<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Receipt extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('code_model','',TRUE);
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
			//$invnr1 = $_this->input->get('invnr');
			//$invnr2 = $_this->input->get('invnr2');
			//if(!empty($invnr1) && empty($invnr2)){
			//  $_this->db->where('invnr', $invnr1);
			//}
			//elseif(!empty($invnr1) && !empty($invnr2)){
			//  $_this->db->where('invnr >=', $invnr1);
			//  $_this->db->where('invnr <=', $invnr2);
			//}
			
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

		$totalCount = $this->db->count_all_results($tbName);

		createQuery($this);
		$limit = $this->input->get('limit');
		$start = $this->input->get('start');
		if(isset($limit) && isset($start)) $this->db->limit($limit, $start);

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
		if(!empty($id)){
			$this->db->limit(1);
			$this->db->where('recnr', $id);
			$query = $this->db->get('vbbk');
		}
		
		$formData = array(
			//'recnr' => $this->input->post('recnr'),
			'bldat' => $this->input->post('bldat'),
			'kunnr' => $this->input->post('kunnr'),
			'netwr' => $this->input->post('netwr'),
			'beamt' => $this->input->post('beamt'),
			'dismt' => $this->input->post('dismt'),
			//'ctype' => $curr,
			//'exchg' => $this->input->post('exchg'),
			'duedt' => $this->input->post('duedt')
		);
		
		// start transaction
		$this->db->trans_start();  
		
		if (!empty($query) && $query->num_rows() > 0){
			$this->db->where('recnr', $id);
			$this->db->set('updat', 'NOW()', false);
			$this->db->set('upnam', 'test');
			$this->db->update('vbbk', $formData);
		}else{
			$id = $this->code_model->generate('RD', 
			$this->input->post('bldat'));
			//echo ($id);
			$this->db->set('recnr', $id);
			$this->db->set('erdat', 'NOW()', false);
		    $this->db->set('ernam', 'test');
			$this->db->insert('vbbk', $formData);
			
			//$id = $this->db->insert_id();
		}

		// ลบ receipt item ภายใต้ id ทั้งหมด
		$this->db->where('recnr', $id);
		$this->db->delete('vbbp');

		// เตรียมข้อมูล receipt item
		$vbbp = $this->input->post('vbbp');
		$rc_item_array = json_decode($vbbp);
		//echo $this->db->last_query();
		
		if(!empty($vbbp) && !empty($rc_item_array)){
			// loop เพื่อ insert receipt item ที่ส่งมาใหม่
			$item_index = 0;
		foreach($rc_item_array AS $p){
			$this->db->insert('vbbp', array(
				'recnr'=>$id,
				'vbelp'=>++$item_index,
				'invnr'=>$p->invnr,
				'invdt'=>$p->invdt,
				'texts'=>$p->texts,
				'itamt'=>$p->itamt,
				'reman'=>$p->reman,
				'payrc'=>$p->payrc,
				'refnr'=>$p->refnr
			));
	    	}
		}
		
		// ลบ pay_item ภายใต้ id ทั้งหมด
		$this->db->where('recnr', $id);
		$this->db->delete('paym');

		// เตรียมข้อมูล pay item
		$paym = $this->input->post('paym');
		$pm_item_array = json_decode($paym);
		$cheque='';$noncheque='';
		if(!empty($paym) && !empty($pm_item_array)){

			$item_index = 0;
			// loop เพื่อ insert pay_item ที่ส่งมาใหม่
			foreach($pm_item_array AS $p){
				if($p->ptype=='05'){
					$cheque = '1';
				}else{if(!empty($p->ptype))$noncheque = '1';}
				$this->db->insert('paym', array(
					'recnr'=>$id,
					'paypr'=>++$item_index,
					'ptype'=>$p->ptype,
					'bcode'=>$p->bcode,
					'sgtxt'=>$p->sgtxt,
					'chqid'=>$p->chqid,
					'chqdt'=>$p->chqdt,
					'pramt'=>$p->pramt,
					'reman'=>$p->reman,
					'payam'=>$p->payam
				));
			}
		}
		
//*** Save GL Posting	
        $ids = $id;	
		$id = $this->input->post('id');
		$query = null;
		if(!empty($id)){
			$this->db->limit(1);
			$this->db->where('invnr', $id);
			$query = $this->db->get('bkpf');
		}
		$date = date('Ymd');
//Non Cheque Payment
	if($noncheque=='1'){
		$formData = array(
		    'gjahr' => substr($date,0,4),
		    'bldat' => $this->input->post('bldat'),
			'invnr' => $ids,
			'txz01' => $this->input->post('txz01'),
			'auart' => 'RV',
			'netwr' => $this->input->post('netwr')
		);
		
		// start transaction
		$this->db->trans_start();  
		
		if (!empty($query) && $query->num_rows() > 0){
			$q_gl = $query->first_row('array');
			$id = $q_gl['belnr'];
			$this->db->where('belnr', $id);
			$this->db->set('updat', 'NOW()', false);
			$this->db->set('upnam', 'test');
			$this->db->update('bkpf', $formData);
		}else{
			$id = $this->code_model->generate('RV', 
			$this->input->post('bldat'));
			$this->db->set('belnr', $id);
			$this->db->set('erdat', 'NOW()', false);
		    $this->db->set('ernam', 'test');
			$this->db->insert('bkpf', $formData);
		}
		
		// ลบ gl_item ภายใต้ id ทั้งหมด
		$this->db->where('belnr', $id);
		$this->db->delete('bcus');

		// เตรียมข้อมูล pay item
		$bcus = $this->input->post('bcus');
		$gl_item_array = json_decode($bcus);
		if(!empty($bcus) && !empty($gl_item_array)){

			$item_index = 0;
			// loop เพื่อ insert pay_item ที่ส่งมาใหม่
			foreach($gl_item_array AS $p){
				if($p->statu=='1'){
				$this->db->insert('bcus', array(
					'belnr'=>$id,
					'belpr'=>++$item_index,
					'gjahr'=>substr($date,0,4),
					'saknr'=>$p->saknr,
					'debit'=>$p->debit,
					'credi'=>$p->credi,
					'txz01'=>$p->txz01
				));
				}
			}
		  }
		}
//Have Cheque Payment		
		if($cheque=='1'){
			$formData = array(
		    'gjahr' => substr($date,0,4),
		    'bldat' => $this->input->post('bldat'),
			'invnr' => $ids,
			'txz01' => $this->input->post('txz01'),
			'auart' => 'RC',
			'netwr' => $this->input->post('netwr')
		);
		if (!empty($query) && $query->num_rows() > 0){
			$q_gl = $query->first_row('array');
			$id = $q_gl['belnr'];
			$this->db->where('belnr', $id);
			$this->db->set('updat', 'NOW()', false);
			$this->db->set('upnam', 'test');
			$this->db->update('bkpf', $formData);
		}else{
			$id = $this->code_model->generate('RC', 
			$this->input->post('bldat'));
			$this->db->set('belnr', $id);
			$this->db->set('erdat', 'NOW()', false);
		    $this->db->set('ernam', 'test');
			$this->db->insert('bkpf', $formData);
		}
		
		// ลบ gl_item ภายใต้ id ทั้งหมด
		$this->db->where('belnr', $id);
		$this->db->delete('bcus');

		// เตรียมข้อมูล pay item
		$bcus = $this->input->post('bcus');
		$gl_item_array = json_decode($bcus);
		if(!empty($bcus) && !empty($gl_item_array)){

			$item_index = 0;
			// loop เพื่อ insert pay_item ที่ส่งมาใหม่
			foreach($gl_item_array AS $p){
				if($p->statu=='2'){
				$this->db->insert('bcus', array(
					'belnr'=>$id,
					'belpr'=>++$item_index,
					'gjahr'=>substr($date,0,4),
					'saknr'=>$p->saknr,
					'debit'=>$p->debit,
					'credi'=>$p->credi,
					'txz01'=>$p->txz01
				));
				}
			}
		  }
		}
		
		// end transaction
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
			echo json_encode(array(
				'success'=>false
			));
		else
			echo json_encode(array(
				'success'=>true,
				'data'=>$_POST
			));
	}
	
	public function loads_pcombo(){
		$tbName = 'ptyp';
		$tbPK = 'ptype';

		$query = $this->input->post('query');

		$totalCount = $this->db->count_all_results($tbName);

		if(!empty($query) && $query!=''){
			$this->db->or_like('paytx', $query);
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
        
		// Start for report
		/*function createQuery($_this){
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
		
			$bldat1 = $_this->input->get('bldat');
			$bldat2 = $_this->input->get('bldat2');
			if(!empty($bldat1) && empty($bldat2)){
			  $_this->db->where('bldat', $bldat1);
			}
			elseif(!empty($bldat1) && !empty($bldat2)){
			  $_this->db->where('bldat >=', $bldat1);
			  $_this->db->where('bldat <=', $bldat2);
			}
			
			$duedt1 = $_this->input->get('duedt');
			$duedt2 = $_this->input->get('duedt2');
			if(!empty($duedt1) && empty($duedt2)){
			  $_this->db->where('duedt', $duedt1);
			}
			elseif(!empty($duedt1) && !empty($duedt2)){
			  $_this->db->where('duedt >=', $duedt1);
			  $_this->db->where('duedt <=', $duedt2);
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
			
		}*/
		
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
		$iv_id = $this->input->get('belnr');

		if(empty($iv_id)){
		   $net = $this->input->get('netpr');  //Net amt
		   $kunnr = $this->input->get('kunnr');  //Customer Code
		   //$ptype = $this->input->get('ptype');  //Pay Type
		   $dtype = $this->input->get('dtype');  //Doc Type
		   
           $i=0;$n=0;$vamt=0;
		   $result = array();
		   
		   // เตรียมข้อมูล pay item
		$paym = $this->input->get('paym');
		$pm_item_array = json_decode($paym);
//Check payment grid	
		if(!empty($paym) && !empty($pm_item_array)){
        //echo '111'.$pm_item_array.'222';
			$item_index = 0;
// loop เพื่อ insert pay_item ที่ส่งมาใหม่
			foreach($pm_item_array AS $p){
					$ptype = $p->ptype;
				    $payam = $p->payam;
					$reman = $p->reman;
					//$net = $net + $payam;

 // record แรก
            $query = $this->db->get_where('ptyp', array(
			'ptype'=>$ptype));
			if($query->num_rows()>0){
				$q_data = $query->first_row('array');
				$qgl = $this->db->get_where('glno', array(
				'saknr'=>$q_data['saknr']));
				$q_glno = $qgl->first_row('array');
				if($ptype=='05'){$statu='2';}else{$statu='1';}
				$result[$i] = array(
				    'belpr'=>$i + 1,
					'saknr'=>$q_data['saknr'],
					'sgtxt'=>$q_glno['sgtxt'],
					'debit'=>$payam,
					'credi'=>0,
					'statu'=>$statu
				);
				$i++;
//Case cheque payment				
				if($ptype=='05'){
					$query = $this->db->get_where('kna1', array(
				'kunnr'=>$kunnr));
			if($query->num_rows()>0){
				$q_data = $query->first_row('array');
				$qgl = $this->db->get_where('glno', array(
				'saknr'=>$q_data['saknr']));
				$q_glno = $qgl->first_row('array');
				$result[$i] = array(
				    'belpr'=>$i + 1,
					'saknr'=>$q_data['saknr'],
					'sgtxt'=>$q_glno['sgtxt'],
					'debit'=>0,
					'credi'=>$payam,
					'statu'=>'2'
				);
				$net=$net-$payam;
				$i++;
				}
			  }//Case cheque payment
				
			} // record แรก
          }//loop เพื่อ insert pay_item ที่ส่งมาใหม่
		}//Check payment grid
		
		if($net>0){
// record ที่สอง
			$query = $this->db->get_where('kna1', array(
				'kunnr'=>$kunnr));
			if($query->num_rows()>0){
				$q_data = $query->first_row('array');
				$qgl = $this->db->get_where('glno', array(
				'saknr'=>$q_data['saknr']));
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
			}
		}
		echo json_encode(array(
			'success'=>true,
			'rows'=>$result,
			'totalCount'=>count($result)
		));
//In Case Edit and Display		   
		}else{
		   $this->db->set_dbprefix('v_');
		   $this->db->where('belnr', $iv_id);
		   $query = $this->db->get('bsid');
		   echo json_encode(array(
			  'success'=>true,
			  'rows'=>$query->result_array(),
			  'totalCount'=>$query->num_rows()
		));
	  }
	}
}