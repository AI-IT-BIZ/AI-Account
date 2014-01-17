<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mattrans extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}

	function index(){
		$this->load->view('mattrans');
	}

	function loads(){
		$tbName = 'trko';
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
			'trdoc' => $this->input->post('trdoc'),
			'bldat' => $this->input->post('bldat'),
			/*'maetx' => $this->input->post('maetx'),
			'mtart' => $this->input->post('mtart'),
			'meins' => $this->input->post('meins'),
			'saknr' => $this->input->post('saknr'),*/
			'beqty' => floatval($this->input->post('beqty')),
			'beval' => floatval($this->input->post('beval'))
			/*'cosav' => $this->input->post('cosav'),
			'enqty' => $this->input->post('enqty'),		
			'enval' => $this->input->post('enval'),
			'cost1' => $this->input->post('cost1'),
			'cost2' => $this->input->post('cost2'),
			'cost3' => $this->input->post('cost3'),*/
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