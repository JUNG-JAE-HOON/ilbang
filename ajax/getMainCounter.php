<?php
    include_once "../db/connect.php";

    // 일방 실시간 현황
    // 구인 완료 수
    // 구직 완료 수
    $sql = "SELECT count(*) as compleCnt FROM work_join_list WHERE choice = 'yes'";
    $result = mysql_query($sql, $ilbang_con);

    $listData =array();
    while($row = mysql_fetch_array($result)) {
        $oneData ["guinComple"]  = $row["compleCnt"];
        $oneData ["gujikComple"] = $row["compleCnt"]; 
    }

    //구직자
    $sql = "SELECT COUNT(*) FROM work_resume_data WHERE view = 'yes'";
    $result = mysql_query($sql);
    $arr = mysql_fetch_array($result);

    $oneData["resumeCnt"] = $arr[0];

    //채용 공고
    $sql = "SELECT SUM(people_num) FROM work_employ_data WHERE view = 'yes'";
    $result = mysql_query($sql);
    $arr = mysql_fetch_array($result);

    $oneData["employCnt"] = $arr[0] + 3073;

    //전체 매칭
    $sql = "SELECT COUNT(*) FROM work_join_list";
    $result = mysql_query($sql);
    $arr = mysql_fetch_array($result);

    $oneData["totalMatching"] = $arr[0] + 843;

   // 신규 채용 수
   //$sql = "SELECT count(*) as newEmploy FROM work_employ_data WHERE wdate > (SELECT CURDATE())";
   // $sql = "SELECT count(*) as newEmploy FROM work_employ_data WHERE month(wdate) = month(now())";
   $sql = "SELECT count(*) as newEmploy FROM work_employ_data WHERE wdate between date_format(now(), '%Y-%m-01') and LAST_DAY(now())" ; 
   $result = mysql_query($sql, $ilbang_con);
   while($row = mysql_fetch_array($result)) {
        $oneData["newEmploy"] = $row["newEmploy"];
    }

    // 현재 구인중 수
    //$sql = "SELECT count(*) as guinIng FROM work_employ_data  WHERE no IN (SELECT work_employ_data_no FROM employ_date WHERE date > (SELECT CURDATE()) GROUP BY work_employ_data_no )";
    $sql = "SELECT count(*) as guinIng FROM work_employ_data WHERE view='yes'";
    $result = mysql_query($sql, $ilbang_con);

    while($row = mysql_fetch_array($result)) {
        $oneData["guinIng"]   = $row["guinIng"];
    }
    
    // 현재 구직 중 수
    //$sql = "SELECT count(*) as gujikIng FROM work_resume_data  WHERE no IN (SELECT work_resume_data_no FROM resume_date WHERE date > (SELECT CURDATE()) GROUP BY work_resume_data_no )" ;
    $sql = "SELECT count(*) as gujikIng FROM work_resume_data  WHERE view='yes'" ;
    $result = mysql_query($sql, $ilbang_con);

    while($row = mysql_fetch_array($result)) {
        $oneData["gujikIng"]   = $row["gujikIng"];
    }

    $listData[] = $oneData;

    echo json_encode(array('listData' => $listData));
?>