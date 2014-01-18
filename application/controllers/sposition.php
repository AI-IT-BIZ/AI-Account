<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sposition extends CI_Controller {

	function __construct()
	{
		parent::__construct();

	}


	function index(){
		//$this->phxview->RenderView('Sdistrict');
		//$this->phxview->RenderLayout('default');
	}
	
	function load(){
		//$this->db->set_dbprefix('v_');
		$id = $this->input->post('id');
		$this->db->limit(1);
		$this->db->where('depnr', $id);
		$query = $this->db->get('depn');
		if($query->num_rows()>0){
			$result_data = $query->first_row('array');
			$result_data['id'] = $result_data['depnr'];
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
		$tbName = 'posi';
		
		$limit = $this->input->get('limit');
		$start = $this->input->get('start');
		if(isset($limit) && isset($start)) $this->db->limit($limit, $start);

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
		
		//$this->db->delete('ktyp');

		// เตรียมข้อมูล payment item
		$posi = $this->input->post('posi');
		$item_array = json_decode($posi);
		
		if(!empty($posi) && !empty($item_array)){
			// ลบ receipt item ภายใต้ id ทั้งหมด
			if(db_helper_is_mssql($_this)){
			$this->db->where('1=1');
		    $this->db->delete('posi');
			}
			if(db_helper_is_mysql($_this)){
		    $this->db->truncate('posi');
			}
			// loop เพื่อ insert payment item ที่ส่งมาใหม่
			$item_index = 0;
		foreach($item_array AS $p){
			$this->db->insert('posi', array(
				'depnr'=>$p->depnr,
				'deptx'=>$p->deptx,
				'posnr'=>$p->posnr,
				'postx'=>$p->postx
			));
	    	}
		}

		echo json_encode(array(
			'success'=>true,
			'data'=>$_POST
		));
	}
	
	function loads_dep(){
		$tbName = 'depn';
		
		$limit = $this->input->get('limit');
		$start = $this->input->get('start');
		if(isset($limit) && isset($start)) $this->db->limit($limit, $start);

		$query = $this->db->get($tbName);
		//echo $this->db->last_query();
		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$query->num_rows()
		));
	}
	
	function save_dep(){
		//echo "vendor type";
		
		//start transaction
		//$this->db->trans_start();  
		
		//$this->db->delete('ktyp');

		// เตรียมข้อมูล payment item
		$depn = $this->input->post('depn');
		$item_array = json_decode($depn);
		
		if(!empty($depn) && !empty($item_array)){
			// ลบ receipt item ภายใต้ id ทั้งหมด
		if(db_helper_is_mssql($_this)){
		$this->db->where('1=1');
		$this->db->delete('depn');
		}
		if(db_helper_is_mysql($_this)){
		$this->db->truncate('depn');
		}
			// loop เพื่อ insert payment item ที่ส่งมาใหม่
			$item_index = 0;
		foreach($item_array AS $p){
			$this->db->insert('depn', array(
				'depnr'=>$p->depnr,
				'deptx'=>$p->deptx
			));
	    	}
		}

		echo json_encode(array(
			'success'=>true,
			'data'=>$_POST
		));
	}
}