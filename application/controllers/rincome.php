<?php
class RIncome extends CI_Controller {

	function __construct(){
		parent::__construct();
	}
		
	public function pdf(){
		$sd1 = explode('-',$_GET['start_date1']);
		$ed1 = explode('-',$_GET['end_date1']);
		$sd2 = explode('-',$_GET['start_date2']);
		$ed2 = explode('-',$_GET['end_date2']);
		require_once substr(BASEPATH,0,-7).'application/libraries/jasper/rest/client/JasperClient.php'; 
		$client = new Jasper\JasperClient(JASPERSERVER,
						JASPERPORT,
					   JASPERUSER,
					   JASPERPASSWORD,
					   '/jasperserver'
				   );
		$controls = array('start_date1' => intval(mktime(0,0,0,intval($sd1[1]),intval($sd1[2]),intval($sd1[0])))*1000,
						  'end_date1' => intval(mktime(0,0,0,intval($ed1[1]),intval($ed1[2]),intval($ed1[0])))*1000,
						  'start_date2' => intval(mktime(0,0,0,intval($sd2[1]),intval($sd2[2]),intval($sd2[0])))*1000,
						  'end_date2' => intval(mktime(0,0,0,intval($ed2[1]),intval($ed2[2]),intval($ed2[0])))*1000);
		
		$report = $client->runReport('/ai_account/rincome', 'pdf', null, $controls);
		 
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