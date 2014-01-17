<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rsalarywht_attach extends CI_Controller {
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
		//$r_data = $query->first_row('array');
		
		// calculate sum
		$rows = $query->result_array();
		$b_amt = 0; $result = array();
		$i=0;
		foreach ($rows as $key => $item) {
			$result[$i]['emnam']=$item['emnam'];
			$result[$i]['taxid']=$item['taxid'];
			$result[$i]['bldat']=$item['bldat'];
			if($item['saknr']=='2132-01'){
		       $result[$i]['credi']=$item['credi'];
			   $i++;
		    }else{ $result[$i]['debit']= $item['debit']; }
			
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
.fc1-0 { COLOR:000000;FONT-SIZE:10PT;FONT-FAMILY:'angsana_newbold';}
.fc1-1 { COLOR:000000;FONT-SIZE:21PT;FONT-FAMILY:'angsana_newbold';}
.fc1-2 { COLOR:000000;FONT-SIZE:13PT;FONT-FAMILY:'angsana_newbold';}
.fc1-3 { COLOR:000000;FONT-SIZE:9PT;FONT-WEIGHT:NORMAL;FONT-STYLE:ITALIC;}
.fc1-4 { COLOR:000000;FONT-SIZE:11PT;FONT-FAMILY:'angsana_newbold';}
.fc1-5 { COLOR:000000;FONT-SIZE:11PT;FONT-WEIGHT:NORMAL;FONT-STYLE:ITALIC;}
.fc1-6 { COLOR:000000;FONT-SIZE:11PT;FONT-FAMILY:Wingdings;FONT-WEIGHT:NORMAL;}
.fc1-7 { COLOR:000000;FONT-SIZE:12PT;FONT-WEIGHT:NORMAL;}
.fc1-8 { COLOR:000000;FONT-SIZE:11PT;;FONT-WEIGHT:NORMAL;}
.fc1-9 { COLOR:000000;FONT-SIZE:10PT;FONT-WEIGHT:NORMAL;}
.fc1-10 { COLOR:000000;FONT-SIZE:10PT;FONT-WEIGHT:NORMAL;FONT-STYLE:ITALIC;}
.fc1-11 { COLOR:808080;FONT-SIZE:8PT;FONT-WEIGHT:NORMAL;}
.fc1-12 { COLOR:000000;FONT-SIZE:11PT;FONT-WEIGHT:NORMAL;}
.fc1-13 { COLOR:000000;FONT-SIZE:7PT;FONT-FAMILY:Wingdings;FONT-WEIGHT:NORMAL;}
.ad1-0 {border-color:000000;border-style:none;border-bottom-width:0PX;border-left-width:0PX;border-top-width:0PX;border-right-width:0PX;}
.ad1-1 {border-color:000000;border-style:none;border-bottom-width:0PX;border-left-style:solid;border-left-width:1PX;border-top-width:0PX;border-right-width:0PX;}
.ad1-2 {border-color:000000;border-style:none;border-bottom-width:0PX;border-left-width:0PX;border-top-style:solid;border-top-width:1PX;border-right-width:0PX;}
.ad1-3 {border-color:000000;border-style:none;border-bottom-width:0PX;border-left-style:solid;border-left-width:1PX;border-top-width:0PX;border-right-width:0PX;}
.ad1-4 {border-color:000000;border-style:none;border-bottom-width:0PX;border-left-width:0PX;border-top-style:solid;border-top-width:1PX;border-right-width:0PX;}
.ad1-5 {border-color:000000;border-style:none;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;}
.ad1-6 {border-color:808080;border-style:none;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;}
</STYLE>

<BODY BGCOLOR="FFFFFF"LEFTMARGIN=0 TOPMARGIN=0 BOTTOMMARGIN=0 RIGHTMARGIN=0>

<? if($query->num_rows()==0){ ?>
		   <DIV style="left: 478px; top: 94px; width: 263PX; height: 25PX; TEXT-ALIGN: CENTER;"><span class="fc1-1">No Data was selected</span></DIV>
<? }?>

<?php
$current_copy_index = 0;
for($current_copy_index=0;$current_copy_index<$copies;$current_copy_index++):

	// check total page
	$page_size = 8;
	$total_count = count($result);
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

<div style="left: 121PX; top: 172PX; border-color: 000000; border-style: solid; border-width: 0px; border-left-width: 1PX; height: 419px;">
<table width="0px" height="419PX"><td>&nbsp;</td></table>
</div>
<div style="left:121PX;top:200PX;border-color:000000;border-style:solid;border-width:0px;border-top-width:1PX;width:466PX;">
</div>
<div style="left:1001PX;top:172PX;border-color:000000;border-style:solid;border-width:0px;border-left-width:1PX;height:454PX;">
<table width="0px" height="448PX"><td>&nbsp;</td></table>
</div>
<div style="left:845PX;top:227PX;border-color:000000;border-style:solid;border-width:0px;border-left-width:1PX;height:399PX;">
<table width="0px" height="393PX"><td>&nbsp;</td></table>
</div>
<div style="left:975PX;top:227PX;border-color:000000;border-style:solid;border-width:0px;border-left-width:1PX;height:399PX;">
<table width="0px" height="393PX"><td>&nbsp;</td></table>
</div>
<div style="left:738PX;top:193PX;border-color:000000;border-style:solid;border-width:0px;border-left-width:1PX;height:434PX;">
<table width="0px" height="428PX"><td>&nbsp;</td></table>
</div>
<div style="left: 586PX; top: 172PX; border-color: 000000; border-style: solid; border-width: 0px; border-left-width: 1PX; height: 420px;">
<table width="0px" height="419PX"><td>&nbsp;</td></table>
</div>
<div style="left:382PX;top:172PX;border-color:000000;border-style:solid;border-width:0px;border-left-width:1PX;height:29PX;">
<table width="0px" height="23PX"><td>&nbsp;</td></table>
</div>
<div style="left:70PX;top:172PX;border-color:000000;border-style:solid;border-width:0px;border-left-width:1PX;height:574PX;">
<table width="0px" height="568PX"><td>&nbsp;</td></table>
</div>
<div style="left:1029PX;top:172PX;border-color:000000;border-style:solid;border-width:0px;border-left-width:1PX;height:574PX;">
<table width="0px" height="568PX"><td>&nbsp;</td></table>
</div>
<div style="left:70PX;top:172PX;border-color:000000;border-style:solid;border-width:0px;border-top-width:1PX;width:960PX;">
</div>
<div style="left:70PX;top:227PX;border-color:000000;border-style:solid;border-width:0px;border-top-width:1PX;width:960PX;">
</div>
<div style="left:586PX;top:194PX;border-color:000000;border-style:solid;border-width:0px;border-top-width:1PX;width:286PX;">
</div>
<div style="left:871PX;top:172PX;border-color:000000;border-style:solid;border-width:0px;border-left-width:1PX;height:453PX;">
<table width="0px" height="447PX"><td>&nbsp;</td></table>
</div>

<div style="left:70PX;top:271PX;border-color:000000;border-style:solid;border-width:0px;border-top-width:1PX;width:960PX;">
</div>
<div style="left: 70PX; top: 317px; border-color: 000000; border-style: solid; border-width: 0px; border-top-width: 1PX; width: 960PX;">
</div>
<div style="left: 70PX; top: 363px; border-color: 000000; border-style: solid; border-width: 0px; border-top-width: 1PX; width: 960PX;">
</div>

<div style="left: 70PX; top: 408px; border-color: 000000; border-style: solid; border-width: 0px; border-top-width: 1PX; width: 960PX;">
</div>
<div style="left: 70PX; top: 455px; border-color: 000000; border-style: solid; border-width: 0px; border-top-width: 1PX; width: 960PX;">
</div>
<div style="left: 70PX; top: 501px; border-color: 000000; border-style: solid; border-width: 0px; border-top-width: 1PX; width: 960PX;">
</div>
<div style="left: 70PX; top: 546px; border-color: 000000; border-style: solid; border-width: 0px; border-top-width: 1PX; width: 960PX;">
</div>

<div style="left:70PX;top:596PX;border-color:000000;border-style:solid;border-width:0px;border-left-width:1PX;height:4PX;">
<table width="0px" height="-2PX"><td>&nbsp;</td></table>
</div>
<div style="left: 70PX; top: 590px; border-color: 000000; border-style: solid; border-width: 0px; border-top-width: 1PX; width: 960PX;">
</div>
<div style="left:70PX;top:625PX;border-color:000000;border-style:solid;border-width:0px;border-top-width:1PX;width:934PX;">
</div>
<div style="left:585PX;top:625PX;border-color:000000;border-style:solid;border-width:0px;border-left-width:1PX;height:122PX;">
<table width="0px" height="116PX"><td>&nbsp;</td></table>
</div>
<div style="left:70PX;top:745PX;border-color:000000;border-style:solid;border-width:0px;border-top-width:1PX;width:960PX;">
</div>

<DIV class="box" style="z-index:10; border-color:000000;border-style:solid;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;left:70PX;top:80PX;width:791PX;height:92PX;">
<table border=0 cellpadding=0 cellspacing=0 width=784px height=84px><TD>&nbsp;</TD></TABLE>
</DIV>
<DIV style="left:249PX;top:43PX;width:136PX;height:15PX;"><span class="fc1-0">เลขประจำตัวประชาชน</span></DIV>

<DIV style="left:121PX;top:42PX;width:119PX;height:31PX;"><span class="fc1-1">ภ.ง.ด.1</span></DIV>

<DIV style="left:71PX;top:51PX;width:50PX;height:22PX;"><span class="fc1-2">ใบแนบ</span></DIV>

<DIV style="left:249PX;top:58PX;width:136PX;height:16PX;"><span class="fc1-3">( ของผู้มีหน้าที่หักภาษี ณ ที่จ่าย)</span></DIV>

<DIV style="left:615PX;top:58PX;width:246PX;height:18PX;"><span class="fc1-3">(ของผู้มีหน้าที่หักภาษี ณ ที่จ่าย ที่เป็นผู้ไม่มีเลขประจำตัวประชาชน)</span></DIV>

<DIV style="left:615PX;top:43PX;width:246PX;height:18PX;"><span class="fc1-0">เลขประจำตัวผู้เสียภาษีอากร</span></DIV>

<DIV style="left:877PX;top:53PX;width:140PX;height:22PX;"><span class="fc1-4"><?= $r_com['taxid']; ?></span></DIV>

<DIV style="left:75PX;top:84PX;width:342PX;height:19PX;"><span class="fc1-5">( ให้แยกกรอกรายการในใบแนบนี้ตามเงินได้แต่ละประเภท โดยใส่เครื่องหมาย " </span></DIV>

<DIV style="left:417PX;top:86PX;width:13PX;height:19PX;TEXT-ALIGN:CENTER;"><img  WIDTH=20 HEIGHT=18 SRC="<?= base_url('assets/images/icons/checkbox02.jpg') ?>"></DIV>

<DIV style="left:430PX;top:84PX;width:37PX;height:19PX;"><span class="fc1-5">" ลงใน "</span></DIV>

<DIV style="left:467PX;top:86PX;width:17PX;height:17PX;TEXT-ALIGN:CENTER;"><img  WIDTH=15 HEIGHT=15 SRC="<?= base_url('assets/images/icons/checkbox01.jpg') ?>"></DIV>

<DIV style="left:484PX;top:84PX;width:189PX;height:19PX;"><span class="fc1-5">" หน้าข้อความแล้วแต่กรณี&nbsp;&nbsp;เพียงข้อเดียว )</span></DIV>

<DIV style="left:75PX;top:103PX;width:77PX;height:21PX;"><span class="fc1-4">ประเภทเงินได้</span></DIV>

<DIV style="left:152PX;top:103PX;width:15PX;height:22PX;TEXT-ALIGN:CENTER;"><img  WIDTH=20 HEIGHT=18 SRC="<?= base_url('assets/images/icons/checkbox02.jpg') ?>"></DIV>

<DIV style="left:150PX;top:127PX;width:17PX;height:17PX;TEXT-ALIGN:CENTER;"><img  WIDTH=15 HEIGHT=15 SRC="<?= base_url('assets/images/icons/checkbox01.jpg') ?>"></DIV>

<DIV style="left:167PX;top:101PX;width:287PX;height:22PX;"><span class="fc1-7">(1) เงินได้ตามมาตรา 40(1) เงินเดือน ค่าจ้าง ฯลฯ กรณี ทั่วไป</span></DIV>

<DIV style="left:167PX;top:123PX;width:271PX;height:22PX;"><span class="fc1-7">(2) เงินได้ตามมาตรา 40(1) เงินเดือน ค่าจ้าง ฯลฯ </span></DIV>

<DIV style="left:167PX;top:146PX;width:271PX;height:21PX;"><span class="fc1-7">กรณีได้รับอนุมัติจากกรมสรรพากรให้หักอัตรา ร้อยละ 3</span></DIV>

<DIV style="left:454PX;top:104PX;width:17PX;height:17PX;TEXT-ALIGN:CENTER;"><img  WIDTH=15 HEIGHT=15 SRC="<?= base_url('assets/images/icons/checkbox01.jpg') ?>"></DIV>

<DIV style="left:454PX;top:127PX;width:17PX;height:17PX;TEXT-ALIGN:CENTER;"><img  WIDTH=15 HEIGHT=15 SRC="<?= base_url('assets/images/icons/checkbox01.jpg') ?>"></DIV>

<DIV style="left:454PX;top:149PX;width:17PX;height:17PX;TEXT-ALIGN:CENTER;"><img  WIDTH=15 HEIGHT=15 SRC="<?= base_url('assets/images/icons/checkbox01.jpg') ?>"></DIV>

<DIV style="left:471PX;top:101PX;width:390PX;height:19PX;"><span class="fc1-7">(3) เงินได้ตามมาตรา 40(1)(2) กรณีนายจ้างจ่ายให้ครั้งเดียวเพราะเหตุออกจากงาน</span></DIV>

<DIV style="left:471PX;top:123PX;width:344PX;height:19PX;"><span class="fc1-7">(4) เงินได้ตามมาตรา 40(2) กรณีผู้รับเงินได้เป็นผู้อยู่ในประเทศไทย</span></DIV>

<DIV style="left:471PX;top:146PX;width:344PX;height:22PX;"><span class="fc1-7">(5) เงินได้ตามมาตรา 40(2) กรณีผู้รับเงินได้มิได้เป็นผู้อยู่ในประเทศไทย </span></DIV>

<DIV style="left:914PX;top:80PX;width:42PX;height:21PX;"><span class="fc1-4">สาขาที่</span></DIV>

<DIV style="left:962PX;top:80PX;width:69PX;height:21PX;"><span class="fc1-4">0000</span></DIV>

<DIV style="left:871PX;top:147PX;width:159PX;height:23PX;"><span class="fc1-8">แผ่นที่ ...........ในจำนวน...........แผ่น</span></DIV>

<DIV style="left:904PX;top:144PX;width:22PX;height:21PX;TEXT-ALIGN:CENTER;"><span class="fc1-8"><?=($current_page_index+1);?></span></DIV>

<DIV style="left: 960px; top: 144PX; width: 31PX; height: 21PX; TEXT-ALIGN: CENTER;"><span class="fc1-8"><?=$total_page;?></span></DIV>

<DIV style="left:75PX;top:180PX;width:46PX;height:45PX;TEXT-ALIGN:CENTER;">
<table width="41PX" border=0 cellpadding=0 cellspacing=0>
<tr><td ALIGN="CENTER" class="fc1-8">ลำดับ</td></tr>
<tr><td ALIGN="CENTER" class="fc1-8">ที่</td></tr></table>
</DIV>

<DIV style="left:121PX;top:180PX;width:128PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-8">เลขประจำตัวประชาชน </span></DIV>

<DIV style="left:382PX;top:172PX;width:205PX;height:19PX;TEXT-ALIGN:CENTER;"><span class="fc1-9">เลขประจำตัวผู้เสียภาษีอากร</span></DIV>

<DIV style="left:121PX;top:204PX;width:167PX;height:23PX;TEXT-ALIGN:RIGHT;"><span class="fc1-8">ชื่อผู้มีเงินได้ </span></DIV>

<DIV style="left:586PX;top:174PX;width:285PX;height:20PX;TEXT-ALIGN:CENTER;"><span class="fc1-8">รายละเอียดเกี่ยวกับการจ่ายเงิน</span></DIV>

<DIV style="left:586PX;top:200PX;width:152PX;height:21PX;TEXT-ALIGN:CENTER;"><span class="fc1-8">วัน เดือน ปี ที่จ่าย</span></DIV>

<DIV style="left:738PX;top:200PX;width:133PX;height:21PX;TEXT-ALIGN:CENTER;"><span class="fc1-8">จำนวนเงินได้ที่จ่ายในครั้งนี้</span></DIV>

<DIV style="left:871PX;top:180PX;width:131PX;height:20PX;TEXT-ALIGN:CENTER;"><span class="fc1-8">จำนวนเงินภาษีที่หัก</span></DIV>

<DIV style="left:871PX;top:200PX;width:131PX;height:21PX;TEXT-ALIGN:CENTER;"><span class="fc1-8">และนำส่งในครั้งนี้</span></DIV>

<DIV style="left:249PX;top:180PX;width:84PX;height:21PX;"><span class="fc1-10">(ของผู้มีเงินได้)</span></DIV>

<DIV style="left:382PX;top:185PX;width:205PX;height:17PX;TEXT-ALIGN:CENTER;"><span class="fc1-3">(ของผู้มีเงินได้ที่เป็นผู้ไม่มีเลขประจำตัวประชาชน)</span></DIV>

<DIV style="left:288PX;top:204PX;width:270PX;height:23PX;"><span class="fc1-10">  (ให้ระบุให้ชัดเจนว่าเป็น นาย นาง นางสาว หรือยศ )</span></DIV>


<!--Item List-->
<DIV style="left: 70px; top: 230px">
<table cellpadding="0" cellspacing="0" border="0" width="916">
<?php
//$rows = $query->result_array();
$no=1;$v_amt=0;$t_amt=0;$invdt_str='';
$j=0;$no=1;$nos='';$beamt=0;$taxid='';
for ($i=($current_page_index * $page_size);$i<($current_page_index * $page_size + $page_size) && $i<count($result);$i++)://$rows as $key => $item):
    $item = $result[$i];
	$invdt_str = util_helper_format_date($item['bldat']);
	$names = explode(' ',$item['emnam']);
	//if($item['saknr']=='2132-01'){
		$v_amt+=$item['credi'];
		$t_amt+=$beamt;
		$taxid = str_split($item['taxid']);
		$beamt = $item['debit']; 
?>
	<tr>
		<td align="center" class="fc1-8" style="width:54px;"><?=$no++;?></td>
	  <td align="left" background="<?= base_url('assets/images/icons/pp04.jpg') ?>" class="fc1-8" style="width:250px;background-repeat: no-repeat;" >&nbsp;&nbsp;<?=$taxid[0];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$taxid[1];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$taxid[2];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$taxid[3];?>&nbsp;&nbsp;&nbsp;&nbsp;<?=$taxid[4];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$taxid[5];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$taxid[6];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$taxid[7];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$taxid[8];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$taxid[9];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$taxid[10];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$taxid[11]?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$taxid[12];?></td>
	  <td align="left" class="fc1-8" style="width:160px;"><?=$nos;?></td>
	  <td align="center" class="fc1-8" style="width:130px;"><?=$invdt_str;?></td>
      <td align="right" class="fc1-8" style="width:130px;"><?=number_format($beamt,2,'.',',');?></td>
      <td align="right" class="fc1-8" style="width:120px;"><?=number_format($item['credi'],2,'.',',');?></td>
	</tr>
<!-- Name & Surename -->
    <tr>
		<td class="fc1-8" align="center" style="width:49px;"><?=$nos;?></td>
	  <td class="fc1-8" align="left" style="width:250px;">ชื่อ <?=$names[0];?></td>
	  <td class="fc1-8" align="left" style="width:160px;">ชื่อสกุล <?=$names[1];?></td>
	  <td class="fc1-8" align="center" style="width:130px;"><?=$nos;?></td>
      <td class="fc1-8" align="right" style="width:130px;"><?=$nos;?></td>
      <td class="fc1-8" align="right" style="width:120px;"><?=$nos;?></td>
	</tr>

<?php
   //}else{ 
   //  $beamt = $item['debit']; 
?>
      
<?php   
 //  }
endfor;
?>
</table>
</DIV>

<!--
<DIV style="left:740PX;top:229PX;width:99PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-8">0</span></DIV>

<DIV style="left:845PX;top:229PX;width:26PX;height:20PX;TEXT-ALIGN:CENTER;"><span class="fc1-8">00</span></DIV>

<DIV style="left:874PX;top:229PX;width:95PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-8">0</span></DIV>

<DIV style="left:975PX;top:229PX;width:27PX;height:20PX;TEXT-ALIGN:CENTER;"><span class="fc1-8">00</span></DIV>

<DIV style="left:133PX;top:229PX;width:199PX;height:20PX;"><span class="fc1-8">3012201210019</span></DIV>

<DIV style="left:398PX;top:229PX;width:160PX;height:20PX;"><span class="fc1-8">1201252133208</span></DIV>

<DIV style="left:333PX;top:248PX;width:225PX;height:21PX;"><span class="fc1-8">หวังร่ำรวย</span></DIV>

<DIV style="left:591PX;top:229PX;width:144PX;height:20PX;TEXT-ALIGN:CENTER;"><span class="fc1-8">28/02/2550</span></DIV>

<DIV style="left:1003PX;top:229PX;width:26PX;height:22PX;TEXT-ALIGN:CENTER;"><span class="fc1-8">1</span></DIV>

<DIV style="left:133PX;top:248PX;width:199PX;height:21PX;"><span class="fc1-8">นาย เดือนแรม</span></DIV>

<DIV style="left:75PX;top:229PX;width:46PX;height:20PX;TEXT-ALIGN:CENTER;"><span class="fc1-8">1</span></DIV>

<DIV style="left:740PX;top:273PX;width:99PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-8">0</span></DIV>

<DIV style="left:845PX;top:273PX;width:26PX;height:20PX;TEXT-ALIGN:CENTER;"><span class="fc1-8">00</span></DIV>

<DIV style="left:874PX;top:273PX;width:95PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-8">0</span></DIV>

<DIV style="left:975PX;top:273PX;width:27PX;height:20PX;TEXT-ALIGN:CENTER;"><span class="fc1-8">00</span></DIV>

<DIV style="left:133PX;top:273PX;width:199PX;height:20PX;"><span class="fc1-8">3101242043851</span></DIV>

<DIV style="left:398PX;top:273PX;width:160PX;height:20PX;"><span class="fc1-8">1112424402019</span></DIV>

<DIV style="left:333PX;top:293PX;width:225PX;height:21PX;"><span class="fc1-8">หวังร่ำรวย</span></DIV>

<DIV style="left:591PX;top:273PX;width:144PX;height:20PX;TEXT-ALIGN:CENTER;"><span class="fc1-8">28/02/2550</span></DIV>

<DIV style="left:1003PX;top:273PX;width:26PX;height:22PX;TEXT-ALIGN:CENTER;"><span class="fc1-8">1</span></DIV>

<DIV style="left:133PX;top:293PX;width:199PX;height:21PX;"><span class="fc1-8">นาง เดือนเพ็ญ</span></DIV>

<DIV style="left:75PX;top:273PX;width:46PX;height:20PX;TEXT-ALIGN:CENTER;"><span class="fc1-8">2</span></DIV>

<DIV style="left:740PX;top:318PX;width:99PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-8">0</span></DIV>

<DIV style="left:845PX;top:318PX;width:26PX;height:20PX;TEXT-ALIGN:CENTER;"><span class="fc1-8">00</span></DIV>

<DIV style="left:874PX;top:318PX;width:95PX;height:20PX;TEXT-ALIGN:RIGHT;"><span class="fc1-8">0</span></DIV>

<DIV style="left:975PX;top:318PX;width:27PX;height:20PX;TEXT-ALIGN:CENTER;"><span class="fc1-8">00</span></DIV>

<DIV style="left:133PX;top:318PX;width:199PX;height:20PX;"><span class="fc1-8">3012546278811</span></DIV>

<DIV style="left:398PX;top:318PX;width:160PX;height:20PX;"><span class="fc1-8">4531551524123</span></DIV>

<DIV style="left:333PX;top:338PX;width:225PX;height:21PX;"><span class="fc1-8">หวังร่ำรวย</span></DIV>

<DIV style="left:591PX;top:318PX;width:144PX;height:20PX;TEXT-ALIGN:CENTER;"><span class="fc1-8">28/02/2550</span></DIV>

<DIV style="left:1003PX;top:318PX;width:26PX;height:22PX;TEXT-ALIGN:CENTER;"><span class="fc1-8">1</span></DIV>

<DIV style="left:133PX;top:338PX;width:199PX;height:21PX;"><span class="fc1-8">นาย วันสิกา</span></DIV>

<DIV style="left:75PX;top:318PX;width:46PX;height:20PX;TEXT-ALIGN:CENTER;"><span class="fc1-8">3</span></DIV>

-->

<DIV style="left:75PX;top:628PX;width:483PX;height:22PX;"><span class="fc1-5">( ให้กรอกลำดับที่ต่อเนื่องกันไปทุกแผ่นตามเงินได้แต่ละประเภท</span></DIV>

<DIV style="left:75PX;top:659PX;width:68PX;height:19PX;"><span class="fc1-4">&nbsp;&nbsp;หมายเหตุ&nbsp;&nbsp;* </span></DIV>

<DIV style="left:143PX;top:659PX;width:190PX;height:19PX;"><span class="fc1-8">เงื่อนไขการหักภาษี ให้กรอกดังนี้</span></DIV>

<DIV style="left:154PX;top:678PX;width:95PX;height:19PX;"><span class="fc1-8">&nbsp;&nbsp;หัก&nbsp;&nbsp;ณ ที่จ่าย&nbsp;&nbsp;&nbsp;</span></DIV>

<DIV style="left:154PX;top:697PX;width:95PX;height:19PX;"><span class="fc1-8">&nbsp;&nbsp;ออกให้ตลอดไป&nbsp;&nbsp;</span></DIV>

<DIV style="left:154PX;top:715PX;width:95PX;height:19PX;"><span class="fc1-8">&nbsp;&nbsp;ออกให้ครั้งเดียว&nbsp;&nbsp;&nbsp;</span></DIV>

<DIV style="left:266PX;top:678PX;width:67PX;height:19PX;"><span class="fc1-8">กรอก&nbsp;&nbsp;1&nbsp;&nbsp;&nbsp;</span></DIV>

<DIV style="left:266PX;top:697PX;width:67PX;height:19PX;"><span class="fc1-8">กรอก&nbsp;&nbsp;2&nbsp;&nbsp;&nbsp;</span></DIV>

<DIV style="left:266PX;top:715PX;width:67PX;height:19PX;"><span class="fc1-8">กรอก&nbsp;&nbsp;3&nbsp;&nbsp;&nbsp;</span></DIV>

<DIV style="left:738PX;top:719PX;width:263PX;height:23PX;TEXT-ALIGN:CENTER;"><span class="fc1-8">ยื่นวันที่............เดือน...............................พ .ศ..................</span></DIV>

<DIV style="left:738PX;top:700PX;width:263PX;height:19PX;TEXT-ALIGN:CENTER;"><span class="fc1-8">ตำแหน่ง ..........................................................................</span></DIV>

<DIV style="left:760PX;top:681PX;width:263PX;height:19PX;"><span class="fc1-8">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;( ............................................................... )</span></DIV>

<DIV style="left:738PX;top:662PX;width:263PX;height:19PX;TEXT-ALIGN:CENTER;"><span class="fc1-8">ลงชื่อ .................................................................ผู้จ่ายเงิน</span></DIV>

<DIV style="left: 735px; top: 602PX; width: 121px; height: 24PX; TEXT-ALIGN: RIGHT;"><span class="fc1-8"><?= check_page($current_page_index, $total_page, number_format($t_amt,2,'.',',')) ?></span></DIV>
<DIV style="left: 871px; top: 602PX; width: 115px; height: 22PX; TEXT-ALIGN: RIGHT;"><span class="fc1-8"><?= check_page($current_page_index, $total_page, number_format($v_amt,2,'.',',')) ?></span></DIV>

<DIV style="left:635PX;top:667PX;width:42PX;height:42PX;TEXT-ALIGN:CENTER;"><img  WIDTH=42 HEIGHT=42 SRC="<?= base_url('assets/images/icons/seal.jpg') ?>"></DIV>
<DIV style="left: 596px; top: 601px; width: 123PX; height: 19PX; TEXT-ALIGN: RIGHT;"><span class="fc1-8">ยอดรวมทั้งหมด</span></DIV>

<DIV style="left:143PX;top:684PX;width:11PX;height:12PX;TEXT-ALIGN:CENTER;"><span class="fc1-13">n&nbsp;</span></DIV>

<DIV style="left:143PX;top:702PX;width:11PX;height:12PX;TEXT-ALIGN:CENTER;"><span class="fc1-13">n&nbsp;</span></DIV>

<DIV style="left:143PX;top:721PX;width:11PX;height:12PX;TEXT-ALIGN:CENTER;"><span class="fc1-13">n&nbsp;</span></DIV>
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