<?php
    include_once "../../db/connect.php";

    $no = $_POST["no"];
    $page = $_POST["page"];

    $no=868;
    $page=1;

    $sql = "SELECT COUNT(*) FROM employ_review WHERE work_join_list_no = $no";
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

    $sql = "SELECT A.score, A.content, A.euid, A.ruid, A.wdate, C.name, D.birthday, D.sex, B.img_url
                 FROM employ_review A JOIN company B JOIN member C JOIN member_extend D
                 WHERE A.work_join_list_no = $no AND A.euid = B.uid AND A.euid = C.uid AND A.euid = D.uid
                 ORDER BY A.wdate DESC $sqlLimit";
    $result = mysql_query($sql);

    while($arr = mysql_fetch_array($result)) {
        $euid = $arr["euid"];
        $ruid = $arr["ruid"];

        $reviewData["ruid"] = $ruid;
        $reviewData["name"] = $arr["name"];

        if($arr["sex"] == "female") {
            $reviewData["sex"] = "여자";
        } else if($arr["sex"] == "male") {
            $reviewData["sex"] = "남자";
        } else {
            $reviewData["sex"] = "알 수 없음";
        }

        if($arr["birthday"] == null || $arr["birthday"] == "") {
            $reviewData["age"] = "알 수 없음";
        } else {
            $year = explode("-", $arr["birthday"]);
            $reviewData["age"] = ((date("Y") - $year[0]) + 1)."세";
        }

        if($arr["img_url"] == null) {
            $reviewData["imgUrl"] = "../images/144x38.png";
        } else {
            $reviewData["imgUrl"] = "../guinImage/".$arr["img_url"];
        }

        $reviewData["score"] = $arr["score"];
        $reviewData["content"] = nl2br($arr["content"]);
        $reviewData["date"] = date("Y.m.d", strtotime($arr["wdate"]));

        $sql2 = "SELECT img_url FROM member_extend WHERE uid = '$ruid'";
        $result2 = mysql_query($sql2);
        $arr2 = mysql_fetch_array($result2);

        if($arr2["img_url"] == null) {
            $reviewData["reviewImg"] = "../images/review01.png";
        } else {
            $reviewData["reviewImg"] = "../guinImage/".$arr2[0];
        }

        $sql2 = "SELECT AVG(score) FROM employ_review WHERE euid = '$euid'";
        $result2 = mysql_query($sql2);
        $arr2 = mysql_fetch_array($result2);

        $reviewData["avg"] = round($arr2[0], 1);

        $reviewList[] = $reviewData;
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

    echo json_encode(array('reviewList' => $reviewList, 'paging' => $paging));
?>