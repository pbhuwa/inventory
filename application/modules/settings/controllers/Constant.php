<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Constant extends CI_Controller
{
	function __construct()
	{
			
		parent::__construct();
			$this->load->model('constant_mdl');
			
			$this->load->library('general');
			// $this->orgid= $this->session->userdata(ORG_ID);

	}
	
	public function index()
	{
		$this->data['const']=$this->constant_mdl->get_constant_list();
    	$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->build('constant/v_constant_list', $this->data);	
	}
	public function constant_popup()
	{
		
			if ($_SERVER['REQUEST_METHOD'] === 'POST') 
			{
				$id=$this->input->post('id');
				$this->data['constant_list']=$this->constant_mdl->get_constant_list($id);
	
				$template=$this->load->view('constant/v_edit_popup.php',$this->data,true);

				print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template,'tempform'=>$template)));

		   		exit;	
			}
			else
			{
				print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

		        exit;

			}
	}

	public function edit_constant($id=false)
	{
		$id=$this->input->post('id');
		
		$trans = $this->constant_mdl->edit_constant($id);

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
	
	public function reload_constant_list()
	{
		$this->data['const']=$this->constant_mdl->get_constant_list();
		
		$template=$this->load->view('constant/v_constant_table',$this->data,true);

		print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));

   		 exit;
	}
}