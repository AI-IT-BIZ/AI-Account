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
	
	function load(){
		$this->db->set_dbprefix('v_');
		$id = $this->input->post('id');
		$this->db->limit(1);
		$this->db->where('ktype', $id);
		$query = $this->db->get('ktyp');
		if($query->num_rows()>0){
			$result_data = $query->first_row('array');
			$result_data['id'] = $result_data['ktype'];
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
		$tbName = 'ktyp';
		
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
		$ktyp = $this->input->post('ktyp');
		$item_array = json_decode($ktyp);
		$result_array = json_decode($ktyp);
		if(!empty($ktyp) && !empty($item_array)){
			$i=0;
			foreach($item_array AS $p){
				$j=0;
				foreach($result_array AS $o){
					if($p->ktype == $o->ktype && $i!=$j){
						$emsg = 'Cannot Save Customer type '.$p->ktype.' is duplicated';
					    echo json_encode(array(
						  'success'=>false,
						  'message'=>$emsg
					    ));
					    return;
					}$j++;
				}$i++;
			}
		} 
		
		// ลบ receipt item ภายใต้ id ทั้งหมด
		if(db_helper_is_mssql($this)){
		  $this->db->where('1=1');
		  $this->db->delete('ktyp');
		}
		if(db_helper_is_mysql($this)){
		  $this->db->truncate('ktyp');
		}
		//$this->db->delete('ktyp');

		// เตรียมข้อมูล payment item
		//$ktyp = $this->input->post('ktyp');
		//$item_array = json_decode($ktyp);
		
		if(!empty($ktyp) && !empty($item_array)){
			// loop เพื่อ insert payment item ที่ส่งมาใหม่
			$item_index = 0;
		foreach($item_array AS $p){
			echo $p->ktype;
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