<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
     class Login extends CI_Controller {
        
        function index()
     	{
     	    
            
	    }
        function GetCompany()
        { 
            $strResult = "";
            $strSQL = "Select comid,name1 from tbl_comp;";
            $query = $this->db->query($strSQL);
            foreach ($query->result() as $row)
            {
               $strResult = $strResult . $row->comid . "+" . $row->name1 . "|";
            }
            if( $strResult != "" )
            {
               $strResult  = substr($strResult,0 ,strlen($strResult) -1)  ;
            }
        
            echo $strResult;
        }
        function CheckLogin()
        {
             $strResult = "";
             $uname = $_GET['uname'];
             $passw = $_GET['passw'];
             $comid = $_GET['comid'];
                 //$strSQL = "Select comid,uname,passw from tbl_user Where uname = '" . $uname . "' and passw = '" . $passw . "' and comid = '" . $comid . "';";
                
                
             $strSQL = " Select tbl_user.comid,tbl_user.uname,tbl_user.passw , tbl_autx.docty , ";
             $strSQL = $strSQL . " MID(autex,1,1) 'display',MID(autex,2,1) 'create',MID(autex,3,1) 'edit', ";
             $strSQL = $strSQL . " MID(autex,4,1) 'delete',MID(autex,5,1) 'export',MID(autex,6,1) 'approve' ";
             $strSQL = $strSQL . " from tbl_user  ";
             $strSQL = $strSQL . " Left Join tbl_autx On tbl_user.empnr = tbl_autx.empnr ";
             $strSQL = $strSQL . " Where tbl_user.uname = '" . $uname . "'  ";  
             $strSQL = $strSQL . " and tbl_user.passw = '" . $passw . "'  "; 
             $strSQL = $strSQL . " and tbl_user.comid = '" . $comid . "' "; 
                
                
             $query = $this->db->query($strSQL);
             foreach ($query->result() as $row)
             {
                $strResult = $strResult . $row->comid . "+" . $row->uname . "+" . $row->passw . "+" . $row->docty . "+" ;
                $strResult = $strResult . $row->display . "+" . $row->create . "+" . $row->edit . "+";
                $strResult = $strResult . $row->delete . "+" . $row->export . "+" . $row->approve . "|";
             }
             if( $strResult != "" )
             {
                $strResult  = substr($strResult,0 ,strlen($strResult) -1)  ;
             }
        
             echo $strResult;
        }
     }
?>
