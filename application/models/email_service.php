<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Email_service extends CI_Model {

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
			$emp_super = $this->get_super_emp($o->ernam);

			$emp_creater = $this->get_emp_by_username($o->ernam);

			$this->send_mail(array(
				'to'=>$emp_super->email,
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
			$emp_super = $this->get_emp_by_username($o->upnam);
			$emp_creater = $this->get_emp_by_username($o->ernam);

			// get new status text
			$status = $this->get_status_text($o->statu);

			$this->send_mail(array(
				'to'=>$emp_creater->email,
				'subject'=>'Quotation no: '.$o->vbeln.' has "'.$status.'".',
				'message'=>'Quotation no: '.$o->vbeln.' has "'.$status.'" at '.$o->updat
							.' by '.$emp_super->name1.'.'
			));
		}
	}
	// ***** END QUOTATION *****

}
