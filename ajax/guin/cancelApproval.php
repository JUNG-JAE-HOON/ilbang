
<?php
    include_once "../../db/connect.php";

    $work_join_list_no_arr      = $_POST['work_join_list_no_arr'];

    //$work_join_list_no_arr = array('0','1','2');
    
    $work_join_list_no_str = implode($work_join_list_no_arr,",");
    $sql  = "     UPDATE work_join_list SET choice ='no' ";
    $sql .= " WHERE no IN ('$work_join_list_no_str')     ";

    $result = mysql_query($sql);

    echo json_encode(array('result' => '1','msg' => '승인 취소 되었습니다.'));



?>