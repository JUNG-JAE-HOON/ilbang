<?php
    include_once "../../db/connect.php";

    $no = $_POST["no"];

    $sql = "SELECT A.title, A.manager, A.business, A.keyword, A.phone, A.sex, A.career, C.date, A.pay, A.time, A.content, B.img_url, A.fn, A.age_1st, A.age_2nd, A.lng, A.lat
                 FROM work_employ_data A JOIN company B JOIN employ_date C
                 WHERE A.no = $no AND A.member_no = B.member_no AND A.no = C.work_employ_data_no";
    $result = mysql_query($sql);

    while($arr = mysql_fetch_array($result)) {
        $numberNo = $arr["number_no"];
        $employList["title"] = $arr["title"];
        $employList["manager"] = $arr["manager"];
        $employList["business"] = $arr["business"];
        $employList["age"] = $arr["age_1st"]."세 ~ ".$arr["age_2nd"]."세";
        $employList["content"] = nl2br($arr["content"]);
        $employList["lat"] = $arr["lat"];
        $employList["lng"] = $arr["lng"];

        $keyword = explode(",", $arr["keyword"]);

        if($keyword[0] == "전체") {
            $employList["addr"] = $keyword[0];
        } else {
            $employList["addr"] = $keyword[0]." ".$keyword[1]." ".$keyword[2];
        }

        $employList["work"] = $keyword[4];

        if($arr["sex"] == "nothing") {
            $employList["sex"] = "무관";
        } else if($arr["sex"] == "man") {
            $employList["sex"] = "남자";
        } else {
            $employList["sex"] = "여자";
        }

        if($arr["career"] == -1) {
            $employList["career"] = "무관";
        } else if($arr["career"] == 0) {
            $employList["career"] = "신입";
        } else if($arr["career"] == 1) {
            $employList["career"] = "1년 미만";
        } else if($arr["career"] == 3) {
            $employList["career"] = "3년 미만";
        } else if($arr["career"] == 5) {
            $employList["career"] = "5년 미만";
        } else {
            $employList["career"] = "5년 이상";
        }

        $phone = explode("-", $arr["phone"]);
        $employList["phone"] = $phone[0]."-****-****";
        $employList["date"].= $arr["date"]." / ";

        if ($arr["time"] == "1") {
            $employList["time"] = "오전";
        } else if ($arr["time"] == "2") {
            $employList["time"] = "오후";
        } else if ($arr["time"] == "3") {
            $employList["time"] = "저녁";
        } else if ($arr["time"] == "4") {
            $employList["time"] = "새벽";
        } else if ($arr["time"] == "5") {
            $employList["time"] = "오전 ~ 오후";
        } else if ($arr["time"] == "6") {
            $employList["time"] = "오후 ~ 저녁";
        } else if ($arr["time"] == "7") {
            $employList["time"] = "저녁 ~ 새벽";
        } else if ($arr["time"] == "8") {
            $employList["time"] = "새벽 ~ 오전";
        } else if ($arr["time"] == "9") {
            $employList["time"] = "풀타임";
        } else {
            $employList["time"] = "무관/협의";
        }

        $pay = number_format($arr["pay"]);

        if($pay == 0) {
            $employList["pay"] = "**,***";
        } else {
            $employList["pay"] = preg_replace('/[0-9]/', '*', $pay);
        }

        if($arr2["img_url"] == null) {
            $employList["imgUrl"] = "../images/144x38.png";
        } else {
            $employList["imgUrl"] = "../guinImage/".$arr["img_url"];
        }

        if($arr["fn"] == 0) {
            $employList["fn"] = "X";
        } else {
            $employList["fn"] = "O";
        }
    }

    $employList["date"] = substr($employList["date"], 0, -2);

    echo json_encode(array('employList' => $employList));
?>