<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Repair_information_mdl extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
		$this->table='rere_repairrequests';
	}


	public $validate_settings_repair_information = array(               
        array('field' => 'rere_description', 'label' => 'Description Name', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'rere_department', 'label' => 'Department', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'rere_reported_by', 'label' => 'rere Reported By', 'rules' => 'trim|required|xss_clean'),

       
        );
	
	public function rere_information_save()
	{
		$postdata=$this->input->post();
		$id=$this->input->post('id');
		unset($postdata['id']);
		if($id)
		{
			$postdata['rere_modifydatead']=CURDATE_EN;
			$postdata['rere_modifydatebs']=CURDATE_NP;
			$postdata['rere_modifytime']=$this->general->get_currenttime();
			$postdata['rere_modifyip']=$this->session->userdata(USER_ID);
			$postdata['rere_modifyip']=$this->general->get_real_ipaddr();
			$postdata['rere_modifymac']=$this->general->get_Mac_Address();
			$postdata['rere_equid']=$this->input->post('rere_equid');
			if(!empty($postdata))
			{
				$this->db->update($this->table,$postdata,array('rere_repairrequestid'=>$id));
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
			$postdata['rere_postdatead']=CURDATE_EN;
			$postdata['rere_postdatebs']=CURDATE_NP;
			$postdata['rere_posttime']=$this->general->get_currenttime();
			$postdata['rere_postby']=$this->session->userdata(USER_ID);
			$postdata['rere_postip']=$this->general->get_real_ipaddr();
			$postdata['rere_postmac']=$this->general->get_Mac_Address();
			$postdata['rere_equid']=$this->input->post('rere_equid');
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
	public function ureq_information_save()
	{
		$postdata=$this->input->post();
		$id=$this->input->post('id');
		unset($postdata['id']);
		if($id)
		{
			$postdata['rere_modifydatead']=CURDATE_EN;
			$postdata['rere_modifydatebs']=CURDATE_NP;
			$postdata['rere_modifytime']=$this->general->get_currenttime();
			$postdata['rere_modifyip']=$this->session->userdata(USER_ID);
			$postdata['rere_modifyip']=$this->general->get_real_ipaddr();
			$postdata['rere_modifymac']=$this->general->get_Mac_Address();
			$postdata['rere_equid']=$this->input->post('rere_equid');
			if(!empty($postdata))
			{
				$this->db->update($this->table,$postdata,array('rere_repairrequestid'=>$id));
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
		}else{
			$postdata['rere_postdatead']=CURDATE_EN;
			$postdata['rere_postdatebs']=CURDATE_NP;
			$postdata['rere_posttime']=$this->general->get_currenttime();
			$postdata['rere_postby']=$this->session->userdata(USER_ID);
			$postdata['rere_postip']=$this->general->get_real_ipaddr();
			$postdata['rere_postmac']=$this->general->get_Mac_Address();
			$postdata['rere_equid']=$this->input->post('rere_equid');
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
	

	public function get_all_repair_information($srchcol=false,$limit=false,$offset=false,$order=false,$order_by=false)
	{
		$this->db->select('m.*');
		$this->db->from('rere_repairrequests m');
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

	public function remove_repair_information()
	{
		$id=$this->input->post('id');
		if($id)
		{
			$this->db->delete($this->table,array('rere_repairrequestid'=>$id));
			$rowaffected=$this->db->affected_rows();
			if($rowaffected)
			{
				return $rowaffected;
			}
			return false;
		}
		return false;
	}

	
	public function get_repairinformation($srchcol=false,$limit=false,$offset=false,$order_by=false,$order=false)
	{
	  	  $this->db->select('bm.*,eql.eqli_description,di.dein_department');
	      $this->db->from('bmin_bmeinventory bm');
	      $this->db->join('eqli_equipmentlist eql','eql.eqli_equipmentlistid=bm.bmin_descriptionid','LEFT');
	      $this->db->join('dein_departmentinformation di','di.dein_departmentid=bm.bmin_departmentid','LEFT');
	    
	     if($srchcol)
	     {
	         $this->db->where($srchcol); 
	     }

	    $qry=$this->db->get();
	     // echo $this->db->last_query();die();
	      
	    if($qry->num_rows()>0)
	    {
	      return $qry->result();
	    }
	     return false;
	}
	
}