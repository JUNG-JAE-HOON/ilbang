<?php
/* * INIlite_repay.php
 *
 * �̹� ���� ���ε� �ŷ����� ��Ҹ� ���ϴ� �ݾ��� �Է��Ͽ� �ٽ� ������ ���ϵ��� ��û�Ѵ�.
 * 
 * [����] ��� �� ������̹Ƿ� �� �ŷ����̵� ��ȯ�ǳ�, ���ŷ� TID�� �κ����(�����)�� �����Կ� ����
 * [����] ���ŷ��� �ſ�ī�� ������ ��쿡�� ����
 * (OK ĳ���� ���� ���� ���ԵǾ� �־ �Ұ�)
 * [����] �ݵ�� ����� �ݾ��� �Է��ϵ��� ��
 *  
 * Date : 2010/11
 * Author : ts@inicis.com
 * Project : INILITE_V2 INIAPI PHP
 * 
 * http://www.inicis.com
 * Copyright (C) 2008 Inicis, Co. All rights reserved.
 */

	/**************************
	 * 1. ���̺귯�� ��Ŭ��� *
	 **************************/
	require("../libs/INILiteLib.php");
	
	
	/***************************************
	 * 2. INILite Ŭ������ �ν��Ͻ� ���� *
	 ***************************************/
	$inipay = new INILite;


	/*********************
	 * 3. ���� ���� ���� *
	 *********************/
	$inipay->m_inipayHome = "/usr/local/INILite_php"; //���� ���� �ʿ�
	$inipay->m_key = "SU5JTElURV9UUklQTEVERVNfS0VZU1RS";  //���� �����ڿ��� �߱޵� �������� ��ĪŰ�� ���� �մϴ�.(merchantkey)
	$inipay->m_pgId = "INIphpRPAY";      // ���� (���� ���� �Ұ�)
	$inipay->m_ssl = "true"; 				//ssl�����ϸ� true�� ������ �ּ���.
	$inipay->m_type = "repay"; 			// ���� (���� ���� �Ұ�) // �κ���� : repay
	$inipay->m_log = "true";              // true�� �����ϸ� �αװ� ������(���ر���)
	$inipay->m_debug = "true";              // �α׸��("true"�� �����ϸ� �󼼷αװ� ������. ���ر���)
	$inipay->m_mid = $mid; 					// �������̵�
	$inipay->m_oldtid = $oldtid;				//  ���ŷ���ȣ
	$inipay->m_uip = getenv("REMOTE_ADDR"); 		// ���� (���� ���� �Ұ�)
	$inipay->m_currency = $currency;			// ȭ�����
	$inipay->m_price = $price;							// ����ұݾ�
	$inipay->m_confirm_price = $confirm_price;			// ����ұݾ�
	$inipay->m_encrypted = $encrypted;			// ��ȣ��
	
	/****************
	 * 4. ���� ��û *
	 ****************/
	$inipay->startAction();
	
	
	/****************************************************************
	 *  5. ���
	****************************************************************/
	/*
	$this->m_mid 			= $xml->getXMLData('mid');
	$this->m_tid 			= $xml->getXMLData('tid');							// �Űŷ���ȣ
	$this->m_resultCode 	= $xml->getXMLData('resultcode');			// ����ڵ� ("00"�̸� ����)
	$this->m_resultMsg 		= $xml->getXMLData('resultmessage');			// ������� (����� ���� ����)
	$this->m_prtc_tid 		= $xml->getXMLData('prtc_tid');				// ���ŷ� ��ȣ
	$this->m_prtc_remains 	= $xml->getXMLData('prtc_remains');		// �������� �ݾ�
	$this->m_prtc_price 	= $xml->getXMLData('prtc_price');			// �κ���� �ݾ�
	$this->m_prtc_type 		= $xml->getXMLData('prtc_type');				// �κ���� ���а�(�Ǵ� ����� ���а�, "0"-�����, "1"-�κ����)
	$this->m_prtc_cnt 		= $xml->getXMLData('prtc_cnt');				// �κ����(�����) ��ûȽ��
	*/
	
?>


<!-------------------------------------------------------------------------------------------------------
 *  													*
 *       												*
 *        												*
 *	�Ʒ� ������ ���� ����� ���� ��� ������ �����Դϴ�. 				                *
 *													*
 *													*
 *													*
 -------------------------------------------------------------------------------------------------------->
 
<html>
<head>
<title>INILITE-INIAPI PHP �κ���� ����</title>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<link rel="stylesheet" href="css/group.css" type="text/css">
<style>
body, tr, td {font-size:10pt; font-family:����,verdana; color:#433F37; line-height:19px;}
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
  <?    // ���� ���ܿ� ���� ��� �̹����� ����ȴ�.
   	$background_img = "img/spool_top.gif";    //default image
   	
   	if ($inipay->m_resultCode =="01"){
   	    $background_img = "img/card.gif";
   	}
?>
    <td height="83" background="<?=$background_img?>"style="padding:0 0 0 64">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="3%" valign="top"><img src="img/title_01.gif" width="8" height="27" vspace="5"></td>
          <td width="97%" height="40" class="pl_03"><font color="#FFFFFF"><b>�κ���� ���</b></font></td>
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
		                 	������ �κ���� ��û�� �����Ǿ����ϴ�.
		               <?  }else{?>
		                 	������ �κ���� ��û�� ���еǾ����ϴ�.
		                <? }?>
                 </b></td>
                <td width="8"><img src="img/right.gif" width="8" height="30"></td>
              </tr>
            </table>
            <br>
            <table width="510" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td width="407"  style="padding:0 0 0 9"><img src="img/icon.gif" width="10" height="11"> 
                  <strong><font color="433F37">�� �� �� ��</font></strong></td>
                <td width="103">&nbsp;</td>                
              </tr>
              <tr> 
                <td colspan="2"  style="padding:0 0 0 23">
		  <table width="470" border="0" cellspacing="0" cellpadding="0">
                    <tr> 
                      <td width="18" align="center"><img src="img/icon02.gif" width="7" height="7"></td>
                      <td width="109" height="26">�� �� �� ��</td>
                      <td width="343"><?php echo($inipay->m_resultCode); ?></td>
                    </tr>
                     <tr> 
                      <td height="1" colspan="3" align="center"  background="img/line.gif"></td>
                    </tr>
                    <tr> 
                      <td width="18" align="center"><img src="img/icon02.gif" width="7" height="7"></td>
                      <td width="109" height="25">�� �� �� ��</td>
                      <td width="343"><?php echo($inipay->m_resultMsg); ?></td>
                    </tr>
                    <tr> 
                      <td height="1" colspan="3" align="center"  background="img/line.gif"></td>
                    </tr>
                    <tr> 
                      <td width="18" align="center"><img src="img/icon02.gif" width="7" height="7"></td>
                      <td width="109" height="25">���ŷ� ��ȣ</td>
                      <td width="343"><?php echo($inipay->m_prtc_tid); ?></td>
                    </tr>
                    <tr> 
                      <td height='1' colspan='3' align='center'  background='img/line.gif'></td>
                    </tr>
                    <tr> 
                      <td width="18" align="center"><img src="img/icon02.gif" width="7" height="7"></td>
                      <td width="109" height="25">�� �� �� ȣ</td>
                      <td width="343"><?php echo($inipay->m_tid); ?></td>
                    </tr>
                    <tr> 
                      <td height="1" colspan="3" align="center"  background="img/line.gif"></td>
                    </tr>
                    <tr> 
                      <td width='18' align='center'><img src='img/icon02.gif' width='7' height='7'></td>
                      <td width='109' height='25'>���������ݾ� </td>
                      <td width='343'><?php echo($inipay->m_prtc_remains); ?></td>
                    </tr>
                    <tr> 
                      <td height='1' colspan='3' align='center'  background='img/line.gif'></td>
                    </tr>
                    <tr> 
                      <td width='18' align='center'><img src='img/icon02.gif' width='7' height='7'></td>
                      <td width='109' height='25'>�� �� �� ��</td>
                      <td width='343'><?php echo($inipay->m_prtc_price); ?></td>
                    </tr>
                    <tr> 
                      <td height='1' colspan='3' align='center'  background='img/line.gif'></td>
                    </tr>
                    <tr> 
                      <td width='18' align='center'><img src='img/icon02.gif' width='7' height='7'></td>
                      <td width='109' height='25'>�κ����(�����) ���� </td>
                      <td width='343'><b><font color=blue>(<?
                      				if($inipay->m_prtc_type == "0"){
                      				?>
                      					�����
                      				<?}else{?>
                      					�κ����
                      				<?}?>)</font></b></td>
                    </tr>
                    <tr> 
                      <td height='1' colspan='3' align='center'  background='img/line.gif'></td>
                    </tr>
                    <tr> 
                      <td width='18' align='center'><img src='img/icon02.gif' width='7' height='7'></td>
                      <td width='109' height='25'>�κ����(�����)��û Ƚ�� </td>
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
                     <strong><font color='433F37'>�̿�ȳ�</font></strong></td>
                 </tr>
                 <tr> 
                   <td  style='padding:0 0 0 23'> 
                     <table width='470' border='0' cellspacing='0' cellpadding='0'>
                       <tr>          					          
                         <td height='25'>(1)����, BC, �Ｚ, LGī�常 �κ���Ұ� �����մϴ�. <br>
                         (2)�κ���� �ִ�ݾװ� ����Ƚ���� �� ī��縶�� �ٸ��� �ֽ��ϴ�. </td>
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

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                
