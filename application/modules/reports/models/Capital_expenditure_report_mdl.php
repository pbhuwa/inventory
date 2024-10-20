<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Capital_expenditure_report_mdl extends CI_Model
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
  

  public function get_capital_report_report()
  {
    // echo "asd";
    $locationid=$this->input->post('locationid');
    // if($locationid){
    //   $locid=$locationid;
    // }else{
    // $locid=$this->locationid;
    // }
  
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

    $this->db->select('il.itli_itemcode,il.itli_itemname,sama_billdatebs,sama_billdatead,sama_depname,sama_receivedby,sama_remarks,sade_curqty,sade_unitrate, (sade_curqty*sade_unitrate) as totalamt');
    $this->db->from('sama_salemaster sm');
    $this->db->join('sade_saledetail sd','sd.sade_salemasterid=sm.sama_salemasterid','INNER');
    $this->db->join('rema_reqmaster rm','rm.rema_reqno=sm.sama_requisitionno','INNER');
    $this->db->join('itli_itemslist il','il.itli_itemlistid=sd.sade_itemsid','INNER');
    $this->db->join('eqca_equipmentcategory ca','ca.eqca_equipmentcategoryid=il.itli_catid','LEFT');
    $this->db->where('rm.rema_fyear=sm.sama_fyear');
    $this->db->where(array('sm.sama_ishandover'=>'N','sm.sama_status'=>'O','sd.sade_status'=>'O','il.itli_materialtypeid'=>'2'));
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