<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customerxml extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('email_service','',TRUE);
		$this->load->model('code_model2','',TRUE);
	}
		
	function convert()
	{
		$response = "";
		function check_exist_pk($customerxml,$_this){
			$_response = "";
			$id = $customerxml['refnr'];
			$_this->db->where('refnr',$id);
			$query = $_this->db->get('kna1');
			
			if($query->num_rows()>0){
				$_response = "Edit";
				return $_response;
			}
			else{
				$_response = "Create";
				return $_response;
			}
		}
		
		function check_exist_customer($cus_code,$_this,$_result){
			$_response = $_result;
			$id = $cus_code;
			$_this->db->where('refnr',$id);
			$query = $_this->db->get('kna1');
			
			if($query->num_rows()>0){
				$arry_query = $query->result_array();
				if($arry_query[0]['statu']=="03"){
					array_push($_response,"Customer ".$cus_code." has been rejected");
					return $_response;
				}
				return $_response;
			}
		}
		
		
		$doc = new DOMDocument();
		if($_REQUEST['url']){
		$doc->load($_REQUEST['url']);
		$customer = array(
					//'kunnr'=>'',
					'name1'=>$doc->getElementsByTagName('customerName')->item(0)->nodeValue,
					'adr01'=>$doc->getElementsByTagName('billAddress')->item(0)->nodeValue,
					'distx'=>$doc->getElementsByTagName('billProvinct')->item(0)->nodeValue,
					'cunt1'=>$doc->getElementsByTagName('billCountry')->item(0)->nodeValue,
					'pstlz'=>$doc->getElementsByTagName('billPostCode')->item(0)->nodeValue,
					'email'=>$doc->getElementsByTagName('billEmail')->item(0)->nodeValue,
					'telf1'=>$doc->getElementsByTagName('billPhoneNumber')->item(0)->nodeValue,
					'telfx'=>$doc->getElementsByTagName('billFaxNumber')->item(0)->nodeValue,
					'pson1'=>$doc->getElementsByTagName('billContractPerson')->item(0)->nodeValue,
					'adr02'=>$doc->getElementsByTagName('shipAddress')->item(0)->nodeValue,
					'dis02'=>$doc->getElementsByTagName('shipProvinct')->item(0)->nodeValue,
					'cunt2'=>$doc->getElementsByTagName('shipCountry')->item(0)->nodeValue,
					'pst02'=>$doc->getElementsByTagName('shipPostCode')->item(0)->nodeValue,
					'emai2'=>$doc->getElementsByTagName('shipEmail')->item(0)->nodeValue,
					'tel02'=>$doc->getElementsByTagName('shipPhoneNumber')->item(0)->nodeValue,
					'telf2'=>$doc->getElementsByTagName('shipFaxNumber')->item(0)->nodeValue,
					'pson2'=>$doc->getElementsByTagName('shipContractPerson')->item(0)->nodeValue,
					//'terms'=>intval($doc->getElementsByTagName('creditTerms')->item(0)->nodeValue),
					//'apamt'=>floatval($doc->getElementsByTagName('creditLimitAmt')->item(0)->nodeValue),
					//'pleve'=>$doc->getElementsByTagName('priceLevel')->item(0)->nodeValue,
					//'vat01'=>floatval($doc->getElementsByTagName('vatValue')->item(0)->nodeValue),
					//'began'=>floatval($doc->getElementsByTagName('minimumAmt')->item(0)->nodeValue),
					//'endin'=>floatval($doc->getElementsByTagName('maximunAmt')->item(0)->nodeValue),
					//'taxid'=>$doc->getElementsByTagName('taxID')->item(0)->nodeValue,
					'note1'=>$doc->getElementsByTagName('textNote')->item(0)->nodeValue,
					'statu'=>"01",
					'refnr'=>$doc->getElementsByTagName('customerCode')->item(0)->nodeValue
					);
		
		//$customer = check_exist_pk($customer,$this);
		$response = check_exist_pk($customer,$this);
			if($response=="Create"){
				$id = $this->code_model2->generate2('CS');
				$customer['kunnr']=$id;
				$username = "BMS";
				db_helper_set_now($this, 'erdat');
				$this->db->set('ernam', $username);
				$this->db->insert('kna1', $customer);
			}
			if($response=="Edit"){
				//Verify Data
				$result = array();
				$result = check_exist_customer($customer['refnr'],$this,$result);
				if(count($result)>0){
					echo json_encode(array(
					'success'=>false,
					'error'=>$result));
					return;
				}		
				else{
					$this->db->where('refnr',$customer['refnr']);				
					$this->db->update('kna1',$customer);
				}
			}
			echo json_encode(array(
			'success'=>true,
			'data'=>$customer
			));
		}
		else {
			echo json_encode(array(
				'success'=>false
			));
		}
		
		try{
				if($response=="Create"){$post_id = $id;}
				else{
					$res = $this->db->get('kna1');
					$res_arry = $res->result_array();
					$post_id = $res_arry[0]['kunnr'];
				}
				$total_amount = "0";
				// send notification email
				if($post_id!=""){
					$q_row = $this->db->get_where('kna1', array('kunnr'=>$post_id));
					$row = $q_row->first_row();
					$this->email_service->sendmail_create(
						'CS', 'Customer master',
						$post_id, $total_amount,
						$row->ernam
					);
				}
			}catch(exception $e){}				
	}

}
	