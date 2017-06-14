<?php
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

    session_start();
    header("Cache-Control: no-cache,must-revalidate");

    if(!extension_loaded('CPClient')) {
        dl('CPClient.' . PHP_SHLIB_SUFFIX);
    }

    $module = 'CPClient';
    $sitecode = "AB817";                    // NICE로부터 부여받은 사이트 코드
    $sitepasswd = "8BflzwxoxI1k";               // NICE로부터 부여받은 사이트 패스워드

    $enc_data = $_POST["EncodeData"];       // 암호화된 결과 데이타
    $sReserved1 = $_POST['param_r1'];
    $sReserved2 = $_POST['param_r2'];
    $sReserved3 = $_POST['param_r3'];

    //////////////////////////////////////////////// 문자열 점검///////////////////////////////////////////////
    if(preg_match('~[^0-9a-zA-Z+/=]~', $enc_data, $match)) {echo "입력 값 확인이 필요합니다 : ".$match[0]; exit;} // 문자열 점검 추가.
    if(base64_encode(base64_decode($enc_data))!=$enc_data) {echo "입력 값 확인이 필요합니다"; exit;}
    if(preg_match("/[#\&\\+\-%@=\/\\\:;,\.\'\"\^`~\_|\!\/\?\*$#<>()\[\]\{\}]/i", $sReserved1, $match)) {echo "문자열 점검 : ".$match[0]; exit;}
    if(preg_match("/[#\&\\+\-%@=\/\\\:;,\.\'\"\^`~\_|\!\/\?\*$#<>()\[\]\{\}]/i", $sReserved2, $match)) {echo "문자열 점검 : ".$match[0]; exit;}
    if(preg_match("/[#\&\\+\-%@=\/\\\:;,\.\'\"\^`~\_|\!\/\?\*$#<>()\[\]\{\}]/i", $sReserved3, $match)) {echo "문자열 점검 : ".$match[0]; exit;}
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////

    if($enc_data != "") {
        if(extension_loaded($module)) {     // 동적으로 모듈 로드 했을경우
            $plaindata = get_decode_data($sitecode, $sitepasswd, $enc_data);// 암호화된 결과 데이터의 복호화
        } else {
            $plaindata = "Module get_response_data is not compiled into PHP";
        }

      //  echo "[plaindata] " . $plaindata . "<br>";

        if ($plaindata == -1) {
            $returnMsg  = "암/복호화 시스템 오류";
        } else if ($plaindata == -4) {
            $returnMsg  = "복호화 처리 오류";
        } else if ($plaindata == -5) {
            $returnMsg  = "HASH값 불일치 - 복호화 데이터는 리턴됨";
        } else if ($plaindata == -6) {
            $returnMsg  = "복호화 데이터 오류";
        } else if ($plaindata == -9) {
            $returnMsg  = "입력값 오류";
        } else if ($plaindata == -12) {
            $returnMsg  = "사이트 비밀번호 오류";
        } else {
            // 복호화가 정상적일 경우 데이터를 파싱합니다.
            $requestnumber = GetValue($plaindata , "REQ_SEQ");
            $errcode = GetValue($plaindata , "ERR_CODE");
            $authtype = GetValue($plaindata , "AUTH_TYPE");
        }
    }

    function GetValue($str , $name) {
        $pos1 = 0;  //length의 시작 위치
        $pos2 = 0;  //:의 위치

        while($pos1 <= strlen($str)) {
            $pos2 = strpos( $str , ":" , $pos1);
            $len = substr($str , $pos1 , $pos2 - $pos1);
            $key = substr($str , $pos2 + 1 , $len);
            $pos1 = $pos2 + $len + 1;

            if($key == $name) {
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
?>
<html>
<head>
    <title>NICE평가정보 - CheckPlus 안심본인인증 테스트</title>
</head>
<body>
<?
    $error = iconv('euc-kr','utf-8',$errcode);

    if($error == '0001') {
        echo "<script>alert('사용자 정보 혹은 인증 번호가 맞지 않습니다.');</script>";
    } else if($error == '0011') {
        echo "<script>alert('유효하지 않은 응답입니다.');</script>";
    } else if($error == '0012') {
        echo "<script>alert('유효하지 않은 인증정보 입니다.');</script>";
    } else if($error == '0013') {
        echo "<script>alert('암호화 데이터 처리 오류입니다.');</script>";
    } else if($error == '0014') {
        echo "<script>alert('암호화 프로세스 오류입니다.');</script>";
    } else if($error == '0015') {
        echo "<script>alert('암호화 데이터 오류입니다.');</script>";
    } else if($error == '0016') {
        echo "<script>alert('복호화 프로세스 오류입니다.');</script>";
    } else if($error == '0017') {
        echo "<script>alert('복호화 데이터 오류입니다.');</script>";
    } else if($error == '0018') {
        echo "<script>alert('이동 통신사 통신 오류입니다.');</script>";
    } else if($error == '0020') {
        echo "<script>alert('유효하지 않은 제휴사 코드입니다.');</script>";
    } else if($error == '0021') {
        echo "<script>alert('중단된 제휴사 코드입니다.');</script>";
    } else if($error == '0022') {
        echo "<script>alert('휴대폰 인증 사용이 불가능한 제휴사 코드입니다.');</script>";
    } else if($error == '0031') {
        echo "<script>alert('인증 번호 확인 실패입니다. (데이터 없음)');</script>";
    } else if($error == '0032') {
        echo "<script>alert('인증 번호 확인 실패입니다. (주민번호 불일치)');</script>";
    } else if($error == '0033') {
        echo "<script>alert('인증 번호 확인 실패입니다. (요청 SEQ 불일치)');</script>";
    } else if($error == '0034') {
        echo "<script>alert('인증 번호 확인 실패입니다. (기 처리건)');</script>";
    } else if($error == '0050') {
        echo "<script>alert('명의도용 차단 서비스 가입자입니다.');</script>";
    } else if($error == '9998') {
        echo "<script>alert('본인인증 결과값 전달 실패');</script>";
    } else if($error == '9999') {
        echo "<script>alert('정의되지 않은 오류');</script>";
    }

    echo "<script>self.close();</script>";
?>
</body>
</html>
