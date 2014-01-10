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
		
		// Start for report
		function createQuery($_this){
			$query = $_this->input->get('query');
			if(!empty($query)){
				$_this->db->where("(`tranr` LIKE '%$query%'
				OR `txz01` LIKE '%$query%'
				OR `ttype` LIKE '%$query%')", NULL, FALSE);
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
        createQuery($this);
		$totalCount = $this->db->count_all_results($tbName);

		createQuery($this);
		$limit = $this->input->get('limit');
		$start = $this->input->get('start');
		if(isset($limit) && isset($start)) $this->db->limit($limit, $start);
        
		$sort = $this->input->get('sort');
		$dir = $this->input->get('dir');
		$this->db->order_by($sort, $dir);
		
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
		$txt  = $this->input->post('txz01');
		//if($query->num_rows() > 0){
			$this->db->where('txz01', $txt);
			$q_txt = $this->db->get('trko');
			if($q_txt->num_rows() > 0){
				$emsg = 'The template name already created';
					echo json_encode(array(
						'success'=>false,
						'message'=>$emsg
					));
					return;
			}
		//}

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
			if(!empty($p->saknr)){
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