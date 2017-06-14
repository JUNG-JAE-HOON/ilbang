<?php
    include_once "../../db/connect.php";

    $uid=$_POST["uid"];
// $uid="slslcx";
$sql="SELECT * FROM  work_resume_data WHERE uid='$uid'";
$result=mysql_query($sql);

$listData=array();
while($row = mysql_fetch_array($result)){
    $data["title"] =$row["title"];
    $data["keyword"]=$row["keyword"];
    $data["pay"]=$row["pay"];
    $data["age"]=$row["age"];
    $data["career"]=$row["career"];
    $data["no"]=$row["no"];
    $listData[]=$data;

}

 echo json_encode(array('listData' => $listData ));


  

?>