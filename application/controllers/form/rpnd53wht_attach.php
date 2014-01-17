<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rpnd53wht_attach extends CI_Controller {
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
        $strSQL = $strSQL . " Where v_ebbp.vtype = '01' and v_ebbp.bldat ".$dt_result;
		$strSQL .= " ORDER BY payno ASC";
       
		$query = $this->db->query($strSQL);
		//$r_data = $query->first_row('array');
		
		// calculate sum
		$rows = $query->result_array();
		$b_amt = 0; $result = array();
		$taxid = str_split($r_com['taxid']);

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
.fc1-0 { COLOR:000000;FONT-SIZE:11PT;FONT-FAMILY:'angsana_newbold';}
.fc1-1 { COLOR:000000;FONT-SIZE:10PT;FONT-WEIGHT:NORMAL;}
.fc1-2 { COLOR:000000;FONT-SIZE:11PT;FONT-WEIGHT:NORMAL;}
.fc1-3 { COLOR:000000;FONT-SIZE:9PT;FONT-FAMILY:'angsana_newbold';}
.fc1-4 { COLOR:000000;FONT-SIZE:15PT;FONT-FAMILY:'angsana_newbold';}
.fc1-5 { COLOR:000000;FONT-SIZE:29PT;FONT-FAMILY:'angsana_newbold';}
.fc1-6 { COLOR:000000;FONT-SIZE:10PT;FONT-WEIGHT:NORMAL;}
.fc1-7 { COLOR:000000;FONT-SIZE:11PT;FONT-WEIGHT:NORMAL;}
.fc1-8 { COLOR:000000;FONT-SIZE:11PT;FONT-WEIGHT:NORMAL;}
.fc1-9 { COLOR:000000;FONT-SIZE:12PT;FONT-WEIGHT:NORMAL;}
.fc1-10 { COLOR:000000;FONT-SIZE:7PT;FONT-WEIGHT:NORMAL;}
.fc1-11 { COLOR:000000;FONT-SIZE:9PT;FONT-WEIGHT:NORMAL;FONT-STYLE:ITALIC;}
.fc1-12 { COLOR:000000;FONT-SIZE:8PT;FONT-WEIGHT:NORMAL;}
.fc1-13 { COLOR:000000;FONT-SIZE:9PT;FONT-WEIGHT:NORMAL;}
.fc1-14 { COLOR:000000;FONT-SIZE:10PT;FONT-FAMILY:'angsana_newbold';}
.fc1-15 { COLOR:000000;FONT-SIZE:10PT;FONT-WEIGHT:NORMAL;FONT-STYLE:ITALIC;}
.fc1-16 { COLOR:000000;FONT-SIZE:13PT;FONT-FAMILY:'angsana_newbold';}
.fc1-17 { COLOR:808080;FONT-SIZE:7PT;FONT-WEIGHT:NORMAL;}
.fc1-18 { COLOR:000000;FONT-SIZE:10PT;FONT-WEIGHT:NORMAL;FONT-STYLE:ITALIC;}
.fc1-19 { COLOR:000000;FONT-SIZE:10PT;FONT-WEIGHT:NORMAL;TEXT-DECORATION:UNDERLINE;}
.fc1-20 { COLOR:000000;FONT-SIZE:9PT;FONT-WEIGHT:NORMAL;}
.fc1-21 { COLOR:000000;FONT-SIZE:7PT;FONT-WEIGHT:NORMAL;}
.fc1-22 { COLOR:000000;FONT-SIZE:9PT;FONT-FAMILY:'angsana_newbold';}
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

<? if($query->num_rows()==0){ ?>
		   <DIV style="left: 463px; top: 97px; width: 263PX; height: 25PX; TEXT-ALIGN: CENTER;"><span class="fc1-0">No Data was selected</span></DIV>
<? }?>

<?php
$current_copy_index = 0;
for($current_copy_index=0;$current_copy_index<$copies;$current_copy_index++):

	// check total page
	$page_size = 5;
	$total_count = count($rows);
	$total_page = ceil($total_count / $page_size);
	$real_current_page = 0;
	for($current_page_index=0; $current_page_index<$total_page; $current_page_index++):
		echo '<div';
		if($real_current_page>0)
			echo ' class="break"';
		echo ' style="position:relative; height:760px;">';
		$real_current_page++;
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<DIV style="z-index:0"> &nbsp; </div>

<div style="left:901PX;top:94PX;border-color:000000;border-style:solid;border-width:0px;border-left-width:1PX;height:494PX;">
<table width="0px" height="488PX"><td>&nbsp;</td></table>
</div>
<div style="left:45PX;top:163PX;border-color:000000;border-style:solid;border-width:0px;border-top-width:1PX;width:985PX;">
</div>
<div style="left:76PX;top:94PX;border-color:000000;border-style:solid;border-width:0px;border-left-width:1PX;height:466PX;">
<table width="0px" height="460PX"><td>&nbsp;</td></table>
</div>
<div style="left:527PX;top:94PX;border-color:000000;border-style:solid;border-width:0px;border-left-width:1PX;height:466PX;">
<table width="0px" height="460PX"><td>&nbsp;</td></table>
</div>
<div style="left:1008PX;top:96PX;border-color:000000;border-style:solid;border-width:0px;border-left-width:1PX;height:492PX;">
<table width="0px" height="486PX"><td>&nbsp;</td></table>
</div>
<div style="left:785PX;top:124PX;border-color:000000;border-style:solid;border-width:0px;border-left-width:1PX;height:464PX;">
<table width="0px" height="458PX"><td>&nbsp;</td></table>
</div>
<div style="left:748PX;top:124PX;border-color:000000;border-style:solid;border-width:0px;border-left-width:1PX;height:436PX;">
<table width="0px" height="430PX"><td>&nbsp;</td></table>
</div>
<div style="left:605PX;top:124PX;border-color:000000;border-style:solid;border-width:0px;border-left-width:1PX;height:436PX;">
<table width="0px" height="430PX"><td>&nbsp;</td></table>
</div>
<div style="left:527PX;top:124PX;border-color:000000;border-style:solid;border-width:0px;border-top-width:1PX;width:375PX;">
</div>
<div style="left:76PX;top:113PX;border-color:000000;border-style:solid;border-width:0px;border-top-width:1PX;width:377PX;">
</div>
<div style="left:452PX;top:94PX;border-color:000000;border-style:solid;border-width:0px;border-left-width:1PX;height:466PX;">
<table width="0px" height="460PX"><td>&nbsp;</td></table>
</div>
<div style="left: 45PX; top: 235px; border-color: 000000; border-style: solid; border-width: 0px; border-top-width: 1PX; width: 985PX;">
</div>

<div style="left: 45PX; top: 301px; border-color: 000000; border-style: solid; border-width: 0px; border-top-width: 1PX; width: 985PX;">
</div>

<div style="left: 45PX; top: 367px; border-color: 000000; border-style: solid; border-width: 0px; border-top-width: 1PX; width: 985PX;">
</div>

<div style="left: 45PX; top: 434px; border-color: 000000; border-style: solid; border-width: 0px; border-top-width: 1PX; width: 985PX;">
</div>

<div style="left: 45PX; top: 501px; border-color: 000000; border-style: solid; border-width: 0px; border-top-width: 1PX; width: 985PX;">
</div>

<div style="left:45PX;top:587PX;border-color:000000;border-style:solid;border-width:0px;border-top-width:1PX;width:965PX;">
</div>
<div style="left: 628PX; top: 587PX; border-color: 000000; border-style: solid; border-width: 0px; border-left-width: 1PX; height: 155px;">
<table width="0px" height="142PX"><td>&nbsp;</td></table>
</div>
<div style="left:45PX;top:559PX;border-color:000000;border-style:solid;border-width:0px;border-top-width:1PX;width:985PX;">
</div>

<DIV class="box" style="z-index:10; border-color:000000;border-style:solid;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;left:45PX;top:90PX;width:0PX;height:1PX;">
<table border=0 cellpadding=0 cellspacing=0 width=-7px height=-6px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV class="box" style="z-index: 10; border-color: 000000; border-style: solid; border-bottom-style: solid; border-bottom-width: 1PX; border-left-style: solid; border-left-width: 1PX; border-top-style: solid; border-top-width: 1PX; border-right-style: solid; border-right-width: 1PX; left: 45PX; top: 94PX; width: 984PX; height: 648px;">
<table border=0 cellpadding=0 cellspacing=0 width=977px height=633px><TD>&nbsp;</TD></TABLE>
</DIV>


<DIV style="left: 719px; top: 55PX; width: 35PX; height: 23PX;"><span class="fc1-0">สาขาที่ </span></DIV>

<DIV style="left:852PX;top:74PX;width:178PX;height:19PX;TEXT-ALIGN:RIGHT;"><span class="fc1-1">แผ่นที่...............ในจำนวน...............แผ่น</span></DIV>

<DIV style="left: 904px; top: 69PX; width: 26PX; height: 22PX; TEXT-ALIGN: CENTER;"><span class="fc1-2"><?=($current_page_index+1);?></span></DIV>

<DIV style="left:976PX;top:69PX;width:29PX;height:22PX;TEXT-ALIGN:CENTER;"><span class="fc1-2"><?=$total_page;?></span></DIV>

<DIV style="left: 771px; top: 57px; width: 61PX; height: 19PX;"><span class="fc1-2">0000</span></DIV>

<DIV style="left:45PX;top:52PX;width:52PX;height:28PX;"><span class="fc1-4"> ใบแนบ</span></DIV>

<DIV style="left:97PX;top:38PX;width:120PX;height:42PX;"><span class="fc1-5">ภ.ง.ด.53</span></DIV>

<DIV style="left:234PX;top:55PX;width:175PX;height:22PX;"><span class="fc1-0">เลขประจำตัวผู้เสียภาษีอากร(13หลัก)*</span></DIV>

<DIV style="z-index: 15; left: 424px; top: 57px; width: 235PX; height: 20PX;">
<img  WIDTH=235 HEIGHT=20 SRC="<?= base_url('assets/images/icons/pp04.jpg') ?>">
</DIV>

<DIV style="left:426PX;top:57PX;width:235PX;height:20PX;"><span class="fc1-8">&nbsp;<?=$taxid[0];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$taxid[1];?>&nbsp;&nbsp;&nbsp;&nbsp;<?=$taxid[2];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$taxid[3];?>&nbsp;&nbsp;&nbsp;&nbsp;<?=$taxid[4];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$taxid[5];?>&nbsp;&nbsp;&nbsp;&nbsp;<?=$taxid[6];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$taxid[7];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$taxid[8];?>&nbsp;&nbsp;&nbsp;&nbsp;<?=$taxid[9];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$taxid[10];?>&nbsp;&nbsp;&nbsp;<?=$taxid[11]?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$taxid[12];?></span></DIV>

<DIV style="left:1008PX;top:122PX;width:19PX;height:32PX;">
<table width="14PX" border=0 cellpadding=0 cellspacing=0>
<tr><td class="fc1-6">เ</td></tr>
<tr><td class="fc1-6">ง</td></tr>
<tr><td class="fc1-6">ื</td></tr>
<tr><td class="fc1-6">่</td></tr>
<tr><td class="fc1-6">อ</td></tr>
<tr><td class="fc1-6">น</td></tr>
<tr><td class="fc1-6">ไ</td></tr>
<tr><td class="fc1-6">ข</td></tr></table>
</DIV>

<DIV style="left:1008PX;top:101PX;width:21PX;height:17PX;TEXT-ALIGN:CENTER;"><span class="fc1-7"></span></DIV>

<DIV style="left:901PX;top:106PX;width:107PX;height:40PX;TEXT-ALIGN:CENTER;">
<table width="102PX" border=0 cellpadding=0 cellspacing=0><td ALIGN="CENTER" class="fc1-8">จำนวนเงินภาษี</td></table>

<table width="102PX" border=0 cellpadding=0 cellspacing=0><td ALIGN="CENTER" class="fc1-8">ที่หักและนำส่งในครั้งนี้</td></table>
</DIV>

<DIV style="left:785PX;top:134PX;width:116PX;height:19PX;TEXT-ALIGN:CENTER;"><span class="fc1-6">จำนวนเงินที่จ่ายในครั้งนี้</span></DIV>

<DIV style="left:521PX;top:99PX;width:375PX;height:19PX;TEXT-ALIGN:CENTER;"><span class="fc1-8">รายละเอียดเกี่ยวกับการจ่ายเงิน</span></DIV>

<DIV style="left:748PX;top:124PX;width:36PX;height:40PX;TEXT-ALIGN:CENTER;">
<table width="31PX" border=0 cellpadding=0 cellspacing=0><td ALIGN="CENTER" class="fc1-6">อัตรา</td></table>

<table width="31PX" border=0 cellpadding=0 cellspacing=0><td ALIGN="CENTER" class="fc1-6">ภาษี %</td></table>
</DIV>

<DIV style="left:650PX;top:125PX;width:71PX;height:19PX;"><span class="fc1-6">ประเภทเงินได้</span></DIV>

<DIV style="left:631PX;top:127PX;width:21PX;height:17PX;TEXT-ALIGN:CENTER;"><span class="fc1-9">&nbsp;</span></DIV>

<DIV style="left:527PX;top:134PX;width:78PX;height:19PX;TEXT-ALIGN:CENTER;"><span class="fc1-6">วัน เดือน ปี ที่จ่าย</span></DIV>

<DIV style="left:452PX;top:120PX;width:75PX;height:21PX;TEXT-ALIGN:CENTER;"><span class="fc1-6">สาขาที่</span></DIV>

<DIV style="left:95PX;top:94PX;width:157PX;height:19PX;"><span class="fc1-6">เลขประจำตัวผู้เสียภาษีอากร (13 หลัก)*</span></DIV>

<DIV style="left:254PX;top:96PX;width:60PX;height:17PX;"><span class="fc1-11">(ของผู้มีเงินได้)</span></DIV>

<DIV style="left:85PX;top:115PX;width:357PX;height:19PX;TEXT-ALIGN:CENTER;"><span class="fc1-6">ชื่อและที่อยู่ของผู้มีเงินได้ </span></DIV>

<DIV style="left:86PX;top:132PX;width:355PX;height:31PX;TEXT-ALIGN:CENTER;">
<table width="350PX" border=0 cellpadding=0 cellspacing=0><td ALIGN="CENTER" class="fc1-11">(ให้ระบุว่าเป็นบริษัทจำกัด ห้างหุ้นส่วนจำกัด หรือ ห้างหุ้นส่วนสามัญนิติบุคคล</td></table>

<table width="350PX" border=0 cellpadding=0 cellspacing=0><td ALIGN="CENTER" class="fc1-11">และให้ระบุเลขที่ ตรอก/ซอย ถนน ตำบล/แขวง อำเภอ/เขต จังหวัด)</td></table>
</DIV>

<DIV style="left:45PX;top:103PX;width:32PX;height:55PX;TEXT-ALIGN:CENTER;">
<table width="27PX" border=0 cellpadding=0 cellspacing=0><td ALIGN="CENTER" class="fc1-6">ลำ</td></table>

<table width="27PX" border=0 cellpadding=0 cellspacing=0><td ALIGN="CENTER" class="fc1-6">ดับ</td></table>

<table width="27PX" border=0 cellpadding=0 cellspacing=0><td ALIGN="CENTER" class="fc1-6">ที่</td></table>
</DIV>

<DIV style="left:605PX;top:143PX;width:144PX;height:19PX;TEXT-ALIGN:CENTER;"><span class="fc1-6">พึงประเมินที่จ่าย</span></DIV>

<!--Item List-->
<DIV style="left: 42px; top: 170px">
<table cellpadding="0" cellspacing="0" border="0" width="960">
<?php
//$rows = $query->result_array();
$no=1;$v_amt=0;$t_amt=0;$invdt_str='';
$j=0;$no=1;$nos='';
for ($i=($current_page_index * $page_size);$i<($current_page_index * $page_size + $page_size) && $i<count($rows);$i++)://$rows as $key => $item):
    $item = $rows[$i];
	$invdt_str = util_helper_format_date($item['bldat']);
	$v_amt+=$item['wht01'];
	$t_amt+=$item['beamt'];
	//$names = explode(' ',$item['name1']);
	$taxid = str_split($item['taxid']);
?>
    <tr>
		<td class="fc1-8" align="center" style="width:40px;"><?=$no++;?></td>
	  <td class="fc1-8" align="left" background="<?= base_url('assets/images/icons/pp04.jpg') ?>" style="width:370px;height:25PX;background-repeat: no-repeat;">&nbsp;&nbsp;<?=$taxid[0];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$taxid[1];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$taxid[2];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$taxid[3];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$taxid[4];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$taxid[5];?>&nbsp;&nbsp;&nbsp;&nbsp;<?=$taxid[6];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$taxid[7];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$taxid[8];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$taxid[9];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$taxid[10];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$taxid[11]?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$taxid[12];?></td>
	  <td class="fc1-8" align="center" style="width:75px;">0000</td>
      <td class="fc1-8" align="center" style="width:78px;"><?=$invdt_str?></td>
      <td class="fc1-8" align="center" style="width:144px;"><?=$item['whtnr']?></td>
      <td class="fc1-8" align="center" style="width:36px;"><?=number_format($item['whtpr'],0,'.',',');?></td>
      <td class="fc1-8" align="right" style="width:110px;"><?=number_format($item['beamt'],2,'.',',');?></td>
      <td class="fc1-8" align="right" style="width:110px;"><?=number_format($item['wht01'],2,'.',',');?></td>
	</tr>
	<tr>
		<td class="fc1-8" align="center" style="width:40px;"><?=$nos;?></td>
	  <td class="fc1-8" align="left" style="width:370px;height:10PX;">ชื่อ&nbsp;<?=$item['name1']?></td>
	  <td class="fc1-8" align="center" style="width:75px;"><?=$nos;?></td>
      <td class="fc1-8" align="center" style="width:78px;"><?=$nos;?></td>
      <td class="fc1-8" align="center" style="width:144px;"><?=$nos;?></td>
      <td class="fc1-8" align="center" style="width:36px;"><?=$nos;?></td>
      <td class="fc1-8" align="right" style="width:110px;"><?=$nos;?></td>
      <td class="fc1-8" align="right" style="width:110px;"><?=$nos;?></td>
	</tr>
    <tr>
		<td class="fc1-8" align="center" style="width:40px;"><?=$nos;?></td>
	  <td class="fc1-8" align="left" style="width:370px;height:20PX;">ที่อยู่&nbsp;<?=$r_com['adr01'];?>&nbsp;<?=$r_com['distx'];?>&nbsp;&nbsp;<?=$r_com['pstlz'];?></td>
	  <td class="fc1-8" align="center" style="width:75px;"><?=$nos;?></td>
      <td class="fc1-8" align="center" style="width:78px;"><?=$nos;?></td>
      <td class="fc1-8" align="center" style="width:144px;"><?=$nos;?></td>
      <td class="fc1-8" align="center" style="width:36px;"><?=$nos;?></td>
      <td class="fc1-8" align="right" style="width:110px;"><?=$nos;?></td>
      <td class="fc1-8" align="right" style="width:110px;"><?=$nos;?></td>
	</tr>
      
<?php   
endfor;
?>
</table>
</DIV>

<!--
<DIV style="left:527PX;top:166PX;width:78PX;height:21PX;TEXT-ALIGN:CENTER;"><span class="fc1-2">12/04/2556</span></DIV>

<DIV style="left:45PX;top:166PX;width:31PX;height:14PX;TEXT-ALIGN:CENTER;"><span class="fc1-12">1</span></DIV>

<DIV style="left:98PX;top:182PX;width:354PX;height:19PX;"><span class="fc1-2">บริษัท น้ำดื่มไทยแลนด์ จำกัด</span></DIV>

<DIV style="left:104PX;top:199PX;width:348PX;height:31PX;"><span class="fc1-1">786 ถนนรามคำแหง แขวงลำสาลี เขตบึงกุ่ม กรุงเทพฯ 10750</span></DIV>

<DIV style="left:610PX;top:166PX;width:139PX;height:31PX;"><span class="fc1-2">ค่าบริการ</span></DIV>

<DIV style="left:785PX;top:166PX;width:111PX;height:16PX;TEXT-ALIGN:RIGHT;"><span class="fc1-13">2,000.00</span></DIV>

<DIV style="left:748PX;top:166PX;width:36PX;height:17PX;TEXT-ALIGN:CENTER;"><span class="fc1-12">3.00</span></DIV>

<DIV style="left:901PX;top:166PX;width:102PX;height:16PX;TEXT-ALIGN:RIGHT;"><span class="fc1-13">60.00</span></DIV>

<DIV style="left:1008PX;top:168PX;width:21PX;height:19PX;TEXT-ALIGN:CENTER;"><span class="fc1-13">1</span></DIV>


<DIV style="left:79PX;top:166PX;width:244PX;height:16PX;"><span class="fc1-13">----</span></DIV>

<DIV style="left:79PX;top:182PX;width:19PX;height:19PX;"><span class="fc1-14">ชื่อ</span></DIV>

<DIV style="left:79PX;top:199PX;width:24PX;height:29PX;"><span class="fc1-14">ที่อยู่</span></DIV>

<DIV style="left:454PX;top:166PX;width:71PX;height:20PX;TEXT-ALIGN:CENTER;"><span class="fc1-13">00000</span></DIV>
-->
<DIV style="left:661PX;top:639PX;width:240PX;height:23PX;">
<table width="235PX" border=0 cellpadding=0 cellspacing=0>
<tr><td class="fc1-8">ลงชื่อ&nbsp;&nbsp;..........................................................................</td></tr>
<tr><td class="fc1-8">&nbsp;</td></tr></table>
</DIV>

<DIV style="left:681PX;top:661PX;width:231PX;height:22PX;TEXT-ALIGN:CENTER;"><span class="fc1-2">(.......................................................................)&nbsp;&nbsp;</span></DIV>

<DIV style="left:901PX;top:640PX;width:57PX;height:22PX;"><span class="fc1-2"> ผู้จ่ายเงิน</span></DIV>

<DIV style="left:662PX;top:684PX;width:295PX;height:21PX;"><span class="fc1-8"> ตำแหน่ง .......................................................................... </span></DIV>

<DIV style="left:662PX;top:706PX;width:295PX;height:19PX;"><span class="fc1-2"> ยื่นวันที่ .......... เดือน ............................ พ.ศ. ............. </span></DIV>

<DIV style="left: 782px; top: 564PX; width: 111PX; height: 16PX; TEXT-ALIGN: RIGHT;"><span class="fc1-0"><?= check_page($current_page_index, $total_page, number_format($t_amt,2,'.',',')) ?></span></DIV>

<DIV style="left: 898px; top: 564PX; width: 102PX; height: 16PX; TEXT-ALIGN: RIGHT;"><span class="fc1-0"><?= check_page($current_page_index, $total_page, number_format($v_amt,2,'.',',')) ?></span></DIV>

<DIV style="left:426PX;top:562PX;width:24PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-0">รวม </span></DIV>

<DIV style="left:450PX;top:562PX;width:116PX;height:21PX;"><span class="fc1-8">ยอดเงินได้และภาษีที่นำส่ง</span></DIV>

<DIV style="left:565PX;top:564PX;width:56PX;height:17PX;"><span class="fc1-15">(นำไปรวมกับ</span></DIV>

<DIV style="left:620PX;top:562PX;width:36PX;height:20PX;"><span class="fc1-0"> ใบแนบ</span></DIV>

<DIV style="left:717PX;top:564PX;width:62PX;height:17PX;"><span class="fc1-15">แผ่นอื่น (ถ้ามี))</span></DIV>

<DIV style="left:657PX;top:561PX;width:55PX;height:21PX;"><span class="fc1-16">ภ.ง.ด.53</span></DIV>

<DIV style="left:944PX;top:672PX;width:43PX;height:36PX;TEXT-ALIGN:CENTER;">
<img  WIDTH=42 HEIGHT=42 SRC="<?= base_url('assets/images/icons/seal.jpg') ?>">
</DIV>

<DIV style="left:50PX;top:588PX;width:163PX;height:21PX;"><span class="fc1-18">(ให้กรอกลำดับที่ต่อเนื่องกันไปทุกแผ่น)</span></DIV>

<DIV style="left:50PX;top:606PX;width:40PX;height:19PX;"><span class="fc1-19">หมายเหตุ </span></DIV>

<DIV style="left:100PX;top:608PX;width:21PX;height:17PX;TEXT-ALIGN:CENTER;"><span class="fc1-9">&nbsp;</span></DIV>

<DIV style="left:98PX;top:660PX;width:24PX;height:20PX;TEXT-ALIGN:CENTER;"><span class="fc1-9"></span></DIV>

<DIV style="left:123PX;top:660PX;width:119PX;height:18PX;"><span class="fc1-20">เงื่อนไขการหักภาษี ให้กรอกดังนี้</span></DIV>

<DIV style="left:312PX;top:663PX;width:11PX;height:12PX;TEXT-ALIGN:CENTER;"><span class="fc1-21">n&nbsp;</span></DIV>

<DIV style="left:322PX;top:660PX;width:73PX;height:17PX;"><span class="fc1-20">หัก ณ ที่จ่าย&nbsp;&nbsp;&nbsp;กรอก</span></DIV>

<DIV style="left:398PX;top:660PX;width:9PX;height:17PX;TEXT-ALIGN:CENTER;"><span class="fc1-22">1</span></DIV>

<DIV style="left:468PX;top:663PX;width:11PX;height:12PX;TEXT-ALIGN:CENTER;"><span class="fc1-21">n&nbsp;</span></DIV>

<DIV style="left:480PX;top:660PX;width:86PX;height:17PX;"><span class="fc1-20">ออกให้ตลอดไป&nbsp;&nbsp;&nbsp;กรอก</span></DIV>

<DIV style="left:568PX;top:660PX;width:9PX;height:17PX;TEXT-ALIGN:CENTER;"><span class="fc1-22">2</span></DIV>

<DIV style="left:123PX;top:677PX;width:489PX;height:54PX;">
<table width="484PX" border=0 cellpadding=0 cellspacing=0><td class="fc1-20">เลขประจำตัวผู้เสียภาษีอากร (13หลัก)* หมายถึง</td></table>

<table width="484PX" border=0 cellpadding=0 cellspacing=0><td class="fc1-20"> 1. กรณีบุคคลธรรมดาไทย ให้ใช้เลขประจำตัวประชาชนของกรมการปกครอง</td></table>

<table width="484PX" border=0 cellpadding=0 cellspacing=0><td class="fc1-20"> 2. กรณีนิติบุคคล ให้ใช้เลขทะเบียนนิติบุคคลของกรมพัฒนาธุรกิจการค้า</td></table>

<table width="484PX" border=0 cellpadding=0 cellspacing=0><td class="fc1-20"> 3. กรณีอื่นๆนอกเหนือจาก 1. และ 2. ให้ใช้เลขประจำตัวผู้เสียภาษีอากร (13หลัก)ของกรมสรรพากร</td></table>
</DIV>

<DIV style="z-index: 15; left: 52PX; top: 745px; width: 397PX; height: 24PX;">
<img  WIDTH=397 HEIGHT=24 SRC="<?= base_url('assets/images/icons/pnd53_02.jpg') ?>">
</DIV>
<DIV style="left:121PX;top:606PX;width:503PX;height:55PX;">
<table width="498PX" border=0 cellpadding=0 cellspacing=0>
<tr><td class="fc1-20">ให้ระบุว่าจ่ายเป็นค่าอะไร&nbsp;&nbsp;&nbsp;เช่น&nbsp;&nbsp;ค่านายหน้า&nbsp;&nbsp;ค่าแห่งกู๊ดวิลล์&nbsp;&nbsp;ดอกเบี้ยเงินฝาก&nbsp;&nbsp;ตั๋วเงิน&nbsp;&nbsp;&nbsp;เงินปันผล&nbsp;&nbsp;&nbsp;เงินส่วนแบ่งกำไร&nbsp;&nbsp;&nbsp;&nbsp;ค่าเช่าอาคาร&nbsp;&nbsp;&nbsp;</td></tr>
<tr><td class="fc1-20">ค่าสอบบัญชี&nbsp;&nbsp;&nbsp;ค่าออกแบบ&nbsp;&nbsp;ค่าก่อสร้างโรงเรียน&nbsp;&nbsp;&nbsp;ค่าซื้อเครื่องพิมพ์ดีด&nbsp;&nbsp;ค่าซื้อพืชผลทางการเกษตร&nbsp;&nbsp;(ยางพารา มันสำปะหลัง ปอ ข้าว ฯลฯ)&nbsp;&nbsp;</td></tr>
<tr><td class="fc1-20">ค่าจ้างทำของ&nbsp;&nbsp;ค่าจ้างโฆษณา&nbsp;&nbsp;รางวัล&nbsp;&nbsp;ส่วนลดหรือประโยชน์ใดๆ เนื่องจากการส่งเสริมการขาย&nbsp;&nbsp;รางวัลในการประกวด&nbsp;&nbsp;การแข่งขัน&nbsp;&nbsp;การชิงโชค&nbsp;&nbsp;</td></tr>
<tr><td class="fc1-20">ค่าขนส่งสินค้า&nbsp;&nbsp;ค่าเบี้ยประกันวินาศภัย</td></tr></table>
</DIV>
<BR>

<?php
		echo '</div>';
	endfor; // end page for
endfor; // end copy for
?>
</BODY></HTML>


<?php
	}
	}
}

?>