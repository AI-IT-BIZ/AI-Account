<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

	function util_helper_get_time_by_date_string($dt_str){
		$dt_arr = strptime($dt_str, '%Y-%m-%d');
		$time = mktime(
			0,0,0,
			$dt_arr['tm_mon']+1,$dt_arr['tm_mday'],$dt_arr['tm_year'] + 1900
		);
		return $time;

	}

	function util_helper_format_date($dt_str, $format = 'd/m/Y'){
		$time = util_helper_get_time_by_date_string($dt_str);
		return date($format, $time);
	}