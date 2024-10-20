<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api_purchase extends CI_Controller {

	function __construct() {
		parent::__construct();
			$this->load->model('api_purchase_mdl');
	}
	public function index()
	{
		
	}
	public function purchase_information()
	{
		$purchase_quotation_list=$this->api_purchase_mdl->get_purchase_details_db();	
		// echo "<pre>";
		// print_r($purchase_quotation_list);
		// die();
		//print_r(array_change_key_case($staff_pos_list,CASE_LOWER));
		$this->db->insert_batch('qude_quotationdetail',$purchase_quotation_list);
	}

	public function purchase_master()
	{
		$purchase_master_list=$this->api_purchase_mdl->get_purchase_master_db();	
		// echo "<pre>";
		// print_r($purchase_master_list);
		// die();
		// print_r(array_change_key_case($staff_pos_list,CASE_LOWER));
		$this->db->insert_batch('quma_quotationmaster',$purchase_master_list);
	}
	public function requisition_note()
	{	
		$requisition_note_list=$this->api_purchase_mdl->get_requisition_note_db();	
		// echo "<pre>";
		// print_r($requisition_note_list);
		// die();
		// print_r(array_change_key_case($staff_pos_list,CASE_LOWER));
		$this->db->insert_batch('reno_requisitionnote',$requisition_note_list);
		
	}
	public function requisition_details_note()
	{	
		$note_details_list=$this->api_purchase_mdl->get_requisition_note_details_db();	
		// echo "<pre>";
		// print_r($staff_info_list);
		// die();
		// print_r(array_change_key_case($staff_pos_list,CASE_LOWER));
		$this->db->insert_batch('redt_reqdetailnote',$note_details_list);
		
	}
	public function return_master()
	{	
		$return_master_list=$this->api_purchase_mdl->get_return_master_db();	
		// echo "<pre>";
		// print_r($return_master_list);
		// die();
		// print_r(array_change_key_case($staff_pos_list,CASE_LOWER));
		$this->db->insert_batch('rema_returnmaster',$return_master_list);
		
	}

	public function return_detail()
	{	
		$return_detail_list=$this->api_purchase_mdl->get_return_detail_db();	
		// echo "<pre>";
		// print_r($return_detail_list);
		// die();
		// print_r(array_change_key_case($staff_pos_list,CASE_LOWER));
		$this->db->insert_batch('rede_returndetail',$return_detail_list);
		
	}
	

	public function chalan_master()
	{	
		$chalan_master_list=$this->api_purchase_mdl->get_chalan_master_db();	
		// echo "<pre>";
		// print_r($chalan_master_list);
		// die();
		// print_r(array_change_key_case($staff_pos_list,CASE_LOWER));
		$this->db->insert_batch('chde_challandetails',$chalan_master_list);
		
	}


	public function purchase_return_detail()
	{
		$purchase_return_detail_list=$this->api_purchase_mdl->get_purchase_return_detail_db();	
		// echo "<pre>";
		// print_r($purchase_master_list);
		// die();
		// print_r(array_change_key_case($staff_pos_list,CASE_LOWER));
		$this->db->insert_batch('prde_purchasereturndetail',$purchase_return_detail_list);
	}


	public function purchase_order_detail()
	{
		$purchase_order_detail_list=$this->api_purchase_mdl->get_purchase_order_detail_db();	
		// echo "<pre>";
		// print_r($purchase_master_list);
		// die();
		// print_r(array_change_key_case($staff_pos_list,CASE_LOWER));
		$this->db->insert_batch('pude_purchaseorderdetail',$purchase_order_detail_list);
	}


	public function purchase_order_master()
	{
		$purchase_order_master_list=$this->api_purchase_mdl->get_purchase_order_master_db();	
		// echo "<pre>";
		// print_r($purchase_master_list);
		// die();
		// print_r(array_change_key_case($staff_pos_list,CASE_LOWER));
		$this->db->insert_batch('puor_purchaseordermaster',$purchase_order_master_list);
	}

public function purchase_return()
	{
		$purchase_return_list=$this->api_purchase_mdl->get_purchase_return_db();	
		// echo "<pre>";
		// print_r($purchase_return_list);
		// die();
		// print_r(array_change_key_case($staff_pos_list,CASE_LOWER));
		$this->db->insert_batch('purr_purchasereturn',$purchase_return_list);
	}

public function received_master()
	{
		$received_master_list=$this->api_purchase_mdl->get_received_master_db();	
		// echo "<pre>";
		// print_r($purchase_return_list);
		// die();
		// print_r(array_change_key_case($staff_pos_list,CASE_LOWER));
		$this->db->insert_batch('recm_receivedmaster',$received_master_list);
	}


	public function received_detail()
	{
		$received_detail_list=$this->api_purchase_mdl->get_received_master_db();	
		// echo "<pre>";
		// print_r($purchase_return_list);
		// die();
		// print_r(array_change_key_case($staff_pos_list,CASE_LOWER));
		$this->db->insert_batch('recd_receiveddetail',$received_detail_list);
	}




}
?>