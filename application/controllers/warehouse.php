<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Warehouse extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}

	function index(){
		$this->load->view('warehouse');
	}

	function load(){
		$id = $this->input->post('id');
		$this->db->limit(1);
		$this->db->where('warnr', $id);
		$query = $this->db->get('mwar');
		if($query->num_rows()>0){
			$result_data = $query->first_row('array');
			$result_data['id'] = $result_data['warnr'];

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
		$tbName = 'mwar';
/*
		function createQuery($_this){
			$query = $_this->input->post('query');
			if(isset($query) && strlen($query)>0){
				$_this->db->or_like('code', $query);
			}
		}

		createQuery($this);
		$this->db->select('id');*/
		$totalCount = $this->db->count_all_results($tbName);

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
			'totalCount'=>$totalCount
		));
	}

	function save(){
		$id = $this->input->post('id');
		$query = null;
		if(!empty($id)){
			$this->db->limit(1);
			$this->db->where('warnr', $id);
			$query = $this->db->get('mwar');
		}

		$formData = array(
			'warnr' => $this->input->post('warnr'),
			'watxt' => $this->input->post('watxt')
		);
		if (!empty($query) && $query->num_rows() > 0){
			$this->db->where('warnr', $id);
			$this->db->update('mwar', $formData);
		}else{
			$this->db->insert('mwar', $formData);
		}

		echo json_encode(array(
			'success'=>true,
			'data'=>$_POST
		));
	}

	function remove(){
		$id = $this->input->post('id');
		$this->db->where('warnr', $id);
		$query = $this->db->delete('mwar');
		echo json_encode(array(
			'success'=>true,
			'data'=>$id
		));
	}

}