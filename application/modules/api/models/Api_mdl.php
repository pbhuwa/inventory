<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api_mdl extends CI_Model 
{

	public function __construct() 
	{
		parent::__construct();
		$this->table='apta_apitable';
	}

public $validate_settings_api = array(               
        array('field' => 'apta_name', 'label' => 'API Name', 'rules' => 'trim|required|xss_clean|callback_exists_apta_name'),
        array('field' => 'apta_url', 'label' => 'API Link', 'rules' => 'trim|required|xss_clean'),
          array('field' => 'apta_isactive', 'label' => 'Is Active', 'rules' => 'trim|xss_clean'),
        );
	
	public function api_save()
	{
		$postdata=$this->input->post();

		
		$id=$this->input->post('id');
		unset($postdata['id']);
		if($id)
		{
		$postdata['apta_modifydatead']=CURDATE_EN;
		$postdata['apta_modifydatebs']=CURDATE_NP;
		$postdata['apta_modifytime']=date('H:i:s');
		$postdata['apta_modifyby']=$this->session->userdata(USER_ID);
		$postdata['apta_modifyip']=$this->general->get_real_ipaddr();
		$postdata['apta_modifymac']=$this->general->get_Mac_Address();

		if(!empty($postdata))
		{
			$this->general->save_log($this->table,'apta_id',$id,$postdata,'Update');
			$this->db->update($this->table,$postdata,array('apta_id'=>$id));
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
		$postdata['apta_postdatead']=CURDATE_EN;
		$postdata['apta_postdatebs']=CURDATE_NP;
		$postdata['apta_posttime']=date('H:i:s');
		$postdata['apta_postby']=$this->session->userdata(USER_ID);
		$postdata['apta_postip']=$this->general->get_real_ipaddr();
		$postdata['apta_postmac']=$this->general->get_Mac_Address();
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




	public function get_all_api($srchcol=false,$limit=false,$offset=false,$order=false,$order_by=false)
	{
		$this->db->select('*');
		$this->db->from($this->table);
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

	public function remove_api()
	{
		$id=$this->input->post('id');
		if($id)
		{
			$this->general->save_log($this->table,'apta_id',$id,$postdata=array(),'Delete');
			$this->db->delete($this->table,array('apta_id'=>$id));
			$rowaffected=$this->db->affected_rows();
			if($rowaffected)
			{
				return $rowaffected;
			}
			return false;
		}
		return false;
	}

	public function check_exist_api_name_for_other($api_name = false, $id = false){
		$data = array();
		if($api_name)
		{
				$this->db->where('apta_name',$api_name);
		}
		if($id)
		{
			$this->db->where('apta_id!=',$id);
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
        
                
                 
                
                
              
               
                     
                  
            
    
                
               
                    
                
                
                     
                   