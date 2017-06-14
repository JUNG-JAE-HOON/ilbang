<?php
    include_once "../include/session.php";
    include_once "../db/connect.php";

    $val = $_POST["val"];

    if($val == 0) {
        $message = "더이상 이력서를 작성할 수 없습니다.";
        $url = "http://il-bang.com/pc_renewal/gujik/form/form.php";

        $sql = "SELECT resume_count FROM member_extend WHERE uid = '$uid'";
    } else {
        $message = "더이상 채용 공고를 작성할 수 없습니다.";
        $url = "http://il-bang.com/pc_renewal/guin/form/form.php";
        
        $sql = "SELECT employ_count FROM company WHERE uid = '$uid'";
    }

    $result = mysql_query($sql);
    $arr = mysql_fetch_array($result);

    $count = $arr[0];

    echo json_encode(array('count' => $count, 'message' => $message, 'url' => $url));
?>