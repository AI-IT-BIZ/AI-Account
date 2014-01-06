<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rsalarywht_docket extends CI_Controller {
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
		
		$date =	$this->input->get('bldat');
		$copies =	$this->input->get('copies');
		//$no = $type = $this->uri->segment(4);
		//$copies = intval($type = $this->uri->segment(5));
		$month = explode('-',$date);
		$dt_result = util_helper_get_sql_between_month($date);
		$text_month = $this->convert_amount->text_month($month[1]);
		
		if($copies<=0) $copies = 1;
		$strSQL = " select v_bsid.*,v_bkpf.*";
        $strSQL = $strSQL . " from v_bsid ";
		$strSQL = $strSQL . " left join v_bkpf on v_bsid.belnr = v_bkpf.belnr ";
        $strSQL = $strSQL . " Where (v_bsid.saknr='5131-01' or v_bsid.saknr='5132-01' or v_bsid.saknr='5310-01' or v_bsid.saknr='2132-01') and ";
		$strSQL = $strSQL . "v_bkpf.docty = '09' and v_bkpf.bldat ".$dt_result;
		//$strSQL .= " ORDER BY v_bsid.belnr and v_bsid.belpr ASC";
       
		$query = $this->db->query($strSQL);
		$r_data = $query->first_row('array');
		
		// calculate sum
		$rows = $query->result_array();
		$pamt = count($rows)/2;
		$beamt = 0;$wht=0;
		foreach ($rows as $key => $item) {
			if($item['saknr']=='2132-01'){
		       $wht+=$item['credi'];
		    }else{ $beamt += $item['debit']; }
		}

		function check_page($page_index, $total_page, $value){
			return ($page_index==0 && $total_page>1)?"":$value;
		}
        ?>
<HTML xmlns="http://www.w3.org/1999/xhtml">
<script>

 ie4up=nav4up=false;
 var agt = navigator.userAgent.toLowerCase();
 var major = parseInt(navigator.appVersion);
 if ((agt.indexOf('msie') != -1) && (major >= 4))
   ie4up = true;
 if ((agt.indexOf('mozilla') != -1)  && (agt.indexOf('spoofer') == -1) && (agt.indexOf('compatible') == -1) && ( major>= 4))
   nav4up = true;
</script>
<link rel="stylesheet" href="<?= base_url('assets/css/fonts/AngsanaNew/font.css') ?>" />
<STYLE>
body { font-family: 'angsana_newregular'; }
 A {text-decoration:none}
 A IMG {border-style:none; border-width:0;}
 DIV {position:absolute; z-index:25;}
.fc1-0 { COLOR:000000;FONT-SIZE:11PT;FONT-WEIGHT:NORMAL;}
.fc1-1 { COLOR:000000;FONT-SIZE:9PT;FONT-WEIGHT:NORMAL;FONT-STYLE:ITALIC;}
.fc1-2 { COLOR:000000;FONT-SIZE:11PT;FONT-FAMILY:'angsana_newbold';}
.fc1-3 { COLOR:000000;FONT-SIZE:11PT;FONT-WEIGHT:NORMAL;FONT-STYLE:ITALIC;}
.fc1-4 { COLOR:000000;FONT-SIZE:15PT;FONT-FAMILY:'angsana_newbold';}
.fc1-5 { COLOR:000000;FONT-SIZE:13PT;FONT-FAMILY:'angsana_newbold';}
.fc1-6 { COLOR:000000;FONT-SIZE:13PT;FONT-WEIGHT:NORMAL;}
.fc1-7 { COLOR:000000;FONT-SIZE:10PT;FONT-WEIGHT:NORMAL;}
.fc1-8 { COLOR:000000;FONT-SIZE:13PT;FONT-WEIGHT:NORMAL;}
.fc1-9 { COLOR:000000;FONT-SIZE:11PT;FONT-WEIGHT:NORMAL;}
.fc1-10 { COLOR:000000;FONT-SIZE:12PT;FONT-WEIGHT:NORMAL;}
.fc1-11 { COLOR:808080;FONT-SIZE:11PT;FONT-WEIGHT:NORMAL;}
.fc1-12 { COLOR:000000;FONT-SIZE:10PT;FONT-WEIGHT:NORMAL;FONT-STYLE:ITALIC;}
.fc1-13 { COLOR:000000;FONT-SIZE:10PT;FONT-FAMILY:'angsana_newbold';FONT-STYLE:ITALIC;}
.fc1-14 { COLOR:000000;FONT-SIZE:17PT;FONT-FAMILY:'angsana_newbold';}
.fc1-15 { COLOR:000000;FONT-SIZE:13PT;FONT-FAMILY:'angsana_newbold';}
.fc1-16 { COLOR:000000;FONT-SIZE:13PT;FONT-FAMILY:'angsana_newbold';}
.fc1-17 { COLOR:000000;FONT-SIZE:12PT;FONT-WEIGHT:NORMAL;}
.fc1-18 { COLOR:000000;FONT-SIZE:12PT;FONT-WEIGHT:NORMAL;FONT-STYLE:ITALIC;}
.fc1-19 { COLOR:808080;FONT-SIZE:7PT;FONT-WEIGHT:NORMAL;}
.fc1-20 { COLOR:000000;FONT-SIZE:11PT;FONT-WEIGHT:NORMAL;}
.ad1-0 {border-color:000000;border-style:none;border-bottom-width:0PX;border-left-width:0PX;border-top-width:0PX;border-right-width:0PX;}
.ad1-1 {border-color:000000;border-style:none;border-bottom-width:0PX;border-left-width:0PX;border-top-width:0PX;border-right-width:0PX;}
.ad1-2 {border-color:808080;border-style:none;border-bottom-width:0PX;border-left-style:solid;border-left-width:1PX;border-top-width:0PX;border-right-width:0PX;}
.ad1-3 {border-color:808080;border-style:none;border-bottom-width:0PX;border-left-width:0PX;border-top-style:solid;border-top-width:1PX;border-right-width:0PX;}
.ad1-4 {border-color:808080;border-style:none;border-bottom-width:0PX;border-left-style:solid;border-left-width:1PX;border-top-width:0PX;border-right-width:0PX;}
.ad1-5 {border-color:C0C0C0;border-style:none;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;}
.ad1-6 {border-color:000000;border-style:none;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;}
.ad1-7 {border-color:808080;border-style:none;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;}
.ad1-8 {border-color:808080;border-style:none;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;}
.ad1-9 {border-color:808080;border-style:none;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;}
</STYLE>

<TITLE>Crystal Report Viewer</TITLE>
<BODY BGCOLOR="FFFFFF"LEFTMARGIN=0 TOPMARGIN=0 BOTTOMMARGIN=0 RIGHTMARGIN=0>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<DIV style="z-index:0"> &nbsp; </div>

<div style="left:441PX;top:110PX;border-color:808080;border-style:solid;border-width:0px;border-left-width:1PX;height:279PX;">
<table width="0px" height="273PX"><td>&nbsp;</td></table>
</div>
<div style="left:441PX;top:269PX;border-color:808080;border-style:solid;border-width:0px;border-top-width:1PX;width:316PX;">
</div>
<div style="left:30PX;top:326PX;border-color:808080;border-style:solid;border-width:0px;border-top-width:1PX;width:412PX;">
</div>
<div style="left:30PX;top:387PX;border-color:808080;border-style:solid;border-width:0px;border-top-width:1PX;width:727PX;">
</div>
<div style="left:31PX;top:788PX;border-color:808080;border-style:solid;border-width:0px;border-top-width:1PX;width:726PX;">
</div>
<div style="left:564PX;top:520PX;border-color:808080;border-style:solid;border-width:0px;border-left-width:1PX;height:25PX;">
<table width="0px" height="19PX"><td>&nbsp;</td></table>
</div>
<div style="left:564PX;top:581PX;border-color:808080;border-style:solid;border-width:0px;border-left-width:1PX;height:25PX;">
<table width="0px" height="19PX"><td>&nbsp;</td></table>
</div>
<div style="left:564PX;top:624PX;border-color:808080;border-style:solid;border-width:0px;border-left-width:1PX;height:25PX;">
<table width="0px" height="19PX"><td>&nbsp;</td></table>
</div>
<div style="left:564PX;top:650PX;border-color:808080;border-style:solid;border-width:0px;border-left-width:1PX;height:25PX;">
<table width="0px" height="19PX"><td>&nbsp;</td></table>
</div>
<div style="left:564PX;top:676PX;border-color:808080;border-style:solid;border-width:0px;border-left-width:1PX;height:25PX;">
<table width="0px" height="19PX"><td>&nbsp;</td></table>
</div>
<div style="left:564PX;top:703PX;border-color:808080;border-style:solid;border-width:0px;border-left-width:1PX;height:25PX;">
<table width="0px" height="19PX"><td>&nbsp;</td></table>
</div>
<div style="left:682PX;top:520PX;border-color:808080;border-style:solid;border-width:0px;border-left-width:1PX;height:25PX;">
<table width="0px" height="19PX"><td>&nbsp;</td></table>
</div>
<div style="left:682PX;top:581PX;border-color:808080;border-style:solid;border-width:0px;border-left-width:1PX;height:25PX;">
<table width="0px" height="19PX"><td>&nbsp;</td></table>
</div>
<div style="left:682PX;top:624PX;border-color:808080;border-style:solid;border-width:0px;border-left-width:1PX;height:25PX;">
<table width="0px" height="19PX"><td>&nbsp;</td></table>
</div>
<div style="left:682PX;top:650PX;border-color:808080;border-style:solid;border-width:0px;border-left-width:1PX;height:25PX;">
<table width="0px" height="19PX"><td>&nbsp;</td></table>
</div>
<div style="left:682PX;top:676PX;border-color:808080;border-style:solid;border-width:0px;border-left-width:1PX;height:25PX;">
<table width="0px" height="19PX"><td>&nbsp;</td></table>
</div>
<div style="left:682PX;top:703PX;border-color:808080;border-style:solid;border-width:0px;border-left-width:1PX;height:25PX;">
<table width="0px" height="19PX"><td>&nbsp;</td></table>
</div>
<div style="left:682PX;top:729PX;border-color:808080;border-style:solid;border-width:0px;border-left-width:1PX;height:25PX;">
<table width="0px" height="19PX"><td>&nbsp;</td></table>
</div>
<div style="left:682PX;top:755PX;border-color:808080;border-style:solid;border-width:0px;border-left-width:1PX;height:25PX;">
<table width="0px" height="19PX"><td>&nbsp;</td></table>
</div>
<div style="left:31PX;top:961PX;border-color:808080;border-style:solid;border-width:0px;border-top-width:1PX;width:726PX;">
</div>

<DIV class="box" style="z-index:10; border-color:C0C0C0;border-style:solid;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;left:64PX;top:488PX;width:334PX;height:27PX;background-color:C0C0C0;layer-background-color:C0C0C0;">
<table border=0 cellpadding=0 cellspacing=0 width=327px height=20px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV class="box" style="z-index:10; border-color:000000;border-style:solid;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;left:408PX;top:488PX;width:68PX;height:26PX;">
<table border=0 cellpadding=0 cellspacing=0 width=62px height=19px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV class="box" style="z-index:10; border-color:000000;border-style:solid;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;left:480PX;top:488PX;width:112PX;height:26PX;">
<table border=0 cellpadding=0 cellspacing=0 width=105px height=19px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV class="box" style="z-index:10; border-color:000000;border-style:solid;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;left:598PX;top:488PX;width:114PX;height:26PX;">
<table border=0 cellpadding=0 cellspacing=0 width=107px height=19px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV class="box" style="z-index:10; border-color:808080;border-style:solid;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;left:407PX;top:520PX;width:69PX;height:24PX;">
<table border=0 cellpadding=0 cellspacing=0 width=62px height=17px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV class="box" style="z-index:10; border-color:808080;border-style:solid;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;left:407PX;top:581PX;width:69PX;height:24PX;">
<table border=0 cellpadding=0 cellspacing=0 width=62px height=17px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV class="box" style="z-index:10; border-color:808080;border-style:solid;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;left:407PX;top:624PX;width:69PX;height:24PX;">
<table border=0 cellpadding=0 cellspacing=0 width=62px height=17px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV class="box" style="z-index:10; border-color:808080;border-style:solid;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;left:407PX;top:650PX;width:69PX;height:25PX;">
<table border=0 cellpadding=0 cellspacing=0 width=62px height=17px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV class="box" style="z-index:10; border-color:808080;border-style:solid;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;left:407PX;top:676PX;width:69PX;height:25PX;">
<table border=0 cellpadding=0 cellspacing=0 width=62px height=17px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV class="box" style="z-index:10; border-color:808080;border-style:solid;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;left:407PX;top:703PX;width:69PX;height:24PX;background-color:C0C0C0;layer-background-color:C0C0C0;">
<table border=0 cellpadding=0 cellspacing=0 width=62px height=17px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV class="box" style="z-index:10; border-color:808080;border-style:solid;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;left:482PX;top:520PX;width:110PX;height:24PX;">
<table border=0 cellpadding=0 cellspacing=0 width=103px height=17px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV class="box" style="z-index:10; border-color:808080;border-style:solid;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;left:482PX;top:581PX;width:110PX;height:24PX;">
<table border=0 cellpadding=0 cellspacing=0 width=103px height=17px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV class="box" style="z-index:10; border-color:808080;border-style:solid;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;left:482PX;top:624PX;width:110PX;height:24PX;">
<table border=0 cellpadding=0 cellspacing=0 width=103px height=17px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV class="box" style="z-index:10; border-color:808080;border-style:solid;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;left:482PX;top:650PX;width:110PX;height:25PX;">
<table border=0 cellpadding=0 cellspacing=0 width=103px height=17px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV class="box" style="z-index:10; border-color:808080;border-style:solid;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;left:482PX;top:676PX;width:110PX;height:25PX;">
<table border=0 cellpadding=0 cellspacing=0 width=103px height=17px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV class="box" style="z-index:10; border-color:808080;border-style:solid;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;left:482PX;top:703PX;width:110PX;height:24PX;background-color:C0C0C0;layer-background-color:C0C0C0;">
<table border=0 cellpadding=0 cellspacing=0 width=103px height=17px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV class="box" style="z-index:10; border-color:808080;border-style:solid;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;left:600PX;top:520PX;width:110PX;height:24PX;">
<table border=0 cellpadding=0 cellspacing=0 width=103px height=17px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV class="box" style="z-index:10; border-color:808080;border-style:solid;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;left:600PX;top:581PX;width:110PX;height:24PX;">
<table border=0 cellpadding=0 cellspacing=0 width=103px height=17px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV class="box" style="z-index:10; border-color:808080;border-style:solid;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;left:600PX;top:624PX;width:110PX;height:24PX;">
<table border=0 cellpadding=0 cellspacing=0 width=103px height=17px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV class="box" style="z-index:10; border-color:808080;border-style:solid;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;left:600PX;top:650PX;width:110PX;height:25PX;">
<table border=0 cellpadding=0 cellspacing=0 width=103px height=17px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV class="box" style="z-index:10; border-color:808080;border-style:solid;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;left:600PX;top:676PX;width:110PX;height:25PX;">
<table border=0 cellpadding=0 cellspacing=0 width=103px height=17px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV class="box" style="z-index:10; border-color:808080;border-style:solid;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;left:600PX;top:703PX;width:110PX;height:24PX;background-color:C0C0C0;layer-background-color:C0C0C0;">
<table border=0 cellpadding=0 cellspacing=0 width=103px height=17px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV class="box" style="z-index:10; border-color:808080;border-style:solid;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;left:600PX;top:729PX;width:110PX;height:24PX;">
<table border=0 cellpadding=0 cellspacing=0 width=103px height=17px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV class="box" style="z-index:10; border-color:808080;border-style:solid;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;left:600PX;top:755PX;width:110PX;height:24PX;background-color:C0C0C0;layer-background-color:C0C0C0;">
<table border=0 cellpadding=0 cellspacing=0 width=103px height=17px><TD>&nbsp;</TD></TABLE>
</DIV>


<DIV style="z-index:15;left:30PX;top:38PX;width:726PX;height:70PX;">
<img  WIDTH=726 HEIGHT=70 SRC="<?= base_url('assets/images/icons/pnd1.jpg') ?>">
</DIV>
<DIV style="left:30PX;top:110PX;width:105PX;height:19PX;"><span class="fc1-0">เลขประจำตัวประชาชน</span></DIV>

<DIV style="left:142PX;top:157PX;width:134PX;height:17PX;"><span class="fc1-1">ที่เป็นผู้ไม่มีเลขประจำตัวประชาชน)</span></DIV>

<DIV style="left:30PX;top:142PX;width:127PX;height:22PX;">
<table width="122PX" border=0 cellpadding=0 cellspacing=0>
<tr><td class="fc1-0">เลขประจำตัวผู้เสียภาษีอากร </td></tr>
<tr><td class="fc1-0">&nbsp;</td></tr></table>
</DIV>

<DIV style="left:30PX;top:176PX;width:164PX;height:20PX;"><span class="fc1-2">ชื่อผู้มีหน้าที่หักภาษี ณ ที่จ่าย</span></DIV>

<DIV style="left:194PX;top:176PX;width:71PX;height:21PX;"><span class="fc1-3">( หน่วยงาน ) :</span></DIV>

<DIV style="left:320PX;top:176PX;width:45PX;height:21PX;"><span class="fc1-2">สาขาที่</span></DIV>

<DIV style="left:295PX;top:142PX;width:140PX;height:32PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4"><?= $r_com['taxid']; ?></span></DIV>

<DIV style="left:364PX;top:174PX;width:71PX;height:21PX;TEXT-ALIGN:RIGHT;"><span class="fc1-5">0000</span></DIV>

<DIV style="left:30PX;top:198PX;width:405PX;height:28PX;"><span class="fc1-5"><?= $r_com['name1']; ?></span></DIV>

<DIV style="left:75PX;top:226PX;width:360PX;height:73PX;"><span class="fc1-6"><?=$r_com['adr01'];?>&nbsp;<?=$r_com['distx'];?></span></DIV>

<DIV style="left:101PX;top:297PX;width:52PX;height:24PX;"><span class="fc1-6"><?=$r_com['pstlz'];?></span></DIV>

<DIV style="left:153PX;top:299PX;width:65PX;height:24PX;"><span class="fc1-2"> โทรศัพท์ : </span></DIV>

<DIV style="left: 219px; top: 297PX; width: 146px; height: 25PX;"><span class="fc1-6"><?=$r_com['telf1'];?></span></DIV>

<DIV style="left:155PX;top:142PX;width:121PX;height:17PX;"><span class="fc1-1"> (ของผู้มีหน้าที่หักภาษี ณ ที่จ่าย</span></DIV>

<DIV style="left:116PX;top:347PX;width:60PX;height:24PX;"><span class="fc1-0">(1 ) ยื่นปกติ</span></DIV>

<DIV style="left:239PX;top:347PX;width:138PX;height:23PX;"><span class="fc1-0">(2 ) ยื่นเพิ่มเติมครั้งที่ .............</span></DIV>

<DIV style="left:446PX;top:120PX;width:127PX;height:26PX;"><span class="fc1-0">เดือนที่จ่ายเงินได้พึงประเมิน</span></DIV>

<DIV style="left:446PX;top:146PX;width:84PX;height:19PX;"><span class="fc1-7">( ให้ทำเครื่องหมาย "</span></DIV>

<DIV style="left:532PX;top:145PX;width:20PX;height:18PX;TEXT-ALIGN:CENTER;"><img  WIDTH=20 HEIGHT=18 SRC="<?= base_url('assets/images/icons/checkbox02.jpg') ?>"></DIV>

<DIV style="left:547PX;top:146PX;width:32PX;height:21PX;"><span class="fc1-7">" ลงใน "</span></DIV>

<DIV style="left:598PX;top:146PX;width:62PX;height:19PX;"><span class="fc1-7">" หน้าชื่อเดือน )</span></DIV>

<DIV style="left:661PX;top:146PX;width:95PX;height:21PX;"><span class="fc1-7">พ.ศ. .........................</span></DIV>

<DIV style="left:463PX;top:179PX;width:58PX;height:17PX;"><span class="fc1-7">(1) มกราคม</span></DIV>

<DIV style="left:540PX;top:179PX;width:58PX;height:17PX;"><span class="fc1-7">(4) เมษายน</span></DIV>

<DIV style="left:614PX;top:179PX;width:56PX;height:17PX;"><span class="fc1-7">(7) กรกฎาคม</span></DIV>

<DIV style="left:687PX;top:179PX;width:69PX;height:19PX;"><span class="fc1-7">(10) ตุลาคม</span></DIV>

<DIV style="left:463PX;top:211PX;width:58PX;height:16PX;"><span class="fc1-7">(2) กุมภาพันธ์</span></DIV>

<DIV style="left:540PX;top:211PX;width:60PX;height:17PX;"><span class="fc1-7">(5) พฤษภาคม</span></DIV>

<DIV style="left:614PX;top:211PX;width:56PX;height:16PX;"><span class="fc1-7">(8) สิงหาคม</span></DIV>

<DIV style="left:687PX;top:213PX;width:69PX;height:22PX;"><span class="fc1-7">(11) พฤศจิกายน</span></DIV>

<DIV style="left:463PX;top:243PX;width:58PX;height:19PX;"><span class="fc1-7">(3) มีนาคม</span></DIV>

<DIV style="left:540PX;top:243PX;width:58PX;height:19PX;"><span class="fc1-7">(6) มิถุนายน</span></DIV>

<DIV style="left:614PX;top:245PX;width:56PX;height:17PX;"><span class="fc1-7">(9) กันยายน</span></DIV>

<DIV style="left:688PX;top:245PX;width:68PX;height:17PX;"><span class="fc1-7">(12) ธันวาคม</span></DIV>

<DIV style="left:138PX;top:110PX;width:63PX;height:17PX;"><span class="fc1-1"> (ของผู้มีหน้าที่</span></DIV>

<DIV style="left:127PX;top:125PX;width:88PX;height:17PX;"><span class="fc1-1">หัก ภาษี ณ ที่จ่าย )</span></DIV>

<DIV style="left:446PX;top:180PX;width:17PX;height:17PX;TEXT-ALIGN:CENTER;"><img  WIDTH=15 HEIGHT=15 SRC="<?php if($month[1]=='01'){echo base_url('assets/images/icons/checkbox02.jpg');}else{echo base_url('assets/images/icons/checkbox01.jpg');} ?>"></DIV>

<DIV style="left:523PX;top:181PX;width:17PX;height:17PX;TEXT-ALIGN:CENTER;"><img  WIDTH=15 HEIGHT=15 SRC="<?php if($month[1]=='4'){echo base_url('assets/images/icons/checkbox02.jpg');}else{echo base_url('assets/images/icons/checkbox01.jpg');} ?>"></DIV>

<DIV style="left:598PX;top:181PX;width:17PX;height:17PX;TEXT-ALIGN:CENTER;"><img  WIDTH=15 HEIGHT=15 SRC="<?php if($month[1]=='07'){echo base_url('assets/images/icons/checkbox02.jpg');}else{echo base_url('assets/images/icons/checkbox01.jpg');} ?>"></DIV>

<DIV style="left:670PX;top:181PX;width:17PX;height:17PX;TEXT-ALIGN:CENTER;"><img  WIDTH=15 HEIGHT=15 SRC="<?php if($month[1]=='10'){echo base_url('assets/images/icons/checkbox02.jpg');}else{echo base_url('assets/images/icons/checkbox01.jpg');} ?>"></DIV>

<DIV style="left:446PX;top:213PX;width:17PX;height:17PX;TEXT-ALIGN:CENTER;"><img  WIDTH=15 HEIGHT=15 SRC="<?php if($month[1]=='02'){echo base_url('assets/images/icons/checkbox02.jpg');}else{echo base_url('assets/images/icons/checkbox01.jpg');} ?>"></DIV>

<DIV style="left:523PX;top:213PX;width:17PX;height:17PX;TEXT-ALIGN:CENTER;"><img  WIDTH=15 HEIGHT=15 SRC="<?php if($month[1]=='05'){echo base_url('assets/images/icons/checkbox02.jpg');}else{echo base_url('assets/images/icons/checkbox01.jpg');} ?>"></DIV>

<DIV style="left:598PX;top:213PX;width:17PX;height:17PX;TEXT-ALIGN:CENTER;"><img  WIDTH=15 HEIGHT=15 SRC="<?php if($month[1]=='08'){echo base_url('assets/images/icons/checkbox02.jpg');}else{echo base_url('assets/images/icons/checkbox01.jpg');} ?>"></DIV>

<DIV style="left:670PX;top:213PX;width:17PX;height:17PX;TEXT-ALIGN:CENTER;"><img  WIDTH=15 HEIGHT=15 SRC="<?php if($month[1]=='11'){echo base_url('assets/images/icons/checkbox02.jpg');}else{echo base_url('assets/images/icons/checkbox01.jpg');} ?>"></DIV>

<DIV style="left:446PX;top:245PX;width:17PX;height:17PX;TEXT-ALIGN:CENTER;"><img  WIDTH=15 HEIGHT=15 SRC="<?php if($month[1]=='03'){echo base_url('assets/images/icons/checkbox02.jpg');}else{echo base_url('assets/images/icons/checkbox01.jpg');} ?>"></DIV>

<DIV style="left:523PX;top:245PX;width:17PX;height:17PX;TEXT-ALIGN:CENTER;"><img  WIDTH=15 HEIGHT=15 SRC="<?php if($month[1]=='06'){echo base_url('assets/images/icons/checkbox02.jpg');}else{echo base_url('assets/images/icons/checkbox01.jpg');} ?>"></DIV>

<DIV style="left:598PX;top:245PX;width:17PX;height:17PX;TEXT-ALIGN:CENTER;"><img  WIDTH=15 HEIGHT=15 SRC="<?php if($month[1]=='09'){echo base_url('assets/images/icons/checkbox02.jpg');}else{echo base_url('assets/images/icons/checkbox01.jpg');} ?>"></DIV>

<DIV style="left:670PX;top:245PX;width:17PX;height:17PX;TEXT-ALIGN:CENTER;"><img  WIDTH=15 HEIGHT=15 SRC="<?php if($month[1]=='12'){echo base_url('assets/images/icons/checkbox02.jpg');}else{echo base_url('assets/images/icons/checkbox01.jpg');} ?>"></DIV>

<DIV style="left:579PX;top:148PX;width:15PX;height:15PX;TEXT-ALIGN:CENTER;"><img  WIDTH=15 HEIGHT=15 SRC="<?= base_url('assets/images/icons/checkbox01.jpg') ?>"></DIV>

<DIV style="left:456PX;top:281PX;width:301PX;height:27PX;"><span class="fc1-11">ใบเสร็จเล่มที่ .........................เลขที่ .....................................</span></DIV>

<DIV style="left:30PX;top:228PX;width:45PX;height:22PX;"><span class="fc1-2">ที่อยู่ :</span></DIV>

<DIV style="left:30PX;top:299PX;width:71PX;height:24PX;"><span class="fc1-0"> รหัสไปรษณีย์</span></DIV>

<DIV style="left:217PX;top:351PX;width:15PX;height:15PX;TEXT-ALIGN:CENTER;"><img  WIDTH=15 HEIGHT=15 SRC="<?= base_url('assets/images/icons/checkbox01.jpg') ?>"></DIV>

<DIV style="left:456PX;top:306PX;width:301PX;height:27PX;"><span class="fc1-11"> จำนวนเงิน...........................................&nbsp;&nbsp;บาท</span></DIV>

<DIV style="left:456PX;top:344PX;width:246PX;height:23PX;"><span class="fc1-11">ลงชื่อ.....................................................ผู้รับเงิน</span></DIV>

<DIV style="left:456PX;top:364PX;width:246PX;height:23PX;"><span class="fc1-11">วันที่.....................................................</span></DIV>

<DIV style="left:94PX;top:350PX;width:15PX;height:15PX;TEXT-ALIGN:CENTER;"><img  WIDTH=15 HEIGHT=15 SRC="<?= base_url('assets/images/icons/checkbox01.jpg') ?>"></DIV>

<DIV style="left:682PX;top:142PX;width:66PX;height:19PX;TEXT-ALIGN:CENTER;"><span class="fc1-2">2550</span></DIV>

<DIV style="left:66PX;top:413PX;width:224PX;height:23PX;"><span class="fc1-0">มีรายละเอียดการหักเป็นรายผู้มีเงินได้ ปรากฏตาม</span></DIV>

<DIV style="left:66PX;top:434PX;width:224PX;height:19PX;"><span class="fc1-12">(ให้แสดงรายละเอียดในใบแนบ ภ.ง.ด.1&nbsp;&nbsp;หรือในสื่อ</span></DIV>

<DIV style="left:66PX;top:454PX;width:125PX;height:21PX;"><span class="fc1-13">บันทึกในระบบคอมพิวเตอร์</span></DIV>

<DIV style="left:351PX;top:408PX;width:52PX;height:25PX;"><span class="fc1-5"> ใบแนบ</span></DIV>

<DIV style="left:467PX;top:408PX;width:97PX;height:27PX;"><span class="fc1-6">ที่แนบมาพร้อมนี้ :</span></DIV>

<DIV style="left:624PX;top:408PX;width:117PX;height:27PX;"><span class="fc1-6">จำนวน................แผ่น</span></DIV>

<DIV style="left:351PX;top:432PX;width:181PX;height:24PX;"><span class="fc1-5"> สื่อบันทึกในระบบคอมพิวเตอร์</span></DIV>

<DIV style="left:530PX;top:432PX;width:93PX;height:24PX;"><span class="fc1-6">ที่แนบมาพร้อมนี้ :</span></DIV>

<DIV style="left:351PX;top:452PX;width:390PX;height:19PX;"><span class="fc1-12">(ตามหนังสือแสดงความประสงค์ฯ ทะเบียนรับเลขที่...............................................................)</span></DIV>

<?php
  $page = $pamt / 8;
?>

<DIV style="left: 658px; top: 405px; width: 42PX; height: 24PX; TEXT-ALIGN: CENTER;"><span class="fc1-5"><?=number_format($page,0,'.',',');?></span></DIV>

<DIV style="left:191PX;top:454PX;width:99PX;height:21PX;">
<table width="94PX" border=0 cellpadding=0 cellspacing=0>
<tr><td class="fc1-12">อย่างใดอย่างหนึ่งเท่านั้น</td></tr>
<tr><td class="fc1-12">&nbsp;</td></tr></table>
</DIV>

<DIV style="left:404PX;top:402PX;width:62PX;height:28PX;"><span class="fc1-14">ภ.ง.ด.1 </span></DIV>

<DIV style="left:333PX;top:434PX;width:17PX;height:17PX;TEXT-ALIGN:CENTER;"><img  WIDTH=15 HEIGHT=15 SRC="<?= base_url('assets/images/icons/checkbox01.jpg') ?>"></DIV>

<DIV style="left:624PX;top:432PX;width:117PX;height:27PX;"><span class="fc1-6">จำนวน................แผ่น</span></DIV>

<DIV style="left:333PX;top:409PX;width:17PX;height:17PX;TEXT-ALIGN:CENTER;"><img  WIDTH=20 HEIGHT=18 SRC="<?= base_url('assets/images/icons/checkbox02.jpg') ?>"></DIV>

<DIV style="left:118PX;top:488PX;width:227PX;height:27PX;TEXT-ALIGN:CENTER;"><span class="fc1-15">สรุปรายการภาษีที่นำส่ง</span></DIV>

<DIV style="left:410PX;top:488PX;width:63PX;height:26PX;TEXT-ALIGN:CENTER;"><span class="fc1-16">จำนวนราย</span></DIV>

<DIV style="left:488PX;top:488PX;width:95PX;height:24PX;TEXT-ALIGN:CENTER;"><span class="fc1-16">เงินได้ทั้งสิ้น</span></DIV>

<DIV style="left:601PX;top:488PX;width:106PX;height:26PX;TEXT-ALIGN:CENTER;"><span class="fc1-16">ภาษีที่นำส่งทั้งสิ้น</span></DIV>

<DIV style="left:66PX;top:544PX;width:312PX;height:24PX;"><span class="fc1-17">2. เงินได้ตาม มาตรา 40 (1)&nbsp;&nbsp;เงินเดือน&nbsp;&nbsp;ค่าจ้าง&nbsp;&nbsp;ฯลฯ&nbsp;&nbsp;กรณีได้รับ</span></DIV>

<DIV style="left:66PX;top:521PX;width:312PX;height:22PX;"><span class="fc1-17">1. เงินได้ตาม มาตรา 40 (1)&nbsp;&nbsp;เงินเดือน&nbsp;&nbsp;ค่าจ้าง&nbsp;&nbsp;ฯลฯ&nbsp;&nbsp;กรณีทั่วไป</span></DIV>

<DIV style="left:82PX;top:564PX;width:295PX;height:24PX;"><span class="fc1-17">อนุมัติจากกรมสรรพากรให้หักอัตรา ร้อยละ&nbsp;&nbsp;3</span></DIV>

<DIV style="left:82PX;top:587PX;width:295PX;height:21PX;"><span class="fc1-18">(ตามหนังสือที่....................................ลงวันที่.........................</span></DIV>

<DIV style="left:66PX;top:607PX;width:312PX;height:22PX;"><span class="fc1-17">3. เงินได้ตาม มาตรา 40 (1)&nbsp;&nbsp;(2)&nbsp;&nbsp;กรณีนายจ้างจ่ายให้ครั้งเดียว</span></DIV>

<DIV style="left:66PX;top:652PX;width:312PX;height:24PX;">
<table width="307PX" border=0 cellpadding=0 cellspacing=0>
<tr><td class="fc1-17">4. เงินได้ตาม มาตรา 40 (2)&nbsp;&nbsp;กรณีผู้รับเงินได้เป็นผู้อยู่ในประเทศไ</td></tr>
<tr><td class="fc1-17">&nbsp;</td></tr></table>
</DIV>

<DIV style="left:82PX;top:630PX;width:295PX;height:22PX;"><span class="fc1-17">เพราะเหตุออกจากงาน</span></DIV>

<DIV style="left:66PX;top:678PX;width:312PX;height:24PX;"><span class="fc1-17">5. เงินได้ตาม มาตรา 40 (2)&nbsp;&nbsp;กรณีผู้รับเงินได้มิได้เป็นผู้อยู่ในปร</span></DIV>

<DIV style="left:66PX;top:706PX;width:310PX;height:24PX;"><span class="fc1-17">6. รวม</span></DIV>

<DIV style="left:66PX;top:732PX;width:312PX;height:24PX;"><span class="fc1-17">7. เงินเพิ่ม&nbsp;&nbsp;(ถ้ามี)</span></DIV>

<DIV style="left:66PX;top:759PX;width:312PX;height:24PX;"><span class="fc1-17">8. รวมยอดภาษีที่นำส่งทั้งสิ้น&nbsp;&nbsp;และเงินเพิ่ม&nbsp;&nbsp;(6. + 7.)</span></DIV>

<DIV style="left: 485px; top: 521PX; width: 92px; height: 21PX; TEXT-ALIGN: RIGHT;"><span class="fc1-6"><?=number_format($beamt,2,'.',',');?></span></DIV>
<DIV style="left: 606px; top: 521PX; width: 89px; height: 21PX; TEXT-ALIGN: RIGHT;"><span class="fc1-6"><?=number_format($wht,2,'.',',');?></span></DIV>
<DIV style="left: 602px; top: 704PX; width: 93px; height: 21PX; TEXT-ALIGN: RIGHT;"><span class="fc1-5"><?=number_format($wht,2,'.',',');?></span></DIV>
<DIV style="left: 486px; top: 704PX; width: 91px; height: 21PX; TEXT-ALIGN: RIGHT;"><span class="fc1-5"><?=number_format($beamt,2,'.',',');?></span></DIV>

<DIV style="left:409PX;top:521PX;width:63PX;height:21PX;TEXT-ALIGN:CENTER;"><span class="fc1-6"><?=number_format($pamt,0,'.',',');?></span></DIV>

<DIV style="left:411PX;top:704PX;width:65PX;height:21PX;TEXT-ALIGN:CENTER;"><span class="fc1-5"><?=number_format($pamt,0,'.',',');?></span></DIV>

<DIV style="left: 602px; top: 757PX; width: 93px; height: 21PX; TEXT-ALIGN: RIGHT;"><span class="fc1-5"><?=number_format($wht,2,'.',',');?></span></DIV>
<DIV style="left:168PX;top:796PX;width:448PX;height:24PX;TEXT-ALIGN:CENTER;"><span class="fc1-17">ข้าพเจ้าขอรับรองว่า&nbsp;&nbsp;รายการที่แจ้งไว้ข้างต้นนี้&nbsp;&nbsp;เป็นรายการที่ถูกต้องและครบถ้วนทุกประการ </span></DIV>

<DIV style="left:194PX;top:857PX;width:392PX;height:24PX;TEXT-ALIGN:CENTER;"><span class="fc1-17">ลงชื่อ .......................................................................ผู้จ่ายเงิน</span></DIV>

<DIV style="left: 590px; top: 883PX; width: 42PX; height: 42PX; TEXT-ALIGN: CENTER;"><img  WIDTH=42 HEIGHT=42 SRC="<?= base_url('assets/images/icons/seal.jpg') ?>"></DIV>

<DIV style="left:190PX;top:883PX;width:392PX;height:24PX;TEXT-ALIGN:CENTER;"><span class="fc1-17">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;( .........................................................................)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></DIV>
<DIV style="left:194PX;top:911PX;width:392PX;height:24PX;TEXT-ALIGN:CENTER;"><span class="fc1-17">ตำแหน่ง ..................................................................................</span></DIV>

<DIV style="left:194PX;top:937PX;width:392PX;height:24PX;TEXT-ALIGN:CENTER;"><span class="fc1-17">ยื่นวันที่.............เดือน................................พ .ศ. .......................</span></DIV>

<DIV style="left:278PX;top:932PX;width:34PX;height:19PX;TEXT-ALIGN:CENTER;"><span class="fc1-20">17</span></DIV>

<DIV style="left:346PX;top:932PX;width:86PX;height:19PX;TEXT-ALIGN:CENTER;"><span class="fc1-20">ธันวาคม</span></DIV>

<DIV style="left:465PX;top:932PX;width:58PX;height:19PX;TEXT-ALIGN:CENTER;"><span class="fc1-20">2556</span></DIV>
<BR>
</BODY></HTML>


<?php
	}
   
}

?>