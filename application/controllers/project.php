<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Project extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->model('code_model','',TRUE);
	}
	
	/*
	function test_get_code(){
		echo $this->code_model->generate('PR', '2013-05-22');
	}*/

	function index(){
		//$this->load->view('project');
		//$this->phxview->RenderView('jobk');
		//$this->phxview->RenderLayout('default');
	}

	function load(){
		$this->db->set_dbprefix('v_');
		$id = $this->input->post('id');
		$this->db->limit(1);
		
		$this->db->where('jobnr', $id);
		$query = $this->db->get('jobk');
		if($query->num_rows()>0){
			$result_data = $query->first_row('array');
			
			$result_data['adr01'] .= $result_data['distx'].' '.$result_data['pstlz'].
			                         PHP_EOL.'Tel: '.$result_data['telf1'].PHP_EOL.'Fax: '.$result_data['telfx'].
									 PHP_EOL.'Email: '.$result_data['email'];
			
			$result_data['id'] = $result_data['jobnr'];

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
		$tbName = 'jobk';

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
		//$this->db->set_dbprefix('v_');
		$id = $this->input->post('id');
		$query = null;
		if(!empty($id)){
			$this->db->limit(1);
			$this->db->where('jobnr', $id);
			$query = $this->db->get('jobk');
		}

		$formData = array(
			//'jobnr' => $this->input->post('jobnr'),
			'jobtx' => $this->input->post('jobtx'),
			'jtype' => $this->input->post('jtype'),
			'bldat' => $this->input->post('bldat'),
			'statu' => $this->input->post('statu'),
			'txz01' => $this->input->post('txz01'),
			'salnr' => $this->input->post('salnr'),
			'stdat' => $this->input->post('stdat'),
			'endat' => $this->input->post('endat'),
			
			'datam' => $this->input->post('datam'),
			'kunnr' => $this->input->post('kunnr'),
			'pson1' => $this->input->post('pson1'),		
			'pramt' => $this->input->post('pramt'),
			'esamt' => $this->input->post('esamt')
		);
		  //$this->db->set('erdat', 'NOW()', false);
		  //$this->db->set('ernam', 'test');
		  
		if (!empty($query) && $query->num_rows() > 0){
			$this->db->where('jobnr', $id);
			$this->db->set('updat', 'NOW()', false);
			$this->db->set('upnam', 'test');
			$this->db->update('jobk', $formData);
		}else{
			$this->db->set('jobnr', $this->code_model->generate('PJ',
			$this->input->post('bldat')));
			$this->db->set('erdat', 'NOW()', false);
			$this->db->set('ernam', 'test');
			$this->db->insert('jobk', $formData);
		}

		echo json_encode(array(
			'success'=>true,
			'data'=>$_POST
		));
	}

    public function loads_tcombo(){
		$tbName = 'jtyp';
		$tbPK = 'jtype';

		$query = $this->input->post('query');

		$totalCount = $this->db->count_all_results($tbName);


		if(!empty($query) && $query!=''){
			$this->db->or_like('jobtx', $query);
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
	
	public function loads_scombo(){
		$tbName = 'apov';
		$tbPK = 'statu';

		$query = $this->input->post('query');

		$totalCount = $this->db->count_all_results($tbName);


		if(!empty($query) && $query!=''){
			$this->db->or_like('statx', $query);
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
	
	public function loads_ocombo(){
		$tbName = 'psal';
		$tbPK = 'salnr';

		$query = $this->input->post('query');

		$totalCount = $this->db->count_all_results($tbName);

		if(!empty($query) && $query!=''){
			$this->db->or_like('name1', $query);
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

	function remove(){
		$id = $this->input->post('id');
		$this->db->where('jobnr', $id);
		$query = $this->db->delete('jobk');
		echo json_encode(array(
			'success'=>true,
			'data'=>$id
		));
	}

}