<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rwht_docket extends CI_Controller {
    public $query;
    public $strSQL;
	function __construct()
	{
		parent::__construct();

		$this->load->model('convert_amount','',TRUE);
	}
	
	function index()
	{

		//$balwr = $this->input->get('balwr');
		$comid = XUMS::COMPANY_ID();
		$strSQL="";//echo $comid;
		$strSQL= " select tbl_comp.* from tbl_comp where tbl_comp.comid = '".$comid."'";
		$q_com = $this->db->query($strSQL);
		
		if($q_com->num_rows()>0){
		$r_com = $q_com->first_row('array');
		
		$invnr =	$this->input->get('invnr');
		$copies =	$this->input->get('copies');
		//echo $invnr;
		//$no = $type = $this->uri->segment(4);
		//$copies = intval($type = $this->uri->segment(5));
		//$month = explode('-',$date);
		//$dt_result = util_helper_get_sql_between_month($date);
		//$text_month = $this->convert_amount->text_month($month[1]);
		
		$taxid = str_split($r_com['taxid']);
		
		if($copies<=0) $copies = 1;
	
		//Purchase
		$strSQL = " select v_ebrk.*,v_ebrp.*";
        $strSQL = $strSQL . " from v_ebrk ";
        $strSQL = $strSQL . " left join v_ebrp on v_ebrk.invnr = v_ebrp.invnr ";
        $strSQL = $strSQL . " Where v_ebrk.invnr = '".$invnr."'";
		$strSQL .= "ORDER BY vbelp ASC";
       
		$query = $this->db->query($strSQL);
		if($query->num_rows()>0){
		$r_data = $query->first_row('array');
		
		$cusid = str_split($r_data['taxid']);
		// calculate sum
		//$result = array();
		
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
.fc1-0 { COLOR:000000;FONT-SIZE:10PT;FONT-WEIGHT:NORMAL;}
.fc1-1 { COLOR:000000;FONT-SIZE:11PT;FONT-WEIGHT:NORMAL;}
.fc1-2 { COLOR:000000;FONT-SIZE:13PT;FONT-FAMILY:'angsana_newbold';}
.fc1-3 { COLOR:000000;FONT-SIZE:11PT;FONT-FAMILY:'angsana_newbold';}
.fc1-4 { COLOR:000000;FONT-SIZE:9PT;FONT-WEIGHT:NORMAL;}
.fc1-5 { COLOR:000000;FONT-SIZE:10PT;FONT-WEIGHT:NORMAL;}
.fc1-6 { COLOR:000000;FONT-SIZE:11PT;'angsana_newbold';}
.fc1-7 { COLOR:000000;FONT-SIZE:9PT;FONT-WEIGHT:NORMAL;}
.ad1-0 {border-color:000000;border-style:none;border-bottom-width:0PX;border-left-width:0PX;border-top-width:0PX;border-right-width:0PX;}
.ad1-1 {border-color:000000;border-style:none;border-bottom-width:0PX;border-left-width:0PX;border-top-width:0PX;border-right-width:0PX;}
.ad1-2 {border-color:000000;border-style:none;border-bottom-width:0PX;border-left-style:solid;border-left-width:1PX;border-top-width:0PX;border-right-width:0PX;}
.ad1-3 {border-color:000000;border-style:none;border-bottom-width:0PX;border-left-width:0PX;border-top-style:solid;border-top-width:1PX;border-right-width:0PX;}
.ad1-4 {border-color:000000;border-style:none;border-bottom-width:0PX;border-left-style:solid;border-left-width:1PX;border-top-width:0PX;border-right-width:0PX;}
.ad1-5 {border-color:000000;border-style:none;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;}
.ad1-6 {border-color:000000;border-style:none;border-bottom-style:solid;border-bottom-width:1PX;border-left-style:solid;border-left-width:1PX;border-top-style:solid;border-top-width:1PX;border-right-style:solid;border-right-width:1PX;}
</STYLE>

<TITLE>Crystal Report Viewer</TITLE>
<BODY BGCOLOR="FFFFFF"LEFTMARGIN=0 TOPMARGIN=0 BOTTOMMARGIN=0 RIGHTMARGIN=0>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<DIV style="z-index:0"> &nbsp; </div>

<div style="left:649PX;top:326PX;border-color:000000;border-style:solid;border-width:0px;border-left-width:1PX;height:455PX;">
<table width="0px" height="449PX"><td>&nbsp;</td></table>
</div>
<div style="left:539PX;top:326PX;border-color:000000;border-style:solid;border-width:0px;border-left-width:1PX;height:455PX;">
<table width="0px" height="449PX"><td>&nbsp;</td></table>
</div>
<div style="left:436PX;top:326PX;border-color:000000;border-style:solid;border-width:0px;border-left-width:1PX;height:429PX;">
<table width="0px" height="423PX"><td>&nbsp;</td></table>
</div>
<div style="left:34PX;top:365PX;border-color:000000;border-style:solid;border-width:0px;border-top-width:1PX;width:704PX;">
</div>
<div style="left:628PX;top:365PX;border-color:000000;border-style:solid;border-width:0px;border-left-width:1PX;height:416PX;">
<table width="0px" height="410PX"><td>&nbsp;</td></table>
</div>
<div style="left:714PX;top:365PX;border-color:000000;border-style:solid;border-width:0px;border-left-width:1PX;height:416PX;">
<table width="0px" height="410PX"><td>&nbsp;</td></table>
</div>
<div style="left:34PX;top:810PX;border-color:000000;border-style:solid;border-width:0px;border-top-width:1PX;width:703PX;">
</div>
<div style="left:34PX;top:878PX;border-color:000000;border-style:solid;border-width:0px;border-top-width:1PX;width:703PX;">
</div>
<div style="left:331PX;top:878PX;border-color:000000;border-style:solid;border-width:0px;border-left-width:1PX;height:75PX;">
<table width="0px" height="69PX"><td>&nbsp;</td></table>
</div>
<div style="left:539PX;top:780PX;border-color:000000;border-style:solid;border-width:0px;border-top-width:1PX;width:198PX;">
</div>
<div style="left:34PX;top:754PX;border-color:000000;border-style:solid;border-width:0px;border-top-width:1PX;width:703PX;">
</div>
<div style="left: 34PX; top: 196px; border-color: 000000; border-style: solid; border-width: 0px; border-top-width: 1PX; width: 704PX;">
</div>
<div style="left:34PX;top:281PX;border-color:000000;border-style:solid;border-width:0px;border-top-width:1PX;width:704PX;">
</div>
<div style="left:34PX;top:326PX;border-color:000000;border-style:solid;border-width:0px;border-top-width:1PX;width:704PX;">
</div>

<DIV class="box" style="z-index: 10; border-color: 000000; border-style: solid; border-bottom-style: solid; border-bottom-width: 1PX; border-left-style: solid; border-left-width: 1PX; border-top-style: solid; border-top-width: 1PX; border-right-style: solid; border-right-width: 1PX; left: 34PX; top: 121px; width: 702PX; height: 851px;">
<table border=0 cellpadding=0 cellspacing=0 width=696px height=862px><TD>&nbsp;</TD></TABLE>
</DIV>

<DIV style="left:40PX;top:21PX;width:540PX;height:20PX;"><span class="fc1-0">ฉบับที่ 1 (สำหรับผู้ถูกหักภาษี ณ ที่จ่าย ใช้แนบพร้อมกับแบบแสดงรายการภาษี)</span></DIV>

<DIV style="left: 40PX; top: 42px; width: 540PX; height: 20PX;"><span class="fc1-0">ฉบับที่ 2 (สำหรับผู้ถูกหักภาษี ณ ที่จ่าย เก็บไว้เป็นหลักฐาน)</span></DIV>

<DIV style="left: 40px; top: 95px; width: 34PX; height: 22PX;"><span class="fc1-1">&nbsp;&nbsp;&nbsp;เล่มที่ </span></DIV>

<DIV style="left: 226px; top: 90px; width: 332px; height: 26PX; TEXT-ALIGN: CENTER;"><span class="fc1-2"> ตามมาตรา 50 ทวิ แห่งประมวลรัษฎากร </span></DIV>

<DIV style="left: 226px; top: 62px; width: 330px; height: 26PX; TEXT-ALIGN: CENTER;"><span class="fc1-2">หนังสือรับรองการหักภาษี ณ ที่จ่าย </span></DIV>

<DIV style="left: 620PX; top: 67px; width: 49PX; height: 22PX; TEXT-ALIGN: RIGHT;"><span class="fc1-1">เลขที่&nbsp;&nbsp;</span></DIV>

<DIV style="left:40PX;top:329PX;width:396PX;height:36PX;TEXT-ALIGN:CENTER;"><span class="fc1-1">ประเภทเงินได้พึงประเมินที่จ่าย</span></DIV>

<DIV style="left:436PX;top:329PX;width:104PX;height:30PX;TEXT-ALIGN:CENTER;">
<span class="fc1-1">วัน เดือน </span>
</DIV>

<DIV style="left: 437px; top: 346px; width: 104PX; height: 30PX; TEXT-ALIGN: CENTER;">
<span class="fc1-1">หรือปีภาษี ที่จ่าย</span>
</DIV>

<DIV style="left:539PX;top:329PX;width:110PX;height:36PX;TEXT-ALIGN:CENTER;"><span class="fc1-1">จำนวนเงินที่จ่าย</span></DIV>

<DIV style="left:332PX;top:757PX;width:186PX;height:23PX;TEXT-ALIGN:RIGHT;"><span class="fc1-3">รวมเงินที่จ่ายและภาษีที่หักนำส่ง</span></DIV>

<DIV style="left:40PX;top:786PX;width:159PX;height:21PX;"><span class="fc1-3">รวมเงินภาษีที่หักนำส่ง (ตัวอักษร)</span></DIV>

<DIV style="left:40PX;top:813PX;width:101PX;height:22PX;"><span class="fc1-1">เลขที่นายจ้าง</span></DIV>

<DIV style="left:332PX;top:813PX;width:208PX;height:22PX;"><span class="fc1-1">เลขที่บัตรประกันสังคมของผู้ถูกหักภาษี ณ ที่จ่าย</span></DIV>

<DIV style="left:40PX;top:881PX;width:51PX;height:22PX;"><span class="fc1-3">ผู้จ่ายเงิน</span></DIV>

<DIV style="left:340PX;top:881PX;width:327PX;height:22PX;"><span class="fc1-1">ขอรับรองว่า ข้อความและตัวเลขข้างต้นถูกต้องตรงกับความจริงทุกประการ</span></DIV>

<DIV style="left:340PX;top:908PX;width:328PX;height:26PX;TEXT-ALIGN:CENTER;"><span class="fc1-1">ลงชื่อ&nbsp;&nbsp;.......................................................&nbsp;&nbsp;&nbsp;ผู้มีหน้าที่หักภาษี ณ ที่จ่าย&nbsp;&nbsp;</span></DIV>

<DIV style="left:674PX;top:899PX;width:52PX;height:44PX;TEXT-ALIGN:CENTER;">
<img  WIDTH=42 HEIGHT=42 SRC="<?= base_url('assets/images/icons/seal.jpg') ?>">
</DIV>

<DIV style="left:493PX;top:926PX;width:156PX;height:21PX;"><span class="fc1-1">วันเดือนปี ที่ออกหนังสือรับรอง</span></DIV>

<DIV style="left: 40PX; top: 654px; width: 396PX; height: 21PX;">
<span class="fc1-1">5. การจ่ายเงินได้ที่ต้องหักภาษี ณ ที่จ่าย ตามคำสั่งกรมสรรพากร ที่ออกตาม</span>
</DIV>

<DIV style="left: 40PX; top: 672px; width: 396PX; height: 21PX;">
<span class="fc1-1">&nbsp;&nbsp;&nbsp;&nbsp;มาตรา 3 เตรส&nbsp;&nbsp;(ระบุ) </span>
</DIV>

<DIV style="left: 40PX; top: 692px; width: 396PX; height: 15PX;">
<span class="fc1-4">&nbsp;&nbsp;&nbsp;&nbsp;(เช่น รางวัล ส่วนลดหรือประโยชน์ใดๆ เนื่องจากการส่งเสริมการขาย รางวัล</span>
</DIV>

<DIV style="left: 40PX; top: 706px; width: 396PX; height: 15PX;">
<span class="fc1-4">&nbsp;&nbsp;&nbsp;&nbsp;ในการประกวด การแข่งขัน การชิงโชค ค่าแสดงของนักแสดงสาธารณะ ค่าจ้างทำของ</span>
</DIV>

<DIV style="left: 40PX; top: 720px; width: 396PX; height: 15PX;">
<span class="fc1-4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ค่าโฆษณา ค่าเช่า ค่าขนส่ง ค่าบริการ ค่าเบี้ยประกันวินาศภัย ฯลฯ)</span>
</DIV>

<DIV style="left:40PX;top:857PX;width:277PX;height:22PX;"><span class="fc1-1">เงินสะสมจ่ายเข้ากองทุนสำรองเลี้ยงชีพ ใบอนุญาตเลขที่&nbsp;&nbsp;</span></DIV>

<DIV style="left:40PX;top:365PX;width:396PX;height:22PX;"><span class="fc1-1">1. เงินเดือน ค่าจ้าง เบี้ยเลี้ยง โบนัส ฯลฯ ตามมาตรา 40 (1)</span></DIV>

<DIV style="left:40PX;top:384PX;width:396PX;height:22PX;"><span class="fc1-1">2. ค่าธรรมเนียม ค่านายหน้า ฯลฯ ตามมาตรา 40 (2)</span></DIV>

<DIV style="left:40PX;top:403PX;width:396PX;height:22PX;"><span class="fc1-1">3. ค่าแห่งลิขสิทธิ ฯลฯ ตามมาตรา 40 (3)</span></DIV>

<DIV style="left:40PX;top:422PX;width:396PX;height:22PX;"><span class="fc1-1">4. (ก) ค่าดอกเบี้ย&nbsp;&nbsp;ฯลฯ ตามมาตรา 40 (4) ก</span></DIV>

<DIV style="left: 40PX; top: 735px; width: 396PX; height: 24PX;"><span class="fc1-1">6. อื่น ๆ (ระบุ)&nbsp;&nbsp;.........................................................................</span></DIV>

<DIV style="left: 112px; top: 731px; width: 276px; height: 24PX;"><span class="fc1-1"><? if($r_data['whtgp']=='6') echo $r_data['whtxt']; ?></span></DIV>

<DIV style="left:455PX;top:857PX;width:85PX;height:21PX;"><span class="fc1-1">จำนวนเงิน </span></DIV>

<DIV style="left: 697PX; top: 831px; width: 29PX; height: 23PX; TEXT-ALIGN: RIGHT;"><span class="fc1-1">บาท</span></DIV>

<DIV style="left: 697PX; top: 854px; width: 29PX; height: 23PX; TEXT-ALIGN: RIGHT;"><span class="fc1-1">บาท</span></DIV>

<DIV style="left:40PX;top:835PX;width:196PX;height:22PX;">
<table width="191PX" border=0 cellpadding=0 cellspacing=0>
<tr><td class="fc1-1">เงินสมทบจ่ายเข้ากองทุนประกันสังคม&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr></table>
</DIV>

<DIV style="left:454PX;top:835PX;width:85PX;height:22PX;"><span class="fc1-1">จำนวนเงิน </span></DIV>

<DIV style="left:34PX;top:956PX;width:702PX;height:18PX;"><span class="fc1-5">&nbsp;&nbsp;&nbsp;หมายเหตุ : ให้สามารถอ้างอิงหรือสอบยันกันได้ระหว่างแบบแสดงรายการนำส่งภาษีกับหนังสือรับรองการหัก ภาษี ณ ที่จ่าย&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></DIV>

<DIV style="left: 41px; top: 148px; width: 32PX; height: 22PX;"><span class="fc1-3">ชื่อ</span></DIV>

<DIV style="left: 41px; top: 174px; width: 32PX; height: 22PX;"><span class="fc1-3">ที่อยู่</span></DIV>

<DIV style="left: 453px; top: 150px; width: 125PX; height: 20PX;"><span class="fc1-1">เลขประจำตัวผู้เสียภาษีอากร </span></DIV>




<DIV style="left: 40PX; top: 228px; width: 32PX; height: 22PX;"><span class="fc1-3">ชื่อ</span></DIV>

<DIV style="left:40PX;top:255PX;width:32PX;height:22PX;"><span class="fc1-3">ที่อยู่</span></DIV>

<DIV style="left:216PX;top:284PX;width:95PX;height:22PX;"><span class="fc1-1">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)&nbsp;&nbsp;ภ.ง.ด. 1 ก&nbsp;&nbsp;&nbsp;&nbsp;</span></DIV>

<DIV style="left:40PX;top:284PX;width:43PX;height:22PX;"><span class="fc1-1">ลำดับที่</span></DIV>

<DIV style="left:154PX;top:284PX;width:50PX;height:22PX;"><span class="fc1-1"> ในแบบ&nbsp;&nbsp;&nbsp;&nbsp;</span></DIV>

<DIV style="left:40PX;top:440PX;width:396PX;height:22PX;"><span class="fc1-1">&nbsp;&nbsp;&nbsp;&nbsp;(ข) เงินปันผล เงินส่วนแบ่งกำไร ฯลฯ ตามมาตรา 40 (4) (ข)</span></DIV>

<DIV style="left:66PX;top:458PX;width:369PX;height:17PX;"><span class="fc1-1">(1)&nbsp;&nbsp;&nbsp;กรณีผู้ได้รับเงินปันผลได้รับเครดิตภาษี โดยจ่ายจาก</span></DIV>

<DIV style="left:86PX;top:492PX;width:261PX;height:15PX;"><span class="fc1-4">(1.1) อัตราร้อยละ 30 ของกำไรสุทธิ&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></DIV>

<DIV style="left:86PX;top:507PX;width:261PX;height:15PX;"><span class="fc1-4">(1.2)&nbsp;&nbsp;อัตราร้อยละ 25 ของกำไรสุทธิ&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></DIV>

<DIV style="left:86PX;top:522PX;width:261PX;height:15PX;"><span class="fc1-4">(1.3) อัตราร้อยละ 20 ของกำไรสุทธิ&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></DIV>

<DIV style="left:86PX;top:537PX;width:262PX;height:15PX;"><span class="fc1-4">(1.4)&nbsp;&nbsp;อัตราอื่นๆ(ระบุ).................................................... ของกำไรสุทธิ&nbsp;&nbsp;&nbsp;&nbsp;</span></DIV>

<DIV style="left:34PX;top:974PX;width:702PX;height:18PX;"><span class="fc1-5">&nbsp;&nbsp;&nbsp;คำเตือน&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ผู้มีหน้าที่ออกหนังสือรับรองการหักภาษี ณ ที่จ่าย ฝ่าฝืนไม่ปฎิบัติตามมาตรา 50 ทวิ แห่งประมวลรัษฎากร ต้องรับโทษทางอาญามาตรา 35 แห่งประมวลรัษฎากร</span></DIV>

<DIV style="left:34PX;top:992PX;width:702PX;height:18PX;"><span class="fc1-5">&nbsp;&nbsp;&nbsp;ฉบับที่ 1 สำหรับผู้ถูกหัก ณ ที่จ่ายแนบพร้อมแบบแสดงรายงานภาษี&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ฉบับที่ 2&nbsp;&nbsp;สำหรับผู้ถูกหักภาษี&nbsp;&nbsp;ณ&nbsp;&nbsp;ที่จ่าย&nbsp;&nbsp;เก็บไว้เป็นหลักฐาน</span></DIV>

<DIV style="left: 75px; top: 95px; width: 58PX; height: 24PX;"><span class="fc1-3">1</span></DIV>

<DIV style="left: 673px; top: 66px; width: 62PX; height: 26PX; TEXT-ALIGN: CENTER;"><span class="fc1-3">0003</span></DIV>

<DIV style="left: 496px; top: 127px; width: 191PX; height: 18PX; TEXT-ALIGN: RIGHT;"><img  WIDTH=235 HEIGHT=20 SRC="<?= base_url('assets/images/icons/pp02.jpg') ?>"></DIV>

<DIV style="left: 495px; top: 204px; width: 191PX; height: 18PX; TEXT-ALIGN: RIGHT;"><img  WIDTH=235 HEIGHT=20 SRC="<?= base_url('assets/images/icons/pp02.jpg') ?>"></DIV>

<DIV style="left:498PX;top:123PX;width:14PX;height:20PX;TEXT-ALIGN:CENTER;"><span class="fc1-2"><?= $taxid[0];?></span></DIV>

<DIV style="left: 520px; top: 123PX; width: 14PX; height: 20PX; TEXT-ALIGN: CENTER;"><span class="fc1-2"><?= $taxid[1];?></span></DIV>

<DIV style="left: 535px; top: 123PX; width: 14px; height: 20PX; TEXT-ALIGN: CENTER;"><span class="fc1-2"><?= $taxid[2];?></span></DIV>

<DIV style="left: 551px; top: 123PX; width: 14px; height: 20PX; TEXT-ALIGN: CENTER;"><span class="fc1-2"><?= $taxid[3];?></span></DIV>

<DIV style="left: 567px; top: 123PX; width: 14px; height: 20PX; TEXT-ALIGN: CENTER;"><span class="fc1-2"><?= $taxid[4];?></span></DIV>

<DIV style="left: 589px; top: 123PX; width: 14px; height: 20PX; TEXT-ALIGN: CENTER;"><span class="fc1-2"><?= $taxid[5];?></span></DIV>

<DIV style="left: 605px; top: 123PX; width: 14px; height: 20PX; TEXT-ALIGN: CENTER;"><span class="fc1-2"><?= $taxid[6];?></span></DIV>

<DIV style="left: 622px; top: 123PX; width: 14px; height: 20PX; TEXT-ALIGN: CENTER;"><span class="fc1-2"><?= $taxid[7];?></span></DIV>

<DIV style="left: 636px; top: 123PX; width: 14px; height: 20PX; TEXT-ALIGN: CENTER;"><span class="fc1-2"><?= $taxid[8];?></span></DIV>

<DIV style="left: 653px; top: 123PX; width: 14px; height: 20PX; TEXT-ALIGN: CENTER;"><span class="fc1-2"><?= $taxid[9];?></span></DIV>

<DIV style="left:665PX;top:123PX;width:36PX;height:20PX;TEXT-ALIGN:CENTER;"><span class="fc1-2"><?= $taxid[10];?></span></DIV>

<DIV style="left:693PX;top:123PX;width:16PX;height:20PX;TEXT-ALIGN:CENTER;"><span class="fc1-2"><?= $taxid[11];?></span></DIV>

<DIV style="left:716PX;top:122PX;width:16PX;height:20PX;TEXT-ALIGN:CENTER;"><span class="fc1-2"><?= $taxid[12];?></span></DIV>

<DIV style="left: 76px; top: 150px; width: 364PX; height: 20PX;"><span class="fc1-3"><?= $r_com['name1']; ?></span></DIV>

<DIV style="left:72PX;top:255PX;width:640PX;height:22PX;"><span class="fc1-3"><?=$r_data['adr01'];?>&nbsp;<?=$r_data['distx'];?>&nbsp;&nbsp;<?=$r_data['pstlz'];?></span></DIV>

<DIV style="left: 76px; top: 174px; width: 659PX; height: 22PX;"><span class="fc1-3"><?=$r_com['adr01'];?>&nbsp;<?=$r_com['distx'];?>&nbsp;&nbsp;<?=$r_com['pstlz'];?></span></DIV>

<DIV style="left: 72PX; top: 228px; width: 379px; height: 22PX;"><span class="fc1-3"><?=$r_data['name1'];?></span></DIV>

<DIV style="left:498PX;top:200PX;width:14PX;height:20PX;TEXT-ALIGN:CENTER;"><span class="fc1-2"><?= $cusid[0];?></span></DIV>

<DIV style="left: 520px; top: 200PX; width: 14PX; height: 20PX; TEXT-ALIGN: CENTER;"><span class="fc1-2"><?= $cusid[1];?></span></DIV>

<DIV style="left: 535px; top: 200PX; width: 14px; height: 20PX; TEXT-ALIGN: CENTER;"><span class="fc1-2"><?= $cusid[2];?></span></DIV>

<DIV style="left: 551px; top: 200PX; width: 14px; height: 20PX; TEXT-ALIGN: CENTER;"><span class="fc1-2"><?= $cusid[3];?></span></DIV>

<DIV style="left: 567px; top: 200PX; width: 14px; height: 20PX; TEXT-ALIGN: CENTER;"><span class="fc1-2"><?= $cusid[4];?></span></DIV>

<DIV style="left: 589px; top: 200PX; width: 14px; height: 20PX; TEXT-ALIGN: CENTER;"><span class="fc1-2"><?= $cusid[5];?></span></DIV>

<DIV style="left: 605px; top: 200PX; width: 14px; height: 20PX; TEXT-ALIGN: CENTER;"><span class="fc1-2"><?= $cusid[6];?></span></DIV>

<DIV style="left: 622px; top: 200PX; width: 14px; height: 20PX; TEXT-ALIGN: CENTER;"><span class="fc1-2"><?= $cusid[7];?></span></DIV>

<DIV style="left: 636px; top: 200PX; width: 14px; height: 20PX; TEXT-ALIGN: CENTER;"><span class="fc1-2"><?= $cusid[8];?></span></DIV>

<DIV style="left: 653px; top: 200PX; width: 14px; height: 20PX; TEXT-ALIGN: CENTER;"><span class="fc1-2"><?= $cusid[9];?></span></DIV>

<DIV style="left:665PX;top:200PX;width:36PX;height:20PX;TEXT-ALIGN:CENTER;"><span class="fc1-2"><?= $cusid[10];?></span></DIV>

<DIV style="left:693PX;top:200PX;width:16PX;height:20PX;TEXT-ALIGN:CENTER;"><span class="fc1-2"><?= $cusid[11];?></span></DIV>

<DIV style="left:716PX;top:200PX;width:16PX;height:20PX;TEXT-ALIGN:CENTER;"><span class="fc1-2"><?= $cusid[12];?></span></DIV>

<DIV style="left:72PX;top:904PX;width:257PX;height:22PX;"><span class="fc1-1">(X)&nbsp;&nbsp;หักภาษี ณ ที่จ่าย&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(&nbsp;&nbsp;)&nbsp;&nbsp;ออกภาษีให้ตลอดไป</span></DIV>

<DIV style="left:72PX;top:926PX;width:257PX;height:21PX;"><span class="fc1-1">(&nbsp;&nbsp;)&nbsp;&nbsp;ออกภาษีให้ครั้งเดียว&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(&nbsp;&nbsp;)&nbsp;&nbsp;อื่นๆ (ให้ระบุ) ...............</span></DIV>

<?php
$t_beamt=0;$t_wht=0;$posit=0; 
$t1_beamt=0;$t1_wht=0;
$t2_beamt=0;$t2_wht=0;
$t3_beamt=0;$t3_wht=0;
$t4_beamt=0;$t4_wht=0;
$t5_beamt=0;$t5_wht=0;
$t6_beamt=0;$t6_wht=0;
$tt_beamt=0;$tt_wht=0;
$bldat_str = util_helper_format_date($r_data['bldat']); 
//$whtnr = $r_data['whtgp'];
$t_beamt=$r_data['beamt'];
$t_wht=$r_data['wht01'];
/*switch($whtnr){
  	case '1': $posit=365;break;
	case '2': $posit=384;break;
	case '3': $posit=403;break;
	case '4': $posit=422;break;
	case '5': $posit=646;break;
	case '6': $posit=734;break;
}*/

        $rows = $query->result_array();
		$b_amt = 0;
		$v_amt = 0;$i=0;
		$result = array();
		
		foreach ($rows as $key => $item) {
			$itamt = 0;
			$strSQL="";
		$strSQL= " select tbl_whty.* from tbl_whty where tbl_whty.whtnr = '".$item['whtnr']."'";
		$q_wht = $this->db->query($strSQL);
		 
		if($q_wht->num_rows()>0){
			$q_data = $q_wht->first_row('array');
			switch($q_data['whtgp']){
  	          case '1':  $t1_beamt+=$item['itamt'];
			             $t1_wht+=$item['itamt'] * $q_data['whtpr'] / 100;
			  break;
			  case '2': $t2_beamt+=$item['itamt'];
			             $t2_wht+=$item['itamt'] * $q_data['whtpr'] / 100;
							break;
			  case '3': $t3_beamt+= $item['itamt'];
			             $t3_wht+=$item['itamt'] * $q_data['whtpr'] / 100;
							break;
			  case '4': $t4_beamt+=$item['itamt'];
			             $t4_wht+=$item['itamt'] * $q_data['whtpr'] / 100;

							break;
			  case '5': $t5_beamt+= $item['itamt'];
			             $t5_wht+=$item['itamt'] * $q_data['whtpr'] / 100;

							break;
			  case '6': $t6_beamt+=$item['itamt'];
			             $t6_wht+=$item['itamt'] * $q_data['whtpr'] / 100;
							break;
             }
			 $i++;
		}
		}

        //echo 'aaa'.$t3_beamt.'bbb'.$t5_beamt;
		foreach ($rows as $key => $item) {
			$itamt = 0;
			$strSQL="";
		$strSQL= " select tbl_whty.* from tbl_whty where tbl_whty.whtnr = '".$item['whtnr']."'";
		$q_wht = $this->db->query($strSQL);
	
		if($q_wht->num_rows()>0){
			$q_data = $q_wht->first_row('array');
			switch($q_data['whtgp']){
  	          case '1': $posit=365;
			            $tt_beamt=$t1_beamt;
						$tt_wht=$t1_wht;
						break;
			  case '2': $posit=384;
			            $tt_beamt=$t2_beamt;
						$tt_wht=$t3_wht;break;
			  case '3': $posit=403;
			            $tt_beamt=$t3_beamt;
						$tt_wht=$t3_wht;break;
			  case '4': $posit=422;
			            $tt_beamt=$t4_beamt;
						$tt_wht=$t4_wht;break;
			  case '5': $posit=646;
			            $tt_beamt=$t5_beamt;
						$tt_wht=$t5_wht;break;
			  case '6': $posit=734;
			            $tt_beamt=$t6_beamt;
						$tt_wht=$t6_wht;break;
             }
?>

<DIV style="left:436PX;top:<?= $posit;?>PX;width:104PX;height:24PX;TEXT-ALIGN:CENTER;"><span class="fc1-1"><?= $bldat_str;?></span></DIV>

<DIV style="left: 539PX; top: <?= $posit;?>PX; width: 100px; height: 24PX; TEXT-ALIGN: RIGHT;"><span class="fc1-1"><?= number_format($tt_beamt,2,'.',',');?></span></DIV>
<DIV style="left: 649PX; top: <?= $posit;?>PX; width: 76px; height: 24PX; TEXT-ALIGN: RIGHT;"><span class="fc1-1"><?= number_format($tt_wht,2,'.',',');?></span></DIV>

<?php }} ?>

<DIV style="left: 649PX; top: 757PX; width: 76px; height: 23PX; TEXT-ALIGN: RIGHT;"><span class="fc1-3"><?= number_format($t_wht,2,'.',',');?></span></DIV>
<DIV style="left: 539PX; top: 757PX; width: 100px; height: 23PX; TEXT-ALIGN: RIGHT;"><span class="fc1-3"><?= number_format($t_beamt,2,'.',',');?></span></DIV>
<DIV style="left:139PX;top:813PX;width:153PX;height:22PX;"><span class="fc1-1">&nbsp;&nbsp;</span></DIV>

<?php
  $text_amt='';
  if($t_wht>0){
     $text_amt = $this->convert_amount->generate($t_wht);
  }
?>

<DIV style="left:216PX;top:783PX;width:466PX;height:24PX;background-color:D6D7D8;layer-background-color:D6D7D8;">
<table width="461PX" border=0 cellpadding=0 cellspacing=0><td class="fc1-2">&nbsp;&nbsp;<?php 
if(!empty($text_amt)) echo '( '.$text_amt.' )' ?></td></table>
</DIV>

<DIV style="left:216PX;top:303PX;width:95PX;height:22PX;"><span class="fc1-1">(&nbsp;&nbsp;<? if($r_data['vtype']=='02') echo 'X'; else echo ' ';?>&nbsp;&nbsp;)&nbsp;&nbsp;&nbsp;ภ.ง.ด. 3 </span></DIV>

<DIV style="left:436PX;top:303PX;width:137PX;height:22PX;"><span class="fc1-1">(&nbsp;&nbsp;<? if($r_data['vtype']=='01') echo 'X'; else echo ' ';?>&nbsp;&nbsp;)&nbsp;&nbsp;&nbsp;ภ.ง.ด. 53 </span></DIV>

<DIV style="left:311PX;top:303PX;width:92PX;height:23PX;"><span class="fc1-1">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)&nbsp;&nbsp;ภ.ง.ด. 3 ก </span></DIV>

<DIV style="left:436PX;top:284PX;width:276PX;height:22PX;"><span class="fc1-1">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)&nbsp;&nbsp;&nbsp;ภ.ง.ด. 2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)&nbsp;&nbsp;ภ.ง.ด. 2 ก&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></DIV>

<DIV style="left:311PX;top:284PX;width:125PX;height:22PX;"><span class="fc1-1">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)&nbsp;&nbsp;ภ.ง.ด. 1 ก (พิเศษ)&nbsp;&nbsp;&nbsp;</span></DIV>

<DIV style="left:649PX;top:329PX;width:85PX;height:30PX;TEXT-ALIGN:CENTER;">
<span class="fc1-1">ภาษีที่หัก</span>
</DIV>

<DIV style="left: 650px; top: 344px; width: 85PX; height: 30PX; TEXT-ALIGN: CENTER;">
<span class="fc1-1">และนำส่งไว้</span>
</DIV>

<DIV style="left: 41px; top: 126px; width: 140PX; height: 20PX;"><span class="fc1-6">ผู้มีหน้าที่หักภาษี ณ ที่จ่าย&nbsp;&nbsp;:- </span></DIV>

<DIV style="left: 333px; top: 125px; width: 156px; height: 23PX;"><span class="fc1-1">เลขประจำตัวผู้เสียภาษีอากร (13 หลัก)</span></DIV>


<DIV style="left: 457px; top: 229px; width: 125PX; height: 22PX;"><span class="fc1-1">เลขประจำตัวผู้เสียภาษีอากร </span></DIV>

<DIV style="left: 40PX; top: 203px; width: 140PX; height: 21PX;"><span class="fc1-6">ผู้ถูกหักภาษี ณ ที่จ่าย&nbsp;&nbsp;:- </span></DIV>

<DIV style="left:66PX;top:475PX;width:369PX;height:17PX;"><span class="fc1-1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;กำไรสุทธิของกิจการที่ต้องเสียภาษีเงินได้นิติบุคคลในอัตราดังนี้</span></DIV>

<DIV style="left:66PX;top:552PX;width:369PX;height:18PX;"><span class="fc1-1">(2)&nbsp;&nbsp;&nbsp;กรณีผู้ได้รับเงินปันผลไม่ได้รับเครดิตภาษี เนื่องจากจ่ายจาก</span></DIV>

<DIV style="left:86PX;top:570PX;width:262PX;height:16PX;"><span class="fc1-4">(2.1) กำไรสุทธิของกิจการที่ได้รับยกเว้นภาษีเงินได้นิติบุคคล</span></DIV>

<DIV style="left:86PX;top:586PX;width:349PX;height:30PX;">
<table width="344PX" border=0 cellpadding=0 cellspacing=0><td class="fc1-4">(2.2) เงินปันผลหรือเงินส่วนแบ่งของกำไรที่ได้รับยกเว้นไม่ต้องนำมารวม</td></table>

<table width="344PX" border=0 cellpadding=0 cellspacing=0><td class="fc1-4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;คำนวณเป็นรายได้เพื่อเสียภาษีเงินได้นิติบุคคล&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></table>
</DIV>

<DIV style="left:86PX;top:616PX;width:349PX;height:15PX;"><span class="fc1-4">(2.3) กำไรสุทธิส่วนที่ได้หักผลขาดทุนสุทธิยกมาไม่เกิน 5 ปี ก่อนรอบระยะเวลาบัญชีปีปัจจุบัน</span></DIV>

<DIV style="left:86PX;top:631PX;width:349PX;height:15PX;"><span class="fc1-4">(2.4) กำไรที่รับรู้ทางบัญชีโดยวิธิส่วนได้ส่วนเสีย (equity method)</span></DIV>

<DIV style="left: 334px; top: 204px; width: 156px; height: 20PX;"><span class="fc1-1">เลขประจำตัวผู้เสียภาษีอากร (13 หลัก)</span></DIV>

<BR>
</BODY></HTML>

<?php
	  }
	}
  }
}

?>