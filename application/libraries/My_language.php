<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class My_language 
{

	protected $ci;	

	protected $languages = array(
		'en' => 'english',
		'np' => 'nepali'
	);
	
	
	public function __construct() 
	{
		$this->ci =& get_instance();			
			
		//get language short code to find the main language folder
		$lang_code = $this->ci->session->userdata('lang');
		// echo $lang_code;
		// $langload=$this->langload();
		if($lang_code=='np')
		{

		 $this->ci->config->set_item('language', 'nepali');
		}
		else
		{
			 $this->ci->config->set_item('language', 'english');
		}
		// $this->ci->config->set_item('lang', $lang_short_code);
		$this->ci->lang->load('general');
	
	}

	// default language: first element of $this->languages

	function langload()
	{
		$lang = $this->languages;
		
		foreach($lang as $lang => $language)
		{
			$lang;
		}
	}
	
}