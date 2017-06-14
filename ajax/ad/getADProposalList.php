<?php
    include_once "../../include/session.php";
    include_once "../../db/connect.php";

    if(isset($_POST['page'])) {
        $page = $_POST['page'];
    } else {
        $page = 1;
    }

    $sql = "SELECT COUNT(*) FROM ad WHERE admin_uid = '$uid'";
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);

    $allPost = $row[0];

    $onePage = 10; // 한 페이지에 보여줄 게시글의 수.
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

    $sql = "SELECT no, wdate, type, title, count FROM ad WHERE admin_uid = '$uid' ORDER BY wdate DESC $sqlLimit";
    $result = mysql_query($sql);

    while($arr = mysql_fetch_array($result)) {
        $proposalData["no"] = $arr["no"];
        $proposalData["day"] = date("Y-m-d", strtotime($arr["wdate"]));
        $proposalData["time"] = date("H:i:s", strtotime($arr["wdate"]));
        $proposalData["type"] = $arr["type"];

        if($arr["type"] == 0) {
            $proposalData["typeTitle"] = "AD 동영상";
        } else if($arr["type"] == 1) {
            $proposalData["typeTitle"] = "AD 배너";
        }

        $proposalData["title"] = $arr["title"];
        $proposalData["expose"] = number_format($arr["count"]);

        $adProposalList[] = $proposalData;
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

    echo json_encode(array('adProposalList' => $adProposalList, 'paging' => $paging));
?>