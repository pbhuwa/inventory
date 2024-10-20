<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Doctor extends CI_Controller
{
	function __construct()
	{
			
		parent::__construct();
		$this->load->Model('doctor_mdl');
		$this->load->Model('department_mdl');
		
		
	}
	
	public function index()
	{
		
		
		// echo "<pre>";
		// print_r($this->data['doctor_list']);
		// die();
		
		$this->data['doctor_all']=$this->doctor_mdl->get_all_doctor();
		$this->data['department_all']=$this->department_mdl->get_all_department();
		
		$this->data['editurl']=base_url().'settings/doctor/editdoctor';
		$this->data['deleteurl']=base_url().'settings/doctor/deletedoctor';
		
		// echo "<pre>";
		// print_r($this->data['doctor_all']);
		// die();
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
			->build('doctor/v_doctor', $this->data);
	}

	public function save_doctor()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$id = $this->input->post('id');
		try {
				if($id)
			{
					$this->data['doc_data']=$this->doctor_mdl->get_all_doctor(array('dose_docid'=>$id));
				// echo "<pre>";
				// print_r($this->data['dept_data']);
				// die();
			if($this->data['doc_data'])
			{
				$dep_date=$this->data['doc_data'][0]->dose_postdatead;
				$dep_time=$this->data['doc_data'][0]->dose_posttime;
				$editstatus=$this->general->compute_data_for_edit($dep_date,$dep_time);
				$usergroup=$this->session->userdata(USER_GROUPCODE);
				
				if($editstatus==0 && $usergroup!='SA' )
				{
					   $this->general->disabled_edit_message();

				}

			}
			}
			$this->form_validation->set_rules($this->doctor_mdl->validate_settings_doctor);
		
			if($this->form_validation->run()==TRUE)
			 {

            $trans = $this->doctor_mdl->save_doctor();
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


public function editdoctor()
{
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$id=$this->input->post('id');
		
		$this->data['doc_data']=$this->doctor_mdl->get_all_doctor(array('dose_docid'=>$id));
		 $this->data['department_all']=$this->department_mdl->get_all_department();
		// $this->data['group_all']=$this->group_mdl->get_all_group();
		// $this->data['user_dep']=$this->doctor_mdl->get_userwise_dep($id,false);
		// $this->data['user_group']=$this->doctor_mdl->get_userwise_group($id,false);
		if($this->data['doc_data'])
		{
			$dep_date=$this->data['doc_data'][0]->dose_postdatead;
			$dep_time=$this->data['doc_data'][0]->dose_posttime;
			$editstatus=$this->general->compute_data_for_edit($dep_date,$dep_time);
			// echo $editstatus;
			// die();
			$this->data['edit_status']=$editstatus;

		}

		// echo "<pre>";
		// print_r($this->data['doc_data']);
		// die();
		$tempform=$this->load->view('doctor/v_doctorform',$this->data,true);
		// echo $tempform;
		// die();
		if(!empty($this->data['doc_data']))
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

public function deletedoctor()
{
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$id=$this->input->post('id');
		$trans=$this->doctor_mdl->remove_doctor();
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

public function exists_username()
{
		$usma_username=$this->input->post('usma_username');
		$input_id=$this->input->post('id');
		$username=$this->doctor_mdl->check_exit_username_for_other($usma_username,$input_id);
		if($username)
		{
			return true;
		}
		else
		{
			$this->form_validation->set_message('exists_username', 'Alreay Exit Username.');
			return false;
		}

}



		
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */