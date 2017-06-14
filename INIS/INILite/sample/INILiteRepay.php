<?php
/* * INIlite_repay.php
 *
 * 이미 정상 승인된 거래에서 취소를 원하는 금액을 입력하여 다시 승인을 득하도록 요청한다.
 * 
 * [주의] 취소 후 재승인이므로 새 거래아이디가 반환되나, 원거래 TID로 부분취소(재승인)이 가능함에 유의
 * [주의] 원거래가 신용카드 지불인 경우에만 가능
 * (OK 캐쉬백 적립 등이 포함되어 있어도 불가)
 * [주의] 반드시 취소할 금액을 입력하도록 함
 *  
 * Date : 2010/11
 * Author : ts@inicis.com
 * Project : INILITE_V2 INIAPI PHP
 * 
 * http://www.inicis.com
 * Copyright (C) 2008 Inicis, Co. All rights reserved.
 */

	/**************************
	 * 1. 라이브러리 인클루드 *
	 **************************/
	require("../libs/INILiteLib.php");
	
	
	/***************************************
	 * 2. INILite 클래스의 인스턴스 생성 *
	 ***************************************/
	$inipay = new INILite;


	/*********************
	 * 3. 지불 정보 설정 *
	 *********************/
	$inipay->m_inipayHome = "/usr/local/INILite_php"; //상점 수정 필요
	$inipay->m_key = "SU5JTElURV9UUklQTEVERVNfS0VZU1RS";  //상점 관리자에서 발급된 가맹점의 대칭키를 설정 합니다.(merchantkey)
	$inipay->m_pgId = "INIphpRPAY";      // 고정 (절대 수정 불가)
	$inipay->m_ssl = "true"; 				//ssl지원하면 true로 셋팅해 주세요.
	$inipay->m_type = "repay"; 			// 고정 (절대 수정 불가) // 부분취소 : repay
	$inipay->m_log = "true";              // true로 설정하면 로그가 생성됨(적극권장)
	$inipay->m_debug = "true";              // 로그모드("true"로 설정하면 상세로그가 생성됨. 적극권장)
	$inipay->m_mid = $mid; 					// 상점아이디
	$inipay->m_oldtid = $oldtid;				//  원거래번호
	$inipay->m_uip = getenv("REMOTE_ADDR"); 		// 고정 (절대 수정 불가)
	$inipay->m_currency = $currency;			// 화폐단위
	$inipay->m_price = $price;							// 취소할금액
	$inipay->m_confirm_price = $confirm_price;			// 취소할금액
	$inipay->m_encrypted = $encrypted;			// 암호문
	
	/****************
	 * 4. 지불 요청 *
	 ****************/
	$inipay->startAction();
	
	
	/****************************************************************
	 *  5. 결과
	****************************************************************/
	/*
	$this->m_mid 			= $xml->getXMLData('mid');
	$this->m_tid 			= $xml->getXMLData('tid');							// 신거래번호
	$this->m_resultCode 	= $xml->getXMLData('resultcode');			// 결과코드 ("00"이면 성공)
	$this->m_resultMsg 		= $xml->getXMLData('resultmessage');			// 결과내용 (결과에 대한 설명)
	$this->m_prtc_tid 		= $xml->getXMLData('prtc_tid');				// 원거래 번호
	$this->m_prtc_remains 	= $xml->getXMLData('prtc_remains');		// 최종결제 금액
	$this->m_prtc_price 	= $xml->getXMLData('prtc_price');			// 부분취소 금액
	$this->m_prtc_type 		= $xml->getXMLData('prtc_type');				// 부분취소 구분값(또는 재승인 구분값, "0"-재승인, "1"-부분취소)
	$this->m_prtc_cnt 		= $xml->getXMLData('prtc_cnt');				// 부분취소(재승인) 요청횟수
	*/
	
?>


<!-------------------------------------------------------------------------------------------------------
 *  													*
 *       												*
 *        												*
 *	아래 내용은 결제 결과에 대한 출력 페이지 샘플입니다. 				                *
 *													*
 *													*
 *													*
 -------------------------------------------------------------------------------------------------------->
 
<html>
<head>
<title>INILITE-INIAPI PHP 부분취소 데모</title>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<link rel="stylesheet" href="css/group.css" type="text/css">
<style>
body, tr, td {font-size:10pt; font-family:굴림,verdana; color:#433F37; line-height:19px;}
table, img {border:none}

/* Padding ******/ 
.pl_01 {padding:1 10 0 10; line-height:19px;}
.pl_03 {font-size:20pt; font-family:굴림,verdana; color:#FFFFFF; line-height:29px;}

/* Link ******/ 
.a:link  {font-size:9pt; color:#333333; text-decoration:none}
.a:visited { font-size:9pt; color:#333333; text-decoration:none}
.a:hover  {font-size:9pt; color:#0174CD; text-decoration:underline}

.txt_03a:link  {font-size: 8pt;line-height:18px;color:#333333; text-decoration:none}
.txt_03a:visited {font-size: 8pt;line-height:18px;color:#333333; text-decoration:none}
.txt_03a:hover  {font-size: 8pt;line-height:18px;color:#EC5900; text-decoration:underline}
</style>

<script>
	var openwin=window.open("childwin.html","childwin","width=299,height=149");
	openwin.close();
	
</script>

<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
</script>
</head>
<body bgcolor="#FFFFFF" text="#242424" leftmargin=0 topmargin=15 marginwidth=0 marginheight=0 bottommargin=0 rightmargin=0><center> 
<table width="632" border="0" cellspacing="0" cellpadding="0">
  <tr> 
  <?    // 지불 수단에 따라 상단 이미지가 변경된다.
   	$background_img = "img/spool_top.gif";    //default image
   	
   	if ($inipay->m_resultCode =="01"){
   	    $background_img = "img/card.gif";
   	}
?>
    <td height="83" background="<?=$background_img?>"style="padding:0 0 0 64">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="3%" valign="top"><img src="img/title_01.gif" width="8" height="27" vspace="5"></td>
          <td width="97%" height="40" class="pl_03"><font color="#FFFFFF"><b>부분취소 결과</b></font></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td align="center" bgcolor="6095BC">
      <table width="620" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td bgcolor="#FFFFFF" style="padding:0 0 0 56">
		  <table width="510" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td width="7"><img src="img/life.gif" width="7" height="30"></td>
                <td background="img/center.gif"><img src="img/icon03.gif" width="12" height="10">
                 <b>
	                 <?
		                 if($inipay->m_resultCode == "00"){
		              ?>
		                 	고객님의 부분취소 요청이 성공되었습니다.
		               <?  }else{?>
		                 	고객님의 부분취소 요청이 실패되었습니다.
		                <? }?>
                 </b></td>
                <td width="8"><img src="img/right.gif" width="8" height="30"></td>
              </tr>
            </table>
            <br>
            <table width="510" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td width="407"  style="padding:0 0 0 9"><img src="img/icon.gif" width="10" height="11"> 
                  <strong><font color="433F37">결 제 내 역</font></strong></td>
                <td width="103">&nbsp;</td>                
              </tr>
              <tr> 
                <td colspan="2"  style="padding:0 0 0 23">
		  <table width="470" border="0" cellspacing="0" cellpadding="0">
                    <tr> 
                      <td width="18" align="center"><img src="img/icon02.gif" width="7" height="7"></td>
                      <td width="109" height="26">결 과 코 드</td>
                      <td width="343"><?php echo($inipay->m_resultCode); ?></td>
                    </tr>
                     <tr> 
                      <td height="1" colspan="3" align="center"  background="img/line.gif"></td>
                    </tr>
                    <tr> 
                      <td width="18" align="center"><img src="img/icon02.gif" width="7" height="7"></td>
                      <td width="109" height="25">결 과 내 용</td>
                      <td width="343"><?php echo($inipay->m_resultMsg); ?></td>
                    </tr>
                    <tr> 
                      <td height="1" colspan="3" align="center"  background="img/line.gif"></td>
                    </tr>
                    <tr> 
                      <td width="18" align="center"><img src="img/icon02.gif" width="7" height="7"></td>
                      <td width="109" height="25">원거래 번호</td>
                      <td width="343"><?php echo($inipay->m_prtc_tid); ?></td>
                    </tr>
                    <tr> 
                      <td height='1' colspan='3' align='center'  background='img/line.gif'></td>
                    </tr>
                    <tr> 
                      <td width="18" align="center"><img src="img/icon02.gif" width="7" height="7"></td>
                      <td width="109" height="25">거 래 번 호</td>
                      <td width="343"><?php echo($inipay->m_tid); ?></td>
                    </tr>
                    <tr> 
                      <td height="1" colspan="3" align="center"  background="img/line.gif"></td>
                    </tr>
                    <tr> 
                      <td width='18' align='center'><img src='img/icon02.gif' width='7' height='7'></td>
                      <td width='109' height='25'>최종결제금액 </td>
                      <td width='343'><?php echo($inipay->m_prtc_remains); ?></td>
                    </tr>
                    <tr> 
                      <td height='1' colspan='3' align='center'  background='img/line.gif'></td>
                    </tr>
                    <tr> 
                      <td width='18' align='center'><img src='img/icon02.gif' width='7' height='7'></td>
                      <td width='109' height='25'>취 소 금 액</td>
                      <td width='343'><?php echo($inipay->m_prtc_price); ?></td>
                    </tr>
                    <tr> 
                      <td height='1' colspan='3' align='center'  background='img/line.gif'></td>
                    </tr>
                    <tr> 
                      <td width='18' align='center'><img src='img/icon02.gif' width='7' height='7'></td>
                      <td width='109' height='25'>부분취소(재승인) 구분 </td>
                      <td width='343'><b><font color=blue>(<?
                      				if($inipay->m_prtc_type == "0"){
                      				?>
                      					재승인
                      				<?}else{?>
                      					부분취소
                      				<?}?>)</font></b></td>
                    </tr>
                    <tr> 
                      <td height='1' colspan='3' align='center'  background='img/line.gif'></td>
                    </tr>
                    <tr> 
                      <td width='18' align='center'><img src='img/icon02.gif' width='7' height='7'></td>
                      <td width='109' height='25'>부분취소(재승인)요청 횟수 </td>
                      <td width='343'><?php echo($inipay->m_prtc_cnt); ?></td>
                    </tr>
                    <tr> 
                      <td height='1' colspan='3' align='center'  background='img/line.gif'></td>
                    </tr>
                   </table></td>
              </tr>
            </table>
            <br>
	    <table width='510' border='0' cellspacing='0' cellpadding='0'>
               <tr> 
                   <td height='25'  style='padding:0 0 0 9'><img src='img/icon.gif' width='10' height='11'> 
                     <strong><font color='433F37'>이용안내</font></strong></td>
                 </tr>
                 <tr> 
                   <td  style='padding:0 0 0 23'> 
                     <table width='470' border='0' cellspacing='0' cellpadding='0'>
                       <tr>          					          
                         <td height='25'>(1)국민, BC, 삼성, LG카드만 부분취소가 가능합니다. <br>
                         (2)부분취소 최대금액과 가능횟수은 각 카드사마다 다를수 있습니다. </td>
                       </tr>
                       <tr> 
                         <td height='1' colspan='2' align='center'  background='img/line.gif'></td>
                       </tr>
                       
                     </table></td>
                 </tr>
            </table>
            
          </td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td><img src="img/bottom01.gif" width="632" height="13"></td>
  </tr>
</table>
</center></body>
</html>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                
