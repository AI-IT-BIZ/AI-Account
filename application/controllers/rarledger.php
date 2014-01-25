<?php
class RarLedger extends CI_Controller {

	function __construct(){
		parent::__construct();
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
			$kunnr = " and kunnr between '{$_GET['kunnr']}' and '{$_GET['kunnr2']}'";
		}
		if(trim($_GET['statu']) !== "ALL"){
			$kunnr = $kunnr. " and statx like '%{$_GET['statu']}%'";
		}
		$controls = array('start_date' => intval(mktime(0,0,0,intval($sd[1]),intval($sd[2]),intval($sd[0])))*1000,
						  'end_date' => intval(mktime(0,0,0,intval($ed[1]),intval($ed[2]),intval($ed[0])))*1000,
						  'kunnr' => $kunnr);
		
		//echo($kunnr); return;
		$report = $client->runReport('/ai_account/rarledger', 'pdf', null, $controls);
		 
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