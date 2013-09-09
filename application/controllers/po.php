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
		
		 
		/*
		$sql="SELECT ebeln,t1.lifnr,name1,adr01,distx,pstlz,telf1,telfx,email,
			refnr,bldat,lfdat,t1.crdit,t1.taxnr,t1.sgtxt,t1.dismt,t1.taxpr,
			t1.purnr,t1.ptype
			FROM tbl_ekko AS t1 
				inner join tbl_lfa1 AS t2 ON t1.lifnr=t2.lifnr
				inner join tbl_apov AS t3 ON t1.statu=t3.statu
			WHERE ebeln='$id'";
			//echo $sql; exit;
		$query = $this->db->query($sql);
		
		 */
		
		$this->db->where('ebeln', $id);
		$query = $this->db->get('ekko');
		 
		if($query->num_rows()>0){
			/*	
			$result = $query->first_row('array');
			$result['bldat']=substr($result['bldat'], 0, 10);
			*/
			
			$result_data = $query->first_row('array');
			$result_data['id'] = $result_data['ebeln'];

			$result_data['adr01'] .= $result_data['distx'].' '.$result_data['pstlz'].
			                         PHP_EOL.'Tel: '.$result_data['telf1'].PHP_EOL.'Fax: '.
			                         $result_data['telfx'].
									 PHP_EOL.'Email: '.$result_data['email'];

			//$result['bldat']=substr($result['bldat'], 0, 10);

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
			  $_this->db->where('kunnr', $lifnr1);
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
		
		/*$sql="SELECT ebeln,
				bldat,
				t2.lifnr,
				name1,
				netwr,
				statx 
			FROM tbl_ekko AS t1 inner join tbl_lfa1 AS t2 ON t1.lifnr=t2.lifnr
			inner join tbl_apov AS t3 ON t1.statu=t3.statu";
		$query = $this->db->query($sql);*/
		
		//$totalCount = $this->db->count_all_results($tbName);
		createQuery($this); 
		$query = $this->db->get($tbName);
		
		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>2//$totalCount
		));
	}

	function save(){
		//$id = $this->input->post('ebeln');
		$id = $this->input->post('id');
		//echo $id; exit;
		$query = null;
		if(!empty($id)){
			$this->db->limit(1);
			$this->db->where('ebeln', $id);
			$query = $this->db->get('ekko');
		}
		$netwr = str_replace(",","",$this->input->post('netwr'));
		$formData = array(
			//'purnr' => $this->input->post('purnr'),
			'statu' => '01',
			'bldat' => $this->input->post('bldat'),
			'lifnr' => $this->input->post('lifnr'),
			'lfdat' => $this->input->post('lfdat'),
			'taxnr' => $this->input->post('taxnr'),
			'refnr' => $this->input->post('refnr'),
			'purnr' => $this->input->post('purnr'),
			'ptype' => $this->input->post('ptype'),
			'crdit' => $this->input->post('crdit'),
			'dismt' => $this->input->post('dismt'),
			'taxpr' => $this->input->post('taxpr'),
			'sgtxt' => $this->input->post('sgtxt'),
			'netwr' => $netwr,
			
			
		);

		// start transaction
		$this->db->trans_start();

		if (!empty($query) && $query->num_rows() > 0){
			$this->db->where('ebeln', $id);
			$this->db->set('updat', 'NOW()', false);
			$this->db->set('upnam', 'somwang');
			$this->db->update('ekko', $formData);
		}else{
			
			$id = $this->code_model->generate('PO', $this->input->post('bldat'));
		//echo $id; exit;
			$this->db->set('ebeln', $id);
			$this->db->set('erdat', 'NOW()', false);
			$this->db->set('ernam', 'somwang');
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
				$this->db->insert('ekpo', array(
					'ebeln'=>$id,
					'ebelp'=>++$item_index,//vbelp,
					'matnr'=>$p->matnr,
					'menge'=>$p->menge,
					'meins'=>$p->meins,
					'dismt'=>$p->dismt,
					'unitp'=>$p->unitp,
					'itamt'=>$p->itamt,
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
		//echo "111".$grdpurnr;//exit;

		/*
		$po_id = $this->input->get('ebeln');
		//echo "test na";
		$sql="SELECT *,t1.meins
			FROM tbl_ekpo AS t1 inner join tbl_mara AS t2 ON t1.matnr=t2.matnr
				inner join tbl_unit AS t3 ON t1.meins=t3.meins
			WHERE ebeln = '$po_id'";
		$query = $this->db->query($sql);
		*/
		
		$po_id = $this->input->get('ebeln');
		if(!empty($grdpurnr)){
			$sql="SELECT *,t1.meins
				FROM tbl_ebpo AS t1 inner join tbl_mara AS t2 ON t1.matnr=t2.matnr
					inner join tbl_unit AS t3 ON t1.meins=t3.meins
				WHERE purnr = '$grdpurnr'";
			$query = $this->db->query($sql);
		}else{
			$sql="SELECT *,t1.meins
				FROM tbl_ekpo AS t1 inner join tbl_mara AS t2 ON t1.matnr=t2.matnr
					inner join tbl_unit AS t3 ON t1.meins=t3.meins
				WHERE ebeln = '$po_id'";
			$query = $this->db->query($sql);
		}
		
		//echo $sql;//exit;
		
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