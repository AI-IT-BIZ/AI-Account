<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Material extends CI_Controller {

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
		$kunnr = $this->input->post('kunnr');
		$key = $this->input->post('key');
		
		$this->db->limit(1);
		
		if(!empty($kunnr)){
			
			$sql="select a.*,b.unit,b.cost from tbl_mara a 
			      inner join tbl_plev b on a.matnr = b.matnr
                  inner join tbl_kna1 c on b.pleve = c.pleve
		          WHERE a.matnr='$id'
		          AND c.kunnr='$kunnr' ";
		    if($key==1){
				$sql.="AND a.statu = '02'";
			}
		    $query = $this->db->query($sql);
			$result_data = $query->first_row('array');
	
		}else{
		   	if($key==1){
			   $this->db->where('statu', '02');
		    }		
			$this->db->set_dbprefix('v_');
		    $tbName = 'umat';
		    $this->db->where('matnr', $id);
			$query = $this->db->get($tbName);
		}
		
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
		$tbName = 'mara';
		
		function createQuery($_this){
			
			$query = $_this->input->get('query');
			if(!empty($query)){
				$_this->db->where("(matnr LIKE '%$query%'
				OR maktx LIKE '%$query%'
				OR mtart LIKE '%$query%') and mtart <> 'SV'", NULL, FALSE);
			}else{
				$_this->db->where("mtart <> 'SV'", NULL, FALSE);
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
	
	function load2(){
		$this->db->set_dbprefix('v_');
		$tbName = 'mara';
		
		if($this->input->get('ftype')=='01'){
			$tbName = 'fara';
		}
		
		function createQuery($_this){
			
			$query = $_this->input->get('query');
			if(!empty($query)){
				$_this->db->where("(matnr LIKE '%$query%'
				OR maktx LIKE '%$query%'
				OR mtart LIKE '%$query%')", NULL, FALSE);
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
			$_this->db->where('stype','01');

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
		$status_changed = false;
		$inserted_id = false;
		if(!empty($id)){
			$this->db->limit(1);
			$this->db->where('matnr', $id);
			$query = $this->db->get('mara');
			
			// ##### CHECK PERMISSIONS
			$row = $query->first_row('array');
			// status has change
			$status_changed = $row['statu']!=$this->input->post('statu');
			if($status_changed){
				if(XUMS::CAN_DISPLAY('MM') && XUMS::CAN_APPROVE('MM')){
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
					$emsg = 'You do not have permission to change material status.';
					echo json_encode(array(
						'success'=>false,
						'errors'=>array( 'statu' => $emsg ),
						'message'=>$emsg
					));
					return;
				}
			}else{
				if($row['statu']=='03'){
					$emsg = 'The material that already or rejected cannot be update.';
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
			//'maetx' => $this->input->post('maetx'),
			'matkl' => $this->input->post('matkl'),
			'mtart' => $this->input->post('mtart'),
			'meins' => $this->input->post('meins'),
			'saknr' => $this->input->post('saknr'),
			'beqty' => floatval($this->input->post('beqty')),
			
			'beval' => floatval($this->input->post('beval')),
			'cosav' => floatval($this->input->post('cosav')),
			'enqty' => floatval($this->input->post('enqty')),		
			'enval' => floatval($this->input->post('enval')),
			'unit1' => $this->input->post('unit1'),
			'cost1' => floatval($this->input->post('cost1')),
			'unit2' => $this->input->post('unit2'),
			'cost2' => floatval($this->input->post('cost2')),
			'unit3' => $this->input->post('unit3'),
			'cost3' => floatval($this->input->post('cost3')),
			'statu' => $this->input->post('statu'),
			'descr' => $this->input->post('descr'),
			'brand' => $this->input->post('brand'),
			'stype' => $this->input->post('stype'),
			'buget' => floatval($this->input->post('buget'))
			);
			
			$current_username = XUMS::USERNAME();
			
		if (!empty($query) && $query->num_rows() > 0){
			$this->db->where('matnr', $id);
			//$this->db->set('updat', 'NOW()', false);
			db_helper_set_now($this, 'updat');
			$this->db->set('upnam', $current_username);
			$this->db->update('mara', $formData);
		}else{
			$id = $this->code_model2->generate2('MM');
			$this->db->set('matnr', $id);
			//$this->db->set('erdat', 'NOW()', false);
			db_helper_set_now($this, 'erdat');
			$this->db->set('ernam', $current_username);
			$this->db->insert('mara', $formData);
			
			$inserted_id = $id;
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
			'cost' => floatval($this->input->post($c)),
			);
		  $this->db->insert('plev', $formCost);
		}

		echo json_encode(array(
			'success'=>true,
			'data'=>$_POST
		));
		
		/*try{
				$post_id = $this->input->post('id');
				//$total_amount = floatval($this->input->post('netwr'));
				$total_amount = 0;
				// send notification email
				if(!empty($inserted_id)){
					$this->email_service->quotation_create('MM', $total_amount);
				}else if(!empty($post_id)){
					if($status_changed)
						$this->email_service->quotation_change_status('MM', $total_amount);
				}
			}catch(exception $e){}*/
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
		$query = $this->db->get('mtyp');
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
		$tbName = 'mtyp';
		
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
		$mtyp= $this->input->post('mtyp');
		$item_array = json_decode($mtyp);
		$result_array = json_decode($mtyp);
		if(!empty($mtyp) && !empty($item_array)){
			$i=0;
			foreach($item_array AS $p){
				$j=0;
				foreach($result_array AS $o){
					if($p->mtart == $o->mtart && $i!=$j){
						$emsg = 'Cannot Save Material type '.$p->mtart.' is duplicated';
					    echo json_encode(array(
						  'success'=>false,
						  'message'=>$emsg
					    ));
					    return;
					}$j++;
				}$i++;
			}
		}
		
		// ลบ receipt item ภายใต้ id ทั้งหมด
		if(db_helper_is_mssql($this)){
		$this->db->where('1=1');
		$this->db->delete('mtyp');
		}
		if(db_helper_is_mysql($this)){
		$this->db->truncate('mtyp');
		}
		//$this->db->delete('ktyp');

		// เตรียมข้อมูล payment item
		//$mtyp = $this->input->post('mtyp');
		//$item_array = json_decode($mtyp);
		
		if(!empty($mtyp) && !empty($item_array)){
			// loop เพื่อ insert payment item ที่ส่งมาใหม่
			$item_index = 0;
		foreach($item_array AS $p){
			$this->db->insert('mtyp', array(
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
		$query = $this->db->delete('mtyp');
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
		$query = $this->db->get('mgrp');
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
		$tbName = 'mgrp';
		
		$limit = $this->input->get('limit');
		$start = $this->input->get('start');
		if(isset($limit) && isset($start)) $this->db->limit($limit, $start);

		//$sort = $this->input->post('sort');
		//$dir = $this->input->post('dir');
		//$this->db->order_by($sort, $dir);

		$query = $this->db->get($tbName);
		$totalCount = $this->db->count_all_results($tbName);
		//echo $this->db->last_query();
		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$totalCount
		));
	}

	function save_grp(){
		$mgrp = $this->input->post('mgrp');
		$item_array = json_decode($mgrp);
		$result_array = json_decode($mgrp);
		if(!empty($mgrp) && !empty($item_array)){
			$i=0;
			foreach($item_array AS $p){
				$j=0;
				foreach($result_array AS $o){
					if($p->matkl == $o->matkl && $i!=$j){
						$emsg = 'Cannot Save Material group '.$p->matkl.' is duplicated';
					    echo json_encode(array(
						  'success'=>false,
						  'message'=>$emsg
					    ));
					    return;
					}$j++;
				}$i++;
			}
		}
		
		// ลบ receipt item ภายใต้ id ทั้งหมด
		if(db_helper_is_mssql($this)){
		$this->db->where('1=1');
		$this->db->delete('mgrp');
		}
		if(db_helper_is_mysql($this)){
		$this->db->truncate('mgrp');
		}
		//$this->db->delete('ktyp');

		// เตรียมข้อมูล payment item
		//$mgrp = $this->input->post('mgrp');
		//$item_array = json_decode($mgrp);
		
		if(!empty($mgrp) && !empty($item_array)){
			// loop เพื่อ insert payment item ที่ส่งมาใหม่
			$item_index = 0;
		foreach($item_array AS $p){
			$this->db->insert('mgrp', array(
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
		$query = $this->db->delete('mgrp');
		echo json_encode(array(
			'success'=>true,
			'data'=>$id
		));
	}

}