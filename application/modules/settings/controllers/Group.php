<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Group extends CI_Controller
{
	function __construct()
	{
			
		parent::__construct();
		$this->load->Model('group_mdl');
		$this->useraccess= $this->session->userdata(USER_ACCESS_TYPE);
		$this->orgid= $this->session->userdata(ORG_ID);
	 	$this->locationid = $this->session->userdata(LOCATION_ID);
     	$this->location_ismain = $this->session->userdata(ISMAIN_LOCATION);
     	// echo $this->location_ismain;die;
		
	}
	
	public function index()
	{

		$this->data['org_list']=$this->general->get_tbl_data('*','orga_organization',array('orga_isactive'=>'Y','orga_orgid'=>$this->session->userdata(ORG_ID)),'orga_orgid','ASC');
		$this->data['dashboard_all'] = $this->general->get_tbl_data('*','dash_dashboard',array('dash_orgid'=>$this->orgid,'dash_isactive'=>'Y'),'dash_id','ASC');
		// echo "<pre>";
		// print_r($this->data['dashboard_all']);
		// die();

		if($this->location_ismain == 'Y')
		{
			$this->data['group_all']=$this->group_mdl->get_all_group();
			$this->data['location_all'] =$this->general->get_tbl_data('*','loca_location',false,'loca_locationid','ASC');

		}else{
			$this->data['group_all']=$this->group_mdl->get_all_group(array('usgr_locationid'=>$this->locationid));
			$this->data['location_all'] =$this->general->get_tbl_data('*','loca_location',array('loca_locationid'=>$this->locationid),'loca_locationid','ASC');

		}


		
		$this->data['editurl']=base_url().'settings/group/editgroup';
		$this->data['deleteurl']=base_url().'settings/group/deletegroup';
		$this->data['listurl']=base_url().'settings/group/listgroup';
		$this->data['location_ismain']=$this->location_ismain;
		$this->data['current_location']=$this->locationid;
	
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
			->build('group/v_group', $this->data);
	}

public function form_group()
{
	$this->data['dashboard_all'] = $this->general->get_tbl_data('*','dash_dashboard',array('dash_orgid'=>$this->orgid,'dash_isactive'=>'Y'),'dash_id','ASC');
		if($this->location_ismain == 'Y')
		{
			$this->data['group_all']=$this->group_mdl->get_all_group();
			$this->data['location_all'] =$this->general->get_tbl_data('*','loca_location',false,'loca_locationid','ASC');

		}else{
			// echo $this->db->last_query();
			// die();
			$this->data['group_all']=$this->group_mdl->get_all_group(array('usgr_locationid'=>$this->locationid));
			$this->data['location_all'] =$this->general->get_tbl_data('*','loca_location',array('loca_locationid'=>$this->locationid),'loca_locationid','ASC');

		}

		$this->data['location_ismain']=$this->location_ismain;
		$this->data['current_location']=$this->locationid;
		

		$this->data['org_list']=$this->general->get_tbl_data('*','orga_organization',array('orga_isactive'=>'Y'),'orga_orgid','ASC');
		$this->load->view('group/v_groupform',$this->data);
}



public function listgroup()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			
		if($this->location_ismain == 'Y')
		{
			$this->data['group_all']=$this->group_mdl->get_all_group();
			$this->data['location_all'] =$this->general->get_tbl_data('*','loca_location',false,'loca_locationid','ASC');

		}else{
			
			$this->data['group_all']=$this->group_mdl->get_all_group(array('usgr_locationid'=>$this->locationid));
			$this->data['location_all'] =$this->general->get_tbl_data('*','loca_location',array('loca_locationid'=>$this->locationid),'loca_locationid','ASC');

		}

		$this->data['location_ismain']=$this->location_ismain;
		$this->data['current_location']=$this->locationid;
		

			$template=$this->load->view('group/v_group_list',$this->data,true);
			print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));
	   		 exit;	
		}
		else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}
	}

	public function save_group()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		try {
			$id=$this->input->post('id');
			if($id)
			{
					$this->data['group_data']=$this->group_mdl->get_all_group(array('ug.usgr_usergroupid'=>$id));
			
			if($this->data['group_data'])
			{
				$dep_date=$this->data['group_data'][0]->usgr_postdatead;
				$dep_time=$this->data['group_data'][0]->usgr_posttime;
				$editstatus=$this->general->compute_data_for_edit($dep_date,$dep_time);
				$usergroup=$this->session->userdata(USER_GROUPCODE);
				
				if($editstatus==0 && $usergroup!='SA' )
				{
					   $this->general->disabled_edit_message();

				}

			}
			}
		

			 $this->form_validation->set_rules($this->group_mdl->validate_settings_group);
			  if($this->form_validation->run()==TRUE)
			 {

            $trans = $this->group_mdl->group_save();
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



public function editgroup()
{
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if(MODULES_UPDATE=='N')
				{
				$this->general->permission_denial_message();
				exit;
				}
		$id=$this->input->post('id');
		$this->data['org_list']=$this->general->get_tbl_data('*','orga_organization',array('orga_isactive'=>'Y'),'orga_orgid','ASC');
	
		$this->data['group_data']=$this->group_mdl->get_all_group(array('ug.usgr_usergroupid'=>$id));
		$this->data['dashboard_all'] = $this->general->get_tbl_data('*','dash_dashboard',array('dash_orgid'=>$this->orgid,'dash_isactive'=>'Y'),'dash_id','ASC');

		if($this->data['group_data'])
		{
			$dep_date=$this->data['group_data'][0]->usgr_postdatead;
			$dep_time=$this->data['group_data'][0]->usgr_posttime;
			$editstatus=$this->general->compute_data_for_edit($dep_date,$dep_time);
			// echo $editstatus;
			// die();
			$this->data['edit_status']=$editstatus;

		}

		if($this->location_ismain == 'Y')
		{
		$this->data['location_all'] =$this->general->get_tbl_data('*','loca_location',false,'loca_locationid','ASC');
		}else{
 		$this->data['location_all'] =$this->general->get_tbl_data('*','loca_location',array('loca_locationid'=>$this->locationid),'loca_locationid','ASC');

		}
		$this->data['location_ismain']=$this->location_ismain;
		$this->data['current_location']=$this->locationid;
	
		$tempform=$this->load->view('group/v_groupform',$this->data,true);
		
		if(!empty($this->data['group_data']))
		{
				print_r(json_encode(array('status'=>'success','message'=>'You Can edit','tempform'=>$tempform)));
            	exit;
		}
		else{
			print_r(json_encode(array('status'=>'error','message'=>'Unable to Edit!!')));
            	exit;
		}
	}
	else
	{
	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        exit;
	}

}

public function deletegroup()
{
	if(MODULES_DELETE=='N')
				{
				$this->general->permission_denial_message();
				exit;
				}
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$id=$this->input->post('id');
		$trans=$this->group_mdl->remove_group();
		if($trans)
		{
			print_r(json_encode(array('status'=>'success','message'=>'Successfully Deleted!!')));
       		 exit;	
		}
		else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Error while deleting!!')));
       		 exit;	
		}

	}
	else
	{
	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        exit;
	}

}
	
public function exists_group()
	{
		$usgr_usergroup=$this->input->post('usgr_usergroup');
		$id=$this->input->post('id');
		$grpcode=$this->group_mdl->check_exit_group_for_other($usgr_usergroup,$id);
		
		if($grpcode)
		{
			$this->form_validation->set_message('exists_group', 'Already Exist Group Name!!');
			return false;
		}
		else
		{
			return true;
			
		}
}


public function save_group_clone()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		try {
		

			 $this->form_validation->set_rules($this->group_mdl->validate_settings_group);
			  if($this->form_validation->run()==TRUE)
			 {

            $trans = $this->group_mdl->group_save_clone();
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


	

		
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */