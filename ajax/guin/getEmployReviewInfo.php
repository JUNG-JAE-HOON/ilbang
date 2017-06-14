<?php
    include_once "../../include/session.php";
    include_once "../../db/connect.php";

    $employNo = $_POST["employNo"];

    $sql  = " SELECT A.company, B.age, C.name, B.sex, D.img_url, A.uid ";
    $sql .= " FROM work_employ_data A                   ";
    $sql .= "    , member_extend B                      ";
    $sql .= "    , member C                             ";
    $sql .= "    , company D                            ";
    $sql .= " WHERE A.no = '$employNo'                  ";
    $sql .= " AND A.member_no = B.member_no             ";
    $sql .= " AND A.member_no = C.no                    ";
    $sql .= " AND A.member_no = D.member_no             ";
    $result = mysql_query($sql, $ilbang_con);

    $company   = "";
    $age       = "";
    $sex       = "";
    $img_url   = "";
    $euid      = "";

    while($row = mysql_fetch_array($result)) {
        $company   = $row["company"];
        $age       = $row["age"];
        $sex       = $row["sex"];
        $img_url   = $row["img_url"];
        $euid      = $row["uid"];
        $age = substr($age, 0, 1) . "0"; 

        if ($sex == "male")    $sex = "남자";
        else if ($sex == "female")  $sex = "여자";
        else if ($sex == "nothing") $sex = "무관";  
    }

    $sql  = " SELECT no as work_join_list_no            ";
    $sql .= "       , work_date            ";
    $sql .= "       , euid                              ";
    $sql .= "       , ruid                              ";
    $sql .= "   FROM work_join_list                     ";
    $sql .= "   WHERE 1=1                               ";
    $sql .= "   AND ruid = '$uid'                       ";
    $sql .= "   AND choice = 'yes'                      ";
    $sql .= "   AND work_employ_data_no = '$employNo'   ";
    $result = mysql_query($sql, $ilbang_con);

    $listData          = array();
        
    while($row = mysql_fetch_array($result)){
        $oneData["work_join_list_no"] = $row["work_join_list_no"];
        $oneData["work_date"]         = $row["work_date"];

        $listData[] = $oneData;  
    }

    $sql  = " SELECT ifnull(AVG(score),0) as totalScore ";
    $sql .= " FROM employ_review                        ";
    $sql .= " WHERE euid = '$euid'                      ";
    $result = mysql_query($sql, $ilbang_con);

    while($row = mysql_fetch_array($result)) {
        $totalScore = round($row["totalScore"],1);
    }

    $sql   = "     SELECT  no            ";
    $sql  .= "         ,   euid          ";
    $sql  .= "         ,   score         ";
    $sql  .= "         ,   content       ";
    $sql  .= "         ,   wdate         ";
    $sql  .= "     FROM employ_review    ";
    $sql  .= "     WHERE 1=1             ";
    $sql  .= "     AND euid = '$euid'    ";
    $sql  .= "     ORDER BY wdate desc   ";
    $result = mysql_query($sql, $ilbang_con);

    $reviewList = array();

    while($row = mysql_fetch_array($result)) {
        $reviewData["no"]         = $row["no"];
        $reviewData["score"]      = $row["score"]; 
        $reviewData["content"]    = $row["content"]; 
        $reviewData["wdate"]       = date("Y-m-d H:i", strtotime($row["wdate"])); 

        if($uid == $row["euid"]) {
            $reviewData["script"] = '<a href="javascript:reviewDelete('.$row["no"].')" class="reivewBtn">삭제</a>';
        } else {
            $reviewData["script"] = '';
        }

        $reviewList[] = $reviewData;  
    }

    echo json_encode(array('reviewList' => $reviewList, 'company' => $company, 'age'=>$age , 'sex'=>$sex, 'euid' => $euid , 'listData'=>$listData, 'totalScore'=>$totalScore, 'img_url' => $img_url));
?>