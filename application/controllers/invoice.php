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
			
			$result['adr01'] .= $result['distx'].' '.$result['pstlz'].
			                         PHP_EOL.'Tel: '.$result['telf1'].PHP_EOL.'Fax: '.
			                         $result['telfx'].
									 PHP_EOL.'Email: '.$result['email'];
			$result['adr11'] = $result['adr01'];

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
		
		$exchg = $this->input->post('exchg');
		$curr = 'THB';
		if($exchg <> 0){
			$curr = 'USD';
		}

		$formData = array(
		    //'invnr' => $this->input->post('invnr'),
			'vbeln' => $this->input->post('vbeln'),
			'bldat' => $this->input->post('bldat'),
			'statu' => $this->input->post('statu'),
			'txz01' => $this->input->post('txz01'),
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
			'ctype' => $curr,
			'exchg' => $this->input->post('exchg'),
			'duedt' => $this->input->post('duedt'),
			'vbeln' => $this->input->post('vbeln'),
			//'paypr' => $this->input->post('paypr'),
			//'belnr' => $this->input->post('belnr'),
			'condi' => $this->input->post('condi')
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
				'dismt'=>$p->dismt,
				'unitp'=>$p->unitp,
				'itamt'=>$p->itamt,
				'ctype'=>$p->ctype
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
		$tbName = 'apov';
		$tbPK = 'statu';
		
        //$this->db->where('apgrp', '2');
		//$query = $this->db->get('apov');
		
		$query = $this->input->post('query');
		
		$totalCount = $this->db->count_all_results($tbName);

		if(!empty($query) && $query!=''){
			$this->db->or_like('statx', $query);
			$this->db->or_like($tbPK, $query);
		}

		//$this->db->order_by($_POST['sort'], $_POST['dir']);
		$query = $this->db->get($tbName);
		//$query = $this->db->get('apov');

		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$totalCount
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
		$tbName = 'ptyp';
		$tbPK = 'ptype';

		$query = $this->input->post('query');

		$totalCount = $this->db->count_all_results($tbName);

		if(!empty($query) && $query!=''){
			$this->db->or_like('paytx', $query);
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
        $this->db->set_dbprefix('v_');
		$iv_id = $this->input->get('invnr');
		$this->db->where('invnr', $iv_id);

		$query = $this->db->get('vbrp');
		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$query->num_rows()
		));
	}
	
	function loads_gl_item(){
        $this->db->set_dbprefix('v_');
		$iv_id = $this->input->get('belnr');
		$this->db->where('belnr', $iv_id);

		$query = $this->db->get('bsid');
		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$query->num_rows()
		));
	}
	

}