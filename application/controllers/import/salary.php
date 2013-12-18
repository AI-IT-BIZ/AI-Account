<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Salary extends CI_Controller {

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
		$sum_tax = 0;
		$batch_data = array();
		foreach($data_obj AS $data){
			if(empty($data->error) || $data->error==''){
				array_push($batch_data, array(
					'lifnr'=>$data->lifnr,
					'vtype'=>$data->vtype,
					'name1'=>$data->name1,
					'adr01'=>$data->adr01,
					'distx'=>$data->distx,
					'pstlz'=>$data->pstlz,
					'cunty'=>$data->cunty,
					'pstlz'=>$data->pstlz,
					'telf1'=>$data->telf1,
					'telfx'=>$data->telfx,
					'email'=>$data->email,
					'pson1'=>$data->pson1,
					'disct'=>$data->disct,
					//'begin'=>$data->begin,
					'endin'=>$data->endin,
					'ptype'=>$data->ptype,
					'terms'=>$data->terms,
					'taxnr'=>$data->taxnr,
					'vat01'=>$data->vat01,
					'taxid'=>$data->taxid,
					'saknr'=>$data->saknr,
					'note1'=>$data->note1,
					'statu'=>$data->statu
				));
				$sum_social += $data->soci;
				$sum_tax += $data->wtax; 
			}
		}
		if(count($batch_data)>0){
			foreach($batch_data as $data){
				$this->db->insert('lfa1', $data);
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