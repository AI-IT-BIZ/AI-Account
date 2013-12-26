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
				ifnull(tbl_glno.sgtxt,'') as sgtxt,
				ifnull(v_bcus.debit,'') as debit,
				ifnull(v_bcus.credi,'') as credi,
				ifnull(v_bcus.statu,'') as statu
			from 
				v_bkpf
				LEFT JOIN v_bcus on v_bcus.belnr = v_bkpf.belnr
				LEFT JOIN tbl_glno on v_bcus.saknr = tbl_glno.saknr
			where 
				v_bkpf.bldat BETWEEN '{$_POST['start_date']}' and '{$_POST['end_date']}'	
			ORDER BY v_bkpf.bldat ,v_bkpf.belnr desc
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
				floatval($v['debit']),
				floatval($v['credi']),
				$v['statu']
			);
		}
		$data['success'] = true;
		echo json_encode($data);
	}
	
	public function pdf(){
		$sd = explode('-',$_GET['start_date']);
		$ed = explode('-',$_GET['end_date']);
		require_once substr(BASEPATH,0,-7).'application/libraries/jasper/rest/client/JasperClient.php'; 
		$client = new Jasper\JasperClient(JASPERSERVER,
						JASPERPORT,
					   JASPERUSER,
					   JASPERPASSWORD,
					   '/jasperserver'
				   );
		$controls = array('start_date' => intval(mktime(0,0,0,intval($sd[1]),intval($sd[2]),intval($sd[0])))*1000,
						  'end_date' => intval(mktime(0,0,0,intval($ed[1]),intval($ed[2]),intval($ed[0])))*1000,
						  'comid' => 2000);
		
		$report = $client->runReport('/ai_account/rgeneraljournal', 'pdf', null, $controls);
		 
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Description: File Transfer');
		header('Content-Disposition: inline;');
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: ' . strlen($report));
		header('Content-Type: application/pdf');
		 
		echo $report;		
	}
}
?>