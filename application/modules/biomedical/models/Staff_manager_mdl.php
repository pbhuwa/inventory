
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class staff_manager_mdl extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
		$this->table='stin_staffinfo';
	}


	

	public $validate_settings_staff_manager = array(               
         array('field' => 'stin_code', 'label' => 'Staff Code ', 'rules' => 'trim|required|xss_clean|callback_exists_stin_code'),
      array('field' => 'stin_fname', 'label' => 'First Name', 'rules' => 'trim|required|xss_clean'),            
	  
        array('field' => 'stin_lname', 'label' => 'Last Name', 'rules' => 'trim|required|xss_clean'), 
         );
	
	public function staff_manager_save()
	{
		$postdata=$this->input->post();
		$id=$this->input->post('id');
		unset($postdata['id']);
		if($id)
		{
		$postdata['stin_modifydatead']=CURDATE_EN;
		$postdata['stin_modifydatebs']=CURDATE_NP;
		$postdata['stin_modifytime']=date('H:i:s');
		$postdata['stin_modifyip']='';
		$postdata['stin_modifyip']=$this->general->get_real_ipaddr();
		$postdata['stin_modifymac']=$this->general->get_Mac_Address();
		if(!empty($postdata))
		{
			$this->db->update($this->table,$postdata,array('stin_staffinfoid'=>$id));
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
		// $postdata['stin_jobstatus']=1;
		$postdata['stin_postdatead']=CURDATE_EN;
		$postdata['stin_postdatebs']=CURDATE_NP;
		$postdata['stin_posttime']=date('H:i:s');
		$postdata['stin_postby']='';
		$postdata['stin_postip']=$this->general->get_real_ipaddr();
		$postdata['stin_postmac']=$this->general->get_Mac_Address();
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

	public function get_all_staff_manager($srstinl=false,$limit=false,$offset=false,$order_by=false,$order=false)
	{
		$this->db->select('st.*,rd.rode_roomname,dp.dept_depname,sp.stpo_staffposition');
		 $this->db->from('stin_staffinfo st');
	    $this->db->join('dept_department dp','dp.dept_depid=st.stin_departmentid','LEFT');
		 $this->db->join('rode_roomdepartment rd','rd.rode_roomdepartmentid=st.stin_roomid','LEFT');
		  $this->db->join('stpo_staffposition sp','sp.stpo_staffpositionid=st.stin_positionid','LEFT');
		  if($srstinl)
		 {
			$this->db->where($srstinl);
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
	
	public function get_all_position($srstinl=false,$limit=false,$offset=false,$order_by=false,$order=false)
	{
		$this->db->select('*');
		 $this->db->from('stpo_staffposition sp');
		 if($srstinl)
	   
		 {
			$this->db->where($srstinl);
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

	public function remove_staff_manager()
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

	public function check_exit_staff_info_desc_for_other($staffcode=false,$id=false)
		{
		$data = array();

		if($id)
		{
			$query = $this->db->get_where($this->table,array('stin_code'=>$staffcode,'stin_staffinfoid !='=>$id));
		}
		else
		{
			$query = $this->db->get_where($this->table,array('stin_code'=>$staffcode));
		}
		if ($query->num_rows() > 0) 
		{
			$data=$query->row();	
			return $data;			
		}
		return false;
		}


    public function get_staff_list()
	{
		$get = $_GET;
 
      	foreach ($get as $key => $value) {
        	$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
      	}
     	if(!empty($get['sSearch_0'])){
            $this->db->where("stin_staffinfoid like  '%".$get['sSearch_0']."%'  ");
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("stin_code like  '%".$get['sSearch_1']."%'  ");
        }
        if(!empty($get['sSearch_2'])){
            $this->db->where("stin_fname like  '%".$get['sSearch_2']."%'  ");
        }

        if(!empty($get['sSearch_3'])){
            $this->db->where("stin_address1 like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("stin_mobile like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("dept_depname like  '%".$get['sSearch_5']."%'  ");
        }
        if(!empty($get['sSearch_6'])){
            $this->db->where("rode_roomname like  '%".$get['sSearch_6']."%'  ");
        }
         
        if($this->session->userdata(USER_ACCESS_TYPE)=='S')
      	{
        	//$this->db->where('stin_staffinfoid',$this->session->userdata(ORG_ID));
      	}

        $resltrpt=$this->db->select("COUNT(*) as cnt")
  					->from('stin_staffinfo st')
  					->join('dept_department dp','dp.dept_depid=st.stin_departmentid','LEFT')
		 			->join('rode_roomdepartment rd','rd.rode_roomdepartmentid=st.stin_roomid','LEFT')
		 			->join('stpo_staffposition sp','sp.stpo_staffpositionid=st.stin_positionid','LEFT')
		 			->where('stin_jobstatus','Y')
  					->get()
  					->row(); 
      	//echo $this->db->last_query();die(); 
      	$totalfilteredrecs=$resltrpt->cnt; 
		//print_r($totalfilteredrecs);die;
      	$order_by = 'stin_staffinfoid';
      	$order = 'desc';
      	if($this->input->get('sSortDir_0'))
  		{
  				$order = $this->input->get('sSortDir_0');
  		}
  
      	$where='';
      	if($this->input->get('iSortCol_0')==0)
        	$order_by = 'stin_staffinfoid';
      	else if($this->input->get('iSortCol_0')==1)
        	$order_by = 'stin_code';
        	else if($this->input->get('iSortCol_0')==2)
        	$order_by = 'stin_fname';
      	else if($this->input->get('iSortCol_0')==3)
       		$order_by = 'stin_address1';
       	else if($this->input->get('iSortCol_0')==4)
      	 	$order_by = 'stin_mobile';
      	else if($this->input->get('iSortCol_0')==5)
      	 	$order_by = 'dept_depname';
      	 	else if($this->input->get('iSortCol_0')==6)
      	 	$order_by = 'rode_roomname';
      	
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
            $this->db->where("stin_code like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("stin_fname like  '%".$get['sSearch_2']."%'  ");
        }

        if(!empty($get['sSearch_3'])){
            $this->db->where("stin_address1 like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("stin_mobile like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("dept_depname like  '%".$get['sSearch_5']."%'  ");
        }
        if(!empty($get['sSearch_6'])){
            $this->db->where("rode_roomname like  '%".$get['sSearch_6']."%'  ");
        }
         
        // if($cond) {
        //   $this->db->where($cond);
        // }

         $this->db->select('st.*,rd.rode_roomname,dp.dept_depname,sp.stpo_staffposition');
	     $this->db->from('stin_staffinfo st');
	     $this->db->join('dept_department dp','dp.dept_depid=st.stin_departmentid','LEFT');
		 $this->db->join('rode_roomdepartment rd','rd.rode_roomdepartmentid=st.stin_roomid','LEFT');
		 $this->db->join('stpo_staffposition sp','sp.stpo_staffpositionid=st.stin_positionid','LEFT');
		 $this->db->where('stin_jobstatus','Y');
	    //$this->db->join('coun_country c','c.coun_countryid=di.dist_countryid','left');

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