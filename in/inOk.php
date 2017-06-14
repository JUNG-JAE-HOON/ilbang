<?php
    session_start();
    //**************************************************************************************************************
    //NICE평가정보 Copyright(c) KOREA INFOMATION SERVICE INC. ALL RIGHTS RESERVED

    //서비스명 :  체크플러스 - 안심본인인증 서비스
    //페이지명 :  체크플러스 - 결과 페이지

    //보안을 위해 제공해드리는 샘플페이지는 서비스 적용 후 서버에서 삭제해 주시기 바랍니다.
    //**************************************************************************************************************

    /*****************************
    //아파치에서 모듈 로드가 되지 않았을경우 동적으로 모듈을 로드합니다.

    if(!extension_loaded('CPClient')) {
        dl('CPClient.' . PHP_SHLIB_SUFFIX);
    }
    
    $module = 'CPClient';
    *****************************/

    if(!extension_loaded('CPClient')) {
        dl('CPClient.' . PHP_SHLIB_SUFFIX);
    }
    
    $module = 'CPClient';
    $sitecode = "AB817";                               // NICE로부터 부여받은 사이트 코드
    $sitepasswd = "8BflzwxoxI1k";               // NICE로부터 부여받은 사이트 패스워드

    $enc_data = $_POST["EncodeData"];     // 암호화된 결과 데이타
    $sReserved1 = $_POST['param_r1'];
    $sReserved2 = $_POST['param_r2'];
    $sReserved3 = $_POST['param_r3'];

    //////////////////////////////////////////////// 문자열 점검///////////////////////////////////////////////
    if(preg_match('~[^0-9a-zA-Z+/=]~', $enc_data, $match)) {echo "입력 값 확인이 필요합니다 : ".$match[0]; exit;} // 문자열 점검 추가.
    if(base64_encode(base64_decode($enc_data))!=$enc_data) {echo "입력 값 확인이 필요합니다"; exit;}
    if(preg_match("/[#\&\\+\-%@=\/\\\:;,\.\'\"\^`~\_|\!\/\?\*$#<>()\[\]\{\}]/i", $sReserved1, $match)) {echo "문자열 점검 : ".$match[0]; exit;}
    if(preg_match("/[#\&\\+\-%@=\/\\\:;,\.\'\"\^`~\_|\!\/\?\*$#<>()\[\]\{\}]/i", $sReserved2, $match)) {echo "문자열 점검 : ".$match[0]; exit;}
    //  if(preg_match("/[#\&\\+\-%@=\/\\\:;,\.\'\"\^`~\_|\!\/\?\*$#<>()\[\]\{\}]/i", $sReserved3, $match)) {echo "문자열 점검 : ".$match[0]; exit;};
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////

    if($enc_data != "") {
        if(extension_loaded($module)) {//  동적으로 모듈 로드 했을경우
            $plaindata = get_decode_data($sitecode, $sitepasswd, $enc_data);//암호화된 결과 데이터의 복호화
        } else {
            $plaindata = "Module get_response_data is not compiled into PHP";
        }

       // echo "[plaindata]  " . $plaindata . "<br>";

        if($plaindata == -1) {
            $returnMsg  = "암/복호화 시스템 오류";
        } else if($plaindata == -4) {
            $returnMsg  = "복호화 처리 오류";
        } else if($plaindata == -5) {
            $returnMsg  = "HASH값 불일치 - 복호화 데이터는 리턴됨";
        } else if($plaindata == -6) {
            $returnMsg  = "복호화 데이터 오류";
        } else if($plaindata == -9) {
            $returnMsg  = "입력값 오류";
        } else if($plaindata == -12) {
            $returnMsg  = "사이트 비밀번호 오류";
        } else {
            // 복호화가 정상적일 경우 데이터를 파싱합니다.
            $requestnumber = GetValue($plaindata , "REQ_SEQ");
            $responsenumber = GetValue($plaindata , "RES_SEQ");
            $authtype = GetValue($plaindata , "AUTH_TYPE");
            $name = GetValue($plaindata , "NAME");
            $birthdate = GetValue($plaindata , "BIRTHDATE");
            $gender = GetValue($plaindata , "GENDER");
            $nationalinfo = GetValue($plaindata , "NATIONALINFO");  //내/외국인정보(사용자 매뉴얼 참조)
            $dupinfo = GetValue($plaindata , "DI");
            $conninfo = GetValue($plaindata , "CI");
            $mobile_no = GetValue($plaindata , "MOBILE_NO");

            if(strcmp($_SESSION["REQ_SEQ"], $requestnumber) != 0) {
                //echo "세션값이 다릅니다. 올바른 경로로 접근하시기 바랍니다.<br>";
                $requestnumber = "";
                $responsenumber = "";
                $authtype = "";
                $name = "";
                $birthdate = "";
                $gender = "";
                $nationalinfo = "";
                $dupinfo = "";
                $conninfo = "";
                $mobile_no = "";
            }
        }
    }

    function GetValue($str , $name) {
        $pos1 = 0;  //length의 시작 위치
        $pos2 = 0;  //:의 위치

        while( $pos1 <= strlen($str)) {
            $pos2 = strpos( $str , ":" , $pos1);
            $len = substr($str , $pos1 , $pos2 - $pos1);
            $key = substr($str , $pos2 + 1 , $len);
            $pos1 = $pos2 + $len + 1;

            if( $key == $name ) {
                $pos2 = strpos( $str , ":" , $pos1);
                $len = substr($str , $pos1 , $pos2 - $pos1);
                $value = substr($str , $pos2 + 1 , $len);
                return $value;
            } else {
                // 다르면 스킵한다.
                $pos2 = strpos( $str , ":" , $pos1);
                $len = substr($str , $pos1 , $pos2 - $pos1);
                $pos1 = $pos2 + $len + 1;
            }
        }
    }

    $name = iconv('euc-kr','utf-8', $name);
    $uid = iconv('euc-kr','utf-8', $sReserved1);
    $wdate = date("Y-m-d H:i:s");

    $birthdate1 = substr($birthdate, 0, 4);
    $birthdate2 = substr($birthdate, 4, 2);
    $birthdate3 = substr($birthdate, 6, 2);

    $phone1 = substr($mobile_no, 0, 3);
    $phone2 = substr($mobile_no, 3, 4);
    $phone3 = substr($mobile_no, 7, 4);

    $birthdate = $birthdate1."-".$birthdate2."-".$birthdate3;
    $mobile_no = $phone1."-".$phone2."-".$phone3;
?>
<html>
<head>
    <title>NICE평가정보 - CheckPlus 본인인증</title>
</head>
<body>
    <?
        include_once "../db/connect.php";

        $age = explode("-", $birthdate);
        $age = (date("Y") - $age[0]) + 1;

        if($gender == 0) {
            $sex = "female";
        } else {
            $sex = "male";
        }

        $sql = "SELECT COUNT(*) FROM member_valid WHERE name = '$name' AND birthdate = '$birthdate'";
        $result = mysql_query($sql);
        $arr = mysql_fetch_array($result);

        if($arr[0] == 0) {
            $sql = "INSERT INTO member_valid(req_seq, res_seq, auth_type, uid, name, gender, birthdate, phone, nationalinfo, wdate)
                         VALUES ('$requestnumber', '$responsenumber', '$authtype', '$uid', '$name', '$gender', '$birthdate', '$mobile_no', '$nationalinfo', '$wdate')";
            $result = mysql_query($sql);

            if($result) {
                $sql = "SELECT no FROM member_valid WHERE uid = '$uid'";
                $result = mysql_query($sql);
                $arr = mysql_fetch_array($result);

                $validNo = $arr[0];

                mysql_query("UPDATE member SET valid = 'yes', valid_no = $validNo, name = '$name' WHERE uid = '$uid'");
                mysql_query("UPDATE member_extend SET birthday = '$birthdate', age = '$age', sex = '$sex', phone = '$mobile_no' WHERE uid = '$uid'");
                mysql_query("UPDATE company SET valid_no = $validNo WHERE uid = '$uid'");

                echo "<script>alert('본인 인증이 완료되었습니다.');</script>";
            } else {
                echo "<script>alert('본인 인증 실패\n관리자에게 문의바랍니다.');</script>";
            }
        } else {
            echo "<script>alert('이미 본인 인증을 하셨습니다.');</script>";
        }

        echo "<script>window.opener.location.reload(true);</script>";
        echo "<script>self.close();</script>";
    ?>
</html>
