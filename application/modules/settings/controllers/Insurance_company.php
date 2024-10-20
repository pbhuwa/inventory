<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Insurance_company extends CI_Controller
{
	function __construct()
	{
			
		parent::__construct();
		$this->load->Model('insurance_company_mdl');
		$this->load->helper('file');
		$this->load->helper('form');
		
	}

	public function index()
	{
		

		$this->data['insurance_company_all']=$this->insurance_company_mdl->get_all_insurance_company();
		// echo "<pre>";
		// print_r($this->data['orga_setup_all']);
		// die();

		$this->data['editurl']=base_url().'settings/insurance_company/edit_insurance_company';
		$this->data['deleteurl']=base_url().'settings/insurance_company/delete_insurance_company';
		$this->data['listurl']=base_url().'settings/insurance_company/list_insurance_company';

		// $seo_data='';
		// if($seo_data)
		// {
		// 	//set SEO data
		// 	$this->page_title = $seo_data->page_title;
		// 	$this->data['meta_keys']= $seo_data->meta_key;
		// 	$this->data['meta_desc']= $seo_data->meta_description;
		// }
		// else
		// {
		// 	//set SEO data
		//     $this->page_title = ORGA_NAME;
		//     $this->data['meta_keys']= ORGA_NAME;
		//     $this->data['meta_desc']= ORGA_NAME;
		// }

		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			//->title($this->page_title)
			->build('insurance_company/v_insurance_company', $this->data);
	}

	public function form_insurance_company()
	{
	    
		$this->load->view('insurance_company/v_insurance_company_form');
	}

	public function save_insurance_company()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		try {
			$id=$this->input->post('id');
			if($id)
			{
					 $this->data['insurance_company_data']=$this->insurance_company_mdl->get_all_insurance_company(array('inco_id'=>$id));
				// echo "<pre>";
				// print_r($data['dept_data']);
				// die();
			if($this->data['insurance_company_data'])
			{
				$dep_date=$this->data['insurance_company_data'][0]->inco_postdatead;
				$dep_time=$this->data['insurance_company_data'][0]->inco_posttime;
				$editstatus=$this->general->compute_data_for_edit($dep_date,$dep_time);
				$usergroup=$this->session->userdata(USER_GROUPCODE);
				
				if($editstatus==0 && $usergroup!='SA' )
				{
					   $this->general->disabled_edit_message();

				}

			}
			}



			 $this->form_validation->set_rules($this->insurance_company_mdl->validate_settings_insurance_company);
			// $this->room_mdl->validate_settings_room();
			  if($this->form_validation->run()==TRUE)
			 {

            $trans = $this->insurance_company_mdl->insurance_company_save();
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

public function edit_insurance_company()
{
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$id=$this->input->post('id');
		$this->data['insurance_company_all']=$this->insurance_company_mdl->get_all_insurance_company();
	
		$this->data['insurance_company_data']=$this->insurance_company_mdl->get_all_insurance_company(array('inco_id'=>$id));
		// echo "<pre>";
		// print_r($this->data['orga_setup_all']);
		// die();

		if($this->data['insurance_company_data'])
		{
			$dep_date=$this->data['insurance_company_data'][0]->inco_postdatead;
			$dep_time=$this->data['insurance_company_data'][0]->inco_posttime;
			$editstatus=$this->general->compute_data_for_edit($dep_date,$dep_time);
			// echo $editstatus;
			// die();
			$this->data['edit_status']=$editstatus;

		}
		$tempform=$this->load->view('insurance_company/v_insurance_company_form',$this->data,true);
		// echo $tempform;
		// die();
		if(!empty($this->data['insurance_company_data']))
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


public function delete_insurance_company()
{
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$id=$this->input->post('id');
		
		$trans=$this->insurance_company_mdl->remove_insurance_company();
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
	
}

public function list_insurance_company(){
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$this->data['insurance_company_all']=$this->insurance_company_mdl->get_all_insurance_company();


		$template=$this->load->view('insurance_company/v_insurance_company_list',$this->data,true);
		print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));
			exit;	
	   }
	else
	{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
		exit;
	}
}

public function exists_inco_name()
	{
		$inco_name=$this->input->post('inco_name');
		$id=$this->input->post('id');
		$inco_namechk=$this->insurance_company_mdl->check_exist_orga_organame_for_other($inco_name,$id);
		if($orga_organamechk)
		{
			$this->form_validation->set_message('exists_inco_name', 'Already Exist modulekey!');
			return false;

		}
		else
		{
			return true;
		}
	}


	
	


}