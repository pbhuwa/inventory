<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Message extends CI_Controller {

	function __construct() {
		parent::__construct();
			$this->load->model('message_mdl');
	}
	
	
	public function index()
	{
		
		$frmdatedb=CURDATE_EN;
		$todatedb=CURDATE_EN;
		$srch=array('loac_logindatead>='=>$frmdatedb,'loac_logindatead<='=>$todatedb);

		$this->data['access_log_list']=$this->access_log_mdl->get_access_log_rec($srch);
		$this->data['table_list']=$this->access_log_mdl->get_table_list();
		// echo "<pre>";
		// print_r($this->data['table_list']);
		// die();
		$this->page_title='Message';
		
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('access_log/access_log_list', $this->data);
			

	}



}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */