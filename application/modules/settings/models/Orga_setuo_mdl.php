
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Orga_setup_mdl extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
		$this->table='orga_organization';
	}

	public $validate_settings_orga_setup = array(               
         array('field' => 'orga_orgname', 'label' => 'Organization Name ', 'rules' => 'trim|required|xss_clean|callback_exists_orga_orgname'),
       // array('field' => 'orga_isactive', 'label' => 'Is Active', 'rules' => 'trim|required|xss_clean'),
       );
	
	public function orga_setup_save()
	{
		$postdata=$this->input->post();
		$id=$this->input->post('id');
		unset($postdata['id']);
		if($id)
		{
		$postdata['orga_modifydatead']=CURDATE_EN;
		$postdata['orga_modifydatebs']=CURDATE_NP;
		$postdata['orga_modifytime']=date('H:i:s');
		$postdata['orga_modifyip']='';
		$postdata['orga_modifyip']=$this->general->get_real_ipaddr();
		$postdata['orga_modifymac']=$this->general->get_Mac_Address();
		if(!empty($postdata))
		{
			$this->db->update($this->table,$postdata,array('orga_orgid'=>$id));
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
		$postdata['orga_postdatead']=CURDATE_EN;
		$postdata['orga_postdatebs']=CURDATE_NP;
		$postdata['orga_posttime']=date('H:i:s');
		$postdata['orga_postby']='';
		$postdata['orga_postip']=$this->general->get_real_ipaddr();
		$postdata['orga_postmac']=$this->general->get_Mac_Address();
		// echo "<pre>";
		// print_r($postdata);
		// die();

		if(!empty($postdata))
		{
			$this->db->insert($this->table,$postdata);
			// echo $this->db->last_query();
			$insertid=$this->db->insert_id();
			// echo $insertid;
			// die();
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

	public function get_all_orga_setup($srorgal=false,$limit=false,$offset=false,$order=false,$order_by=false)
	{
		$this->db->select('*');
		$this->db->from('orga_orgname pc');
		
		if($srorgal)
		{
			$this->db->where($srorgal);
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

	public function remove_orga_setup()
	{
		$id=$this->input->post('id');
		if($id)
		{
			$this->db->delete($this->table,array('orga_orgid'=>$id));
			$rowaffected=$this->db->affected_rows();
			if($rowaffected)
			{
				return $rowaffected;
			}
			return false;
		}
		return false;
	}



	public function check_exist_orga_orgname_for_other($orga_orgname = false, $id = false){
		$data = array();
		if($orga_orgname)
		{
				$this->db->where('orga_orgname',$orga_orgname);
		}
		if($id)
		{
			$this->db->where('orga_orgid!=',$id);
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