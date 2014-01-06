<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Employee extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('code_model2','',TRUE);
	}

	function index(){
		//$this->phxview->RenderView('empl');
		//$this->phxview->RenderLayout('default');
	}

	function load(){
		$this->db->set_dbprefix('v_');
		$tbName = 'empl';
		
		$id = $this->input->post('id'); //exit;
		
		$this->db->limit(1);
		$this->db->where('empnr', $id);
		$query = $this->db->get($tbName);
		if($query->num_rows()>0){
			$result_data = $query->first_row('array');
			$result_data['id'] = $result_data['empnr'];
			
			echo json_encode(array(
				'success'=>true,
				'data'=>$result_data
			));
		}else
			echo json_encode(array(
				'success'=>false
			));
	}
	
	function load2(){
		$this->db->set_dbprefix('v_');
		$tbName = 'empl';
		
		$id = $this->input->post('id'); //exit;
		
		$this->db->limit(1);
		$this->db->where('empnr', $id);
		$query = $this->db->get($tbName);
		if($query->num_rows()>0){
			$result_data = $query->first_row('array');
			
			$result_data['id'] = $result_data['empnr'];
			$result_data['adr01'] .= ' '.$result_data['distx'].' '.$result_data['pstlz'].
			                         PHP_EOL.'Tel: '.$result_data['telf1'].' '.'Fax: '.$result_data['telfx'].
									 PHP_EOL.'Email: '.$result_data['email'];
			
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
		$tbName = 'empl';
		
		function createQuery($_this){
			
			$query = $_this->input->get('query');
			if(!empty($query)){
				$_this->db->where("(`empnr` LIKE '%$query%'
				OR `name1` LIKE '%$query%')", NULL, FALSE);
			}
			
			$empnr1 = $_this->input->get('empnr');
			$empnr2 = $_this->input->get('empnr2');
			if(!empty($empnr1) && empty($empnr2)){
			  $_this->db->where('empnr', $empnr1);
			}
			elseif(!empty($empnr1) && !empty($empnr2)){
			  $_this->db->where('empnr >=', $empnr1);
			  $_this->db->where('empnr <=', $empnr2);
			}

		}
		// End for report		
		
		createQuery($this);
		$totalCount = $this->db->count_all_results($tbName);

		createQuery($this);
		$limit = $this->input->get('limit');
		$start = $this->input->get('start');
		if(isset($limit) && isset($start)) $this->db->limit($limit, $start);

		$sort = $this->input->get('sort');
		$dir = $this->input->get('dir');
		$this->db->order_by($sort, $dir);
		
		$query = $this->db->get($tbName);
		
		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$totalCount
		));
	}

	function save(){
		//$lifnr = $this->input->post('lifnr');
		$id = $this->input->post('id');
		$query = null;
		if(!empty($id)){
			$this->db->limit(1);
			$this->db->where('empnr', $id);
			$query = $this->db->get('empl');
		}
		
		$formData = array(
			//'lifnr' => $this->input->post('lifnr'),
			'name1' => $this->input->post('name1'),
			'adr01' => $this->input->post('adr01'),
			'distx' => $this->input->post('distx'),
			'pstlz' => $this->input->post('pstlz'),
			'telf1' => $this->input->post('telf1'),
			'email' => $this->input->post('email'),
			'pson1' => $this->input->post('pson1'),
			'cidno' => $this->input->post('cidno'),
			'posnr' => $this->input->post('posnr'),
			'begdt' => $this->input->post('begdt'),
			'saknr' => $this->input->post('saknr'),
			'bcode' => $this->input->post('bcode'),
			'salar' => $this->input->post('salar'),
			'depnr' => $this->input->post('depnr'),
			'statu' => $this->input->post('statu'),
			'supnr' => $this->input->post('supnr'),
			//'adr02' => $this->input->post('adr02'),
			'telf2' => $this->input->post('telf2')//,
			//'note1' => $this->input->post('note1')
		);
		if (!empty($query) && $query->num_rows() > 0){
			$this->db->where('empnr', $id);
			$this->db->update('empl', $formData);
		}else{
			$this->db->set('empnr', 
			$this->code_model2->generate2('EP'));
			$this->db->set('erdat', 'NOW()', false);
			$this->db->set('ernam', 'test');
			$this->db->insert('empl', $formData);
		}

		echo json_encode(array(
			'success'=>true,
			'data'=>$_POST
		));
	}

	function remove(){
		$lifnr = $this->input->post('empnr');
		$this->db->where('empnr', $empnr);
		$query = $this->db->delete('empl');
		echo json_encode(array(
			'success'=>true,
			'data'=>$empnr
		));
	}
	
	public function loads_tcombo(){
		//$tbName = 'ptyp';
		//$tbPK = 'ptype';

		$sql="SELECT *
			FROM tbl_ptyp
			WHERE ptype <> '02'";
		$query = $this->db->query($sql);

		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$query->num_rows()
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