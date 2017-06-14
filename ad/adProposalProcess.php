<?php
    header("Cache-Control: no-cache, must-revalidate");
    include_once "../include/session.php";
    include_once "../db/connect.php";

    if($uid == "") {
        echo "<script>alert('로그인 후 이용해주세요.');</script>";
    } else {
        if(isset($_POST["adNo"])) {
            $no = $_POST["adNo"];
        } else {
            $no = "";
        }

        if(isset($_POST["adTime"])) {
            $time = $_POST["adTime"];
        } else {
            $time = 15;
        }

        $type = $_POST["type"];
        $title = $_POST["adTitle"];
        $link = $_POST["adLink"];
        $content = $_POST["adContent"];
        $quiz = $_POST["adQuiz"];
        $example = $_POST["adExample1"].",".$_POST["adExample2"].",".$_POST["adExample3"].",".$_POST["adExample4"];    
        $correct = $_POST["adCorrect"];
        $expose = $_POST["adExpose"];
        $price = $_POST["adPrice"];

        $totalPrice = $expose * $price;
        $wdate = date("Y-m-d H:i:s");

        if($type == 0) {
            $sql = "INSERT INTO ad(type, title, content, add_point, total_count, all_point, time, ad_link, quiz, example, correct, view, wdate, admin_uid, count)
                         VALUES ('$type', '$title', '$content', '$price', '$expose', '$totalPrice', '$time', '$link', '$quiz', '$example', '$correct', 'no', '$wdate', '$uid', 0)";
        } else if($type == 1) {
            $sql = "INSERT INTO ad(type, title, content, add_point, total_count, all_point, time, ad_link, quiz, example, correct, view, wdate, admin_uid, count)
                         VALUES ('$type', '$title', '$content', '$price', '$expose', '$totalPrice', 15, '$link', '$quiz', '$example', '$correct', 'no', '$wdate', '$uid', 0)";
        } else if($type == 2) {
            $sql = "UPDATE ad SET title = '$title', content = '$content', add_point = '$price', total_count = '$expose', all_point = '$totalPrice', time = '$time', ad_link = '$link', quiz = '$quiz',
                         example = '$example', correct = '$correct', wdate = '$wdate' WHERE no = '$no' AND admin_uid = '$uid'";
        }

        $result = mysql_query($sql);

        if($result) {
            if($type != 2) {
                echo "<script>alert('광고 신청이 완료 되었습니다.');</script>";
            } else {
                echo "<script>alert('광고가 수정되었습니다.');</script>";
            }
        } else {
            if($type != 2) {
                echo "<script>alert('광고 신청 실패');</script>";        
            } else {
                echo "<script>alert('광고 수정 실패');</script>";
            }
        }
    }

    echo "<script>document.location.href = 'adProposal.php?tab=3';</script>";
?>