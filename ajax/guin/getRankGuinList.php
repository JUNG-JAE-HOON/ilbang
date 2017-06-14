<?php
    include_once "../../db/connect.php";

    //VIP LIST
    $sql = "SELECT B.no, B.company, B.keyword, B.pay, C.img_url
                 FROM pc_vip_employ A JOIN work_employ_data B JOIN company C
                 WHERE A.employ_no = B.no AND A.free_end_date > NOW() AND B.member_no = C.member_no
                 ORDER BY A.free_end_date LIMIT 8";
    $result = mysql_query($sql);

    while($arr = mysql_fetch_array($result)) {
        $keyword = explode(",", $arr["keyword"]);

        $data["no"] = $arr["no"];
        $data["company"] = $arr["company"];
        $data["work"] = $keyword[3]." > ".$keyword[4];
        $data["pay"] = number_format($arr["pay"]);

        if($keyword[0] == "전체") {
            $data["area"] = "전체";
        } else {
            if($keyword[1] == "전체") {
                $data["area"] = $keyword[0]." > 전체";
            } else {
                $data["area"] = $keyword[0]." > ".$keyword[1]." ".$keyword[2];
            }
        }

        if(empty($arr["img_url"])) {
            $data["logo"] = '<p class="mt30"><div class="f20 bold text-cut">'.$data["company"].'</div></p>';
        } else {
            $data["logo"] = '<p class="mt20"><img src="guinImage/'.$arr["img_url"].'" alt="" class="wh144"></p>';
        }

        $vipList[] = $data;
    }

    //PLATINUM LIST
    $sql = "SELECT B.no, B.company, B.title, B.business, B.pay, B.sex, B.age_1st, B.age_2nd, B.time, B.keyword
                 FROM pc_platinum_employ A JOIN work_employ_data B
                 WHERE A.employ_no = B.no AND A.free_end_date > NOW()
                 ORDER BY A.free_end_date LIMIT 5";
    $result = mysql_query($sql);

    while($arr = mysql_fetch_array($result)) {
        $keyword = explode(",", $arr["keyword"]);

        $data["no"] = $arr["no"];
        $data["company"] = $arr["company"];
        $data["title"] = $arr["title"];
        $data["business"] = $arr["business"];
        $data["pay"] = number_format($arr["pay"]);
        $data["work1"] = $keyword[3];
        $data["work2"] = $keyword[4];
        $data["age"] = $arr["age_1st"]."대 ~ ".$arr["age_2nd"]."대";

        if($keyword[0] == "전체") {
            $data["area"] = "전체";
        } else {
            if($keyword[1] == "전체") {
                $data["area"] = $keyword[0]." > 전체";
            } else {
                $data["area"] = $keyword[0]." > ".$keyword[1]." ".$keyword[2];
            }
        }

        if($arr["sex"] == "nothing" || $arr["sex"] == "" || $arr["sex"] == null) {
            $data["sex"] = "무관";
        } else if($arr["sex"] == "woman") {
            $data["sex"] = "여자";
        } else {
            $data["sex"] = "남자";
        }

        if ($arr["time"] == "1") {
            $data["time"] = "오전";
        } else if ($arr["time"] == "2") {
            $data["time"] = "오후";
        } else if ($arr["time"] == "3") {
            $data["time"] = "저녁";
        } else if ($arr["time"] == "4") {
            $data["time"] = "새벽";
        } else if ($arr["time"] == "5") {
            $data["time"] = "오전 ~ 오후";
        } else if ($arr["time"] == "6") {
            $data["time"] = "오후 ~ 저녁";
        } else if ($arr["time"] == "7") {
            $data["time"]  = "저녁 ~ 새벽";
        } else if ($arr["time"] == "8") {
            $data["time"]  = "새벽 ~ 오전";
        } else if ($arr["time"] == "9") {
            $data["time"]  = "풀타임";
        } else {
            $data["time"]  = "무관/협의";
        }

        $platinumList[] = $data;
    }

    //GRAND LIST
    $sql = "SELECT B.no, B.company, B.title, B.business, B.pay, B.sex, B.age_1st, B.age_2nd, B.time, B.keyword
                 FROM pc_grand_employ A JOIN work_employ_data B
                 WHERE A.employ_no = B.no AND A.free_end_date > NOW()
                 ORDER BY A.free_end_date LIMIT 5";
    $result = mysql_query($sql);

    while($arr = mysql_fetch_array($result)) {
        $keyword = explode(",", $arr["keyword"]);

        $data["no"] = $arr["no"];
        $data["company"] = $arr["company"];
        $data["title"] = $arr["title"];
        $data["business"] = $arr["business"];
        $data["pay"] = number_format($arr["pay"]);
        $data["work"] = $keyword[3]." > ".$keyword[4];
        $data["age"] = $arr["age_1st"]."대 ~ ".$arr["age_2nd"]."대";
        

        if($keyword[0] == "전체") {
            $data["area"] = "전체";
        } else {
            if($keyword[1] == "전체") {
                $data["area"] = $keyword[0]." > 전체";
            } else {
                $data["area"] = $keyword[0]." > ".$keyword[1]." ".$keyword[2];
            }
        }

        if($arr["sex"] == "nothing" || $arr["sex"] == "" || $arr["sex"] == null) {
            $data["sex"] = "무관";
        } else if($arr["sex"] == "woman") {
            $data["sex"] = "여자";
        } else {
            $data["sex"] = "남자";
        }

        if ($arr["time"] == "1") {
            $data["time"] = "오전";
        } else if ($arr["time"] == "2") {
            $data["time"] = "오후";
        } else if ($arr["time"] == "3") {
            $data["time"] = "저녁";
        } else if ($arr["time"] == "4") {
            $data["time"] = "새벽";
        } else if ($arr["time"] == "5") {
            $data["time"] = "오전 ~ 오후";
        } else if ($arr["time"] == "6") {
            $data["time"] = "오후 ~ 저녁";
        } else if ($arr["time"] == "7") {
            $data["time"]  = "저녁 ~ 새벽";
        } else if ($arr["time"] == "8") {
            $data["time"]  = "새벽 ~ 오전";
        } else if ($arr["time"] == "9") {
            $data["time"]  = "풀타임";
        } else {
            $data["time"]  = "무관/협의";
        }

        $grandList[] = $data;
    }

    //SPECIAL LIST
    $sql = "SELECT B.no, B.company, B.business, B.pay, B.keyword
                 FROM pc_special_employ A JOIN work_employ_data B
                 WHERE A.employ_no = B.no AND A.free_end_date > NOW()
                 ORDER BY A.free_end_date LIMIT 14";
                 // ORDER BY RAND() LIMIT 14";
    $result = mysql_query($sql);

    while($arr = mysql_fetch_array($result)) {
        $keyword = explode(",", $arr["keyword"]);

        $data["no"] = $arr["no"];
        $data["company"] = $arr["company"];
        $data["business"] = $arr["business"];
        $data["pay"] = number_format($arr["pay"]);
        $data["work"] = $keyword[4];

        if($keyword[0] == "전체") {
            $data["area"] = "전체";
        } else {
            if($keyword[1] == "전체") {
                $data["area"] = $keyword[0]." 전체";
            } else {
                $data["area"] = $keyword[0]." ".$keyword[1]." ".$keyword[2];
            }
        }

        $specialList[] = $data;
    }

    $sql = "SELECT A.no, A.company, A.title, A.business, A.pay, A.sex, A.age_1st, A.age_2nd, A.time, A.keyword, B.img_url
                 FROM work_employ_data A JOIN company B
                 WHERE A.member_no = B.member_no AND A.wdate > (NOW() - INTERVAL 7 DAY)
                 GROUP BY A.no ORDER BY RAND()";
    $result = mysql_query($sql);

    while($arr = mysql_fetch_array($result)) {
        $keyword = explode(",", $arr["keyword"]);

        $data["no"] = $arr["no"];
        $data["company"] = $arr["company"];
        $data["title"] = $arr["title"];
        $data["business"] = $arr["business"];
        $data["pay"] = number_format($arr["pay"]);
        $data["work1"] = $keyword[3];
        $data["work2"] = $keyword[4];
        $data["age"] = $arr["age_1st"]."대 ~ ".$arr["age_2nd"]."대";

        if($keyword[0] == "전체") {
            $data["area"] = "전체";
        } else {
            if($keyword[1] == "전체") {
                $data["area"] = $keyword[0]." > 전체";
            } else {
                $data["area"] = $keyword[0]." > ".$keyword[1]." ".$keyword[2];
            }
        }

        if($arr["sex"] == "nothing" || $arr["sex"] == "" || $arr["sex"] == null) {
            $data["sex"] = "무관";
        } else if($arr["sex"] == "woman") {
            $data["sex"] = "여자";
        } else {
            $data["sex"] = "남자";
        }

        if ($arr["time"] == "1") {
            $data["time"] = "오전";
        } else if ($arr["time"] == "2") {
            $data["time"] = "오후";
        } else if ($arr["time"] == "3") {
            $data["time"] = "저녁";
        } else if ($arr["time"] == "4") {
            $data["time"] = "새벽";
        } else if ($arr["time"] == "5") {
            $data["time"] = "오전 ~ 오후";
        } else if ($arr["time"] == "6") {
            $data["time"] = "오후 ~ 저녁";
        } else if ($arr["time"] == "7") {
            $data["time"]  = "저녁 ~ 새벽";
        } else if ($arr["time"] == "8") {
            $data["time"]  = "새벽 ~ 오전";
        } else if ($arr["time"] == "9") {
            $data["time"]  = "풀타임";
        } else {
            $data["time"]  = "무관/협의";
        }

        if(empty($arr["img_url"])) {
            $data["logo"] = '<p class="mt30"><div class="f20 bold text-cut" style="padding: 0 20px;">'.$data["company"].'</div></p>';
        } else {
            $data["logo"] = '<p class="mt20"><img src="guinImage/'.$arr["img_url"].'" alt="" class="wh144"></p>';
        }

        $recentList[] = $data;
    }

    echo json_encode(array('vipList' => $vipList, 'platinumList' => $platinumList, 'grandList' => $grandList, 'specialList' => $specialList, 'recentList' => $recentList));
?>