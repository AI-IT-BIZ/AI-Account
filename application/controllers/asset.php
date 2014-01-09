<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Asset extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('code_model2','',TRUE);
		$this->load->model('email_service','',TRUE);
	}

	function index(){
		//$this->load->view('material');
	}
	
	function load(){
		//$this->db->set_dbprefix('v_');
		$id = $this->input->post('id');
		//$kunnr = $this->input->post('kunnr');
		$this->db->limit(1);
		
		    /*$sql="select a.*,b.unit,b.cost 
		          from tbl_mara a 
		          left join tbl_plev b
                  on a.matnr = b.matnr
		          WHERE a.matnr='$id'";
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
			}*/
			
			$this->db->set_dbprefix('v_');
		    $tbName = 'fara';
		    $this->db->where('matnr', $id);
			$query = $this->db->get($tbName);
		
		if($query->num_rows()>0){
			$result_data = $query->first_row('array');
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
		
		$this->db->set_dbprefix('v_');
		$tbName = 'fara';
		
		function createQuery($_this){
			
			$query = $_this->input->get('query');
			if(!empty($query)){
				$_this->db->where("(`matnr` LIKE '%$query%'
				OR `maktx` LIKE '%$query%'
				OR `mtart` LIKE '%$query%')", NULL, FALSE);
			//}else{
			//	$_this->db->where("`mtart` <> 'SV'", NULL, FALSE);
			}
			
			$matnr1 = $_this->input->get('matnr');
			$matnr2 = $_this->input->get('matnr2');
			if(!empty($matnr1) && empty($matnr2)){
			  $_this->db->where('matnr', $matnr1);
			}
			elseif(!empty($matnr1) && !empty($matnr2)){
			  $_this->db->where('matnr >=', $matnr1);
			  $_this->db->where('matnr <=', $matnr2);
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
		//echo $this->db->last_query();
		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$totalCount
		));
	}
	
	function load2(){
		$this->db->set_dbprefix('v_');
		$tbName = 'fara';
		
		function createQuery($_this){
			
			$query = $_this->input->get('query');
			if(!empty($query)){
				$_this->db->where("(`matnr` LIKE '%$query%'
				OR `maktx` LIKE '%$query%'
				OR `mtart` LIKE '%$query%')", NULL, FALSE);
			}
			
			$matnr1 = $_this->input->get('matnr');
			$matnr2 = $_this->input->get('matnr2');
			if(!empty($matnr1) && empty($matnr2)){
			  $_this->db->where('matnr', $matnr1);
			}
			elseif(!empty($matnr1) && !empty($matnr2)){
			  $_this->db->where('matnr >=', $matnr1);
			  $_this->db->where('matnr <=', $matnr2);
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
		//echo $this->db->last_query();
		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$totalCount
		));
	}
	
	public function loads_tcombo(){
		$tbName = 'ftyp';
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
		$tbName = 'fgrp';
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
			$query = $this->db->get('fara');
		}

		$formData = array(
			//'matnr' => $this->input->post('matnr'),
			'maktx' => $this->input->post('maktx'),
			'matkl' => $this->input->post('matkl'),
			'mtart' => $this->input->post('mtart'),
			'meins' => $this->input->post('meins'),
			'saknr' => $this->input->post('saknr'),
			'brand' => $this->input->post('brand'),
			
			'model' => $this->input->post('model'),
			'serno' => $this->input->post('serno'),
			'specs' => $this->input->post('specs'),		
			'reque' => $this->input->post('reque'),
			'holds' => $this->input->post('holds'),
			'lastn' => $this->input->post('lastn'),
			'depnr' => $this->input->post('depnr'),
			'assnr' => $this->input->post('assnr'),
			'ebeln' => $this->input->post('ebeln'),
			'bldat' => $this->input->post('bldat'),
			
			'acqui' => $this->input->post('acqui'),
			'costs' => $this->input->post('costs'),
			'resid' => $this->input->post('resid'),
			'lifes' => $this->input->post('lifes'),
			'depre' => $this->input->post('depre'),
			'keepi' => $this->input->post('keepi'),
			'statu' => $this->input->post('statu')
			);
			
			$current_username = XUMS::USERNAME();
		if (!empty($query) && $query->num_rows() > 0){
			$this->db->where('matnr', $id);
			//$this->db->set('updat', 'NOW()', false);
			db_helper_set_now($this, 'updat');
			$this->db->set('upnam', 'test');
			$this->db->update('fara', $formData);
		}else{
			$id = $this->code_model2->generate2('FA');
			$this->db->set('matnr', $id);
			//$this->db->set('erdat', 'NOW()', false);
			db_helper_set_now($this, 'erdat');
			$this->db->set('ernam', 'test');
			$this->db->insert('fara', $formData);
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
	
	function load_type(){
		//$this->db->set_dbprefix('v_');
		$id = $this->input->post('id');
		$this->db->limit(1);
		$this->db->where('mtart', $id);
		$query = $this->db->get('ftyp');
		if($query->num_rows()>0){
			$result_data = $query->first_row('array');
			$result_data['id'] = $result_data['mtart'];
			echo json_encode(array(
				'success'=>true,
				'data'=>$result_data
			));
		}else
			echo json_encode(array(
				'success'=>false
			));
	}

	function loads_type(){
		//$this->db->set_dbprefix('v_');
		$tbName = 'ftyp';
		
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
			'totalCount'=>$query->num_rows()
		));
	}

	function save_type(){
		//echo "vendor type";
		
		//start transaction
		//$this->db->trans_start();  
		
		// ลบ receipt item ภายใต้ id ทั้งหมด
		$this->db->truncate('ftyp');
		//$this->db->delete('ktyp');

		// เตรียมข้อมูล payment item
		$mtyp = $this->input->post('ftyp');
		$item_array = json_decode($mtyp);
		
		if(!empty($mtyp) && !empty($item_array)){
			// loop เพื่อ insert payment item ที่ส่งมาใหม่
			$item_index = 0;
		foreach($item_array AS $p){
			$this->db->insert('ftyp', array(
				'mtart'=>$p->mtart,
				'matxt'=>$p->matxt//,
				//'saknr'=>$p->saknr
			));
	    	}
		}

		echo json_encode(array(
			'success'=>true,
			'data'=>$_POST
		));
	}
	
	function remove_type(){
		$id = $this->input->post('id');
		$this->db->where('mtart', $id);
		$query = $this->db->delete('ftyp');
		echo json_encode(array(
			'success'=>true,
			'data'=>$id
		));
	}
	
	function load_grp(){
		$this->db->set_dbprefix('v_');
		$id = $this->input->post('id');
		$this->db->limit(1);
		$this->db->where('matkl', $id);
		$query = $this->db->get('fgrp');
		if($query->num_rows()>0){
			$result_data = $query->first_row('array');
			$result_data['id'] = $result_data['matkl'];
			echo json_encode(array(
				'success'=>true,
				'data'=>$result_data
			));
		}else
			echo json_encode(array(
				'success'=>false
			));
	}

	function loads_grp(){
		$this->db->set_dbprefix('v_');
		$tbName = 'fgrp';
		
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
			'totalCount'=>$query->num_rows()
		));
	}

	function save_grp(){
		//echo "vendor type";
		
		//start transaction
		//$this->db->trans_start();  
		
		// ลบ receipt item ภายใต้ id ทั้งหมด
		$this->db->truncate('fgrp');
		//$this->db->delete('ktyp');

		// เตรียมข้อมูล payment item
		$mgrp = $this->input->post('fgrp');
		$item_array = json_decode($mgrp);
		
		if(!empty($mgrp) && !empty($item_array)){
			// loop เพื่อ insert payment item ที่ส่งมาใหม่
			$item_index = 0;
		foreach($item_array AS $p){
			$this->db->insert('fgrp', array(
				'matkl'=>$p->matkl,
				'matxt'=>$p->matxt,
				'saknr'=>$p->saknr
			));
	    	}
		}

		echo json_encode(array(
			'success'=>true,
			'data'=>$_POST
		));
	}
	
	function remove_grp(){
		$id = $this->input->post('id');
		$this->db->where('matkl', $id);
		$query = $this->db->delete('fgrp');
		echo json_encode(array(
			'success'=>true,
			'data'=>$id
		));
	}

}