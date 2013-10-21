<?php

Class Code_model3 extends CI_Model
{
	function generate3($modul,$table,$pkey){
		$this->db->where('modul', $modul);

		$query_init = $this->db->get('init');
		$result_code = '';

		if($query_init->num_rows()>0){
			$result_init = $query_init->first_row('array');
			$min_code = '01';
			$min_code_length = strlen($min_code);
			$tb_name = $table;
			$tb_code = $pkey;
			$short_code = $result_init['short'];

			$sql = "SELECT ".$tb_code." FROM ".$tb_name." WHERE ".$pkey." LIKE '".$short_code."%'".
			" ORDER BY ".$tb_code." DESC LIMIT 1";
			$query_code = $this->db->query($sql);

			if($query_code->num_rows()>0){
				$result_code = $query_code->first_row('array');
				// หาเลขตัวหลัง
				$last_no = substr($result_code[$tb_code], $min_code_length*-1);
				$last_no = abs(intval($last_no))+1;

				return $short_code.str_pad($last_no, $min_code_length, '0', STR_PAD_LEFT);
			}else{

				return $short_code.$min_code;
			}
		}else{
			// could not find init configuration
			throw new Exception('could not find init configuration');
		}
	}

}
?>

