<?php
    include_once "../../db/connect.php";

    $code = $_POST["code"];

    $sql = "SELECT COUNT(*) FROM affiliate WHERE admin_cd = '$code'";
    $result = mysql_query($sql);
    $arr = mysql_fetch_array($result);

    echo json_encode($arr[0]);
?>