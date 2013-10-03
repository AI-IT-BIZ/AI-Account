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
			$result['adr11'] = $result['adr01'];

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
			
			$bldat1 = $_this->input->get('bldat1');
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
			
			'duedt' => $this->input->post('duedt')
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
				'refnr'=>$p->refnr
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
        //$this->db->set_dbprefix('v_');
        
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
	
	
	function loads_gl_item(){
        $this->db->set_dbprefix('v_');
		$gl_id = $this->input->get('belnr');
		$this->db->where('belnr', $gl_id);

		$query = $this->db->get('bsid');
		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$query->num_rows()
		));
	}
	public function loads_combo($tb,$pk,$like){
    	/*
		$tbName = 'ktyp';
		$tbPK = 'ktype';
		$tbLike = 'custx';
		*/
		
		$tbName = $tb;
		$tbPK = $pk;
		$tbLike = $like;

		$query = $this->input->post('query');

		$totalCount = $this->db->count_all_results($tbName);


		if(!empty($query) && $query!=''){
			$this->db->or_like($tbLike, $query);
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

}