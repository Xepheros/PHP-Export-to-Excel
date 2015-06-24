<?php
 /**
   * PHP Export to Excel - ExcelGenerate
   * ==================================================
   * Author : Thanadon X Songsuittipong
   * ==================================================
   * using PHPExcel Libraries 
   * Available at http://phpexcel.codeplex.com/
   */

	error_reporting(E_ALL);
	ini_set('display_errors', TRUE);
	ini_set('display_startup_errors', TRUE);
	if (PHP_SAPI == 'cli') die('This should only be run from a Web Browser');

	// Include PHPExcel 
	require('Classes/PHPExcel.php');
	// Include DBFunction
	require('dbfunction.php');

	// Create new PHPExcel object
	$objPHPExcel = new PHPExcel();

	// Add Column Header
	$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Member ID')
            ->setCellValue('B1', 'Username')
            ->setCellValue('C1', 'Full Name')
            ->setCellValue('D1', 'Last Export');

    // Get input data
    if(isset($_POST["chkSelect"]))
	{
     	$input = $_POST["chkSelect"];
	} else {
		$input = false;
	}

    $now = date("Y-m-d H:i:s");

    for($i = 0; $i<count($input); $i++) {
    	if($input[$i] != "")
		{
			// Update last export date time
			update_lastexport($input[$i],$now);

			// Get data with memberID
			$result = get_data($input[$i]);
			$row = $result->fetch_row(); 

			// Set Excel row to write
			$d = $i + 2;

			$objPHPExcel->getActiveSheet()->setCellValue('A' . $d, $row[0]);
			$objPHPExcel->getActiveSheet()->setCellValue('B' . $d, $row[1]);
			$objPHPExcel->getActiveSheet()->setCellValue('C' . $d, $row[2]);
			$objPHPExcel->getActiveSheet()->setCellValue('D' . $d, $row[3]);
			
		}
    }

    // If contains data select
    if(isset($_POST["chkSelect"]))
	{
    // Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('Data');

	// Set active sheet index to the first sheet
    $objPHPExcel->setActiveSheetIndex(0);

    // Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="mydata.xlsx"');
	header('Cache-Control: max-age=0');
	// If you're serving to IE 9, then the following may be needed
	header('Cache-Control: max-age=1');

	// If you're serving to IE over SSL, then the following may be needed
	header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
	header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
	header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	header ('Pragma: public'); // HTTP/1.0

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');
	
	exit;
	} else {
		die('No data selected');
	}
?>