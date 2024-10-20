<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Manage_return extends CI_Controller
{
	function __construct()
	{
			
		parent::__construct();
		$this->load->Model('manage_return_mdl');
		
	}
	public function index()
	{
		$this->data['department']=$this->general->get_tbl_data('*','dept_department',false,'dept_depid','DESC');
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
			->build('manage_return/v_manage_return', $this->data);
	}
	public function save_department()
	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		try {
			if($this->input->post('id'))
			{
				if(MODULES_UPDATE=='N')
				{
				$this->general->permission_denial_message();
				exit;
				}
			}
			else
			{
				if(MODULES_INSERT=='N')
				{
				$this->general->permission_denial_message();
				exit;
				}
			}
			$id=$this->input->post('id');
			if($id)
			{
			$this->form_validation->set_rules($this->manage_return_mdl->validate_settings_department);
			}
			else
			{
			$this->form_validation->set_rules($this->manage_return_mdl->validate_settings_department);
			}
			
			if($this->form_validation->run()==TRUE)
			{
		$trans = $this->manage_return_mdl->department_save();
		if($trans)
		{
			print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully')));
			exit;
		}
		else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Record Save Successfully')));
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
		}else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
		exit;
		}
	}
	public function change_details()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$this->data=array();
			$cond='';
			$invoice_no = $this->input->post('invoice_no');
			$fyear =$this->input->post('fiscal_year');
			$this->data['departmentdata']=$this->general->get_tbl_data('*','dept_department',false,'dept_depid','DESC');
			$this->data['department']=$this->general->get_tbl_data('sama_salemasterid,sama_invoiceno,sama_requisitionno,sama_manualbillno,sama_storeid,sama_soldby,sama_fyear,sama_remarks,sama_manualbillno','sama_salemaster',array('sama_fyear'=>$fyear,'sama_invoiceno'=>$invoice_no),'sama_salemasterid','DESC');
			// echo $this->db->last_query();
			//echo"<pre>";print_r($this->data['department']);die;
			$template=$this->load->view('change_department/v_form_details',$this->data,true);
			print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','tempform'=>$template)));
	   		 exit;	
		}
		else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}	
	}

	public function change_reloadform()
	{	$this->data=array();
		$this->data['departmentdata']=$this->general->get_tbl_data('*','dept_department',false,'dept_depid','DESC');
		$this->load->view('change_department/v_department_form',$this->data);
	}
}