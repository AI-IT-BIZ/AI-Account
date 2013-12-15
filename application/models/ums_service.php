<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ums_service extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
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

}