<?php
    header("Cache-Control: no-cache, must-revalidate");
    session_start();
    include_once "../db/connect.php";

    $uid = $_POST["user_id"];
    $passwd = $_POST["user_passwd"];
    $loginType = $_POST["loginType"];
    $url = "http://".$_POST["url"];
    $loginDate = date("Y-m-d H:i:s");

    $sql = "SELECT no, name, passwd, kind, COUNT(*) AS cnt FROM member WHERE uid = '$uid' and kind = '$loginType'";
    $result = mysql_query($sql);
    $arr = mysql_fetch_array($result);

    $memberNo = $arr["no"];
    $name = $arr["name"];
    $passwdCheck = $arr["passwd"];
    $kind = $arr["kind"];

    if($arr["cnt"] != 0) {
        $sql = "SELECT COUNT(*) FROM out_member WHERE uid = '$uid'";
        $result = mysql_query($sql);
        $arr = mysql_fetch_array($result);

        if($arr[0] == 0) {
            if(check_password($passwd, $passwdCheck) == false) {
                echo "<script>alert('아이디 또는 비밀번호가 맞지 않습니다.');</script>";
                echo "<script>history.back();</script>";
            } else {
                $_SESSION["id"] = $uid;
                $_SESSION["name"] = $name;
                $_SESSION["kind"] = $kind;
                $_SESSION["memberNo"] = $memberNo;

                mysql_query("UPDATE member_extend SET login_count = login_count + 1, login_time = '$loginDate' WHERE uid = '$uid'");
            }
        } else {
            echo "<script>alert('탈퇴한 회원입니다.');</script>";
            echo "<script>history.back();</script>";
        }
    } else {
        if($loginType == "general") {
            echo "<script>alert('일반 회원이 아닙니다.');</script>";
        } else if($loginType == "company") {
            echo "<script>alert('기업 회원이 아닙니다.');</script>";
        } else if($loginType == "jijeom") {
            echo "<script>alert('지점 회원이 아닙니다.');</script>";
        }

        echo "<script>history.back();</script>";
    }
?>
<meta http-equiv="refresh" content='0; url="<?php echo $url; ?>"'>