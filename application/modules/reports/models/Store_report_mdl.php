<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Store_report_mdl extends CI_Model
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
  
  public function get_store_report_report()
  {
    // echo "asd";
    $locationid=$this->input->post('locationid');
    $fiscalyrs=$this->input->post('fiscalyrs');
    $month=$this->input->post('month');
    $yrs_split=explode('/',$fiscalyrs);
    $yr1='2'.$yrs_split[0];
    $yr2='20'.$yrs_split[1];
    if($month >= 4 && $month <=12 )    
    {
      $yrs_mnth=$yr1.'/'.sprintf("%02d", $month);
    } else{
      $yrs_mnth=$yr2.'/'.sprintf("%02d", $month);
    }
    $start_date=$yrs_mnth.'/01';
    $end_date=$this->general->find_end_of_month($yrs_mnth);
    // $yrs_month_start=sprintf('%s',$yr1).'/04/01';; 
    // $yrs_month_end=sprintf('%s', $yr2).'/03';

    // echo $yrs_mnth;
    // die();$this->db->where('rm.recm_receiveddatebs LIKE '.'"%'.$srchmnth.'%"');
      $recmloc = '';
      $haovloc = '';
      $remaloc = '';
    if($this->location_ismain=='Y'){
      if($locationid){
        $recmloc .= " AND rm.recm_locationid = $locationid";
        $haovloc .= " AND  hm.haov_tolocationid = $locationid";
        $remaloc .= " AND  rm.rema_locationid = $locationid ";
      }else{
        $recmloc .= '';
        $haovloc .= '';
        $remaloc .= '';
      }
    }else{
         $recmloc .= " AND rm.recm_locationid=$this->locationid";
        $haovloc .= " AND  hm.haov_tolocationid=$this->locationid";
        $remaloc .= " AND  rm.rema_locationid=$this->locationid ";
    }

    $result=$this->db->query("SELECT SUM(rc_amount)rc_amount,SUM(hdo_amount) hdo_amount,SUM(iss_retamt) iss_retamt FROM( 
    SELECT sum(recm_clearanceamount) AS rc_amount, 0 AS hdo_amount, 0 AS iss_retamt FROM xw_recm_receivedmaster rm  WHERE rm.recm_status <> 'M' 
     AND rm.recm_receiveddatebs >= '$start_date' AND rm.recm_receiveddatebs <= '$end_date' AND rm.recm_receivedmasterid IS NOT NULL $recmloc   
    UNION 
    SELECT 0 as rc_amount, SUM(hd.haod_qty) * hd.haod_unitprice  AS hdo_amount, 0 as iss_retamt FROM xw_haov_handovermaster hm LEFT JOIN xw_haod_handoverdetail hd ON hd.haod_handovermasterid = hm.haov_handovermasterid WHERE hm.haov_status = 'O'  AND hm.haov_handoverdatebs >= '$start_date' AND hm.haov_handoverdatebs <= '$end_date'  AND hm.haov_handovermasterid IS NOT NULL $haovloc GROUP BY hd.haod_itemsid
    UNION 
    SELECT 0 as rc_amount, 0 AS hdo_amount, SUM(rd.rede_unitprice) * rede_qty iss_retamt FROM xw_rema_returnmaster rm LEFT JOIN xw_rede_returndetail rd ON rd.rede_returnmasterid = rm.rema_returnmasterid WHERE rm.rema_returndatebs >= '$start_date' AND rm.rema_returndatebs <= '$end_date' AND rm.rema_returnmasterid IS NOT NULL  $remaloc GROUP BY rede_itemsid   ) X")->result();
    // echo $this->db->last_query();
    // die;
    return $result;

  }

  public function get_store_expenses_summary($mattype)
  {
    $locationid=$this->input->post('locationid');
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
    // $yrs_month_start=sprintf('%s',$yr1).'/04/01';; 
    // $yrs_month_end=sprintf('%s', $yr2).'/03';

    // echo $yrs_mnth;
    // die();$this->db->where('rm.recm_receiveddatebs LIKE '.'"%'.$srchmnth.'%"');
      $recmloc = '';
     
    if($this->location_ismain=='Y'){
      if($locationid){
        $this->db->where('sm.sama_locationid',$locationid);
        }
    }else{
           $this->db->where('sm.sama_locationid',$this->locationid);
    }

    $this->db->select("il.itli_catid, eqca_code,ca.eqca_category, SUM(sade_curqty)sade_curqty ,sade_unitrate, SUM(sade_curqty*sade_unitrate) as totalamt");
    $this->db->from('sama_salemaster sm');
    $this->db->join('sade_saledetail sd','sd.sade_salemasterid=sm.sama_salemasterid','INNER');
    $this->db->join('itli_itemslist il','il.itli_itemlistid=sd.sade_itemsid','INNER');
    $this->db->join('eqca_equipmentcategory ca','ca.eqca_equipmentcategoryid=il.itli_catid','INNER');
    $this->db->where(array('sm.sama_status'=>'O', 'sd.sade_status'=>'O'));
    $this->db->where(array('sm.sama_ishandover'=>'N'));
    $this->db->where("sm.sama_billdatebs LIKE '".$yrs_mnth."%'");
    $this->db->where('il.itli_materialtypeid=',$mattype);
    $result=$this->db->get()->row();
    if(!empty($result)){
      return $result;
    }
    return false;

  }

  public function get_opening_stock_amount(){
    $locationid=$this->input->post('locationid');
    $fiscalyrs=$this->input->post('fiscalyrs');
    $month=$this->input->post('month');
    
    // $month=$month-1;

    $yrs_split=explode('/',$fiscalyrs);
    $yr1='2'.$yrs_split[0];
    $yr2='20'.$yrs_split[1];
    if($month>=4 && $month<=12)    
    {
      $yrs_mnth=$yr1.'/'.sprintf("%02d", $month).'/01';
    } else{

      $yrs_mnth=$yr2.'/'.sprintf("%02d", $month).'/01';
    }

    // echo $yrs_mnth;
    // die();
    // $yrs_month_start=sprintf('%s',$yr1).'/04/01';; 
    // $yrs_month_end=sprintf('%s', $yr2).'/03';

    // echo $yrs_mnth;
    // die();$this->db->where('rm.recm_receiveddatebs LIKE '.'"%'.$srchmnth.'%"');
      $trloc = '';
      $isloc = '';
      $remloc = '';
     
    // if($this->location_ismain=='Y'){
    //   if($locationid){
    //     $this->db->where('sm.sama_locationid',$locationid);
    //      $trloc = ' AND sm.sama_locationid';
    //      $isloc = '';
    //      $remloc = '';
    //     }else{
      
    //       }
    // }else{
    //        $this->db->where('sm.sama_locationid',$this->locationid);
    // }
      // $sql="SELECT SUM(tr_amount-issueamt+issret_amt) openingbalance FROM (
      //       SELECT SUM(trde_requiredqty*trde_unitprice) tr_amount,0 as issueamt,0 as issret_amt from xw_trma_transactionmain tm
      //       LEFT JOIN xw_trde_transactiondetail td on td.trde_trmaid=tm.trma_trmaid
      //       WHERE tm.trma_status='O'
      //       AND td.trde_status='O'
      //       AND tm.trma_transactiondatebs < '".$yrs_mnth."' 
      //       UNION
      //       SELECT 0 as tr_amount, SUM(sade_qty*sade_unitrate) as iss_totalamt,0 as issret_amt FROM  xw_sama_salemaster sm  
      //       INNER JOIN xw_sade_saledetail sd on sd.sade_salemasterid=sm.sama_salemasterid
      //       WHERE sm.sama_status='O'
      //       AND sd.sade_status='O'
      //       AND sama_billdatebs < '".$yrs_mnth."' 
      //       UNION
      //        SELECT 0 as tr_amount, 0 AS iss_totalamt,  SUM(rd.rede_unitprice * rede_qty) issret_amt 
      //       FROM xw_rema_returnmaster rm LEFT JOIN xw_rede_returndetail rd ON rd.rede_returnmasterid = rm.rema_returnmasterid 
      //       WHERE rm.rema_st <> 'C'   AND rm.rema_returndatebs < '".$yrs_mnth."' 
      //       ) X";
      $sql="SELECT SUM(td.trde_requiredqty * sade_unitrate) -SUM(sade_curqty * sade_unitrate) openingbalance FROM 
              xw_sama_salemaster sm INNER JOIN
              xw_sade_saledetail sd on sd.sade_salemasterid=sm.sama_salemasterid
              INNER JOIN xw_trde_transactiondetail td on td.trde_trdeid=sd.sade_mattransdetailid
                  WHERE sm.sama_status = 'O' AND sd.sade_status='O' AND sm.sama_billdatebs < '".$yrs_mnth."' ";
            // echo $sql;
            // die();
   $result=$this->db->query($sql)->row();
    if(!empty($result)){
      return $result;
    }
    return false;
  }

  public function get_opening_stock_balance()
  {
    $locationid=$this->input->post('locationid');
    $fiscalyrs=$this->input->post('fiscalyrs');
    $month=$this->input->post('month');
      $condiss1 ='';
      $cond_trde='';

   if(!empty($locationid )){
          $condiss1 .= ' AND sm.sama_locationid ='.$locationid.'';
          $cond_trde .= ' AND tm.trma_locationid ='.$locationid.'';

      }
    
    // $month=$month-1;

    $yrs_split=explode('/',$fiscalyrs);
    $yr1='2'.$yrs_split[0];
    $yr2='20'.$yrs_split[1];
    if($month>=4 && $month<=12)    
    {
      $yrs_mnth=$yr1.'/'.sprintf("%02d", $month).'/01';
    } else{

      $yrs_mnth=$yr2.'/'.sprintf("%02d", $month).'/01';
    }

    // echo $yrs_mnth;
    // die();

     $opening_qry = "
      SELECT
          SUM(ptotal_amt)-SUM(itotal_amt) as openingbalance
      FROM
      (
          SELECT
              trde_itemsid itemid,
              SUM(trde_requiredqty) pqty,
              SUM(trde_requiredqty * trde_unitprice) AS ptotal_amt,
              0 AS iqty,
              0 AS itotal_amt
          FROM
              xw_trma_transactionmain tm
          INNER JOIN xw_trde_transactiondetail td ON td.trde_trmaid = tm.trma_trmaid
          WHERE
              td.trde_status = 'O'
              AND tm.trma_status = 'O'
              AND tm.trma_received = '1'
              AND tm.trma_transactiondatebs < '".$yrs_mnth."' 
              $cond_trde
         
          UNION
          SELECT
              sd.sade_itemsid itemid,
              0 AS pqty,
              0 AS ptotal_amt,
              SUM(sd.sade_curqty) iqty,
              SUM(sd.sade_curqty * sd.sade_unitrate) itotal_amt
          FROM
              xw_sama_salemaster sm
          INNER JOIN xw_sade_saledetail sd ON sd.sade_salemasterid = sm.sama_salemasterid
          WHERE
              sm.sama_status = 'O'
              AND sm.sama_st != 'C'
              AND sm.sama_billdatebs < '".$yrs_mnth."'
              $condiss1

      ) X 
      ";

         $result=$this->db->query($opening_qry)->row();
         // echo $this->db->last_query();
         // die;
    if(!empty($result)){
      return $result;
    }
    return false;
  }

   public function get_closing_stock_amount(){
  $locationid=$this->input->post('locationid');
    $fiscalyrs=$this->input->post('fiscalyrs');
    $month=$this->input->post('month');
    
    // $month=$month-1;

    $yrs_split=explode('/',$fiscalyrs);
    $yr1='2'.$yrs_split[0];
    $yr2='20'.$yrs_split[1];
    if($month>=4 && $month<=12)    
    {
      $yrs_mnth_start=$yr1.'/'.sprintf("%02d", $month).'/01';
      $yrs_mnth_end=$this->general->find_end_of_month($yr1.'/'.sprintf("%02d", $month));

    } else{

      $yrs_mnth_start=$yr2.'/'.sprintf("%02d", $month).'/01';
        $yrs_mnth_end=$this->general->find_end_of_month($yr2.'/'.sprintf("%02d", $month));
    }

    // echo $yrs_mnth_start;

    // $yrs_month_start=sprintf('%s',$yr1).'/04/01';; 
    // $yrs_month_end=sprintf('%s', $yr2).'/03';

    // echo $yrs_mnth;
    // die();$this->db->where('rm.recm_receiveddatebs LIKE '.'"%'.$srchmnth.'%"');
      $trloc = '';
      $isloc = '';
      $remloc = '';
     
    // if($this->location_ismain=='Y'){
    //   if($locationid){
    //     $this->db->where('sm.sama_locationid',$locationid);
    //      $trloc = ' AND sm.sama_locationid';
    //      $isloc = '';
    //      $remloc = '';
    //     }else{
      
    //       }
    // }else{
    //        $this->db->where('sm.sama_locationid',$this->locationid);
    // }
  //     $sql="
  //     SELECT SUM(openingbalance)+SUM(tramt)+SUM(recamount)-SUM(isscuramt)+SUM(issret_amt)closingbalance 
  //     FROM(
  // SELECT
  //   SUM(
  //     td.trde_requiredqty * sade_unitrate) - SUM(sade_curqty * sade_unitrate) openingbalance,
  //   0 AS tramt,
  //   0 AS recamount,
  //   0 AS isscuramt,
  //   0 AS issret_amt
  // FROM
  //   xw_sama_salemaster sm
  // INNER JOIN xw_sade_saledetail sd ON sd.sade_salemasterid = sm.sama_salemasterid
  // INNER JOIN xw_trde_transactiondetail td ON td.trde_trdeid = sd.sade_mattransdetailid
  // WHERE
  //   sm.sama_status = 'O'
  // AND sd.sade_status = 'O'
  // AND sm.sama_billdatebs < '".$yrs_mnth_start."'
  // UNION
  //   SELECT
  //     0 AS openingbalance,
  //     0 AS tramt,
  //     SUM(
  //       rd.recd_purchasedqty * rd.recd_arate
  //     ) AS recamount,
  //     0 AS isscuramt,
  //     0 as issret_amt
  //   FROM
  //     xw_recd_receiveddetail rd
  //   INNER JOIN xw_recm_receivedmaster rm ON rm.recm_receivedmasterid = rd.recd_receivedmasterid
  //   WHERE
  //     rm.recm_receiveddatebs >= '".$yrs_mnth_start."'
  //   AND rm.recm_receiveddatebs <= '".$yrs_mnth_end."' 
  //   AND rm.recm_status <> 'M'
  //   UNION
  //     SELECT
  //       0 AS openingbalance,
  //       0 AS tramt,
  //       0 AS recamount,
  //       SUM(sade_curqty * sade_unitrate) isscuramt,
  //       0 as issret_amt
  //     FROM
  //       xw_sade_saledetail sd
  //     INNER JOIN xw_sama_salemaster sm ON sm.sama_salemasterid = sd.sade_salemasterid
  //     WHERE
  //       sm.sama_billdatebs >= '".$yrs_mnth_start."'
  //     AND sm.sama_billdatebs <= '".$yrs_mnth_end."' 
  //     AND sm.sama_status = 'O'
  //     UNION
  //       SELECT
  //         0 AS openingbalance,
  //         0 AS tramt,
  //         0 AS recamount,
  //         0 isscuramt,
  //         SUM(rd.rede_unitprice * rede_qty) issret_amt
  //       FROM
  //         xw_rema_returnmaster rm
  //       LEFT JOIN xw_rede_returndetail rd ON rd.rede_returnmasterid = rm.rema_returnmasterid
  //       WHERE
  //         rm.rema_st <> 'C'
  //       AND rm.rema_returndatebs >= '".$yrs_mnth_start."'
  //       AND rm.rema_returndatebs <= '".$yrs_mnth_end."' )X ";
          // echo $sql;
          // die();

      $sql="SELECT SUM(tr_amount-issueamt+issret_amt) closingbalance FROM (
            SELECT SUM(trde_requiredqty*trde_unitprice) tr_amount,0 as issueamt,0 as issret_amt from xw_trma_transactionmain tm
            LEFT JOIN xw_trde_transactiondetail td on td.trde_trmaid=tm.trma_trmaid
            WHERE tm.trma_status='O'
            AND td.trde_status='O'
            AND tm.trma_transactiondatebs >= '".$yrs_mnth_start."' AND tm.trma_transactiondatebs <= '".$yrs_mnth_end."'  
            UNION
            SELECT 0 as tr_amount, SUM(sade_qty*sade_unitrate) as iss_totalamt,0 as issret_amt FROM  xw_sama_salemaster sm  
            INNER JOIN xw_sade_saledetail sd on sd.sade_salemasterid=sm.sama_salemasterid
            WHERE sm.sama_status='O'
            AND sd.sade_status='O'
            AND sama_billdatebs >= '".$yrs_mnth_start."' AND sama_billdatebs >= '".$yrs_mnth_end."'
            UNION
             SELECT 0 as tr_amount, 0 AS iss_totalamt,  SUM(rd.rede_unitprice * rede_qty) issret_amt 
            FROM xw_rema_returnmaster rm LEFT JOIN xw_rede_returndetail rd ON rd.rede_returnmasterid = rm.rema_returnmasterid 
            WHERE rm.rema_st <> 'C'   AND rm.rema_returndatebs >= '".$yrs_mnth_start."' AND rm.rema_returndatebs >= '".$yrs_mnth_end."' 
            ) X";
            // echo $sql;
            // die();
   $result=$this->db->query($sql)->row();
    if(!empty($result)){
      return $result;
    }
    return false;
  }

}