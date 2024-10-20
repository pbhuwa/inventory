<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Colorcode_set extends CI_Controller
{
	function __construct()
	{
		    parent::__construct();
			$this->load->model('colorcode_set_mdl');
			$this->load->library('general');
			// $this->orgid= $this->session->userdata(ORG_ID);
	}
	
	public function index()
	{
		
		$this->data['colorcode_data']=$this->colorcode_set_mdl->get_colorcode_set_list();
		 // echo "<pre>"; print_r($this->data['category']);die();
		// $category=$this->data['category']->cons_categoty;

		// $this->data['colorcode_list']=$this->colorcode_set_mdl->get_colorcode_set_list(false,array('cons_categoty'=>$category));
    	$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->build('colorcode_set/v_colorcode_set', $this->data);	
	}
	public function add_group_popup()
	{
		
			if ($_SERVER['REQUEST_METHOD'] === 'POST') 

			{
			     $this->data['colorcode_set_list']='';
				$template=$this->load->view('colorcode_set/v_add_colorcode_popup',$this->data,true);

				print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template,'tempform'=>$template)));

		   		exit;	
			}
			else
			{
				print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

		        exit;

			}
	}

public function save_colorcode_set($id=false)
	{
		
		$trans = $this->colorcode_set_mdl->save_colorcode_set();

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
	public function update_colorcode()
	{
		//print_r($this->input->post());
		// die; 
//		$this->data['colorcode_list']=$this->system_setting_mdl->get_all_colorcode();

		$trans = $this->colorcode_set_mdl->update_colorcode();

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

	

	public function reload_colorcode_set_list()
	{
		$this->data['colorcode_data']=$this->colorcode_set_mdl->get_colorcode_set_list();
		
		$template=$this->load->view('colorcode_set/v_colorcode_set_list',$this->data,true);

		print_r(json_encode(array('status'=>'success','message'=>'Successfully Reloded!!','template'=>$template)));

   		 exit;
	}
}