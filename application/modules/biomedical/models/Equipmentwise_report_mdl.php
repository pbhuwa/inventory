<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Equipmentwise_report_mdl extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
		// $this->table='eqdc_eqdepchange';
    $this->sess_usercode = $this->session->userdata(USER_GROUPCODE);
    $this->sess_dept = $this->session->userdata(USER_DEPT);
	}

 	public function get_all_department($srchcol=false,$limit=false,$offset=false,$order_by=false,$order='ASC')
    {
        $this->db->select('dp.*,lo.*');
        $this->db->from('dept_department dp');
        $this->db->join('loca_location lo','lo.loca_locationid=dp.dept_locationid','LEFT');
    
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
           if(($this->sess_usercode != 'SA') && ($this->sess_usercode != 'AD')){
 
          $new_sess_dept = explode(',',$this->sess_dept);
          $this->db->where_in('dept_depid',$new_sess_dept);
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

    public function get_department_wise_lists($deptquery)
    {
      $equipmentid = $this->input->get('equipmentid'); 

      $get = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }
        $whr='';

        if(!empty($get['sSearch_1'])){
          
            $this->db->where("eqli_code like  '%".$get['sSearch_1']."%' ");
        }
        if(!empty($get['sSearch_2'])){
           $this->db->where("eqli_description like  '%".$get['sSearch_2']."%' ");
        }
           if(($this->sess_usercode != 'SA') && ($this->sess_usercode != 'AD')){
 
          $new_sess_dept = explode(',',$this->sess_dept);
          $this->db->where_in('dept_depid',$new_sess_dept);
        }

        if($equipmentid){
          $this->db->where('eqli_equipmentlistid',$equipmentid);
        }
       
        $resltrpt=$this->db->select("*")
                         ->from('bmin_bmeinventory bm')
                        ->join('eqli_equipmentlist el','el.eqli_equipmentlistid = bm.bmin_descriptionid','LEFT')
                        ->join('dept_department d','d.dept_depid = bm.bmin_departmentid','LEFT')
                        ->where(array('bm.bmin_isdelete'=>'N','bm.bmin_isunrepairable'=>'N'))
                        ->group_by('bm.bmin_descriptionid')
                        ->get()
                        ->result();
        //echo $this->db->last_query();die(); 
        $totalfilteredrecs=sizeof( $resltrpt); 

        $order_by = 'eqli_equipmentlistid';
        $order = 'desc';
        if($this->input->get('sSortDir_0'))
        {
                $order = $this->input->get('sSortDir_0');
        }
  
        $where='';
      
         if($this->input->get('iSortCol_0')==2)
            $order_by = 'eqli_code';
        else if($this->input->get('iSortCol_0')==3)
            $order_by = 'eqli_description';
           
        
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
          
            $this->db->where("eqli_code like  '%".$get['sSearch_1']."%' ");
        }
        if(!empty($get['sSearch_2'])){
           $this->db->where("eqli_description like  '%".$get['sSearch_2']."%' ");
        }

        $this->db->select("bm.bmin_descriptionid,el.eqli_code,el.eqli_description,$deptquery")
        ->from('bmin_bmeinventory bm')
                        ->join('eqli_equipmentlist el','el.eqli_equipmentlistid = bm.bmin_descriptionid','LEFT')
                        ->join('dept_department d','d.dept_depid = bm.bmin_departmentid','LEFT')
                        ->where(array('bm.bmin_isdelete'=>'N','bm.bmin_isunrepairable'=>'N'))
                        ->group_by('bm.bmin_descriptionid');
                        

        $this->db->order_by($order_by,$order);
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

          if($equipmentid){
          $this->db->where('eqli_equipmentlistid',$equipmentid);
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