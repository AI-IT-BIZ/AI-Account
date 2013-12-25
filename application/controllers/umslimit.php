<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Umslimit extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->model('ums_service','',TRUE);
	}

	private $splitter = '$';

	private function is_node_root($id){
		return $id=='root';
	}
	private function is_node_docty($id){
		return count(explode($this->splitter, $id))==2;
	}
	private function is_node_limam($id){
		return count(explode($this->splitter, $id))==3;
	}
	private function is_node_empnr($id){
		return count(explode($this->splitter, $id))==4;
	}
	private function get_id($id){
		return end(explode($this->splitter, $id));
	}

	public function loads_tree_doctype() {
		$rs = array();

		$node = $this->input->get('node');
		$comid = $this->input->get('comid');

		if(empty($comid)){
			X::renderJSON(array(
				'success'=>false,
				'message'=>'Company is not identified.'
			));
			return;
		}

		if($this->is_node_root($node)){
			$q = $this->db->get('doct');
			$list = $q->result();
			foreach($list AS $l){
				array_push($rs, array(
					'text'=>$l->doctx,
					'id'=>$node.$this->splitter.$l->docty,
					'expanded'=>true
				));
			}
		}else if($this->is_node_docty($node)){
			$docty = $this->db->escape($this->get_id($node));
			$comid = $this->db->escape($comid);
			$sql = "SELECT docty, limam FROM tbl_autl
WHERE docty=$docty AND comid=$comid
GROUP BY limam
ORDER BY limam DESC";

			$q = $this->db->query($sql);
			$list = $q->result();
			foreach($list AS $l){
				array_push($rs, array(
					'text'=>number_format($l->limam),
					'id'=>$node.$this->splitter.$l->limam,
					'expanded'=>true
				));
			}
		}

		X::renderJSON(array(
			'success'=>true,
			'rows'=>$rs
		));

		/*
		$permission_array = $this->ums_service->permission_array;

		$Username = $this->input->post('username');
		$Password = $this->input->post('password');

		$resFailUsername = array(
			'success' => false,
			'message' => 'username','msg'=>'Username or Password incorrect!'
		);
		$resFailStatus = array(
			'success' => false,
			'message' => 'User is not exist.'
		);
		$query=$this->db->get_where('user', array(
			'uname'=>$Username
		));
		$users = $query->result('array');
		if (count($users) == 1)
		{
			$sUser = $users[0];
			if (!isset($sUser['passw']))
				X::renderJSON($resFailStatus);
			else
				if(!isset($Password))
					X::renderJSON($resFailUsername);
				else{
					if ($sUser['passw']!=$Password)
						X::renderJSON($resFailUsername);
					else
					{
                    	// prepare PermissionState
                    	$permission_state = $this->ums_service->load_permission_by_uname($sUser['uname']);
						$permission_state_buff = array();
						foreach($permission_state AS $v){
							if($v['display']==1){
								$perm = array('docty'=>$v['docty']);
								foreach($permission_array AS $p){
									$perm[$p] = $v[$p];
								}
								array_push($permission_state_buff, $perm);
							}
						}

						$limit_state = $this->ums_service->load_doctype_limit_by_uname($sUser['uname']);
						$limit_state_buff = array();
						foreach($limit_state AS $v){
							$is_exist = false;
							foreach($permission_state_buff AS $p){
								if($p['docty']==$v['docty']){
									$is_exist=true; break;
								}
							}
							if($is_exist){
								$lim = array(
									'limam'=>empty($v['limam'])?0:$v['limam'],
									'docty'=>$v['docty']
								);
								array_push($limit_state_buff, $lim);
							}
						}

						X::setSession('currentStateJson',json_encode(array(
							'UserState'=>array(
								'uname'=>$sUser['uname'],
								'name1'=>$sUser['name1'],
								'comid'=>$sUser['comid']
							),
							'Permission'=>$permission_state_buff,
							'Limit'=>$limit_state_buff
						)));
						X::renderJSON(array(
							'success'=>true,
							'data'=>json_decode(X::getSession('currentStateJson'))
						));
					}
				}
		}
		else
			X::renderJSON($resFailUsername);
		*/
	}

	public function save_limit(){
		$limit_amount = $this->input->post('limam');
		$id = $this->input->post('id');
		$comid = $this->input->post('comid');

		if(empty($comid)){
			X::renderJSON(array(
				'success'=>false,
				'message'=>'Company is not identified.'
			));
			return;
		}

		if($this->is_node_docty($id)){
			$docty = $this->get_id($id);

			// check exist limit
			$q = $this->db->get_where('autl', array(
				'docty'=>$docty,
				'comid'=>$comid,
				'limam'=>$limit_amount
			));
			if($q->num_rows()>0){
				X::renderJSON(array(
					'success'=>false,
					'message'=>'Limit amount already exist.'
				));
				return;
			}

			$this->db->insert('autl', array(
				'comid'=>$comid,
				'docty'=>$docty,
				'limam'=>$limit_amount
			));
		}else if($this->is_node_limam($id)){
			$this->db->where('comid', $comid);
			$this->db->where('limam', $limit_amount);
			//$this->db->where('docty', $docty)
		}



		echo json_encode(array(
			'success'=>true
		));

		//$this->db->insert('autl', )

		/*

		$tbUser = $this->ums_service->tbUser;
		$permission_array = $this->ums_service->permission_array;

		$id = $this->input->post('id');

		$uname = $this->input->post('uname');
		$passw = $this->input->post('passw');

		$query = null;
		$user = null;
		if(!empty($id)){
			$user = $this->ums_service->load_user_bypk($id);
		}else{
			echo json_encode(array(
				'success'=>false,
				'message'=>'Username is not found.'
			));
			return;
		}

		// start transaction
		$this->db->trans_begin();

		if (!empty($user)){
			$this->db->where('uname', $id);
			//db_helper_set_now($this, 'updat');
			//$this->db->set('upnam', 'test');
			$this->db->update('user', array(
				'passw' => $passw
			));
		}else{
			echo json_encode(array(
				'success'=>false,
				'message'=>'Username is not found.'
			));
			return;
		}

		// ลบ permission ภายใต้ id ทั้งหมด
		$id_query = $this->db->escape($id);
		$this->db->where("empnr = (SELECT empnr FROM $tbUser WHERE uname=$id_query)");
		$this->db->delete('autx');

		// เตรียมข้อมูล permission
		$autx = $this->input->post('autx');
		$autx_array = json_decode($autx);
		if(!empty($user) && !empty($autx_array)){
			// loop เพื่อ insert autx ที่ส่งมาใหม่
			$item_index = 0;
			foreach($autx_array AS $p){
				// loop เพื่อสร้างค่า autex
				$autx_data = array(
					'comid'=>'1000',
					'empnr'=>$user['empnr'],
					'docty'=>$p->docty,
					'autex'=>''
				);
				$classname = "p";

				$p_array = $permission_array;
				for($i=0;$i<count($p_array);$i++){
					$autx_data['autex'] .= $$classname->{$p_array[$i]};
				}

				// finally save each autx
				$this->db->insert('autx', $autx_data);
			}
		}

		// ลบ limit ภายใต้ id ทั้งหมด
		$id_query = $this->db->escape($id);
		$this->db->where("empnr = (SELECT empnr FROM $tbUser WHERE uname=$id_query)");
		$this->db->delete('autl');

		// เตรียมข้อมูล permission
		$autl = $this->input->post('autl');
		$autl_array = json_decode($autl);
		if(!empty($user) && !empty($autl_array)){
			// loop เพื่อ insert autl ที่ส่งมาใหม่
			$item_index = 0;
			foreach($autl_array AS $p){
				// finally save each autx
				$this->db->insert('autl', array(
					'comid'=>'1000',
					'empnr'=>$user['empnr'],
					'docty'=>$p->docty,
					'limam'=>$p->limam
				));
			}
		}

		// end transaction
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			echo json_encode(array(
				'success'=>false,
				'message'=>'Error occured rollback.'
			));
		}
		else
		{
			$this->db->trans_commit();
			echo json_encode(array(
				'success'=>true
			));
		}
		*/
	}

	// combo
	public function loads_company_combo(){
		$this->db->select('comid,name1');
		$q = $this->db->get('comp');

		echo json_encode(array(
			'success'=>true,
			'rows'=>$q->result_array(),
			'totalCount'=>$q->num_rows()
		));
	}


}