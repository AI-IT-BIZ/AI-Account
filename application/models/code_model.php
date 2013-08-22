<?php
Class Code_model extends CI_Model
{
	function generate($modul, $date){
		$this->db->where('modul', $modul);

		$query_init = $this->db->get('init');

		$result_code = '';

		if($query_init->num_rows()>0){
			$result_init = $query_init->first_row('array');
			$min_code = $result_init['minnr'];
			$min_code_length = strlen($min_code);

			$short_code = $result_init['short'];

			$sql = "SELECT code, CONCAT(?, RIGHT(YEAR(?),2) ,LPAD(MONTH(?), 2, '0')) AS prefix FROM tbl_pr
WHERE code LIKE (SELECT CONCAT(?, RIGHT(YEAR(?),2) ,LPAD(MONTH(?), 2, '0'), '%'))
ORDER BY id DESC
LIMIT 1";
			$query_code = $this->db->query($sql, array(
				$short_code, $date, $date,
				$short_code, $date, $date
			));

			if($query_code->num_rows()>0){
				$result_code = $query_code->first_row('array');
				// หาเลขตัวหลัง
				$last_no = substr($result_code['code'], $min_code_length*-1);
				$last_no = abs(intval($last_no))+1;

				return $result_code['prefix'].'-'.str_pad($last_no, $min_code_length, '0', STR_PAD_LEFT);
			}else{
				$sql = "SELECT CONCAT(?, RIGHT(YEAR(?),2) ,LPAD(MONTH(?), 2, '0')) AS prefix";
				$query_prefix = $this->db->query($sql, array(
					$short_code, $date, $date
				));
				if($query_prefix->num_rows()>0){
					$result_prefix = $query_prefix->first_row('array');
					return $result_prefix['prefix'].'-'.$min_code;
				}else
					throw new Exception('could not build prefix with mysql');
			}
		}else{
			// could not find init configuration
			throw new Exception('could not find init configuration');
		}
	}

}