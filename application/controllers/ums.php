<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ums extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->model('ums_service','',TRUE);
	}

	public function login(){
		$this->phxview->RenderView('login');
		$this->phxview->RenderLayout('empty_ext');
	}

	public function check_session(){
		$sess_obj = XUMS::getUserState();
		if(empty($sess_obj)){
			X::renderJSON(FALSE);
		}else{
			X::renderJSON($sess_obj);
		}
	}

	public function do_login()
	{
		$permission_array = $this->ums_service->permission_array;

		$Comid = $this->input->post('comid');
		$Username = $this->input->post('username');
		$Password = $this->input->post('password');

		if(empty($Comid)){
			X::renderJSON(array(
				'success'=>false,
				'message'=>'Company is not identified.'
			));
			return;
		}

		$resFailUsername = array(
			'success' => false,
			'message' => 'username','msg'=>'Username or Password incorrect!'
		);
		$resFailStatus = array(
			'success' => false,
			'message' => 'User is not exist.'
		);
		$query=$this->db->get_where('user', array(
			'uname'=>$Username,
			'comid'=>$Comid
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
                    	$permission_state = $this->ums_service->load_permission_by_uname($sUser['uname'], $Comid);
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

						$limit_state = $this->ums_service->load_doctype_limit_by_uname($sUser['uname'], $Comid);
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
	}

	public function do_logout(){
		X::unsetSession('currentStateJson');
		redirect(site_url('ums/login'));
	}

	public function index(){
		X::test(999999999999999);
		/*
		// test stuff
		$json = '{"a":10,"b":20}';
		$obj = json_decode($json);
		$classname = "obj";
		$varname = "a";

		$$classname->{'b'} += 55;

		echo $$classname->{'b'};
		*/
	}

	public function load(){
		$id = $this->input->post('id');
		$this->db->limit(1);
		$this->db->where('uname', $id);
		$query = $this->db->get('user');
			if($query->num_rows()==1){
			echo json_encode(array(
				'success'=>true,
				'data'=>$query->first_row('array')
			));
		}else{
			echo json_encode(array(
				'success'=>false,
				'message'=>'User is not exist.'
			));
		}
	}

	public function loads_user(){
		$tbName = 'user';
		$comid = XUMS::COMPANY_ID();
		$comid_esc = $this->db->escape($comid);

		if(empty($comid)){
			X::renderJSON(array(
				'success'=>false,
				'message'=>'Company is not identified.'
			));
			return;
		}

		/*$sql = "SELECT u.*,e.posnr,e.depnr FROM tbl_user u
INNER JOIN tbl_empl e ON u.empnr=e.empnr
WHERE u.comid=$comid_esc
ORDER BY u.empnr";*/
		$sql = "SELECT u.comid, u.empnr, u.uname, u.name1, u.passw,
e.posnr,e.depnr,p.postx,d.deptx
FROM tbl_user u
LEFT JOIN tbl_empl e ON u.empnr=e.empnr
LEFT JOIN tbl_posi p ON e.posnr=p.posnr
LEFT JOIN tbl_posi d ON e.depnr=d.depnr
WHERE u.comid=$comid_esc
GROUP BY u.empnr, e.posnr, e.depnr, p.postx, d.deptx, u.comid, u.uname, u.name1, u.passw
ORDER BY u.empnr";

		//$this->db->where('comid', $comid);

		//$sort = $this->input->get('sort');
		//$dir = $this->input->get('dir');
		//$this->db->order_by($sort, $dir);

		//$query = $this->db->get($tbName);
		//echo $this->db->last_query();

		$query = $this->db->query($sql);

		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$query->num_rows()
		));
	}

	public function loads_employee(){
		$tbName = 'empl';

		function createQuery($_this){

			$query = $_this->input->get('query');
			if(!empty($query)){
				$query = $_this->db->escape_str($query);
				$_this->db->where("(empnr LIKE '%$query%'
				OR name1 LIKE '%$query%')", NULL, FALSE);
			}

			$empnr1 = $_this->input->get('empnr');
			$empnr2 = $_this->input->get('empnr2');
			if(!empty($empnr1) && empty($empnr2)){
			  $_this->db->where('empnr', $empnr1);
			}
			elseif(!empty($empnr1) && !empty($empnr2)){
			  $_this->db->where('empnr >=', $empnr1);
			  $_this->db->where('empnr <=', $empnr2);
			}
		}

		//ต้อง filter employee เอาเฉพาะที่ยังไม่ได้เป็น user
		$tbUser = $this->db->dbprefix('user');
		$this->db->where("empnr NOT IN (SELECT empnr FROM $tbUser)");

		createQuery($this);
		$totalCount = $this->db->count_all_results($tbName);

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

	public function loads_permission(){
		$uname = $this->input->get('uname');
		$comid = XUMS::COMPANY_ID();//$this->input->get('comid');

		$result = $this->ums_service->load_permission_by_uname($uname, $comid);

		echo json_encode(array(
			'success'=>true,
			'rows'=>$result,
			'totalCount'=>count($result)
		));
	}

	public function loads_doctype_limit(){
		$tbAutl = $this->ums_service->tbAutl;
		$tbDoct = $this->ums_service->tbDoct;
		$tbUser = $this->ums_service->tbUser;

		$uname = $this->input->get('uname');
		$comid = $this->input->get('comid');

		$result = $this->ums_service->load_doctype_limit_by_uname($uname, $comid);

		echo json_encode(array(
			'success'=>true,
			'rows'=>$result,
			'totalCount'=>count($result)
		));
	}

	public function save(){
		$tbUser = $this->ums_service->tbUser;
		$permission_array = $this->ums_service->permission_array;

		$id = $this->input->post('id');
		$comid = XUMS::COMPANY_ID();
		$comid_esc = $this->db->escape($comid);

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
		$this->db->where("empnr = (SELECT empnr FROM $tbUser WHERE uname=$id_query AND comid=$comid_esc)");
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
					'comid'=>$comid,
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
	}


}