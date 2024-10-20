<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Stock_requirement_mdl extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->curtime = $this->general->get_currenttime();
        $this->userid  = $this->session->userdata(USER_ID);
        $this->mac     = $this->general->get_Mac_Address();
        $this->ip      = $this->general->get_real_ipaddr();
    }

    public $validate_settings_distributors = array(
        array(
            'field' => 'dist_distributor', 'label' => 'Distributor Name', 'rules' => 'trim|required|xss_clean'), 
        array('field' => 'dist_phone1', 'label' => 'Phone 1', 'rules' => 'trim|required|xss_clean'), 
        array('field' => 'dist_email', 'label' => 'Email', 'rules' => 'trim|valid_email|xss_clean'), 
        array('field' => 'dist_repemail', 'label' => 'Sales Resp. Email', 'rules' => 'trim|valid_email|xss_clean'));

    public function get_stock_requirement_list($frmDate = false){
        $curdate = CURDATE_NP;

        $fromdate1 = $frmDate.'/01';
        $todate1 = $frmDate.'/32';

        $date = explode('/',$frmDate);
        $year = !empty($date[0])?$date[0]:'';
        $month = !empty($date[1])?$date[1]:'';

        $month2 = $month3 = $year2 = $year3 = $fromdate2 = $fromdate3 = $todate2 = $todate3 = '';

        if($month == '01'){
            $month2 = '11';
            $month3 = '12';

            $year2 = $year3 = $year-1;
        }else if($month == '02'){
            $month2 = '12';
            $year2 = $year;

            $month3 = '01';
            $year3 = $year-1;
        }else{
            $month2 = $month-2;
            $month3 = $month-1;

            if($month2 < 10){
                $month2 = sprintf("%02d", $month2);
            }

            if($month3 < 10){
                $month3 = sprintf("%02d", $month3);
            }

            $year2 = $year3 = $year;
        }

        if($year2 && $month2){
            $fromdate2 = $year2.'/'.$month2.'/'.'01';
            $todate2 = $year2.'/'.$month2.'/'.'32';    
        }
        
        if($year3 && $month3){
            $fromdate3 = $year3.'/'.$month3.'/'.'01';
            $todate3 = $year3.'/'.$month3.'/'.'32';
        }

        // print_r($fromdate2);
        // print_r($todate2);

        //  print_r($fromdate3);
        // print_r($todate3);
        // die();

        $sql = "SELECT DISTINCT
            (il.itli_itemlistid) AS itemid,
            il.itli_itemcode AS itemcode,
            il.itli_itemname AS itemname,
            il.itli_itemnamenp AS itemnamenp,

            ec.eqca_category AS categoryname,
            il.itli_purchaserate AS purchaserate,
            (
                IFNULL(
                    (
                        SELECT
                            sum(recd_purchasedqty)
                        FROM
                            xw_recm_receivedmaster rm,
                            xw_recd_receiveddetail rd
                        WHERE
                            rm.recm_receivedmasterid = rd.recd_receivedmasterid
                        AND rm.recm_status = 'O'
                        AND rd.recd_itemsid = il.itli_itemlistid
                        AND rm.recm_receiveddatebs < '$curdate'
                    ),
                    0
                ) - IFNULL(
                    (
                        SELECT
                            sum(sade_qty)
                        FROM
                            xw_sama_salemaster sm,
                            xw_sade_saledetail sd
                        WHERE
                            sm.sama_salemasterid = sd.sade_salemasterid
                        AND sd.sade_itemsid = il.itli_itemlistid
                        AND sm.sama_st = 'N'
                        AND sm.sama_billdatebs < '$curdate'
                    ),
                    0
                ) - IFNULL(
                    (
                        SELECT
                            sum(prde_returnqty)
                        FROM
                            xw_purr_purchasereturn pr,
                            xw_prde_purchasereturndetail prd
                        WHERE
                            pr.purr_purchasereturnid = prd.prde_purchasereturnid
                        AND prd.prde_itemsid = il.itli_itemlistid
                        AND pr.purr_returndatebs < '$curdate'
                    ),
                    0
                ) + IFNULL(
                    (
                        SELECT
                            sum(rede_qty)
                        FROM
                            xw_rema_returnmaster rm,
                            xw_rede_returndetail rd
                        WHERE
                            rm.rema_returnmasterid = rd.rede_returnmasterid
                        AND rd.rede_itemsid = il.itli_itemlistid
                        AND rm.rema_st = 'N'
                        AND rm.rema_returndatebs < '$curdate'
                    ),
                    0
                ) + IFNULL(
                    (
                        SELECT
                            sum(trde_requiredqty)
                        FROM
                            xw_trma_transactionmain mtm,
                            xw_trde_transactiondetail mtd
                        WHERE
                            mtm.trma_trmaid = mtd.trde_trmaid
                        AND mtd.trde_itemsid = il.itli_itemlistid
                        AND mtm.trma_status = 'O'
                        AND lower(mtm.trma_transactiontype) = 'opening'
                        AND mtd.trde_transactiondatebs < '$curdate'
                    ),
                    0
                ) + IFNULL(
                    (
                        SELECT
                            sum(stde_qty)
                        FROM
                            xw_stde_stockdetail sd
                        WHERE
                            sd.stde_itemsid = il.itli_itemlistid
                            AND stde_adjustdatebs < '$curdate'
                    ),
                    0
                )
            ) op_qty,
            (
                IFNULL(
                    (
                        SELECT
                            SUM(sade_qty)
                        FROM
                            xw_sama_salemaster sm,
                            xw_sade_saledetail sd
                        WHERE
                            sm.sama_salemasterid = sd.sade_salemasterid
                            AND sm.sama_billdatebs BETWEEN '$fromdate1' AND '$todate1'
                        AND sm.sama_st = 'N'
                        AND sd.sade_itemsid = il.itli_itemlistid
                    ),
                    0
                ) - IFNULL(
                    (
                        SELECT
                            SUM(rede_qty)
                        FROM
                            xw_rema_returnmaster rm,
                            xw_rede_returndetail rd
                        WHERE
                            rm.rema_returnmasterid = rd.rede_returnmasterid
                            AND rm.rema_returndatebs BETWEEN '$fromdate1' AND '$todate1'
                        AND rm.rema_st = 'N'
                        AND rd.rede_itemsid = il.itli_itemlistid
                    ),
                    0
                )
            ) issue_qty,
            (
                IFNULL(
                    (
                        SELECT
                            SUM(recd_purchasedqty)
                        FROM
                            xw_recm_receivedmaster rm,
                            xw_recd_receiveddetail rd
                        WHERE
                            rm.recm_receivedmasterid = rd.recd_receivedmasterid
                            AND rm.recm_receiveddatebs BETWEEN '$fromdate1' ANd '$todate1'
                        AND rm.recm_status = 'O'
                        AND rd.recd_itemsid = il.itli_itemlistid
                    ),
                    0
                ) - IFNULL(
                    (
                        SELECT
                            SUM(prde_returnqty)
                        FROM
                            xw_purr_purchasereturn pr,
                            xw_prde_purchasereturndetail prd
                        WHERE
                            pr.purr_purchasereturnid = prd.prde_purchasereturnid
                            AND pr.purr_returndatebs BETWEEN '$fromdate1' ANd '$todate1'
                        AND prd.prde_itemsid = il.itli_itemlistid
                    ),
                    0
                )
            ) rec_qty,
            IFNULL(
                (
                    SELECT
                        SUM(rede_qty)
                    FROM
                        xw_rema_reqmaster rm,
                        xw_rede_reqdetail rd
                    WHERE
                        rm.rema_reqmasterid = rd.rede_reqmasterid
                        AND rema_reqdatebs BETWEEN '$fromdate1' ANd '$todate1'
                    AND rm.rema_received = '0'
                    AND rd.rede_itemsid = il.itli_itemlistid
                ),
                0
            ) req_qty,
            (
                IFNULL(
                    (
                        SELECT
                            SUM(sade_qty * sade_unitrate)
                        FROM
                            xw_sama_salemaster sm,
                            xw_sade_saledetail sd
                        WHERE
                            sm.sama_salemasterid = sd.sade_salemasterid
                            AND sm.sama_billdatebs BETWEEN '$fromdate1' ANd '$todate1'
                        AND sm.sama_st = 'N'
                        AND sd.sade_itemsid = il.itli_itemlistid
                    ),
                    0
                ) - IFNULL(
                    (
                        SELECT
                            SUM(rede_total)
                        FROM
                            xw_rema_returnmaster rm,
                            xw_rede_returndetail rd
                        WHERE
                            rm.rema_returnmasterid = rd.rede_returnmasterid
                            AND rm.rema_st='N' 
                            AND rm.rema_returndatebs BETWEEN '$fromdate1' ANd '$todate1'
                        AND rd.rede_itemsid = il.itli_itemlistid
                    ),
                    0
                )
            ) cmonth1,
            (
                IFNULL(
                    (
                        SELECT
                            SUM(sade_qty * sade_unitrate)
                        FROM
                            xw_sama_salemaster sm,
                            xw_sade_saledetail sd
                        WHERE
                            sm.sama_salemasterid = sd.sade_salemasterid
                            AND sm.sama_billdatebs BETWEEN '$fromdate2' ANd '$todate2'
                        AND sm.sama_st = 'N'
                        AND sd.sade_itemsid = il.itli_itemlistid
                    ),
                    0
                ) - IFNULL(
                    (
                        SELECT
                            SUM(rede_total)
                        FROM
                            xw_rema_returnmaster rm,
                            xw_rede_returndetail rd
                        WHERE
                            rm.rema_returnmasterid = rd.rede_returnmasterid
                            AND rm.rema_st='N' 
                            AND rm.rema_returndatebs BETWEEN '$fromdate2' ANd '$todate2'
                        AND rd.rede_itemsid = il.itli_itemlistid
                    ),
                    0
                )
            ) cmonth2,
            (
                IFNULL(
                    (
                        SELECT
                            SUM(sade_qty * sade_unitrate)
                        FROM
                            xw_sama_salemaster sm,
                            xw_sade_saledetail sd
                        WHERE
                            sm.sama_salemasterid = sd.sade_salemasterid
                            AND sm.sama_billdatebs BETWEEN '$fromdate3' ANd '$todate3'
                        AND sm.sama_st = 'N'
                        AND sd.sade_itemsid = il.itli_itemlistid
                    ),
                    0
                ) - IFNULL(
                    (
                        SELECT
                            SUM(rede_total)
                        FROM
                            xw_rema_returnmaster rm,
                            xw_rede_returndetail rd
                        WHERE
                            rm.rema_returnmasterid = rd.rede_returnmasterid
                        AND rm.rema_st = 'N'
                        AND rm.rema_returndatebs BETWEEN '$fromdate3' ANd '$todate3'
                        AND rd.rede_itemsid = il.itli_itemlistid
                    ),
                    0
                )
            ) cmonth3,
            (
                IFNULL(
                    (
                        SELECT
                            SUM(sade_qty)
                        FROM
                            xw_sama_salemaster sm,
                            xw_sade_saledetail sd
                        WHERE
                            sm.sama_salemasterid = sd.sade_salemasterid
                            AND sm.sama_billdatebs BETWEEN '$fromdate2' ANd '$todate2'
                        AND sm.sama_st = 'N'
                        AND sd.sade_itemsid = il.itli_itemlistid
                    ),
                    0
                ) - IFNULL(
                    (
                        SELECT
                            SUM(rd.rede_qty)
                        FROM
                            xw_rema_returnmaster rm,
                            xw_rede_returndetail rd
                        WHERE
                            rm.rema_returnmasterid = rd.rede_returnmasterid
                            AND rm.rema_returndatebs BETWEEN '$fromdate2' ANd '$todate2'
                        AND rm.rema_st = 'N'
                        AND rd.rede_itemsid = il.itli_itemlistid
                    ),
                    0
                )
            ) cmonth2_qty,
            (
                IFNULL(
                    (
                        SELECT
                            SUM(sade_qty)
                        FROM
                            xw_sama_salemaster sm,
                            xw_sade_saledetail sd
                        WHERE
                            sm.sama_salemasterid = sd.sade_salemasterid
                            AND sm.sama_billdatebs BETWEEN '$fromdate3' ANd '$todate3'
                        AND sm.sama_st = 'N'
                        AND sd.sade_itemsid = il.itli_itemlistid
                    ),
                    0
                ) - IFNULL(
                    (
                        SELECT
                            SUM(rd.rede_qty)
                        FROM
                            xw_rema_returnmaster rm,
                            xw_rede_returndetail rd
                        WHERE
                            rm.rema_returnmasterid = rd.rede_returnmasterid
                        AND rm.rema_st = 'N'
                        AND rm.rema_returndatebs BETWEEN '$fromdate3' ANd '$todate3'
                        AND rd.rede_itemsid = il.itli_itemlistid
                    ),
                    0
                )
            ) cmonth3_qty
        FROM
            xw_itli_itemslist il,
            xw_eqca_equipmentcategory ec,
            xw_trde_transactiondetail mtd
        WHERE
            il.itli_catid = ec.eqca_equipmentcategoryid
        AND il.itli_itemlistid = mtd.trde_itemsid
        AND (
            mtd.trde_trdeid IN (
                SELECT
                    trde_trdeid
                FROM
                    xw_sama_salemaster sm,
                    xw_sade_saledetail sd
                WHERE
                    sm.sama_salemasterid = sd.sade_salemasterid
                AND sm.sama_st = 'N'
                AND sm.sama_billdatebs BETWEEN '$fromdate3' AND '$todate1'
            )
        )
        AND IL.itli_itemlistid NOT IN (
            SELECT DISTINCT
                (rede_itemsid)
            FROM
                xw_rema_reqmaster rqm,
                xw_rede_reqdetail rqd
            WHERE
                rqm.rema_reqdatebs BETWEEN '$fromdate3' AND '$todate1'
            AND rqm.rema_reqmasterid = rqd.rede_reqmasterid
        ) ORDER BY ec.eqca_category ASC
        ";

        $query = $this->db->query($sql);

        // echo $this->db->last_query();
        // die();

        if ($query->num_rows() > 0) 
        {
            $data=$query->result();     
            return $data;       
        }       
        return false;
    }
}