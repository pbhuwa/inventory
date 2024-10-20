<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Current_stock_details extends CI_Controller
{
	function __construct()
	{	
		parent::__construct();
		$this->load->Model('current_stock_mdl');
	}
	public function index()
	{
		$this->data['store_type']=$this->general->get_tbl_data('*','store',false,'st_store_id','ASC');
		$this->data['current_stock']='detail';
		//echo "details";die;
		$seo_data='';
		if($seo_data)
		{	//set SEO data
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
			->build('current_stock/v_current_stock_details_main', $this->data);
    }
}