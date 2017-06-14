<?php
    include_once "../db/connect.php";


    $sql  = " SELECT   A.no             ";
    $sql .= "         ,A.company        ";
    $sql .= "         ,A.keyword        ";
    $sql .= "         ,B.img_url        ";
    $sql .= " FROM work_employ_data A   ";
    $sql .= " LEFT OUTER JOIN company B ";
    $sql .= " ON A.member_no = B.member_no ";
    $sql .= " WHERE 1=1                     ";
    $sql .= " AND A.keyword != ''           ";
    $sql .= " AND A.view = 'yes'            "; 
    $sql .= " ORDER BY A.wdate desc         ";
    $sql .= " limit 0, 10                   ";


    $listData = array();
    $result = mysql_query($sql, $ilbang_con);
    while($row = mysql_fetch_array($result)) {
        $oneData ["no"]      = $row["no"];
        $oneData ["company"] = $row["company"];
        $oneData ["img_url"] = $row["img_url"];
        
        $keyword             = explode(",",$row["keyword"]);

        $oneData ["area_1st_nm"] = $keyword[0];
        $oneData ["area_2nd_nm"] = $keyword[1];
        $oneData ["area_3rd_nm"] = $keyword[2];
        $oneData ["work_1st_nm"] = $keyword[3];
        $oneData ["work_2nd_nm"] = $keyword[4];

        $listData[] = $oneData;

    }  

    echo json_encode(array('listData' => $listData));

?>

