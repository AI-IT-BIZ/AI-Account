<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rsumvat extends CI_Controller {
    public $query;
    public $strSQL;
	function __construct()
	{
		parent::__construct();

		$this->load->model('convert_amount','',TRUE);
	}
	
	function index()
	{
		//$no = $type = $this->uri->segment(4);
		$date =	$this->input->get('bldat');
		$copies =	$this->input->get('copies');
		$month = explode('-',$date);
		$dt_result = util_helper_get_sql_between_month($date);
		$text_month = $this->convert_amount->text_month($month[1]);
		
		if($copies<=0) $copies = 1;
		//Sale
	    $strSQL1 = " select v_vbrk.*";
        $strSQL1 = $strSQL1 . " from v_vbrk ";
        $strSQL1 = $strSQL1 . " Where v_vbrk.bldat ".$dt_result;
		$strSQL1 .= "ORDER BY invnr ASC";
       
		$q_sale = $this->db->query($strSQL1);
		$r_sale = $q_sale->first_row('array');
		
		//Purchase
		$strSQL2 = " select v_ebrk.*";
        $strSQL2 = $strSQL2 . " from v_ebrk ";
        $strSQL2 = $strSQL2 . " Where v_ebrk.bldat ".$dt_result;
		$strSQL2 .= "ORDER BY invnr ASC";
       
		$q_purch = $this->db->query($strSQL2);
		$r_purch = $q_purch->first_row('array');
		
		// calculate sum
		$rows = $q_sale->result_array();
		$b_amt = 0;

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
 DIV {
	position: absolute;
	z-index: 25;
	width: 16px;
}
.fc1-0 { COLOR:000000;FONT-SIZE:9PT;FONT-FAMILY:Tahoma;FONT-WEIGHT:NORMAL;}
.fc1-1 { COLOR:000000;FONT-SIZE:11PT;FONT-FAMILY:CordiaUPC;FONT-WEIGHT:NORMAL;}
.fc1-2 { COLOR:FFFFFF;FONT-SIZE:11PT;FONT-FAMILY:CordiaUPC;FONT-WEIGHT:NORMAL;}
.fc1-3 { COLOR:FFFFFF;FONT-SIZE:14PT;FONT-FAMILY:CordiaUPC;FONT-WEIGHT:BOLD;}
.fc1-4 { COLOR:000000;FONT-SIZE:10PT;FONT-FAMILY:CordiaUPC;FONT-WEIGHT:NORMAL;}
.fc1-5 { COLOR:000000;FONT-SIZE:11PT;FONT-FAMILY:CordiaUPC;FONT-WEIGHT:BOLD;}
.ad1-0 {border-color:FF8600;border-style:none;border-bottom-style:solid;border-bottom-width:1PX;border-left-width:0PX;border-top-style:solid;border-top-width:1PX;border-right-width:0PX;}
.ad1-1 {border-color:000000;border-style:none;border-bottom-width:0PX;border-left-width:0PX;border-top-width:0PX;border-right-width:0PX;}
.ad1-2 {border-color:000000;border-style:none;border-bottom-width:0PX;border-left-width:0PX;border-top-width:0PX;border-right-width:0PX;}
.ad1-3 {border-color:000000;border-style:none;border-bottom-width:0PX;border-left-width:0PX;border-top-width:0PX;border-right-width:0PX;}
.ad1-4 {border-color:000000;border-style:none;border-bottom-width:0PX;border-left-width:0PX;border-top-style:solid;border-top-width:0PX;border-right-width:0PX;}
</STYLE>

<TITLE>Crystal Report Viewer</TITLE>
<BODY BGCOLOR="FFFFFF"LEFTMARGIN=0 TOPMARGIN=0 BOTTOMMARGIN=0 RIGHTMARGIN=0>
<?php
$current_copy_index = 0;
for($current_copy_index=0;$current_copy_index<$copies;$current_copy_index++):

	// check total page
	$page_size = 10;
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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<DIV style="z-index:0"> &nbsp; </div>


<DIV style="left: 12px; top: 156PX; width: 1065px; height: 47PX; background-color: FFC16F; layer-background-color: FFC16F;" class="ad1-0">
<table width="1026PX" border=0 cellpadding=0 cellspacing=0><td class="fc1-0">&nbsp;</td></table>
</DIV>

<DIV style="left: 13px; top: 105px; width: 95px; height: 21PX;"><span class="fc1-1">เป็นใบแนบ ภ.พ.30</span></DIV>

<!--Check Box 1-->

<DIV style="z-index: 15; left: 196px; top: 108px; width: 15PX; height: 15PX;">
<img  WIDTH=15 HEIGHT=15 SRC="<?= base_url('assets/images/icons/checkbox01.jpg') ?>">
</DIV>

<DIV style="z-index: 15; left: 316px; top: 108px; width: 15PX; height: 15PX;">
<img  WIDTH=15 HEIGHT=15 SRC="<?= base_url('assets/images/icons/checkbox01.jpg') ?>">
</DIV>

<DIV style="left: 223px; top: 106px; width: 57px; height: 21PX;"><span class="fc1-1">กรณียื่นปกติ</span></DIV>

<DIV style="left: 595px; top: 107px; width: 57px; height: 21PX;"><span class="fc1-1">สำหรับเดือน</span></DIV>
<DIV style="left: 663px; top: 106px; width: 109px; height: 25PX; TEXT-ALIGN: LEFT;"><span class="fc1-1"><?= $text_month ?></span></DIV>

<DIV style="left: 775px; top: 107px; width: 30px; height: 21PX;"><span class="fc1-1">พ.ศ.</span></DIV>

<DIV style="left: 809px; top: 105px; width: 61px; height: 25PX; TEXT-ALIGN: LEFT;"><span class="fc1-1"><?= $month[0] ?></span></DIV>
<DIV style="left: 960px; top: 108px; width: 42px; height: 21PX;"><span class="fc1-1">ในจำนวนแผ่น</span></DIV>

<DIV style="left: 881px; top: 108px; width: 42px; height: 21PX;"><span class="fc1-1">แผ่นที่</span></DIV>

<DIV style="left: 595px; top: 129px; width: 57px; height: 21PX;"><span class="fc1-1">เลขประจำตัวผู้เสียภาษีอากร</span></DIV>

<DIV style="left: 343px; top: 106px; width: 57px; height: 21PX;"><span class="fc1-1">กรณียื่นเพิ่มเติมครั้งที่</span></DIV>

<DIV style="left: 13px; top: 127px; width: 95px; height: 21PX;"><span class="fc1-1">ชื่อผู้ประกอบการ</span></DIV>

<DIV style="left: 110px; top: 127px; width: 251px; height: 21PX;"><span class="fc1-1">บริษัท บางกอก มีเดีย แอนด์ บรอทคาสติ้ง จำกัด</span></DIV>
<DIV style="left: 352px; top: 44px; width: 500px; height: 28PX; background-color: FF8600; layer-background-color: FF8600;">
  <table width="500PX" border=0 cellpadding=0 cellspacing=0><td class="fc1-3">ใบแนบ ภ.พ.30 รายละเอียดภาษีขายและภาษีซื้อของสถานประกอบการแต่ละแห่ง</td></table>
</DIV>
<div style="left: 53px; top: 157px; border-color: 0000FF; border-style: solid; border-width: 0px; border-left-width: 1PX; height: 503px;">
  <table width="0px" height="205PX">
      <td>&nbsp;</td>
  </table>
</div>
<DIV style="left: 12px; top: 168px; width: 40px; height: 22PX; TEXT-ALIGN: CENTER;"><span class="fc1-5">ลำดับที่</span></DIV>
<div style="left: 13px; top: 157px; border-color: 0000FF; border-style: solid; border-width: 0px; border-left-width: 1PX; height: 503px;">
  <table width="0px" height="205PX">
      <td>&nbsp;</td>
  </table>
</div>
<DIV style="left: 55px; top: 168px; width: 59px; height: 22PX; TEXT-ALIGN: CENTER;"><span class="fc1-5">วันที่</span></DIV>
<div style="left: 182px; top: 157px; border-color: 0000FF; border-style: solid; border-width: 0px; border-left-width: 1PX; height: 504px;">
  <table width="0px" height="205PX"><td>&nbsp;</td></table>
</div>

<DIV style="left: 114px; top: 158px; width: 70px; height: 22PX; TEXT-ALIGN: CENTER;"><span class="fc1-5">เลขที่</span></DIV>
<DIV style="left: 113px; top: 181px; width: 70px; height: 22PX; TEXT-ALIGN: CENTER;"><span class="fc1-5">ใบกำกับภาษี</span></DIV>

<div style="left: 113px; top: 156px; border-color: 0000FF; border-style: solid; border-width: 0px; border-left-width: 1PX; height: 504px;">
  <table width="0px" height="205PX"><td>&nbsp;</td></table>
</div>

<DIV style="left: 183px; top: 158px; width: 61px; height: 22PX; TEXT-ALIGN: CENTER;"><span class="fc1-5">สำนักงาน</span></DIV>
<DIV style="left: 182px; top: 181px; width: 63px; height: 22PX; TEXT-ALIGN: CENTER;"><span class="fc1-5">ใหญ่/สาขา</span></DIV>

<div style="left: 245px; top: 156px; border-color: 0000FF; border-style: solid; border-width: 0px; border-left-width: 1PX; height: 504px;">
  <table width="0px" height="205PX"><td>&nbsp;</td></table>
</div>

<DIV style="left: 244px; top: 178px; width: 133px; height: 22PX; TEXT-ALIGN: CENTER;"><span class="fc1-5">และสาขา</span></DIV>
<DIV style="left: 244px; top: 157px; width: 133px; height: 22PX; TEXT-ALIGN: CENTER;"><span class="fc1-5">ชื่อสำนักงานใหญ่</span></DIV>

<div style="left: 378px; top: 158px; border-color: 0000FF; border-style: solid; border-width: 0px; border-left-width: 1PX; height: 503px;">
  <table width="0px" height="205PX"><td>&nbsp;</td></table>
</div>

<DIV style="left: 379px; top: 167px; width: 256px; height: 22PX; TEXT-ALIGN: CENTER;"><span class="fc1-5">ที่ตั้งสถานประกอบการ</span></DIV>

<div style="left: 635px; top: 157px; border-color: 0000FF; border-style: solid; border-width: 0px; border-left-width: 1PX; height: 523px;">
  <table width="0px" height="205PX"><td>&nbsp;</td></table>
</div>

<DIV style="left: 636px; top: 167px; width: 75px; height: 22PX; TEXT-ALIGN: CENTER;"><span class="fc1-5">ยอดขาย</span></DIV>

<DIV style="left: 712px; top: 166px; width: 70px; height: 22PX; TEXT-ALIGN: CENTER;"><span class="fc1-5">ภาษีขาย</span></DIV>

<div style="left: 782px; top: 157px; border-color: 0000FF; border-style: solid; border-width: 0px; border-left-width: 1PX; height: 524px;">
  <table width="0px" height="205PX"><td>&nbsp;</td></table>
</div>

<DIV style="left: 784px; top: 166px; width: 75px; height: 22PX; TEXT-ALIGN: CENTER;"><span class="fc1-5">ยอดซื้อ</span></DIV>

<DIV style="left: 862px; top: 167px; width: 70px; height: 22PX; TEXT-ALIGN: CENTER;"><span class="fc1-5">ภาษีซื้อ</span></DIV>

<div style="left: 860px; top: 158px; border-color: 0000FF; border-style: solid; border-width: 0px; border-left-width: 1PX; height: 523px;">
  <table width="0px" height="205PX"><td>&nbsp;</td></table>
</div>

<div style="left: 711px; top: 156px; border-color: 0000FF; border-style: solid; border-width: 0px; border-left-width: 1PX; height: 524px;">
  <table width="0px" height="205PX"><td>&nbsp;</td></table>
</div>

<div style="left: 933px; top: 158px; border-color: 0000FF; border-style: solid; border-width: 0px; border-left-width: 1PX; height: 522px;">
  <table width="0px" height="205PX"><td>&nbsp;</td></table>
</div>

<DIV style="left: 934px; top: 157px; width: 142px; height: 22PX; TEXT-ALIGN: CENTER;"><span class="fc1-5">ภาษีมูลค่าเพิ่มที่ต้องชำระ(+)</span></DIV>

<DIV style="left: 962px; top: 180px; width: 80px; height: 22PX; TEXT-ALIGN: CENTER;"><span class="fc1-5">ชำระเกิน (-)</span></DIV>

<div style="left: 1060px; top: 159px; border-color: 0000FF; border-style: solid; border-width: 0px; border-left-width: 1PX; height: 520px;">
  <table width="0px" height="205PX"><td>&nbsp;</td></table>
</div>

<DIV style="left: 13px; top: 210PX; width: 1064px; height: 23PX;"><span class="fc1-5">&nbsp;</span></DIV>

<!--Item List-->
<DIV style="left: 13px; top: 210px">
<table cellpadding="0" cellspacing="0" border="0">
<?php
$rows = $q_sale->result_array();
$rowp = $q_purch->result_array();
$alls = count($rows) + count($rowp);
$j=0;$no=1;$s_amt=0;$s_vat=0;$p_amt=0;$p_vat=0;
for ($i=($current_page_index * $page_size);$i<($current_page_index * $page_size + $page_size) && $i<$alls;$i++)://$rows as $key => $item):
     if($i<=count($rows)){
	    $item = $rows[$i];
		$s_amt += $item['beamt'];
		$s_vat += $item['vat01'];
	 }else{
		$item = $rowp[$j];
		$j++;
		$p_amt += $item['beamt'];
		$p_vat += $item['vat01'];
	};
	$itamt = $item['beamt'];
	$t_amt += $itamt;
	$t_vat += $item['vat01'];
	
	$invdt_str = util_helper_format_date($r_data['invdt']);
	$adr01 = $item['adr01'].$item['distx'];
?>
	<tr>
		<td class="fc1-8" align="center" style="width:40px;"><?=$no++;?></td>
	  <td class="fc1-8" align="center" style="width:59px;"><?=$invdt_str;?></td>
	  <td class="fc1-8" align="center" style="width:70px;"><?=$item['invnr'];?></td>
      <td class="fc1-8" align="center" style="width:65px;">0000</td>
	  <td class="fc1-8" align="left" style="width:133px;"><?=$item['name1'];?></td>
		<td class="fc1-8" align="left" style="width:256px;"><?=$adr01;?></td>
        <?php if($i<=count($rows)){ ?>
        <td class="fc1-8" align="right" style="width:75px;"><?=$item['beamt'];?></td>
        <td class="fc1-8" align="right" style="width:70px;"><?=$item['vat01'];?></td>
        
        <?php }else{ ?>
        <td class="fc1-8" align="right" style="width:75px;"><?=$item['beamt'];?></td>
	  <td class="fc1-8" align="right" style="width:70px;"><?=$item['vat01'];?></td>
      <?php } ?>
      
	  <td class="fc1-8" align="right" style="width:142px;"><?=$invdt_str;?></td>
	</tr>

<?php
endfor;
?>
</table>
</DIV>
<!--
<DIV style="left:48PX;top:210PX;width:85PX;height:21PX;TEXT-ALIGN:CENTER;"><span class="fc1-4">111221</span></DIV>

<DIV style="left:133PX;top:210PX;width:65PX;height:21PX;TEXT-ALIGN:CENTER;"><span class="fc1-4">000</span></DIV>

<DIV style="left:749PX;top:210PX;width:103PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:432PX;top:210PX;width:96PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">5,200.00</span></DIV>

<DIV style="left:531PX;top:210PX;width:104PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:647PX;top:210PX;width:100PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:966PX;top:210PX;width:93PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:864PX;top:210PX;width:100PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">5,200.00</span></DIV>

<DIV style="left:198PX;top:210PX;width:238PX;height:21PX;"><span class="fc1-4">เงินฝากออมทรัพย์ -&nbsp;&nbsp;กรุงเทพ</span></DIV>

<DIV style="left:46PX;top:233PX;width:1031PX;height:23PX;background-color:FFF0D9;layer-background-color:FFF0D9;">
<table width="1026PX" border=0 cellpadding=0 cellspacing=0><td class="fc1-5">&nbsp;</td></table>
</DIV>

<DIV style="left:48PX;top:233PX;width:85PX;height:21PX;TEXT-ALIGN:CENTER;"><span class="fc1-4">112001</span></DIV>

<DIV style="left:133PX;top:233PX;width:65PX;height:21PX;TEXT-ALIGN:CENTER;"><span class="fc1-4">000</span></DIV>

<DIV style="left:749PX;top:233PX;width:103PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:432PX;top:233PX;width:96PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">2,251.01</span></DIV>

<DIV style="left:531PX;top:233PX;width:104PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:647PX;top:233PX;width:100PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:966PX;top:233PX;width:93PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:864PX;top:233PX;width:100PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">2,251.01</span></DIV>

<DIV style="left:198PX;top:233PX;width:238PX;height:21PX;"><span class="fc1-4">ลูกหนี้การค้า ทั่วไป</span></DIV>

<DIV style="left:46PX;top:257PX;width:1031PX;height:23PX;"><span class="fc1-5">&nbsp;</span></DIV>

<DIV style="left:48PX;top:257PX;width:85PX;height:21PX;TEXT-ALIGN:CENTER;"><span class="fc1-4">113000</span></DIV>

<DIV style="left:133PX;top:257PX;width:65PX;height:21PX;TEXT-ALIGN:CENTER;"><span class="fc1-4">000</span></DIV>

<DIV style="left:749PX;top:257PX;width:103PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:432PX;top:257PX;width:96PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">91,699.00</span></DIV>

<DIV style="left:531PX;top:257PX;width:104PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:647PX;top:257PX;width:100PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:966PX;top:257PX;width:93PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:864PX;top:257PX;width:100PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">91,699.00</span></DIV>

<DIV style="left:198PX;top:257PX;width:238PX;height:21PX;"><span class="fc1-4">เช็ครับยังไม่นำเข้า</span></DIV>

<DIV style="left:46PX;top:280PX;width:1031PX;height:23PX;background-color:FFF0D9;layer-background-color:FFF0D9;">
<table width="1026PX" border=0 cellpadding=0 cellspacing=0><td class="fc1-5">&nbsp;</td></table>
</DIV>

<DIV style="left:48PX;top:280PX;width:85PX;height:21PX;TEXT-ALIGN:CENTER;"><span class="fc1-4">116100</span></DIV>

<DIV style="left:133PX;top:280PX;width:65PX;height:21PX;TEXT-ALIGN:CENTER;"><span class="fc1-4">000</span></DIV>

<DIV style="left:749PX;top:280PX;width:103PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:432PX;top:280PX;width:96PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:531PX;top:280PX;width:104PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">44,800.00</span></DIV>

<DIV style="left:647PX;top:280PX;width:100PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:966PX;top:280PX;width:93PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">44,800.00</span></DIV>

<DIV style="left:864PX;top:280PX;width:100PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:198PX;top:280PX;width:238PX;height:21PX;"><span class="fc1-4">วัตถุดิบ</span></DIV>

<DIV style="left:46PX;top:303PX;width:1031PX;height:23PX;"><span class="fc1-5">&nbsp;</span></DIV>

<DIV style="left:48PX;top:303PX;width:85PX;height:21PX;TEXT-ALIGN:CENTER;"><span class="fc1-4">116201</span></DIV>

<DIV style="left:133PX;top:303PX;width:65PX;height:21PX;TEXT-ALIGN:CENTER;"><span class="fc1-4">000</span></DIV>

<DIV style="left:749PX;top:303PX;width:103PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:432PX;top:303PX;width:96PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">186,250.00</span></DIV>

<DIV style="left:531PX;top:303PX;width:104PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:647PX;top:303PX;width:100PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:966PX;top:303PX;width:93PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:864PX;top:303PX;width:100PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">186,250.00</span></DIV>

<DIV style="left:198PX;top:303PX;width:238PX;height:21PX;"><span class="fc1-4">สินค้าสำเร็จรูป&nbsp;&nbsp;1</span></DIV>

<DIV style="left:46PX;top:327PX;width:1031PX;height:23PX;background-color:FFF0D9;layer-background-color:FFF0D9;">
<table width="1026PX" border=0 cellpadding=0 cellspacing=0><td class="fc1-5">&nbsp;</td></table>
</DIV>

<DIV style="left:48PX;top:327PX;width:85PX;height:21PX;TEXT-ALIGN:CENTER;"><span class="fc1-4">117102</span></DIV>

<DIV style="left:133PX;top:327PX;width:65PX;height:21PX;TEXT-ALIGN:CENTER;"><span class="fc1-4">000</span></DIV>

<DIV style="left:749PX;top:327PX;width:103PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:432PX;top:327PX;width:96PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">150.00</span></DIV>

<DIV style="left:531PX;top:327PX;width:104PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:647PX;top:327PX;width:100PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:966PX;top:327PX;width:93PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:864PX;top:327PX;width:100PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">150.00</span></DIV>

<DIV style="left:198PX;top:327PX;width:238PX;height:21PX;"><span class="fc1-4">ภาษีนิติบุคคลถูกหัก ณ ที่จ่าย</span></DIV>

<DIV style="left:46PX;top:350PX;width:1031PX;height:23PX;"><span class="fc1-5">&nbsp;</span></DIV>

<DIV style="left:48PX;top:350PX;width:85PX;height:21PX;TEXT-ALIGN:CENTER;"><span class="fc1-4">117401</span></DIV>

<DIV style="left:133PX;top:350PX;width:65PX;height:21PX;TEXT-ALIGN:CENTER;"><span class="fc1-4">000</span></DIV>

<DIV style="left:749PX;top:350PX;width:103PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:432PX;top:350PX;width:96PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">90,611.50</span></DIV>

<DIV style="left:531PX;top:350PX;width:104PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:647PX;top:350PX;width:100PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:966PX;top:350PX;width:93PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:864PX;top:350PX;width:100PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">90,611.50</span></DIV>

<DIV style="left:198PX;top:350PX;width:238PX;height:21PX;"><span class="fc1-4">ภาษีซื้อ</span></DIV>

<DIV style="left:46PX;top:373PX;width:1031PX;height:23PX;background-color:FFF0D9;layer-background-color:FFF0D9;">
<table width="1026PX" border=0 cellpadding=0 cellspacing=0><td class="fc1-5">&nbsp;</td></table>
</DIV>

<DIV style="left:48PX;top:373PX;width:85PX;height:21PX;TEXT-ALIGN:CENTER;"><span class="fc1-4">121301</span></DIV>

<DIV style="left:133PX;top:373PX;width:65PX;height:21PX;TEXT-ALIGN:CENTER;"><span class="fc1-4">000</span></DIV>

<DIV style="left:749PX;top:373PX;width:103PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:432PX;top:373PX;width:96PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:531PX;top:373PX;width:104PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">477.76</span></DIV>

<DIV style="left:647PX;top:373PX;width:100PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:966PX;top:373PX;width:93PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">477.76</span></DIV>

<DIV style="left:864PX;top:373PX;width:100PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:198PX;top:373PX;width:238PX;height:21PX;"><span class="fc1-4">ค่าเสื่อมราคาสะสม-เครื่องตกแต่งและเครื่องใช้สำนักงาน</span></DIV>

<DIV style="left:46PX;top:396PX;width:1031PX;height:23PX;"><span class="fc1-5">&nbsp;</span></DIV>

<DIV style="left:48PX;top:396PX;width:85PX;height:21PX;TEXT-ALIGN:CENTER;"><span class="fc1-4">211001</span></DIV>

<DIV style="left:133PX;top:396PX;width:65PX;height:21PX;TEXT-ALIGN:CENTER;"><span class="fc1-4">000</span></DIV>

<DIV style="left:749PX;top:396PX;width:103PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:432PX;top:396PX;width:96PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:531PX;top:396PX;width:104PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">25,519.50</span></DIV>

<DIV style="left:647PX;top:396PX;width:100PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:966PX;top:396PX;width:93PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">25,519.50</span></DIV>

<DIV style="left:864PX;top:396PX;width:100PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:198PX;top:396PX;width:238PX;height:21PX;"><span class="fc1-4">เจ้าหนี้การค้าทั่วไป</span></DIV>

<DIV style="left:46PX;top:420PX;width:1031PX;height:23PX;background-color:FFF0D9;layer-background-color:FFF0D9;">
<table width="1026PX" border=0 cellpadding=0 cellspacing=0><td class="fc1-5">&nbsp;</td></table>
</DIV>

<DIV style="left:48PX;top:420PX;width:85PX;height:21PX;TEXT-ALIGN:CENTER;"><span class="fc1-4">213000</span></DIV>

<DIV style="left:133PX;top:420PX;width:65PX;height:21PX;TEXT-ALIGN:CENTER;"><span class="fc1-4">000</span></DIV>

<DIV style="left:749PX;top:420PX;width:103PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:432PX;top:420PX;width:96PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:531PX;top:420PX;width:104PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">212,230.00</span></DIV>

<DIV style="left:647PX;top:420PX;width:100PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:966PX;top:420PX;width:93PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">212,230.00</span></DIV>

<DIV style="left:864PX;top:420PX;width:100PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:198PX;top:420PX;width:238PX;height:21PX;"><span class="fc1-4">เช็คค้างจ่าย</span></DIV>

<DIV style="left:46PX;top:443PX;width:1031PX;height:23PX;"><span class="fc1-5">&nbsp;</span></DIV>

<DIV style="left:48PX;top:443PX;width:85PX;height:21PX;TEXT-ALIGN:CENTER;"><span class="fc1-4">215011</span></DIV>

<DIV style="left:133PX;top:443PX;width:65PX;height:21PX;TEXT-ALIGN:CENTER;"><span class="fc1-4">000</span></DIV>

<DIV style="left:749PX;top:443PX;width:103PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:432PX;top:443PX;width:96PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:531PX;top:443PX;width:104PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">6,842.76</span></DIV>

<DIV style="left:647PX;top:443PX;width:100PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:966PX;top:443PX;width:93PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">6,842.76</span></DIV>

<DIV style="left:864PX;top:443PX;width:100PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:198PX;top:443PX;width:238PX;height:21PX;"><span class="fc1-4">ภาษีขาย</span></DIV>

<DIV style="left:46PX;top:466PX;width:1031PX;height:23PX;background-color:FFF0D9;layer-background-color:FFF0D9;">
<table width="1026PX" border=0 cellpadding=0 cellspacing=0><td class="fc1-5">&nbsp;</td></table>
</DIV>

<DIV style="left:48PX;top:466PX;width:85PX;height:21PX;TEXT-ALIGN:CENTER;"><span class="fc1-4">215040</span></DIV>

<DIV style="left:133PX;top:466PX;width:65PX;height:21PX;TEXT-ALIGN:CENTER;"><span class="fc1-4">000</span></DIV>

<DIV style="left:749PX;top:466PX;width:103PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:432PX;top:466PX;width:96PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:531PX;top:466PX;width:104PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">31,560.00</span></DIV>

<DIV style="left:647PX;top:466PX;width:100PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:966PX;top:466PX;width:93PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">31,560.00</span></DIV>

<DIV style="left:864PX;top:466PX;width:100PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:198PX;top:466PX;width:238PX;height:21PX;"><span class="fc1-4">ภาษีเงินได้หัก ณ ที่จ่าย</span></DIV>

<DIV style="left:46PX;top:489PX;width:1031PX;height:23PX;"><span class="fc1-5">&nbsp;</span></DIV>

<DIV style="left:48PX;top:489PX;width:85PX;height:21PX;TEXT-ALIGN:CENTER;"><span class="fc1-4">310000</span></DIV>

<DIV style="left:133PX;top:489PX;width:65PX;height:21PX;TEXT-ALIGN:CENTER;"><span class="fc1-4">000</span></DIV>

<DIV style="left:749PX;top:489PX;width:103PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:432PX;top:489PX;width:96PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:531PX;top:489PX;width:104PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">300,000.00</span></DIV>

<DIV style="left:647PX;top:489PX;width:100PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:966PX;top:489PX;width:93PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">300,000.00</span></DIV>

<DIV style="left:864PX;top:489PX;width:100PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:198PX;top:489PX;width:238PX;height:21PX;"><span class="fc1-4">ทุนจดทะเบียน</span></DIV>

<DIV style="left:46PX;top:513PX;width:1031PX;height:23PX;background-color:FFF0D9;layer-background-color:FFF0D9;">
<table width="1026PX" border=0 cellpadding=0 cellspacing=0><td class="fc1-5">&nbsp;</td></table>
</DIV>

<DIV style="left:48PX;top:513PX;width:85PX;height:21PX;TEXT-ALIGN:CENTER;"><span class="fc1-4">330000</span></DIV>

<DIV style="left:133PX;top:513PX;width:65PX;height:21PX;TEXT-ALIGN:CENTER;"><span class="fc1-4">000</span></DIV>

<DIV style="left:749PX;top:513PX;width:103PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:432PX;top:513PX;width:96PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:531PX;top:513PX;width:104PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">30,000.00</span></DIV>

<DIV style="left:647PX;top:513PX;width:100PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:966PX;top:513PX;width:93PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">30,000.00</span></DIV>

<DIV style="left:864PX;top:513PX;width:100PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:198PX;top:513PX;width:238PX;height:21PX;"><span class="fc1-4">กำไร(ขาดทุน)สะสม</span></DIV>

<DIV style="left:46PX;top:536PX;width:1031PX;height:23PX;"><span class="fc1-5">&nbsp;</span></DIV>

<DIV style="left:48PX;top:536PX;width:85PX;height:21PX;TEXT-ALIGN:CENTER;"><span class="fc1-4">411000</span></DIV>

<DIV style="left:133PX;top:536PX;width:65PX;height:21PX;TEXT-ALIGN:CENTER;"><span class="fc1-4">000</span></DIV>

<DIV style="left:749PX;top:536PX;width:103PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">97,753.75</span></DIV>

<DIV style="left:432PX;top:536PX;width:96PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:531PX;top:536PX;width:104PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">97,753.75</span></DIV>

<DIV style="left:647PX;top:536PX;width:100PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:966PX;top:536PX;width:93PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:864PX;top:536PX;width:100PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:198PX;top:536PX;width:238PX;height:21PX;"><span class="fc1-4">ขาย</span></DIV>

<DIV style="left:46PX;top:559PX;width:1031PX;height:23PX;background-color:FFF0D9;layer-background-color:FFF0D9;">
<table width="1026PX" border=0 cellpadding=0 cellspacing=0><td class="fc1-5">&nbsp;</td></table>
</DIV>

<DIV style="left:48PX;top:559PX;width:85PX;height:21PX;TEXT-ALIGN:CENTER;"><span class="fc1-4">511000</span></DIV>

<DIV style="left:133PX;top:559PX;width:65PX;height:21PX;TEXT-ALIGN:CENTER;"><span class="fc1-4">000</span></DIV>

<DIV style="left:749PX;top:559PX;width:103PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:432PX;top:559PX;width:96PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">101,000.00</span></DIV>

<DIV style="left:531PX;top:559PX;width:104PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:647PX;top:559PX;width:100PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">101,000.00</span></DIV>

<DIV style="left:966PX;top:559PX;width:93PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:864PX;top:559PX;width:100PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:198PX;top:559PX;width:238PX;height:21PX;"><span class="fc1-4">ต้นทุนสินค้าเพื่อขาย</span></DIV>

<DIV style="left:46PX;top:582PX;width:1031PX;height:23PX;"><span class="fc1-5">&nbsp;</span></DIV>

<DIV style="left:48PX;top:582PX;width:85PX;height:21PX;TEXT-ALIGN:CENTER;"><span class="fc1-4">531201</span></DIV>

<DIV style="left:133PX;top:582PX;width:65PX;height:21PX;TEXT-ALIGN:CENTER;"><span class="fc1-4">000</span></DIV>

<DIV style="left:749PX;top:582PX;width:103PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:432PX;top:582PX;width:96PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">477.76</span></DIV>

<DIV style="left:531PX;top:582PX;width:104PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:647PX;top:582PX;width:100PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">477.76</span></DIV>

<DIV style="left:966PX;top:582PX;width:93PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:864PX;top:582PX;width:100PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:198PX;top:582PX;width:238PX;height:21PX;"><span class="fc1-4">ค่าเสื่อมราคา - เครื่องตกแต่งและเครื่องใช้สำนักงาน</span></DIV>

<DIV style="left:46PX;top:606PX;width:1031PX;height:23PX;background-color:FFF0D9;layer-background-color:FFF0D9;">
<table width="1026PX" border=0 cellpadding=0 cellspacing=0><td class="fc1-5">&nbsp;</td></table>
</DIV>

<DIV style="left:48PX;top:606PX;width:85PX;height:21PX;TEXT-ALIGN:CENTER;"><span class="fc1-4">531502</span></DIV>

<DIV style="left:133PX;top:606PX;width:65PX;height:21PX;TEXT-ALIGN:CENTER;"><span class="fc1-4">000</span></DIV>

<DIV style="left:749PX;top:606PX;width:103PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:432PX;top:606PX;width:96PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">1,052,000.00</span></DIV>

<DIV style="left:531PX;top:606PX;width:104PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:647PX;top:606PX;width:100PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">1,052,000.00</span></DIV>

<DIV style="left:966PX;top:606PX;width:93PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:864PX;top:606PX;width:100PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-4">0.00</span></DIV>

<DIV style="left:198PX;top:606PX;width:238PX;height:21PX;"><span class="fc1-4">ค่าใช้จ่ายเบ็ดเตล็ด</span></DIV>
-->

<!--Total Line-->
<DIV style="left: 11px; top: 660PX; width: 1065px; height: 20PX; background-color: FFC16F; layer-background-color: FFC16F;" class="ad1-0">
<table width="635PX" border=0 cellpadding=0 cellspacing=0><td class="fc1-0">&nbsp;</td></table>
</DIV>
<DIV style="left: 634px; top: 661px; width: 76px; height: 22PX; TEXT-ALIGN: RIGHT;"><span class="fc1-1">1,809,639.27</span></DIV>

<DIV style="left: 863px; top: 661px; width: 71px; height: 22PX; TEXT-ALIGN: RIGHT;"><span class="fc1-1">656,161.51</span></DIV>

<DIV style="left: 711px; top: 660PX; width: 72px; height: 22PX; TEXT-ALIGN: RIGHT;"><span class="fc1-1">1,153,477.76</span></DIV>

<DIV style="left:975PX;top:660PX;width:84PX;height:22PX;TEXT-ALIGN:RIGHT;"><span class="fc1-1">1,711,885.52</span></DIV>

<DIV style="left: 783px; top: 660PX; width: 76px; height: 22PX; TEXT-ALIGN: RIGHT;"><span class="fc1-1">97,753.75</span></DIV>

<DIV style="left: 331px; top: 660PX; width: 106PX; height: 21PX; TEXT-ALIGN: RIGHT;"><span class="fc1-5">รวมทั้งสิ้น</span></DIV>
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

?>