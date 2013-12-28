<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('code_model','',TRUE);
	}

	function index(){
	}

	function load(){
		$this->db->set_dbprefix('v_');
		$id = $this->input->post('id');
		$this->db->limit(1);
		$this->db->where('payno', $id);
		$query = $this->db->get('ebbk');
		
		if($query->num_rows()>0){
			$result = $query->first_row('array');
			$result['id'] = $result['payno'];
			
			$result['adr01'] .= $result['distx'].' '.$result['pstlz'].
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
		$tbName = 'ebbk';
		
		// Start for report
		function createQuery($_this){
			$query = $_this->input->get('query');
			if(!empty($query)){
				$_this->db->where("(`paynr` LIKE '%$query%'
				OR `lifnr` LIKE '%$query%'
				OR `name1` LIKE '%$query%'
				OR `invnr` LIKE '%$query%')", NULL, FALSE);
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
			
			$duedt1 = $_this->input->get('duedt1');
			$duedt2 = $_this->input->get('duedt2');
			if(!empty($duedt1) && empty($duedt2)){
			  $_this->db->where('duedt', $duedt1);
			}
			elseif(!empty($duedt2) && !empty($duedt2)){
			  $_this->db->where('duedt >=', $duedt2);
			  $_this->db->where('duedt <=', $duedt2);
			}
			
            $payno1 = $_this->input->get('payno');
			$payno2 = $_this->input->get('payno2');
			if(!empty($payno1) && empty($payno2)){
			  $_this->db->where('payno', $payno1);
			}
			elseif(!empty($payno1) && !empty($payno2)){
			  $_this->db->where('payno >=', $payno1);
			  $_this->db->where('payno <=', $payno2);
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
		}
// End for report

		$totalCount = $this->db->count_all_results($tbName);

		createQuery($this);
		$limit = $this->input->get('limit');
		$start = $this->input->get('start');
		if(isset($limit) && isset($start)) $this->db->limit($limit, $start);

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
		if(!empty($id)){
			$this->db->limit(1);
			$this->db->where('payno', $id);
			$query = $this->db->get('ebbk');
		}

		$formData = array(
			'bldat' => $this->input->post('bldat'),
			'lifnr' => $this->input->post('lifnr'),
			'netwr' => $this->input->post('netwr'),
			'beamt' => $this->input->post('beamt'),
			'dismt' => $this->input->post('dismt'),
			'txz01' => $this->input->post('txz01'),
			'ctype' => $this->input->post('ctype'),
			'exchg' => $this->input->post('exchg'),
			'reanr' => $this->input->post('reanr'),
			'statu' => $this->input->post('statu'),
			'duedt' => $this->input->post('duedt'),
			'dispc' => $this->input->post('dispc')
		);
		
		// start transaction
		$this->db->trans_start();  
		
		if (!empty($query) && $query->num_rows() > 0){
			$this->db->where('payno', $id);
			$this->db->set('updat', 'NOW()', false);
			$this->db->set('upnam', 'somwang');
			$this->db->update('ebbk', $formData);
		}else{
			$id = $this->code_model->generate('PY', $this->input->post('bldat'));
			$this->db->set('payno', $id);
			$this->db->set('erdat', 'NOW()', false);
		    $this->db->set('ernam', 'somwang');
			$this->db->insert('ebbk', $formData);
		}

		// ลบ receipt item ภายใต้ id ทั้งหมด
		$this->db->where('payno', $id);
		$this->db->delete('ebbp');

		// เตรียมข้อมูล payment item
		$ebbp = $this->input->post('ebbp');
		$py_item_array = json_decode($ebbp);
		
		if(!empty($ebbp) && !empty($py_item_array)){
			// loop เพื่อ insert payment item ที่ส่งมาใหม่
			$item_index = 0;
		foreach($py_item_array AS $p){
			$this->db->insert('ebbp', array(
				'payno'=>$id,
				'vbelp'=>++$item_index,
				'invnr'=>$p->invnr,
				'invdt'=>$p->invdt,
				'texts'=>$p->texts,
				'itamt'=>$p->itamt,
				'reman'=>$p->reman,
				'payrc'=>$p->payrc,
				'refnr'=>$p->refnr,
				'ctype'=>$p->ctype,
				'wht01'=>$p->wht01,
				'vat01'=>$p->vat01,
				'dtype'=>$p->dtype
			));
	    	}
		}
		
		// ลบ pay_item ภายใต้ id ทั้งหมด
		$this->db->where('recnr', $id);
		$this->db->delete('paym');
		
		// เตรียมข้อมูล pm item
		$paym = $this->input->post('paym');
		$pm_item_array = json_decode($paym);
		if(!empty($paym) && !empty($pm_item_array)){

			$item_index = 0;
			// loop เพื่อ insert pm_item ที่ส่งมาใหม่
			foreach($pm_item_array AS $p){
				$this->db->insert('paym', array(
					'recnr'=>$id,
					'paypr'=>++$item_index,
					'sgtxt'=>$p->sgtxt,
					'chqid'=>$p->chqid,
					'chqdt'=>$p->chqdt,
					'bcode'=>$p->bcode,
					'ptype'=>$p->ptype,
					'pramt'=>$p->pramt,
					'reman'=>$p->reman,
					'payam'=>$p->payam
				));
			}
		}

//*** Save GL Posting	
        //$ids = $id;	
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
			'kunnr' => $this->input->post('lifnr'),
			'txz01' => 'Payment No '.$id,
			'ttype' => '03',
			'auart' => 'PV',
			'netwr' => $this->input->post('netwr')
		);
		
		// start transaction
		$this->db->trans_start();  
		
		if (!empty($query) && $query->num_rows() > 0){
			$q_gl = $query->first_row('array');
			$accno = $q_gl['belnr'];
			$this->db->where('belnr', $accno);
			$this->db->set('updat', 'NOW()', false);
			$this->db->set('upnam', 'test');
			$this->db->update('bkpf', $formData);
		}else{
			$accno = $this->code_model->generate('PV', 
			$this->input->post('bldat'));
			$this->db->set('belnr', $accno);
			$this->db->set('erdat', 'NOW()', false);
		    $this->db->set('ernam', 'test');
			$this->db->insert('bkpf', $formData);
		}
		
		// ลบ gl_item ภายใต้ id ทั้งหมด
		$this->db->where('belnr', $accno);
		$this->db->delete('bven');

		// เตรียมข้อมูล pay item
		$bven = $this->input->post('bven');
		$gl_item_array = json_decode($bven);
		if(!empty($bven) && !empty($gl_item_array)){

			$item_index = 0;
			// loop เพื่อ insert pay_item ที่ส่งมาใหม่
			foreach($gl_item_array AS $p){
				if($p->statu=='1' && !empty($p->saknr)){
				$this->db->insert('bven', array(
					'belnr'=>$accno,
					'belpr'=>++$item_index,
					'gjahr'=>substr($date,0,4),
					'bldat' => $this->input->post('bldat'),
					'kunnr' => $this->input->post('lifnr'),
					'saknr'=>$p->saknr,
					'debit'=>$p->debit,
					'credi'=>$p->credi,
					'docty'=>'01',
					'txz01' => 'Payment No '.$id
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
			$query = $this->db->get('bven');
		}
		
		$formData = array(
		    'gjahr' => substr($date,0,4),
		    'bldat' => $this->input->post('bldat'),
			'invnr' => $id,
			'refnr' => $id,
			'kunnr' => $this->input->post('lifnr'),
			'txz01' => 'Payment No '.$id,
			'ttype' => '03',
			'auart' => 'PV',
			'netwr' => $this->input->post('netwr')
		);
		
		// start transaction
		$this->db->trans_start();  
		$this->db->set_dbprefix('tbl_');
		if (!empty($query) && $query->num_rows() > 0){
			$q_gl = $query->first_row('array');
			$accno = $q_gl['belnr'];
			$this->db->where('belnr', $accno);
			$this->db->set('updat', 'NOW()', false);
			$this->db->set('upnam', 'test');
			$this->db->update('bkpf', $formData);
		}else{
			$accno = $this->code_model->generate('PV', 
			$this->input->post('bldat'));
			$this->db->set('belnr', $accno);
			$this->db->set('erdat', 'NOW()', false);
		    $this->db->set('ernam', 'test');
			$this->db->insert('bkpf', $formData);
		}
		
		// ลบ gl_item ภายใต้ id ทั้งหมด
		$this->db->where('belnr', $accno);
		$this->db->delete('bven');

		// เตรียมข้อมูล pay item
		$bcus = $this->input->post('bven');
		$gl_item_array = json_decode($bcus);
		if(!empty($bcus) && !empty($gl_item_array)){

			$item_index = 0;
			// loop เพื่อ insert pay_item ที่ส่งมาใหม่
			foreach($gl_item_array AS $p){
				if($p->statu=='2' && !empty($p->saknr)){
				$this->db->insert('bven', array(
					'belnr'=>$accno,
					'belpr'=>++$item_index,
					'gjahr'=>substr($date,0,4),
					'bldat' => $this->input->post('bldat'),
					'kunnr' => $this->input->post('lifnr'),
					'saknr'=>$p->saknr,
					'debit'=>$p->debit,
					'credi'=>$p->credi,
					'docty'=>'02',
					'txz01' => 'Deposit Payment No '.$id
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
				// also send id after save
				'data'=> array(
					'id'=>$id
				)
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
	// Payment ITEM
	///////////////////////////////////////////////

	function loads_py_item(){
        $this->db->set_dbprefix('v_');
        
	    $py_id = $this->input->get('payno');
		$this->db->where('payno', $py_id);

	    $query = $this->db->get('ebbp');
       // echo $this->db->last_query();
		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$query->num_rows()
		));
	}
	
	function loads_pm_item(){
        $this->db->set_dbprefix('v_');
		//$pm_id = $this->input->get('recnr'); 
		$pm_id = $this->input->get('recnr'); //payno เลขที่ payment
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
		   $vwht = $this->input->get('vwht');
		   $vvat = $this->input->get('vvat');
		   $dtype = $this->input->get('dtype');
		   $lifnr = $this->input->get('lifnr');  //Customer Code
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

       $bamt=0;
       if($dtype == 'D'){
// record ที่หนึ่ง
        if($net>0){
        	$gl_vat = '1151-06';
			$qgl = $this->db->get_where('glno', array(
				'saknr'=>$gl_vat));
		if($qgl->num_rows()>0){
				$q_glno = $qgl->first_row('array');
		$result[$i] = array(
		    'belpr'=>$i + 1,
			'saknr'=>$gl_vat,
			'sgtxt'=>$q_glno['sgtxt'],
			'debit'=>$net,
			'credi'=>0,
			'statu'=>'1'
		);
		$i++;
		$debit+=$net;
		}}

// record ที่สอง
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
			'debit'=>$vvat,
			'credi'=>0,
			'statu'=>'1'
		);
		$i++;
		$debit+=$vvat;
		}}
// record ที่สาม
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
			'debit'=>0,
			'credi'=>$vwht,
			'statu'=>'1'
		);
		$i++;
		$credit = $credit + $vwht;	
		}}
		
// record ที่สี่
         for($j=0;$j<count($items);$j++){
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
					'debit'=>0,
					'credi'=>$payam,
					'statu'=>'1'
				);
				$i++;
				$credit+=$payam;
				}
			}
          }//loop เพื่อ insert pay_item ที่ส่งมาใหม่
		//}//Check payment grid
				
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
        $net_vat=$net+$vvat;
		$debit=0;$credit=0;$j=0;
		$gl_vat = '2131-14';
			$qgl = $this->db->get_where('glno', array(
				'saknr'=>$gl_vat));
				if($qgl->num_rows()>0){
				$q_glno = $qgl->first_row('array');
		$result[$i] = array(
		    'belpr'=>$j + 1,
			'saknr'=>$gl_vat,
			'sgtxt'=>$q_glno['sgtxt'],
			'debit'=>$net_vat,
			'credi'=>0,
			'statu'=>'2'
		);
		$i++;
		$debit+=$bamt;
		}
//record ที่ สอง-> New Deposit posting
        if($vvat>0){
        	$gl_vat = '1155-00';
			$qgl = $this->db->get_where('glno', array(
				'saknr'=>$gl_vat));
				if($qgl->num_rows()>0){
				$q_glno = $qgl->first_row('array');
		$result[$i] = array(
		    'belpr'=>$j + 1,
			'saknr'=>$gl_vat,
			'sgtxt'=>$q_glno['sgtxt'],
			'debit'=>0,
			'credi'=>$vvat,
			'statu'=>'2'
		);
		$i++;
		$credit+=$vvat;
		}}
//record ที่ สาม -> New Deposit posting
        $gl_vat = '1151-06';
		    //$grand = $net + $vwht;
			$qgl = $this->db->get_where('glno', array(
				'saknr'=>$gl_vat));
				if($qgl->num_rows()>0){
				$q_glno = $qgl->first_row('array');
		$result[$i] = array(
		    'belpr'=>$j + 1,
			'saknr'=>$gl_vat,
			'sgtxt'=>$q_glno['sgtxt'],
			'debit'=>0,
			'credi'=>$net,
			'statu'=>'2'
		);
		$i++;
		$credit+=$net;
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
      	
 // record แรก
            if($net>0){
			$query = $this->db->get_where('lfa1', array(
				'lifnr'=>$lifnr));
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
					'credi'=>0,
					'statu'=>'1'
				);
				$i++;
				$debit+=$net;
			}}
		    }
		
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
			'debit'=>0,
			'credi'=>$vwht,
			'statu'=>'1'
		);
		$i++;
		$credit = $credit + $vwht;	
		}}
// record ที่สาม
        for($j=0;$j<count($items);$j++){
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
					'debit'=>0,
					'credi'=>$payam,
					'statu'=>'1'
				);
				$i++;
				$credit+=$payam;
				}
			}
          }//loop เพื่อ insert pay_item ที่ส่งมาใหม่
		}//Check payment grid
		
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
		   $this->db->set_dbprefix('v_');
		   $this->db->where('belnr', $iv_id);
		   $query = $this->db->get('bven');
		   echo json_encode(array(
			  'success'=>true,
			  'rows'=>$query->result_array(),
			  'totalCount'=>$query->num_rows()
		));
	  }
	}
}