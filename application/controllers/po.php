<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Po extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->model('code_model','',TRUE);
	}

	function index(){
		$this->phxview->RenderView('po');
		$this->phxview->RenderLayout('default');
	}
	
	function load(){
		$this->db->set_dbprefix('v_');
		$tbName = 'ekko';
		$id = $this->input->post('id');
		$this->db->where('ebeln', $id);
		$query = $this->db->get('ekko');
		
		if($query->num_rows()>0){
			
			$result_data = $query->first_row('array');
			$result_data['id'] = $result_data['ebeln'];

			$result_data['adr01'] .= ' '.$result_data['distx'].' '.$result_data['pstlz'].
			                         PHP_EOL.'Tel: '.$result_data['telf1'].' '.'Fax: '.
			                         $result_data['telfx'].
									 PHP_EOL.'Email: '.$result_data['email'];

			// unset calculated value
			unset($result_data['beamt']);
			unset($result_data['netwr']);
			
			echo json_encode(array(
				'success'=>true,
				'data'=>$result_data
			));
		}else
			echo json_encode(array(
				'success'=>false
			));
	}

	function loads(){
		$this->db->set_dbprefix('v_');
		$tbName = 'ekko';

		$limit = $this->input->get('limit');
		$start = $this->input->get('start');
		if(isset($limit) && isset($start)) $this->db->limit($limit, $start);

		
		// Start for report
		function createQuery($_this){
			
			$query = $_this->input->get('query');
			if(!empty($query)){
				$_this->db->where("(`ebeln` LIKE '%$query%'
				OR `lifnr` LIKE '%$query%'
				OR `name1` LIKE '%$query%'
				OR `purnr` LIKE '%$query%')", NULL, FALSE);
			}
			
			$bldat1 = $_this->input->get('bldat1');
			$bldat2 = $_this->input->get('bldat2');
			if(!empty($bldat1) && empty($bldat2)){
			  $_this->db->where('bldat', $bldat1);
			}
			elseif(!empty($bldat1) && !empty($bldat2)){
			  $_this->db->where('bldat >=', $bldat1);
			  $_this->db->where('bldat <=', $bldat2);
			}

            $ebeln1 = $_this->input->get('ebeln');
			$ebeln2 = $_this->input->get('ebeln2');
			if(!empty($ebeln1) && empty($ebeln2)){
			  $_this->db->where('ebeln', $ebeln1);
			}
			elseif(!empty($ebeln1) && !empty($ebeln2)){
			  $_this->db->where('ebeln >=', $ebeln1);
			  $_this->db->where('ebeln <=', $ebeln2);
			}
			
            $purnr1 = $_this->input->get('purnr');
			$purnr2 = $_this->input->get('purnr2');
			if(!empty($purnr1) && empty($purnr2)){
			  $_this->db->where('purnr', $purnr1);
			}
			elseif(!empty($purnr1) && !empty($purnr2)){
			  $_this->db->where('purnr >=', $purnr1);
			  $_this->db->where('purnr <=', $purnr2);
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
		if(!empty($id)){
			$this->db->limit(1);
			$this->db->where('ebeln', $id);
			$query = $this->db->get('ekko');
		}
		$formData = array(
			'bldat' => $this->input->post('bldat'),
			'lifnr' => $this->input->post('lifnr'),
			'lfdat' => $this->input->post('lfdat'),
			'taxnr' => $this->input->post('taxnr'),
			'refnr' => $this->input->post('refnr'),
			'purnr' => $this->input->post('purnr'),
			'ptype' => $this->input->post('ptype'),
			'terms' => $this->input->post('terms'),
			'beamt' => $this->input->post('beamt'),
			'dismt' => $this->input->post('dismt'),
			'taxpr' => $this->input->post('taxpr'),
			'sgtxt' => $this->input->post('sgtxt'),
			'statu' => $this->input->post('statu'),
			'netwr' => $this->input->post('netwr'),
			'ptype' => $this->input->post('ptype'),
			'exchg' => $this->input->post('exchg'),
			'statu' => $this->input->post('statu'),
			'ctype' => $this->input->post('ctype')
		);

		// start transaction
		$this->db->trans_start();

		if (!empty($query) && $query->num_rows() > 0){
			$this->db->where('ebeln', $id);
			$this->db->set('updat', 'NOW()', false);
			$this->db->set('upnam', 'test');
			$this->db->update('ekko', $formData);
		}else{
			
			$id = $this->code_model->generate('PO', $this->input->post('bldat'));
			$this->db->set('ebeln', $id);
			$this->db->set('erdat', 'NOW()', false);
			$this->db->set('ernam', 'test');
			$this->db->insert('ekko', $formData);
		}
		// ลบ pr_item ภายใต้ id ทั้งหมด
		$this->db->where('ebeln', $id);
		$this->db->delete('ekpo');

		// เตรียมข้อมูล  qt item
		$ekpo = $this->input->post('ekpo');//$this->input->post('vbelp');
		$qt_item_array = json_decode($ekpo);
		if(!empty($ekpo) && !empty($qt_item_array)){
			// loop เพื่อ insert pr_item ที่ส่งมาใหม่
			$item_index = 0;
			foreach($qt_item_array AS $p){
				$itamt = $p->menge * $p->unitp;
				$itamt = $itamt - $p->disit;
				$this->db->insert('ekpo', array(
					'ebeln'=>$id,
					'ebelp'=>++$item_index,//vbelp,
					'matnr'=>$p->matnr,
					'menge'=>$p->menge,
					'meins'=>$p->meins,
					'disit'=>$p->disit,
					'unitp'=>$p->unitp,
					'itamt'=>$itamt,
					'chk01'=>$p->chk01,
					'ctype'=>$p->ctype
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
		$ebeln = $this->input->post('ebeln'); 
		//echo $ebeln; exit;
		$this->db->where('ebeln', $ebeln);
		$query = $this->db->delete('ekko');
		
		$this->db->where('ebeln', $ebeln);
		$query = $this->db->delete('ekpo');
		echo json_encode(array(
			'success'=>true,
			'data'=>$ebeln
		));
	}

	///////////////////////////////////////////////
	// PR ITEM
	///////////////////////////////////////////////


	function loads_po_item(){
		$grdpurnr = $this->input->get('grdpurnr');
		
		$po_id = $this->input->get('ebeln');
		if(!empty($grdpurnr)){
			$this->db->set_dbprefix('v_');
			$this->db->where('purnr', $grdpurnr);
			$query = $this->db->get('ebpo');
		}else{
			
			$this->db->set_dbprefix('v_');
			$this->db->where('ebeln', $po_id);
			$query = $this->db->get('ekpo');
		}
		
		//echo $sql;//exit;
		
		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$query->num_rows()
		));
	}
	
}