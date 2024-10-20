<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api_stock extends CI_Controller {

	function __construct() {
		parent::__construct();
			$this->load->model('api_stock_mdl');
	}
	
	
	public function index()
	{
		
	}	

	public function stock_detail_list()
	{
		//echo"call";die;
		$stock_detail_list=$this->api_stock_mdl->get_stock_detail_other_db();	
		// echo "<pre>";
		// print_r($supplier_list);
		// die();
		// print_r(array_change_key_case($staff_pos_list,CASE_LOWER));
		$this->db->insert_batch('stde_stockdetail',$stock_detail_list);
	}

	//Sales master Table Data From SALESMASTER =>xw_sama_salesmaster
	
	
	
public function stock_master_list()
	{
		//echo"call";die;
		$stock_master_list=$this->api_stock_mdl->get_stock_master_other_db();	
		// echo "<pre>";
		// print_r($supplier_list);
		// die();
		// print_r(array_change_key_case($staff_pos_list,CASE_LOWER));
		$this->db->insert_batch('stma_stockmaster',$stock_master_list);
	}

public function closing_stock_list()
	{
		//echo"call";die;
		$closing_stock_list=$this->api_stock_mdl->get_closing_stock_other_db();	
		// echo "<pre>";
		// print_r($closing_stock_list);
		// die();
		// print_r(array_change_key_case($staff_pos_list,CASE_LOWER));
		$this->db->insert_batch('csde_closingstockdetail',$closing_stock_list);
	}

public function closing_stock_master_list()
	{
		//echo"call";die;
		$closing_stock_master_list=$this->api_stock_mdl->get_closing_stock_master_other_db();	
		// echo "<pre>";
		// print_r($closing_stock_master_list);
		// die();
		// print_r(array_change_key_case($staff_pos_list,CASE_LOWER));
		$this->db->insert_batch('clsm_closingstockmaster',$closing_stock_master_list);
	}




}

	?>