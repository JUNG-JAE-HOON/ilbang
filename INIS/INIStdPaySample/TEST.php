<?php
    include_once "../../db/connect.php";


    $sql  = " SELECT CURDATE() as cur_date

    		";

    $result = mysql_query($sql, $ilbang_con);
        
    while($row = mysql_fetch_array($result)){
             $cur_date   = $row["cur_date"]; 
    }

    echo $cur_date;

?>