<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class RAssetregister extends CI_Controller {
      
     
      function __construct()
      {
		parent::__construct();

		$this->load->library('PHPExcel');
      }
      
      function Index()
      {
                 
        $this->db->set_dbprefix('v_');
		$tbName = 'fara';
		$bldat1 = $this->input->get('bldat');
		function createQuery($_this){
			
			$query = $_this->input->get('query');
			if(!empty($query)){
				$_this->db->where("(matnr LIKE '%$query%'
				OR maktx LIKE '%$query%'
				OR mtart LIKE '%$query%')", NULL, FALSE);
			//}else{
			//	$_this->db->where("mtart <> 'SV'", NULL, FALSE);
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
		// End for report		
		createQuery($this);
		$query = $this->db->get($tbName);
                
        $result_array = $query->result_array();
		$start = $result_array[0]; 
		$irow=count($result_array);
		$irow=$irow-1;  
		$end = $result_array[$irow]; 
		if(empty($docno)) $docno=$start['matnr'].' - '.$end['matnr'];       
                /********************************************************/
                
                 // Create new PHPExcel object
		$objPHPExcel = new PHPExcel();

		// Set document properties
		$objPHPExcel->getProperties()->setCreator("Prime BizNet")
									 ->setLastModifiedBy("Prime BizNet")
									 ->setTitle("Fixed Asset Register")
									 ->setSubject("Fixed Asset Register")
									 ->setDescription("Fixed Asset information.");
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
          
          $objPHPExcel->setActiveSheetIndex(0)->mergeCells('J1:M1:')
                                             // ->mergeCells('H1:J1:')
                                              ->setCellValue('J1', 'Company Name : Bangkok Media Co.,Ltd');
          $objPHPExcel->getActiveSheet()->getStyle('J1')->applyFromArray($StyleHeadCompany);
          /*---------------------------------------------------------------*/
          $objPHPExcel->setActiveSheetIndex(0)->mergeCells('J2:M2')
                                              ->setCellValue('J2', 'Fixed Asset Register Report');
          $objPHPExcel->getActiveSheet()->getStyle('J2')->applyFromArray($StyleHeadReportName);
          /*---------------------------------------------------------------*/
          $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:B4')
                                              ->setCellValue('A4', 'Selection Report No.');
          $objPHPExcel->getActiveSheet()->getStyle('A4')->applyFromArray($StyleHeadReportDetail);
          /*---------------------------------------------------------------*/
          $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A5:D5')
                                              ->setCellValue('A5', 'Selection Period : '.util_helper_format_date($bldat1));
          $objPHPExcel->getActiveSheet()->getStyle('A5')->applyFromArray($StyleHeadReportDetail);
          /*---------------------------------------------------------------*/
          $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A6:E6')
                                              ->setCellValue('A6', 'Running by Fixed Asset No : '.$docno);
          $objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($StyleHeadReportDetail);
          /*---------------------------------------------------------------*/
          //$objPHPExcel->setActiveSheetIndex(0)->mergeCells('O4:P4')
          //                                    ->setCellValue('O4', 'Page:1');
          //$objPHPExcel->getActiveSheet()->getStyle('O4')->applyFromArray($StyleHeadReportDetail);
          /*---------------------------------------------------------------*/
           $objPHPExcel->setActiveSheetIndex(0)->mergeCells('T5:V5')
                                              ->setCellValue('T5', 'Document Status : ');
           $objPHPExcel->getActiveSheet()->getStyle('T5')->applyFromArray($StyleHeadReportDetail);
          /*---------------------------------------------------------------*/
           $objPHPExcel->setActiveSheetIndex(0)->mergeCells('T6:V6')
                                              ->setCellValue('T6', 'Print Date : ' . date('d/m/Y H:i:s'));
           $objPHPExcel->getActiveSheet()->getStyle('T6')->applyFromArray($StyleHeadReportDetail);
          /*---------------------------------------------------------------*/
          /*******************************************************************/

		$objPHPExcel->setActiveSheetIndex(0);
		$current_sheet = $objPHPExcel->getActiveSheet();

		// add header data
		$current_sheet
	                  ->setCellValue('A8', 'Fixed Asset No.')
					  ->setCellValue('B8', 'Fixed Asset Name')
                      ->setCellValue('C8', 'Asset Type')
					  ->setCellValue('D8', 'Asset Type Description')
                      ->setCellValue('E8', 'Asset Group')
					  ->setCellValue('F8', 'Asset Group Description')
                      ->setCellValue('G8', 'Under Asset No.')
					  ->setCellValue('H8', 'Under Asset Name')
                      ->setCellValue('I8', 'Serial No')
                      ->setCellValue('J8', 'Acquisition Date')
                      ->setCellValue('K8', 'Cost Value')
					  ->setCellValue('L8', 'GL Account Code')
                      ->setCellValue('M8', 'Residual Value')
                      ->setCellValue('N8', 'Use ful life (year)')
                      ->setCellValue('O8', '% of depreciation')
                      ->setCellValue('P8', 'Monthly Depreciation')
                      ->setCellValue('Q8', 'Yearly Depreciation')
                      ->setCellValue('R8', 'The Current Date')
                      ->setCellValue('S8', 'Days for Depreciation')
                      ->setCellValue('T8', 'Accummulated Depreciation')
                      ->setCellValue('U8', 'GL Account Code')
					  ->setCellValue('V8', 'Book Value');
                
		// Add some data
		$asstx='';$deprey=0;$deprem=0;$curdt='';$daysc=0;
		$accum=0;$saknr2='';$books=0;
		for($i=0;$i<count($result_array);$i++){
			$value = $result_array[$i];
			$excel_i = $i+9;
                     	
			//Under asset
			$this->db->set_dbprefix('tbl_');
			$q_qt = $this->db->get_where('fara', array(
				'matnr'=>$value['assnr']
			));
			if($q_qt->num_rows()>0){
			$r_qt = $q_qt->first_row('array');
			$asstx = $r_qt['maktx'];
			}
			
			$deprey = $value['costv'] - $value['resid'];
			if($value['lifes']>0){
			   $deprey = $deprey / $value['lifes'];
			   $deprem = $deprey / 12;
			}else{
			   $deprey = 0;
			   $deprem = 0;
			}
			//echo $this->input->get('bldat');
			$curdt = $this->input->get('bldat');
			
			$stdat = util_helper_get_time_by_date_string($curdt);
			$grdat = util_helper_get_time_by_date_string($value['bldat']);
			$time_diff = $stdat - $grdat;
			$day = ceil($time_diff/(24 * 60 * 60));
			$daysc = $day;
			
			$deprey = $value['costv'] - $value['resid'];
			$deprey = $deprey * $value['depre'] * $day;
			$accum = $deprey / 365;
			
			$saknr2 = '5xxxxxxxx';
			
			$books = $value['costv'] - $accum;
					
                    $current_sheet
		            ->setCellValue('A'.$excel_i, $value['matnr'])
		            ->setCellValue('B'.$excel_i, $value['maktx'])
		            ->setCellValue('C'.$excel_i, $value['mtart'])
		            ->setCellValue('D'.$excel_i, $value['mtype'])
					->setCellValue('E'.$excel_i, $value['matkl'])
		            ->setCellValue('F'.$excel_i, $value['mgrpp'])
			        ->setCellValue('G'.$excel_i, $value['assnr'])
		            ->setCellValue('H'.$excel_i, $asstx)
                    ->setCellValue('I'.$excel_i, $value['serno'])
		            ->setCellValue('J'.$excel_i, util_helper_format_date($value['bldat']))  
   
                    ->setCellValue('K'.$excel_i, number_format($value['costv'],2,'.',','))
                    ->setCellValue('L'.$excel_i, $value['saknr'])
                    ->setCellValue('M'.$excel_i, number_format($value['resid'],2,'.',','))
                    ->setCellValue('N'.$excel_i, $value['lifes'])
                    ->setCellValue('O'.$excel_i, $value['depre'])
                    ->setCellValue('P'.$excel_i, number_format($deprem,2,'.',','))
                    ->setCellValue('Q'.$excel_i, number_format($deprey,2,'.',','))
					
					->setCellValue('R'.$excel_i, util_helper_format_date($curdt))
                    ->setCellValue('S'.$excel_i, number_format($daysc,2,'.',','))
                    ->setCellValue('T'.$excel_i, number_format($accum,2,'.',','))
                    ->setCellValue('U'.$excel_i, $saknr2)
                    ->setCellValue('V'.$excel_i, number_format($books,2,'.',','));
                            
		}


		// Adjust header cell format
		foreach(range('A','V') as $columnID) {
		    $current_sheet->getColumnDimension($columnID)->setAutoSize(true);

			// add color to head
			$cell_style = $current_sheet->getStyle($columnID.'8');
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
		header('Content-Disposition: attachment;filename="asset_register_'.date('Y-m-d_H:i:s').'.xls"');
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