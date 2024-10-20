<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 

class M57pdf {

 

    public function __construct() {

    

        $this->ci =& get_instance();

        

    }

 

    function load($param=NULL)

    {
        // error_reporting(0);
       include_once APPPATH.'/third_party/mpdf60/mpdf.php';

 

        if ($params == NULL)

        {

            $param = '"en-GB-x","A4","","",10,10,10,10,6,3';

        }

 

        return new mPDF($param);

    }

}