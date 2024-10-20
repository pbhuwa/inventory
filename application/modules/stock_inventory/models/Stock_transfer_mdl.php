<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Stock_transfer_mdl extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->mat_masterTable='trma_transactionmain';
        $this->mat_detailTable='trde_transactiondetail';
        $this->trde_detailTable='trde_transactiondetail';
        $this->trma_masterTable='trma_transactionmain';
        $this->userid = $this->session->userdata(USER_ID);
        $this->username = $this->session->userdata(USER_NAME);
        $this->curtime = $this->general->get_currenttime();
        $this->mac = $this->general->get_Mac_Address();
        $this->ip = $this->general->get_real_ipaddr();
        $this->depid = $this->session->userdata(USER_DEPT);
        $this->locationid=$this->session->userdata(LOCATION_ID);
        $this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
        $this->locationid=$this->session->userdata(LOCATION_ID);
    }
    public $validate_settings_stock_transfer = array(
        array('field' => 'rema_reqno', 'label' => 'Requisition No', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'from_store', 'label' => 'From Store', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'to_store', 'label' => 'To Store', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'trma_reqby', 'label' => 'Dispatch By !!', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'trma_dispatch_date', 'label' => 'Dispatch Date', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'trma_toby', 'label' => 'Dispatch To !!', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'transfer_number', 'label' => 'Transfer Number !!', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'sama_fyear', 'label' => 'Fiscal Year', 'rules' => 'trim|required|xss_clean'),
        // array('field' => 'sade_itemsid[]', 'label' => 'Items', 'rules' => 'trim|required|xss_clean'),
        // array('field' => 'qtyinstock[]', 'label' => 'Item Stock', 'rules' => 'trim|required|xss_clean'),
        // array('field' => 'sade_qty[]', 'label' => 'Items Qty', 'rules' => 'trim|required|xss_clean|numeric'),
    );
    public function save_stocktransfer()
    {
        try{
            $postdata=$this->input->post();
            // echo "<pre>";print_r($postdata);die();
                $dispatch_date=$this->input->post('trma_dispatch_date');
            if(DEFAULT_DATEPICKER=='NP')
            {
                $dispatch_dateNp=$dispatch_date;
                $dispatch_dateEn=$this->general->NepToEngDateConv($dispatch_date);
            }
            else
            {
                $dispatch_dateEn=$dispatch_date;
                $dispatch_dateNp=$this->general->EngToNepDateConv($dispatch_date);
            }
            $reqno=$this->input->post('rema_reqno');
            $trans_num=$this->input->post('transfer_number');
            $from_store = $this->input->post('from_store');
            $to_store = $this->input->post('to_store');
            $trma_reqby = $this->input->post('trma_reqby');
            $trma_toby = $this->input->post('trma_toby');
            $fiscalyear = $this->input->post('fiscalyear');
            $itemsid = $this->input->post('itemid');
            $itemstock = $this->input->post('itemstock');
            $dis_qty = $this->input->post('dis_qty');
            $remarks = $this->input->post('remarks');
            $expdate = $this->input->post('expdate'); 
            $mattransmasterid = $this->input->post('mattransmasterid'); 
            $controlno = $this->input->post('controlno'); 
                
            $curtime=$this->general->get_currenttime();
            $userid=$this->session->userdata(USER_ID);
            $mac=$this->general->get_Mac_Address();
            $ip=$this->general->get_real_ipaddr();
            $this->db->trans_begin();
            
                $mat_master = array(
                                    'trma_transactiondatebs'=>$dispatch_dateNp,
                                    'trma_transactiondatead'=>$dispatch_dateEn,
                                    'trma_transactiontype'=>'ISSUE',
                                    'trma_fromdepartmentid'=>$from_store,
                                    'trma_todepartmentid'=>$to_store, 
                                    'trma_fromby'=>$trma_reqby,
                                    'trma_toby'=>$trma_toby,
                                    'trma_issueno'=>$trans_num,
                                    'trma_status'=>'O',
                                    'trma_reqno'=>$reqno,
                                    'trma_received'=>0,
                                    'trma_receiveddatebs'=>CURDATE_NP,
                                    'trma_receiveddatead'=>CURDATE_EN,
                                    'trma_fyear'=>$fiscalyear,
                                    'trma_sttransfer'=>'S',
                                    'trma_postdatead'=>CURDATE_EN,
                                    'trma_postdatebs'=>CURDATE_NP,
                                    'trma_posttime'=>$curtime,
                                    'trma_postby'=>$userid,
                                    'trma_postip'=>$ip,
                                    'trma_postmac'=>$mac,
                                    'trma_locationid'=>$this->locationid
                                    );
                if(!empty($mat_master))
                {   //print_r($mat_master);die;
                    $this->db->insert($this->mat_masterTable,$mat_master);
                    $insertid=$this->db->insert_id();
                    if($insertid)
                    {
                    foreach ($itemsid as $key => $val) {
                    $mat_detail[]=array(
                                    'trde_trmaid'=>$insertid,
                                    'trde_transactiondatead'=>$dispatch_dateNp,
                                    'trde_transactiondatebs'=>$dispatch_dateEn,
                                    'trde_itemsid'=> !empty($itemsid[$key])?$itemsid[$key]:'',
                                    'trde_requiredqty'=> !empty($dis_qty[$key])?$dis_qty[$key]:'',
                                    'trde_postdatebs'=>CURDATE_NP,
                                    'trde_postdatead'=>CURDATE_EN,
                                    'trde_postip'=>$ip,                              
                                    'trde_postmac'=>$mac,
                                    'trde_locationid'=>$this->locationid,
                                    'trde_posttime'=>$curtime,
                                    'trde_postby'=>$userid,
                                    'trde_transactiontype'=>'ISSUE',
                                    'trde_mtmid'=>!empty($mattransmasterid[$key])?$mattransmasterid[$key]:'',
                                    'trde_controlno'=>!empty($controlno[$key])?$controlno[$key]:'',
                                    // 'trde_mfgdate',
                                        // 'trde_expdatead',
                                        // 'trde_packingtypeid',
                                        // 'trde_mtdid',
                                        // 'trde_batchno',
                                        // 'trde_unitpercase',
                                        // 'trde_noofcases',
                                        // 'trde_caseno',
                                        // 'trde_requiredqty',
                                        // 'trde_issueqty',
                                        // 'trde_transferqty',
                                        // 'trde_batchsize',
                                        // 'trde_packing',
                                        // 'trde_stripqty',
                                        // 'trde_issueno',
                                        // 'trde_status',
                                        // 'trde_sysdate',
                                        // 'trde_lastchangedate',
                                        // 'trde_lastchangeby',
                                        // 'trde_mtmid',
                                        // 'trde_transactiontype',
                                        // 'trde_statusupdatedatebs',
                                        // 'trde_statusupdatedatead',
                                        // 'trde_unitprice',
                                        // 'trde_selprice',
                                        // 'trde_remarks',
                                        // 'trde_supplierid',
                                        // 'trde_supplierbillno',
                                        // 'trde_transtime',
                                        // 'trde_mtdtime',
                                        // 'trde_unitvolume',
                                        // 'trde_microunitid',
                                        // 'trde_totalvalue',
                                        // 'trde_description',
                                        // 'trde_free',
                                    // 'trde_newissueqty',
                                );
                        }
                        if(!empty($mat_detail))
                        {   //echo"<pre>";print_r($mat_detail);die;
                            $this->db->insert_batch($this->mat_detailTable,$mat_detail);
                        }
                    }
                }
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                return false;
            }
            else{
                $this->db->trans_commit();
                return true;
            }
        }catch(Exception $e){
            throw $e;
        }
    }

    //  select mtm.trma_trmaid,mtm.trma_transactiondatebs,mtm.trma_transactiondatead,
    // mtm.trma_transactiontype,mtm.trma_fromdepartmentid,mtm.trma_todepartmentid,mtm.trma_fromby,mtm.trma_toby,
    // mtm.trma_issueno,mtm.trma_reqno,et.eqty_equipmenttype,sum(mtd.trde_requiredqty * mtd.trde_unitprice) totalamount
    //  from xw_trma_transactionmain mtm left join xw_trde_transactiondetail mtd on mtd.trde_trmaid=mtm.trma_trmaid
    // left join xw_eqca_equipmentcategory ec on ec.eqca_equipmentcategoryid=mtm.trma_todepartmentid
    // WHERE 
    // mtm.trma_transactiontype='ISSUE' AND mtm.trma_status<>'C'
    // and mtm.trma_transactiondatebs BETWEEN '2074/04/02' AND '2074/06/07'
    // AND(mtm.trma_todepartmentid='1' OR mtm.trma_fromdepartmentid ='1')
    // GROUP BY  mtm.trma_trmaid,mtm.trma_transactiondatebs,mtm.trma_transactiondatead,
    // mtm.trma_transactiontype,mtm.trma_fromdepartmentid,mtm.trma_todepartmentid,mtm.trma_fromby,mtm.trma_toby,
    // mtm.trma_issueno,mtm.trma_reqno,et.eqty_equipmenttype 
    //  order by mtd.trde_transactiondatebs DESC
    
    public function get_stock_transfer_list($cond = false)
        {
            $frmDate=$this->input->get('frmDate');
            $toDate=$this->input->get('toDate');
            $locationid=$this->input->get('locationid');

            $equipmenttypeid=$this->input->get('equipmenttypeid');
            $get = $_GET;
            foreach ($get as $key => $value) {
                $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
            }
            

            if(!empty($get['sSearch_1'])){
                $this->db->where("trma_transactiondatebs like  '%".$get['sSearch_1']."%'  ");
            }
            if(!empty($get['sSearch_2'])){
                $this->db->where("trma_transactiondatead like  '%".$get['sSearch_2']."%'  ");
            }
            if(!empty($get['sSearch_3'])){
                $this->db->where("trma_transactiontype like  '%".$get['sSearch_3']."%'  ");
            }
            if(!empty($get['sSearch_4'])){
                $this->db->where("toStore like  '%".$get['sSearch_4']."%'  ");
            }
              if(!empty($get['sSearch_5'])){
                $this->db->where("trma_fromby like  '%".$get['sSearch_5']."%'  ");
            }
            if(!empty($get['sSearch_6'])){
                $this->db->where("trma_toby like  '%".$get['sSearch_6']."%'  ");
            }
            if(!empty($get['sSearch_7'])){
                $this->db->where("trma_issueno like  '%".$get['sSearch_7']."%'  ");
            }
            if(!empty($get['sSearch_8'])){
                        $this->db->where("trma_reqno like  '%".$get['sSearch_8']."%'  ");
            }
              if($cond) {
              $this->db->where($cond);
            }
          
         
            if($this->location_ismain=='Y'){
                if(!empty($locationid)){
               $this->db->where('mtm.trma_locationid',$locationid);
                }
            }else{
                $this->db->where('mtm.trma_locationid',$this->locationid);
            }


             $this->db->select('mtm.trma_trmaid, mtm.trma_reqno,mtm.trma_fromdepartmentid,mtm.trma_todepartmentid,mtm.trma_fromby,mtm.trma_transactiondatebs,mtm.trma_toby,mtm.trma_issueno,mtm.trma_fyear,mtm.trma_transactiontype,et1.eqty_equipmenttype as fromStore,
    et2.eqty_equipmenttype AS toStore');
                 $this->db->from('trma_transactionmain mtm');
                $this->db->join('eqty_equipmenttype et1','et1.eqty_equipmenttypeid=mtm.trma_fromdepartmentid','LEFT');
                $this->db->join('eqty_equipmenttype et2','et2.eqty_equipmenttypeid=mtm.trma_todepartmentid','LEFT');
                $this->db->where('trma_transactiontype','S.TRANSFER');
                $this->db->order_by('mtm.trma_transactiondatebs','DESC');
    /*
        $this->db->join('trde_transactiondetail mtd','mtd.trde_trmaid=mtm.trma_trmaid','left');
                $this->db->join('eqty_equipmenttype et','et.eqty_equipmenttypeid=mtm.trma_todepartmentid','left'); 
                $this->db->where(array('mtm.trma_transactiontype'=>'ISSUE',' mtm.trma_status<> '=>'C'));
                $this->db->where("(mtm.trma_todepartmentid=$equipmenttypeid OR mtm.trma_fromdepartmentid =$equipmenttypeid)");
                $this->db->group_by('mtm.trma_trmaid,mtm.trma_transactiondatebs,mtm.trma_transactiondatead,
        mtm.trma_transactiontype,mtm.trma_fromdepartmentid,mtm.trma_todepartmentid,mtm.trma_fromby,mtm.trma_toby,
        mtm.trma_issueno,mtm.trma_reqno,et.eqty_equipmenttype ');
    */ 
        $query=$this->db->get();
        //echo ($this->db->last_query());die;
        $resltrpt=$query->result();
        //print_r($resltrpt);die;
        $totalfilteredrecs=sizeof($resltrpt); 
        $order_by = 'mtm.trma_transactiondatebs';
        $order = 'desc';
        if($this->input->get('sSortDir_0'))
        {
                $order = $this->input->get('sSortDir_0');
        }
        $where='';
       if($this->input->get('iSortCol_0')==1)
            $order_by = 'trma_transactiondatebs';
        else if($this->input->get('iSortCol_0')==2)
            $order_by = 'trma_transactiondatead';
        else if($this->input->get('iSortCol_0')==3)
            $order_by = 'trma_transactiontype';
        else if($this->input->get('iSortCol_0')==4)
            $order_by = 'eqty_equipmenttype';
        else if($this->input->get('iSortCol_0')==5)
            $order_by = 'trma_fromby';
            else if($this->input->get('iSortCol_0')==6)
            $order_by = 'trma_toby';
        else if($this->input->get('iSortCol_0')==7)
            $order_by = 'trma_issueno';
        else if($this->input->get('iSortCol_0')==8)
            $order_by = 'trma_reqno';
        $totalrecs='';
        $limit = 15;
        $offset = 1;
        $get = $_GET;

        //print_r($resltrpt);die;
 
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }
      
        if(!empty($_GET["iDisplayLength"])){
           $limit = $_GET['iDisplayLength'];
           $offset = $_GET["iDisplayStart"];
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("trma_transactiondatebs like  '%".$get['sSearch_1']."%'  ");
        }
        if(!empty($get['sSearch_2'])){
            $this->db->where("trma_transactiondatead like  '%".$get['sSearch_2']."%'  ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("trma_transactiontype like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("toStore like  '%".$get['sSearch_4']."%'  ");
        }
          if(!empty($get['sSearch_5'])){
            $this->db->where("trma_fromby like  '%".$get['sSearch_5']."%'  ");
        }
        if(!empty($get['sSearch_6'])){
            $this->db->where("trma_toby like  '%".$get['sSearch_6']."%'  ");
        }
        if(!empty($get['sSearch_7'])){
            $this->db->where("trma_issueno like  '%".$get['sSearch_7']."%'  ");
        }
        if(!empty($get['sSearch_8'])){
                    $this->db->where("trma_reqno like  '%".$get['sSearch_8']."%'  ");
        }
        // if(!empty(($frmDate && $toDate)))
        // {
        //     $this->db->where('mtm.trma_transactiondatebs >=',$frmDate);
        //     $this->db->where('mtm.trma_transactiondatebs <=',$toDate);
        // }
        //    if(!empty($locationid)){
        //     $this->db->where('mtm.trma_locationid',$locationid);
        // }
        if($cond) {
          $this->db->where($cond);
        }
     if($this->location_ismain=='Y'){
        if(!empty($locationid)){
               $this->db->where('mtm.trma_locationid',$locationid);
                }
            }else{
                $this->db->where('mtm.trma_locationid',$this->locationid);
            }

        $this->db->select('mtm.trma_trmaid, mtm.trma_reqno,mtm.trma_fromdepartmentid,mtm.trma_todepartmentid,mtm.trma_fromby,mtm.trma_transactiondatebs,mtm.trma_transactiondatead,mtm.trma_toby,mtm.trma_issueno,mtm.trma_fyear,mtm.trma_transactiontype,et1.eqty_equipmenttype as fromStore,
    et2.eqty_equipmenttype AS toStore');
                 $this->db->from('trma_transactionmain mtm');
                $this->db->join('eqty_equipmenttype et1','et1.eqty_equipmenttypeid=mtm.trma_fromdepartmentid','LEFT');
                $this->db->join('eqty_equipmenttype et2','et2.eqty_equipmenttypeid=mtm.trma_todepartmentid','LEFT');
                $this->db->where('trma_transactiontype','S.TRANSFER');
                $this->db->order_by('mtm.trma_transactiondatebs','DESC');
      

        if($limit && $limit>0)
        {  
            $this->db->limit($limit);
        }
        if($offset)
        {
            $this->db->offset($offset);
        }
      
       $nquery=$this->db->get();
        // echo $this->db->last_query();die();
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

    public function get_max_issue_no($depid=false)
    {
        $this->db->select('MAX(mtm.trma_issueno)+1 as maxid');
        $this->db->from('trma_transactionmain mtm');
        $this->db->where(array('mtm.trma_transactiontype'=>'ISSUE','trma_fyear'=>CUR_FISCALYEAR));
        if($depid){
                $this->db->where(array('trma_fromdepartmentid'=>$depid));
            }
        $query = $this->db->get();
        // echo $this->db->last_query();
        if($query->num_rows() > 0){
                $result = $query->row()->maxid;
                return $result;
            }
            return false;        
    }

    public function get_req_no_list($srchcol = false, $order_by = false, $order = false){
        $this->db->select('rm.rema_fyear,rm.rema_reqmasterid, rm.rema_reqno, rm.rema_reqdatebs, rm.rema_reqdatead, rm.rema_manualno, rm.rema_reqfromdepid, rm.rema_reqby,rm.rema_approved,eq.eqty_equipmenttype as fromstore,to.eqty_equipmenttype as tostore,eq.eqty_equipmenttypeid as fromstore,to.eqty_equipmenttypeid as tostore');
        $this->db->from('rema_reqmaster rm');
        $this->db->join('eqty_equipmenttype eq','eq.eqty_equipmenttypeid = rm.rema_reqfromdepid','left');
        $this->db->join('eqty_equipmenttype to','to.eqty_equipmenttypeid = rm.rema_reqtodepid','left');
        if($srchcol){
            $this->db->where($srchcol);
        }
        if($order_by && $order){
            $this->db->order_by($order_by,$order);    
        }
        
        $query = $this->db->get();
        //echo $this->db->last_query();die();
        if($query->num_rows() > 0){
            $result = $query->result();
            return $result;
        }
        return false;
    }
    public function get_req_details($srchcol = false, $order_by = false, $order = false){
        $this->db->select('rd.*,il.itli_itemcode,il.itli_itemname,il.itli_itemlistid');
        $this->db->from('rede_reqdetail rd');
        $this->db->join('itli_itemslist il','il.itli_itemlistid = rd.rede_itemsid','left');
        if($srchcol){
            $this->db->where($srchcol);
        }
        if($order_by && $order){
            $this->db->order_by($order_by,$order);    
        }
        
        $query = $this->db->get();
        //echo $this->db->last_query();die();
        if($query->num_rows() > 0){
            $result = $query->result();
            return $result;
        }
        return false;
    }
    public function save_store_transfer()
    {
        try{
            $tmid = $this->input->post('id');
            $itemid = $this->input->post('sade_itemsid');
            $transfer_qty = $this->input->post('sade_qty');//transfer_qty dis_qty 
            $requisition_number= $this->input->post('rema_reqno');
            $from_store1= $this->input->post('from_store');
            $to_store1= $this->input->post('to_store');
            $approve_by = $this->input->post('approved_by');
            $dispatchby = $this->input->post('trma_reqby');
            $dispatchto = $this->input->post('trma_toby');
            $dispatch_date = $this->input->post('trma_dispatch_date');
            $transfer_number=$this->input->post('transfer_number');
            if(DEFAULT_DATEPICKER=='NP')
            {
                $dispatch_dateNp=$dispatch_date;
                $dispatch_dateEn=$this->general->NepToEngDateConv($dispatch_date);
            }
            else
            {
                $dispatch_dateEn=$dispatch_date;
                $dispatch_dateNp=$this->general->EngToNepDateConv($dispatch_date);
            }
            $this->db->trans_begin();
            $transfermainData=$this->general->get_tbl_data('*','rema_reqmaster',array('rema_reqmasterid'=> $tmid ));
                //

            //echo $tmid;die;
            if($transfermainData)
            {
                $fromstoreid=$transfermainData[0]->rema_reqfromdepid;
                $tostoreid=$transfermainData[0]->rema_reqtodepid;
                $transMasterId=$this->insert_into_transaction_master_table($requisition_number,$fromstoreid,$tostoreid,$dispatchby,$dispatchto,$dispatch_dateNp,$dispatch_dateEn,$transfer_number);
                    if($itemid)
                    {

                      foreach ($itemid as $key => $val) {
                        $itmid=!empty($itemid[$key])?$itemid[$key]:'';
                        $trnsfer_qty=!empty($transfer_qty[$key])?$transfer_qty[$key]:'';

                        $this->get_transfer_data_by_transfer_masterid($itmid, $trnsfer_qty,$tmid,$transMasterId);
                        }  
                    }
                        $this->db->trans_complete();
                         if ($this->db->trans_status() === FALSE){
                        $this->db->trans_rollback();
                        return false;
                    }
                    else
                    {
                        $tfmaArray = array(
                                    'rema_status' => 'N',
                                    'rema_received' => '2',
                                    'rema_approvedby' =>$approve_by,
                                    //'rema_approvedusername' =>$this->username,
                                    //'rema_approveddatebs' =>CURDATE_EN,
                                    'rema_approveddatebs' =>CURDATE_NP,
                                    // 'rema_approvedtime' =>$this->curtime,
                                    // 'rema_isreceived' =>'N',
                                    // 'rema_receivedby' =>''
                                );
                            if($tfmaArray){
                                $this->db->where('rema_reqmasterid',$tmid);
                                $this->db->update('rema_reqmaster',$tfmaArray);
                            }
                        $this->db->trans_commit();
                        return true;
                    }
                    return false;
            }

           
            return false;
            
         
        }catch(Exception $e){
            throw $e;
        }
    }
    public function insert_into_transaction_master_table($requisition_number,$fromstoreid,$tostoreid,$dispatchby,$dispatchto,$dispatch_dateNp,$dispatch_dateEn,$transfer_number)
    {
        $postdata['trma_reqno']=$requisition_number;
        $postdata['trma_transactiondatead']=$dispatch_dateEn; //transaction date is dispatch date for store trransfer form one store to another store 
        $postdata['trma_transactiondatebs']=$dispatch_dateNp;
        $postdata['trma_transactiontype']='S.TRANSFER';
            $postdata['trma_fromdepartmentid']= $tostoreid;// from store 
            $postdata['trma_todepartmentid']= $fromstoreid;// tostore 
        $postdata['trma_fromby']=$dispatchby;//dispatch by is from by for stock transfer from store to store
        $postdata['trma_toby']=$dispatchto;
        $postdata['trma_issueno']='';
        $postdata['trma_issueno']=$transfer_number;
        $postdata['trma_status']='O';
        $postdata['trma_sysdate']=CURDATE_EN;
        $postdata['trma_received']=1;
        $postdata['trma_fyear']=CUR_FISCALYEAR;
        $postdata['trma_sttransfer']='Y';
        $postdata['trma_postdatead']=CURDATE_EN;
        $postdata['trma_postdatebs']=CURDATE_NP;
        $postdata['trma_posttime']=$this->curtime;
        $postdata['trma_postby']=$this->userid;
        $postdata['trma_postip']=$this->ip;
        $postdata['trma_postmac']=$this->mac;
       // $postdata['trma_locationid']=$tolocationid;
        $postdata['trma_locationid']=$this->locationid;
        
        if(!empty($postdata))
        {
            $this->db->insert('trma_transactionmain',$postdata);
            $insertid=$this->db->insert_id();
            if($insertid)
            {
                return $insertid;
            }
            return false;
        }
        return false;

    }
    //this function is for details data entry 
    public function get_transfer_data_by_transfer_masterid($itmid, $trnsfer_qty,$tmid,$transMasterId)
    {
        $this->db->select('*'); 
        $this->db->from('rede_reqdetail rd');
        $this->db->where(array('rd.rede_reqmasterid'=>$tmid));
        $this->db->where(array('rd.rede_itemsid'=>$itmid));
            // $this->db->from('tfde_transferdetail tfd');
            // $this->db->where(array('tfd.tfde_tfmaid'=>$tmid));
            // $this->db->where(array('tfd.tfde_itemid'=>$itmid));
        $this->db->order_by('rd.rede_reqdetailid','ASC');
        $this->db->limit(1);
        $qrydata=$this->db->get();
        //echo $this->db->last_query();die();
        $transferdata=$qrydata->row();
        if(!empty($transferdata))
        {
            $db_itemid=$transferdata->rede_itemsid;
            $db_req_tr_qty=$transferdata->rede_qty;//tfde_reqtransferqty as requested qty
            $db_cur_tr_qty=$transferdata->rede_remqty;// current qty rde_qty
            $db_fromstore=$transferdata->rede_fromstoreid;
            $db_tostore=$transferdata->rede_tostoreid; 
            $db_tfmaid=$transferdata->rede_reqmasterid;
            $db_tfdeid=$transferdata->rede_reqdetailid;
            $this->get_transaction_detail_tbl_data($db_itemid,$trnsfer_qty,$db_fromstore,$db_tostore,$db_tfdeid,$db_tfmaid,$transMasterId);

        }
    }
    public function get_transaction_detail_tbl_data($itemid,$issueqty,$fromstore,$tostore,$tfdeid,$tfmaid,$transMasterId)
    {
       // print_r($fromstore);die;
        $this->db->select('mtd.trde_trdeid, mtd.trde_unitprice, mtd.trde_selprice, mtd.trde_controlno, mtd.trde_expdatebs, mtd.trde_issueqty,mtd.trde_mtdid');
        $this->db->from('trde_transactiondetail mtd');
        $this->db->join('trma_transactionmain mtm','mtm.trma_trmaid = mtd.trde_trmaid','LEFT');
        $this->db->where(array('trde_issueqty>'=>'0','trma_received'=>'1','trde_status'=>'O'));
        $this->db->where(array('trde_itemsid'=>$itemid));
            //$this->db->where(array('trde_locationid'=>$fromlocationid));
        $this->db->where(array('trma_fromdepartmentid'=>$fromstore));
        $this->db->order_by('trde_trdeid','ASC');
        $this->db->limit(1);
        $qrydata=$this->db->get();
        //echo "<pre>";echo $this->db->last_query();die();
        $data=$qrydata->row();
        if($data)
        {
            $db_issueqty=$data->trde_issueqty;
            $db_trdeid=$data->trde_trdeid;
            $db_unitprice=$data->trde_unitprice;
            $rem_issue=$issueqty-$db_issueqty;
            $db_mtdid=$data->trde_trdeid;
            if($rem_issue>0)
            {
                // $data->trde_trdeid;    
                $this->update_trde_issue_qty(0,$data->trde_trdeid);
                
                $this->insert_into_transferlog_and_transactiondetail($itemid,$db_issueqty,$db_unitprice,$fromstore,$tostore,$tfdeid,$tfmaid,$db_mtdid,$transMasterId);// For Insert intoo transfer log and transaction detail

                $this->get_transaction_detail_tbl_data($itemid,$rem_issue,$fromstore,$tostore,$tfdeid,$tfmaid,$transMasterId);

            }
            else{
                if($rem_issue<=0)
                {
                    $rem_issue=-($rem_issue);
                     $this->insert_into_transferlog_and_transactiondetail($itemid,$issueqty,$db_unitprice,$fromstore,$tostore,$tfdeid,$tfmaid,$db_mtdid,$transMasterId);// For Insert intoo transfer log and transaction detail
                     $this->update_trde_issue_qty($rem_issue,$data->trde_trdeid);
                }
            }
        } 
    }
    public function insert_into_transferlog_and_transactiondetail($itemid,$rem_issue_qty,$unitprice,$fromstore,$tostore,$tfdeid,$tfmaid,$trns_mtdid,$transMasterId)
    {
        $curtime=$this->general->get_currenttime();
        $userid=$this->session->userdata(USER_ID);
        $username=$this->session->userdata(USER_NAME);
        $mac=$this->general->get_Mac_Address();
        $ip=$this->general->get_real_ipaddr();
        $tranDetailArray=array(
                                'trde_trmaid'=>$transMasterId,
                                'trde_transactiondatead'=>CURDATE_EN,
                                'trde_transactiondatebs'=>CURDATE_NP,
                                'trde_itemsid'=>!empty($itemid)?$itemid:'',
                                'trde_transactiontype'=>"ST.TRANSFER",
                                'trde_status'=>'O',
                                'trde_sysdate'=>CURDATE_EN,
                                'trde_requiredqty'=>!empty($rem_issue_qty)?$rem_issue_qty:'',
                                'trde_issueqty'=>!empty($rem_issue_qty)?$rem_issue_qty:'',
                                'trde_newissueqty'=>!empty($rem_issue_qty)?$rem_issue_qty:'',
                                'trde_transtime'=>$curtime,
                                'trde_unitprice'=>!empty($unitprice)?$unitprice:'',
                                'trde_selprice'=>!empty($unitprice)?$unitprice:'',
                                'trde_remarks'=> 'Stock Transfer From Location :'.$fromstore.' To'.$tostore,
                                'trde_description'=>'Stock Transfer From Location :'.$fromstore.' To'.$tostore,
                                'trde_postdatebs'=>CURDATE_NP,
                                'trde_postdatead'=>CURDATE_EN,
                                'trde_mtdid'=>$trns_mtdid,
                                'trde_postip'=>$ip,
                                'trde_postmac'=>$mac,
                                'trde_posttime'=>$curtime,
                                'trde_postby'=>$userid,
                                'trde_locationid'=>$this->locationid);
            // echo '<pre>';print_r($tranDetailArray);die();
            if(!empty($tranDetailArray))
            {
                $this->db->insert($this->trde_detailTable,$tranDetailArray);
            }
            //     $MasterInsertid=$this->db->insert_id();
                //     if($MasterInsertid)
                //     {
                //         $transferLogArray=array(
                //             'trlo_tfdeid'=>$tfdeid,
                //             'trlo_tfmaid'=>$tfmaid,
                //             'trlo_itemid'=>$itemid,
                //             'trlo_trdeid'=>$MasterInsertid,
                //             'trlo_trqty'=>$rem_issue_qty,
                //             'trlo_curqty'=>$rem_issue_qty,
                //             'trlo_unitprice'=>$unitprice,
                //             'trlo_fromlocationid'=>$fromlocationid,
                //             'trlo_tolocationid'=>$tolocationid,
                //             'trlo_postdatead'=>CURDATE_EN,
                //             'trlo_postdatebs'=>CURDATE_NP,
                //             'trlo_postmac'=>$mac,
                //             'trlo_postip'=>$ip,
                //             'trlo_postby'=>$userid,
                //             'trlo_status'=>'N',
                //         );
                //         if(!empty($transferLogArray))
                //         {
                //              $this->db->insert($this->tflo_transferlogTable,$transferLogArray);
                //         }
                //     }
            // }
        // $this->tflo_transferlogTable
    }
    public function update_trde_issue_qty($rem_qty, $trde_id){
        $update_array = array(
                        'trde_issueqty' => $rem_qty,
                        'trde_stripqty'=>$rem_qty,
                    );
        $this->db->update($this->trde_detailTable,$update_array,array('trde_trdeid'=>$trde_id));
    }
}