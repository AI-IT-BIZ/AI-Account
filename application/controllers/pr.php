<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pr extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->model('code_model','',TRUE);
	}

	function test_get_code(){
		echo $this->code_model->generate('PJ', '2013-08-22');
	}

	function index(){
		$this->phxview->RenderView('pr');
		$this->phxview->RenderLayout('default');
	}

	function load(){
		$id = $this->input->post('id');
		$this->db->limit(1);
		$this->db->where('id', $id);
		$query = $this->db->get('pr');
		if($query->num_rows()>0){
			$result = $query->first_row('array');
			$result['create_date']=substr($result['create_date'], 0, 10);

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
		//$this->db->set_dbprefix('v_');

		$tbName = 'pr';
/*
		function createQuery($_this){
			$query = $_this->input->post('query');
			if(isset($query) && strlen($query)>0){
				$_this->db->or_like('code', $query);
			}
		}

		createQuery($this);
		$this->db->select('id');
		$totalCount = $this->db->count_all_results($tbName);
*/
//		createQuery($this);
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
		$id = $this->input->post('id');
		$query = null;
		if(!empty($id)){
			$this->db->limit(1);
			$this->db->where('id', $id);
			$query = $this->db->get('pr');
		}

		$formData = array(
			//'code' => $this->input->post('code'),
			'mtart' => $this->input->post('mtart'),
			'create_date' => $this->input->post('create_date')
		);

		// start transaction
		$this->db->trans_start();

		if (!empty($query) && $query->num_rows() > 0){
			$this->db->where('id', $id);
			$this->db->set('update_date', 'NOW()', false);
			$this->db->set('update_by', 'test');
			$this->db->update('pr', $formData);
		}else{
			$this->db->set('code', $this->code_model->generate('PR', $this->input->post('create_date')));
			$this->db->set('create_by', 'test');
			$this->db->insert('pr', $formData);

			$id = $this->db->insert_id();
		}

		// ลบ pr_item ภายใต้ id ทั้งหมด
		$this->db->where('pr_id', $id);
		$this->db->delete('pr_item');

		// เตรียมข้อมูล pr item
		$pr_item = $this->input->post('pr_item');
		$pr_item_array = json_decode($pr_item);

		// loop เพื่อ insert pr_item ที่ส่งมาใหม่
		foreach($pr_item_array AS $p){
			$this->db->insert('pr_item', array(
				'pr_id'=>$id,
				'code'=>$p->code,
				'price'=>$p->price,
				'amount'=>$p->amount
			));
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
		$this->db->where('id', $id);
		$query = $this->db->delete('pr');
		echo json_encode(array(
			'success'=>true,
			'data'=>$id
		));
	}

	///////////////////////////////////////////////
	// PR ITEM
	///////////////////////////////////////////////


	function loads_pr_item(){

		$pr_id = $this->input->get('pr_id');
		$this->db->where('pr_id', $pr_id);

		$query = $this->db->get('pr_item');
		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$query->num_rows()
		));
	}

}