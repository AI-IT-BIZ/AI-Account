<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invoice extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('code_model','',TRUE);
	}

	function index(){
		//$this->load->view('project');
		//$this->phxview->RenderView('vbak');
		//$this->phxview->RenderLayout('default');
	}

	function load(){
		$this->db->set_dbprefix('v_');
		$id = $this->input->post('id');
		$this->db->limit(1);
		$this->db->where('invnr', $id);
		$query = $this->db->get('vbrk');
		if($query->num_rows()>0){
			$result = $query->first_row('array');
			//$result['id'] = $result['vbeln'];
			//$result['bldat']=substr($result['bldat'], 0, 10);
			
			$result_data['adr01'] .= $result_data['distx'].' '.$result_data['pstlz'].
			                         PHP_EOL.'Tel: '.$result_data['telf1'].PHP_EOL.'Fax: '.
			                         $result_data['telfx'].
									 PHP_EOL.'Email: '.$result_data['email'];
			$result_data['adr11'] = $result_data['adr01'];

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
		$this->db->set_dbprefix('v_');
		$tbName = 'vbrk';
		//$tbName2 = 'jobp';
/*
		function createQuery($_this){
			$query = $_this->input->post('query');
			if(isset($query) && strlen($query)>0){
				$_this->db->or_like('code', $query);
			}
		}

		createQuery($this);
		$this->db->select('id');*/
		//$totalCount1 = $this->db->count_all_results($tbName1);
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
	
	function loads_pp(){
		$tbName = 'payp';
		//$tbName2 = 'jobp';
/*
		function createQuery($_this){
			$query = $_this->input->post('query');
			if(isset($query) && strlen($query)>0){
				$_this->db->or_like('code', $query);
			}
		}

		createQuery($this);
		$this->db->select('id');*/
		//$totalCount1 = $this->db->count_all_results($tbName1);
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

	function save(){
		$id = $this->input->post('id');
		$query = null;
		if(!empty($id)){
			$this->db->limit(1);
			$this->db->where('invnr', $id);
			$query = $this->db->get('vbrk');
		}

		$formData = array(
		    //'invnr' => $this->input->post('invnr'),
			'vbeln' => $this->input->post('vbeln'),
			'bldat' => $this->input->post('bldat'),
			'statu' => $this->input->post('statu'),
			'txz01' => $this->input->post('txz01'),
			'jobnr' => $this->input->post('jobnr'),
			'auart' => $this->input->post('auart'),
			'reanr' => $this->input->post('reanr'),
			'refnr' => $this->input->post('refnr'),
			'ptype' => $this->input->post('ptype'),
			'taxnr' => $this->input->post('taxnr'),
			'lidat' => $this->input->post('lidat'),
			'kunnr' => $this->input->post('kunnr'),
			'netwr' => $this->input->post('netwr'),
			'beamt' => $this->input->post('beamt'),
			'dismt' => $this->input->post('dismt'),
			'taxpr' => $this->input->post('taxpr'),
			'salnr' => $this->input->post('salnr'),
			'ctype' => $this->input->post('ctype'),
			'exchg' => $this->input->post('exchg')
		);
		
		// start transaction
		$this->db->trans_start();  
		
		if (!empty($query) && $query->num_rows() > 0){
			$this->db->where('invnr', $id);
			$this->db->set('updat', 'NOW()', false);
			$this->db->set('upnam', 'test');
			$this->db->update('vbak', $formData);
		}else{
			$id = $this->code_model->generate('IV', 
			$this->input->post('bldat'));
			$this->db->set('invnr', $id);
			$this->db->set('erdat', 'NOW()', false);
		    $this->db->set('ernam', 'test');
			$this->db->insert('vbrk', $formData);
			
			$id = $this->db->insert_id();
		}

		// ลบ pr_item ภายใต้ id ทั้งหมด
		$this->db->where('vbelp', $id);
		$this->db->delete('vbrp');

		// เตรียมข้อมูล pr item
		$vbap = $this->input->post('vbrp');
		$qt_item_array = json_decode($vbap);

		// loop เพื่อ insert pr_item ที่ส่งมาใหม่
		foreach($qt_item_array AS $p){
			$this->db->insert('vbrp', array(
				'invnr'=>$id,
				'vbelp'=>$p->vbelp,
				'matnr'=>$p->matnr,
				'menge'=>$p->menge,
				'meins'=>$p->meins,
				'dismt'=>$p->dismt,
				'unitp'=>$p->unitp,
				'itamt'=>$p->itamt,
				'ctype'=>$p->ctype
			));
		}

		// end transaction
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
			echo json_encode(array(
				'success'=>false
			));
		else
			echo json_encode(array(
				'success'=>true,
				'data'=>$_POST
			));
	}

    public function loads_acombo(){
		$tbName = 'apov';
		$tbPK = 'statu';

		$query = $this->input->post('query');

		$totalCount = $this->db->count_all_results($tbName);

		if(!empty($query) && $query!=''){
			$this->db->or_like('statx', $query);
			$this->db->or_like($tbPK, $query);
		}

		//$this->db->order_by($_POST['sort'], $_POST['dir']);
		$query = $this->db->get($tbName);

		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$totalCount
		));
	}

    public function loads_scombo(){
		$tbName = 'psal';
		$tbPK = 'salnr';

		$query = $this->input->post('query');

		$totalCount = $this->db->count_all_results($tbName);

		if(!empty($query) && $query!=''){
			$this->db->or_like('name1', $query);
			$this->db->or_like($tbPK, $query);
		}

		//$this->db->order_by($_POST['sort'], $_POST['dir']);
		$query = $this->db->get($tbName);

		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$totalCount
		));
	}
	
	public function loads_tcombo(){
		$tbName = 'ptyp';
		$tbPK = 'ptype';

		$query = $this->input->post('query');

		$totalCount = $this->db->count_all_results($tbName);

		if(!empty($query) && $query!=''){
			$this->db->or_like('paytx', $query);
			$this->db->or_like($tbPK, $query);
		}

		//$this->db->order_by($_POST['sort'], $_POST['dir']);
		$query = $this->db->get($tbName);

		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$totalCount
		));
	}
    
    public function loads_taxcombo(){
		$tbName = 'tax1';
		$tbPK = 'taxnr';

		$query = $this->input->post('query');

		$totalCount = $this->db->count_all_results($tbName);

		if(!empty($query) && $query!=''){
			$this->db->or_like('taxtx', $query);
			$this->db->or_like($tbPK, $query);
		}

		//$this->db->order_by($_POST['sort'], $_POST['dir']);
		$query = $this->db->get($tbName);

		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$totalCount
		));
	}

	function remove(){
		$id = $this->input->post('id');
		$this->db->where('invnr', $id);
		$query = $this->db->delete('vbrk');
		echo json_encode(array(
			'success'=>true,
			'data'=>$id
		));
	}
	
	///////////////////////////////////////////////
	// Quotation ITEM
	///////////////////////////////////////////////

	function loads_iv_item(){
        $this->db->set_dbprefix('v_');
		$qt_id = $this->input->get('vbeln');
		$this->db->where('vbeln', $qt_id);

		$query = $this->db->get('vbrp');
		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$query->num_rows()
		));
	}

}