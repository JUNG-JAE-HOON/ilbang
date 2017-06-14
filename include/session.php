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

    $admin = "ilbangManager";       //qna 관리자 댓글 쓸 수 있는 어드민 아이디
    $url = $_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
?>