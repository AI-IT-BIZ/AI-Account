<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rpnd3wht_docket extends CI_Controller {
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
		
		//$balwr = $this->input->get('balwr');
		$date =	$this->input->get('bldat');
		$copies =	$this->input->get('copies');
		//$no = $type = $this->uri->segment(4);
		//$copies = intval($type = $this->uri->segment(5));
		$month = explode('-',$date);
		$dt_result = util_helper_get_sql_between_month($date);
		$text_month = $this->convert_amount->text_month($month[1]);
		
		//$taxid = str_split('1234567890123');
		
		if($copies<=0) $copies = 1;
	
		//Purchase
		$strSQL="";
		$strSQL = " select v_ebbp.*";
        $strSQL = $strSQL . " from v_ebbp ";
        $strSQL = $strSQL . " Where v_ebbp.vtype = '02' and v_ebbp.bldat ".$dt_result;
		$strSQL .= " ORDER BY payno ASC";
       
		$query = $this->db->query($strSQL);
		$r_data = $query->first_row('array');
		// calculate sum
		$rowp = $query->result_array();
		$tline = count($rowp);
		
		$purch_amt=0;$purch_wht=0;
		foreach ($rowp as $key => $item) {
		   $purch_amt += $item['beamt'];
		   $purch_wht += $item['wht01'];
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
<STYLE>
 A {text-decoration:none}
 A IMG {border-style:none; border-width:0;}
 DIV {position:absolute; z-index:25;}
.fc1-0 { COLOR:000000;FONT-SIZE:11PT;FONT-FAMILY:CordiaUPC;FONT-WEIGHT:NORMAL;}
.fc1-1 { COLOR:000000;FONT-SIZE:11PT;FONT-FAMILY:Wingdings;FONT-WEIGHT:NORMAL;}
.fc1-2 { COLOR:000000;FONT-SIZE:11PT;FONT-FAMILY:AngsanaUPC;FONT-WEIGHT:BOLD;}
.fc1-3 { COLOR:000000;FONT-SIZE:11PT;FONT-FAMILY:AngsanaUPC;FONT-WEIGHT:NORMAL;}
.fc1-4 { COLOR:000000;FONT-SIZE:10PT;FONT-FAMILY:CordiaUPC;FONT-WEIGHT:NORMAL;}
.fc1-5 { COLOR:000000;FONT-SIZE:10PT;FONT-FAMILY:Wingdings;FONT-WEIGHT:NORMAL;}
.fc1-6 { COLOR:000000;FONT-SIZE:11PT;FONT-FAMILY:CordiaUPC;FONT-WEIGHT:BOLD;}
.fc1-7 { COLOR:000000;FONT-SIZE:9PT;FONT-FAMILY:Arial;FONT-WEIGHT:BOLD;}
.fc1-8 { COLOR:000000;FONT-SIZE:9PT;FONT-FAMILY:Arial;FONT-WEIGHT:NORMAL;}
.fc1-9 { COLOR:000000;FONT-SIZE:10PT;FONT-FAMILY:AngsanaUPC;FONT-WEIGHT:BOLD;}
.fc1-10 { COLOR:000000;FONT-SIZE:8PT;FONT-FAMILY:CordiaUPC;FONT-WEIGHT:NORMAL;FONT-STYLE:ITALIC;}
.fc1-11 { COLOR:000000;FONT-SIZE:11PT;FONT-FAMILY:CordiaUPC;FONT-WEIGHT:NORMAL;FONT-STYLE:ITALIC;}
.fc1-12 { COLOR:000000;FONT-SIZE:15PT;FONT-FAMILY:EucrosiaUPC;FONT-WEIGHT:BOLD;}
.fc1-13 { COLOR:000000;FONT-SIZE:13PT;FONT-FAMILY:Wingdings;FONT-WEIGHT:NORMAL;}
.fc1-14 { COLOR:000000;FONT-SIZE:10PT;FONT-FAMILY:CordiaUPC;FONT-WEIGHT:NORMAL;FONT-STYLE:ITALIC;}
.fc1-15 { COLOR:000000;FONT-SIZE:13PT;FONT-FAMILY:AngsanaUPC;FONT-WEIGHT:BOLD;}
.fc1-16 { COLOR:000000;FONT-SIZE:13PT;FONT-FAMILY:EucrosiaUPC;FONT-WEIGHT:NORMAL;}
.fc1-17 { COLOR:000000;FONT-SIZE:12PT;FONT-FAMILY:CordiaUPC;FONT-WEIGHT:NORMAL;FONT-STYLE:ITALIC;}
.fc1-18 { COLOR:000000;FONT-SIZE:13PT;FONT-FAMILY:CordiaUPC;FONT-WEIGHT:NORMAL;}
.fc1-19 { COLOR:808080;FONT-SIZE:8PT;FONT-FAMILY:AngsanaUPC;FONT-WEIGHT:NORMAL;}
.fc1-20 { COLOR:000000;FONT-SIZE:10PT;FONT-FAMILY:CordiaUPC;FONT-WEIGHT:NORMAL;TEXT-DECORATION:UNDERLINE;}
.ad1-0 {border-color:000000;border-style:none;border-bottom-width:0PX;border-left-width:0PX;border-top-width:0PX;border-right-width:0PX;}
.ad1-1 {border-color:000000;border-style:none;border-bottom-width:0PX;border-left-width:0PX;border-top-width:0PX;border-right-width:0PX;}
.ad1-2 {border-color:808080;border-style:none;border-bottom-width:0PX;border-left-width:0PX;border-top-style:solid;border-top-width:1PX;border-right-width:0PX;}
.ad1-3 {border-color:808080;border-style:none;border-bottom-width:0PX;border-left-style:solid;border-left-width:1PX;border-top-width:0PX;border-right-width:0PX;}
.ad1-4 {border-color:808080;border-style:none;border-bottom-width:0PX;border-left-width:0PX;border-top-style:solid;border-top-width:2PX;border-right-width:0PX;}
.ad1-5 {border-color:D4D6E4;border-style:none;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;}
.ad1-6 {border-color:808080;border-style:none;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;}
.ad1-7 {border-color:808080;border-style:none;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;}
.ad1-8 {border-color:D4D6E4;border-style:none;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;}
.ad1-9 {border-color:808080;border-style:none;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;}
</STYLE>

<TITLE>Crystal Report Viewer</TITLE>
<BODY BGCOLOR="FFFFFF"LEFTMARGIN=0 TOPMARGIN=0 BOTTOMMARGIN=0 RIGHTMARGIN=0>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<DIV style="z-index:0"> &nbsp; </div>

<div style="left:40PX;top:387PX;border-color:808080;border-style:solid;border-width:0px;border-top-width:1PX;width:727PX;">
</div>
<div style="left:450PX;top:109PX;border-color:808080;border-style:solid;border-width:0px;border-left-width:1PX;height:279PX;">
<table width="0px" height="273PX"><td>&nbsp;</td></table>
</div>
<div style="left:450PX;top:276PX;border-color:808080;border-style:solid;border-width:0px;border-top-width:2PX;width:316PX;">
</div>
<div style="left:450PX;top:387PX;border-color:808080;border-style:solid;border-width:0px;border-top-width:2PX;width:316PX;">
</div>
<div style="left:40PX;top:323PX;border-color:808080;border-style:solid;border-width:0px;border-top-width:1PX;width:412PX;">
</div>
<div style="left:695PX;top:604PX;border-color:808080;border-style:solid;border-width:0px;border-left-width:1PX;height:23PX;">
<table width="0px" height="17PX"><td>&nbsp;</td></table>
</div>
<div style="left:695PX;top:630PX;border-color:808080;border-style:solid;border-width:0px;border-left-width:1PX;height:24PX;">
<table width="0px" height="18PX"><td>&nbsp;</td></table>
</div>
<div style="left:695PX;top:656PX;border-color:808080;border-style:solid;border-width:0px;border-left-width:1PX;height:24PX;">
<table width="0px" height="18PX"><td>&nbsp;</td></table>
</div>
<div style="left:695PX;top:682PX;border-color:808080;border-style:solid;border-width:0px;border-left-width:1PX;height:24PX;">
<table width="0px" height="18PX"><td>&nbsp;</td></table>
</div>
<div style="left:40PX;top:727PX;border-color:808080;border-style:solid;border-width:0px;border-top-width:1PX;width:728PX;">
</div>
<div style="left:40PX;top:922PX;border-color:808080;border-style:solid;border-width:0px;border-top-width:1PX;width:728PX;">
</div>

<DIV class="box" style="z-index:10; border-color:D4D6E4;border-style:solid;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;left:138PX;top:576PX;width:461PX;height:28PX;background-color:D4D6E4;layer-background-color:D4D6E4;">
<table border=0 cellpadding=0 cellspacing=0 width=454px height=21px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV class="box" style="z-index:10; border-color:808080;border-style:solid;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;left:603PX;top:604PX;width:118PX;height:23PX;">
<table border=0 cellpadding=0 cellspacing=0 width=111px height=16px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV class="box" style="z-index:10; border-color:808080;border-style:solid;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;left:603PX;top:630PX;width:118PX;height:23PX;background-color:E8EAF8;layer-background-color:E8EAF8;">
<table border=0 cellpadding=0 cellspacing=0 width=111px height=16px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV class="box" style="z-index:10; border-color:808080;border-style:solid;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;left:603PX;top:656PX;width:118PX;height:23PX;">
<table border=0 cellpadding=0 cellspacing=0 width=111px height=16px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV class="box" style="z-index:10; border-color:808080;border-style:solid;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;left:603PX;top:682PX;width:118PX;height:23PX;background-color:E8EAF8;layer-background-color:E8EAF8;">
<table border=0 cellpadding=0 cellspacing=0 width=111px height=16px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV class="box" style="z-index:10; border-color:D4D6E4;border-style:solid;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;left:601PX;top:576PX;width:120PX;height:28PX;">
<table border=0 cellpadding=0 cellspacing=0 width=113px height=20px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV style="z-index:15;left:40PX;top:38PX;width:725PX;height:70PX;">
<img  WIDTH=708 HEIGHT=67 SRC="<?= base_url('assets/images/icons/pnd3.jpg') ?>">
</DIV>
<DIV style="left:456PX;top:135PX;width:85PX;height:28PX;"><span class="fc1-0">(ให้ทำเครื่องหมาย "</span></DIV>

<DIV style="left:546PX;top:137PX;width:20PX;height:18PX;TEXT-ALIGN:CENTER;">
<img  WIDTH=20 HEIGHT=18 SRC="<?= base_url('assets/images/icons/checkbox02.jpg') ?>">
</DIV>

<DIV style="left:561PX;top:135PX;width:35PX;height:28PX;"><span class="fc1-0">" ลงใน "</span></DIV>

<DIV style="left:594PX;top:137PX;width:15PX;height:24PX;TEXT-ALIGN:CENTER;">
<img  WIDTH=15 HEIGHT=15 SRC="<?= base_url('assets/images/icons/checkbox01.jpg') ?>">
</DIV>

<DIV style="left:610PX;top:135PX;width:141PX;height:28PX;"><span class="fc1-0">" หน้าชื่อเดือน) พ.ศ. ................</span></DIV>

<DIV style="left:40PX;top:148PX;width:127PX;height:23PX;"><span class="fc1-2">ชื่อผู้มีหน้าที่หักภาษี ณ ที่จ่าย</span></DIV>

<DIV style="left:315PX;top:148PX;width:54PX;height:23PX;TEXT-ALIGN:RIGHT;"><span class="fc1-3">สาขาที่</span></DIV>

<DIV style="left:40PX;top:205PX;width:35PX;height:25PX;"><span class="fc1-2">ที่อยู่:</span></DIV>

<DIV style="left:40PX;top:279PX;width:62PX;height:24PX;"><span class="fc1-4">รหัสไปรษณีย์</span></DIV>

<DIV style="left:190PX;top:278PX;width:50PX;height:24PX;"><span class="fc1-3">โทรศัพท์:</span></DIV>

<DIV style="left:472PX;top:181PX;width:55PX;height:19PX;"><span class="fc1-4">(1) มกราคม</span></DIV>

<DIV style="left:546PX;top:181PX;width:61PX;height:21PX;"><span class="fc1-4">(4) เมษายน</span></DIV>

<DIV style="left:472PX;top:212PX;width:59PX;height:21PX;"><span class="fc1-4">(2) กุมภาพันธ์</span></DIV>

<DIV style="left:468PX;top:245PX;width:55PX;height:21PX;"><span class="fc1-4">(3) มีนาคม</span></DIV>

<DIV style="left:546PX;top:212PX;width:61PX;height:21PX;"><span class="fc1-4">(5) พฤษภาคม</span></DIV>

<DIV style="left:546PX;top:245PX;width:61PX;height:21PX;"><span class="fc1-4">(6) มิถุนายน</span></DIV>

<DIV style="left:622PX;top:181PX;width:59PX;height:21PX;"><span class="fc1-4">(7) กรกฎาคม</span></DIV>

<DIV style="left:622PX;top:212PX;width:59PX;height:21PX;"><span class="fc1-4">(8) สิงหาคม</span></DIV>

<DIV style="left:622PX;top:245PX;width:59PX;height:22PX;"><span class="fc1-4">(9) กันยายน</span></DIV>

<DIV style="left:696PX;top:181PX;width:68PX;height:21PX;"><span class="fc1-4">(10) ตุลาคม</span></DIV>

<DIV style="left:696PX;top:212PX;width:68PX;height:21PX;"><span class="fc1-4">(11) พฤศจิกายน</span></DIV>

<DIV style="left:696PX;top:245PX;width:66PX;height:22PX;"><span class="fc1-4">(12) ธันวาคม</span></DIV>

<DIV style="left:128PX;top:342PX;width:83PX;height:23PX;"><span class="fc1-3">(1) ยื่นปกติ</span></DIV>

<DIV style="left:260PX;top:342PX;width:158PX;height:24PX;"><span class="fc1-3">(2) ยื่นเพิ่มเติมครั้งที่ .................</span></DIV>

<DIV style="left:454PX;top:182PX;width:15PX;height:21PX;"><img  WIDTH=15 HEIGHT=15 SRC="<?php if($month[1]=='01'){echo base_url('assets/images/icons/checkbox02.jpg');}else{echo base_url('assets/images/icons/checkbox01.jpg');} ?>"></DIV>

<DIV style="left:454PX;top:215PX;width:15PX;height:23PX;"><img  WIDTH=15 HEIGHT=15 SRC="<?php if($month[1]=='02'){echo base_url('assets/images/icons/checkbox02.jpg');}else{echo base_url('assets/images/icons/checkbox01.jpg');} ?>"></DIV>

<DIV style="left:454PX;top:248PX;width:15PX;height:25PX;"><img  WIDTH=15 HEIGHT=15 SRC="<?php if($month[1]=='03'){echo base_url('assets/images/icons/checkbox02.jpg');}else{echo base_url('assets/images/icons/checkbox01.jpg');} ?>"></DIV>

<DIV style="left:530PX;top:182PX;width:16PX;height:25PX;"><img  WIDTH=15 HEIGHT=15 SRC="<?php if($month[1]=='04'){echo base_url('assets/images/icons/checkbox02.jpg');}else{echo base_url('assets/images/icons/checkbox01.jpg');} ?>"></DIV>

<DIV style="left:530PX;top:215PX;width:16PX;height:23PX;"><img  WIDTH=15 HEIGHT=15 SRC="<?php if($month[1]=='05'){echo base_url('assets/images/icons/checkbox02.jpg');}else{echo base_url('assets/images/icons/checkbox01.jpg');} ?>"></DIV>

<DIV style="left:530PX;top:248PX;width:16PX;height:25PX;"><img  WIDTH=15 HEIGHT=15 SRC="<?php if($month[1]=='06'){echo base_url('assets/images/icons/checkbox02.jpg');}else{echo base_url('assets/images/icons/checkbox01.jpg');} ?>"></DIV>

<DIV style="left:606PX;top:182PX;width:15PX;height:25PX;"><img  WIDTH=15 HEIGHT=15 SRC="<?php if($month[1]=='07'){echo base_url('assets/images/icons/checkbox02.jpg');}else{echo base_url('assets/images/icons/checkbox01.jpg');} ?>"></DIV>

<DIV style="left:606PX;top:215PX;width:15PX;height:23PX;"><img  WIDTH=15 HEIGHT=15 SRC="<?php if($month[1]=='08'){echo base_url('assets/images/icons/checkbox02.jpg');}else{echo base_url('assets/images/icons/checkbox01.jpg');} ?>"></DIV>

<DIV style="left:606PX;top:248PX;width:15PX;height:25PX;"><img  WIDTH=15 HEIGHT=15 SRC="<?php if($month[1]=='09'){echo base_url('assets/images/icons/checkbox02.jpg');}else{echo base_url('assets/images/icons/checkbox01.jpg');} ?>"></DIV>

<DIV style="left:679PX;top:182PX;width:15PX;height:25PX;"><img  WIDTH=15 HEIGHT=15 SRC="<?php if($month[1]=='10'){echo base_url('assets/images/icons/checkbox02.jpg');}else{echo base_url('assets/images/icons/checkbox01.jpg');} ?>"></DIV>

<DIV style="left:679PX;top:215PX;width:15PX;height:23PX;"><img  WIDTH=15 HEIGHT=15 SRC="<?php if($month[1]=='11'){echo base_url('assets/images/icons/checkbox02.jpg');}else{echo base_url('assets/images/icons/checkbox01.jpg');} ?>"></DIV>

<DIV style="left:679PX;top:248PX;width:13PX;height:25PX;">
<img  WIDTH=15 HEIGHT=15 SRC="<?php if($month[1]=='12'){echo base_url('assets/images/icons/checkbox02.jpg');}else{echo base_url('assets/images/icons/checkbox01.jpg');} ?>">
</DIV>

<DIV style="left:111PX;top:345PX;width:15PX;height:20PX;"><img  WIDTH=15 HEIGHT=15 SRC="<?= base_url('assets/images/icons/checkbox01.jpg') ?>"></DIV>

<DIV style="left:242PX;top:345PX;width:15PX;height:20PX;"><img  WIDTH=15 HEIGHT=15 SRC="<?= base_url('assets/images/icons/checkbox01.jpg') ?>"></DIV>

<DIV style="left:40PX;top:170PX;width:374PX;height:28PX;"><span class="fc1-6">บริษัท ตัวอย่าง จำกัด</span></DIV>

<DIV style="left:371PX;top:149PX;width:67PX;height:21PX;TEXT-ALIGN:RIGHT;"><span class="fc1-7">0000</span></DIV>

<DIV style="left:76PX;top:207PX;width:361PX;height:68PX;">
<table width="356PX" border=0 cellpadding=0 cellspacing=0>
<tr><td class="fc1-6"><?=$r_com['adr01'];?></td></tr>
<tr><td class="fc1-6"><?=$r_com['distx'];?></td></tr></table>
</DIV>

<DIV style="left:215PX;top:113PX;width:223PX;height:26PX;TEXT-ALIGN:RIGHT;"><span class="fc1-7"><?= $r_com['taxid']; ?></span></DIV>

<DIV style="left:695PX;top:135PX;width:56PX;height:17PX;TEXT-ALIGN:CENTER;"><span class="fc1-8">2556</span></DIV>

<DIV style="left:40PX;top:109PX;width:168PX;height:21PX;"><span class="fc1-9">เลขประจำตัวผู้เสียภาษีอากร(13หลัก)*</span></DIV>

<DIV style="left:97PX;top:127PX;width:112PX;height:15PX;"><span class="fc1-10"> (ของผู้มีหน้าที่หัก ภาษี ณ ที่จ่าย)</span></DIV>

<DIV style="left: 94px; top: 280px; width: 59px; height: 26PX; TEXT-ALIGN: LEFT;"><span class="fc1-7"><?=$r_com['pstlz'];?></span></DIV>

<DIV style="left: 243px; top: 281px; width: 97px; height: 26PX; TEXT-ALIGN: LEFT;"><span class="fc1-7"><?=$r_com['telf1'];?></span></DIV>

<DIV style="left:456PX;top:109PX;width:135PX;height:23PX;"><span class="fc1-2">เดือนที่จ่ายเงินได้พึงประเมิน</span></DIV>

<DIV style="left:166PX;top:148PX;width:67PX;height:21PX;"><span class="fc1-11">( หน่วยงาน ) :</span></DIV>

<DIV style="left:86PX;top:396PX;width:72PX;height:24PX;"><span class="fc1-3">นำส่งภาษีตาม</span></DIV>

<DIV style="left:178PX;top:397PX;width:15PX;height:21PX;"><img  WIDTH=15 HEIGHT=15 SRC="<?= base_url('assets/images/icons/checkbox01.jpg') ?>"></DIV>

<DIV style="left:202PX;top:396PX;width:90PX;height:24PX;"><span class="fc1-3"> (1)&nbsp;&nbsp;มาตรา 3 เตรส</span></DIV>

<DIV style="left:356PX;top:396PX;width:89PX;height:22PX;"><span class="fc1-3"> (2)&nbsp;&nbsp;&nbsp;มาตรา 48 ทวิ</span></DIV>

<DIV style="left:514PX;top:396PX;width:111PX;height:22PX;"><span class="fc1-3"> (3) มาตรา 50 (3) (4) (5)</span></DIV>

<DIV style="left:329PX;top:397PX;width:15PX;height:21PX;"><img  WIDTH=15 HEIGHT=15 SRC="<?= base_url('assets/images/icons/checkbox01.jpg') ?>"></DIV>

<DIV style="left:487PX;top:397PX;width:15PX;height:21PX;"><img  WIDTH=15 HEIGHT=15 SRC="<?= base_url('assets/images/icons/checkbox01.jpg') ?>"></DIV>

<DIV style="left:88PX;top:441PX;width:231PX;height:43PX;">
<table width="226PX" border=0 cellpadding=0 cellspacing=0><td class="fc1-0">มีรายละเอียดการหักเป็นรายผู้มีเงินได้&nbsp;&nbsp;&nbsp;ปรากฏตาม</td></table>

<table width="226PX" border=0 cellpadding=0 cellspacing=0><td class="fc1-0">รายการที่แนบอย่างใดอย่างหนึ่ง&nbsp;&nbsp;ดังนี้</td></table>
</DIV>

<DIV style="left:409PX;top:429PX;width:35PX;height:23PX;"><span class="fc1-2">ใบแนบ</span></DIV>

<DIV style="left:495PX;top:430PX;width:85PX;height:23PX;"><span class="fc1-0">ที่แนบมาพร้อมนี้ :</span></DIV>

<DIV style="left:443PX;top:427PX;width:50PX;height:24PX;"><span class="fc1-12">ภ.ง.ด.3 </span></DIV>

<DIV style="left:409PX;top:463PX;width:41PX;height:23PX;"><span class="fc1-2">หรือ</span></DIV>

<DIV style="left:632PX;top:429PX;width:127PX;height:27PX;TEXT-ALIGN:RIGHT;"><span class="fc1-0">จำนวน.......................ราย</span></DIV>

<DIV style="left:379PX;top:430PX;width:20PX;height:18PX;"><img  WIDTH=20 HEIGHT=18 SRC="<?= base_url('assets/images/icons/checkbox02.jpg') ?>"></DIV>

<DIV style="left:632PX;top:455PX;width:127PX;height:27PX;TEXT-ALIGN:RIGHT;"><span class="fc1-0">จำนวน......................แผ่น</span></DIV>

<?php
  $page = $tline / 5;
?>
<DIV style="left:676PX;top:425PX;width:66PX;height:26PX;TEXT-ALIGN:CENTER;"><span class="fc1-8"><?=number_format($tline,0,'.',',');?></span></DIV>
<DIV style="left:676PX;top:451PX;width:66PX;height:20PX;TEXT-ALIGN:CENTER;"><span class="fc1-8"><?=number_format($page,0,'.',',');?></span></DIV>

<DIV style="left:409PX;top:500PX;width:137PX;height:23PX;"><span class="fc1-2">สื่อบันทึกในระบบคอมพิวเตอร์</span></DIV>

<DIV style="left:379PX;top:502PX;width:15PX;height:21PX;"><img  WIDTH=15 HEIGHT=15 SRC="<?= base_url('assets/images/icons/checkbox01.jpg') ?>"></DIV>

<DIV style="left:546PX;top:502PX;width:85PX;height:23PX;"><span class="fc1-0">ที่แนบมาพร้อมนี้ :</span></DIV>

<DIV style="left:634PX;top:502PX;width:127PX;height:27PX;TEXT-ALIGN:RIGHT;"><span class="fc1-0">จำนวน.......................ราย</span></DIV>

<DIV style="left:634PX;top:526PX;width:127PX;height:27PX;TEXT-ALIGN:RIGHT;"><span class="fc1-0">จำนวน......................แผ่น</span></DIV>

<DIV style="left:405PX;top:550PX;width:361PX;height:19PX;"><span class="fc1-14">(ตามหนังสือแสดงความประสงค์ฯ ทะเบียนรับเลขที่.........................................................) </span></DIV>

<DIV style="left:173PX;top:576PX;width:395PX;height:27PX;TEXT-ALIGN:CENTER;"><span class="fc1-15">สรุปรายการภาษีที่นำส่ง </span></DIV>

<DIV style="left:144PX;top:607PX;width:121PX;height:22PX;"><span class="fc1-16">1. รวมยอดเงินได้ทั้งสิ้น </span></DIV>

<DIV style="left:144PX;top:633PX;width:147PX;height:22PX;"><span class="fc1-16">2. รวมยอดภาษีที่นำส่งทั้งสิ้น</span></DIV>

<DIV style="left:144PX;top:659PX;width:55PX;height:21PX;"><span class="fc1-16">3. เงินเพิ่</span></DIV>

<DIV style="left:144PX;top:685PX;width:274PX;height:21PX;"><span class="fc1-16">4. รวมยอดภาษีที่นำส่งทั้งสิ้น และเงินเพิ่ม (2. + 3.)</span></DIV>

<DIV style="left: 601px; top: 607PX; width: 110px; height: 21PX; TEXT-ALIGN: RIGHT;"><span class="fc1-8"><?=number_format($purch_amt,2,'.',',');?></span></DIV>
<DIV style="left: 602px; top: 633PX; width: 109px; height: 21PX; TEXT-ALIGN: RIGHT;"><span class="fc1-8"><?=number_format($purch_wht,2,'.',',');?></span></DIV>
<DIV style="left: 602px; top: 685PX; width: 109px; height: 21PX; TEXT-ALIGN: RIGHT;"><span class="fc1-8"><?=number_format($purch_wht,2,'.',',');?></span></DIV>
<DIV style="left:622PX;top:578PX;width:79PX;height:23PX;TEXT-ALIGN:CENTER;"><span class="fc1-2">จำนวนเงิน</span></DIV>

<DIV style="left:268PX;top:613PX;width:326PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.</span></DIV>

<DIV style="left:291PX;top:637PX;width:303PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.</span></DIV>

<DIV style="left:234PX;top:663PX;width:359PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.</span></DIV>

<DIV style="left:201PX;top:659PX;width:29PX;height:24PX;"><span class="fc1-17">(ถ้ามี)</span></DIV>

<DIV style="left:416PX;top:689PX;width:178PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.</span></DIV>

<DIV style="left:209PX;top:749PX;width:465PX;height:21PX;"><span class="fc1-18">ข้าพเจ้าขอรับรองว่า รายการที่แจ้งไว้ข้างต้นนี้&nbsp;&nbsp;&nbsp;เป็นรายการที่ถูกต้องและครบถ้วนทุกประการ</span></DIV>

<DIV style="left:208PX;top:806PX;width:455PX;height:27PX;TEXT-ALIGN:CENTER;"><span class="fc1-18">ลงชื่อ ..................................................................... ผู้จ่ายเงิน</span></DIV>

<DIV style="left:208PX;top:833PX;width:455PX;height:25PX;TEXT-ALIGN:CENTER;"><span class="fc1-18">(.......................................................................)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></DIV>

<DIV style="left:208PX;top:857PX;width:455PX;height:23PX;TEXT-ALIGN:CENTER;"><span class="fc1-18">ตำแหน่ง ..............................................................................................</span></DIV>

<DIV style="left:208PX;top:881PX;width:455PX;height:27PX;TEXT-ALIGN:CENTER;"><span class="fc1-18"> ยื่นวันที่ ............ เดือน ............................................. พ.ศ. ....................</span></DIV>

<DIV style="left:667PX;top:823PX;width:43PX;height:48PX;TEXT-ALIGN:CENTER;">
<img  WIDTH=42 HEIGHT=42 SRC="<?= base_url('assets/images/icons/seal.jpg') ?>">
</DIV>

<DIV style="left:48PX;top:934PX;width:43PX;height:21PX;"><span class="fc1-20">หมายเหตุ</span></DIV>

<DIV style="left:91PX;top:934PX;width:467PX;height:67PX;">
<table width="462PX" border=0 cellpadding=0 cellspacing=0><td class="fc1-4">เลขประจำตัวผู้เสียภาษีอากร (13หลัก)* หมายถึง</td></table>

<table width="462PX" border=0 cellpadding=0 cellspacing=0><td class="fc1-4">1. กรณีบุคคลธรรมดาไทย ให้ใช้เลขประจำตัวประชาชนของกรมการปกครอง</td></table>

<table width="462PX" border=0 cellpadding=0 cellspacing=0><td class="fc1-4">2. กรณีนิติบุคคล ให้ใช้เลขทะเบียนนิติบุคคลของกรมพัฒนาธุรกิจการค้า</td></table>

<table width="462PX" border=0 cellpadding=0 cellspacing=0><td class="fc1-4">3. กรณีอื่นๆนอกเหนือจาก 1. และ 2. ให้ใช้เลขประจำตัวผู้เสียภาษีอากร (13หลัก)ของกรมสรรพากร</td></table>
</DIV>

<DIV style="z-index:15;left:50PX;top:1043PX;width:397PX;height:24PX;">
<img  WIDTH=392 HEIGHT=22 SRC="<?= base_url('assets/images/icons/pnd53_02.jpg') ?>">
</DIV><BR>
</BODY></HTML>


<?php
	}
   
}

?>