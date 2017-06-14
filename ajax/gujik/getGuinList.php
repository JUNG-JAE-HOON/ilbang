<?php
    include_once "../db/connect.php";

    if(isset($_POST['page'])) {
        $page = $_POST['page'];
    } else {
        $page = 1;
    }
  
    $guinArea1st            = $_POST['guinArea1st'];
    $guinArea2nd            = $_POST['guinArea2nd'];
    $guinArea3rd            = $_POST['guinArea3rd']; 
    $guinWork1st            = $_POST['guinWork1st']; 
    $guinWork2nd            = $_POST['guinWork2nd']; 
    $guinAge                = $_POST['guinAge']; 
    $guinPay                = $_POST['guinPay']; 
    $guinPayIsUnrelated     = $_POST['guinPayIsUnrelated']; 
    $guinTime               = $_POST['guinTime']; 
    $guinGender             = $_POST['guinGender']; 
    $guinCareer             = $_POST['guinCareer']; 
    $guinCareerIsUnrelated  = $_POST['guinCareerIsUnrelated']; 

/*
    $guinArea1st            = "1";
    $guinArea2nd            = "";
    $guinArea3rd            = ""; 
    $guinWork1st            = ""; 
    $guinWork2nd            = ""; 
    $guinAge                = "unrelated"; 
    $guinPay                = ""; 
    $guinPayIsUnrelated     = ""; 
    $guinTime               = "unrelated"; 
    $guinGender             = "nothing"; 
    $guinCareer             = ""; 
    $guinCareerIsUnrelated  = ""; 
*/

    //-- ,  ROUND(6371 * acos( cos( radians(35.5058023792) ) * cos( radians(lat) ) * cos( radians(lng) - radians(129.4417746378) ) + sin( radians(35.5058023792) ) * sin( radians(lat) ) ),2) as distance
    $sql  = " SELECT  count(*) cnt ";
    $sql .= " FROM work_employ_data A ";
    $sql .= " WHERE 1=1 ";
    $sql .= " AND A.view = 'yes' ";

         if ($guinArea1st!='' && $guinArea2nd=='' && $guinArea3rd=='')     $sql .= " AND A.area_1st = '$guinArea1st' ";
    else if ($guinArea1st!='' && $guinArea2nd!='' && $guinArea3rd=='')     $sql .= " AND A.area_2nd = '$guinArea2nd' ";
    else if ($guinArea1st!='' && $guinArea2nd!='' && $guinArea3rd!='')     $sql .= " AND A.area_3rd = '$guinArea3rd' ";
     
         if ($guinWork1st != '')                                           $sql .= " AND A.work_1st = '$guinWork1st' ";
    else if ($guinWork2nd != '')                                           $sql .= " AND A.work_2nd = '$guinWork2nd' ";

         if ($guinAge               != 'unrelated'  )                      $sql .= " AND '$guinAge' BETWEEN A.age_1st AND A.age_2nd";
         if ($guinPayIsUnrelated    != 'Y'          )                      $sql .= " AND A.pay = '$guinPay' ";
         if ($guinTime              != 'unrelated'  )                      $sql .= " AND A.time = '$guinTime' ";
         if ($guinGender            != 'unrelated'  )                      $sql .= " AND A.sex = '$guinGender' ";
         if ($guinCareerIsUnrelated != 'Y'          )                      $sql .= " AND A.career = '$career' ";

        

    $result = mysql_query($sql, $ilbang_con);
        
    while($row = mysql_fetch_array($result)){
             $allPost = $row["cnt"];    // 전체 게시글 수
    }

    //$allPost = $row['cnt']; //전체 게시글의 수

    $onePage = 5; // 한 페이지에 보여줄 게시글의 수.
    $allPage = ceil($allPost / $onePage); //전체 페이지의 수

    $oneSection = 5; //한번에 보여줄 총 페이지 개수(1 ~ 10, 11 ~ 20 ...)
    $currentSection = ceil($page / $oneSection); //현재 섹션
    $allSection = ceil($allPage / $oneSection); //전체 섹션의 수

    $firstPage = ($currentSection * $oneSection) - ($oneSection - 1); //현재 섹션의 처음 페이지

    if ($allPost == 0){
        $lastPage = 1;
        $currentSection = 1;
        $allSection = 1;
    
    } else if($currentSection == $allSection) {
        $lastPage = $allPage; //현재 섹션이 마지막 섹션이라면 $allPage가 마지막 페이지가 된다.
    } else {
        $lastPage = $currentSection * $oneSection; //현재 섹션의 마지막 페이지
    }

    $prevPage = (($currentSection - 1) * $oneSection); //이전 페이지, 11~20일 때 이전을 누르면 10 페이지로 이동.
    $nextPage = (($currentSection + 1) * $oneSection) - ($oneSection - 1); //다음 페이지, 11~20일 때 다음을 누르면 21 페이지로 이동.        
    


    $currentLimit = ($onePage * $page) - $onePage; //몇 번째의 글부터 가져오는지
    $sqlLimit = ' limit ' . $currentLimit . ', ' . $onePage;
    
    $sql   = " SELECT  A.no       ";
    $sql  .= "      ,  A.keyword  ";
    $sql  .= "      ,  A.title    ";
    $sql  .= "      ,  A.business ";
    $sql  .= "      ,   A.career  ";
    $sql  .= "      ,   A.pay     ";
    $sql  .= "      ,   A.sex     ";
    $sql  .= "      ,   A.age_1st ";
    $sql  .= "      ,   A.age_2nd ";
    $sql  .= "      ,   A.time    ";
    $sql  .= "      ,   A.wdate   ";
    $sql  .= " FROM work_employ_data A ";
    $sql  .= " WHERE 1=1 ";
    $sql  .= " AND A.view = 'yes' ";

         if ($guinArea1st!='' && $guinArea2nd=='' && $guinArea3rd=='')     $sql .= " AND A.area_1st = '$guinArea1st' ";
    else if ($guinArea1st!='' && $guinArea2nd!='' && $guinArea3rd=='')     $sql .= " AND A.area_2nd = '$guinArea2nd' ";
    else if ($guinArea1st!='' && $guinArea2nd!='' && $guinArea3rd!='')     $sql .= " AND A.area_3rd = '$guinArea3rd' ";
     
         if ($guinWork1st != '')                                           $sql .= " AND A.work_1st = '$guinWork1st' ";
    else if ($guinWork2nd != '')                                           $sql .= " AND A.work_2nd = '$guinWork2nd' ";

         if ($guinAge               != 'unrelated'  )                      $sql .= " AND '$guinAge' BETWEEN A.age_1st AND A.age_2nd";
         if ($guinPayIsUnrelated    != 'Y'          )                      $sql .= " AND A.pay = '$guinPay' ";
         if ($guinTime              != 'unrelated'  )                      $sql .= " AND A.time = '$guinTime' ";
         if ($guinGender            != 'unrelated'  )                      $sql .= " AND A.sex = '$guinGender' ";
         if ($guinCareerIsUnrelated != 'Y'          )                      $sql .= " AND A.career = '$career' ";

   $sql .= " ORDER BY A.wdate desc $sqlLimit";       

    $result = mysql_query($sql, $ilbang_con);


    $listData =array();
    while($row = mysql_fetch_array($result)){
            //$oneData["keyword"]   = $row["keyword"];
        
            $keyword = explode(",",$row["keyword"]);
        
            $oneData["area_1st_nm"] = $keyword[0];
            $oneData["area_2nd_nm"] = $keyword[1];
            $oneData["area_3rd_nm"] = $keyword[2];
            $oneData["work_1st_nm"] = $keyword[3];
            $oneData["work_2nd_nm"] = $keyword[4];

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

            $listData[]           = $oneData;
    }

    $paging["page"]           = $page;
    $paging["currentSection"] = $currentSection;
    $paging["allSection"]     = $allSection;
    $paging["allPage"]        = $allPage;
    $paging["prevPage"]       = $prevPage;
    $paging["nextPage"]       = $nextPage;
    $paging["lastPage"]       = $lastPage;
    $paging["firstPage"]      = $firstPage;
    $paging["allPost"]        = $allPost;

    $searchCondition["areaCd"] = $areaCd;
    $searchCondition["workCd"] = $workCd;


    echo json_encode(array('listData' => $listData, 'paging'=>$paging, 'searchCondition'=>$searchCondition ));



?>