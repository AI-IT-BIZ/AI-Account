<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Saleperson extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('code_model2','',TRUE);
	}

	function index(){
		//$this->phxview->RenderView('saleperson');
		//$this->phxview->RenderLayout('default');
	}

	function load(){
		$this->db->set_dbprefix('v_');
		$salnr = $this->input->post('salnr');
		$this->db->limit(1);
		$this->db->where('salnr', $salnr);
		$query = $this->db->get('psal');
		
		if($query->num_rows()>0){
			$result_data = $query->first_row('array');
			$result_data['id'] = $result_data['salnr'];
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
		$tbName = 'psal';
		
		$totalCount = $this->db->count_all_results($tbName);
		
		$limit = $this->input->get('limit');
		$start = $this->input->get('start');
		if(isset($limit) && isset($start)) 
		$this->db->limit($limit, $start);

		$query = $this->db->get($tbName);
		//echo $this->db->last_query();
		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$totalCount
		));
	}

	function save(){
		
		$salnr = $this->input->post('salnr');
		$query = null;
		if(!empty($salnr)){
			$this->db->limit(1);
			$this->db->where('salnr', $salnr);
			$query = $this->db->get('psal');
		}
		//$stdat = "2013-08-20";
		$stdat = date_create($this->input->post('stdat'));
		$stdat = date_format($stdat, 'Y-m-d');
		
		$endat = date_create($this->input->post('endat'));
		$endat = date_format($endat, 'Y-m-d');
		
		$formData = array(
			//'salnr' => $this->input->post('salnr'),
			'empnr' => $this->input->post('empnr'),
			'ctype' => $this->input->post('ctype'),
			'name1' => $this->input->post('name1'),
			'goals' => $this->input->post('goals'),
			'stdat' => $stdat,
			'endat' => $endat,
			'percs' => $this->input->post('percs')
			
		);
		
		$current_username = XUMS::USERNAME();
		if (!empty($query) && $query->num_rows() > 0){
			$this->db->where('salnr', $salnr);
			$this->db->update('psal', $formData);
		}else{
			$id = $this->code_model2->generate2('SP');
			$this->db->set('salnr', $id);
			$this->db->set('erdat', 'NOW()', false);
			$this->db->set('ernam', $current_username);
			$this->db->insert('psal', $formData);
		}

		echo json_encode(array(
			'success'=>true,
			'data'=>$_POST
		));
	}

	function remove(){
		$salnr = $this->input->post('salnr');
		$this->db->where('salnr', $salnr);
		$query = $this->db->delete('psal');
		echo json_encode(array(
			'success'=>true,
			'data'=>$salnr
		));
	}


    public function loads_combo($tb,$pk,$like){
    	/*
		$tbName = 'ktyp';
		$tbPK = 'ktype';
		$tbLike = 'custx';
		*/
		
		$tbName = $tb;
		$tbPK = $pk;
		$tbLike = $like;

		$query = $this->input->post('query');

		$totalCount = $this->db->count_all_results($tbName);


		if(!empty($query) && $query!=''){
			$this->db->or_like($tbLike, $query);
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