<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ChartofAccount extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->library('PHPExcel');
	}

	function index()
	{
		$this->db->set_dbprefix('tbl_');
		$tbName = 'glno';
		

		$query = $this->db->get($tbName);

		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();

		// Set document properties
		$objPHPExcel->getProperties()->setCreator("Prime BizNet")
									 ->setLastModifiedBy("Prime BizNet")
									 ->setTitle("Chart Of Account")
									 ->setSubject("Chart Of Account")
									 ->setDescription("Chart Of Account");

		$objPHPExcel->setActiveSheetIndex(0);
		$current_sheet = $objPHPExcel->getActiveSheet();

		// add header data
		$current_sheet
	            ->setCellValue('A1', 'Account Code')
	            ->setCellValue('B1', 'Name Thai')
	            ->setCellValue('C1', 'Name Eng')
	            ->setCellValue('D1', 'Type(1=Group, 2=Sub)')
				->setCellValue('E1', 'GL Group')
	            ->setCellValue('F1', 'GL Level')
	            ->setCellValue('G1', 'GL Over')
	            ->setCellValue('H1', 'Department');
				
		// Add some data
		$result_array = $query->result_array();
		for($i=0;$i<count($result_array);$i++){
			$value = $result_array[$i];
			$excel_i = $i+2;
			$current_sheet
					->setCellValue('A'.$excel_i, $value['saknr'])
		            ->setCellValue('B'.$excel_i, $value['sgtxt'])
		            ->setCellValue('C'.$excel_i, $value['entxt'])
					->setCellValue('E'.$excel_i, $value['glgrp'])
					->setCellValue('F'.$excel_i, $value['gllev'])
		            ->setCellValue('D'.$excel_i, $value['gltyp'])
		            ->setCellValue('G'.$excel_i, $value['overs'])
		            ->setCellValue('H'.$excel_i, $value['depar']);
		}


		// Adjust header cell format
		foreach(range('A','H') as $columnID) {
		    $current_sheet->getColumnDimension($columnID)->setAutoSize(true);

			// add color to head
			$cell_style = $current_sheet->getStyle($columnID.'1');
			$cell_style->applyFromArray(
				array(
					'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'color' => array('rgb' => '62BB46')
					),
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
					)//,
					//'font' => array(
					//	'bold' => true
					//)
				)
			);
		}

		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);

		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="chart_of_account_'.date('Y-m-d_H:i:s').'.xls"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		exit;
	}

}

?>