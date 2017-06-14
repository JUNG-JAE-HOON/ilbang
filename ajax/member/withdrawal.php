<?php
    include_once "../../include/session.php";
    include_once "../../db/connect.php";

    $withReason = $_POST["withSel"];
    $withId = $_POST["withId"];
    $withPwd = get_encrypt_string($_POST["withPwd"]);

    if($uid == $withId) {
        $sql = "SELECT * FROM member A JOIN member_extend B WHERE A.uid = B.uid AND A.uid = '$uid'";
        $result = mysql_query($sql);
        $arr = mysql_fetch_array($result);

        $pwd = $arr["passwd"];

        if($pwd == $withPwd) {
            $valid = $arr["valid"];
            $wdate = $arr["wdate"];
            $outDate = date("Y-m-d H:i:s");
            $memberNo = $arr["no"];
            $validNo = $arr["valid_no"];

            $sql = "INSERT INTO out_member(name, kind, passwd, valid, wdate, out_date, member_no, valid_no, uid, secession_reason)
                         VALUES ('$name', '$kind', '$pwd', '$valid', '$wdate', '$outDate', '$memberNo', '$validNo', '$uid', '$withReason')";
            $result = mysql_query($sql);

            $birth = $arr["birthday"];
            $age = $arr["age"];
            $sex = $arr["sex"];
            $email = $arr["email"];
            $phone = $arr["phone"];
            $obstacle = $arr["obstacle"];
            $loginCount = $arr["login_count"];
            $loginTime = $arr["login_time"];
            $ip = $arr["ip"];

            $sql = "INSERT INTO out_member_extend(birthday, age, sex, email, phone, obstacle, login_count, login_time, ip, member_no, valid_no, uid)
                         VALUES ('$birth', '$age', '$sex', '$email', '$phone', '$obstacle', '$loginCount', '$loginTime', '$ip', '$memberNo', '$validNo', '$uid')";
            $result = mysql_query($sql);

            if($kind == "company" || $kind == "jijeom") {
                $sql = "SELECT * FROM company WHERE uid = '$uid'";
                $result = mysql_query($sql);
                $arr = mysql_fetch_array($result);

                $company = $arr["company"];
                $ceo = $arr["ceo"];
                $number = $arr["number"];
                $content = $arr["content"];
                $types = $arr["types"];
                $status = $arr["status"];
                $flotation = $arr["flotation"];

                $sql = "INSERT INTO out_company(company,ceo, number, content, types, status, flotation, company_member_no, valid_no, uid)
                             VALUES ('$company', '$ceo', '$number', '$content', '$types', '$status', '$flotation', '$memberNo', '$validNo', '$uid')";
                $result = mysql_query($sql);
            }

            if($result) {
                session_destroy();

                mysql_query("DELETE FROM member WHERE uid = '$uid'");
                mysql_query("DELETE FROM member_extend WHERE uid = '$uid'");

                if($kind == "company" || $kind == "jijeom") {
                    mysql_query("DELETE FROM company WHERE uid = '$uid'");
                }

                mysql_close();

                $dest_host = '182.162.141.20';
                $dest_user = 'root';
                $dest_password = 'Tlqkfdudrhkd!!';
                $dest_db = 'ilbangshop';

                $ilbang_con= mysql_connect($dest_host, $dest_user, $dest_password);
                $ilbang_db = mysql_select_db($dest_db, $ilbang_con);

                mysql_query("DELETE FROM g5_member WHERE mb_id = '$uid'");
                mysql_close();

                $message = "탈퇴 되었습니다.";
                $check = 1;
            } else {
                $message = "탈퇴 실패";
            }
        } else {
            $message = "비밀번호가 맞지 않습니다.";
        }
    } else {
        $message = "아이디가 맞지 않습니다.";
    }

    echo json_encode(array('message' => $message, 'check' => $check));
?>