<?php
    include_once "../db/connect.php";

    $work_1st = $_POST["work_1st"];

    if ($work_1st == "" ){
        $listData = array();
        echo json_encode(array('listData' => $listData, 'msg' => 'work_1st 값이 없습니다.'));
        return ;
    }

    // get work_1st
    $sql  = "SELECT no as work_2nd, list_name as work_2nd_nm FROM category WHERE type='work_type' AND parent_no = '$work_1st'";

    $result = mysql_query($sql, $ilbang_con);
    while($row = mysql_fetch_array($result)) {
        $oneData ["work_2nd"]    = $row["work_2nd"];
        $oneData ["work_2nd_nm"] = $row["work_2nd_nm"];

        $listData[] = $oneData;

    }  

    echo json_encode(array('listData' => $listData));
?>