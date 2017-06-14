<?php
    header("Cache-Control: no-cache, must-revalidate");
    include_once "../../log/session.php";
    include_once "../../db/connect.php";

    if(isset($_POST["emergency"])) {
        $emergency = $_POST["emergency"];
    } else {
        $emergency = 0;
    }

    //구인 신청서 번호(신청서 수정할 때만 받아옴)
    if(isset($_POST["no"])) {
        $no = $_POST["no"];
    } else {
        $no = "";
    }

    $title = $_POST["title"];                                 //구인 신청서 제목
    $area1 = $_POST["area_1st"];                      //희망 지역 1차
    $area2 = $_POST["area_2nd"];                    //희망 지역 2차
    $work1 = $_POST["work_1st"];                   //희망 직종 1차
    $work2 = $_POST["work_2nd"];                 //희망 직종 2차
    $time = $_POST["time"];                              //희망 근무 시간
    $workDate = trim($_POST["workDate"]);
    $workDate = explode(",", $workDate);      //희망 근무일
    $time = $_POST["time"];                              //희망 근무 시간
    $minAge = $_POST["minAge"];                  //희망 연령대 (최소)
    $maxAge = $_POST["maxAge"];                //희망 연령대 (최대)
    $career = $_POST["career"];                         //필요 경력
    $sex = $_POST["sex"];                                  //희망 성별
    $people = $_POST["people"];                     //모집 인원
    $address = $_POST["address1"].", ".$_POST["address2"];                                         //근무지 주소
    $manager = $_POST["manager"];               // 담당자 이름
    $phone = $_POST["phone1"]."-".$_POST["phone2"]."-".$_POST["phone3"];        //담당자 연락처
    $business = $_POST["business"];                 //담당 업무 내용
    $content = $_POST["contents"];                   //상세 모집 내용
    $wdate = date("Y-m-d H:i:s");

    if($work2 == 8017) {
        $pay = 0;
    } else {
        $pay = $_POST["pay"];                              //희망 일급
    }

    if($uid == "" || $uid == null) {
        echo "<script>alert('로그인 후 이용해주세요.');</script>";
        echo "<script>history.back();</script>";
    } else {
        if($title == "" || $business == "" || $area1 == "" || $area2 == "" || $work1 == "" || $work2 == "" || $sex == "" || $content == "" || $people == 0 || $manager == "" || $phone == "--") {
            echo "<script>alert('입력 내용 혹은 개인 정보를 확인해주세요.\n(내용 누락 및 연락처 확인 불가)');</script>";
            echo "<script>history.back();</script>";
        } else {
            //------------------------------------------------------------$
            //                       기업 회원 정보 조회
            //------------------------------------------------------------
            $sql = "SELECT company, member_no, valid_no, employ_count FROM company WHERE uid = '$uid'";
            $result = mysql_query($sql);
            $arr = mysql_fetch_array($result);

            $company = $arr["company"];               //회사 이름
            $memberNo = $arr["member_no"];      //회원 번호
            $validNo = $arr["valid_no"];                   //본인 인증 번호
            $employCount = $arr["employ_count"] - 1;

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

            if($no == "") {
                //긴급 구인 아이템이 있는지 없는지 확인. 없으면 emergency 0으로 만듬.
                if($emergency != 0) {
                    $sql = "SELECT COUNT(*) AS cnt, item_id, no FROM work_item where uid ='$uid' AND item_kind = 'emergency' AND count > 0";
                    $result = mysql_query($sql);
                    $arr = mysql_fetch_array($result);

                    if($arr["cnt"] == 0) {
                        $emergency = 0;
                        $message = "긴급 구인 아이템이 없어 일반 구인으로 등록됩니다.";
                    } else {
                        $itemNo = $arr["no"];
                        $itemID = $arr["item_id"];

                        $sql = "SELECT item_id FROM item_data WHERE id = $itemID";
                        $result = mysql_query($sql);
                        $arr = mysql_fetch_array($result);

                        $itemID = $arr["item_id"];
                    }
                }

                //------------------------------------------------------------
                //                        구인 신청서 등록
                //------------------------------------------------------------
                $sql = "INSERT INTO work_employ_data(company, title, business, area_1st, area_2nd, area_3rd, work_1st, work_2nd, age_1st, age_2nd,
                             sex, career, pay, content, wdate, people_num, address, time, member_no, valid_no, uid, manager, phone, emergency_check, keyword, edit_date, location)
                             VALUES ('$company', '$title', '$business', '$area1', '$area2', '10001', '$work1', '$work2', '$minAge', '$maxAge',
                             '$sex', '$career', '$pay', '$content', '$wdate', '$people', '$address', '$time', '$memberNo', '$validNo', '$uid', '$manager', '$phone', '$emergency', '$keyword', '$wdate', 'PC')";
            } else {
                //------------------------------------------------------------
                //                        구인 신청서 수정
                //------------------------------------------------------------
                $sql = "UPDATE work_employ_data SET company = '$company', title = '$title', business = '$business', area_1st = '$area1', area_2nd = '$area2', work_1st = '$work1',
                             work_2nd = '$work2', age_1st = '$minAge', age_2nd = '$maxAge', sex = '$sex', career = '$career', pay = '$pay', content = '$content', people_num = '$people',
                             address = '$address', time = '$time', manager = '$manager', phone = '$phone', keyword = '$keyword', edit_date = '$wdate', location = 'PC_modify'
                             WHERE no = $no";
            }

            $result = mysql_query($sql);

            if($result) {
                //------------------------------------------------------------
                //                       구인 날짜별로 등록
                //------------------------------------------------------------
                $sql = "SELECT no, people_num FROM work_employ_data WHERE uid = '$uid' ORDER BY wdate DESC";
                $result = mysql_query($sql);
                $arr = mysql_fetch_array($result);

                $employNo = $arr[0];
                $peopleNum = $arr[1];

                $success = "채용 공고가 작성되었습니다.";
                $fail = "채용 공고  작성 실패";

                if($no != "") {
                    //------------------------------------------------------------
                    //              구인 날짜별로 등록(수정할 때)
                    //------------------------------------------------------------
                    mysql_query("DELETE FROM employ_date WHERE work_employ_data_no = $no");

                    $sql = "SELECT COUNT(*) FROM work_join_list WHERE work_employ_data_no = $no";
                    $result = mysql_query($sql);
                    $arr = mysql_fetch_array($result);

                    $employNum = $arr[0];

                    if($employNum > 0) {
                        mysql_query("DELETE FROM work_join_list WHERE work_employ_data_no = $no");
                    }

                    $employNo = $no;

                    $success = "채용 공고가 수정되었습니다.";
                    $fail = "채용 공고 수정 실패";
                } else {
                    mysql_query("UPDATE company SET employ_count = $employCount WHERE uid = '$uid'");

                    if($emergency != 0) {
                        $lastWorkDay = $workDate[count($workDate) - 1];
                        
                        mysql_query("INSERT INTO em_last_date(work_employ_data_no, last_date) VALUES ($employNo, '$lastWorkDay')");
                        mysql_query("INSERT INTO item_use_log(user_id, item_name, use_date) VALUES ('$uid', '$itemID', '$wdate')");
                        mysql_query("UPDATE work_item SET count = count - 1 WHERE no = $itemNo");
                    }
                }

                for($i=0; $i<count($workDate); $i++) {
                    $workDay = $workDate[$i];

                    $sql = "INSERT INTO employ_date(date, connect_num, work_employ_data_no) VALUES ('$workDay', '$peopleNum', $employNo)";
                    $result = mysql_query($sql);
                }

                echo "<script>alert('".$success.'\n'.$message."');</script>";
                echo "<script>document.location.href = '../../guin.php?tab=2';</script>";
            } else {
                echo "<script>alert('".$fail."');</script>";
                echo "<script>history.back();</script>";
            }
        }
    }
?>