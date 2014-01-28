<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rsumwht_docket extends CI_Controller {
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
	
		$strSQL="";
		$strSQL = " select v_ebbp.*";
        $strSQL = $strSQL . " from v_ebbp ";
        $strSQL = $strSQL . " Where v_ebbp.type1 = '1' and v_ebbp.bldat ".$dt_result;
		$strSQL = $strSQL . " And v_ebbp.statu = '02' ";
		$strSQL .= " ORDER BY payno ASC";
		//echo $strSQL;
       
		$query = $this->db->query($strSQL);
		$r_data = $query->first_row('array');
		// calculate sum
		$rowp = $query->result_array();
		$tline = count($rowp);
		
		$purch_amt=0;$purch_wht=0;
		foreach ($rowp as $key => $item) {
		   $purch_amt += $item['beamt'] - $item['dismt'];
		   $purch_wht += $item['wht01'];
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
<link rel="stylesheet" href="<?= base_url('assets/css/fonts/AngsanaNew/font.css') ?>" />
<STYLE>
body { font-family: 'angsana_newregular'; }
 A {text-decoration:none}
 A IMG {border-style:none; border-width:0;}
 DIV {position:absolute; z-index:25;}
.fc1-0 { COLOR:000000;FONT-SIZE:11PT;FONT-FAMILY:'angsana_newbold';}
.fc1-1 { COLOR:000000;FONT-SIZE:9PT;FONT-WEIGHT:NORMAL;}
.fc1-2 { COLOR:000000;FONT-SIZE:10PT;FONT-WEIGHT:NORMAL;}
.fc1-3 { COLOR:000000;FONT-SIZE:11PT;FONT-WEIGHT:NORMAL;}
.fc1-4 { COLOR:000000;FONT-SIZE:10PT;FFONT-WEIGHT:NORMAL;}
.fc1-5 { COLOR:000000;FONT-SIZE:12PT;FONT-WEIGHT:NORMAL;}
.fc1-6 { COLOR:000000;FONT-SIZE:11PT;FONT-WEIGHT:NORMAL;}
.fc1-7 { COLOR:000000;FONT-SIZE:11PT;FONT-FAMILY:'angsana_newbold';}
.fc1-8 { COLOR:000000;FONT-SIZE:11PT;FONT-FAMILY:'angsana_newbold';}
.fc1-9 { COLOR:000000;FONT-SIZE:12PT;FONT-WEIGHT:NORMAL;}
.fc1-10 { COLOR:000000;FONT-SIZE:9PT;FONT-WEIGHT:NORMAL;}
.fc1-11 { COLOR:000000;FONT-SIZE:10PT;FONT-FAMILY:'angsana_newbold';}
.fc1-12 { COLOR:000000;FONT-SIZE:8PT;FONT-WEIGHT:NORMAL;FONT-STYLE:ITALIC;}
.fc1-13 { COLOR:000000;FONT-SIZE:9PT;FONT-FAMILY:'angsana_newbold';}
.fc1-14 { COLOR:000000;FONT-SIZE:11PT;FONT-WEIGHT:NORMAL;FONT-STYLE:ITALIC;}
.fc1-15 { COLOR:000000;FONT-SIZE:11PT;FONT-WEIGHT:NORMAL;}
.fc1-16 { COLOR:000000;FONT-SIZE:15PT;FONT-FAMILY:'angsana_newbold';}
.fc1-17 { COLOR:000000;FONT-SIZE:13PT;FONT-WEIGHT:NORMAL;}
.fc1-18 { COLOR:000000;FONT-SIZE:10PT;;FONT-WEIGHT:NORMAL;FONT-STYLE:ITALIC;}
.fc1-19 { COLOR:000000;FONT-SIZE:13PT;FONT-WEIGHT:NORMAL;}
.fc1-20 { COLOR:000000;FONT-SIZE:13PT;FONT-WEIGHT:NORMAL;}
.fc1-21 { COLOR:000000;FONT-SIZE:8PT;FONT-FAMILY:'angsana_newbold';}
.fc1-22 { COLOR:000000;FONT-SIZE:12PT;FONT-WEIGHT:NORMAL;FONT-STYLE:ITALIC;}
.fc1-23 { COLOR:000000;FONT-SIZE:13PT;FONT-WEIGHT:NORMAL;}
.fc1-24 { COLOR:808080;FONT-SIZE:7PT;FONT-WEIGHT:NORMAL;}
.fc1-25 { COLOR:000000;FONT-SIZE:10PT;FONT-WEIGHT:NORMAL;TEXT-DECORATION:UNDERLINE;}
.fc1-26 { COLOR:000000;FONT-SIZE:10PT;FONT-FAMILY:AngsanaUPC;FONT-WEIGHT:NORMAL;}
.ad1-0 {border-color:000000;border-style:none;border-bottom-width:0PX;border-left-width:0PX;border-top-width:0PX;border-right-width:0PX;}
.ad1-1 {border-color:000000;border-style:none;border-bottom-width:0PX;border-left-width:0PX;border-top-width:0PX;border-right-width:0PX;}
.ad1-2 {border-color:AED2E6;border-style:none;border-bottom-width:0PX;border-left-style:solid;border-left-width:1PX;border-top-width:0PX;border-right-width:0PX;}
.ad1-3 {border-color:AED2E6;border-style:none;border-bottom-width:0PX;border-left-width:0PX;border-top-style:solid;border-top-width:1PX;border-right-width:0PX;}
.ad1-4 {border-color:AED2E6;border-style:none;border-bottom-width:0PX;border-left-width:0PX;border-top-style:solid;border-top-width:2PX;border-right-width:0PX;}
.ad1-5 {border-color:366337;border-style:none;border-bottom-width:0PX;border-left-style:solid;border-left-width:1PX;border-top-width:0PX;border-right-width:0PX;}
.ad1-6 {border-color:AED2E6;border-style:none;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;}
.ad1-7 {border-color:AED2E6;border-style:none;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;}
.ad1-8 {border-color:366337;border-style:none;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;}
.ad1-9 {border-color:366337;border-style:none;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;}
.ad1-10 {border-color:366337;border-style:none;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;}
.ad1-11 {border-color:808080;border-style:none;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;}
</STYLE>

<TITLE>Crystal Report Viewer</TITLE>
<BODY BGCOLOR="FFFFFF"LEFTMARGIN=0 TOPMARGIN=0 BOTTOMMARGIN=0 RIGHTMARGIN=0>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<DIV style="z-index:0"> &nbsp; </div>

<div style="left:447PX;top:116PX;border-color:AED2E6;border-style:solid;border-width:0px;border-left-width:1PX;height:302PX;">
<table width="0px" height="296PX"><td>&nbsp;</td></table>
</div>
<div style="left:41PX;top:332PX;border-color:AED2E6;border-style:solid;border-width:0px;border-top-width:1PX;width:407PX;">
</div>
<div style="left:43PX;top:417PX;border-color:AED2E6;border-style:solid;border-width:0px;border-top-width:1PX;width:711PX;">
</div>
<div style="left:447PX;top:285PX;border-color:AED2E6;border-style:solid;border-width:0px;border-top-width:2PX;width:308PX;">
</div>
<div style="left:447PX;top:243PX;border-color:AED2E6;border-style:solid;border-width:0px;border-top-width:1PX;width:308PX;">
</div>
<div style="left:447PX;top:417PX;border-color:AED2E6;border-style:solid;border-width:0px;border-top-width:2PX;width:307PX;">
</div>
<div style="left:682PX;top:609PX;border-color:366337;border-style:solid;border-width:0px;border-left-width:1PX;height:23PX;">
<table width="0px" height="17PX"><td>&nbsp;</td></table>
</div>
<div style="left:682PX;top:635PX;border-color:366337;border-style:solid;border-width:0px;border-left-width:1PX;height:24PX;">
<table width="0px" height="18PX"><td>&nbsp;</td></table>
</div>
<div style="left:682PX;top:663PX;border-color:366337;border-style:solid;border-width:0px;border-left-width:1PX;height:23PX;">
<table width="0px" height="17PX"><td>&nbsp;</td></table>
</div>
<div style="left:682PX;top:691PX;border-color:366337;border-style:solid;border-width:0px;border-left-width:1PX;height:24PX;">
<table width="0px" height="18PX"><td>&nbsp;</td></table>
</div>
<div style="left:43PX;top:727PX;border-color:AED2E6;border-style:solid;border-width:0px;border-top-width:1PX;width:712PX;">
</div>
<div style="left:43PX;top:917PX;border-color:AED2E6;border-style:solid;border-width:0px;border-top-width:1PX;width:711PX;">
</div>

<DIV class="box" style="z-index:10; border-color:AED2E6;border-style:solid;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;left:461PX;top:116PX;width:292PX;height:21PX;background-color:AED2E6;layer-background-color:AED2E6;">
<table border=0 cellpadding=0 cellspacing=0 width=285px height=14px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV class="box" style="z-index:10; border-color:AED2E6;border-style:solid;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;left:123PX;top:582PX;width:460PX;height:24PX;background-color:AED2E6;layer-background-color:AED2E6;">
<table border=0 cellpadding=0 cellspacing=0 width=454px height=17px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV class="box" style="z-index:10; border-color:366337;border-style:solid;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;left:587PX;top:609PX;width:120PX;height:24PX;">
<table border=0 cellpadding=0 cellspacing=0 width=113px height=16px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV class="box" style="z-index:10; border-color:366337;border-style:solid;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;left:587PX;top:635PX;width:120PX;height:24PX;">
<table border=0 cellpadding=0 cellspacing=0 width=113px height=16px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV class="box" style="z-index:10; border-color:366337;border-style:solid;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;left:587PX;top:663PX;width:120PX;height:23PX;">
<table border=0 cellpadding=0 cellspacing=0 width=113px height=16px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV class="box" style="z-index:10; border-color:366337;border-style:solid;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;left:587PX;top:691PX;width:120PX;height:23PX;">
<table border=0 cellpadding=0 cellspacing=0 width=113px height=16px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV class="box" style="z-index:10; border-color:366337;border-style:solid;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;left:587PX;top:582PX;width:120PX;height:24PX;">
<table border=0 cellpadding=0 cellspacing=0 width=113px height=17px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV style="left: 581px; top: 950px; width: 45PX; height: 36PX; TEXT-ALIGN: CENTER;">
<img  WIDTH=42 HEIGHT=42 SRC="<?= base_url('assets/images/icons/seal.jpg') ?>">
</DIV>

<DIV style="left:43PX;top:332PX;width:125PX;height:21PX;"><span class="fc1-0">เดือนที่จ่ายเงินได้พึงประเมิน</span></DIV>

<DIV style="left:172PX;top:336PX;width:75PX;height:20PX;"><span class="fc1-1">(ให้ทำเครื่องหมาย "</span></DIV>

<DIV style="left:247PX;top:336PX;width:18PX;height:20PX;TEXT-ALIGN:CENTER;"><img  WIDTH=20 HEIGHT=18 SRC="<?= base_url('assets/images/icons/checkbox02.jpg') ?>"></DIV>

<DIV style="left:265PX;top:336PX;width:32PX;height:20PX;"><span class="fc1-1">" ลงใน "</span></DIV>

<DIV style="left:296PX;top:336PX;width:16PX;height:20PX;TEXT-ALIGN:CENTER;">
<img  WIDTH=15 HEIGHT=15 SRC="<?= base_url('assets/images/icons/checkbox01.jpg') ?>">
</DIV>

<DIV style="left:312PX;top:336PX;width:135PX;height:20PX;"><span class="fc1-1">" หน้าชื่อเดือน) พ.ศ. ....................</span></DIV>

<DIV style="left:43PX;top:213PX;width:35PX;height:25PX;"><span class="fc1-0">ที่อยู่:</span></DIV>

<DIV style="left:43PX;top:275PX;width:71PX;height:24PX;"><span class="fc1-3"> รหัสไปรษณีย์</span></DIV>

<DIV style="left: 121px; top: 278px; width: 54px; height: 21PX; TEXT-ALIGN: CENTER;"><span class="fc1-13"><?=$r_com['pstlz'];?></span></DIV>

<DIV style="left:222PX;top:275PX;width:50PX;height:24PX;"><span class="fc1-0"> โทรศัพท์:</span></DIV>

<DIV style="left: 280px; top: 278px; width: 103px; height: 21PX; TEXT-ALIGN: LEFT;"><span class="fc1-13"><?=$r_com['telf1'];?></span></DIV>

<DIV style="left:59PX;top:356PX;width:72PX;height:19PX;"><span class="fc1-4">(1) มกราคม</span></DIV>

<DIV style="left:156PX;top:356PX;width:66PX;height:19PX;"><span class="fc1-4">(4) เมษายน</span></DIV>

<DIV style="left:59PX;top:375PX;width:72PX;height:21PX;"><span class="fc1-4">(2) กุมภาพันธ์</span></DIV>

<DIV style="left:59PX;top:393PX;width:72PX;height:24PX;"><span class="fc1-4">(3) มีนาคม</span></DIV>

<DIV style="left:156PX;top:375PX;width:66PX;height:18PX;"><span class="fc1-4">(5) พฤษภาคม</span></DIV>

<DIV style="left:156PX;top:393PX;width:66PX;height:24PX;"><span class="fc1-4">(6) มิถุนายน</span></DIV>

<DIV style="left:247PX;top:356PX;width:75PX;height:19PX;"><span class="fc1-4"> (7) กรกฎาคม</span></DIV>

<DIV style="left:247PX;top:375PX;width:75PX;height:18PX;"><span class="fc1-4"> (8) สิงหาคม</span></DIV>

<DIV style="left:247PX;top:393PX;width:75PX;height:24PX;"><span class="fc1-4"> (9) กันยายน</span></DIV>

<DIV style="left:346PX;top:356PX;width:73PX;height:19PX;"><span class="fc1-4"> (10) ตุลาคม</span></DIV>

<DIV style="left:346PX;top:375PX;width:73PX;height:18PX;"><span class="fc1-4"> (11) พฤศจิกายน</span></DIV>

<DIV style="left:346PX;top:393PX;width:73PX;height:24PX;"><span class="fc1-4"> (12) ธันวาคม</span></DIV>

<DIV style="left:506PX;top:253PX;width:66PX;height:24PX;"><span class="fc1-5">ยื่นปกติ</span></DIV>

<DIV style="left:608PX;top:253PX;width:139PX;height:24PX;"><span class="fc1-5">ยื่นเพิ่มเติมครั้งที่ .................</span></DIV>

<DIV style="left:45PX;top:358PX;width:15PX;height:16PX;"><img  WIDTH=15 HEIGHT=15 SRC="<?php if($month[1]=='05'){echo base_url('assets/images/icons/checkbox02.jpg');}else{echo base_url('assets/images/icons/checkbox01.jpg');} ?>"></DIV>

<DIV style="left:45PX;top:378PX;width:15PX;height:18PX;"><img  WIDTH=15 HEIGHT=15 SRC="<?php if($month[1]=='05'){echo base_url('assets/images/icons/checkbox02.jpg');}else{echo base_url('assets/images/icons/checkbox01.jpg');} ?>"></DIV>

<DIV style="left:45PX;top:396PX;width:15PX;height:21PX;"><img  WIDTH=15 HEIGHT=15 SRC="<?php if($month[1]=='05'){echo base_url('assets/images/icons/checkbox02.jpg');}else{echo base_url('assets/images/icons/checkbox01.jpg');} ?>"></DIV>

<DIV style="left:486PX;top:256PX;width:23PX;height:20PX;"><img  WIDTH=15 HEIGHT=15 SRC="<?= base_url('assets/images/icons/checkbox01.jpg') ?>"></DIV>

<DIV style="left:588PX;top:256PX;width:15PX;height:20PX;"><img  WIDTH=15 HEIGHT=15 SRC="<?= base_url('assets/images/icons/checkbox01.jpg') ?>"></DIV>

<DIV style="left:43PX;top:182PX;width:374PX;height:28PX;"><span class="fc1-7">บริษัท บางกอก มีเดีย แอนด์ บรอทคาสติ้ง จำกัด</span></DIV>

<DIV style="left:79PX;top:215PX;width:340PX;height:49PX;">
<table width="335PX" border=0 cellpadding=0 cellspacing=0>
<tr><td class="fc1-7"><?=$r_com['adr01'];?></td></tr>
<tr><td class="fc1-7"><?=$r_com['distx'];?></td></tr></table>
</DIV>

<DIV style="left:141PX;top:358PX;width:15PX;height:16PX;"><img  WIDTH=15 HEIGHT=15 SRC="<?php if($month[1]=='05'){echo base_url('assets/images/icons/checkbox02.jpg');}else{echo base_url('assets/images/icons/checkbox01.jpg');} ?>"></DIV>

<DIV style="left:141PX;top:378PX;width:15PX;height:15PX;"><img  WIDTH=15 HEIGHT=15 SRC="<?php if($month[1]=='05'){echo base_url('assets/images/icons/checkbox02.jpg');}else{echo base_url('assets/images/icons/checkbox01.jpg');} ?>"></DIV>

<DIV style="left:141PX;top:396PX;width:15PX;height:21PX;"><img  WIDTH=15 HEIGHT=15 SRC="<?php if($month[1]=='05'){echo base_url('assets/images/icons/checkbox02.jpg');}else{echo base_url('assets/images/icons/checkbox01.jpg');} ?>"></DIV>

<DIV style="left:232PX;top:358PX;width:15PX;height:16PX;"><img  WIDTH=15 HEIGHT=15 SRC="<?php if($month[1]=='05'){echo base_url('assets/images/icons/checkbox02.jpg');}else{echo base_url('assets/images/icons/checkbox01.jpg');} ?>"></DIV>

<DIV style="left:232PX;top:378PX;width:15PX;height:18PX;"><img  WIDTH=15 HEIGHT=15 SRC="<?php if($month[1]=='05'){echo base_url('assets/images/icons/checkbox02.jpg');}else{echo base_url('assets/images/icons/checkbox01.jpg');} ?>"></DIV>

<DIV style="left:232PX;top:396PX;width:15PX;height:21PX;"><img  WIDTH=15 HEIGHT=15 SRC="<?php if($month[1]=='05'){echo base_url('assets/images/icons/checkbox02.jpg');}else{echo base_url('assets/images/icons/checkbox01.jpg');} ?>"></DIV>

<DIV style="left:331PX;top:358PX;width:15PX;height:19PX;"><img  WIDTH=15 HEIGHT=15 SRC="<?php if($month[1]=='05'){echo base_url('assets/images/icons/checkbox02.jpg');}else{echo base_url('assets/images/icons/checkbox01.jpg');} ?>"></DIV>

<DIV style="left:331PX;top:378PX;width:15PX;height:18PX;"><img  WIDTH=15 HEIGHT=15 SRC="<?php if($month[1]=='05'){echo base_url('assets/images/icons/checkbox02.jpg');}else{echo base_url('assets/images/icons/checkbox01.jpg');} ?>"></DIV>

<DIV style="left:331PX;top:396PX;width:15PX;height:21PX;"><img  WIDTH=15 HEIGHT=15 SRC="<?php if($month[1]=='05'){echo base_url('assets/images/icons/checkbox02.jpg');}else{echo base_url('assets/images/icons/checkbox01.jpg');} ?>"></DIV>

<DIV style="left:478PX;top:118PX;width:256PX;height:21PX;TEXT-ALIGN:CENTER;"><span class="fc1-8">นำส่งภาษีตาม</span></DIV>

<DIV style="left:509PX;top:154PX;width:16PX;height:19PX;"><img  WIDTH=15 HEIGHT=15 SRC="<?= base_url('assets/images/icons/checkbox01.jpg') ?>"></DIV>

<DIV style="left:528PX;top:152PX;width:213PX;height:24PX;"><span class="fc1-9"> (1) มาตรา 3 เตรส แห่งประมวลรัษฎากร</span></DIV>

<DIV style="left:528PX;top:180PX;width:213PX;height:24PX;"><span class="fc1-9"> (2) มาตรา 65 จัตวา แห่งประมวลรัษฎากร</span></DIV>

<DIV style="left:509PX;top:182PX;width:16PX;height:19PX;"><img  WIDTH=15 HEIGHT=15 SRC="<?= base_url('assets/images/icons/checkbox01.jpg') ?>"></DIV>

<DIV style="left:509PX;top:209PX;width:16PX;height:19PX;"><img  WIDTH=15 HEIGHT=15 SRC="<?= base_url('assets/images/icons/checkbox01.jpg') ?>"></DIV>

<DIV style="left:529PX;top:208PX;width:213PX;height:24PX;"><span class="fc1-9"> (3) มาตรา 69 ทวิ แห่งประมวลรัษฎากร</span></DIV>


<DIV style="left:382PX;top:332PX;width:51PX;height:17PX;TEXT-ALIGN:CENTER;"><span class="fc1-10">2556</span></DIV>

<DIV style="z-index:15;left:41PX;top:41PX;width:708PX;height:67PX;">
<img  WIDTH=708 HEIGHT=67 SRC="<?= base_url('assets/images/icons/pnd53_01.jpg') ?>">
</DIV>
<DIV style="left:43PX;top:114PX;width:154PX;height:21PX;"><span class="fc1-11">เลขประจำตัวผู้เสียภาษีอากร(13หลัก)*</span></DIV>

<DIV style="left:85PX;top:131PX;width:112PX;height:15PX;"><span class="fc1-12"> (ของผู้มีหน้าที่หัก ภาษี ณ ที่จ่าย)</span></DIV>

<DIV style="left:241PX;top:118PX;width:200PX;height:26PX;TEXT-ALIGN:RIGHT;"><span class="fc1-13"><?= $r_com['taxid']; ?></span></DIV>

<DIV style="left:43PX;top:159PX;width:127PX;height:23PX;"><span class="fc1-0">ชื่อผู้มีหน้าที่หักภาษี ณ ที่จ่าย</span></DIV>

<DIV style="left:170PX;top:159PX;width:67PX;height:21PX;"><span class="fc1-14">( หน่วยงาน ) :</span></DIV>

<DIV style="left:322PX;top:159PX;width:54PX;height:23PX;TEXT-ALIGN:RIGHT;"><span class="fc1-15">สาขาที่</span></DIV>

<DIV style="left: 378PX; top: 161PX; width: 39px; height: 21PX; TEXT-ALIGN: RIGHT;"><span class="fc1-13">0000</span></DIV>

<DIV style="left:71PX;top:441PX;width:231PX;height:43PX;">
<table width="226PX" border=0 cellpadding=0 cellspacing=0><td class="fc1-3">มีรายละเอียดการหักเป็นรายผู้มีเงินได้&nbsp;&nbsp;&nbsp;ปรากฏตาม</td></table>

<table width="226PX" border=0 cellpadding=0 cellspacing=0><td class="fc1-3">รายการที่แนบอย่างใดอย่างหนึ่ง&nbsp;&nbsp;ดังนี้</td></table>
</DIV>

<DIV style="left:388PX;top:429PX;width:35PX;height:23PX;"><span class="fc1-0"> ใบแนบ</span></DIV>

<DIV style="left:487PX;top:431PX;width:85PX;height:23PX;"><span class="fc1-3">ที่แนบมาพร้อมนี้ :</span></DIV>

<DIV style="left:426PX;top:427PX;width:61PX;height:24PX;"><span class="fc1-16">ภ.ง.ด.53 </span></DIV>

<DIV style="left:391PX;top:464PX;width:41PX;height:23PX;"><span class="fc1-0">หรือ</span></DIV>

<DIV style="left:615PX;top:429PX;width:127PX;height:27PX;TEXT-ALIGN:RIGHT;"><span class="fc1-3">จำนวน.......................ราย</span></DIV>

<DIV style="left:362PX;top:431PX;width:15PX;height:21PX;"><img  WIDTH=20 HEIGHT=18 SRC="<?= base_url('assets/images/icons/checkbox02.jpg') ?>"></DIV>

<DIV style="left:615PX;top:453PX;width:127PX;height:27PX;TEXT-ALIGN:RIGHT;"><span class="fc1-3">จำนวน......................แผ่น</span></DIV>


<DIV style="left:658PX;top:426PX;width:66PX;height:22PX;TEXT-ALIGN:CENTER;"><span class="fc1-10"><?=number_format($tline,0,'.',',');?></span></DIV>

<?php
  $page = $tline / 6;
?>
<DIV style="left:658PX;top:450PX;width:66PX;height:20PX;TEXT-ALIGN:CENTER;"><span class="fc1-10"><?=number_format($page,0,'.',',');?></span></DIV>

<DIV style="left:390PX;top:500PX;width:137PX;height:23PX;"><span class="fc1-0">สื่อบันทึกในระบบคอมพิวเตอร์</span></DIV>

<DIV style="left:362PX;top:502PX;width:15PX;height:21PX;"><img  WIDTH=15 HEIGHT=15 SRC="<?php if($month[1]=='05'){echo base_url('assets/images/icons/checkbox02.jpg');}else{echo base_url('assets/images/icons/checkbox01.jpg');} ?>"></DIV>

<DIV style="left:527PX;top:502PX;width:85PX;height:23PX;"><span class="fc1-3">ที่แนบมาพร้อมนี้ :</span></DIV>

<DIV style="left:615PX;top:502PX;width:127PX;height:27PX;TEXT-ALIGN:RIGHT;"><span class="fc1-3">จำนวน.......................ราย</span></DIV>

<DIV style="left:615PX;top:526PX;width:127PX;height:27PX;TEXT-ALIGN:RIGHT;"><span class="fc1-3">จำนวน......................แผ่น</span></DIV>

<DIV style="left:386PX;top:550PX;width:361PX;height:19PX;"><span class="fc1-18">(ตามหนังสือแสดงความประสงค์ฯ ทะเบียนรับเลขที่.........................................................) </span></DIV>

<DIV style="left:157PX;top:580PX;width:395PX;height:27PX;TEXT-ALIGN:CENTER;"><span class="fc1-19">สรุปรายการภาษีที่นำส่ง </span></DIV>

<DIV style="left:123PX;top:615PX;width:127PX;height:23PX;"><span class="fc1-20">1. รวมยอดเงินได้ทั้งสิ้น </span></DIV>

<DIV style="left:123PX;top:642PX;width:153PX;height:23PX;"><span class="fc1-20">2. รวมยอดภาษีที่นำส่งทั้งสิ้น</span></DIV>

<DIV style="left:123PX;top:668PX;width:59PX;height:22PX;"><span class="fc1-20">3. เงินเพิ่ม</span></DIV>

<DIV style="left:123PX;top:693PX;width:276PX;height:25PX;"><span class="fc1-20">4. รวมยอดภาษีที่นำส่งทั้งสิ้น และเงินเพิ่ม (2. + 3.)</span></DIV>

<DIV style="left: 584PX; top: 613PX; width: 113px; height: 23PX; TEXT-ALIGN: RIGHT;"><span class="fc1-21"><?=number_format($purch_amt,2,'.',',');?></span></DIV>
<DIV style="left: 584PX; top: 641PX; width: 113px; height: 23PX; TEXT-ALIGN: RIGHT;"><span class="fc1-21"><?=number_format($purch_wht,2,'.',',');?></span></DIV>
<DIV style="left: 584PX; top: 696PX; width: 113px; height: 19PX; TEXT-ALIGN: RIGHT;"><span class="fc1-21"><?=number_format($purch_wht,2,'.',',');?></span></DIV>
<DIV style="left:587PX;top:582PX;width:120PX;height:23PX;TEXT-ALIGN:CENTER;"><span class="fc1-0">จำนวนเงิน</span></DIV>

<DIV style="left:182PX;top:668PX;width:29PX;height:23PX;"><span class="fc1-22">(ถ้ามี)</span></DIV>

<DIV style="left:254PX;top:618PX;width:326PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.</span></DIV>

<DIV style="left:279PX;top:644PX;width:301PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4"> .&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.</span></DIV>

<DIV style="left:216PX;top:670PX;width:364PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.</span></DIV>

<DIV style="left:400PX;top:698PX;width:180PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.</span></DIV>

<DIV style="left:213PX;top:747PX;width:465PX;height:21PX;"><span class="fc1-23">ข้าพเจ้าขอรับรองว่า รายการที่แจ้งไว้ข้างต้นนี้&nbsp;&nbsp;&nbsp;เป็นรายการที่ถูกต้องและครบถ้วนทุกประการ</span></DIV>

<DIV style="left:211PX;top:796PX;width:455PX;height:27PX;TEXT-ALIGN:CENTER;"><span class="fc1-23">ลงชื่อ ..................................................................... ผู้จ่ายเงิน</span></DIV>

<DIV style="left:211PX;top:822PX;width:455PX;height:25PX;TEXT-ALIGN:CENTER;"><span class="fc1-23">(.......................................................................)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></DIV>

<DIV style="left:211PX;top:848PX;width:455PX;height:23PX;TEXT-ALIGN:CENTER;"><span class="fc1-23">ตำแหน่ง ..............................................................................................</span></DIV>

<DIV style="left:211PX;top:870PX;width:455PX;height:27PX;TEXT-ALIGN:CENTER;"><span class="fc1-23"> ยื่นวันที่ ............ เดือน ............................................. พ.ศ. ....................</span></DIV>
<DIV style="left:52PX;top:936PX;width:43PX;height:21PX;"><span class="fc1-25">หมายเหตุ</span></DIV>

<DIV style="left:95PX;top:936PX;width:467PX;height:67PX;">
<table width="462PX" border=0 cellpadding=0 cellspacing=0><td class="fc1-26">เลขประจำตัวผู้เสียภาษีอากร (13หลัก)* หมายถึง</td></table>

<table width="462PX" border=0 cellpadding=0 cellspacing=0><td class="fc1-26">1. กรณีบุคคลธรรมดาไทย ให้ใช้เลขประจำตัวประชาชนของกรมการปกครอง</td></table>

<table width="462PX" border=0 cellpadding=0 cellspacing=0><td class="fc1-26">2. กรณีนิติบุคคล ให้ใช้เลขทะเบียนนิติบุคคลของกรมพัฒนาธุรกิจการค้า</td></table>

<table width="462PX" border=0 cellpadding=0 cellspacing=0><td class="fc1-26">3. กรณีอื่นๆนอกเหนือจาก 1. และ 2. ให้ใช้เลขประจำตัวผู้เสียภาษีอากร (13หลัก)&nbsp;&nbsp;ที่กรมสรรพากรออกให้</td></table>
</DIV>

<DIV style="z-index:15;left:52PX;top:1051PX;width:392PX;height:22PX;">
<img  WIDTH=392 HEIGHT=22 SRC="<?= base_url('assets/images/icons/pnd53_02.jpg') ?>">
</DIV><BR>
</BODY></HTML>


<?php
	}
   
}

?>