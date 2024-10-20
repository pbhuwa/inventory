<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Workorder extends CI_Controller

{

	function __construct()

	{



		parent::__construct();



		$this->load->Model('work_order_mdl');

		$this->load->library('upload');

		$this->load->library('image_lib');

		$this->load->helper('file');

		$this->load->helper('form');
	}





	public function index()

	{

		//echo "aa";die;

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

		$this->data['breadcrumb'] = 'Assets Maintenance';



		$this->data['tab_type'] = "entry";

		$this->page_title = 'Work Order Entry';

		$this->template

			->set_layout('general')

			->enable_parser(FALSE)

			->title($this->page_title)

			->build('work_order/v_assets_work_order_common', $this->data);
	}



	public function entry($reload = false)

	{

		//echo "aa";die;

		$this->data['reload'] = $reload;

		$locationid = $this->session->userdata(LOCATION_ID);

		$currentfyrs = CUR_FISCALYEAR;





		$cur_fiscalyrs_invoiceno = $this->db->select('woma_workorderno,woma_fiscalyrs')

			->from('woma_workordermaster')

			->where('woma_locationid', $locationid)

			// ->where('prin_fiscalyrs',$currentfyrs)

			->order_by('woma_fiscalyrs', 'DESC')

			->limit(1)

			->get()->row();



		// echo "<pre>";

		// print_r($cur_fiscalyrs_invoiceno);

		// die();



		if (!empty($cur_fiscalyrs_invoiceno)) {

			$invoice_format = $cur_fiscalyrs_invoiceno->woma_workorderno;



			$invoice_string = str_split($invoice_format);

			// echo "<pre>";

			// print_r($invoice_string);

			// die();

			$invoice_prefix_len = strlen(WORKORDER_CODE_NO_PREFIX);

			$chk_first_string_after_invoice_prefix = $invoice_string[$invoice_prefix_len];

			// echo $chk_first_string_after_invoice_prefix;

			// die();

			if ($chk_first_string_after_invoice_prefix == '0') {

				$invoice_no_prefix = WORKORDER_CODE_NO_PREFIX . CUR_FISCALYEAR;
			} else if ($cur_fiscalyrs_invoiceno->prin_fiscalyrs == $currentfyrs && $chk_first_string_after_invoice_prefix == '0') {

				$invoice_no_prefix = WORKORDER_CODE_NO_PREFIX . CUR_FISCALYEAR;
			} else if ($cur_fiscalyrs_invoiceno->prin_fiscalyrs != $currentfyrs && $chk_first_string_after_invoice_prefix == '0') {

				$invoice_no_prefix = WORKORDER_CODE_NO_PREFIX . CUR_FISCALYEAR;
			} else if ($cur_fiscalyrs_invoiceno->prin_fiscalyrs != $currentfyrs && $chk_first_string_after_invoice_prefix != '0') {

				$invoice_no_prefix = WORKORDER_CODE_NO_PREFIX . CUR_FISCALYEAR;
			} else {

				$invoice_no_prefix = WORKORDER_CODE_NO_PREFIX;
			}
		} else {

			$invoice_no_prefix = WORKORDER_CODE_NO_PREFIX . CUR_FISCALYEAR;
		}

		// die();









		$this->data['workorder_code'] = $this->general->generate_invoiceno('woma_workorderno', 'woma_workorderno', 'woma_workordermaster', $invoice_no_prefix, PROJECT_CODE_NO_LENGTH, false, 'woma_locationid');



		$this->data['fiscal_year'] = $this->general->get_tbl_data('*', 'fiye_fiscalyear', false, 'fiye_fiscalyear_id', 'DESC', 2);

		$this->data['distributor'] = $this->general->get_tbl_data('*', 'dist_distributors', array('dist_isactive' => 'Y'), 'dist_distributor', 'ASC');

		$this->data['project_list'] = $this->general->get_tbl_data('*', 'prin_projectinfo', array('prin_fiscalyrs' => $currentfyrs, 'prin_st' => 'O'), 'prin_prinid', 'ASC');





		// echo "<pre>";

		// print_r($this->data);

		// die();

		if ($reload == 'reload') {



			$this->load->view('work_order/v_work_order_form', $this->data);
		} else {

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

			$this->data['breadcrumb'] = 'Work Order Entry';



			$this->data['tab_type'] = "entry";

			$this->page_title = 'Assets Assets';

			$this->template

				->set_layout('general')

				->enable_parser(FALSE)

				->title($this->page_title)

				->build('work_order/v_assets_work_order_common', $this->data);
		}
	}



	public function save_work_order($print = false)
	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			try {

				// echo "<pre>";

				// print_r($this->input->post());

				// die();



				if ($this->input->post('id')) {

					if (MODULES_UPDATE == 'N') {

						$this->general->permission_denial_message();

						exit;
					}



					$action_log_message = "edit";
				} else {

					if (MODULES_INSERT == 'N') {

						$this->general->permission_denial_message();

						exit;
					}

					$action_log_message = "";
				}



				$this->form_validation->set_rules($this->work_order_mdl->validate_settings_work_order);

				if ($this->form_validation->run() == TRUE) {   //echo "<pre>"; print_r($this->input->post());die;

					$trans = $this->work_order_mdl->work_order_save();

					if ($trans) {

						if ($print == "print") {



							$print_report = '';



							print_r(json_encode(array('status' => 'success', 'message' => 'Record Save Successfully.', 'print_report' => $print_report)));

							exit;
						}

						print_r(json_encode(array('status' => 'success', 'message' => 'Record Save Successfully.')));

						exit;
					} else {

						print_r(json_encode(array('status' => 'error', 'message' => 'Unsuccessful Operation.')));

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



	public function summary()

	{



		$frmDate = CURMONTH_DAY1;

		$toDate = CURDATE_NP;

		$cur_fiscalyear = CUR_FISCALYEAR;

		$this->data['fiscalyear'] = $this->general->get_tbl_data('*', 'fiye_fiscalyear', false, 'fiye_fiscalyear_id', 'DESC');

		$this->data['distributor'] = $this->general->get_tbl_data('*', 'dist_distributors', array('dist_isactive' => 'Y'), 'dist_distributor', 'ASC');

		$this->data['project_list'] = $this->general->get_tbl_data('*', 'prin_projectinfo', array('prin_st' => 'O'), 'prin_prinid', 'ASC');



		$this->data['breadcrumb'] = 'Work Order Summary';

		$this->data['tab_type'] = "work_order_summary";

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





		$this->session->unset_userdata('id');

		$this->page_title = 'Work Order Summary';

		$this->template

			->set_layout('general')

			->enable_parser(FALSE)

			->title($this->page_title)

			->build('work_order/v_assets_work_order_common', $this->data);
	}



	public function get_summary_list()
	{

		if (MODULES_VIEW == 'N') {

			$array = array();

			echo json_encode(array("recordsFiltered" => 0, "recordsTotal" => 0, "data" => $array));

			exit;
		}

		$useraccess = $this->session->userdata(USER_ACCESS_TYPE);

		$i = 0;





		$data = $this->work_order_mdl->get_work_order_summary_list();

		$array = array();

		$filtereddata = ($data["totalfilteredrecs"] > 0 ? $data["totalfilteredrecs"] : $data["totalrecs"]);

		$totalrecs = $data["totalrecs"];

		unset($data["totalfilteredrecs"]);

		unset($data["totalrecs"]);





		foreach ($data as $row) {

			$array[$i]['datead'] = $row->woma_datead;

			$array[$i]['datebs'] = $row->woma_datebs;

			$array[$i]['workorderno'] = $row->woma_workorderno;

			$array[$i]['noticeno'] = $row->woma_noticeno;

			$array[$i]['projectname'] = $row->projectname;

			$array[$i]['contractor_name'] = $row->contractor_name;

			$array[$i]['manualno'] = $row->woma_manualno;

			$array[$i]['fiscalyrs'] = $row->woma_fiscalyrs;



			$array[$i]['noticedatead'] = $row->woma_noticedatead;

			$array[$i]['noticedatebs'] = $row->woma_noticedatebs;



			$array[$i]['action'] = '<a href="javascript:void(0)" title="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></i></a>&nbsp;<a href="javascript:void(0)" class="view" data-id=' . $row->woma_womasterid . ' title="View" data-viewurl="' . base_url("/ams/workorder/view_approved_operation") . '" data-heading="Estimate Work Order"><i class="fa fa-check"></i></a>&nbsp;<a href="javascript:void(0)" class="view" data-id=' . $row->woma_womasterid . '  data-viewurl="' . base_url("/ams/workorder/get_work_order_data_by_id") . '" title="Work Order Data" data-heading="Work Order Data"><i class="fa fa-eye"></i></a>';

			$array[$i]['viewurl'] = base_url() . 'issue_consumption/stock_requisition';



			$i++;
		}

		$get = $_GET;

		echo json_encode(array("recordsFiltered" => $filtereddata, "recordsTotal" => $totalrecs, "data" => $array));
	}



	public function get_work_order_data_by_id()
	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			if ($_SERVER['REQUEST_METHOD'] === 'POST') {

				$id = $this->input->post('id');

				if ($id) {

					$this->data['work_order_master'] = $this->work_order_mdl->get_work_order_master_data(array('wm.woma_womasterid' => $id));



					$template = '';

					if ($this->data['work_order_master'] > 0) {

						$this->data['distinct_dtype'] = $this->general->get_tbl_data('DISTINCT(wode_dtype)', 'wode_workorderdetail wd', array('wd.wode_womasterid' => $id));

						// echo "<pre>";

						// print_r($distinct_dtype);

						// die();





						$this->data['id'] = $id;



						// echo "<pre>";

						// print_r($this->data['work_order_detail']);

						// die();



						$template = $this->load->view('work_order/v_work_order_detail_view', $this->data, true);



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



	public function view_approved_operation()
	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			if ($_SERVER['REQUEST_METHOD'] === 'POST') {

				$id = $this->input->post('id');

				if ($id) {

					$this->data['work_order_master'] = $this->work_order_mdl->get_work_order_master_data(array('wm.woma_womasterid' => $id));
					$this->data['contractbill_list'] = $this->general->get_tbl_data('*', 'wocb_workordercontractbill', array('wocb_womasterid' => $id));
					$this->data['payment_list'] = $this->general->get_tbl_data('*', 'wopa_workorderpayment', array('wopa_masterid' => $id));
					$template = '';

					if ($this->data['work_order_master'] > 0) {

						$this->data['distinct_dtype'] = $this->general->get_tbl_data('DISTINCT(wode_dtype)', 'wode_workorderdetail wd', array('wd.wode_womasterid' => $id));

						// echo "<pre>";

						// print_r($distinct_dtype);

						// die();





						$this->data['id'] = $id;







						$template = $this->load->view('work_order/v_work_order_detail_view', $this->data, true);

						$template .= $this->load->view('work_order/v_work_order_flowstep', $this->data, true);



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





	public function change_status()

	{
		// echo "<pre>";
		// var_dump($_POST);
		// die;

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			try {

				$input_status = $this->input->post('woma_workorderstatus');

				$curstatus = $this->check_current_status();

				if ($input_status == $curstatus) {

					print_r(json_encode(array('status' => 'error', 'message' => 'Same Status')));
					exit;
				}

				$trans = $this->work_order_mdl->save_work_order_status();

				if ($trans) {

					print_r(json_encode(array('status' => 'success', 'message' => 'Record Saved Successfully !!')));

					exit;
				} else {

					print_r(json_encode(array('status' => 'error', 'message' => 'Error while saving Data !!.')));

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

	public function workorder_bill_and_payment()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			try {

				// $input_status = $this->input->post('woma_workorderstatus');

				// $curstatus = $this->check_current_status();

				// if ($input_status == $curstatus) {

				// 	print_r(json_encode(array('status' => 'error', 'message' => 'Same Status')));
				// 	exit;
				// }

				$trans = $this->work_order_mdl->save_workorder_bill_and_payment();

				if ($trans) {

					print_r(json_encode(array('status' => 'success', 'message' => 'Record Saved Successfully !!')));

					exit;
				} else {

					print_r(json_encode(array('status' => 'error', 'message' => 'Error while saving Data !!.')));

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



	public function check_current_status()

	{

		$masterid = $this->input->post('masterid');

		// $woma_workorderstatus=$this->input->post

		$this->db->select('woma_workorderstatus');

		$this->db->from('woma_workordermaster');

		$this->db->where(array('woma_womasterid' => $masterid));

		$result = $this->db->get()->row();

		if (!empty($result)) {

			return $result->woma_workorderstatus;
		}

		return false;
	}









	public function detail()

	{

		//echo "aa";die;

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

		$this->data['breadcrumb'] = 'Work Order Detail';



		$this->data['tab_type'] = "Log";



		$this->session->unset_userdata('id');

		$this->page_title = 'Assets Assets';

		$this->template

			->set_layout('general')

			->enable_parser(FALSE)

			->title($this->page_title)

			->build('work_order/v_assets_work_order_common', $this->data);
	}





	public function reprint_work_order()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$id = $this->input->post('id');

			$this->data = array();

			if ($id) {

				$this->data['work_order_detail'] = array();

				$this->data['work_order_master'] = $this->work_order_mdl->get_work_order_master_data(array('wm.woma_womasterid' => $id));

				if ($this->data['work_order_master'] > 0) {

					$this->data['work_order_detail'] = $this->work_order_mdl->get_work_order_detail_data(array('wd.wode_womasterid' => $id));
				}



				// echo "<pre>";

				// print_r($this->data);

				// die();



				$template = $this->load->view('ams/work_order/v_work_order_reprint', $this->data, true);





				if ($template) {

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
	}
}
