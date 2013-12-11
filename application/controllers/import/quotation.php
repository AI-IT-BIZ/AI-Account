<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Quotation extends CI_Controller {

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

		$upload_file = $this->input->get('file');
		$exel_file = FCPATH.'fileuploads/'.$upload_file;//FCPATH.'fileuploads/quotation.xlsx';

		$result = array();

		$columns = array(
			0=>'vbeln',
			1=>'kunnr',
			2=>'jobnr'
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
		$result = check_duplicate($result, 'vbeln');

		// check valid quotation no
		$quotations = array();
		foreach($result AS $value){
			array_push($quotations, $value['vbeln']);
		}
		$this->db->select('vbeln');
		$this->db->where_in('vbeln', $quotations);
		$query = $this->db->get('vbak');
		$exist_quotations = $query->result_array();
		$result = check_exist_pk($exist_quotations, $result, 'vbeln', 'Primary key is duplicate');

		// check valid customer no
		$customers = array();
		foreach($result AS $value){
			array_push($customers, $value['kunnr']);
		}
		$this->db->select('kunnr');
		$this->db->where_in('kunnr', $customers);
		$query = $this->db->get('kna1');
		$valid_customers = $query->result_array();
		$result = check_exist($valid_customers, $result, 'kunnr', 'Customer is not exist');

		// check valid project no
		$projects = array();
		foreach($result AS $value){
			array_push($projects, $value['jobnr']);
		}
		$this->db->select('jobnr');
		$this->db->where_in('jobnr', $projects);
		$query = $this->db->get('jobk');
		$valid_projects = $query->result_array();
		$result = check_exist($valid_projects, $result, 'jobnr', 'Project is not exist');

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
					'vbeln'=>$data->vbeln,
					'kunnr'=>$data->kunnr,
					'jobnr'=>$data->jobnr
				));
		}
		if(count($batch_data)>0){
			$this->db->insert_batch('vbak', $batch_data);
		}
		echo json_encode(array(
			'success'=>TRUE,
			'rows'=>$batch_data,
			'totalCount'=>count($batch_data)
		));
	}

}

?>