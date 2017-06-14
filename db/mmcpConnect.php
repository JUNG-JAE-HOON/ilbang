<?php
    $dest_host = '182.162.141.20';
    $dest_user = 'root';
    $dest_password = 'Tlqkfdudrhkd!!';
    $dest_db = 'mmcp';

    $ilbang_con= mysql_connect($dest_host, $dest_user, $dest_password);
    $ilbang_db = mysql_select_db($dest_db, $ilbang_con);
?>