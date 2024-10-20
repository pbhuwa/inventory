<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Permission_denial extends CI_Controller {
	function __construct() {
		parent::__construct();
		
		
	}
	
	public function index()
	{
		// echo "Permission_denial";
		$this->data='';
		$this->data['refer_url']=!empty($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'javascript:void(0)';
		// echo $this->data['refer_url'];
		// die();
		$this->page_title='Permission denial';
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('v_permission_denial', $this->data);
	}

	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */