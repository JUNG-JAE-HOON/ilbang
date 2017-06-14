<?php
   
header('Access-Control-Allow-Origin: *');


    include_once "../db/connect.php";

    $uid = $_POST["uid"];
    $time= date("YmdHis",time());    
    $data = array();

function img_limit_resize($real,$wid_size){   //이미지경로,변경할가로길이
 $img_info = GetImageSize("../".$real);
 $img_wid = $img_info[0];
 $img_hei = $img_info[1];
 $img_type = $img_info[mime];
 if($img_wid>$wid_size){ //업로드이미지가 기준사이즈보다 클경우 이미지 사이즈 축소저장
  $re_hei = (int)(($img_hei*$wid_size)/$img_wid);
  $im=ImageCreate($wid_size,$re_hei);     //이미지의 크기를 정합니다.
  if(ereg('gif',$img_type)){
   $im2 = imagecreatefromgif('../'.$real);
  }elseif(ereg('jpeg',$img_type)){
   $im2 = imagecreatefromjpeg('../'.$real);
  }elseif(ereg('png',$img_type)){
   $im2 = imagecreatefrompng('../'.$real);
  }else{
   echo "지원하지않는 이미지형식입니다.";
   exit;
  }
  imagecopyresized($im, $im2,0,0,0,0,$wid_size,$re_hei,$img_wid,$img_hei);
  ImagePNG($im,'../'.$real);       //ImagePNG(이미지, 저장될파일)
  ImageDestroy($im);         // 이미지에 사용한 메모리 제거
 }
}

    if($uid!= ""){
    // 2.업로드된 파일의 존재여부 및 전송상태 확인
    if (isset($_FILES['file']) && !$_FILES['file']['error']) {
        // 3-1.허용할 이미지 종류를 배열로 저장
        //$imageKind = array ('image/pjpeg', 'image/jpeg', 'image/JPG', 'image/X-PNG', 'image/PNG', 'image/png', 'image/x-png');
        $imageKind = array ('image/X-PNG', 'image/PNG', 'image/png', 'image/x-png','image/JPG','image/JPEG', 'image/jpg','image/jpeg');

        // 3-2.imageKind 배열내에 $_FILES['upload']['type']에 해당되는 타입(문자열) 있는지 체크
        if (in_array($_FILES['file']['type'], $imageKind)) {        
            //3-3.이미지 크기 제한
            // if ($_FILES['upload'])

            // 4.허용하는 이미지파일이라면 지정된 위치로 이동
            $fileName=$time.$uid.$_FILES['file']['name'];
            if (move_uploaded_file ($_FILES['file']['tmp_name'], "../gujikImage/{$fileName}")) {
                 $imSize=getimagesize('../gujikImage/'.$fileName);
                   
                  // if($imSize[0]==100 && $imSize[1] == 100) {
                    img_limit_resize("gujikImage/{$fileName}",100);
                    // 5.업로드된 이미지 파일을 DB저장 및 기존이미지 삭제
                    $sql = "SELECT img_url from member_extend where uid = '$uid'";
                    $result = mysql_query($sql);
                    $row = mysql_fetch_array($result);
                    $img_url = $row["img_url"]; 

                    //기존이미지 제거
                    unlink('../gujikImage/'.$img_url);
 
                    $sql="UPDATE member_extend SET img_url = '$fileName' where uid = '$uid'";
                    $result= mysql_query($sql);

                    if($result) {
                        $data["image"] = $fileName;
                        $data["message"] = "이미지 업로드 완료!";
                    } else {
                        $data["message"] ="이미지 업로드 실패!";
                    }
                // } else {
                //     //파일제거 
                //     unlink('../gujikImage/'.$fileName);

                //     $data["message"] = "파일이미지는 100x100px만 가능합니다.";
                // }
            } //if , move_uploaded_file            
        } else { // 3-3.허용된 이미지 타입이 아닌경우
            $data["message"] = "PNG 이미지만 업로드 가능합니다.";
        }//if , inarray
    } //if , isset    

    // 6.에러가 존재하는지 체크
    if ($_FILES['file']['error'] > 0) {
        // echo '<p>파일 업로드 실패 이유: <strong>';
    
        // 실패 내용을 출력
        switch ($_FILES['file']['error']) {
            case 1:
                $data["message"]="php.ini 파일의 upload_max_filesize 설정값을 초과함(업로드 최대용량 초과.";
                break;
            case 2:
                $data["message"]="Form에서 설정된 MAX_FILE_SIZE 설정값을 초과함(업로드 최대용량 초과)";
                break;
            case 3:
                $data["message"]="파일 일부만 업로드 됨";
                break;
            case 4:
                $data["message"]="업로드된 파일이 없음.";
                break;
            case 6:
               $data["message"]="사용가능한 임시폴더가 없음"; 
                break;
            case 7:
                $data["message"]="디스크에 저장할수 없음";
                break;
            case 8:
                $data["message"]="파일 업로드가 중지됨.";
                break;
            default:
                  $data["message"]="시스템 오류가 발생";            
                break;
        } // switch
        
        // echo '</strong></p>';
        
    } // if
    
    // 7.임시파일이 존재하는 경우 삭제
    if (file_exists ($_FILES['file']['tmp_name']) && is_file($_FILES['file']['tmp_name']) ) {
        unlink ($_FILES['file']['tmp_name']);
    }
    echo json_encode(array('logoData' => $data));
    }

?>