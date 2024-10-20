<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Risk_value_mdl extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
		$this->table='riva_riskvalues';
	}

	public $validate_risk_value = array(  
		 array('field' => 'riva_year', 'label' => 'Risk Year', 'rules' => 'trim|required|xss_clean|numeric'),
		  array('field' => 'riva_risktype', 'label' => 'Risk Type', 'rules' => 'trim|required|xss_clean'),      
	 array('field' => 'riva_risk', 'label' => 'Risk', 'rules' => 'trim|required|xss_clean'),            
	  array('field' => 'riva_times', 'label' => 'Times', 'rules' => 'trim|required|xss_clean'),  
        array('field' => 'riva_comments', 'label' => 'Comments', 'rules' => 'trim|required|xss_clean'),
        );
	
	
	public function save_risk_value()
	{
		$postdata=$this->input->post();
		$id=$this->input->post('id');
		

		$postid=$this->general->get_real_ipaddr();
		$postmac=$this->general->get_Mac_Address();
		unset($postdata['id']);
			// echo "<pre>";
			// print_r($id);
			// die();
		if($id)
		{
			$this->db->trans_start();
			$postdata['riva_modifydatead']=CURDATE_EN;
			$postdata['riva_modifydatebs']=CURDATE_NP;
			$postdata['riva_modifytime']=$this->general->get_currenttime();
			$postdata['riva_modifyby']=$this->session->userdata(USER_ID);
			$postdata['riva_modifyip']=$postid;
			$postdata['riva_modifymac']=$postmac;
			
			if(!empty($postdata))
			{
				 $this->general->save_log($this->table,'riva_riskid',$id,$postdata,'Update');
				$this->db->update($this->table,$postdata,array('riva_riskid'=>$id));
				
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
		
			$postdata['riva_postdatead']=CURDATE_EN;
			$postdata['riva_postdatebs']=CURDATE_NP;
			$postdata['riva_posttime']=$this->general->get_currenttime();
			$postdata['riva_postby']=$this->session->userdata(USER_ID);
			$postdata['riva_orgid']=$this->session->userdata(ORG_ID);
			$postdata['riva_postip']=$postid;
			$postdata['riva_postmac']=$postmac;
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


	public function get_all_risk_value($srchcol=false)
	{
		$this->db->select('rv.*');
		$this->db->from('riva_riskvalues rv');
		
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

	


	public function remove_risk_value()
	{
		$id=$this->input->post('id');
		if($id)
		{
			 $this->general->save_log($this->table,'riva_riskid',$id,$postdata=array(),'Delete');
			$this->db->delete($this->table,array('riva_riskid'=>$id));
			$rowaffected=$this->db->affected_rows();
			if($rowaffected)
			{
				return $rowaffected;
			}
			return false;
		}
		return false;
	}
    
    
    public function get_risk_value_list($srch=false)
	{
		$get = $_GET;
 
      	foreach ($get as $key => $value) {
        	$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
      	}
      	if(!empty($get['sSearch_0'])){
            $this->db->where("riva_riskid like  '%".$get['sSearch_0']."%'  ");
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("riva_risk like  '%".$get['sSearch_1']."%'  ");
        }

         if(!empty($get['sSearch_2'])){
            $this->db->where("riva_times like  '%".$get['sSearch_2']."%'  ");
        }

        if(!empty($get['sSearch_3'])){
            $this->db->where("riva_comments like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("riva_postdatead like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("riva_postdatebs like  '%".$get['sSearch_5']."%'  ");
        }

        $resltrpt=$this->db->select("COUNT(*) as cnt")
      					->from('riva_riskvalues')
      					->get()
      					->row();
      	//$resltrpt=$this->db->query("SELECT COUNT(*) as cnt FROM xw_riva_riskvalues  $where ")->row();
	    //echo $this->db->last_query();die(); 
      	$totalfilteredrecs=$resltrpt->cnt; 

      	$order_by = 'riva_riskid';
  		$order = 'desc';
  		if($this->input->get('sSortDir_0'))
  		{
  				$order = $this->input->get('sSortDir_0');
  		}
      
  
      	$where='';
      	if($this->input->get('iSortCol_0')==0)
        	$order_by = 'riva_riskid';
      	else if($this->input->get('iSortCol_0')==1)
        	$order_by = 'riva_risk';
        else if($this->input->get('iSortCol_0')==2)
        	$order_by = 'riva_times';
        else if($this->input->get('iSortCol_0')==3)
       		$order_by = 'riva_comments';
       	 else if($this->input->get('iSortCol_0')==4)
       		$order_by = 'riva_postdatead';
       	else if($this->input->get('iSortCol_0')==5)
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
            $this->db->where("riva_riskid like  '%".$get['sSearch_0']."%'  ");
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("riva_risk like  '%".$get['sSearch_1']."%'  ");
        }

         if(!empty($get['sSearch_2'])){
            $this->db->where("riva_times like  '%".$get['sSearch_2']."%'  ");
        }

        if(!empty($get['sSearch_3'])){
            $this->db->where("riva_comments like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("riva_postdatead like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("riva_postdatebs like  '%".$get['sSearch_5']."%'  ");
        }

       
        $this->db->select('*');
		$this->db->from('riva_riskvalues');
        $this->db->order_by($order_by,$order);
        if($limit && $limit>0)
        {  
            $this->db->limit($limit);
        }
        if($offset)
        {
            $this->db->offset($offset);
        }
        if($srch)
        {
        	$this->db->where($srch);
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