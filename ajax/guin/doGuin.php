<?php
    include_once "../../db/connect.php";

    
    $euid                   = $_POST['euid'];
    $ruid                   = $_POST['ruid'];
    $work_date              = $_POST['work_date']; 
    $today                  = date("Y-m-d H:i:s");
    $work_resume_data_no    = $_POST['work_resume_data_no'];
    /*
    $euid                   = "slslcx";
    $ruid                   = "mituki";
    $work_date              = array("2016-07-30","2016-07-31"); 
    $today                  = date("Y-m-d H:i:s");
    $work_resume_data_no    = "1024";
    */

   if ($ruid == $euid){
        echo json_encode(array('result' => "0" ,'msg'=>'자신의 이력서에 구인 신청할 수 없습니다.'));
        return ;
   }

    if ($work_date == ""){
        echo json_encode(array('result' => "0" ,'msg'=>'날짜를 선택하세요.'));
        return ;
    }

     // 대표 채용공고(구인신청서) 번호 구하기
    $work_employ_data_no = "";
    $sql  = " SELECT no as work_employ_data_no FROM work_employ_data WHERE uid = '$euid' AND delegate = 1 ";
    $result = mysql_query($sql, $ilbang_con);
    while($row = mysql_fetch_array($result)){
            $work_employ_data_no = $row["work_employ_data_no"];
    }

    if ($work_employ_data_no == ""){
        echo json_encode(array('result' => "0" ,'msg'=>'대표 채용공고가 없습니다. 내 채용 공고에서 대표 채용공고를 선택하세요.'));
         return ;
    }


    for ($i=0; $i<count($work_date); $i++) {

        $sql = "SELECT count(*) cnt FROM work_join_list WHERE euid = '$euid' AND work_employ_data_no IN (SELECT no FROM work_employ_data A WHERE A.uid = '$euid' AND A.delegate = 1) AND work_date = '$work_date[$i]' AND work_resume_data_no = '$work_resume_data_no'";
        $result = mysql_query($sql, $ilbang_con);

        while($row = mysql_fetch_array($result)){
                $cnt = $row["cnt"];
        }

        if ($cnt != 0){
            //echo json_encode(array('result' => "0" ,'msg'=>'이미 구인 신청한 이력서 입니다.' ,'cnt' =>$cnt, 'sql'=>$sql  ));
            //return ;
            continue;
        } 
                


        $sql  = " INSERT INTO work_join_list (euid, ruid, work_date, resume_review, employ_review, wdate, work_resume_data_no " ;
        $sql .= ", work_employ_data_no) VALUES "                                                                                 ;
        $sql .= " ('$euid', '$ruid' ,'$work_date[$i]', 'no', 'no', '$today', '$work_resume_data_no','$work_employ_data_no') "        ;

        $result = mysql_query($sql, $ilbang_con);

        if($result){
            //echo json_encode(array('result' => "1" ,'msg'=>'구인 신청 되었습니다. 내 구인신청&매칭 목록 에서 확인하세요.','work_date'=>$work_date, 'sql'=>$sql));
        } else {
            //echo json_encode(array('result' => "0",'msg'=>'구인 신청 실패하였습니다.', 'sql'=>$sql));
        }


    
    }

    echo json_encode(array('result' => "1" ,'msg'=>'구인 신청 되었습니다. ','work_date'=>$work_date, 'sql'=>$sql));
?>