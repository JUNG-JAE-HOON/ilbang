<?php
header('Access-Control-Allow-Origin: *');
include_once "../db/connect.php";
 
$location = $_POST['directory'];
$uploadfile = $_POST['fileName'];
$uid = $_POST['uid'];
$uploadfilename = $_FILES['file']['tmp_name'];
$time= date("YmdHis",time());    
$name = $time.$uid.$uploadfile;
if(move_uploaded_file($uploadfilename, "../gujikImage/$name")){

        $sql = "SELECT img_url from member_extend where uid = '$uid'";
        $result = mysql_query($sql);
        $row = mysql_fetch_array($result);
        $img_url = $row["img_url"]; 

                    //기존이미지 제거
        unlink("../gujikImage/".$img_url);
 
        $sql="UPDATE member_extend SET img_url = '$name' where uid = '$uid'";
        $result= mysql_query($sql);

        if($result) {
            $data["image"] = $name;
            $data["message"] = "이미지 업로드 완료!";
        } else {
            $data["message"] ="이미지 업로드 실패!";
        }

    	echo $name;
} else {
        // echo '<p>파일 업로드 실패 이유: <strong>';
    
        // 실패 내용을 출력
        switch ($_FILES['file']['error']) {
            case 1:
                echo "php.ini 파일의 upload_max_filesize 설정값을 초과함(업로드 최대용량 초과.)";
                break;
            case 2:
                echo "Form에서 설정된 MAX_FILE_SIZE 설정값을 초과함(업로드 최대용량 초과)";
                break;
            case 3:
                echo "파일 일부만 업로드 됨";
                break;
            case 4:
                echo "업로드된 파일이 없음.";
                break;
            case 6:
               echo "사용가능한 임시폴더가 없음"; 
                break;
            case 7:
                echo "디스크에 저장할수 없음";
                break;
            case 8:
                echo "파일 업로드가 중지됨.";
                break;
            default:
                  echo $_FILES['file']['error'];            
                break;
        } // switch
        
        // echo '</strong></p>';
    }

?>