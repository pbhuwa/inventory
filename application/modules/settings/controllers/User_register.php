<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User_register extends CI_Controller
{
	function __construct()
	{

		parent::__construct();
		$this->load->Model('user_register_mdl');
		$this->load->Model('department_mdl');
		$this->load->Model('group_mdl');
		 //$this->load->Model('designation_mdl');
		$this->load->Model('location_mdl');
		$this->locationid=$this->session->userdata(LOCATION_ID);
		$this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
		

	}
	
	public function index()
	{
		$this->data['department']=$this->general->get_tbl_data('*','dept_department',false,'dept_depid','DESC');
		// $frmDate = CURMONTH_DAY1;
		// $toDate= CURDATE_NP;
	   
  //         $cond='';

		// if($frmDate){
		// 	$cond .=" WHERE usre_postdatebs >='".$frmDate."'";
		// }
		// if($toDate){
		// 		$cond .=" AND usre_postdatebs <='".$toDate."'";
		// }else{
		// 	$cond .=" AND usre_postdatebs <='".$frmDate."'";
		// }

	    $this->data['status_count'] = $this->user_register_mdl->getColorStatusCount();
		$this->data['total_count'] = $this->user_register_mdl->getRemCount();

		$this->data['meta_keys']= '';
		$this->data['meta_desc']= '';
		
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
		->build('user_register/v_user_register', $this->data);
	}

	public function exists_username()
	{
		
		$usre_username=$this->input->post('usre_username');
		$input_id=$this->input->post('id');
		$username=$this->user_register_mdl->check_exit_username_for_other($usre_username,$input_id);
		if($username)
		{
			$this->form_validation->set_message('exists_username', 'Alreay Exit Username.');
			return false;

		}
		else
		{
			return true;
		}

	}
	public function reister_user_list()
	{	
		
		$data = $this->user_register_mdl->get_user_register_list();
		  // echo "<pre>"; print_r($data); die();
		$i = 0;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

		unset($data["totalfilteredrecs"]);
		unset($data["totalrecs"]);
		foreach($data as $row)
		{
			$id=$row->usre_userid;
			$status=$row->usre_status;
			
             $color_codeclass=$this->user_register_mdl->getColorStatusCount();
		    	 foreach ($color_codeclass as $key => $color) {

		    	 	if($status==$color->coco_statusval)
		         	{
		    		$appclass=$color->coco_statusname;
		    		$status_class='<span class="badge badge-'.$color->coco_button.'">'.$color->coco_displaystatus.'</span>';
		    
		    	     }
		    	 }
			// if($status==0){
			// 	$status_class='<span class="badge badge-secondary">Pending </span>';
			// }
			// if($status==1){
			// 	$status_class='<span class="badge badge-success">Approve</span>';
			// }
			// if($status==2){
			// 	$status_class='<span class="badge badge-danger">Cancelled</span>'	;
			// }
			// if($status==3){
			// 	$status_class='<span class="badge badge-danger">Cancelled</span>'	;
			// }


			

			if($row->usre_isactive=='1'){
				$status_classcolor = "btn btn-success ";
				$status="Yes";
			} else {
				$status_classcolor = "btn btn-danger ";
				$status="No";
			}


				$array[$i]["sno"] = $i+1;
				$array[$i]["usre_username"] = $row->usre_username;
				$array[$i]["usre_fullname"] = $row->usre_fullname;
				$array[$i]["usre_departmentid"] = $row->dept_depname;
				$array[$i]["usre_phoneno"] = $row->usre_phoneno;
				$array[$i]["usre_postdatebs"] = $row->usre_postdatebs;
				$array[$i]["usre_postdatead"] = $row->usre_postdatead;
				$array[$i]["status"] = $status_class;

				if($row->usre_status==1){
					$array[$i]["isactive"]='<button type="button" class="'. $status_classcolor.' bs_change_status" data-placement="bottom" data-toggle="confirmation" id="bs_change_status" data-viewurl='.base_url('settings/user_register/UpdateUserStatus/').' data-status = '.$row->usre_isactive.' data-id='.$row->usre_userid.'>'.ucfirst($status).'</button>';

				}
				else{
					$array[$i]["isactive"]='';

				}


				$this->data['registr_data']=$this->user_register_mdl->get_all_user_reg(array('usre_userid'=>$id));
				$username=$row->usre_username;
				$check_name=$this->user_register_mdl->exit_user_name($username);
				if($check_name==true && $status==1){
					$array[$i]["action"] ='';
				}else{
					$array[$i]["action"] = '<a href="javascript:void(0)" data-id='.$row->usre_userid.' data-displaydiv="UserDetails" data-viewurl='.base_url('settings/user_register/user_register_views/').' class="view btn-primary btn-xxs" data-heading="View User Reg. Details"  ><i class="fa fa-eye " aria-hidden="true" ></i></a>';
				}
				$i++;

			}
			echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
		}

		public function user_register_views(){

			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$this->data=array();
				$id = $this->input->post('id');
				$this->data['registr_data']=$this->user_register_mdl->get_all_user_reg(array('usre_userid'=>$id));
				
				$username=$this->data['registr_data'][0]->usre_username;
				$this->data['check_name']=$this->user_register_mdl->exit_user_name($username);
				$this->data['designation'] = $this->general->get_tbl_data('*','desi_designation');
				$this->data['group_all']=$this->user_register_mdl->get_all_group_reg();
				$this->data['registr_data']=$this->user_register_mdl->get_all_user_reg(array('usre_userid'=>$id));

				$this->data['designation'] = $this->general->get_tbl_data('*','desi_designation');
				


		 // echo "<pre>";print_r($this->data['status_count']);die;
				$tempform=$this->load->view('user_register/v_user_register_view',$this->data,true);
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
		public function change_status_user()
		{

			if ($_SERVER['REQUEST_METHOD'] === 'POST') {

				$status = $this->input->post('user_status');
				$userid=$this->input->post('userid');

				if($status=='')
				{
					print_r(json_encode(array('status'=>'error','message'=>'You Need to Select Atleast One Option !!! ')));
					exit;
				}
				if($status==1){
					$status_value=0;
					$update_isactive  = $this->updateStatus($status_value,$userid);
				}
				else{
					$status_value=1;
					$update_isactive  = $this->updateStatus($status_value,$userid);

				}
				$this->data['registr_data']=$this->user_register_mdl->get_all_user_reg(array('usre_userid'=>$userid));
				$username=$this->data['registr_data'][0]->usre_username;
				$check_name=$this->data['check_name']=$this->user_register_mdl->exit_user_name($username);
				if($check_name==true){
					print_r(json_encode(array('status'=>'success','message'=>'Already Approved user')));
					exit;

				}else{

					$update_status  = $this->user_register_mdl->status_change_user_register($status,$userid);
					if($update_status)
					{  
						if($status==1){
					
						

							$save=$this->user_reg_to_user_save();
							if($save){



								print_r(json_encode(array('status'=>'success','message'=>'User Approved Successfully ')));
								exit;

							}

						}else{
							print_r(json_encode(array('status'=>'success','message'=>'Record update')));
							exit;

						}

					}

					else
					{
						print_r(json_encode(array('status'=>'error','message'=>'Record Save Successfully')));
						exit;
					}
				}
			}else
			{
				print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
				exit;
			}
		}
		public function UpdateUserStatus()
		{

			if ($_SERVER['REQUEST_METHOD'] === 'POST') {


				$id=$this->input->post('id');
				$status=$this->input->post('current_status');
				 // echo $id;die;

				$tran  = $this->updateStatus($status,$id);
				if($tran)
				{  
					

					print_r(json_encode(array('status'=>'success','message'=>'Update Successfully ')));
					exit;

				}

				else
				{
					print_r(json_encode(array('status'=>'error','message'=>'Operation Failed!!')));
					exit;
				}

			}else
			{
				print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
				exit;
			}
		}
		
		public function updateStatus($status,$id)
		{
			if(!empty($id)) {
				if($status==1){
					$status_val=0;
				}
				else{
					$status_val=1;
				}
				$postdata = array(
					'usre_isactive'=>$status_val,
					'usre_modifydatead'=>CURDATE_EN,
					'usre_modifydatebs'=> CURDATE_NP,
					'usre_modifytime'=>date('H:i:s'),
					'usre_modifymac'=>$this->general->get_real_ipaddr(),
					'usre_modifyip'=>$this->general->get_Mac_Address(),
					'usre_inactivedatebs'=>CURDATE_NP,
					'usre_inactivedatead'=>CURDATE_EN
				);
				$this->db->update('usre_userregister',$postdata,array('usre_userid'=>$id));
   // echo  $this->db->last_query();die;
				$rowaffected=$this->db->affected_rows();
				if($rowaffected)
				{
					return $rowaffected;
				}
				else
				{
					return false;
				}
			}
		}

		public function user_reg_to_user_save(){

			$userid = $this->input->post('userid');
			$this->data['reg_data']=$this->user_register_mdl->get_all_user_reg(array('usre_userid'=>$userid));

	     // echo "<pre>";print_r($this->data['reg_data']);die();

			$user_name=$this->data['reg_data'][0]->usre_username;
			$pass=$this->data['reg_data'][0]->usre_userpassword;
			$salt =$this->general->salt();	
			$password=$this->general->hash_password($pass,$salt);
			$postdata['usma_userpassword']=$password; 
			$postdata['usma_salt']=$salt;
			$postdata['usma_username']=$this->data['reg_data'][0]->usre_username;
			$postdata['usma_email']=$this->data['reg_data'][0]->usre_email;
			$postdata['usma_desiid']=$this->data['reg_data'][0]->usre_desiid;
			$postdata['usma_fullname']=$this->data['reg_data'][0]->usre_fullname; 
			$postdata['usma_fullnamenp']=$this->data['reg_data'][0]->usre_fullnamenp;
			$postdata['usma_isactive']=$this->data['reg_data'][0]->usre_isactive; 
			$postdata['usma_departmentid']=$this->data['reg_data'][0]->usre_departmentid;
			$postdata['usma_dashboard']=$this->data['reg_data'][0]->usre_dashboard;
			$postdata['usma_phoneno']=$this->data['reg_data'][0]->usre_phoneno; 
			$postdata['usma_signaturepath']=$this->data['reg_data'][0]->usre_signaturepath;
			$postdata['usma_usergroupid']=$this->data['reg_data'][0]->usre_usergroupid; 
			$postdata['usma_orgid']=$this->data['reg_data'][0]->usre_orgid;
			$postdata['usma_textimage']=$this->data['reg_data'][0]->usre_textimage; 
			$postdata['usma_islogin']=$this->data['reg_data'][0]->usre_islogin;
			$postdata['usma_logindatead']=$this->data['reg_data'][0]->usre_logindatead; 
			$postdata['usma_logindatebs']=$this->data['reg_data'][0]->usre_logindatebs; 
			$postdata['usma_logintime']=$this->data['reg_data'][0]->usre_logintime; 
			$postdata['usma_loginmac']=$this->data['reg_data'][0]->usre_loginmac;
			$postdata['usma_loginip']=$this->data['reg_data'][0]->usre_loginip;
			$postdata['usma_logoutdatead']=$this->data['reg_data'][0]->usre_logoutdatead;
			$postdata['usma_logoutdatebs']=$this->data['reg_data'][0]->usre_logoutdatebs; 
			$postdata['usma_logouttime']=$this->data['reg_data'][0]->usre_logouttime;
			$postdata['usma_postdatead']=$this->data['reg_data'][0]->usre_postdatead; 
			$postdata['usma_postdatebs']=$this->data['reg_data'][0]->usre_postdatebs;
			$postdata['usma_posttime']=$this->data['reg_data'][0]->usre_posttime; 
			$postdata['usma_postby']=$this->data['reg_data'][0]->usre_postby; 
			$postdata['usma_postmac']=$this->data['reg_data'][0]->usre_postmac; 
			$postdata['usma_postip']=$this->data['reg_data'][0]->usre_postip;
			$postdata['usma_modifydatead']=$this->data['reg_data'][0]->usre_modifydatead;
			$postdata['usma_modifydatebs']=$this->data['reg_data'][0]->usre_modifydatebs; 
			$postdata['usma_modifytime']=$this->data['reg_data'][0]->usre_modifytime;
			$postdata['usma_modifyby']=$this->data['reg_data'][0]->usre_modifyby;
			$postdata['usma_modifymac']=$this->data['reg_data'][0]->usre_modifymac; 
			$postdata['usma_modifyip']=$this->data['reg_data'][0]->usre_modifyip; 
			$postdata['usma_isreguser']=$this->data['reg_data'][0]->usre_isreguser; 
			$postdata['usma_designation']=$this->data['reg_data'][0]->usre_designation; 
			$postdata['usma_designationnp']=$this->data['reg_data'][0]->usre_designationnp;
			$postdata['usma_storeposttype']=$this->data['reg_data'][0]->usre_storeposttype;
			$postdata['usma_expdatead']=$this->data['reg_data'][0]->usre_expdatead; 
			$postdata['usma_expdatebs']=$this->data['reg_data'][0]->usre_expdatebs;
			$postdata['usma_usertype']=$this->data['reg_data'][0]->usre_usertype;
			$postdata['usma_status']=$this->data['reg_data'][0]->usre_status;
			$postdata['usma_locationid']=$this->data['reg_data'][0]->usre_locationid; 
			$postdata['usma_oldsignaturepath']=$this->data['reg_data'][0]->usre_oldsignaturepath; 
			$postdata['usma_servicestartdatebs']=$this->data['reg_data'][0]->usre_servicestartdatebs;
			$postdata['usma_servicestartdatead']=$this->data['reg_data'][0]->usre_servicestartdatead; 
			$postdata['usma_serviceendatead']=$this->data['reg_data'][0]->usre_serviceendatead;
			$postdata['usma_serviceendatebs']=$this->data['reg_data'][0]->usre_serviceendatebs;
			$postdata['usma_appdesiid']=$this->data['reg_data'][0]->usre_appdesiid;

			if(!empty($postdata)){
				$this->db->insert('usma_usermain',$postdata);

				 $insert_id = $this->db->insert_id();
				 	/*  for notification message*/ 
				          $mess_user = $insert_id;
				          $location_id=$this->locationid;
						  $var=ucfirst($user_name);
						  $approveby=$this->session->userdata(USER_NAME);
					      $message = "$var yours request approved by $approveby !!!";
					      $mess_title = $mess_message = $message;
					      $mess_path = 'settings/notification/user_notification_detail';
					      $this->general->send_message_to_user($mess_user, $mess_title, $mess_message, $mess_path,$location_id);
					      	/*  for notification message*/ 
				$this->db->trans_start();

				$this->db->trans_complete();
				if ($this->db->trans_status() === FALSE)
				{
					$this->db->trans_rollback();
					return false;
				}
				else
				{
					$this->db->trans_commit();
					return true;
				}

			}

		}
		public function user_summary()
		{
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		  // print_r($this->input->post());
		  // die();
				$frmDate = !empty($this->input->post('frmdate'))?$this->input->post('frmdate'):CURDATE_NP;
				$toDate = !empty($this->input->post('todate'))?$this->input->post('todate'):CURDATE_NP;
				$input_locationid=!empty($this->input->post('locationid'))?$this->input->post('locationid'):'';
				$depid=!empty($this->input->post('departmentid'))?$this->input->post('departmentid'):'';


				if($this->location_ismain=='Y')
				{
					if($input_locationid)
					{
						$status_count = $this->user_register_mdl->getStatusCount(array('usre_postdatebs >='=>$frmDate, 'usre_postdatebs <='=>$toDate,'usre_locationid'=>$input_locationid));
						 // echo "<pre>"; print_r($status_count); die();

						$total_count = $this->user_register_mdl->getRemCount(array('usre_postdatebs >='=>$frmDate, 'usre_postdatebs <='=>$toDate,'usre_locationid'=>$input_locationid));
						 $color_codeclass=$this->general->get_color_code('*','coco_colorcode',array('coco_isactive'=>'Y','coco_listname'=>'user_registerlist','coco_isallorg'=>'Y'));
					}
					else
					{
						$status_count = $this->user_register_mdl->getStatusCount(array('usre_postdatebs >='=>$frmDate, 'usre_postdatebs <='=>$toDate));

						$total_count = $this->user_register_mdl->getRemCount(array('usre_postdatebs >='=>$frmDate, 'usre_postdatebs <='=>$toDate));

					}
				}
				else
				{
					$status_count = $this->user_register_mdl->getStatusCount(array('usre_postdatebs >='=>$frmDate, 'usre_postdatebs <='=>$toDate,'usre_locationid'=>$this->locationid));

					$total_count = $this->user_register_mdl->getRemCount(array('usre_postdatebs >='=>$frmDate, 'usre_postdatebs <='=>$toDate,'usre_locationid'=>$this->locationid));
				}
		    // echo $this->db->last_query();
				print_r(json_encode(array('status'=>'success','status_count'=>$status_count,'total_count'=>$total_count)));
			}
		}
	

	}
	/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */