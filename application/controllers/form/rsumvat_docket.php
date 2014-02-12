<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rsumvat_docket extends CI_Controller {
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
		
		$balwr = $this->input->get('balwr');
		if(empty($balwr)) $balwr='0.00';
		$date =	$this->input->get('bldat');
		$copies =	$this->input->get('copies');
		//$no = $type = $this->uri->segment(4);
		//$copies = intval($type = $this->uri->segment(5));
		$month = explode('-',$date);
		$dt_result = util_helper_get_sql_between_month($date);
		$text_month = $this->convert_amount->text_month($month[1]);
		
		if($copies<=0) $copies = 1;
		
		//Sale
		$strSQL = " select v_vbrk.*";
        $strSQL = $strSQL . " from v_vbrk ";
        $strSQL = $strSQL . " Where v_vbrk.bldat ".$dt_result;
		$strSQL = $strSQL . " And v_vbrk.statu = '02' ";
		$strSQL .= " ORDER BY invnr ASC";
		
		$query = $this->db->query($strSQL);
		$r_data = $query->first_row('array');
		
		$taxid = str_split($r_com['taxid']);
		$posid = str_split($r_com['pstlz']);
		// calculate sum
		$rows = $query->result_array();
		
		$sale_amt=0;$sale_vat=0;
		foreach ($rows as $key => $item) {
		   $sale_amt += $item['beamt'] - $item['dismt'];
		   $sale_vat += $item['vat01'];
		}
		
		//Sale debit
	    $strSQL = " select v_vbdn.*";
        $strSQL = $strSQL . " from v_vbdn ";
        $strSQL = $strSQL . " Where v_vbdn.bldat ".$dt_result;
		$strSQL = $strSQL . " And v_vbdn.statu = '02' ";
		$strSQL .= "ORDER BY debnr ASC";
       
		$q_saledn = $this->db->query($strSQL);
		$rows = $q_saledn->result_array();
		foreach ($rows as $key => $item) {
		   $sale_amt += $item['beamt'] - $item['dismt'];
		   $sale_vat += $item['vat01'];
		}
		
		//Purchase credit
		$strSQL2 = " select v_ebcn.*";
        $strSQL2 = $strSQL2 . " from v_ebcn ";
        $strSQL2 = $strSQL2 . " Where v_ebcn.bldat ".$dt_result;
		$strSQL = $strSQL . " And v_ebcn.statu = '02' ";
		$strSQL2 .= "ORDER BY crenr ASC";
       
		$q_purchcn = $this->db->query($strSQL2);
		$rows = $q_purchcn->result_array();
		foreach ($rows as $key => $item) {
		   $sale_amt += $item['beamt'] - $item['dismt'];
		   $sale_vat += $item['vat01'];
		}
		
		
		//Purchase
		$strSQL="";
		$strSQL = " select v_ebrk.*";
        $strSQL = $strSQL . " from v_ebrk ";
        $strSQL = $strSQL . " Where v_ebrk.bldat ".$dt_result;
		$strSQL = $strSQL . " And v_ebrk.statu = '02' ";
		$strSQL .= " ORDER BY invnr ASC";
       
		$query = $this->db->query($strSQL);
		$r_data = $query->first_row('array');
		// calculate sum
		$rowp = $query->result_array();
		
		$purch_amt=0;$purch_vat=0;
		foreach ($rowp as $key => $item) {
		   $purch_amt += $item['beamt'] - $item['dismt'];
		   $purch_vat += $item['vat01'];
		}
		
		//Purchase debit
		$strSQL2 = " select v_ebdn.*";
        $strSQL2 = $strSQL2 . " from v_ebdn ";
        $strSQL2 = $strSQL2 . " Where v_ebdn.bldat ".$dt_result;
		$strSQL = $strSQL . " And v_ebdn.statu = '02' ";
		$strSQL2 .= "ORDER BY debnr ASC";
       
		$q_purchdn = $this->db->query($strSQL2);
		$rowp = $q_purchdn->result_array();
		
		foreach ($rowp as $key => $item) {
		   $purch_amt += $item['beamt'] - $item['dismt'];
		   $purch_vat += $item['vat01'];
		}
		
		//Sale credit
	    $strSQL = " select v_vbcn.*";
        $strSQL = $strSQL . " from v_vbcn ";
        $strSQL = $strSQL . " Where v_vbcn.bldat ".$dt_result;
		$strSQL = $strSQL . " And v_vbcn.statu = '02' ";
		$strSQL .= "ORDER BY crenr ASC";
       
		$q_salecn = $this->db->query($strSQL);
		$rowp = $q_salecn->result_array();
		
		foreach ($rowp as $key => $item) {
		   $purch_amt += $item['beamt'] - $item['dismt'];
		   $purch_vat += $item['vat01'];
		}
		

		function check_page($page_index, $total_page, $value){
			return ($page_index==0 && $total_page>1)?"":$value;
		}
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
body { FONT-FAMILY:'Angsana New';}
 A {text-decoration:none}
 A IMG {border-style:none; border-width:0;}
 DIV {position:absolute; z-index:25;}
.fc1-0 { COLOR:000000;FONT-SIZE:13PT;FONT-FAMILY:'Angsana New';FONT-WEIGHT:BOLD;}
.fc1-1 { COLOR:000000;FONT-SIZE:10PT;FONT-WEIGHT:NORMAL;}
.fc1-2 { COLOR:000000;FONT-SIZE:13PT;FONT-FAMILY:'Angsana New';FONT-WEIGHT:BOLD;}
.fc1-3 { COLOR:000000;FONT-SIZE:12PT;FONT-FAMILY:'Angsana New';FONT-WEIGHT:BOLD;}
.fc1-4 { COLOR:000000;FONT-SIZE:10PT;FONT-WEIGHT:NORMAL;}
.fc1-5 { COLOR:000000;FONT-SIZE:11PT;FONT-WEIGHT:NORMAL;}
.fc1-6 { COLOR:000000;FONT-SIZE:9PT;FONT-WEIGHT:NORMAL;}
.fc1-7 { COLOR:000000;FONT-SIZE:10PT;FONT-WEIGHT:NORMAL;}
.fc1-8 { COLOR:000000;FONT-SIZE:10PT;FONT-FAMILY:'Angsana New';FONT-WEIGHT:BOLD;}
.fc1-9 { COLOR:000000;FONT-SIZE:9PT;FONT-WEIGHT:NORMAL;}
.fc1-10 { COLOR:000000;FONT-SIZE:13PT;;FONT-WEIGHT:NORMAL;}
.fc1-11 { COLOR:000000;FONT-SIZE:11PT;FONT-FAMILY:'Angsana New';FONT-WEIGHT:BOLD;}
.fc1-12 { COLOR:000000;FONT-SIZE:10PT;FONT-WEIGHT:NORMAL;}
.fc1-13 { COLOR:000000;FONT-SIZE:15PT;FONT-FAMILY:'Angsana New';FONT-WEIGHT:BOLD;}
.fc1-14 { COLOR:E8E1DE;FONT-SIZE:11PT;FONT-FAMILY:'Angsana New';FONT-WEIGHT:BOLD;}
.fc1-15 { COLOR:000000;FONT-SIZE:8PT;FONT-FAMILY:Tahoma;FONT-WEIGHT:NORMAL;}
.fc1-16 { COLOR:000000;FONT-SIZE:27PT;FONT-WEIGHT:NORMAL;}
.fc1-17 { COLOR:000000;FONT-SIZE:12PT;FONT-WEIGHT:NORMAL;}
.fc1-18 { COLOR:000000;FONT-SIZE:7PT;FONT-FAMILY:'Angsana New';FONT-WEIGHT:BOLD;}
.fc1-19 { COLOR:000000;FONT-SIZE:13PT;FONT-WEIGHT:NORMAL;}
.fc1-20 { COLOR:000000;FONT-SIZE:9PT;FONT-FAMILY:'Angsana New';FONT-WEIGHT:BOLD;}
.fc1-21 { COLOR:000000;FONT-SIZE:12PT;FONT-WEIGHT:NORMAL;}
.fc1-22 { COLOR:000000;FONT-SIZE:11PT;FONT-WEIGHT:NORMAL;}
.fc1-23 { COLOR:000000;FONT-SIZE:27PT;FONT-WEIGHT:NORMAL;}
.fc1-24 { COLOR:000000;FONT-SIZE:9PT;FONT-FAMILY:'Angsana New';FONT-WEIGHT:BOLD;}
.fc1-25 { COLOR:000000;FONT-SIZE:15PT;FONT-WEIGHT:NORMAL;}
.fc1-26 { COLOR:000000;FONT-SIZE:12PT;FONT-WEIGHT:NORMAL;}
.fc1-27 { COLOR:000000;FONT-SIZE:13PT;FONT-WEIGHT:NORMAL;}
.fc1-28 { COLOR:FFFFFF;FONT-SIZE:13PT;FONT-FAMILY:'Angsana New';FONT-WEIGHT:BOLD;}
.fc1-29 { COLOR:000000;FONT-SIZE:11PT;FONT-WEIGHT:NORMAL;FONT-STYLE:ITALIC;}
.fc1-30 { COLOR:808080;FONT-SIZE:6PT;FONT-WEIGHT:NORMAL;}
.ad1-0 {border-color:000000;border-style:none;border-bottom-width:0PX;border-left-width:0PX;border-top-width:0PX;border-right-width:0PX;}
.ad1-1 {border-color:000000;border-style:none;border-bottom-width:0PX;border-left-width:0PX;border-top-width:0PX;border-right-width:0PX;}
.ad1-2 {border-color:800000;border-style:none;border-bottom-width:0PX;border-left-style:solid;border-left-width:1PX;border-top-width:0PX;border-right-width:0PX;}
.ad1-3 {border-color:800000;border-style:none;border-bottom-width:0PX;border-left-style:solid;border-left-width:1PX;border-top-width:0PX;border-right-width:0PX;}
.ad1-4 {border-color:800000;border-style:none;border-bottom-width:0PX;border-left-width:0PX;border-top-style:solid;border-top-width:1PX;border-right-width:0PX;}
.ad1-5 {border-color:800000;border-style:none;border-bottom-width:0PX;border-left-width:0PX;border-top-style:solid;border-top-width:2PX;border-right-width:0PX;}
.ad1-6 {border-color:BC968C;border-style:none;border-bottom-width:0PX;border-left-width:0PX;border-top-style:dashed;border-top-width:0PX;border-right-width:0PX;}
.ad1-7 {border-color:BC968C;border-style:none;border-bottom-width:0PX;border-left-style:solid;border-left-width:1PX;border-top-width:0PX;border-right-width:0PX;}
.ad1-8 {border-color:000000;border-style:none;border-bottom-width:0PX;border-left-width:0PX;border-top-width:0PX;border-right-width:0PX;}
.ad1-9 {border-color:BC968C;border-style:none;border-bottom-style:solid;border-bottom-width:2PX;border-left-style:solid;border-left-width:2PX;border-top-style:solid;border-top-width:2PX;border-right-style:solid;border-right-width:2PX;}
.ad1-10 {border-color:BC968C;border-style:none;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;}
.ad1-11 {border-color:BC968C;border-style:none;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;}
.ad1-12 {border-color:000000;border-style:none;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;}
.ad1-13 {border-color:000000;border-style:none;border-bottom-width:0PX;border-left-width:0PX;border-top-width:0PX;border-right-width:0PX;}
</STYLE>

<TITLE>Crystal Report Viewer</TITLE>
<BODY BGCOLOR="FFFFFF"LEFTMARGIN=0 TOPMARGIN=0 BOTTOMMARGIN=0 RIGHTMARGIN=0>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<DIV style="z-index:0"> &nbsp; </div>

<div style="left:584PX;top:115PX;border-color:800000;border-style:solid;border-width:0px;border-left-width:1PX;height:46PX;">
<table width="0px" height="40PX"><td>&nbsp;</td></table>
</div>
<div style="left:444PX;top:94PX;border-color:800000;border-style:solid;border-width:0px;border-left-width:1PX;height:292PX;">
<table width="0px" height="286PX"><td>&nbsp;</td></table>
</div>
<div style="left:444PX;top:161PX;border-color:800000;border-style:solid;border-width:0px;border-top-width:1PX;width:321PX;">
</div>
<div style="left:444PX;top:283PX;border-color:800000;border-style:solid;border-width:0px;border-top-width:2PX;width:323PX;">
</div>
<div style="left:444PX;top:385PX;border-color:800000;border-style:solid;border-width:0px;border-top-width:2PX;width:323PX;">
</div>
<div style="left:30PX;top:719PX;border-color:BC968C;border-style:solid;border-width:0px;border-top-width:1PX;width:719PX;">
</div>
<div style="left: 558PX; top: 690px; border-color: BC968C; border-style: solid; border-width: 0px; border-left-width: 1PX; height: 23PX;">
  <table width="0px" height="17PX"><td>&nbsp;</td></table>
</div>
<div style="left: 718px; top: 612px; border-color: BC968C; border-style: solid; border-width: 0px; border-left-width: 1PX; height: 23PX;">
  <table width="0px" height="17PX"><td>&nbsp;</td></table>
</div>
<div style="left:558PX;top:667PX;border-color:BC968C;border-style:solid;border-width:0px;border-left-width:1PX;height:23PX;">
  <table width="0px" height="17PX"><td>&nbsp;</td></table>
</div>
<div style="left:718PX;top:563PX;border-color:BC968C;border-style:solid;border-width:0px;border-left-width:1PX;height:23PX;">
<table width="0px" height="17PX"><td>&nbsp;</td></table>
</div>
<div style="left:718PX;top:587PX;border-color:BC968C;border-style:solid;border-width:0px;border-left-width:1PX;height:23PX;">
<table width="0px" height="17PX"><td>&nbsp;</td></table>
</div>
<div style="left:718PX;top:636PX;border-color:BC968C;border-style:solid;border-width:0px;border-left-width:1PX;height:23PX;">
  <table width="0px" height="17PX"><td>&nbsp;</td></table>
</div>
<div style="left:718PX;top:499PX;border-color:BC968C;border-style:solid;border-width:0px;border-left-width:1PX;height:23PX;">
<table width="0px" height="17PX"><td>&nbsp;</td></table>
</div>
<div style="left:558PX;top:403PX;border-color:BC968C;border-style:solid;border-width:0px;border-left-width:1PX;height:23PX;">
<table width="0px" height="17PX"><td>&nbsp;</td></table>
</div>
<div style="left:558PX;top:428PX;border-color:BC968C;border-style:solid;border-width:0px;border-left-width:1PX;height:23PX;">
<table width="0px" height="17PX"><td>&nbsp;</td></table>
</div>
<div style="left:558PX;top:452PX;border-color:BC968C;border-style:solid;border-width:0px;border-left-width:1PX;height:23PX;">
<table width="0px" height="17PX"><td>&nbsp;</td></table>
</div>
<div style="left:558PX;top:476PX;border-color:BC968C;border-style:solid;border-width:0px;border-left-width:1PX;height:23PX;">
<table width="0px" height="17PX"><td>&nbsp;</td></table>
</div>
<div style="left:558PX;top:532PX;border-color:BC968C;border-style:solid;border-width:0px;border-left-width:1PX;height:23PX;">
<table width="0px" height="17PX"><td>&nbsp;</td></table>
</div>
<div style="left:30PX;top:719PX;border-color:BC968C;border-style:solid;border-width:0px;border-top-width:1PX;width:719PX;">
</div>
<div style="left:558PX;top:738PX;border-color:BC968C;border-style:solid;border-width:0px;border-left-width:1PX;height:23PX;">
<table width="0px" height="17PX"><td>&nbsp;</td></table>
</div>
<div style="left:558PX;top:762PX;border-color:BC968C;border-style:solid;border-width:0px;border-left-width:1PX;height:23PX;">
<table width="0px" height="17PX"><td>&nbsp;</td></table>
</div>
<div style="left:718PX;top:785PX;border-color:BC968C;border-style:solid;border-width:0px;border-left-width:1PX;height:23PX;">
<table width="0px" height="17PX"><td>&nbsp;</td></table>
</div>
<div style="left:718PX;top:809PX;border-color:BC968C;border-style:solid;border-width:0px;border-left-width:1PX;height:23PX;">
<table width="0px" height="17PX"><td>&nbsp;</td></table>
</div>
<div style="left:444PX;top:857PX;border-color:800000;border-style:solid;border-width:0px;border-left-width:1PX;height:208PX;">
<table width="0px" height="202PX"><td>&nbsp;</td></table>
</div>

<DIV class="box" style="z-index:10; left:30PX;top:355PX;width:409PX;height:27PX;background-color:F2EBE8;layer-background-color:F2EBE8;">
<table border=0 cellpadding=0 cellspacing=0 width=409px height=27px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV class="box" style="z-index:10; border-color:BC968C;border-style:solid;border-bottom-style:solid;border-bottom-width:2PX;border-left-style:solid;border-left-width:2PX;border-top-style:solid;border-top-width:2PX;border-right-style:solid;border-right-width:2PX;left:444PX;top:691PX;width:136PX;height:23PX;">
<table border=0 cellpadding=0 cellspacing=0 width=126px height=14px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV class="box" style="z-index:10; border-color:BC968C;border-style:solid;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;left:30PX;top:415PX;width:28PX;height:106PX;background-color:BC968C;layer-background-color:BC968C;">
<table border=0 cellpadding=0 cellspacing=0 width=21px height=99px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV class="box" style="z-index:10; border-color:BC968C;border-style:solid;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;left:30PX;top:532PX;width:28PX;height:53PX;background-color:BC968C;layer-background-color:BC968C;">
<table border=0 cellpadding=0 cellspacing=0 width=21px height=46px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV class="box" style="z-index:10; border-color:BC968C;border-style:solid;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;left:30PX;top:597PX;width:28PX;height:65PX;background-color:BC968C;layer-background-color:BC968C;">
<table border=0 cellpadding=0 cellspacing=0 width=21px height=57px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV class="box" style="z-index:10; border-color:BC968C;border-style:solid;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;left:30PX;top:669PX;width:28PX;height:43PX;background-color:BC968C;layer-background-color:BC968C;">
<table border=0 cellpadding=0 cellspacing=0 width=21px height=37px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV class="box" style="z-index:10; border-color:BC968C;border-style:solid;border-bottom-style:solid;border-bottom-width:2PX;border-left-style:solid;border-left-width:2PX;border-top-style:solid;border-top-width:2PX;border-right-style:solid;border-right-width:2PX;left:444PX;top:667PX;width:136PX;height:22PX;">
<table border=0 cellpadding=0 cellspacing=0 width=126px height=14px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV class="box" style="z-index:10; border-color:BC968C;border-style:solid;border-bottom-style:solid;border-bottom-width:2PX;border-left-style:solid;border-left-width:2PX;border-top-style:solid;border-top-width:2PX;border-right-style:solid;border-right-width:2PX;left:604PX;top:563PX;width:135PX;height:22PX;">
<table border=0 cellpadding=0 cellspacing=0 width=126px height=14px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV class="box" style="z-index:10; border-color:BC968C;border-style:solid;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;left:604PX;top:587PX;width:135PX;height:23PX;">
<table border=0 cellpadding=0 cellspacing=0 width=128px height=16px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV class="box" style="z-index:10; border-color:BC968C;border-style:solid;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;left:604PX;top:611PX;width:135PX;height:23PX;">
<table border=0 cellpadding=0 cellspacing=0 width=128px height=16px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV class="box" style="z-index:10; border-color:BC968C;border-style:solid;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;left:604PX;top:636PX;width:135PX;height:22PX;">
<table border=0 cellpadding=0 cellspacing=0 width=128px height=16px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV class="box" style="z-index:10; border-color:BC968C;border-style:solid;border-bottom-style:solid;border-bottom-width:2PX;border-left-style:solid;border-left-width:2PX;border-top-style:solid;border-top-width:2PX;border-right-style:solid;border-right-width:2PX;left:604PX;top:499PX;width:135PX;height:22PX;">
<table border=0 cellpadding=0 cellspacing=0 width=126px height=14px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV class="box" style="z-index:10; border-color:BC968C;border-style:solid;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;left:444PX;top:403PX;width:136PX;height:23PX;">
<table border=0 cellpadding=0 cellspacing=0 width=128px height=16px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV class="box" style="z-index:10; border-color:BC968C;border-style:solid;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;left:444PX;top:428PX;width:136PX;height:22PX;">
<table border=0 cellpadding=0 cellspacing=0 width=128px height=16px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV class="box" style="z-index:10; border-color:BC968C;border-style:solid;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;left:444PX;top:452PX;width:136PX;height:23PX;">
<table border=0 cellpadding=0 cellspacing=0 width=128px height=16px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV class="box" style="z-index:10; border-color:BC968C;border-style:solid;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;left:444PX;top:476PX;width:136PX;height:23PX;">
<table border=0 cellpadding=0 cellspacing=0 width=128px height=16px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV class="box" style="z-index:10; border-color:BC968C;border-style:solid;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;left:444PX;top:532PX;width:136PX;height:22PX;">
<table border=0 cellpadding=0 cellspacing=0 width=128px height=16px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV class="box" style="z-index:10; border-color:BC968C;border-style:solid;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;left:444PX;top:738PX;width:136PX;height:23PX;">
<table border=0 cellpadding=0 cellspacing=0 width=128px height=16px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV class="box" style="z-index:10; border-color:BC968C;border-style:solid;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;left:444PX;top:762PX;width:136PX;height:23PX;">
<table border=0 cellpadding=0 cellspacing=0 width=128px height=16px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV class="box" style="z-index:10; border-color:BC968C;border-style:solid;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;left:604PX;top:785PX;width:135PX;height:23PX;">
<table border=0 cellpadding=0 cellspacing=0 width=128px height=16px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV class="box" style="z-index:10; border-color:BC968C;border-style:solid;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;left:604PX;top:809PX;width:135PX;height:23PX;">
<table border=0 cellpadding=0 cellspacing=0 width=128px height=16px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV class="box" style="z-index:10; left:30PX;top:857PX;width:411PX;height:25PX;background-color:F2EBE8;layer-background-color:F2EBE8;">
<table border=0 cellpadding=0 cellspacing=0 width=411px height=25px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV class="box" style="z-index:10; left:444PX;top:857PX;width:314PX;height:25PX;background-color:F2EBE8;layer-background-color:F2EBE8;">
<table border=0 cellpadding=0 cellspacing=0 width=313px height=25px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV class="box" style="z-index:10; left:59PX;top:966PX;width:379PX;height:35PX;background-color:F2EBE8;layer-background-color:F2EBE8;">
<table border=0 cellpadding=0 cellspacing=0 width=379px height=35px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV class="box" style="z-index:10; left:59PX;top:1004PX;width:379PX;height:61PX;background-color:F2EBE8;layer-background-color:F2EBE8;">
<table border=0 cellpadding=0 cellspacing=0 width=379px height=61px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV style="z-index:15;left:28PX;top:19PX;width:738PX;height:71PX;">
<img  WIDTH=726 HEIGHT=70 SRC="<?= base_url('assets/images/icons/pp01.jpg') ?>">
</DIV>
<DIV style="z-index:15;left:191PX;top:104PX;width:235PX;height:20PX;">
<img  WIDTH=235 HEIGHT=20 SRC="<?= base_url('assets/images/icons/pp02.jpg') ?>">
</DIV>
<DIV style="z-index:15;left:347PX;top:129PX;width:79PX;height:20PX;">
<img  WIDTH=79 HEIGHT=20 SRC="<?= base_url('assets/images/icons/pp03.jpg') ?>">
</DIV>

<DIV style="z-index: 15; left: 112px; top: 288px; width: 79PX; height: 20PX;">
<img  WIDTH=79 HEIGHT=20 SRC="<?= base_url('assets/images/icons/pp03.jpg') ?>">
</DIV>

<DIV style="left:344PX;top:126PX;width:20PX;height:24PX;TEXT-ALIGN:CENTER;"><span class="fc1-0">0</span></DIV>

<DIV style="left:360PX;top:126PX;width:20PX;height:24PX;TEXT-ALIGN:CENTER;"><span class="fc1-0">0</span></DIV>

<DIV style="left:375PX;top:126PX;width:20PX;height:24PX;TEXT-ALIGN:CENTER;"><span class="fc1-0">0</span></DIV>

<DIV style="left:391PX;top:126PX;width:20PX;height:24PX;TEXT-ALIGN:CENTER;"><span class="fc1-0">0</span></DIV>

<DIV style="left:30PX;top:104PX;width:154PX;height:22PX;"><span class="fc1-1">เลขประจำตัวผู้เสียภาษีอากร(13หลัก)*</span></DIV>

<DIV style="left:295PX;top:129PX;width:44PX;height:21PX;TEXT-ALIGN:RIGHT;"><span class="fc1-1">สาขาที่</span></DIV>

<DIV style="left:30PX;top:151PX;width:90PX;height:25PX;"><span class="fc1-2">ชื่อผู้ประกอบการ</span></DIV>

<DIV style="left:120PX;top:153PX;width:319PX;height:40PX;"><span class="fc1-0"><?= $r_com['name1']; ?></span></DIV>

<DIV style="left:467PX;top:94PX;width:196PX;height:26PX;"><span class="fc1-2">การยื่นแบบแสดงรายการ กรณีมีสาขา</span></DIV>

<DIV style="left:30PX;top:193PX;width:103PX;height:25PX;"><span class="fc1-3">ชื่อสถานประกอบการ</span></DIV>

<DIV style="left:134PX;top:194PX;width:305PX;height:25PX;"><span class="fc1-0"><?= $r_com['name1']; ?></span></DIV>

<DIV style="left:30PX;top:224PX;width:42PX;height:27PX;"><span class="fc1-3">ที่อยู่ :</span></DIV>

<DIV style="left:85PX;top:225PX;width:354PX;height:61PX;">
<table width="349PX" border=0 cellpadding=0 cellspacing=0>
<tr><td class="fc1-0"><?=$r_com['adr01'];?></td></tr>
<tr><td class="fc1-0"><?=$r_com['distx'];?></td></tr></table>
</DIV>

<DIV style="left:87PX;top:316PX;width:239PX;height:27PX;"><span class="fc1-0"><?=$r_com['telf1'];?></span></DIV>

<DIV style="left:30PX;top:316PX;width:55PX;height:27PX;"><span class="fc1-3">โทรศัพท์</span></DIV>

<DIV style="left:446PX;top:127PX;width:36PX;height:24PX;"><span class="fc1-3">ยื่นรวม</span></DIV>

<DIV style="left:481PX;top:129PX;width:23PX;height:20PX;"><span class="fc1-4">กันที่</span></DIV>

<DIV style="left:500PX;top:120PX;width:15PX;height:16PX;TEXT-ALIGN:CENTER;"><img  WIDTH=15 HEIGHT=15 SRC="<?= base_url('assets/images/icons/checkbox01.jpg') ?>"></DIV>

<DIV style="left:500PX;top:141PX;width:15PX;height:16PX;TEXT-ALIGN:CENTER;"><img  WIDTH=15 HEIGHT=15 SRC="<?= base_url('assets/images/icons/checkbox01.jpg') ?>"></DIV>

<DIV style="left:515PX;top:118PX;width:67PX;height:19PX;"><span class="fc1-6">(1) สำนักงานใหญ่</span></DIV>

<DIV style="left:515PX;top:141PX;width:67PX;height:17PX;"><span class="fc1-6">(2) สาขาที่ ...........</span></DIV>

<DIV style="left:588PX;top:116PX;width:40PX;height:24PX;"><span class="fc1-3"> แยกยื่น</span></DIV>

<DIV style="left:630PX;top:118PX;width:114PX;height:18PX;"><span class="fc1-4">เป็นรายสถานประกอบการ</span></DIV>

<DIV style="left:588PX;top:141PX;width:15PX;height:16PX;TEXT-ALIGN:CENTER;"><img  WIDTH=15 HEIGHT=15 SRC="<?= base_url('assets/images/icons/checkbox01.jpg') ?>"></DIV>

<DIV style="left:604PX;top:139PX;width:83PX;height:19PX;"><span class="fc1-6">(3) เป็นสำนักงานใหญ่</span></DIV>

<DIV style="left:692PX;top:141PX;width:15PX;height:16PX;TEXT-ALIGN:CENTER;"><img  WIDTH=15 HEIGHT=15 SRC="<?= base_url('assets/images/icons/checkbox01.jpg') ?>"></DIV>

<DIV style="left:710PX;top:139PX;width:52PX;height:18PX;"><span class="fc1-6"> (4) เป็นสาขา</span></DIV>

<DIV style="left:482PX;top:162PX;width:39PX;height:20PX;"><span class="fc1-3">ยื่นปกติ</span></DIV>

<DIV style="left:465PX;top:167PX;width:15PX;height:16PX;TEXT-ALIGN:CENTER;"><img  WIDTH=15 HEIGHT=15 SRC="<?= base_url('assets/images/icons/checkbox01.jpg') ?>"></DIV>

<DIV style="left:538PX;top:167PX;width:15PX;height:16PX;TEXT-ALIGN:CENTER;"><img  WIDTH=15 HEIGHT=15 SRC="<?= base_url('assets/images/icons/checkbox01.jpg') ?>"></DIV>

<DIV style="left:555PX;top:162PX;width:109PX;height:20PX;"><span class="fc1-3">ยื่นเพิ่มเติมครั้งที่ ........</span></DIV>

<DIV style="left:664PX;top:165PX;width:18PX;height:21PX;"><span class="fc1-7">ของ</span></DIV>

<DIV style="left:685PX;top:162PX;width:38PX;height:20PX;"><span class="fc1-3">ภ.พ.30</span></DIV>

<DIV style="left:722PX;top:165PX;width:40PX;height:19PX;"><span class="fc1-7">ซึ่งยื่นไว้</span></DIV>

<DIV style="left:555PX;top:184PX;width:15PX;height:16PX;TEXT-ALIGN:CENTER;"><img  WIDTH=15 HEIGHT=15 SRC="<?= base_url('assets/images/icons/checkbox01.jpg') ?>"></DIV>

<DIV style="left:573PX;top:182PX;width:89PX;height:20PX;"><span class="fc1-8">ภายในกำหนดเวลา</span></DIV>

<DIV style="left:685PX;top:182PX;width:72PX;height:18PX;"><span class="fc1-8">เกินกำหนดเวลา</span></DIV>

<DIV style="left:664PX;top:184PX;width:15PX;height:16PX;TEXT-ALIGN:CENTER;"><img  WIDTH=15 HEIGHT=15 SRC="<?= base_url('assets/images/icons/checkbox01.jpg') ?>"></DIV>

<DIV style="left:448PX;top:198PX;width:72PX;height:20PX;"><span class="fc1-8">สำหรับเดือนภาษี</span></DIV>

<DIV style="left:521PX;top:200PX;width:74PX;height:16PX;"><span class="fc1-9">(ให้ทำเครื่องหมาย "</span></DIV>

<DIV style="left:595PX;top:198PX;width:14PX;height:20PX;TEXT-ALIGN:CENTER;"><img  WIDTH=20 HEIGHT=18 SRC="<?= base_url('assets/images/icons/checkbox02.jpg') ?>"></DIV>

<DIV style="left:609PX;top:200PX;width:31PX;height:16PX;"><span class="fc1-9">" ลงใน "</span></DIV>

<DIV style="left:642PX;top:200PX;width:15PX;height:18PX;TEXT-ALIGN:CENTER;"><img  WIDTH=15 HEIGHT=15 SRC="<?= base_url('assets/images/icons/checkbox01.jpg') ?>"></DIV>

<DIV style="left:658PX;top:200PX;width:106PX;height:18PX;"><span class="fc1-9">" หน้าชื่อเดือน) พ.ศ. ...........</span></DIV>

<DIV style="left:732PX;top:196PX;width:31PX;height:41PX;TEXT-ALIGN:CENTER;"><span class="fc1-11"><?= $month[0]+543 ?></span></DIV>

<DIV style="left:463PX;top:219PX;width:62PX;height:18PX;"><span class="fc1-4">(1) มกราคม</span></DIV>

<DIV style="left:543PX;top:219PX;width:62PX;height:19PX;"><span class="fc1-4">(4) เมษายน</span></DIV>

<DIV style="left:463PX;top:238PX;width:62PX;height:19PX;"><span class="fc1-4">(2) กุมภาพันธ์</span></DIV>

<DIV style="left: 543px; top: 238px; width: 70px; height: 19px;"><span class="fc1-4">(5) พฤษภาคม</span></DIV>

<DIV style="left:619PX;top:219PX;width:59PX;height:19PX;"><span class="fc1-4">(7) กรกฎาคม</span></DIV>

<DIV style="left:621PX;top:238PX;width:59PX;height:19PX;"><span class="fc1-4">(8) สิงหาคม</span></DIV>

<DIV style="left:694PX;top:220PX;width:66PX;height:18PX;"><span class="fc1-4">(10) ตุลาคม</span></DIV>

<DIV style="left:694PX;top:238PX;width:70PX;height:19PX;"><span class="fc1-4">(11) พฤศจิกายน</span></DIV>

<DIV style="left:446PX;top:222PX;width:15PX;height:18PX;TEXT-ALIGN:CENTER;"><img  WIDTH=15 HEIGHT=15 SRC="<?php if($month[1]=='01'){echo base_url('assets/images/icons/checkbox02.jpg');}else{echo base_url('assets/images/icons/checkbox01.jpg');} ?>"></DIV>

<DIV style="left:446PX;top:241PX;width:15PX;height:19PX;TEXT-ALIGN:CENTER;"><img  WIDTH=15 HEIGHT=15 SRC="<?php if($month[1]=='02'){echo base_url('assets/images/icons/checkbox02.jpg');}else{echo base_url('assets/images/icons/checkbox01.jpg');} ?>"></DIV>

<DIV style="left:528PX;top:222PX;width:16PX;height:18PX;TEXT-ALIGN:CENTER;"><img  WIDTH=15 HEIGHT=15 SRC="<?php if($month[1]=='04'){echo base_url('assets/images/icons/checkbox02.jpg');}else{echo base_url('assets/images/icons/checkbox01.jpg');} ?>"></DIV>

<DIV style="left:528PX;top:241PX;width:16PX;height:18PX;TEXT-ALIGN:CENTER;"><img  WIDTH=15 HEIGHT=15 SRC="<?php if($month[1]=='05'){echo base_url('assets/images/icons/checkbox02.jpg');}else{echo base_url('assets/images/icons/checkbox01.jpg');} ?>"></DIV>

<DIV style="left:606PX;top:222PX;width:15PX;height:23PX;TEXT-ALIGN:CENTER;"><img  WIDTH=15 HEIGHT=15 SRC="<?php if($month[1]=='07'){echo base_url('assets/images/icons/checkbox02.jpg');}else{echo base_url('assets/images/icons/checkbox01.jpg');} ?>"></DIV>

<DIV style="left:606PX;top:241PX;width:15PX;height:23PX;TEXT-ALIGN:CENTER;"><img  WIDTH=15 HEIGHT=15 SRC="<?php if($month[1]=='08'){echo base_url('assets/images/icons/checkbox02.jpg');}else{echo base_url('assets/images/icons/checkbox01.jpg');} ?>"></DIV>

<DIV style="left:678PX;top:222PX;width:15PX;height:25PX;TEXT-ALIGN:CENTER;"><img  WIDTH=15 HEIGHT=15 SRC="<?php if($month[1]=='10'){echo base_url('assets/images/icons/checkbox02.jpg');}else{echo base_url('assets/images/icons/checkbox01.jpg');} ?>"></DIV>

<DIV style="left:678PX;top:241PX;width:15PX;height:23PX;TEXT-ALIGN:CENTER;"><img  WIDTH=15 HEIGHT=15 SRC="<?php if($month[1]=='11'){echo base_url('assets/images/icons/checkbox02.jpg');}else{echo base_url('assets/images/icons/checkbox01.jpg');} ?>"></DIV>

<DIV style="left:446PX;top:260PX;width:15PX;height:17PX;"><img  WIDTH=15 HEIGHT=15 SRC="<?php if($month[1]=='03'){echo base_url('assets/images/icons/checkbox02.jpg');}else{echo base_url('assets/images/icons/checkbox01.jpg');} ?>"></DIV>

<DIV style="left:463PX;top:257PX;width:62PX;height:19PX;"><span class="fc1-4">(3) มีนาคม</span></DIV>

<DIV style="left:528PX;top:260PX;width:16PX;height:17PX;TEXT-ALIGN:CENTER;"><img  WIDTH=15 HEIGHT=15 SRC="<?php if($month[1]=='06'){echo base_url('assets/images/icons/checkbox02.jpg');}else{echo base_url('assets/images/icons/checkbox01.jpg');} ?>"></DIV>

<DIV style="left: 543px; top: 260px; width: 59PX; height: 19PX;"><span class="fc1-4">(6) มิถุนายน</span></DIV>

<DIV style="left:606PX;top:260PX;width:15PX;height:16PX;TEXT-ALIGN:CENTER;"><img  WIDTH=15 HEIGHT=15 SRC="<?php if($month[1]=='09'){echo base_url('assets/images/icons/checkbox02.jpg');}else{echo base_url('assets/images/icons/checkbox01.jpg');} ?>"></DIV>

<DIV style="left:678PX;top:260PX;width:13PX;height:16PX;TEXT-ALIGN:CENTER;"><img  WIDTH=15 HEIGHT=15 SRC="<?php if($month[1]=='12'){echo base_url('assets/images/icons/checkbox02.jpg');}else{echo base_url('assets/images/icons/checkbox01.jpg');} ?>"></DIV>

<DIV style="left:621PX;top:257PX;width:59PX;height:20PX;"><span class="fc1-4">(9) กันยายน</span></DIV>

<DIV style="left:694PX;top:257PX;width:71PX;height:19PX;"><span class="fc1-4">(12) ธันวาคม</span></DIV>

<DIV style="left:30PX;top:287PX;width:71PX;height:27PX;"><span class="fc1-3">รหัสไปรษณีย์</span></DIV>

<DIV style="left: 80PX; top: 285px; width: 82PX; height: 26PX; TEXT-ALIGN: CENTER;"><span class="fc1-0"><?= $posid[0];?></span></DIV>

<DIV style="left:95PX;top:285PX;width:82PX;height:26PX;TEXT-ALIGN:CENTER;"><span class="fc1-0"><?= $posid[1];?></span></DIV>

<DIV style="left:110PX;top:285PX;width:82PX;height:26PX;TEXT-ALIGN:CENTER;"><span class="fc1-0"><?= $posid[2];?></span></DIV>

<DIV style="left:125PX;top:285PX;width:82PX;height:26PX;TEXT-ALIGN:CENTER;"><span class="fc1-0"><?= $posid[3];?></span></DIV>

<DIV style="left:140PX;top:285PX;width:82PX;height:26PX;TEXT-ALIGN:CENTER;"><span class="fc1-0"><?= $posid[4];?></span></DIV>

<DIV style="left:193PX;top:104PX;width:14PX;height:20PX;TEXT-ALIGN:CENTER;"><span class="fc1-11"><?= $taxid[0];?></span></DIV>

<DIV style="left: 215px; top: 104PX; width: 14PX; height: 20PX; TEXT-ALIGN: CENTER;"><span class="fc1-11"><?= $taxid[1];?></span></DIV>

<DIV style="left: 230px; top: 104PX; width: 14px; height: 20PX; TEXT-ALIGN: CENTER;"><span class="fc1-11"><?= $taxid[2];?></span></DIV>

<DIV style="left: 246px; top: 104PX; width: 14px; height: 20PX; TEXT-ALIGN: CENTER;"><span class="fc1-11"><?= $taxid[3];?></span></DIV>

<DIV style="left: 262px; top: 104PX; width: 14px; height: 20PX; TEXT-ALIGN: CENTER;"><span class="fc1-11"><?= $taxid[4];?></span></DIV>

<DIV style="left: 284px; top: 104PX; width: 14px; height: 20PX; TEXT-ALIGN: CENTER;"><span class="fc1-11"><?= $taxid[5];?></span></DIV>

<DIV style="left: 300px; top: 104PX; width: 14px; height: 20PX; TEXT-ALIGN: CENTER;"><span class="fc1-11"><?= $taxid[6];?></span></DIV>

<DIV style="left: 317px; top: 104PX; width: 14px; height: 20PX; TEXT-ALIGN: CENTER;"><span class="fc1-11"><?= $taxid[7];?></span></DIV>

<DIV style="left: 333px; top: 104PX; width: 14px; height: 20PX; TEXT-ALIGN: CENTER;"><span class="fc1-11"><?= $taxid[8];?></span></DIV>

<DIV style="left: 347px; top: 104PX; width: 14px; height: 20PX; TEXT-ALIGN: CENTER;"><span class="fc1-11"><?= $taxid[9];?></span></DIV>

<DIV style="left:360PX;top:104PX;width:36PX;height:20PX;TEXT-ALIGN:CENTER;"><span class="fc1-11"><?= $taxid[10];?></span></DIV>

<DIV style="left:385PX;top:104PX;width:16PX;height:20PX;TEXT-ALIGN:CENTER;"><span class="fc1-11"><?= $taxid[11];?></span></DIV>

<DIV style="left:410PX;top:104PX;width:16PX;height:20PX;TEXT-ALIGN:CENTER;"><span class="fc1-11"><?= $taxid[12];?></span></DIV>

<DIV style="left:169PX;top:354PX;width:98PX;height:30PX;TEXT-ALIGN:CENTER;"><span class="fc1-13">การคำนวณภาษี</span></DIV>

<DIV style="left:475PX;top:365PX;width:255PX;height:23PX;TEXT-ALIGN:CENTER;"><span class="fc1-14">สำหรับบันทึกข้อมูลจากระบบ TCL</span></DIV>

<DIV style="left:444PX;top:388PX;width:113PX;height:16PX;TEXT-ALIGN:CENTER;"><span class="fc1-15">บาท</span></DIV>

<DIV style="left:557PX;top:388PX;width:23PX;height:16PX;TEXT-ALIGN:CENTER;"><span class="fc1-15">สต.</span></DIV>

<DIV style="left:304PX;top:420PX;width:15PX;height:16PX;TEXT-ALIGN:CENTER;"><img  WIDTH=15 HEIGHT=15 SRC="<?= base_url('assets/images/icons/checkbox01.jpg') ?>"></DIV>

<DIV style="left:322PX;top:402PX;width:102PX;height:21PX;"><span class="fc1-4">(1.1) ยอดขายแจ้งไว้ขาด</span></DIV>

<DIV style="left:304PX;top:404PX;width:15PX;height:16PX;TEXT-ALIGN:CENTER;"><img  WIDTH=15 HEIGHT=15 SRC="<?= base_url('assets/images/icons/checkbox01.jpg') ?>"></DIV>

<DIV style="left:322PX;top:418PX;width:101PX;height:21PX;"><span class="fc1-4">(1.2) ยอดซื้อแจ้งไว้เกิน</span></DIV>

<DIV style="left:420PX;top:395PX;width:10PX;height:52PX;"><span class="fc1-16">}</span></DIV>

<DIV style="left:196PX;top:393PX;width:11PX;height:52PX;TEXT-ALIGN:RIGHT;"><span class="fc1-16">{</span></DIV>

<DIV style="left:205PX;top:408PX;width:97PX;height:26PX;"><span class="fc1-17">หรือกรณียื่นเพิ่มเติม</span></DIV>

<DIV style="left: 63PX; top: 412px; width: 19PX; height: 17PX; TEXT-ALIGN: RIGHT;"><span class="fc1-20">1.</span></DIV>

<DIV style="left:86PX;top:407PX;width:104PX;height:23PX;"><span class="fc1-19">ยอดขายในเดือนนี้</span></DIV>

<DIV style="left: 63PX; top: 437px; width: 19PX; height: 19PX; TEXT-ALIGN: RIGHT;"><span class="fc1-20">&nbsp;&nbsp;2.</span></DIV>

<DIV style="left:86PX;top:431PX;width:22PX;height:24PX;"><span class="fc1-2">ลบ</span></DIV>

<DIV style="left:106PX;top:433PX;width:198PX;height:25PX;"><span class="fc1-17">ยอดขายที่เสียภาษีในอัตราร้อยละ 0&nbsp;&nbsp;(ถ้ามี)</span></DIV>

<DIV style="left: 447px; top: 403px; width: 124px; height: 21PX; TEXT-ALIGN: RIGHT;"><span class="fc1-2"><?=number_format($sale_amt,2,'.',',');?></span></DIV>

<DIV style="left:449PX;top:431PX;width:108PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-2">0</span></DIV>

<DIV style="left:560PX;top:431PX;width:21PX;height:20PX;"><span class="fc1-2">00</span></DIV>

<DIV style="left:449PX;top:455PX;width:108PX;height:22PX;TEXT-ALIGN:RIGHT;"><span class="fc1-2">0</span></DIV>

<DIV style="left:560PX;top:455PX;width:21PX;height:22PX;"><span class="fc1-2">00</span></DIV>

<DIV style="left: 443px; top: 476px; width: 128px; height: 22PX; TEXT-ALIGN: RIGHT;"><span class="fc1-2"><?=number_format($sale_amt,2,'.',',');?></span></DIV>

<DIV style="left:86PX;top:455PX;width:22PX;height:23PX;"><span class="fc1-2">ลบ</span></DIV>

<DIV style="left:106PX;top:457PX;width:140PX;height:21PX;"><span class="fc1-17">ยอดขายที่ได้รับยกเว้น&nbsp;&nbsp;(ถ้ามี)</span></DIV>

<DIV style="left: 63PX; top: 461px; width: 19PX; height: 19PX; TEXT-ALIGN: RIGHT;"><span class="fc1-20">3.</span></DIV>

<DIV style="left: 63PX; top: 483px; width: 19PX; height: 19PX; TEXT-ALIGN: RIGHT;"><span class="fc1-20">4.</span></DIV>

<DIV style="left:193PX;top:478PX;width:63PX;height:23PX;"><span class="fc1-2">(1. - 2. - 3.)</span></DIV>

<DIV style="left:86PX;top:480PX;width:108PX;height:22PX;"><span class="fc1-17">ยอดขายที่ต้องเสียภาษี</span></DIV>

<DIV style="left: 63PX; top: 505px; width: 19PX; height: 16PX; TEXT-ALIGN: RIGHT;"><span class="fc1-20">5.</span></DIV>

<DIV style="left:86PX;top:500PX;width:81PX;height:20PX;"><span class="fc1-2">ภาษีขายเดือนนี้</span></DIV>

<DIV style="left:170PX;top:505PX;width:404PX;height:24PX;"><span class="fc1-21">.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.</span></DIV>

<DIV style="left: 64PX; top: 531px; width: 18PX; height: 23PX; TEXT-ALIGN: RIGHT;"><span class="fc1-20">6.</span></DIV>

<DIV style="left:88PX;top:528PX;width:120PX;height:22PX;"><span class="fc1-17">ยอดซื้อที่มีสิทธินำภาษีซื้อ</span></DIV>

<DIV style="left:88PX;top:546PX;width:128PX;height:19PX;"><span class="fc1-4">มาหักในการคำนวณภาษีเดือนนี้</span></DIV>

<DIV style="left:217PX;top:539PX;width:86PX;height:20PX;"><span class="fc1-22">หรือกรณียื่นเพิ่มเติม</span></DIV>

<DIV style="left:304PX;top:532PX;width:15PX;height:16PX;TEXT-ALIGN:CENTER;"><img  WIDTH=15 HEIGHT=15 SRC="<?= base_url('assets/images/icons/checkbox01.jpg') ?>"></DIV>

<DIV style="left:208PX;top:519PX;width:11PX;height:52PX;TEXT-ALIGN:RIGHT;"><span class="fc1-23">{</span></DIV>

<DIV style="left:304PX;top:548PX;width:15PX;height:16PX;TEXT-ALIGN:CENTER;"><img  WIDTH=15 HEIGHT=15 SRC="<?= base_url('assets/images/icons/checkbox01.jpg') ?>"></DIV>

<DIV style="left:322PX;top:530PX;width:101PX;height:21PX;"><span class="fc1-7">(6.1) ยอดซื้อแจ้งไว้ขาด</span></DIV>

<DIV style="left:322PX;top:544PX;width:101PX;height:18PX;"><span class="fc1-7">(6.2) ยอดขายแจ้งไว้เกิน</span></DIV>

<DIV style="left:417PX;top:519PX;width:8PX;height:50PX;"><span class="fc1-23">}</span></DIV>

<DIV style="left:580PX;top:478PX;width:24PX;height:19PX;TEXT-ALIGN:RIGHT;"><span class="fc1-24">4</span></DIV>

<DIV style="left:580PX;top:454PX;width:24PX;height:19PX;TEXT-ALIGN:RIGHT;"><span class="fc1-24">3</span></DIV>

<DIV style="left:580PX;top:429PX;width:24PX;height:19PX;TEXT-ALIGN:RIGHT;"><span class="fc1-24">2</span></DIV>

<DIV style="left:588PX;top:405PX;width:16PX;height:19PX;TEXT-ALIGN:RIGHT;"><span class="fc1-24">1</span></DIV>

<DIV style="left:739PX;top:500PX;width:19PX;height:21PX;TEXT-ALIGN:RIGHT;"><span class="fc1-24">5</span></DIV>

<DIV style="left: 63PX; top: 645px; width: 19PX; height: 18PX; TEXT-ALIGN: RIGHT;"><span class="fc1-20">10.</span></DIV>

<DIV style="left:86PX;top:639PX;width:108PX;height:22PX;"><span class="fc1-2">ภาษีที่ชำระเกินยกมา</span></DIV>

<DIV style="left:248PX;top:618PX;width:46PX;height:20PX;TEXT-ALIGN:CENTER;"><span class="fc1-17">น้อยกว่า</span></DIV>

<DIV style="left:205PX;top:618PX;width:19PX;height:20PX;"><span class="fc1-17">(ถ้า</span></DIV>

<DIV style="left: 63PX; top: 622px; width: 19PX; height: 18PX; TEXT-ALIGN: RIGHT;"><span class="fc1-20">9.</span></DIV>

<DIV style="left:86PX;top:617PX;width:119PX;height:22PX;"><span class="fc1-2">ภาษีที่ชำระเกินเดือนนี้</span></DIV>

<DIV style="left:248PX;top:592PX;width:46PX;height:21PX;TEXT-ALIGN:CENTER;"><span class="fc1-17">มากกว่า</span></DIV>

<DIV style="left:205PX;top:592PX;width:19PX;height:21PX;"><span class="fc1-17">(ถ้า</span></DIV>

<DIV style="left:86PX;top:592PX;width:121PX;height:21PX;"><span class="fc1-2">ภาษีที่ต้องชำระเดือนนี้</span></DIV>

<DIV style="left: 63PX; top: 597px; width: 19PX; height: 17PX; TEXT-ALIGN: RIGHT;"><span class="fc1-20">8.</span></DIV>

<DIV style="left:169PX;top:566PX;width:232PX;height:21PX;"><span class="fc1-17">(ตามหลักฐานในใบกำกับภาษีของยอดซื้อตาม 6.) </span></DIV>

<DIV style="left:88PX;top:564PX;width:79PX;height:23PX;"><span class="fc1-2">ภาษีซื้อเดือนนี้</span></DIV>

<DIV style="left: 64PX; top: 569px; width: 18PX; height: 14PX; TEXT-ALIGN: RIGHT;"><span class="fc1-20">7.</span></DIV>

<DIV style="left:580PX;top:532PX;width:24PX;height:21PX;TEXT-ALIGN:RIGHT;"><span class="fc1-24">6</span></DIV>

<DIV style="left:739PX;top:565PX;width:19PX;height:21PX;TEXT-ALIGN:RIGHT;"><span class="fc1-24">7</span></DIV>


<DIV style="left:569PX;top:502PX;width:20PX;height:24PX;TEXT-ALIGN:RIGHT;"><span class="fc1-25">…</span></DIV>

<DIV style="left:570PX;top:566PX;width:19PX;height:23PX;TEXT-ALIGN:RIGHT;"><span class="fc1-25"></span></DIV>

<DIV style="left:224PX;top:592PX;width:24PX;height:21PX;TEXT-ALIGN:CENTER;"><span class="fc1-25">…</span></DIV>

<DIV style="left:294PX;top:592PX;width:23PX;height:21PX;TEXT-ALIGN:CENTER;"><span class="fc1-25"></span></DIV>

<DIV style="left:224PX;top:618PX;width:24PX;height:20PX;TEXT-ALIGN:CENTER;"><span class="fc1-25">…</span></DIV>

<DIV style="left:294PX;top:618PX;width:23PX;height:20PX;TEXT-ALIGN:CENTER;"><span class="fc1-25"></span></DIV>

<DIV style="left:316PX;top:618PX;width:9PX;height:21PX;"><span class="fc1-26">)</span></DIV>

<DIV style="left:316PX;top:594PX;width:9PX;height:20PX;"><span class="fc1-26">)</span></DIV>

<DIV style="left:326PX;top:592PX;width:253PX;height:20PX;"><span class="fc1-27">.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.</span></DIV>

<DIV style="left:326PX;top:618PX;width:253PX;height:20PX;"><span class="fc1-27">.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.</span></DIV>

<DIV style="left:63PX;top:695PX;width:23PX;height:20PX;"><img  WIDTH=15 HEIGHT=15 SRC="<?= base_url('assets/images/icons/checkbox01.jpg') ?>"></DIV>

<DIV style="left:63PX;top:670PX;width:23PX;height:22PX;"><img  WIDTH=15 HEIGHT=15 SRC="<?= base_url('assets/images/icons/checkbox01.jpg') ?>"></DIV>

<DIV style="left: 86PX; top: 673px; width: 20PX; height: 15PX; TEXT-ALIGN: RIGHT;"><span class="fc1-20">11.</span></DIV>

<DIV style="left: 86PX; top: 697px; width: 20PX; height: 18PX; TEXT-ALIGN: RIGHT;"><span class="fc1-20">12.</span></DIV>

<DIV style="left:108PX;top:669PX;width:151PX;height:21PX;"><span class="fc1-17">ต้องชำระ&nbsp;&nbsp;&nbsp;&nbsp;(ถ้า 8. มากกว่า 10.)</span></DIV>

<DIV style="left:108PX;top:691PX;width:277PX;height:23PX;"><span class="fc1-19">ชำระเกิน&nbsp;&nbsp;&nbsp;((ถ้า 10. มากกว่า 8.)&nbsp;&nbsp;หรือ&nbsp;&nbsp;(9. รวมกับ 10.))</span></DIV>

<DIV style="left: 603px; top: 499px; width: 128px; height: 22PX; TEXT-ALIGN: RIGHT;"><span class="fc1-2"><?=number_format($sale_vat,2,'.',',');?></span></DIV>
<DIV style="left: 445px; top: 532px; width: 127px; height: 22PX; TEXT-ALIGN: RIGHT;"><span class="fc1-2"><?=number_format($purch_amt,2,'.',',');?></span></DIV>

<DIV style="left: 608px; top: 564px; width: 123px; height: 22PX; TEXT-ALIGN: RIGHT;"><span class="fc1-2"><?=number_format($purch_vat,2,'.',',');?></span></DIV>

<DIV style="left: 607px; top: 636px; width: 124px; height: 22PX; TEXT-ALIGN: RIGHT;"><span class="fc1-2"><?=number_format($balwr,2,'.',',');?></span></DIV>

<?php 
      $net_amt=0;$over_amt=0;
	  $net_amt = $sale_vat - $purch_vat;
      if($net_amt<0){$over_amt = 0 - $net_amt;}
	  elseif($net_amt==0){$net_amt = $over_amt;}
?>
<DIV style="left: 608px; top: 588px; width: 123px; height: 21PX; TEXT-ALIGN: RIGHT;"><span class="fc1-2"><?=number_format($net_amt,2,'.',',');?></span></DIV>

<DIV style="left: 605px; top: 612px; width: 126px; height: 22PX; TEXT-ALIGN: RIGHT;"><span class="fc1-2"><?=number_format($over_amt,2,'.',',');?></span></DIV>

<?php 
      $net_amt2=0;$over_amt2=0;
	  $net_amt2 = $sale_vat - $purch_vat;
	  $net_amt2 = $net_amt2 - $balwr;
      if($net_amt2<0){$over_amt2 = 0 - $net_amt2;}
	  elseif($net_amt2==0){$net_amt2 = $over_amt2;}
?>
<DIV style="left: 448px; top: 692px; width: 123px; height: 22PX; TEXT-ALIGN: RIGHT;"><span class="fc1-2"><?=number_format($net_amt,2,'.',',');?></span></DIV>

<DIV style="left:739PX;top:589PX;width:19PX;height:19PX;TEXT-ALIGN:RIGHT;"><span class="fc1-24">8</span></DIV>

<DIV style="left:739PX;top:613PX;width:19PX;height:19PX;TEXT-ALIGN:RIGHT;"><span class="fc1-24">9</span></DIV>

<DIV style="left:739PX;top:639PX;width:19PX;height:19PX;TEXT-ALIGN:RIGHT;"><span class="fc1-24">10</span></DIV>

<DIV style="left:582PX;top:670PX;width:22PX;height:18PX;TEXT-ALIGN:RIGHT;"><span class="fc1-24">11</span></DIV>

<DIV style="left:584PX;top:695PX;width:20PX;height:18PX;TEXT-ALIGN:RIGHT;"><span class="fc1-24">12</span></DIV>

<DIV style="left:247PX;top:457PX;width:198PX;height:20PX;"><span class="fc1-26">.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.</span></DIV>

<DIV style="left:255PX;top:481PX;width:189PX;height:20PX;"><span class="fc1-26">.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;. </span></DIV>

<DIV style="left:401PX;top:566PX;width:168PX;height:20PX;"><span class="fc1-26">.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.</span></DIV>

<DIV style="left:193PX;top:643PX;width:387PX;height:20PX;"><span class="fc1-26">.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.</span></DIV>

<DIV style="left:261PX;top:670PX;width:164PX;height:22PX;"><span class="fc1-26">.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.</span></DIV>

<DIV style="left:30PX;top:447PX;width:28PX;height:54PX;TEXT-ALIGN:CENTER;">
<table width="23PX" border=0 cellpadding=0 cellspacing=0><td ALIGN="CENTER" class="fc1-28">ภาษี</td></table>

<table width="23PX" border=0 cellpadding=0 cellspacing=0><td ALIGN="CENTER" class="fc1-28">ขาย</td></table>
</DIV>

<DIV style="left:30PX;top:535PX;width:28PX;height:45PX;TEXT-ALIGN:CENTER;">
<table width="23PX" border=0 cellpadding=0 cellspacing=0><td ALIGN="CENTER" class="fc1-28">ภาษี</td></table>

<table width="23PX" border=0 cellpadding=0 cellspacing=0><td ALIGN="CENTER" class="fc1-28">ซื้อ</td></table>
</DIV>

<DIV style="left:30PX;top:599PX;width:30PX;height:61PX;TEXT-ALIGN:CENTER;">
<table width="25PX" border=0 cellpadding=0 cellspacing=0><td ALIGN="CENTER" class="fc1-28">ภาษี</td></table>

<table width="25PX" border=0 cellpadding=0 cellspacing=0><td ALIGN="CENTER" class="fc1-28">มูลค่า</td></table>

<table width="25PX" border=0 cellpadding=0 cellspacing=0><td ALIGN="CENTER" class="fc1-28">เพิ่ม</td></table>
</DIV>

<DIV style="left:30PX;top:669PX;width:28PX;height:45PX;TEXT-ALIGN:CENTER;">
<table width="23PX" border=0 cellpadding=0 cellspacing=0><td ALIGN="CENTER" class="fc1-28">ภาษี</td></table>

<table width="23PX" border=0 cellpadding=0 cellspacing=0><td ALIGN="CENTER" class="fc1-28">สุทธิ</td></table>
</DIV>

<DIV style="left:304PX;top:435PX;width:140PX;height:20PX;"><span class="fc1-26">.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;. </span></DIV>

<DIV style="left:66PX;top:721PX;width:366PX;height:22PX;"><span class="fc1-2">กรณียื่นแบบแสดงรายการและชำระภาษีเกินกำหนดเวลา หรือยื่นเพิ่มเติม</span></DIV>

<DIV style="left: 63PX; top: 749px; width: 19PX; height: 17PX; TEXT-ALIGN: RIGHT;"><span class="fc1-20">13.</span></DIV>

<DIV style="left: 63PX; top: 773px; width: 19PX; height: 17PX; TEXT-ALIGN: RIGHT;"><span class="fc1-20">14.</span></DIV>

<DIV style="left: 63PX; top: 796px; width: 19PX; height: 21PX; TEXT-ALIGN: RIGHT;"><span class="fc1-20">15.</span></DIV>

<DIV style="left: 63PX; top: 820px; width: 19PX; height: 20PX; TEXT-ALIGN: RIGHT;"><span class="fc1-20">16.</span></DIV>

<DIV style="left:86PX;top:745PX;width:42PX;height:21PX;"><span class="fc1-17">เงินเพิ่ม </span></DIV>

<DIV style="left:86PX;top:769PX;width:42PX;height:21PX;"><span class="fc1-17">เบี้ยปรับ</span></DIV>

<DIV style="left:127PX;top:745PX;width:317PX;height:20PX;"><span class="fc1-26"> .&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.</span></DIV>

<DIV style="left:127PX;top:769PX;width:317PX;height:20PX;"><span class="fc1-26"> .&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;. </span></DIV>

<DIV style="left:86PX;top:792PX;width:212PX;height:21PX;"><span class="fc1-17">รวมภาษี&nbsp;&nbsp;เงินเพิ่ม&nbsp;&nbsp;และเบี้ยปรับที่ต้องชำระ&nbsp;&nbsp;((</span></DIV>

<DIV style="left:297PX;top:790PX;width:85PX;height:21PX;TEXT-ALIGN:CENTER;"><span class="fc1-2">11. + 13. + 14.</span></DIV>

<DIV style="left:380PX;top:790PX;width:42PX;height:21PX;"><span class="fc1-17">)&nbsp;&nbsp;หรือ&nbsp;&nbsp;(</span></DIV>

<DIV style="left:422PX;top:790PX;width:76PX;height:21PX;TEXT-ALIGN:CENTER;"><span class="fc1-2">13. + 14. - 12.</span></DIV>

<DIV style="left:498PX;top:792PX;width:106PX;height:21PX;"><span class="fc1-26">)) .&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.</span></DIV>

<DIV style="left:86PX;top:816PX;width:281PX;height:21PX;"><span class="fc1-17">รวมภาษีที่ชำระเกิน&nbsp;&nbsp;หลังคำนวณเงินเพิ่มและเบี้ยปรับแล้ว&nbsp;&nbsp;(</span></DIV>

<DIV style="left:362PX;top:814PX;width:82PX;height:21PX;TEXT-ALIGN:CENTER;"><span class="fc1-2">12. - 13. - 14.</span></DIV>

<DIV style="left:444PX;top:816PX;width:159PX;height:21PX;"><span class="fc1-26">) .&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.&nbsp;&nbsp;.</span></DIV>

<DIV style="left:579PX;top:740PX;width:25PX;height:27PX;TEXT-ALIGN:RIGHT;"><span class="fc1-24">13</span></DIV>

<DIV style="left:579PX;top:769PX;width:25PX;height:27PX;TEXT-ALIGN:RIGHT;"><span class="fc1-24">14</span></DIV>

<DIV style="left:739PX;top:787PX;width:19PX;height:21PX;TEXT-ALIGN:RIGHT;"><span class="fc1-24">15</span></DIV>

<DIV style="left:739PX;top:811PX;width:19PX;height:19PX;TEXT-ALIGN:RIGHT;"><span class="fc1-24">16</span></DIV>

<DIV style="left:39PX;top:859PX;width:397PX;height:19PX;TEXT-ALIGN:CENTER;"><span class="fc1-2">การขอคืนภาษี </span></DIV>

<DIV style="left:68PX;top:885PX;width:276PX;height:20PX;"><span class="fc1-22">ถ้าประสงค์จะขอคืนภาษีที่ชำระเกินตามจำนวนเงินที่แสดงไว้ตาม </span></DIV>

<DIV style="left:359PX;top:885PX;width:26PX;height:21PX;TEXT-ALIGN:CENTER;"><span class="fc1-22">หรือ </span></DIV>

<DIV style="left:340PX;top:888PX;width:22PX;height:16PX;TEXT-ALIGN:CENTER;"><span class="fc1-18">12.</span></DIV>

<DIV style="left:378PX;top:888PX;width:22PX;height:14PX;TEXT-ALIGN:CENTER;"><span class="fc1-18">16.</span></DIV>

<DIV style="left:48PX;top:900PX;width:53PX;height:21PX;"><span class="fc1-3">เป็นเงินสด</span></DIV>

<DIV style="left:134PX;top:900PX;width:81PX;height:21PX;"><span class="fc1-3">โอนเข้าธนาคาร</span></DIV>

<DIV style="left:101PX;top:902PX;width:33PX;height:23PX;TEXT-ALIGN:CENTER;"><span class="fc1-22">หรือให้ </span></DIV>

<DIV style="left:214PX;top:902PX;width:182PX;height:19PX;"><span class="fc1-22">โปรดลงชื่อในช่องข้างล่าง แล้วแต่กรณี</span></DIV>

<DIV style="left:66PX;top:922PX;width:347PX;height:21PX;"><span class="fc1-22">หากไม่ลงชื่อถือว่าขอนำภาษีที่ชำระเกินเดือนนี้ไปชำระภาษีมูลค่าเพิ่มในเดือน</span></DIV>

<DIV style="left:48PX;top:940PX;width:299PX;height:19PX;"><span class="fc1-22">ถัดไป&nbsp;&nbsp;เว้นแต่กรณียื่นเพิ่มเติม&nbsp;&nbsp;&nbsp;หากไม่ลงชื่อจะต้องยื่นขอคืนด้วยแบบ </span></DIV>

<DIV style="left:344PX;top:938PX;width:30PX;height:22PX;TEXT-ALIGN:CENTER;"><span class="fc1-3">ค.10</span></DIV>

<DIV style="left:375PX;top:940PX;width:33PX;height:19PX;"><span class="fc1-22">เท่านั้น</span></DIV>

<DIV style="left:63PX;top:978PX;width:59PX;height:21PX;"><span class="fc1-3">เป็นเงินสด</span></DIV>

<DIV style="left:66PX;top:1004PX;width:74PX;height:21PX;"><span class="fc1-3">โอนเข้าธนาคาร</span></DIV>

<DIV style="left:129PX;top:980PX;width:298PX;height:21PX;"><span class="fc1-22">ลงชื่อ ..............................................................................ผู้ประกอบการ</span></DIV>

<DIV style="left:142PX;top:1006PX;width:277PX;height:20PX;"><span class="fc1-29">(ตามที่ได้ยื่นคำขอฯ และได้รับอนุมัติจากสำนักงานสรรพากร</span></DIV>

<DIV style="left:68PX;top:1021PX;width:99PX;height:20PX;"><span class="fc1-29">พิ้นที่สาขาแล้ว)</span></DIV>

<DIV style="left:127PX;top:1041PX;width:298PX;height:21PX;"><span class="fc1-22">ลงชื่อ ..............................................................................ผู้ประกอบการ</span></DIV>

<DIV style="left:475PX;top:885PX;width:257PX;height:19PX;"><span class="fc1-22">ข้าพเจ้าขอรับรองว่าข้อความที่แสดงในแบบแสดงรายการนี้</span></DIV>

<DIV style="left:455PX;top:904PX;width:274PX;height:19PX;"><span class="fc1-22">ถูกต้องและเป็นความจริงทุกประการ กรณียื่นแบบแสดงรายการ</span></DIV>

<DIV style="left:456PX;top:923PX;width:283PX;height:19PX;"><span class="fc1-22">เกินกำหนดเวลาหรือยื่นเพิ่มเติม ข้าพเจ้าขอลดเบี้ยปรับด้วย</span></DIV>

<DIV style="left:465PX;top:985PX;width:304PX;height:21PX;"><span class="fc1-22">ลงชื่อ ....................................................................ผู้ประกอบการ</span></DIV>

<DIV style="left:465PX;top:1030PX;width:245PX;height:21PX;"><span class="fc1-22">ยื่นวันที่.................................................................</span></DIV>

<DIV style="left:477PX;top:1008PX;width:214PX;height:23PX;TEXT-ALIGN:CENTER;"><span class="fc1-22">(................................................................)</span></DIV>

<DIV style="left:687PX;top:1015PX;width:45PX;height:36PX;TEXT-ALIGN:CENTER;">
<img  WIDTH=42 HEIGHT=42 SRC="<?= base_url('assets/images/icons/seal.jpg') ?>">
</DIV>

<DIV style="left:454PX;top:859PX;width:301PX;height:23PX;TEXT-ALIGN:CENTER;"><span class="fc1-2">คำรับรอง </span></DIV>
<BR>
</BODY></HTML>


<?php
	}
   
}

?>