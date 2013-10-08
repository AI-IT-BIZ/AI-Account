<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Glposting extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->model('code_model','',TRUE);
	}
	
	function loads_gl_item(){
        
		$iv_id = $this->input->get('belnr');
		$result = array();
		$i=0;$n=0;$vamt=0;

		if(empty($iv_id)){
		   //$matnr = array();
		   $netpr = $this->input->get('netpr');  //Net amt
	       $vvat = $this->input->get('vvat');    //VAT amt
		   $vwht = $this->input->get('vwht');    //WHT amt
		   //$matnr = $this->input->get('matnr');  //Mat Code
		   $kunnr = $this->input->get('kunnr');  //Customer Code
		   $ptype = $this->input->get('ptype');  //Pay Type
		   $dtype = $this->input->get('dtype');  //Doc Type
           
		   if(empty($vvat)) $vvat=0;
		   if(empty($vwht)) $vwht=0;
		   
		   $net = ($netpr + $vvat) - $vwht;
		   
// record แรก
		if($ptype=='01'){
			$query = $this->db->get_where('kna1', array(
				'kunnr'=>$kunnr));
			if($query->num_rows()>0){
				$q_data = $query->first_row('array');
				$qgl = $this->db->get_where('glno', array(
				'saknr'=>$q_data['saknr']));
				$q_glno = $qgl->first_row('array');
				$result[$i] = array(
				    'belpr'=>$i + 1,
					'saknr'=>$q_data['saknr'],
					'sgtxt'=>$q_glno['sgtxt'],
					'debit'=>$net,
					'credi'=>0
				);
				$i++;
			}
		}else{
			$query = $this->db->get_where('ptyp', array(
			'ptype'=>$ptype));
			if($query->num_rows()>0){
				$q_data = $query->first_row('array');
				$qgl = $this->db->get_where('glno', array(
				'saknr'=>$q_data['saknr']));
				$q_glno = $qgl->first_row('array');
				$result[$i] = array(
				    'belpr'=>$i + 1,
					'saknr'=>$q_data['saknr'],
					'sgtxt'=>$q_glno['sgtxt'],
					'debit'=>$net,
					'credi'=>0
				);
				$i++;
			}
		}
// record ที่สอง
        if($netpr>0){
        if($dtype=='01'){
           $doct = '411000';
        }
        
		$qdoc = $this->db->get_where('glno', array(
				'saknr'=>$doct));
		$q_doc = $qdoc->first_row('array');
		$result[$i] = array(
		    'belpr'=>$i + 1,
			'saknr'=>$doct,
			'sgtxt'=>$q_doc['sgtxt'],
			'debit'=>0,
			'credi'=>$netpr
		);
		$i++;
		}
// record ที่สาม
		if($vvat>'1'){ 
		//	$net_tax = floatval($net) * 0.07;}
		$glvat = '215010';
		$qgl = $this->db->get_where('glno', array(
				'saknr'=>$glvat));
		$q_glno = $qgl->first_row('array');
		$result[$i] = array(
		    'belpr'=>$i + 1,
			'saknr'=>$glvat,
			'sgtxt'=>$q_glno['sgtxt'],
			'debit'=>0,
			'credi'=>$vvat
		);
		$i++;	
		}
        if($vwht>'1'){ 
		//	$net_tax = floatval($net) * 0.07;}
		$glwht = '215040';
		$qgl = $this->db->get_where('glno', array(
				'saknr'=>$glwht));
		$q_glno = $qgl->first_row('array');
		$result[$i] = array(
		    'belpr'=>$i + 1,
			'saknr'=>$glwht,
			'sgtxt'=>$q_glno['sgtxt'],
			'debit'=>$vwht,
			'credi'=>0
		);
		$i++;	
		}
		echo json_encode(array(
			'success'=>true,
			'rows'=>$result,
			'totalCount'=>count($result)
		));
//In Case Edit and Display		   
		}else{
		   $this->db->set_dbprefix('v_');
		   $this->db->where('belnr', $iv_id);
		   $query = $this->db->get('bsid');
		   echo json_encode(array(
			  'success'=>true,
			  'rows'=>$query->result_array(),
			  'totalCount'=>$query->num_rows()
		));
	  }
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