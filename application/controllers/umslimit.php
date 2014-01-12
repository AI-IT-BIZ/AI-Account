<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Umslimit extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->model('autl_model','autl',TRUE);
		$this->load->model('autd_model','autd',TRUE);
		$this->load->model('autu_model','autu',TRUE);

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
			$sql = "SELECT d.*, a.depdp FROM tbl_doct d
LEFT JOIN tbl_autd a ON d.docty=a.docty
WHERE d.field='1'
ORDER BY d.grpmo ASC
";
			$q = $this->db->query($sql);
			$list = $q->result();
			foreach($list AS $l){
				array_push($rs, array(
					'text'=>$l->doctx.(($l->depdp==1)?' - <b>Depend on department</b>':''),
					'id'=>$node.$this->splitter.$l->docty,
					'expanded'=>false,
					'iconCls'=>'tree-node-document'
				));
			}
		}else if($this->is_node_docty($node)){
			$docty = $this->db->escape($this->get_id($node));
			$comid = $this->db->escape($comid);
			$sql = "SELECT autlid, docty, limam FROM tbl_autl
WHERE docty=$docty AND comid=$comid AND limam IS NOT NULL AND limam>=0
GROUP BY limam
ORDER BY limam DESC";

			$q = $this->db->query($sql);
			$has_unlimit = FALSE;
			$list = $q->result();
			foreach($list AS $l){
				if($l->limam==0 && $has_unlimit==FALSE)
					$has_unlimit = TRUE;
				array_push($rs, array(
					'text'=>($l->limam!=0)?number_format($l->limam):'Unlimit',
					'id'=>$node.$this->splitter.$l->autlid,
					'expanded'=>false,
					'iconCls'=>'tree-node-limit'
				));
			}
			// swap if limit
			if($has_unlimit && count($rs)>1){
				$buff = $rs[0];
				$last = array_pop($rs);
				$rs[0] = $last;
				array_push($rs, $buff);
			}
		}else if($this->is_node_limam($node)){
			$autlid = $this->db->escape($this->get_id($node));
			$comid = $this->db->escape($comid);
			$sql = "SELECT au.autlid, au.autuid, au.empnr, em.name1 FROM tbl_autu au
LEFT JOIN tbl_empl em ON au.empnr=em.empnr
WHERE au.autlid=$autlid
";

			$q = $this->db->query($sql);
			$list = $q->result();
			foreach($list AS $l){
				array_push($rs, array(
					'text'=>$l->name1.' ('.$l->empnr.')',
					'id'=>$node.$this->splitter.$l->autuid,
					'leaf'=>true,
					'iconCls'=>'tree-node-user'
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

	public function load_limit(){
		$id = $this->input->post('id');
		$comid = $this->input->post('comid');

		if(empty($comid)){
			X::renderJSON(array(
				'success'=>false,
				'message'=>'Company is not identified.'
			));
			return;
		}

		$autlid = $this->get_id($id);

		$l = $this->autl->get($autlid);

		if(!empty($l)){
			X::renderJSON(array(
				'success'=>true,
				'data'=>array(
					'limam'=>$l->limam
				)
			));
		}else{
			X::renderJSON(array(
				'success'=>false,
				'message'=>'No data(s) found.'
			));
		}

	}

	public function load_document(){
		$id = $this->input->post('id');
		$comid = $this->input->post('comid');

		if(empty($comid)){
			X::renderJSON(array(
				'success'=>false,
				'message'=>'Company is not identified.'
			));
			return;
		}

		$docty = $this->get_id($id);
		$doc = $this->autd->get_by(array(
			'comid'=>$comid,
			'docty'=>$docty
		));

		X::renderJSON(array(
			'success'=>true,
			'data'=>(!empty($doc))?$doc:null
		));
	}

	public function save_document(){
		$id = $this->input->post('id');
		$comid = $this->input->post('comid');
		$depdp = $this->input->post('depdp');

		if(empty($comid)){
			X::renderJSON(array(
				'success'=>false,
				'message'=>'Company is not identified.'
			));
			return;
		}

		if($this->is_node_docty($id)){
			$docty = $this->get_id($id);
			$this->db->where('comid', $comid);
			$this->db->where('docty', $docty);


			$docty = $this->get_id($id);
			$doc = $this->autd->get_by(array(
				'comid'=>$comid,
				'docty'=>$docty
			));
			if(count($doc)>0){
				$this->autd->update_by(array(
					'comid'=>$comid,
					'docty'=>$docty
				), array(
					'depdp'=>$depdp
				));
			}else{
				$this->autd->insert(array(
					'comid'=>$comid,
					'docty'=>$docty,
					'depdp'=>$depdp
				));
			}

		}

		X::renderJSON(array(
			'success'=>true
		));
	}

	public function save_limit(){
		$limit_amount = $this->input->post('limam');
		$id = $this->input->post('id');
		$comid = XUMS::COMPANY_ID();//$this->input->post('comid');

		if(empty($comid)){
			X::renderJSON(array(
				'success'=>false,
				'message'=>'Company is not identified.'
			));
			return;
		}

		if($this->is_node_docty($id)){
			$docty = $this->get_id($id);

			// check exist autd
			$doc = $this->autd->get_by(array(
				'comid'=>$comid,
				'docty'=>$docty
			));
			if(empty($doc)){
				$this->autd->insert(array(
					'comid'=>$comid,
					'docty'=>$docty,
					'depdp'=>0
				));
			}

			// check exist limit
			$rows = $this->autl->get_many_by(array(
				'docty'=>$docty,
				'comid'=>$comid,
				'limam'=>$limit_amount
			));
			// ถ้าเจอให้วนลูปเช็ค
			if(count($rows)>0){
				X::renderJSON(array(
					'success'=>false,
					'message'=>'Limit amount already exist.'
				));
				return;
			}else{
				$this->autl->insert(array(
					'comid'=>$comid,
					'docty'=>$docty,
					'limam'=>$limit_amount
				));
			}
		}else if($this->is_node_limam($id)){
			$autlid = $this->get_id($id);

			$this->autl->update_by(array(
				'autlid'=>$autlid
			), array(
				'limam'=>$limit_amount
			));
		}

		X::renderJSON(array(
			'success'=>true
		));
	}

	public function remove_limit(){
		$id = $this->input->post('id');
		$comid = XUMS::COMPANY_ID();//$this->input->post('comid');

		if(empty($comid)){
			X::renderJSON(array(
				'success'=>false,
				'message'=>'Company is not identified.'
			));
			return;
		}

		if($this->is_node_limam($id)){
			$autlid = $this->get_id($id);
			$this->autl->delete($autlid);

			// remove all user under autlid
			$this->autu->delete_by(array(
				'autlid'=>$autlid
			));
		}

		X::renderJSON(array(
			'success'=>true,
			'data'=>$autlid
		));
	}

	public function save_user(){
		$id = $this->input->post('id');
		$comid = XUMS::COMPANY_ID();//$this->input->post('comid');
		$empnr = $this->input->post('empnr');

		if(empty($comid)){
			X::renderJSON(array(
				'success'=>false,
				'message'=>'Company is not identified.'
			));
			return;
		}

		if($this->is_node_limam($id)){
			$autlid = $this->get_id($id);

			// check user under autl
			$u_count = $this->autu->count_by(array(
				'autlid'=>$autlid,
				'empnr'=>$empnr
			));

			if($u_count>0){
				X::renderJSON(array(
					'success'=>false,
					'message'=>'User already exist.'
				));
				return;
			}else{
				$this->autu->insert(array(
					'comid'=>$comid,
					'autlid'=>$autlid,
					'empnr'=>$empnr
				));
			}
		}

		X::renderJSON(array(
			'success'=>true
		));
	}

	public function remove_user(){
		$id = $this->input->post('id');
		$comid = XUMS::COMPANY_ID();

		if(empty($comid)){
			X::renderJSON(array(
				'success'=>false,
				'message'=>'Company is not identified.'
			));
			return;
		}

		if($this->is_node_empnr($id)){
			$autuid = $this->get_id($id);
			$this->autu->delete($autuid);
		}

		X::renderJSON(array(
			'success'=>true,
			'data'=>$autuid
		));
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