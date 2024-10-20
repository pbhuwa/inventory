<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api_patient extends CI_Controller {

	function __construct() {
		parent::__construct();
			$this->load->model('Api_patients_mdl');
	}
	
	
	public function index()
	{
		/*$patientlist=$this->api_mdl->getpatientfromotherdb();*/	
		// echo "<pre>";
		// print_r($patientlist);
		// die();
		// print_r(array_change_key_case($patientlist,CASE_LOWER));
		// $this->db->insert_batch('pama_patientmain',$patientlist);
		 $patientvisit=$this->api_mdl->getpatientvisitfromotherdb();
		 echo "<pre>";
		 print_r($patientvisit);
		 die();

		$this->db->insert_batch('pavi_patientvisit',$patientvisit);
	}	

	public function other_db_data()
	{
		// $country=$this->api_mdl->get_countryfromotherdb();
		// $this->db->insert_batch('coun_country',$country);

		// $zone=$this->api_mdl->get_zonefromotherdb();
		// $this->db->insert_batch('zona_zonename',$zone);

		// $district=$this->api_mdl->get_districtfromotherdb();
		// $this->db->insert_batch('dist_district',$district);

		// $relation=$this->api_mdl->get_relationfromotherdb();
		// $this->db->insert_batch('rela_relation',$relation);

		// $occupation=$this->api_mdl->get_occupationfromotherdb();
		// $this->db->insert_batch('occu_occupation',$occupation);
	}

	public function nurse_triage_db_data()
	{
		
	}

	public function testname()
	{
		$testname=$this->api_mdl->get_testnamefromotherdb();
		// echo "<pre>";
		// print_r($testname);
		// die();

		 $this->db->insert_batch('xw_tsna_testname',$testname);

	}

	
	public function genericlist()
	{
		$genericlist=$this->api_mdl->get_genericlistfromotherdb();
		// echo "<pre>";
		// print_r($genericlist);
		// die();

		 $this->db->insert_batch('xw_gena_genericname',$genericlist);
	}

	public function depname()
	{
		 $depname=$this->api_mdl->getdepnamefromotherdb();
		//  	echo "<pre>";
		// print_r($depname);
		// die();
		 $this->db->insert_batch('xw_dept_department',$depname);


	}

	/*-------Doctor Template------*/

	public function complain()
	{
		$complain=$this->api_mdl->getcomplainfromotherdb();
		//  	echo "<pre>";
		// print_r($complain);
		// die();
		
  	   $this->db->insert_batch('xw_code_complaindetail',$complain);
	}

	public function history()
	{
		$complain=$this->api_mdl->gethistoryfromotherdb();
		//  	echo "<pre>";
		// print_r($complain);
		// die();
		
  	   $this->db->insert_batch('xw_code_complaindetail',$complain);
	}

	public function pharmacy_generic_brandname()
	{
		$gen_brand=$this->api_mdl->get_gen_brand_pharmacy();
		echo "<pre>";
		print_r($gen_brand);
		die();



	}


	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */