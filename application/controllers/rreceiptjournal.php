<?php
class Rreceiptjournal extends CI_Controller {

	function __construct(){
		parent::__construct();
	}
	
	public function result(){
		$search = "";
		if ($_POST['kunnr'] != ""){
			$search = " and v_bkpf.kunnr like '%{$_POST['kunnr']}%' ";
		}
		if(db_helper_is_mysql($this)){
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
				ifnull(v_bcus.statu,'') as statu,
				ifnull(v_bkpf.kunnr,'') as kunnr
				
			from 
				v_bcus
				   LEFT JOIN v_bkpf on v_bcus.belnr = v_bkpf.belnr
				    LEFT JOIN tbl_glno on v_bcus.saknr = tbl_glno.saknr
			where 
				v_bkpf.bldat BETWEEN '{$_POST['start_date']}' and '{$_POST['end_date']}' and v_bcus.belnr like 'RV%' {$search}
			ORDER BY v_bkpf.bldat ,v_bkpf.belnr desc
		";
		}
		if(db_helper_is_mssql($this)){
		$sql = "
			select 
				isnull(v_bkpf.bldat,'') as bldat,
				isnull(v_bkpf.belnr,'') as belnr,
				isnull(v_bkpf.invnr,'') as invnr,
				isnull(v_bkpf.name1,'') as name1,
				isnull(v_bcus.saknr,'') as saknr,
				isnull(tbl_glno.sgtxt,'') as sgtxt,
				isnull(v_bcus.debit,0) as debit,
				isnull(v_bcus.credi,0) as credi,
				isnull(v_bcus.statu,'') as statu,
				isnull(v_bkpf.kunnr,'') as kunnr
				
			from 
				v_bcus
				   LEFT JOIN v_bkpf on v_bcus.belnr = v_bkpf.belnr
				    LEFT JOIN tbl_glno on v_bcus.saknr = tbl_glno.saknr
			where 
				v_bkpf.bldat BETWEEN '{$_POST['start_date']}' and '{$_POST['end_date']}' and v_bcus.belnr like 'RV%' {$search}
			ORDER BY v_bkpf.bldat ,v_bkpf.belnr desc
		";
		}
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
				$v['statu'],
				$v['kunnr']
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
		
		$kunnr = "";
		if(trim($_GET['kunnr']) !== ""){
			$kunnr = " and v_bkpf.kunnr like '%{$_GET['kunnr']}%' ";
		}
		$controls = array('start_date' => intval(mktime(0,0,0,intval($sd[1]),intval($sd[2]),intval($sd[0])))*1000,
						  'end_date' => intval(mktime(0,0,0,intval($ed[1]),intval($ed[2]),intval($ed[0])))*1000,
						  'comid' => 1000,  
						  'kunnr' => $kunnr);
		
		
		$report = $client->runReport('/ai_account/rreceiptjournal', 'pdf', null, $controls);
		 
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Description: File Transfer');
		header('Content-Disposition: inline;');
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: ' . strlen($report));
		header('Content-Type: application/pdf');
		 
		echo $report;		
	}

	public function excel(){
		$sd = explode('-',$_GET['start_date']);
		$ed = explode('-',$_GET['end_date']);
		require_once substr(BASEPATH,0,-7).'application/libraries/jasper/rest/client/JasperClient.php'; 
		$client = new Jasper\JasperClient(JASPERSERVER,
						JASPERPORT,
					   JASPERUSER,
					   JASPERPASSWORD,
					   '/jasperserver'
				   );
		
		$kunnr = "";
		if(trim($_GET['kunnr']) !== ""){
			$kunnr = " and v_bkpf.kunnr like '%{$_GET['kunnr']}%' ";
		}
		$controls = array('start_date' => intval(mktime(0,0,0,intval($sd[1]),intval($sd[2]),intval($sd[0])))*1000,
						  'end_date' => intval(mktime(0,0,0,intval($ed[1]),intval($ed[2]),intval($ed[0])))*1000,
						  'comid' => 1000,  
						  'kunnr' => $kunnr);
		
		
		$report = $client->runReport('/ai_account/rreceiptjournal', 'xlsx', null, $controls);
		 
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Description: File Transfer');
		header('Content-Disposition: inline;');
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: ' . strlen($report));
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		 
		echo $report;		
	}
}
?>