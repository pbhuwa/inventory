<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Sales_report_mdl extends CI_Model
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
  
    public function get_sales_report($type=false)
    {
      
        $locationid = $this->input->post('locationid');
        $year = $this->input->post('year');
        $month = $this->input->post('month');
       $month= sprintf("%02d", $month);
        $srchmnth=$year.'/'.$month;

      $this->db->select('sm.sama_invoiceno,
                          sm.sama_billdatebs as datebs,sm.sama_billdatead as datead,il.itli_itemcode,il.itli_itemname,sd.sade_curqty,sd.sade_unitrate,(sd.sade_curqty*sd.sade_unitrate) grand_total,sd.sade_remarks');
      $this->db->from('sama_salemaster sm');
      $this->db->join('sade_saledetail sd','sd.sade_salemasterid=sm.sama_salemasterid','LEFT');
      $this->db->join('itli_itemslist il','il.itli_itemlistid = sd.sade_itemsid','LEFT');
      $this->db->where('sm.sama_ishandover','N');
      $this->db->where("sm.sama_status <> 'C'"); 
      $this->db->where("sd.sade_iscancel",'N');
      $this->db->where('sm.sama_billdatebs LIKE '.'"%'.$srchmnth.'%"');
      // $this->db->limit('10');
      $this->db->order_by('sm.sama_salemasterid','ASC');

        if($locationid){
            $this->db->where('sm.sama_locationid',$locationid);
        }

         if($type == 'sales_report'){
      
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