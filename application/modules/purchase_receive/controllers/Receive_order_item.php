<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Receive_order_item extends CI_Controller
{
	function __construct()
	{
			
		parent::__construct();
		$this->load->Model('receive_order_model');
		
	}
	public function index()
	{  
		$this->data['equipmentcategory']=$this->general->get_tbl_data('*','eqca_equipmentcategory',false,'eqca_equipmentcategoryid','DESC');
		$this->data['depatrment']=$this->general->get_tbl_data('*','dept_department',false,'dept_depid','DESC');
		$this->data['item_all']=$this->general->get_tbl_data('*','itli_itemslist',false,'itli_itemlistid','DESC');
		$this->data['unit_all'] = $this->general->get_tbl_data('*','unit_unit',false,'unit_unitid','DESC');
		$this->data['tax_all'] = $this->general->get_tbl_data('*','tava_taxvalue',false,'tava_taxvalueid','DESC');
		$this->data['product_all'] = $this->general->get_tbl_data('*','prod_product',false,'prod_productid','DESC');
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
			->build('receive_order_item/v_receive_order_item', $this->data);
	}
	public function order_lists()
	{	$this->data['depatrment']=$this->general->get_tbl_data('*','dept_department',false,'dept_depid','DESC');
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$order_muner = $this->input->post('order_no');
			$this->data['orderno'] =  $this->input->post('order_no');
			if($order_muner)
			{
				$this->data['order_item_details'] = $this->receive_order_model->get_selected_order();
				
				$template=$this->load->view('receive_order_item/v_receive_order_form',$this->data,true);
			// echo $template; die();
			if($this->data['order_item_details']>0)
			{
					print_r(json_encode(array('status'=>'success','message'=>'','template'=>$template)));
	            	exit;
			}
			else{
				print_r(json_encode(array('status'=>'error','message'=>'')));
	            	exit;
			}
				print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));
	   		 exit;	
			}
		}
	 	else
	    {
	    	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	            exit;
	    }
	}
	public function save_receive_order_item()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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


		try {
			$this->form_validation->set_rules($this->receive_order_model->validate_settings_receive_order_item);
			if($this->form_validation->run()==TRUE)
			{
				$trans = $this->receive_order_model->order_item_receive_save();
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
	
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */