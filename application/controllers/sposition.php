<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sposition extends CI_Controller {

	function __construct()
	{
		parent::__construct();

	}


	function index(){
		//$this->phxview->RenderView('Sdistrict');
		//$this->phxview->RenderLayout('default');
	}
	
	function load(){
		$this->db->set_dbprefix('v_');
		$id = $this->input->post('id');
		//$id2 = $this->input->post('id2');
		$this->db->limit(1);
		$this->db->where('posnr', $id);
		//$this->db->where('posnr', $id2);
		$query = $this->db->get('posi');
		if($query->num_rows()>0){
			$result_data = $query->first_row('array');
			$result_data['id'] = $result_data['posnr'];
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
		$tbName = 'posi';
		$totalCount = $this->db->count_all_results($tbName);
		
		$limit = $this->input->get('limit');
		$start = $this->input->get('start');
		if(isset($limit) && isset($start)) $this->db->limit($limit, $start);

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
		$id2 = $this->input->post('depnr');

		$query = null;
		$status_changed = false;
		$inserted_id = false;
		if(!empty($id)){
			$this->db->limit(1);
			$this->db->where('depnr', $id2);
			$this->db->where('posnr', $id);
			$query = $this->db->get('posi');
			}
		
		$formData = array(
			'depnr' => $this->input->post('depnr'),
			//'deptx' => $this->input->post('deptx'),
			'posnr' => $this->input->post('posnr'),
			'postx' => $this->input->post('postx')
		);

		$current_username = XUMS::USERNAME();

		if (!empty($query) && $query->num_rows() > 0){
			$this->db->where('depnr', $id2);
			$this->db->where('posnr', $id);
			$this->db->update('posi', $formData);

		}else{
			//$id = $this->code_model2->generate2('CT');
			//$this->db->set('ktype', $id);
			//$this->db->set('erdat', 'NOW()', false);
			db_helper_set_now($this, 'erdat');
			$this->db->set('ernam', $current_username);
			$this->db->insert('posi', $formData);

		}

		echo json_encode(array(
			'success'=>true,
			'data'=>$_POST
		));
	}

    function remove(){
		$id = $this->input->post('id');
		$this->db->where('depnr', $id);
		$query = $this->db->delete('depn');
		echo json_encode(array(
			'success'=>true,
			'data'=>$id
		));
	}

    function load_dep(){
		//$this->db->set_dbprefix('v_');
		$id = $this->input->post('id');
		$this->db->limit(1);
		$this->db->where('depnr', $id);
		$query = $this->db->get('depn');
		if($query->num_rows()>0){
			$result_data = $query->first_row('array');
			$result_data['id'] = $result_data['depnr'];
			echo json_encode(array(
				'success'=>true,
				'data'=>$result_data
			));
		}else
			echo json_encode(array(
				'success'=>false
			));
	}
	
	function loads_dep(){
		$tbName = 'depn';
		
		$limit = $this->input->get('limit');
		$start = $this->input->get('start');
		if(isset($limit) && isset($start)) $this->db->limit($limit, $start);
		
		//$sort = $this->input->get('sort');
		//$dir = $this->input->get('dir');
		//$this->db->order_by($sort, $dir);

		$query = $this->db->get($tbName);
		//echo $this->db->last_query();
		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$query->num_rows()
		));
	}
	
	function save_dep(){
		$id = $this->input->post('id');

		$query = null;
		$status_changed = false;
		$inserted_id = false;
		if(!empty($id)){
			$this->db->limit(1);
			$this->db->where('depnr', $id);
			$query = $this->db->get('depn');
			}
		
		$formData = array(
			'depnr' => $this->input->post('depnr'),
			'deptx' => $this->input->post('deptx')
		);

		$current_username = XUMS::USERNAME();

		if (!empty($query) && $query->num_rows() > 0){
			$this->db->where('depnr', $id);
			$this->db->update('depn', $formData);

		}else{
			//$id = $this->code_model2->generate2('CT');
			//$this->db->set('ktype', $id);
			//$this->db->set('erdat', 'NOW()', false);
			db_helper_set_now($this, 'erdat');
			$this->db->set('ernam', $current_username);
			$this->db->insert('depn', $formData);

		}

		echo json_encode(array(
			'success'=>true,
			'data'=>$_POST
		));
	}
	
	function remove_dep(){
		$id = $this->input->post('id');
		$this->db->where('depnr', $id);
		$query = $this->db->delete('depn');
		echo json_encode(array(
			'success'=>true,
			'data'=>$id
		));
	}
}