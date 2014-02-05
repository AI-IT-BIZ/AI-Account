<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer extends CI_Controller {

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
			0=>'kunnr',
			1=>'ktype',
			2=>'name1',
			3=>'adr01',
			4=>'distx',
			5=>'cunt1',
			6=>'pstlz',
			7=>'email',
			8=>'telf1',
			9=>'telfx',
			10=>'pson1',
			11=>'adr02',
			12=>'dis02',
			13=>'cunt2',
			14=>'pst02',
			15=>'emai2',
			16=>'tel02',
			17=>'telf2',
			18=>'pson2',
			19=>'ptype',
			20=>'terms',
			21=>'apamt',
			22=>'pleve',
			23=>'taxnr',
			24=>'vat01',
			25=>'began',
			26=>'endin',
			27=>'taxid',
			28=>'saknr',
			29=>'note1',
			30=>'statu'
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
		$result = check_duplicate($result, 'kunnr');

		// check valid customer no
		$customers = array();
		foreach($result AS $value){
			array_push($customers, $value['kunnr']);
		}
		$this->db->select('kunnr');
		$this->db->where_in('kunnr', $customers);
		$query = $this->db->get('kna1');
		$exist_customers = $query->result_array();
		$result = check_exist_pk($exist_customers, $result, 'kunnr', 'Primary key is duplicate');

		// check valid customer type
		$customer_type = array();
		foreach($result AS $value){
			array_push($customer_type, $value['ktype']);
		}
		$this->db->select('ktype');
		$this->db->where_in('ktype', $customer_type);
		$query = $this->db->get('ktyp');
		$valid_customer_type = $query->result_array();
		$result = check_exist($valid_customer_type, $result, 'ktype', 'Customer type is not exist');

		// check valid payment
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
					'kunnr'=>$data->kunnr,
					'ktype'=>$data->ktype,
					'name1'=>$data->name1,
					'adr01'=>$data->adr01,
					'distx'=>$data->distx,
					'pstlz'=>$data->pstlz,
					'cunt1'=>$data->cunt1,
					'email'=>$data->email,
					'telf1'=>$data->telf1,
					'telfx'=>$data->telfx,
					'pson1'=>$data->pson1,
					'adr02'=>$data->adr02,
					'dis02'=>$data->dis02,
					'cunt2'=>$data->cunt2,
					'pst02'=>$data->pst02,
					'emai2'=>$data->emai2,
					'tel02'=>$data->tel02,
					'telf2'=>$data->telf2,
					'pson2'=>$data->pson2,
					'ptype'=>$data->ptype,
					'terms'=>$data->terms,
					'apamt'=>$data->apamt,
					'pleve'=>$data->pleve,
					'taxnr'=>$data->taxnr,
					'vat01'=>$data->vat01,
					'began'=>$data->began,
					'endin'=>$data->endin,
					'taxid'=>$data->taxid,
					'saknr'=>$data->saknr,
					'note1'=>$data->note1,
					'statu'=>$data->statu
				));
		}
		if(count($batch_data)>0){
			//$this->db->insert_batch('kna1', $batch_data);
			foreach($batch_data as $data){
				$this->db->insert('kna1', $data);
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