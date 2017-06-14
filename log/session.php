<?php
    session_start();

    if(isset($_SESSION["id"]) || isset($_SESSION["name"]) || isset($_SESSION["kind"]) || isset($_SESSION["memberNo"])) {
        $uid = $_SESSION["id"];
        $name = $_SESSION["name"];
        $kind = $_SESSION["kind"];
        $memberNo = $_SESSION["memberNo"];
    } else {
        $uid = "";
        $name = "";
        $kind = "";
        $memberNo = "";
    }

    $url = $_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];

?>