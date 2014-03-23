<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Saleperson extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->library('PHPExcel');
	}

	function index()
	{
		$this->db->set_dbprefix('v_');
		$tbName = 'psal';
		
		function createQuery($_this){
			
			$query = $_this->input->get('query');
			if(!empty($query)){
				$_this->db->where("(`salnr` LIKE '%$query%'
				OR `emnam` LIKE '%$query%')", NULL, FALSE);
			}
			
			$salnr1 = $_this->input->get('salnr');
			$salnr2 = $_this->input->get('salnr2');
			if(!empty($salnr1) && empty($salnr2)){
			  $_this->db->where('salnr', $salnr1);
			}
			elseif(!empty($salnr1) && !empty($salnr2)){
			  $_this->db->where('salnr >=', $salnr1);
			  $_this->db->where('salnr <=', $salnr2);
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
									 ->setTitle("Saleperson")
									 ->setSubject("Saleperson")
									 ->setDescription("Saleperson information.");

		$objPHPExcel->setActiveSheetIndex(0);
		$current_sheet = $objPHPExcel->getActiveSheet();

		// add header data
		$current_sheet
	            ->setCellValue('A1', 'Saleperson No')
				->setCellValue('B1', 'Saleperson Name')
	            ->setCellValue('C1', 'Employee No')
	            ->setCellValue('D1', 'Commission Type');

		// Add some data
		$result_array = $query->result_array();
		for($i=0;$i<count($result_array);$i++){
			$value = $result_array[$i];
			$excel_i = $i+2;
			$current_sheet
		            ->setCellValue('A'.$excel_i, $value['salnr'])
					->setCellValue('B'.$excel_i, $value['name1'])
		            ->setCellValue('C'.$excel_i, $value['empnr'])
		            ->setCellValue('D'.$excel_i, $value['ctype']);
		}


		// Adjust header cell format
		foreach(range('A','D') as $columnID) {
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
		header('Content-Disposition: attachment;filename="saleperson_'.date('Y-m-d_H:i:s').'.xls"');
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