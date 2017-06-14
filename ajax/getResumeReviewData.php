<?php
    include_once "../include/session.php";
    include_once "../db/connect.php";

    $resumeNo = $_POST["resumeNo"];

    $sql  = " SELECT B.age, C.name, B.sex, B.img_url, A.uid as ruid";
    $sql .= " FROM work_resume_data A";
    $sql .= ", member_extend B";
    $sql .= ", member C";
    $sql .= " WHERE 1=1";
    $sql .= " AND A.no = '$resumeNo'";
    $sql .= " AND A.member_no = B.member_no";
    $sql .= " AND A.member_no = C.no";
    $result = mysql_query($sql, $ilbang_con);

     $name = "";
     $age = "";
     $sex = "";
     $img_url = "";
     $ruid = "";

    while($row = mysql_fetch_array($result)) {
        $name = $row["name"];
        $age = $row["age"];
        $sex = $row["sex"];
        $img_url = $row["img_url"];
        $ruid = $row["ruid"];

        if ($sex == "male")    $sex = "남자";
        else if ($sex == "female")  $sex = "여자";
        else if ($sex == "nothing") $sex = "무관";  
    }

    $sql  = "SELECT no as work_join_list_no";
    $sql .= ",  work_date";
    $sql .= ", euid";
    $sql .= ", ruid";
    $sql .= " FROM work_join_list";
    $sql .= " WHERE 1=1";
    $sql .= " AND euid = '$uid'";
    $sql .= " AND choice = 'yes'";
    $sql .= " AND work_resume_data_no = '$resumeNo'";
    $result = mysql_query($sql, $ilbang_con);
 
    $listData = array();
        
    while($row = mysql_fetch_array($result)) {
        $oneData["work_join_list_no"] = $row["work_join_list_no"];
        $oneData["work_date"] = $row["work_date"]; 
        $euid = $row["euid"];

        $listData[] = $oneData;  
    }

    $sql  = "SELECT ifnull(AVG(score),0) as totalScore";
    $sql .= " FROM resume_review";
    $sql .= " WHERE ruid = '$ruid'";
    $result = mysql_query($sql, $ilbang_con);

    while($row = mysql_fetch_array($result)) {
        $totalScore = round($row["totalScore"],1);
    }

    $sql   = "     SELECT  no            ";
    $sql  .= "         ,   ruid          ";
    $sql  .= "         ,   euid          ";
    $sql  .= "         ,   score         ";
    $sql  .= "         ,   content       ";
    $sql  .= "         ,   wdate         ";
    $sql  .= "     FROM resume_review    ";
    $sql  .= "     WHERE 1=1             ";
    $sql  .= "     AND ruid = '$ruid'    ";
    $sql  .= "     ORDER BY wdate desc   ";
    $result = mysql_query($sql, $ilbang_con);

    $reviewList = array();

    while($row = mysql_fetch_array($result)){
        $reviewData["no"]         = $row["no"];
        $reviewData["ruid"]       = $row["ruid"];
        $reviewData["score"]      = $row["score"]; 
        $reviewData["content"]    = $row["content"]; 
        $reviewData["wdate"]       = date("Y-m-d H:i", strtotime($row["wdate"])); 

        if($uid == $row["ruid"]) {
            $reviewData["script"] = '<a href="javascript:reviewDelete('.$reviewData["no"].')" class="reivewBtn">삭제</a>';
        } else {
            $reviewData["script"] = '';
        }
        
        $reviewList[] = $reviewData;  
    }

    echo json_encode(array('name'=>$name, 'reviewList' => $reviewList,'age'=>$age ,'sex'=>$sex,  'euid' => $euid , 'ruid' => $ruid, 'listData'=>$listData, 'totalScore'=>$totalScore, 'img_url' => $img_url));
?>