<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Handover_issue extends CI_Controller
{
	function __construct()
	{

		parent::__construct();
		$this->load->Model('handover_issue_mdl');
		$this->load->Model('handover_req_mdl');
		$this->load->Model('stock_inventory/stock_requisition_mdl','stock_requisition_mdl');
		// $this->load->Model('stock_inventory/stock_requisition_mdl');
		$this->username = $this->session->userdata(USER_NAME);
		$this->userid = $this->session->userdata(USER_ID);
		$this->locationid=$this->session->userdata(LOCATION_ID);
		$this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
		$this->orgid=$this->session->userdata(ORG_ID);
	}
	public function index()
	{   
		$this->data['reqno']= $this->input->post('id');
		$this->data['equipmentcategory']=$this->general->get_tbl_data('*','eqca_equipmentcategory',false,'eqca_equipmentcategoryid','DESC');
		$this->data['depatrment']=$this->general->get_tbl_data('*','dept_department',false,'dept_depid','DESC');
		
		$this->data['fiscal_year']=$this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','DESC');
		$this->data['new_issue'] ="";
		$this->data['tab_type']='entry';
		$this->data['handoverissue_no']=$this->general->generate_invoiceno('haov_handoverno','haov_handoverno','haov_handovermaster',HANDOVER_NO_PREFIX,HANDOVER_NO_LENGTH,false,'haov_locationid');
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
	
	public function handover_issuesummary()
	{
		$frmDate = CURMONTH_DAY1;
    	$toDate = CURDATE_NP;
        $cond='';

		if($frmDate){
			    $cond .=" WHERE haov_postdatead >='".$frmDate."'";
		}
		if($toDate){
				$cond .=" AND haov_postdatead <='".$toDate."'";
		}else{
			$cond .=" AND haov_postdatead <='".$frmDate."'";
		}
     $this->data['status_count'] = $this->handover_issue_mdl->getColorStatusCount($cond);
     // echo "<pre>";print_r($this->data['status_count']);die;
		$this->data['tab_type']='summary';
		$this->data['apptype'] = '';
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
	public function handover_issuedetail()
	{
		$this->data['tab_type']='details';
		$this->data['apptype'] = '';
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


	public function new_issue_temp()
	{
		$this->data['depatrment']=$this->general->get_tbl_data('*','dept_department',false,'dept_depid','DESC');
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$depid = $this->input->post('depid');
			$this->data['depart'] =  $this->input->post('depid');
			if($depid)
			{
				$this->data['new_issue'] = $this->handover_issue_mdl->get_selected_issue();
				
				$template=$this->load->view('issue/v_temp_new_issue',$this->data,true);
				//echo"<pre>"; print_r($template); die;
				if($this->data['new_issue']>0)
				{
					print_r(json_encode(array('status'=>'success','message'=>'','template'=>$template)));
					exit;
				}
				else{
					print_r(json_encode(array('status'=>'error','message'=>'')));
					exit;
				}
				print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));
				exit;	
			}
		}
		else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
			exit;
		}
	}
	public function save_handover_issue($print =false)
	{
		error_reporting(0);
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

				$postdata=$this->input->post();
   			// echo "<pre>";print_r($postdata);die();
				$req_nochk=$this->check_handover_req_no();
   			// echo $this->db->last_query();
   			// die();
			// echo $req_nochk;
				// if(empty($req_nochk)){
				// 	print_r(json_encode(array('status'=>'error','message'=>'Invalid Requisition No!!')));
				// 	exit;
				// }

				$print_report='';
				$itemsid = $this->input->post('sade_itemsid');
				$qtyinstock = $this->input->post('qtyinstock');
				$isqty = $this->input->post('sade_qty');
				$itmname=$this->input->post('sade_itemsname');
				$reqqty=$this->input->post('remqty');
				$this->form_validation->set_rules($this->handover_issue_mdl->validate_handover_issue);
				if($this->form_validation->run()==TRUE)
					{	if(!empty($itemsid))
						{
							foreach($itemsid as $key=>$val){
								$stockval = !empty($qtyinstock[$key])?$qtyinstock[$key]:'';
								$issueqty= !empty($isqty[$key])?$isqty[$key]:'';
								$itemid= !empty($itemsid[$key])?$itemsid[$key]:'';
								$itemStockVal=$this->handover_issue_mdl->check_item_stock($itemid);
						// echo $this->db->last_query();
						// die();
						// echo "<per>";print_r($itemStockVal);die;
								$db_item_stockval=!empty($itemStockVal)?$itemStockVal:0;

								$itmname=!empty($itmname[$key])?$itmname[$key]:'';
								$remQty=!empty($reqqty[$key])?$reqqty[$key]:'';

								if($issueqty>$db_item_stockval)
								{
									print_r(json_encode(array('status'=>'error','message'=>'Issue Qty of Item '.$itmname.' should not exceed stock qty. Please check it.')));
									exit;
								}

								if($issueqty>$remQty)
								{
									print_r(json_encode(array('status'=>'error','message'=>'Issue Qty of Item '.$itmname.' should not exceed Req. qty. Please check it.')));
									exit;
								}
							}
						}
						$trans = $this->handover_issue_mdl->save_handover_issue();

						if($trans)
						{

			// for message start
			  $this->data['handover_data'] = $this->general->get_tbl_data('*','haov_handovermaster',array('haov_handovermasterid'=>$trans),'haov_handovermasterid','DESC');

				$locationid = !empty($handover_data[0]->harm_tolocationid)?$handover_data[0]->harm_tolocationid:'';
				
				$central_location = $this->general->get_tbl_data('loca_locationid','loca_location',array('loca_locationid'=>$locationid));
				$central_location_id = !empty($central_location[0]->loca_locationid)?$central_location[0]->loca_locationid:0;

				$hovno = !empty($handover_data[0]->haov_handoverreqno)?$handover_data[0]->haov_handoverreqno:'';

				$mess_user = array('SK','SI');	

				$message = "Your handover request no $hovno has been handovered.";

				$mess_title = $mess_message = $message;

				$mess_path = 'issue_consumption/stock_requisition/requisition_list';

				$this->general->send_message_to_user($mess_user, $mess_title, $mess_message, $mess_path, 'G', $central_location_id);
            // message end
                          
							if($print =="print")
							{	
								$this->data['issue_master'] = $this->general->get_tbl_data('*','haov_handovermaster',array('haov_handovermasterid'=>$trans),'haov_handovermasterid','DESC');
						         // echo"<pre>";print_r($this->data['issue_master']);die;
								$this->data['issue_details'] = $this->handover_issue_mdl->get_issue_detail(array('sd.haod_handoverdetailid'=>$trans));
					           // echo"<pre>";	print_r($this->data['issue_details']);die;
								$this->data['store']=$this->general->get_tbl_data('eqty_equipmenttype','eqty_equipmenttype',array('eqty_equipmenttypeid'=>$this->session->userdata(STORE_ID)),'eqty_equipmenttypeid','ASC');
								$this->data['user_signature'] = $this->general->get_signature($this->userid);
								$approve_data = $this->handover_issue_mdl->get_approve_data($trans);
								$approvedby = !empty($approve_data[0]->harm_approvedid)?$approve_data[0]->harm_approvedid:'';
								$this->data['approver_signature'] = $this->general->get_signature($approvedby);
								$issue_date = !empty($issue_details[0]->haov_handoverdatebs)?$issue_details[0]->haov_handoverdatebs:CURDATE_NP; 
								$store_head_id = $this->general->get_store_post_data($issue_date,'store_head');
								$this->data['store_head_signature'] = $this->general->get_signature($store_head_id);
								if(defined('HANDOVER_LAYOUT_TYPE')):
									if(HANDOVER_LAYOUT_TYPE == 'DEFAULT'){
										$print_report = $this->load->view('handover/handover_issue/v_handover_issue_print', $this->data, true);
									}else{
										$print_report = $this->load->view('handover/handover_issue/'.REPORT_SUFFIX.'/v_handover_issue_print', $this->data, true);
									}
								else:
									$print_report = $this->load->view('handover/handover_issue/v_handover_issue_print', $this->data, true);
								endif;


						//echo "<pre>"; print_r($print_report);die;
							}
							print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully','print_report'=>$print_report)));
							exit;
						}
						else
						{
							print_r(json_encode(array('status'=>'error','message'=>'Unsuccessfull Operation')));
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


		public function form_handover_issue(){
			$this->data['reqno']='';
			$this->data['equipmentcategory']=$this->general->get_tbl_data('*','eqca_equipmentcategory',false,'eqca_equipmentcategoryid','DESC');
			$this->data['depatrment']=$this->general->get_tbl_data('*','dept_department',false,'dept_depid','DESC');
			$this->data['item_all']=$this->general->get_tbl_data('*','itli_itemslist',false,'itli_itemlistid','DESC');
			$this->data['fiscal_year']=$this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','ASC');
			$this->data['new_issue'] ="";
			$this->data['tab_type']='entry';
			$this->data['issue_no']=$this->generate_handover_issueno();

			$this->data['handoverissue_no']=$this->general->generate_invoiceno('haov_handoverno','haov_handoverno','haov_handovermaster',HANDOVER_NO_PREFIX,HANDOVER_NO_LENGTH,false,'haov_locationid');

			if(defined('NEW_ISSUE_FORM_TYPE')):
				if(NEW_ISSUE_FORM_TYPE == 'DEFAULT'){
					$this->load->view('handover/handover_issue/v_handover_issue_form',$this->data);
				}else{
					$this->load->view('handover/handover_issue/'.REPORT_SUFFIX.'/v_handover_issue_form',$this->data);
				}
			else:
				$this->load->view('handover/handover_issue/v_handover_issue_form',$this->data);
			endif;

		}

		public function check_handover_req_no()
		{
			$req_no=$this->input->post('sama_requisitionno');
			$fyear=$this->input->post('sama_fyear');
			$storeid=!empty($this->session->userdata(STORE_ID))?$this->session->userdata(STORE_ID):1;

			// $srchcol=array('harm_handoverreqno'=>$req_no,'harm_fyear'=>$fyear,'harm_approved'=>'2','harm_storeid'=>$storeid);
			$srchcol=array('harm_handoverreqno'=>$req_no,'harm_fyear'=>$fyear,'harm_approved'=>'2','harm_storeid'=>$storeid);
			
			$this->data['req_data']=$this->handover_issue_mdl->get_handover_req_no_list($srchcol, 'harm_handoverreqno','desc');
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

		public function handover_issuelist_by_req_no()

		{
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$req_no=$this->input->post('req_no');
				$fyear=$this->input->post('fyear');
				$locationid=$this->input->post('locationid');
				if(empty($locationid)){
					print_r(json_encode(array('status'=>'error','message'=>'location Field is required!!')));
					exit;
				}
				$storeid=!empty($this->session->userdata(STORE_ID))?$this->session->userdata(STORE_ID):1;

				$srchcol=array('harm_handoverreqno'=>$req_no,'harm_fyear'=>$fyear,'harm_storeid'=>$storeid,'harm_fromlocationid'=>$locationid);

				$this->data['handreq_data']=$this->handover_req_mdl->get_handover_req_no_list($srchcol, 'harm_tolocationid','desc');
			// echo $this->db->last_query();
			// die();
			// echo "<pre>";print_r($this->data['handreq_data']);die();
				$handreq_data=array();
				if(!empty($this->data['handreq_data']))
				{
					$masterid=$this->data['handreq_data'][0]->harm_handovermasterid;
					$isapproved=!empty($this->data['handreq_data'][0]->harm_approved)?$this->data['handreq_data'][0]->harm_approved:'';
				// echo $isapproved;
				// die();
					if(DEFAULT_DATEPICKER=='NP')
					{
						$req_data['req_date']=$this->data['handreq_data'][0]->harm_reqdatebs;
					}
					else
					{
						$req_data['req_date']=$this->data['handreq_data'][0]->harm_reqdatead;
					}
					$req_data['fromdepid']=$this->data['handreq_data'][0]->harm_fromdepid;

					$req_data['fromlocationid']=$this->data['handreq_data'][0]->harm_fromlocationid;
					$req_data['reqby']=$this->data['handreq_data'][0]->harm_requestedby;

					// if($isapproved!='2' && empty($isapproved))
					// {
					// 	print_r(json_encode(array('status'=>'error','message'=>'Requested Handover Req. number is not approved !!')));
					// 	exit;
					// }
					// else
					// {
					print_r(json_encode(array('status'=>'success','message'=>'Data Selected  Successfully!!','masterid'=>$masterid,'req_data'=>$req_data)));
					exit;
					// }


				}
				else
				{
					print_r(json_encode(array('status'=>'error','message'=>'Invalid Requisition Number!!!')));
					exit;
				}
			}
			else
			{
				print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
				exit;
			}
		}
		public function handover_issue_details_list()
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

			$data = $this->handover_issue_mdl->get_handover_issue_book_details_list();
			// echo $this->db->last_query();die();
		   //  echo "<pre>";print_r($data);die;
			$array = array();
			$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
			$totalrecs = $data["totalrecs"];
			unset($data["totalfilteredrecs"]);
			unset($data["totalrecs"]);
			
			foreach($data as $row)
			{
				if(ITEM_DISPLAY_TYPE=='NP'){
					$req_itemname = !empty($row->itli_itemnamenp)?$row->itli_itemnamenp:$row->itli_itemname;
				}else{ 
					$req_itemname = !empty($row->itli_itemname)?$row->itli_itemname:'';
				}
					// $array[$i]['salemasterid']=$row->haov_handovermasterid;
				$array[$i]["invoiceno"]=$row->haov_handoverno;
				$array[$i]["from"]=$row->fromlocation;
				$array[$i]["to"]=$row->tolocation;
				$array[$i]["billdatebs"]=$row->haov_handoverdatebs;
				$array[$i]["billdatead"]=$row->haov_handoverdatead;
				$array[$i]["depname"]=$row->dept_depname;
				$array[$i]["totalamount"]=$row->haov_totalamount;
				$array[$i]["username"]=$row->haov_username;
				$array[$i]["memno"]=$row->haov_receivedby;
				$array[$i]["requisitionno"]=$row->haov_handoverreqno;
				$array[$i]["handovertime"]=$row->haov_handovertime;
				$array[$i]["sade_qty"]= number_format($row->haod_qty,2);
				$array[$i]["sade_unitrate"]=number_format($row->haod_unitprice,2);
				$array[$i]["issueamt"]= number_format($row->issueamt,2);
				$array[$i]["itli_itemcode"]=$row->itli_itemcode;
				$array[$i]["itli_itemname"]=$req_itemname;
				$array[$i]["sade_remarks"]=$row->haod_remarks;
				$array[$i]["action"]='';
				$i++;
			}

			echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
		}
	
		public function handover_issue_summary_list()
		{	

           // $status=$this->input->post('apptype');
           // echo $status;die;
			$data = $this->handover_issue_mdl->get_issue_handover_list();
            // echo "<pre>";print_r($data);die();	
			$i = 0;
			$array = array();
			$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
			$totalrecs = $data["totalrecs"];

			unset($data["totalfilteredrecs"]);
			unset($data["totalrecs"]);
		// $view_heading_var=$this->lang->line('issue_requisition_details');

			
			foreach($data as $row){

				$appclass='';
				$approved=$row->haov_isreceived;
				if($approved=='N')
				{
					$appclass='handover';
					$status='NO';
				}
				if($approved=='Y'){
					$appclass='received';
					$status='YES';
				}
				if($approved=='P'){
					$appclass='partial';
					$status='PARTIAL';
				}
				$array[$i]["sno"] = $i+1;
				$array[$i]["approvedclass"] =$appclass;
				$array[$i]["handover_no"] = $row->haov_handoverno;
				$array[$i]["handover_req_no"]=$row->haov_handoverreqno;
				$array[$i]["date_ad"]=$row->haov_handoverdatead;
				$array[$i]["date_bs"]=$row->haov_handoverdatebs;
				$array[$i]["haov_isreceived"]=$status;
				$array[$i]["handover_to"]=$row->tolocation;
				$array[$i]["time"]=$row->haov_handovertime;
				$array[$i]["fyear"]=$row->haov_fyear;

			$view='<a href="javascript:void(0)" data-id='.$row->haov_handovermasterid.' data-displaydiv="Handover Issue" data-viewurl='.base_url('handover/handover_issue/handover_view_details').' class="view btn-primary btn-xxs" data-heading="Handover Details View" title="View"  ><i class="fa fa-eye" aria-hidden="true" ></i></a>';
		    $reprint='<a href="javascript:void(0)" data-id='.$row->haov_handovermasterid.' class="btn-xxs btn-success PrintThisNow ReprintThis" id="btnPrintNowBtn" data-heading="Receivd Handover" title="Print" data-print="print" data-viewdiv="reprint_received_handover" data-actionurl='.base_url('handover/handover_issue/handover_issue_reprint').' ><i class="fa fa-print"></i></a>';
				
				if($row->haov_isreceived=='Y'){
					$array[$i]["action"]=$view.' '.$reprint;
				}else{
					$array[$i]["action"]=$view;
				}
				
				$i++;

			}
			echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));

		}
public function handover_view_details()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$id = $this->input->post('id');

				if($id)
				{ 
					$this->data['issue_master'] = $this->handover_issue_mdl->get_handovermaster_date_id(array('hm.haov_handovermasterid'=>$id));
					// echo "<pre>";
					// print_r($this->data['issue_master']);
					// die();

					$this->data['all_issue_details'] = $this->handover_issue_mdl->get_all_handover_issue_details(array('haod_handovermasterid'=>$id));
					 // echo $this->db->last_query();die;
					  // echo"<pre>";print_r($this->data['all_issue_details']);die();
					if(defined('HANDOVER_LAYOUT_TYPE')):
							if(HANDOVER_LAYOUT_TYPE == 'DEFAULT'){
								$template=$this->load->view('handover/handover_issue/v_handover_issue_detail',$this->data,true);
							}else{
								$template=$this->load->view('handover/handover_issue/'.REPORT_SUFFIX.'/v_handover_issue_detail',$this->data,true);
							}
						else:
							$template=$this->load->view('handover/handover_issue/v_handover_issue_detail',$this->data,true);
						endif;

					if($this->data['issue_master']>0)
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
		
public function handover_received_save()
		{

			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$update_status  = $this->handover_issue_mdl->received_handover_status_change();
				if($update_status){

					print_r(json_encode(array('status'=>'success','message'=>' Received Successfully ')));
					exit;

				}

			else{
				print_r(json_encode(array('status'=>'error','message'=>'failed to update')));
				exit;

			}

		}else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
			exit;
		}
	}


public function handover_issue_summary()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		  // print_r($this->input->post());
		  // die();
			$frmDate = !empty($this->input->post('frmdate'))?$this->input->post('frmdate'):CURDATE_NP;
			$toDate = !empty($this->input->post('todate'))?$this->input->post('todate'):CURDATE_NP;
		// 	 $cond='';

		// if($frmDate){
		// 	    $cond .=" WHERE haov_postdatead >='".$frmDate."'";
		// }
		// if($toDate){
		// 		$cond .=" AND haov_postdatead <='".$toDate."'";
		// }else{
		// 	$cond .=" AND haov_postdatead <='".$frmDate."'";
		// }

			 $status_count = $this->handover_issue_mdl->getStatusCount(array('haov_handoverdatebs >='=>$frmDate, 'haov_handoverdatebs <='=>$toDate,'haov_locationid'=>$this->locationid),'cancel');
			// $this->data['status_count'] = $this->handover_issue_mdl->getColorStatusCount($cond);


		    // echo $this->db->last_query();
			print_r(json_encode(array('status'=>'success','status_count'=>$status_count)));
		}

	}

	public function handover_received_popup(){
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$id = $this->input->post('id');
			$this->data['handover_issue_details']=$this->handover_issue_mdl->get_handover_data(array('hm.haov_handovermasterid'=>$id));
			$this->data['depatrment']=$this->general->get_tbl_data('*','dept_department',false,'dept_depid','DESC');
			

		   // echo "<pre>";print_r($this->data['handover_issue_details']);die;
			if(defined('HANDOVER_LAYOUT_TYPE')){
				if(HANDOVER_LAYOUT_TYPE == 'DEFAULT'){
					$template=$this->load->view('handover/handover_issue/v_handover_issue_receive',$this->data,true);
				}else{
					$template=$this->load->view('handover/handover_issue/'.REPORT_SUFFIX.'/v_handover_issue_receive',$this->data,true);
				}}
				else{
					$template=$this->load->view('handover/handover_issue/v_handover_issue_receive',$this->data,true);
				}
				
				if(!empty($template))
				{
					print_r(json_encode(array('status'=>'success','message'=>'You Can view','tempform'=>$template)));
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

		public function generate_pdfIssueBookList()
		{
			$apptype = $this->input->get('apptype');
			if($apptype == 'cancel'){
				$this->data['searchResult'] = $this->handover_issue_mdl->get_issue_handover_list(array('sama_st'=>'C'));	
			}else if($apptype == 'issuereturn'){
				$this->data['searchResult'] = $this->handover_issue_mdl->get_issue_return_list(array('rema_st'=>'N'));
			}else if($apptype == 'returncancel'){
				$this->data['searchResult'] = $this->handover_issue_mdl->get_issue_return_list(array('rema_st'=>'C'));
			}else if($apptype == 'issue' || empty($apptype)){
				$this->data['searchResult'] = $this->handover_issue_mdl->get_issue_handover_list(array('sama_st'=>'N'));
			}
       // $this->data['searchResult'] = $this->stock_requisition_mdl->get_requisition_list();
			unset($this->data['searchResult']['totalfilteredrecs']);
			unset($this->data['searchResult']['totalrecs']);
			
			$html = $this->load->view('issue/v_new_issue_download', $this->data, true);
			
			$output = 'new_issue'.date('Y_m_d_H_i').'.pdf';
			
			$this->general->generate_pdf($html,'','');
		}
		public function exportToExcelIssueBookList(){
			header("Content-Type: application/xls");    
			header("Content-Disposition: attachment; filename=new_issue".date('Y_m_d_H_i').".xls");  
			header("Pragma: no-cache"); 
			header("Expires: 0");

        //$data = $this->issue_requisition_mdl->get_requisition_list();
			$apptype = $this->input->get('apptype');
			if($apptype == 'cancel'){
				$data = $this->handover_issue_mdl->get_issue_handover_list(array('sama_st'=>'C'));	
			}else if($apptype == 'issuereturn'){
				$data = $this->handover_issue_mdl->get_issue_return_list(array('rema_st'=>'N'));
			}else if($apptype == 'returncancel'){
				$data = $this->handover_issue_mdl->get_issue_return_list(array('rema_st'=>'C'));
			}else if($apptype == 'issue' || empty($apptype)){
				$data = $this->handover_issue_mdl->get_issue_handover_list(array('sama_st'=>'N'));
			}

        //$this->data['searchResult'] = $this->issue_requisition_mdl->get_requisition_list();
           		//$apptype = $this->input->get('apptype');
			if($apptype == 'cancel'){
				$this->data['searchResult'] = $this->handover_issue_mdl->get_issue_handover_list(array('sama_st'=>'C'));	
			}else if($apptype == 'issuereturn'){
				$this->data['searchResult'] = $this->handover_issue_mdl->get_issue_return_list(array('rema_st'=>'N'));
			}else if($apptype == 'returncancel'){
				$this->data['searchResult'] = $this->handover_issue_mdl->get_issue_return_list(array('rema_st'=>'C'));
			}else if($apptype == 'issue' || empty($apptype)){
				$this->data['searchResult'] = $this->handover_issue_mdl->get_issue_handover_list(array('sama_st'=>'N'));
			}

			$array = array();
			unset($this->data['searchResult']['totalfilteredrecs']);
			unset($this->data['searchResult']['totalrecs']);
			$response = $this->load->view('issue/v_new_issue_download', $this->data, true);


			echo $response;
		}
		public function reprint_handover_details()
		{
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$id = $this->input->post('id');
				if($id)
				{ 
					// $this->data['harm_handovermasterid'] = $id;

					$issue_master = $this->data['issue_master'] = $this->handover_issue_mdl->get_handovermaster_date_id(array('hm.haov_handovermasterid'=>$id));

					$this->data['all_issue_details'] = $this->handover_issue_mdl->get_all_handover_issue_details(array('haod_handovermasterid'=>$id));

					$harm_masterid_from_haov_id = $this->handover_issue_mdl->get_harm_data_from_haov_id($id);

					$this->data['harm_handovermasterid'] = $harm_masterid_from_haov_id[0]->harm_handovermasterid;

					$this->data['haov_username'] = $harm_masterid_from_haov_id[0]->haov_username;

					$this->data['harm_username'] = $harm_masterid_from_haov_id[0]->harm_username;

					$this->data['store']=$this->general->get_tbl_data('eqty_equipmenttype','eqty_equipmenttype',array('eqty_equipmenttypeid'=>$this->session->userdata(STORE_ID)),'eqty_equipmenttypeid','ASC');

				//signature
					$this->data['user_signature'] = $this->general->get_signature($this->userid);

					$approve_data = $this->handover_issue_mdl->get_approve_data($id);

					$approvedby = !empty($approve_data[0]->rema_approvedid)?$approve_data[0]->rema_approvedid:'';

					$this->data['approver_signature'] = $this->general->get_signature($approvedby);

					$issue_date = !empty($all_issue_details[0]->sama_billdatebs)?$all_issue_details[0]->sama_billdatebs:CURDATE_NP; 

					$store_head_id = $this->general->get_store_post_data($issue_date,'store_head');

					$this->data['store_head_signature'] = $this->general->get_signature($store_head_id);

				//echo "ok";die;

				if(defined('HANDOVER_REPORT_TYPE')):
					if(HANDOVER_REPORT_TYPE == 'DEFAULT'){
						$template=$this->load->view('handover/handover_issue/v_handover_issue_print',$this->data,true);
					}else{
						$template=$this->load->view('handover/handover_issue/'.REPORT_SUFFIX.'/v_handover_issue_print',$this->data,true);
					}
				else:
					$template=$this->load->view('handover/handover_issue/v_handover_issue_print',$this->data,true);
				endif;

				//print_r($this->data['issue_master']);die;

					if($this->data['issue_master']>0)
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
		}
		public function issue_details_views()
		{
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				if ($_SERVER['REQUEST_METHOD'] === 'POST') {
					$id = $this->input->post('id');
					$invoiceno = $this->input->post('invoiceno');
					$fyear = $this->input->post('fiscal_year');

					if($id)
					{ 
						$this->data['issue_master'] = $this->general->get_tbl_data('*','sama_salemaster',array('sama_salemasterid'=>$id),'sama_salemasterid','DESC');
						$this->data['issue_details'] = $this->handover_issue_mdl->get_issue_detail(array('sd.sade_salemasterid'=>$id));

						$this->data['all_issue_details'] = $this->handover_issue_mdl->get_all_issue_details($id, $invoiceno, $fyear);
					//echo $this->db->last_query();die;
					// echo"<pre>";print_r($this->data['all_issue_details']);die();
						$template=$this->load->view('issue/v_issue_details_view',$this->data,true);
						if($this->data['issue_master']>0)
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
		public function issue_cancel(){

			$this->data['tab_type']='cancel';

			$this->data['issue_no']=$this->generate_handover_issueno();
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
			->build('issue/v_new_issue', $this->data);
		}

		public function issue_cancel_item()
		{
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				try {
					$sade_id=$this->input->post('id');
			// echo $sade_id;
			// die();
					$sade_data=$this->handover_issue_mdl->get_issue_detail(array('sade_saledetailid'=>$sade_id));
			// echo "<pre>";
			// print_r($sade_data);
			// die();
					if(empty($sade_data))
					{
						print_r(json_encode(array('status'=>'error','message'=>'Unable to cancel this Item !!!')));
						exit;
					}
					else
					{
						$qty=$sade_data[0]->sade_qty;
						$mat_transdetailid=$sade_data[0]->sade_mattransdetailid;
						$iscancel=$sade_data[0]->sade_iscancel;
						if($iscancel=='Y')
						{
							print_r(json_encode(array('status'=>'error','message'=>'Already Cancel this Item !!!')));
							exit;
						}

						$update_sd=$this->handover_issue_mdl->update_salesdetail($sade_id);
						$mat_trans=$this->handover_issue_mdl->update_mat_trans_detailid($mat_transdetailid,$qty);

						print_r(json_encode(array('status'=>'success','message'=>'Successfully Cancelled !!!')));
						exit;

					}


				}catch (Exception $e) {
					print_r(json_encode(array('status'=>'error','message' => $e->getMessage())));
				}
			}
			else
			{
				print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
				exit;
			}
		}

		public function issue_cancel_item_all()
		{
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				try {
					$sama_id=$this->input->post('id');
			// echo $sama_id;
			// die();
					$sama_data=$this->handover_issue_mdl->get_issue_master(array('sama_salemasterid'=>$sama_id));
			// echo "<pre>";
			// print_r($sama_data);
			// die();

					$reqno = !empty($sama_data[0]->sama_requisitionno)?$sama_data[0]->sama_requisitionno:'';
					$fyear = !empty($sama_data[0]->sama_fyear)?$sama_data[0]->sama_fyear:'';
					$storeid = !empty($sama_data[0]->sama_storeid)?$sama_data[0]->sama_storeid:'';
					$locationid = !empty($sama_data[0]->sama_locationid)?$sama_data[0]->sama_locationid:'';
					$depid = !empty($sama_data[0]->sama_depid)?$sama_data[0]->sama_depid:'';

					if(empty($sama_data))
					{
						print_r(json_encode(array('status'=>'error','message'=>'Unable to cancel')));
						exit;
					}

					if($sama_data[0]->sama_st=='C')
					{
						print_r(json_encode(array('status'=>'error','message'=>'Already cancel this issue no!!')));
						exit;
					}
					else
					{

						$this->db->trans_begin();

						$this->handover_issue_mdl->update_salesmaster($sama_id);

						$sade_data=$this->handover_issue_mdl->get_issue_detail(array('sade_salemasterid'=>$sama_id));
				// echo "<pre>";
				// print_r($sade_data);
				// die();

				// $this->handover_issue_mdl->update_reqmaster($reqno,$fyear,$storeid,$depid,$locationid);

						if(!empty($sade_data))
						{
							foreach ($sade_data as $ksd => $sade) {
								$saledetailid=$sade->sade_saledetailid;
								$qty=$sade->sade_qty;
								$mat_transdetailidid=$sade->sade_mattransdetailid;
								$iscancel=$sade->sade_iscancel;
								$reqdetailid = $sade->sade_reqdetailid;

								if($iscancel!='Y')
								{
									$update_sd=$this->handover_issue_mdl->update_salesdetail($saledetailid);
								}

								if($mat_transdetailidid)
								{
									$mat_trans=$this->handover_issue_mdl->update_mat_trans_detailid($mat_transdetailidid,$qty);
								}

								if($reqdetailid){
									$update_reqdetail = $this->handover_issue_mdl->update_reqdetail($reqdetailid);
								}

							}
						}

						$this->db->trans_complete();
						if ($this->db->trans_status() === FALSE){
							$this->db->trans_rollback();
							trigger_error("Commit failed");
					// return false;
						}
						else{
							$this->db->trans_commit();
						}

						print_r(json_encode(array('status'=>'success','message'=>'Successfully Cancelled !!!')));
						exit;


					}


				}catch (Exception $e) {
					print_r(json_encode(array('status'=>'error','message' => $e->getMessage())));
				}
			}
			else
			{
				print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
				exit;
			}
		}
		public function issue_return(){

			$this->data['tab_type']='return';
			$this->data['fiscal'] = $this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','DESC');
			$this->data['return_issue_no']=$this->generate_return_invoiceno();
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
			->build('issue/v_new_issue', $this->data);
		}

		public function form_issue_return(){
			$this->data['tab_type']='return';
			$this->data['fiscal'] = $this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','DESC');
			$this->data['return_issue_no']=$this->generate_return_invoiceno();

			$this->load->view('issue/v_issue_return',$this->data);
		}

		public function issuelist_by_issue_no()
		{
			if ($_SERVER['REQUEST_METHOD'] === 'POST') 
			{
				if(MODULES_VIEW=='N')
				{

					print_r(json_encode(array('status'=>'error','message'=>$this->general->permission_denial_message())));
					exit;
				}

				$issue_no=$this->input->post('issue_no');
				$issue_date=$this->input->post('issue_date');
				$locationid=!empty($this->input->post('locationid'))?$this->input->post('locationid'):0;
				$this->storeid = $this->session->userdata(STORE_ID);

				if(DEFAULT_DATEPICKER=='NP')
				{
					$srchcol=array('sama_billdatebs'=>$issue_date,'sama_invoiceno'=>$issue_no,'sama_storeid'=>$this->storeid,'sama_locationid'=>$this->locationid);
				}
				else
				{
					$srchcol=array('sama_billdatead'=>$issue_date,'sama_invoiceno'=>$issue_no,'sama_storeid'=>$this->storeid,'sama_locationid'=>$this->locationid);
				}
				
				$this->data['issue_data']=$this->handover_issue_mdl->get_issue_master($srchcol);
				// echo $this->db->last_query();
				// die();
				// echo "<pre>";
				// print_r($this->data['issue_data']);
				// die();
				
				if(empty($this->data['issue_data'][0]))
				{
					print_r(json_encode(array('status'=>'error','message'=>'Cannot Cancel this issue.!!!')));
					exit;	
				}

				
				$this->data['issue_detail']=array();
				$tempform='';
				if($this->data['issue_data'])
				{
					$issuemasterid=$this->data['issue_data'][0]->sama_salemasterid;
					$this->data['issue_detail']=$this->handover_issue_mdl->get_issue_detail(array('sade_salemasterid'=>$issuemasterid));
				// 	// echo "<pre>";
				// 	// print_r($this->data['order_detail']);
				// 	// die();
					if($this->data['issue_detail'])
					{
						$tempform=$this->load->view('issue/v_issue_list_for_cancel',$this->data,true);
					}


				}
				print_r(json_encode(array('status'=>'success','issue_data'=>$this->data['issue_data'],'tempform'=>$tempform,'message'=>'Selected Successfully')));
				exit;	

			}
			else
			{
				print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
				exit;
			}
		}

		public function issuelist_by_issue_no_for_return()
		{
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$issue_no=$this->input->post('issue_no');
				$fiscalyrs=$this->input->post('fiscalyrs');
				$this->storeid=$this->session->userdata(STORE_ID);
				
				$srchcol=array('sama_fyear'=>$fiscalyrs,'sama_invoiceno'=>$issue_no,'sama_storeid'=>$this->storeid);			
				$this->data['issue_data']=$this->handover_issue_mdl->get_issue_master($srchcol);
				// echo "<pre>";
				// print_r($this->data['issue_data']);
				// die();
				// echo $this->db->last_query();
				// die();
				
				if(empty($this->data['issue_data']))
				{
					print_r(json_encode(array('status'=>'error','message'=>'Invalid Issue No.!!!')));
					exit;	
				}

				
				$this->data['issue_detail']=array();
				$tempform='';
				if($this->data['issue_data'])
				{
					$issuemasterid=$this->data['issue_data'][0]->sama_salemasterid;
					$this->data['issue_detail']=$this->handover_issue_mdl->get_issue_detail(array('sade_salemasterid'=>$issuemasterid));
					$this->data['issuemasterid']=$issuemasterid;
				// 	// echo "<pre>";
				// 	// print_r($this->data['order_detail']);
				// 	// die();
					if($this->data['issue_detail'])
					{
						$tempform=$this->load->view('issue/v_issue_list_for_return',$this->data,true);
					}


				}
				print_r(json_encode(array('status'=>'success','issue_data'=>$this->data['issue_data'],'tempform'=>$tempform,'message'=>'Selected Successfully')));
				exit;	

			}
			else
			{
				print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
				exit;
			}
		}

		public function exportToExcel(){
			header("Content-Type: application/xls");    
			header("Content-Disposition: attachment; filename=stock_requisition_".date('Y_m_d_H_i').".xls");  
			header("Pragma: no-cache"); 
			header("Expires: 0");

			$data = $this->store_requisition_mdl->get_store_requisition_list();

			$array = array();
			unset($data["totalfilteredrecs"]);
			unset($data["totalrecs"]);



			$response = '<table border="1">';
			$response .= '<tr><th colspan="7"><center>Store Requisition</center></th></tr>';
			$response .= '<tr><th >S.n.</th>
			<th>Req.No</th>
			<th>Req.Date(BS)</th>
			<th>Req.Date(AD)</th>
			<th>Req.Time</th>
			<th>Req.By</th>
			<th>F.Year</th>
			<th>Cost Center</th></tr>';

			$i=1;
			$iDisplayStart = !empty($_GET['iDisplayStart'])?$_GET['iDisplayStart']:0;
			foreach($data as $row){
				$sno = $iDisplayStart + $i; 
				$reqdatebs = $row->reno_reqdatebs;
				$reqdatead = $row->reno_reqdatead;
				$reqno = $row->reno_reqno;
				$reqtime = $row->reno_reqtime;
				$appliedby = $row->reno_appliedby;
				$fyear = $row->reno_fyear;
				$costcenter = $row->reno_costcenter;

				$response .= '<tr><td>'.$sno.'</td><td>'.$reqno.'</td><td>'.$reqdatebs.'</td><td>'.$reqdatead.'</td><td>'.$reqtime.'</td><td>'.$appliedby.'</td><td>'.$fyear.'</td><td>'.$costcenter.'</td></tr>';
				$i++;
			}

			$response .= '</table>';

			echo $response;
		}

		public function save_requisition()
		{
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				try {
					$id=$this->input->post('id');


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

					$this->form_validation->set_rules($this->store_requisition_mdl->validate_settings_requisition);
			// }

					if($this->form_validation->run()==TRUE)
					{

						$trans = $this->store_requisition_mdl->store_requisition_save();
						if($trans)
						{

							print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully')));
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
						print_r(json_encode(array('status'=>'error','message'=>validation_errors())));
						exit;
					}

				} catch (Exception $e) {

					print_r(json_encode(array('status'=>'error','message' => $e->getMessage())));
				}
			}
			else
			{
				print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
				exit;
			}
		}

		public function form_store_requisition()
		{
			$reqdata=$this->general->get_tbl_data('MAX(reno_reqno)+1 as maxreqno','reno_requisitionnote',array('reno_fyear'=>CUR_FISCALYEAR),false,false);
			$this->data['req_no']=!empty($reqdata[0]->maxreqno)?$reqdata[0]->maxreqno:'1';
			$this->load->view('store_requisition/store_requisition_form',$this->data);

		}
		public function generate_handover_issueno()
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

			$this->db->select('sama_invoiceno');
			$this->db->from('sama_salemaster');
			$this->db->where('sama_invoiceno LIKE '.'"%'.HANDOVER_NO_ISSUE_PREFIX.$prefix.'%"');
			$this->db->limit(1);
			$this->db->order_by('sama_invoiceno','DESC');
			$query = $this->db->get();
        // echo $this->db->last_query(); die();
			$invoiceno = 0;
			$dbinvoiceno='';
			if ($query->num_rows() > 0) 
			{
				$dbinvoiceno=$query->row()->sama_invoiceno;         
			}

			$invoiceno=$this->general->stringseperator($dbinvoiceno,'number');
			if(empty($invoiceno))
	      	{
	      		$invoiceno=0;
	      	}
			$nw_invoice = str_pad($invoiceno + 1, INVOICE_NO_LENGTH, 0, STR_PAD_LEFT);
			return HANDOVER_NO_ISSUE_PREFIX.$prefix.$nw_invoice;
		}



		public function generate_return_invoiceno()
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

			$this->db->select('rema_invoiceno');
			$this->db->from('rema_returnmaster');
			$this->db->where('rema_invoiceno LIKE '.'"%'.RETURN_NO_PREFIX.$prefix.'%"');
			$this->db->limit(1);
			$this->db->order_by('rema_invoiceno','DESC');
			$query = $this->db->get();
        // echo $this->db->last_query(); die();
			$dbinvoiceno='';
			if ($query->num_rows() > 0) 
			{
				$dbinvoiceno=$query->row()->rema_invoiceno;         
			}

			$invoiceno=$this->general->stringseperator($dbinvoiceno,'number');
			$nw_invoice = str_pad($invoiceno + 1, RETURN_NO_LENGTH, 0, STR_PAD_LEFT);
			return RETURN_NO_PREFIX.$prefix.$nw_invoice;
		}

		public function save_issue_return()
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
				// $postdata=$this->input->post();
	   			//  echo "<pre>";print_r($postdata);die();
					$returnqty=$this->input->post('returnqty');
					$cnttotalArray=count($returnqty);
					$uniqueCnt = 0;
					if($returnqty){
						$uniqueCnt=count(array_unique($returnqty));
					}

	   			// echo $uniqueCnt;
	   			// echo $cnttotalArray;
	   			// die();
					if($uniqueCnt==1 && $cnttotalArray>=2 )
					{
						print_r(json_encode(array('status'=>'error','message'=>'Atleast one returning Qty. should not be zero !')));
						exit;
					}
	   			// echo "<pre>";
	   			// print_r($returnqty);
	   			// die();

					$this->form_validation->set_rules($this->handover_issue_mdl->validate_issue_return);
					if($this->form_validation->run()==TRUE)
					{
						$trans = $this->handover_issue_mdl->save_issue_return();
						if($trans)
						{
							print_r(json_encode(array('status'=>'success','message'=>'Record Saved Successfully')));
							exit;
						}
						else
						{
							print_r(json_encode(array('status'=>'error','message'=>'Record Saved Successfully')));
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

		

		public function issue_returncancel(){

			$this->data['tab_type']='returncancel';

			$this->data['issue_no']=$this->generate_handover_issueno();
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
			->build('issue/v_new_issue', $this->data);
		}

		public function issuelist_by_return_no()
		{
			if ($_SERVER['REQUEST_METHOD'] === 'POST') 
			{

				if(MODULES_VIEW=='N')
				{

					print_r(json_encode(array('status'=>'error','message'=>$this->general->permission_denial_message())));
					exit;
				}

				$return_no=$this->input->post('return_no');
				$return_date=$this->input->post('return_date');
				$this->storeid=$this->session->userdata(STORE_ID);
				if(DEFAULT_DATEPICKER=='NP')
				{
					$srchcol=array('rema_returndatebs'=>$return_date,'rema_invoiceno'=>$return_no,'rema_storeid'=>$this->storeid,'rema_locationid'=>$this->locationid);
				}
				else
				{
					$srchcol=array('rema_returndatead'=>$return_date,'rema_invoiceno'=>$return_no,'rema_storeid'=>$this->storeid,'rema_locationid'=>$this->locationid);
				}

				$this->data['return_data']=$this->handover_issue_mdl->get_return_master_handover_issue($srchcol);

			// echo "<pre>";
			// print_r($this->data['return_data']);
			// die();

			// echo $this->db->last_query();
			// die();

				if(empty($this->data['return_data'][0]))
				{
					print_r(json_encode(array('status'=>'error','message'=>'Cannot Cancel this Return No.')));
					exit;	
				}


				$this->data['return_detail']=array();
				$tempform='';
				if($this->data['return_data'])
				{
					$returnmasterid=$this->data['return_data'][0]->rema_returnmasterid;
					$this->data['return_detail']=$this->handover_issue_mdl->get_return_detail(array('rede_returnmasterid'=>$returnmasterid));
			// 	// echo "<pre>";
			// 	// print_r($this->data['order_detail']);
			// 	// die();
					if($this->data['return_detail'])
					{
						$tempform=$this->load->view('issue/v_return_list_for_cancel',$this->data,true);
					}


				}
				print_r(json_encode(array('status'=>'success','return_data'=>$this->data['return_data'],'tempform'=>$tempform,'message'=>'Cancel Issue Return Successfully')));
				exit;	

			}
			else
			{
				print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
				exit;
			}
		}

		public function return_cancel_item_all()
		{
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				try {
					$rema_id=$this->input->post('id');
			// echo $rema_id;
			// die();
					$rema_data=$this->handover_issue_mdl->get_return_master_handover_issue(array('rema_returnmasterid'=>$rema_id));
			// echo "<pre>";
			// print_r($rema_data);
			// die();

					if(empty($rema_data))
					{
						print_r(json_encode(array('status'=>'error','message'=>'Unable to Cancel')));
						exit;
					}

					if($rema_data[0]->rema_st == 'C')
					{
						print_r(json_encode(array('status'=>'error','message'=>'Already cancel this receive no!!')));
						exit;
					}
					else
					{

						$this->handover_issue_mdl->update_returnmaster($rema_id);
						print_r(json_encode(array('status'=>'success','message'=>'Successfully Cancelled !!!')));
						exit;


					}


				}catch (Exception $e) {
					print_r(json_encode(array('status'=>'error','message' => $e->getMessage())));
				}
			}
			else
			{
				print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
				exit;
			}
		}

		public function return_cancel_item()
		{
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				try {
					$rede_id=$this->input->post('id');
			// echo $rede_id;
			// die();
					$rede_data=$this->handover_issue_mdl->get_return_detail(array('rede_returndetailid'=>$rede_id));
			// echo "<pre>";
			// print_r($rede_data);
			// die();
					if(empty($rede_data))
					{
						print_r(json_encode(array('status'=>'error','message'=>'Unable to cancel this Item !!!')));
						exit;
					}
					else
					{
						$qty=$rede_data[0]->rede_qty;
						$mat_transdetailid=$rede_data[0]->rede_mattransdetailid;
						$iscancel=$rede_data[0]->rede_iscancel;
						if($iscancel=='Y')
						{
							print_r(json_encode(array('status'=>'error','message'=>'Already Cancel this Item !!!')));
							exit;
						}

						$update_rd=$this->handover_issue_mdl->update_returndetail($rede_id);
						$mat_trans=$this->handover_issue_mdl->update_mat_trans_detailid($mat_transdetailid,$qty,'returncancel');

						print_r(json_encode(array('status'=>'success','message'=>'Successfully Cancelled !!!')));
						exit;

					}


				}catch (Exception $e) {
					print_r(json_encode(array('status'=>'error','message' => $e->getMessage())));
				}
			}
			else
			{
				print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
				exit;
			}
		}

		public function issue_requisition_views_details()
		{
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				if ($_SERVER['REQUEST_METHOD'] === 'POST') {
					$id = $this->input->post('id');
					$fyear = $this->input->post('fiscal_year');
					if($id)
					{ 
						$this->data['stock_requisition_details']=$this->requisition_mdl->get_requisition_master_data(array('rm.rema_reqno'=>$id,'rm.rema_fyear'=>$fyear));
					// print_r($this->data['stock_requisition_details']);
						$template='';
						if($this->data['stock_requisition_details']>0)
						{
							$mast_id=$this->data['stock_requisition_details'][0]->rema_reqmasterid;
						// echo $mast_id;
							$store_id=$this->data['stock_requisition_details'][0]->rema_storeid;
							$this->data['stock_requisition'] = $this->requisition_mdl->get_requisition_details_data(array('rd.rede_reqmasterid'=>$mast_id, 'rd.rede_isdelete' => 'N'),$store_id);
						 // echo $this->db->last_query();
							$template=$this->load->view('stock/v_stock_requistion_details',$this->data,true);

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
		public function generate_handoverno()
		{
			$handoverno=$this->general->generate_handover_issueno('haov_handoverno','haov_handoverno','haov_handovermaster',HANDOVER_NO_PREFIX,HANDOVER_NO_LENGTH);
			return $handoverno;
  	 // echo $this->db->last_query();
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
	 public function exportToExcelReqlist(){
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=stock_requisition".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");

        $data =$this->handover_issue_mdl->get_issue_handover_list();
       
	   $this->data['searchResult']  = $this->handover_issue_mdl->get_issue_handover_list();
	
        
        $array = array();
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);
        $response = $this->load->view('handover/handover_issue/kukl/v_handover_issue_table_download', $this->data, true);
        echo $response;
    }
    	public function generate_pdfReqlist()
    {
    	
			  $this->data['searchResult'] =$this->handover_issue_mdl->get_issue_handover_list();
	
        // $this->data['searchResult'] = $this->stock_requisition_mdl->get_requisition_list_kukl();
       
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);
        
        $html = $this->load->view('handover/handover_issue/kukl/v_handover_issue_table_download', $this->data, true);
        
        $output = 'handover'.date('Y_m_d_H_i').'.pdf';
        
        $this->general->generate_pdf($html,'','');
    }

    	public function generate_pdfDetail()
    {
    	
			  $this->data['searchResult'] =$this->handover_issue_mdl->get_handover_issue_book_details_list();
	
        // $this->data['searchResult'] = $this->stock_requisition_mdl->get_requisition_list_kukl();
       
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);
        
        $html = $this->load->view('handover/handover_issue/kukl/v_handover_issue_table_download', $this->data, true);
        
        $output = 'handover'.date('Y_m_d_H_i').'.pdf';
        
        $this->general->generate_pdf($html,'','');
    }

     public function exportToExcelDetail(){
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=stock_requisition".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");

        $data =$this->handover_issue_mdl->get_handover_issue_book_details_list();
       
	   $this->data['searchResult']  = $this->handover_issue_mdl->get_handover_issue_book_details_list();
	
        
        $array = array();
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);
        $response = $this->load->view('handover/handover_issue/kukl/v_handover_issue_table_download', $this->data, true);
        echo $response;
    }

    public function receive_handover_items(){
    	


		$trans = $this->handover_issue_mdl->receive_handover_items();

		// print_r($trans);
		// die();

		if($trans){

			  $this->data['handover_master'] = $this->general->get_tbl_data('*','hrem_handoverrecmaster',array('hrem_handoverrecmasterid'=>$trans),'hrem_handoverrecmasterid','DESC');

				$hovno = !empty($handover_master[0]->hrem_handoverno)?$handover_master[0]->hrem_handoverno:'';
			    $central_location = $this->general->get_tbl_data('loca_locationid','loca_location',array('loca_ismain'=>'Y'));
				$central_location_id = !empty($central_location[0]->loca_locationid)?$central_location[0]->loca_locationid:0;

				$mess_user = array('SK','SI');	

				$message = "Handover requisition no $trans has been received.";

				$mess_title = $mess_message = $message;

				$mess_path = 'issue_consumption/stock_requisition/requisition_list';

				$this->general->send_message_to_user($mess_user, $mess_title, $mess_message, $mess_path, 'G', $central_location_id);


			// Send Message back to supervisor
			// $message = "Recommendation from IT Department for $rema_reqno was submitted.";
			
			// $supervisor_id = $this->general->get_tbl_data('rema_reqto','rema_reqmaster',array('rema_reqmasterid'=>$rema_reqmasterid));

			// $mess_userid = $supervisor_id[0]->rema_reqto;

			// $mess_title = $mess_message = $message;

			// $mess_path = 'issue_consumption/stock_requisition/requisition_list';

			// $this->general->send_message_to_user($mess_userid, $mess_title, $mess_message, $mess_path, 'S');

			print_r(json_encode(array('status'=>'success','message'=>'Recommend qty was submitted.')));
		    exit;
		}else{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	    	exit;
		}
    }

public function handover_issue_reprint()
{
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$id = $this->input->post('id');
			if($id)
			{ 

			$issue_master = $this->data['issue_master'] = $this->handover_issue_mdl->get_handovermaster_date_id(array('hm.haov_handovermasterid'=>$id));
           // echo"<pre>";print_r($this->data['issue_master']);die();
			$this->data['all_issue_details'] = $this->handover_issue_mdl->get_all_handover_issue_details(array('haod_handovermasterid'=>$id));
			 // echo"<pre>";print_r($this->data['all_issue_details']);die();
			// $this->data['user_signature'] = $this->general->get_signature($this->userid);
				$approvedby = $issue_master[0]->haov_receivedby;
				$this->data['approver_signature'] = $this->general->get_signature($approvedby);
					// echo"<pre>";print_r($this->data['handover_issue_details']);die();
			$req_date = !empty($issue_master[0]->haov_reqdatebs)?$issue_master[0]->haov_reqdatebs:CURDATE_NP; 

			 $store_head_id = $this->general->get_store_post_data($req_date,'store_head');

			 // $this->data['store_head_signature'] = $this->general->get_signature($store_head_id);

			 $harm_data = $this->handover_issue_mdl->get_harm_data_from_haov_id($id);
			 $harm_username = !empty($harm_data[0]->harm_username)?$harm_data[0]->harm_username:'';
			 $haov_username = !empty($harm_data[0]->haov_username)?$harm_data[0]->haov_username:'';

			 $this->data['store_head_signature'] = $harm_username;

			 $this->data['user_signature'] = $haov_username;

			 $this->data['harm_handovermasterid'] = !empty($harm_data[0]->harm_handovermasterid)?$harm_data[0]->harm_handovermasterid:'';



				if(defined('HANDOVER_REPORT_TYPE')):
					if(HANDOVER_REPORT_TYPE == 'DEFAULT'){
						$template=$this->load->view('handover/handover_issue/v_handover_issue_print_list',$this->data,true);
					}else{
					$template=$this->load->view('handover/handover_issue/'.REPORT_SUFFIX.'/v_handover_issue_print_list',$this->data,true);
					}
				else:
					$template=$this->load->view('handover/handover_issue/v_handover_issue_print_list',$this->data,true);
				endif;

				if($this->data['all_issue_details']>0)
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

	}
	/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */