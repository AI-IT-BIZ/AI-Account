<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Purchasedebitnote extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->library('PHPExcel');
	}

	function index()
	{
		$this->db->set_dbprefix('v_');
		$tbName = 'ebdn';
		
		// Start for report
		function createQuery($_this){
			$query = $_this->input->get('query');
			if(!empty($query)){
				$_this->db->where("(debnr LIKE '%$query%'
				OR lifnr LIKE '%$query%'
				OR name1 LIKE '%$query%'
				OR invnr LIKE '%$query%')", NULL, FALSE);
			}
			
			$invnr1 = $_this->input->get('invnr');
			$invnr2 = $_this->input->get('invnr2');
			if(!empty($invnr1) && empty($invnr2)){
			  $_this->db->where('invnr', $invnr1);
			}
			elseif(!empty($invnr1) && !empty($invnr2)){
			  $_this->db->where('invnr >=', $invnr1);
			  $_this->db->where('invnr <=', $invnr2);
			}
			
	        $debnr1 = $_this->input->get('debnr');
			$debnr2 = $_this->input->get('debnr2');
			if(!empty($debnr1) && empty($debnr2)){
			  $_this->db->where('debnr', $debnr1);
			}
			elseif(!empty($debnr1) && !empty($debnr2)){
			  $_this->db->where('debnr >=', $debnr1);
			  $_this->db->where('debnr <=', $debnr2);
			}
			
			$bldat1 = $_this->input->get('bldat');
			$bldat2 = $_this->input->get('bldat2');
			if(!empty($bldat1) && empty($bldat2)){
			  $_this->db->where('bldat', $bldat1);
			}
			elseif(!empty($bldat1) && !empty($bldat2)){
			  $_this->db->where('bldat >=', $bldat1);
			  $_this->db->where('bldat <=', $bldat2);
			}
			
			$lifnr1 = $_this->input->get('lifnr');
			$lifnr2 = $_this->input->get('lifnr2');
			if(!empty($lifnr1) && empty($lifnr2)){
			  $_this->db->where('lifnr', $lifnr1);
			}
			elseif(!empty($lifnr1) && !empty($lifnr2)){
			  $_this->db->where('lifnr >=', $lifnr1);
			  $_this->db->where('lifnr <=', $lifnr2);
			}

			$statu1 = $_this->input->get('statu');
			$statu2 = $_this->input->get('statu2');
			if(!empty($statu1) && empty($statu2)){
			  $_this->db->where('statu', $statu1);
			}
			elseif(!empty($statu1) && !empty($statu2)){
			  $_this->db->where('statu >=', $statu1);
			  $_this->db->where('statu <=', $statu2);
			}
		}

		createQuery($this);
		$sort = $this->input->get('sort');
		$dir = $this->input->get('dir');
		$this->db->order_by($sort, $dir);

		$query = $this->db->get($tbName);

		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();

		// Set document properties
		$objPHPExcel->getProperties()->setCreator("Prime BizNet")
									 ->setLastModifiedBy("Prime BizNet")
									 ->setTitle("Debit Note")
									 ->setSubject("Debit Note")
									 ->setDescription("Debit Note information.");

		$objPHPExcel->setActiveSheetIndex(0);
		$current_sheet = $objPHPExcel->getActiveSheet();

		// add header data
		$current_sheet
	            ->setCellValue('A1', 'Debit Note No')
	            ->setCellValue('B1', 'Debit Note Date')
	            ->setCellValue('C1', 'Vendor No')
	            ->setCellValue('D1', 'Vendor Name')
	            ->setCellValue('E1', 'Invoice No')
				->setCellValue('F1', 'Sale Name')
	            ->setCellValue('G1', 'Status')
	            ->setCellValue('H1', 'Amount')
	            ->setCellValue('I1', 'Currency');

		// Add some data
		$result_array = $query->result_array();
		for($i=0;$i<count($result_array);$i++){
			$value = $result_array[$i];
			$excel_i = $i+2;
			$current_sheet
		            ->setCellValue('A'.$excel_i, $value['debnr'])
		            ->setCellValue('B'.$excel_i, util_helper_format_date($value['bldat']))
		            ->setCellValue('C'.$excel_i, $value['lifnr'])
		            ->setCellValue('D'.$excel_i, $value['name1'])
		            ->setCellValue('E'.$excel_i, $value['invnr'])
					->setCellValue('G'.$excel_i, $value['sname'])
		            ->setCellValue('F'.$excel_i, $value['statx'])
		            ->setCellValue('H'.$excel_i, number_format($value['netwr'],2,'.',','))
		            ->setCellValue('I'.$excel_i, $value['ctype']);
		}


		// Adjust header cell format
		foreach(range('A','I') as $columnID) {
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
		header('Content-Disposition: attachment;filename="purchase_debitnote_'.date('Y-m-d_H:i:s').'.xls"');
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