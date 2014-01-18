<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Unit extends CI_Controller {

	function __construct()
	{
		parent::__construct();

	}

	function index(){
		//$this->phxview->RenderView('Customertype');
		//$this->phxview->RenderLayout('default');
	}
	
	function load(){
		//$this->db->set_dbprefix('v_');
		$id = $this->input->post('id');
		$this->db->limit(1);
		$this->db->where('meins', $id);
		$query = $this->db->get('unit');
		if($query->num_rows()>0){
			$result_data = $query->first_row('array');
			$result_data['id'] = $result_data['meins'];
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
		//$this->db->set_dbprefix('v_');
		$tbName = 'unit';
		
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
		
		//start transaction
		//$this->db->trans_start();  
		
		// ลบ receipt item ภายใต้ id ทั้งหมด
		if(db_helper_is_mssql($_this)){
		$this->db->where('1=1');
		$this->db->delete('unit');
		}
		if(db_helper_is_mysql($_this)){
		$this->db->truncate('unit');
		}
		//$this->db->delete('ktyp');

		// เตรียมข้อมูล payment item
		$unit = $this->input->post('unit');
		$item_array = json_decode($unit);
		
		if(!empty($unit) && !empty($item_array)){
			// loop เพื่อ insert payment item ที่ส่งมาใหม่
			$item_index = 0;
		foreach($item_array AS $p){
			$this->db->insert('unit', array(
				'meins'=>$p->meins,
				'metxt'=>$p->metxt
			));
	    	}
		}

		echo json_encode(array(
			'success'=>true,
			'data'=>$_POST
		));
	}

}