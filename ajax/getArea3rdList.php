<?php
    include_once "../db/connect.php";

    // get work_1st
    $area_2nd = $_POST["area_2nd"];


    if ($area_2nd == "" ){
        echo json_encode(array('msg' => 'area_2nd 를 입력하세요.'));
        return;
    }

    
    $sql  = "SELECT no as area_3rd, list_name as area_3rd_nm FROM category WHERE type='area_type' AND parent_no = '$area_2nd'";

    
    $result = mysql_query($sql, $ilbang_con);
    $listData = array();
    while($row = mysql_fetch_array($result)) {
        $oneData ["area_3rd"]    = $row["area_3rd"];
        $oneData ["area_3rd_nm"] = $row["area_3rd_nm"];

        $listData[] = $oneData;

    }  

    echo json_encode(array('listData' => $listData));
?>