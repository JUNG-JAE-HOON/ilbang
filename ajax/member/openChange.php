<?php
    include_once "../../include/session.php";
    include_once "../../db/connect.php";

    $val = $_POST["val"];
    $no = $_POST["no"];

    $sql = "SELECT delegate FROM work_resume_data WHERE uid = '$uid' AND no = $no";
    $result = mysql_query($sql);
    $arr = mysql_fetch_array($result);

    $delegate = $arr[0];

    if($delegate == 1) {
        $message = "대표 이력서는 비공개로 변경할 수 없습니다.";
    } else {
        if($val == 0) {
            $sql = "UPDATE work_resume_data SET open = 'no' WHERE uid = '$uid' AND no = $no";

            $success = "이력서가 비공개로 변경되었습니다.";
        } else {
            $sql = "UPDATE work_resume_data SET open = 'yes' WHERE uid = '$uid' AND no = $no";

            $success = "이력서가 공개로 변경되었습니다.";
        }

        $result = mysql_query($sql);

        if($result) {
            $message = $success;
        } else {
            $message = "이력서 공개 설정 실패";
        }
    }

    echo json_encode($message);
?>