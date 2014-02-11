<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Quotation extends CI_Controller {
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
		
	    $strSQL = " select v_vbak.*,v_vbap.*";
        $strSQL = $strSQL . " from v_vbak ";
        $strSQL = $strSQL . " left join v_vbap on v_vbak.vbeln = v_vbap.vbeln ";
        $strSQL = $strSQL . " Where v_vbak.vbeln = '$no'  ";
        $strSQL .= "ORDER BY vbelp ASC";
		
		$query = $this->db->query($strSQL);
		$r_data = $query->first_row('array');
		// calculate sum
		$rows = $query->result_array();
		
		$strSQL = " select tbl_payp.*";
        $strSQL = $strSQL . " from tbl_payp ";
        $strSQL = $strSQL . " Where vbeln = '$no'  ";
        $strSQL .= "ORDER BY paypr ASC";
		
		$q_pay = $this->db->query($strSQL);
		// calculate sum
		$rowp = $q_pay->result_array();
		
		$b_amt = 0;
		//$v_amt = 0;$w_amt = 0;
		foreach ($rows as $key => $item) {
			$itamt = 0;
			$itamt = $item['menge'] * $item['unitp'];
			$itamt = $itamt - $item['disit'];
			$b_amt += $itamt;
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
.fc1-0 { COLOR:0000FF;FONT-SIZE:15PT;FONT-FAMILY:'angsana_newbold';}
.fc1-1 { COLOR:0000FF;FONT-SIZE:15PT;FONT-FAMILY:'angsana_newbold';}
.fc1-2 { COLOR:0000FF;FONT-SIZE:13PT;FONT-FAMILY:'angsana_newbold';}
.fc1-3 { COLOR:000000;FONT-SIZE:13PT;FONT-WEIGHT:NORMAL;}
.fc1-4 { COLOR:0000FF;FONT-SIZE:12PT;FONT-WEIGHT:NORMAL;}
.fc1-5 { COLOR:0000FF;FONT-SIZE:16PX;FONT-WEIGHT:NORMAL;}
.fc1-6 { COLOR:000000;FONT-SIZE:16PX;FONT-WEIGHT:NORMAL;}
.fc1-7 { COLOR:000000;FONT-SIZE:18PX;FONT-WEIGHT:NORMAL;}
.fc1-8 { COLOR:000000;FONT-SIZE:14PX;FONT-WEIGHT:NORMAL;}
.fc1-9 { COLOR:0000FF;FONT-SIZE:35PX;FONT-FAMILY:'angsana_newbold';}
.fc1-10 { COLOR:000000;FONT-SIZE:13PT;FONT-FAMILY:'angsana_newbold';}
.fc1-11 { COLOR:0000FF;FONT-SIZE:9PT;FONT-WEIGHT:NORMAL;}
.fc1-12 { COLOR:0000FF;FONT-SIZE:11PT;FONT-WEIGHT:NORMAL;}
.fc1-13 { COLOR:000000;FONT-SIZE:11PT;FONT-WEIGHT:NORMAL;}
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
<?php
$current_copy_index = 0;
for($current_copy_index=0;$current_copy_index<$copies;$current_copy_index++):

	// check total page
	$page_size = 15;
	$total_count = count($rows) + count($rowp);
	$total_page = ceil($total_count / $page_size);
	$real_current_page = 0;
	for($current_page_index=0; $current_page_index<$total_page; $current_page_index++):
		echo '<div';
		if($real_current_page>0)
			echo ' class="break"';
		echo ' style="position:relative; height:1100px;">';
		$real_current_page++;
?>

<DIV style="z-index:0"> &nbsp; </div>
<div style="left:57PX;top:1041PX;border-color:0000FF;border-style:solid;border-width:0px;border-top-width:1PX;width:170PX;">
</div>
<div style="left:238PX;top:1041PX;border-color:0000FF;border-style:solid;border-width:0px;border-top-width:1PX;width:160PX;">
</div>
<div style="left:410PX;top:1041PX;border-color:0000FF;border-style:solid;border-width:0px;border-top-width:1PX;width:152PX;">
</div>
<div style="left:584PX;top:1041PX;border-color:0000FF;border-style:solid;border-width:0px;border-top-width:1PX;width:152PX;">
</div>
<DIV class="box" style="z-index: 10; left: 48PX; top: 169PX; width: 474px; height: 101PX;">
  <table border=0 cellpadding=0 cellspacing=0 width=401px height=94px><TD>&nbsp;</TD></TABLE>
</DIV>
<DIV class="box" style="z-index: 10; left: 49PX; top: 311px; width: 704PX; height: 767px;">
  <table border=0 cellpadding=0 cellspacing=0 width=697px height=721px><TD>&nbsp;</TD></TABLE>
</DIV>

<!--Copies-->
<?php if($current_copy_index>0): ?>
<DIV style="left:621PX;top:26PX;width:40PX;height:20PX;"><span class="fc1-2">Copy</span></DIV>
<DIV style="left:655PX;top:24PX;width:112PX;height:25PX;"><span class="fc1-3"><?= $current_copy_index ?></span></DIV>
<?php else: ?>
<DIV style="left:621PX;top:26PX;width:40PX;height:20PX;"><span class="fc1-2">Original</span></DIV>
<?php endif; ?>

<!--Page No-->
<DIV style="left:675PX;top:26PX;width:30PX;height:20PX;"><span class="fc1-2">Page</span></DIV>
<DIV style="left: 705PX; top: 25px; width: 74px; height: 25PX;"><span class="fc1-3"><?=($current_page_index+1).'/'.$total_page;?></span></DIV>

<!--Header Text-->
<DIV style="left: 547px; top: 56px; width: 112PX; height: 25PX;"><span class="fc1-3"><?=$r_data['vbeln'];?></span></DIV>
<?php 
  //$bldat_str = util_helper_format_date($r_data['bldat']); 
  $date = $r_data['bldat'];
  $month = explode('-',$date);
  $text_month = $this->convert_amount->text_month_en($month[1]);
?>

<DIV style="left: 549px; top: 250px; width: 108PX; height: 21PX;"><span class="fc1-3"><?=$month[2].' '.$text_month.' '.$month[0];?></span></DIV>

<!--Company Logo-->
<DIV style="z-index: 15; left: 44px; top: 34px; width: 205px; height: 43px;">
<img  WIDTH=205 HEIGHT=44 SRC="<?= base_url('assets/images/icons/boflogo.jpg') ?>">
</DIV>

<DIV style="left: 54px; top: 65px; width: 225px; height: 32px;"><span class="fc1-9">THERE'S A</span></DIV>
<DIV style="left: 55px; top: 96px; width: 228px; height: 31px;"><span class="fc1-9">QUOTATION</span></DIV>

<!--Company Text-->
<DIV style="left: 548px; top: 84px; width: 200px; height: 70px;">
  <table width="200PX" border=0 cellpadding=0 cellspacing=0>
  <td class="fc1-13"><?=$r_com['adr01'];?></td></table>
<table width="200PX" border=0 cellpadding=0 cellspacing=0><td class="fc1-13"><?=$r_com['distx'];?>&nbsp;&nbsp;<?=$r_com['pstlz'];?></td></table>
<table width="200PX" border=0 cellpadding=0 cellspacing=0><td class="fc1-13">เลขที่ผู้เสียภาษี&nbsp;<?= $r_com['taxid']; ?></td></table>
</DIV>

<!--TEL-->
<DIV style="left: 548px; top: 169px; width: 200px; height: 21PX;">
 <table width="200PX" border=0 cellpadding=0 cellspacing=0>
  <td class="fc1-13">TEL&nbsp;<?=$r_com['telf1'];?></td></table>
  <table width="200PX" border=0 cellpadding=0 cellspacing=0>
  <td class="fc1-13">FAX&nbsp;<?=$r_com['telfx'];?></td></table>
</DIV>

<!--Vendor Name-->
<DIV style="left: 57PX; top: 174px; width: 52PX; height: 22PX;"><span class="fc1-5">Client</span></DIV>
<DIV style="left: 57PX; top: 198px; width: 52PX; height: 22PX;"><span class="fc1-5">Address</span></DIV>
<DIV style="left: 109PX; top: 173PX; width: 413px; height: 26PX;"><span class="fc1-7"><?=$r_data['name1'];?></span></DIV>

<DIV style="left: 109PX; top: 198PX; width: 412px; height: 23PX;"><span class="fc1-8"><?=$r_data['adr01'];?></span></DIV>

<DIV style="left: 109PX; top: 221PX; width: 413px; height: 22PX;"><span class="fc1-8"><?=$r_data['distx'];?>&nbsp;&nbsp;<?=$r_data['pstlz'];?>&nbsp;&nbsp;เลขประจำตัวผู้เสียภาษี&nbsp;<?=$r_data['taxid'];?></span></DIV>

<!--Reference Table-->

<DIV style="left: 48px; top: 283px; width: 82px; height: 19PX; TEXT-ALIGN: CENTER;"><span class="fc1-5">Job no.</span></DIV>
<DIV style="left: 135px; top: 281px; width: 90PX; height: 21px; TEXT-ALIGN: CENTER;"><span class="fc1-3">
  <?=$r_data['jobnr'];?>
</span></DIV>
<DIV style="left: 235px; top: 282px; width: 289px; height: 21px; TEXT-ALIGN: LEFT;"><span class="fc1-3">
  <?=$r_data['jobtx'];?>
</span></DIV>
<!--2 Reference--><!--3 Vendor code--><!--4 Credit--><!--5 Delivery date-->
<?php 
//$duedt_str = util_helper_format_date($r_data['duedt']);
?>

<!--Item Table-->
<DIV style="left:49PX;top:315PX;width:40PX;height:19PX;TEXT-ALIGN:CENTER;"><span class="fc1-2">ลำดับ</span></DIV>
<DIV style="left:49PX;top:333PX;width:40PX;height:20PX;TEXT-ALIGN:CENTER;"><span class="fc1-5">No.</span></DIV>

<DIV style="left: 87px; top: 315PX; width: 87PX; height: 19PX; TEXT-ALIGN: CENTER;"><span class="fc1-2">รหัสสินค้า</span></DIV>
<DIV style="left: 87px; top: 333PX; width: 87PX; height: 20PX; TEXT-ALIGN: CENTER;"><span class="fc1-5">Code</span></DIV>

<DIV style="left: 174px; top: 315PX; width: 298PX; height: 19PX; TEXT-ALIGN: CENTER;"><span class="fc1-2">รายการ</span></DIV>
<DIV style="left: 175px; top: 333PX; width: 298PX; height: 20PX; TEXT-ALIGN: CENTER;"><span class="fc1-5">Description</span></DIV>

<DIV style="left: 475px; top: 315PX; width: 85PX; height: 19PX; TEXT-ALIGN: CENTER;"><span class="fc1-2">จำนวน</span></DIV>
<DIV style="left: 475px; top: 333PX; width: 85PX; height: 20PX; TEXT-ALIGN: CENTER;"><span class="fc1-5">Quantity</span></DIV>

<DIV style="left: 560px; top: 315PX; width: 92PX; height: 19PX; TEXT-ALIGN: RIGHT;"><span class="fc1-2">ราคาต่อหน่วย</span></DIV>
<DIV style="left: 560px; top: 333PX; width: 92px; height: 20PX; TEXT-ALIGN: RIGHT;"><span class="fc1-5">Unit Price</span></DIV>
<DIV style="left: 660PX; top: 315PX; width: 95px; height: 19PX; TEXT-ALIGN: RIGHT;"><span class="fc1-2">จำนวนเงิน</span></DIV>
<DIV style="left: 660PX; top: 333PX; width: 95px; height: 20PX; TEXT-ALIGN: RIGHT;"><span class="fc1-5">Amount</span></DIV>

<?php
/*
$rows = $query->result_array();
$i=397;$b_amt = 0;
foreach ($rows as $key => $item) {
	//echo $value['total_per_menge']."<br />";
?>
<DIV style="left:49PX;top:<?=$i?>PX;width:32PX;height:19PX;TEXT-ALIGN:CENTER;"><span class="fc1-8"><?=$item['ebelp'];?></span></DIV>
<DIV style="left:81PX;top:<?=$i?>PX;width:77PX;height:19PX;TEXT-ALIGN:CENTER;"><span class="fc1-8"><?=$item['matnr'];?></span></DIV>
<DIV style="left:167PX;top:<?=$i?>PX;width:218PX;height:22PX;"><span class="fc1-8"><?=$item['maktx'];?></span></DIV>
<DIV style="left:385PX;top:<?=$i?>PX;width:71PX;height:19PX;TEXT-ALIGN:RIGHT;"><span class="fc1-8"><?=number_format($item['menge'],2,'.',',');?></span></DIV>
<DIV style="left:520PX;top:<?=$i?>PX;width:78PX;height:19PX;TEXT-ALIGN:RIGHT;"><span class="fc1-8"><?=number_format($item['unitp'],2,'.',',');?></span></DIV>
<DIV style="left:460PX;top:<?=$i?>PX;width:60PX;height:19PX;TEXT-ALIGN:CENTER;"><span class="fc1-8"><?=$item['meins'];?></span></DIV>
<DIV style="left:578PX;top:<?=$i?>PX;width:78PX;height:19PX;TEXT-ALIGN:RIGHT;"><span class="fc1-8"><?=number_format($item['disit'],2,'.',',');?></span></DIV>
<?php 
  $itamt = 0;
  $itamt = $item['menge'] * $item['unitp'];
  $itamt = $itamt - $item['disit'];
  $b_amt += $itamt;
?>
<DIV style="left:660PX;top:<?=$i?>PX;width:88PX;height:19PX;TEXT-ALIGN:RIGHT;"><span class="fc1-8"><?=number_format($itamt,2,'.',',');?></span></DIV>

<?php
$v_amt=0;$v=0;
if(!empty($r_data['chk01']))
{
   $v = $itamt * $r_data['taxpr'];
   $v = $v / 100; 
   $v_amt += $v;
}
$i=397+20;
}*/
?>

<DIV style="left:49PX;top:357px">
<table cellpadding="0" cellspacing="0" border="0">
<?php
$rows = $query->result_array();$aaa='';$k=0;$j=0;
$allrow = count($rows) + count($rowp);
//echo 'aaa'.$page_size.'bbb'.$allrow.'ccc'.$current_page_index;
for ($i=($current_page_index * $page_size);$i<($current_page_index * $page_size + $page_size) && $i<$allrow;$i++)://$rows as $key => $item):
	if($i<count($rows)){
	$item = $rows[$i];
	$itamt = 0;$pos='';$disc=0;
	$itamt = $item['menge'] * $item['unitp'];
	//$itamt = $itamt - $item['disit'];
?>
	<tr>
		<td class="fc1-6" align="center" style="width:40px;"><?=$item['vbelp'];?></td>
		<td class="fc1-6" align="center" style="width:89px;"><?=$item['matnr'];?></td>
		<td class="fc1-6" align="left" style="width:294px;"><?=$item['maktx'];?></td>
		<td class="fc1-6" align="center" style="width:85px;"><?=number_format($item['menge'],0,'.',',');?></td>
		
	  <td class="fc1-6" align="right" style="width:92px;"><?=number_format($item['unitp'],2,'.',',');?></td>
		
	  <td class="fc1-6" align="right" style="width:103px;"><?=number_format($itamt,2,'.',',');?></td>
	</tr>
<?php
	}else{
		 
		 $paytxt='';
	   //for($j=0;$j<count($rowp);$j++){
		   $ipay = $rowp[$j];
		   $paytxt = $ipay['paypr'].'. '.$ipay['sgtxt'];
		   if($j==0){
?>
       
       <tr>
		<td class="fc1-6" align="center" style="width:40px;"><?=$aaa;?></td>
		<td class="fc1-6" align="center" style="width:89px;"><?=$aaa;?></td>
		<td class="fc1-6" align="left" style="width:294px;">Period Payment :</td>
		<td class="fc1-6" align="center" style="width:85px;"><?=$aaa;?></td>
		
	  <td class="fc1-6" align="right" style="width:92px;"><?=$aaa;?></td>
		
	  <td class="fc1-6" align="right" style="width:103px;"><?=$aaa;?></td>
	</tr>
<?php } $j++; ?>
        <tr>
		<td class="fc1-6" align="center" style="width:40px;"><?=$aaa;?></td>
		<td class="fc1-6" align="center" style="width:89px;"><?=$aaa;?></td>
		<td class="fc1-6" align="left" style="width:294px;"><?=$paytxt;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$ipay['perct'];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=number_format($ipay['pramt'],2,'.',',');?>&nbsp;&nbsp;&nbsp;<?=$ipay['ctyp1'];?></td>
		<td class="fc1-6" align="center" style="width:85px;"><?=$aaa;?></td>
		
	  <td class="fc1-6" align="right" style="width:92px;"><?=$aaa;?></td>
		
	  <td class="fc1-6" align="right" style="width:103px;"><?=$aaa;?></td>
	</tr>

<?php
	  }
endfor;
?>
</table>
</DIV>

<!--Footer Text-->
<DIV style="left:465PX;top:724PX;width:194PX;height:23PX;"><span class="fc1-4">&nbsp;Total</span></DIV>
<DIV style="left:660PX;top:724PX;width:92PX;height:19PX;TEXT-ALIGN:RIGHT;"><span class="fc1-10">
<?= check_page($current_page_index, $total_page, number_format($r_data['beamt'],2,'.',',')) ?></span></DIV>
<DIV style="left:465PX;top:746PX;width:101PX;height:23PX;"><span class="fc1-4">Discount</span></DIV>
<?php
$distxt='';$disamt=0;
/*if(strpos($r_data['dismt'], '%') !== false)
{
	$distxt = $r_data['dismt'];
	$disamt = strstr($distxt, '%', true);
	$disamt = $disamt * $r_data['beamt'];
	$disamt = $disamt / 100;
}else{$disamt = $r_data['dismt'];}
if(empty($disamt)) $disamt = 0;*/
?>

<DIV style="left:660PX;top:744PX;width:92PX;height:19PX;TEXT-ALIGN:RIGHT;"><span class="fc1-10">
<?= check_page($current_page_index, $total_page, number_format($r_data['dismt'],2,'.',',')) ?></span></DIV>

<DIV style="left:465PX;top:769PX;width:194PX;height:23PX;"><span class="fc1-4">After Discount</span></DIV>
<?php $d_amt = $r_data['beamt'] - $r_data['dismt']; ?>

<DIV style="left:660PX;top:769PX;width:92PX;height:19PX;TEXT-ALIGN:RIGHT;"><span class="fc1-10">
<?= check_page($current_page_index, $total_page, number_format($d_amt,2,'.',',')) ?></span></DIV>

<DIV style="left:465PX;top:791PX;width:194PX;height:23PX;"><span class="fc1-4">เงินมัดจำ&nbsp;&nbsp;Advance Payment</span></DIV>

<DIV style="left:660PX;top:813PX;width:92PX;height:19PX;TEXT-ALIGN:RIGHT;"><span class="fc1-10"></span></DIV>

<DIV style="left:465PX;top:813PX;width:194PX;height:19PX;"><span class="fc1-4">หลังหักมัดจำ&nbsp;&nbsp;After Advance payment</span></DIV>

<DIV style="left:465PX;top:836PX;width:136PX;height:23PX;"><span class="fc1-4">ภาษีมูลค่าเพิ่ม&nbsp;&nbsp;VAT Amount</span></DIV>

<DIV style="left: 465PX; top: 859PX; width: 168px; height: 23PX;"><span class="fc1-4">ภาษีหัก ณ ที่จ่าย &nbsp;&nbsp;WHT Amount</span></DIV>

<?php
$tax_str = "";
if(!empty($r_data['taxpr']) && intval($r_data['taxpr'])>0)
	$tax_str = number_format($r_data['taxpr'],0,'.',',').'%';
else
	$tax_str = '';

$wht_str = "";
if(!empty($r_data['whtpr']) && $r_data['wht01']>0)
	$wht_str = $r_data['whtpr'];
else
	$wht_str = '';
?>
<DIV style="left:602PX;top:836PX;width:50PX;height:19PX;TEXT-ALIGN:RIGHT;"><span class="fc1-10">
<?= $tax_str ?></span></DIV>

<DIV style="left:602PX;top:859PX;width:50PX;height:19PX;TEXT-ALIGN:RIGHT;"><span class="fc1-10">
<?= $wht_str ?></span></DIV>

<DIV style="left:660PX;top:836PX;width:92PX;height:19PX;TEXT-ALIGN:RIGHT;"><span class="fc1-10">
<?= check_page($current_page_index, $total_page, number_format($r_data['vat01'],2,'.',',')) ?></span></DIV>

<DIV style="left:660PX;top:859PX;width:92PX;height:19PX;TEXT-ALIGN:RIGHT;"><span class="fc1-10">
<?= check_page($current_page_index, $total_page, number_format($r_data['wht01'],2,'.',',')) ?></span></DIV>

<DIV style="left:465PX;top:901PX;width:194PX;height:23PX;"><span class="fc1-2">จำนวเงินที่ต้องชำระ</span></DIV>

<DIV style="left:660PX;top:901PX;width:92PX;height:19PX;TEXT-ALIGN:RIGHT;"><span class="fc1-10">
<?= check_page($current_page_index, $total_page, number_format($r_data['netwr'],2,'.',',')) ?></span></DIV>

<!--Payment Table-->
<?php
  $text_amt = $this->convert_amount->generate($r_data['netwr']);
?>
<!--Amount Text--><!--Signature Text-->
<DIV style="left: 57px; top: 928px; width: 324px; height: 25px;">
<table width="367" border=0 cellpadding=0 cellspacing=0><td class="fc1-11">ได้รับสิ่งของ/บริการตามรายการข้างต้นในสภาพดีและถูกต้องแล้ว</td></table>
</DIV>

<DIV style="left: 56px; top: 957px; width: 369px; height: 27PX;">
<table width="365" border=0 cellpadding=0 cellspacing=0><td class="fc1-5">Goods/Service received in good condition and order</td></table>
</DIV>

<DIV style="left:232PX;top:1041PX;width:171PX;height:19PX;TEXT-ALIGN:CENTER;"><span class="fc1-4">ผู้ส่งของ ........../............/................</span></DIV>

<DIV style="left:403PX;top:1041PX;width:166PX;height:19PX;TEXT-ALIGN:CENTER;"><span class="fc1-4">ผู้มีอำนาจลงนาม</span></DIV>

<DIV style="left:232PX;top:1059PX;width:64PX;height:19PX;TEXT-ALIGN:RIGHT;"><span class="fc1-5">Delivered by</span></DIV>

<DIV style="left:403PX;top:1059PX;width:166PX;height:19PX;TEXT-ALIGN:CENTER;"><span class="fc1-5">Authorized Signature</span></DIV>

<DIV style="left:49PX;top:1059PX;width:47PX;height:19PX;TEXT-ALIGN:RIGHT;"><span class="fc1-5">Receiver</span></DIV>

<DIV style="left:57PX;top:724PX;width:101PX;height:22PX;TEXT-ALIGN:CENTER;"><span class="fc1-4">หมายเหตุ / Remark :</span></DIV>

<DIV style="left: 75px; top: 755px; width: 374px; height: 155px;"><span class="fc1-3"><?=$r_data['txz01'];?></span></DIV>

<DIV style="left:49PX;top:1041PX;width:183PX;height:19PX;TEXT-ALIGN:CENTER;"><span class="fc1-4">ผู้รับของ ............./............../................</span></DIV>

<DIV style="left:569PX;top:1041PX;width:178PX;height:19PX;TEXT-ALIGN:CENTER;"><span class="fc1-12">ผู้รับเงิน ........../.........../.............</span></DIV>

<DIV style="left:569PX;top:1059PX;width:178PX;height:19PX;TEXT-ALIGN:CENTER;"><span class="fc1-5">Collector</span></DIV>
<BR>
<?php
		echo '</div>';
	endfor; // end page for
endfor; // end copy for
?>
<table width="200PX" border=0 cellpadding=0 cellspacing=0>
    <td class="fc1-11"><?=$r_com['name1'];?></td>
</table>
</BODY></HTML>

<?php
		}
	}
   
}

?>