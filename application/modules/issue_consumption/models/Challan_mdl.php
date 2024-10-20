<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Challan_mdl extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->chma_masterTable='chma_challanmaster';
        $this->chde_detailTable='chde_challandetails';
        $this->trma_masterTable='trma_transactionmain';
        $this->trde_detailTable='trde_transactiondetail';
        $this->recm_masterTable='recm_receivedmaster';
        $this->recd_detailTable='recd_receiveddetail';
        $this->puor_masterTable = 'puor_purchaseordermaster';
        $this->pude_detailTable = 'pude_purchaseorderdetail';
        $this->sade_detailTable = 'sade_saledetail';
        
        $this->curtime=$this->general->get_currenttime();
        $this->userid=$this->session->userdata(USER_ID);
        $this->username = $this->session->userdata(USER_NAME);
        $this->depid = $this->session->userdata(USER_DEPT);
        $this->storeid = $this->session->userdata(STORE_ID);
        $this->mac=$this->general->get_Mac_Address();
        $this->ip=$this->general->get_real_ipaddr();
        $this->locationid=$this->session->userdata(LOCATION_ID);
        $this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
        $this->orgid=$this->session->userdata(ORG_ID);
    }
    public $validate_settings_challan = array(
        array('field' => 'chma_receiveno', 'label' => 'Receive Number', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'chma_supplierid', 'label' => 'Supplier  ', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'chma_suchallanno', 'label' => 'Supplier Challan Number', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'trde_itemsid[]', 'label' => 'Item', 'rules' => 'trim|required|xss_clean'),
    );
    public $validate_settings_receive_order_item = array(
        array('field' => 'receipt_no', 'label' => 'Receipt No', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'suplier_bill_no', 'label' => 'Supplier Bill No', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'suplier_bill_date', 'label' => 'Supplier Bill Date', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'fiscalyearid', 'label' => 'Fiscal Year', 'rules' => 'trim|required|xss_clean'),
        // array('field' => 'bill_amount', 'label' => 'Bill Amount', 'rules' => 'trim|required|callback_compareamount[bill_amount]|xss_clean'),
        array('field' => 'clearanceamt', 'label' => 'Clearance Amount', 'rules' => 'trim|required'),
        array('field' => 'supplier', 'label' => 'Supplier', 'rules' => 'trim|required'),
        array('field' => 'trde_itemsid[]', 'label' => 'Item', 'rules' => 'trim|required'),
        array('field' => 'puit_qty[]', 'label' => 'Qty', 'rules' => 'trim|required|numeric'),
        array('field' => 'puit_unitprice[]', 'label' => 'Rate', 'rules' => 'trim|required|numeric')
    );

    public $validate_settings_challan_bill_entry = array(
        array('field' => 'supplierid', 'label' => 'Supplier Name', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'received_no', 'label' => 'Received No', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'suplier_bill_no', 'label' => 'Supplier Bill No.', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'suplier_bill_date', 'label' => 'Supplier Bill Date.', 'rules' => 'trim|required|xss_clean'),
         array('field' => 'received_date', 'label' => 'Received Date', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'received_qty[]', 'label' => 'Received Qty', 'rules' => 'trim|required|xss_clean|greater_than[0]'),
       // array('field' => 'billamount', 'label' => 'Bill Amount', 'rules' => 'trim|required|xss_clean'),
       // array('field' => 'clearanceamt', 'label' => 'Clearance Amount', 'rules' => 'trim|required|callback__notMatch[billamount]|xss_clean'),
    );

    public function challan_save()
    {
        try{
            $id = $this->input->post('id');

            $postdata=$this->input->post();

            $orderno = $this->input->post('orderno');
            $fyear = $this->input->post('fiscalyear');
                
            $receivedate=$this->input->post('chma_receivedatebs');
            $suchalandate=$this->input->post('suchalandatebs');
            $challandate=$this->input->post('suchalandatebs');
            
            if(DEFAULT_DATEPICKER=='NP'){ 
                $receivedateNp=$receivedate;
                $receivedateEn=$this->general->NepToEngDateConv($receivedate);
                $supdateNp=$suchalandate;
                $supdateEn=$this->general->NepToEngDateConv($suchalandate);
                $chderdateNp=$challandate;
                $chderdateEn=$this->general->NepToEngDateConv($challandate);
                //print_r($chderdateEn);print_r($chderdateNp);die;
            }
            else{ 
                $receivedateEn=$receivedate;
                $receivedateNp=$this->general->EngToNepDateConv($receivedate);
                $supdateEn=$suchalandate;
                $supdateNp=$this->general->EngToNepDateConv($suchalandate);
                $chderdateEn=$challandate;
                $chderdateNp=$this->general->EngToNepDateConv($challandate);
            }
               
            $receiveno=$this->input->post('chma_receiveno');
            $supplierid = $this->input->post('chma_supplierid');
            $challanno = $this->input->post('chma_suchallanno');
            //details data for challan details and trans master table 
            $itemid=$this->input->post('trde_itemsid');
            $qty=$this->input->post('trde_issueqty');
            $code=$this->input->post('trde_mtmid');
            $unit=$this->input->post('trde_unitpercase');
            $remarks=$this->input->post('remarks');

            $order_qty = $this->input->post('order_qty');
            $pudeid = $this->input->post('pudeid'); 

            // $challan_remarks = $this->input->post('challan_remarks');
            $curtime=$this->general->get_currenttime();
            $userid=$this->session->userdata(USER_ID);
            $mac=$this->general->get_Mac_Address();
            $ip=$this->general->get_real_ipaddr();

            $challan_trdeid = $this->input->post('trdeid');
            $chde_challandetailid = $this->input->post('chde_challandetailid');
            
            $this->db->trans_begin();

            if($id){
                //update 
                $chderMasterArray = array(
                                    'chma_challanrecno'=>$receiveno,
                                    'chma_supplierid'=>$supplierid,
                                    'chma_challanrecdatebs'=>$chderdateNp,
                                    'chma_challanrecdatead'=>$chderdateEn,
                                    'chma_challannumber'=>$challanno,
                                    'chma_suchallanno'=>$challanno,
                                    'chma_receivedatebs'=>$supdateEn,
                                    'chma_receivedatead'=>$receivedateEn,
                                    'chma_suchalandatebs'=>$supdateEn,
                                    'chma_suchallandatead'=>$supdateEn,
                                    'chma_received'=>'N',
                                    'chma_modifydatead'=>CURDATE_EN,
                                    'chma_modifydatebs'=>CURDATE_NP,
                                    'chma_modifytime'=>$curtime,
                                    'chma_modifyby'=>$userid,
                                    'chma_modifymac'=>$mac,
                                    'chma_modifyip'=>$ip ,
                                    'chma_locationid'=>$this->locationid                 
                                );

                if(!empty($chderMasterArray)){
                    $this->db->where('chma_challanmasterid',$id);
                    $this->db->update($this->chma_masterTable,$chderMasterArray);

                    foreach ($itemid as $key => $val) {
                        $chderDetail = array(
                            'chde_itemsid'=> !empty($itemid[$key])?$itemid[$key]:'',
                            'chde_qty'=> !empty($qty[$key])?$qty[$key]:'',
                            'chde_code'=> !empty($code[$key])?$code[$key]:'',
                            'chde_remarks'=> !empty($remarks[$key])?$remarks[$key]:'',
                            'chde_pudeid' => !empty($pudeid[$key])?$pudeid[$key]:'',
                            'chde_modifydatead'=>CURDATE_EN,
                            'chde_modifydatebs'=>CURDATE_NP,
                            'chde_modifytime'=>$curtime,
                            'chde_modifyby'=>$userid,
                            'chde_modifymac'=>$mac,
                            'chde_modifyip'=>$ip,
                            'chde_locationid'=>$this->locationid       
                        );

                        if(!empty($chderDetail))
                        {  //echo"reqdata"; echo"<pre>";print_r($directpur_det);
                            $this->db->where('chde_challandetailid',$chde_challandetailid[$key]);
                            $this->db->update($this->chde_detailTable,$chderDetail);
                            // $detail_insertArray[] = $this->db->insert_id();
                        }
                    }

                    foreach($itemid as $key => $val){
                        $trde_update_detail = array(
                            'trde_requiredqty' => !empty($qty[$key])?$qty[$key]:'',
                            'trde_issueqty' => !empty($qty[$key])?$qty[$key]:'',
                            'trde_stripqty' => !empty($qty[$key])?$qty[$key]:'',
                            'trde_newissueqty' => !empty($qty[$key])?$qty[$key]:'',
                            'trde_modifyip'=>$ip,
                            'trde_modifydatead'=>CURDATE_EN,
                            'trde_modifydatebs'=>CURDATE_NP,
                            'trde_modifymac'=>$mac,
                            'trde_modifytime'=>$curtime,
                            'trde_modifyby'=>$userid,
                        );

                        if(!empty($trde_update_detail)){
                            $this->db->where('trde_trdeid', $challan_trdeid[$key]);
                            $this->db->update($this->trde_detailTable, $trde_update_detail);
                        }
                    }
                }

            }else{
                //insert
                $chderMasterArray = array(
                                    'chma_challanrecno'=>$receiveno,
                                    'chma_supplierid'=>$supplierid,
                                    'chma_challanrecdatebs'=>$chderdateNp,
                                    'chma_challanrecdatead'=>$chderdateEn,
                                    'chma_challannumber'=>$challanno,
                                    'chma_suchallanno'=>$challanno,
                                    'chma_receivedatebs'=>$supdateEn,
                                    'chma_receivedatead'=>$receivedateEn,
                                    'chma_suchalandatebs'=>$supdateEn,
                                    'chma_suchallandatead'=>$supdateEn,
                                    'chma_received'=>'N',
                                    'chma_puorid'=>$orderno,
                                    'chma_fyear'=>$fyear,
                                    'chma_postdatead'=>CURDATE_EN,
                                    'chma_postdatebs'=>CURDATE_NP,
                                    'chma_posttime'=>$curtime,
                                    'chma_postby'=>$userid,
                                    'chma_postmac'=>$mac,
                                    'chma_postip'=>$ip ,
                                    'chma_locationid'=>$this->locationid,
                                    'chma_orgid'=>$this->orgid               
                                );
                if(!empty($chderMasterArray)){   
                    //echo "<pre>";print_r($chderMasterArray);die;
                    $this->db->insert($this->chma_masterTable,$chderMasterArray);
                    $insertid=$this->db->insert_id();
                    if($insertid)
                    {
                        foreach ($itemid as $key => $val) {
                            $chderDetail = array(
                                'chde_challanmasterid'=>$insertid,
                                'chde_itemsid'=> !empty($itemid[$key])?$itemid[$key]:'',
                                'chde_qty'=> !empty($qty[$key])?$qty[$key]:'',
                                'chde_code'=> !empty($code[$key])?$code[$key]:'',
                                'chde_remarks'=> !empty($remarks[$key])?$remarks[$key]:'',
                                'chde_pudeid' => !empty($pudeid[$key])?$pudeid[$key]:'',
                                'chde_postdatead'=>CURDATE_EN,
                                'chde_postdatebs'=>CURDATE_NP,
                                'chde_status'=>'N',
                                'chde_receivecomplete'=>'N',
                                'chde_posttime'=>$curtime,
                                'chde_postby'=>$userid,
                                'chde_postmac'=>$mac,
                                'chde_postip'=>$ip,
                                'chde_locationid'=>$this->locationid,
                                'chde_orgid'=>$this->orgid      
                            );

                            if(!empty($chderDetail))
                            {
                                $this->db->insert($this->chde_detailTable,$chderDetail);
                                $detail_challanArray[] =$this->db->insert_id();
                            }
                        }

                        //update purchase order status
                        $puor_array = array(
                                        'puor_status'=>'CH'
                                    );
                        if(!empty($puor_array)){
                            $this->db->where(array('puor_fyear'=>$fyear,'puor_orderno'=>$orderno));
                            $this->db->update($this->puor_masterTable,$puor_array);
                        }
                        
                    }
                }
                /*
                    this is for transmaster and transdetails data 
                */
                $transMasterArray = array(
                                'trma_transactiondatead'=>$chderdateNp,
                                'trma_transactiondatebs'=>$chderdateEn,
                                'trma_transactiontype'=>'PURCHASE',
                                'trma_fromdepartmentid'=>$this->storeid,
                                'trma_todepartmentid'=>$this->storeid,
                                'trma_fromby'=>$this->userid,
                                'trma_toby'=>$this->userid,
                                'trma_status'=>'O',
                                'trma_sysdate'=>CURDATE_EN,
                                'trma_lastchangedate'=>CURDATE_EN,
                                'trma_statusupdatedate'=>CURDATE_EN,
                                'trma_received'=>'1',
                                'trma_receiveddatebs'=>$receivedateNp,
                                'trma_receivedby'=>$this->username,
                                'trma_remarks'=>'Challan first',
                                'trma_fyear'=>CUR_FISCALYEAR,
                                'trma_sttransfer'=>'N',
                                'trma_postdatead'=>CURDATE_EN,
                                'trma_postdatebs'=>CURDATE_NP,
                                'trma_posttime'=>$curtime,
                                'trma_postby'=>$userid,
                                'trma_postusername'=>$this->username,
                                'trma_postip'=>$ip,
                                'trma_postmac'=>$mac,
                                'trma_locationid'=>$this->locationid,
                                'trma_orgid'=>$this->orgid     
                            );
                if(!empty($transMasterArray))
                {   
                    //echo"<pre>"; print_r($transMasterArray);
                    $this->db->insert($this->trma_masterTable,$transMasterArray);
                    $insertidtr=$this->db->insert_id();
                    $this->db->update($this->chma_masterTable,array('chma_mattransmasterid'=>$insertidtr),array('chma_challanmasterid'=>$insertid));
                    //echo $this->db->last_query();die;
                    if($insertidtr)
                    {
                        foreach ($itemid as $key => $val) {
                            $tranDetail[]=array(
                                    'trde_trmaid'=>$insertidtr,
                                    'trde_transactiondatead'=>CURDATE_EN,
                                    'trde_transactiondatebs'=>CURDATE_NP,
                                    'trde_postdatebs'=>CURDATE_NP,
                                    'trde_itemsid'=>!empty($itemid[$key])?$itemid[$key]:'',
                                    'trde_controlno'=>'CR',
                                    'trde_mfgdatead'=>'CR',
                                    'trde_mfgdatebs'=>'CR',
                                    'trde_mtdid'=>!empty($detail_challanArray[$key])?$detail_challanArray[$key]:'',// inserted while bill is received
                                    'trde_batchno'=>'CR',
                                    'trde_requiredqty'=>!empty($qty[$key])?$qty[$key]:'',
                                    'trde_issueqty'=>!empty($qty[$key])?$qty[$key]:'',
                                    'trde_stripqty'=>!empty($qty[$key])?$qty[$key]:'',
                                    'trde_status'=>'O',
                                    'trde_sysdate'=>CURDATE_EN,
                                    'trde_lastchangedate'=>CURDATE_NP,
                                    'trde_mtmid'=>$supplierid,  //no of challan in fiscal year and incerased by one  
                                    'trde_transactiontype'=>'PURCHASE',
                                    'trde_statusupdatedatebs'=>CURDATE_NP,
                                    'trde_statusupdatedatead'=>CURDATE_EN,
                                    'trde_remarks'=>'Challan First',
                                    'trde_supplierid'=>$supplierid,
                                    'trde_supplierbillno'=>$challanno,
                                    'trde_description'=>!empty($remarks[$key])?$remarks[$key]:'',
                                    'trde_newissueqty'=>!empty($qty[$key])?$qty[$key]:'',
                                    'trde_postip'=>$ip,
                                    'trde_postdatead'=>CURDATE_EN,
                                    'trde_postmac'=>$mac,
                                    'trde_posttime'=>$curtime,
                                    'trde_postby'=>$userid,
                                    'trde_locationid'=>$this->locationid,
                                    'trde_orgid'=>$this->orgid
                                );
                        }
                        //echo"<pre>";print_r($tranDetail);die;
                        if(!empty($tranDetail))
                        {  
                            $this->db->insert_batch($this->trde_detailTable,$tranDetail);
                        }
                    }
                }

                //update remqty in purchase order table
                if(!empty($itemid)){
                    $all_total_qty = 0;
                    foreach($itemid as $key=>$value){
                        $pude_id = !empty($pudeid[$key])?$pudeid[$key]:'';

                        $orderqty = !empty($order_qty[$key])?$order_qty[$key]:0;
                        $receivedqty = !empty($qty[$key])?$qty[$key]:0;

                        $total_qty = $orderqty - $receivedqty;

                        $pude_array = array(
                                'pude_remqty' => $total_qty,
                                'pude_status' => 'CH'
                            );

                        $all_total_qty = $all_total_qty+$total_qty;

                        //update detail table
                        if(!empty($pude_array)){
                            $this->db->where('pude_puordeid',$pude_id);
                            $this->db->update($this->pude_detailTable, $pude_array);
                        }
                    }
                } // end if itemsid exists for purchase table   

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

    public function get_challan_list($cond = false)
    {   //echo"<pre>"; print_r($this->input->post());die;
        $frmDate=$this->input->get('frmDate');
        $toDate=$this->input->get('toDate');
        $get = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }
        if(!empty($get['sSearch_0'])){
            $this->db->where("lower(chma_challanmasterid) like  '%".$get['sSearch_0']."%'  ");
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("lower(chma_challannumber) like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("lower(dist_distributor) like  '%".$get['sSearch_2']."%'  ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("lower(chma_challanrecno) like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("lower(chma_receivedatead) like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("lower(chma_receivedatebs) like  '%".$get['sSearch_5']."%'  ");
        }
        if(!empty($get['sSearch_6'])){
            $this->db->where("lower(chma_suchallanno) like  '%".$get['sSearch_6']."%'  ");
        }
        if(!empty($get['sSearch_7'])){
            $this->db->where("lower(chma_suchalandatebs) like  '%".$get['sSearch_7']."%'  ");
        }
          if($cond) {
          $this->db->where($cond);
        }
        $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');
        $toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');
        $fyear = !empty($get['fyear'])?$get['fyear']:$this->input->post('fyear');
        $locationid= !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');
        $apptype = !empty($get['apptype'])?$get['apptype']:$this->input->post('apptype');

         if($apptype=='pending')
            {
                $approved='N';
            }
            if($apptype=='complete')
            {
                $approved='Y';
            }
          
        

        if($frmDate &&  $toDate){
            if(DEFAULT_DATEPICKER=='NP')
            {
              $this->db->where('chma_challanrecdatebs >=', $frmDate);
              $this->db->where('chma_challanrecdatebs <=', $toDate);
            }
            else
            {
              $this->db->where('chma_challanrecdatead >=', $frmDate);
              $this->db->where('chma_challanrecdatead <=', $toDate);
            }
        }

        if($apptype)
        {
            $this->db->where('chma_received',$approved);
        }
     
             
    if($this->location_ismain=='Y'){
       if(!empty($locationid))
        {
            $this->db->where('chma_locationid',$locationid);
        }
        }else{
            $this->db->where('chma_locationid',$this->locationid);

        }

        $resltrpt=$this->db->select("COUNT(*) as cnt")
                    ->from('chma_challanmaster cm')
                   // ->join('chde_challandetails qd','qd.chde_challandetailid =cm.chma_challanmasterid','LEFT')
                    ->join('puor_purchaseordermaster pm','pm.puor_orderno = cm.chma_puorid and pm.puor_fyear = cm.chma_fyear','left')
                    ->join('dist_distributors t','t.dist_distributorid = cm.chma_supplierid','LEFT')
                    ->get()
                    ->row(); 
        //echo $this->db->last_query();die(); 
        $totalfilteredrecs=$resltrpt->cnt; 

        $order_by = 'chma_challanmasterid';
        $order = 'desc';
        if($this->input->get('sSortDir_0'))
        {
                $order = $this->input->get('sSortDir_0');
        }
  
        $where='';
        if($this->input->get('iSortCol_0')==0)
            $order_by = 'chma_challanmasterid';
        else if($this->input->get('iSortCol_0')==1)
            $order_by = 'chma_challannumber';
        else if($this->input->get('iSortCol_0')==2)
            $order_by = 'dist_distributor';
        else if($this->input->get('iSortCol_0')==3)
            $order_by = 'chma_challanrecno';
        else if($this->input->get('iSortCol_0')==4)
            $order_by = 'chma_receivedatead';
        else if($this->input->get('iSortCol_0')==5)
            $order_by = 'chma_receivedatebs';
        else if($this->input->get('iSortCol_0')==6)
            $order_by = 'chma_suchallanno';
        else if($this->input->get('iSortCol_0')==7)
            $order_by = 'chma_suchalandatebs';
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
            $this->db->where("lower(puor_purchasorderemaster_id) like  '%".$get['sSearch_0']."%'  ");
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("lower(chma_challannumber) like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("lower(dist_distributor) like  '%".$get['sSearch_2']."%'  ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("lower(chma_challanrecno) like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("lower(chma_receivedatead) like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("lower(chma_receivedatebs) like  '%".$get['sSearch_5']."%'  ");
        } 
        if(!empty($get['sSearch_6'])){
            $this->db->where("lower(chma_suchallanno) like  '%".$get['sSearch_6']."%'  ");
        }
        if(!empty($get['sSearch_7'])){
            $this->db->where("lower(chma_suchalandatebs) like  '%".$get['sSearch_7']."%'  ");
        }
        $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');
        $toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');
        $fyear = !empty($get['fyear'])?$get['fyear']:$this->input->post('fyear');
        $locationid= !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');
        $apptype = !empty($get['apptype'])?$get['apptype']:$this->input->post('apptype');
          if($apptype=='pending')
            {
                $approved='N';
            }
            if($apptype=='complete')
            {
                $approved='Y';
            }
          
        if($frmDate &&  $toDate){
            if(DEFAULT_DATEPICKER=='NP')
            {
              $this->db->where('chma_challanrecdatebs >=', $frmDate);
              $this->db->where('chma_challanrecdatebs <=', $toDate);
            }
            else
            {
              $this->db->where('chma_challanrecdatead >=', $frmDate);
              $this->db->where('chma_challanrecdatead <=', $toDate);
            }
        }

        if($apptype)
        {
            $this->db->where('chma_received',$approved);
        }

   if($this->location_ismain=='Y'){
       if(!empty($locationid))
        {
            $this->db->where('chma_locationid',$locationid);
        }
        }else{
            $this->db->where('chma_locationid',$this->locationid);

        }
        if($cond) {
          $this->db->where($cond);
        }
      
        $this->db->select('cm.*, t.dist_distributor,qd.chde_receivecomplete, pm.puor_orderdatead, pm.puor_orderdatebs');
        $this->db->from('chma_challanmaster cm');
        $this->db->join('chde_challandetails qd','qd.chde_challandetailid =cm.chma_challanmasterid','LEFT');
        $this->db->join('puor_purchaseordermaster pm','pm.puor_orderno = cm.chma_puorid and pm.puor_fyear = cm.chma_fyear','left');
        $this->db->join('dist_distributors t','t.dist_distributorid = cm.chma_supplierid','LEFT');
 
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
    public function chalanmaster($cond =false)
    {
            $this->db->select('t.dist_distributor,qd.chma_received,qd.chma_receivedatead,qd.chma_challanrecno,qd.chma_suchalandatebs, qd.chma_suchallanno, qd.chma_supplierid,qd.chma_challanmasterid,qd.chma_challanrecdatebs,qd.chma_receivedatebs, qd.chma_fyear, qd.chma_puorid,lo.loca_name');
            $this->db->from('chma_challanmaster qd');
            $this->db->join('dist_distributors t','t.dist_distributorid = qd.chma_supplierid','LEFT');
            $this->db->join('loca_location lo','lo.loca_locationid=qd.chma_locationid','LEFT');
            if($cond){
                $this->db->where($cond);
            }
          $query = $this->db->get();
          // echo $this->db->last_query();die();
          if($query->num_rows() > 0) 
          {
            $data=$query->result();   
            return $data;   
          }   
          return false;
    }
    public function chalandetails($cond =false)
    {
            $this->db->select('cd.chde_challandetailid,cm.chma_mattransmasterid,t.dist_distributor,cm.*,cm.chma_challanmasterid,cd.chde_remarks,cm.chma_receivedatebs,cd.chde_itemsid,cd.chde_qty,cd.chde_code,cm.chma_receivedatead,cm.chma_challanrecno,cm.chma_suchalandatebs, cm.chma_suchallanno, cm.chma_supplierid, t.dist_distributor, it.itli_itemcode,it.itli_itemname,it.itli_itemnamenp,un.unit_unitname,td.trde_trdeid, dist_address1');
            $this->db->from('chma_challanmaster cm');
            $this->db->join('chde_challandetails cd','cd.chde_challanmasterid = cm.chma_challanmasterid','LEFT');
            $this->db->join('trde_transactiondetail td','td.trde_trmaid = cm.chma_mattransmasterid and cd.chde_itemsid = td.trde_itemsid','LEFT');
            $this->db->join('dist_distributors t','t.dist_distributorid = cm.chma_supplierid','LEFT');
            $this->db->join('itli_itemslist it','it.itli_itemlistid = cd.chde_itemsid','LEFT');
            $this->db->join('unit_unit un','un.unit_unitid = it.itli_unitid','LEFT');
            if($cond){
                $this->db->where($cond);
            }
          $query = $this->db->get();
          // echo $this->db->last_query();die();
          if($query->num_rows() > 0) 
          {
            $data=$query->result();   
            return $data;   
          }   
          return false;
    }
    public function getStatusCount($srchcol = false){
        try{
            $this->db->select("SUM(CASE WHEN chma_received='Y' THEN 1 ELSE 0 END ) complete, SUM(CASE WHEN chma_received='N' THEN 1 ELSE 0 END ) pending");
                $this->db->from('chma_challanmaster'); 
            if($srchcol){
                $this->db->where($srchcol);
            }

            $query = $this->db->get();
            //echo $this->db->last_query();die();
            if($query->num_rows() > 0){
                return $query->result();
            }
            return false;
        }catch(Exception $e){
            throw $e;
        }
    }
    //This is challan bill entry 
    public function order_item_receive_save()
    {
        try{
            $challanmasterid = $this->input->post('id');
            $transmasterid = $this->input->post('tmraid');//this is for updating data 
            
           // echo "<pre>";print_r($masteridArray);die(); trde_trdeid
            $challandetailsid = $this->input->post('challandetailid');//this is for received details id
            $req_date=$this->input->post('order_date');
            $received_date=$this->input->post('received_date');
            $expiredate =   $this->input->post('end_date');
            $suplier_bill_date =   $this->input->post('suplier_bill_date');
            $trde_expdate= $this->input->post('trde_expdate');
            if(DEFAULT_DATEPICKER=='NP')
            {   $suplier_bill_dateNp=$suplier_bill_date;
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

            $receivedetailid = $this->input->post('receiveddetailid');
            
            $cc = $this->input->post('cc');

            $vat = $this->input->post('vat');
            $vatamt = $this->input->post('vatamt');

            $item_totalamt = $this->input->post('totalamt');

            $total_discountamt = $this->input->post('discountamt');
            $total_taxamt = $this->input->post('taxamt');

            //masster table 
            $remarks = $this->input->post('remarks');
            $bugetid = $this->input->post('bugetid');
            //insert form direct purchase in trans details and master
            
            $refund = $this->input->post('rf');
            // $receipt_no = $this->input->post('receipt_no');

            $receipt_no = $this->general->generate_invoiceno('recm_invoiceno','recm_invoiceno','recm_receivedmaster',RECEIVED_NO_PREFIX,RECEIVED_NO_LENGTH);

            // print_r($receipt_no);
            // die();
            // $trma_transactiontype = $this->input->post('trma_transactiontype');//form direct purchasre always PURCHASE
            $trma_transactiontype = 'PURCHASE';
            $trma_status = $this->input->post('trma_status'); 
            $supplierid = $this->input->post('supplier'); 
            $matdsupplierbillno = $this->input->post('trde_supplierbillno');

            //$receiveno = $this->general->getLastNo('recm_receivedno',$this->recm_masterTable,array('recm_fyear'=>$fiscal_year, 'recm_locationid'=>$this->locationid,'recm_departmentid'=>$this->depid,'recm_storeid'=>$this->storeid));
            // echo $this->db->last_query();print_r($receiveno);die();
            $this->db->trans_begin();
                //new direct purchase
            //echo "<pre>";print_r($this->input->post());die();
                $ReceiveMasterArray = array(
                                //'recm_purchaseorderno'=>!empty($order_number)?$order_number:0,
                                'recm_receiveddatead'=>$receivedateEn,
                                'recm_receiveddatebs'=>$receivedateNp,
                                'recm_fyear'=>$fiscal_year,
                                'recm_amount'=>$grandtotal,
                                'recm_discount'=>$total_discountamt,
                                'recm_refund' => $refund,
                                'recm_taxamount'=>$total_taxamt,
                                'recm_purchaseorderdatebs'=>$orderdateNp,
                                'recm_purchaseorderdatead'=>$orderdateEn,
                                'recm_remarks'=>$remarks, 
                                'recm_invoiceno'=>$receipt_no,
                                'recm_purchasestatus'=>'D',
                                'recm_status'=>'O',
                                'recm_challanno'=>$challanmasterid,
                                //'recm_receivedno'=>$receiveno+1,
                                'recm_supplierbillno'=>$suplier_bill_no,
                                'recm_dstat'=>'D',
                                'recm_tstat'=>'S',
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
                                'recm_departmentid'=>$this->depid,
                                'recm_storeid'=>$this->storeid,
                                'recm_locationid'=>$this->locationid,
                                'recm_postmac'=>$this->mac,
                                'recm_postip'=>$this->ip,
                                'recm_orgid'=>$this->orgid
                                                         
                            );
                if(!empty($ReceiveMasterArray))
                {   //echo"<pre>"; print_r($ReceiveMasterArray); die;
                    $this->db->insert($this->recm_masterTable,$ReceiveMasterArray);
                    $insertid=$this->db->insert_id();
                    if($insertid)
                    {
                        foreach ($itemsid  as $key => $val) {
                            $itmname = !empty($itemname[$key])?$itemname[$key]:'';
                            $desc = !empty($description[$key])?$description[$key]:'';
                            $item_desc = !empty($desc)?$itmname.' '.$desc:'';
                            $ReqDetail=array(
                                    'recd_receivedmasterid'=>$insertid,
                                    'recd_itemsid'=> !empty($itemsid[$key])?$itemsid[$key]:'',
                                    'recd_purchasedqty'=>!empty($qty[$key])?$qty[$key]:'',
                                    'recd_batchno'=> !empty($batch_no[$key])?$batch_no[$key]:'',
                                    'recd_cccharge'=> !empty($cc[$key])?$cc[$key]:'',
                                    'recd_arate'=> !empty($puit_unitprice[$key])?$puit_unitprice[$key]:'',
                                    'recd_salerate'=> !empty($puit_unitprice[$key])?$puit_unitprice[$key]:'',
                                    'recd_vatpc'=> !empty($vat[$key])?$vat[$key]:'',
                                    'recd_vatamt' =>!empty($vatamt[$key])?$vatamt[$key]:'',
                                            //'recd_controlno'=>'Not Found'
                                    'recd_st'=>'N',
                                    'recd_free'=> !empty($free[$key])?$free[$key]:'',
                                    'recd_amount'=> !empty($item_totalamt[$key])?$item_totalamt[$key]:'',
                                    'recd_unitprice'=> !empty($puit_unitprice[$key])?$puit_unitprice[$key]:'',
                                    'recd_discountpc'=> !empty($discountper[$key])?$discountper[$key]:'',
                                        //'puit_taxid'=> !empty($taxtype[$key])?$taxtype[$key]:'',
                                    'recd_description'=> !empty($item_desc)?$item_desc:'',
                                    'recd_discountamt'=> !empty($discountamt[$key])?$discountamt[$key]:'',
                                        //'recd_expdatead'=>expiredateEn,
                                        //'recd_expdatebs'=>expiredateNp,
                                    'recd_challandetailid'=> !empty($challandetailsid[$key])?$challandetailsid[$key]:'',
                                    'recd_postdatead'=>CURDATE_EN,
                                    'recd_postdatebs'=>CURDATE_NP,
                                    'recd_enteredby'=>$this->username,
                                    'recd_postusername' => $this->username,
                                    'recd_posttime'=>$this->curtime,
                                    'recd_postby'=>$this->userid,
                                    'recd_postmac'=>$this->mac,
                                    'recd_postip'=>$this->ip,
                                    'recd_locationid'=>$this->locationid,
                                    'recd_orgid'=>$this->orgid 
                                );
                            if(!empty($ReqDetail))
                            {  //echo"reqdata"; echo"<pre>";print_r($ReqDetail);
                                $this->db->insert($this->recd_detailTable,$ReqDetail);
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
                $masteridArray = $this->general->get_tbl_data('*','trde_transactiondetail',array('trde_trmaid'=>$transmasterid),'trde_trdeid','ASC');
                if(!empty($masteridArray))
                {
                    foreach ($masteridArray as $key => $mv) {
                        $tranDetail=array(
                                        'trde_mtdid'=>!empty($detail_insertArray[$key])?$detail_insertArray[$key]:'',
                                        'trde_unitprice'=> !empty($puit_unitprice[$key])?$puit_unitprice[$key]:'',
                                        'trde_selprice'=>!empty($puit_unitprice[$key])?$puit_unitprice[$key]:'',
                                    );
                        if(!empty($tranDetail))
                        {   //echo"<pre>";print_r($tranDetail);die;
                            $this->db->update($this->trde_detailTable,$tranDetail,array('trde_trdeid'=>$mv->trde_trdeid));
                            // echo $this->db->last_query();die;
                        }
                    }
                    $chalandetails = array(
                                            'chma_modifydatead'=>CURDATE_EN,
                                            'chma_modifydatebs'=>CURDATE_NP,
                                            'chma_modifytime'=>$this->curtime,
                                            'chma_received'=>'Y',
                                            'chma_modifyip'=>$this->ip,
                                            'chma_modifymac'=>$this->mac,
                                            );
                    if($challanmasterid)
                    {
                       $this->db->update('chma_challanmaster',$chalandetails,array('chma_challanmasterid'=>$challanmasterid)); 
                       //echo $this->db->last_query();die;
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

    public function get_order_list($cond = false)
    {
        $get = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("lower(puor_orderno) like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("lower(puor_requno) like  '%".$get['sSearch_2']."%'  ");
        }
        
        if(!empty($get['sSearch_3'])){
            if(DEFAULT_DATEPICKER=='NP'){
                $this->db->where("lower(puor_orderdatebs) like  '%".$get['sSearch_3']."%'  ");       
            }else{
                $this->db->where("lower(puor_orderdatead) like  '%".$get['sSearch_3']."%'  ");
            }
        }

        if(!empty($get['sSearch_4'])){
            $this->db->where("lower(dist_distributor) like  '%".$get['sSearch_4']."%'  ");
        }

        if(!empty($get['sSearch_5'])){
            $this->db->where("lower(puor_amount) like  '%".$get['sSearch_5']."%'  ");
        }

        if($cond) {
            $this->db->where($cond);
        }

        $resltrpt=$this->db->select("COUNT(*) as cnt")
                    ->from('puor_purchaseordermaster po')
                    ->join('dist_distributors dist','po.puor_supplierid = dist.dist_distributorid','left')
                    ->where('puor_purchased <>',2)
                    ->get()
                    ->row();

        $totalfilteredrecs=$resltrpt->cnt; 

        $order_by = 'puor_orderno';
        $order = 'desc';
  
        $where='';
        if($this->input->get('iSortCol_0')==1)
            $order_by = 'puor_orderno';
        else if($this->input->get('iSortCol_0')==2)
            $order_by = 'puor_requno';
        else if($this->input->get('iSortCol_0')==3)
            $order_by = 'puor_orderdatebs';
        else if($this->input->get('iSortCol_0')==4)
            $order_by = 'dist_distributor';
        else if($this->input->get('iSortCol_0')==5)
            $order_by = 'puor_amount';
        
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
            $this->db->where("lower(puor_orderno) like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("lower(puor_requno) like  '%".$get['sSearch_2']."%'  ");
        }
        
        if(!empty($get['sSearch_3'])){
            if(DEFAULT_DATEPICKER=='NP'){
                $this->db->where("lower(puor_orderdatebs) like  '%".$get['sSearch_3']."%'  ");       
            }else{
                $this->db->where("lower(puor_orderdatead) like  '%".$get['sSearch_3']."%'  ");
            }
        }

        if(!empty($get['sSearch_4'])){
            $this->db->where("lower(dist_distributor) like  '%".$get['sSearch_4']."%'  ");
        }

        if(!empty($get['sSearch_5'])){
            $this->db->where("lower(puor_amount) like  '%".$get['sSearch_5']."%'  ");
        }

        $this->db->select('puor_purchaseordermasterid, puor_orderno,puor_requno, puor_orderdatead, puor_orderdatebs, puor_supplierid, puor_amount, dist_distributor');
        $this->db->from('puor_purchaseordermaster po');
        $this->db->join('dist_distributors dist','po.puor_supplierid = dist.dist_distributorid','left');
        $this->db->where('puor_purchased <>',2);

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

    public function get_order_details($srchcol = false){
        $this->db->select('it.itli_itemcode as itemcode, it.itli_itemname as itemname,it.itli_itemnamenp as itemnamenp, it.itli_itemlistid, it.itli_purchaserate, it.itli_salesrate, pd.pude_puordeid, pd.pude_itemsid, pd.pude_quantity as quantity, pd.pude_unit as unit_unitname, pd.pude_rate as rate, pd.pude_amount,pd.pude_discount, pd.pude_vat, pd.pude_remqty, pd.pude_remarks');
        $this->db->from('pude_purchaseorderdetail pd');
        $this->db->join('itli_itemslist it','it.itli_itemlistid = pd.pude_itemsid','left');

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

    public function get_order_details_from_po($cond=false)
    {
        $this->db->select('il.itli_itemlistid, il.itli_itemcode as itemcode, il.itli_itemname as itemname, il.itli_itemnamenp as itemnamenp,il.itli_purchaserate, il.itli_salesrate,s.supp_suppliername as suppliername, pom.puor_status as status, pod.pude_quantity as quantity, pod.pude_cancelqty as cancelqty, pom.puor_orderno as orderno, pod.pude_remarks, pod.pude_canceldatebs as canceldate, pod.pude_canceldatead, pom.puor_orderdatebs as orderdate, pom.puor_orderdatead, pod.pude_rate as rate, pod.pude_amount, pod.pude_quantity, pod.pude_vat as vat, pod.pude_discount as discount,pom.puor_purchaseordermasterid,pom.puor_orderdatebs,pom.puor_fyear,pom.puor_canceldatebs,pom.puor_amount,pom.puor_deliverydatebs,pom.puor_supplierid,pod.pude_remqty,pod.pude_itemsid,pod.pude_puordeid, pom.puor_purchased, un.unit_unitname, cd.chde_challandetailid, sum(chde_qty) as challanqty');
        $this->db->from('puor_purchaseordermaster pom');
        $this->db->join('pude_purchaseorderdetail pod','pom.puor_purchaseordermasterid = pod.pude_purchasemasterid','left');
        $this->db->join('chde_challandetails cd','pod.pude_puordeid = cd.chde_pudeid','left');
        $this->db->join('itli_itemslist il','il.itli_itemlistid = pod.pude_itemsid','left');
        $this->db->join('unit_unit un','un.unit_unitid = il.itli_unitid','LEFT');
        $this->db->join('supp_supplier s','pom.puor_supplierid = s.supp_supplierid','left');
        $this->db->group_by('itli_itemlistid');
        if($cond) {
          $this->db->where($cond);
        }
        $nquery=$this->db->get();

        // echo $this->db->last_query();
        // die();
        $num_row=$nquery->num_rows();
        if($num_row>0)
        {
            return $nquery->result();
        }
        return false;
    }

    public function get_order_details_for_bill_entry($srchcol = false){
        $this->db->select('it.itli_itemcode as itemcode, it.itli_itemname as itemname,it.itli_itemnamenp as itemnamenp, it.itli_itemlistid, it.itli_purchaserate, it.itli_salesrate, pd.pude_puordeid, pd.pude_itemsid, pd.pude_quantity as quantity, pd.pude_unit as unit_unitname, pd.pude_rate as rate, pd.pude_quantity, pd.pude_amount,pd.pude_discount, pd.pude_vat, pd.pude_remqty, pd.pude_remarks, sum(chde_qty) as challanqty, chde_challandetailid, chde_challanmasterid, pm.puor_purchased');
        $this->db->from('pude_purchaseorderdetail pd');
        $this->db->join('puor_purchaseordermaster pm','pm.puor_purchaseordermasterid = pd.pude_purchasemasterid','left');
        $this->db->join('itli_itemslist it','it.itli_itemlistid = pd.pude_itemsid','left');
        $this->db->join('chde_challandetails cd','cd.chde_pudeid = pd.pude_puordeid','left');
        $this->db->order_by('pude_puordeid','asc');
        $this->db->group_by('itli_itemlistid');

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

    public function get_all_challan_detail_id($srchcol = false){
        $this->db->select('chde_challandetailid');
        $this->db->from('chde_challandetails cd');
        $this->db->join('chma_challanmaster cm','cm.chma_challanmasterid = cd.chde_challanmasterid','left');

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

    public function save_challan_bill_entry()
    {

        // $postdata = $this->input->post();
        // echo "<pre>";
        // print_r($postdata);
        // die();

        //check id
        $id = $this->input->post('id');

        //received master data
        $orderno = $this->input->post('orderno');

        $fiscalyear = $this->input->post('fiscalyear');
        $supplierid = $this->input->post('supplierid');
        $orderdate = $this->input->post('order_date');
        $received_no = $this->input->post('received_no');
        $received_date = $this->input->post('received_date');
        $supplier_bill_no = $this->input->post('suplier_bill_no');
        $suplier_bill_date = $this->input->post('suplier_bill_date');
        $purchaseordermasterid = $this->input->post('purchaseordermasterid');

        $challanmasterid = $this->input->post('chde_chmaid');

        if(DEFAULT_DATEPICKER=='NP'){
            $orderdatebs = $orderdate;
            $orderdatead = $this->general->NepToEngDateConv($orderdate);

            $received_datebs = $received_date;
            $received_datead = $this->general->NepToEngDateConv($received_date);

            $suplier_bill_datebs = $suplier_bill_date;
            $suplier_bill_datead = $this->general->NepToEngDateConv($suplier_bill_date);
        }
        else{
            $orderdatead = $orderdate;
            $orderdatebs = $this->general->EngToNepDateConv($orderdate);

            $received_datead = $received_date;
            $received_datebs = $this->general->EngToNepDateConv($received_date);

            $suplier_bill_datead = $suplier_bill_date;
            $suplier_bill_datebs = $this->general->EngToNepDateConv($suplier_bill_date);
        }

        $bill_amount = $this->input->post('billamount');
        $remarks = $this->input->post('remarks');

        $insurance = $this->input->post('insurance');
        $carriage = $this->input->post('carriage');
        $packing = $this->input->post('packing');
        $transportamt = $this->input->post('transportamt');
        $otheramt = $this->input->post('otheramt');

        $totalamount = $this->input->post('totalamount');
        $discountamt = $this->input->post('discountamt');
        $subtotalamt = $this->input->post('subtotalamt');
        $taxamt = $this->input->post('taxamt');
        $extra = $this->input->post('extra');
        $refund = $this->input->post('refund');

        $clearanceamt = $this->input->post('clearanceamt');

        //received detail data
        $itemsid = $this->input->post('itemsid');
        $batchno = $this->input->post('batchno');
        $unit = $this->input->post('unit');
        $order_qty = $this->input->post('order_qty');
        $received_qty = $this->input->post('received_qty');
        $challan_qty = $this->input->post('challan_qty');
        $free = $this->input->post('free');
        $rate = $this->input->post('rate');
        $purchase_rate = $this->input->post('purchase_rate');
        $cc = $this->input->post('cc');
        $discount = $this->input->post('discount');
        $disamt = $this->input->post('disamt');
        $vat = $this->input->post('vat');
        $vatamt = $this->input->post('vatamt');
        $amount = $this->input->post('amount');
        $expiry_date = $this->input->post('expiry_date');
        $description = $this->input->post('description');
        $pudeid = $this->input->post('pudeid'); 
        $chde_id = $this->input->post('chde_id');

        // echo "<pre>";
        // print_r($chde_id);
        // die();

        $get_remain_items = $this->general->get_tbl_data('pude_remqty','pude_purchaseorderdetail',array('pude_remqty !='=>0, 'pude_purchasemasterid'=>$purchaseordermasterid));

        $count_input_items = count($itemsid);

        $count_remain_items = count($get_remain_items);


        $last_receivedno = $this->get_last_receivedno($fiscalyear, $this->storeid);

        $receivedno = !empty($last_receivedno[0]->recm_receivedno)?$last_receivedno[0]->recm_receivedno:0;

        $this->db->trans_begin();

        if($id){

        }else{
            $receivedMasterArray = array(
                        'recm_fyear' => $fiscalyear,
                        'recm_supplierid' => $supplierid,
                        'recm_purchaseorderno' => $orderno,
                        'recm_purchaseorderdatead' => $orderdatead,
                        'recm_purchaseorderdatebs'=> $orderdatebs,
                        'recm_purchaseordermasterid' => $purchaseordermasterid,
                        'recm_receivedno' => $receivedno+1,
                        'recm_receiveddatebs' => $received_datebs,
                        'recm_receiveddatead' => $received_datead,
                        'recm_supplierbillno' => $supplier_bill_no,
                        'recm_supbilldatebs' => $suplier_bill_datebs,
                        'recm_supbilldatead' => $suplier_bill_datead,
                        'recm_clearanceamount' => $clearanceamt,
                        'recm_challanno'=>$challanmasterid,
                        'recm_amount' => $totalamount,//
                        'recm_discount' => $discountamt,
                        'recm_taxamount' => $taxamt,          
                        'recm_departmentid' => $this->storeid,
                        'recm_storeid' => $this->storeid,
                        'recm_status' => 'O',                        
                        'recm_invoiceno' => $received_no,
                        'recm_insurance' => $insurance,
                        'recm_carriagefreight' => $carriage,
                        'recm_packing' => $packing,
                        'recm_transportcourier' => $transportamt,
                        'recm_others' => $otheramt,
                        'recm_remarks' => $remarks,
                        'recm_ischallan' => 'Y',
                        'recm_postusername' => $this->username,
                        'recm_postby' => $this->userid,
                        'recm_postdatead' => CURDATE_EN,
                        'recm_postdatebs' => CURDATE_NP,
                        'recm_posttime' => $this->curtime,
                        'recm_postmac' => $this->mac,
                        'recm_postip' => $this->ip,
                        'recm_locationid'=>$this->locationid,
                        'recm_orgid'=>$this->orgid
                    );
           
            if(!empty($receivedMasterArray)){
                $this->db->insert($this->recm_masterTable,$receivedMasterArray);
                $insert_id = $this->db->insert_id();

                if($insert_id){
                    $detail_insertArray=array();
                    // if insert in master, insert in detail table
                    if(!empty($itemsid)){
                        foreach($itemsid as $key=>$val):

                            $expiry_date = !empty($expiry_date[$key])?$expiry_date[$key]:'';
                            if(DEFAULT_DATEPICKER == 'NP'){
                                $expirydatebs = $expiry_date; 
                                $expirydatead = $this->general->NepToEngDateConv($expiry_date);
                            }else{
                                $expirydatead = $expiry_date;
                                $expirydatebs = $this->general->EngToNepDateConv($expiry_date);
                            }

                            $purchased_qty = !empty($received_qty[$key])?$received_qty[$key]:0;
                            $challan_quantity = !empty($challan_qty[$key])?$challan_qty[$key]:0;
                            $received_rate = !empty($rate[$key])?$rate[$key]:0;
                            $purchaserate = !empty($purchase_rate[$key])?$purchase_rate[$key]:0;
                            $cc_charge = !empty($cc[$key])?$cc[$key]:0;
                            $discountpc = !empty($discount[$key])?$discount[$key]:0;
                            $discountamt = !empty($disamt[$key])?$disamt[$key]:0;
                            $vatpc = !empty($vat[$key])?$vat[$key]:0;
                            $vatamt_total = !empty($vatamt[$key])?$vatamt[$key]:0;
                            $amount_total = !empty($amount[$key])?$amount[$key]:0;

                            $receive_itemsid = !empty($itemsid[$key])?$itemsid[$key]:'';

                            //get all challan detail ids from itemsid and po to update price
                            if(!empty($challan_quantity)):
                                $all_chde_id = $this->get_all_challan_detail_id(array('chma_fyear'=>$fiscalyear,'chma_puorid'=>$orderno,'chde_itemsid'=>$receive_itemsid));

                                foreach($all_chde_id as $key=>$ids){
                                    $array_chde_id[] = $ids->chde_challandetailid;
                                }

                                //update trde price
                                if(!empty($array_chde_id)){
                                    foreach($array_chde_id as $key=>$ch){
                                        $challanid = !empty($array_chde_id[$key])?$array_chde_id[$key]:0;
                                        // $new_rate = !empty($rate[$key])?$rate[$key]:0;

                                        if($challanid != 0){
                                            $this->update_trde_price($fiscalyear, $challanid, $received_rate, $receive_itemsid);    
                                        }
                                    }
                                }
                            endif;

                            //receive continue
                            $receivedDetailArray= array(
                                'recd_receivedmasterid'=>$insert_id,
                                'recd_itemsid' => $receive_itemsid,
                                'recd_purchasedqty' => $purchased_qty,
                                'recd_challanqty' => $challan_quantity,
                                'recd_amount' => $amount_total,
                                'recd_qualitystatus' => 'O',
                                'recd_status' => 'O',
                                'recd_batchno' => !empty($batchno[$key])?$batchno[$key]:'',
                                'recd_st' => 'N',
                                'recd_expdatead' => $expirydatead,
                                'recd_expdatebs' => $expirydatebs,
                                'recd_cccharge' => $cc_charge,
                                // 'recd_unitprice' => $purchaserate,
                                'recd_unitprice' => $received_rate,
                                'recd_arate' => $received_rate,
                                'recd_salerate' => $received_rate,
                                'recd_free' => !empty($free[$key])?$free[$key]:'',
                                'recd_discountpc' => $discountpc,
                                'recd_discountamt' => $discountamt,
                                'recd_vatpc' => $vatpc,
                                'recd_vatamt' => $vatamt_total,
                                'recd_purchaseorderdetailid' => !empty($pudeid[$key])?$pudeid[$key]:'',
                                'recd_challandetailid' => !empty($chde_id[$key])?$chde_id[$key]:'',
                                'recd_description' => !empty($description[$key])?$description[$key]:'',
                                'recd_postusername' => $this->username,
                                'recd_postby' => $this->userid,
                                'recd_postdatead' => CURDATE_EN,
                                'recd_postdatebs' => CURDATE_NP,
                                'recd_posttime' => $this->curtime,
                                'recd_postmac' => $this->mac,
                                'recd_postip' => $this->ip,
                                'recd_locationid'=>$this->locationid,
                                'recd_orgid'=>$this->orgid 
                            );

                            if(!empty($receivedDetailArray)){
                                $this->db->insert($this->recd_detailTable, $receivedDetailArray);
                                $detail_insertArray[] =$this->db->insert_id();
                            }
                        endforeach; 

                        foreach ($itemsid  as $key => $val) {
                            $itemid = !empty($itemsid[$key])?$itemsid[$key]:'';
                            $unitprice = !empty($rate[$key])?$rate[$key]:'';
                            $this->general->compare_item_price($itemid,$unitprice);
                            // echo $this->db->last_query();
                        } 

                    } // end if itemsid

                    //insert in transaction master table

                    $mattransMasterArray = array(
                                'trma_transactiondatead' => $received_datead,
                                'trma_transactiondatebs' => $received_datebs,
                                'trma_transactiontype' => 'PURCHASE',
                                'trma_fromdepartmentid' => $this->storeid, //recheck
                                'trma_todepartmentid' => $this->storeid, //recheck
                                'trma_status' => 'O',
                                'trma_received' => '1',
                                'trma_fyear' => $fiscalyear,
                                'trma_fromby' => $this->userid, //recheck
                                'trma_toby' => $this->userid, //recheck
                                'trma_sttransfer' => 'N', //N
                                'trma_issueno' => $received_no,
                                'trma_postby' => $this->userid,
                                'trma_postdatead' => CURDATE_EN,
                                'trma_postdatebs' => CURDATE_NP,
                                'trma_posttime' => $this->curtime,
                                'trma_postusername'=>$this->username,
                                'trma_postmac' => $this->mac,
                                'trma_postip' => $this->ip,
                                'trma_locationid'=>$this->locationid,
                                'trma_orgid'=>$this->orgid
                            );
                    
                    if(!empty($mattransMasterArray)){
                        $this->db->insert($this->trma_masterTable,$mattransMasterArray);
                        $master_insertid = $this->db->insert_id();
                    }

                    if(!empty($master_insertid)){
                        if(!empty($itemsid)):
                            $trde_insert_array = array();
                            foreach($itemsid as $key=>$value){
                                $qty_total = !empty($qty[$key])?$qty[$key]:0;

                                $receivedqty = !empty($received_qty[$key])?$received_qty[$key]:'';
                                $challanqty = !empty($challan_qty[$key])?$challan_qty[$key]:0;

                                $receivedqty_after_challan = $receivedqty - $challanqty;

                                $expiry_date = !empty($expiry_date[$key])?$expiry_date[$key]:'';
                                if(DEFAULT_DATEPICKER == 'NP'){
                                    $expirydatebs = $expiry_date; 
                                    $expirydatead = $this->general->NepToEngDateConv($expiry_date);
                                }else{
                                    $expirydatead = $expiry_date;
                                    $expirydatebs = $this->general->EngToNepDateConv($expiry_date);
                                }

                                $mattransDetailArray = array(
                                    'trde_trmaid' => $master_insertid,
                                    'trde_mtdid' => !empty($detail_insertArray[$key])?$detail_insertArray[$key]:'',
                                    'trde_transactiondatead' => CURDATE_EN,
                                    'trde_transactiondatebs' => CURDATE_NP,
                                    'trde_itemsid' => !empty($itemsid[$key])?$itemsid[$key]:'',
                                    'trde_controlno' => '',
                                    'trde_expdatebs' => $expirydatebs,
                                    'trde_expdatead' => $expirydatead,
                                    'trde_controlno' => '',
                                    'trde_requiredqty' => $receivedqty_after_challan,
                                    'trde_issueqty' => $receivedqty_after_challan,
                                    'trde_transferqty' => '',
                                    'trde_status' => 'O', //O
                                    'trde_sysdate' => CURDATE_NP,
                                    'trde_transactiontype' => 'PURCHASE',
                                    'trde_unitprice' => !empty($rate[$key])?$rate[$key]:'0.00',
                                    'trde_selprice' => !empty($rate[$key])?$rate[$key]:'0.00',
                                    'trde_supplierid' => $supplierid,
                                    'trde_mtmid' => $supplierid,
                                    'trde_supplierbillno' => $supplier_bill_no,
                                    'trde_unitvolume' => 0,
                                    'trde_microunitid' => 0,
                                    'trde_totalvalue' => 0,
                                    'trde_description' => !empty($description[$key])?$description[$key]:'',
                                    'trde_newissueqty' => $receivedqty_after_challan,
                                    'trde_postby' => $this->userid,
                                    'trde_postdatead' => CURDATE_EN,
                                    'trde_postdatebs' => CURDATE_NP,
                                    'trde_posttime' => $this->curtime,
                                    'trde_postmac' => $this->mac,
                                    'trde_postip' => $this->ip,
                                    'trde_locationid'=>$this->locationid,
                                    'trde_orgid'=>$this->orgid
                                );

                                if(!empty($mattransDetailArray)){
                                    $this->db->insert($this->trde_detailTable, $mattransDetailArray);
                                    $trde_insert_array[] = $this->db->insert_id();
                                }
                            }
                        endif;

                    } // end check if master insertid

                    //purchase order array
                    if(!empty($itemsid)){
                        $all_total_qty = 0;
                        foreach($itemsid as $key=>$value){
                            $pude_id = !empty($pudeid[$key])?$pudeid[$key]:'';

                            $orderqty = !empty($order_qty[$key])?$order_qty[$key]:0;
                            $receivedqty = !empty($received_qty[$key])?$received_qty[$key]:0;

                            $total_qty = $orderqty - $receivedqty;

                            $pude_array = array(
                                    'pude_remqty' => $total_qty,
                                );

                            $all_total_qty = $all_total_qty+$total_qty;

                            //update detail table
                            if(!empty($pude_array)){
                                $this->db->where('pude_puordeid',$pude_id);
                                $this->db->update($this->pude_detailTable, $pude_array);
                            }
                        }

                        // check received status and insert into master table
                        if($count_input_items >= $count_remain_items){
                            if($all_total_qty == 0){
                                $received_status = 2;

                                $puor_array = array(
                                    'puor_status'=> 'R',
                                    'puor_purchased' =>$received_status
                                ); 

                            }else{
                                $received_status = 1;

                                $puor_array = array(
                                    'puor_purchased' =>$received_status
                                ); 
                            }
                        }else{
                            $received_status = 1;

                             $puor_array = array(
                                'puor_purchased' =>$received_status
                            ); 
                        }                   

                        if(!empty($puor_array)){
                            $this->db->where('puor_purchaseordermasterid', $purchaseordermasterid);
                            $this->db->update($this->puor_masterTable,$puor_array);
                        }
                        // $rec_status ='Y';
                        //      $chma_array = array(
                        //         'chma_received' =>$rec_status
                        //     );
                        //  if(!empty($chma_array)){
                        //     $this->db->where('chma_puorid', $orderno);
                        //     $this->db->update($this->chma_masterTable,$chma_array);
                        // }
                    } // end if itemsid exists for purchase table       
                } // if insertid
            }
        }

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            if(!empty($id)){
                return $id;
            }else{
                return $insert_id;
            }
        }
    }

    function get_last_receivedno($fiscalyear, $storeid){
        try{
            if(empty($fiscalyear) || empty($storeid)){
                echo "Error occured. Please try again";
                return false;
            }

            $this->db->select_max('recm_receivedno');
            $this->db->from('recm_receivedmaster');
            $this->db->where('recm_fyear',$fiscalyear);
            $this->db->where('recm_departmentid',$storeid);

            $query = $this->db->get();

            if($query->num_rows()>0){
                return $query->result();
            }
            return false;

        }catch(Exception $e){
            throw $e;
        }
    }

    public function update_trde_price($fyear, $chid, $unitprice, $itemsid){
        $this->db->select('trde_trdeid,trde_trmaid,trde_itemsid');
        $this->db->from('trde_transactiondetail td');
        $this->db->join('chde_challandetails ch','ch.chde_challandetailid = td.trde_mtdid','left');
        $this->db->join('chma_challanmaster cm','ch.chde_challanmasterid = cm.chma_challanmasterid','left');
        $this->db->where('trde_mtdid',$chid);
        $this->db->where('trde_controlno','CR');
        $this->db->where('chma_fyear',$fyear);

        $query = $this->db->get();
        if($query->num_rows()>0){
            $result = $query->result();
        }
        $db_trdeid = $result[0]->trde_trdeid;
        $db_itemsid = $result[0]->trde_itemsid;

        $update_array = array(
            'trde_unitprice'=>$unitprice,
            'trde_selprice'=>$unitprice
        );

        $update_sade_array = array(
            'sade_unitrate'=>$unitprice,
            'sade_purchaserate'=>$unitprice,
            'sade_ischallanupdate' => 'Y',
            'sade_challanupdateby' => $this->userid,
            'sade_challandatead' => CURDATE_EN,
            'sade_challandatebs' => CURDATE_NP,
            'sade_challanupdatetime' => $this->curtime,
            'sade_challanupatemac' => $this->mac,
            'sade_challanupdateip' => $this->ip
        );
        if(!empty($db_trdeid)){
            $this->db->where('trde_trdeid',$db_trdeid);
            $this->db->where('trde_itemsid',$itemsid);
            $this->db->update('trde_transactiondetail',$update_array);

            $this->db->where('sade_mattransdetailid',$db_trdeid);
            $this->db->where('sade_itemsid',$itemsid);
            $this->db->update('sade_saledetail',$update_sade_array);

            return true;
        }
        return false;
    }

    public function get_challan_bill_entry_lists($cond = false)
    {   //echo"<pre>"; print_r($this->input->post());die;


        $get = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("lower(recm_receiveddatebs) like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("lower(recm_fyear) like  '%".$get['sSearch_2']."%'  ");
        }

        if(!empty($get['sSearch_3'])){
            $this->db->where("lower(recm_purchaseorderno) like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("lower(recm_purchaseorderno) like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("lower(dist_distributor) like  '%".$get['sSearch_5']."%'  ");
        }
        if(!empty($get['sSearch_6'])){
            $this->db->where("lower(recm_discount) like  '%".$get['sSearch_6']."%'  ");
        }
        if(!empty($get['sSearch_7'])){
            $this->db->where("lower(recm_taxamount) like  '%".$get['sSearch_7']."%'  ");
        }
        if(!empty($get['sSearch_8'])){
            $this->db->where("lower(recm_clearanceamount) like  '%".$get['sSearch_8']."%'  ");
        }
        if(!empty($get['sSearch_9'])){
            $this->db->where("lower(recm_posttime) like  '%".$get['sSearch_9']."%'  ");
        }
        if($cond) {
            $this->db->where($cond);
        }
        $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');
        $toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');
        // echo"<pre>";print_r($this->input->get());die;
        $fyear = !empty($get['fyear'])?$get['fyear']:$this->input->post('fyear');
        $store_id = !empty($get['store_id'])?$get['store_id']:$this->input->post('store_id');
      
      $locationid= !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');

             
   if($this->location_ismain=='Y'){
       if(!empty($locationid))
        {
            $this->db->where('rm.recm_locationid',$locationid);
        }
        }else{
            $this->db->where('rm.recm_locationid',$this->locationid);

        }

        if($frmDate &&  $toDate){
            if(DEFAULT_DATEPICKER=='NP')
            {
                $this->db->where('recm_receiveddatebs >=', $frmDate);
                $this->db->where('recm_receiveddatebs <=', $toDate);
            }
            else
            {
                $this->db->where('recm_receiveddatead >=', $frmDate);
                $this->db->where('recm_receiveddatead <=', $toDate);
            }
        }

        if($fyear)
        {
           $this->db->where('recm_fyear',$fyear);
        }

        $resltrpt=$this->db->select("COUNT(*) as cnt")
                    ->from('recm_receivedmaster rm')
                    ->join('dist_distributors s','s.dist_distributorid = rm.recm_supplierid','LEFT')
                    ->join('budg_budgets b','b.budg_budgetid = rm.recm_budgetid','LEFT')
                    // ->where('recm_purchaseordermasterid !=',0)
                    ->where('recm_challanno IS NOT NULL')
                    ->where('recm_purchaseordermasterid != 0 OR recm_challanno != 0')
                    ->get()
                    ->row();

        //echo $this->db->last_query();die(); 
        $totalfilteredrecs=$resltrpt->cnt; 

        $order_by = 'rm.recm_receiveddatebs';
        $order = 'DESC';
        if($this->input->get('sSortDir_0'))
        {
            $order = $this->input->get('sSortDir_0');
        }
  
        $where='';
        if($this->input->get('iSortCol_0')==1)
            $order_by = 'recm_receiveddatebs';
        else if($this->input->get('iSortCol_0')==2)
            $order_by = 'recm_fyear';
        else if($this->input->get('iSortCol_0')==3)
            $order_by = 'recm_invoiceno';
        else if($this->input->get('iSortCol_0')==4)
             $order_by = 'recm_purchaseorderno';
        else if($this->input->get('iSortCol_0')==5)
            $order_by = 'dist_distributor';
        else if($this->input->get('iSortCol_0')==6)
            $order_by = 'recm_discount';
        else if($this->input->get('iSortCol_0')==7)
            $order_by = 'recm_taxamount';
        else if($this->input->get('iSortCol_0')==8)
            $order_by = 'recm_clearanceamount';
         else if($this->input->get('iSortCol_0')==9)
            $order_by = 'recm_posttime';
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
            $this->db->where("lower(recm_receiveddatebs) like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("lower(recm_fyear) like  '%".$get['sSearch_2']."%'  ");
        }

        if(!empty($get['sSearch_3'])){
            $this->db->where("lower(recm_invoiceno) like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("lower(recm_purchaseorderno) like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("lower(dist_distributor) like  '%".$get['sSearch_5']."%'  ");
        }
        
        if(!empty($get['sSearch_6'])){
            $this->db->where("lower(recm_discount) like  '%".$get['sSearch_6']."%'  ");
        }
        if(!empty($get['sSearch_7'])){
            $this->db->where("lower(recm_taxamount) like  '%".$get['sSearch_7']."%'  ");
        }
        if(!empty($get['sSearch_8'])){
            $this->db->where("lower(recm_clearanceamount) like  '%".$get['sSearch_8']."%'  ");
        }
        if(!empty($get['sSearch_9'])){
            $this->db->where("lower(recm_posttime) like  '%".$get['sSearch_9']."%'  ");
        }
       
        if($cond) {
          $this->db->where($cond);
        }

        $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');
        $toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');

        if($frmDate &&  $toDate){
            if(DEFAULT_DATEPICKER=='NP')
            {
              $this->db->where('recm_receiveddatebs >=', $frmDate);
              $this->db->where('recm_receiveddatebs <=', $toDate);
            }
            else
            {
              $this->db->where('recm_receiveddatead >=', $frmDate);
              $this->db->where('recm_receiveddatead <=', $toDate);
            }
        }
         $locationid= !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');

             
   if($this->location_ismain=='Y'){
       if(!empty($locationid))
        {
            $this->db->where('rm.recm_locationid',$locationid);
        }
        }else{
            $this->db->where('rm.recm_locationid',$this->locationid);

        }

        $this->db->select('rm.recm_receivedmasterid,rm.recm_receiveddatebs,rm.recm_fyear,rm.recm_locationid,rm.recm_invoiceno,rm.recm_purchaseorderno as orderno,rm.recm_amount,s.dist_distributor, b.budg_budgetname,rm.recm_discount,rm.recm_taxamount,rm.recm_clearanceamount,rm.recm_posttime,
         rm.recm_status, rm.recm_challanno,(select group_concat(chma_challanmasterid) from xw_chma_challanmaster where chma_puorid = recm_purchaseorderno) as challanhistory ');
        $this->db->from('recm_receivedmaster rm');
        $this->db->join('dist_distributors s','s.dist_distributorid = rm.recm_supplierid','LEFT');
        $this->db->join('budg_budgets b','b.budg_budgetid = rm.recm_budgetid','LEFT');
        // $this->db->where('recm_purchaseordermasterid !=',0);
        $this->db->where('recm_challanno IS NOT NULL');
        $this->db->where('recm_purchaseordermasterid != 0 OR recm_challanno != 0');
        
        // if($fyear)
        // {
        //     $this->db->where('rm.recm_fyear',$fyear);
        // }
        if($store_id)
        {
            $this->db->where('recm_storeid',$store_id);
        }
        // if(!empty($order_by) && !empty($order)){
        //     $order_by = 'rm.recm_receiveddatebs';
        //     $order = 'desc';
        // }
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

        // echo $this->db->last_query(); die();
        
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
       public function getColorStatusCount($srchcol = false){
         $con1='';
         if($srchcol){
            if($this->location_ismain=='Y'){
               $con1= $srchcol;
           }else{
             
             $con1.= $srchcol;
             $con1.=" AND chma_locationid ='".$this->locationid."'";
         }
         }else{
             $con1='';
         }

$sql="SELECT * FROM
     xw_coco_colorcode cc
    LEFT JOIN (
     SELECT
         chma_received,
         COUNT('*') AS statuscount
     FROM
         xw_chma_challanmaster ch
     ".$con1."
     GROUP BY
         chma_received
    ) X ON x.chma_received = cc.coco_statusval
    WHERE
     cc.coco_listname = 'challan_list'
    AND cc.coco_statusval <> ''
    AND cc.coco_isactive = 'Y'";
            
         $query = $this->db->query($sql);
         // echo $this->db->last_query();
         // die();
         return $query->result();
        
    }

}