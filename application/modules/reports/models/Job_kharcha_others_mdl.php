<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Job_kharcha_others_mdl extends CI_Model
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
  

  public function get_job_kharcha_others_report($tempfn)
  {
    // echo "asd";
    $locationid=$this->input->post('locationid');
  
    $fromdate=$this->input->post('fromdate');
    $todate=$this->input->post('todate');
      $fiscalyrs=$this->input->post('fiscalyrs');
    $month=$this->input->post('month');
    // echo $month;
    // die();
     $yrs_split=explode('/',$fiscalyrs);
    $yr1='2'.$yrs_split[0];
    $yr2='20'.$yrs_split[1];
    if($month>=4 && $month<=12)    
    {
      $yrs_mnth=$yr1.'/'.sprintf("%02d", $month);
    //   echo $yrs_mnth;
    // die();
    } else{
      $yrs_mnth=$yr2.'/'.sprintf("%02d", $month);

    }

    $this->db->select('sm.sama_billdatebs,sm.sama_invoiceno,'.$tempfn.'');
    $this->db->from('sama_salemaster sm');
    
     $this->db->where('sm.sama_billdatebs LIKE '.'"%'.$yrs_mnth.'%"');

      if($this->location_ismain=='Y'){
            if($locationid){
                  $this->db->where('sm.sama_locationid',$locationid);
               }else{
                 $this->db->where('sm.sama_locationid IS NOT NULL');
              }
            }
          else{
              $this->db->where('sm.sama_locationid',$this->locationid);
          }
 
     // $this->db->where(array('sm.sama_billdatebs >='=>$fromdate,'sm.sama_billdatebs<='=>$todate));
   

    $nquery=$this->db->get();
    // echo $this->db->last_query();
    // die();
    // $ndata=$nquery->result();
    // if(!empty($ndata)){
    //   return $ndata;
    // }
    // return false;
      if($nquery->num_rows()>0)
              {
                  return $nquery->result();
              }
              return false;

  }
  


}