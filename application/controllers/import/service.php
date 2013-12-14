<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Service extends CI_Controller {

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
		$exel_file = FCPATH.'fileuploads/'.$upload_file;//FCPATH.'fileuploads/excelfile.xlsx';

		$result = array();

		$columns = array(
			0=>'matnr',
			1=>'maktx',
			2=>'matkl',
			3=>'mtart',
			4=>'meins',
			5=>'saknr',
			6=>'beqty',
			7=>'beval',
			8=>'cosav',
			9=>'enqty',
			10=>'enval',
			11=>'unit1',
			12=>'cost1',
			13=>'unit2',
			14=>'cost2',
			15=>'unit3',
			16=>'cost3',
			17=>'statu',
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
		$result = check_duplicate($result, 'matnr');

		// check valid Service
		$services = array();
		foreach($result AS $value){
			array_push($services, $value['matnr']);
		}
		$this->db->select('matnr');
		$this->db->where_in('matnr', $services);
		$query = $this->db->get('mara');
		$exist_services = $query->result_array();
		$result = check_exist_pk($exist_services, $result, 'matnr', 'Primary key is duplicate');

		// check valid Service Group
		$service_group = array();
		foreach($result AS $value){
			array_push($service_group, $value['matkl']);
		}
		$this->db->select('matkl');
		$this->db->where_in('matkl', $service_group);
		$query = $this->db->get('mgrp');
		$valid_service_group = $query->result_array();
		$result = check_exist($valid_service_group, $result, 'matkl', 'Service Group is not exist');

		// check valid Service type
		$service_type = array();
		foreach($result AS $value){
			array_push($service_type, $value['mtart']);
		}
		$this->db->select('mtart');
		$this->db->where_in('mtart', $service_type);
		$query = $this->db->get('mtyp');
		$valid_service_type = $query->result_array();
		$result = check_exist($valid_service_type, $result, 'mtart', 'Service Type is not exist');
		
		// check valid GL Account
		$gl = array();
		foreach($result AS $value){
			array_push($gl, $value['saknr']);
		}
		$this->db->select('saknr');
		$this->db->where_in('saknr', $gl);
		$query = $this->db->get('glno');
		$valid_gl = $query->result_array();
		$result = check_exist($valid_gl, $result, 'saknr', 'GL Number is not exist');

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
					'matnr'=>$data->matnr,
					'maktx'=>$data->maktx,
					'matkl'=>$data->matkl,
					'mtart'=>$data->mtart,
					'meins'=>$data->meins,
					'saknr'=>$data->saknr,
					'beqty'=>$data->beqty,
					'beval'=>$data->beval,
					'cosav'=>$data->cosav,
					'enqty'=>$data->enqty,
					'enval'=>$data->enval,
					'unit1'=>$data->unit1,
					'cost1'=>$data->cost1,
					'unit2'=>$data->unit2,
					'cost2'=>$data->cost2,
					'unit3'=>$data->unit3,
					'cost3'=>$data->cost3,
					'statu'=>$data->statu,
				));
		}
		if(count($batch_data)>0){
			foreach($batch_data as $data){
				$this->db->insert('mara', $data);
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