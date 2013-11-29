<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}

	function index(){
		$strSQL2 = " select v_ekpo.*,v_ekko.* ,(v_ekpo.menge * v_ekpo.unitp) total_per_menge";
	    $strSQL2 = $strSQL2 . " from v_ekpo ";
	    $strSQL2 = $strSQL2 . " left join v_ekko on v_ekpo.ebeln = v_ekko.ebeln ";
	    $strSQL2 = $strSQL2 . " Where v_ekpo.ebeln = 'PO1309-1000' ";
		$query = $this->db->query($strSQL2);
		
		$ekpo_result = $query->result_array();
		
		$this->phxview->RenderView('form/report', array(
			'ekpo_list'=>$ekpo_result
		));
		$this->phxview->RenderLayout('empty');
	}

}