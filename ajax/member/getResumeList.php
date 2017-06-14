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
        $search = "";
    } else {
        $search = "AND view = 'yes'";
    }

    $sql = "SELECT COUNT(*) FROM work_resume_data WHERE uid = '$uid' $search";
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

    $sql = "SELECT no, title, area_1st, area_2nd, work_2nd, pay, career, time, wdate, open, delegate, keyword FROM work_resume_data
                 WHERE uid = '$uid' $search ORDER BY delegate DESC, wdate DESC $sqlLimit";
    $result = mysql_query($sql);

    while($arr = mysql_fetch_array($result)) {
        $area1 = $arr["area_1st"];
        $area2 = $arr["area_2nd"];
        $work2 = $arr["work_2nd"];
        $resumeNo = $arr["no"];

        $sql2 = "SELECT COUNT(*) FROM work_join_list WHERE work_resume_data_no = $resumeNo AND choice = 'yes'";
        $result2 = mysql_query($sql2);
        $arr2 = mysql_fetch_array($result2);

        $resumeData["no"] = $resumeNo;
        $resumeData["title"] = $arr["title"];
        $resumeData["matching"] = $arr2[0];

        if(empty($arr["keyword"])) {
            $sql2 = "SELECT list_name FROM category WHERE no = $area1";
            $result2 = mysql_query($sql2);
            $arr2 = mysql_fetch_array($result2);

            $resumeData["area1"] = $arr2[0];

            if($area2 == 0) {
                $resumeData["area2"] = "전체";
            } else {
                $sql2 = "SELECT list_name FROM category WHERE no = $area2";
                $result2 = mysql_query($sql2);
                $arr2 = mysql_fetch_array($result2);

                $resumeData["area2"] = $arr2[0];
            }

            $sql2 = "SELECT list_name FROM category WHERE no = $work2";
            $result2 = mysql_query($sql2);
            $arr2 = mysql_fetch_array($result2);

            $resumeData["work2"] = $arr2[0];
        } else {
            $keyword = explode(",", $arr["keyword"]);
            $resumeData["area1"] = $keyword[0];
            $resumeData["area2"] = $keyword[1];
            $resumeData["work2"] = $keyword[4];
        }

        $resumeData["pay"] = number_format($arr["pay"]);
        $resumeData["wdate"] = date("Y.m.d", strtotime($arr["wdate"]));

        if($arr["career"] == 0) {
            $resumeData["career"] = "신입";
        } else if($arr["career"] == 1) {
            $resumeData["career"] = "1년 미만";
        } else if($arr["career"] == 3) {
            $resumeData["career"] = "3년 미만";
        } else if($arr["career"] == 5) {
            $resumeData["career"] = "5년 미만";
        } else {
            $resumeData["career"] = "5년 이상";
        }

        if($arr["time"] == 1) {
            $resumeData["time"] = "오전";
        } else if($arr["time"] == 2) {
            $resumeData["time"] = "오후";
        } else if($arr["time"] == 3) {
            $resumeData["time"] = "저녁";
        } else if($arr["time"] == 4) {
            $resumeData["time"] = "새벽";
        } else if($arr["time"] == 5) {
            $resumeData["time"] = "오전 ~ 오후";
        } else if($arr["time"] == 6) {
            $resumeData["time"] = "오후 ~ 저녁";
        } else if($arr["time"] == 7) {
            $resumeData["time"] = "저녁 ~ 새벽";
        } else if($arr["time"] == 8) {
            $resumeData["time"] = "새벽 ~ 오전";
        } else if($arr["time"] == 9) {
            $resumeData["time"] = "풀타임";
        } else {
            $resumeData["time"] = "협의";
        }

        if($arr["delegate"] == 0) {
            $resumeData["delegate"] = "";
        } else {
            $resumeData["delegate"] = "대표 이력서";
        }

        if($arr["open"] == "yes") {
            $resumeData["open"] = "공개";
        } else {
            $resumeData["open"] = "비공개";
        }

        $resumeList[] = $resumeData;
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

    echo json_encode(array('resumeList' => $resumeList, 'paging' => $paging));
?>