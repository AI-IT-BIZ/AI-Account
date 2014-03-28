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
		$this->db->set_dbprefix('v_');
		$id = $this->input->post('id');
        $key = $this->input->post('key');
		if($key==1){
			$this->db->where('statu', '02');
		}
		$this->db->limit(1);
			
		$tbName = 'fara';
		$this->db->where('matnr', $id);
	    $query = $this->db->get($tbName);
		
		if($query->num_rows()>0){
			$result_data = $query->first_row('array');
			$result_data['id'] = $result_data['matnr'];
			//Under asset
			$this->db->set_dbprefix('tbl_');
			$q_qt = $this->db->get_where('fara', array(
				'matnr'=>$result_data['assnr']
			));
			if($q_qt->num_rows()>0){
			$r_qt = $q_qt->first_row('array');
			$result_data['asstx'] = $r_qt['maktx'];
			}
			//Request by
			$q_qt = $this->db->get_where('empl', array(
				'empnr'=>$result_data['reque']
			));
			if($q_qt->num_rows()>0){
			$r_qt = $q_qt->first_row('array');
			$result_data['reqtx'] = $r_qt['name1'];
			}
			//Holder
			$q_qt = $this->db->get_where('empl', array(
				'empnr'=>$result_data['holds']
			));
			if($q_qt->num_rows()>0){
			$r_qt = $q_qt->first_row('array');
			$result_data['hodtx'] = $r_qt['name1'];
			}
			//Last Holder
			$q_qt = $this->db->get_where('empl', array(
				'empnr'=>$result_data['lastn']
			));
			if($q_qt->num_rows()>0){
			$r_qt = $q_qt->first_row('array');
			$result_data['lastx'] = $r_qt['name1'];
			}
			//Department
			$q_qt = $this->db->get_where('depn', array(
				'depnr'=>$result_data['depnr']
			));
			if($q_qt->num_rows()>0){
			$r_qt = $q_qt->first_row('array');
			$result_data['deptx'] = $r_qt['deptx'];
			}

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
				$_this->db->where("(matnr LIKE '%$query%'
				OR maktx LIKE '%$query%'
				OR mtart LIKE '%$query%')", NULL, FALSE);
			//}else{
			//	$_this->db->where("mtart <> 'SV'", NULL, FALSE);
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

    function loads_report(){
		
		$this->db->set_dbprefix('v_');
		$tbName = 'fara';
		$bldat1 = '';
		function createQuery($_this){
			
			$query = $_this->input->get('query');
			if(!empty($query)){
				$_this->db->where("(matnr LIKE '%$query%'
				OR maktx LIKE '%$query%'
				OR mtart LIKE '%$query%')", NULL, FALSE);
			//}else{
			//	$_this->db->where("mtart <> 'SV'", NULL, FALSE);
			}
			$bldat1 = $_this->input->get('bldat');
			
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
		
		$res = $query->result_array();
		for($i=0;$i<count($res);$i++){
			$r_data = $res[$i];
			// search item
			//Under asset
			$this->db->set_dbprefix('tbl_');
			$q_qt = $this->db->get_where('fara', array(
				'matnr'=>$r_data['assnr']
			));
			if($q_qt->num_rows()>0){
			$r_qt = $q_qt->first_row('array');
			$res[$i]['asstx'] = $r_qt['maktx'];
			}
			
			$deprey = $r_data['costv'] - $r_data['resid'];
			if($r_data['lifes']>0){
			   $deprey = $deprey / $r_data['lifes'];
			   $res[$i]['deprey'] = $deprey;
			   $res[$i]['deprem'] = $deprey / 12;
			}else{
			   $res[$i]['deprey'] = 0;
			   $res[$i]['deprem'] = 0;
			}
			//echo $this->input->get('bldat');
			$res[$i]['curdt'] = $this->input->get('bldat');
			
			$stdat = util_helper_get_time_by_date_string($res[$i]['curdt']);
			$grdat = util_helper_get_time_by_date_string($r_data['bldat']);
			$time_diff = $stdat - $grdat;
			$day = ceil($time_diff/(24 * 60 * 60));
			$res[$i]['daysc'] = $day;
			
			$deprey = $r_data['costv'] - $r_data['resid'];
			$deprey = $deprey * $r_data['depre'] * $day;
			$res[$i]['accum'] = $deprey / 365;
			
			$res[$i]['saknr2'] = '5xxxxxxxx';
			
			$res[$i]['books'] = $r_data['costv'] - $res[$i]['accum'];
		
		}
        
		//echo $this->db->last_query();
		echo json_encode(array(
			'success'=>true,
			'rows'=>$res,
			'totalCount'=>$totalCount
		));
	}

    function loads_depreciation(){
		
		$this->db->set_dbprefix('v_');
		$tbName = 'fara';
		$bldat1 = '';
		function createQuery($_this){
			
			$query = $_this->input->get('query');
			if(!empty($query)){
				$_this->db->where("(matnr LIKE '%$query%'
				OR maktx LIKE '%$query%'
				OR mtart LIKE '%$query%')", NULL, FALSE);
			//}else{
			//	$_this->db->where("mtart <> 'SV'", NULL, FALSE);
			}
			$bldat1 = $_this->input->get('bldat');
			
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
		
		$res = $query->result_array();
		for($i=0;$i<count($res);$i++){
			$r_data = $res[$i];
			// search item
			//Under asset
			$this->db->set_dbprefix('tbl_');
			$q_qt = $this->db->get_where('fara', array(
				'matnr'=>$r_data['assnr']
			));
			if($q_qt->num_rows()>0){
			$r_qt = $q_qt->first_row('array');
			$res[$i]['asstx'] = $r_qt['maktx'];
			}
			
			$deprey = $r_data['costv'] - $r_data['resid'];
			if($r_data['lifes']>0){
			   $deprey = $deprey / $r_data['lifes'];
			   $res[$i]['deprey'] = $deprey;
			   $res[$i]['deprem'] = $deprey / 12;
			}else{
			   $res[$i]['deprey'] = 0;
			   $res[$i]['deprem'] = 0;
			}
			//echo $this->input->get('bldat');
			$res[$i]['curdt'] = $this->input->get('bldat');
			
			$stdat = util_helper_get_time_by_date_string($res[$i]['curdt']);
			$grdat = util_helper_get_time_by_date_string($r_data['bldat']);
			$time_diff = $stdat - $grdat;
			$day = ceil($time_diff/(24 * 60 * 60));
			$res[$i]['daysc'] = $day;
			
			$deprey = $r_data['costv'] - $r_data['resid'];
			$deprey = $deprey * $r_data['depre'] * $day;
			$res[$i]['accum'] = $deprey / 365;
			
			$accum = $res[$i]['accum'];
			$year = substr($res[$i]['curdt'], 0, 4);
			$deprey = $r_data['costv'] - $r_data['resid'];
			
			for($j=1;$j<13;$j++){
			    $day = cal_days_in_month(CAL_GREGORIAN, $j, $year);
			    $deprey2 = $deprey * $r_data['depre'] * $day;
			    $deprey2 = $deprey2 / 365;
			    $res[$i]['mon'.$j] = $deprey2 + $accum;
				//$year = $year + 543;
				$res[$i]['mon'.$j.'_name'] = $day.'/'.$j.'/'.$year;
			}
		
		}
        
		//echo $this->db->last_query();
		echo json_encode(array(
			'success'=>true,
			'rows'=>$res,
			'totalCount'=>$totalCount
		));
	}
	
	function load2(){
		$this->db->set_dbprefix('v_');
		$tbName = 'fara';
		if($this->input->get('ftype')=='02'){
			$tbName = 'mara';
		}
		
		function createQuery($_this){
			
			$query = $_this->input->get('query');
			if(!empty($query)){
				$_this->db->where("(matnr LIKE '%$query%'
				OR maktx LIKE '%$query%'
				OR mtart LIKE '%$query%')", NULL, FALSE);
			//}else{
			//	$_this->db->where("mtart <> 'SV'", NULL, FALSE);
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
			
			$statu1 = $_this->input->get('statu');
			$statu2 = $_this->input->get('statu2');
			if(!empty($statu1) && empty($statu2)){
			  $_this->db->where('statu', $statu1);
			}
			elseif(!empty($statu1) && !empty($statu2)){
			  $_this->db->where('statu >=', $statu1);
			  $_this->db->where('statu <=', $statu2);
			}
			$_this->db->where('stype','02');

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
		$status_changed = false;
		$inserted_id = false;
		if(!empty($id)){
			$this->db->limit(1);
			$this->db->where('matnr', $id);
			$query = $this->db->get('fara');
			
			// ##### CHECK PERMISSIONS
			$row = $query->first_row('array');
			// status has change
			$status_changed = $row['statu']!=$this->input->post('statu');
			if($status_changed){
				if(XUMS::CAN_DISPLAY('FA') && XUMS::CAN_APPROVE('FA')){
					/*$limit = XUMS::LIMIT('MM');
					if($limit<$row['netwr']){
						$emsg = 'You do not have permission to change material status over than '.number_format($limit);
						echo json_encode(array(
							'success'=>false,
							'errors'=>array( 'statu' => $emsg ),
							'message'=>$emsg
						));
						return;
					}*/
				}else{
					$emsg = 'You do not have permission to change asset status.';
					echo json_encode(array(
						'success'=>false,
						'errors'=>array( 'statu' => $emsg ),
						'message'=>$emsg
					));
					return;
				}
			}else{
				if($row['statu']=='02'||$row['statu']=='03'){
					$emsg = 'The asset that already approved or rejected cannot be update.';
					echo json_encode(array(
						'success'=>false,
						'message'=>$emsg
					));
					return;
				}
			}
			// ##### END CHECK PERMISSIONS
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
			
			//'acqui' => $this->input->post('acqui'),
			'costv' => floatval($this->input->post('costv')),
			'resid' => floatval($this->input->post('resid')),
			'lifes' => intval($this->input->post('lifes')),
			'depre' => floatval($this->input->post('depre')),
			'keepi' => $this->input->post('keepi'),
			'stype' => $this->input->post('stype'),
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
			
			$inserted_id = $id;
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
		$this->db->set_dbprefix('v_');
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
		$this->db->set_dbprefix('v_');
		$tbName = 'ftyp';
		
		$totalCount = $this->db->count_all_results($tbName);

		//createQuery($this);
		$limit = $this->input->get('limit');
		$start = $this->input->get('start');
		if(isset($limit) && isset($start)) $this->db->limit($limit, $start);

		$sort = $this->input->get('sort');
		$dir = $this->input->get('dir');
		//$this->db->order_by($sort, $dir);

		$query = $this->db->get($tbName);
		//echo $this->db->last_query();
		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$totalCount 
		));
	}

	function save_type(){
		$id = $this->input->post('id');

		$query = null;
		$status_changed = false;
		$inserted_id = false;
		if(!empty($id)){
			$this->db->limit(1);
			$this->db->where('mtart', $id);
			$query = $this->db->get('ftyp');
			}
		
		$formData = array(
			'mtart' => $this->input->post('mtart'),
			'matxt' => $this->input->post('matxt'),
			'saknr' => $this->input->post('saknr')
		);

		$current_username = XUMS::USERNAME();

		if (!empty($query) && $query->num_rows() > 0){
			$this->db->where('mtart', $id);
			$this->db->update('mtyp', $formData);

		}else{
			$id = $this->code_model2->generate2('FT');
			$this->db->set('mtart', $id);
			//$this->db->set('erdat', 'NOW()', false);
			db_helper_set_now($this, 'erdat');
			$this->db->set('ernam', $current_username);
			$this->db->insert('mtyp', $formData);

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
		
		$totalCount = $this->db->count_all_results($tbName);

		//createQuery($this);
		$limit = $this->input->get('limit');
		$start = $this->input->get('start');
		if(isset($limit) && isset($start)) $this->db->limit($limit, $start);

		$sort = $this->input->get('sort');
		$dir = $this->input->get('dir');
		//$this->db->order_by($sort, $dir);

		$query = $this->db->get($tbName);
		//echo $this->db->last_query();
		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$totalCount 
		));
	}

	function save_grp(){
		$id = $this->input->post('id');

		$query = null;
		$status_changed = false;
		$inserted_id = false;
		if(!empty($id)){
			$this->db->limit(1);
			$this->db->where('matkl', $id);
			$query = $this->db->get('fgrp');
			}
		
		$formData = array(
			'matkl' => $this->input->post('matkl'),
			'matxt' => $this->input->post('matxt'),
			'mtart' => $this->input->post('mtart')
		);

		$current_username = XUMS::USERNAME();

		if (!empty($query) && $query->num_rows() > 0){
			$this->db->where('matkl', $id);
			$this->db->update('mgrp', $formData);

		}else{
			$id = $this->code_model2->generate2('FG');
			$this->db->set('matkl', $id);
			//$this->db->set('erdat', 'NOW()', false);
			db_helper_set_now($this, 'erdat');
			$this->db->set('ernam', $current_username);
			$this->db->insert('mgrp', $formData);

		}

		echo json_encode(array(
			'success'=>true,
			'data'=>$_POST
		));
	}
	
	function load_tag(){
		$this->db->set_dbprefix('v_');
		$id = $this->input->post('id');
		$this->db->limit(1);
		$this->db->where('matnr', $id);
		$query = $this->db->get('fatp');
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

	function loads_tag(){
		
		$matnr = $this->input->get('matnr');
		$menge = $this->input->get('menge');
		$bldat = $this->input->get('bldat');
		$mbeln = $this->input->get('mbeln');
		//echo 'aaa'.$bldat;
		
		$this->db->set_dbprefix('v_');
		$tbName = 'fatp';
		
		$totalCount = $this->db->count_all_results($tbName);

		//createQuery($this);
		$limit = $this->input->get('limit');
		$start = $this->input->get('start');
		if(isset($limit) && isset($start)) $this->db->limit($limit, $start);

		//$sort = $this->input->get('sort');
		//$dir = $this->input->get('dir');
		//$this->db->order_by($sort, $dir);
        
		if($mbeln <> 'GRXXXX-XXXX'){
			$this->db->where('matnr', $matnr);
			$this->db->where('mbeln', $mbeln);
		    $query = $this->db->get($tbName);
			
			echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$totalCount 
		    ));
		}else{
			$result = array();
			$i=0;$j=0;$k=0;$num='';$l='';
			
			if(db_helper_is_mysql($this)){
				$sql = "SELECT matpr FROM tbl_fatp
				WHERE matnr = ".$matnr." matpr LIKE '".$matnr."%'"
				." ORDER BY matpr DESC LIMIT 1";
			}
			
			if(db_helper_is_mssql($this)){
				$sql = "SELECT TOP 1 matpr FROM tbl_fatp WHERE matnr = ".$matnr."
				and matpr LIKE '".$matnr."%'"
				." ORDER BY matpr DESC ";
			}
			
			$query_code = $this->db->query($sql);
            $last_no='';
			if($query_code->num_rows()>0){
				$result_code = $query_code->first_row('array');
				// หาเลขตัวหลัง
				$running = explode('-',$result_code['matpr']);
				$last_no = $running[1];
			}else{
				$last_no = '0';
			}
			   
			
			$qmat = $this->db->get_where('fara', array(
				'matnr'=>$matnr));
			if($qmat->num_rows()>0){
		    $q_matno = $qmat->first_row('array');
			}
			$items = explode('.',$menge);
			$i = abs(intval($last_no));
			for($j=0;$j<$items[0];$j++){
			   //$l=$i++;	
			   //$l = abs(intval($last_no))+1;
			   $i = $i+1;
			   $k=strlen($i);
			   //echo 'aaa'.$i;
			   if($k==1){
			   	 $num = $matnr.'-000'.$i;
			   }elseif($k==2){
			   	 //echo 'bbb';
			   	 $num=$matnr.'-00'.$i;
			   }elseif($k==3){
			   	 $num=$matnr.'-0'.$i;
			   }
			   
			   $result[$j] = array(
		       'id_matnr'=>$i,
			   'matnr'=>$matnr,
			   'mbeln'=>$mbeln,
			   'bldat'=>$bldat,
			   'maktx'=>$q_matno['maktx'],
			   'matpr'=>$num,
			   'lvorm'=>1
		       );
		       //$i++;
			}
            echo json_encode(array(
			'success'=>true,
			'rows'=>$result,
			'totalCount'=>count($result)
		    ));
		}
	}
	
	function save_tag(){
		// เตรียมข้อมูล payment item
		$matnr = $this->input->post('matnr');
		// ลบ pay_item ภายใต้ id ทั้งหมด
		$this->db->where('matnr', $matnr);
		$this->db->delete('fatp');
		
		$fatp = $this->input->post('fatp');
		$item_array = json_decode($fatp);
		
		if(!empty($fatp) && !empty($item_array)){
			// loop เพื่อ insert payment item ที่ส่งมาใหม่
	    $item_index = 0;
		foreach($item_array AS $p){
			if($p->lvorm==false)
			{ $p->lvorm = ''; }
			$this->db->insert('fatp', array(
				'matnr'=>$p->matnr,
				'matpr'=>$p->matpr,
				'bldat'=>$p->bldat,
				'mbeln'=>$p->mbeln,
				'lvorm'=>$p->lvorm
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

	function barcode(){
		$matpr = "(".$_GET['matpr'].")";
		require_once substr(BASEPATH,0,-7).'application/libraries/jasper/rest/client/JasperClient.php';
		$client = new Jasper\JasperClient(JASPERSERVER,
						JASPERPORT,
					   JASPERUSER,
					   JASPERPASSWORD,
					   '/jasperserver'
				   );
		$controls = array('matpr' => $matpr);
		//echo $matpr;
		$report = $client->runReport('/ai_account/barcode', 'pdf', null, $controls);
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Description: File Transfer');
		header('Content-Disposition: inline;');
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: ' . strlen($report));
		header('Content-Type: application/pdf');
		echo $report; 
	}

}