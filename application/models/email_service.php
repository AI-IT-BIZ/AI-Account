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
	WHERE l.limam>$amount_esc AND l.docty=$document_type_esc
	ORDER BY l.limam ASC LIMIT 1
)
";

		if($is_depend){
			// get employee department
			$this->empl->db->where("empnr=(SELECT u.empnr FROM tbl_user u WHERE u.uname=$creater_uname_esc)");
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
		$this->db->select('email,name1');
		$this->db->where("empnr=(SELECT u.empnr FROM tbl_user u WHERE u.uname=".$this->db->escape($username).")");
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

	// ***** QUOTATION *****
	public function quotation_create($id){
		// load quotation
		$query = $this->db->get_where('vbak', array(
			'vbeln'=>$id
		));
		if($query->num_rows()==1){
			$o = $query->first_row();

			// get involved employee
			$emails = $this->get_email('QT', $o->netwr, $o->ernam);
			$emp_creater = $this->get_emp_by_username($o->ernam);

			if(count($emails)>0)
				$this->send_mail(array(
					'to'=>implode(',', $emails),
					'subject'=>'Quotation no: '.$o->vbeln.' has created.',
					'message'=>'Quotation no: '.$o->vbeln.' has created at '.$o->erdat
								.' by '.$emp_creater->name1.' and wating for approve'
				));
		}
	}

	public function quotation_change_status($id){
		// load quotation
		$query = $this->db->get_where('vbak', array(
			'vbeln'=>$id
		));
		if($query->num_rows()==1){
			$o = $query->first_row();

			// get involved employee
			$emails = $this->get_email('QT', $o->netwr, $o->ernam);
			$emp_creater = $this->get_emp_by_username($o->ernam);

			// get new status text
			$status = $this->get_status_text($o->statu);

			$this->send_mail(array(
				'to'=>$emp_creater->email,
				'subject'=>'Quotation no: '.$o->vbeln.' has "'.$status.'".',
				'message'=>'Quotation no: '.$o->vbeln.' has "'.$status.'" at '.$o->updat
							.' by '.$emp_creater->name1.'.'
			));
		}
	}
	// ***** END QUOTATION *****
}
