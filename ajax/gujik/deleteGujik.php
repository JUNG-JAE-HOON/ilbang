<?php
    include_once "../../include/session.php";
    include_once "../../db/connect.php";

    $no = $_POST["no"];

    $sql = "SELECT resume_count FROM member_extend WHERE uid = '$uid'";
    $result = mysql_query($sql);
    $arr = mysql_fetch_array($result);

    $resumeCount = $arr[0] + 1;

    $sql = "UPDATE work_resume_data SET view = 'no' WHERE no = $no AND uid = '$uid'";
    $result = mysql_query($sql);

    if($result) {
        mysql_query("UPDATE member_extend SET resume_count = $resumeCount WHERE uid = '$uid'");
        
        $message = "이력서가 삭제되었습니다.";
    } else {
        $message = "이력서 삭제 실패";
    }

    echo json_encode($message);
?>