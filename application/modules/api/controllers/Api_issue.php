<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
ini_set('max_execution_time', 0); 
ini_set('memory_limit','2048M');
class Api_issue extends CI_Controller 
{

	function __construct() {
		parent::__construct();
			$this->load->model('api_issue_mdl');
	}
//Requistion Master Table
public function req_master_list()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$req_master_list=$this->api_issue_mdl->get_req_master_other_db();	
		$trans=$this->db->insert_batch('rema_reqmaster',$req_master_list);
		$this->db->query("UPDATE xw_rema_reqmaster SET rema_reqdatead=date_conveter('EN',rema_reqdatebs)");
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
	else{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        exit;
	}
	}
// Requistion Detail
public function req_detail_list()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$req_detail_list=$this->api_issue_mdl->get_req_detail_other_db();	
		$trans=$this->db->insert_batch('rede_reqdetail',$req_detail_list);
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
	else{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        exit;
	}

}


public function sales_master_data()
	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$sales_master_list=$this->api_issue_mdl->get_sales_master_other_db();	
		$trans=$this->db->insert_batch('sama_salemaster',$sales_master_list);
		$this->db->query("UPDATE xw_sama_salemaster SET sama_billdatead=date_conveter('EN',sama_billdatebs),sama_requisitiondatead=date_conveter('EN',sama_requisitiondatebs)");
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




	public function sale_detail_list()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$sale_detail_list=$this->api_issue_mdl->get_sales_detail_other_db();	
		// echo "<pre>";
		// print_r($supplier_list);
		// die();
		// print_r(array_change_key_case($staff_pos_list,CASE_LOWER));
		$trans=$this->db->insert_batch('sade_saledetail',$sale_detail_list);
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



	public function return_master()
	{	
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$return_master_list=$this->api_issue_mdl->get_return_master_db();	
			$trans=$this->db->insert_batch('rema_returnmaster',$return_master_list);
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

	public function return_detail()
	{	
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			
			$return_detail_list=$this->api_issue_mdl->get_return_detail_db();	
			$trans=$this->db->insert_batch('rede_returndetail',$return_detail_list);
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
	

	public function transaction_master()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$transaction_master_list=$this->api_issue_mdl->get_transaction_master();	
				$trans=$this->db->insert_batch('xw_trma_transactionmain',$transaction_master_list);
				$this->db->query("UPDATE xw_trma_transactionmain SET trma_transactiondatead=date_conveter('EN',trma_transactiondatebs)");

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

public function transaction_details()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
					
					$return_detail_list=$this->api_issue_mdl->get_transaction_detail();	
					$trans=$this->db->insert_batch('trde_transactiondetail',$return_detail_list);
					$this->db->query("UPDATE xw_trde_transactiondetail SET trde_transactiondatead=date_conveter('EN',trde_transactiondatebs)");
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
// 	public function reqdetail_note_list()
// 	{
// 		$reqdetail_note_list=$this->api_issue_mdl->get_reqdetail_note_other_db();	
// 		// echo "<pre>";
// 		// print_r($supplier_list);
// 		// die();
// 		// print_r(array_change_key_case($staff_pos_list,CASE_LOWER));
// 		$this->db->insert_batch('redt_reqdetailnote',$reqdetail_note_list);
// 	}


// public function requisition_list()
// 	{
// 		$requisition_list=$this->api_issue_mdl->get_requisition_other_db();	
// 		// echo "<pre>";
// 		// print_r($supplier_list);
// 		// die();
// 		// print_r(array_change_key_case($staff_pos_list,CASE_LOWER));
// 		$this->db->insert_batch('requ_requisition',$requisition_list);
// 	}

// public function requisitionnote_list()
// 	{
// 		$requisitionnote_list=$this->api_issue_mdl->get_requisitionnote_other_db();	
// 		// echo "<pre>";
// 		// print_r($supplier_list);
// 		// die();
// 		// print_r(array_change_key_case($staff_pos_list,CASE_LOWER));
// 		$this->db->insert_batch('reno_requisitionnote',$requisitionnote_list);
// 	}

}

