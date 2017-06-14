<?php
    include_once "../../include/session.php";
    include_once "../../db/connect.php";

    if(isset($_POST['page'])) {
        $page = $_POST['page'];
    } else {
        $page = 1;
    }

    if($kind == "general") {
        $search = "kind IN('$kind', 'common')";
    } else {
        $search = "kind IN('company', 'common')";
    }

    $sql = "SELECT COUNT(*) FROM item_data WHERE charge_type = 'P' AND $search";
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);

    $allPost = $row[0];
    $onePage = 5; // 한 페이지에 보여줄 게시글의 수.
    $allPage = ceil($allPost / $onePage); //전체 페이지의 수

    $oneSection = 5; //한번에 보여줄 총 페이지 개수(1 ~ 10, 11 ~ 20 ...)
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

    //아이템 리스트 가져오기
    $sql = "SELECT id, kind, item_name, item_type, item_kind FROM item_data WHERE charge_type = 'P' AND $search $sqlLimit";
    $result = mysql_query($sql);

    while($arr = mysql_fetch_array($result)) {
        $itemType = $arr["item_type"];
        $itemKind = $arr["item_kind"];

        if($arr["kind"] == "company") {
            $section = "구인자용";
        } else if($arr["kind"] == "general") {
            $section = "구직자용";
        } else {
            $section = "공용";
        }

        $itemData["kind"] = $section;
        $itemData["name"] = $arr["item_name"];

        $sql2 = "SELECT COUNT(*) AS dataCheck, IFNULL(SUM(count), 'not') AS cnt, start_date, end_date
                       FROM work_item WHERE uid = '$uid' AND item_kind = '$itemKind'";
        $result2 = mysql_query($sql2);
        $arr2 = mysql_fetch_array($result2);

        if($arr2["dataCheck"] == 0) {
            if($itemType == "term") {
                $itemData["remain"] = "-";
            } else {
                $itemData["remain"] = '<div class="fc">0회</div>';
            }
        } else {
            if($arr2["cnt"] == "not") {
                $itemData["remain"] = date("Y-m-d", strtotime($arr2["start_date"]))." ~ ".date("Y-m-d", strtotime($arr2["end_date"]));
            } else {
                $itemData["remain"] = '<div class="fc">'.$arr2["cnt"].'회</div>';
            }
        }

        $itemList[] = $itemData;
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

    echo json_encode(array('itemList' => $itemList, 'paging' => $paging));
?>