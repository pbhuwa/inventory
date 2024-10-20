<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Store_credit_report_mdl extends CI_Model
{
  public function __construct()
  {
  parent::__construct();

    $this->curtime = $this->general->get_currenttime();
    $this->userid = $this->session->userdata(USER_ID);
    $this->username = $this->session->userdata(USER_NAME);
    $this->userdepid = $this->session->userdata(USER_DEPT); //storeid
    $this->storeid = $this->session->userdata(STORE_ID);
    $this->mac = $this->general->get_Mac_Address();
    $this->ip = $this->general->get_real_ipaddr();
    $this->locationid=$this->session->userdata(LOCATION_ID);
    $this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
    $this->orgid=$this->session->userdata(ORG_ID);
    
  }
  

    public function get_store_credit_report($type=false)
    {
      
        $locationid = $this->input->post('locationid');
        $year = $this->input->post('year');
        $month = $this->input->post('month');
       $month= sprintf("%02d", $month);
        $srchmnth=$year.'/'.$month;


      $this->db->select('rm.rema_returndatead,rm.rema_returndatebs,rm.rema_receiveno,il.itli_itemcode,il.itli_itemname, 
      rd.rede_qty qty,rd.rede_unitprice,(rd.rede_qty*rd.rede_unitprice) gtotal, rd.rede_remarks');
      $this->db->from('rema_returnmaster rm');

      $this->db->join('rede_returndetail rd','rd.rede_returnmasterid=rm.rema_returnmasterid','LEFT');
    
      $this->db->join('itli_itemslist il','il.itli_itemlistid = rd.rede_itemsid','LEFT');
      $this->db->where("rm.rema_st <> 'C'");
      $this->db->where('rm.rema_returndatebs LIKE '.'"%'.$srchmnth.'%"');
      $this->db->limit('10');
      $this->db->order_by('rm.rema_returnmasterid','ASC');


        if($locationid){
            $this->db->where('rm.rema_locationid',$locationid);
        }


         if($type == 'store_credit_report'){
      
        }else{
            
        }
 
        $qry=$this->db->get();
        // echo $this->db->last_query();die(); 
        if($qry->num_rows()>0)
        {
            return $qry->result();
        }
        return false;
    }


}