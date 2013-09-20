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
			
			$result['adr01'] .= $result['distx'].' '.$result['pstlz'].
			                         PHP_EOL.'Tel: '.$result['telf1'].PHP_EOL.'Fax: '.
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

			//$statu1 = $_this->input->get('statu');
			//$statu2 = $_this->input->get('statu2');
			//if(!empty($statu1) && empty($statu2)){
			//  $_this->db->where('statu', $statu1);
			//}
			//elseif(!empty($statu1) && !empty($statu2)){
			//  $_this->db->where('statu >=', $statu1);
			//  $_this->db->where('statu <=', $statu2);
			//}
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
		
		//$exchg = $this->input->post('exchg');
		//$curr = 'THB';
		//if($exchg <> 0){
		//	$curr = 'USD';
		//}

		$formData = array(
			//'recnr' => $this->input->post('recnr'),
			'bldat' => $this->input->post('bldat'),
			//'statu' => $this->input->post('statu'),
			//'txz01' => $this->input->post('txz01'),
			//'refnr' => $this->input->post('refnr'),
			
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
			$id = $this->code_model->generate('RC', 
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
		if(!empty($paym) && !empty($pm_item_array)){

			$item_index = 0;
			// loop เพื่อ insert pay_item ที่ส่งมาใหม่
			foreach($pm_item_array AS $p){
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
        
	    $rc_id = $this->input->get('recnr');
		$this->db->where('recnr', $rc_id);

	    $query = $this->db->get('vbbp');
       // echo $this->db->last_query();
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
	

}