<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upload extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('code_model2','',TRUE);
	}

	function do_upload(){
		$file_path = FCPATH."fileuploads/";
		$date = new DateTime();
		$time = $date->getTimestamp();

		$config['upload_path'] = $file_path;
		$config['file_name'] = $time;
		$config['allowed_types'] = 'xlsx';

		$this->load->library('upload');
		$this->upload->initialize($config);
		if (!$this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());
			echo json_encode(array(
		    	'success' => false,
		    	'msg'=>$error
			));
		}
		else
		{
			$upload_data = $this->upload->data();
			$file_name = $upload_data['file_name'];
			echo json_encode(array(
		    	'success' => true,
		    	'file'=>$file_name
			));
		}
	}

}