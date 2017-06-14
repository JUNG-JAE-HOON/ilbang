<?php
    include_once "../db/connect.php";

    // get work_1st
    $sql  = "SELECT no as work_1st, list_name as work_1st_nm FROM category WHERE type='work_type' AND parent_no = '0'";

    $result = mysql_query($sql, $ilbang_con);
    while($row = mysql_fetch_array($result)) {
        $oneData ["work_1st"]    = $row["work_1st"];
        $oneData ["work_1st_nm"] = $row["work_1st_nm"];

        $listData[] = $oneData;

    }  

    echo json_encode(array('listData' => $listData));
?>