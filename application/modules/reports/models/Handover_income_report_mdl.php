<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Handover_income_report_mdl extends CI_Model
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
  

    public function get_handover_income_report($type=false)
    {
      
        $locationid = $this->input->post('locationid');
        $year = $this->input->post('year');
        $month = $this->input->post('month');
        $month= sprintf("%02d", $month);
        $srchmnth=$year.'/'.$month;

        $this->db->select('hm.haov_handoverdatebs,hm.haov_handoverdatead,hm.haov_handoverno,lo1.loca_name as fromloc,lo2.loca_name as toloc,
          il.itli_itemcode,il.itli_itemname,hd.haod_qty,hd.haod_unitprice,(hd.haod_qty*hd.haod_unitprice) as gtotal, hd.haod_remarks');
        $this->db->from('haov_handovermaster hm');
        $this->db->join('haod_handoverdetail hd','hd.haod_handovermasterid=hm.haov_handovermasterid','LEFT');
        $this->db->join('itli_itemslist il','il.itli_itemlistid = hd.haod_itemsid','LEFT');
        $this->db->join('loca_location lo1','lo1.loca_locationid = hm.haov_fromlocationid','LEFT');
        $this->db->join('loca_location lo2','lo2.loca_locationid = hm.haov_tolocationid','LEFT');
        $this->db->where('hm.haov_isreceived','Y');
        $this->db->where("hm.haov_status <> 'C'");
         $this->db->where('hm.haov_tolocationid',$locationid);
        $this->db->where('hm.haov_handoverdatebs LIKE '.'"%'.$srchmnth.'%"');
        $this->db->limit('10');
        $this->db->order_by('hm.haov_handovermasterid','ASC');


        if($locationid){
            $this->db->where('hm.haov_locationid',$locationid);
        }


         if($type == 'handover_income_report'){
      
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