<?php
    include_once "../../db/connect.php";

    $no = $_POST["no"];

    $sql = "SELECT A.title, A.area_1st, A.area_2nd, A.work_2nd, B.name, C.birthday, A.keyword, C.sex, A.career, C.obstacle, C.email, C.phone, D.date, A.pay, A.time, A.content, C.img_url, A.content
                 FROM work_resume_data A JOIN member B JOIN member_extend C JOIN resume_date D
                 WHERE A.no = $no AND A.member_no = B.no AND A.member_no = C.member_no AND A.no = D.work_resume_data_no";
    $result = mysql_query($sql);

    while($arr = mysql_fetch_array($result)) {
        $star = "";
        $area1 = $arr["area_1st"];
        $area2 = $arr["area_2st"];
        $work2 = $arr["work_2nd"];
        $name = $arr["name"];
        $resumeList["title"] = $arr["title"];
        $resumeList["name"] = mb_substr($name, 0, 1, "UTF-8")."**";
        $resumeList["birth"] = $arr["birthday"];

        if($arr["content"] == null || $arr["content"] == "") {
            $resumeList["content"] = "자기 소개가 없습니다.";
        } else {
            $resumeList["content"] = nl2br($arr["content"]);
        }

        if($arr["sex"] == "male") {
            $resumeList["sex"] = "남자";
        } else if($arr["sex"] == "female") {
            $resumeList["sex"] = "여자";
        } else {
            $resumeList["sex"] = "알 수 없음";
        }

        $birth = explode("-", $arr["birthday"]);
        $age = (date("Y") - $birth[0]) + 1;
        $resumeList["age"] = substr($age, 0, 1)."0대";

        if($arr["career"] == 0) {
            $resumeList["career"] = "신입";
        } else if($arr["career"] == 1) {
            $resumeList["career"] = "1년 미만";
        } else if($arr["career"] == 3) {
            $resumeList["career"] = "3년 미만";
        } else if($arr["career"] == 5) {
            $resumeList["career"] = "5년 미만";
        } else {
            $resumeList["career"] = "5년 이상";
        }

        $email = explode("@", $arr["email"]);
        $emailLength = strlen($email[0]);

        for($i=0; $i<$emailLength; $i++) {
            $star.= "*";
        }

        $resumeList["email"] = $star."@".$email[1];

        $phone = explode("-", $arr["phone"]);
        $resumeList["phone"] = $phone[0]."-****-****";
        $resumeList["date"].= $arr["date"]." / ";

        if ($arr["time"] == "1") {
            $resumeList["time"] = "오전";
        } else if ($arr["time"] == "2") {
            $resumeList["time"] = "오후";
        } else if ($arr["time"] == "3") {
            $resumeList["time"] = "저녁";
        } else if ($arr["time"] == "4") {
            $resumeList["time"] = "새벽";
        } else if ($arr["time"] == "5") {
            $resumeList["time"] = "오전 ~ 오후";
        } else if ($arr["time"] == "6") {
            $resumeList["time"] = "오후 ~ 저녁";
        } else if ($arr["time"] == "7") {
            $resumeList["time"] = "저녁 ~ 새벽";
        } else if ($arr["time"] == "8") {
            $resumeList["time"] = "새벽 ~ 오전";
        } else if ($arr["time"] == "9") {
            $resumeList["time"] = "풀타임";
        } else if ($arr["time"] == "10") {
            $resumeList["time"] = "무관/협의";
        }

        if($arr["obstacle"] == 'yes') {
            $resumeList["obstacle"] = "장애";
        } else if($arr["obstacle"] == 'no') {
            $resumeList["obstacle"] = "비장애";
        } else {
            $resumeList["obstacle"] = "알 수 없음";
        }

        $pay = number_format($arr["pay"]);

        if($pay == 0) {
            $resumeList["pay"] = "**,***";
        } else {
            $resumeList["pay"] = preg_replace('/[0-9]/', '*', $pay);
        }

        if($arr["img_url"] == null) {
            $resumeList["imgUrl"] = "../images/profile.png";
        } else {
            $resumeList["imgUrl"] = "../gujikImage/".$arr["img_url"];
        }

        if(empty($arr["keyword"])) {
            $sql2 = "SELECT list_name FROM category WHERE no = $area1";
            $result2 = mysql_query($sql2);
            $arr2 = mysql_fetch_array($result2);

            $area1 = $arr2[0];

            if($area2 == 0) {
                $area2 = "전체";
            } else {
                $sql2 = "SELECT list_name FROM category WHERE no = $area2";
                $result2 = mysql_query($sql2);
                $arr2 = mysql_fetch_array($result2);

                $area2 = $arr2[0];
            }

            $sql2 = "SELECT list_name FROM category WHERE no = $work2";
            $result2 = mysql_query($sql2);
            $arr2 = mysql_fetch_array($result2);

            $work2 = $arr2[0];

            $resumeList["addr"] = $area1." ".$area2;
            $resumeList["work"] = $work2;
        } else {
            $keyword = explode(",", $arr["keyword"]);

            if($keyword[0] == "전체") {
                $resumeList["addr"] = $keyword[0];
            } else {
                $resumeList["addr"] = $keyword[0]." ".$keyword[1]." ".$keyword[2];
            }

            $resumeList["work"] = $keyword[4];
        }
    }

    $resumeList["date"] = substr($resumeList["date"], 0, -2);

    echo json_encode(array('resumeList' => $resumeList));
?>