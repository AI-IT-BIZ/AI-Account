<?php
Class Convert_amount extends CI_Model
{
	function generate($input_number){

$bathtext1='';
$digit=array('ศูนย์','หนึ่ง','สอง','สาม','สี่','ห้า','หก','เจ็ด','แปด','เก้า','สิบ','สิบเอ็ด');
$digit2=array('','สิบ','ร้อย','พัน','หมื่น','แสน','ล้าน');

$explode_number = explode(".",$input_number);
$num0=$explode_number[0]; // เลขจำนวนเต็ม
$num1=$explode_number[1]; // หลักทศนิยม


// เลขจำนวนเต็ม
$didit2_chk=strlen($num0)-1;
for($i=0;$i<=strlen($num0)-1;$i++){
 
  $cut_input_number=substr($num0,$i,1);
  
  if($cut_input_number==0){ // ถ้าเลข 0 ไม่ต้องใส่ค่าอะไร
   //$bathtext1.=''."".$digit2[$didit2_chk]; 
  }elseif($cut_input_number==2 && $didit2_chk==1){ // ถ้าเลข 2 อยู่หลักสิบ
   $bathtext1.='ยี่'."".$digit2[$didit2_chk]; 
  }elseif($cut_input_number==1 && $didit2_chk==1){ // ถ้าเลข 1 อยู่หลักสิบ
   //$bathtext1.= ''."".$digit2[$didit2_chk]; 
  }elseif($cut_input_number==1 && $didit2_chk==0){ // ถ้าเลข 1 อยู่หลักหน่วย
   if(substr($num0,$i-1,1)==0){
    $bathtext1.= 'หนึ่ง'."".$digit2[$didit2_chk];
   }else{
    $bathtext1.= 'เอ็ด'."".$digit2[$didit2_chk];
   } 
     
  }else{
   $bathtext1.= $digit[$cut_input_number]."".$digit2[$didit2_chk];
  }
  
  
  $didit2_chk=$didit2_chk-1;
}
$bathtext1.='บาทถ้วน ';

// เลขทศนิยม
$didit2_chk=strlen($num1)-1;
for($i=0;$i<=strlen($num1)-1;$i++){
 
  $cut_input_number=substr($num1,$i,1);
  
  if($cut_input_number==0){ // ถ้าเลข 0 ไม่ต้องใส่ค่าอะไร
  
  }elseif($cut_input_number==2 && $didit2_chk==1){ // ถ้าเลข 2 อยู่หลักสิบ
   $bathtext1.='ยี่'."".$digit2[$didit2_chk]; 
  }elseif($cut_input_number==1 && $didit2_chk==1){ // ถ้าเลข 1 อยู่หลักสิบ
   $bathtext1.= ''."".$digit2[$didit2_chk];
  }elseif($cut_input_number==1 && $didit2_chk==0){ // ถ้าเลข 1 อยู่หลักหน่วย
   if(substr($num1,$i-1,1)==0){
    $bathtext1.= 'หนึ่ง'."".$digit2[$didit2_chk];
   }else{
    $bathtext1.= 'เอ็ด'."".$digit2[$didit2_chk];
   } 
  }else{
   $bathtext1.= $digit[$cut_input_number]."".$digit2[$didit2_chk];
  }
  
  
  $didit2_chk=$didit2_chk-1;
}
if($didit2_chk<>-1)
 $bathtext1.='สตางค์';
//return $didit2_chk;
return $bathtext1;

	}
}