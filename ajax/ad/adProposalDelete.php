<?php
    include_once "../../include/session.php";
    include_once "../../db/connect.php";

    $no = $_POST["no"];

    $sql = "SELECT admin_uid FROM ad WHERE no = $no";
    $result = mysql_query($sql);
    $arr = mysql_fetch_array($result);

    $checkID = $arr[0];

    if($uid == $checkID) {
        $sql = "DELETE FROM ad WHERE no = $no AND admin_uid = '$uid'";
        $result = mysql_query($sql);

        if($result) {
            $message = "삭제 되었습니다.";        
        } else {
            $message = "삭제 실패했습니다.";
        }
    } else {
        $message = "본인이 등록한 글만 삭제할 수 있습니다.";
    }

    echo json_encode($message);
?>