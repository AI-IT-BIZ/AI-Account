<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Journal extends CI_Controller {

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
		$this->db->where('belnr', $id);
		$query = $this->db->get('bkpf');
		
		if($query->num_rows()>0){
			$result = $query->first_row('array');
			$result['id'] = $result['belnr'];

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
		$tbName = 'bkpf';
		
		// Start for report
		function createQuery($_this){
			$belnr1 = $_this->input->get('belnr');
			$belnr2 = $_this->input->get('belnr2');
			if(!empty($belnr1) && empty($belnr2)){
			  $_this->db->where('belnr', $belnr1);
			}
			elseif(!empty($belnr1) && !empty($belnr2)){
			  $_this->db->where('belnr >=', $belnr1);
			  $_this->db->where('belnr <=', $belnr2);
			}
			
	        $ttype1 = $_this->input->get('ttype');
			$ttype2 = $_this->input->get('ttype2');
			if(!empty($ttype1) && empty($ttype2)){
			  $_this->db->where('ttype', $ttype1);
			}
			elseif(!empty($ttype1) && !empty($ttype2)){
			  $_this->db->where('ttype >=', $ttype1);
			  $_this->db->where('ttype <=', $ttype2);
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
			
			$tranr1 = $_this->input->get('tranr');
			$tranr2 = $_this->input->get('tranr2');
			if(!empty($tranr1) && empty($tranr2)){
			  $_this->db->where('tranr', $tranr1);
			}
			elseif(!empty($tranr1) && !empty($tranr2)){
			  $_this->db->where('tranr >=', $tranr1);
			  $_this->db->where('tranr <=', $tranr2);
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

    public function loads_jtypecombo(){
		$tbName = 'ttyp';
		$tbPK = 'ttype';
        
		$query = $this->input->post('query');

		$totalCount = $this->db->count_all_results($tbName);

		if(!empty($query) && $query!=''){
			$this->db->or_like('typtx', $query);
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

	function save(){
		$id = $this->input->post('id');
		$query = null;
		if(!empty($id)){
			$this->db->limit(1);
			$this->db->where('belnr', $id);
			$query = $this->db->get('bkpf');
		}
		
		$type = $this->input->post('ttype');
        $date = date('Ymd');
		
		$formData = array(
		    'gjahr' => substr($date,0,4),
		    'bldat' => $this->input->post('bldat'),
			'txz01' => $this->input->post('txz01'),
			'ttype' => $this->input->post('ttype'),
			'tranr' => $this->input->post('tranr'),
			'netwr' => $this->input->post('debit')
		);
		
		// start transaction
		$this->db->trans_start();  
		
		if (!empty($query) && $query->num_rows() > 0){
			$this->db->where('belnr', $id);
			$this->db->set('updat', 'NOW()', false);
			$this->db->set('upnam', 'test');
			$this->db->update('bkpf', $formData);
		}else{
			$this->db->where('ttype', $type);
		    $query_type = $this->db->get('ttyp');
			
			if($query_type->num_rows()>0){
			$result_type = $query_type->first_row('array');
		    $modul = $result_type['modul'];
			}
			$id = $this->code_model->generate($modul,
			$this->input->post('bldat'));
			$this->db->set('belnr', $id);
			$this->db->set('erdat', 'NOW()', false);
		    $this->db->set('ernam', 'test');
			$this->db->insert('bkpf', $formData);
			
			//$id = $this->db->insert_id();
		}

		// ลบ pr_item ภายใต้ id ทั้งหมด
		$this->db->where('belnr', $id);
		$this->db->delete('bsid');

		// เตรียมข้อมูล tr item
		$bsid = $this->input->post('bsid');
		$tr_item_array = json_decode($bsid);
		
		if(!empty($bsid) && !empty($tr_item_array)){
			// loop เพื่อ insert tr_item ที่ส่งมาใหม่
			$item_index = 0;
		foreach($tr_item_array AS $p){
			$this->db->insert('bsid', array(
				'belnr'=>$id,
				'belpr'=>++$item_index,
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

	function remove(){
		$id = $this->input->post('id');
		$this->db->where('belnr', $id);
		$query = $this->db->delete('bkpf');
		echo json_encode(array(
			'success'=>true,
			'data'=>$id
		));
	}
	
	///////////////////////////////////////////////
	// Quotation ITEM
	///////////////////////////////////////////////

	function loads_gl_item(){
        $this->db->set_dbprefix('v_');
		$tranr = $this->input->get('tranr1');
		if(!empty($tranr)){
	     	//$iv_id = $this->input->get('vbap');
		    $this->db->where('tranr', $tranr);

		    $query = $this->db->get('trpo');
		}else{
		    $tr_id = $this->input->get('belnr');
		    $this->db->where('belnr', $tr_id);
		    $query = $this->db->get('bsid');
		}

		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$query->num_rows()
		));
	}
	

}