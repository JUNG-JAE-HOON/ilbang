<?php
    include_once "../../db/connect.php";

    $inputId = $_POST["id"];
    $inputName = $_POST["name"];
    $phone = $_POST["phone"];
    $val = $_POST["val"];           //0 - 아이디 찾기 / 1 - 비밀번호 찾기

    if($val == 0) {
        $sql = "SELECT A.uid, A.wdate FROM member A JOIN member_extend B
                     WHERE A.name = '$inputName' AND A.uid = B.uid AND B.phone = '$phone' GROUP BY A.uid ORDER BY A.wdate";
        $result = mysql_query($sql);

        while($arr = mysql_fetch_array($result)) {
            $findData["id"] = $arr[0];
            $findData["date"] = date("Y-m-d H:i", strtotime($arr[1]));
            
            $findInfo[] = $findData;
        }
    } else {
        $sql = "SELECT COUNT(*) FROM member A JOIN member_extend B
                     WHERE A.uid = '$inputId' AND A.uid = B.uid AND A.name = '$inputName' AND B.phone = '$phone' GROUP BY A.uid";
        $result = mysql_query($sql);
        $arr = mysql_fetch_array($result);

        $findPwd = $arr[0];
    }

    echo json_encode(array('findInfo' => $findInfo, 'findPwd' => $findPwd));
?>