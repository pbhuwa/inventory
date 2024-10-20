<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Group_mdl extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
		$this->table='usgr_usergroup';
	}


	public $validate_settings_group = array(               
        array('field' => 'usgr_usergroup', 'label' => 'group Name', 'rules' => 'trim|required|xss_clean|callback_exists_group'),
       
        );

	
	
	public function group_save()
	{
		$postdata=$this->input->post();
		$id=$this->input->post('id');
		//$locationid=$this->input->post('')
		$locationid=$this->session->userdata(LOCATION_ID);
		$input_location_id=$this->input->post('usgr_locationid');
		$dashboard=$this->input->post('dashboard');
		$dasboardid='';
		if(!empty($dashboard))
		{
			$dasboardid=implode(',', $dashboard);   
		}
		unset($postdata['dashboard']);
		unset($postdata['id']);
		if($id)
		{
		$postdata['usgr_dashboard']=$dasboardid;
		$postdata['usgr_modifydatead']=CURDATE_EN;
		$postdata['usgr_modifydatebs']=CURDATE_NP;
		$postdata['usgr_modifytime']=date('H:i:s');
		$postdata['usgr_modifyby']=$this->session->userdata(USER_ID);
		$postdata['usgr_modifyip']=$this->general->get_real_ipaddr();
		$postdata['usgr_modifymac']=$this->general->get_Mac_Address();
		if(!empty($postdata))
		{
			$this->general->save_log($this->table,'usgr_usergroupid',$id,$postdata,'Update');
			$this->db->update($this->table,$postdata,array('usgr_usergroupid'=>$id));
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
		$postdata['usgr_dashboard']=$dasboardid;
		$postdata['usgr_postdatead']=CURDATE_EN;
		$postdata['usgr_postdatebs']=CURDATE_NP;
		$postdata['usgr_posttime']=date('H:i:s');
		$postdata['usgr_postby']=$this->session->userdata(USER_ID);
		$postdata['usgr_orgid']=$this->session->userdata(ORG_ID);
		$postdata['usgr_postip']=$this->general->get_real_ipaddr();
		$postdata['usgr_postmac']=$this->general->get_Mac_Address();
		$postdata['usgr_locationid']=!empty($input_location_id)?$input_location_id:$locationid;
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

	public function get_all_group($srchcol=false)
	{
		$this->db->select('ug.*,lo.*');
		$this->db->from('usgr_usergroup ug');
		$this->db->join('loca_location lo','lo.loca_locationid=ug.usgr_locationid','LEFT');
		if (ORGANIZATION_NAME != 'NPHL') {
			$this->db->where('ug.usgr_orgid',$this->session->userdata(ORG_ID));
		}
		
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

	public function group_union()
	{
		$locationid=$this->session->userdata(LOCATION_ID);
		// if($locationid)

		$qry="SELECT usgr_usergroupid,usgr_usergroupcode,usgr_usergroup,ug.usgr_isalllocation,lo.loca_name  from xw_usgr_usergroup ug
			LEFT JOIN xw_loca_location lo  ON lo.loca_locationid = ug.usgr_locationid
			 WHERE usgr_isalllocation='Y'
			UNION
			SELECT usgr_usergroupid,usgr_usergroupcode,usgr_usergroup,ug.usgr_isalllocation,lo.loca_name  from xw_usgr_usergroup ug
			LEFT JOIN xw_loca_location lo  ON lo.loca_locationid = ug.usgr_locationid
			WHERE usgr_locationid=$locationid";
			$result=$this->db->query($qry)->result();
			return $result;

	}
	public function get_all_group_reg($srchcol=false)
	{
		$this->db->select('ug.*,lo.*');
		$this->db->from('usgr_usergroup ug');
		$this->db->join('loca_location lo','lo.loca_locationid=ug.usgr_locationid','LEFT');
	
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


	public function remove_group()
	{
		$id=$this->input->post('id');
		if($id)
		{
			$this->general->save_log($this->table,'usgr_usergroupid',$id,$postdata=array(),'Delete');
			$this->db->delete($this->table,array('usgr_usergroupid'=>$id));
			$rowaffected=$this->db->affected_rows();
			if($rowaffected)
			{
				return $rowaffected;
			}
			return false;
		}
		return false;
	}

	public function check_exit_group_for_other($usrgrp=false,$id=false)
		{
		$data = array();

		if($id)
		{
			$query = $this->db->get_where($this->table,array('usgr_usergroup'=>$usrgrp,'usgr_usergroupid !='=>$id));
		}
		else
		{
			$query = $this->db->get_where($this->table,array('usgr_usergroup'=>$usrgrp));
		}
		if ($query->num_rows() > 0) 
		{
			$data=$query->row();	
			return $data;			
		}
		return false;
		}

	public function group_save_clone()
	{
		$postdata=$this->input->post();
		$groupid=$this->input->post('groupid');
		$usgr_usergroup=$this->input->post('usgr_usergroup');
		$postdatead=CURDATE_EN;
		$postdatebs=CURDATE_NP;
		$posttime=date('H:i:s');

		$postby=$this->session->userdata(USER_ID);
		$orgid=$this->session->userdata(ORG_ID);
		$postip=$this->general->get_real_ipaddr();
		$postmac=$this->general->get_Mac_Address();
		$locationid=$this->session->userdata(LOCATION_ID);
		$input_location_id=$this->input->post('usgr_locationid');
		unset($postdata['groupid']);
		$postdata['usgr_postdatead']=CURDATE_EN;
		$postdata['usgr_postdatebs']=CURDATE_NP;
		$postdata['usgr_posttime']=date('H:i:s');
		$postdata['usgr_postby']=$this->session->userdata(USER_ID);
		$postdata['usgr_orgid']=$this->session->userdata(ORG_ID);
		$postdata['usgr_postip']=$this->general->get_real_ipaddr();
		$postdata['usgr_postmac']=$this->general->get_Mac_Address();
		$postdata['usgr_locationid']=!empty($input_location_id)?$input_location_id:$locationid;

		if(!empty($postdata))
		{
			$this->db->insert($this->table,$postdata);
			$insertid=$this->db->insert_id();
			if($insertid)
			{
				$group_per=$this->get_permission_by_group_ip($groupid);
		// echo "<pre>";
		// print_r($group_per);
		// die();
		if(!empty($group_per))
		{
			$perArray=array();
			foreach ($group_per as $kgp => $grp):
				$perArray[]=array(
		            'mope_usergroupid'=>$insertid,
		            'mope_usergroup'=>$usgr_usergroup,
		            'mope_moduleid'=>$grp->mope_moduleid,
		            'mope_hasaccess'=>$grp->mope_hasaccess,
		            'mope_insert'=>$grp->mope_insert,
		            'mope_update'=>$grp->mope_update,
		            'mope_delete'=>$grp->mope_delete,
		            'mope_view'=>$grp->mope_view,
		            'mope_verified'=>$grp->mope_verified,
		            'mope_approve'=>$grp->mope_approve,
		            'mope_postdatead'=>$postdatead,
		            'mope_postdatebs'=>$postdatebs,
		            'mope_posttime'=>$posttime,
		            'mope_postby'=>$postby,
		            'mope_postmac'=>$postmac,
		            'mope_postip'=>$postip,
		            'mope_locationid'=>!empty($input_location_id)?$input_location_id:$locationid,
		            'mope_orgid'=>$orgid
				);

			endforeach;
			if(!empty($perArray)){
				$this->db->insert_batch('mope_modulespermission',$perArray);
			}
		}
				// return $insertid;
		return true;
			}
			else
			{
				return false;
			}
		}
		
		return false;


		//$locationid=$this->input->post('')
		

		
}

public function get_permission_by_group_ip($gid){
	$this->db->select('*');
	$this->db->from('mope_modulespermission mp');
	$this->db->where('mope_usergroupid',$gid);
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

	
}