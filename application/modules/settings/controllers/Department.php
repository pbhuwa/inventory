<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Department extends CI_Controller
{
	function __construct()
	{
		$this->insert = '';
		parent::__construct();
		$this->load->Model('department_mdl');
		$this->useraccess = $this->session->userdata(USER_ACCESS_TYPE);
		// $orgid = $this->session->userdata(ORG_ID);
		$this->locationid = $this->session->userdata(LOCATION_ID);
		$this->location_ismain = $this->session->userdata(ISMAIN_LOCATION);


		// echo 'NSA'.MODULES_INSERT;
		// die();
		// $this->insert=MODULES_INSERT;
		// $per=new General();
		// $per->menu_permission;
		// print_r($per->menu_permission);
		// die();
		// $currenturl=$this->general->getUrl();
		// $new_url=str_replace(base_url(),"",$currenturl);
		// $urlchk= '/'.$new_url;
		// $this->menu_permission= $this->general->check_menu_permission($urlchk);
		// echo $this->db->last_query();
		// print_r($this->menu_permission);
		// die();
		// echo $_SERVER['HTTP_REFERER'];
		// die();

	}

	public function index()
	{
		// echo "<pre>";
		// print_r($this->data['department_list']);
		// die();
		// print_r($this->session->all_userdata());
		// die();
		// echo $this->location_ismain;
		// die();

		// echo $this->db->last_query();
		// die();
		$this->data['department_all'] = $this->department_mdl->get_all_department(array('dept_locationid' => $this->locationid));
		$this->data['departments'] = $this->department_mdl->get_all_department_with_subdepartments();


		if ($this->location_ismain == 'Y') {
			$this->data['location_all'] = $this->general->get_tbl_data('*', 'loca_location', false, 'loca_locationid', 'ASC');
		} else {
			$this->data['location_all'] = $this->general->get_tbl_data('*', 'loca_location', array('loca_locationid' => $this->locationid), 'loca_locationid', 'ASC');
			// $this->data['department_all'] = $this->department_mdl->get_all_department(array('dept_locationid' => $this->locationid));
		}

		$this->data['department_type'] = $this->department_mdl->get_all_departmenttype(array('dt.dety_isactive' => 'Y'));
		$this->data['editurl'] = base_url() . 'settings/department/editdepartment';
		$this->data['deleteurl'] = base_url() . 'settings/department/deletedepartment';
		$this->data['listurl'] = base_url() . 'settings/department/listdepartment';
		$this->data['location_ismain'] = $this->location_ismain;
		$this->data['current_location'] = $this->locationid;
		$this->data['modal'] = '';


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
			->build('department/v_department', $this->data);
	}

	public function form_department()
	{
		$this->useraccess = $this->session->userdata(USER_ACCESS_TYPE);
		// $orgid = $this->session->userdata(ORG_ID);
		$this->locationid = $this->session->userdata(LOCATION_ID);
		$this->location_ismain = $this->session->userdata(ISMAIN_LOCATION);

		if ($this->location_ismain == 'Y') {
			$this->data['department_all'] = $this->department_mdl->get_all_department();
			$this->data['location_all'] = $this->general->get_tbl_data('*', 'loca_location', false, 'loca_locationid', 'ASC');
		} else {
			$this->data['department_all'] = $this->department_mdl->get_all_department(array('dept_locationid' => $this->locationid));
			$this->data['location_all'] = $this->general->get_tbl_data('*', 'loca_location', array('loca_locationid' => $this->locationid), 'loca_locationid', 'ASC');
		}


		$this->data['department_type'] = $this->department_mdl->get_all_departmenttype(array('dt.dety_isactive' => 'Y'));
		$this->data['location_ismain'] = $this->location_ismain;
		$this->data['current_location'] = $this->locationid;
		$this->load->view('department/v_departmentform', $this->data);
	}

	public function listdepartment()
	{
		if (MODULES_VIEW == 'N') {
			$this->general->permission_denial_message();
			exit;
		}

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$this->locationid = $this->session->userdata(LOCATION_ID);
			$this->location_ismain = $this->session->userdata(ISMAIN_LOCATION);
			// echo $this->location_ismain;
			if ($this->location_ismain == 'Y') {
				$this->data['department_all'] = $this->department_mdl->get_all_department();
			} else {
				$this->data['department_all'] = $this->department_mdl->get_all_department(array('dept_locationid' => $this->locationid));
			}
			$this->data['departments'] = $this->department_mdl->get_all_department_with_subdepartments();


			$template = $this->load->view('department/v_department_list', $this->data, true);
			print_r(json_encode(array('status' => 'success', 'message' => 'Successfully Selected!!', 'template' => $template)));
			exit;
		} else {
			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		}
	}


	public function save_department()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
			try {
				// echo MODULES_INSERT;
				// die();
				$id = $this->input->post('id');
				// echo "<prev>";
				// print_r($id);
				// die();
				if ($id) {
					$data['dept_data'] = $this->department_mdl->get_all_department(array('dp.dept_depid' => $id));
					// echo "<pre>";
					// print_r($data['dept_data']);
					// die();
					if ($data['dept_data']) {
						$dep_date = $data['dept_data'][0]->dept_postdatead;
						$dep_time = $data['dept_data'][0]->dept_posttime;
						$editstatus = $this->general->compute_data_for_edit($dep_date, $dep_time);
						$usergroup = $this->session->userdata(USER_GROUPCODE);

						if ($editstatus == 0 && $usergroup != 'SA') {
							$this->general->disabled_edit_message();
						}
					}
				}



				// $this->mope_update
				// $this->mope_delete
				// $this->mope_view
				$this->form_validation->set_rules($this->department_mdl->validate_settings_department);
				// $this->department_mdl->validate_settings_department();
				if ($this->form_validation->run() == TRUE) {

					$trans = $this->department_mdl->department_save();
					if ($trans) {
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
	public function save_country()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

			try {
				$this->form_validation->set_rules($this->department_mdl->validate_settings_country);
				// $this->department_mdl->validate_settings_department();
				if ($this->form_validation->run() == TRUE) {

					$trans = $this->department_mdl->country_save();
					if ($trans) {
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

	public function editdepartment()
	{
		if (MODULES_UPDATE == 'N') {
			$this->general->permission_denial_message();
			exit;
		}

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {


			$id = $this->input->post('id');

			if ($this->location_ismain == 'Y') {
				$this->data['location_all'] = $this->general->get_tbl_data('*', 'loca_location', false, 'loca_locationid', 'ASC');
				$this->data['department_all'] = $this->department_mdl->get_all_department(array('dept_locationid' => $this->locationid));
			} else {
				$this->data['department_all'] = $this->department_mdl->get_all_department(array('dept_locationid' => $this->locationid));
				$this->data['location_all'] = $this->general->get_tbl_data('*', 'loca_location', array('loca_locationid' => $this->locationid), 'loca_locationid', 'ASC');
			}



			$this->data['department_type'] = $this->department_mdl->get_all_departmenttype(array('dt.dety_isactive' => 'Y'));
			$this->data['dept_data'] = $this->department_mdl->get_all_department(array('dp.dept_depid' => $id));
			// echo "<pre>";
			// print_r($this->data['dept_data']);
			// die();
			$this->data['location_ismain'] = $this->location_ismain;
			$this->data['current_location'] = $this->locationid;
			if ($this->data['dept_data']) {
				$dep_date = $this->data['dept_data'][0]->dept_postdatead;
				$dep_time = $this->data['dept_data'][0]->dept_posttime;
				$editstatus = $this->general->compute_data_for_edit($dep_date, $dep_time);
				// echo $editstatus;
				// die();
				$this->data['edit_status'] = $editstatus;
			}
			$tempform = $this->load->view('department/v_departmentform', $this->data, true);
			// echo $tempform;
			// die();
			if (!empty($this->data['dept_data'])) {
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

	public function deletedepartment()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if (MODULES_DELETE == 'N') {
				$this->general->permission_denial_message();
				exit;
			}
			$id = $this->input->post('id');
			$trans = $this->department_mdl->remove_department();
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


	public function exists_departcode()
	{
		$dept_depcode = $this->input->post('dept_depcode');
		$id = $this->input->post('id');
		$depcode = $this->department_mdl->check_exit_deptcode_for_other($dept_depcode, $id);
		// print_r($depcode);
		// die();
		// echo $this->db->last_query();
		// die();
		if ($depcode) {
			$this->form_validation->set_message('exists_departcode', 'Already Exist Dep.code!!');
			return false;
		} else {
			return true;
		}
	}

	public function exists_departname()
	{
		$dept_depname = $this->input->post('dept_depname');
		$id = $this->input->post('id');
		$depname = $this->department_mdl->check_exit_deptname_for_other($dept_depname, $id);
		if ($depname) {

			$this->form_validation->set_message('exists_departname', 'Already Exist Dep.name!!');
			return false;
		} else {
			return true;
		}
	}


	public function exists_countrycode()
	{
		$coun_countrycode = $this->input->post('coun_countrycode');
		$id = $this->input->post('id');
		$depcode = $this->department_mdl->check_exit_countrycode_for_other($coun_countrycode, $id);
		// print_r($depcode);
		// die();
		// echo $this->db->last_query();
		// die();
		if ($depcode) {
			$this->form_validation->set_message('exists_countrycode', 'Already Exist Country Code!!');
			return false;
		} else {
			return true;
		}
	}

	public function exists_countryname()
	{
		$coun_countryname = $this->input->post('coun_countryname');
		$id = $this->input->post('id');
		$depname = $this->department_mdl->check_exit_countname_for_other($coun_countryname, $id);
		if ($depname) {

			$this->form_validation->set_message('exists_countryname', 'Already Exist Country Name!!');
			return false;
		} else {
			return true;
		}
	}

	public function get_country()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {


			$this->data['country_list'] = $this->department_mdl->get_all_country();
			// echo $this->db->last_query();
			// die();
			// echo "<pre>";
			// print_r($this->data['country_list']);die;
			echo json_encode($this->data['country_list']);
		} else {
			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		}
	}
	public function department_entry($modal = false)
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if ($this->location_ismain == 'Y') {
				$this->data['department_all'] = $this->department_mdl->get_all_department();
				$this->data['location_all'] = $this->general->get_tbl_data('*', 'loca_location', false, 'loca_locationid', 'ASC');
			} else {
				$this->data['department_all'] = $this->department_mdl->get_all_department(array('dept_locationid' => $this->locationid));
				// echo $this->db->last_query();
				// die();
				$this->data['location_all'] = $this->general->get_tbl_data('*', 'loca_location', array('loca_locationid' => $this->locationid), 'loca_locationid', 'ASC');
			}


			$this->data['department_type'] = $this->department_mdl->get_all_departmenttype(array('dt.dety_isactive' => 'Y'));

			// $this->data['department_all']='';
			$this->data['editurl'] = base_url() . 'settings/department/editdepartment';
			$this->data['deleteurl'] = base_url() . 'settings/department/deletedepartment';
			$this->data['listurl'] = base_url() . 'settings/department/listdepartment';
			$this->data['location_ismain'] = $this->location_ismain;
			$this->data['current_location'] = $this->locationid;

			// echo '<pre>'; print_r($this->data['distributor_list']); die();
			//for item entry from popup
			$this->data['modal'] = $modal;
			$template = '';
			$template = $this->load->view('department/v_departmentform', $this->data, true);
			print_r(json_encode(array('status' => 'success', 'message' => 'Successfully Selected!!', 'template' => $template, 'tempform' => $template)));
			exit;
		} else {
			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		}
	}

	public function department_reload()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$department = $this->department_mdl->get_all_department(false, false, false, 'dept_depname', 'ASC');
			$tempform = '';

			if ($department) :

				foreach ($department as $ku => $dep) :
					//
					$tempform .= '<option value="' . $dep->dept_depid . '">' . $dep->dept_depname . '</option>';

				endforeach;
			endif;

			echo json_encode($tempform);
		} else {
			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */