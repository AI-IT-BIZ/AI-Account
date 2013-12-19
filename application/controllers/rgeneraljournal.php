<?php
class Rgeneraljournal extends CI_Controller {

	function __construct(){
		parent::__construct();
	}
	
	public function result(){
		$sql = "
			select 
				ifnull(v_bkpf.bldat,'') as bldat,
				ifnull(v_bkpf.belnr,'') as belnr,
				ifnull(v_bkpf.invnr,'') as invnr,
				ifnull(v_bkpf.name1,'') as name1,
				ifnull(v_bcus.saknr,'') as saknr,
				ifnull(v_bcus.sgtxt,'') as sgtxt,
				ifnull(v_bcus.debit,'') as debit,
				ifnull(v_bcus.credi,'') as credi,
				ifnull(v_bcus.statu,'') as statu
			from 
				v_bkpf 
				LEFT JOIN v_bcus on v_bcus.belnr = v_bkpf.belnr
			where 
				v_bkpf.bldat BETWEEN '{$_POST['start_date']}' and '{$_POST['end_date']}'
			ORDER BY v_bkpf.belnr,v_bkpf.bldat		
		";
		$rs = $this->db->query($sql);
		$rs = $rs->result_array();
		$data = array();
		$data['datas'] = array();
		foreach ($rs as $v) {
			$data['datas'][] = array(
				$v['bldat'],
				$v['belnr'],
				$v['invnr'],
				$v['name1'],
				$v['saknr'],
				$v['sgtxt'],
				$v['debit'],
				$v['credi'],
				$v['statu']
			);
		}
		$data['success'] = true;
		echo json_encode($data);
	}
}
?>