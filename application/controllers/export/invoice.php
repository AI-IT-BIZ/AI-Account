<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invoice extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->library('PHPExcel');
	}

	function index()
	{
		$this->db->set_dbprefix('v_');
		$tbName = 'vbrk';
		
		// Start for report
		function createQuery($_this){
			$query = $_this->input->get('query');
			if(!empty($query)){
				$_this->db->where("(invnr LIKE '%$query%'
				OR kunnr LIKE '%$query%'
				OR name1 LIKE '%$query%'
				OR ordnr LIKE '%$query%')", NULL, FALSE);
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
			
	        $ordnr1 = $_this->input->get('ordnr');
			$ordnr2 = $_this->input->get('ordnr2');
			if(!empty($ordnr1) && empty($ordnr2)){
			  $_this->db->where('ordnr', $ordnr1);
			}
			elseif(!empty($ordnr1) && !empty($ordnr2)){
			  $_this->db->where('ordnr >=', $ordnr1);
			  $_this->db->where('ordnr <=', $ordnr2);
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
			
			$jobnr1 = $_this->input->get('jobnr');
			$jobnr2 = $_this->input->get('jobnr2');
			if(!empty($jobnr1) && empty($jobnr2)){
			  $_this->db->where('jobnr', $jobnr1);
			}
			elseif(!empty($jobnr1) && !empty($jobnr2)){
			  $_this->db->where('jobnr >=', $jobnr1);
			  $_this->db->where('jobnr <=', $jobnr2);
			}
			
			$kunnr1 = $_this->input->get('kunnr');
			$kunnr2 = $_this->input->get('kunnr2');
			if(!empty($kunnr1) && empty($kunnr2)){
			  $_this->db->where('kunnr', $kunnr1);
			}
			elseif(!empty($kunnr1) && !empty($kunnr2)){
			  $_this->db->where('kunnr >=', $kunnr1);
			  $_this->db->where('kunnr <=', $kunnr2);
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
			
			if(db_helper_is_mssql($_this))
			   $_this->db->where("(itype is null)", NULL, FALSE);
			elseif(db_helper_is_mysql($_this)) {
			   $_this->db->where("(isnull(itype))", NULL, FALSE);
			}
		}
// End for report

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
									 ->setTitle("Invoice")
									 ->setSubject("Invoice")
									 ->setDescription("Invoice information.");

		$objPHPExcel->setActiveSheetIndex(0);
		$current_sheet = $objPHPExcel->getActiveSheet();

		// add header data
		$current_sheet
	            ->setCellValue('A1', 'Invoice No')
	            ->setCellValue('B1', 'Invoice Date')
	            ->setCellValue('C1', 'Customer No')
	            ->setCellValue('D1', 'Customer Name')
	            ->setCellValue('E1', 'Delivery Order No')
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
		            ->setCellValue('A'.$excel_i, $value['invnr'])
		            ->setCellValue('B'.$excel_i, util_helper_format_date($value['bldat']))
		            ->setCellValue('C'.$excel_i, $value['kunnr'])
		            ->setCellValue('D'.$excel_i, $value['name1'])
		            ->setCellValue('E'.$excel_i, $value['delnr'])
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
		header('Content-Disposition: attachment;filename="invoice_'.date('Y-m-d_H:i:s').'.xls"');
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