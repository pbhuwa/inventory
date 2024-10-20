<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Direct_receive extends CI_Controller
{
	function __construct()
	{
			
		parent::__construct();
		$this->load->Model('stock_requisition_mdl');
		
	}
	public function index()
	{  
		// echo "echo call ";die;
		// $this->data['editurl']=base_url().'stock_inventory/challan/edit_challan';
		// $this->data['deleteurl']=base_url().'stock_inventory/challan/delete_challan';
		// $this->data['listurl']=base_url().'dep_change/list_challan';
		$this->data['equipmentcategory']=$this->general->get_tbl_data('*','eqca_equipmentcategory',false,'eqca_equipmentcategoryid','DESC');
		$this->data['depatrment']=$this->general->get_tbl_data('*','dept_department',false,'dept_depid','DESC');
		$this->data['item_all']=$this->general->get_tbl_data('*','itli_itemslist',false,'itli_itemlistid','DESC');

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
			->build('stock/v_stock_requisition', $this->data);
	}
	public function save_requisition()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		try {
			$this->form_validation->set_rules($this->stock_requisition_mdl->validate_settings_stock_requisition);
			if($this->form_validation->run()==TRUE)
			{
				$trans = $this->stock_requisition_mdl->stock_requisition_save();
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