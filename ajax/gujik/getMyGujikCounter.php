<?php
    include_once "../../db/connect.php";  

    $uid = $_POST['uid'];
    // 등록된 신청서 수
    $sql = "SELECT count(*) as insertCnt FROM work_resume_data WHERE view = 'yes' AND uid = '$uid'";
    $result = mysql_query($sql, $ilbang_con);

    $listData =array();
    while($row = mysql_fetch_array($result)) {
        $oneData ["insertCnt"]  = $row["insertCnt"];
    }    

    // 등록할 수 잇는 횟수
    $sql = "SELECT resume_count FROM member_extend where uid = '$uid'";
    $result = mysql_query($sql);

    while($row = mysql_fetch_array($result)) {
        $oneData ["enableCnt"]  = $row["resume_count"];
    }    


    // 나의 평가
    $sql = "SELECT count(*) as myReviewCnt FROM resume_review WHERE ruid = '$uid'";  //euid (기업)이 평가남김 
    $result = mysql_query($sql, $ilbang_con);

    
    while($row = mysql_fetch_array($result)) {
        $oneData ["myReviewCnt"]  = $row["myReviewCnt"];
    }


    // 현재 매칭건 수
    $sql  = " SELECT count(*) matchingCnt ";
    $sql .= " FROM work_join_list ";
    $sql .= " WHERE 1=1 ";
    $sql .= " AND work_resume_data_no IN (SELECT no FROM work_resume_data WHERE uid = '$uid' AND view='yes') ";
    
    while($row = mysql_fetch_array($result)) {
        $oneData["matchingCnt"] = $row["matchingCnt"];
    }


    $listData[] = $oneData;

    echo json_encode(array('listData' => $listData));
?>