<?php
class RapLedger extends CI_Controller {

	function __construct(){
		parent::__construct();
	}
	
	
	public function pdf(){
		$ed = explode('-',$_GET['end_date']);
		require_once substr(BASEPATH,0,-7).'application/libraries/jasper/rest/client/JasperClient.php'; 
		$client = new Jasper\JasperClient(JASPERSERVER,
						JASPERPORT,
					   JASPERUSER,
					   JASPERPASSWORD,
					   '/jasperserver'
				   );
		
		$lifnr = "";
		if(trim($_GET['lifnr']) !== ""){
			$lifnr = " and lifnr between '{$_GET['lifnr']}' and '{$_GET['lifnr2']}'";
		}
		if(trim($_GET['statu']) !== "ALL"){
			$lifnr = $lifnr. " and statx like '%{$_GET['statu']}%'";
		}
		$controls = array('end_date' => intval(mktime(0,0,0,intval($ed[1]),intval($ed[2]),intval($ed[0])))*1000,
						  'lifnr' => $lifnr);
		
		$report = $client->runReport('/ai_account/rapledger', 'pdf', null, $controls);
		 
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
		$ed = explode('-',$_GET['end_date']);
		require_once substr(BASEPATH,0,-7).'application/libraries/jasper/rest/client/JasperClient.php'; 
		$client = new Jasper\JasperClient(JASPERSERVER,
						JASPERPORT,
					   JASPERUSER,
					   JASPERPASSWORD,
					   '/jasperserver'
				   );
		
		$lifnr = "";
		if(trim($_GET['lifnr']) !== ""){
			$lifnr = " and lifnr between '{$_GET['lifnr']}' and '{$_GET['lifnr2']}'";
		}
		if(trim($_GET['statu']) !== "ALL"){
			$lifnr = $lifnr. " and statx like '%{$_GET['statu']}%'";
		}
		$controls = array('end_date' => intval(mktime(0,0,0,intval($ed[1]),intval($ed[2]),intval($ed[0])))*1000,
						  'lifnr' => $lifnr);
		
		$report = $client->runReport('/ai_account/rapledger', 'xls', null, $controls);
		 
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Description: File Transfer');
		header('Content-Disposition: inline;');
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: ' . strlen($report));
		header('Content-Type: application/vnd.ms-excel');
		 
		echo $report;		
	}
}
?>