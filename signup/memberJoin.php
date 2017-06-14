<?php
    header("Cache-Control: no-cache, must-revalidate");
    session_start();
    include_once "../db/connect.php";

    $kind = $_POST["kind"];
    $uid = trim($_POST["id"]);
    $passwd = get_encrypt_string($_POST["pwd"]);
    $name = trim($_POST["name"]);
    $phone = trim($_POST["phone1"])."-".trim($_POST["phone2"])."-".trim($_POST["phone3"]);
    $number = $_POST["number1"]."-".$_POST["number2"]."-".$_POST["number3"];
    $wdate = date("Y-m-d H:i:s");
    $ip = $_SERVER["REMOTE_ADDR"];

    if(isset($_POST["reuid"])) {
        $reuid = $_POST["reuid"];
    } else {
        $reuid = "";
    }

    $sql = "SELECT COUNT(*) FROM out_member WHERE uid = '$uid'";
    $result = mysql_query($sql);
    $arr = mysql_fetch_array($result);

    $outMember =$arr[0];

    if($outMember == 0) {
        $sql = "SELECT COUNT(*) FROM member WHERE uid = '$uid'";
        $result = mysql_query($sql);
        $arr = mysql_fetch_array($result);

        $member = $arr[0];

        if($member == 0) {
            if($kind != "general") {
                $sql = "SELECT COUNT(*) FROM company WHERE number = '$number'";
                $result = mysql_query($sql);
                $arr = mysql_fetch_array($result);

                $numberCheck = $arr[0];
            }

            if($numberCheck == 0 || $kind == "general") {
                $sql = "INSERT INTO member(uid, name, kind, passwd, valid, wdate, valid_no, reuid)
                             VALUES ('$uid', '$name', '$kind', '$passwd', 'no', '$wdate', 0, '$reuid')";
                $result = mysql_query($sql);

                if($result) {
                    $sql = "SELECT no FROM member WHERE uid = '$uid'";
                    $result = mysql_query($sql);
                    $arr = mysql_fetch_array($result);

                    $memberNo = $arr[0];

                    $birth = $_POST["year"]."-".$_POST["month"]."-".$_POST["day"];
                    $sex = $_POST["sex"];
                    $email = trim($_POST["email1"])."@".trim($_POST["email2"]);
                    $obstacle = $_POST["obstacle"];
                    $age = (date("Y") - $_POST["year"]) + 1;

                    $sql = "INSERT INTO member_extend(birthday, age, sex, email, phone, obstacle, login_count, login_time, ip, member_no, valid_no, uid)
                                 VALUES ('$birth', '$age', '$sex', '$email', '$phone', '$obstacle', 1, '$wdate', '$ip', $memberNo, 0, '$uid')";
                    $result = mysql_query($sql);

                    if($kind == "company") {
                        $company = trim($_POST["company"]);
                        $ceo = trim($_POST["ceo"]);
                        $types = $_POST["types"];
                        $status = $_POST["status"];
                        $content = $_POST["content"];
                        $flotation = $_POST["flotation"];

                        $sql = "INSERT INTO company(company, ceo, number, content, types, status, flotation, member_no, valid_no, uid, ip)
                                     VALUES ('$company', '$ceo', '$number', '$content', '$types', '$status', '$flotation', $memberNo, 0, '$uid', '$ip')";
                        $result = mysql_query($sql);
                    }

                    if($result) {
                        mysql_query("INSERT INTO ad_money(point, member_no, valid_no, uid) VALUES(0, $memberNo, 0, '$uid')");

                        $register = "http://www.mmcpshop.co.kr/ilbang/bbs/register_get.php?id=".$uid."&pw=".$_POST['pwd']."&name=".$name."&email=".$email."&addr1=".$_POST['address1']."&addr2=".$_POST['address2']."&mobile=".$phone;
                        file_get_contents($register);

                        $_SESSION["wdate"] = $wdate;
                        
                        echo "<script>alert('회원으로 가입되었습니다.');</script>";
                        echo "<script>document.location.href = 'step4.php?id=".$uid."';</script>";
                    } else {
                        echo "<script>alert('회원가입 실패');</script>";
                        echo "<script>history.back();</script>";
                    }
                } else {
                    echo "<script>alert('회원가입 실패.');</script>";
                    echo "<script>history.back();</script>";
                }
            } else {
                echo "<script>alert('이미 사용중인 사업자 번호입니다.');</script>";
                echo "<script>history.back();</script>";
            }
        } else {
            echo "<script>alert('이미 존재하는 아이디입니다.');</script>";
            echo "<script>history.back();</script>";
        }
    } else {
        echo "<script>alert('이미 존재하는 아이디입니다.');</script>";
        echo "<script>history.back();</script>";
    }
?>