<?php
    include_once "../../include/session.php";
    include_once "../../db/connect.php";

    $no = $_POST["val"];

    $sql = "SELECT * FROM ad WHERE admin_uid = '$uid' AND no = '$no'";
    $result = mysql_query($sql);
    $arr = mysql_fetch_array($result);

    $exam = explode(",", $arr["example"]);

    $proposalData["no"] = $arr["no"];
    $proposalData["title"] = $arr["title"];
    $proposalData["link"] = $arr["ad_link"];
    $proposalData["content"] = $arr["content"];
    $proposalData["time"] = $arr["time"];
    $proposalData["quiz"] = $arr["quiz"];
    $proposalData["exam1"] = $exam[0];
    $proposalData["exam2"] = $exam[1];
    $proposalData["exam3"] = $exam[2];
    $proposalData["exam4"] = $exam[3];
    $proposalData["correct"] = $arr["correct"];
    $proposalData["expose"] = $arr["total_count"];
    $proposalData["price"] = $arr["add_point"];
    $totalPrice = $arr["total_count"] * $arr["add_point"];
    $proposalData["totalPrice"] = number_format($totalPrice);

    echo json_encode(array('proposalData' => $proposalData));
?>