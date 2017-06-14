<?php
    include_once "../../include/session.php";
    include_once "../../db/connect.php";

    if(isset($_POST['page'])) {
        $page = $_POST['page'];
    } else {
        $page = 1;
    }

    $adminId = $uid;

    $sql  = " SELECT COUNT(*) as cnt    ";
    $sql .= " FROM member A             ";
    $sql .= "   , member_extend B       "; 
    $sql .= " WHERE 1=1                 ";
    $sql .= " AND A.reuid = '$adminId'  ";
    $sql .= " AND A.kind = 'company'    ";
    $sql .= " AND A.no = B.member_no    ";
    
    $result = mysql_query($sql, $ilbang_con);
        
    while($row = mysql_fetch_array($result)){
        $allPost = $row["cnt"];    // 전체 게시글 수
    }

    $onePage = 9; // 한 페이지에 보여줄 게시글의 수.
    $allPage = ceil($allPost / $onePage); //전체 페이지의 수
    $oneSection = 4; //한번에 보여줄 총 페이지 개수(1 ~ 10, 11 ~ 20 ...)
    $currentSection = ceil($page / $oneSection); //현재 섹션
    $allSection = ceil($allPage / $oneSection); //전체 섹션의 수
    $firstPage = ($currentSection * $oneSection) - ($oneSection - 1); //현재 섹션의 처음 페이지

    if ($allPost == 0) {
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

    $sql  = " SELECT                                        ";
    $sql .= "        @rownum:=@rownum+1 as rowNum           ";
    $sql .= "     ,  A.no as memberNo                       ";
    $sql .= "     ,  A.uid                                  ";
    $sql .= "     ,  A.name                                 ";
    $sql .= "     ,  B.phone                                ";
    $sql .= "     ,  B.login_count                          ";
    $sql .= "     ,  (                                      ";
    $sql .= "         SELECT COUNT(*)                       ";
    $sql .= "         FROM work_employ_data C               ";
    $sql .= "         WHERE 1=1                             ";
    $sql .= "         AND   C.member_no = A.no              ";
    $sql .= "         AND   C.view = 'yes'                  ";
    $sql .= "        ) as employCnt                         ";
    $sql .= "     , (                                       ";
    $sql .= "         SELECT COUNT(*)                       ";
    $sql .= "         FROM work_join_list D                 ";
    $sql .= "         WHERE 1=1                             ";
    $sql .= "         AND A.uid = D.euid                    ";
    $sql .= "         AND D.choice = 'yes'                  ";
    $sql .= "               ) as matchingCompleCnt          ";
    $sql .= "             , A.wdate as joinDate             ";
    $sql .= "         FROM member A                         ";
    $sql .= "            , member_extend B                  ";
    $sql .= "            , (SELECT @ROWNUM :=$currentLimit ) R ";
    $sql .= "         WHERE 1=1                             ";
    $sql .= "         AND A.reuid = '$adminId'              ";
    $sql .= "         AND A.kind = 'company'                ";
    $sql .= "         AND A.no = B.member_no                ";
    $sql .= "         ORDER BY A.wdate desc $sqlLimit       ";

    $result = mysql_query($sql, $ilbang_con);

    $listData =array();

    while($row = mysql_fetch_array($result)){
        $oneData["rowNum"]       = $row["rowNum"];
        $oneData["memberNo"]     = $row["memberNo"];
        $oneData["uid"]          = $row["uid"];
        $oneData["phone"]        = $row["phone"];
        $oneData["login_count"]  = $row["login_count"];
        $oneData["employCnt"]          = $row["employCnt"];
        $oneData["matchingCompleCnt"]  = $row["matchingCompleCnt"];
        $oneData["joinDate"]           = $row["joinDate"];

        if(empty($row["name"])) {
            $oneData["name"] = "&nbsp;";
        } else {
            $oneData["name"]         = $row["name"];
        }

        $listData[]           = $oneData;
    }

    //$paging .=  '<ul class="pagination">';
    //첫 페이지가 아니라면 처음 버튼을 생성
    if($page != 1) {
        $paging .= '<li><a href="javascript:getCmpMyRecmmndList(1)"> << 첫페이지 </a></li>';
    }

    //첫 섹션이 아니라면 이전 버튼을 생성
    if($currentSection != 1) {
        $paging .= '<li><a href="javascript:getCmpMyRecmmndList('.$prevPage.')">이전</a></li>';
    }

    for($i = $firstPage; $i <= $lastPage; $i++) {
        if($i == $page) {
            $paging .= '<li class="active"><a href="javascript:getCmpMyRecmmndList('. $i .')">'.$i.'</a></li>'; 
        } else {
            $paging .= '<li><a href="javascript:getCmpMyRecmmndList('. $i .')">'.$i.'</a></li>'; 
        }
    }

    //마지막 섹션이 아니라면 다음 버튼을 생성
    if($currentSection != $allSection) {
        $paging .= '<li><a href="javascript:getCmpMyRecmmndList('.$nextPage.')">다음</a></li>';
    }

    //마지막 페이지가 아니라면 끝 버튼을 생성
    if($page != $allPage && $allPage != 0) {
        $paging .= '<li><a href="javascript:getCmpMyRecmmndList('.$allPage.')">끝페이지 >> </a></li>';
    }

    echo json_encode(array('listData' => $listData, 'paging'=>$paging ));
?>