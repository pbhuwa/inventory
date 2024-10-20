<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Repair_information extends CI_Controller
{
	function __construct()
	{
			
		parent::__construct();
		$this->load->Model('repair_information_mdl');
		$this->load->Model('bio_medical_mdl');
	}

	public function index()
	{
		$this->data['repair_information_list']=$this->repair_information_mdl->get_all_repair_information();
		
		// echo '<pre>';
		// print_r($this->data['distributor_list']);
		// die();

		$this->data['editurl']=base_url().'biomedical/repair_information/editrepair_information';
		$this->data['deleteurl']=base_url().'biomedical/repair_information/deleterepair_information';
		$this->data['listurl']=base_url().'biomedical/repair_information/list_repair_information';
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
			->build('repair_information/v_repairinformation', $this->data);
	}

	
    public function list_repair_information()
    {
    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$data=array();
			$template=$this->load->view('repair_information/v_repairrequest_lists',$data,true);
			print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));
	   		 exit;	
		}
		else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}
    }
	public function form_repair_information()
	{
		$this->load->view('repair_information/v_repairinformationform');
	}

	public function save_repair_information()
	{   
		// echo '<pre>';
		// print_r($this->input->post());
		// die();
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		try {
			 $this->form_validation->set_rules($this->repair_information_mdl->validate_settings_repair_information);
			  if($this->form_validation->run()==TRUE)
			 {

            $trans = $this->repair_information_mdl->rere_information_save();
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


	public function editrepair_information()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$id=$this->input->post('id');
		
			$data['repair_data']=$this->repair_information_mdl->get_all_repair_information(array('rere_repairrequestid'=>$id));
			// echo "<pre>";
			// print_r($data['service_techlist']);
			// die();
			$tempform = $this->load->view('repair_information/v_repairinformationform',$data,true);
			// echo $tempform;
			// die();
			if(!empty($data['repair_data']))
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

	public function deleterepair_information()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$id=$this->input->post('id');
			$trans=$this->repair_information_mdl->remove_repair_information();
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
	public function get_repair_information()
	{	

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$equid=$this->input->post('id');
			//print_r($equid);die;
			$data['rere_data'] = $this->bio_medical_mdl->get_biomedical_inventory(array('bm.bmin_equipid'=>$equid));
			//echo "<pre>";print_r($data['rere_data']);die();
			
			$tempform = $this->load->view('repair_information/v_repinformation',$data,true);
			// echo $tempform;
			// die();
			if($data['rere_data'])
			{
				print_r(json_encode(array('status'=>'success','tempform'=>$tempform,'message'=>'Successfully Selected!!')));
	       		exit;	
			}
			else
			{
				print_r(json_encode(array('status'=>'error','message'=>'Unsuccessfully Selected')));
	       		exit;	
			}
		

		}
		else
		{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}
	}

	// public function un_repairable_form()
	// {
	// 	$seo_data='';
	// 	if($seo_data)
	// 	{
	// 		//set SEO data
	// 		$this->page_title = $seo_data->page_title;
	// 		$this->data['meta_keys']= $seo_data->meta_key;
	// 		$this->data['meta_desc']= $seo_data->meta_description;
	// 	}
	// 	else
	// 	{
	// 		//set SEO data
	// 	    $this->page_title = ORGA_NAME;
	// 	    $this->data['meta_keys']= ORGA_NAME;
	// 	    $this->data['meta_desc']= ORGA_NAME;
	// 	}
	// 	$this->template
	// 		->set_layout('general')
	// 		->enable_parser(FALSE)
	// 		->title($this->page_title)
	// 		->build('repair_information/v_unrepairinformation', $this->data);
	// }

}