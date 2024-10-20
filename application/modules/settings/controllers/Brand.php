<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Brand extends CI_Controller

{

	function __construct()

	{

		$this->insert = '';

		parent::__construct();

		$this->load->Model('brand_mdl');
	}





	public function index()

	{

		$useraccess = $this->session->userdata(USER_ACCESS_TYPE);

		$orgid = $this->session->userdata(ORG_ID);



		$this->data['brand_all'] = $this->general->get_tbl_data('*', 'bran_brand', false, 'bran_brandid', 'DESC');



		// $this->data['location_all']='';

		$this->data['editurl'] = base_url() . 'settings/brand/editbrand';

		$this->data['deleteurl'] = base_url() . 'settings/brand/deletebrand';

		$this->data['listurl'] = base_url() . 'settings/brand/brandlist';



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

			->build('brand/v_brand', $this->data);
	}



	public function form_brand()

	{

		$this->data['editurl'] = base_url() . 'settings/brand/editbrand';

		$this->data['deleteurl'] = base_url() . 'settings/brand/deletebrand';

		$this->data['listurl'] = base_url() . 'settings/brand/brandlist';

		$this->data['brand_all'] = $this->general->get_tbl_data('*', 'bran_brand', false, 'bran_brandid', 'DESC');

		$this->load->view('brand/v_brandform', $this->data);
	}



	public function brandlist()
	{

		if (MODULES_VIEW == 'N') {

			$this->general->permission_denial_message();

			exit;
		}



		if ($_SERVER['REQUEST_METHOD'] === 'POST') {



			$this->locationid = $this->session->userdata(LOCATION_ID);

			$this->location_ismain = $this->session->userdata(ISMAIN_LOCATION);

			// echo $this->location_ismain;

			// if ($this->location_ismain == 'Y') {

			$this->data['brand_all'] = $this->general->get_tbl_data('*', 'bran_brand', false, 'bran_brandid', 'DESC');
			// } else {

			// 	$this->data['brand_all'] = $this->general->get_tbl_data('*', 'bran_brand', array('bran_locationid' => $this->locationid), 'bran_brandid', 'DESC');
			// }

			$template = $this->load->view('brand/v_brand_list', $this->data, true);

			print_r(json_encode(array('status' => 'success', 'message' => 'Successfully Selected!!', 'template' => $template)));

			exit;
		} else {

			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));

			exit;
		}
	}





	public function save_brand()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			try {



				$id = $this->input->post('id');

				// if($this->input->post('id'))

				// {

				// 	if(MODULES_UPDATE=='N')

				// 	{

				// 	$this->general->permission_denial_message();

				// 	exit;

				// 	}

				// }

				// else

				// {

				// 	if(MODULES_INSERT=='N')

				// 	{

				// 	$this->general->permission_denial_message();

				// 	exit;

				// 	}

				// }

				$this->form_validation->set_rules($this->brand_mdl->validate_settings_brand);



				if ($this->form_validation->run() == TRUE) {



					$trans = $this->brand_mdl->brand_save();

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

	public function editbrand()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$id = $this->input->post('id');

			$this->data['dept_data'] = $this->general->get_tbl_data('*', 'bran_brand', array('bran_brandid' => $id), 'bran_brandid', 'DESC');

			$tempform = $this->load->view('brand/v_brandform', $this->data, true);

			//echo $tempform; die();

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

	public function deletebrand()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			if (MODULES_DELETE == 'N') {

				$this->general->permission_denial_message();

				exit;
			}

			$id = $this->input->post('id');

			$trans = $this->brand_mdl->remove_brand();

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



	public function exists_brand()

	{

		$bran_name = $this->input->post('bran_name');

		$id = $this->input->post('id');

		$bname = $this->brand_mdl->check_exit_brand_for_other($bran_name, $id);

		if ($bname) {



			$this->form_validation->set_message('exists_brand', 'Already Exist Brand Name!!');

			return false;
		} else {

			return true;
		}
	}



	public function exists_brandcode()

	{

		$brand_code = $this->input->post('bran_code');

		$id = $this->input->post('id');

		$bcode = $this->brand_mdl->check_exit_brand_code_for_other($brand_code, $id);

		if ($bcode) {



			$this->form_validation->set_message('exists_brandcode', 'Already Exist Brand Code!!');

			return false;
		} else {

			return true;
		}
	}





	public function brand_popup()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$this->data['is_savelist'] = 'savelist';

			$this->data['editurl'] = base_url() . 'settings/brand/editbrand';

			$this->data['deleteurl'] = base_url() . 'settings/brand/deletebrand';

			$this->data['listurl'] = base_url() . 'settings/brand/listbrand';



			$this->data['equipmnt_brand'] = $this->general->get_tbl_data('*', 'bran_brand', false, 'bran_name', 'ASC');

			$tempform = '';



			$tempform .= $this->load->view('brand/v_brandform', $this->data, true);



			//$tempform .=$this->load->view('brand/v_brand_list',$this->data,true);

			// echo $tempform;

			// die();

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

	public function brand_reload()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$brands = $this->general->get_tbl_data('*', 'bran_brand', false, 'bran_name', 'ASC');

			$tempform = '';



			if ($brands) :



				foreach ($brands as $ku => $brand) :

					//

					$tempform .= '<option value="' . $brand->bran_brandid . '">' . $brand->bran_name . '</option>';



				endforeach;

			endif;



			echo json_encode($tempform);
		} else {

			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));

			exit;
		}
	}
}
