<?php
    include_once "../../include/session.php";
    include_once "../../db/connect.php";

    if(isset($_POST["uid"])) {
        $uid = $_POST["uid"];

        $sql = "SELECT kind FROM member WHERE uid = '$uid'";
        $result = mysql_query($sql);
        $arr = mysql_fetch_array($result);

        $kind = $arr["kind"];
    }

    if($uid == "") {
        $message = "로그인 후 이용해주세요.";
    } else {
        if($kind == "general") {
            $sql = "SELECT A.valid, B.birthday, B.email, B.sex, B.phone FROM member A JOIN member_extend B WHERE A.uid = B.uid AND  A.uid = '$uid'";
            $result = mysql_query($sql);
            $arr = mysql_fetch_array($result);
        } else {
            $sql = "SELECT A.valid, B.birthday, B.email, B.sex, B.phone, C.company, C.number, C.content, C.types, C.status, C.flotation
                         FROM member A JOIN member_extend B JOIN company C
                         WHERE A.uid = B.uid AND A.uid = C.uid AND A.uid = '$uid'";
            $result = mysql_query($sql);
            $arr = mysql_fetch_array($result);

            $memberInfo["company"] = $arr["company"];
            $memberInfo["number"] = $arr["number"];
            $memberInfo["content"] = $arr["content"];
            $memberInfo["types"] = $arr["types"];
            $memberInfo["status"] = $arr["status"];
            $memberInfo["flotation"] = $arr["flotation"];
        }

        $memberInfo["valid"] = $arr["valid"];
        $memberInfo["birth"] = date("Y년 m월 d일", strtotime($arr["birthday"]));

        $email = explode("@", $arr["email"]);
        $memberInfo["email1"] = $email[0];
        $memberInfo["email2"] = $email[1];

        if($arr["sex"] == "female") {
            $memberInfo["sex"] = "여자";
        } else {
            $memberInfo["sex"] = "남자";
        }

        $phone = explode("-", $arr["phone"]);
        $memberInfo["phone1"] = $phone[0];
        $memberInfo["phone2"] = $phone[1];
        $memberInfo["phone3"] = $phone[2];

        $sql = "SELECT point FROM ad_money WHERE uid = '$uid'";
        $result = mysql_query($sql);
        $arr = mysql_fetch_array($result);

        $memberInfo["point"] = number_format($arr[0]);

        if($kind == "general") {
            $sql = "SELECT COUNT(*) FROM work_resume_data WHERE uid = '$uid' AND view = 'yes'";
            $result = mysql_query($sql);
            $arr = mysql_fetch_array($result);

            $memberInfo["resume"] = $arr[0];
        } else {
            $sql = "SELECT COUNT(*) FROM work_employ_data WHERE uid = '$uid' AND view = 'yes'";
            $result = mysql_query($sql);
            $arr = mysql_fetch_array($result);

            $memberInfo["employ"] = $arr[0];
        }

        if($kind == "general") {
            $sql = "SELECT COUNT(*) FROM work_join_list WHERE ruid = '$uid' AND choice = 'yes'";
        } else {
            $sql = "SELECT COUNT(*) FROM work_join_list WHERE euid = '$uid' AND choice = 'yes'";
        }

        $result = mysql_query($sql);
        $arr = mysql_fetch_array($result);

        $memberInfo["matching"] = $arr[0];
    }

    echo json_encode(array('memberInfo' => $memberInfo, 'message' => $message));
?>