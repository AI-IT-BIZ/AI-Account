<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

	function util_helper_get_time_by_date_string($dt_str){
		$unix = mysql_to_unix($dt_str);
		return $unix;

	}

	function util_helper_format_date($dt_str, $format = 'd/m/Y'){
		$time = util_helper_get_time_by_date_string($dt_str);
		return date($format, $time);
	}