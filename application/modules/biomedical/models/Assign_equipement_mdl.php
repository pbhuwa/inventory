<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Assign_equipement_mdl extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
		$this->table='eqas_equipmentassign';
     $this->sess_usercode = $this->session->userdata(USER_GROUPCODE);
        $this->sess_dept = $this->session->userdata(USER_DEPT);
	}

	public $validate_settings_dep_change = array( 
	   array('field' => 'eqas_newdepid', 'label' => 'Department', 'rules' => 'trim|required|xss_clean'),
	     array('field' => 'eqas_date', 'label' => 'Date', 'rules' => 'trim|required|xss_clean'),
	
       );                
	
	
	public function assign_equipment_save()
	{
		$savetype=$this->input->post('savetype');
		$equipid=$this->input->post('equipid');
		// if($savetype=='Y')
		// {

		// }
		$equipArray=explode(',', $equipid);
		$countequip=sizeof($equipArray);
		// echo "<pre>";
		// print_r($equipArray);
		// die();
		// echo $countequip;
		// die();
		$postip=$this->general->get_real_ipaddr();
		$postmac=$this->general->get_Mac_Address();
		$assigndate=$this->input->post('assigndate');
			if(DEFAULT_DATEPICKER=='NP')
	  		{
	  			$assigndatebs=$assigndate;
	  			$assigndatead=$this->general->NepToEngDateConv($assigndate);
	  		}
	  		else
	  		{
	  			$assigndatebs=$this->general->EngToNepDateConv($assigndate);
	  			$assigndatead=$assigndate;
	  		}
	  		$curtime=$this->general->get_currenttime();
	  		$postby=$this->session->userdata(USER_ID);
	  		$orgid=$this->session->userdata(ORG_ID);



		for ($i=0; $i <$countequip ; $i++) { 
		$biomedical_data=$this->bio_medical_mdl->get_biomedical_inventory(array('bmin_equipid'=>$equipArray[$i]));
		$equipArray_all[]=array(
			'eqas_equipid'=>$equipArray[$i],
			'eqas_equipdepid'=> $biomedical_data[0]->bmin_departmentid,
			'eqas_equiproomid'=>$biomedical_data[0]->bmin_roomid,
			'eqas_staffid'=>$this->input->post('staffid'),
			'eqas_staffdepid'=>$this->input->post('staffdepid'),
			'eqas_staffroomid'=>$this->input->post('staffroomid'),
			'eqas_postdatead'=>CURDATE_EN,
			'eqas_postdatebs'=>CURDATE_NP,
			'eqas_posttime'=>$curtime,
			'eqas_postby'=>$postby,
			'eqas_orgid'=>$orgid,
			'eqas_postip'=>$postip,
			'eqas_postmac'=>$postmac,
			'eqas_assigndatebs'=>$assigndatebs,
			'eqas_assigndatead'=>$assigndatead		
		);
}
		
			$this->db->trans_start();
			if(!empty($equipArray_all))
			{
				$this->db->insert_batch($this->table,$equipArray_all);
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
			
			return false;
	}

  public function handover_equipment_save()
  {
    $assignid=$this->input->post('assignid');
    $equipid =$this->input->post('equipid');
    $assigndate=$this->input->post('assigndate');
    $staffid=$this->input->post('staffid');
    $staffdepid=$this->input->post('staffdepid');
    $staffroomid=$this->input->post('staffroomid');

    $biomedical_data=$this->bio_medical_mdl->get_biomedical_inventory(array('bmin_equipid'=>$equipid));
    $departmentid=$biomedical_data[0]->bmin_departmentid;
    $roomid=$biomedical_data[0]->bmin_roomid;

    if(DEFAULT_DATEPICKER=='NP')
      {
          $assigndatebs=$assigndate;
          $assigndatead=$this->general->NepToEngDateConv($assigndate);
      }
      else
      {
          $assigndatebs=$this->general->EngToNepDateConv($assigndate);
          $assigndatead=$assigndate;
      }
      $curtime=$this->general->get_currenttime();
      $postby=$this->session->userdata(USER_ID);
      $orgid=$this->session->userdata(ORG_ID);
      $postip=$this->general->get_real_ipaddr();
      $postmac=$this->general->get_Mac_Address();
   
      $updateArray['eqas_ishandover']='Y';
      $updateArray['eqas_handoverdatead']=CURDATE_EN;
      $updateArray['eqas_handoverdatebs']=CURDATE_NP;
      $updateArray['eqas_handoverstaffid']=$staffid;
      $updateArray['eqas_handoverpostby']=$postby;


      $postdata['eqas_equipid']=$equipid;
      $postdata['eqas_equipdepid']= $departmentid;
      $postdata['eqas_equiproomid']=$roomid;
      $postdata['eqas_staffid']=$staffid;
      $postdata['eqas_staffdepid']=$staffdepid;
      $postdata['eqas_staffroomid']=$staffroomid;
      $postdata['eqas_postdatead']=CURDATE_EN;      
      $postdata['eqas_postdatebs']=CURDATE_NP;
      $postdata['eqas_posttime']=$curtime;
      $postdata['eqas_postby']=$postby;
      $postdata['eqas_orgid']=$orgid;
      $postdata['eqas_postip']=$postip;
      $postdata['eqas_postmac']=$postmac;
      $postdata['eqas_assigndatebs']=$assigndatebs;
      $postdata['eqas_assigndatead']=$assigndatead;
      $postdata['eqas_ishandover']='N';
      $postdata['eqas_handovermasterid']=$assignid;

   

      $this->db->trans_start();
      $this->db->update('eqas_equipmentassign',$updateArray,array('eqas_equipmentassignid'=>$assignid));
      $rwaff=$this->db->affected_rows();
      if($rwaff >0)
      {
        $this->db->insert('eqas_equipmentassign',$postdata);
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

 
    // echo "<pre>";
    // print_r($postdata);
    // die();
  }


	public function get_all_equipment($srchcol=false)
	{
		$this->db->select('eq.*');
		 $this->db->from('eqas_eqdepchange eq');
	    $this->db->join('eqty_equipmenttype et','et.eqty_equipmenttypeid=eq.eqli_equipmenttypeid','LEFT');
		
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

	public function get_assign_equipment($cond=false)
	{

		$get = $_GET;
 
      	foreach ($get as $key => $value) {
        	$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
      	}
     	if(!empty($get['sSearch_0'])){
            $this->db->where("bmin_equipmentkey like  '%".$get['sSearch_0']."%'  ");
        }
         if(!empty($get['sSearch_1'])){
            $this->db->where("stin_fname like  '%".$get['sSearch_1']."%'  ");
        }
         if(!empty($get['sSearch_2'])){
            $this->db->where("usma_username like  '%".$get['sSearch_2']."%'  ");
        }
		 if(!empty($get['sSearch_3'])){
         	if(DEFAULT_DATEPICKER=='NP')
			   {
			    $this->db->where("eqas_postdatebs like  '%".$get['sSearch_3']."%'  ");
			   }
			   else{
			    $this->db->where("eqas_postdatead like  '%".$get['sSearch_3']."%'  ");
			    }
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("dept_depname like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("rode_roomname like  '%".$get['sSearch_5']."%'  ");
        }
         if(($this->sess_usercode != 'SA') && ($this->sess_usercode != 'AD')){
          $new_sess_dept = explode(',',$this->sess_dept);
          $this->db->where_in('dept_depid',$new_sess_dept);
            }
         if($cond) {
          $this->db->where($cond);
        }
        if($this->session->userdata(USER_ACCESS_TYPE)=='S')
      	{
        $this->db->where('eqas_orgid',$this->session->userdata(ORG_ID));
      	}


       	$this->db->select('count("*") as cnt');
		$this->db->from('eqas_equipmentassign eql');
	    $this->db->join('stin_staffinfo st','st.stin_staffinfoid=eql.eqas_staffid','LEFT');
	    $this->db->join('usma_usermain um','um.usma_userid=eql.eqas_postby','LEFT');
		$this->db->join('bmin_bmeinventory bm','bm.bmin_equipid=eql.eqas_equipid','LEFT');
		$this->db->join('dept_department di','di.dept_depid=eql.eqas_equipdepid','LEFT');
		$this->db->join('rode_roomdepartment rd', 'rd.rode_roomdepartmentid = eql.eqas_equiproomid', 'LEFT');

  		$resltrpt=$this->db->get()->row();
      	//echo $this->db->last_query();die(); 
      	$totalfilteredrecs=$resltrpt->cnt; 

      	$order_by = 'bmin_equipmentkey';
      	$order = 'desc';
      	if($this->input->get('sSortDir_0'))
  		{
  				$order = $this->input->get('sSortDir_0');
  		}
  
      	$where='';
      	if($this->input->get('iSortCol_0')==0)
        	$order_by = 'bmin_equipmentkey';
      	else if($this->input->get('iSortCol_0')==1)
        	$order_by = 'stin_fname';
      	else if($this->input->get('iSortCol_0')==2)
       		$order_by = 'usma_username';
       	else if($this->input->get('iSortCol_0')==3)
      	 	$order_by = 'eqas_postdatead';
      	else if($this->input->get('iSortCol_0')==4)
      	 	$order_by = 'dept_depname';
      	 	else if($this->input->get('iSortCol_0')==5)
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
            $this->db->where("bmin_equipmentkey like  '%".$get['sSearch_0']."%'  ");
        }
         if(!empty($get['sSearch_1'])){
            $this->db->where("stin_fname like  '%".$get['sSearch_1']."%'  ");
        }
         if(!empty($get['sSearch_2'])){
            $this->db->where("usma_username like  '%".$get['sSearch_2']."%'  ");
        }
		 if(!empty($get['sSearch_3'])){
         	if(DEFAULT_DATEPICKER=='NP')
			   {
			    $this->db->where("eqas_postdatebs like  '%".$get['sSearch_3']."%'  ");
			   }
			   else{
			    $this->db->where("eqas_postdatead like  '%".$get['sSearch_3']."%'  ");
			    }
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("dept_depname like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("rode_roomname like  '%".$get['sSearch_5']."%'  ");
        }

        if($cond) {
          $this->db->where($cond);
        }
        if($this->session->userdata(USER_ACCESS_TYPE)=='S')
      	{
        $this->db->where('eqas_orgid',$this->session->userdata(ORG_ID));
      	}
        
      
		$this->db->select('eql.*,st.stin_fname,st.stin_lname,bm.bmin_equipmentkey,um.usma_username,di.dept_depname,rd.rode_roomname');
		$this->db->from('eqas_equipmentassign eql');
	    $this->db->join('stin_staffinfo st','st.stin_staffinfoid=eql.eqas_staffid','LEFT');
	    $this->db->join('usma_usermain um','um.usma_userid=eql.eqas_postby','LEFT');
		$this->db->join('bmin_bmeinventory bm','bm.bmin_equipid=eql.eqas_equipid','LEFT');
		$this->db->join('dept_department di','di.dept_depid=eql.eqas_equipdepid','LEFT');
		$this->db->join('rode_roomdepartment rd', 'rd.rode_roomdepartmentid = eql.eqas_equiproomid', 'LEFT');
        $this->db->order_by($order_by,$order);
        
        // if($cond) {
        // 	$this->db->where('manu_postdatead =', date("Y/m/d"));
        // }
        if($limit && $limit>0)
        {  
            $this->db->limit($limit);
        }
        if($offset)
        {
            $this->db->offset($offset);
        }
       if(($this->sess_usercode != 'SA') && ($this->sess_usercode != 'AD')){
          $new_sess_dept = explode(',',$this->sess_dept);
          $this->db->where_in('dept_depid',$new_sess_dept);
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
	    //echo $this->db->last_query();die();
	  return $ndata;
	}

	public function get_assign_equipment_report($srchcol=false,$limit=false,$offset=false,$order_by=false,$order=false)
  {
    $fromdate=$this->input->post('fromdate');
    $todate=$this->input->post('todate');
    $srchdate=$this->input->post('date');
    $srchtxt= $this->input->post('srchtext');
    $this->db->select('as.*,bm.bmin_equipmentkey,bm.bmin_modelno,bm.bmin_serialno,eql.eqli_description,di.dept_depname as dein_department,ri.riva_risk,ri.riva_risktype, ri.riva_year,ri.riva_riskcount,ri.riva_times, dis.dist_distributor,bm.bmin_amc,mf.manu_manlst,rd.rode_roomname,st.stin_code,st.stin_fname,st.stin_lname,um.usma_username,pr.pudo_purdonated,sth.stin_fname as hstin_fname,sth.stin_lname as hstin_lname,umh.usma_username as husma_username');
    $this->db->from('eqas_equipmentassign as');
    $this->db->join('bmin_bmeinventory bm','bm.bmin_equipid=as.eqas_equipid','LEFT');
    $this->db->join('eqli_equipmentlist eql','eql.eqli_equipmentlistid=bm.bmin_descriptionid','LEFT');
    $this->db->join('dept_department di','di.dept_depid=as.eqas_equipdepid','LEFT');
    $this->db->join('rode_roomdepartment rd', 'rd.rode_roomdepartmentid = as.eqas_equiproomid', 'LEFT');
    $this->db->join('riva_riskvalues ri', 'ri.riva_riskid = bm.bmin_riskid', 'LEFT');
    $this->db->join('dist_distributors dis', 'dis.dist_distributorid = bm.bmin_distributorid', 'LEFT');
    $this->db->join('manu_manufacturers mf', 'mf.manu_manlistid = bm.bmin_manufacturerid', 'LEFT');
    $this->db->join('stin_staffinfo st','st.stin_staffinfoid=as.eqas_staffid','LEFT');
      $this->db->join('stin_staffinfo sth','sth.stin_staffinfoid=as.eqas_handoverstaffid','LEFT');
	$this->db->join('usma_usermain um','um.usma_userid=as.eqas_postby','LEFT');
    $this->db->join('usma_usermain umh','umh.usma_userid=as.eqas_handoverpostby','LEFT');
   $this->db->join('pudo_purchdonate pr','pr.pudo_purdonatedid=bm.bmin_purch_donatedid','LEFT');


      if($srchcol)
      {
         $this->db->where($srchcol); 
      }

     
      if($srchdate=='as_date')
      {
        if(DEFAULT_DATEPICKER=='NP')
        {
          $this->db->where('eqas_assigndatebs  >=', $fromdate);
          $this->db->where('eqas_assigndatebs  <=', $todate);
        }
        else
        {
          $this->db->where('eqas_assigndatead >=', $fromdate);
          $this->db->where('eqas_assigndatead <=', $todate);
        }
      
      }

       if($srchdate=='hn_date')
      {
        if(DEFAULT_DATEPICKER=='NP')
        {
          $this->db->where('eqas_handoverdatebs  >=', $fromdate);
          $this->db->where('eqas_handoverdatebs  <=', $todate);
        }
        else
        {
          $this->db->where('eqas_handoverdatead >=', $fromdate);
          $this->db->where('eqas_handoverdatead <=', $todate);
        }
      
      }
      if($srchdate=='post_date')
      {
        if(DEFAULT_DATEPICKER=='NP')
        {
         $this->db->where('eqas_postdatebs >=', $fromdate);
         $this->db->where('eqas_postdatebs <=', $todate);
       }
       else
       {
        $this->db->where('eqas_postdatead >=', $fromdate);
         $this->db->where('eqas_postdatead <=', $todate);
       }
      }
       if($srchtxt)
      {
         $this->db->where("bm.bmin_equipmentkey like  '%".$srchtxt."%'  ");
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

      
         if(($this->sess_usercode != 'SA') && ($this->sess_usercode != 'AD')){
 
          $new_sess_dept = explode(',',$this->sess_dept);
          $this->db->where_in('dept_depid',$new_sess_dept);
        }

     $qry=$this->db->get();
      //echo $this->db->last_query();die();
      
     if($qry->num_rows()>0)
     {
      return $qry->result();
     }
     return false;
  }

  public function get_all_assign_to($srchcol=false)
  {
  		$this->db->select('st.*');
		$this->db->from('stin_staffinfo st');
		
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

   public function get_all_assign_by($srchcol=false)
  {
  		$this->db->select('um.*');
		$this->db->from('usma_usermain um');
		
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

	

	

	
}