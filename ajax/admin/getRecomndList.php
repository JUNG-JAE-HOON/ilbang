<?php
    include_once "../../include/session.php";
    include_once "../../db/connect.php";

    if(isset($_POST["page"])) {
        $page = $_POST["page"];
    } else {
        $page = 1;
    }

    $sql = "SELECT COUNT(*) FROM member WHERE reuid = '$uid' AND kind = 'general'";
    $result = mysql_query($sql);
    $arr = mysql_fetch_array($result);

    $allPost = $arr[0];
    $onePage = 9;
    $allPage = ceil($allPost / $onePage);
    $oneSection = 4;
    $currentSection = ceil($page / $oneSection);
    $allSection = ceil($allPage / $oneSection);
    $firstPage = ($currentSection * $oneSection) - ($oneSection - 1);

    if($allPage == 0) {
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
    $sqlLimit = ' LIMIT '.$currentLimit.', '.$onePage;
    $no = ($onePage * ($page - 1)) + 1;     //페이지 글 번호

    $sql = "SELECT A.no AS memberNo, A.uid, A.name, B.phone, B.login_count, A.wdate,
                 (SELECT COUNT(*) FROM work_resume_data C WHERE 1 = 1 AND C.member_no = A.no AND C.view = 'yes') AS resumeCnt,
                 (SELECT COUNT(*) FROM work_join_list D WHERE 1 = 1 AND A.uid = D.ruid AND D.choice = 'yes') AS matchingFinishCnt
                 FROM member A JOIN member_extend B
                 WHERE 1 = 1 AND A.reuid = '$uid' AND A.kind = 'general' AND A.no = B.member_no ORDER BY A.wdate DESC $sqlLimit";
    $result = mysql_query($sql);

    while($arr = mysql_fetch_array($result)) {
        $recomndData["no"] = $no++;
        $recomndData["uid"] = $arr["uid"];
        $recomndData["name"] = $arr["name"];
        $recomndData["phone"] = $arr["phone"];
        $recomndData["visit"] = $arr["login_count"];
        $recomndData["resumeCnt"] = $arr["resumeCnt"];
        $recomndData["matchingFinishCnt"] = $arr["matchingFinishCnt"];
        $recomndData["date"] = $arr["wdate"];

        $recomndList[] = $recomndData;
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

    echo json_encode(array('recomndList' => $recomndList, 'paging' => $paging));
?>