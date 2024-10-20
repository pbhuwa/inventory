<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Purchase_order_mdl extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->puor_masterTable='puor_purchaseordermaster';
        $this->pude_detailTable='pude_purchaseorderdetail';
        // $this->tran_masterTable='trma_transactionmain';
        // $this->tran_detailTable='trde_transactiondetail';
        $this->locationid=$this->session->userdata(LOCATION_ID);
        $this->username=$this->session->userdata(USER_NAME);
        $this->orgid=$this->session->userdata(ORG_ID);
        $this->userid = $this->session->userdata(USER_ID);

    }
    public $validate_settings_order_item = array(
        array('field' => 'fiscalyear', 'label' => 'Fiscal Year', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'supplier', 'label' => 'Supplier', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'item_type', 'label' => 'Item Type', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'order_date', 'label' => 'Order Date', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'order_number', 'label' => 'Order Number', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'delevery_date', 'label' => 'Delivery Date', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'qude_itemsid[]', 'label' => 'Item', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'puit_qty[]', 'label' => 'Order Qty', 'rules' => 'trim|required|numeric|greater_than[0]|xss_clean'),
        array('field' => 'order_date', 'label' => 'Order Date', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'totalamount', 'label' => 'Total Amount', 'rules' => 'trim|required|xss_clean')
        
    );

     public $validate_settings_order_item_no_supplier = array(
        array('field' => 'fiscalyear', 'label' => 'Fiscal Year', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'item_type', 'label' => 'Item Type', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'order_date', 'label' => 'Order Date', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'order_number', 'label' => 'Order Number', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'delevery_date', 'label' => 'Delivery Date', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'qude_itemsid[]', 'label' => 'Item', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'puit_qty[]', 'label' => 'Order Qty', 'rules' => 'trim|required|numeric|greater_than[0]|xss_clean'),
        array('field' => 'order_date', 'label' => 'Order Date', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'totalamount', 'label' => 'Total Amount', 'rules' => 'trim|required|xss_clean')
        
    );

    public function order_item_save()
    {
        try{
            // echo "<pre>";print_r($this->input->post());die();
            $id = $this->input->post('id');

            $order_date=$this->input->post('order_date');
            $delevery_date=$this->input->post('delevery_date');
            $suplier_bill_date =   $this->input->post('suplier_bill_date');
            $id = $this->input->post('id');
            if(DEFAULT_DATEPICKER=='NP')
            {   $suplier_bill_dateNp=$suplier_bill_date;
                $suplier_bill_dateEn=$this->general->NepToEngDateConv($suplier_bill_date);
                $deleverydateNp=$delevery_date;
                $deleverydateEn=$this->general->NepToEngDateConv($delevery_date);
                $orderdateNp=$order_date;
                $orderdateEn=$this->general->NepToEngDateConv($order_date);
            }
            else
            {   
                $suplier_bill_dateEn=$suplier_bill_date;
                $suplier_bill_dateNp=$this->general->EngToNepDateConv($suplier_bill_date);
                $deleverydateEn=$delevery_date;
                $deleverydateNp=$this->general->EngToNepDateConv($delevery_date);
                $orderdateEn=$order_date;
                $orderdateNp=$this->general->NepToEngDateConv($order_date);
            }
            $storeid=$this->input->post('item_type');
            // $orderno = $this->general->getLastNo('puor_orderno','puor_purchaseordermaster',array('puor_fyear'=>CUR_FISCALYEAR,'puor_locationid'=>$this->locationid));
            // $order_number=$orderno+1;

            $mattypeid=!empty($this->input->post('puro_mattypeid'))?$this->input->post('puro_mattypeid'):'';

             $fiscalyear= $this->input->post('fiscalyear');
             
            $order_no_array = array('puor_fyear'=>$fiscalyear,'puor_locationid'=>$this->locationid);

         if(ORGANIZATION_NAME=='KU' || ORGANIZATION_NAME=='ARMY' ){
                $order_no_array['puro_mattypeid']=$mattypeid;
                
                 $order_number = $this->general->generate_form_no('puor_orderno','puor_purchaseordermaster', $order_no_array,'puor_purchaseordermasterid', 'DESC');
            }else{
                 $order_number = $this->general->generate_form_no('puor_orderno','puor_purchaseordermaster', $order_no_array,'puor_purchaseordermasterid', 'DESC');
            }    

            $supplier=$this->input->post('supplier');
            $item_type=$this->input->post('item_type');
            $ordernumber = $this->input->post('order_number');
            $delevery_site = $this->input->post('delevery_site');
            $req_no = $this->input->post('req_no');
            $fy = $this->input->post('fiscalyear');
            $purdreqdetid = $this->input->post('purd_reqdetid');
            $purdreqmasterid=$this->input->post('puor_purchasereqmasterid');
            $mattypeid=$this->input->post('puro_mattypeid');
            $budgetid=$this->input->post('puor_budgetid');

            // echo "<pre>";
            // print_r($this->input->post());
            // die();

           
            $rema_manualno = $this->input->post('rema_manualno');
            $receiveno = $this->input->post('receiveno');
            $suplier_bill_no = $this->input->post('suplier_bill_no');
            $discountpc = $this->input->post('discountpc');

            $code =   $this->input->post('puit_barcode');
            $unitid =   $this->input->post('puit_unitid');
            $stock_qty =   $this->input->post('stock_qty');
            $productid =   $this->input->post('qude_itemsid');
            $puit_unitprice =   $this->input->post('puit_unitprice');
           // $pude_remarks =   $this->input->post('pude_remarks');
            $qty =   $this->input->post('puit_qty');
            $vatid =   $this->input->post('puit_taxid');
            $individualtotal =   $this->input->post('puit_total');
            //$grandtotal =   $this->input->post('total');
            $tender_no =   $this->input->post('tender_no');
            $free =   $this->input->post('free');
            $subtotal =   $this->input->post('subtotal');
            $transport =   $this->input->post('transport');
            $discountper =   $this->input->post('puin_discountper');
            $freight =   $this->input->post('freight');
            $packing =   $this->input->post('packing');
            $discountamt =   $this->input->post('puin_discountamt');
            $description =   $this->input->post('description');
            $other =   $this->input->post('other');
            $insurance =   $this->input->post('insurance');
            //$grandtotal =   $this->input->post('total');
            $isfreeze =   $this->input->post('isfreeze');
            if(!empty($isfreeze))
            {
                $statusfreeze =  $isfreeze;
            }else
            {
                $statusfreeze =  'N';
            }
            $extraamount =   $this->input->post('extraamount');

            //details of payment details 
                // if($qty)
                    //{   
                        // foreach ($qty as $kg => $nqty) {
                        //     $detailid = !empty($purdreqdetid[$kg])?$purdreqdetid[$kg]:'';
                        //     $pqty = $this->general->get_tbl_data('purd_remqty','purd_purchasereqdetail',array('purd_reqdetid'=>$detailid),'purd_reqdetid','DESC');
                        //     $previousqty=$pqty[0]->purd_remqty;
                        //     $enteredqty = !empty($qty[$kg])?$qty[$kg]:'';
                        //     $remtotalqty = $previousqty - $enteredqty;
                            
                        //     $this->db->update('purd_purchasereqdetail',array('purd_remqty'=>$remtotalqty),array('purd_reqdetid'=>NULL));   //echo $this->db->last_query();
                        // } 
                        //print_r($remqty);die;
                      // die;    
                   
                // }
            $paymentdays =   $this->input->post('paymentdays');
            $taxtamount =   $this->input->post('taxtamount');

            $currencysymbol =   $this->input->post('currencysymbol');
            $delivery_day =   $this->input->post('delivery_day');
            $units =   $this->input->post('units');
            $paymentremarks =   $this->input->post('paymentremarks');
            $approvedby =   $this->input->post('approvedby');
            $taxamount =   $this->input->post('taxamount');
            $grandtotal =   $this->input->post('totalamount');
             $reqdetid = $this->input->post('pude_orderid');
            if(ORGANIZATION_NAME=='KUKL'){
                $reqdetid = $this->input->post('purd_reqdetid');
                
             }
           //this is for updating quantity in purchaserequisition details
            $curtime=$this->general->get_currenttime();
            $userid=$this->session->userdata(USER_ID);
            $mac=$this->general->get_Mac_Address();
            $ip=$this->general->get_real_ipaddr();
            // print_r($id);die;

            // echo "<pre>";
            // print_r($this->input->post());
            // die();
            if($id)
            {
                // echo "interif";
                // die();
                $old_pur_order_array=array();
                $pude_insert_array=array();
                $orderMasterArrayUp = array(
                    'puor_orderno'=>$ordernumber,
                    'puor_orderdatead'=>$orderdateEn,
                    'puor_orderdatebs'=>$orderdateNp,
                    'puor_fyear'=>$fiscalyear,
                    'puor_amount'=>$grandtotal,
                    'puor_deliverysite'=>$delevery_site,
                    'puor_deliverydatead'=>$deleverydateEn,
                    'puor_deliverydatebs'=>$deleverydateNp,
                    //'puor_dist_id'=>$supplier,
                    'puor_requno'=>$req_no,
                       // 'puor_amount'=>$orderdateNp,
                    'puor_supplierid'=>$supplier,
                    'puor_carriagefreight'=>$freight,
                    'puor_transportcourier'=>$transport,
                        //'puor_amount'=>$discountamt,
                    'puor_other'=>$other,
                    'puor_packing'=>$packing,
                    'puor_insurance'=>$insurance,
                    'puor_approvedby'=>$approvedby,
                    'puor_vatamount'=>$taxtamount,
                    'puor_discount'=>$discountamt,
                        // 'puor_amount'=>$suplier_bill_dateEn,
                        //'puor_terms'=>$,
                    'puor_currencytype'=>$currencysymbol,
                        //'puor_ordertype'=>$,
                    'puor_remarks'=>$paymentremarks,
                    'puor_isfreezer'=>$statusfreeze,
                    'puor_tostoreid'=>$item_type,
                        //'puor_timetypeid'=>$,
                    'puor_storeid'=>$storeid,
                    //'puor_purchased'=>'',
                    'puor_paymentdays'=>$paymentdays,
                    'puor_deliverydays'=>$delivery_day,
                    //'puor_orderfor'=>$,
                    //'puor_status'=>'',
                    //'puor_discount'=>$discountpc,
                    //'puor_vat'=>$vatid,
                    'puor_modifyby'=>$userid,
                    'puor_modifydatead'=>CURDATE_EN,
                    'puor_modifydatebs'=>CURDATE_NP,
                    'puor_modifytime'=>$curtime,
                    'puor_modifymac'=>$mac,
                    'puor_modifyip'=>$ip,
                    'puor_locationid'=>$this->locationid,
                    'puor_orgid'=>$this->orgid
                );

                // echo "<pre>";
                // print_r($orderMasterArrayUp);
                // die();
                 if(!empty($purdreqmasterid)){
                            $orderMasterArrayUp['puor_purchasereqmasterid']=implode(',',$purdreqmasterid);
                    }

                     if(!empty($budgetid)){
                        $orderMasterArrayUp['puor_budgetid']=$budgetid;
                    }

                if(!empty($orderMasterArrayUp)){
                    $this->db->update('puor_purchaseordermaster',$orderMasterArrayUp,array('puor_purchaseordermasterid'=>$id));
                }

                $old_rede_list = $this->get_all_order_item_det_id(array('pude_purchasemasterid'=>$id)); // check old Order detail ids
                $old_order_det_id_array=array();
                if(!empty($old_order_det_id_array)){
                    foreach($old_order_det_id_array as $key=>$value){
                        $old_pur_order_array[] = $value->pude_puordeid;
                    }
                }

                $pude_insertid = array();

                // echo "<pre>";
                // print_r($reqdetid);
                // die();

                foreach ($reqdetid as $key => $value) {
                    $updetailsid= !empty($reqdetid[$key])?$reqdetid[$key]:'';

                    if(!empty($updetailsid)){
                        if(in_array($updetailsid, $old_pur_order_array)){
                            $pude_array[] = $updetailsid;
                        }
                    
                        $orderDetailUpdate=array(
                           // ''=>$insertid,
                            'pude_itemsid'=> !empty($productid[$key])?$productid[$key]:'',
                            'pude_quantity'=> !empty($qty[$key])?$qty[$key]:'',
                            'pude_remqty'=> !empty($qty[$key])?$qty[$key]:'',
                            'pude_rate'=> !empty($puit_unitprice[$key])?$puit_unitprice[$key]:'',
                            'pude_free'=> !empty($free[$key])?$free[$key]:'',
                            'pude_unit'=> !empty($unitid[$key])?$unitid[$key]:'',
                            'pude_tenderno'=> !empty($tender_no[$key])?$tender_no[$key]:'',
                            'pude_stockqty'=> !empty($stock_qty[$key])?$stock_qty[$key]:'',
                            // 'pude_requsitionid'=>!empty($purdreqdetid[$key])?$purdreqdetid[$key]:'',
                            'pude_vat'=> !empty($vatid[$key])?$vatid[$key]:'',
                            'pude_amount'=> !empty($individualtotal[$key])?$individualtotal[$key]:'',
                            'pude_remarks'=> !empty($description[$key])?$description[$key]:'',
                            //'pude_remarks'=> $description,
                            'pude_discount'=> !empty($discountpc[$key])?$discountpc[$key]:'',
                            'purd_modifydatead'=>CURDATE_EN,
                            'purd_modifydatebs'=>CURDATE_NP,
                            'pude_posttime'=>$curtime,
                            'purd_modifyby'=>$userid,
                            'purd_modifymac'=>$mac,
                            'purd_modifyip'=>$ip,
                            'pude_locationid'=>$this->locationid,
                            'pude_orgid'=>$this->orgid
                        );
                        if(!empty($orderDetailUpdate)) {
                            $this->db->update('pude_purchaseorderdetail',$orderDetailUpdate,array('pude_puordeid'=>$updetailsid));
                                //echo $this->db->last_query();die;
                        }
                    }else{
                        $pude_insert_array = array(
                            'pude_purchasemasterid'=>$id,
                            'pude_itemsid'=> !empty($productid[$key])?$productid[$key]:'',
                            'pude_quantity'=> !empty($qty[$key])?$qty[$key]:'',
                            'pude_remqty'=> !empty($qty[$key])?$qty[$key]:'',
                            'pude_rate'=> !empty($puit_unitprice[$key])?$puit_unitprice[$key]:'',
                            'pude_free'=> !empty($free[$key])?$free[$key]:'',
                            'pude_unit'=> !empty($unitid[$key])?$unitid[$key]:'',
                            'pude_tenderno'=> !empty($tender_no[$key])?$tender_no[$key]:'',
                            'pude_stockqty'=> !empty($stock_qty[$key])?$stock_qty[$key]:'',
                            'pude_requsitionid'=>!empty($purdreqdetid[$key])?$purdreqdetid[$key]:'',
                            'pude_vat'=> !empty($vatid[$key])?$vatid[$key]:'',
                            'pude_amount'=> !empty($individualtotal[$key])?$individualtotal[$key]:'',
                            'pude_remarks'=> !empty($description[$key])?$description[$key]:'',
                            //'pude_remarks'=> $description,
                            'pude_discount'=> !empty($discountpc[$key])?$discountpc[$key]:'',
                            'purd_modifydatead'=>CURDATE_EN,
                            'purd_modifydatebs'=>CURDATE_NP,
                            'pude_posttime'=>$curtime,
                            'purd_modifyby'=>$userid,
                            'purd_modifymac'=>$mac,
                            'purd_modifyip'=>$ip,
                            'pude_locationid'=>$this->locationid,
                            'pude_orgid'=>$this->orgid
                        );

                        $this->db->insert($this->pude_detailTable, $pude_insert_array);
                        $pude_insertid[] = $this->db->insert_id();

                        $detailid = !empty($purdreqdetid[$key])?$purdreqdetid[$key]:'';
                        if (!empty($detailid)) {    
                        $pqty = $this->general->get_tbl_data('purd_remqty','purd_purchasereqdetail',array('purd_reqdetid'=>$detailid),'purd_reqdetid','DESC');
                        $previousqty= !empty($pqty[0]->purd_remqty)?$pqty[0]->purd_remqty:0;
                        $enteredqty = !empty($qty[$key])?$qty[$key]:0;
                        $remtotalqty = $previousqty - $enteredqty;
                        if ($remtotalqty < 0) {
                            $remtotalqty = 0;
                        }

                        $this->db->update('purd_purchasereqdetail',array('purd_remqty'=>$remtotalqty),array('purd_reqdetid'=>$detailid)); 
                        }
                            
                    }
                }

                // deleted items
                $old_items_list = $this->general->get_tbl_data('pude_puordeid','pude_purchaseorderdetail',array('pude_purchasemasterid'=>$id));
                // $this->general->insert_query_log();

                // echo "<pre>";
                // print_r($old_items_list);
                // die();
                
                $old_items_array = array();
                if(!empty($old_items_list)){
                    foreach($old_items_list as $key=>$value){
                        $old_items_array[] = $value->pude_puordeid;
                    }
                }
                
                // print_r($old_items_array);
                // die();

                $total_itemlist = count($old_items_list);

                $deleted_items = array();

                if(!empty($pude_insertid)){
                    $purdreqdetid = array_merge($purdreqdetid, $pude_insertid);
                }

                if(is_array($purdreqdetid)){
                    $deleted_items = array_diff($old_items_array, $purdreqdetid);
                }

                $del_items_num = count($deleted_items);

                 if(!empty($del_items_num)){
                    for($i = 0; $i<$del_items_num; $i++){
                        $deleted_array = array_values($deleted_items);
                        // print_r($deleted_array);
                        // die();

                        foreach($deleted_array as $key=>$del){
                           $pu_order_rslt= $this->db->select('pude_requsitionid,pude_quantity')->from('pude_purchaseorderdetail')->where(array('pude_puordeid'=>$del))->get()->row();
                           // echo "<pre>";
                           // print_r($pu_order_rslt);
                           // die(); 

                           if(!empty($pu_order_rslt)){
                            if($pu_order_rslt->pude_requsitionid>0){
                                 $this->db->set('purd_remqty', 'purd_qty', FALSE);
                                 $this->db->where(array('purd_reqdetid'=>$pu_order_rslt->pude_requsitionid));
                                 $this->db->update('purd_purchasereqdetail');
                            }
                            
                            // $this->general->insert_query_log();
                           }

                            $this->db->where(array('pude_puordeid'=>$del));
                            $this->db->delete('pude_purchaseorderdetail');
                            // $this->general->insert_query_log();

                        }
                    }
                }
                    
            }else{

                // echo "interelse";
                //     die(); 
                $this->db->trans_begin();

                //insert array
                $orderMasterArray = array(
                                'puor_orderno'=>$order_number,
                                'puor_orderdatead'=>$orderdateEn,
                                'puor_orderdatebs'=>$orderdateNp,
                                'puor_fyear'=>$fiscalyear,
                                'puor_amount'=>$grandtotal,
                                'puor_deliverysite'=>$delevery_site,
                                'puor_deliverydatead'=>$deleverydateEn,
                                'puor_deliverydatebs'=>$deleverydateNp,
                                //'puor_dist_id'=>$supplier,
                                'puor_requno'=>$req_no,
                                'puor_vatamount'=>$taxtamount,
                                'puor_discount'=>$discountamt,
                                'puor_supplierid'=>$supplier,
                                'puor_carriagefreight'=>$freight,
                                //'puor_discount'=>$discountpc,
                                'puor_transportcourier'=>$transport,
                                    //'puor_amount'=>$discountamt,
                                'puor_other'=>$other,
                                'puor_packing'=>$packing,
                                'puor_insurance'=>$insurance,
                                'puor_approvedby'=>$approvedby,
                                    // 'puor_amount'=>$suplier_bill_dateEn,
                                    //'puor_terms'=>$,
                                'puor_currencytype'=>$currencysymbol,
                                    //'puor_ordertype'=>$,
                                'puor_remarks'=>$paymentremarks,
                                'puor_isfreezer'=>$statusfreeze,
                                'puor_tostoreid'=>$item_type,
                                    //'puor_timetypeid'=>$,
                                'puor_storeid'=>$storeid,
                                'puor_purchased'=>'0',
                                'puor_paymentdays'=>$paymentdays,
                                'puor_deliverydays'=>$delivery_day,
                                //'puor_orderfor'=>$,
                                'puor_status'=>'N',
                                //'puor_vat'=>$vatid,
                                'puor_postby'=>$userid,
                                'puor_postedad'=>CURDATE_EN,
                                'puor_postedbs'=>CURDATE_NP,
                                'puor_posttime'=>$curtime,
                                'puor_enteredby'=>$userid,
                                'puor_postmac'=>$mac,
                                'puor_postip'=>$ip,
                                'puor_locationid'=>$this->locationid,
                                'puor_orgid'=>$this->orgid 
                                );

                if(!empty($orderMasterArray))
                {   //echo"<pre>"; print_r($orderMasterArray);die;

                   if(!empty($purdreqmasterid)){
                            $orderMasterArray['puor_purchasereqmasterid']=implode(',',$purdreqmasterid);
                    }
                    if(!empty($mattypeid)){
                        $orderMasterArray['puro_mattypeid']=$mattypeid;
                    }
                    if(!empty($budgetid)){
                        $orderMasterArray['puor_budgetid']=$budgetid;
                    }

                    $this->db->insert($this->puor_masterTable,$orderMasterArray);
                    $insertid=$this->db->insert_id();
                    if($insertid)
                    {
                        foreach ($productid as $key => $val) {
                            $orderDetail[]=array(
                                    'pude_purchasemasterid'=>$insertid,
                                    'pude_itemsid'=> !empty($productid[$key])?$productid[$key]:'',
                                    'pude_quantity'=> !empty($qty[$key])?$qty[$key]:'',
                                    'pude_remqty'=> !empty($qty[$key])?$qty[$key]:'',
                                    'pude_rate'=> !empty($puit_unitprice[$key])?$puit_unitprice[$key]:'',
                                    'pude_free'=> !empty($free[$key])?$free[$key]:'',
                                    'pude_unit'=> !empty($unitid[$key])?$unitid[$key]:'',
                                    'pude_tenderno'=> !empty($tender_no[$key])?$tender_no[$key]:'',
                                    'pude_stockqty'=> !empty($stock_qty[$key])?$stock_qty[$key]:'',
                                    'pude_requsitionid'=>!empty($purdreqdetid[$key])?$purdreqdetid[$key]:'',
                                        //'puit_taxid'=> !empty($taxtype[$key])?$taxtype[$key]:'',
                                    'pude_remarks'=> !empty($description[$key])?$description[$key]:'',
                                    'pude_amount'=> !empty($individualtotal[$key])?$individualtotal[$key]:'',
                                    'pude_vat'=> !empty($vatid[$key])?$vatid[$key]:'',
                                    'pude_discount'=> !empty($discountpc[$key])?$discountpc[$key]:'',
                                    'pude_postdatead'=>CURDATE_EN,
                                    'pude_postdatebs'=>CURDATE_NP,
                                    'pude_posttime'=>$curtime,
                                    'pude_postby'=>$userid,
                                    'pude_postmac'=>$mac,
                                    'pude_postip'=>$ip,
                                    'pude_locationid'=>$this->locationid,
                                    'pude_orgid'=>$this->orgid 
                                );
                        }

                        if(!empty($orderDetail))
                        {  //echo"reqdata"; echo"<pre>";print_r($orderDetail);
                            $this->db->insert_batch($this->pude_detailTable,$orderDetail);
                        }  
                       
                    }
                }

                //updating new purchase rate if any changes for new items
                foreach ($productid  as $key => $val) {
                    $itemid = !empty($productid[$key])?$productid[$key]:'';
                    $unitprice = !empty($puit_unitprice[$key])?$puit_unitprice[$key]:'';
                    $this->general->compare_item_price($itemid,$unitprice);
                } 
                //updating remaining Qty in purchase requisition 
                if($qty)
                {   
                    foreach ($qty as $kg => $nqty) {
                        $detailid = !empty($purdreqdetid[$kg])?$purdreqdetid[$kg]:'';
                        if (!empty($detailid)) {
                        $pqty = $this->general->get_tbl_data('purd_remqty','purd_purchasereqdetail',array('purd_reqdetid'=>$detailid),'purd_reqdetid','DESC');
                        $previousqty= !empty($pqty[0]->purd_remqty)?$pqty[0]->purd_remqty:0;
                        $enteredqty = !empty($qty[$kg])?$qty[$kg]:0;
                        $remtotalqty = $previousqty - $enteredqty;
                         if ($remtotalqty < 0) {
                            $remtotalqty = 0;
                        }

                        $this->db->update('purd_purchasereqdetail',array('purd_remqty'=>$remtotalqty),array('purd_reqdetid'=>$detailid));   //echo $this->db->last_query();
                
                        }
                    } 
                    // foreach ($qty as $kg => $nqty) {
                    //     $detailid = !empty($reqdetid[$key])?$reqdetid[$key]:'';
                    //     $pqty = $this->general->get_tbl_data('purd_remqty','purd_purchasereqdetail',array('purd_reqdetid'=>$detailid),'purd_reqdetid','DESC');
                    //     $previousqty=$pqty[$kg]->purd_remqty;
                    //     $enteredqty = !empty($qty[$kg])?$qty[$kg]:'';
                    //     $remqty = $previousqty - $enteredqty;
                    //     $updateArray=array(
                    //         'purd_remqty'=>!empty($remqty[$kg])?$remqty[$kg]:'',
                    //     );       
                    // }
                    //$this->db->update('purd_purchasereqdetail',$updateArray,array('purd_reqdetid'=>$detailid));
                }
            }

            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                return false;
            }
            else{
                if (ORGANIZATION_NAME == 'KUKL') {
                    if($id){
                        if (defined('RUN_API') && RUN_API == 'Y'){
                         if (defined('API_CALL') && API_CALL == 'KUKL') {
                             $this->notify_kukl_budget($id);
                            }
                        }
                        $this->db->trans_commit(); 
                        return $id;
                    }else{
                        if (defined('RUN_API') && RUN_API == 'Y'){
                            if (defined('API_CALL') && API_CALL == 'KUKL') {
                                $this->notify_kukl_budget($insertid);
                            }
                        }  
                        $this->db->trans_commit();
                        return $insertid;
                    }   
                }else{
                    $this->db->trans_commit();
                    if($id){
                        return $id;
                    }else{ 
                        return $insertid;
                    }   
                }
            }
        }catch(Exception $e){
            $this->db->trans_rollback();
            return false;
        }
    }

    public function get_all_order_item_det_id($srchcol = false){
        try{
            $this->db->select('pude_puordeid');
            $this->db->from('pude_purchaseorderdetail');
            if($srchcol){
                $this->db->where($srchcol);
            }
            $query = $this->db->get();
            if($query->num_rows() > 0){
                $result = $query->result();
                return $result;
            }
        }catch(Exception $e){
            throw $e;
        }
    }

    public function get_requisition_details($cond=false)
    {
        $this->db->select('cm.pure_purchasereqid,cm.pure_itemstypeid,cm.pure_isapproved,cm.pure_posttime,cm.pure_fyear,cm.pure_approvaluser,cm.pure_approveddatebs,rd.purd_reqdetid,rd.purd_stock,rd.purd_unit,rd.purd_qty,cm.pure_storeid,rd.purd_remarks,rd.purd_reqdatebs,eq.itli_itemname,eq.itli_itemnamenp,eq.itli_itemcode,eq.itli_itemlistid,eq.itli_salesrate,eq.itli_purchaserate,rd.purd_remqty');
        $this->db->from('pure_purchaserequisition cm');
        $this->db->join('purd_purchasereqdetail rd','rd.purd_reqid = cm.pure_purchasereqid','LEFT');
        $this->db->join('eqty_equipmenttype t','t.eqty_equipmenttypeid = cm.pure_itemstypeid','LEFT');
        $this->db->join('itli_itemslist eq','eq.itli_itemlistid = rd.purd_itemsid','LEFT');
        //$this->db->where('rd.purd_remqty>', 0);
        if($cond)
        {
            $this->db->where($cond);
        }
        $query = $this->db->get();
        //echo $this->db->last_query(); die();
        if ($query->num_rows() > 0) 
        {
            $data=$query->result();     
            return $data;       
        }       
        return false;
    }
    public function get_order_selected($cond =false)
    {
        $id = $this->input->post('id');
        $stock_col="(SELECT IFNULL(SUM(md.trde_issueqty),0) FROM xw_trde_transactiondetail md LEFT JOIN xw_trma_transactionmain mt   on md.trde_trmaid =mt.trma_trmaid
  WHERE t.itli_itemlistid=md.trde_itemsid AND mt.trma_received=1 AND md.trde_locationid=".$this->locationid." AND mt.trma_fromdepartmentid=".$this->storeid." ) as stockqty";
        $this->db->select('p.*,pd.*,t.itli_itemcode,t.itli_itemname,t.itli_itemnamenp,eq.eqca_code_manual,s.eqty_equipmenttypeid,s.eqty_equipmenttype,d.dist_distributor,et.eqty_equipmenttype as dept_depname,ut.unit_unitname,d.dist_govtregno,d.dist_address1, d.dist_vatno,prr.pure_reqdatebs, prr.pure_reqdatead,prr.pure_purchasereqid,lo.loca_name,'.$stock_col.'');
        $this->db->from('puor_purchaseordermaster p');
        $this->db->join('pude_purchaseorderdetail pd','pd.pude_purchasemasterid=p.puor_purchaseordermasterid','LEFT');
        $this->db->join('purd_purchasereqdetail prd','prd.purd_reqdetid = pd.pude_requsitionid','left');
         $this->db->join('pure_purchaserequisition prr','prr.pure_purchasereqid = prd.purd_reqid','left');
        $this->db->join('itli_itemslist t','t.itli_itemlistid = pd.pude_itemsid','LEFT');
        $this->db->join('eqty_equipmenttype s','s.eqty_equipmenttypeid = p.puor_storeid','LEFT');
        $this->db->join('dist_distributors d','d.dist_distributorid = p.puor_supplierid','LEFT');
          $this->db->join('eqty_equipmenttype et','et.eqty_equipmenttypeid = p.puor_tostoreid','LEFT');
           $this->db->join('eqca_equipmentcategory eq', 'eq.eqca_equipmentcategoryid = t.itli_catid', 'LEFT');
        $this->db->join('unit_unit ut','ut.unit_unitid = t.itli_unitid','LEFT');
         $this->db->join('loca_location lo','lo.loca_locationid = p.puor_locationid','LEFT');
        if($cond)
        {
            $this->db->where($cond);
        }
        if($id)
        {
            $this->db->where('puor_purchaseordermasterid', $id);
        }
        $query = $this->db->get();
        //echo $this->db->last_query(); die();
        if ($query->num_rows() > 0) 
        {
            $data=$query->result();     
            return $data;       
        }       
        return false;
    }
    public function get_selected_order()
    {   
        $order_number = $this->input->post('order_no');
        $this->db->select('p.*');
        $this->db->from('puor_purorder p');
        $this->db->join('puorde_purchaseorderitem pd','pd.puorde_purchaseid=p.puor_purorderid','LEFT');
        
        if($order_number)
        {
            $this->db->where('puor_quotationid', $order_number);
        }
        $query = $this->db->get();
        // echo $this->db->last_query(); die();
        if ($query->num_rows() > 0) 
        {
            $data=$query->result();     
            return $data;       
        }       
        return false;
    }
    
    public function get_order_list($cond = false)
    {
        $get = $_GET;
        $apptype = $this->input->get('apptype');
          $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');
        $toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');
        $supplier=$this->input->get('supplier');
        $locationid=$this->input->get('locationid');
        $mattypeid=$this->input->get('mattypeid');
        $srchtext=!empty($get['srchtext'])?$get['srchtext']:'';

        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }
        if(!empty($get['sSearch_0'])){
            $this->db->where("quma_quotation_master_id like  '%".$get['sSearch_0']."%'  ");
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("puor_orderno like  '%".$get['sSearch_1']."%'  ");
        }
         if(!empty($get['sSearch_2'])){
            $this->db->where("puor_fyear like  '%".$get['sSearch_2']."%'  ");
        }

         if(!empty($get['sSearch_3'])){
            $this->db->where("puor_orderdatead like  '%".$get['sSearch_3']."%'  ");
        }

        if(!empty($get['sSearch_4'])){
            $this->db->where("puor_orderdatebs like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("puor_deliverydatead like  '%".$get['sSearch_5']."%'  ");
        }
        
        if(!empty($get['sSearch_6'])){
            $this->db->where("puor_deliverydatebs like  '%".$get['sSearch_6']."%'  ");
        }
        
        if(!empty($get['sSearch_7'])){
            $this->db->where("puor_deliverysite like  '%".$get['sSearch_7']."%'  ");
        }
        if(!empty($get['sSearch_8'])){
            $this->db->where("dist_distributor like  '%".$get['sSearch_8']."%'  ");
        }
       
        if(!empty($get['sSearch_9'])){
            $this->db->where("puor_amount like  '%".$get['sSearch_9']."%'  ");
        }
        if(!empty($get['sSearch_10'])){
            $this->db->where("puor_requno like  '%".$get['sSearch_10']."%'  ");
        }
        if($cond) {
          $this->db->where($cond);
        }
        //  if($this->session->userdata(USER_ACCESS_TYPE)=='S')
        // {
        //   $this->db->where('dist_orgid',$this->session->userdata(ORG_ID));
        // }
        if($apptype == 'pending')
        {
            $srch = array('pm.puor_status'=>'N','pm.puor_purchased'=>'0');
        }
        if($apptype == 'complete')
        {
            $srch = array('pm.puor_status'=>'R','pm.puor_purchased'=>'2');
        }
        if($apptype == 'partialcomplete')
        {
            $srch = array('pm.puor_status'=>'R','pm.puor_purchased'=>'1');
        }
        if(!empty(($frmDate && $toDate)))
        {
             if(DEFAULT_DATEPICKER=='NP')
            { 
            $this->db->where('pm.puor_orderdatebs >=',$frmDate);
            $this->db->where('pm.puor_orderdatebs <=',$toDate);
            }
            else
            {
            $this->db->where('pm.puor_orderdatead >=',$frmDate);
            $this->db->where('pm.puor_orderdatead <=',$toDate);
            }
        }
        if($supplier)
        {
            $this->db->where('pm.puor_supplierid',$supplier);
        }
        if($locationid)
        {
            $this->db->where('pm.puor_locationid',$locationid);
        }
        if(!empty($mattypeid)){
            $this->db->where('pm.puro_mattypeid',$mattypeid);
        }

        if(!empty($srchtext)){
            $this->db->where('(puor_orderno='.$srchtext.' OR puor_requno='.$srchtext.')');
        }

        $resltrpt=$this->db->select("COUNT(*) as cnt")
                    ->from('puor_purchaseordermaster pm')
                   // ->join('pude_purchaseorderdetail qd','qd.pude_purchasemasterid = pm.puor_purchaseordermasterid','LEFT')
                    ->join('dist_distributors t','t.dist_distributorid = pm.puor_supplierid','LEFT')
                    ->join('itli_itemslist itm','itm.itli_itemlistid = pm.puor_purchaseordermasterid','LEFT')
                        //->where('puor_deliverysite',"GENERAL STORE")
                    ->get()
                    ->row(); 
        //echo $this->db->last_query();die(); 
        $totalfilteredrecs=$resltrpt->cnt; 

        $order_by = 'puor_purchaseordermasterid';
        $order = 'desc';
        if($this->input->get('sSortDir_0'))
        {
                $order = $this->input->get('sSortDir_0');
        }
  
        $where='';
        if($this->input->get('iSortCol_0')==0)
            $order_by = 'puor_purchaseordermasterid';
        else if($this->input->get('iSortCol_0')==1)
            $order_by = 'puor_orderno';
        else if($this->input->get('iSortCol_0')==2)
            $order_by = 'puor_fyear';
        
         else if($this->input->get('iSortCol_0')==3)
            $order_by = 'puor_orderdatead';

        else if($this->input->get('iSortCol_0')==4)
            $order_by = 'puor_orderdatebs';
         else if($this->input->get('iSortCol_0')==5)
            $order_by = 'puor_deliverydatead';
         else if($this->input->get('iSortCol_0')==6)
            $order_by = 'puor_deliverydatebs';

        else if($this->input->get('iSortCol_0')==7)
            $order_by = 'puor_deliverysite';
        else if($this->input->get('iSortCol_0')==8)
            $order_by = 'dist_distributor';
       
        else if($this->input->get('iSortCol_0')==9)
            $order_by = 'puor_amount';
        else if($this->input->get('iSortCol_0')==10)
            $order_by = 'puor_requno';
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

        if(!empty($get['sSearch_0'])){
            $this->db->where("quma_quotation_master_id like  '%".$get['sSearch_0']."%'  ");
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("puor_orderno like  '%".$get['sSearch_1']."%'  ");
        }
         if(!empty($get['sSearch_2'])){
            $this->db->where("puor_fyear like  '%".$get['sSearch_2']."%'  ");
        }

         if(!empty($get['sSearch_3'])){
            $this->db->where("puor_orderdatead like  '%".$get['sSearch_3']."%'  ");
        }

        if(!empty($get['sSearch_4'])){
            $this->db->where("puor_orderdatebs like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("puor_deliverydatead like  '%".$get['sSearch_5']."%'  ");
        }
        
        if(!empty($get['sSearch_6'])){
            $this->db->where("puor_deliverydatebs like  '%".$get['sSearch_6']."%'  ");
        }
        
        if(!empty($get['sSearch_7'])){
            $this->db->where("puor_deliverysite like  '%".$get['sSearch_7']."%'  ");
        }
        if(!empty($get['sSearch_8'])){
            $this->db->where("dist_distributor like  '%".$get['sSearch_8']."%'  ");
        }
       
        if(!empty($get['sSearch_9'])){
            $this->db->where("puor_amount like  '%".$get['sSearch_9']."%'  ");
        }
        if(!empty($get['sSearch_10'])){
            $this->db->where("puor_requno like  '%".$get['sSearch_10']."%'  ");
        }

       //  if($this->session->userdata(USER_ACCESS_TYPE)=='S')
        // {
       //   $this->db->where('dist_orgid',$this->session->userdata(ORG_ID));
        // }
        if($cond) {
          $this->db->where($cond);
        }
          if(!empty($mattypeid)){
            $this->db->where('qm.puro_mattypeid',$mattypeid);
        }
        if(ORGANIZATION_NAME=='KU' || ORGANIZATION_NAME=='ARMY' ){
            $selcol=",mt.maty_material";
               
        }else{
            $selcol="";
        }
        $count_no_of_item="(SELECT COUNT(pude_puordeid) as cnt from xw_pude_purchaseorderdetail pd WHERE pd.pude_purchasemasterid=qm.puor_purchaseordermasterid) as cnt ";

        $this->db->select("qm.*,t.dist_distributor,ap.appr_approvedname,$count_no_of_item $selcol");
        $this->db->from('puor_purchaseordermaster qm');
        if(ORGANIZATION_NAME=='KU'  || ORGANIZATION_NAME=='ARMY' ){
             $this->db->join('maty_materialtype mt','mt.maty_materialtypeid=qm.puro_mattypeid',"LEFT");
        }
    
        //$this->db->join('pude_purchaseorderdetail qd','qd.pude_purchasemasterid = qm.puor_purchaseordermasterid','LEFT');
    
        $this->db->join('dist_distributors t','t.dist_distributorid = qm.puor_supplierid','LEFT');
        $this->db->join('appr_approved ap','ap.appr_approvedid=qm.puor_approvedby',"LEFT");
            //$this->db->where('puor_deliverysite',"GENERAL STORE");
        if($apptype == 'pending')
        {
            $srch = array('qm.puor_status'=>'N','qm.puor_purchased'=>'0');
        }
        if($apptype == 'complete')
        {
            $srch = array('qm.puor_status'=>'R','qm.puor_purchased'=>'2');
        }
        if($apptype == 'partialcomplete')
        {
            $srch = array('qm.puor_status'=>'R','qm.puor_purchased'=>'1');
        }
        if(!empty(($frmDate && $toDate)))
        { 
            if(DEFAULT_DATEPICKER=='NP')
            { 
            $this->db->where('qm.puor_orderdatebs >=',$frmDate);
            $this->db->where('qm.puor_orderdatebs <=',$toDate);
            }
            else
            {
            $this->db->where('qm.puor_orderdatead >=',$frmDate);
            $this->db->where('qm.puor_orderdatead <=',$toDate);
            }
        }

         if(!empty($srchtext)){
            $this->db->where('(puor_orderno='.$srchtext.' OR puor_requno='.$srchtext.')');
        }

        if($supplier)
        {
            $this->db->where('qm.puor_supplierid',$supplier);
        }
        if($locationid)
        {
            $this->db->where('qm.puor_locationid',$locationid);
        }
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
    
    public function getStatusCount($srchcol = false){
        try{
            $locationid=$this->input->post('locationid');
            $supplierid=$this->input->post('supplier');
          $frmDate=$this->input->post('frmdate');
        $toDate=$this->input->post('todate');
        $locationid=$this->input->post('locationid');
        $supplierid=$this->input->post('supplier');
        if(!empty($frmDate) && !empty($toDate)){
            if(DEFAULT_DATEPICKER=='NP'){
           $this->db->where('pm.puor_orderdatebs >=',$frmDate);
            $this->db->where('pm.puor_orderdatebs <=',$toDate);  
            } else{
            $this->db->where('pm.puor_orderdatead >=',$frmDate);
            $this->db->where('pm.puor_orderdatead <=',$toDate);  
            }
        }

            $this->db->select("
                            SUM(
                                CASE
                                WHEN puor_purchased = '0' AND puor_status ='N' THEN
                                    1
                                ELSE
                                    0
                                END
                            ) pending,
                            SUM(
                                CASE
                                WHEN puor_purchased = '1' AND puor_status ='R' THEN
                                    1
                                ELSE
                                    0
                                END
                            ) partialcomplete,
                            SUM(
                                CASE
                                WHEN puor_purchased = '2' AND puor_status ='R' THEN
                                    1
                                ELSE
                                    0
                                END
                            ) complete,
                            SUM(
                                CASE
                                WHEN puor_purchased = '0' AND puor_status ='C' THEN
                                    1
                                ELSE
                                    0
                                END
                            ) cancel,
                            SUM(
                                CASE
                                WHEN puor_purchased = '0' AND puor_status ='CH' THEN
                                    1
                                ELSE
                                    0
                                END
                            ) challan ");
            $this->db->from('puor_purchaseordermaster pm'); 
            if($srchcol){
                $this->db->where($srchcol);
            }
            if($locationid)
            {
                $this->db->where('puor_locationid',$locationid);
            }
            if($supplierid)
            {
                 $this->db->where('puor_supplierid',$supplierid);
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

      public function getStatusCount_kukl($srchcol = false){
        try{
            $frmDate=$this->input->post('frmdate');
            $toDate=$this->input->post('todate');
            $locationid=$this->input->post('locationid');
            $supplierid=$this->input->post('supplier');
            if(!empty($frmDate) && !empty($toDate)){
                if(DEFAULT_DATEPICKER=='NP'){
               $this->db->where('pm.puor_orderdatebs >=',$frmDate);
                $this->db->where('pm.puor_orderdatebs <=',$toDate);  
                } else{
                $this->db->where('pm.puor_orderdatead >=',$frmDate);
                $this->db->where('pm.puor_orderdatead <=',$toDate);  
                }
            }

            $this->db->select("
                            SUM(
                                CASE
                                WHEN puor_purchased = '0' AND puor_status ='N' THEN
                                    1
                                ELSE
                                    0
                                END
                            ) pending,
                            SUM(
                                CASE
                                WHEN puor_purchased = '1' AND puor_status ='R' THEN
                                    1
                                ELSE
                                    0
                                END
                            ) partialcomplete,
                            SUM(
                                CASE
                                WHEN puor_purchased = '2' AND puor_status ='R' THEN
                                    1
                                ELSE
                                    0
                                END
                            ) complete,
                            SUM(
                                CASE
                                WHEN puor_purchased = '0' AND puor_status ='C' THEN
                                    1
                                ELSE
                                    0
                                END
                            ) cancel,
                            SUM(
                                CASE
                                WHEN puor_purchased = '0' AND puor_status ='CH' THEN
                                    1
                                ELSE
                                    0
                                END
                            ) challan ");
            $this->db->from('puor_purchaseordermaster pm'); 
            if($locationid)
            {
                $this->db->where('puor_locationid',$locationid);
            }
            if($supplierid)
            {
                 $this->db->where('puor_supplierid',$supplierid);
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

    public function summary_purchase_order($select,$srchcol=false,$limit=false,$offset=false,$order_by=false,$order=false)
    {
         $this->db->select($select);
        $this->db->from('puor_purchaseordermaster pm');
        $this->db->join('pude_purchaseorderdetail pd','pd.pude_purchasemasterid=pm.puor_purchaseordermasterid','LEFT');

        if($srchcol){
            $this->db->where($srchcol);
        }
        if($limit && $limit>0){
            $this->db->limit($limit);
        }
        if($order_by){
            $this->db->order_by($order_by,$order);
        }
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result();
        }
        return false;
    }

    public function get_pur_requisition_list($cond = false)
    {
       
        $get = $_GET;
        $mattype = !empty($get['materialtypeid'])?$get['materialtypeid']:'';

        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("pure_reqno like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("pure_reqdatebs like  '%".$get['sSearch_2']."%'  ");
        }

        if(!empty($get['sSearch_3'])){
            $this->db->where("pure_reqdatead like  '%".$get['sSearch_3']."%'  ");
        }

        if(!empty($get['sSearch_4'])){
            $this->db->where("pure_appliedby like  '%".$get['sSearch_4']."%'  ");
        }

        if(!empty($get['sSearch_5'])){
            $this->db->where("eqty_equipmenttype like  '%".$get['sSearch_5']."%'  ");
        }

        if(!empty($get['sSearch_6'])){
            $this->db->where("pure_requestto like  '%".$get['sSearch_6']."%'  ");
        }
        
        if($cond) {
            $this->db->where($cond);
        }

        if($mattype){
            $this->db->where('pr.pure_mattypeid',$mattype);
        }

        if (ORGANIZATION_NAME == 'KUKL') {
                $pure_isapproved = 'P';
            } else {
                $pure_isapproved = 'Y';
            }

        $resltrpt=$this->db->select("pr.pure_reqno")
                    ->from('pure_purchaserequisition pr')
                    ->join('eqty_equipmenttype et','et.eqty_equipmenttypeid = pr.pure_itemstypeid','LEFT')
                    ->join('purd_purchasereqdetail pd','pd.purd_reqid=pr.pure_reqmasterid','LEFT')
                    ->where(array('pd.purd_remqty >'=>'0.00'))
                    ->where('pure_isapproved',$pure_isapproved)
                    ->where('pure_locationid',$this->locationid)
                    // ->having('orderno','0')
                    ->get()
                    ->result();

        // echo "<pre>";
        // print_r($resltrpt);
        // die();

        $totalfilteredrecs=0;
        if(!empty($resltrpt) && is_array($resltrpt)){
        $totalfilteredrecs=sizeof($resltrpt);     
        }
        
        // echo $totalfilteredrecs;
        // die();

        $order_by = 'pure_reqno';
        $order = 'desc';
  
        $where='';
        if($this->input->get('iSortCol_0')==1)
            $order_by = 'pure_reqno';
        else if($this->input->get('iSortCol_0')==2)
            $order_by = 'pure_reqdatebs';
        else if($this->input->get('iSortCol_0')==3)
            $order_by = 'pure_reqdatead';
        else if($this->input->get('iSortCol_0')==4)
            $order_by = 'pure_appliedby';
        else if($this->input->get('iSortCol_0')==5)
            $order_by = 'eqty_equipmenttype';
        else if($this->input->get('iSortCol_0')==6)
            $order_by = 'pure_requestto';
        
        $totalrecs='';
        $limit = 15;
        $offset = 1;
        $get = $_GET;
        $mattype = !empty($get['materialtypeid'])?$get['materialtypeid']:'';
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }
        if($this->input->get('sSortDir_0'))
        {
            $order = $this->input->get('sSortDir_0');
        }
      
        if(!empty($_GET["iDisplayLength"])){
            $limit = $_GET['iDisplayLength'];
            $offset = $_GET["iDisplayStart"];
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("pure_reqno like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("pure_reqdatebs like  '%".$get['sSearch_2']."%'  ");
        }

        if(!empty($get['sSearch_3'])){
            $this->db->where("pure_reqdatead like  '%".$get['sSearch_3']."%'  ");
        }

        if(!empty($get['sSearch_4'])){
            $this->db->where("pure_appliedby like  '%".$get['sSearch_4']."%'  ");
        }

        if(!empty($get['sSearch_5'])){
            $this->db->where("eqty_equipmenttype like  '%".$get['sSearch_5']."%'  ");
        }

        if(!empty($get['sSearch_6'])){
            $this->db->where("pure_requestto like  '%".$get['sSearch_6']."%'  ");
        }

        $this->db->select('pure_purchasereqid, pure_reqdatebs, pure_reqdatead, pure_appliedby, pure_reqtime, pure_requestto, pure_fyear, pure_reqno, pure_ordered, et.eqty_equipmenttype, et.eqty_equipmenttypeid,0 As orderno');
        $this->db->from('pure_purchaserequisition pr');
        $this->db->join('eqty_equipmenttype et','et.eqty_equipmenttypeid = pr.pure_itemstypeid','LEFT');
        // $this->db->join('puor_purchaseordermaster por','por.puor_requno = pr.pure_reqno  and por.puor_fyear = pr.pure_fyear','LEFT');
        $this->db->join('purd_purchasereqdetail pd','pd.purd_reqid=pr.pure_reqmasterid','LEFT');
        $this->db->where('pure_isapproved',$pure_isapproved);
        $this->db->where(array('pd.purd_remqty >'=>'0.00'));
        $this->db->where('pure_locationid',$this->locationid);
        // $this->db->having('orderno','0');
        if($cond) {
            $this->db->where($cond);
        }
         if($mattype){
            $this->db->where('pr.pure_mattypeid',$mattype);
        }
        $this->db->group_by('pure_purchasereqid');

        if($limit && $limit>0)
        {  
            $this->db->limit($limit);
        }
        
        if($offset)
        {
            $this->db->offset($offset);
        }
        $this->db->order_by($order_by,$order);

        $nquery=$this->db->get();

        // print_r($nquery);
        // die();
        // echo $this->db->last_query();die();

        $num_row=$nquery->num_rows();

        if (!empty($_GET['iDisplayLength']) &&  !empty($nquery) && is_array($nquery->result()) && count($nquery->result()) > 0 ) {
            $totalrecs = count($nquery->result()); 
            // echo $totalrecs;
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
       
       return $ndata;
    }

    public function get_pur_requisition_details($srchcol = false){
        if(ORGANIZATION_NAME == 'KUKL'){
            $this->db->select('it.itli_itemcode as itemcode, it.itli_itemname as itemname, it.itli_itemnamenp as itemnamenp, it.itli_itemlistid, it.itli_purchaserate, it.itli_salesrate, pd.purd_reqdetid, pd.purd_itemsid, pd.purd_stock, pd.purd_qty as quantity, pd.purd_unit, pd.purd_estimatecost as rate, (pd.purd_qty * pd.purd_estimatecost) as amount, purd_remqty, purd_remarks, pure_itemstypeid,pm.pure_purchasereqid,unit_unitname as purd_unit');
                $this->db->from('pure_purchaserequisition pm');
                $this->db->join('purd_purchasereqdetail pd','pd.purd_reqid = pm.pure_purchasereqid','LEFT');
                $this->db->join('itli_itemslist it','it.itli_itemlistid = pd.purd_itemsid','left');
                $this->db->join('unit_unit ut','ut.unit_unitid=it.itli_unitid','LEFT');
                $this->db->join('prld_purreqlogdetail pld','pld.prld_pureid = pd.purd_reqid AND pld.prld_itemsid = pd.purd_itemsid','left');
                // $this->db->where('purd_proceedorder','Y');
                $this->db->where('pm.pure_locationid',$this->locationid);
        }
        else{
            $mat_type_id=$this->input->post('mat_type_id');
            if(!empty($mat_type_id)){
                $this->db->where('pm.pure_mattypeid',$mat_type_id);
            }
            $this->db->select('it.itli_itemcode as itemcode, it.itli_itemname as itemname, it.itli_itemnamenp as itemnamenp, it.itli_itemlistid, it.itli_purchaserate, it.itli_salesrate, pd.purd_reqdetid, pd.purd_itemsid, pd.purd_stock, pd.purd_qty as quantity, ut.unit_unitname purd_unit, pd.purd_rate as rate, (pd.purd_qty * it.itli_purchaserate) as amount, purd_remqty, purd_remarks, pure_itemstypeid,pm.pure_purchasereqid,pm.*');
            $this->db->from('pure_purchaserequisition pm');
            $this->db->join('purd_purchasereqdetail pd','pd.purd_reqid = pm.pure_purchasereqid','LEFT');
            $this->db->join('itli_itemslist it','it.itli_itemlistid = pd.purd_itemsid','LEFT');
            $this->db->join('unit_unit ut','ut.unit_unitid=it.itli_unitid','LEFT');
            $this->db->where('pm.pure_locationid',$this->locationid);
         }
        
        if($srchcol){
            $this->db->where($srchcol);
        }

        // if(ORGANIZATION_NAME == 'KUKL'):
        //     $this->db->where('purd_proceedorder','Y');
        // endif;
        
        $query = $this->db->get();
        // echo $this->db->last_query();
        // die();

        if($query->num_rows() > 0){
            $result = $query->result();
            return $result;
        }
        return false;
    }
    
    public function getColorStatusCount($srchcol = false)
    {
            $con1='';
       if($srchcol){
            if($this->location_ismain=='Y'){
            $con1= $srchcol;
        }else{     
        $con1.= $srchcol;
        $con1.=" AND puor_locationid ='".$this->locationid."'";
 
        }
        }else{
          $con1='';
          }

       $sql="SELECT * FROM
         xw_coco_colorcode cc
        LEFT JOIN (
         SELECT
             puor_status,puor_purchased,
             COUNT('*') AS statuscount
         FROM
             xw_puor_purchaseordermaster pr
         ".$con1."
         GROUP BY
             puor_status
        ) X ON X.puor_status = cc.coco_statusval AND X.puor_purchased =cc.coco_button
        WHERE
         cc.coco_listname = 'pur_order_summarylist'
        AND cc.coco_statusval <> ''
        AND cc.coco_isactive = 'Y'";
            
         $query = $this->db->query($sql);
         // echo $this->db->last_query();
         // die();
         return $query->result();
        
    }
    public function get_approve_user($srchcol = false){
        $this->db->select('usma_fullname,usma_appdesiid,desi_designationname, usma_employeeid');
        $this->db->from('usma_usermain um');
        $this->db->join('desi_designation de','de.desi_designationid = um.usma_appdesiid','LEFT');

        if($srchcol){
            $this->db->where($srchcol);
        }

        $query = $this->db->get();

        if($query->num_rows() > 0){
            $result = $query->result();
            return $result;
        }
        return false;
    }

    public function purchase_order_approval(){

        $approve_status = $this->input->post('approve_status');

        $masterid = $this->input->post('masterid');

        $approved_id = $this->userid;
        $approved_by = $this->username;

        $approve_remarks = '';
     
        switch ($approve_status) {
        case 1:
            $approve_remarks = "Verified by $approved_by";
        break;
        case 2:
            $approve_remarks = "Approved by $approved_by";
        break;
        default:
            echo "Status check";
        }

        $puorArray = array(
            'puor_verified' => $approve_status,
        );

        // echo "<pre>";
        // print_r($items_id);
        // die();

        $this->db->update('puor_purchaseordermaster', $puorArray, array('puor_purchaseordermasterid'=>$masterid));

        $this->general->saveActionLog('puor_purchaseordermaster', $masterid, $approved_id, $approve_status,'puor_verified',$approve_remarks); 

        $rowaffected=$this->db->affected_rows();

        if($rowaffected)
        {
            return $rowaffected;
        }
        else
        {
            return false;
        }
    }

    public function notify_kukl_budget($id)
    {   

        try{
            if (!$id)
            {
                throw new Exception('Order Id Not Found');
            }

        $this->db->select('pd.pude_requsitionid,purd_reqid');
        $this->db->from('pude_purchaseorderdetail pd');
        $this->db->join('purd_purchasereqdetail prd','prd.purd_reqdetid = pd.pude_requsitionid','left');
        $this->db->where('pude_purchasemasterid',$id);
        $ordered_items = $this->db->get()->result();
        $ordered_items_array = array();
        $pur_req_master_array = array(); 
        if (!empty($ordered_items && count($ordered_items))) {
            $ordered_items_array = array_column($ordered_items,'pude_requsitionid');
            $pur_req_master_array = array_unique(array_column($ordered_items,'purd_reqid'));
            
            $this->db->select('purd_reqdetid');
            $this->db->from('purd_purchasereqdetail');
            $this->db->where_in('purd_reqid',$pur_req_master_array);
            $preq_items = $this->db->get()->result();

            if (!empty($preq_items && count($preq_items))) {
                $all_requested_array = array_column($preq_items,'purd_reqdetid');

                $removed_items = array_diff($all_requested_array,$ordered_items_array);

                if (!empty($removed_items) && count($removed_items)) {
                    $this->db->select('purd_reqdetailid,rede_reqmasterid');
                    $this->db->from('purd_purchasereqdetail pd');
                    $this->db->join('rede_reqdetail rd','pd.purd_reqdetailid = rd.rede_reqdetailid','LEFT');
                    $this->db->where_in('purd_reqdetid',$removed_items);
                    $removed_items = $this->db->get()->result();

                    foreach($removed_items as $items){
                        $post_data = array(
                            'Req_MasterId'=> $items->rede_reqmasterid,
                            'req_detailId' => $items->purd_reqdetailid,
                            'r_Status' => 'C', 
                            'insUp' => 'UP',
                            'Entry_By' => null,
                            'Entry_Date' => null,
                            "Remarks" => 'cancel item',  
                            "insUp" => "UP",
                            "Budget_id"=> 0,
                            "Amount"=> 0,
                            "Item_Description"=> null,
                            "Rem_Amount"=> 0,
                            "Req_DateEn"=> null,
                            "Req_DateNp"=> null,
                            "Office_code"=> 0,
                            "Demand_No"=> 0, 
                            "Fyear"=> null,
                            "Updated_Date"=> str_replace('/', '.', CURDATE_NP), 
                            "Updated_Time"=> $this->general->get_currenttime(),
                            "Updated_By" => $this->username,
                            "Entrytime"=> null,
                        ); 

                        if($this->general->api_send_budget_demand_amount($post_data)){

                            $this->db->where('req_detailid',$items->purd_reqdetailid);
                            $this->db->where('req_masterid',$items->rede_reqmasterid);
                            $this->db->where('locationid',$this->locationid);
                            $this->db->where('orgid',$this->orgid);  
                            $this->db->update('api_budgetexpense',array('status' => 'C'));

                        }
                    }

                }
            }
        }
        return true; 

        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }
}
 