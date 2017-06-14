<?php
    include_once "../../include/session.php";
    include_once "../../db/connect.php";

    if(isset($_POST['page'])) {
        $page = $_POST['page'];
    } else {
        $page = 1;
    }

    $sql = "SELECT COUNT(*) FROM ad_money_log WHERE uid = '$uid' AND type NOT IN(2)";
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);

    $allPost = $row[0];

    $onePage = 3; // 한 페이지에 보여줄 게시글의 수.
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

    $adReserveList = array();
    $i = 0;    

    $sql = "SELECT point FROM ad_money WHERE uid = '$uid'";
    $result = mysql_query($sql);
    $arr = mysql_fetch_array($result);

    $myPoint = number_format($arr["point"]);

    $sql = "SELECT A.type, A.point, A.total_point, A.wdate, B.title  FROM ad_money_log A JOIN ad B
                 WHERE A.ad_no = B.no AND A.uid = '$uid' AND A.type NOT IN(2) ORDER BY A.wdate DESC $sqlLimit";
    $result = mysql_query($sql);
    $length = mysql_num_rows($result);

    while($arr = mysql_fetch_array($result)) {
        $reserveData["day"] = date("Y-m-d", strtotime($arr["wdate"]));
        $reserveData["time"] = date("H:i:s", strtotime($arr["wdate"]));

        if($arr["type"] == 0) {
            $reserveData["content"] = '[영상 광고] '.$arr["title"];
        } else if($arr["type"] == 1) {
            $reserveData["content"] = '[배너 광고] '.$arr["title"];
        }

        $reserveData["point"] = number_format($arr["point"]);
        $reserveData["total"] = number_format($arr["total_point"]);

        $adReserveList[$i++] = $reserveData;
    }

    $sql = "SELECT SUM(point) FROM ad_money_log WHERE uid = '$uid' AND type NOT IN(2)";
    $result = mysql_query($sql);
    $arr = mysql_fetch_array($result);

    $reservedPoint = number_format($arr[0]);

    $paging["page"] = $page;
    $paging["currentSection"] = $currentSection;
    $paging["allSection"] = $allSection;
    $paging["allPage"] = $allPage;
    $paging["prevPage"] = $prevPage;
    $paging["nextPage"] = $nextPage;
    $paging["lastPage"] = $lastPage;
    $paging["firstPage"] = $firstPage;
    $paging["allPost"] = $allPost;

    echo json_encode(array('adReserveList' => $adReserveList, 'paging' => $paging, 'length' => $length, 'myPoint' => $myPoint, 'reservedPoint' => $reservedPoint));
?>