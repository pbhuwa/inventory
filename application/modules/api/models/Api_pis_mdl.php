<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api_pis_mdl extends CI_Model 
{

	public function __construct() 
	{
		parent::__construct();
		$this->db2=$this->load->database('pis',true);
		
	}

	function get_staff_postion_other_db()
	{
		// print_r($this->db2);
		// die();
		$this->db2->select('
			POSITIONID  as stpo_staffpositionid, 
			POSITIONNAME   as stpo_staffposition
			');
		$this->db2->order_by('POSITIONID','ASC');
		$query=$this->db2->get('STAFFPOSITION');

		if($query->num_rows()>0)
		{
			return $query->result();
		}
		return false;

	}

	function get_staff_information_other_db()
	{	
	$this->db2->select('
            STAFFCODE 			as stin_code,
            FIRSTNAME 			as stin_fname,
            LASTNAME 			as stin_lname,
            GENDER 				as stin_gender,
            DOBVS 				as stin_dobad,
            DOBAD 				as stin_dobbs,
            PHONE 				as stin_phone,
            POSITIONID 			as stin_positionid,
            DEPARTMENTID 		as stin_departmentid,
            JOINDATEVS 			as stin_joindatead,
            JOINDATEAD 			as stin_joindatebd,
            JOBSTATUSID 		as stin_jobstatus,
            MARITALSTATUS 		as stin_maritalstatus,
            MOBILENO 			as stin_mobile,
            EMAIL 				as stin_email,
          
			');
		$query=$this->db2->get('STAFF');

		if($query->num_rows()>0)
		{
			return $query->result();
		}
		return false;
	}

	

    
}
        
                
                 
                
                
              
               
                     
                  
            
    
                
               
                    
                
                
                     
                   