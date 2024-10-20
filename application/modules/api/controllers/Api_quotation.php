<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api_quotation extends CI_Controller {

	function __construct() {
		parent::__construct();
			$this->load->model('api_quotation_mdl');
	}
	
	
	public function index()
	{
		
	}	

	public function quotation_master_list()
	{
		//echo"call";die;
		$quotation_master_list=$this->api_quotation_mdl->get_quotation_master_other_db();	
		// echo "<pre>";
		// print_r($quotation_master_list);
		// die();
		// print_r(array_change_key_case($staff_pos_list,CASE_LOWER));
		$this->db->insert_batch('quma_quotationmaster',$quotation_master_list);
	}


	public function quotation_detail_list()
	{
		//echo"call";die;
		$quotation_detail_list=$this->api_quotation_mdl->get_quotation_detail_other_db();	
		// echo "<pre>";
		// print_r($quotation_detail_list);
		// die();
		// print_r(array_change_key_case($staff_pos_list,CASE_LOWER));
		$this->db->insert_batch('qude_quotationdetail',$quotation_detail_list);
	}


}

	?>