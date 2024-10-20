<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Stock_transfer_mdl extends CI_Model
{
    public function __construct()
    {
    parent::__construct();
        $this->trma_masterTable='trma_transactionmain';
        $this->trde_detailTable='trde_transactiondetail';
        $this->tfma_masterTable='tfma_transfermain';
        $this->tfde_detailTable='tfde_transferdetail';
        $this->tflo_transferlogTable='trlo_tranferlog';

        $this->userid = $this->session->userdata(USER_ID);
        $this->username = $this->session->userdata(USER_NAME);
        $this->curtime = $this->general->get_currenttime();
        $this->mac = $this->general->get_Mac_Address();
        $this->ip = $this->general->get_real_ipaddr();
        $this->depid = $this->session->userdata(USER_DEPT);
        $this->locationid=$this->session->userdata(LOCATION_ID);
        $this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
        $this->orgid=$this->session->userdata(ORG_ID);
        $this->storeid=$this->session->userdata(STORE_ID);


    }
    public $validate_settings_stock_requisition = array(
        array('field' => 'to_location', 'label' => 'To Location', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'from_location', 'label' => 'From Location', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'transfer_by', 'label' => 'Transfer by', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'itemid[]', 'label' => 'Items', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'transfer_qty[]', 'label' => 'Transfer Qty', 'rules' => 'trim|required|xss_clean|is_natural_no_zero'),
    );

    public $validate_approve_stock_requisition = array(
        array('field' => 'approve_by', 'label' => 'Approve by', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'itemid[]', 'label' => 'Items', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'transfer_qty[]', 'label' => 'Transfer Qty', 'rules' => 'trim|required|xss_clean|is_natural_no_zero'),
    );
    
    public function save_stocktransfer(){
        try{
            //master table
            $transfer_no = $this->input->post('transfer_no');
            $fiscal_year = $this->input->post('fiscal_year');
            $transfer_date = $this->input->post('transfer_date');
            if(DEFAULT_DATEPICKER == 'NP'){
                $transfer_date_bs = $transfer_date;
                $transfer_date_ad = $this->general->NepToEngDateConv($transfer_date);
            }else{
                $transfer_date_ad = $transfer_date;
                $transfer_date_bs = $this->general->EngToNepDateConv($transfer_date);
            }
            $from_location = $this->input->post('from_location');

            $to_location = $this->input->post('to_location');
            $transfer_by = $this->input->post('transfer_by');
            $transfer_reason = $this->input->post('transfer_reason');
            $transfer_sno = $this->general->getLastNo('trma_issueno','trma_transactionmain',array('trma_transactiontype'=>'S.TRANSFER'));
            
            //detail table
            $itemcode = $this->input->post('itemcode');
            $itemid = $this->input->post('itemid');
            $itemname = $this->input->post('itemname');
            $unit = $this->input->post('unit');
            $stock_qty = $this->input->post('stock_qty');
            $transfer_qty = $this->input->post('transfer_qty');
            $remarks = $this->input->post('remarks');
            $purchase_rate = $this->input->post('purchase_rate');
            $sales_rate = $this->input->post('sales_rate');
            $tfde_unitprice =   $this->input->post('tfde_unitprice');
            $tfde_totalamt =   $this->input->post('tfde_totalamt');
            $grandtotal = $this->input->post('totalamount');

            $this->db->trans_begin();

            $tfmaArray = array(
                            'tfma_transfersno' => $transfer_sno+1,
                            'tfma_transferinvoice' => $this->general->generate_invoiceno('tfma_tfmaid','tfma_transferinvoice','tfma_transfermain',TRANSFER_NO_PREFIX,TRANSFER_NO_LENGTH),
                            'tfma_fiscalyear' => $fiscal_year,
                            'tfma_transferdatead' => $transfer_date_ad,
                            'tfma_transferdatebs' => $transfer_date_bs,
                            'tfma_fromlocationid' => $from_location,
                            'tfma_tolocationid' => $to_location,
                             'tfma_totalamt' => $grandtotal,
                           
                            'tfma_transferby' => $transfer_by,
                            'tfma_remarks' => $transfer_reason,
                            'tfma_status' => 'N',
                            'tfma_isapproved' => 'N',
                            'tfma_approvedby' =>'',
                            'tfma_isreceived' =>'N',
                            'tfma_receivedby' =>'',
                            'tfma_postby'=>$this->userid,
                            'tfma_postusername' => $this->username,
                            'tfma_postdatead' => CURDATE_EN,
                            'tfma_postdatebs' => CURDATE_NP,
                            'tfma_posttime' => $this->curtime,
                            'tfma_postmac' => $this->mac,
                            'tfma_postip' => $this->ip,
                            'tfma_orgid' => $this->orgid,
                            'tfma_locationid' => $this->locationid


                        );
            if(!empty($tfmaArray)){
                $this->db->insert($this->tfma_masterTable,$tfmaArray);
                $insertid=$this->db->insert_id();

                if($insertid){
                    foreach ($itemid as $key => $val) {
                        $tfdeArray[] = array(
                                'tfde_tfmaid' => $insertid,
                                'tfde_transferno' => $transfer_sno+1,
                                'tfde_itemid' => !empty($itemid[$key])?$itemid[$key]:'',
                                'tfde_itemcode' => !empty($itemcode[$key])?$itemcode[$key]:'',
                                'tfde_itemname' => !empty($itemname[$key])?$itemname[$key]:'',
                                'tfde_unit' => !empty($unit[$key])?$unit[$key]:'',
                                'tfde_stockqty' => !empty($stock_qty[$key])?$stock_qty[$key]:'',
                                'tfde_reqtransferqty' => !empty($transfer_qty[$key])?$transfer_qty[$key]:'',
                                  'tfde_curtransferqty' => 0,
                                'tfde_remarks' => !empty($remarks[$key])?$remarks[$key]:'',
                                'tfde_unitprice'=> !empty($tfde_unitprice[$key])?$tfde_unitprice[$key]:'',
                                'tfde_totalamt'=> !empty($tfde_totalamt[$key])?$tfde_totalamt[$key]:'',
                                'tfde_fromlocationid'=>$this->storeid,
                                'tfde_tolocationid'=>$to_location,
                                'tfde_locationid' => $this->locationid,
                                'tfde_postby' =>$this->userid,
                                'tfde_postusername' =>$this->username,
                                'tfde_postdatead' =>CURDATE_EN,
                                'tfde_postdatebs' =>CURDATE_NP,
                                'tfde_posttime' =>$this->curtime,
                                'tfde_postmac' =>$this->mac,
                                'tfde_postip' =>$this->ip,  
                                'tfde_orgid' => $this->orgid,

                            );
                    }
                    if(!empty($tfdeArray)){
                        $this->db->insert_batch($this->tfde_detailTable,$tfdeArray);
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

    public function approve_stocktransfer(){
        try{
            $id = $this->input->post('id');
            //master table
            // $transfer_no = $this->input->post('transfer_no');
            $fiscal_year = $this->input->post('fiscal_year');
            $transfer_date = $this->input->post('transfer_date');
            if(DEFAULT_DATEPICKER == 'NP'){
                $transfer_date_bs = $transfer_date;
                $transfer_date_ad = $this->general->NepToEngDateConv($transfer_date);
            }else{
                $transfer_date_ad = $transfer_date;
                $transfer_date_bs = $this->general->EngToNepDateConv($transfer_date);
            }
            $from_location = $this->input->post('from_location');
            $to_location = $this->input->post('to_location');
            $transfer_by = $this->input->post('transfer_by');
            $transfer_reason = $this->input->post('transfer_reason');
            $transaction_no = $this->general->getLastNo('trma_issueno','trma_transactionmain',array('trma_locationid'=>$this->locationid,'trma_fromdepartmentid'=>$this->depid,'trma_fyear'=>$fiscal_year));
            // $transfer_sno = $this->general->getLastNo('trma_issueno','trma_transactionmain',array('trma_transactiontype'=>'S.TRANSFER'));
            // print_r($transaction_no);

            $approve_by = $this->input->post('approved_by');
            
            //detail table
            $itemcode = $this->input->post('itemcode');
            $itemid = $this->input->post('itemid');
            $itemname = $this->input->post('itemname');
            $unit = $this->input->post('unit');
            $stock_qty = $this->input->post('stock_qty');
            $transfer_qty = $this->input->post('transfer_qty');
            $remarks = $this->input->post('remarks');
            $purchase_rate = $this->input->post('purchase_rate');
            $sales_rate = $this->input->post('sales_rate');
            $tfdeid = $this->input->post('tfdeid');

            $this->db->trans_begin();

            $tfmaArray = array(
                            'tfma_status' => 'N',
                            'tfma_isapproved' => 'Y',
                            'tfma_approvedby' =>$approve_by,
                            'tfma_isreceived' =>'N',
                            'tfma_receivedby' =>''
                        );
            if($tfmaArray){
                $this->db->where('tfma_tfmaid',$id);
                $this->db->update($this->tfma_masterTable,$tfmaArray);
            }


            if(!empty($itemid)){
                foreach($itemid as $key=>$val){
                    $tfdeid = !empty($tfdeid[$key])?$tfdeid[$key]:'';
                    $item_id = !empty($itemid[$key])?$itemid[$key]:'';
                    $tran_qty = !empty($transfer_qty[$key])?$transfer_qty[$key]:'';
                    $stock_qty = !empty($stock_qty[$key])?$stock_qty[$key]:'';
                    $rem_stock = $stock_qty - $tran_qty;
                    $old_transaction_detailid = $this->get_transaction_detail_id($item_id,false,false,$tran_qty);

                    $tfdeArray = array(
                        'tfde_stockqty' => $rem_stock,
                        'tfde_transferqty' => $tran_qty
                    );

                    if($tfdeArray){
                        $this->db->where('tfde_tfdeid',$tfdeid);
                        $this->db->update($this->tfde_detailTable,$tfdeArray);
                    }
                }
            }

            $trmaArray = array(
                                'trma_transactiondatead'=>CURDATE_EN,
                                'trma_transactiondatebs'=>CURDATE_NP,
                                'trma_transactiontype'=>'TRANSFER',
                                'trma_issueno'=>$transaction_no+1,
                                'trma_status'=>'O',
                                'trma_sysdate' =>CURDATE_EN,
                                'trma_received'=>0,
                                'trma_receivedby' => '',
                                'trma_remarks' => $transfer_reason,
                                'trma_fyear' =>$fiscal_year,
                                'trma_sttransfer' => 'N',
                                // 'trma_storeid' => $this->storeid,
                                // 'trma_depid' => $this->depid,
                                'trma_locationid' => $this->locationid,
                                'trma_postby' =>$this->userid,
                                'trma_postusername' =>$this->username,
                                'trma_postdatead' =>CURDATE_EN,
                                'trma_postdatebs' =>CURDATE_NP,
                                'trma_posttime' =>$this->curtime,
                                'trma_postmac' =>$this->mac,
                                'trma_postip' =>$this->ip, 
                                'trma_orgid' =>$this->orgid,

                            ); 
            if(!empty($trmaArray)){
                $this->db->insert($this->trma_masterTable,$trmaArray);
                $insertid=$this->db->insert_id();

                if($insertid){
                    foreach ($itemid as $key => $val) {
                        $trdeArray[] = array(
                                'trde_trmaid' => $insertid,
                                'trde_mtdid' => !empty($tfdeid[$key])?$tfdeid[$key]:'',
                                'trde_transactiondatead' => CURDATE_EN,
                                'trde_transactiondatebs' => CURDATE_NP,
                                'trde_itemsid' => !empty($itemid[$key])?$itemid[$key]:'',
                                'trde_controlno' => '',
                                'trde_requiredqty' => !empty($transfer_qty[$key])?$transfer_qty[$key]:'',
                                'trde_issueqty' => !empty($transfer_qty[$key])?$transfer_qty[$key]:'',
                                'trde_transferqty' => '',
                                'trde_status' => 'O', //O
                                'trde_sysdate' => CURDATE_NP,
                                'trde_transactiontype' => 'PURCHASE',
                                'trde_unitprice' => !empty($purchase_rate[$key])?$purchase_rate[$key]:'',
                                'trde_selprice' => !empty($purchase_rate[$key])?$purchase_rate[$key]:'',
                                'trde_supplierid' => 0,
                                'trde_mtmid' => 0,
                                'trde_supplierbillno' => 0,
                                'trde_unitvolume' => 0,
                                'trde_microunitid' => 0,
                                'trde_totalvalue' => 0,
                                'trde_description' => !empty($remarks[$key])?$remarks[$key]:'',
                                'trde_newissueqty' => !empty($transfer_qty[$key])?$transfer_qty[$key]:'',
                                'trde_postby' => $this->userid,
                                'trde_postdatead' => CURDATE_EN,
                                'trde_postdatebs' => CURDATE_NP,
                                'trde_posttime' => $this->curtime,
                                'trde_postmac' => $this->mac,
                                'trde_postip' => $this->ip,
                                'trde_locationid'=>$this->locationid,
                                'trde_orgid' => $this->orgid,

                            );
                    }
                    if(!empty($trdeArray)){
                        $this->db->insert_batch($this->trde_detailTable,$trdeArray);
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


    public function save_approve_stocktransfer(){
        try{
            $tmid = $this->input->post('id');
            $itemid = $this->input->post('itemid');
            $transfer_qty = $this->input->post('transfer_qty');
            $approve_by = $this->input->post('approved_by');
            $this->db->trans_begin();
            $transfermainData=$this->general->get_tbl_data('*',$this->tfma_masterTable,array('tfma_tfmaid'=> $tmid ));
            // echo "<pre>";print_r($transfermainData); die();
            if($transfermainData)
            {
                $fromlocationid=$transfermainData[0]->tfma_fromlocationid;
                $tolocationid=$transfermainData[0]->tfma_tolocationid;

                $transMasterId=$this->insert_into_transaction_master_table($fromlocationid,$tolocationid);
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
                    else{
                        $tfmaArray = array(
                                    'tfma_status' => 'N',
                                    'tfma_isapproved' => 'Y',
                                    'tfma_approvedby' =>$approve_by,
                                    'tfma_approvedusername' =>$this->username,
                                    'tfma_approveddatebs' =>CURDATE_EN,
                                    'tfma_approveddatead' =>CURDATE_NP,
                                    'tfma_approvedtime' =>$this->curtime,
                                    'tfma_isreceived' =>'N',
                                    'tfma_receivedby' =>''
                                );
                            if($tfmaArray){
                                $this->db->where('tfma_tfmaid',$tmid);
                                $this->db->update($this->tfma_masterTable,$tfmaArray);
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

    public function insert_into_transaction_master_table($fromlocationid,$tolocationid)
    {

        $postdata['trma_transactiondatead']=CURDATE_EN;
        $postdata['trma_transactiondatebs']=CURDATE_NP;
        $postdata['trma_transactiontype']='S.TRANSFER';
        $postdata['trma_fromdepartmentid']= $fromlocationid;
        $postdata['trma_todepartmentid']= $tolocationid;
        $postdata['trma_fromby']=$this->username;
        $postdata['trma_toby']=$this->username;
        $postdata['trma_issueno']='';
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
        $postdata['trma_locationid']=$tolocationid;
        $postdata['trma_orgid']=$this->orgid;

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


    public function get_transfer_data_by_transfer_masterid($itmid, $trnsfer_qty,$tmid,$transMasterId)
    {
            $this->db->select('*');
            $this->db->from('tfde_transferdetail tfd');
            $this->db->where(array('tfd.tfde_tfmaid'=>$tmid));
            $this->db->where(array('tfd.tfde_itemid'=>$itmid));
            $this->db->order_by('tfd.tfde_tfdeid','ASC');
            $this->db->limit(1);
            $qrydata=$this->db->get();
            // echo $this->db->last_query();
            // die();
            $transferdata=$qrydata->row();
            if(!empty($transferdata))
            {
                $db_itemid=$transferdata->tfde_itemid;
                $db_req_tr_qty=$transferdata->tfde_reqtransferqty;
                $db_cur_tr_qty=$transferdata->tfde_curtransferqty;
                $db_fromlocationid=$transferdata->tfde_fromlocationid;
                $db_tolocationid=$transferdata->tfde_tolocationid; 
                $db_tfmaid=$transferdata->tfde_tfmaid;
                $db_tfdeid=$transferdata->tfde_tfdeid;
                $this->get_transaction_detail_tbl_data($db_itemid,$trnsfer_qty,$db_fromlocationid,$db_tolocationid,$db_tfdeid,$db_tfmaid,$transMasterId);

            }
        }


public function get_transaction_detail_tbl_data($itemid,$issueqty,$fromlocationid,$tolocationid,$tfdeid,$tfmaid,$transMasterId)
{
  $this->db->select('mtd.trde_trdeid, mtd.trde_unitprice, mtd.trde_selprice, mtd.trde_controlno, mtd.trde_expdatebs, mtd.trde_issueqty,mtd.trde_mtdid');
        $this->db->from('trde_transactiondetail mtd');
        $this->db->join('trma_transactionmain mtm','mtm.trma_trmaid = mtd.trde_trmaid','LEFT');
        $this->db->where(array('trde_issueqty>'=>'0','trma_received'=>'1','trde_status'=>'O'));
        $this->db->where(array('trde_itemsid'=>$itemid));
        $this->db->where(array('trde_locationid'=>$fromlocationid));
        $this->db->order_by('trde_trdeid','ASC');
        $this->db->limit(1);
       

        $qrydata=$this->db->get();
        //  echo "<pre>";echo $this->db->last_query();die();
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
            
            $this->insert_into_transferlog_and_transactiondetail($itemid,$db_issueqty,$db_unitprice,$fromlocationid,$tolocationid,$tfdeid,$tfmaid,$db_mtdid,$transMasterId);// For Insert intoo transfer log and transaction detail

            $this->get_transaction_detail_tbl_data($itemid,$rem_issue,$fromlocationid,$tolocationid,$tfdeid,$tfmaid,$transMasterId);

        }
        else{
            if($rem_issue<=0)
            {
                $rem_issue=-($rem_issue);
                 $this->insert_into_transferlog_and_transactiondetail($itemid,$issueqty,$db_unitprice,$fromlocationid,$tolocationid,$tfdeid,$tfmaid,$db_mtdid,$transMasterId);// For Insert intoo transfer log and transaction detail
                 $this->update_trde_issue_qty($rem_issue,$data->trde_trdeid);
            }
        }

        
    } 

}
public function insert_into_transferlog_and_transactiondetail($itemid,$rem_issue_qty,$unitprice,$fromlocationid,$tolocationid,$tfdeid,$tfmaid,$trns_mtdid,$transMasterId)
{
    $curtime=$this->general->get_currenttime();
    $userid=$this->session->userdata(USER_ID);
    $username=$this->session->userdata(USER_NAME);
    $mac=$this->general->get_Mac_Address();
    $ip=$this->general->get_real_ipaddr();
    $this->orgid=$this->session->userdata(ORG_ID);



    $tranDetailArray=array(
                                'trde_trmaid'=>$transMasterId,
                                'trde_transactiondatead'=>CURDATE_EN,
                                'trde_transactiondatebs'=>CURDATE_NP,
                                'trde_itemsid'=>!empty($itemid)?$itemid:'',
                                'trde_transactiontype'=>"S.TRANSFER",
                                'trde_status'=>'O',
                                'trde_sysdate'=>CURDATE_EN,
                                'trde_requiredqty'=>!empty($rem_issue_qty)?$rem_issue_qty:'',
                                'trde_issueqty'=>!empty($rem_issue_qty)?$rem_issue_qty:'',
                                'trde_newissueqty'=>!empty($rem_issue_qty)?$rem_issue_qty:'',
                                'trde_transtime'=>$curtime,
                                'trde_unitprice'=>!empty($unitprice)?$unitprice:'',
                                'trde_selprice'=>!empty($unitprice)?$unitprice:'',
                                'trde_remarks'=> 'Stock Transfer From Location :'.$fromlocationid.' To'.$tolocationid,
                                'trde_description'=>'Stock Transfer From Location :'.$fromlocationid.' To'.$tolocationid,
                                'trde_postdatebs'=>CURDATE_NP,
                                'trde_postdatead'=>CURDATE_EN,
                                'trde_mtdid'=>$trns_mtdid,
                                'trde_postip'=>$ip,
                                'trde_postmac'=>$mac,
                                'trde_posttime'=>$curtime,
                                'trde_postby'=>$userid,
                                'trde_locationid'=>$tolocationid,
                                'trde_orgid'=>$this->orgid);

    // echo '<pre>';
    // print_r($tranDetailArray);
    // die();
    if(!empty($tranDetailArray))
    {
        $this->db->insert($this->trde_detailTable,$tranDetailArray);
        $MasterInsertid=$this->db->insert_id();
        if($MasterInsertid)
        {
            $transferLogArray=array(
                'trlo_tfdeid'=>$tfdeid,
                'trlo_tfmaid'=>$tfmaid,
                'trlo_itemid'=>$itemid,
                'trlo_trdeid'=>$MasterInsertid,
                'trlo_trqty'=>$rem_issue_qty,
                'trlo_curqty'=>$rem_issue_qty,
                'trlo_unitprice'=>$unitprice,
                'trlo_fromlocationid'=>$fromlocationid,
                'trlo_tolocationid'=>$tolocationid,
                'trlo_postdatead'=>CURDATE_EN,
                'trlo_postdatebs'=>CURDATE_NP,
                'trlo_postmac'=>$mac,
                'trlo_postip'=>$ip,
                'trlo_postby'=>$userid,
                'trlo_status'=>'N',
                'trlo_orgid'=>$this->orgid,

            );

            if(!empty($transferLogArray))
            {
                 $this->db->insert($this->tflo_transferlogTable,$transferLogArray);
            }
        }
    }
    // $this->tflo_transferlogTable

}



    public function update_trde_issue_qty($rem_qty, $trde_id){
        $update_array = array(
                        'trde_issueqty' => $rem_qty,
                        'trde_stripqty'=>$rem_qty,
                    );
        $this->db->update($this->trde_detailTable,$update_array,array('trde_trdeid'=>$trde_id));
    }
    public function get_stock_transfer_list($cond = false)
    {
        $frmDate=$this->input->get('frmDate');
        $toDate=$this->input->get('toDate');
        $apptype = $this->input->get('apptype');
        $get = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }
        if(!empty($get['sSearch_1'])){
            $this->db->where("lower(tfma_transferinvoice like  '%".$get['sSearch_1']."%'  ");
        }
        if(!empty($get['sSearch_2'])){
            if(DEFAULT_DATEPICKER=='NP')
            {
                $this->db->where("lower(tfma_transferdatebs) like  '%".$get['sSearch_2']."%'  ");
            }else{
                $this->db->where("lower(tfma_transferdatead) like  '%".$get['sSearch_2']."%'  ");
            }
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("lower(tfma_fiscalyear) like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("lower(loc.loca_name) like  '%".$get['sSearch_4']."%'  ");
        }
          if(!empty($get['sSearch_5'])){
            $this->db->where("lower(lc.loca_name) like  '%".$get['sSearch_5']."%'  ");
        }
        if(!empty($get['sSearch_6'])){
            $this->db->where("lower(tfma_transferby) like  '%".$get['sSearch_6']."%'  ");
        }
        if(!empty($get['sSearch_7'])){
            $this->db->where("lower(tfma_remarks) like  '%".$get['sSearch_7']."%'  ");
        }
        if($cond) {
          $this->db->where($cond);
        }
        $input_locationid= !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');
          $input_locationid2= !empty($get['locationid2'])?$get['locationid2']:$this->input->post('locationid');
          
        if(!empty(($frmDate && $toDate)))
        {
            if(DEFAULT_DATEPICKER == 'NP'){
                $this->db->where('tf.tfma_transferdatebs >=',$frmDate);
                $this->db->where('tf.tfma_transferdatebs <=',$toDate);    
            }else{
                $this->db->where('tf.tfma_transferdatead >=',$frmDate);
                $this->db->where('tf.tfma_transferdatead <=',$toDate);
            }
        }
        
      if(!empty($input_locationid))
        {
             $this->db->where('tf.tfma_fromlocationid',$input_locationid);
          
             $this->db->where('tf.tfma_locationid',$this->locationid);
        }
    if(!empty($input_locationid2))
         {
            
             $this->db->where('tf.tfma_tolocationid',$input_locationid2);
             $this->db->where('tf.tfma_locationid',$this->locationid);
        }
    


       if(!empty($apptype)){
         if($apptype=="received")
        {
            $this->db->where('tf.tfma_isreceived','Y');
        }
        if($apptype=="approved")
        {
            $this->db->where('tf.tfma_isapproved','Y');
        }
        if($apptype=="pending")
        {
            $this->db->where(array('tf.tfma_isreceived'=>'N', 'tf.tfma_isapproved'=>'N'));
        }
       }
        $resltrpt=$this->db->select("COUNT(*) as cnt")
                    //->from('sama_salemaster rn')
                    ->from('tfma_transfermain tf')
                    
                    ->get()->row();
        //echo $this->db->last_query();die(); 
        $totalfilteredrecs=($resltrpt->cnt); 
        $order_by = 'tfma_tfmaid';
        $order = 'desc';
        if($this->input->get('sSortDir_0'))
        {
                $order = $this->input->get('sSortDir_0');
        }
        $where='';
       if($this->input->get('iSortCol_0')==1)
            $order_by = 'tfma_transferinvoice';
        else if($this->input->get('iSortCol_0')==2)
        if(DEFAULT_DATEPICKER=='NP')
        {
            $order_by = 'tfma_transferdatebs'; 
        }else{
            $order_by = 'tfma_transferdatead';
        }
        else if($this->input->get('iSortCol_0')==3)
            $order_by = 'tfma_fiscalyear';
        else if($this->input->get('iSortCol_0')==4)
            $order_by = 'loc.loca_name';
        else if($this->input->get('iSortCol_0')==5)
            $order_by = 'lc.loca_name';
            else if($this->input->get('iSortCol_0')==6)
            $order_by = 'tfma_transferby';
        else if($this->input->get('iSortCol_0')==7)
            $order_by = 'tfma_remarks';
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
            $this->db->where("lower(tfma_transferinvoice) like  '%".$get['sSearch_1']."%'  ");
        }
        if(!empty($get['sSearch_2'])){
           if(DEFAULT_DATEPICKER=='NP')
           {
                $this->db->where("lower(tfma_transferdatebs) like  '%".$get['sSearch_2']."%'  ");
           }else{
                $this->db->where("lower(tfma_transferdatead) like  '%".$get['sSearch_2']."%'  ");
           }
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("lower(tfma_fiscalyear) like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("lower(loc.loca_name) like  '%".$get['sSearch_4']."%'  ");
        }
          if(!empty($get['sSearch_5'])){
            $this->db->where("lower(lc.loca_name) like  '%".$get['sSearch_5']."%'  ");
        }
        if(!empty($get['sSearch_6'])){
            $this->db->where("lower(tfma_transferby) like  '%".$get['sSearch_6']."%'  ");
        }
        if(!empty($get['sSearch_7'])){
            $this->db->where("lower(tfma_remarks) like  '%".$get['sSearch_7']."%'  ");
        }
        
        if(!empty(($frmDate && $toDate)))
        {
            if(DEFAULT_DATEPICKER == 'NP'){
                $this->db->where('tf.tfma_transferdatebs >=',$frmDate);
                $this->db->where('tf.tfma_transferdatebs <=',$toDate);    
            }else{
                $this->db->where('tf.tfma_transferdatead >=',$frmDate);
                $this->db->where('tf.tfma_transferdatead <=',$toDate);
            }
        }
        if($cond) {
          $this->db->where($cond);
        }
            $input_locationid= !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');
          $input_locationid2= !empty($get['locationid2'])?$get['locationid2']:$this->input->post('locationid2');


    if(!empty($input_locationid))
        {
             $this->db->where('tf.tfma_fromlocationid',$input_locationid);
             $this->db->where('tf.tfma_locationid',$this->locationid);
        }
    if(!empty($input_locationid2))
         {
             $this->db->where('tf.tfma_tolocationid',$input_locationid2);
             $this->db->where('tf.tfma_locationid',$this->locationid);
        }
     
       if(!empty($apptype)){
         if($apptype=="received")
        {
            $this->db->where('tf.tfma_isreceived','Y');
        }
        if($apptype=="approved")
        {
            $this->db->where('tf.tfma_isapproved','Y');
        }
        if($apptype=="pending")
        {
            $this->db->where(array('tf.tfma_isreceived'=>'N', 'tf.tfma_isapproved'=>'N'));
        }
       }
        $this->db->select('tf.*,loc.loca_name as fromlocation, lc.loca_name as tolocation,tf.tfma_tolocationid');
        $this->db->from('tfma_transfermain tf');
        $this->db->join('loca_location loc','loc.loca_locationid =tf.tfma_fromlocationid','LEFT');
        $this->db->join('loca_location lc','lc.loca_locationid = tf.tfma_tolocationid','LEFT');
        $this->db->order_by($order_by,$order);
        if($limit && $limit>0)
        {  
            $this->db->limit($limit);
        }
        if($offset)
        {
            $this->db->offset($offset);
        }
        $nquery=$this->db->get();
        $num_row=$nquery->num_rows();
 if (!empty($_GET['iDisplayLength']) &&  !empty($nquery) && is_array($nquery) && count($nquery) > 0 ) {
            $totalrecs = count($nquery);
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
    public function get_stock_transfer_details_list($cond = false)
    {
        $frmDate=$this->input->get('frmDate');
        $toDate=$this->input->get('toDate');
        $apptype = $this->input->get('apptype');
        $get = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }
        if(!empty($get['sSearch_1'])){
            $this->db->where("lower(tfma_transferinvoice) like  '%".$get['sSearch_1']."%'  ");
        }
        if(!empty($get['sSearch_2'])){
            if(DEFAULT_DATEPICKER=='NP')
            {
                $this->db->where("lower(tfma_transferdatebs) like  '%".$get['sSearch_2']."%'  ");
            }else{
                $this->db->where("lower(tfma_transferdatead) like  '%".$get['sSearch_2']."%'  ");
            }
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("lower(tfma_fiscalyear) like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("lower(loc.loca_name) like  '%".$get['sSearch_4']."%'  ");
        }
          if(!empty($get['sSearch_5'])){
            $this->db->where("lower(lc.loca_name) like  '%".$get['sSearch_5']."%'  ");
        }
        if(!empty($get['sSearch_6'])){
            $this->db->where("lower(tfma_transferby) like  '%".$get['sSearch_6']."%'  ");
        }
        if(!empty($get['sSearch_7'])){
            $this->db->where("lower(itli_itemcode) like  '%".$get['sSearch_7']."%'  ");
        }
        if(!empty($get['sSearch_8'])){
             $this->db->where("lower(itli_itemname) like  '%".$get['sSearch_8']."%' OR itli_itemnamenp like  '%".$get['sSearch_8']."%'  ");
        }
        if(!empty($get['sSearch_9'])){
            $this->db->where("lower(unit_unitname) like  '%".$get['sSearch_9']."%'  ");
        }
        if(!empty($get['sSearch_10'])){
            $this->db->where("lower(tfde_reqtransferqty) like  '%".$get['sSearch_10']."%'  ");
        }

        if($cond) {
          $this->db->where($cond);
        }
        $input_locationid= !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');
      
        if(!empty(($frmDate && $toDate)))
        {
            if(DEFAULT_DATEPICKER=='NP')
            {
                $this->db->where('td.tfde_postdatebs >=',$frmDate);
                $this->db->where('td.tfde_postdatebs <=',$toDate);
            }else{
                $this->db->where('td.tfde_postdatead >=',$frmDate);
                $this->db->where('td.tfde_postdatead <=',$toDate);
            }
        }
         if($this->location_ismain=='Y')
        {
            if($input_locationid)
            {
                $this->db->where('td.tfde_locationid',$input_locationid);
            }
        }
        else
        {
            $this->db->where('td.tfde_locationid',$this->locationid);
        }
        if($apptype=="received")
        {
            $this->db->where('tf.tfma_isreceived','Y');
        }
        if($apptype=="approved")
        {
            $this->db->where('tf.tfma_isapproved','Y');
        }
        if($apptype=="pending")
        {
            $this->db->where(array('tf.tfma_isreceived'=>'N', 'tf.tfma_isapproved'=>'N'));
        }
        $resltrpt=$this->db->select("COUNT(*) as cnt")
                    ->from('tfde_transferdetail td')
                    ->join('tfma_transfermain tf','tf.tfma_tfmaid =td.tfde_tfmaid','LEFT')
                    ->join('loca_location loc','loc.loca_locationid =td.tfde_fromlocationid','LEFT')
                    ->join('loca_location lc','lc.loca_locationid = td.tfde_tolocationid','LEFT')
                    ->join('itli_itemslist il','il.itli_itemlistid = td.tfde_itemid','LEFT')
                    ->join('unit_unit ut','ut.unit_unitid = il.itli_unitid','LEFT')
                    ->get()->row();
        //echo $this->db->last_query();die(); 
        $totalfilteredrecs=($resltrpt->cnt); 
        $order_by = 'tfde_tfdeid';
        $order = 'desc';
        if($this->input->get('sSortDir_0'))
        {
                $order = $this->input->get('sSortDir_0');
        }
        $where='';
       if($this->input->get('iSortCol_0')==1)
            $order_by = 'tfma_transferinvoice';
        else if($this->input->get('iSortCol_0')==2)
        if(DEFAULT_DATEPICKER=='NP')
        {
            $order_by = 'tfde_postdatead'; 
        }else{
            $order_by = 'tfma_transferdatead';
        }
        else if($this->input->get('iSortCol_0')==3)
            $order_by = 'tfma_fiscalyear';
        else if($this->input->get('iSortCol_0')==4)
            $order_by = 'loc.loca_name';
        else if($this->input->get('iSortCol_0')==5)
            $order_by = 'lc.loca_name';
            else if($this->input->get('iSortCol_0')==6)
            $order_by = 'tfma_transferby';
        else if($this->input->get('iSortCol_0')==7)
            $order_by = 'itli_itemcode';
        else if($this->input->get('iSortCol_0')==8)
            $order_by = 'itli_itemname';
        else if($this->input->get('iSortCol_0')==9)
            $order_by = 'unit_unitname';
        else if($this->input->get('iSortCol_0')==10)
            $order_by = 'tfde_reqtransferqty';
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
            $this->db->where("lower(tfma_transferinvoice) like  '%".$get['sSearch_1']."%'  ");
        }
        if(!empty($get['sSearch_2'])){
           if(DEFAULT_DATEPICKER=='NP')
           {
                $this->db->where("lower(tfma_transferdatebs)  like  '%".$get['sSearch_2']."%'  ");
           }else{
                $this->db->where("lower(tfde_postdatead) like  '%".$get['sSearch_2']."%'  ");
           }
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("lower(tfma_fiscalyear) like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("lower(loc.loca_name) like  '%".$get['sSearch_4']."%'  ");
        }
          if(!empty($get['sSearch_5'])){
            $this->db->where("lower(lc.loca_name) like  '%".$get['sSearch_5']."%'  ");
        }
        if(!empty($get['sSearch_6'])){
            $this->db->where("lower(tfma_transferby) like  '%".$get['sSearch_6']."%'  ");
        }
        if(!empty($get['sSearch_7'])){
            $this->db->where("lower(itli_itemcode) like  '%".$get['sSearch_7']."%'  ");
        }
        if(!empty($get['sSearch_8'])){
            $this->db->where("lower(itli_itemname) like  '%".$get['sSearch_8']."%' OR itli_itemnamenp like  '%".$get['sSearch_8']."%'  ");
        }
        if(!empty($get['sSearch_9'])){
            $this->db->where("lower(unit_unitname) like  '%".$get['sSearch_9']."%'  ");
        }
        if(!empty($get['sSearch_10'])){
            $this->db->where("lower(tfde_reqtransferqty) like  '%".$get['sSearch_10']."%'  ");
        }
        if(!empty(($frmDate && $toDate)))
        {
            if(DEFAULT_DATEPICKER=='NP')
            {
                $this->db->where('td.tfde_postdatebs >=',$frmDate);
                $this->db->where('td.tfde_postdatebs <=',$toDate);
            }else{
                $this->db->where('td.tfde_postdatead >=',$frmDate);
                $this->db->where('td.tfde_postdatead <=',$toDate);
            }
        }
        if($cond) {
          $this->db->where($cond);
        }
        if($this->location_ismain=='Y')
        {
            if($input_locationid)
            {
                $this->db->where('td.tfde_locationid',$input_locationid);
            }
        }
        else
        {
            $this->db->where('td.tfde_locationid',$this->locationid);
        }
         if($apptype=="received")
        {
            $this->db->where('tf.tfma_isreceived','Y');
        }
        if($apptype=="approved")
        {
            $this->db->where('tf.tfma_isapproved','Y');
        }
        if($apptype=="pending")
        {
            $this->db->where(array('tf.tfma_isreceived'=>'N', 'tf.tfma_isapproved'=>'N'));
        }
        $this->db->select('tf.*,td.*,loc.loca_name as fromlocation, lc.loca_name as tolocation,il.itli_itemname,il.itli_itemnamenp,il.itli_itemcode,ut.unit_unitname');
        $this->db->from('tfde_transferdetail td');
        $this->db->join('tfma_transfermain tf','tf.tfma_tfmaid =td.tfde_tfmaid','LEFT');
        $this->db->join('loca_location loc','loc.loca_locationid =td.tfde_fromlocationid','LEFT');
        $this->db->join('loca_location lc','lc.loca_locationid = td.tfde_tolocationid','LEFT');
        $this->db->join('itli_itemslist il','il.itli_itemlistid = td.tfde_itemid','LEFT');
        $this->db->join('unit_unit ut','ut.unit_unitid = il.itli_unitid','LEFT');
        $this->db->order_by($order_by,$order);
        if($limit && $limit>0)
        {  
            $this->db->limit($limit);
        }
        if($offset)
        {
            $this->db->offset($offset);
        }
        $nquery=$this->db->get();
        
        $num_row=$nquery->num_rows();
         if (!empty($_GET['iDisplayLength']) &&  !empty($nquery) && is_array($nquery) && count($nquery) > 0 ) {
            $totalrecs = count($nquery);
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
    public function get_transfer_detail($srchcol=false)
    {
        $this->db->select('td.*, il.itli_itemcode, il.itli_itemname, il.itli_itemnamenp, il.itli_itemlistid,ut.unit_unitname');
        $this->db->from('tfde_transferdetail td');
        $this->db->join('itli_itemslist il','il.itli_itemlistid=td.tfde_itemid','LEFT');
        $this->db->join('unit_unit ut','ut.unit_unitid=il.itli_unitid','LEFT');
        if($srchcol)
        {
            $this->db->where($srchcol);
        }
        $query = $this->db->get();
       // echo $this->db->last_query();die();
        if ($query->num_rows() > 0) 
        {
            $data=$query->result();     
            return $data;       
        }       
        return false;

    }
    
    public function get_transfer_master($srchcol=false)
    {
        $this->db->select('tf.*,loc.loca_name as fromlocation, lc.loca_name as tolocation');
        $this->db->from('tfma_transfermain tf');
        $this->db->join('loca_location loc','loc.loca_locationid =tf.tfma_fromlocationid','LEFT');
        $this->db->join('loca_location lc','lc.loca_locationid = tf.tfma_tolocationid','LEFT');
        if($srchcol)
        {
            $this->db->where($srchcol);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();die();
        if ($query->num_rows() > 0) 
        {
            $data=$query->result();     
            return $data;       
        }       
        return false;

    }
    public function getStatusCount($srchcol = false){
        try{
            
            $this->db->select("
                SUM(CASE WHEN tfma_isapproved='N' THEN 1 ELSE 0 END ) pending, 
                SUM(CASE WHEN tfma_isapproved='Y' THEN 1 ELSE 0 END ) approved,
                SUM(CASE WHEN tfma_isreceived='Y' THEN 1 ELSE 0 END ) received"
            );
            $this->db->from('tfma_transfermain'); 
            // else if($type == 'return'){
            //     $this->db->select("SUM(CASE WHEN rema_st='N' THEN 1 ELSE 0 END ) issuereturn, SUM(CASE WHEN rema_st='C' THEN 1 ELSE 0 END ) returncancel");
            //     $this->db->from('rema_returnmaster');
            // }

            if($srchcol){
                $this->db->where($srchcol);
            }
           
             // if($this->locationid){
             //     $this->db->where('tfma_locationid',$this->locationid);
             //    }
            $query = $this->db->get();
            //echo $this->db->last_query();die;
            if($query->num_rows() > 0){
                return $query->result();
            }
            return false;
        }catch(Exception $e){
            throw $e;
        }
    }

    public function get_transfer_details($cond=false)
    {
        try{
            $this->db->select('itm.itli_itemcode,itm.itli_itemname,itm.itli_itemlistid,td.*, un.unit_unitname');
            $this->db->from('itli_itemslist itm'); 
            $this->db->join('tfde_transferdetail td','td.tfde_itemid =itm.itli_itemlistid ','LEFT');
            $this->db->join('unit_unit un','un.unit_unitid = itm.itli_unitid','LEFT');
            if($cond){
                $this->db->where($cond);
            }
            $query = $this->db->get();
            // echo $this->db->last_query();die; 
            if($query->num_rows() > 0){
                return $query->result();
            }
            return false;
        }catch(Exception $e){
            throw $e;
        }
    }

    public function req_analysis_report($cond= false)
    {
        $fromdate = $this->input->post('frmDate');
        $todate = $this->input->post('toDate');
        $this->db->select('il.itli_itemname,il.itli_itemcode,rm.rema_reqno,rm.rema_reqdatebs,rd.rede_itemsid,rd.rede_remarks,SUM(rd.rede_qty) as reqqty, SUM(rd.rede_remqty) as remqty, SUM(rd.rede_qty - rd.rede_remqty) as isuedqty,dp.dept_depname');
        $this->db->from('rede_reqdetail rd');
        $this->db->join('rema_reqmaster rm','rm.rema_reqmasterid=rd.rede_reqmasterid','LEFT');
        $this->db->join('itli_itemslist il', 'il.itli_itemlistid = rd.rede_itemsid', "LEFT");
        $this->db->join('dept_department dp','dp.dept_depid = rm.rema_reqfromdepid','LEFT');
        $this->db->where('rm.rema_status', "N");
        $this->db->where('rd.rede_remqty >', "0");
        if($cond)
        {
            $this->db->where($cond);
        }
        if($fromdate &&  $todate){
            if(DEFAULT_DATEPICKER=='NP')
            {
              $this->db->where('rm.rema_reqdatebs >=', $fromdate);
              $this->db->where('rm.rema_reqdatebs <=', $todate);
            }
            else
            {
                $this->db->where('rm.rema_reqdatead >=', $fromdate);
                $this->db->where('rm.rema_reqdatead <=', $todate);
            }
        }
        $this->db->group_by('rm.rema_reqno,rd.rede_itemsid,il.itli_itemname,il.itli_itemcode,dp.dept_depname,rm.rema_reqdatebs,rd.rede_remarks');
        $this->db->order_by('dp.dept_depname,rm.rema_reqno,rm.rema_reqdatebs');
        $query = $this->db->get();
        //echo $this->db->last_query();die();
        if ($query->num_rows() > 0) 
        {
            $data=$query->result();     
            return $data;       
        }       
        return false;
    }


    public function req_analysis_report_dist($cond= false)
    {
        $fromdate = $this->input->post('frmDate');
        $todate = $this->input->post('toDate');
        $this->db->select('DISTINCT(rema_reqtodepid),rm.rema_reqno,rd.rede_itemsid,rm.rema_reqdatebs,rm.rema_manualno,rm.rema_reqmasterid,dp.dept_depname');
        $this->db->from('rema_reqmaster rm');
        $this->db->join('rede_reqdetail rd','rd.rede_reqmasterid=rm.rema_reqmasterid','LEFT');
        $this->db->join('itli_itemslist il', 'il.itli_itemlistid = rd.rede_itemsid', "LEFT");
        $this->db->join('dept_department dp','dp.dept_depid = rm.rema_reqfromdepid','LEFT');
        $this->db->where('rm.rema_status', "N");
        $this->db->where('rd.rede_remqty >', "0");
        // $input_locationid=!empty($this->input->post('locationid'))?$this->input->post('locationid'):'';
         // if($this->location_ismain=='Y')
         //    {
         //        if($input_locationid)
         //        {
         //            $this->db->where('rm.rema_locationid',$input_locationid);
         //        }

         //    }
         //    else
         //    {
         //         $this->db->where('rm.rema_locationid',$this->locationid);
         //    }

        if($cond)
        {
            $this->db->where($cond);
        }
        if($fromdate &&  $todate){
            if(DEFAULT_DATEPICKER=='NP')
            {
              $this->db->where('rm.rema_reqdatebs >=', $fromdate);
              $this->db->where('rm.rema_reqdatebs <=', $todate);
            }
            else
            {
                $this->db->where('rm.rema_reqdatead >=', $fromdate);
                $this->db->where('rm.rema_reqdatead <=', $todate);
            }
        }
        $this->db->group_by('rm.rema_reqno,rd.rede_itemsid,il.itli_itemname,il.itli_itemcode,dp.dept_depname,rm.rema_reqdatebs,rd.rede_remarks');
        $this->db->order_by('dp.dept_depname,rm.rema_reqno,rm.rema_reqdatebs');
        $query = $this->db->get();
        // echo $this->db->last_query();die();
        if ($query->num_rows() > 0) 
        {
            $data=$query->result();     
            return $data;       
        }       
        return false;
    }

    public function req_analysis_report_dist_dep($cond= false)
    {
        $fromdate = $this->input->post('frmDate');
        $todate = $this->input->post('toDate');
        $this->db->select('DISTINCT(rema_reqfromdepid),dp.dept_depname,rm.rema_reqmasterid,rm.rema_reqdatebs,rm.rema_manualno,rm.rema_reqno');
        $this->db->from('rema_reqmaster rm');
        $this->db->join('rede_reqdetail rd','rd.rede_reqmasterid=rm.rema_reqmasterid','LEFT');
        $this->db->join('dept_department dp','dp.dept_depid = rm.rema_reqfromdepid','LEFT');
        $this->db->where('rm.rema_status', "N");
        $this->db->where('rd.rede_remqty >', "0");
        // $input_locationid=!empty($this->input->post('locationid'))?$this->input->post('locationid'):'';
         // if($this->location_ismain=='Y')
         //    {
         //        if($input_locationid)
         //        {
         //            $this->db->where('rm.rema_locationid',$input_locationid);
         //        }

         //    }
         //    else
         //    {
         //         $this->db->where('rm.rema_locationid',$this->locationid);
         //    }

        if($cond)
        {
            $this->db->where($cond);
        }
        if($fromdate &&  $todate){
            if(DEFAULT_DATEPICKER=='NP')
            {
              $this->db->where('rm.rema_reqdatebs >=', $fromdate);
              $this->db->where('rm.rema_reqdatebs <=', $todate);
            }
            else
            {
                $this->db->where('rm.rema_reqdatead >=', $fromdate);
                $this->db->where('rm.rema_reqdatead <=', $todate);
            }
        }
        // $this->db->group_by('');
        $this->db->order_by('dp.dept_depname');
        $query = $this->db->get();
        // echo $this->db->last_query();die();
        if ($query->num_rows() > 0) 
        {
            $data=$query->result();     
            return $data;       
        }       
        return false;
    }

    public function req_analysis_transfer($cond=false)
    {
        $fromdate = $this->input->post('frmDate');
        $todate = $this->input->post('toDate');

        $input_locationid=!empty($this->input->post('locationid'))?$this->input->post('locationid'):'';
        $this->db->select('rm.rema_reqno,rm.rema_reqmasterid,rm.rema_manualno,rm.rema_reqdatebs,eq.eqty_equipmenttype');
        $this->db->from('rema_reqmaster rm');
        $this->db->join('eqty_equipmenttype eq', 'eq.eqty_equipmenttypeid = rm.rema_reqtodepid', "LEFT");
        $this->db->where('rm.rema_isdep', "N");
        if($cond)
        {
            $this->db->where($cond);
        }
        // if($this->location_ismain=='Y')
        // {
        //     if($input_locationid)
        //     {
        //         $this->db->where('rm.rema_locationid',$input_locationid);
        //     }

        // }
        // else
        // {
        //      $this->db->where('rm.rema_locationid',$this->locationid);
        // }

        if($fromdate &&  $todate){
            if(DEFAULT_DATEPICKER=='NP')
            {
              $this->db->where('rema_reqdatebs >=', $fromdate);
              $this->db->where('rema_reqdatebs <=', $todate);
            }
            else
            {
                $this->db->where('rema_reqdatead >=', $fromdate);
                $this->db->where('rema_reqdatead <=', $todate);
            }
        }
        $this->db->group_by('rm.rema_reqmasterid','DESC');
        $query = $this->db->get();
        //echo $this->db->last_query();die();
        if ($query->num_rows() > 0) 
        {
            $data=$query->result();     
            return $data;       
        }       
        return false;
    }
    public function req_analysis_transfer_details($cond=false)
    {
        $fromdate = $this->input->post('frmDate');
        $todate = $this->input->post('toDate');
        $input_locationid=!empty($this->input->post('locationid'))?$this->input->post('locationid'):'';
        $this->db->select('il.itli_itemname,il.itli_itemcode,rm.rema_reqno,rm.rema_reqdatebs,rd.rede_itemsid,rd.rede_remarks,SUM(rd.rede_qty) as reqqty, SUM(rd.rede_remqty) as remqty, SUM(rd.rede_qty - rd.rede_remqty) as isuedqty,,eq.eqty_equipmenttype');
        $this->db->from('rede_reqdetail rd');
        $this->db->join('rema_reqmaster rm','rm.rema_reqmasterid=rd.rede_reqmasterid');
        $this->db->join('itli_itemslist il', 'il.itli_itemlistid = rd.rede_itemsid', "LEFT");
        $this->db->join('eqty_equipmenttype eq', 'eq.eqty_equipmenttypeid = rm.rema_reqtodepid', "LEFT");
        $this->db->where('rm.rema_isdep', "N");
        if($cond)
        {
            $this->db->where($cond);
        }
        if($this->location_ismain=='Y')
        {
            if($input_locationid)
            {
                $this->db->where('rm.rema_locationid',$input_locationid);
            }

        }
        else
        {
             $this->db->where('rm.rema_locationid',$this->locationid);
        }

        if($fromdate &&  $todate) {
            if(DEFAULT_DATEPICKER=='NP')
            {
              $this->db->where('rema_reqdatebs >=', $fromdate);
              $this->db->where('rema_reqdatebs <=', $todate);
            }
            else
            {
                $this->db->where('rema_reqdatead >=', $fromdate);
                $this->db->where('rema_reqdatead <=', $todate);
            }
        }
    
        $query = $this->db->get();
        //echo $this->db->last_query();die();
        if ($query->num_rows() > 0) 
        {
            $data=$query->result();     
            return $data;       
        }       
        return false;
    }
}