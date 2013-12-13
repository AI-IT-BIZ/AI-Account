<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Service extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->library('PHPExcel');
	}

	function index()
	{
		$this->db->set_dbprefix('v_');
		$tbName = 'mara';
		
		function createQuery($_this){
			
			$query = $_this->input->get('query');
			if(!empty($query)){
				$_this->db->where("(`matnr` LIKE '%$query%'
				OR `maktx` LIKE '%$query%'
				OR `mtart` LIKE '%$query%')
				and `mtart` = 'SV'", NULL, FALSE);
			}else{
				$_this->db->where("`mtart` = 'SV'", NULL, FALSE);
			}
			
			$matnr1 = $_this->input->get('matnr');
			$matnr2 = $_this->input->get('matnr2');
			if(!empty($matnr1) && empty($matnr2)){
			  $_this->db->where('matnr', $matnr1);
			}
			elseif(!empty($matnr1) && !empty($matnr2)){
			  $_this->db->where('matnr >=', $matnr1);
			  $_this->db->where('matnr <=', $matnr2);
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
									 ->setTitle("Service")
									 ->setSubject("Service")
									 ->setDescription("Service information.");

		$objPHPExcel->setActiveSheetIndex(0);
		$current_sheet = $objPHPExcel->getActiveSheet();

		// add header data
		$current_sheet
	            ->setCellValue('A1', 'Service No')
				->setCellValue('B1', 'Service Name')
	            ->setCellValue('C1', 'Service Type')
	            ->setCellValue('D1', 'Service Group')
	            ->setCellValue('E1', 'Unit')
	            ->setCellValue('F1', 'Create Date')
	            ->setCellValue('G1', 'GL No')
				->setCellValue('H1', 'Status')
				
				->setCellValue('I1', 'Cost 1')
				->setCellValue('J1', 'Unit 1')
	            ->setCellValue('K1', 'Cost 2')
	            ->setCellValue('L1', 'Unit 2')
	            ->setCellValue('M1', 'Cost 3')
	            ->setCellValue('N1', 'Unit 3');

		// Add some data
		$result_array = $query->result_array();
		for($i=0;$i<count($result_array);$i++){
			$value = $result_array[$i];
			$excel_i = $i+2;
			$current_sheet
		            ->setCellValue('A'.$excel_i, $value['matnr'])
					->setCellValue('B'.$excel_i, $value['maktx'])
		            ->setCellValue('C'.$excel_i, $value['mtype'])
		            ->setCellValue('D'.$excel_i, $value['mgrpp'])
		            ->setCellValue('E'.$excel_i, $value['meins'])
                    ->setCellValue('F'.$excel_i, $value['erdat'])
		            ->setCellValue('G'.$excel_i, $value['saknr'])
					
					->setCellValue('H'.$excel_i, $value['statu'])
					->setCellValue('I'.$excel_i, $value['cost1'])
		            ->setCellValue('J'.$excel_i, $value['unit1'])
		            ->setCellValue('K'.$excel_i, $value['cost2'])
		            ->setCellValue('L'.$excel_i, $value['unit2'])
                    ->setCellValue('M'.$excel_i, $value['cost3'])
		            ->setCellValue('N'.$excel_i, $value['unit3']);
		}


		// Adjust header cell format
		foreach(range('A','N') as $columnID) {
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
		header('Content-Disposition: attachment;filename="service_'.date('Y-m-d_H:i:s').'.xls"');
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