<?php
    session_start();

    $uid = $_POST["user_id"];
    $passwd = $_POST["user_pwd"];
    $url = "http://".$_POST["url"];

    include_once "../db/connect.php";

    $sql = "SELECT A.no, A.name, A.kind, A.passwd, B.login_count
                 FROM member A JOIN member_extend B WHERE A.uid = '$uid' AND A.uid = B.uid";
    $result = mysql_query($sql);
    $arr = mysql_fetch_array($result);

    $memberNo = $arr["no"];
    $name = $arr["name"];
    $kind = $arr["kind"];
    $passwdCheck = $arr["passwd"];
    $visit = $arr["login_count"] + 1;
    $loginDate = date("Y-m-d H:i:s");

    $sql = "SELECT COUNT(*) FROM out_member WHERE uid = '$uid'";
    $result = mysql_query($sql);
    $arr = mysql_fetch_array($result);

    $secession = $arr[0];

    if($secession == 0) {
        if(check_password($passwd, $passwdCheck) == false) {
            $val = 0;
            $message = "아이디 또는 비밀번호가 맞지 않습니다.";
        } else {
            $val = 1;

            $_SESSION["id"] = $uid;
            $_SESSION["name"] = $name;
            $_SESSION["kind"] = $kind;
            $_SESSION["memberNo"] = $memberNo;

            mysql_query("UPDATE member_extend SET login_count = $visit, login_time = '$loginDate' WHERE uid = '$uid'");
        }
    } else {
        $val = 0;
        $message = "탈퇴한 회원입니다.";
    }

    $login["val"] = $val;
    $login["message"] = $message;
    $login["url"] = $url;

    echo json_encode(array('login' => $login));
?>