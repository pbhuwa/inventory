<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Asco_condition extends CI_Controller
{
	function __construct()
	{
			
		parent::__construct();
		$this->load->Model('asco_condition_mdl');
		$this->load->helper('file');
		$this->load->helper('form');
		
	}

	public function index()
	{
        // echo"<pre>";
        // print_r("hy");
        // die();

		$this->data['asco_condition']=$this->asco_condition_mdl->get_all_asco_condition();
		// echo "<pre>";
		// print_r($this->data['orga_setup_all']);
		// die();

		$this->data['editurl']=base_url().'settings/asco_condition/edit_asco_condition';
		$this->data['deleteurl']=base_url().'settings/asco_condition/delete_asco_condition';
		$this->data['listurl']=base_url().'settings/asco_condition/list_asco_condition';

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
			->build('asco_condition/v_asco_condition', $this->data);
	}

	public function form_asco_condition()
	{
	    
		$this->load->view('asco_condition/v_asco_condition_form');
	}

	public function save_asco_condition()
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
					 $this->data['asco_condition_data']=$this->asco_condition_mdl->get_all_asco_condition(array('asco_ascoid'=>$id));
				// echo "<pre>";
				// print_r($data['dept_data']);
				// die();
			if($this->data['asco_condition_data'])
			{
				$dep_date=$this->data['asco_condition_data'][0]->asco_postdatead;
				$dep_time=$this->data['asco_condition_data'][0]->asco_posttime;
				$editstatus=$this->general->compute_data_for_edit($dep_date,$dep_time);
				$usergroup=$this->session->userdata(USER_GROUPCODE);
				
				if($editstatus==0 && $usergroup!='SA' )
				{
					   $this->general->disabled_edit_message();

				}

			}
			}



			 $this->form_validation->set_rules($this->asco_condition_mdl->validate_settings_asco_condition);
			// $this->room_mdl->validate_settings_room();
			  if($this->form_validation->run()==TRUE)
			 {

            $trans = $this->asco_condition_mdl->asco_condition_save();
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

public function edit_asco_condition()
{
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		if(MODULES_UPDATE=='N')
					{
						$this->general->permission_denial_message();
						exit;
					}
					
		$id=$this->input->post('id');
		$this->data['asco_condition']=$this->asco_condition_mdl->get_all_asco_condition();
	
		$this->data['asco_condition_data']=$this->asco_condition_mdl->get_all_asco_condition(array('asco_ascoid'=>$id));
		// echo "<pre>";
		// print_r($this->data['orga_setup_all']);
		// die();

		if($this->data['asco_condition_data'])
		{
			$dep_date=$this->data['asco_condition_data'][0]->asco_postdatead;
			$dep_time=$this->data['asco_condition_data'][0]->asco_posttime;
			$editstatus=$this->general->compute_data_for_edit($dep_date,$dep_time);
			// echo $editstatus;
			// die();
			$this->data['edit_status']=$editstatus;

		}
		$tempform=$this->load->view('asco_condition/v_asco_condition_form',$this->data,true);
		// echo $tempform;
		// die();
		if(!empty($this->data['asco_condition_data']))
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


public function delete_asco_condition()
{

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if(MODULES_DELETE=='N')
				{
				$this->general->permission_denial_message();
				exit;
				}

		$id=$this->input->post('id');

		$trans=$this->asco_condition_mdl->remove_asco_condition();
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

public function list_asco_condition(){
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$this->data['asco_condition']=$this->asco_condition_mdl->get_all_asco_condition();


		$template=$this->load->view('asco_condition/v_asco_condition_list',$this->data,true);
		print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));
			exit;	
	   }
	else
	{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
		exit;
	}
}

public function exists_asco_name()
	{
		$asco_name=$this->input->post('asco_name');
		$id=$this->input->post('id');
		$asco_namechk=$this->asco_condition_mdl->check_exist_orga_organame_for_other($asco_name,$id);
		if($orga_organamechk)
		{
			$this->form_validation->set_message('exists_asco_name', 'Already Exist modulekey!');
			return false;

		}
		else
		{
			return true;
		}
	}


	
	


}