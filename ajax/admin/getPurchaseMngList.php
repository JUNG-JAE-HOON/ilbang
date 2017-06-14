<?php
    include_once "../../db/connect.php";
    include_once "../../include/session.php";
    if(isset($_POST['page'])) {
        $page = $_POST['page'];
    } else {
        $page = 1;
    }
    
    $yyyymm = $_POST["yyyymm"];

    $adminId = $uid;

    //$adminId = '';
    //$yyyymm ="2017-03";
    // test 나중에 지워야함.
    //$adminId = 'GIGA';

    $sql  = " 
            SELECT COUNT(*) as cnt 
            FROM (
             SELECT                                                              
                    E.*
             FROM (                                                                                            
                  SELECT                                                                                     
                  (                                                                                          
                    SELECT IFNULL(sum(total_price) - (sum(total_price) * 0.1),0)
                    FROM inis_result_data C
                    WHERE 1=1
                    AND A.no = C.member_no
                    AND DATE_FORMAT(C.appl_date,'%Y-%m') = '$yyyymm'   
                     ) as itemPurchaseAmt                                                                      
                 ,  (                                                                                          
                        SELECT IFNULL(SUM(C.item_price) - (SUM(C.item_price) * 0.3 ),0) 
                        FROM in_app_purchase_data C
                        WHERE 1=1
                        AND C.member_no = A.no
                        AND DATE_FORMAT(C.server_date, '%Y-%m') = '$yyyymm'                                       
                    ) as marketPurchaseAmt
            FROM member A                                                                                     
            WHERE 1=1                                                                                         
            AND reuid = '$adminId'                                               
            ) E                                                                           
            WHERE 1=1
            AND (itemPurchaseAmt > 0 OR marketPurchaseAmt > 0 )                                                                                           
            ) X ";
//

    /* (SELECT count(*)                                                                           
    FROM work_join_list E                                                                     
    WHERE 1=1                                                                                 
    AND (A.uid = E.euid OR A.uid = E.ruid)                                                    
    AND E.choice='yes'                                                                        
    ) * 1000 as matchingCompleAmt*/ 
    

    $result = mysql_query($sql, $ilbang_con);
        
    while($row = mysql_fetch_array($result)){
             $allPost = $row["cnt"];    // 전체 게시글 수
    }


    $onePage = 5; // 한 페이지에 보여줄 게시글의 수.
    $allPage = ceil($allPost / $onePage); //전체 페이지의 수

    $oneSection = 4; //한번에 보여줄 총 페이지 개수(1 ~ 10, 11 ~ 20 ...)
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

$sql  = "   SELECT     @rownum:=@rownum+1 as rowNum
                    ,  X.*
                 
             FROM (
             SELECT                                                              
                        E.memberNo                                                                                
                     ,  E.kind                                                                                    
                     ,  E.uid                                                                                     
                     ,  FLOOR(E.itemPurchaseAmt)   as itemPurchaseAmt                                             
                     ,  FLOOR(E.marketPurchaseAmt) as marketPurchaseAmt                                           
                     ,  0  as matchingAmt                                                                          
                     ,  0  as mathicngCommission                                                                  
                     ,  FLOOR(E.itemPurchaseAmt * 0.05)   as payAmtA                                             
                     ,  FLOOR(E.marketPurchaseAmt * 0.05)   as payAmtB                                             
                     ,  FLOOR((E.itemPurchaseAmt * 0.05) + (E.marketPurchaseAmt * 0.05)) as totalAmt             
                 FROM (                                                                                            
                      SELECT A.no as memberNo                                                                           
                      ,  A.kind                                                                                     
                      ,  A.uid                                                                                      
                     ,  (                                                                                          
                        SELECT IFNULL(sum(total_price) - (sum(total_price) * 0.1),0)
                        FROM inis_result_data C
                        WHERE 1=1
                        AND A.no = C.member_no
                        AND DATE_FORMAT(C.appl_date,'%Y-%m') = '$yyyymm'   
                         ) as itemPurchaseAmt                                                                      
                     ,  (                                                                                          
                            SELECT IFNULL(SUM(C.item_price) - (SUM(C.item_price) * 0.3 ),0) 
                            FROM in_app_purchase_data C
                            WHERE 1=1
                            AND C.member_no = A.no
                            AND DATE_FORMAT(C.server_date, '%Y-%m') = '$yyyymm'                                       
                        ) as marketPurchaseAmt
                FROM member A                                                                                     
                WHERE 1=1                                                                                         
                AND reuid = '$adminId'                                              
                ) E,                                                                                              
                (SELECT @ROWNUM :=0 ) R                                                                           
                WHERE 1=1
                AND (itemPurchaseAmt > 0 OR marketPurchaseAmt > 0 )                                                                                           
                ) X                              
                ORDER BY X.totalAmt desc $sqlLimit ";
//
          
    //$sql .= " --   , (SELECT count(*)                                                                           ";
    //$sql .= " --      FROM work_join_list E                                                                     ";
    //$sql .= " --      WHERE 1=1                                                                                 ";
    //$sql .= " --      AND (A.uid = E.euid OR A.uid = E.ruid)                                                    ";
    //$sql .= " --      AND E.choice='yes'                                                                        ";
    //$sql .= " --      ) * 1000 as matchingCompleAmt                                                             ";
   
    $result = mysql_query($sql, $ilbang_con);


    $listData =array();
    while($row = mysql_fetch_array($result)){

            $oneData["rowNum"]              = $row["rowNum"];
            $oneData["memberNo"]            = $row["memberNo"];
            $oneData["kind"]                = $row["kind"];

            if      ($oneData["kind"]=="general") $oneData["kind"] = "개인";
            else if ($oneData["kind"]=="company") $oneData["kind"] = "기업"; 

            $oneData["uid"]                 = $row["uid"];
            $oneData["itemPurchaseAmt"]     = $row["itemPurchaseAmt"];
            $oneData["marketPurchaseAmt"]   = number_format($row["marketPurchaseAmt"]);
            $oneData["matchingAmt"]         = number_format($row["matchingAmt"]);
            $oneData["mathicngCommission"]  = number_format($row["mathicngCommission"]);
            $oneData["payAmtA"]             = number_format($row["payAmtA"]);
            $oneData["payAmtB"]             = number_format($row["payAmtB"]);
            $oneData["totalAmt"]            = number_format($row["totalAmt"]);
            $listData[]           = $oneData;
    }



    //$paging .=  '<ul class="pagination">';
    //첫 페이지가 아니라면 처음 버튼을 생성
    if($page != 1) {
      $paging .= '<li><a href="javascript:getPurchaseMngList(1)"> << 첫페이지 </a></li>';

    }
    //첫 섹션이 아니라면 이전 버튼을 생성
    if($currentSection != 1) {
      $paging .= '<li><a href="javascript:getPurchaseMngList('.$prevPage.')">이전</a></li>';
    }

    for($i = $firstPage; $i <= $lastPage; $i++) {
      if($i == $page) {
        $paging .= '<li class="active"><a href="javascript:getPurchaseMngList('. $i .')">'.$i.'</a></li>'; 
      } else {
        $paging .= '<li><a href="javascript:getPurchaseMngList('. $i .')">'.$i.'</a></li>'; 
      }
    }

    //마지막 섹션이 아니라면 다음 버튼을 생성
    if($currentSection != $allSection) {
      $paging .= '<li><a href="javascript:getPurchaseMngList('.$nextPage.')">다음</a></li>';
    }

    //마지막 페이지가 아니라면 끝 버튼을 생성
    if($page != $allPage && $allPage != 0) {
      $paging .= '<li><a href="javascript:getPurchaseMngList('.$allPage.')">끝페이지 >> </a></li>';
    }
    //$paging .=  '</ul>';

    $sql  = "    SELECT SUM(FLOOR((X.itemPurchaseAmt*0.05) + (X.marketPurchaseAmt*0.05))) as totalSumAmt
                 FROM (
                 SELECT                                                              
                            E.*
                     FROM (                                                                                            
                          SELECT                                                                                     
                          (                                                                                          
                            SELECT IFNULL(sum(total_price) - (sum(total_price) * 0.1),0)
                            FROM inis_result_data C
                            WHERE 1=1
                            AND A.no = C.member_no
                            AND DATE_FORMAT(C.appl_date,'%Y-%m') = '$yyyymm'   
                             ) as itemPurchaseAmt                                                                      
                         ,  (                                                                                          
                                SELECT IFNULL(SUM(C.item_price) - (SUM(C.item_price) * 0.3 ),0) 
                                FROM in_app_purchase_data C
                                WHERE 1=1
                                AND C.member_no = A.no
                                AND DATE_FORMAT(C.server_date, '%Y-%m') = '$yyyymm'                                       
                            ) as marketPurchaseAmt
                    FROM member A                                                                                     
                    WHERE 1=1                                                                                         
                    AND reuid = '$adminId'                                               
                    ) E                                                                           
                    WHERE 1=1
                    AND (itemPurchaseAmt > 0 OR marketPurchaseAmt > 0 )                                                                                           
                    ) X 

          ";
//

    $result = mysql_query($sql, $ilbang_con);

    while($row = mysql_fetch_array($result)){

            $totalSumAmt  = number_format($row["totalSumAmt"]);
            
    }

/*
    SELECT SUM(FLOOR((E.marketPurchaseAmt * 0.05) + (E.matchingCompleAmt * 0.05))) as totalSumAmt
    FROM (                                                                                            
    SELECT A.no as memberNo                                                                         
        ,  A.kind                                                                                   
        ,  A.uid                                                                                    
        ,  (                                                                                        
           SELECT IFNULL(SUM(item_price-(item_price*0.1)),0)                                        
           FROM item_data C,  work_item D                                                           
           WHERE C.id = D.item_id                                                                   
           AND D.member_no = A.no                                                                   
           AND C.charge_type IN ('P')                                                               
           AND DATE_FORMAT(D.wdate, '%Y-%m') = '$yyyymm'                                            
            ) as itemPurchaseAmt                                                                    
        ,  (                                                                                        
           SELECT IFNULL(SUM(item_price*IFNULL(D.count,1)-(item_price*IFNULL(D.count,1)*0.3)),0)    
           FROM item_data C,  work_item D                                                            
           WHERE C.id = D.item_id                                                                    
           AND D.member_no = A.no                                                                    
           AND C.charge_type IN ('A','I')                                                            
           AND DATE_FORMAT(D.wdate, '%Y-%m') = '$yyyymm'                                             
            ) as marketPurchaseAmt                                                            
         , 0 as matchingCompleAmt                                                                      
        FROM member A                                                                                     
        WHERE 1=1                                                                                         
        AND reuid = '$adminId'                                                                        
        ) E,                                                                                             
        (SELECT @ROWNUM :=0 ) R                                                                           
        WHERE 1=1                                                                                         
        AND (E.marketPurchaseAmt * 0.05) + (E.matchingCompleAmt * 0.05) > 0                               ;
*/


    echo json_encode(array('listData' => $listData, 'paging'=>$paging ,'totalSumAmt'=>$totalSumAmt));
?>