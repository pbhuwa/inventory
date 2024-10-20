<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dep_change_mdl extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
		$this->table='eqdc_eqdepchange';
	}

	public $validate_settings_dep_change = array( 
	   array('field' => 'eqdc_newdepid', 'label' => 'Department', 'rules' => 'trim|required|xss_clean'),
	     array('field' => 'eqdc_date', 'label' => 'Date', 'rules' => 'trim|required|xss_clean'),
	
       );                
	

	public function get_change_equip_department($srchcol=false,$limit=false,$offset=false,$order=false,$order_by=false)
	{
		$this->db->select('eqch.*,di.dept_depname as old_depname,rd.rode_roomname as old_room,din.dept_depname as new_depname,rdn.rode_roomname as new_room');
		$this->db->from('eqdc_eqdepchange eqch');
		$this->db->join('dept_department di','di.dept_depid=eqch.eqdc_olddepid','LEFT');
		$this->db->join('rode_roomdepartment rd', 'rd.rode_roomdepartmentid = eqch.eqdc_oldroomid', 'LEFT');
		$this->db->join('dept_department din','din.dept_depid=eqch.eqdc_newdepid','LEFT');
		$this->db->join('rode_roomdepartment rdn', 'rdn.rode_roomdepartmentid = eqch.eqdc_newroomid', 'LEFT');

	
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
	
	public function save_department_change()
	{
		$postdata=$this->input->post();
		$id=$this->input->post('id');
		$eqdc_equipid=$this->input->post('eqdc_equipid');
		$eqdc_newdepid=$this->input->post('eqdc_newdepid');
		$eqdc_newroomid=$this->input->post('eqdc_newroomid');
		
		$postid=$this->general->get_real_ipaddr();
		$postmac=$this->general->get_Mac_Address();
		$eqdc_date=$this->input->post('eqdc_date');
		if(DEFAULT_DATEPICKER=='NP')
  		{
   	 	$eqdc_datenp=$eqdc_date;
   		$eqdc_dateen=$this->general->NepToEngDateConv($eqdc_date);
  		}
  		else
  		{
    	$eqdc_dateen=$eqdc_date;
    	$eqdc_datenp=$this->general->EngToNepDateConv($eqdc_date);
  		}
		$postdata['eqdc_datead']=$eqdc_dateen;
		$postdata['eqdc_datebs']=$eqdc_datenp;
		$equip_data = $this->bio_medical_mdl->get_biomedical_inventory(array('bm.bmin_equipid'=>$eqdc_equipid));


		unset($postdata['eqdc_date']);
		unset($postdata['id']);
	
		if($id)
		{
			$this->db->trans_start();
			$postdata['eqdc_modifydatead']=CURDATE_EN;
			$postdata['eqdc_modifydatebs']=CURDATE_NP;
			$postdata['eqdc_modifytime']=$this->general->get_currenttime();
			$postdata['eqdc_modifyby']=$this->session->userdata(USER_ID);
			$postdata['eqdc_modifyip']=$postid;
			$postdata['eqdc_modifymac']=$postmac;
			
			if(!empty($postdata))
			{
				 $this->general->save_log($this->table,'eqdc_eqdepchangeid',$id,$postdata,'Update');
				$this->db->update($this->table,$postdata,array('eqdc_equipmentlistid'=>$id));
				
			}

			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
				{
				        $this->db->trans_rollback();
				        return false;
				}
				else
				{
				        $this->db->trans_commit();
				        return true;
				}
		}
		else
		{
		
			$postdata['eqdc_postdatead']=CURDATE_EN;
			$postdata['eqdc_postdatebs']=CURDATE_NP;
			$postdata['eqdc_posttime']=$this->general->get_currenttime();
			$postdata['eqdc_postby']=$this->session->userdata(USER_ID);
			$postdata['eqdc_orgid']=$this->session->userdata(ORG_ID);
			$postdata['eqdc_postip']=$postid;
			$postdata['eqdc_postmac']=$postmac;

			$postdata['eqdc_olddepid']=!empty($equip_data[0]->bmin_departmentid)?$equip_data[0]->bmin_departmentid:'';
			$postdata['eqdc_oldroomid']=!empty($equip_data[0]->bmin_roomid)?$equip_data[0]->bmin_roomid:'';
			$this->db->trans_start();
			if(!empty($postdata))
			{
				$this->db->insert($this->table,$postdata);
				$this->db->update('bmin_bmeinventory',array('bmin_departmentid'=>$eqdc_newdepid,'bmin_roomid'=>$eqdc_newroomid),array('bmin_equipid'=>$eqdc_equipid));
			}
				
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
				{
				        $this->db->trans_rollback();
				        return false;
				}
				else
				{
				        $this->db->trans_commit();
				        return true;
				}
			}
			return false;
	}


	public function get_all_equipment($srchcol=false)
	{
		$this->db->select('eq.*');
		 $this->db->from('eqdc_eqdepchange eq');
	    $this->db->join('eqty_equipmenttype et','et.eqty_equipmenttypeid=eq.eqli_equipmenttypeid','LEFT');
		
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

	public function get_all_equipment_list($srchcol=false)
	{  
		$this->db->select('ds.*');
		$this->db->from('bmin_bmeinventory ds');
		
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

	

		
}