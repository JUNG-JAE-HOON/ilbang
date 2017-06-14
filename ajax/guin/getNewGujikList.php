<?php
    include_once "../../db/connect.php";
 
    $sql  = "  SELECT A.keyword                         ";
    $sql .= "    ,  A.title                             ";
    $sql .= "    ,  A.no                                ";
    $sql .= "    ,  A.career                            ";
    $sql .= "    ,  A.time                              ";
    $sql .= "    ,  B.img_url                           ";
    $sql .= "    ,  B.sex                           ";
    $sql .= " FROM work_resume_data A, member_extend B  ";
    $sql .= " WHERE 1=1                                 ";
    $sql .= " AND A.keyword != ''                       ";
    $sql .= " AND A.member_no = B.member_no             ";
    $sql .= " ORDER BY wdate desc                       ";
    $sql .= " limit 0, 9                                ";



 
    $result = mysql_query($sql, $ilbang_con);
        
    while($row = mysql_fetch_array($result)){
                   
            $keyword = explode(",",$row["keyword"]);
        
            $oneData["area_1st_nm"] = $keyword[0];
            $oneData["area_2nd_nm"] = $keyword[1];
            $oneData["area_3rd_nm"] = $keyword[2];
            $oneData["work_1st_nm"] = $keyword[3];
            $oneData["work_2nd_nm"] = $keyword[4];

            $oneData["title"]     = $row["title"];
            $oneData["no"]        = $row["no"];
            $oneData["img_url"]   = $row["img_url"];

            $oneData["career"]    = $row["career"];
            $oneData["time"]   = $row["time"];
            $oneData["sex"] = $row["sex"];

                 if ($oneData["time"] == "1")  $oneData["time"] = "오전";
            else if ($oneData["time"] == "2")  $oneData["time"] = "오후";
            else if ($oneData["time"] == "3")  $oneData["time"] = "저녁";
            else if ($oneData["time"] == "4")  $oneData["time"] = "새벽";
            else if ($oneData["time"] == "5")  $oneData["time"] = "오전 ~ 오후";
            else if ($oneData["time"] == "6")  $oneData["time"] = "오후 ~ 저녁";
            else if ($oneData["time"] == "7")  $oneData["time"] = "저녁 ~ 새벽";
            else if ($oneData["time"] == "8")  $oneData["time"] = "새벽 ~ 오전";
            else if ($oneData["time"] == "9")  $oneData["time"] = "풀타임";
            else if ($oneData["time"] == "10") $oneData["time"] = "무관/협의";


          
                 if ($oneData["career"] == "-1")  $oneData["career"] = "무관";
            else if ($oneData["career"] == "0")   $oneData["career"] = "신입";
            else if ($oneData["career"] == "1")   $oneData["career"] = "1년 미만";  
            else if ($oneData["career"] == "3")   $oneData["career"] = "3년 미만";  
            else if ($oneData["career"] == "5")   $oneData["career"] = "5년 미만";  
            else if ($oneData["career"] == "6")   $oneData["career"] = "5년 이상";


            $listData[]           = $oneData;
    }


    echo json_encode(array('listData' => $listData ));



?>