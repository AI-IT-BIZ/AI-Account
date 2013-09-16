<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bankname extends CI_Controller {

	function __construct()
	{
		parent::__construct();

	}


	function index(){
		//$this->phxview->RenderView('Bankname');
		//$this->phxview->RenderLayout('default');
	}
	
	function load(){
		//$this->db->set_dbprefix('v_');
		$id = $this->input->post('id');
		$this->db->limit(1);
		
		$this->db->where('bcode', $id);
		$query = $this->db->get('bnam');
		if($query->num_rows()>0){
			$result_data = $query->first_row('array');
			
			$result_data['id'] = $result_data['bcode'];

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
		$tbName = 'bnam';
		
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
	
	function save(){
		//$this->db->set_dbprefix('v_');
		$id = $this->input->post('id');
		$query = null;
		if(!empty($id)){
			$this->db->limit(1);
			$this->db->where('bcode', $id);
			$query = $this->db->get('bnam');
		}

		$formData = array(
			'bcode' => $this->input->post('bcode'),
			'bname' => $this->input->post('bname'),
			'bthai' => $this->input->post('bthai'),
			'saknr' => $this->input->post('saknr'),
			'addrs' => $this->input->post('addrs')
		);
		  //$this->db->set('erdat', 'NOW()', false);
		  //$this->db->set('ernam', 'test');
		  
		if (!empty($query) && $query->num_rows() > 0){
			$this->db->where('bcode', $id);
			$this->db->set('updat', 'NOW()', false);
			$this->db->set('upnam', 'test');
			$this->db->update('bnam', $formData);
		}else{
			//$this->db->set('jobnr', $this->code_model->generate('PJ',
			//$this->input->post('bldat')));
			$this->db->set('erdat', 'NOW()', false);
			$this->db->set('ernam', 'test');
			$this->db->insert('bnam', $formData);
		}

		echo json_encode(array(
			'success'=>true,
			'data'=>$_POST
		));
	}

function remove(){
		$id = $this->input->post('id');
		$this->db->where('bcode', $id);
		$query = $this->db->delete('bnam');
		echo json_encode(array(
			'success'=>true,
			'data'=>$id
		));
	}


}