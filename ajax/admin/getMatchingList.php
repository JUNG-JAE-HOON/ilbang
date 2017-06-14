<?php
    include_once "../../db/connect.php";

    $uid = $_POST["id"];
    $page = $_POST["page"];
    $type = $_POST["type"];

    if($type == "general") {
        $search = "ruid = '".$uid."'";
    } else {
        $search = "euid = '".$uid."'";
    }

    $sql = "SELECT COUNT(*) FROM work_join_list WHERE $search AND choice = 'yes'";
    $result = mysql_query($sql);
    $arr = mysql_fetch_array($result);

    $allPost = $arr[0];

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
    $sqlLimit = ' limit ' . $currentLimit . ', ' . $onePage;

    $sql = "SELECT no, resume_review, employ_review, work_employ_data_no FROM work_join_list
                 WHERE $search AND choice = 'yes' ORDER BY wdate DESC $sqlLimit";
    $result = mysql_query($sql);

    while($arr = mysql_fetch_array($result)) {
        $employNo = $arr[3];
        $matchingData["no"] = $arr[0];
        $matchingData["review"] = $arr[1];
        $matchingData["employNo"] = $arr[3];

        $sql2 = "SELECT title, business, career, pay, sex, time, keyword FROM work_employ_data WHERE no = $employNo";
        $result2 = mysql_query($sql2);
        $arr2 = mysql_fetch_array($result2);

        $matchingData["title"] = $arr2["title"];
        $matchingData["business"] = $arr2["business"];
        $matchingData["pay"] = number_format($arr2["pay"]);

        if($arr2["career"] == -1) {
            $matchingData["career"] = "무관";
        } else if($arr2["career"] == 0) {
            $matchingData["career"] = "신입";
        } else if($arr2["career"] == 1) {
            $matchingData["career"] = "1년 미만";
        } else if($arr2["career"] == 3) {
            $matchingData["career"] = "3년 미만";
        } else if($arr2["career"] == 5) {
            $matchingData["career"] = "5년 미만";
        } else {
            $matchingData["career"] = "5년 이상";
        }

        if($arr2["sex"] == "nothing") {
            $matchingData["sex"] = "무관";
        } else if($arr2["sex"] == "man") {
            $matchingData["sex"] = "남자";
        } else {
            $matchingData["sex"] = "여자";
        }

        if($arr2["time"] == 1) {
            $matchingData["time"] = "오전";
        } else if($arr2["time"] == 2) {
            $matchingData["time"] = "오후";
        } else if($arr2["time"] == 3) {
            $matchingData["time"] = "저녁";
        } else if($arr2["time"] == 4) {
            $matchingData["time"] = "새벽";
        } else if($arr2["time"] == 5) {
            $matchingData["time"] = "오전 ~ 오후";
        } else if($arr2["time"] == 6) {
            $matchingData["time"] = "오후 ~ 저녁";
        } else if($arr2["time"] == 7) {
            $matchingData["time"] = "저녁 ~ 새벽";
        } else if($arr2["time"] == 8) {
            $matchingData["time"] = "새벽 ~ 오전";
        } else if($arr2["time"] == 9) {
            $matchingData["time"] = "풀타임";
        } else {
            $matchingData["time"] = "협의";
        }

        $keyword = explode(",", $arr2["keyword"]);
        $matchingData["area"] = $keyword[0]." ".$keyword[1];
        $matchingData["work"] = $keyword[4];

        $matchingList[] = $matchingData;
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

    echo json_encode(array('matchingList' => $matchingList, 'paging' => $paging));
?>