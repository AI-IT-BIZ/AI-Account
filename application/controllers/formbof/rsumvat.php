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
		$comid = XUMS::COMPANY_ID();
		$strSQL="";//echo $comid;
		$strSQL= " select tbl_comp.* from tbl_comp where tbl_comp.comid = '".$comid."'";
		$q_com = $this->db->query($strSQL);
		$r_com = $q_com->first_row('array');
		if($q_com->num_rows()>0){
		
		//$no = $type = $this->uri->segment(4);
		$no=1;$j=0;
		$date =	$this->input->get('bldat');
		$copies =	$this->input->get('copies');
		$month = explode('-',$date);
		$dt_result = util_helper_get_sql_between_month($date);
		$text_month = $this->convert_amount->text_month($month[1]);
		
		if($copies<=0) $copies = 1;
		//Sale
	    $strSQL = " select v_vbrk.*";
        $strSQL = $strSQL . " from v_vbrk ";
        $strSQL = $strSQL . " Where v_vbrk.bldat ".$dt_result;
		$strSQL = $strSQL . " And v_vbrk.statu = '02' ";
		$strSQL .= "ORDER BY invnr ASC";
       
		$query = $this->db->query($strSQL);
		$r_data = $query->first_row('array');
		
		//Sale debit
	    $strSQL = " select v_vbdn.*";
        $strSQL = $strSQL . " from v_vbdn ";
        $strSQL = $strSQL . " Where v_vbdn.bldat ".$dt_result;
		$strSQL = $strSQL . " And v_vbdn.statu = '02' ";
		$strSQL .= "ORDER BY debnr ASC";
       
		$q_saledn = $this->db->query($strSQL);
		
		//Sale credit
	    $strSQL = " select v_vbcn.*";
        $strSQL = $strSQL . " from v_vbcn ";
        $strSQL = $strSQL . " Where v_vbcn.bldat ".$dt_result;
		$strSQL = $strSQL . " And v_vbcn.statu = '02' ";
		$strSQL .= "ORDER BY crenr ASC";
       
		$q_salecn = $this->db->query($strSQL);
		
		//Purchase
		$strSQL2 = " select v_ebrk.*";
        $strSQL2 = $strSQL2 . " from v_ebrk ";
        $strSQL2 = $strSQL2 . " Where v_ebrk.bldat ".$dt_result;
		$strSQL = $strSQL . " And v_ebrk.statu = '02' ";
		$strSQL2 .= "ORDER BY invnr ASC";
       
		$q_purch = $this->db->query($strSQL2);
		
        //Purchase debit
		$strSQL2 = " select v_ebdn.*";
        $strSQL2 = $strSQL2 . " from v_ebdn ";
        $strSQL2 = $strSQL2 . " Where v_ebdn.bldat ".$dt_result;
		$strSQL = $strSQL . " And v_ebdn.statu = '02' ";
		$strSQL2 .= "ORDER BY debnr ASC";
       
		$q_purchdn = $this->db->query($strSQL2);
		
		//Purchase credit
		$strSQL2 = " select v_ebcn.*";
        $strSQL2 = $strSQL2 . " from v_ebcn ";
        $strSQL2 = $strSQL2 . " Where v_ebcn.bldat ".$dt_result;
		$strSQL = $strSQL . " And v_ebcn.statu = '02' ";
		$strSQL2 .= "ORDER BY crenr ASC";
       
		$q_purchcn = $this->db->query($strSQL2);
		
		// calculate sum
		$rows = $query->result_array();
		$rowscn = $q_salecn->result_array();
		$rowsdn = $q_saledn->result_array();
		$rowp = $q_purch->result_array();
		$rowpcn = $q_purchcn->result_array();
		$rowpdn = $q_purchdn->result_array();

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
<link rel="stylesheet" href="<?= base_url('assets/css/fonts/AngsanaNew/font.css') ?>" />
<STYLE>
body { font-family: 'angsana_newregular'; }
 A {text-decoration:none}
 A IMG {border-style:none; border-width:0;}
 DIV {
	position: absolute;
	z-index: 25;
	
}
.fc1-0 { COLOR:000000;FONT-SIZE:9PT;FONT-FAMILY:Tahoma;FONT-WEIGHT:NORMAL;}
.fc1-1 { COLOR:000000;FONT-SIZE:11PT;FONT-WEIGHT:NORMAL;}
.fc1-2 { COLOR:FFFFFF;FONT-SIZE:11PT;FONT-WEIGHT:NORMAL;}
.fc1-3 { COLOR:FFFFFF;FONT-SIZE:14PT;FONT-FAMILY:'angsana_newbold';}
.fc1-4 { COLOR:000000;FONT-SIZE:10PT;FONT-WEIGHT:NORMAL;}
.fc1-5 { COLOR:000000;FONT-SIZE:11PT;FONT-FAMILY:'angsana_newbold';}
.fc1-8 { COLOR:000000;FONT-SIZE:13PT;FONT-WEIGHT:NORMAL;}
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
	$page_size = 8;
	$total_count = count($rows) + count($rowp) + count($rowscn) 
	+ count($rowpcn) + count($rowsdn) + count($rowpdn);
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

<DIV style="left: 721px; top: 130px; width: 109px; height: 25PX; TEXT-ALIGN: LEFT;"><span class="fc1-1"><?= $r_com['taxid']; ?></span></DIV>

<DIV style="left: 775px; top: 107px; width: 30px; height: 21PX;"><span class="fc1-1">พ.ศ.</span></DIV>

<DIV style="left: 801px; top: 107px; width: 61px; height: 20px; TEXT-ALIGN: LEFT;"><span class="fc1-1"><?= $month[0]+543 ?></span></DIV>
<DIV style="left: 912px; top: 108px; width: 37px; height: 25PX; TEXT-ALIGN: LEFT;"><span class="fc1-1"><?=($current_page_index+1);?></span></DIV>
<DIV style="left: 1024px; top: 107px; width: 45px; height: 25PX; TEXT-ALIGN: LEFT;"><span class="fc1-1"><?=$total_page;?></span></DIV>
<DIV style="left: 949px; top: 108px; width: 94px; height: 21PX;"><span class="fc1-1">ในจำนวนแผ่น</span></DIV>

<DIV style="left: 874px; top: 108px; width: 42px; height: 21PX;"><span class="fc1-1">แผ่นที่</span></DIV>

<DIV style="left: 595px; top: 129px; width: 172px; height: 21PX;"><span class="fc1-1">เลขประจำตัวผู้เสียภาษีอากร</span></DIV>

<DIV style="left: 343px; top: 106px; width: 57px; height: 21PX;"><span class="fc1-1">กรณียื่นเพิ่มเติมครั้งที่</span></DIV>

<DIV style="left: 13px; top: 127px; width: 95px; height: 21PX;"><span class="fc1-1">ชื่อผู้ประกอบการ</span></DIV>

<DIV style="left: 95px; top: 127px; width: 251px; height: 21PX;"><span class="fc1-1"><?= $r_com['name1']; ?></span></DIV>
<DIV style="left: 352px; top: 44px; width: 500px; height: 28PX; background-color: FF8600; layer-background-color: FF8600;TEXT-ALIGN: CENTER;">
  <span class="fc1-3">ใบแนบ ภ.พ.30 รายละเอียดภาษีขายและภาษีซื้อของสถานประกอบการแต่ละแห่ง</span>
</DIV>
<div style="left: 49px; top: 157px; border-style: solid; border-width: 0px; border-left-width: 1PX; height: 503px;"class="ad1-0">
  <table width="0px" height="205PX">
      <td>&nbsp;</td>
  </table>
</div>
<DIV style="left: 12px; top: 168px; width: 38px; height: 22PX; TEXT-ALIGN: CENTER;"><span class="fc1-5">ลำดับที่</span></DIV>
<div style="left: 13px; top: 157px;  border-style: solid; border-width: 0px; border-left-width: 1PX; height: 503px;"class="ad1-0">
  <table width="0px" height="205PX">
      <td>&nbsp;</td>
  </table>
</div>
<DIV style="left: 50px; top: 168px; width: 56px; height: 22PX; TEXT-ALIGN: CENTER;"><span class="fc1-5">วันที่</span></DIV>
<div style="left: 175px; top: 157px; border-style: solid; border-width: 0px; border-left-width: 1PX; height: 504px;"class="ad1-0">
  <table width="0px" height="205PX"><td>&nbsp;</td></table>
</div>

<DIV style="left: 107px; top: 158px; width: 70px; height: 22PX; TEXT-ALIGN: CENTER;"><span class="fc1-5">เลขที่</span></DIV>
<DIV style="left: 106px; top: 181px; width: 70px; height: 22PX; TEXT-ALIGN: CENTER;"><span class="fc1-5">ใบกำกับภาษี</span></DIV>

<div style="left: 106px; top: 156px; border-style: solid; border-width: 0px; border-left-width: 1PX; height: 504px;"class="ad1-0">
  <table width="0px" height="205PX"><td>&nbsp;</td></table>
</div>

<DIV style="left: 175px; top: 158px; width: 53px; height: 22PX; TEXT-ALIGN: CENTER;"><span class="fc1-5">สำนักงาน</span></DIV>
<DIV style="left: 175px; top: 181px; width: 54px; height: 22PX; TEXT-ALIGN: CENTER;"><span class="fc1-5">ใหญ่/สาขา</span></DIV>

<div style="left: 227px; top: 156px; border-style: solid; border-width: 0px; border-left-width: 1PX; height: 504px;"class="ad1-0">
  <table width="0px" height="205PX"><td>&nbsp;</td></table>
</div>

<DIV style="left: 228px; top: 178px; width: 180px; height: 22PX; TEXT-ALIGN: CENTER;"><span class="fc1-5">และสาขา</span></DIV>
<DIV style="left: 228px; top: 157px; width: 181px; height: 22PX; TEXT-ALIGN: CENTER;"><span class="fc1-5">ชื่อสำนักงานใหญ่</span></DIV>

<div style="left: 408px; top: 157px; border-style: solid; border-width: 0px; border-left-width: 1PX; height: 503px;"class="ad1-0">
  <table width="0px" height="205PX"><td>&nbsp;</td></table>
</div>

<DIV style="left: 409px; top: 167px; width: 265px; height: 22PX; TEXT-ALIGN: CENTER;"><span class="fc1-5">ที่ตั้งสถานประกอบการ</span></DIV>

<div style="left: 673px; top: 157px; border-style: solid; border-width: 0px; border-left-width: 1PX; height: 523px;"class="ad1-0">
  <table width="0px" height="205PX"><td>&nbsp;</td></table>
</div>

<DIV style="left: 675px; top: 167px; width: 75px; height: 22PX; TEXT-ALIGN: CENTER;"><span class="fc1-5">ยอดขาย</span></DIV>

<DIV style="left: 752px; top: 166px; width: 70px; height: 22PX; TEXT-ALIGN: CENTER;"><span class="fc1-5">ภาษีขาย</span></DIV>

<div style="left: 822px; top: 157px; border-style: solid; border-width: 0px; border-left-width: 1PX; height: 524px;"class="ad1-0">
  <table width="0px" height="205PX"><td>&nbsp;</td></table>
</div>

<DIV style="left: 824px; top: 167px; width: 73px; height: 22PX; TEXT-ALIGN: CENTER;"><span class="fc1-5">ยอดซื้อ</span></DIV>

<DIV style="left: 898px; top: 167px; width: 70px; height: 22PX; TEXT-ALIGN: CENTER;"><span class="fc1-5">ภาษีซื้อ</span></DIV>

<div style="left: 897px; top: 157px; border-style: solid; border-width: 0px; border-left-width: 1PX; height: 523px;"class="ad1-0">
  <table width="0px" height="205PX"><td>&nbsp;</td></table>
</div>

<div style="left: 750px; top: 156px; border-style: solid; border-width: 0px; border-left-width: 1PX; height: 524px;"class="ad1-0">
  <table width="0px" height="205PX"><td>&nbsp;</td></table>
</div>

<div style="left: 968px; top: 157px; border-style: solid; border-width: 0px; border-left-width: 1PX; height: 522px;"class="ad1-0">
  <table width="0px" height="205PX"><td>&nbsp;</td></table>
</div>

<DIV style="left: 969px; top: 157px; width: 108px; height: 22PX; TEXT-ALIGN: CENTER;"><span class="fc1-5">ภาษีมูลค่าเพิ่มที่</span></DIV>

<DIV style="left: 961px; top: 180px; width: 122px; height: 22PX; TEXT-ALIGN: CENTER;"><span class="fc1-5">ต้องชำระ(+)ชำระเกิน (-)</span></DIV>

<div style="left: 1077px; top: 156px; border-style: solid; border-width: 0px; border-left-width: 1PX; height: 523px;"class="ad1-0">
  <table width="0px" height="205PX"><td>&nbsp;</td></table>
</div>

<DIV style="left: 13px; top: 210PX; width: 1064px; height: 23PX;"><span class="fc1-5">&nbsp;</span></DIV>

<!--Item List-->
<DIV style="left: 13px; top: 210px">
<table cellpadding="0" cellspacing="0" border="0" width="1062">
<?php
$rows = $query->result_array();
$rowp = $q_purch->result_array();
$alls = count($rows) + count($rowp) + count($rowscn) 
	  + count($rowpcn) + count($rowsdn) + count($rowpdn);
$s_amt=0;$s_vat=0;$p_amt=0;$p_vat=0;$t_vat=0;$k=0;$l=0;$m=0;$n=0;
$invdt_str='';$d_vat=0;$ts_amt=0;$ts_vat=0;$tp_amt=0;$tp_vat=0;$invoice='';
for ($i=($current_page_index * $page_size);
     $i<($current_page_index * $page_size + $page_size) && $i<$alls;$i++)://$rows as $key => $item):
     if($i<count($rows)){
	    $item = $rows[$i];
		$s_amt = $item['beamt'];
		$s_vat = $item['vat01'];
		$ts_amt += $item['beamt'];
		$ts_vat += $item['vat01'];
		$d_vat = $item['vat01'];
		$invoice = $item['invnr'];
	 }else{
	      if($j<count($rowp)){
		     $item = $rowp[$j];
		     $j++;
		     $p_amt = $item['beamt'];
		     $p_vat = $item['vat01'];
		     $tp_amt += $item['beamt'];
		     $tp_vat += $item['vat01'];
		     $d_vat = 0 - $item['vat01'];
			 $invoice = $item['invnr'];
	         }else{
	             if($k<count($rowsdn)){
		         $item = $rowsdn[$k];
		         $k++;
		         $p_amt = $item['beamt'];
		         $p_vat = $item['vat01'];
		         $tp_amt += $item['beamt'];
		         $tp_vat += $item['vat01'];
		         $d_vat = $item['vat01'];
				 $invoice = $item['debnr'];
	             }else{
	             	if($l<count($rowscn)){
		              $item = $rowscn[$l];
		              $l++;
		              $p_amt = $item['beamt'];
		              $p_vat = $item['vat01'];
		              $tp_amt += $item['beamt'];
		              $tp_vat += $item['vat01'];
		              $d_vat = 0 - $item['vat01'];
					  $invoice = $item['crenr'];
	                  }else{
	             	      if($m<count($rowpcn)){
		                    $item = $rowpcn[$m];
		                    $m++;
		                    $p_amt = $item['beamt'];
		                    $p_vat = $item['vat01'];
		                    $tp_amt += $item['beamt'];
		                    $tp_vat += $item['vat01'];
		                    $d_vat = $item['vat01'];
							$invoice = $item['crenr'];
	                        }else{
	             	           if($n<count($rowpdn)){
		                          $item = $rowpdn[$n];
		                          $n++;
		                          $p_amt = $item['beamt'];
		                          $p_vat = $item['vat01'];
		                          $tp_amt += $item['beamt'];
		                          $tp_vat += $item['vat01'];
		                          $d_vat = 0 - $item['vat01'];
								  $invoice = $item['debnr'];
	                           }
	                        }
	                  }
	             }
	 }
	 }
	//$itamt = $item['beamt'];
	//$t_amt += $itamt;
	$t_vat += $d_vat;
	
	$invdt_str = util_helper_format_date($r_data['bldat']);
	$adr01 = $item['adr01'].$item['distx'];
?>
	<tr>
	  <td class="fc1-8" align="center" valign="top" style="width:36px;"><?=$no++;?></td>
	  <td class="fc1-8" align="center" valign="top" style="width:56px;"><?=$invdt_str;?></td>
	  <td class="fc1-8" align="center" valign="top" style="width:70px;"><?=$invoice;?></td>
      <td class="fc1-8" align="center" valign="top" style="width:53px;">0000</td>
	  <td class="fc1-8" align="left" valign="top" style="width:181px;"><?=$item['name1'];?></td>
      <td class="fc1-8" align="left" valign="top" style="width:263px;"><?=$adr01;?></td>

      <td class="fc1-8" align="right" valign="top" style="width:75px;"><?=number_format($s_amt,2,'.',',');?></td>
      <td class="fc1-8" align="right" valign="top" style="width:70px;"><?=number_format($s_vat,2,'.',',');?></td>
      <td class="fc1-8" align="right" valign="top" style="width:74px;"><?=number_format($p_amt,2,'.',',');?></td>
	  <td class="fc1-8" align="right" valign="top" style="width:72px;"><?=number_format($p_vat,2,'.',',');?></td>
	  <td class="fc1-8" align="right" valign="top" style="width:110px;"><?=number_format($d_vat,2,'.',',');?></td>
	</tr>

<?php
$s_amt=0;$s_vat=0;$p_amt=0;$p_vat=0;
endfor;
?>
</table>
</DIV>

<!--Total Line-->
<DIV style="left: 11px; top: 660PX; width: 1067px; height: 20PX; background-color: FFC16F; layer-background-color: FFC16F;" class="ad1-0">
<table width="635PX" border=0 cellpadding=0 cellspacing=0><td class="fc1-0">&nbsp;</td></table>
</DIV>
<DIV style="left: 674px; top: 660px; width: 76px; height: 22PX; TEXT-ALIGN: RIGHT;"><span class="fc1-1"><?=check_page($current_page_index, $total_page, number_format($ts_amt,2,'.',','));?></span></DIV>

<DIV style="left: 897px; top: 661px; width: 71px; height: 22PX; TEXT-ALIGN: RIGHT;"><span class="fc1-1"><?=check_page($current_page_index, $total_page, number_format($tp_vat,2,'.',','));?></span></DIV>

<DIV style="left: 750px; top: 660PX; width: 72px; height: 22PX; TEXT-ALIGN: RIGHT;"><span class="fc1-1"><?=check_page($current_page_index, $total_page, number_format($ts_vat,2,'.',','));?></span></DIV>

<DIV style="left: 970px; top: 660PX; width: 105px; height: 22PX; TEXT-ALIGN: RIGHT;"><span class="fc1-1"><?=check_page($current_page_index, $total_page, number_format($t_vat,2,'.',','));?></span></DIV>

<DIV style="left: 821px; top: 660PX; width: 76px; height: 22PX; TEXT-ALIGN: RIGHT;"><span class="fc1-1"><?=check_page($current_page_index, $total_page, number_format($tp_amt,2,'.',','));?></span></DIV>

<DIV style="left: 486px; top: 660PX; width: 106PX; height: 21PX; TEXT-ALIGN: CENTER;"><span class="fc1-5">รวมทั้งสิ้น</span></DIV>
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