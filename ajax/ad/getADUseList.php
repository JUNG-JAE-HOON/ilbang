<?php
    include_once "../../include/session.php";
    include_once "../../db/connect.php";

    if(isset($_POST['page'])) {
        $page = $_POST['page'];
    } else {
        $page = 1;
    }

    $sql = "SELECT COUNT(*) FROM ad_money_log WHERE uid = '$uid' AND type IN(3)";
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);

    $allPost = $row[0];

    $onePage = 3; // 한 페이지에 보여줄 게시글의 수.
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
    $sqlLimit = ' limit ' . $currentLimit . ', ' . $onePage;

    mysql_close();

    $dest_host = '182.162.141.20';
    $dest_user = 'root';
    $dest_password = 'Tlqkfdudrhkd!!';
    $dest_db = 'ilbangshop';

    $ilbang_con= mysql_connect($dest_host, $dest_user, $dest_password);
    $ilbang_db = mysql_select_db($dest_db, $ilbang_con);

    $sql = "SELECT B.it_name FROM g5_shop_order A JOIN g5_shop_cart B
                 WHERE A.mb_id = '$uid' AND A.od_id = B.od_id ORDER BY B.ct_time DESC $sqlLimit";
    $result = mysql_query($sql);

    while($arr = mysql_fetch_array($result)) {
        $useListArr .= $arr[0].", ";
    }

    $useListArr = substr(trim($useListArr), 0, -1);
    $useList = explode(",", $useListArr);

    mysql_close();

    $dest_host = '182.162.104.152';
    $dest_user = 'root';
    $dest_password = 'ghldfudrhkd!!';
    $dest_db = 'ilbang';
    // ilbang DB 접속

    $ilbang_con= mysql_connect($dest_host, $dest_user, $dest_password);
    $ilbang_db = mysql_select_db($dest_db, $ilbang_con);

    $sql = "SELECT point, total_point, wdate FROM ad_money_log WHERE uid = '$uid' AND type IN(3) ORDER BY wdate DESC $sqlLimit";
    $result = mysql_query($sql);
    $length = mysql_num_rows($result);

    $i = 0;

    while($arr = mysql_fetch_array($result)) {
        $useData["day"] = date("Y-m-d", strtotime($arr["wdate"]));
        $useData["time"] = date("H:i:s", strtotime($arr["wdate"]));
        // $useData["content"] = "포인트몰 상품 구입";
        $useData["content"] = $useList[$i++];
        $useData["point"] = number_format($arr["point"]);
        $useData["total"] = number_format($arr["total_point"]);

        $adUseList[] = $useData;
    }

    $sql = "SELECT SUM(point) FROM ad_money_log WHERE uid = '$uid' AND type IN(3)";
    $result = mysql_query($sql);
    $arr = mysql_fetch_array($result);

    $usedPoint = number_format($arr[0]);

    $paging["page"] = $page;
    $paging["currentSection"] = $currentSection;
    $paging["allSection"] = $allSection;
    $paging["allPage"] = $allPage;
    $paging["prevPage"] = $prevPage;
    $paging["nextPage"] = $nextPage;
    $paging["lastPage"] = $lastPage;
    $paging["firstPage"] = $firstPage;
    $paging["allPost"] = $allPost;

    echo json_encode(array('adUseList' => $adUseList, 'paging' => $paging, 'length' => $length, 'usedPoint' => $usedPoint));
?>