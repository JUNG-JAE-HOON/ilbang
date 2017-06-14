<?php
    include_once "../../db/connect.php";

    $uid = $_POST["id"];
    $pwd = get_encrypt_string($_POST["pwd"]);

    $sql = "UPDATE member SET passwd = '$pwd' WHERE uid = '$uid'";
    $result = mysql_query($sql);

    if($result) {
        $message = "비밀번호가 변경되었습니다.";
        $check = 1;
    } else {
        $message = "비밀번호 변경 실패";
    }

    echo json_encode(array('message' => $message, 'check' => $check));
?>