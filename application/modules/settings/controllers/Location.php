<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Location extends CI_Controller
{
	function __construct()
	{
		$this->insert='';	
		parent::__construct();
		$this->load->Model('location_mdl');
		// echo 'NSA'.MODULES_INSERT;
		// die();
		// $this->insert=MODULES_INSERT;
		// $per=new General();
		// $per->menu_permission;
		// print_r($per->menu_permission);
		// die();
		// $currenturl=$this->general->getUrl();
		// $new_url=str_replace(base_url(),"",$currenturl);
		// $urlchk= '/'.$new_url;
		// $this->menu_permission= $this->general->check_menu_permission($urlchk);
		// echo $this->db->last_query();
		// print_r($this->menu_permission);
		// die();
		// echo $_SERVER['HTTP_REFERER'];
		// die();

	}
	
	public function index()
	{  
		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);
		$orgid = $this->session->userdata(ORG_ID);
		// $id = $this->input->post('id');
		// if($useraccess == 'B')
		// {   
		// }else{
		// 	$this->data['location_all'] = $this->general->get_tbl_data('*','loca_location',array('loca_locationid'=>$id),'loca_locationid','DESC');
		// 	//$this->data['location_all']=$this->location_mdl->get_all_department(array('dept_orgid'=>$orgid));
		// } 
		$this->data['location_all'] = $this->general->get_tbl_data('*','loca_location',false,'loca_locationid','DESC');
		
		// $this->data['location_all']='';
		$this->data['editurl']=base_url().'settings/location/editlocation';
		$this->data['deleteurl']=base_url().'settings/location/deletelocation';
		$this->data['listurl']=base_url().'settings/location/list_location';

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
			->build('location/v_location', $this->data);
	}

	public function form_location()
	{	
		$this->data['editurl']=base_url().'settings/location/editlocation';
		$this->data['deleteurl']=base_url().'settings/location/deletelocation';
		$this->data['listurl']=base_url().'settings/location/listlocation';
		$this->load->view('location/v_locationform',$this->data);
	}

	// public function listdepartment()
		// {
		// 	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		// 		if(MODULES_VIEW=='N')
		// 		{
		// 		$this->general->permission_denial_message();
		// 		exit;
		// 		}

		// 		$this->data['department_all']=$this->location_mdl->get_all_department();
		// 		$template=$this->load->view('department/v_department_list',$this->data,true);
		// 		print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));
		//    		 exit;	
		// 	}
		// 	else
		// 	{
		// 		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
		//         exit;
		// 	}
	// }
	public function save_location()
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
			$this->form_validation->set_rules($this->location_mdl->validate_settings_department);
			
			if($this->form_validation->run()==TRUE)
			{

            $trans = $this->location_mdl->location_save();
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

	public function list_location(){
		// $this->data['location_all'] = $this->general->get_tbl_data('*','loca_location',false,'loca_locationid','DESC');
		// $this->load->view('location/v_location_list',$this->data);
		if(MODULES_VIEW=='N')
			{
			$this->general->permission_denial_message();
			exit;
			}

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			
			$this->locationid = $this->session->userdata(LOCATION_ID);
		$this->location_ismain = $this->session->userdata(ISMAIN_LOCATION);
		// echo $this->location_ismain;
		if($this->location_ismain=='Y')
		{
			$this->data['location_all'] = $this->general->get_tbl_data('*','loca_location',false,'loca_locationid','DESC');
		}
		else
		{
			$this->data['location_all'] = $this->general->get_tbl_data('*','loca_location',false,'loca_locationid','DESC');
		}

			
			$template=$this->load->view('location/v_location_list',$this->data,true);
			print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));
	   		 exit;	
		}
		else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}
		
	}
	public function editlocation()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			// if(MODULES_UPDATE=='N')
			// {
			// $this->general->permission_denial_message();
			// exit;
			// }

			$id=$this->input->post('id');
			
		    //$data['department_type']=$this->location_mdl->get_all_departmenttype(array('dt.dety_isactive'=>'Y'));
			$this->data['dept_data'] = $this->general->get_tbl_data('*','loca_location',array('loca_locationid'=>$id),'loca_locationid','DESC');
			// echo "<pre>";
			// print_r($this->data['dept_data']);
			// die();
				// if($data['dept_data'])
				// {
				// 	$dep_date=$data['dept_data'][0]->dept_postdatead;
				// 	$dep_time=$data['dept_data'][0]->dept_posttime;
				// 	$editstatus=$this->general->compute_data_for_edit($dep_date,$dep_time);
				// 	// echo $editstatus;
				// 	// die();
				// 	$data['edit_status']=$editstatus;

				// }
			$tempform=$this->load->view('location/v_locationform',$this->data,true);
			//echo $tempform; die();
			if(!empty($this->data['dept_data']))
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
	public function deletelocation()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if(MODULES_DELETE=='N')
			{
				$this->general->permission_denial_message();
					exit;
			}
			$id=$this->input->post('id');
			$trans=$this->location_mdl->remove_location();
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

	public function exists_location()
{
		$loca_name=$this->input->post('loca_name');
		$input_id=$this->input->post('id');
		$locationname=$this->location_mdl->check_exit_location_for_other($loca_name,$input_id);
		if($locationname)
		{
			$this->form_validation->set_message('exists_location', 'Already Exit Location Name.');
			return false;

		}
		else
		{
			return true;
		}

}
}