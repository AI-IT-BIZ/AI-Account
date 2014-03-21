<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Saleperson extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('code_model2','',TRUE);
	}

	function index(){
		//$this->phxview->RenderView('saleperson');
		//$this->phxview->RenderLayout('default');
	}

	function load(){
		$this->db->set_dbprefix('v_');
		$salnr = $this->input->post('salnr');
		$this->db->limit(1);
		$this->db->where('salnr', $salnr);
		$query = $this->db->get('psal');
		
		if($query->num_rows()>0){
			$result_data = $query->first_row('array');
			$result_data['id'] = $result_data['salnr'];
			//$result_data['name1'] = $result_data['emnam'];
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
		$tbName = 'psal';
		
		function createQuery($_this){
			
			$query = $_this->input->get('query');
			if(!empty($query)){
				$_this->db->where("(`salnr` LIKE '%$query%'
				OR `emnam` LIKE '%$query%')", NULL, FALSE);
			}
			
			$salnr1 = $_this->input->get('salnr');
			$salnr2 = $_this->input->get('salnr2');
			if(!empty($salnr1) && empty($salnr2)){
			  $_this->db->where('salnr', $salnr1);
			}
			elseif(!empty($salnr1) && !empty($salnr2)){
			  $_this->db->where('salnr >=', $salnr1);
			  $_this->db->where('salnr <=', $salnr2);
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
			$this->db->where('salnr', $id);
			$query = $this->db->get('psal');
			
			// ##### CHECK PERMISSIONS
			$row = $query->first_row('array');
			// status has change
			$status_changed = $row['statu']!=$this->input->post('statu');
			if($status_changed){
				if(XUMS::CAN_DISPLAY('SP') && XUMS::CAN_APPROVE('SP')){
					$limit = XUMS::LIMIT('SP');
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
					$emsg = 'You do not have permission to change Sale Person status.';
					echo json_encode(array(
						'success'=>false,
						'errors'=>array( 'statu' => $emsg ),
						'message'=>$emsg
					));
					return;
				}
			}else{
				if($row['statu']=='03'){
					$emsg = 'The Sale Person that already approved or rejected cannot be update.';
					echo json_encode(array(
						'success'=>false,
						'message'=>$emsg
					));
					return;
				}
			}
			// ##### END CHECK PERMISSIONS
		}
		
		if($this->input->post('goals')<$this->input->post('levt3')){
					$emsg = 'The Sales goal must be more than Level 3 Amount.';
					echo json_encode(array(
						'success'=>false,
						'message'=>$emsg
					));
					return;
				}
        
		$sdat = explode('-',$this->input->post('stdat'));
		$edat = explode('-',$this->input->post('endat'));
		$stdat = $sdat[0].$sdat[1].$sdat[2];
		$endat = $edat[0].$edat[1].$edat[2];
		//echo $stdat.'aaa'.$endat;
		if($stdat>$endat){
					$emsg = 'The End date must be more than Start date.';
					echo json_encode(array(
						'success'=>false,
						'message'=>$emsg
					));
					return;
				}
		
		if($this->input->post('ctype') == '1') $commis='Levels';
		else $commis='Step';
		
		//echo $this->input->post('empnr');
		$formData = array(
			//'salnr' => $this->input->post('salnr'),
			'empnr' => $this->input->post('empnr'),
			'ctype' => $commis,
			'name1' => $this->input->post('name1'),
			'goals' => $this->input->post('goals'),
			'stdat' => $this->input->post('stdat'),
			'endat' => $this->input->post('endat'),
			'percs' => $this->input->post('percs'),
			'levf1' => $this->input->post('levf1'),
			'levf2' => $this->input->post('levf2'),
			'levf3' => $this->input->post('levf3'),
			'levt1' => $this->input->post('levt1'),
			'levt2' => $this->input->post('levt2'),
			'levt3' => $this->input->post('levt3'),
			'perc1' => $this->input->post('perc1'),
			'perc2' => $this->input->post('perc2'),
			'perc3' => $this->input->post('perc3'),
			'statu' => $this->input->post('statu')
			
		);
		
		$current_username = XUMS::USERNAME();
		if (!empty($query) && $query->num_rows() > 0){
			$this->db->where('salnr', $id);
			$this->db->update('psal', $formData);
		}else{
			$id = $this->code_model2->generate2('SP');
			$this->db->set('salnr', $id);
			//$this->db->set('erdat', 'NOW()', false);
			db_helper_set_now($this, 'erdat');
			$this->db->set('ernam', $current_username);
			$this->db->insert('psal', $formData);
			
			$inserted_id = $id;
		}

		echo json_encode(array(
			'success'=>true,
			'data'=>$_POST
		));
	}

	function remove(){
		$salnr = $this->input->post('salnr');
		$this->db->where('salnr', $salnr);
		$query = $this->db->delete('psal');
		echo json_encode(array(
			'success'=>true,
			'data'=>$salnr
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