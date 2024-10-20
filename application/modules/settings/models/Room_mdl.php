<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Room_mdl extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
		$this->table='rode_roomdepartment';
	}


	public $validate_settings_room = array(               
        array('field' => 'rode_departmentid', 'label' => 'Department', 'rules' => 'trim|required|xss_clean'),
      array('field' => 'rode_roomname', 'label' => 'Room Name', 'rules' => 'trim|required|xss_clean'),
     
	 array('field' => 'rode_isactive', 'label' => 'Is Active', 'rules' => 'trim|required|xss_clean')
        );


		

	
	
	public function room_save()
	{
		$postdata=$this->input->post();
		$id=$this->input->post('id');
		unset($postdata['id']);
		if($id)
		{
		$postdata['rode_modifydatead']=CURDATE_EN;
		$postdata['rode_modifydatebs']=CURDATE_NP;
		$postdata['rode_modifytime']=date('H:i:s');
		$postdata['rode_modifyby']=$this->session->userdata(USER_ID);
		$postdata['rode_modifyip']=$this->general->get_real_ipaddr();
		$postdata['rode_modifymac']=$this->general->get_Mac_Address();
		if(!empty($postdata))
		{
			$this->db->update($this->table,$postdata,array('rode_roomdepartmentid'=>$id));
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
		$postdata['rode_postdatead']=CURDATE_EN;
		$postdata['rode_postdatebs']=CURDATE_NP;
		$postdata['rode_posttime']=date('H:i:s');
		$postdata['rode_postby']=$this->session->userdata(USER_ID);
		$postdata['rode_orgid']=$this->session->userdata(ORG_ID);
		$postdata['rode_postip']=$this->general->get_real_ipaddr();
		$postdata['rode_postmac']=$this->general->get_Mac_Address();
		$postdata['rode_locationid']=$this->session->userdata(LOCATION_ID);
		
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

	public function get_all_room($srchcol=false,$limit=false,$offset=false,$order=false,$order_by=false)
	{
		$this->db->select('rm.*,dp.dept_depname ');
		$this->db->from('rode_roomdepartment rm');
		$this->db->join('dept_department dp','dp.dept_depid=rm.rode_departmentid','left');
		if($srchcol)
		{
			$this->db->where($srchcol);
		}
		if($srchcol)
		{
			$this->db->where($srchcol);
		}
		if($limit && $limit>0)
		{
			$this->db->limit($limit);
		}
		if($offset)
		{
			$this->db->offset($offset);
		}

		if($order)
		{
			$this->db->order_by($order,$order_by);
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


	

	public function remove_room()
	{
		$id=$this->input->post('id');
		if($id)
		{
			$this->general->save_log($this->table,'rode_roomdepartmentid',$id,$postdata=array(),'Delete');
			$this->db->delete($this->table,array('rode_roomdepartmentid'=>$id));
			$rowaffected=$this->db->affected_rows();
			if($rowaffected)
			{
				return $rowaffected;
			}
			return false;
		}
		return false;
	}

	public function check_exit_deptcode_for_other($depcode,$id)
		{
		
		$data = array();
		if($id)
		{
			$query = $this->db->get_where($this->table,array('rode_depcode'=>$depcode,'rode_roomdepartmentid !='=>$id));
		}
		else
		{
			$query = $this->db->get_where($this->table,array('rode_depcode'=>$depcode));
		}
		
		if ($query->num_rows() > 0) 
		{
			$data=$query->row();	
			return $data;			
		}
		return false;

		
		}

	public function check_exit_deptname_for_other($depname=false,$id=false)
		{
		$data = array();

		if($id)
		{
			$query = $this->db->get_where($this->table,array('rode_roomname'=>$depname,'rode_roomdepartmentid !='=>$id));
		}
		else
		{
			$query = $this->db->get_where($this->table,array('rode_roomname'=>$depname));
		}
		if ($query->num_rows() > 0) 
		{
			$data=$query->row();	
			return $data;			
		}
		return false;
		}
}