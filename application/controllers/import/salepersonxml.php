<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Salepersonxml extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('email_service','',TRUE);
		$this->load->model('code_model2','',TRUE);
	}
		
	function convert()
	{
		$response = "";
		function check_exist_pk($salexml,$_this){
			$_response = "";
			$id = $salexml['refnr'];
			$_this->db->where('refnr',$id);
			$query = $_this->db->get('psal');
			
			if($query->num_rows()>0){
				$_response = "Edit";
				return $_response;
			}
			else{
				$_response = "Create";
				return $_response;
			}
		}
		
		function check_exist_sale($sale_code,$_this,$_result){
			$_response = $_result;
			$id = $sale_code;
			$_this->db->where('refnr',$id);
			$query = $_this->db->get('psal');
			
			if($query->num_rows()>0){
				$arry_query = $query->result_array();
				if($arry_query[0]['statu']=="03"){
					array_push($_response,"SalePerson ".$sale_code." has been rejected");
					return $_response;
				}
				return $_response;
			}
		}
		
		
		$doc = new DOMDocument();
		if($_REQUEST['url']){
		$doc->load($_REQUEST['url']);
		$saleperson = array(
					//'salnr'=>$doc->getElementsByTagName('SalePersonCode')->item(0)->nodeValue,
					'name1'=>$doc->getElementsByTagName('SalePersonName')->item(0)->nodeValue,
					'statu'=>"01",
					'refnr'=>$doc->getElementsByTagName('SalePersonCode')->item(0)->nodeValue
					);
		
		//$customer = check_exist_pk($customer,$this);
		$response = check_exist_pk($saleperson,$this);
			if($response=="Create"){
				$id = $this->code_model2->generate2('SP');
				$saleperson['salnr']=$id;
				$username = "BMS";
				db_helper_set_now($this, 'erdat');
				$this->db->set('ernam', $username);
				$this->db->insert('psal', $saleperson);
			}
			if($response=="Edit"){
				//Verify Data
				$result = array();
				$result = check_exist_sale($doc->getElementsByTagName('SalePersonCode')->item(0)->nodeValue,$this,$result);
				if(count($result)>0){
					echo json_encode(array(
					'success'=>false,
					'error'=>$result));
					return;
				}		
				else{
					$this->db->where('refnr', $saleperson['refnr']);
					$this->db->update('psal',$saleperson);
				}
			}
			echo json_encode(array(
			'success'=>true,
			'data'=>$saleperson
			));
		}
		else {
			echo json_encode(array(
				'success'=>false
			));
		}
		
		try{
				if($response=="Create"){$post_id = $saleperson['salnr'];}
				else{
					$res = $this->db->get('psal');
					$res_arry = $res->result_array();
					$post_id = $res_arry[0]['salnr'];
				}
				$total_amount = "0";
				// send notification email
				if($post_id!=""){
					$q_row = $this->db->get_where('psal', array('salnr'=>$post_id));
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