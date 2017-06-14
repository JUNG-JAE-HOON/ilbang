<?php
    include_once "../../db/connect.php";

    
    $rno                   = $_POST['rno'];
    $eno                   = $_POST['eno'];
    $work_date              = $_POST['work_date']; 
   
    for ($i=0; $i<count($work_date); $i++) {
        $sql  = " DELETE FROM work_join_list                ";
        $sql .= " WHERE 1=1                                 ";
        $sql .= " AND work_resume_data_no = '$rno'          ";
        $sql .= " AND work_employ_data_no = '$eno'          ";
        $sql .= " AND work_date           = '$work_date[$i]'    ";


        $result = mysql_query($sql, $ilbang_con);
    }

    echo json_encode(array('result' => "1" ,'msg'=>'구인 신청 취소 되었습니다.'));
?>