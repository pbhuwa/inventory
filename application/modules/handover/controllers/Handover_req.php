<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Handover_req extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->Model('handover_req_mdl');
		$this->load->Model('handover_issue_mdl');
		$this->load->Model('handover_req_direct_mdl');
		$this->load->Model('stock_inventory/handover_req_mdl');
		$this->username = $this->session->userdata(USER_NAME);
		$this->userid = $this->session->userdata(USER_ID);
		$this->locationid=$this->session->userdata(LOCATION_ID);
		$this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
		$this->orgid=$this->session->userdata(ORG_ID);
		$this->storeid = $this->session->userdata(STORE_ID);
		$this->usergroup = $this->session->userdata(USER_GROUPCODE);
	}


	public function handover_req($type=false)
	{   
		$id = $this->input->post('id');


		$this->data['tab_type'] = $type;

		if($id){
			$this->data['handover_data'] = $this->handover_req_mdl->get_requisition_data(array('harm_handovermasterid'=>$id));
		}else{
			$this->data['handover_data'] = array();
		}
		$this->data['department']=$this->general->get_tbl_data('*','dept_department',false,'dept_depid','DESC');
	    // $this->data['reqno']= $this->input->post('id');
		$this->data['handover_number']=$this->generate_handover_reqno();
		 // echo"<pre>";print_r($this->data['reqno']);die;
		$this->data['equipmentcategory']=$this->general->get_tbl_data('*','eqca_equipmentcategory',false,'eqca_equipmentcategoryid','DESC');
		$this->data['item_all']=$this->general->get_tbl_data('*','itli_itemslist',false,'itli_itemlistid','DESC');
		$this->data['fiscal_year']=$this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','DESC');
		
		$this->data['tab_type']='handover_req_entry';
	// $this->data['req_data'] = $this->handover_req_mdl->get_requisition_data(array('harm_isdelete'=>'N','hard_reqmasterid'=>$id));
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
		->build('handover/v_handover_tab', $this->data);

	}
		

	public function generate_handover_reqno()
	{
		//req no without location code
		$handoverreqno = '';
		$cur_fiscalyear = CUR_FISCALYEAR;
		$depid = !empty($this->input->post('depid'))?$this->input->post('depid'):$this->storeid;
		
	
			$get_reqno = $this->handover_req_mdl->get_req_no(array('harm_fyear'=>$cur_fiscalyear, 'harm_locationid' => $this->locationid));
			
			// print_r($get_reqno);
			// die();
		

		if(!empty($get_reqno)){
			$handoverreqno = !empty($get_reqno[0]->handoverreqno)?$get_reqno[0]->handoverreqno+1:1;
			// print_r($reqno);
			// die();
		}

	    if(defined('SHOW_FORM_NO_WITH_LOCATION')){
			if(SHOW_FORM_NO_WITH_LOCATION == 'Y'){

						//req no with location code
			  	$location_data = $this->general->get_tbl_data('loca_code','loca_location',array('loca_locationid'=>$this->locationid));

				$location_code = !empty($location_data[0]->loca_code)?$location_data[0]->loca_code:'';

				$prefix = $location_code;

			  	$this->db->select('harm_handoverreqno');
			  	$this->db->from('harm_handovermaster');
			  	$this->db->where('harm_handoverreqno LIKE '.'"%'.$prefix.'%"');
			  	$this->db->where('harm_locationid',$this->locationid);
			  	$this->db->limit(1);
			  	$this->db->order_by('harm_handoverreqno','DESC');
			  	$query = $this->db->get();
			         // echo $this->db->last_query(); die();
			  	$invoiceno=0;
			  	$dbinvoiceno='';
		      
		        if ($query->num_rows() > 0) 
		        {
		            $dbinvoiceno=$query->row()->harm_handoverreqno;         
		        }
		        if(!empty($dbinvoiceno))
		        {
		        	  $invoiceno=$this->general->stringseperator($dbinvoiceno,'number');
		        }

			    $nw_invoice = str_pad($invoiceno + 1, RECEIVED_NO_LENGTH, 0, STR_PAD_LEFT);

				return $prefix.'-'.$nw_invoice;
			}else{
				return $handoverreqno;
			}
		}else{
			return $handoverreqno;
		}
    }


	public function handover_request_from_branch()
	{
		if($_SERVER['REQUEST_METHOD'] === 'POST') {
			$req_no=$this->input->post('req_no');
			$itemid=$this->input->post('itemlist');
			$chk_for_unknown_item=$this->db->select('itli_materialtypeid')
								->from('itli_itemslist')
								->where_in('itli_itemlistid',$itemid)
								->where('itli_materialtypeid',3)
								->get()->result();


			// echo "<pre>";
			// print_r($chk_for_unknown_item);
			// die();
			if(!empty($chk_for_unknown_item)){

				print_r(json_encode(array('status' => 'error', 'message' => 'Unknown Item Could not be Request to Central Office, Please make change to known items !! ')));
				exit;
			}

			$trans  = $this->handover_req_mdl->save_handover_request_from_branch();
			if($trans){

				// Send Message to central store
				
				$central_location = $this->general->get_tbl_data('loca_locationid','loca_location',array('loca_ismain'=>'Y'));

				$central_location_id = !empty($central_location[0]->loca_locationid)?$central_location[0]->loca_locationid:0;

				$msg_params = array(
	            	'DEMAND_NO'=>$req_no,
	            	'HANDOVER_NO'=>$trans
	            );
	            $this->general->send_message_params('handover_request_from_branch', $msg_params, false, $central_location_id);

				print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully')));
				exit;
			}
			else{
				print_r(json_encode(array('status'=>'error','message'=>'Operation Fail !!')));
				exit;
			}
		}
		else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
			exit;
		}
	}

	public function form_handover_requisition()
	{
		$this->data['equipmentcategory']=$this->general->get_tbl_data('*','eqca_equipmentcategory',false,'eqca_equipmentcategoryid','DESC');
		// $this->data['handover_number']=$this->general->get_tbl_data('MAX(harm_handovermasterid) as id','harm_handoverreqmaster',array('harm_locationid'=>$this->locationid),'harm_handovermasterid','DESC');
		$this->data['department']=$this->general->get_tbl_data('*','dept_department',false,'dept_depid','DESC');
		$this->data['item_all']=$this->general->get_tbl_data('*','itli_itemslist',false,'itli_itemlistid','DESC');
		$this->data['fiscal_year']=$this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','DESC');
		$this->data['handover_number'] = $this->generate_handover_reqno();


		// $this->load->view('handover/v_handoverrequisition_form',$this->data);
		if(defined('HANDOVER_LAYOUT_TYPE')):
			if(HANDOVER_LAYOUT_TYPE == 'DEFAULT'){
				$this->load->view('handover/handover_req_direct/v_direct_handover_req_form', $this->data);
			}else{

				$this->load->view('handover/handover_req_direct/v_direct_handover_req_form', $this->data);
			}
		else:

			$this->load->view('handover/handover_req_direct/v_direct_handover_req_form', $this->data);
		endif;

	}

	public function handover_req_detail()
	{
		$this->data['tab_type']='handover_req_detail';
		$frmDate = CURDATE_NP;
		$toDate = CURDATE_NP;
		$cur_fiscalyear = CUR_FISCALYEAR;
		$this->data['fiscalyear'] = $this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','DESC'); 
		$this->data['status_count'] = $this->handover_req_mdl->getStatusCount(array('harm_reqdatebs >='=>$frmDate, 'harm_reqdatebs <='=>$toDate));
		// $this->data['requisition_no'] = $this->generate_stock_reqno();

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
		->build('handover/v_handover_tab', $this->data);
	}
	public function hadnover_requisition_details_lists()
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
		$data = $this->handover_req_mdl->get_handover_requisition_details_list();
	  	// echo $this->db->last_query();die();
	 	// echo"<pre>";print_r($data);die;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];
		unset($data["totalfilteredrecs"]);
		unset($data["totalrecs"]);
		foreach($data as $row)
		{
			    // $array[$i]["hard_reqdetailid"] = '<a href="javascript:void(0)" class="patlist" data-patientid='.$row->hard_reqdetailid.'>'.$row->hard_reqdetailid.'</a>';
			$array[$i]["harm_handoverreqno"] = $row->harm_handoverreqno;
			$array[$i]["postdatead"] = $row->harm_reqdatead;
			$array[$i]["postdatebs"] = $row->harm_reqdatebs;
			$array[$i]["itli_itemcode"] = $row->itli_itemcode;
			$array[$i]["itli_itemname"] = $row->itli_itemname;
			$array[$i]["itli_itemnamenp"] = $row->itli_itemnamenp;
			$array[$i]["harm_fyear"] = $row->harm_fyear;
			$array[$i]["hard_qty"] = $row->hard_qty;
			$array[$i]["hard_remqty"] = $row->hard_remqty;
			$array[$i]["issueqty"] = $row->hard_qty - $row->hard_remqty;
			$array[$i]["hard_remarks"] = $row->hard_remarks;
		 //$array[$i]["itli_itemname"] = $row->itli_itemname;

			$i++;
		}
		    //echo"<pre>";print_r($data);die;
		$get = $_GET;
		echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}
	public function exportToExcelHandoverReqlistSummary()
	{
		header("Content-Type: application/xls");    
		header("Content-Disposition: attachment; filename=handover_requisition_summary".date('Y_m_d_H_i').".xls");  
		header("Pragma: no-cache"); 
		header("Expires: 0");

		$data = $this->handover_req_mdl->get_handover_requisition_list();

		$this->data['searchResult'] = $this->handover_req_mdl->get_handover_requisition_list();

		$array = array();
		unset($this->data['searchResult']['totalfilteredrecs']);
		unset($this->data['searchResult']['totalrecs']);
		if(defined('HANDOVER_LAYOUT_TYPE')):
			if(HANDOVER_LAYOUT_TYPE == 'DEFAULT'){
				$response = $this->load->view('handover/handover_req/v_handover_requisition_download_summary', $this->data, true);
			}else{
				$response = $this->load->view('handover/handover_req/'.REPORT_SUFFIX.'/v_handover_requisition_download_summary', $this->data, true);
			}
		else:
			$response = $this->load->view('handover/handover_req/v_handover_requisition_download_summary', $this->data, true);
		endif;
		


		echo $response;
	}
	public function generate_pdfHandoverReqsummarylist()
	{

		$this->data['searchResult'] = $this->handover_req_mdl->get_handover_requisition_list();
		unset($this->data['searchResult']['totalfilteredrecs']);
		unset($this->data['searchResult']['totalrecs']);
		
		if(defined('HANDOVER_LAYOUT_TYPE')):
			if(HANDOVER_LAYOUT_TYPE == 'DEFAULT'){
				$html = $this->load->view('handover/handover_req/v_handover_requisition_download_summary', $this->data, true);
			}else{
				$html = $this->load->view('handover/handover_req/'.REPORT_SUFFIX.'/v_handover_requisition_download_summary', $this->data, true);
			}
		else:
			$html = $this->load->view('handover/handover_req/v_handover_requisition_download_summary', $this->data, true);
		endif;
		
		
		$output = 'handover_requisition'.date('Y_m_d_H_i').'.pdf';
		
		$this->general->generate_pdf($html, '','');
	}
	public function exportToExcelHandoverReqlistDetails()
	{
		header("Content-Type: application/xls");    
		header("Content-Disposition: attachment; filename=handover_requisition_details".date('Y_m_d_H_i').".xls");  
		header("Pragma: no-cache"); 
		header("Expires: 0");

		$data = $this->handover_req_mdl->get_handover_requisition_details_list();

		$this->data['searchResult'] = $this->handover_req_mdl->get_handover_requisition_details_list();

		$array = array();
		unset($this->data['searchResult']['totalfilteredrecs']);
		unset($this->data['searchResult']['totalrecs']);
		if(defined('HANDOVER_LAYOUT_TYPE')):
			if(HANDOVER_LAYOUT_TYPE == 'DEFAULT'){
				$response = $this->load->view('handover/handover_req/v_handover_requisition_download_details', $this->data, true);
			}else{
				$response = $this->load->view('handover/handover_req/'.REPORT_SUFFIX.'/v_handover_requisition_download_details', $this->data, true);
			}
		else:
			$response = $this->load->view('handover/handover_req/v_handover_requisition_download_details', $this->data, true);
		endif;


		echo $response;
	}
	public function generate_pdfHandoverReqlist_details()
	{

		$this->data['searchResult'] = $this->handover_req_mdl->get_handover_requisition_details_list();
		unset($this->data['searchResult']['totalfilteredrecs']);
		unset($this->data['searchResult']['totalrecs']);
		
		if(defined('HANDOVER_LAYOUT_TYPE')):
			if(HANDOVER_LAYOUT_TYPE == 'DEFAULT'){
				$html = $this->load->view('handover/handover_req/v_handover_requisition_download_details', $this->data, true);
			}else{
				$html = $this->load->view('handover/handover_req/'.REPORT_SUFFIX.'/v_handover_requisition_download_details', $this->data, true);
			}
		else:
			$html = $this->load->view('handover/handover_req/v_handover_requisition_download_details', $this->data, true);
		endif;
		
		$output = 'handover_requisition_details'.date('Y_m_d_H_i').'.pdf';
		
		$this->general->generate_pdf($html,'','');
	}
	public function save_handover($print = false)
	{
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

				$this->form_validation->set_rules($this->handover_req_mdl->validate_settings_handover_requisition);
				if($this->form_validation->run()==TRUE)
			{   //echo "<pre>"; print_r($this->input->post());die;
		$trans = $this->handover_req_mdl->save_handover();
				// echo $trans;die;
		if($trans)
				{		//error_reporting(0);
					$report_data = $this->data['report_data'] = $this->input->post();
					$harm_fromlocationid = !empty($report_data['harm_fromlocationid'])?$report_data['harm_fromlocationid']:'';
					$harm_fromdepid = !empty($report_data['harm_fromdepid'])?$report_data['harm_fromdepid']:'';
					$dep = $this->input->post('harm_ishandover');
					if($dep == "Y")
					{
						$this->data['from']=$this->general->get_tbl_data('*','dept_department',array('dept_depid'=>$harm_fromlocationid),false,'DESC');
					}
					if($dep == "N")
					{
						$this->data['from']=$this->general->get_tbl_data('*','eqty_equipmenttype',array('eqty_equipmenttypeid'=>$harm_fromlocationid),false,'DESC');
					}
					$this->data['tostore']=$this->general->get_tbl_data('*','eqty_equipmenttype',array('eqty_equipmenttypeid'=>$harm_fromdepid),false,'DESC');
						//print_r($this->data['tostore']);die;
					if(!empty($itemid)):
						foreach($itemid as $key=>$it):
							$itemid = !empty($report_data['harm_itemsid'][$key])?$report_data['harm_itemsid'][$key]:'';
							$unitid = !empty($report_data['puit_unitid'][$key])?$report_data['puit_unitid'][$key]:'';

						endforeach;
					endif;
					// $email = $this->load->view('stock/v_print_report_email', $this->data, true);
					if($print = "print")
					{	
						$handover_requisition_details=$this->data['handover_master'] = $this->general->get_tbl_data('*','harm_handoverreqmaster',array('harm_handovermasterid'=>$trans),'harm_handovermasterid','DESC');
						// echo"<pre>";print_r($this->data['issue_master']);die;
						$this->data['handover_details'] = $this->handover_req_mdl->get_requisition_data(array('rd.hard_handovermasterid'=>$trans));
						
						$this->data['user_signature'] = $this->general->get_signature($this->userid);

						$approvedby = $handover_requisition_details[0]->harm_approvedby;

						$this->data['approver_signature'] = $this->general->get_signature($approvedby);

						$req_date = !empty($handover_requisition_details[0]->harm_reqdatebs)?$handover_requisition_details[0]->harm_reqdatebs:CURDATE_NP; 

						$store_head_id = $this->general->get_store_post_data($req_date,'store_head');
						
						$this->data['store_head_signature'] = $this->general->get_signature($store_head_id);
						// $this->data['received_no'] = $this->generate_receiveno();
						if(defined('HANDOVER_REPORT_TYPE')):
							if(HANDOVER_LAYOUT_TYPE == 'DEFAULT'){
								$print_report = $this->load->view('handover/handover_req/v_handover_print_list',$this->data, true);
							}else{

								$print_report = $this->load->view('handover/handover_req/'.REPORT_SUFFIX.'/v_handover_print_list',$this->data, true);
							}
						else:

							$print_report = $this->load->view('handover/handover_req/v_handover_print_list',$this->data, true);
						endif;
						
					}
					print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully.', 'print_report'=>$print_report)));
					exit;
				}
				else
				{
					print_r(json_encode(array('status'=>'error','message'=>'Unsuccessful Operation.')));
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


public function check_req_no()
{
	$req_no=$this->input->post('sama_requisitionno');
	$fyear=$this->input->post('sama_fyear');
	$storeid=!empty($this->session->userdata(STORE_ID))?$this->session->userdata(STORE_ID):1;

	$srchcol=array('harm_handoverreqno'=>$req_no,'harm_fyear'=>$fyear,'harm_fromdepid'=>$storeid,'harm_approved'=>'1');

	$this->data['handover_data']=$this->handover_req_mdl->get_handover_req_no_list($srchcol, 'harm_handoverreqno','desc');
			// echo $this->db->last_query();
			// die();
	if(!empty($this->data['req_data']))
	{
		return 1;
	}
	else
	{
		return 0;
	}

}

public function handover_req_summary_list()
{
 	// echo "asdfsad";die;
	$this->data['department']=$this->general->get_tbl_data('*','dept_department',false,'dept_depid','DESC');
	$this->data['tab_type']='handover_req_summary';
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
	->build('handover/v_handover_tab', $this->data);

}

public function handover_detail()
{
	$this->data['tab_type']='handover_req_detail';
	$frmDate = CURDATE_NP;
	$toDate = CURDATE_NP;
	$cur_fiscalyear = CUR_FISCALYEAR;
	$this->data['fiscalyear'] = $this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','DESC'); 
	$this->data['status_count'] = $this->stock_requisition_mdl->getStatusCount(array('harm_reqdatebs >='=>$frmDate, 'harm_reqdatebs <='=>$toDate));
	$this->data['requisition_no'] = $this->generate_stock_reqno();
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
	->build('handover/v_handover_tab', $this->data);
}

public function handover_requisition_lists()
{
	
	if(MODULES_VIEW=='N')
	{
		$array=array();
		echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));			
		exit;
	}

	$useraccess= $this->session->userdata(USER_ACCESS_TYPE);
	$i = 0;
	$data = $this->handover_req_mdl->get_handover_requisition_list();
	// echo $this->db->last_query();
	// die();
	
	$array = array();
	$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
	$totalrecs = $data["totalrecs"];
	unset($data["totalfilteredrecs"]);
	unset($data["totalrecs"]);
	$view_heading_var=$this->lang->line('handover_requisition_details');
	$approve_heading_var=$this->lang->line('handover_requisition_information');

	foreach($data as $row)
	{
		
		$appclass='';
		$approved=$row->harm_approved;
		if($approved=='0')
		{
			$appclass='pending';
		}
		if($approved=='1')
		{
			$appclass='verified';
		}
			if($approved=='2')
		{
			$appclass='approved';
		}
		if($approved=='3')
		{
			$appclass='unapproved';
		}

		if($approved=='4')
		{
			$appclass='cancel';
		}

		$approvedby = $row->harm_approvedby;
		if(defined('APPROVEBY_TYPE')):
			if(APPROVEBY_TYPE == 'USER'){
				$approvedby = $row->harm_approvedby;
			}else{
				$approvedby = (defined('APPROVER_USERNAME') && !empty($row->harm_approvedby))?APPROVER_USERNAME:$row->harm_approvedby;
			}
		endif;
		    	// $array[$i]['viewurl']=base_url().'issue_consumption/stock_requisition/load_stock_requisition_popup';
		$array[$i]['viewurl']=base_url().'issue_consumption/stock_requisition';
		$array[$i]["prime_id"] = $row->harm_handovermasterid;
		$array[$i]["harm_handovermasterid"] = '<a href="javascript:void(0)" class="patlist" data-patientid='.$row->harm_handovermasterid.'>'.$row->harm_handovermasterid.'</a>';
		$array[$i]["reqno"] = $row->harm_handoverreqno;
		$array[$i]["approvedclass"] = $appclass;
		$array[$i]["manualno"] = $row->harm_manualno;
		$array[$i]["fromloc"] = $row->fromloc;
		$array[$i]["toloc"] = $row->toloc;
		$array[$i]["fromdep"] = $row->dept_depname;
		$array[$i]["username"] = $row->harm_username;
		if($approved=='0')
			{$array[$i]["cntitem"]='<a href="javascript:void(0)" data-id='.$row->harm_handovermasterid.' data-displaydiv="orderDetails" data-viewurl='.base_url('handover/handover_req/view_handover_requisition').' class="view  btn-xxs" data-heading="'.$view_heading_var.'">'.$row->cntitem.'</a>';
		
	}else{
		$array[$i]["cntitem"]='<a href="javascript:void(0)" data-id='.$row->harm_handovermasterid.' data-displaydiv="orderDetails" data-viewurl='.base_url('handover/handover_req/handover_requisition_views_details').' class="view  btn-xxs" data-heading="'.$view_heading_var.'">'.$row->cntitem.'</a>';
	}
		// $array[$i]["isdep"] = $row->harm_ishandover;
	$array[$i]["reqby"] = $row->harm_requestedby;
	$array[$i]["approvedby"] = $approvedby;
	$array[$i]["remarks"] = $row->harm_remarks;
	$array[$i]["fyear"] = $row->harm_fyear;
	$array[$i]["postdatead"] = $row->harm_reqdatead;
	$array[$i]["postdatebs"] = $row->harm_reqdatebs;
	if($approved=='0')
	{
		$editbtn='<a href="javascript:void(0)" data-id='.$row->harm_handovermasterid.' data-displaydiv="stockreqform" data-viewurl='.base_url('handover/handover_req/handover_req').' class="btnredirect btn-info btn-xxs" data-heading="View handover Requisition" title="Edit"  ><i class="fa fa-edit " aria-hidden="true" ></i></a>';
	}
	else
	{
		$editbtn='&nbsp;';
	}
	// $array[$i]["action"] = $editbtn.' <a href="javascript:void(0)" title="Approved" data-viewurl='.base_url('handover/handover_req/view_handover_requisition').' data-heading="'.$approve_heading_var.'"  class="view  btn-success btn-xxs" data-id='.$row->harm_handovermasterid.'><i class="fa fa-check-square-o" aria-hidden="true"></i></a> <a href="javascript:void(0)" data-id='.$row->harm_handovermasterid.' data-displaydiv="handoverDetails" data-viewurl='.base_url('handover/handover_req/handover_requisition_views_details').' class="view btn-primary btn-xxs" data-heading="'.$view_heading_var.'"><i class="fa fa-eye" aria-hidden="true" ></i></a> ';
	$array[$i]["action"] = '<a href="javascript:void(0)" data-id='.$row->harm_handovermasterid.' data-displaydiv="handoverDetails" data-viewurl='.base_url('handover/handover_req/handover_requisition_views_details').' class="view btn-primary btn-xxs" data-heading="'.$view_heading_var.'"><i class="fa fa-eye" aria-hidden="true" ></i></a> ';
	$i++;
}
$get = $_GET;
echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
}
public function requisition_summary()
{
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		  // print_r($this->input->post());
		  // die();
		$frmDate = !empty($this->input->post('frmdate'))?$this->input->post('frmdate'):CURDATE_NP;
		$toDate = !empty($this->input->post('todate'))?$this->input->post('todate'):CURDATE_NP;
		$input_locationid=!empty($this->input->post('locationid'))?$this->input->post('locationid'):'';

		if($this->location_ismain=='Y')
		{
			if($input_locationid)
			{
				$status_count = $this->handover_req_mdl->getStatusCount(array('harm_reqdatebs >='=>$frmDate, 'harm_reqdatebs <='=>$toDate,'harm_locationid'=>$input_locationid));

				$total_count = $this->handover_req_mdl->getRemCount(array('rm.harm_reqdatebs >='=>$frmDate, 'rm.harm_reqdatebs <='=>$toDate,'rm.harm_locationid'=>$input_locationid));
			}
			else
			{
				$status_count = $this->handover_req_mdl->getStatusCount(array('harm_reqdatebs >='=>$frmDate, 'harm_reqdatebs <='=>$toDate));
				$total_count = $this->handover_req_mdl->getRemCount(array('rm.harm_reqdatebs >='=>$frmDate, 'rm.harm_reqdatebs <='=>$toDate));
			}

		}
		else
		{
			$status_count = $this->handover_req_mdl->getStatusCount(array('harm_reqdatebs >='=>$frmDate, 'harm_reqdatebs <='=>$toDate,'harm_locationid'=>$this->locationid));
			$total_count = $this->handover_req_mdl->getRemCount(array('rm.harm_reqdatebs >='=>$frmDate, 'rm.harm_reqdatebs <='=>$toDate,'rm.harm_locationid'=>$this->locationid));
		}


		    // echo $this->db->last_query();
		print_r(json_encode(array('status'=>'success','status_count'=>$status_count,'total_count'=>$total_count)));
	}
}
public function generate_stock_reqno()
{
		//req no without location code
	$reqno = '';
	$cur_fiscalyear = CUR_FISCALYEAR;
	$depid = !empty($this->input->post('depid'))?$this->input->post('depid'):$this->storeid;
	$type = !empty($this->input->post('type'))?$this->input->post('type'):'issue';	

	if($type == 'transfer'){
		$get_reqno = $this->handover_req_mdl->get_req_no(array('harm_ishandover'=>'N','harm_fyear'=>$cur_fiscalyear, 'harm_locationid'=>$this->locationid));	
	}else if($type=='issue'){
		$get_reqno = $this->handover_req_mdl->get_req_no(array('harm_fromdepid'=>$depid,'harm_fyear'=>$cur_fiscalyear, 'harm_locationid' => $this->locationid));
	}else{
		$get_reqno = $this->handover_req_mdl->get_req_no(array('harm_fromdepid'=>$depid,'harm_fyear'=>$cur_fiscalyear, 'harm_locationid' => $this->locationid));
	}

	if(!empty($get_reqno)){
		$reqno = !empty($get_reqno[0]->reqno)?$get_reqno[0]->reqno+1:1;
	}

	if(defined('SHOW_REQNO_WITH_LOCATION')){
		if(SHOW_REQNO_WITH_LOCATION == 'Y'){

						//req no with location code
			$location_data = $this->general->get_tbl_data('loca_code','loca_location',array('loca_locationid'=>$this->locationid));

			$location_code = !empty($location_data[0]->loca_code)?$location_data[0]->loca_code:'';

			$prefix = $location_code;

			$this->db->select('harm_handoverreqno');
			$this->db->from('harm_handoverreqmaster');
			$this->db->where('harm_handoverreqno LIKE '.'"%'.$prefix.'%"');
			$this->db->limit(1);
			$this->db->order_by('harm_handoverreqno','DESC');
			$query = $this->db->get();
			        // echo $this->db->last_query(); die();
			$invoiceno=0;
			$dbinvoiceno='';

			if ($query->num_rows() > 0) 
			{
				$dbinvoiceno=$query->row()->harm_handoverreqno;         
			}
			if(!empty($dbinvoiceno))
			{
				$invoiceno=$this->general->stringseperator($dbinvoiceno,'number');
			}

			$nw_invoice = str_pad($invoiceno + 1, RECEIVED_NO_LENGTH, 0, STR_PAD_LEFT);

			return $prefix.$nw_invoice;
		}else{
			return $reqno;
		}
	}else{
		return $reqno;
	}
}
public function view_handover_requisition()
{
	if($_SERVER['REQUEST_METHOD'] === 'POST') {
		$mastid_id=$this->input->post('id');
		$this->data['requistion_data']=$this->handover_req_mdl->get_requisition_master_data(array('rm.harm_handovermasterid'=>$mastid_id));
		  // echo $this->db->last_query();die();
		$this->data['req_detail_list'] = $this->handover_req_mdl->get_requisition_details_data(array('rd.hard_handovermasterid'=>$mastid_id,'rd.hard_isdelete'=>'N'));
		//echo "<pre>";print_r($this->data['req_detail_list']);die();
		$tempform='';
		if(defined('HANDOVER_LAYOUT_TYPE')):
			if(HANDOVER_LAYOUT_TYPE == 'DEFAULT'){
				$tempform=$this->load->view('handover/handover_req/v_handover_requistion_view',$this->data,true);
			}else{
				$tempform=$this->load->view('handover/handover_req/'.REPORT_SUFFIX.'/v_handover_requistion_view',$this->data,true);
			}
		else:
			$tempform=$this->load->view('handover/handover_req/v_handover_requistion_view',$this->data,true);
		endif;
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
	else
	{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
		exit;
	}
}
public function handover_requisition_views_details()
{
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$id = $this->input->post('id');
			if($id)
			{ 
				$this->data['handover_requisition_details']=$this->handover_req_mdl->get_requisition_master_data(array('rm.harm_handovermasterid'=>$id));
				$this->data['handovermasterid']=$id;
					// print_r($this->data['handover_requisition_details']);
				$cstatus=$this->check_current_status_handover($id);
				// echo $cstatus;
				// die();
				$this->data['cstatus']=$cstatus;
				$template='';
				if($this->data['handover_requisition_details']>0)
				{
					$store_id=$this->data['handover_requisition_details'][0]->harm_storeid;
					$this->data['handover_requisition'] = $this->handover_req_mdl->get_requisition_details_data(array('rd.hard_handovermasterid'=>$id,'rd.hard_isdelete' =>'N'),$store_id);
					
					if(defined('HANDOVER_LAYOUT_TYPE')):
						if(HANDOVER_LAYOUT_TYPE == 'DEFAULT'){
							$template=$this->load->view('handover/handover_req/v_handover_req_detail',$this->data,true);
						}else{
							$template=$this->load->view('handover/handover_req/'.REPORT_SUFFIX.'/v_handover_req_detail',$this->data,true);
						}
					else:
						$template=$this->load->view('handover/handover_req/v_handover_req_detail',$this->data,true);
					endif;

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

public function check_current_status_handover($handovermasterid)
	{
		$this->db->select('harm_currentstatus');
		$this->db->from('harm_handoverreqmaster');
		$this->db->where('harm_handovermasterid',$handovermasterid);
		$query = $this->db->get();
		// echo $this->db->last_query();
		// die();
	    if ($query->num_rows() > 0) 
	    {
	        $data=$query->row();     
	        return $data->harm_currentstatus;       
	    }       
	}

public function handover_requisition_reprint()
{
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$id = $this->input->post('id');
			if($id)
			{ 
				$handover_requisition_details=$this->data['handover_master'] = $this->general->get_tbl_data('*','harm_handoverreqmaster',array('harm_handovermasterid'=>$id),'harm_handovermasterid','DESC');

				$req_masterid = !empty($handover_requisition_details[0]->harm_reqmasterid)?$handover_requisition_details[0]->harm_reqmasterid:'';
				
				$this->data['stock_req'] = $this->general->get_tbl_data('*','rema_reqmaster',array('rema_reqmasterid'=>$req_masterid),'rema_reqmasterid','DESC');

				// echo"<pre>";print_r($req_masterid);die;
				$this->data['handover_details'] = $this->handover_req_mdl->get_requisition_data(array('rd.hard_handovermasterid'=>$id));
				
				$this->data['user_signature'] = $this->general->get_signature($this->userid);
				$approvedby = $handover_requisition_details[0]->harm_approved;
				$this->data['approver_signature'] = $this->general->get_signature($approvedby);
					//echo"<pre>";print_r($this->data['stock_requisition_details']);die();
				$req_date = !empty($handover_requisition_details[0]->harm_reqdatebs)?$handover_requisition_details[0]->harm_reqdatebs:CURDATE_NP; 

				$store_head_id = $this->general->get_store_post_data($req_date,'store_head');

				$this->data['store_head_signature'] = $this->general->get_signature($store_head_id);


				if(defined('HANDOVER_REPORT_TYPE')):
					if(HANDOVER_REPORT_TYPE == 'DEFAULT'){
						$template=$this->load->view('handover/handover_req/v_handover_print_list',$this->data,true);
					}else{
						$template=$this->load->view('handover/handover_req/'.REPORT_SUFFIX.'/v_handover_print_list',$this->data,true);
					}
				else:
					$template=$this->load->view('handover/handover_req/v_handover_print_list',$this->data,true);
				endif;

				if($this->data['handover_master']>0)
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
public function change_status_handover()
{
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if(MODULES_APPROVE=='N')
		{
			print_r(json_encode(array('status'=>'error','message'=>$this->general->permission_denial_message())));
			exit;
		}

		$approve_post_status = $this->input->post('approve_status');
		$masterid=$this->input->post('masterid');
			// print_r($approve_post_status);die;
		if($approve_post_status=='')
		{
			print_r(json_encode(array('status'=>'error','message'=>'You Need to Select Atleast One Option !!! ')));
			exit;
		}
		
		$status='';
		if($approve_post_status == "0")
		{
			$status = "0";
		}
		if($approve_post_status == "1")
		{
			$status = "1";
		}
		if($approve_post_status == "2")
		{
			$status = "2";
		}
		
		if($approve_post_status == "3")
		{
			$status = "3";
		}
		if($approve_post_status == "4")
		{
			$status = "4";
		}

			//print_r($status);die;
		$trans  = $this->handover_req_mdl->handover_requisition_change_status($status,$masterid);
		if($trans)
		{
			print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully')));
			exit;
		}
		else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Record Save Successfully')));
			exit;
		}
	}else
	{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
		exit;
	}
}
public function load_requisition()
{
		// echo $depid;
		// die();
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		try {	
				//print_r($this->input->post()); die;
			$depid= $this->input->post('id');
				// echo $depid; die();
			$fiscalyear = $this->input->post('fiscal_year');
			
			$searcharry=array('rm.harm_fyear'=>$fiscalyear,'rm.harm_approved'=>'2','rm.harm_locationid'=>$this->locationid,'rm.harm_storeid'=>$this->storeid);

			
			$this->data['requistion_departments']= $this->handover_req_mdl->get_handover_issue_list($searcharry, 'harm_handoverreqno','desc');
				 // echo $this->db->last_query();die();
			

			$this->data['pending_list'] = '';
				//$this->data['type'] = $transfer;
			$tempform=$this->load->view('handover/handover_req/kukl/v_handover_req_selection_model',$this->data,true);
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
public function load_pendinglist($new_issue = false){
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$req_masterid = $this->input->post('req_masterid');
				$pending_list = $this->data['pending_list'] = $this->handover_issue_mdl->get_handover_requisition_details(array('rd.hard_handovermasterid'=>$req_masterid,'rd.hard_remqty >'=>0));
			// echo"<pre>";print_r($pending_list);die;
			// echo $this->db->last_query();die();
				if(empty($pending_list)){
					$isempty = 'empty';
				}else{
					$isempty = 'not_empty';
				}
				if($new_issue =='handover_issue_pending_list'){

					$tempform=$this->load->view('handover/handover_issue/kukl/v_handover_pendinglist',$this->data,true);
				}
				else{
					$tempform=$this->load->view('handover/handover_issue/kukl/v_handover_pendinglist',$this->data,true);
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
public function list_of_reqby()
{
	if ($_SERVER['REQUEST_METHOD'] === 'POST') 
	{
		try {
			$data['reqby_list'] = $this->handover_req_mdl->get_all_reqby(false,10,false,'harm_handovermasterid','ASC');
				  // echo "<pre>";
				  // print_r($data);
				  // die();
			$template=$this->load->view('handover/handover_req/kukl/v_list_of_handover_reqby',$data,true);
			
			if($template){
				print_r(json_encode(array('status'=>'success','message'=>'Selected Successfully','template'=>$template)));
				exit;
			}
			else
			{
				print_r(json_encode(array('status'=>'error','message'=>'Operation Unsuccessful')));
				exit;
			}
		}
		catch (Exception $e) {
			
			print_r(json_encode(array('status'=>'error','message' => $e->getMessage())));
		}
	}
	else
	{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
		exit;
	}
 }
 public function handover_req_reject()
 {
 	if ($_SERVER['REQUEST_METHOD'] === 'POST') 
	{
		
		// $trans=$this->handover_req_mdl->change_current_status('reject');
		 $handover_masterid=$this->input->post('hmid');
		 if(!empty($handover_masterid)){
		 	$handreq_dtl_list=$this->handover_req_mdl->get_requisition_data(array('harm_handovermasterid'=>$handover_masterid));
		 // 	echo $this->db->last_query();
		 // echo "<pre>";
		 // print_r($handreq_dtl_list);
		 // die();
		 	if(!empty($handreq_dtl_list)){
		 		$to_userid= !empty($handreq_dtl_list[0]->harm_postby)?$handreq_dtl_list[0]->harm_postby:'';
		 		$itemstr ='<table>';
		 		$itemstr .='<tr><th>S.n.</th><th>Item Code</th><th>Item Name</th><th>Unit</th><th>Qty</th></tr>';
		 		$i=1;
		 		foreach ($handreq_dtl_list as $kit => $itm) {
		 			$itemstr .='<tr><td>'.$i.'</td><td>'.$itm->itli_itemcode.'</td><td>'.$itm->itli_itemname.'</td><td>'.$itm->unit_unitname.'</td><td>'.$itm->hard_qty.'</td></tr>';
		 			$i++;
		 		}
		 		$itemstr.='</table>';
		 		$trans=$this->handover_req_mdl->change_current_status('reject');

				$mess_userid=$to_userid;
				$mess_title="Your Request No. $trans is rejected!!";
				$mess_message="Your Request No. $trans is rejected!! ".$itemstr;
				$mess_path = 'issue_consumption/stock_requisition/requisition_list';
				
				$this->general->send_message_to_user($mess_userid, $mess_title, $mess_message, $mess_path);


				if($trans){
					print_r(json_encode(array('status'=>'success','message'=>'The request is rejected!')));
					exit;
				}
				else{
					print_r(json_encode(array('status'=>'error','message'=>'Operation Fail !!')));
					exit;
				}


		 	}
		 	else{
					print_r(json_encode(array('status'=>'error','message'=>'Operation Fail !!')));
					exit;
				}

		 		
		 }


	}
	else
	{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
		exit;
	}
 }

 public function handover_req_accept()
 {
 	if ($_SERVER['REQUEST_METHOD'] === 'POST') 
	{
		 $handover_masterid=$this->input->post('hmid');
		 if(!empty($handover_masterid)){
		 	$handreq_dtl_list=$this->handover_req_mdl->get_requisition_data(array('harm_handovermasterid'=>$handover_masterid));
		 // 	echo $this->db->last_query();
		 // echo "<pre>";
		 // print_r($handreq_dtl_list);
		 // die();
		 	if(!empty($handreq_dtl_list)){
		 		$to_userid= !empty($handreq_dtl_list[0]->harm_postby)?$handreq_dtl_list[0]->harm_postby:'';
		 		$itemstr ='<table>';
		 		$itemstr .='<tr><th>S.n.</th><th>Item Code</th><th>Item Name</th><th>Unit</th><th>Qty</th></tr>';
		 		$i=1;
		 		foreach ($handreq_dtl_list as $kit => $itm) {
		 			$itemstr .='<tr><td>'.$i.'</td><td>'.$itm->itli_itemcode.'</td><td>'.$itm->itli_itemname.'</td><td>'.$itm->unit_unitname.'</td><td>'.$itm->hard_qty.'</td></tr>';
		 			$i++;
		 		}
		 		$itemstr.='</table>';
		 		$trans=$this->handover_req_mdl->change_current_status('accept');
		 		if($trans=='stock_empty')
		 		{
		 			print_r(json_encode(array('status'=>'error','message'=>'Could not Accept Zero Stock!!')));
					exit;
		 		}

				$mess_userid=$to_userid;
				$mess_title='Your Request is Accepted!!';
				$mess_message='Your Request is Accepted!! '.$itemstr;
				
				$this->general->send_message_to_user($mess_userid, $mess_title, $mess_message);


				if($trans){
					print_r(json_encode(array('status'=>'success','message'=>'Record Accepted Successfully !!')));
					exit;
				}
				else{
					print_r(json_encode(array('status'=>'error','message'=>'Operation Fail !!')));
					exit;
				}


		 	}
		 	else{
					print_r(json_encode(array('status'=>'error','message'=>'Operation Fail !!')));
					exit;
				}

		 		
		 }
		 // die();
		
	
	}
	else
	{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
		exit;
	}
 }

 public function handover_req_to_branch()
 {
 	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 		 $item_n_loc=$this->input->post('itemlist');
 		  $handovermasterid=$this->input->post('handovermasterid');

 		 if($item_n_loc==''){
 		 	print_r(json_encode(array('status'=>'error','message'=>'Click any one branch to request send !!')));
			exit;

 		 }

 		  $chkmaster=$this->general->get_tbl_data("*",'harm_handoverreqmaster hm',array('hm.harm_parentharmid'=>$handovermasterid));

 		  //$this->handover_req_mdl->check_item_with_handovermaster('master');
 		  
 		   if(!empty($chkmaster)){
 		   	print_r(json_encode(array('status'=>'error','message'=>'Request send already !!')));
			exit;
 		   }



	$trans=$this->handover_req_mdl->request_to_other_branch();
		if($trans){
			print_r(json_encode(array('status'=>'success','message'=>'Request Send Successfully !!')));
			exit;
		}
		else{
			print_r(json_encode(array('status'=>'error','message'=>'Operation Fail !!')));
			exit;
		}
	}
	else{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
		exit;
	}
 }

 	public function request_for_approval(){
 		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$trans=$this->handover_req_mdl->request_for_approval();

			if($trans){

				$mess_user = array('DH');

				$message = "Request for approval of Handover No. $trans.";

				$mess_title = $mess_message = $message;

				$mess_path = 'handover/handover_req/handover_req_summary_list';

				$this->general->send_message_to_user($mess_user, $mess_title, $mess_message, $mess_path, 'G');

				print_r(json_encode(array('status'=>'success','message'=>'Record Accepted Successfully !!')));
				exit;
			}
			else{
				print_r(json_encode(array('status'=>'error','message'=>'Operation Fail !!')));
				exit;
			}
		}
		else{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
			exit;
		}
 	}
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */