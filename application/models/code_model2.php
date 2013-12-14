<?php

Class Code_model2 extends CI_Model
{
	function generate2($modul){
		$this->db->where('modul', $modul);

		$query_init = $this->db->get('init');

		$result_code = '';
		if($query_init->num_rows()>0){
			$result_init = $query_init->first_row('array');
			$min_code = $result_init['minnr'];
			$min_code_length = strlen($min_code);

			$short_code = $result_init['short'];
			
			$tb_name = $result_init['tname'];
			$tb_code = $result_init['tcode'];
			$prefix  = $result_init['short'];
			
			$sql = "SELECT ".$tb_code." FROM ".$tb_name.
			" WHERE ".$tb_code." LIKE '".$prefix."%'"
			." ORDER BY ".$tb_code." DESC LIMIT 1";
			$query_code = $this->db->query($sql);
            
			if($query_code->num_rows()>0){
				$result_code = $query_code->first_row('array');
				// หาเลขตัวหลัง
				if($modul=='CP'){
					//$last_no = substr($result_code[$tb_code], $min_code_length*-1);
				    $last_no = abs(intval($result_code[$tb_code]))+1000;
					return $last_no;
				}else{
				    $last_no = substr($result_code[$tb_code], $min_code_length*-1);
				    $last_no = abs(intval($last_no))+1;
					return $prefix.str_pad($last_no, $min_code_length, '0', STR_PAD_LEFT);
				}

				
			}else{
				if($modul=='CP')
				return $min_code;
				else
				return $prefix.$min_code;
			}
		}else{
			// could not find init configuration
			throw new Exception('could not find init configuration');
		}
	}
}
?>

