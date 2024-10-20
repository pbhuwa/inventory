<?php if (!defined('BASEPATH')) exit('No direct script access allowed');



class Common extends CI_Controller
{



	function __construct()
	{

		parent::__construct();

		$this->load->model('Common_mdl');
	}



	public function change_language()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$lang = $this->input->post('language');

			if ($lang == 'np') {

				$this->session->set_userdata('lang', 'np');
			}

			if ($lang == 'en') {

				$this->session->set_userdata('lang', 'en');
			}



			print_r(json_encode(array('status' => 'success', 'message' => 'Language Set successfully')));

			exit;
		} else {

			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));

			exit;
		}
	}



	public function reload_empty()

	{

		echo "";
	}

	public function check_date()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$inp_date = $this->input->post('inp_date');
			if (!empty($inp_date)) {
				if (DEFAULT_DATEPICKER == 'NP') {
					$col_name = 'need_bsdate';
				} else {
					$col_name = 'need_addate';
				}
				$result = $this->db->get_where('need_nepequengdate', array($col_name => $inp_date))->row();
				if (!empty($result)) {
					print_r(json_encode(array('status' => 'success', 'message' => 'valid')));
					exit;
				}
				print_r(json_encode(array('status' => 'error', 'message' => 'invalid')));
				exit;
			}
		} else {

			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		}
	}
}
