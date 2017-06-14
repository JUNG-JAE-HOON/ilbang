<?php
    include_once "../../include/session.php";
    include_once "../../db/connect.php";

    $sql = "SELECT img_url FROM company WHERE uid = '$uid'";
    $result = mysql_query($sql);
    $arr = mysql_fetch_array($result);

    $imgUrl = $arr[0];

    if($imgUrl == null || $imgUrl == "") {
        $message = "삭제할 사진이 없습니다.";
    } else {
        unlink('../../guinImage/'.$imgUrl);

        $sql = "UPDATE company SET img_url = null WHERE uid = '$uid'";
        $result = mysql_query($sql);

        if($result) {
            $message = "사진이 삭제되었습니다.";
        } else {
            $message = "사진 삭제 실패";
        }
    }

    echo json_encode($message);
?>