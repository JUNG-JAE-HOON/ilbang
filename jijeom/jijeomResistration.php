<?php
    include_once "../include/session.php";
    include_once "../db/connect.php";

    $company = $_POST["company"];
    $number = $_POST["number1"]."-".$_POST["number2"]."-".$_POST["number3"];
    $address = $_POST["address1"]." ".$_POST["address2"];
    $ceo = $_POST["ceo"];
    $phone = $_POST["phone1"]."-".$_POST["phone2"]."-".$_POST["phone3"];
    $content = $_POST["content"];
    $types = $_POST["types"];
    $status = $_POST["status"];
    $flotation = $_POST["flotation"];
    $wdate = date("Y-m-d H:i:s");
    $ip = $_SERVER["REMOTE_ADDR"];

    $tmpName = $_FILES["file"]["tmp_name"];
    $fileName = $_FILES["file"]["name"];
    $fileInfo = pathinfo($fileName);
    $ext = strtolower($fileInfo['extension']);
    $saveName = date("YmdHis").$uid.".".$ext;
    $path = "../jijeomFile/".$saveName;

    if($uid != "") {
        $sql = "SELECT COUNT(*) FROM company WHERE number = '$number'";
        $result = mysql_query($sql);
        $arr = mysql_fetch_array($result);

        if($arr[0] == 0) {
            $sql = "SELECT COUNT(*) FROM branch_list WHERE number = '$number'";
            $result = mysql_query($sql);
            $arr = mysql_fetch_array($result);

            if($arr[0] == 0) {
                $sql = "SELECT A.no, A.valid_no, B.img_url FROM member A JOIN member_extend B WHERE A.uid = '$uid' AND A.uid = B.uid";
                $result = mysql_query($sql);
                $arr = mysql_fetch_array($result);

                $memberNo = $arr["no"];
                $validNo = $arr["valid_no"];
                $imgUrl = $arr["img_url"];

                if($kind == "company" || $kind == "jijeom" || $kind == "gameng") {
                    $sql = "SELECT img_url FROM company WHERE uid = '$uid'";
                    $result = mysql_query($sql);
                    $arr = mysql_fetch_array($result);

                    $imgUrl = $arr["img_url"];
                }

                $sql = "INSERT INTO branch_list(uid, ceo, company, number, address, phone, wdate, file) VALUES ('$uid', '$ceo', '$company', '$number', '$address', '$phone', '$wdate', '$saveName')";
                $result = mysql_query($sql);

                if($result) {
                    $sql = "SELECT no FROM branch_list WHERE uid = '$uid' ORDER BY wdate DESC";
                    $result = mysql_query($sql);
                    $arr = mysql_fetch_array($result);

                    $jijeomNo = $arr[0];

                    $sql = "INSERT INTO company_temp(uid, company, ceo, number, content, types, status, flotation, member_no, valid_no, img_url, ip, jijeom_no)
                                 VALUES ('$uid', '$company', '$ceo', '$number', '$content', '$types', '$status', '$flotation', '$memberNo', '$validNo', '$imgUrl', '$ip', '$jijeomNo')";
                    $result = mysql_query($sql);

                    if($result) {
                        move_uploaded_file($tmpName, $path);

                        echo "<script>alert('신청되었습니다.');</script>";
                        echo "<script>document.location.href = 'jijeomResult.php';</script>";
                    } else {
                        echo "<script>alert('신청 실패');</script>";
                        echo "<script>history.back();</script>";
                    }
                } else {
                    echo "<script>alert('신청 실패');</script>";
                    echo "<script>history.back();</script>";
                }
            } else {
                echo "<script>alert('이미 등록된 사업자 번호입니다.');</script>";
                echo "<script>history.back();</script>";
            }
        } else {
            echo "<script>alert('이미 등록된 사업자 번호입니다.');</script>";
            echo "<script>history.back();</script>";
        }
    } else {
        echo "<script>alert('로그인 후 이용해주세요.');</script>";
        echo "<script>history.back();</script>";
    }
?>