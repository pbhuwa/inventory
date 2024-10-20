<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Handover_receive extends CI_Controller
{
	function __construct()
	{	
		parent::__construct();
		$this->load->Model('handover_receive_mdl');
		// $this->load->Model('direct_purchase_mdl');
		$this->storeid = $this->session->userdata(STORE_ID);
		$this->userid = $this->session->userdata(USER_ID);
		$this->locationid=$this->session->userdata(LOCATION_ID);
		$this->locationcode=$this->session->userdata(LOCATION_CODE);
	   	$this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
		$this->load->library('upload');
		$this->load->library('image_lib');
		$this->load->helper('file');
		$this->load->helper('form');
	}

	public function index()
	{ 
		$this->data['store_type']=$this->general->get_tbl_data('*','store',false,'st_store_id','ASC');
		$this->data['tab_type']='entry';
		$this->data['fiscal'] = $this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','DESC');
		$this->data['supplier_all'] = $this->general->get_tbl_data('*','dist_distributors',false,'dist_distributor','ASC');
		$this->data['budgets_list'] = $this->general->get_tbl_data('*','budg_budgets',false,'budg_budgetname','ASC');
		// echo "<pre>";print_r($this->data['budgets_list']);die();
		$this->data['received_no']=$this->generate_receiveno();
		$this->data['loadselect2']='no';

		$seo_data='';
		if($seo_data)
		{
			//set SEO data
			$this->page_title = $seo_data->page_title;
			$this->data['meta_keys']= $seo_data->meta_key;
			$this->data['meta_desc']= $seo_data->meta_description;
		}
		else
		{
			//set SEO data
			$this->page_title = ORGA_NAME;
			$this->data['meta_keys']= ORGA_NAME;
			$this->data['meta_desc']= ORGA_NAME;
		}
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('handover_receive/v_handover', $this->data);
	}
	public function form_direct_received_items()
	{
		$this->data['store_type']=$this->general->get_tbl_data('*','store',false,'st_store_id','ASC');
		$this->data['tab_type']='entry';
		$this->data['fiscal'] = $this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','DESC');
		$this->data['supplier_all'] = $this->general->get_tbl_data('*','dist_distributors',false,'dist_distributor','ASC');
		$this->data['budgets_list'] = $this->general->get_tbl_data('*','budg_budgets',false,'budg_budgetname','ASC');
		// echo "<pre>";print_r($this->data['budgets_list']);die();
		$this->data['received_no']=$this->generate_receiveno();
		$this->data['loadselect2']='yes';
		$this->load->view('handover_receive/v_receive_against_order_form',$this->data);

	}

	public function form_received_form(){
		$this->data['loadselect2']='yes';
		$this->data['store_type']=$this->general->get_tbl_data('*','store',false,'st_store_id','ASC');
		$this->data['tab_type']='entry';
		$this->data['fiscal'] = $this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','DESC');
		$this->data['supplier_all'] = $this->general->get_tbl_data('*','dist_distributors',false,'dist_distributor','ASC');
		$this->data['budgets_list'] = $this->general->get_tbl_data('*','budg_budgets',false,'budg_budgetname','ASC');
		// echo "<pre>";
		// print_r($this->data['budgets_list']);
		// die();

		 $this->data['received_no']=$this->generate_receiveno();

		// die();
		$seo_data='';
		if($seo_data)
		{
			//set SEO data
			$this->page_title = $seo_data->page_title;
			$this->data['meta_keys']= $seo_data->meta_key;
			$this->data['meta_desc']= $seo_data->meta_description;
		}
		else
		{
			//set SEO data
			$this->page_title = ORGA_NAME;
			$this->data['meta_keys']= ORGA_NAME;
			$this->data['meta_desc']= ORGA_NAME;
		}
		$this->load->view('handover_receive/v_receive_against_order_form',$this->data);
	}
	public function received_order_item_details()
	{
		$this->data['store_type']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','ASC');
		$this->data['supplier_all'] = $this->general->get_tbl_data('*','dist_distributors',false,'dist_distributor','ASC');
		$this->data['tab_type']='detailslist';
		$this->data['loadselect2']='yes';
		$seo_data='';
		if($seo_data)
		{
			//set SEO data
			$this->page_title = $seo_data->page_title;
			$this->data['meta_keys']= $seo_data->meta_key;
			$this->data['meta_desc']= $seo_data->meta_description;
		}
		else
		{
			//set SEO data
			$this->page_title = ORGA_NAME;
			$this->data['meta_keys']= ORGA_NAME;
			$this->data['meta_desc']= ORGA_NAME;
		}
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('handover_receive/v_against_order', $this->data);
	}
	public function received_order_item_details_lists()
	{  
		
		if(MODULES_VIEW=='N')
			{
			$array=array();
			 // $this->general->permission_denial_message();
			 echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));			
			exit;
			}
		
		 //echo "terst";die;
		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);
		//echo $this->db->last_query();die();
	  	$i = 0;
	  	$data = $this->handover_receive_mdl->get_receive_against_order_details_list();
	  	// echo"<pre>";print_r($data);die;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

	  	//echo "<pre>";print_r($data);die;
	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
		  	foreach($data as $row)
		    {
		    	if(ITEM_DISPLAY_TYPE=='NP'){
                	$rec_itemname = !empty($row->itli_itemnamenp)?$row->itli_itemnamenp:$row->itli_itemname;
                }else{ 
                    $rec_itemname = !empty($row->itli_itemname)?$row->itli_itemname:'';
                }

		   		$array[$i]["sno"] = $i+1;
		   		$array[$i]['orderno'] = !empty($row->recm_purchaseorderno)?$row->recm_purchaseorderno:"Challan: ".$row->recm_challanno;	
		   		$array[$i]['challan_no'] = $row->recm_challanno;	
		   		$array[$i]['itli_itemname'] = $rec_itemname;
		   		$array[$i]['recm_fyear'] = $row->recm_fyear;
		   		
		   		$array[$i]['unit_unitname'] = $row->unit_unitname;
		   		$array[$i]['recd_purchasedqty'] = $row->recd_purchasedqty;
		   		$array[$i]['recd_discount'] = $row->recd_discountamt;
		   		$array[$i]['recd_vatamt'] = $row->recd_vatamt;
		   		$array[$i]['recd_amount'] = $row->recd_amount;
		   		// if(DEFAULT_DATEPICKER=='NP')
	   			// {
	   			// 	$array[$i]['recm_receiveddatebs'] = $row->recm_receiveddatebs;
	   			// }else{
	   			// 	$array[$i]['recm_receiveddatebs'] = $row->recm_receiveddatead;
	   			// }
	   			$array[$i]['recm_receiveddatebs'] = $row->recm_receiveddatebs;
	   			$array[$i]['recm_supbilldatebs'] = $row->recm_supbilldatebs;
	   				$array[$i]['rate'] = $row->recd_unitprice;
	   			$array[$i]['total'] = $row->total;
	   			$array[$i]['supplier']=$row->dist_distributor;

		   		// $array[$i]['action'] = '<a href="javascript:void(0)" data-id='.$row->recm_receivedmasterid.' data-displaydiv="" data-viewurl='.base_url('purchase_receive/direct_purchase/direct_purchase_details').' class="view" data-heading="Direct Received Details"><i class="fa fa-eye" title="Return" aria-hidden="true" ></i></a>';
		   		//$array[$i]['cancel_all'] = '';
			    $i++;
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	//}
    }

	public function received_order_item_list()
	{
		
		$this->data['store_type']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','ASC');
		$this->data['supplier_all'] = $this->general->get_tbl_data('*','dist_distributors',false,'dist_distributorid','ASC');
		// echo "<pre>"; print_r($this->data['store_type']); die;

		$this->data['tab_type']='list';
		$seo_data='';
		if($seo_data)
		{
			//set SEO data
			$this->page_title = $seo_data->page_title;
			$this->data['meta_keys']= $seo_data->meta_key;
			$this->data['meta_desc']= $seo_data->meta_description;
		}
		else
		{
			//set SEO data
			$this->page_title = ORGA_NAME;
			$this->data['meta_keys']= ORGA_NAME;
			$this->data['meta_desc']= ORGA_NAME;
		}
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('handover_receive/v_against_order', $this->data);
	}

	public function orderlist_by_order_no()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$orderno=$this->input->post('orderno');
			$fiscalyrs=$this->input->post('fiscalyear');
			$puor_storeid=$this->session->userdata(STORE_ID);
			$this->data['order_data']=$this->handover_receive_mdl->get_orderlist_by_order_no(array('po.puor_orderno'=>$orderno,'po.puor_fyear'=>$fiscalyrs,'puor_storeid'=>$puor_storeid,'puor_locationid'=>$this->locationid));
			// echo $this->db->last_query();
			// die();
			// echo $this->db->last_query();die;
			// echo "<pre>";print_r($this->data['order_data']);die();
			$purchased=!empty($this->data['order_data'][0]->puor_purchased)?$this->data['order_data'][0]->puor_purchased:'';
			$status=!empty($this->data['order_data'][0]->puor_status)?$this->data['order_data'][0]->puor_status:'';

			if(empty($this->data['order_data']))
			{
				print_r(json_encode(array('status'=>'error','message'=>'Order no. '.$orderno .' is not found!!')));
				exit;	
			}
			if($purchased=='2')
			{
				print_r(json_encode(array('status'=>'error','message'=>'Order no. '.$orderno.' has been purchased/received completely')));
				exit;	
			}
			if($status=='C')
			{
				print_r(json_encode(array('status'=>'error','message'=>'Order no. '.$orderno.'is cancelled.')));
				exit;	
			}
			if($status=='CH')
			{
				print_r(json_encode(array('status'=>'error','message'=>'Order no. '.$orderno.'is received through challan.')));
				exit;	
			}

			$this->data['order_detail']=array();
			$tempform='';
			if($this->data['order_data'])
			{
				$ordermasterid=$this->data['order_data'][0]->puor_purchaseordermasterid;
				$this->data['order_detail']=$this->handover_receive_mdl->get_orderdetail_list(array('pude_purchasemasterid'=>$ordermasterid));
				// echo $this->db->last_query();
				// die();
				// echo "<pre>";
				// print_r($this->data['order_detail']);
				// die();
				if(!empty($this->data['order_detail']))
				{
					// echo "asd";
					// die();
					$tempform=$this->load->view('handover_receive/v_receive_against_order_form_detail',$this->data,true);
					
				}
			

			}
			// echo"<pre>"; print_r($tempform);die;
			print_r(json_encode(array('status'=>'success','order_data'=>$this->data['order_data'],'tempform'=>$tempform,'message'=>'Selected Successfully')));
			exit;	

		}
		else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
			exit;
		}
	}

	public function received_against_order_list()
	{	
		if(MODULES_VIEW=='N')
		{
			$array=array();
		 	// $this->general->permission_denial_message();
		 	echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));			
			exit;
		}
		
		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);
			
	  	$i = 0;
	  	$data = $this->handover_receive_mdl->get_receive_against_order_list();
	  	// echo"<pre>";print_r($data);die;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
		  	foreach($data as $row)
		    {	
		   		$array[$i]["sno"] = $i+1;
		   		$array[$i]['recm_receiveddatebs'] = $row->recm_receiveddatebs;
		   		$array[$i]['recm_fyear'] = $row->recm_fyear;
		   		$array[$i]['recm_invoiceno'] = $row->recm_invoiceno;
		   		$array[$i]['orderno'] = !empty($row->orderno)?$row->orderno:"Challan: ".$row->recm_challanno;
		   		$array[$i]['challano'] = $row->recm_challanno;
		   		$array[$i]['dist_distributor'] = $row->dist_distributor;
		   		$array[$i]['budg_budgetname'] = $row->budg_budgetname;
		   		$array[$i]['recm_discount'] = $row->recm_discount;
		   		$array[$i]['recm_taxamount'] = $row->recm_taxamount;
		   		$array[$i]['recm_clearanceamount'] = $row->recm_clearanceamount;
		   		$array[$i]['recm_posttime'] = $row->recm_posttime;
			   		// $array[$i]['order_date'] = $row->orderdate;
			   		// $array[$i]['rate'] = $row->rate;
			   		// $array[$i]['vat'] = $row->vat;
		   		$disp_var=$this->lang->line('receive_ordered_items_detail');
			   	$array[$i]['recm_status'] = $row->recm_status;
		   		$array[$i]['recm_amount'] = $row->recm_amount;
		   		$array[$i]['action'] = '<a href="javascript:void(0)" data-id='.$row->recm_receivedmasterid.' data-displaydiv="" data-viewurl='.base_url('purchase_receive/handover_receive/direct_purchase_details').' class="view" data-heading="'.$disp_var.'"><i class="fa fa-eye" title="View" aria-hidden="true" ></i></a> <a href="javascript:void(0)" data-id='.$row->recm_receivedmasterid.' data-displaydiv="" data-viewurl='.base_url('purchase_receive/handover_receive/direct_purchase_details').' class="view" data-heading="'.$disp_var.'"><i class="fa fa-upload" title="Upload" aria-hidden="true" ></i></a>';
		   		//$array[$i]['cancel_all'] = ''; purchase_receive/direct_purchase/direct_purchase_details
			    $i++;
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}
	public function direct_purchase_details()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$mastid_id=$this->input->post('id');
		$this->data['master_id']=$mastid_id;
		$this->data['req_detail_list']=$this->direct_purchase_mdl->get_received_details(array('rd.recd_receivedmasterid'=>$mastid_id));
		
		$this->data['direct_purchase_master']=$this->direct_purchase_mdl->received_master_views(array('rm.recm_receivedmasterid'=>$mastid_id,'recm_status'=>'O'));
		// echo "<pre>";print_r($this->data['req_detail_list']);die();
		$tempform='';
		$tempform=$this->load->view('handover_receive/v_received_against_order_view',$this->data,true);
		if(!empty($tempform))
			{
					print_r(json_encode(array('status'=>'success','message'=>'View Open Success','tempform'=>$tempform)));
	            	exit;
			}
			else{
				print_r(json_encode(array('status'=>'error','message'=>'Unable to View!!')));
	            	exit;
			}
		}
		else
		{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
		exit;
		}
	}
	public function receive_aginst_reprint()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$id = $this->input->post('id');
				if($id)
				{ 
					$this->data['req_detail_list']=$this->direct_purchase_mdl->get_received_details(array('rd.recd_receivedmasterid'=>$id));
					$receive_master = $this->data['direct_purchase_master']=$this->direct_purchase_mdl->received_master_views(array('rm.recm_receivedmasterid'=>$id));
						//echo"<pre>";print_r($this->data['req_detail_list']);die();
						//$template=$this->load->view('purchase/v_print_report_direct_purchase',$this->data,true);

					$purchase_order_no = !empty($receive_master[0]->recm_purchaseorderno)?$receive_master[0]->recm_purchaseorderno:'';

					$this->data['challan_no'] = $this->general->get_tbl_data('chma_challanmasterid','chma_challanmaster', array('chma_puorid'=>$purchase_order_no));

					$this->data['user_signature'] = $this->general->get_signature($this->userid);

					$recv_date = !empty($req_detail_list[0]->recm_receiveddatebs)?$req_detail_list[0]->recm_receiveddatebs:CURDATE_NP;

					$approvedby = $this->general->get_store_post_data($recv_date,'approver');

					$this->data['approver_signature'] = $this->general->get_signature($approvedby);

					$store_head_id = $this->general->get_store_post_data($recv_date,'store_head');

					$this->data['store_head_signature'] = $this->general->get_signature($store_head_id);

					if(RECV_REPORT_TYPE == 'DEFAULT'){
						$template=$this->load->view('handover_receive/v_received_against_order_print',$this->data,true);
					}else{
						$template=$this->load->view('handover_receive/v_received_against_order_print'.'_'.REPORT_SUFFIX,$this->data,true);
					}

					// $template=$this->load->view('handover_receive/v_received_against_order_print',$this->data,true);
					// print_r($template);die;
				if($this->data['req_detail_list']>0)
				{
					print_r(json_encode(array('status'=>'success','message'=>'','tempform'=>$template)));
		            exit;
				}
				else{
					print_r(json_encode(array('status'=>'error','message'=>'')));
		            	exit;
				}
					print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','tempform'=>$template)));
		   		 exit;	
				}
			}
		 	else
		    {
		    	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
		            exit;
		    }
	    }else{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
		exit;
		}
	}

	public function load_order_list()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			try {	
				$this->data['requistion_departments']= '';
				$this->data['detail_list'] = '';

				$tempform=$this->load->view('handover_receive/v_pur_order_list_modal',$this->data,true);

				if(!empty($tempform))
				{
					print_r(json_encode(array('status'=>'success','message'=>'You Can view','tempform'=>$tempform)));
	            	exit;
				}
				else{
					print_r(json_encode(array('status'=>'error','message'=>'Unable to View!!')));
		            exit;
				}
			}
			catch (Exception $e) {
				print_r(json_encode(array('status'=>'error','message' => $e->getMessage())));
			}
		}else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
		exit;
		}
	}

	public function save_received_items($print = false)
	{   
		// echo"<pre>";print_r($this->input->post());die;
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		try { 

			if($this->input->post('id'))
			{
				if(MODULES_UPDATE=='N')
				{
				$this->general->permission_denial_message();
				exit;
				}
			}
			else
			{
				if(MODULES_INSERT=='N')
				{
				$this->general->permission_denial_message();
				exit;
				}
			}

			$this->form_validation->set_rules($this->handover_receive_mdl->validate_settings_receive_against_order);
			if($this->form_validation->run()==TRUE)
			{   
				$trans = $this->handover_receive_mdl->save_receive_order();
					if($trans)
					{
						$print_report = "";
						if($print = "print")
						{
							$this->data['req_detail_list']=$this->direct_purchase_mdl->get_received_details(array('rd.recd_receivedmasterid'=>$trans));
							$this->data['direct_purchase_master']=$this->direct_purchase_mdl->received_master_views(array('rm.recm_receivedmasterid'=>$trans));


							$this->data['user_signature'] = $this->general->get_signature($this->userid);

							$recv_date = !empty($req_detail_list[0]->recm_receiveddatebs)?$req_detail_list[0]->recm_receiveddatebs:CURDATE_NP;

							$approvedby = $this->general->get_store_post_data($recv_date,'approver');

							$this->data['approver_signature'] = $this->general->get_signature($approvedby);

							$store_head_id = $this->general->get_store_post_data($recv_date,'store_head');

							$this->data['store_head_signature'] = $this->general->get_signature($store_head_id);

							
							if(RECV_REPORT_TYPE == 'DEFAULT'){
								$print_report=$this->load->view('handover_receive/v_received_against_order_print',$this->data,true);
							}else{
								$print_report=$this->load->view('handover_receive/v_received_against_order_print'.'_'.REPORT_SUFFIX,$this->data,true);
							}
							// $print_report = $this->load->view('handover_receive/v_received_against_order_print', $this->data, true);
						}

						$this->insert_api_data_locally($trans);

						// api parameters
						if(defined('RUN_API') && RUN_API == 'Y'):
							if(defined('API_CALL')):	
								if(API_CALL == 'KUKL'){
									// $this->load->module('api/Api_kukl');
									// $this->Api_kukl->post_api_import_asset_with_issueno($trans);
									
									$this->post_api_import_asset_with_recno($trans);
								}
							endif;
						endif;

						print_r(json_encode(array('status'=>'success','message'=>'Received Order Successfully', 'print_report'=>$print_report)));
						exit;
					}
					else
					{
						print_r(json_encode(array('status'=>'error','message'=>'Operation Failed.')));
						exit;
				}
			}
		else
			{
				print_r(json_encode(array('status'=>'error','message'=>validation_errors())));
					exit;
			}
		
		} catch (Exception $e) {
		
		print_r(json_encode(array('status'=>'error','message' => $e->getMessage())));
		}
		}else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
		exit;
		}
	}

	public function upload_attachment($print = false)
		{   
			// echo"<pre>";print_r($this->input->post());die;
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			try { 

				if($this->input->post('id'))
				{
					if(MODULES_UPDATE=='N')
					{
					$this->general->permission_denial_message();
					exit;
					}
				}
				else
				{
					if(MODULES_INSERT=='N')
					{
					$this->general->permission_denial_message();
					exit;
					}
				}

				// $this->form_validation->set_rules($this->handover_receive_mdl->validate_settings_upload_attachment);

				if($this->input->post('id'))
				{   
					$trans = $this->handover_receive_mdl->save_attachment();
						if($trans)
						{
							$print_report = "";
							if($print = "print")
							{
								$this->data['req_detail_list']=$this->direct_purchase_mdl->get_received_details(array('rd.recd_receivedmasterid'=>$trans));
								$this->data['direct_purchase_master']=$this->direct_purchase_mdl->received_master_views(array('rm.recm_receivedmasterid'=>$trans));

								//print direct from form
								// $this->data['req_detail_list']='';
								// $this->data['direct_purchase_master']='';
								// //echo"<pre>";print_r($this->input->post());die;
								// $report_data = $this->data['report_data'] = $this->input->post();
								// $itemid = !empty($report_data['rede_itemsid'])?$report_data['itemsid']:'';
								// if(!empty($itemid)):
								// 	foreach($itemid as $key=>$it):
								// 		$itemid = !empty($report_data['itemsid'][$key])?$report_data['itemsid'][$key]:'';
								// 		$this->data['item_name']=$this->general->get_tbl_data('*','itli_itemslist',array('itli_itemlistid'=>$itemid),false,'DESC');
								// 	endforeach;
								// endif;
								//$print_report = $this->load->view('handover_receive/v_received_against_order_print', $this->data, true);
								$print_report = $this->load->view('handover_receive/v_received_against_order_print', $this->data, true);
								//print_r($print_report);die;
							}
							print_r(json_encode(array('status'=>'success','message'=>'Image Upload Successfully', 'print_report'=>$print_report)));
							exit;
						}
						else
						{
							print_r(json_encode(array('status'=>'error','message'=>'Please Choose Image||File.')));
							exit;
					}
				}
			else
				{
					print_r(json_encode(array('status'=>'error','message'=>validation_errors())));
						exit;
				}
			
			} catch (Exception $e) {
			
			print_r(json_encode(array('status'=>'error','message' => $e->getMessage())));
			}
			}else
			{
				print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
			exit;
			}
		}


	public function _notMatch($totalamountValue, $billamountFieldName)
	{
	    if($totalamountValue != $this->input->post($billamountFieldName))
	    {
	       $this->form_validation->set_message('_notMatch', 'Bill amount and total amount does not match');
	       return false;
	    }
	    return true;
	}
	public function exportToExcel(){
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=cancel_order_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");

        $data = $this->handover_receive_mdl->get_receive_against_order_list();

        $this->data['searchResult'] = $this->handover_receive_mdl->get_receive_against_order_list();
        
        $array = array();
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);
        $response = $this->load->view('handover_receive/v_against_order_download', $this->data, true);


        echo $response;
    }
    public function generate_pdf()
    {
        $this->data['searchResult'] = $this->handover_receive_mdl->get_receive_against_order_list();
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);
        $this->load->library('pdf');
        $mpdf = $this->pdf->load();
        //echo"<pre>";print_r($this->data['searchResult']);die;
        ini_set('memory_limit', '256M');
        $html = $this->load->view('handover_receive/v_against_order_download', $this->data, true);
        $mpdf = new mPDF('c', 'A4-L'); 


        if(PDF_IMAGEATEXT == '3')
        {
            $mpdf->SetWatermarkImage(PDF_WATERMARK);
            $mpdf->showWatermarkImage = true;
            $mpdf->showWatermarkText = true;  
            $mpdf->SetWatermarkText(ORGA_NAME);
        }
        if(PDF_IMAGEATEXT == '1')
        {
            $mpdf->SetWatermarkImage(PDF_WATERMARK);
            $mpdf->showWatermarkImage = true;
        } 
        if(PDF_IMAGEATEXT == '2')
        {
            $mpdf->showWatermarkText = true;  
            $mpdf->SetWatermarkText(ORGA_NAME);
        }

        $mpdf = new mPDF('utf-8', 'A4-L');
        $mpdf->SetAutoFont(AUTOFONT_ALL);
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->WriteHTML($html);
        $output = 'cancel_order_'.date('Y_m_d_H_i').'.pdf';
        $mpdf->Output();
        exit();
    }
    public function exportToExceldetails(){
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=cancel_order_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");

        $data = $this->handover_receive_mdl->get_receive_against_order_details_list();

        $this->data['searchResult'] = $this->handover_receive_mdl->get_receive_against_order_details_list();
        
        $array = array();
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);
        $response = $this->load->view('handover_receive/v_against_order_details_download', $this->data, true);
        echo $response;
    }
    public function generate_pdfDetails()
    {
        $this->data['searchResult'] = $this->handover_receive_mdl->get_receive_against_order_details_list();
        // echo "<pre>";
        // print_r($this->data['searchResult']);
        // die();
        $this->data['report_title']=$this->lang->line('received_detail_list');
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);
        $this->load->library('pdf');
        $mpdf = $this->pdf->load();
        //echo"<pre>";print_r($this->data['searchResult']);die;
        ini_set('memory_limit', '256M');
        $html = $this->load->view('handover_receive/v_against_order_details_download', $this->data, true);
        $mpdf = new mPDF('c', 'A4-L'); 


        if(PDF_IMAGEATEXT == '3')
        {
            $mpdf->SetWatermarkImage(PDF_WATERMARK);
            $mpdf->showWatermarkImage = true;
            $mpdf->showWatermarkText = true;  
            $mpdf->SetWatermarkText(ORGA_NAME);
        }
        if(PDF_IMAGEATEXT == '1')
        {
            $mpdf->SetWatermarkImage(PDF_WATERMARK);
            $mpdf->showWatermarkImage = true;
        } 
        if(PDF_IMAGEATEXT == '2')
        {
            $mpdf->showWatermarkText = true;  
            $mpdf->SetWatermarkText(ORGA_NAME);
        }

        $mpdf = new mPDF('utf-8', 'A4-L');
        $mpdf->SetAutoFont(AUTOFONT_ALL);
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->WriteHTML($html);
        $output = 'cancel_order_'.date('Y_m_d_H_i').'.pdf';
        $mpdf->Output();
        exit();
    }

   	public function generate_receiveno()
  	{
	  	$curmnth=CURMONTH;
	  	if($curmnth==1)
	  	{
	  		$prefix='A';
	  	}
	  	if($curmnth==2)
	  	{
	  		$prefix='B';
	  	}
	  	if($curmnth==3)
	  	{
	  		$prefix='C';
	  	}
	  	if($curmnth==4)
	  	{
	  		$prefix='D';
	  	}
	  	if($curmnth==5)
	  	{
	  		$prefix='E';
	  	}
	  	if($curmnth==6)
	  	{
	  		$prefix='F';
	  	}
	  	if($curmnth==7)
	  	{
	  		$prefix='G';
	  	}
	  	if($curmnth==8)
	  	{
	  		$prefix='H';
	  	}
	  	if($curmnth==9)
	  	{
	  		$prefix='I';
	  	}
	  	if($curmnth==10)
	  	{
	  		$prefix='J';
	  	}
	  	if($curmnth==11)
	  	{
	  		$prefix='K';
	  	}
	  	if($curmnth==12)
	  	{
	  		$prefix='L';
	  	}

	  	if(ORGANIZATION_NAME == 'NPHL'){
	  		$prefix = 'E';
	  	}

	  	$this->db->select('recm_invoiceno');
	  	$this->db->from('recm_receivedmaster');
	  	$this->db->where('recm_invoiceno LIKE '.'"%'.RECEIVED_NO_PREFIX.$prefix.'%"');
	  	$this->db->where('recm_locationid',$this->locationid);
	  	$this->db->limit(1);
	  	$this->db->order_by('recm_invoiceno','DESC');
	  	$query = $this->db->get();
	        // echo $this->db->last_query(); die();
	  	$invoiceno=0;
	  	$dbinvoiceno='';
	   
	    if ($query->num_rows() > 0) 
	    {
	        $dbinvoiceno=$query->row()->recm_invoiceno;         
	    }
	    if(!empty($dbinvoiceno))
	    {
	    	  $invoiceno=$this->general->stringseperator($dbinvoiceno,'number');
	    }

      	$nw_invoice = str_pad($invoiceno + 1, RECEIVED_NO_LENGTH, 0, STR_PAD_LEFT);

      	if(defined('SHOW_FORM_NO_WITH_LOCATION')){
	      	if(SHOW_FORM_NO_WITH_LOCATION == 'Y'){
	      		return $this->locationcode.'-'.RECEIVED_NO_PREFIX.$prefix.$nw_invoice;	
	      	}else{
	      		return RECEIVED_NO_PREFIX.$prefix.$nw_invoice;
	      	}
	    }else{
	     	return RECEIVED_NO_PREFIX.$prefix.$nw_invoice;
	    }
  	}

	public function get_order_list_for_receive(){

		if(MODULES_VIEW=='N')
		{
		  	$array=array();
            echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));
            exit;
		}
		
		$fiscalyear= !empty($this->input->get('fiscalyear'))?$this->input->get('fiscalyear'):$this->input->post('fiscalyear');

		$searcharray = array('po.puor_fyear'=>$fiscalyear,'po.puor_storeid'=>$this->storeid,'po.puor_status <>'=>'CH','po.puor_locationid'=>$this->locationid);

		$this->data['detail_list'] = '';


		$data = $this->handover_receive_mdl->get_order_list($searcharray);
		// echo "<pre>";
		// print_r($data); die;
		// echo $this->db->last_query(); die;
	  	$i = 0;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
	  
		  	foreach($data as $row)
		    {
		    	$array[$i]["masterid"] = $row->puor_purchaseordermasterid;
			    $array[$i]["order_no"] = $row->puor_orderno;
			    $array[$i]["req_no"] = $row->puor_requno;
			    $array[$i]["date"] = $row->puor_orderdatebs;
			    $array[$i]["suppliername"] = $row->dist_distributor;
			    $array[$i]["amount"] = $row->puor_amount;
			    
			    $i++;
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));


	}

	public function load_detail_list($new_order = false){
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$masterid = $this->input->post('masterid');

			$detail_list = $this->data['detail_list'] = $this->handover_receive_mdl->get_order_details(array('pude_purchasemasterid'=>$masterid,'pude_remqty >'=>0));
			
			if(empty($detail_list)){
				$isempty = 'empty';
			}else{
				$isempty = 'not_empty';
			}
			if($new_order == 'new_detail_list'){
				$tempform=$this->load->view('handover_receive/v_pur_order_detail_append',$this->data,true);
			}else{
				$tempform=$this->load->view('handover_receive/v_pur_order_detail_modal',$this->data,true);
			}

			if(!empty($tempform))
			{
				print_r(json_encode(array('status'=>'success','message'=>'You Can view','tempform'=>$tempform,'isempty'=>$isempty)));
	            exit;
			}
			else{
				print_r(json_encode(array('status'=>'error','message'=>'Unable to View!!')));
	            exit;
			}
		}else{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
			exit;
		}
	}

	public function post_api_import_asset_with_recno($rec_no){
		$req_detail_list =$this->direct_purchase_mdl->get_received_details(array('rd.recd_receivedmasterid'=>$rec_no));


		$recv_no = !empty($req_detail_list[0]->recm_invoiceno)?$req_detail_list[0]->recm_invoiceno:'';

		$recv_date = !empty($req_detail_list[0]->recm_receiveddatebs)?$req_detail_list[0]->recm_receiveddatebs:'';

		$recv_date_conv = str_replace("/", ".", $recv_date);

		$recm_departmentid = !empty($req_detail_list[0]->recm_departmentid)?$req_detail_list[0]->recm_departmentid:'';

		$recm_postusername = !empty($req_detail_list[0]->recm_postusername)?$req_detail_list[0]->recm_postusername:'';

		$recm_locationid = !empty($req_detail_list[0]->recm_locationid)?$req_detail_list[0]->recm_locationid:'';

		$recm_remarks = !empty($req_detail_list[0]->recm_remarks)?$req_detail_list[0]->recm_remarks:'';


		$post_master_array = array(
			"tranDate" => !empty($recv_date_conv)?$recv_date_conv:"0", //2076.01.20
		    "voucherType" => "1",
		    "voucherNo" => !empty($recv_no)?$recv_no:"0", 
		    "office_ID" => 40,
		    "entryBY" => !empty($recm_postusername)?$recm_postusername:"0",
		    "narration" => !empty($recm_remarks)?$recm_remarks:"0"
		);

		if(!empty($req_detail_list)):
			$drCrArray = array('Dr','Cr');
			foreach($req_detail_list as $reqkey=>$reqval){
				$recd_itemsid = !empty($reqval->recd_itemsid)?$reqval->recd_itemsid:'';

				$eqca_accode = !empty($reqval->eqca_accode)?$reqval->eqca_accode:'';

				$recd_description = !empty($reqval->recd_description)?$reqval->recd_description:'';

				$recd_amount = !empty($reqval->recd_amount)?$reqval->recd_amount:'';

				$distributor = !empty($reqval->dist_distributor)?$reqval->dist_distributor:'';

				foreach($drCrArray as $value){
					$post_detail_array[] = array(
						"aC_Code" => !empty($eqca_accode)?(int)$eqca_accode:0, // acc code according to api
						"drCr" => $value,
						"description" => !empty($recd_description)?$recd_description:"test",
						"amount" => !empty($recd_amount)?(float)$recd_amount:0,
						"costCenter_ID" => 1,
						"acC_NAME" => !empty($distributor)?$distributor:"0" // supplier name
					);
				}
			}
		endif;


		$master_array=array();
			


		$dtl_arr ='';
		$dtl_arr .= '{"offTranModel": '.json_encode($post_master_array).',';
		if(!empty($post_detail_array)):
			foreach($post_detail_array as $key=>$value){
				// $detail_array = array(
				// 	'offTranDetModel'=>array($value)
				// );
					$dtl_arr .= '"offTranDetModel":['.json_encode($value).']'.',';				
				// print_r($post_detail_array);

				// $test[] = $detail_array;
					
			}
		endif;
		$dtl_arr = rtrim($dtl_arr,',');
		$dtl_arr.= '}';
	

		$post_json = $dtl_arr;

		$api_url = KUKL_API_URL.'InventoryService/CurrentAssetsImport'.KUKL_API_KEY;

		// $api_url = base_url('api/api_kukl/get_post_data_issue');

		$client = curl_init($api_url);
		
		curl_setopt($client, CURLOPT_CUSTOMREQUEST, "POST");
		
		curl_setopt($client, CURLOPT_HTTPHEADER, array(
	    'Content-Type: application/json',
	    'Content-Length: ' . strlen($post_json))
	    );

	    // curl_setopt($client, CURLOPT_POST, true);
	    // curl_setopt($client, CURLOPT_POSTFIELDS, $post_json);
	    curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($client, CURLOPT_POSTFIELDS, $post_json);
	    curl_setopt($client, CURLOPT_FOLLOWLOCATION, 1); 

	    $response = curl_exec($client);

	    curl_close($client);

	    // echo $response;
	    return true;
		   
		
	}

	public function insert_api_data_locally($rec_no){
		$req_detail_list =$this->direct_purchase_mdl->get_received_details(array('rd.recd_receivedmasterid'=>$rec_no));


		$recv_no = !empty($req_detail_list[0]->recm_invoiceno)?$req_detail_list[0]->recm_invoiceno:'';

		$recv_date = !empty($req_detail_list[0]->recm_receiveddatebs)?$req_detail_list[0]->recm_receiveddatebs:'';

		$recv_date_conv = str_replace("/", ".", $recv_date);

		$recm_departmentid = !empty($req_detail_list[0]->recm_departmentid)?$req_detail_list[0]->recm_departmentid:'';

		$recm_postusername = !empty($req_detail_list[0]->recm_postusername)?$req_detail_list[0]->recm_postusername:'';

		$recm_locationid = !empty($req_detail_list[0]->recm_locationid)?$req_detail_list[0]->recm_locationid:'';

		$recm_remarks = !empty($req_detail_list[0]->recm_remarks)?$req_detail_list[0]->recm_remarks:'';

		$this->db->trans_begin();
		$api_master_array = array(
			'apma_transdate' =>!empty($recv_date_conv)?$recv_date_conv:"0",
			'apma_vouchertype' =>"1",
			'apma_voucherno'=>!empty($recv_no)?$recv_no:"0",
			'apma_officeid'=>40,
			'apma_entryby'=>!empty($recm_postusername)?$recm_postusername:"0",
			'apma_narration'=>!empty($recm_remarks)?$recm_remarks:"0",
			'apma_issync'=>'N',
			'apma_actionfrom'=>'Receive'
		);

		if(!empty($api_master_array)){
			$this->db->insert('apma_apimaster',$api_master_array);
			$insertid = $this->db->insert_id();
		}

		if(!empty($insertid)){
			if(!empty($req_detail_list)):
				$drCrArray = array('Dr','Cr');
				foreach($req_detail_list as $reqkey=>$reqval){
					$recd_itemsid = !empty($reqval->recd_itemsid)?$reqval->recd_itemsid:'';

					$eqca_accode = !empty($reqval->eqca_accode)?$reqval->eqca_accode:'';

					$recd_description = !empty($reqval->recd_description)?$reqval->recd_description:'';

					$recd_amount = !empty($reqval->recd_amount)?$reqval->recd_amount:'';

					$distributor = !empty($reqval->dist_distributor)?$reqval->dist_distributor:'';

					foreach($drCrArray as $value){
						$api_detail_array[] = array(
							"apde_apmaid"=>$insertid,
							"apde_accode" => !empty($eqca_accode)?(int)$eqca_accode:0, // acc code according to api
							"apde_drcr" => $value,
							"apde_description" => !empty($recd_description)?$recd_description:"test",
							"apde_amount" => !empty($recd_amount)?(float)$recd_amount:0,
							"apde_costcenterid" => 1,
							"apde_acname" => !empty($distributor)?$distributor:"0", // supplier name
							"apde_issync" => 'N'
						);
					}
				}
			endif;
			if(!empty($api_detail_array)){

				$this->db->insert_batch('apde_apidetail',$api_detail_array);
			}
		}

		$this->db->trans_complete();
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            return true;
        }
	}


	public function received_direct($reload=false){
		$this->data['store_type']=$this->general->get_tbl_data('*','store',false,'st_store_id','ASC');
		$this->data['tab_type']='entry';
		$this->data['fiscal'] = $this->general->get_tbl_data('*', 'fiye_fiscalyear', false, 'fiye_fiscalyear_id', 'DESC', '3');
		$this->data['received_no']=$this->handover_receive_mdl->generate_receiveno_handover();
		// echo $this->data['received_no'];
		// die();
		$this->data['loadselect2']='no';
		$seo_data='';
		if($seo_data)
		{
			//set SEO data
			$this->page_title = $seo_data->page_title;
			$this->data['meta_keys']= $seo_data->meta_key;
			$this->data['meta_desc']= $seo_data->meta_description;
		}
		else
		{
			//set SEO data
			$this->page_title = ORGA_NAME;
			$this->data['meta_keys']= ORGA_NAME;
			$this->data['meta_desc']= ORGA_NAME;
		}
		if($reload=='reload'){
			$this->load->view('handover_direct/v_handover_receive_direct_form',$this->data);
		}else{
			$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('handover_direct/v_handover_direct', $this->data);
		}

	
	}

	

	public function save_handover_received_direct()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			try {
				// if ($this->input->post('id')) {
				// 	if (MODULES_UPDATE == 'N') {
				// 		$this->general->permission_denial_message();
				// 		exit;
				// 	}
				// } else {
				// 	if (MODULES_INSERT == 'N') {
				// 		$this->general->permission_denial_message();
				// 		exit;
				// 	}
				// }

				$this->form_validation->set_rules($this->handover_receive_mdl->validate_settings_handover_received_item);
				if ($this->form_validation->run() == TRUE) {

					$trans = $this->handover_receive_mdl->handover_item_receive_save();

					// echo "test";
					// die();
					if ($trans) {
						$print = $this->input->post('print');
						$print_report = '';
						if ($print = "print") {
							

							// $print_report = $this->load->view('purchase/v_print_report_direct_purchase', $this->data, true);
							//echo "<pre>"; print_r($print_report);die;
						}
						print_r(json_encode(array('status' => 'success', 'message' => 'Record Save Successfully', 'print_report' => $print_report)));
						exit;
						// print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully')));
						// exit;
					} else {
						print_r(json_encode(array('status' => 'error', 'message' => 'Unsuccessful Operation')));
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


	public function received_direct_summary(){
	$this->data['tab_type']='summary_list';
	$seo_data='';
		if($seo_data)
		{
			//set SEO data
			$this->page_title = $seo_data->page_title;
			$this->data['meta_keys']= $seo_data->meta_key;
			$this->data['meta_desc']= $seo_data->meta_description;
		}
		else
		{
			//set SEO data
			$this->page_title = ORGA_NAME;
			$this->data['meta_keys']= ORGA_NAME;
			$this->data['meta_desc']= ORGA_NAME;
		}
		
			$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('handover_direct/v_handover_direct', $this->data);
	}

	public function received_direct_detail(){
	$this->data['tab_type']='detailslist';
		$seo_data='';
			if($seo_data)
			{
				//set SEO data
				$this->page_title = $seo_data->page_title;
				$this->data['meta_keys']= $seo_data->meta_key;
				$this->data['meta_desc']= $seo_data->meta_description;
			}
			else
			{
				//set SEO data
				$this->page_title = ORGA_NAME;
				$this->data['meta_keys']= ORGA_NAME;
				$this->data['meta_desc']= ORGA_NAME;
			}
			
				$this->template
				->set_layout('general')
				->enable_parser(FALSE)
				->title($this->page_title)
				->build('handover_direct/v_handover_direct', $this->data);
	}


	public function get_handover_summary_list()
	{
		if (MODULES_VIEW == 'N') {
			$array = array();
			// $this->general->permission_denial_message();
			echo json_encode(array("recordsFiltered" => 0, "recordsTotal" => 0, "data" => $array));
			exit;
		}

		$apptype = $this->input->get('apptype');

		$useraccess = $this->session->userdata(USER_ACCESS_TYPE);

		$i = 0;
		$data = $this->handover_receive_mdl->get_handover_receive_summary_report();
		
		// echo"<pre>";print_r($data);die;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"] > 0 ? $data["totalfilteredrecs"] : $data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

		unset($data["totalfilteredrecs"]);
		unset($data["totalrecs"]);
		foreach ($data as $row) {
			$appclass = '';
			$handover_status = $row->hrem_status;

			if ($handover_status == 'C') {
				$appclass = 'cancel';
			} else {
				$appclass = '';
			}
			$insurance = !empty($row->hrem_insurance) ? $row->hrem_insurance : '0.00';
			$carriagefreight = !empty($row->hrem_carriagefreight) ? $row->hrem_carriagefreight : '0.00';
			$packing = !empty($row->hrem_packing) ? $row->hrem_packing : '0.00';
			$transportcourier = !empty($row->hrem_transportcourier) ? $row->hrem_transportcourier : '0.00';
			$others = !empty($row->hrem_others) ? $row->hrem_others : '0.00';
			$extra = $insurance + $carriagefreight + $packing + $transportcourier + $others;

		
			$array[$i]["approvedclass"] = $appclass;
			$array[$i]["sno"] = $i + 1;
			$array[$i]['receiveddate'] = $row->hrem_receiveddatebs;
			$array[$i]['fyear'] = $row->hrem_fyear;
			$array[$i]['source'] = $row->hrem_source;
			$array[$i]['receivedno'] = $row->hrem_receivedno;
			$array[$i]['billno'] = $row->hrem_billno;
			$array[$i]['billdate'] = $row->hrem_billdatebs;
			$array[$i]['amount'] = $row->hrem_amount;
			$array[$i]['discount'] = $row->hrem_discount;
			$array[$i]['taxamount'] = $row->hrem_taxamount;
			$array[$i]['refund'] = $row->hrem_refund;
			$array[$i]['extra_amt'] = $extra;
			$array[$i]['clearanceamount'] = $row->hrem_clearanceamount;
			$array[$i]['receivedby'] = $row->hrem_receivedby;
			$array[$i]['enteredby'] = $row->hrem_enteredby;
			$array[$i]['action'] = '<a href="javascript:void(0)" data-id=' . $row->hrem_handoverrecmasterid . ' data-displaydiv="" data-viewurl=' . base_url('handover/handover_receive/received_direct_summary_view') . ' class="view btn-primary btn-xxs sm-pd " data-heading="Handover Received View" ><i class="fa fa-eye" title="View" aria-hidden="true" ></i></a> 

		   		<a href="javascript:void(0)" data-id=' . $row->hrem_handoverrecmasterid . ' data-date=' . $row->hrem_receivedno . ' data-viewurl=' . base_url('purchase_receive/receive_against_order/receive_cancel') . ' class="redirectedit  btn-danger btn-xxs" title="Receive Cancel"><i class="fa fa-times-rectangle" aria-hidden="true"></i></a>';
			//$array[$i]['cancel_all'] = ''; purchase_receive/direct_purchase/direct_purchase_details
			$i++;
		}
		echo json_encode(array("recordsFiltered" => $filtereddata, "recordsTotal" => $totalrecs, "data" => $array));
}

public function received_direct_summary_view(){
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$mastid_id = $this->input->post('id');
	$this->data['master_id'] = $mastid_id;
	$this->data['handover_master_data'] = $this->handover_receive_mdl->get_handover_master_receive(array('hm.hrem_handoverrecmasterid' => $mastid_id));
	// echo $this->db->last_query();
	// die();
	$this->data['handover_detail_data'] = $this->handover_receive_mdl->get_handover_detail_receive(array('hd.hred_handoverrecmasterid' => $mastid_id,'hd.hred_status'=>'O'));
	// echo "<pre>";print_r($this->data['handover_master_data']);die();
		$tempform = $this->load->view('handover_direct/v_handover_receive_view', $this->data, true);
	if (!empty($tempform)) {
		print_r(json_encode(array('status' => 'success', 'message' => 'View Open Success', 'tempform' => $tempform)));
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


public function handover_correction()
{
	$this->data['store_type'] = $this->general->get_tbl_data('*', 'store', false, 'st_store_id', 'ASC');
		$this->data['tab_type'] = 'handover_edit';
		$this->data['fiscal'] = $this->general->get_tbl_data('*', 'fiye_fiscalyear', false, 'fiye_fiscalyear_id', 'DESC',2);
		
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
			->build('handover_direct/v_handover_direct', $this->data);
}

public function search_handover_correction_form(){
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$locationid=$this->input->post('locationid');
	$receive_no=$this->input->post('receive_no');
	$fiscalyrs=$this->input->post('fiscalyrs');

	if(empty($locationid)){
		$tempform='<label>Branch Field is required </label>';
		print_r(json_encode(array('status' => 'success', 'message' => '', 'tempform' => $tempform)));
	exit;
	}
	if(empty($fiscalyrs)){
		$tempform='<label>Fiscal Year is required </label>';
		print_r(json_encode(array('status' => 'success', 'message' => '', 'tempform' => $tempform)));
		exit;
	}
	if(empty($receive_no)){
		$tempform='<label>Receive No is required </label>';
		print_r(json_encode(array('status' => 'success', 'message' => '', 'tempform' => $tempform)));
		exit;
	}

	
	$search_rec_array=array();
	if(!empty($locationid)){
		$search_rec_array['hrem_locationid']=$locationid;
	}
	if(!empty($receive_no)){
		$search_rec_array['hrem_receivedno']=$receive_no;
	}
	if(!empty($fiscalyrs)){
		$search_rec_array['hrem_fyear']=$fiscalyrs;
	}

	$this->data['handover_master_data'] = $this->handover_receive_mdl->get_handover_master_receive($search_rec_array);
	// echo "<pre>";
	// print_r($this->data['handover_master_data']);
	// die();
	if(empty($this->data['handover_master_data'])){
		

		$tempform='<label class="text-danger">Record does not exit !!! </label>';
		print_r(json_encode(array('status' => 'success', 'message' => '', 'tempform' => $tempform)));
		exit;
	}

	if(!empty($this->data['handover_master_data'])){
		$master_id=$this->data['handover_master_data'][0]->hrem_handoverrecmasterid;
		$rc_status = $this->data['handover_master_data'][0]->hrem_status;
		if ($rc_status == 'M') { // M=Cancel Status and O =Ok Status
					print_r(json_encode(array('status' => 'error', 'message' => 'Already Cancel this Handover Receive No.')));
					exit;
				}
		$this->data['handover_detail_data'] = $this->handover_receive_mdl->get_handover_detail_receive(array('hd.hred_handoverrecmasterid' => $master_id,'hd.hred_status'=>'O'));
	}
	// echo "<pre>";
	// print_r($this->data['handover_detail_data'] );
	// die();

	

	$this->data['fiscal'] = $this->general->get_tbl_data('*', 'fiye_fiscalyear', false, 'fiye_fiscalyear_id', 'DESC', '3');
	$this->data['received_no']=0;
	$tempform = '<div class="white-box pad-5 mtop_10" style="
    background: #efefef">';
	$tempform .=$this->load->view('handover_direct/v_handover_receive_direct_form',$this->data,true);
	$tempform .= '</div>';

	$tempform .= '</div><a href="javascript:void(0)" class="btn btn-sm btn-danger btnConfirm" data-id="' . $master_id . '" data-url="' . base_url('handover/handover_receive/handover_received_cancel_save') . '">Handover Received Cancel</a>';
	print_r(json_encode(array('status' => 'success', 'message' => '', 'tempform' => $tempform)));
	exit;
} else {
		print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
		exit;
	}
}

public function handover_received_cancel_save()
{
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$id= $this->input->post('id');

		$received_status = 0;
			$this->db->select('hrem_handoverrecmasterid,hrem_fyear,hrem_status');
			$this->db->from('hrem_handoverrecmaster');
			$this->db->where('hrem_handoverrecmasterid', $id);
			$this->db->order_by('hrem_handoverrecmasterid', 'ASC');
			$rm_data = $this->db->get()->row();
			if (!empty($rm_data)) {
				// echo "<pre>";
				// print_r($rm_data);
				// die();
				$this->db->trans_begin();
				$rc_mid = $rm_data->hrem_handoverrecmasterid;
				$rc_fiscalyrs = $rm_data->hrem_fyear;
				$rc_status = $rm_data->hrem_status;
				if ($rc_status == 'M') { // M=Cancel Status and O =Ok Status
					print_r(json_encode(array('status' => 'error', 'message' => 'Already Cancel this Handover Receive No.')));
					exit;
				}
				$update_handover_masterArray = array(
					'hrem_status' => 'M'
				);
				$this->db->update('hrem_handoverrecmaster', $update_handover_masterArray, array('hrem_handoverrecmasterid' => $rc_mid));

				// echo "<pre>";
				// echo $rc_mid;
				// die();

				$this->db->select('hd.hred_handoverrecdetailid,hd.hred_handoverrecmasterid,hd.hred_itemsid,td.trde_trmaid,td.trde_trdeid');
				$this->db->from('hred_handoverrecdetail hd');
				$this->db->join('trde_transactiondetail td','hd.hred_handoverrecdetailid=td.trde_mtdid AND td.trde_itemsid=hd.hred_itemsid','LEFT');
				$this->db->where('hd.hred_handoverrecmasterid', $rc_mid);
				$this->db->where('hd.hred_status','O');
				$this->db->order_by('hd.hred_handoverrecdetailid', 'ASC');
				$result_handover_detail = $this->db->get()->result();
				// echo "<pre>";
				// echo $this->db->last_query();

				// echo "<pre>";
				// print_r($result_handover_detail);
				// die();



				if (!empty($result_handover_detail)) {
					$trn_id= !empty($result_handover_detail[0]->trde_trmaid)?$result_handover_detail[0]->trde_trmaid:'';
					if(!empty($trn_id)){
						$this->db->where(array('trma_trmaid'=>$trn_id));
						$this->db->update('trma_transactionmain', array('trma_status'=>'M'));
						
					}

					foreach ($result_handover_detail as $khd => $rhd) {
					$trde_trid[]=$rhd->trde_trdeid;
					$hred_detetailid[]=$rhd->hred_handoverrecdetailid;
					}
					
					if(!empty($hred_detetailid)){
						$this->db->where_in('hred_handoverrecdetailid',$hred_detetailid);
						$this->db->update('hred_handoverrecdetail', array('hred_status'=>'M'));
						
					}

					if(!empty($trde_trid)){
						$this->db->where_in('trde_trdeid',$trde_trid);
						$this->db->update('trde_transactiondetail', array('trde_status'=>'M'));
						
					}
					
				}

				$this->db->trans_complete();
				if ($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();
					print_r(json_encode(array('status' => 'error', 'message' => 'Unable to cancel this receipt')));
					exit;
					exit;
				} else {
					$this->db->trans_commit();
					print_r(json_encode(array('status' => 'success', 'message' => 'Receipt Cancel Successfully!!')));
					exit;
					exit;
				}
			} else {
				print_r(json_encode(array('status' => 'error', 'message' => 'Unable to cancel this receipt')));
				exit;
			}
	


	} else {
			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		}
}


}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */