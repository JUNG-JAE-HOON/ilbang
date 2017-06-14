<!DOCTYPE html>
<html>
<script src="../mobile/js/jquery-1.12.3.min.js"></script>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name=”viewport” content=”width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no” />
	<title>이미지 업로드</title>
	<link rel="stylesheet" href="">
	<style>
		/*button{display:block;width:50%; height: 150px; border:2px solid #ddd; border-radius: 3px; margin:50px auto; font-size: 50px}*/
		.tc{text-align: center}
		.oh {overflow:hidden;}
		.fl {float: left;}
		/* 성화진추가 */
		input {outline: none;}
		.imgUpWrap {margin-top:70px;}
		.imgTitle {line-height:25px; font-size: 18px; font-weight: normal; color: #333;}
		.custom-file-input::-webkit-file-upload-button {visibility: hidden;}
		.custom-file-input::before {content: '파일선택'; display: inline-block; width: 145px; background: #ef547a; border: 1px solid #ef547a; border-radius: 3px; padding: 25px 50px; -webkit-user-select: none; text-align:center; cursor: pointer; font-size: 35px; color: #fff;		}
		.fileSet {display:inline-block; margin: 0 auto; padding: 25px 50px; font-size:35px; color: #333; background: #fff; border:1px solid #ef547a; border-radius: 3px;}
		.btnGroup {width: 50%; margin: 0 auto; padding-top: 30px; overflow:hidden;}
	</style>
</head>
<?php
	$id = $_GET["id"];
	$no = $_GET["no"];
?>
<body>
	<div class="imgUpWrap">
		<div class="tc">
			<h1 class="imgTitle ">
				<font size=5>
				※ 문화일방 프로필 이미지 업로드를 위한 페이지입니다.<Br>이미지를 선택하고 업로드 해주세요. 업로드 이후 어플에서 바로 반영되지는 않습니다.<br> 등록 후 브라우저를 종료하고 프로필 등록을 완료하여주세요.
				</font>
			</h1>
			<img id = "artistImg" width="600dp" alt="">
		</div>
		<div class="btnGroup">
			<form id="artistForm" method="post" enctype="multipart/form-data" class="pr fl">
				<input class="artist-photo pa custom-file-input" type="file" id="FILE_TAG" name="FILE_TAG" accept="image/*"/>
			</form>
			<button class="fileSet" onclick="uploadArtistImage()">파일등록</button>
		</div>
	</div>
</body>
</html>

<script>
	$(function() {
				$("#FILE_TAG").on('change', function(){
						readURL(this);
				});
		});

		function readURL(input) {
				if (input.files && input.files[0]) {
				var reader = new FileReader();

				reader.onload = function (e) {
								$('#artistImg').attr('src', e.target.result);
						}

					reader.readAsDataURL(input.files[0]);
				}
		}


function uploadArtistImage(){
	if($('#FILE_TAG').val() == "") {
            alert("사진을 선택하세요.");
        } else {
            var form = $('artistForm')[0];
            var formData = new FormData(form);

            var image_URL = "http://il-bang.com/pc_renewal/sotongFile/";

            formData.append("file", $("#FILE_TAG")[0].files[0]);
            formData.append("uid",'<?php echo $id ?>' );
            formData.append("no", '<?php echo $no ?>');

            $.ajax({
                url: "http://il-bang.com/ilbang_pc/ionic/http/sotong/uploadArtistImage.php",
                processData: false,
                contentType: false,
                data: formData,
                type: 'POST',
                dataType: 'JSON',
                success: function(data) {

									alert('서버에 이미지가 등록되었습니다.브라우저를 종료 하신 후 이어서 프로필 작성을 하시면 됩니다.(프로필 이미지는 등록 후 바로 반영되지 않으며 어플 화면을 새로 고친 후 적용됩니다.)');

										//
                    // if($stateParams.no == null || $stateParams.no == "") {
                    //     document.getElementById("plusImg").style.display = "none";
										//
                    // }
                }
            });
        }
}
</script>
