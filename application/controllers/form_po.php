<?php
class Form_PO extends CI_Controller {
    public $query;
    public $strSQL;
	function index()
	{
	    $strSQL = " select v_ekpo.*,v_ekko.* ,(v_ekpo.menge * v_ekpo.unitp) total_per_menge";
        $strSQL = $strSQL . " from v_ekpo ";
        $strSQL = $strSQL . " left join v_ekko on v_ekpo.ebeln = v_ekko.ebeln ";
        $strSQL = $strSQL . " Where v_ekpo.ebeln = 'PO1309-1000' ";
        
		$query = $this->db->query($strSQL);
        
        ?>
        <body> <meta http-equiv="content-type" content="text/html; charset=windows-874">
        
        <form id="form1" >
        <INPUT TYPE="button" value="Print" onClick="window.print()">
        <div>

           <table style="border: 1px solid #000000; width: 60%; height: 598px; border-collapse: collapse; ">
           <tr>
                 <td style="height: 60px">
                 <?php
                 foreach ($query->result() as $row)
                 {
                 ?>
                      </br>
                            <font color="black" size="2"> <?=$row->name1;?></font></br>
                            <font color="black" size="2"> <?=$row->adr01;?></font></br>
                            <font color="black" size="2">Tel : <?=$row->telf1;?></font></br>
                            <font color="black" size="2">Email : <?=$row->email;?></font></br></br>
                 <?php
                  break; 
                 }
                 ?>
                 
                 </td>
           </tr>
           <tr >
                 <td style="height: 40px">
                     <table style=" border: 1px solid #000000 ;width:100%;border-collapse: collapse; ">
                     <tr>
                        <td style="border: 1px solid #000000; text-align: center">
                            <font color="black" size="2">เลขที่ใบสั่งซื้อ</font></td>
                        <td style="border: 1px solid #000000; text-align: center">
                            <font color="black" size="2">อ้างถึง</font></td>
                        <td style="border: 1px solid #000000; text-align: center">
                            <font color="black" size="2">พนักงานขาย</font></td>
                        <td style="border: 1px solid #000000; text-align: center">
                            <font color="black" size="2">เครดิต</font></td>
                        <td style="border: 1px solid #000000; text-align: center">
                            <font color="black" size="2">วันที่ครบกำหนด</font></td>
                    </tr>
                     <tr >
                        <td style="border: 1px solid #000000; height:60px; text-align: center">
                            &nbsp;</td>
                        <td style="border: 1px solid #000000; text-align: center">
                            &nbsp;</td>
                        <td style="border: 1px solid #000000; text-align: center">
                            &nbsp;</td>
                        <td style="border: 1px solid #000000; text-align: center">
                            &nbsp;</td>
                        <td style="border: 1px solid #000000; text-align: center">
                            &nbsp;</td>
                    </tr>
                    </table>

                 </td>
           </tr>
            <tr>
                 <td style="height:60px">
                    <table style="width:100%;border-collapse: collapse;">
                    <tr>
                        <td style="border: 1px solid #000000; text-align: center">
                            <font color="black" size="2">ลำดับ</font></td>
                        <td style="border: 1px solid #000000; text-align: center; width: 133px;">
                            <font color="black" size="2">รหัสสินค้า</font></td>
                        <td style="border: 1px solid #000000; text-align: center">
                            <font color="black" size="2">รายการ</font></td>
                        <td style="border: 1px solid #000000; text-align: center">
                            <font color="black" size="2">จำนวน</font></td>
                        <td style="border: 1px solid #000000; text-align: center">
                            <font color="black" size="2">หน่วย</font></td>
                        <td style="border: 1px solid #000000; text-align: center; width: 155px;">
                            <font color="black" size="2">ราคาต่อหน่วย</font></td>
                        <td style="border: 1px solid #000000; text-align: center">
                            <font color="black" size="2">ส่วนลด</font></td>
                        <td style="border: 1px solid #000000; text-align: center">
                            <font color="black" size="2">จำนวนเงิน</font></td>
                    </tr>

                    <tr>
                        <td style="border: 1px solid #000000; height:200px;  text-align: center">
                          <div style="height:220px;padding-top:5px">
                            <?php
                               $row_count = 0;
                               foreach ($query->result() as $row)
                               {
                                  $row_count = $row_count +1;
                            ?>
                                 </br>
                                 <font color="black" size="2" > <?=$row_count;?></font>  </br>
                            <?php
                               }
                            ?>
                            
                           </div></td>
                        <td style="border: 1px solid #000000; text-align: center; width: 133px;">
                          <div style="height:220px;padding-top:5px">
                            <?php
                           
                               foreach ($query->result() as $row)
                               {
                            ?>
                                </br>
                                <font color="black" size="2"> <?=$row->matnr;?></font></br>
                            <?php
                               }
                            ?>
                            
                             </div></td>
                        <td style="border: 1px solid #000000; text-align: center">
                              <div style="height:220px;padding-top:5px">
                             <?php
                           
                               foreach ($query->result() as $row)
                               {
                            ?>
                                </br>
                                <font color="black" size="2"> <?=$row->maktx;?></font></br>
                            <?php
                               }
                            ?>
                              </div></td>
                        <td style="border: 1px solid #000000; text-align: center">
                              <div style="height:220px;padding-top:5px">
                             <?php
                           
                               foreach ($query->result() as $row)
                               {
                            ?>
                                </br>
                                <font color="black" size="2"> <?=$row->menge;?></font></br>
                            <?php
                               }
                            ?>
                               </div></td>
                        <td style="border: 1px solid #000000; text-align: center">
                              <div style="height:220px;padding-top:5px">
                             <?php
                           
                               foreach ($query->result() as $row)
                               {
                            ?>
                                </br>
                                <font color="black" size="2"> <?=$row->meins;?></font></br>
                            <?php
                               }
                            ?>
                             </div></td>
                        <td style="border: 1px solid #000000; text-align: center; width: 155px;">
                              <div style="height:220px;padding-top:5px">
                             <?php
                           
                               foreach ($query->result() as $row)
                               {
                            ?>
                                </br>
                                <font color="black" size="2"> <?=$row->unitp;?></font></br>
                            <?php
                               }
                            ?>
                             </div></td>
                        <td style="border: 1px solid #000000; text-align: center">
                          <div style="height:220px;padding-top:5px">
                             <?php
                           
                               foreach ($query->result() as $row)
                               {
                            ?>
                                </br>
                                <font color="black" size="2"> <?=$row->dismt;?></font></br>
                            <?php
                               }
                            ?>
                             </div></td>
                        <td style="border: 1px solid #000000; text-align: center">
                          <div style="height:220px;padding-top:5px">
                             <?php
                                $total_money = 0;
                               foreach ($query->result() as $row)
                               {
                                $total_money = $total_money + $row->total_per_menge;
                            ?>
                                </br>
                                <font color="black" size="2"> <?=$row->total_per_menge;?></font></br>
                            <?php
                               }
                            ?>
                            </div></td>
                    </tr>

                    <tr>
                        <td style="border: 0px solid #000000;  text-align: left" colspan="4"><font color="black" size="2">หมายเหตุ</font>
                            &nbsp;</td>
                        <td style="border: 1px solid #000000; text-align: left" colspan="3"><font color="black" size="2">รวมเงิน</font></td>
                        <td style="border: 1px solid #000000; text-align: center">
                        <font color="black" size="2"> <?=$total_money;?></font>
                            &nbsp;</td>
                    </tr>

                    <tr>
                        <td style="border: 0px solid #000000;  text-align: center" colspan="4">
                            &nbsp;</td>
                        <td style="border: 1px solid #000000; text-align: left" colspan="3">
                            <font color="black" size="2">ส่วนลด</font></td>
                        <td style="border: 1px solid #000000; text-align: center">
                            &nbsp;</td>
                    </tr>

                    <tr>
                        <td style="border: 0px solid #000000;  text-align: center" colspan="4">
                            &nbsp;</td>
                        <td style="border: 1px solid #000000; text-align: left" colspan="3">
                            <font color="black" size="2">จำนวนเงินหลังหักส่วนลด</font></td>
                        <td style="border: 1px solid #000000; text-align: center">
                            &nbsp;</td>
                    </tr>

                    <tr>
                        <td style="border: 0px solid #000000;  text-align: center" colspan="4">
                            &nbsp;</td>
                        <td style="border: 1px solid #000000; text-align: left" colspan="3">
                            <font color="black" size="2">เงินมัดจำ</font></td>
                        <td style="border: 1px solid #000000; text-align: center">
                            &nbsp;</td>
                    </tr>

                    <tr>
                        <td style="border: 0px solid #000000;  text-align: center" colspan="4">
                            &nbsp;</td>
                        <td style="border: 1px solid #000000; text-align: left" colspan="3">
                            <font color="black" size="2">หลังหักมัดจำ</font></td>
                        <td style="border: 1px solid #000000; text-align: center">
                            &nbsp;</td>
                    </tr>

                    <tr>
                        <td style="border: 0px solid #000000;  text-align: center" colspan="4">
                            &nbsp;</td>
                        <td style="border: 1px solid #000000; text-align: left" colspan="3">
                          
                            <font color="black" size="2">ภาษีมูลค่าเพิ่ม</font></td>
                        <td style="border: 1px solid #000000; text-align: center">
                            &nbsp;</td>
                    </tr>

                    <tr>
                        <td style="border: 0px solid #000000;  text-align: center" colspan="4">
                            &nbsp;</td>
                        <td style="border: 1px solid #000000; text-align: left" colspan="3">
                            <font color="black" size="2">ก่อนหักภาษี ณ ที่จ่าย</font></td>
                        <td style="border: 1px solid #000000; text-align: center">
                            &nbsp;</td>
                    </tr>

                    <tr>
                        <td style="border: 0px solid #000000;  text-align: center" colspan="4">
                            &nbsp;</td>
                        <td style="border: 1px solid #000000; text-align: left" colspan="3">
                            <font color="black" size="2">ภาษีหัก ณ ที่จ่าย</font></td>
                        <td style="border: 1px solid #000000; text-align: center">
                            &nbsp;</td>
                    </tr>

                    <tr>
                        <td style="border: 0px solid #000000;  text-align: center" colspan="4">
                            &nbsp;</td>
                        <td style="border: 1px solid #000000; text-align: left" colspan="3">
                            <font color="black" size="2">จำนวนเงินที่ต้องชำระ</font></td>
                        <td style="border: 1px solid #000000; text-align: center">
                            &nbsp;</td>
                    </tr>

                    <tr>
                        <td style="border: 1px solid #000000;  text-align: center">
                            <font color="black" size="2">เงินสด</font></td>
                        <td style="border: 1px solid #000000; text-align: center; width: 133px;">
                            <font color="black" size="2">ธนาคาร</font></td>
                        <td style="border: 1px solid #000000; text-align: center" colspan="2">
                            <font color="black" size="2">สาขา</font></td>
                        <td style="border: 1px solid #000000; text-align: center" colspan="2">
                            <font color="black" size="2">วันที่</font></td>
                        <td style="border: 1px solid #000000; text-align: center">
                            <font color="black" size="2">เลขที่</font></td>
                        <td style="border: 1px solid #000000; text-align: center">
                            <font color="black" size="2">จำนวนเงิน</font></td>
                    </tr>

                    <tr>
                        <td style="border: 1px solid #000000; height:60px;  text-align: center">
                            &nbsp;</td>
                        <td style="border: 1px solid #000000; text-align: center; width: 133px;">
                            &nbsp;</td>
                        <td style="border: 1px solid #000000; text-align: center" colspan="2">
                            &nbsp;</td>
                        <td style="border: 1px solid #000000; text-align: center" colspan="2">
                            &nbsp;</td>
                        <td style="border: 1px solid #000000; text-align: center">
                            &nbsp;</td>
                        <td style="border: 1px solid #000000; text-align: center">
                            &nbsp;</td>
                    </tr>

                    <tr>
                        <td style="border: 1px solid #000000; height:40px;  text-align: left" colspan="8">
                            <font color="black" size="2">(จำนวนเงิน ตัวอักษร)</font></td>
                            &nbsp;</td>
                    </tr>

                    </table>
            <table style="width: 100%;border-collapse: collapse;">
                <tr>
                    <td style="text-align: center; height:100px; border: 1px solid #000000; width: 161px;"> <div><font color="black" size="2">___________________</font></div></br> <div><font color="black" size="2">ผู้รับของ ....../....../......</font></div> </td>
                    <td style="text-align: center; border: 1px solid #000000"><div><font color="black" size="2">___________________</font></div></br> <div><font color="black" size="2">ผู้ส่งของ ....../....../......</font></div> </td>
                    <td style="text-align: center; border: 1px solid #000000"><div><font color="black" size="2">___________________</font></div></br> <div><font color="black" size="2">ผู้มีอำนาจลงนาม</font></div> </td>
                    <td style="text-align: center; border: 1px solid #000000"><div><font color="black" size="2">___________________</font></div></br> <div><font color="black" size="2">ผู้รับเงิน</font></div> </td>
                </tr>
                </table>


                 </td>
           </tr>
           <tr>
               <td>



               </td>
           </tr>
        </table>

        </div>
   
       
    </form>
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
        </body>
   
        <?php
	}
   
}

?>


        

 