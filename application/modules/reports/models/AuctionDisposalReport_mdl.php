<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class AuctionDisposalReport_mdl extends CI_Model
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
  
  public function get_report_summary()
  {
    $locationid = $this->input->post('locationid');
    $searchDateType = $this->input->post('searchDateType');
    $frmDate = $this->input->post('frmDate');
    $toDate = $this->input->post('toDate');
    $mattypeid = $this->input->post('rema_mattypeid');
    $rpt_type = $this->input->post('rpt_type');
    $disposal_type = $this->input->post('disposal_type');

    $this->db->start_cache();

    if($this->location_ismain == 'Y'){
      if($locationid)
      {
          $this->db->where('asde.asde_locationid',$locationid);
      }
    }
    else
    {
      $this->db->where('asde.asde_locationid',$this->locationid);
    }

    if($searchDateType == 'date_range'){
        if(!empty(($frmDate && $toDate))){
            if(DEFAULT_DATEPICKER == 'NP'){
                $this->db->where('asde.asde_deposaldatebs >=',$frmDate);
                $this->db->where('asde.asde_deposaldatebs <=',$toDate);    
            }else{
                $this->db->where('asde.asde_desposaldatead >=',$frmDate);
                $this->db->where('asde.asde_desposaldatead <=',$toDate);
            }
        }

    }

    if(!empty($disposal_type)){
      $this->db->where("asde.asde_desposaltypeid",$disposal_type);
    }

    if (!empty($mattypeid)) {
      $this->db->where("mt.maty_materialtypeid",$mattypeid);
    }

    $this->db->stop_cache();

    $this->db->select("SUM(asdd_sales_totalamt) as asdd_sales_totalamt ,SUM(asdd_sales_amount) as asdd_sales_amount,SUM(asdd_currentvalue) as asdd_currentvalue,dety.dety_name,SUM(asdd_disposalqty) as item_count");
    $this->db->from('asde_assetdesposalmaster asde');
    $this->db->join('asdd_assetdesposaldetail asdd','asdd.asdd_assetdesposalmasterid = asde.asde_assetdesposalmasterid','LEFT');
    $this->db->join('dety_desposaltype dety','dety.dety_detyid = asde.asde_desposaltypeid','LEFT');
    $this->db->join('itli_itemslist it','it.itli_itemlistid = asdd.asdd_assetid','LEFT');
    $this->db->join('maty_materialtype mt','mt.maty_materialtypeid = it.itli_materialtypeid',"LEFT");
    $this->db->group_by('asde_desposaltypeid');
    $data = $this->db->get()->result();
    $this->db->flush_cache();
    return $data;
  }

  public function get_report_detail()
  {
    $locationid = $this->input->post('locationid');
    $searchDateType = $this->input->post('searchDateType');
    $frmDate = $this->input->post('frmDate');
    $toDate = $this->input->post('toDate');
    $mattypeid = $this->input->post('rema_mattypeid');
    $rpt_type = $this->input->post('rpt_type');
    $disposal_type = $this->input->post('disposal_type');

    $this->db->start_cache();

    if($this->location_ismain == 'Y'){
      if($locationid)
      {
          $this->db->where('asde.asde_locationid',$locationid);
      }
    }
    else
    {
      $this->db->where('asde.asde_locationid',$this->locationid);
    }

    if($searchDateType == 'date_range'){
        if(!empty(($frmDate && $toDate))){
            if(DEFAULT_DATEPICKER == 'NP'){
                $this->db->where('asde.asde_deposaldatebs >=',$frmDate);
                $this->db->where('asde.asde_deposaldatebs <=',$toDate);    
            }else{
                $this->db->where('asde.asde_desposaldatead >=',$frmDate);
                $this->db->where('asde.asde_desposaldatead <=',$toDate);
            }
        }

    }

    if(!empty($disposal_type)){
      $this->db->where("asde.asde_desposaltypeid",$disposal_type);
    }

    if (!empty($mattypeid)) {
      $this->db->where("mt.maty_materialtypeid",$mattypeid);
    }

    $this->db->stop_cache();

    $this->db->select("asde_assetdesposalmasterid, asde_fiscalyrs, asde_desposaltypeid, asde_disposalno, asde_manualno, asde_desposaldatead, asde_deposaldatebs, asde_customer_name, asde_remarks, asdd_asddid, asdd_assetid, SUM(asdd_purchaseqty) asdd_purchaseqty , SUM(asdd_disposalqty) asdd_disposalqty, SUM(asdd_sales_amount) asdd_sales_amount, SUM(asdd_sales_totalamt) asdd_sales_totalamt, asdd_remarks, dety.dety_name,il.itli_itemcode,il.itli_itemname")
       ->from('asdd_assetdesposaldetail  asdd')
       ->join('asde_assetdesposalmaster asde','asdd.asdd_assetdesposalmasterid = asde.asde_assetdesposalmasterid','LEFT')
       ->join('dety_desposaltype dety','dety.dety_detyid = asde.asde_desposaltypeid','LEFT')
        ->join('itli_itemslist il','asdd.asdd_assetid = il.itli_itemlistid','LEFT');
      $this->db->join('maty_materialtype mt','mt.maty_materialtypeid = il.itli_materialtypeid',"LEFT");
      $this->db->group_by("asdd_assetdesposalmasterid, asdd_assetid");
    $data = $this->db->get()->result();

    $this->db->flush_cache();
    return $data;
  }

}