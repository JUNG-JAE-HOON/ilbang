<?php
    include_once "../../include/session.php";
    include_once "../../db/connect.php";

    $no = $_POST["no"];

    if($kind == "general") {
        $sql = "SELECT open FROM work_resume_data WHERE no = $no";
        $result = mysql_query($sql);
        $arr = mysql_fetch_array($result);

        $open = $arr[0];

        if($open == "yes") {
            mysql_query("UPDATE work_resume_data SET delegate = 0 WHERE uid = '$uid'");

            $sql = "UPDATE work_resume_data SET delegate = 1 WHERE no = $no AND uid = '$uid'";
            $result = mysql_query($sql);

            if($result) {
                $message = "대표 이력서로 설정되었습니다.";
            } else {
                $message = "대표 이력서 설정 실패";
            }
        } else {
            $message = "비공개 이력서는 대표 이력서로 설정할 수 없습니다.";
        }
    } else {
        mysql_query("UPDATE work_employ_data SET delegate = 0 WHERE uid = '$uid'");

        $sql = "UPDATE work_employ_data SET delegate = 1 WHERE no = $no AND uid = '$uid'";
        $result = mysql_query($sql);

        if($result) {
            $message = "대표 채용 공고로 설정되었습니다.";
        } else {
            $message = "대표 채용 공고 설정 실패";
        }
    }

    echo json_encode($message);
?>