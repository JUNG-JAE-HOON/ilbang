<?php
	include_once("../lib/excel/PHPExcel.php");
	
	$file_name = $_FILES["fileToUpload"]["tmp_name"];
	$objPHPExcel = PHPExcel_IOFactory::load($file_name);

	$sheetsCount = $objPHPExcel->getSheetCount();
 
	/* 쉬트별로 읽기 */
	for($i = 0; $i < $sheetsCount; $i++)
	{
	    $objPHPExcel	-> setActiveSheetIndex($i);
	    $sheet 			= $objPHPExcel->getActiveSheet();
	    $highestRow 	= $sheet->getHighestRow(); 
	    $highestColumn 	= $sheet->getHighestColumn();
 
	    /* 한줄읽기 */
	    for ($row = 1; $row <= $highestRow; $row++)
	    {
	        /* $rowData가 한줄의 데이터를 셀별로 배열처리 됩니다. */
	        $colA = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

	        $colB = $sheet->rangeToArray('B' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

	        $colC = $sheet->rangeToArray('C' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

	        $date = PHPExcel_Style_NumberFormat::toFormattedString($colC[0][0], PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);

	        //echo $colA[0][0].' '.$colB[0][0].' '.$date. ' '.$colC[0][0];
	        //echo "<br>";


	    }

	    echo json_encode(array('colA' => $colA[0][0]));
	}
?>
