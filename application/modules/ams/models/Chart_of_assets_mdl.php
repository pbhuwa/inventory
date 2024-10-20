<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chart_of_assets_mdl extends CI_Model 
{

	public function __construct() 
	{
		parent::__construct();
		$this->userid = $this->session->userdata(USER_ID);
        $this->username = $this->session->userdata(USER_NAME);
        $this->curtime = $this->general->get_currenttime();
        $this->mac = $this->general->get_Mac_Address();
        $this->ip = $this->general->get_real_ipaddr();
        $this->locationid=$this->session->userdata(LOCATION_ID);
        $this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
        $this->orgid=$this->session->userdata(ORG_ID);
		
	}

	
	
	
}
