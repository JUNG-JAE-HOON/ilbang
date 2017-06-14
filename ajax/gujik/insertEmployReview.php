<?php
    include_once "../../db/connect.php";




    $work_join_list_no  = $_POST['work_join_list_no'];
    $content            = $_POST['reviewContent'];
    $euid               = $_POST['euid'];
    $ruid               = $_POST['ruid'];
    $score              = $_POST['score'];


    $sql  = " SELECT no as employ_review_no                     ";
    $sql .= " FROM employ_review                                ";
    $sql .= " WHERE work_join_list_no = '$work_join_list_no'    ";
        

    $result = mysql_query($sql, $ilbang_con);
    
    $employ_review_no = "";    
    while($row = mysql_fetch_array($result)){
             $employ_review_no = $row["employ_review_no"];
    }

    if($employ_review_no=="") { // 등록된 리뷰없음 새로등록

        $sql  = " INSERT INTO employ_review  (euid     , ruid      , score     , content   , wdate    , work_join_list_no     ) VALUES  ";
        $sql .= "                            ('$euid'  , '$ruid'   , '$score'  , '$content', SYSDATE(), '$work_join_list_no'  )         ";

    $result = mysql_query($sql, $ilbang_con);

    } else { // 등록된 리뷰잇음 리뷰 수정.

        $sql  = " UPDATE  employ_review ";
        $sql .= " SET  euid = '$euid'   ";
        $sql .= "     ,ruid = '$ruid'   ";
        $sql .= "     ,score= '$score'                              ";
        $sql .= "     ,content='$content'                           ";
        $sql .= "     ,wdate = SYSDATE()                            ";
        $sql .= "     , work_join_list_no = '$work_join_list_no'    ";
        $sql .= " WHERE no = '$employ_review_no'                    ";

        $result = mysql_query($sql, $ilbang_con);
    }
    echo json_encode(array('result' => mysql_affected_rows(), 'sql'=>$sql));


?>