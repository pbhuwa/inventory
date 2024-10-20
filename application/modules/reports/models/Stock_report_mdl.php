<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Stock_report_mdl extends CI_Model
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
  
 public function distinct_stock_category()
  {

    $locid=$this->input->post('locationid');
    $mattypeid=$this->input->post('mattypeid');
    $searchtype=$this->input->post('searchDateType');

    $storeid=$this->input->post('store_id');
    $catid=$this->input->post('catid');
    $fromdate = $this->input->post('frmDate');
    $todate = $this->input->post('toDate');
    $rpt_type=$this->input->post('rpt_wise');

  $cond='';
  if($this->location_ismain=='Y'){
        if($locid)
        {
            $cond.=" AND trma_locationid =$locid";
        }
    }
    else{
        $cond.=" AND trma_locationid =$this->locationid";
    }

    if($storeid)
    {
        $cond.=" AND trma_fromdepartmentid =$storeid";
    }
    if($catid)
    {
        $cond.= " AND eq.eqca_equipmentcategoryid =$catid";
    }
   
    if(!empty($mattypeid)){
            $cond.= " AND il.itli_materialtypeid =$mattypeid ";
    }
    if(ORGANIZATION_NAME=='KU'){
      $cond .= " AND eqca_mattypeid= $mattypeid ";
    }
     if($searchtype=='date_range'){
        
    }

// $cond='';
     $data= $this->db->query('SELECT DISTINCT(eqca_equipmentcategoryid)eqca_equipmentcategoryid ,eqca_category FROM( SELECT eq.eqca_equipmentcategoryid,eq.eqca_category,tm.trma_transactiondatebs,tm.trma_transactiondatead,il.itli_itemname,il.itli_itemnamenp,td.trde_itemsid,SUM(td.trde_issueqty)trde_issueqty,td.trde_unitprice,(td.trde_issueqty*td.trde_unitprice) tamount from xw_trma_transactionmain tm LEFT JOIN xw_trde_transactiondetail td on td.trde_trmaid=tm.trma_trmaid 
        LEFT JOIN xw_itli_itemslist il on il.itli_itemlistid=td.trde_itemsid
        LEFT JOIN xw_eqca_equipmentcategory eq ON eq.eqca_equipmentcategoryid = il.itli_catid
        WHERE
        tm.trma_received = "1"
        AND td.trde_status = "O"
        AND td.trde_issueqty >0 '.$cond.'  
        AND td.trde_itemsid IS NOT NULL
        GROUP BY il.itli_itemname,td.trde_itemsid, td.trde_unitprice
        )X WHERE eqca_equipmentcategoryid IS NOT NULL  GROUP BY eqca_equipmentcategoryid ORDER by eqca_category ASC')->result();
     // echo  $this->db->last_query();die;
   return $data;
  }

  public function stock_report_data_range_detail($viewcall=false,$viewcat_id=false,$limit = 0,$offset = 0)
  {

    $this->stock_generate_by_date('generate_table',false);
     $category_condition = '';
     if(!empty($viewcat_id)){
      $category_condition = " WHERE itli_catid = $viewcat_id ";
     }
     $limit_cond = '';
     if($limit > 0 && $offset >= 0){

        $limit_cond = " limit $limit offset $offset";
        
        // if ($offset == 1) {
        // $limit_cond = " limit $limit";
        // }
     }
    $searchtype=$this->input->post('searchDateType');
    $fromdate = $this->input->post('frmDate');
    $todate = $this->input->post('toDate');
    $auction_disposal_data = '';
    if($searchtype=='date_range' && $fromdate && $todate){
        if(DEFAULT_DATEPICKER=='NP' && ORGANIZATION_NAME == 'NPHL'){
          $auction_disposal_data .= " ,fn_auction_disposal_item(itemid,'".$fromdate."','".$todate."') as auction_disposal_data";
        }
    }

    $sql_final="
    SELECT * FROM (
    SELECT itemid,il.itli_itemcode,il.itli_itemname, ut.unit_unitname, il.itli_catid,
                SUM(opqty) as opqty,SUM(opamt)/SUM(opqty) as oprate,SUM(opamt) opamt,
                SUM(purqty) as purqty,SUM(puramt)/SUM(purqty) as purrate,SUM(puramt) puramt ,
                SUM(issqty) as issqty,SUM(issamt)/SUM(issqty) as issrate,SUM(issamt) issamt,
                SUM( (opqty + purqty) - issqty) balanceqty,
                SUM( (opamt + puramt) - issamt) balanceamt
                $auction_disposal_data 
                  FROM (
                SELECT itemid,
                SUM(qty) as opqty,SUM(total_amt)/SUM(qty) as oprate,SUM(total_amt) opamt,
                0 as purqty,0 as purrate,0 as puramt,
                0 as issqty,0 as issrate,0 as issamt 
                FROM xw_temp_stockrec
                WHERE type='OPENING'
                GROUP BY itemid 
                UNION
                SELECT itemid,
                0 as opqty,0 as oprate,0 as opamt,  
                SUM(qty) as purqty,SUM(total_amt)/SUM(qty) as purrate,SUM(total_amt) puramt ,
                0 as issqty,0 as issrate,0 as issamt 
                FROM xw_temp_stockrec
                WHERE type='PURCHASE'
                GROUP BY itemid 
                UNION
                SELECT itemid,
                0 as opqty,0 as oprate,0 as opamt,  
                0 as purqty,0 as purrate,0 as puramt,
                SUM(qty) as issqty,SUM(total_amt)/SUM(qty) as issrate,SUM(total_amt) issamt 
                FROM xw_temp_stockrec
                WHERE type='ISSUE'
                GROUP BY itemid 
                ) X LEFT JOIN xw_itli_itemslist il on il.itli_itemlistid=X.itemid LEFT JOIN xw_unit_unit ut on ut.unit_unitid=il.itli_unitid
                $category_condition
                GROUP BY X.itemid
                ORDER BY il.itli_itemcode ASC) Y HAVING balanceqty >= 0 $limit_cond";
        $result_final = $this->db->query($sql_final)->result();
        // echo "<pre>";
        // print_r ($this->db->last_query());
        // echo "</pre>";
        // die();
        
        if(!empty($result_final)){
          return $result_final;
        }
        return false;

  }

  public function stock_report_current($cat_id=false)
  {

   $locid=$this->input->post('locationid');
    $mattypeid=$this->input->post('mattypeid');
    $searchtype=$this->input->post('searchDateType');

    $storeid=$this->input->post('store_id');
    $catid=$this->input->post('catid');
    $fromdate = $this->input->post('frmDate');
    $todate = $this->input->post('toDate');

    $cond='';
    if($locid)
    {
        $cond.=" AND trma_locationid =$locid";
    }
    if($storeid)
    {
        $cond.=" AND trma_fromdepartmentid =$storeid";
    }
   
    if($catid)
    {
         $cond.= " AND il.itli_catid= $catid";
    }
    
    if($cat_id){
         $cond.= " AND il.itli_catid= $cat_id"; 
    }

    if(!empty($mattypeid)){
        $cond.= " AND il.itli_typeid =$mattypeid ";
    }
        // echo INVENTORY_VALUATION;
        // die();

        if(defined('INVENTORY_VALUATION')){
            if(INVENTORY_VALUATION=='FIFO' || INVENTORY_VALUATION=='LIFO' ){
                 $data= $this->db->query('SELECT il.itli_itemname,il.itli_itemnamenp,il.itli_itemcode,ut.unit_unitname,td.trde_itemsid,SUM(td.trde_issueqty) balanceqty,td.trde_unitprice,(sum(td.trde_issueqty)*td.trde_unitprice) balanceamt from xw_trma_transactionmain tm LEFT JOIN xw_trde_transactiondetail td on td.trde_trmaid=tm.trma_trmaid
                  LEFT JOIN xw_itli_itemslist il on il.itli_itemlistid=td.trde_itemsid
                  LEFT JOIN xw_unit_unit ut on ut.unit_unitid=il.itli_unitid
                  LEFT JOIN xw_eqca_equipmentcategory eq ON eq.eqca_equipmentcategoryid = il.itli_catid
                  WHERE tm.trma_received = "1"
                  AND tm.trma_status = "O"
                  AND td.trde_status = "O"
                  AND td.trde_issueqty >0 '.$cond.'  
                  AND td.trde_itemsid IS NOT NULL
                   GROUP BY il.itli_itemname,td.trde_itemsid, td.trde_unitprice
                  ORDER BY eq.eqca_category ASC, itli_itemname ASC')->result();
            }
             if(INVENTORY_VALUATION=='AVERAGE_WEIGHTED'){
                 $data= $this->db->query('SELECT il.itli_itemname,il.itli_itemnamenp,il.itli_itemcode,ut.unit_unitname, td.trde_itemsid,SUM(td.trde_issueqty) balanceqty,SUM(td.trde_issueqty*td.trde_unitprice)/SUM(td.trde_issueqty) trde_unitprice,SUM(td.trde_issueqty)*(SUM(td.trde_issueqty*td.trde_unitprice)/SUM(td.trde_issueqty)) balanceamt from xw_trma_transactionmain tm LEFT JOIN xw_trde_transactiondetail td on td.trde_trmaid=tm.trma_trmaid
                  LEFT JOIN xw_itli_itemslist il on il.itli_itemlistid=td.trde_itemsid
                  LEFT JOIN xw_unit_unit ut on ut.unit_unitid=il.itli_unitid
                  LEFT JOIN xw_eqca_equipmentcategory eq ON eq.eqca_equipmentcategoryid = il.itli_catid
                  WHERE tm.trma_received = "1"
                  AND tm.trma_status = "O"
                  AND td.trde_status = "O"
                  AND td.trde_issueqty >0 '.$cond.'  
                  AND td.trde_itemsid IS NOT NULL
                   GROUP BY il.itli_itemname,td.trde_itemsid
                  ORDER BY eq.eqca_category ASC, itli_itemname ASC')->result();
            }
        }
        else{
              $data= $this->db->query('SELECT il.itli_itemname,il.itli_itemnamenp,il.itli_itemcode,td.trde_itemsid,SUM(td.trde_issueqty)balanceqty,td.trde_unitprice,(sum(td.trde_issueqty)*td.trde_unitprice) balanceamt from xw_trma_transactionmain tm LEFT JOIN xw_trde_transactiondetail td on td.trde_trmaid=tm.trma_trmaid
      LEFT JOIN xw_itli_itemslist il on il.itli_itemlistid=td.trde_itemsid
      LEFT JOIN xw_eqca_equipmentcategory eq ON eq.eqca_equipmentcategoryid = il.itli_catid
      WHERE tm.trma_received = "1"
      AND tm.trma_status = "O"
      AND td.trde_status = "O"
      AND td.trde_issueqty >0 '.$cond.'  
      AND td.trde_itemsid IS NOT NULL
       GROUP BY il.itli_itemname,td.trde_itemsid, td.trde_unitprice
      ORDER BY eq.eqca_category ASC, itli_itemname ASC')->result();
        }

   // echo $this->db->last_query();die;
   return $data;
  
  }

public function get_item_stock_report($cond = false)
    {
        $get = $_GET;
        foreach ($get as $key => $value) 
        {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }
        $cond='';
         // $cond='';

        if(!empty($get['sSearch_1']))
        {
            $cond .=" AND itli_itemcode like  '%".$get['sSearch_1']."%' ";
            // $this->db->where("itli_itemcode like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2']))
        {
           // $this->db->where("itli_itemname like  '%".$get['sSearch_2']."%' OR itli_itemnamenp like  '%".$get['sSearch_2']."%'  ");
             $cond .=" AND itli_itemname like  '%".$get['sSearch_2']."%' OR itli_itemnamenp like  '%".$get['sSearch_2']."%' ";
        }

        if(!empty($get['sSearch_3']))
        {
            // $this->db->where("unit_unitname like  '%".$get['sSearch_3']."%'  ");
               $cond .=" AND unit_unitname like  '%".$get['sSearch_2']."%' ";
        }

        $frmDate = !empty($get['frmDate'])?$get['frmDate']:CURMONTH_DAY1;
        $toDate = !empty($get['toDate'])?$get['toDate']:DISPLAY_DATE;

        // echo $frmDate.''.$toDate;die;

        $store_id = !empty($get['store_id'])?$get['store_id']:1;
        if(!empty( $store_id ))
        {
            $cond_open=" AND tm.trma_fromdepartmentid=$store_id";
            $cond_rec=" AND rm.recm_storeid=$store_id";
            $cond_issue=" AND sama_storeid=$store_id";
        }
        else
        {
            $cond_open='';
            $cond_rec='';
            $cond_issue='';
        }
        
        $material_id = !empty($get['material_id'])?$get['material_id']:$this->input->post('material_id');
          if($material_id){
            $this->db->where('il.itli_materialtypeid',$material_id);
        }
         $sql="
                SELECT * FROM (
                    SELECT
                    itli_itemlistid,
                    itli_itemcode,
                    itli_itemname,
                    itli_itemnamenp,
                    unit_unitname,
                    SUM(opqty) AS opqty,
                    SUM(opamount) AS opamount,
                    SUM(rec_qty) rec_qty,
                    SUM(recamount) recamount,
                    SUM(issQty) issQty,
                    SUM(isstamt) isstamt,
                    SUM(opqty + rec_qty - issQty) balanceqty,
                    SUM(opamount + recamount - isstamt) balanceamt
                    FROM
                    (
                    SELECT
                        il.itli_itemlistid,
                        il.itli_itemcode,
                        il.itli_itemname,
                        il.itli_itemnamenp,
                        un.unit_unitname,
                        SUM(trde_issueqty) AS opqty,
                        trde_unitprice AS oprate,
                        SUM(trde_issueqty) * trde_unitprice AS opamount,
                        0 AS rec_qty,
                        0 AS recrate,
                        0 AS recamount,
                        0 issQty,
                        0 issrate,
                        0 AS isstamt
                    FROM
                        xw_itli_itemslist il
                    LEFT JOIN xw_trde_transactiondetail td ON td.trde_itemsid = il.itli_itemlistid
                    LEFT JOIN xw_trma_transactionmain tm ON tm.trma_trmaid = td.trde_trmaid
                    LEFT JOIN xw_unit_unit un ON un.unit_unitid = il.itli_unitid
                    WHERE
                        trde_issueqty >0
                        AND
                        tm.trma_transactiondatebs <= '".$frmDate."' " .$cond ." ".$cond_open."
                    GROUP BY
                        il.itli_itemlistid,
                        il.itli_itemcode,
                        il.itli_itemname,
                        un.unit_unitname,
                        trde_unitprice
                        UNION
                        SELECT
                    il.itli_itemlistid,
                    il.itli_itemcode,
                    il.itli_itemname,
                    il.itli_itemnamenp,
                    un.unit_unitname,
                    0 AS opqty,
                    0 AS oprate,
                    0 AS opamount,
                    SUM(rd.recd_purchasedqty) AS rec_qty,
                    rd.recd_unitprice AS recrate,
                    SUM(
                        rd.recd_purchasedqty)* rd.recd_unitprice
                    AS recamount,
                    0 issQty,
                    0 issrate,
                    0 AS isstamt
                FROM
                    xw_itli_itemslist il
                LEFT JOIN xw_recd_receiveddetail rd ON rd.recd_itemsid = il.itli_itemlistid
                LEFT JOIN xw_recm_receivedmaster rm ON rm.recm_receivedmasterid = rd.recd_receivedmasterid
                LEFT JOIN xw_unit_unit un ON un.unit_unitid = il.itli_unitid
                WHERE
                rm.recm_receiveddatebs >= '".$frmDate."'
                AND rm.recm_receiveddatebs <= '".$toDate."' ".$cond_rec."
                AND rm.recm_status <> 'M'
                GROUP BY
                    il.itli_itemlistid,
                    il.itli_itemcode,
                    il.itli_itemname,
                    un.unit_unitname,
                    rd.recd_unitprice
                UNION
                SELECT
                il.itli_itemlistid,
                il.itli_itemcode,
                il.itli_itemname,
                il.itli_itemnamenp,
                un.unit_unitname,
                0 AS opqty,
                0 AS oprate,
                0 AS opamount,
                0 AS rec_qty,
                0 AS recrate,
                0 AS recamount,
                SUM(sade_curqty) issQty,
                sade_unitrate issrate,
                SUM(sade_curqty) * sade_unitrate AS isstamt
                FROM
                    xw_itli_itemslist il
                LEFT JOIN xw_sade_saledetail sd ON sd.sade_itemsid = il.itli_itemlistid
                LEFT JOIN xw_sama_salemaster sm ON sm.sama_salemasterid = sd.sade_salemasterid
                LEFT JOIN xw_unit_unit un ON un.unit_unitid = il.itli_unitid
                WHERE
                sm.sama_storeid = 1
                 AND sm.sama_billdatebs >='".$frmDate."'
                AND sm.sama_billdatebs <='".$toDate."' ".$cond_issue."
                AND sm.sama_status = 'O'
                " .$cond ."
                    GROUP BY
                il.itli_itemlistid,
                il.itli_itemcode,
                il.itli_itemname,
                un.unit_unitname,
              sade_unitrate
              ) x
                GROUP BY
                x.itli_itemlistid,
                x.itli_itemcode,
                x.itli_itemname,
                x.unit_unitname
                ) Z WHERE balanceqty>0 ";

                $resltrpt = $this->db->query("SELECT COUNT(*) as cnt from($sql) Y ")->row();
                $totalfilteredrecs=$resltrpt->cnt;  
                $order_by = 'itli_itemname';
                $order = 'asc';
                if($this->input->get('sSortDir_0'))
                {
                        $order = $this->input->get('sSortDir_0');
                }
                $where='';
                if($this->input->get('iSortCol_0')==1)
                    $order_by = 'itli_itemcode';
                else if($this->input->get('iSortCol_0')==2)
                    $order_by = 'itli_itemname';
                else if($this->input->get('iSortCol_0')==3)
                    $order_by = 'unit_unitname';
                else if($this->input->get('iSortCol_0')==4)
                    $order_by = 'trde_issueqty';
                $totalrecs='';
                $limit = 15;
                $offset = 1;
                $get = $_GET;
            
                foreach ($get as $key => $value) {
                    $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
                }
      
                if(!empty($_GET["iDisplayLength"])){
                   $limit = $_GET['iDisplayLength'];
                   $offset = $_GET["iDisplayStart"];
                }

                if(!empty($get['sSearch_1'])){
                    $this->db->where("itli_itemcode like  '%".$get['sSearch_1']."%'  ");
                }

                if(!empty($get['sSearch_2'])){
                    $this->db->where("itli_itemname like  '%".$get['sSearch_2']."%' OR itli_itemnamenp like  '%".$get['sSearch_2']."%'  ");
                }

                if(!empty($get['sSearch_3'])){
                    $this->db->where("unit_unitname like  '%".$get['sSearch_3']."%'  ");
                }  
            if($cond) {
              $this->db->where($cond);
            }
            if($material_id){
            $this->db->where('il.itli_materialtypeid',$material_id);
        }
        $sql="
        SELECT * FROM (
                    SELECT
                    itli_itemlistid,
                    itli_itemcode,
                    itli_itemname,
                    itli_itemnamenp,
                    unit_unitname,
                    SUM(opqty) AS opqty,
                    SUM(opamount) AS opamount,
                    SUM(rec_qty) rec_qty,
                    SUM(recamount) recamount,
                    SUM(issQty) issQty,
                    SUM(isstamt) isstamt,
                    SUM(opqty + rec_qty - issQty) balanceqty,
                    SUM(opamount + recamount - isstamt) balanceamt
                    FROM
                    (
                    SELECT
                        il.itli_itemlistid,
                        il.itli_itemcode,
                        il.itli_itemname,
                        il.itli_itemnamenp,
                        un.unit_unitname,
                        SUM(trde_issueqty) AS opqty,
                        trde_unitprice AS oprate,
                        SUM(trde_issueqty) * trde_unitprice AS opamount,
                        0 AS rec_qty,
                        0 AS recrate,
                        0 AS recamount,
                        0 issQty,
                        0 issrate,
                        0 AS isstamt
                    FROM
                        xw_itli_itemslist il
                    LEFT JOIN xw_trde_transactiondetail td ON td.trde_itemsid = il.itli_itemlistid
                    LEFT JOIN xw_trma_transactionmain tm ON tm.trma_trmaid = td.trde_trmaid
                    LEFT JOIN xw_unit_unit un ON un.unit_unitid = il.itli_unitid
                    WHERE

                        tm.trma_transactiondatebs <= '".$frmDate."' " .$cond ." ".$cond_open."
                            AND trde_issueqty >0
                    GROUP BY
                        il.itli_itemlistid,
                        il.itli_itemcode,
                        il.itli_itemname,
                        un.unit_unitname,
                        trde_unitprice
                        UNION
                        SELECT
                    il.itli_itemlistid,
                    il.itli_itemcode,
                    il.itli_itemname,
                    il.itli_itemnamenp,
                    un.unit_unitname,
                    0 AS opqty,
                    0 AS oprate,
                    0 AS opamount,
                    SUM(rd.recd_purchasedqty) AS rec_qty,
                    rd.recd_unitprice AS recrate,
                    SUM(
                        rd.recd_purchasedqty)* rd.recd_unitprice
                    AS recamount,
                    0 issQty,
                    0 issrate,
                    0 AS isstamt
                FROM
                    xw_itli_itemslist il
                LEFT JOIN xw_recd_receiveddetail rd ON rd.recd_itemsid = il.itli_itemlistid
                LEFT JOIN xw_recm_receivedmaster rm ON rm.recm_receivedmasterid = rd.recd_receivedmasterid
                LEFT JOIN xw_unit_unit un ON un.unit_unitid = il.itli_unitid
                WHERE
                rm.recm_receiveddatebs >= '".$frmDate."'
                AND rm.recm_receiveddatebs <= '".$toDate."' ".$cond_rec."
                AND rm.recm_status <> 'M'
                GROUP BY
                    il.itli_itemlistid,
                    il.itli_itemcode,
                    il.itli_itemname,
                    un.unit_unitname,
                    rd.recd_unitprice
                UNION
                SELECT
                il.itli_itemlistid,
                il.itli_itemcode,
                il.itli_itemname,
                il.itli_itemnamenp,
                un.unit_unitname,
                0 AS opqty,
                0 AS oprate,
                0 AS opamount,
                0 AS rec_qty,
                0 AS recrate,
                0 AS recamount,
                SUM(sade_curqty) issQty,
                sade_unitrate issrate,
                SUM(sade_curqty) * sade_unitrate AS isstamt
                FROM
                    xw_itli_itemslist il
                LEFT JOIN xw_sade_saledetail sd ON sd.sade_itemsid = il.itli_itemlistid
                LEFT JOIN xw_sama_salemaster sm ON sm.sama_salemasterid = sd.sade_salemasterid
                LEFT JOIN xw_unit_unit un ON un.unit_unitid = il.itli_unitid
                WHERE
                sm.sama_storeid = 1
                 AND sm.sama_billdatebs >='".$frmDate."'
                AND sm.sama_billdatebs <='".$toDate."' ".$cond_issue."
                AND sm.sama_status = 'O'
                " .$cond ."
                    GROUP BY
                il.itli_itemlistid,
                il.itli_itemcode,
                il.itli_itemname,
                un.unit_unitname,
              sade_unitrate
              ) x
                GROUP BY
                x.itli_itemlistid,
                x.itli_itemcode,
                x.itli_itemname,
                x.unit_unitname
                ) Z WHERE balanceqty>0" .$cond ."
                ORDER BY itli_itemname ASC limit ".$limit." offset ".$offset." ";

        $query=$this->db->query($sql);
        // echo $this->db->last_query();
        // die();
                    
        if($limit && $limit>0)
        {  
            $this->db->limit($limit);
        }
        if($offset)
        {
            $this->db->offset($offset);
        }
      
        $nquery=$query;

        $num_row=$nquery->num_rows();
        if (!empty($_GET['iDisplayLength']) &&  !empty($nquery) && is_array($nquery) && count($nquery) > 0 ) {
            $totalrecs = sizeof($nquery);
        }

       if($num_row>0){
          $ndata=$nquery->result();
          $ndata['totalrecs'] = $totalrecs;
          $ndata['totalfilteredrecs'] = $totalfilteredrecs;
        } 
        else
        {
            $ndata=array();
            $ndata['totalrecs'] = 0;
            $ndata['totalfilteredrecs'] = 0;
        }
        // echo $this->db->last_query();die();
       return $ndata;
    }

    public function stock_generate_by_date($type = false,$category_id = false)
    {

    $locid=$this->input->post('locationid');
    $mattypeid=$this->input->post('mattypeid');
    $storeid=$this->input->post('store_id');
    $catid=$this->input->post('catid');
    $itemid=$this->input->post('itemid');
    $searchtype=$this->input->post('searchDateType');
    $fromdate = $this->input->post('frmDate');
    $todate = $this->input->post('toDate');
    $auction_disposal_data = '';
    if($searchtype=='date_range' && $fromdate && $todate){
        if(DEFAULT_DATEPICKER=='NP' && ORGANIZATION_NAME == 'NPHL'){
          $auction_disposal_data .= " ,fn_auction_disposal_item(itemid,'".$fromdate."','".$todate."') as auction_disposal_data";
        }
    }

    if($type == 'generate_table'){

    if(!$this->db->table_exists('xw_temp_stockrec')){
      $create_stockrecord_table = "CREATE TABLE xw_temp_stockrec  (
      id BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      date VARCHAR(15),
      itemid BIGINT(15),
      qty DECIMAL(15,2),
      rate DECIMAL(15,2),
      total_amt DECIMAL(15,2),
      type VARCHAR(15),
      locationid INT(15),
      orgid INT(15)
      )";
      $this->db->query($create_stockrecord_table);      
    }
    $this->db->query("TRUNCATE TABLE xw_temp_stockrec");

    $condiss1 ='';
    $condiss2 ='';
    $condrec ='';
    $conditem='';
    $cond_trde='';
   
    if($searchtype=='date_range'){
      if($fromdate && $todate){
        if(DEFAULT_DATEPICKER=='NP'){
          $condiss1 .= " AND sm.sama_billdatebs < '".$fromdate."' ";
          $condiss2 .= " AND sm.sama_billdatebs >='".$fromdate."' AND sm.sama_billdatebs<='".$todate."' ";
          $condrec .=" AND tm.trma_transactiondatebs >='".$fromdate."' AND tm.trma_transactiondatebs <='".$todate."' ";
        }  
      }
      
    }

    if($storeid){
      $condiss1 .= " AND sm.sama_storeid =$storeid ";
      $condiss2 .= " AND sm.sama_storeid =$storeid ";
      $condrec .= " AND  tm.trma_fromdepartmentid =$storeid ";
    }

    // if (ORGANIZATION_NAME != 'NPHL') {
        if($mattypeid){
           $condiss1 .= ' AND itli_materialtypeid ='.$mattypeid.'';
            $condiss2 .= ' AND itli_materialtypeid ='.$mattypeid.'';
            $condrec .= ' AND itli_materialtypeid ='.$mattypeid.'';
            $cond_trde .= ' AND itli_materialtypeid ='.$mattypeid.'';
        }    
    // }

    if(!empty($locid)){
      
      $condiss1 .= ' AND sm.sama_locationid ='.$locid.'';
      $condiss1 .= ' AND sd.sade_locationid ='.$locid.'';

      $condiss2 .= ' AND sm.sama_locationid ='.$locid.'';
      $condiss2 .= ' AND sd.sade_locationid ='.$locid.'';
      $condrec .= ' AND tm.trma_locationid ='.$locid.'';
      $condrec .= ' AND td.trde_locationid ='.$locid.'';
      $cond_trde .= ' AND tm.trma_locationid ='.$locid.'';
      $cond_trde .= ' AND td.trde_locationid ='.$locid.'';
    }

    if(!empty($itemid)){
        $condiss1 .= ' AND itli_itemlistid ='.$itemid.'';
        $condiss2 .= ' AND itli_itemlistid ='.$itemid.'';
        $condrec .= ' AND itli_itemlistid ='.$itemid.'';
        $conditem .=' AND itli_itemlistid ='.$itemid.'';
        $cond_trde .= ' AND itli_itemlistid ='.$itemid.'';
    }

    if(!empty($catid)){
        $condiss1 .= ' AND itli_catid ='.$catid.'';
        $condiss2 .= ' AND itli_catid ='.$catid.'';
        $condrec .= ' AND itli_catid ='.$catid.'';
    }

     if(empty($locid)){
      $locid="''";
    }

    $sql_opening="SELECT
  itemid,
  SUM(pqty)- SUM(iqty) AS qty,
  SUM(ptotal_amt-itotal_amt)/SUM(pqty-iqty) rate,
  SUM(ptotal_amt-itotal_amt) total_amt,
  'OPENING' as type,
  $locid as locationid
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
    INNER JOIN xw_itli_itemslist il ON il.itli_itemlistid = td.trde_itemsid
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
        SUM(sd.sade_curqty * sd.sade_unitrate) itotal_amt
        FROM
        xw_sama_salemaster sm
      INNER JOIN xw_sade_saledetail sd ON sd.sade_salemasterid = sm.sama_salemasterid
      INNER JOIN xw_itli_itemslist il ON il.itli_itemlistid = sd.sade_itemsid
      WHERE
        sm.sama_status = 'O'
        AND sm.sama_st != 'C'
       $condiss1
      GROUP BY
        sd.sade_itemsid
  ) X 
GROUP BY
  X.itemid HAVING SUM(pqty)>SUM(iqty)";

       // echo $sql_opening;
       // die();

      $result_open=$this->db->query($sql_opening)->result();
      // echo "<pre>";
      // print_r( $result_open);
      // die();

      if(!empty($result_open)){
        $this->db->insert_batch('temp_stockrec',$result_open);
      }

      $sql_purchase="SELECT
            td.trde_itemsid as itemid,
            SUM(td.trde_requiredqty) AS qty,
            td.trde_unitprice AS rate,
            SUM(td.trde_requiredqty * td.trde_unitprice) AS total_amt,
           'PURCHASE' as type,
           $locid as locationid
          FROM xw_trde_transactiondetail td
          LEFT JOIN  xw_itli_itemslist il  ON td.trde_itemsid = il.itli_itemlistid
          LEFT JOIN xw_trma_transactionmain tm ON tm.trma_trmaid = td.trde_trmaid
          WHERE
          tm.trma_status = 'O'
          AND td.trde_status='O'
          AND tm.trma_received='1'
          $condrec 
          GROUP BY
            td.trde_itemsid " ;

            // echo $sql_purchase;
            // die();

    $result_purchase=$this->db->query($sql_purchase)->result();

    if(!empty($result_purchase)){
      $this->db->insert_batch('temp_stockrec',$result_purchase);
    }

    $sql_issue=" SELECT
                sd.sade_itemsid as itemid,
                SUM(sade_curqty) qty,
                sade_unitrate rate,
                SUM(sade_curqty * sade_unitrate) AS total_amt,
                'ISSUE' as type,
                $locid as locationid
                FROM
                xw_sade_saledetail sd  
                LEFT JOIN xw_itli_itemslist il  ON sd.sade_itemsid = il.itli_itemlistid
                LEFT JOIN xw_sama_salemaster sm ON sm.sama_salemasterid = sd.sade_salemasterid
                WHERE
                 sm.sama_status = 'O'
                 AND sm.sama_st != 'C'
                $condiss2
                    GROUP BY
                sd.sade_itemsid";

            // echo $sql_issue;
            // die();

            $result_issue=$this->db->query($sql_issue)->result();
        
        // echo "<pre>";
        // print_r( $result_issue);
        // die();
      if(!empty($result_issue)){
        $this->db->insert_batch('temp_stockrec',$result_issue);
      }  

      return true;    
    }

    if($type == 'get_stock_data'){
      $category_condition = '';
     if(!empty($category_id)){
      $category_condition = " WHERE itli_catid = $category_id ";
     }
    $sql_final="SELECT itemid,il.itli_itemcode,il.itli_itemname, ut.unit_unitname,mt.maty_material,ec.eqca_category,
                SUM(opqty) as opqty,SUM(opamt)/SUM(opqty) as oprate,SUM(opamt) opamt,
                SUM(purqty) as purqty,SUM(puramt)/SUM(purqty) as purrate,SUM(puramt) puramt ,
                SUM(issqty) as issqty,SUM(issamt)/SUM(issqty) as issrate,SUM(issamt) issamt,
                SUM( (opqty + purqty) - issqty) balanceqty,
                SUM( (opamt + puramt) - issamt) balanceamt,
                SUM( (opamt + puramt) - issamt)/SUM( (opqty + purqty) - issqty) as trde_unitprice
                $auction_disposal_data
                  FROM (
                SELECT itemid,
                SUM(qty) as opqty,SUM(total_amt)/SUM(qty) as oprate,SUM(total_amt) opamt,
                0 as purqty,0 as purrate,0 as puramt,
                0 as issqty,0 as issrate,0 as issamt 
                FROM xw_temp_stockrec
                WHERE type='OPENING'
                GROUP BY itemid 
                UNION
                SELECT itemid,
                0 as opqty,0 as oprate,0 as opamt,  
                SUM(qty) as purqty,SUM(total_amt)/SUM(qty) as purrate,SUM(total_amt) puramt ,
                0 as issqty,0 as issrate,0 as issamt 
                FROM xw_temp_stockrec
                WHERE type='PURCHASE'
                GROUP BY itemid 
                UNION
                SELECT itemid,
                0 as opqty,0 as oprate,0 as opamt,  
                0 as purqty,0 as purrate,0 as puramt,
                SUM(qty) as issqty,SUM(total_amt)/SUM(qty) as issrate,SUM(total_amt) issamt 
                FROM xw_temp_stockrec
                WHERE type='ISSUE'
                GROUP BY itemid 
                ) X LEFT JOIN xw_itli_itemslist il on il.itli_itemlistid=X.itemid LEFT JOIN xw_unit_unit ut on ut.unit_unitid=il.itli_unitid
                LEFT JOIN xw_maty_materialtype mt on mt.maty_materialtypeid = il.itli_materialtypeid 
                LEFT JOIN xw_eqca_equipmentcategory ec on ec.eqca_equipmentcategoryid = il.itli_catid 
                $category_condition
                GROUP BY X.itemid
                ORDER BY il.itli_itemcode ASC";
        $result_final=$this->db->query($sql_final)->result();

        // echo $this->db->last_query();
        // echo "<pre>";
        // die();
        // print_r ($result_final);
        // echo "</pre>";
        // die;
        if(!empty($result_final)){
          return $result_final;
        }
    }
    return false;

    }

}