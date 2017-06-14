<link rel="stylesheet" href="../daumeditor/css/editor.css" type="text/css" charset="utf-8"/>
<script src="../daumeditor/js/editor_loader.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="../js/jquery-1.10.2.min.js"></script>

<!-- 에디터 시작 -->
<div>
	<form name="frm" id="frm" action="/send.jsp" method="post" accept-charset="utf-8">
		<!-- 에디터프레임호출 영역 -->
		<div id="editor_frame"></div>
		<!-- 실제 값이 담겨져서 넘어갈 textarea 태그 -->
		<textarea name="daumeditor" id="daumeditor" rows="10" cols="100" style="width:766px; height:412px;display: none;"></textarea>
		<input type="button" id="save_busson" value="내용전송" />

	</form>
</div>
<!-- 에디터 끝 -->