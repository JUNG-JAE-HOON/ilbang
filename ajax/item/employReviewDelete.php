<?php
    include_once "../../include/session.php";
    include_once "../../db/connect.php";

    $reviewNo = $_POST["no"];
    $wdate = date("Y-m-d H:i:s");

    $sql = "SELECT euid FROM employ_review WHERE no = $reviewNo";
    $result = mysql_query($sql);
    $arr = mysql_fetch_array($result);

    if($uid == $arr["euid"]) {
        $sql = "SELECT A.no, COUNT(*) AS itemCnt, SUM(A.count) AS totalCnt, B.item_id
                     FROM work_item A JOIN item_data B
                     WHERE A.uid = '$uid' AND A.item_kind = 'review' AND A.count > 0 AND A.item_id = B.id";
        $result = mysql_query($sql);
        $arr = mysql_fetch_array($result);

        $totalCnt = $arr["totalCnt"] - 1;

        if($arr["itemCnt"] != 0) {
            $itemID = $arr["item_id"];
            $itemNo = $arr["no"];

            $sql = "UPDATE work_item SET count = count - 1 WHERE uid = '$uid' AND no = $itemNo";
            $result = mysql_query($sql);

            if($result) {
                $sql = "INSERT INTO item_use_log(user_id, item_name, use_date) VALUES ('$uid', '$itemID', '$wdate')";
                $result = mysql_query($sql);

                if($result) {
                    $sql = "DELETE FROM employ_review WHERE euid = '$uid' AND no = $reviewNo";
                    $result = mysql_query($sql);

                    if($result) {
                        $message = "악평 지우기 1회를 사용하여 리뷰를 지웠습니다."."\n"."악평 지우기 남은 횟수 : ".number_format($totalCnt)."회";
                    } else {
                        $message = "리뷰 지우기 실패";
                    }
                } else {
                    $message = "아이템 사용 기록 등록 실패";
                }
            } else {
                $message = "아이템 사용 실패";
            }
        } else {
            $message = "악평 지우기 아이템이 없습니다.";
        }
    } else {
        $message = "삭제할 수 없습니다.";
    }

    echo json_encode($message);
?>