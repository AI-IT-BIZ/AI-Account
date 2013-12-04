<?php 
     class Configauthen extends CI_Controller {
        
        function index()
     	{
     	    $func = $_GET['func'];
          
            if($func == "GetUserAuthen")
            {
               $strAutx = "";
               $strResult = "";
     	       $empnr = $_GET['empnr'];
     	       $strSQL = " Select tbl_doct.doctx ,tbl_doct.docty,tbl_autx.autex  ";
               $strSQL = $strSQL . " From tbl_doct ";
               $strSQL = $strSQL . " Left Join tbl_autx on tbl_doct.docty = tbl_autx.docty and tbl_autx.empnr = '" . $empnr . "'  ";
               
	 	       $query = $this->db->query($strSQL);
               foreach ($query->result() as $row)
               {
                  if($row->autex == "") 
                  {
                     $strAutx = "0" . "+" . "0" . "+" . "0" . "+" . "0" . "+" . "0";  
                
                  }
                  else
                  {
                     $strAutx =  substr($row->autex , -5,1) . "+" . substr($row->autex , -4,1) . "+" . substr($row->autex , -3 ,1) . "+" . substr($row->autex, -2 ,1) . "+" . substr($row->autex , -1 ,1) ;
                  }

                  $strResult = $strResult . $row->doctx . "+" . $row->docty . "+" . $strAutx . "|";
               }
               if( $strResult != "" )
               {
                  $strResult  = substr($strResult,0 ,strlen($strResult) -1)  ;
               }
        
               echo $strResult;
               return;
            }
            /*******************************************/
            if($func == "GetSaveEditApprove")
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
               
             // 
               $query = $this->db->query($strSQL);   
               $strSQL = " Delete From tbl_autx Where empnr = '" . $empnr . "';";
               $query = $this->db->query($strSQL);
               $arrAuthen = explode("|", $authen);
               foreach($arrAuthen as $myAuthen) 
               {
                  $arrRec = explode(" ", $myAuthen);
                  $strSQL =  "Insert into tbl_autx(empnr,docty,autex) Values('" . $empnr . "','" . $arrRec[0] . "','" . $arrRec[1] . "');"     ;         
                //  $strSQL = $strSQL . "Insert into tbl_autx(uname,docty,autex) Values('" . $empnr . "','" . $myAuthen ;
                    $query = $this->db->query($strSQL);
               }
              // $query = $this->db->query($strSQL);
               echo "1";
             // echo $strSQL;
              return;
            }
            /*******************************************/
            if($func == "GetEmployee")
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
                return;
            }
     	   
	    }

     }
?>