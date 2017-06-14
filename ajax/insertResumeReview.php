<?php
    include_once "../db/connect.php";




    $work_join_list_no  = $_POST['work_join_list_no'];
    $content            = $_POST['reviewContent'];
    $euid               = $_POST['euid'];
    $ruid               = $_POST['ruid'];
    $score              = $_POST['score'];


    $sql  = " SELECT no as resume_review_no                     ";
    $sql .= " FROM resume_review                                ";
    $sql .= " WHERE work_join_list_no = '$work_join_list_no'    ";
        

    $result = mysql_query($sql, $ilbang_con);
    
    $resume_review_no = "";    
    while($row = mysql_fetch_array($result)){
             $resume_review_no = $row["resume_review_no"];
    }

    if($resume_review_no=="") { // 등록된 리뷰없음 새로등록

        $sql  = " INSERT INTO resume_review  (euid     , ruid      , score     , content   , wdate    , work_join_list_no     ) VALUES  ";
        $sql .= "                            ('$euid'  , '$ruid'   , '$score'  , '$content', SYSDATE(), '$work_join_list_no'  )         ";

    $result = mysql_query($sql, $ilbang_con);

    } else { // 등록된 리뷰잇음 리뷰 수정.

        $sql  = " UPDATE  resume_review ";
        $sql .= " SET  euid = '$euid'   ";
        $sql .= "     ,ruid = '$ruid'   ";
        $sql .= "     ,score= '$score'                              ";
        $sql .= "     ,content='$content'                           ";
        $sql .= "     ,wdate = SYSDATE()                            ";
        $sql .= "     , work_join_list_no = '$work_join_list_no'    ";
        $sql .= " WHERE no = '$resume_review_no'                    ";

        $result = mysql_query($sql, $ilbang_con);
    }
    echo json_encode(array('result' => mysql_affected_rows(), 'sql'=>$sql));


?>