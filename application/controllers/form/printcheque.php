<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Printcheque extends CI_Controller {
        public $query;
    public $strSQL;
	function __construct()
	{
		parent::__construct();

		$this->load->model('convert_amount','',TRUE);
	}
	
	function index()
	{
		$comid = XUMS::COMPANY_ID();
		$strSQL="";//echo $comid;
		$strSQL= " select tbl_comp.* from tbl_comp where tbl_comp.comid = '".$comid."'";
		$q_com = $this->db->query($strSQL);
		$r_com = $q_com->first_row('array');
		if($q_com->num_rows()>0){
		
		$no = $type = $this->uri->segment(4);
		$copies = intval($type = $this->uri->segment(5));
		if($copies<=0) $copies = 1;
		
		$strSQL = " select v_ebbk.*";
        $strSQL = $strSQL . " from v_ebbk ";
        $strSQL = $strSQL . " Where v_ebbk.payno = '$no'  ";
		
		$query = $this->db->query($strSQL);
		$r_data = $query->first_row('array');
		
		$strSQL = " select v_paym.*";
        $strSQL = $strSQL . " from v_paym ";
        $strSQL = $strSQL . " Where v_paym.recnr = '$no'  ";
		$strSQL = $strSQL . " And v_paym.ptype = '05'  ";
        $strSQL .= "ORDER BY paypr ASC";
		
		$q_pay = $this->db->query($strSQL);
		$r_pay = $q_pay->first_row('array');
		if($q_pay->num_rows()>0){
		// calculate sum
		$rows = $query->result_array();
		$b_amt = 0;
		//$v_amt = 0;
		//foreach ($rows as $key => $item) {
			//$itamt = 0;
			//$itamt = $item['menge'] * $item['unitp'];
			//$itamt = $itamt - $item['disit'];
			//$b_amt += $item['itamt'];
			//$v=0;
			//if(!empty($r_data['chk01']))
			//{
			//   $v = $itamt * $r_data['taxpr'];
			//   $v = $v / 100;
			//   $v_amt += $v;
			//}
		//}

		//function check_page($page_index, $total_page, $value){
		//	return ($page_index==0 && $total_page>1)?"":$value;
		//}
        ?>
<HTML xmlns="http://www.w3.org/1999/xhtml">
	<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script>

 ie4up=nav4up=false;
 var agt = navigator.userAgent.toLowerCase();
 var major = parseInt(navigator.appVersion);
 if ((agt.indexOf('msie') != -1) && (major >= 4))
   ie4up = true;
 if ((agt.indexOf('mozilla') != -1)  && (agt.indexOf('spoofer') == -1) && (agt.indexOf('compatible') == -1) && ( major>= 4))
   nav4up = true;
</script>

<script type="text/javascript">
	function do_print() {
		window.print()
	}
</script>

<STYLE>
body { font-family: 'Angsana New'; }
 A {text-decoration:none}
 A IMG {border-style:none; border-width:0;}
 DIV {position:absolute; z-index:25;}
.fc1-0 { COLOR:000000;FONT-SIZE:15PT;FONT-FAMILY:'Angsana New';FONT-WEIGHT:BOLD;}
.fc1-1 { COLOR:000000;FONT-SIZE:16PT;FONT-FAMILY:'Angsana New';FONT-WEIGHT:BOLD;}
.fc1-2 { COLOR:0000FF;FONT-SIZE:13PT;FONT-FAMILY:'Angsana New';FONT-WEIGHT:BOLD;}
.fc1-3 { COLOR:000000;FONT-SIZE:13PT;FONT-WEIGHT:NORMAL;}
.fc1-4 { COLOR:0000FF;FONT-SIZE:12PT;FONT-WEIGHT:NORMAL;}
.fc1-5 { COLOR:0000FF;FONT-SIZE:11PT;FONT-WEIGHT:NORMAL;}
.fc1-6 { COLOR:000000;FONT-SIZE:13PT;FONT-WEIGHT:NORMAL;}
.fc1-7 { COLOR:000000;FONT-SIZE:25PX;FONT-WEIGHT:NORMAL;}
.fc1-8 { COLOR:000000;FONT-SIZE:13PT;FONT-WEIGHT:NORMAL;}
.fc1-9 { COLOR:000000;FONT-SIZE:13PT;FONT-WEIGHT:NORMAL;}
.fc1-10 { COLOR:000000;FONT-SIZE:13PT;FONT-FAMILY:'Angsana New';}
.fc1-11 { COLOR:0000FF;FONT-SIZE:9PT;FONT-WEIGHT:NORMAL;}
.fc1-12 { COLOR:0000FF;FONT-SIZE:11PT;FONT-WEIGHT:NORMAL;}
.ad1-0 {border-color:000000;border-style:none;border-bottom-width:0PX;border-left-width:0PX;border-top-width:0PX;border-right-width:0PX;}
.ad1-1 {border-color:000000;border-style:none;border-bottom-width:0PX;border-left-width:0PX;border-top-width:0PX;border-right-width:0PX;}
.ad1-2 {border-color:0000FF;border-style:none;border-bottom-width:0PX;border-left-style:solid;border-left-width:1PX;border-top-width:0PX;border-right-width:0PX;}
.ad1-3 {border-color:0000FF;border-style:none;border-bottom-width:0PX;border-left-width:0PX;border-top-style:solid;border-top-width:1PX;border-right-width:0PX;}
.ad1-4 {border-color:0000FF;border-style:none;border-bottom-width:0PX;border-left-width:0PX;border-top-style:solid;border-top-width:1PX;border-right-width:0PX;}
.ad1-5 {border-color:0000FF;border-style:none;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;}
.ad1-6 {border-color:0000FF;border-style:none;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;}
.ad1-7 {border-color:0000FF;border-style:none;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;}
.ad1-8 {border-color:0000FF;border-style:none;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;}
</STYLE>

<!--<TITLE>Crystal Report Viewer</TITLE>-->
<BODY BGCOLOR="FFFFFF"LEFTMARGIN=0 TOPMARGIN=0 BOTTOMMARGIN=0 RIGHTMARGIN=0>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<div style="position:relative">

<!--Copies-->

<?php $chqdt = $r_pay['chqdt']; ?>

<DIV style="left: 1280px; top: 334px; width: 251px; height: 20PX;"><span class="fc1-7"><?=$chqdt[8];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$chqdt[9];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$chqdt[5];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$chqdt[6];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$chqdt[0];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$chqdt[1];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$chqdt[2];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$chqdt[3];?></span></DIV>

<!--Page No--><!--Header Text-->
<DIV style="left: 1481px; top: 407px; width: 87px; height: 21px;"><span class="fc1-7"></span></DIV>

<DIV style="left: 1268px; top: 510px; width: 162px; height: 21PX;"><span class="fc1-7"><?=number_format($r_pay['payam'],2,'.',',')?></span></DIV>

<!--Company Logo--><!--Company Text--><!--Vendor Name-->
<DIV style="left: 805px; top: 422PX; width: 568px; height: 26PX;"><span class="fc1-7"><?=$r_data['name1'];?></span></DIV>

<?php
  $text_amt = $this->convert_amount->generate($r_pay['payam']);
?>
<DIV style="left: 805px; top: 465px; width: 568px; height: 23px;"><span class="fc1-7">(<?=$text_amt;?>)</span></DIV>

</div>
<!--Item Table-->

<!--Payment Table-->

<!--Amount Text--><!--Signature Text-->

</BODY></HTML>

<?php
		}
	  }
	}
}

?>