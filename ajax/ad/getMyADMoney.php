<?php
    include_once "../../include/session.php";
    include_once "../../db/connect.php";

    $sql = "SELECT point FROM ad_money WHERE uid = '$uid'";
    $result = mysql_query($sql);
    $arr = mysql_fetch_array($result);

    $myAD["point"] = number_format($arr["point"]);

    echo json_encode(array('myAD' => $myAD));
?>