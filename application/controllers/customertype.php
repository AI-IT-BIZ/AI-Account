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


}