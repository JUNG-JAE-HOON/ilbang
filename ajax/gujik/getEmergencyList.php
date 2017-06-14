<?php
    include_once "../../db/connect.php";

   
    
    $sql   = " SELECT  A.no       ";
    $sql  .= "      ,  A.company  ";
    $sql  .= "      ,  A.keyword  ";
    $sql  .= "      ,  A.title    ";
    $sql  .= "      ,  A.business ";
    $sql  .= "      ,   A.career  ";
    $sql  .= "      ,   A.pay     ";
    $sql  .= "      ,   A.sex     ";
    $sql  .= "      ,   A.lat     ";
    $sql  .= "      ,   A.lng     ";
    $sql  .= "      ,   A.age_1st ";
    $sql  .= "      ,   A.age_2nd ";
    $sql  .= "      ,   A.time    ";
    $sql  .= "      ,   A.wdate   ";
    $sql  .= "      ,   B.img_url   ";
    $sql  .= " FROM work_employ_data A ";
    $sql  .= " JOIN company B ";
    $sql  .= " WHERE A.member_no = B.member_no";
    $sql  .= " AND A.view = 'yes' and A.emergency_check='1'";

      

   $sql .= " ORDER BY A.wdate desc limit 0, 8";       
 // echo $sql."<br>";
    $result = mysql_query($sql, $ilbang_con);


    $listData =array();
    while($row = mysql_fetch_array($result)){
            //$oneData["keyword"]   = $row["keyword"];
        
            $keyword = explode(",",$row["keyword"]);
            $oneData["no"] = $row["no"];
            $oneData["area_1st_nm"] = $keyword[0];
            $oneData["area_2nd_nm"] = $keyword[1];
            $oneData["area_3rd_nm"] = $keyword[2];
            $oneData["work_1st_nm"] = $keyword[3];
            $oneData["work_2nd_nm"] = $keyword[4];
            $oneData["company"]     = $row["company"];
            $oneData["title"]     = $row["title"];
            $oneData["business"]  = $row["business"];
            $oneData["career"]    = $row["career"];
            $oneData["pay"]       = $row["pay"];
            $oneData["sex"]       = $row["sex"];
            $oneData["age_1st"]   = $row["age_1st"];
            $oneData["age_2nd"]   = $row["age_2nd"];
            $oneData["time"]      = number_format($row["pay"]);
            $oneData["lat"]       = $row["lat"];
            $oneData["lng"]       = $row["lng"];
            $oneData["img_url"]       = $row["img_url"];

            $listData[]           = $oneData;
    }

 

    echo json_encode(array('listData' => $listData));



?>