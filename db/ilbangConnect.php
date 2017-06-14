<?php
    $dest_host = '103.60.126.175';
    $dest_user = 'ilbang';
    $dest_password = 'ilbang7950';
    $dest_db = 'ilbang';

    $ilbang_con= mysql_connect($dest_host, $dest_user, $dest_password);
    $ilbang_db = mysql_select_db($dest_db, $ilbang_con);
?>