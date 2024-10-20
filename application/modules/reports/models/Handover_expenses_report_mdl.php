<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Handover_expenses_report_mdl extends CI_Model
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
  

    public function get_handover_expenses_report($type=false)
    {
      
        $locationid = $this->input->post('locationid');
        $year = $this->input->post('year');
        $fiscalyrs=$this->input->post('fiscalyrs');
        $fyrsarr=explode('/',$fiscalyrs);
        if(!empty($fyrsarr)){
           // echo $start_yrs='2'.$fyrsarr[0].'/04/01';
           // echo $end_yrs='20'.$fyrsarr[1].'/03/31';
           $start_yrs='2'.$fyrsarr[0];
           $end_yrs='20'.$fyrsarr[1];
        }
        // die();

        $month = $this->input->post('month');
        if($month>0 && $month<12){
            $yrs_month=$start_yrs.'/'.sprintf("%02d", $month);
        }else{
            $yrs_month=$end_yrs.'/'.sprintf("%02d", $month);
        }
        
        $this->db->select('hm.haov_handoverdatebs,hm.haov_handoverdatead,hm.haov_handoverno,lo1.loca_name as fromloc,lo2.loca_name as toloc,
            il.itli_itemcode,il.itli_itemname,hd.haod_qty,hd.haod_unitprice,(hd.haod_qty*hd.haod_unitprice) as gtotal, hd.haod_remarks');
        $this->db->from('haov_handovermaster hm');
        $this->db->join('haod_handoverdetail hd','hd.haod_handovermasterid=hm.haov_handovermasterid','LEFT');
        $this->db->join('itli_itemslist il','il.itli_itemlistid = hd.haod_itemsid','LEFT');
        $this->db->join('loca_location lo1','lo1.loca_locationid = hm.haov_fromlocationid','LEFT');
        $this->db->join('loca_location lo2','lo2.loca_locationid = hm.haov_tolocationid','LEFT');

        $this->db->where('hm.haov_isreceived','Y');
        $this->db->where("hm.haov_status <> 'C'");
         $this->db->where('hm.haov_fromlocationid',$locationid);
        $this->db->where('hm.haov_handoverdatebs LIKE '.'"'.$yrs_month.'%"');
        // $this->db->limit('10');
        $this->db->order_by('hm.haov_handovermasterid','ASC');


        if($locationid){
            $this->db->where('hm.haov_locationid',$locationid);
        }


         if($type == 'handover_expenses_report'){
      
        }else{
            
        }
 
        $qry=$this->db->get();
        //  echo $this->db->last_query();die(); 
        if($qry->num_rows()>0)
        {
            return $qry->result();
        }
        return false;
    }

    public function get_all_month_all_location_handover_exp()
    {
        $fiscalyrs=$this->input->post('fiscalyrs');
        $fyrsarr=explode('/',$fiscalyrs);
        if(!empty($fyrsarr)){
            for($i=4;$i<=12;$i++){
                 $fyrs_mnth[]='2'.$fyrsarr[0].'/'.sprintf("%02d", $i);
                 // echo $end_yrs='20'.$fyrsarr[1].'/03';
            }
            for($j=1;$j<=3;$j++){
                 $fyrs_mnth[]='20'.$fyrsarr[1].'/'.sprintf("%02d", $j);
            }
            // echo "<pre>";
            // print_r($fyrs_mnth);

          if(!empty($fyrs_mnth)){
             $location=$this->general->get_tbl_data('loca_locationid,loca_name','loca_location',false,'loca_locationid','ASC');
             // echo "<pre>";
             // print_r($location);
             // die();
             if(!empty($location)){
                $thcol ='';
                foreach($location as $loc){
                    $thcol .="fn_handover_report('EXP',fysmnth,".$loc->loca_locationid.") as handexploc_".$loc->loca_locationid.",";
                }
                $thcolstring=rtrim($thcol, ',');

                // echo $thcolstring;
                foreach($fyrs_mnth as $kfm =>$fmnth){
                    // echo $fmnth;

                     $str_with_f_mnth=str_replace('fysmnth',"'".$fmnth."'", $thcolstring);

                    $resultarr[]=$this->db->query("SELECT '$fmnth' as fyrs, $str_with_f_mnth")->row();

                }
                // die();
                // echo "<pre>";
                // print_r($resultarr);
                // die();
                if(!empty($resultarr)){
                    return $resultarr;
                }
                return false;
             }

          }
        }
        return true;

    }


}