<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class XUMS {

	function __construct() {
	}

	public static function getUserState(){
		$sess = X::getUMSSession();
		if(empty($sess))
			return $sess;
		else{
			return $sess->UserState;
		}
	}

	public static function getPermission(){
		$sess = X::getUMSSession();
		if(empty($sess))
			return $sess;
		else{
			return $sess->Permission;
		}
	}

	public static function getLimit(){
		$sess = X::getUMSSession();
		if(empty($sess))
			return $sess;
		else{
			return $sess->Limit;
		}
	}

	public static function getCompany(){
		$sess = XUMS::getUserState();
		return $sess->comid;
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
		$limits = XUMS::getLimit();

		foreach($permissions AS $p){
			$exist = false;
			foreach($limits AS $l){
				if($p->docty==$l->docty){
					$exist = true; break;
				}
			}
			//if($exist)
		}
	}

}