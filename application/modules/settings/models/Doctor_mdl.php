<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Doctor_mdl extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
		$this->table='dose_doctorsetup';
	}


	public $validate_settings_doctor = array(               
        array('field' => 'dose_doccode', 'label' => 'Doc Code', 'rules' => 'trim|required|xss_clean|min_length[3]'),
        array('field' => 'dose_desig', 'label' => 'Designation', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'dose_docname', 'label' => 'Doctor name', 'rules' => 'trim|required|xss_clean'),
        );



	
	
	public function save_doctor()
	{
		$postdata=$this->input->post();
		$id=$this->input->post('id');
		

		$postid=$this->general->get_real_ipaddr();
		$postmac=$this->general->get_Mac_Address();
		unset($postdata['id']);
	
		if($id)
		{
			$this->db->trans_start();
			$postdata['dose_modifydatead']=CURDATE_EN;
			$postdata['dose_modifydatebs']=CURDATE_NP;
			$postdata['dose_modifytime']=date('H:i:s');
			$postdata['dose_modifyby']='';
			$postdata['dose_modifyip']=$postid;
			$postdata['dose_modifymac']=$postmac;
			if(!empty($postdata))
			{
				$this->db->update($this->table,$postdata,array('dose_docid'=>$id));
				
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
		
			$postdata['dose_postdatead']=CURDATE_EN;
			$postdata['dose_postdatebs']=CURDATE_NP;
			$postdata['dose_posttime']=date('H:i:s');
			$postdata['dose_postby']='';
			$postdata['dose_postip']=$postid;
			$postdata['dose_postmac']=$postmac;
			// echo "<pre>";
			// print_r($postdata);
			// die();
			$this->db->trans_start();
			if(!empty($postdata))
			{
				$this->db->insert($this->table,$postdata);
				
			
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

	public function get_all_doctor($srchcol=false)
	{
		$this->db->select('ds.*');
		$this->db->from('dose_doctorsetup ds');
		
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

	


	public function remove_doctor()
	{
		$id=$this->input->post('id');
		if($id)
		{
			$this->db->delete($this->table,array('dose_userid'=>$id));
			$rowaffected=$this->db->affected_rows();
			if($rowaffected)
			{
				return $rowaffected;
			}
			return false;
		}
		return false;
	}


	public function check_exit_username_for_other($dose_username,$input_id)
	{
		$data = array();
		$query = $this->db->get_where($this->table,array('dose_username'=>$dose_username,'dose_userid'=>$input_id));
		if ($query->num_rows() > 0) 
		{
			$data=$query->row();	
			return $data;			
		}
		return false;
	}

	
}