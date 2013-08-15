<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pr extends CI_Controller {

	function __construct()
	{
		parent::__construct();
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
			echo json_encode(array(
				'success'=>true,
				'data'=>$query->first_row('array')
			));
		}else
			echo json_encode(array(
				'success'=>false
			));
	}

	function loads(){
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
			'totalCount'=>2//$totalCount
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
			'code' => $this->input->post('code'),
			'mtart' => $this->input->post('mtart'),
			'create_date' => $this->input->post('create_date')
		);
		if (!empty($query) && $query->num_rows() > 0){
			$this->db->where('id', $id);
			$this->db->set('update_date', 'NOW()', false);
			$this->db->set('update_by', 'test');
			$this->db->update('pr', $formData);
		}else{
			//$this->db->set('create_date', 'NOW()', false);
			$this->db->set('create_by', 'test');
			$this->db->insert('pr', $formData);
		}

		echo $this->db->last_query();

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

}