<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Receive_against_order extends CI_Controller
{
	function __construct()
	{

		parent::__construct();
		$this->load->Model('receive_against_order_mdl');
		$this->load->Model('direct_purchase_mdl');
		$this->storeid = $this->session->userdata(STORE_ID);
		$this->userid = $this->session->userdata(USER_ID);
		$this->locationid = $this->session->userdata(LOCATION_ID);
		$this->orgid = $this->session->userdata(ORG_ID);
		$this->username = $this->session->userdata(USER_NAME);

		if (defined('LOCATION_CODE')) {
			$this->locationcode = $this->session->userdata(LOCATION_CODE);
		}

		$this->location_ismain = $this->session->userdata(ISMAIN_LOCATION);
		$this->usergroup = $this->session->userdata(USER_GROUPCODE);

		$this->userdept = $this->session->userdata(USER_DEPT);

		$this->mattypeid = $this->session->userdata(USER_MAT_TYPEID);

		$this->show_location_group = array('SA', 'SK', 'SI');

		$this->load->library('upload');
		$this->load->library('image_lib');
		$this->load->helper('file');
		$this->load->helper('form');
	}

	public function index($reload = false)
	{

		$order_masterid = $this->input->post('id');
		$orderno = '';
		if (!empty($order_masterid)) {
			$get_orderno = $this->general->get_tbl_data('puor_orderno', 'puor_purchaseordermaster', array('puor_purchaseordermasterid' => $order_masterid));
			if (!empty($get_orderno)) {
				$orderno = !empty($get_orderno[0]->puor_orderno) ? $get_orderno[0]->puor_orderno : '';
			}
		}
		$this->data['order_no'] = $orderno;

		$locationid = $this->session->userdata(LOCATION_ID);
		$this->data['store_type'] = $this->general->get_tbl_data('*', 'store', false, 'st_store_id', 'ASC');

		// echo $this->db->last_query();
		// die();
		$this->data['tab_type'] = 'entry';
		$this->data['fiscal'] = $this->general->get_tbl_data('*', 'fiye_fiscalyear', false, 'fiye_fiscalyear_id', 'DESC', '2');

		$this->data['supplier_all'] = $this->general->get_tbl_data('*', 'dist_distributors', false, 'dist_distributor', 'ASC');

		// echo "<pre>";print_r($this->data['material_type']);die();
		$this->data['department'] = $this->general->get_tbl_data('*', 'dept_department', array('dept_locationid' => $this->locationid), 'dept_depid', 'DESC');
		if (!empty($this->mattypeid)) {
			$srchmat = array('maty_materialtypeid' => $this->mattypeid, 'maty_isactive' => 'Y');
			$srchbudg = array('budg_materialtypeid' => $this->mattypeid);
		} else {
			$srchmat = array('maty_isactive' => 'Y');
			$srchbudg = '';
		}
		$srchbudg = '';
		$this->data['budgets_list'] = $this->general->get_tbl_data('*', 'budg_budgets', $srchbudg, 'budg_budgetname', 'ASC');
		// echo $this->db->last_query();
		// die();

		// echo "<pre>";
		// print_r($this->data['budgets_list']);
		// die();

		$this->data['material_type'] = $this->general->get_tbl_data('maty_materialtypeid,maty_material', 'maty_materialtype', $srchmat, 'maty_materialtypeid', 'ASC');

		$currentfyrs = CUR_FISCALYEAR;

		// echo ORGANIZATION_NAME;
		// die();

		$this->db->select('recm_invoiceno,recm_fyear')
			->from('recm_receivedmaster')
			->where('recm_locationid', $locationid);
		if (ORGANIZATION_NAME == 'KU' || ORGANIZATION_NAME=='ARMY' ) {
			if ($this->mattypeid) {
				$this->db->where('recm_mattypeid', $this->mattypeid);
			} else {
				$this->db->where('recm_mattypeid', 1);
			}
		}

		$cur_fiscalyrs_invoiceno = $this->db->order_by('recm_fyear', 'DESC')
			->limit(1)
			->get()->row();

		// echo "<pre>";
		// echo($this->db->last_query());
		// die();

		// echo "<pre>";
		// print_r($cur_fiscalyrs_invoiceno);
		// die();

		if (!empty($cur_fiscalyrs_invoiceno)) {
			$invoice_format = $cur_fiscalyrs_invoiceno->recm_invoiceno;

			$invoice_string = str_split($invoice_format);
			// echo "<pre>";
			// print_r($invoice_string);
			// die();
			$invoice_prefix_len = strlen(RECEIVED_NO_PREFIX);
			$chk_first_string_after_invoice_prefix = $invoice_string[$invoice_prefix_len];
			// echo $chk_first_string_after_invoice_prefix;
			// die();
			if ($chk_first_string_after_invoice_prefix == '0') {
				$invoice_no_prefix = RECEIVED_NO_PREFIX . CUR_FISCALYEAR;
			} else if ($cur_fiscalyrs_invoiceno->recm_fyear == $currentfyrs && $chk_first_string_after_invoice_prefix == '0') {
				$invoice_no_prefix = RECEIVED_NO_PREFIX . CUR_FISCALYEAR;
			} else if ($cur_fiscalyrs_invoiceno->recm_fyear != $currentfyrs && $chk_first_string_after_invoice_prefix == '0') {
				$invoice_no_prefix = RECEIVED_NO_PREFIX . CUR_FISCALYEAR;
			} else if ($cur_fiscalyrs_invoiceno->recm_fyear != $currentfyrs && $chk_first_string_after_invoice_prefix != '0') {
				$invoice_no_prefix = RECEIVED_NO_PREFIX . CUR_FISCALYEAR;
			} else {
				$invoice_no_prefix = RECEIVED_NO_PREFIX;
			}
		} else {
			$invoice_no_prefix = RECEIVED_NO_PREFIX . CUR_FISCALYEAR;
		}

		// $this->data['received_no']=$this->generate_receiveno();
		if (ORGANIZATION_NAME == 'KU' || ORGANIZATION_NAME == 'PU') {
			$invoice_no_prefix = '';
			if ($this->mattypeid) {
				$mattypeid = $this->mattypeid;
			} else {
				$mattypeid = 1;
			}

			if(ORGANIZATION_NAME=='PU'){
				$srch=array();
			}else{
				$srch= array('recm_mattypeid' => $mattypeid);
			}

			$this->data['received_no'] = $this->general->generate_invoiceno('recm_invoiceno', 'recm_invoiceno', 'recm_receivedmaster', $invoice_no_prefix, RECEIVED_NO_LENGTH,$srch, 'recm_locationid', 'recm_fyear DESC ,recm_receivedmasterid  DESC', 'M', false, 'Y');
			
			// echo $this->db->last_query();
			// die();
		} else {
			$this->data['received_no'] = $this->general->generate_invoiceno('recm_invoiceno', 'recm_invoiceno', 'recm_receivedmaster', $invoice_no_prefix, RECEIVED_NO_LENGTH, false, 'recm_locationid', 'recm_fyear DESC ,recm_receivedmasterid  DESC', 'M');
		}

		if ($reload == 'reload') {
			$this->data['loadselect2'] = 'yes';
			if (ORGANIZATION_NAME == 'KU' ||  ORGANIZATION_NAME == 'ARMY' || ORGANIZATION_NAME == 'PU') {
				$this->load->view('receive_against_order/'.REPORT_SUFFIX.'/v_receive_against_order_form', $this->data);
			} else {
				$this->load->view('receive_against_order/v_receive_against_order_form', $this->data);
			}
		} else {
			$this->data['loadselect2'] = 'no';
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
				->build('receive_against_order/v_against_order', $this->data);
		}
	}

	public function form_direct_received_items()
	{
		$locationid = $this->session->userdata(LOCATION_ID);

		$this->data['store_type'] = $this->general->get_tbl_data('*', 'store', false, 'st_store_id', 'ASC');
		$this->data['tab_type'] = 'entry';
		$this->data['fiscal'] = $this->general->get_tbl_data('*', 'fiye_fiscalyear', false, 'fiye_fiscalyear_id', 'DESC', '2');
		$this->data['supplier_all'] = $this->general->get_tbl_data('*', 'dist_distributors', false, 'dist_distributor', 'ASC');
		$this->data['budgets_list'] = $this->general->get_tbl_data('*', 'budg_budgets', false, 'budg_budgetname', 'ASC');
		// echo "<pre>";print_r($this->data['budgets_list']);die();
		// $this->data['received_no']=$this->generate_receiveno();
		$locationid = $this->session->userdata(LOCATION_ID);
		$currentfyrs = CUR_FISCALYEAR;

		$cur_fiscalyrs_invoiceno = $this->db->select('recm_invoiceno,recm_fyear')
			->from('recm_receivedmaster')
			->where('recm_locationid', $locationid)
			// ->where('recm_fyear',$currentfyrs)
			->order_by('recm_fyear', 'DESC')
			->limit(1)
			->get()->row();

		// echo "<pre>";
		// print_r($cur_fiscalyrs_invoiceno);
		// die();

		if (!empty($cur_fiscalyrs_invoiceno)) {
			$invoice_format = $cur_fiscalyrs_invoiceno->recm_invoiceno;

			$invoice_string = str_split($invoice_format);
			// echo "<pre>";
			// print_r($invoice_string);
			// die();
			$invoice_prefix_len = strlen(RECEIVED_NO_PREFIX);
			$chk_first_string_after_invoice_prefix = $invoice_string[$invoice_prefix_len];
			// echo $chk_first_string_after_invoice_prefix;
			// die();
			if ($chk_first_string_after_invoice_prefix == '0') {
				$invoice_no_prefix = RECEIVED_NO_PREFIX . CUR_FISCALYEAR;
			} else if ($cur_fiscalyrs_invoiceno->recm_fyear == $currentfyrs && $chk_first_string_after_invoice_prefix == '0') {
				$invoice_no_prefix = RECEIVED_NO_PREFIX . CUR_FISCALYEAR;
			} else if ($cur_fiscalyrs_invoiceno->recm_fyear != $currentfyrs && $chk_first_string_after_invoice_prefix == '0') {
				$invoice_no_prefix = RECEIVED_NO_PREFIX . CUR_FISCALYEAR;
			} else if ($cur_fiscalyrs_invoiceno->recm_fyear != $currentfyrs && $chk_first_string_after_invoice_prefix != '0') {
				$invoice_no_prefix = RECEIVED_NO_PREFIX . CUR_FISCALYEAR;
			} else {
				$invoice_no_prefix = RECEIVED_NO_PREFIX;
			}
		} else {
			$invoice_no_prefix = RECEIVED_NO_PREFIX . CUR_FISCALYEAR;
		}

		// $this->data['received_no']=$this->generate_receiveno();

		$this->data['received_no'] = $this->general->generate_invoiceno('recm_invoiceno', 'recm_invoiceno', 'recm_receivedmaster', $invoice_no_prefix, RECEIVED_NO_LENGTH, false, 'recm_locationid', 'recm_fyear DESC ,recm_receivedmasterid  DESC', 'M');

		$this->data['loadselect2'] = 'yes'; 
		$this->load->view('receive_against_order/v_receive_against_order_form', $this->data);
	}

	public function form_received_form()
	{
		$this->data['loadselect2'] = 'yes';
		$this->data['store_type'] = $this->general->get_tbl_data('*', 'store', false, 'st_store_id', 'ASC');
		$this->data['tab_type'] = 'entry';
		$this->data['fiscal'] = $this->general->get_tbl_data('*', 'fiye_fiscalyear', false, 'fiye_fiscalyear_id', 'DESC', '2');
		$this->data['supplier_all'] = $this->general->get_tbl_data('*', 'dist_distributors', false, 'dist_distributor', 'ASC');
		$this->data['budgets_list'] = $this->general->get_tbl_data('*', 'budg_budgets', false, 'budg_budgetname', 'ASC');
		// echo "<pre>";
		// print_r($this->data['budgets_list']);
		// die();
		$currentfyrs = CUR_FISCALYEAR;
		// $this->data['received_no']=$this->generate_receiveno();
		$cur_fiscalyrs_invoiceno = $this->db->select('recm_invoiceno,recm_fyear')
			->from('recm_receivedmaster')
			->where('recm_locationid', $locationid)
			// ->where('recm_fyear',$currentfyrs)
			->order_by('recm_fyear', 'DESC')
			->limit(1)
			->get()->row();

		// echo "<pre>";
		// print_r($cur_fiscalyrs_invoiceno);
		// die();

		if (!empty($cur_fiscalyrs_invoiceno)) {
			$invoice_format = $cur_fiscalyrs_invoiceno->recm_invoiceno;

			$invoice_string = str_split($invoice_format);
			// echo "<pre>";
			// print_r($invoice_string);
			// die();
			$invoice_prefix_len = strlen(RECEIVED_NO_PREFIX);
			$chk_first_string_after_invoice_prefix = $invoice_string[$invoice_prefix_len];
			// echo $chk_first_string_after_invoice_prefix;
			// die();
			if ($chk_first_string_after_invoice_prefix == '0') {
				$invoice_no_prefix = RECEIVED_NO_PREFIX . CUR_FISCALYEAR;
			} else if ($cur_fiscalyrs_invoiceno->recm_fyear == $currentfyrs && $chk_first_string_after_invoice_prefix == '0') {
				$invoice_no_prefix = RECEIVED_NO_PREFIX . CUR_FISCALYEAR;
			} else if ($cur_fiscalyrs_invoiceno->recm_fyear != $currentfyrs && $chk_first_string_after_invoice_prefix == '0') {
				$invoice_no_prefix = RECEIVED_NO_PREFIX . CUR_FISCALYEAR;
			} else if ($cur_fiscalyrs_invoiceno->recm_fyear != $currentfyrs && $chk_first_string_after_invoice_prefix != '0') {
				$invoice_no_prefix = RECEIVED_NO_PREFIX . CUR_FISCALYEAR;
			} else {
				$invoice_no_prefix = RECEIVED_NO_PREFIX;
			}
		} else {
			$invoice_no_prefix = RECEIVED_NO_PREFIX . CUR_FISCALYEAR;
		}

		// $this->data['received_no']=$this->generate_receiveno();

		$this->data['received_no'] = $this->general->generate_invoiceno('recm_invoiceno', 'recm_invoiceno', 'recm_receivedmaster', $invoice_no_prefix, RECEIVED_NO_LENGTH, false, 'recm_locationid', 'recm_fyear DESC ,recm_receivedmasterid  DESC', 'M');

		// die();
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
		$this->load->view('receive_against_order/v_receive_against_order_form', $this->data);
	}

	public function get_account_head_acc_to_material()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$mattypeid = $this->input->post('mattypeid');
			$budgets_list = $this->general->get_tbl_data('*', 'budg_budgets', array('budg_materialtypeid' => $mattypeid), 'budg_budgetname', 'ASC');
			if(ORGANIZATION_NAME=='ARMY'){
				$budgets_list = $this->general->get_tbl_data('*', 'budg_budgets', false, 'budg_budgetname', 'ASC');
			}
	
			if (!empty($budgets_list)) {
				$budget_option = '<option value="">--select--</option>';
				foreach ($budgets_list as $key => $bl) {
					$budget_option .= "<option value='$bl->budg_budgetid'>$bl->budg_budgetname</option>";
				}

				print_r(json_encode(array('status' => 'success', 'budget_option' => $budget_option, 'message' => 'Data Selection')));
				exit;
			} else {

				print_r(json_encode(array('status' => 'error', 'budget_option' => array(), 'message' => 'Record Empty')));
			}
		} else {

			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		}
	}

	public function gen_receive_invoice()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$fyrs = $this->input->post('fyrs');
			$mattype = $this->input->post('mattype');

			$locationid = $this->session->userdata(LOCATION_ID);
			// $currentfyrs=CUR_FISCALYEAR;

			if (ORGANIZATION_NAME == 'KU' || ORGANIZATION_NAME == 'ARMY' || ORGANIZATION_NAME == 'PU') {
				if ($mattype) {
					$this->db->where('recm_mattypeid', $mattype);
				}
			}
			$cur_fiscalyrs_invoiceno = $this->db->select('recm_invoiceno,recm_fyear')
				->from('recm_receivedmaster')
				->where('recm_locationid', $locationid)
				->where('recm_fyear', $fyrs)
				->order_by('recm_fyear', 'DESC')
				->limit(1)
				->get()->row();

			// echo "<pre>";
			// echo $this->db->last_query();
			// die();

			if (!empty($cur_fiscalyrs_invoiceno)) {
				$invoice_format = $cur_fiscalyrs_invoiceno->recm_invoiceno;

				$invoice_string = str_split($invoice_format);
				// echo "<pre>";
				// print_r($invoice_string);
				// die();
				$invoice_prefix_len = strlen(RECEIVED_NO_PREFIX);
				$chk_first_string_after_invoice_prefix = $invoice_string[$invoice_prefix_len];
				// echo $chk_first_string_after_invoice_prefix;
				// die();
				if ($chk_first_string_after_invoice_prefix == '0') {
					$invoice_no_prefix = RECEIVED_NO_PREFIX . CUR_FISCALYEAR;
				} else if ($cur_fiscalyrs_invoiceno->recm_fyear == $fyrs && $chk_first_string_after_invoice_prefix == '0') {
					$invoice_no_prefix = RECEIVED_NO_PREFIX . CUR_FISCALYEAR;
				} else if ($cur_fiscalyrs_invoiceno->recm_fyear != $fyrs && $chk_first_string_after_invoice_prefix == '0') {
					$invoice_no_prefix = RECEIVED_NO_PREFIX . CUR_FISCALYEAR;
				} else if ($cur_fiscalyrs_invoiceno->recm_fyear != $fyrs && $chk_first_string_after_invoice_prefix != '0') {
					$invoice_no_prefix = RECEIVED_NO_PREFIX . CUR_FISCALYEAR;
				} else {
					$invoice_no_prefix = RECEIVED_NO_PREFIX;
				}
			} else {
				$invoice_no_prefix = RECEIVED_NO_PREFIX . CUR_FISCALYEAR;
			}

			// $this->data['received_no']=$this->generate_receiveno();
			if (ORGANIZATION_NAME == 'KU' || ORGANIZATION_NAME == 'ARMY' || ORGANIZATION_NAME == 'PU' ) {
				$received_no =  $this->general->generate_invoiceno('recm_invoiceno', 'recm_invoiceno', 'recm_receivedmaster', false, RECEIVED_NO_LENGTH, array('recm_mattypeid' => $mattype, 'recm_fyear' => $fyrs), 'recm_locationid', 'recm_fyear DESC ,recm_receivedmasterid  DESC', 'M', false, 'Y');
			} else {
				$received_no =  $this->general->generate_invoiceno('recm_invoiceno', 'recm_invoiceno', 'recm_receivedmaster', $invoice_no_prefix, RECEIVED_NO_LENGTH, false, 'recm_locationid', 'recm_fyear DESC ,recm_receivedmasterid  DESC', 'M');
			}

			// echo $received_no;
			// die();
			print_r(json_encode(array('status' => 'success', 'received_no' => $received_no)));
			exit;
		} else {
			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		}
	}

	public function received_order_item_details()
	{
		$this->data['store_type'] = $this->general->get_tbl_data('*', 'eqty_equipmenttype', false, 'eqty_equipmenttypeid', 'ASC');
		$this->data['supplier_all'] = $this->general->get_tbl_data('*', 'dist_distributors', false, 'dist_distributor', 'ASC');
		if (!empty($this->mattypeid)) {
			$srchmat = array('maty_materialtypeid' => $this->mattypeid, 'maty_isactive' => 'Y');
		} else {
			$srchmat = array('maty_isactive' => 'Y');
		}
		$this->data['material_type'] = $this->general->get_tbl_data('maty_materialtypeid,maty_material', 'maty_materialtype', $srchmat, 'maty_materialtypeid', 'ASC');
		$this->data['department'] = $this->general->get_tbl_data('*', 'dept_department', array('dept_locationid' => $this->locationid), 'dept_depid', 'DESC');
		$this->data['tab_type'] = 'detailslist';
		$this->data['loadselect2'] = 'yes';
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
			->build('receive_against_order/v_against_order', $this->data);
	}
	public function received_order_item_details_lists()
	{

		if (MODULES_VIEW == 'N') {
			$array = array();
			// $this->general->permission_denial_message();
			echo json_encode(array("recordsFiltered" => 0, "recordsTotal" => 0, "data" => $array));
			exit;
		}

		//echo "terst";die;
		$useraccess = $this->session->userdata(USER_ACCESS_TYPE);
		//echo $this->db->last_query();die();
		$i = 0;
		if (ORGANIZATION_NAME == 'KU' || ORGANIZATION_NAME == 'ARMY' || ORGANIZATION_NAME == 'PU'  ) {
			$data = $this->receive_against_order_mdl->get_receive_against_order_details_list_ku();
		} else {
			$data = $this->receive_against_order_mdl->get_receive_against_order_details_list();
		}

		// echo"<pre>";print_r($data);die;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"] > 0 ? $data["totalfilteredrecs"] : $data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

		//echo "<pre>";print_r($data);die;
		unset($data["totalfilteredrecs"]);
		unset($data["totalrecs"]);
		foreach ($data as $row) {
			if (ITEM_DISPLAY_TYPE == 'NP') {
				$rec_itemname = !empty($row->itli_itemnamenp) ? $row->itli_itemnamenp : $row->itli_itemname;
			} else {
				$rec_itemname = !empty($row->itli_itemname) ? $row->itli_itemname : '';
			}

			$array[$i]["sno"] = $i + 1;
			$pur_type = '';
			if ($row->recm_dstat == 'D') {
				$pur_type = 'D.Purchase';
			}
			$array[$i]['orderno'] = !empty($row->recm_purchaseorderno) ? $row->recm_purchaseorderno : $pur_type;

			// $array[$i]['orderno'] = !empty($row->recm_purchaseorderno) ? $row->recm_purchaseorderno : "Challan: " . $row->recm_challanno;
			$array[$i]['challan_no'] = $row->recm_challanno;
			$array[$i]['itli_itemname'] = $rec_itemname;
			$array[$i]['recm_fyear'] = $row->recm_fyear;

			$array[$i]['unit_unitname'] = $row->unit_unitname;
			$array[$i]['recd_purchasedqty'] = sprintf('%g',$row->recd_purchasedqty);
			$array[$i]['recd_discount'] = $row->recd_discountamt;
			$array[$i]['recd_vatamt'] = $row->recd_vatamt;
			$array[$i]['recd_amount'] = $row->recd_amount;
			$array[$i]['description'] = !empty($row->recd_description) ? $row->recd_description : '';

			$array[$i]['expiry_date'] = !empty($row->recd_expdatebs) ? $row->recd_expdatebs : '-';
			$array[$i]['batchno'] = !empty($row->recd_batchno) ? $row->recd_batchno : '-';

			if (ORGANIZATION_NAME == 'KU' || ORGANIZATION_NAME == 'PU') {
				$school = $row->schoolname;
				$fromdep = $row->fromdep;
				$fromdepparent = $row->fromdepparent;
				if (!empty($fromdepparent)) {
					$dep_info = $fromdepparent . '/' . $fromdep;
				} else {
					$dep_info = $fromdep;
				}

				$array[$i]["department"] = $school . '-' . $dep_info;
			}
			$array[$i]['receivedby'] = !empty($row->recm_receivedby) ? $row->recm_receivedby : '';
			$array[$i]['mattype'] = !empty($row->maty_material) ? $row->maty_material : '';

			// if(DEFAULT_DATEPICKER=='NP')
			// {
			// 	$array[$i]['recm_receiveddatebs'] = $row->recm_receiveddatebs;
			// }else{
			// 	$array[$i]['recm_receiveddatebs'] = $row->recm_receiveddatead;
			// }
			$array[$i]['recm_receiveddatebs'] = $row->recm_receiveddatebs;
			$array[$i]['recm_supbilldatebs'] = $row->recm_supbilldatebs;
			$array[$i]['rate'] = $row->recd_unitprice;
			$array[$i]['total'] =  sprintf('%0.2f', $row->total);
			$array[$i]['supplier'] = $row->dist_distributor;

			// $array[$i]['action'] = '<a href="javascript:void(0)" data-id='.$row->recm_receivedmasterid.' data-displaydiv="" data-viewurl='.base_url('purchase_receive/direct_purchase/direct_purchase_details').' class="view" data-heading="Direct Received Details"><i class="fa fa-eye" title="Return" aria-hidden="true" ></i></a>';
			//$array[$i]['cancel_all'] = '';
			$i++;
		}
		echo json_encode(array("recordsFiltered" => $filtereddata, "recordsTotal" => $totalrecs, "data" => $array));
		//}
	}

	public function received_order_item_list()
	{
		$frmDate = CURMONTH_DAY1;
		$toDate = CURDATE_NP;
		$cur_fiscalyear = CUR_FISCALYEAR;

		$this->data['store_type'] = $this->general->get_tbl_data('*', 'eqty_equipmenttype', false, 'eqty_equipmenttypeid', 'ASC');
		$this->data['supplier_all'] = $this->general->get_tbl_data('*', 'dist_distributors', false, 'dist_distributorid', 'ASC');
		// echo "<pre>"; print_r($this->data['store_type']); die;
		$this->data['department'] = $this->general->get_tbl_data('*', 'dept_department', array('dept_locationid' => $this->locationid), 'dept_depid', 'DESC');

		$this->data['status_count'] = $this->receive_against_order_mdl->getStatusCount(array('recm_receiveddatebs >=' => $frmDate, 'recm_receiveddatebs <=' => $toDate, 'recm_locationid' => $this->locationid));

		// echo $this->db->last_query();
		// die();
		if (!empty($this->mattypeid)) {
			$srchmat = array('maty_materialtypeid' => $this->mattypeid, 'maty_isactive' => 'Y');
		} else {
			$srchmat = array('maty_isactive' => 'Y');
		}
		$this->data['material_type'] = $this->general->get_tbl_data('maty_materialtypeid,maty_material', 'maty_materialtype', $srchmat, 'maty_materialtypeid', 'ASC');

		$this->data['tab_type'] = 'list';
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
			->build('receive_against_order/v_against_order', $this->data);
	}

	public function orderlist_by_order_no()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$orderno = $this->input->post('orderno');
			$fiscalyrs = $this->input->post('fiscalyear');
			$mattypeid = $this->input->post('mattypeid');
			$puor_storeid = $this->session->userdata(STORE_ID);

			if (ORGANIZATION_NAME == 'KUKL') {
				$this->data['order_data'] = $this->receive_against_order_mdl->get_orderlist_by_order_no(array('po.puor_orderno' => $orderno, 'po.puor_fyear' => $fiscalyrs, 'puor_storeid' => $puor_storeid, 'puor_locationid' => $this->locationid, 'puor_verified' => 2));
			} else {

				$srchcol = array('po.puor_orderno' => $orderno, 'po.puor_fyear' => $fiscalyrs, 'puor_storeid' => $puor_storeid, 'puor_locationid' => $this->locationid);

				if (!empty($mattypeid)) {
					$srchcol['po.puro_mattypeid'] = $mattypeid;
				}
				if (!empty($this->mattypeid)) {
					$srchcol['po.puro_mattypeid'] = $this->mattypeid;
				}

				$this->data['order_data'] = $this->receive_against_order_mdl->get_orderlist_by_order_no($srchcol);

				if (ORGANIZATION_NAME == 'KU' || ORGANIZATION_NAME=='ARMY' || ORGANIZATION_NAME == 'PU' ) {
					$purchase_masterid = !empty($this->data['order_data'][0]->puor_purchaseordermasterid) ? $this->data['order_data'][0]->puor_purchaseordermasterid : '';
					if (!empty($purchase_masterid)) {
						$this->db->select('rm.rema_reqfromdepid depid,d.dept_depname depname, rm.rema_school schoolid,loc.loca_name schoolname');
						$this->db->from('puor_purchaseordermaster pm');
						$this->db->join('pure_purchaserequisition pr', 'pr.pure_purchasereqid=pm.puor_purchasereqmasterid', 'LEFT');
						$this->db->join('rema_reqmaster rm', 'rm.rema_reqmasterid=pr.pure_reqmasterid', 'LEFT');
						$this->db->join('dept_department d', 'd.dept_depid=rm.rema_reqfromdepid', 'LEFT');
						$this->db->join('loca_location loc', 'loc.loca_locationid=rm.rema_school', 'LEFT');
						$this->db->where('puor_purchaseordermasterid', $purchase_masterid);
						$result = $this->db->get()->row();
						// echo "<pre>";
						// print_r($result);
						// die();
						if (!empty($result)) {

							$check_parentid = $this->general->get_tbl_data('*', 'dept_department', array('dept_depid' => $result->depid), 'dept_depname', 'ASC');

							// echo "<pre>";
							// print_r($check_parentid);
							// die();
							$this->data['order_data']['parentdepid'] = '';
							if (!empty($check_parentid)) {
								$dep_parentid = !empty($check_parentid[0]->dept_parentdepid) ? $check_parentid[0]->dept_parentdepid : '0';
								if ($dep_parentid != 0) {
									$this->data['parent_depid'] = $dep_parentid;
									$parent_department = $this->general->get_tbl_data('*', 'dept_department', array('dept_depid' => $dep_parentid), 'dept_depname', 'ASC');
								}
								// echo "sad<pre>";
								// print_r($parent_department);
								// die();
								$this->data['order_data']['parentdepid'] = !empty($parent_department[0]->dept_depid) ? $parent_department[0]->dept_depid : '';
							}

							$this->data['order_data']['depid'] = $result->depid;
							$this->data['order_data']['depname'] = $result->depname;
							$this->data['order_data']['schoolid'] = $result->schoolid;
							$this->data['order_data']['schoolname'] = $result->schoolname;
						}
					}
				}
			}

			// echo $this->db->last_query();
			// die();
			// echo $this->db->last_query();die;
			// echo "<pre>";print_r($this->data['order_data']);die();
			$purchased = !empty($this->data['order_data'][0]->puor_purchased) ? $this->data['order_data'][0]->puor_purchased : '';
			$status = !empty($this->data['order_data'][0]->puor_status) ? $this->data['order_data'][0]->puor_status : '';

			if (empty($this->data['order_data'])) {
				print_r(json_encode(array('status' => 'error', 'message' => 'Order no. ' . $orderno . ' is not found!!')));
				exit;
			}
			if ($purchased == '2') {
				print_r(json_encode(array('status' => 'error', 'message' => 'Order no. ' . $orderno . ' has been purchased/received completely')));
				exit;
			}
			if ($status == 'C') {
				print_r(json_encode(array('status' => 'error', 'message' => 'Order no. ' . $orderno . ' is cancelled.')));
				exit;
			}
			if ($status == 'CH') {
				print_r(json_encode(array('status' => 'error', 'message' => 'Order no. ' . $orderno . 'is received through challan.')));
				exit;
			}

			$this->data['order_detail'] = array();
			$tempform = '';
			if ($this->data['order_data']) {
				$ordermasterid = $this->data['order_data'][0]->puor_purchaseordermasterid;
				$this->data['order_detail'] = $this->receive_against_order_mdl->get_orderdetail_list(array('pude_purchasemasterid' => $ordermasterid));
				// echo $this->db->last_query();
				// die();
				// echo "<pre>";
				// print_r($this->data['order_detail']);
				// die();
				if (!empty($this->data['order_detail'])) {
					// echo "asd";
					// die();
					$tempform = $this->load->view('receive_against_order/v_receive_against_order_form_detail', $this->data, true);
				}
			}
			// echo"<pre>"; print_r($tempform);die;
			print_r(json_encode(array('status' => 'success', 'order_data' => $this->data['order_data'], 'tempform' => $tempform, 'message' => 'Selected Successfully')));
			exit;
		} else {
			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		}
	}

	public function received_against_order_list()
	{
		if (MODULES_VIEW == 'N') {
			$array = array();
			// $this->general->permission_denial_message();
			echo json_encode(array("recordsFiltered" => 0, "recordsTotal" => 0, "data" => $array));
			exit;
		}

		$apptype = $this->input->get('apptype');

		$useraccess = $this->session->userdata(USER_ACCESS_TYPE);

		$i = 0;

		if ($apptype == 'cancel') {
			$data = $this->receive_against_order_mdl->get_receive_against_order_list(array('recm_status' => 'M'));
		} else {
			if (ORGANIZATION_NAME == 'KU' || ORGANIZATION_NAME=='ARMY' || ORGANIZATION_NAME == 'PU') {
				$data = $this->receive_against_order_mdl->get_receive_against_order_list_ku();
			} else {
				$data = $this->receive_against_order_mdl->get_receive_against_order_list();
			}
		}

		// echo "<pre>";
		// print_r($this->db->last_query());
		// die();

		// echo"<pre>";print_r($data);die;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"] > 0 ? $data["totalfilteredrecs"] : $data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

		unset($data["totalfilteredrecs"]);
		unset($data["totalrecs"]);
		foreach ($data as $row) {
			$appclass = '';
			$receive_status = $row->recm_status;

			if ($receive_status == 'M') {
				$appclass = 'cancel';
			} else {
				$appclass = '';
			}
			$insurance = !empty($row->recm_insurance) ? $row->recm_insurance : '0.00';
			$carriagefreight = !empty($row->recm_carriagefreight) ? $row->recm_carriagefreight : '0.00';
			$packing = !empty($row->recm_packing) ? $row->recm_packing : '0.00';
			$transportcourier = !empty($row->recm_transportcourier) ? $row->recm_transportcourier : '0.00';
			$others = !empty($row->recm_others) ? $row->recm_others : '0.00';
			$extra = $insurance + $carriagefreight + $packing + $transportcourier + $others;

			if (ORGANIZATION_NAME == 'KU' || ORGANIZATION_NAME == 'PU') {
				$school = $row->schoolname;
				$fromdep = $row->fromdep;
				$fromdepparent = $row->fromdepparent;
				if (!empty($fromdepparent)) {
					$dep_info = $fromdepparent . '/' . $fromdep;
				} else {
					$dep_info = $fromdep;
				}

				$array[$i]["department"] = $school . '-' . $dep_info;
			}

			$array[$i]["approvedclass"] = $appclass;
			$array[$i]["sno"] = $i + 1;
			$array[$i]['recm_receiveddatebs'] = $row->recm_receiveddatebs;
			$array[$i]['recm_fyear'] = $row->recm_fyear;
			$array[$i]['recm_invoiceno'] = $row->recm_invoiceno;
			// $array[$i]['orderno'] = !empty($row->recm_purchaseorderno) ? $row->recm_purchaseorderno : "Challan: " . $row->recm_challanno;
			$pur_type = '';
			if ($row->recm_dstat == 'D') {
				$pur_type = 'D.Purchase';
			}
			$array[$i]['orderno'] = !empty($row->recm_purchaseorderno) ? $row->recm_purchaseorderno : $pur_type;
			$array[$i]['challano'] = $row->recm_challanno;
			$array[$i]['dist_distributor'] = $row->dist_distributor;
			$array[$i]['budg_budgetname'] = $row->budg_budgetname;
			$array[$i]['recm_amount'] = $row->recm_amount;
			$array[$i]['recm_discount'] = $row->recm_discount;
			$array[$i]['recm_taxamount'] = $row->recm_taxamount;
			$array[$i]['extra_amt'] = $extra;
			$array[$i]['receivedby'] = !empty($row->recm_receivedby) ? $row->recm_receivedby : '';
			$array[$i]['recm_clearanceamount'] = $row->recm_clearanceamount;
			$array[$i]['recm_posttime'] = $row->recm_postdatebs."</br>".$row->recm_posttime;
			

			// $array[$i]['order_date'] = $row->orderdate;
			// $array[$i]['rate'] = $row->rate;
			// $array[$i]['vat'] = $row->vat;
			$disp_var = $this->lang->line('receive_ordered_items_detail');
			$array[$i]['recm_status'] = $row->recm_status;

			$array[$i]['mattype'] = !empty($row->maty_material) ? $row->maty_material : '';
			if(DEFAULT_DATEPICKER == 'NP'){
				$array[$i]["postdate"] = $row->recm_postdatebs.' '.$row->recm_posttime;
			}else{
				$array[$i]["postdate"] = $row->recm_postdatead.' '.$row->recm_posttime;
			}
			$array[$i]['action'] = '<a href="javascript:void(0)" data-id=' . $row->recm_receivedmasterid . ' data-displaydiv="" data-viewurl=' . base_url('purchase_receive/receive_against_order/direct_purchase_details') . ' class="view btn-primary btn-xxs sm-pd" data-heading="' . $disp_var . '"><i class="fa fa-eye" title="View" aria-hidden="true" ></i></a> 

		   		<a href="javascript:void(0)" data-id=' . $row->recm_invoiceno . ' data-date=' . $row->recm_receiveddatebs . ' data-viewurl=' . base_url('purchase_receive/receive_against_order/receive_cancel') . ' class="redirectedit  btn-danger btn-xxs" title="Receive Cancel"><i class="fa fa-times-rectangle" aria-hidden="true"></i></a>';
			//$array[$i]['cancel_all'] = ''; purchase_receive/direct_purchase/direct_purchase_details
			$i++;
		}
		echo json_encode(array("recordsFiltered" => $filtereddata, "recordsTotal" => $totalrecs, "data" => $array));
	}
	public function direct_purchase_details()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$mastid_id = $this->input->post('id');
			$this->data['master_id'] = $mastid_id;
			$this->data['req_detail_list'] = $this->direct_purchase_mdl->get_received_details(array('rd.recd_receivedmasterid' => $mastid_id));

			// $this->data['direct_purchase_master']=$this->direct_purchase_mdl->received_master_views(array('rm.recm_receivedmasterid'=>$mastid_id,'recm_status'=>'O'));
			$this->data['direct_purchase_master'] = $this->direct_purchase_mdl->received_master_views(array('rm.recm_receivedmasterid' => $mastid_id));
			// echo "<pre>";print_r($this->data['direct_purchase_master']);die();
			$tempform = '';
			if (ORGANIZATION_NAME == 'KU' || ORGANIZATION_NAME == 'ARMY' || ORGANIZATION_NAME == 'PU'  ) {
				$tempform = $this->load->view('receive_against_order/' . REPORT_SUFFIX . '/v_received_against_order_view', $this->data, true);
			} else {
				$tempform = $this->load->view('receive_against_order/v_received_against_order_view', $this->data, true);
			}

			if (!empty($tempform)) {
				print_r(json_encode(array('status' => 'success', 'message' => 'View Open Success', 'tempform' => $tempform)));
				exit;
			} else {
				print_r(json_encode(array('status' => 'error', 'message' => 'Unable to View!!')));
				exit;
			}
		} else {
			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		}
	}
	public function receive_aginst_reprint()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$id = $this->input->post('id');
				if ($id) {
					$this->data['req_detail_list'] = $this->direct_purchase_mdl->get_received_details(array('rd.recd_receivedmasterid' => $id));

					$receive_master = $this->data['direct_purchase_master'] = $this->direct_purchase_mdl->received_master_views(array('rm.recm_receivedmasterid' => $id));
					// echo "<pre>";
					// print_r($this->data['req_detail_list']);
					// die();
					//$template=$this->load->view('purchase/v_print_report_direct_purchase',$this->data,true);

					$purchase_order_no = !empty($receive_master[0]->recm_purchaseorderno) ? $receive_master[0]->recm_purchaseorderno : '';
					$this->data['mattypeid'] = '';
					if (!empty($receive_master)) {
						$this->data['mattypeid'] = !empty($receive_master[0]->recm_mattypeid) ? $receive_master[0]->recm_mattypeid : '';
					}

					$this->data['challan_no'] = $this->general->get_tbl_data('chma_challanmasterid,chma_challanrecno', 'chma_challanmaster', array('chma_puorid' => $purchase_order_no));

					$this->data['user_signature'] = $this->general->get_signature($this->userid);

					$recv_date = !empty($req_detail_list[0]->recm_receiveddatebs) ? $req_detail_list[0]->recm_receiveddatebs : CURDATE_NP;

					$approvedby = $this->general->get_store_post_data($recv_date, 'approver');

					$this->data['approver_signature'] = $this->general->get_signature($approvedby);

					$store_head_id = $this->general->get_store_post_data($recv_date, 'store_head');

					$this->data['store_head_signature'] = $this->general->get_signature($store_head_id);
					// echo RECV_REPORT_TYPE;
					// die();
					if (RECV_REPORT_TYPE == 'DEFAULT') {
						$template = $this->load->view('receive_against_order/v_received_against_order_print', $this->data, true);
					} else {
						$template = $this->load->view('receive_against_order/v_received_against_order_print' . '_' . REPORT_SUFFIX, $this->data, true);
					}

					// $template=$this->load->view('receive_against_order/v_received_against_order_print',$this->data,true);
					// print_r($template);die;
					if ($this->data['req_detail_list'] > 0) {
						print_r(json_encode(array('status' => 'success', 'message' => '', 'tempform' => $template)));
						exit;
					} else {
						print_r(json_encode(array('status' => 'error', 'message' => '')));
						exit;
					}
					print_r(json_encode(array('status' => 'success', 'message' => 'Successfully Selected!!', 'tempform' => $template)));
					exit;
				}
			} else {
				print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
				exit;
			}
		} else {
			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		}
	}

	public function received_reprint_test()
	{
		$id = 19;
		$this->data['req_detail_list'] = $this->direct_purchase_mdl->get_received_details(array('rd.recd_receivedmasterid' => $id));
		$receive_master = $this->data['direct_purchase_master'] = $this->direct_purchase_mdl->received_master_views(array('rm.recm_receivedmasterid' => $id));
		//echo"<pre>";print_r($this->data['req_detail_list']);die();
		//$template=$this->load->view('purchase/v_print_report_direct_purchase',$this->data,true);

		$purchase_order_no = !empty($receive_master[0]->recm_purchaseorderno) ? $receive_master[0]->recm_purchaseorderno : '';

		$this->data['challan_no'] = $this->general->get_tbl_data('chma_challanmasterid,chma_challanrecno', 'chma_challanmaster', array('chma_puorid' => $purchase_order_no));

		$this->data['user_signature'] = $this->general->get_signature($this->userid);

		$recv_date = !empty($req_detail_list[0]->recm_receiveddatebs) ? $req_detail_list[0]->recm_receiveddatebs : CURDATE_NP;

		$approvedby = $this->general->get_store_post_data($recv_date, 'approver');

		$this->data['approver_signature'] = $this->general->get_signature($approvedby);

		$store_head_id = $this->general->get_store_post_data($recv_date, 'store_head');

		$this->data['store_head_signature'] = $this->general->get_signature($store_head_id);

		if (RECV_REPORT_TYPE == 'DEFAULT') {
			$template = $this->load->view('receive_against_order/v_received_against_order_print', $this->data, true);
		} else {
			$template = $this->load->view('receive_against_order/v_received_against_order_print' . '_' . REPORT_SUFFIX, $this->data, true);
		}

		// $template=$this->load->view('receive_against_order/v_received_against_order_print',$this->data,true);
		echo $template;
	}

	public function load_order_list()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			try {
				$this->data['requistion_departments'] = '';
				$this->data['detail_list'] = '';

				$tempform = $this->load->view('receive_against_order/v_pur_order_list_modal', $this->data, true);

				if (!empty($tempform)) {
					print_r(json_encode(array('status' => 'success', 'message' => 'You Can view', 'tempform' => $tempform)));
					exit;
				} else {
					print_r(json_encode(array('status' => 'error', 'message' => 'Unable to View!!')));
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

	public function save_received_items($print = false)
	{
		// echo"<pre>";print_r($this->input->post());die;
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			try {

				if ($this->input->post('id')) {
					if (MODULES_UPDATE == 'N') {
						$this->general->permission_denial_message();
						exit;
					}
				} else {
					if (MODULES_INSERT == 'N') {
						$this->general->permission_denial_message();
						exit;
					}
				}

				$this->form_validation->set_rules($this->receive_against_order_mdl->validate_settings_receive_against_order);
				if ($this->form_validation->run() == TRUE) {
					$trans = $this->receive_against_order_mdl->save_receive_order();
					if ($trans) {
						$print_report = "";
						if ($print = "print") {
							$req_detail_list = $this->data['req_detail_list'] = $this->direct_purchase_mdl->get_received_details(array('rd.recd_receivedmasterid' => $trans));
							$this->data['direct_purchase_master'] = $this->direct_purchase_mdl->received_master_views(array('rm.recm_receivedmasterid' => $trans));

							if (!empty($this->data['direct_purchase_master'])) {
								$this->data['mattypeid'] = !empty($this->data['direct_purchase_master'][0]->recm_mattypeid) ? $this->data['direct_purchase_master'][0]->recm_mattypeid : '';
							}

							$this->data['user_signature'] = $this->general->get_signature($this->userid);

							$recv_date = !empty($req_detail_list[0]->recm_receiveddatebs) ? $req_detail_list[0]->recm_receiveddatebs : CURDATE_NP;

							$approvedby = $this->general->get_store_post_data($recv_date, 'approver');

							$this->data['approver_signature'] = $this->general->get_signature($approvedby);

							$store_head_id = $this->general->get_store_post_data($recv_date, 'store_head');

							$this->data['store_head_signature'] = $this->general->get_signature($store_head_id);
							

							if (RECV_REPORT_TYPE == 'DEFAULT') {
								$print_report = $this->load->view('receive_against_order/v_received_against_order_print', $this->data, true);
							} else {
								$print_report = $this->load->view('receive_against_order/v_received_against_order_print' . '_' . REPORT_SUFFIX, $this->data, true);
							}
							// $print_report = $this->load->view('receive_against_order/v_received_against_order_print', $this->data, true);

							$this->insert_api_data_locally($trans);

							// api parameters
							if (defined('RUN_API') && RUN_API == 'Y') :
								if (defined('API_CALL')) :
									if (API_CALL == 'KUKL') {
										$this->post_api_import_asset_with_recno($trans);
										// $this->api_post_expense_amount($trans);
									}
								endif;
							endif;
						}
						print_r(json_encode(array('status' => 'success', 'message' => 'Received Order Successfully', 'print_report' => $print_report)));
						exit;
					} else {
						print_r(json_encode(array('status' => 'error', 'message' => 'Operation Failed.')));
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

	public function upload_attachment($print = false)
	{
		// echo"<pre>";print_r($this->input->post());die;
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			try {

				// if ($this->input->post('id')) {
				// 	if (MODULES_UPDATE == 'N') {
				// 		$this->general->permission_denial_message();
				// 		exit;
				// 	}
				// } else {
				// 	if (MODULES_INSERT == 'N') {
				// 		$this->general->permission_denial_message();
				// 		exit;
				// 	}
				// }

				// $this->form_validation->set_rules($this->receive_against_order_mdl->validate_settings_upload_attachment);

				if ($this->input->post('id')) {
					$trans = $this->receive_against_order_mdl->save_attachment();
					if ($trans) {
						$print_report = "";
						if ($print = "print") {
							$this->data['req_detail_list'] = $this->direct_purchase_mdl->get_received_details(array('rd.recd_receivedmasterid' => $trans));
							$this->data['direct_purchase_master'] = $this->direct_purchase_mdl->received_master_views(array('rm.recm_receivedmasterid' => $trans));

							//print direct from form
							// $this->data['req_detail_list']='';
							// $this->data['direct_purchase_master']='';
							// //echo"<pre>";print_r($this->input->post());die;
							// $report_data = $this->data['report_data'] = $this->input->post();
							// $itemid = !empty($report_data['rede_itemsid'])?$report_data['itemsid']:'';
							// if(!empty($itemid)):
							// 	foreach($itemid as $key=>$it):
							// 		$itemid = !empty($report_data['itemsid'][$key])?$report_data['itemsid'][$key]:'';
							// 		$this->data['item_name']=$this->general->get_tbl_data('*','itli_itemslist',array('itli_itemlistid'=>$itemid),false,'DESC');
							// 	endforeach;
							// endif;
							//$print_report = $this->load->view('receive_against_order/v_received_against_order_print', $this->data, true);
							$print_report = $this->load->view('receive_against_order/v_received_against_order_print', $this->data, true);
							//print_r($print_report);die;
						}
						print_r(json_encode(array('status' => 'success', 'message' => 'Image Upload Successfully', 'print_report' => $print_report)));
						exit;
					} else {
						print_r(json_encode(array('status' => 'error', 'message' => 'Please Choose Image||File.')));
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

	public function _notMatch($totalamountValue, $billamountFieldName)
	{
		if ($totalamountValue != $this->input->post($billamountFieldName)) {
			$this->form_validation->set_message('_notMatch', 'Bill amount and total amount does not match');
			return false;
		}
		return true;
	}
	public function exportToExcel()
	{
		header("Content-Type: application/xls");
		header("Content-Disposition: attachment; filename=cancel_order_" . date('Y_m_d_H_i') . ".xls");
		header("Pragma: no-cache");
		header("Expires: 0");

		$data = $this->receive_against_order_mdl->get_receive_against_order_list();

		$this->data['searchResult'] = $this->receive_against_order_mdl->get_receive_against_order_list();

		$array = array();
		unset($this->data['searchResult']['totalfilteredrecs']);
		unset($this->data['searchResult']['totalrecs']);
		if (ORGANIZATION_NAME == 'KU' || ORGANIZATION_NAME == 'PU') {
			$html = $this->load->view('receive_against_order/ku/v_against_order_download', $this->data, true);
		} else {
			$html = $this->load->view('receive_against_order/v_against_order_download', $this->data, true);
		}

		echo $html;
	}
	public function generate_pdf()
	{
		$page_orientation = !empty($_GET['page_orientation']) ? $_GET['page_orientation']  : '';
		if ($page_orientation == 'L') {
			$page_size = 'A4-L';
		} else {
			$page_size = 'A4';
		}

		if (ORGANIZATION_NAME == 'KU' || ORGANIZATION_NAME == 'ARMY' || ORGANIZATION_NAME == 'PU' ) {
			$this->data['searchResult'] = $this->receive_against_order_mdl->get_receive_against_order_list_ku();
		} else {
			$this->data['searchResult'] = $this->receive_against_order_mdl->get_receive_against_order_list();
		}

		// $this->data['searchResult'] = $this->receive_against_order_mdl->get_receive_against_order_list();

		unset($this->data['searchResult']['totalfilteredrecs']);
		unset($this->data['searchResult']['totalrecs']);
		//echo"<pre>";print_r($this->data['searchResult']);die;
		ini_set('memory_limit', '256M');

		$get = $_GET;

		$this->data['fromdate'] = !empty($get['frmDate']) ? $get['frmDate'] : $this->input->post('frmDate');
		$this->data['todate'] = !empty($get['toDate']) ? $get['toDate'] : $this->input->post('toDate');
		$this->data['report_title'] = 'Received Order List';

		if (ORGANIZATION_NAME == 'KU' || ORGANIZATION_NAME == 'ARMY' || ORGANIZATION_NAME == 'PU' ) {
			$html = $this->load->view('receive_against_order/ku/v_against_order_download', $this->data, true);
		} else {
			$html = $this->load->view('receive_against_order/v_against_order_download', $this->data, true);
		}

		// echo $html;
		// die();
		error_reporting(0);

		$this->general->generate_pdf($html, '', $page_size);
	}
	public function exportToExceldetails()
	{
		header("Content-Type: application/xls");
		header("Content-Disposition: attachment; filename=cancel_order_" . date('Y_m_d_H_i') . ".xls");
		header("Pragma: no-cache");
		header("Expires: 0");

		$data = $this->receive_against_order_mdl->get_receive_against_order_details_list();

		$this->data['searchResult'] = $this->receive_against_order_mdl->get_receive_against_order_details_list();

		$array = array();
		unset($this->data['searchResult']['totalfilteredrecs']);
		unset($this->data['searchResult']['totalrecs']);
		$response = $this->load->view('receive_against_order/v_against_order_details_download', $this->data, true);
		echo $response;
	}
	public function generate_pdfDetails()
	{
		$this->data['searchResult'] = $this->receive_against_order_mdl->get_receive_against_order_details_list();
		// echo "<pre>";
		// print_r($this->data['searchResult']);
		// die();
		$this->data['report_title'] = $this->lang->line('received_detail_list');
		unset($this->data['searchResult']['totalfilteredrecs']);
		unset($this->data['searchResult']['totalrecs']);

		//echo"<pre>";print_r($this->data['searchResult']);die;
		ini_set('memory_limit', '256M');

		if (ORGANIZATION_NAME == 'KU' || ORGANIZATION_NAME == 'PU') {
			// echo "yes";
			// die();

			$html = $this->load->view('receive_against_order/ku/v_against_order_details_download', $this->data, true);
		} else {
			$html = $this->load->view('receive_against_order/v_against_order_details_download', $this->data, true);
		}

		$html = $this->load->view('receive_against_order/v_against_order_details_download', $this->data, true);

		if (PDF_IMAGEATEXT == '3') {
			$mpdf->SetWatermarkImage(PDF_WATERMARK);
			$mpdf->showWatermarkImage = true;
			$mpdf->showWatermarkText = true;
			$mpdf->SetWatermarkText(ORGA_NAME);
		}
		if (PDF_IMAGEATEXT == '1') {
			$mpdf->SetWatermarkImage(PDF_WATERMARK);
			$mpdf->showWatermarkImage = true;
		}
		if (PDF_IMAGEATEXT == '2') {
			$mpdf->showWatermarkText = true;
			$mpdf->SetWatermarkText(ORGA_NAME);
		}

		$this->general->generate_pdf($html, '', '');
	}

	public function generate_receiveno()
	{
		$curmnth = CURMONTH;
		if ($curmnth == 1) {
			$prefix = 'A';
		}
		if ($curmnth == 2) {
			$prefix = 'B';
		}
		if ($curmnth == 3) {
			$prefix = 'C';
		}
		if ($curmnth == 4) {
			$prefix = 'D';
		}
		if ($curmnth == 5) {
			$prefix = 'E';
		}
		if ($curmnth == 6) {
			$prefix = 'F';
		}
		if ($curmnth == 7) {
			$prefix = 'G';
		}
		if ($curmnth == 8) {
			$prefix = 'H';
		}
		if ($curmnth == 9) {
			$prefix = 'I';
		}
		if ($curmnth == 10) {
			$prefix = 'J';
		}
		if ($curmnth == 11) {
			$prefix = 'K';
		}
		if ($curmnth == 12) {
			$prefix = 'L';
		}

		if (ORGANIZATION_NAME == 'NPHL') {
			$prefix = 'E';
		}

		$this->db->select('recm_invoiceno');
		$this->db->from('recm_receivedmaster');
		$this->db->where('recm_invoiceno LIKE ' . '"%' . RECEIVED_NO_PREFIX . $prefix . '%"');
		$this->db->where('recm_locationid', $this->locationid);
		$this->db->limit(1);
		$this->db->order_by('recm_invoiceno', 'DESC');
		$query = $this->db->get();
		// echo $this->db->last_query(); die();
		$invoiceno = 0;
		$dbinvoiceno = '';

		if ($query->num_rows() > 0) {
			$dbinvoiceno = $query->row()->recm_invoiceno;
		}
		if (!empty($dbinvoiceno)) {
			$invoiceno = $this->general->stringseperator($dbinvoiceno, 'number');
		}

		$nw_invoice = str_pad($invoiceno + 1, RECEIVED_NO_LENGTH, 0, STR_PAD_LEFT);

		if (defined('SHOW_FORM_NO_WITH_LOCATION')) {
			if (SHOW_FORM_NO_WITH_LOCATION == 'Y') {
				return $this->locationcode . '-' . RECEIVED_NO_PREFIX . $prefix . $nw_invoice;
			} else {
				return RECEIVED_NO_PREFIX . $prefix . $nw_invoice;
			}
		} else {
			return RECEIVED_NO_PREFIX . $prefix . $nw_invoice;
		}
	}

	public function get_order_list_for_receive()
	{
		// echo "ASd";
		// die();
		// if(MODULES_VIEW=='N')
		// {
		//   	$array=array();
		//           echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));
		//           exit;
		// }

		$fiscalyear = !empty($this->input->get('fiscalyear')) ? $this->input->get('fiscalyear') : $this->input->post('fiscalyear');
		$mattypeid = !empty($this->input->get('mattypeid')) ? $this->input->get('mattypeid') : $this->input->post('mattypeid');

		if (ORGANIZATION_NAME == 'KUKL') {
			$searcharray = array('po.puor_fyear' => $fiscalyear, 'po.puor_storeid' => $this->storeid, 'po.puor_status <>' => 'CH', 'po.puor_locationid' => $this->locationid, 'po.puor_verified' => 2);
		} else {
			$searcharray = array('po.puor_fyear' => $fiscalyear, 'po.puor_storeid' => $this->storeid, 'po.puor_status <>' => 'CH', 'po.puor_locationid' => $this->locationid);
			if (!empty($mattypeid)) {
				$searcharray['po.puro_mattypeid'] = $mattypeid;
			}
		}

		// die();

		$this->data['detail_list'] = '';

		$data = $this->receive_against_order_mdl->get_order_list($searcharray);
		// echo "<pre>";
		// print_r($data); die;
		// echo $this->db->last_query(); die;
		$i = 0;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"] > 0 ? $data["totalfilteredrecs"] : $data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

		unset($data["totalfilteredrecs"]);
		unset($data["totalrecs"]);

		foreach ($data as $row) {
			$array[$i]["masterid"] = $row->puor_purchaseordermasterid;
			$array[$i]["order_no"] = $row->puor_orderno;
			$array[$i]["req_no"] = $row->puor_requno;
			$array[$i]["date"] = $row->puor_orderdatebs;
			$array[$i]["suppliername"] = $row->dist_distributor;
			$array[$i]["amount"] = $row->puor_amount;

			$i++;
		}
		echo json_encode(array("recordsFiltered" => $filtereddata, "recordsTotal" => $totalrecs, "data" => $array));
	}

	public function load_detail_list($new_order = false)
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$masterid = $this->input->post('masterid');

			$detail_list = $this->data['detail_list'] = $this->receive_against_order_mdl->get_order_details(array('pude_purchasemasterid' => $masterid, 'pude_remqty >' => 0));

			if (empty($detail_list)) {
				$isempty = 'empty';
			} else {
				$isempty = 'not_empty';
			}
			if ($new_order == 'new_detail_list') {
				$tempform = $this->load->view('receive_against_order/v_pur_order_detail_append', $this->data, true);
			} else {
				$tempform = $this->load->view('receive_against_order/v_pur_order_detail_modal', $this->data, true);
			}

			if (!empty($tempform)) {
				print_r(json_encode(array('status' => 'success', 'message' => 'You Can view', 'tempform' => $tempform, 'isempty' => $isempty)));
				exit;
			} else {
				print_r(json_encode(array('status' => 'error', 'message' => 'Unable to View!!')));
				exit;
			}
		} else {
			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		}
	}

	public function post_api_import_asset_with_recno($rec_no)
	{
		$req_detail_list = $this->direct_purchase_mdl->get_received_details(array('rd.recd_receivedmasterid' => $rec_no));

		$recv_no = !empty($req_detail_list[0]->recm_invoiceno) ? $req_detail_list[0]->recm_invoiceno : '';

		$recv_date = !empty($req_detail_list[0]->recm_receiveddatebs) ? $req_detail_list[0]->recm_receiveddatebs : '';

		$recv_date_conv = str_replace("/", ".", $recv_date);

		$recm_departmentid = !empty($req_detail_list[0]->recm_departmentid) ? $req_detail_list[0]->recm_departmentid : '';

		$recm_postusername = !empty($req_detail_list[0]->recm_postusername) ? $req_detail_list[0]->recm_postusername : '';

		$recm_locationid = !empty($req_detail_list[0]->recm_locationid) ? $req_detail_list[0]->recm_locationid : '';

		$recm_remarks = !empty($req_detail_list[0]->recm_remarks) ? $req_detail_list[0]->recm_remarks : '';

		$post_master_array = array(
			"tranDate" => !empty($recv_date_conv) ? $recv_date_conv : "0", //2076.01.20
			"voucherType" => "1",
			"voucherNo" => !empty($recv_no) ? $recv_no : "0",
			"office_ID" => 40,
			"entryBY" => !empty($recm_postusername) ? $recm_postusername : "0",
			"narration" => !empty($recm_remarks) ? $recm_remarks : "0"
		);

		if (!empty($req_detail_list)) :
			$drCrArray = array('Dr', 'Cr');
			foreach ($req_detail_list as $reqkey => $reqval) {
				$recd_itemsid = !empty($reqval->recd_itemsid) ? $reqval->recd_itemsid : '';

				$eqca_accode = !empty($reqval->eqca_accode) ? $reqval->eqca_accode : '';

				$recd_description = !empty($reqval->recd_description) ? $reqval->recd_description : '';

				$recd_amount = !empty($reqval->recd_amount) ? $reqval->recd_amount : '';

				$distributor = !empty($reqval->dist_distributor) ? $reqval->dist_distributor : '';

				foreach ($drCrArray as $value) {
					$post_detail_array[] = array(
						"aC_Code" => !empty($eqca_accode) ? (int)$eqca_accode : 0, // acc code according to api
						"drCr" => $value,
						"description" => !empty($recd_description) ? $recd_description : "test",
						"amount" => !empty($recd_amount) ? (float)$recd_amount : 0,
						"costCenter_ID" => 1,
						"acC_NAME" => !empty($distributor) ? $distributor : "0" // supplier name
					);
				}
			}
		endif;
		$master_array = array();

		$dtl_arr = '';
		$dtl_arr .= '{"offTranModel": ' . json_encode($post_master_array) . ',';
		if (!empty($post_detail_array)) :
			foreach ($post_detail_array as $key => $value) {
				// $detail_array = array(
				// 	'offTranDetModel'=>array($value)
				// );
				$dtl_arr .= '"offTranDetModel":[' . json_encode($value) . ']' . ',';
				// print_r($post_detail_array);

				// $test[] = $detail_array;

			}
		endif;
		$dtl_arr = rtrim($dtl_arr, ',');
		$dtl_arr .= '}';

		$post_json = $dtl_arr;

		$api_url = KUKL_API_URL . 'InventoryService/CurrentAssetsImport' . KUKL_API_KEY;

		// $api_url = base_url('api/api_kukl/get_post_data_issue');

		$client = curl_init($api_url);

		curl_setopt($client, CURLOPT_CUSTOMREQUEST, "POST");

		curl_setopt($client, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Content-Length: ' . strlen($post_json)
		));

		// curl_setopt($client, CURLOPT_POST, true);
		// curl_setopt($client, CURLOPT_POSTFIELDS, $post_json);
		curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($client, CURLOPT_POSTFIELDS, $post_json);
		curl_setopt($client, CURLOPT_FOLLOWLOCATION, 1);

		$response = curl_exec($client);

		curl_close($client);

		// echo $response;
		return true;
	}

	public function insert_api_data_locally($rec_no)
	{
		$req_detail_list = $this->direct_purchase_mdl->get_received_details(array('rd.recd_receivedmasterid' => $rec_no));

		$recv_no = !empty($req_detail_list[0]->recm_invoiceno) ? $req_detail_list[0]->recm_invoiceno : '';

		$recv_date = !empty($req_detail_list[0]->recm_receiveddatebs) ? $req_detail_list[0]->recm_receiveddatebs : '';

		$recv_date_conv = str_replace("/", ".", $recv_date);

		$recm_departmentid = !empty($req_detail_list[0]->recm_departmentid) ? $req_detail_list[0]->recm_departmentid : '';

		$recm_postusername = !empty($req_detail_list[0]->recm_postusername) ? $req_detail_list[0]->recm_postusername : '';

		$recm_locationid = !empty($req_detail_list[0]->recm_locationid) ? $req_detail_list[0]->recm_locationid : '';

		$recm_remarks = !empty($req_detail_list[0]->recm_remarks) ? $req_detail_list[0]->recm_remarks : '';

		$this->db->trans_begin();
		$api_master_array = array(
			'apma_transdate' => !empty($recv_date_conv) ? $recv_date_conv : "0",
			'apma_vouchertype' => "1",
			'apma_voucherno' => !empty($recv_no) ? $recv_no : "0",
			'apma_officeid' => 40,
			'apma_entryby' => !empty($recm_postusername) ? $recm_postusername : "0",
			'apma_narration' => !empty($recm_remarks) ? $recm_remarks : "0",
			'apma_issync' => 'N',
			'apma_actionfrom' => 'Receive'
		);

		if (!empty($api_master_array)) {
			$this->db->insert('apma_apimaster', $api_master_array);
			$insertid = $this->db->insert_id();
		}

		if (!empty($insertid)) {
			if (!empty($req_detail_list)) :
				$drCrArray = array('Dr', 'Cr');
				foreach ($req_detail_list as $reqkey => $reqval) {
					$recd_itemsid = !empty($reqval->recd_itemsid) ? $reqval->recd_itemsid : '';

					$eqca_accode = !empty($reqval->eqca_accode) ? $reqval->eqca_accode : '';

					$recd_description = !empty($reqval->recd_description) ? $reqval->recd_description : '';

					$recd_amount = !empty($reqval->recd_amount) ? $reqval->recd_amount : '';

					$distributor = !empty($reqval->dist_distributor) ? $reqval->dist_distributor : '';

					foreach ($drCrArray as $value) {
						$api_detail_array[] = array(
							"apde_apmaid" => $insertid,
							"apde_accode" => !empty($eqca_accode) ? (int)$eqca_accode : 0, // acc code according to api
							"apde_drcr" => $value,
							"apde_description" => !empty($recd_description) ? $recd_description : "test",
							"apde_amount" => !empty($recd_amount) ? (float)$recd_amount : 0,
							"apde_costcenterid" => 1,
							"apde_acname" => !empty($distributor) ? $distributor : "0", // supplier name
							"apde_issync" => 'N'
						);
					}
				}
			endif;
			if (!empty($api_detail_array)) {

				$this->db->insert_batch('apde_apidetail', $api_detail_array);
			}
		}

		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return false;
		} else {
			$this->db->trans_commit();
			return true;
		}
	}

	public function receive_cancel()
	{

		$this->data['tab_type'] = 'cancel';
		$this->data['fiscal'] = $this->general->get_tbl_data('*', 'fiye_fiscalyear', false, 'fiye_fiscalyear_id', 'DESC', '2');

		if (!empty($this->mattypeid)) {
			$srchmat = array('maty_materialtypeid' => $this->mattypeid, 'maty_isactive' => 'Y');
		} else {
			$srchmat = array('maty_isactive' => 'Y');
		}
		$this->data['material_type'] = $this->general->get_tbl_data('maty_materialtypeid,maty_material', 'maty_materialtype', $srchmat, 'maty_materialtypeid', 'ASC');

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
			->build('receive_against_order/v_against_order', $this->data);
	}

	// public function issue_cancel_item()
	// {
	// 	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// 		try {
	// 		$sade_id=$this->input->post('id');
	// 		// echo $sade_id;
	// 		// die();
	// 		$sade_data=$this->new_issue_mdl->get_receive_detail(array('sade_saledetailid'=>$sade_id));
	// 		// echo "<pre>";
	// 		// print_r($sade_data);
	// 		// die();
	// 		if(empty($sade_data))
	// 		{
	// 			print_r(json_encode(array('status'=>'error','message'=>'Unable to cancel this Item !!!')));
	// 			exit;
	// 		}
	// 		else
	// 		{
	// 			$qty=$sade_data[0]->sade_qty;
	// 			$mat_transdetailid=$sade_data[0]->sade_mattransdetailid;
	// 			$iscancel=$sade_data[0]->sade_iscancel;
	// 			if($iscancel=='Y')
	// 			{
	// 				print_r(json_encode(array('status'=>'error','message'=>'Already Cancel this Item !!!')));
	// 				exit;
	// 			}

	// 			$update_sd=$this->new_issue_mdl->update_salesdetail($sade_id);
	// 			$mat_trans=$this->new_issue_mdl->update_mat_trans_detailid($mat_transdetailid,$qty);

	// 			print_r(json_encode(array('status'=>'success','message'=>'Successfully Cancelled !!!')));
	// 			exit;

	// 		}

	// 		}catch (Exception $e) {
	//            print_r(json_encode(array('status'=>'error','message' => $e->getMessage())));
	//        	}
	// 	}
	// 		else
	// 		{
	// 			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	// 			exit;
	// 		}
	// }

	public function receivelist_by_receive_no()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			// if(MODULES_VIEW=='N')
			// {

			// 		print_r(json_encode(array('status'=>'error','message'=>$this->general->permission_denial_message())));
			// 	exit;
			// }

			$receive_no = $this->input->post('receive_no');
			$receive_date = $this->input->post('receive_date');
			$fiscalyrs=$this->input->post('fiscalyear');

			$input_locationid = $this->input->post('locationid');

			$this->storeid = $this->session->userdata(STORE_ID);

			if ($this->location_ismain == 'Y') {
				if ($input_locationid) {
					$locationid = $input_locationid;
				}
			} else {
				$locationid = $this->locationid;
			}

			// $locationid=!empty($this->input->post('locationid'))?$this->input->post('locationid'):$this->locationid;

			$srchcol = array('recm_invoiceno' => $receive_no, 'recm_storeid' => $this->storeid, 'recm_locationid' => $locationid);
			if (ORGANIZATION_NAME == 'KU' || ORGANIZATION_NAME == 'ARMY' || ORGANIZATION_NAME == 'PU'  ) {
				$mattypeid = !empty($this->input->post('mattypeid')) ? $this->input->post('mattypeid') : $this->mattypeid;
				if (!empty($mattypeid)) {
					$srchcol['recm_mattypeid'] = $mattypeid;
				}
				if(!empty($fiscalyrs)){
						$srchcol['recm_fyear'] = $fiscalyrs;
				}
			}

			$this->data['receive_data'] = $this->receive_against_order_mdl->get_receive_master($srchcol);
			// echo $this->db->last_query();
			// die();
			// echo "<pre>";
			// print_r($this->data['receive_data']);
			// die();

			if (empty($this->data['receive_data'][0])) {
				print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Cancel this Received.!!!')));
				exit;
			}

			$receive_status = !empty($this->data['receive_data'][0]->recm_status) ? $this->data['receive_data'][0]->recm_status : '';

			if ($receive_status == 'M') {
				print_r(json_encode(array('status' => 'error', 'message' => 'Already Cancelled!!!')));
				exit;
			}

			$this->data['receive_detail'] = array();
			$tempform = '';
			if ($this->data['receive_data']) {
				$id = $this->data['receive_data'][0]->recm_receivedmasterid;
				$this->data['req_detail_list'] = $this->direct_purchase_mdl->get_received_details(array('rd.recd_receivedmasterid' => $id));
				$receive_master = $this->data['direct_purchase_master'] = $this->direct_purchase_mdl->received_master_views(array('rm.recm_receivedmasterid' => $id));
				//echo"<pre>";print_r($this->data['req_detail_list']);die();
				//$template=$this->load->view('purchase/v_print_report_direct_purchase',$this->data,true);

				$purchase_order_no = !empty($receive_master[0]->recm_purchaseorderno) ? $receive_master[0]->recm_purchaseorderno : '';

				$this->data['challan_no'] = $this->general->get_tbl_data('chma_challanmasterid,chma_challanrecno', 'chma_challanmaster', array('chma_puorid' => $purchase_order_no));

				$this->data['user_signature'] = $this->general->get_signature($this->userid);

				$recv_date = !empty($req_detail_list[0]->recm_receiveddatebs) ? $req_detail_list[0]->recm_receiveddatebs : CURDATE_NP;

				$approvedby = $this->general->get_store_post_data($recv_date, 'approver');

				$this->data['approver_signature'] = $this->general->get_signature($approvedby);

				$store_head_id = $this->general->get_store_post_data($recv_date, 'store_head');

				$this->data['store_head_signature'] = $this->general->get_signature($store_head_id);
				$template = '<div class="white-box pad-5 mtop_10 pdf-wrapper">';
				if (RECV_REPORT_TYPE == 'DEFAULT') {
					$template .= $this->load->view('receive_against_order/v_received_against_order_print', $this->data, true);
				} else {
					$template .= $this->load->view('receive_against_order/v_received_against_order_print' . '_' . REPORT_SUFFIX, $this->data, true);
				}
				$template .= '</div><a href="javascript:void(0)" class="btn btn-sm btn-danger btnConfirm" data-id="' . $id . '" data-url="' . base_url('purchase_receive/receive_against_order/receive_cancel_save') . '">Received Cancel</a>';
				// $tempform=$this->load->view('receive_against_order/v_receive_against_order_list_for_cancel',$this->data,true);

			}
			print_r(json_encode(array('status' => 'success', 'receive_data' => $this->data['receive_data'], 'tempform' => $template, 'message' => 'Selected Successfully')));
			exit;
		} else {
			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		}
	}

	public function receive_cancel_save()
	{	
		try{
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$recmid = $this->input->post('id');
			$received_status = 0;
			$this->db->select('recm_receivedmasterid,recm_purchaseordermasterid,recm_status');
			$this->db->from('recm_receivedmaster');
			$this->db->where('recm_receivedmasterid', $recmid);
			$this->db->order_by('recm_receivedmasterid', 'ASC');
			$rm_data = $this->db->get()->row();
			if (!empty($rm_data)) {
				// echo "<pre>";
				// print_r($rm_data);
				// die();
				$this->db->trans_begin();
				$rc_mid = $rm_data->recm_receivedmasterid;
				$rc_pomid = $rm_data->recm_purchaseordermasterid;
				$rc_status = $rm_data->recm_status;
				if ($rc_status == 'M') { // M=Cancel Status and O =Ok Status
					print_r(json_encode(array('status' => 'error', 'message' => 'Already Cancel this recepit')));
					exit;
				}
				$update_receive_masterArray = array(
					'recm_status' => 'M'
				);
				$this->db->update('recm_receivedmaster', $update_receive_masterArray, array('recm_receivedmasterid' => $recmid));

				$this->db->select('recd_receiveddetailid,recd_receivedmasterid');
				$this->db->from('recd_receiveddetail');
				$this->db->where('recd_receivedmasterid', $recmid);
				$this->db->order_by('recd_receiveddetailid', 'ASC');
				$rslt_recdid = $this->db->get()->row();
				// echo "<pre>";
				// print_r($rslt);
				// die();

				if (!empty($rslt_recdid)) {
					$rec_did = $rslt_recdid->recd_receiveddetailid;
					$update_receive_detailArray = array(
						'recd_status' => 'M'
					);
					$this->db->update('recd_receiveddetail', $update_receive_detailArray, array('recd_receivedmasterid' => $recmid));

					$this->db->select('trde_trdeid,trde_trmaid');
					$this->db->from('trde_transactiondetail');
					$this->db->where('trde_mtdid', $rec_did);
					$this->db->order_by('trde_trdeid', 'ASC');
					$rslt_trdetail = $this->db->get()->row();
					// echo "<pre>";
					// print_r($rslt_trdetail);
					// die();
					if (!empty($rslt_trdetail)) {
						$trmid = $rslt_trdetail->trde_trmaid;
						$update_trmaArray = array('trma_status' => 'C');
						$this->db->update('trma_transactionmain', $update_trmaArray, array('trma_trmaid' => $trmid));

						$update_trmaArray = array('trde_status' => 'C');
						$this->db->update('trde_transactiondetail', $update_trmaArray, array('trde_trmaid' => $trmid));
					}
					$puor_array = array(
						'puor_status' => 'N',
						'puor_purchased' => $received_status
					);

					if (!empty($puor_array)) {
						$this->db->where('puor_purchaseordermasterid', $rc_pomid);
						$this->db->update('puor_purchaseordermaster', $puor_array);
					}
				}
				if (ORGANIZATION_NAME == 'KUKL') {
					if (defined('RUN_API') && RUN_API == 'Y'){
						if (defined('API_CALL') && API_CALL == 'KUKL') {
							$this->api_post_cancel_expense_amount($recmid);
						}
					}
				}
				$this->db->trans_complete();
				if ($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();
					print_r(json_encode(array('status' => 'error', 'message' => 'Unable to cancel this receipt')));
					exit;
				} else {
					
					$this->db->trans_commit();
					print_r(json_encode(array('status' => 'success', 'message' => 'Receipt Cancel Successfully!!')));
					exit;
				}
			} else {
				print_r(json_encode(array('status' => 'error', 'message' => 'Unable to cancel this receipt')));
				exit;
			}
		} else {
			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		}

		}catch(Exception $e){
			$this->db->trans_rollback();
			print_r(json_encode(array('status' => 'error', 'message' => $e->getMessage())));
			exit;
		}
		
	}

	public function received_edit()
	{
		$this->data['store_type'] = $this->general->get_tbl_data('*', 'store', false, 'st_store_id', 'ASC');
		$this->data['tab_type'] = 'edit';
			$this->data['fiscal'] = $this->general->get_tbl_data('*', 'fiye_fiscalyear', false, 'fiye_fiscalyear_id', 'DESC', '2');

		$this->data['loadselect2'] = 'no';
		if (!empty($this->mattypeid)) {
			$srchmat = array('maty_materialtypeid' => $this->mattypeid, 'maty_isactive' => 'Y');
		} else {
			$srchmat = array('maty_isactive' => 'Y');
		}
		$this->data['material_type'] = $this->general->get_tbl_data('maty_materialtypeid,maty_material', 'maty_materialtype', $srchmat, 'maty_materialtypeid', 'ASC');

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
			->build('receive_against_order/v_against_order', $this->data);
	}

	public function receivelist_by_receive_no_edit()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			// error_reporting(0);
			$receive_no = $this->input->post('receive_no');
			$receive_date = $this->input->post('receive_date');
			$fiscalyrs=$this->input->post('fiscalyear');
			$locationid = !empty($this->input->post('locationid')) ? $this->input->post('locationid') : $this->locationid;
			$this->storeid = $this->session->userdata(STORE_ID);
			$this->data['loadselect2'] = 'no';
			$this->data['supplier_all'] = $this->general->get_tbl_data('*', 'dist_distributors', false, 'dist_distributor', 'ASC');
			$this->data['fiscal'] = $this->general->get_tbl_data('*', 'fiye_fiscalyear', false, 'fiye_fiscalyear_id', 'DESC');
			$this->data['budgets_list'] = $this->general->get_tbl_data('*', 'budg_budgets', false, 'budg_budgetname', 'ASC');
			// echo "<pre>";print_r($this->data['material_type']);die();
			$this->data['department'] = $this->general->get_tbl_data('*', 'dept_department', false, 'dept_depid', 'DESC');
			if (!empty($this->mattypeid)) {
				$srchmat = array('maty_materialtypeid' => $this->mattypeid, 'maty_isactive' => 'Y');
			} else {
				$srchmat = array('maty_isactive' => 'Y');
			}
			$this->data['material_type'] = $this->general->get_tbl_data('maty_materialtypeid,maty_material', 'maty_materialtype', $srchmat, 'maty_materialtypeid', 'ASC');

			$mattypeid = !empty($this->input->post('mattypeid')) ? $this->input->post('mattypeid') : $this->mattypeid;

			$srchcol = array('recm_invoiceno' => $receive_no, 'recm_storeid' => $this->storeid, 'recm_locationid' => $locationid);
			// $srchcol = array('recm_invoiceno' => $receive_no, 'recm_storeid' => $this->storeid);
			// if (ORGANIZATION_NAME == 'KU') {
			// 	$srchcol['recm_school'] = $locationid;
			// } else {
			// 	$srchcol['recm_locationid'] = $locationid;
			// }
			// if (!empty($this->mattypeid)) {
			// 	$srchcol['recm_mattypeid'] = $this->mattypeid;
			// }
			$srchcol['recm_mattypeid'] = $mattypeid;
			if($fiscalyrs){
				$srchcol['recm_fyear']=$fiscalyrs;
			}
			$this->data['receive_data_master'] = $this->receive_against_order_mdl->get_receive_master($srchcol);
			// echo $this->db->last_query();
			// die();
			// echo "<pre>";
			// print_r($this->data['receive_data_master']);
			// die();
			if (!empty($this->data['receive_data_master'])) {
				$rec_master_id = $this->data['receive_data_master'][0]->recm_receivedmasterid;

				$purstatus = $this->data['receive_data_master'][0]->recm_purchasestatus;
				if ($purstatus == 'C') {
					print_r(json_encode(array('status' => 'error', 'message' => 'Invoice No. is Already Cancelled. Please Try another !!')));
					exit;
				}
				$this->data['receive_data_detail'] = $this->receive_against_order_mdl->get_receive_detail_item(array('recd_receivedmasterid' => $rec_master_id, 'recd_status' => 'O'));
				// echo "<pre>";
				// print_r($this->data['receive_data_detail']);
				// die();

				$template = '<div class="white-box pad-5 mtop_10 ">';
				if (ORGANIZATION_NAME == 'KU' || ORGANIZATION_NAME == 'ARMY' || ORGANIZATION_NAME == 'PU') {
					$template .= $this->load->view('receive_against_order/'.REPORT_SUFFIX.'/v_receive_against_order_form_edit', $this->data, true);
				} else {
					$template .= $this->load->view('receive_against_order/v_receive_against_order_form_edit', $this->data, true);
				}
				$template .= '</div>';
				print_r(json_encode(array('status' => 'success', 'message' => '', 'tempform' => $template)));
				exit;
			} else {
				print_r(json_encode(array('status' => 'error', 'message' => 'Invoice No. Not Found')));
				exit;
			}
		} else {
			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		}
	}

	public function receive_summary()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$receive_status = $this->receive_against_order_mdl->get_receive_status();

			// echo $this->db->last_query();
			// die();

			print_r(json_encode(array('status' => 'success', 'status_count' => $receive_status)));
		}
	}

	public function update_received_items()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$trans = $this->receive_against_order_mdl->update_receive_data();
			$print_report = "";
			if ($trans) {
				if ($print = "print") {
					$req_detail_list = $this->data['req_detail_list'] = $this->direct_purchase_mdl->get_received_details(array('rd.recd_receivedmasterid' => $trans));
					$this->data['direct_purchase_master'] = $this->direct_purchase_mdl->received_master_views(array('rm.recm_receivedmasterid' => $trans));

					if (!empty($this->data['direct_purchase_master'])) {
						$this->data['mattypeid'] = !empty($this->data['direct_purchase_master'][0]->recm_mattypeid) ? $this->data['direct_purchase_master'][0]->recm_mattypeid : '';
					}

					$this->data['user_signature'] = $this->general->get_signature($this->userid);

					$recv_date = !empty($req_detail_list[0]->recm_receiveddatebs) ? $req_detail_list[0]->recm_receiveddatebs : CURDATE_NP;

					$approvedby = $this->general->get_store_post_data($recv_date, 'approver');

					$this->data['approver_signature'] = $this->general->get_signature($approvedby);

					$store_head_id = $this->general->get_store_post_data($recv_date, 'store_head');

					$this->data['store_head_signature'] = $this->general->get_signature($store_head_id);

					if (RECV_REPORT_TYPE == 'DEFAULT') {
						$print_report = $this->load->view('receive_against_order/v_received_against_order_print', $this->data, true);
					} else {
						$print_report = $this->load->view('receive_against_order/v_received_against_order_print' . '_' . REPORT_SUFFIX, $this->data, true);
					}
					// $print_report = $this->load->view('receive_against_order/v_received_against_order_print', $this->data, true);

					$this->insert_api_data_locally($trans);

					// api parameters
					if (defined('RUN_API') && RUN_API == 'Y') :
						if (defined('API_CALL')) :
							if (API_CALL == 'KUKL') {
								// $this->load->module('api/Api_kukl');
								// $this->Api_kukl->post_api_import_asset_with_recno($trans);
								// return true;
								$this->post_api_import_asset_with_recno($trans);
								// $this->api_post_expense_amount($trans);
							}
						endif;
					endif;
				}
				print_r(json_encode(array('status' => 'success', 'message' => 'Received Order Successfully', 'print_report' => $print_report)));
				exit;
			} else {
				print_r(json_encode(array('status' => 'error', 'message' => 'Operation Failed.')));
				exit;
			}
		} else {
			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		}
	}

	public function voucher_print()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$id = $this->input->post('id');
				if ($id) {
					$this->data['req_detail_list'] = $this->direct_purchase_mdl->get_received_details(array('rd.recd_receivedmasterid' => $id));
					$receive_master = $this->data['direct_purchase_master'] = $this->direct_purchase_mdl->received_master_views(array('rm.recm_receivedmasterid' => $id));
					//echo"<pre>";print_r($this->data['req_detail_list']);die();
					//$template=$this->load->view('purchase/v_print_report_direct_purchase',$this->data,true);

					$purchase_order_no = !empty($receive_master[0]->recm_purchaseorderno) ? $receive_master[0]->recm_purchaseorderno : '';

					$this->data['challan_no'] = $this->general->get_tbl_data('chma_challanmasterid,chma_challanrecno', 'chma_challanmaster', array('chma_puorid' => $purchase_order_no));

					$this->data['user_signature'] = $this->general->get_signature($this->userid);

					$recv_date = !empty($req_detail_list[0]->recm_receiveddatebs) ? $req_detail_list[0]->recm_receiveddatebs : CURDATE_NP;

					$approvedby = $this->general->get_store_post_data($recv_date, 'approver');

					$this->data['approver_signature'] = $this->general->get_signature($approvedby);

					$store_head_id = $this->general->get_store_post_data($recv_date, 'store_head');

					$this->data['store_head_signature'] = $this->general->get_signature($store_head_id);

					if (RECV_REPORT_TYPE == 'DEFAULT') {
						$template = $this->load->view('receive_against_order/v_voucher_print', $this->data, true);
					} else {
						$template = $this->load->view('receive_against_order/v_voucher_print' . '_' . REPORT_SUFFIX, $this->data, true);
					}

					// $template=$this->load->view('receive_against_order/v_received_against_order_print',$this->data,true);
					// print_r($template);die;
					if ($this->data['req_detail_list'] > 0) {
						print_r(json_encode(array('status' => 'success', 'message' => '', 'tempform' => $template)));
						exit;
					} else {
						print_r(json_encode(array('status' => 'error', 'message' => '')));
						exit;
					}
					print_r(json_encode(array('status' => 'success', 'message' => 'Successfully Selected!!', 'tempform' => $template)));
					exit;
				}
			} else {
				print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
				exit;
			}
		} else {
			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		}
	}

	public function api_post_expense_amount($rec_no)
	{	

		if (!$rec_no) {
			return false;
		}

		$req_detail_list = $this->direct_purchase_mdl->get_received_details(array('rd.recd_receivedmasterid' => $rec_no));

		if(!empty($req_detail_list)){
			foreach($req_detail_list as $req_list){
				$this->db->select('purd_reqdetailid');
				$this->db->from('pude_purchaseorderdetail pod');
				$this->db->join('purd_purchasereqdetail prd','pod.pude_requsitionid = prd.purd_reqdetid','LEFT');
				$this->db->where('pude_puordeid',$req_list->recd_purchaseorderdetailid);

				$req_detail = $this->db->get()->row();
				if (!empty($req_detail)) {
					$this->db->where('req_detailid',$req_detail->purd_reqdetailid);
					$this->db->where('status','O');
					$this->db->or_where('status','E');
					$this->db->from('api_budgetexpense');
					$expense_data = $this->db->get()->row();
					if (!empty($expense_data)) {

						$recd_amount = $req_list->recd_amount;
						$rem_block_amt = $expense_data->remaning_block_amount;

						$total_remaning_amt = $rem_block_amt - $recd_amount;

						$post_data = array(
							'id' => $expense_data->req_detailid,
							'budget_id' => $expense_data->account_code,
							'amount' => $recd_amount,
							'r_Status' => "expense",
							'entry_By' => $this->userid.' - '.$this->username,
							'entry_Date' => CURDATE_NP, 
						);

						if($this->general->api_send_budget_demand_amount($post_data)){
							$this->db->where('id',$expense_data->id);
							$this->db->update('api_budgetexpense',array('remaning_block_amount' =>$total_remaning_amt,'status' => 'E'));
						}
					}
				}
			}
		}

		return true;
	}

	public function api_post_cancel_expense_amount($rec_no)
	{	
		try{
			if(!$rec_no){
				throw new Exception('Received Number Not Found');
			}
			$req_detail_list = $this->direct_purchase_mdl->get_received_details(array('rd.recd_receivedmasterid' => $rec_no,'recd_status' => 'M'));

		if(!empty($req_detail_list)){
			foreach($req_detail_list as $req_list){
				$this->db->select('purd_reqdetailid');
				$this->db->from('pude_purchaseorderdetail pod');
				$this->db->join('purd_purchasereqdetail prd','pod.pude_requsitionid = prd.purd_reqdetid','LEFT');
				$this->db->where('pude_puordeid',$req_list->recd_purchaseorderdetailid);

				$req_detail = $this->db->get()->row();

				if (!empty($req_detail)) {
					$this->db->where('req_detailid',$req_detail->purd_reqdetailid);
					$this->db->where('locationid',$this->locationid);				
					$this->db->where('orgid',$this->orgid);				
					$this->db->where('status','E');
					$this->db->or_where('status','PR');
					$this->db->from('api_budgetexpense');
					$expense_data = $this->db->get()->row();
					if (!empty($expense_data)) {

						$recd_amount = $req_list->recd_amount;
						$block_amt = $expense_data->block_amount;

						if ($recd_amount == $block_amt) {
							$new_block_amount = $block_amt;
							$expense_status = 'C';
							$post_data = array(
                                'Req_MasterId'=> $expense_data->req_masterid,
                                'req_detailId' => $expense_data->req_detailid,
                                'r_Status' => 'C', 
                                'Entry_By' => null,
                                'Entry_Date' => null,
                                "Remarks" => 'Received Cancelled', 
                                "insUp" => "UP",
                                "Budget_id"=> 0,
                                "Amount"=> 0,
                                "Item_Description"=> null, 
                                "Rem_Amount"=> 0,
                                "Req_DateEn"=> null,
                                "Req_DateNp"=> null,
                                "Office_code"=> 0,
                                "Demand_No"=> 0, 
                                "Fyear"=> null,
                                "Updated_Date"=> str_replace('/', '.', CURDATE_NP), 
                                "Updated_Time"=> $this->general->get_currenttime(),
                                "Updated_By" =>$this->username,
                                "Entrytime"=> null,
                            ); 
								
						}else{
							$new_block_amount = $block_amt - $recd_amount;

							$expense_status = $expense_data->status;
							if ($expense_status == 'PR') {
								$api_status = 'P';
							}else if($expense_status == 'E'){
								$api_status = 'V';
							}

							$post_data = array(
                                'Req_MasterId'=> $expense_data->req_masterid,
                                'req_detailId' => $expense_data->req_detailid,
                                'r_Status' => $api_status, 
                                'Entry_By' => null,
                                'Entry_Date' => null,
                                "Remarks" => 'Received Cancelled', 
                                "insUp" => "UP",
                                "Budget_id"=> 0,
                                "Amount"=> (float)$new_block_amount,
                                "Item_Description"=> null, 
                                "Rem_Amount"=> (float)($expense_data->remaning_blocked_amount),
                                "Req_DateEn"=> null,
                                "Req_DateNp"=> null,
                                "Office_code"=> 0,
                                "Demand_No"=> 0, 
                                "Fyear"=> null,
                                "Updated_Date"=> str_replace('/', '.', CURDATE_NP), 
                                "Updated_Time"=> $this->general->get_currenttime(),
                                "Updated_By" =>$this->username,
                                "Entrytime"=> null,
                            ); 
						}	

						if($this->general->api_send_budget_demand_amount($post_data)){
							$this->db->where('id',$expense_data->id);
							$this->db->update('api_budgetexpense',array('block_amount' =>$new_block_amount,'status' => $expense_status));  
						}
					}
				}
			}
		}
		return true;
		}catch(Exception $e){
			throw new Exception($e->getMessage());
		}	
	}

public function no_supplier($reload = false)
	{

		$order_masterid = $this->input->post('id');
		$orderno = '';
		if (!empty($order_masterid)) {
			$get_orderno = $this->general->get_tbl_data('puor_orderno', 'puor_purchaseordermaster', array('puor_purchaseordermasterid' => $order_masterid));
			if (!empty($get_orderno)) {
				$orderno = !empty($get_orderno[0]->puor_orderno) ? $get_orderno[0]->puor_orderno : '';
			}
		}
		$this->data['order_no'] = $orderno;

		$locationid = $this->session->userdata(LOCATION_ID);
		$this->data['store_type'] = $this->general->get_tbl_data('*', 'store', false, 'st_store_id', 'ASC');

		// echo $this->db->last_query();
		// die();
		$this->data['tab_type'] = 'no_supplier';
		$this->data['fiscal'] = $this->general->get_tbl_data('*', 'fiye_fiscalyear', false, 'fiye_fiscalyear_id', 'DESC', '2');

		$this->data['supplier_all'] = $this->general->get_tbl_data('*', 'dist_distributors', false, 'dist_distributor', 'ASC');

		// echo "<pre>";print_r($this->data['material_type']);die();
		$this->data['department'] = $this->general->get_tbl_data('*', 'dept_department', array('dept_locationid' => $this->locationid), 'dept_depid', 'DESC');
		if (!empty($this->mattypeid)) {
			$srchmat = array('maty_materialtypeid' => $this->mattypeid, 'maty_isactive' => 'Y');
			$srchbudg = array('budg_materialtypeid' => $this->mattypeid);
		} else {
			$srchmat = array('maty_isactive' => 'Y');
			$srchbudg = '';
		}
		$srchbudg = '';
		$this->data['budgets_list'] = $this->general->get_tbl_data('*', 'budg_budgets', $srchbudg, 'budg_budgetname', 'ASC');
		// echo $this->db->last_query();
		// die();

		// echo "<pre>";
		// print_r($this->data['budgets_list']);
		// die();

		$this->data['material_type'] = $this->general->get_tbl_data('maty_materialtypeid,maty_material', 'maty_materialtype', $srchmat, 'maty_materialtypeid', 'ASC');

		$currentfyrs = CUR_FISCALYEAR;

		// echo ORGANIZATION_NAME;
		// die();

		$this->db->select('recm_invoiceno,recm_fyear')
			->from('recm_receivedmaster')
			->where('recm_locationid', $locationid);
		if (ORGANIZATION_NAME == 'KU' || ORGANIZATION_NAME=='ARMY' || ORGANIZATION_NAME == 'PU') {
			if ($this->mattypeid) {
				$this->db->where('recm_mattypeid', $this->mattypeid);
			} else {
				$this->db->where('recm_mattypeid', 1);
			}
		}

		$cur_fiscalyrs_invoiceno = $this->db->order_by('recm_fyear', 'DESC')
			->limit(1)
			->get()->row();

		// echo "<pre>";
		// echo($this->db->last_query());
		// die();

		// echo "<pre>";
		// print_r($cur_fiscalyrs_invoiceno);
		// die();

		if (!empty($cur_fiscalyrs_invoiceno)) {
			$invoice_format = $cur_fiscalyrs_invoiceno->recm_invoiceno;

			$invoice_string = str_split($invoice_format);
			// echo "<pre>";
			// print_r($invoice_string);
			// die();
			$invoice_prefix_len = strlen(RECEIVED_NO_PREFIX);
			$chk_first_string_after_invoice_prefix = $invoice_string[$invoice_prefix_len];
			// echo $chk_first_string_after_invoice_prefix;
			// die();
			if ($chk_first_string_after_invoice_prefix == '0') {
				$invoice_no_prefix = RECEIVED_NO_PREFIX . CUR_FISCALYEAR;
			} else if ($cur_fiscalyrs_invoiceno->recm_fyear == $currentfyrs && $chk_first_string_after_invoice_prefix == '0') {
				$invoice_no_prefix = RECEIVED_NO_PREFIX . CUR_FISCALYEAR;
			} else if ($cur_fiscalyrs_invoiceno->recm_fyear != $currentfyrs && $chk_first_string_after_invoice_prefix == '0') {
				$invoice_no_prefix = RECEIVED_NO_PREFIX . CUR_FISCALYEAR;
			} else if ($cur_fiscalyrs_invoiceno->recm_fyear != $currentfyrs && $chk_first_string_after_invoice_prefix != '0') {
				$invoice_no_prefix = RECEIVED_NO_PREFIX . CUR_FISCALYEAR;
			} else {
				$invoice_no_prefix = RECEIVED_NO_PREFIX;
			}
		} else {
			$invoice_no_prefix = RECEIVED_NO_PREFIX . CUR_FISCALYEAR;
		}

		// $this->data['received_no']=$this->generate_receiveno();
		if (ORGANIZATION_NAME == 'KU' || ORGANIZATION_NAME == 'PU') {
			$invoice_no_prefix = '';
			if ($this->mattypeid) {
				$mattypeid = $this->mattypeid;
			} else {
				$mattypeid = 1;
			}

			$this->data['received_no'] = $this->general->generate_invoiceno('recm_invoiceno', 'recm_invoiceno', 'recm_receivedmaster', $invoice_no_prefix, RECEIVED_NO_LENGTH, array('recm_mattypeid' => $mattypeid), 'recm_locationid', 'recm_fyear DESC ,recm_receivedmasterid  DESC', 'M', false, 'Y');
			// echo $this->db->last_query();
			// die();
		} else {
			$this->data['received_no'] = $this->general->generate_invoiceno('recm_invoiceno', 'recm_invoiceno', 'recm_receivedmaster', $invoice_no_prefix, RECEIVED_NO_LENGTH, false, 'recm_locationid', 'recm_fyear DESC ,recm_receivedmasterid  DESC', 'M');
		}

		if ($reload == 'reload') {
			$this->data['loadselect2'] = 'yes';
		$this->load->view('receive_against_order/pu/v_receive_against_order_form_no_supplier', $this->data);
		} else {
			$this->data['loadselect2'] = 'no';
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
				->build('receive_against_order/v_against_order', $this->data);
		}
	}

public function orderlist_by_order_no_no_supplier()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$orderno = $this->input->post('orderno');
			$fiscalyrs = $this->input->post('fiscalyear');
			$mattypeid = $this->input->post('mattypeid');
			$puor_storeid = $this->session->userdata(STORE_ID);

			if (ORGANIZATION_NAME == 'KUKL') {
				$this->data['order_data'] = $this->receive_against_order_mdl->get_orderlist_by_order_no(array('po.puor_orderno' => $orderno, 'po.puor_fyear' => $fiscalyrs, 'puor_storeid' => $puor_storeid, 'puor_locationid' => $this->locationid, 'puor_verified' => 2));
			} else {

				$srchcol = array('po.puor_orderno' => $orderno, 'po.puor_fyear' => $fiscalyrs, 'puor_storeid' => $puor_storeid, 'puor_locationid' => $this->locationid);

				if (!empty($mattypeid)) {
					$srchcol['po.puro_mattypeid'] = $mattypeid;
				}
				if (!empty($this->mattypeid)) {
					$srchcol['po.puro_mattypeid'] = $this->mattypeid;
				}

				$this->data['order_data'] = $this->receive_against_order_mdl->get_orderlist_by_order_no($srchcol);

				if (ORGANIZATION_NAME == 'KU' || ORGANIZATION_NAME=='ARMY' || ORGANIZATION_NAME == 'PU' ) {
					$purchase_masterid = !empty($this->data['order_data'][0]->puor_purchaseordermasterid) ? $this->data['order_data'][0]->puor_purchaseordermasterid : '';
					if (!empty($purchase_masterid)) {
						$this->db->select('rm.rema_reqfromdepid depid,d.dept_depname depname, rm.rema_school schoolid,loc.loca_name schoolname');
						$this->db->from('puor_purchaseordermaster pm');
						$this->db->join('pure_purchaserequisition pr', 'pr.pure_purchasereqid=pm.puor_purchasereqmasterid', 'LEFT');
						$this->db->join('rema_reqmaster rm', 'rm.rema_reqmasterid=pr.pure_reqmasterid', 'LEFT');
						$this->db->join('dept_department d', 'd.dept_depid=rm.rema_reqfromdepid', 'LEFT');
						$this->db->join('loca_location loc', 'loc.loca_locationid=rm.rema_school', 'LEFT');
						$this->db->where('puor_purchaseordermasterid', $purchase_masterid);
						$result = $this->db->get()->row();
						// echo "<pre>";
						// print_r($result);
						// die();
						if (!empty($result)) {

							$check_parentid = $this->general->get_tbl_data('*', 'dept_department', array('dept_depid' => $result->depid), 'dept_depname', 'ASC');

							// echo "<pre>";
							// print_r($check_parentid);
							// die();
							$this->data['order_data']['parentdepid'] = '';
							if (!empty($check_parentid)) {
								$dep_parentid = !empty($check_parentid[0]->dept_parentdepid) ? $check_parentid[0]->dept_parentdepid : '0';
								if ($dep_parentid != 0) {
									$this->data['parent_depid'] = $dep_parentid;
									$parent_department = $this->general->get_tbl_data('*', 'dept_department', array('dept_depid' => $dep_parentid), 'dept_depname', 'ASC');
								}
								// echo "sad<pre>";
								// print_r($parent_department);
								// die();
								$this->data['order_data']['parentdepid'] = !empty($parent_department[0]->dept_depid) ? $parent_department[0]->dept_depid : '';
							}

							$this->data['order_data']['depid'] = $result->depid;
							$this->data['order_data']['depname'] = $result->depname;
							$this->data['order_data']['schoolid'] = $result->schoolid;
							$this->data['order_data']['schoolname'] = $result->schoolname;
						}
					}
				}
			}

			// echo $this->db->last_query();
			// die();
			// echo $this->db->last_query();die;
			// echo "<pre>";print_r($this->data['order_data']);die();
			$purchased = !empty($this->data['order_data'][0]->puor_purchased) ? $this->data['order_data'][0]->puor_purchased : '';
			$status = !empty($this->data['order_data'][0]->puor_status) ? $this->data['order_data'][0]->puor_status : '';

			if (empty($this->data['order_data'])) {
				print_r(json_encode(array('status' => 'error', 'message' => 'Order no. ' . $orderno . ' is not found!!')));
				exit;
			}
			if ($purchased == '2') {
				print_r(json_encode(array('status' => 'error', 'message' => 'Order no. ' . $orderno . ' has been purchased/received completely')));
				exit;
			}
			if ($status == 'C') {
				print_r(json_encode(array('status' => 'error', 'message' => 'Order no. ' . $orderno . ' is cancelled.')));
				exit;
			}
			if ($status == 'CH') {
				print_r(json_encode(array('status' => 'error', 'message' => 'Order no. ' . $orderno . 'is received through challan.')));
				exit;
			}

			$this->data['order_detail'] = array();
			$tempform = '';
			if ($this->data['order_data']) {
				$ordermasterid = $this->data['order_data'][0]->puor_purchaseordermasterid;
				$this->data['order_detail'] = $this->receive_against_order_mdl->get_orderdetail_list(array('pude_purchasemasterid' => $ordermasterid));
				// echo $this->db->last_query();
				// die();
				// echo "<pre>";
				// print_r($this->data['order_detail']);
				// die();

				$this->data['supplier_all'] = $this->general->get_tbl_data('*', 'dist_distributors', false, 'dist_distributor', 'ASC');

				$srchbudg = '';
				$this->data['budgets_list'] = $this->general->get_tbl_data('*', 'budg_budgets', $srchbudg, 'budg_budgetname', 'ASC');

				if (!empty($this->data['order_detail'])) {
					// echo "asd";
					// die();
					$tempform = $this->load->view('receive_against_order/pu/v_receive_against_order_form_detail_no_supplier', $this->data, true);
				}
			}
			// echo"<pre>"; print_r($tempform);die;
			print_r(json_encode(array('status' => 'success', 'order_data' => $this->data['order_data'], 'tempform' => $tempform, 'message' => 'Selected Successfully')));
			exit;
		} else {
			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		}
	}


	public function save_received_items_no_supplier($print = false)
	{
		// echo"<pre>";print_r($this->input->post());die;
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			try {

				if ($this->input->post('id')) {
					if (MODULES_UPDATE == 'N') {
						$this->general->permission_denial_message();
						exit;
					}
				} else {
					if (MODULES_INSERT == 'N') {
						$this->general->permission_denial_message();
						exit;
					}
				}

				$this->form_validation->set_rules($this->receive_against_order_mdl->validate_settings_receive_against_order_no_supplier);
				if ($this->form_validation->run() == TRUE) {
					$trans = $this->receive_against_order_mdl->save_receive_order_no_supplier();
					if ($trans) {
						$print_report = "";
						if ($print = "print") {
							$req_detail_list = $this->data['req_detail_list'] = $this->direct_purchase_mdl->get_received_details(array('rd.recd_receivedmasterid' => $trans));
							$this->data['direct_purchase_master'] = $this->direct_purchase_mdl->received_master_views(array('rm.recm_receivedmasterid' => $trans));

							if (!empty($this->data['direct_purchase_master'])) {
								$this->data['mattypeid'] = !empty($this->data['direct_purchase_master'][0]->recm_mattypeid) ? $this->data['direct_purchase_master'][0]->recm_mattypeid : '';
							}

							$this->data['user_signature'] = $this->general->get_signature($this->userid);

							$recv_date = !empty($req_detail_list[0]->recm_receiveddatebs) ? $req_detail_list[0]->recm_receiveddatebs : CURDATE_NP;

							$approvedby = $this->general->get_store_post_data($recv_date, 'approver');

							$this->data['approver_signature'] = $this->general->get_signature($approvedby);

							$store_head_id = $this->general->get_store_post_data($recv_date, 'store_head');

							$this->data['store_head_signature'] = $this->general->get_signature($store_head_id);

							if (RECV_REPORT_TYPE == 'DEFAULT') {
								$print_report = $this->load->view('receive_against_order/v_received_against_order_print', $this->data, true);
							} else {
								$print_report = $this->load->view('receive_against_order/v_received_against_order_print' . '_' . REPORT_SUFFIX, $this->data, true);
							}
							
						}
						print_r(json_encode(array('status' => 'success', 'message' => 'Received Order Successfully', 'print_report' => $print_report)));
						exit;
					} else {
						print_r(json_encode(array('status' => 'error', 'message' => 'Operation Failed.')));
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


}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */