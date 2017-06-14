<?php
    include_once "../../db/connect.php";

    $area1 = $_POST["area1"];
    $work1 = $_POST["work1"];

    //------------------------------------------------------------
    //                         희망 지역 1차
    //------------------------------------------------------------
    $sql = "SELECT no, list_name FROM category WHERE type = 'area_type' AND parent_no = 0";
    $result = mysql_query($sql);

    $areaList = array();
    $i = 0;

    while($arr = mysql_fetch_array($result)) {
        $areaData["no"] = $arr[0];
        $areaData["name"] = $arr[1];

        $areaList[$i++] = $areaData;
    }

    //------------------------------------------------------------
    //                         희망 지역 2차
    //------------------------------------------------------------
    if(isset($_POST["area1"])) {
        $sql = "SELECT no, list_name FROM category WHERE parent_no = $area1";
        $result = mysql_query($sql);

        $areaList2 = array();
        $i = 0;

        while($arr = mysql_fetch_array($result)) {
            $areaData["no"] = $arr[0];
            $areaData["name"] = $arr[1];

            $areaList2[$i++] = $areaData;
        }
    }

    //------------------------------------------------------------
    //                          희망 직종 2차
    //------------------------------------------------------------
    if(isset($_POST["work1"])) {
        $sql = "SELECT no, list_name FROM category WHERE parent_no = $work1";
        $result = mysql_query($sql);

        $workList = array();
        $i = 0;

        while($arr = mysql_fetch_array($result)) {
            $workData["no"] = $arr[0];
            $workData["name"] = $arr[1];

            $workList[$i++] = $workData;
        }
    }

    echo json_encode(array('areaList' => $areaList, 'areaList2' => $areaList2, 'workList' => $workList));
?>