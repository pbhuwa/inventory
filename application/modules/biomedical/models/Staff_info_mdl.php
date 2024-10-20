<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Staff_info_mdl extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
		$this->table='stin_staffinfo';
	}

	public $validate_settings_staff_info = array( 
	   array('field' => 'stin_staff_infotypeid', 'label' => 'staff_info Type', 'rules' => 'trim|required|xss_clean'),
	 array('field' => 'stin_code', 'label' => 'staff_info Code', 'rules' => 'trim|required|xss_clean|min_length[2]|callback_exists_equipcode'),
        array('field' => 'stin_description', 'label' => 'staff_info Description', 'rules' => 'trim|required|xss_clean|callback_exists_equipdesc'),
       );                
	
	
	public function save_staff_info()
	{
		$postdata=$this->input->post();
		$id=$this->input->post('id');
		

		$postid=$this->general->get_real_ipaddr();
		$postmac=$this->general->get_Mac_Address();
		unset($postdata['id']);
	
		if($id)
		{
			$this->db->trans_start();
			$postdata['stin_modifydatead']=CURDATE_EN;
			$postdata['stin_modifydatebs']=CURDATE_NP;
			$postdata['stin_modifytime']=$this->general->get_currenttime();
			$postdata['stin_modifyby']=$this->session->userdata(USER_ID);
			$postdata['stin_modifyip']=$postid;
			$postdata['stin_modifymac']=$postmac;
			
			if(!empty($postdata))
			{
				 $this->general->save_log($this->table,'stin_staffinfoid',$id,$postdata,'Update');
				$this->db->update($this->table,$postdata,array('stin_staffinfoid'=>$id));
				
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
		
			$postdata['stin_postdatead']=CURDATE_EN;
			$postdata['stin_postdatebs']=CURDATE_NP;
			$postdata['stin_posttime']=$this->general->get_currenttime();
			$postdata['stin_postby']=$this->session->userdata(USER_ID);
			$postdata['stin_orgid']=$this->session->userdata(ORG_ID);
			$postdata['stin_postip']=$postid;
			$postdata['stin_postmac']=$postmac;
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


	public function get_all_staff_info($srchcol=false,$limit=false,$offset=false,$order_by=false,$order=false)
	{
		$this->db->select('st.*,rd.rode_roomname,dp.dept_depname');
		 $this->db->from('stin_staffinfo st');
	    $this->db->join('dept_department dp','dp.dept_depid=st.stin_departmentid	','LEFT');
		 $this->db->join('rode_roomdepartment rd','rd.rode_roomdepartmentid=st.stin_roomid	','LEFT');
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

	      if($order_by)
	      {
	        $this->db->order_by($order_by,$order);
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



	


	public function remove_staff_info()
	{
		$id=$this->input->post('id');
		if($id)
		{
			 $this->general->save_log($this->table,'stin_staffinfoid',$id,$postdata=array(),'Delete');
			$this->db->delete($this->table,array('stin_staffinfoid'=>$id));
			$rowaffected=$this->db->affected_rows();
			if($rowaffected)
			{
				return $rowaffected;
			}
			return false;
		}
		return false;
	}

	public function check_exit_staff_info_for_other($eqcode=false,$id=false)
		{
		$data = array();

		if($id)
		{
			$query = $this->db->get_where($this->table,array('stin_code'=>$eqcode,'stin_staffinfoid !='=>$id));
		}
		else
		{
			$query = $this->db->get_where($this->table,array('stin_code'=>$eqcode));
		}
		if ($query->num_rows() > 0) 
		{
			$data=$query->row();	
			return $data;			
		}
		return false;
		}


	public function check_exit_staff_info_desc_for_other($stin_description=false,$id=false)
		{
		$data = array();

		if($id)
		{
			$query = $this->db->get_where($this->table,array('stin_description'=>$stin_description,'stin_staffinfoid !='=>$id));
		}
		else
		{
			$query = $this->db->get_where($this->table,array('stin_description'=>$stin_description));
		}
		if ($query->num_rows() > 0) 
		{
			$data=$query->row();	
			return $data;			
		}
		return false;
		}

		
	public function get_dstaff_info_list($srch=false)
	{
		$get = $_GET;
      	foreach ($get as $key => $value) {
        	$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
      	}

       if(!empty($get['sSearch_0'])){
            $this->db->where("stin_staffinfoid like  '%".$get['sSearch_0']."%'  ");
        }

		if(!empty($get['sSearch_1'])){
            $this->db->where("eqty_staff_infotype like  '%".$get['sSearch_1']."%'  ");
        }
       	if(!empty($get['sSearch_2'])){
            $this->db->where("stin_code like  '%".$get['sSearch_2']."%'  ");
        }

      
          if(!empty($get['sSearch_3'])){
            $this->db->where("stin_description like  '%".$get['sSearch_3']."%'  ");
        }
          if(!empty($get['sSearch_4'])){
            $this->db->where("stin_comment like  '%".$get['sSearch_4']."%'  ");
        }

        if(!empty($get['sSearch_5'])){
            if(DEFAULT_DATEPICKER=='NP') {
			 $this->db->where("stin_postdatebs like  '%".$get['sSearch_5']."%'  ");
			}else{
				 $this->db->where("stin_postdatead like  '%".$get['sSearch_5']."%'  ");
			}  
        }

      	$resltrpt=$this->db->select("COUNT(*) as cnt")
      					 ->from('stin_staffinfoid eq')
	    				
      					->get()
      					->row();
	    //echo $this->db->last_query();die(); 
      	$totalfilteredrecs=$resltrpt->cnt; 

      	$order_by = 'stin_staffinfoid';
      	$order = 'desc';
      	if($this->input->get('sSortDir_0'))
  		{
  				$order = $this->input->get('sSortDir_0');
  		}
  
      	$where='';
      	if($this->input->get('iSortCol_0')==0)
        	$order_by = 'stin_staffinfoid';
        if($this->input->get('iSortCol_0')==1)
        	$order_by = 'eqty_staff_infotype';
        
      	else if($this->input->get('iSortCol_0')==2)
        	$order_by = 'stin_code';
      	else if($this->input->get('iSortCol_0')==3)
       		$order_by = 'stin_description';
       		else if($this->input->get('iSortCol_0')==4)
      	 	$order_by = 'stin_comment';
       	else if($this->input->get('iSortCol_0')==5)
      	 	$order_by = 'stin_postdatebs';
      	
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
            $this->db->where("stin_staffinfoid like  '%".$get['sSearch_0']."%'  ");
        }

		if(!empty($get['sSearch_1'])){
            $this->db->where("eqty_staff_infotype like  '%".$get['sSearch_1']."%'  ");
        }
       	if(!empty($get['sSearch_2'])){
            $this->db->where("stin_code like  '%".$get['sSearch_2']."%'  ");
        }

      
          if(!empty($get['sSearch_3'])){
            $this->db->where("stin_description like  '%".$get['sSearch_3']."%'  ");
        }
          if(!empty($get['sSearch_4'])){
            $this->db->where("stin_comment like  '%".$get['sSearch_4']."%'  ");
        }

        if(!empty($get['sSearch_5'])){
            if(DEFAULT_DATEPICKER=='NP') {
			 $this->db->where("stin_postdatebs like  '%".$get['sSearch_5']."%'  ");
			}else{
				 $this->db->where("stin_postdatead like  '%".$get['sSearch_5']."%'  ");
			}  
        }
       
        $this->db->select('*');
	    $this->db->from('stin_staffinfoid eq');
	    //$this->db->join('eqty_staff_infotype et','et.eqty_staff_infotypeid=eq.stin_staff_infotypeid','LEFT');
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