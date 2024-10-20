<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Offline extends CI_Controller {
	function __construct() {
		parent::__construct();
		
		// if(SITE_STATUS == '1')
		// {
		// 	//redirect to live site
		// 	redirect(site_url(''));
		// }else if(SITE_STATUS == '3'){
		// 	//redirect to maintainance page
		// 	redirect(site_url('/maintainance'));
		// }
	}
	
	
	public function index()
	{
		$cms_id = '14';
		$this->data['offline_msg'] = $this->general->get_cms_details($cms_id);
		//print_r($this->data['offline_msg']);
		//set SEO data
		$this->page_title = $this->data['offline_msg']->heading." - ". WEBSITE_NAME;
		//$this->data['meta_ keys'] = isset($this->data['offline_msg']->meta_keys)? $this->data['offline_msg']->meta_keys : DEFAULT_PAGE_TITLE;
		//$this->data['meta_desc'] = isset($this->data['offline_msg']->meta_desc)? $this->data['offline_msg']->meta_desc : DEFAULT_PAGE_TITLE;
		
		$this->load->view('offline',$this->data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */