<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sdistrict extends CI_Controller {

	function __construct()
	{
		parent::__construct();

	}


	function index(){
		$this->phxview->RenderView('Sdistrict');
		$this->phxview->RenderLayout('default');
	}

	function loads(){
		$tbName = 'dist';
		$totalCount = $this->db->count_all_results($tbName);
		$limit = $this->input->get('limit');
		$start = $this->input->get('start');
		if(isset($limit) && isset($start)) $this->db->limit($limit, $start);

		$query = $this->db->get($tbName);
		//echo $this->db->last_query();
		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$totalCount
		));
	}


}