<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rpayment extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->library('PHPExcel');
	}

	function index()
	{
		$this->db->set_dbprefix('v_');
		$tbName = 'ebbp';
		
		// Start for report
		$period='';$docno='';$status='';
		function createQuery($_this){
			$query = $_this->input->get('query');
			if(!empty($query)){
				$_this->db->where("(paynr LIKE '%$query%'
				OR lifnr LIKE '%$query%'
				OR name1 LIKE '%$query%'
				OR invnr LIKE '%$query%')", NULL, FALSE);
			}
			
			$bldat1 = $_this->input->get('bldat');
			$bldat2 = $_this->input->get('bldat2');
			if(!empty($bldat1) && empty($bldat2)){
			  $_this->db->where('bldat', $bldat1);
				$period=$bldat1;
			}
			elseif(!empty($bldat1) && !empty($bldat2)){
			  $_this->db->where('bldat >=', $bldat1);
			  $_this->db->where('bldat <=', $bldat2);
			  $period=$bldat1.' - '.$bldat2;
			}
			
            $payno1 = $_this->input->get('payno');
			$payno2 = $_this->input->get('payno2');
			if(!empty($payno1) && empty($payno2)){
			  $_this->db->where('payno', $payno1);
			  $docno=$payno1;
			}
			elseif(!empty($payno1) && !empty($payno2)){
			  $_this->db->where('payno >=', $payno1);
			  $_this->db->where('payno <=', $payno2);
			  $docno=$payno1.' - '.$payno2;
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
			  $status=$statu1;
			}
			elseif(!empty($statu1) && !empty($statu2)){
			  $_this->db->where('statu >=', $statu1);
			  $_this->db->where('statu <=', $statu2);
			}
		}
// End for report

		createQuery($this);
		//$sort = $this->input->get('sort');
		//$dir = $this->input->get('dir');
		//$this->db->order_by($sort, $dir);
		
		$query = $this->db->get($tbName);
        $result_array = $query->result_array();
		$start = $result_array[0]; 
		$irow=count($result_array);
		$irow=$irow-1;  
		$end = $result_array[$irow]; 
		if(empty($docno)) $docno=$start['payno'].' - '.$end['payno'];       
                /********************************************************/
                
		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();

		// Set document properties
		$objPHPExcel->getProperties()->setCreator("Prime BizNet")
									 ->setLastModifiedBy("Prime BizNet")
									 ->setTitle("Payment")
									 ->setSubject("Payment")
									 ->setDescription("Payment information.");
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
          
          $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D1:G1:')
                                             // ->mergeCells('H1:J1:')
                                              ->setCellValue('D1', 'Company Name : Bangkok Media Co.,Ltd');
          $objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($StyleHeadCompany);
          /*---------------------------------------------------------------*/
          $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D2:F2')
                                              ->setCellValue('D2', 'Purchase Payment Report');
          $objPHPExcel->getActiveSheet()->getStyle('D2')->applyFromArray($StyleHeadReportName);
          /*---------------------------------------------------------------*/
          $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:B4')
                                              ->setCellValue('A4', 'Selection Report No.');
          $objPHPExcel->getActiveSheet()->getStyle('A4')->applyFromArray($StyleHeadReportDetail);
          /*---------------------------------------------------------------*/
          $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A5:C5')
                                              ->setCellValue('A5', 'Selection Period : '.$period);
          $objPHPExcel->getActiveSheet()->getStyle('A5')->applyFromArray($StyleHeadReportDetail);
          /*---------------------------------------------------------------*/
          $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A6:D6')
                                              ->setCellValue('A6', 'Running by Payment Number : '.$docno);
          $objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($StyleHeadReportDetail);
          /*---------------------------------------------------------------*/
          //$objPHPExcel->setActiveSheetIndex(0)->mergeCells('H4:I4')
           //                                   ->setCellValue('H4', 'Page:');
           //$objPHPExcel->getActiveSheet()->getStyle('H4')->applyFromArray($StyleHeadReportDetail);
          /*---------------------------------------------------------------*/
           $objPHPExcel->setActiveSheetIndex(0)->mergeCells('G5:I5')
                                              ->setCellValue('G5', 'Document Status : '.$status);
           $objPHPExcel->getActiveSheet()->getStyle('G4')->applyFromArray($StyleHeadReportDetail);
          /*---------------------------------------------------------------*/
           $objPHPExcel->setActiveSheetIndex(0)->mergeCells('G6:I6')
                                              ->setCellValue('G6', 'Print Date : ' . date('d/m/Y H:i:s'));
           $objPHPExcel->getActiveSheet()->getStyle('G6')->applyFromArray($StyleHeadReportDetail);
          /*---------------------------------------------------------------*/
          /*******************************************************************/

		$objPHPExcel->setActiveSheetIndex(0);
		$current_sheet = $objPHPExcel->getActiveSheet();

		// add header data
		$current_sheet
	            ->setCellValue('A8', 'Payment No')
	            ->setCellValue('B8', 'Document Date')
	            ->setCellValue('C8', 'Vendor No')
	            ->setCellValue('D8', 'Vendor Name')
	            ->setCellValue('E8', 'Net Amount')
	            ->setCellValue('F8', 'Status')
				->setCellValue('G8', 'Paymented by')
	            ->setCellValue('H8', 'Invoice No')
	            ->setCellValue('I8', 'Invoice Date')
				->setCellValue('J8', 'Invoice Vat')
	            ->setCellValue('K8', 'Invoice WHT')
				->setCellValue('L8', 'Invoice Amount')
				
				->setCellValue('M8', 'Material Code')
                ->setCellValue('N8', 'Material Description')
                ->setCellValue('O8', 'Quantity')
                ->setCellValue('P8', 'Unit Price')

	            ->setCellValue('Q8', 'Amount');

		// Add some data
		$inv_temp='';$payment='';$inv2='';
		$result_array = $query->result_array();
		for($i=0;$i<count($result_array);$i++){
			$value = $result_array[$i];
			$excel_i = $i+9;
		    
					if($inv_temp == "" || $inv_temp != $value['payno'])   
                         {
                       $q_pm = $this->db->get_where('paym', array(
				       'recnr'=>$value['payno']
			           ));
			
			if($q_pm->num_rows()>0){
				$pay = $q_pm->result_array();
				$payment='';
				for($j=0;$j<count($pay);$j++){
		            $p = $pay[$j];
					if($j==0) $payment = $p['paytx'];
					else $payment = $payment.','.$p['paytx'];
			    }
			}  
                             $current_sheet      
		            ->setCellValue('A'.$excel_i, $value['payno'])
		            ->setCellValue('B'.$excel_i, util_helper_format_date($value['bldat']))
		            ->setCellValue('C'.$excel_i, $value['lifnr'])
		            ->setCellValue('D'.$excel_i, $value['name1'])
		            ->setCellValue('E'.$excel_i, number_format($value['netwr'],2,'.',','))
					->setCellValue('F'.$excel_i, $value['statx'])
		            ->setCellValue('G'.$excel_i, $payment);
   
                         }
                         else {
                               $current_sheet
		               ->setCellValue('A'.$excel_i, "")
		               ->setCellValue('B'.$excel_i, "")
		               ->setCellValue('C'.$excel_i, "")
		               ->setCellValue('D'.$excel_i, "")
		               ->setCellValue('E'.$excel_i, "")
					   ->setCellValue('F'.$excel_i, "")
		               ->setCellValue('G'.$excel_i, "");  
                             
                         }
			       //$total = $value['beamt'] + $value['vat01'];
					   
					   if($inv2 == "" || $inv2 != $value['invnr']){
					   	  $current_sheet     
                          ->setCellValue('H'.$excel_i, $value['invnr'])
		                  ->setCellValue('I'.$excel_i, util_helper_format_date($value['invdt']))
		              
					      ->setCellValue('J'.$excel_i, $value['vat01'])
		                  ->setCellValue('K'.$excel_i, $value['wht01'])
					      ->setCellValue('L'.$excel_i, number_format($value['itamt'], 2));
						  
					   }else{
					   	  $current_sheet
		                  ->setCellValue('H'.$excel_i, "")
		                  ->setCellValue('I'.$excel_i, "")
		                  ->setCellValue('J'.$excel_i, "")
		                  ->setCellValue('K'.$excel_i, "")
		                  ->setCellValue('L'.$excel_i, "");
					   }
					   
					   $current_sheet 
					      ->setCellValue('M'.$excel_i, $value['matnr'])
		                  ->setCellValue('N'.$excel_i, $value['maktx'])
		              
					      ->setCellValue('O'.$excel_i, number_format($value['menge'], 2))
						  ->setCellValue('P'.$excel_i, number_format($value['unitp'], 2))
					      ->setCellValue('Q'.$excel_i, number_format($value['Expr6'], 2));
						
						$inv2 = $value['invnr'];   
                        $inv_temp = $value['payno'];
		
		}


		// Adjust header cell format
		foreach(range('A','Q') as $columnID) {
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
		header('Content-Disposition: attachment;filename="payment_'.date('Y-m-d_H:i:s').'.xls"');
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