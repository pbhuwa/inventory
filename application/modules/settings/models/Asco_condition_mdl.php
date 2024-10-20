<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Asco_condition_mdl extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
		$this->table='asco_condition';
		$this->curtime=$this->general->get_currenttime();
        $this->userid=$this->session->userdata(USER_ID);
        $this->username = $this->session->userdata(USER_NAME);
        $this->depid = $this->session->userdata(USER_DEPT);
        $this->storeid = $this->session->userdata(STORE_ID);
        $this->mac=$this->general->get_Mac_Address();
        $this->ip=$this->general->get_real_ipaddr();
        $this->locationid=$this->session->userdata(LOCATION_ID);
	}

	public $validate_settings_asco_condition = array(               
         array('field' => 'asco_conditionname', 'label' => 'Asco Condition Name ', 'rules' => 'trim|required|xss_clean'),
           // array('field' => 'asco_email1', 'label' => 'Email ', 'rules' => 'trim|valid_email|xss_clean'),
       );
	
	public function asco_condition_save()
	{
		$postdata=$this->input->post();
		$id=$this->input->post('id');
		unset($postdata['id']);
		if($id)
		{
		$postdata['asco_modifydatead']=CURDATE_EN;
		$postdata['asco_modifydatebs']=CURDATE_NP;
		$postdata['asco_modifytime']=date('H:i:s');
		$postdata['asco_modifyby']=$this->session->userdata(USER_ID);
		$postdata['asco_modifyip']=$this->general->get_real_ipaddr();
		$postdata['asco_modifymac']=$this->general->get_Mac_Address();
		if(!empty($postdata))
		{
			$this->db->update($this->table,$postdata,array('asco_ascoid'=>$id));
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
		$postdata['asco_postdatead']=CURDATE_EN;
		$postdata['asco_postdatebs']=CURDATE_NP;
		$postdata['asco_posttime']=date('H:i:s');
		$postdata['asco_postby']=$this->session->userdata(USER_ID);
		$postdata['asco_orgid']=$this->session->userdata(ORG_ID);
		$postdata['asco_postip']=$this->general->get_real_ipaddr();
		$postdata['asco_postmac']=$this->general->get_Mac_Address();
		$postdata['asco_locationid']=$this->session->userdata(LOCATION_ID);
		
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

	public function get_all_asco_condition($srorgal=false,$limit=false,$offset=false,$order=false,$order_by=false)
	{
		$this->db->select('*');
		$this->db->from('asco_condition as');
		
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

	public function remove_asco_condition()
	{
		$id=$this->input->post('id');
		if($id)
		{
			$this->db->delete($this->table,array('asco_ascoid'=>$id));
			$rowaffected=$this->db->affected_rows();
			if($rowaffected)
			{
				return $rowaffected;
			}
			return false;
		}
		return false;
	}



	public function check_exist_asco_conditionname_for_other($asco_conditionname = false, $id = false){
		$data = array();
		if($asco_conditionname)
		{
				$this->db->where('asco_conditionname',$asco_conditionname);
		}
		if($id)
		{
			$this->db->where('asco_ascoid!=',$id);
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