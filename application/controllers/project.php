<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Project extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->model('code_model','',TRUE);

		$this->load->model('email_service','',TRUE);
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

			$result_data['adr01'] .= ' '.$result_data['distx'].' '.$result_data['pstlz'].
			                         PHP_EOL.'Tel: '.$result_data['telf1'].' '.'Fax: '.$result_data['telfx'].
									 PHP_EOL.'Email: '.$result_data['email'];

			$result_data['adr02'] .= ' '.$result_data['dis02'].' '.$result_data['pst02'].
			                         PHP_EOL.'Tel: '.$result_data['tel02'].' '.'Fax: '.$result_data['telf2'].
									 PHP_EOL.'Email: '.$result_data['emai2'];

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

// Start for report
		function createQuery($_this){
			$query = $_this->input->get('query');
			if(!empty($query)){
				$_this->db->where("(`jobnr` LIKE '%$query%'
				OR `jobtx` LIKE '%$query%'
				OR `kunnr` LIKE '%$query%'
				OR `name1` LIKE '%$query%'
				OR `salnr` LIKE '%$query%')", NULL, FALSE);
			}

            $jobnr1 = $_this->input->get('jobnr');
			$jobnr2 = $_this->input->get('jobnr2');
			if(!empty($jobnr1) && empty($jobnr2)){
			  $_this->db->where('jobnr', $jobnr1);
			}
			elseif(!empty($jobnr1) && !empty($jobnr2)){
			  $_this->db->where('jobnr >=', $jobnr1);
			  $_this->db->where('jobnr <=', $jobnr2);
			}

			$bldat1 = $_this->input->get('bldat');
			$bldat2 = $_this->input->get('bldat2');
			if(!empty($bldat1) && empty($bldat2)){
			  $_this->db->where('bldat', $bldat1);
			}
			elseif(!empty($bldat1) && !empty($bldat2)){
			  $_this->db->where('bldat >=', $bldat1);
			  $_this->db->where('bldat <=', $bldat2);
			}

			$kunnr1 = $_this->input->get('kunnr');
			$kunnr2 = $_this->input->get('kunnr2');
			if(!empty($kunnr1) && empty($kunnr2)){
			  $_this->db->where('kunnr', $kunnr1);
			}
			elseif(!empty($kunnr1) && !empty($kunnr2)){
			  $_this->db->where('kunnr >=', $kunnr1);
			  $_this->db->where('kunnr <=', $kunnr2);
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

	function save(){
		//$this->db->set_dbprefix('v_');
		$id = $this->input->post('id');
		$query = null;

		$status_changed = false;
		$inserted_id = false;
		if(!empty($id)){
			$this->db->limit(1);
			$this->db->where('jobnr', $id);
			$query = $this->db->get('jobk');

			// ##### CHECK PERMISSIONS
			$row = $query->first_row('array');
			// status has change
			$status_changed = $row['statu']!=$this->input->post('statu');
			if($status_changed&&$row['statu']!=02&&$row['statu']!=02&&$row['statu']!=03){
				if(XUMS::CAN_DISPLAY('PJ') && XUMS::CAN_APPROVE('PJ')){
					$limit = XUMS::LIMIT('PJ');
					print_r($limit); return;
					if($limit<$row['pramt']){
						$emsg = 'You do not have permission to change project status over than '.number_format($limit);
						echo json_encode(array(
							'success'=>false,
							'errors'=>array( 'statu' => $emsg ),
							'message'=>$emsg
						));
						return;
					}
				}else{
					$emsg = 'You do not have permission to change project status.';
					echo json_encode(array(
						'success'=>false,
						'errors'=>array( 'statu' => $emsg ),
						'message'=>$emsg
					));
					return;
				}
			}else{
				if($row['statu']=='02'||$row['statu']=='03'){
					$emsg = 'The project that already approved or rejected cannot be update.';
					echo json_encode(array(
						'success'=>false,
						'message'=>$emsg
					));
					return;
				}
			}
			// ##### END CHECK PERMISSIONS
		}

        $sdat = explode('-',$this->input->post('stdat'));
		$edat = explode('-',$this->input->post('endat'));
		$stdat = $sdat[0].$sdat[1].$sdat[2];
		$endat = $edat[0].$edat[1].$edat[2];
		//echo $stdat.'aaa'.$endat;
		if($stdat>$endat){
					$emsg = 'The End date must be more than Start date.';
					echo json_encode(array(
						'success'=>false,
						'message'=>$emsg
					));
					return;
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
			'ctype' => $this->input->post('ctype'),
			'esamt' => $this->input->post('esamt')
		);
		  //$this->db->set('erdat', 'NOW()', false);
		  $current_username = XUMS::USERNAME();

		if (!empty($query) && $query->num_rows() > 0){
			$this->db->where('jobnr', $id);
			//$this->db->set('updat', 'NOW()', false);
			db_helper_set_now($this, 'updat');
			$this->db->set('upnam', $current_username);
			$this->db->update('jobk', $formData);
		}else{
			$this->db->set('jobnr', $this->code_model->generate('PJ',
			$this->input->post('bldat')));
			//$this->db->set('erdat', 'NOW()', false);
			db_helper_set_now($this, 'erdat');
			$this->db->set('ernam', $current_username);
			$this->db->insert('jobk', $formData);
		}

		echo json_encode(array(
			'success'=>true,
			'data'=>$_POST
		));

		try{
				$post_id = $this->input->post('id');
				$total_amount = $this->input->post('pramt');
				// send notification email
				if(empty($inserted_id)){
					$q_row = $this->db->get_where('jobk', array('jobnr'=>$inserted_id));
					$row = $q_row->first_row();
					$this->email_service->sendmail_create(
						'PJ', 'Project',
						$inserted_id, $total_amount,
						$row->ernam
					); print_r($inserted_id);
				}else if(!empty($post_id)){print_r($post_id);
					if($status_changed){
						$q_row = $this->db->get_where('jobk', array('jobnr'=>$post_id));
						$row = $q_row->first_row();
						$this->email_service->sendmail_change_status(
							'PJ', 'Project',
							$post_id, $total_amount, $row->statu,
							$row->ernam
						);
					}
				}
			}catch(exception $e){}
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

	function load_type(){
		//$this->db->set_dbprefix('v_');
		$id = $this->input->post('id');
		$this->db->limit(1);
		$this->db->where('jtype', $id);
		$query = $this->db->get('jtyp');
		if($query->num_rows()>0){
			$result_data = $query->first_row('array');
			$result_data['id'] = $result_data['jtype'];
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
		$tbName = 'jtyp';

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
		$this->db->truncate('jtyp');
		//$this->db->delete('ktyp');

		// เตรียมข้อมูล payment item
		$jtyp = $this->input->post('jtyp');
		$item_array = json_decode($jtyp);

		if(!empty($jtyp) && !empty($item_array)){
			// loop เพื่อ insert payment item ที่ส่งมาใหม่
			$item_index = 0;
		foreach($item_array AS $p){
			$this->db->insert('jtyp', array(
				'jtype'=>$p->jtype,
				'typtx'=>$p->typtx//,
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
		$this->db->where('jtype', $id);
		$query = $this->db->delete('jtyp');
		echo json_encode(array(
			'success'=>true,
			'data'=>$id
		));
	}

}