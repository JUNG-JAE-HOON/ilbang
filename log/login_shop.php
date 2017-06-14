<?php
include_once "../db/connect.php";
include_once "../include/session.php";

$sql="select passwd from member where uid='$uid'";
$result=mysql_query($sql,$ilbang_con);
$row=mysql_fetch_array($result);
$pwd=$row[0];



if($uid ==""){
	  echo "<script>alert('로그인 하세요.');</script>";
	  echo "<script>history.go(-1);</script>";
}

	//echo "<script>document.location.href='http://www.ilbbang.com/mmcshop/bbs/login_check2.php?id=$uid&pw=$pwd'</script>";

?>
<form name="frm" action="http://www.ilbbang.com/mmcshop/bbs/login_check2.php" data-ajax="false"  method="POST"   >
<input type="hidden" name="id" value="<?php echo $uid;?>" />
<input type="hidden" name="pw" value="<?php echo $pwd;?>" />

</form>
<script type="text/javascript">
				//예외처리 
	document.frm.submit(); 
</script>
