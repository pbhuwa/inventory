<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cancel_order_mdl extends CI_Model 
{
    public function __construct() 
    {
        parent::__construct();
        $this->approveTable = 'teap_tenderapproved';
        $this->quotation_detail = 'qude_quotationdetail';

        $this->curtime = $this->general->get_currenttime();
        $this->userid = $this->session->userdata(USER_ID);
        $this->mac = $this->general->get_Mac_Address();
        $this->ip = $this->general->get_real_ipaddr();
        $this->locationid = $this->session->userdata(LOCATION_ID);
        $this->username = $this->session->userdata(USER_NAME);
        $this->orgid = $this->session->userdata(ORG_ID);
        $this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
    }
    public $validate_settings_distributors = array(               
        array('field' => 'dist_distributor', 'label' => 'Distributor Name', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'dist_phone1', 'label' => 'Phone 1', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'dist_email', 'label' => 'Email', 'rules' => 'trim|valid_email|xss_clean'),
        array('field' => 'dist_repemail', 'label' => 'Sales Resp. Email', 'rules' => 'trim|valid_email|xss_clean')
    );
    public $validate_settings_cancelorder = array( 
        array('field' => 'itemsid[]', 'label' => 'Items Name', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'orderno', 'label' => 'Order Number', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'cancel_reason', 'label' => 'Cancel Reason', 'rules' => 'trim|required|xss_clean'),
    );
    public function get_cancel_order_list($cond = false)
    {

        $get = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("itli_itemcode like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            // $this->db->where("itli_itemname like  '%".$get['sSearch_2']."%'  ");
               $this->db->where("itli_itemname like  '%".$get['sSearch_2']."%' OR itli_itemnamenp like  '%".$get['sSearch_2']."%'  ");
        }

        if(!empty($get['sSearch_3'])){
            $this->db->where("supp_suppliername like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("pude_canceldatebs like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("puor_orderno like  '%".$get['sSearch_5']."%'  ");
        }
         $locationid= !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');
      if($this->location_ismain=='Y'){
            if(!empty($locationid))
            {
                  $this->db->where('pom.puor_locationid',$locationid);
            }
         }else{
            $this->db->where('pom.puor_locationid',$this->locationid);

        }
   
        if($cond) {
            $this->db->where($cond);
        }

        $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');
        $toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');

        $supplier = !empty($get['supplier'])?$get['supplier']:$this->input->post('supplier');
        
        $items = !empty($get['items'])?$get['items']:$this->input->post('items');

        if($frmDate &&  $toDate){
            if(DEFAULT_DATEPICKER=='NP')
            {
              $this->db->where('pude_canceldatebs >=', $frmDate);
              $this->db->where('pude_canceldatebs <=', $toDate);
            }
            else
            {
              $this->db->where('pude_canceldatead >=', $frmDate);
              $this->db->where('pude_canceldatead <=', $toDate);
            }
        }

        if(!empty($supplier)){
            $this->db->where('supp_supplierid',$supplier);
        }

        if(!empty($items)){
            $this->db->where('itli_itemlistid',$items);
        }

        $resltrpt=$this->db->select("COUNT(*) as cnt")
                    ->from('puor_purchaseordermaster pom')
                    ->join('pude_purchaseorderdetail pod','pom.puor_purchaseordermasterid = pod.pude_purchasemasterid','left')
                    ->join('itli_itemslist il','il.itli_itemlistid = pod.pude_itemsid','left')
                    ->join('supp_supplier s','pom.puor_supplierid = s.supp_supplierid','left')
                    ->where('pom.puor_status','C')
                    ->get()
                    ->row();

        // echo $this->db->last_query();die(); 
        $totalfilteredrecs=$resltrpt->cnt; 

        $order_by = 'itli_itemname';
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
            $order_by = 'supp_suppliername';
        else if($this->input->get('iSortCol_0')==4)
            $order_by = 'pude_canceldatebs';
        else if($this->input->get('iSortCol_0')==5)
            $order_by = 'puor_orderno';
        else if($this->input->get('iSortCol_0')==6)
            $order_by = 'puor_orderdatebs';
        else if($this->input->get('iSortCol_0')==7)
            $order_by = 'pude_cancelqty';
        else if($this->input->get('iSortCol_0')==8)
            $order_by = 'pude_rate';
        else if($this->input->get('iSortCol_0')==9)
            $order_by = 'pude_vat';
        else if($this->input->get('iSortCol_0')==10)
            $order_by = 'pude_discount';
        
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
            // $this->db->where("itli_itemname like  '%".$get['sSearch_2']."%'  ");
              $this->db->where("itli_itemname like  '%".$get['sSearch_2']."%' OR itli_itemnamenp like  '%".$get['sSearch_2']."%'  ");
        }

        if(!empty($get['sSearch_3'])){
            $this->db->where("supp_suppliername like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("pude_canceldatebs like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("puor_orderno like  '%".$get['sSearch_5']."%'  ");
        }
    
        if($cond) {
          $this->db->where($cond);
        }

        $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');
        $toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');

        $supplier = !empty($get['supplier'])?$get['supplier']:$this->input->post('supplier');
        
        $items = !empty($get['items'])?$get['items']:$this->input->post('items');

        if($frmDate &&  $toDate){
            if(DEFAULT_DATEPICKER=='NP')
            {
              $this->db->where('pude_canceldatebs >=', $frmDate);
              $this->db->where('pude_canceldatebs <=', $toDate);
            }
            else
            {
              $this->db->where('pude_canceldatead >=', $frmDate);
              $this->db->where('pude_canceldatead <=', $toDate);
            }
        }

        if(!empty($supplier)){
            $this->db->where('supp_supplierid',$supplier);
        }

        if(!empty($items)){
            $this->db->where('itli_itemlistid',$items);
        }
            if($this->location_ismain=='Y'){
            if(!empty($locationid))
              {
                  $this->db->where('pom.puor_locationid',$locationid);
              }
               }else{
               $this->db->where('pom.puor_locationid',$this->locationid);

            }
   
        $this->db->select('il.itli_itemcode as itemcode, il.itli_itemname as itemname, il.itli_itemnamenp as itemnamenp, s.supp_suppliername as suppliername, pom.puor_status as status, pod.pude_quantity as quantity, pod.pude_cancelqty as cancelqty, pom.puor_orderno as orderno, pod.pude_remarks as remarks, pod.pude_canceldatebs as canceldate, pod.pude_canceldatead, pom.puor_orderdatebs as orderdate, pom.puor_orderdatead,pom.puor_locationid, pod.pude_rate as rate, pod.pude_vat as vat, pod.pude_discount as discount');
        $this->db->from('puor_purchaseordermaster pom');
        $this->db->join('pude_purchaseorderdetail pod','pom.puor_purchaseordermasterid = pod.pude_purchasemasterid','left');
        $this->db->join('itli_itemslist il','il.itli_itemlistid = pod.pude_itemsid','left');
        $this->db->join('supp_supplier s','pom.puor_supplierid = s.supp_supplierid','left');
        $this->db->where('pom.puor_status','C');
    
        if(!empty($order_by) && !empty($order)){
            $order_by = 'supp_suppliername, itli_itemname';
            $order = 'asc';
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
    public function get_cancelorder_list($cond=false)
    {
        $this->db->select('il.itli_itemcode as itemcode, il.itli_itemname as itemname, il.itli_itemnamenp as itemnamenp, pom.puor_status as status, pod.pude_quantity as quantity, pod.pude_cancelqty as cancelqty, pom.puor_orderno as orderno, pod.pude_remarks as remarks, pod.pude_canceldatebs as canceldate, pod.pude_canceldatead, pom.puor_orderdatebs as orderdate, pom.puor_orderdatead, pod.pude_rate as rate, pod.pude_amount, pod.pude_vat as vat, pod.pude_discount as discount,pom.puor_purchaseordermasterid,pom.puor_orderdatebs,pom.puor_fyear,pom.puor_canceldatebs,pom.puor_amount,pom.puor_deliverydatebs,pom.puor_supplierid,pod.pude_remqty,pod.pude_itemsid,pod.pude_puordeid, pom.puor_purchased, un.unit_unitname');
        $this->db->from('puor_purchaseordermaster pom');
        $this->db->join('pude_purchaseorderdetail pod','pom.puor_purchaseordermasterid = pod.pude_purchasemasterid','left');
        $this->db->join('itli_itemslist il','il.itli_itemlistid = pod.pude_itemsid','left');
        $this->db->join('unit_unit un','un.unit_unitid = il.itli_unitid','LEFT');
        $this->db->where('pom.puor_status !=', "C");
        if($cond) {
          $this->db->where($cond);
        }
        $nquery=$this->db->get();
        $num_row=$nquery->num_rows();
        if($num_row>0)
        {
            return $nquery->result();
        }
        return false;
    }

    public function save_cancel_order()
    {
       
        try{
            $postdata=$this->input->post();
            // echo "<pre>";print_r($postdata);die();
            $puor_orderdate=$this->input->post('puor_orderdate');
            $deliverydate=$this->input->post('deliverydate');
            $puor_orderdate=$this->input->post('puor_orderdate');
            $canceldate=$this->input->post('canceldate');
            $cancel_reason = $this->input->post('cancel_reason');
               
            if(DEFAULT_DATEPICKER=='NP')
            {
                $cancel_dateNp=$canceldate;
                $cancel_dateEn=$this->general->NepToEngDateConv($canceldate);
            }
            else
            {
                $cancel_dateEn=$canceldate;
                $cancel_dateNp=$this->general->EngToNepDateConv($canceldate);
            }
            
            $supplier=$this->input->post('supplier');
            $orderno=$this->input->post('orderno');
            $fiscalyear = $this->input->post('fiscalyear');
            $itemsid = $this->input->post('itemsid');
            $quantity = $this->input->post('quantity');
            $pude_remqty = $this->input->post('pude_remqty');
            $detailsid = $this->input->post('pude_puordeid');
            $remarks = $this->input->post('remarks');
            $cancelqty=$this->input->post('cancelqty');
                // $expdate = $this->input->post('expdate'); 
                // $mattransmasterid = $this->input->post('mattransmasterid'); 
                // $controlno = $this->input->post('controlno'); 
           
            $curtime=$this->general->get_currenttime();
            $userid=$this->session->userdata(USER_ID);
            $mac=$this->general->get_Mac_Address();
            $ip=$this->general->get_real_ipaddr();
            $cancelall=$this->input->post('cancel_all');
            if($cancelall)
            {
                $status="C";
            }
            
            $this->db->trans_begin();
            if(!empty($itemsid))
            {
                foreach ($itemsid as $key => $val) {
                    // $remqty =  $pude_remqty[$key] - $cancelqty[$key];
                    $pudedetlid = !empty($detailsid[$key])?$detailsid[$key]:'';
                    $cancel_update_array=array(
                                'pude_canceldatebs'=>$cancel_dateNp,
                                'pude_canceldatead'=>$cancel_dateEn,
                                // 'pude_itemsid'=> !empty($itemsid[$key])?$itemsid[$key]:'',
                                // 'pude_remqty'=> !empty($remqty)?$remqty:'',
                                //     // 'pude_postdatebs'=>CURDATE_NP,
                                //     // 'pude_postdatead'=>CURDATE_EN,
                                //     // 'pude_postip'=>$ip,                              
                                //     // 'pude_postmac'=>$mac,
                                //     // 'pude_posttime'=>$curtime,
                                //     // 'pude_postby'=>$userid,
                                'pude_remarks'=>!empty($remarks[$key])?$remarks[$key]:'',
                                'pude_cancelqty'=>!empty($cancelqty[$key])?$cancelqty[$key]:'',
                                'pude_status'=>!empty($status[$key])?$status[$key]:'',
                    ); 
                //echo"<pre>";print_r($cancel_update_array);die;
                $this->db->update('pude_purchaseorderdetail', $cancel_update_array,array('pude_puordeid'=>$pudedetlid));

                }// echo $this->db->last_query();die;
                $puor_masterid = $this->general->get_tbl_data('pude_purchasemasterid','pude_purchaseorderdetail',array('pude_puordeid'=>$pudedetlid),'pude_purchasemasterid','DESC');
                $upmaster_id = $puor_masterid[0]->pude_purchasemasterid;
                //print_r($upmaster_id);die;
                $puor_array = array(
                                'puor_status' => 'C',
                                'puor_canceldatebs' => $cancel_dateNp,
                                'puor_canceldatead' => $cancel_dateEn,
                                'puor_canceltime' => $this->curtime,
                                'puor_cancelremarks' => $cancel_reason
                                );
                $this->db->update('puor_purchaseordermaster',$puor_array,array('puor_purchaseordermasterid'=>$upmaster_id));
               // echo $this->db->last_query();die;
                if (ORGANIZATION_NAME == 'KUKL') {
                    if (defined('RUN_API') && RUN_API == 'Y'){
                        if (defined('API_CALL') && API_CALL == 'KUKL') {
                            $this->api_cancel_order($upmaster_id);
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
                return true;
            }
        }catch(Exception $e){
            $this->db->trans_rollback();
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
            $this->db->where("puor_orderno like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("puor_requno like  '%".$get['sSearch_2']."%'  ");
        }
        
        if(!empty($get['sSearch_3'])){
            if(DEFAULT_DATEPICKER=='NP'){
                $this->db->where("puor_orderdatebs like  '%".$get['sSearch_3']."%'  ");       
            }else{
                $this->db->where("puor_orderdatead like  '%".$get['sSearch_3']."%'  ");
            }
        }

        if(!empty($get['sSearch_4'])){
            $this->db->where("dist_distributor like  '%".$get['sSearch_4']."%'  ");
        }

        if(!empty($get['sSearch_5'])){
            $this->db->where("puor_amount like  '%".$get['sSearch_5']."%'  ");
        }

        if($cond) {
            $this->db->where($cond);
        }

        $resltrpt=$this->db->select("COUNT(*) as cnt")
                    ->from('puor_purchaseordermaster po')
                    ->join('dist_distributors dist','po.puor_supplierid = dist.dist_distributorid','left')
                    ->where('puor_status','N')
                    ->where('puor_purchased',0)
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
            $this->db->where("puor_orderno like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("puor_requno like  '%".$get['sSearch_2']."%'  ");
        }
        
        if(!empty($get['sSearch_3'])){
            if(DEFAULT_DATEPICKER=='NP'){
                $this->db->where("puor_orderdatebs like  '%".$get['sSearch_3']."%'  ");       
            }else{
                $this->db->where("puor_orderdatead like  '%".$get['sSearch_3']."%'  ");
            }
        }

        if(!empty($get['sSearch_4'])){
            $this->db->where("dist_distributor like  '%".$get['sSearch_4']."%'  ");
        }

        if(!empty($get['sSearch_5'])){
            $this->db->where("puor_amount like  '%".$get['sSearch_5']."%'  ");
        }

        $this->db->select('puor_purchaseordermasterid, puor_orderno,puor_requno, puor_orderdatead, puor_orderdatebs, puor_supplierid, puor_amount, dist_distributor');
        $this->db->from('puor_purchaseordermaster po');
        $this->db->join('dist_distributors dist','po.puor_supplierid = dist.dist_distributorid','left');
        $this->db->where('puor_status','N');
        $this->db->where('puor_purchased',0);

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
        $this->db->select('it.itli_itemcode as itemcode, it.itli_itemname as itemname, it.itli_itemnamenp as itemnamenp, it.itli_itemlistid, it.itli_purchaserate, it.itli_salesrate, pd.pude_puordeid, pd.pude_itemsid, pd.pude_quantity as quantity, pd.pude_unit as unit_unitname, pd.pude_rate as rate, pd.pude_amount,pd.pude_discount, pd.pude_vat');
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

    function api_cancel_order($order_id) 
    {   
        try{
        if (!$order_id)
        {
           throw new Exception('Order Id Not Given');
        }
        $this->db->select('pd.pude_requsitionid,purd_reqdetailid,rede_reqmasterid');
        $this->db->from('pude_purchaseorderdetail pd');
        $this->db->join('purd_purchasereqdetail prd','prd.purd_reqdetid = pd.pude_requsitionid','left');
        $this->db->join('rede_reqdetail rd','prd.purd_reqdetailid = rd.rede_reqdetailid','LEFT');
        $this->db->where('pude_purchasemasterid',$order_id);
        $ordered_items = $this->db->get()->result();

        if (!empty($ordered_items && count($ordered_items))) {
            foreach($ordered_items as $items){ 
                $post_data = array(
                    'Req_MasterId'=> $items->rede_reqmasterid,
                    'req_detailId' => $items->purd_reqdetailid,
                    'r_Status' => 'C', 
                    'insUp' => 'UP', 
                    'Entry_By' => null,
                    'Entry_Date' => null,
                    "Remarks" => 'Cancel Item', 
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
        return true;

        }catch(Exception $e){
            throw new Exception('Api Error Occured');
        }
    }
}