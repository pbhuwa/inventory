<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lease_company_mdl extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
		$this->table='leco_leasocompany';
		$this->curtime=$this->general->get_currenttime();
        $this->userid=$this->session->userdata(USER_ID);
        $this->username = $this->session->userdata(USER_NAME);
        $this->depid = $this->session->userdata(USER_DEPT);
        $this->storeid = $this->session->userdata(STORE_ID);
        $this->mac=$this->general->get_Mac_Address();
        $this->ip=$this->general->get_real_ipaddr();
        $this->locationid=$this->session->userdata(LOCATION_ID);
	}

	public $validate_settings_lease_company = array(               
         array('field' => 'leco_companyname', 'label' => 'Company Name ', 'rules' => 'trim|required|xss_clean'),
           // array('field' => 'leco_email1', 'label' => 'Email ', 'rules' => 'trim|valid_email|xss_clean'),
       );
	
	public function lease_company_save()
	{
		$postdata=$this->input->post();
		$id=$this->input->post('id');
		unset($postdata['id']);
		if($id)
		{
		$postdata['leco_modifydatead']=CURDATE_EN;
		$postdata['leco_modifydatebs']=CURDATE_NP;
		$postdata['leco_modifytime']=date('H:i:s');
		$postdata['leco_modifyby']=$this->session->userdata(USER_ID);
		$postdata['leco_modifyip']=$this->general->get_real_ipaddr();
		$postdata['leco_modifymac']=$this->general->get_Mac_Address();
		if(!empty($postdata))
		{
			$this->db->update($this->table,$postdata,array('leco_leasecompanyid'=>$id));
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
		$postdata['leco_postdatead']=CURDATE_EN;
		$postdata['leco_postdatebs']=CURDATE_NP;
		$postdata['leco_posttime']=date('H:i:s');
		$postdata['leco_postby']=$this->session->userdata(USER_ID);
		$postdata['leco_orgid']=$this->session->userdata(ORG_ID);
		$postdata['leco_postip']=$this->general->get_real_ipaddr();
		$postdata['leco_postmac']=$this->general->get_Mac_Address();
		$postdata['leco_locationid']=$this->session->userdata(LOCATION_ID);
		
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

	public function get_all_lease_company($srorgal=false,$limit=false,$offset=false,$order=false,$order_by=false)
	{
		$this->db->select('*');
		$this->db->from('leco_leasocompany in');
		
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

	public function remove_lease_company()
	{
		$id=$this->input->post('id');
		if($id)
		{
			$this->db->delete($this->table,array('leco_leasecompanyid'=>$id));
			$rowaffected=$this->db->affected_rows();
			if($rowaffected)
			{
				return $rowaffected;
			}
			return false;
		}
		return false;
	}



	public function check_exist_leco_companyname_for_other($leco_companyname = false, $id = false){
		$data = array();
		if($leco_companyname)
		{
				$this->db->where('leco_companyname',$leco_companyname);
		}
		if($id)
		{
			$this->db->where('leco_leasecompanyid!=',$id);
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