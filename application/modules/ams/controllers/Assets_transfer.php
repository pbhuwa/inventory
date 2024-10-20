<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Assets_transfer extends CI_Controller

{

	function __construct()

	{

		parent::__construct();

		$this->load->Model('assets_transfer_mdl');
		$this->load->Model('assets_mdl');

		$this->load->library('upload');

		$this->load->library('image_lib');

		$this->load->helper('file');

		$this->load->helper('form');
	}

	public function index($reload = false)

	{


		$this->data['reload'] = $reload;

		$locationid = $this->session->userdata(LOCATION_ID);

		$currentfyrs = CUR_FISCALYEAR;

		$cur_fiscalyrs_transferno = $this->db->select('astm_transferno,astm_fiscalyrs')

			->from('astm_assettransfermaster')

			->where('astm_locationid', $locationid)

			// ->where('prin_fiscalyrs',$currentfyrs)

			->order_by('astm_fiscalyrs', 'DESC')

			->limit(1)

			->get()->row();

		// echo "<pre>";

		// print_r($cur_fiscalyrs_transferno);

		// die();

		if (!empty($cur_fiscalyrs_transferno)) {

			$transfer_format = $cur_fiscalyrs_transferno->astm_transferno;

			$transfer_string = str_split($transfer_format);

			// echo "<pre>";

			// print_r($transfer_string);

			// die();

			$transfer_prefix_len = strlen(ASSETS_TRANSFER_CODE_NO_PREFIX);

			$chk_first_string_after_transfer_prefix = $transfer_string[$transfer_prefix_len];

			// echo $chk_first_string_after_transfer_prefix;

			// die();

			if ($chk_first_string_after_transfer_prefix == '0') {

				$transfer_no_prefix = ASSETS_TRANSFER_CODE_NO_PREFIX . CUR_FISCALYEAR;
			} else if ($cur_fiscalyrs_transferno->prin_fiscalyrs == $currentfyrs && $chk_first_string_after_transfer_prefix == '0') {

				$transfer_no_prefix = ASSETS_TRANSFER_CODE_NO_PREFIX . CUR_FISCALYEAR;
			} else if ($cur_fiscalyrs_transferno->prin_fiscalyrs != $currentfyrs && $chk_first_string_after_transfer_prefix == '0') {

				$transfer_no_prefix = ASSETS_TRANSFER_CODE_NO_PREFIX . CUR_FISCALYEAR;
			} else if ($cur_fiscalyrs_transferno->prin_fiscalyrs != $currentfyrs && $chk_first_string_after_transfer_prefix != '0') {

				$transfer_no_prefix = ASSETS_TRANSFER_CODE_NO_PREFIX . CUR_FISCALYEAR;
			} else {

				$transfer_no_prefix = ASSETS_TRANSFER_CODE_NO_PREFIX;
			}
		} else {

			$transfer_no_prefix = ASSETS_TRANSFER_CODE_NO_PREFIX . CUR_FISCALYEAR;
		}

		// die();

		$this->data['transfer_code'] = $this->general->generate_invoiceno('astm_transferno', 'astm_transferno', 'astm_assettransfermaster', $transfer_no_prefix, ASSETS_TRANSFER_CODE_NO_LENGTH, false, 'astm_locationid');

		$this->data['fiscal_year'] = $this->general->get_tbl_data('*', 'fiye_fiscalyear', false, 'fiye_fiscalyear_id', 'DESC', 2);

		$this->data['department_list'] = $this->general->get_tbl_data('*', 'dept_department', array('dept_isactive' => 'Y', 'dept_locationid' => $locationid));

		// $this->data['department_list']= '';

		$this->data['location_list'] = $this->general->get_tbl_data('*', 'loca_location', false);
		$this->data['locationid'] = $locationid;
		$this->data['staff_list'] = $this->general->get_tbl_data('*', 'stin_staffinfo');

		$this->data['tab_type'] = 'entry';

		if ($reload == 'reload') {

			// $this->load->view('assets_transfer/v_assets_transfer', $this->data);
			if (ORGANIZATION_NAME == 'KU' || ORGANIZATION_NAME == 'ARMY' ) {
				
				// die();
				$this->load->view('assets_transfer/ku/v_assets_transfer', $this->data);

			} else {
				
				$this->load->view('assets_transfer/v_assets_transfer', $this->data);
			}
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

			$this->data['breadcrumb'] = 'Transfer of Assets';

			$this->template

				->set_layout('general')

				->enable_parser(FALSE)

				->title($this->page_title)

				->build('assets_transfer/v_assets_transfer_common', $this->data);
		}
	}

	public function summary()
	{

		$this->data['department_list'] = $this->general->get_tbl_data('*', 'dept_department', array('dept_isactive' => 'Y'));
		$locationid = $this->session->userdata(LOCATION_ID);
		$this->data['locationid'] = $locationid;
		$this->data['breadcrumb'] = 'Transfer Summary';

		$this->data['tab_type'] = "transfer_summary";

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

		$this->page_title = 'Assets Transfer Summary';

		$this->template

			->set_layout('general')

			->enable_parser(FALSE)

			->title($this->page_title)

			->build('assets_transfer/v_assets_transfer_common', $this->data);
	}

	public function get_assets_transfer_summary_list()
	{

		if (MODULES_VIEW == 'N') {

			$array = array();

			echo json_encode(array("recordsFiltered" => 0, "recordsTotal" => 0, "data" => $array));

			exit;
		}

		$useraccess = $this->session->userdata(USER_ACCESS_TYPE);

		$i = 0;

		if (ORGANIZATION_NAME == 'KU' || ORGANIZATION_NAME=='ARMY') {
			$data = $this->assets_transfer_mdl->get_summary_list_of_assets_transfer_ku();
		} else {
			$data = $this->assets_transfer_mdl->get_summary_list_of_assets_transfer();
		}

		// echo "<pre>";

		// print_r($data);

		// die();

		$array = array();

		$filtereddata = ($data["totalfilteredrecs"] > 0 ? $data["totalfilteredrecs"] : $data["totalrecs"]);

		$totalrecs = $data["totalrecs"];

		unset($data["totalfilteredrecs"]);

		unset($data["totalrecs"]);

		foreach ($data as $row) {
			if (ORGANIZATION_NAME == 'KU' || ORGANIZATION_NAME =='ARMY' ) {
				$fromschool = $row->fromlocation;
				$fromdepparent = $row->fromdepparent;
				$fromdep = $row->fromdep;
				if (!empty($fromdepparent)) {
					$from_departmentname = $fromdepparent . '/' . $fromdep;
				} else {
					$from_departmentname = $fromdep;
				}
				$array[$i]['from'] = $fromschool . '-' . $from_departmentname;

				$toschoolname = $row->tolocation;
				$todep = $row->todep;
				$todepparent = $row->todepparent;
				if (!empty($todepparent)) {
					$to_departmentname = $todepparent . '/' . $todep;
				} else {
					$to_departmentname = $todep;
				}

				$array[$i]['to'] = $toschoolname . '-' . $to_departmentname;
				$array[$i]['received_by'] = $row->astm_receivedby;
			} else {
				$transfertype = $row->astm_transfertypeid;
				if ($transfertype == 'D') {
					$array[$i]['transfertype'] = 'Department';
					$array[$i]['from'] = $row->fromdep;
					$array[$i]['to'] = $row->todep;
				}

				if ($transfertype == 'B') {
					$array[$i]['transfertype'] = 'Branch';
					$array[$i]['from'] = $row->fromlocation;
					$array[$i]['to'] = $row->tolocation;
				}
			}

			$array[$i]['datead'] = $row->astm_transferdatead;

			$array[$i]['datebs'] = $row->astm_transferdatebs;

			$array[$i]['transferno'] = $row->astm_transferno;

			$array[$i]['noofassets'] = $row->astm_noofassets;

			$array[$i]['manualno'] = $row->astm_manualno;

			$array[$i]['fiscalyrs'] = $row->astm_fiscalyrs;
			$array[$i]['remarks'] = $row->astm_remark;

			$array[$i]['action'] = '<a href="javascript:void(0)" class="view" data-id=' . $row->astm_assettransfermasterid . ' title="View" data-viewurl="' . base_url("/ams/assets_transfer/get_assets_transfer_data_by_id") . '" title="View Transfer Summary" data-heading="Assets Transfer Summary"><i class="fa fa-eye"></i></a>';

			$i++;
		}

		$get = $_GET;

		echo json_encode(array("recordsFiltered" => $filtereddata, "recordsTotal" => $totalrecs, "data" => $array));
	}

	public function get_assets_transfer_data_by_id()
	{

			if ($_SERVER['REQUEST_METHOD'] === 'POST') {

				$id = $this->input->post('id');

				if ($id) {

					if (ORGANIZATION_NAME == 'KU' || ORGANIZATION_NAME=='ARMY') {
						$this->data['assets_transfer_master'] = $this->assets_transfer_mdl->get_assets_transfer_detail_data_ku(array('tm.astm_assettransfermasterid' => $id));
					} else {
						$this->data['assets_transfer_master'] = $this->assets_transfer_mdl->get_assets_transfer_detail_data(array('tm.astm_assettransfermasterid' => $id));
					}

					$template = '';

					if ($this->data['assets_transfer_master'] > 0) {
						if (ORGANIZATION_NAME == 'KU'  || ORGANIZATION_NAME=='ARMY') {
							$this->data['assets_transfer_detail'] = $this->assets_transfer_mdl->get_assets_transfer_detail_data_ku(array('tm.astm_assettransfermasterid' => $id));
						} else {
							$this->data['assets_transfer_detail'] = $this->assets_transfer_mdl->get_assets_transfer_detail_data(array('td.astd_assetetransfermasterid' => $id));
						}

						// echo "<pre>";

						// print_r($this->data['assets_transfer_master']);

						// die();

						if (ORGANIZATION_NAME == 'KU'  || ORGANIZATION_NAME=='ARMY') {
							$template = $this->load->view('assets_transfer/ku/v_assets_transfer_summary_view', $this->data, true);
						} else {
							$template = $this->load->view('assets_transfer/v_assets_transfer_summary_view', $this->data, true);
						}

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

	public function re_print_transfer()
	{
		$id = $this->input->post('id');

		$print_report = '';
		$this->data = array();

		if (ORGANIZATION_NAME == 'KU' || ORGANIZATION_NAME=='ARMY') {
			// $assetid=$this->input->post('assetid');
			// $transfer_type = $this->input->post('astm_transfertypeid');

			// $this->data['assets_data'] = $this->assets_mdl->get_all_assets();
			$this->data['transfer_data'] = $this->assets_transfer_mdl->get_assets_transfer_detail_data_ku(array('tm.astm_assettransfermasterid' => $id));
			// echo "<pre>";
			// print_r($this->data);
			// die();
			$print_report = $this->load->view('assets_transfer/' . REPORT_SUFFIX . '/v_asset_transfer_print', $this->data, true);
		}

		print_r(json_encode(array('status' => 'success', 'message' => 'Record Save Successfully.', 'tempform' => $print_report)));

		exit;
	}

	public function detail()

	{

		$this->data['department_list'] = $this->general->get_tbl_data('*', 'dept_department', array('dept_isactive' => 'Y'));
		$locationid = $this->session->userdata(LOCATION_ID);
		$this->data['locationid'] = $locationid;

		$this->data['breadcrumb'] = 'Assets Transfer Detail';

		$this->data['tab_type'] = "transfer_detail";

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

		$this->page_title = 'Assets Transfer Detail';

		$this->template

			->set_layout('general')

			->enable_parser(FALSE)

			->title($this->page_title)

			->build('assets_transfer/v_assets_transfer_common', $this->data);
	}

	public function get_assets_transfer_detail_list()
	{

		if (MODULES_VIEW == 'N') {

			$array = array();

			echo json_encode(array("recordsFiltered" => 0, "recordsTotal" => 0, "data" => $array));

			exit;
		}

		$useraccess = $this->session->userdata(USER_ACCESS_TYPE);

		$i = 0;

		if (ORGANIZATION_NAME == 'KU') {
			$data = $this->assets_transfer_mdl->get_detail_list_of_assets_transfer_ku();
		} else {
			$data = $this->assets_transfer_mdl->get_detail_list_of_assets_transfer();
		}

		// echo "<pre>";

		// print_r($data);

		// die();

		$array = array();

		$filtereddata = ($data["totalfilteredrecs"] > 0 ? $data["totalfilteredrecs"] : $data["totalrecs"]);

		$totalrecs = $data["totalrecs"];

		unset($data["totalfilteredrecs"]);

		unset($data["totalrecs"]);

		foreach ($data as $row) {
			if (ORGANIZATION_NAME == 'KU') {
				$fromschool = $row->fromschoolname;
				$fromdepparent = $row->fromdepparent;
				$fromdep = $row->fromdep;
				if (!empty($fromdepparent)) {
					$from_departmentname = $fromdepparent . '/' . $fromdep;
				} else {
					$from_departmentname = $fromdep;
				}
				$array[$i]['from'] = $fromschool . '-' . $from_departmentname;

				$toschoolname = $row->toschoolname;
				$todep = $row->todep;
				$todepparent = $row->todepparent;
				if (!empty($todepparent)) {
					$to_departmentname = $todepparent . '/' . $todep;
				} else {
					$to_departmentname = $todep;
				}

				$array[$i]['to'] = $toschoolname . '-' . $to_departmentname;
				$array[$i]['itemname'] = $row->itli_itemname;
				$array[$i]['received_by'] = $row->astm_receivedby;
				$array[$i]['previous_staffname'] = $row->astd_prev_staffname;

				$array[$i]['astd_remark'] = $row->astd_remark;
			} else {

				$transfertype = $row->astm_transfertypeid;

				if ($transfertype == 'D') {

					$array[$i]['transfertype'] = 'Department';

					$array[$i]['from'] = $row->fromdep;

					$array[$i]['to'] = $row->todep;
				}

				if ($transfertype == 'B') {

					$array[$i]['transfertype'] = 'Branch';

					$array[$i]['from'] = $row->fromlocation;

					$array[$i]['to'] = $row->tolocation;
				}
			}

			$array[$i]['astm_transferdatead'] = $row->astm_transferdatead;
			$array[$i]['astm_transferdatebs'] = $row->astm_transferdatebs;
			$array[$i]['astm_transferno'] = $row->astm_transferno;
			$array[$i]['astd_assetsid'] = $row->asen_assetcode;
			$array[$i]['astd_assetsdesc'] = $row->astd_assetsdesc;
			$array[$i]['astd_originalamt'] = $row->astd_originalamt;
			$array[$i]['astd_currentamt'] = $row->astd_currentamt;
			$i++;
		}

		$get = $_GET;

		echo json_encode(array("recordsFiltered" => $filtereddata, "recordsTotal" => $totalrecs, "data" => $array));
	}

	public function bulk_transfer(){
		$locationid = $this->session->userdata(LOCATION_ID);
		$this->data['fiscal_year'] = $this->general->get_tbl_data('*', 'fiye_fiscalyear', false, 'fiye_fiscalyear_id', 'DESC', 2);

		$this->data['department_list'] = $this->general->get_tbl_data('*', 'dept_department', array('dept_isactive' => 'Y', 'dept_locationid' => $locationid));

		// $this->data['department_list']= '';

		$this->data['location_list'] = $this->general->get_tbl_data('*', 'loca_location', false);
		
		$this->data['tab_type'] = "transfer_bulk";

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

			$this->data['breadcrumb'] = 'Bulk Transfer of Assets';

			$this->template

				->set_layout('general')

				->enable_parser(FALSE)

				->title($this->page_title)

				->build('assets_transfer/v_assets_transfer_common', $this->data);
		}

		public function search_assets_record_branch_department(){
			$locationid = $this->session->userdata(LOCATION_ID);
			$astm_transfertypeid= $this->input->post('astm_transfertypeid');
			$schoolid=$this->input->post('schoolid');
				if(empty($schoolid)){
		            print_r(json_encode(array('status'=>'success','template'=>'<span class="text-danger alert">Scholl Field is required</span>','message'=>'Selected')));

		            exit; 
		        }
		      
				$depid=$this->input->post('depid');
		        if(empty($depid)){
		            print_r(json_encode(array('status'=>'success','template'=>'<span class="text-danger alert">Department Field is required</span>','message'=>'Selected')));
		            exit; 
		        }
		      
		      	$sub_department=$this->input->post('subdepid');
		      
		      		$_POST['limit']=800;

		         $data = $this->assets_mdl->get_all_assets_list_ku();
		         // echo $this->db->last_query();
		         // die();
		         // print_r($data);
		         // die();
		         unset($data["totalfilteredrecs"]);
		         unset($data["totalrecs"]);
		         $currentfyrs = CUR_FISCALYEAR;
		         $this->data['astm_transfertypeid']=$astm_transfertypeid;
		          $this->data['fromlocation']=$schoolid;
					$this->data['fromdepartment']=$depid;
					$this->data['fromsubdepid']=$sub_department;

		$cur_fiscalyrs_transferno = $this->db->select('astm_transferno,astm_fiscalyrs')

			->from('astm_assettransfermaster')

			->where('astm_locationid', $schoolid)

			// ->where('prin_fiscalyrs',$currentfyrs)

			->order_by('astm_fiscalyrs', 'DESC')

			->limit(1)

			->get()->row();

		// echo "<pre>";

		// print_r($cur_fiscalyrs_transferno);

		// die();

		if (!empty($cur_fiscalyrs_transferno)) {

			$transfer_format = $cur_fiscalyrs_transferno->astm_transferno;

			$transfer_string = str_split($transfer_format);

			// echo "<pre>";

			// print_r($transfer_string);

			// die();

			$transfer_prefix_len = strlen(ASSETS_TRANSFER_CODE_NO_PREFIX);

			$chk_first_string_after_transfer_prefix = $transfer_string[$transfer_prefix_len];

			// echo $chk_first_string_after_transfer_prefix;

			// die();

			if ($chk_first_string_after_transfer_prefix == '0') {

				$transfer_no_prefix = ASSETS_TRANSFER_CODE_NO_PREFIX . CUR_FISCALYEAR;
			} else if ($cur_fiscalyrs_transferno->prin_fiscalyrs == $currentfyrs && $chk_first_string_after_transfer_prefix == '0') {

				$transfer_no_prefix = ASSETS_TRANSFER_CODE_NO_PREFIX . CUR_FISCALYEAR;
			} else if ($cur_fiscalyrs_transferno->prin_fiscalyrs != $currentfyrs && $chk_first_string_after_transfer_prefix == '0') {

				$transfer_no_prefix = ASSETS_TRANSFER_CODE_NO_PREFIX . CUR_FISCALYEAR;
			} else if ($cur_fiscalyrs_transferno->prin_fiscalyrs != $currentfyrs && $chk_first_string_after_transfer_prefix != '0') {

				$transfer_no_prefix = ASSETS_TRANSFER_CODE_NO_PREFIX . CUR_FISCALYEAR;
			} else {

				$transfer_no_prefix = ASSETS_TRANSFER_CODE_NO_PREFIX;
			}
		} else {

			$transfer_no_prefix = ASSETS_TRANSFER_CODE_NO_PREFIX . CUR_FISCALYEAR;
		}

		// die();

		$this->data['transfer_code'] = $this->general->generate_invoiceno('astm_transferno', 'astm_transferno', 'astm_assettransfermaster', $transfer_no_prefix, ASSETS_TRANSFER_CODE_NO_LENGTH, false, 'astm_locationid');

		$this->data['fiscal_year'] = $this->general->get_tbl_data('*', 'fiye_fiscalyear', false, 'fiye_fiscalyear_id', 'DESC', 1);
		
		$this->data['department_list'] = $this->general->get_tbl_data('*', 'dept_department', array('dept_isactive' => 'Y', 'dept_locationid' => $locationid));
		// echo "<pre>";
		// print_r($this->data['department_list']);
		// die();

		$this->data['staff_list'] = $this->general->get_tbl_data('*', 'stin_staffinfo');

		         $this->data['staff_assets_record']=$data;

		         $tempform= $this->load->view('assets_transfer/ku/v_assets_record_list_ready_bulk_transfer',$this->data,true);
		          print_r(json_encode(array('status'=>'success','template'=>$tempform,'message'=>'Selected')));

            exit; 

		}

public function save_bulk_transfer($print = false){
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			try {
				$this->form_validation->set_rules($this->assets_transfer_mdl->validate_settings_transfer_assets);
				if ($this->form_validation->run() == TRUE) {

					$trans = $this->assets_transfer_mdl->save_assets_transfer_data_bulk();

					if ($trans) {
						$template = '';

						if ($print == "print") {
							if (ORGANIZATION_NAME == 'KU' || ORGANIZATION_NAME == 'ARMY' ) {
							$this->data['transfer_details']=$this->assets_transfer_mdl->get_assets_transfer_detail_data_ku(array('astm_assettransfermasterid'=>$trans));
						 	$this->data['report_title']='Bulk Assets Transfer Record';
        					$template = $this->load->view('assets_transfer/ku/v_bulk_assets_transfer_print', $this->data, true);
							}else{
							$this->data['transfer_details']=$this->assets_transfer_mdl->get_assets_transfer_detail_data(array('astm_assettransfermasterid'=>$trans));
        					$this->data['report_title']='Bulk Assets Transfer Record';
        					$template = $this->load->view('assets_transfer/v_bulk_assets_transfer_print', $this->data, true);
							}
							print_r(json_encode(array('status' => 'success', 'message' => 'Record Save Successfully.', 'print_report' => $template)));

							exit;
						}

						print_r(json_encode(array('status' => 'success', 'message' => 'Record Save Successfully.')));

						exit;
					}else{
						print_r(json_encode(array('status' => 'error', 'message' => 'Operation Fail !!')));
						exit;
					}

				} else {

					print_r(json_encode(array('status' => 'error', 'message' => validation_errors())));

					exit;
				}
			}
			catch (Exception $e) {

				print_r(json_encode(array('status' => 'error', 'message' => $e->getMessage())));
				exit;
			}
	}
	else {

			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));

			exit;
		}

}

	public function save_asset_transfer($print = false)
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

				// echo "test";

				// die();

				if (ORGANIZATION_NAME == 'KU'  || ORGANIZATION_NAME == 'ARMY' ) {
					$fromdepid = $this->input->post('fromdepid');
					$todepid = $this->input->post('todepid');
					$from_schoolid = $this->input->post('from_schoolid');
					$to_schoolid = $this->input->post('to_schoolid');
					$from_subdepid = $this->input->post('from_subdepid');
					$to_subdepid = $this->input->post('to_subdepid');
					//         if($from_schoolid==$to_schoolid && $from_subdepid==$to_subdepid){
					//         	print_r(json_encode(array('status'=>'error','message'=>'Could not transfer to same department')));

					// exit;
					//         }

					//         $check_parentfromdep=$this->general->get_tbl_data('dept_depid,dept_parentdepid','dept_department',array('dept_depid'=>$fromdepid),'dept_depname','ASC');
					//         if(!empty($check_parentfromdep) && empty($from_subdepid)){
					//         	print_r(json_encode(array('status'=>'error','message'=>'You need to select from Sub Department')));

					// 	exit;
					//         }

					//          $check_parenttodep=$this->general->get_tbl_data('dept_depid,dept_parentdepid','dept_department',array('dept_depid'=>$todepid),'dept_depname','ASC');
					//         if(!empty($check_parenttodep)  && empty($to_subdepid)){
					//         	print_r(json_encode(array('status'=>'error','message'=>'You need to select to Sub Department')));

					// 	exit;
					//         }

				}

				// die();

				$this->form_validation->set_rules($this->assets_transfer_mdl->validate_settings_transfer_assets);

				if ($this->form_validation->run() == TRUE) {

					// echo "<pre>"; print_r($this->input->post());die;

					$trans = $this->assets_transfer_mdl->save_assets_transfer_data();

					if ($trans) {

						if ($print == "print") {

							$print_report = '';
							$this->data = array();

							if (ORGANIZATION_NAME == 'KU'  || ORGANIZATION_NAME == 'ARMY' ) {
								// $assetid=$this->input->post('assetid');
								// $transfer_type = $this->input->post('astm_transfertypeid');

								// $this->data['assets_data'] = $this->assets_mdl->get_all_assets();
								$this->data['transfer_data'] = $this->assets_transfer_mdl->get_assets_transfer_detail_data(array('tm.astm_assettransfermasterid' => $trans));
								// print_r($this->data);
								// die();
								$print_report = $this->load->view('assets_transfer/' . REPORT_SUFFIX . '/v_asset_transfer_print', $this->data, true);
							}

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

	public function list_asset_transfer_detail()
	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$this->data['asset_transfer_detail_all'] = $this->assets_transfer_mdl->get_all_asset_transfer_detail();

			$template = $this->load->view('assets_transfer/v_assets_transfer_detail_list', $this->data, true);

			print_r(json_encode(array('status' => 'success', 'message' => 'Successfully Selected!!', 'template' => $template)));

			exit;
		} else {

			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));

			exit;
		}
	}

	public function generate_pdfDirect()

	{

		//$this->data['searchResult'] = $this->assets_transfer_mdl->get_detail_list_of_assets_transfer();

		if (ORGANIZATION_NAME == 'KU'  || ORGANIZATION_NAME == 'ARMY' ) {
			$this->data['searchResult'] = $this->assets_transfer_mdl->get_detail_list_of_assets_transfer_ku();
		} else {
			$this->data['searchResult'] = $this->assets_transfer_mdl->get_detail_list_of_assets_transfer();
		}

		// echo "<pre>";

		// print_r( $this->data['searchResult']);

		// die();

		unset($this->data['searchResult']['totalfilteredrecs']);

		unset($this->data['searchResult']['totalrecs']);

		if (ORGANIZATION_NAME == 'KU'  || ORGANIZATION_NAME == 'ARMY' ) {

			$html = $this->load->view('assets_transfer/ku/v_asset_transfer_detail_download', $this->data, true);
		} else {

			$html = $this->load->view('assets_transfer/v_asset_transfer_detail_download', $this->data, true);
		}

		$filename = 'direct_purchase_' . date('Y_m_d_H_i_s') . '_.pdf';

		$pdfsize = 'A4-L'; //A4-L for landscape

		//if save and download with default filename, send $filename as parameter

		$this->general->generate_pdf($html, false, $pdfsize);

		exit();
	}

	public function exportToExcelDirect()

	{

		header("Content-Type: application/xls");

		header("Content-Disposition: attachment; filename=assets_list" . date('Y_m_d_H_i') . ".xls");

		header("Pragma: no-cache");

		header("Expires: 0");

		$data = $this->assets_transfer_mdl->get_detail_list_of_assets_transfer();

		$this->data['searchResult'] = $this->assets_transfer_mdl->get_detail_list_of_assets_transfer();

		$array = array();

		unset($this->data['searchResult']['totalfilteredrecs']);

		unset($this->data['searchResult']['totalrecs']);

		$response = $this->load->view('assets_transfer/v_asset_transfer_detail_download', $this->data, true);

		echo $response;
	}

	public function list_asset_transfer_summary()
	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$this->data['asset_transfer_summary_all'] = $this->assets_transfer_mdl->get_all_asset_transfer_summary();

			$template = $this->load->view('assets_transfer/v_assets_transfer_summary_list', $this->data, true);

			print_r(json_encode(array('status' => 'success', 'message' => 'Successfully Selected!!', 'template' => $template)));

			exit;
		} else {

			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));

			exit;
		}
	}

	public function generatesummary_pdfDirect()
	{
		if (ORGANIZATION_NAME == 'KU'  || ORGANIZATION_NAME == 'ARMY' ) {
			$this->data['searchResult'] = $this->assets_transfer_mdl->get_summary_list_of_assets_transfer_ku();
		} else {
			$this->data['searchResult'] = $this->assets_transfer_mdl->get_summary_list_of_assets_transfer();
		}

		// echo "<pre>";

		// print_r( $this->data['searchResult']);

		// die();

		unset($this->data['searchResult']['totalfilteredrecs']);

		unset($this->data['searchResult']['totalrecs']);

		if (ORGANIZATION_NAME == 'KU'  || ORGANIZATION_NAME == 'ARMY' ) {
			$html = $this->load->view('assets_transfer/ku/v_asset_transfer_summary_download', $this->data, true);
		} else {
			$html = $this->load->view('assets_transfer/v_asset_transfer_summary_download', $this->data, true);
		}

		$filename = 'direct_purchase_' . date('Y_m_d_H_i_s') . '_.pdf';

		$pdfsize = 'A4-L'; //A4-L for landscape

		//if save and download with default filename, send $filename as parameter

		$this->general->generate_pdf($html, false, $pdfsize);

		exit();
	}

	public function exportToExcelDirectSummary()

	{

		header("Content-Type: application/xls");

		header("Content-Disposition: attachment; filename=assets_list" . date('Y_m_d_H_i') . ".xls");

		header("Pragma: no-cache");

		header("Expires: 0");

		$data = $this->assets_transfer_mdl->get_summary_list_of_assets_transfer();

		$this->data['searchResult'] = $this->assets_transfer_mdl->get_summary_list_of_assets_transfer();

		$array = array();

		unset($this->data['searchResult']['totalfilteredrecs']);

		unset($this->data['searchResult']['totalrecs']);

		$response = $this->load->view('assets_transfer/v_asset_transfer_summary_download', $this->data, true);

		echo $response;
	}

	public function correction()
	{
		$this->data['breadcrumb'] = 'Assets Transfer Correction';
		$this->data['tab_type'] = "correction";
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

		$this->page_title = 'Assets Transfer Summary';

		$this->template

			->set_layout('general')

			->enable_parser(FALSE)

			->title($this->page_title)

			->build('assets_transfer/v_assets_transfer_common', $this->data);
	}

	public function get_transfer_assets_form_edit()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$astm_transferno = $this->input->post('transfer_no');
			if(!empty($astm_transferno)){
			
			if (ORGANIZATION_NAME == 'KU'  || ORGANIZATION_NAME == 'ARMY' ) {
				$this->data['assets_transfer_master'] = $this->assets_transfer_mdl->get_assets_transfer_detail_data_ku(array('tm.astm_transferno' => $astm_transferno));
			} else {
				$this->data['assets_transfer_master'] = $this->assets_transfer_mdl->get_assets_transfer_detail_data(array('tm.astm_transferno' => $astm_transferno));
			}

			// echo "<pre>";
			// print_r($this->data);
			// die();

			$locationid = $this->session->userdata(LOCATION_ID);

			$currentfyrs = CUR_FISCALYEAR;
			$this->data['fiscal_year'] = $this->general->get_tbl_data('*', 'fiye_fiscalyear', false, 'fiye_fiscalyear_id', 'DESC', 2);
			$this->data['locationid'] = $locationid;
			$this->data['staff_list'] = $this->general->get_tbl_data('*', 'stin_staffinfo');

			$template = '<div class="white-box pad-5 mtop_10 ">';
			if ( !empty($this->data['assets_transfer_master'])) {
				if (ORGANIZATION_NAME == 'KU'  || ORGANIZATION_NAME == 'ARMY' ) {

				$this->data['transfer_data'] = $this->assets_transfer_mdl->get_assets_transfer_detail_data(array('tm.astm_transferno' => $astm_transferno));
					$template .= $this->load->view('assets_transfer/ku/v_transfer_assets_form_edit', $this->data, true);
				} else {
					$template .= $this->load->view('assets_transfer/v_transfer_assets_form_edit', $this->data, true);
				}
			}else{
				print_r(json_encode(array('status' => 'error', 'message' => 'No Data Found')));
				exit;
			}
			$template .= '</div>';
			print_r(json_encode(array('status' => 'success', 'message' => '', 'tempform' => $template)));
			exit;
			} else {
				print_r(json_encode(array('status' => 'error', 'message' => 'Invoice No. Not Found')));
			exit;
			} 
		}
		else {
			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		}
	}

	public function cancel_asset_transfer()
	{
		// print_r($this->input->post());
		// die();
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$trans = $this->assets_transfer_mdl->cancel_asset_transfer();
			if ($trans) {

				print_r(json_encode(array('status' => 'success', 'message' => 'Asset Transfer Cancelled Successfully.')));

				exit;
			} else {

				print_r(json_encode(array('status' => 'error', 'message' => 'Unsuccessful Operation.')));

				exit;
			}

		}else{

			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		}
	}

}