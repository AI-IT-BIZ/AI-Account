<?php
class PrintCheque2 extends CI_Controller {

	function __construct(){
		parent::__construct();
		
		$this->load->model('convert_amount','',TRUE);
	}
	
	
	public function pdf(){
		//Prepare Data
		$strSQL = " select v_paym.*";
        $strSQL = $strSQL . " from v_paym ";
        $strSQL = $strSQL . " Where v_paym.recnr = '{$_GET['payno']}'  ";
		$strSQL = $strSQL . " And v_paym.ptype = '05'  ";
        $strSQL .= "ORDER BY paypr ASC";
		
		$payno = $_GET['payno'];
				
		$q_pay = $this->db->query($strSQL);
		$r_pay = $q_pay->first_row('array');
		
		$text_amt = $this->convert_amount->generate($r_pay['payam']);
		
		$chq_date = $r_pay['chqdt'];
		require_once substr(BASEPATH,0,-7).'application/libraries/jasper/rest/client/JasperClient.php';
		$client = new Jasper\JasperClient(JASPERSERVER,
						JASPERPORT,
					   JASPERUSER,
					   JASPERPASSWORD,
					   '/jasperserver'
				   );
				
		$controls = array('payno' => $payno,
						  'txtamt' => $text_amt,
		 			  'datestr' => $chq_date);
		
		//echo($lifnr); return;
		$report = $client->runReport('/ai_account/printcheque', 'pdf',null,$controls);
		 
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Description: File Transfer');
		header('Content-Disposition: inline;');
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: ' . strlen($report));
		header('Content-Type: application/pdf');
		 
		echo $report;		
	}

	/*public function excel(){
		$sd = explode('-',$_GET['start_date']);
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
			$kunnr = " and (kunnr between '{$_GET['lifnr']}' and '{$_GET['lifnr2']}')";
		}
		
		$controls = array('start_date' => intval(mktime(0,0,0,intval($sd[1]),intval($sd[2]),intval($sd[0])))*1000,
						  'end_date' => intval(mktime(0,0,0,intval($ed[1]),intval($ed[2]),intval($ed[0])))*1000,
						  'comid' => 1000,
						  'lifnr' => $lifnr);
		
		//echo($lifnr); return;
		$report = $client->runReport('/ai_account/rapaging', 'xlsx', null, $controls);
		 
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Description: File Transfer');
		header('Content-Disposition: inline;');
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: ' . strlen($report));
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		 
		echo $report;		
	}*/

}
?>