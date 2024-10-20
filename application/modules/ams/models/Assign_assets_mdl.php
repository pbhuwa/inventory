<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Assign_assets_mdl extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
		$this->table='eqas_equipmentassign';
	}


public function assign_assets_save()
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
		$assets_data=$this->Assets_mdl->get_assets_list_data(array('asen_asenid'=>$equipArray[$i]));
		$equipArray_all[]=array(
			'eqas_equipid'=>$equipArray[$i],
			'eqas_equipdepid'=> $assets_data[0]->asen_assettype,
			'eqas_equiproomid'=>$assets_data[0]->asen_description,
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
				}				else
				{
				        $this->db->trans_commit();
				        return true;
				}
			
			return false;
	}



public function get_assign_assets($cond=false)
	{

		$get = $_GET;
 
      	foreach ($get as $key => $value) {
        	$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
      	}
     	if(!empty($get['sSearch_0'])){
            $this->db->where("asen_assetcode like  '%".$get['sSearch_0']."%'  ");
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
            $this->db->where("eqca_category like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("itli_itemname like  '%".$get['sSearch_5']."%'  ");
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
		$this->db->join('asen_assetentry as','as.asen_asenid=eql.eqas_equipid','LEFT');
		$this->db->join('dept_department di','di.dept_depid=eql.eqas_equipdepid','LEFT');
		$this->db->join('rode_roomdepartment rd', 'rd.rode_roomdepartmentid = eql.eqas_equiproomid', 'LEFT');
  		$resltrpt=$this->db->get()->row();
      	//echo $this->db->last_query();die(); 
      	$totalfilteredrecs=$resltrpt->cnt; 

      	$order_by = 'asen_assetcode';
      	$order = 'desc';
      	if($this->input->get('sSortDir_0'))
  		{
  				$order = $this->input->get('sSortDir_0');
  		}
  
      	$where='';
      	if($this->input->get('iSortCol_0')==0)
        	$order_by = 'asen_assetcode';
      	else if($this->input->get('iSortCol_0')==1)
        	$order_by = 'stin_fname';
      	else if($this->input->get('iSortCol_0')==2)
       		$order_by = 'usma_username';
       	else if($this->input->get('iSortCol_0')==3)
      	 	$order_by = 'eqas_postdatead';
      	else if($this->input->get('iSortCol_0')==4)
      	 	$order_by = 'eqca_category';
      	 	else if($this->input->get('iSortCol_0')==5)
      	 	$order_by = 'itli_itemname';
      	
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
            $this->db->where("asen_assetcode like  '%".$get['sSearch_0']."%'  ");
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
            $this->db->where("eqca_category like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("itli_itemname like  '%".$get['sSearch_5']."%'  ");
        }

        if($cond) {
          $this->db->where($cond);
        }
        if($this->session->userdata(USER_ACCESS_TYPE)=='S')
      	{
        $this->db->where('eqas_orgid',$this->session->userdata(ORG_ID));
      	}
        
      
		$this->db->select('eql.*,st.stin_fname,st.stin_lname,as.*,ec.*,il.*,um.usma_username,di.dept_depname,rd.rode_roomname');
		$this->db->from('eqas_equipmentassign eql');
	    $this->db->join('stin_staffinfo st','st.stin_staffinfoid=eql.eqas_staffid','LEFT');
	    $this->db->join('usma_usermain um','um.usma_userid=eql.eqas_postby','LEFT');
		$this->db->join('asen_assetentry as','as.asen_asenid=eql.eqas_equipid','LEFT');
    $this->db->join('eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid=as.asen_assettype','LEFT');

       $this->db->join('itli_itemslist il','il.itli_itemlistid=as.asen_description','LEFT');
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







}