<?php
    include_once "../../db/mmcpConnect.php";

    $sql = "SELECT wr_id, wr_subject, wr_datetime FROM g5_write_notice1 ORDER BY wr_datetime DESC LIMIT 5";
    $result = mysql_query($sql);

    while($arr = mysql_fetch_array($result)) {
        $noticeList2["no"] = $arr["wr_id"];
        $noticeList2["title"] = $arr["wr_subject"];
        $noticeList2["date"] = date("y-m-d H:i", strtotime($arr["wr_datetime"]));

        $noticeList[] = $noticeList2;
    }

    echo json_encode(array('noticeList' => $noticeList));
?>