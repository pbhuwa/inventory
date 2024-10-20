<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class System_setting extends CI_Controller
{
	function __construct()
	{
			
		parent::__construct();
		$this->load->Model('system_setting_mdl');
		
	}
	
	public function index()
	{
		
		$this->data['constant_list']=$this->system_setting_mdl->get_all_constant();
		$this->data['listurl']=base_url().'settings/system_setting/list_constant';
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
			->build('system_setting/v_system_setting', $this->data);
	}
	public function update_constant()
	{
		//print_r($this->input->post());
		// die; 
//		$this->data['constant_list']=$this->system_setting_mdl->get_all_constant();

		$trans = $this->system_setting_mdl->update_constant();

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

	public function list_constant()
	{
		// $this->data['constant_list']=$this->system_setting_mdl->get_all_constant();
		
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$data['constant_list']=$this->system_setting_mdl->get_all_constant();
		
			$template=$this->load->view('system_setting/v_system_list',$data,true);
			print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));
	   		 exit;	
		}
		else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}

		// $this->load->view('system_setting/v_system_setting',$this->data);
	}


}

