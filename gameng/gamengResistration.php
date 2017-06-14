<?php
    include_once "../include/session.php";
    include_once "../db/connect.php";

    $gamengCategory = $_POST["category"];
    $gamengName = $_POST["name"];
    $ceo = $_POST["ceo"];
    $number = $_POST["number1"]."-".$_POST["number2"]."-".$_POST["number3"];
    $types = $_POST["types"];
    $status = $_POST["status"];
    $flotation = $_POST["flotation"];
    $content = $_POST["content"];
    $addr = $_POST["address1"]." ".$_POST["address2"];
    $lat = $_POST["lat"];
    $lng = $_POST["lng"];
    $area1 = $_POST["area_1st"];
    $area2 = $_POST["area_2nd"];
    $discountRate = $_POST["discountRate"] / 100;
    $phone = $_POST["phone1"]."-".$phone2."-".$phone3;
    $code = $_POST["adminCode"];
    $wdate = date("Y-m-d H:i:s");
    $ip = $_SERVER["REMOTE_ADDR"];

    //1차 지역 검색
    $sql = "SELECT list_name FROM category WHERE no = $area1";
    $result = mysql_query($sql);
    $arr = mysql_fetch_array($result);

    $area1Name = $arr[0];

    //2차 지역 검색
    $sql = "SELECT list_name FROM category WHERE no = $area2";
    $result = mysql_query($sql);
    $arr = mysql_fetch_array($result);

    $area2Name = $arr[0];

    $keyword = $area1Name.",".$area2Name;

    //이미지 파일 관련
    $tmpName = $_FILES["file"]["tmp_name"];
    $fileName = $_FILES["file"]["name"];
    $fileInfo = pathinfo($fileName);
    $ext = strtolower($fileInfo['extension']);
    $saveName = date("YmdHis").$uid.".".$ext;
    $path = "../gamengImg/".$saveName;
    $path2 = "http://il-bang.com/pc_renewal/gamengImg/".$saveName;

    if($uid != "") {
        if($kind == "general") {
            $tableName = "member_extend B";
        } else {
            $tableName = "company B";
        }

        $sql = "SELECT A.no, A.valid_no, B.img_url FROM member A JOIN $tableName WHERE A.uid = B.uid AND A.uid = '$uid'";
        $result = mysql_query($sql);
        $arr = mysql_fetch_array($result);

        $memberNo = $arr["no"];
        $validNo = $arr["valid_no"];
        $logoImg = $arr["img_url"];

        //파일 저장
        move_uploaded_file($tmpName, $path);
        
        $imgSize = getimagesize($path);

        if($imgSize[0] != 58 || $imgSize[1] != 58) {
            //파일 삭제
            unlink($path);

            echo "<script>alert('58x58 사이즈의 png 이미지만 사용할 수 있습니다.');</script>";
            echo "<script>history.back();</script>";
        } else {
            $sql = "INSERT INTO affiliate(admin_id, img_url, type, name, area_1st, area_2nd, address, phone, lat, lng, keyword, discount_rate, wdate, admin_cd)
                         VALUES ('$uid', '$path2', '$gamengCategory', '$gamengName', '$area1', '$area2', '$addr', '$phone', '$lat', '$lng', '$keyword', '$discountRate', '$wdate', '$code')";
            $result = mysql_query($sql);

            if($result) {
                $sql = "SELECT no FROM affiliate WHERE admin_id = '$uid' ORDER BY wdate DESC";
                $result = mysql_query($sql);
                $arr = mysql_fetch_array($result);

                $gamengNo = $arr[0];

                $sql = "INSERT INTO company_temp(uid, company, ceo, number, content, types, status, flotation, member_no, valid_no, img_url, ip, gameng_no)
                             VALUES ('$uid', '$gamengName', '$ceo', '$number', '$content', '$types', '$status', '$flotation', '$memberNo', '$validNo', '$logoImg', '$ip', '$gamengNo')";
                $result = mysql_query($sql);

                if($result) {
                    echo "<script>alert('신청 되었습니다.');</script>";
                    echo "<script>document.location.href = 'gamengApply.php';</script>";
                } else {
                    unlink($path);

                    echo "<script>alert('신청 실패(회사 정보 추가 에러)');</script>";
                    echo "<script>history.back();</script>";
                }
            } else {
                unlink($path);

                echo "<script>alert('신청 실패');</script>";
                echo "<script>history.back();</script>";
            }
        }
    } else {
        echo "<script>alert('로그인 후 이용해주세요.');</script>";
        echo "<script>history.back();</script>";
    }
?>