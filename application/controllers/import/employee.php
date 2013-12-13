<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Employee extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->library('PHPExcel');
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
			2=>'adr01',
			3=>'distx',
			4=>'pstlz',
			5=>'telf1',
			6=>'cidno',
			7=>'email',
			8=>'postx',
			9=>'supnr',
			10=>'begdt',
			11=>'salar',
			12=>'bcode',
			13=>'saknr',
			14=>'pson1',
			15=>'telf2',
			16=>'statu'
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

		// check duplicate code
		$result = check_duplicate($result, 'empnr');

		// check valid employee no
		$employees = array();
		foreach($result AS $value){
			array_push($employees, $value['empnr']);
		}
		$this->db->select('empnr');
		$this->db->where_in('empnr', $employees);
		$query = $this->db->get('empl');
		$exist_employees = $query->result_array();
		$result = check_exist_pk($exist_employees, $result, 'empnr', 'Primary key is duplicate');

		// check valid supervisor
		$supervisor = array();
		foreach($result AS $value){
			array_push($supervisor, $value['supnr']);
		}
		$this->db->select('empnr');
		$this->db->where_in('empnr', $supervisor);
		$query = $this->db->get('empl');
		$valid_supervisor = $query->result_array();
		$result = check_exist2($valid_supervisor, $result, 'empnr', 'supnr', 'Supervisor is not exist');
		
		// check valid position
		$position = array();
		foreach($result AS $value){
			array_push($position, $value['postx']);
		}
		$this->db->select('postx');
		$this->db->where_in('postx', $position);
		$query = $this->db->get('posi');
		$valid_position = $query->result_array();
		$result = check_exist($valid_position, $result, 'postx', 'Position is not exist');

		// check valid bank name
		$bank = array();
		foreach($result AS $value){
			array_push($bank, $value['bcode']);
		}
		$this->db->select('bcode');
		$this->db->where_in('bcode', $bank);
		$query = $this->db->get('bnam');
		$valid_bank = $query->result_array();
		$result = check_exist($valid_bank, $result, 'bcode', 'Bank Name is not exist');
		
		// check valid GL Account
		$gl = array();
		foreach($result AS $value){
			array_push($gl, $value['saknr']);
		}
		$this->db->select('saknr');
		$this->db->where_in('saknr', $gl);
		$query = $this->db->get('glno');
		$valid_gl = $query->result_array();
		$result = check_exist($valid_gl, $result, 'saknr', 'Bank Account Number is not exist');

		// finish data
		for($i=0;$i<count($result);$i++){
			$result[$i]['error'] = implode(',', $result[$i]['error']);
		}

		//print_r($valid_projects);
		//print_r($result);

		echo json_encode(array(
			'success'=>TRUE,
			'rows'=>$result,
			'totalCount'=>count($result)
		));
	}

	function import(){
		$datas = $this->input->post('data');
		$data_obj = json_decode($datas);
		$batch_data = array();
		foreach($data_obj AS $data){
			if(empty($data->error) || $data->error=='')
				array_push($batch_data, array(
					'empnr'=>$data->empnr,
					'name1'=>$data->name1,
					'adr01'=>$data->adr01,
					'distx'=>$data->distx,
					'pstlz'=>$data->pstlz,
					'telf1'=>$data->telf1,
					'cidno'=>$data->cidno,
					'email'=>$data->email,
					'postx'=>$data->postx,
					'supnr'=>$data->supnr,
					'begdt'=>$data->begdt,
					'salar'=>$data->salar,
					'bcode'=>$data->bcode,
					'saknr'=>$data->saknr,
					'pson1'=>$data->pson1,
					'telf2'=>$data->telf2,
					'statu'=>$data->statu
				));
		}
		if(count($batch_data)>0){
			foreach($batch_data as $data){
				$this->db->insert('empl', $data);
			}
		}
		echo json_encode(array(
			'success'=>TRUE,
			'rows'=>$batch_data,
			'totalCount'=>count($batch_data)
		));
	}

}

?>