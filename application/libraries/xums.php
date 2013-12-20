<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class XUMS {

	function __construct() {
	}

	public static function getUserState(){
		$sess = X::getUMSSession();
		if(empty($sess))
			return $sess;
		else
			return $sess->UserState;
	}

	public static function USERNAME(){
		$us = XUMS::getUserState();
		if(empty($us))
			return $us;
		else
			return $us->uname;
	}

	public static function DISPLAYNAME(){
		$us = XUMS::getUserState();
		if(empty($us))
			return $us;
		else
			return $us->name1;
	}

	public static function COMPANY_ID(){
		$us = XUMS::getUserState();
		if(empty($us))
			return $us;
		else
			return $us->comid;
	}

	public static function getPermission(){
		$sess = X::getUMSSession();
		if(empty($sess))
			return $sess;
		else{
			return $sess->Permission;
		}
	}

	// return list of authorize limit value
	public static function getLimits(){
		$sess = X::getUMSSession();
		if(empty($sess))
			return $sess;
		else{
			return $sess->Limit;
		}
	}

	private static function checkPermission($docty, $type){
		$permissions = XUMS::getPermission();
		if(!empty($permissions)){
			$have = false;
			foreach($permissions AS $p){
				$classname = "p";
				if($$classname->{$type}==1 && $p->docty==$docty){
					$have = true; break;
				}
			}
			return $have;
		}else
			return false;
	}

	public static function CAN_DISPLAY($docty){ return XUMS::checkPermission($docty, 'display'); }
	public static function CAN_CREATE($docty){ return XUMS::checkPermission($docty, 'create'); }
	public static function CAN_EDIT($docty){ return XUMS::checkPermission($docty, 'edit'); }
	public static function CAN_DELETE($docty){ return XUMS::checkPermission($docty, 'delete'); }
	public static function CAN_EXPORT($docty){ return XUMS::checkPermission($docty, 'export'); }
	public static function CAN_APPROVE($docty){ return XUMS::checkPermission($docty, 'approve'); }

	public static function LIMIT($docty){
		$permissions = XUMS::getPermission();
		$limits = XUMS::getLimits();

		foreach($permissions AS $p){
			$exist = false;
			$l_val = -1;
			foreach($limits AS $l){
				if($docty==$l->docty
					&& XUMS::CAN_DISPLAY($docty)
					&& XUMS::CAN_APPROVE($docty)){
					$exist = true;
					$l_val = $l->limam;
					break;
				}
			}
			if($exist){
				if($l_val==0)
					return 9999999999;
				else
					return $l_val;
			}else{
				return 0;
			}
		}
	}

}