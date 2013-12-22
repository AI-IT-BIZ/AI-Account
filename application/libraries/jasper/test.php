<?php
require_once "rest/client/JasperClient.php";
 
$client = new Jasper\JasperClient('localhost',
				8080,
			   'jasperadmin',
			   'jasperadmin',
			   '/jasperserver'
		   );

$controls = array('start_date' => intval(mktime(0,0,0,12,8,2013))*1000,
                  'end_date' => intval(mktime(0,0,0,12,8,2013))*1000,
				  'comid' => 2000);

$report = $client->runReport('/ai_account/test', 'pdf', null, $controls);
 
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Description: File Transfer');
header('Content-Disposition: inline;');
header('Content-Transfer-Encoding: binary');
header('Content-Length: ' . strlen($report));
header('Content-Type: application/pdf');
 
echo $report;



		   
		   

?>