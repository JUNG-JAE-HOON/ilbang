<?php
include_once "../../db/connect.php";

$rno =$_POST["rno"];
$eno = $_POST["eno"];
$chked_val = $_POST["chked_val"];
// $eno="685";
// $rno="10425";
// $chked_val="2017-01-19";

$data=array();
$work_date = split(',',$chked_val);
for($i=0; $i<count($work_date); $i++){
		$sql="SELECT * FROM work_join_list where work_employ_data_no='$eno' and work_resume_data_no='$rno' and work_date='$work_date[$i]'";
		$result= mysql_query($sql);
		// echo $sql;
		while($row= mysql_fetch_array($result)){
			 $choice= $row["choice"];
			 $no = $row["no"];
			 if($choice=='yes'){
			 	//승인 취소
			 	$sql="UPDATE work_join_list SET choice='no' where no='$no'";
			 	mysql_query($sql);
			 	$message["message"]=$work_date[$i]."일 승인 취소";
			 	$message["work_date"]=$work_date[$i];
			 	$message["choice"]="no";
			 	$data[] = $message;
			 }else{
			 	//승인 
			 	$sql="UPDATE work_join_list SET choice='yes' where no='$no'";
			 	mysql_query($sql);
			 	$message["message"]=$work_date[$i]."일 승인 ";
			 	$message["work_date"]=$work_date[$i];
			 	$message["choice"]="yes";
			 	$data[] = $message;
			 }

		}

}


 echo json_encode(array('join' => $data));

?>