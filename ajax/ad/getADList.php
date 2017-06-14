<?php
    include_once "../../include/session.php";
    include_once "../../db/connect.php";

    if(isset($_POST['page'])) {
        $page = $_POST['page'];
    } else {
        $page = 1;
    }

    $type = $_POST["type"];

    $sql = "SELECT ad_no FROM ad_money_log WHERE uid = '$uid' AND type IN($type) GROUP BY ad_no";
    $result = mysql_query($sql);
    $num = mysql_num_rows($result);

    while($arr = mysql_fetch_array($result)) {
        $adLog .= $arr[0].",";
    }

    $adLog = substr($adLog, 0, -1);

    if($num == 0) {
        $sql = "SELECT COUNT(*) FROM ad WHERE type IN($type) AND view = 'yes'";
    } else {
        $sql = "SELECT COUNT(*) FROM ad WHERE no NOT IN($adLog) AND type IN($type) AND view = 'yes'"; 
    }

    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);

    $allPost = $row[0];

    if($type == 0) {
        $onePage = 12; // 한 페이지에 보여줄 게시글의 수.
    } else {
        $onePage = 9;
    }
    
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

    if($num == 0) {
        $sql = "SELECT * FROM ad WHERE type IN($type) AND view = 'yes' ORDER BY no DESC $sqlLimit";
    } else {
        $sql = "SELECT * FROM ad WHERE no NOT IN($adLog) AND type IN($type) AND view = 'yes' ORDER BY no DESC $sqlLimit";
    }

    $result = mysql_query($sql);

    while($arr = mysql_fetch_array($result)) {
        $adData["no"] = $arr["no"];
        $adData["title"] = $arr["title"];        
        $adData["point"] = $arr["add_point"];        

        if($type == 0) {
            $adData["content"] = $arr["content"];
            $adLink = explode('/', $arr["ad_link"]);
            $adData["thum"] = "http://img.youtube.com/vi/".$adLink[4]."/mqdefault.jpg";
        } else {
            $adCon = explode('<br>', $arr["content"]);
            $adData["content"] = $adCon[0];
            $adData["thum"] = "../../mobile/ad/img/".$arr["ad_link"];
        }

        $adList[] = $adData;
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

    echo json_encode(array('adList' => $adList, 'paging' => $paging));
?>