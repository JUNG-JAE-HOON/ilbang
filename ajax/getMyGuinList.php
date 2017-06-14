<?php
    include_once "../include/session.php";
    include_once "../db/connect.php";
/*
SELECT 
       A.no
    ,  A.keyword
    ,  A.title
    ,  A.company
    ,  A.business
    ,  A.career
    ,  A.pay
    , (SELECT count(*) 
       FROM work_join_list B
       WHERE 1=1
       AND B.work_employ_data_no = A.no
       ) as matchingCnt
FROM work_employ_data A
WHERE 1=1
AND A.view = 'yes'
AND A.uid = '$uid';
*/
    if(isset($_POST['page'])) {
        $page = $_POST['page'];
    } else {
        $page = 1;
    }

    $uid = $_POST['uid'];


    //-- ,  ROUND(6371 * acos( cos( radians(35.5058023792) ) * cos( radians(lat) ) * cos( radians(lng) - radians(129.4417746378) ) + sin( radians(35.5058023792) ) * sin( radians(lat) ) ),2) as distance

    $sql  = "   SELECT                  "; 
    $sql  .= "        count(*) cnt       ";
    $sql  .= " FROM work_employ_data A   ";
    $sql  .= " WHERE 1=1                 ";
    $sql  .= " AND A.view = 'yes'        ";
    $sql  .= " AND A.uid = '$uid'        ";
            

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
    
    $sql  = " SELECT            ";
    $sql .= "        A.no       ";
    $sql .= "     ,  A.keyword  ";
    $sql .= "     ,  A.wdate    ";
    $sql .= "     ,  A.title    ";
    $sql .= "     ,  A.company  ";
    $sql .= "     ,  A.business ";
    $sql .= "     ,  A.career   ";
    $sql .= "     ,  A.pay                  ";
    $sql .= "     ,  A.delegate ";
    $sql .= "     , (SELECT count(*)        ";
    $sql .= "        FROM work_join_list B  ";
    $sql .= "        WHERE 1=1                          ";
    $sql .= "        AND B.work_employ_data_no = A.no   ";
    $sql .= "        ) as matchingCnt                   ";
    $sql .= " FROM work_employ_data A                   ";
    $sql .= " WHERE 1=1                                 ";
    $sql .= " AND A.view = 'yes'                        ";
    $sql .= " AND A.uid = '$uid'                        ";

    $sql .= " ORDER BY A.wdate desc $sqlLimit           ";       

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

            $oneData["no"]        = $row["no"];
            $oneData["company"]   = $row["company"];
            $oneData["title"]     = $row["title"];
            $oneData["business"]  = $row["business"];

            if($row["delegate"] == 1) {
                $oneData["delegate"] = "대표 채용 공고";
            } else {
                $oneData["delegate"] = "";
            }

            if($row["career"] == -1) {
                $oneData["career"] = "무관";
            } else if($row["career"] == 0) {
                $oneData["career"] = "신입";
            } else if($row["career"] == 1) {
                $oneData["career"] = "1년 미만";
            } else if($row["career"] == 3) {
                $oneData["career"] = "3년 미만";
            } else if($row["career"] == 5) {
                $oneData["career"] = "5년 미만";
            } else {
                $oneData["career"] = "5년 이상";
            }

            $oneData["pay"]          = number_format($row["pay"]);
            $oneData["matchingCnt"]  = $row["matchingCnt"];
            $oneData["wdate"]        = $row["wdate"];

            if (empty($oneData["area_1st_nm"])) $oneData["area_1st_nm"] = "";
            if (empty($oneData["area_2nd_nm"])) $oneData["area_2nd_nm"] = "";
            if (empty($oneData["area_3rd_nm"])) $oneData["area_3rd_nm"] = "";
            if (empty($oneData["work_1st_nm"])) $oneData["work_1st_nm"] = "";
            if (empty($oneData["work_2nd_nm"])) $oneData["work_2nd_nm"] = "";


            $listData[]           = $oneData;
    }

/*
    $paging["page"]           = $page;
    $paging["currentSection"] = $currentSection;
    $paging["allSection"]     = $allSection;
    $paging["allPage"]        = $allPage;
    $paging["prevPage"]       = $prevPage;
    $paging["nextPage"]       = $nextPage;
    $paging["lastPage"]       = $lastPage;
    $paging["firstPage"]      = $firstPage;
    $paging["allPost"]        = $allPost;
*/

    $paging ="";

    //$paging .=  '<ul class="pagination">';
    //첫 페이지가 아니라면 처음 버튼을 생성
    if($page != 1) {
      $paging .= '<li><a href="javascript:getMyGuinList(1)"> << 첫페이지 </a></li>';

    }
    //첫 섹션이 아니라면 이전 버튼을 생성
    if($currentSection != 1) {
      $paging .= '<li><a href="javascript:getMyGuinList('.$prevPage.')">이전</a></li>';
    }

    for($i = $firstPage; $i <= $lastPage; $i++) {
      if($i == $page) {
        $paging .= '<li class="active"><a href="javascript:getMyGuinList('. $i .')">'.$i.'</a></li>'; 
      } else {
        $paging .= '<li><a href="javascript:getMyGuinList('. $i .')">'.$i.'</a></li>'; 
      }
    }

    //마지막 섹션이 아니라면 다음 버튼을 생성
    if($currentSection != $allSection) {
      $paging .= '<li><a href="javascript:getMyGuinList('.$nextPage.')">다음</a></li>';
    }

    //마지막 페이지가 아니라면 끝 버튼을 생성
    if($page != $allPage && $allPage != 0) {
      $paging .= '<li><a href="javascript:getMyGuinList('.$allPage.')">끝페이지 >> </a></li>';
    }
    //$paging .=  '</ul>';

    echo json_encode(array('listData' => $listData, 'paging'=>$paging ));



?>