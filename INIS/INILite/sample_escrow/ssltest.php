<?php

require_once('../libs/INILiteCls.php');

$sslconn = fsockopen("ssl://".HTTP_SSL_SERVER, HTTP_SSL_PORT, $errno, $errstr, 20);
if( $sslconn ) fclose($sslconn);

$httpconn = fsockopen(HTTP_SERVER, HTTP_PORT, $errno, $errstr, 20);
if( $httpconn ) fclose($httpconn);
?>

<html>
<head>
<title>INILite SSL 연결 확인</title>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<link rel="stylesheet" href="/css/group.css" type="text/css">
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
    <td height="83" background=<?
    
    				if(!$sslconn||!$httpconn){
	
					echo "img/sock_top_no.gif";
				}
				else{
					echo "img/sock_top_ok.gif";
				}
    
    
?> style="padding:0 0 0 64">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="3%" valign="top"><img src="img/title_01.gif" width="8" height="27" vspace="5"></td>
          <td width="97%" height="40" class="pl_03"><font color="#FFFFFF"><b>SSL 통신 확인 결과</b></font></td>
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
                  <b>SSL 통신 확인 결과 입니다.</b></td>
                <td width="8"><img src="img/right.gif" width="8" height="30"></td>
              </tr>
            </table>
            <br>
            <table width="510" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td width="407"  style="padding:0 0 0 9"><img src="img/icon.gif" width="10" height="11"> 
                  <strong><font color="433F37">확인결과</font></strong></td>
                <td width="103">&nbsp;</td>
              </tr>
              <tr> 
                <td colspan="2"  style="padding:0 0 0 23">
		  <table width="470" border="0" cellspacing="0" cellpadding="0">
                    <tr> 
                      <td height="1" colspan="3" align="center"  background="img/line.gif"></td>
                    </tr>
                    <tr> 
                      <td width="18" align="center"><img src="img/icon02.gif" width="7" height="7"></td>
                      <td width="109" height="25">결 과 내 용</td>
                      <td width='343'>
                        <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                          <tr> 
                            <td><?
                            
                                 if($sslconn){
                       	echo "<font color=blue><b>SSL 통신 => 성공</b></font><br>";
				 				}else{
				        echo "<font color=red><b>SSL 통신 => 실패&nbsp;&nbsp;(".$errstr.")</b></font>";
				 }
												
				?></td>			    
                          </tr>
                          <tr> 
                            <td><?
                            
                                 if($httpconn){
                       	echo "<font color=blue><b>HTTP 통신 => 성공</b></font><br>";
				 }else{
				        echo "<font color=red><b>HTTP 통신 => 실패&nbsp;&nbsp;(".$errstr.")</b></font>";
				 }
				
				?></td>			    
                          </tr>
                          
                        </table></td>
                    </tr>
                    <tr>
                      <td height="1" colspan="3" align="center"  background="img/line.gif"></td>
                    </tr>
                      <?
                    	if(!$sslconn||!$httpconn){
                      		echo"<tr>
                      		       <td width='18' align='center'><img src='img/icon02.gif' width='7' height='7'></td>
                                       <td width='109' height='25'>조 치 방 법</td>
                                       <td>
					◈ <font color=red><b>SSL 통신 => 실패</b></font>로 나올시에는 <font color=red>결제처리페이지에서 var \$m_ssl = true; => var \$m_ssl = false;로 수정</font>해 주십시오.<br><br>";
			}

			?>
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
    <td><img src='img/bottom01.gif' width='632' height='13'></td>
  </tr>
</table>
</center></body>
</html>
