<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ChartOfAccounts extends CI_Controller {

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
		
		function insert_glcre($array_import){
			
			for ($i=0;$i<count($array_import);$i++){ 
				switch ($array_import[$i]['glgrp']){
					case '1' : $array_import[$i]['glcre']='-1'; break;
					case '2' : $array_import[$i]['glcre']='1'; break;
					case '3' : $array_import[$i]['glcre']='1'; break;
					case '4' : $array_import[$i]['glcre']='1'; break;
					case '5' : $array_import[$i]['glcre']='-1'; break;
				}
			}
			return $array_import;
		}

		$upload_file = $this->input->get('file');
		$exel_file = FCPATH.'fileuploads/'.$upload_file;//FCPATH.'fileuploads/excelfile.xlsx';

		$result = array();

		$columns = array(
			0=>'saknr',
			1=>'sgtxt',
			2=>'entxt',
			3=>'glgrp',
			4=>'gllev',
			5=>'gltyp',
			6=>'overs',
			7=>'glcre',
			8=>'depar'
			//7=>'statu'
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
		$result = check_duplicate($result, 'saknr');

		// check valid gl no
		$gl = array();
		foreach($result AS $value){
			array_push($gl, $value['saknr']);
		}
		$this->db->select('saknr');
		$this->db->where_in('saknr', $gl);
		$query = $this->db->get('glno');
		$exist_gl = $query->result_array();
		$result = check_exist_pk($exist_gl, $result, 'saknr', 'Primary key is duplicate');

		// check valid GL Group
		$gl_group = array();
		foreach($result AS $value){
			array_push($gl_group, $value['glgrp']);
		}
		
		$this->db->select('glgrp');
		$this->db->where_in('glgrp', $gl_group);
		$query = $this->db->get('ggrp');
		$valid_gl_group = $query->result_array();
		$result = check_exist($valid_gl_group, $result, 'glgrp', 'GL Group is not exist');
		
		//Insert glcre
		$result = insert_glcre($result);
		
		for($i=0;$i<count($result);$i++){
			$result[$i]['error'] = implode(',', $result[$i]['error']);
		}

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
					'saknr'=>$data->saknr,
					'sgtxt'=>$data->sgtxt,
					'entxt'=>$data->entxt,
					'glgrp'=>$data->glgrp,
					'gllev'=>$data->gllev,
					'gltyp'=>$data->gltyp,
					'overs'=>$data->overs,
					'glcre'=>$data->glcre,
					'depar'=>$data->depar
					//'statu'=>$data->statu
				));
		}
		if(count($batch_data)>0){
			foreach($batch_data as $data){
				$this->db->insert('glno', $data);
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