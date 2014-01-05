<?php
class Rgeneralledger extends CI_Controller {

	function __construct(){
		parent::__construct();
	}
	
	public function result(){
		$search = "";
		if($_POST["start_saknr"] != "" and $_POST["end_saknr"] != ""){
			$search = " where tbl_glno.saknr between '{$_POST["start_saknr"]}' and '{$_POST["end_saknr"]}' ";
		}
		$datas['datas']  = array();		
		$sql = "
				select
					 tbl_glno.saknr,
					 tbl_glno.sgtxt,
					 tbl_glno.glcre
				from
					tbl_glno
				{$search}
				order by
					tbl_glno.saknr
				limit 100;";
		
		
		$acc_code = $this->db->query($sql);
		$acc_code = $acc_code->result_array();
		$idx = 0;
		for($i=0;$i<count($acc_code);$i++){
			$idx++;
			$val = $acc_code[$i];
			$sql = "
				select 
					sum(v_uacc.debit) as debit,
					sum(v_uacc.credi) as credi
					
				from 
					v_bkpf
					LEFT JOIN v_uacc on v_uacc.belnr = v_bkpf.belnr
					LEFT JOIN tbl_glno on v_uacc.saknr = tbl_glno.saknr
				where 
					v_bkpf.bldat < '{$_POST['start_date']}' and
					v_uacc.saknr = '{$val['saknr']}'
			";
			$bf = $this->db->query($sql);
			$bf = $bf->first_row('array');
			$tmp1_ = (floatval($bf["debit"]) > floatval($bf["credi"]))? floatval($bf["debit"])*floatval($val["glcre"])*(-1) : '';
			$tmp2_ = (floatval($bf["debit"]) < floatval($bf["credi"]))? floatval($bf["credi"])*floatval($val["glcre"]) : '';
			$tmp3_ = (floatval($bf["debit"]) > floatval($bf["credi"]))? floatval($bf["debit"])*floatval($val["glcre"])*(-1) : floatval($bf["credi"])*floatval($val["glcre"]);
			$datas['datas'][$idx-1] = array(
				'',
				'',
				'',
				'',
				'B/F', 
				"{$tmp1_}",
				"{$tmp2_}",
				'',
				"{$val['saknr']}",
				"{$val['sgtxt']}",				 
				"{$tmp3_}",
			);
			
			$sql = "
				select 
					ifnull(v_bkpf.bldat,'') as bldat,
					ifnull(v_bkpf.belnr,'') as belnr,
					ifnull(v_bkpf.invnr,'') as invnr,
					ifnull(v_bkpf.name1,'') as name1,
					ifnull(v_uacc.saknr,'') as saknr,
					ifnull(tbl_glno.sgtxt,'') as sgtxt,
					ifnull(v_uacc.debit,'') as debit,
					ifnull(v_uacc.credi,'') as credi,
					ifnull(v_uacc.statu,'') as statu,
					ifnull(v_bkpf.kunnr,'') as kunnr,
					ifnull(v_bkpf.txz01,'') as txz01,
					tbl_glno.glcre
				from 
					v_bkpf
					LEFT JOIN v_uacc on v_uacc.belnr = v_bkpf.belnr
					LEFT JOIN tbl_glno on v_uacc.saknr = tbl_glno.saknr
				where 
					v_bkpf.bldat BETWEEN '{$_POST['start_date']}' and '{$_POST['end_date']}' and
					v_uacc.saknr = '{$val['saknr']}'
				order by v_bkpf.bldat
			";
			$rs = $this->db->query($sql);
			$rs = $rs->result_array();
			
			for($j=0;$j<count($rs);$j++){
				$val2 = $rs[$j];
				$idx++;
				if(floatval($val2['credi']) == 0 and floatval($val2['debit']) != 0){
					$tmp_n = floatval($val2['debit'])*floatval($val2['glcre'])*-1 + floatval($datas['datas'][$idx-2][10]);
				}
				if(floatval($val2['credi']) != 0 and floatval($val2['debit']) == 0){
					$tmp_n = floatval($val2['credi'])*floatval($val2['glcre']) + floatval($datas['datas'][$idx-2][10]);
				}
				if(floatval($val2['credi']) != 0 and floatval($val2['debit']) != 0){
					$tmp_n = floatval($val2['debit']) - floatval($val2['credi']) + floatval($datas['datas'][$idx-2][10]);
				}
				
				$tmp_debit = $val2['debit'];
				$tmp_credi = $val2['credi'];
				$datas['datas'][$idx-1] = array(
					"{$val2['bldat']}",
					"{$val2['belnr']}",
					"{$val2['kunnr']}",
					"{$val2['name1']}",
					"{$val2['txz01']}",
					"{$tmp_debit}",
					"{$tmp_credi}",
					"{$val2['statu']}",
					"{$val['saknr']}",
					"{$val['sgtxt']}",							 
					$tmp_n
				);
			}
		}
		$datas['success'] = true;		
		echo json_encode($datas);
	}
	
	public function excel(){
		$data_tmp = array();
		$this->load->library('PHPExcel');
		$sd = util_helper_format_date($_GET['start_date']);
		$ed = util_helper_format_date($_GET['end_date']);
		$sql = "select name1 from tbl_comp where comid 	= 1000";
		$comp = $this->db->query($sql);
		$comp = $comp->first_row('array');
		
		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();
		// Set document properties
		$objPHPExcel->getProperties()->setCreator("Prime BizNet")
									 ->setLastModifiedBy("Prime BizNet")
									 ->setTitle("General Ledger")
									 ->setSubject("General Ledger")
									 ->setDescription("General Ledger information.");
									 
									 
        /*Font Style*****************************************************/
        $StyleHeadCompany = array(
			'font'  => array(
				'bold'  => true,
				'color' => array('rgb' => 'FF0000'),
				'size'  => 15,
				'name'  => 'Verdana'
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
			)
		);
		
		$StyleHeadReportName = array(
			'font'  => array(
				'bold'  => true,
				'color' => array('rgb' => '1C1C1C'),
				'size'  => 12,
				'name'  => 'Verdana'
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
			)
		);
            
        $StyleHeadReportDetail = array(
			'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => '1C1C1C'),
			'size'  => 10,
			'name'  => 'Verdana'
		));
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:I1')->setCellValue('A1', 'Company Name : '.$comp['name1']);
		$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($StyleHeadCompany);
		
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:I2')->setCellValue('A2', 'General Ledger (GL)');
        $objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($StyleHeadReportName);
		
		/*-----------------------------------------------------------------------------------------*/
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:B4')->setCellValue('A4', 'Running by Chart of Account');
        $objPHPExcel->getActiveSheet()->getStyle('A4')->applyFromArray($StyleHeadReportDetail);
		
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A5:B5')->setCellValue('A5', 'Selection Report No.');
        $objPHPExcel->getActiveSheet()->getStyle('A5')->applyFromArray($StyleHeadReportDetail);
		
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A6:B6')->setCellValue('A6', 'Selection Period');
        $objPHPExcel->getActiveSheet()->getStyle('A6')->applyFromArray($StyleHeadReportDetail);
		
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('C6:D6')->setCellValue('C6', $sd.'-'.$ed);
        $objPHPExcel->getActiveSheet()->getStyle('C6')->applyFromArray($StyleHeadReportDetail);
		
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A7:B7')->setCellValue('A7', 'Selection Accounting Code Number');
        $objPHPExcel->getActiveSheet()->getStyle('A7')->applyFromArray($StyleHeadReportDetail);
		
		
		
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('F4:G4')->setCellValue('F4', 'Print Date:');
        $objPHPExcel->getActiveSheet()->getStyle('F4')->applyFromArray($StyleHeadReportDetail);		
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('H4:I4')->setCellValue('H4', date("d/m/Y H:i:s"));
        $objPHPExcel->getActiveSheet()->getStyle('H4')->applyFromArray($StyleHeadReportDetail);
		
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('F5:G5')->setCellValue('F5', 'Page:');
        $objPHPExcel->getActiveSheet()->getStyle('F5')->applyFromArray($StyleHeadReportDetail);
		
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('H6:I6')->setCellValue('H6', 'Document Status:');
        $objPHPExcel->getActiveSheet()->getStyle('H6')->applyFromArray($StyleHeadReportDetail);
		
		/*----------------------------------------------------------------------------------------*/
		
		
		$objPHPExcel->setActiveSheetIndex(0);
		$current_sheet = $objPHPExcel->getActiveSheet();
		$current_sheet
	              ->setCellValue('A9', 'Date')
                      ->setCellValue('B9', 'Document Number')
                      ->setCellValue('C9', 'Customer/ Supplier Code')
                      ->setCellValue('D9', 'Customer/ Supplier Name')
                      ->setCellValue('E9', 'Description')
                      ->setCellValue('F9', 'Debit (A)')
                      ->setCellValue('G9', 'Credit (B)')
                      ->setCellValue('H9', 'Balance (C) = (C(-1)+A-B)')
                      ->setCellValue('I9', 'Status');
					  
		$search = "";
		if($_GET["start_saknr"] != "" and $_GET["end_saknr"] != ""){
			$search = " where tbl_glno.saknr between '{$_GET["start_saknr"]}' and '{$_GET["end_saknr"]}' ";
		}
		
		$sql = "
				select
					tbl_glno.saknr,
					tbl_glno.sgtxt,
					tbl_glno.glcre
				from
					tbl_glno
				{$search}
				order by
					tbl_glno.saknr
				limit 100;";
		
		$data = $this->db->query($sql);
		$data = $data->result_array();
		$row_idx = 9;
		$debit = array();
		$credit = array();
		$balance = array();
		$didx = 0;
		for($i=0;$i<count($data);$i++){
			$val = $data[$i];
			$row_idx = $row_idx + 2;
			
			$current_sheet->setCellValue("A{$row_idx}", 'Account Code:');
			$current_sheet->setCellValue("B{$row_idx}", $val["saknr"]);
			
			$current_sheet->setCellValue("C{$row_idx}", 'Account Name');
			$current_sheet->setCellValue("D{$row_idx}", $val["sgtxt"]);
	
			$current_sheet->getStyle("A{$row_idx}")->applyFromArray(array(
				'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'DAEEF3'))
			));
			
			$sql = "
				select 
					sum(v_uacc.debit) as debit,
					sum(v_uacc.credi) as credi
					
				from 
					v_bkpf
					LEFT JOIN v_uacc on v_uacc.belnr = v_bkpf.belnr
					LEFT JOIN tbl_glno on v_uacc.saknr = tbl_glno.saknr
				where 
					v_bkpf.bldat < '{$_GET['start_date']}' and
					v_uacc.saknr = '{$val['saknr']}'
			";
			$bf = $this->db->query($sql);
			$bf = $bf->first_row('array');
			$row_idx = $row_idx + 1;
			
			$data_tmp[] =(floatval($bf["debit"]) > floatval($bf["credi"]))? floatval($bf["debit"])*floatval($val["glcre"])*(-1) : floatval($bf["credi"])*floatval($val["glcre"]);
			$didx = $didx + 1;
			
			$current_sheet
                      ->setCellValue("E{$row_idx}", 'B/F')
                      ->setCellValue("F{$row_idx}", (floatval($bf["debit"]) > floatval($bf["credi"]))? floatval($bf["debit"])*floatval($val["glcre"])*(-1) : '')
                      ->setCellValue("G{$row_idx}", (floatval($bf["debit"]) < floatval($bf["credi"]))? floatval($bf["credi"])*floatval($val["glcre"]) : '')
                      ->setCellValue("H{$row_idx}", (floatval($bf["debit"]) > floatval($bf["credi"]))? floatval($bf["debit"])*floatval($val["glcre"])*(-1) : floatval($bf["credi"])*floatval($val["glcre"]) );
									
			$sql = "
				select 
					ifnull(v_bkpf.bldat,'') as bldat,
					ifnull(v_bkpf.belnr,'') as belnr,
					ifnull(v_bkpf.invnr,'') as invnr,
					ifnull(v_bkpf.name1,'') as name1,
					ifnull(v_uacc.saknr,'') as saknr,
					ifnull(tbl_glno.sgtxt,'') as sgtxt,
					ifnull(v_uacc.debit,'') as debit,
					ifnull(v_uacc.credi,'') as credi,
					ifnull(v_uacc.statu,'') as statu,
					ifnull(v_bkpf.kunnr,'') as kunnr,
					ifnull(v_bkpf.txz01,'') as txz01,
					tbl_glno.glcre
				from 
					v_bkpf
					LEFT JOIN v_uacc on v_uacc.belnr = v_bkpf.belnr
					LEFT JOIN tbl_glno on v_uacc.saknr = tbl_glno.saknr
				where 
					v_bkpf.bldat BETWEEN '{$_GET['start_date']}' and '{$_GET['end_date']}' and
					v_uacc.saknr = '{$val['saknr']}'
				order by v_bkpf.bldat
			";
			$rs = $this->db->query($sql);
			$rs = $rs->result_array();
			$start_idx = $row_idx;
			$end_idx = $row_idx;
			for($j=0;$j<count($rs);$j++){
				$row_idx = $row_idx + 1;
				$end_idx = $row_idx;
				$r = $rs[$j];
				$tmp_idx = $row_idx-1;
				
				
				
				if(floatval($r['credi']) == 0 and floatval($r['debit']) != 0){
					$tmp_n = floatval($r['debit'])*floatval($r['glcre'])*-1 + floatval($data_tmp[$didx-1]);
				}
				if(floatval($r['credi']) != 0 and floatval($r['debit']) == 0){
					$tmp_n = floatval($r['credi'])*floatval($r['glcre']) + floatval($data_tmp[$didx-1]);
				}
				if(floatval($r['credi']) != 0 and floatval($r['debit']) != 0){
					$tmp_n = floatval($r['debit']) - floatval($r['credi']) + floatval($data_tmp[$didx-1]);
				}
				
				$data_tmp[] = $tmp_n;	
				$didx = $didx + 1;
				
				$current_sheet
	              ->setCellValue("A{$row_idx}", util_helper_format_date($r["bldat"]))
                      ->setCellValue("B{$row_idx}", $r['belnr'])
                      ->setCellValue("C{$row_idx}", $r['kunnr'])
                      ->setCellValue("D{$row_idx}", $r['name1'])
                      ->setCellValue("E{$row_idx}", $r['txz01'])
                      ->setCellValue("F{$row_idx}", $r['debit'])
                      ->setCellValue("G{$row_idx}", $r['credi'])
                      ->setCellValue("H{$row_idx}", $tmp_n)
                      ->setCellValue("I{$row_idx}", $r['statu']);
					  
					  
				if (count($rs)-1 == $j ){
					$row_idx = $row_idx + 2;
					$current_sheet->setCellValue("A{$row_idx}", 'Total:');
					$current_sheet->setCellValue("B{$row_idx}", $val["saknr"]);
					$current_sheet->setCellValue("C{$row_idx}", 'Account Name');
					$current_sheet->setCellValue("D{$row_idx}", $val["sgtxt"]);
					$current_sheet->setCellValue("E{$row_idx}", "Balance");
					$current_sheet->setCellValue("F{$row_idx}", "=SUM(F{$start_idx}:F{$end_idx})");
					$current_sheet->setCellValue("G{$row_idx}", "=SUM(G{$start_idx}:G{$end_idx})");
					$current_sheet->setCellValue("H{$row_idx}", "=SUM(H{$start_idx}:H{$end_idx})");
					$current_sheet->setCellValue("I{$row_idx}","E/F");
					
					$debit[] = "F{$row_idx}";
					$credit[] = "G{$row_idx}";
					$balance[] = "H{$row_idx}";
					
					$current_sheet->getStyle("A{$row_idx}")->applyFromArray(array(
						'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'A6A6A6'))
					));				
				}
				
			}
		
			
		}
		
		$debit = "=".join("+",$debit);
		$credit = "=".join("+",$credit);
		$balance = "=".join("+",$balance);
		
		$row_idx = $row_idx + 2;
		$current_sheet->setCellValue("A{$row_idx}", 'Grand Total:');
		$current_sheet->setCellValue("E{$row_idx}", "Balance");
		$current_sheet->setCellValue("F{$row_idx}", $debit);
		$current_sheet->setCellValue("G{$row_idx}", $credit);
		$current_sheet->setCellValue("H{$row_idx}", $balance);
		$current_sheet->setCellValue("I{$row_idx}","E/F");
		
		
		
		
		foreach(range('A','I') as $columnID) {
			$current_sheet->getColumnDimension($columnID)->setAutoSize(true);
			// add color to head
			$cell_style = $current_sheet->getStyle($columnID.'9');
			$cell_style->applyFromArray(
				array(
					'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'color' => array('rgb' => 'DAEEF3')
					),
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
					),
					'font' => array(
						'bold' => true
					)
				)
			);
			

		}
		
		$objPHPExcel->setActiveSheetIndex(0);
		 
		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="generalledger_'.date('Y-m-d_H:i:s').'.xls"');
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