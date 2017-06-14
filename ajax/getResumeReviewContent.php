
<?php
    include_once "../db/connect.php";

    $work_join_list_no      = $_POST['work_join_list_no'];


    $sql  = " SELECT content                                ";
    $sql .= "      , score                                  ";
    $sql .= " FROM resume_review                            ";
    $sql .= " WHERE work_join_list_no = '$work_join_list_no' ";


    $result = mysql_query($sql, $ilbang_con);
        
    while($row = mysql_fetch_array($result)){
             $content   = $row["content"]; 
             $score   = $row["score"]; 
    }

    echo json_encode(array('content' => $content, 'score'=>$score));



?>