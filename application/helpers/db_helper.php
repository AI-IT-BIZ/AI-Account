<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

	function db_helper_is_mysql($_this){
		return ($_this->db->dbdriver=='mysql');
	}

	function db_helper_set_now($_this, $field){
		if(db_helper_is_mysql($_this)){
			$_this->db->set($field, 'NOW()', false);
		}else{
			// assume sqlserver
			$_this->db->set($field, 'GETDATE()', false);
		}
	}
