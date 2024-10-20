<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Maintainance extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if (SITE_STATUS == '1') {
			//redirect to live site
			redirect(site_url(''));
		} else if (SITE_STATUS == '2') {
			//redirect to offline page
			redirect(site_url('/offline'));
		}
	}
	public function index()
	{
		$parent_id = '13';
		$cms_langid = BACKEND_DEFAULT_LANG;
		$this->data['maintainance_msg'] = $this->general->get_cms_details($parent_id, $cms_langid);
		//print_r($this->data['offline_msg']);
		if ($this->input->server('REQUEST_METHOD') == 'POST' && $this->input->post('key', TRUE)) {
			//check whether key is matched with key or not
			$maintainance_key = $this->input->post('key', TRUE);
			$this->db->select('maintainance_key');
			$query = $this->db->get("site_settings");
			if ($query->num_rows() > 0) {
				$data = $query->row();
				if ($maintainance_key === $data->maintainance_key) {
					//set session for maintainance
					$this->session->set_userdata('MAINTAINANCE_KEY', 'YES');
					//echo $this->session->userdata('MAINTAINANCE_KEY');exit;
					redirect(site_url(), 'refresh');
					exit;
				}
			}
		}
		//set SEO data
		$this->page_title = $this->data['maintainance_msg']->heading . " - " . WEBSITE_NAME;
		$this->load->view('maintainance', $this->data);
	}
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */