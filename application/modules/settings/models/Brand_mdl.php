<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Brand_mdl extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
		$this->table='bran_brand';
	}


	public $validate_settings_brand = array(               
        array('field' => 'bran_code', 'label' => 'Brand Code', 'rules' => 'trim|required|xss_clean|callback_exists_brandcode'),
          array('field' => 'bran_name', 'label' => 'Brand Name', 'rules' => 'trim|required|xss_clean|callback_exists_brand'),
        // array('field' => 'bran_address', 'label' => 'Brand Address', 'rules' => 'trim|required|xss_clean'),
        );


	public function brand_save()
	{
		$postdata=$this->input->post();
		$id=$this->input->post('id');
		unset($postdata['id']);
		if($id)
		{
			if(!empty($postdata))
			{
				  $this->general->save_log($this->table,'bran_brandid',$id,$postdata,'Update');
				$this->db->update($this->table,$postdata,array('bran_brandid'=>$id));
				$rowaffected=$this->db->affected_rows();
				return true;
			}
		}
		else
		{
		$postdata['bran_postdatead']=CURDATE_EN;
		$postdata['bran_postdatebs']=CURDATE_NP;
		$postdata['bran_posttime']=date('H:i:s');
		$postdata['bran_postby']=$this->session->userdata(USER_ID);
		$postdata['bran_postip']=$this->general->get_real_ipaddr();
		$postdata['bran_postmac']=$this->general->get_Mac_Address();
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
	public function remove_brand()
	{
		$id=$this->input->post('id');
		if($id)
		{
			$this->general->save_log($this->table,'bran_brandid',$id,$postdata=array(),'Delete');
			$this->db->delete($this->table,array('bran_brandid'=>$id));
			$rowaffected=$this->db->affected_rows();
			if($rowaffected)
			{

				return $rowaffected;
			}
			return false;
		}
		return false;
	}

public function check_exit_brand_for_other($bname=false,$id=false)
{
$data = array();
	if($id){
		$query = $this->db->get_where($this->table,array('bran_name'=>$bname,'bran_brandid !='=>$id));
	}
	else{
		$query = $this->db->get_where($this->table,array('bran_name'=>$bname));
	}
	if ($query->num_rows() > 0) 
	{
		$data=$query->row();	
		return $data;			
	}
	return false;
}

public function check_exit_brand_code_for_other($bname=false,$id=false)
{
$data = array();
	if($id){
		$query = $this->db->get_where($this->table,array('bran_code'=>$bname,'bran_brandid !='=>$id));
	}
	else{
		$query = $this->db->get_where($this->table,array('bran_code'=>$bname));
	}
	if ($query->num_rows() > 0) 
	{
		$data=$query->row();	
		return $data;			
	}
return false;
}

}