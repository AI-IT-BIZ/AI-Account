<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
     class ChartofAccounts extends CI_Controller {
        
        function index()
     	{
     	}  
	function GetTreeChart()
        {
           $strSQL = "Select * from tbl_glno Where gllev = 1 order by saknr asc ;";
           $queryL1 = $this->db->query($strSQL);
           $strSQL = "Select * from tbl_glno Where gllev = 2 order by saknr asc ;";
           $queryL2 = $this->db->query($strSQL);
           $strSQL = "Select * from tbl_glno Where gllev = 3 order by saknr asc ;";
           $queryL3 = $this->db->query($strSQL);
           $strSQL = "Select * from tbl_glno Where gllev = 4 order by saknr asc ;";
           $queryL4 = $this->db->query($strSQL);
           $strSQL = "Select * from tbl_glno Where gllev = 5 order by saknr asc ;";
           $queryL5 = $this->db->query($strSQL);
           
           $saknrL1 = "";
           $saknrL2 = "";
           $saknrL3 = "";
           $saknrL4 = "";
           $saknrL5 = "";
           $arrL1 = array();
           $leaf1 = "";
           $strText = "";

           foreach ($queryL1->result() as $rowL1)
           {  
            
              /************************************/
              /*Level2 **************************/
              $saknrL1 =  $rowL1->saknr;
              $arrChild  = array();  
              foreach ($queryL2->result() as $rowL2)
              {
                  if($saknrL1 == $rowL2->overs)
                  {
                      
                  
                  /*Level3 **************************/
                  $saknrL2 =  $rowL2->saknr;
                  $arrChild3  = array(); 
                  foreach ($queryL3->result() as $rowL3)
                  {  
                    if($saknrL2 == $rowL3->overs)
                    {
                        
                    
                    /*Level4 **************************/
                    $saknrL3 =  $rowL3->saknr;
                    $arrChild4  = array(); 
                    foreach ($queryL4->result() as $rowL4)
                    {
                        if($saknrL3 == $rowL4->overs)
                        {
                        
                       
                        /*Level5 **************************/
                        $saknrL4 =  $rowL4->saknr;
                        $arrChild5  = array(); 
                        foreach ($queryL5->result() as $rowL5)
                        {
                            if($saknrL4 == $rowL5->overs)
                            {
                                $strText = $rowL5->saknr . "[" . $rowL5->depar  . "]" . $rowL5->sgtxt;
                                $leaf1 = ($rowL5->gltyp == "1") ? "false" : "true";
                                array_push($arrChild5, array('text' => $strText, 'leaf' => $leaf1 , 'id' => $rowL5->saknr ));
                            }
                            
                        }
                        $strText = $rowL4->saknr. "[" . $rowL4->depar  . "]" . $rowL4->sgtxt;
                        $leaf1 = ($rowL4->gltyp == "1") ? "false" : "true";
                        array_push($arrChild4, array('text' => $strText, 'leaf' => $leaf1 , 'id' => $rowL4->saknr  , 'expanded' => true ,  'children' => $arrChild5  ));
                         }
                    }
                     $strText = $rowL3->saknr. "[" . $rowL3->depar  . "]" . $rowL3->sgtxt;
                     $leaf1 = ($rowL3->gltyp == "1") ? "false" : "true";
                     array_push($arrChild3, array('text' => $strText, 'leaf' => $leaf1 , 'id' => $rowL3->saknr  , 'expanded' => true , 'children' => $arrChild4 ));
                    }
                  }
                  $strText = $rowL2->saknr. "[" . $rowL2->depar  . "]" . $rowL2->sgtxt;
                  $leaf1 = ($rowL2->gltyp == "1") ? "false" : "true";
                  array_push($arrChild, array('text' => $strText, 'leaf' => $leaf1 , 'id' => $rowL2->saknr  ,  'expanded' => true , 'children' => $arrChild3));
                }
              }
              /************************************/
              $strText = $rowL1->saknr. "[" . $rowL1->depar  . "]" . $rowL1->sgtxt;
              $leaf1 = ($rowL1->gltyp == "1") ? "false" : "true";
              array_push($arrL1, array('text' => $strText, 'leaf' => $leaf1 , 'id' => $rowL1->saknr , 'expanded' => true ,  'children' => $arrChild ));
           }
           
           $arrxx = array($arrL1);
           echo json_encode($arrL1);
        }
         
        function GetTreeChart_OLD()
     	{
     
           $strSQL = "Select * from tbl_glno Where gllev = 1 order by saknr asc ;";
           $leaf1 = "";
           $queryL1 = $this->db->query($strSQL);
           $arrL1 = array();
           $arrChild  = array();
           $strText = "";
       
           foreach ($queryL1->result() as $rowL1)
           {  
            
              /************************************/
              /*Level2 **************************/
              $strSQL = " Select * from tbl_glno Where gllev = 2 And overs = '" . $rowL1->saknr . "' order by overs desc ;"; 
              $queryL2 = $this->db->query($strSQL);
              $arrChild  = array();  
              foreach ($queryL2->result() as $rowL2)
              {
                  /*Level3 **************************/
                  $strSQL = " Select * from tbl_glno Where gllev = 3 And overs = '" . $rowL2->saknr . "' order by overs desc;"; 
                  $queryL3 = $this->db->query($strSQL);
                  $arrChild3  = array(); 
                  foreach ($queryL3->result() as $rowL3)
                  {  
                    
                    /*Level4 **************************/
                    $strSQL = " Select * from tbl_glno Where gllev = 4 And overs = '" . $rowL3->saknr . "' order by overs desc;"; 
                    $queryL4 = $this->db->query($strSQL);
                    $arrChild4  = array(); 
                    foreach ($queryL4->result() as $rowL4)
                    {
                        /*Level5 **************************/
                        $strSQL = " Select * from tbl_glno Where gllev = 5 And overs = '" . $rowL4->saknr . "' order by overs desc;"; 
                        $queryL5 = $this->db->query($strSQL);
                        $arrChild5  = array(); 
                        foreach ($queryL5->result() as $rowL5)
                        {
                            $strText = $rowL5->saknr . "[" . $rowL5->depar  . "]" . $rowL5->sgtxt;
                            $leaf1 = ($rowL5->gltyp == "1") ? "false" : "true";
                            array_push($arrChild5, array('text' => $strText, 'leaf' => $leaf1 , 'id' => $rowL5->saknr ));
                        }
                        $strText = $rowL4->saknr. "[" . $rowL4->depar  . "]" . $rowL4->sgtxt;
                        $leaf1 = ($rowL4->gltyp == "1") ? "false" : "true";
                        array_push($arrChild4, array('text' => $strText, 'leaf' => $leaf1 , 'id' => $rowL4->saknr  , 'expanded' => true ,  'children' => $arrChild5  ));
                    }
                     $strText = $rowL3->saknr. "[" . $rowL3->depar  . "]" . $rowL3->sgtxt;
                     $leaf1 = ($rowL3->gltyp == "1") ? "false" : "true";
                     array_push($arrChild3, array('text' => $strText, 'leaf' => $leaf1 , 'id' => $rowL3->saknr  , 'expanded' => true , 'children' => $arrChild4 ));
                  }
                  $strText = $rowL2->saknr. "[" . $rowL2->depar  . "]" . $rowL2->sgtxt;
                  $leaf1 = ($rowL2->gltyp == "1") ? "false" : "true";
                  array_push($arrChild, array('text' => $strText, 'leaf' => $leaf1 , 'id' => $rowL2->saknr  ,  'expanded' => true , 'children' => $arrChild3));
              }
              /************************************/
              $strText = $rowL1->saknr. "[" . $rowL1->depar  . "]" . $rowL1->sgtxt;
              $leaf1 = ($rowL1->gltyp == "1") ? "false" : "true";
              array_push($arrL1, array('text' => $strText, 'leaf' => $leaf1 , 'id' => $rowL1->saknr , 'expanded' => true ,  'children' => $arrChild ));
           }
        /*******************************************************/
     	   //$arr = array('text' => 'detention', 'leaf' => false);
            $arrxx = array($arrL1);
         	echo json_encode($arrL1);
          
         
	    }
        function SaveTree()
        {
           
            
            /************************/
            $treid = $_GET['treid'];
            $gllev = $_GET['level'];
           // $text1 = $_GET['text1'];
           // $leaf1 = $_GET['leaf1'];
          //  $child = $_GET['child'];
            $saknr = $_GET['accid'];
            $sgtxt = $_GET['tname'];
            $entxt = $_GET['ename'];
            $gltyp = $_GET['accty'];
            $overs = $_GET['accgr'];
            $depar = $_GET['deptx'];
            if($treid == "")
            {
                
                
                $strSQL = " Insert into tbl_glno(saknr,gllev,gltyp,";
                $strSQL = $strSQL . " sgtxt,entxt,overs,depar) Values('";
                $strSQL = $strSQL . $saknr . "','" . $gllev . "','" . $gltyp . "','";
                $strSQL = $strSQL . $sgtxt . "','" . $entxt . "','" . $overs . "','" . $depar . "') ";
                $query = $this->db->query($strSQL);
            }
            else
            {
               $strSQL = " Update tbl_glno Set gllev = '" . $gllev .  "' , saknr = '" . $saknr . "' , ";
               $strSQL = $strSQL . " sgtxt = '" . $sgtxt . "' , entxt = '" . $entxt . "' , gltyp = '" . $gltyp . "' , overs = '" . $overs . "' , depar = '" . $depar . "' ";
               $strSQL = $strSQL . " Where saknr = '" . $saknr . "' ;";
        
               $query = $this->db->query($strSQL);
            }
            echo "Save Complete";
        }
        function GetAccountChart()
        {
            $strSQL = "Select * from tbl_glno";
            $strResult = "";
            $leaf1 = "";
            $query = $this->db->query($strSQL);
            foreach ($query->result() as $row)
            {
                $leaf1 = ($rowL1->gltyp == "1") ? "false" : "true";
                $strResult = $strResult . $row->saknr . "+" . $row->gllev  . "+" . "" . "+" . $leaf1 . "+" . $row->overs . "+" . $row->saknr . "+";
                $strResult = $strResult . $row->sgtxt . "+" . $row->entxt . "+"  . $row->gltyp . "+"  . $row->overs . "+"  . $row->depar . "|" ;
            }
            if( $strResult != "" )
            {
                $strResult  = substr($strResult,0 ,strlen($strResult) -1)  ;
            }
            echo $strResult;
        }
        function GetGroupAccount()
        {
            $strSQL = "Select saknr,saknr from tbl_glno Where gltyp = '1';" ;
            $strResult = "";
            $query = $this->db->query($strSQL);
            foreach ($query->result() as $row)
            {
                $strResult = $strResult . $row->saknr . "+" . $row->saknr  . "|" ;
            }
            if( $strResult != "" )
            {
                $strResult  = substr($strResult,0 ,strlen($strResult) -1)  ;
            }
            echo $strResult;
        }
        function GetDepartment()
        {
              echo "000+000";
        }
     }
?>