
<?php
    include_once "../../db/connect.php";

    $uid      = $_POST['uid'];
    $resumeNo = $_POST["resumeNo"];

    $sql  = " SELECT B.name, A.title, A.keyword, C.sex, C.age, A.career, C.obstacle, C.email, C.phone, A.time, A.pay, A.content ";
    $sql .= " FROM   work_resume_data A                                                                                         ";
    $sql .= "    , member B                                                                                                     ";
    $sql .= "    , member_extend C                                                                                              ";
    $sql .= " WHERE 1=1                             ";
    $sql .= " AND A.no = '$resumeNo'                ";
    $sql .= " AND A.member_no = B.no                ";
    $sql .= " AND A.member_no = C.member_no         ";


    $resumeData = array();
    while($row = mysql_fetch_array($result)){
             $oneData["name"]   = $row["name"];
             $oneData["title"]  = $row["title"];
             //$keyword   = $row["keyword"];
             $keyword = explode(",",$row["keyword"]);

             $oneData["area_1st_nm"] = $keyword[0];
             $oneData["area_2nd_nm"] = $keyword[1];
             $oneData["area_3rd_nm"] = $keyword[2];
             $oneData["work_1st_nm"] = $keyword[3];
             $oneData["work_2nd_nm"] = $keyword[4];

             $oneData["sex"]       = $row["sex"];
             $oneData["age"]       = $row["age"];
             $oneData["career"]    = $row["career"];
             $oneData["obstacle"]  = $row["obstacle"];
             $oneData["email"]     = $row["email"];
             $oneData["phone"]     = $row["phone"];;
             $oneData["time"]      = $row["time"];
             $oneData["pay"]       = $row["pay"];
             $oneData["content"]   = $row["content"];


                 if ($oneData["sex"] == "male")    $oneData["sex"] = "남자";
            else if ($oneData["sex"] == "female")  $oneData["sex"] = "여자";
            else if ($oneData["sex"] == "nothing") $oneData["sex"] = "무관"; 

                 if ($oneData["time"]  == "1")  $oneData["time"]  = "오전";
            else if ($oneData["time"]  == "2")  $oneData["time"]  = "오후";
            else if ($oneData["time"]  == "3")  $oneData["time"]  = "저녁";
            else if ($oneData["time"]  == "4")  $oneData["time"]  = "새벽";
            else if ($oneData["time"]  == "5")  $oneData["time"]  = "오전~오후";
            else if ($oneData["time"]  == "6")  $oneData["time"]  = "오후~저녁";
            else if ($oneData["time"]  == "7")  $oneData["time"]  = "저녁~새벽";
            else if ($oneData["time"]  == "8")  $oneData["time"]  = "새벽~오전";
            else if ($oneData["time"]  == "9")  $oneData["time"]  = "풀타임";
            else if ($oneData["time"]  == "10") $oneData["time"]  = "무관/협의";

           
            $resumeData[] = $oneData; 

    }



    $sql  = " SELECT work_date                      ";
    $sql .= " FROM work_join_list                   ";
    $sql .= " WHERE work_employ_data_no IN (        ";
    $sql .= " SELECT no                             ";
    $sql .= " FROM work_employ_data                 ";
    $sql .= " WHERE uid = '$uid')                   ";
    $sql .= " AND work_resume_data_no = '$resumeNo' ";

    $workDateList = array();
    $oneData      = array();

    while($row = mysql_fetch_array($result)){
             $oneData["work_date"] = $row["work_date"];

             $workDateList[] = $oneData;  
    }



    echo json_encode(array('resumeData' => $resumeData,'workDateList' => $workDateList));



?>