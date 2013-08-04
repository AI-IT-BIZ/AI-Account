<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}

	function index(){
		$this->load->view('customer');
	}

	function loads(){
		$tbName = 'kna1';
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
			'kunnr' => $this->input->post('kunnr'),
			'name1' => $this->input->post('name1'),
			//'name2' => $this->input->post('name2'),
			'adr01' => $this->input->post('adr01'),
			//'adr02' => $this->input->post('adr02'),
			'distr' => $this->input->post('distr'),
			'telf1' => $this->input->post('telf1'),
			'telfx' => $this->input->post('telfx'),		
			'enval' => $this->input->post('pson1'),
			'cost1' => $this->input->post('taxbs'),
			
			'saknr' => $this->input->post('saknr'),
			'taxnr' => $this->input->post('taxnr'),
			'pleve' => $this->input->post('pleve'),
			'retax' => $this->input->post('retax'),
			'crdit' => $this->input->post('crdit'),
			'disct' => $this->input->post('disct'),
			'pappr' => $this->input->post('pappr'),
			'endin' => $this->input->post('endin'),
			'sgtxt' => $this->input->post('sgtxt'),
			'ktype' => $this->input->post('ktype')
			);
			
		/*if ($query->num_rows() > 0){
			$this->db->where($tbPK, $id);
			$this->db->set('update_date', 'NOW()', false);
			$this->db->set('update_by', $sess_user_id);
			$this->db->update($tbName, $formData);
		}else{
		 */
			$this->db->set('erdat', 'NOW()', false);
			$this->db->set('ernam', 'test');
			$this->db->insert('mara', $formData);
		//}

		echo json_encode(array(
			'success'=>true,
			'data'=>$_POST
		));
	}

}