<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer2 extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->model('code_model2','',TRUE);
	}

	function index(){
		$this->phxview->RenderView('customer2');
		$this->phxview->RenderLayout('default');
	}

	function load(){
		$kunnr = $this->input->post('kunnr');
		$this->db->limit(1);
		$this->db->where('kunnr', $kunnr);
		$query = $this->db->get('kna1');
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
		$tbName = 'kna1';
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
			'totalCount'=>2//$totalCount
		));
	}

	function save(){
		$kunnr = $this->input->post('kunnr');
		$query = null;
		if(!empty($kunnr)){
			$this->db->limit(1);
			$this->db->where('kunnr', $kunnr);
			$query = $this->db->get('kna1');
		}
		
		$formData = array(
			//'kunnr' => $this->input->post('kunnr'),
			'name1' => $this->input->post('name1'),
			
			'adr01' => $this->input->post('adr01'),
			'ktype' => $this->input->post('ktype'),
			
			'distx' => $this->input->post('distx'),
			'pstlz' => $this->input->post('pstlz'),
			'crdit' => $this->input->post('crdit'),
			
			'telf1' => $this->input->post('telf1'),
			'disct' => $this->input->post('disct'),
			
			'telfx' => $this->input->post('telfx'),
			'pleve' => $this->input->post('pleve'),
			
			'email' => $this->input->post('email'),
			
			'pson1' => $this->input->post('pson1'),
			'apamt' => $this->input->post('apamt'),
			
			'taxid' => $this->input->post('taxid'),
			'begin' => $this->input->post('begin'),
			
			'saknr' => $this->input->post('saknr'),
			'endin' => $this->input->post('endin'),
			
			'taxnr' => $this->input->post('taxnr'),
			
			'sgtxt' => $this->input->post('sgtxt')
			
		);
		if (!empty($query) && $query->num_rows() > 0){
			$this->db->where('kunnr', $kunnr);
			$this->db->update('kna1', $formData);
		}else{
			$this->db->set('kunnr', $this->code_model2->generate2('CS'));
			$this->db->set('erdat', 'NOW()', false);
			$this->db->set('ernam', 'somwang');
			$this->db->insert('kna1', $formData);
		}

		echo json_encode(array(
			'success'=>true,
			'data'=>$_POST
		));
	}

	function remove(){
		$kunnr = $this->input->post('kunnr');
		$this->db->where('kunnr', $kunnr);
		$query = $this->db->delete('kna1');
		echo json_encode(array(
			'success'=>true,
			'data'=>$kunnr
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