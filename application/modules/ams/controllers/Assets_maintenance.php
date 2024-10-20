<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Assets_maintenance extends CI_Controller
{
	function __construct()
	{
			
		parent::__construct();
		
		$this->load->Model('Assets_maintenance_mdl');
		$this->load->library('upload');
		$this->load->library('image_lib');
		$this->load->helper('file');
		$this->load->helper('form');

	}

	public function index()
	{
		//echo "aa";die;
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
		$this->data['breadcrumb']='Assets Maintenance';

		$this->data['tab_type']="Log";

		$this->session->unset_userdata('id');
		$this->page_title='Assets Assets';
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('assets_maintenance/v_assets_maintenance_common', $this->data);

	}

	public function preventive()
	{
		//echo "aa";die;
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
		$this->data['breadcrumb']='Assets Maintenance';

		$this->data['tab_type']="Log";

		$this->session->unset_userdata('id');
		$this->page_title='Assets Assets';
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('assets_maintenance/v_assets_maintenance_common', $this->data);

	}

	public function corrective()
	{
		//echo "aa";die;
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
		$this->data['breadcrumb']='Assets Maintenance';

		$this->data['tab_type']="Log";

		$this->session->unset_userdata('id');
		$this->page_title='Assets Assets';
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('assets_maintenance/v_assets_maintenance_common', $this->data);

	}
	public function emergency()
	{
		//echo "aa";die;
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
		$this->data['breadcrumb']='Assets Maintenance';

		$this->data['tab_type']="Log";

		$this->session->unset_userdata('id');
		$this->page_title='Assets Assets';
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('assets_maintenance/v_assets_maintenance_common', $this->data);

	}

}