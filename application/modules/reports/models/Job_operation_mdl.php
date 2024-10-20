<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Job_operation_mdl extends CI_Model
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
  
    // this is just for demo. Need verification.
    public function get_job_operation_report($type=false)
    {
      
        $locationid = $this->input->post('locationid');
        $year = $this->input->post('year');
        $month = $this->input->post('month');
       $month= sprintf("%02d", $month);
        $srchmnth=$year.'/'.$month;


      $this->db->select('itli_catid, sum(sade_unitrate) as unitrate, sum(sade_qty) as qty, sade_remarks');
      $this->db->from('sade_saledetail sd');
      $this->db->join('sama_salemaster sm','sm.sama_salemasterid = sd.sade_salemasterid','LEFT');
      $this->db->join('itli_itemslist il','il.itli_itemlistid = sd.sade_itemsid','LEFT');
      $this->db->group_by('itli_catid');


        if($locationid){
            $this->db->where('sd.sade_locationid',$locationid);
        }

          $this->db->where('sm.sama_ishandover','N');
      $this->db->where("sm.sama_status <> 'C'");

        $this->db->where('sm.sama_billdatebs LIKE '.'"%'.$srchmnth.'%"');


         if($type == 'job_operation'){
      
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