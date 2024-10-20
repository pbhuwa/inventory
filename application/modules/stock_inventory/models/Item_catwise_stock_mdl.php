<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Item_catwise_stock_mdl extends CI_Model
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

    public function get_item_catwise_stock_list($cond = false)
    {
        $get = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }

    if(!empty($get['sSearch_1'])){
            $this->db->where("trma_issueno like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("eqty_equipmenttype like  '%".$get['sSearch_2']."%'  ");
        }

        if(!empty($get['sSearch_5'])){
            $this->db->where("trma_fromby like  '%".$get['sSearch_5']."%'  ");
        }

        if(!empty($get['sSearch_6'])){
            $this->db->where("trma_receivedby like  '%".$get['sSearch_6']."%'  ");
        }
        
        if($cond) {
            $this->db->where($cond);
        }

        $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');
        $toDate = CURDATE_NP;

        if($frmDate &&  $toDate){
            if(DEFAULT_DATEPICKER=='NP')
            {
              $this->db->where('mtm.trma_transactiondatebs >=', $frmDate);
              $this->db->where('mtm.trma_transactiondatebs <=', $toDate);
            }
            else
            {
              $this->db->where('mtm.trma_transactiondatead >=', $frmDate);
              $this->db->where('mtm.trma_transactiondatead <=', $toDate);
            }
        }

        $resltrpt=$this->db->select("COUNT(*) as cnt")
                    ->from('trma_transactionmain mtm')
                    ->join('eqty_equipmenttype et','et.eqty_equipmenttypeid = mtm.trma_fromdepartmentid','left')
                    ->join('trde_transactiondetail mtd','mtm.trma_trmaid = mtd.trde_trmaid','left')
                    ->where("trma_received",'1')
                    ->where("trma_todepartmentid",'1')
                    ->where("trma_transactiontype",'issue')
                    ->where("trma_status",'O')
                    ->where("trma_received",'1')
                    ->group_by('mtm.trma_transactiondatebs, mtm.trma_transactiontype, mtm.trma_todepartmentid, mtm.trma_fromby, mtm.trma_receivedby,mtm.trma_fromdepartmentid, mtm.trma_issueno, et.eqty_equipmenttype, mtm.trma_trmaid')
                    ->get()
                    ->result();

        $totalfilteredrecs=sizeof($resltrpt);  

        $order_by = 'trma_transactiondatebs';
        $order = 'desc';
  
        $where='';
        if($this->input->get('iSortCol_0')==1)
            $order_by = 'trma_issueno';
        else if($this->input->get('iSortCol_0')==2)
            $order_by = 'eqty_equipmenttype';
        
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
            $this->db->where("trma_issueno like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("eqty_equipmenttype like  '%".$get['sSearch_2']."%'  ");
        }

        if(!empty($get['sSearch_5'])){
            $this->db->where("trma_fromby like  '%".$get['sSearch_5']."%'  ");
        }

        if(!empty($get['sSearch_6'])){
            $this->db->where("trma_receivedby like  '%".$get['sSearch_6']."%'  ");
        }
       
        if($cond) {
          $this->db->where($cond);
        }

        if($frmDate &&  $toDate){
            if(DEFAULT_DATEPICKER=='NP')
            {
              $this->db->where('mtm.trma_transactiondatebs >=', $frmDate);
              $this->db->where('mtm.trma_transactiondatebs <=', $toDate);
            }
            else
            {
              $this->db->where('mtm.trma_transactiondatead >=', $frmDate);
              $this->db->where('mtm.trma_transactiondatead <=', $toDate);
            }
        }

        $this->db->select('mtm.trma_transactiondatead as transactiondatead, mtm.trma_transactiondatebs as transactiondatebs, mtm.trma_todepartmentid as todepid, mtm.trma_fromby as fromby, mtm.trma_receivedby as receivedby, mtm.trma_fromdepartmentid as fromdepid, mtm.trma_issueno as issueno, et.eqty_equipmenttype as departmentname, mtm.trma_trmaid as mattransmasterid, sum(mtd.trde_requiredqty * mtd.trde_unitprice) as amount, mtm.trma_reqno as reqno');
        $this->db->from('trma_transactionmain mtm');
        $this->db->join('eqty_equipmenttype et','et.eqty_equipmenttypeid = mtm.trma_fromdepartmentid','left');
        $this->db->join('trde_transactiondetail mtd','mtm.trma_trmaid = mtd.trde_trmaid','left');
        $this->db->where("trma_received",'1');
        $this->db->where("trma_todepartmentid",'1');
        $this->db->where("trma_transactiontype",'issue');
        $this->db->where("trma_status",'O');
        $this->db->where("trma_received",'1');
        $this->db->group_by('mtm.trma_transactiondatebs, mtm.trma_transactiontype, mtm.trma_todepartmentid, mtm.trma_fromby, mtm.trma_receivedby,mtm.trma_fromdepartmentid, mtm.trma_issueno, et.eqty_equipmenttype, mtm.trma_trmaid');
      
        $this->db->order_by($order_by, $order);

        if($limit && $limit>0)
        {  
            $this->db->limit($limit);
        }
        if($offset)
        {
            $this->db->offset($offset);
        }
      
        $nquery=$this->db->get();

        // echo $this->db->last_query();
        // die();
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
               $cond .=" AND unit_unitname like  '%".$get['sSearch_3']."%' ";
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
                        `xw_itli_itemslist` `il`
                    LEFT JOIN `xw_trde_transactiondetail` `td` ON `td`.`trde_itemsid` = `il`.`itli_itemlistid`
                    LEFT JOIN `xw_trma_transactionmain` `tm` ON `tm`.`trma_trmaid` = `td`.`trde_trmaid`
                    LEFT JOIN `xw_unit_unit` `un` ON `un`.`unit_unitid` = `il`.`itli_unitid`
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
                LEFT JOIN `xw_unit_unit` `un` ON `un`.`unit_unitid` = `il`.`itli_unitid`
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

                $order_by = 'itli_itemcode';

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
                $limit_cond = '';
                if($limit > 0 && $offset > 0){
                    $limit_cond = " limit $limit offset $offset"; 
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
                        `xw_itli_itemslist` `il`
                    LEFT JOIN `xw_trde_transactiondetail` `td` ON `td`.`trde_itemsid` = `il`.`itli_itemlistid`
                    LEFT JOIN `xw_trma_transactionmain` `tm` ON `tm`.`trma_trmaid` = `td`.`trde_trmaid`
                    LEFT JOIN `xw_unit_unit` `un` ON `un`.`unit_unitid` = `il`.`itli_unitid`
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
                LEFT JOIN `xw_unit_unit` `un` ON `un`.`unit_unitid` = `il`.`itli_unitid`
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
                ORDER BY itli_itemname ASC $limit_cond ";

        $this->db->order_by($order_by,$order); 
        
        $query=$this->db->query($sql);

        // echo $this->db->last_query();
        // die();
                    
        $this->db->order_by($order_by,$order);  
      
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

    public function get_stock_received_by_id($srchcol = false)
    {
        try{
            $this->db->select('trde_requiredqty as requiredqty, trde_controlno as controlno, trde_itemsid as itemsid, il.itli_itemname as itemname, il.itli_itemcode as itemcode, trde_unitprice as unitprice, u.unit_unitname as unitname');
            $this->db->from('trde_transactiondetail mtd');
            $this->db->join('itli_itemslist il','il.itli_itemlistid = mtd.trde_itemsid');
            $this->db->join('unit_unit u','u.unit_unitid  = il.itli_unitid');
            if($srchcol){
                $this->db->where($srchcol);
            }
            $query = $this->db->get();

            if($query->num_rows() >0){
                $result = $query->result();
                return $result;
            }
        }catch(Exception $e){
            throw $e;
        }
    }
}