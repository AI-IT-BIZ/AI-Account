<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Salary extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->library('PHPExcel');
		$this->load->model('code_model','',TRUE);
	}

	function read()
	{
		function check_duplicate($array, $field){
			for($i=0;$i<count($array);$i++){
				$code1 = $array[$i][$field];
				for($j=$i;$j<count($array);$j++){
					$code2 = $array[$j][$field];
					if($i!=$j && $code1==$code2){
						array_push($array[$i]['error'] ,'Code is exist');
						break;
					}
				}
			}
			return $array;
		}
		function check_exist_pk($array_master, $array_import, $field, $error_message){
			for($i=0;$i<count($array_import);$i++){
				$code1 = $array_import[$i][$field];
				$exist = false;
				for($j=0;$j<count($array_master);$j++){
					$code2 = $array_master[$j][$field];
					if($code1==$code2){
						$exist = true;
						break;
					}
				}
				if($exist)
					array_push($array_import[$i]['error'] ,$error_message);
			}
			return $array_import;
		}
		function check_exist($array_master, $array_import, $field, $error_message){
			for($i=0;$i<count($array_import);$i++){
				$code1 = $array_import[$i][$field];
				$exist = false;
				for($j=0;$j<count($array_master);$j++){
					$code2 = $array_master[$j][$field];
					if($code1==$code2){
						$exist = true;
						break;
					}
				}
				if(!$exist)
					array_push($array_import[$i]['error'] ,$error_message);
			}
			return $array_import;
		}
		function check_exist2($array_master, $array_import, $field_master, $field_import, $error_message){
			for($i=0;$i<count($array_import);$i++){
				$code1 = $array_import[$i][$field_import];
				$exist = false;
				for($j=0;$j<count($array_master);$j++){
					$code2 = $array_master[$j][$field_master];
					if($code1==$code2){
						$exist = true;
						break;
					}
				}
				if(!$exist)
					array_push($array_import[$i]['error'], $error_message);
			}
			return $array_import;
		}

		$upload_file = $this->input->get('file');
		$exel_file = FCPATH.'fileuploads/'.$upload_file;//FCPATH.'fileuploads/excelfile.xlsx';

		$result = array();

		$columns = array(
			0=>'empnr',
			1=>'name1',
			2=>'glcod',
			3=>'salar',
			4=>'socia',
			5=>'cosoc',
			6=>'withh',
			7=>'netpa',
			8=>'glban'
		);

		$objReader = PHPExcel_IOFactory::createReaderForFile($exel_file);
		$objReader->setReadDataOnly(true);
		$objPHPExcel = $objReader->load($exel_file);

		for($sh=0;$sh<$objPHPExcel->getSheetCount();$sh++){
			$objSheet = $objPHPExcel->getSheet($sh);

			$highestRow = $objSheet->getHighestRow();

			for ($row = 1; $row <= $highestRow; ++$row) {
				if($row==1) continue;

				$item = array();
				foreach($columns as $key=>$value){
					$item[$value] = $objSheet->getCellByColumnAndRow($key, $row)->getValue();
				}

				$item['row_id'] = $row;
				$item['error'] = array();
				array_push($result, $item);
			}
		}
		
		//print_r($result);
		
		// check duplicate code
		$result = check_duplicate($result, 'empnr');

		
		// check valid employee code
		$employee = array();
		foreach($result AS $value){
			array_push($employee, $value['empnr']);
		}
		$this->db->select('empnr');
		$this->db->where_in('empnr', $employee);
		$query = $this->db->get('empl');
		$valid_employee = $query->result_array();
		$result = check_exist($valid_employee, $result, 'empnr', 'Employee Code is not exist');

		
		// check valid GL Code
		$glcode = array();
		foreach($result AS $value){
			array_push($glcode, $value['glcod']);
		}
		$this->db->select('saknr');
		$this->db->where_in('saknr', $glcode);
		$query = $this->db->get('glno');
		$valid_glcode = $query->result_array();
		$result = check_exist2($valid_glcode, $result, 'saknr', 'glcod', 'GL Code is not exist');
		
		
		// check valid GL Code Bank
		$gl_bank = array();
		foreach($result AS $value){
			array_push($gl_bank, $value['glban']);
		}
		$this->db->select('saknr');
		$this->db->where_in('saknr', $gl_bank);
		$query = $this->db->get('glno');
		$valid_gl_bank = $query->result_array();
		$result = check_exist2($valid_gl_bank, $result, 'saknr', 'glban', 'GL Code Bank is not exist');

		// finish data
		for($i=0;$i<count($result);$i++){
			$result[$i]['error'] = implode(',', $result[$i]['error']);
		}

		//print_r($valid_projects);
		

		echo json_encode(array(
			'success'=>TRUE,
			'rows'=>$result,
			'totalCount'=>count($result)
		));
	}

	function import(){
		$datas = $this->input->post('data');
		$data_obj = json_decode($datas);
		$sum_social = 0;
		$sum_withh = 0;
		$sum_socialco = 0;
		$withh = 0;
		$social = 0;
		$socialco = 0;
		$current_user = XUMS::USERNAME();
		$date = date('Ymd');
		$form_data = array();
		$item_data = array();
		
		//Prepare Form Data
		foreach($data_obj AS $data){
			if(empty($data->error) || $data->error==''){
				array_push($form_data, array(
					'belnr'=>"",//$this->code_model->generate('JV',$date),
					'gjahr' => substr($date,0,4),
					'bldat'=>$date,
					'ernam'=>$current_user,
					'erdat'=>$date,
					'txz01'=>"จ่ายเงินเดือนให้กับพนักงาน ".+$data->empnr,
					'refnr'=>$data->empnr,
					'auart'=>"JV",
					'netwr'=>$data->salar
				));
				$withh = $data->withh;
				$sum_withh += $withh;
				$social = $data->socia;
				$sum_social += $social;
				$socialco = $data->cosoc;
				$sum_socialco += $socialco;
			}
		}		
		//Prepare Item Data
		foreach($data_obj AS $data){
			if(empty($data->error) || $data->error==''){
				array_push($item_data, array(
					'socia'=>$data->socia,
					'cosoc'=>$data->cosoc,
					'withh'=>$data->withh,
					'netpa'=>$data->netpa,
					'glcod'=>$data->glcod,
					'glban'=>$data->glban
				));
			}
		}
		
		//echo $this->code_model->generate('JV',$date);
		//return;
		
		if(count($form_data)>0){
			for($i=0;$i<count($form_data);$i++){
				
				//Save Journal Header Salary
				$id = $this->code_model->generate('JV',$date);
				$form_data[$i]['belnr'] = $id;
				$this->db->insert('bkpf', $form_data[$i]);
		
				//Save Journal Item				
				$array_item1 = array(	//Debit เงินเดือนพนักงาน
					'belnr'=>$id,
					'gjahr'=>$form_data[$i]['gjahr'],
					'belpr'=>1,
					'bldat'=>$date,
					'ernam'=>$current_user,
					'erdat'=>$date,
					'txz01'=>'เงินเดือนพนักงาน',
					'saknr'=>$item_data[$i]['glcod'],
					'debit'=>$form_data[$i]['netwr'],
					'credi'=>'0'
				);								
				$array_item2 = array(	//Credit Withholding Tax
					'belnr'=>$id,
					'gjahr'=>$form_data[$i]['gjahr'],
					'belpr'=>2,
					'bldat'=>$date,
					'ernam'=>$current_user,
					'erdat'=>$date,
					'txz01'=>'ภาษีหัก ณ ที่จ่าย ภงด 1',
					'saknr'=>'2132-01',
					'debit'=>0,
					'credi'=>$item_data[$i]['withh']
				);
				$array_item3 = array(	//Credit Social Fund
					'belnr'=>$id,
					'gjahr'=>$form_data[$i]['gjahr'],
					'belpr'=>3,
					'bldat'=>$date,
					'ernam'=>$current_user,
					'erdat'=>$date,
					'txz01'=>'เงินประกันสังคม',
					'saknr'=>'2131-04',
					'debit'=>0,
					'credi'=>$item_data[$i]['socia']
				);
				$array_item4 = array(	//Credit Bank
					'belnr'=>$id,
					'gjahr'=>$form_data[$i]['gjahr'],
					'belpr'=>4,
					'bldat'=>$date,
					'ernam'=>$current_user,
					'erdat'=>$date,
					'txz01'=>'ธนาคาร',
					'saknr'=>$item_data[$i]['glban'],
					'debit'=>0,
					'credi'=>$item_data[$i]['netpa']
				);
				$this->db->insert('bsid', $array_item1);
				$this->db->insert('bsid', $array_item2);
				$this->db->insert('bsid', $array_item3);
				$this->db->insert('bsid', $array_item4);					
			}
			//Save Journal  Social Fund
			$id_social = $this->code_model->generate('JV',$date);
			$form_social = array(
				'belnr'=>$id_social,
				'gjahr' => substr($date,0,4),
				'bldat'=>$date,
				'ernam'=>$current_user,
				'erdat'=>$date,
				'txz01'=>"จ่ายสมทบเงินประกันสังคม ",
				'auart'=>"JV",
				'netwr'=>$sum_social+$sum_socialco
			);
			$item_social1 = array(	//Debit Social Fund
				'belnr'=>$id_social,
				'gjahr'=>$form_social['gjahr'],
				'belpr'=>1,
				'bldat'=>$date,
				'ernam'=>$current_user,
				'erdat'=>$date,
				'txz01'=>'ประกันสังคม',
				'saknr'=>'2131-04',
				'debit'=>$sum_social,
				'credi'=>'0'
			);
			$item_social2 = array(	//Debit Social Fund Contribution
				'belnr'=>$id_social,
				'gjahr'=>$form_social['gjahr'],
				'belpr'=>2,
				'bldat'=>$date,
				'ernam'=>$current_user,
				'erdat'=>$date,
				'txz01'=>'สมทบประกันสังคม',
				'saknr'=>'5310-09',
				'debit'=>$sum_socialco,
				'credi'=>'0'
			);
			$item_social3 = array(	//Credit Social Fund AP
				'belnr'=>$id_social,
				'gjahr'=>$form_social['gjahr'],
				'belpr'=>3,
				'bldat'=>$date,
				'ernam'=>$current_user,
				'erdat'=>$date,
				'txz01'=>'เจ้าหนี้ประกันสังคม',
				'saknr'=>'2138-00',
				'debit'=>'0',
				'credi'=>$sum_social+$sum_socialco
			);
			$this->db->insert('bkpf',$form_social);	
			$this->db->insert('bsid', $item_social1);
			$this->db->insert('bsid', $item_social2);
			$this->db->insert('bsid', $item_social3);
			
			//Save Journal  Withholding Tax
			$id_withh = $this->code_model->generate('JV',$date);
			$form_withh = array(
				'belnr'=>$id_withh,
				'gjahr' => substr($date,0,4),
				'bldat'=>$date,
				'ernam'=>$current_user,
				'erdat'=>$date,
				'txz01'=>"บันทึกเจ้าหนี้สรรพากร  ภงด 1 ",
				'auart'=>"JV",
				'netwr'=>$sum_withh
			);
			$item_withh1 = array(	//Debit Withholding Tax
				'belnr'=>$id_withh,
				'gjahr'=>$form_withh['gjahr'],
				'belpr'=>1,
				'bldat'=>$date,
				'ernam'=>$current_user,
				'erdat'=>$date,
				'txz01'=>'ภาษีหัก ณ ที่จ่าย ภงด 1',
				'saknr'=>'2132-01',
				'debit'=>$sum_withh,
				'credi'=>'0'
			);
			$item_withh2 = array(	//Credit Revenue AP
				'belnr'=>$id_withh,
				'gjahr'=>$form_withh['gjahr'],
				'belpr'=>2,
				'bldat'=>$date,
				'ernam'=>$current_user,
				'erdat'=>$date,
				'txz01'=>'เจ้าหนี้กรมสรรพากร',
				'saknr'=>'2137-00',
				'debit'=>'0',
				'credi'=>$sum_withh
			);
			$this->db->insert('bkpf',$form_withh);	
			$this->db->insert('bsid', $item_withh1);
			$this->db->insert('bsid', $item_withh2);
		}
						
		echo json_encode(array(
			'success'=>TRUE,
			'rows'=>$form_data,
			'totalCount'=>count($form_data)
		));
	}

}

?>