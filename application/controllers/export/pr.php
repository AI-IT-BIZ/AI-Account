<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pr extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->library('PHPExcel');
	}

	function index()
	{
		$this->db->set_dbprefix('v_');
		$tbName = 'ebko';

		// Start for report
		function createQuery($_this){

			$query = $_this->input->get('query');
			if(!empty($query)){
				$_this->db->where("(purnr LIKE '%$query%'
				OR lifnr LIKE '%$query%'
				OR name1 LIKE '%$query%'
				OR jobnr LIKE '%$query%'
				OR jobtx LIKE '%$query%')", NULL, FALSE);
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

            $purnr1 = $_this->input->get('purnr');
			$purnr2 = $_this->input->get('purnr2');
			if(!empty($purnr1) && empty($purnr2)){
			  $_this->db->where('purnr', $purnr1);
			}
			elseif(!empty($purnr1) && !empty($purnr2)){
			  $_this->db->where('purnr >=', $purnr1);
			  $_this->db->where('purnr <=', $purnr2);
			}

			$lifnr1 = $_this->input->get('lifnr');
			$lifnr2 = $_this->input->get('lifnr2');
			if(!empty($lifnr1) && empty($lifnr2)){
			  $_this->db->where('kunnr', $lifnr1);
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
			//Get PR by Userlogin Department Accept Accounting
			$uname = XUMS::USERNAME();
			$sql = "select t1.uname, t1.empnr, t2.name1, t2.depnr
					from tbl_user t1
					join tbl_empl t2 on t1.empnr=t2.empnr
					join tbl_depn t3 on t2.depnr=t3.depnr
					where t1.uname = '$uname'";
			$q_dep = $_this->db->query($sql);
            if($q_dep->num_rows()>0){
			  $r_dep = $q_dep->first_row('array');
			  $_this->db->where('depnr',$r_dep['depnr']);
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
									 ->setTitle("Purchase Requisition")
									 ->setSubject("Purchase Requisition")
									 ->setDescription("Purchase Requisition information.");

		$objPHPExcel->setActiveSheetIndex(0);
		$current_sheet = $objPHPExcel->getActiveSheet();

		// add header data
		$current_sheet
				->setCellValue('A1', 'PR No')
	            ->setCellValue('B1', 'PR Date')
				->setCellValue('C1', 'Due Date')
	            ->setCellValue('D1', 'Vendor No')
	            ->setCellValue('E1', 'Vendor Name')
	            ->setCellValue('F1', 'Status')
	            ->setCellValue('G1', 'Amount')
	            ->setCellValue('H1', 'Currency');

		// Add some data
		$result_array = $query->result_array();
		for($i=0;$i<count($result_array);$i++){
			$value = $result_array[$i];
			$excel_i = $i+2;
			$current_sheet
		            ->setCellValue('A'.$excel_i, $value['purnr'])
		            ->setCellValue('B'.$excel_i, util_helper_format_date($value['bldat']))
		            ->setCellValue('C'.$excel_i, $value['lfdat'])
		            ->setCellValue('D'.$excel_i, $value['lifnr'])
		            ->setCellValue('E'.$excel_i, $value['name1'])
		            ->setCellValue('F'.$excel_i, $value['statx'])
		            ->setCellValue('G'.$excel_i, number_format($value['netwr'],2,'.',','))
		            ->setCellValue('H'.$excel_i, $value['ctype']);	
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
		header('Content-Disposition: attachment;filename="purchase_requisition_'.date('Y-m-d_H:i:s').'.xls"');
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