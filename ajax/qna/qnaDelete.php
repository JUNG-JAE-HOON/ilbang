<?php
    include_once "../../include/session.php";
    include_once "../../db/connect.php";

    $no = $_POST["no"];

    if($uid == "") {
        $message = "로그인 후 이용해주세요.";
    } else {
        $sql = "SELECT comment FROM qna_board WHERE no = $no AND uid = '$uid' AND view = 1";
        $result = mysql_query($sql);
        $arr = mysql_fetch_array($result);

        $Aview = $arr[0];

        if($Aview == 0) {
            $sql = "UPDATE qna_board SET view = 0 WHERE no = $no AND uid = '$uid'";
            $result = mysql_query($sql);

            if($result) {
                $message = "삭제 되었습니다.";
                $check = 1;
            } else {
                $message = "삭제 실패";
            }
        } else {
            $message = "답변 완료된 글은 삭제할 수 없습니다.";
        }
    }

    echo json_encode(array('message' => $message, 'check' => $check));
?>