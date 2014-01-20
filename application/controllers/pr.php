<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pr extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->model('code_model','',TRUE);
		$this->load->model('email_service','',TRUE);
	}

	function index(){
		$this->phxview->RenderView('pr2');
		$this->phxview->RenderLayout('default');
	}

	function load(){
		$this->db->set_dbprefix('v_');
		$id = $this->input->post('id');
		$this->db->limit(1);

		$this->db->where('purnr', $id);
		$query = $this->db->get('ebko');
		
		if($query->num_rows()>0){
			
			$result_data = $query->first_row('array');
			$result_data['id'] = $result_data['purnr'];

			$result_data['adr01'] .= ' '.$result_data['distx'].' '.$result_data['pstlz'].
			PHP_EOL.'Tel: '.$result_data['telf1'].' '.'Fax: '.
			$result_data['telfx'].
			PHP_EOL.'Email: '.$result_data['email'];

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
		$tbName = 'ebko';
		
		$limit = $this->input->get('limit');
		$start = $this->input->get('start');
		if(isset($limit) && isset($start)) $this->db->limit($limit, $start);

		// Start for report
		function createQuery($_this){
			
			$query = $_this->input->get('query');
			if(!empty($query)){
				$_this->db->where("(purnr LIKE '%$query%'
				OR lifnr LIKE '%$query%'
				OR name1 LIKE '%$query%'
				OR refnr LIKE '%$query%')", NULL, FALSE);
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

            $purnr1 = $_this->input->get('purnr');
			$purnr2 = $_this->input->get('purnr2');
			if(!empty($purnr1) && empty($purnr2)){
			  $_this->db->where('purnr', $purnr1);
			}
			elseif(!empty($purnr1) && !empty($purnr2)){
			  $_this->db->where('purnr >=', $purnr1);
			  $_this->db->where('purnr <=', $purnr2);
			}
			
			$lifnr1 = $_this->input->get('lifnr');
			$lifnr2 = $_this->input->get('lifnr2');
			if(!empty($lifnr1) && empty($lifnr2)){
			  $_this->db->where('kunnr', $lifnr1);
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
			//Get PR by Userlogin Department Accept Accounting
			$uname = XUMS::USERNAME();
			$sql = "select t1.uname, t1.empnr, t2.name1, t2.depnr
					from tbl_user t1
					join tbl_empl t2 on t1.empnr=t2.empnr
					join tbl_depn t3 on t2.depnr=t3.depnr
					where t1.uname = '$uname'";
			$query = $_this->db->query($sql);

			$result = $query->result_array();
				$_this->db->where('depnr',$result[0]['depnr']);
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

	function loads_pr(){
		$this->db->set_dbprefix('v_');
		$tbName = 'ebko';
		
		$limit = $this->input->get('limit');
		$start = $this->input->get('start');
		if(isset($limit) && isset($start)) $this->db->limit($limit, $start);

		// Start for report
		function createQuery($_this){
			
			$query = $_this->input->get('query');
			if(!empty($query)){
				$_this->db->where("(purnr LIKE '%$query%'
				OR lifnr LIKE '%$query%'
				OR name1 LIKE '%$query%'
				OR refnr LIKE '%$query%')", NULL, FALSE);
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

            $purnr1 = $_this->input->get('purnr');
			$purnr2 = $_this->input->get('purnr2');
			if(!empty($purnr1) && empty($purnr2)){
			  $_this->db->where('purnr', $purnr1);
			}
			elseif(!empty($purnr1) && !empty($purnr2)){
			  $_this->db->where('purnr >=', $purnr1);
			  $_this->db->where('purnr <=', $purnr2);
			}
			
			$lifnr1 = $_this->input->get('lifnr');
			$lifnr2 = $_this->input->get('lifnr2');
			if(!empty($lifnr1) && empty($lifnr2)){
			  $_this->db->where('kunnr', $lifnr1);
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
		$id = $this->input->post('id');
		$query = null;
		
		$status_changed = false;
		$inserted_id = false;
		$net = floatval($this->input->post('netwr'));
		$lifnr = $this->input->post('lifnr');
		if(!empty($id)){
			$this->db->limit(1);
			$this->db->where('purnr', $id);
			$query = $this->db->get('ebko');
			
			// ##### CHECK PERMISSIONS
			$row = $query->first_row('array');
			// status has change
			$status_changed = $row['statu']!=$this->input->post('statu');
			if($status_changed&&$row['statu']!=02&&$row['statu']!=02&&$row['statu']!=03){
				if(XUMS::CAN_DISPLAY('PR') && XUMS::CAN_APPROVE('PR')){
					$limit = XUMS::LIMIT('PR');
					if($limit<$row['netwr']){
						$emsg = 'You do not have permission to change PR status over than '.number_format($limit);
						echo json_encode(array(
							'success'=>false,
							'errors'=>array( 'statu' => $emsg ),
							'message'=>$emsg
						));
						return;
					}
				}else{
					$emsg = 'You do not have permission to change PR status.';
					echo json_encode(array(
						'success'=>false,
						'errors'=>array( 'statu' => $emsg ),
						'message'=>$emsg
					));
					return;
				}
			}else{
				if($row['statu']=='02'||$row['statu']=='03'){
					$emsg = 'The PR that already approved or rejected cannot be update.';
					echo json_encode(array(
						'success'=>false,
						'message'=>$emsg
					));
					return;
				}
			}
			// ##### END CHECK PERMISSIONS
		}else{

		$this->db->where('lifnr', $lifnr);
		$q_limit = $this->db->get('lfa1');
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
		//$netwr = str_replace(",","",floatval($this->input->post('netwr')));
		$formData = array(
			'bldat' => $this->input->post('bldat'),
			'lifnr' => $this->input->post('lifnr'),
			'lfdat' => $this->input->post('lfdat'),
			'taxnr' => $this->input->post('taxnr'),
			'refnr' => $this->input->post('refnr'),
			'terms' => intval($this->input->post('terms')),
			'beamt' => floatval($this->input->post('beamt')),
			'dismt' => floatval($this->input->post('dismt')),
			'taxpr' => floatval($this->input->post('taxpr')),
			'sgtxt' => $this->input->post('sgtxt'),
			'vat01' => floatval($this->input->post('vat01')),
			'netwr' => floatval($this->input->post('netwr')),
			'ptype' => $this->input->post('ptype'),
			'exchg' => floatval($this->input->post('exchg')),
			'statu' => $this->input->post('statu'),
			'ctype' => $this->input->post('ctype')
		);

		// start transaction
		$this->db->trans_start();
		$current_username = XUMS::USERNAME();

		if (!empty($query) && $query->num_rows() > 0){
			$this->db->where('purnr', $id);
			//$this->db->set('updat', 'NOW()', false);
			db_helper_set_now($this, 'updat');
			$this->db->set('upnam', $current_username);
			$this->db->update('ebko', $formData);
			
// Credit limit -> Reject case
        if($this->input->post('statu') == '03'){
        	$this->db->where('lifnr', $kunnr);
		    $q_limit = $this->db->get('lfa1');
		    $reman=0;
		
		if($q_limit->num_rows()>0){
			$r_limit = $q_limit->first_row('array');
			$reman = $r_limit['reman'] - $net;
			
			if(!empty($kunnr)){	
			$this->db->where('lifnr', $lifnr);
			$this->db->set('upamt', $net);
			$this->db->set('reman', $reman);
			$this->db->update('lfa1');
			}
		}	
        }
		
		}else{
			
			$id = $this->code_model->generate('PR', $this->input->post('bldat'));
			$this->db->set('purnr', $id);
			//$this->db->set('erdat', 'NOW()', false);
			db_helper_set_now($this, 'erdat');
			$this->db->set('ernam', $current_username);
			$this->db->insert('ebko', $formData);
			
			$inserted_id = $id;
			
//Upate limit remain			
		    if(!empty($lifnr)){	
			$this->db->where('lifnr', $lifnr);
			$this->db->set('upamt', $net);
			$this->db->set('reman', $reman);
			$this->db->update('lfa1');
			}
			
		}

		// ลบ pr_item ภายใต้ id ทั้งหมด
		$this->db->where('purnr', $id);
		$this->db->delete('ebpo');

		// เตรียมข้อมูล  qt item
		$ebpo = $this->input->post('ebpo');//$this->input->post('vbelp');
		$qt_item_array = json_decode($ebpo);
		if(!empty($ebpo) && !empty($qt_item_array)){
			// loop เพื่อ insert pr_item ที่ส่งมาใหม่
			$item_index = 0;
			foreach($qt_item_array AS $p){
				$this->db->insert('ebpo', array(
					'purnr'=>$id,
					'purpr'=>++$item_index,//vbelp,
					'matnr'=>$p->matnr,
					'menge'=>$p->menge,
					'meins'=>$p->meins,
					'disit'=>$p->disit,
					'unitp'=>$p->unitp,
					'itamt'=>$p->itamt,
					'chk01'=>$p->chk01,
					'ctype'=>$p->ctype
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
					$q_row = $this->db->get_where('ebko', array('purnr'=>$inserted_id));
					$row = $q_row->first_row();
					$this->email_service->sendmail_create(
						'PR', 'Purchase Requisition',
						$inserted_id, $total_amount,
						$row->ernam
					);
				}else if(!empty($post_id)){
					if($status_changed){
						$q_row = $this->db->get_where('ebko', array('purnr'=>$post_id));
						$row = $q_row->first_row();
						$this->email_service->sendmail_change_status(
							'PR', 'Purchase Requisition',
							$post_id, $total_amount, $row->statu,
							$row->ernam
						);
					}
				}
			}catch(exception $e){}
		}
	}

	function remove(){
		$purnr = $this->input->post('purnr'); 
		$this->db->where('purnr', $purnr);
		$query = $this->db->delete('ebko');
		
		$this->db->where('purnr', $purnr);
		$query = $this->db->delete('ebpo');
		echo json_encode(array(
			'success'=>true,
			'data'=>$purnr
		));
	}

	///////////////////////////////////////////////
	// PR ITEM
	///////////////////////////////////////////////


	function loads_pr_item(){
		$pr_id = $this->input->get('purnr');
		
		$this->db->set_dbprefix('v_');
		$this->db->where('purnr', $pr_id);
		$query = $this->db->get('ebpo');
		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$query->num_rows()
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
	
	function loads_conp_item(){
        $menge = $this->input->get('menge');
		$unitp = $this->input->get('unitp');
		$disit = $this->input->get('disit');
		$vvat = $this->input->get('vvat');
		//$vwht = $this->input->get('vwht');
		$vat = $this->input->get('vat');
		//$wht = $this->input->get('wht');
		$vattype = $this->input->get('vattype');
		$amt = $menge * $unitp;
        $i=0;$vamt=0;
		$result = array();
		
	    $query = $this->db->get('cont');
        if($query->num_rows()>0){
			$rows = $query->result_array();
			foreach($rows AS $row){

					if($row['conty']=='01'){
						if(empty($disit)) $disit=0;
						$tamt = $amt - $disit;
						if($vattype=='02'){
			                   $tamt = $tamt * 100;
			                   $tamt = $tamt / 107;
		                }
						$amt = $tamt;
						
						$result[$i] = array(
					    'contx'=>$row['contx'],
				     	'vtamt'=>$disit,
					    'ttamt'=>$tamt
				        );
						$i++;
					}elseif($row['conty']=='02'){
						if($vat=='true' || $vat=='1'){
							$vamt = ($amt * $vvat) / 100;
							$tamt = $amt + $vamt;
						$result[$i] = array(
					        'contx'=>$row['contx'],
				     	    'vtamt'=>$vamt,
					        'ttamt'=>$tamt
				        );
						$i++;
						}
					/*}elseif($row['conty']=='03'){
						if($wht=='true' || $wht=='1'){
							$vwht = ($amt * $vwht) / 100;
							$tamt = $amt - $vwht;
							$tamt = $tamt + $vamt;
						$result[$i] = array(
					        'contx'=>$row['contx'],
				     	    'vtamt'=>$vwht,
					        'ttamt'=>$tamt
				        );$i++;
					}*/
				}
			}}
		echo json_encode(array(
			'success'=>true,
			'rows'=>$result,
			'totalCount'=>count($result)
		));
	}
}