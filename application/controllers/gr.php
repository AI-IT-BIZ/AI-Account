<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gr extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->model('code_model','',TRUE);
	}

	function index(){
		$this->phxview->RenderView('gr');
		$this->phxview->RenderLayout('default');
	}

	function load(){
		$this->db->set_dbprefix('v_');
		$tbName = 'mkpf';
		
		$id = $this->input->post('id');
		
		
		$this->db->where('mbeln', $id);
		$query = $this->db->get('mkpf');
		 
		if($query->num_rows()>0){
			
			$result_data = $query->first_row('array');
			$result_data['id'] = $result_data['mbeln'];

			$result_data['adr01'] .= $result_data['distx'].' '.$result_data['pstlz'].
			                         PHP_EOL.'Tel: '.$result_data['telf1'].PHP_EOL.'Fax: '.
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
		$tbName = 'mkpf';

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
			
            $mbeln1 = $_this->input->get('mbeln');
			$mbeln2 = $_this->input->get('mbeln2');
			if(!empty($mbeln1) && empty($mbeln2)){
			  $_this->db->where('mbeln', $mbeln1);
			}
			elseif(!empty($mbeln1) && !empty($mbeln2)){
			  $_this->db->where('mbeln >=', $mbeln1);
			  $_this->db->where('mbeln <=', $mbeln2);
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
		$query = $this->db->get($tbName);
		
		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>2//$totalCount
		));
	}

	function save(){
		$id = $this->input->post('id');
		$query = null;
		if(!empty($id)){
			$this->db->limit(1);
			$this->db->where('mbeln', $id);
			$query = $this->db->get('mkpf');
		}
		$netwr = str_replace(",","",$this->input->post('netwr'));
		$formData = array(
			'statu' => '01',
			'bldat' => $this->input->post('bldat'),
			'lifnr' => $this->input->post('lifnr'),
			'lfdat' => $this->input->post('lfdat'),
			'taxnr' => $this->input->post('taxnr'),
			'refnr' => $this->input->post('refnr'),
			'ebeln' => $this->input->post('ebeln'),  //PO no.
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
			$this->db->where('mbeln', $id);
			$this->db->set('updat', 'NOW()', false);
			$this->db->set('upnam', 'somwang');
			$this->db->update('mkpf', $formData);
		}else{
			
			$id = $this->code_model->generate('GR', $this->input->post('bldat'));
		//echo $id; exit;
			$this->db->set('mbeln', $id);
			$this->db->set('erdat', 'NOW()', false);
			$this->db->set('ernam', 'somwang');
			$this->db->insert('mkpf', $formData);
		}
		// ลบ pr_item ภายใต้ id ทั้งหมด
		$this->db->where('mbeln', $id);
		$this->db->delete('mseg');

		// เตรียมข้อมูล  qt item
		$mseg = $this->input->post('mseg');//$this->input->post('vbelp');
		$gr_item_array = json_decode($mseg);
		if(!empty($mseg) && !empty($gr_item_array)){
			// loop เพื่อ insert gr_item ที่ส่งมาใหม่
			$item_index = 0;
			foreach($gr_item_array AS $p){
				$this->db->insert('mseg', array(
					'mbeln'=>$id,
					'mbelp'=>++$item_index,//vbelp,
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
		$mbeln = $this->input->post('mbeln'); 
		//echo $ebeln; exit;
		$this->db->where('mbeln', $mbeln);
		$query = $this->db->delete('mkpf');
		
		$this->db->where('mbeln', $mbeln);
		$query = $this->db->delete('mseg');
		echo json_encode(array(
			'success'=>true,
			'data'=>$mbeln
		));
	}

	///////////////////////////////////////////////
	// PR ITEM
	///////////////////////////////////////////////


	function loads_gr_item(){
		$grdebeln = $this->input->get('grdebeln');
		
		$gr_id = $this->input->get('mbeln');
		if(!empty($grdebeln)){
			$this->db->set_dbprefix('v_');
			$this->db->where('ebeln', $grdebeln);
			$query = $this->db->get('ekpo');
			
		}else{
			$this->db->set_dbprefix('v_');
			$this->db->where('mbeln', $gr_id);
			$query = $this->db->get('mseg');
		
		}
		
		//echo $sql;//exit;
		
		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$query->num_rows()
		));
	}
	
	
	public function loads_combo($tb,$pk,$like){
    	
		$tbName = $tb;
		$tbPK = $pk;
		$tbLike = $like;

		$query = $this->input->post('query');

		$totalCount = $this->db->count_all_results($tbName);


		if(!empty($query) && $query!=''){
			$this->db->or_like($tbLike, $query);
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