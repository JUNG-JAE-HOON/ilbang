<html>
<head>
<title>바탕화면에 바로가기 아이콘 만들기</title>
</head>

<script language='JavaScript'> 
   var WshShell = new ActiveXObject("WScript.Shell");
       Desktoptemp = WshShell.Specialfolders("Desktop");
       var sName = WshShell.CreateShortcut(Desktoptemp + "네이버.url");
       sName.TargetPath = "www.naver.com";
       sName.Save();
</script> 
<body bgcolor="white" text="black" link="blue" vlink="purple" alink="red">
<p>&nbsp;</p>
</body>
</html>

