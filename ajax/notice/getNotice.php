<?php
    include_once "../../db/mmcpConnect.php";

    $no = $_POST["no"];

    $sql = "SELECT wr_subject, wr_content, wr_link1, wr_link2, wr_hit, wr_datetime, wr_file, wr_comment FROM g5_write_notice1 WHERE wr_id = $no";
    $result = mysql_query($sql);
    $arr = mysql_fetch_array($result);

    $board = array();

    $hit = $arr["wr_hit"] + 1;
    $board["title"] = $arr["wr_subject"];
    $board["content"] = nl2br($arr["wr_content"]);
    $board["link1"] = $arr["wr_link1"];
    $board["link2"] = $arr["wr_link2"];
    $board["hit"] = number_format($arr["wr_hit"]);
    $board["date"] = $arr["wr_datetime"];
    $board["file"] = $arr["wr_file"];
    $board["day"] = date("y-m-d", strtotime($arr["wr_datetime"]));
    $board["time"] = date("H:i", strtotime($arr["wr_datetime"]));
    $board["comment"] = $arr["wr_comment"];

    if($arr["wr_file"] != 0) {
        $sql = "SELECT bf_file FROM g5_board_file WHERE bo_table = 'notice1' AND wr_id = $no";
        $result = mysql_query($sql);

        $i = 0;

        while($arr = mysql_fetch_array($result)) {
            $file[$i++] = $arr[0];
        }

        $board["fileList"] = $file;
    } else {
        $board["fileList"] = "";
    }

    $sql = "SELECT wr_id, wr_subject FROM g5_write_notice1
                 WHERE wr_id IN(SELECT MAX(wr_id) FROM g5_write_notice1 WHERE wr_id < $no)";
    $result = mysql_query($sql);
    $num = mysql_num_rows($result);
    $arr = mysql_fetch_array($result);

    if($num != 0) {
        $board["prevNo"] = $arr[0];
        $board["prev"] = $arr[1];
    } else {
        $board["prevNo"] = "";
        $board["prev"] = 0;
    }

    $sql = "SELECT wr_id, wr_subject FROM g5_write_notice1
                 WHERE wr_id IN(SELECT MIN(wr_id) FROM g5_write_notice1 WHERE wr_id > $no)";
    $result = mysql_query($sql);
    $num = mysql_num_rows($result);
    $arr = mysql_fetch_array($result);

    if($num != 0) {
        $board["nextNo"] = $arr[0];
        $board["next"] = $arr[1];
    } else {
        $board["nextNo"] = "";
        $board["next"] = 0;
    }

    mysql_query("UPDATE g5_write_notice1 SET wr_hit = $hit WHERE wr_id = $no");

    echo json_encode(array('board' => $board));
?>