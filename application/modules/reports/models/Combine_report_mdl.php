<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Combine_report_mdl extends CI_Model
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

public function get_combine_report_summary()  
{
    $locid=$this->input->post('locationid');
    $mattypeid=$this->input->post('rema_mattypeid');
    $searchtype=$this->input->post('searchDateType');

    $storeid=$this->input->post('store_id');
    $catid=$this->input->post('catid');
    $fromdate = $this->input->post('frmDate');
    $todate = $this->input->post('toDate');
    $rpt_type=$this->input->post('rpt_wise');
    $cond_rema ='';
    $cond_sama='';
    $cond_pure ='';
    $cond_puor ='';
    $cond_recm ='';

    if($this->location_ismain=='Y'){
      if($locid)
      {
          $cond_rema.=" AND rema_locationid =$locid";
          $cond_sama.=" AND sama_locationid =$locid";
          $cond_pure.=" AND pure_locationid =$locid";
          $cond_puor.=" AND puor_locationid =$locid";
          $cond_recm.=" AND recm_locationid =$locid";

      }
    }
    else{
        $cond_rema.=" AND rema_locationid =$this->locationid";
        $cond_sama.=" AND sama_locationid =$this->locationid";
        $cond_pure.=" AND pure_locationid =$this->locationid";
        $cond_puor.=" AND puor_locationid =$this->locationid";
        $cond_recm.=" AND recm_locationid =$this->locationid";
    }

    if($searchtype=='date_range'){
        if($fromdate && $todate){
        $cond_rema .=" AND rema_reqdatebs >='$fromdate' AND rema_reqdatebs <= '$todate' ";
        $cond_sama .=" AND sama_billdatebs >='$fromdate' AND sama_billdatebs <= '$todate' ";
        $cond_pure .=" AND pure_reqdatebs >='$fromdate' AND pure_reqdatebs <= '$todate' ";
        $cond_puor .=" AND puor_orderdatebs >='$fromdate' AND puor_orderdatebs <= '$todate' ";
        $cond_recm .=" AND recm_receiveddatebs >='$fromdate' AND recm_receiveddatebs <= '$todate' ";
      }
    }
    
    if($mattypeid){
        $cond_rema.=" AND rema_mattypeid =$mattypeid";
        $cond_sama.=" AND sama_mattypeid =$mattypeid";
        $cond_pure.=" AND pure_mattypeid =$mattypeid";
        $cond_puor.=" AND puro_mattypeid =$mattypeid";
        $cond_recm.=" AND recm_mattypeid =$mattypeid";
    }


  $sql_qry="SELECT locationid,loc.loca_name,SUM(remaCnt) remaCnt,SUM(issueCnt) issueCnt,SUM(pur_reCnt) pur_reCnt,SUM(poCnt) as poCnt,SUM(recCnt) as recCnt FROM (
        SELECT rema_locationid as locationid,COUNT('*') as remaCnt,0 as issueCnt,0 as pur_reCnt,0 as poCnt,0 as recCnt from xw_rema_reqmaster WHERE rema_approved!='3' $cond_rema
        GROUP BY rema_locationid
        UNION
        SELECT sama_locationid as locationid, 0 as remaCnt,COUNT('*') as issueCnt,0 as pur_reCnt,0 as poCnt,0 as recCnt from xw_sama_salemaster WHERE sama_status='O' $cond_sama
        GROUP BY sama_locationid
        UNION
        SELECT pure_locationid as locationid, 0 as remaCnt,0 as issueCnt,COUNT('*') as pur_reCnt,0 as poCnt,0 as recCnt from xw_pure_purchaserequisition WHERE pure_isapproved!='C'  $cond_pure
        GROUP BY pure_locationid
        UNION
        SELECT puor_locationid as locationid, 0 as remaCnt,0 as issueCnt,0 as pur_reCnt,COUNT('*') as poCnt,0 as recCnt from xw_puor_purchaseordermaster WHERE puor_status!='C'  $cond_puor
        GROUP BY puor_locationid
        UNION
        SELECT recm_locationid as locationid, 0 as remaCnt,0 as issueCnt,0 as pur_reCnt,0 as poCnt, COUNT('*') as recCnt from xw_recm_receivedmaster WHERE recm_status='O' $cond_recm
        GROUP BY recm_locationid
        )X JOIN xw_loca_location loc on loc.loca_locationid=X.locationid GROUP BY locationid";

  $data=  $this->db->query($sql_qry)->result();
  return $data;

}
 
}