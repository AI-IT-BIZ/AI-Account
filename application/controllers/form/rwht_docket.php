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
		//$dt_str = '2013-02-22';
		//echo $dt_result;
		
		//$balwr = $this->input->get('balwr');
		$date =	$this->input->get('bldat');
		$copies =	$this->input->get('copies');
		//$no = $type = $this->uri->segment(4);
		//$copies = intval($type = $this->uri->segment(5));
		$month = explode('-',$date);
		$dt_result = util_helper_get_sql_between_month($date);
		$text_month = $this->convert_amount->text_month($month[1]);
		
		$taxid = str_split('1234567890123');
		
		if($copies<=0) $copies = 1;
	
		//Purchase
		$strSQL="";
		$strSQL = " select v_ebbp.*";
        $strSQL = $strSQL . " from v_ebbp ";
        $strSQL = $strSQL . " Where v_ebbp.bldat ".$dt_result;
		$strSQL .= " ORDER BY payno ASC";
       
		$query = $this->db->query($strSQL);
		$r_data = $query->first_row('array');
		// calculate sum
		$rowp = $query->result_array();
		$tline = $query->num_rows();
		
		$purch_amt=0;$purch_vat=0;
		foreach ($rowp as $key => $item) {
		   $purch_amt += $item['netwr'];
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
.fc1-0 { COLOR:000000;FONT-SIZE:10PT;FONT-FAMILY:CordiaUPC;FONT-WEIGHT:NORMAL;}
.fc1-1 { COLOR:000000;FONT-SIZE:11PT;FONT-FAMILY:Angsana New;FONT-WEIGHT:NORMAL;}
.fc1-2 { COLOR:000000;FONT-SIZE:13PT;FONT-FAMILY:Angsana New;FONT-WEIGHT:BOLD;}
.fc1-3 { COLOR:000000;FONT-SIZE:11PT;FONT-FAMILY:Angsana New;FONT-WEIGHT:BOLD;}
.fc1-4 { COLOR:000000;FONT-SIZE:9PT;FONT-FAMILY:Angsana New;FONT-WEIGHT:NORMAL;}
.fc1-5 { COLOR:000000;FONT-SIZE:10PT;FONT-FAMILY:Angsana New;FONT-WEIGHT:NORMAL;}
.fc1-6 { COLOR:000000;FONT-SIZE:11PT;FONT-FAMILY:CordiaUPC;FONT-WEIGHT:BOLD;}
.fc1-7 { COLOR:000000;FONT-SIZE:9PT;FONT-FAMILY:Arial;FONT-WEIGHT:NORMAL;}
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
<table width="99PX" border=0 cellpadding=0 cellspacing=0><td ALIGN="CENTER" class="fc1-1">วัน เดือน </td></table>

<table width="99PX" border=0 cellpadding=0 cellspacing=0><td ALIGN="CENTER" class="fc1-1">หรือปีภาษี ที่จ่าย</td></table>
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

<DIV style="left:40PX;top:646PX;width:396PX;height:84PX;">
<table width="391PX" border=0 cellpadding=0 cellspacing=0><td class="fc1-1">5. การจ่ายเงินได้ที่ต้องหักภาษี ณ ที่จ่าย ตามคำสั่งกรมสรรพากร ที่ออกตาม</td></table>

<table width="391PX" border=0 cellpadding=0 cellspacing=0><td class="fc1-1">&nbsp;&nbsp;&nbsp;&nbsp;มาตรา 3 เตรส&nbsp;&nbsp;(ระบุ) .........................................................................</td></table>

<table width="391PX" border=0 cellpadding=0 cellspacing=0><td class="fc1-1">&nbsp;&nbsp;&nbsp;&nbsp;(เช่น รางวัล ส่วนลดหรือประโยชน์ใดๆ เนื่องจากการส่งเสริมการขาย รางวัล</td></table>

<table width="391PX" border=0 cellpadding=0 cellspacing=0><td class="fc1-1">&nbsp;&nbsp;&nbsp;&nbsp;ในการประกวด การแข่งขัน การชิงโชค ค่าแสดงของนักแสดงสาธารณะ ค่าจ้างทำของ</td></table>

<table width="391PX" border=0 cellpadding=0 cellspacing=0><td class="fc1-1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ค่าโฆษณา ค่าเช่า ค่าขนส่ง ค่าบริการ ค่าเบี้ยประกันวินาศภัย ฯลฯ)</td></table>
</DIV>

<DIV style="left:40PX;top:857PX;width:277PX;height:22PX;"><span class="fc1-1">เงินสะสมจ่ายเข้ากองทุนสำรองเลี้ยงชีพ ใบอนุญาตเลขที่&nbsp;&nbsp;</span></DIV>

<DIV style="left:40PX;top:365PX;width:396PX;height:22PX;"><span class="fc1-1">1. เงินเดือน ค่าจ้าง เบี้ยเลี้ยง โบนัส ฯลฯ ตามมาตรา 40 (1)</span></DIV>

<DIV style="left:40PX;top:384PX;width:396PX;height:22PX;"><span class="fc1-1">2. ค่าธรรมเนียม ค่านายหน้า ฯลฯ ตามมาตรา 40 (2)</span></DIV>

<DIV style="left:40PX;top:403PX;width:396PX;height:22PX;"><span class="fc1-1">3. ค่าแห่งลิขสิทธิ ฯลฯ ตามมาตรา 40 (3)</span></DIV>

<DIV style="left:40PX;top:422PX;width:396PX;height:22PX;"><span class="fc1-1">4. (ก) ค่าดอกเบี้ย&nbsp;&nbsp;ฯลฯ ตามมาตรา 40 (4) ก</span></DIV>

<DIV style="left:40PX;top:730PX;width:396PX;height:24PX;"><span class="fc1-1">6. อื่น ๆ (ระบุ)&nbsp;&nbsp;&nbsp;7hhhhh</span></DIV>

<DIV style="left:455PX;top:857PX;width:85PX;height:21PX;"><span class="fc1-1">จำนวนเงิน </span></DIV>

<DIV style="left:697PX;top:814PX;width:29PX;height:23PX;TEXT-ALIGN:RIGHT;"><span class="fc1-1">บาท</span></DIV>

<DIV style="left:697PX;top:837PX;width:29PX;height:23PX;TEXT-ALIGN:RIGHT;"><span class="fc1-1">บาท</span></DIV>

<DIV style="left:40PX;top:835PX;width:196PX;height:22PX;">
<table width="191PX" border=0 cellpadding=0 cellspacing=0>
<tr><td class="fc1-1">เงินสมทบจ่ายเข้ากองทุนประกันสังคม&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr></table>
</DIV>

<DIV style="left:454PX;top:835PX;width:85PX;height:22PX;"><span class="fc1-1">จำนวนเงิน </span></DIV>

<DIV style="left:34PX;top:956PX;width:702PX;height:18PX;"><span class="fc1-5">&nbsp;&nbsp;&nbsp;หมายเหตุ : ให้สามารถอ้างอิงหรือสอบยันกันได้ระหว่างแบบแสดงรายการนำส่งภาษีกับหนังสือรับรองการหัก ภาษี ณ ที่จ่าย&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></DIV>

<DIV style="left: 41px; top: 148px; width: 32PX; height: 22PX;"><span class="fc1-3">ชื่อ</span></DIV>

<DIV style="left: 41px; top: 174px; width: 32PX; height: 22PX;"><span class="fc1-3">ที่อยู่</span></DIV>

<DIV style="left: 472px; top: 150px; width: 125PX; height: 20PX;"><span class="fc1-1">เลขประจำตัวผู้เสียภาษีอากร </span></DIV>




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

<DIV style="left: 76px; top: 150px; width: 364PX; height: 20PX;"><span class="fc1-3">บริษัท ตัวอย่าง จำกัด</span></DIV>

<DIV style="left:72PX;top:255PX;width:640PX;height:22PX;"><span class="fc1-3">oik&nbsp;&nbsp;&nbsp;กาญจนบุรี&nbsp;&nbsp;12055</span></DIV>

<DIV style="left: 76px; top: 174px; width: 659PX; height: 22PX;"><span class="fc1-3">555 อาคารรุ่งเรือง ถนนสามเสนใน แขวงพญาไท เขตพญาไท กรุงเทพฯ 10400</span></DIV>

<DIV style="left: 72PX; top: 228px; width: 400PX; height: 22PX;"><span class="fc1-3">asd</span></DIV>

<DIV style="left:72PX;top:904PX;width:257PX;height:22PX;"><span class="fc1-1">(X)&nbsp;&nbsp;หักภาษี ณ ที่จ่าย&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(&nbsp;&nbsp;)&nbsp;&nbsp;ออกภาษีให้ตลอดไป</span></DIV>

<DIV style="left:72PX;top:926PX;width:257PX;height:21PX;"><span class="fc1-1">(&nbsp;&nbsp;)&nbsp;&nbsp;ออกภาษีให้ครั้งเดียว&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(&nbsp;&nbsp;)&nbsp;&nbsp;อื่นๆ (ให้ระบุ) ...............</span></DIV>

<DIV style="left:417PX;top:926PX;width:76PX;height:21PX;TEXT-ALIGN:CENTER;"><span class="fc1-3">28/11/2556</span></DIV>

<DIV style="left:436PX;top:730PX;width:104PX;height:24PX;TEXT-ALIGN:CENTER;"><span class="fc1-1">28/11/2556</span></DIV>

<DIV style="left:539PX;top:730PX;width:85PX;height:24PX;TEXT-ALIGN:RIGHT;"><span class="fc1-1">50,000</span></DIV>

<DIV style="left:628PX;top:730PX;width:22PX;height:24PX;TEXT-ALIGN:CENTER;"><span class="fc1-1">00</span></DIV>

<DIV style="left:649PX;top:730PX;width:62PX;height:24PX;TEXT-ALIGN:RIGHT;"><span class="fc1-1">1,500</span></DIV>

<DIV style="left:714PX;top:730PX;width:19PX;height:24PX;TEXT-ALIGN:CENTER;"><span class="fc1-1">00</span></DIV>

<DIV style="left:649PX;top:757PX;width:62PX;height:23PX;TEXT-ALIGN:RIGHT;"><span class="fc1-3">1,500</span></DIV>

<DIV style="left:715PX;top:757PX;width:19PX;height:23PX;TEXT-ALIGN:CENTER;"><span class="fc1-3">00</span></DIV>

<DIV style="left:539PX;top:757PX;width:85PX;height:23PX;TEXT-ALIGN:RIGHT;"><span class="fc1-3">50,000</span></DIV>

<DIV style="left:628PX;top:757PX;width:22PX;height:23PX;TEXT-ALIGN:CENTER;"><span class="fc1-3">00</span></DIV>

<DIV style="left:139PX;top:813PX;width:153PX;height:22PX;"><span class="fc1-1">&nbsp;&nbsp;</span></DIV>

<DIV style="left:216PX;top:783PX;width:466PX;height:24PX;background-color:D6D7D8;layer-background-color:D6D7D8;">
<table width="461PX" border=0 cellpadding=0 cellspacing=0><td class="fc1-2">&nbsp;&nbsp;(หนึ่งพันห้าร้อยบาทถ้วน)</td></table>
</DIV>

<DIV style="left:216PX;top:303PX;width:95PX;height:22PX;"><span class="fc1-1">(&nbsp;&nbsp;X&nbsp;&nbsp;)&nbsp;&nbsp;&nbsp;ภ.ง.ด. 3 </span></DIV>

<DIV style="left:436PX;top:303PX;width:137PX;height:22PX;"><span class="fc1-1">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)&nbsp;&nbsp;&nbsp;ภ.ง.ด. 53 </span></DIV>

<DIV style="left:311PX;top:303PX;width:92PX;height:23PX;"><span class="fc1-1">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)&nbsp;&nbsp;ภ.ง.ด. 3 ก </span></DIV>

<DIV style="left:436PX;top:284PX;width:276PX;height:22PX;"><span class="fc1-1">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)&nbsp;&nbsp;&nbsp;ภ.ง.ด. 2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)&nbsp;&nbsp;ภ.ง.ด. 2 ก&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></DIV>

<DIV style="left:311PX;top:284PX;width:125PX;height:22PX;"><span class="fc1-1">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)&nbsp;&nbsp;ภ.ง.ด. 1 ก (พิเศษ)&nbsp;&nbsp;&nbsp;</span></DIV>

<DIV style="left:649PX;top:329PX;width:85PX;height:30PX;TEXT-ALIGN:CENTER;">
<table width="80PX" border=0 cellpadding=0 cellspacing=0><td ALIGN="CENTER" class="fc1-1">ภาษีที่หัก</td></table>

<table width="80PX" border=0 cellpadding=0 cellspacing=0><td ALIGN="CENTER" class="fc1-1">และนำส่งไว้</td></table>
</DIV>

<DIV style="left: 41px; top: 126px; width: 140PX; height: 20PX;"><span class="fc1-6">ผู้มีหน้าที่หักภาษี ณ ที่จ่าย&nbsp;&nbsp;:- </span></DIV>

<DIV style="left: 371px; top: 125px; width: 170PX; height: 23PX;"><span class="fc1-1">เลขประจำตัวผู้เสียภาษีอากร (13 หลัก)</span></DIV>


<DIV style="left: 472PX; top: 229px; width: 125PX; height: 22PX;"><span class="fc1-1">เลขประจำตัวผู้เสียภาษีอากร </span></DIV>

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

<DIV style="left: 368px; top: 204px; width: 170PX; height: 20PX;"><span class="fc1-1">เลขประจำตัวผู้เสียภาษีอากร (13 หลัก)</span></DIV>



<DIV style="left: 540px; top: 128px; width: 191PX; height: 18PX; TEXT-ALIGN: RIGHT;"><span class="fc1-7">3-1312-31313-13-2</span></DIV>

<DIV style="left: 539PX; top: 205px; width: 191PX; height: 18PX; TEXT-ALIGN: RIGHT;"><span class="fc1-7">1-2345-67891-23-6</span></DIV>
<BR>
</BODY></HTML>

<?php
	}
   
}

?>