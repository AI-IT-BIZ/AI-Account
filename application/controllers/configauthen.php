<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
     class Configauthen extends CI_Controller {
        
        function index()
     	{
     	    
            
	    }
        function GetEmployee()
        {
            $strResult = "";
            $strSQL = " Select tbl_empl.empnr,tbl_empl.name1,tbl_empl.email,tbl_empl.postx, ";
            $strSQL = $strSQL . " tbl_empl.deptx, tbl_user.uname , tbl_user.passw ";
            $strSQL = $strSQL . " from tbl_empl ";
            $strSQL = $strSQL . " Left Join tbl_user on tbl_empl.empnr = tbl_user.empnr ";
            $query = $this->db->query($strSQL);
            foreach ($query->result() as $row)
            {  
               $strResult = $strResult . $row->empnr . "+" . $row->name1 . "+" . $row->email . "+" . $row->postx . "+" . $row->deptx . "+" . $row->uname . "+" . $row->passw   . "|";
            }
            echo $strResult;   
        }
        function GetUserAuthen()
        {
            $strAutx = "";
            $strResult = "";
	        $empnr = $_GET['empnr'];
            $comid = "1000";
 	        $strSQL = " Select tbl_doct.doctx ,tbl_doct.docty,tbl_autx.autex  ";
            $strSQL = $strSQL . " From tbl_doct ";
            $strSQL = $strSQL . " Left Join tbl_autx on tbl_doct.docty = tbl_autx.docty and tbl_autx.empnr = '" . $empnr . "'  ";
              // $strSQL = $strSQL . " Where "
            $strSQL = $strSQL . " Order by tbl_doct.doctx ASC ";
	 	    $query = $this->db->query($strSQL);
            foreach ($query->result() as $row)
            {
               if($row->autex == "") 
               {
                  $strAutx =  "0" . "+" . "0" . "+" . "0" . "+" . "0" . "+" . "0" . "+" . "0";  
                
               }
               else
               {
                   $strAutx =  substr($row->autex , -6,1) . "+" . substr($row->autex , -5,1) . "+" . substr($row->autex , -4,1) . "+" . substr($row->autex , -3 ,1) . "+" . substr($row->autex, -2 ,1) . "+" . substr($row->autex , -1 ,1) ;
               }

               $strResult = $strResult . $row->doctx . "+" . $row->docty . "+" . $strAutx . "|";
            }
            if( $strResult != "" )
            {
               $strResult  = substr($strResult,0 ,strlen($strResult) -1)  ;
            }
        
            echo $strResult; 
        }
        function GetSaveEditApprove()
        {
            $empnr = $_GET['empnr'];
            $uname = $_GET['uname'];
            $passw = $_GET['passw'];
            $authen = $_GET['authen'];
            $sCount = 0;
               
            $strSQL = "select uname from tbl_user;";
            $query = $this->db->query($strSQL);  
            foreach ($query->result() as $row)
            {
                $sCount = $sCount + 1;
            }
            if($sCount > 0)
            {
                $strSQL = " Update tbl_user Set uname ='" . $uname . "' , passw = '" . $passw . "' Where empnr = '" . $empnr . "';";
            }
            else{
                $strSQL =  "Insert into tbl_user(empnr,uname,passw) Values('" . $empnr . "','" . $uname . "','" . $passw . "');";
            }
               
            $query = $this->db->query($strSQL);   
            $strSQL = " Delete From tbl_autx Where empnr = '" . $empnr . "';";
            $query = $this->db->query($strSQL);
            $arrAuthen = explode("|", $authen);
            foreach($arrAuthen as $myAuthen) 
            {
                $arrRec = explode(" ", $myAuthen);
                $strSQL =  "Insert into tbl_autx(empnr,docty,autex) Values('" . $empnr . "','" . $arrRec[0] . "','" . $arrRec[1] . "');"     ;         
                $query = $this->db->query($strSQL);
            }
            echo "1";
        }
        
        /*PanelAuthenDoc*************************************/
        
        function GET_TBL_DOCT()
        {
            $strResult = "";
                
            $strSQL = " SELECT TRIM(grptx) grptx,TRIM(doctx) doctx,TRIM(docty) docty,TRIM(grpmo) grpmo  ";
            $strSQL = $strSQL . " FROM tbl_doct order by TRIM(grptx) , TRIM(docty) asc; ";
            $query = $this->db->query($strSQL);
            foreach ($query->result() as $row)
            {
                    
                $strResult = $strResult . $row->grptx . "+" . $row->docty . "+" . $row->doctx . "+" . $row->grpmo  . "|";
                
            }
            if( $strResult != "" )
            {
                $strResult  = substr($strResult,0 ,strlen($strResult) -1)  ;
            }
            echo $strResult;   
        }
        function GET_TBL_AMOU()
        {
            $strResult = "";
                
            $docty = $_GET['docty'];
            $strSQL = " Select tbl_amou.*,tbl_doct.grptx ";
            $strSQL = $strSQL . " From tbl_amou ";
            $strSQL = $strSQL . " Left Join tbl_doct on tbl_amou.docty = tbl_doct.docty ";
            $strSQL = $strSQL . " Where tbl_amou.docty = '" . $docty . "' ";
            $CountRow = 0;
            $query = $this->db->query($strSQL);
            foreach ($query->result() as $row)
            {
               $CountRow = $CountRow +1;
               $strResult = $strResult . $CountRow . "+" . $row->amoid . "+" . $row->rowid . "+" . $row->grptx . "+" . $row->docty . "+" . $row->liamo  . "|";
            }
            if( $strResult != "" )
            {
               $strResult  = substr($strResult,0 ,strlen($strResult) -1)  ;
            }
            echo $strResult;
        }
        function GET_TBL_AUAM()
        {
            $strResult = "";
            $CountRow = 0;
            $amoid = $_GET['amoid'];
            $strSQL = " Select tbl_auam.*,tbl_empl.name1,tbl_empl.postx,tbl_empl.deptx ";
            $strSQL = $strSQL . " from tbl_auam ";
            $strSQL = $strSQL . " left join tbl_empl on tbl_auam.empnr = tbl_empl.empnr ";
            $strSQL = $strSQL . " Where tbl_auam.amoid = '" . $amoid . "' ";
            $strSQL = $strSQL . " Order By tbl_auam.levid asc ";
               
            $query = $this->db->query($strSQL);
            foreach ($query->result() as $row)
            {
                $CountRow = $CountRow + 1;
                $strResult = $strResult . $CountRow  . "+" . $row->levid . "+" . $row->amoid . "+" . $row->empnr . "+" . $row->name1 . "+" . $row->postx . "+" . $row->deptx  . "|";
            }
            if( $strResult != "" )
            {
                $strResult  = substr($strResult,0 ,strlen($strResult) -1)  ;
            }
            echo $strResult;
            return;
        }
        function GET_EMPL_APPROVE()
        {
           $strResult = "";
           $docty = $_GET['docty'];
          
                 
           $strSQL = " Select distinct tbl_empl.* ";
           $strSQL = $strSQL . " From tbl_empl ";
           $strSQL = $strSQL . " Inner Join tbl_autx On tbl_empl.empnr = tbl_autx.empnr ";
           $strSQL = $strSQL . " Where tbl_autx.docty = '" . $docty . "' ";
           $strSQL = $strSQL . " And RIGHT(tbl_autx.autex,1) = '1' ";
                 
           $query = $this->db->query($strSQL);
           foreach ($query->result() as $row)
           {
              $strResult = $strResult .  $row->empnr . "+" . $row->name1 . "+" . $row->postx . "+" . $row->deptx . "|";
           }
           if( $strResult != "" )
           {
               $strResult  = substr($strResult,0 ,strlen($strResult) -1)  ;
           }
           echo $strResult; 
            
        }
        function GetSaveAmount()
        {
            //  $MaxKey = GetMaxKey("tbl_amou","amoid","AM","00000","");
            $strTable = "tbl_amou";
            $strField = "amoid";
            $strTypeID = "AM";
            $numID = 0;
            $myID = "";
            $strSQL = "Select MAX(" . $strField . ") MaxKEY From " . $strTable . " Where " . $strField . " Like '" . $strTypeID . "-%'";
            $query = $this->db->query($strSQL);
            foreach ($query->result() as $row) 
            {
               if($row->MaxKEY == "")
               {
                  $numID = 0;
               } 
               else
               {
                  $numID = str_replace($strTypeID . "-","" ,$row->MaxKEY);
               }
                  
            }
            $numID = $numID + 1;
            $MaxKey = $strTypeID . "-" . sprintf("%05s",$numID);
            /******************************************************/
            $rowid =  $_GET['rowid'];
            $docty =  $_GET['docty'];
            $liamo =  $_GET['liamo'];
            $strSQL = " Insert into tbl_amou(amoid,rowid,docty,liamo) Values('" . $MaxKey . "'," . $rowid . ",'" . $docty . "'," . $liamo . ");";
            $query = $this->db->query($strSQL);
                 
            /****************************************************************/
                 
            $strResult = "";
                
            $docty = $_GET['docty'];
            $strSQL = " Select tbl_amou.*,tbl_doct.grptx ";
            $strSQL = $strSQL . " From tbl_amou ";
            $strSQL = $strSQL . " Left Join tbl_doct on tbl_amou.docty = tbl_doct.docty ";
            $strSQL = $strSQL . " Where tbl_amou.docty = '" . $docty . "' ";
            $CountRow = 0;
            $query = $this->db->query($strSQL);
            foreach ($query->result() as $row)
            {
               $CountRow = $CountRow +1;
               $strResult = $strResult . $CountRow . "+" . $row->amoid . "+" . $row->rowid . "+" . $row->grptx . "+" . $row->docty . "+" . $row->liamo  . "|";
            }
            if( $strResult != "" )
            {
                $strResult  = substr($strResult,0 ,strlen($strResult) -1)  ;
            }
            echo $strResult;
        }
        function GetSaveEmplAuthen()
        {
            $levid = $_GET['levid'];
            $amoid = $_GET['amoid'];
            $empnr = $_GET['empnr'];
            $strSQL = "Delete From tbl_auam Where amoid = '" .$amoid . "' and empnr = '" . $empnr . "';";
            $query = $this->db->query($strSQL);
            $strSQL = " Insert into tbl_auam(levid,amoid,empnr) Values('" . $levid . "','" . $amoid. "','" . $empnr . "');";
            $query = $this->db->query($strSQL);
            echo "Save Complete";
            
        }
        function DeleteAmount()
        {
            $amoid = $_GET['amoid'];
            $strSQL = "Delete from tbl_amou Where amoid = '" .$amoid . "';";
            $query = $this->db->query($strSQL);
            $strSQL = "Delete from tbl_auam Where amoid = '" .$amoid . "';";
            $query = $this->db->query($strSQL);
            echo "Delete Complete";
        }
        function DeleteEmplAuthen()
        {
            $amoid = $_GET['amoid'];
            $empnr= $_GET['empnr'];
            $strSQL = "Delete from tbl_auam Where amoid = '" .$amoid . "' And empnr = '" . $empnr . "';";
            $query = $this->db->query($strSQL);
            echo "Delete Complete";
        }
       
     }
?>