<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GL extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}

	function index(){
		$this->load->view('gl');
	}
	
	function load(){
		//$this->db->set_dbprefix('v_');
		$id = $this->input->post('id');
		$this->db->limit(1);
		$this->db->where('saknr', $id);
		$query = $this->db->get('glno');
		
		if($query->num_rows()>0){
			$result = $query->first_row('array');
			$result['id'] = $result['saknr'];

			echo json_encode(array(
				'success'=>true,
				'data'=>$result
			));
		}else
			echo json_encode(array(
				'success'=>false
			));
	}

	function loads(){
		$tbName = 'glno';
/*
		function createQuery($_this){
			$query = $_this->input->post('query');
			if(isset($query) && strlen($query)>0){
				$_this->db->or_like('code', $query);
			}
		}

		createQuery($this);
		$this->db->select('id');*/
		$totalCount = $this->db->count_all_results($tbName);

//		createQuery($this);
		$limit = $this->input->get('limit');
		$start = $this->input->get('start');
		if(isset($limit) && isset($start)) $this->db->limit($limit, $start);

		//$sort = $this->input->post('sort');
		//$dir = $this->input->post('dir');
		//$this->db->order_by($sort, $dir);

		$query = $this->db->get($tbName);
		//echo $this->db->last_query();
		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$totalCount
		));
	}

    function rloads(){
    	
		$sql= '';$q_header = '';$q_header2 = '';$ttype1='';$ttype2='';$bldat1='';$bldat2='';
		$saknr1='';$saknr2='';$having='';$where='';
		$ttype1 = $this->input->get('ttype');
		$ttype2 = $this->input->get('ttype2');
		if(!empty($ttype1) || !empty($ttype2)){
				//$q_header = " and t.belnr IN (SELECT h.belnr FROM tbl_bkpf AS h WHERE 1=1";
			if(!empty($ttype1) && empty($ttype2)){
			    $q_header .= " AND h.ttype='".$ttype1."'";
				$q_header2 .= " h.ttype='".$ttype1."'";
			    
            }elseif(!empty($ttype1) && !empty($ttype2)){
				$q_header .= " AND h.ttype>='".$ttype1."' AND h.ttype<='".$ttype2."'";
				$q_header2 .= " h.ttype>='".$ttype1."' AND h.ttype<='".$ttype2."'";
			}
		}

		$bldat1 = $this->input->get('bldat');
		$bldat2 = $this->input->get('bldat2');
		if(!empty($bldat1) || !empty($bldat2)){
			//if(empty($q_header))
				//$q_header = " and t.belnr IN (SELECT h.belnr FROM tbl_bkpf AS h WHERE 1=1";
			if(!empty($bldat1) && empty($bldat2)){
			    $q_header .= " AND h.bldat='".$bldat1."'";
			    if(empty($q_header2)) $q_header2 .= " h.bldat='".$bldat1."'";
				else $q_header2 .= " AND h.bldat='".$bldat1."'";
				
				}elseif(!empty($bldat1) && !empty($bldat2)){
				$q_header .= " AND h.bldat>='".$bldat1."' AND h.bldat<='".$bldat2."'";
				if(empty($q_header2)) $q_header2 .= " h.bldat>='".$bldat1."' AND h.bldat<='".$bldat2."'";
				else $q_header2 .= $q_header;
				}
		}
		
		$saknr1 = $this->input->get('saknr');
		$saknr2 = $this->input->get('saknr2');
		if(!empty($saknr1) || !empty($saknr2)){
			if(!empty($saknr1) && empty($saknr2)){
				$q_header .= " AND t.saknr='".$saknr1."'";
			    if(empty($q_header2)) $q_header2 .= " h.saknr='".$saknr1."'";
				else $q_header2 .= " AND h.saknr='".$saknr1."'";
			}elseif(!empty($saknr1) && !empty($saknr2)){
				$q_header .= " AND t.saknr>='".$saknr1."' AND t.saknr<='".$saknr2."'";
				if(empty($q_header2)) $q_header2 .= " h.saknr>='".$saknr1."' AND h.saknr<='".$saknr2."'";
				else $q_header2 .= $q_header;
			}
		}
		
		if(!empty($ttype1) || !empty($ttype2) || !empty($bldat1) || !empty($bldat2)){
			
			$having = " HAVING (
	a.saknr IN (SELECT t.saknr FROM tbl_bkpf as h 
inner join tbl_bsid AS t on h.bukrs = t.bukrs AND h.belnr = t.belnr
and h.gjahr = t.gjahr WHERE ".$q_header2.")
	OR a.saknr IN (SELECT t.saknr FROM tbl_bkpf as h 
inner join tbl_bcus AS t on h.bukrs = t.bukrs AND h.belnr = t.belnr
and h.gjahr = t.gjahr WHERE ".$q_header2.")
)";
		}elseif(!empty($saknr1) || !empty($saknr2)){
			if(!empty($saknr1) && empty($saknr2)){
				$where = " WHERE saknr = '".$saknr1."'";
		    }elseif(!empty($saknr1) && !empty($saknr2)){
		    	$where = " WHERE saknr >='".$saknr1."' AND saknr<='".$saknr2."'";
			}
		}
		//&& empty($saknr1) && empty($saknr2))
		$sql = "
select a.saknr,a.sgtxt

,(select IF(sum(t.debit) IS NULL, 0, sum(t.debit)) from tbl_bkpf as h 
inner join tbl_bsid AS t on h.bukrs = t.bukrs AND h.belnr = t.belnr
and h.gjahr = t.gjahr where t.saknr = a.saknr ".$q_header.")
 +(select IF(sum(t.debit) IS NULL, 0, sum(t.debit)) from tbl_bkpf as h 
inner join tbl_bcus AS t on h.bukrs = t.bukrs AND h.belnr = t.belnr
and h.gjahr = t.gjahr where t.saknr = a.saknr ".$q_header.")
 as deb1
,(select IF(sum(t.credi) IS NULL, 0, sum(t.credi)) from tbl_bkpf as h 
inner join tbl_bsid AS t on h.bukrs = t.bukrs AND h.belnr = t.belnr
and h.gjahr = t.gjahr where t.saknr = a.saknr ".$q_header.")
 +(select IF(sum(t.credi) IS NULL, 0, sum(t.credi)) from tbl_bkpf as h 
inner join tbl_bcus AS t on h.bukrs = t.bukrs AND h.belnr = t.belnr
and h.gjahr = t.gjahr where t.saknr = a.saknr ".$q_header.")
as cre1
from tbl_glno a".$where."
group by a.saknr".$having;
		
		$query = $this->db->query($sql);
		//echo $this->db->last_query();
		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$query->num_rows()
		));
		
	}

	function save(){

		$formData = array(
			'saknr' => $this->input->post('saknr'),
			'sgtxt' => $this->input->post('sgtxt'),
			'entxt' => $this->input->post('entxt'),
			'gltyp' => $this->input->post('gltyp'),
			'erdat' => $this->input->post('erdat'),
			'ernam' => $this->input->post('ernam'),
			'glgrp' => $this->input->post('glgrp'),
			'gllev' => $this->input->post('gllev'),
			'xloev' => $this->input->post('xloev'),
			'debit' => $this->input->post('debit'),
			'credi' => $this->input->post('credi'),
			'under' => $this->input->post('under'),
		);
		/*if ($query->num_rows() > 0){
			$this->db->where($tbPK, $id);
			$this->db->set('update_date', 'NOW()', false);
			$this->db->set('update_by', $sess_user_id);
			$this->db->update($tbName, $formData);
		}else{
		 */
			$this->db->set('erdat', 'NOW()', false);
			$this->db->set('ernam', 'test');
			$this->db->insert('gl', $formData);
		//}

		echo json_encode(array(
			'success'=>true,
			'data'=>$_POST
		));
	}

}