<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Journaltemp extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('code_model3','',TRUE);
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
		$this->db->where('tranr', $id);
		$query = $this->db->get('trko');
		
		if($query->num_rows()>0){
			$result = $query->first_row('array');
			$result['id'] = $result['tranr'];

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
		$tbName = 'trko';
		
		$type = $this->input->get('ttype');
		echo '111'.$type;
		if(!empty($type)){
			$this->db->where('ttype', $type);
		}

		$totalCount = $this->db->count_all_results($tbName);

		//createQuery($this);
		$limit = $this->input->get('limit');
		$start = $this->input->get('start');
		if(isset($limit) && isset($start)) $this->db->limit($limit, $start);
		
		if(!empty($type)){
			$this->db->where('ttype', $type);
		}

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
			$this->db->where('tranr', $id);
			$query = $this->db->get('trko');
		}
		
		$type = $this->input->post('ttype');

		$formData = array(
		    //'invnr' => $this->input->post('invnr'),
			'txz01' => $this->input->post('txz01'),
			'ttype' => $this->input->post('ttype'),
			
		);
		
		// start transaction
		$this->db->trans_start();  
		
		if (!empty($query) && $query->num_rows() > 0){
			$this->db->where('tranr', $id);
			$this->db->set('updat', 'NOW()', false);
			$this->db->set('upnam', 'test');
			$this->db->update('trko', $formData);
		}else{
			$this->db->where('ttype', $type);
		    $query_type = $this->db->get('ttyp');
			
			if($query_type->num_rows()>0){
			$result_type = $query_type->first_row('array');
		    $modul = $result_type['modul'];
			$tname = 'tbl_trko';
			$tcode = 'tranr';
			}
			$id = $this->code_model3->generate3($modul,$tname,$tcode);
			$this->db->set('tranr', $id);
			$this->db->set('erdat', 'NOW()', false);
		    $this->db->set('ernam', 'test');
			$this->db->insert('trko', $formData);
			
			//$id = $this->db->insert_id();
		}

		// ลบ pr_item ภายใต้ id ทั้งหมด
		$this->db->where('tranr', $id);
		$this->db->delete('trpo');

		// เตรียมข้อมูล tr item
		$trpo = $this->input->post('trpo');
		$tr_item_array = json_decode($trpo);
		
		if(!empty($trpo) && !empty($tr_item_array)){
			// loop เพื่อ insert tr_item ที่ส่งมาใหม่
			$item_index = 0;
		foreach($tr_item_array AS $p){
			$this->db->insert('trpo', array(
				'tranr'=>$id,
				'trapr'=>++$item_index,
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
		$this->db->where('tranr', $id);
		$query = $this->db->delete('trko');
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
		$tr_id = $this->input->get('tranr');
		$this->db->where('tranr', $tr_id);

		$query = $this->db->get('trpo');
		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$query->num_rows()
		));
	}
	

}