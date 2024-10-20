<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Room extends CI_Controller
{
	function __construct()
	{
			
		parent::__construct();
		$this->load->Model('room_mdl');
		$this->load->Model('department_mdl');
		
	}
	
	public function index()
	{

		
		// echo "<pre>";
		// print_r($this->data['room_list']);
		// die();
		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);
		$orgid = $this->session->userdata(ORG_ID);
		if($useraccess == 'B')
		{
			$this->data['room_all']=$this->room_mdl->get_all_room();
		}else{
			$this->data['room_all']=$this->room_mdl->get_all_room(array('rode_orgid'=>$orgid));
		}
		
		$this->data['department_all']=$this->department_mdl->get_all_department();
		// $this->data['room_all']='';
		// echo "<pre>";
		// print_r($this->data['room_all']);
		// die();

		$this->data['editurl']=base_url().'settings/room/editroom';
		$this->data['deleteurl']=base_url().'settings/room/deleteroom';
		$this->data['listurl']=base_url().'settings/room/listroom';

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
			->build('room/v_room', $this->data);
	}

	public function form_room()
	{
		$this->data['department_all']=$this->department_mdl->get_all_department();
		$this->load->view('room/v_roomform',$this->data);
	}

	public function listroom()
	{
		if(MODULES_VIEW=='N')
			//echo MODULES_VIEW;die;
			{
			 $array["rode_roomdepartmentid"]='';
			 $array["dept_depname"] ='';
			 $array["rode_roomname"]=''; 
			 $array["rode_postdatebs"]=''; 
			 $array["rode_isactive"] ='';
			 $array["action"]='';
			 // $this->general->permission_denial_message();
			 echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));			
			exit;
			}
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$this->data['room_all']=$this->room_mdl->get_all_room();
			$template=$this->load->view('room/v_room_list',$this->data,true);
			print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));
	   		 exit;	
		}
		else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}
	}


	public function save_room()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		try {
			$id=$this->input->post('id');
			if($id)
			{
					 $this->data['room_data']=$this->room_mdl->get_all_room(array('rode_roomdepartmentid'=>$id));
				// echo "<pre>";
				// print_r($data['dept_data']);
				// die();
			if($this->data['room_data'])
			{
				$dep_date=$this->data['room_data'][0]->rode_postdatead;
				$dep_time=$this->data['room_data'][0]->rode_posttime;
				$editstatus=$this->general->compute_data_for_edit($dep_date,$dep_time);
				$usergroup=$this->session->userdata(USER_GROUPCODE);
				
				if($editstatus==0 && $usergroup!='SA' )
				{
					   $this->general->disabled_edit_message();

				}

			}
			}



			 $this->form_validation->set_rules($this->room_mdl->validate_settings_room);
			// $this->room_mdl->validate_settings_room();
			  if($this->form_validation->run()==TRUE)
			 {

            $trans = $this->room_mdl->room_save();
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


public function editroom()
{

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if(MODULES_UPDATE=='N')
				{
				$this->general->permission_denial_message();
				exit;
				}
		$id=$this->input->post('id');
		
	    $this->data['room_data']=$this->room_mdl->get_all_room(array('rode_roomdepartmentid'=>$id));
		$this->data['department_all']=$this->department_mdl->get_all_department();
		// echo "<pre>";
		// print_r($data['dept_data']);
		// die();

		if($this->data['room_data'])
		{
			$dep_date=$this->data['room_data'][0]->rode_postdatead;
			$dep_time=$this->data['room_data'][0]->rode_posttime;
			$editstatus=$this->general->compute_data_for_edit($dep_date,$dep_time);
			// echo $editstatus;
			// die();
			$this->data['edit_status']=$editstatus;

		}
		$tempform=$this->load->view('room/v_roomform',$this->data,true);
		// echo $tempform;
		// die();
		if(!empty($this->data['room_data']))
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

public function deleteroom()
{
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if(MODULES_DELETE=='N')
				{
				$this->general->permission_denial_message();
				exit;
				}
		$id=$this->input->post('id');
		$trans=$this->room_mdl->remove_room();
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


public function exists_departcode()
	{
		$dept_depcode=$this->input->post('dept_depcode');
		$id=$this->input->post('id');
		$depcode=$this->room_mdl->check_exit_deptcode_for_other($dept_depcode,$id);
		// print_r($depcode);
		// die();
		// echo $this->db->last_query();
		// die();
		if($depcode)
		{
			$this->form_validation->set_message('exists_departcode', 'Already Exist Dep.code!!');
			return false;
		}
		else
		{
			return true;
			
		}
}

public function exists_departname()
{
	$dept_depname=$this->input->post('dept_depname');
		$id=$this->input->post('id');
		$depname=$this->room_mdl->check_exit_deptname_for_other($dept_depname,$id);
		if($depname)
		{
			
			$this->form_validation->set_message('exists_departname', 'Already Exist Dep.name!!');
			return false;
			
		}
		else
		{
			return true;
		}
}




	

		
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */