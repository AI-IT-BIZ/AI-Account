<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ums_service extends CI_Model {

	public $permission_array = array(
		'display',
		'create',
		'edit',
		'delete',
		'export',
		'approve'
	);

	public $tbAutx = '';
	public $tbAutl = '';
	public $tbDoct = '';
	public $tbUser = '';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();

		// init table name
		$this->tbAutx = $this->db->dbprefix('autx');
		$this->tbAutl = $this->db->dbprefix('autl');
		$this->tbAutu = $this->db->dbprefix('autu');
		$this->tbDoct = $this->db->dbprefix('doct');
		$this->tbUser = $this->db->dbprefix('user');
    }

	public function load_user_bypk($id){
		$this->db->where('uname', $id);
		$this->db->limit(1);
		$this->db->where('uname', $id);
		$q = $this->db->get('user');
		if($q->num_rows()==1){
			return $q->first_row('array');
		}else{
			return null;
		}
	}

	public function load_permission_by_uname($uname){
		$tbAutx = $this->tbAutx;
		$tbDoct = $this->tbDoct;
		$tbUser = $this->tbUser;

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
		return $result;
	}

	public function load_doctype_limit_by_uname($uname){
		$tbAutl = $this->tbAutl;
		$tbAutu = $this->tbAutu;
		$tbDoct = $this->tbDoct;
		$tbUser = $this->tbUser;

		$uname = $this->db->escape($uname);

		$sql = "
SELECT
TRIM(d.grptx) grptx,TRIM(d.doctx) doctx,TRIM(d.docty) docty,TRIM(d.grpmo) grpmo
, al.limam, au.comid
FROM $tbDoct d

LEFT JOIN $tbAutu au ON au.empnr=(SELECT u.empnr FROM $tbUser u WHERE u.uname=$uname)
LEFT JOIN $tbAutl al ON au.autlid=al.autlid AND al.docty=d.docty

WHERE 1=1
GROUP BY d.docty
ORDER BY TRIM(d.grptx) , TRIM(d.docty) ASC, al.limam DESC";
		$query = $this->db->query($sql);

		$result = $query->result_array();
		return $result;
	}


}