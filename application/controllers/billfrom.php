<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Billfrom extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('code_model','',TRUE);
		$this->load->model('email_service','',TRUE);
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
		$this->db->where('bilnr', $id);
		$query = $this->db->get('ebkk');
		
		if($query->num_rows()>0){
			$result = $query->first_row('array');
			$result['id'] = $result['bilnr'];
			
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
		$tbName = 'ebkk';
		
		// Start for report
		function createQuery($_this){
			$query = $_this->input->get('query');
			if(!empty($query)){
				$_this->db->where("(`bilnr` LIKE '%$query%'
				OR `kunnr` LIKE '%$query%'
				OR `name1` LIKE '%$query%'
				OR `jobnr` LIKE '%$query%'
				OR `sname` LIKE '%$query%')", NULL, FALSE);
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

	function save(){
		$id = $this->input->post('id');
		$query = null;
		
		$status_changed = false;
		$inserted_id = false;
		if(!empty($id)){
			$this->db->limit(1);
			$this->db->where('bilnr', $id);
			$query = $this->db->get('ebkk');
			
			// ##### CHECK PERMISSIONS
			$row = $query->first_row('array');
			// status has change
			$status_changed = $row['statu']!=$this->input->post('statu');
			if($status_changed&&$row['statu']!=02&&$row['statu']!=02&&$row['statu']!=03){
				if(XUMS::CAN_DISPLAY('BF') && XUMS::CAN_APPROVE('BF')){
					$limit = XUMS::LIMIT('BF');
					if($limit<$row['netwr']){
						$emsg = 'You do not have permission to change billing status over than '.number_format($limit);
						echo json_encode(array(
							'success'=>false,
							'errors'=>array( 'statu' => $emsg ),
							'message'=>$emsg
						));
						return;
					}
				}else{
					$emsg = 'You do not have permission to change billing status.';
					echo json_encode(array(
						'success'=>false,
						'errors'=>array( 'statu' => $emsg ),
						'message'=>$emsg
					));
					return;
				}
			}else{
				if($row['statu']=='02'||$row['statu']=='03'){
					$emsg = 'The billing that already approved or rejected cannot be update.';
					echo json_encode(array(
						'success'=>false,
						'message'=>$emsg
					));
					return;
				}
			}
			// ##### END CHECK PERMISSIONS
		}

        $sdat = explode('-',$this->input->post('bldat'));
		$edat = explode('-',$this->input->post('duedt'));
		$stdat = $sdat[0].$sdat[1].$sdat[2];
		$endat = $edat[0].$edat[1].$edat[2];
		//echo $stdat.'aaa'.$endat;
		if($stdat>$endat){
					$emsg = 'The Due date must be more than Document date.';
					echo json_encode(array(
						'success'=>false,
						'message'=>$emsg
					));
					return;
				}
		
		
		// start transaction
		$this->db->trans_start();
		// เตรียมข้อมูล receipt item
		$ebkp = $this->input->post('ebkp');
		$bt_item_array = json_decode($ebkp);
		$ctype='';
		if(!empty($bt_item_array)){
			//$result = $bt_item_array->first_row('array');
			//print_r($bt_item_array);
		    $ctype = $bt_item_array[0]->ctyp1;
		}
		
		$formData = array(
			//'recnr' => $this->input->post('recnr'),
			'bldat' => $this->input->post('bldat'),
			'lifnr' => $this->input->post('lifnr'),
			'netwr' => $this->input->post('netwr'),
			'beamt' => $this->input->post('beamt'),
			'dismt' => $this->input->post('dismt'),
			'ctype' => $ctype,
			'statu' => $this->input->post('statu'),
			'duedt' => $this->input->post('duedt'),
			'dispc' => $this->input->post('dispc')
		);
		
		// start transaction
		$this->db->trans_start();  
		
		$current_username = XUMS::USERNAME();
		
		if (!empty($query) && $query->num_rows() > 0){
			$this->db->where('bilnr', $id);
			//$this->db->set('updat', 'NOW()', false);
			db_helper_set_now($this, 'updat');
			$this->db->set('upnam', $current_username);
			$this->db->update('ebkk', $formData);
		}else{
			$id = $this->code_model->generate('BF', 
			$this->input->post('bldat'));
			$this->db->set('bilnr', $id);
			//$this->db->set('erdat', 'NOW()', false);
			db_helper_set_now($this, 'erdat');
		    $this->db->set('ernam', $current_username);
			$this->db->insert('ebkk', $formData);
			//$id = $this->db->insert_id();
			
			$inserted_id = $id;
		}

		// ลบ receipt item ภายใต้ id ทั้งหมด
		$this->db->where('bilnr', $id);
		$this->db->delete('ebkp');

		// เตรียมข้อมูล receipt item
		//$ebkp = $this->input->post('ebkp');
		//$bt_item_array = json_decode($ebkp);
		//echo $this->db->last_query();
		
		if(!empty($ebkp) && !empty($bt_item_array)){
			// loop เพื่อ insert receipt item ที่ส่งมาใหม่
			$item_index = 0;
		foreach($bt_item_array AS $p){
			$this->db->insert('ebkp', array(
				'bilnr'=>$id,
				'vbelp'=>++$item_index,
				'invnr'=>$p->invnr,
				'invdt'=>$p->invdt,
				//'texts'=>$p->texts,
				'itamt'=>$p->itamt,
				//'reman'=>$p->reman,
				//'payrc'=>$p->payrc,
				'refnr'=>$p->refnr,
				'ctyp1'=>$p->ctyp1
			));
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
				$total_amount = $this->input->post('netwr');
				// send notification email
				if(!empty($inserted_id)){
					$q_row = $this->db->get_where('ebkk', array('bilnr'=>$inserted_id));
					$row = $q_row->first_row();
					$this->email_service->sendmail_create(
						'BF', 'Billing Receipt',
						$inserted_id, $total_amount,
						$row->ernam
					);
				}else if(!empty($post_id)){
					if($status_changed){
						$q_row = $this->db->get_where('ebkk', array('bilnr'=>$post_id));
						$row = $q_row->first_row();
						$this->email_service->sendmail_change_status(
							'BF', 'Billing Receipt',
							$post_id, $total_amount, $row->statu,
							$row->ernam
						);
					}
				}
			}catch(exception $e){}
		}
	}
    
	function remove(){
		$id = $this->input->post('id');
		$this->db->where('bilnr', $id);
		$query = $this->db->delete('ebkk');
		echo json_encode(array(
			'success'=>true,
			'data'=>$id
		));
	}
	
	///////////////////////////////////////////////
	// Billto ITEM
	///////////////////////////////////////////////
	function loads_bt_item(){
        $this->db->set_dbprefix('v_');
	    $bt_id = $this->input->get('bilnr');
		$this->db->where('bilnr', $bt_id);
        //$totalCount = $this->db->count_all_results('vbbp');
		
		//createQuery($this);
	    $query = $this->db->get('ebkp');
      //  echo $this->db->last_query();
		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$query->num_rows()
		));
	}

}