<?php include_once "../include/header.php"; ?>
<script type="text/javascript">
	function myFunct() {
		document.body.scrollIntoView(true);
		document.getElementById("pointiframe").height = 1500;
	}
</script>

<!-- <script type="text/javascript">
	function resizeiframecent(ifid, oldx, oldy) {
		var actualwidth = document.getElementById(ifid).offsetWidth;
		 
		var proporcion = actualwidth / oldx;
		newheight=proporcion * oldy;
		var newheight2 = Math.ceil(newheight);
		 
		document.getElementById(ifid).height = newheight2;
	}
</script> -->
<!-- <script type="text/javascript">
	function autoResize(i)
        {
            var iframeHeight=
            (i).contentWindow.document.body.scrollHeight;
            (i).height=iframeHeight+20;
        }
</script>
 -->
<!-- <div class="container center wdfull bb">
    <div class="pg_rp"> 
        <div class="c999 fl subTitle">HOME > <b class="c555">포인트몰</b></div>
        <div class="c999 fr padding-vertical">
            <span class="mr5 br15 subNotice">공지</span>
            <a href="#" class="c999"><span id="adNotice"></span></a>
        </div>
    </div>
</div> -->

<div class="center" id="content">

<!-- 
<iframe name="NeBoard" src="../log/login_shop.php" scrolling="No" onLoad="ResizeFrame('NeBoard');" width="100%" height="100%" ></iframe> -->
<!-- <iframe id="iframe_main" name="iframe_main" src="../log/login_shop.php" frameborder="0" width="100%" height="100%" scrolling="no"></iframe> -->

<iframe src="../log/login_shop.php" id="pointiframe" width="100%" class="iframe" scrolling="no" frameborder="0" onLoad="myFunct();"></iframe>

 <!-- <iframe src="../log/login_shop.php" width="100%" id="the_iframe" onLoad="iframeAutoResize(this);" scrolling="NO" frameborder="1" height="1"></iframe>  -->
 <!-- <iframe src="../log/login_shop.php" id="ifrm" width="100%" height="100%" frameborder="no" scrolling="no" marginwidth="0" marginheight="0" onload="resizeIframe(this)"></iframe>  -->

 <!--  <iframe src="http://il-bang.com/pc_renewal/index.php" width=100% onload="autoResize(this)" scrolling="no" frameborder="0"></iframe> -->
  <!-- <iframe src="../log/login_shop.php" width=100% id="aaa" frameBorder="0" scrolling="no" ></iframe> --> 
<!--  <iframe src="../log/login_shop.php" id="aaa" width=100% height=0 frameborder="0" scrolling="no" ></iframe> -->
<!-- 
<iframe src="../log/login_shop.php" id="iframe" onload="resizeiframecent('iframe','560','315')" scrolling="no" width="100%" frameborder="0"></iframe> -->
</div>

<!-- <script>

         document.body.scrollIntoView(true);
         // if(parent.document.all.aaa) parent.document.all.aaa.height = document.body.scrollHeight;
         document.all.aaa.height = document.body.scrollHeight+500; 
</script>  -->

<!-- <?php //include_once "../include/footer.php"; ?> -->