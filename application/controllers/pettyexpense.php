<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pettyexpense extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->model('code_model','',TRUE);
		
		$this->load->model('email_service','',TRUE);
	}

	function index(){
		$this->phxview->RenderView('pettyexpense');
		$this->phxview->RenderLayout('default');
	}

	function load(){
		$this->db->set_dbprefix('v_');
		$tbName = 'ebek';
		
		$id = $this->input->post('id');
		$key = $this->input->post('key');
		if($key==1){
			$this->db->where('statu', '02');
		}
		
		$this->db->where('invnr', $id);
		$query = $this->db->get('ebek');
		 
		if($query->num_rows()>0){
			
			$result_data = $query->first_row('array');
			$result_data['id'] = $result_data['invnr'];

			$result_data['adr01'] .= $result_data['distx'].' '.$result_data['pstlz'].
			                         PHP_EOL.'Tel: '.$result_data['telf1'].' '.'Fax: '.
			                         $result_data['telfx'].
									 PHP_EOL.'Email: '.$result_data['email'];

			// unset calculated value
			unset($result_data['beamt']);
			unset($result_data['netwr']);
			
			$result_data['whtpr']=number_format($result_data['whtpr']);
			
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
		$tbName = 'ebek';
		
		$totalCount = $this->db->count_all_results($tbName);

		//createQuery($this);
		//$limit = $this->input->get('limit');
		//$start = $this->input->get('start');
		//if(isset($limit) && isset($start)) $this->db->limit($limit, $start);

		$query = $this->db->get($tbName);

		//echo $this->db->last_query();
		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$totalCount
		));
	}

	function loads(){
		$this->db->set_dbprefix('v_');
		$tbName = 'ebek';

		// Start for report
		function createQuery($_this){
			$query = $_this->input->get('query');
			if(!empty($query)){
				$_this->db->where("(invnr LIKE '%$query%'
				OR lifnr LIKE '%$query%'
				OR name1 LIKE '%$query%'
				OR remnr LIKE '%$query%')", NULL, FALSE);
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
			
            $remnr1 = $_this->input->get('remnr');
			$remnr2 = $_this->input->get('remnr2');
			if(!empty($remnr1) && empty($remnr2)){
			  $_this->db->where('remnr', $remnr1);
			}
			elseif(!empty($remnr1) && !empty($remnr2)){
			  $_this->db->where('remnr >=', $remnr1);
			  $_this->db->where('remnr <=', $remnr2);
			}

            $invnr1 = $_this->input->get('invnr');
			$invnr2 = $_this->input->get('invnr2');
			if(!empty($invnr1) && empty($invnr2)){
			  $_this->db->where('invnr', $invnr1);
			}
			elseif(!empty($invnr1) && !empty($invnr2)){
			  $_this->db->where('invnr >=', $invnr1);
			  $_this->db->where('invnr <=', $invnr2);
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
			'totalCount'=>2//$totalCount
		));
	}

    function loads_report(){
		$this->db->set_dbprefix('v_');
		$tbName = 'ebep';

		// Start for report
		function createQuery($_this){
			$query = $_this->input->get('query');
			if(!empty($query)){
				$_this->db->where("(invnr LIKE '%$query%'
				OR lifnr LIKE '%$query%'
				OR name1 LIKE '%$query%'
				OR remnr LIKE '%$query%')", NULL, FALSE);
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
			
            $remnr1 = $_this->input->get('remnr');
			$remnr2 = $_this->input->get('remnr2');
			if(!empty($remnr1) && empty($remnr2)){
			  $_this->db->where('remnr', $remnr1);
			}
			elseif(!empty($remnr1) && !empty($remnr2)){
			  $_this->db->where('remnr >=', $remnr1);
			  $_this->db->where('remnr <=', $remnr2);
			}

            $invnr1 = $_this->input->get('invnr');
			$invnr2 = $_this->input->get('invnr2');
			if(!empty($invnr1) && empty($invnr2)){
			  $_this->db->where('invnr', $invnr1);
			}
			elseif(!empty($invnr1) && !empty($invnr2)){
			  $_this->db->where('invnr >=', $invnr1);
			  $_this->db->where('invnr <=', $invnr2);
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
		if(!empty($id)){
			$this->db->limit(1);
			$this->db->where('invnr', $id);
			$query = $this->db->get('ebek');
			
			// ##### CHECK PERMISSIONS
			$row = $query->first_row('array');
			// status has change
			$status_changed = $row['statu']!=$this->input->post('statu');
			if($status_changed&&$row['statu']!=02&&$row['statu']!=03){
				if(XUMS::CAN_DISPLAY('PE') && XUMS::CAN_APPROVE('PE')){
					$limit = XUMS::LIMIT('PE');
					if($limit<$row['netwr']){
						$emsg = 'You do not have permission to change Petty Cash status over than '.number_format($limit);
						echo json_encode(array(
							'success'=>false,
							'errors'=>array( 'statu' => $emsg ),
							'message'=>$emsg
						));
						return;
					}
				}else{
					$emsg = 'You do not have permission to change Petty Cash status.';
					echo json_encode(array(
						'success'=>false,
						'errors'=>array( 'statu' => $emsg ),
						'message'=>$emsg
					));
					return;
				}
			}else{
				if($row['statu']=='02'||$row['statu']=='03'){
					$emsg = 'The Petty Cash that already approved or rejected cannot be update.';
					echo json_encode(array(
						'success'=>false,
						'message'=>$emsg
					));
					return;
				}
			}
			// ##### END CHECK PERMISSIONS
			}else{
				if($this->input->post('loekz')=='2'){
        	    $emsg = 'The GR already created AP doc.';
					echo json_encode(array(
						'success'=>false,
						'message'=>$emsg
					));
					return;
            }
		}
			
		$bven = $this->input->post('bsid');
		$gl_item_array = json_decode($bven);
		foreach($gl_item_array AS $p){
			if(empty($p->saknr) && $p->sgtxt == 'Total'){
		    if($p->debit != $p->credi){
						$emsg = 'Banlance Amount not equal';
						echo json_encode(array(
							'success'=>false,
							//'errors'=>array( 'statu' => $emsg ),
							'message'=>$emsg
						));
						return;
					}
		}
		}

        if($this->input->post('whtnr')=='6' && $this->input->post('whtxt')==''){
        	$emsg = 'The WHT Type 6 is required to fill in WHT Text';
					echo json_encode(array(
						'success'=>false,
						'message'=>$emsg
					));
					return;
        }
		
		$netwr = str_replace(",","",$this->input->post('netwr'));
		$formData = array(
			'bldat' => $this->input->post('bldat'),
			'lifnr' => $this->input->post('lifnr'),
			'taxnr' => $this->input->post('taxnr'),
			'refnr' => $this->input->post('refnr'),
			'remnr' => $this->input->post('remnr'),  //GR Doc.
			'ptype' => $this->input->post('ptype'),
			'terms' => intval($this->input->post('terms')),
			'dismt' => floatval($this->input->post('dismt')),
			'taxpr' => floatval($this->input->post('taxpr')),
			'txz01' => $this->input->post('txz01'),
			'beamt' => floatval($this->input->post('beamt')),
			'vat01' => floatval($this->input->post('vat01')),
			'wht01' => floatval($this->input->post('wht01')),
			'netwr' => floatval($this->input->post('netwr')),
			'ptype' => $this->input->post('ptype'),
			'exchg' => floatval($this->input->post('exchg')),
			'statu' => $this->input->post('statu'),
			'ctype' => $this->input->post('ctype'),
			'whtnr' => $this->input->post('whtnr'),
			'whtxt' => $this->input->post('whtxt'),
			'duedt' => $this->input->post('duedt'),
			'deamt' => floatval($this->input->post('deamt'))
		);

		// start transaction
		$this->db->trans_start();
		
		$current_username = XUMS::USERNAME();
		
		if(db_helper_is_mysql($this)){
			$sql = "SELECT remnr,reman,dispc FROM tbl_ebtk".
			" WHERE remnr LIKE 'CPV%'"
			." ORDER BY remnr DESC LIMIT 1";
		    }
			
		    if(db_helper_is_mssql($this)){
			$sql = "SELECT TOP 1 remnr,reman,dispc FROM tbl_ebtk".
			" WHERE remnr LIKE 'CPV%'"
			." ORDER BY remnr DESC ";
		    }	
		$q_code = $this->db->query($sql);

		if (!empty($query) && $query->num_rows() > 0){
			$this->db->where('invnr', $id);
			//$this->db->set('updat', 'NOW()', false);
			db_helper_set_now($this, 'updat');
			$this->db->set('upnam', $current_username);
			$this->db->update('ebek', $formData);
			
			if($q_code->num_rows()>0){
		      $r_code = $q_code->first_row('array');
			  $reman = $this->input->post('netwr') - $row['netwr'];
			  $dispc = $r_code['dispc'] - $reman;
			  $reman = $r_code['reman'] + $reman;
			  
			  $this->db->where('remnr', $r_code['remnr']);
			  $this->db->set('reman', floatval($reman));
			  $this->db->set('dispc', floatval($dispc));
			  $this->db->set('upamt', floatval($this->input->post('netwr')));
			  $this->db->update('ebtk');
		    }
		}else{
			$id = $this->code_model->generate('PC', 
			$this->input->post('bldat'));
			$this->db->set('invnr', $id);
			//$this->db->set('erdat', 'NOW()', false);
			db_helper_set_now($this, 'erdat');
			$this->db->set('ernam', $current_username);
			$this->db->insert('ebek', $formData);
			
			$inserted_id = $id;
            
	    if($q_code->num_rows()>0){
		    $r_code = $q_code->first_row('array');
			$reman = $r_code['reman'] + $this->input->post('netwr');
			$dispc = $r_code['dispc'] - $this->input->post('netwr');
			$this->db->where('remnr', $r_code['remnr']);
			$this->db->set('reman', floatval($reman));
			$this->db->set('dispc', floatval($dispc));
			$this->db->set('upamt', floatval($this->input->post('netwr')));
			$this->db->update('ebtk');
		}

		}// end save

		// ลบ pr_item ภายใต้ id ทั้งหมด
		$this->db->where('invnr', $id);
		$this->db->delete('ebep');

		// เตรียมข้อมูล  qt item
		$ebrp = $this->input->post('ebep');//$this->input->post('vbelp');
		$ap_item_array = json_decode($ebrp);
		if(!empty($ebrp) && !empty($ap_item_array)){
			// loop เพื่อ insert ap_item ที่ส่งมาใหม่
			$item_index = 0;
			foreach($ap_item_array AS $p){
				$itamt = $p->menge * $p->unitp;
		        $itamt = $itamt - $p->disit;
				$this->db->insert('ebep', array(
					'invnr'=>$id,
					'ebelp'=>intval(++$item_index),//vbelp,
					'matnr'=>$p->matnr,
					'menge'=>floatval($p->menge),
					'meins'=>$p->meins,
					'disit'=>$p->disit,
					'unitp'=>floatval($p->unitp),
					'itamt'=>floatval($p->itamt),
					'chk01'=>$p->chk01,
					'chk02'=>$p->chk02,
					'ctype'=>$p->ctype
				));
			}
		}
	
// Save GL Posting	
    if($this->input->post('statu') == '02'){
        //$ids = $id;	
        
		$ids = $this->input->post('id');
		$query = null;
		if(!empty($ids)){
			$this->db->limit(1);
			$this->db->where('invnr', $ids);
			$query = $this->db->get('bkpf');
		}
		$date = date('Ymd');
		$formData = array(
		    'gjahr' => substr($date,0,4),
		    'bldat' => $this->input->post('bldat'),
			'invnr' => $id,
			'txz01' => 'PC No '.$id,
			'ttype' => '05',
			'auart' => 'PE',
			'kunnr' => $this->input->post('lifnr'),
			'netwr' => $this->input->post('netwr')
		);
		
		// start transaction
		$this->db->trans_start();  
		
		if (!empty($query) && $query->num_rows() > 0){
			$q_gl = $query->first_row('array');
			$accno = $q_gl['belnr'];
			$this->db->where('belnr', $accno);
			//$this->db->set('updat', 'NOW()', false);
			db_helper_set_now($this, 'updat');
			$this->db->set('upnam', $current_username);
			$this->db->update('bkpf', $formData);
		}else{
			$accno = $this->code_model->generate('PE', 
			$this->input->post('bldat'));
			$this->db->set('belnr', $accno);
			//$this->db->set('erdat', 'NOW()', false);
			db_helper_set_now($this, 'erdat');
		    $this->db->set('ernam', $current_username);
			$this->db->insert('bkpf', $formData);
			
			//$id = $this->db->insert_id();
		}
		
		// ลบ gl_item ภายใต้ id ทั้งหมด
		
		$this->db->where('belnr', $accno);
		$this->db->delete('bven');

		// เตรียมข้อมูล pay item
		$bsid = $this->input->post('bsid');//$this->input->post('vbelp');
		$gl_item_array = json_decode($bsid);
		if(!empty($bsid) && !empty($gl_item_array)){

			$item_index = 0;
			// loop เพื่อ insert pay_item ที่ส่งมาใหม่
			foreach($gl_item_array AS $p){
				if(!empty($p->txz01))$p->txz01='PC No '.$id;
				if(!empty($p->saknr)){
				$this->db->insert('bsid', array(
					'belnr'=>$accno,
					'belpr'=>++$item_index,
					'gjahr' => substr($date,0,4),
					'saknr'=>$p->saknr,
					'debit'=>$p->debit,
					'credi'=>$p->credi,
					'kunnr'=> $this->input->post('lifnr'),
					'bldat'=>$this->input->post('bldat'),
					'txz01'=>$p->txz01
				));
			  }
			}
		}
	}//check status approved
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
					$q_row = $this->db->get_where('ebek', array('invnr'=>$inserted_id));
					$row = $q_row->first_row();
					$this->email_service->sendmail_create(
						'PE', 'Petty Cash',
						$inserted_id, $total_amount,
						$row->ernam
					);
				}else if(!empty($post_id)){
					if($status_changed){
						$q_row = $this->db->get_where('ebek', array('invnr'=>$post_id));
						$row = $q_row->first_row();
						$this->email_service->sendmail_change_status(
							'PE', 'Petty Cash',
							$post_id, $total_amount, $row->statu,
							$row->ernam
						);
					}
				}
			}catch(exception $e){}
		}
	}


	function remove(){
		$invnr = $this->input->post('invnr'); 
		//echo $ebeln; exit;
		$this->db->where('invnr', $invnr);
		$query = $this->db->delete('ebek');
		
		$this->db->where('invnr', $invnr);
		$query = $this->db->delete('ebep');
		echo json_encode(array(
			'success'=>true,
			'data'=>$invnr
		));
	}

	///////////////////////////////////////////////
	// PR ITEM
	///////////////////////////////////////////////
	function loads_ap_item(){

		    $ap_id = $this->input->get('invnr');
			$this->db->set_dbprefix('v_');
			$this->db->where('invnr', $ap_id);
			$query = $this->db->get('ebep');
		
		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$query->num_rows()
		));
	}
	
	function loads_gl_item(){
        
		$iv_id = $this->input->get('netpr');
        $result = array();
		if($iv_id!=0){
		   //$matnr = array();
		   $netpr = $this->input->get('netpr');  //Net amt
	       $vvat  = $this->input->get('vvat');    //VAT amt
		   $lifnr = $this->input->get('lifnr');  //Vendor Code
		   $vwht = $this->input->get('vwht');  //WHT amt
		   $itms = $this->input->get('items');  //Doc Type
		   $items = explode(',',$itms);
           
		   if(empty($vvat)) $vvat=0;
		   //if(empty($vwht)) $vwht=0;
		   
		   $net = $netpr + $vvat;
		   
           $i=0;$n=0;$vamt=0;$debit=0;$credit=0;
		   $result = array();
// record แรก
           if(!empty($items)){
			// loop เพื่อ insert
		for($j=0;$j<count($items);$j++){
			$item = explode('|',$items[$j]);
			if(!empty($item)){
			$glno = $item[0];
			$amt  = $item[1];
			}
			
			$qgl = $this->db->get_where('glno', array(
				'saknr'=>$glno));
			if($qgl->num_rows()>0){
		    $q_glno = $qgl->first_row('array');
			
			$result[$i] = array(
		    'belpr'=>$i + 1,
			'saknr'=>$glno,
			'sgtxt'=>$q_glno['sgtxt'],
			'debit'=>$amt,
			'credi'=>0
		);
		$i++;
		$debit = $debit + $amt;	
			}
	    }
		}
			
// record ที่สอง
        if($vvat>0){ 
		//	$net_tax = floatval($net) * 0.07;}
		$glvat = '1154-00';
		$qgl = $this->db->get_where('glno', array(
				'saknr'=>$glvat));
		if($qgl->num_rows()>0){
		$q_glno = $qgl->first_row('array');
		$result[$i] = array(
		    'belpr'=>$i + 1,
			'saknr'=>$glvat,
			'sgtxt'=>$q_glno['sgtxt'],
			'debit'=>$vvat,
			'credi'=>0
		);
		$i++;
		$debit = $debit + $vvat;	
		}}
		
// record ที่สาม
        $dewht = $net - $vwht;
        if($dewht>0){ 
		$glvat = '1111-00';
		$qgl = $this->db->get_where('glno', array(
				'saknr'=>$glvat));
		if($qgl->num_rows()>0){
		$q_glno = $qgl->first_row('array');
		$result[$i] = array(
		    'belpr'=>$i + 1,
			'saknr'=>$glvat,
			'sgtxt'=>$q_glno['sgtxt'],
			'debit'=>0,
			'credi'=>$dewht
		);
		$i++;
		$credit = $credit + $dewht;	
		}}
		
// record ที่สี่
        if($vwht>0){
		$glvat = '2132-02';
		$qgl = $this->db->get_where('glno', array(
				'saknr'=>$glvat));
		if($qgl->num_rows()>0){
		$q_glno = $qgl->first_row('array');
		$result[$i] = array(
		    'belpr'=>$i + 1,
			'saknr'=>$glvat,
			'sgtxt'=>$q_glno['sgtxt'],
			'debit'=>0,
			'credi'=>$vwht
		);
		$i++;
		$credit = $credit + $vwht;	
		}
		}
	
		if(!empty($debit) || !empty($credit)){
		$result[$i] = array(
		    'belpr'=>$i + 1,
			'saknr'=>'',
			'sgtxt'=>'Total',
			'debit'=>$debit,
			'credi'=>$credit
		);
		}
		echo json_encode(array(
			'success'=>true,
			'rows'=>$result,
			'totalCount'=>count($result)
		));
//In Case Edit and Display		   
		}else{
		    $i=0;
		   $result[$i] = array(
		    'belpr'=>$i + 1,
			'saknr'=>'',
			'sgtxt'=>'Total',
			'debit'=>0,
			'credi'=>0
			);
		   echo json_encode(array(
			  'success'=>true,
			  'rows'=>$result,
			  'totalCount'=>count($result)
		));
	  }
	}
}