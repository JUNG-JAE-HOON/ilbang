<?php
    include_once "../include/session.php";
    include_once "../db/connect.php";

    $phone = $_POST["phone1"]."-".$_POST["phone2"]."-".$_POST["phone3"];
    $email = $_POST["email1"]."@".$_POST["email2"];

    if($_POST["pwd"] != "") {
        $passwd = get_encrypt_string($_POST["pwd"]);

        $sql = "UPDATE member A INNER JOIN member_extend B ON A.uid = B.uid
                     SET A.passwd = '$passwd', B.phone = '$phone', B.email = '$email' WHERE A.uid = '$uid'";
    } else {
        $sql = "UPDATE member_extend SET phone = '$phone', email = '$email' WHERE uid = '$uid'";
    }

    $result = mysql_query($sql);

    $modifyUrl = "myInfo-general.php";

    if($kind != "general") {
        $types = $_POST["types"];
        $status = $_POST["status"];

        $sql = "UPDATE company SET types = '$types', status = '$status' WHERE uid = '$uid'";
        $result = mysql_query($sql);

        $modifyUrl = "myInfo-comp.php";
    }

    if($result) {
        echo "<script>alert('정보가 수정되었습니다.');</script>";
        echo "<script>document.location.href = '".$modifyUrl."';</script>";
    } else {
        echo "<script>alert('정보 수정 실패');</script>";
        echo "<script>history.back();</script>";
    }
?>