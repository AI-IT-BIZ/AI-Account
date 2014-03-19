<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invoicexml extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('email_service','',TRUE);
		$this->load->model('code_model','',TRUE);
	}
		
	function convert()
	{
		$response = "";
		function check_exist_pk($dataxml,$_this){
			$_response = "";
			$id = $dataxml['matnr'];
			$_this->db->where('matnr',$id);
			$query = $_this->db->get('mara');
			
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
			$_this->db->where('kunnr',$id);
			$query = $_this->db->get('kna1');
			
			if($query->num_rows()>0){
				$arry_query = $query->result_array();
				if($arry_query[0]['statu']=="01"){
					array_push($_response,"Customer ".$cus_code." is not approve");
					return $_response;
				}else if($arry_query[0]['statu']=="03"){
					array_push($_response,"Customer ".$cus_code." is rejected");
					return $_response;
				}
				return $_response;
			}
			else{
				array_push($_response,"Customer ".$cus_code." is not exist");
				return $_response;
			}
		}
		
		function check_exist_saleperson($sale_code,$_this,$_result){
			$_response = $_result;
			$id = $sale_code;
			$_this->db->where('salnr',$id);
			$query = $_this->db->get('psal');
			
			if($query->num_rows()>0){
				$arry_query = $query->result_array();
				if($arry_query[0]['statu']=="01"){
					array_push($_response,"Sale Person ".$sale_code." is not approve");
					return $_response;
				}else if($arry_query[0]['statu']=="03"){
					array_push($_response,"Sale Person ".$sale_code." is rejected");
					return $_response;
				}
				return $_response;
			}
			else{
				array_push($_response,"Sale Person ".$sale_code." is not exist");
				return $_response;
			}
		}

		function check_exist_service($serv_code,$_this,$_result){
			$_response = $_result;
			$id = $serv_code;
			$_this->db->where('matnr',$id);
			$query = $_this->db->get('mara');
			$str = "";
			if($query->num_rows()>0){
				$arry_query = $query->result_array();
				if($arry_query[0]['statu']=="01"){
					array_push($_response,"Service ".$serv_code." is not approve");
					return $_response;
				}else if($arry_query[0]['statu']=="03"){
					array_push($_response,"Service ".$serv_code." is rejected");
					return $_response;
				}
				return $_response;
			}
			else{
				array_push($_response,"Service ".$serv_code." is not exist");
				return $_response;
			}
		}
				
		$doc = new DOMDocument();
		if($_REQUEST['url']){
		$doc->load($_REQUEST['url']);
		
		//===Verify Data
		$result = array();
		$result = check_exist_customer($doc->getElementsByTagName('CustomerCode')->item(0)->nodeValue,$this,$result);
		$result = check_exist_saleperson($doc->getElementsByTagName('SalePerson')->item(0)->nodeValue,$this,$result);
		for($i=0;$i<$doc->getElementsByTagName('InvoiceItem')->length;$i++){
			$node = $doc->getElementsByTagName('InvoiceItem')->item($i);
			$result = check_exist_service($node->getElementsByTagName('MaterialCode')->item(0)->nodeValue,$this,$result);
		}
		if(count($result)>0){
			echo json_encode(array(
			'success'=>false,
			'error'=>$result));
			return;
		}		
		//===End Verify Data

		//Fill Invoice Header into Array
		$id = 'IV1403-0019';
		$formData = array(
		    'invnr' => $id,
			'bldat' => '2014-03-19',
			'statu' => '01',
			'txz01' => '',
			'reanr' => '',
			'refnr' => $doc->getElementsByTagName('ReferenceNo')->item(0)->nodeValue,
			'ptype' => "01",
			'taxnr' => "02",
			'terms' => intval($doc->getElementsByTagName('CreditTerms')->item(0)->nodeValue),
			'kunnr' => $doc->getElementsByTagName('CustomerCode')->item(0)->nodeValue,
			'netwr' => floatval($doc->getElementsByTagName('NetAmont')->item(0)->nodeValue),
			'beamt' => floatval($doc->getElementsByTagName('Total')->item(0)->nodeValue),
			'dismt' => floatval($doc->getElementsByTagName('SaleDiscount')->item(0)->nodeValue),
			'taxpr' => floatval("7.00"),
			'salnr' => $doc->getElementsByTagName('SalePerson')->item(0)->nodeValue,
			'ctype' => "THB",
			'exchg' => floatval("1.00"),
			'duedt' => '2014-04-19',
			'vat01' => floatval($doc->getElementsByTagName('VatTotal')->item(0)->nodeValue),
			'wht01' => floatval($doc->getElementsByTagName('WHTTotal')->item(0)->nodeValue),
			'ftype' => "02"
		);
		//Fill Invoice Item into Array
		$itemData = array();
		for($i=0;$i<$doc->getElementsByTagName('InvoiceItem')->length;$i++){
			$node = $doc->getElementsByTagName('InvoiceItem')->item($i);
			array_push($itemData,array(
				'invnr' => $id,
				'vbelp' => $i+1,
				'matnr' => $node->getElementsByTagName('MaterialCode')->item(0)->nodeValue,
				'menge' => $node->getElementsByTagName('Qty')->item(0)->nodeValue,
				'meins' => $node->getElementsByTagName('Unit')->item(0)->nodeValue,
				'disit' => '',
				'unitp' => $node->getElementsByTagName('PriceUnit')->item(0)->nodeValue,
				'itamt' => $node->getElementsByTagName('Amount')->item(0)->nodeValue,
				'ctype' => 'THB',
				'chk01' => '1'
			));
		}
		
		// start transaction
		$this->db->trans_start(); 
		
		db_helper_set_now($this, 'erdat');
		$this->db->set('ernam', 'BMS');
		$this->db->insert('vbrk', $formData);
		
		foreach($itemData AS $p){
			$this->db->insert('vbrp', array(
				'invnr'=>$p['invnr'],
				'vbelp'=>$p['vbelp'],
				'matnr'=>$p['matnr'],
				'menge'=>floatval($p['menge']),
				'meins'=>$p['meins'],
				'disit'=>$p['disit'],
				'unitp'=>floatval($p['unitp']),
				'itamt'=>floatval($p['itamt']),
				'ctype'=>$p['ctype'],
				'chk01'=>$p['chk01']
				));
		}
		
		// end transaction
		$this->db->trans_complete();
		echo json_encode(array(
			'success'=>true,
			'data'=>$formData
			));
		}
		else {
			
			
		}		
				
	}

}