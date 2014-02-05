<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Depositin extends CI_Controller {

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
		$key = $this->input->post('key');
		if($key==1){
			$this->db->where('statu', '02');
		}
		$this->db->limit(1);
		$this->db->where('depnr', $id);
		$query = $this->db->get('vbdk');
		
		if($query->num_rows()>0){
			$result = $query->first_row('array');
			$result['id'] = $result['depnr'];
			
			$result['adr01'] .= ' '.$result['distx'].' '.$result['pstlz'].
			                         PHP_EOL.'Tel: '.$result['telf1'].' '.'Fax: '.
			                         $result['telfx'].
									 PHP_EOL.'Email: '.$result['email'];

			// unset calculated value
			unset($result['beamt']);
			unset($result['netwr']);
			
			$result['whtpr']=number_format($result['whtpr']);
			
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
		$tbName = 'vbdk';
		
		// Start for report
		function createQuery($_this){
			
			$query = $_this->input->get('query');
			if(!empty($query)){
				$_this->db->where("(depnr LIKE '%$query%'
				OR kunnr LIKE '%$query%'
				OR name1 LIKE '%$query%'
				OR vbeln LIKE '%$query%'
				OR salnr LIKE '%$query%')", NULL, FALSE);
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
		if(!empty($id)){
			$this->db->limit(1);
			$this->db->where('depnr', $id);
			$query = $this->db->get('vbdk');
			
			// ##### CHECK PERMISSIONS
			$row = $query->first_row('array');
			// status has change
			$status_changed = $row['statu']!=$this->input->post('statu');
			if($status_changed&&$row['statu']!=02&&$row['statu']!=02&&$row['statu']!=03){
				if(XUMS::CAN_DISPLAY('DR') && XUMS::CAN_APPROVE('DR')){
					$limit = XUMS::LIMIT('DR');
					if($limit<$row['netwr']){
						$emsg = 'You do not have permission to change deposit status over than '.number_format($limit);
						echo json_encode(array(
							'success'=>false,
							'errors'=>array( 'statu' => $emsg ),
							'message'=>$emsg
						));
						return;
					}
				}else{
					$emsg = 'You do not have permission to change deposit status.';
					echo json_encode(array(
						'success'=>false,
						'errors'=>array( 'statu' => $emsg ),
						'message'=>$emsg
					));
					return;
				}
			}else{
				if($row['statu']=='02'||$row['statu']=='03'){
					$emsg = 'The deposit that already approved or rejected cannot be update.';
					echo json_encode(array(
						'success'=>false,
						'message'=>$emsg
					));
					return;
				}
			}
			// ##### END CHECK PERMISSIONS
			if($this->input->post('statu')=='03' && $this->input->post('reanr')==''){
				$emsg = 'Please enter reason for reject status';
					echo json_encode(array(
						'success'=>false,
						'message'=>$emsg
					));
					return;
			}
			}else{
				if($this->input->post('loekz')=='2'){
        	        $emsg = 'The quotation already created deposit doc.';
					echo json_encode(array(
						'success'=>false,
						'message'=>$emsg
					));
					return;
                }
		}

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

        if($this->input->post('whtnr')=='6' && $this->input->post('whtxt')==''){
        	$emsg = 'The WHT Type 6 is required to fill in WHT Text';
					echo json_encode(array(
						'success'=>false,
						'message'=>$emsg
					));
					return;
        }
		
		$formData = array(
			'vbeln' => $this->input->post('vbeln'),
			'bldat' => $this->input->post('bldat'),
			'kunnr' => $this->input->post('kunnr'),
			'netwr' => floatval($this->input->post('netwr')),
			'beamt' => floatval($this->input->post('beamt')),
			'dismt' => floatval($this->input->post('dismt')),
			'ctype' => $this->input->post('ctype'),
			'exchg' => floatval($this->input->post('exchg')),
			'reanr' => $this->input->post('reanr'),
			'statu' => $this->input->post('statu'),
			'txz01' => $this->input->post('txz01'),
			'duedt' => $this->input->post('duedt'),
			'taxnr' => $this->input->post('taxnr'),
			'taxpr' => floatval($this->input->post('taxpr')),
			//'whtpr' => $this->input->post('whtpr'),
			'vat01' => floatval($this->input->post('vat01')),
			'wht01' => floatval($this->input->post('wht01')),
			//'whtyp' => $this->input->post('whtyp'),
			'whtnr' => $this->input->post('whtnr'),
			'whtxt' => $this->input->post('whtxt'),
			'terms' => intval($this->input->post('terms'))
		);
		
		// start transaction
		$this->db->trans_start(); 
		
		$current_username = XUMS::USERNAME(); 
		
		if (!empty($query) && $query->num_rows() > 0){
			$this->db->where('depnr', $id);
			//$this->db->set('updat', 'NOW()', false);
			db_helper_set_now($this, 'updat');
			$this->db->set('upnam', $current_username);
			$this->db->update('vbdk', $formData);
		}else{
			$id = $this->code_model->generate('DR', 
			$this->input->post('bldat'));
			//echo ($id);
			$this->db->set('depnr', $id);
			//$this->db->set('erdat', 'NOW()', false);
			db_helper_set_now($this, 'erdat');
		    $this->db->set('ernam', $current_username);
			$this->db->insert('vbdk', $formData);
			
			$inserted_id = $id;
			
			$this->db->where('vbeln', $this->input->post('vbeln'));
			$this->db->set('loekz', '2');
			$this->db->update('vbak');
		}

		// ลบ receipt item ภายใต้ id ทั้งหมด
		$this->db->where('depnr', $id);
		$this->db->delete('vbdp');

		// เตรียมข้อมูล receipt item
		$vbdp = $this->input->post('vbdp');
		$dp_item_array = json_decode($vbdp);
		//echo $this->db->last_query();
		
		if(!empty($vbdp) && !empty($dp_item_array)){
			// loop เพื่อ insert receipt item ที่ส่งมาใหม่
			$item_index = 0;
		foreach($dp_item_array AS $p){
			$this->db->insert('vbdp', array(
				'depnr'=>$id,
				'vbelp'=>intval(++$item_index),
				'sgtxt'=>$p->sgtxt,
				'pramt'=>floatval($p->pramt),
				'perct'=>$p->perct,
				'duedt'=>$p->duedt,
				'chk01'=>$p->chk01,
				'chk02'=>$p->chk02,
				'disit'=>$p->disit,
				'ctyp1'=>$p->ctyp1
			));
	    	}
		}

// Save GL Posting	
        //$ids = $id;	
    if($this->input->post('statu') == '02'){
		
		$ids = $this->input->post('id');
		$query = null;
		if(!empty($ids)){
			$this->db->limit(1);
			$this->db->where('invnr', $ids);
			$query = $this->db->get('bkpf');
			if($query->num_rows()>0){
				$result = $query->first_row('array');
			    $accno = $result['belnr'];
			}
		}
		$date = date('Ymd');
		$formData = array(
		    'gjahr' => substr($date,0,4),
		    'bldat' => $this->input->post('bldat'),
			'invnr' => $id,
			'refnr' => $id,
			'kunnr' => $this->input->post('kunnr'),
			'txz01' => 'Deposit Receipt No '.$id,
			'ttype' => '04',
			'auart' => 'AR',
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
			$accno = $this->code_model->generate('AR', 
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
		$this->db->delete('bcus');

		// เตรียมข้อมูล pay item
		$bcus = $this->input->post('bcus');//$this->input->post('vbelp');
		$gl_item_array = json_decode($bcus);
		if(!empty($bcus) && !empty($gl_item_array)){

			$item_index = 0;
			// loop เพื่อ insert pay_item ที่ส่งมาใหม่
			foreach($gl_item_array AS $p){
				if(!empty($p->saknr)){
				$this->db->insert('bcus', array(
					'belnr'=>$accno,
					'belpr'=>++$item_index,
					'gjahr' => substr($date,0,4),
					'saknr'=>$p->saknr,
					'debit'=>$p->debit,
					'credi'=>$p->credi,
					'bldat'=>$this->input->post('bldat'),
					'txz01'=>'Deposit Receipt No '.$id
				));
			  }
			}
		}
	}// check status approved
	
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
					$q_row = $this->db->get_where('vbdk', array('depnr'=>$inserted_id));
					$row = $q_row->first_row();
					$this->email_service->sendmail_create(
						'DR', 'Deposit Receipt',
						$inserted_id, $total_amount,
						$row->ernam
					);
				}else if(!empty($post_id)){
					if($status_changed){
						$q_row = $this->db->get_where('vbdk', array('depnr'=>$post_id));
						$row = $q_row->first_row();
						$this->email_service->sendmail_change_status(
							'DR', 'Deposit Receipt',
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
	// Deposit ITEM
	///////////////////////////////////////////////
	function loads_dp_item(){
		$qtnr = $this->input->get('qtnr');
		
		if(!empty($qtnr)){
			//$this->db->set_dbprefix('v_');
			$tbName = 'payp';
		    $this->db->where('vbeln', $qtnr);
			$this->db->where('payty', '1');

		    $query = $this->db->get('payp');
			
		}else{
            $this->db->set_dbprefix('v_');
			$tbName = 'vbdp';
	        $dp_id = $this->input->get('depnr');
		    $this->db->where('depnr', $dp_id);
        //$totalCount = $this->db->count_all_results('vbbp');
		
		//createQuery($this);
	       $query = $this->db->get('vbdp');
      //  echo $this->db->last_query();
		}
		$totalCount = $this->db->count_all_results($tbName);
		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$totalCount
		));
	}
	
// GL Posting
	function loads_gl_item(){
		$iv_id = $this->input->get('netpr');
        $result = array();
		if($iv_id!=0){
		   $netpr = $this->input->get('netpr');  //Net amt
		   $kunnr = $this->input->get('kunnr');  //Customer Code
		   $vvat = $this->input->get('vvat');    //VAT amt
		   //$rate = $this->input->get('rate');    //Currency Rate
		   //$ptype = $this->input->get('ptype');  //Pay Type
		   //$dtype = $this->input->get('dtype');  //Doc Type
		   
		   $net = $netpr + $vvat;
		   
           $i=0;$n=0;$vamt=0;$debit=0;$credit=0;
		   
		// record แรก
			//$query = $this->db->get_where('kna1', array(
			//	'kunnr'=>$kunnr));
			//if($query->num_rows()>0){
			//	$q_data = $query->first_row('array');
			//	$qgl = $this->db->get_where('glno', array(
			//	'saknr'=>$q_data['saknr']));
				$glno = '1130-05';  
		        $qgl = $this->db->get_where('glno', array(
				'saknr'=>$glno));
				
				if($qgl->num_rows()>0){
				$q_glno = $qgl->first_row('array');
				$result[$i] = array(
				    'belpr'=>$i + 1,
					'saknr'=>$glno,
					'sgtxt'=>$q_glno['sgtxt'],
					'debit'=>$net,
					'credi'=>0
				);
				$i++;
				$debit=$net;
			}
			//}

// record ที่สอง
        if($netpr>0){
        $glno = '2133-00';  
		$qdoc = $this->db->get_where('glno', array(
				'saknr'=>$glno));
				
		if($qdoc->num_rows()>0){
		$q_doc = $qdoc->first_row('array');
		$result[$i] = array(
		    'belpr'=>$i + 1,
			'saknr'=>$glno,
			'sgtxt'=>$q_doc['sgtxt'],
			'debit'=>0,
			'credi'=>$netpr
		);
		$i++;
		$credit=$netpr;
		}
		}
		
// record ที่สาม
		if($vvat>0){ 
		//	$net_tax = floatval($net) * 0.07;}
		$glvat = '2136-00';
		$qgl = $this->db->get_where('glno', array(
				'saknr'=>$glvat));
		$q_glno = $qgl->first_row('array');
		$result[$i] = array(
		    'belpr'=>$i + 1,
			'saknr'=>$glvat,
			'sgtxt'=>$q_glno['sgtxt'],
			'debit'=>0,
			'credi'=>$vvat
		);
		$i++;
		$credit = $credit + $vvat;	
		}
/*        if($vwht>'1'){ 
		//	$net_tax = floatval($net) * 0.07;}
		$glwht = '215040';
		$qgl = $this->db->get_where('glno', array(
				'saknr'=>$glwht));
		$q_glno = $qgl->first_row('array');
		$result[$i] = array(
		    'belpr'=>$i + 1,
			'saknr'=>$glwht,
			'sgtxt'=>$q_glno['sgtxt'],
			'debit'=>$vwht,
			'credi'=>0
		);
		$i++;
        $debit = $debit + $vwht;
		}
		*/
		
		if(!empty($debit)){
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