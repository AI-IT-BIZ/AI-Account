<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Journaltype extends CI_Controller {

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
		
		$this->db->where('ttype', $id);
		$query = $this->db->get('ttyp');
		if($query->num_rows()>0){
			$result_data = $query->first_row('array');
			
			$result_data['id'] = $result_data['ttype'];

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
		$tbName = 'ttyp';
		
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
			$this->db->where('ttype', $id);
			$query = $this->db->get('ttyp');
		}

		$formData = array(
			'ttype' => $this->input->post('ttype'),
			'typtx' => $this->input->post('typtx')
		);
		  //$this->db->set('erdat', 'NOW()', false);
		  //$this->db->set('ernam', 'test');
		  
		if (!empty($query) && $query->num_rows() > 0){
			$this->db->where('ttype', $id);
			$this->db->set('updat', 'NOW()', false);
			$this->db->set('upnam', 'test');
			$this->db->update('ttyp', $formData);
		}else{
			//$this->db->set('jobnr', $this->code_model->generate('PJ',
			//$this->input->post('bldat')));
			$this->db->set('erdat', 'NOW()', false);
			$this->db->set('ernam', 'test');
			$this->db->insert('ttyp', $formData);
		}

		echo json_encode(array(
			'success'=>true,
			'data'=>$_POST
		));
	}

function remove(){
		$id = $this->input->post('id');
		$this->db->where('ttype', $id);
		$query = $this->db->delete('ttyp');
		echo json_encode(array(
			'success'=>true,
			'data'=>$id
		));
	}


}