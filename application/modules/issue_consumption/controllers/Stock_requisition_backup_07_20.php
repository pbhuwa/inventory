<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Stock_requisition extends CI_Controller
{
	function __construct()
	{
			
		parent::__construct();
		$this->load->Model('stock_requisition_mdl');
		$this->locationid=$this->session->userdata(LOCATION_ID);
        $this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
        $this->storeid = $this->session->userdata(STORE_ID);
        $this->userid = $this->session->userdata(USER_ID);

        $this->username = $this->session->userdata(USER_NAME);
        $this->curtime = $this->general->get_currenttime();
        $this->mac = $this->general->get_Mac_Address();
        $this->ip = $this->general->get_real_ipaddr();
        $this->orgid=$this->session->userdata(ORG_ID);

        $this->usergroup = $this->session->userdata(USER_GROUPCODE);
        $this->userdept = $this->session->userdata(USER_DEPT);
	
		
	}
	public function index($type = 'entry')
	{
		// echo "sfdl";die;
		$id = $this->input->post('id');

		$this->data['tab_type'] = $type;

		if($id){
			$this->data['req_data'] = $this->stock_requisition_mdl->get_requisition_data(array('rede_isdelete'=>'N','rede_reqmasterid'=>$id));
		}else{
			$this->data['req_data'] = array();
		}

		// echo $this->db->last_query();
		// die();

		// $this->data['editurl']=base_url().'issue_consumption/stock_requisition/edit_stock_requisition';
		// $this->data['deleteurl']=base_url().'issue_consumption/stock_requisition/delete_requisition';
		// $this->data['listurl']=base_url().'issue_consumption/stock_requisition/list_requisition';

		$this->data['store_type'] = $this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttype','ASC');

		// $this->data['department']=$this->general->get_tbl_data('*','dept_department',false,'dept_depname','ASC');

		if(ORGANIZATION_NAME == 'KUKL'):
			$this->data['department'] = $this->stock_requisition_mdl->get_dept_by_user();
		else:
			$this->data['department']=$this->general->get_tbl_data('*','dept_department',false,'dept_depid','DESC');
		endif;
		// echo $this->db->last_query();
		// die();

		$this->data['supervisor_list'] = $this->stock_requisition_mdl->get_user_by_group_code();
	
		$this->data['requisition_no'] = $this->generate_stock_reqno();

		$get_approval_designation = $this->general->get_tbl_data('usma_appdesiid','usma_usermain',array('usma_userid'=>$this->userid));

		$approval_designation = $get_approval_designation[0]->usma_appdesiid;

		if($approval_designation){
			$approval_designation_array = explode(',',$approval_designation);	
		}else{
			$approval_designation_array = array();
		}

		 // $this->data['designation'] = $this->general->get_tbl_data('*','desi_designation');

	 	$this->data['designation'] = $this->stock_requisition_mdl->get_approval_designation_list($approval_designation_array);

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
		
		// $this->load->view('stock/v_stock_requisition', $this->data);
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('stock/v_stock_requisition', $this->data);
	}

	public function testemail()
	{	echo anchor('https://xelwel.com.np/biomedical', 'Click To visit Homepage', 'class="link-class"');die;
		$this->load->library('email');	
		$subject="Stock Requisition Details";
		$emailbody=" this is test email test";
		$from = 'info@xelwel.com.np';
		$to = 'kunwarsujan143@gmail.com';
		$this->email->from($to);
		$this->email->to($to);
		$this->email->subject($subject);
		//echo"<pre>"; print_r($emailbody); die;
		$this->email->message('Email:'.$from.' '.$emailbody);
		$this->email->send();
		echo $this->email->print_debugger();
	}

	public function save_requisition($print = false)
	{
		echo "Test";
			die();
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

			$this->form_validation->set_rules($this->stock_requisition_mdl->validate_settings_stock_requisition);


			if($this->form_validation->run()==TRUE)
			{   //echo "<pre>"; print_r($this->input->post());die;
				$trans = $this->stock_requisition_mdl->stock_requisition_save();
				if($trans)
				{		

					//error_reporting(0);
					    $report_data = $this->data['report_data'] = $this->input->post();
						$rema_reqfromdepid = !empty($report_data['rema_reqfromdepid'])?$report_data['rema_reqfromdepid']:'';
						$rema_reqtodepid = !empty($report_data['rema_reqtodepid'])?$report_data['rema_reqtodepid']:'';
						$dep = $this->input->post('rema_isdep');
						if($dep == "Y")
						{
							$this->data['from']=$this->general->get_tbl_data('*','dept_department',array('dept_depid'=>$rema_reqfromdepid),false,'DESC');
						}
						if($dep == "N")
						{
							$this->data['from']=$this->general->get_tbl_data('*','eqty_equipmenttype',array('eqty_equipmenttypeid'=>$rema_reqfromdepid),false,'DESC');
						}
						$this->data['tostore']=$this->general->get_tbl_data('*','eqty_equipmenttype',array('eqty_equipmenttypeid'=>$rema_reqtodepid),false,'DESC');
						//print_r($this->data['tostore']);die;
						if(!empty($itemid)):
							foreach($itemid as $key=>$it):
								$itemid = !empty($report_data['rede_itemsid'][$key])?$report_data['rede_itemsid'][$key]:'';
								$unitid = !empty($report_data['puit_unitid'][$key])?$report_data['puit_unitid'][$key]:'';
								
							endforeach;
						endif;
					$email = $this->load->view('stock/v_print_report_email', $this->data, true);

					// //print_r($email);die;
					// $this->load->library('email');	
					// $subject="Stock Requisition Details";
					// $emailbody=$email;//" this is test email test";
					// $from = 'info@xelwel.com.np';
					// $to = 'kunwarsujan143@gmail.com';//sudipmzn@gmail.com paparatzi2@gmail.com  
					// $this->email->from($to);
					// $this->email->to($to);
					// $this->email->subject($subject);
					// //echo"<pre>"; print_r($emailbody); die;
					// $this->email->message('Email:'.$from.' '.$emailbody);
					// $this->email->send();
						
					if($print = "print")
					{	

						$stock_requisition_details = $this->data['stock_requisition_details'] = $this->general->get_tbl_data('*','rema_reqmaster',array('rema_reqmasterid'=>$trans),'rema_reqmasterid','DESC');
						$this->data['stock_requisition'] = $this->stock_requisition_mdl->get_requisition_data(array('rd.rede_reqmasterid'=>$trans));
						// echo "<pre>";
						// print_r($this->data['stock_requisition']);
						// die();

						$this->data['user_signature'] = $this->general->get_signature($this->userid);

						$approvedby = $stock_requisition_details[0]->rema_approvedid;

						$this->data['approver_signature'] = $this->general->get_signature($approvedby);

						$req_date = !empty($stock_requisition_details[0]->rema_reqdatebs)?$stock_requisition_details[0]->rema_reqdatebs:CURDATE_NP; 

						$store_head_id = $this->general->get_store_post_data($req_date,'store_head');

						$this->data['store_head_signature'] = $this->general->get_signature($store_head_id);
						$this->data['requisition_no'] = $this->generate_stock_reqno();
						

						if(STOCK_REQ_REPORT_TYPE == 'DEFAULT'){
							$print_report = $this->load->view('stock/v_print_report_issue', $this->data, true);
						}else{
							$print_report = $this->load->view('stock/v_print_report_issue'.'_'.REPORT_SUFFIX, $this->data, true);
						}

						//echo "<pre>"; print_r($print_report);die;

						// send message to supervisor on demand form save
						$rema_reqno = !empty($stock_requisition_details[0]->rema_reqno)?$stock_requisition_details[0]->rema_reqno:'';

						if($this->usergroup == 'DM'){
							$mess_user = array('DS');	
						}else{
							$approval_designation_id = $stock_requisition_details[0]->rema_reqtodesignation;

							if($approval_designation_id):
								$approval_designation_id_array = explode(',',$approval_designation_id);
							else:
								$approval_designation_id_array = array();
							endif;

							$approval_userlist = $this->general->get_tbl_data('usma_userid','usma_usermain',false,false,false, $approval_designation_id_array);

							$mess_user_array = $approval_userlist;
						}

						$message = "New Demand Request No. $rema_reqno generated.";

						$mess_title = $mess_message = $message;

						$mess_path = 'issue_consumption/stock_requisition/requisition_list';

						// $this->general->send_message_to_user($mess_user, $mess_title, $mess_message, $mess_path, 'G');

						foreach($mess_user_array as $mess){
							$mess_user = $mess->usma_userid;
							$this->general->send_message_to_user($mess_user, $mess_title, $mess_message, $mess_path, 'U');
						}

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

	public function form_stock_requisition($type = 'entry',$id = false){
		$id = $this->input->post('id');

		$this->data['tab_type'] = $type;

		$this->data['is_approval_modal'] = 'N';

		$this->data['req_data'] = $this->stock_requisition_mdl->get_requisition_data(array('rede_isdelete'=>'N','rema_reqmasterid'=>$id));

		// echo $this->db->last_query();
		// die();

		// $this->data['editurl']=base_url().'issue_consumption/stock_requisition/edit_stock_requisition';
		// $this->data['deleteurl']=base_url().'issue_consumption/stock_requisition/delete_requisition';
		// $this->data['listurl']=base_url().'issue_consumption/stock_requisition/list_requisition';
		$this->data['equipmentcategory']=$this->general->get_tbl_data('*','eqca_equipmentcategory',false,'eqca_equipmentcategoryid','DESC');

		$this->data['store_type'] = $this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttype','ASC');

		if(ORGANIZATION_NAME == 'KUKL'):
			$this->data['department'] = $this->stock_requisition_mdl->get_dept_by_user();
		else:
			$this->data['department']=$this->general->get_tbl_data('*','dept_department',false,'dept_depid','DESC');
		endif;

		
		$this->data['item_all']=$this->general->get_tbl_data('*','itli_itemslist',false,'itli_itemlistid','DESC');
		$this->data['requisition_no'] = $this->generate_stock_reqno();

		// $this->load->view('stock/v_stockrequisition_form',$this->data);
		
		 if(defined('STOCK_REQ_FORM_TYPE')):
            if(STOCK_REQ_FORM_TYPE == 'DEFAULT'){
                $this->load->view('stock/v_stockrequisition_form',$this->data);
            }else{
                $this->load->view('stock/'.REPORT_SUFFIX.'/v_stockrequisition_form',$this->data);
            }
        else:
            $this->load->view('issue/v_stockrequisition_form',$this->data);
        endif;
                   
	}

	public function requisition_list()
	{
		// echo "<pre>";print_r('hyy');die();   
		$this->data['tab_type']='list';
	    $frmDate = CURDATE_NP;
    	$toDate = CURDATE_NP;
    	$cur_fiscalyear = CUR_FISCALYEAR;
    	$this->data['fiscalyear'] = $this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','DESC'); 
		$this->data['status_count'] = $this->stock_requisition_mdl->getStatusCount(array('rema_reqdatebs >='=>$frmDate, 'rema_reqdatebs <='=>$toDate));
		
		$this->data['total_count'] = $this->stock_requisition_mdl->getRemCount(array('rema_reqdatebs >='=>$frmDate, 'rema_reqdatebs <='=>$toDate));
		$seo_data='';
		if(ORGANIZATION_NAME == 'KUKL'):
			$this->data['department'] = $this->stock_requisition_mdl->get_dept_by_user();
		else:
			$this->data['department']=$this->general->get_tbl_data('*','dept_department',false,'dept_depid','DESC');
		endif;
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
			->build('stock/v_stock_requisition', $this->data);

	}

	public function stock_requisition_details()
	{
		$this->data['tab_type']='details';
	    $frmDate = CURDATE_NP;
    	$toDate = CURDATE_NP;
    	$cur_fiscalyear = CUR_FISCALYEAR;
    	$this->data['fiscalyear'] = $this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','DESC'); 
		$this->data['status_count'] = $this->stock_requisition_mdl->getStatusCount(array('rema_reqdatebs >='=>$frmDate, 'rema_reqdatebs <='=>$toDate));
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
			->build('stock/v_stock_requisition', $this->data);
	}
	public function requisition_details_lists()
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
	  	$data = $this->stock_requisition_mdl->get_requisition_details_list();
	  	// echo $this->db->last_query();die();
	 	//echo"<pre>";print_r($data);die;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];
	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
		  	foreach($data as $row)
		    {
			    // $array[$i]["rede_reqdetailid"] = '<a href="javascript:void(0)" class="patlist" data-patientid='.$row->rede_reqdetailid.'>'.$row->rede_reqdetailid.'</a>';
		    	$array[$i]["rema_reqno"] = $row->rema_reqno;
		    	$array[$i]["postdatead"] = $row->rema_reqdatead;
		    	$array[$i]["postdatebs"] = $row->rema_reqdatebs;
			   	$array[$i]["itli_itemcode"] = $row->itli_itemcode;
			    $array[$i]["itli_itemname"] = $row->itli_itemname;
			    $array[$i]["itli_itemnamenp"] = $row->itli_itemnamenp;
			    $array[$i]["rema_fyear"] = $row->rema_fyear;
			    $array[$i]["rede_qty"] = $row->rede_qty;
			    $array[$i]["rede_remqty"] = $row->rede_remqty;
			    $array[$i]["issueqty"] = $row->rede_qty - $row->rede_remqty;
			    $array[$i]["rede_remarks"] = $row->rede_remarks;
			    //$array[$i]["itli_itemname"] = $row->itli_itemname;
			  
			    $i++;
		    }
		    //echo"<pre>";print_r($data);die;
		    $get = $_GET;
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}
	public function view_requisition()
	{
		if($_SERVER['REQUEST_METHOD'] === 'POST') {
		$mastid_id=$this->input->post('id');
		$this->data['requistion_data']=$this->stock_requisition_mdl->get_requisition_master_data(array('rm.rema_reqmasterid'=>$mastid_id));
		// echo $this->db->last_query();echo $id;die();
		$this->data['req_detail_list'] = $this->stock_requisition_mdl->get_requisition_details_data(array('rd.rede_reqmasterid'=>$mastid_id,'rd.rede_isdelete'=>'N'));
		//echo "<pre>";print_r($this->data['req_detail_list']);die();


		$this->data['handover_status'] = $this->general->get_tbl_data('harm_currentstatus','harm_handoverreqmaster',array('harm_reqmasterid'=>$mastid_id),'harm_handovermasterid','DESC');

		// echo "Test";
		// print_r($this->data['handover_status']);
		// die();


		$tempform='';

		if(defined('STOCK_DEMAND_LIST')):
            if(STOCK_DEMAND_LIST == 'DEFAULT'){
                $tempform=$this->load->view('stock/v_stock_requistion_view',$this->data,true);
            }else{
            	
            	$tempform=$this->load->view('stock/'.REPORT_SUFFIX.'/v_stock_requistion_view',$this->data,true);
            }
        else:
            $tempform=$this->load->view('stock/v_stock_requistion_view',$this->data,true);
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

	public function verification_requisition($id=false,$reqno=false)
	{
		$masterid=$this->general->get_tbl_data('rema_reqmasterid','rema_reqmaster',array('rema_reqno'=>$reqno),false,'DESC');
			if($id == "2")
			{
				$status = "2";
			}
			if($id == "1")
			{
				$status = "1";
			}
			//print_r($status);die;
			$trans  = $this->stock_requisition_mdl->stock_requisition_change_status_email($status,$masterid[0]->rema_reqmasterid);
			if($trans)
			{
				echo "Change  Status Successfully";
				echo anchor('https://xelwel.com.np/biomedical', 'Click To visit Homepage', 'class="link-class"');
				//print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully')));
				exit;
			}
			else
			{
				print_r(json_encode(array('status'=>'error','message'=>'Record Save Successfully')));
				exit;
			}
	}

	public function change_status()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if(MODULES_APPROVE=='N')
			{
 				print_r(json_encode(array('status'=>'error','message'=>$this->general->permission_denial_message())));
				exit;
			}

			$reqno = $this->input->post('reqno');
			$masterid = $this->input->post('masterid');
			$approve_post_status = $this->input->post('approve_status');

			if($approve_post_status=='')
			{
				print_r(json_encode(array('status'=>'error','message'=>'You Need to Select Atleast One Option !!! ')));
				exit;
			}
			
			$status='';
			if($approve_post_status == "2")
			{
				$status = "2";
			}
			if($approve_post_status == "1")
			{
				$status = "1";
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
			$trans  = $this->stock_requisition_mdl->stock_requisition_change_status($status);
			if($trans)
			{
				if($status == '4'):
					// send message to storekeeper on verified
					$mess_user = array('SI','SK');

					$message = "Demand No. $reqno is verified.";

					$mess_title = $mess_message = $message;

					$mess_path = 'issue_consumption/stock_requisition/requisition_list';

					$this->general->send_message_to_user($mess_user, $mess_title, $mess_message, $mess_path, 'G');
				elseif($status == '3'):
					// send message to demander about cancel
					$get_post_by = $this->general->get_tbl_data('rema_postby','rema_reqmaster',array('rema_reqmasterid'=>$masterid));

					$mess_user = $get_post_by[0]->rema_postby;

					$message = "Demand No. $reqno is cancelled.";

					$mess_title = $mess_message = $message;

					$mess_path = 'issue_consumption/stock_requisition/requisition_list';

					$this->general->send_message_to_user($mess_user, $mess_title, $mess_message, $mess_path, 'S');
				endif;

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

	public function requisition_lists()
	{
		// $apptype=$this->input->post('apptype');
	 //    echo $apptype;die;
			// If search from datatable then 

		// echo $_SERVER['HTTP_REFERER'];
		// die();

		// echo MODULES_UPDATE;
		// die();
		// $this->general->check_permission_module();
		// echo $this->db->last_query();
		// die();

		// echo MODULES_VERIFIED;
		// echo MODULES_APPROVE;
		// die();

		
		if(MODULES_VIEW=='N')
		{
			$array=array();
		
			// $this->general->permission_denial_message();
			echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));			
			exit;
		}
	
		// die();
		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);
		$i = 0;
	  	$data = $this->stock_requisition_mdl->get_requisition_list();
	  	$this->data['requisition_no'] = $this->generate_stock_reqno();
	   // echo $this->db->last_query();die();
	  	// echo"<pre>";print_r($data);die;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];
	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
	  	$view_heading_var=$this->lang->line('stock_requisition_details');
	  	$approve_heading_var=$this->lang->line('requisition_information');
	  	$recommend_qty_view_group = array('SA','DM','DS');

		  	foreach($data as $row)
		    {
		    	$isdep=$row->rema_isdep;

		    	if($isdep=='N')
		    	{
		    		$frm_dep=$row->fromdep_transfer;
		    	}
		    	else
		    	{
		    		$frm_dep=$row->depfrom; 
		    	}
		    	$appclass='';
		    	$approved=$row->rema_approved;

		    	$recommend_status = $row->rema_recommendstatus;

		    	if($approved=='0')
		    	{
		    		$appclass='pending';
		    	}
		    	if($approved=='1')
		    	{
		    		$appclass='approved';
		    	}
		    	if($approved=='2')
		    	{
		    		$appclass='unapproved';
		    	}
		    	
		    	if($approved=='3')
		    	{
		    		$appclass='cancel';
		    	}

		    	if($approved=='4')
		    	{
		    		$appclass='verified';
		    	}

		    	$approvedby = $row->rema_approvedby;
		    	if(defined('APPROVEBY_TYPE')):
			    	if(APPROVEBY_TYPE == 'USER'){
			    		$approvedby = $row->rema_approvedby;
			    	}else{
			    		$approvedby = (defined('APPROVER_USERNAME') && !empty($row->rema_approvedby))?APPROVER_USERNAME:$row->rema_approvedby;
			    	}
		    	endif;

		    	if($row->rema_recommendstatus == 'R'){
		    		$recommendstatus = 'Recomm.';
		    	}else if($row->rema_recommendstatus == 'A'){
		    		$recommendstatus = 'Accepted';
		    	}else if($row->rema_recommendstatus == 'D'){
		    		$recommendstatus = 'Declined';
		    	}else{
		    		$recommendstatus = '';
		    	}
		    	// $array[$i]['viewurl']=base_url().'issue_consumption/stock_requisition/load_stock_requisition_popup';
		    	$array[$i]['viewurl']=base_url().'issue_consumption/stock_requisition';
		    	$array[$i]["prime_id"] = $row->rema_reqmasterid;
			    $array[$i]["rema_reqmasterid"] = '<a href="javascript:void(0)" class="patlist" data-patientid='.$row->rema_reqmasterid.'>'.$row->rema_reqmasterid.'</a>';
			    $array[$i]["reqno"] = $row->rema_reqno;
			   	$array[$i]["approvedclass"] = $appclass;
			    $array[$i]["manualno"] = $row->rema_manualno;
			    $array[$i]["fromdep"] = $frm_dep;
			    $array[$i]["todep"] = $row->depto;
			    $array[$i]["username"] = $row->rema_username;
			  	$array[$i]["cntitem"]='<a href="javascript:void(0)" data-id='.$row->rema_reqmasterid.' data-displaydiv="orderDetails" data-viewurl='.base_url('issue_consumption/stock_requisition/stock_requisition_views_details').' class="view  btn-xxs" data-heading="'.$view_heading_var.'">'.$row->cntitem.'</a>';
			    $array[$i]["isdep"] = ($row->rema_received == 1)?'Y':'N';
			    $array[$i]["reqby"] = $row->rema_reqby;
			    $array[$i]["approvedby"] = $approvedby;
			    $array[$i]["remarks"] = $row->rema_remarks;
			    $array[$i]["fyear"] = $row->rema_fyear;
			    $array[$i]["postdatead"] = $row->rema_reqdatead;
			    $array[$i]["postdatebs"] = $row->rema_reqdatebs;
			    $array[$i]['recommend_status'] = $recommendstatus;

			    $edit_allowed_group = array('DM','SA');
			    
			    if($approved=='0' && MODULES_UPDATE =='Y' && in_array($this->usergroup, $edit_allowed_group))
		    	{

		    		$editbtn='<a href="javascript:void(0)" data-id='.$row->rema_reqmasterid.' data-displaydiv="stockreqform" data-viewurl='.base_url('issue_consumption/stock_requisition').' class="btnredirect btn-info btn-xxs" data-heading="View Stock Requisition" title="Edit"  ><i class="fa fa-edit " aria-hidden="true" ></i></a>';
		    	}
		    	else
		    	{
		    		$editbtn='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		    	}
		    	
		    	if(MODULES_VERIFIED=='Y' || MODULES_APPROVE=='Y')
		    	{
		    		$approvedbtn='<a href="javascript:void(0)" title="Verified/Approved" data-viewurl='.base_url('issue_consumption/stock_requisition/view_requisition').' data-heading="'.$approve_heading_var.'"  class="view  btn-success btn-xxs" data-id='.$row->rema_reqmasterid.'><i class="fa fa-check-square-o" aria-hidden="true"></i></a>';
		    	}
		    	else
		    	{
		    		$approvedbtn='';
		    	}

			    $array[$i]["action"] = $editbtn.' '.$approvedbtn.'<a href="javascript:void(0)" data-id='.$row->rema_reqmasterid.' data-displaydiv="orderDetails" data-viewurl='.base_url('issue_consumption/stock_requisition/stock_requisition_views_details').' class="view btn-primary btn-xxs" data-heading="'.$view_heading_var.'"><i class="fa fa-eye" aria-hidden="true" ></i></a> ';
			    $i++;
		    }
		    $get = $_GET;
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}
	public function generate_pdfReqlist_details()
    {
        $this->data['searchResult'] = $this->stock_requisition_mdl->get_requisition_details_list();
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);
        $this->load->library('pdf');
        $mpdf = $this->pdf->load();
        //echo"<pre>";print_r($this->data['searchResult']);die;
        ini_set('memory_limit', '256M');
        $html = $this->load->view('stock/v_stock_requisition_download_details', $this->data, true);
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
        $output = 'stock_requisition_details'.date('Y_m_d_H_i').'.pdf';
        $mpdf->Output();
        exit();
    }
    public function exportToExcelReqlistDetails()
    {
    	header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=stock_requisition_details".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");

        $data = $this->stock_requisition_mdl->get_requisition_details_list();

        $this->data['searchResult'] = $this->stock_requisition_mdl->get_requisition_details_list();
        
        $array = array();
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);
        $response = $this->load->view('stock/v_stock_requisition_download_details', $this->data, true);


        echo $response;
    }
	public function generate_pdfReqlist()
    {
    	
        $this->data['searchResult'] = $this->stock_requisition_mdl->get_requisition_list();
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);
        $this->load->library('pdf');
        $mpdf = $this->pdf->load();
        //echo"<pre>";print_r($this->data['searchResult']);die;
        ini_set('memory_limit', '256M');
        $html = $this->load->view('stock/v_stock_requisition_download', $this->data, true);
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
        $output = 'stock_requisition'.date('Y_m_d_H_i').'.pdf';
        $mpdf->Output();
        exit();
    }
    public function exportToExcelReqlist(){
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=stock_requisition".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");

        $data = $this->stock_requisition_mdl->get_requisition_list();

        $this->data['searchResult'] = $this->stock_requisition_mdl->get_requisition_list();
        
        $array = array();
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);
        $response = $this->load->view('stock/v_stock_requisition_download', $this->data, true);
        echo $response;
    }
	public function stock_requisition_views_details()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$id = $this->input->post('id');
				if($id)
				{ 
					$this->data['stock_requisition_details']=$this->stock_requisition_mdl->get_requisition_master_data(array('rm.rema_reqmasterid'=>$id));
					// print_r($this->data['stock_requisition_details']);
					$template='';
					if($this->data['stock_requisition_details']>0)
					{
						$store_id=$this->data['stock_requisition_details'][0]->rema_storeid;
						$this->data['stock_requisition'] = $this->stock_requisition_mdl->get_requisition_details_data(array('rd.rede_reqmasterid'=>$id, 'rd.rede_isdelete' => 'N'),$store_id);
						// echo $this->db->last_query();
						// die();

						if(defined('STOCK_DEMAND_LIST')):
	                        if(STOCK_DEMAND_LIST == 'DEFAULT'){
	                            $template=$this->load->view('stock/v_stock_requistion_details',$this->data,true);
	                        }else{
	                        	$template=$this->load->view('stock/'.REPORT_SUFFIX.'/v_stock_requistion_details',$this->data,true);
	                        }
	                    else:
	                        $template=$this->load->view('stock/v_stock_requistion_details',$this->data,true);
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

	public function stock_requisition_reprint()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$id = $this->input->post('id');
				if($id)
				{ 
					$requisition_data = $this->data['stock_requisition_details'] = $this->general->get_tbl_data('*','rema_reqmaster',array('rema_reqmasterid'=>$id),'rema_reqmasterid','DESC');
					$this->data['stock_requisition'] = $this->stock_requisition_mdl->get_requisition_data(array('rd.rede_reqmasterid'=>$id));

					$this->data['user_signature'] = $this->general->get_signature($this->userid);

					$approvedby = $requisition_data[0]->rema_approvedid;

					$this->data['approver_signature'] = $this->general->get_signature($approvedby);
					//echo"<pre>";print_r($this->data['stock_requisition_details']);die();

					$req_date = !empty($stock_requisition_details[0]->rema_reqdatebs)?$stock_requisition_details[0]->rema_reqdatebs:CURDATE_NP; 

					$store_head_id = $this->general->get_store_post_data($req_date,'store_head');

					$this->data['store_head_signature'] = $this->general->get_signature($store_head_id);

					if(STOCK_REQ_REPORT_TYPE == 'DEFAULT'){
						$template=$this->load->view('stock/v_print_report_issue',$this->data,true);
					}else{
						$template=$this->load->view('stock/v_print_report_issue'.'_'.REPORT_SUFFIX,$this->data,true);
					}

					// print_r($template);die;
				if($this->data['stock_requisition']>0)
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
					
					$status_count = $this->stock_requisition_mdl->getStatusCount(array('rema_reqdatebs >='=>$frmDate, 'rema_reqdatebs <='=>$toDate,'rema_locationid'=>$input_locationid));

					$total_count = $this->stock_requisition_mdl->getRemCount(array('rm.rema_reqdatebs >='=>$frmDate, 'rm.rema_reqdatebs <='=>$toDate,'rm.rema_locationid'=>$input_locationid));
				}
				else
				{
					$status_count = $this->stock_requisition_mdl->getStatusCount(array('rema_reqdatebs >='=>$frmDate, 'rema_reqdatebs <='=>$toDate));
					$total_count = $this->stock_requisition_mdl->getRemCount(array('rm.rema_reqdatebs >='=>$frmDate, 'rm.rema_reqdatebs <='=>$toDate));
				}

			}
			else
			{
				$status_count = $this->stock_requisition_mdl->getStatusCount(array('rema_reqdatebs >='=>$frmDate, 'rema_reqdatebs <='=>$toDate,'rema_locationid'=>$this->locationid));
				$total_count = $this->stock_requisition_mdl->getRemCount(array('rm.rema_reqdatebs >='=>$frmDate, 'rm.rema_reqdatebs <='=>$toDate,'rm.rema_locationid'=>$this->locationid));
			}

		    
		    // echo $this->db->last_query();
		    print_r(json_encode(array('status'=>'success','status_count'=>$status_count,'total_count'=>$total_count)));
		}
	}

	public function get_dept_list(){
		try{
			$cur_storeid = $this->session->userdata(STORE_ID);
			$type = $this->input->post('type');

			if($type == 'issue'){
				$selected = '';

				if(ORGANIZATION_NAME == 'KUKL'):
					$department = $this->stock_requisition_mdl->get_dept_by_user();

					$count_dep = count($department);
				
					if($count_dep == '1'):
						$selected = 'selected';
					endif;
				else:
					$department = $this->general->get_tbl_data('*','dept_department',false,'dept_depid','DESC');
				endif;

				$store_type = $this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttype','ASC');

				$fromdepid = "<option value=''>---select---</option>";
				if(!empty($department)):
					foreach($department as $dep):
						$fromdepid .= "<option value='$dep->dept_depid' $selected>$dep->dept_depname</option>";
					endforeach;
				endif;

				$todepid = "";
				if(!empty($store_type)):
					foreach($store_type as $dep):
						if($this->storeid == $dep->eqty_equipmenttypeid){
							$is_selected = "selected";
						}else{
							$is_selected = "";
						}
						$todepid .= "<option value='$dep->eqty_equipmenttypeid' $is_selected>$dep->eqty_equipmenttype</option>";
					endforeach;
				endif;

			}else if($type == 'transfer'){

				$fromdepid_data = $this->general->get_tbl_data('*','eqty_equipmenttype',array('eqty_equipmenttypeid'=>$cur_storeid),'eqty_equipmenttype','ASC');

				$todepid_data = $this->general->get_tbl_data('*','eqty_equipmenttype',array('eqty_equipmenttypeid !='=>$cur_storeid),'eqty_equipmenttype','ASC');

				$fromdepid = "<option value=''>---select---</option>";
				if(!empty($fromdepid_data)):
					foreach($fromdepid_data as $dep):
						$fromdepid .= "<option value='$dep->eqty_equipmenttypeid' selected='selected'>$dep->eqty_equipmenttype</option>";
					endforeach;
				endif;

				$todepid = "";
				if(!empty($todepid_data)):
					foreach($todepid_data as $dep):
						if($this->storeid == $dep->eqty_equipmenttypeid){
							$is_selected = "selected";
						}else{
							$is_selected = "";
						}
						$todepid .= "<option value='$dep->eqty_equipmenttypeid' $is_selected>$dep->eqty_equipmenttype</option>";
					endforeach;
				endif;
			}

			print_r(json_encode(array('status'=>'success','from_depid'=>$fromdepid, 'to_depid'=>$todepid,'type'=>$type)));
			exit;
		}catch(Exception $e){
			echo $e->getMessage();
		}
	}

	public function get_req_no(){
		try{
			$cur_fiscalyear = CUR_FISCALYEAR;

			$depid = !empty($this->input->post('depid'))?$this->input->post('depid'):$this->storeid;
			$type = !empty($this->input->post('type'))?$this->input->post('type'):'issue';	

			$reqno = $this->generate_stock_reqno();

			print_r(json_encode(array('status'=>'success','reqno'=>$reqno,'depid'=>$depid,'type'=>$type)));
			exit;

		}catch(Exception $e){
			echo $e->getMessage();
		}
	}

	public function load_stock_requisition_popup($rema_id = false)
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			try {	
				$id = $this->input->post('id');

				$this->data['id']=$id;
				$this->data['is_approval_modal'] = 'Y';

				$this->data['req_data'] = $this->stock_requisition_mdl->get_requisition_data(array('rede_isdelete'=>'N','rede_reqmasterid'=>$id));

				$this->data['equipmentcategory']=$this->general->get_tbl_data('*','eqca_equipmentcategory',false,'eqca_equipmentcategoryid','DESC');

				$this->data['store_type'] = $this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttype','ASC');

				$this->data['department']=$this->general->get_tbl_data('*','dept_department',false,'dept_depid','DESC');
				$this->data['item_all']=$this->general->get_tbl_data('*','itli_itemslist',false,'itli_itemlistid','DESC');
				$this->data['requisition_no'] = $this->generate_stock_reqno();

				$tempform=$this->load->view('stock/v_stockrequisition_form',$this->data,true);

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
	
	public function demand_analysis()
	{
		$this->data['store_type'] = $this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttype','ASC');
		$this->data['department'] = $this->general->get_tbl_data('*','dept_department',false,'dept_depid','ASC');
		
		$this->data['tab_type']='demand_analysis';

	    $frmDate = CURDATE_NP;
    	$toDate = CURDATE_NP;

		$this->data['status_count'] = $this->stock_requisition_mdl->getStatusCount(array('rema_reqdatebs >='=>$frmDate, 'rema_reqdatebs <='=>$toDate));
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
			->build('stock/v_stock_requisition', $this->data);

	}

	public function demand_analysis_lists()
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
	  	$cond="";
	  	$st_store_id = $this->input->post('st_store_id');
	  	$depid = $this->input->post('depid');
	  	$store_id = $this->input->post('store_id');
	  	$data = $this->stock_requisition_mdl->get_demand_analysis_list();
	  
	
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

			    $array[$i]["itli_itemlistid"] = $row->itli_itemlistid;
			    $array[$i]["rema_reqdatead"] = $row->rema_reqdatead;
			    $array[$i]["rema_reqdatebs"] = $row->rema_reqdatebs;
			   	$array[$i]["itli_itemcode"] = $row->itli_itemcode;
			    $array[$i]["itli_itemname"] = $req_itemname;
			    $array[$i]["demandqty"] = $row->demandqty; 
			    $array[$i]["stockqty"] = $row->stockqty;
			    $array[$i]["diff"] = $row->diff;
			   
			    $i++;
		    }
		    $get = $_GET;
		
		   
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}
	public function generate_pdfDemand()
    {
    	
        $this->data['searchResult'] = $this->stock_requisition_mdl->get_demand_analysis_list();
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);
        $this->load->library('pdf');
        $mpdf = $this->pdf->load();
        //echo"<pre>";print_r($this->data['searchResult']);die;
        ini_set('memory_limit', '256M');
        $html = $this->load->view('stock/v_stock_requisition_download', $this->data, true);
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
        $output = 'stock_requisition'.date('Y_m_d_H_i').'.pdf';
        $mpdf->Output();
        exit();
    }
    public function exportToExcelDemand(){
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=stock_requisition".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");

        $data = $this->stock_requisition_mdl->get_demand_analysis_list();

        $this->data['searchResult'] = $this->stock_requisition_mdl->get_demand_analysis_list();
        
        $array = array();
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);
        $response = $this->load->view('stock/v_stock_requisition_download', $this->data, true);


        echo $response;
    }

	public function demand_analysis_form_dropdown()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$type =$this->input->post('id');
			// $this->data['department'] = '';
			// $this->data['store_type'] = '';
			$this->data['type'] = $type;
			if($type == "transfer")
			{
				$this->data['store_type'] = $this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttype','ASC');
			}
			if($type == "issue")
			{
				$this->data['department'] = $this->general->get_tbl_data('*','dept_department',false,'dept_depid','ASC');
			}
			$template = $this->load->view('stock/v_stock_partial_form',$this->data,true);
			//echo"<pre>"; print_r($template);die;
			if(!empty($this->data['store_type']) || !empty($this->data['department']))
						{
								print_r(json_encode(array('status'=>'success','message'=>'success','template'=>$template)));
				            	exit;
						}
						else{
							print_r(json_encode(array('status'=>'error','message'=>'Error While Choosing Data!!')));
				            	exit;
						}
			}
			else
			{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}
	}

	public function monthlywise_dep_req()
	{

		$this->data['tab_type'] ='monthlywise_dep_req';
		$seo_data='';
		$this->data['fiscalyear']=$this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','ASC');
		$this->data['store']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','ASC');
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
			->build('stock/v_stock_requisition', $this->data);
	}
	public function monthlywise_dep_req_lists()
	{ 
	 	$get = $_GET;  
		$store_id = !empty($get['store_id'])?$get['store_id']:'0';
        $fyear = !empty($get['fiscal_year'])?$get['fiscal_year']:CUR_FISCALYEAR;
        // echo $fyear;
        // die();
        $apstatus=!empty($get['appstatus'])?$get['appstatus']:'';
        $locationid = !empty($get['locationid'])?$get['locationid']:$this->session->userdata(LOCATION_ID);
		
		if(MODULES_VIEW=='N')
			{
			$array=array();
		
			echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));			
			exit;
			}
	
		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);
	  	$i = 0;
	  	$deptreq='';
	  	$this->data['department']=$this->general->get_tbl_data('*','dept_department',false,'dept_depid','ASC');
	  	
	  	$data = $this->stock_requisition_mdl->get_department_wise_data();
	  	//echo"<pre>";print_r($data);die;
	  	// echo $this->db->last_query();die();
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
			  	foreach($data as $row)
			    {
			    	$totalallloc=0;	
			   		$array[$i]["sno"] = $i+1;
			   		$array[$i]['depid'] = $row->depid;
			   		$array[$i]['dept_depname'] = $row->dept_depname;
			   		$sum_all_data=0;
			   		for ($j=1; $j <=12 ; $j++) {
			   			$rwdep=('mdr'.$j);
			   			$monthname = $this->general->getNepaliMonth($j);
			   			$mnthr = !empty($row->{$rwdep})?$row->{$rwdep}:'';
			   			$array[$i]['mdr'.$j] ='<a href="javascript:void(0)" data-yrs='.$row->yrs.' data-appstatus="'.$apstatus.'" data-month='.$j.' data-locationid='.$row->locationid.'  data-fyear="'.$fyear.'" data-store_id='.$store_id.' data-id='.$row->depid.' data-displaydiv="IssueDetails" data-viewurl='.base_url('issue_consumption/stock_requisition/view_deails_requisition').' class="view" data-heading="Requisition Monthly Details '.$monthname.'" title="Requisition Monthly Details '.$monthname.'">'.$mnthr.'</a>';
			   		$sum_all_data +=$mnthr;

			   		}
			   		$array[$i]['total_all']=$sum_all_data;
				   	$array[$i]['totalallloc']=$totalallloc;
				    $i++;
			    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}
	public function view_deails_requisition()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$id = $this->input->post('id');
				// $appstatus = $this->input->post('appstatus');
				// $month = $this->input->post('month');
				// $yrs = $this->input->post('yrs');
				// if($month < 10)
				// {
				// 	$nyrs ='0'.$month;
				// }else{
				// 	$nyrs =$month;
				// }
				// $year = "$yrs/$nyrs";
				if($id)
				{ 
					//echo"<pre>"; print_r($this->input->post());die;
					
					//print_r($srch);die;
					$this->data['details_requisition_department'] = $this->stock_requisition_mdl->get_requisition_data_department_wise();
					
					// echo $this->db->last_query(); die();
					// echo"<pre>";print_r($this->data['details_requisition_department']);die();
					$template=$this->load->view('stock/v_stock_requistion_monthly_popup',$this->data,true);
					
					//$template=$this->load->view('stock/v_stock_requistion_details',$this->data,true);
					if($this->data['details_requisition_department']>0)
					{
							print_r(json_encode(array('status'=>'success','message'=>'','tempform'=>$template)));
			            	exit;
					}
					else{
						print_r(json_encode(array('status'=>'error','message'=>'No record Found!!')));
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
	public function generate_pdfRequisitionMonthly()
    {
    	//locationid appstatus store_id fiscal_year
        $this->data['searchResult'] = $this->stock_requisition_mdl->get_department_wise_data();
        //echo"<pre>";print_r($this->input->get());die;
        //echo"<pre>";print_r($this->data['searchResult']);die;
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);
        $this->load->library('pdf');
        $mpdf = $this->pdf->load();
        
        ini_set('memory_limit', '256M');
        $html = $this->load->view('stock/v_stock_requisition_monthly_download', $this->data, true);
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
        $output = 'pdfRequisitionMonthly_'.date('Y_m_d_H_i').'.pdf';
        $mpdf->Output();
        exit();
    }
    public function exportToExcelRequisitionMonthly(){
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=stock_requisition".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");
        $data = $this->stock_requisition_mdl->get_department_wise_data();

        $this->data['searchResult'] = $this->stock_requisition_mdl->get_department_wise_data();
        
        $array = array();
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);
        $response = $this->load->view('stock/v_stock_requisition_monthly_download', $this->data, true);
        echo $response;
    }

    public function list_of_reqby()
	{
	    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
	    {
			try {
				$data['reqby_list'] = $this->stock_requisition_mdl->get_all_reqby(false,10,false,'rema_reqmasterid','ASC');
				  // echo "<pre>";
				  // print_r($data);
				  // die();
				$template=$this->load->view('issue_consumption/stock/list_of_reqby',$data,true);
		        
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

    public function demand_print_form()
	{
		$this->data['issue_master'] = $this->general->get_tbl_data('*','rema_reqmaster',array('rema_reqmasterid'=>'29'),'rema_reqmasterid','DESC');
		$this->data['stock_requisition'] = $this->stock_requisition_mdl->get_requisition_data(array('rd.rede_reqmasterid'=>'29'));
		$print_report = $this->load->view('stock/v_print_report_issue_kukl', $this->data, true);
		echo $print_report;
		die();
	}



	public function generate_stock_reqno()
	{
		//req no without location code
		$reqno = '';
		$cur_fiscalyear = CUR_FISCALYEAR;
		$depid = !empty($this->input->post('depid'))?$this->input->post('depid'):$this->storeid;
		$type = !empty($this->input->post('type'))?$this->input->post('type'):'issue';	

		if($type == 'transfer'){
			$get_reqno = $this->stock_requisition_mdl->get_req_no(array('rema_isdep'=>'N','rema_fyear'=>$cur_fiscalyear, 'rema_locationid'=>$this->locationid));	
		}else if($type=='issue'){
			$get_reqno = $this->stock_requisition_mdl->get_req_no(array('rema_reqtodepid'=>$depid,'rema_fyear'=>$cur_fiscalyear, 'rema_locationid' => $this->locationid));
		}else{
			$get_reqno = $this->stock_requisition_mdl->get_req_no(array('rema_reqtodepid'=>$depid,'rema_fyear'=>$cur_fiscalyear, 'rema_locationid' => $this->locationid));
		}

		if(!empty($get_reqno)){
			$reqno = !empty($get_reqno[0]->reqno)?$get_reqno[0]->reqno+1:1;
		}

	    if(defined('SHOW_FORM_NO_WITH_LOCATION')){
			if(SHOW_FORM_NO_WITH_LOCATION == 'Y'){

						//req no with location code
			  	$location_data = $this->general->get_tbl_data('loca_code','loca_location',array('loca_locationid'=>$this->locationid));

				$location_code = !empty($location_data[0]->loca_code)?$location_data[0]->loca_code:'';

				$prefix = $location_code;

			  	$this->db->select('rema_reqno');
			  	$this->db->from('rema_reqmaster');
			  	$this->db->where('rema_reqno LIKE '.'"%'.$prefix.'%"');
			  	$this->db->where('rema_locationid',$this->locationid);
			  	$this->db->limit(1);
			  	$this->db->order_by('rema_reqno','DESC');
			  	$query = $this->db->get();
			        // echo $this->db->last_query(); die();
			  	$invoiceno=0;
			  	$dbinvoiceno='';
		      
		        if ($query->num_rows() > 0) 
		        {
		            $dbinvoiceno=$query->row()->rema_reqno;         
		        }
		        if(!empty($dbinvoiceno))
		        {
		        	  $invoiceno=$this->general->stringseperator($dbinvoiceno,'number');
		        }

			    $nw_invoice = str_pad($invoiceno + 1, RECEIVED_NO_LENGTH, 0, STR_PAD_LEFT);

				return $prefix.'-'.$nw_invoice;
			}else{
				return $reqno;
			}
		}else{
			return $reqno;
		}
    }

/*FOR KUKL*/
public function requisition_summary_view(){
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
					
					$status_count = $this->stock_requisition_mdl->getStatusCount(array('rema_reqdatebs >='=>$frmDate, 'rema_reqdatebs <='=>$toDate,'rema_locationid'=>$input_locationid));

					$total_count = $this->stock_requisition_mdl->getRemCount(array('rm.rema_reqdatebs >='=>$frmDate, 'rm.rema_reqdatebs <='=>$toDate,'rm.rema_locationid'=>$input_locationid));
				}
				else
				{
					$status_count = $this->stock_requisition_mdl->getStatusCount(array('rema_reqdatebs >='=>$frmDate, 'rema_reqdatebs <='=>$toDate));
					$total_count = $this->stock_requisition_mdl->getRemCount(array('rm.rema_reqdatebs >='=>$frmDate, 'rm.rema_reqdatebs <='=>$toDate));
				}

			}
			else
			{
				$status_count = $this->stock_requisition_mdl->getStatusCount(array('rema_reqdatebs >='=>$frmDate, 'rema_reqdatebs <='=>$toDate,'rema_locationid'=>$this->locationid));
				$total_count = $this->stock_requisition_mdl->getRemCount(array('rm.rema_reqdatebs >='=>$frmDate, 'rm.rema_reqdatebs <='=>$toDate,'rm.rema_locationid'=>$this->locationid));
			}

		    
		    // echo $this->db->last_query();
		    print_r(json_encode(array('status'=>'success','status_count'=>$status_count,'total_count'=>$total_count)));
		}
}

public function view_requisition_mdl()
	{
		if($_SERVER['REQUEST_METHOD'] === 'POST') {
		$mastid_id=$this->input->post('id');
		$this->data['requistion_data']=$this->stock_requisition_mdl->get_requisition_master_data(array('rm.rema_reqmasterid'=>$mastid_id));
		// echo $this->db->last_query();echo $id;die();
		$this->data['req_detail_list'] = $this->stock_requisition_mdl->get_requisition_details_data(array('rd.rede_reqmasterid'=>$mastid_id,'rd.rede_isdelete'=>'N'));
		//echo "<pre>";print_r($this->data['req_detail_list']);die();
		$tempform='';
		$tempform=$this->load->view('stock/v_stock_requistion_view',$this->data,true);
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

	public function update_recommend_qty(){
		$recommend_qty = $this->input->post('all_recommend_qty');

		$items_id = $this->input->post('all_items_id');

		$rema_reqmasterid = $this->input->post('rema_reqmasterid');

		$rema_reqno = $this->input->post('rema_reqno');

		$trans = $this->stock_requisition_mdl->update_recommend_qty($items_id, $recommend_qty, $rema_reqmasterid);

		
		if($trans){
			//Send Message
			$message = "Recommend qty for Req No. $rema_reqno was updated.";

			$get_post_by = $this->general->get_tbl_data('rema_postby','rema_reqmaster',array('rema_reqmasterid'=>$rema_reqmasterid));

			$mess_userid = $get_post_by[0]->rema_postby;

			$mess_title = $mess_message = $message;

			$mess_path = 'issue_consumption/stock_requisition/requisition_list';

			$this->general->send_message_to_user($mess_userid, $mess_title, $mess_message, $mess_path,'S');

			print_r(json_encode(array('status'=>'success','message'=>'Recommend qty was submitted.')));
		    exit;
		}else{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	    	exit;
		}

	}

	public function verify_recommend_qty(){
		$recommend_qty = $this->input->post('all_recommend_qty');

		$items_id = $this->input->post('all_items_id');

		$rema_reqmasterid = $this->input->post('rema_reqmasterid');

		$rema_reqno = $this->input->post('rema_reqno');

		$recommendation_status = $this->input->post('recommendation_status');

		$trans = $this->stock_requisition_mdl->verify_recommend_qty($items_id, $recommend_qty, $rema_reqmasterid, $recommendation_status);

		if($trans){
			//Send Message
			if($recommendation_status == 'A'){
				$message = "Recommend qty for $rema_reqno was accepted.";
			}else{
				$message = "Recommend qty for $rema_reqno was declined.";
			}
			
			$get_post_by = $this->general->get_tbl_data('rema_recommendby','rema_reqmaster',array('rema_reqmasterid'=>$rema_reqmasterid));

			$mess_userid = $get_post_by[0]->rema_recommendby;

			$mess_title = $mess_message = $message;

			$mess_path = 'issue_consumption/stock_requisition/requisition_list';

			$this->general->send_message_to_user($mess_userid, $mess_title, $mess_message, $mess_path, 'S');

			print_r(json_encode(array('status'=>'success','message'=>'Recommend qty was submitted.')));
		    exit;
		}else{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	    	exit;
		}
		
	}

	public function proceed_to_issue(){
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$items_id = $this->input->post('itemlist');

			$rema_reqmasterid = $this->input->post('masterid');

			$status = '1';

			foreach($items_id as $key=>$item){
				$itemArray = array(
					'rede_proceedissue' =>'Y',
					'rede_proceedtype' => 'I'
				);

				$this->db->where('rede_reqmasterid',$rema_reqmasterid);
				$this->db->where('rede_itemsid',$items_id[$key]);
				$this->db->update('rede_reqdetail',$itemArray);
			}

			$trans  = $this->stock_requisition_mdl->stock_requisition_change_status($status);
			if($trans)
			{
				print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully')));
				exit;
			}
			else
			{
				print_r(json_encode(array('status'=>'error','message'=>'Operation Error')));
				exit;
			}
		}else
	    {
	      	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	    	exit;
	    }
	}

	public function proceed_to_procurement(){
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$trans  = $this->stock_requisition_mdl->proceed_to_procurement();

			if($trans)
			{
				// send message to proceed to procurement

				$mess_user = array('PR');

				$message = "Procurement Request No. $trans generated.";

				$mess_title = $mess_message = $message;

				$mess_path = 'issue_consumption/stock_requisition/requisition_list';

				$this->general->send_message_to_user($mess_user, $mess_title, $mess_message, $mess_path, 'G');

				print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully')));
				exit;
			}
			else
			{
				print_r(json_encode(array('status'=>'error','message'=>'Operation Error')));
				exit;
			}
		}else
	    {
	      	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	    	exit;
	    }
	}


/* End KUKL */

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */