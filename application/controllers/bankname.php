<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bankname extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('code_model2','',TRUE);
		$this->load->model('email_service','',TRUE);
	}


	function index(){
		//$this->phxview->RenderView('Bankname');
		//$this->phxview->RenderLayout('default');
	}
	
	function load(){
		$this->db->set_dbprefix('v_');
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
		$this->db->set_dbprefix('v_');
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
		
		$id = $this->input->post('id');

		$query = null;
		$status_changed = false;
		$inserted_id = false;
		if(!empty($id)){
			$this->db->limit(1);
			$this->db->where('bcode', $id);
			$query = $this->db->get('bnam');
			}
		
		$formData = array(
			//'bcode' => $this->input->post('bcode'),
			'bname' => $this->input->post('bname'),
			'saknr' => $this->input->post('saknr'),
		);

		$current_username = XUMS::USERNAME();

		if (!empty($query) && $query->num_rows() > 0){
			$this->db->where('bcode', $id);
			$this->db->update('bnam', $formData);

		}else{
			$id = $this->code_model2->generate2('BK');
			$this->db->set('bcode', $id);
			//$this->db->set('erdat', 'NOW()', false);
			db_helper_set_now($this, 'erdat');
			$this->db->set('ernam', $current_username);
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