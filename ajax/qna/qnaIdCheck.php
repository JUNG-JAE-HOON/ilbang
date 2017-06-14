<?php
    include_once "../../include/session.php";
    include_once "../../db/connect.php";

    $no = $_POST["no"];
    $val = $_POST["val"];       // 0 : 수정, 1 : 삭제

    $sql = "SELECT uid FROM qna_board WHERE no = $no";
    $result = mysql_query($sql);
    $arr = mysql_fetch_array($result);

    $chkID = $arr[0];

    if($uid != $chkID) {
        if($val == 0) {
            $message = "본인의 글만 수정할 수 있습니다.";
        } else {
            $message = "본인의 글만 삭제할 수 있습니다.";
        }
    }

    echo json_encode($message);
?>