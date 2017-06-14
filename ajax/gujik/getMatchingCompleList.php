<?php
    include_once "../../db/connect.php";

    if($_POST['page'] != '') {
        $page = $_POST['page'];
    } else {
        $page = 1;
    }

    if($_POST['onePage'] != '') {
        $onePage = $_POST['onePage'];
    } else {
        $onePage = 10;
    }
  
    $uid            = $_POST['uid'];
    // $uid  = 'slslcx';
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
 
    $sql  = " SELECT count(*) as cnt                                                                   ";
    $sql .= " FROM work_employ_data A, work_join_list B, work_resume_data C, member D, member_extend E ";
    $sql .= " WHERE 1=1                                                                                ";
    $sql .= " AND A.uid   = '$uid'                                                                     ";
    $sql .= " AND A.no    = B.work_employ_data_no                                                      ";
    $sql .= " AND B.choice    = 'yes'                                                                  ";
    $sql .= " AND B.work_resume_data_no = C.no                                                         ";
    $sql .= " AND C.member_no = D.no                                                                   ";
    $sql .= " AND C.member_no = E.member_no                                                            ";
    $sql .= " GROUP BY C.no                                                                            ";

    


/*
	$sql  = " SELECT count(*) cnt 		"; 						
	$sql .= " FROM (					";
	$sql .= " SELECT age, title, keyword, pay, career, content, wdate,time, member_no ";
	$sql .= " FROM work_resume_data 	";
	$sql .= " WHERE 1=1 				";
	$sql .= " AND no IN 				";
	$sql .= " ( 						";
	$sql .= " SELECT work_resume_data_no 		";
	$sql .= " FROM work_join_list 				";
    $sql .= " WHERE 1=1                           ";
    $sql .= " AND choice = 'yes'                ";
    
	$sql .= " AND  work_employ_data_no IN   	";
	$sql .= "     (								";
	$sql .= " 	SELECT no 						";
	$sql .= " 	FROM work_employ_data  			";
	$sql .= " 	WHERE 1=1 						";
	$sql .= " 		AND uid = '$uid'			";
	$sql .= " 		)							";
	$sql .= " 	)								";
	$sql .= " 	) A, member B, member_extend C 	";
	$sql .= " 	WHERE A.member_no = B.no 		";
	$sql .= " 	AND C.member_no = B.no 			";

*/
        

    $result = mysql_query($sql, $ilbang_con);
        
    while($row = mysql_fetch_array($result)){
             $allPost = $row["cnt"];    // 전체 게시글 수
    }

    //$allPost = $row['cnt']; //전체 게시글의 수

    //$onePage = 5; // 한 페이지에 보여줄 게시글의 수.
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

/*
	$sql  = " SELECT A.no, C.age, A.title, A.keyword, A.pay, A.career, A.content, A.wdate,A.time, A.member_no, B.name, C.sex ";
    $sql .= " FROM ( ";
    $sql .= " SELECT no, age, title, keyword, pay, career, content, wdate,time, member_no ";
    $sql .= " FROM work_resume_data             ";
    $sql .= " WHERE 1=1                         ";
    $sql .= " AND no IN                         ";
    $sql .= " (                                 ";
    $sql .= " SELECT work_resume_data_no        ";
    $sql .= " FROM work_join_list               ";
    $sql .= " WHERE 1 =1                         ";
    $sql .= " AND choice = 'yes'               ";
    
    $sql .= " AND work_employ_data_no IN      "; 
    $sql .= "     (                             ";
    $sql .= "   SELECT no                       ";
    $sql .= "   FROM work_employ_data           ";
    $sql .= "   WHERE 1=1                       ";
    $sql .= "   AND uid = '$uid'                ";
    $sql .= "   )                               ";
    $sql .= " )                                 ";
    $sql .= " ) A, member B, member_extend C    ";
    $sql .= " WHERE A.member_no = B.no          ";
    $sql .= " AND C.member_no = B.no            ";
    $sql .= " ORDER BY wdate desc $sqlLimit     ";
*/

    $sql  = " SELECT B.work_resume_data_no, B.work_employ_data_no, C.no as resumeNo, E.age, C.title, C.keyword, C.pay, C.career, C.content,C.business, C.wdate, C.time, C.member_no, D.name, E.sex ";
    $sql .= " FROM work_resume_data A, work_join_list B, work_employ_data C, member D, member_extend E";
    $sql .= " WHERE 1=1 ";
    $sql .= " AND A.uid   = '$uid' ";
    $sql .= " AND A.no    = B.work_resume_data_no ";
    $sql .= " AND B.choice    = 'yes'                                                                  ";
    $sql .= " AND B.work_employ_data_no = C.no ";
    $sql .= " AND C.member_no = D.no ";
    $sql .= " AND C.member_no = E.member_no ";
    $sql .= " GROUP BY C.no ";
    $sql .= " ORDER BY C.wdate desc $sqlLimit     ";



    $result = mysql_query($sql, $ilbang_con);


    $listData =array();
    while($row = mysql_fetch_array($result)){
            //$oneData["keyword"]   = $row["keyword"];
            $oneData["work_resume_data_no"]       = $row["work_resume_data_no"];
            $oneData["work_employ_data_no"]       = $row["work_employ_data_no"];
            $oneData["resumeNo"]                  = $row["resumeNo"];

        	//$oneData["no"]       = $row["no"];
        	$oneData["age"]      = $row["age"];
        	$oneData["title"]    = $row["title"];
        	//$oneData["keyword"]  = $row["keyword"];
        	$oneData["pay"]      = number_format($row["pay"]);
        	$oneData["career"]   = $row["career"];
        	$oneData["content"]  = $row["content"];
        	$oneData["wdate"]    = $row["wdate"];
        	$oneData["time"]     = $row["time"];
        	$oneData["name"]     = $row["name"];
        	$oneData["sex"]      = $row["sex"];
            $oneData["business"]      = $row["business"];


                 if ($oneData["time"] == "1")  $oneData["time"] = "오전";
            else if ($oneData["time"] == "2")  $oneData["time"] = "오후";
            else if ($oneData["time"] == "3")  $oneData["time"] = "저녁";
            else if ($oneData["time"] == "4")  $oneData["time"] = "새벽";
            else if ($oneData["time"] == "5")  $oneData["time"] = "오전~오후";
            else if ($oneData["time"] == "6")  $oneData["time"] = "오후~저녁";
            else if ($oneData["time"] == "7")  $oneData["time"] = "저녁~새벽";
            else if ($oneData["time"] == "8")  $oneData["time"] = "새벽~오전";
            else if ($oneData["time"] == "9")  $oneData["time"] = "풀타임";
            else if ($oneData["time"] == "10")  $oneData["time"] = "무관/협의";

                 if ($oneData["sex"] == "male")     $oneData["sex"] = "남자";
            else if ($oneData["sex"] == "female")   $oneData["sex"] = "여자";
            else if ($oneData["sex"] == "nothing") $oneData["sex"] = "무관";  


                 if ($oneData["career"] == "-1")  $oneData["career"] = "무관";
            else if ($oneData["career"] == "0")   $oneData["career"] = "신입";
            else if ($oneData["career"] == "1")   $oneData["career"] = "1년미만";  
            else if ($oneData["career"] == "3")   $oneData["career"] = "3년미만";  
            else if ($oneData["career"] == "5")   $oneData["career"] = "5년미만";  
            else if ($oneData["career"] == "6")   $oneData["career"] = "5년이상";

            $keyword = explode(",",$row["keyword"]);
        
            $oneData["area_1st_nm"] = $keyword[0];
            $oneData["area_2nd_nm"] = $keyword[1];
            $oneData["area_3rd_nm"] = $keyword[2];
            $oneData["work_1st_nm"] = $keyword[3];
            $oneData["work_2nd_nm"] = $keyword[4];

           
            if (empty($oneData["area_1st_nm"])) $oneData["area_1st_nm"] = "";
            if (empty($oneData["area_2nd_nm"])) $oneData["area_2nd_nm"] = "";
            if (empty($oneData["area_3rd_nm"])) $oneData["area_3rd_nm"] = "";
            if (empty($oneData["work_1st_nm"])) $oneData["work_1st_nm"] = "";
            if (empty($oneData["work_2nd_nm"])) $oneData["work_2nd_nm"] = "";

            //$oneData["name"] = mb_substr($oneData["name"], 0, 1, 'utf-8') . "OO"; 
            //$oneData["age"] = substr($oneData["age"], 0, 1) . "0";  

           

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

    $paging = "";

    if($page != 1) {
      $paging .= '<li><a href="javascript:getMatchingCompleList(1,'.$onePage.')"> << 첫페이지 </a></li>';

    }
    //첫 섹션이 아니라면 이전 버튼을 생성
    if($currentSection != 1) {
      $paging .= '<li><a href="javascript:getMatchingCompleList('.$prevPage.','.$onePage.')">이전</a></li>';
    }

    for($i = $firstPage; $i <= $lastPage; $i++) {
      if($i == $page) {
        $paging .= '<li class="active"><a href="javascript:getMatchingCompleList('. $i .','.$onePage.')">'.$i.'</a></li>'; 
      } else {
        $paging .= '<li><a href="javascript:getMatchingCompleList('. $i .','.$onePage.')">'.$i.'</a></li>'; 
      }
    }

    //마지막 섹션이 아니라면 다음 버튼을 생성
    if($currentSection != $allSection) {
      $paging .= '<li><a href="javascript:getMatchingCompleList('.$nextPage.','.$onePage.')">다음</a></li>';
    }

    //마지막 페이지가 아니라면 끝 버튼을 생성
    if($page != $allPage && $allPage != 0) {
      $paging .= '<li><a href="javascript:getMatchingCompleList('.$allPage.','.$onePage.')">끝페이지 >> </a></li>';
    }


    echo json_encode(array('listData' => $listData, 'paging'=>$paging ,'onePage'=>$onePage));



?>