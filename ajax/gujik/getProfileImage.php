<?php

    include_once "../../include/session.php";
    include_once "../../db/connect.php";

    $data=array();

    $sql="SELECT * from member_extend where uid='$uid'";
    $result=mysql_query($sql);
    $row=mysql_fetch_array($result);
    $data["img_url"]=$row["img_url"];

    echo json_encode(array('logoData' => $data));
?>