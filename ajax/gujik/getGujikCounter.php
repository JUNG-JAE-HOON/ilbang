<?php
    include_once "../../db/connect.php";


    // 신규 신청서
    $sql = "SELECT count(*) as newEmploy FROM work_resume_data WHERE wdate between date_format(now(), '%Y-%m-01') and LAST_DAY(now())" ; 
    $result = mysql_query($sql, $ilbang_con);
    while($row = mysql_fetch_array($result)) {
        $oneData["newEmploy"] = $row["newEmploy"];
    }


    // 등록할 수 잇는 횟수
    $sql = "SELECT resume_count FROM member_extend where uid = '$uid'";
    $result = mysql_query($sql);

    while($row = mysql_fetch_array($result)) {
        $oneData ["enableCnt"]  = $row["resume_count"];
    }    

    // 전체 신청서
    $sql = "SELECT count(*) as allEmploy FROM work_resume_data WHERE view = 'yes'" ;
    $result = mysql_query($sql, $ilbang_con);
    while($row = mysql_fetch_array($result)) {
        $oneData["allEmploy"] = $row["allEmploy"];
    }

    // 신규매칭
    $sql = "SELECT count(*) as newMatching FROM work_join_list WHERE 1=1 AND wdate between date_format(now(), '%Y-%m-01') and LAST_DAY(now()); ";
    $result = mysql_query($sql, $ilbang_con);

    $listData =array();
    while($row = mysql_fetch_array($result)) {
        $oneData ["newMatching"]  = $row["newMatching"]; 
    }    

    $sql = "SELECT count(*) as allMatching FROM work_join_list ; ";
    $result = mysql_query($sql, $ilbang_con);

    while($row = mysql_fetch_array($result)) {
        $oneData["allMatching"]   = $row["allMatching"];
    }
    
    $listData[] = $oneData;

    echo json_encode(array('listData' => $listData));
?>