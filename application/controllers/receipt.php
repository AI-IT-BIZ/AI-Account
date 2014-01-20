<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Receipt extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('code_model','',TRUE);
		$this->load->model('email_service','',TRUE);
	}

	function index(){
		//$this->load->view('project');
		//$this->phxview->RenderView('vbak');
		//$this->phxview->RenderLayout('default');
	}

	function load(){
		$this->db->set_dbprefix('v_');
		$id = $this->input->post('id');
		$this->db->limit(1);
		$this->db->where('recnr', $id);
		$query = $this->db->get('vbbk');
		
		if($query->num_rows()>0){
			$result = $query->first_row('array');
			$result['id'] = $result['recnr'];
			
			$result['adr01'] .= ' '.$result['distx'].' '.$result['pstlz'].
			                         PHP_EOL.'Tel: '.$result['telf1'].' '.'Fax: '.
			                         $result['telfx'].
									 PHP_EOL.'Email: '.$result['email'];

			// unset calculated value
			unset($result['beamt']);
			unset($result['netwr']);
		
			echo json_encode(array(
				'success'=>true,
				'data'=>$result
			));
		}else
			echo json_encode(array(
				'success'=>false
			));
	}

	function loads(){
		$this->db->set_dbprefix('v_');
		$tbName = 'vbbk';
		
		// Start for report
		function createQuery($_this){
			$query = $_this->input->get('query');
			if(!empty($query)){
				$_this->db->where("(recnr LIKE '%$query%'
				OR kunnr LIKE '%$query%'
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

    function loads_report(){
		$this->db->set_dbprefix('v_');
		$tbName = 'vbbp';
		
		// Start for report
		function createQuery($_this){
			$query = $_this->input->get('query');
			if(!empty($query)){
				$_this->db->where("(recnr LIKE '%$query%'
				OR kunnr LIKE '%$query%'
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
			
			$kunnr1 = $_this->input->get('kunnr');
			$kunnr2 = $_this->input->get('kunnr2');
			if(!empty($kunnr1) && empty($kunnr2)){
			  $_this->db->where('kunnr', $kunnr1);
			}
			elseif(!empty($kunnr1) && !empty($kunnr2)){
			  $_this->db->where('kunnr >=', $kunnr1);
			  $_this->db->where('kunnr <=', $kunnr2);
			}
			
			$recnr1 = $_this->input->get('recnr');
			$recnr2 = $_this->input->get('recnr2');
			if(!empty($recnr1) && empty($recnr2)){
			  $_this->db->where('recnr', $recnr1);
			}
			elseif(!empty($recnr1) && !empty($recnr2)){
			  $_this->db->where('recnr >=', $recnr1);
			  $_this->db->where('recnr <=', $recnr2);
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
		
		$res = $query->result_array();
		for($i=0;$i<count($res);$i++){
			$r = $res[$i];
			// search item
			$q_pm = $this->db->get_where('paym', array(
				'recnr'=>$r['recnr']
			));
			
			//$result_data = $q_pm->first_row('array');
			//echo count($result_data);
			if($q_pm->num_rows()>0){
				$pay = $q_pm->result_array();
				$paytx='';
				for($j=0;$j<count($pay);$j++){
		            $p = $pay[$j];
					
			        $paytx = $paytx.$p['paytx'];
					$res[$i]['paytx'] = $paytx;
			   
			    }
			}
		}

		//echo $this->db->last_query();
		echo json_encode(array(
			'success'=>true,
			'rows'=>$res,
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
			$this->db->where('recnr', $id);
			$query = $this->db->get('vbbk');
			
			// ##### CHECK PERMISSIONS
			$row = $query->first_row('array');
			// status has change
			$status_changed = $row['statu']!=$this->input->post('statu');
			if($status_changed&&$row['statu']!=02&&$row['statu']!=02&&$row['statu']!=03){
				if(XUMS::CAN_DISPLAY('RD') && XUMS::CAN_APPROVE('RD')){
					$limit = XUMS::LIMIT('RD');
					if($limit<$row['netwr']){
						$emsg = 'You do not have permission to change receipt status over than '.number_format($limit);
						echo json_encode(array(
							'success'=>false,
							'errors'=>array( 'statu' => $emsg ),
							'message'=>$emsg
						));
						return;
					}
				}else{
					$emsg = 'You do not have permission to change receipt status.';
					echo json_encode(array(
						'success'=>false,
						'errors'=>array( 'statu' => $emsg ),
						'message'=>$emsg
					));
					return;
				}
			}else{
				if($row['statu']=='02'||$row['statu']=='03'){
					$emsg = 'The receipt that already approved or rejected cannot be update.';
					echo json_encode(array(
						'success'=>false,
						'message'=>$emsg
					));
					return;
				}
			}
			// ##### END CHECK PERMISSIONS
		}

        $vbbp = $this->input->post('vbbp');
		$rc_item_array = json_decode($vbbp);
		$perv='';$kerv='';
		if(!empty($vbbp) && !empty($rc_item_array)){
		foreach($rc_item_array AS $p){
			if($p->loekz=='2'){
				$emsg = 'The invoice no '.$p->invnr.' already created receipt doc.';
					echo json_encode(array(
						'success'=>false,
						'message'=>$emsg
					));
					return;
			}
			
			if(substr($p->invnr,0,1)!=$perv && $perv!=''){
				$emsg = 'Cannot create receipt doc from differnt invoice type';
					echo json_encode(array(
						'success'=>false,
						'message'=>$emsg
					));
					return;
			}
			$perv = substr($p->invnr,0,1);
			
			if($p->kunnr!=$kerv && $kerv!=''){
				$emsg = 'Cannot create receipt doc from differnt customer';
					echo json_encode(array(
						'success'=>false,
						'message'=>$emsg
					));
					return;
			}
			$kerv = $p->kunnr;
		  }
		}
		
		$formData = array(
			//'recnr' => $this->input->post('recnr'),
			'bldat' => $this->input->post('bldat'),
			'kunnr' => $this->input->post('kunnr'),
			'netwr' => floatval($this->input->post('netwr')),
			'beamt' => floatval($this->input->post('beamt')),
			'dismt' => floatval($this->input->post('dismt')),
			//'ctype' => $this->input->post('ctype'),
			'exchg' => floatval($this->input->post('exchg')),
			'reanr' => $this->input->post('reanr'),
			'statu' => $this->input->post('statu'),
			'txz01' => $this->input->post('txz01'),
			'duedt' => $this->input->post('duedt'),
			'dispc' => $this->input->post('dispc')//,
			//'whtpr' => $this->input->post('whtpr')
			);
		
		// start transaction
		$this->db->trans_start();
		
		$current_username = XUMS::USERNAME();  
		
		if (!empty($query) && $query->num_rows() > 0){
			$this->db->where('recnr', $id);
			//$this->db->set('updat', 'NOW()', false);
			db_helper_set_now($this, 'updat');
			$this->db->set('upnam', $current_username);
			$this->db->update('vbbk', $formData);
		}else{
			$id = $this->code_model->generate('RD', 
			$this->input->post('bldat'));
			//echo ($id);
			$this->db->set('recnr', $id);
			//$this->db->set('erdat', 'NOW()', false);
			db_helper_set_now($this, 'erdat');
		    $this->db->set('ernam', $current_username);
			$this->db->insert('vbbk', $formData);
			
			$inserted_id = $id;
		}

		// ลบ receipt item ภายใต้ id ทั้งหมด
		$this->db->where('recnr', $id);
		$this->db->delete('vbbp');

		// เตรียมข้อมูล receipt item
		//$vbbp = $this->input->post('vbbp');
		//$rc_item_array = json_decode($vbbp);
		//echo $this->db->last_query();
		
		if(!empty($vbbp) && !empty($rc_item_array)){
			// loop เพื่อ insert receipt item ที่ส่งมาใหม่
			$item_index = 0;$depno=0;$netwr=0;$itamt=0;
		foreach($rc_item_array AS $p){
			$this->db->insert('vbbp', array(
				'recnr'=>$id,
				'vbelp'=>++$item_index,
				'invnr'=>$p->invnr,
				'invdt'=>$p->invdt,
				'texts'=>$p->texts,
				'itamt'=>floatval($p->itamt),
				//'reman'=>$p->reman,
				//'payrc'=>$p->payrc,
				'refnr'=>$p->refnr,
				'ctype'=>$p->ctype,
				'wht01'=>floatval($p->wht01),
				'vat01'=>floatval($p->vat01),
				'dtype'=>$p->dtype,
				'jobtx'=>$p->jobtx
			));
			
			$this->db->where('invnr', $p->invnr);
			$this->db->set('loekz', '2');
			$netwr=floatval($this->input->post('netwr'));
			if($p->itamt > $netwr){
				$itamt=$p->itamt - $netwr;
				$this->db->set('reman', $itamt);
			}
			$this->db->update('vbrk');
			
			if($this->input->post('statu') == '02'){
			if($p->itamt <= $netwr){
			$kunnr = $this->input->post('kunnr');
		    $this->db->where('kunnr', $kunnr);
		    $q_limit = $this->db->get('kna1');
			$reman=0;$upamt=0;
			if($q_limit->num_rows()>0){
			  $r_limit = $q_limit->first_row('array');
			  $reman = $r_limit['reman'] - $p->itamt;
			  $upamt = $p->itamt;
			  
			  $this->db->where('kunnr', $kunnr);
			  $this->db->set('upamt', $upamt);
			  $this->db->set('reman', $reman);
			  $this->db->update('kna1');
			  }
			} 
			}
	      }
		}
		
		// ลบ pay_item ภายใต้ id ทั้งหมด
		$this->db->where('recnr', $id);
		$this->db->delete('paym');

		// เตรียมข้อมูล pay item
		$paym = $this->input->post('paym');
		$pm_item_array = json_decode($paym);
		$cheque='';$noncheque='';$amt1=0;$amt2=0;$amt3=0;
		$deposit='';
		if(!empty($paym) && !empty($pm_item_array)){

			$item_index = 0;
			// loop เพื่อ insert pay_item ที่ส่งมาใหม่
			foreach($pm_item_array AS $p){
				$amt3 += $p->payam;
				if($p->ptype=='05'){
					$cheque = '1';
					$amt1 += $p->payam;
				}else{if(!empty($p->ptype)){
					$noncheque = '1';
					$amt2 += $p->payam;
				}}
				$this->db->insert('paym', array(
					'recnr'=>$id,
					'paypr'=>++$item_index,
					'ptype'=>$p->ptype,
					'bcode'=>$p->bcode,
					'sgtxt'=>$p->sgtxt,
					'chqid'=>$p->chqid,
					'chqdt'=>$p->chqdt,
					'pramt'=>floatval($p->pramt),
					'reman'=>floatval($p->reman),
					'payam'=>floatval($p->payam),
					'saknr'=>$p->saknr
				));
			}
		}
		
//*** Save GL Posting	
    if($this->input->post('statu') == '02'){
        //$ids = $id;	
        $bcus = $this->input->post('bcus');
		$gl_item_array = json_decode($bcus);
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
		
		$ids = $this->input->post('id');
		$query = null;
		if(!empty($ids)){
			$this->db->limit(1);
			$this->db->where('invnr', $ids);
			$query = $this->db->get('bkpf');
		}
		$date = date('Ymd');

// Payment
		$formData = array(
		    'gjahr' => substr($date,0,4),
		    'bldat' => $this->input->post('bldat'),
			'invnr' => $id,
			'refnr' => $id,
			'kunnr' => $this->input->post('kunnr'),
			'txz01' => 'Receipt No '.$id,
			'ttype' => '03',
			'auart' => 'RV',
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
			$accno = $this->code_model->generate('RV', 
			$this->input->post('bldat'));
			$this->db->set('belnr', $accno);
			//$this->db->set('erdat', 'NOW()', false);
			db_helper_set_now($this, 'erdat');
		    $this->db->set('ernam', $current_username);
			$this->db->insert('bkpf', $formData);
		}
		
		// ลบ gl_item ภายใต้ id ทั้งหมด
		$this->db->where('belnr', $accno);
		$this->db->delete('bcus');

		// เตรียมข้อมูล pay item
		$bcus = $this->input->post('bcus');
		$gl_item_array = json_decode($bcus);
		if(!empty($bcus) && !empty($gl_item_array)){

			$item_index = 0;
			// loop เพื่อ insert pay_item ที่ส่งมาใหม่
			foreach($gl_item_array AS $p){
				if($p->statu=='1' && !empty($p->saknr)){
				$this->db->insert('bcus', array(
					'belnr'=>$accno,
					'belpr'=>++$item_index,
					'gjahr'=>substr($date,0,4),
					'bldat' => $this->input->post('bldat'),
					'kunnr' => $this->input->post('kunnr'),
					'saknr'=>$p->saknr,
					'debit'=>$p->debit,
					'credi'=>$p->credi,
					'docty'=>'01',
					'txz01' => 'Receipt No '.$id
				));
				}elseif($p->statu=='2' && !empty($p->saknr)){
					$deposit = '1';
				}
			}
		  }

//Deposit Doc
	if($deposit=='1'){
		if(!empty($id)){
			$this->db->set_dbprefix('v_');
			$this->db->limit(1);
			$this->db->where('invnr', $id);
			$this->db->where('docty', '02');
			$query = $this->db->get('bcus');
		}
		
		$formData = array(
		    'gjahr' => substr($date,0,4),
		    'bldat' => $this->input->post('bldat'),
			'invnr' => $id,
			'refnr' => $id,
			'kunnr' => $this->input->post('kunnr'),
			'txz01' => 'Receipt No '.$id,
			'ttype' => '03',
			'auart' => 'RV',
			'netwr' => floatval($this->input->post('netwr'))
		);
		
		// start transaction
		$this->db->trans_start();  
		$this->db->set_dbprefix('tbl_');
		if (!empty($query) && $query->num_rows() > 0){
			$q_gl = $query->first_row('array');
			$accno = $q_gl['belnr'];
			$this->db->where('belnr', $accno);
			//$this->db->set('updat', 'NOW()', false);
			db_helper_set_now($this, 'updat');
			$this->db->set('upnam', $current_username);
			$this->db->update('bkpf', $formData);
		}else{
			$accno = $this->code_model->generate('RV', 
			$this->input->post('bldat'));
			$this->db->set('belnr', $accno);
			//$this->db->set('erdat', 'NOW()', false);
			db_helper_set_now($this, 'updat');
		    $this->db->set('ernam', $current_username);
			$this->db->insert('bkpf', $formData);
		}
		
		// ลบ gl_item ภายใต้ id ทั้งหมด
		$this->db->where('belnr', $accno);
		$this->db->delete('bcus');

		// เตรียมข้อมูล pay item
		$bcus = $this->input->post('bcus');
		$gl_item_array = json_decode($bcus);
		if(!empty($bcus) && !empty($gl_item_array)){

			$item_index = 0;
			// loop เพื่อ insert pay_item ที่ส่งมาใหม่
			foreach($gl_item_array AS $p){
				if($p->statu=='2' && !empty($p->saknr)){
				$this->db->insert('bcus', array(
					'belnr'=>$accno,
					'belpr'=>++$item_index,
					'gjahr'=>substr($date,0,4),
					'bldat' => $this->input->post('bldat'),
					'kunnr' => $this->input->post('kunnr'),
					'saknr'=>$p->saknr,
					'debit'=>$p->debit,
					'credi'=>$p->credi,
					'docty'=>'02',
					'txz01' => 'Receipt No '.$id
				));
				} 
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
					$q_row = $this->db->get_where('vbbk', array('recnr'=>$inserted_id));
					$row = $q_row->first_row();
					$this->email_service->sendmail_create(
						'RD', 'Receipt',
						$inserted_id, $total_amount,
						$row->ernam
					);
				}else if(!empty($post_id)){
					if($status_changed){
						$q_row = $this->db->get_where('vbbk', array('recnr'=>$post_id));
						$row = $q_row->first_row();
						$this->email_service->sendmail_change_status(
							'RD', 'Receipt',
							$post_id, $total_amount, $row->statu,
							$row->ernam
						);
					}
				}
			}catch(exception $e){}
		}
	}
	
	public function loads_pcombo(){
		//$tbName = 'ptyp';
		//$tbPK = 'ptype';

		$sql="SELECT *
			FROM tbl_ptyp
			WHERE ptype <> '01'";
		$query = $this->db->query($sql);

		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$query->num_rows()
		));
	}
    
	function remove(){
		$id = $this->input->post('id');
		$this->db->where('recnr', $id);
		$query = $this->db->delete('vbbk');
		echo json_encode(array(
			'success'=>true,
			'data'=>$id
		));
	}
	
	///////////////////////////////////////////////
	// Quotation ITEM
	///////////////////////////////////////////////

	function loads_rc_item(){
        $this->db->set_dbprefix('v_');
		
	    $rc_id = $this->input->get('recnr');
		$this->db->where('recnr', $rc_id);
        //$totalCount = $this->db->count_all_results('vbbp');
		
		//createQuery($this);
	    $query = $this->db->get('vbbp');
      //  echo $this->db->last_query();
		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$query->num_rows()
		));
	}
	
	function loads_pm_item(){
        $this->db->set_dbprefix('v_');
		$pm_id = $this->input->get('recnr');
		//echo $pm_id;
		$this->db->where('recnr', $pm_id);

		$query = $this->db->get('paym');
		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$query->num_rows()
		));
	}
// GL Posting
	function loads_gl_item(){
		$iv_id = $this->input->get('netpr');
        $result = array();
		if($iv_id!=0){
		   $net = $this->input->get('netpr');  //Net amt
		   $vwht = $this->input->get('vwht');
		   $vvat = $this->input->get('vvat');
		   $dtype = $this->input->get('dtype');
		   $kunnr = $this->input->get('kunnr');  //Customer Code
		   $itms = $this->input->get('items');  //items
		   
		   $items = explode(',',$itms);
		   
           $i=0;$n=0;$vamt=0;$debit=0;$credit=0;
		   $ptype='';
		   $result = array();

		   // เตรียมข้อมูล pay item
		//$paym = $this->input->get('paym');
		//$pm_item_array = json_decode($paym);
//Check payment grid	
		if(!empty($items)){
			$item_index = 0;
			
            for($j=0;$j<count($items);$j++){
 // record แรก
            $item = explode('|',$items[$j]);
			if(!empty($item)){
			$glno = $item[0];
			$payam  = $item[1];
			}
			if(strlen($glno) == 2){
		    $ptype = $glno;
            $query = $this->db->get_where('ptyp', array(
			'ptype'=>$ptype));
			$q_data = $query->first_row('array');
			$glno = $q_data['saknr'];
			}
			
			if(!empty($glno)){
				
				$qgl = $this->db->get_where('glno', array(
				'saknr'=>$glno));
				if($qgl->num_rows()>0){
				$q_glno = $qgl->first_row('array');

				$result[$i] = array(
				    'belpr'=>$i + 1,
					'saknr'=>$glno,
					'sgtxt'=>$q_glno['sgtxt'],
					'debit'=>$payam,
					'credi'=>0,
					'statu'=>'1'
				);
				$i++;
				$debit+=$payam;
				}
			}
          }//loop เพื่อ insert pay_item ที่ส่งมาใหม่
		}//Check payment grid
		
// record ที่สอง
		if($vwht>0){ 
		//	$net_tax = floatval($net) * 0.07;}
		$glvat = '2132-02';
		$qgl = $this->db->get_where('glno', 
		array('saknr'=>$glvat));
		if($qgl->num_rows()>0){
		$q_glno = $qgl->first_row('array');
		$result[$i] = array(
		    'belpr'=>$i + 1,
			'saknr'=>$glvat,
			'sgtxt'=>$q_glno['sgtxt'],
			'debit'=>$vwht,
			'credi'=>0,
			'statu'=>'1'
		);
		$i++;
		$debit = $debit + $vwht;	
		}}

       $bamt=0;
       if($dtype == 'D'){
// record ที่สาม
		if($net>0){
			    $bamt = $net - $vvat;
			    $bamt = $bamt + $vwht;
			    $gl_sale = '4100-01';
				$qgl = $this->db->get_where('glno', array(
				'saknr'=>$gl_sale));
				if($qgl->num_rows()>0){
				$q_glno = $qgl->first_row('array');
				$result[$i] = array(
				    'belpr'=>$i + 1,
					'saknr'=>$gl_sale,
					'sgtxt'=>$q_glno['sgtxt'],
					'debit'=>0,
					'credi'=>$bamt,
					'statu'=>'1'
				);
				$i++;
				$credit+=$bamt;
			}
		}
		
// record ที่สี่
		if($vvat>0){
        	$gl_vat = '2135-00';
			$qgl = $this->db->get_where('glno', array(
				'saknr'=>$gl_vat));
				if($qgl->num_rows()>0){
				$q_glno = $qgl->first_row('array');
		$result[$i] = array(
		    'belpr'=>$i + 1,
			'saknr'=>$gl_vat,
			'sgtxt'=>$q_glno['sgtxt'],
			'debit'=>0,
			'credi'=>$vvat,
			'statu'=>'1'
		);
		$i++;
		$credit+=$vvat;
		}}
				
		if(!empty($debit) || !empty($credit)){
		$result[$i] = array(
		    'belpr'=>$i + 1,
			'saknr'=>'',
			'sgtxt'=>'Total',
			'debit'=>$debit,
			'credi'=>$credit
		);
		$i++;
		}

//record ที่ หนึ่ง -> New Deposit posting
		$debit=0;$credit=0;$j=0;
		$gl_vat = '2133-00';
			$qgl = $this->db->get_where('glno', array(
				'saknr'=>$gl_vat));
				if($qgl->num_rows()>0){
				$q_glno = $qgl->first_row('array');
		$result[$i] = array(
		    'belpr'=>$j + 1,
			'saknr'=>$gl_vat,
			'sgtxt'=>$q_glno['sgtxt'],
			'debit'=>$bamt,
			'credi'=>0,
			'statu'=>'2'
		);
		$i++;
		$debit+=$bamt;
		}
//record ที่ สอง-> New Deposit posting
        if($vvat>0){
        	$gl_vat = '2136-00';
			$qgl = $this->db->get_where('glno', array(
				'saknr'=>$gl_vat));
				if($qgl->num_rows()>0){
				$q_glno = $qgl->first_row('array');
		$result[$i] = array(
		    'belpr'=>$j + 1,
			'saknr'=>$gl_vat,
			'sgtxt'=>$q_glno['sgtxt'],
			'debit'=>$vvat,
			'credi'=>0,
			'statu'=>'2'
		);
		$i++;
		$debit+=$vvat;
		}}
//record ที่ สาม -> New Deposit posting
        $gl_vat = '1130-05';
		    $grand = $net + $vwht;
			$qgl = $this->db->get_where('glno', array(
				'saknr'=>$gl_vat));
				if($qgl->num_rows()>0){
				$q_glno = $qgl->first_row('array');
		$result[$i] = array(
		    'belpr'=>$j + 1,
			'saknr'=>$gl_vat,
			'sgtxt'=>$q_glno['sgtxt'],
			'debit'=>0,
			'credi'=>$grand,
			'statu'=>'2'
		);
		$i++;
		$credit+=$grand;
		}
		
		if(!empty($debit) || !empty($credit)){
		$result[$i] = array(
		    'belpr'=>$j + 1,
			'saknr'=>'',
			'sgtxt'=>'Total',
			'debit'=>$debit,
			'credi'=>$credit
		);
		}
		
      }else{
// record ที่สาม
      	if($net>0){
      		$net+=$vwht;
			$query = $this->db->get_where('kna1', array(
				'kunnr'=>$kunnr));
			if($query->num_rows()>0){
				$q_data = $query->first_row('array');
				$qgl = $this->db->get_where('glno', array(
				'saknr'=>$q_data['saknr']));
				if($qgl->num_rows()>0){
				$q_glno = $qgl->first_row('array');
				$result[$i] = array(
				    'belpr'=>$i + 1,
					'saknr'=>$q_data['saknr'],
					'sgtxt'=>$q_glno['sgtxt'],
					'debit'=>0,
					'credi'=>$net,
					'statu'=>'1'
				);
				$i++;
				$credit+=$net;
			}}
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