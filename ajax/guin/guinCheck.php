<?php
    include_once "../../include/session.php";

    if($kind == "general") {
        $companyNum = 0;
    } else {
        $companyNum = 1;
    }

    echo json_encode($companyNum);
?>