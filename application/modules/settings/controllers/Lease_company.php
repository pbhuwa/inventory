<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lease_company extends CI_Controller
{
	function __construct()
	{
			
		parent::__construct();
		$this->load->Model('lease_company_mdl');
		$this->load->helper('file');
		$this->load->helper('form');
		
	}

	public function index()
	{
        // echo"<pre>";
        // print_r("hy");
        // die();

		$this->data['lease_company_all']=$this->lease_company_mdl->get_all_lease_company();
		// echo "<pre>";
		// print_r($this->data['orga_setup_all']);
		// die();

		$this->data['editurl']=base_url().'settings/lease_company/edit_lease_company';
		$this->data['deleteurl']=base_url().'settings/lease_company/delete_lease_company';
		$this->data['listurl']=base_url().'settings/lease_company/list_lease_company';

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
			->build('lease_company/v_lease_company', $this->data);
	}

	public function form_lease_company()
	{
	    
		$this->load->view('lease_company/v_lease_company_form');
	}

	public function save_lease_company()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		try {
			$id=$this->input->post('id');

			if(MODULES_UPDATE=='N')
					{
						$this->general->permission_denial_message();
						exit;
					}

			if($id)
			{
					 $this->data['lease_company_data']=$this->lease_company_mdl->get_all_lease_company(array('leco_leasecompanyid'=>$id));
				// echo "<pre>";
				// print_r($data['dept_data']);
				// die();
			if($this->data['lease_company_data'])
			{
				$dep_date=$this->data['lease_company_data'][0]->leco_postdatead;
				$dep_time=$this->data['lease_company_data'][0]->leco_posttime;
				$editstatus=$this->general->compute_data_for_edit($dep_date,$dep_time);
				$usergroup=$this->session->userdata(USER_GROUPCODE);
				
				if($editstatus==0 && $usergroup!='SA' )
				{
					   $this->general->disabled_edit_message();

				}

			}
			}



			 $this->form_validation->set_rules($this->lease_company_mdl->validate_settings_lease_company);
			// $this->room_mdl->validate_settings_room();
			  if($this->form_validation->run()==TRUE)
			 {

            $trans = $this->lease_company_mdl->lease_company_save();
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

public function edit_lease_company()
{
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		if(MODULES_UPDATE=='N')
					{
						$this->general->permission_denial_message();
						exit;
					}
					
		$id=$this->input->post('id');
		$this->data['lease_company_all']=$this->lease_company_mdl->get_all_lease_company();
	
		$this->data['lease_company_data']=$this->lease_company_mdl->get_all_lease_company(array('leco_leasecompanyid'=>$id));
		// echo "<pre>";
		// print_r($this->data['orga_setup_all']);
		// die();

		if($this->data['lease_company_data'])
		{
			$dep_date=$this->data['lease_company_data'][0]->leco_postdatead;
			$dep_time=$this->data['lease_company_data'][0]->leco_posttime;
			$editstatus=$this->general->compute_data_for_edit($dep_date,$dep_time);
			// echo $editstatus;
			// die();
			$this->data['edit_status']=$editstatus;

		}
		$tempform=$this->load->view('lease_company/v_lease_company_form',$this->data,true);
		// echo $tempform;
		// die();
		if(!empty($this->data['lease_company_data']))
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


public function delete_lease_company()
{

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if(MODULES_DELETE=='N')
				{
				$this->general->permission_denial_message();
				exit;
				}

		$id=$this->input->post('id');

		$trans=$this->lease_company_mdl->remove_lease_company();
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

public function list_lease_company(){
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$this->data['lease_company_all']=$this->lease_company_mdl->get_all_lease_company();


		$template=$this->load->view('lease_company/v_lease_company_list',$this->data,true);
		print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));
			exit;	
	   }
	else
	{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
		exit;
	}
}

public function exists_leco_name()
	{
		$leco_name=$this->input->post('leco_name');
		$id=$this->input->post('id');
		$leco_namechk=$this->lease_company_mdl->check_exist_orga_organame_for_other($leco_name,$id);
		if($orga_organamechk)
		{
			$this->form_validation->set_message('exists_leco_name', 'Already Exist modulekey!');
			return false;

		}
		else
		{
			return true;
		}
	}


	
	


}