<?php 

class Pdf { 
	function __construct() { 
		$CI = & get_instance(); 
		log_message('Debug', 'mPDF class is loaded.'); 
		} 

	function load($param=NULL) { 
		 include_once APPPATH.'/third_party/mpdf_0/mpdf.php';

 

        if ($params == NULL)

        {

            $param = '"en-GB-x","A4","","",10,10,10,10,6,3';

        }

 

        return new mPDF($param);
		} 
	}

?>