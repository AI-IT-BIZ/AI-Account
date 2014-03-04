<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customertype extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('code_model2','',TRUE);

	}


	function index(){
		$this->phxview->RenderView('Customertype');
		$this->phxview->RenderLayout('default');
	}
	
	function load(){
		$this->db->set_dbprefix('v_');
		$id = $this->input->post('id');
		$this->db->limit(1);
		$this->db->where('ktype', $id);
		$query = $this->db->get('ktyp');
		if($query->num_rows()>0){
			$result_data = $query->first_row('array');
			$result_data['id'] = $result_data['ktype'];
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
		$this->db->set_dbprefix('v_');
		$tbName = 'ktyp';
		
		
		$totalCount = $this->db->count_all_results($tbName);

		//createQuery($this);
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
			$this->db->where('ktype', $id);
			$query = $this->db->get('ktyp');
			}
		
		$formData = array(
			'custx' => $this->input->post('custx'),
			'saknr' => $this->input->post('saknr')
		);

		$current_username = XUMS::USERNAME();

		if (!empty($query) && $query->num_rows() > 0){
			$this->db->where('ktype', $id);
			$this->db->update('ktyp', $formData);

		}else{
			$id = $this->code_model2->generate2('CT');
			$this->db->set('ktype', $id);
			//$this->db->set('erdat', 'NOW()', false);
			db_helper_set_now($this, 'erdat');
			$this->db->set('ernam', $current_username);
			$this->db->insert('ktyp', $formData);

		}

		echo json_encode(array(
			'success'=>true,
			'data'=>$_POST
		));
	}

    function remove(){
		$id = $this->input->post('id');
		$this->db->where('ktype', $id);
		$query = $this->db->delete('ktyp');
		echo json_encode(array(
			'success'=>true,
			'data'=>$id
		));
	}

}