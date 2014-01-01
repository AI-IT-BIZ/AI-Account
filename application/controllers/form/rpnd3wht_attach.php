<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rpnd3wht_attach extends CI_Controller {
    public $query;
    public $strSQL;
	function __construct()
	{
		parent::__construct();

		$this->load->model('convert_amount','',TRUE);
	}
	
	function index()
	{
		//$dt_str = '2013-02-22';
		//echo $dt_result;
		$date =	$this->input->get('bldat');
		$copies =	$this->input->get('copies');
		//$no = $type = $this->uri->segment(4);
		//$copies = intval($type = $this->uri->segment(5));
		$month = explode('-',$date);
		$dt_result = util_helper_get_sql_between_month($date);
		$text_month = $this->convert_amount->text_month($month[1]);
		
		if($copies<=0) $copies = 1;
		
		$strSQL = " select v_ebbp.*";
        $strSQL = $strSQL . " from v_ebbp ";
        $strSQL = $strSQL . " Where v_ebbp.bldat ".$dt_result;
		$strSQL .= " ORDER BY payno ASC";
       
		$query = $this->db->query($strSQL);
		//$r_data = $query->first_row('array');
		
		// calculate sum
		$rows = $query->result_array();
		$b_amt = 0; $result = array();

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
.fc1-0 { COLOR:000000;FONT-SIZE:11PT;FONT-FAMILY:AngsanaUPC;FONT-WEIGHT:BOLD;}
.fc1-1 { COLOR:000000;FONT-SIZE:10PT;FONT-FAMILY:CordiaUPC;FONT-WEIGHT:NORMAL;}
.fc1-2 { COLOR:000000;FONT-SIZE:11PT;FONT-FAMILY:CordiaUPC;FONT-WEIGHT:NORMAL;}
.fc1-3 { COLOR:000000;FONT-SIZE:9PT;FONT-FAMILY:Arial;FONT-WEIGHT:NORMAL;}
.fc1-4 { COLOR:000000;FONT-SIZE:15PT;FONT-FAMILY:AngsanaUPC;FONT-WEIGHT:BOLD;}
.fc1-5 { COLOR:000000;FONT-SIZE:29PT;FONT-FAMILY:EucrosiaUPC;FONT-WEIGHT:BOLD;}
.fc1-6 { COLOR:000000;FONT-SIZE:13PT;FONT-FAMILY:AngsanaUPC;FONT-WEIGHT:BOLD;}
.fc1-7 { COLOR:000000;FONT-SIZE:9PT;FONT-FAMILY:CordiaUPC;FONT-WEIGHT:NORMAL;FONT-STYLE:ITALIC;}
.fc1-8 { COLOR:000000;FONT-SIZE:9PT;FONT-FAMILY:Arial;FONT-WEIGHT:BOLD;}
.fc1-9 { COLOR:000000;FONT-SIZE:10PT;FONT-FAMILY:AngsanaUPC;FONT-WEIGHT:NORMAL;}
.fc1-10 { COLOR:000000;FONT-SIZE:11PT;FONT-FAMILY:Wingdings;FONT-WEIGHT:NORMAL;}
.fc1-11 { COLOR:000000;FONT-SIZE:11PT;FONT-FAMILY:AngsanaUPC;FONT-WEIGHT:NORMAL;}
.fc1-12 { COLOR:000000;FONT-SIZE:12PT;FONT-FAMILY:Wingdings;FONT-WEIGHT:NORMAL;}
.fc1-13 { COLOR:000000;FONT-SIZE:7PT;FONT-FAMILY:MS Shell Dlg;FONT-WEIGHT:NORMAL;}
.fc1-14 { COLOR:000000;FONT-SIZE:8PT;FONT-FAMILY:Arial;FONT-WEIGHT:NORMAL;}
.fc1-15 { COLOR:000000;FONT-SIZE:10PT;FONT-FAMILY:CordiaUPC;FONT-WEIGHT:NORMAL;FONT-STYLE:ITALIC;}
.fc1-16 { COLOR:000000;FONT-SIZE:13PT;FONT-FAMILY:EucrosiaUPC;FONT-WEIGHT:BOLD;}
.fc1-17 { COLOR:808080;FONT-SIZE:8PT;FONT-FAMILY:AngsanaUPC;FONT-WEIGHT:NORMAL;}
.fc1-18 { COLOR:000000;FONT-SIZE:11PT;FONT-FAMILY:CordiaUPC;FONT-WEIGHT:NORMAL;FONT-STYLE:ITALIC;}
.fc1-19 { COLOR:000000;FONT-SIZE:10PT;FONT-FAMILY:AngsanaUPC;FONT-WEIGHT:NORMAL;TEXT-DECORATION:UNDERLINE;}
.fc1-20 { COLOR:000000;FONT-SIZE:9PT;FONT-FAMILY:CordiaUPC;FONT-WEIGHT:NORMAL;}
.fc1-21 { COLOR:000000;FONT-SIZE:7PT;FONT-FAMILY:Wingdings;FONT-WEIGHT:NORMAL;}
.fc1-22 { COLOR:000000;FONT-SIZE:9PT;FONT-FAMILY:CordiaUPC;FONT-WEIGHT:BOLD;}
.ad1-0 {border-color:000000;border-style:none;border-bottom-width:0PX;border-left-width:0PX;border-top-width:0PX;border-right-width:0PX;}
.ad1-1 {border-color:000000;border-style:none;border-bottom-width:0PX;border-left-width:0PX;border-top-width:0PX;border-right-width:0PX;}
.ad1-2 {border-color:000000;border-style:none;border-bottom-width:0PX;border-left-style:solid;border-left-width:1PX;border-top-width:0PX;border-right-width:0PX;}
.ad1-3 {border-color:000000;border-style:none;border-bottom-width:0PX;border-left-width:0PX;border-top-style:solid;border-top-width:1PX;border-right-width:0PX;}
.ad1-4 {border-color:000000;border-style:none;border-bottom-width:0PX;border-left-style:solid;border-left-width:1PX;border-top-width:0PX;border-right-width:0PX;}
.ad1-5 {border-color:000000;border-style:none;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;}
.ad1-6 {border-color:808080;border-style:none;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;}
</STYLE>

<TITLE>Crystal Report Viewer</TITLE>
<BODY BGCOLOR="FFFFFF"LEFTMARGIN=0 TOPMARGIN=0 BOTTOMMARGIN=0 RIGHTMARGIN=0>
<?php
$current_copy_index = 0;
for($current_copy_index=0;$current_copy_index<$copies;$current_copy_index++):

	// check total page
	$page_size = 4;
	$total_count = count($rows);
	$total_page = ceil($total_count / $page_size);
	$real_current_page = 0;
	for($current_page_index=0; $current_page_index<$total_page; $current_page_index++):
		echo '<div';
		if($real_current_page>0)
			echo ' class="break"';
		echo ' style="position:relative; height:720px;">';
		$real_current_page++;
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<DIV style="z-index:0"> &nbsp; </div>

<div style="left:884PX;top:94PX;border-color:000000;border-style:solid;border-width:0px;border-left-width:1PX;height:484PX;">
<table width="0px" height="478PX"><td>&nbsp;</td></table>
</div>
<div style="left:884PX;top:117PX;border-color:000000;border-style:solid;border-width:0px;border-top-width:1PX;width:147PX;">
</div>
<div style="left:45PX;top:163PX;border-color:000000;border-style:solid;border-width:0px;border-top-width:1PX;width:985PX;">
</div>
<div style="left:76PX;top:94PX;border-color:000000;border-style:solid;border-width:0px;border-left-width:1PX;height:456PX;">
<table width="0px" height="450PX"><td>&nbsp;</td></table>
</div>
<div style="left:497PX;top:94PX;border-color:000000;border-style:solid;border-width:0px;border-left-width:1PX;height:456PX;">
<table width="0px" height="450PX"><td>&nbsp;</td></table>
</div>
<div style="left:1008PX;top:117PX;border-color:000000;border-style:solid;border-width:0px;border-left-width:1PX;height:462PX;">
<table width="0px" height="456PX"><td>&nbsp;</td></table>
</div>
<div style="left:759PX;top:120PX;border-color:000000;border-style:solid;border-width:0px;border-left-width:1PX;height:458PX;">
<table width="0px" height="452PX"><td>&nbsp;</td></table>
</div>
<div style="left:724PX;top:120PX;border-color:000000;border-style:solid;border-width:0px;border-left-width:1PX;height:430PX;">
<table width="0px" height="424PX"><td>&nbsp;</td></table>
</div>
<div style="left:568PX;top:120PX;border-color:000000;border-style:solid;border-width:0px;border-left-width:1PX;height:430PX;">
<table width="0px" height="424PX"><td>&nbsp;</td></table>
</div>
<div style="left:497PX;top:120PX;border-color:000000;border-style:solid;border-width:0px;border-top-width:1PX;width:388PX;">
</div>
<div style="left:76PX;top:117PX;border-color:000000;border-style:solid;border-width:0px;border-top-width:1PX;width:422PX;">
</div>
<div style="left:76PX;top:141PX;border-color:000000;border-style:solid;border-width:0px;border-top-width:1PX;width:422PX;">
</div>
<div style="left:323PX;top:94PX;border-color:000000;border-style:solid;border-width:0px;border-left-width:1PX;height:24PX;">
<table width="0px" height="18PX"><td>&nbsp;</td></table>
</div>
<div style="left:45PX;top:229PX;border-color:000000;border-style:solid;border-width:0px;border-top-width:1PX;width:985PX;">
</div>
<div style="left:45PX;top:577PX;border-color:000000;border-style:solid;border-width:0px;border-top-width:1PX;width:965PX;">
</div>
<div style="left:614PX;top:577PX;border-color:000000;border-style:solid;border-width:0px;border-left-width:1PX;height:148PX;">
<table width="0px" height="142PX"><td>&nbsp;</td></table>
</div>
<div style="left:45PX;top:550PX;border-color:000000;border-style:solid;border-width:0px;border-top-width:1PX;width:985PX;">
</div>

<DIV class="box" style="z-index:10; border-color:000000;border-style:solid;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;left:45PX;top:90PX;width:0PX;height:1PX;">
<table border=0 cellpadding=0 cellspacing=0 width=-7px height=-6px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV class="box" style="z-index:10; border-color:000000;border-style:solid;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;left:45PX;top:94PX;width:984PX;height:631PX;">
<table border=0 cellpadding=0 cellspacing=0 width=977px height=624px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV class="box" style="z-index:10; border-color:808080;border-style:solid;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;left:674PX;top:640PX;width:50PX;height:51PX;">
<table border=0 cellpadding=0 cellspacing=0 width=43px height=44px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV style="left:930PX;top:48PX;width:35PX;height:21PX;"><span class="fc1-0">สาขาที่ </span></DIV>

<DIV style="left:852PX;top:74PX;width:178PX;height:19PX;TEXT-ALIGN:RIGHT;"><span class="fc1-1">แผ่นที่...............ในจำนวน...............แผ่น</span></DIV>

<DIV style="left:899PX;top:69PX;width:26PX;height:22PX;TEXT-ALIGN:CENTER;"><span class="fc1-2">1</span></DIV>

<DIV style="left:976PX;top:69PX;width:29PX;height:22PX;TEXT-ALIGN:CENTER;"><span class="fc1-2">1</span></DIV>

<DIV style="left:969PX;top:50PX;width:61PX;height:19PX;TEXT-ALIGN:RIGHT;"><span class="fc1-3">0000</span></DIV>

<DIV style="left:45PX;top:52PX;width:52PX;height:28PX;"><span class="fc1-4"> ใบแนบ</span></DIV>

<DIV style="left:97PX;top:38PX;width:101PX;height:42PX;"><span class="fc1-5">ภ.ง.ด.3</span></DIV>

<DIV style="left:230PX;top:53PX;width:196PX;height:26PX;"><span class="fc1-6">เลขประจำตัวผู้เสียภาษีอากร(13หลัก)*</span></DIV>

<DIV style="left:426PX;top:59PX;width:125PX;height:15PX;"><span class="fc1-7">( ของผู้มีหน้าที่หักภาษี ณ ที่จ่าย)</span></DIV>

<DIV style="left:556PX;top:57PX;width:200PX;height:20PX;"><span class="fc1-8">3-1312-31313-13-2</span></DIV>

<DIV style="left:884PX;top:96PX;width:146PX;height:21PX;TEXT-ALIGN:CENTER;"><span class="fc1-9">รวมเงินภาษีที่หักและนำส่งในครั้งนี้</span></DIV>

<DIV style="left:1008PX;top:130PX;width:19PX;height:32PX;">
<table width="14PX" border=0 cellpadding=0 cellspacing=0>
<tr><td class="fc1-9">เ</td></tr>
<tr><td class="fc1-9">ง</td></tr>
<tr><td class="fc1-9">ื</td></tr>
<tr><td class="fc1-9">่</td></tr>
<tr><td class="fc1-9">อ</td></tr>
<tr><td class="fc1-9">น</td></tr>
<tr><td class="fc1-9">ไ</td></tr>
<tr><td class="fc1-9">ข</td></tr></table>
</DIV>

<DIV style="left:1008PX;top:117PX;width:21PX;height:17PX;TEXT-ALIGN:CENTER;"><span class="fc1-10"></span></DIV>

<DIV style="left:904PX;top:130PX;width:84PX;height:20PX;TEXT-ALIGN:CENTER;"><span class="fc1-11">จำนวนเงิน</span></DIV>

<DIV style="left:759PX;top:125PX;width:121PX;height:19PX;TEXT-ALIGN:CENTER;"><span class="fc1-9">จำนวนเงินที่จ่ายแต่ละประเภท</span></DIV>

<DIV style="left:759PX;top:141PX;width:121PX;height:19PX;TEXT-ALIGN:CENTER;"><span class="fc1-9">เฉพาะคนหนึ่งๆ ในครั้งนี้</span></DIV>

<DIV style="left:596PX;top:96PX;width:285PX;height:19PX;TEXT-ALIGN:CENTER;"><span class="fc1-11">รายละเอียดเกี่ยวกับการจ่ายเงิน</span></DIV>

<DIV style="left:726PX;top:120PX;width:32PX;height:43PX;TEXT-ALIGN:CENTER;">
<table width="27PX" border=0 cellpadding=0 cellspacing=0><td ALIGN="CENTER" class="fc1-9">อัตรา</td></table>

<table width="27PX" border=0 cellpadding=0 cellspacing=0><td ALIGN="CENTER" class="fc1-9">ภาษี</td></table>

<table width="27PX" border=0 cellpadding=0 cellspacing=0><td ALIGN="CENTER" class="fc1-9">ร้อยละ</td></table>
</DIV>

<DIV style="left:568PX;top:143PX;width:155PX;height:17PX;TEXT-ALIGN:CENTER;"><span class="fc1-7">(ถ้ามากกว่าหนึ่งประเภทให้กรอกเรียงลงไป</span></DIV>

<DIV style="left:632PX;top:123PX;width:71PX;height:21PX;"><span class="fc1-9">ประเภทเงินได้</span></DIV>

<DIV style="left:609PX;top:125PX;width:21PX;height:17PX;TEXT-ALIGN:CENTER;"><span class="fc1-12">&nbsp;</span></DIV>

<DIV style="left:497PX;top:132PX;width:71PX;height:19PX;TEXT-ALIGN:CENTER;"><span class="fc1-9">วัน เดือน ปี ที่จ่าย</span></DIV>

<DIV style="left:326PX;top:96PX;width:172PX;height:21PX;TEXT-ALIGN:CENTER;"><span class="fc1-9">สาขาที่</span></DIV>

<DIV style="left:92PX;top:96PX;width:159PX;height:21PX;"><span class="fc1-9">เลขประจำตัวผู้เสียภาษีอากร (13 หลัก)*</span></DIV>

<DIV style="left:249PX;top:98PX;width:60PX;height:17PX;"><span class="fc1-7">(ของผู้มีเงินได้)</span></DIV>

<DIV style="left:197PX;top:118PX;width:63PX;height:21PX;TEXT-ALIGN:RIGHT;"><span class="fc1-11">ชื่อผู้มีเงินได้ </span></DIV>

<DIV style="left:260PX;top:120PX;width:193PX;height:17PX;"><span class="fc1-7"> (ให้ระบุให้ชัดเจนว่าเป็น นาย นาง นางสาว หรือยศ )</span></DIV>

<DIV style="left:135PX;top:143PX;width:83PX;height:21PX;TEXT-ALIGN:RIGHT;"><span class="fc1-11">ที่อยู่ผู้มีเงินได้ </span></DIV>

<DIV style="left:218PX;top:143PX;width:235PX;height:19PX;"><span class="fc1-7"> (ให้ระบุเลขที่ ตรอก/ซอย ถนน ตำบล/แขวง อำเภอ/เขต จังหวัด)</span></DIV>

<DIV style="left:45PX;top:103PX;width:32PX;height:55PX;TEXT-ALIGN:CENTER;">
<table width="27PX" border=0 cellpadding=0 cellspacing=0><td ALIGN="CENTER" class="fc1-9">ลำ</td></table>

<table width="27PX" border=0 cellpadding=0 cellspacing=0><td ALIGN="CENTER" class="fc1-9">ดับ</td></table>

<table width="27PX" border=0 cellpadding=0 cellspacing=0><td ALIGN="CENTER" class="fc1-9">ที่</td></table>
</DIV>

<!--Item List-->
<DIV style="left: 42px; top: 170px">
<table cellpadding="0" cellspacing="0" border="0">
<?php
$rows = $query->result_array();
$no=1;$v_amt=0;$t_amt=0;$invdt_str='';
$j=0;$no=1;$nos='';
for ($i=($current_page_index * $page_size);$i<($current_page_index * $page_size + $page_size) && $i<count($rows);$i++)://$rows as $key => $item):
    //$item = $rows[$i];
	//$invdt_str = util_helper_format_date($item['bldat']);
	//$v_amt+=$item['credi'];
	//$t_amt+=$beamt;
?>
	<tr>
		<td class="fc1-8" align="center" style="width:40px;"><?=$nos;?></td>
	  <td class="fc1-8" align="left" style="width:420px;">ชื่อ </td>
	  <td class="fc1-8" align="center" style="width:75px;"><?=$invdt_str;?></td>
      <td class="fc1-8" align="center" style="width:144px;">00</td>
      <td class="fc1-8" align="center" style="width:36px;">0000</td>
      <td class="fc1-8" align="right" style="width:124px;">0000</td>
      <td class="fc1-8" align="right" style="width:124px;">0000</td>
	</tr>
    
      <tr>
		<td class="fc1-8" align="center" style="width:40px;"><?=$no++;?></td>
	  <td class="fc1-8" align="left" style="width:420px;"><?=$invdt_str;?></td>
	  <td class="fc1-8" align="center" style="width:75px;"><?=$nos;?></td>
      <td class="fc1-8" align="center" style="width:144px;"><?=$nos;?></td>
      <td class="fc1-8" align="center" style="width:36px;"><?=$nos;?></td>
      <td class="fc1-8" align="right" style="width:124px;"><?=$nos;?></td>
      <td class="fc1-8" align="right" style="width:124px;"><?=$nos;?></td>
	</tr>
    
    <tr>
		<td class="fc1-8" align="center" style="width:40px;"><?=$no++;?></td>
	  <td class="fc1-8" align="left" style="width:420px;"><?=$invdt_str;?></td>
	  <td class="fc1-8" align="center" style="width:75px;"><?=$nos;?></td>
      <td class="fc1-8" align="center" style="width:144px;"><?=$nos;?></td>
      <td class="fc1-8" align="center" style="width:36px;"><?=$nos;?></td>
      <td class="fc1-8" align="right" style="width:124px;"><?=$nos;?></td>
      <td class="fc1-8" align="right" style="width:124px;"><?=$nos;?></td>
	</tr>
<?php   
endfor;
?>
</table>
</DIV>

<!--
<DIV style="left:497PX;top:168PX;width:71PX;height:21PX;TEXT-ALIGN:CENTER;"><span class="fc1-2">28/11/2556</span></DIV>

<DIV style="left:45PX;top:168PX;width:28PX;height:14PX;TEXT-ALIGN:CENTER;"><span class="fc1-14">1</span></DIV>

<DIV style="left:102PX;top:185PX;width:387PX;height:22PX;"><span class="fc1-2">asd</span></DIV>

<DIV style="left:107PX;top:206PX;width:381PX;height:23PX;"><span class="fc1-2">oik&nbsp;&nbsp;กาญจนบุรี 12055</span></DIV>

<DIV style="left:572PX;top:168PX;width:152PX;height:31PX;"><span class="fc1-2">7hhhhh</span></DIV>

<DIV style="left:759PX;top:168PX;width:120PX;height:16PX;TEXT-ALIGN:RIGHT;"><span class="fc1-3">50,000.00</span></DIV>

<DIV style="left:724PX;top:169PX;width:35PX;height:17PX;TEXT-ALIGN:CENTER;"><span class="fc1-14">3.00</span></DIV>

<DIV style="left:884PX;top:168PX;width:120PX;height:16PX;TEXT-ALIGN:RIGHT;"><span class="fc1-3">1,500.00</span></DIV>

<DIV style="left:1008PX;top:168PX;width:21PX;height:19PX;TEXT-ALIGN:CENTER;"><span class="fc1-3">1</span></DIV>

<DIV style="left:79PX;top:168PX;width:244PX;height:17PX;"><span class="fc1-3">1-2345-67891-23-6</span></DIV>

<DIV style="left:79PX;top:185PX;width:23PX;height:21PX;"><span class="fc1-0">ชื่อ</span></DIV>

<DIV style="left:79PX;top:206PX;width:28PX;height:21PX;"><span class="fc1-0">ที่อยู่</span></DIV>
-->

<DIV style="left:754PX;top:629PX;width:195PX;height:22PX;"><span class="fc1-2">ลงชื่อ&nbsp;&nbsp;.......................................................</span></DIV>

<DIV style="left:781PX;top:652PX;width:165PX;height:22PX;TEXT-ALIGN:CENTER;"><span class="fc1-2">(&nbsp;&nbsp;&nbsp;................................................&nbsp;&nbsp;&nbsp;) </span></DIV>

<DIV style="left:951PX;top:629PX;width:57PX;height:22PX;"><span class="fc1-2"> ผู้จ่ายเงิน</span></DIV>

<DIV style="left:754PX;top:681PX;width:232PX;height:21PX;"><span class="fc1-2"> ตำแหน่ง .................................................... </span></DIV>

<DIV style="left:754PX;top:702PX;width:232PX;height:19PX;"><span class="fc1-2"> ยื่นวันที่ ...... เดือน .................. พ.ศ. .......... </span></DIV>

<DIV style="left:761PX;top:556PX;width:118PX;height:19PX;TEXT-ALIGN:RIGHT;"><span class="fc1-14">50,000.00</span></DIV>

<DIV style="left:884PX;top:556PX;width:120PX;height:19PX;TEXT-ALIGN:RIGHT;"><span class="fc1-14">1,500.00</span></DIV>

<DIV style="left:414PX;top:553PX;width:24PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-0">รวม </span></DIV>

<DIV style="left:439PX;top:553PX;width:116PX;height:21PX;"><span class="fc1-11">ยอดเงินได้และภาษีที่นำส่ง</span></DIV>

<DIV style="left:554PX;top:555PX;width:56PX;height:17PX;"><span class="fc1-15">(นำไปรวมกับ</span></DIV>

<DIV style="left:610PX;top:553PX;width:36PX;height:20PX;"><span class="fc1-0"> ใบแนบ</span></DIV>

<DIV style="left:695PX;top:555PX;width:62PX;height:17PX;"><span class="fc1-15">แผ่นอื่น (ถ้ามี))</span></DIV>

<DIV style="left:648PX;top:553PX;width:47PX;height:21PX;"><span class="fc1-16">ภ.ง.ด.3</span></DIV>

<DIV style="left:674PX;top:648PX;width:52PX;height:36PX;TEXT-ALIGN:CENTER;">
<table width="47PX" border=0 cellpadding=0 cellspacing=0><td ALIGN="CENTER" class="fc1-17">ประทับตรา</td></table>

<table width="47PX" border=0 cellpadding=0 cellspacing=0><td ALIGN="CENTER" class="fc1-17">นิติบุคคล</td></table>

<table width="47PX" border=0 cellpadding=0 cellspacing=0><td ALIGN="CENTER" class="fc1-17">ถ้ามี</td></table>
</DIV>

<DIV style="left:52PX;top:581PX;width:277PX;height:20PX;"><span class="fc1-18">(ให้กรอกลำดับที่ต่อเนื่องกันไปทุกแผ่นตามเงินได้แต่ละประเภท)</span></DIV>

<DIV style="left:53PX;top:603PX;width:40PX;height:19PX;"><span class="fc1-19">หมายเหตุ </span></DIV>

<DIV style="left:98PX;top:603PX;width:21PX;height:17PX;TEXT-ALIGN:CENTER;"><span class="fc1-12">&nbsp;</span></DIV>

<DIV style="left:121PX;top:603PX;width:461PX;height:42PX;">
<table width="456PX" border=0 cellpadding=0 cellspacing=0><td class="fc1-20">ให้ระบุว่าจ่ายเป็นค่าอะไร เช่น ค่าเช่าอาคาร ค่าสอบบัญชี ค่าทนายความ ค่าวิชาชีพของแพทย์ </td></table>

<table width="456PX" border=0 cellpadding=0 cellspacing=0><td class="fc1-20">ค่าก่อสร้าง รางวัล ส่วนลดหรือประโยชน์ใดๆ เนื่องจากการส่งเสริมการขาย รางวัลในการประกวด</td></table>

<table width="456PX" border=0 cellpadding=0 cellspacing=0><td class="fc1-20">การแข่งขัน การชิงโชค ค่าจ้างแสดงภาพยนต์ คร้องเพลงดนตรี ค่าจ้างทำของ ค่าจ้างโฆษณา ค่าขนส่งสินค้า ฯลฯ</td></table>
</DIV>

<DIV style="left:98PX;top:647PX;width:24PX;height:20PX;TEXT-ALIGN:CENTER;"><span class="fc1-12"></span></DIV>

<DIV style="left:123PX;top:647PX;width:119PX;height:17PX;"><span class="fc1-20">เงื่อนไขการหักภาษี ให้กรอกดังนี้</span></DIV>

<DIV style="left:248PX;top:650PX;width:11PX;height:12PX;TEXT-ALIGN:CENTER;"><span class="fc1-21">n&nbsp;</span></DIV>

<DIV style="left:258PX;top:647PX;width:73PX;height:17PX;"><span class="fc1-20">หัก ณ ที่จ่าย&nbsp;&nbsp;&nbsp;กรอก</span></DIV>

<DIV style="left:334PX;top:647PX;width:9PX;height:17PX;TEXT-ALIGN:CENTER;"><span class="fc1-22">1</span></DIV>

<DIV style="left:355PX;top:650PX;width:11PX;height:12PX;TEXT-ALIGN:CENTER;"><span class="fc1-21">n&nbsp;</span></DIV>

<DIV style="left:367PX;top:647PX;width:86PX;height:17PX;"><span class="fc1-20">ออกให้ตลอดไป&nbsp;&nbsp;&nbsp;กรอก</span></DIV>

<DIV style="left:456PX;top:647PX;width:9PX;height:17PX;TEXT-ALIGN:CENTER;"><span class="fc1-22">2</span></DIV>

<DIV style="left:471PX;top:650PX;width:11PX;height:12PX;TEXT-ALIGN:CENTER;"><span class="fc1-21">n&nbsp;</span></DIV>

<DIV style="left:482PX;top:647PX;width:86PX;height:17PX;"><span class="fc1-20">ออกให้ครั้งเดียว&nbsp;&nbsp;&nbsp;กรอก</span></DIV>

<DIV style="left:568PX;top:647PX;width:9PX;height:17PX;TEXT-ALIGN:CENTER;"><span class="fc1-22">3</span></DIV>

<DIV style="left:123PX;top:662PX;width:489PX;height:62PX;">
<table width="484PX" border=0 cellpadding=0 cellspacing=0><td class="fc1-9">เลขประจำตัวผู้เสียภาษีอากร (13หลัก)* หมายถึง</td></table>

<table width="484PX" border=0 cellpadding=0 cellspacing=0><td class="fc1-9">&nbsp;&nbsp;1. กรณีบุคคลธรรมดาไทย ให้ใช้เลขประจำตัวประชาชนของกรมการปกครอง</td></table>

<table width="484PX" border=0 cellpadding=0 cellspacing=0><td class="fc1-9">&nbsp;&nbsp;2. กรณีนิติบุคคล ให้ใช้เลขทะเบียนนิติบุคคลของกรมพัฒนาธุรกิจการค้า</td></table>

<table width="484PX" border=0 cellpadding=0 cellspacing=0><td class="fc1-9">&nbsp;&nbsp;3. กรณีอื่นๆนอกเหนือจาก 1. และ 2. ให้ใช้เลขประจำตัวผู้เสียภาษีอากร (13หลัก)ของกรมสรรพากร</td></table>
</DIV>

<DIV style="z-index:15;left:53PX;top:725PX;width:467PX;height:28PX;">
<img  WIDTH=467 HEIGHT=28 SRC="7a301000000g.jpg">
</DIV><BR>

<?php
		echo '</div>';
	endfor; // end page for
endfor; // end copy for
?>
</BODY></HTML>


<?php
	}
   
}

?>