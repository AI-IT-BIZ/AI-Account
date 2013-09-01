<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Quotation extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->model('code_model','',TRUE);
	}
	/*
	function test_get_code(){
		echo $this->code_model->generate('PR', '2013-05-22');
	}*/

	function index(){
		//$this->load->view('project');
		//$this->phxview->RenderView('vbak');
		//$this->phxview->RenderLayout('default');
	}

	function load(){
		$this->db->set_dbprefix('v_');
		$id = $this->input->post('id');
		$this->db->limit(1);

		$this->db->where('vbeln', $id);
		$query = $this->db->get('vbak');

		if($query->num_rows()>0){
			$result_data = $query->first_row('array');
			$result_data['id'] = $result_data['vbeln'];

			$result_data['adr01'] .= $result_data['distx'].' '.$result_data['pstlz'].
			                         PHP_EOL.'Tel: '.$result_data['telf1'].PHP_EOL.'Fax: '.
			                         $result_data['telfx'].
									 PHP_EOL.'Email: '.$result_data['email'];
			$result_data['adr11'] = $result_data['adr01'];

			//$result['bldat']=substr($result['bldat'], 0, 10);

			// unset calculated value
			unset($result_data['beamt']);
			unset($result_data['netwr']);


			echo json_encode(array(
				'success'=>true,
				'data'=>$result_data
			));
		}else
			echo json_encode(array(
				'success'=>false
			));
	}

	function loads(){
		$this->db->set_dbprefix('v_');
		$tbName = 'vbak';
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
			$this->db->where('vbeln', $id);
			$query = $this->db->get('vbak');
		}

		$formData = array(
			//'vbeln' => $this->input->post('vbeln'),
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
			$this->db->where('vbeln', $id);
			$this->db->set('updat', 'NOW()', false);
			$this->db->set('upnam', 'test');
			$this->db->update('vbak', $formData);
		}else{
			$id = $this->code_model->generate('QT', $this->input->post('bldat'));
			$this->db->set('vbeln', $id);
			$this->db->set('erdat', 'NOW()', false);
		    $this->db->set('ernam', 'test');
			$this->db->insert('vbak', $formData);

			//$id = $this->db->insert_id();
		}

		// ลบ pr_item ภายใต้ id ทั้งหมด
		$this->db->where('vbeln', $id);
		$this->db->delete('vbap');

		// เตรียมข้อมูล  qt item
		$vbap = $this->input->post('vbap');//$this->input->post('vbelp');
		$qt_item_array = json_decode($vbap);
		if(!empty($vbap) && !empty($qt_item_array)){
			// loop เพื่อ insert pr_item ที่ส่งมาใหม่
			$item_index = 0;
			foreach($qt_item_array AS $p){
				$this->db->insert('vbap', array(
					'vbeln'=>$id,
					'vbelp'=>++$item_index,//vbelp,
					'matnr'=>$p->matnr,
					'menge'=>$p->menge,
					'meins'=>$p->meins,
					'dismt'=>$p->dismt,
					'unitp'=>$p->unitp,
					'itamt'=>$p->itamt,
					'ctype'=>$p->ctype
				));
			}
		}

		// ลบ pay_item ภายใต้ id ทั้งหมด
		$this->db->where('vbeln', $id);
		$this->db->delete('payp');

		// เตรียมข้อมูล pay item
		$payp = $this->input->post('payp');//$this->input->post('vbelp');
		$pp_item_array = json_decode($payp);
		if(!empty($payp) && !empty($pp_item_array)){

			$item_index = 0;
			// loop เพื่อ insert pay_item ที่ส่งมาใหม่
			foreach($pp_item_array AS $p){
				$this->db->insert('payp', array(
					'vbeln'=>$id,
					'paypr'=>++$item_index,
					'sgtxt'=>$p->sgtxt,
					'duedt'=>$p->duedt,
					'perct'=>$p->perct,
					'pramt'=>$p->pramt,
					'ctyp1'=>$p->ctyp1
				));
			}
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
		$this->db->where('vbeln', $id);
		$query = $this->db->delete('vbak');
		echo json_encode(array(
			'success'=>true,
			'data'=>$id
		));
	}

	///////////////////////////////////////////////
	// Quotation ITEM
	///////////////////////////////////////////////

	function loads_qt_item(){
        $this->db->set_dbprefix('v_');
		$qt_id = $this->input->get('vbeln');
		$this->db->where('vbeln', $qt_id);

		$query = $this->db->get('vbap');
		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$query->num_rows()
		));
	}

	function loads_pay_item(){
        //$this->db->set_dbprefix('v_');
		$pp_id = $this->input->get('vbeln');
		$this->db->where('vbeln', $pp_id);

		$query = $this->db->get('payp');
		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$query->num_rows()
		));
	}

}