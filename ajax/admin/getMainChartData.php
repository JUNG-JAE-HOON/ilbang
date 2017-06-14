<?php
    include_once "../../db/connect.php";
  
    $year        = $_POST['year'];
    $adminId     = $_POST['adminId'];

    //$year		= "2016";
    //$adminId	= "GIGA";

	$sql  = "	SELECT '구인중' as type 								";
	$sql .= "  		, DATE_FORMAT(A.wdate, '%c') as m		        ";
	$sql .= "		,  count(A.no) as guingujikCnt 					";
	$sql .= "	FROM work_employ_data A 							";
	$sql .= "	WHERE 1=1 											";
	$sql .= "	AND A.view = 'yes' 									";
	$sql .= "	AND A.no IN ( SELECT C.no 							";
	$sql .= "   	           FROM work_employ_data C, member D 	";
	$sql .= "       	       WHERE 1=1 							";					
	$sql .= "           	   AND D.reuid = '$adminId'		     	";
	$sql .= "            	   AND C.member_no = D.no 				";
	$sql .= "             	   AND C.view = 'yes' 					";
	$sql .= "             	   AND D.kind = 'company' 				";
	$sql .= "		    	) 										";
	$sql .= "	AND DATE_FORMAT(A.wdate,'%Y') = '$year' 			";
	$sql .= "	GROUP BY DATE_FORMAT(A.wdate, '%c')  				";
	$sql .= "	UNION 												";
	$sql .= "	SELECT '구직중' as type 								";
	$sql .= "		, DATE_FORMAT(A.wdate, '%c') as m        		";
	$sql .= "		,  count(A.no) as guingujikCnt 					";
	$sql .= "	FROM work_resume_data A 							";
	$sql .= "	WHERE 1=1 											";
	$sql .= "	AND A.view = 'yes' 									";
	$sql .= "	AND A.no IN ( SELECT C.no 							";
	$sql .= "   	           FROM work_resume_data C, member D 	";
	$sql .= "       	       WHERE 1=1 							";
	$sql .= "           	   AND D.reuid = '$adminId' 			";
	$sql .= "            	   AND C.member_no = D.no 				";
	$sql .= "             	   AND C.view = 'yes' 					";
	$sql .= "              	  AND D.kind = 'general' 				";
	$sql .= "		    	) 										";
	$sql .= "	AND DATE_FORMAT(A.wdate,'%Y') = '$year' 			";
	$sql .= "	GROUP BY DATE_FORMAT(A.wdate, '%c') 				";


	$result = mysql_query($sql, $ilbang_con);

	while($row = mysql_fetch_array($result)){

            $oneData["type"]       		= $row["type"]				;
            $oneData["m"]       		= $row["m"]			;
        	$oneData["guingujikCnt"]    = $row["guingujikCnt"]		;
            
            $listData[]  = $oneData;
    }

    $chartData = array();

    $chartOneData["seriesname"] = "구인중";
    $chartDataArr["0"]["value"] = "0";
    $chartDataArr["1"]["value"] = "0";
    $chartDataArr["2"]["value"] = "0";
    $chartDataArr["3"]["value"] = "0";
    $chartDataArr["4"]["value"] = "0";
    $chartDataArr["5"]["value"] = "0";
    $chartDataArr["6"]["value"] = "0";
    $chartDataArr["7"]["value"] = "0";
    $chartDataArr["8"]["value"] = "0";
    $chartDataArr["9"]["value"] = "0";
    $chartDataArr["10"]["value"] = "0";
    $chartDataArr["11"]["value"] = "0";

    for ($i=0; $i<count($listData); $i++){ 

    	if($listData[$i]["type"]=="구인중"){
    		$chartDataArr[intval($listData[$i]["m"])-1]["value"] = $listData[$i]["guingujikCnt"];
    	}
    }
    $chartOneData["data"] = $chartDataArr;
    $chartData[] =  $chartOneData; 


    $chartOneData["seriesname"] = "구직중";
    $chartDataArr["0"]["value"] = "0";
    $chartDataArr["1"]["value"] = "0";
    $chartDataArr["2"]["value"] = "0";
    $chartDataArr["3"]["value"] = "0";
    $chartDataArr["4"]["value"] = "0";
    $chartDataArr["5"]["value"] = "0";
    $chartDataArr["6"]["value"] = "0";
    $chartDataArr["7"]["value"] = "0";
    $chartDataArr["8"]["value"] = "0";
    $chartDataArr["9"]["value"] = "0";
    $chartDataArr["10"]["value"] = "0";
    $chartDataArr["11"]["value"] = "0";


    for ($i=0; $i<count($listData); $i++){ 

        if($listData[$i]["type"]=="구직중"){
            $chartDataArr[intval($listData[$i]["m"])-1]["value"] = $listData[$i]["guingujikCnt"];
        }
    }

    $chartOneData["data"] = $chartDataArr;
    $chartData[] = $chartOneData;

    echo json_encode(array('chartData' => $chartData));
?>