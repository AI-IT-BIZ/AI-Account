<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Company extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('code_model2','',TRUE);
	}

	function index(){

	}

	function load(){
		//$this->db->set_dbprefix('v_');
		$tbName = 'comp';
		
		$id = $this->input->post('id'); //exit;
		
		$this->db->limit(1);
		$this->db->where('comid', $id);
		$query = $this->db->get($tbName);
		if($query->num_rows()>0){
			$result_data = $query->first_row('array');
			$result_data['id'] = $result_data['comid'];
			
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
		//$this->db->set_dbprefix('v_');
		$tbName = 'comp';
		
		$id = $this->input->post('id'); //exit;
		
		$this->db->limit(1);
		$this->db->where('comid', $id);
		$query = $this->db->get($tbName);
		if($query->num_rows()>0){
			$result_data = $query->first_row('array');
			
			$result_data['id'] = $result_data['comid'];
			$result_data['adr01'] .= ' '.$result_data['distx'].' '.$result_data['pstlz'].
			                         PHP_EOL.'Tel: '.$result_data['telf1'].' '.
			                         'Fax: '.$result_data['telfx'].
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
		//$this->db->set_dbprefix('v_');
		$tbName = 'comp';
		
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
		//$lifnr = $this->input->post('lifnr');
		$id = $this->input->post('id');
		$query = null;
		if(!empty($id)){
			$this->db->limit(1);
			$this->db->where('comid', $id);
			$query = $this->db->get('comp');
		}
		
		$formData = array(
			//'lifnr' => $this->input->post('lifnr'),
			'name1' => $this->input->post('name1'),
			'name2' => $this->input->post('name2'),
			'adr01' => $this->input->post('adr01'),
			'distx' => $this->input->post('distx'),
			'pstlz' => $this->input->post('pstlz'),
			//'terms' => $this->input->post('terms'),
			'telf1' => $this->input->post('telf1'),
			'telfx' => $this->input->post('telfx'),
			'email' => $this->input->post('email'),
			'taxid' => $this->input->post('taxid'),
			'taxnr' => $this->input->post('taxnr'),
			'regno' => $this->input->post('regno'),
			'logoc' => $this->input->post('logoc'),
			'statu' => $this->input->post('statu'),
			'ptype' => $this->input->post('ptype'),
			'vat01' => $this->input->post('vat01'),
			'cotyp' => $this->input->post('cotyp'),
			'recty' => $this->input->post('recty'),
			'proty' => $this->input->post('proty'),
			'langu' => $this->input->post('langu'),
			'ctype' => $this->input->post('ctype')
		);
		if (!empty($query) && $query->num_rows() > 0){
			$this->db->where('comid', $id);
			$this->db->update('comp', $formData);
		}else{
			$this->db->set('comid', 
			$this->code_model2->generate2('CP'));
			$this->db->set('erdat', 'NOW()', false);
			$this->db->set('ernam', 'test');
			$this->db->insert('comp', $formData);
		}

		echo json_encode(array(
			'success'=>true,
			'data'=>$_POST
		));
	}

	function remove(){
		$lifnr = $this->input->post('comid');
		$this->db->where('comid', $lifnr);
		$query = $this->db->delete('comp');
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

}