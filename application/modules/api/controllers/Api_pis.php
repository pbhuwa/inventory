<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api_pis extends CI_Controller {

	function __construct() {
		parent::__construct();
			$this->load->model('api_pis_mdl');
	}
	
	
	public function index()
	{
		
	}	

	public function staff_postion()
	{
		$staff_pos_list=$this->api_pis_mdl->get_staff_postion_other_db();	
		// echo "<pre>";
		// print_r($staff_pos_list);
		// die();
		// print_r(array_change_key_case($staff_pos_list,CASE_LOWER));
		$this->db->insert_batch('stpo_staffposition',$staff_pos_list);
	}

	public function staff_information()
	{
		$staff_info_list=$this->api_pis_mdl->get_staff_information_other_db();	
		// echo "<pre>";
		// print_r($staff_info_list);
		// die();
		// print_r(array_change_key_case($staff_pos_list,CASE_LOWER));
		$this->db->insert_batch('stin_staffinfo',$staff_info_list);
	}




}

	?>