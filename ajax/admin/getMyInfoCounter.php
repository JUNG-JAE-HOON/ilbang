<?php
    include_once "../../db/connect.php";
  

    $adminId     = $_POST['adminId'];

    //$adminId	= "GIGA";

    $sql  = "   SELECT COUNT(*) as myRecmdCnt       ";
    $sql .= "   FROM member                         ";
    $sql .= "   WHERE 1=1                           ";
    $sql .= "   AND reuid = '$adminId'              "; 

    $result = mysql_query($sql, $ilbang_con);
    $arr = mysql_fetch_array($result);

    $myRecmdCnt = $arr[0];

    // while($row = mysql_fetch_array($result)){

    //         $myRecmdCnt            = $row["myRecmdCnt"];
    // }


    $sql  = "   SELECT COUNT(B.no) as totalGuinCnt      ";
    $sql .= "   FROM member A, work_employ_data B       ";
    $sql .= "   WHERE 1=1                               ";
    $sql .= "   AND reuid = '$adminId'                  ";
    $sql .= "   AND A.no = B.member_no                  ";
    $sql .= "   AND A.kind = 'company'                  ";
    $sql .= "   AND B.view = 'yes'                      ";


    $result = mysql_query($sql, $ilbang_con);
    $arr = mysql_fetch_array($result);

    $totalGuinCnt = $arr[0];

    // while($row = mysql_fetch_array($result)){

    //         $totalGuinCnt           = $row["totalGuinCnt"];
    // }

    $sql  = "   SELECT COUNT(B.no) as totalGujikCnt ";
    $sql .= "   FROM member A, work_resume_data B   ";
    $sql .= "   WHERE 1=1                           ";
    $sql .= "   AND reuid = '$adminId'              ";
    $sql .= "   AND A.no = B.member_no              ";
    $sql .= "   AND A.kind = 'general'              ";
    $sql .= "   AND B.view = 'yes'                  ";


    $result = mysql_query($sql, $ilbang_con);
    $arr = mysql_fetch_array($result);

    $totalGujikCnt = $arr[0];

    // while($row = mysql_fetch_array($result)){

    //         $totalGujikCnt           = $row["totalGujikCnt"];
    // }

    echo json_encode(array('myRecmdCnt' => $myRecmdCnt, 'totalGuinCnt' => $totalGuinCnt, 'totalGujikCnt' => $totalGujikCnt));
?>