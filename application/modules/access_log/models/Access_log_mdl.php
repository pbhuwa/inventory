<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Access_log_mdl extends CI_Model 
{

	public function __construct() 
	{
		parent::__construct();
    $this->table='loac_loginactivity';
		
	}


public function get_access_log_rec($srchcol=false,$limit=false,$offset=false,$order_by=false,$order=false)
{
    $this->db->select('cl.*');
    $this->db->from('loac_loginactivity cl');
    
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
      $this->db->order_by('loac_logindatebs','ASC');
      $qry=$this->db->get();
      //echo $this->db->last_query();die();
      
        if($qry->num_rows()>0)
          {
          return $qry->result();
       }
     return false;
  }

	public function get_table_list($srchcol=false,$limit=false,$offset=false,$order_by=false,$order=false)
{
    $this->db->select('cl.colt_tablename,tn.tana_tabledisplay');
    $this->db->from('colt_commonlogtable cl');
    $this->db->join('tana_tablename tn','cl.colt_tablename=tn.tana_tablename','inner');
    $this->db->group_by('cl.colt_tablename,tn.tana_tabledisplay');

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
      $qry=$this->db->get();
      //echo $this->db->last_query();die();
      
        if($qry->num_rows()>0)
          {
          return $qry->result();
       }
     return false;
  }

  public function get_access_details_list($cond = false)
    {
        $frmDate=$this->input->get('frmDate');
        $toDate=$this->input->get('toDate');
        $get = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }
        if(!empty($get['sSearch_1'])){
            $this->db->where("lower(loac_logindatebs) like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("lower(loac_logindatead) like  '%".$get['sSearch_2']."%'  ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("lower(loac_logintime) like  '%".$get['sSearch_3']."%'  ");
        }
         if(!empty($get['sSearch_4'])){
            $this->db->where("lower(loac_loginusername) like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("lower(loac_loginip) like  '%".$get['sSearch_5']."%'  ");
        }
          if(!empty($get['sSearch_6'])){
            $this->db->where("lower(loac_isvalidlogin) like  '%".$get['sSearch_6']."%'  ");
        }
/*
        if(!empty($get['sSearch_8'])){
            $this->db->where("rede_remqty like  '%".$get['sSearch_8']."%'  ");
        }
        if(!empty($get['sSearch_9'])){
            $this->db->where("rede_remarks like  '%".$get['sSearch_9']."%'  ");
        }
        //  if(!empty($get['sSearch_11'])){
        //     $this->db->where("sade_unitrate like  '%".$get['sSearch_11']."%'  ");
        // }
        // if(!empty($get['sSearch_10'])){
        //             $this->db->where("sade_qty like  '%".$get['sSearch_10']."%'  ");
        //  }
        $fiscalyear = !empty($get['fiscalyear'])?$get['fiscalyear']:$this->input->post('fiscalyear');
*/
        if($cond) {
          $this->db->where($cond);
        }
/*
        $input_locationid= !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');
      
        if($this->location_ismain=='Y')
          {
            if($input_locationid)
            {
                $this->db->where('rm.rema_locationid',$input_locationid);
            }
        }
        else
        {
             $this->db->where('rm.rema_locationid',$this->locationid);
        }
*/
      
       if(!empty(($frmDate && $toDate)))
        {
            $this->db->where('loac_logindatebs >=',$frmDate);
            $this->db->where('loac_logindatebs <=',$toDate);
        }

        $resltrpt=$this->db->select("COUNT(*) as cnt")
                    ->from('loac_loginactivity la')
                    ->get()->row();
        //echo $this->db->last_query();die(); 

        $totalfilteredrecs=($resltrpt->cnt); 
        
        if($this->input->get('sSortDir_0'))
        {
                $order = $this->input->get('sSortDir_0');
        }
  
        $where='';

       if($this->input->get('iSortCol_0')==1)
            $order_by = 'loac_logindatebs';
       
        else if($this->input->get('iSortCol_0')==2)
            $order_by = 'loac_logindatead';
        else if($this->input->get('iSortCol_0')==3)
            $order_by = 'loac_logintime';
         else if($this->input->get('iSortCol_0')==4)
            $order_by = 'loac_loginusername';
        else if($this->input->get('iSortCol_0')==5)
            $order_by = 'loac_loginip';
        else if($this->input->get('iSortCol_0')==6)
            $order_by = 'loac_isvalidlogin';

       

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


        if(!empty($get['sSearch_1'])){
            $this->db->where("lower(loac_logindatebs) like  '%".$get['sSearch_1']."%'  ");
        }
        if(!empty($get['sSearch_2'])){
            $this->db->where("lower(loac_logindatead) like  '%".$get['sSearch_2']."%'  ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("lower(loac_logintime) like  '%".$get['sSearch_3']."%'  ");
        }
         if(!empty($get['sSearch_4'])){
            $this->db->where("lower(loac_loginusername) like  '%".$get['sSearch_4']."%'  ");
        } 
        if(!empty($get['sSearch_5'])){
            $this->db->where("lower(loac_loginip) like  '%".$get['sSearch_5']."%'  ");
        } 
        if(!empty($get['sSearch_6'])){
            $this->db->where("lower(loac_isvalidlogin) like  '%".$get['sSearch_6']."%'  ");
        }

       if(!empty(($frmDate && $toDate)))
        {
            $this->db->where('loac_logindatebs >=',$frmDate);
            $this->db->where('loac_logindatebs <=',$toDate);
        }
        if($cond) {
          $this->db->where($cond);
        }

        $this->db->select('la.*');
        $this->db->from('loac_loginactivity la');


        $this->db->order_by('loac_logindatebs desc, loac_logintime desc');
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
