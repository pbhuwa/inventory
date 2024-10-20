<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api_purchase_received extends CI_Controller {

	function __construct() {
		parent::__construct();
			$this->load->model('api_purchase_received_mdl');

	}


	public function purchase_requisition_master()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$requisition_master_list=$this->api_purchase_received_mdl->get_purchase_requistion_master();	
		$trans=$this->db->insert_batch('pure_purchaserequisition',$requisition_master_list);
			if($trans)
	        {
	        	  print_r(json_encode(array('status'=>'success','message'=>'Generated Successfully !!')));
	        	exit;
	        }
	        else
	        {
	        	 print_r(json_encode(array('status'=>'error','message'=>'Operation Unsuccessful')));
	        	exit;
	        }
		}
		else
		{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}

		

	}


	public function purchase_requisition_detail()
	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$purchase_req_det_list=$this->api_purchase_received_mdl->get_purchase_requistion_detail();
		$trans=$this->db->insert_batch('purd_purchasereqdetail',$purchase_req_det_list);
		if($trans)
	        {
	        	  print_r(json_encode(array('status'=>'success','message'=>'Generated Successfully !!')));
	        	exit;
	        }
	        else
	        {
	        	 print_r(json_encode(array('status'=>'error','message'=>'Operation Unsuccessful')));
	        	exit;
	        }
		}
		else
		{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}

	}

	
	public function quotation_master_list()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			/*echo "test";
			die();*/
			$quotation_master_list=$this->api_purchase_received_mdl->get_quotation_master_other_db();	
		$trans=$this->db->insert_batch('quma_quotationmaster',$quotation_master_list);
		if($trans)
	        {
	        	  print_r(json_encode(array('status'=>'success','message'=>'Generated Successfully !!')));
	        	exit;
	        }
	        else
	        {
	        	 print_r(json_encode(array('status'=>'error','message'=>'Operation Unsuccessful')));
	        	exit;
	        }
		}
		else
		{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}

	
	}


	public function quotation_detail_list()
	{
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$quotation_detail_list=$this->api_purchase_received_mdl->get_quotation_detail_other_db();	
		$trans=$this->db->insert_batch('qude_quotationdetail',$quotation_detail_list);
		if($trans)
	        {
	        	  print_r(json_encode(array('status'=>'success','message'=>'Generated Successfully !!')));
	        	exit;
	        }
	        else
	        {
	        	 print_r(json_encode(array('status'=>'error','message'=>'Operation Unsuccessful')));
	        	exit;
	        }
		}
		else
		{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}
	}

	public function purchase_order_master()
	{
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$purchase_order_master=$this->api_purchase_received_mdl->get_purchase_order_master_db();	
		$trans=$this->db->insert_batch('puor_purchaseordermaster',$purchase_order_master);
			$this->db->query("UPDATE xw_puor_purchaseordermaster SET puor_orderdatead=date_conveter('EN',puor_orderdatebs),puor_deliverydatead=date_conveter('EN',puor_deliverydatebs), puor_canceldatead=date_conveter('EN',puor_canceldatebs)");

		if($trans)
	        {
	        	  print_r(json_encode(array('status'=>'success','message'=>'Generated Successfully !!')));
	        	exit;
	        }
	        else
	        {
	        	 print_r(json_encode(array('status'=>'error','message'=>'Operation Unsuccessful')));
	        	exit;
	        }
		}
		else
		{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}
	}

	public function purchase_order_detail()
	{
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$purchase_order_detail_list=$this->api_purchase_received_mdl->get_purchase_order_detail_db();
		// echo "<pre>";
		// print_r($purchase_order_detail_list);
		// die();

		$trans=$this->db->insert_batch('pude_purchaseorderdetail',$purchase_order_detail_list);
		if($trans)
	        {
	        	  print_r(json_encode(array('status'=>'success','message'=>'Generated Successfully !!')));
	        	exit;
	        }
	        else
	        {
	        	 print_r(json_encode(array('status'=>'error','message'=>'Operation Unsuccessful')));
	        	exit;
	        }
		}
		else
		{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}
	}

	public function purchase_return()
	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		$purchase_return_list=$this->api_purchase_received_mdl->get_purchase_return_db();	
		// echo $this->db->last_query();
		// die();
		$trans='';
		if(!empty($purchase_return))
		{
					$trans=$this->db->insert_batch('purr_purchasereturn',$purchase_return_list);
		$this->db->query("UPDATE xw_purr_purchasereturn SET purr_returndatead=date_conveter('EN',purr_returndatebs)");
		}

		
		if($trans)
	        {
	        	  print_r(json_encode(array('status'=>'success','message'=>'Generated Successfully !!')));
	        	exit;
	        }
	        else
	        {
	        	 print_r(json_encode(array('status'=>'error','message'=>'Operation Unsuccessful')));
	        	exit;
	        }
		}
		else
		{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}

	}

	public function purchase_return_detail()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$purchase_return_detail_list=$this->api_purchase_received_mdl->get_purchase_return_detail_db();	
		$trans=$this->db->insert_batch('prde_purchasereturndetail',$purchase_return_detail_list);
		if($trans)
	        {
	        	  print_r(json_encode(array('status'=>'success','message'=>'Generated Successfully !!')));
	        	exit;
	        }
	        else
	        {
	        	 print_r(json_encode(array('status'=>'error','message'=>'Operation Unsuccessful')));
	        	exit;
	        }
		}
		else
		{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}

	}

	public function received_master()
	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$received_master_list=$this->api_purchase_received_mdl->get_received_master_db();	
		$trans=$this->db->insert_batch('recm_receivedmaster',$received_master_list);
		$this->db->query("UPDATE xw_recm_receivedmaster SET recm_purchaseorderdatead=date_conveter('EN',recm_purchaseorderdatebs), recm_supbilldatead=date_conveter('EN',recm_supbilldatebs)");
		if($trans)
	        {
	        	  print_r(json_encode(array('status'=>'success','message'=>'Generated Successfully !!')));
	        	exit;
	        }
	        else
	        {
	        	 print_r(json_encode(array('status'=>'error','message'=>'Operation Unsuccessful')));
	        	exit;
	        }
		}
		else
		{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}

	}


	public function received_detail()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$received_detail_list=$this->api_purchase_received_mdl->get_received_detail_db();	
		$trans=$this->db->insert_batch('recd_receiveddetail',$received_detail_list);
		if($trans)
	        {
	        	  print_r(json_encode(array('status'=>'success','message'=>'Generated Successfully !!')));
	        	exit;
	        }
	        else
	        {
	        	 print_r(json_encode(array('status'=>'error','message'=>'Operation Unsuccessful')));
	        	exit;
	        }
		}
		else
		{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}

	}

	public function chalan_master()
	{	
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$chalan_master_list=$this->api_purchase_received_mdl->get_chalan_master_db();	
		$trans=$this->db->insert_batch('chma_challanmaster',$chalan_master_list);
		if($trans)
	        {
	        	  print_r(json_encode(array('status'=>'success','message'=>'Generated Successfully !!')));
	        	exit;
	        }
	        else
	        {
	        	 print_r(json_encode(array('status'=>'error','message'=>'Operation Unsuccessful')));
	        	exit;
	        }
		}
		else
		{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}

		
	}

	public function chalan_detail()
	{	
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$chalan_detail_list=$this->api_purchase_received_mdl->get_chalan_details_db();	
		$trans=$this->db->insert_batch('chde_challandetails',$chalan_detail_list);
		if($trans)
	        {
	        	  print_r(json_encode(array('status'=>'success','message'=>'Generated Successfully !!')));
	        	exit;
	        }
	        else
	        {
	        	 print_r(json_encode(array('status'=>'error','message'=>'Operation Unsuccessful')));
	        	exit;
	        }
		}
		else
		{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}

		
	}





	public function requisition_note()
	{	
		$requisition_note_list=$this->api_purchase_received_mdl->get_requisition_note_db();	
		echo "<pre>";
		print_r($requisition_note_list);
		die();
		// print_r(array_change_key_case($staff_pos_list,CASE_LOWER));
		$this->db->insert_batch('reno_requisitionnote',$requisition_note_list);
		
	}
	public function requisition_details_note()
	{	
		$note_details_list=$this->api_purchase_received_mdl->get_requisition_note_details_db();	
		echo "<pre>";
		print_r($staff_info_list);
		die();
		// print_r(array_change_key_case($staff_pos_list,CASE_LOWER));
		$this->db->insert_batch('redt_reqdetailnote',$note_details_list);
		
	}
	
	








}
?>