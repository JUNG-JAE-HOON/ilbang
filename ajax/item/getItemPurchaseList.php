<?php
    include_once "../../include/session.php";
    include_once "../../db/connect.php";

    if(isset($_POST['page'])) {
        $page = $_POST['page'];
    } else {
        $page = 1;
    }

    $sql = "SELECT
                 (SELECT COUNT(*) FROM inis_result_data WHERE uid = '$uid') +
                 (SELECT COUNT(*) FROM in_app_purchase_data WHERE member_id = '$uid')";
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);

    $allPost = $row[0];
    $onePage = 5; // 한 페이지에 보여줄 게시글의 수.
    $allPage = ceil($allPost / $onePage); //전체 페이지의 수
    $oneSection = 4; //한번에 보여줄 총 페이지 개수(1 ~ 10, 11 ~ 20 ...)
    $currentSection = ceil($page / $oneSection); //현재 섹션
    $allSection = ceil($allPage / $oneSection); //전체 섹션의 수
    $firstPage = ($currentSection * $oneSection) - ($oneSection - 1); //현재 섹션의 처음 페이지

    if ($allPost == 0){
        $lastPage = 1;
        $currentSection = 1;
        $allSection = 1;    
    } else if($currentSection == $allSection) {
        $lastPage = $allPage; //현재 섹션이 마지막 섹션이라면 $allPage가 마지막 페이지가 된다.
    } else {
        $lastPage = $currentSection * $oneSection; //현재 섹션의 마지막 페이지
    }

    $prevPage = (($currentSection - 1) * $oneSection); //이전 페이지, 11~20일 때 이전을 누르면 10 페이지로 이동.
    $nextPage = (($currentSection + 1) * $oneSection) - ($oneSection - 1); //다음 페이지, 11~20일 때 다음을 누르면 21 페이지로 이동.
    $currentLimit = ($onePage * $page) - $onePage; //몇 번째의 글부터 가져오는지
    $sqlLimit = ' LIMIT '.$currentLimit .', '.$onePage;

    $sql = "SELECT good_name, amount, pay_method, total_price, CONCAT(appl_date, ' ', apple_time) AS purchaseDate
                 FROM inis_result_data WHERE uid = '$uid'
                 UNION ALL
                 SELECT A.item_name, 1, '휴대폰 결제', B.item_price, A.server_date
                 FROM in_app_purchase_data A JOIN item_data B WHERE A.member_id = '$uid' AND A.item_type = B.item_id
                 ORDER BY purchaseDate DESC $sqlLimit";
    $result = mysql_query($sql);

    while($arr = mysql_fetch_array($result)) {
        $itemData["date"] = date("Y-m-d", strtotime($arr["purchaseDate"]));
        $itemData["name"] = $arr["good_name"];
        $itemData["amount"] = number_format($arr["amount"]);
        $itemData["price"] = number_format($arr["total_price"]);
        $itemData["method"] = $arr["pay_method"];

        if(empty($arr["amount"])) {
            $itemData["amount"] = 1;
        }

        $itemPurchaseList[] = $itemData;
    }

    $paging["page"] = $page;
    $paging["currentSection"] = $currentSection;
    $paging["allSection"] = $allSection;
    $paging["allPage"] = $allPage;
    $paging["prevPage"] = $prevPage;
    $paging["nextPage"] = $nextPage;
    $paging["lastPage"] = $lastPage;
    $paging["firstPage"] = $firstPage;
    $paging["allPost"] = $allPost;

    echo json_encode(array('itemPurchaseList' => $itemPurchaseList, 'paging' => $paging));
?>