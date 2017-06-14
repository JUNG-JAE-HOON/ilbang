<?php
    include_once "../../include/session.php";
    include_once "../../db/connect.php";

    if($uid != "") {
        if($kind != "general") {
            $sql = "SELECT company, number, ceo, types, status, flotation, img_url FROM company WHERE uid = '$uid'";
            $result = mysql_query($sql);
            $arr = mysql_fetch_array($result);

            $memberInfo["number"] = $arr["number"];
            $memberInfo["company"] = $arr["company"];
            $memberInfo["ceo"] = $arr["ceo"];
            $memberInfo["types"] = $arr["types"];
            $memberInfo["status"] = $arr["status"];
            $memberInfo["flotation"] = $arr["flotation"];
            $memberInfo["img_url"] = $arr["img_url"];

            //긴급 구인 아이템이 있는지 확인
            $sql = "SELECT IF(COUNT(*) = 0, 'not', COUNT(*)) AS totalCnt, IFNULL(SUM(count), 0) AS cnt FROM work_item
                         WHERE uid = '$uid' AND item_kind = 'emergency' AND count > 0";
            $result = mysql_query($sql);
            $arr = mysql_fetch_array($result);

            $itemEmergency["totalCnt"] = $arr["totalCnt"];
            $itemEmergency["cnt"] = number_format($arr["cnt"]);

            if(isset($_POST["no"])) {
                $sql = "SELECT * FROM work_employ_data WHERE no = $no";
                $result = mysql_query($sql);
                $arr = mysql_fetch_array($result);

                if($arr["view"] == "no") {
                    $message = "삭제된 구인 신청서입니다.";
                } else if($arr["uid"] != $uid) {
                    $message = "본인의 구인 신청서만 볼 수 있습니다.";
                } else {
                    $keyword = explode(",", $arr["keyword"]);

                    $guinFormList["title"] = $arr["title"];
                    $guinFormList["area1Val"] = $arr["area_1st"];
                    $guinFormList["area2Val"] = $arr["area_2nd"];
                    $guinFormList["work1Val"] = $arr["work_1st"];
                    $guinFormList["work2Val"] = $arr["work_2nd"];
                    $guinFormList["area1"] = $keyword[0];
                    $guinFormList["area2"] = $keyword[1];
                    $guinFormList["work1"] = $keyword[3];
                    $guinFormList["work2"] = $keyword[4];
                    $guinFormList["pay"] = $arr["pay"];
                    $guinFormList["time"] = $arr["time"];
                    $guinFormList["minAge"] = $arr["age_1st"];
                    $guinFormList["maxAge"] = $arr["age_2nd"];
                    $guinFormList["career"] = $arr["career"];
                    $guinFormList["sex"] = $arr["sex"];
                    $guinFormList["people"] = $arr["people_num"];
                    $address = explode(", ", $arr["address"]);
                    $guinFormList["address1"] = $address[0];
                    $guinFormList["address2"] = $address[1];
                    $guinFormList["manager"] = $arr["manager"];
                    $phone = explode("-", $arr["phone"]);
                    $guinFormList["phone1"] = $phone[0];
                    $guinFormList["phone2"] = $phone[1];
                    $guinFormList["phone3"] = $phone[2];
                    $guinFormList["business"] = $arr["business"];
                    $guinFormList["content"] = nl2br($arr["content"]);
                }
            }
        } else {
            $message = "추가 정보 입력 후 이용할 수 있습니다.";
        }
    } else {
        $message = "로그인 후 이용해주세요.";
    }

    echo json_encode(array('memberInfo' => $memberInfo, 'itemEmergency' => $itemEmergency, 'guinFormList' => $guinFormList, 'message' => $message));
?>