<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Useraccess extends CI_Controller {
	function __construct() {
		parent::__construct();
		
		// if(SITE_STATUS == '1'){
		// 	//redirect to live site
		// 	redirect(site_url(''));
		// }else if(SITE_STATUS == '2'){
		// 	//redirect to offline page
		// 	redirect(site_url('/offline'));
		// }
	}
	
	public function index()
	{
		$key=$this->input->post('key');
		
		if($this->input->server('REQUEST_METHOD')=='POST' && $this->input->post('key',TRUE))
		{
			$accesskey=$this->general->check_user_access_key($key);
				if($accesskey)
				{
					
					$this->save_log_user_access('Y','Success');
					$this->session->set_userdata('ACCESS_KEY','YES');
					redirect(site_url('/login'),'refresh'); exit;
			}
			else
			{
				$this->save_log_user_access('N','Invalid Access Key');
				$this->session->set_flashdata('message','Invalid Access Key');
				redirect(site_url('/useraccess'),'refresh'); exit;
			}

		}

	
		$this->data='';
		$this->page_title = '';
		$this->load->view('v_useraccess',$this->data);
	}

	public function save_log_user_access($isaccess,$reason)
	{
			$ipaddres=$this->general->get_real_ipaddr();
	 		$macadd=$this->general->get_Mac_Address();
			$postdata['usal_postdatead']=CURDATE_EN;
			$postdata['usal_postdatebs']=CURDATE_NP;
			$postdata['usal_posttime']=$this->general->get_currenttime();
			$postdata['usal_computername']=gethostname();
			$postdata['usal_postip']=$ipaddres;
			$postdata['usal_postmac']=$macadd;
			$postdata['usal_isaccess']=$isaccess;
			$postdata['usal_reason']=$reason;
			if(!empty($postdata))
			{
				$this->db->insert('usal_useraccesslog',$postdata);
			}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */