<?php
    include_once "../../include/session.php";
    include_once "../../db/connect.php";

    $no = $_POST["no"];

    if($kind == "general") {
        $sql = "SELECT resume_count FROM member_extend WHERE uid = '$uid'";
        $result = mysql_query($sql);
        $arr = mysql_fetch_array($result);

        $resumeCount = $arr[0] + 1;

        mysql_query("UPDATE member_extend SET resume_count = $resumeCount WHERE uid = '$uid'");

        $sql = "UPDATE work_resume_data SET view = 'no' WHERE no = $no AND uid = '$uid'";

        $success = "이력서가 삭제되었습니다.";
        $fail = "이력서 삭제 실패";
    } else {
        $sql = "SELECT employ_count FROM company WHERE uid = '$uid'";
        $result = mysql_query($sql);
        $arr = mysql_fetch_array($result);

        $employCount = $arr[0] + 1;

        mysql_query("UPDATE company SET employ_count = $employCount WHERE uid = '$uid'");

        $sql = "UPDATE work_employ_data SET view = 'no' WHERE no = $no AND uid = '$uid'";
        $result = mysql_query($sql);

        $success = "채용 공고가 삭제되었습니다.";
        $fail = "채용 공고 삭제 실패";
    }

    $result = mysql_query($sql);

    if($result) {
        echo json_encode($success);
    } else {
        echo json_encode($fail);
    }
?>