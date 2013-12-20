<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->output->set_header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
		$this->output->set_header('Cache-Control: post-check=0, pre-check=0', FALSE);
		$this->output->set_header('Cache-Control: max-age=-1281, public, must-revalidate, proxy-revalidate', FALSE);
		$this->output->set_header('Pragma: no-cache');
	}

	function index()
	{
		$userState = XUMS::getUserState();
		if(empty($userState) || empty($userState->uname))
			redirect(site_url('ums/login', true));

		$this->phxview->RenderView('index');
		$this->phxview->RenderLayout('default');
	}

	function loads(){
		$tbName = 'pr';

		function createQuery($_this){
			$query = $_this->input->post('query');
			if(isset($query) && strlen($query)>0){
				$_this->db->or_like('code', $query);
			}
		}

		createQuery($this);
		$this->db->select('id');
		$totalCount = $this->db->count_all_results($tbName);

		createQuery($this);
		$limit = $this->input->post('limit');
		$start = $this->input->post('start');
		if(isset($limit) && isset($start)) $this->db->limit($limit, $start);

		$sort = $this->input->post('sort');
		$dir = $this->input->post('dir');
		$this->db->order_by($sort, $dir);
		$query = $this->db->get($tbName);
		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$totalCount
		));
	}

}