<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('code_model2','',TRUE);
		$this->load->model('email_service','',TRUE);
	}

	function index(){
		$this->load->view('customer');
	}

	function load(){
		$this->db->set_dbprefix('v_');
		$id = $this->input->post('id');
		$this->db->limit(1);
		$this->db->where('kunnr', $id);
		$query = $this->db->get('kna1');
		if($query->num_rows()>0){
			$result_data = $query->first_row('array');
			$result_data['id'] = $result_data['kunnr'];
			echo json_encode(array(
				'success'=>true,
				'data'=>$result_data
			));
		}else
			echo json_encode(array(
				'success'=>false
			));
	}

	function load2(){
		$id = $this->input->post('id');
		$this->db->limit(1);
		$this->db->where('kunnr', $id);
		$query = $this->db->get('kna1');
		if($query->num_rows()>0){
			$result_data = $query->first_row('array');

			$result_data['adr01'] .= ' '.$result_data['distx'].' '.$result_data['pstlz'].
			                         PHP_EOL.'Tel: '.$result_data['telf1'].' '.'Fax: '.$result_data['telfx'].
									 PHP_EOL.'Email: '.$result_data['email'];

			$result_data['adr02'] .= ' '.$result_data['dis02'].' '.$result_data['pst02'].
			                         PHP_EOL.'Tel: '.$result_data['tel02'].' '.'Fax: '.$result_data['telf2'].
									 PHP_EOL.'Email: '.$result_data['emai2'];
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
		$tbName = 'kna1';

		function createQuery($_this){

			$query = $_this->input->get('query');
			if(!empty($query)){
				$_this->db->where("(`kunnr` LIKE '%$query%'
				OR `name1` LIKE '%$query%')", NULL, FALSE);
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

		//echo $this->db->last_query();
		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$totalCount
		));
	}

	public function loads_acombo(){
		//$tbName = 'apov';
		//$tbPK = 'statu';

		$sql="SELECT *
			FROM tbl_apov
			WHERE apgrp = '1'";
		$query = $this->db->query($sql);

		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$query->num_rows()
		));
	}

	function save(){
		//$kunnr = $this->input->post('kunnr');
		$id = $this->input->post('id');

		$query = null;
		$status_changed = false;
		$inserted_id = false;
		if(!empty($id)){
			$this->db->limit(1);
			$this->db->where('kunnr', $id);
			$query = $this->db->get('kna1');

			// ##### CHECK PERMISSIONS
			$row = $query->first_row('array');
			// status has change
			$status_changed = $row['statu']!=$this->input->post('statu');
			if($status_changed&&$row['statu']!=02&&$row['statu']!=02){
				if(XUMS::CAN_DISPLAY('CS') && XUMS::CAN_APPROVE('CS')){
					$limit = XUMS::LIMIT('CS');
					/*if($limit<$row['netwr']){
						$emsg = 'You do not have permission to change Vendor status over than '.number_format($limit);
						echo json_encode(array(
							'success'=>false,
							'errors'=>array( 'statu' => $emsg ),
							'message'=>$emsg
						));
						return;
					}*/
				}else{
					$emsg = 'You do not have permission to change Customer status.';
					echo json_encode(array(
						'success'=>false,
						'errors'=>array( 'statu' => $emsg ),
						'message'=>$emsg
					));
					return;
				}
			}else{
				if($row['statu']=='02'||$row['statu']=='03'){
					$emsg = 'The Customer that already approved or rejected cannot be update.';
					echo json_encode(array(
						'success'=>false,
						'message'=>$emsg
					));
					return;
				}
			}
			// ##### END CHECK PERMISSIONS
		}else{
			$name1=$this->input->post('name1');
	    	if(!empty($name1)){
			$this->db->where('name1', $name1);
			$q_txt = $this->db->get('kna1');
			if($q_txt->num_rows() > 0){
					$emsg = 'The Customer Name already created.';
					echo json_encode(array(
						'success'=>false,
						'message'=>$emsg
					));
					return;
				}
			}
		}

		/*$name1='';
        $name = explode(' ',$this->input->post('name1'));
	    for($i=0;$i<count($name);$i++){
	    	$name1 = $name1.$name[$i];
	    }*/

        if($this->input->post('apamt')<$this->input->post('endin')){
					$emsg = 'The Limit Credit must be more than Maximum Amt.';
					echo json_encode(array(
						'success'=>false,
						'message'=>$emsg
					));
					return;
				}

		if($this->input->post('endin')<$this->input->post('begin')){
					$emsg = 'The Maximum Amt must be more than Minimum Amt.';
					echo json_encode(array(
						'success'=>false,
						'message'=>$emsg
					));
					return;
				}

		$vat = $this->input->post('vat01');
        if($this->input->post('taxnr')=='03' || $this->input->post('taxnr')=='04'){
        	$vat = 0;
		}

		$formData = array(
			//'kunnr' => $this->input->post('kunnr'),
			'name1' => $this->input->post('name1'),
			'adr01' => $this->input->post('adr01'),
			'ktype' => $this->input->post('ktype'),
			'distx' => $this->input->post('distx'),
			'pstlz' => $this->input->post('pstlz'),
			'terms' => $this->input->post('terms'),
			'telf1' => $this->input->post('telf1'),
			'disct' => $this->input->post('disct'),
			'telfx' => $this->input->post('telfx'),
			'pleve' => $this->input->post('pleve'),
			'email' => $this->input->post('email'),
			'pson1' => $this->input->post('pson1'),
			'apamt' => $this->input->post('apamt'),
			'taxid' => $this->input->post('taxid'),
			'began' => $this->input->post('began'),
			'saknr' => $this->input->post('saknr'),
			'endin' => $this->input->post('endin'),
			'taxnr' => $this->input->post('taxnr'),
			'note1' => $this->input->post('note1'),
			'adr02' => $this->input->post('adr02'),
			'dis02' => $this->input->post('dis02'),
			'pst02' => $this->input->post('pst02'),
			'tel02' => $this->input->post('tel02'),
			'telf2' => $this->input->post('telf2'),
			'emai2' => $this->input->post('emai2'),
			'pson2' => $this->input->post('pson2'),
			'cunt1' => $this->input->post('cunt1'),
			'cunt2' => $this->input->post('cunt2'),
			'statu' => $this->input->post('statu'),
			'vat01' => $vat,
			'ptype' => $this->input->post('ptype')

		);

		$current_username = XUMS::USERNAME();

		if (!empty($query) && $query->num_rows() > 0){
			$this->db->where('kunnr', $id);
			$this->db->update('kna1', $formData);

		}else{
			$id = $this->code_model2->generate2('CS');
			$this->db->set('kunnr', $id);
			//$this->db->set('erdat', 'NOW()', false);
			db_helper_set_now($this, 'erdat');
			$this->db->set('ernam', $current_username);
			$this->db->insert('kna1', $formData);

			$inserted_id = $id;
		}

		echo json_encode(array(
			'success'=>true,
			'data'=>$_POST
		));

		try{
				$post_id = $this->input->post('id');
				$total_amount = $this->input->post('endin');
				// send notification email
				if(!empty($inserted_id)){
					$q_row = $this->db->get_where('kna1', array('kunnr'=>$inserted_id));
					$row = $q_row->first_row();
					$this->email_service->sendmail_create(
						'CS', 'Customer master',
						$inserted_id, $total_amount,
						$row->ernam
					);
				}else if(!empty($post_id)){
					if($status_changed){
						$q_row = $this->db->get_where('kna1', array('kunnr'=>$post_id));
						$row = $q_row->first_row();
						$this->email_service->sendmail_change_status(
							'CS', 'Customer master',
							$post_id, $total_amount, $row->statu,
							$row->ernam
						);
					}
				}
			}catch(exception $e){}
	}

	function remove(){
		$kunnr = $this->input->post('kunnr');
		$this->db->where('kunnr', $kunnr);
		$query = $this->db->delete('kna1');
		echo json_encode(array(
			'success'=>true,
			'data'=>$kunnr
		));
	}

    public function loads_tcombo(){
		//$tbName = 'ptyp';
		//$tbPK = 'ptype';

		$sql="SELECT *
			FROM tbl_ptyp
			WHERE ptype <> '02'";
		$query = $this->db->query($sql);

		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$query->num_rows()
		));
	}

	public function loads_combo($tbName,$tbPK,$tbTxt){
		/*$tbName = 'mtyp';
		$tbPK = 'mtart';*/

		$tbName = $tbName;
		$tbPK = $tbPK;
		$tbTxt = $tbTxt;

		$query = $this->input->post('query');

		$totalCount = $this->db->count_all_results($tbName);


		if(!empty($query) && $query!=''){
			$this->db->or_like($tbTxt, $query);
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