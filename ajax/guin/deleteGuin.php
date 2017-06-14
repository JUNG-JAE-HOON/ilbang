<?php
    include_once "../../include/session.php";
    include_once "../../db/connect.php";

    $no = $_POST["no"];

    $sql = "SELECT employ_count FROM company WHERE uid = '$uid'";
    $result = mysql_query($sql);
    $arr = mysql_fetch_array($result);

    $employCount = $arr[0] + 1;

    $sql = "UPDATE work_employ_data SET view = 'no' WHERE no = '$no' ";
    $result = mysql_query($sql, $ilbang_con);

    if(mysql_affected_rows()==1) {
        mysql_query("UPDATE company SET employ_count = $employCount WHERE uid = '$uid'");
        
        $message = "채용 공고가 삭제되었습니다.";
    } else {
        $message = "채용 공고 삭제 실패";
    }

    echo json_encode($message);
?>