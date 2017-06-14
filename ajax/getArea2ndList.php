<?php
    include_once "../db/connect.php";

    // get work_1st
    $area_1st = $_POST["area_1st"];


    if ($area_1st == "" ){
        echo json_encode(array('msg' => 'area_1st 를 입력하세요.'));
        return;
    }

    
    $sql  = "SELECT no as area_2nd, list_name as area_2nd_nm FROM category WHERE type='area_type' AND parent_no = '$area_1st'";

    $result = mysql_query($sql, $ilbang_con);
    $listData = array();
    while($row = mysql_fetch_array($result)) {
        $oneData ["area_2nd"]    = $row["area_2nd"];
        $oneData ["area_2nd_nm"] = $row["area_2nd_nm"];

        $listData[] = $oneData;

    }  

    echo json_encode(array('listData' => $listData));
?>