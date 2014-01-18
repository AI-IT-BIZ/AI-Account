<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gr extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->model('code_model','',TRUE);
		$this->load->model('email_service','',TRUE);
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
		$tbName = 'mkpf';

		$limit = $this->input->get('limit');
		$start = $this->input->get('start');
		if(isset($limit) && isset($start)) $this->db->limit($limit, $start);

		
		// Start for report
		function createQuery($_this){
			
			$query = $_this->input->get('query');
			if(!empty($query)){
				$_this->db->where("(mbeln LIKE '%$query%'
				OR lifnr LIKE '%$query%'
				OR name1 LIKE '%$query%'
				OR ebeln LIKE '%$query%')", NULL, FALSE);
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
			'totalCount'=>2//$totalCount
		));
	}

	function save(){
		$id = $this->input->post('id');
		$query = null;
		
		$status_changed = false;
		$inserted_id = false;
		if(!empty($id)){
			$this->db->limit(1);
			$this->db->where('mbeln', $id);
			$query = $this->db->get('mkpf');
			
			// ##### CHECK PERMISSIONS
			$row = $query->first_row('array');
			// status has change
			$status_changed = $row['statu']!=$this->input->post('statu');
			if($status_changed&&$row['statu']!=02&&$row['statu']!=02&&$row['statu']!=03){
				if(XUMS::CAN_DISPLAY('GR') && XUMS::CAN_APPROVE('GR')){
					$limit = XUMS::LIMIT('GR');
					if($limit<$row['netwr']){
						$emsg = 'You do not have permission to change GR status over than '.number_format($limit);
						echo json_encode(array(
							'success'=>false,
							'errors'=>array( 'statu' => $emsg ),
							'message'=>$emsg
						));
						return;
					}
				}else{
					$emsg = 'You do not have permission to change GR status.';
					echo json_encode(array(
						'success'=>false,
						'errors'=>array( 'statu' => $emsg ),
						'message'=>$emsg
					));
					return;
				}
			}else{
				if($row['statu']=='02'||$row['statu']=='03'){
					$emsg = 'The GR that already approved or rejected cannot be update.';
					echo json_encode(array(
						'success'=>false,
						'message'=>$emsg
					));
					return;
				}
			}
			// ##### END CHECK PERMISSIONS
			$this->db->set_dbprefix('v_');
			$this->db->where('ebeln', $id);
			$this->db->where('matkl', '08');

			$q_txt = $this->db->get('ekpo');
			if($q_txt->num_rows() > 0){
				if($this->input->post('loekz')==''){
        	        $emsg = 'The PO is not created deposit payment yet.';
					echo json_encode(array(
						'success'=>false,
						'message'=>$emsg
					));
					return;
                }
			}
		}

        if($this->input->post('loekz')=='3'){
        	$emsg = 'The po already created gr doc.';
					echo json_encode(array(
						'success'=>false,
						'message'=>$emsg
					));
					return;
        }

		$formData = array(
			'bldat' => $this->input->post('bldat'),
			'lifnr' => $this->input->post('lifnr'),
			'lfdat' => $this->input->post('lfdat'),
			'taxnr' => $this->input->post('taxnr'),
			'refnr' => $this->input->post('refnr'),
			'ebeln' => $this->input->post('ebeln'),  //PO no.
			'ptype' => $this->input->post('ptype'),
			'terms' => intval($this->input->post('terms')),
			'dismt' => floatval($this->input->post('dismt')),
			'taxpr' => floatval($this->input->post('taxpr')),
			'sgtxt' => $this->input->post('sgtxt'),
			'beamt' => floatval($this->input->post('beamt')),
			'vat01' => floatval($this->input->post('vat01')),
			'netwr' => floatval($this->input->post('netwr')),
			'ptype' => $this->input->post('ptype'),
			'exchg' => floatval($this->input->post('exchg')),
			'statu' => $this->input->post('statu'),
			'ctype' => $this->input->post('ctype'),
			'deamt' => floatval($this->input->post('deamt'))
		);

		// start transaction
		$this->db->trans_start();
		
		$current_username = XUMS::USERNAME();
        $this->db->set_dbprefix('tbl_');
		if (!empty($query) && $query->num_rows() > 0){
			$this->db->where('mbeln', $id);
			//$this->db->set('updat', 'NOW()', false);
			db_helper_set_now($this, 'updat');
			$this->db->set('upnam', $current_username);
			$this->db->update('mkpf', $formData);
		}else{
			
			$id = $this->code_model->generate('GR', $this->input->post('bldat'));
		//echo $id; exit;
			$this->db->set('mbeln', $id);
			//$this->db->set('erdat', 'NOW()', false);
			db_helper_set_now($this, 'erdat');
			$this->db->set('ernam', $current_username);
			$this->db->insert('mkpf', $formData);
			
			$inserted_id = $id;
			
			$this->db->where('ebeln', $this->input->post('ebeln'));
			$this->db->set('loekz', '3');
			$this->db->update('ekko');
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
					'disit'=>$p->disit,
					'unitp'=>$p->unitp,
					'itamt'=>$p->itamt,
					'chk01'=>$p->chk01,
					'ctype'=>$p->ctype,
					'serno'=>$p->serno
				));
				
				if($this->input->post('statu')=='02'){
				$this->db->where('matnr', $p->matnr);
			    $this->db->set('ebeln', $id);
				$this->db->set('bldat', $this->input->post('bldat'));
				$this->db->set('serno', $p->serno);
				$this->db->set('costv', $p->itamt);
			    $this->db->update('fara');
				}
			}
		}
	
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
					$q_row = $this->db->get_where('mkpf', array('mbeln'=>$inserted_id));
					$row = $q_row->first_row();
					$this->email_service->sendmail_create(
						'GR', 'Goods Receipt',
						$inserted_id, $total_amount,
						$row->ernam
					);
				}else if(!empty($post_id)){
					if($status_changed){
						$q_row = $this->db->get_where('mkpf', array('mbeln'=>$post_id));
						$row = $q_row->first_row();
						$this->email_service->sendmail_change_status(
							'GR', 'Goods Receipt',
							$post_id, $total_amount, $row->statu,
							$row->ernam
						);
					}
				}
			}catch(exception $e){}
		}
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
		$grdebeln = $this->input->get('grdponr');
		
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
	
}