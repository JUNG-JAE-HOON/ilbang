<?php
    include_once "../../db/connect.php";

    $uid      = $_POST['uid'];
    $employNo = $_POST["employNo"];

    // $uid="slslcx";
    // $employNo = 683;
/*
SELECT B.age, C.name, B.sex, B.img_url, A.uid
  FROM work_resume_data A               
    , member_extend B
  , member C
WHERE 1=1
  AND A.no = '$resumeNo'
  AND A.member_no = B.member_no
  AND A.member_no = C.no       ;
*/

    $sql  = " SELECT B.age, C.name, B.sex, D.img_url, A.uid as ruid  ";
    $sql .= " FROM work_employ_data A                         ";
    $sql .= "    , member_extend B                            ";
    $sql .= "    , member C                                   ";
    $sql .= "    , company D                                   ";
    $sql .= " WHERE 1=1                                       ";
    $sql .= " AND A.no = '$employNo'                          ";
    $sql .= " AND A.member_no = B.member_no                   ";
    $sql .= " AND A.member_no = C.no                          ";
    $sql .= " AND A.member_no = D.member_no                          ";

   
    $result = mysql_query($sql, $ilbang_con);

     $name      = "";
     $age       = "";
     $sex       = "";
     $img_url   = "";
     $ruid      = "";

    while($row = mysql_fetch_array($result)){
             $name      = $row["name"];
             $age       = $row["age"];
             $sex       = $row["sex"];
             $img_url   = $row["img_url"];
             $euid      = $row["euid"];

             //$age = substr($age, 0, 1) . "0"; 

                 if ($sex == "male")    $sex = "남자";
            else if ($sex == "female")  $sex = "여자";
            else if ($sex == "nothing") $sex = "무관";  

    }


    $sql  = " SELECT no as work_join_list_no            ";
    $sql .= "       , work_date                         ";
    $sql .= "       , euid                              ";
    $sql .= "       , ruid                              ";
    $sql .= "   FROM work_join_list                     ";
    $sql .= "   WHERE 1=1                               ";
    $sql .= "   AND ruid = '$uid'                       ";
    $sql .= "   AND choice = 'yes'                      ";
    $sql .= "   AND work_employ_data_no = '$employNo'   ";

    $result = mysql_query($sql, $ilbang_con);
    
    $work_join_list_no  = array();
    $work_date          = array();
    $listData          = array();
        
    while($row = mysql_fetch_array($result)){
             $oneData["work_join_list_no"] = $row["work_join_list_no"];
             $oneData["work_date"]         = $row["work_date"]; 
             //$euid                         = $row["euid"];
             $euid                         = $row["euid"];

             $listData[] = $oneData;  
    }


   $sql  = " SELECT ifnull(AVG(score),0) as totalScore ";
   $sql .= " FROM resume_review                        ";
   $sql .= " WHERE euid = '$euid'                      ";

   $result = mysql_query($sql, $ilbang_con);

  while($row = mysql_fetch_array($result)){
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

   while($row = mysql_fetch_array($result)){
             $reviewData["no"]         = $row["no"];
             $reviewData["euid"]       = $row["euid"];
             $reviewData["score"]      = $row["score"]; 
             $reviewData["content"]    = $row["content"]; 
             $reviewData["wdate"]       = $row["wdate"]; 


             $reviewList[] = $reviewData;  
   }



    echo json_encode(array('name'=>$name, 'reviewList' => $reviewList,'company' => $company, 'age'=>$age ,'sex'=>$sex,  'euid' => $euid , 'ruid' => $ruid, 'listData'=>$listData, 'totalScore'=>$totalScore, 'img_url' => $img_url));



?>