<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Insurance_Company_mdl extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
		$this->table='inco_insurancecompany';
		$this->curtime=$this->general->get_currenttime();
        $this->userid=$this->session->userdata(USER_ID);
        $this->username = $this->session->userdata(USER_NAME);
        $this->depid = $this->session->userdata(USER_DEPT);
        $this->storeid = $this->session->userdata(STORE_ID);
        $this->mac=$this->general->get_Mac_Address();
        $this->ip=$this->general->get_real_ipaddr();
        $this->locationid=$this->session->userdata(LOCATION_ID);
	}

	public $validate_settings_insurance_company = array(               
         array('field' => 'inco_name', 'label' => 'Company Name ', 'rules' => 'trim|required|xss_clean'),
           // array('field' => 'inco_email', 'label' => 'Email ', 'rules' => 'trim|valid_email|xss_clean'),
       );
	
	public function insurance_company_save()
	{
		$postdata=$this->input->post();
		$id=$this->input->post('id');
		unset($postdata['id']);
		if($id)
		{
		$postdata['inco_modifydatead']=CURDATE_EN;
		$postdata['inco_modifydatebs']=CURDATE_NP;
		$postdata['inco_modifytime']=date('H:i:s');
		$postdata['inco_modifyby']=$this->session->userdata(USER_ID);
		$postdata['inco_modifyip']=$this->general->get_real_ipaddr();
		$postdata['inco_modifymac']=$this->general->get_Mac_Address();
		if(!empty($postdata))
		{
			$this->db->update($this->table,$postdata,array('inco_id'=>$id));
			$rowaffected=$this->db->affected_rows();
			if($rowaffected)
			{
				return $rowaffected;
			}
			else
			{
				return false;
			}
		}
	}
		else
		{
		$postdata['inco_postdatead']=CURDATE_EN;
		$postdata['inco_postdatebs']=CURDATE_NP;
		$postdata['inco_posttime']=date('H:i:s');
		$postdata['inco_postby']=$this->session->userdata(USER_ID);
		$postdata['inco_orgid']=$this->session->userdata(ORG_ID);
		$postdata['inco_postip']=$this->general->get_real_ipaddr();
		$postdata['inco_postmac']=$this->general->get_Mac_Address();
		$postdata['inco_locationid']=$this->session->userdata(LOCATION_ID);
		
		// echo "<pre>";
		// print_r($postdata);
		// die();

		if(!empty($postdata))
		{
			$this->db->insert($this->table,$postdata);
			$insertid=$this->db->insert_id();
			if($insertid)
			{
				return $insertid;
			}
			else
			{
				return false;
			}
		}
	}
		
		return false;

	}

	public function get_all_insurance_company($srorgal=false,$limit=false,$offset=false,$order=false,$order_by=false)
	{
		$this->db->select('*');
		$this->db->from('inco_insurancecompany in');
		
		if($srorgal)
		{
			$this->db->where($srorgal);
		}
		$query = $this->db->get();
		// echo $this->db->last_query();
		// die();
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();		
			return $data;		
		}		
		return false;
	}

	public function remove_insurance_company()
	{
		$id=$this->input->post('id');
		if($id)
		{
			$this->db->delete($this->table,array('inco_id'=>$id));
			$rowaffected=$this->db->affected_rows();
			if($rowaffected)
			{
				return $rowaffected;
			}
			return false;
		}
		return false;
	}



	public function check_exist_inco_name_for_other($inco_name = false, $id = false){
		$data = array();
		if($inco_name)
		{
				$this->db->where('inco_name',$inco_name);
		}
		if($id)
		{
			$this->db->where('inco_id!=',$id);
		}

		$query = $this->db->get($this->table);
		// echo $this->db->last_query();
		// die();

		if ($query->num_rows() > 0) 
		{
			$data=$query->row();	
			return $data;			
		}
		return false;
	}

}