<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Service extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('code_model2','',TRUE);
	}

	function index(){
		//$this->load->view('material');
	}
	
	function load(){
		//$this->db->set_dbprefix('v_');
		$id = $this->input->post('id');
		$kunnr = $this->input->post('kunnr');
		$this->db->limit(1);
		
		if(!empty($kunnr)){
			//echo $kunnr;
			$sql="select a.*,b.unit,b.cost from tbl_mara a inner join tbl_plev b
                  on a.matnr = b.matnr
                  inner join tbl_kna1 c on b.pleve = c.pleve
		          WHERE a.matnr='$id'
		          AND c.kunnr='$kunnr'";
		    $query = $this->db->query($sql);
			$result_data = $query->first_row('array');
		//if($query->num_rows()==0){
		//	$this->db->where('matnr', $id);
		//    $query = $this->db->get('mara');
		//}
		}else{
		    $sql="select a.*,b.unit,b.cost from tbl_mara a left join tbl_plev b
                  on a.matnr = b.matnr
		          WHERE a.matnr='$id'
		          and a.mtart = 'SV'";
		    $query = $this->db->query($sql);
			
			if($query->num_rows()>0){
			$result_data = $query->first_row('array');	
			$rows = $query->result_array();
			$i=0;$u='';
			foreach($rows AS $row){
				$i++;
				$u = 'unit'.$i;
				$c = 'cost'.$i;
				$result_data[$u] = $row['unit'];
				$result_data[$c] = $row['cost'];
			}
			}
		}
		
		if($query->num_rows()>0){
			//$result_data = $query->first_row('array');
			$result_data['id'] = $result_data['matnr'];

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
		
		$sql="select a.*,b.unit,b.cost from tbl_mara a left join tbl_plev b
                  on a.matnr = b.matnr
		          WHERE a.mtart = 'SV'";
		$query = $this->db->query($sql);
		//$tbName = 'mara';

		//$sort = $this->input->post('sort');
		//$dir = $this->input->post('dir');
		//$this->db->order_by($sort, $dir);

		//$query = $this->db->get($tbName);
		//echo $this->db->last_query();
		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$query->num_rows()
		));
	}
	
	public function loads_tcombo(){
		$tbName = 'mtyp';
		$tbPK = 'mtart';

		$query = $this->input->post('query');

		$totalCount = $this->db->count_all_results($tbName);


		if(!empty($query) && $query!=''){
			$this->db->or_like('matxt', $query);
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
	
	public function loads_gcombo(){
		$tbName = 'mgrp';
		$tbPK = 'matkl';

		$query = $this->input->post('query');

		$totalCount = $this->db->count_all_results($tbName);


		if(!empty($query) && $query!=''){
			$this->db->or_like('matxt', $query);
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

	function save(){
		
		$id = $this->input->post('id');
		$query = null;
		if(!empty($id)){
			$this->db->limit(1);
			$this->db->where('matnr', $id);
			$query = $this->db->get('mara');
		}

		$formData = array(
			//'matnr' => $this->input->post('matnr'),
			'maktx' => $this->input->post('maktx'),
			//'maetx' => $this->input->post('maetx'),
			'matkl' => $this->input->post('matkl'),
			'mtart' => $this->input->post('mtart'),
			'meins' => $this->input->post('meins'),
			'saknr' => $this->input->post('saknr'),
			'beqty' => $this->input->post('beqty'),
			
			'beval' => $this->input->post('beval'),
			'cosav' => $this->input->post('cosav'),
			'enqty' => $this->input->post('enqty'),		
			'enval' => $this->input->post('enval')
			);
			
		if (!empty($query) && $query->num_rows() > 0){
			$this->db->where('matnr', $id);
			$this->db->set('updat', 'NOW()', false);
			$this->db->set('upnam', 'test');
			$this->db->update('mara', $formData);
		}else{
			$id = $this->code_model2->generate2('SM');
			$this->db->set('matnr', $id);
			$this->db->set('erdat', 'NOW()', false);
			$this->db->set('ernam', 'test');
			$this->db->insert('mara', $formData);
		}
		
		$this->db->where('matnr', $id);
		$this->db->delete('plev');
		
		$i=0;$p=0;$u=0;$c=0;
		for($i=1;$i<=3;$i++){
		    $p='0'.$i;
			$u='unit'.$i;
			$c='cost'.$i;	
		$formCost = array(
		    'pleve' => $p,
		    'matnr' => $id,
			'unit' => $this->input->post($u),
			'cost' => $this->input->post($c),
			);
		  $this->db->insert('plev', $formCost);
		}

		echo json_encode(array(
			'success'=>true,
			'data'=>$_POST
		));
	}

    function remove(){
		$id = $this->input->post('id');
		$this->db->where('matnr', $id);
		$query = $this->db->delete('mara');
		echo json_encode(array(
			'success'=>true,
			'data'=>$id
		));
	}

}