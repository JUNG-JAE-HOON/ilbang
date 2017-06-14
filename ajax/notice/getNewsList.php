<?php
    include_once "../../db/mmcpConnect.php";

    if(isset($_POST['page'])) {
        $page = $_POST['page'];
    } else {
        $page = 1;
    }

    $sql = "SELECT COUNT(*) FROM g5_write_notice1";
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);

    $allPost = $row[0];    

    $onePage = 10; // 한 페이지에 보여줄 게시글의 수.
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
    $no = ($onePage * ($page - 1)) + 1;     //페이지 글 번호

    $newsList = array();
    $i = 0;

    $sql = "SELECT wr_id, wr_subject, wr_hit, wr_datetime FROM g5_write_notice1 ORDER BY wr_datetime DESC $sqlLimit";
    $result = mysql_query($sql);
    $length = mysql_num_rows($result);

    while($arr = mysql_fetch_array($result)) {
        $newsData["no"] = $no++;
        $newsData["newsNo"] = $arr["wr_id"];
        $newsData["title"] = $arr["wr_subject"];
        $newsData["hit"] = $arr["wr_hit"];
        $newsData["date"] = date("Y.m.d", strtotime($arr["wr_datetime"]));

        $newsList[$i++] = $newsData;
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

    echo json_encode(array('newsList' => $newsList, 'paging' => $paging, 'length' => $length));
?>