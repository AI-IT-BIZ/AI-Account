<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customertype extends CI_Controller {

	function __construct()
	{
		parent::__construct();

	}


	function index(){
		$this->phxview->RenderView('Customertype');
		$this->phxview->RenderLayout('default');
	}

	function loads(){
		$this->db->set_dbprefix('v_');
		$tbName = 'v_ktyp';
		
		$limit = $this->input->get('limit');
		$start = $this->input->get('start');
		if(isset($limit) && isset($start)) $this->db->limit($limit, $start);

		//$sort = $this->input->post('sort');
		//$dir = $this->input->post('dir');
		//$this->db->order_by($sort, $dir);

		$query = $this->db->get($tbName);
		//echo $this->db->last_query();
		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$query->num_rows()
		));
	}


	function save(){
		//echo "vendor type";
		
		// start transaction
		//$this->db->trans_start();  
		
		// ลบ receipt item ภายใต้ id ทั้งหมด
		$this->db->truncate('ktyp'); 

		// เตรียมข้อมูล payment item
		$ktyp = $this->input->post('ktyp');
		$item_array = json_decode($ktyp);
		
		if(!empty($ktyp) && !empty($item_array)){
			// loop เพื่อ insert payment item ที่ส่งมาใหม่
			$item_index = 0;
		foreach($item_array AS $p){
			$this->db->insert('ktyp', array(
				'ktype'=>$p->ktype,
				'custx'=>$p->custx,
				'saknr'=>$p->saknr
			));
	    	}
		}

		echo json_encode(array(
			'success'=>true,
			'data'=>$_POST
		));
	}

}