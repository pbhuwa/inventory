<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Item_mdl extends CI_Model {
	public function __construct() {
		parent::__construct();
		$this->table = 'itli_itemslist';
		$this->locationid = $this->session->userdata(LOCATION_ID);
		$this->location_ismain = $this->session->userdata(ISMAIN_LOCATION);
	}

	public $validate_settings_itemlist = array(
		array('field' => 'itli_materialtypeid', 'label' => 'Material', 'rules' => 'trim|required|xss_clean'),
		array('field' => 'itli_catid', 'label' => 'Subcategory ', 'rules' => 'trim|required|xss_clean'),
		array('field' => 'itli_itemcode', 'label' => 'Item Code ', 'rules' => 'trim|required|xss_clean|callback_exists_item_code'),
		array('field' => 'itli_itemname', 'label' => 'Item Name ', 'rules' => 'trim|required|xss_clean|callback_exists_item_name'),
		
		array('field' => 'itli_reorderlevel', 'label' => 'Record Level ', 'rules' => 'trim|numeric|xss_clean'),
		array('field' => 'itli_maxlimit', 'label' => 'Max Limit ', 'rules' => 'trim|numeric|xss_clean'),
		array('field' => 'itli_purchaserate', 'label' => 'Purchase Rate ', 'rules' => 'trim|numeric|xss_clean'),
		array('field' => 'itli_unitid', 'label' => 'Unit', 'rules' => 'trim|numeric|xss_clean'),
		// array('field' => 'itli_branid', 'label' => 'Brand Name ', 'rules' => 'trim|required|xss_clean'),
		array('field' => 'itli_typeid', 'label' => 'Item Type', 'rules' => 'trim|required|xss_clean'),

	);

	public $validate_settings_otheritemlist = array(
		array('field' => 'teit_itemname', 'label' => 'Item Name', 'rules' => 'trim|required|xss_clean'),

	);

	public function save_item() {

		$postdata = $this->input->post();
		$id = $this->input->post('id');
		$isitdep = $this->input->post('itli_isitdep');

		unset($postdata['itli_isitdep']);
		$postdata['itli_isitdep'] = !empty($isitdep) ? $isitdep : 'N';

		$isnonexp = $this->input->post('itli_isnonexp');

		unset($postdata['itli_isnonexp']);
		$postdata['itli_isnonexp'] = !empty($isnonexp) ? $isnonexp : 'N';

		unset($postdata['id']);
		if ($id) {
			$postdata['itli_modifydatead'] = CURDATE_EN;
			$postdata['itli_modifydatebs'] = CURDATE_NP;
			$postdata['itli_modifytime'] = date('H:i:s');
			$postdata['itli_modifyby'] = $this->session->userdata(USER_ID);
			$postdata['itli_modifyip'] = $this->general->get_real_ipaddr();
			$postdata['itli_modifymac'] = $this->general->get_Mac_Address();
			if (!empty($postdata)) {
				$this->general->save_log($this->table, 'itli_itemlistid', $id, $postdata, 'Update');
				$this->db->update($this->table, $postdata, array('itli_itemlistid' => $id));
				$rowaffected = $this->db->affected_rows();
				if ($rowaffected) {

					return $rowaffected;
				} else {
					return false;
				}
			}
		} else { 
			$postdata['itli_postdatead'] = CURDATE_EN;
			$postdata['itli_postdatebs'] = CURDATE_NP;
			$postdata['itli_posttime'] = date('H:i:s');
			$postdata['itli_postby'] = $this->session->userdata(USER_ID);
			$postdata['itli_postip'] = $this->general->get_real_ipaddr();
			$postdata['itli_postmac'] = $this->general->get_Mac_Address();
			$postdata['itli_orgid'] = $this->session->userdata(ORG_ID);
			$postdata['itli_locationid'] = $this->locationid;
			// echo "<pre>";
			// print_r($postdata);
			// die();

			if (!empty($postdata)) {
				$this->db->insert($this->table, $postdata);
				$insertid = $this->db->insert_id();
				if ($insertid) {
					return $insertid;
				} else {
					return false;
				}
			}
		}
	}

	public function save_otheritem() {

		$postdata = $this->input->post();

		$postdata['teit_postdatead'] = CURDATE_EN;
		$postdata['teit_postdatebs'] = CURDATE_NP;
		$postdata['teit_posttime'] = date('H:i:s');
		$postdata['teit_postby'] = $this->session->userdata(USER_ID);
		$postdata['teit_postip'] = $this->general->get_real_ipaddr();
		$postdata['teit_postmac'] = $this->general->get_Mac_Address();
		$postdata['teit_orgid'] = $this->session->userdata(ORG_ID);
		$postdata['teit_locationid'] = $this->locationid;
		// echo "<pre>";
		// print_r($postdata);
		// die();

		if (!empty($postdata)) {
			$this->db->insert('teit_tempitem', $postdata);
			$insertid = $this->db->insert_id();
			if ($insertid) {
				return true;
			} else {
				return false;
			}
		}
	}

	public function get_all_itemlist($srchcol = false, $limit = false, $offset = false, $order_by = false, $order = 'ASC', $multiple_order = false) {
		$this->db->select('it.*,ec.eqca_code,ec.eqca_category,br.bran_name,mt.maty_material,u.unit_unitname,et.eqty_equipmenttype');
		$this->db->from('itli_itemslist it');
		$this->db->join('eqca_equipmentcategory ec', 'ec.eqca_equipmentcategoryid=it.itli_catid', 'LEFT');
		$this->db->join('maty_materialtype mt', 'mt.maty_materialtypeid=it.itli_materialtypeid', 'LEFT');
		$this->db->join('unit_unit u', 'u.unit_unitid=it.itli_unitid', 'LEFT');
		$this->db->join('eqty_equipmenttype et', 'et.eqty_equipmenttypeid=it.itli_typeid', 'LEFT');
		$this->db->join('bran_brand br', 'br.bran_brandid=it.itli_branid', 'LEFT');
		if ($srchcol) {
			$this->db->where($srchcol);
		}
		if ($limit && $limit > 0) {
			$this->db->limit($limit);
		}
		if ($offset) {
			$this->db->offset($offset);
		}

		if ($order_by) {
			$this->db->order_by($order_by, $order);
		}
		if ($multiple_order) {
			$this->db->order_by($multiple_order);
		}

		$query = $this->db->get();
		// echo $this->db->last_query();

		// die();
		if ($query->num_rows() > 0) {
			$data = $query->result();
			return $data;
		}
		return false;
	}

	public function get_item_list($srch = false) {
		$get = $_GET;
		// $material_type = $_GET['material_type'];
		// $category = $_GET['category'];

		foreach ($get as $key => $value) {
			$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
		}

		$material_type = $this->input->get('material_type');
		$category = $this->input->get('category');
		$search_text = $this->input->get('search_text');
		// echo "<pre>";
		// print_r($search_text);
		// die();

		if (!empty($get['sSearch_1'])) {
			$this->db->where("mt.maty_material like  '%" . $get['sSearch_1'] . "%'  ");
		}

		if (!empty($get['sSearch_2'])) {
			$this->db->where("ec.eqca_category like  '%" . $get['sSearch_2'] . "%'  ");
		}
		if (!empty($get['sSearch_3'])) {
			$this->db->where("it.itli_itemcode like  '%" . $get['sSearch_3'] . "%'  ");
		}

		if (!empty($get['sSearch_4'])) {
			$this->db->where("it.itli_itemname like  '%" . htmlspecialchars_decode($get['sSearch_4']) . "%' OR it.itli_itemnamenp like  '%" . htmlspecialchars_decode($get['sSearch_4']) . "%'    ");
		}

		if (!empty($get['sSearch_5'])) {
			$this->db->where("it.itli_itemname like  '%" . $get['sSearch_5'] . "%' OR it.itli_itemnamenp like  '%" . $get['sSearch_5'] . "%'    ");
		}

		if (!empty($get['sSearch_6'])) {
			$this->db->where("it.itli_purchaserate like  '%" . $get['sSearch_6'] . "%'  ");
		}
		if (!empty($get['sSearch_7'])) {
			//$this->db->where("it.itli_purchaserate like  '%".$get['sSearch_7']."%'  ");
			$this->db->where("u.unit_unitname like  '%" . $get['sSearch_7'] . "%'  ");
		}
		if (!empty($get['sSearch_8'])) {
			$this->db->where("et.eqty_equipmenttype like  '%" . $get['sSearch_8'] . "%'  ");
		}

		$locationid = !empty($get['locationid']) ? $get['locationid'] : $this->input->post('locationid');

		//   if($this->location_ismain=='Y')
		//   {
		//     if(!empty($locationid))
		//     {
		//         $this->db->where('it.itli_locationid',$locationid);
		//      }

		// }
		// else
		// {
		//      $this->db->where('it.itli_locationid',$this->locationid);
		// }

		$this->db->select("COUNT(*) as cnt")
			->from('itli_itemslist it')
			->join('eqca_equipmentcategory ec', 'ec.eqca_equipmentcategoryid=it.itli_catid', 'LEFT')
			->join('maty_materialtype mt', 'mt.maty_materialtypeid=it.itli_materialtypeid', 'LEFT')
			->join('unit_unit u', 'u.unit_unitid=it.itli_unitid', 'LEFT')
			->join('eqty_equipmenttype et', 'et.eqty_equipmenttypeid=it.itli_typeid', 'LEFT');

		if ($search_text) {
			$this->db->group_start()
				->where("mt.maty_material like '%$search_text%'")
				->or_where("ec.eqca_category like '%$search_text%'")
				->or_where("it.itli_itemcode like '%$search_text%'")
				->or_where("it.itli_itemname like '%$search_text%'")
				->group_end();
		}

		if ($material_type) {
			$this->db->where("it.itli_materialtypeid", $material_type);
		}

		if ($category) {
			$this->db->where("it.itli_catid", $category);
		}
		$resltrpt = $this->db->get()
			->row();

		// echo $this->db->last_query();die();
		$totalfilteredrecs = $resltrpt->cnt;
		// echo '<pre>'
		// print_r($totalfilteredrecs);
		// die();
		$order_by = 'ec.eqca_category';
		$order = 'asc';
		if ($this->input->get('sSortDir_0')) {
			$order = $this->input->get('sSortDir_0');
		}

		$where = '';
		if ($this->input->get('iSortCol_0') == 1) {
			$order_by = 'mt.maty_material';
		}

		if ($this->input->get('iSortCol_0') == 2)
		//$order_by = 'ec.eqca_code';
		{
			$order_by = 'ec.eqca_category';
		} else if ($this->input->get('iSortCol_0') == 3) {
			$order_by = 'it.itli_itemcode';
		} else if ($this->input->get('iSortCol_0') == 4) {
			$order_by = 'it.itli_itemname ';
		} else if ($this->input->get('iSortCol_0') == 5) {
			$order_by = 'it.itli_itemnamenp ';
		} else if ($this->input->get('iSortCol_0') == 7) {
			$order_by = 'u.unit_unitname';
		} else if ($this->input->get('iSortCol_0') == 8) {
			$order_by = 'et.eqty_equipmenttype';
		}
		else if ($this->input->get('iSortCol_0') == 98) {
			$order_by = 'it.itli_postdatead';
		}

		$totalrecs = '';
		$limit = 15;
		$offset = 1;
		$get = $_GET;

		foreach ($get as $key => $value) {
			$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
		}

		if (!empty($_GET["iDisplayLength"])) {
			$limit = $_GET['iDisplayLength'];
			$offset = $_GET["iDisplayStart"];
		}

		if (!empty($get['sSearch_1'])) {
			$this->db->where("mt.maty_material like  '%" . $get['sSearch_1'] . "%'  ");
		}

		if (!empty($get['sSearch_2'])) {
			$this->db->where("ec.eqca_category like  '%" . $get['sSearch_2'] . "%'  ");
		}
		if (!empty($get['sSearch_3'])) {
			$this->db->where("it.itli_itemcode like  '%" . $get['sSearch_3'] . "%'  ");
		}

		if (!empty($get['sSearch_4'])) {
			$this->db->where("it.itli_itemname like  '%" . htmlspecialchars_decode($get['sSearch_4']) . "%' OR it.itli_itemnamenp like  '%" . htmlspecialchars_decode($get['sSearch_4']) . "%'");
		}

		if (!empty($get['sSearch_5'])) {
			$this->db->where("it.itli_itemname like  '%" . $get['sSearch_5'] . "%' OR it.itli_itemnamenp like  '%" . $get['sSearch_5'] . "%'    ");
		}

		if (!empty($get['sSearch_6'])) {
			$this->db->where("it.itli_purchaserate like  '%" . $get['sSearch_6'] . "%'  ");
		}
		if (!empty($get['sSearch_7'])) {
			//$this->db->where("it.itli_purchaserate like  '%".$get['sSearch_7']."%'  ");
			$this->db->where("u.unit_unitname like  '%" . $get['sSearch_7'] . "%'  ");
		}
		if (!empty($get['sSearch_8'])) {
			$this->db->where("et.eqty_equipmenttype like  '%" . $get['sSearch_8'] . "%'  ");
		}

		$locationid = !empty($get['locationid']) ? $get['locationid'] : $this->input->post('locationid');

		//   if($this->location_ismain=='Y')
		//   {
		//     if(!empty($locationid))
		//     {
		//         $this->db->where('it.itli_locationid',$locationid);
		//      }

		// }
		// else
		// {
		//      $this->db->where('it.itli_locationid',$this->locationid);
		// }

		$this->db->select('it.*,ec.eqca_code,ec.eqca_category,mt.maty_material,u.unit_unitname,et.eqty_equipmenttype');
		$this->db->from('itli_itemslist it');
		$this->db->join('eqca_equipmentcategory ec', 'ec.eqca_equipmentcategoryid=it.itli_catid', 'LEFT');
		$this->db->join('maty_materialtype mt', 'mt.maty_materialtypeid=it.itli_materialtypeid', 'LEFT');
		$this->db->join('unit_unit u', 'u.unit_unitid=it.itli_unitid', 'LEFT');
		$this->db->join('eqty_equipmenttype et', 'et.eqty_equipmenttypeid=it.itli_typeid', 'LEFT');

		if ($search_text) {
			$this->db->group_start()
				->where("mt.maty_material like '%$search_text%'")
				->or_where("ec.eqca_category like '%$search_text%'")
				->or_where("it.itli_itemcode like '%$search_text%'")
				->or_where("it.itli_itemname like '%$search_text%'")
				->group_end();
		}

		if ($material_type) {
			$this->db->where("it.itli_materialtypeid", $material_type);
		}

		if ($category) {
			$this->db->where("it.itli_catid", $category);
		}

		$this->db->order_by($order_by, $order);
		if ($limit && $limit > 0) {
			$this->db->limit($limit, $offset);
		}

		// if ($search_text) {
		// 	$this->db->where("mt.maty_material like '%" . $search_text . "%' ");
		// 	$this->db_or_where("ec.eqca_category like '%" . $search_text . "%' ");
		// 	$this->db_or_where("it.itli_itemcode like '%" . $search_text . "% ");
		// 	$this->db_or_where("it.itli_itemname like '%" . $search_text . "% ");
		// }

		// if ($search_text) {
		// 	$this->db->where("mt.maty_material like '%$search_text%'")
		// 		->or_where("ec.eqca_category like '%$search_text%'")
		// 		->or_where("it.itli_itemcode", $search_text)
		// 		->or_where("it.itli_itemname like '%$search_text%'");
		// }

		// if ($material_type) {
		// 	$this->db->where("it.itli_materialtypeid", $material_type);
		// }

		// if ($category) {
		// 	$this->db->where("it.itli_catid", $category);
		// }

		$nquery = $this->db->get();
		// echo $this->db->last_query();
		// die();
		$num_row = $nquery->num_rows();
		if (!empty($_GET['iDisplayLength']) && !empty($nquery) && is_array($nquery) && count($nquery) > 0) {
			$totalrecs = sizeof($nquery);
		}

		if ($num_row > 0) {
			$ndata = $nquery->result();
			$ndata['totalrecs'] = $totalrecs;
			$ndata['totalfilteredrecs'] = $totalfilteredrecs;
		} else {
			$ndata = array();
			$ndata['totalrecs'] = 0;
			$ndata['totalfilteredrecs'] = 0;
		}
		// echo $this->db->last_query();die();
		return $ndata;

	}

	public function item_list_normal($srch = false) {

		$get = $_GET;

		foreach ($get as $key => $value) {
			$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
		}
		if (!empty($get['sSearch_1'])) {
			$this->db->where("lower(il.itli_itemcode) like  '%" . $get['sSearch_1'] . "%'  ");
		}
		if (!empty($get['sSearch_2'])) {
			$this->db->where("lower(il.itli_itemname) like  '%" . $get['sSearch_2'] . "%'  ");
		}
		if (!empty($get['sSearch_3'])) {
			$this->db->where("lower(il.itli_itemnamenp) like  '%" . $get['sSearch_3'] . "%'  ");
		}

		if (!empty($get['searchtext'])) {
			$this->db->where("lower(il.itli_itemname) like  '%" . htmlspecialchars_decode($get['searchtext']) . "%' OR lower(il.itli_itemnamenp) like  '%" . htmlspecialchars_decode($get['searchtext']) . "%'  OR lower(il.itli_itemcode) like  '%" . htmlspecialchars_decode($get['searchtext']) . "%'  ");
		}
		$locationid = !empty($get['locationid']) ? $get['locationid'] : $this->input->post('locationid');

		if ($this->location_ismain == 'Y') {
			if (!empty($locationid)) {
				$this->db->where('il.itli_locationid', $locationid);
			}

		} else {
			$this->db->where('il.itli_locationid', $this->locationid);
		}

		$resltrpt = $this->db->select("COUNT(*) as cnt")
			->from('itli_itemslist il')
			->get()
			->row();

		// echo $this->db->last_query();die();
		$totalfilteredrecs = $resltrpt->cnt;

		$order_by = 'il.itli_itemname';
		$order = 'ASC';
		if ($this->input->get('sSortDir_0')) {
			$order = $this->input->get('sSortDir_0');
		}

		$where = '';
		if ($this->input->get('iSortCol_0') == 1) {
			$order_by = 'il.itli_itemcode';
		}

		if ($this->input->get('iSortCol_0') == 2) {
			$order_by = 'il.itli_itemname';
		}

		if ($this->input->get('iSortCol_0') == 3) {
			$order_by = 'il.itli_itemnamenp';
		}

		$totalrecs = '';
		$limit = 15;
		$offset = 1;
		$get = $_GET;

		foreach ($get as $key => $value) {
			$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
		}

		if (!empty($_GET["iDisplayLength"])) {
			$limit = $_GET['iDisplayLength'];
			$offset = $_GET["iDisplayStart"];
		}

		if (!empty($get['sSearch_1'])) {
			$this->db->where("loweer(il.itli_itemcode) like  '%" . $get['sSearch_1'] . "%'  ");
		}
		if (!empty($get['sSearch_2'])) {
			$this->db->where("loweer(il.itli_itemname) like  '%" . $get['sSearch_2'] . "%'  ");
		}
		if (!empty($get['sSearch_3'])) {
			$this->db->where("loweer(il.itli_itemnamenp) like  '%" . $get['sSearch_3'] . "%'  ");
		}
		if (!empty($get['searchtext'])) {
			$this->db->where("lower(il.itli_itemname) like  '%" . htmlspecialchars_decode($get['searchtext']) . "%' OR lower(il.itli_itemnamenp) like  '%" . htmlspecialchars_decode($get['searchtext']) . "%'  OR lower(il.itli_itemcode) like  '%" . htmlspecialchars_decode($get['searchtext']) . "%'  ");
		}
		$locationid = !empty($get['locationid']) ? $get['locationid'] : $this->input->post('locationid');

		// if($this->location_ismain=='Y')
		//   {
		//     if(!empty($locationid))
		//     {
		//         $this->db->where('il.itli_locationid',$locationid);
		//      }

		// }
		// else
		// {
		//      $this->db->where('il.itli_locationid',$this->locationid);
		// }

		$this->db->select('il.itli_itemlistid,il.itli_itemcode,il.itli_itemname,il.itli_itemnamenp,il.itli_salesrate,ec.eqca_code,ec.eqca_category,mt.maty_material,u.unit_unitname,et.eqty_equipmenttype,il.itli_purchaserate,
');
		$this->db->from('itli_itemslist il ');
		$this->db->join('eqca_equipmentcategory ec', 'ec.eqca_equipmentcategoryid=il.itli_catid', 'LEFT');
		$this->db->join('maty_materialtype mt', 'mt.maty_materialtypeid=il.itli_materialtypeid', 'LEFT');
		$this->db->join('unit_unit u', 'u.unit_unitid=il.itli_unitid', 'LEFT');
		$this->db->join('eqty_equipmenttype et', 'et.eqty_equipmenttypeid=il.itli_typeid', 'LEFT');

		$this->db->order_by($order_by, $order);
		if ($limit && $limit > 0) {
			$this->db->limit($limit, $offset);
		}

		if ($srch) {
			$this->db->where($srch);
		}

		$nquery = $this->db->get();
		// echo $this->db->last_query();
		// die();
		$num_row = $nquery->num_rows();
		if (!empty($_GET['iDisplayLength']) && !empty($nquery) && is_array($nquery) && count($nquery) > 0) {
			$totalrecs = sizeof($nquery);
		}

		if ($num_row > 0) {
			$ndata = $nquery->result();
			$ndata['totalrecs'] = $totalrecs;
			$ndata['totalfilteredrecs'] = $totalfilteredrecs;
		} else {
			$ndata = array();
			$ndata['totalrecs'] = 0;
			$ndata['totalfilteredrecs'] = 0;
		}
		// echo $this->db->last_query();die();
		return $ndata;

	}

	public function item_list_tbl($srch = false) {
		$get = $_GET;
		foreach ($get as $key => $value) {
			$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
		}
		if (!empty($get['sSearch_1'])) {
			$this->db->where("il.itli_itemcode like  '%" . $get['sSearch_1'] . "%'  ");
		}
		if (!empty($get['sSearch_2'])) {
			$this->db->where("itli_itemname like  '%" . $get['sSearch_2'] . "%' OR itli_itemnamenp like  '%" . $get['sSearch_2'] . "%'  ");
		}
		if (!empty($get['sSearch_3'])) {
			$this->db->where("itli_itemname like  '%" . $get['sSearch_3'] . "%' OR itli_itemnamenp like  '%" . $get['sSearch_3'] . "%'  ");
		}

		$resltrpt = $this->db->select("COUNT(*) as cnt")
			->from('itli_itemslist il')
			->get()
			->row();

		// echo $this->db->last_query();die();
		$totalfilteredrecs = $resltrpt->cnt;

		$order_by = 'il.itli_itemname';
		$order = 'ASC';
		if ($this->input->get('sSortDir_0')) {
			$order = $this->input->get('sSortDir_0');
		}

		$where = '';
		if ($this->input->get('iSortCol_0') == 1) {
			$order_by = 'il.itli_itemcode';
		}

		if ($this->input->get('iSortCol_0') == 2) {
			$order_by = 'il.itli_itemname';
		}

		$totalrecs = '';
		$limit = 15;
		$offset = 1;
		$get = $_GET;

		foreach ($get as $key => $value) {
			$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
		}

		if (!empty($_GET["iDisplayLength"])) {
			$limit = $_GET['iDisplayLength'];
			$offset = $_GET["iDisplayStart"];
		}

		if (!empty($get['sSearch_1'])) {
			$this->db->where("il.itli_itemcode like  '%" . $get['sSearch_1'] . "%'  ");
		}
		if (!empty($get['sSearch_2'])) {
			$this->db->where("itli_itemname like  '%" . $get['sSearch_2'] . "%' OR itli_itemnamenp like  '%" . $get['sSearch_2'] . "%'  ");
		}
		if (!empty($get['sSearch_3'])) {
			$this->db->where("itli_itemname like  '%" . $get['sSearch_3'] . "%' OR itli_itemnamenp like  '%" . $get['sSearch_3'] . "%'  ");
		}

		$this->db->select('il.itli_itemlistid,il.itli_itemcode,il.itli_itemname,il.itli_itemnamenp,il.itli_salesrate,ec.eqca_code,ec.eqca_category,mt.maty_material,u.unit_unitname,et.eqty_equipmenttype,
(SELECT IFNULL(SUM(md.trde_issueqty)," ") FROM xw_trde_transactiondetail md LEFT JOIN xw_trma_transactionmain mt   on md.trde_trmaid =mt.trma_trmaid
  WHERE il.itli_itemlistid=md.trde_itemsid AND mt.trma_received=1 AND md.trde_locationid=' . $this->locationid . ' ) as stockqty');
		$this->db->from('itli_itemslist il ');
		$this->db->join('eqca_equipmentcategory ec', 'ec.eqca_equipmentcategoryid=il.itli_catid', 'LEFT');
		$this->db->join('maty_materialtype mt', 'mt.maty_materialtypeid=il.itli_materialtypeid', 'LEFT');
		$this->db->join('unit_unit u', 'u.unit_unitid=il.itli_unitid', 'LEFT');
		$this->db->join('eqty_equipmenttype et', 'et.eqty_equipmenttypeid=il.itli_typeid', 'LEFT');

		$this->db->order_by($order_by, $order);
		if ($limit && $limit > 0) {
			$this->db->limit($limit, $offset);
		}

		if ($srch) {
			$this->db->where($srch);
		}

		$nquery = $this->db->get();
		// echo $this->db->last_query();
		// die();
		$num_row = $nquery->num_rows();
		if (!empty($_GET['iDisplayLength']) && !empty($nquery) && is_array($nquery) && count($nquery) > 0) {
			$totalrecs = sizeof($nquery);
		}

		if ($num_row > 0) {
			$ndata = $nquery->result();
			$ndata['totalrecs'] = $totalrecs;
			$ndata['totalfilteredrecs'] = $totalfilteredrecs;
		} else {
			$ndata = array();
			$ndata['totalrecs'] = 0;
			$ndata['totalfilteredrecs'] = 0;
		}
		// echo $this->db->last_query();die();
		return $ndata;

	}

// For  Stock and Inventory --Stock Transfer
	public function get_item_list_stock_transfer($srch = false) {

		$get = $_GET;
		foreach ($get as $key => $value) {
			$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
		}

		if (!empty($get['sSearch_1'])) {
			$this->db->where("itli_itemcode like  '%" . $get['sSearch_1'] . "%'  ");
		}

		if (!empty($get['sSearch_2'])) {
			$this->db->where("itli_itemname like  '%" . $get['sSearch_2'] . "%' OR  itli_itemnamenp like  '%" . $get['sSearch_2'] . "%'  ");
		}

		if ($srch) {
			$this->db->where($srch);
		}

		$resltrpt = $this->db->select("COUNT(*) as cnt")
			->from('itli_itemslist il')
			->join('trde_transactiondetail mtd', 'mtd.trde_itemsid=il.itli_itemlistid', 'LEFT')
			->join('trma_transactionmain mtm', 'mtm.trma_trmaid=mtd.trde_trmaid', 'LEFT')
			->join('unit_unit ut', 'ut.unit_unitid=il.itli_unitid', 'LEFT')
			->where(array('mtm.trma_received' => '1'))
			->where(array('mtm.trma_status<>' => 'C'))
			->where(array('mtd.trde_issueqty<>' => 0))
			->get()
			->row();

		//echo $this->db->last_query();die();
		$totalfilteredrecs = $resltrpt->cnt;

		$order_by = 'il.itli_itemname';
		$order = 'asc';
		if ($this->input->get('sSortDir_0')) {
			$order = $this->input->get('sSortDir_0');
		}

		$where = '';
		if ($this->input->get('iSortCol_0') == 1)
		//$order_by = 'ec.eqca_code';
		{
			$order_by = 'il.itli_itemcode';
		} else if ($this->input->get('iSortCol_0') == 2) {
			$order_by = 'il.itli_itemname';
		}

		$totalrecs = '';
		$limit = 15;
		$offset = 1;
		$get = $_GET;

		foreach ($get as $key => $value) {
			$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
		}

		if (!empty($_GET["iDisplayLength"])) {
			$limit = $_GET['iDisplayLength'];
			$offset = $_GET["iDisplayStart"];
		}

		if (!empty($get['sSearch_1'])) {
			$this->db->where("itli_itemcode like  '%" . $get['sSearch_1'] . "%'  ");
		}

		if (!empty($get['sSearch_2'])) {
			$this->db->where("itli_itemname like  '%" . $get['sSearch_2'] . "%' OR  itli_itemnamenp like  '%" . $get['sSearch_2'] . "%'  ");
		}

		$this->db->select('il.itli_itemlistid,il.itli_itemcode,il.itli_purchaserate,il.itli_itemname,il.itli_itemnamenp,mtd.trde_mtdid,mtd.trde_controlno controlno,mtd.trde_issueqty, mtd.trde_trmaid,mtd.trde_supplierid,mtd.trde_supplierbillno,mtd.trde_expdatead, mtd.trde_expdatebs,mtm.trma_issueno,mtd.trde_trdeid,mtd.trde_unitprice,ut.unit_unitname,ut.unit_unitid');
		$this->db->from('itli_itemslist il');
		$this->db->join('trde_transactiondetail mtd', 'mtd.trde_itemsid= il.itli_itemlistid', 'LEFT');
		$this->db->join('trma_transactionmain mtm', 'mtm.trma_trmaid=mtd.trde_trmaid', 'LEFT');
		$this->db->join('unit_unit ut', 'ut.unit_unitid=il.itli_unitid', 'LEFT');
		$this->db->where(array('mtm.trma_received' => '1'));
		$this->db->where(array('mtm.trma_status<>' => 'C'));
		$this->db->where(array('mtd.trde_issueqty<>' => 0));
		$this->db->where(array('mtm.trma_locationid' => $this->locationid));

		if ($srch) {
			$this->db->where($srch);
		}

		$this->db->order_by($order_by, $order);
		if ($limit && $limit > 0) {
			$this->db->limit($limit);
		}
		if ($offset) {
			$this->db->offset($offset);
		}

		$nquery = $this->db->get();
		$num_row = $nquery->num_rows();
		if (!empty($_GET['iDisplayLength']) && !empty($nquery) && is_array($nquery) && count($nquery) > 0) {
			$totalrecs = sizeof($nquery);
		}

		if ($num_row > 0) {
			$ndata = $nquery->result();
			$ndata['totalrecs'] = $totalrecs;
			$ndata['totalfilteredrecs'] = $totalfilteredrecs;
		} else {
			$ndata = array();
			$ndata['totalrecs'] = 0;
			$ndata['totalfilteredrecs'] = 0;
		}
		//echo $this->db->last_query();die();
		return $ndata;

	}

// For Issue and Consumption Requisition Modules
	public function get_item_list_stock_requisition($srch = false, $storeid = false) {
		$storeid = $storeid;

		$get = $_GET;

		$ku_stock_select = '';
		if (ORGANIZATION_NAME == 'KU') {
			if (!empty($srch) && $srch['itli_materialtypeid'] == 2) {
				$ku_stock_select = ', 0 as issue_qty';
			}	
		}

		foreach ($get as $key => $value) {
			$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
		}

		$this->db->start_cache();
		if (!empty($get['sSearch_1'])) {
			$this->db->where("lower(itli_itemcode) like  '%" . $get['sSearch_1'] . "%'  ");
		}

		if (!empty($get['sSearch_2'])) {
			$this->db->where("lower(itli_itemname) like  '%" . htmlspecialchars_decode($get['sSearch_2']) . "%'  ");
		}
		if (!empty($get['sSearch_3'])) {
			$this->db->where("lower(itli_itemnamenp) like  '%" . $get['sSearch_3'] . "%'  ");
		}
		if (!empty($get['sSearch_7'])) {
			$this->db->where("lower(ec.eqca_category) like  '%" . $get['sSearch_7'] . "%'  ");
		}

		$searchtext = !empty($get['searchtext']) ? trim($get['searchtext']) : '';
		// echo $searchtext;
		// die();

		if ($srch) {
			$this->db->where($srch);
		}
		if (!empty($searchtext)) {
			$this->db->where("(lower(itli_itemcode) like  '%" . htmlspecialchars_decode($searchtext) . "%' OR lower(itli_itemname) like  '%" . htmlspecialchars_decode($searchtext) . "%' OR lower(itli_itemnamenp) like  '%" . htmlspecialchars_decode($searchtext) . "%' )");
		}
		$this->db->stop_cache();

		$resltrpt = $this->db->select("COUNT(*) as cnt")
			->from('itli_itemslist il')
			->join('eqca_equipmentcategory ec', 'ec.eqca_equipmentcategoryid=il.itli_catid')
			->get()
			->row();
		// echo $this->db->last_query();
		// die();

		$totalfilteredrecs = $resltrpt->cnt;

		$order_by = 'il.itli_itemname';
		$order = 'asc';
		if ($this->input->get('sSortDir_0')) {
			$order = $this->input->get('sSortDir_0');
		}

		$where = '';
		if ($this->input->get('iSortCol_0') == 1)
		//$order_by = 'ec.eqca_code';
		{
			$order_by = 'il.itli_itemcode';
		} else if ($this->input->get('iSortCol_0') == 2) {
			$order_by = 'il.itli_itemname';
		} else if ($this->input->get('iSortCol_0') == 3) {
			$order_by = 'il.itli_itemnamenp';
		} else if ($this->input->get('iSortCol_0') == 7) {
			$order_by = 'ec.eqca_category';
		}

		$totalrecs = '';
		$limit = 15;
		$offset = 1;

		if (!empty($_GET["iDisplayLength"])) {
			$limit = $_GET['iDisplayLength'];
			$offset = $_GET["iDisplayStart"];
		}

		$this->db->select("itli_itemlistid, itli_itemcode,itli_itemname, itli_itemnamenp, itli_purchaserate, itli_salesrate, itli_reorderlevel, itli_locationid,
      (select COALESCE(SUM(mtd.trde_issueqty),0) from xw_trde_transactiondetail mtd, xw_trma_transactionmain  mtm WHERE
        mtm.trma_trmaid = mtd.trde_trmaid AND
        mtd.trde_itemsid = il.itli_itemlistid AND mtm.trma_received = '1' AND mtd.trde_status = 'O' AND trde_issueqty>0 AND mtd.trde_locationid = $this->locationid AND mtm.trma_fromdepartmentid = $storeid  ) issue_qty,ut.unit_unitname,ut.unit_unitid,ec.eqca_category,$ku_stock_select");
		$this->db->from('itli_itemslist il');
		$this->db->join('unit_unit ut', 'ut.unit_unitid=il.itli_unitid', 'LEFT');
		$this->db->join('eqca_equipmentcategory ec', 'ec.eqca_equipmentcategoryid=il.itli_catid', 'LEFT');

		if ($srch) {
			$this->db->where($srch);
		}

		$this->db->order_by($order_by, $order);
		if ($limit && $limit > 0) {
			$this->db->limit($limit);
		}
		if ($offset) {
			$this->db->offset($offset);
		}

		$nquery = $this->db->get();
		// echo "<pre>";
		// print_r($nquery);
		// die();

		$this->db->flush_cache();

		$num_row = $nquery->num_rows();

		//kukl
		//         $this->db->select("itli_itemlistid,itli_itemcode,itli_itemname,itli_itemnamenp,itli_purchaserate,itli_salesrate,itli_reorderlevel,itli_locationid,
		// (select SUM(mtd.trde_issueqty) from xw_trde_transactiondetail mtd, xw_trma_transactionmain  mtm WHERE
		// mtm.trma_trmaid=mtd.trde_trmaid AND
		// mtd.trde_itemsid=il.itli_itemlistid AND mtm.trma_received='1' AND mtd.trde_status='O' AND mtd.trde_locationid=$this->locationid AND mtm.trma_fromdepartmentid=$storeid ) issue_qty,ut.unit_unitname,ut.unit_unitid, '' as teit_ismove");
		//       $this->db->from('itli_itemslist il');
		//       $this->db->join('unit_unit ut','ut.unit_unitid=il.itli_unitid','LEFT');

		// $locationid= !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');

		//     if($this->location_ismain=='Y')
		//     {
		//       if(!empty($locationid))
		//       {
		//           $this->db->where('il.itli_locationid',$locationid);
		//        }

		//   }
		//   else
		//   {
		//        $this->db->where('il.itli_locationid',$this->locationid);
		//   }

		// $nquery=$this->db->get();
		//  $this->db->order_by($order_by,$order);
		// if($limit)
		// {
		//     $this->db->limit($limit);
		// }
		// if($offset)
		// {
		//     $this->db->offset($offset);
		// }

		// $query1 = $this->db->get_compiled_select();

		// $this->db->select("teit_tempitemid as itli_itemlistid,
		//                 '' as itli_itemcode,
		//                 teit_itemname as itli_itemname,
		//                 '' as itli_itemnamenp,
		//                 0 as itli_purchaserate,
		//                 0 as itli_salesrate,
		//                 0 as itli_reorderlevel,
		//                 teit_locationid as itli_locationid,
		//                 0 as issue_qty,
		//                 '-' as unit_unitname,
		//                 0 AS unit_unitid,
		//                 teit_ismove");
		// $this->db->from('teit_tempitem');
		// $this->db->where('teit_ismove','N');
		// $query2 = $this->db->get_compiled_select();

		//    $order_by = 'teit_ismove desc, itli_itemname';
		//    $nquery = $this->db->query("SELECT * FROM (".$query1." UNION ".$query2.") X  ORDER BY $order_by LIMIT $limit");

		//  $this->db->order_by($order_by,$order);
		// if($limit)
		// {
		//     $this->db->limit($limit);
		// }
		// if($offset)
		// {
		//     $this->db->offset($offset);
		// }

		$num_row = $nquery->num_rows();
		if (!empty($_GET['iDisplayLength']) && $num_row > 0) {
			$totalrecs = $num_row;
		}

		// echo $num_row;
		// die();

		if ($num_row > 0) {
			$ndata = $nquery->result();
			$ndata['totalrecs'] = $totalrecs;
			$ndata['totalfilteredrecs'] = $totalfilteredrecs;
		} else {
			$ndata = array();
			$ndata['totalrecs'] = 0;
			$ndata['totalfilteredrecs'] = 0;
		}

		// echo "<pre>";
		// print_r($ndata);
		// die();

		return $ndata;

	}

// For Stock Transfer From One Location to Another Requisition Modules
	public function get_item_list_stock_transfer_location($srch = false, $locationid = false) {
		$locationid = $locationid;

		$get = $_GET;
		foreach ($get as $key => $value) {
			$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
		}
		if (!empty($get['sSearch_1'])) {
			$this->db->where("itli_itemcode like  '%" . $get['sSearch_1'] . "%'  ");
		}
		if (!empty($get['sSearch_2'])) {
			$this->db->where("itli_itemname like  '%" . $get['sSearch_2'] . "%' OR itli_itemnamenp like  '%" . $get['sSearch_2'] . "%'  ");
		}
		if ($srch) {
			$this->db->where($srch);
		}

		$resltrpt = $this->db->select("COUNT(*) as cnt")
			->from('itli_itemslist il')
			->get()
			->row();

		//echo $this->db->last_query();die();
		$totalfilteredrecs = $resltrpt->cnt;

		$order_by = 'il.itli_itemname';
		$order = 'asc';
		if ($this->input->get('sSortDir_0')) {
			$order = $this->input->get('sSortDir_0');
		}

		$where = '';
		if ($this->input->get('iSortCol_0') == 1)
		//$order_by = 'ec.eqca_code';
		{
			$order_by = 'il.itli_itemcode';
		} else if ($this->input->get('iSortCol_0') == 2) {
			$order_by = 'il.itli_itemname';
		}

		$totalrecs = '';
		$limit = 15;
		$offset = 1;
		$get = $_GET;

		foreach ($get as $key => $value) {
			$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
		}

		if (!empty($_GET["iDisplayLength"])) {
			$limit = $_GET['iDisplayLength'];
			$offset = $_GET["iDisplayStart"];
		}

		if (!empty($get['sSearch_1'])) {
			$this->db->where("itli_itemcode like  '%" . $get['sSearch_1'] . "%'  ");
		}

		if (!empty($get['sSearch_2'])) {
			$this->db->where("itli_itemname like  '%" . $get['sSearch_2'] . "%' OR itli_itemnamenp like  '%" . $get['sSearch_2'] . "%'  ");
		}

		$this->db->select("itli_itemlistid,itli_itemcode,itli_itemname,itli_itemnamenp,itli_purchaserate,itli_salesrate,
(select SUM(mtd.trde_issueqty) from xw_trde_transactiondetail mtd, xw_trma_transactionmain  mtm WHERE
mtm.trma_trmaid=mtd.trde_trmaid AND
mtd.trde_itemsid=il.itli_itemlistid AND mtm.trma_received='1' AND mtd.trde_status='O' AND mtd.trde_locationid=$locationid ) issue_qty,ut.unit_unitname,ut.unit_unitid");
		$this->db->from('itli_itemslist il');
		$this->db->join('unit_unit ut', 'ut.unit_unitid=il.itli_unitid', 'LEFT');

		if ($srch) {
			$this->db->where($srch);
		}

		$this->db->order_by($order_by, $order);
		if ($limit && $limit > 0) {
			$this->db->limit($limit);
		}
		if ($offset) {
			$this->db->offset($offset);
		}

		$nquery = $this->db->get();
		$num_row = $nquery->num_rows();
		if (!empty($_GET['iDisplayLength']) && !empty($nquery) && is_array($nquery) && count($nquery) > 0) {
			$totalrecs = sizeof($nquery);
		}

		if ($num_row > 0) {
			$ndata = $nquery->result();
			$ndata['totalrecs'] = $totalrecs;
			$ndata['totalfilteredrecs'] = $totalfilteredrecs;
		} else {
			$ndata = array();
			$ndata['totalrecs'] = 0;
			$ndata['totalfilteredrecs'] = 0;
		}
		// echo $this->db->last_query();die();
		return $ndata;

	}
// For Purchase Requisition Modules
	public function get_item_list_purchase_requisition($srch = false, $storeid = false) {
		$storeid = $storeid;

		$get = $_GET;
		foreach ($get as $key => $value) {
			$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
		}
		if (!empty($get['sSearch_1'])) {
			$this->db->where("itli_itemcode like  '%" . $get['sSearch_1'] . "%'  ");
		}
		if (!empty($get['sSearch_2'])) {
			$this->db->where("itli_itemname like  '%" . $get['sSearch_2'] . "%' OR itli_itemnamenp like  '%" . $get['sSearch_2'] . "%'  ");
		}
		if ($srch) {
			$this->db->where($srch);
		}

		$this->db->select("il.itli_itemcode,il.itli_itemlistid,il.itli_itemname,il.itli_purchaserate,ut.unit_unitname,
    qd.qude_quotationmasterid,qm.quma_quotationnumber,
    (select SUM(mtd.trde_issueqty) from xw_trde_transactiondetail mtd, xw_trma_transactionmain  mtm WHERE
    mtm.trma_trmaid=mtd.trde_trmaid AND
    mtd.trde_itemsid=il.itli_itemlistid AND mtm.trma_received='1' AND mtm.trma_todepartmentid=$storeid AND mtd.trde_locationid=$this->locationid ) stock_qty");
		$this->db->from('qude_quotationdetail qd');
		$this->db->join('quma_quotationmaster qm', 'qm.quma_quotationmasterid=qd.qude_quotationmasterid', 'LEFT');
		$this->db->join('itli_itemslist il', 'il.itli_itemlistid=qd.qude_itemsid', 'LEFT');
		$this->db->join('unit_unit ut', 'ut.unit_unitid=il.itli_unitid', 'LEFT');
		$this->db->where(array('qd.qude_approvestatus' => 'FA'));
		$this->db->where('il.itli_itemlistid IS NOT NULL');
		$this->db->group_by('il.itli_itemname');
		$resltrpt = $this->db->get()->result();

		//echo $this->db->last_query();die();
		$totalfilteredrecs = sizeof($resltrpt);

		$order_by = 'il.itli_itemname';
		$order = 'asc';
		if ($this->input->get('sSortDir_0')) {
			$order = $this->input->get('sSortDir_0');
		}

		$where = '';
		if ($this->input->get('iSortCol_0') == 1)
		//$order_by = 'ec.eqca_code';
		{
			$order_by = 'il.itli_itemcode';
		} else if ($this->input->get('iSortCol_0') == 2) {
			$order_by = 'il.itli_itemname';
		}

		$totalrecs = '';
		$limit = 15;
		$offset = 1;
		$get = $_GET;

		foreach ($get as $key => $value) {
			$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
		}

		if (!empty($_GET["iDisplayLength"])) {
			$limit = $_GET['iDisplayLength'];
			$offset = $_GET["iDisplayStart"];
		}

		if (!empty($get['sSearch_1'])) {
			$this->db->where("itli_itemcode like  '%" . $get['sSearch_1'] . "%'  ");
		}

		if (!empty($get['sSearch_2'])) {
			$this->db->where("itli_itemname like  '%" . $get['sSearch_2'] . "%' OR itli_itemnamenp like  '%" . $get['sSearch_2'] . "%'  ");
		}

		$this->db->select("il.itli_itemcode,il.itli_itemlistid,il.itli_itemname,il.itli_purchaserate,ut.unit_unitname,
qd.qude_quotationmasterid,qm.quma_quotationnumber,
(select SUM(mtd.trde_issueqty) from xw_trde_transactiondetail mtd, xw_trma_transactionmain  mtm WHERE
mtm.trma_trmaid=mtd.trde_trmaid AND
mtd.trde_itemsid=il.itli_itemlistid AND mtm.trma_received='1' AND mtm.trma_todepartmentid=$storeid AND mtd.trde_locationid=$this->locationid ) stock_qty");
		$this->db->from('qude_quotationdetail qd');
		$this->db->join('quma_quotationmaster qm', 'qm.quma_quotationmasterid=qd.qude_quotationmasterid', 'LEFT');
		$this->db->join('itli_itemslist il', 'il.itli_itemlistid=qd.qude_itemsid', 'LEFT');
		$this->db->join('unit_unit ut', 'ut.unit_unitid=il.itli_unitid', 'LEFT');
		$this->db->where(array('qd.qude_approvestatus' => 'FA'));
		$this->db->where('il.itli_itemlistid IS NOT NULL');
		$this->db->group_by('il.itli_itemname');

// select  il.itli_itemcode,il.itli_itemlistid,il.itli_itemname,il.itli_purchaserate,ut.unit_unitname,
		// qd.qude_quotationmasterid,qm.quma_quotationnumber,
		// (select SUM(mtd.trde_issueqty) from xw_trde_transactiondetail mtd, xw_trma_transactionmain  mtm WHERE
		// mtm.trma_trmaid=mtd.trde_trmaid AND
		// mtd.trde_itemsid=il.itli_itemlistid AND mtm.trma_received='1' AND mtm.trma_todepartmentid=1) stock_qty
		//  from xw_qude_quotationdetail qd LEFT JOIN
		// xw_quma_quotationmaster qm on qm.quma_quotationmasterid=qd.qude_quotationmasterid
		// LEFT JOIN
		// xw_itli_itemslist il on il.itli_itemlistid=qd.qude_itemsid
		// LEFT JOIN
		// xw_unit_unit ut on ut.unit_unitid=il.itli_unitid
		// WHERE qd.qude_approvestatus='FA' AND il.itli_itemlistid IS NOT NULL
		// GROUP by il.itli_itemname

		if ($srch) {
			$this->db->where($srch);
		}

		$this->db->order_by($order_by, $order);
		if ($limit && $limit > 0) {
			$this->db->limit($limit);
		}
		if ($offset) {
			$this->db->offset($offset);
		}

		$nquery = $this->db->get();
		$num_row = $nquery->num_rows();
		if (!empty($_GET['iDisplayLength']) && !empty($nquery) && is_array($nquery) && count($nquery) > 0) {
			$totalrecs = sizeof($nquery);
		}

		if ($num_row > 0) {
			$ndata = $nquery->result();
			$ndata['totalrecs'] = $totalrecs;
			$ndata['totalfilteredrecs'] = $totalfilteredrecs;
		} else {
			$ndata = array();
			$ndata['totalrecs'] = 0;
			$ndata['totalfilteredrecs'] = 0;
		}
		// echo $this->db->last_query();die();
		return $ndata;

	}

	public function remove_item() {
		$id = $this->input->post('id');
		if ($id) {
			$this->general->save_log($this->table, 'itli_itemlistid', $id, $postdata = array(), 'Delete');
			$this->db->delete($this->table, array('itli_itemlistid' => $id));
			$rowaffected = $this->db->affected_rows();
			if ($rowaffected) {
				return $rowaffected;
			}
			return false;
		}
		return false;
	}

	public function get_category_by_materialid($material_typeid = false) {
		$this->db->select('*');
		$this->db->from('eqca_equipmentcategory');
		$this->db->where('eqca_mattypeid', $material_typeid);
		$query = $this->db->get();
		// echo $this->db->last_query();
		// die();
		if ($query->num_rows() > 0) {
			$data = $query->result();
			return $data;
		}
		return false;
	}

	public function get_itemlist_by_materialid($material_typeid = false) {
		$this->db->select('*');
		$this->db->from('itli_itemslist il');
		if (!empty($material_typeid)) {
			$this->db->where('il.itli_materialtypeid', $material_typeid);
		}

		$query = $this->db->get();
		// echo $this->db->last_query();
		// die();
		if ($query->num_rows() > 0) {
			$data = $query->result();
			return $data;
		}
		return false;
	}

	public function check_exit_itemcode_for_other($itemcode, $id)
	{

		$data = array();
		if ($id) {
			$query = $this->db->get_where($this->table, array('itli_itemcode' => $itemcode, 'itli_itemlistid !=' => $id));
		} else {
			$query = $this->db->get_where($this->table, array('itli_itemcode' => $itemcode));
		}

		if ($query->num_rows() > 0) {
			$data = $query->row();
			return $data;
		}
		return false;
	}

	public function check_exit_itemname_for_other($itemname = false, $id = false)
	{
		$data = array();

		if ($id) {
			$query = $this->db->get_where($this->table, array('itli_itemname' => $itemname, 'itli_itemlistid !=' => $id));
		} else {
			$query = $this->db->get_where($this->table, array('itli_itemname' => $itemname));
		}
		if ($query->num_rows() > 0) {
			$data = $query->row();
			return $data;
		}
		return false;
	}

}