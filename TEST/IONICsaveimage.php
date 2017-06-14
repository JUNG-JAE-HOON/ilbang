<?php
	header('Access-Control-Allow-Origin: *');
	//echo $_FILES['file'][ㅗㅇㅇ'name'];
	if($_FILES['file']['name']) {
		if(!$_FILES['file']['error']){
			$name = md5(rand(100, 200));
			$ext = explode('.', $_FILES['file']['name']);
			$filename = $name . '.' . $ext[1];
			$destination = '../guinImage/'.$filename; // change this directory
			$location = $_FILES["file"]["tmp_name"];
			move_uploaded_file($location, $destination);
			echo 'http://il-bang.com/pc_renewal/guinImage/'.$filename;//change this URL
		}else {
			echo $message = 'Ooops! Your upload triggered the following error: '.$_FILES['file']['error'];

		}
	}

/*
UPLOAD_ERR_OK
값: 0; 오류 없이 파일 업로드가 성공했습니다.

UPLOAD_ERR_INI_SIZE
값: 1; 업로드한 파일이 php.ini upload_max_filesize 지시어보다 큽니다.

UPLOAD_ERR_FORM_SIZE
값: 2; 업로드한 파일이 HTML 폼에서 지정한 MAX_FILE_SIZE 지시어보다 큽니다.

UPLOAD_ERR_PARTIAL
값: 3; 파일이 일부분만 전송되었습니다.

UPLOAD_ERR_NO_FILE
값: 4; 파일이 전송되지 않았습니다.

UPLOAD_ERR_NO_TMP_DIR
값: 6; 임시 폴더가 없습니다. PHP 4.3.10과 PHP 5.0.3에서 추가.

UPLOAD_ERR_CANT_WRITE
값: 7; 디스크에 파일 쓰기를 실패했습니다. PHP 5.1.0에서 추가.

UPLOAD_ERR_EXTENSION
값: 8; 확장에 의해 파일 업로드가 중지되었습니다. PHP 5.2.0에서 추가.

http://php.net/manual/kr/features.file-upload.errors.php
*/
?>