<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Orga_setup extends CI_Controller
{
	function __construct()
	{
			
		parent::__construct();
		$this->load->Model('orga_setup_mdl');
		$this->load->library('upload');
		$this->load->library('image_lib');
		$this->load->helper('file');
		$this->load->helper('form');
		
		
		
	}
	
	public function index()
	{
		

		$this->data['orga_setup_all']=$this->orga_setup_mdl->get_all_orga_setup();
		// echo "<pre>";
		// print_r($this->data['orga_setup_all']);
		// die();

		$this->data['editurl']=base_url().'settings/orga_setup/editorga_setup';
		$this->data['deleteurl']=base_url().'settings/orga_setup/deleteorga_setup';
		$this->data['listurl']=base_url().'settings/orga_setup/listorga_setup';

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
			->build('orga_setup/v_orga_setup', $this->data);
	}

	public function form_orga_setup()
	{
	    
		$this->load->view('orga_setup/v_orga_setup_form');
	}


	public function save_orga_setup()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		try {
            $this->logoattachment='';
			$this->headerattachment='';
			$this->footerattachment='';

	   		$id=$this->input->post('id');


			if($id)
			{
					$this->data['orga_setup_data']=$this->orga_setup_mdl->get_all_orga_setup(array('orga_orgid'=>$id));
				// echo "<pre>"; print_r($data['dept_data']);die();
					//only 24 hour can edit 
				if($this->data['orga_setup_data'])
				{
					$dep_date=$this->data['orga_setup_data'][0]->orga_postdatead;
					$dep_time=$this->data['orga_setup_data'][0]->orga_posttime;
					$editstatus=$this->general->compute_data_for_edit($dep_date,$dep_time);
					$usergroup=$this->session->userdata(USER_GROUPCODE);
					
					if($editstatus==0 && $usergroup!='SA' )
					{
						   $this->general->disabled_edit_message();

					}

				}
			}
			$this->form_validation->set_rules($this->orga_setup_mdl->validate_settings_orga_setup);
		
			if($this->form_validation->run()==TRUE )
			 {
			 	$upload_result_error=FALSE;
				if(!empty($_FILES['orga_image']['name']))
				{
					$upload_result_error=$this->orga_setup_mdl->upload_logo();
					
					//echo $upload_result_error;die; 
					if($upload_result_error==TRUE)
					{
						print_r(json_encode(array('status'=>'error','message'=>$this->session->userdata('bill_error'))));
						exit;
					}
				}

				if(!empty($_FILES['orga_headerimg']['name']))
				{
				$upload_result_error_kp=$this->orga_setup_mdl->upload_header();
				// echo $upload_result_error;
				// die();
				if($upload_result_error_kp==TRUE)
				{
					print_r(json_encode(array('status'=>'error','message'=>$this->session->userdata('known_attach_error'))));
					exit;
				}

				}
				if(!empty($_FILES['orga_footerimg']['name']))
				{
				$upload_result_error_kp=$this->orga_setup_mdl->upload_footer();
				// echo $upload_result_error;
				// die();
				if($upload_result_error_kp==TRUE)
				{
					print_r(json_encode(array('status'=>'error','message'=>$this->session->userdata('known_attach_error'))));
					exit;
				}

				}



			$id=$this->input->post('id');
			// if($id)
			// {
			// $this->form_validation->set_rules($this->orga_setup_mdl->validate_settings_menu_edit);
			// }
			// else
			// {
			$this->form_validation->set_rules($this->orga_setup_mdl->validate_settings_orga_setup);
			// }
			
			  if($this->form_validation->run()==TRUE)
			 {

            $trans = $this->orga_setup_mdl->orga_setup_save();
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


public function editorga_setup()
{
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$id=$this->input->post('id');
		$this->data['orga_setup_all']=$this->orga_setup_mdl->get_all_orga_setup();
	
		$this->data['orga_setup_data']=$this->orga_setup_mdl->get_all_orga_setup(array('orga_orgid'=>$id));
		// echo "<pre>";
		// print_r($this->data['orga_setup_all']);
		// die();

		if($this->data['orga_setup_data'])
		{
			$dep_date=$this->data['orga_setup_data'][0]->orga_postdatead;
			$dep_time=$this->data['orga_setup_data'][0]->orga_posttime;
			$editstatus=$this->general->compute_data_for_edit($dep_date,$dep_time);
			// echo $editstatus;
			// die();
			$this->data['edit_status']=$editstatus;

		}
		$tempform=$this->load->view('orga_setup/v_orga_setup_form',$this->data,true);
		// echo $tempform;
		// die();
		if(!empty($this->data['orga_setup_data']))
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


public function deleteorga_setup()
{
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$id=$this->input->post('id');
		
		$trans=$this->orga_setup_mdl->remove_orga_setup();
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

public function exists_orga_organame()
	{
		$orga_organame=$this->input->post('orga_organame');
		$id=$this->input->post('id');
		$orga_organamechk=$this->orga_setup_mdl->check_exist_orga_organame_for_other($orga_organame,$id);
		if($orga_organamechk)
		{
			$this->form_validation->set_message('exists_orga_organame', 'Already Exist modulekey!');
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