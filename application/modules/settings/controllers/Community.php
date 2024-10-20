<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Community extends CI_Controller
{
	function __construct()
	{
			
		parent::__construct();
		$this->load->Model('community_mdl');
		
	}
	
	public function index()
	{		
		$this->data['department_all']=$this->community_mdl->get_all_community();
		$this->data['editurl']=base_url().'settings/community/editcommunity';
		$this->data['deleteurl']=base_url().'settings/community/deletecommunity';
		//echo "<pre>";print_r($this->data['department_all']);die;
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
			->build('community/v_community', $this->data);
	}

	public function form_community()
	{
		$this->load->view('community/v_communityform');
	}

	public function save_community()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		try {
			$this->form_validation->set_rules($this->community_mdl->validate_settings_community);
			if($this->form_validation->run()==TRUE)
			{
            $trans = $this->community_mdl->community_save();
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


	public function editcommunity()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$id=$this->input->post('id');
		    
			$data['comm_data']=$this->community_mdl->get_all_community(array('comm_communityid'=>$id));
			// echo "<pre>";
			// print_r($data['dept_data']);
			// die();
			$tempform=$this->load->view('community/v_communityform',$data,true);
			// echo $tempform;
			// die();
			if(!empty($data['comm_data']))
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

	public function deletecommunity()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$id=$this->input->post('id');
			$trans=$this->community_mdl->remove_community();
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


	// public function exists_departcode()
	// 	{
	// 		$dept_depcode=$this->input->post('dept_depcode');
	// 		$id=$this->input->post('id');
	// 		$depcode=$this->department_mdl->check_exit_deptcode_for_other($dept_depcode,$id);
	// 		if($depcode)
	// 		{
	// 			return true;
	// 		}
	// 		else
	// 		{
	// 			$this->form_validation->set_message('exists_departcode', 'Already Exist Depcode!');
	// 			return false;
	// 		}
	// }

	// public function exists_departname()
	// {
	// 	$dept_depname=$this->input->post('dept_depname');
	// 		$id=$this->input->post('id');
	// 		$depname=$this->department_mdl->check_exit_deptname_for_other($dept_depname,$id);
	// 		if($depname)
	// 		{
	// 			return true;
	// 		}
	// 		else
	// 		{
	// 			$this->form_validation->set_message('exists_departname', 'Already Exist Depname!!');
	// 			return false;
	// 		}
	// }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */