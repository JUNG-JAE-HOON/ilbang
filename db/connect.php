<?php
    $dest_host = '182.162.104.152';
    $dest_user = 'root';
    $dest_password = 'ghldfudrhkd!!';
    $dest_db = 'ilbang';
    // ilbang DB 접속

    $ilbang_con= mysql_connect($dest_host, $dest_user, $dest_password);
    $ilbang_db = mysql_select_db($dest_db, $ilbang_con);

    function get_encrypt_string($str){
        $sql ="select password('".$str."')";
        $result= mysql_query($sql,$GLOBALS['ilbang_con']);
        $row = mysql_fetch_row($result);

        return $row[0];
    }

    function check_password($pass, $hash) {
        $password = get_encrypt_string($pass);
        
        return ($password === $hash);
    }
?>