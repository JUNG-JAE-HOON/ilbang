<?php
    include_once "../db/connect.php";
    include_once "../include/header.php";
    
    
    require_once('libs/INIStdPayUtil.php');
    require_once('libs/HttpClient.php');
    require_once('libs/sha256.inc.php');
    require_once('libs/json_lib.php');
?>
<div class="signupWrap">
    <div class="mt50">
        <h3 class="mb30">주문 / 결제</h3>
        <div class="itemshopPayWrap">
            <div class="center tc">
                <p class="f18"><strong class="fc underline" ><?php echo $item_name;?></strong> 상품을 결제완료 하였습니다.</p>
                <p class="c999 f14" ><?php echo $content;?></p>
            </div>
        </div>
    </div>
    <div class="mt40 mb100">
<?php
    $util = new INIStdPayUtil();

    try {

        if (strcmp("0000", $_REQUEST["resultCode"]) == 0) {
                
                //echo "####인증성공/승인요청####";
                //echo "<br/>";

                //############################################
                // 1.전문 필드 값 설정(***가맹점 개발수정***)
                //############################################

                $mid                = $_REQUEST["mid"];                             // 가맹점 ID 수신 받은 데이터로 설정

                $signKey            = "SU5JTElURV9UUklQTEVERVNfS0VZU1RS";           // 가맹점에 제공된 키(이니라이트키) (가맹점 수정후 고정) !!!절대!! 전문 데이터로 설정금지

                $timestamp          = $util->getTimestamp();                        // util에 의해서 자동생성

                $charset            = "UTF-8";                                      // 리턴형식[UTF-8,EUC-KR](가맹점 수정후 고정)

                $format             = "JSON";                                       // 리턴형식[XML,JSON,NVP](가맹점 수정후 고정)

                $authToken          = $_REQUEST["authToken"];                       // 취소 요청 tid에 따라서 유동적(가맹점 수정후 고정)

                $authUrl            = $_REQUEST["authUrl"];                         // 승인요청 API url(수신 받은 값으로 설정, 임의 세팅 금지)

                $netCancel          = $_REQUEST["netCancelUrl"];                    // 망취소 API url(수신 받은f값으로 설정, 임의 세팅 금지)

                $mKey               = hash("sha256", $signKey);                     // 가맹점 확인을 위한 signKey를 해시값으로 변경 (SHA-256방식 사용)

                //#####################
                // 2.signature 생성
                //#####################
                $signParam["authToken"] = $authToken;       // 필수
                $signParam["timestamp"] = $timestamp;       // 필수
                // signature 데이터 생성 (모듈에서 자동으로 signParam을 알파벳 순으로 정렬후 NVP 방식으로 나열해 hash)
                $signature = $util->makeSignature($signParam);


                //#####################
                // 3.API 요청 전문 생성
                //#####################
                $authMap["mid"]         = $mid;             // 필수
                $authMap["authToken"]   = $authToken;       // 필수
                $authMap["signature"]   = $signature;       // 필수
                $authMap["timestamp"]   = $timestamp;       // 필수
                $authMap["charset"]     = $charset;         // default=UTF-8
                $authMap["format"]      = $format;          // default=XML

                try {

                    $httpUtil = new HttpClient();

                    //#####################
                    // 4.API 통신 시작
                    //#####################

                    $authResultString = "";
                    if ($httpUtil->processHTTP($authUrl, $authMap)) {
                        $authResultString = $httpUtil->body;
                        //echo "<p><b>RESULT DATA :</b> $authResultString</p>";           //PRINT DATA
                    } else {
                        echo "Http Connect Error\n";
                        echo $httpUtil->errormsg;

                        throw new Exception("Http Connect Error");
                    }

                    //############################################################
                    //5.API 통신결과 처리(***가맹점 개발수정***)
                    //############################################################
                    //echo "## 승인 API 결과 ##";
                    
                    $resultMap = json_decode($authResultString, true);
                    //echo "<pre>";
                    //echo "<table width='565' border='0' cellspacing='0' cellpadding='0'>";

                    /*************************  결제보안 추가 2016-05-18 START ****************************/ 
                    $secureMap["mid"]       = $mid;                         //mid
                    $secureMap["tstamp"]    = $timestamp;                   //timestemp
                    $secureMap["MOID"]      = $resultMap["MOID"];           //MOID
                    $secureMap["TotPrice"]  = $resultMap["TotPrice"];       //TotPrice
                    
                    // signature 데이터 생성 
                    $secureSignature = $util->makeSignatureAuth($secureMap);


                    if ((strcmp("0000", $resultMap["resultCode"]) == 0) && (strcmp($secureSignature, $resultMap["authSignature"]) == 0) ){  //결제보안 추가 2016-05-18
                       /*****************************************************************************
                       * 여기에 가맹점 내부 DB에 결제 결과를 반영하는 관련 프로그램 코드를 구현한다.  
                       
                         [중요!] 승인내용에 이상이 없음을 확인한 뒤 가맹점 DB에 해당건이 정상처리 되었음을 반영함
                                  처리중 에러 발생시 망취소를 한다.
                       ******************************************************************************/
                                $merchantData = $_REQUEST['merchantData'];
                                //echo 'merchantData:['.$merchantData.']';

                                parse_str($merchantData);

                                //echo 'item_id['.$item_id.']';
                                //echo 'amount['.$amount.']';


                                $payMethod      = @(in_array($resultMap['payMethod'] , $resultMap) ? $resultMap['payMethod'] : 'null' );
                                $totPrice       = @(in_array($resultMap['TotPrice'] , $resultMap) ? $resultMap['TotPrice'] : 'null' );
                                $applDate       = @(in_array($resultMap['applDate'] , $resultMap) ? $resultMap['applDate'] : 'null' );
                                $applTime       = @(in_array($resultMap['applTime'] , $resultMap) ? $resultMap['applTime'] : 'null' );

                                $cardCode       = @(in_array($resultMap['CARD_Code'] , $resultMap) ? $resultMap['CARD_Code'] : 'null' );
                                $cardQuota      = @(in_array($resultMap['CARD_Quota'] , $resultMap) ? $resultMap['CARD_Quota'] : 'null' );        
                                $cardInterest   = @(in_array($resultMap['CARD_Interest'] , $resultMap) ? $resultMap['CARD_Interest'] : 'null' );  
                                $point          = @(in_array($resultMap['point'] , $resultMap) ? $resultMap['point'] : 'null' );                    
                                $cardBankCode   = @(in_array($resultMap['CARD_BankCode'] , $resultMap) ? $resultMap['CARD_BankCode'] : 'null' );  
                                $cardCheckFlag  = @(in_array($resultMap['CARD_CheckFlag'] , $resultMap) ? $resultMap['CARD_CheckFlag'] : 'null' );  
                                $cardNum        = @(in_array($resultMap['CARD_Num'] , $resultMap) ? $resultMap['CARD_Num'] : 'null' );  



                                       if ($payMethod == "VCard")       { $payMethodNm = '신용카드(ISP)';
                                } else if ($payMethod == "Card")        { $payMethodNm = '신용카드(안심클릭)';
                                } else if ($payMethod == "OCBPoint")    { $payMethodNm = 'OK캐쉬백 포인트';
                                } else if ($payMethod == "GSPT")        { $payMethodNm = 'GS&POINT';
                                } else if ($payMethod == "UPNT")        { $payMethodNm = '삼성 U-point';
                                } else if ($payMethod == "DirectBank")  { $payMethodNm = '실시간계좌이체(K계좌이체)';
                                } else if ($payMethod == "iDirectBank") { $payMethodNm = '실시간계좌이체(I계좌이체)';
                                } else if ($payMethod == "HPP")         { $payMethodNm = '휴대폰';
                                } else if ($payMethod == "VBank")       { $payMethodNm = '무통장입금(가상계좌)';
                                } else if ($payMethod == "PhoneBill")   { $payMethodNm = '폰빌전화결제';
                                } else if ($payMethod == "Culture")     { $payMethodNm = '문화상품권';
                                } else if ($payMethod == "TeenCash")    { $payMethodNm = '틴캐쉬';
                                } else if ($payMethod == "DGCL")        { $payMethodNm = '스마트문화상품';
                                } else if ($payMethod == "BCSH")        { $payMethodNm = '도서문화상품권';
                                } else if ($payMethod == "HPMN")        { $payMethodNm = '해피머니상품권';
                                } else if ($payMethod == "YPAY")        { $payMethodNm = '옐로페이';
                                } else if ($payMethod == "EWallet")     { $payMethodNm = '뱅크월렛';
                                } else if ($payMethod == "Auth")        { $payMethodNm = '싱용카드빌링키발급';
                                }

                                       if ($cardCode == "01") { $cardCodeNm = "하나(외환)";
                                } else if ($cardCode == "03") { $cardCodeNm = "롯데";
                                } else if ($cardCode == "04") { $cardCodeNm = "현대";
                                } else if ($cardCode == "06") { $cardCodeNm = "국민";
                                } else if ($cardCode == "11") { $cardCodeNm = "BC";
                                } else if ($cardCode == "12") { $cardCodeNm = "삼성";
                                } else if ($cardCode == "14") { $cardCodeNm = "신한";
                                } else if ($cardCode == "21") { $cardCodeNm = "해외 VISA";
                                } else if ($cardCode == "22") { $cardCodeNm = "해외마스터";
                                } else if ($cardCode == "23") { $cardCodeNm = "해외 JCB";
                                } else if ($cardCode == "26") { $cardCodeNm = "중국은련";
                                } else if ($cardCode == "32") { $cardCodeNm = "광주";
                                } else if ($cardCode == "33") { $cardCodeNm = "전북";
                                } else if ($cardCode == "34") { $cardCodeNm = "하나";
                                } else if ($cardCode == "35") { $cardCodeNm = "산업카드";
                                } else if ($cardCode == "41") { $cardCodeNm = "NH";
                                } else if ($cardCode == "43") { $cardCodeNm = "씨티";
                                } else if ($cardCode == "44") { $cardCodeNm = "우리";
                                } else if ($cardCode == "48") { $cardCodeNm = "신협체크";
                                } else if ($cardCode == "51") { $cardCodeNm = "수협";
                                } else if ($cardCode == "52") { $cardCodeNm = "제주";
                                } else if ($cardCode == "54") { $cardCodeNm = "MG새마을금고체크";
                                } else if ($cardCode == "71") { $cardCodeNm = "우체국체크";
                                } else if ($cardCode == "95") { $cardCodeNm = "저축은행체크";
                                }

                                if (isset($resultMap["EventCode"]) && isset($resultMap["CARD_Interest"]) && (strcmp("1", $resultMap["CARD_Interest"]) == 0 || strcmp("1", $resultMap["EventCode"]) == 0 )) {
                                    $cardInterestNm = "무이자";
                                } else if (isset($resultMap["CARD_Interest"]) && !strcmp("1", $resultMap["CARD_Interest"]) == 0) {
                                    $cardInterestNm = "유이자";
                                }


                                if (isset($resultMap["point"]) && strcmp("1", $resultMap["point"]) == 0) {
                                        $pointNm = "사용";
                                } else {
                                        $pointNm = "미사용";
                                }

                                if ($cardQuota == "00") { $cardQuotaNm = "일시불";

                                }

                                       if ($cardBankCode == "02") { $cardBankCodeNm = "한국산업은행";
                                } else if ($cardBankCode == "03") { $cardBankCodeNm = "기업은행";

                                } else if ($cardBankCode == "04") { $cardBankCodeNm = "국민은행 (주택은행)";
                                } else if ($cardBankCode == "05") { $cardBankCodeNm = "하나은행 (구외환)";
                                } else if ($cardBankCode == "07") { $cardBankCodeNm = "수협중앙회";
                                } else if ($cardBankCode == "11") { $cardBankCodeNm = "농협중앙회";
                                } else if ($cardBankCode == "12") { $cardBankCodeNm = "단위농협";
                                } else if ($cardBankCode == "16") { $cardBankCodeNm = "축협중앙회";
                                } else if ($cardBankCode == "20") { $cardBankCodeNm = "우리은행";
                                } else if ($cardBankCode == "21") { $cardBankCodeNm = "신한은행 (조흥은행)";
                                } else if ($cardBankCode == "23") { $cardBankCodeNm = "제일은행";
                                } else if ($cardBankCode == "25") { $cardBankCodeNm = "하나은행 (서울은행)";
                                } else if ($cardBankCode == "26") { $cardBankCodeNm = "신한은행";

                                } else if ($cardBankCode == "27") { $cardBankCodeNm = "한국씨티은행 (한미은행)";
                                } else if ($cardBankCode == "31") { $cardBankCodeNm = "대구은행";
                                } else if ($cardBankCode == "32") { $cardBankCodeNm = "부산은행";

                                } else if ($cardBankCode == "34") { $cardBankCodeNm = "광주은행";
                                } else if ($cardBankCode == "35") { $cardBankCodeNm = "제주은행";
                                } else if ($cardBankCode == "37") { $cardBankCodeNm = "전북은행";
                                } else if ($cardBankCode == "38") { $cardBankCodeNm = "강원은행";
                                } else if ($cardBankCode == "39") { $cardBankCodeNm = "경남은행";
                                } else if ($cardBankCode == "41") { $cardBankCodeNm = "비씨카드";
                                } else if ($cardBankCode == "53") { $cardBankCodeNm = "씨티은행";
                                } else if ($cardBankCode == "54") { $cardBankCodeNm = "홍콩상하이은행";
                                } else if ($cardBankCode == "71") { $cardBankCodeNm = "우체국";
                                } else if ($cardBankCode == "81") { $cardBankCodeNm = "하나은행";
                                } else if ($cardBankCode == "83") { $cardBankCodeNm = "평화은행";
                                } else if ($cardBankCode == "87") { $cardBankCodeNm = "신세계";
                                } else if ($cardBankCode == "88") { $cardBankCodeNm = "신한은행(조흥 통합)";

                                }

                                $sql = "
                                    INSERT INTO inis_result_data (tid, pay_method, result_code, result_msg, appl_date, apple_time, mid, `oid`, good_name, total_price, buyer_name, buyer_tel, buyer_email, uid, card_code, card_quota, card_interest, `point`, card_bankcode, card_checkflag, card_num, amount)
                                    VALUES (
                                              '".@(in_array($resultMap['tid'] , $resultMap) ? $resultMap['tid'] : 'null' )."'
                                            , '".$payMethodNm."'
                                            , '".@(in_array($resultMap['resultCode'] , $resultMap) ? $resultMap['resultCode'] : 'null' )."'
                                            , '".@(in_array($resultMap['resultMsg'] , $resultMap) ? $resultMap['resultMsg'] : 'null' )."'
                                            , '".$applDate."'
                                            , '".$applTime ."'
                                            , '".$mid."'
                                            , '".@(in_array($resultMap['MOID'] , $resultMap) ? substr($resultMap['MOID'],strrpos($resultMap['MOID'],'_')) : 'null' )."'
                                            , '".@(in_array($resultMap['goodName'] , $resultMap) ? $resultMap['goodName'] : 'null' )."'
                                            , '".$totPrice."'
                                            , '".@(in_array($resultMap['buyerName'] , $resultMap) ? $resultMap['buyerName'] : 'null' )."'
                                            , '".@(in_array($resultMap['buyerTel'] , $resultMap) ? $resultMap['buyerTel'] : 'null' )."'
                                            , '".@(in_array($resultMap['buyerEmail'] , $resultMap) ? $resultMap['buyerEmail'] : 'null' )."'
                                            , '".$uid."'
                                            , '$cardCodeNm'
                                            , '$cardQuotaNm'
                                            , '$cardInterestNm'
                                            , '$pointNm'
                                            , '$cardBankCodeNm'
                                            , '$cardCheckFlag'
                                            , '$cardNum'
                                            ,  $amount
                                            )
                                ";

                                $yyyy   = substr($applDate, 0, 4);
                                $mm     = substr($applDate, 4, 2);
                                $dd     = substr($applDate, 6, 2);
                                
                                $apple_date = $yyyy."-".$mm."-".$dd;


                                $HH   = substr($applTime, 0, 2);
                                $mm   = substr($applTime, 2, 2);
                                $ss   = substr($applTime, 4, 2);

                                $apple_time = $HH.":".$mm.":".$ss;


                                $oDateA = date('Y-m-d H:i:s', strtotime($apple_date." ".$apple_time));

                                //echo 
                                //echo $oDateA;


                                //echo 'sql:['.$sql.']';

                                $result = mysql_query($sql, $ilbang_con);

                                //echo '결과:['.$result.']';

                                //if ($cardCheckFlag == "1") $cardCheckFlag = "체크카드 입니다.";


                        //echo "<tr><th class='td01'><p>거래 성공 여부</p></th>";
                        //echo "<td class='td02'><p>성공</p></td></tr>";

                               

                               $sql = " 
                                        SELECT no as member_no, valid_no
                                          FROM member
                                         WHERE 1=1
                                          AND uid = '$uid'
                                      ";


                                $result = mysql_query($sql);

                                while($row = mysql_fetch_array($result)) {
                                    $member_no  = $row["member_no"];
                                    $valid_no   = $row["valid_no"];
                                }      

                                // get item_type, id, item_name
                                $sql = "
                                        SELECT IF(item_type='consume','소모',IF(item_type='term','기간','분류없음')) as item_type
                                              , id
                                              , item_name
                                              , item_kind  
                                        FROM item_data
                                        WHERE 1=1
                                        AND item_id = '$item_id'
                                        ";

                                $result = mysql_query($sql);

                                while($row = mysql_fetch_array($result)) {
                                    $item_type = $row["item_type"];
                                    $item_no   = $row["id"];
                                    $item_name = $row["item_name"];
                                    $item_kind = $row["item_kind"];
                                }
                                $start_date = null;
                                $end_date   = null;
                                $wdate      = date("Y-m-d H:i:s");

                                
                                if ($item_type == "소모"  ) { // 소모 아이템 : 악평지우기 1회 || 긴급구인1회 || 이력서 열람 1회
                                        $sql = "
                                                UPDATE work_item
                                                SET count = count + $amount
                                                ,   wdate = '$wdate'
                                                WHERE 1=1
                                                AND uid     = '$uid'
                                                AND item_id = '$item_no'
                                               ";

                                        $result = mysql_query($sql);

                                        if (mysql_affected_rows()==0) { // 업데이트개수가 0 이면(기존거수정할거없으면) 아이템 등록.

                                            $sql = "    INSERT INTO work_item (type, count,  wdate, item_name, member_no, valid_no, uid, item_id, item_kind)
                                                        VALUES ('$item_type', '$amount',  '$wdate', '$item_name', '$member_no', '$valid_no', '$uid','$item_no','$item_kind' )
                                                    ";

                                            $result = mysql_query($sql);
                                        }

                                } else if ($item_id == "inis.reading1weekbuy"   ) { // 이력서 열람 7일 무제한

                                    $start_date = $oDateA;
                                    $end_date   = date('Y-m-d H:i:s', strtotime($start_date. ' + 7 days'));

                                    $sql = "
                                                UPDATE work_item
                                                SET     start_date = '$start_date'
                                                    ,   end_date = '$end_date'
                                                WHERE 1=1
                                                AND uid     = '$uid'
                                                AND item_id = '$item_no'
                                           ";

                                    $result = mysql_query($sql);
                                    
                                    if (mysql_affected_rows()==0) { // 업데이트개수가 0 이면(기존거수정할거없으면) 아이템 등록.   

                                            $sql = "    INSERT INTO work_item (type, count, start_date, end_date, wdate, item_name, member_no, valid_no, uid, item_id, item_kind)
                                                        VALUES ('$item_type', '$amount', '$start_date','$end_date', '$wdate', '$item_name', '$member_no', '$valid_no', '$uid','$item_no' ,'$item_kind' )
                                                    ";

                                            $result = mysql_query($sql);

                                    }

                                } else if ($item_id == "inis.reading1monthbuy"  ) { // 이력서 열람 한달 무제한 

                                    $start_date = $oDateA;
                                    $end_date   = date('Y-m-d H:i:s', strtotime($start_date. ' + 1 month'));


                                    $sql = "
                                                UPDATE work_item
                                                SET     start_date = '$start_date'
                                                    ,   end_date = '$end_date'
                                                WHERE 1=1
                                                AND uid     = '$uid'
                                                AND item_id = '$item_no'
                                           ";

                                    $result = mysql_query($sql);

                                    if (mysql_affected_rows()==0) { // 업데이트개수가 0 이면(기존거수정할거없으면) 아이템 등록.   


                                        $sql = "    INSERT INTO work_item (type, count, start_date, end_date, wdate, item_name, member_no, valid_no, uid, item_id, item_kind)
                                                    VALUES ('$item_type', '$amount', '$start_date','$end_date', '$wdate', '$item_name', '$member_no', '$valid_no', '$uid','$item_no', '$item_kind' )
                                                ";

                                        $result = mysql_query($sql);
                                    }

                                } else if ($item_kind == "vip"  ) { // vip

                                    $start_date = $oDateA;


                                           if($item_id == "inis.vip1day" )  {      $end_date   = date('Y-m-d H:i:s', strtotime($start_date. ' + 1 days'));
                                    } else if ($item_id == "inis.vip7days") {      $end_date   = date('Y-m-d H:i:s', strtotime($start_date. ' + 7 days'));
                                    } else if ($item_id == "inis.vip15days"){      $end_date   = date('Y-m-d H:i:s', strtotime($start_date. ' + 15 days'));
                                    } else if ($item_id == "inis.vip30days"){      $end_date   = date('Y-m-d H:i:s', strtotime($start_date. ' + 1 month'));
                                    }

                                    $sql = "    INSERT INTO work_item (type, count, start_date, end_date, wdate, item_name, member_no, valid_no, uid, item_id, item_kind)
                                                        VALUES ('$item_type', '$amount', '$start_date','$end_date', '$wdate', '$item_name', '$member_no', '$valid_no', '$uid','$item_no', '$item_kind' )
                                           ";

                                    $result = mysql_query($sql);

                                    if(mysql_affected_rows()==1) { // 등록한 개수가 1이면 메인에 노출

                                        $sql = " INSERT INTO pc_vip_employ (employ_no, start_date, end_date, free_end_date, price, wdate)
                                                 VALUES ('$employ_no','$start_date','$end_date','$end_date','$totPrice', '$start_date') ";

                                        $result = mysql_query($sql);       

                                    }
                                    

                                } else if ($item_kind == "platinum"  ) { // platinum

                                    $start_date = $oDateA;


                                           if($item_id == "inis.platinum1day" )  {  $end_date   = date('Y-m-d H:i:s', strtotime($start_date. ' + 1 days'));
                                    } else if ($item_id == "inis.platinum7days") {  $end_date   = date('Y-m-d H:i:s', strtotime($start_date. ' + 7 days'));
                                    } else if ($item_id == "inis.platinum15days"){  $end_date   = date('Y-m-d H:i:s', strtotime($start_date. ' + 15 days'));
                                    } else if ($item_id == "inis.platinum30days"){  $end_date   = date('Y-m-d H:i:s', strtotime($start_date. ' + 1 month'));
                                    }

                            
                                    $sql = "    INSERT INTO work_item (type, count, start_date, end_date, wdate, item_name, member_no, valid_no, uid, item_id, item_kind)
                                                VALUES ('$item_type', '$amount', '$start_date','$end_date', '$wdate', '$item_name', '$member_no', '$valid_no', '$uid','$item_no','$item_kind' )
                                            ";

                                    $result = mysql_query($sql);
                                    

                                    if(mysql_affected_rows()==1) { // 등록한 개수가 1이면 메인에 노출

                                        $sql = " INSERT INTO pc_platinum_employ (employ_no, start_date, end_date, free_end_date, price, wdate)
                                                 VALUES ('$employ_no','$start_date','$end_date','$end_date','$totPrice', '$start_date') ";

                                        $result = mysql_query($sql);       

                                    }


                                } else if ($item_kind == "grand"  ) { // grand

                                    $start_date = $oDateA; 

                                           if($item_id == "inis.grand1day"  )   {    $end_date   = date('Y-m-d H:i:s', strtotime($start_date. ' + 1 days'));
                                    } else if ($item_id == "inis.grand7days")   {    $end_date   = date('Y-m-d H:i:s', strtotime($start_date. ' + 7 days'));
                                    } else if ($item_id == "inis.grand15days")  {    $end_date   = date('Y-m-d H:i:s', strtotime($start_date. ' + 15 days'));
                                    } else if ($item_id == "inis.grand30days")  {    $end_date   = date('Y-m-d H:i:s', strtotime($start_date. ' + 1 month'));
                                    }



                                    $sql = "    INSERT INTO work_item (type, count, start_date, end_date, wdate, item_name, member_no, valid_no, uid, item_id, item_kind)
                                                VALUES ('$item_type', '$amount', '$start_date','$end_date', '$wdate', '$item_name', '$member_no', '$valid_no', '$uid','$item_no','$item_kind' )
                                            ";

                                    $result = mysql_query($sql);


                                    if(mysql_affected_rows()==1) { // 등록한 개수가 1이면 메인에 노출

                                        $sql = " INSERT INTO pc_grand_employ (employ_no, start_date, end_date, free_end_date, price, wdate)
                                                 VALUES ('$employ_no','$start_date','$end_date','$end_date','$totPrice', '$start_date') ";

                                        $result = mysql_query($sql);       

                                    }



                                } else if ($item_kind == "special"  ) { // special

                                    $start_date = $oDateA;    
                                    
                                    
                                    if($item_id == "inis.special1day" ){            $end_date   = date('Y-m-d H:i:s', strtotime($start_date. ' + 1 days'));
                                    } else if ($item_id == "inis.special7days") {   $end_date   = date('Y-m-d H:i:s', strtotime($start_date. ' + 7 days'));
                                    } else if ($item_id == "inis.special15days") {  $end_date   = date('Y-m-d H:i:s', strtotime($start_date. ' + 15 days'));
                                    } else if ($item_id == "inis.special30days") {  $end_date   = date('Y-m-d H:i:s', strtotime($start_date. ' + 1 month'));
                                    }


                                    $sql = "    INSERT INTO work_item (type, count, start_date, end_date, wdate, item_name, member_no, valid_no, uid, item_id, item_kind)
                                                VALUES ('$item_type', '$amount', '$start_date','$end_date', '$wdate', '$item_name', '$member_no', '$valid_no', '$uid','$item_no', '$item_kind' )
                                            ";

                                    $result = mysql_query($sql); 


                                    if(mysql_affected_rows()==1) { // 등록한 개수가 1이면 메인에 노출

                                        $sql = " INSERT INTO pc_special_employ (employ_no, start_date, end_date, free_end_date, price, wdate)
                                                 VALUES ('$employ_no','$start_date','$end_date','$end_date','$totPrice', '$start_date') ";

                                        $result = mysql_query($sql);       

                                    }
                                }                                     

                                //echo $sql;
                                  

?>

        <h4 class="f16">주문 결제정보</h4>
        <div class="itemshopPay oh mt10">
             <div class="oh border-bottom">
                <div class="di w15 noMargin sect2head bg_grey lh40 f14 tc bold">상품이름</div>
                <div class="sect2Table di lh40 f12 tc noMargin pdl20 c999" ><?php echo $item_name?></div>
            </div>
            <?php
                if($item_type == "소모") { 
            ?>
            <div class="oh border-bottom">
                <div class="di w15 noMargin sect2head bg_grey lh40 f14 tc bold">구매개수</div>
                <div class="sect2Table di lh40 f12 tc noMargin pdl20 c999" ><?php echo $amount?></div>
            </div>
            <?php
                }
            ?>

            <div class="oh border-bottom">
                <div class="di w15 noMargin sect2head bg_grey lh40 f14 tc bold">결제방법</div>
                <div class="sect2Table di lh40 f12 tc noMargin pdl20 c999" ><?php echo $payMethodNm?></div>
            </div>
            <div class="oh border-bottom">
                <div class="di w15 noMargin sect2head bg_grey lh40 f14 tc bold">결제완료금액</div>
                <div class="sect2Table di lh40 f12 tc noMargin pdl20 fc bold" ><? echo number_format($totPrice) ?> 원</div>
            </div>
            <div class="oh border-bottom">
                <div class="di w15 noMargin sect2head bg_grey lh40 f14 tc bold">주문번호</div>
                <div class="sect2Table di lh40 f12 tc noMargin pdl20" ><?php echo $orderNumber;?> </div>
            </div>
            <div class="oh border-bottom">
                <div class="di w15 noMargin sect2head bg_grey lh40 f14 tc bold">승인날짜</div>
                <div class="sect2Table di lh40 f12 tc noMargin pdl20" ><?php echo date_format(date_create($applDate), "Y-m-d")?> </div>
            </div>
            <div class="oh border-bottom">
                <div class="di w15 noMargin sect2head bg_grey lh40 f14 tc bold">승인시간</div>
                <div class="sect2Table di lh40 f12 tc noMargin pdl20" ><?php echo date_format(date_create($applTime), "H:i:s")?> </div>
            </div>
            <div class="oh border-bottom">
                <div class="di w15 noMargin sect2head bg_grey lh40 f14 tc bold">카드번호</div>
                <div class="sect2Table di lh40 f12 tc noMargin pdl20" ><?php echo $cardNum ?></div><!-- 945821*********0  -->
            </div>
            <!--
            <div class="oh border-bottom">
                <div class="di w15 noMargin sect2head bg_grey lh40 f14 tc bold">할부기간</div>
                <div class="sect2Table di lh40 f12 tc noMargin pdl20" ><?php echo $cardQuotaNm?></div>
                -->
                <!-- 일시불 / <span class="c999">이벤트 코드 (상점 무이자 + 카드 Prefix별 할인 이벤트)</span> -->
            <!--</div>
            -->
             <!-- <div class="oh border-bottom">
                <div class="di w15 noMargin sect2head bg_grey lh40 f14 tc bold">할부 유형</div>
                <div class="sect2Table di lh40 f12 tc noMargin pdl20" ><?php $cardInterestNm?><span class="c999">*유이자로 표시되더라도 EventCode 및 EDI에 따라 무이자 처리가 될 수 있습니다.</span> </div>
            </div>-->
            <!--
             <div class="oh border-bottom">
                <div class="di w15 noMargin sect2head bg_grey lh40 f14 tc bold">포인트 사용 여부</div>
                <div class="sect2Table di lh40 f12 tc noMargin pdl20" ><?php echo $pointNm?></div>
            </div>
            -->
            <div class="oh border-bottom">
                <div class="di w15 noMargin sect2head bg_grey lh40 f14 tc bold">카드종류</div>
                <div class="sect2Table di lh40 f12 tc noMargin pdl20" ><?php echo $cardCodeNm?> </div>
            </div>
            <div class="oh border-bottom">
                <div class="di w15 noMargin sect2head bg_grey lh40 f14 tc bold">카드 발급사</div>
                <div class="sect2Table di lh40 f12 tc noMargin pdl20" ><?php echo $cardBankCodeNm?></div>
            </div>
            <!--
            <div class="oh border-bottom">
                <div class="di w15 noMargin sect2head bg_grey lh40 f14 tc bold">체크카드 여부</div>
                <div class="sect2Table di lh40 f12 tc noMargin pdl20" ><?php echo  $cardCheckFlag?></div>
            </div>
            -->
        </div>
    </div>
    </form>
  
<?php
                    } else {
                        echo "<tr><th class='td01'><p>거래 성공 여부</p></th>";
                        echo "<td class='td02'><p>실패</p></td></tr>";
                        echo "<tr><th class='line' colspan='2'><p></p></th></tr>
                            <tr><th class='td01'><p>결과 코드</p></th>
                            <td class='td02'><p>" . @(in_array($resultMap["resultCode"] , $resultMap) ? $resultMap["resultCode"] : "null" ) . "</p></td></tr>";
                        
                        //결제보안키가 다른 경우.
                        if (strcmp($secureSignature, $resultMap["authSignature"]) != 0) {
                            echo "<tr><th class='line' colspan='2'><p></p></th></tr>
                                <tr><th class='td01'><p>결과 내용</p></th>
                                <td class='td02'><p>" . "* 데이터 위변조 체크 실패" . "</p></td></tr>";

                            //망취소
                            if(strcmp("0000", $resultMap["resultCode"]) == 0) {
                                throw new Exception("데이터 위변조 체크 실패");
                            }
                        } else {
                            echo "<tr><th class='line' colspan='2'><p></p></th></tr>
                                <tr><th class='td01'><p>결과 내용</p></th>
                                <td class='td02'><p>" . @(in_array($resultMap["resultMsg"] , $resultMap) ? $resultMap["resultMsg"] : "null" ) . "</p></td></tr>";
                        }

                    }


?>



<?php


                } catch (Exception $e) {
                    //    $s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
                    //####################################
                    // 실패시 처리(***가맹점 개발수정***)
                    //####################################
                    //---- db 저장 실패시 등 예외처리----//
                    $s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
                    echo $s;

                    //#####################
                    // 망취소 API
                    //#####################

                    $netcancelResultString = ""; // 망취소 요청 API url(고정, 임의 세팅 금지)
                    if ($httpUtil->processHTTP($netCancel, $authMap)) {
                        $netcancelResultString = $httpUtil->body;
                    } else {
                        echo "Http Connect Error\n";
                        echo $httpUtil->errormsg;

                        throw new Exception("Http Connect Error");
                    }

                    echo "<br/>## 망취소 API 결과 ##<br/>";
                    
                    /*##XML output##*/
                    //$netcancelResultString = str_replace("<", "&lt;", $$netcancelResultString);
                    //$netcancelResultString = str_replace(">", "&gt;", $$netcancelResultString);

                    // 취소 결과 확인
                    echo "<p>". $netcancelResultString . "</p>";
                
                }


        } else {

            //#############
            // 인증 실패시
            //#############
            echo "<br/>";
            echo "####인증실패####";

            echo "<pre>" . var_dump($_REQUEST) . "</pre>";
        }

    } catch (Exception $e) {
        $s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
        echo $s;
    }
?>
  <div class="center tc mb100">
        <a href="../../index.php" class="c-red beforeBtn">메인으로</a>
        <!-- <a href="../my-page/myInfo-general.php?tab=3" class="fff nextBtn">아이템관리</a> -->
        <!-- <a href="itemshop.php" class="fff nextBtn">아이템샵 가기</a>-->
        <a href="../../my-page/myInfo-comp.php?tab=3" class="fff nextBtn">아이템결제내역 보기</a>
        
    </div>
    
</div>

<?php include_once "../include/footer.php" ?>