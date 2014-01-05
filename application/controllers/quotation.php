<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Quotation extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->model('code_model','',TRUE);

		$this->load->model('email_service','',TRUE);
/*
		if(empty(XUMS::USERNAME())){
			echo json_encode(array(
				'success'=>false,
				'message'=>'Session has expire please re-login.'
			));
			return;
		}
*/
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
		$this->db->limit(1);

		$this->db->where('vbeln', $id);
		$query = $this->db->get('vbak');

		if($query->num_rows()>0){
			$result_data = $query->first_row('array');
			$result_data['id'] = $result_data['vbeln'];

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
		$tbName = 'vbak';

		// Start for report
		function createQuery($_this){
			$query = $_this->input->get('query');
			if(!empty($query)){
				$_this->db->where("(`vbeln` LIKE '%$query%'
				OR `kunnr` LIKE '%$query%'
				OR `name1` LIKE '%$query%'
				OR `jobnr` LIKE '%$query%'
				OR `sname` LIKE '%$query%')", NULL, FALSE);
			}


	        $vbeln1 = $_this->input->get('vbeln');
			$vbeln2 = $_this->input->get('vbeln2');
			if(!empty($vbeln1) && empty($vbeln2)){
			  $_this->db->where('vbeln', $vbeln1);
			}
			elseif(!empty($vbeln1) && !empty($vbeln2)){
			  $_this->db->where('vbeln >=', $vbeln1);
			  $_this->db->where('vbeln <=', $vbeln2);
			}

			$bldat1 = $_this->input->get('bldat');
			$bldat2 = $_this->input->get('bldat2');
			if(!empty($bldat1) && empty($bldat2)){
			  $_this->db->where('bldat >=', $bldat1);
			}
			elseif(!empty($bldat1) && !empty($bldat2)){
			  $_this->db->where('bldat >=', $bldat1);
			  $_this->db->where('bldat <=', $bldat2);
			}

			$jobnr1 = $_this->input->get('jobnr');
			$jobnr2 = $_this->input->get('jobnr2');
			if(!empty($jobnr1) && empty($jobnr2)){
			  $_this->db->where('jobnr', $jobnr1);
			}
			elseif(!empty($jobnr1) && !empty($jobnr2)){
			  $_this->db->where('jobnr >=', $jobnr1);
			  $_this->db->where('jobnr <=', $jobnr2);
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

			// query for limit user
			//if(XUMS::CAN_DISPLAY('QT') && XUMS::CAN_APPROVE('QT')){
			//	$_this->db->where('beamt <=', XUMS::LIMIT('QT'));
			//}else{
			//	$_this->db->where('ernam', XUMS::USERNAME());
			//}
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
			$this->db->where('vbeln', $id);
			$query = $this->db->get('vbak');

			// ##### CHECK PERMISSIONS
			$row = $query->first_row('array');
			// status has change
			$status_changed = $row['statu']!=$this->input->post('statu');
			if($status_changed){
				if(XUMS::CAN_DISPLAY('QT') && XUMS::CAN_APPROVE('QT')){
					$limit = XUMS::LIMIT('QT');
					if($limit<$row['netwr']){
						$emsg = 'You do not have permission to change quotaion status over than '.number_format($limit);
						echo json_encode(array(
							'success'=>false,
							'errors'=>array( 'statu' => $emsg ),
							'message'=>$emsg
						));
						return;
					}
				}else{
					$emsg = 'You do not have permission to change quotaion status.';
					echo json_encode(array(
						'success'=>false,
						'errors'=>array( 'statu' => $emsg ),
						'message'=>$emsg
					));
					return;
				}
			}else{
				if($row['statu']=='02'||$row['statu']=='03'){
					$emsg = 'The quotation that already approved or rejected cannot be update.';
					echo json_encode(array(
						'success'=>false,
						'message'=>$emsg
					));
					return;
				}
			}
			// ##### END CHECK PERMISSIONS
		}

        $net = $this->input->post('netwr');
		$formData = array(
			//'vbeln' => $this->input->post('vbeln'),
			'bldat' => $this->input->post('bldat'),
			'statu' => $this->input->post('statu'),
			'txz01' => $this->input->post('txz01'),
			'jobnr' => $this->input->post('jobnr'),
			'auart' => $this->input->post('auart'),
			'reanr' => $this->input->post('reanr'),
			'refnr' => $this->input->post('refnr'),
			'ptype' => $this->input->post('ptype'),
			'taxnr' => $this->input->post('taxnr'),
			'terms' => $this->input->post('terms'),
			'kunnr' => $this->input->post('kunnr'),
			'netwr' => $this->input->post('netwr'),
			'beamt' => $this->input->post('beamt'),
			'dismt' => $this->input->post('dismt'),
			'taxpr' => $this->input->post('taxpr'),
			'salnr' => $this->input->post('salnr'),
			'ctype' => $this->input->post('ctype'),
			'exchg' => $this->input->post('exchg'),
			'whtpr' => $this->input->post('whtpr'),
			'vat01' => $this->input->post('vat01'),
			'wht01' => $this->input->post('wht01')
		);

		// start transaction
		$this->db->trans_start();

		$current_username = XUMS::USERNAME();

		if (!empty($query) && $query->num_rows() > 0){
			$this->db->where('vbeln', $id);
			//$this->db->set('updat', 'NOW()', false);
			db_helper_set_now($this, 'updat');
			$this->db->set('upnam', $current_username);
			$this->db->update('vbak', $formData);
		}else{
			$id = $this->code_model->generate('QT', $this->input->post('bldat'));
			$this->db->set('vbeln', $id);
			$this->db->set('erdat', 'NOW()', false);
		    $this->db->set('ernam', $current_username);
			$this->db->insert('vbak', $formData);

			$inserted_id = $id;
		}

		// ลบ pr_item ภายใต้ id ทั้งหมด
		$this->db->where('vbeln', $id);
		$this->db->delete('vbap');

		// เตรียมข้อมูล  qt item
		$vbap = $this->input->post('vbap');//$this->input->post('vbelp');
		$qt_item_array = json_decode($vbap);
		if(!empty($vbap) && !empty($qt_item_array)){
			// loop เพื่อ insert pr_item ที่ส่งมาใหม่
			$item_index = 0;
			foreach($qt_item_array AS $p){
				$itamt = $p->menge * $p->unitp;
				$itamt = $itamt - $p->disit;
				$this->db->insert('vbap', array(
					'vbeln'=>$id,
					'vbelp'=>++$item_index,//vbelp,
					'matnr'=>$p->matnr,
					'menge'=>$p->menge,
					'meins'=>$p->meins,
					'disit'=>$p->disit,
					'unitp'=>$p->unitp,
					'itamt'=>$itamt,
					'ctype'=>$p->ctype,
					'chk01'=>$p->chk01,
					'chk02'=>$p->chk02
				));
			}
		}

		// ลบ pay_item ภายใต้ id ทั้งหมด
		$this->db->where('vbeln', $id);
		$this->db->delete('payp');

		// เตรียมข้อมูล pay item
		$payp = $this->input->post('payp');//$this->input->post('vbelp');
		$pp_item_array = json_decode($payp);
		if(!empty($payp) && !empty($pp_item_array)){
            $item_index = 0;
			// loop เพื่อ insert pay_item ที่ส่งมาใหม่
			foreach($pp_item_array AS $p){
				$perct = $p->perct;
                $perct = $perct / 100;
                $pramt = $perct * $net;

				$this->db->insert('payp', array(
					'vbeln'=>$id,
					'paypr'=>++$item_index,
					'sgtxt'=>$p->sgtxt,
					'duedt'=>$p->duedt,
					'perct'=>$p->perct,
					'pramt'=>$pramt,
					'ctyp1'=>$p->ctyp1,
					'payty'=>$p->payty
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
					$this->email_service->quotation_create('QT', $total_amount);
				}else if(!empty($post_id)){
					if($status_changed)
						$this->email_service->quotation_change_status('QT', $total_amount);
				}
			}catch(exception $e){}
		}
	}

    public function loads_scombo(){
		$tbName = 'psal';
		$tbPK = 'salnr';

		$query = $this->input->post('query');

		$totalCount = $this->db->count_all_results($tbName);

		if(!empty($query) && $query!=''){
			$this->db->or_like('name1', $query);
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

    public function loads_taxcombo(){
		$tbName = 'tax1';
		$tbPK = 'taxnr';

		$query = $this->input->post('query');

		$totalCount = $this->db->count_all_results($tbName);

		if(!empty($query) && $query!=''){
			$this->db->or_like('taxtx', $query);
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
		$this->db->where('vbeln', $id);
		$query = $this->db->delete('vbak');
		echo json_encode(array(
			'success'=>true,
			'data'=>$id
		));
	}

	///////////////////////////////////////////////
	// Quotation ITEM
	///////////////////////////////////////////////

	function loads_qt_item(){
        $this->db->set_dbprefix('v_');
		$qt_id = $this->input->get('vbeln');
		$this->db->where('vbeln', $qt_id);

		$query = $this->db->get('vbap');
		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$query->num_rows()
		));
	}

	function loads_pay_item(){
        //$this->db->set_dbprefix('v_');
		$pp_id = $this->input->get('vbeln');
		$this->db->where('vbeln', $pp_id);

		$query = $this->db->get('payp');
		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$query->num_rows()
		));
	}

    function loads_conp_item(){
        $menge = $this->input->get('menge');
		$unitp = $this->input->get('unitp');
		$disit = $this->input->get('disit');
		$vvat = $this->input->get('vvat');
		$vwht = $this->input->get('vwht');
		$vat = $this->input->get('vat');
		$wht = $this->input->get('wht');
		$vattype = $this->input->get('vattype');
		$amt = $menge * $unitp;
		$i=0;$vamt=0;

		$result = array();
	    $query = $this->db->get('cont');
        if($query->num_rows()>0){
			$rows = $query->result_array();
			foreach($rows AS $row){

					if($row['conty']=='01'){
						if(empty($disit)) $disit=0;

						$tamt = $amt - $disit;
						if($vattype=='02'){
			                   $tamt = $tamt * 100;
			                   $tamt = $tamt / 107;
		                }
						$amt = $tamt;

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