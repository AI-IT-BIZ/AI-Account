<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class X {

	function __construct() {
	}

	public static function toJSON($o){
		return json_encode($o);
	}
	public static function renderJSON($o){
		$_CI = &get_instance();
		$_CI->output
		    ->set_content_type('application/json')
		    ->set_output(X::toJSON($o));
	}

	// base session
	public static function getSession($key){
		$_CI = &get_instance();
		return $_CI->session->userdata($key);
	}
	public static function setSession($key,$value){
		$_CI = &get_instance();
		return $_CI->session->set_userdata($key,$value);
	}
	public static function unsetSession($key){
		$_CI = &get_instance();
		return $_CI->session->unset_userdata($key);
	}
	public static function getValue($val,$default){
		return (isset($val)&&trim($val)!='')?$val:$default;
	}

	// ums session
	public static function getUMSSession(){
		$str = X::getSession('currentStateJson');
		return json_decode($str);
	}
	public static function setUMSSession($value){
		return X::setSession('currentStateJson', $value);
	}

}