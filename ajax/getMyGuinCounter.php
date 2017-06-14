<?php
    include_once "../db/connect.php";  

    $uid = $_POST['uid'];
    //$uid = 'p20513';
    // 등록된 신청서 수
    $sql = "SELECT count(*) as insertCnt FROM work_employ_data WHERE view = 'yes' AND uid = '$uid'";
    $result = mysql_query($sql, $ilbang_con);

    $listData =array();
    while($row = mysql_fetch_array($result)) {
        $oneData ["insertCnt"]  = $row["insertCnt"];
    }    

    // 등록할 수 잇는 횟수


    // 나의 평가
    $sql = "SELECT count(*) as myReviewCnt FROM employ_review WHERE euid = '$uid'"; 
    $result = mysql_query($sql, $ilbang_con);

    
    while($row = mysql_fetch_array($result)) {
        $oneData ["myReviewCnt"]  = $row["myReviewCnt"];
    }


  // 현재 매칭건 수
    $sql  = " SELECT count(*) matchingCnt ";
    $sql .= " FROM work_join_list ";
    $sql .= " WHERE 1=1 ";
    $sql .= " AND work_employ_data_no IN (SELECT no FROM work_employ_data WHERE uid = '$uid' AND view='yes')   ";
    $result = mysql_query($sql, $ilbang_con);
    
    while($row = mysql_fetch_array($result)) {
        $oneData["matchingCnt"] = $row["matchingCnt"];
    }


    $listData[] = $oneData;

    echo json_encode(array('listData' => $listData));
?>