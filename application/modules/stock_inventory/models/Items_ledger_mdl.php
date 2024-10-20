<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Items_ledger_mdl extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->locationid=$this->session->userdata(LOCATION_ID);
         $this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
    }

    public $validate_items_ledger = array(
        array('field' => 'itemid', 'label' => 'Item', 'rules' => 'trim|required|xss_clean')
    );

    public $validate_items_ledger_typei = array(
        array('field' => 'fiscalyrs', 'label' => 'Item', 'rules' => 'trim|required|xss_clean')
    );

    public function get_items_ledger_data($cond=false)
    {
        $get = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }

        if(!empty($get['sSearch_1'])){
            $whr .=" AND  itli_itemcode like  '%".$get['sSearch_1']."%' "; 
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("itli_itemcode like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("eqty_equipmenttype like  '%".$get['sSearch_2']."%'  ");
        }

        if(!empty($get['sSearch_3'])){
            $this->db->where("itli_itemname like  '%".$get['sSearch_3']."%'  ");
        }

        if($cond) {
            $this->db->where($cond);
        }

        $fromdate = !empty($get['fromdate'])?$get['fromdate']:$this->input->post('fromdate');
        $todate = !empty($get['todate'])?$get['todate']:$this->input->post('todate');

        $itemid = !empty($get['itemid'])?$get['itemid']:$this->input->post('itemid');
        $storeid = !empty($get['store_id'])?$get['store_id']:$this->input->post('store_id');
        $locationid = !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');

        $where_sama_storeid = $where_trma_storeid = $where_recm_storeid = $where_purr_storeid = $where_conv_storeid = $where_stma_storeid = $where_rema_storeid = "";

        $where_sama_locationid = $where_trma_locationid = $where_recm_locationid = $where_purr_locationid  = $where_stma_locationid = $where_conv_locationid = $where_rema_locationid = "";

        if($storeid){
            $where_sama_storeid = "AND sm.sama_storeid = '$storeid'";
            $where_trma_storeid = "AND tm.trma_fromdepartmentid = '$storeid'";
            $where_recm_storeid = "AND (rm.recm_storeid = '$storeid' OR rm.recm_departmentid = '$storeid')";
            $where_purr_storeid = "AND (pr.purr_storeid = '$storeid' OR pr.purr_departmentid = '$storeid')";
            $where_conv_storeid = "AND c.conv_departmentid = '$storeid'";
            $where_rema_storeid = "AND rema.rema_storeid = '$storeid'";
        }

        if($this->location_ismain=='Y'){

        if($locationid){
            $where_sama_locationid  = "AND sm.sama_locationid = '$locationid'";
            $where_trma_locationid  = "AND tm.trma_locationid = '$locationid'";
            $where_recm_locationid  = "AND rm.recm_locationid = '$locationid'";
            $where_purr_locationid  = "AND pr.purr_locationid = '$locationid'";
            $where_stma_locationid  = "AND stma.stma_locationid = '$locationid'";
            $where_conv_locationid  = "AND c.conv_locationid = '$locationid'";
            $where_rema_locationid  = "AND rema.rema_locationid = '$locationid'";
        }}else{
            $where_sama_locationid  = "AND sm.sama_locationid = '$this->locationid'";
            $where_trma_locationid  = "AND tm.trma_locationid = '$this->locationid'";
            $where_recm_locationid  = "AND rm.recm_locationid = '$this->locationid'";
            $where_purr_locationid  = "AND pr.purr_locationid = '$this->locationid'";
            $where_stma_locationid  = "AND stma.stma_locationid = '$this->locationid'";
            $where_conv_locationid  = "AND c.conv_locationid = '$this->locationid'";
            $where_rema_locationid  = "AND rema.rema_locationid = '$this->locationid'";  
        }

        $resltrpt = "SELECT * from (
        SELECT '-' as datesad,'-' as dates, 'Opening' as description,'-' as refno, '-' as Depname,   SUM(rec_purqty) rec_purqty, 0 rec_rate, 0 as rec_amt, SUM(issueQty) issueQty , 0 iss_rate, 0 issuAmt  FROM(
        select sm.sama_billdatead datesad, sm.sama_billdatebs dates, sm.sama_invoiceno description, sm.sama_requisitionno refno, sm.sama_depname Depname, 0 rec_purqty, sade_unitrate rec_rate, 0 as rec_amt, sd.sade_qty issueQty, sd.sade_unitrate iss_rate, sd.sade_qty * sd.sade_unitrate issuAmt 
        from xw_sama_salemaster sm  
        left join xw_sade_saledetail sd on sm.sama_salemasterid = sd.sade_salemasterid 
        where sm.sama_st = 'N' and sd.sade_itemsid = '$itemid' and sm.sama_billdatebs < '$fromdate'  $where_sama_storeid $where_sama_locationid
        UNION ALL
        select tm.trma_transactiondatead datesad, tm.trma_transactiondatebs dates,'OPENING' AS description, 'In-Date' refno, '' as Depname, td.trde_requiredqty rec_purqty, td.trde_unitprice rec_rate, td.trde_requiredqty * td.trde_unitprice as rec_amt, 0 issueQty, 0 iss_rate, 0 issuAmt 
        from xw_trma_transactionmain tm
        left join xw_trde_transactiondetail td on tm.trma_trmaid = td.trde_trmaid
        where td.trde_transactiontype = 'OPENING' and td.trde_itemsid = '$itemid' and tm.trma_transactiondatebs < '$fromdate'  $where_trma_storeid $where_trma_locationid
        UNION ALL
        select cm.chma_challanrecdatead datesad, cm.chma_challanrecdatebs dates, concat('Challan-',chma_challannumber) description, chma_challannumber refno, dist_distributor as Depname, cd.chde_qty rec_purqty, 0 rec_rate, 0 as rec_amt, 0 issueQty, 0 iss_rate, 0 issuAmt
        from xw_chma_challanmaster cm 
        left join xw_chde_challandetails cd on cm.chma_challanmasterid = cd.chde_challanmasterid
        left join xw_dist_distributors dist on cm.chma_supplierid = dist.dist_distributorid 
        left join xw_trma_transactionmain tm on tm.trma_trmaid = cm.chma_mattransmasterid 
        where cd.chde_itemsid = '$itemid' and cm.chma_challanrecdatebs < '$fromdate'  and chde_receivecomplete = 'N' $where_trma_storeid $where_trma_locationid
        UNION ALL
        select rm.recm_receiveddatead datesad, rm.recm_receiveddatebs dates, 
        concat(recm_invoiceno,'-','O.Date:',pm.puor_orderdatebs) description, rm.recm_supplierbillno as refno, dist.dist_distributor Depname, rd.recd_purchasedqty rec_purqty, rd.recd_salerate rec_rate, rd.recd_purchasedqty * recd_salerate rec_amt, 0 issueQty, 0 iss_rate, 0 issuAmt 
        from xw_recm_receivedmaster rm 
        left join xw_recd_receiveddetail rd on rd.recd_receivedmasterid = rm.recm_receivedmasterid 
        left join xw_puor_purchaseordermaster pm on pm.puor_purchaseordermasterid = rm.recm_purchaseordermasterid 
        left join xw_dist_distributors dist on dist_distributorid = rm.recm_supplierid 
        where rd.recd_itemsid = '$itemid' and rm.recm_receiveddatebs < '$fromdate'  and rm.recm_status <> 'M' $where_recm_storeid $where_recm_locationid
        UNION ALL
        SELECT pr.purr_returndatead datesad, purr_returndatebs dates, concat('Purchase Return -',pr.purr_invoiceno) description, pr.purr_invoiceno as refno, dist.dist_distributor Depname, pd.prde_returnqty rec_purqty, pd.prde_purchaserate rec_ratem, pd.prde_returnqty * pd.prde_purchaserate rec_amt, 0 issueQty, 0 iss_rate, 0 issuAmt from xw_purr_purchasereturn pr 
        left join xw_prde_purchasereturndetail pd on pd.prde_purchasereturnid = pr.purr_purchasereturnid
        left join xw_dist_distributors dist on dist.dist_distributorid = pr.purr_supplierid 
        where pd.prde_itemsid = '$itemid' and pr.purr_returndatebs < '$fromdate'  and pr.purr_st = 'N' $where_purr_storeid $where_purr_locationid
        UNION ALL 
        select stma_stockdatead datesad, stma_stockdatebs dates, 'STOCK ADJUSTMENT' description,  stma.stma_remarks as refno, '' as Depname, stde.stde_qty rec_purqty, stde.stde_rate rec_rate, stde.stde_qty * stde.stde_rate rec_amt, 0 issueQty, stde_salerate iss_rate, 0 issuAmt 
        from xw_stma_stockmaster stma  
        left join xw_stde_stockdetail stde on stde.stde_stockmasterid = stma.stma_stockmassterid 
        where stde.stde_itemsid = '$itemid' AND stma.stma_stockdatebs < '$fromdate'  $where_stma_storeid $where_stma_locationid
        UNION ALL 
        select stma_stockdatead datesad, stma_stockdatebs dates, 'AMOUNT ADJUSTMENT' description,  stma.stma_remarks as refno, '' as Depname, stde.stde_qty rec_purqty, stde.stde_rate rec_rate, stde.stde_adjustamount rec_amt, 0 issueQty, stde_salerate iss_rate, 0 issuAmt 
        from xw_stma_stockmaster stma 
        left join xw_stde_stockdetail stde on stde.stde_stockmasterid = stma.stma_stockmassterid 
        where stde.stde_itemsid = '$itemid' AND stma.stma_stockdatebs < '$fromdate'  $where_stma_storeid $where_stma_locationid
        UNION ALL 
        select c.conv_condatead datesad, c.conv_condatebs dates, 'Conversion In' description, 'CI' as refno, '' as Depname, c.conv_childqty rec_purqty, c.conv_childrate rec_rate, c.conv_childqty * c.conv_childrate rec_amt, 0 issueQty, c.conv_childrate iss_rate, 0 issuAmt 
        from xw_conv_conversion c where c.conv_childid = '$itemid' and c.conv_condatebs < '$fromdate'  $where_conv_storeid $where_conv_locationid
        UNION ALL 
        select c.conv_condatead datesad, c.conv_condatebs dates, 'Conversion Out' description, 'CO' as refno, '' as Depname, 0 rec_purqty, c.conv_parentrate rec_rate, 0 * c.conv_childrate rec_amt, c.conv_parentqty issueQty, c.conv_parentrate iss_rate, c.conv_parentqty * c.conv_parentrate issuAmt 
        from xw_conv_conversion c 
        where c.conv_parentid = '$itemid' and c.conv_condatebs < '$fromdate'  $where_conv_storeid $where_conv_locationid
        UNION ALL
        select rema.rema_returndatead datesad, rema.rema_returndatebs dates, concat('RETURN-',rema_invoiceno) description, concat('REQ NO:',rqm.rema_reqno) as refno, d.dept_depname as depname, rede.rede_qty rec_purqty, rede.rede_unitprice rec_rate, 0 rec_amt, 0 issueQty, rede.rede_unitprice iss_rate, rede.rede_total issuAmt 
        from xw_rema_returnmaster rema 
        left join xw_rede_returndetail rede on rede.rede_returnmasterid = rema.rema_returnmasterid 
        left join xw_rede_reqdetail rqd on rqd.rede_reqdetailid = rede.rede_reqdetailid 
        left join xw_rema_reqmaster rqm on rqm.rema_reqmasterid = rqd.rede_reqmasterid 
        left join xw_dept_department d on d.dept_depid  = rema.rema_depid 
        where rede.rede_itemsid = '$itemid' and rema.rema_returndatebs < '$fromdate'  $where_rema_storeid $where_rema_locationid ) A

        UNION

        select sm.sama_billdatead datesad, sm.sama_billdatebs dates, sm.sama_invoiceno description, sm.sama_requisitionno refno, sm.sama_depname Depname, 0 rec_purqty, sade_unitrate rec_rate, 0 as rec_amt, sd.sade_qty issueQty, sd.sade_unitrate iss_rate, sd.sade_qty * sd.sade_unitrate issuAmt 
        from xw_sama_salemaster sm  
        left join xw_sade_saledetail sd on sm.sama_salemasterid = sd.sade_salemasterid 
        where sm.sama_st = 'N' and sd.sade_itemsid = '$itemid' and sm.sama_billdatebs between '$fromdate' AND '$todate' $where_sama_storeid $where_sama_locationid
        UNION ALL
        select tm.trma_transactiondatead datesad, tm.trma_transactiondatebs dates,'OPENING' AS description, 'In-Date' refno, '' as Depname, td.trde_requiredqty rec_purqty, td.trde_unitprice rec_rate, td.trde_requiredqty * td.trde_unitprice as rec_amt, 0 issueQty, 0 iss_rate, 0 issuAmt 
        from xw_trma_transactionmain tm
        left join xw_trde_transactiondetail td on tm.trma_trmaid = td.trde_trmaid
        where td.trde_transactiontype = 'OPENING' and td.trde_itemsid = '$itemid' and tm.trma_transactiondatebs between '$fromdate' AND '$todate' $where_trma_storeid $where_trma_locationid
        UNION ALL
        select cm.chma_challanrecdatead datesad, cm.chma_challanrecdatebs dates, concat('Challan-',chma_challannumber) description, chma_challannumber refno, dist_distributor as Depname, cd.chde_qty rec_purqty, 0 rec_rate, 0 as rec_amt, 0 issueQty, 0 iss_rate, 0 issuAmt
        from xw_chma_challanmaster cm 
        left join xw_chde_challandetails cd on cm.chma_challanmasterid = cd.chde_challanmasterid
        left join xw_dist_distributors dist on cm.chma_supplierid = dist.dist_distributorid 
        left join xw_trma_transactionmain tm on tm.trma_trmaid = cm.chma_mattransmasterid
        where cd.chde_itemsid = '$itemid' and cm.chma_challanrecdatebs between '$fromdate' AND '$todate' and chde_receivecomplete = 'N' $where_trma_storeid $where_trma_locationid
        UNION ALL
        SELECT rm.recm_receiveddatead datesad, rm.recm_receiveddatebs dates, concat(recm_invoiceno,'-','O.Date:',pm.puor_orderdatebs) description, rm.recm_supplierbillno as refno, dist.dist_distributor Depname, rd.recd_purchasedqty rec_purqty, rd.recd_salerate rec_rate, rd.recd_purchasedqty * recd_salerate rec_amt, 0 issueQty, 0 iss_rate, 0 issuAmt 
        from xw_recm_receivedmaster rm 
        left join xw_recd_receiveddetail rd on rd.recd_receivedmasterid = rm.recm_receivedmasterid 
        left join xw_puor_purchaseordermaster pm on pm.puor_purchaseordermasterid = rm.recm_purchaseordermasterid 
        left join xw_dist_distributors dist on dist_distributorid = rm.recm_supplierid 
        where rd.recd_itemsid = '$itemid' and rm.recm_receiveddatebs between '$fromdate' AND '$todate' and rm.recm_status <> 'M'  $where_recm_storeid $where_recm_locationid
        UNION ALL
        SELECT pr.purr_returndatead datesad, purr_returndatebs dates, concat('Purchase Return -',pr.purr_invoiceno) description, pr.purr_invoiceno as refno, dist.dist_distributor Depname, pd.prde_returnqty rec_purqty, pd.prde_purchaserate rec_ratem, pd.prde_returnqty * pd.prde_purchaserate rec_amt, 0 issueQty, 0 iss_rate, 0 issuAmt from xw_purr_purchasereturn pr 
        left join xw_prde_purchasereturndetail pd on pd.prde_purchasereturnid = pr.purr_purchasereturnid
        left join xw_dist_distributors dist on dist.dist_distributorid = pr.purr_supplierid 
        where pd.prde_itemsid = '$itemid' and pr.purr_returndatebs between '$fromdate' AND '$todate' and pr.purr_st = 'N' $where_purr_storeid $where_purr_locationid
        UNION ALL 
        SELECT stma_stockdatead datesad, stma_stockdatebs dates, 'STOCK ADJUSTMENT' description,  stma.stma_remarks as refno, '' as Depname, stde.stde_qty rec_purqty, stde.stde_rate rec_rate, stde.stde_qty * stde.stde_rate rec_amt, 0 issueQty, stde_salerate iss_rate, 0 issuAmt 
        from xw_stma_stockmaster stma  
        left join xw_stde_stockdetail stde on stde.stde_stockmasterid = stma.stma_stockmassterid 
        where stde.stde_itemsid = '$itemid' AND stma.stma_stockdatebs between '$fromdate' AND '$todate' $where_stma_storeid $where_stma_locationid
        UNION ALL 
        SELECT stma_stockdatead datesad, stma_stockdatebs dates, 'AMOUNT ADJUSTMENT' description,  stma.stma_remarks as refno, '' as Depname, stde.stde_qty rec_purqty, stde.stde_rate rec_rate, stde.stde_adjustamount rec_amt, 0 issueQty, stde_salerate iss_rate, 0 issuAmt 
        from xw_stma_stockmaster stma 
        left join xw_stde_stockdetail stde on stde.stde_stockmasterid = stma.stma_stockmassterid 
        where stde.stde_itemsid = '$itemid' AND stma.stma_stockdatebs between '$fromdate' AND '$todate'  $where_stma_storeid $where_stma_locationid
        UNION ALL 
        SELECT c.conv_condatead datesad, c.conv_condatebs dates, 'Conversion In' description, 'CI' as refno, '' as Depname, c.conv_childqty rec_purqty, c.conv_childrate rec_rate, c.conv_childqty * c.conv_childrate rec_amt, 0 issueQty, c.conv_childrate iss_rate, 0 issuAmt 
        from xw_conv_conversion c where c.conv_childid = '$itemid' and c.conv_condatebs between '$fromdate' AND '$todate'  $where_conv_storeid $where_conv_locationid
        UNION ALL 
        SELECT c.conv_condatead datesad, c.conv_condatebs dates, 'Conversion Out' description, 'CO' as refno, '' as Depname, 0 rec_purqty, c.conv_parentrate rec_rate, 0 * c.conv_childrate rec_amt, c.conv_parentqty issueQty, c.conv_parentrate iss_rate, c.conv_parentqty * c.conv_parentrate issuAmt 
        from xw_conv_conversion c 
        where c.conv_parentid = '$itemid' and c.conv_condatebs between '$fromdate' AND '$todate'  $where_conv_storeid $where_conv_locationid
        UNION ALL
        SELECT rema.rema_returndatead datesad, rema.rema_returndatebs dates, concat('RETURN-',rema_receiveno) description, concat('REQ NO:',rqm.rema_reqno) as refno, d.dept_depname as depname, 0 rec_purqty, rede.rede_unitprice rec_rate, 0 rec_amt, rede.rede_qty issueQty, rede.rede_unitprice iss_rate, rede.rede_total issuAmt 
        from xw_rema_returnmaster rema 
        left join xw_rede_returndetail rede on rede.rede_returnmasterid = rema.rema_returnmasterid 
        left join xw_rede_reqdetail rqd on rqd.rede_reqdetailid = rede.rede_reqdetailid 
        left join xw_rema_reqmaster rqm on rqm.rema_reqmasterid = rqd.rede_reqmasterid 
        left join xw_dept_department d on d.dept_depid  = rema.rema_depid 
        where rede.rede_itemsid = '$itemid' and rema.rema_returndatebs between '$fromdate' AND '$todate' $where_rema_storeid $where_rema_locationid

        UNION
          SELECT '-' as datesad,'9099/12/12' as dates, 'Closing' as description,'-' as refno, '-' as Depname,   SUM(rec_purqty) rec_purqty, 0 rec_rate, 0 as rec_amt, SUM(issueQty) issueQty , 0 iss_rate, 0 issuAmt  FROM(
        SELECT sm.sama_billdatead datesad, sm.sama_billdatebs dates, sm.sama_invoiceno description, sm.sama_requisitionno refno, sm.sama_depname Depname, 0 rec_purqty, sade_unitrate rec_rate, 0 as rec_amt, sd.sade_qty issueQty, sd.sade_unitrate iss_rate, sd.sade_qty * sd.sade_unitrate issuAmt 
        from xw_sama_salemaster sm  
        left join xw_sade_saledetail sd on sm.sama_salemasterid = sd.sade_salemasterid 
        where sm.sama_st = 'N' and sd.sade_itemsid = '$itemid' and sm.sama_billdatebs > '$todate'  $where_sama_storeid $where_sama_locationid
        UNION ALL
        SELECT tm.trma_transactiondatead datesad, tm.trma_transactiondatebs dates,'OPENING' AS description, 'In-Date' refno, '' as Depname, td.trde_requiredqty rec_purqty, td.trde_unitprice rec_rate, td.trde_requiredqty * td.trde_unitprice as rec_amt, 0 issueQty, 0 iss_rate, 0 issuAmt 
        from xw_trma_transactionmain tm
        left join xw_trde_transactiondetail td on tm.trma_trmaid = td.trde_trmaid
        where td.trde_transactiontype = 'OPENING' and td.trde_itemsid = '$itemid' and tm.trma_transactiondatebs > '$todate'  $where_trma_storeid $where_trma_locationid
        UNION ALL
        select cm.chma_challanrecdatead datesad, cm.chma_challanrecdatebs dates, concat('Challan-',chma_challannumber) description, chma_challannumber refno, dist_distributor as Depname, cd.chde_qty rec_purqty, 0 rec_rate, 0 as rec_amt, 0 issueQty, 0 iss_rate, 0 issuAmt
        from xw_chma_challanmaster cm 
        left join xw_chde_challandetails cd on cm.chma_challanmasterid = cd.chde_challanmasterid
        left join xw_dist_distributors dist on cm.chma_supplierid = dist.dist_distributorid 
        left join xw_trma_transactionmain tm on tm.trma_trmaid = cm.chma_mattransmasterid 
        where cd.chde_itemsid = '$itemid' and cm.chma_challanrecdatebs > '$todate'  and chde_receivecomplete = 'N' $where_trma_storeid $where_trma_locationid
        UNION ALL
        select rm.recm_receiveddatead datesad, rm.recm_receiveddatebs dates, 
        concat(recm_invoiceno,'-','O.Date:',pm.puor_orderdatebs) description, rm.recm_supplierbillno as refno, dist.dist_distributor Depname, rd.recd_purchasedqty rec_purqty, rd.recd_salerate rec_rate, rd.recd_purchasedqty * recd_salerate rec_amt, 0 issueQty, 0 iss_rate, 0 issuAmt 
        from xw_recm_receivedmaster rm 
        left join xw_recd_receiveddetail rd on rd.recd_receivedmasterid = rm.recm_receivedmasterid 
        left join xw_puor_purchaseordermaster pm on pm.puor_purchaseordermasterid = rm.recm_purchaseordermasterid 
        left join xw_dist_distributors dist on dist_distributorid = rm.recm_supplierid 
        where rd.recd_itemsid = '$itemid' and rm.recm_receiveddatebs > '$todate'  and rm.recm_status <> 'M' $where_recm_storeid $where_recm_locationid
        UNION ALL
        SELECT pr.purr_returndatead datesad, purr_returndatebs dates, concat('Purchase Return -',pr.purr_invoiceno) description, pr.purr_invoiceno as refno, dist.dist_distributor Depname, pd.prde_returnqty rec_purqty, pd.prde_purchaserate rec_ratem, pd.prde_returnqty * pd.prde_purchaserate rec_amt, 0 issueQty, 0 iss_rate, 0 issuAmt from xw_purr_purchasereturn pr 
        left join xw_prde_purchasereturndetail pd on pd.prde_purchasereturnid = pr.purr_purchasereturnid
        left join xw_dist_distributors dist on dist.dist_distributorid = pr.purr_supplierid 
        where pd.prde_itemsid = '$itemid' and pr.purr_returndatebs > '$todate'  and pr.purr_st = 'N' $where_purr_storeid $where_purr_locationid
        UNION ALL 
        select stma_stockdatead datesad, stma_stockdatebs dates, 'STOCK ADJUSTMENT' description,  stma.stma_remarks as refno, '' as Depname, stde.stde_qty rec_purqty, stde.stde_rate rec_rate, stde.stde_qty * stde.stde_rate rec_amt, 0 issueQty, stde_salerate iss_rate, 0 issuAmt 
        from xw_stma_stockmaster stma  
        left join xw_stde_stockdetail stde on stde.stde_stockmasterid = stma.stma_stockmassterid 
        where stde.stde_itemsid = '$itemid' AND stma.stma_stockdatebs > '$todate'  $where_stma_storeid $where_stma_locationid
        UNION ALL 
        select stma_stockdatead datesad, stma_stockdatebs dates, 'AMOUNT ADJUSTMENT' description,  stma.stma_remarks as refno, '' as Depname, stde.stde_qty rec_purqty, stde.stde_rate rec_rate, stde.stde_adjustamount rec_amt, 0 issueQty, stde_salerate iss_rate, 0 issuAmt 
        from xw_stma_stockmaster stma 
        left join xw_stde_stockdetail stde on stde.stde_stockmasterid = stma.stma_stockmassterid 
        where stde.stde_itemsid = '$itemid' AND stma.stma_stockdatebs > '$todate'  $where_stma_storeid $where_stma_locationid
        UNION ALL 
        select c.conv_condatead datesad, c.conv_condatebs dates, 'Conversion In' description, 'CI' as refno, '' as Depname, c.conv_childqty rec_purqty, c.conv_childrate rec_rate, c.conv_childqty * c.conv_childrate rec_amt, 0 issueQty, c.conv_childrate iss_rate, 0 issuAmt 
        from xw_conv_conversion c where c.conv_childid = '$itemid' and c.conv_condatebs > '$todate'  $where_conv_storeid $where_conv_locationid
        UNION ALL 
        select c.conv_condatead datesad, c.conv_condatebs dates, 'Conversion Out' description, 'CO' as refno, '' as Depname, 0 rec_purqty, c.conv_parentrate rec_rate, 0 * c.conv_childrate rec_amt, c.conv_parentqty issueQty, c.conv_parentrate iss_rate, c.conv_parentqty * c.conv_parentrate issuAmt 
        from xw_conv_conversion c 
        where c.conv_parentid = '$itemid' and c.conv_condatebs > '$todate'  $where_conv_storeid $where_conv_locationid
        UNION ALL
        SELECT rema.rema_returndatead datesad, rema.rema_returndatebs dates, concat('RETURN-',rema_invoiceno) description, concat('REQ NO:',rqm.rema_reqno) as refno, d.dept_depname as depname, rede.rede_qty rec_purqty, rede.rede_unitprice rec_rate, 0 rec_amt, 0 issueQty, rede.rede_unitprice iss_rate, rede.rede_total issuAmt 
        from xw_rema_returnmaster rema 
        left join xw_rede_returndetail rede on rede.rede_returnmasterid = rema.rema_returnmasterid 
        left join xw_rede_reqdetail rqd on rqd.rede_reqdetailid = rede.rede_reqdetailid 
        left join xw_rema_reqmaster rqm on rqm.rema_reqmasterid = rqd.rede_reqmasterid 
        left join xw_dept_department d on d.dept_depid  = rema.rema_depid 
        where rede.rede_itemsid = '$itemid' and rema.rema_returndatebs > '$todate'  $where_rema_storeid $where_rema_locationid ) 
B
        ) X order_by dates ASC";

        $totalfilteredrecs = '';

        if (!empty($_GET['iDisplayLength']) &&  !empty($resltrpt) && is_array($resltrpt) && count($resltrpt) > 0 ) {
            $totalfilteredrecs=sizeof( $resltrpt);
        }

        $order_by = 'X.dates';
        $order = 'asc';
        if($this->input->get('sSortDir_0'))
        {
                $order = $this->input->get('sSortDir_0');
        }
  
        $where='';
        if($this->input->get('iSortCol_0')==1)
            $order_by = 'itli_itemcode';
      
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
            $this->db->where("eqty_equipmenttype like  '%".$get['sSearch_2']."%'  ");
        }

        if(!empty($get['sSearch_3'])){
            $this->db->where("itli_itemname like  '%".$get['sSearch_3']."%'  ");
        }

        $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');
        
        $sql = "SELECT * from (

        SELECT '-' as datesad,'-' as dates, 'Opening' as description,'-' as refno, '-' as Depname,   SUM(rec_purqty) rec_purqty, 0 rec_rate, 0 as rec_amt, SUM(issueQty) issueQty , 0 iss_rate, 0 issuAmt  FROM(
        select sm.sama_billdatead datesad, sm.sama_billdatebs dates, sm.sama_invoiceno description, sm.sama_requisitionno refno, sm.sama_depname Depname, 0 rec_purqty, sade_unitrate rec_rate, 0 as rec_amt, sd.sade_qty issueQty, sd.sade_unitrate iss_rate, sd.sade_qty * sd.sade_unitrate issuAmt 
        from xw_sama_salemaster sm  
        left join xw_sade_saledetail sd on sm.sama_salemasterid = sd.sade_salemasterid 
        where sm.sama_st = 'N' and sd.sade_itemsid = '$itemid' and sm.sama_billdatebs < '$fromdate'  $where_sama_storeid $where_sama_locationid
        UNION ALL
        select tm.trma_transactiondatead datesad, tm.trma_transactiondatebs dates,'OPENING' AS description, 'In-Date' refno, '' as Depname, td.trde_requiredqty rec_purqty, td.trde_unitprice rec_rate, td.trde_requiredqty * td.trde_unitprice as rec_amt, 0 issueQty, 0 iss_rate, 0 issuAmt 
        from xw_trma_transactionmain tm
        left join xw_trde_transactiondetail td on tm.trma_trmaid = td.trde_trmaid
        where td.trde_transactiontype = 'OPENING' and td.trde_itemsid = '$itemid' and tm.trma_transactiondatebs < '$fromdate'  $where_trma_storeid $where_trma_locationid
        UNION ALL
        select cm.chma_challanrecdatead datesad, cm.chma_challanrecdatebs dates, concat('Challan-',chma_challannumber) description, chma_challannumber refno, dist_distributor as Depname, cd.chde_qty rec_purqty, 0 rec_rate, 0 as rec_amt, 0 issueQty, 0 iss_rate, 0 issuAmt
        from xw_chma_challanmaster cm 
        left join xw_chde_challandetails cd on cm.chma_challanmasterid = cd.chde_challanmasterid
        left join xw_dist_distributors dist on cm.chma_supplierid = dist.dist_distributorid 
        left join xw_trma_transactionmain tm on tm.trma_trmaid = cm.chma_mattransmasterid 
        where cd.chde_itemsid = '$itemid' and cm.chma_challanrecdatebs < '$fromdate'  and chde_receivecomplete = 'N' $where_trma_storeid $where_trma_locationid
        UNION ALL
        select rm.recm_receiveddatead datesad, rm.recm_receiveddatebs dates, 
        concat(recm_invoiceno,'-','O.Date:',pm.puor_orderdatebs) description, rm.recm_supplierbillno as refno, dist.dist_distributor Depname, rd.recd_purchasedqty rec_purqty, rd.recd_salerate rec_rate, rd.recd_purchasedqty * recd_salerate rec_amt, 0 issueQty, 0 iss_rate, 0 issuAmt 
        from xw_recm_receivedmaster rm 
        left join xw_recd_receiveddetail rd on rd.recd_receivedmasterid = rm.recm_receivedmasterid 
        left join xw_puor_purchaseordermaster pm on pm.puor_purchaseordermasterid = rm.recm_purchaseordermasterid 
        left join xw_dist_distributors dist on dist_distributorid = rm.recm_supplierid 
        where rd.recd_itemsid = '$itemid' and rm.recm_receiveddatebs < '$fromdate'  and rm.recm_status <> 'M' $where_recm_storeid $where_recm_locationid
        UNION ALL
        SELECT pr.purr_returndatead datesad, purr_returndatebs dates, concat('Purchase Return -',pr.purr_invoiceno) description, pr.purr_invoiceno as refno, dist.dist_distributor Depname, pd.prde_returnqty rec_purqty, pd.prde_purchaserate rec_ratem, pd.prde_returnqty * pd.prde_purchaserate rec_amt, 0 issueQty, 0 iss_rate, 0 issuAmt from xw_purr_purchasereturn pr 
        left join xw_prde_purchasereturndetail pd on pd.prde_purchasereturnid = pr.purr_purchasereturnid
        left join xw_dist_distributors dist on dist.dist_distributorid = pr.purr_supplierid 
        where pd.prde_itemsid = '$itemid' and pr.purr_returndatebs < '$fromdate'  and pr.purr_st = 'N' $where_purr_storeid $where_purr_locationid
        UNION ALL 
        select stma_stockdatead datesad, stma_stockdatebs dates, 'STOCK ADJUSTMENT' description,  stma.stma_remarks as refno, '' as Depname, stde.stde_qty rec_purqty, stde.stde_rate rec_rate, stde.stde_qty * stde.stde_rate rec_amt, 0 issueQty, stde_salerate iss_rate, 0 issuAmt 
        from xw_stma_stockmaster stma  
        left join xw_stde_stockdetail stde on stde.stde_stockmasterid = stma.stma_stockmassterid 
        where stde.stde_itemsid = '$itemid' AND stma.stma_stockdatebs < '$fromdate'  $where_stma_storeid $where_stma_locationid
        UNION ALL 
        select stma_stockdatead datesad, stma_stockdatebs dates, 'AMOUNT ADJUSTMENT' description,  stma.stma_remarks as refno, '' as Depname, stde.stde_qty rec_purqty, stde.stde_rate rec_rate, stde.stde_adjustamount rec_amt, 0 issueQty, stde_salerate iss_rate, 0 issuAmt 
        from xw_stma_stockmaster stma 
        left join xw_stde_stockdetail stde on stde.stde_stockmasterid = stma.stma_stockmassterid 
        where stde.stde_itemsid = '$itemid' AND stma.stma_stockdatebs < '$fromdate'  $where_stma_storeid $where_stma_locationid
        UNION ALL 
        select c.conv_condatead datesad, c.conv_condatebs dates, 'Conversion In' description, 'CI' as refno, '' as Depname, c.conv_childqty rec_purqty, c.conv_childrate rec_rate, c.conv_childqty * c.conv_childrate rec_amt, 0 issueQty, c.conv_childrate iss_rate, 0 issuAmt 
        from xw_conv_conversion c where c.conv_childid = '$itemid' and c.conv_condatebs < '$fromdate'  $where_conv_storeid $where_conv_locationid
        UNION ALL 
        select c.conv_condatead datesad, c.conv_condatebs dates, 'Conversion Out' description, 'CO' as refno, '' as Depname, 0 rec_purqty, c.conv_parentrate rec_rate, 0 * c.conv_childrate rec_amt, c.conv_parentqty issueQty, c.conv_parentrate iss_rate, c.conv_parentqty * c.conv_parentrate issuAmt 
        from xw_conv_conversion c 
        where c.conv_parentid = '$itemid' and c.conv_condatebs < '$fromdate'  $where_conv_storeid $where_conv_locationid
        UNION ALL
        select rema.rema_returndatead datesad, rema.rema_returndatebs dates, concat('RETURN-',rema_invoiceno) description, concat('REQ NO:',rqm.rema_reqno) as refno, d.dept_depname as depname, rede.rede_qty rec_purqty, rede.rede_unitprice rec_rate, 0 rec_amt, 0 issueQty, rede.rede_unitprice iss_rate, rede.rede_total issuAmt 
        from xw_rema_returnmaster rema 
        left join xw_rede_returndetail rede on rede.rede_returnmasterid = rema.rema_returnmasterid 
        left join xw_rede_reqdetail rqd on rqd.rede_reqdetailid = rede.rede_reqdetailid 
        left join xw_rema_reqmaster rqm on rqm.rema_reqmasterid = rqd.rede_reqmasterid 
        left join xw_dept_department d on d.dept_depid  = rema.rema_depid 
        where rede.rede_itemsid = '$itemid' and rema.rema_returndatebs < '$fromdate'  $where_rema_storeid $where_rema_locationid ) A

        UNION
        select sm.sama_billdatead datesad, sm.sama_billdatebs dates, sm.sama_invoiceno description, sm.sama_requisitionno refno, sm.sama_depname Depname, 0 rec_purqty, sade_unitrate rec_rate, 0 as rec_amt, sd.sade_qty issueQty, sd.sade_unitrate iss_rate, sd.sade_qty * sd.sade_unitrate issuAmt 
        from xw_sama_salemaster sm  
        left join xw_sade_saledetail sd on sm.sama_salemasterid = sd.sade_salemasterid 
        where sm.sama_st = 'N' and sd.sade_itemsid = '$itemid' and sm.sama_billdatebs between '$fromdate' AND '$todate' $where_sama_storeid $where_sama_locationid
        UNION ALL
        select tm.trma_transactiondatead datesad, tm.trma_transactiondatebs dates,'OPENING' AS description, 'In-Date' refno, '' as Depname, td.trde_requiredqty rec_purqty, td.trde_unitprice rec_rate, td.trde_requiredqty * td.trde_unitprice as rec_amt, 0 issueQty, 0 iss_rate, 0 issuAmt 
        from xw_trma_transactionmain tm
        left join xw_trde_transactiondetail td on tm.trma_trmaid = td.trde_trmaid
        where td.trde_transactiontype = 'OPENING' and td.trde_itemsid = '$itemid' and tm.trma_transactiondatebs between '$fromdate' AND '$todate' $where_trma_storeid $where_trma_locationid
        UNION ALL
        select cm.chma_challanrecdatead datesad, cm.chma_challanrecdatebs dates, concat('Challan-',chma_challannumber) description, chma_challannumber refno, dist_distributor as Depname, cd.chde_qty rec_purqty, 0 rec_rate, 0 as rec_amt, 0 issueQty, 0 iss_rate, 0 issuAmt
        from xw_chma_challanmaster cm 
        left join xw_chde_challandetails cd on cm.chma_challanmasterid = cd.chde_challanmasterid
        left join xw_dist_distributors dist on cm.chma_supplierid = dist.dist_distributorid 
        left join xw_trma_transactionmain tm on tm.trma_trmaid = cm.chma_mattransmasterid 
        where cd.chde_itemsid = '$itemid' and cm.chma_challanrecdatebs between '$fromdate' AND '$todate' and chde_receivecomplete = 'N' $where_trma_storeid $where_trma_locationid
        UNION ALL
        select rm.recm_receiveddatead datesad, rm.recm_receiveddatebs dates, 
        concat(recm_invoiceno,'-','O.Date:',pm.puor_orderdatebs) description, rm.recm_supplierbillno as refno, dist.dist_distributor Depname, rd.recd_purchasedqty rec_purqty, rd.recd_salerate rec_rate, rd.recd_purchasedqty * recd_salerate rec_amt, 0 issueQty, 0 iss_rate, 0 issuAmt 
        from xw_recm_receivedmaster rm 
        left join xw_recd_receiveddetail rd on rd.recd_receivedmasterid = rm.recm_receivedmasterid 
        left join xw_puor_purchaseordermaster pm on pm.puor_purchaseordermasterid = rm.recm_purchaseordermasterid 
        left join xw_dist_distributors dist on dist_distributorid = rm.recm_supplierid 
        where rd.recd_itemsid = '$itemid' and rm.recm_receiveddatebs between '$fromdate' AND '$todate' and rm.recm_status <> 'M' $where_recm_storeid $where_recm_locationid
        UNION ALL
        SELECT pr.purr_returndatead datesad, purr_returndatebs dates, concat('Purchase Return -',pr.purr_invoiceno) description, pr.purr_invoiceno as refno, dist.dist_distributor Depname, pd.prde_returnqty rec_purqty, pd.prde_purchaserate rec_ratem, pd.prde_returnqty * pd.prde_purchaserate rec_amt, 0 issueQty, 0 iss_rate, 0 issuAmt from xw_purr_purchasereturn pr 
        left join xw_prde_purchasereturndetail pd on pd.prde_purchasereturnid = pr.purr_purchasereturnid
        left join xw_dist_distributors dist on dist.dist_distributorid = pr.purr_supplierid 
        where pd.prde_itemsid = '$itemid' and pr.purr_returndatebs between '$fromdate' AND '$todate' and pr.purr_st = 'N' $where_purr_storeid $where_purr_locationid
        UNION ALL 
        select stma_stockdatead datesad, stma_stockdatebs dates, 'STOCK ADJUSTMENT' description,  stma.stma_remarks as refno, '' as Depname, stde.stde_qty rec_purqty, stde.stde_rate rec_rate, stde.stde_qty * stde.stde_rate rec_amt, 0 issueQty, stde_salerate iss_rate, 0 issuAmt 
        from xw_stma_stockmaster stma  
        left join xw_stde_stockdetail stde on stde.stde_stockmasterid = stma.stma_stockmassterid 
        where stde.stde_itemsid = '$itemid' AND stma.stma_stockdatebs between '$fromdate' AND '$todate' $where_stma_storeid $where_stma_locationid
        UNION ALL 
        select stma_stockdatead datesad, stma_stockdatebs dates, 'AMOUNT ADJUSTMENT' description,  stma.stma_remarks as refno, '' as Depname, stde.stde_qty rec_purqty, stde.stde_rate rec_rate, stde.stde_adjustamount rec_amt, 0 issueQty, stde_salerate iss_rate, 0 issuAmt 
        from xw_stma_stockmaster stma 
        left join xw_stde_stockdetail stde on stde.stde_stockmasterid = stma.stma_stockmassterid 
        where stde.stde_itemsid = '$itemid' AND stma.stma_stockdatebs between '$fromdate' AND '$todate' $where_stma_storeid $where_stma_locationid
        UNION ALL 
        select c.conv_condatead datesad, c.conv_condatebs dates, 'Conversion In' description, 'CI' as refno, '' as Depname, c.conv_childqty rec_purqty, c.conv_childrate rec_rate, c.conv_childqty * c.conv_childrate rec_amt, 0 issueQty, c.conv_childrate iss_rate, 0 issuAmt 
        from xw_conv_conversion c where c.conv_childid = '$itemid' and c.conv_condatebs between '$fromdate' AND '$todate' $where_conv_storeid $where_conv_locationid
        UNION ALL 
        select c.conv_condatead datesad, c.conv_condatebs dates, 'Conversion Out' description, 'CO' as refno, '' as Depname, 0 rec_purqty, c.conv_parentrate rec_rate, 0 * c.conv_childrate rec_amt, c.conv_parentqty issueQty, c.conv_parentrate iss_rate, c.conv_parentqty * c.conv_parentrate issuAmt 
        from xw_conv_conversion c 
        where c.conv_parentid = '$itemid' and c.conv_condatebs between '$fromdate' AND '$todate' $where_conv_storeid $where_conv_locationid
        UNION ALL
        select rema.rema_returndatead datesad, rema.rema_returndatebs dates, concat('RETURN-',rema_invoiceno) description, concat('REQ NO:',rqm.rema_reqno) as refno, d.dept_depname as depname, rede.rede_qty rec_purqty, rede.rede_unitprice rec_rate, 0 rec_amt, 0 issueQty, rede.rede_unitprice iss_rate, rede.rede_total issuAmt 
        from xw_rema_returnmaster rema 
        left join xw_rede_returndetail rede on rede.rede_returnmasterid = rema.rema_returnmasterid 
        left join xw_rede_reqdetail rqd on rqd.rede_reqdetailid = rede.rede_reqdetailid 
        left join xw_rema_reqmaster rqm on rqm.rema_reqmasterid = rqd.rede_reqmasterid 
        left join xw_dept_department d on d.dept_depid  = rema.rema_depid 
        where rede.rede_itemsid = '$itemid' and rema.rema_returndatebs between '$fromdate' AND '$todate' $where_rema_storeid $where_rema_locationid 

UNION
          SELECT '-' as datesad,'9099/12/12' as dates, 'Closing' as description,'-' as refno, '-' as Depname,   SUM(rec_purqty) rec_purqty, 0 rec_rate, 0 as rec_amt, SUM(issueQty) issueQty , 0 iss_rate, 0 issuAmt  FROM(
        select sm.sama_billdatead datesad, sm.sama_billdatebs dates, sm.sama_invoiceno description, sm.sama_requisitionno refno, sm.sama_depname Depname, 0 rec_purqty, sade_unitrate rec_rate, 0 as rec_amt, sd.sade_qty issueQty, sd.sade_unitrate iss_rate, sd.sade_qty * sd.sade_unitrate issuAmt 
        from xw_sama_salemaster sm  
        left join xw_sade_saledetail sd on sm.sama_salemasterid = sd.sade_salemasterid 
        where sm.sama_st = 'N' and sd.sade_itemsid = '$itemid' and sm.sama_billdatebs > '$todate'  $where_sama_storeid $where_sama_locationid
        UNION ALL
        select tm.trma_transactiondatead datesad, tm.trma_transactiondatebs dates,'OPENING' AS description, 'In-Date' refno, '' as Depname, td.trde_requiredqty rec_purqty, td.trde_unitprice rec_rate, td.trde_requiredqty * td.trde_unitprice as rec_amt, 0 issueQty, 0 iss_rate, 0 issuAmt 
        from xw_trma_transactionmain tm
        left join xw_trde_transactiondetail td on tm.trma_trmaid = td.trde_trmaid
        where td.trde_transactiontype = 'OPENING' and td.trde_itemsid = '$itemid' and tm.trma_transactiondatebs > '$todate'  $where_trma_storeid $where_trma_locationid
        UNION ALL
        select cm.chma_challanrecdatead datesad, cm.chma_challanrecdatebs dates, concat('Challan-',chma_challannumber) description, chma_challannumber refno, dist_distributor as Depname, cd.chde_qty rec_purqty, 0 rec_rate, 0 as rec_amt, 0 issueQty, 0 iss_rate, 0 issuAmt
        from xw_chma_challanmaster cm 
        left join xw_chde_challandetails cd on cm.chma_challanmasterid = cd.chde_challanmasterid
        left join xw_dist_distributors dist on cm.chma_supplierid = dist.dist_distributorid 
        left join xw_trma_transactionmain tm on tm.trma_trmaid = cm.chma_mattransmasterid 
        where cd.chde_itemsid = '$itemid' and cm.chma_challanrecdatebs > '$todate'  and chde_receivecomplete = 'N' $where_trma_storeid $where_trma_locationid
        UNION ALL
        select rm.recm_receiveddatead datesad, rm.recm_receiveddatebs dates, 
        concat(recm_invoiceno,'-','O.Date:',pm.puor_orderdatebs) description, rm.recm_supplierbillno as refno, dist.dist_distributor Depname, rd.recd_purchasedqty rec_purqty, rd.recd_salerate rec_rate, rd.recd_purchasedqty * recd_salerate rec_amt, 0 issueQty, 0 iss_rate, 0 issuAmt 
        from xw_recm_receivedmaster rm 
        left join xw_recd_receiveddetail rd on rd.recd_receivedmasterid = rm.recm_receivedmasterid 
        left join xw_puor_purchaseordermaster pm on pm.puor_purchaseordermasterid = rm.recm_purchaseordermasterid 
        left join xw_dist_distributors dist on dist_distributorid = rm.recm_supplierid 
        where rd.recd_itemsid = '$itemid' and rm.recm_receiveddatebs > '$todate'  and rm.recm_status <> 'M' $where_recm_storeid $where_recm_locationid
        UNION ALL
        SELECT pr.purr_returndatead datesad, purr_returndatebs dates, concat('Purchase Return -',pr.purr_invoiceno) description, pr.purr_invoiceno as refno, dist.dist_distributor Depname, pd.prde_returnqty rec_purqty, pd.prde_purchaserate rec_ratem, pd.prde_returnqty * pd.prde_purchaserate rec_amt, 0 issueQty, 0 iss_rate, 0 issuAmt from xw_purr_purchasereturn pr 
        left join xw_prde_purchasereturndetail pd on pd.prde_purchasereturnid = pr.purr_purchasereturnid
        left join xw_dist_distributors dist on dist.dist_distributorid = pr.purr_supplierid 
        where pd.prde_itemsid = '$itemid' and pr.purr_returndatebs > '$todate'  and pr.purr_st = 'N' $where_purr_storeid $where_purr_locationid
        UNION ALL 
        select stma_stockdatead datesad, stma_stockdatebs dates, 'STOCK ADJUSTMENT' description,  stma.stma_remarks as refno, '' as Depname, stde.stde_qty rec_purqty, stde.stde_rate rec_rate, stde.stde_qty * stde.stde_rate rec_amt, 0 issueQty, stde_salerate iss_rate, 0 issuAmt 
        from xw_stma_stockmaster stma  
        left join xw_stde_stockdetail stde on stde.stde_stockmasterid = stma.stma_stockmassterid 
        where stde.stde_itemsid = '$itemid' AND stma.stma_stockdatebs > '$todate'  $where_stma_storeid $where_stma_locationid
        UNION ALL 
        select stma_stockdatead datesad, stma_stockdatebs dates, 'AMOUNT ADJUSTMENT' description,  stma.stma_remarks as refno, '' as Depname, stde.stde_qty rec_purqty, stde.stde_rate rec_rate, stde.stde_adjustamount rec_amt, 0 issueQty, stde_salerate iss_rate, 0 issuAmt 
        from xw_stma_stockmaster stma 
        left join xw_stde_stockdetail stde on stde.stde_stockmasterid = stma.stma_stockmassterid 
        where stde.stde_itemsid = '$itemid' AND stma.stma_stockdatebs > '$todate'  $where_stma_storeid $where_stma_locationid
        UNION ALL 
        select c.conv_condatead datesad, c.conv_condatebs dates, 'Conversion In' description, 'CI' as refno, '' as Depname, c.conv_childqty rec_purqty, c.conv_childrate rec_rate, c.conv_childqty * c.conv_childrate rec_amt, 0 issueQty, c.conv_childrate iss_rate, 0 issuAmt 
        from xw_conv_conversion c where c.conv_childid = '$itemid' and c.conv_condatebs > '$todate'  $where_conv_storeid $where_conv_locationid
        UNION ALL 
        select c.conv_condatead datesad, c.conv_condatebs dates, 'Conversion Out' description, 'CO' as refno, '' as Depname, 0 rec_purqty, c.conv_parentrate rec_rate, 0 * c.conv_childrate rec_amt, c.conv_parentqty issueQty, c.conv_parentrate iss_rate, c.conv_parentqty * c.conv_parentrate issuAmt 
        from xw_conv_conversion c 
        where c.conv_parentid = '$itemid' and c.conv_condatebs > '$todate'  $where_conv_storeid $where_conv_locationid
        UNION ALL
        select rema.rema_returndatead datesad, rema.rema_returndatebs dates, concat('RETURN-',rema_invoiceno) description, concat('REQ NO:',rqm.rema_reqno) as refno, d.dept_depname as depname, rede.rede_qty rec_purqty, rede.rede_unitprice rec_rate, 0 rec_amt, 0 issueQty, rede.rede_unitprice iss_rate, rede.rede_total issuAmt 
        from xw_rema_returnmaster rema 
        left join xw_rede_returndetail rede on rede.rede_returnmasterid = rema.rema_returnmasterid 
        left join xw_rede_reqdetail rqd on rqd.rede_reqdetailid = rede.rede_reqdetailid 
        left join xw_rema_reqmaster rqm on rqm.rema_reqmasterid = rqd.rede_reqmasterid 
        left join xw_dept_department d on d.dept_depid  = rema.rema_depid 
        where rede.rede_itemsid = '$itemid' and rema.rema_returndatebs > '$todate'  $where_rema_storeid $where_rema_locationid ) 
B

    ) X  ORDER BY X.dates ASC";
       
        $query = $this->db->query($sql);

        // echo $this->db->last_query();
        // die();

        $nquery= $query;

        $num_row = $nquery->num_rows($query);
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
        //echo $this->db->last_query();die();
       return $ndata;
    }

    public function get_ledger_report_new(){

        $fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
        $locationid = $this->input->post('locationid');
        $storeid = $this->input->post('store_id');
        $itemid = $this->input->post('itemid');
        $searchtype=$this->input->post('searchDateType');

        $condiss1 ='';
        $condiss2 ='';
        $condrec ='';
        $conditem='';
        $cond_trde='';
        $cond_pur_ret = '';
        $cond_iss_ret = '';

        if($searchtype=='date_range'){
          if($fromdate && $todate){
            if(DEFAULT_DATEPICKER=='NP'){
              $condiss1 .= " AND sm.sama_billdatebs < '$fromdate'";
              $condiss2 .= " AND sm.sama_billdatebs >='$fromdate' AND sm.sama_billdatebs<='$todate' ";
              $condrec .=" AND tm.trma_transactiondatebs >='$fromdate' AND tm.trma_transactiondatebs <='$todate' ";
              $cond_pur_ret .=" AND pr.purr_returndatebs >='$fromdate' AND pr.purr_returndatebs <='$todate' ";
              $cond_iss_ret .=" AND rema.rema_returndatebs >= '$fromdate' AND rema.rema_returndatebs <= '$todate' "; 
             
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
            $cond_pur_ret .= ' AND pr.purr_locationid ='.$locationid.'';
            $cond_iss_ret .=" AND rema.rema_locationid = $locationid";
        }
        
        if(!empty($itemid)){
            $condiss1 .= ' AND sade_itemsid ='.$itemid.'';
            $condiss2 .= ' AND sade_itemsid ='.$itemid.'';
            $condrec .= ' AND trde_itemsid ='.$itemid.'';
            $conditem .=' AND itli_itemlistid ='.$itemid.'';
            $cond_trde .= ' AND trde_itemsid ='.$itemid.'';
            $cond_pur_ret .= " AND prd.prde_itemsid = $itemid";
            $cond_iss_ret .= " AND rede.rede_itemsid = $itemid";
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

        $issue_return = "
        SELECT
            rema.rema_returndatead datesad,
            rema.rema_returndatebs dates,
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
            ) X 
        ORDER BY
            X.datebs ASC
        ";

        return $this->db->query($final_query)->result(); 
        
    }

    public function get_ledger_report($cond = false){
        if($cond) {
            $this->db->where($cond);
        }

        $fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
        $locationid = $this->input->post('locationid');
        $storeid = $this->input->post('store_id');
        $itemid = $this->input->post('itemid');

        $where_sama_storeid = $where_trma_storeid = $where_recm_storeid = $where_purr_storeid = $where_conv_storeid = $where_stma_storeid = $where_rema_storeid = "";

        $where_sama_locationid = $where_trma_locationid = $where_recm_locationid = $where_purr_locationid  = $where_stma_locationid = $where_conv_locationid = $where_rema_locationid = "";

        if($storeid){
            $where_sama_storeid = "AND sm.sama_storeid = '$storeid'";
            $where_trma_storeid = "AND tm.trma_fromdepartmentid = '$storeid'";
            $where_recm_storeid = "AND (rm.recm_storeid = '$storeid' OR rm.recm_departmentid = '$storeid')";
            $where_purr_storeid = "AND (pr.purr_storeid = '$storeid' OR pr.purr_departmentid = '$storeid')";
            $where_conv_storeid = "AND c.conv_departmentid = '$storeid'";
            $where_rema_storeid = "AND rema.rema_storeid = '$storeid'";
        }
        if( $this->location_ismain=='Y'){

        if(!empty($locationid)){
            $where_sama_locationid = "AND sm.sama_locationid = '$locationid'";
            $where_trma_locationid = "AND tm.trma_locationid = '$locationid'";
            $where_recm_locationid = "AND rm.recm_locationid = '$locationid'";
            $where_purr_locationid = "AND pr.purr_locationid = '$locationid'";
            $where_stma_locationid = "AND stma.stma_locationid = '$locationid'";
            $where_conv_locationid = "AND c.conv_locationid = '$locationid'";
            $where_rema_locationid = "AND rema.rema_locationid = '$locationid'";
        }
    }
    else{
            $where_sama_locationid = "AND sm.sama_locationid = '$this->locationid'";
            $where_trma_locationid = "AND tm.trma_locationid = '$this->locationid'";
            $where_recm_locationid = "AND rm.recm_locationid = '$this->locationid'";
            $where_purr_locationid = "AND pr.purr_locationid = '$this->locationid'";
            $where_stma_locationid = "AND stma.stma_locationid = '$this->locationid'";
            $where_conv_locationid = "AND c.conv_locationid = '$this->locationid'";
            $where_rema_locationid = "AND rema.rema_locationid = '$this->locationid'";

        }

      $sql = "SELECT * from (

        SELECT '-' as datesad,'-' as dates, 'Opening' as description,'-' as refno, '-' as Depname,   SUM(rec_purqty) rec_purqty, 0 rec_rate, 0 as rec_amt, SUM(issueQty) issueQty , 0 iss_rate, 0 issuAmt,  'Opening' as rtype  FROM(
        select sm.sama_billdatead datesad, sm.sama_billdatebs dates, sm.sama_invoiceno description, sm.sama_requisitionno refno, sm.sama_depname Depname, 0 rec_purqty, sade_unitrate rec_rate, 0 as rec_amt, sd.sade_qty issueQty, sd.sade_unitrate iss_rate, sd.sade_qty * sd.sade_unitrate issuAmt 
        from xw_sama_salemaster sm  
        left join xw_sade_saledetail sd on sm.sama_salemasterid = sd.sade_salemasterid 
        where sm.sama_st = 'N' and sd.sade_itemsid = '$itemid' and sm.sama_billdatebs < '$fromdate'  $where_sama_storeid $where_sama_locationid
        UNION ALL
        select tm.trma_transactiondatead datesad, tm.trma_transactiondatebs dates,'OPENING' AS description, 'In-Date' refno, '' as Depname, td.trde_requiredqty rec_purqty, td.trde_unitprice rec_rate, td.trde_requiredqty * td.trde_unitprice as rec_amt, 0 issueQty, 0 iss_rate, 0 issuAmt 
        from xw_trma_transactionmain tm
        left join xw_trde_transactiondetail td on tm.trma_trmaid = td.trde_trmaid
        where td.trde_transactiontype = 'OPENING' and td.trde_itemsid = '$itemid' and tm.trma_transactiondatebs < '$fromdate'  $where_trma_storeid $where_trma_locationid
        UNION ALL
        select cm.chma_challanrecdatead datesad, cm.chma_challanrecdatebs dates, concat('Challan-',chma_challannumber) description, chma_challannumber refno, dist_distributor as Depname, cd.chde_qty rec_purqty, 0 rec_rate, 0 as rec_amt, 0 issueQty, 0 iss_rate, 0 issuAmt
        from xw_chma_challanmaster cm 
        left join xw_chde_challandetails cd on cm.chma_challanmasterid = cd.chde_challanmasterid
        left join xw_dist_distributors dist on cm.chma_supplierid = dist.dist_distributorid 
        left join xw_trma_transactionmain tm on tm.trma_trmaid = cm.chma_mattransmasterid 
        where cd.chde_itemsid = '$itemid' and cm.chma_challanrecdatebs < '$fromdate'  and chde_receivecomplete = 'N' $where_trma_storeid $where_trma_locationid
        UNION ALL
        select rm.recm_receiveddatead datesad, rm.recm_receiveddatebs dates, 
        concat(recm_invoiceno,'-','O.Date:',pm.puor_orderdatebs) description, rm.recm_supplierbillno as refno, dist.dist_distributor Depname, rd.recd_purchasedqty rec_purqty, rd.recd_salerate rec_rate, rd.recd_purchasedqty * recd_salerate rec_amt, 0 issueQty, 0 iss_rate, 0 issuAmt 
        from xw_recm_receivedmaster rm 
        left join xw_recd_receiveddetail rd on rd.recd_receivedmasterid = rm.recm_receivedmasterid 
        left join xw_puor_purchaseordermaster pm on pm.puor_purchaseordermasterid = rm.recm_purchaseordermasterid 
        left join xw_dist_distributors dist on dist_distributorid = rm.recm_supplierid 
        where rd.recd_itemsid = '$itemid' and rm.recm_receiveddatebs < '$fromdate'  and rm.recm_status <> 'M' $where_recm_storeid $where_recm_locationid
        UNION ALL
        SELECT pr.purr_returndatead datesad, purr_returndatebs dates, concat('Purchase Return -',pr.purr_invoiceno) description, pr.purr_invoiceno as refno, dist.dist_distributor Depname, pd.prde_returnqty rec_purqty, pd.prde_purchaserate rec_ratem, pd.prde_returnqty * pd.prde_purchaserate rec_amt, 0 issueQty, 0 iss_rate, 0 issuAmt from xw_purr_purchasereturn pr 
        left join xw_prde_purchasereturndetail pd on pd.prde_purchasereturnid = pr.purr_purchasereturnid
        left join xw_dist_distributors dist on dist.dist_distributorid = pr.purr_supplierid 
        where pd.prde_itemsid = '$itemid' and pr.purr_returndatebs < '$fromdate'  and pr.purr_st = 'N' $where_purr_storeid $where_purr_locationid
        UNION ALL 
        select stma_stockdatead datesad, stma_stockdatebs dates, 'STOCK ADJUSTMENT' description,  stma.stma_remarks as refno, '' as Depname, stde.stde_qty rec_purqty, stde.stde_rate rec_rate, stde.stde_qty * stde.stde_rate rec_amt, 0 issueQty, stde_salerate iss_rate, 0 issuAmt 
        from xw_stma_stockmaster stma  
        left join xw_stde_stockdetail stde on stde.stde_stockmasterid = stma.stma_stockmassterid 
        where stde.stde_itemsid = '$itemid' AND stma.stma_stockdatebs < '$fromdate'  $where_stma_storeid $where_stma_locationid
        UNION ALL 
        select stma_stockdatead datesad, stma_stockdatebs dates, 'AMOUNT ADJUSTMENT' description,  stma.stma_remarks as refno, '' as Depname, stde.stde_qty rec_purqty, stde.stde_rate rec_rate, stde.stde_adjustamount rec_amt, 0 issueQty, stde_salerate iss_rate, 0 issuAmt 
        from xw_stma_stockmaster stma 
        left join xw_stde_stockdetail stde on stde.stde_stockmasterid = stma.stma_stockmassterid 
        where stde.stde_itemsid = '$itemid' AND stma.stma_stockdatebs < '$fromdate'  $where_stma_storeid $where_stma_locationid
        UNION ALL 
        select c.conv_condatead datesad, c.conv_condatebs dates, 'Conversion In' description, 'CI' as refno, '' as Depname, c.conv_childqty rec_purqty, c.conv_childrate rec_rate, c.conv_childqty * c.conv_childrate rec_amt, 0 issueQty, c.conv_childrate iss_rate, 0 issuAmt 
        from xw_conv_conversion c where c.conv_childid = '$itemid' and c.conv_condatebs < '$fromdate'  $where_conv_storeid $where_conv_locationid
        UNION ALL 
        select c.conv_condatead datesad, c.conv_condatebs dates, 'Conversion Out' description, 'CO' as refno, '' as Depname, 0 rec_purqty, c.conv_parentrate rec_rate, 0 * c.conv_childrate rec_amt, c.conv_parentqty issueQty, c.conv_parentrate iss_rate, c.conv_parentqty * c.conv_parentrate issuAmt 
        from xw_conv_conversion c 
        where c.conv_parentid = '$itemid' and c.conv_condatebs < '$fromdate'  $where_conv_storeid $where_conv_locationid
        UNION ALL
        select rema.rema_returndatead datesad, rema.rema_returndatebs dates, concat('RETURN-',rema_invoiceno) description, concat('REQ NO:',rqm.rema_reqno) as refno, d.dept_depname as depname, rede.rede_qty rec_purqty, rede.rede_unitprice rec_rate, 0 rec_amt, 0 issueQty, rede.rede_unitprice iss_rate, rede.rede_total issuAmt 
        from xw_rema_returnmaster rema 
        left join xw_rede_returndetail rede on rede.rede_returnmasterid = rema.rema_returnmasterid 
        left join xw_rede_reqdetail rqd on rqd.rede_reqdetailid = rede.rede_reqdetailid 
        left join xw_rema_reqmaster rqm on rqm.rema_reqmasterid = rqd.rede_reqmasterid 
        left join xw_dept_department d on d.dept_depid  = rema.rema_depid 
        where rede.rede_itemsid = '$itemid' and rema.rema_returndatebs < '$fromdate'  $where_rema_storeid $where_rema_locationid ) A

        UNION
        select sm.sama_billdatead datesad, sm.sama_billdatebs dates, sm.sama_invoiceno description, sm.sama_requisitionno refno, sm.sama_depname Depname, 0 rec_purqty, sade_unitrate rec_rate, 0 as rec_amt, SUM(sd.sade_qty) issueQty, sd.sade_unitrate iss_rate, SUM(sd.sade_qty)  * sd.sade_unitrate issuAmt ,
        'Issue' as rtype
        from xw_sama_salemaster sm  
        left join xw_sade_saledetail sd on sm.sama_salemasterid = sd.sade_salemasterid 
        where sm.sama_st = 'N' and sd.sade_itemsid = '$itemid' and sm.sama_billdatebs >= '$fromdate' AND  sm.sama_billdatebs <='$todate' $where_sama_storeid $where_sama_locationid GROUP BY sd.sade_salemasterid
        UNION ALL
        select tm.trma_transactiondatead datesad, tm.trma_transactiondatebs dates,'OPENING' AS description, 'In-Date' refno, '' as Depname, td.trde_requiredqty rec_purqty, td.trde_unitprice rec_rate, td.trde_requiredqty * td.trde_unitprice as rec_amt, 0 issueQty, 0 iss_rate, 0 issuAmt,  'OPENING' rtype
        from xw_trma_transactionmain tm
        left join xw_trde_transactiondetail td on tm.trma_trmaid = td.trde_trmaid
        where td.trde_transactiontype = 'OPENING' and td.trde_itemsid = '$itemid' and tm.trma_transactiondatebs >= '$fromdate' AND  tm.trma_transactiondatebs <='$todate' $where_trma_storeid $where_trma_locationid
        UNION ALL
        select cm.chma_challanrecdatead datesad, cm.chma_challanrecdatebs dates, concat('Challan-',chma_challannumber) description, chma_challannumber refno, dist_distributor as Depname, cd.chde_qty rec_purqty, 0 rec_rate, 0 as rec_amt, 0 issueQty, 0 iss_rate, 0 issuAmt, 'Challan' rtype
        from xw_chma_challanmaster cm 
        left join xw_chde_challandetails cd on cm.chma_challanmasterid = cd.chde_challanmasterid
        left join xw_dist_distributors dist on cm.chma_supplierid = dist.dist_distributorid 
        left join xw_trma_transactionmain tm on tm.trma_trmaid = cm.chma_mattransmasterid 
        where cd.chde_itemsid = '$itemid' and cm.chma_challanrecdatebs >= '$fromdate' AND cm.chma_challanrecdatebs <='$todate' and chde_receivecomplete = 'N' $where_trma_storeid $where_trma_locationid
        UNION ALL
        select rm.recm_receiveddatead datesad, rm.recm_receiveddatebs dates, 
        concat(recm_invoiceno,'-','O.Date:',pm.puor_orderdatebs) description, concat('Bill No.:',rm.recm_supplierbillno,'- Invoice:',rm.recm_invoiceno) as refno, dist.dist_distributor Depname, rd.recd_purchasedqty rec_purqty, rd.recd_salerate rec_rate, rd.recd_purchasedqty * recd_salerate rec_amt, 0 issueQty, 0 iss_rate, 0 issuAmt ,  'Received' as rtype
        from xw_recm_receivedmaster rm 
        left join xw_recd_receiveddetail rd on rd.recd_receivedmasterid = rm.recm_receivedmasterid 
        left join xw_puor_purchaseordermaster pm on pm.puor_purchaseordermasterid = rm.recm_purchaseordermasterid 
        left join xw_dist_distributors dist on dist_distributorid = rm.recm_supplierid 
        where rd.recd_itemsid = '$itemid' and rm.recm_receiveddatebs >= '$fromdate' AND rm.recm_receiveddatebs<= '$todate' and rm.recm_status <> 'M' $where_recm_storeid $where_recm_locationid
        UNION ALL
        SELECT pr.purr_returndatead datesad, purr_returndatebs dates, concat('Purchase Return -',pr.purr_invoiceno) description, pr.purr_invoiceno as refno, dist.dist_distributor Depname, pd.prde_returnqty rec_purqty, pd.prde_purchaserate rec_ratem, pd.prde_returnqty * pd.prde_purchaserate rec_amt, 0 issueQty, 0 iss_rate, 0 issuAmt,'PR' as rtype from xw_purr_purchasereturn pr 
        left join xw_prde_purchasereturndetail pd on pd.prde_purchasereturnid = pr.purr_purchasereturnid
        left join xw_dist_distributors dist on dist.dist_distributorid = pr.purr_supplierid 
        where pd.prde_itemsid = '$itemid' and pr.purr_returndatebs >= '$fromdate' AND pr.purr_returndatebs <='$todate' and pr.purr_st = 'N' $where_purr_storeid $where_purr_locationid
        UNION ALL 
        select stma_stockdatead datesad, stma_stockdatebs dates, 'STOCK ADJUSTMENT' description,  stma.stma_remarks as refno, '' as Depname, stde.stde_qty rec_purqty, stde.stde_rate rec_rate, stde.stde_qty * stde.stde_rate rec_amt, 0 issueQty, stde_salerate iss_rate, 0 issuAmt , 'Stock_Ad' as rtype
        from xw_stma_stockmaster stma  
        left join xw_stde_stockdetail stde on stde.stde_stockmasterid = stma.stma_stockmassterid 
        where stde.stde_itemsid = '$itemid' AND stma.stma_stockdatebs >= '$fromdate' AND stma.stma_stockdatebs<= '$todate' $where_stma_storeid $where_stma_locationid
        UNION ALL 
        select stma_stockdatead datesad, stma_stockdatebs dates, 'AMOUNT ADJUSTMENT' description,  stma.stma_remarks as refno, '' as Depname, stde.stde_qty rec_purqty, stde.stde_rate rec_rate, stde.stde_adjustamount rec_amt, 0 issueQty, stde_salerate iss_rate, 0 issuAmt ,    'Amount_Adjustement' as rtype
        from xw_stma_stockmaster stma 
        left join xw_stde_stockdetail stde on stde.stde_stockmasterid = stma.stma_stockmassterid 
        where stde.stde_itemsid = '$itemid' AND stma.stma_stockdatebs >= '$fromdate' AND  stma.stma_stockdatebs<='$todate' $where_stma_storeid $where_stma_locationid
        UNION ALL 
        select c.conv_condatead datesad, c.conv_condatebs dates, 'Conversion In' description, 'CI' as refno, '' as Depname, c.conv_childqty rec_purqty, c.conv_childrate rec_rate, c.conv_childqty * c.conv_childrate rec_amt, 0 issueQty, c.conv_childrate iss_rate, 0 issuAmt,        'Conversion_In' as rtype
        from xw_conv_conversion c where c.conv_childid = '$itemid' and c.conv_condatebs >= '$fromdate' AND  c.conv_condatebs<='$todate' $where_conv_storeid $where_conv_locationid
        UNION ALL 
        select c.conv_condatead datesad, c.conv_condatebs dates, 'Conversion Out' description, 'CO' as refno, '' as Depname, 0 rec_purqty, c.conv_parentrate rec_rate, 0 * c.conv_childrate rec_amt, c.conv_parentqty issueQty, c.conv_parentrate iss_rate, c.conv_parentqty * c.conv_parentrate issuAmt,   'Conversion_Out' as rtype
        from xw_conv_conversion c 
        where c.conv_parentid = '$itemid' and c.conv_condatebs >= '$fromdate' AND c.conv_condatebs<= '$todate' $where_conv_storeid $where_conv_locationid
        UNION ALL
        select rema.rema_returndatead datesad, rema.rema_returndatebs dates, concat('RETURN-',rema_invoiceno) description, concat('REQ NO:',rqm.rema_reqno) as refno, d.dept_depname as depname, rede.rede_qty rec_purqty, rede.rede_unitprice rec_rate, 0 rec_amt, 0 issueQty, rede.rede_unitprice iss_rate, rede.rede_total issuAmt ,'Issue_Return' as rtype
        from xw_rema_returnmaster rema 
        left join xw_rede_returndetail rede on rede.rede_returnmasterid = rema.rema_returnmasterid 
        left join xw_rede_reqdetail rqd on rqd.rede_reqdetailid = rede.rede_reqdetailid 
        left join xw_rema_reqmaster rqm on rqm.rema_reqmasterid = rqd.rede_reqmasterid 
        left join xw_dept_department d on d.dept_depid  = rema.rema_depid 
        where rede.rede_itemsid = '$itemid' and rema.rema_returndatebs >= '$fromdate' AND  rema.rema_returndatebs <='$todate' $where_rema_storeid $where_rema_locationid 

UNION
          SELECT '-' as datesad,'9099/12/12' as dates, 'Closing' as description,'-' as refno, '-' as Depname,   SUM(rec_purqty) rec_purqty, 0 rec_rate, 0 as rec_amt, SUM(issueQty) issueQty , 0 iss_rate, 0 issuAmt,'Closing'  rtype  FROM(
        select sm.sama_billdatead datesad, sm.sama_billdatebs dates, sm.sama_invoiceno description, sm.sama_requisitionno refno, concat(sm.sama_depname,'-',sm.sama_receivedby) Depname, 0 rec_purqty, sade_unitrate rec_rate, 0 as rec_amt, sd.sade_qty issueQty, sd.sade_unitrate iss_rate, sd.sade_qty * sd.sade_unitrate issuAmt 
        from xw_sama_salemaster sm  
        left join xw_sade_saledetail sd on sm.sama_salemasterid = sd.sade_salemasterid 
        where sm.sama_st = 'N' and sd.sade_itemsid = '$itemid' and sm.sama_billdatebs > '$todate'  $where_sama_storeid $where_sama_locationid
        UNION ALL
        select tm.trma_transactiondatead datesad, tm.trma_transactiondatebs dates,'OPENING' AS description, 'In-Date' refno, '' as Depname, td.trde_requiredqty rec_purqty, td.trde_unitprice rec_rate, td.trde_requiredqty * td.trde_unitprice as rec_amt, 0 issueQty, 0 iss_rate, 0 issuAmt 
        from xw_trma_transactionmain tm
        left join xw_trde_transactiondetail td on tm.trma_trmaid = td.trde_trmaid
        where td.trde_transactiontype = 'OPENING' and td.trde_itemsid = '$itemid' and tm.trma_transactiondatebs > '$todate'  $where_trma_storeid $where_trma_locationid
        UNION ALL
        select cm.chma_challanrecdatead datesad, cm.chma_challanrecdatebs dates, concat('Challan-',chma_challannumber) description, chma_challannumber refno, dist_distributor as Depname, cd.chde_qty rec_purqty, 0 rec_rate, 0 as rec_amt, 0 issueQty, 0 iss_rate, 0 issuAmt
        from xw_chma_challanmaster cm 
        left join xw_chde_challandetails cd on cm.chma_challanmasterid = cd.chde_challanmasterid
        left join xw_dist_distributors dist on cm.chma_supplierid = dist.dist_distributorid 
        left join xw_trma_transactionmain tm on tm.trma_trmaid = cm.chma_mattransmasterid 
        where cd.chde_itemsid = '$itemid' and cm.chma_challanrecdatebs > '$todate'  and chde_receivecomplete = 'N' $where_trma_storeid $where_trma_locationid
        UNION ALL
        select rm.recm_receiveddatead datesad, rm.recm_receiveddatebs dates, 
        concat(recm_invoiceno,'-','O.Date:',pm.puor_orderdatebs) description, rm.recm_supplierbillno as refno, dist.dist_distributor Depname, rd.recd_purchasedqty rec_purqty, rd.recd_salerate rec_rate, rd.recd_purchasedqty * recd_salerate rec_amt, 0 issueQty, 0 iss_rate, 0 issuAmt 
        from xw_recm_receivedmaster rm 
        left join xw_recd_receiveddetail rd on rd.recd_receivedmasterid = rm.recm_receivedmasterid 
        left join xw_puor_purchaseordermaster pm on pm.puor_purchaseordermasterid = rm.recm_purchaseordermasterid 
        left join xw_dist_distributors dist on dist_distributorid = rm.recm_supplierid 
        where rd.recd_itemsid = '$itemid' and rm.recm_receiveddatebs > '$todate'  and rm.recm_status <> 'M' $where_recm_storeid $where_recm_locationid
        UNION ALL
        SELECT pr.purr_returndatead datesad, purr_returndatebs dates, concat('Purchase Return -',pr.purr_invoiceno) description, pr.purr_invoiceno as refno, dist.dist_distributor Depname, pd.prde_returnqty rec_purqty, pd.prde_purchaserate rec_ratem, pd.prde_returnqty * pd.prde_purchaserate rec_amt, 0 issueQty, 0 iss_rate, 0 issuAmt from xw_purr_purchasereturn pr 
        left join xw_prde_purchasereturndetail pd on pd.prde_purchasereturnid = pr.purr_purchasereturnid
        left join xw_dist_distributors dist on dist.dist_distributorid = pr.purr_supplierid 
        where pd.prde_itemsid = '$itemid' and pr.purr_returndatebs > '$todate'  and pr.purr_st = 'N' $where_purr_storeid $where_purr_locationid
        UNION ALL 
        select stma_stockdatead datesad, stma_stockdatebs dates, 'STOCK ADJUSTMENT' description,  stma.stma_remarks as refno, '' as Depname, stde.stde_qty rec_purqty, stde.stde_rate rec_rate, stde.stde_qty * stde.stde_rate rec_amt, 0 issueQty, stde_salerate iss_rate, 0 issuAmt 
        from xw_stma_stockmaster stma  
        left join xw_stde_stockdetail stde on stde.stde_stockmasterid = stma.stma_stockmassterid 
        where stde.stde_itemsid = '$itemid' AND stma.stma_stockdatebs > '$todate'  $where_stma_storeid $where_stma_locationid
        UNION ALL 
        select stma_stockdatead datesad, stma_stockdatebs dates, 'AMOUNT ADJUSTMENT' description,  stma.stma_remarks as refno, '' as Depname, stde.stde_qty rec_purqty, stde.stde_rate rec_rate, stde.stde_adjustamount rec_amt, 0 issueQty, stde_salerate iss_rate, 0 issuAmt 
        from xw_stma_stockmaster stma 
        left join xw_stde_stockdetail stde on stde.stde_stockmasterid = stma.stma_stockmassterid 
        where stde.stde_itemsid = '$itemid' AND stma.stma_stockdatebs > '$todate'  $where_stma_storeid $where_stma_locationid
        UNION ALL 
        select c.conv_condatead datesad, c.conv_condatebs dates, 'Conversion In' description, 'CI' as refno, '' as Depname, c.conv_childqty rec_purqty, c.conv_childrate rec_rate, c.conv_childqty * c.conv_childrate rec_amt, 0 issueQty, c.conv_childrate iss_rate, 0 issuAmt 
        from xw_conv_conversion c where c.conv_childid = '$itemid' and c.conv_condatebs > '$todate'  $where_conv_storeid $where_conv_locationid
        UNION ALL 
        select c.conv_condatead datesad, c.conv_condatebs dates, 'Conversion Out' description, 'CO' as refno, '' as Depname, 0 rec_purqty, c.conv_parentrate rec_rate, 0 * c.conv_childrate rec_amt, c.conv_parentqty issueQty, c.conv_parentrate iss_rate, c.conv_parentqty * c.conv_parentrate issuAmt 
        from xw_conv_conversion c 
        where c.conv_parentid = '$itemid' and c.conv_condatebs > '$todate'  $where_conv_storeid $where_conv_locationid
        UNION ALL
        select rema.rema_returndatead datesad, rema.rema_returndatebs dates, concat('RETURN-',rema_invoiceno) description, concat('REQ NO:',rqm.rema_reqno) as refno, d.dept_depname as depname, rede.rede_qty rec_purqty, rede.rede_unitprice rec_rate, 0 rec_amt, 0 issueQty, rede.rede_unitprice iss_rate, rede.rede_total issuAmt 
        from xw_rema_returnmaster rema 
        left join xw_rede_returndetail rede on rede.rede_returnmasterid = rema.rema_returnmasterid 
        left join xw_rede_reqdetail rqd on rqd.rede_reqdetailid = rede.rede_reqdetailid 
        left join xw_rema_reqmaster rqm on rqm.rema_reqmasterid = rqd.rede_reqmasterid 
        left join xw_dept_department d on d.dept_depid  = rema.rema_depid 
        where rede.rede_itemsid = '$itemid' and rema.rema_returndatebs > '$todate'  $where_rema_storeid $where_rema_locationid ) 
B

    ) X  ORDER BY X.dates ASC,'Closing' ASC ";
       
        $query = $this->db->query($sql);
        // echo $this->db->last_query();die;        
        if($query->num_rows() > 0) 
        {
            $data=$query->result();     
            return $data;       
        }       
        return false;
    }

    public function get_ledger_report_kukl($cond = false){
        if($cond) {
            $this->db->where($cond);
        }

        $fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
        $locationid = $this->input->post('locationid');

        $storeid = $this->input->post('store_id');
        $itemid = $this->input->post('itemid');

        $where_sama_storeid = $where_trma_storeid = $where_recm_storeid = $where_purr_storeid = $where_conv_storeid = $where_stma_storeid = $where_rema_storeid = "";

        $where_sama_locationid = $where_trma_locationid = $where_recm_locationid = $where_purr_locationid  = $where_stma_locationid = $where_conv_locationid = $where_rema_locationid = "";

        if($storeid){
            $where_sama_storeid = "AND sm.sama_storeid = '$storeid'";
            $where_trma_storeid = "AND tm.trma_fromdepartmentid = '$storeid'";
            $where_recm_storeid = "AND (rm.recm_storeid = '$storeid' OR rm.recm_departmentid = '$storeid')";
            $where_purr_storeid = "AND (pr.purr_storeid = '$storeid' OR pr.purr_departmentid = '$storeid')";
            $where_rema_storeid = "AND rm.rema_storeid = '$storeid'";
        }
        if( $this->location_ismain=='Y'){
            if(!empty($locationid)){
                $where_hand_income_location=" AND hm.haov_tolocationid = '$locationid'";
                $where_recm_locationid = " AND rm.recm_locationid = '$locationid'";
                $where_rema_locationid = " AND rm.rema_locationid = '$locationid'";
                $where_sama_locationid = " AND sm.sama_locationid = '$locationid'";
                $where_hand_exp_location=" AND haov_fromlocationid = '$locationid'";
                $where_trma_locationid = " AND tm.trma_locationid = '$locationid'";

            }
            else{
                $where_hand_income_location = "";
                $where_recm_locationid = "";
                $where_rema_locationid = "";
                $where_sama_locationid = "";
                $where_hand_exp_location = "";
                $where_trma_locationid = "";
               
            }
        }
        else{
           $where_hand_income_location=" AND hm.haov_tolocationid = '$this->locationid'";
                $where_recm_locationid = " AND rm.recm_locationid = '$this->locationid'";
                $where_rema_locationid = " AND rm.rema_locationid = '$this->locationid'";
                $where_sama_locationid = " AND sm.sama_locationid = '$this->locationid'";
                $where_hand_exp_location=" AND haov_fromlocationid = '$this->locationid'";
                $where_trma_locationid = " AND tm.trma_locationid = '$this->locationid'";  
    }

// $sql_opening="SELECT date,'Opening' as description,
//         SUM(hqty) hqty,SUM(hdr_amount)hdr_amount,SUM(pqty) pqty,SUM(pur_amount)pur_amount,SUM(ret_qty)ret_qty,SUM(ret_amount)ret_amount,SUM(hoqty)hoqty,SUM(hrdo_amount)hrdo_amount,
//         SUM(iss_qty)iss_qty ,SUM(iss_amt)iss_amt FROM(
//         SELECT
//             '2000/01/01' AS date,
//             'Opening' description,
//             SUM(hd.haod_qty) as hqty,
//             SUM(
//                 hd.haod_qty * hd.haod_unitprice
//             ) AS hdr_amount,
//         0 as pqty,
//         0 as pur_amount,
//         0 as ret_qty,
//         0 as ret_amount,
//         0 as hoqty,
//         0 as hrdo_amount,
//         0 as iss_qty,
//         0 as iss_amt
//         FROM
//             xw_haov_handovermaster hm
//         LEFT JOIN xw_haod_handoverdetail hd ON hd.haod_handovermasterid = hm.haov_handovermasterid
//         WHERE
//             hm.haov_status = 'O' $where_hand_income_location
//         AND hm.haov_handoverdatebs < '".$fromdate."'
//         UNION
//         SELECT
//            '2000/01/01' AS date,
//             'Opening' description,
//             0 AS hqty,
//             0 as hdr_amount,
//             SUM(rd.recd_purchasedqty) pqty,
//             SUM(rd.recd_purchasedqty* rd.recd_arate) as pur_amount,
//             0 as ret_qty,
//             0 as ret_amount,
//             0 as hoqty,
//             0 as hrdo_amount,
//             0 as iss_qty,
//             0 as iss_amt
//         FROM
//             xw_recm_receivedmaster rm
//         LEFT JOIN xw_recd_receiveddetail rd ON rd.recd_receivedmasterid = rm.recm_receivedmasterid
//         WHERE
//             rm.recm_status <> 'M' $where_recm_locationid 
//         AND recm_receiveddatebs < '".$fromdate."'
//         UNION 
//         SELECT
//         '2000/01/01'AS date,
//         'Opening' description,
//         0 as hqty,
//         0 as hdr_amount,
//         0 as pqty,
//         0 as pur_amount,
//         SUM(rede_qty) as ret_qty,
//         SUM(rd.rede_unitprice * rede_qty) ret_amount,
//         0 as hoqty,
//         0 as hrdo_amount,
//         0 as iss_qty,
//         0 as iss_amt
//         FROM
//             xw_rema_returnmaster rm
//         LEFT JOIN xw_rede_returndetail rd ON rd.rede_returnmasterid = rm.rema_returnmasterid
//         WHERE
//             rm.rema_st <> 'C'  $where_rema_locationid
//         AND rm.rema_returndatebs < '".$fromdate."'
//         UNION
//         SELECT
//         '2000/01/01' AS date,
//         'Opening' description,
//         0 AS hqty,
//         0 AS hdr_amount,
//         0 AS pqty,
//         0 AS pur_amount,
//         0 AS ret_qty,
//         0 as ret_amount,
//         SUM(hd.haod_qty) AS hoqty,
//         SUM(hd.haod_qty * hd.haod_unitprice) AS hdro_amount,
//         0 AS iss_qty,
//         0 AS iss_amt
//         FROM
//             xw_haov_handovermaster hm
//         LEFT JOIN xw_haod_handoverdetail hd ON hd.haod_handovermasterid = hm.haov_handovermasterid
//         WHERE
//             hm.haov_status = 'O'  $where_hand_exp_location
//         AND hm.haov_handoverdatebs < '".$fromdate."'
//         UNION
//         SELECT
//             '2000/01/01' AS date,
//             'Opening' description,
//             0 as hqty,
//             0 as hdr_amount,
//             0 as pqty,
//             0 as pur_amount,
//             0 as ret_qty,
//             0 ret_amount,
//             0 as hoqty,
//             0 as hrdo_amount,
//             SUM(sd.sade_qty) as iss_qty,
//             SUM(
//                 sd.sade_qty * sade_unitrate
//             ) AS isamt
//         FROM
//             xw_sama_salemaster sm
//         INNER JOIN xw_sade_saledetail sd ON sd.sade_salemasterid = sm.sama_salemasterid
//         WHERE
//             sm.sama_ishandover = 'N'
//         AND sm.sama_status = 'O' $where_sama_locationid
//         AND sm.sama_billdatebs < '".$fromdate."'
//         ) Y";

        // echo $sql_opening;
        // die();

$sql_opening="SELECT '2000/01/01' AS date,
            'Opening' description,
            0 AS hqty,
            0 as hdr_amount,
            SUM(recqty-curissqty) as pqty,
                        SUM(recamt/recqty)* SUM(recqty-curissqty) as recamt,
            0 as ret_qty,
            0 as ret_amount,
            0 as hoqty,
            0 as hrdo_amount,
            0 as iss_qty,
            0 as iss_amt
        FROM (
        SELECT SUM(trde_requiredqty) as recqty, SUM(trde_requiredqty* trde_unitprice) as recamt, SUM(trde_issueqty) curstockqty,
        (SELECT IFNULL(SUM(sade_curqty),0) sade_curqty from 
        xw_sama_salemaster sm INNER JOIN
        xw_sade_saledetail sd on sd.sade_salemasterid=sm.sama_salemasterid
        INNER JOIN xw_trde_transactiondetail tdi on tdi.trde_trdeid=sd.sade_mattransdetailid
                WHERE sm.sama_billdatebs <  '".$fromdate."' AND sm.sama_status = 'O' AND sd.sade_itemsid= $itemid AND tdi.trde_trdeid=td.trde_trdeid $where_sama_locationid  ) as curissqty
         FROM xw_trma_transactionmain tm INNER JOIN  xw_trde_transactiondetail td on td.trde_trmaid=tm.trma_trmaid
            WHERE  td.trde_itemsid= $itemid AND tm.trma_transactiondatebs < '".$fromdate."' $where_trma_locationid  )  X";

    $sql_middle = "SELECT date,GROUP_CONCAT(description) as description,
        SUM(hqty) hqty,SUM(hdr_amount)hdr_amount,SUM(pqty) pqty,SUM(pur_amount)pur_amount,SUM(ret_qty)ret_qty,SUM(ret_amount)ret_amount,SUM(hoqty)hoqty,SUM(hrdo_amount)hrdo_amount,
        SUM(iss_qty)iss_qty ,SUM(iss_amt)iss_amt FROM(
        SELECT
            hm.haov_handoverdatebs AS date,
        GROUP_CONCAT(CONCAT('HDR:',haov_handoverno)) description,
            SUM(hd.haod_qty) as hqty,
            SUM(
                hd.haod_qty * hd.haod_unitprice
            ) AS hdr_amount,
        0 as pqty,
        0 as pur_amount,
        0 as ret_qty,
        0 as ret_amount,
        0 as hoqty,
        0 as hrdo_amount,
        0 as iss_qty,
        0 as iss_amt
        FROM
            xw_haov_handovermaster hm
        LEFT JOIN xw_haod_handoverdetail hd ON hd.haod_handovermasterid = hm.haov_handovermasterid
        WHERE
            hm.haov_status = 'O' $where_hand_income_location
        AND hm.haov_handoverdatebs >= '".$fromdate."'
        AND hm.haov_handoverdatebs <= '".$todate."'
        AND hd.haod_itemsid= $itemid
        GROUP BY
            hm.haov_handoverdatebs
        UNION
       SELECT trma_transactiondatebs AS date,
                    'Opening/Purchase' AS description,
                    0 AS hqty,
                    0 AS hdr_amount,
                    SUM(td.trde_requiredqty) pqty,
                    SUM(
                        td.trde_requiredqty * td.trde_unitprice
                    ) AS pur_amount,
                    0 AS ret_qty,
                    0 AS ret_amount,
                    0 AS hoqty,
                    0 AS hrdo_amount,
                    0 AS iss_qty,
                    0 AS iss_amt FROM xw_trma_transactionmain tm
        INNER JOIN xw_trde_transactiondetail td ON td.trde_trmaid = tm.trma_trmaid WHERE
                tm.trma_status <> 'M'
                $where_trma_locationid 
                AND tm.trma_transactiondatebs >= '".$fromdate."'
                AND tm.trma_transactiondatebs <= '".$todate."' AND td.trde_itemsid = $itemid
                AND (tm.trma_transactiontype='OPENING' ||tm.trma_transactiontype='PURCHASE')
                GROUP BY
                    tm.trma_transactiondatebs
        UNION 
        SELECT
            rm.rema_returndatebs AS date,
            GROUP_CONCAT(CONCAT('RT:',rm.rema_invoiceno)) as description,
            0 as hqty,
            0 as hdr_amount,
            0 as pqty,
            0 as pur_amount,
            SUM(rede_qty) as ret_qty,
            SUM(rd.rede_unitprice * rede_qty) ret_amount,
        0 as hoqty,
        0 as hrdo_amount,
        0 as iss_qty,
        0 as iss_amt
        FROM
            xw_rema_returnmaster rm
        INNER JOIN xw_rede_returndetail rd ON rd.rede_returnmasterid = rm.rema_returnmasterid
        WHERE
            rm.rema_st <> 'C'  $where_rema_locationid
        AND rm.rema_returndatebs >= '".$fromdate."'
        AND rm.rema_returndatebs <= '".$todate."'
        AND rd.rede_itemsid =$itemid
        GROUP BY rm.rema_returndatebs
        UNION
        SELECT
        hm.haov_handoverdatebs AS date,
        GROUP_CONCAT(CONCAT('HDR:',haov_handoverno)) description,
            SUM(hd.haod_qty) as hoqty,
            SUM(hd.haod_qty * hd.haod_unitprice) AS hdro_amount,
         0 as hqty,
            0 as hdr_amount,
            0 as pqty,
            0 as pur_amount,
            0 as ret_qty,
            0 ret_amount,
        0 as iss_qty,
        0 as iss_amt
        FROM
            xw_haov_handovermaster hm
        LEFT JOIN xw_haod_handoverdetail hd ON hd.haod_handovermasterid = hm.haov_handovermasterid
        WHERE
            hm.haov_status = 'O'  $where_hand_exp_location
        AND hm.haov_handoverdatebs >= '".$fromdate."'
        AND hm.haov_handoverdatebs <= '".$todate."'
        AND hd.haod_itemsid =$itemid
        GROUP BY hm.haov_handoverdatebs
        UNION
        SELECT
            sama_billdatebs AS date,
        GROUP_CONCAT(CONCAT('IS:',sm.sama_invoiceno)) description,
        0 as hqty,
            0 as hdr_amount,
            0 as pqty,
            0 as pur_amount,
            0 as ret_qty,
            0 ret_amount,
        0 as hoqty,
        0 as hrdo_amount,
            SUM(sd.sade_qty) as iss_qty,
            SUM(
                sd.sade_qty * sade_unitrate
            ) AS isamt 
            FROM
            xw_sama_salemaster sm
        INNER JOIN xw_sade_saledetail sd ON sd.sade_salemasterid = sm.sama_salemasterid
        WHERE
            sm.sama_ishandover = 'N'
        AND sm.sama_status = 'O' $where_sama_locationid
        AND sm.sama_billdatebs >= '".$fromdate."'
        AND sm.sama_billdatebs <= '".$todate."'
        AND sd.sade_itemsid=$itemid
        GROUP BY sm.sama_billdatebs
        ) X GROUP BY X.date ";

        // echo $sql_middle;
        // die();

        $sql=$sql_opening.' UNION '.$sql_middle;

        // echo $sql;
        // die();
       
        $query = $this->db->query($sql);
        // echo $this->db->last_query();die;        
        if($query->num_rows() > 0) 
        {
            $data=$query->result();     
            return $data;       
        }       
        return false;
    }
}