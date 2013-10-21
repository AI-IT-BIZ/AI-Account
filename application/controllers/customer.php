<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('code_model2','',TRUE);
	}

	function index(){
		$this->load->view('customer');
	}
	
	function load(){
		$this->db->set_dbprefix('v_');
		$id = $this->input->post('id');
		$this->db->limit(1);
		$this->db->where('kunnr', $id);
		$query = $this->db->get('kna1');
		if($query->num_rows()>0){
			$result_data = $query->first_row('array');
			$result_data['id'] = $result_data['kunnr'];
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
		$id = $this->input->post('id');
		$this->db->limit(1);
		$this->db->where('kunnr', $id);
		$query = $this->db->get('kna1');
		if($query->num_rows()>0){
			$result_data = $query->first_row('array');
			
			$result_data['adr01'] .= ' '.$result_data['distx'].' '.$result_data['pstlz'].
			                         PHP_EOL.'Tel: '.$result_data['telf1'].' '.'Fax: '.$result_data['telfx'].
									 PHP_EOL.'Email: '.$result_data['email'];
			
			$result_data['adr02'] .= ' '.$result_data['dis02'].' '.$result_data['pst02'].
			                         PHP_EOL.'Tel: '.$result_data['tel02'].' '.'Fax: '.$result_data['telf2'].
									 PHP_EOL.'Email: '.$result_data['emai2'];
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
		$tbName = 'kna1';

		$totalCount = $this->db->count_all_results($tbName);

//		createQuery($this);
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
	
	public function loads_acombo(){
		//$tbName = 'apov';
		//$tbPK = 'statu';

		$sql="SELECT *
			FROM tbl_apov
			WHERE apgrp = '1'";
		$query = $this->db->query($sql);

		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$query->num_rows()
		));
	}

	function save(){
		//$kunnr = $this->input->post('kunnr');
		$id = $this->input->post('id');
		$query = null;
		if(!empty($id)){
			$this->db->limit(1);
			$this->db->where('kunnr', $id);
			$query = $this->db->get('kna1');
		}
		
		$formData = array(
			//'kunnr' => $this->input->post('kunnr'),
			'name1' => $this->input->post('name1'),
			'adr01' => $this->input->post('adr01'),
			'ktype' => $this->input->post('ktype'),
			'distx' => $this->input->post('distx'),
			'pstlz' => $this->input->post('pstlz'),
			'terms' => $this->input->post('terms'),
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
			'sgtxt' => $this->input->post('sgtxt'),
			'adr02' => $this->input->post('adr02'),
			'dis02' => $this->input->post('dis02'),
			'pst02' => $this->input->post('pst02'),
			'tel02' => $this->input->post('tel02'),
			'telf2' => $this->input->post('telf2'),
			'emai2' => $this->input->post('emai2'),
			'pson2' => $this->input->post('pson2'),
			'cunt1' => $this->input->post('cunt1'),
			'cunt2' => $this->input->post('cunt2'),
			'statu' => $this->input->post('statu'),
			'ptype' => $this->input->post('ptype')
			
		);
		if (!empty($query) && $query->num_rows() > 0){
			$this->db->where('kunnr', $id);
			$this->db->update('kna1', $formData);
		}else{
			$id = $this->code_model2->generate2('CS');
			$this->db->set('kunnr', $id);
			$this->db->set('erdat', 'NOW()', false);
			$this->db->set('ernam', 'test');
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