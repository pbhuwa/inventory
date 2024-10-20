<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class File_manager extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->Model('file_manager_mdl');
		$this->locationid = $this->session->userdata(LOCATION_ID);
		$this->location_ismain = $this->session->userdata(ISMAIN_LOCATION);
		$this->load->library('upload');
		$this->load->library('image_lib');
		$this->load->helper('file');
		$this->load->helper('form');
	}
	public function index($reload = false)
	{
		$this->data['file_type'] = $this->general->get_tbl_data('*', 'fity_filetype', array('fity_isactive' => 'Y'));
		if ($reload == 'reload') {
			$this->load->view('file_manager/v_file_manager_form', $this->data);
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

			$this->data['tab_selector'] = 'entry';

			$this->template
				->set_layout('general')
				->enable_parser(FALSE)
				->title($this->page_title)
				// ->build('stock_adjustment/stock_adjustment_main', $this->data);
				->build('file_manager/v_file_manager_main', $this->data);
		}
	}

	public function save_file()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			// var_dump($_POST);
			// die;  
			try {
				$trans = $this->file_manager_mdl->file_save();
				if ($trans) {
					print_r(json_encode(array('status' => 'success', 'message' => 'Record Saved Successfully!!')));
					exit;
				} else {
					print_r(json_encode(array('status' => 'error', 'message' => 'Operation Failed.')));
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

	public function get_file_list()

	{

		if (MODULES_VIEW == 'N') {

			$array = array();


			echo json_encode(array("recordsFiltered" => 0, "recordsTotal" => 0, "data" => $array));

			exit;
		}

		$useraccess = $this->session->userdata(USER_ACCESS_TYPE);

		$orgid = $this->session->userdata(ORG_ID);
		if ($this->location_ismain == 'Y') {
			$data = $this->file_manager_mdl->get_file_list();
		} else {
			$data = $this->file_manager_mdl->get_file_list(array('fire_locationid' => $this->locationid));
		}





		//echo "<pre>";print_r($data);die;



		$i = 0;

		$array = array();

		$filtereddata = ($data["totalfilteredrecs"] > 0 ? $data["totalfilteredrecs"] : $data["totalrecs"]);

		$totalrecs = $data["totalrecs"];



		unset($data["totalfilteredrecs"]);

		unset($data["totalrecs"]);

		//echo "<pre>";print_r($data);die;



		foreach ($data as $row) {



			$array[$i]["fire_filerecordid"] = '<a href="javascript:void(0)" class="patlist" data-patientid=' . $row->fire_filerecordid . '>' . $row->fire_filerecordid . '</a>';



			$array[$i]["fity_typename"] = $row->fity_typename;
			$array[$i]["fire_file_no"] = $row->fire_file_no;
			$array[$i]["fire_datebs"] = $row->fire_datebs;
			$array[$i]["fire_remarks"] = $row->fire_remarks;

			if (MODULES_DELETE == 'Y') {


				$deletebtn = '<a href="javascript:void(0)" data-id=' . $row->fire_filerecordid . ' data-tableid=' . ($i + 1) . ' data-deleteurl=' . base_url('stock_inventory/file_manager/deletedefiles') . ' class="btnDeleteServer"><i class="fa fa-trash-o" aria-hidden="true" ></i></a>';
			} else {
				$deletebtn = '';
			}
			if (MODULES_UPDATE == 'Y') {

				$editbtn = '<a href="javascript:void(0)" data-id=' . $row->fire_filerecordid . ' data-displaydiv="filemanager" data-viewurl=' . base_url('stock_inventory/file_manager/editdefiles') . ' class="btnEdit"><i class="fa fa-edit" aria-hidden="true" ></i></a>';
			} else {
				$editbtn = '';
			}

			// $array[$i]["action"] =$deletebtn.' | '.$editbtn;
			$array[$i]["action"] = $deletebtn . ' ' . $editbtn . '<a href="javascript:void(0)" data-id=' . $row->fire_filerecordid . ' data-displaydiv="Distributer" data-viewurl=' . base_url('stock_inventory/file_manager/view_file') . ' class="view" data-heading=' . $this->lang->line('distributor') . '> <i class="fa fa-eye" aria-hidden="true" ></i></a> ';




			$i++;

			//(object)array('',$row->studentregno,$row->firstname,$row->classsemyear,$row->section,$row->rollno,$row->gender,'');

		}

		//echo "<pre>";print_r($array);die;

		echo json_encode(array("recordsFiltered" => $filtereddata, "recordsTotal" => $totalrecs, "data" => $array));
	}

	public function view_file()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$this->data = array();
			$id = $this->input->post('id');
			$this->data['file_data'] = $this->file_manager_mdl->get_file_list(array('fire_filerecordid' => $id)); 
			//echo "<pre>";print_r($this->data['distributor_data']);die;
			$tempform = $this->load->view('file_manager/v_file_manager_view', $this->data, true);
			if (!empty($tempform)) {
				print_r(json_encode(array('status' => 'success', 'message' => 'You Can view', 'tempform' => $tempform)));
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

	public function deletedefiles()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			if (MODULES_DELETE == 'N') {

				$this->general->permission_denial_message();

				exit;
			}



			$id = $this->input->post('id');





			$trans = $this->file_manager_mdl->remove_files();

			if ($trans) {

				print_r(json_encode(array('status' => 'success', 'message' => 'Successfully Deleted!!')));

				exit;
			} else {

				print_r(json_encode(array('status' => 'error', 'message' => 'Error while deleting!!')));

				exit;
			}
		} else {

			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));

			exit;
		}
	}

	public function editdefiles()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			if (MODULES_UPDATE == 'N') {

				$this->general->permission_denial_message();

				exit;
			}

			$id = $this->input->post('id');
			$this->data['file_type'] = $this->general->get_tbl_data('*', 'fity_filetype', array('fity_isactive' => 'Y'));
			$this->data['file_manager_data'] = $this->general->get_tbl_data('*', 'fire_filerecord', array('fire_filerecordid' => $id), false, 'false');
 
			$this->data['file_manager_detail'] = $this->general->get_tbl_data('*', 'frde_filerecorddetail', array('frde_filerecord_masterid' => $id), false, 'false');

			// echo "<pre>";print_r($this->data['file_manager_data']);die;
			// var_dump($this->data); 
			// die;
			$tempform = $this->load->view('file_manager/v_file_manager_form', $this->data, true);


			if (!empty($this->data['file_manager_data'])) {
				print_r(json_encode(array('status' => 'success', 'message' => 'You Can edit', 'tempform' => $tempform)));
				exit;
			} else {

				print_r(json_encode(array('status' => 'error', 'message' => 'Unable to Edit!!')));

				exit;
			}
		} else {

			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));

			exit;
		}
	}
}
