<?php
     if (isset($_GET['phpfunction'])){
        
        $allow = array('GET_TBL_DOCT','GET_EMP','GET_TBL_AMOU','GET_TBL_AUAM','GetSaveAmount','GetSaveEmplAuthen');
        /*******************************************************/
        function GET_TBL_DOCT()
        { 
            $host = "127.0.0.1";
            $username = "root";
            $password = "grace15901";
            $objConnect = mysql_connect($host,$username,$password);

            $objDB = mysql_select_db("ai_account");

            $strSQL = " SELECT TRIM(grptx) grptx,TRIM(doctx) doctx,TRIM(docty) docty,TRIM(grpmo) grpmo FROM tbl_doct order by TRIM(grptx) , TRIM(docty) asc;  ";
            $objQuery = mysql_query($strSQL) or die (mysql_error());
            $strResult = "";
            
            
            /********************************************/
            
            while($objResult = mysql_fetch_array($objQuery))
            {
               $strResult = $strResult . $objResult["grptx"] . "+" . $objResult["docty"]  . "+" . $objResult["doctx"]  . "+" . $objResult["grpmo"] . "|";
            }
            
            mysql_close($objConnect);
            
            if( $strResult != "" )
            {
                $strResult  = substr($strResult,0 ,strlen($strResult) -1)  ;
            }
        
            return $strResult;
          
        }
        function GET_EMP($param)
        {
            $host = "127.0.0.1";
            $username = "root";
            $password = "grace15901";
            $objConnect = mysql_connect($host,$username,$password);

            $objDB = mysql_select_db("ai_account");

            $strSQL = " SELECT * FROM tbl_empl  ";
            if($param != "")
            {
                $strSQL = $strSQL . " Where deptx = '" . $param . "'";
            }
            $objQuery = mysql_query($strSQL) or die (mysql_error());
            $strResult = "";
            
            
            while($objResult = mysql_fetch_array($objQuery))
            {
               $strResult = $strResult . $objResult["empnr"] . "+" . $objResult["name1"]  . "+" . $objResult["postx"] . "+" . $objResult["deptx"]  . "|";
            }
            
            mysql_close($objConnect);
            
            if( $strResult != "" )
            {
                $strResult  = substr($strResult,0 ,strlen($strResult) -1)  ;
            }
        
            return $strResult;
            
        }
        function GET_TBL_AMOU($docty)
        {
            $host = "127.0.0.1";
            $username = "root";
            $password = "grace15901";
            $objConnect = mysql_connect($host,$username,$password);

            $objDB = mysql_select_db("ai_account");

            $strSQL = " Select tbl_amou.*,tbl_doct.grptx ";
            $strSQL = $strSQL . " From tbl_amou ";
            $strSQL = $strSQL . " Left Join tbl_doct on tbl_amou.docty = tbl_doct.docty ";
            $strSQL = $strSQL . " Where tbl_amou.docty = '" . $docty . "' ";
            
            $objQuery = mysql_query($strSQL) or die (mysql_error());
            $strResult = "";
            
            
            while($objResult = mysql_fetch_array($objQuery))
            {
               $strResult = $strResult . $objResult["amoid"] . "+" .$objResult["rowid"] . "+"  . $objResult["grptx"]  . "+" . $objResult["docty"] . "+" . $objResult["liamo"]  . "|";
            }
            
            mysql_close($objConnect);
            
            if( $strResult != "" )
            {
                $strResult  = substr($strResult,0 ,strlen($strResult) -1)  ;
            }
        
            return $strResult;
            
        }
        function GET_TBL_AUAM($amoid)
        {
            $host = "127.0.0.1";
            $username = "root";
            $password = "grace15901";
            $objConnect = mysql_connect($host,$username,$password);

            $objDB = mysql_select_db("ai_account");

            $strSQL = " Select tbl_auam.*,tbl_empl.name1,tbl_empl.postx,tbl_empl.deptx ";
            $strSQL = $strSQL . " from tbl_auam ";
            $strSQL = $strSQL . " left join tbl_empl on tbl_auam.empnr = tbl_empl.empnr ";
            $strSQL = $strSQL . " Where tbl_auam.amoid = '" . $amoid . "' ";
            $strSQL = $strSQL . " Order By tbl_auam.levid asc ";
     
            
            $objQuery = mysql_query($strSQL) or die (mysql_error());
            $strResult = "";
            
            
            while($objResult = mysql_fetch_array($objQuery))
            {
               $strResult = $strResult . $objResult["levid"] . "+" .$objResult["amoid"] . "+"  . $objResult["empnr"]  . "+" . $objResult["name1"] . "+" . $objResult["postx"] . "+" . $objResult["deptx"]  . "|";
            }
            
            mysql_close($objConnect);
            
            if( $strResult != "" )
            {
                $strResult  = substr($strResult,0 ,strlen($strResult) -1)  ;
            }
        
            return $strResult;
            
        }
        function GetSaveAmount($strData )
        {  
            $arrData = explode("|" , $strData);
          
            $MaxKey = GetMaxKey("tbl_amou","amoid","AM","00000","");
            $sSql = " Insert into tbl_amou(amoid,rowid,docty,liamo) Values('" . $MaxKey . "'," . $arrData[0] . ",'" . $arrData[1] . "'," . $arrData[2] . ");";
            
           
            /************************/
            $host = "127.0.0.1";
            $username = "root";
            $password = "grace15901";
            $objConnect = mysql_connect($host,$username,$password);

            $objDB = mysql_select_db("ai_account");

            $strSQL = $sSql;
            
            $objQuery = mysql_query($strSQL) or die (mysql_error());
            $strResult = "";
            
          
        
            return $strResult;
            
        }
        function GetSaveEmplAuthen($strData )
        {  
            $arrData = explode("|" , $strData);
          
           // $MaxKey = GetMaxKey("tbl_auam","amoid","EA","00000","");
            $sSql = " Insert into tbl_auam(levid,amoid,empnr) Values('" . $arrData[0] . "','" . $arrData[1] . "','" . $arrData[2] . "');";
            
           
            /************************/
            $host = "127.0.0.1";
            $username = "root";
            $password = "grace15901";
            $objConnect = mysql_connect($host,$username,$password);

            $objDB = mysql_select_db("ai_account");

            $strSQL = $sSql;
            
            $objQuery = mysql_query($strSQL) or die (mysql_error());
            $strResult = "";
            
          
        
            return $strResult;
            
        }
        function GetMaxKey( $strTable,  $strField,  $strTypeID,  $strFormat,  $strWhere)
        {
              $host = "127.0.0.1";
              $username = "root";
              $password = "grace15901";
              $objConnect = mysql_connect($host,$username,$password);
              $objDB = mysql_select_db("ai_account");
               
              
              $numID = 0;
              $myID = "";
              $sSql = "Select MAX(" . $strField . ") MaxKEY From " . $strTable . " Where " . $strField . " Like '" . $strTypeID . "-%'";
              $objQuery = mysql_query($sSql) or die (mysql_error());
              while($objResult = mysql_fetch_array($objQuery))
              {
                  
                  if($objResult["MaxKEY"] == "")
                  {
                     $numID = 0;
                  } 
                  else
                  {
                     $numID = str_replace($strTypeID . "-","" ,$objResult["MaxKEY"]);
                  }
              }
              mysql_close($objConnect);
              $numID = $numID + 1;
              $myID = $strTypeID . "-" . sprintf("%05s",$numID);
              return $myID;
              
        }
        /***********************************************************************************/
        
        
        
        if (in_array($_GET['phpfunction'],$allow,true)){
	    	//เรียกใช้งาน function
	        	$param = json_decode($_GET['param']);
        	//	$value = call_user_func_array($_GET['phpfunction'],$param);
                switch ($_GET['phpfunction'])
                {
                    case "GET_TBL_DOCT":
                          $value = GET_TBL_DOCT();
                          break;
                          
                    case "GET_EMP":
                          $value = GET_EMP($param);
                          break;
                    case "GET_TBL_AMOU":
                          $value = GET_TBL_AMOU($param);
                          break;
                    case "GET_TBL_AUAM":
                          $value = GET_TBL_AUAM($param);
                          break;
                    case "GetSaveAmount":
                          $value = GetSaveAmount($param);
                          break;
                    case "GetSaveEmplAuthen":
                          $value = GetSaveEmplAuthen($param);
                          break;
                }
                
        
	    } 
        else {
	        	$value = 'error';
    	}
        
        
        
       	//ส่งค่า json string กลับไปให้ฝั่ง client
    	header('Content-type:application/json;charset=utf-8');
	    die( json_encode(compact('value')) );
        
        
     }


	
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<title></title>
 <style type="text/css">  

   .select {    border:1px solid red !important; } 

 </style> 
    <link href="../../css/style.css" rel="stylesheet" />
    <script type="text/javascript" src="../../jquery/jquery.js"></script>
    <script type="text/javascript" src="../../jquery/jquery.json-2.2.js"></script>
    <link href="../../ext/resources/css/ext-all.css" rel="stylesheet" />
    <script src="../../ext/ext-all.js"></script>
    <script type="text/javascript">
    

     Ext.require([
        'Ext.tip.QuickTipManager',
        'Ext.container.Viewport',
        'Ext.layout.*',
        'Ext.form.Panel',
        'Ext.form.Label',
        'Ext.grid.*',
        'Ext.data.*',
        'Ext.tree.*',
        'Ext.selection.CellModel',
        'Ext.selection.*',
        'Ext.tab.Panel',
        'Ext.ux.layout.Center',
        'Ext.form.field.ComboBox',
        'Ext.window.MessageBox',
        'Ext.form.FieldSet',
        'Ext.panel.Panel',
        'Ext.form.*',
        'Ext.window.Window',
        'Ext.util.*',
        'Ext.ux.FieldReplicator'

    ]);
 </script>
 
 <script type="text/javascript">
 
  function remoteFunction(name,parameter,callback){
		var value;
		var param = $.toJSON(parameter);
		//request แบบ synchronize
	  $.ajax({
	        url:'?phpfunction='+name+'&'+$.param({param:param}),
          //  url:'?phpfunction='+name,
			type:'GET',
			async:false,
			dataType:'json',
	    success:function(e){
	    	value = e.value;
			}
	  });
	  return value;
 }
 </script>
 
 <script type="text/javascript" src="../AuthenDoc/AuthenDoc-MainWindow.js"></script>


<head></head>
<body onload="PageLoad()">
 <div id="div_disable" style=" position: absolute; top: 0px; left: 0px; width:100%; height: 100%; visibility:hidden; background-color: #808080; filter:alpha(opacity=40); opacity:.30">   </div>

</body>
</html>