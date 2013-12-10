<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Billto extends CI_Controller {
    public $query;
    public $strSQL;
	function __construct()
	{
		parent::__construct();

		$this->load->model('convert_amount','',TRUE);
	}
	
	function index()
	{
		$no = $type = $this->uri->segment(4);
		$copies = intval($type = $this->uri->segment(5));
		if($copies<=0) $copies = 1;
		
	    $strSQL = " select v_vbkk.*,v_vbkp.*";
        $strSQL = $strSQL . " from v_vbkk ";
        $strSQL = $strSQL . " left join v_vbkp on v_vbkk.bilnr =                              v_vbkp.bilnr ";
        $strSQL = $strSQL . " Where v_vbkk.bilnr = '$no' ";
		$strSQL .= "ORDER BY vbelp ASC";
       
		$query = $this->db->query($strSQL);
		$r_data = $query->first_row('array');
		
		// calculate sum
		$rows = $query->result_array();
		$b_amt = 0;
		//$v_amt = 0;
		//foreach ($rows as $key => $item) {
			//$itamt = 0;
			//$itamt = $item['menge'] * $item['unitp'];
			//$itamt = $itamt - $item['disit'];
			//$b_amt += $item['itamt'];
			//$v=0;
			//if(!empty($r_data['chk01']))
			//{
			//   $v = $itamt * $r_data['taxpr'];
			//   $v = $v / 100;
			//   $v_amt += $v;
			//}
		//}

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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<DIV style="z-index:0"> &nbsp; </div>


<DIV style="left:46PX;top:156PX;width:1031PX;height:47PX;background-color:FFC16F;layer-background-color:FFC16F;" class="ad1-0">
<table width="1026PX" border=0 cellpadding=0 cellspacing=0><td class="fc1-0">&nbsp;</td></table>
</DIV>

<DIV style="left: 46px; top: 105px; width: 95px; height: 21PX;"><span class="fc1-1">เป็นใบแนบ ภ.พ.30</span></DIV>

<DIV style="left: 223px; top: 106px; width: 57px; height: 21PX;"><span class="fc1-1">กรณียื่นปกติ</span></DIV>

<DIV style="left: 595px; top: 107px; width: 57px; height: 21PX;"><span class="fc1-1">สำหรับเดือน</span></DIV>

<DIV style="left: 452px; top: 65px; width: 57px; height: 21PX;"><span class="fc1-1">ประจำเดือน</span></DIV>

<DIV style="left: 752px; top: 105px; width: 30px; height: 21PX;"><span class="fc1-1">พ.ศ.</span></DIV>

<DIV style="left: 663px; top: 65px; width: 30px; height: 21PX;"><span class="fc1-1">พ.ศ.</span></DIV>

<DIV style="left: 939px; top: 110px; width: 42px; height: 21PX;"><span class="fc1-1">ในจำนวนแผ่น</span></DIV>

<DIV style="left: 861px; top: 109px; width: 42px; height: 21PX;"><span class="fc1-1">แผ่นที่</span></DIV>

<DIV style="left: 595px; top: 129px; width: 57px; height: 21PX;"><span class="fc1-1">เลขประจำตัวผู้เสียภาษีอากร</span></DIV>

<DIV style="left: 343px; top: 106px; width: 57px; height: 21PX;"><span class="fc1-1">กรณียื่นเพิ่มเติมครั้งที่</span></DIV>

<DIV style="left: 46px; top: 127px; width: 95px; height: 21PX;"><span class="fc1-1">ชื่อผู้ประกอบการ</span></DIV>

<DIV style="left: 142px; top: 127px; width: 251px; height: 21PX;"><span class="fc1-1">บริษัท บางกอก มีเดีย แอนด์ บรอทคาสติ้ง จำกัด</span></DIV>
<DIV style="left: 352px; top: 36px; width: 500px; height: 28PX; background-color: FF8600; layer-background-color: FF8600;">
  <table width="500PX" border=0 cellpadding=0 cellspacing=0><td class="fc1-3">ใบแนบ ภ.พ.30 รายละเอียดภาษีขายและภาษีซื้อของสถานประกอบการแต่ละแห่ง</td></table>
</DIV>
<DIV style="left: 47px; top: 168px; width: 59px; height: 22PX; TEXT-ALIGN: CENTER;"><span class="fc1-5">ลำดับที่</span></DIV>

<DIV style="left: 107px; top: 158px; width: 81px; height: 22PX; TEXT-ALIGN: CENTER;"><span class="fc1-5">สำนักงานใหญ่/</span></DIV>
<DIV style="left: 107px; top: 180px; width: 81px; height: 22PX; TEXT-ALIGN: CENTER;"><span class="fc1-5">สาขาที่</span></DIV>

<DIV style="left: 189px; top: 168px; width: 158px; height: 22PX; TEXT-ALIGN: CENTER;"><span class="fc1-5">ชื่อสำนักงานใหญ่และสาขา</span></DIV>

<DIV style="left: 349px; top: 168px; width: 92PX; height: 22PX; TEXT-ALIGN: CENTER;"><span class="fc1-5">เดบิต</span></DIV>

<DIV style="left: 654px; top: 181px; width: 95PX; height: 22PX; TEXT-ALIGN: RIGHT;"><span class="fc1-5">เดบิต</span></DIV>

<DIV style="left: 872px; top: 181px; width: 95PX; height: 22PX; TEXT-ALIGN: RIGHT;"><span class="fc1-5">เดบิต</span></DIV>

<DIV style="left: 973px; top: 181px; width: 88PX; height: 22PX; TEXT-ALIGN: RIGHT;"><span class="fc1-5">เครดิต</span></DIV>

<DIV style="left: 756px; top: 181px; width: 98PX; height: 22PX; TEXT-ALIGN: RIGHT;"><span class="fc1-5">เครดิต</span></DIV>

<DIV style="left: 531px; top: 180px; width: 99PX; height: 22PX; TEXT-ALIGN: RIGHT;"><span class="fc1-5">เครดิต</span></DIV>
<DIV style="left: 655px; top: 157px; width: 200PX; height: 24PX; TEXT-ALIGN: RIGHT;"><span class="fc1-5">&lt;&lt;&lt;&lt;&lt;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;งบกำไรขาดทุน&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&gt;&gt;&gt;&gt;&gt;</span></DIV>

<DIV style="left: 873px; top: 157px; width: 191PX; height: 24PX; TEXT-ALIGN: RIGHT;"><span class="fc1-5">&lt;&lt;&lt;&lt;&lt;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;งบดุล&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&gt;&gt;&gt;&gt;&gt;</span></DIV>
<DIV style="left:46PX;top:210PX;width:1031PX;height:23PX;"><span class="fc1-5">&nbsp;</span></DIV>

<!--Item List-->
<DIV style="left:46PX;top:210px">
<table cellpadding="0" cellspacing="0" border="0">
<?php
$rows = $query->result_array();
for ($i=($current_page_index * $page_size);$i<($current_page_index * $page_size + $page_size) && $i<count($rows);$i++)://$rows as $key => $item):
	$item = $rows[$i];
	$itamt = $item['itamt'];
	//$itamt = $item['menge'] * $item['unitp'];
	//$itamt = $itamt - $item['disit'];
	$b_amt += $itamt;
	$invdt_str = util_helper_format_date($r_data['invdt']);
?>
	<tr>
		<td class="fc1-8" align="center" style="width:38px;"><?=$item['vbelp'];?></td>
	  <td class="fc1-8" align="center" style="width:65px;"><?=$item['invnr'];?></td>
	  <td class="fc1-8" align="center" style="width:86px;"><?=$invdt_str;?></td>
	  <td class="fc1-8" align="left" style="width:164px;"><?=$item['txz01'];?></td>
		<td class="fc1-8" align="left" style="width:68px;"><?=number_format($itamt,2,'.',',');?></td>
        
        <td class="fc1-8" align="center" style="width:51px;"><?=$item['vbelp'];?></td>
        <td class="fc1-8" align="center" style="width:35px;"><?=$item['vbelp'];?></td>
	  <td class="fc1-8" align="right" style="width:100px;"><?=$item['invnr'];?></td>
	  <td class="fc1-8" align="right" style="width:93px;"><?=$invdt_str;?></td>
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
<DIV style="left:436PX;top:638PX;width:640PX;height:20PX;background-color:FFC16F;layer-background-color:FFC16F;" class="ad1-0">
<table width="635PX" border=0 cellpadding=0 cellspacing=0><td class="fc1-0">&nbsp;</td></table>
</DIV>

<DIV style="left:442PX;top:638PX;width:87PX;height:22PX;TEXT-ALIGN:RIGHT;"><span class="fc1-1">1,809,639.27</span></DIV>

<DIV style="left:541PX;top:638PX;width:93PX;height:22PX;TEXT-ALIGN:RIGHT;"><span class="fc1-1">1,809,639.27</span></DIV>

<DIV style="left:873PX;top:638PX;width:90PX;height:22PX;TEXT-ALIGN:RIGHT;"><span class="fc1-1">656,161.51</span></DIV>

<DIV style="left:657PX;top:638PX;width:90PX;height:22PX;TEXT-ALIGN:RIGHT;"><span class="fc1-1">1,153,477.76</span></DIV>

<DIV style="left:975PX;top:638PX;width:84PX;height:22PX;TEXT-ALIGN:RIGHT;"><span class="fc1-1">1,711,885.52</span></DIV>

<DIV style="left:759PX;top:638PX;width:93PX;height:22PX;TEXT-ALIGN:RIGHT;"><span class="fc1-1">97,753.75</span></DIV>

<DIV style="left:320PX;top:639PX;width:106PX;height:21PX;TEXT-ALIGN:RIGHT;"><span class="fc1-5">รวมทั้งสิ้น</span></DIV>
<BR>

<DIV style="width:100%; left:0; top:834PX">
<HR width="100%"><CENTER><TABLE CELLSPACING=20 CELLPADDING=0 ><TR><TD><FONT COLOR="#08801A"><I>View Pages</I></FONT></TD><TD><I><A href="1A800last.html">Next</A></I></TD><TD><I><A href="1A800last.html">Last</A></I></TD></TR></TABLE></CENTER>
</DIV></BODY></HTML> 


<?php
	}
   
}

?>