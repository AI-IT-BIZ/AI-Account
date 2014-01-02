<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Receipt extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->library('PHPExcel');
	}

	function index()
	{
		$this->db->set_dbprefix('v_');
		$tbName = 'vbbp';
		
		// Start for report
		function createQuery($_this){
			$query = $_this->input->get('query');
			if(!empty($query)){
				$_this->db->where("(`recnr` LIKE '%$query%'
				OR `kunnr` LIKE '%$query%'
				OR `name1` LIKE '%$query%')", NULL, FALSE);
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
			
			$kunnr1 = $_this->input->get('kunnr');
			$kunnr2 = $_this->input->get('kunnr2');
			if(!empty($kunnr1) && empty($kunnr2)){
			  $_this->db->where('kunnr', $kunnr1);
			}
			elseif(!empty($kunnr1) && !empty($kunnr2)){
			  $_this->db->where('kunnr >=', $kunnr1);
			  $_this->db->where('kunnr <=', $kunnr2);
			}
			
			$recnr1 = $_this->input->get('recnr');
			$recnr2 = $_this->input->get('recnr2');
			if(!empty($recnr1) && empty($recnr2)){
			  $_this->db->where('recnr', $recnr1);
			}
			elseif(!empty($recnr1) && !empty($recnr2)){
			  $_this->db->where('recnr >=', $recnr1);
			  $_this->db->where('recnr <=', $recnr2);
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
									 ->setTitle("Receipt")
									 ->setSubject("Receipt")
									 ->setDescription("Receipt information.");
	    /*Font Style*****************************************************/
          $StyleHeadCompany = array(
                        'font'  => array(
                        'bold'  => true,
                        'color' => array('rgb' => 'FF0000'),
                        'size'  => 15,
                        'name'  => 'Verdana'
                       ));
            $StyleHeadReportName = array(
                        'font'  => array(
                        'bold'  => true,
                        'color' => array('rgb' => '1C1C1C'),
                        'size'  => 12,
                        'name'  => 'Verdana'
                       ));
            
            $StyleHeadReportDetail = array(
                        'font'  => array(
                        'bold'  => true,
                        'color' => array('rgb' => '1C1C1C'),
                        'size'  => 10,
                        'name'  => 'Verdana'
                       ));
          /******************************************************/
          
          $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D1:E1:')
                                             // ->mergeCells('H1:J1:')
                                              ->setCellValue('D1', 'Company Name :');
          $objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($StyleHeadCompany);
          /*---------------------------------------------------------------*/
          $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D2:E2')
                                              ->setCellValue('D2', 'Sale Receipt List Report');
          $objPHPExcel->getActiveSheet()->getStyle('D2')->applyFromArray($StyleHeadReportName);
          /*---------------------------------------------------------------*/
          $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:B4')
                                              ->setCellValue('A4', 'Selection Report No.');
          $objPHPExcel->getActiveSheet()->getStyle('A4')->applyFromArray($StyleHeadReportDetail);
          /*---------------------------------------------------------------*/
          $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A5:C5')
                                              ->setCellValue('A5', 'Selection Period : ' .$date_select);
          $objPHPExcel->getActiveSheet()->getStyle('A5')->applyFromArray($StyleHeadReportDetail);
          /*---------------------------------------------------------------*/
        //  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A6:C6')
         //                                     ->setCellValue('A6', 'Running by Sale Tax Invoind Number');
        //  $objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($StyleHeadReportDetail);
          /*---------------------------------------------------------------*/
          $objPHPExcel->setActiveSheetIndex(0)->mergeCells('O4:P4')
                                              ->setCellValue('O4', 'Page:');
           $objPHPExcel->getActiveSheet()->getStyle('O4')->applyFromArray($StyleHeadReportDetail);
          /*---------------------------------------------------------------*/
           $objPHPExcel->setActiveSheetIndex(0)->mergeCells('G5:H5')
                                              ->setCellValue('G5', 'Document Status : ' . $statu_tax);
           $objPHPExcel->getActiveSheet()->getStyle('G5')->applyFromArray($StyleHeadReportDetail);
          /*---------------------------------------------------------------*/
           $objPHPExcel->setActiveSheetIndex(0)->mergeCells('G6:H6')
                                              ->setCellValue('G6', 'Print Date : ' . date('Y-m-d H:i:s'));
           $objPHPExcel->getActiveSheet()->getStyle('G6')->applyFromArray($StyleHeadReportDetail);
          /*---------------------------------------------------------------*/
          /*******************************************************************/

		$objPHPExcel->setActiveSheetIndex(0);
		$current_sheet = $objPHPExcel->getActiveSheet();

		// add header data
		$current_sheet
	            ->setCellValue('A1', 'Receipt No')
	            ->setCellValue('B1', 'Document Date')
	            ->setCellValue('C1', 'Customer No')
	            ->setCellValue('D1', 'Customer Name')
	            ->setCellValue('E1', 'Net Amount')
	            ->setCellValue('F1', 'Invoice No')
	            ->setCellValue('G1', 'Invoice Date')
	            ->setCellValue('H1', 'Amount');

		// Add some data
		$result_array = $query->result_array();
		for($i=0;$i<count($result_array);$i++){
			$value = $result_array[$i];
			$excel_i = $i+2;
			$current_sheet
		            ->setCellValue('A'.$excel_i, $value['recnr'])
		            ->setCellValue('B'.$excel_i, util_helper_format_date($value['bldat']))
		            ->setCellValue('C'.$excel_i, $value['kunnr'])
		            ->setCellValue('D'.$excel_i, $value['name1'])
		            ->setCellValue('E'.$excel_i, preg_replace('/(\.00)$/' ,'',$value['netwr'], 2))
		            ->setCellValue('F'.$excel_i, $value['invnr'])
		            ->setCellValue('G'.$excel_i, $value['invdt'])
		            ->setCellValue('H'.$excel_i, preg_replace('/(\.00)$/' ,'',$value['itamt'], 2));
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
		header('Content-Disposition: attachment;filename="receipt_'.date('Y-m-d_H:i:s').'.xls"');
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