 // $sql_opening="SELECT
    //       sade_itemsid itemid,
    //       sum(rem) AS qty,
    //       unitrate / sum(rem) AS rate,
    //       unitrate total_amt,
    //       'OPENING' as type,
    //       $locid as locationid
    //     FROM (SELECT
    //           sade_itemsid,
    //           SUM(sade_curqty) sade_curqty,
    //           (td.trde_requiredqty) req,
    //           td.trde_requiredqty - SUM(sade_curqty) rem,
    //           td.trde_unitprice * (
    //             td.trde_requiredqty - SUM(sade_curqty)
    //           ) unitrate
    //         FROM
    //           xw_sama_salemaster sm
    //         INNER JOIN xw_sade_saledetail sd ON sd.sade_salemasterid = sm.sama_salemasterid
    //         INNER JOIN xw_trde_transactiondetail td ON td.trde_trdeid = sd.sade_mattransdetailid
    //         INNER JOIN  xw_trma_transactionmain tm ON tm.trma_trmaid=td.trde_trmaid
    //         LEFT JOIN xw_itli_itemslist il on il.itli_itemlistid=td.trde_itemsid
    //         WHERE
    //         sm.sama_status = 'O'
    //         AND tm.trma_status = 'O'
    //         AND td.trde_status='O'
    //          $condiss1
    //         GROUP BY
    //           sade_itemsid,
    //           sade_mattransdetailid
    //           UNION
    //         SELECT
    //           td.trde_itemsid sade_itemsid,
    //           SUM(trde_issueqty) sade_curqty,
    //           SUM(td.trde_requiredqty) req,
    //           SUM(td.trde_issueqty) rem,
    //           td.trde_unitprice * (
    //             SUM(td.trde_requiredqty) 
    //           ) unitrate
    //         FROM
    //           xw_trma_transactionmain tm
    //         LEFT JOIN xw_trde_transactiondetail td ON td.trde_trmaid = tm.trma_trmaid
    //         LEFT JOIN xw_itli_itemslist il on il.itli_itemlistid=td.trde_itemsid
    //         WHERE
    //           tm.trma_status = 'O'
    //           AND td.trde_status='O'
    //           AND tm.trma_received='1'
    //         AND tm.trma_transactiondatebs < '".$fromdate."' 
    //         $conditem
    //         AND td.trde_requiredqty=td.trde_issueqty
    //         GROUP BY
    //           trde_itemsid  
    //       ) X
    //     LEFT JOIN xw_itli_itemslist il ON il.itli_itemlistid = X.sade_itemsid
    //     LEFT JOIN xw_unit_unit un ON un.unit_unitid = il.itli_unitid
    //     GROUP BY
    //       sade_itemsid
    //     HAVING
    //       sum(rem) > 0
    //    ";

    // $sql_opening="SELECT itemid,SUM(pqty-iqty) as qty,SUM(ptotal_amt-itotal_amt)/SUM(pqty-iqty) rate,SUM(ptotal_amt-itotal_amt) as total_amt,
    //           'OPENING' as type,
    //            $locid as locationid
    //            FROM (
    //           SELECT trde_itemsid itemid,
    //           SUM(trde_requiredqty) pqty,
    //           SUM(trde_requiredqty)*trde_unitprice/SUM(trde_requiredqty) as prate,
    //           SUM(trde_requiredqty)*trde_unitprice as ptotal_amt,
    //           0 as iqty,0 as irate,0 as itotal_amt
    //            from xw_trma_transactionmain tm 
    //           INNER JOIN xw_trde_transactiondetail td on td.trde_trmaid=tm.trma_trmaid
    //           INNER JOIN xw_itli_itemslist il on il.itli_itemlistid=td.trde_itemsid
    //           WHERE 
    //            td.trde_status='O' AND tm.trma_status='O'
    //           AND tm.trma_received='1'
    //           AND tm.trma_transactiondatebs < '".$fromdate."' 
    //           $cond_trde
    //           GROUP BY trde_itemsid
    //           UNION
    //           SELECT sd.sade_itemsid itemid,
    //           0 as pqty,
    //           0 as prate,
    //           0 as ptotal_amt,
    //           SUM(sd.sade_curqty) iqty,
    //           SUM(sd.sade_curqty) *sd.sade_unitrate/SUM(sd.sade_curqty) irate,
    //           SUM(sd.sade_curqty) *sd.sade_unitrate  itotal_amt
    //            from xw_sama_salemaster sm 
    //           INNER JOIN  xw_sade_saledetail sd
    //           ON sd.sade_salemasterid=sm.sama_salemasterid
    //           INNER JOIN xw_itli_itemslist il on il.itli_itemlistid=sd.sade_itemsid
    //           WHERE  sm.sama_status = 'O'
    //           AND 
    //           $condiss1
    //           GROUP BY sd.sade_itemsid
    //           ) X GROUP BY itemid HAVING SUM(pqty-iqty) >0";

     // $locid=$this->input->post('locationid');
    // $mattypeid=$this->input->post('mattypeid');
    // $searchtype=$this->input->post('searchDateType');
    // $rpt_type=$this->input->post('rpt_type');
    // $storeid=$this->input->post('store_id');
    // $catid=$this->input->post('catid');
    // $fromdate = $this->input->post('frmDate');
    // $todate = $this->input->post('toDate');
    // $categoryid = $this->input->post('categoryid');

    // $condiss1 ='';
    // $condiss2 ='';
    // $condrec ='';
    // $category_cond = '';
    // if($searchtype=='date_range'){
    //   if($fromdate && $todate){
    //     if(DEFAULT_DATEPICKER=='NP'){
    //       $condiss1 .= " AND sm.sama_billdatebs < '".$fromdate."' ";
    //       $condiss2 .= " AND sm.sama_billdatebs >='".$fromdate."' AND sm.sama_billdatebs<='".$todate."' ";
    //       $condrec .=" AND tm.trma_transactiondatebs >='".$fromdate."' AND tm.trma_transactiondatebs <='".$todate."' ";
    //     }  
    //   }
      
    // }

    // if($storeid){
    //   $condiss1 .= " AND sm.sama_storeid =$storeid ";
    //   $condiss2 .= " AND sm.sama_storeid =$storeid ";
    //   $condrec .= " AND  tm.trma_fromdepartmentid =$storeid ";
    // }

    // if($mattypeid){
    //    $condiss1 .= ' AND itli_materialtypeid ='.$mattypeid.'';
    //     $condiss2 .= ' AND itli_materialtypeid ='.$mattypeid.'';
    //     $condrec .= ' AND itli_materialtypeid ='.$mattypeid.'';
    // }

    // if($categoryid){
    //     $condiss1 .= ' AND itli_catid ='.$categoryid.'';
    //     $condiss2 .= ' AND itli_catid ='.$categoryid.'';
    //     $condrec .= ' AND itli_catid ='.$categoryid.'';
    //     $category_cond = " AND itli_catid = $categoryid";
    // }

    // if(!empty($locid)){
    //    $condiss1 .= ' AND sm.sama_locationid ='.$locid.'';
    //   $condiss2 .= ' AND sm.sama_locationid ='.$locid.'';
    //   $condrec .= ' AND tm.trma_locationid ='.$locid.'';
    // }

    // if(!empty($viewcat_id)){
    //   $cond_cat =" AND itli_catid =$viewcat_id ";
    // }else{
    //   $cond_cat= "";
    // }

//     $sql="SELECT *
//     FROM (
//     SELECT
//       itli_itemlistid,
//       itli_itemcode,
//       itli_itemname,
//       itli_itemnamenp,
//       itli_catid,
//       unit_unitname,
//       SUM(opqty) AS opqty,
//       SUM(opamount) AS opamount,
//       SUM(rec_qty) rec_qty,
//       SUM(recamount) recamount,
//       SUM(issqty) issqty,
//       SUM(isstamt) isstamt,
//       SUM(opqty + rec_qty - issqty) balanceqty,
//       SUM(opamount + recamount - isstamt) balanceamt
//     FROM
//       (
//         SELECT
//           sade_itemsid itli_itemlistid,
//           il.itli_itemcode,
//           il.itli_itemname,
//           il.itli_itemnamenp,
//           il.itli_catid,
//           un.unit_unitname,
//           sum(rem) AS opqty,
//           unitrate / sum(rem) AS oprate,
//           unitrate opamount,
//           0 AS rec_qty,
//           0 AS recrate,
//           0 AS recamount,
//           0 issqty,
//           0 issrate,
//           0 AS isstamt
//         FROM
//           (
//             SELECT
//               sade_itemsid,
//               SUM(sade_curqty) sade_curqty,
//               (td.trde_requiredqty) req,
//               td.trde_requiredqty - SUM(sade_curqty) rem,
//               td.trde_unitprice * (
//                 td.trde_requiredqty - SUM(sade_curqty)
//               ) unitrate
//             FROM
//               xw_sama_salemaster sm
//             INNER JOIN xw_sade_saledetail sd ON sd.sade_salemasterid = sm.sama_salemasterid
//             INNER JOIN xw_trde_transactiondetail td ON td.trde_trdeid = sd.sade_mattransdetailid
//             LEFT JOIN xw_itli_itemslist il on il.itli_itemlistid=td.trde_itemsid
//             WHERE
//             sm.sama_status = 'O'
//              $condiss1
//             GROUP BY
//               sade_itemsid,
//               sade_mattransdetailid

//               UNION
//             SELECT
//               td.trde_itemsid sade_itemsid,
//               SUM(trde_issueqty) sade_curqty,
//               SUM(td.trde_requiredqty) req,
//               SUM(td.trde_issueqty) rem,
//               td.trde_unitprice * (
//                 SUM(td.trde_requiredqty) 
//               ) unitrate
//             FROM
//               xw_trma_transactionmain tm
//             LEFT JOIN xw_trde_transactiondetail td ON td.trde_trmaid = tm.trma_trmaid
//             LEFT JOIN xw_itli_itemslist il on il.itli_itemlistid=td.trde_itemsid
//             WHERE
//               tm.trma_status = 'O'
//               AND td.trde_status='O'
//               AND tm.trma_received='1'
//               $category_cond
//             AND tm.trma_transactiondatebs < '".$fromdate."' 
//             AND td.trde_requiredqty=td.trde_issueqty
//             GROUP BY
//               trde_itemsid  
//           ) X
//         LEFT JOIN xw_itli_itemslist il ON il.itli_itemlistid = X.sade_itemsid
//         LEFT JOIN xw_unit_unit un ON un.unit_unitid = il.itli_unitid
//         GROUP BY
//           sade_itemsid
//         HAVING
//           sum(rem) > 0
//         UNION
//           SELECT
//             il.itli_itemlistid,
//             il.itli_itemcode,
//             il.itli_itemname,
//             il.itli_itemnamenp,
//             il.itli_catid,
//             un.unit_unitname,
//             0 AS opqty,
//             0 AS oprate,
//             0 AS opamount,
//             SUM(td.trde_requiredqty) AS rec_qty,
//             td.trde_unitprice AS recrate,
//             SUM(td.trde_requiredqty) * td.trde_unitprice AS recamount,
//             0 issqty,
//             0 issrate,
//             0 AS isstamt
//           FROM
//             xw_itli_itemslist il
//           LEFT JOIN xw_trde_transactiondetail td ON td.trde_itemsid = il.itli_itemlistid
//           LEFT JOIN xw_trma_transactionmain tm ON tm.trma_trmaid = td.trde_trmaid
//           LEFT JOIN xw_unit_unit un ON un.unit_unitid = il.itli_unitid
//           WHERE
//           tm.trma_status = 'O'
//           $condrec 
//           GROUP BY
//             il.itli_itemlistid,
//             il.itli_itemcode,
//             il.itli_itemname,
//             un.unit_unitname,
//             td.trde_unitprice
//           UNION
//             SELECT
//               il.itli_itemlistid,
//               il.itli_itemcode,
//               il.itli_itemname,
//               il.itli_itemnamenp,
//               il.itli_catid,
//               un.unit_unitname,
//               0 AS opqty,
//               0 AS oprate,
//               0 AS opamount,
//               0 AS rec_qty,
//               0 AS recrate,
//               0 AS recamount,
//               SUM(sade_curqty) issqty,
//               sade_unitrate issrate,
//               SUM(sade_curqty) * sade_unitrate AS isstamt
//             FROM
//               xw_itli_itemslist il
//             LEFT JOIN xw_sade_saledetail sd ON sd.sade_itemsid = il.itli_itemlistid
//             LEFT JOIN xw_sama_salemaster sm ON sm.sama_salemasterid = sd.sade_salemasterid
//             LEFT JOIN xw_unit_unit un ON un.unit_unitid = il.itli_unitid
//             WHERE
//             sm.sama_status = 'O'
//             $condiss2
//             GROUP BY
//               il.itli_itemlistid,
//               il.itli_itemcode,
//               il.itli_itemname,
//               un.unit_unitname,
//               sade_unitrate
//       ) x
//     GROUP BY
//       x.itli_itemlistid,
//       x.itli_itemcode,
//       x.itli_itemname,
//       x.unit_unitname
//   ) Z
// WHERE
//   balanceqty > 0 $cond_cat
// ORDER BY
//   itli_itemname ASC";

//   if($rpt_type=='stock_range' && empty($viewcall)){
//     $sql="SELECT DISTINCT(itli_catid) catid,
// ec.eqca_category FROM ($sql) A LEFT JOIN xw_eqca_equipmentcategory ec on ec.eqca_equipmentcategoryid=A.itli_catid ORDER BY ec.eqca_category ASC ";
//     // echo $sql;
//     // die();
//   }

//   $result=$this->db->query($sql)->result();
//   // echo $this->db->last_query();
//   return $result;