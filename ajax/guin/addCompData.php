<?php
    include_once "../../include/session.php";
    include_once "../../db/connect.php";

    $company = $_POST["company"];
    $ceo = $_POST["ceo"];
    $number = $_POST["number"];
    $types = $_POST["types"];
    $status = $_POST["status"];
    $content = $_POST["content"];
    $flotation = $_POST["flotation"];
    $ip = $_SERVER["REMOTE_ADDR"];
    $date = date("Y-m-d H:i:s");

    $sql = "SELECT COUNT(*) FROM company WHERE number = '$number'";
    $result = mysql_query($sql);
    $arr = mysql_fetch_array($result);

    if($arr[0] == 0) {
        $sql = "SELECT no, valid_no FROM member WHERE uid = '$uid'";
        $result = mysql_query($sql);
        $arr = mysql_fetch_array($result);

        $memberNo = $arr[0];
        $validNo = $arr[1];

        $sql = "INSERT INTO company(company, ceo, number, content, types, status, flotation, member_no, valid_no, uid, employ_count, ip, member_change, change_date)
                     VALUES ('$company', '$ceo', '$number', '$content', '$types', '$status', '$flotation', '$memberNo', '$validNo', '$uid', 3, '$ip', 'yes', '$date')";
        $result = mysql_query($sql);

        if($result) {
            mysql_query("UPDATE member SET kind = 'company' WHERE uid = '$uid'");

            $kind = "company";      //세션에 등록된 kind값 company로 변경
            $check = 1;
            $message = "정보가 추가 되었습니다.";
            $url = 'http://il-bang.com/pc_renewal/guin/form/form.php';
        } else {
            $message = "정보 추가 실패";
        }
    } else {
        $message = "이미 사용중인 사업자 번호입니다.";
    }

    echo json_encode(array('message' => $message, 'url' => $url, 'check' => $check));
?>