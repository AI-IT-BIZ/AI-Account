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
	
	function load(){
		//$this->db->set_dbprefix('v_');
		$tbName = 'ctyp';
		
		$id = $this->input->post('id'); //exit;
				 
		$this->db->limit(1);
		$this->db->where('ctype', $id);
		$query = $this->db->get($tbName);
		if($query->num_rows()>0){
			$result_data = $query->first_row('array');
			//$result_data['id'] = $result_data['ctype'];
			
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
		//$this->db->set_dbprefix('v_');
		$tbName = 'ctyp';
		
		function createQuery($_this){
			$query = $_this->input->get('query');
			//echo $query;
			if(!empty($query)){
				$_this->db->where("(ctype LIKE '%$query%'
				OR curtx LIKE '%$query%')", NULL, FALSE);
			}
		}

		createQuery($this);
		$totalCount = $this->db->count_all_results($tbName);
		//echo $this->db->last_query();
/*
		createQuery($this);
		$limit = $this->input->get('limit');
		//$limit=$totalCount;
		$start = $this->input->get('start');
		//$page=$totalCount / 25;
		//if(isset($limit) && isset($start)) $this->db->limit($limit, $start);
*/
		createQuery($this);
		$limit = $this->input->get('limit');
		$start = $this->input->get('start');
		if(isset($limit) && isset($start)) $this->db->limit($limit, $start);

		$sort = $this->input->get('sort');
		$dir = $this->input->get('dir');
		$this->db->order_by($sort, $dir);
		
		$query = $this->db->get($tbName);

		//echo $this->db->last_query();
		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$totalCount//,
			//'limit'=>$limit,
			//'start'=>$start,
			//'page'=>$page
		));
	}

	

}