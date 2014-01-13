<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Email_service extends CI_Model {

	function __construct()
	{
		parent::__construct();

		$this->load->model('autl_model','autl',TRUE);
		$this->load->model('autd_model','autd',TRUE);
		$this->load->model('autu_model','autu',TRUE);
		$this->load->model('empl_model','empl',TRUE);
	}

	private function send_mail($mail_data){

		//print_r($mail_data);

		$this->load->library('email');
		$result = $this->email
					->from('kitipong@primebiznets.com')
					->to($mail_data['to'])
					//->to('khemmac@gmail.com')
					->cc('khemmac@gmail.com')
					->subject($mail_data['subject'])
					->message($mail_data['message'])
					->send();
		return $result;
	}

	private function get_email($document_type, $amount, $creater_uname){
		// prepare var
		$comid = XUMS::COMPANY_ID();
		$comid_esc = $this->db->escape($comid);
		$document_type_esc = $this->db->escape($document_type);
		$amount_esc = $this->db->escape($amount);
		$creater_uname_esc = $this->db->escape($creater_uname);

		// check if depend on department
		$d = $this->autd->get_by(array(
			'docty'=>$document_type
		));

		if(empty($d)){
			// not set limit
			return;
		}

		$is_depend = !empty($d) && $d->depdp=='1';

		$mail_list = array();

		$sql = "
SELECT
e.depnr,
 e.email, e.name1
, al.limam, al.autlid, al.docty
FROM tbl_autu au
INNER JOIN tbl_autl al ON au.autlid=al.autlid
INNER JOIN tbl_empl e ON au.empnr=e.empnr
WHERE al.autlid=(
	SELECT l.autlid FROM tbl_autl l
	WHERE (l.limam>=$amount_esc OR l.limam=0) AND l.docty=$document_type_esc
	ORDER BY l.limam ASC LIMIT 1
)
";

		if($is_depend){
			// get employee department
			$this->empl->db->where("empnr=(SELECT u.empnr FROM tbl_user u WHERE u.uname=$creater_uname_esc AND comid=$comid_esc)");
			$emp = $this->empl->get_by();
			if(empty($emp) || empty($emp->depnr)) return;

			// get limit of document
			$dept_esc = $this->db->escape($emp->depnr);
			$sql .= " AND e.depnr=$dept_esc";
			$q_mail = $this->db->query($sql);
			$mail_list = $q_mail->result();
		}else{
			// not depend on  department
			// get limit of document
			$q_mail = $this->db->query($sql);
			$mail_list = $q_mail->result();
		}
		//print_r($mail_list->result());
		$mail_arr = array();
		foreach($mail_list AS $m){
			if(!empty($m->email))
				array_push($mail_arr, $m->email);
		}
		return $mail_arr;
	}
	
	private function get_email_change_status($document_type, $amount, $creater_uname){
		// prepare var
		$comid = XUMS::COMPANY_ID();
		$comid_esc = $this->db->escape($comid);
		$document_type_esc = $this->db->escape($document_type);
		$amount_esc = $this->db->escape($amount);
		$creater_uname_esc = $this->db->escape($creater_uname);

		// check if depend on department
		$d = $this->autd->get_by(array(
			'docty'=>$document_type
		));

		if(empty($d)){
			// not set limit
			return;
		}

		$is_depend = !empty($d) && $d->depdp=='1';

		$mail_list = array();

		$sql = "
SELECT
e.depnr,
 e.email, e.name1
, al.limam, al.autlid, al.docty
FROM tbl_autu au
INNER JOIN tbl_autl al ON au.autlid=al.autlid
INNER JOIN tbl_empl e ON au.empnr=e.empnr
WHERE al.autlid=(
	SELECT l.autlid FROM tbl_autl l
	WHERE (l.limam>=$amount_esc OR l.limam=0) AND l.docty=$document_type_esc
	ORDER BY l.limam ASC LIMIT 1
)
";

		if($is_depend){
			// get employee department
			$this->empl->db->where("empnr=(SELECT u.empnr FROM tbl_user u WHERE u.uname=$creater_uname_esc AND comid=$comid_esc)");
			$emp = $this->empl->get_by();
			if(empty($emp) || empty($emp->depnr)) return;

			// get limit of document
			$dept_esc = $this->db->escape($emp->depnr);
			$sql .= " AND e.depnr=$dept_esc";
			$q_mail = $this->db->query($sql);
			$mail_list = $q_mail->result();
		}else{
			// not depend on  department
			// get limit of document
			$q_mail = $this->db->query($sql);
			$mail_list = $q_mail->result();
		}
		//print_r($mail_list->result());
		$mail_arr = array();
		foreach($mail_list AS $m){
			if(!empty($m->email))
				array_push($mail_arr, $m->email);
		}
		//Get Creater Email
		$sql2 = "
SELECT b.email
FROM tbl_user a
LEFT JOIN tbl_empl b ON a.empnr=b.empnr
WHERE uname = '$creater_uname'
";
		$c_mail = $this->db->query($sql2);
		$mail_list2 = $c_mail->result();
		foreach($mail_list2 AS $m){
			if(!empty($m->email))
				array_push($mail_arr, $m->email);
		return $mail_arr;
		}
	}

/*
	private function get_super_emp($username){
		$this->db->select('email,name1');
		$this->db->where("empnr=(
SELECT e.supnr FROM tbl_empl e
WHERE e.empnr=(SELECT u.empnr FROM tbl_user u WHERE u.uname=".$this->db->escape($username).")
)");
		$q = $this->db->get('empl');
		if($q->num_rows()>0){
			$o = $q->first_row();
			return $o;
		}
		else
			return FALSE;
	}
*/

	private function get_emp_by_username($username){
		$username_esc = $this->db->escape($username);
		$comid = XUMS::COMPANY_ID();
		$comid_esc = $this->db->escape($comid);
		$this->db->select('email,name1');
		$this->db->where("empnr=(SELECT u.empnr FROM tbl_user u WHERE u.uname=$username_esc AND comid=$comid_esc)");
		$q = $this->db->get('empl');
		if($q->num_rows()>0){
			$o = $q->first_row();
			return $o;
		}
		else
			return FALSE;
	}

	private function get_status_text($status){
		$this->db->select('statx');
		$q = $this->db->get_where('apov', array(
			'statu'=>$status
		));
		if($q->num_rows()==1){
			$o = $q->first_row();
			return $o->statx;
		}else
			return 'Unknown';
	}

	public function sendmail_create($module_code, $module_name,
									$row_code, $amount,
									$create_user
									){
		$action_user = XUMS::USERNAME();
		$action_date = date('d/m/Y H:i:s');

		if(empty($module_code)) return;
		try{
			// get involved employee
			$emails = $this->get_email($module_code, $amount, $create_user);
			if(empty($emails)) return;
			
			$emp_action_user = $this->get_emp_by_username($action_user);
			$emp_action_name = (!empty($emp_action_user))?$emp_action_user->name1:'Unknown';

			$this->send_mail(array(
				'to'=>implode(',', $emails),
				'subject'=>"$module_name no: $row_code has created.",
				'message'=>"$module_name no: $row_code has created at $action_date"
							." by $emp_action_name and wating for approve"
			));

		}catch(exception $e){
			// do nothing
		}
	}

	public function sendmail_change_status($module_code, $module_name,
									$row_code, $amount, $status,
									$create_user
									){
		$action_user = XUMS::USERNAME();
		$action_date = date('d/m/Y H:i:s');
		
		if(empty($module_code)) return;
		//echo PHP_EOL.'MODULE CODE: '.$module_code.PHP_EOL;
		//echo PHP_EOL.'ROW CODE: '.$row_code.PHP_EOL;
		try{
			// get involved employee
			$emails = $this->get_email_change_status($module_code, $amount, $create_user);
			//echo 'CREATE USER: '.$create_user.PHP_EOL;
			//echo 'EMAILS: '.PHP_EOL;
			if(empty($emails)) return;

			// get new status text
			$status_text = $this->get_status_text($status);

			$emp_action_user = $this->get_emp_by_username($action_user);
			$emp_action_name = (!empty($emp_action_user))?$emp_action_user->name1:'Unknown';

			$this->send_mail(array(
				'to'=>implode(',', $emails),
				'subject'=>"$module_name no: $row_code has $status_text.",
				'message'=>"$module_name no: $row_code has $status_text at $action_date"
							." by $emp_action_name."
			));

		}catch(exception $e){
			// do nothing
		}
	}

}
