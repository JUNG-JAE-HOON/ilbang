<?php
    include_once "db/connect.php";

    $ip = $_SERVER["REMOTE_ADDR"];
    $wdate = date("Y-m-d H:i:s");

    $sql = "INSERT INTO pc_execute_log(uid, wdate, ip) VALUES ('$uid', '$wdate', '$ip')";
    $result = mysql_query($sql);
?>