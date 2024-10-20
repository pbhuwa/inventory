<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Report_mdl extends CI_Model 
{
  public function __construct() 
  {
    parent::__construct();
      
        $this->curtime = $this->general->get_currenttime();
        $this->userid = $this->session->userdata(USER_ID);
        $this->mac = $this->general->get_Mac_Address();
        $this->ip = $this->general->get_real_ipaddr();
        $this->locationid=$this->session->userdata(LOCATION_ID);
        $this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
  }
  
  public function get_yearly_report(){
    $locationid=$this->input->post('locationid');
    if($this->location_ismain=='Y'){
       if($locationid){
        $locid=$locationid;
        $recrpt_loc=" AND rm.recm_locationid=$locid";
        $han_rec_loc=" AND hm.haov_tolocationid=$locid";
        $hand_exp_loc=" AND hm.haov_fromlocationid=$locid";
        $iss_exp_loc=" AND sama_locationid=$locid";
          $rema_loc=" AND rm.rema_locationid=$locid";
        }else{
        // $locid=$this->locationid;
          $recrpt_loc='';
          $han_rec_loc='';
          $hand_exp_loc='';
          $iss_exp_loc='';
           $rema_loc='';
        }
    }else{
        $locid=$this->locationid;
        $recrpt_loc=" AND rm.recm_locationid=$locid";
        $han_rec_loc=" AND hm.haov_tolocationid=$locid";
        $hand_exp_loc=" AND hm.haov_fromlocationid=$locid";
        $iss_exp_loc=" AND sama_locationid=$locid";
        $rema_loc=" AND rm.rema_locationid=$locid";
    }
    
    // $fromdate=$this->input->post('fromdate');
    // $todate=$this->input->post('todate');
    $fyear= $this->input->post('fiscalyrs');
    $month=$this->input->post('month');
    $yrs_split=explode('/',$fyear);
    $yr1='2'.$yrs_split[0];
    $yr2='20'.$yrs_split[1];
    // echo $yr1;
    // echo $yr2;
    // die();
    $fromdate=$yr1.'/04/01';

    $todate=$this->general->find_end_of_month($yr2.'/03');
    // echo $todate;
    // die();
    
    $sql="SELECT yrs,mnth,fiscalyrs,SUM(rc_amount) rc_amount,SUM(hdr_amount) hdr_amount, SUM(hdo_amount) hdo_amount, SUM(isamt) isamt,SUM(iss_retamt) as iss_retamt FROM( SELECT rdate,( CASE WHEN( ( trim( LEADING '0' FROM substring_index( substring_index(rdate, '/', 2), '/' ,- (1)) ) >= 1 ) AND ( trim( LEADING '0' FROM substring_index( substring_index(rdate, '/', 2), '/' ,- (1) ) ) <= 3 ) ) THEN concat( CONVERT ( CONVERT ( substr( ( substring_index(rdate, '/', 1) - 1 ), 2, 4 ) USING latin1 ) USING utf8 ), '/', substr( substring_index(rdate, '/', 1), 3, 4 ) ) WHEN ( ( MONTH (rdate) >= 4 ) AND ( MONTH (rdate) <= 12 ) ) THEN concat( substr( substring_index(rdate, '/', 1), 2, 4 ), '/', CONVERT ( CONVERT ( substr( ( substring_index(rdate, '/', 1) + 1 ), 3, 4 ) USING latin1 ) USING utf8 ) ) END ) AS `fiscalyrs`, substring_index(rdate, '/', 1) AS `yrs`, trim( LEADING '0' FROM substring_index( substring_index(rdate, '/', 2), '/' ,- (1) ) ) AS `mnth`, SUM(rc_amount) rc_amount,SUM(hdr_amount) hdr_amount, SUM(hdo_amount) hdo_amount, SUM(isamt) isamt,SUM(iss_retamt) as iss_retamt FROM( 
      SELECT recm_receiveddatebs as rdate,SUM( recm_clearanceamount ) AS rc_amount,0 as hdr_amount,0 as hdo_amount, 0 as isamt,0 as iss_retamt FROM xw_recm_receivedmaster rm WHERE rm.recm_status <>'M'  $recrpt_loc  AND recm_receiveddatebs >='$fromdate' AND recm_receiveddatebs <='$todate' GROUP BY rm.recm_receiveddatebs 
      UNION 
      SELECT hm.haov_handoverdatebs as rdate,0 as rc_amount,SUM(hd.haod_qty*hd.haod_unitprice) as hdr_amount,0 as hdo_amount, 0 as isamt,0 as iss_retamt from xw_haov_handovermaster hm LEFT JOIN xw_haod_handoverdetail hd on hd.haod_handovermasterid= hm.haov_handovermasterid WHERE hm.haov_status='O' $han_rec_loc AND hm.haov_handoverdatebs >='$fromdate' AND hm.haov_handoverdatebs <='$todate' GROUP BY hm.haov_handoverdatebs 
      UNION 
      SELECT hm.haov_handoverdatebs as rdate,0 as rc_amount,0 as hdr_amount,SUM(hd.haod_qty*hd.haod_unitprice) as hdo_amount,0 as isamt,0 as iss_retamt from xw_haov_handovermaster hm LEFT JOIN xw_haod_handoverdetail hd on hd.haod_handovermasterid= hm.haov_handovermasterid WHERE hm.haov_status='O' $hand_exp_loc  AND hm.haov_handoverdatebs >='$fromdate' AND hm.haov_handoverdatebs <='$todate' GROUP BY hm.haov_handoverdatebs 
      UNION 
      SELECT sama_billdatebs as rdate,0 as rc_amount,0 as hdr_amount,0 as hdo_amount , SUM(sd.sade_qty*sade_unitrate) as isamt,0 as iss_retamt from xw_sama_salemaster sm INNER JOIN xw_sade_saledetail sd on sd.sade_salemasterid=sm.sama_salemasterid WHERE sm.sama_ishandover='N' AND sm.sama_status='O' $iss_exp_loc AND sm.sama_billdatebs >='$fromdate' AND sm.sama_billdatebs <='$todate' GROUP BY sm.sama_billdatebs 
        UNION 
    SELECT rm.rema_returndatebs AS rdate, 0 AS rc_amount, 0 AS hdr_amount, 0 as hdo_amount,0 as isamt, SUM(rede_qty *rd.rede_unitprice)  iss_retamt FROM xw_rema_returnmaster rm LEFT JOIN xw_rede_returndetail rd ON rd.rede_returnmasterid = rm.rema_returnmasterid WHERE rm.rema_st <> 'C'  $rema_loc AND rm.rema_returndatebs >= '$fromdate' AND rm.rema_returndatebs <= '$todate'
      GROUP BY  rm.rema_returndatebs 

    )X GROUP BY rdate )Y WHERE yrs !='' GROUP BY yrs,mnth";
      // echo "<pre>";
      // echo $sql;
      // die();
        $this->db->query("CREATE TEMPORARY TABLE xw_yearly_income_exp(
                      id INT NOT NULL  AUTO_INCREMENT,
                      yrs int,
                      mnth int,
                      fiscalyrs varchar(20),
                      rc_amount DECIMAL(15,4),
                      hdr_amount DECIMAL(15,4),
                      hdo_amount DECIMAL(15,4),
                      isamt DECIMAL(15,4),
                      iss_retamt DECIMAL(15,4),
                      PRIMARY KEY (id)
                      );"
        );

    $this->db->query("INSERT INTO xw_yearly_income_exp(yrs,mnth,fiscalyrs,rc_amount,hdr_amount,hdo_amount,isamt,iss_retamt) $sql");

    $this->db->select("fn_monthly_opening_stock(CONCAT(yrs,'/',LPAD(mnth,2,0),'/01'),$locationid) as opening_balance,yrs,mnth,fiscalyrs,rc_amount,hdr_amount,hdo_amount,isamt,iss_retamt");
    $this->db->from('yearly_income_exp');
    $this->db->order_by("yrs",'ASC');
    $this->db->order_by('mnth','ASC');
    $nquery=$this->db->get();
    // echo $this->db->last_query();
    // die();
    $ndata=$nquery->result();
    return $ndata;
  }

  public function get_monthly_income_exp_report(){
    $locationid=$this->input->post('locationid');
    // echo 'loc'.$locationid;
    // die();

    if($this->location_ismain=='Y'){
       if($locationid != 'all'){
        $locid=$locationid;
        $recrpt_loc=" AND rm.recm_locationid=$locid";
        $han_rec_loc=" AND hm.haov_tolocationid=$locid";
        $hand_exp_loc=" AND hm.haov_fromlocationid=$locid";
        $iss_exp_loc=" AND sama_locationid=$locid";
        $rema_loc=" AND rm.rema_locationid=$locid";
        }else{
        // $locid=$this->locationid;
          $recrpt_loc='';
          $han_rec_loc='';
          $hand_exp_loc='';
          $iss_exp_loc='';
          $rema_loc='';
        }
    }else{
        $locid=$this->locationid;
        $recrpt_loc=" AND rm.recm_locationid= $locid";
        $han_rec_loc=" AND hm.haov_tolocationid= $locid";
        $hand_exp_loc=" AND hm.haov_fromlocationid= $locid";
        $iss_exp_loc=" AND sama_locationid= $locid";
        $rema_loc=" AND rm.rema_locationid= $locid";
    }
   
   $fromdate=$this->input->post('fromdate');
   $todate=$this->input->post('todate');
    
    $sql="SELECT fn_monthly_opening_stock(rdate,$locationid) as opening_balance, rdate,( CASE WHEN( ( trim( LEADING '0' FROM substring_index( substring_index(rdate, '/', 2), '/' ,- (1)) ) >= 1 ) AND ( trim( LEADING '0' FROM substring_index( substring_index(rdate, '/', 2), '/' ,- (1) ) ) <= 3 ) ) THEN concat( CONVERT ( CONVERT ( substr( ( substring_index(rdate, '/', 1) - 1 ), 2, 4 ) USING latin1 ) USING utf8 ), '/', substr( substring_index(rdate, '/', 1), 3, 4 ) ) WHEN ( ( MONTH (rdate) >= 4 ) AND ( MONTH (rdate) <= 12 ) ) THEN concat( substr( substring_index(rdate, '/', 1), 2, 4 ), '/', CONVERT ( CONVERT ( substr( ( substring_index(rdate, '/', 1) + 1 ), 3, 4 ) USING latin1 ) USING utf8 ) ) END ) AS `fiscalyrs`, substring_index(rdate, '/', 1) AS `yrs`, trim( LEADING '0' FROM substring_index( substring_index(rdate, '/', 2), '/' ,- (1) ) ) AS `mnth`, SUM(rc_amount) rc_amount,SUM(hdr_amount) hdr_amount, SUM(hdo_amount) hdo_amount, SUM(isamt) isamt,SUM(iss_retamt) iss_retamt FROM(SELECT recm_receiveddatebs as rdate,SUM( recm_clearanceamount ) AS rc_amount,0 as hdr_amount,0 as hdo_amount, 0 as isamt,0 as iss_retamt FROM xw_recm_receivedmaster rm WHERE rm.recm_status <>'M'  $recrpt_loc  AND recm_receiveddatebs >='$fromdate' AND recm_receiveddatebs <='$todate' GROUP BY rm.recm_receiveddatebs 
      UNION 
      SELECT hm.haov_handoverdatebs as rdate,0 as rc_amount,SUM(hd.haod_qty*hd.haod_unitprice) as hdr_amount,0 as hdo_amount, 0 as isamt,0 as iss_retamt from xw_haov_handovermaster hm LEFT JOIN xw_haod_handoverdetail hd on hd.haod_handovermasterid= hm.haov_handovermasterid WHERE hm.haov_status='O' $han_rec_loc AND hm.haov_handoverdatebs >='$fromdate' AND hm.haov_handoverdatebs <='$todate' GROUP BY hm.haov_handoverdatebs 
      UNION 
      SELECT hm.haov_handoverdatebs as rdate,0 as rc_amount,0 as hdr_amount,SUM(hd.haod_qty*hd.haod_unitprice) as hdo_amount,0 as isamt,0 as iss_retamt from xw_haov_handovermaster hm LEFT JOIN xw_haod_handoverdetail hd on hd.haod_handovermasterid= hm.haov_handovermasterid WHERE hm.haov_status='O' $hand_exp_loc  AND hm.haov_handoverdatebs >='$fromdate' AND hm.haov_handoverdatebs <='$todate' GROUP BY hm.haov_handoverdatebs 
      UNION 
      SELECT sama_billdatebs as rdate,0 as rc_amount,0 as hdr_amount,0 as hdo_amount , SUM(sd.sade_qty*sade_unitrate) as isamt,0 as iss_retamt from xw_sama_salemaster sm INNER JOIN xw_sade_saledetail sd on sd.sade_salemasterid=sm.sama_salemasterid WHERE sm.sama_ishandover='N' AND sd.sade_iscancel = 'N' AND sm.sama_status='O' $iss_exp_loc AND sm.sama_billdatebs >='$fromdate' AND sm.sama_billdatebs <='$todate' GROUP BY sm.sama_billdatebs  
        UNION 
    SELECT rm.rema_returndatebs AS rdate, 0 AS rc_amount, 0 AS hdr_amount, 0 as hdo_amount,0 as isamt, SUM(rede_qty *rd.rede_unitprice)  iss_retamt FROM xw_rema_returnmaster rm LEFT JOIN xw_rede_returndetail rd ON rd.rede_returnmasterid = rm.rema_returnmasterid WHERE rm.rema_st <> 'C'  $rema_loc AND rm.rema_returndatebs >= '$fromdate' AND rm.rema_returndatebs <= '$todate'
      GROUP BY  rm.rema_returndatebs 
       )X WHERE rdate !='' GROUP BY rdate ORDER BY rdate ASC";
       // echo $sql;
       // die();
    $ndata=$this->db->query($sql)->result();
    
    return $ndata;
  }

  public function daily_market_income_master(){
    $locationid=$this->input->post('locationid');
    $search_date=$this->input->post('search_date');
    $fyrs=$this->input->post('fyrs');
    if($this->location_ismain=='Y'){
       if($locationid!='all'){
        $locid=$locationid;
        $recrpt_loc=" AND rm.recm_locationid=$locid";
        }else{
          $recrpt_loc='';
        }
    }else{
        $locid=$this->locationid;
        $recrpt_loc=" AND rm.recm_locationid=$locid";
     }
      $this->db->select("recm_receivedmasterid, recm_receiveddatebs, recm_receiveddatead, recm_fyear, recm_supplierid, dist_distributor, recm_budgetid, recm_purchaseordermasterid, recm_amount, recm_discount, recm_taxamount, recm_refund, recm_clearanceamount, recm_challanno, recm_purchaseorderno, recm_purchaseorderdatead, recm_purchaseorderdatebs, recm_qtychallan, recm_qtyreceived, recm_supplierbillno, recm_receivedno, recm_departmentid, recm_storeid, recm_status, recm_dstat, recm_tstat, recm_enteredby, recm_supbilldatebs, recm_supbilldatead, recm_invoiceno, recm_daycloseid, recm_insurance, recm_carriagefreight, recm_packing, recm_transportcourier, recm_others, recm_remarks, recm_attachments, recm_billupload, recm_currencysymbol, recm_currencyrate, recm_actualclearanceamount, recm_reqno, loca_name");
     $this->db->from("recm_receivedmaster rm");
     $this->db->join("dist_distributors ds","ds.dist_distributorid=rm.recm_supplierid",'LEFT');
      $this->db->join("loca_location lo","lo.loca_locationid = rm.recm_locationid",'LEFT');
      $this->db->where(array('rm.recm_status<>'=>'M'));
      if(!empty( $locid)){
              $this->db->where(array('rm.recm_locationid'=>$locationid));
      }
      $this->db->where('rm.recm_receiveddatebs',$search_date);

      $this->db->order_by('rm.recm_receivedmasterid',$search_date);
      $result=$this->db->get()->result();
      if(!empty($result)){
        return $result;
      }
      return false;
  }

   public function daily_market_income_master_detail($recmid){
      $this->db->select("recd_itemsid,recd_challanqty,recd_purchasedqty,recd_unitprice,recd_vatpc,
il.itli_itemcode,il.itli_itemname,ut.unit_unitname,
ec.eqca_category");
     $this->db->from("recd_receiveddetail rd");
     $this->db->join("itli_itemslist il","il.itli_itemlistid=rd.recd_itemsid",'LEFT');
      $this->db->join("eqca_equipmentcategory ec","ec.eqca_equipmentcategoryid=il.itli_catid",'LEFT');
      $this->db->join("unit_unit ut"," ut.unit_unitid=il.itli_unitid",'LEFT');
      $this->db->where(array('rd.recd_status<>'=>'M'));
      $this->db->where(array('rd.recd_receivedmasterid'=>$recmid));

      $this->db->order_by('rd.recd_receivedmasterid','ASC');
      $result=$this->db->get()->result();
      if(!empty($result)){
        return $result;
      }
      return false;
  }

  public function daily_handover_income(){
    
  }

  public function daily_handoever_expenses(){

  }

  public function daily_issue_expenses(){

  }

  public function get_monthly_income_only_report(){
    $locationid=$this->input->post('locationid');
    // echo 'loc'.$locationid;
    // die();

    if($this->location_ismain=='Y'){
       if($locationid!='all'){
        $locid=$locationid;
        $recrpt_loc=" AND rm.recm_locationid=$locid";
        $rema_loc=" AND rm.rema_locationid=$locid";
        $hand_inc_loc=" AND hm.haov_tolocationid=$locid";
        $iss_exp_loc=" AND sama_locationid=$locid";
        }else{
        // $locid=$this->locationid;
          $recrpt_loc='';
          $rema_loc='';
          $hand_inc_loc='';
          $iss_exp_loc='';
        }
    }else{
        $locid=$this->locationid;
        $recrpt_loc=" AND rm.recm_locationid=$locid";
        $rema_loc=" AND rm.rema_locationid=$locid";
        $hand_inc_loc=" AND hm.haov_tolocationid=$locid";
        $iss_exp_loc=" AND sama_locationid=$locid";
    }
   
   $fromdate=$this->input->post('fromdate');
   $todate=$this->input->post('todate');
    
    $sql=" SELECT rdate,( CASE WHEN ( ( trim( LEADING '0' FROM substring_index( substring_index(rdate, '/', 2), '/' ,- (1)) ) >= 1 ) AND ( trim( LEADING '0' FROM substring_index( substring_index(rdate, '/', 2), '/' ,- (1) ) ) <= 3 ) ) THEN concat( CONVERT ( CONVERT ( substr( ( substring_index(rdate, '/', 1) - 1 ), 2, 4 ) USING latin1 ) USING utf8 ), '/', substr( substring_index(rdate, '/', 1), 3, 4 ) ) WHEN ( (MONTH(rdate) >= 4) AND (MONTH(rdate) <= 12) ) THEN concat( substr( substring_index(rdate, '/', 1), 2, 4 ), '/', CONVERT ( CONVERT ( substr( ( substring_index(rdate, '/', 1) + 1 ), 3, 4 ) USING latin1 ) USING utf8 ) ) END ) AS `fiscalyrs`, substring_index(rdate, '/', 1) AS `yrs`, trim( LEADING '0' FROM substring_index( substring_index(rdate, '/', 2), '/' ,- (1) ) ) AS `mnth`, SUM(rc_amount) rc_amount, SUM(hdr_amount) hdr_amount, SUM(iss_retamt) AS iss_retamt FROM (
    SELECT recm_receiveddatebs AS rdate, (recm_clearanceamount) AS rc_amount, 0 AS hdr_amount, 0 AS iss_retamt FROM xw_recm_receivedmaster rm LEFT JOIN xw_recd_receiveddetail rd ON rd.recd_receivedmasterid = rm.recm_receivedmasterid WHERE rm.recm_status <> 'M' $recrpt_loc  AND recm_receiveddatebs >= '$fromdate' AND recm_receiveddatebs <= '$todate' GROUP BY rm.recm_receiveddatebs 
    UNION 
    SELECT rm.rema_returndatebs AS rdate, 0 AS rc_amount, 0 AS hdr_amount, SUM(rd.rede_unitprice * rede_qty) iss_retamt FROM xw_rema_returnmaster rm LEFT JOIN xw_rede_returndetail rd ON rd.rede_returnmasterid = rm.rema_returnmasterid WHERE rm.rema_st <> 'C'  $rema_loc AND rm.rema_returndatebs >= '$fromdate' AND rm.rema_returndatebs <= '$todate'  GROUP BY rm.rema_returndatebs 
    UNION 
    SELECT hm.haov_handoverdatebs AS rdate, 0 AS rc_amount, ( hd.haod_qty * hd.haod_unitprice ) AS hdr_amount, 0 AS iss_retamt FROM xw_haov_handovermaster hm LEFT JOIN xw_haod_handoverdetail hd ON hd.haod_handovermasterid = hm.haov_handovermasterid WHERE hm.haov_status = 'O' $hand_inc_loc AND hm.haov_handoverdatebs >= '$fromdate' AND hm.haov_handoverdatebs <= '$todate' GROUP BY hm.haov_handoverdatebs ) X WHERE rdate!='' GROUP BY rdate ";
    $ndata=$this->db->query($sql)->result();
    
    return $ndata;
  }

  public function store_expenses_report()
  {
    $locationid=$this->input->post('locationid');
    if($locationid){
      $locid=$locationid;
    }else{
    $locid=$this->locationid;
    }
    $fiscalyrs=$this->input->post('fiscalyrs');
    $month=$this->input->post('month');
    $yrs_split=explode('/',$fiscalyrs);
    $yr1='2'.$yrs_split[0];
    $yr2='20'.$yrs_split[1];
    if($month>=4 && $month<=12)    
    {
      $yrs_mnth=$yr1.'/'.sprintf("%02d", $month);
    } else{
      $yrs_mnth=$yr2.'/'.sprintf("%02d", $month);
    }

    $this->db->select('ca.eqca_equipmentcategoryid, eqca_code,ca.eqca_category,SUM(sade_curqty)as sade_curqty,sade_unitrate,SUM(sade_curqty*sade_unitrate) as totalamt'); 
    $this->db->from('xw_eqca_equipmentcategory ca'); 
    $this->db->join('xw_itli_itemslist il','ca.eqca_equipmentcategoryid=il.itli_catid','LEFT');
    $this->db->join('xw_sade_saledetail sd','il.itli_itemlistid=sd.sade_itemsid','LEFT');
    $this->db->join('xw_sama_salemaster sm','sd.sade_salemasterid=sm.sama_salemasterid','LEFT');
    $this->db->where(array('sm.sama_status'=>'O','sd.sade_status'=>'O','sama_ishandover'=>'N'));
    $this->db->where('sm.sama_billdatebs LIKE '.'"%'.$yrs_mnth.'%"');
    $this->db->group_by('ca.eqca_equipmentcategoryid');
    $this->db->order_by('eqca_code','ASC');

    $nquery=$this->db->get();
    $ndata=$nquery->result();
    // print_r($ndata);
    // die();
    return $ndata;
  }

   public function expenses_report()
  {
    $locationid=$this->input->post('locationid');
    if($locationid){
      $locid=$locationid;
    }else{
    $locid=$this->locationid;
    }
  
    $fromdate=$this->input->post('fromdate');
    $todate=$this->input->post('todate');
    $fiscalyrs=$this->input->post('fiscalyrs');
    $month=$this->input->post('month');
    // echo $fiscalyrs;
    // die();
    $yrs_split=explode('/',$fiscalyrs);
    $yr1='2'.$yrs_split[0];
    $yr2='20'.$yrs_split[1];
    if($month>=4 && $month<=12)    
    {
      $yrs_mnth=$yr1.'/'.sprintf("%02d", $month);
    } else{
      $yrs_mnth=$yr2.'/'.sprintf("%02d", $month);
    }

    $this->db->select('il.itli_catid, eqca_code,ca.eqca_category, SUM(sade_curqty)sade_curqty,sade_unitrate, SUM(sade_curqty*sade_unitrate) as totalamt');
    $this->db->from('sama_salemaster sm');
    $this->db->join('sade_saledetail sd','sd.sade_salemasterid=sm.sama_salemasterid','INNER');
    $this->db->join('itli_itemslist il','il.itli_itemlistid=sd.sade_itemsid','INNER');
    $this->db->join('eqca_equipmentcategory ca','ca.eqca_equipmentcategoryid=il.itli_catid','LEFT');
    $this->db->where(array('sm.sama_ishandover'=>'N','sm.sama_status'=>'O','sd.sade_status'=>'O','il.itli_materialtypeid'=>'1'));
     $this->db->where('sm.sama_billdatebs LIKE '.'"%'.$yrs_mnth.'%"');
    // $this->db->where(array('sm.sama_billdatebs >='=>$fromdate,'sm.sama_billdatebs<='=>$todate));
    $this->db->group_by('il.itli_catid');

    $nquery=$this->db->get();
    $ndata=$nquery->result();
    return $ndata;
  }

  public function capital_internal_report()
  {
    $locationid=$this->input->post('locationid');
    if($locationid){
      $locid=$locationid;
    }else{
    $locid=$this->locationid;
    }
  
    $fromdate=$this->input->post('fromdate');
    $todate=$this->input->post('todate');
      $fiscalyrs=$this->input->post('fiscalyrs');
    $month=$this->input->post('month');
    // echo $fiscalyrs;
    // die();
     $yrs_split=explode('/',$fiscalyrs);
    $yr1='2'.$yrs_split[0];
    $yr2='20'.$yrs_split[1];
    if($month>=4 && $month<=12)    
    {
      $yrs_mnth=$yr1.'/'.sprintf("%02d", $month);
    } else{
      $yrs_mnth=$yr2.'/'.sprintf("%02d", $month);
    }

    $this->db->select('il.itli_catid, eqca_code,ca.eqca_category, SUM(sade_curqty)sade_curqty,sade_unitrate, SUM(sade_curqty*sade_unitrate) as totalamt');
    $this->db->from('sama_salemaster sm');
    $this->db->join('sade_saledetail sd','sd.sade_salemasterid=sm.sama_salemasterid','INNER');
    $this->db->join('itli_itemslist il','il.itli_itemlistid=sd.sade_itemsid','INNER');
    $this->db->join('eqca_equipmentcategory ca','ca.eqca_equipmentcategoryid=il.itli_catid','LEFT');
    $this->db->where(array('sm.sama_ishandover'=>'N','sm.sama_status'=>'O','sd.sade_status'=>'O','il.itli_materialtypeid'=>'2'));
     $this->db->where('sm.sama_billdatebs LIKE '.'"%'.$yrs_mnth.'%"');
    // $this->db->where(array('sm.sama_billdatebs >='=>$fromdate,'sm.sama_billdatebs<='=>$todate));
    $this->db->group_by('il.itli_catid');

    $nquery=$this->db->get();
    $ndata=$nquery->result();
    return $ndata;
  }

  public function capital_external_report()
  {
    $locationid=$this->input->post('locationid');
    if($locationid){
      $locid=$locationid;
    }else{
    $locid=$this->locationid;
    }
  
    $fromdate=$this->input->post('fromdate');
    $todate=$this->input->post('todate');
      $fiscalyrs=$this->input->post('fiscalyrs');
    $month=$this->input->post('month');
    // echo $fiscalyrs;
    // die();
     $yrs_split=explode('/',$fiscalyrs);
    $yr1='2'.$yrs_split[0];
    $yr2='20'.$yrs_split[1];
    if($month>=4 && $month<=12)    
    {
      $yrs_mnth=$yr1.'/'.sprintf("%02d", $month);
    } else{
      $yrs_mnth=$yr2.'/'.sprintf("%02d", $month);
    }

    $this->db->select('il.itli_catid, eqca_code,ca.eqca_category, SUM(sade_curqty)sade_curqty,sade_unitrate, SUM(sade_curqty*sade_unitrate) as totalamt');
    $this->db->from('sama_salemaster sm');
    $this->db->join('sade_saledetail sd','sd.sade_salemasterid=sm.sama_salemasterid','INNER');
    $this->db->join('itli_itemslist il','il.itli_itemlistid=sd.sade_itemsid','INNER');
    $this->db->join('eqca_equipmentcategory ca','ca.eqca_equipmentcategoryid=il.itli_catid','LEFT');
    $this->db->where(array('sm.sama_ishandover'=>'N','sm.sama_status'=>'O','sd.sade_status'=>'O','il.itli_materialtypeid'=>'3'));
     $this->db->where('sm.sama_billdatebs LIKE '.'"%'.$yrs_mnth.'%"');
    // $this->db->where(array('sm.sama_billdatebs >='=>$fromdate,'sm.sama_billdatebs<='=>$todate));
    $this->db->group_by('il.itli_catid');

    $nquery=$this->db->get();
    $ndata=$nquery->result();
    return $ndata;
  }

  public function party_ledger_report()
  {
    $locationid=$this->input->post('locationid');
    if($locationid){
      $locid=$locationid;
    }else{
    $locid=$this->locationid;
    }
    $fromdate=$this->input->post('fromdate');
    $todate=$this->input->post('todate');

    $this->db->select('recm_receiveddatebs as rdate,ds.dist_distributor,recm_invoiceno,recm_supplierbillno,(
    rm.recm_clearanceamount) AS rc_amount');
    $this->db->from('recm_receivedmaster rm');
    $this->db->join('dist_distributors ds','rm.recm_supplierid=ds.dist_distributorid','LEFT');
    $this->db->where('rm.recm_locationid',$locid);
    $this->db->where(array('rm.recm_receiveddatebs >='=>$fromdate,'rm.recm_receiveddatebs<='=>$todate));
    $this->db->where("rm.recm_supplierid<>''");
    $this->db->where("rm.recm_status",'O');
    $this->db->order_by('recm_receiveddatebs','ASC');

    $nquery=$this->db->get();
    $ndata=$nquery->result();
    return $ndata;
  }

  public function purchase_return_ledger_report()
  {
    $locationid=$this->input->post('locationid');
    if($locationid){
      $locid=$locationid;
    }else{
    $locid=$this->locationid;
    }
    $fromdate=$this->input->post('fromdate');
    $todate=$this->input->post('todate');

    $this->db->select('pr.purr_returndatebs,purr_invoiceno,ds.dist_distributor,purr_returnamount');
    $this->db->from('purr_purchasereturn pr ');
    $this->db->join('dist_distributors ds','pr.purr_supplierid= ds.dist_distributorid','LEFT');
    $this->db->where('pr.purr_locationid',$locid);
    $this->db->where(array('pr.purr_returndatebs >='=>$fromdate,'pr.purr_returndatebs<='=>$todate));
    $this->db->where("pr.purr_st<>'C'");
    $this->db->order_by('pr.purr_returndatebs','ASC');

    $nquery=$this->db->get();
    $ndata=$nquery->result();
    return $ndata;
  }

   public function material_return_ledger_report()
  {
    $locationid=$this->input->post('locationid');
    if($locationid){
      $locid=$locationid;
    }else{
    $locid=$this->locationid;
    }
    $fromdate=$this->input->post('fromdate');
    $todate=$this->input->post('todate');

    $this->db->select('rm.rema_returnmasterid, rm.rema_returndatebs,rm.rema_invoiceno,dp.dept_depname,SUM(rd.rede_unitprice*rede_qty) ret_amt');
    $this->db->from('rema_returnmaster rm');
    $this->db->join('rede_returndetail rd','rd.rede_returnmasterid=rm.rema_returnmasterid','LEFT');
    $this->db->join('dept_department dp','dp.dept_depid=rm.rema_depid','LEFT');
    $this->db->where('rm.rema_locationid',$locid);
    $this->db->where(array('rm.rema_returndatebs >='=>$fromdate,'rm.rema_returndatebs<='=>$todate));
    $this->db->where("rm.rema_st <> 'C'");
    $this->db->group_by('rm.rema_returnmasterid');
    $this->db->order_by('rm.rema_returndatebs','ASC');

    $nquery=$this->db->get();
    $ndata=$nquery->result();
    // echo $this->db->last_query();
    // die();
    return $ndata;
  }

 public function handover_received_report()
  {
    $locationid=$this->input->post('locationid');
    if($locationid){
      $locid=$locationid;
    }else{
    $locid=$this->locationid;
    }
    $fromdate=$this->input->post('fromdate');
    $todate=$this->input->post('todate');

    $this->db->select('hm.haov_handoverdatebs as handoverdate ,haov_handoverno,l.loca_name, haov_totalamount');
    $this->db->from('haov_handovermaster hm  ');
    $this->db->join('haod_handoverdetail hd','hd.haod_handovermasterid= hm.haov_handovermasterid','LEFT');
    $this->db->join('loca_location l','l.loca_locationid=hm.haov_fromlocationid','LEFT');
    $this->db->where('hm.haov_tolocationid',$locid);
    $this->db->where(array('hm.haov_handoverdatebs >='=>$fromdate,'hm.haov_handoverdatebs<='=>$todate));
    $this->db->where("hm.haov_status='O'");
    $this->db->order_by('hm.haov_handoverdatebs','ASC');

    $nquery=$this->db->get();
    $ndata=$nquery->result();
    return $ndata;
  }

  public function current_stock_report()
  {
     $locationid=$this->input->post('locationid');
    if($locationid){
      $locid=$locationid;
    }else{
    $locid=$this->locationid;
    }
    $fromdate=$this->input->post('fromdate');
    $todate=$this->input->post('todate');
     $storid=$this->input->post('store_id');
    $cond='';
    if($locid)
    {
        $cond.=" AND trma_locationid =$locid";
    }
    if($storid)
    {
        $cond.=" AND trma_fromdepartmentid =$storid";
    }
    else
    {
         $cond.="  ";
    }

        // echo INVENTORY_VALUATION;
        // die();

        if(defined('INVENTORY_VALUATION')){
            if(INVENTORY_VALUATION=='FIFO'){
                 $data= $this->db->query('SELECT td.trde_itemsid,il.itli_itemname,il.itli_itemnamenp,il.itli_itemcode,ut.unit_unitname,SUM(td.trde_issueqty)trde_issueqty,td.trde_unitprice,(sum(td.trde_issueqty)*td.trde_unitprice) tamount from xw_trma_transactionmain tm LEFT JOIN xw_trde_transactiondetail td on td.trde_trmaid=tm.trma_trmaid
                  LEFT JOIN xw_itli_itemslist il on il.itli_itemlistid=td.trde_itemsid
                  WHERE tm.trma_received = "1"
                  AND td.trde_status = "O"
                  AND td.trde_issueqty >"0.00" '.$cond.'  
                   GROUP BY il.itli_itemname,td.trde_itemsid, td.trde_unitprice
                  ORDER BY  itli_itemname ASC')->result();
            }
             if(INVENTORY_VALUATION=='AVERAGE_WEIGHTED'){
                 $data= $this->db->query('SELECT td.trde_itemsid,il.itli_itemname,il.itli_itemnamenp,il.itli_itemcode,ut.unit_unitname,SUM(td.trde_issueqty) trde_issueqty,SUM(td.trde_issueqty*td.trde_unitprice)/SUM(td.trde_issueqty) trde_unitprice,SUM(td.trde_issueqty)*(SUM(td.trde_issueqty*td.trde_unitprice)/SUM(td.trde_issueqty)) tamount from xw_trma_transactionmain tm LEFT JOIN xw_trde_transactiondetail td on td.trde_trmaid=tm.trma_trmaid
                  LEFT JOIN xw_itli_itemslist il on il.itli_itemlistid=td.trde_itemsid
                 LEFT JOIN xw_unit_unit ut on ut.unit_unitid=il.itli_unitid
                  WHERE tm.trma_received = "1"
                  AND td.trde_status = "O"
                  AND td.trde_issueqty >"0.00" '.$cond.'  
                  AND il.itli_itemname IS NOT NULL
                   GROUP BY td.trde_itemsid,il.itli_itemname
                  ORDER BY itli_itemname ASC')->result();
            }
        }
        else{
               $data= $this->db->query('SELECT td.trde_itemsid,il.itli_itemname,il.itli_itemcode,il.itli_itemnamenp,ut.unit_unitname,SUM(td.trde_issueqty)trde_issueqty,td.trde_unitprice,(sum(td.trde_issueqty)*td.trde_unitprice) tamount from xw_trma_transactionmain tm LEFT JOIN xw_trde_transactiondetail td on td.trde_trmaid=tm.trma_trmaid
                  LEFT JOIN xw_itli_itemslist il on il.itli_itemlistid=td.trde_itemsid
                  LEFT JOIN xw_unit_unit ut on ut.unit_unitid=il.itli_unitid
                  WHERE tm.trma_received = "1"
                  AND td.trde_status = "O"
                  AND td.trde_issueqty >"0.00" '.$cond.'  
                   GROUP BY il.itli_itemname,td.trde_itemsid, td.trde_unitprice
                  ORDER BY  itli_itemname ASC')->result();
        }

   // echo $this->db->last_query();die;
   return $data;

  }

  public function get_income_exp_report(){
 $locationid=$this->input->post('locationid');
    if($this->location_ismain=='Y'){
       if($locationid){
        $locid=$locationid;
        $recrpt_loc=" AND rm.recm_locationid=$locid";
        $han_rec_loc=" AND hm.haov_tolocationid=$locid";
        $hand_exp_loc=" AND hm.haov_fromlocationid=$locid";
        $iss_exp_loc=" AND sama_locationid=$locid";
        }else{
        // $locid=$this->locationid;
          $recrpt_loc='';
          $han_rec_loc='';
          $hand_exp_loc='';
          $iss_exp_loc='';
        }
    }else{
        $locid=$this->locationid;
        $recrpt_loc=" AND rm.recm_locationid=$locid";
        $han_rec_loc=" AND hm.haov_tolocationid=$locid";
        $hand_exp_loc=" AND hm.haov_fromlocationid=$locid";
        $iss_exp_loc=" AND sama_locationid=$locid";
    }
    
    // $fromdate=$this->input->post('fromdate');
    // $todate=$this->input->post('todate');
    $fyear= $this->input->post('fiscalyrs');
    $yrs_split=explode('/',$fyear);
    $yr1='2'.$yrs_split[0];
    $yr2='20'.$yrs_split[1];
    // echo $yr1;
    // echo $yr2;
    // die();
    $fromdate=$yr1.'/04/01';

    $todate=$this->general->find_end_of_month($yr2.'/03');
    // echo $todate;
    // die();

      $sql="SELECT yrs,mnth,fiscalyrs,SUM(rc_amount) rc_amount,SUM(hdr_amount) hdr_amount, SUM(iss_retamt) as iss_retamt,SUM(hdo_amount) hdo_amount, SUM(isamt) isamt FROM( SELECT rdate,( CASE WHEN( ( trim( LEADING '0' FROM substring_index( substring_index(rdate, '/', 2), '/' ,- (1)) ) >= 1 ) AND ( trim( LEADING '0' FROM substring_index( substring_index(rdate, '/', 2), '/' ,- (1) ) ) <= 3 ) ) THEN concat( CONVERT ( CONVERT ( substr( ( substring_index(rdate, '/', 1) - 1 ), 2, 4 ) USING latin1 ) USING utf8 ), '/', substr( substring_index(rdate, '/', 1), 3, 4 ) ) WHEN ( ( MONTH (rdate) >= 4 ) AND ( MONTH (rdate) <= 12 ) ) THEN concat( substr( substring_index(rdate, '/', 1), 2, 4 ), '/', CONVERT ( CONVERT ( substr( ( substring_index(rdate, '/', 1) + 1 ), 3, 4 ) USING latin1 ) USING utf8 ) ) END ) AS `fiscalyrs`, substring_index(rdate, '/', 1) AS `yrs`, trim( LEADING '0' FROM substring_index( substring_index(rdate, '/', 2), '/' ,- (1) ) ) AS `mnth`, SUM(rc_amount) rc_amount,SUM(hdr_amount) hdr_amount,SUM(iss_retamt) as iss_retamt, SUM(hdo_amount) hdo_amount, SUM(isamt) isamt FROM( 
      SELECT recm_receiveddatebs as rdate,( recm_clearanceamount ) AS rc_amount,0 as hdr_amount,0 as iss_retamt, 0 as hdo_amount, 0 as isamt FROM xw_recm_receivedmaster rm LEFT JOIN xw_recd_receiveddetail rd ON rd.recd_receivedmasterid = rm.recm_receivedmasterid WHERE rm.recm_locationid=$locid AND rm.recm_status <>'M' AND recm_receiveddatebs >='$fromdate' AND recm_receiveddatebs <='$todate' GROUP BY rm.recm_receiveddatebs 
      UNION 
      SELECT rm.rema_returndatebs as rdate,0 as rc_amount,0  as hdr_amount,SUM(rd.rede_unitprice * rede_qty) iss_retamt,
        0 as hdo_amount, 0 as isamt FROM
        xw_rema_returnmaster rm
      LEFT JOIN xw_rede_returndetail rd ON rd.rede_returnmasterid = rm.rema_returnmasterid
      WHERE
        rm.rema_locationid = $locid
      AND rm.rema_returndatebs >= '$fromdate'
      AND rm.rema_returndatebs <= '$todate'
      AND rm.rema_st <> 'C'
      GROUP BY
        rm.rema_returndatebs
      UNION
      SELECT hm.haov_handoverdatebs as rdate,0 as rc_amount,(hd.haod_qty*hd.haod_unitprice) as hdr_amount,0 as iss_retamt, 0 as hdo_amount, 0 as isamt from xw_haov_handovermaster hm LEFT JOIN xw_haod_handoverdetail hd on hd.haod_handovermasterid= hm.haov_handovermasterid WHERE hm.haov_status='O' AND hm.haov_tolocationid=$locid AND hm.haov_handoverdatebs >='$fromdate' AND hm.haov_handoverdatebs <='$todate' GROUP BY hm.haov_handoverdatebs 
      UNION 
      SELECT hm.haov_handoverdatebs as rdate,0 as rc_amount,0 as hdr_amount,0 as iss_retamt, (hd.haod_qty*hd.haod_unitprice) as hdo_amount,0 as isamt from xw_haov_handovermaster hm LEFT JOIN xw_haod_handoverdetail hd on hd.haod_handovermasterid= hm.haov_handovermasterid WHERE hm.haov_status='O' AND hm.haov_fromlocationid=$locid AND hm.haov_handoverdatebs >='$fromdate' AND hm.haov_handoverdatebs <='$todate' GROUP BY hm.haov_handoverdatebs 
      UNION 
      SELECT sama_billdatebs as rdate,0 as rc_amount,0 as hdr_amount,0 as iss_retamt,0 as hdo_amount , SUM(sd.sade_curqty*sade_unitrate) as isamt from xw_sama_salemaster sm INNER JOIN xw_sade_saledetail sd on sd.sade_salemasterid=sm.sama_salemasterid WHERE sm.sama_ishandover='N' AND sm.sama_status='O' AND sama_locationid=$locid AND sm.sama_billdatebs >='$fromdate' AND sm.sama_billdatebs <='$todate' )X GROUP BY rdate )Y WHERE yrs !='' GROUP BY yrs,mnth";

      // echo $sql;
      // die();

        $this->db->query("CREATE TEMPORARY TABLE xw_yearly_income(
                      id INT NOT NULL  AUTO_INCREMENT,
                      yrs int,
                      mnth int,
                      fiscalyrs varchar(20),
                      rc_amount DECIMAL(15,4),
                      hdr_amount DECIMAL(15,4),
                      iss_retamt DECIMAL(15,4),
                      hdo_amount DECIMAL(15,4),
                      isamt DECIMAL(15,4),
                      PRIMARY KEY (id)
                      );"
        );

    $this->db->query("INSERT INTO xw_yearly_income(yrs,mnth,fiscalyrs,rc_amount,hdr_amount,iss_retamt,hdo_amount,isamt) $sql");

    $this->db->select('*');
    $this->db->from('yearly_income');
    $this->db->order_by("yrs",'ASC');
    $this->db->order_by('mnth','ASC');
    $nquery=$this->db->get();
    $ndata=$nquery->result();
    return $ndata;
  }
  
}