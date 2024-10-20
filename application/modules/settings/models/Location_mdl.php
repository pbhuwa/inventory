<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Location_mdl extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
		$this->table='loca_location';
	}


	public $validate_settings_department = array(               
        array('field' => 'loca_name', 'label' => 'Location Name', 'rules' => 'trim|required|xss_clean|callback_exists_location'),
        array('field' => 'loca_address', 'label' => 'Location Address', 'rules' => 'trim|required|xss_clean'),
        );


	public function location_save()
	{
		$postdata=$this->input->post();
		// echo "<pre>";
		// print_r($postdata);
		// die();
		$id=$this->input->post('id');
		unset($postdata['id']);
		if($id)
		{
			if(!empty($postdata))
			{
				  $this->general->save_log($this->table,'loca_locationid',$id,$postdata,'Update');
				$this->db->update($this->table,$postdata,array('loca_locationid'=>$id));
				$rowaffected=$this->db->affected_rows();
				if($rowaffected)
				{
					
					return $id;
				}
				else
				{
					return true;
				}
			}
		}
		else
		{
		$postdata['loca_postdatead']=CURDATE_EN;
		$postdata['loca_postdatebs']=CURDATE_NP;
		$postdata['loca_posttime']=date('H:i:s');
		$postdata['loca_postby']=$this->session->userdata(USER_ID);
		$postdata['loca_postip']=$this->general->get_real_ipaddr();
		$postdata['loca_postmac']=$this->general->get_Mac_Address();
		if(!empty($postdata))
		{
			$this->db->insert($this->table,$postdata);
			$insertid=$this->db->insert_id($this->table);
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
	public function remove_location()
	{
		$id=$this->input->post('id');
		if($id)
		{
			$this->general->save_log($this->table,'loca_locationid',$id,$postdata=array(),'Delete');
			$this->db->delete($this->table,array('loca_locationid'=>$id));
			$rowaffected=$this->db->affected_rows();
			if($rowaffected)
			{

				return $rowaffected;
			}
			return false;
		}
		return false;
	}


	public function check_exit_location_for_other($loca_name,$input_id)
	{
		
		$data = array();

		if($input_id)
		{
			$query = $this->db->get_where($this->table,array('loca_name'=>$loca_name,'loca_locationid !='=>$input_id));
		}
		else
		{
			$query = $this->db->get_where($this->table,array('loca_name'=>$loca_name));
		}
		if ($query->num_rows() > 0) 
		{
			$data=$query->row();	
			return $data;			
		}
		return false;
	}
}