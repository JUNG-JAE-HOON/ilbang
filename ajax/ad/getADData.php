<?php
    include_once "../../db/connect.php";

    $no = $_POST["val"];

    $sql = "SELECT no, type, title, content, ad_link, quiz, example
                 FROM ad WHERE no = '$no' AND view = 'yes' AND total_count > count";
    $result = mysql_query($sql);
    $arr = mysql_fetch_array($result);

    $exam = explode(",", $arr["example"]);

    $adDataList["no"] = $arr["no"];
    $adDataList["title"] = $arr["title"];
    $adDataList["content"] = $arr["content"];

    if($arr["type"] == 0) {
        $adDataList["link"] = $arr["ad_link"];
    } else if($arr["type"] == 1) {
        $adDataList["link"] = "../../mobile/ad/img/".$arr["ad_link"];
    }

    $adDataList["quiz"] = $arr["quiz"];
    $adDataList["exam1"] = $exam[0];
    $adDataList["exam2"] = $exam[1];
    $adDataList["exam3"] = $exam[2];
    $adDataList["exam4"] = $exam[3];

    echo json_encode(array('adDataList' => $adDataList));
?>