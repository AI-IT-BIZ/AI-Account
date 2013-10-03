<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->model('code_model','',TRUE);
	}

	function get_gl_item(){
		// *** parameter
		$payment_type = '01';//$this->input->get('payment_type');
		$customer_code = '10002';//$this->input->get('customer_code');
        $net = 2782;  //Vat 182 บาท
        $tax = 182;
		$gltax = '215010';
		$sale = '411000';

		$mats = '[{"matnr":100001,"total":500},
				{"matnr":100002,"total":600},
				{"matnr":200001,"total":700},
				{"matnr":200002,"total":800}]';//$this->input->get('mats');
		$amt = 0;
		$mats_array = json_decode($mats);
		foreach($mats_array AS $mat){
			$amt += floatval($mat->total);
		}

		$tax_type = '01';//$this->input->get('tax_type');

		$result = array();

// record แรก
		if($payment_type=='04'){
			$query = $this->db->get_where('kna1', array(
				'kunnr'=>$customer_code
			));
			if($query->num_rows()>0){
				$q_data = $query->first_row('array');
				$result[0] = array(
					'saknr'=>$q_data['saknr'],
					'debit'=>$net,
					'credit'=>0
				);
			}
		}else{
			$query = $this->db->get_where('ptyp', array(
			));
			if($query->num_rows()>0){
				$q_data = $query->first_row('array');
				$result[0] = array(
					'saknr'=>$q_data['saknr'],
					'debit'=>$net,
					'credit'=>0
				);
			}
		}

// record ที่สอง
		//$net_tax = 0;
		//if($tax_type=='1'){ // seperate tax
		//	$net_tax = floatval($net) * 0.07;
		//}

		$result[1] = array(
			'saknr'=>$gltax,
			'debit'=>0,
			'credit'=>$tax
		);

// record ที่สาม+
		$amt = $net - $tax;
		$result[2] = array(
			'saknr'=>$sale,
			'debit'=>0,
			'credit'=>$amt
		);
		
		//return $result;

// record ที่สี่+
/*
		$item_array = array();
		foreach($mats_array AS $mat){
			// load database get saknr
			$this->db->select('matnr,saknr');
			$query = $this->db->get_where('mara', array('matnr'=>$mat->matnr));
			if($query->num_rows()>0){
				$master_mat = $query->first_row('array');
				// check exist saknr
				$exist_index = -1;
				for($i=0;$i<count($item_array);$i++){
					$item=$item_array[$i];
					//echo '&nbsp;&nbsp;'.$master_mat['saknr'].'=='.$item['saknr'];
					//echo '<br />';
					if($master_mat['saknr']==$item['saknr']){
						$exist_index = $i;
						break;
					}
				}
				if($exist_index==-1){
					//echo '<b>NOT EXIST</b> : '.$mat->total.' TO '.$master_mat['saknr'];
					//echo '<br />';
					array_push($item_array, array(
						'saknr'=>$master_mat['saknr'],
						'debit'=>0,
						'credit'=>floatval($mat->total)
					));
				}else{
					//echo '<b>EXIST</b> : '.$mat->total.' TO '.$master_mat['saknr'];
					//echo '<br />';
					$item_array[$exist_index]['credit'] += floatval($mat->total);
				}
			}
		}
		
		//echo '<hr />';

		$result = array_merge($result, $item_array);*/
/*
		$this->db->select('saknr');
		$this->db->where_in('matnr', explode(',', $mats_code_array));
		$query = $this->db->get('mara');


		if($query->num_rows()>0){
			$q_mara = $query->result_array();
			foreach($q_mara AS $mara){
				// check exist saknr
				$is_exist = false;
				foreach($item_array AS $item){
					if($q_mara['saknr']==$item['saknr']){
						$is_exist = true; break;
					}
				}
				if(!$is_exist){
					array_push($item_array, array(
						'saknr'=>$mara['saknr'],
						'debit'=>0,
						'credit'=>99
					));
				}
			}
		}
*/
		// generate result
		echo json_encode(array(
			'success'=>true,
			'rows'=>$result,
			'totalCount'=>count($result)
		));
	}

}