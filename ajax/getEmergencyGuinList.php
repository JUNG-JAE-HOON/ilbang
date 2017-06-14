<?php
    include_once "../db/connect.php";

    // $sql   = "  SELECT                          ";  
    // $sql  .= "     A.no                          ";
    // $sql  .= " ,   A.title                          ";
    // $sql  .= " ,   A.company                    ";
    // $sql  .= " ,   A.keyword                    ";
    // $sql  .= " ,   A.pay                        ";
    // $sql  .= " ,   B.img_url                    ";
    // $sql  .= "  FROM work_employ_data A         ";
    // $sql  .= "      LEFT OUTER JOIN company B   ";
    // $sql  .= "  ON A.member_no = B.member_no    ";
    // $sql  .= "  WHERE 1=1                       ";
    // $sql  .= "  AND A.keyword != ''             ";
    // $sql  .= "  AND A.emergency_check = 1       ";
    // $sql  .= "  AND A.view = 'yes'              ";
    // $sql  .= "  ORDER BY A.wdate desc           ";
    // $sql  .= "  limit 0, 10                     ";

    // $listData = array();
    // $result = mysql_query($sql, $ilbang_con);
    // while($row = mysql_fetch_array($result)) {
    //     $oneData ["no"]      = $row["no"];
    //     $oneData ["title"] = $row["title"];
    //     $oneData ["company"] = $row["company"];
    //     $keyword             = explode(",",$row["keyword"]);

    //     $oneData ["area_1st_nm"] = $keyword[0];
    //     $oneData ["area_2nd_nm"] = $keyword[1];
    //     $oneData ["area_3rd_nm"] = $keyword[2];
    //     $oneData ["work_1st_nm"] = $keyword[3];
    //     $oneData ["work_2nd_nm"] = $keyword[4];

    //     $oneData ["pay"] = number_format($row["pay"]);

    //     $oneData ["img_url"]     = $row["img_url"];


    //     $listData[] = $oneData;

    // }

    $sql = "SELECT A.company, A.title, A.pay, A.keyword, A.no ,C.img_url
                 FROM work_employ_data A JOIN em_last_date B JOIN company C
                 WHERE A.no = B.work_employ_data_no AND A.member_no = C.member_no
                 AND A.emergency_check = 1 AND A.keyword != '' AND A.view = 'yes' AND B.last_date > NOW()
                 ORDER BY A.wdate DESC LIMIT 0,10";
    $result = mysql_query($sql);

    while($arr = mysql_fetch_array($result)) {
        $data["no"] = $arr["no"];
        $data["title"] = $arr["title"];
        $data["company"] = $arr["company"];

        $keyword = explode(",", $arr["keyword"]);
        $data["area_1st_nm"] = $keyword[0];
        $data["area_2nd_nm"] = $keyword[1];
        $data["area_3rd_nm"] = $keyword[2];
        $data["work_1st_nm"] = $keyword[3];
        $data["work_2nd_nm"] = $keyword[4];
        $data["pay"] = number_format($arr["pay"]);
        $data["img_url"] = $arr["img_url"];

        $listData[] = $data;
    }

    echo json_encode(array('listData' => $listData));
?>