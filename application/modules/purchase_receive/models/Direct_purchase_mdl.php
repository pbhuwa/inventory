<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Direct_purchase_mdl extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->recm_masterTable = 'recm_receivedmaster';
        $this->recd_detailTable = 'recd_receiveddetail';
        $this->tran_masterTable = 'trma_transactionmain';
        $this->tran_detailTable = 'trde_transactiondetail';

        $this->curtime = $this->general->get_currenttime();
        $this->userid = $this->session->userdata(USER_ID);
        $this->username = $this->session->userdata(USER_NAME);
        $this->depid = $this->session->userdata(USER_DEPT);
        $this->storeid = $this->session->userdata(STORE_ID);
        $this->mac = $this->general->get_Mac_Address();
        $this->ip = $this->general->get_real_ipaddr();
        $this->locationid = $this->session->userdata(LOCATION_ID);
        $this->location_ismain = $this->session->userdata(ISMAIN_LOCATION);
        $this->mattypeid = $this->session->userdata(USER_MAT_TYPEID);
        // echo $this->locationid;die;
    }

    public $validate_settings_receive_order_item = array(
        array('field' => 'receipt_no', 'label' => 'Receipt No', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'suplier_bill_no', 'label' => 'Supplier Bill No', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'suplier_bill_date', 'label' => 'Supplier Bill Date', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'fiscalyearid', 'label' => 'Fiscal Year', 'rules' => 'trim|required|xss_clean'),
        // array('field' => 'bill_amount', 'label' => 'Bill Amount', 'rules' => 'trim|required|callback_compareamount[bill_amount]|xss_clean'),
        array('field' => 'clearanceamt', 'label' => 'Clearance Amount', 'rules' => 'trim|required'),
        array('field' => 'supplier', 'label' => 'Supplier', 'rules' => 'trim|required'),
        array('field' => 'trde_itemsid[]', 'label' => 'Item', 'rules' => 'trim|required'),
        array('field' => 'puit_qty[]', 'label' => 'Qty', 'rules' => 'trim|required|numeric|greater_than[0]'),
        array('field' => 'puit_unitprice[]', 'label' => 'Rate', 'rules' => 'trim|required|numeric|greater_than[0]')

    );
    public function order_item_receive_save()
    {
        try{
            $id = $this->input->post('id');
            // echo "<pre>";print_r($this->input->post());die();
            $req_date=$this->input->post('order_date');
            $received_date=$this->input->post('received_date');
            $expiredate =   $this->input->post('end_date');
            $suplier_bill_date =   $this->input->post('suplier_bill_date');
            $trde_expdate= $this->input->post('trde_expdate');
              $mattypeid = $this->input->post('recm_mattypeid');
            $orgid=$this->session->userdata(ORG_ID);
            // echo "<pre>";print_r($orgid);die();
            $school = $this->input->post('recm_school');
            $departmentid = $this->input->post('recm_departmentid');
            $recm_subdepartmentid = $this->input->post('recm_subdepartmentid');
            if (!empty($recm_subdepartmentid)) {
                $departmentid = $recm_subdepartmentid;
            }
              $receivedby = $this->input->post('recm_receivedby');

            if(DEFAULT_DATEPICKER=='NP')
               {   
                $suplier_bill_dateNp=$suplier_bill_date;
                $suplier_bill_dateEn=$this->general->NepToEngDateConv($suplier_bill_date);
                //$expiredateNp=$trde_expdate;
                //$expiredateEn=$this->general->NepToEngDateConv($trde_expdate);
                $orderdateNp=$req_date;
                $orderdateEn=$this->general->NepToEngDateConv($req_date);

                $receivedateNp=$received_date;
                $receivedateEn=$this->general->NepToEngDateConv($received_date);
            }
            else
            {   
                $suplier_bill_dateEn=$suplier_bill_date;
                $suplier_bill_dateNp=$this->general->EngToNepDateConv($suplier_bill_date);
                //$expiredateEn=$trde_expdate;
                //$expiredateNp=$this->general->EngToNepDateConv($trde_expdate);
                $orderdateEn=$req_date;
                $orderdateNp=$this->general->EngToNepDateConv($req_date);

                $receivedateEn=$received_date;
                $receivedateNp=$this->general->NepToEngDateConv($received_date);
            } 
            
            $order_number=$this->input->post('order_number');
            $fiscal_year=$this->input->post('fiscalyearid');
            $supplierid = $this->input->post('supplier');
            $rema_manualno = $this->input->post('rema_manualno');
            $suplier_bill_no = $this->input->post('suplier_bill_no');
            // $receiveno = $this->input->post('receiveno');
            $description = $this->input->post('description');
            $code =   $this->input->post('puit_barcode');
            $batch_no =   $this->input->post('unit');
            $itemsid =   $this->input->post('trde_itemsid');
            $itemname = $this->input->post('itemname');
            $unit =   $this->input->post('puit_unitid');
            $qty =   $this->input->post('puit_qty');
            $taxtype =   $this->input->post('puit_taxid');
            $subottaltotal = $this->input->post('subtotalamt');
            $grandtotal = $this->input->post('totalamount');
            $tax =   $this->input->post('tax');
            $free =   $this->input->post('free');
            $puit_unitprice =   $this->input->post('puit_unitprice');
            $unitprice =   $this->input->post('unitprice');
            $discounttype =   $this->input->post('discounttype');
            $discountper =   $this->input->post('discount');
            $discountamt =   $this->input->post('disamt');
            $reqno= $this->input->post('sama_requisitionno');
            $insurance = $this->input->post('insurance');
            $carriage = $this->input->post('carriage');
            $packing = $this->input->post('packing');
            $transportamt = $this->input->post('transportamt');
            $otheramt = $this->input->post('otheramt');
            $other_description=$this->input->post('other_description');

            $receivedetailid = $this->input->post('receiveddetailid');
            
            $cc = $this->input->post('cc');

            $vat = $this->input->post('vat');
            $vatamt = $this->input->post('vatamt');

            $amount = $this->input->post('totalamt');

            $total_discountamt = $this->input->post('discountamt');
            $total_taxamt = $this->input->post('taxamt');

            //masster table 
            $remarks = $this->input->post('remarks');
            $bugetid = $this->input->post('bugetid');
            //insert form direct purchase in trans details and master
            
            $refund = $this->input->post('rf');
            // $receipt_no = $this->input->post('receipt_no');
            $currentfyrs=CUR_FISCALYEAR;

            $recm_typeid=$this->input->post('recm_typeid');
            $recm_receivetypeother=$this->input->post('recm_receivetypeother');

             $this->db->select('recm_invoiceno,recm_fyear')
            ->from('recm_receivedmaster')
            ->where('recm_locationid', $this->locationid);
        if (ORGANIZATION_NAME == 'KU') {
            if ($this->mattypeid) {
                $this->db->where('recm_mattypeid', $this->mattypeid);
            } else {
                $this->db->where('recm_mattypeid', $mattypeid);
            }
        }

        $cur_fiscalyrs_invoiceno = $this->db->order_by('recm_fyear', 'DESC')
            ->limit(1)
            ->get()->row();

        // echo "<pre>";
        // echo($this->db->last_query());
        // die();

        // echo "<pre>";
        // print_r($cur_fiscalyrs_invoiceno);
        // die();

        if (!empty($cur_fiscalyrs_invoiceno)) {
            $invoice_format = $cur_fiscalyrs_invoiceno->recm_invoiceno;

            $invoice_string = str_split($invoice_format);
            // echo "<pre>";
            // print_r($invoice_string);
            // die();
            $invoice_prefix_len = strlen(RECEIVED_NO_PREFIX);
            $chk_first_string_after_invoice_prefix = $invoice_string[$invoice_prefix_len];
            // echo $chk_first_string_after_invoice_prefix;
            // die();
            if ($chk_first_string_after_invoice_prefix == '0') {
                $invoice_no_prefix = RECEIVED_NO_PREFIX . CUR_FISCALYEAR;
            } else if ($cur_fiscalyrs_invoiceno->recm_fyear == $currentfyrs && $chk_first_string_after_invoice_prefix == '0') {
                $invoice_no_prefix = RECEIVED_NO_PREFIX . CUR_FISCALYEAR;
            } else if ($cur_fiscalyrs_invoiceno->recm_fyear != $currentfyrs && $chk_first_string_after_invoice_prefix == '0') {
                $invoice_no_prefix = RECEIVED_NO_PREFIX . CUR_FISCALYEAR;
            } else if ($cur_fiscalyrs_invoiceno->recm_fyear != $currentfyrs && $chk_first_string_after_invoice_prefix != '0') {
                $invoice_no_prefix = RECEIVED_NO_PREFIX . CUR_FISCALYEAR;
            } else {
                $invoice_no_prefix = RECEIVED_NO_PREFIX;
            }
        } else {
            $invoice_no_prefix = RECEIVED_NO_PREFIX . CUR_FISCALYEAR;
        }

        // $this->data['received_no']=$this->generate_receiveno();
        if (ORGANIZATION_NAME == 'KU' || ORGANIZATION_NAME=='ARMY') {
            $invoice_no_prefix = '';
            if ($this->mattypeid) {
                $mattypeid = $this->mattypeid;
            } else {
                $mattypeid = $mattypeid;
            }

            $received_no = $this->general->generate_invoiceno('recm_invoiceno', 'recm_invoiceno', 'recm_receivedmaster', $invoice_no_prefix, RECEIVED_NO_LENGTH, array('recm_mattypeid' => $mattypeid,'recm_fyear'=>$fiscal_year), 'recm_locationid', 'recm_fyear DESC ,recm_receivedmasterid  DESC', 'M', false, 'Y');
            // echo $this->db->last_query();
            // die();
        } else {
            $received_no = $this->general->generate_invoiceno('recm_invoiceno', 'recm_invoiceno', 'recm_receivedmaster', $invoice_no_prefix, RECEIVED_NO_LENGTH, false, 'recm_locationid', 'recm_fyear DESC ,recm_receivedmasterid  DESC', 'M');
        }

            // $receipt_no = $this->general->generate_invoiceno('recm_invoiceno','recm_invoiceno','recm_receivedmaster',RECEIVED_NO_PREFIX,RECEIVED_NO_LENGTH);

            // print_r($receipt_no);
            // die();
            // $trma_transactiontype = $this->input->post('trma_transactiontype');//form direct purchasre always PURCHASE
            $trma_transactiontype = 'PURCHASE';
            $trma_status = $this->input->post('trma_status'); 
            $supplierid = $this->input->post('supplier'); 
            $matdsupplierbillno = $this->input->post('trde_supplierbillno');

            $receiveno = $this->general->getLastNo('recm_receivedno',$this->recm_masterTable,array('recm_fyear'=>$fiscal_year, 'recm_locationid'=>$this->locationid,'recm_storeid'=>$this->storeid));

            // echo $this->db->last_query();
            // die();

            // print_r($receiveno);
            // die();
            $this->db->trans_begin();
           // echo $this->db->last_query();die;
            
            if($id){
                // echo "task remaining";
                // die();


                $old_recd_list = $this->db->select('recd_receiveddetailid')
                                        ->from('recd_receiveddetail')
                                        ->where('recd_receivedmasterid',$id)
                                        ->get()
                                        ->result();
                // echo "<pre>";
                // print_r($old_recd_list);
                // die();

                        // (array('rede_reqmasterid'=>$id)); // check old req detail ids

                $old_recd_array=array();

                if(!empty($old_recd_list)){

                    foreach($old_recd_list as $key=>$value){

                        $old_recd_array[] = $value->recd_receiveddetailid;

                    }

                }

                $receivedmasterid=$id;
                $trans_main_id = '';
                if (!empty($receivedetailid)) :
                    $first_rec_dtlid = !empty($receivedetailid[0]) ? $receivedetailid[0] : '';
                    // echo "f_r_d".$first_rec_dtlid;
                    $this->db->select('trde_trdeid,trde_trmaid');
                    $this->db->from('trde_transactiondetail');
                    $this->db->where('trde_mtdid', $first_rec_dtlid);
                    $this->db->order_by('trde_trdeid', 'ASC');
                    $rslt_trdetail = $this->db->get()->row();

                    // echo "<pre>";
                    // print_r($rslt_trdetail);
                    // die();
                    if (!empty($rslt_trdetail)) {
                        $trans_main_id = $rslt_trdetail->trde_trmaid;
                    }

                endif;

              $insertdtl_arr=array();
                $UpdatereceivedMasterArray = array(
                    'recm_purchaseorderno'=>!empty($order_number)?$order_number:0,
                    'recm_receiveddatead'=>$receivedateEn,
                    'recm_receiveddatebs'=>$receivedateNp,
                    'recm_fyear'=>$fiscal_year,
                    'recm_insurance' => $insurance,
                    'recm_carriagefreight' => $carriage,
                    'recm_packing' => $packing,
                    'recm_transportcourier' => $transportamt,
                    'recm_others' => $otheramt,
                    'recm_othersdescription'=>$other_description,
                    'recm_amount'=>$subottaltotal,
                    'recm_discount'=>$total_discountamt,
                    'recm_refund' => $refund,
                    'recm_taxamount'=>$total_taxamt,
                    'recm_purchaseorderdatebs'=>$orderdateNp,
                    'recm_purchaseorderdatead'=>$orderdateEn,
                    'recm_remarks'=>$remarks, 
                    'recm_budgetid' => $bugetid,
                    'recm_supplierbillno'=>$suplier_bill_no,
                    'recm_clearanceamount'=>$grandtotal,
                    'recm_supplierid'=>$supplierid,
                    'recm_supbilldatebs'=>$suplier_bill_dateNp,
                    'recm_supbilldatead'=>$suplier_bill_dateEn,
                    'recm_departmentid'=>$departmentid,
                    'recm_typeid'=>$recm_typeid, 
                    'recm_receivetypeother'=>$recm_receivetypeother );

                  $updateTransmasterArray = array(
                    'trma_transactiondatead' => $receivedateEn,
                    'trma_transactiondatebs' => $receivedateNp,
                    'trma_modifytime' => $this->curtime,
                    'trma_modifyby' => $this->userid,
                    'trma_modifyip' => $this->ip,
                    'trma_modifymac' => $this->mac,
                    'trma_receiveddatead' => $received_datead,
                    'trma_receiveddatebs' => $received_datebs,
                );

                if (!empty($UpdatereceivedMasterArray)) {
                    $this->db->update('recm_receivedmaster', $UpdatereceivedMasterArray, array('recm_receivedmasterid' => $receivedmasterid));
                    $lastupdateId= $this->db->affected_rows();

                    $this->general->save_log('recm_receivedmaster', 'recm_receivedmasterid', $receivedmasterid, $UpdatereceivedMasterArray, 'Update');

                    if (!empty($updateTransmasterArray)) {
                        $this->db->update('trma_transactionmain', $updateTransmasterArray, array('trma_trmaid' => $trans_main_id));
                        $this->general->save_log('trma_transactionmain', 'trma_trmaid', $trans_main_id, $updateTransmasterArray, 'Update');
                    }
                    if(!empty($lastupdateId)){

                    foreach ($itemsid  as $key => $val) {
                    $recived_detailid= !empty($receivedetailid[$key])?$receivedetailid[$key]:'';
    
                     if(in_array($recived_detailid, $old_recd_array)){
                            $rede_array[] = $recived_detailid;
                        }

                    $itmname = !empty($itemname[$key])?$itemname[$key]:'';
                    $desc = !empty($description[$key])?$description[$key]:'';
                    $purchased_qty = !empty($qty[$key]) ? $qty[$key] : 0;
                    $amount_total = !empty($amount[$key]) ? $amount[$key] : 0;
                    $actualrate =    $amount_total / $purchased_qty;

                    if($recived_detailid){
                            $receivedDetailUpdateArray=array(
                            'recd_itemsid'=> !empty($itemsid[$key])?$itemsid[$key]:'',
                            'recd_purchasedqty'=>!empty($qty[$key])?$qty[$key]:'',
                            'recd_batchno'=> !empty($batch_no[$key])?$batch_no[$key]:'',
                            'recd_cccharge'=> !empty($cc[$key])?$cc[$key]:'',
                            'recd_arate'=> !empty($actualrate)?$actualrate:'',
                            'recd_salerate'=> !empty($puit_unitprice[$key])?$puit_unitprice[$key]:'',
                            'recd_unitprice' => !empty($puit_unitprice[$key])?$puit_unitprice[$key]:'',
                            'recd_arate' => $actualrate,
                            'recd_vatpc'=> !empty($vat[$key])?$vat[$key]:'',
                            'recd_vatamt' =>!empty($vatamt[$key])?$vatamt[$key]:'',
                            'recd_free'=> !empty($free[$key])?$free[$key]:'',
                            'recd_amount'=> !empty($amount[$key])?$amount[$key]:'',
                            'recd_unitprice'=> !empty($puit_unitprice[$key])?$puit_unitprice[$key]:'',
                            'recd_discountpc'=> !empty($discountper[$key])?$discountper[$key]:'',
                                            //'puit_taxid'=> !empty($taxtype[$key])?$taxtype[$key]:'',
                            'recd_description'=> !empty($desc)?$desc:'',
                            'recd_discountamt'=> !empty($discountamt[$key])?$discountamt[$key]:''
                            //'recd_expdatead'=>expiredateEn,
                            //'recd_expdatebs'=>expiredateNp,
                           
                            );

                            
                            $tran_detailUpdateArray = array(
                                 'trde_transactiondatead'=>$receivedateEn,
                                 'trde_transactiondatebs'=>$receivedateNp,
                                'trde_itemsid' => !empty($itemsid[$key]) ? $itemsid[$key] : '',
                                'trde_expdatebs' => $expirydatebs,
                                'trde_expdatead' => $expirydatead,
                                'trde_batchno' => !empty($batchno[$key]) ? $batchno[$key] : '',
                                'trde_requiredqty' => !empty($purchased_qty) ? $purchased_qty : '0.00',
                                'trde_issueqty' => !empty($purchased_qty) ? $purchased_qty : '0.00',
                                'trde_status' => 'O',
                                'trde_unitprice' => $actualrate,
                                'trde_selprice' => !empty($rate[$key]) ? $rate[$key] : '',
                                'trde_description' => !empty($description[$key]) ? $description[$key] : '',
                                'trde_temperature' => !empty($temperature[$key]) ? $temperature[$key] : '',
                                'trde_newissueqty' => !empty($purchased_qty) ? $purchased_qty : '0.00',
                            );


                             if (!empty($receivedDetailUpdateArray)) {
                                $this->db->where(array('recd_receiveddetailid'=>$recived_detailid));
                                $this->db->update('recd_receiveddetail', $receivedDetailUpdateArray);
                            }
                            if (!empty($tran_detailUpdateArray)) {
                                // print_r($tran_detailUpdateArray);
                                // die();
                                 $this->db->where(array('trde_mtdid'=>$recived_detailid));
                                 $this->db->update('trde_transactiondetail', $tran_detailUpdateArray);
                            }


                    }else{
                        
                            $receivedDetailInsertArray=array(
                            'recd_receivedmasterid'=>$receivedmasterid,
                            'recd_itemsid'=> !empty($itemsid[$key])?$itemsid[$key]:'',
                            'recd_purchasedqty'=>!empty($qty[$key])?$qty[$key]:'',
                            'recd_batchno'=> !empty($batch_no[$key])?$batch_no[$key]:'',
                            'recd_cccharge'=> !empty($cc[$key])?$cc[$key]:'',
                            'recd_arate'=> !empty($actualrate)?$actualrate:'',
                            'recd_salerate'=> !empty($puit_unitprice[$key])?$puit_unitprice[$key]:'',
                            'recd_unitprice' => !empty($puit_unitprice[$key])?$puit_unitprice[$key]:'',
                            'recd_arate' => $actualrate,
                            'recd_vatpc'=> !empty($vat[$key])?$vat[$key]:'',
                            'recd_vatamt' =>!empty($vatamt[$key])?$vatamt[$key]:'',
                            'recd_free'=> !empty($free[$key])?$free[$key]:'',
                            'recd_amount'=> !empty($amount[$key])?$amount[$key]:'',
                            'recd_unitprice'=> !empty($puit_unitprice[$key])?$puit_unitprice[$key]:'',
                            'recd_discountpc'=> !empty($discountper[$key])?$discountper[$key]:'',
                                            //'puit_taxid'=> !empty($taxtype[$key])?$taxtype[$key]:'',
                            'recd_description'=> !empty($desc)?$desc:'',
                            'recd_discountamt'=> !empty($discountamt[$key])?$discountamt[$key]:'',
                            'recd_postdatead'=>CURDATE_EN,
                            'recd_postdatebs'=>CURDATE_NP,
                            'recd_enteredby'=>$this->username,
                            'recd_postusername' => $this->username,
                            'recd_posttime'=>$this->curtime,
                            'recd_postby'=>$this->userid,
                            'recd_postmac'=>$this->mac,
                            'recd_postip'=>$this->ip,
                            'recd_locationid'=>$this->locationid,
                            'recd_orgid'=>$orgid 
                           
                            );


                            $this->db->insert($this->recd_detailTable,$receivedDetailInsertArray);
                            $insertdetail_id =$this->db->insert_id();
                            $insertdtl_arr[]=$insertdetail_id;

                            if(!empty($insertdetail_id)){
                             $tran_detailInsertArray = array(
                            'trde_trmaid'=>$trans_main_id,
                            'trde_itemsid'=> !empty($itemsid[$key])?$itemsid[$key]:'',
                            'trde_mtdid'=>$insertdetail_id,
                            'trde_unitprice'=> !empty($actualrate)?$actualrate:'0.00',
                            'trde_description'=> !empty($itemname[$key])?$itemname[$key]:'',
                            'trde_transactiondatead'=>$receivedateEn,
                            'trde_transactiondatebs'=>$receivedateNp,
                            'trde_sysdate'=>CURDATE_EN,
                            'trde_transactiontype'=>$trma_transactiontype,
                            'trde_supplierbillno'=>$matdsupplierbillno,
                            'trde_supplierid'=>$supplierid,
                            'trde_remarks'=>!empty($description[$key])?$description[$key]:'',
                            'trde_status'=>'O',
                            'trde_mtmid'=>$supplierid,
                            'trde_newissueqty'=>!empty($qty[$key])?$qty[$key]:'',
                            'trde_stripqty'=>!empty($qty[$key])?$qty[$key]:'',
                            'trde_issueqty'=>!empty($qty[$key])?$qty[$key]:'',
                            'trde_requiredqty'=>!empty($qty[$key])?$qty[$key]:'',
                            'trde_description' => !empty($description[$key]) ? $description[$key] : '',
                            // 'trde_expdatebs'=>!empty($trde_expdate[$key])?$trde_expdate[$key]:'',
                            //'trde_expdatead'=>!empty($expiredateEn[$key])?$expiredateEn[$key]:'',
                            'trde_selprice'=>!empty($puit_unitprice[$key])?$puit_unitprice[$key]:'',
                            'trde_postdatead'=>CURDATE_EN,
                            'trde_postdatebs'=>CURDATE_NP,
                            'trde_posttime'=>$this->curtime,
                            'trde_postby'=>$this->userid,
                            'trde_postmac'=>$this->mac,
                            'trde_postip'=>$this->ip,
                            'trde_locationid'=>$this->locationid,
                            'trde_orgid'=>$orgid
                            );

                             if(!empty($tran_detailInsertArray)){
                                 $this->db->insert($this->tran_detailTable,$tran_detailInsertArray);
                             }
                        }
                   }
                }
            }

               
               

                if(is_array($rede_array)){
                    $deleted_items = array_diff($old_recd_array, $rede_array);
                }
                $del_items_num = count($deleted_items);
                // echo "<pre>";
                // print_r($deleted_items);
                // die();
                if(!empty($del_items_num)){
                    for($i = 0; $i<$del_items_num; $i++){
                        $deleted_array = array_values($deleted_items);
                        foreach($deleted_array as $key=>$del){
                            $this->db->where(array('recd_receiveddetailid'=>$del));
                            $this->db->delete('recd_receiveddetail');

                            $this->db->where(array('trde_mtdid'=>$del));
                            $this->db->delete('trde_transactiondetail');
                        }
                }
            }
    }                
}else{
            //new direct purchase
            $ReceiveMasterArray = array(
            'recm_purchaseorderno'=>!empty($order_number)?$order_number:0,
            'recm_receiveddatead'=>$receivedateEn,
            'recm_receiveddatebs'=>$receivedateNp,
            'recm_fyear'=>$fiscal_year,
            'recm_insurance' => $insurance,
            'recm_carriagefreight' => $carriage,
            'recm_packing' => $packing,
            'recm_transportcourier' => $transportamt,
            'recm_others' => $otheramt,
            'recm_othersdescription'=>$other_description,
            'recm_amount'=>$subottaltotal,
            'recm_discount'=>$total_discountamt,
            'recm_refund' => $refund,
            'recm_taxamount'=>$total_taxamt,
            'recm_purchaseorderdatebs'=>$orderdateNp,
            'recm_purchaseorderdatead'=>$orderdateEn,
            'recm_remarks'=>$remarks, 
            'recm_budgetid' => $bugetid,
            'recm_invoiceno' => $received_no,
            'recm_purchasestatus'=>'D',
            'recm_status'=>'O',
            'recm_receivedno'=>$receiveno+1,
            'recm_supplierbillno'=>$suplier_bill_no,
            'recm_dstat'=>'D',
            'recm_tstat'=>'S',
            'recm_reqno'=>$reqno,
            'recm_clearanceamount'=>$grandtotal,
            'recm_supplierid'=>$supplierid,
            'recm_supbilldatebs'=>$suplier_bill_dateNp,
            'recm_supbilldatead'=>$suplier_bill_dateEn,
            'recm_postdatead'=>CURDATE_EN,
            'recm_postdatebs'=>CURDATE_NP,
            'recm_posttime'=>$this->curtime,
            'recm_enteredby'=>$this->userid,
            'recm_postby'=>$this->userid,
            'recm_postusername'=>$this->username,
            'recm_departmentid'=>$departmentid,
            'recm_storeid'=>$this->storeid,
            'recm_locationid'=>$this->locationid,
            'recm_postmac'=>$this->mac,
            'recm_postip'=>$this->ip,
            'recm_orgid'=>$orgid,
            'recm_typeid'=>$recm_typeid, 
             'recm_receivetypeother'=>$recm_receivetypeother 

        );
        if(!empty($ReceiveMasterArray))
                {   //echo"<pre>"; print_r($ReceiveMasterArray);
                if (!empty($mattypeid)) {
                    $ReceiveMasterArray['recm_mattypeid'] = $mattypeid;
                }
                if (!empty($school)) {
                    $ReceiveMasterArray['recm_school'] = $school;
                }
                if (!empty($departmentid)) {
                    $ReceiveMasterArray['recm_departmentid'] = $departmentid;
                }

                if (!empty($receivedby)) {
                    $received_arr = explode(',', $receivedby);
                    $ReceiveMasterArray['recm_receivedstaffid'] = !empty($received_arr[0]) ? $received_arr[0] : '';
                    $ReceiveMasterArray['recm_receivedby'] = !empty($received_arr[1]) ? $received_arr[1] : '';
                }

            $this->db->insert($this->recm_masterTable,$ReceiveMasterArray);
            $insertid=$this->db->insert_id();
            if($insertid)
            {
                foreach ($itemsid  as $key => $val) {
                    $itmname = !empty($itemname[$key])?$itemname[$key]:'';
                    $desc = !empty($description[$key])?$description[$key]:'';
                    $purchased_qty = !empty($qty[$key]) ? $qty[$key] : 0;
                    $amount_total = !empty($amount[$key]) ? $amount[$key] : 0;
                    $actualrate =    $amount_total / $purchased_qty;

                    $directpur_det=array(
                        'recd_receivedmasterid'=>$insertid,
                        'recd_itemsid'=> !empty($itemsid[$key])?$itemsid[$key]:'',
                        'recd_purchasedqty'=>!empty($qty[$key])?$qty[$key]:'',
                        'recd_batchno'=> !empty($batch_no[$key])?$batch_no[$key]:'',
                        'recd_cccharge'=> !empty($cc[$key])?$cc[$key]:'',
                        'recd_arate'=> !empty($actualrate)?$actualrate:'',
                        'recd_salerate'=> !empty($puit_unitprice[$key])?$puit_unitprice[$key]:'',
                         'recd_unitprice' => !empty($puit_unitprice[$key])?$puit_unitprice[$key]:'',
                         'recd_arate' => $actualrate,
                         
                        'recd_vatpc'=> !empty($vat[$key])?$vat[$key]:'',
                        'recd_vatamt' =>!empty($vatamt[$key])?$vatamt[$key]:'',
                                            //'recd_controlno'=>'Not Found'
                        'recd_qualitystatus' => 'O',
                        'recd_status' => 'O',
                        'recd_st'=>'N',
                        'recd_free'=> !empty($free[$key])?$free[$key]:'',
                        'recd_amount'=> !empty($amount[$key])?$amount[$key]:'',
                        'recd_unitprice'=> !empty($puit_unitprice[$key])?$puit_unitprice[$key]:'',
                        'recd_discountpc'=> !empty($discountper[$key])?$discountper[$key]:'',
                                        //'puit_taxid'=> !empty($taxtype[$key])?$taxtype[$key]:'',
                        'recd_description'=> !empty($desc)?$desc:'',
                        'recd_discountamt'=> !empty($discountamt[$key])?$discountamt[$key]:'',
                                        //'recd_expdatead'=>expiredateEn,
                                        //'recd_expdatebs'=>expiredateNp,
                        'recd_postdatead'=>CURDATE_EN,
                        'recd_postdatebs'=>CURDATE_NP,
                        'recd_enteredby'=>$this->username,
                        'recd_postusername' => $this->username,
                        'recd_posttime'=>$this->curtime,
                        'recd_postby'=>$this->userid,
                        'recd_postmac'=>$this->mac,
                        'recd_postip'=>$this->ip,
                        'recd_locationid'=>$this->locationid,
                        'recd_orgid'=>$orgid 

                    );
                    if(!empty($directpur_det))
                            {  //echo"reqdata"; echo"<pre>";print_r($directpur_det);
                        $this->db->insert($this->recd_detailTable,$directpur_det);
                        $detail_insertArray[] =$this->db->insert_id();
                    }
                }
                
            }
            foreach ($itemsid  as $key => $val) {
                $itemid = !empty($itemsid[$key])?$itemsid[$key]:'';
                $unitprice = !empty($puit_unitprice[$key])?$puit_unitprice[$key]:'';
                $this->general->compare_item_price($itemid,$unitprice);
                        // echo $this->db->last_query();
            } 
        }
        $transMasterArray = array(
            'trma_transactiondatead'=>$receivedateEn,
            'trma_transactiondatebs'=>$receivedateNp,
            'trma_fromdepartmentid'=>$this->storeid,//not found
            'trma_todepartmentid'=>$this->storeid,//not found
            'trma_fromby'=>$this->username,
            'trma_toby'=>$this->username,
            'trma_status'=>'O',
            'trma_received'=>'1',
            //'trma_issueno'=>,not found
            'trma_fyear'=>$fiscal_year,
            'trma_transactiontype'=>$trma_transactiontype,//form direct purchasre
            'trma_sttransfer'=>'N',
            'trma_postdatead'=>CURDATE_EN,
            'trma_postdatebs'=>CURDATE_NP,
            'trma_sysdate'=>CURDATE_NP,
            'trma_posttime'=>$this->curtime,
            'trma_postby'=>$this->userid,
            'trma_postusername'=>$this->username,
            'trma_postmac'=>$this->mac,
            'trma_postip'=>$this->ip,
            'trma_locationid'=>$this->locationid,
            'trma_orgid'=>$orgid                              

                                    );
        if(!empty($transMasterArray))
                {   //echo"<pre>"; print_r($transMasterArray);
            $this->db->insert($this->tran_masterTable,$transMasterArray);
            $insertidtr=$this->db->insert_id();
            if($insertidtr)
            {
                foreach ($itemname as $key => $val) {
                     $purchased_qty = !empty($qty[$key]) ? $qty[$key] : 0;
                     $amount_total = !empty($amount[$key]) ? $amount[$key] : 0;
                     $actualrate =    $amount_total / $purchased_qty;

                    $tranDetail[]=array(
                        'trde_trmaid'=>$insertidtr,
                        'trde_itemsid'=> !empty($itemsid[$key])?$itemsid[$key]:'',
                        'trde_mtdid'=>!empty($detail_insertArray[$key])?$detail_insertArray[$key]:'',
                                        //'trde_controlno'=> !empty($trde_unitpercase[$key])?$trde_unitpercase[$key]:'',notfound
                        'trde_unitprice'=> !empty($actualrate)?$actualrate:'0.00',
                        'trde_description'=> !empty($itemname[$key])?$itemname[$key]:'',
                        'trde_transactiondatead'=>$receivedateEn,
                        'trde_transactiondatebs'=>$receivedateNp,
                        'trde_sysdate'=>CURDATE_EN,
                        'trde_transactiontype'=>$trma_transactiontype,
                        'trde_supplierbillno'=>$matdsupplierbillno,
                        'trde_supplierid'=>$supplierid,

                                        //'trde_mtdid'=>, not found entered while direct purchase
                                        //'trde_issueno'=>not found entered while direct purchase
                        'trde_remarks'=>!empty($description[$key])?$description[$key]:'',
                        'trde_status'=>'O',
                        'trde_mtmid'=>$supplierid,
                        'trde_newissueqty'=>!empty($qty[$key])?$qty[$key]:'',
                        'trde_stripqty'=>!empty($qty[$key])?$qty[$key]:'',
                        'trde_issueqty'=>!empty($qty[$key])?$qty[$key]:'',
                        'trde_requiredqty'=>!empty($qty[$key])?$qty[$key]:'',
                         'trde_description' => !empty($description[$key]) ? $description[$key] : '',
                                        // 'trde_expdatebs'=>!empty($trde_expdate[$key])?$trde_expdate[$key]:'',
                                        //'trde_expdatead'=>!empty($expiredateEn[$key])?$expiredateEn[$key]:'',
                        'trde_selprice'=>!empty($puit_unitprice[$key])?$puit_unitprice[$key]:'',
                        'trde_postdatead'=>CURDATE_EN,
                        'trde_postdatebs'=>CURDATE_NP,
                        'trde_posttime'=>$this->curtime,
                        'trde_postby'=>$this->userid,
                        'trde_postmac'=>$this->mac,
                        'trde_postip'=>$this->ip,
                        'trde_locationid'=>$this->locationid,
                        'trde_orgid'=>$orgid,

                    );
                }
                        //echo"<pre>";print_r($tranDetail);die;
                if(!empty($tranDetail))
                {  
                    $this->db->insert_batch($this->tran_detailTable,$tranDetail);
                }
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
        if($id){
            return $id;
        }else{
            return $insertid;
        }
    }
}catch(Exception $e){
    $this->db->trans_rollback();
    throw $e;
}
}
    public function get_direct_received_list_new($cond = false)
    {
        $get = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }

        if (!empty($get['sSearch_1'])) {
            $this->db->where("recm_receiveddatebs like  '%" . $get['sSearch_1'] . "%'  ");
        }

        if (!empty($get['sSearch_2'])) {
            $this->db->where("recm_receiveddatead like  '%" . $get['sSearch_2'] . "%'  ");
        }

        if (!empty($get['sSearch_3'])) {
            $this->db->where("recm_invoiceno like  '%" . $get['sSearch_3'] . "%'  ");
        }

        if (!empty($get['sSearch_4'])) {
            $this->db->where("recm_receivedno like  '%" . $get['sSearch_4'] . "%'  ");
        }

        if (!empty($get['sSearch_5'])) {
            $this->db->where("dist_distributor like  '%" . $get['sSearch_5'] . "%'  ");
        }

        if (!empty($get['sSearch_6'])) {
            $this->db->where("recm_fyear like  '%" . $get['sSearch_6'] . "%'  ");
        }

        if ($cond) {
            $this->db->where($cond);
        }

        $srchtext=!empty($get['srchtext'])?$get['srchtext']:'';

        // echo $srchtext;
        // die();

        $fromdate = !empty($get['frmDate']) ? $get['frmDate'] : $this->input->post('frmDate');
        $todate = !empty($get['toDate']) ? $get['toDate'] : $this->input->post('toDate');
        //echo"<pre>";print_r($this->input->get());die;
        $fyear = !empty($get['fyear']) ? $get['fyear'] : $this->input->post('fyear');
        $locationid = !empty($get['locationid']) ? $get['locationid'] : $this->input->post('locationid');

        $store_id = !empty($get['store_id']) ? $get['store_id'] : $this->input->post('store_id');

        $searchDateType=!empty($get['searchDateType']) ? $get['searchDateType']:'';
        if($searchDateType!='date_all'){
            if ($fromdate &&  $todate) {
            if (DEFAULT_DATEPICKER == 'NP') {
                $this->db->where('recm_receiveddatebs >=', $fromdate);
                $this->db->where('recm_receiveddatebs <=', $todate);
            } else {
                $this->db->where('recm_receiveddatead >=', $fromdate);
                $this->db->where('recm_receiveddatead <=', $todate);
            }
        }
        }
        
        if ($fyear) {
            $this->db->where('recm_fyear', $fyear);
        }
          if(!empty($srchtext)){
            $this->db->where('recm_invoiceno=',$srchtext);
            // $this->db->where('(recm_invoiceno='.$srchtext.' OR recm_supplierbillno='.$srchtext.')');
        }
 
        // if(!empty($locationid)){
        //  $this->db->where('recm_locationid',$locationid);
        // }
        if ($this->location_ismain == 'Y') {
            if ($locationid) {
                $this->db->where('recm_locationid', $locationid);
            }
        } else {
            $this->db->where('recm_locationid', $this->locationid);
        }

        $resltrpt = $this->db->select("COUNT(*) as cnt")
            ->from('recm_receivedmaster rm')
            ->join('dist_distributors s', 's.dist_distributorid = rm.recm_supplierid', 'left')
            ->where('rm.recm_dstat', 'D')
            ->get()
            ->row();

        // echo $this->db->last_query();die(); 
        $totalfilteredrecs = $resltrpt->cnt;

        $order_by = 'rm.recm_receiveddatebs';
        $order = 'DESC';
        if ($this->input->get('sSortDir_0')) {
            $order = $this->input->get('sSortDir_0');
        }

        $where = '';
        if ($this->input->get('iSortCol_0') == 1)
            $order_by = 'recm_receiveddatebs';
        else if ($this->input->get('iSortCol_0') == 2)
            $order_by = 'recm_receiveddatead';
        else if ($this->input->get('iSortCol_0') == 3)
            $order_by = 'recm_invoiceno';
        else if ($this->input->get('iSortCol_0') == 4)
            $order_by = 'recm_receivedno';
        else if ($this->input->get('iSortCol_0') == 5)
            $order_by = 'dist_distributor';
        else if ($this->input->get('iSortCol_0') == 6)
            $order_by = 'recm_fyear';
        else if ($this->input->get('iSortCol_0') == 7)
            $order_by = 'recm_discount';
        else if ($this->input->get('iSortCol_0') == 8)
            $order_by = 'recm_taxamount';
        else if ($this->input->get('iSortCol_0') == 9)
            $order_by = 'recm_clearanceamount';
        $totalrecs = '';
        $limit = 15;
        $offset = 1;
        $get = $_GET;

        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }

        if (!empty($_GET["iDisplayLength"])) {
            $limit = $_GET['iDisplayLength'];
            $offset = $_GET["iDisplayStart"];
        }

        if (!empty($get['sSearch_1'])) {
            $this->db->where("recm_receiveddatebs like  '%" . $get['sSearch_1'] . "%'  ");
        }

        if (!empty($get['sSearch_2'])) {
            $this->db->where("recm_receiveddatead like  '%" . $get['sSearch_2'] . "%'  ");
        }

        if (!empty($get['sSearch_3'])) {
            $this->db->where("recm_invoiceno like  '%" . $get['sSearch_3'] . "%'  ");
        }

        if (!empty($get['sSearch_4'])) {
            $this->db->where("recm_receivedno like  '%" . $get['sSearch_4'] . "%'  ");
        }

        if (!empty($get['sSearch_5'])) {
            $this->db->where("dist_distributor like  '%" . $get['sSearch_5'] . "%'  ");
        }

        if (!empty($get['sSearch_6'])) {
            $this->db->where("recm_fyear like  '%" . $get['sSearch_6'] . "%'  ");
        }
        if (!empty($get['sSearch_7'])) {
            $this->db->where("recm_discount like  '%" . $get['sSearch_7'] . "%'  ");
        }
        if (!empty($get['sSearch_8'])) {
            $this->db->where("recm_taxamount like  '%" . $get['sSearch_8'] . "%'  ");
        }
        if (!empty($get['sSearch_9'])) {
            $this->db->where("recm_clearanceamount like  '%" . $get['sSearch_9'] . "%'  ");
        }

        if ($cond) {
            $this->db->where($cond);
        }
        
      

          if($searchDateType!='date_all'){
            if ($fromdate &&  $todate) {
            if (DEFAULT_DATEPICKER == 'NP') {
                $this->db->where('recm_receiveddatebs >=', $fromdate);
                $this->db->where('recm_receiveddatebs <=', $todate);
            } else {
                $this->db->where('recm_receiveddatead >=', $fromdate);
                $this->db->where('recm_receiveddatead <=', $todate);
            }
        }
        }

       
        //  if(!empty($locationid)){
        //     $this->db->where('recm_locationid',$locationid);
        // }
        if ($this->location_ismain == 'Y') {
            if ($locationid) {
                $this->db->where('recm_locationid', $locationid);
            }
        } else {
            $this->db->where('recm_locationid', $this->locationid);
        }
        
        $this->db->select('rm.recm_fyear,rm.recm_supbilldatebs,rm.recm_supbilldatead,rm.recm_supplierbillno,rm.recm_receiveddatead,rm.recm_postdatead,rm.recm_receivedmasterid,rm.recm_receiveddatebs,rm.recm_purchasestatus,rm.recm_invoiceno,rm.recm_receivedno as orderno,rm.recm_amount,s.dist_distributor,rm.recm_discount,rm.recm_taxamount,rm.recm_clearanceamount,rm.recm_posttime,recm_locationid,
        rm.recm_status, recm_fyear');
        $this->db->from('recm_receivedmaster rm');
        $this->db->join('dist_distributors s', 's.dist_distributorid = rm.recm_supplierid', 'left');
        $this->db->where('rm.recm_dstat', 'D');
        if ($fyear) {
            $this->db->where('rm.recm_fyear', $fyear);
        }
        if(!empty($srchtext)){
            $this->db->where('recm_invoiceno=',$srchtext);
            //$this->db->where('(recm_invoiceno='.$srchtext.' OR recm_supplierbillno='.$srchtext.')');
        }
        if ($store_id) {
            $this->db->where('recm_storeid', $store_id);
        }

        $this->db->order_by($order_by, $order);

        if ($limit && $limit > 0) {
            $this->db->limit($limit);
        }
        if ($offset) {
            $this->db->offset($offset);
        }

        $nquery = $this->db->get();

        //echo $this->db->last_query(); die();
        $num_row = $nquery->num_rows();
        // if(!empty($_GET['iDisplayLength'])) {
        //     $totalrecs = sizeof( $nquery);
        // }
        if (!empty($_GET['iDisplayLength']) &&  !empty($nquery) && is_array($nquery) && count($nquery) > 0) {
            $totalrecs = sizeof($nquery);
        }

        if ($num_row > 0) {
            $ndata = $nquery->result();
            $ndata['totalrecs'] = $totalrecs;
            $ndata['totalfilteredrecs'] = $totalfilteredrecs;
        } else {
            $ndata = array();
            $ndata['totalrecs'] = 0;
            $ndata['totalfilteredrecs'] = 0;
        }
        //echo $this->db->last_query();die();
        return $ndata;
    }

    public function get_purchase_return_list_new($cond = false)
    {
        $get = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }

        if (!empty($get['sSearch_1'])) {
            $this->db->where("purr_returndatebs like  '%" . $get['sSearch_1'] . "%'  ");
        }

        if (!empty($get['sSearch_2'])) {
            $this->db->where("purr_returndatead like  '%" . $get['sSearch_2'] . "%'  ");
        }

        if (!empty($get['sSearch_3'])) {
            $this->db->where("purr_invoiceno like  '%" . $get['sSearch_3'] . "%'  ");
        }

        if (!empty($get['sSearch_4'])) {
            $this->db->where("purr_returnno like  '%" . $get['sSearch_4'] . "%'  ");
        }

        if (!empty($get['sSearch_5'])) {
            $this->db->where("dist_distributor like  '%" . $get['sSearch_5'] . "%'  ");
        }

        if (!empty($get['sSearch_6'])) {
            $this->db->where("purr_fyear like  '%" . $get['sSearch_6'] . "%'  ");
        }

        if ($cond) {
            $this->db->where($cond);
        }

        $fromdate = !empty($get['frmDate']) ? $get['frmDate'] : $this->input->post('frmDate');
        $todate = !empty($get['toDate']) ? $get['toDate'] : $this->input->post('toDate');
        //echo"<pre>";print_r($this->input->get());die;
        $fyear = !empty($get['fyear']) ? $get['fyear'] : $this->input->post('fyear');
        $locationid = !empty($get['locationid']) ? $get['locationid'] : $this->input->post('locationid');

        $store_id = !empty($get['store_id']) ? $get['store_id'] : $this->input->post('store_id');

         $srchtext=!empty($get['srchtext'])?$get['srchtext']:'';

        if ($fromdate &&  $todate) {
            if (DEFAULT_DATEPICKER == 'NP') {
                $this->db->where('purr_returndatebs >=', $fromdate);
                $this->db->where('purr_returndatebs <=', $todate);
            } else {
                $this->db->where('purr_returndatead >=', $fromdate);
                $this->db->where('purr_returndatead <=', $todate);
            }
        }
        if ($fyear) {
            $this->db->where('purr_fyear', $fyear);
        }
         if(!empty($srchtext)){
         $this->db->where('purr_invoiceno',$srchtext);
        }
        if ($this->location_ismain == 'Y') {
            if ($locationid) {
                $this->db->where('purr_locationid', $locationid);
            }
        } else {
            $this->db->where('purr_locationid', $this->locationid);
        }

        $resltrpt = $this->db->select("COUNT(*) as cnt")
            ->from('purr_purchasereturn pr')
            ->join('dist_distributors s', 's.dist_distributorid = pr.purr_supplierid', 'left')
            ->get()
            ->row();

        //echo $this->db->last_query();die(); 
        $totalfilteredrecs = $resltrpt->cnt;

        $order_by = 'pr.purr_returndatebs';
        $order = 'DESC';
        if ($this->input->get('sSortDir_0')) {
            $order = $this->input->get('sSortDir_0');
        }

        $where = '';
        if ($this->input->get('iSortCol_0') == 1)
            $order_by = 'purr_returndatebs';
        else if ($this->input->get('iSortCol_0') == 2)
            $order_by = 'purr_returndatead';
        else if ($this->input->get('iSortCol_0') == 3)
            $order_by = 'purr_invoiceno';
        else if ($this->input->get('iSortCol_0') == 4)
            $order_by = 'purr_returnno';
        else if ($this->input->get('iSortCol_0') == 5)
            $order_by = 'dist_distributor';
        else if ($this->input->get('iSortCol_0') == 6)
            $order_by = 'purr_fyear';
        else if ($this->input->get('iSortCol_0') == 7)
            $order_by = 'purr_discount';
        else if ($this->input->get('iSortCol_0') == 8)
            $order_by = 'purr_vatamount';
        else if ($this->input->get('iSortCol_0') == 9)
            $order_by = 'purr_returnamount';
        $totalrecs = '';
        $limit = 15;
        $offset = 1;
        $get = $_GET;

        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }

        if (!empty($_GET["iDisplayLength"])) {
            $limit = $_GET['iDisplayLength'];
            $offset = $_GET["iDisplayStart"];
        }

        if (!empty($get['sSearch_1'])) {
            $this->db->where("purr_returndatebs like  '%" . $get['sSearch_1'] . "%'  ");
        }

        if (!empty($get['sSearch_2'])) {
            $this->db->where("purr_returndatead like  '%" . $get['sSearch_2'] . "%'  ");
        }

        if (!empty($get['sSearch_3'])) {
            $this->db->where("purr_invoiceno like  '%" . $get['sSearch_3'] . "%'  ");
        }

        if (!empty($get['sSearch_4'])) {
            $this->db->where("purr_returnno like  '%" . $get['sSearch_4'] . "%'  ");
        }

        if (!empty($get['sSearch_5'])) {
            $this->db->where("dist_distributor like  '%" . $get['sSearch_5'] . "%'  ");
        }

        if (!empty($get['sSearch_6'])) {
            $this->db->where("purr_fyear like  '%" . $get['sSearch_6'] . "%'  ");
        }
        if (!empty($get['sSearch_7'])) {
            $this->db->where("purr_discount like  '%" . $get['sSearch_7'] . "%'  ");
        }
        if (!empty($get['sSearch_8'])) {
            $this->db->where("purr_vatamount like  '%" . $get['sSearch_8'] . "%'  ");
        }
        if (!empty($get['sSearch_9'])) {
            $this->db->where("purr_returnamount like  '%" . $get['sSearch_9'] . "%'  ");
        }

        if ($cond) {
            $this->db->where($cond);
        }

        $fromdate = !empty($get['frmDate']) ? $get['frmDate'] : $this->input->post('frmDate');
        $todate = !empty($get['toDate']) ? $get['toDate'] : $this->input->post('toDate');
        $locationid = !empty($get['locationid']) ? $get['locationid'] : $this->locationid;
        $srchtext=!empty($get['srchtext'])?$get['srchtext']:'';

        if ($fromdate &&  $todate) {
            if (DEFAULT_DATEPICKER == 'NP') {
                $this->db->where('purr_returndatebs >=', $fromdate);
                $this->db->where('purr_returndatebs <=', $todate);
            } else {
                $this->db->where('purr_returndatead >=', $fromdate);
                $this->db->where('purr_returndatead <=', $todate);
            }
        }
        //  if(!empty($locationid)){
        //     $this->db->where('purr_locationid',$locationid);
        // }
        if(!empty($srchtext)){
         $this->db->where('purr_invoiceno',$srchtext);
        }

        if ($this->location_ismain == 'Y') {
            if ($locationid) {
                $this->db->where('purr_locationid', $locationid);
            }
        } else {
            $this->db->where('purr_locationid', $this->locationid);
        }

        $this->db->select('pr.purr_fyear, pr.purr_returndatebs, pr.purr_returndatead, pr.purr_returnno, pr.purr_postdatead, pr.purr_postdatebs,pr.purr_st, pr.purr_invoiceno, pr.purr_returnamount, pr.purr_discount, pr.purr_receiptno, pr.purr_vatamount, pr.purr_posttime, pr.purr_locationid, s.dist_distributor');
        $this->db->from('purr_purchasereturn pr');
        $this->db->join('dist_distributors s', 's.dist_distributorid = pr.purr_supplierid', 'left');

        if ($fyear) {
            $this->db->where('pr.purr_fyear', $fyear);
        }
        if ($store_id) {
            $this->db->where('purr_storeid', $store_id);
        }

        $this->db->order_by($order_by, $order);

        if ($limit && $limit > 0) {
            $this->db->limit($limit);
        }
        if ($offset) {
            $this->db->offset($offset);
        }

        $nquery = $this->db->get();

        //echo $this->db->last_query(); die();
        $num_row = $nquery->num_rows();
        // if(!empty($_GET['iDisplayLength'])) {
        //     $totalrecs = sizeof( $nquery);
        // }
        if (!empty($_GET['iDisplayLength']) &&  !empty($nquery) && is_array($nquery) && count($nquery) > 0) {
            $totalrecs = sizeof($nquery);
        }

        if ($num_row > 0) {
            $ndata = $nquery->result();
            $ndata['totalrecs'] = $totalrecs;
            $ndata['totalfilteredrecs'] = $totalfilteredrecs;
        } else {
            $ndata = array();
            $ndata['totalrecs'] = 0;
            $ndata['totalfilteredrecs'] = 0;
        }
        //echo $this->db->last_query();die();
        return $ndata;
    }

    public function get_direct_received_list($cond = false)
    {
        $get = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }

        if (!empty($get['sSearch_1'])) {
            $this->db->where("recm_receiveddatebs like  '%" . $get['sSearch_1'] . "%'  ");
        }

        if (!empty($get['sSearch_2'])) {
            $this->db->where("recm_invoiceno like  '%" . $get['sSearch_2'] . "%'  ");
        }

        if (!empty($get['sSearch_3'])) {
            $this->db->where("recm_receivedno like  '%" . $get['sSearch_3'] . "%'  ");
        }
        // if(!empty($get['sSearch_4'])){
        //     $this->db->where("recm_receivedno like  '%".$get['sSearch_4']."%'  ");
        // }
        if (!empty($get['sSearch_4'])) {
            $this->db->where("dist_distributor like  '%" . $get['sSearch_4'] . "%'  ");
        }
        // if(!empty($get['sSearch_5'])){
        //     $this->db->where("budg_budgetname like  '%".$get['sSearch_5']."%'  ");
        // }

        if (!empty($get['sSearch_5'])) {
            $this->db->where("recm_discount like  '%" . $get['sSearch_6'] . "%'  ");
        }
        if (!empty($get['sSearch_6'])) {
            $this->db->where("recm_taxamount like  '%" . $get['sSearch_6'] . "%'  ");
        }
        if (!empty($get['sSearch_7'])) {
            $this->db->where("recm_clearanceamount like  '%" . $get['sSearch_7'] . "%'  ");
        }

        if ($cond) {
            $this->db->where($cond);
        }

        $fromdate = !empty($get['frmDate']) ? $get['frmDate'] : $this->input->post('frmDate');
        $todate = !empty($get['toDate']) ? $get['toDate'] : $this->input->post('toDate');
        //echo"<pre>";print_r($this->input->get());die;
        $fyear = !empty($get['fyear']) ? $get['fyear'] : $this->input->post('fyear');
        $locationid = !empty($get['locationid']) ? $get['locationid'] : $this->input->post('locationid');

        $store_id = !empty($get['store_id']) ? $get['store_id'] : $this->input->post('store_id');

        if ($fromdate &&  $todate) {
            if (DEFAULT_DATEPICKER == 'NP') {
                $this->db->where('recm_receiveddatebs >=', $fromdate);
                $this->db->where('recm_receiveddatebs <=', $todate);
            } else {
                $this->db->where('recm_receiveddatead >=', $fromdate);
                $this->db->where('recm_receiveddatead <=', $todate);
            }
        }
        if ($fyear) {
            $this->db->where('recm_fyear', $fyear);
        }
        //  if(!empty($locationid)){
        //  $this->db->where('itli_locationid',$locationid);
        // }
        if ($this->location_ismain == 'Y') {
            if ($locationid) {
                $this->db->where('itli_locationid', $locationid);
            }
        } else {
            $this->db->where('itli_locationid', $this->locationid);
        }

        $resltrpt = $this->db->select("COUNT(*) as cnt")
            ->from('recm_receivedmaster rm')
            ->join('dist_distributors s', 's.dist_distributorid = rm.recm_supplierid')
            ->join('recd_receiveddetail rd', 'rd.recd_receivedmasterid=rm.recm_receivedmasterid', "LEFT")
            ->join('itli_itemslist il', 'il.itli_itemlistid=rd.recd_itemsid', "LEFT")
            // ->join('budg_budgets b','b.budg_budgetid = rm.recm_budgetid')
            // ->where('recm_purchaseordermasterid !=',0)
            //->where('recm_purchasestatus','D')
            ->get()
            ->row();

        //echo $this->db->last_query();die(); 
        $totalfilteredrecs = $resltrpt->cnt;

        $order_by = 'rm.recm_receiveddatebs';
        $order = 'DESC';
        if ($this->input->get('sSortDir_0')) {
            $order = $this->input->get('sSortDir_0');
        }

        $where = '';
        if ($this->input->get('iSortCol_0') == 1)
            $order_by = 'recm_receiveddatebs';
        else if ($this->input->get('iSortCol_0') == 2)
            $order_by = 'recm_invoiceno';
        else if ($this->input->get('iSortCol_0') == 3)
            $order_by = 'recm_receivedno';
        // else if($this->input->get('iSortCol_0')==4)
        //      $order_by = 'recm_receivedno';
        else if ($this->input->get('iSortCol_0') == 4)
            $order_by = 'dist_distributor';
        // else if($this->input->get('iSortCol_0')==5)
        //     $order_by = 'budg_budgetname';
        else if ($this->input->get('iSortCol_0') == 5)
            $order_by = 'recm_discount';
        else if ($this->input->get('iSortCol_0') == 6)
            $order_by = 'recm_taxamount';
        else if ($this->input->get('iSortCol_0') == 7)
            $order_by = 'recm_clearanceamount';
        $totalrecs = '';
        $limit = 15;
        $offset = 1;
        $get = $_GET;

        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }

        if (!empty($_GET["iDisplayLength"])) {
            $limit = $_GET['iDisplayLength'];
            $offset = $_GET["iDisplayStart"];
        }

        if (!empty($get['sSearch_1'])) {
            $this->db->where("recm_receiveddatebs like  '%" . $get['sSearch_1'] . "%'  ");
        }

        if (!empty($get['sSearch_2'])) {
            $this->db->where("recm_invoiceno like  '%" . $get['sSearch_2'] . "%'  ");
        }

        if (!empty($get['sSearch_3'])) {
            $this->db->where("recm_receivedno like  '%" . $get['sSearch_3'] . "%'  ");
        }
        // if(!empty($get['sSearch_4'])){
        //     $this->db->where("recm_receivedno like  '%".$get['sSearch_4']."%'  ");
        // }
        if (!empty($get['sSearch_4'])) {
            $this->db->where("dist_distributor like  '%" . $get['sSearch_4'] . "%'  ");
        }
        // if(!empty($get['sSearch_5'])){
        //     $this->db->where("budg_budgetname like  '%".$get['sSearch_5']."%'  ");
        // }

        if (!empty($get['sSearch_5'])) {
            $this->db->where("recm_discount like  '%" . $get['sSearch_5'] . "%'  ");
        }
        if (!empty($get['sSearch_6'])) {
            $this->db->where("recm_taxamount like  '%" . $get['sSearch_6'] . "%'  ");
        }
        if (!empty($get['sSearch_7'])) {
            $this->db->where("recm_clearanceamount like  '%" . $get['sSearch_7'] . "%'  ");
        }

        if ($cond) {
            $this->db->where($cond);
        }

        $frmDate = !empty($get['frmDate']) ? $get['frmDate'] : $this->input->post('frmDate');
        $toDate = !empty($get['toDate']) ? $get['toDate'] : $this->input->post('toDate');
        $locationid = !empty($get['locationid']) ? $get['locationid'] : $this->input->post('locationid');

        if ($fromdate &&  $todate) {
            if (DEFAULT_DATEPICKER == 'NP') {
                $this->db->where('recm_receiveddatebs >=', $fromdate);
                $this->db->where('recm_receiveddatebs <=', $todate);
            } else {
                $this->db->where('recm_receiveddatead >=', $fromdate);
                $this->db->where('recm_receiveddatead <=', $todate);
            }
        }
        //  if(!empty($locationid)){
        //     $this->db->where('itli_locationid',$locationid);
        // }
        if ($this->location_ismain == 'Y') {
            if ($locationid) {
                $this->db->where('itli_locationid', $locationid);
            }
        } else {
            $this->db->where('itli_locationid', $this->locationid);
        }

        $this->db->select('rm.recm_receivedmasterid,rm.recm_receiveddatebs,rm.recm_purchasestatus,rm.recm_invoiceno,rm.recm_receivedno as orderno,rm.recm_amount,s.dist_distributor,rm.recm_discount,rm.recm_taxamount,rm.recm_clearanceamount,rm.recm_posttime,itli_locationid,
   rm.recm_status');
        $this->db->from('recm_receivedmaster rm');
        $this->db->join('dist_distributors s', 's.dist_distributorid = rm.recm_supplierid');
        $this->db->join('recd_receiveddetail rd', 'rd.recd_receivedmasterid=rm.recm_receivedmasterid', "LEFT");
        $this->db->join('itli_itemslist il', 'il.itli_itemlistid=rd.recd_itemsid', "LEFT");
        //$this->db->join('budg_budgets b','b.budg_budgetid = rm.recm_budgetid');
        //$this->db->where('recm_purchasestatus','D');
        //$this->db->where('recm_purchaseordermasterid !=',0);
        if ($fyear) {
            $this->db->where('rm.recm_fyear', $fyear);
        }
        if ($store_id) {
            $this->db->where('recm_fyear', $store_id);
        }

        $this->db->order_by($order_by, $order);

        if ($limit && $limit > 0) {
            $this->db->limit($limit);
        }
        if ($offset) {
            $this->db->offset($offset);
        }

        $nquery = $this->db->get();

        // echo $this->db->last_query(); die();
        $num_row = $nquery->num_rows();
        // if(!empty($_GET['iDisplayLength'])) {
        //     $totalrecs = sizeof( $nquery);
        // }
        if (!empty($_GET['iDisplayLength']) &&  !empty($nquery) && is_array($nquery) && count($nquery) > 0) {
            $totalrecs = sizeof($nquery);
        }

        if ($num_row > 0) {
            $ndata = $nquery->result();
            $ndata['totalrecs'] = $totalrecs;
            $ndata['totalfilteredrecs'] = $totalfilteredrecs;
        } else {
            $ndata = array();
            $ndata['totalrecs'] = 0;
            $ndata['totalfilteredrecs'] = 0;
        }
        //echo $this->db->last_query();die();
        return $ndata;
    }

    public function getStatusCount($srchcol = false,$invoice_no=false)
    {
        // echo $invoice_no;
        // die();
        try {
            $this->db->select("
            SUM(
            CASE
            WHEN recm_purchasestatus = 'D' THEN
            1
            ELSE
            0
            END
            ) directreceived,
            SUM(
            CASE
            WHEN recm_purchasestatus = 'O' THEN
            1
            ELSE
            0
            END
            ) orderreceived,
            SUM(
            CASE
            WHEN recm_purchasestatus = 'C' THEN
            1
            ELSE
            0
            END
            ) cancel,
            SUM(
            CASE
            WHEN recm_purchasestatus = 'R' THEN
            1
            ELSE
            0
            END
        ) returno");
            $this->db->from('recm_receivedmaster rm');
            $this->db->join('dist_distributors s', 's.dist_distributorid = rm.recm_supplierid', 'left');
            $this->db->where('rm.recm_dstat', 'D');
            if ($srchcol) {
                $this->db->where($srchcol);
            }
            if ($this->locationid) {
                $this->db->where('rm.recm_locationid', $this->locationid);
            }
            if (!empty($invoice_no)) {
               $this->db->where('rm.recm_invoiceno', $invoice_no);
            }

            $query = $this->db->get();
            // echo $this->db->last_query();die; 
            if ($query->num_rows() > 0) {
                return $query->result();
            }
            return false;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getStatusCountReturn($srchcol = false)
    {
        try {
            $this->db->select('COUNT(purr_purchasereturnid) as total, purr_returndatebs');
            $this->db->from('purr_purchasereturn pr');
            $this->db->join('dist_distributors s', 's.dist_distributorid = pr.purr_supplierid', 'left');

            if ($srchcol) {
                $this->db->where($srchcol);
            }
            if ($this->locationid) {
                $this->db->where('pr.purr_locationid', $this->locationid);
            }

            $query = $this->db->get();
            // echo $this->db->last_query();die; 
            if ($query->num_rows() > 0) {
                return $query->result();
            }
            return false;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function get_purcase_details($cond = false)
    {
        try {
            $this->db->select('itm.itli_itemcode,itm.itli_itemname,itm.itli_itemlistid,rm.*, un.unit_unitname');
            $this->db->from('itli_itemslist itm');
            $this->db->join('recd_receiveddetail rm', 'rm.recd_itemsid =itm.itli_itemlistid ', 'LEFT');
            $this->db->join('unit_unit un', 'un.unit_unitid = itm.itli_unitid', 'LEFT');
            if ($cond) {
                $this->db->where($cond);
            }
            $query = $this->db->get();
            //echo $this->db->last_query();die; 
            if ($query->num_rows() > 0) {
                return $query->result();
            }
            return false;
        } catch (Exception $e) {
            throw $e;
        }
    }
    public function get_received_master($srchcol = false)
    {
        $locationid = $this->input->post('locationid');
        $this->db->select('rm.recm_receivedno, rm.recm_supplierid, rm.recm_receiveddatead, rm.recm_receiveddatebs, rm.recm_supplierbillno, rm.recm_supbilldatead, rm.recm_supbilldatebs, rm.recm_postusername, rm.recm_discount, rm.recm_taxamount, rm.recm_amount, rm.recm_receivedmasterid, rm.recm_status, rm.recm_postdatebs, rm.recm_postdatead, rm.recm_invoiceno, rm.recm_locationid, rm.recm_fyear, s.dist_distributor');
        $this->db->from('recm_receivedmaster rm');
        $this->db->join('dist_distributors s', 's.dist_distributorid = rm.recm_supplierid');

        if ($srchcol) {
            $this->db->where($srchcol);
        }
        if (!empty($locationid)) {
            $this->db->where('recm_locationid', $locationid);
        } else {
            $this->db->where('recm_locationid', $this->locationid);
        }
        $query = $this->db->get();
        // echo $this->db->last_query();
        // die();
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data;
        }
        return false;
    }
    public function received_master_views($srchcol = false)
    {
        $this->db->select('rm.*,lo.loca_name,s.dist_distributor');
        $this->db->from('recm_receivedmaster rm');
        $this->db->join('dist_distributors s', 's.dist_distributorid = rm.recm_supplierid');
        $this->db->join('loca_location lo', 'lo.loca_locationid=rm.recm_locationid', 'LEFT');
        if ($srchcol) {
            $this->db->where($srchcol);
        }
        $query = $this->db->get();
        // echo $this->db->last_query();
        // die();
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data;
        }
        return false;
    }
    public function get_received_details($srchcol = false)
    {
        $subqry = "(SELECT sum(pod.pude_quantity) from xw_puor_purchaseordermaster pom LEFT JOIN xw_pude_purchaseorderdetail pod
    on pom.puor_purchaseordermasterid=pod.pude_purchasemasterid WHERE pom.puor_purchaseordermasterid=rm.recm_purchaseordermasterid
    AND pod.pude_itemsid=rd.recd_itemsid group by puor_purchaseordermasterid
) as puord_qty";
        $this->db->select("rd.*,il.itli_itemcode,il.itli_itemname,il.itli_itemnamenp,il.itli_itemlistid,eq.eqca_code_manual,ut.unit_unitname,rm.recm_invoiceno,rm.recm_receivedno,d.dist_distributor,rm.recm_supplierbillno,rm.recm_remarks,rm.recm_amount,rm.recm_clearanceamount,rm.recm_purchaseorderno,rm.recm_taxamount, rm.recm_discount,rm.recm_others,rm.recm_othersdescription,rm.recm_receiveddatead,rm.recm_receiveddatebs,rm.recm_purchaseorderdatebs,rm.recm_purchaseorderdatead,rm.recm_locationid, eq.eqca_jinsicode,$subqry");
        $this->db->from('recd_receiveddetail rd');
        $this->db->join('itli_itemslist il', 'il.itli_itemlistid=rd.recd_itemsid', 'LEFT');
  
        $this->db->join('unit_unit ut', 'ut.unit_unitid=il.itli_unitid', 'LEFT');
        $this->db->join('recm_receivedmaster rm', 'rm.recm_receivedmasterid=rd.recd_receivedmasterid', 'LEFT');
        $this->db->join('dist_distributors d', 'd.dist_distributorid=rm.recm_supplierid', 'LEFT');
        $this->db->join('eqca_equipmentcategory eq', 'eq.eqca_equipmentcategoryid = il.itli_catid', 'LEFT');

        if ($srchcol) {
            $this->db->where($srchcol);
        }
        $query = $this->db->get();
        // echo $this->db->last_query(); die();
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data;
        }
        return false;
    }
    public function update_receive_detail($id)
    {
        if ($id) {
            $updateArray['recd_iscancel'] = 'Y';
            $updateArray['recd_canceldatead'] = CURDATE_EN;
            $updateArray['recd_canceldatebs'] = CURDATE_NP;
            //$updateArray['recd_cancelip']= $this->userid;
            $updateArray['recd_canceluser'] = $this->username;

            $this->db->update('recd_receiveddetail', $updateArray, array('recd_receiveddetailid' => $id));
            $rwaff = $this->db->affected_rows();
            if ($rwaff) {
                return true;
            }
        }
        return false;
    }
    public function update_receive_master($id)
    {
        if ($id) {
            $updateArray['recm_purchasestatus'] = 'C';
            $updateArray['recm_storeid'] = $this->storeid;
            $updateArray['recm_departmentid'] = $this->depid;
            $updateArray['recm_locationid'] = $this->locationid;
            $updateArray['recm_postusername'] = $this->username;
            $updateArray['recm_postdatebs'] = CURDATE_NP;
            $updateArray['recm_postdatead'] = CURDATE_EN;
            $this->db->update('recm_receivedmaster', $updateArray, array('recm_receivedmasterid' => $id));
            $rwaff = $this->db->affected_rows();
            if ($rwaff) {
                return true;
            }
        }
        return false;
    }

    public function update_mat_trans_detailid($mat_transdetailidid, $qty)
    {
        if ($mat_transdetailidid) {
            $this->db->query("UPDATE xw_trde_transactiondetail SET trde_issueqty= (trde_issueqty)-$qty WHERE trde_trdeid=$mat_transdetailidid");
        }
        $rwaff = $this->db->affected_rows();
        if ($rwaff) {
            return true;
        }
        return false;
    }

    public function update_req_master($masterid)
    {
        if ($masterid) {
            $this->db->query("UPDATE xw_rema_reqmaster SET rema_isdirect= '1' WHERE rema_reqmasterid=$masterid");
        }
        $rwaff = $this->db->affected_rows();
        if ($rwaff) {
            return true;
        }
        return false;
    }

    public function getColorStatusCount($srchcol = false)
    {
        if ($srchcol) {
            $con1 = $srchcol;
        } else {
            $con1 = '';
        }

        $sql = "SELECT * FROM
     xw_coco_colorcode cc
    LEFT JOIN (
     SELECT
         recm_purchasestatus,
         COUNT('*') AS statuscount
     FROM
         xw_recm_receivedmaster rm
     " . $con1 . "
     GROUP BY
         recm_purchasestatus
    ) X ON X.recm_purchasestatus = cc.coco_statusval
    WHERE
     cc.coco_listname = 'direct_purchaselist'
    AND cc.coco_statusval <> ''
    AND cc.coco_isactive = 'Y'";

        $query = $this->db->query($sql);
        // echo $this->db->last_query();
        // die();
        return $query->result();
    }

    public function get_purcase_req_details($cond = false)
    {
        try {
            $this->db->select('itm.itli_itemcode,itm.itli_itemname,itm.itli_itemlistid,rm.*, un.unit_unitname, rm.purd_itemsid as recd_itemsid, purd_qty as recd_purchasedqty, purd_rate as recd_unitprice');
            $this->db->from('itli_itemslist itm');
            $this->db->join('purd_purchasereqdetail rm', 'rm.purd_itemsid =itm.itli_itemlistid ', 'LEFT');
            $this->db->join('unit_unit un', 'un.unit_unitid = itm.itli_unitid', 'LEFT');
            $this->db->join('prld_purreqlogdetail pld', 'pld.prld_pureid = rm.purd_reqid AND pld.prld_itemsid = rm.purd_itemsid', 'left');
            if ($cond) {
                $this->db->where($cond);
            }
            $query = $this->db->get();
            //echo $this->db->last_query();die; 
            if ($query->num_rows() > 0) {
                return $query->result();
            }
            return false;
        } catch (Exception $e) {
            throw $e;
        }
    }
}