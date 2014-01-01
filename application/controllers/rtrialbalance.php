<?php
class RTrialBalance extends CI_Controller {

	function __construct(){
		parent::__construct();
	}
	
	public function result()
	{
		function summarydata($array_master){
			
		for($i=0;$i<count($array_master);$i++){
			if($array_master[$i]['sum(b.debit)']>$array_master[$i]['sum(b.credi)']){
				$array_master[$i]['sum(b.debit)']=(float)$array_master[$i]['sum(b.debit)']-(float)$array_master[$i]['sum(b.credi)'];
				$array_master[$i]['sum(b.credi)']="";
			}
			else if ($array_master[$i]['sum(b.credi)']>$array_master[$i]['sum(b.debit)']){
				$array_master[$i]['sum(b.credi)']=(float)$array_master[$i]['sum(b.credi)']-(float)$array_master[$i]['sum(b.debit)'];
				$array_master[$i]['sum(b.debit)']="";
			}
			else {
				$array_master[$i]['sum(b.debit)']="";
				$array_master[$i]['sum(b.credi)']="";
			}
		}
		print_r($array_master);
		return;
		//return($array_master);
		}
			
		$sql = "select a.saknr, a.sgtxt, sum(b.debit), sum(b.credi), b.bldat
				from tbl_glno as a 
				left join v_uacc as b on a.saknr = b.saknr
				where b.bldat between '{$_POST['start_date']}' and '{$_POST['start_date']}' or isnull(b.bldat)
				group by a.saknr";
		$rs = $this->db->query($sql);
		$rs = $rs->result_array();
		$data = array();
		$data['datas'] = array();
		foreach ($rs as $v) {
			$data['datas'][] = array(
				$v['saknr'],
				$v['sgtxt'],
				$v['sum(b.debit)'],
				$v['sum(b.credi)']
			);
		}
		
		//Summary Debit and Credit
		//summarydata($rs);
		summarydata($rs);
		
		$data['success'] = true;
		//print_r($data['datas']);
		return;
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