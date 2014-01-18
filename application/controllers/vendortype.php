<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vendortype extends CI_Controller {

	function __construct()
	{
		parent::__construct();

	}


	function index(){
		$this->phxview->RenderView('Vendortype');
		$this->phxview->RenderLayout('default');
	}

	function load(){
		$this->db->set_dbprefix('v_');
		$id = $this->input->post('id');
		$this->db->limit(1);
		$this->db->where('vtype', $id);
		$query = $this->db->get('vtyp');
		if($query->num_rows()>0){
			$result_data = $query->first_row('array');
			$result_data['id'] = $result_data['vtype'];
			echo json_encode(array(
				'success'=>true,
				'data'=>$result_data
			));
		}else
			echo json_encode(array(
				'success'=>false
			));
	}

	function loads(){
		$this->db->set_dbprefix('v_');
		$tbName = 'vtyp';

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
		if(db_helper_is_mssql($this)){
			$this->db->where('1=1');
			$this->db->delete('vtyp');
		}
		if(db_helper_is_mysql($this)){
			$this->db->truncate('vtyp');
		}

		// เตรียมข้อมูล payment item
		$vtyp = $this->input->post('vtyp');
		$item_array = json_decode($vtyp);

		if(!empty($vtyp) && !empty($item_array)){
			// loop เพื่อ insert payment item ที่ส่งมาใหม่
			$item_index = 0;
		foreach($item_array AS $p){
			$this->db->insert('vtyp', array(
				'vtype'=>$p->vtype,
				'ventx'=>$p->ventx,
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