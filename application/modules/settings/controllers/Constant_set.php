<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Constant_set extends CI_Controller
{
	function __construct()
	{
		    parent::__construct();
			$this->load->model('constant_set_mdl');
			$this->load->library('general');
			// $this->orgid= $this->session->userdata(ORG_ID);
	}
	
	public function index()
	{
		
		$this->data['category']=$this->constant_set_mdl->get_constant_category();
		 // echo "<pre>"; print_r($this->data['category']);die();
		// $category=$this->data['category']->cons_categoty;

		// $this->data['constant_list']=$this->constant_set_mdl->get_constant_set_list(false,array('cons_categoty'=>$category));
    	$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->build('constant_set/v_constant_set', $this->data);	
	}
	public function add_group_popup()
	{
		
			if ($_SERVER['REQUEST_METHOD'] === 'POST') 

			{
			     $this->data['constant_set_list']='';
				$template=$this->load->view('constant_set/v_add_group_popup',$this->data,true);

				print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template,'tempform'=>$template)));

		   		exit;	
			}
			else
			{
				print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

		        exit;

			}
	}

public function save_constant_set($id=false)
	{
		
		$trans = $this->constant_set_mdl->save_constant_set();

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
	public function update_constant()
	{
		//print_r($this->input->post());
		// die; 
//		$this->data['constant_list']=$this->system_setting_mdl->get_all_constant();

		$trans = $this->constant_set_mdl->update_constant();

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

	

	public function reload_constant_set_list()
	{
		$this->data['category']=$this->constant_set_mdl->get_constant_category();
		
		$template=$this->load->view('constant_set/v_constant_set_list',$this->data,true);

		print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));

   		 exit;
	}
}