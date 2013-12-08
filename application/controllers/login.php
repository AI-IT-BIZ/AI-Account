<?php 
 class Login extends CI_Controller {
        
        function index()
     	{
     	    $func = $_GET['func'];
            if($func == "GetCompany")
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
                 return;
                
            }
            if($func == "Login")
            {
                 $strResult = "";
                 $uname = $_GET['uname'];
                 $passw = $_GET['passw'];
                 $comid = $_GET['comid'];
                 //$strSQL = "Select comid,uname,passw from tbl_user Where uname = '" . $uname . "' and passw = '" . $passw . "' and comid = '" . $comid . "';";
                
                
                 $strSQL = " Select tbl_user.comid,tbl_user.uname,tbl_user.passw , tbl_autx.docty , LEFT(autex,1) display ";
                 $strSQL = $strSQL . " from tbl_user  ";
                 $strSQL = $strSQL . " Left Join tbl_autx On tbl_user.empnr = tbl_autx.empnr ";
                 $strSQL = $strSQL . " Where tbl_user.uname = '" . $uname . "'  ";  
                 $strSQL = $strSQL . " and tbl_user.passw = '" . $passw . "'  "; 
                 $strSQL = $strSQL . " and tbl_user.comid = '" . $comid . "' "; 
                
                
                $query = $this->db->query($strSQL);
                 foreach ($query->result() as $row)
                 {
                    $strResult = $strResult . $row->comid . "+" . $row->uname . "+" . $row->passw . "+" . $row->docty . "+" . $row->display . "|";
                 }
                 if( $strResult != "" )
                 {
                    $strResult  = substr($strResult,0 ,strlen($strResult) -1)  ;
                 }
        
                 echo $strResult;
                 return;
                
            }
        }
        
}
?>