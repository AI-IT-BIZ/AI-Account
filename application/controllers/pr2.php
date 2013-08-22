<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pr2 extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}

	function index(){
		$this->phxview->RenderView('pr2');
		$this->phxview->RenderLayout('default');
	}

	function load(){
		$id = $this->input->post('id');
		$this->db->limit(1);
		$this->db->where('id', $id);
		$query = $this->db->get('ebko');
		if($query->num_rows()>0){
			$result = $query->first_row('array');
			$result['bldat']=substr($result['bldat'], 0, 10);

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
		$tbName = 'ebko';
/*
		function createQuery($_this){
			$query = $_this->input->post('query');
			if(isset($query) && strlen($query)>0){
				$_this->db->or_like('code', $query);
			}
		}

		createQuery($this);
		$this->db->select('id');
		$totalCount = $this->db->count_all_results($tbName);
*/
//		createQuery($this);
		$limit = $this->input->get('limit');
		$start = $this->input->get('start');
		if(isset($limit) && isset($start)) $this->db->limit($limit, $start);

		//$sort = $this->input->post('sort');
		//$dir = $this->input->post('dir');
		//$this->db->order_by($sort, $dir);

		//$query = $this->db->get($tbName);
		//echo $this->db->last_query();
		
		$sql="SELECT t1.id,purnr,
				bldat,
				t2.lifnr,
				name1,
				netwr,
				statx 
			FROM tbl_ebko AS t1 inner join tbl_lfa1 AS t2 ON t1.lifnr=t2.lifnr
			inner join tbl_apov AS t3 ON t1.statu=t3.statu";
		$query = $this->db->query($sql);
		
		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>2//$totalCount
		));
	}

	function save(){
		$id = $this->input->post('id');
		$query = null;
		if(!empty($id)){
			$this->db->limit(1);
			$this->db->where('id', $id);
			$query = $this->db->get('ebko');
		}

		$formData = array(
			'purnr' => $this->input->post('purnr'),
			'statu' => '01',
			'bldat' => $this->input->post('bldat'),
			'lifnr' => $this->input->post('lifnr'),
			'lfdat' => $this->input->post('lfdat'),
			'taxnr' => $this->input->post('taxnr'),
			'crdat' => $this->input->post('crdat'),
			'refnr' => $this->input->post('refnr'),
			//'dismt' => $this->input->post('dismt'),
			'taxpr' => $this->input->post('taxpr'),
			
			
		);

		// start transaction
		$this->db->trans_start();

		if (!empty($query) && $query->num_rows() > 0){
			$this->db->where('id', $id);
			$this->db->set('updat', 'NOW()', false);
			$this->db->set('upnam', 'somwang');
			$this->db->update('ebko', $formData);
		}else{
			$this->db->set('erdat', 'NOW()', false);
			$this->db->set('ernam', 'somwang');
			$this->db->insert('ebko', $formData);

			$id = $this->db->insert_id();
		}

		// ลบ pr_item ภายใต้ id ทั้งหมด
		$this->db->where('pr_id', $id);
		$this->db->delete('ebpo');

		// เตรียมข้อมูล pr item
		$ebpo = $this->input->post('ebpo');
		$ebpo_array = json_decode($ebpo);

		// loop เพื่อ insert pr_item ที่ส่งมาใหม่
		foreach($ebpo_array AS $p){
			$this->db->insert('ebpo', array(
				'pr_id'=>$id,
				'purpo'=>$p->purpo,
				'menge'=>$p->menge,
				'meins'=>$p->meins,
				'matnr'=>$p->matnr,
				'itamt'=>$p->itamt,
				'unitp'=>$p->unitp,
				'dismt'=>$p->dismt
				
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

	function remove(){
		$id = $this->input->post('id');
		$this->db->where('id', $id);
		$query = $this->db->delete('ebko');
		echo json_encode(array(
			'success'=>true,
			'data'=>$id
		));
	}

	///////////////////////////////////////////////
	// PR ITEM
	///////////////////////////////////////////////


	function loads_pr_item(){

		$pr_id = $this->input->get('pr_id');
		$this->db->where('pr_id', $pr_id);

		//$query = $this->db->get('ebpo');
		
		$sql="SELECT *,t1.meins
			FROM tbl_ebpo AS t1 inner join tbl_mara AS t2 ON t1.matnr=t2.matnr
				inner join tbl_unit AS t3 ON t1.meins=t3.meins
			WHERE pr_id = $pr_id";
		$query = $this->db->query($sql);
		
		
		echo json_encode(array(
			'success'=>true,
			'rows'=>$query->result_array(),
			'totalCount'=>$query->num_rows()
		));
	}
	
	
	public function loads_combo($tb,$pk,$like){
    	/*
		$tbName = 'ktyp';
		$tbPK = 'ktype';
		$tbLike = 'custx';
		*/
		
		$tbName = $tb;
		$tbPK = $pk;
		$tbLike = $like;

		$query = $this->input->post('query');

		$totalCount = $this->db->count_all_results($tbName);


		if(!empty($query) && $query!=''){
			$this->db->or_like($tbLike, $query);
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
}