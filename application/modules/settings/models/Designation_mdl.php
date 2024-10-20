<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Designation_mdl extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
		$this->table='desi_designation';
	}


	public $validate_settings_designation = array(               
        array('field' => 'desi_designationname', 'label' => 'Designation Name', 'rules' => 'trim|required|xss_clean'),
          // array('field' => 'bran_name', 'label' => 'Brand Name', 'rules' => 'trim|required|xss_clean|callback_exists_brand'),
        // array('field' => 'bran_address', 'label' => 'Brand Address', 'rules' => 'trim|required|xss_clean'),
        );


	public function designation_save()
	{
		$postdata=$this->input->post();
		$id=$this->input->post('id');
		unset($postdata['id']);
		if($id)
		{
			if(!empty($postdata))
			{
				$this->general->save_log($this->table,'desi_designationid',$id,$postdata,'Update');
				$this->db->update($this->table,$postdata,array('desi_designationid'=>$id));
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
			$postdata['desi_postdatead']=CURDATE_EN;
			$postdata['desi_postdatebs']=CURDATE_NP;
			$postdata['desi_posttime']=date('H:i:s');
			$postdata['desi_postby']=$this->session->userdata(USER_ID);
			$postdata['desi_postip']=$this->general->get_real_ipaddr();
			$postdata['desi_postmac']=$this->general->get_Mac_Address();
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
	public function remove_designation()
	{
		$id=$this->input->post('id');
		if($id)
		{
			$this->general->save_log($this->table,'desi_designationid',$id,$postdata=array(),'Delete');
			$this->db->delete($this->table,array('desi_designationid'=>$id));
			$rowaffected=$this->db->affected_rows();
			if($rowaffected)
			{

				return $rowaffected;
			}
			return false;
		}
		return false;
	}


	// public function check_exit_location_for_other($loca_name,$input_id)
	// {
		
	// 	$data = array();

	// 	if($input_id)
	// 	{
	// 		$query = $this->db->get_where($this->table,array('loca_name'=>$loca_name,'loca_locationid !='=>$input_id));
	// 	}
	// 	else
	// 	{
	// 		$query = $this->db->get_where($this->table,array('loca_name'=>$loca_name));
	// 	}
	// 	if ($query->num_rows() > 0) 
	// 	{
	// 		$data=$query->row();	
	// 		return $data;			
	// 	}
	// 	return false;
	// }
}