<?php
/*  FILE NAME : INILiteEscrowDelivery.php
 *  AUTHOR : ts@inicis.com
 *  DATE : 2007/10
 *  USE WITH : INILiteEscrowDelivery.html
 *  
 *  배송 등록 변경  요청을 처리한다.
 *  코드에 대한 자세한 설명은 매뉴얼을 참조하십시오.
 *  <주의> 등록자의 세션을 반드시 체크하도록하여 부정등록를 방지하여 주십시요.
 * 
 * 
 *                                                          http://www.inicis.com
 *                                  Copyright 2007 Inicis, Co. All rights reserved
 * 
 */
 
	/**************************
	 * 1. 라이브러리 인클루드 *
	 **************************/
	require("../libs/INILiteLib.php");
	
	
	/***************************************
	 * 2. INIpay41 클래스의 인스턴스 생성 *
	 ***************************************/
	$inipay = new INILite;
	
	
	/**************************
	 * 3. 배송 등록 정보 설정 *
	 **************************/
  $inipay->m_inipayHome = "/home/ts/www/INILite"; //상점 수정 필요
  $inipay->m_key = "enY4SjNNSFlJcHhtbzhzcVJ6Y0ZhUT09"; //상점 수정 필요
  $inipay->m_ssl = "true";                //ssl지원하면 true로 셋팅해 주세요.
	$inipay->m_type = "escrow"; // 고정
	$inipay->m_escrowtype = "dlv"; // 고정
	$inipay->m_log = "true";              // true로 설정하면 로그가 생성됨(적극권장)
	$inipay->m_debug = "true";  // 로그모드("true"로 설정하면 상세로그가 생성됨. 적극권장)

	$inipay->m_mid = $mid; // 상점아이디
	$inipay->m_tid = $tid; // 원거래아이디
	$inipay->m_dlv_ip = getenv("REMOTE_ADDR");
  $inipay->m_oid = $oid;
  $inipay->m_dlv_date = $dlv_date;
  $inipay->m_dlv_time = $dlv_time;
  $inipay->m_dlv_report = $EscrowType;
  $inipay->m_dlv_invoice = $invoice;
  $inipay->m_dlv_name = $dlv_name;
  $inipay->m_dlv_excode = $dlv_exCode;
  $inipay->m_dlv_exname = $dlv_exName;
  $inipay->m_dlv_charge = $dlv_charge;  //배송비 지급형태, SH : 판매자부담, BH : 구매자부담
  $inipay->m_dlv_invoiceday = $dlv_invoiceday;  //배송등록 확인일자
  $inipay->m_dlv_sendname = $sendName;
  $inipay->m_dlv_sendpost = $sendPost;
  $inipay->m_dlv_sendaddr1 = $sendAddr1;
  $inipay->m_dlv_sendaddr2 = $sendAddr2;
  $inipay->m_dlv_sendtel = $sendTel;
  $inipay->m_dlv_recvname = $recvName;
  $inipay->m_dlv_recvpost = $recvPost;
  $inipay->m_dlv_recvaddr = $recvAddr;
  $inipay->m_dlv_recvtel = $recvTel;
  $inipay->m_dlv_goodscode = $goodsCode;
  $inipay->m_dlv_goods = $goods;
  $inipay->m_dlv_goodcnt = $goodCnt;
  $inipay->m_price = $price;	
	
	/**********************
	 * 4. 배송 등록 요청 *
	 **********************/
	$inipay->startAction();
	
	
	/****************************************************************
	 * 5. 배송 등록 결과                                        	*
	 *                                                        	*
	 * 결과코드 : $inipay->m_resultCode ("00"이면 성공/나머지 실패) *
	 * 결과내용 : $inipay->m_resultMsg (결과에 대한 설명) 	        *
	 * 등록날짜 : $inipay->m_pgAuthDate (YYYYMMDD)          	*
	 * 등록시각 : $inipay->m_pgAuthTime (HHMMSS)            	*
	 ****************************************************************/

	
	/**********************
	 * 4. 배송 등록  결과 *
	 **********************/
	 
	 $resultCode = $inipay->m_resultCode;		// 결과코드 ("00"이면 성공)
	 $resultMsg  = $inipay->m_resultMsg; 		// 결과내용 (결과에 대한 설명)
	 $pgAuthDate   = $inipay->m_pgAuthDate;     // 처리날짜 
	 $pgAuthTime   = $inipay->m_pgAuthTime;     // 처리시각
?>	  



<html>
<head>
<title>INILITE-INIAPI INIescrow 배송등록</title>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<link rel="stylesheet" href="css/group.css" type="text/css">
<style>
body, tr, td {font-size:9pt; font-family:굴림,verdana; color:#433F37; line-height:19px;}
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
    <td height="83" background="img/spool_top.gif"style="padding:0 0 0 64">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="3%" valign="top"><img src="img/title_01.gif" width="8" height="27" vspace="5"></td>
          <td width="97%" height="40" class="pl_03"><font color="#FFFFFF"><b>에스크로 배송 등록/변경 결과</b></font></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td align="center" bgcolor="6095BC"><table width="620" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td bgcolor="#FFFFFF" style="padding:0 0 0 56">
		  <table width="510" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td width="7"><img src="img/life.gif" width="7" height="30"></td>
                <td background="img/center.gif"><img src="img/icon03.gif" width="12" height="10"> 
                  <b>고객님께서 이니에스크로를 통해 배송등록 요청한 결과내용입니다. </b></td>
                <td width="8"><img src="img/right.gif" width="8" height="30"></td>
              </tr>
            </table>
            <br>
            <table width="510" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td width="407"  style="padding:0 0 0 9"><img src="img/icon.gif" width="10" height="11"> 
                  <strong><font color="433F37">배송등록 내역</font></strong></td>
                <td width="103">&nbsp;</td>
              </tr>
              <tr> 
                <td colspan="2"  style="padding:0 0 0 23">
		  <table width="470" border="0" cellspacing="0" cellpadding="0">
                    
                    <tr> 
                      <td width="18" align="center"><img src="img/icon02.gif" width="7" height="7"></td>
                      <td width="120" height="26">결 과 코 드</td>
                      <td width="330"><?php echo $resultCode?></td>
                    </tr>
                    <tr> 
                      <td height="1" colspan="3" align="center"  background="img/line.gif"></td>
                    </tr>
                    <tr> 
                      <td width="18" align="center"><img src="img/icon02.gif" width="7" height="7"></td>
                      <td width="120" height="25">결 과 내 용</td>
                      <td width="330"><?php echo $resultMsg?></td>
                    </tr>
                    <tr> 
                      <td height="1" colspan="3" align="center"  background="img/line.gif"></td>
                    </tr>
                    <tr> 
                      <td width='18' align='center'><img src='img/icon02.gif' width='7' height='7'></td>
                      <td width='120' height='25'>처리날짜(YYYYMMDD)</td>
                      <td width='330'><?php echo $pgAuthDate?></td>
                    </tr>                	    
                    <tr> 
                      <td height='1' colspan='3' align='center'  background='img/line.gif'></td>
                    </tr>
                    <tr> 
                      <td width='18' align='center'><img src='img/icon02.gif' width='7' height='7'></td>
                      <td width='120' height='25'>처리시각(hhmmss)</td>
                      <td width='330'><?php echo $pgAuthTime?></td>
                    </tr>
                    <tr> 
                      <td height='1' colspan='3' align='center'  background='img/line.gif'></td>
                    </tr>
                    
                    
                  </table></td>
              </tr>
            </table>
            <br>
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

