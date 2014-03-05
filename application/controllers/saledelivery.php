<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Saledelivery extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->model('code_model','',TRUE);
		$this->load->model('email_service','',TRUE);
	}
	/*
	function test_get_code(){
		echo $this->code_model->generate('PR', '2013-05-22');
	}*/

	function index(){
		//$this->load->view('project');
		//$this->phxview->RenderView('vbak');
		//$this->phxview->RenderLayout('default');
	}

	function load(){
		$this->db->set_dbprefix('v_');
		$id = $this->input->post('id');
		$key = $this->input->post('key');
		if($key==1){
			$this->db->where('statu', '02');
		}
		$this->db->limit(1);

		$this->db->where('delnr', $id);
		$query = $this->db->get('vbvk');

		if($query->num_rows()>0){
			$result_data = $query->first_row('array');
			$result_data['id'] = $result_data['delnr'];
            
			$result_data['adr01'] .= ' '.$result_data['distx'].' '.$result_data['pstlz'].
			                         PHP_EOL.'Tel: '.$result_data['telf1'].' '.'Fax: '.
			                         $result_data['telfx'].
									 PHP_EOL.'Email: '.$result_data['email'];
			$result_data['adr02'] .= $result_data['dis02'].' '.$result_data['pst02'].
			                         PHP_EOL.'Tel: '.$result_data['tel02'].' '.'Fax: '.
			                         $result_data['telf2'].
									 PHP_EOL.'Email: '.$result_data['emai2'];
			 
			$q_qt = $this->db->get_where('psal', array(
				'salnr'=>$result_data['salnr']
			));
			
			$r_qt = $q_qt->first_row('array');
			$result_data['emnam'] = $r_qt['emnam'];
			
			//$result_data['disco'] = $result_data['dispc'];
			
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
		$tbName = 'vbvk';

		// Start for report
		function createQuery($_this){
			$query = $_this->input->get('query');
			if(!empty($query)){
				$_this->db->where("(delnr LIKE '%$query%'
				OR kunnr LIKE '%$query%'
				OR name1 LIKE '%$query%'
				OR ordnr LIKE '%$query%'
				OR salnr LIKE '%$query%')", NULL, FALSE);
			}
			
	        $delnr1 = $_this->input->get('delnr');
			$delnr2 = $_this->input->get('delnr2');
			if(!empty($delnr1) && empty($delnr2)){
			  $_this->db->where('delnr', $delnr1);
			}
			elseif(!empty($delnr1) && !empty($delnr2)){
			  $_this->db->where('delnr >=', $delnr1);
			  $_this->db->where('delnr <=', $delnr2);
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

			$ordnr1 = $_this->input->get('ordnr');
			$ordnr2 = $_this->input->get('ordnr2');
			if(!empty($ordnr1) && empty($ordnr2)){
			  $_this->db->where('ordnr', $ordnr1);
			}
			elseif(!empty($ordnr1) && !empty($ordnr2)){
			  $_this->db->where('ordnr >=', $ordnr1);
			  $_this->db->where('ordnr <=', $ordnr2);
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

	function save(){
		$id = $this->input->post('id');
		$query = null;
		
		$status_changed = false;
		$inserted_id = false;
		if(!empty($id)){
			$this->db->limit(1);
			$this->db->where('delnr', $id);
			$query = $this->db->get('vbvk');
			
			// ##### CHECK PERMISSIONS
			$row = $query->first_row('array');
			// status has change
			$status_changed = $row['statu']!=$this->input->post('statu');
			if($status_changed&&$row['statu']!=03){
				if(XUMS::CAN_DISPLAY('DO') && XUMS::CAN_APPROVE('DO')){
					$limit = XUMS::LIMIT('DO');
					if($this->input->post('statu')==01){
						$emsg = 'Cannot Change status to waiting for approve';
						echo json_encode(array(
							'success'=>false,
							'errors'=>array( 'statu' => $emsg ),
							'message'=>$emsg
						));
						return;
					}
					else if($limit<$row['netwr']){
						$emsg = 'You do not have permission to change saleorder status over than '.number_format($limit);
						echo json_encode(array(
							'success'=>false,
							'errors'=>array( 'statu' => $emsg ),
							'message'=>$emsg
						));
						return;
					}
				}else{
					$emsg = 'You do not have permission to change saleorder status.';
					echo json_encode(array(
						'success'=>false,
						'errors'=>array( 'statu' => $emsg ),
						'message'=>$emsg
					));
					return;
				}
			}else{
				if($row['statu']=='02'||$row['statu']=='03'){
					$emsg = 'The delivery that already approved or rejected cannot be update.';
					echo json_encode(array(
						'success'=>false,
						'message'=>$emsg
					));
					return;
				}
			}
			// ##### END CHECK PERMISSIONS
			
			if($this->input->post('statu')=='03' && $this->input->post('reanr')==''){
				$emsg = 'Please enter reason for reject status';
					echo json_encode(array(
						'success'=>false,
						'message'=>$emsg
					));
					return;
			}
			
			/*$this->db->where('vbeln', $id);
			$this->db->where('payty', '1');
			$q_txt = $this->db->get('payp');
			if($q_txt->num_rows() > 0){
				if($this->input->post('loekz')==''){
        	        $emsg = 'The quotation is not created deposit receipt yet.';
					echo json_encode(array(
						'success'=>false,
						'message'=>$emsg
					));
					return;
                }
			}*/
			}/*else{
                if($this->input->post('loekz')=='2'){
        	        $emsg = 'The sale order already created delivery doc.';
					echo json_encode(array(
						'success'=>false,
						'message'=>$emsg
					));
					return;
                }
		}*/
		
		$this->db->where('delnr', $id);
		$this->db->delete('vbvp');

		// เตรียมข้อมูล  qt item
		$vbvp = $this->input->post('vbvp');
		$do_item_array = json_decode($vbvp);
		if(!empty($vbvp) && !empty($do_item_array)){
			// loop เพื่อ insert pr_item ที่ส่งมาใหม่
			$item_index = 0;
			foreach($do_item_array AS $p){
				if($p->upqty > $p->reman){
					$emsg = 'DO qty over remain qty';
					echo json_encode(array(
						'success'=>false,
						'message'=>$emsg
					));
					return;
				}
			}
		}

		$formData = array(
			//'vbeln' => $this->input->post('vbeln'),
			'bldat' => $this->input->post('bldat'),
			'statu' => $this->input->post('statu'),
			'txz01' => $this->input->post('txz01'),
			'ordnr' => $this->input->post('ordnr'),
			'auart' => $this->input->post('auart'),
			'reanr' => $this->input->post('reanr'),
			'refnr' => $this->input->post('refnr'),
			'ptype' => $this->input->post('ptype'),
			'taxnr' => $this->input->post('taxnr'),
			'terms' => intval($this->input->post('terms')),
			'kunnr' => $this->input->post('kunnr'),
			'netwr' => floatval($this->input->post('netwr')),
			'beamt' => floatval($this->input->post('beamt')),
			'dismt' => floatval($this->input->post('dismt')),
			'dispc' => floatval($this->input->post('dispc')),
			'taxpr' => floatval($this->input->post('taxpr')),
			'salnr' => $this->input->post('salnr'),
			'ctype' => $this->input->post('ctype'),
			'exchg' => floatval($this->input->post('exchg')),
			'whtnr' => $this->input->post('whtnr'),
			'vat01' => floatval($this->input->post('vat01')),
			'wht01' => floatval($this->input->post('wht01')),
			'duedt' => $this->input->post('duedt'),
			'disco' => floatval($this->input->post('disco')),
			'whtxt' => $this->input->post('whtxt')
		);

		// start transaction
		$this->db->trans_start();
		
		$current_username = XUMS::USERNAME();

		if (!empty($query) && $query->num_rows() > 0){
			$this->db->where('delnr', $id);
			//$this->db->set('updat', 'NOW()', false);
			db_helper_set_now($this, 'updat');
			$this->db->set('upnam', $current_username);
			$this->db->update('vbvk', $formData);
		}else{
			$id = $this->code_model->generate('DO', $this->input->post('bldat'));
			$this->db->set('delnr', $id);
			//$this->db->set('erdat', 'NOW()', false);
			db_helper_set_now($this, 'erdat');
		    $this->db->set('ernam', $current_username);
			$this->db->insert('vbvk', $formData);

			$inserted_id = $id;
			
			$this->db->where('ordnr', $this->input->post('ordnr'));
			$this->db->set('loekz', '2');
			$this->db->update('vbok');
		}

		// ลบ pr_item ภายใต้ id ทั้งหมด
		//$this->db->where('delnr', $id);
		//$this->db->delete('vbvp');

		// เตรียมข้อมูล  qt item
		//$vbvp = $this->input->post('vbvp');
		//$do_item_array = json_decode($vbvp);
		if(!empty($vbvp) && !empty($do_item_array)){
			// loop เพื่อ insert pr_item ที่ส่งมาใหม่
			$item_index = 0;
			foreach($do_item_array AS $p){
				$itamt = $p->menge * $p->unitp;
				$itamt = $itamt - $p->disit;
				$this->db->insert('vbvp', array(
					'delnr'=>$id,
					'vbelp'=>intval(++$item_index),//vbelp,
					'matnr'=>$p->matnr,
					'menge'=>floatval($p->menge),
					'meins'=>$p->meins,
					'disit'=>$p->disit,
					'unitp'=>floatval($p->unitp),
					'itamt'=>floatval($p->itamt),
					'ctype'=>$p->ctype,
					'chk01'=>$p->chk01,
					'chk02'=>$p->chk02,
					'reman'=>floatval($p->reman),
					'upqty'=>floatval($p->upqty),
					'tdisc'=>floatval($p->tdisc),
					'whtnr'=>$this->input->post('whtnr')
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
				$total_amount = floatval($this->input->post('netwr'));
				// send notification email
				if(!empty($inserted_id)){
					$q_row = $this->db->get_where('vbvk', array('delnr'=>$inserted_id));
					$row = $q_row->first_row();
					$this->email_service->sendmail_create(
						'DO', 'Delivery Order',
						$inserted_id, $total_amount,
						$row->ernam
					);
				}else if(!empty($post_id)){
					if($status_changed){
						$q_row = $this->db->get_where('vbvk', array('delnr'=>$post_id));
						$row = $q_row->first_row();
						$this->email_service->sendmail_change_status(
							'DO', 'Delivery Order',
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
		$this->db->where('delnr', $id);
		$query = $this->db->delete('vbvk');
		echo json_encode(array(
			'success'=>true,
			'data'=>$id
		));
	}

	///////////////////////////////////////////////
	// Sale Order ITEM
	///////////////////////////////////////////////

	function loads_do_item(){
		$sonr = $this->input->get('sonr');
		if(!empty($sonr)){
			$this->db->set_dbprefix('v_');
	     	//$iv_id = $this->input->get('vbap');
		    $this->db->where('ordnr', $sonr);

		    $query = $this->db->get('vbop');
		    
			$res = $query->result_array();
			$sumqty = 0;
		for($i=0;$i<count($res);$i++){
			$r = $res[$i];
			
			$this->db->where('ordnr', $sonr);
			$this->db->where('vbelp', $r['vbelp']);
			$q_vbvp = $this->db->get('vbvp');
			
			if($q_vbvp->num_rows()>0){
				$vbvp = $q_vbvp->result_array();
				for($j=0;$j<count($vbvp);$j++){
					$rs = $vbvp[$j];
					$sumqty = $sumqty + $rs['upqty'];
				}
                $res[$i]['reman'] = $res[$i]['menge'] - $sumqty;
				$sumqty=0;
			}else{
			   $res[$i]['reman'] = $res[$i]['menge'];
			}
		    $res[$i]['upqty'] = $res[$i]['reman'];
		}
		
		echo json_encode(array(
			'success'=>true,
			'rows'=>$res,
			'totalCount'=>$query->num_rows()
		));
		}else{
        $this->db->set_dbprefix('v_');
		$do_id = $this->input->get('delnr');
		$this->db->where('delnr', $do_id);
		
		$query = $this->db->get('vbvp');
		
		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$query->num_rows()
		));
		}	
	}

    function loads_conp_item(){
        $menge = $this->input->get('menge');
		$unitp = $this->input->get('unitp');
		$disit = $this->input->get('disit');
		$vvat = $this->input->get('vvat');
		$vwht = $this->input->get('vwht');
		$vat = $this->input->get('vat');
		$wht = $this->input->get('wht');
		$amt = $menge * $unitp;
		$i=0;$vamt=0;
		$result = array();
	    $query = $this->db->get('cont');
        if($query->num_rows()>0){
			$rows = $query->result_array();
			foreach($rows AS $row){
				    
					if($row['conty']=='01'){
						if(empty($dismt)) $dismt=0;
						$tamt = $amt - $disit;
						$amt = $amt - $disit;
						//unset($result[0]);
						if(empty($disit)) $disit=0;
						$tamt = $amt - $disit;
						
						$result[$i] = array(
					    'contx'=>$row['contx'],
				     	'vtamt'=>$disit,
					    'ttamt'=>$tamt
				        );
						$i++;
						/*array_push($result, array(
						    'contx'=>$row['contx'],
					     	'vtamt'=>$dismt,
						    'ttamt'=>$tamt
				        ));*/
					}elseif($row['conty']=='02'){
						if($vat=='true' || $vat=='1'){
							$vamt = ($tamt * $vvat) / 100;
							$tamt = $tamt + $vamt;
						$result[$i] = array(
					        'contx'=>$row['contx'],
				     	    'vtamt'=>$vamt,
					        'ttamt'=>$tamt
				        );
						$i++;
						}
					}elseif($row['conty']=='03'){
						//unset($result[2]);
						if($wht=='true' || $wht=='1'){
							$vwht = ($amt * $vwht) / 100;
							$tamt = $amt - $vwht;
							$tamt = $tamt + $vamt;
						$result[$i] = array(
					        'contx'=>$row['contx'],
				     	    'vtamt'=>$vwht,
					        'ttamt'=>$tamt
				        );
					}
				}
			}}
		echo json_encode(array(
			'success'=>true,
			'rows'=>$result,
			'totalCount'=>count($result)
		));
	}

}