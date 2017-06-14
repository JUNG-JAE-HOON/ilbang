<?php
 include_once "../../db/connect.php";

 	$no=$_POST["rno"];
      $eno=$_POST["eno"];

 	$data = array();
 	if($no!=""){
 		$sql="SELECT * FROM work_resume_data A join member_extend B join member C where A.no='$no' and A.member_no=B.member_no and A.member_no = C.no";
 		$result=mysql_query($sql);
 		while($row=mysql_fetch_array($result)){
 			$oneData["no"] = $row["no"];
 			$oneData["age"] = $row["age"];
 			$oneData["name"] = $row["name"];
 			$oneData["title"] = $row["title"];
 			$oneData["sex"] = $row["sex"];
 			$oneData["time"] = $row["time"];
 			$oneData["wdate"] = $row["wdate"];
 			$oneData["career"] = $row["career"];
 			$oneData["pay"] = $row["pay"];
 			$oneData["email"] = $row["email"];
 			$oneData["phone"] = $row["phone"];
 			$oneData["img_url"] = $row["img_url"];
 			$oneData["birthday"] = $row["birthday"];
 			$oneData["obstacle"] = $row["obstacle"];
                  $oneData["content"] = $row["content"];
                  

 			if ($oneData["obstacle"] == "yes")$oneData["obstacle"]="장애";
			 else if ($oneData["obstacle"] == "no")$oneData["obstacle"]="장애";



 			$keyword = explode(",",$row["keyword"]);
        
            $oneData["area_1st_nm"] = $keyword[0];
            $oneData["area_2nd_nm"] = $keyword[1];
            $oneData["area_3rd_nm"] = $keyword[2];
            $oneData["work_1st_nm"] = $keyword[3];
            $oneData["work_2nd_nm"] = $keyword[4];

            if (empty($oneData["area_1st_nm"])) $oneData["area_1st_nm"] = "";
            if (empty($oneData["area_2nd_nm"])) $oneData["area_2nd_nm"] = "";
            if (empty($oneData["area_3rd_nm"])) $oneData["area_3rd_nm"] = "";
            if (empty($oneData["work_1st_nm"])) $oneData["work_1st_nm"] = "";
            if (empty($oneData["work_2nd_nm"])) $oneData["work_2nd_nm"] = "";


 			 	if ($oneData["time"] == "1")  $oneData["time"] = "오전";
            else if ($oneData["time"] == "2")  $oneData["time"] = "오후";
            else if ($oneData["time"] == "3")  $oneData["time"] = "저녁";
            else if ($oneData["time"] == "4")  $oneData["time"] = "새벽";
            else if ($oneData["time"] == "5")  $oneData["time"] = "오전~오후";
            else if ($oneData["time"] == "6")  $oneData["time"] = "오후~저녁";
            else if ($oneData["time"] == "7")  $oneData["time"] = "저녁~새벽";
            else if ($oneData["time"] == "8")  $oneData["time"] = "새벽~오전";
            else if ($oneData["time"] == "9")  $oneData["time"] = "풀타임";
            else if ($oneData["time"] == "10")  $oneData["time"] = "무관/협의";

                 if ($oneData["sex"] == "male")     $oneData["sex"] = "남자";
            else if ($oneData["sex"] == "female")   $oneData["sex"] = "여자";
            else if ($oneData["sex"] == "nothing") $oneData["sex"] = "무관";  


                 if ($oneData["career"] == "-1")  $oneData["career"] = "무관";
            else if ($oneData["career"] == "0")   $oneData["career"] = "신입";
            else if ($oneData["career"] == "1")   $oneData["career"] = "1년미만";  
            else if ($oneData["career"] == "3")   $oneData["career"] = "3년미만";  
            else if ($oneData["career"] == "5")   $oneData["career"] = "5년미만";  
            else if ($oneData["career"] == "6")   $oneData["career"] = "5년이상";

            $data[]= $oneData;

 		}
      //신청한 날짜 출력
      $sql="SELECT * FROM work_join_list where work_employ_data_no='$eno' and work_resume_data_no='$no'";
      $result=mysql_query($sql);
      $work_date=array();
      while($row = mysql_fetch_array($result)){
            $day["date"]=$row["work_date"];
            $day["choice"]= $row["choice"];
            $work_date[] = $day;
      }

   
    echo json_encode(array('resume' => $data, 'date'=>$work_date ));

 	}

?>