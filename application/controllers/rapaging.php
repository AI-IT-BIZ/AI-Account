<?php
class Rapaging extends CI_Controller {

	function __construct(){
		parent::__construct();
	}
	
	
	public function pdf(){
		require_once substr(BASEPATH,0,-7).'application/libraries/jasper/rest/client/JasperClient.php'; 
		$client = new Jasper\JasperClient(JASPERSERVER,
						JASPERPORT,
					   JASPERUSER,
					   JASPERPASSWORD,
					   '/jasperserver'
				   );
		
		$lifnr = "";
		if(trim($_GET['lifnr']) !== ""){
			$lifnr = " and (lifnr between '{$_GET['lifnr']}' and '{$_GET['lifnr2']}')";
		}
		
		$controls = array('lifnr' => $lifnr);
		
		//echo($lifnr); return;
		$report = $client->runReport('/ai_account/rapaging', 'pdf', null, $controls);
		 
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