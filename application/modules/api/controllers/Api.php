<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller {

	function __construct() {
		parent::__construct();
			$this->load->model('api_mdl');
			// echo "<pre>";
			// print_r($this->db);
			// die();
	}
	
	
	public function index()
	{
		$this->data['api_all']=$this->api_mdl->get_all_api();
		
		$this->data['editurl']=base_url().'api/editapi';
		$this->data['deleteurl']=base_url().'api/deleteapi';
		$this->data['listurl']=base_url().'api/listapi';
		
		
		// echo "<pre>";
		// print_r($this->data['menu_all']);
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
			->build('api/api/v_api', $this->data);
	}


	public function form_api()
	{
		$this->data['api_all']=$this->api_mdl->get_all_api();
		$this->load->view('api/api/v_apiform',$this->data);
	}

	public function save_api()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		try {
			$id=$this->input->post('id');
			if($id)
			{
				$this->data['api_data']=$this->api_mdl->get_all_api(array('apta_id'=>$id));
				// echo "<pre>";
				// print_r($data['dept_data']);
				// die();
			if($this->data['api_data'])
			{
				$dep_date=$this->data['api_data'][0]->apta_postdatead;
				$dep_time=$this->data['api_data'][0]->apta_posttime;
				$editstatus=$this->general->compute_data_for_edit($dep_date,$dep_time);
				$usergroup=$this->session->userdata(USER_GROUPCODE);
				
				if($editstatus==0 && $usergroup!='SA' )
				{
					   $this->general->disabled_edit_message();

				}

			}
			}
			$this->form_validation->set_rules($this->api_mdl->validate_settings_api);
			// }
			
			  if($this->form_validation->run()==TRUE)
			 {

            $trans = $this->api_mdl->api_save();
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


public function editapi()
{
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		
    			if(MODULES_UPDATE=='N')
				{
				$this->general->permission_denial_message();
				exit;
				}
		$id=$this->input->post('id');
		
	
		$this->data['api_data']=$this->api_mdl->get_all_api(array('apta_id'=>$id));
		// echo "<pre>";
		// print_r($this->data['menu_all']);
		// die();

		if($this->data['api_data'])
		{
			$dep_date=$this->data['api_data'][0]->apta_postdatead;
			$dep_time=$this->data['api_data'][0]->apta_posttime;
			$editstatus=$this->general->compute_data_for_edit($dep_date,$dep_time);
			// echo $editstatus;
			// die();
			$this->data['edit_status']=$editstatus;

		}
		$tempform=$this->load->view('api/api/v_apiform',$this->data,true);
		// echo $tempform;
		// die();
		if(!empty($this->data['api_data']))
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

public function deletemenu()
{
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		
		if(MODULES_DELETE=='N')
				{
				$this->general->permission_denial_message();
				exit;
				}
		$id=$this->input->post('id');
		$submenu=$this->api_mdl->get_all_menu(array('m.modu_parentmodule'=>$id));
		if($submenu)
		{
			print_r(json_encode(array('status'=>'error','message'=>'You cannot delete this menu !!')));
       		 exit;	
		}

		$trans=$this->api_mdl->remove_menu();
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

	public function listapi()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$this->data['api_all']=$this->api_mdl->get_all_api();
			$template=$this->load->view('api/api/v_api_list',$this->data,true);
			print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));
	   		 exit;	
		}
		else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}
	}
	

	public function exists_apta_name()
	{
		$api_key=$this->input->post('apta_name');
		$id=$this->input->post('id');
		$modulekey=$this->api_mdl->check_exist_api_name_for_other($api_key,$id);
		if($modulekey)
		{
			$this->form_validation->set_message('exists_apta_name', 'Already Exist Api name!');
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