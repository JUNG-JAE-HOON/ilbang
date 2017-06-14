<?php
    include_once "../../db/connect.php";

    $number = $_POST["number"];

    $sql = "SELECT IF(COUNT(*) != 0, '1', '0') AS duplication FROM company WHERE number = '$number'";
    $result = mysql_query($sql);
    $arr = mysql_fetch_array($result);

    if($arr["duplication"] == 0) {
        $sql = "SELECT IF(COUNT(*) != 0, '1', '0') AS duplication FROM branch_list WHERE number = '$number'";
        $result = mysql_query($sql);
        $arr = mysql_fetch_array($result);
    }

    echo json_encode($arr["duplication"]);
?>