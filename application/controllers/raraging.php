<?php
class Raraging extends CI_Controller {

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
		
		$kunnr = "";
		if(trim($_GET['kunnr']) !== ""){
			$kunnr = " and (kunnr between '{$_GET['kunnr']}' and '{$_GET['kunnr2']}')";
		}
		
		$controls = array('kunnr' => $kunnr);
		
		//echo($kunnr); return;
		$report = $client->runReport('/ai_account/raraging', 'pdf', null, $controls);
		 
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