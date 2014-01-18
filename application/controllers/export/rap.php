<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rap extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->library('PHPExcel');
	}

	function index()
	{
	    $this->db->set_dbprefix('v_');
		$tbName = 'ebrp';

		// Start for report
		$period='';$docno='';$status='';
		function createQuery($_this){
			$query = $_this->input->get('query');
			if(!empty($query)){
				$_this->db->where("(invnr LIKE '%$query%'
				OR lifnr LIKE '%$query%'
				OR name1 LIKE '%$query%'
				OR mbeln LIKE '%$query%')", NULL, FALSE);
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
			
            $mbeln1 = $_this->input->get('mbeln');
			$mbeln2 = $_this->input->get('mbeln2');
			if(!empty($mbeln1) && empty($mbeln2)){
			  $_this->db->where('mbeln', $mbeln1);
			}
			elseif(!empty($mbeln1) && !empty($mbeln2)){
			  $_this->db->where('mbeln >=', $mbeln1);
			  $_this->db->where('mbeln <=', $mbeln2);
			}

            $invnr1 = $_this->input->get('invnr');
			$invnr2 = $_this->input->get('invnr2');
			if(!empty($invnr1) && empty($invnr2)){
			  $_this->db->where('invnr', $invnr1);
				$docno=$invnr1;
			}
			elseif(!empty($invnr1) && !empty($invnr2)){
			  $_this->db->where('invnr >=', $invnr1);
			  $_this->db->where('invnr <=', $invnr2);
			  $docno=$invnr1.' - '.$invnr2;
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
		if(empty($docno)) $docno=$start['invnr'].' - '.$end['invnr']; 
		/********************************************************/

		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();

		// Set document properties
		$objPHPExcel->getProperties()->setCreator("Prime BizNet")
									 ->setLastModifiedBy("Prime BizNet")
									 ->setTitle("Account Payable")
									 ->setSubject("Account Payable")
									 ->setDescription("Account Payable information.");
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
          
          $objPHPExcel->setActiveSheetIndex(0)->mergeCells('G1:K1:')
                                             // ->mergeCells('H1:J1:')
                                              ->setCellValue('G1', 'Company Name : Bangkok Media Co.,Ltd');
          $objPHPExcel->getActiveSheet()->getStyle('G1')->applyFromArray($StyleHeadCompany);
          /*---------------------------------------------------------------*/
          $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H2:I2')
                                              ->setCellValue('H2', 'Account Payable Report');
          $objPHPExcel->getActiveSheet()->getStyle('H2')->applyFromArray($StyleHeadReportName);
          /*---------------------------------------------------------------*/
          $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:B4')
                                              ->setCellValue('A4', 'Selection Report No.');
          $objPHPExcel->getActiveSheet()->getStyle('A4')->applyFromArray($StyleHeadReportDetail);
          /*---------------------------------------------------------------*/
          $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A5:C5')
                                              ->setCellValue('A5', 'Selection Period : '.$period);
          $objPHPExcel->getActiveSheet()->getStyle('A5')->applyFromArray($StyleHeadReportDetail);
          /*---------------------------------------------------------------*/
          $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A6:C6')
                                              ->setCellValue('A6', 'Running by Account Payable Number : '.$docno);
          $objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($StyleHeadReportDetail);
          /*---------------------------------------------------------------*/
          //$objPHPExcel->setActiveSheetIndex(0)->mergeCells('O4:P4')
          //                                    ->setCellValue('O4', 'Page:');
          //$objPHPExcel->getActiveSheet()->getStyle('O4')->applyFromArray($StyleHeadReportDetail);
          /*---------------------------------------------------------------*/
           $objPHPExcel->setActiveSheetIndex(0)->mergeCells('O5:P5')
                                              ->setCellValue('O5', 'Document Status : '.$status);
           $objPHPExcel->getActiveSheet()->getStyle('O5')->applyFromArray($StyleHeadReportDetail);
          /*---------------------------------------------------------------*/
           $objPHPExcel->setActiveSheetIndex(0)->mergeCells('O6:P6')
                                              ->setCellValue('O6', 'Print Date : ' . date('d/m/Y H:i:s'));
           $objPHPExcel->getActiveSheet()->getStyle('O6')->applyFromArray($StyleHeadReportDetail);
          /*---------------------------------------------------------------*/
          /*******************************************************************/

		$objPHPExcel->setActiveSheetIndex(0);
		$current_sheet = $objPHPExcel->getActiveSheet();

		// add header data
		$current_sheet
	                  ->setCellValue('A8', 'AP No.')
                      ->setCellValue('B8', 'AP Date')
                      //->setCellValue('C7', 'Ref. Project No.')
                      ->setCellValue('C8', 'Ref. PO No.')
					  ->setCellValue('D8', 'Vendor Code')
                      ->setCellValue('E8', 'Vendor Name')
                      ->setCellValue('F8', 'Credit Term')
                      ->setCellValue('G8', 'Due Date')
                      ->setCellValue('H8', 'Over Due')
                      ->setCellValue('I8', 'Status')
                      ->setCellValue('J8', 'Material Code')
                      ->setCellValue('K8', 'Material Description')
                      ->setCellValue('L8', 'Quantity')
                      ->setCellValue('M8', 'Unit Price')
                      ->setCellValue('N8', 'Amount (Before Vat')
                      ->setCellValue('O8', 'Vat Amount(7%)')
                      ->setCellValue('P8', 'Amount Including Vat');

		// Add some data
		$inv_temp = '';$ebeln='';$my_date='';$overd='';
		$result_array = $query->result_array();
		for($i=0;$i<count($result_array);$i++){
			$value = $result_array[$i];
			$excel_i = $i+9;
			//$current_sheet
		            		            
					if($inv_temp == "" || $inv_temp != $value['invnr'])   
                    {
                    
					$q_gr = $this->db->get_where('mkpf', array(
				    'mbeln'=>$value['mbeln']
			        ));
			
			        $result_data = $q_gr->first_row('array');
			        $ebeln = $result_data['ebeln'];
			
			        //$terms='+'.$res[$i]['terms']." days";
			        $my_date = util_helper_get_time_by_date_string($value['duedt']);
			
			        $time_diff = time() - $my_date;
			        $day = ceil($time_diff/(24 * 60 * 60));
            
			        if($day>0){
				       $overd = $day;
			        }else{ $overd = 0; }
					         	
                    $current_sheet
		            ->setCellValue('A'.$excel_i, $value['invnr'])
		            ->setCellValue('B'.$excel_i, util_helper_format_date($value['bldat']))
		            ->setCellValue('C'.$excel_i, $ebeln)
					->setCellValue('D'.$excel_i, $value['lifnr'])
		            ->setCellValue('E'.$excel_i, $value['name1'])
		            ->setCellValue('F'.$excel_i, $value['terms'])
					->setCellValue('G'.$excel_i, util_helper_format_date($value['duedt']))
		            ->setCellValue('H'.$excel_i, $overd)
		            ->setCellValue('I'.$excel_i, $value['statx']);  
                    }else {
                        $current_sheet
		               ->setCellValue('A'.$excel_i, "")
		               ->setCellValue('B'.$excel_i, "")
		               ->setCellValue('C'.$excel_i, "")
		               ->setCellValue('D'.$excel_i, "")
		               ->setCellValue('E'.$excel_i, "")
					   ->setCellValue('F'.$excel_i, "")
		               ->setCellValue('G'.$excel_i, "")
		               ->setCellValue('H'.$excel_i, "")
					   ->setCellValue('I'.$excel_i, ""); 
                         }
			       //$total = $value['beamt'] + $value['vat01'];
                       $current_sheet     
                       ->setCellValue('J'.$excel_i, $value['matnr'])
		               ->setCellValue('K'.$excel_i, $value['maktx'])
					   ->setCellValue('L'.$excel_i, preg_replace('/(\.00)$/' ,'',$value['menge'], 2))
		               ->setCellValue('M'.$excel_i, preg_replace('/(\.00)$/' ,'',$value['unitp'], 2))
					   ->setCellValue('N'.$excel_i, preg_replace('/(\.00)$/' ,'',$value['beamt'], 2))
		               ->setCellValue('O'.$excel_i, preg_replace('/(\.00)$/' ,'',$value['vat01'], 2)) 
		               ->setCellValue('P'.$excel_i, preg_replace('/(\.00)$/' ,'',$value['netwr'], 2)); 
                            
                        $inv_temp = $value['invnr'];
		
		}


		// Adjust header cell format
		foreach(range('A','P') as $columnID) {
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
		header('Content-Disposition: attachment;filename="account_payable_'.date('Y-m-d_H:i:s').'.xls"');
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