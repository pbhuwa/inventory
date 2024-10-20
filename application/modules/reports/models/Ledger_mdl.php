<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ledger_mdl extends CI_Model
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
    $this->mattypeid = $this->session->userdata(USER_MAT_TYPEID);
    
  }
  
  public function stock_report_date_range_detail(){
      $fromdate = $this->input->post('frmDate');
      $todate = $this->input->post('toDate');
      $locationid = $this->input->post('locationid');
      $storeid = $this->input->post('store_id');
      $itemid = $this->input->post('itemid');
      $searchtype = $this->input->post('searchDateType');
      $ledger_type = $this->input->post('ledger_type');

      $condiss1 ='';
      $condiss2 ='';
      $condrec ='';
      $conditem='';
      $cond_trde='';
      $cond_pur_ret = '';
      $cond_iss_ret = '';
      $cond_disposal = '';

      if($searchtype=='date_range'){
        if($fromdate && $todate){
          if(DEFAULT_DATEPICKER=='NP'){
            $condiss1 .= " AND sm.sama_billdatebs < '$fromdate'";
            $condiss2 .= " AND sm.sama_billdatebs >='$fromdate' AND sm.sama_billdatebs<='$todate' ";
            $condrec .=" AND tm.trma_transactiondatebs >='$fromdate' AND tm.trma_transactiondatebs <='$todate' ";
            $cond_pur_ret .=" AND pr.purr_returndatebs >='$fromdate' AND pr.purr_returndatebs <='$todate' ";
            $cond_iss_ret .=" AND rema.rema_returndatebs >= '$fromdate' AND rema.rema_returndatebs <= '$todate' ";
            $cond_disposal .= " AND asde_deposaldatebs >= '$fromdate' AND asde_deposaldatebs <= '$todate' "; 
           
          }  
        }
          
      }

      if($storeid){
          $condiss1 .= " AND sm.sama_storeid = $storeid ";
          $condiss2 .= " AND sm.sama_storeid = $storeid ";
          $condrec .= " AND tm.trma_fromdepartmentid = $storeid ";
          $cond_iss_ret .= " AND rede.rede_storeid = $storeid ";
      }

      if(!empty($locationid )){
          $condiss1 .= ' AND sm.sama_locationid ='.$locationid.'';
          $condiss2 .= ' AND sm.sama_locationid ='.$locationid.'';
          $condrec .= ' AND tm.trma_locationid ='.$locationid.'';
          $cond_trde .= ' AND tm.trma_locationid ='.$locationid.'';
          $cond_pur_ret .= ' AND pr.purr_locationid ='.$locationid.'';
          $cond_iss_ret .=" AND rema.rema_locationid = $locationid";
          $cond_disposal .=" AND asde_locationid = $locationid";
      }
      
      if(!empty($itemid)){
          $condiss1 .= ' AND sade_itemsid ='.$itemid.'';
          $condiss2 .= ' AND sade_itemsid ='.$itemid.'';
          $condrec .= ' AND trde_itemsid ='.$itemid.'';
          $conditem .=' AND itli_itemlistid ='.$itemid.'';
          $cond_trde .= ' AND trde_itemsid ='.$itemid.'';
          $cond_pur_ret .= " AND prd.prde_itemsid = $itemid";
          $cond_iss_ret .= " AND rede.rede_itemsid = $itemid";
          $cond_disposal .= " AND asdd_assetid = $itemid";
      }

      $opening = "
      SELECT
          '-' as datebs,
          '-' as datead,
          'OPENING' as description,
          '-' as refno,
          SUM(pqty)- SUM(iqty) AS inc_qty,
          SUM(ptotal_amt)/ SUM(pqty) rate,
          (SUM(ptotal_amt)/ SUM(pqty))*(SUM(pqty-iqty)) total_amt,
          0 as exp_qty,
          'OPENING' as type
      FROM
      (
          SELECT
              trde_itemsid itemid,
              SUM(trde_requiredqty) pqty,
              SUM(trde_requiredqty) * trde_unitprice AS ptotal_amt,
              0 AS iqty,
              0 AS itotal_amt
          FROM
              xw_trma_transactionmain tm
          INNER JOIN xw_trde_transactiondetail td ON td.trde_trmaid = tm.trma_trmaid
          WHERE
              td.trde_status = 'O'
              AND tm.trma_status = 'O'
              AND tm.trma_received = '1'
              AND tm.trma_transactiondatebs < '".$fromdate."' 
              $cond_trde
          GROUP BY
              trde_itemsid
          UNION
          SELECT
              sd.sade_itemsid itemid,
              0 AS pqty,
              0 AS ptotal_amt,
              SUM(sd.sade_curqty) iqty,
              SUM(sd.sade_curqty) * sd.sade_unitrate itotal_amt
          FROM
              xw_sama_salemaster sm
          INNER JOIN xw_sade_saledetail sd ON sd.sade_salemasterid = sm.sama_salemasterid
          WHERE
              sm.sama_status = 'O'
              AND sm.sama_st != 'C'
              $condiss1
          GROUP BY
              sd.sade_itemsid
      ) X 
      ";

      $purchase = "
      SELECT
          trma_transactiondatebs as datebs,
          trma_transactiondatead as datead,
          'PURCHASE' as description,
          concat( 'Bill No.:', rm.recm_supplierbillno, ' - Invoice:', rm.recm_invoiceno ) AS refno,
          SUM(td.trde_requiredqty) AS incqty,
          td.trde_unitprice AS rate,
          SUM(td.trde_requiredqty) * td.trde_unitprice AS total_amt,
          0 as exp_qty,
          'PURCHASE' as type
      FROM xw_trde_transactiondetail td
      LEFT JOIN xw_recd_receiveddetail rd ON rd.recd_receiveddetailid = td.trde_mtdid
      LEFT JOIN xw_recm_receivedmaster rm ON rm.recm_receivedmasterid = rd.recd_receivedmasterid
      LEFT JOIN xw_trma_transactionmain tm ON tm.trma_trmaid = td.trde_trmaid
      WHERE
         tm.trma_status = 'O'
          AND td.trde_status='O'
          AND tm.trma_received='1'
          $condrec 
      GROUP BY
          td.trde_trmaid   
      ";

      if ($searchtype == 'date_all') {
        $opening = "SELECT
          '-' as datebs,
          '-' as datead,
          'OPENING' as description,
          '-' as refno,
          0 AS inc_qty,
          0 rate,
          0 total_amt,
          0 as exp_qty,
          'OPENING' as type";
      }

      $issue = "
      SELECT
          sm.sama_billdatebs datebs,
          sm.sama_billdatead datead,
          sm.sama_invoiceno description,
          sm.sama_requisitionno refno,
          0 as inc_qty,
          sd.sade_unitrate rate,
          sade_qty * sade_unitrate AS total_amt,
          sd.sade_qty as exp_qty,
          'ISSUE' as type 
      FROM
          xw_sade_saledetail sd  
      LEFT JOIN xw_sama_salemaster sm ON sm.sama_salemasterid = sd.sade_salemasterid
      WHERE
          sm.sama_status = 'O'
          AND sm.sama_st != 'C'
          $condiss2
      ";

      if (ORGANIZATION_NAME == 'NPHL') {
      $disposal = "
        UNION ALL  
          SELECT
          am.asde_deposaldatebs datebs,
          am.asde_desposaldatead datead,
          am.asde_disposalno description,
          am.asde_disposalno refno,
          0 as inc_qty,
          ad.asdd_sales_amount rate, 
          ad.asdd_disposalqty * ad.asdd_sales_amount  AS total_amt,
          ad.asdd_disposalqty as exp_qty,
          UPPER(dety_name) as type
      FROM
          xw_asdd_assetdesposaldetail ad  
      LEFT JOIN xw_asde_assetdesposalmaster am ON am.asde_assetdesposalmasterid = ad.asdd_assetdesposalmasterid
      LEFT JOIN xw_dety_desposaltype dt ON dt.dety_detyid = am.asde_desposaltypeid 
      WHERE
          am.asde_status = 'O'
          AND ad.asdd_status = 'O'
          $cond_disposal
      ";
      }else{
        $disposal = '';
      }

      $issue_return = "
      SELECT
        rema.rema_returndatebs datesbs,
        rema.rema_returndatead datesad, 
          concat( 'ISSUE RETURN-', rema_invoiceno ) description,
          concat( 'REQ NO:', rqm.rema_reqno ) AS refno,
          rede.rede_qty inc_qty,
          rede.rede_unitprice rate,
          rede.rede_total total_amt,
          0 as exp_qty,
          'ISSUE_RETURN' as type
      FROM
          xw_rema_returnmaster rema
          LEFT JOIN xw_rede_returndetail rede ON rede.rede_returnmasterid = rema.rema_returnmasterid
          LEFT JOIN xw_rede_reqdetail rqd ON rqd.rede_reqdetailid = rede.rede_reqdetailid
          LEFT JOIN xw_rema_reqmaster rqm ON rqm.rema_reqmasterid = rqd.rede_reqmasterid
      WHERE
          rede.rede_iscancel = 'N'
          $cond_iss_ret
      ";    
          
      $purchase_return = "
      SELECT
          purr_returndatebs datebs,
          purr_returndatead datead,
          concat('Purchase Return -', pr.purr_invoiceno ) description,
          pr.purr_invoiceno AS refno,
          0 as inc_qty,
          prde_purchaserate rate,
          prde_returnqty * prde_purchaserate AS total_amt,
          prde_returnqty as exp_qty,
          'PURCHASE_RETURN' as type
      FROM 
          xw_prde_purchasereturndetail prd
      LEFT JOIN xw_purr_purchasereturn pr ON pr.purr_purchasereturnid = prd.prde_purchasereturnid
      LEFT JOIN xw_dist_distributors dist ON dist.dist_distributorid = pr.purr_supplierid 
      WHERE
          pr.purr_st = 'N'
          $cond_pur_ret
      ";

      $final_query = "
      SELECT * 
      FROM 
          (
              $opening UNION ALL
              $purchase UNION ALL
              $purchase_return UNION ALL
              $issue UNION ALl
              $issue_return
              $disposal 
          ) X 
      ORDER BY
          X.datebs ASC
      ";

      return $this->db->query($final_query)->result(); 
  }

  
}