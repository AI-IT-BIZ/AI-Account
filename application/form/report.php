
<?php
	$host = "54.251.188.145";
    $username = "ai_account";
    $password = "ai_account_pass";
    $objConnect = mysql_connect($host,$username,$password);

    $objDB = mysql_select_db("ai_account");
    
    //$strSQL1 = " select v_ekpo.* ";
  //  $strSQL1 = $strSQL1 .  " from v_ekpo  ";
  //  $strSQL1 = $strSQL1 .  " Where v_ekpo.ebeln = 'PO1309-1000' ";
  
  //  $objQuery_V_EKPO = mysql_query($strSQL1) or die (mysql_error());
    /*********************************************************************/
    $strSQL2 = " select v_ekpo.*,v_ekko.* ,(v_ekpo.menge * v_ekpo.unitp) total_per_menge";
    $strSQL2 = $strSQL2 . " from v_ekpo ";
    $strSQL2 = $strSQL2 . " left join v_ekko on v_ekpo.ebeln = v_ekko.ebeln ";
    $strSQL2 = $strSQL2 . " Where v_ekpo.ebeln = 'PO1309-1000' ";
    
    $objQuery_V_EKKO = mysql_query($strSQL2) or die (mysql_error());
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<head>
    <title></title>
</head>
<body> 
    <form id="form1" >
        <INPUT TYPE="button" value="Print" onClick="window.print()">
        <div>

           <table style="border: 1px solid #000000; width: 60%; height: 598px; border-collapse: collapse; ">
           <tr>
                 <td style="height: 60px">
                  <?php
                        $objQuery_V_EKKO = mysql_query($strSQL2) or die (mysql_error());
	                    while($objResult = mysql_fetch_array($objQuery_V_EKKO))
                        {
                        ?>
                            </br>
                            <font color="black" size="2"> <?=$objResult["name1"];?></font></br>
                            <font color="black" size="2"> <?=$objResult["adr01"];?></font></br>
                            <font color="black" size="2">Tel : <?=$objResult["telf1"];?></font></br>
                            <font color="black" size="2">Email : <?=$objResult["email"];?></font></br></br>
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
                            <font color="black" size="2">�Ţ������觫���</font></td>
                        <td style="border: 1px solid #000000; text-align: center">
                            <font color="black" size="2">��ҧ�֧</font></td>
                        <td style="border: 1px solid #000000; text-align: center">
                            <font color="black" size="2">��ѡ�ҹ���</font></td>
                        <td style="border: 1px solid #000000; text-align: center">
                            <font color="black" size="2">�ôԵ</font></td>
                        <td style="border: 1px solid #000000; text-align: center">
                            <font color="black" size="2">�ѹ���ú��˹�</font></td>
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
                            <font color="black" size="2">�ӴѺ</font></td>
                        <td style="border: 1px solid #000000; text-align: center; width: 133px;">
                            <font color="black" size="2">�����Թ���</font></td>
                        <td style="border: 1px solid #000000; text-align: center; width: 200px;">
                            <font color="black" size="2">��¡��</font></td>
                        <td style="border: 1px solid #000000; text-align: center">
                            <font color="black" size="2">�ӹǹ</font></td>
                        <td style="border: 1px solid #000000; text-align: center">
                            <font color="black" size="2">˹���</font></td>
                        <td style="border: 1px solid #000000; text-align: center; width: 155px;">
                            <font color="black" size="2">�Ҥҵ��˹���</font></td>
                        <td style="border: 1px solid #000000; text-align: center">
                            <font color="black" size="2">��ǹŴ</font></td>
                        <td style="border: 1px solid #000000; text-align: center">
                            <font color="black" size="2">�ӹǹ�Թ</font></td>
                    </tr>

                    <tr>
                    
                        <td style="border: 1px solid #000000; height:200px;  text-align: center; ">
                        <div style="height:220px;padding-top:5px">
                         <?php
                        $row_count = 0;
                        $objQuery_V_EKKO = mysql_query($strSQL2) or die (mysql_error());
	                    while($objResult = mysql_fetch_array($objQuery_V_EKKO))
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
                          <div style="height:200px;padding-top:5px">
                        <?php
                        $objQuery_V_EKKO = mysql_query($strSQL2) or die (mysql_error());
                        while($objResult = mysql_fetch_array($objQuery_V_EKKO))
                        { 
                        ?>
                       </br>
                            <font color="black" size="2"> <?=$objResult["matnr"];?></font></br>
                        <?php  
                         }
                        ?>
                         </div>     &nbsp;</td>
                        <td style="border: 1px solid #000000; text-align: center ;width: 133px;">
                          <div style="height:200px;padding-top:5px">
                        <?php
                        $objQuery_V_EKKO = mysql_query($strSQL2) or die (mysql_error());
                        while($objResult = mysql_fetch_array($objQuery_V_EKKO))
                        { 
                        ?>
                       </br>
                            <font color="black" size="2"> <?=$objResult["maktx"];?></font></br>
                        <?php  
                         }
                        ?>
                         </div>     &nbsp;</td>
                        <td style="border: 1px solid #000000; text-align: center">
                          <div style="height:200px;padding-top:5px">
                         <?php
                        $objQuery_V_EKKO = mysql_query($strSQL2) or die (mysql_error());
                        while($objResult = mysql_fetch_array($objQuery_V_EKKO))
                        { 
                        ?>
                       </br>
                            <font color="black" size="2"> <?=$objResult["menge"];?></font></br>
                        <?php  
                         }
                        ?>
                          </div>    &nbsp;</td>
                        <td style="border: 1px solid #000000; text-align: center">
                          <div style="height:200px;padding-top:5px">
                         <?php
                        $objQuery_V_EKKO = mysql_query($strSQL2) or die (mysql_error());
                        while($objResult = mysql_fetch_array($objQuery_V_EKKO))
                        { 
                        ?>
                       </br>
                            <font color="black" size="2"> <?=$objResult["meins"];?></font></br>
                        <?php  
                         }
                        ?>
                          </div>    &nbsp;</td>
                        <td style="border: 1px solid #000000; text-align: center; width: 155px;">
                          <div style="height:200px;padding-top:5px">
                         <?php
                        $objQuery_V_EKKO = mysql_query($strSQL2) or die (mysql_error());
                        while($objResult = mysql_fetch_array($objQuery_V_EKKO))
                        { 
                        ?>
                       </br>
                            <font color="black" size="2"> <?=$objResult["unitp"];?></font></br>
                        <?php  
                         }
                        ?>
                          </div>    &nbsp;</td>
                        <td style="border: 1px solid #000000; text-align: center">
                          <div style="height:200px;padding-top:5px">
                         <?php
                        $objQuery_V_EKKO = mysql_query($strSQL2) or die (mysql_error());
                        while($objResult = mysql_fetch_array($objQuery_V_EKKO))
                        { 
                        ?>
                       </br>
                            <font color="black" size="2"> <?=$objResult["dismt"];?></font></br>
                        <?php  
                         }
                        ?>
                           </div>   &nbsp;</td>
                        <td style="border: 1px solid #000000; text-align: center">
                          <div style="height:200px;padding-top:5px">
                         <?php
                        $objQuery_V_EKKO = mysql_query($strSQL2) or die (mysql_error());
                        $total_money = 0;
                        while($objResult = mysql_fetch_array($objQuery_V_EKKO))
                        { $total_money = $total_money + $objResult["total_per_menge"];
                        ?>
                       </br>
                            <font color="black" size="2"> <?=$objResult["total_per_menge"];?></font></br>
                        <?php  
                         }
                        ?>
                           </div> &nbsp;</td>
                    </tr>

                    <tr>
                        <td style="border: 0px solid #000000;  text-align: left" colspan="4"><font color="black" size="2">�����˵�</font>
                            &nbsp;</td>
                        <td style="border: 1px solid #000000; text-align: left" colspan="3"><font color="black" size="2">����Թ</font></td>
                        <td style="border: 1px solid #000000; text-align: center">
                       <font color="black" size="2"> <?=$total_money;?></font></br>
                            &nbsp;</td>
                    </tr>

                    <tr>
                        <td style="border: 0px solid #000000;  text-align: center" colspan="4">
                            &nbsp;</td>
                        <td style="border: 1px solid #000000; text-align: left" colspan="3">
                            <font color="black" size="2">��ǹŴ</font></td>
                        <td style="border: 1px solid #000000; text-align: center">
                            &nbsp;</td>
                    </tr>

                    <tr>
                        <td style="border: 0px solid #000000;  text-align: center" colspan="4">
                            &nbsp;</td>
                        <td style="border: 1px solid #000000; text-align: left" colspan="3">
                            <font color="black" size="2">�ӹǹ�Թ��ѧ�ѡ��ǹŴ</font></td>
                        <td style="border: 1px solid #000000; text-align: center">
                            &nbsp;</td>
                    </tr>

                    <tr>
                        <td style="border: 0px solid #000000;  text-align: center" colspan="4">
                            &nbsp;</td>
                        <td style="border: 1px solid #000000; text-align: left" colspan="3">
                            <font color="black" size="2">�Թ�Ѵ��</font></td>
                        <td style="border: 1px solid #000000; text-align: center">
                            &nbsp;</td>
                    </tr>

                    <tr>
                        <td style="border: 0px solid #000000;  text-align: center" colspan="4">
                            &nbsp;</td>
                        <td style="border: 1px solid #000000; text-align: left" colspan="3">
                            <font color="black" size="2">��ѧ�ѡ�Ѵ��</font></td>
                        <td style="border: 1px solid #000000; text-align: center">
                            &nbsp;</td>
                    </tr>

                    <tr>
                        <td style="border: 0px solid #000000;  text-align: center" colspan="4">
                            &nbsp;</td>
                        <td style="border: 1px solid #000000; text-align: left" colspan="3">
                          
                            <font color="black" size="2">������Ť������</font></td>
                        <td style="border: 1px solid #000000; text-align: center">
                            &nbsp;</td>
                    </tr>

                    <tr>
                        <td style="border: 0px solid #000000;  text-align: center" colspan="4">
                            &nbsp;</td>
                        <td style="border: 1px solid #000000; text-align: left" colspan="3">
                            <font color="black" size="2">��͹�ѡ���� � ������</font></td>
                        <td style="border: 1px solid #000000; text-align: center">
                            &nbsp;</td>
                    </tr>

                    <tr>
                        <td style="border: 0px solid #000000;  text-align: center" colspan="4">
                            &nbsp;</td>
                        <td style="border: 1px solid #000000; text-align: left" colspan="3">
                            <font color="black" size="2">�����ѡ � ������</font></td>
                        <td style="border: 1px solid #000000; text-align: center">
                            &nbsp;</td>
                    </tr>

                    <tr>
                        <td style="border: 0px solid #000000;  text-align: center" colspan="4">
                            &nbsp;</td>
                        <td style="border: 1px solid #000000; text-align: left" colspan="3">
                            <font color="black" size="2">�ӹǹ�Թ����ͧ����</font></td>
                        <td style="border: 1px solid #000000; text-align: center">
                            &nbsp;</td>
                    </tr>

                    <tr>
                        <td style="border: 1px solid #000000;  text-align: center">
                            <font color="black" size="2">�Թʴ</font></td>
                        <td style="border: 1px solid #000000; text-align: center; width: 133px;">
                            <font color="black" size="2">��Ҥ��</font></td>
                        <td style="border: 1px solid #000000; text-align: center" colspan="2">
                            <font color="black" size="2">�Ң�</font></td>
                        <td style="border: 1px solid #000000; text-align: center" colspan="2">
                            <font color="black" size="2">�ѹ���</font></td>
                        <td style="border: 1px solid #000000; text-align: center">
                            <font color="black" size="2">�Ţ���</font></td>
                        <td style="border: 1px solid #000000; text-align: center">
                            <font color="black" size="2">�ӹǹ�Թ</font></td>
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
                           <font color="black" size="2"> <?=$total_money;?></font></br>
                            &nbsp;</td>
                    </tr>

                    <tr>
                        <td style="border: 1px solid #000000; height:40px;  text-align: left" colspan="8">
                            <font color="black" size="2">(�ӹǹ�Թ ����ѡ��)</font></td>
                            &nbsp;</td>
                    </tr>

                    </table>
            <table style="width: 100%;border-collapse: collapse;">
                <tr>
                    <td style="text-align: center; height:100px; border: 1px solid #000000; width: 161px;"> <div><font color="black" size="2">___________________</font></div></br> <div><font color="black" size="2">����Ѻ�ͧ ....../....../......</font></div> </td>
                    <td style="text-align: center; border: 1px solid #000000"><div><font color="black" size="2">___________________</font></div></br> <div><font color="black" size="2">����觢ͧ ....../....../......</font></div> </td>
                    <td style="text-align: center; border: 1px solid #000000"><div><font color="black" size="2">___________________</font></div></br> <div><font color="black" size="2">������ӹҨŧ���</font></div> </td>
                    <td style="text-align: center; border: 1px solid #000000"><div><font color="black" size="2">___________________</font></div></br> <div><font color="black" size="2">����Ѻ�Թ</font></div> </td>
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
</html>
<?
mysql_close($objConnect);
?>
