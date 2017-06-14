<?php
/*  FILE NAME : INILiteEscrowDelivery.php
 *  AUTHOR : ts@inicis.com
 *  DATE : 2007/10
 *  USE WITH : INILiteEscrowDelivery.html
 *  
 *  ��� ��� ����  ��û�� ó���Ѵ�.
 *  �ڵ忡 ���� �ڼ��� ������ �Ŵ����� �����Ͻʽÿ�.
 *  <����> ������� ������ �ݵ�� üũ�ϵ����Ͽ� ������ϸ� �����Ͽ� �ֽʽÿ�.
 * 
 * 
 *                                                          http://www.inicis.com
 *                                  Copyright 2007 Inicis, Co. All rights reserved
 * 
 */
 
	/**************************
	 * 1. ���̺귯�� ��Ŭ��� *
	 **************************/
	require("../libs/INILiteLib.php");
	
	
	/***************************************
	 * 2. INIpay41 Ŭ������ �ν��Ͻ� ���� *
	 ***************************************/
	$inipay = new INILite;
	
	
	/**************************
	 * 3. ��� ��� ���� ���� *
	 **************************/
  $inipay->m_inipayHome = "/home/ts/www/INILite"; //���� ���� �ʿ�
  $inipay->m_key = "enY4SjNNSFlJcHhtbzhzcVJ6Y0ZhUT09"; //���� ���� �ʿ�
  $inipay->m_ssl = "true";                //ssl�����ϸ� true�� ������ �ּ���.
	$inipay->m_type = "escrow"; // ����
	$inipay->m_escrowtype = "dlv"; // ����
	$inipay->m_log = "true";              // true�� �����ϸ� �αװ� ������(���ر���)
	$inipay->m_debug = "true";  // �α׸��("true"�� �����ϸ� �󼼷αװ� ������. ���ر���)

	$inipay->m_mid = $mid; // �������̵�
	$inipay->m_tid = $tid; // ���ŷ����̵�
	$inipay->m_dlv_ip = getenv("REMOTE_ADDR");
  $inipay->m_oid = $oid;
  $inipay->m_dlv_date = $dlv_date;
  $inipay->m_dlv_time = $dlv_time;
  $inipay->m_dlv_report = $EscrowType;
  $inipay->m_dlv_invoice = $invoice;
  $inipay->m_dlv_name = $dlv_name;
  $inipay->m_dlv_excode = $dlv_exCode;
  $inipay->m_dlv_exname = $dlv_exName;
  $inipay->m_dlv_charge = $dlv_charge;  //��ۺ� ��������, SH : �Ǹ��ںδ�, BH : �����ںδ�
  $inipay->m_dlv_invoiceday = $dlv_invoiceday;  //��۵�� Ȯ������
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
	 * 4. ��� ��� ��û *
	 **********************/
	$inipay->startAction();
	
	
	/****************************************************************
	 * 5. ��� ��� ���                                        	*
	 *                                                        	*
	 * ����ڵ� : $inipay->m_resultCode ("00"�̸� ����/������ ����) *
	 * ������� : $inipay->m_resultMsg (����� ���� ����) 	        *
	 * ��ϳ�¥ : $inipay->m_pgAuthDate (YYYYMMDD)          	*
	 * ��Ͻð� : $inipay->m_pgAuthTime (HHMMSS)            	*
	 ****************************************************************/

	
	/**********************
	 * 4. ��� ���  ��� *
	 **********************/
	 
	 $resultCode = $inipay->m_resultCode;		// ����ڵ� ("00"�̸� ����)
	 $resultMsg  = $inipay->m_resultMsg; 		// ������� (����� ���� ����)
	 $pgAuthDate   = $inipay->m_pgAuthDate;     // ó����¥ 
	 $pgAuthTime   = $inipay->m_pgAuthTime;     // ó���ð�
?>	  



<html>
<head>
<title>INILITE-INIAPI INIescrow ��۵��</title>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<link rel="stylesheet" href="css/group.css" type="text/css">
<style>
body, tr, td {font-size:9pt; font-family:����,verdana; color:#433F37; line-height:19px;}
table, img {border:none}

/* Padding ******/ 
.pl_01 {padding:1 10 0 10; line-height:19px;}
.pl_03 {font-size:20pt; font-family:����,verdana; color:#FFFFFF; line-height:29px;}

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
          <td width="97%" height="40" class="pl_03"><font color="#FFFFFF"><b>����ũ�� ��� ���/���� ���</b></font></td>
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
                  <b>���Բ��� �̴Ͽ���ũ�θ� ���� ��۵�� ��û�� ��������Դϴ�. </b></td>
                <td width="8"><img src="img/right.gif" width="8" height="30"></td>
              </tr>
            </table>
            <br>
            <table width="510" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td width="407"  style="padding:0 0 0 9"><img src="img/icon.gif" width="10" height="11"> 
                  <strong><font color="433F37">��۵�� ����</font></strong></td>
                <td width="103">&nbsp;</td>
              </tr>
              <tr> 
                <td colspan="2"  style="padding:0 0 0 23">
		  <table width="470" border="0" cellspacing="0" cellpadding="0">
                    
                    <tr> 
                      <td width="18" align="center"><img src="img/icon02.gif" width="7" height="7"></td>
                      <td width="120" height="26">�� �� �� ��</td>
                      <td width="330"><?php echo $resultCode?></td>
                    </tr>
                    <tr> 
                      <td height="1" colspan="3" align="center"  background="img/line.gif"></td>
                    </tr>
                    <tr> 
                      <td width="18" align="center"><img src="img/icon02.gif" width="7" height="7"></td>
                      <td width="120" height="25">�� �� �� ��</td>
                      <td width="330"><?php echo $resultMsg?></td>
                    </tr>
                    <tr> 
                      <td height="1" colspan="3" align="center"  background="img/line.gif"></td>
                    </tr>
                    <tr> 
                      <td width='18' align='center'><img src='img/icon02.gif' width='7' height='7'></td>
                      <td width='120' height='25'>ó����¥(YYYYMMDD)</td>
                      <td width='330'><?php echo $pgAuthDate?></td>
                    </tr>                	    
                    <tr> 
                      <td height='1' colspan='3' align='center'  background='img/line.gif'></td>
                    </tr>
                    <tr> 
                      <td width='18' align='center'><img src='img/icon02.gif' width='7' height='7'></td>
                      <td width='120' height='25'>ó���ð�(hhmmss)</td>
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

