<?php
    header("Cache-Control: no-cache, must-revalidate");
    include_once "../include/session.php";
    include_once "../db/connect.php";

    if($uid == "") {
        echo "<script>alert('로그인 후 이용해주세요.');</script>";
    } else {
        $title = $_POST["title"];    
        $adName = $_POST["adName"];
        $phone = $_POST["phone1"]."-".$_POST["phone2"]."-".$_POST["phone3"];
        $email = $_POST["email1"]."@".$_POST["email2"];
        $company = $_POST["company"];
        $content = $_POST["content"];   
        $wdate = date("Y-m-d H:i:s");

        $sql = "INSERT INTO ad_partnership(uid, name, company, title, content, phone, email, wdate)
                     VALUES ('$uid', '$adName', '$company', '$title', '$content', '$phone', '$email', '$wdate')";
        $result = mysql_query($sql);

        if($result) {
            echo "<script>alert('업무 제휴가 신청되었습니다.');</script>";
        } else {
            echo "<script>alert('업무 제휴 신청 실패');</script>";
        }
    }

    echo "<script>document.location.href = 'cooperation.php';</script>";
?>