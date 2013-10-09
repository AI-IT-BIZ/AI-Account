<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invoice extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('code_model','',TRUE);
	}

	function index(){
		//$this->load->view('project');
		//$this->phxview->RenderView('vbak');
		//$this->phxview->RenderLayout('default');
	}

	function load(){
		$this->db->set_dbprefix('v_');
		$id = $this->input->post('id');
		$this->db->limit(1);
		$this->db->where('invnr', $id);
		$query = $this->db->get('vbrk');
		
		if($query->num_rows()>0){
			$result = $query->first_row('array');
			$result['id'] = $result['invnr'];
			
			$result['adr01'] .= ' '.$result['distx'].' '.$result['pstlz'].
			                    PHP_EOL.'Tel: '.$result['telf1'].' '.'Fax: '.
			                    $result['telfx'].
							    PHP_EOL.'Email: '.$result['email'];
			$result['adr02'] .= ' '.$result['dis02'].' '.$result['pst02'].
			                         PHP_EOL.'Tel: '.$result['tel02'].' '.'Fax: '.
			                         $result['telf2'].
									 PHP_EOL.'Email: '.$result['emai2'];

			echo json_encode(array(
				'success'=>true,
				'data'=>$result
			));
		}else
			echo json_encode(array(
				'success'=>false
			));
	}

	function loads(){
		$this->db->set_dbprefix('v_');
		$tbName = 'vbrk';
		
		// Start for report
		function createQuery($_this){
			$invnr1 = $_this->input->get('invnr');
			$invnr2 = $_this->input->get('invnr2');
			if(!empty($invnr1) && empty($invnr2)){
			  $_this->db->where('invnr', $invnr1);
			}
			elseif(!empty($invnr1) && !empty($invnr2)){
			  $_this->db->where('invnr >=', $invnr1);
			  $_this->db->where('invnr <=', $invnr2);
			}
			
	        $vbeln1 = $_this->input->get('vbeln');
			$vbeln2 = $_this->input->get('vbeln2');
			if(!empty($vbeln1) && empty($vbeln2)){
			  $_this->db->where('vbeln', $vbeln1);
			}
			elseif(!empty($vbeln1) && !empty($vbeln2)){
			  $_this->db->where('vbeln >=', $vbeln1);
			  $_this->db->where('vbeln <=', $vbeln2);
			}
			
			$bldat1 = $_this->input->get('bldat');
			$bldat2 = $_this->input->get('bldat2');
			if(!empty($bldat1) && empty($bldat2)){
			  $_this->db->where('bldat', $bldat1);
			}
			elseif(!empty($bldat1) && !empty($bldat2)){
			  $_this->db->where('bldat >=', $bldat1);
			  $_this->db->where('bldat <=', $bldat2);
			}
			
			$jobnr1 = $_this->input->get('jobnr');
			$jobnr2 = $_this->input->get('jobnr2');
			if(!empty($jobnr1) && empty($jobnr2)){
			  $_this->db->where('jobnr', $jobnr1);
			}
			elseif(!empty($jobnr1) && !empty($jobnr2)){
			  $_this->db->where('jobnr >=', $jobnr1);
			  $_this->db->where('jobnr <=', $jobnr2);
			}
			
			$kunnr1 = $_this->input->get('kunnr');
			$kunnr2 = $_this->input->get('kunnr2');
			if(!empty($kunnr1) && empty($kunnr2)){
			  $_this->db->where('kunnr', $kunnr1);
			}
			elseif(!empty($kunnr1) && !empty($kunnr2)){
			  $_this->db->where('kunnr >=', $kunnr1);
			  $_this->db->where('kunnr <=', $kunnr2);
			}

			$statu1 = $_this->input->get('statu');
			$statu2 = $_this->input->get('statu2');
			if(!empty($statu1) && empty($statu2)){
			  $_this->db->where('statu', $statu1);
			}
			elseif(!empty($statu1) && !empty($statu2)){
			  $_this->db->where('statu >=', $statu1);
			  $_this->db->where('statu <=', $statu2);
			}
		}
// End for report

		$totalCount = $this->db->count_all_results($tbName);
		
		//echo 'aaaa';

		createQuery($this);
		$limit = $this->input->get('limit');
		$start = $this->input->get('start');
		if(isset($limit) && isset($start)) $this->db->limit($limit, $start);

		$query = $this->db->get($tbName);

		//echo $this->db->last_query();
		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$totalCount
		));
	}

	function save(){
		$id = $this->input->post('id');
		$query = null;
		if(!empty($id)){
			$this->db->limit(1);
			$this->db->where('invnr', $id);
			$query = $this->db->get('vbrk');
		}
		
		$formData = array(
		    //'invnr' => $this->input->post('invnr'),
			'bldat' => $this->input->post('bldat'),
			'statu' => $this->input->post('statu'),
			'txz01' => $this->input->post('txz01'),
			'vbeln' => $this->input->post('vbeln'),
			'reanr' => $this->input->post('reanr'),
			'refnr' => $this->input->post('refnr'),
			'ptype' => $this->input->post('ptype'),
			'taxnr' => $this->input->post('taxnr'),
			'terms' => $this->input->post('terms'),
			'kunnr' => $this->input->post('kunnr'),
			'netwr' => $this->input->post('netwr'),
			'beamt' => $this->input->post('beamt'),
			'dismt' => $this->input->post('dismt'),
			'taxpr' => $this->input->post('taxpr'),
			'salnr' => $this->input->post('salnr'),
			'ctype' => $this->input->post('ctype'),
			'exchg' => $this->input->post('exchg'),
			'duedt' => $this->input->post('duedt'),
			'vbeln' => $this->input->post('vbeln'),
			'condi' => $this->input->post('condi'),
			'whtpr' => $this->input->post('whtpr'),
			'vat01' => $this->input->post('vat01'),
			'wht01' => $this->input->post('wht01')
		);
		
		// start transaction
		$this->db->trans_start();  
		
		if (!empty($query) && $query->num_rows() > 0){
			$this->db->where('invnr', $id);
			$this->db->set('updat', 'NOW()', false);
			$this->db->set('upnam', 'test');
			$this->db->update('vbrk', $formData);
		}else{
			$id = $this->code_model->generate('IV', 
			$this->input->post('bldat'));
			$this->db->set('invnr', $id);
			$this->db->set('erdat', 'NOW()', false);
		    $this->db->set('ernam', 'test');
			$this->db->insert('vbrk', $formData);
			
			//$id = $this->db->insert_id();
		}

		// ลบ pr_item ภายใต้ id ทั้งหมด
		$this->db->where('invnr', $id);
		$this->db->delete('vbrp');

		// เตรียมข้อมูล pr item
		$vbrp = $this->input->post('vbrp');
		$iv_item_array = json_decode($vbrp);
		
		if(!empty($vbrp) && !empty($iv_item_array)){
			// loop เพื่อ insert pr_item ที่ส่งมาใหม่
			$item_index = 0;
		foreach($iv_item_array AS $p){
			$this->db->insert('vbrp', array(
				'invnr'=>$id,
				'vbelp'=>++$item_index,
				'matnr'=>$p->matnr,
				'menge'=>$p->menge,
				'meins'=>$p->meins,
				'disit'=>$p->disit,
				'unitp'=>$p->unitp,
				'itamt'=>$p->itamt,
				'ctype'=>$p->ctype,
				'chk01'=>$p->chk01,
				'chk02'=>$p->chk02
			));
	    	}
		}
// Save GL Posting	
        $ids = $id;	
		$id = $this->input->post('id');
		$query = null;
		if(!empty($id)){
			$this->db->limit(1);
			$this->db->where('invnr', $id);
			$query = $this->db->get('bkpf');
		}
		$date = date('Ymd');
		$formData = array(
		    'gjahr' => substr($date,0,4),
		    'bldat' => $this->input->post('bldat'),
			'invnr' => $ids,
			'txz01' => $this->input->post('txz01'),
			'auart' => 'AR',
			'netwr' => $this->input->post('netwr')
		);
		
		// start transaction
		$this->db->trans_start();  
		
		if (!empty($query) && $query->num_rows() > 0){
			$q_gl = $query->first_row('array');
			$id = $q_gl['belnr'];
			$this->db->where('belnr', $id);
			$this->db->set('updat', 'NOW()', false);
			$this->db->set('upnam', 'test');
			$this->db->update('bkpf', $formData);
		}else{
			$id = $this->code_model->generate('AR', 
			$this->input->post('bldat'));
			$this->db->set('belnr', $id);
			$this->db->set('erdat', 'NOW()', false);
		    $this->db->set('ernam', 'test');
			$this->db->insert('bkpf', $formData);
			
			//$id = $this->db->insert_id();
		}
		
		// ลบ gl_item ภายใต้ id ทั้งหมด
		
		$this->db->where('belnr', $id);
		$this->db->delete('bcus');

		// เตรียมข้อมูล pay item
		$bcus = $this->input->post('belpr');//$this->input->post('vbelp');
		$gl_item_array = json_decode($bcus);
		if(!empty($bcus) && !empty($gl_item_array)){

			$item_index = 0;
			// loop เพื่อ insert pay_item ที่ส่งมาใหม่
			foreach($gl_item_array AS $p){
				$this->db->insert('bcus', array(
					'belnr'=>$id,
					'belpr'=>++$item_index,
					'gjahr' => substr($date,0,4),
					'saknr'=>$p->saknr,
					'debit'=>$p->debit,
					'credi'=>$p->credi,
					'txz01'=>$p->txz01
				));
			}
		}

		// end transaction
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
			echo json_encode(array(
				'success'=>false
			));
		else
			echo json_encode(array(
				'success'=>true,
				'data'=>$_POST
			));
	}

    public function loads_condcombo(){
		$tbName = 'cond';
		$tbPK = 'condi';
        
		$query = $this->input->post('query');

		$totalCount = $this->db->count_all_results($tbName);

		if(!empty($query) && $query!=''){
			$this->db->or_like('contx', $query);
			$this->db->or_like($tbPK, $query);
		}

		//$this->db->order_by($_POST['sort'], $_POST['dir']);
		$query = $this->db->get($tbName);

		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$totalCount
		));
	}

    public function loads_acombo(){
		//$tbName = 'apov';
		//$tbPK = 'statu';
		
        $sql="SELECT *
			FROM tbl_apov
			WHERE apgrp = '2'";
		$query = $this->db->query($sql);
		
		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$query->num_rows()
		));
	}

   public function loads_percombo(){
		$tbName = 'payp';
		$tbPK = 'vbeln';

		$query = $this->input->post('query');

		$totalCount = $this->db->count_all_results($tbName);

		if(!empty($query) && $query!=''){
			$this->db->or_like('sgtxt', $query);
			$this->db->or_like($tbPK, $query);
		}

		//$this->db->order_by($_POST['sort'], $_POST['dir']);
		$query = $this->db->get($tbName);

		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$totalCount
		));
	}

    public function loads_scombo(){
		$tbName = 'psal';
		$tbPK = 'salnr';

		$query = $this->input->post('query');

		$totalCount = $this->db->count_all_results($tbName);

		if(!empty($query) && $query!=''){
			$this->db->or_like('name1', $query);
			$this->db->or_like($tbPK, $query);
		}

		//$this->db->order_by($_POST['sort'], $_POST['dir']);
		$query = $this->db->get($tbName);

		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$totalCount
		));
	}
	
	public function loads_tcombo(){
		//$tbName = 'ptyp';
		//$tbPK = 'ptype';

		$sql="SELECT *
			FROM tbl_ptyp
			WHERE ptype <> '02'";
		$query = $this->db->query($sql);

		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$query->num_rows()
		));
	}
    
    public function loads_taxcombo(){
		$tbName = 'tax1';
		$tbPK = 'taxnr';

		$query = $this->input->post('query');

		$totalCount = $this->db->count_all_results($tbName);

		if(!empty($query) && $query!=''){
			$this->db->or_like('taxtx', $query);
			$this->db->or_like($tbPK, $query);
		}

		//$this->db->order_by($_POST['sort'], $_POST['dir']);
		$query = $this->db->get($tbName);

		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$totalCount
		));
	}

	function remove(){
		$id = $this->input->post('id');
		$this->db->where('invnr', $id);
		$query = $this->db->delete('vbrk');
		echo json_encode(array(
			'success'=>true,
			'data'=>$id
		));
	}
	
	///////////////////////////////////////////////
	// Quotation ITEM
	///////////////////////////////////////////////

	function loads_iv_item(){
		$qtnr = $this->input->get('qtnr');
		if(!empty($qtnr)){
			$this->db->set_dbprefix('v_');
	     	//$iv_id = $this->input->get('vbap');
		    $this->db->where('vbeln', $qtnr);

		    $query = $this->db->get('vbap');
		}else{
            $this->db->set_dbprefix('v_');
	     	$iv_id = $this->input->get('invnr');
		    $this->db->where('invnr', $iv_id);

		    $query = $this->db->get('vbrp');
		}
		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$query->num_rows()
		));
	}
	
	function loads_gl_item(){
        
		$iv_id = $this->input->get('belnr');

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
		   
           $i=0;$n=0;$vamt=0;
		   $result = array();
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
	
    function loads_conp_item(){
        $menge = $this->input->get('menge');
		$unitp = $this->input->get('unitp');
		$disit = $this->input->get('disit');
		$vvat = $this->input->get('vvat');
		$vwht = $this->input->get('vwht');
		$vat = $this->input->get('vat');
		$wht = $this->input->get('wht');
		$amt = $menge * $unitp;
        $i=0;$vamt=0;
		$result = array();
		
	    $query = $this->db->get('cont');
        if($query->num_rows()>0){
			$rows = $query->result_array();
			foreach($rows AS $row){

					if($row['conty']=='01'){
						if(empty($disit)) $disit=0;
						$tamt = $amt - $disit;
						$amt = $amt - $disit;
						//unset($result[0]);
						if(empty($disit)) $disit=0;
						$tamt = $amt - $disit;
						
						$result[$i] = array(
					    'contx'=>$row['contx'],
				     	'vtamt'=>$disit,
					    'ttamt'=>$tamt
				        );
						$i++;
					}elseif($row['conty']=='02'){
						if($vat=='true' || $vat=='1'){
							$vamt = ($amt * $vvat) / 100;
							$tamt = $amt + $vamt;
						$result[$i] = array(
					        'contx'=>$row['contx'],
				     	    'vtamt'=>$vamt,
					        'ttamt'=>$tamt
				        );
						$i++;
						}
					}elseif($row['conty']=='03'){
						if($wht=='true' || $wht=='1'){
							$vwht = ($amt * $vwht) / 100;
							$tamt = $amt - $vwht;
							$tamt = $tamt + $vamt;
						$result[$i] = array(
					        'contx'=>$row['contx'],
				     	    'vtamt'=>$vwht,
					        'ttamt'=>$tamt
				        );$i++;
					}
				}
			}}
		echo json_encode(array(
			'success'=>true,
			'rows'=>$result,
			'totalCount'=>count($result)
		));
	}
}