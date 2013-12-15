<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
     class ChartofAccounts extends CI_Controller {
        
        function index()
     	{
     	    
	    }
        function GetTreeChart()
     	{
     	//  $xx = "{ text: 'detention', leaf: false }" ;
           $strSQL = "Select * from tbl_chrt Where level = 1;";
           $queryL1 = $this->db->query($strSQL);
           $arrL1 = array();
           $arrChild  = array();
           $strText = "";
       
           foreach ($queryL1->result() as $rowL1)
           {  
            
              /************************************/
              /*Level2 **************************/
              $strSQL = " Select * from tbl_chrt Where level = 2 And child = '" . $rowL1->treid . "' ;"; 
              $queryL2 = $this->db->query($strSQL);
              $arrChild  = array();  
              foreach ($queryL2->result() as $rowL2)
              {
                  /*Level3 **************************/
                  $strSQL = " Select * from tbl_chrt Where level = 3 And child = '" . $rowL2->treid . "' ;"; 
                  $queryL3 = $this->db->query($strSQL);
                  $arrChild3  = array(); 
                  foreach ($queryL3->result() as $rowL3)
                  {  
                    
                    /*Level4 **************************/
                    $strSQL = " Select * from tbl_chrt Where level = 4 And child = '" . $rowL3->treid . "' ;"; 
                    $queryL4 = $this->db->query($strSQL);
                    $arrChild4  = array(); 
                    foreach ($queryL4->result() as $rowL4)
                    {
                        /*Level5 **************************/
                        $strSQL = " Select * from tbl_chrt Where level = 5 And child = '" . $rowL4->treid . "' ;"; 
                        $queryL5 = $this->db->query($strSQL);
                        $arrChild5  = array(); 
                        foreach ($queryL5->result() as $rowL5)
                        {
                            $strText = $rowL5->accid. "[" . $rowL5->deptx  . "]" . $rowL5->tname;
                            array_push($arrChild5, array('text' => $strText, 'leaf' => $rowL5->leaf1 , 'id' => $rowL5->treid ));
                        }
                        $strText = $rowL4->accid. "[" . $rowL4->deptx  . "]" . $rowL4->tname;
                        array_push($arrChild4, array('text' => $strText, 'leaf' => $rowL4->leaf1 , 'id' => $rowL4->treid  , 'expanded' => true ,  'children' => $arrChild5  ));
                    }
                     $strText = $rowL3->accid. "[" . $rowL3->deptx  . "]" . $rowL3->tname;
                     array_push($arrChild3, array('text' => $strText, 'leaf' => $rowL3->leaf1 , 'id' => $rowL3->treid  , 'expanded' => true , 'children' => $arrChild4 ));
                  }
                  $strText = $rowL2->accid. "[" . $rowL2->deptx  . "]" . $rowL2->tname;
                  array_push($arrChild, array('text' => $strText, 'leaf' => $rowL2->leaf1 , 'id' => $rowL2->treid  ,  'expanded' => true , 'children' => $arrChild3));
              }
              /************************************/
              $strText = $rowL1->accid. "[" . $rowL1->deptx  . "]" . $rowL1->tname;
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
            $strTable = "tbl_chrt";
            $strTypeID = "TR";
            
            
            /************************/
            $treid = $_GET['treid'];
            $level = $_GET['level'];
           // $text1 = $_GET['text1'];
            $leaf1 = $_GET['leaf1'];
            $child = $_GET['child'];
            $accid = $_GET['accid'];
            $tname = $_GET['tname'];
            $ename = $_GET['ename'];
            $accty = $_GET['accty'];
            $accgr = $_GET['accgr'];
            $deptx = $_GET['deptx'];
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
                $strSQL = " Insert into tbl_chrt(treid,level,text1,leaf1,child,accid,";
                $strSQL = $strSQL . " tname,ename,accty,accgr,deptx) Values('";
                $strSQL = $strSQL . $MaxKey . "','" . $level . "','" . "" . "','" . $leaf1 . "','" . $child . "','" . $accid . "','";
                $strSQL = $strSQL . $tname . "','" . $ename . "','" . $accty . "','" . $accgr . "','" . $deptx . "') ";
                $query = $this->db->query($strSQL);
            }
            else
            {
               $strSQL = " Update tbl_chrt Set level = " . $level . " , leaf1 = '" . $leaf1 . "' , child = '" . $child . "' , accid = '" . $accid . "' , ";
               $strSQL = $strSQL . " tname = '" . $tname . "' , ename = '" . $ename . "' , accty = '" . $accty . "' , accgr = '" . $accgr . "' , deptx = '" . $deptx . "' ";
               $strSQL = $strSQL . " Where treid = '" . $treid . "' ;";
        
               $query = $this->db->query($strSQL);
            }
            echo "Save Complete";
        }
        function GetAccountChart()
        {
            $strSQL = "Select * from tbl_chrt";
            $strResult = "";
            $query = $this->db->query($strSQL);
            foreach ($query->result() as $row)
            {
                $strResult = $strResult . $row->treid . "+" . $row->level  . "+" . $row->text1 . "+" . $row->leaf1 . "+" . $row->child . "+" . $row->accid . "+";
                $strResult = $strResult . $row->tname . "+" . $row->ename . "+"  . $row->accty . "+"  . $row->accgr . "+"  . $row->deptx . "|" ;
            }
            if( $strResult != "" )
            {
                $strResult  = substr($strResult,0 ,strlen($strResult) -1)  ;
            }
            echo $strResult;
        }
        function GetGroupAccount()
        {
            $strSQL = "Select treid,accid from tbl_chrt Where leaf1 = 'false';" ;
            $strResult = "";
            $query = $this->db->query($strSQL);
            foreach ($query->result() as $row)
            {
                $strResult = $strResult . $row->treid . "+" . $row->accid  . "|" ;
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