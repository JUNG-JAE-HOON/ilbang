<?php
    include_once "../db/connect.php";

    $uid = $_POST["id"];

    $sql = "SELECT COUNT(*) FROM out_member WHERE uid = '$uid'";
    $result = mysql_query($sql);
    $arr = mysql_fetch_array($result);

    $outMember = $arr[0];

    if($outMember == 0) {
        $sql = "SELECT COUNT(*) FROM member WHERE uid = '$uid'";
        $result = mysql_query($sql);
        $arr = mysql_fetch_array($result);

        $member = $arr[0];

        if($member == 0) {
            $message = "사용 가능한 아이디입니다.";
        } else {
            $message = "이미 존재하는 아이디입니다.";
        }
    } else {
        $message = "이미 존재하는 아이디입니다.";
    }

    echo json_encode(array('check' => $member, 'message' => $message));
?>