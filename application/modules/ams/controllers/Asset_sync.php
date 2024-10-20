<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Asset_sync extends CI_Controller

{

	function __construct()

	{

		parent::__construct();

		$this->load->model('assets_mdl');

		$this->load->model('asset_sync_mdl');

		$this->load->model('assets_decommision_mdl');

		$this->load->Model('settings/department_mdl', 'department_mdl');

		$this->load->Model('biomedical/bio_medical_mdl');

		$this->load->Model('biomedical/manufacturers_mdl');

		$this->load->Model('biomedical/equipment_mdl');

		$this->load->Model('biomedical/distributors_mdl');

		$this->load->helper('file');

		$this->load->helper('form');

		$this->load->library('zend');

		$this->zend->load('Zend/Barcode');

		$this->load->library('ciqrcode');

		$this->username = $this->session->userdata(USER_NAME);
		$this->deptid = $this->session->userdata(USER_DEPT);
		$this->userid = $this->session->userdata(USER_ID);
		$this->locationid = $this->session->userdata(LOCATION_ID);
		if (defined('LOCATION_CODE')) :
			$this->locationcode = $this->session->userdata(LOCATION_CODE);
		endif;
		$this->location_ismain = $this->session->userdata(ISMAIN_LOCATION);
		$this->orgid = $this->session->userdata(ORG_ID);
		$this->usergroup = $this->session->userdata(USER_GROUPCODE);
		$this->userdept = $this->session->userdata(USER_DEPT);
		$this->mattypeid = $this->session->userdata(USER_MAT_TYPEID);
		$this->show_location_group = array('SA', 'SK', 'SI');
	}

	public function index()
	{

		if (MODULES_VIEW == 'N') {

			$array = array();

			$this->general->permission_denial_message();

			exit;
		}

		$frmDate = CURDATE_NP;

		$toDate = CURDATE_NP;

		$cur_fiscalyear = CUR_FISCALYEAR;

		$this->data['fiscalyear'] = $this->general->get_tbl_data('*', 'fiye_fiscalyear', false, 'fiye_fiscalyear_id', 'DESC');

		$this->db->select('*');

		$this->db->from('eqca_equipmentcategory ec');

		$this->db->where('eqca_isnonexp', 'Y');

		$result = $this->db->get()->result();

		$this->data['equipmentcategory'] = $result;

		// echo "<pre>";

		// print_r($this->data['equipmentcategory']);

		// die();
		$this->data['department'] = $this->general->get_tbl_data('*', 'dept_department', array('dept_locationid' => $this->locationid), 'dept_depname', 'ASC');

		$this->data['supplier_all'] = $this->general->get_tbl_data('*', 'dist_distributors', array('dist_isactive' => 'Y'), 'dist_distributor', 'ASC');

		$this->page_title = 'Asset Synchronization';

		$this->data['tab_type'] = "assets_inv_list";

		$seo_data = '';

		if ($seo_data) {

			//set SEO data

			$this->page_title = $seo_data->page_title;

			$this->data['meta_keys'] = $seo_data->meta_key;

			$this->data['meta_desc'] = $seo_data->meta_description;
		} else {

			//set SEO data

			$this->page_title = ORGA_NAME;

			$this->data['meta_keys'] = ORGA_NAME;

			$this->data['meta_desc'] = ORGA_NAME;
		}

		$this->template

			->set_layout('general')

			->enable_parser(FALSE)

			->title($this->page_title)

			->build('asset_sync/v_asset_sync_main', $this->data);
	}

	public function asset_sync_summary_view()
	{
		try {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$sync_id = $this->input->post('id');
				$this->data['sync_id'] = $sync_id;
				$this->data['assets_data'] = $this->assets_mdl->get_all_assets(array('asen_syncid' => $sync_id));
				$transaction_id = $this->general->get_tbl_data('assy_trdeid', 'assy_assetsync', array('assy_assyid' => $sync_id));
				$this->data['item_details'] = $this->asset_sync_mdl->get_item_details_for_asset(array('td.trde_trdeid' => $transaction_id[0]->assy_trdeid));
				// var_dump($this->data['assets_data']);
				// die;
				$seo_data = '';

				if ($seo_data) {

					//set SEO data

					$this->page_title = $seo_data->page_title;

					$this->data['meta_keys'] = $seo_data->meta_key;

					$this->data['meta_desc'] = $seo_data->meta_description;
				} else {

					//set SEO data

					$this->page_title = ORGA_NAME;

					$this->data['meta_keys'] = ORGA_NAME;

					$this->data['meta_desc'] = ORGA_NAME;
				}

				if (defined('ORGANIZATION_NAME')) :

					if (ORGANIZATION_NAME == 'KUKL') :

						$tempform = $this->load->view('asset_sync/' . REPORT_SUFFIX . '/v_asset_sync_summary_view_modal', $this->data, true);

					elseif (ORGANIZATION_NAME == 'KU') :

						$tempform = $this->load->view('asset_sync/' . REPORT_SUFFIX . '/v_asset_sync_summary_view_modal', $this->data, true);

					else :

						$tempform = $this->load->view('asset_sync/v_asset_sync_summary_view_modal', $this->data, true);

					endif;

				else :

					$tempform = $this->load->view('asset_sync/v_asset_sync_summary_view_modal', $this->data, true);

				endif;
				print_r(json_encode(array('status' => 'success', 'message' => 'Success', 'tempform' => $tempform)));
				exit;
			} else {
				print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
				exit;
			}
		} catch (Exception $e) {

			throw $e;
		}
	}

	public function synclist_asset_summary()
	{
		if (MODULES_VIEW == 'N') {

			$array = array();
			echo json_encode(array("recordsFiltered" => 0, "recordsTotal" => 0, "data" => $array));
			exit;
		}
		$i = 0;
		if (ORGANIZATION_NAME == 'KU' || ORGANIZATION_NAME=='ARMY' ) {

			$data = $this->asset_sync_mdl->get_item_synch_summary_ku();

			$array = array();

			$filtereddata = ($data["totalfilteredrecs"] > 0 ? $data["totalfilteredrecs"] : $data["totalrecs"]);

			$totalrecs = $data["totalrecs"];

			unset($data["totalfilteredrecs"]);

			unset($data["totalrecs"]);

			foreach ($data as $row) {

				$array[$i]["sync_date_ad"] = $row->assy_syncdatead;

				$array[$i]["sync_date_bs"] = $row->assy_syncdatebs;

				$array[$i]["purchase_date_ad"] = $row->assy_purchasedatead;
				$array[$i]["purchase_date_bs"] = $row->assy_purchasedatebs;

				$array[$i]["item_code"] = $row->itli_itemcode;

				$array[$i]["item_name"] = $row->itli_itemname;

				$array[$i]["item_name_np"] = $row->itli_itemnamenp;

				$array[$i]["category"] = $row->eqca_category;

				$array[$i]["supplier"] = $row->dist_distributor;

				$array[$i]["qty"] = $row->assy_qty;

				$array[$i]["rate"] = number_format($row->assy_price, 2);

				$array[$i]["amount"] = number_format(($row->assy_qty) * ($row->assy_price), 2);

				$array[$i]["school"] = !empty($row->schoolname) ? $row->schoolname : '';

				$depparentname = !empty($row->depparentname) ? $row->depparentname : '';

				if ($depparentname) {

					$depparentname = '(' . $depparentname . ')';
				}

				$array[$i]["department"] = "$row->dept_depname $depparentname";

				$array[$i]["received_by"] = $row->recm_receivedby;

				$array[$i]["action"] = '<a href="javascript:void(0)" title="Edit" class="btn btn-sm btn-primary view" data-id=' . $row->assy_assyid . ' data-viewurl=' . base_url("/ams/asset_sync/asset_sync_summary_view") . ' data-displaydiv="assets" data-heading="Asset Sync Summary View"  data-detailid=' . $row->assy_assyid . ' ><i class="fa fa-eye" aria-hidden="true"></i></a>&nbsp;';

				$i++;
			}

			//echo"<pre>";print_r($data);die;

			$get = $_GET;

			echo json_encode(array("recordsFiltered" => $filtereddata, "recordsTotal" => $totalrecs, "data" => $array));
		} else {

			$data = $this->asset_sync_mdl->get_item_synch_summary();

			$array = array();

			$filtereddata = ($data["totalfilteredrecs"] > 0 ? $data["totalfilteredrecs"] : $data["totalrecs"]);

			$totalrecs = $data["totalrecs"];

			unset($data["totalfilteredrecs"]);

			unset($data["totalrecs"]);

			foreach ($data as $row) {

				$array[$i]["received_date_ad"] = $row->recm_receiveddatead;

				$array[$i]["received_date_bs"] = $row->recm_receiveddatebs;

				$array[$i]["receive_no"] = $row->recm_receivedno;

				$array[$i]["item_code"] = $row->itli_itemcode;

				$array[$i]["item_name"] = $row->itli_itemname;

				$array[$i]["item_name_np"] = $row->itli_itemnamenp;

				$array[$i]["category"] = $row->eqca_category;

				$array[$i]["supplier"] = $row->dist_distributor;

				$array[$i]["qty"] = $row->trde_requiredqty;

				$array[$i]["rate"] = $row->trde_unitprice;

				$array[$i]["amount"] = ($row->trde_requiredqty) * ($row->trde_unitprice);

				$array[$i]["action"] = '<a href="javascript:void(0)" data-id=' . $row->trde_trdeid . ' data-displaydiv="" data-viewurl=' . base_url('ams/asset_sync/asset_sync_items_detail') . ' class="btn btn-sm btn-warning btnredirect" data-heading="' . $row->itli_itemname . '" data-id="' . $row->trde_trdeid . '" title="Synch To Assets"><i class="fa fa-database"  aria-hidden="true" ></i>&nbsp; Synch To Assets</a>';
				$i++;
			}

			//echo"<pre>";print_r($data);die;

			$get = $_GET;

			echo json_encode(array("recordsFiltered" => $filtereddata, "recordsTotal" => $totalrecs, "data" => $array));
		}
	}

	public function itemslist_from_inventory()
	{

		if (MODULES_VIEW == 'N') {

			$array = array();

			// $this->general->permission_denial_message();

			echo json_encode(array("recordsFiltered" => 0, "recordsTotal" => 0, "data" => $array));

			exit;
		}

		$useraccess = $this->session->userdata(USER_ACCESS_TYPE);

		$i = 0;

		// echo ORGANIZATION_NAME;

		// die();

		if (ORGANIZATION_NAME == 'KUKL') {

			$data = $this->asset_sync_mdl->get_itemslist_from_inventory_kukl();

			$array = array();

			$filtereddata = ($data["totalfilteredrecs"] > 0 ? $data["totalfilteredrecs"] : $data["totalrecs"]);

			$totalrecs = $data["totalrecs"];

			unset($data["totalfilteredrecs"]);

			unset($data["totalrecs"]);

			foreach ($data as $row) {

				$array[$i]["received_date_ad"] = $row->recm_receiveddatead;

				$array[$i]["received_date_bs"] = $row->recm_receiveddatebs;

				$array[$i]["servie_date_ad"] = $row->sama_billdatead;

				$array[$i]["servie_date_bs"] = $row->sama_billdatebs;

				$array[$i]["invoice_no"] = $row->sama_invoiceno;

				$array[$i]["item_code"] = $row->itli_itemcode;

				$array[$i]["item_name"] = $row->itli_itemname;

				$array[$i]["item_name_np"] = $row->itli_itemnamenp;

				$array[$i]["category"] = $row->eqca_category;

				$array[$i]["supplier"] = $row->dist_distributor;

				$array[$i]["qty"] = $row->trde_requiredqty;

				$array[$i]["rate"] = number_format($row->trde_unitprice, 2);

				$total_amt = ($row->trde_requiredqty) * ($row->trde_unitprice);

				$array[$i]["amount"] = number_format($total_amt, 2);

				$array[$i]["action"] = '<a href="javascript:void(0)" data-id=' . $row->sade_saledetailid . ' data-displaydiv="" data-viewurl=' . base_url('ams/asset_sync/asset_sync_items_detail') . ' class="btn btn-sm btn-warning btnredirect" data-heading="' . $row->itli_itemname . '" data-id="' . $row->sade_saledetailid . '" title="Synch To Assets"><i class="fa fa-database"  aria-hidden="true" ></i>&nbsp; Synch To Assets</a>';

				$i++;
			}

			//echo"<pre>";print_r($data);die;

			$get = $_GET;

			echo json_encode(array("recordsFiltered" => $filtereddata, "recordsTotal" => $totalrecs, "data" => $array));
		} else if (ORGANIZATION_NAME == 'KU' || ORGANIZATION_NAME=='ARMY') {

			$data = $this->asset_sync_mdl->get_itemslist_from_inventory_ku();

			// echo "s<pre>";

			// print_r($data);

			// die();

			$array = array();

			$filtereddata = ($data["totalfilteredrecs"] > 0 ? $data["totalfilteredrecs"] : $data["totalrecs"]);

			$totalrecs = $data["totalrecs"];

			unset($data["totalfilteredrecs"]);

			unset($data["totalrecs"]);

			foreach ($data as $row) {

				$array[$i]["received_date_ad"] = $row->recm_receiveddatead;

				$array[$i]["received_date_bs"] = $row->recm_receiveddatebs;

				$array[$i]["receive_no"] = '<a href="javascript:void(0)" data-id="' . $row->recm_receivedmasterid . '" data-displaydiv="" data-viewurl="' . base_url() . '/purchase_receive/receive_against_order/direct_purchase_details" class="view" data-heading="Receive Ordered Items Detail">' . $row->recm_receivedno . '</a>';

				$array[$i]["item_code"] = $row->itli_itemcode;

				$array[$i]["item_name"] = $row->itli_itemname;

				$array[$i]["item_name_np"] = $row->itli_itemnamenp;

				$array[$i]["category"] = $row->eqca_category;

				$array[$i]["supplier"] = $row->dist_distributor;

				$array[$i]["qty"] = $row->trde_requiredqty;

				$array[$i]["rate"] = number_format($row->trde_unitprice, 2);

				$total_amt = ($row->trde_requiredqty) * ($row->trde_unitprice);

				$array[$i]["amount"] = number_format($total_amt, 2);

				$array[$i]["school"] = $row->schoolname;

				$depparentname = !empty($row->depparentname) ? $row->depparentname : '';

				if ($depparentname) {

					$depparentname = '(' . $depparentname . ')';
				}

				$array[$i]["department"] = $row->dept_depname . $depparentname;

				$array[$i]["received_by"] = $row->recm_receivedby;

				$array[$i]["action"] = '<a href="javascript:void(0)" data-id=' . $row->trde_trdeid . ' data-displaydiv="" data-viewurl=' . base_url('ams/asset_sync/asset_sync_items_detail') . ' class="btn btn-sm btn-warning btnredirect" data-heading="' . $row->itli_itemname . '" data-id="' . $row->trde_trdeid . '" title="Synch To Assets"><i class="fa fa-database"  aria-hidden="true" ></i>&nbsp; Synch To Assets</a>';

				$i++;
			}

			//echo"<pre>";print_r($data);die;

			$get = $_GET;

			echo json_encode(array("recordsFiltered" => $filtereddata, "recordsTotal" => $totalrecs, "data" => $array));
		} else {

			$data = $this->asset_sync_mdl->get_itemslist_from_inventory();
			// echo "<pre>";
			// print_r($data);
			// die();

			$array = array();

			$filtereddata = ($data["totalfilteredrecs"] > 0 ? $data["totalfilteredrecs"] : $data["totalrecs"]);

			$totalrecs = $data["totalrecs"];

			unset($data["totalfilteredrecs"]);

			unset($data["totalrecs"]);

			foreach ($data as $row) {

				$array[$i]["received_date_ad"] = $row->recm_receiveddatead;

				$array[$i]["received_date_bs"] = $row->recm_receiveddatebs;

				$array[$i]["receive_no"] = '<a href="javascript:void(0)" data-id="' . $row->recm_receivedmasterid . '" data-displaydiv="" data-viewurl="' . base_url() . '/purchase_receive/receive_against_order/direct_purchase_details" class="view" data-heading="Receive Ordered Items Detail">' . $row->recm_receivedno . '</a>';

				$array[$i]["item_code"] = $row->itli_itemcode;

				$array[$i]["item_name"] = $row->itli_itemname;

				$array[$i]["item_name_np"] = $row->itli_itemnamenp;

				$array[$i]["category"] = $row->eqca_category;

				$array[$i]["supplier"] = $row->dist_distributor;

				$array[$i]["qty"] = $row->trde_requiredqty;

				$array[$i]["rate"] = $row->trde_unitprice;

				$array[$i]["amount"] = ($row->trde_requiredqty) * ($row->trde_unitprice);

				$array[$i]["action"] = '<a href="javascript:void(0)" data-id=' . $row->trde_trdeid . ' data-displaydiv="" data-viewurl=' . base_url('ams/asset_sync/asset_sync_items_detail') . ' class="btn btn-sm btn-warning btnredirect" data-heading="' . $row->itli_itemname . '" data-id="' . $row->trde_trdeid . '" title="Synch To Assets"><i class="fa fa-database"  aria-hidden="true" ></i>&nbsp; Synch To Assets</a>';

				$i++;
			}

			// echo"<pre>";print_r($array);die;

			$get = $_GET;

			echo json_encode(array("recordsFiltered" => $filtereddata, "recordsTotal" => $totalrecs, "data" => $array));
		}

		// echo $this->db->last_query();die();

		//echo"<pre>";print_r($data);die;

	}

	public function synchlist_from_asset()

	{

		if (MODULES_VIEW == 'N') {

			$array = array();

			// $this->general->permission_denial_message();

			echo json_encode(array("recordsFiltered" => 0, "recordsTotal" => 0, "data" => $array));

			exit;
		}

		$useraccess = $this->session->userdata(USER_ACCESS_TYPE);

		$i = 0;

		$data = $this->asset_sync_mdl->get_item_synch_list();

		// echo "<pre>";

		// print_r($data);

		// die();

		$array = array();

		$filtereddata = ($data["totalfilteredrecs"] > 0 ? $data["totalfilteredrecs"] : $data["totalrecs"]);

		$totalrecs = $data["totalrecs"];

		unset($data["totalfilteredrecs"]);

		unset($data["totalrecs"]);

		foreach ($data as $row) {

			$array[$i]["syncdatead"] = $row->assy_syncdatead;

			$array[$i]["syncdatebs"] = $row->assy_syncdatebs;

			$array[$i]["servie_date_ad"] = $row->assy_servicedatead;

			$array[$i]["servie_date_bs"] = $row->assy_servicedatebs;

			$array[$i]["item_code"] = $row->itli_itemcode;

			$array[$i]["item_name"] = $row->itli_itemname;

			$array[$i]["category"] = $row->eqca_category;

			$array[$i]["qty"] = $row->assy_qty;

			$array[$i]["rate"] = $row->assy_price;

			$array[$i]["amount"] = ($row->assy_qty) * ($row->assy_price);

			$array[$i]["action"] = '<a href="javascript:void(0)" title="Edit" class="btn btn-sm btn-primary view" data-id=' . $row->assy_assyid . ' data-viewurl=' . base_url("/ams/asset_sync/asset_sync_summary_view") . ' data-displaydiv="assets" data-heading="Asset Sync Summary View"  data-detailid=' . $row->assy_assyid . ' ><i class="fa fa-eye" aria-hidden="true"></i></a>&nbsp;';

			$i++;
		}

		//echo"<pre>";print_r($data);die;

		$get = $_GET;

		echo json_encode(array("recordsFiltered" => $filtereddata, "recordsTotal" => $totalrecs, "data" => $array));
	}

	public function sync_list()

	{

		$this->data['equipmentcategory'] = $this->general->get_tbl_data('*', 'eqca_equipmentcategory', array('eqca_equiptypeid' => 2), 'eqca_equipmentcategoryid', 'DESC');

		$this->data['page_title'] = 'Asset Synch List';

		$this->data['tab_type'] = "assets_synch_list";

		$seo_data = '';

		if ($seo_data) {
			// echo "seo data ";
			// die

			//set SEO data

			$this->page_title = $seo_data->page_title;

			$this->data['meta_keys'] = $seo_data->meta_key;

			$this->data['meta_desc'] = $seo_data->meta_description;
		} else {

			//set SEO data

			$this->page_title = ORGA_NAME;

			$this->data['meta_keys'] = ORGA_NAME;

			$this->data['meta_desc'] = ORGA_NAME;
		}

		$this->template

			->set_layout('general')

			->enable_parser(FALSE)

			->title($this->page_title)

			->build('asset_sync/v_asset_sync_main', $this->data);
	}

	public function asset_sync_summary()

	{

		$this->data['equipmentcategory'] = $this->general->get_tbl_data('*', 'eqca_equipmentcategory', array('eqca_equiptypeid' => 2), 'eqca_equipmentcategoryid', 'DESC');

		// $this->db->select('*');

		// $this->db->from('eqca_equipmentcategory ec');

		// $this->db->where('eqca_isnonexp', 'Y');

		// $result = $this->db->get()->result();

		// $this->data['equipmentcategory'] = $result;

		$this->data['supplier_all'] = $this->general->get_tbl_data('*', 'dist_distributors', array('dist_isactive' => 'Y'), 'dist_distributor', 'ASC');
		$this->data['department'] = $this->general->get_tbl_data('*', 'dept_department', array('dept_locationid' => $this->locationid), 'dept_depname', 'ASC');

		$this->data['page_title'] = 'Asset Synch Summary';

		$this->data['tab_type'] = "assets_synch_summary";

		$seo_data = '';

		if ($seo_data) {
			// echo "seo data ";
			// die

			//set SEO data

			$this->page_title = $seo_data->page_title;

			$this->data['meta_keys'] = $seo_data->meta_key;

			$this->data['meta_desc'] = $seo_data->meta_description;
		} else {

			//set SEO data

			$this->page_title = ORGA_NAME;

			$this->data['meta_keys'] = ORGA_NAME;

			$this->data['meta_desc'] = ORGA_NAME;
		}

		$this->template

			->set_layout('general')

			->enable_parser(FALSE)

			->title($this->page_title)

			->build('asset_sync/v_asset_sync_main', $this->data);
	}

	public function asset_sync_items_detail()
	{

		try {

			if ($_SERVER['REQUEST_METHOD'] === 'POST') {

				$this->data['status'] = $this->assets_mdl->get_status(array('asst_isactive' => 'Y'));

				$this->data['condition'] = $this->assets_mdl->get_condition(array('asco_isactive' => 'Y'));

				$this->data['depreciation'] = $this->assets_mdl->get_depreciation(array('dety_isactive' => 'Y'));

				$this->data['manufacturers'] = $this->manufacturers_mdl->get_all_manufacturers();

				$this->data['brand_all'] = $this->general->get_tbl_data('*', 'bran_brand', false, 'bran_brandid', 'DESC');

				$this->data['departments'] = $this->general->get_tbl_data('*', 'dept_department');

				$id = $this->input->post('id');

				$detailid = $this->input->post('detailid');

				if ($id == $detailid) {

					$this->data['assets_data'] = $this->asset_sync_mdl->get_synch_item_data($id);
				}

				$this->data['assets_data'] = $this->assets_mdl->get_all_assets(array('asen_asenid' => $id));

				// echo "<pre>";
				// echo $this->db->last_query();
				// die();

				// echo "<pre>";

				// print_r($this->data['assets_data']);

				// die();

				if (ORGANIZATION_NAME == 'KUKL') :

					$item_details = $this->data['item_details'] = $this->asset_sync_mdl->get_item_details_for_asset_kukl(array('sd.sade_saledetailid' => $id));

				else :

					$item_details = $this->data['item_details'] = $this->asset_sync_mdl->get_item_details_for_asset(array('td.trde_trdeid' => $id));

				endif;

				// echo $this->db->last_query();
				// echo "<pre>";

				// print_r($item_details);

				// die();

				if (!empty($item_details)) {

					$issynch = !empty($item_details[0]->trde_isassetsync) ? $item_details[0]->trde_isassetsync : '';

					if ($issynch == 'Y') {

						// echo "Already Synch Into Assets";

						// redirect(base_url().'/ams/asset_sync');

						redirect('/ams/asset_sync', 'refresh');
						exit;
					}
				}

				$item_name = !empty($item_details[0]->itli_itemname) ? $item_details[0]->itli_itemname : '';

				$item_id = !empty($item_details[0]->itli_itemlistid) ? $item_details[0]->itli_itemlistid : '';

				$fyear = !empty($item_details[0]->trma_fyear) ? $item_details[0]->trma_fyear : '';

				// print_r($item_id);die();

				$this->data['asset_code'] = $this->generate_asset_code($item_name, $item_id, $fyear);

				// if(ORGANIZATION_NAME=='KU'){

				// 	$this->data['serial_no']=$this->generate_serial_code($item_details);

				// }

				// print_r($this->data['asset_code']);die();

				$seo_data = '';

				if ($seo_data) {

					//set SEO data

					$this->page_title = $seo_data->page_title;

					$this->data['meta_keys'] = $seo_data->meta_key;

					$this->data['meta_desc'] = $seo_data->meta_description;
				} else {

					//set SEO data

					$this->page_title = ORGA_NAME;

					$this->data['meta_keys'] = ORGA_NAME;

					$this->data['meta_desc'] = ORGA_NAME;
				}

				if (defined('ORGANIZATION_NAME')) :

					if (ORGANIZATION_NAME == 'KUKL') :

						$this->template

							->set_layout('general')

							->enable_parser(FALSE)

							->title($this->page_title)

							->build('asset_sync/' . REPORT_SUFFIX . '/v_asset_sync_item_detail_modal', $this->data);

					elseif (ORGANIZATION_NAME == 'KU' || ORGANIZATION_NAME=='ARMY') :

						$this->template

							->set_layout('general')

							->enable_parser(FALSE)

							->title($this->page_title)

							->build('asset_sync/' . REPORT_SUFFIX . '/v_asset_sync_item_detail_modal', $this->data);

					else :

						$this->template

							->set_layout('general')

							->enable_parser(FALSE)

							->title($this->page_title)

							->build('asset_sync/v_asset_sync_item_detail_modal', $this->data);

					endif;

				else :

					$this->template

						->set_layout('general')

						->enable_parser(FALSE)

						->title($this->page_title)

						->build('asset_sync/v_asset_sync_item_detail_modal', $this->data);

				endif;
			} else {

				print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));

				exit;
			}
		} catch (Exception $e) {

			throw $e;
		}
	}

	public function generate_serial_code($itemarr = array())
	{

		echo "<pre>";

		print_r($itemarr);

		die();
	}

	public function get_asset_code($item_name = false)
	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			try {

				$asset_name = $item_name;

				if (!empty($asset_name)) {

					$format = $this->generate_asset_code($asset_name);

					print_r(json_encode(array('status' => 'success', 'asset_code' => $format,  'message' => 'Successfully Created!!')));

					exit;
				}
			} catch (Exception $e) {

				throw $e;
			}
		} else {

			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));

			exit;
		}
	}

	public function generate_asset_code($asset_name, $itemid = false, $fiscalyear = false)
	{

		$wordcount = str_word_count($asset_name);

		// print_r('wc'.$wordcount);

		// die();

		$asset_code = '';

		if ($wordcount == 1) {

			$asset_code = strtoupper(substr($asset_name, 0, 3));
		}

		if ($wordcount == 2) {

			$stringarray = explode(' ', $asset_name);

			// print_r($stringarray);

			$str1 = strtoupper(substr($stringarray[0], 0, 2));

			$str2 = strtoupper(substr($stringarray[1], 0, 1));

			$asset_code = $str1 . $str2;
		}

		if ($wordcount == 3) {

			$stringarray = explode(' ', $asset_name);

			// print_r($stringarray);

			$str1 = strtoupper(substr($stringarray[0], 0, 1));

			$str2 = strtoupper(substr($stringarray[1], 0, 1));

			$str3 = strtoupper(substr($stringarray[2], 0, 1));

			$asset_code = $str1 . $str2 . $str3;
		}

		if ($wordcount >= 4) {

			$stringarray = explode(' ', $asset_name);

			// print_r($stringarray);

			$str1 = strtoupper(substr($stringarray[0], 0, 1));

			$str2 = strtoupper(substr($stringarray[1], 0, 1));

			$str3 = strtoupper(substr($stringarray[2], 0, 1));

			$str4 = !empty($stringarray[3]) ? strtoupper(substr($stringarray[3], 0, 1)) : '';

			$asset_code = $str1 . $str2 . $str3;
		}

		// echo $asset_code;

		// die();

		// $asset_list = $this->general->get_tbl_data('asen_maxval','asen_assetentry',array('asen_description'=>$itemid),'asen_asenid','DESC');

		$maxval = 0;

		$this->db->select('asen_assetcode');

		$this->db->from('asen_assetentry');

		$this->db->where('asen_description', $itemid);

		$this->db->where('asen_assetcode!=', '');

		$this->db->order_by('asen_asenid', 'DESC');

		$this->db->limit(1);

		$rslt = $this->db->get()->row();

		// echo $this->db->last_query();

		// die();

		// echo "<pre>";

		// print_r($rslt);

		// die();

		if (!empty($rslt)) {

			// echo "asd";

			// die();

			$assetecode = !empty($rslt->asen_assetcode) ? $rslt->asen_assetcode : '';
			// var_dump($assetecode);
			// die;

			// echo end( explode( "-", $assetecode ) );

			$asscode_array = explode('-', $assetecode);

			// if(!empty($asscode_array)){

			// 	$ass_Array1=$asscode_array[0];

			// 	$ass_Array2=$asscode_array[1];

			// }

			// $maxval=$ass_Array2;

			// if()

			if (is_array($asscode_array) && !empty($asscode_array)) {

				$sizeofassets = sizeof($asscode_array);
			} else {

				$sizeofassets = 0;
			}

			// echo $sizeofassets;

			// die();

			$numberfilter = $asscode_array[$sizeofassets - 2];

			// echo $numberfilter;

			// die();

			$length_of_number_filter = strlen($numberfilter);

			$increment_assets_number = $numberfilter + 1;

			$final_number_gen = str_pad($increment_assets_number, $length_of_number_filter, 0, STR_PAD_LEFT);

			$new_ass_code_arr_str = '';

			if (!empty($asscode_array)) {

				for ($i = 0; $i < $sizeofassets - 2; $i++) {

					$new_ass_code_arr_str .= $asscode_array[$i] . '-';
				}
			}

			$final_assets_code = $new_ass_code_arr_str . $final_number_gen;
		} else {

			$increment_assets_number = 1;

			$final_number_gen = str_pad($increment_assets_number, AUTO_ASSET_CODE_LENGTH, 0, STR_PAD_LEFT);

			// echo $final_number_gen;

			// die();
			$asset_code = preg_replace('/[^A-Za-z0-9\-]/', '', $asset_code);
			$final_assets_code = $asset_code . '-' . $final_number_gen;
		}

		// echo $final_assets_code;

		// die();

		if (!empty($fiscalyear)) {

			return $final_assets_code . '-' . $fiscalyear;
		}

		return $final_assets_code;
	}

	public function save_asset_sync($print = false)
	{

		// echo "test";

		// die();

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			try {

				$this->form_validation->set_rules($this->asset_sync_mdl->validate_settings_asset_sync);

				if ($this->form_validation->run() == TRUE) {

					if (ORGANIZATION_NAME == 'KUKL') {

						$trans = $this->asset_sync_mdl->save_asset_sync_kukl();
					} else {

						$trans = $this->asset_sync_mdl->save_asset_sync(); 
					}

					if ($trans) {

						if ($print == "print") {

							$this->data = array();

							if (ORGANIZATION_NAME == 'KU' || ORGANIZATION_NAME=='ARMY') {
								$this->data['assets_data'] = $this->assets_mdl->get_all_assets(array('asen_syncid' => $trans));
								// echo "<pre>";
								// print_r($this->data['assets_data']);
								// die();
								$transaction_id = $this->general->get_tbl_data('assy_trdeid', 'assy_assetsync', array('assy_assyid' => $trans));
								$this->data['item_details'] = $this->asset_sync_mdl->get_item_details_for_asset(array('td.trde_trdeid' => $transaction_id[0]->assy_trdeid));
								// var_dump($this->data);
								// die;
								$print_report = $this->load->view('ams/asset_sync/' . REPORT_SUFFIX . '/v_assets_code_reprint', $this->data, true);

								// $print_report = $this->load->view('ams/asset_sync/' . REPORT_SUFFIX . '/v_assets_code_print', $this->data, true);
							} else {
								$this->data['assets_data'] = $this->assets_mdl->get_all_assets(array('asen_syncid' => $trans));
								// echo "<pre>";
								// print_r($this->data['assets_data']);
								// die();
								$transaction_id = $this->general->get_tbl_data('assy_trdeid', 'assy_assetsync', array('assy_assyid' => $trans));
								$this->data['item_details'] = $this->asset_sync_mdl->get_item_details_for_asset(array('td.trde_trdeid' => $transaction_id[0]->assy_trdeid));
								// var_dump($this->data);
								// die;
								$print_report = $this->load->view('ams/asset_sync/v_assets_code_reprint', $this->data, true);
							}

							print_r(json_encode(array('status' => 'success', 'message' => 'Record Save Successfully', 'print_report' => $print_report)));

							exit;
						}

						print_r(json_encode(array('status' => 'success', 'message' => 'Record Save Successfully')));

						exit;
					} else {

						print_r(json_encode(array('status' => 'error', 'message' => 'Operation Unsuccessful')));

						exit;
					}
				} else {

					print_r(json_encode(array('status' => 'error', 'message' => validation_errors())));

					exit;
				}
			} catch (Exception $e) {

				print_r(json_encode(array('status' => 'error', 'message' => $e->getMessage())));
			}
		} else {

			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));

			exit;
		}
	}

	public function reprint_asset_code()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$sync_id = $this->input->post('id');
			$this->data['assets_data'] = $this->assets_mdl->get_all_assets(array('asen_syncid' => $sync_id));
			// echo "<pre>";
			// print_r($this->data['assets_data']);
			// die();
			$transaction_id = $this->general->get_tbl_data('assy_trdeid', 'assy_assetsync', array('assy_assyid' => $sync_id));
			$this->data['item_details'] = $this->asset_sync_mdl->get_item_details_for_asset(array('td.trde_trdeid' => $transaction_id[0]->assy_trdeid));
			// var_dump($this->data);
			// die;
			if (ORGANIZATION_NAME == 'KU' || ORGANIZATION_NAME == 'ARMY' ) {
				$print_report = $this->load->view('ams/asset_sync/' . REPORT_SUFFIX . '/v_assets_code_reprint', $this->data, true);
			} else {
				$print_report = $this->load->view('ams/asset_sync/v_assets_code_reprint', $this->data, true);
			}

			print_r(json_encode(array('status' => 'success', 'message' => 'Template Fetched Successfully', 'tempform' => $print_report)));
			exit;
		}
	}

	public function sticker_print()

	{

		$_POST['asen_depid'] = '311';

		$_POST['asen_assetcode'] = array('8P-0001-077/78', '8P-0002-077/78');

		// $this->data=array();

		$this->load->view('ams/asset_sync/ku/v_assets_code_print');
	}
}