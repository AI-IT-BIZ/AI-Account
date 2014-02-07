<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rpurchasevat extends CI_Controller {
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
		
	    $strSQL = " select v_ebrk.*";
        $strSQL = $strSQL . " from v_ebrk ";
        $strSQL = $strSQL . " Where v_ebrk.bldat ".$dt_result;
		$strSQL = $strSQL . " And v_ebrk.statu = '02' ";
		$strSQL .= "ORDER BY invnr ASC";
       
		$query = $this->db->query($strSQL);
		
		$r_data = $query->first_row('array');
		
		// calculate sum
		$rows = $query->result_array();
		$b_amt = 0;

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
.fc1-1 { COLOR:0000FF;FONT-SIZE:14PT;FONT-FAMILY:'angsana_newbold';}
.fc1-2 { COLOR:0000FF;FONT-SIZE:13PT;FONT-FAMILY:'angsana_newbold';}
.fc1-3 { COLOR:000000;FONT-SIZE:12PT;FONT-WEIGHT:NORMAL;}
.fc1-4 { COLOR:0000FF;FONT-SIZE:12PT;FONT-WEIGHT:NORMAL;}
.fc1-5 { COLOR:0000FF;FONT-SIZE:11PT;FONT-WEIGHT:NORMAL;}
.fc1-6 { COLOR:000000;FONT-SIZE:13PT;FONT-WEIGHT:NORMAL;}
.fc1-7 { COLOR:000000;FONT-SIZE:15PT;FONT-WEIGHT:NORMAL;}
.fc1-8 { COLOR:000000;FONT-SIZE:13PT;FONT-WEIGHT:NORMAL;}
.fc1-9 { COLOR:000000;FONT-SIZE:13PT;FONT-WEIGHT:NORMAL;}
.fc1-10 { COLOR:000000;FONT-SIZE:13PT;FONT-WEIGHT:BOLD;}
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
<? if($query->num_rows()==0){ ?>
		   <DIV style="left: 259px; top: 94px; width: 263PX; height: 25PX; TEXT-ALIGN: CENTER;"><span class="fc1-0">No Data was selected</span></DIV>
<? }?>

<?php
$current_copy_index = 0;
for($current_copy_index=0;$current_copy_index<$copies;$current_copy_index++):

	// check total page
	$page_size = 25;
	$total_count = count($rows);
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
<div style="left: 586px; top: 229px; border-color: 0000FF; border-style: solid; border-width: 0px; border-left-width: 1PX; height: 852px;">
  <table width="0px" height="305PX"><td>&nbsp;</td></table>
</div>
<div style="left: 550px; top: 229px; border-color: 0000FF; border-style: solid; border-width: 0px; border-left-width: 1PX; height: 819px;">
  <table width="0px" height="305PX"><td>&nbsp;</td></table>
</div>
<div style="left: 499px; top: 229px; border-color: 0000FF; border-style: solid; border-width: 0px; border-left-width: 1PX; height: 820px;">
  <table width="0px" height="305PX"><td>&nbsp;</td></table>
</div>
<div style="left: 419px; top: 229px; border-color: 0000FF; border-style: solid; border-width: 0px; border-left-width: 1PX; height: 820px;">
  <table width="0px" height="305PX"><td>&nbsp;</td></table>
</div>
<div style="left:49PX;top:270PX;border-color:0000FF;border-style:solid;border-width:0px;border-top-width:1PX;width:705PX;">
</div>
<div style="left: 672px; top: 228px; border-color: 0000FF; border-style: solid; border-width: 0px; border-left-width: 1PX; height: 853px;">
  <table width="0px" height="568PX"><td>&nbsp;</td></table>
</div>
<div style="left: 87px; top: 229px; border-color: 0000FF; border-style: solid; border-width: 0px; border-left-width: 1PX; height: 820px;">
  <table width="0px" height="305PX"><td>&nbsp;</td></table>
</div>
<div style="left: 228px; top: 229px; border-color: 0000FF; border-style: solid; border-width: 0px; border-left-width: 1PX; height: 820px;">
  <table width="0px" height="305PX"><td>&nbsp;</td></table>
</div>
<div style="left: 152px; top: 229px; border-color: 0000FF; border-style: solid; border-width: 0px; border-left-width: 1PX; height: 821px;">
<table width="0px" height="304PX"><td>&nbsp;</td></table>
</div>
<div style="left: 49px; top: 1050px; border-color: 0000FF; border-style: solid; border-width: 0px; border-top-width: 1PX; width: 705PX;">
</div>
<DIV class="box" style="z-index: 10; border-color: 0000FF; border-style: solid; border-bottom-style: solid; border-bottom-width: 1PX; border-left-style: solid; border-left-width: 1PX; border-top-style: solid; border-top-width: 1PX; border-right-style: solid; border-right-width: 1PX; left: 48PX; top: 27px; width: 704px; height: 189px;">
  <table border=0 cellpadding=0 cellspacing=0 width=401px height=94px><TD>&nbsp;</TD></TABLE>
</DIV>
<DIV class="box" style="z-index: 10; border-color: 0000FF; border-style: solid; border-bottom-style: solid; border-bottom-width: 1PX; border-left-style: solid; border-left-width: 1PX; border-top-style: solid; border-top-width: 1PX; border-right-style: solid; border-right-width: 1PX; left: 49PX; top: 228px; width: 704PX; height: 850px;">
  <table border=0 cellpadding=0 cellspacing=0 width=697px height=721px><TD>&nbsp;</TD></TABLE>
</DIV>

<!--Copies-->
<?php if($current_copy_index>0): ?>
<DIV style="left: 579px; top: 27px; width: 40PX; height: 20PX;"><span class="fc1-2">สำเนา</span></DIV>
<DIV style="left: 612px; top: 27px; width: 112PX; height: 25PX;"><span class="fc1-3"><?= $current_copy_index ?></span></DIV>
<?php else: ?>
<DIV style="left: 577px; top: 28px; width: 40PX; height: 20PX;"><span class="fc1-2">ต้นฉบับ</span></DIV>
<?php endif; ?>

<!--Page No-->
<DIV style="left: 642px; top: 28px; width: 30PX; height: 20PX;"><span class="fc1-2">Page</span></DIV>
<DIV style="left: 672px; top: 29px; width: 78px; height: 25PX;"><span class="fc1-3"><?=($current_page_index+1).'/'.$total_page;?></span></DIV>

<!--Header Text-->
<DIV style="left: 262px; top: 29px; width: 263PX; height: 25PX; TEXT-ALIGN: CENTER;"><span class="fc1-0">รายงานภาษีซื้อ</span></DIV>
<DIV style="left: 267px; top: 60px; width: 74px; height: 25PX; TEXT-ALIGN: CENTER;"><span class="fc1-1">ประจำเดือน</span></DIV>

<DIV style="left: 341px; top: 60px; width: 81px; height: 25PX; TEXT-ALIGN: LEFT;"><span class="fc1-1"><?= $text_month ?></span></DIV>

<DIV style="left: 421px; top: 60px; width: 45px; height: 25PX; TEXT-ALIGN: CENTER;"><span class="fc1-1">ปี</span></DIV>
<DIV style="left: 466px; top: 60px; width: 61px; height: 25PX; TEXT-ALIGN: LEFT;"><span class="fc1-1"><?= $month[0]+543 ?></span></DIV>

<DIV style="left: 51px; top: 126px; width: 75px; height: 20PX;"><span class="fc1-3">ชื่อผู้ประกอบการ </span></DIV>
<DIV style="left: 51px; top: 151px; width: 119PX; height: 20PX;"><span class="fc1-3">เลขประจำตัวผู้เสียภาษี </span></DIV>
<DIV style="left: 159px; top: 152px; width: 147px; height: 20PX;"><span class="fc1-3"><?= $r_com['taxid']; ?></span></DIV>

<DIV style="left: 427px; top: 177px; width: 75PX; height: 20PX;"><span class="fc1-3">หน้าที่</span></DIV>

<DIV style="left: 472px; top: 176px; width: 112PX; height: 25PX;"><span class="fc1-3"></span></DIV>

<DIV style="left: 319px; top: 126px; width: 106PX; height: 20PX;"><span class="fc1-3">ชื่อสถานประกอบการ </span></DIV>

<DIV style="left: 319px; top: 149px; width: 106PX; height: 20PX;"><span class="fc1-3">ที่อยู่สถานประกอบการ </span></DIV>

<DIV style="left: 319px; top: 176px; width: 76PX; height: 20PX;"><span class="fc1-3">สาขาที่ </span></DIV>
<?php 
$bldat_str = util_helper_format_date($r_data['bldat']);
?>
<DIV style="left: 357px; top: 176px; width: 60px; height: 21PX;"><span class="fc1-5">0000</span></DIV>
<?php 
$duedt_str = util_helper_format_date($r_data['duedt']);
?>

<!--Company Logo--><!--Company Text-->
<DIV style="left: 414px; top: 128px; width: 214px; height: 20px;"><span class="fc1-5"><?= $r_com['name1']; ?></span></DIV>

<DIV style="left: 129px; top: 127px; width: 248px; height: 20px;"><span class="fc1-5"><?= $r_com['name1']; ?></span></DIV>

<DIV style="left: 420px; top: 149px; width: 327px; height: 25px;">
<table width="330PX" border=0 cellpadding=0 cellspacing=0>
  <td class="fc1-4"><?=$r_com['adr01'];?>&nbsp;<?=$r_com['distx'];?>&nbsp;&nbsp;<?=$r_com['pstlz'];?></td></table>
</DIV>

<!--Vendor Name-->
<DIV style="left: 51px; top: 176PX; width: 79px; height: 22PX;"><span class="fc1-3">สำนักงานใหญ่</span></DIV>
<DIV style="left: 124px; top: 173PX; width: 181px; height: 26PX;"><span class="fc1-5">0000</span></DIV>

<!--Item Table-->
<DIV style="left: 49PX; top: 230PX; width: 38px; height: 19PX; TEXT-ALIGN: CENTER;"><span class="fc1-2">ลำดับ</span></DIV>
<DIV style="left: 156px; top: 230PX; width: 73px; height: 19PX; TEXT-ALIGN: CENTER;"><span class="fc1-2">เลขที่</span></DIV>
<DIV style="left: 156px; top: 248PX; width: 72px; height: 20PX; TEXT-ALIGN: CENTER;"><span class="fc1-2">ใบกำกับภาษี</span></DIV>

<DIV style="left: 231px; top: 230PX; width: 190px; height: 19PX; TEXT-ALIGN: CENTER;"><span class="fc1-2">ชื่อผู้ขายสินค้า/</span></DIV>
<DIV style="left: 229px; top: 248PX; width: 190px; height: 20PX; TEXT-ALIGN: CENTER;"><span class="fc1-2">ผู้รับบริการ</span></DIV>

<DIV style="left: 420px; top: 230px; width: 79px; height: 19PX; TEXT-ALIGN: CENTER;"><span class="fc1-2">เลขที่ประจำตัว</span></DIV>
<DIV style="left: 419px; top: 248PX; width: 80px; height: 20PX; TEXT-ALIGN: CENTER;"><span class="fc1-2">ผู้เสียภาษี</span></DIV>

<DIV style="left: 498px; top: 230PX; width: 51px; height: 19PX; TEXT-ALIGN: CENTER;"><span class="fc1-2">สำนักงาน</span></DIV>
<DIV style="left: 501px; top: 248PX; width: 47px; height: 20PX; TEXT-ALIGN: CENTER;"><span class="fc1-2">ใหญ่</span></DIV>

<DIV style="left: 551px; top: 230PX; width: 35px; height: 19PX; TEXT-ALIGN: CENTER;"><span class="fc1-2">สาขาที่</span></DIV>

<DIV style="left: 89px; top: 230px; width: 64px; height: 19PX; TEXT-ALIGN: CENTER;"><span class="fc1-2">วันที่</span></DIV>
<DIV style="left: 89px; top: 248PX; width: 64px; height: 20PX; TEXT-ALIGN: CENTER;"><span class="fc1-2">ใบกำกับภาษี</span></DIV>
<DIV style="left: 587px; top: 230PX; width: 85px; height: 19PX; TEXT-ALIGN: CENTER;"><span class="fc1-2">มูลค่าสินค้า</span></DIV>
<DIV style="left: 589px; top: 248PX; width: 83px; height: 20PX; TEXT-ALIGN: CENTER;"><span class="fc1-2">หรือบริการ</span></DIV>
<DIV style="left: 674px; top: 230PX; width: 79px; height: 19PX; TEXT-ALIGN: CENTER;"><span class="fc1-2">จำนวนเงิน</span></DIV>
<DIV style="left: 672px; top: 248PX; width: 81px; height: 20PX; TEXT-ALIGN: CENTER;"><span class="fc1-2">ภาษีมูลค่าเพิ่ม</span></DIV>

<?php
/*
$rows = $query->result_array();
$i=322;$b_amt = 0;
foreach ($rows as $key => $item) {
	//echo $value['total_per_menge']."<br />";
?>
<DIV style="left:49PX;top:<?=$i?>PX;width:32PX;height:19PX;TEXT-ALIGN:CENTER;"><span class="fc1-8"><?=$item['vbelp'];?></span></DIV>

<DIV style="left:167PX;top:<?=$i?>PX;width:218PX;height:22PX;"><span class="fc1-8"><?=$item['invnr'];?></span></DIV>
<DIV style="left:385PX;top:<?=$i?>PX;width:71PX;height:19PX;TEXT-ALIGN:RIGHT;"><span class="fc1-8"><?=$item['invdt'];?></span></DIV>
<DIV style="left:520PX;top:<?=$i?>PX;width:78PX;height:19PX;TEXT-ALIGN:RIGHT;"><span class="fc1-8"><?=$item['coldt'];?></span></DIV>

<DIV style="left:660PX;top:<?=$i?>PX;width:88PX;height:19PX;TEXT-ALIGN:RIGHT;"><span class="fc1-8"><?=number_format($item['itamt'],2,'.',',');?></span></DIV>

<?php
$i=322+20;
}
*/
?>

<DIV style="left:49PX;top:272px">
<table cellpadding="0" cellspacing="0" border="0">
<?php
$rows = $query->result_array();
$no=1;$v_amt=0;$t_amt=0;
for ($i=($current_page_index * $page_size);$i<($current_page_index * $page_size + $page_size) && $i<count($rows);$i++)://$rows as $key => $item):
	$item = $rows[$i];
	$itamt = $item['beamt'] - $item['dismt'];
	$t_amt += $itamt;
	$vtamt = $item['vat01'];
	$v_amt += $vtamt;
	$invdt_str = util_helper_format_date($r_data['bldat']);
?>
	<tr>
		<td class="fc1-8" align="center" style="width:38px;"><?=$no++;?></td>
	  <td class="fc1-8" align="center" style="width:65px;"><?=$invdt_str;?></td>
	  <td class="fc1-8" align="center" style="width:77px;"><?=$item['invnr'];?></td>
	  <td class="fc1-8" align="left" style="width:190px;"><?=$item['name1'];?></td>
		<td class="fc1-8" align="center" style="width:80px;"><?=$item['taxid'];?></td>
      <td class="fc1-8" align="center" style="width:51px;">0000</td>
        <td class="fc1-8" align="center" style="width:35px;">0000</td>
	  <td class="fc1-8" align="right" style="width:84px;"><?=number_format($itamt,2,'.',',');?></td>
	  <td class="fc1-8" align="right" style="width:81px;"><?=number_format($item['vat01'],2,'.',',');?></td>
	</tr>

<?php
endfor;
?>
</table>
</DIV>

<!--Footer Text-->
<DIV style="left: 210px; top: 1055px; width: 194PX; height: 23PX;"><span class="fc1-4">รวมเงิน&nbsp;&nbsp;Total</span></DIV>
<DIV style="left: 586px; top: 1055px; width: 85px; height: 19PX; TEXT-ALIGN: RIGHT;"><span class="fc1-10">
<?= check_page($current_page_index, $total_page, number_format($t_amt,2,'.',',')) ?></span></DIV>
<DIV style="left: 674px; top: 1055px; width: 77px; height: 19PX; TEXT-ALIGN: RIGHT;"><span class="fc1-10">
<?= check_page($current_page_index, $total_page, number_format($v_amt,2,'.',',')) ?></span></DIV>

<!--Payment Table-->

<?php
  $text_amt = $this->convert_amount->generate($r_data['netwr']);
?>
<!--Amount Text--><!--Signature Text--><BR>
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