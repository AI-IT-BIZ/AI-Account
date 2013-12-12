<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

	function util_helper_get_time_by_date_string($dt_str){
		$unix = mysql_to_unix($dt_str);
		return $unix;

	}

	function util_helper_format_date($dt_str, $format = 'd/m/Y'){
		$time = util_helper_get_time_by_date_string($dt_str);
		return date($format, $time);
	}
	
	function util_helper_get_sql_between_month($dt_str){
		$time = mysql_to_unix($dt_str);
		
		$dt_start = date("Y-m-d", mktime(0, 0, 0, date("m", $time), 1, date("Y", $time)));
		$dt_end = date("Y-m-d", mktime(0, 0, 0, date("m", $time)+1, 0, date("Y", $time)));
		
		return "between '$dt_start' AND '$dt_end'";

	}