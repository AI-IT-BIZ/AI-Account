<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ums extends CI_Controller {

	private $permission_array = array(
		'display',
		'create',
		'edit',
		'delete',
		'export',
		'approve'
	);


	private $tbAutx = '';
	private $tbAutl = '';
	private $tbDoct = '';
	private $tbUser = '';

	function __construct()
	{
		parent::__construct();

		$this->load->model('ums_service','',TRUE);

		// init table name
		$this->tbAutx = $this->db->dbprefix('autx');
		$this->tbAutl = $this->db->dbprefix('autl');
		$this->tbDoct = $this->db->dbprefix('doct');
		$this->tbUser = $this->db->dbprefix('user');
	}
	public function index(){
		// test stuff
		$json = '{"a":10,"b":20}';
		$obj = json_decode($json);
		$classname = "obj";
		$varname = "a";

		$$classname->{'b'} += 55;

		echo $$classname->{'b'};
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
			'totalCount'=>$query->num_rows()
		));
	}

	public function loads_employee(){
		$tbName = 'empl';

		function createQuery($_this){

			$query = $_this->input->get('query');
			if(!empty($query)){
				$query = $_this->db->escape_str($query);
				$_this->db->where("(`empnr` LIKE '%$query%'
				OR `name1` LIKE '%$query%')", NULL, FALSE);
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
		$tbAutx = $this->tbAutx;
		$tbDoct = $this->tbDoct;
		$tbUser = $this->tbUser;

		$uname = $this->input->get('uname');
		$uname = $this->db->escape($uname);
		$sql = "
Select d.doctx ,d.docty,a.autex From $tbDoct d
Left Join $tbAutx a on d.docty = a.docty and a.empnr=(SELECT u.empnr FROM $tbUser u WHERE u.uname=$uname)
Order by d.doctx ASC";
		$query = $this->db->query($sql);

		$result = $query->result_array();

		$p_count = count($this->permission_array);
		$p_array = $this->permission_array;

		for($i=0;$i<count($result);$i++){
			$permission = $result[$i]['autex'];
			if(strlen($permission)<$p_count){
				$permission = str_pad('', $p_count, '0');
			}

			for($j=0;$j<count($p_array);$j++){
				$result[$i][$p_array[$j]] = $permission[$j];
			}
		}
		echo json_encode(array(
			'success'=>true,
			'rows'=>$result,
			'totalCount'=>$query->num_rows()
		));
	}

	public function loads_doctype_limit(){
		$tbAutl = $this->tbAutl;
		$tbDoct = $this->tbDoct;
		$tbUser = $this->tbUser;

		$uname = $this->input->get('uname');
		$uname = $this->db->escape($uname);

		$approveable_docty = $this->input->get('approvable');
		//$approveable_docty = $this->db->escape($approveable_docty);

		$sql = "
SELECT
TRIM(d.grptx) grptx,TRIM(d.doctx) doctx,TRIM(d.docty) docty,TRIM(d.grpmo) grpmo
, a.limam, a.comid
FROM $tbDoct d
LEFT JOIN $tbAutl a ON d.docty = a.docty AND a.empnr=(SELECT u.empnr FROM $tbUser u WHERE u.uname=$uname)
WHERE 1=1
ORDER BY TRIM(d.grptx) , TRIM(d.docty) ASC";
		$query = $this->db->query($sql);

		$result = $query->result_array();
		/*
		$new_result = array();
		if(!empty($approveable_docty)){
			$approveable_docty_array = explode(',', $approveable_docty);
			foreach($result AS $v){
				$is_exist = false;
				foreach($approveable_docty_array AS $dt){
					if($v['docty']==$dt){
						$is_exist = true;
						break;
					}
				}
				if($is_exist)
					array_push($new_result, $v);
			}
		}
		*/
		echo json_encode(array(
			'success'=>true,
			'rows'=>$result,
			'totalCount'=>count($result)
		));
	}

	public function save(){
		$tbUser = $this->tbUser;

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

				$p_array = $this->permission_array;
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
	}


}