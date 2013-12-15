<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
     class ChartofAccounts extends CI_Controller {
        
        function index()
     	{
     	    
	    }
        function GetTreeChart()
     	{
     
           $strSQL = "Select * from tbl_glno Where level = 1 order by saknr asc ;";
           $queryL1 = $this->db->query($strSQL);
           $arrL1 = array();
           $arrChild  = array();
           $strText = "";
       
           foreach ($queryL1->result() as $rowL1)
           {  
            
              /************************************/
              /*Level2 **************************/
              $strSQL = " Select * from tbl_glno Where level = 2 And child = '" . $rowL1->treid . "' order by child desc ;"; 
              $queryL2 = $this->db->query($strSQL);
              $arrChild  = array();  
              foreach ($queryL2->result() as $rowL2)
              {
                  /*Level3 **************************/
                  $strSQL = " Select * from tbl_glno Where level = 3 And child = '" . $rowL2->treid . "' order by child desc;"; 
                  $queryL3 = $this->db->query($strSQL);
                  $arrChild3  = array(); 
                  foreach ($queryL3->result() as $rowL3)
                  {  
                    
                    /*Level4 **************************/
                    $strSQL = " Select * from tbl_glno Where level = 4 And child = '" . $rowL3->treid . "' order by child desc;"; 
                    $queryL4 = $this->db->query($strSQL);
                    $arrChild4  = array(); 
                    foreach ($queryL4->result() as $rowL4)
                    {
                        /*Level5 **************************/
                        $strSQL = " Select * from tbl_glno Where level = 5 And child = '" . $rowL4->treid . "' order by child desc;"; 
                        $queryL5 = $this->db->query($strSQL);
                        $arrChild5  = array(); 
                        foreach ($queryL5->result() as $rowL5)
                        {
                            $strText = $rowL5->saknr . "[" . $rowL5->depar  . "]" . $rowL5->sgtxt;
                            array_push($arrChild5, array('text' => $strText, 'leaf' => $rowL5->leaf1 , 'id' => $rowL5->treid ));
                        }
                        $strText = $rowL4->saknr. "[" . $rowL4->depar  . "]" . $rowL4->sgtxt;
                        array_push($arrChild4, array('text' => $strText, 'leaf' => $rowL4->leaf1 , 'id' => $rowL4->treid  , 'expanded' => true ,  'children' => $arrChild5  ));
                    }
                     $strText = $rowL3->saknr. "[" . $rowL3->depar  . "]" . $rowL3->sgtxt;
                     array_push($arrChild3, array('text' => $strText, 'leaf' => $rowL3->leaf1 , 'id' => $rowL3->treid  , 'expanded' => true , 'children' => $arrChild4 ));
                  }
                  $strText = $rowL2->saknr. "[" . $rowL2->depar  . "]" . $rowL2->sgtxt;
                  array_push($arrChild, array('text' => $strText, 'leaf' => $rowL2->leaf1 , 'id' => $rowL2->treid  ,  'expanded' => true , 'children' => $arrChild3));
              }
              /************************************/
              $strText = $rowL1->saknr. "[" . $rowL1->depar  . "]" . $rowL1->sgtxt;
              array_push($arrL1, array('text' => $strText, 'leaf' => $rowL1->leaf1 , 'id' => $rowL1->treid , 'expanded' => true ,  'children' => $arrChild ));
           }
        /*******************************************************/
     	   //$arr = array('text' => 'detention', 'leaf' => false);
            $arrxx = array($arrL1);
         	echo json_encode($arrL1);
          
         
	    }
        function SaveTree()
        {
            $strField = "treid";
            $strTable = "tbl_glno";
            $strTypeID = "TR";
            
            
            /************************/
            $treid = $_GET['treid'];
            $level = $_GET['level'];
           // $text1 = $_GET['text1'];
            $leaf1 = $_GET['leaf1'];
            $child = $_GET['child'];
            $saknr = $_GET['accid'];
            $sgtxt = $_GET['tname'];
            $entxt = $_GET['ename'];
            $gltyp = $_GET['accty'];
            $under = $_GET['accgr'];
            $depar = $_GET['deptx'];
            if($treid == "")
            {
                
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
                $strSQL = " Insert into tbl_glno(treid,level,leaf1,child,saknr,";
                $strSQL = $strSQL . " sgtxt,entxt,gltyp,under,depar) Values('";
                $strSQL = $strSQL . $MaxKey . "'," . $level . ",'" . $leaf1 . "','" . $child . "','" . $saknr . "','";
                $strSQL = $strSQL . $sgtxt . "','" . $entxt . "','" . $gltyp . "','" . $under . "','" . $depar . "') ";
                $query = $this->db->query($strSQL);
            }
            else
            {
               $strSQL = " Update tbl_glno Set level = " . $level . " , leaf1 = '" . $leaf1 . "' , child = '" . $child . "' , saknr = '" . $saknr . "' , ";
               $strSQL = $strSQL . " sgtxt = '" . $sgtxt . "' , entxt = '" . $entxt . "' , gltyp = '" . $gltyp . "' , under = '" . $under . "' , depar = '" . $depar . "' ";
               $strSQL = $strSQL . " Where treid = '" . $treid . "' ;";
        
               $query = $this->db->query($strSQL);
            }
            echo "Save Complete";
        }
        function GetAccountChart()
        {
            $strSQL = "Select * from tbl_glno";
            $strResult = "";
            $query = $this->db->query($strSQL);
            foreach ($query->result() as $row)
            {
                $strResult = $strResult . $row->treid . "+" . $row->level  . "+" . "" . "+" . $row->leaf1 . "+" . $row->child . "+" . $row->saknr . "+";
                $strResult = $strResult . $row->sgtxt . "+" . $row->entxt . "+"  . $row->gltyp . "+"  . $row->under . "+"  . $row->depar . "|" ;
            }
            if( $strResult != "" )
            {
                $strResult  = substr($strResult,0 ,strlen($strResult) -1)  ;
            }
            echo $strResult;
        }
        function GetGroupAccount()
        {
            $strSQL = "Select treid,saknr from tbl_glno Where leaf1 = 'false';" ;
            $strResult = "";
            $query = $this->db->query($strSQL);
            foreach ($query->result() as $row)
            {
                $strResult = $strResult . $row->treid . "+" . $row->saknr  . "|" ;
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