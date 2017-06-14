<?php
    include_once "../../include/session.php";
    include_once "../../db/connect.php";

    if(isset($_POST["no"])) {
        $no = $_POST["no"];
    } else {
        $no = "";
    }

    if($uid != "") {
        $sql = "SELECT A.name, B.birthday, B.age, B.sex, B.phone, B.email, B.obstacle, B.img_url
                     FROM member A JOIN member_extend B
                     WHERE A.uid = B.uid AND A.uid = '$uid'";
        $result = mysql_query($sql);
        $arr = mysql_fetch_array($result);

        $memberInfo["name"] = $arr["name"];
        $memberInfo["birth"] = date("Y년 m월 d일", strtotime($arr["birthday"]));
        $memberInfo["age"] = $arr["age"];
        $memberInfo["img_url"] = $arr["img_url"];

        if($arr["sex"] == "male") {
            $memberInfo["sex"] = "남자";
        } else if($arr["sex"] == "female") {
            $memberInfo["sex"] = "여자";
        } else {
            $memberInfo["sex"] = "";
        }

        $memberInfo["phone"] = $arr["phone"];
        $memberInfo["email"] = $arr["email"];

        if($arr["obstacle"] == "yes") {
            $memberInfo["obstacle"] = "장애";
        } else if($arr["obstacle"] == "no") {
            $memberInfo["obstacle"] = "비장애";
        } else {
            $memberInfo["obstacle"] = "";
        }

        if($no != "") {
            $sql = "SELECT * FROM work_resume_data WHERE no = $no";
            $result = mysql_query($sql);
            $arr = mysql_fetch_array($result);

            if($arr["view"] == "no") {
                $message = "삭제된 이력서입니다.";
            } else if($arr["uid"] != $uid) {
                $message = "본인의 이력서만 볼 수 있습니다.";
            } else {
                $resumeInfo["title"] = $arr["title"];
                $resumeInfo["age"] = $arr["age"];
                $resumeInfo["area1"] = $arr["area_1st"];
                $resumeInfo["area2"] = $arr["area_2nd"];
                $resumeInfo["work1"] = $arr["work_1st"];
                $resumeInfo["work2"] = $arr["work_2nd"];
                $resumeInfo["pay"] = $arr["pay"];
                $resumeInfo["time"] = $arr["time"];
                $resumeInfo["career"] = $arr["career"];
                $resumeInfo["content"] = nl2br($arr["content"]);
                $resumeInfo["open"] = $arr["open"];
            }
        }
    } else {
        $message = "로그인 후 이용해주세요.";
    }

    echo json_encode(array('memberInfo' => $memberInfo, 'resumeInfo' => $resumeInfo, 'message' => $message));
?>