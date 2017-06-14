<?php
    include_once "../../include/session.php";
    include_once "../../db/connect.php";

    $val = $_POST["val"];
    $no = $_POST["no"];
    $aContent = $_POST["aContent"];
    $wdate = date("Y-m-d H:i:s");

    if($uid == $admin) {
        if($val != 2) {
            $sql = "UPDATE qna_board SET admin_content = '$aContent', admin_wdate = '$wdate', comment = 1 WHERE no = $no";
        } else {
            $sql = "UPDATE qna_board SET admin_content = '', comment = 0 WHERE no = $no";
        }

        $result = mysql_query($sql);

        if($result) {
            if($val == 0) {
                $message = "답변을 달았습니다.";
            } else if($val == 1) {
                $message = "답변을 수정했습니다.";
            } else {
                $message = "답변을 삭제했습니다.";
            }
        } else {
            if($val == 0) {
                $message = "답변 달기 실패";
            } else if($val == 1) {
                $message = "답변 수정 실패";
            } else {
                $message = "답변 삭제 실패";
            }
        }
    } else {
        $message = "관리자만 답변을 쓸 수 있습니다.";
    }

    echo json_encode($message);
?>