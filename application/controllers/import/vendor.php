<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vendor extends CI_Controller {

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
			0=>'lifnr',
			1=>'vtype',
			2=>'name1',
			3=>'adr01',
			4=>'distx',
			5=>'cunty',
			6=>'pstlz',
			7=>'telf1',
			8=>'telfx',
			9=>'email',
			10=>'pson1',
			11=>'disct',
			12=>'apamt',
			13=>'begin',
			14=>'endin',
			15=>'ptype',
			16=>'terms',
			17=>'taxnr',
			18=>'vat01',
			19=>'taxid',
			20=>'saknr',
			21=>'note1',
			22=>'statu'
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
		$result = check_duplicate($result, 'lifnr');

		// check valid vendor no
		$vendors = array();
		foreach($result AS $value){
			array_push($vendors, $value['lifnr']);
		}
		$this->db->select('lifnr');
		$this->db->where_in('lifnr', $vendors);
		$query = $this->db->get('lfa1');
		$exist_vendors = $query->result_array();
		$result = check_exist_pk($exist_vendors, $result, 'lifnr', 'Primary key is duplicate');

		// check valid vendor type
		$vendor_type = array();
		foreach($result AS $value){
			array_push($vendor_type, $value['vtype']);
		}
		$this->db->select('vtype');
		$this->db->where_in('vtype', $vendor_type);
		$query = $this->db->get('vtyp');
		$valid_vendor_type = $query->result_array();
		$result = check_exist($valid_vendor_type, $result, 'vtype', 'Vendor type is not exist');

		// check valid payment type
		$payment = array();
		foreach($result AS $value){
			array_push($payment, $value['ptype']);
		}
		$this->db->select('ptype');
		$this->db->where_in('ptype', $payment);
		$query = $this->db->get('ptyp');
		$valid_payment = $query->result_array();
		$result = check_exist($valid_payment, $result, 'ptype', 'Payment Type is not exist');
		
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