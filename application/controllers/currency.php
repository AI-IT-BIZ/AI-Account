<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Currency extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->model('code_model','',TRUE);
	}
	
	/*
	function test_get_code(){
		echo $this->code_model->generate('PR', '2013-05-22');
	}*/

	function index(){
		//$this->load->view('project');
		//$this->phxview->RenderView('jobk');
		//$this->phxview->RenderLayout('default');
	}

	function loads(){
		//$this->db->set_dbprefix('v_');
		$tbName = 'ctyp';

		$totalCount = $this->db->count_all_results($tbName);

		//createQuery($this);
		$limit = $totalCount;//$this->input->get('limit');
		$start = $this->input->get('start');
		$page = $totalCount / $limit;
		if(isset($limit) && isset($start)) $this->db->limit($limit, $start);

		//$sort = $this->input->post('sort');
		//$dir = $this->input->post('dir');
		//$this->db->order_by($sort, $dir);

		$query = $this->db->get($tbName);

		//echo $this->db->last_query();
		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$totalCount,
			'limit'=>$limit,
			'start'=>$start,
			'page'=>$page
		));
	}

	

}