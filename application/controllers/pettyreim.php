<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pettyreim extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->model('code_model','',TRUE);
		
		$this->load->model('email_service','',TRUE);
	}

	function index(){
		$this->phxview->RenderView('ap');
		$this->phxview->RenderLayout('default');
	}

	function load(){
		$this->db->set_dbprefix('v_');
		$tbName = 'ebtk';
		
		$id = $this->input->post('id');
		$key = $this->input->post('key');
		if($key==1){
			$this->db->where('statu', '02');
		}
		$this->db->where('remnr', $id);
		$query = $this->db->get('ebtk');
		 
		if($query->num_rows()>0){
			
			$result_data = $query->first_row('array');
			$result_data['id'] = $result_data['remnr'];

			$result_data['adr01'] .= $result_data['distx'].' '.$result_data['pstlz'].
			                         PHP_EOL.'Tel: '.$result_data['telf1'].' '.'Fax: '.
			                         $result_data['telfx'].
									 PHP_EOL.'Email: '.$result_data['email'];

			// unset calculated value
			//unset($result_data['beamt']);
			//unset($result_data['netwr']);
			
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
	
	function load_remain(){
		$this->db->set_dbprefix('v_');
		$tbname = 'tbl_ebtk';
		$prefix = $this->input->post('id');
		
		if(db_helper_is_mysql($this)){
			$sql = "SELECT reman FROM ".$tbname.
			" WHERE remnr LIKE '".$prefix."%'"
			." ORDER BY remnr DESC LIMIT 1";
		}
			
		if(db_helper_is_mssql($this)){
			$sql = "SELECT TOP 1 reman FROM ".$tbname.
			" WHERE remnr LIKE '".$prefix."%'"
			." ORDER BY remnr DESC ";
		}
			
		$query = $this->db->query($sql);
            
	    if($query->num_rows()>0){
		$r_code = $query->first_row('array');
			
			echo json_encode(array(
			'success'=>true,
			'data'=>$r_code['reman'],
			'totalCount'=>$query->num_rows()
		     ));
		}else{
		echo json_encode(array(
			'success'=>false,
			'data'=>0,
			'totalCount'=>0
		));
		}
	}

	function loads(){
		$this->db->set_dbprefix('v_');
		$tbName = 'ebtk';

		// Start for report
		function createQuery($_this){
			$query = $_this->input->get('query');
			if(!empty($query)){
				$_this->db->where("(remnr LIKE '%$query%'
				OR lifnr LIKE '%$query%'
				OR name1 LIKE '%$query%')", NULL, FALSE);
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
		$tbName = 'ebtp';

		// Start for report
		function createQuery($_this){
			$query = $_this->input->get('query');
			if(!empty($query)){
				$_this->db->where("(invnr LIKE '%$query%'
				OR lifnr LIKE '%$query%'
				OR name1 LIKE '%$query%')", NULL, FALSE);
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
			$this->db->where('remnr', $id);
			$query = $this->db->get('ebtk');
			
			// ##### CHECK PERMISSIONS
			$row = $query->first_row('array');
			// status has change
			$status_changed = $row['statu']!=$this->input->post('statu');
			if($status_changed&&$row['statu']!=02&&$row['statu']!=02&&$row['statu']!=03){
				if(XUMS::CAN_DISPLAY('CPV') && XUMS::CAN_APPROVE('CPV')){
					$limit = XUMS::LIMIT('CPV');
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
		}

        $ebtp = $this->input->post('ebtp');
		$ap_item_array = json_decode($ebtp);
		if(!empty($ebtp) && !empty($ap_item_array)){
			foreach($ap_item_array AS $p){
				if(empty($p->bcode)){
					$emsg = 'Please enter bank code on item';
					echo json_encode(array(
						'success'=>false,
						'message'=>$emsg
					));
					return;
				}
			}}

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
		
		$netwr = $this->input->post('netwr');
		$reman = $this->input->post('reman');
		if(!empty($row['netwr'])){
			$reman = $reman + $row['netwr'];
		}
		$reman = $reman - $netwr;
		$formData = array(
			'bldat' => $this->input->post('bldat'),
			'lifnr' => $this->input->post('lifnr'),
			'refnr' => $this->input->post('refnr'),
			'dismt' => floatval($this->input->post('dismt')),
			'txz01' => $this->input->post('sgtxt'),
			'beamt' => floatval($this->input->post('beamt')),
			'netwr' => floatval($this->input->post('netwr')),
			'exchg' => floatval($this->input->post('exchg')),
			'statu' => $this->input->post('statu'),
			'ctype' => $this->input->post('ctype'),
			'reman' => floatval($reman),
			'dispc' => floatval($this->input->post('netwr')),
			'deamt' => floatval($this->input->post('deamt'))
		);

		// start transaction
		$this->db->trans_start();
		
		$current_username = XUMS::USERNAME();

		if (!empty($query) && $query->num_rows() > 0){
			$this->db->where('remnr', $id);
			//$this->db->set('updat', 'NOW()', false);
			db_helper_set_now($this, 'updat');
			$this->db->set('upnam', $current_username);
			$this->db->update('ebtk', $formData);
		}else{
			$id = $this->code_model->generate('CPV', 
			$this->input->post('bldat'));
			$this->db->set('remnr', $id);
			//$this->db->set('erdat', 'NOW()', false);
			db_helper_set_now($this, 'erdat');
			$this->db->set('ernam', $current_username);
			$this->db->insert('ebtk', $formData);
			
			$inserted_id = $id;
		}
		// ลบ pr_item ภายใต้ id ทั้งหมด
		$this->db->where('remnr', $id);
		$this->db->delete('ebtp');

		// เตรียมข้อมูล  qt item
		$ebtp = $this->input->post('ebtp');
		$ap_item_array = json_decode($ebtp);
		if(!empty($ebtp) && !empty($ap_item_array)){
			$item_index = 0;
			foreach($ap_item_array AS $p){
				$itamt = $p->menge * $p->unitp;
		        $itamt = $itamt - $p->disit;
				$this->db->insert('ebtp', array(
					'remnr'=>$id,
					'ebelp'=>intval(++$item_index),//vbelp,
					'matnr'=>$p->matnr,
					'menge'=>floatval($p->menge),
					'meins'=>$p->meins,
					'disit'=>$p->disit,
					'unitp'=>floatval($p->unitp),
					'itamt'=>floatval($itamt),
					'chk01'=>$p->chk01,
					'ctype'=>$p->ctype,
					'bcode'=>$p->bcode
				));
			}
		}
	
// Save GL Posting	
    if($this->input->post('statu') == '02'){
        
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
			'txz01' => 'CPV No '.$id,
			'ttype' => '05',
			'auart' => 'PE',
			'netwr' => floatval($this->input->post('netwr'))
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
			$accno = $this->code_model->generate('AP', 
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
		$this->db->delete('bsid');

		// เตรียมข้อมูล pay item
		$bsid = $this->input->post('bsid');//$this->input->post('vbelp');
		$gl_item_array = json_decode($bsid);
		if(!empty($bsid) && !empty($gl_item_array)){

			$item_index = 0;
			// loop เพื่อ insert pay_item ที่ส่งมาใหม่
			foreach($gl_item_array AS $p){
				if(!empty($p->txz01))$p->txz01='CPV No '.$id;
				if(!empty($p->saknr)){
				$this->db->insert('bsid', array(
					'belnr'=>$accno,
					'belpr'=>intval(++$item_index),
					'gjahr' => substr($date,0,4),
					'saknr'=>$p->saknr,
					'debit'=>floatval($p->debit),
					'credi'=>floatval($p->credi),
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
					$q_row = $this->db->get_where('ebtk', array('remnr'=>$inserted_id));
					$row = $q_row->first_row();
					$this->email_service->sendmail_create(
						'CPV', 'Petty Cash Reimbursement',
						$inserted_id, $total_amount,
						$row->ernam
					);
				}else if(!empty($post_id)){
					if($status_changed){
						$q_row = $this->db->get_where('ebtk', array('remnr'=>$post_id));
						$row = $q_row->first_row();
						$this->email_service->sendmail_change_status(
							'CPV', 'Petty Cash Reimbursement',
							$post_id, $total_amount, $row->statu,
							$row->ernam
						);
					}
				}
			}catch(exception $e){}
		}
	}


	function remove(){
		$remnr = $this->input->post('remnr'); 
		//echo $ebeln; exit;
		$this->db->where('remnr', $remnr);
		$query = $this->db->delete('ebtk');
		
		$this->db->where('remnr', $remnr);
		$query = $this->db->delete('ebtp');
		echo json_encode(array(
			'success'=>true,
			'data'=>$invnr
		));
	}

	///////////////////////////////////////////////
	// PR ITEM
	///////////////////////////////////////////////
	function loads_ap_item(){
		
		$ap_id = $this->input->get('remnr');

	    $this->db->set_dbprefix('v_');
		$this->db->where('remnr', $ap_id);
		$query = $this->db->get('ebtp');
		
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
		   $net = $this->input->get('netpr');  //Net amt
	       $saknr2  = $this->input->get('saknr2');    //VAT amt
		   //$lifnr = $this->input->get('lifnr');  //Vendor Code
		   //$ptype = $this->input->get('ptype');  //Pay Type
		   $itms = $this->input->get('items');  //Doc Type
		   $items = explode(',',$itms);
           
		   //if(empty($vvat)) $vvat=0;
		   //if(empty($vwht)) $vwht=0;
		   
		   //$net = $netpr + $vvat;
		   
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
        if(!empty($saknr2)){ 
		//	$net_tax = floatval($net) * 0.07;}
		$glvat = $saknr2;
		$qgl = $this->db->get_where('glno', array(
				'saknr'=>$glvat));
		if($qgl->num_rows()>0){
		$q_glno = $qgl->first_row('array');
		$result[$i] = array(
		    'belpr'=>$i + 1,
			'saknr'=>$glvat,
			'sgtxt'=>$q_glno['sgtxt'],
			'debit'=>0,
			'credi'=>$net
		);
		$i++;
		$credit = $credit + $net;	
		}}
	
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