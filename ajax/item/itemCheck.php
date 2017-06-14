<?php
    include_once "../../include/session.php";
    include_once "../../db/connect.php";

    $no = $_POST["no"];

    //확인해야할 아이템
    //횟수 아이템 번호 - 2, 6, 10
    //기간제 아이템 번호 - 3, 4, 7, 8, 11, 12
    $sql = "SELECT COUNT(*) FROM work_item WHERE uid = '$uid' AND item_id IN(3, 4, 7, 8, 11, 12) AND end_date > NOW()";
    $result = mysql_query($sql);
    $arr = mysql_fetch_array($result);

    if($arr[0] == 0) {
        $sql = "SELECT COUNT(*), count FROM work_item WHERE uid = '$uid' AND item_id IN(2, 6, 10) AND count > 0";
        $result = mysql_query($sql);
        $arr = mysql_fetch_array($result);

        if($arr[0] == 0) {
            // $message = "이력서를 열람하기 위해서는 아이템이 필요합니다.\n확인을 누르시면 아이템샵 페이지로 이동합니다.";
            $message = "이력서를 열람하기 위해서는 아이템이 필요합니다.";
            $url = "";
        } else {
            $message = "이력서 열람 남은 횟수 : ".$arr[1]."회\n이력서를 열람하시겠습니까?";
            $url = "http://il-bang.com/pc_renewal/guin/view/guinTab1.php?tab=1&resumeNo=".$no;
        }
    } else {
        $message = "";
        $url = "http://il-bang.com/pc_renewal/guin/view/guinTab1.php?tab=1&resumeNo=".$no;
    }

    echo json_encode(array('message' => $message, 'url' => $url));
?>