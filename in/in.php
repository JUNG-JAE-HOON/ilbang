<?php
    /**************************************************************************************************************
    NICE평가정보 Copyright(c) KOREA INFOMATION SERVICE INC. ALL RIGHTS RESERVED

    서비스명 :  체크플러스 - 안심본인인증 서비스
    페이지명 :  체크플러스 - 메인 호출 페이지
    보안을 위해 제공해드리는 샘플페이지는 서비스 적용 후 서버에서 삭제해 주시기 바랍니다.

    [ PHP 확장모듈 설치 안내 ]
        1. Php.ini 파일의 설정 내용 중 확장모듈 경로(extension_dir)로 지정된 위치에 첨부된 CPClient.so 파일을 복사합니다.
        2. Php.ini 파일에 다음과 같은 설정을 추가 합니다.
             extension=CPClient.so
        3. 아파치 재 시작 합니다.
    **************************************************************************************************************/

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

    $module = "CPClient";
    $sitecode = "AB817";				// NICE로부터 부여받은 사이트 코드
    $sitepasswd = "8BflzwxoxI1k";		// NICE로부터 부여받은 사이트 패스워드
    $authtype = "M";      				// 없으면 기본 선택화면, X: 공인인증서, M: 핸드폰, C: 카드
    $popgubun = "N";				// Y : 취소버튼 있음 / N : 취소버튼 없음
    $customize = "Mobile";			// 없으면 기본 웹페이지 / Mobile : 모바일페이지
    $reqseq = "REQ_0123456789";  	              // 요청 번호, 이는 성공/실패후에 같은 값으로 되돌려주게 되므로

    // 업체에서 적절하게 변경하여 쓰거나, 아래와 같이 생성한다.
    if (extension_loaded($module)) {	// 동적으로 모듈 로드 했을경우
        $reqseq = get_cprequest_no($sitecode);
    } else {
        $reqseq = "Module get_request_no is not compiled into PHP";
    }

    // CheckPlus(본인인증) 처리 후, 결과 데이타를 리턴 받기위해 다음예제와 같이 http부터 입력합니다.
    $returnurl = "http://il-bang.com/pc_renewal/in/inOk.php";	// 성공시 이동될 URL
    $errorurl = "http://il-bang.com/pc_renewal/in/inFail.php";	// 실패시 이동될 URL

    // reqseq값은 성공페이지로 갈 경우 검증을 위하여 세션에 담아둔다.
    $_SESSION["REQ_SEQ"] = $reqseq;

    // 입력될 plain 데이타를 만든다.
    $plaindata =  "7:REQ_SEQ" . strlen($reqseq) . ":" . $reqseq .
	              "8:SITECODE" . strlen($sitecode) . ":" . $sitecode .
		"9:AUTH_TYPE" . strlen($authtype) . ":". $authtype .
		"7:RTN_URL" . strlen($returnurl) . ":" . $returnurl .
		"7:ERR_URL" . strlen($errorurl) . ":" . $errorurl .
		"11:POPUP_GUBUN" . strlen($popgubun) . ":" . $popgubun .
	              "9:CUSTOMIZE" . strlen($customize) . ":" . $customize ;

    if (extension_loaded($module)) {// 동적으로 모듈 로드 했을경우
        $enc_data = get_encode_data($sitecode, $sitepasswd, $plaindata);
    } else {
        $enc_data = "Module get_request_data is not compiled into PHP";
    }

    if($enc_data == -1) {
       $returnMsg = "암/복호화 시스템 오류입니다.";
       $enc_data = "";
    } else if($enc_data== -2) {
        $returnMsg = "암호화 처리 오류입니다.";
        $enc_data = "";
    } else if($enc_data== -3) {
        $returnMsg = "암호화 데이터 오류 입니다.";
        $enc_data = "";
    } else if($enc_data== -9) {
        $returnMsg = "입력값 오류 입니다.";
        $enc_data = "";
    }
?>
 <form name="form_chk" method="post" accept-charset="euc-kr" action="https://nice.checkplus.co.kr/CheckPlusSafeModel/checkplus.cb">
    <input type="hidden" name="m" value="checkplusSerivce" />               <!-- 필수 데이타로, 누락하시면 안됩니다. -->
    <input type="hidden" name="EncodeData" value="<?= $enc_data ?>" />      <!-- 위에서 업체정보를 암호화 한 데이타입니다. -->
    <input type="hidden" id="param1" name="param_r1" value="<?php echo $_GET["id"]; ?>" />
</form>
<script type="text/javascript">
    var checkID = document.getElementById("param1").value;

    if(checkID == "" || checkID == null) {
        alert("정상적인 경로로 이용해주시기 바랍니다.");
        window.opener.location.reload(true);
        self.close();
    } else {
        document.form_chk.submit(); 
    }
</script>
