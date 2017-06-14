<?php
    header("Cache-Control: no-cache, must-revalidate");
    include_once "../../log/session.php";
    include_once "../../db/connect.php";

    if(isset($_POST["no"])) {
        $no = $_POST["no"];
    } else {
        $no = "";
    }

    $title = $_POST["title"];
    $area1 = $_POST["area_1st"];
    $area2 = $_POST["area_2nd"];
    $work1 = $_POST["work_1st"];
    $work2 = $_POST["work_2nd"];
    $pay = $_POST["pay"];
    $workDate = explode(",", trim($_POST["workDate"]));
    $time = $_POST["time"];
    $career = $_POST["career"];
    $content = addslashes($_POST["contents"]);
    $open = $_POST["open"];
    $wdate = date("Y-m-d H:i:s");

    if($uid == "" || $uid == null) {
        echo "<script>alert('로그인 후 이용해주세요.');</script>";
        echo "<script>history.back();</script>";
    } else {
        //------------------------------------------------------------
        //                         지역/직종 조회
        //------------------------------------------------------------
        $sql = "SELECT list_name FROM category WHERE no = $area1";
        $result = mysql_query($sql);
        $arr = mysql_fetch_array($result);

        $area1Text = $arr[0];

        $sql = "SELECT list_name FROM category WHERE no = $area2";
        $result = mysql_query($sql);
        $arr = mysql_fetch_array($result);

        $area2Text = $arr[0];

        $sql = "SELECT list_name FROM category WHERE no = $work1";
        $result = mysql_query($sql);
        $arr = mysql_fetch_array($result);

        $work1Text = $arr[0];

        $sql = "SELECT list_name FROM category WHERE no = $work2";
        $result = mysql_query($sql);
        $arr = mysql_fetch_array($result);

        $work2Text = $arr[0];

        if($area1 == 10000) {
            $area2Text = "전국";
        } else if($area1 == 10001) {
            $area2Text = "전체";
        }

        $keyword = $area1Text.",".$area2Text.",전체,".$work1Text.",".$work2Text;

        if($title == "" || $area1 == "" || $area2 == "" || $work1 == "" || $work2 == "" || $content == "") {
            echo "<script>alert('입력 내용을 확인해주세요. (내용 누락)');</script>";
            echo "<script>history.back();</script>";
        } else {
            $sql = "SELECT age, obstacle, member_no, valid_no, resume_count FROM member_extend WHERE uid = '$uid'";
            $result = mysql_query($sql);
            $arr = mysql_fetch_array($result);

            $age = $arr["age"];
            $obstacle = $arr["obstacle"];
            $memberNo = $arr["member_no"];
            $validNo = $arr["valid_no"];
            $resumeCount = $arr["resume_count"] - 1;

            if($age < 20 && $work2 != 8017) {
                echo "<script>alert('19세 이하는 봉사 일방에만 신청할 수 있습니다.');</script>";
                echo "<script>history.back();</script>";
            } else {
                if($no == "") {
                    $sql = "INSERT INTO work_resume_data(age, title, area_1st, area_2nd, area_3rd, work_1st, work_2nd, lat, lng, pay, career, content, wdate, time, member_no, valid_no, uid, open, keyword, location)
                                 VALUES ('$age', '$title', '$area1', '$area2', 10001, '$work1', '$work2', 0, 0, '$pay', '$career', '$content', '$wdate', '$time', '$memberNo', '$validNo', '$uid', '$open', '$keyword', 'PC')";

                    $success = "이력서가 등록되었습니다.";
                    $fail = "이력서 등록 실패";
                } else {
                    $sql = "UPDATE work_resume_data
                                 SET title = '$title', area_1st = '$area1', area_2nd = '$area2', work_1st = '$work1', work_2nd = '$work2', pay = '$pay', career = '$career',
                                 content = '$content', edit_date = '$wdate', time = '$time', open = '$open', keyword = '$keyword', location = 'PC_modify'
                                 WHERE no = $no";

                    $success = "이력서가 수정되었습니다.";
                    $fail = "이력서 수정 실패";
                }

                $result = mysql_query($sql);

                if($result) {
                    $sql = "SELECT no FROM work_resume_data WHERE uid = '$uid' ORDER BY wdate DESC";
                    $result = mysql_query($sql);
                    $arr = mysql_fetch_array($result);

                    $resumeNo = $arr[0];

                    if($no != "") {
                        mysql_query("DELETE FROM resume_date WHERE work_resume_data_no = $no");

                        $sql = "SELECT COUNT(*) FROM work_join_list WHERE work_resume_data_no = $no";
                        $result = mysql_query($sql);
                        $arr = mysql_fetch_array($result);

                        $joinNum = $arr[0];

                        if($joinNum > 0) {
                            mysql_query("DELETE FROM work_join_list WHERE work_resume_data_no = $no");
                        }

                        $resumeNo = $no;
                    } else {
                        mysql_query("UPDATE member_extend SET resume_count = $resumeCount WHERE uid = '$uid'");
                    }

                    for($i=0; $i<count($workDate); $i++) {
                        $resumeDate = date("Y-m-d", strtotime($workDate[$i]));

                        $sql = "INSERT INTO resume_date(date, work_resume_data_no) VALUES ('$resumeDate', $resumeNo)";
                        $result = mysql_query($sql);
                    }

                    echo "<script>alert('".$success."');</script>";
                    echo "<script>document.location.href = '../../gujik.php?tab=2';</script>";
                } else {
                    echo "<script>alert('".$fail."');</script>";
                    echo "<script>history.back();</script>";
                }
            }
        }
    }
?>