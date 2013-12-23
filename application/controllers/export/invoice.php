<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invoice extends CI_Controller {
      
     
      function __construct()
      {
		parent::__construct();

		$this->load->library('PHPExcel');
      }

      function index()
      {
          //sort=invnr&dir=ASC&query=&bldat=2013-12-21&statu=&bldat2=
            $sort = $_GET['sort'];
            $dir = $_GET['dir'];
            $query = $_GET['query'];
            $bldat = $_GET['bldat'];
            $statu = $_GET['statu'];
            $bldat2 = $_GET['bldat2'];
            $statu_tax = " All ";
            
            $date_select = $bldat . " - " . $bldat2;
            
            switch ($statu)
            {
                case "01": $statu_tax = "Waiting for Approval";
                       break;
                case "02": $statu_tax = "Approved";
                       break;
                case "03": $statu_tax = "Unapproved";
                       break;
                case "04": $statu_tax = "Revised";
                       break;
            }
            
            $sWhere = "";
            $sWhere2 = "";
            if($bldat != "")
            {
                 $sWhere = $sWhere . ($sWhere == "" ? " Where ( v_vbrk.bldat >= '" . $bldat . "' and v_vbrk.bldat <= '" . $bldat . "' ) " : " and ( v_vbrk.bldat >= '" . $bldat . "' and v_vbrk.bldat <= '" . $bldat . "' )" );
            }
            if($statu != "")
            {
                $sWhere = $sWhere . ($sWhere == "" ? " Where v_vbrk.statu = " . $statu : " And v_vbrk.statu = " . $statu  );
            }
            if($query != "")
            {
               $sWhere2 = "";
               $sWhere2 = $sWhere2 . "( v_vbrk.invnr like '%" . $query . "%' or v_vbrk.ordnr like '%" . $query . "%' or v_vbrk.name1 like '%" . $query . "%' )";
            }
            if($sWhere2 != "")
            {
                $sWhere = $sWhere . ($sWhere == "" ? " Where " . $sWhere2 : " And " . $sWhere2  );
            }
            
            $sSql = "Select v_vbrk.*,v_vbrp.* from v_vbrk ";
            $sSql = $sSql . " Left Join v_vbrp on v_vbrk.invnr = v_vbrp.invnr ";
            $sSql = $sSql . $sWhere;
            $sSql = $sSql . " order by v_vbrk.invnr  ";
            $query = $this->db->query($sSql);
            
            // Create new PHPExcel object
		$objPHPExcel = new PHPExcel();

		// Set document properties
		$objPHPExcel->getProperties()->setCreator("Prime BizNet")
									 ->setLastModifiedBy("Prime BizNet")
									 ->setTitle("Invoice")
									 ->setSubject("Invoice")
									 ->setDescription("Invoice information.");
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
          
          $objPHPExcel->setActiveSheetIndex(0)->mergeCells('G1:J1:')
                                             // ->mergeCells('H1:J1:')
                                              ->setCellValue('G1', 'Company Name :');
          $objPHPExcel->getActiveSheet()->getStyle('G1')->applyFromArray($StyleHeadCompany);
          /*---------------------------------------------------------------*/
          $objPHPExcel->setActiveSheetIndex(0)->mergeCells('G2:J2')
                                              ->setCellValue('G2', 'Sale Tax Invoice List Report');
          $objPHPExcel->getActiveSheet()->getStyle('G2')->applyFromArray($StyleHeadReportName);
          /*---------------------------------------------------------------*/
          $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:B4')
                                              ->setCellValue('A4', 'Selection Report No.');
          $objPHPExcel->getActiveSheet()->getStyle('A4')->applyFromArray($StyleHeadReportDetail);
          /*---------------------------------------------------------------*/
          $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A5:D5')
                                              ->setCellValue('A5', 'Selection Period : ' .$date_select);
          $objPHPExcel->getActiveSheet()->getStyle('A5')->applyFromArray($StyleHeadReportDetail);
          /*---------------------------------------------------------------*/
        //  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A6:C6')
         //                                     ->setCellValue('A6', 'Running by Sale Tax Invoind Number');
        //  $objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($StyleHeadReportDetail);
          /*---------------------------------------------------------------*/
          $objPHPExcel->setActiveSheetIndex(0)->mergeCells('O4:P4')
                                              ->setCellValue('O4', 'Page:(Auto)');
           $objPHPExcel->getActiveSheet()->getStyle('O4')->applyFromArray($StyleHeadReportDetail);
          /*---------------------------------------------------------------*/
           $objPHPExcel->setActiveSheetIndex(0)->mergeCells('O5:P5')
                                              ->setCellValue('O5', 'Document Status : ' . $statu_tax);
           $objPHPExcel->getActiveSheet()->getStyle('O5')->applyFromArray($StyleHeadReportDetail);
          /*---------------------------------------------------------------*/
           $objPHPExcel->setActiveSheetIndex(0)->mergeCells('O6:P6')
                                              ->setCellValue('O6', 'Print Date : ' . date('Y-m-d H:i:s'));
           $objPHPExcel->getActiveSheet()->getStyle('O6')->applyFromArray($StyleHeadReportDetail);
          /*---------------------------------------------------------------*/
          /*******************************************************************/

		$objPHPExcel->setActiveSheetIndex(0);
		$current_sheet = $objPHPExcel->getActiveSheet();

		// add header data
		$current_sheet
	              ->setCellValue('A8', 'Invoid No.')
                      ->setCellValue('B8', 'Invoid Date')
                      ->setCellValue('C8', 'Ref. Project No.')
                      ->setCellValue('D8', 'Ref. sale Order No.')
                      ->setCellValue('E8', 'Customer Name')
                      ->setCellValue('F8', 'Credit Term')
                      ->setCellValue('G8', 'Due Date')
                      ->setCellValue('H8', 'Over Due')
                      ->setCellValue('I8', 'Status')
                      ->setCellValue('J8', 'Material Code')
                      ->setCellValue('K8', 'Item Description')
                      ->setCellValue('L8', 'Quantity')
                      ->setCellValue('M8', 'Unit Price')
                      ->setCellValue('N8', 'Amount (Before Vat')
                      ->setCellValue('O8', 'Vat Amount(7%)')
                      ->setCellValue('P8', 'Amount Including Vat');
                

		// Add some data
                $invoid_temp = "";
		$result_array = $query->result_array();
		for($i=0;$i<count($result_array);$i++){
			$value = $result_array[$i];
			$excel_i = $i+9;
                         if($invoid_temp == "" || $invoid_temp != $value['invnr'])   
                         {
                             $current_sheet
                            
		            ->setCellValue('A'.$excel_i, $value['invnr'])
		            ->setCellValue('B'.$excel_i, util_helper_format_date($value['bldat']))
		            ->setCellValue('C'.$excel_i, '')
		            ->setCellValue('D'.$excel_i, $value['ordnr'])
		            ->setCellValue('E'.$excel_i, $value['name1'])
			    ->setCellValue('F'.$excel_i, $value['terms'])
		            ->setCellValue('G'.$excel_i, $value['duedt'])
                            ->setCellValue('H'.$excel_i, '')
		            ->setCellValue('I'.$excel_i, $value['statu']);   
                         }
                         else {
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
			    $total = $value['beamt'] + $value['vat01'];
                            $current_sheet     
                            ->setCellValue('J'.$excel_i, $value['matnr'])
                            ->setCellValue('K'.$excel_i, $value['maktx'])
                            ->setCellValue('L'.$excel_i, $value['menge'])
                            ->setCellValue('M'.$excel_i, $value['unitp'])
                            ->setCellValue('N'.$excel_i, $value['beamt'])
                            ->setCellValue('O'.$excel_i, $value['vat01'])
                            ->setCellValue('P'.$excel_i,  $total);
                            
                            $invoid_temp = $value['invnr'];
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
      
      function GetReportFromPageSelect()
      {
            
                $doc_start_from = $_GET["doc_start_from"];
                $doc_start_to = $_GET["doc_start_to"];
                $invoice_from = $_GET["invoice_from"];
                $invoice_to = $_GET["invoice_to"];
                $so_no_from = $_GET["so_no_from"];
                $so_no_to = $_GET["so_no_to"];
                $cus_code_from = $_GET["cus_code_from"];
                $cus_code_to = $_GET["cus_code_to"];
                $saleperson_from = $_GET["saleperson_from"];
                $saleperson_to = $_GET["saleperson_to"];
                $invoice_status = $_GET["invoice_status"];
            //    $xxx = $this->input->post('xxx');
                
                 $statu_tax = " All ";
                
                 
                 $date_select = $doc_start_from . " - " . $doc_start_to;
                 
                 switch ($invoice_status)
                 {
                   case "01": $statu_tax = "Waiting for Approval";
                       break;
                   case "02": $statu_tax = "Approved";
                       break;
                   case "03": $statu_tax = "Unapproved";
                       break;
                   case "04": $statu_tax = "Revised";
                       break;
                 }
                 $strInvoicNo = "";
                 if($invoice_from != "" && $invoice_to != ""  )
                 {
                    $strInvoicNo = "Running by Sale Tax Invoind Number : " . $invoice_from . " To " . $invoice_to;
                 }
                 
                 
            
                $sWhere = "";
                if($doc_start_from != "")
                {
                    $sWhere = $sWhere .($sWhere == "" ? " Where " : " And") . "  ( v_vbrk.bldat >= STR_TO_DATE('" . $doc_start_from . "','%d/%m/%Y') and  v_vbrk.bldat <= STR_TO_DATE('" . $doc_start_to . "','%d/%m/%Y') )";
                }
                if($invoice_from != "")
                {
                    $sWhere = $sWhere .($sWhere == "" ? " Where " : " And ") . " ( v_vbrk.invnr >= '" . $invoice_from . "' And v_vbrk.invnr <= '" . $invoice_to . "' ) " ;
                }
                 if($so_no_from != "")
                {
                    $sWhere = $sWhere .($sWhere == "" ? " Where " : " And ") . " ( v_vbrk.ordnr >= '" . $so_no_from . "' And v_vbrk.ordnr <= '" . $so_no_from . "' ) " ;
                }
                 if($cus_code_from != "")
                {
                    $sWhere = $sWhere .($sWhere == "" ? " Where " : " And ") . " ( v_vbrk.kunnr >= '" . $cus_code_from . "' And v_vbrk.kunnr <= '" . $cus_code_to . "' ) " ;
                }
                if($saleperson_from != "")
                {
                    $sWhere = $sWhere .($sWhere == "" ? " Where " : " And ") . " ( v_vbrk.salnr >= '" . $saleperson_from . "' And v_vbrk.salnr <= '" . $saleperson_to . "' ) " ;
                }
                if($invoice_status != "")
                {
                    $sWhere = $sWhere .($sWhere == "" ? " Where " : " And ") . " ( v_vbrk.statu = '" . $invoice_status . "' )" ;
                }
                
		$sSql = "Select distinct v_vbrk.*,v_vbrp.* from v_vbrk ";
                $sSql = $sSql . " Left Join v_vbrp on v_vbrk.invnr = v_vbrp.invnr ";
                $sSql = $sSql . $sWhere;
                $sSql = $sSql . " order by v_vbrk.invnr  "  ;
                $query = $this->db->query($sSql);
                
                
                /********************************************************/
                
                 // Create new PHPExcel object
		$objPHPExcel = new PHPExcel();

		// Set document properties
		$objPHPExcel->getProperties()->setCreator("Prime BizNet")
									 ->setLastModifiedBy("Prime BizNet")
									 ->setTitle("Invoice")
									 ->setSubject("Invoice")
									 ->setDescription("Invoice information.");
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
          
          $objPHPExcel->setActiveSheetIndex(0)->mergeCells('G1:J1:')
                                             // ->mergeCells('H1:J1:')
                                              ->setCellValue('G1', 'Company Name :');
          $objPHPExcel->getActiveSheet()->getStyle('G1')->applyFromArray($StyleHeadCompany);
          /*---------------------------------------------------------------*/
          $objPHPExcel->setActiveSheetIndex(0)->mergeCells('G2:J2')
                                              ->setCellValue('G2', 'Sale Tax Invoice List Report');
          $objPHPExcel->getActiveSheet()->getStyle('G2')->applyFromArray($StyleHeadReportName);
          /*---------------------------------------------------------------*/
          $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:B4')
                                              ->setCellValue('A4', 'Selection Report No.');
          $objPHPExcel->getActiveSheet()->getStyle('A4')->applyFromArray($StyleHeadReportDetail);
          /*---------------------------------------------------------------*/
          $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A5:D5')
                                              ->setCellValue('A5', 'Selection Period : ' .$date_select);
          $objPHPExcel->getActiveSheet()->getStyle('A5')->applyFromArray($StyleHeadReportDetail);
          /*---------------------------------------------------------------*/
          $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A6:E6')
                                              ->setCellValue('A6', $strInvoicNo);
          $objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($StyleHeadReportDetail);
          /*---------------------------------------------------------------*/
          $objPHPExcel->setActiveSheetIndex(0)->mergeCells('O4:P4')
                                              ->setCellValue('O4', 'Page:(Auto)');
           $objPHPExcel->getActiveSheet()->getStyle('O4')->applyFromArray($StyleHeadReportDetail);
          /*---------------------------------------------------------------*/
           $objPHPExcel->setActiveSheetIndex(0)->mergeCells('O5:P5')
                                              ->setCellValue('O5', 'Document Status : ' . $statu_tax);
           $objPHPExcel->getActiveSheet()->getStyle('O5')->applyFromArray($StyleHeadReportDetail);
          /*---------------------------------------------------------------*/
           $objPHPExcel->setActiveSheetIndex(0)->mergeCells('O6:P6')
                                              ->setCellValue('O6', 'Print Date : ' . date('Y-m-d H:i:s'));
           $objPHPExcel->getActiveSheet()->getStyle('O6')->applyFromArray($StyleHeadReportDetail);
          /*---------------------------------------------------------------*/
          /*******************************************************************/

		$objPHPExcel->setActiveSheetIndex(0);
		$current_sheet = $objPHPExcel->getActiveSheet();

		// add header data
		$current_sheet
	              ->setCellValue('A8', 'Invoid No.')
                      ->setCellValue('B8', 'Invoid Date')
                      ->setCellValue('C8', 'Ref. Project No.')
                      ->setCellValue('D8', 'Ref. sale Order No.')
                      ->setCellValue('E8', 'Customer Name')
                      ->setCellValue('F8', 'Credit Term')
                      ->setCellValue('G8', 'Due Date')
                      ->setCellValue('H8', 'Over Due')
                      ->setCellValue('I8', 'Status')
                      ->setCellValue('J8', 'Material Code')
                      ->setCellValue('K8', 'Item Description')
                      ->setCellValue('L8', 'Quantity')
                      ->setCellValue('M8', 'Unit Price')
                      ->setCellValue('N8', 'Amount (Before Vat')
                      ->setCellValue('O8', 'Vat Amount(7%)')
                      ->setCellValue('P8', 'Amount Including Vat');
                

		// Add some data
                $invoid_temp = "";
		$result_array = $query->result_array();
		for($i=0;$i<count($result_array);$i++){
			$value = $result_array[$i];
			$excel_i = $i+9;
                         if($invoid_temp == "" || $invoid_temp != $value['invnr'])   
                         {
                             $current_sheet
                            
		            ->setCellValue('A'.$excel_i, $value['invnr'])
		            ->setCellValue('B'.$excel_i, util_helper_format_date($value['bldat']))
		            ->setCellValue('C'.$excel_i, '')
		            ->setCellValue('D'.$excel_i, $value['ordnr'])
		            ->setCellValue('E'.$excel_i, $value['name1'])
			    ->setCellValue('F'.$excel_i, $value['terms'])
		            ->setCellValue('G'.$excel_i, $value['duedt'])
                            ->setCellValue('H'.$excel_i, '')
		            ->setCellValue('I'.$excel_i, $value['statu']);   
                         }
                         else {
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
			    $total = $value['beamt'] + $value['vat01'];
                            $current_sheet     
                            ->setCellValue('J'.$excel_i, $value['matnr'])
                            ->setCellValue('K'.$excel_i, $value['maktx'])
                            ->setCellValue('L'.$excel_i, $value['menge'])
                            ->setCellValue('M'.$excel_i, $value['unitp'])
                            ->setCellValue('N'.$excel_i, $value['beamt'])
                            ->setCellValue('O'.$excel_i, $value['vat01'])
                            ->setCellValue('P'.$excel_i,  $total);
                            
                            $invoid_temp = $value['invnr'];
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