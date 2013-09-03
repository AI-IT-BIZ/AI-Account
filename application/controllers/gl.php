<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GL extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}

	function index(){
		$this->load->view('gl');
	}

	function loads(){
		$tbName = 'glno';
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
			'totalCount'=>$totalCount
		));
	}

	function save(){

		$formData = array(
			'saknr' => $this->input->post('saknr'),
			'sgtxt' => $this->input->post('sgtxt'),
			'entxt' => $this->input->post('entxt'),
			'gltyp' => $this->input->post('gltyp'),
			'erdat' => $this->input->post('erdat'),
			'ernam' => $this->input->post('ernam'),
			'glgrp' => $this->input->post('glgrp'),
			'gllev' => $this->input->post('gllev'),
			'xloev' => $this->input->post('xloev'),
			'debit' => $this->input->post('debit'),
			'credi' => $this->input->post('credi'),
			'under' => $this->input->post('under'),
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
			$this->db->insert('gl', $formData);
		//}

		echo json_encode(array(
			'success'=>true,
			'data'=>$_POST
		));
	}

}