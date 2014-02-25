<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Quotation extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->model('code_model','',TRUE);

		$this->load->model('email_service','',TRUE);
/*
		if(empty(XUMS::USERNAME())){
			echo json_encode(array(
				'success'=>false,
				'message'=>'Session has expire please re-login.'
			));
			return;
		}
*/
	}

	/*
	function test_get_code(){
		echo $this->code_model->generate('PR', '2013-05-22');
	}*/

	function index(){
		//$this->load->view('project');
		//$this->phxview->RenderView('vbak');
		//$this->phxview->RenderLayout('default');
	}

	function load(){
		$this->db->set_dbprefix('v_');
		$id = $this->input->post('id');
		$key = $this->input->post('key');
		if($key==1){
			$this->db->where('statu', '02');
		}
		$this->db->limit(1);

		$this->db->where('vbeln', $id);
		$query = $this->db->get('vbak');

		if($query->num_rows()>0){
			$result_data = $query->first_row('array');
			$result_data['id'] = $result_data['vbeln'];

			$result_data['adr01'] .= ' '.$result_data['distx'].' '.$result_data['pstlz'].
			                         PHP_EOL.'Tel: '.$result_data['telf1'].' '.'Fax: '.
			                         $result_data['telfx'].
									 PHP_EOL.'Email: '.$result_data['email'];
			$result_data['adr02'] .= $result_data['dis02'].' '.$result_data['pst02'].
			                         PHP_EOL.'Tel: '.$result_data['tel02'].' '.'Fax: '.
			                         $result_data['telf2'].
									 PHP_EOL.'Email: '.$result_data['emai2'];

			$q_qt = $this->db->get_where('psal', array(
				'salnr'=>$result_data['salnr']
			));

			$r_qt = $q_qt->first_row('array');
			$result_data['emnam'] = $r_qt['emnam'];
			
			//$vwht = str_replace('%', ' ', $result_data['whtpr']);
			$result_data['whtpr']=$result_data['whtpr'];

			// unset calculated value
			unset($result_data['beamt']);
			unset($result_data['netwr']);

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
		$tbName = 'vbak';

		// Start for report
		function createQuery($_this){
			$query = $_this->input->get('query');
			if(!empty($query)){
				$_this->db->where("(vbeln LIKE '%$query%'
				OR kunnr LIKE '%$query%'
				OR name1 LIKE '%$query%'
				OR jobnr LIKE '%$query%'
				OR jobtx LIKE '%$query%'
				OR sname LIKE '%$query%')", NULL, FALSE);
			}


	        $vbeln1 = $_this->input->get('vbeln');
			$vbeln2 = $_this->input->get('vbeln2');
			if(!empty($vbeln1) && empty($vbeln2)){
			  $_this->db->where('vbeln', $vbeln1);
			}
			elseif(!empty($vbeln1) && !empty($vbeln2)){
			  $_this->db->where('vbeln >=', $vbeln1);
			  $_this->db->where('vbeln <=', $vbeln2);
			}

			$bldat1 = $_this->input->get('bldat');
			$bldat2 = $_this->input->get('bldat2');
			if(!empty($bldat1) && empty($bldat2)){
			  $_this->db->where('bldat >=', $bldat1);
			}
			elseif(!empty($bldat1) && !empty($bldat2)){
			  $_this->db->where('bldat >=', $bldat1);
			  $_this->db->where('bldat <=', $bldat2);
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

			// query for limit user
			//if(XUMS::CAN_DISPLAY('QT') && XUMS::CAN_APPROVE('QT')){
			//	$_this->db->where('beamt <=', XUMS::LIMIT('QT'));
			//}else{
			//	$_this->db->where('ernam', XUMS::USERNAME());
			//}
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

    function loads_deposit(){
		$this->db->set_dbprefix('v_');
		$tbName = 'depo2';

		// Start for report
		function createQuery($_this){
			$query = $_this->input->get('query');
			if(!empty($query)){
				$_this->db->where("(vbeln LIKE '%$query%'
				OR kunnr LIKE '%$query%'
				OR name1 LIKE '%$query%'
				OR jobnr LIKE '%$query%'
				OR jobtx LIKE '%$query%'
				OR sname LIKE '%$query%')", NULL, FALSE);
			}


	        $vbeln1 = $_this->input->get('vbeln');
			$vbeln2 = $_this->input->get('vbeln2');
			if(!empty($vbeln1) && empty($vbeln2)){
			  $_this->db->where('vbeln', $vbeln1);
			}
			elseif(!empty($vbeln1) && !empty($vbeln2)){
			  $_this->db->where('vbeln >=', $vbeln1);
			  $_this->db->where('vbeln <=', $vbeln2);
			}

			$bldat1 = $_this->input->get('bldat');
			$bldat2 = $_this->input->get('bldat2');
			if(!empty($bldat1) && empty($bldat2)){
			  $_this->db->where('bldat >=', $bldat1);
			}
			elseif(!empty($bldat1) && !empty($bldat2)){
			  $_this->db->where('bldat >=', $bldat1);
			  $_this->db->where('bldat <=', $bldat2);
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

			$_this->db->where('payty', '1');
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
		$id = $this->input->post('id');
		$query = null;

		$status_changed = false;
		$inserted_id = false;
		$net = floatval($this->input->post('netwr'));
		$kunnr = $this->input->post('kunnr');
		if(!empty($id)){
			$this->db->limit(1);
			$this->db->where('vbeln', $id);
			$query = $this->db->get('vbak');

			// ##### CHECK PERMISSIONS
			$row = $query->first_row('array');
			// status has change
			$status_changed = $row['statu']!=$this->input->post('statu');
			if($status_changed&&$row['statu']!=03){
				if(XUMS::CAN_DISPLAY('QT') && XUMS::CAN_APPROVE('QT')){
					$limit = XUMS::LIMIT('QT');
					if($this->input->post('statu')==01){
						$emsg = 'Cannot Change status to waiting for approve';
						echo json_encode(array(
							'success'=>false,
							'errors'=>array( 'statu' => $emsg ),
							'message'=>$emsg
						));
						return;
					}
					else if($limit<$row['netwr']){
						$emsg = 'You do not have permission to change quotaion status over than '.number_format($limit);
						echo json_encode(array(
							'success'=>false,
							'errors'=>array( 'statu' => $emsg ),
							'message'=>$emsg
						));
						return;
					}
				}else{
					$emsg = 'You do not have permission to change quotaion status.';
					echo json_encode(array(
						'success'=>false,
						'errors'=>array( 'statu' => $emsg ),
						'message'=>$emsg
					));
					return;
				}
			}else{
				if($row['statu']=='02'||$row['statu']=='03'){
					$emsg = 'The quotation that already approved or rejected cannot be update.';
					echo json_encode(array(
						'success'=>false,
						'message'=>$emsg
					));
					return;
				}
			}
			// ##### END CHECK PERMISSIONS
		}else{

		$this->db->where('kunnr', $kunnr);
		$q_limit = $this->db->get('kna1');
		$reman=0;
		
		if($q_limit->num_rows()>0){
			$r_limit = $q_limit->first_row('array');
			$reman = $r_limit['reman'] + $net;
			$limit = $r_limit['endin'];
			$apamt = $r_limit['apamt'];
			if($net>$limit){
            	$emsg = 'The quotation total have amount more than limit amount.';
					echo json_encode(array(
						'success'=>false,
						'message'=>$emsg
					));
					return;
            }
            
			if($reman>$apamt){
            	$emsg = 'The customer have amount more than credit limit.';
					echo json_encode(array(
						'success'=>false,
						'message'=>$emsg
					));
					return;
            }
		  }
	 	}
		
        $payp = $this->input->post('payp');//$this->input->post('vbelp');
		$pp_item_array = json_decode($payp);
		/*if(!empty($payp) && !empty($pp_item_array)){
			// loop เพื่อ insert pay_item ที่ส่งมาใหม่
			$pramt = 0;$amt = 0;$total=0;
			foreach($pp_item_array AS $p){
				$perct = $p->perct;
				$amt = floatval($this->input->post('beamt')) - floatval($this->input->post('dismt'));
				$pos = strpos($perct, '%');
				if($pos==false){
					$pramt = $perct;
				}else{
					$perc = explode('%',$perct);
					$pramt = $amt * $perc[0];
					$pramt = $pramt / 100;
				}
				$total+=$pramt;
			}
            if($total>$net){
            	$emsg = 'The patial payment total have amount more than quotation total.';
					echo json_encode(array(
						'success'=>false,
						'message'=>$emsg
					));
					return;
            }
		}*/

        
		$formData = array(
			//'vbeln' => $this->input->post('vbeln'),
			'bldat' => $this->input->post('bldat'),
			'statu' => $this->input->post('statu'),
			'txz01' => $this->input->post('txz01'),
			'jobnr' => $this->input->post('jobnr'),
			'auart' => $this->input->post('auart'),
			'reanr' => $this->input->post('reanr'),
			'refnr' => $this->input->post('refnr'),
			'ptype' => $this->input->post('ptype'),
			'taxnr' => $this->input->post('taxnr'),
			'terms' => intval($this->input->post('terms')),
			'kunnr' => $this->input->post('kunnr'),
			'netwr' => floatval($this->input->post('netwr')),
			'beamt' => floatval($this->input->post('beamt')),
			'dismt' => floatval($this->input->post('dismt')),
			'dispc' => floatval($this->input->post('dispc')),
			'taxpr' => floatval($this->input->post('taxpr')),
			'salnr' => $this->input->post('salnr'),
			'ctype' => $this->input->post('ctype'),
			'exchg' => floatval($this->input->post('exchg')),
			'whtnr' => $this->input->post('whtnr'),
			'vat01' => floatval($this->input->post('vat01')),
			'wht01' => floatval($this->input->post('wht01')),
			'whtxt' => $this->input->post('whtxt'),
			'ftype' => $this->input->post('ftype')
		);

		// start transaction
		$this->db->trans_start();

		$current_username = XUMS::USERNAME();

		if (!empty($query) && $query->num_rows() > 0){
			$this->db->where('vbeln', $id);
			//$this->db->set('updat', 'NOW()', false);
			db_helper_set_now($this, 'updat');
			$this->db->set('upnam', $current_username);
			$this->db->update('vbak', $formData);
			
// Credit limit -> Reject case
        $this->db->where('kunnr', $kunnr);
		$q_limit = $this->db->get('kna1');
		$reman=0;
		
		if($q_limit->num_rows()>0){
		   $r_limit = $q_limit->first_row('array');	
        if($this->input->post('statu') == '03'){
			$reman = $r_limit['reman'] - $net;
			
			if(!empty($kunnr)){	
			$this->db->where('kunnr', $kunnr);
			$this->db->set('upamt', $net);
			$this->db->set('reman', $reman);
			$this->db->update('kna1');
		    }	
        }else{
        	//Upate limit remain			
		    if(!empty($kunnr)){
		      $reman = $net - $row['netwr'];
		      $reman = $r_limit['reman'] - $reman;
			  $this->db->where('kunnr', $kunnr);
			  $this->db->set('upamt', $net);
			  $this->db->set('reman', $reman);
			  $this->db->update('kna1');
			}
          }
		}

		}else{
			$id = $this->code_model->generate('QT', $this->input->post('bldat'));
			$this->db->set('vbeln', $id);
			//$this->db->set('erdat', 'NOW()', false);
			db_helper_set_now($this,'erdat');
		    $this->db->set('ernam', $current_username);
			$this->db->insert('vbak', $formData);

			$inserted_id = $id;
			
//Upate limit remain			
		    if(!empty($kunnr)){	
			$this->db->where('kunnr', $kunnr);
			$this->db->set('upamt', $net);
			$this->db->set('reman', $reman);
			$this->db->update('kna1');
			}
		}

		// ลบ pr_item ภายใต้ id ทั้งหมด
		$this->db->where('vbeln', $id);
		$this->db->delete('vbap');
		
        $vbap = $this->input->post('vbap');//$this->input->post('vbelp');
		$qt_item_array = json_decode($vbap);
		// เตรียมข้อมูล  qt item
		if(!empty($vbap) && !empty($qt_item_array)){
			// loop เพื่อ insert pr_item ที่ส่งมาใหม่
			$item_index = 0;
			foreach($qt_item_array AS $p){
				$itamt = $p->menge * $p->unitp;
				$itamt = $itamt - $p->disit;
				$this->db->insert('vbap', array(
					'vbeln'=>$id,
					'vbelp'=>intval(++$item_index),//vbelp,
					'matnr'=>$p->matnr,
					'menge'=>floatval($p->menge),
					'meins'=>$p->meins,
					'disit'=>$p->disit,
					'unitp'=>floatval($p->unitp),
					'itamt'=>floatval($itamt),
					'ctype'=>$p->ctype,
					'chk01'=>$p->chk01,
					'chk02'=>$p->chk02
				));
			}
		}

		// ลบ pay_item ภายใต้ id ทั้งหมด
		$this->db->where('vbeln', $id);
		$this->db->delete('payp');

		// เตรียมข้อมูล pay item
		//$payp = $this->input->post('payp');//$this->input->post('vbelp');
		//$pp_item_array = json_decode($payp);
		if(!empty($payp) && !empty($pp_item_array)){
            $item_index = 0;
			// loop เพื่อ insert pay_item ที่ส่งมาใหม่
			$pramt = 0;$amt = 0;
			foreach($pp_item_array AS $p){
				$perct = $p->perct;
				$amt = floatval($this->input->post('beamt')) - floatval($this->input->post('dismt'));
				$pos = strpos($perct, '%');
				if($pos==false){
					$pramt = $perct;
				}else{
					$perc = explode('%',$perct);
					$pramt = $amt * $perc[0];
					$pramt = $pramt / 100;
				}
               
				$this->db->insert('payp', array(
					'vbeln'=>$id,
					'paypr'=>intval(++$item_index),
					'sgtxt'=>$p->sgtxt,
					'duedt'=>$p->duedt,
					'perct'=>$p->perct,
					'pramt'=>floatval($pramt),
					'ctyp1'=>$p->ctyp1,
					'payty'=>$p->payty,
					'chk01'=>1
				));
			}
		}

		// end transaction
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE){
			echo json_encode(array(
				'success'=>false
			));
		}else{
			echo json_encode(array(
				'success'=>true,
				// also send id after save
				'data'=> array(
					'id'=>$id
				)
			));

			try{
				$post_id = $this->input->post('id');
				$total_amount = floatval($this->input->post('netwr'));
				// send notification email
				if(!empty($inserted_id)){
					$q_row = $this->db->get_where('vbak', array('vbeln'=>$inserted_id));
					$row = $q_row->first_row();
					$this->email_service->sendmail_create(
						'QT', 'Quotation',
						$inserted_id, $total_amount,
						$row->ernam
					);
				}else if(!empty($post_id)){
					if($status_changed){
						$q_row = $this->db->get_where('vbak', array('vbeln'=>$post_id));
						$row = $q_row->first_row();
						$this->email_service->sendmail_change_status(
							'QT', 'Quotation',
							$post_id, $total_amount, $row->statu,
							$row->ernam
						);
					}
				}
			}catch(exception $e){}
		}
	}

    public function loads_scombo(){
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

    public function loads_taxcombo(){
		$tbName = 'tax1';
		$tbPK = 'taxnr';

		$query = $this->input->post('query');

		$totalCount = $this->db->count_all_results($tbName);

		if(!empty($query) && $query!=''){
			$this->db->or_like('taxtx', $query);
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
		$this->db->where('vbeln', $id);
		$query = $this->db->delete('vbak');
		echo json_encode(array(
			'success'=>true,
			'data'=>$id
		));
	}

	///////////////////////////////////////////////
	// Quotation ITEM
	///////////////////////////////////////////////

	function loads_qt_item(){
        $this->db->set_dbprefix('v_');
		$qt_id = $this->input->get('vbeln');
		$this->db->where('vbeln', $qt_id);

		$query = $this->db->get('vbap');
		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$query->num_rows()
		));
	}

	function loads_pay_item(){
        //$this->db->set_dbprefix('v_');
		$pp_id = $this->input->get('vbeln');
		$this->db->where('vbeln', $pp_id);

		$query = $this->db->get('payp');
		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$query->num_rows()
		));
	}

    function loads_conp_item(){
        $menge = $this->input->get('menge');
		$unitp = $this->input->get('unitp');
		$disit = $this->input->get('disit');
		$vvat = $this->input->get('vvat');
		$vwht = $this->input->get('vwht');
		$vat = $this->input->get('vat');
		$wht = $this->input->get('wht');
		$vattype = $this->input->get('vattype');
		$amt = $menge * $unitp;
		$i=0;$vamt=0;$damt=0;

		$result = array();
	    $query = $this->db->get('cont');
        if($query->num_rows()>0){
			$rows = $query->result_array();
			foreach($rows AS $row){

					if($row['conty']=='01'){
						//if(empty($disit)) $disit=0;
                        $pos = strpos($disit, '%');
						if($pos==false){
							$damt = $disit;
						}else{
							$perc = explode('%',$disit);
							$damt = $amt * $perc[0];
							$damt = $damt / 100;
						}
						
						$tamt = $amt - $damt;
						if($vattype=='02'){
			                   $tamt = $tamt * 100;
			                   $tamt = $tamt / 107;
		                }
						$amt = $tamt;
						
						if(empty($damt)) $damt='0.00';

						$result[$i] = array(
					    'contx'=>$row['contx'],
				     	'vtamt'=>$damt,
					    'ttamt'=>$tamt
				        );
						$i++;
						/*array_push($result, array(
						    'contx'=>$row['contx'],
					     	'vtamt'=>$dismt,
						    'ttamt'=>$tamt
				        ));*/
					}elseif($row['conty']=='02'){
						if($vat=='true' || $vat=='1'){
							$vamt = ($tamt * $vvat) / 100;
							$tamt = $tamt + $vamt;
						$result[$i] = array(
					        'contx'=>$row['contx'],
				     	    'vtamt'=>$vamt,
					        'ttamt'=>$tamt
				        );
						$i++;
						}
					}elseif($row['conty']=='03'){
						//unset($result[2]);
						if($wht=='true' || $wht=='1'){
							$vwht = str_replace('%', ' ', $vwht);
							$vwht = ($amt * $vwht) / 100;
							$tamt = $amt - $vwht;
							$tamt = $tamt + $vamt;
						$result[$i] = array(
					        'contx'=>$row['contx'],
				     	    'vtamt'=>$vwht,
					        'ttamt'=>$tamt
				        );
					}
				}
			}}
		echo json_encode(array(
			'success'=>true,
			'rows'=>$result,
			'totalCount'=>count($result)
		));
	}

}
