<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Purchase_order_quotation_mdl extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->puor_masterTable='puor_purchaseordermaster';
        $this->pude_detailTable='pude_purchaseorderdetail';
        // $this->tran_masterTable='trma_transactionmain';
        // $this->tran_detailTable='trde_transactiondetail';
        $this->locationid=$this->session->userdata(LOCATION_ID);

    }
    public $validate_settings_order_item = array(
        array('field' => 'fiscalyear', 'label' => 'Fiscal Year', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'supplier', 'label' => 'Supplier', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'item_type', 'label' => 'Item Type', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'order_date', 'label' => 'Order Date', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'order_number', 'label' => 'Order Number', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'delevery_date', 'label' => 'Delivery Date', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'qude_itemsid[]', 'label' => 'Item', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'puit_qty[]', 'label' => 'Order Qty', 'rules' => 'trim|required|numeric|is_natural_no_zero|xss_clean'),
        array('field' => 'order_date', 'label' => 'Order Date', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'totalamount', 'label' => 'Total Amount', 'rules' => 'trim|required|xss_clean')
        
    );
    public function order_item_save()
    {
        try{
            //echo "<pre>";print_r($this->input->post());die();
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
            $orderno = $this->general->getLastNo('puor_orderno','puor_purchaseordermaster',array('puor_fyear'=>CUR_FISCALYEAR));
            $order_number=$orderno+1;
       
            $supplier=$this->input->post('supplier');
            $item_type=$this->input->post('item_type');
            $ordernumber = $this->input->post('order_number');
            $delevery_site = $this->input->post('delevery_site');
            $req_no = $this->input->post('req_no');
            $fy = $this->input->post('fiscalyear');
            $purdreqdetid = $this->input->post('purd_reqdetid');

            // echo "<pre>";
            // print_r($purdreqdetid);
            // die();

            $fiscalyear= $this->input->post('fiscalyear');
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
            $reqdetid = $this->input->post('purd_reqdetid');//this is for updating quantity in purchaserequisition details
            $curtime=$this->general->get_currenttime();
            $userid=$this->session->userdata(USER_ID);
            $mac=$this->general->get_Mac_Address();
            $ip=$this->general->get_real_ipaddr();
            //print_r($id);die;
            if($id)
            {
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
                                'puor_postedad'=>CURDATE_EN,
                                'puor_postedbs'=>CURDATE_NP,
                                'puor_posttime'=>$curtime,
                                'puor_enteredby'=>$userid,
                                'puor_postmac'=>$mac,
                                'puor_postip'=>$ip 
                                );


                // print_r($puor_storeid);
                // die();

                if($orderMasterArrayUp)
                {
                    $this->db->update('puor_purchaseordermaster',$orderMasterArrayUp,array('puor_purchaseordermasterid'=>$id));
                }
                    foreach ($reqdetid as $key => $value) {
                        $updetailsid= !empty($reqdetid[$key])?$reqdetid[$key]:'';
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
                                        'pude_requsitionid'=>!empty($purdreqdetid[$key])?$purdreqdetid[$key]:'',
                                        'pude_vat'=> !empty($vatid[$key])?$vatid[$key]:'',
                                        'pude_amount'=> !empty($individualtotal[$key])?$individualtotal[$key]:'',
                                        'pude_remarks'=> !empty($description[$key])?$description[$key]:'',
                                        //'pude_remarks'=> $description,
                                        'pude_discount'=> !empty($discountpc[$key])?$discountpc[$key]:'',
                                        'pude_postdatead'=>CURDATE_EN,
                                        'pude_postdatebs'=>CURDATE_NP,
                                        'pude_posttime'=>$curtime,
                                        'pude_postby'=>$userid,
                                        'pude_postmac'=>$mac,
                                        'pude_postip'=>$ip 
                                    );
                        //echo"<pre>"; print_r($orderDetailUpdate);die;
                        if($orderDetailUpdate)
                        {
                            $this->db->update('pude_purchaseorderdetail',$orderDetailUpdate,array('pude_puordeid'=>$updetailsid));
                            //echo $this->db->last_query();die;
                        }
                    } 
                //}
            //echo"<pre>"; print_r($orderMasterArray);die;
            }else{  
                $this->db->trans_begin();
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
                                'puor_postedad'=>CURDATE_EN,
                                'puor_postedbs'=>CURDATE_NP,
                                'puor_posttime'=>$curtime,
                                'puor_enteredby'=>$userid,
                                'puor_postmac'=>$mac,
                                'puor_postip'=>$ip,
                                'puor_locationid'=>$this->locationid  
                                );

                if(!empty($orderMasterArray))
                {   //echo"<pre>"; print_r($orderMasterArray);die;
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
                                    'pude_locationid'=>$this->locationid  
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
                        $pqty = $this->general->get_tbl_data('purd_remqty','purd_purchasereqdetail',array('purd_reqdetid'=>$detailid),'purd_reqdetid','DESC');
                        $previousqty=$pqty[0]->purd_remqty;
                        $enteredqty = !empty($qty[$kg])?$qty[$kg]:'';
                        $remtotalqty = $previousqty - $enteredqty;

                        $this->db->update('purd_purchasereqdetail',array('purd_remqty'=>$remtotalqty),array('purd_reqdetid'=>$detailid));   //echo $this->db->last_query();
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
                $this->db->trans_commit();
                if($id){
                    return $id;
                }else{
                    return $insertid;
                }
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
        $this->db->select('p.*,pd.*,t.itli_itemcode,t.itli_itemname,t.itli_itemnamenp,s.eqty_equipmenttypeid,s.eqty_equipmenttype,d.dist_distributor,et.eqty_equipmenttype as dept_depname,ut.unit_unitname,d.dist_govtregno,d.dist_address1');
        $this->db->from('puor_purchaseordermaster p');
        $this->db->join('pude_purchaseorderdetail pd','pd.pude_purchasemasterid=p.puor_purchaseordermasterid','LEFT');
        $this->db->join('itli_itemslist t','t.itli_itemlistid = pd.pude_itemsid','LEFT');
        $this->db->join('eqty_equipmenttype s','s.eqty_equipmenttypeid = p.puor_storeid','LEFT');
        $this->db->join('dist_distributors d','d.dist_distributorid = p.puor_supplierid','LEFT');
          $this->db->join('eqty_equipmenttype et','et.eqty_equipmenttypeid = p.puor_tostoreid','LEFT');
        $this->db->join('unit_unit ut','ut.unit_unitid = t.itli_unitid','LEFT');
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
        $apptype = $this->input->get('apptype');
        $frmDate=$this->input->get('frmDate');
        $toDate=$this->input->get('toDate');
        $supplier=$this->input->get('supplier');

        $get = $_GET;
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

        $this->db->select('qm.*,t.dist_distributor');
        $this->db->from('puor_purchaseordermaster qm');
        //$this->db->join('pude_purchaseorderdetail qd','qd.pude_purchasemasterid = qm.puor_purchaseordermasterid','LEFT');
    
        $this->db->join('dist_distributors t','t.dist_distributorid = qm.puor_supplierid','LEFT');
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
        if($supplier)
        {
            $this->db->where('qm.puor_supplierid',$supplier);
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
        //echo $this->db->last_query();die();
      return $ndata;

    }
    
    public function getStatusCount($srchcol = false){
        try{
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
                            ) complete ");
            $this->db->from('puor_purchaseordermaster'); 
            if($srchcol){
                $this->db->where($srchcol);
            }

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

        $resltrpt=$this->db->select("(CASE WHEN(puor_orderno is NULL) THEN 0 ELSE 1 END) As orderno")
                    ->from('pure_purchaserequisition pr')
                    ->join('eqty_equipmenttype et','et.eqty_equipmenttypeid = pr.pure_itemstypeid','LEFT')
                    ->join('xw_puor_purchaseordermaster por','por.puor_requno = pr.pure_purchasereqid  and por.puor_fyear = pr.pure_fyear','LEFT')
                    ->where('pure_isapproved','Y')
                    ->having('orderno','0')
                    ->get()
                    ->result();


        $totalfilteredrecs=!sizeof($resltrpt)?$resltrpt:0; 

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

        $this->db->select('pure_purchasereqid, pure_reqdatebs, pure_reqdatead, pure_appliedby, pure_reqtime, pure_requestto, pure_fyear, pure_reqno, pure_ordered, et.eqty_equipmenttype, et.eqty_equipmenttypeid,(CASE WHEN(puor_orderno is NULL) THEN 0 ELSE 1 END) As orderno');
        $this->db->from('pure_purchaserequisition pr');
        $this->db->join('eqty_equipmenttype et','et.eqty_equipmenttypeid = pr.pure_itemstypeid','LEFT');
        $this->db->join('xw_puor_purchaseordermaster por','por.puor_requno = pr.pure_reqno  and por.puor_fyear = pr.pure_fyear','LEFT');
        $this->db->where('pure_isapproved','Y');
        $this->db->having('orderno','0');
        if($cond) {
            $this->db->where($cond);
        }

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
       
       return $ndata;
    }

    public function get_pur_requisition_details($srchcol = false){
        $this->db->select('it.itli_itemcode as itemcode, it.itli_itemname as itemname, it.itli_itemnamenp as itemnamenp, it.itli_itemlistid, it.itli_purchaserate, it.itli_salesrate, pd.purd_reqdetid, pd.purd_itemsid, pd.purd_stock, pd.purd_qty as quantity, pd.purd_unit, pd.purd_rate as rate, (pd.purd_qty * it.itli_purchaserate) as amount, purd_remqty, purd_remarks');
        $this->db->from('purd_purchasereqdetail pd');
        $this->db->join('itli_itemslist it','it.itli_itemlistid = pd.purd_itemsid','left');

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

    public function get_quotation_details($srchcol = false){
        $this->db->select('it.itli_itemcode as itemcode, it.itli_itemname as itemname, it.itli_itemnamenp as itemnamenp, it.itli_itemlistid, purd_qty as quantity, qude_quotationmasterid, qude_itemsid, qude_amount, qude_discountpc as discount, qude_vatpc as vatpc, qude_rate as itli_purchaserate, (pd.purd_qty * qude_rate) as amount, qude_netrate, qude_units, qude_remarks, qude_status,purd_remqty, purd_remarks, pd.purd_stock, pd.purd_reqdetid, purd_unit');
        $this->db->from('qude_quotationdetail qd');
        $this->db->join('quma_quotationmaster qm','qm.quma_quotationmasterid = qd.qude_quotationmasterid','left');
        $this->db->join('itli_itemslist it','it.itli_itemlistid = qd.qude_itemsid','left');
        $this->db->join('purd_purchasereqdetail pd','pd.purd_reqid = qm.quma_reqno and pd.purd_itemsid = qd.qude_itemsid','left');

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
}