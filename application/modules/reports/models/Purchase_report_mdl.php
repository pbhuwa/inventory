<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Purchase_report_mdl extends CI_Model
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
  

    public function get_purchase_report($type=false)
    {
      
        $locationid = $this->input->post('locationid');
        $year = $this->input->post('year');
        $month = $this->input->post('month');
        $month= sprintf("%02d", $month);
        $srchmnth=$year.'/'.$month;


      $this->db->select('rm.recm_receiveddatebs,rm.recm_receiveddatead,recm_invoiceno recno,recm_purchaseorderno,s.dist_distributor,rm.recm_clearanceamount as amt,rm.recm_remarks');
      $this->db->from('recm_receivedmaster rm');

      $this->db->join('dist_distributors s','s.dist_distributorid=rm.recm_supplierid','LEFT');
      
      $this->db->where('rm.recm_status','O');
     
      $this->db->where('rm.recm_receiveddatebs LIKE '.'"%'.$srchmnth.'%"');
      $this->db->limit('10');
      $this->db->order_by('rm.recm_receivedmasterid','ASC');


        if($locationid){
            $this->db->where('rm.recm_locationid',$locationid);
        }


         if($type == 'purchase_report'){
            // $this->db->group_by('eqca_category');
            // $this->db->order_by('ec.eqca_category','ASC');
        }else{
            
        }
 
        $qry=$this->db->get();
        //echo $this->db->last_query();die(); 
        if($qry->num_rows()>0)
        {
            return $qry->result();
        }
        return false;
    }


}