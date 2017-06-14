<?php
    include_once "../../include/session.php";
    include_once "../../db/connect.php";

    if(isset($_POST["area1"])) {
        $area1 = $_POST["area1"];
    } else {
        $area1 = "";
    }

    if(isset($_POST["work1"])) {
        $work1 = $_POST["work1"];
    } else {
        $work1 = "";
    }

    $sql = "SELECT age FROM member_extend WHERE uid = '$uid'";
    $result = mysql_query($sql);
    $arr = mysql_fetch_array($result);

    $age = $arr[0];

    $sql = "SELECT no, list_name FROM category WHERE type = 'area_type' AND parent_no = 0";
    $result = mysql_query($sql);

    while($arr = mysql_fetch_array($result)) {
        $areaData["no"] = $arr[0];
        $areaData["name"] = $arr[1];

        $areaList[] = $areaData;
    }

    if($area1 != "") {
        $sql = "SELECT no, list_name FROM category WHERE parent_no = $area1";
        $result = mysql_query($sql);

        while($arr = mysql_fetch_array($result)) {
            $areaData["no"] = $arr[0];
            $areaData["name"] = $arr[1];

            $areaList2[] = $areaData;
        }
    }

    if($work1 != "") {
        if($age > 19) {
            $sql = "SELECT no, list_name FROM category WHERE parent_no = $work1";
        } else {
            $sql = "SELECT no, list_name FROM category WHERE no = 8017";
        }
        
        $result = mysql_query($sql);

        while($arr = mysql_fetch_array($result)) {
            $workData["no"] = $arr[0];
            $workData["name"] = $arr[1];

            $workList[] = $workData;
        }
    }

    echo  json_encode(array('areaList' => $areaList, 'areaList2' => $areaList2, 'workList' => $workList));
?>