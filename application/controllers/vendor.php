<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vendor extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('code_model2','',TRUE);
		$this->load->model('email_service','',TRUE);
	}

	function index(){
		$this->phxview->RenderView('vendor');
		$this->phxview->RenderLayout('default');
	}

	function load(){
		$this->db->set_dbprefix('v_');
		$tbName = 'lfa1';
		
		$id = $this->input->post('id'); //exit;
		
		$this->db->limit(1);
		$this->db->where('lifnr', $id);
		$query = $this->db->get($tbName);
		if($query->num_rows()>0){
			$result_data = $query->first_row('array');
			$result_data['id'] = $result_data['lifnr'];
			
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
		$tbName = 'lfa1';
		
		$id = $this->input->post('id'); //exit;
		
		$this->db->limit(1);
		$this->db->where('lifnr', $id);
		$query = $this->db->get($tbName);
		if($query->num_rows()>0){
			$result_data = $query->first_row('array');
			
			$result_data['id'] = $result_data['lifnr'];
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
		$tbName = 'lfa1';
		
		function createQuery($_this){
			
			$query = $_this->input->get('query');
			if(!empty($query)){
				$_this->db->where("(`lifnr` LIKE '%$query%'
				OR `name1` LIKE '%$query%')", NULL, FALSE);
			}
			
			$lifnr1 = $_this->input->get('lifnr');
			$lifnr2 = $_this->input->get('lifnr2');
			if(!empty($lifnr1) && empty($lifnr2)){
			  $_this->db->where('lifnr', $lifnr1);
			}
			elseif(!empty($lifnr1) && !empty($lifnr2)){
			  $_this->db->where('lifnr >=', $lifnr1);
			  $_this->db->where('lifnr <=', $lifnr2);
			}
			
			$statu1 = $_this->input->get('statu');
			$statu2 = $_this->input->get('statu2');
			if(!empty($statu1) && empty($statu2)){
			  $_this->db->where('statu', $statu1);
			}
			elseif(!empty($statu1) && !empty($statu2)){
			  $_this->db->where('statu >=', $statu1);
			  $_this->db->where('statu <=', $statu2);
			}
		}
		
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
			'totalCount'=>2//$totalCount
		));
	}

	function save(){
		//$lifnr = $this->input->post('lifnr');
		$id = $this->input->post('id');
		$query = null;
		if(!empty($id)){
			$this->db->limit(1);
			$this->db->where('lifnr', $id);
			$query = $this->db->get('lfa1');
		}
		
		$formData = array(
			//'lifnr' => $this->input->post('lifnr'),
			'name1' => $this->input->post('name1'),
			'adr01' => $this->input->post('adr01'),
			'vtype' => $this->input->post('vtype'),
			'distx' => $this->input->post('distx'),
			'pstlz' => $this->input->post('pstlz'),
			'terms' => $this->input->post('terms'),
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
			'statu' => $this->input->post('statu'),
			'ptype' => $this->input->post('ptype'),
			'vat01' => $this->input->post('vat01'),
			'note1' => $this->input->post('note1')
		);
		if (!empty($query) && $query->num_rows() > 0){
			$this->db->where('lifnr', $id);
			$this->db->update('lfa1', $formData);
		}else{
			$this->db->set('lifnr', 
			$this->code_model2->generate2('VD'));
			$this->db->set('erdat', 'NOW()', false);
			$this->db->set('ernam', 'test');
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