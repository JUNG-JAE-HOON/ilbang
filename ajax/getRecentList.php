<?php
    include_once "../include/session.php";
    include_once "../db/connect.php";

    if(isset($_POST["page"])) {
        $page = $_POST["page"];
    } else {
        $page = 1;
    }

    if($kind == "general") {
        $title = "최근에 본 채용 공고";
        $search = "recent_employ";
    } else {
        $title = "최근에 본 이력서";
        $search = "recent_resume";
    }

    $sql = "SELECT COUNT(*) FROM $search WHERE uid = '$uid'";
    $result = mysql_query($sql);
    $arr = mysql_fetch_array($result);

    $allPost = $arr[0];
    $onePage = 5;
    $allPage = ceil($allPost / $onePage);
    $oneSection = 2;
    $currentSection = ceil($page / $oneSection);
    $allSection = ceil($allPage / $oneSection);
    $firstPage = ($currentSection * $oneSection) - ($oneSection - 1);

    if ($allPost == 0){
        $lastPage = 1;
        $currentSection = 1;
        $allSection = 1;
    } else if($currentSection == $allSection) {
        $lastPage = $allPage;
    } else {
        $lastPage = $currentSection * $oneSection;
    }

    $prevPage = (($currentSection - 1) * $oneSection);
    $nextPage = (($currentSection + 1) * $oneSection) - ($oneSection - 1);
    $currentLimit = ($onePage * $page) - $onePage;
    $sqlLimit = ' LIMIT ' . $currentLimit . ', ' . $onePage;

    $sql = "SELECT * FROM $search WHERE uid = '$uid' ORDER BY wdate DESC $sqlLimit";
    $result = mysql_query($sql);

    while($arr = mysql_fetch_array($result)) {
        $recentData["title"] = $arr["title"];

        if($kind == "general") {
            $recentData["no"] = $arr["employ_no"];
            $recentData["url"] = "gujik/view/tab1.php?employNo=".$arr["employ_no"];
        } else {
            $recentData["no"] = $arr["reumse_no"];
            $recentData["url"] = "guin/view/guinTab1.php?resumeNo=".$arr["resume_no"];
        }

        $recentList[] = $recentData;
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

    echo json_encode(array('recentList' => $recentList, 'title' => $title, 'paging' => $paging));
?>