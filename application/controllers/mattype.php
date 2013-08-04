<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mattype extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}

	function index(){
		$this->load->view('mattype');
	}

	function loads(){
		$tbName = 'mtyp';
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

		$formData = array(
			'mtart' => $this->input->post('mtart'),
			'matxt' => $this->input->post('matxt')
		);
		/*if ($query->num_rows() > 0){
			$this->db->where($tbPK, $id);
			$this->db->set('update_date', 'NOW()', false);
			$this->db->set('update_by', $sess_user_id);
			$this->db->update($tbName, $formData);
		}else{
		 */
			//$this->db->set('erdat', 'NOW()', false);
			//$this->db->set('ernam', 'test');
			$this->db->insert('mtyp', $formData);
		//}

		echo json_encode(array(
			'success'=>true,
			'data'=>$_POST
		));
	}

}