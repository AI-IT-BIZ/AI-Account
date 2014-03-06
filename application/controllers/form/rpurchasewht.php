<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rpurchasewht extends CI_Controller {
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
		//$no = $type = $this->uri->segment(4);
		$date =	$this->input->get('bldat');
		$copies =	$this->input->get('copies');
		$month = explode('-',$date);
		$dt_result = util_helper_get_sql_between_month($date);
		$text_month = $this->convert_amount->text_month($month[1]);
		$whtxt='';$whtgp='';
		if($copies<=0) $copies = 1;
		
		$strSQL1 = " select v_ebbp.*";
        $strSQL1 = $strSQL1 . " from v_ebbp ";
        $strSQL1 = $strSQL1 . " Where v_ebbp.type1 = '1' and v_ebbp.bldat ".$dt_result;
		$strSQL1 = $strSQL1 . " And v_ebbp.statu = '02' ";
		$strSQL1 .= " ORDER BY payno ASC";
       
		$query = $this->db->query($strSQL1);
		//$r_data = $query->first_row('array');
		// calculate sum
		//$rows = $query->result_array();
		//$b_amt = 0;
		$taxid = str_split($r_com['taxid']);
		$b_amt = 0; $result = array();
		$t1_wht='';$t2_wht='';$t3_wht='';
		if($query->num_rows()>0){
			$r_data = $query->first_row('array');
		// calculate sum
		$rows = $query->result_array();
		foreach($rows as $key => $pay){
		
		$strSQL = " select v_ebrp.*";
        $strSQL = $strSQL . " from v_ebrp ";
        $strSQL = $strSQL . " Where v_ebrp.invnr = '".$pay['invnr']."'";
		$strSQL .= "ORDER BY vbelp ASC";
       
		$q_inv = $this->db->query($strSQL);
		if($q_inv->num_rows()>0){
		   	$rowp = $q_inv->result_array();
			foreach($rowp as $key => $item){
				$strSQL="";
        //if(!empty($item['whtnr'])){
			//echo 'aaa'.$item['whtnr'];
		$strSQL= " select tbl_whty.* from tbl_whty where tbl_whty.whtnr = '".$item['whtnr']."'";
		$q_wht = $this->db->query($strSQL);
		 $g1_wht='';$g2_wht='';$g3_wht='';
		 
		if($q_wht->num_rows()>0){
			$q_data = $q_wht->first_row('array');
		    $t1_wht = $q_data['whtpr'];
			$g1_wht = $q_data['whtgp'];
			$whtxt = str_replace('%','',$t1_wht);
			$whtgp = $g1_wht;
			if($t1_wht != $q_data['whtpr']){
			  $t2_wht = $q_data['whtpr'];
			  $g2_wht = $q_data['whtgp']; 
			  $whtxt = $whtxt.str_replace('%','',$t2_wht);
			  $whtgp = $whtgp.$g2_wht;
			  if($t2_wht != $q_data['whtpr']){
				 $t3_wht = $q_data['whtpr'];  
				 $g3_wht = $q_data['whtgp'];
				 $whtxt = $whtxt.str_replace('%','',$t3_wht);
				 $whtgp = $whtgp.$g3_wht;
			  }
			}
		}//wht percent
			//}//check whtnr
			}//loop payment
		}
		}
		}

		function check_page($page_index, $total_page, $value){
			//return ($page_index==0 && $total_page>1)?"":$value;
			if($page_index==0&&$total_page==1){
				return $value;
			}else{
			$page_index+=1;
			if($page_index==$total_page && $total_page>1) return $value;
			else "";
			}
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
.fc1-8 { COLOR:000000;FONT-SIZE:13PT;FONT-FAMILY:Angsana New;FONT-WEIGHT:NORMAL;}
.ad1-0 {border-color:FF8600;border-style:none;border-bottom-style:solid;border-bottom-width:1PX;border-left-width:0PX;border-top-style:solid;border-top-width:1PX;border-right-width:0PX;}
.ad1-1 {border-color:000000;border-style:none;border-bottom-width:0PX;border-left-width:0PX;border-top-width:0PX;border-right-width:0PX;}
.ad1-2 {border-color:000000;border-style:none;border-bottom-width:0PX;border-left-width:0PX;border-top-width:0PX;border-right-width:0PX;}
.ad1-3 {border-color:000000;border-style:none;border-bottom-width:0PX;border-left-width:0PX;border-top-width:0PX;border-right-width:0PX;}
.ad1-4 {border-color:000000;border-style:none;border-bottom-width:0PX;border-left-width:0PX;border-top-style:solid;border-top-width:0PX;border-right-width:0PX;}
</STYLE>

<TITLE>Crystal Report Viewer</TITLE>
<BODY BGCOLOR="FFFFFF"LEFTMARGIN=0 TOPMARGIN=0 BOTTOMMARGIN=0 RIGHTMARGIN=0>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<DIV style="z-index:0"> &nbsp; </div>

<? if($query->num_rows()==0){ ?>
		   <DIV style="left: 478px; top: 94px; width: 263PX; height: 25PX; TEXT-ALIGN: CENTER;"><span class="fc1-0">No Data was selected</span></DIV>
<? }?>

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
		echo ' style="position:relative; height:720px;">';
		$real_current_page++;
?>

<!--Copies-->
<?php if($current_copy_index>0): ?>
<DIV style="left: 910px; top: 50px; width: 40PX; height: 20PX;"><span class="fc1-2">สำเนา</span></DIV>
<DIV style="left: 958px; top: 49px; width: 112PX; height: 25PX;"><span class="fc1-3"><?= $current_copy_index ?></span></DIV>
<?php else: ?>
<DIV style="left: 909px; top: 50px; width: 40PX; height: 20PX;"><span class="fc1-2">ต้นฉบับ</span></DIV>
<?php endif; ?>

<!--Page No-->

<DIV style="left: 12px; top: 156PX; width: 1065px; height: 47PX; background-color: FFC16F; layer-background-color: FFC16F;" class="ad1-0">
<table width="1026PX" border=0 cellpadding=0 cellspacing=0><td class="fc1-0">&nbsp;</td></table>
</DIV>

<DIV style="left: 922px; top: 109px; width: 42px; height: 21PX;"><span class="fc1-1"><?=($current_page_index+1);?></span></DIV>

<DIV style="left: 1027px; top: 108px; width: 42px; height: 21PX;"><span class="fc1-1"><?=$total_page;?></span></DIV>

<!--Check Box 1-->
<DIV style="left: 470px; top: 73px; width: 57px; height: 21PX;"><span class="fc1-1">สำหรับเดือน</span></DIV>
<DIV style="left: 595px; top: 106px; width: 84px; height: 21PX;"><span class="fc1-1">สำนักงานใหญ่</span></DIV>
<DIV style="left: 682px; top: 106px; width: 33px; height: 21PX;"><span class="fc1-1">00000</span></DIV>

<DIV style="left: 743px; top: 107px; width: 39px; height: 21PX;"><span class="fc1-1">สาขา</span></DIV>
<DIV style="left: 787px; top: 106px; width: 33px; height: 21PX;"><span class="fc1-1">00000</span></DIV>

<DIV style="left: 537px; top: 73px; width: 87px; height: 25PX; TEXT-ALIGN: LEFT;"><span class="fc1-1"><?= $text_month ?></span></DIV>

<DIV style="left: 623px; top: 73px; width: 30px; height: 21PX;"><span class="fc1-1">พ.ศ.</span></DIV>

<DIV style="left: 651px; top: 73px; width: 61px; height: 25PX; TEXT-ALIGN: LEFT;"><span class="fc1-1"><?= $month[0] ?></span></DIV>
<DIV style="left: 950px; top: 108px; width: 92px; height: 21PX;"><span class="fc1-1">ในจำนวนแผ่น</span></DIV>

<DIV style="left: 881px; top: 108px; width: 42px; height: 21PX;"><span class="fc1-1">แผ่นที่</span></DIV>

<DIV style="left: 595px; top: 129px; width: 177px; height: 21PX;"><span class="fc1-1">เลขประจำตัวผู้เสียภาษีอากร</span></DIV>
<DIV style="left: 13px; top: 127px; width: 95px; height: 21PX;"><span class="fc1-1">ชื่อผู้ประกอบการ</span></DIV>

<DIV style="left: 110px; top: 127px; width: 251px; height: 21PX;"><span class="fc1-1"><?= $r_com['name1']; ?></span></DIV>
<DIV style="left: 743px; top: 129px; width: 123px; height: 21PX;"><span class="fc1-1"><?= $r_com['taxid']; ?></span></DIV>

<DIV style="left: 352px; top: 44px; width: 500px; height: 28PX; background-color: FF8600; layer-background-color: FF8600;TEXT-ALIGN: CENTER;"><span class="fc1-3">
  รายงานภาษีหัก ณ ที่จ่าย ของผู้มีเงินได้ ที่เป็นนิติบุคคล  (ใบแนบ ภ.ง.ด.53)
</span></DIV>
<div style="left: 53px; top: 157px; border-style: solid; border-width: 0px; border-left-width: 1PX; height: 503px;"class="ad1-0">
  <table width="0px" height="205PX">
      <td>&nbsp;</td>
  </table>
</div>
<DIV style="left: 12px; top: 168px; width: 40px; height: 22PX; TEXT-ALIGN: CENTER;"><span class="fc1-5">ลำดับที่</span></DIV>
<div style="left: 13px; top: 157px; border-style: solid; border-width: 0px; border-left-width: 1PX; height: 503px;"class="ad1-0">
  <table width="0px" height="205PX">
      <td>&nbsp;</td>
  </table>
</div>
<div style="left: 658px; top: 158px; border-style: solid; border-width: 0px; border-left-width: 1PX; height: 504px;"class="ad1-0">
  <table width="0px" height="205PX"><td>&nbsp;</td></table>
</div>

<DIV style="left: 54px; top: 158px; width: 85px; height: 22PX; TEXT-ALIGN: CENTER;"><span class="fc1-5">เลขที่ประจำตัว</span></DIV>
<DIV style="left: 53px; top: 181px; width: 87px; height: 22PX; TEXT-ALIGN: CENTER;"><span class="fc1-5">ผู้เสียภาษีอากร</span></DIV>

<DIV style="left: 659px; top: 171px; width: 41px; height: 22PX; TEXT-ALIGN: CENTER;"><span class="fc1-5">สาขา</span></DIV>

<div style="left: 139px; top: 156px; border-style: solid; border-width: 0px; border-left-width: 1PX; height: 504px;"class="ad1-0">
  <table width="0px" height="205PX"><td>&nbsp;</td></table>
</div>
<DIV style="left: 140px; top: 170px; width: 221px; height: 22PX; TEXT-ALIGN: CENTER;"><span class="fc1-5">ชื่อ</span></DIV>

<div style="left: 361px; top: 157px; border-style: solid; border-width: 0px; border-left-width: 1PX; height: 503px;"class="ad1-0">
  <table width="0px" height="205PX"><td>&nbsp;</td></table>
</div>

<DIV style="left: 361px; top: 171px; width: 297px; height: 22PX; TEXT-ALIGN: CENTER;"><span class="fc1-5">ที่ตั้งสถานประกอบการ</span></DIV>

<div style="left: 700px; top: 158px; border-style: solid; border-width: 0px; border-left-width: 1PX; height: 504px;"class="ad1-0">
  <table width="0px" height="205PX"><td>&nbsp;</td></table>
</div>

<DIV style="left: 701px; top: 158px; width: 63px; height: 22PX; TEXT-ALIGN: CENTER;"><span class="fc1-5">วัน เดือน ปี</span></DIV>

<DIV style="left: 701px; top: 182px; width: 64px; height: 22PX; TEXT-ALIGN: CENTER;"><span class="fc1-5">ที่จ่าย</span></DIV>

<DIV style="left: 764px; top: 157px; width: 46px; height: 22PX; TEXT-ALIGN: CENTER;"><span class="fc1-5">ประเภท</span></DIV>

<DIV style="left: 765px; top: 180px; width: 46px; height: 22PX; TEXT-ALIGN: CENTER;"><span class="fc1-5">เงินได้</span></DIV>

<div style="left: 810px; top: 157px; border-style: solid; border-width: 0px; border-left-width: 1PX; height: 504px;"class="ad1-0">
  <table width="0px" height="205PX"><td>&nbsp;</td></table>
</div>

<DIV style="left: 810px; top: 157px; width: 52px; height: 22PX; TEXT-ALIGN: CENTER;"><span class="fc1-5">อัตราภาษี</span></DIV>

<DIV style="left: 810px; top: 180px; width: 53px; height: 22PX; TEXT-ALIGN: CENTER;"><span class="fc1-5">ร้อยละ</span></DIV>

<DIV style="left: 863px; top: 171px; width: 105px; height: 22PX; TEXT-ALIGN: CENTER;"><span class="fc1-5">จำนวนเงินที่ได้รับ</span></DIV>

<div style="left: 863px; top: 157px; border-style: solid; border-width: 0px; border-left-width: 1PX; height: 504px;"class="ad1-0">
  <table width="0px" height="205PX"><td>&nbsp;</td></table>
</div>

<div style="left: 764px; top: 156px; border-style: solid; border-width: 0px; border-left-width: 1PX; height: 505px;"class="ad1-0">
  <table width="0px" height="205PX"><td>&nbsp;</td></table>
</div>

<div style="left: 967px; top: 157px; border-style: solid; border-width: 0px; border-left-width: 1PX; height: 522px;"class="ad1-0">
  <table width="0px" height="205PX"><td>&nbsp;</td></table>
</div>

<DIV style="left: 968px; top: 157px; width: 108px; height: 22PX; TEXT-ALIGN: CENTER;"><span class="fc1-5">จำนวนเงินภาษีที่หัก</span></DIV>

<DIV style="left: 974px; top: 180px; width: 80px; height: 22PX; TEXT-ALIGN: CENTER;"><span class="fc1-5">และนำส่งในครั้งนี้</span></DIV>

<div style="left: 1077px; top: 156px; border-style: solid; border-width: 0px; border-left-width: 1PX; height: 520px;"class="ad1-0">
  <table width="0px" height="205PX"><td>&nbsp;</td></table>
</div>

<DIV style="left: 13px; top: 210PX; width: 1064px; height: 23PX;"><span class="fc1-5">&nbsp;</span></DIV>

<!--Item List-->
<DIV style="left: 13px; top: 210px">
<table cellpadding="0" cellspacing="0" border="0" width="1060">
<?php
//$rows = $query->result_array();

$j=0;$no=1;$total1=0;$total2=0;
for ($i=($current_page_index * $page_size);$i<($current_page_index * $page_size + $page_size) && $i<count($rows);$i++)://$rows as $key => $item):
	
	$item = $rows[$i];
	$itamt = $item['beamt'] - $item['dismt'];
	$b_amt += $itamt;
	$duedt_str = util_helper_format_date($item['bldat']);
	$adr01 = $item['adr01'].$item['distx'];
	$total1 += $item['netwr'];
	$total2 += $item['wht01'];
?>
	<tr>
	  <td class="fc1-8" align="center" style="width:40px;"><?=$no++;?></td>
	  <td class="fc1-8" align="center" style="width:87px;"><?=$item['taxid'];?></td>
	  <td class="fc1-8" align="left" style="width:223px;"><?=$item['name1'];?></td>
      <td class="fc1-8" align="left" style="width:297px;"><?=$adr01;?></td>
	  <td class="fc1-8" align="center" style="width:40px;">0000</td>
	  <td class="fc1-8" align="center" style="width:63px;"><?=$duedt_str;?></td>
      <td class="fc1-8" align="center" style="width:46px;"><?=$whtgp; ?></td>
      <td class="fc1-8" align="center" style="width:52px;"><?=$whtxt; ?></td>
      <td class="fc1-8" align="right" style="width:105px;"><?=number_format($item['netwr'],2,'.',',');?></td>
	  <td class="fc1-8" align="right" style="width:108px;"><?=number_format($item['wht01'],2,'.',',');?></td>
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
<DIV style="left: 11px; top: 660PX; width: 1067px; height: 20PX; background-color: FFC16F; layer-background-color: FFC16F;" class="ad1-0">
<table width="635PX" border=0 cellpadding=0 cellspacing=0><td class="fc1-0">&nbsp;</td></table>
</DIV>
<DIV style="left: 894px; top: 661px; width: 71px; height: 22PX; TEXT-ALIGN: RIGHT;"><span class="fc1-1"><?= check_page($current_page_index, $total_page, number_format($total1,2,'.',',')) ?></span></DIV>
<DIV style="left: 990px; top: 659px; width: 84PX; height: 22PX; TEXT-ALIGN: RIGHT;"><span class="fc1-1"><?= check_page($current_page_index, $total_page, number_format($total2,2,'.',',')) ?></span></DIV>
<DIV style="left: 440px; top: 662px; width: 106PX; height: 21PX; TEXT-ALIGN: RIGHT;"><span class="fc1-5">รวมทั้งสิ้น</span></DIV>
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