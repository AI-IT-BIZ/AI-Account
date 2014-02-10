<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invoice extends CI_Controller {

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
		$this->db->where('invnr', $id);
		$query = $this->db->get('vbrk');
		
		if($query->num_rows()>0){
			$result = $query->first_row('array');
			$result['id'] = $result['invnr'];
			
			$result['adr01'] .= ' '.$result['distx'].' '.$result['pstlz'].
			                    PHP_EOL.'Tel: '.$result['telf1'].' '.'Fax: '.
			                    $result['telfx'].
							    PHP_EOL.'Email: '.$result['email'];
			$result['adr02'] .= ' '.$result['dis02'].' '.$result['pst02'].
			                         PHP_EOL.'Tel: '.$result['tel02'].' '.'Fax: '.
			                         $result['telf2'].
									 PHP_EOL.'Email: '.$result['emai2'];

			// unset calculated value
			unset($result['beamt']);
			unset($result['netwr']);
			
			$q_qt = $this->db->get_where('psal', array(
				'salnr'=>$result['salnr']
			));
			
			$r_qt = $q_qt->first_row('array');
			$result['emnam'] = $r_qt['emnam'];
			
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
	
	function load2(){
		$this->db->set_dbprefix('v_');
		$tbName = 'vbrk';
		
		$totalCount = $this->db->count_all_results($tbName);

		//createQuery($this);
		//$limit = $this->input->get('limit');
		//$start = $this->input->get('start');
		//if(isset($limit) && isset($start)) $this->db->limit($limit, $start);
		
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

	function loads(){
		$this->db->set_dbprefix('v_');
		$tbName = 'vbrk';
		
		// Start for report
		function createQuery($_this){
			$query = $_this->input->get('query');
			if(!empty($query)){
				$_this->db->where("(invnr LIKE '%$query%'
				OR kunnr LIKE '%$query%'
				OR name1 LIKE '%$query%'
				OR ordnr LIKE '%$query%')", NULL, FALSE);
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
			
	        $ordnr1 = $_this->input->get('ordnr');
			$ordnr2 = $_this->input->get('ordnr2');
			if(!empty($ordnr1) && empty($ordnr2)){
			  $_this->db->where('ordnr', $ordnr1);
			}
			elseif(!empty($ordnr1) && !empty($ordnr2)){
			  $_this->db->where('ordnr >=', $ordnr1);
			  $_this->db->where('ordnr <=', $ordnr2);
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

		/*$res = $query->result_array();
		foreach($res as $r){
			// search item
			$q_item = $this->db->get_where('vbrp', array(
				'invnr'=>$r['invnr']
			));
			$r['items'] = $q_item->result_array();
		}*/

		//echo $this->db->last_query();
		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),//$res,
			'totalCount'=>$totalCount
		));
	}

    function loads_report(){
		$this->db->set_dbprefix('v_');
		$tbName = 'vbrp';
		
		// Start for report
		function createQuery($_this){
			$query = $_this->input->get('query');
			if(!empty($query)){
				$_this->db->where("(invnr LIKE '%$query%'
				OR kunnr LIKE '%$query%'
				OR name1 LIKE '%$query%'
				OR ordnr LIKE '%$query%')", NULL, FALSE);
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
			
	        $ordnr1 = $_this->input->get('ordnr');
			$ordnr2 = $_this->input->get('ordnr2');
			if(!empty($ordnr1) && empty($ordnr2)){
			  $_this->db->where('ordnr', $ordnr1);
			}
			elseif(!empty($ordnr1) && !empty($ordnr2)){
			  $_this->db->where('ordnr >=', $ordnr1);
			  $_this->db->where('ordnr <=', $ordnr2);
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
			
			/*$jobnr1 = $_this->input->get('jobnr');
			$jobnr2 = $_this->input->get('jobnr2');
			if(!empty($jobnr1) && empty($jobnr2)){
			  $_this->db->where('jobnr', $jobnr1);
			}
			elseif(!empty($jobnr1) && !empty($jobnr2)){
			  $_this->db->where('jobnr >=', $jobnr1);
			  $_this->db->where('jobnr <=', $jobnr2);
			}*/
			
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

		$res = $query->result_array();
		for($i=0;$i<count($res);$i++){
			$r = $res[$i];
			// search item
			$q_so = $this->db->get_where('vbok', array(
				'ordnr'=>$r['ordnr']
			));
			
			$result_data = $q_so->first_row('array');
			$res[$i]['vbeln'] = $result_data['vbeln'];
			$q_qt = $this->db->get_where('vbak', array(
				'vbeln'=>$result_data['vbeln']
			));
			
			$r_qt = $q_qt->first_row('array');
			$res[$i]['jobnr'] = $r_qt['jobnr'];
			
			//$terms='+'.$res[$i]['terms']." days";
			$my_date = util_helper_get_time_by_date_string($res[$i]['duedt']);
			
			$time_diff = time() - $my_date;
			$day = ceil($time_diff/(24 * 60 * 60));
            
			if($day>0){
				$res[$i]['overd'] = $day;
			}else{ $res[$i]['overd'] = 0; }
		
		}

		//echo $this->db->last_query();
		echo json_encode(array(
			'success'=>true,
			'rows'=>$res,
			'totalCount'=>$totalCount
		));
	}

    function loads_inv(){
		$this->db->set_dbprefix('v_');
		$tbName = 'uinv';
        
		// Start for report
		function createQuery($_this){
			$query = $_this->input->get('query');
			if(!empty($query)){
				$_this->db->where("(invnr LIKE '%$query%'
				OR kunnr LIKE '%$query%'
				OR name1 LIKE '%$query%'
				OR ordnr LIKE '%$query%')", NULL, FALSE);
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
			
	        $ordnr1 = $_this->input->get('ordnr');
			$ordnr2 = $_this->input->get('ordnr2');
			if(!empty($ordnr1) && empty($ordnr2)){
			  $_this->db->where('ordnr', $ordnr1);
			}
			elseif(!empty($ordnr1) && !empty($ordnr2)){
			  $_this->db->where('ordnr >=', $ordnr1);
			  $_this->db->where('ordnr <=', $ordnr2);
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
			
			/*$jobnr1 = $_this->input->get('jobnr');
			$jobnr2 = $_this->input->get('jobnr2');
			if(!empty($jobnr1) && empty($jobnr2)){
			  $_this->db->where('jobnr', $jobnr1);
			}
			elseif(!empty($jobnr1) && !empty($jobnr2)){
			  $_this->db->where('jobnr >=', $jobnr1);
			  $_this->db->where('jobnr <=', $jobnr2);
			}*/
			
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
		$id = $this->input->post('id');
		$query = null;
		
		$status_changed = false;
		$inserted_id = false;
		if(!empty($id)){
			$this->db->limit(1);
			$this->db->where('invnr', $id);
			$query = $this->db->get('vbrk');
			
			// ##### CHECK PERMISSIONS
			$row = $query->first_row('array');
			// status has change
			$status_changed = $row['statu']!=$this->input->post('statu');
			if($status_changed&&$row['statu']!=02&&$row['statu']!=02&&$row['statu']!=03){
				if(XUMS::CAN_DISPLAY('IV') && XUMS::CAN_APPROVE('IV')){
					$limit = XUMS::LIMIT('IV');
					if($limit<$row['netwr']){
						$emsg = 'You do not have permission to change invoice status over than '.number_format($limit);
						echo json_encode(array(
							'success'=>false,
							'errors'=>array( 'statu' => $emsg ),
							'message'=>$emsg
						));
						return;
					}
				}else{
					$emsg = 'You do not have permission to change invoice status.';
					echo json_encode(array(
						'success'=>false,
						'errors'=>array( 'statu' => $emsg ),
						'message'=>$emsg
					));
					return;
				}
			}else{
				if($row['statu']=='02'||$row['statu']=='03'){
					$emsg = 'The invoice that already approved or rejected cannot be update.';
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
        	$emsg = 'The sale order already created invoice doc.';
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
		
		$quono = $this->input->post('vbeln');
		$formData = array(
		    //'invnr' => $this->input->post('invnr'),
			'bldat' => $this->input->post('bldat'),
			'statu' => $this->input->post('statu'),
			'txz01' => $this->input->post('txz01'),
			'delnr' => $this->input->post('delnr'),
			'reanr' => $this->input->post('reanr'),
			'refnr' => $this->input->post('refnr'),
			'ptype' => $this->input->post('ptype'),
			'taxnr' => $this->input->post('taxnr'),
			'terms' => intval($this->input->post('terms')),
			'kunnr' => $this->input->post('kunnr'),
			'netwr' => floatval($this->input->post('netwr')),
			'beamt' => floatval($this->input->post('beamt')),
			'dismt' => floatval($this->input->post('dismt')),
			'taxpr' => floatval($this->input->post('taxpr')),
			'salnr' => $this->input->post('salnr'),
			'ctype' => $this->input->post('ctype'),
			'exchg' => floatval($this->input->post('exchg')),
			'duedt' => $this->input->post('duedt'),
			'condi' => $this->input->post('condi'),
			//'whtnr' => $this->input->post('whtnr'),
			'vat01' => floatval($this->input->post('vat01')),
			'wht01' => floatval($this->input->post('wht01')),
			'whtxt' => $this->input->post('whtxt')//,
			//'deamt' => floatval($this->input->post('deamt'))
		);
		
		// start transaction
		$this->db->trans_start();  
		
		$current_username = XUMS::USERNAME();
		
		if (!empty($query) && $query->num_rows() > 0){
			$this->db->where('invnr', $id);
			//$this->db->set('updat', 'NOW()', false);
			db_helper_set_now($this, 'updat');
			$this->db->set('upnam', $current_username);
			$this->db->update('vbrk', $formData);
		}else{
			$id = $this->code_model->generate('IV', 
			$this->input->post('bldat'));
			$this->db->set('invnr', $id);
			//$this->db->set('erdat', 'NOW()', false);
			db_helper_set_now($this, 'erdat');
		    $this->db->set('ernam', $current_username);
			$this->db->insert('vbrk', $formData);
			
			$inserted_id = $id;
			
			//$invno = $this->input->post('invnr');
			$qtno = $this->input->post('vbeln');
			$this->db->where('vbeln', $qtno);
			$this->db->where('chk01', '1');
	        $q_gr = $this->db->get('payp');
		
		    if($q_gr->num_rows()>0){   
			}else{
			   $this->db->where('delnr', $this->input->post('delnr'));
			   $this->db->set('loekz', '2');
			   $this->db->update('vbvk');
			}
		}
        
		// ลบ pr_item ภายใต้ id ทั้งหมด
		$this->db->where('invnr', $id);
		$this->db->delete('vbrp');

		// เตรียมข้อมูล pr item
		$vbrp = $this->input->post('vbrp');
		$iv_item_array = json_decode($vbrp);
		
		if(!empty($vbrp) && !empty($iv_item_array)){
			// loop เพื่อ insert pr_item ที่ส่งมาใหม่
			$item_index = 0;
		foreach($iv_item_array AS $p){
			$itamt = $p->menge * $p->unitp;
		    $itamt = $itamt - $p->disit;
			$this->db->insert('vbrp', array(
				'invnr'=>$id,
				'vbelp'=>intval(++$item_index),
				'matnr'=>$p->matnr,
				'menge'=>floatval($p->menge),
				'meins'=>$p->meins,
				'disit'=>$p->disit,
				'unitp'=>floatval($p->unitp),
				'itamt'=>floatval($p->itamt),
				'ctype'=>$p->ctype,
				'chk01'=>$p->chk01,
				'chk02'=>$p->chk02,
				'whtnr'=>$p->whtnr
				//'reman'=>floatval($p->reman),
				//'upqty'=>floatval($p->upqty)
			));
	    	}
		}
		
		// ลบ pay_item ภายใต้ id ทั้งหมด
		$this->db->where('vbeln', $id);
		$this->db->delete('payp');

		// เตรียมข้อมูล pay item
		$payp = $this->input->post('payp');//$this->input->post('vbelp');
		$pp_item_array = json_decode($payp);
		if(!empty($payp) && !empty($pp_item_array)){
            $item_index = 0;
			// loop เพื่อ insert pay_item ที่ส่งมาใหม่
			$pramt = 0;$amt = 0;$paypr=0;
			foreach($pp_item_array AS $p){
				$paypr=$p->loekz;
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
					'loekz'=>$p->loekz,
					'sgtxt'=>$p->sgtxt,
					'duedt'=>$p->duedt,
					'perct'=>$p->perct,
					'pramt'=>floatval($this->input->post('beamt')),
					'ctyp1'=>$p->ctyp1,
					'payty'=>$p->payty,
				));
				$this->db->where('vbeln', $quono);
			    $this->db->where('paypr', $paypr);
			    $this->db->set('chk01', '2');
			    $this->db->update('payp');
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
			'txz01' => 'Invoice No '.$id,
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
					'txz01'=>'Invoice No '.$id
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
					$q_row = $this->db->get_where('vbrk', array('invnr'=>$inserted_id));
					$row = $q_row->first_row();
					$this->email_service->sendmail_create(
						'IV', 'Inovice',
						$inserted_id, $total_amount,
						$row->ernam
					);
				}else if(!empty($post_id)){
					if($status_changed){
						$q_row = $this->db->get_where('vbrk', array('invnr'=>$post_id));
						$row = $q_row->first_row();
						$this->email_service->sendmail_change_status(
							'IV', 'Inovice',
							$post_id, $total_amount, $row->statu,
							$row->ernam
						);
					}
				}
			}catch(exception $e){}
		}
	}

    public function loads_condcombo(){
		$tbName = 'cond';
		$tbPK = 'condi';
        
		$query = $this->input->post('query');

		$totalCount = $this->db->count_all_results($tbName);

		if(!empty($query) && $query!=''){
			$this->db->or_like('contx', $query);
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
		$this->db->where('invnr', $id);
		$query = $this->db->delete('vbrk');
		echo json_encode(array(
			'success'=>true,
			'data'=>$id
		));
	}
	
	///////////////////////////////////////////////
	// Quotation ITEM
	///////////////////////////////////////////////

	function loads_iv_item(){
		$donr = $this->input->get('donr');
		if(!empty($donr)){
			$this->db->set_dbprefix('v_');
		    $this->db->where('delnr', $donr);

		    $query = $this->db->get('vbvp');
			
			$res = $query->result_array();
			$sumqty = 0;
			//echo 'aaa'.$res[0]['whtpr'];
		for($i=0;$i<count($res);$i++){
			$r = $res[$i];
			
			$res[$i]['menge'] = $res[$i]['upqty'];
		}
		
		echo json_encode(array(
			'success'=>true,
			'rows'=>$res,
			'totalCount'=>$query->num_rows()
		));
		}else{
            $this->db->set_dbprefix('v_');
	     	$iv_id = $this->input->get('invnr');
		    $this->db->where('invnr', $iv_id);

		    $query = $this->db->get('vbrp');
		
		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$query->num_rows()
		));
		}
	}
	
	function loads_pay_item(){
        //$this->db->set_dbprefix('v_');
		$pp_id = $this->input->get('invnr');
		$this->db->where('vbeln', $pp_id);

		$query = $this->db->get('payp');
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
	       $vvat = $this->input->get('vvat');    //VAT amt    
		   $kunnr = $this->input->get('kunnr');  //Customer Code
		   //$deamt = $this->input->get('deamt');  //Deposit
		   //$devat = $this->input->get('devat');
		   $itms = $this->input->get('items');  //Doc Type
		   $items = explode(',',$itms);
           
		   if(empty($vvat)) $vvat=0;
		   //if(empty($vwht)) $vwht=0;
		   
		   $net = $netpr + $vvat;
		   
           $i=0;$n=0;$vamt=0;$debit=0;$credit=0;
		   $result = array();
// record แรก
			$query = $this->db->get_where('kna1', array(
				'kunnr'=>$kunnr));
			if($query->num_rows()>0){
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
					'debit'=>$net,
					'credi'=>0
				);
				$i++;
				$debit=$net;
				}
				}
			}

// record ที่สอง
   /*if(!empty($deamt)){
		$glvat = '2130-00'; //'1130-05';
		$qgl = $this->db->get_where('glno', array(
				'saknr'=>$glvat));
		if($qgl->num_rows()>0){
		$q_glno = $qgl->first_row('array');
		$result[$i] = array(
		    'belpr'=>$i + 1,
			'saknr'=>$glvat,
			'sgtxt'=>$q_glno['sgtxt'],
			'debit'=>$deamt,
			'credi'=>0
		);
		$i++;
		$debit = $debit + $deamt;	
		}
		}
// record ที่สอง.หนึ่ง
   if(!empty($devat)){
		$glvat = '2136-00';
		$qgl = $this->db->get_where('glno', array(
				'saknr'=>$glvat));
		if($qgl->num_rows()>0){
		$q_glno = $qgl->first_row('array');
		$result[$i] = array(
		    'belpr'=>$i + 1,
			'saknr'=>$glvat,
			'sgtxt'=>$q_glno['sgtxt'],
			'debit'=>$devat,
			'credi'=>0
		);
		$i++;
		$debit = $debit + $devat;	
		}
		}*/
// record ที่สอง.สอง
        if(!empty($items)){
			// loop เพื่อ insert
		for($j=0;$j<count($items);$j++){
			$item = explode('|',$items[$j]);
			$glno = $item[0];
			$amt  = $item[1];
			
			$qgl = $this->db->get_where('glno', array(
				'saknr'=>$glno));
			if($qgl->num_rows()>0){
		    $q_glno = $qgl->first_row('array');
			
			$result[$i] = array(
		    'belpr'=>$i + 1,
			'saknr'=>$glno,
			'sgtxt'=>$q_glno['sgtxt'],
			'debit'=>0,
			'credi'=>$amt
		);
		$i++;
		$credit = $credit + $amt;	
			}
	    }
		}
// record ที่สาม
		if($vvat>0){ 
		//	$net_tax = floatval($net) * 0.07;}
		$glvat = '2135-00';
		$qgl = $this->db->get_where('glno', array(
				'saknr'=>$glvat));
		if($qgl->num_rows()>0){
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
	
    function loads_conp_item(){
        $menge = $this->input->get('menge');
		$unitp = $this->input->get('unitp');
		$disit = $this->input->get('disit');
		$vvat = $this->input->get('vvat');
		$vwht = $this->input->get('vwht');
		$vat = $this->input->get('vat');
		$vattype = $this->input->get('vattype');
		//$wht = $this->input->get('wht');
		$amt = $menge * $unitp;
        $i=0;$vamt=0;
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
						
						//if(empty($damt)) $damt='0.00';

						$result[$i] = array(
					    'contx'=>$row['contx'],
				     	'vtamt'=>$damt,
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
					}elseif($row['conty']=='03'){
						if(!empty($vwht)){
							$vwht = str_replace('%', ' ', $vwht);
							$vwht = ($amt * $vwht) / 100;
							$tamt = $amt - $vwht;
							$tamt = $tamt + $vamt;
						$result[$i] = array(
					        'contx'=>$row['contx'],
				     	    'vtamt'=>$vwht,
					        'ttamt'=>$tamt
				        );$i++;
					}
				}
			}}
		echo json_encode(array(
			'success'=>true,
			'rows'=>$result,
			'totalCount'=>count($result)
		));
	}

	public function loads_wht(){
		$tbName = 'whty';
		$tbPK = 'whtnr';
		
		$id = $this->input->post('id');
		$this->db->limit(1);
		$this->db->where('whtnr', $id);

		$query = $this->input->post('query');

		$totalCount = $this->db->count_all_results($tbName);

		if(!empty($query) && $query!=''){
			$this->db->or_like('whtxt', $query);
			$this->db->or_like($tbPK, $query);
		}

		$query = $this->db->get($tbName);

		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$totalCount
		));
	}
	}