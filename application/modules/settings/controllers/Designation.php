<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Designation extends CI_Controller
{
	function __construct()
	{
		$this->insert='';	
		parent::__construct();
		$this->load->Model('designation_mdl');
	
	}

	
	public function index()
	{  
		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);
		$orgid = $this->session->userdata(ORG_ID);
	
		$this->data['designation_all'] = $this->general->get_tbl_data('*','desi_designation',false,'desi_designationid','DESC');
		
		// $this->data['location_all']='';
		$this->data['editurl']=base_url().'settings/designation/editdesignation';
		$this->data['deleteurl']=base_url().'settings/designation/deletedesignation';
		$this->data['listurl']=base_url().'settings/designation/';

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
			->build('designation/v_designation', $this->data);
	}

	public function form_designation()
	{	
		$this->data['editurl']=base_url().'settings/designation/editdesignation';
		$this->data['deleteurl']=base_url().'settings/designation/deletedesignation';
		$this->data['listurl']=base_url().'settings/designation/listdesignation';
		$this->data['designation_all'] = $this->general->get_tbl_data('*','desi_designation',false,'desi_designationid','DESC');
		$this->load->view('designation/v_designation',$this->data);
	}


	public function save_designation()
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
			$this->form_validation->set_rules($this->designation_mdl->validate_settings_designation);
			
			if($this->form_validation->run()==TRUE)
			{

            $trans = $this->designation_mdl->designation_save();
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
	public function editdesignation()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			

			$id=$this->input->post('id');
			
		    
			$this->data['dept_data'] = $this->general->get_tbl_data('*','desi_designation',array('desi_designationid'=>$id),'desi_designationid','DESC');
		
			$tempform=$this->load->view('designation/v_designationform',$this->data,true);
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
	public function deletedesignation()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if(MODULES_DELETE=='N')
			{
				$this->general->permission_denial_message();
					exit;
			}
			$id=$this->input->post('id');
			$trans=$this->designation_mdl->remove_designation();
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


	public function designation_popup()
{
	// echo "test";
	// die();
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$this->data['is_savelist']='Y';
	 	$this->data['editurl']=base_url().'settings/designation/editdesignation';
		$this->data['deleteurl']=base_url().'settings/designation/deletedesignation';
		$this->data['listurl']=base_url().'settings/designation/listdesignation';
		
		$this->data['equipmnt_designation']=$this->general->get_tbl_data('*','desi_designation',false,'desi_designationname','ASC');
	 	$tempform='';

	 	$tempform .=$this->load->view('designation/v_designationform',$this->data,true);

	 	//$tempform .=$this->load->view('designation/v_designation_list',$this->data,true);
	 	// echo $tempform;
	 	// die();
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
}