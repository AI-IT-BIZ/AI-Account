<?php
class Quotation extends CI_Controller {

	function __construct(){
		parent::__construct();
		
		$this->load->model('convert_amount','',TRUE);
	}
	
	public function pdf(){
		require_once substr(BASEPATH,0,-7).'application/libraries/jasper/rest/client/JasperClient.php';
		$client = new Jasper\JasperClient(JASPERSERVER,
						JASPERPORT,
					   JASPERUSER,
					   JASPERPASSWORD,
					   '/jasperserver'
				   );
		$vbeln = $_GET['vbeln'];
		$amnt = floatval($_GET['amtxt']);
		$amtxt = $this->convert_amount->generate(sprintf("%.3f", $amnt));
		//find Credate User
		$empnr = "";
		$this->db->where('vbeln',$vbeln);
		$result = $this->db->get('vbak');
		$array_result = $result->result_array();
		if(empty($array_result)){
			$empnr = XUMS::EMPLOYEE_ID();
		}
		else{
			$ernam=$array_result[0]['ernam'];
			$this->db->select('empnr');
			$this->db->where('uname',$ernam);
			$user = $this->db->get('user');
			$array_user = $user->result_array();
			$empnr = $array_user[0]['empnr'];
		}
		
		$controls = array('vbeln' => $vbeln,
						  'amtxt' => $amtxt,
						  'comid' => 1000,
						  'empnr' => $empnr);
		
		$report = $client->runReport('/ai_account/quotation', 'pdf',null,$controls);
		 
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
		
		
		$report = $client->runReport('/ai_account/rgeneraljournal', 'xlsx', null, $controls);
		 
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