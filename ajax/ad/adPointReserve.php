<?php
    include_once "../../include/session.php";
    include_once "../../db/connect.php";

    $no = $_POST["val"];
    $userCorrect = $_POST["correct"];

    if($uid != "") {
        $sql = "SELECT (IFNULL(SUM(point), 0) + (SELECT add_point FROM ad WHERE no = $no)) AS point
                     FROM ad_money_log WHERE uid = '$uid' AND DATE(wdate) = DATE(NOW()) AND type IN(0, 1)";
        $result = mysql_query($sql);
        $arr = mysql_fetch_array($result);

        if($arr["point"] < 3000) {
            $sql = "SELECT * FROM ad_money_log WHERE ad_no = '$no' AND uid = '$uid'";
            $result = mysql_query($sql);
            $check = mysql_num_rows($result);

            if($check == 0) {
                $sql = "SELECT type, add_point, correct, count FROM ad WHERE no = '$no'";
                $result = mysql_query($sql);
                $arr = mysql_fetch_array($result);

                $adCorrect = $arr["correct"];

                if($userCorrect == $adCorrect) {
                    $type = $arr["type"];
                    $point = $arr["add_point"];
                    $wdate = date("Y-m-d H:i:s");
                    $count = $arr["count"] + 1;

                    $sql = "SELECT * FROM ad_money WHERE uid = '$uid'";
                    $result = mysql_query($sql);
                    $arr = mysql_fetch_array($result);

                    $adMoneyNo = $arr["no"];
                    $myPoint = $arr["point"];
                    $memberNo = $arr["member_no"];
                    $validNo = $arr["valid_no"];

                    $totalPoint = $myPoint + $point;

                    $sql = "INSERT INTO ad_money_log(type, ad_no, point, total_point, wdate, ad_money_no, member_no, valid_no, uid)
                                 VALUES ('$type', '$no', '$point', '$totalPoint', '$wdate', '$adMoneyNo', '$memberNo', '$validNo', '$uid')";
                    $result = mysql_query($sql);

                    if($result) {
                        mysql_query("UPDATE ad SET count = '$count' WHERE no = '$no'");
                        mysql_query("UPDATE ad_money SET point = '$totalPoint' WHERE uid = '$uid'");

                        $message = "적립 완료";
                    } else {
                        $message = "적립 실패";
                    }
                } else {
                    $message = "정답이 아닙니다.";
                }
            } else {
                $message = "이미 적립된 광고입니다.";
            }
        } else {
            $message = "하루 최대 3,000원까지 적립할 수 있습니다.";
        }
    } else {
        $message = "로그인 해주시기 바랍니다.";
    }

    echo json_encode($message);
?>