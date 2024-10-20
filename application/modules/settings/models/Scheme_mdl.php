<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Scheme_mdl extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
		$this->table='sche_scheme';
	}


	public $validate_settings_scheme = array(  
		array('field' => 'sche_schemecode', 'label' => 'Schemecode', 'rules' => 'trim|required|xss_clean')

		);
	
	
	public function scheme_save()
	{
		$postdata=$this->input->post();
		$id=$this->input->post('id');
		unset($postdata['id']);
		if($id)
		{
		$postdata['sche_modifydatead']=CURDATE_EN;
		$postdata['sche_modifydatebs']=CURDATE_NP;
		$postdata['sche_modifytime']=date('H:i:s');
		$postdata['sche_modifyip']='';
		$postdata['sche_modifyip']=$this->general->get_real_ipaddr();
		$postdata['sche_modifymac']=$this->general->get_Mac_Address();
		if(!empty($postdata))
		{
			$this->db->update($this->table,$postdata,array('sche_scheunityid'=>$id));
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
		$postdata['sche_postdatead']=CURDATE_EN;
		$postdata['sche_postdatebs']=CURDATE_NP;
		$postdata['sche_posttime']=date('H:i:s');
		$postdata['sche_postby']='';
		$postdata['sche_postip']=$this->general->get_real_ipaddr();
		$postdata['sche_postmac']=$this->general->get_Mac_Address();
		//echo "<pre>";print_r($postdata);die();

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

	public function get_all_scheme($srchcol=false)
	{
		$this->db->select('*');
		$this->db->from('sche_scheme');
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


	public function get_all_departmenttype($srchcol=false)
	{
		$this->db->select('dt.*');
		$this->db->from('dety_departmenttype dt');
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


	public function remove_scheunity()
	{
		$id=$this->input->post('id');
		if($id)
		{
			$this->db->delete($this->table,array('sche_scheunityid'=>$id));
			$rowaffected=$this->db->affected_rows();
			if($rowaffected)
			{
				return $rowaffected;
			}
			return false;
		}
		return false;
	}

	public function check_exit_schecode_for_other($depcode=false,$id=false)
		{
		$data = array();
		if($depcode)
		{
				$this->db->where('sche_depcode',$depcode);
		}
		if($id)
		{
			$this->db->where('sche_depid',$id);
		}

		$query = $this->db->get("sche_department");
		if ($query->num_rows() > 0) 
		{
			$data=$query->row();	
			return $data;			
		}
		return false;
		}

	public function check_exit_schename_for_other($depname=false,$id=false)
		{
		$data = array();
		if($depname)
		{
				$this->db->where('sche_depname',$depname);
		}
		if($id)
		{
			$this->db->where('sche_depid',$id);
		}

		$query = $this->db->get("sche_department");
		if ($query->num_rows() > 0) 
		{
			$data=$query->row();	
			return $data;			
		}
		return false;
	}
	public function get_schema_list()
		{
			$get = $_GET;
	 
	      	foreach ($get as $key => $value) {
	        	$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
	      	}
	     	$where='';
	     	if(!empty($get['sSearch_0']))
	      	{
	      		$where.="WHERE sche_schemeid LIKE '%".$get['sSearch_0']."%'";
	      	}
	      	
	     	if(!empty($get['sSearch_1']))
	      	{
	      		$where.="WHERE riva_risk LIKE '%".$get['sSearch_1']."%'";
	      	}
	      	if(!empty($get['sSearch_2']))
	      	{
	      		$where.="WHERE riva_comments LIKE '%".$get['sSearch_2']."%'";
	      	}
	      	if(!empty($get['sSearch_3']))
	      	{
	      		$where.="WHERE riva_postdatebs LIKE '%".$get['sSearch_3']."%'";
	      	}
	      	
	         
	      	$resltrpt=$this->db->query("SELECT COUNT(*) as cnt FROM xw_sche_scheme  $where ")->row();
		    //echo $this->db->last_query();die(); 
	      	$totalfilteredrecs=$resltrpt->cnt; 

	      	$order_by = 'sche_schemeid';
	      	$order = 'desc';
	  
	      	$where='';
	      	if($this->input->get('iSortCol_0')==0)
	        	$order_by = 'sche_schemeid';
	      	else if($this->input->get('iSortCol_0')==1)
	        	$order_by = 'riva_risk';
	      	else if($this->input->get('iSortCol_0')==2)
	       		$order_by = 'riva_comments';
	       	else if($this->input->get('iSortCol_0')==3)
	       		$order_by = 'riva_postdatebs';
	       	
	      	$totalrecs='';
	      	$limit = 15;
	      	$offset = 1;
	      	$get = $_GET;
	 
		    foreach ($get as $key => $value) {
		        $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
		    }
	      
	        if(!empty($_GET["iDisplayLength"])){
	           $limit = $_GET['iDisplayLength'];
	           $offset = $_GET["iDisplayStart"];
	        }

	        if(!empty($get['sSearch_0'])){
	            $this->db->where("sche_schemeid like  '%".$get['sSearch_0']."%'  ");
	        }

	        if(!empty($get['sSearch_1'])){
	            $this->db->where("riva_risk like  '%".$get['sSearch_1']."%'  ");
	        }

	        if(!empty($get['sSearch_2'])){
	            $this->db->where("riva_comments like  '%".$get['sSearch_2']."%'  ");
	        }
	        if(!empty($get['sSearch_3'])){
	            $this->db->where("riva_postdatebs like  '%".$get['sSearch_3']."%'  ");
	        }
	       
	        $this->db->select('*');
			$this->db->from('sche_scheme');
	        $this->db->order_by($order_by,$order);
	        if($limit && $limit>0)
	        {  
	            $this->db->limit($limit);
	        }
	        if($offset)
	        {
	            $this->db->offset($offset);
	        }
	      
	       $nquery=$this->db->get();
	       $num_row=$nquery->num_rows();
	        if(!empty($_GET['iDisplayLength'])) {
	          $totalrecs = sizeof( $nquery);
	        }


	       if($num_row>0){
	          $ndata=$nquery->result();
	          $ndata['totalrecs'] = $totalrecs;
	          $ndata['totalfilteredrecs'] = $totalfilteredrecs;
	        } 
	        else
	        {
	            $ndata=array();
	            $ndata['totalrecs'] = 0;
	            $ndata['totalfilteredrecs'] = 0;
	        }
		    // echo $this->db->last_query();die();
		    return $ndata;
		}
}