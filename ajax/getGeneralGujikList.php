<?php
    include_once "../db/connect.php";

    // 메인 일반 구직 정보
/*
SELECT  
     A.no
    ,A.title
    ,A.keyword
    ,B.img_url
    ,C.name
    ,B.sex
    ,A.pay
    ,A.career
FROM work_resume_data A
    LEFT OUTER JOIN member_extend B
    ON A.member_no = B.member_no  
    , member C  
WHERE 1=1
AND A.member_no = C.no
AND A.keyword != ''
AND A.view = 'yes'
ORDER BY A.wdate desc
limit 0, 10;
*/

    $sql  = " SELECT                                    ";  
    $sql .= "       A.no                                ";
    $sql .= "     ,A.title                              ";
    $sql .= "     ,A.keyword                            ";
    $sql .= "     ,B.img_url                            ";
    $sql .= "     ,C.name                               ";
    $sql .= "     ,B.sex                                ";
    $sql .= "     ,A.pay                                ";
    $sql .= "     ,A.career                             ";
    $sql .= "     ,B.age                                ";
    $sql .= " FROM work_resume_data A                   ";
    $sql .= "     LEFT OUTER JOIN member_extend B       ";
    $sql .= " ON A.member_no = B.member_no              ";
    $sql .= " , member C                                ";
    $sql .= " WHERE 1=1                                 ";
    $sql .= " AND A.member_no = C.no                    ";
    $sql .= " AND A.keyword != ''                       ";
    $sql .= " AND A.view = 'yes'                        ";
    $sql .= " ORDER BY A.wdate desc                     ";
    $sql .= " limit 0, 10                               ";

    $listData = array();
    $result = mysql_query($sql, $ilbang_con);
    while($row = mysql_fetch_array($result)) {

        $oneData ["img_url"] = $row["img_url"];
        $oneData ["no"]      = $row["no"];
        $oneData ["title"]   = $row["title"];
        $keyword             = explode(",",$row["keyword"]);

        $oneData ["area_1st_nm"] = $keyword[0];
        $oneData ["area_2nd_nm"] = $keyword[1];
        $oneData ["area_3rd_nm"] = $keyword[2];
        $oneData ["work_1st_nm"] = $keyword[3];
        $oneData ["work_2nd_nm"] = $keyword[4];

        $oneData ["name"]   = $row["name"];
        $oneData ["sex"]    = $row["sex"];
        $oneData ["pay"]    = $row["pay"];
        $oneData ["career"] = $row["career"];
        $oneData ["age"]    = $row["age"];

        $oneData["name"] = mb_substr($oneData["name"], 0, 1, 'utf-8') . "OO";

             if ($oneData["sex"] == "male")     $oneData["sex"] = "남자";
        else if ($oneData["sex"] == "female")   $oneData["sex"] = "여자";
        else if ($oneData["sex"] == "nothing") $oneData["sex"] = "무관";  

             if ($oneData["career"] == "-1")  $oneData["career"] = "무관";
        else if ($oneData["career"] == "0")   $oneData["career"] = "신입";
        else if ($oneData["career"] == "1")   $oneData["career"] = "1년 미만";  
        else if ($oneData["career"] == "3")   $oneData["career"] = "3년 미만";  
        else if ($oneData["career"] == "5")   $oneData["career"] = "5년 미만";  
        else if ($oneData["career"] == "6")   $oneData["career"] = "5년 이상";  

        $oneData["age"] = substr($oneData["age"], 0, 1) . "0";

        $listData[] = $oneData;

    }  

    echo json_encode(array('listData' => $listData));

?>

