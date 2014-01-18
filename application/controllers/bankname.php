<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bankname extends CI_Controller {

	function __construct()
	{
		parent::__construct();

	}


	function index(){
		//$this->phxview->RenderView('Bankname');
		//$this->phxview->RenderLayout('default');
	}
	
	function load(){
		$this->db->set_dbprefix('v_');
		$id = $this->input->post('id');
		$this->db->limit(1);
		
		$this->db->where('bcode', $id);
		$query = $this->db->get('bnam');
		if($query->num_rows()>0){
			$result_data = $query->first_row('array');
			
			$result_data['id'] = $result_data['bcode'];

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
		$tbName = 'bnam';
		
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
		// ลบ receipt item ภายใต้ id ทั้งหมด
		if(db_helper_is_mssql($_this)){
			$this->db->where('1=1');
			$this->db->delete('bnam');
		}
		if(db_helper_is_mysql($_this)){
			$this->db->truncate('bnam');
		}

		// เตรียมข้อมูล payment item
		$bnam = $this->input->post('bnam');
		$item_array = json_decode($bnam);
		
		if(!empty($bnam) && !empty($item_array)){
			// loop เพื่อ insert payment item ที่ส่งมาใหม่
			$item_index = 0;
		foreach($item_array AS $p){
			$this->db->insert('bnam', array(
				'bcode'=>$p->bcode,
				'bname'=>$p->bname,
				'saknr'=>$p->saknr,
				'addrs'=>$p->addrs
			));
	    	}
		}

		echo json_encode(array(
			'success'=>true,
			'data'=>$_POST
		));
	}

function remove(){
		$id = $this->input->post('id');
		$this->db->where('bcode', $id);
		$query = $this->db->delete('bnam');
		echo json_encode(array(
			'success'=>true,
			'data'=>$id
		));
	}


}