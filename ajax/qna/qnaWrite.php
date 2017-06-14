<?php
    include_once "../../include/session.php";
    include_once "../../db/connect.php";

    $val = $_POST["val"];
    $no = $_POST["no"];
    $qContent = $_POST["qContent"];
    $wdate = date("Y-m-d H:i:s");

    if($uid == "") {
        $message = "로그인 후 이용해주세요.";
    } else {
        //---------------------------------------------------------------------
        //                           val = 0 (질문 등록)
        //                           val = 1 (질문 수정)
        //---------------------------------------------------------------------
        if($val == 0) {
            $sql = "INSERT INTO qna_board(uid, name, content, wdate) VALUES ('$uid', '$name', '$qContent', '$wdate')";
            $result = mysql_query($sql);

            if($result) {
                $message = "질문이 등록되었습니다.";
                $check = 1;
            } else {
                $message = "질문 등록 실패";
            }
        } else if($val == 1) {
            $sql = "SELECT comment FROM qna_board WHERE no = $no AND uid = '$uid' AND view = 1";
            $result = mysql_query($sql);
            $arr = mysql_fetch_array($result);

            $Aview = $arr[0];

            if($Aview == 0) {
                $sql = "UPDATE qna_board SET content = '$qContent', mdate = '$wdate' WHERE no = $no AND uid = '$uid'";
                $result = mysql_query($sql);

                if($result) {
                    $message = "질문이 수정되었습니다.";
                    $check = 1;
                } else {
                    $message = "질문 수정 실패";
                }
            } else {
                $message = "답변 완료된 글은 수정할 수 없습니다.";
            }
        } else {
            $message = "관리자에게 문의 바랍니다.";
        }
    }

    echo json_encode(array('message' => $message, 'check' => $check));
?>