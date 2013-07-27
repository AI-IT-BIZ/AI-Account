<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Po extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}

	function index(){
		$query = $this->db->get('pr');

		$result_array = $query->result_array();

		//echo json_encode($result_array);

		$this->load->view('po', array(
			'my_message'=>$result_array
		));
	}

}