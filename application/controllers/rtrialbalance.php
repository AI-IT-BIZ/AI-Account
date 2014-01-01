<?php
class RTrialBalance extends CI_Controller {

	function __construct(){
		parent::__construct();
	}
	
	public function result()
	{		
		$sql = "SELECT resault.saknr, resault.sgtxt,
				(CASE WHEN resault.debit>0 THEN resault.debit ELSE '' END) as debit,
				(CASE WHEN resault.credi>0 THEN resault.credi ELSE '' END) as credi,
				(select tbl_comp.name1 from tbl_comp where comid = '1000') as comp
				from(
					select a.saknr, a.sgtxt,
					(sum(b.debit)-sum(b.credi))as debit,
					(sum(b.credi)-sum(b.debit))as credi,
	 				b.bldat
					from tbl_glno as a
							left join v_uacc as b on a.saknr = b.saknr
					where b.bldat between '{$_POST['start_date']}' and '{$_POST['end_date']}' or isnull(b.bldat)
					group by a.saknr
				)as resault";
		$rs = $this->db->query($sql);
		$rs = $rs->result_array();
		$data = array();
		$data['datas'] = array();
		foreach ($rs as $v) {
			$data['datas'][] = array(
				$v['saknr'],
				$v['sgtxt'],
				$v['debit'],
				$v['credi']
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
		$controls = array('start_date' => intval(mktime(0,0,0,intval($sd[1]),intval($sd[2]),intval($sd[0])))*1000,
						  'end_date' => intval(mktime(0,0,0,intval($ed[1]),intval($ed[2]),intval($ed[0])))*1000);
		
		$report = $client->runReport('/ai_account/rtrialbalance', 'pdf', null, $controls);
		 
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