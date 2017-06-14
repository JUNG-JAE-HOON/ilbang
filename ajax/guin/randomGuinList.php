<?php
    include_once "../../db/connect.php";

    $date = date("Y-m-d", strtotime(date("Y-m-d ")."-5day"));

    $sql = "SELECT COUNT(*), B.no, B.title FROM pc_special_employ A JOIN work_employ_data B
                 WHERE A.employ_no = B.no AND A.free_end_date > NOW() ORDER BY RAND() LIMIT 1";
    $result = mysql_query($sql);
    $arr = mysql_fetch_array($result);

    if(empty($arr["no"])) {
        $specialGuin["url"] = "javascript:void(0)";
        $specialGuin["title"] = "스페셜 정보가 없습니다.";
        $specialGuin["different"] = "gujik.php?tab=1";
    } else {
        $specialGuin["url"] = "guin/view/tab1.php?employNo=".$arr["no"];
        $specialGuin["title"] = $arr["title"];
        $specialGuin["different"] = "javascript:specialMove()";
    }

    $sql = "SELECT no, title, keyword FROM work_employ_data WHERE wdate > '$date' ORDER BY RAND() LIMIT 1";
    $result = mysql_query($sql);
    $arr = mysql_fetch_array($result);

    $randomGuin["no"] = $arr["no"];
    $randomGuin["title"] = $arr["title"];
    $keyword = explode(",", $arr["keyword"]);
    $randomGuin["work"] = $keyword[4];

    echo json_encode(array('specialGuin' => $specialGuin, 'randomGuin' => $randomGuin));
?>