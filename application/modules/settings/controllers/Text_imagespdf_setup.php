<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Text_imagespdf_setup extends CI_Controller
{
	function __construct()
	{
		$this->insert='';	
		parent::__construct();
		$this->load->Model('department_mdl');
	}
	
	public function index()
	{
		
		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);
		$orgid = $this->session->userdata(ORG_ID);
		$userid = $this->session->userdata(USER_ID);
		
		$this->data['usermain_data']=$this->department_mdl->get_all_usermain(array('us.usma_userid'=>$userid));

		// echo "<pre>";
		// print_r($userid);
		// die();


		if($useraccess == 'B')
		{
			$this->data['department_all']=$this->department_mdl->get_all_department();
		}else{
			$this->data['department_all']=$this->department_mdl->get_all_department(array('dept_orgid'=>$orgid));
		}
		$this->data['department_type']=$this->department_mdl->get_all_departmenttype(array('dt.dety_isactive'=>'Y'));

		// $this->data['usermain_data']=$this->department_mdl->get_all_usermain(array('usma_userid'=>$userid));
		
		$this->data['imgpdf']=$this->general->get_tbl_data('*','impd_imagepdf',false,'impd_id','DESC');	
		$this->data['dept_code']=$this->general->get_tbl_data('*','orga_organization',false,'orga_orgid','DESC');	
		

			

		// echo "<pre>";
		// print_r($this->data['department_all']);
		// die();


		// $this->data['department_all']='';
		$this->data['editurl']=base_url().'settings/department/editdepartment';
		$this->data['deleteurl']=base_url().'settings/department/deletedepartment';
		$this->data['listurl']=base_url().'settings/department/listdepartment';

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
			->build('department/v_image_text_setup', $this->data);
	}

	public function form_department()
	{
		$this->data['department_type']=$this->department_mdl->get_all_departmenttype(array('dt.dety_isactive'=>'Y'));
		$this->load->view('department/v_departmentform',$this->data);
	}



	public function save_text_imagespdf_setup()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') 
		{

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
			
		try 
		{
		
			$id= $this->input->post('impd_id');
			$userid = $this->session->userdata(USER_ID);

			

			// echo "<pre>";
			// print_r($data['usermain_data']);
			// die();





			$tran=$this->department_mdl->textimage_update($id);

			if($tran)
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
		catch (Exception $e) 
			{
          
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