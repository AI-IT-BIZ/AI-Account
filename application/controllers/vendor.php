<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vendor extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}

	function index(){
		$this->phxview->RenderView('vendor');
		$this->phxview->RenderLayout('default');
	}

	function load(){
		$lifnr = $this->input->post('lifnr');
		$this->db->limit(1);
		$this->db->where('lifnr', $lifnr);
		$query = $this->db->get('lfa1');
		if($query->num_rows()>0){
			echo json_encode(array(
				'success'=>true,
				'data'=>$query->first_row('array')
			));
		}else
			echo json_encode(array(
				'success'=>false
			));
	}

	function loads(){
		$tbName = 'lfa1';
		
		$limit = $this->input->get('limit');
		$start = $this->input->get('start');
		if(isset($limit) && isset($start)) $this->db->limit($limit, $start);

		$query = $this->db->get($tbName);
		
		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>2//$totalCount
		));
	}

	function save(){
		
		$lifnr = $this->input->post('lifnr');
		$query = null;
		if(!empty($lifnr)){
			$this->db->limit(1);
			$this->db->where('lifnr', $lifnr);
			$query = $this->db->get('lfa1');
		}
		
		$formData = array(
			'lifnr' => $this->input->post('lifnr'),
			'name1' => $this->input->post('name1'),
			
			'adr01' => $this->input->post('adr01'),
			'vtype' => $this->input->post('vtype'),
			
			'distr' => $this->input->post('distr'),
			'pstlz' => $this->input->post('pstlz'),
			'crdit' => $this->input->post('crdit'),
			
			'telf1' => $this->input->post('telf1'),
			'disct' => $this->input->post('disct'),
			
			'telfx' => $this->input->post('telfx'),
			
			'email' => $this->input->post('email'),
			
			'pson1' => $this->input->post('pson1'),
			'apamt' => $this->input->post('apamt'),
			
			'taxid' => $this->input->post('taxid'),
			'begin' => $this->input->post('begin'),
			
			'saknr' => $this->input->post('saknr'),
			'endin' => $this->input->post('endin'),
			
			'taxnr' => $this->input->post('taxnr'),
			'retax' => $this->input->post('retax'),
			
			'sgtxt' => $this->input->post('sgtxt')
			
		);
		if (!empty($query) && $query->num_rows() > 0){
			$this->db->where('lifnr', $lifnr);
			$this->db->update('lfa1', $formData);
		}else{
			$this->db->set('erdat', 'NOW()', false);
			$this->db->set('ernam', 'somwang');
			$this->db->insert('lfa1', $formData);
		}

		echo json_encode(array(
			'success'=>true,
			'data'=>$_POST
		));
	}

	function remove(){
		$lifnr = $this->input->post('lifnr');
		$this->db->where('lifnr', $lifnr);
		$query = $this->db->delete('lfa1');
		echo json_encode(array(
			'success'=>true,
			'data'=>$lifnr
		));
	}


    
	public function loads_combo($tbName,$tbPK,$tbTxt){
		/*$tbName = 'mtyp';
		$tbPK = 'mtart';*/
		
		$tbName = $tbName;
		$tbPK = $tbPK;
		$tbTxt = $tbTxt;

		$query = $this->input->post('query');

		$totalCount = $this->db->count_all_results($tbName);


		if(!empty($query) && $query!=''){
			$this->db->or_like($tbTxt, $query);
			$this->db->or_like($tbPK, $query);
		}

		//$this->db->order_by($_POST['sort'], $_POST['dir']);
		$query = $this->db->get($tbName);

		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$totalCount
		));
	}

}