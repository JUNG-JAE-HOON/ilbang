<?php
    include_once "../db/connect.php";

    $sql = "SELECT * FROM faq";
    $result = mysql_query($sql);

    $faqList = array();
    $i = 0;

    while($arr = mysql_fetch_array($result)) {
        $faqData["question"] = $arr["question"];
        $faqData["answer"] = $arr["answer"];

        $faqList[$i++] = $faqData;
    }

    echo json_encode(array('faqList' => $faqList));
?>