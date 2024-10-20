<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Service_techs_mdl extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
		$this->table='sete_servicetechs';
	}

	public $validate_service_techs = array(  
	 array('field' => 'sete_name', 'label' => 'Service Tech Name', 'rules' => 'trim|required|xss_clean'),            
        array('field' => 'sete_workphone', 'label' => 'workphone', 'rules' => 'trim|required|xss_clean'),
        );
	
	
	public function save_service_techs()
	{
		$postdata=$this->input->post();
		$id=$this->input->post('id');
		$postid=$this->general->get_real_ipaddr();
		$postmac=$this->general->get_Mac_Address();
		unset($postdata['id']);
		if($id)
		{
			$this->db->trans_start();
			$postdata['sete_modifydatead']=CURDATE_EN;
			$postdata['sete_modifydatebs']=CURDATE_NP;
			$postdata['sete_modifytime']=$this->general->get_currenttime();
			$postdata['sete_modifyby']=$this->session->userdata(USER_ID);
			$postdata['sete_modifyip']=$postid;
			$postdata['sete_modifymac']=$postmac;
			if(!empty($postdata))
			{
				$this->general->save_log($this->table,'sete_techid',$id,$postdata,'Update');
				$this->db->update($this->table,$postdata,array('sete_techid'=>$id));	
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
		
			$postdata['sete_postdatead']=CURDATE_EN;
			$postdata['sete_postdatebs']=CURDATE_NP;
			$postdata['sete_posttime']=$this->general->get_currenttime();
			$postdata['sete_postby']=$this->session->userdata(USER_ID);
			$postdata['sete_orgid']=$this->session->userdata(ORG_ID);
			$postdata['sete_postip']=$postid;
			$postdata['sete_postmac']=$postmac;
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


	public function get_all_service_techs($srchcol=false)
	{
		$this->db->select('st.*');
		$this->db->from('sete_servicetechs st');
		
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

	


	public function remove_service_techs()
	{
		$id=$this->input->post('id');
		if($id)
		{

			$this->general->save_log($this->table,'sete_techid',$id,$postdata=array(),'Delete');
			$this->db->delete($this->table,array('sete_techid'=>$id));
			$rowaffected=$this->db->affected_rows();
			if($rowaffected)
			{
				return $rowaffected;
			}
			return false;
		}
		return false;
	}
    
    public function get_servicetech_list($cond = false)
	{
		$get = $_GET;
 
      	foreach ($get as $key => $value) {
        	$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
      	}
     	 if(!empty($get['sSearch_0'])){
            $this->db->where("sete_techid like  '%".$get['sSearch_0']."%'  ");
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("sete_name like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("sete_workphone like  '%".$get['sSearch_2']."%'  ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("sete_email like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("sete_address1 like  '%".$get['sSearch_4']."%'  ");
        }
        $resltrpt=$this->db->select("COUNT(*) as cnt")
  					->from('sete_servicetechs')
  					->get()
  					->row();
	    //echo $this->db->last_query();die(); 
      	$totalfilteredrecs=$resltrpt->cnt; 

      	$order_by = 'sete_techid';
      	$order = 'desc';
      	if($this->input->get('sSortDir_0'))
  		{
  				$order = $this->input->get('sSortDir_0');
  		}
  
      	$where='';
      	if($this->input->get('iSortCol_0')==0)
        	$order_by = 'sete_techid';
      	else if($this->input->get('iSortCol_0')==1)
        	$order_by = 'sete_name';
      	else if($this->input->get('iSortCol_0')==2)
       		$order_by = 'sete_workphone';
       	else if($this->input->get('iSortCol_0')==3)
       		$order_by = 'sete_email';
       	else if($this->input->get('iSortCol_0')==4)
       		$order_by = 'sete_address1';
      	
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
            $this->db->where("sete_techid like  '%".$get['sSearch_0']."%'  ");
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("sete_name like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("sete_workphone like  '%".$get['sSearch_2']."%'  ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("sete_email like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("sete_address1 like  '%".$get['sSearch_4']."%'  ");
        }
       
        $this->db->select('*');
		$this->db->from('sete_servicetechs');
        $this->db->order_by($order_by,$order);
        if($cond) {
        	$this->db->where($cond);
        }
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
        if (!empty($_GET['iDisplayLength']) &&  !empty($nquery) && is_array($nquery) && count($nquery) > 0 ) {
            $totalrecs = sizeof($nquery);
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