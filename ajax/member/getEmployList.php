<?php
    include_once "../../include/session.php";
    include_once "../../db/connect.php";

    if(isset($_POST['page'])) {
        $page = $_POST['page'];
    } else {
        $page = 1;
    }

    if(isset($_POST["uid"])) {
        $uid = $_POST["uid"];
    }

    $sql = "SELECT COUNT(*) FROM work_employ_data WHERE uid = '$uid' AND view = 'yes'";
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
    $sqlLimit = ' limit ' . $currentLimit . ', ' . $onePage;

    $sql = "SELECT no, company, business, title, content, sex, pay, career, time, wdate, delegate, keyword FROM work_employ_data
                 WHERE uid = '$uid' AND view = 'yes' ORDER BY delegate DESC, wdate DESC $sqlLimit";
    $result = mysql_query($sql);

    while($arr = mysql_fetch_array($result)) {
        $employNo = $arr["no"];

        $sql2 = "SELECT COUNT(*) FROM work_join_list WHERE work_employ_data_no = $employNo AND choice = 'yes'";
        $result2 = mysql_query($sql2);
        $arr2 = mysql_fetch_array($result2);

        $employData["no"] = $employNo;
        $employData["company"] = $arr["company"];
        $employData["content"] = $arr["content"];
        $employData["business"] = $arr["business"];
        $employData["title"] = $arr["title"];
        $keyword = explode(",", $arr["keyword"]);
        $employData["area1"] = $keyword[0];
        $employData["area2"] = $keyword[1];
        $employData["work2"] = $keyword[4];
        $employData["pay"] = number_format($arr["pay"]);
        $employData["wdate"] = date("Y.m.d H:i", strtotime($arr["wdate"]));
        $employData["matching"] = $arr2[0];

        if($arr["sex"] == "nothing") {
            $employData["sex"] = "무관";
        } else if($arr["sex"] == "woman") {
            $employData["sex"] = "여자";
        } else {
            $employData["sex"] = "남자";
        }

        if($arr["career"] == -1) {
            $employData["career"] = "무관";
        } else if($arr["career"] == 0) {
            $employData["career"] = "신입";
        } else if($arr["career"] == 1) {
            $employData["career"] = "1년 미만";
        } else if($arr["career"] == 3) {
            $employData["career"] = "3년 미만";
        } else if($arr["career"] == 5) {
            $employData["career"] = "5년 미만";
        } else {
            $employData["career"] = "5년 이상";
        }

        if($arr["time"] == 1) {
            $employData["time"] = "오전";
        } else if($arr["time"] == 2) {
            $employData["time"] = "오후";
        } else if($arr["time"] == 3) {
            $employData["time"] = "저녁";
        } else if($arr["time"] == 4) {
            $employData["time"] = "새벽";
        } else if($arr["time"] == 5) {
            $employData["time"] = "오전 ~ 오후";
        } else if($arr["time"] == 6) {
            $employData["time"] = "오후 ~ 저녁";
        } else if($arr["time"] == 7) {
            $employData["time"] = "저녁 ~ 새벽";
        } else if($arr["time"] == 8) {
            $employData["time"] = "새벽 ~ 오전";
        } else if($arr["time"] == 9) {
            $employData["time"] = "풀타임";
        } else {
            $employData["time"] = "협의";
        }

        if($arr["delegate"] == 0) {
            $employData["delegate"] = "";
        } else {
            $employData["delegate"] = "대표 채용 공고";
        }

        $employList[] = $employData;
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

    echo json_encode(array('employList' => $employList, 'paging' => $paging));
?>