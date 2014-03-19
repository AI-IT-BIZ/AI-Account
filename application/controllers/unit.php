<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Unit extends CI_Controller {

	function __construct()
	{
		parent::__construct();

	}

	function index(){
		//$this->phxview->RenderView('Customertype');
		//$this->phxview->RenderLayout('default');
	}
	
	function load(){
		//$this->db->set_dbprefix('v_');
		$id = $this->input->post('id');
		$this->db->limit(1);
		$this->db->where('meins', $id);
		$query = $this->db->get('unit');
		if($query->num_rows()>0){
			$result_data = $query->first_row('array');
			$result_data['id'] = $result_data['meins'];
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
		$tbName = 'unit';
		
		$totalCount = $this->db->count_all_results($tbName);
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
		$status_changed = false;
		$inserted_id = false;
		if(!empty($id)){
			$this->db->limit(1);
			$this->db->where('meins', $id);
			$query = $this->db->get('unit');
			}
		
		$formData = array(
			'meins' => $this->input->post('meins'),
			'metxt' => $this->input->post('metxt')
		);

		$current_username = XUMS::USERNAME();

		if (!empty($query) && $query->num_rows() > 0){
			$this->db->where('meins', $id);
			$this->db->update('unit', $formData);

		}else{
			//$id = $this->code_model2->generate2('BK');
			//$this->db->set('bcode', $id);
			//$this->db->set('erdat', 'NOW()', false);
			db_helper_set_now($this, 'erdat');
			$this->db->set('ernam', $current_username);
			$this->db->insert('unit', $formData);

		}

		echo json_encode(array(
			'success'=>true,
			'data'=>$_POST
		));
	}

}