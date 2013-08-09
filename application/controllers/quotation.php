<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Quotation extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}

	function index(){
		//$this->load->view('project');
	}

	function load(){
		$id = $this->input->post('id');
		$this->db->limit(1);
		$this->db->where('vbeln', $id);
		$query = $this->db->get('vbak');
		if($query->num_rows()>0){
			$result_data = $query->first_row('array');
			$result_data['id'] = $result_data['vbeln'];

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
		$tbName = 'vbak';
		//$tbName2 = 'jobp';
/*
		function createQuery($_this){
			$query = $_this->input->post('query');
			if(isset($query) && strlen($query)>0){
				$_this->db->or_like('code', $query);
			}
		}

		createQuery($this);
		$this->db->select('id');*/
		//$totalCount1 = $this->db->count_all_results($tbName1);
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
	
	function loads_pp(){
		$tbName = 'payp';
		//$tbName2 = 'jobp';
/*
		function createQuery($_this){
			$query = $_this->input->post('query');
			if(isset($query) && strlen($query)>0){
				$_this->db->or_like('code', $query);
			}
		}

		createQuery($this);
		$this->db->select('id');*/
		//$totalCount1 = $this->db->count_all_results($tbName1);
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
	
	function loads_pp(){
		$tbName = 'vbap';
		//$tbName2 = 'jobp';
/*
		function createQuery($_this){
			$query = $_this->input->post('query');
			if(isset($query) && strlen($query)>0){
				$_this->db->or_like('code', $query);
			}
		}

		createQuery($this);
		$this->db->select('id');*/
		//$totalCount1 = $this->db->count_all_results($tbName1);
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
			$this->db->where('vbeln', $id);
			$query = $this->db->get('vbak');
		}

		$formData = array(
			'vbeln' => $this->input->post('vbeln'),
			'bldat' => $this->input->post('bldat'),
			'statu' => $this->input->post('statu'),
			'txz01' => $this->input->post('txz01'),
			'jobnr' => $this->input->post('jobnr'),
			'auart' => $this->input->post('auart'),
			'reanr' => $this->input->post('reanr'),
			'refnr' => $this->input->post('refnr'),
			'ptype' => $this->input->post('ptype'),
			'taxnr' => $this->input->post('taxnr'),
			'lidat' => $this->input->post('lidat'),
			'kunnr' => $this->input->post('kunnr'),
			'netwr' => $this->input->post('netwr'),
			'beamt' => $this->input->post('beamt'),
			'dismt' => $this->input->post('dismt'),
			'taxpr' => $this->input->post('taxpr'),
			'salnr' => $this->input->post('salnr'),
			'ctype' => $this->input->post('ctype'),
			'exchg' => $this->input->post('exchg')
		);
		
		  $this->db->set('erdat', 'NOW()', false);
		  $this->db->set('ernam', 'test');
		
		if (!empty($query) && $query->num_rows() > 0){
			$this->db->where('vbeln', $id);
			$this->db->update('vbak', $formData);
		}else{
			$this->db->insert('vbak', $formData);
		}

		echo json_encode(array(
			'success'=>true,
			'data'=>$_POST
		));
	}

	function remove(){
		$id = $this->input->post('id');
		$this->db->where('vbeln', $id);
		$query = $this->db->delete('vbak');
		echo json_encode(array(
			'success'=>true,
			'data'=>$id
		));
	}

}