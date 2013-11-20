<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Depositout extends CI_Controller {

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
		$this->db->where('depnr', $id);
		$query = $this->db->get('ebdk');
		
		if($query->num_rows()>0){
			$result = $query->first_row('array');
			$result['id'] = $result['depnr'];
			
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
		$tbName = 'ebdk';
		
		// Start for report
		function createQuery($_this){
			
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
			$this->db->where('depnr', $id);
			$query = $this->db->get('ebdk');
		}
		
		$formData = array(
			'vbeln' => $this->input->post('vbeln'),
			'bldat' => $this->input->post('bldat'),
			'kunnr' => $this->input->post('kunnr'),
			'netwr' => $this->input->post('netwr'),
			'beamt' => $this->input->post('beamt'),
			'dismt' => $this->input->post('dismt'),
			'ctype' => $this->input->post('ctype'),
			'exchg' => $this->input->post('exchg'),
			'reanr' => $this->input->post('reanr'),
			'statu' => $this->input->post('statu'),
			'txz01' => $this->input->post('txz01')//,
			//'duedt' => $this->input->post('duedt')
		);
		
		// start transaction
		$this->db->trans_start();  
		
		if (!empty($query) && $query->num_rows() > 0){
			$this->db->where('depnr', $id);
			$this->db->set('updat', 'NOW()', false);
			$this->db->set('upnam', 'test');
			$this->db->update('ebdk', $formData);
		}else{
			$id = $this->code_model->generate('DP', 
			$this->input->post('bldat'));
			//echo ($id);
			$this->db->set('depnr', $id);
			$this->db->set('erdat', 'NOW()', false);
		    $this->db->set('ernam', 'test');
			$this->db->insert('ebdk', $formData);
			
			//$id = $this->db->insert_id();
		}

		// ลบ receipt item ภายใต้ id ทั้งหมด
		$this->db->where('depnr', $id);
		$this->db->delete('ebdp');

		// เตรียมข้อมูล receipt item
		$vbdp = $this->input->post('ebdp');
		$dp_item_array = json_decode($vbdp);
		//echo $this->db->last_query();
		
		if(!empty($vbdp) && !empty($dp_item_array)){
			// loop เพื่อ insert receipt item ที่ส่งมาใหม่
			$item_index = 0;
		foreach($dp_item_array AS $p){
			$this->db->insert('ebdp', array(
				'depnr'=>$id,
				'paypr'=>++$item_index,
				'sgtxt'=>$p->sgtxt,
				'pramt'=>$p->pramt,
				'perct'=>$p->perct,
				'duedt'=>$p->duedt,
				'ctyp1'=>$p->ctyp1
			));
	    	}
		}

// Save GL Posting	
        $ids = $id;	
		$id = $this->input->post('id');
		$query = null;
		if(!empty($id)){
			$this->db->limit(1);
			$this->db->where('invnr', $id);
			$query = $this->db->get('bkpf');
		}
		$date = date('Ymd');
		$formData = array(
		    'gjahr' => substr($date,0,4),
		    'bldat' => $this->input->post('bldat'),
			'invnr' => $ids,
			'txz01' => $this->input->post('txz01'),
			'auart' => 'AR',
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
			$id = $this->code_model->generate('AR', 
			$this->input->post('bldat'));
			$this->db->set('belnr', $id);
			$this->db->set('erdat', 'NOW()', false);
		    $this->db->set('ernam', 'test');
			$this->db->insert('bkpf', $formData);
			
			//$id = $this->db->insert_id();
		}
		
		// ลบ gl_item ภายใต้ id ทั้งหมด
		
		$this->db->where('belnr', $id);
		$this->db->delete('bven');

		// เตรียมข้อมูล pay item
		$bcus = $this->input->post('belpr');//$this->input->post('vbelp');
		$gl_item_array = json_decode($bcus);
		if(!empty($bcus) && !empty($gl_item_array)){

			$item_index = 0;
			// loop เพื่อ insert pay_item ที่ส่งมาใหม่
			foreach($gl_item_array AS $p){
				if(!empty($p->saknr)){
				$this->db->insert('bven', array(
					'belnr'=>$id,
					'belpr'=>++$item_index,
					'gjahr' => substr($date,0,4),
					'saknr'=>$p->saknr,
					'debit'=>$p->debit,
					'credi'=>$p->credi,
					'txz01'=>$p->txz01
				));
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
		/*$qtnr = $this->input->get('qtnr');
		if(!empty($qtnr)){
			//$this->db->set_dbprefix('v_');
		    $this->db->where('vbeln', $qtnr);
			$this->db->where('payty', '1');

		    $query = $this->db->get('payp');
		}else{*/
            $this->db->set_dbprefix('v_');
	        $dp_id = $this->input->get('depnr');
		    $this->db->where('depnr', $dp_id);
        //$totalCount = $this->db->count_all_results('vbbp');
		
		//createQuery($this);
	       $query = $this->db->get('ebdp');
      //  echo $this->db->last_query();
		//}
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
		   $netpr = $this->input->get('netpr');  //Net amt
		   $lifnr = $this->input->get('lifnr');  //Vendor Code
		   $rate = $this->input->get('rate');  //Currency Rate
		   $ptype = $this->input->get('ptype');  //Pay Type
		   $dtype = $this->input->get('dtype');  //Doc Type
		   
		   $net = $netpr;
		   
           $i=0;$n=0;$vamt=0;$debit=0;$credit=0;
		   $result = array();
		   
		// record แรก
		if($ptype=='01'){
			$query = $this->db->get_where('lfa1', array(
				'lifnr'=>$lifnr));
			if($query->num_rows()>0){
				$q_data = $query->first_row('array');
				$qgl = $this->db->get_where('glno', array(
				'saknr'=>$q_data['saknr']));
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
		}else{
			$query = $this->db->get_where('ptyp', array(
			'ptype'=>$ptype));
			if($query->num_rows()>0){
				$q_data = $query->first_row('array');
				$qgl = $this->db->get_where('glno', array(
				'saknr'=>$q_data['saknr']));
				$q_glno = $qgl->first_row('array');
				$result[$i] = array(
				    'belpr'=>$i + 1,
					'saknr'=>$q_data['saknr'],
					'sgtxt'=>$q_glno['sgtxt'],
					'debit'=>$net,
					'credi'=>0
				);
				$i++;
			}
			$debit=$net;
		}
// record ที่สอง
        if($netpr>0){
        if($dtype=='01'){
           $doct = '211000';
        }
        
		$qdoc = $this->db->get_where('glno', array(
				'saknr'=>$doct));
		$q_doc = $qdoc->first_row('array');
		$result[$i] = array(
		    'belpr'=>$i + 1,
			'saknr'=>$doct,
			'sgtxt'=>$q_doc['sgtxt'],
			'debit'=>0,
			'credi'=>$netpr
		);
		$i++;
		$credit=$netpr;
		}
// record ที่สาม
/*
		if($vvat>'1'){ 
		//	$net_tax = floatval($net) * 0.07;}
		$glvat = '215010';
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
        if($vwht>'1'){ 
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