<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Community_mdl extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
		$this->table='comm_community';
	}


	public $validate_settings_community = array(  
		array('field' => 'comm_community', 'label' => 'Community', 'rules' => 'trim|required|xss_clean')

		);
	
	
	public function community_save()
	{
		$postdata=$this->input->post();
		$id=$this->input->post('id');
		unset($postdata['id']);
		if($id)
		{
		$postdata['comm_modifydatead']=CURDATE_EN;
		$postdata['comm_modifydatebs']=CURDATE_NP;
		$postdata['comm_modifytime']=date('H:i:s');
		$postdata['comm_modifyip']='';
		$postdata['comm_modifyip']=$this->general->get_real_ipaddr();
		$postdata['comm_modifymac']=$this->general->get_Mac_Address();
		if(!empty($postdata))
		{
			$this->db->update($this->table,$postdata,array('comm_communityid'=>$id));
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
		$postdata['comm_postdatead']=CURDATE_EN;
		$postdata['comm_postdatebs']=CURDATE_NP;
		$postdata['comm_posttime']=date('H:i:s');
		$postdata['comm_postby']='';
		$postdata['comm_postip']=$this->general->get_real_ipaddr();
		$postdata['comm_postmac']=$this->general->get_Mac_Address();
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

	public function get_all_community($srchcol=false)
	{
		$this->db->select('*');
		$this->db->from('comm_community');
		if($srchcol)
		{
			$this->db->where($srchcol);
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


	public function get_all_departmenttype($srchcol=false)
	{
		$this->db->select('dt.*');
		$this->db->from('dety_departmenttype dt');
		if($srchcol)
		{
			$this->db->where($srchcol);
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


	public function remove_community()
	{
		$id=$this->input->post('id');
		if($id)
		{
			$this->db->delete($this->table,array('comm_communityid'=>$id));
			$rowaffected=$this->db->affected_rows();
			if($rowaffected)
			{
				return $rowaffected;
			}
			return false;
		}
		return false;
	}

	public function check_exit_commcode_for_other($depcode=false,$id=false)
		{
		$data = array();
		if($depcode)
		{
				$this->db->where('comm_depcode',$depcode);
		}
		if($id)
		{
			$this->db->where('comm_depid',$id);
		}

		$query = $this->db->get("comm_department");
		if ($query->num_rows() > 0) 
		{
			$data=$query->row();	
			return $data;			
		}
		return false;
		}

	public function check_exit_commname_for_other($depname=false,$id=false)
		{
		$data = array();
		if($depname)
		{
				$this->db->where('comm_depname',$depname);
		}
		if($id)
		{
			$this->db->where('comm_depid',$id);
		}

		$query = $this->db->get("comm_department");
		if ($query->num_rows() > 0) 
		{
			$data=$query->row();	
			return $data;			
		}
		return false;
		}
}