<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Unrepair_information_mdl extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
		$this->table='ureq_unrepaireqipment';
	}


	public $validate_settings_unrepair_information = array(               
        array('field' => 'ureq_resoan_disommission', 'label' => 'Decommission', 'rules' => 'trim|required|xss_clean')
	);
	

	public function ureq_information_save()
	{
		$postdata=$this->input->post();
		$id=$this->input->post('id');
		$equipid=$this->input->post('ureq_equipid');

		unset($postdata['id']);
		if($id)
		{
			$postdata['ureq_modifydatead']=CURDATE_EN;
			$postdata['ureq_modifydatebs']=CURDATE_NP;
			$postdata['ureq_modifytime']=$this->general->get_currenttime();
			$postdata['ureq_modifyip']=$this->session->userdata(USER_ID);
			$postdata['ureq_modifyip']=$this->general->get_real_ipaddr();
			$postdata['ureq_modifymac']=$this->general->get_Mac_Address();
			// $postdata['ureq_equipid']=$equipid;
			if(!empty($postdata))
			{
				$this->db->update($this->table,$postdata,array('ureq_repairrequestid'=>$id));
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
			$postdata['ureq_postdatead']=CURDATE_EN;
			$postdata['ureq_postdatebs']=CURDATE_NP;
			$postdata['ureq_posttime']=$this->general->get_currenttime();
			$postdata['ureq_postby']=$this->session->userdata(USER_ID);
			$postdata['ureq_postip']=$this->general->get_real_ipaddr();
			$postdata['ureq_postmac']=$this->general->get_Mac_Address();
			// $postdata['ureq_equipid']=$equipid;
			
		if(!empty($postdata))
		{   //echo "<pre>"; print_r($postdata); die();
			$this->db->insert($this->table,$postdata);
			$insertid=$this->db->insert_id();
			if($insertid)
			{
				$this->db->update('bmin_bmeinventory',array('bmin_isunrepairable'=>'Y'),array('bmin_equipid'=>$equipid));
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
		$this->db->from('ureq_unrepaireqipment m');
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

	public function remove_unrepair_information_information()
	{
		$id=$this->input->post('id');
		if($id)
		{
			$this->db->delete($this->table,array('ureq_unrepairableequid'=>$id));
			$rowaffected=$this->db->affected_rows();
			if($rowaffected)
			{
				return $rowaffected;
			}
			return false;
		}
		return false;
	}

	

	
    public function get_all_unrepair_information_view($srchcol=false,$limit=false,$offset=false,$order_by=false,$order=false)
	{
		$this->db->select('u.*, bm.bmin_equipid,bm.bmin_equipmentkey,bm.bmin_descriptionid,bm.bmin_modelno,bm.bmin_serialno,bm.bmin_departmentid,bm.bmin_riskid,bm.bmin_equip_oper,bm.bmin_manufacturerid,bm.bmin_distributorid,bm.bmin_amc,bm.bmin_servicedatead,bm.bmin_servicedatebs,bm.bmin_endwarrantydatead,bm.bmin_endwarrantydatebs,bm.bmin_purch_donatedid,bm.bmin_isoperation,bm.bmin_ismaintenance,bm.bmin_amcontractorid,bm.bmin_accessories ,bm.bmin_comments,bm.bmin_currencytypeid,bm.bmin_cost,bm.bmin_removed,bm.bmin_isprintsticker,bm.bmin_postdatead,bm.bmin_postdatebs,bm.bmin_posttime,bm.bmin_postmac,bm.bmin_postip,bm.bmin_postby,bm.bmin_modifydatead,bm.bmin_modifydatebs,bm.bmin_modifytime,bm.bmin_modifymac,bm.bmin_modifyip,bm.bmin_modifyby,bm.bmin_isunrepairable,bm.bmin_isdelete,eql.eqli_description,di.dept_depname as dein_department, mf.manu_manlst, ri.riva_risk');
	    $this->db->from('ureq_unrepaireqipment u');
	    $this->db->join('bmin_bmeinventory bm', 'bm.bmin_equipid = u.ureq_equipid');
	   $this->db->join('eqli_equipmentlist eql','eql.eqli_equipmentlistid=bm.bmin_descriptionid','LEFT');
      $this->db->join('dept_department di','di.dept_depid=bm.bmin_departmentid','LEFT');
      $this->db->join('manu_manufacturers mf','mf.manu_manlistid=bm.bmin_manufacturerid','LEFT');
      $this->db->join('riva_riskvalues ri', 'ri.riva_riskid = bm.bmin_riskid', 'LEFT');
	    
	    
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

	    $qry=$this->db->get();
	     // echo $this->db->last_query();die();
	      
	    if($qry->num_rows()>0)
	    {
	      return $qry->result();
	    }
	     return false;
	}



	public function get_unrepair_request_rec($srch=false)
	{
	    $get = $_GET;
	      foreach ($get as $key => $value) {
	        $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
	      }
	      $where='';
	     
	    if(!empty($get['sSearch_0'])){
	            $this->db->where("ureq_unrepairableequid like  '%".$get['sSearch_0']."%'  ");
     	}

	    if(!empty($get['sSearch_1'])){
	        $this->db->where("ureq_resoan_disommission like  '%".$get['sSearch_1']."%'  ");
	    }

	    if(!empty($get['sSearch_2'])){
	        $this->db->where("ureq_postdatead like  '%".$get['sSearch_2']."%'  ");
	    }
	    $resltrpt=$this->db->select("COUNT(*) as cnt")
  					->from('ureq_unrepaireqipment u')
  					->join('bmin_bmeinventory b', 'b.bmin_equipid = u.ureq_equipid')
  					->get()
  					->row();
	      // echo $this->db->last_query();
	      // die();
	      $totalfilteredrecs=$resltrpt->cnt;

	      $order_by = 'ureq_unrepairableequid';
	      $order = 'desc';
	  
	      $where='';
	      if($this->input->get('iSortCol_0')==0)
	        $order_by = 'u.ureq_unrepairableequid';
	      else if($this->input->get('iSortCol_0')==1)
	        $order_by = 'u.ureq_resoan_disommission';
	      else if($this->input->get('iSortCol_0')==2)
	       $order_by = 'u.ureq_postdatead';
	      
	      if($this->input->get('sSortDir_0')=='desc')
	        $order = 'desc';
	      else if($this->input->get('sSortDir_0')=='asc')
	        $order = 'asc';

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
	            $this->db->where("u.ureq_unrepairableequid like  '%".$get['sSearch_0']."%'  ");
	         }

	         if(!empty($get['sSearch_1'])){
	            $this->db->where("u.ureq_resoan_disommission like  '%".$get['sSearch_1']."%'  ");
	         }

	         if(!empty($get['sSearch_2'])){
	            $this->db->where("u.ureq_postdatead like  '%".$get['sSearch_2']."%'  ");
	         }


	      $this->db->select('u.*, bm.bmin_equipmentkey,eql.eqli_description');
	      $this->db->from('ureq_unrepaireqipment u');
	      $this->db->join('bmin_bmeinventory bm', 'bm.bmin_equipid = u.ureq_equipid');
	      $this->db->join('eqli_equipmentlist eql','eql.eqli_equipmentlistid=bm.bmin_descriptionid','LEFT');
	       
	        $this->db->order_by($order_by,$order);
	        if($limit && $limit>0)
	        {  
	            $this->db->limit($limit);
	        }
	        if($srch)
	        {  
	            $this->db->where($srch);
	        }
	        if($offset)
	        {
	            $this->db->offset($offset);
	        }
	      
	       $nquery=$this->db->get();
	       // echo $this->db->last_query();
	       // die();
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