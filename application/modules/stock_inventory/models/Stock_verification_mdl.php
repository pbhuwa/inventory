<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Stock_verification_mdl extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->userid = $this->session->userdata(USER_ID);
        $this->username = $this->session->userdata(USER_NAME);
        $this->curtime = $this->general->get_currenttime();
        $this->mac = $this->general->get_Mac_Address();
        $this->ip = $this->general->get_real_ipaddr();
        $this->depid = $this->session->userdata(USER_DEPT);
        $this->locationid=$this->session->userdata(LOCATION_ID);
        $this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
        // $this->locationid=$this->session->userdata(LOCATION_ID);
    }




public function get_issue_serach($cond=false)
    {  
        $frmDate=$this->input->get('frmDate');
        $toDate=$this->input->get('toDate');
       

      $get = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
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

        $store_id = !empty($get['store_id'])?$get['store_id']:$this->input->post('store_id');
        $toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');
        $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');
        $locationid = !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');



        

        if(!empty(($store_id)))
        {  
            //print_r($store_id);die;
           $this->db->where('sm.sama_storeid',$store_id);
           
        }
        if(!empty($locationid)){
            $this->db->where('sm.sama_locationid',$locationid);
        }else{
            $this->db->where('sm.sama_locationid',$this->locationid);
        }

        if(!empty(($frmDate && $toDate)))
        {
            if(DEFAULT_DATEPICKER == 'NP'){
                $this->db->where('sama_billdatebs >=',$frmDate);
                $this->db->where('sama_billdatebs <=',$toDate);    
            }else{
                $this->db->where('sama_billdatead >=',$frmDate);
                $this->db->where('sama_billdatead <=',$toDate);
            }
        }


        $resltrpt=$this->db->select("itli_itemlistid")
                    ->from('itli_itemslist il')
                    ->join('sade_saledetail sd', 'sd.sade_itemsid = il.itli_itemlistid', "LEFT")
                    ->join('sama_salemaster sm', 'sm.sama_salemasterid=sd.sade_salemasterid', "LEFT")
                    ->join('unit_unit ut', 'ut.unit_unitid=il.itli_unitid', "LEFT")
                    ->group_by('itli_itemlistid')
                    ->get()
                    ->result();
        //echo $this->db->last_query();die(); 

        $totalfilteredrecs=sizeof($resltrpt); 

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
            $order_by = 'unit_unitname';
       
        
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
            $this->db->where("itli_itemname like  '%".$get['sSearch_2']."%'  OR itli_itemnamenp like  '%".$get['sSearch_2']."%'  ");
        }

        if(!empty($get['sSearch_3'])){
            $this->db->where("unit_unitname like  '%".$get['sSearch_3']."%'  ");
        }
       

        if(!empty(($frmDate && $toDate)))
        {
            if(DEFAULT_DATEPICKER == 'NP'){
                $this->db->where('sama_billdatebs >=',$frmDate);
                $this->db->where('sama_billdatebs <=',$toDate);    
            }else{
                $this->db->where('sama_billdatead >=',$frmDate);
                $this->db->where('sama_billdatead <=',$toDate);
            }
        }

        if($cond) {
          $this->db->where($cond);
        }

        $store_id = !empty($get['store_id'])?$get['store_id']:$this->input->post('store_id');
        $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');
        $toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');
        $locationid = !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');

       

        if(!empty(($store_id)))
        {  
           $this->db->where('sm.sama_storeid',$store_id);
           
        }
        if($this->location_ismain  ==  'Y'){

         if(!empty($locationid)){
            $this->db->where('sm.sama_locationid',$locationid);
        }
        }else
        {
            $this->db->where('sm.sama_locationid',$this->locationid);
        }


        
        $this->db->select("il.itli_itemlistid,il.itli_itemcode,sm.sama_locationid, il.itli_itemname, il.itli_itemnamenp, ut.unit_unitname,SUM(sd.sade_curqty) qty, SUM(sd.sade_unitrate) rate, SUM(sd.sade_curqty*sd.sade_unitrate) as amount");
        $this->db->from('itli_itemslist il');
        $this->db->join('sade_saledetail sd', 'sd.sade_itemsid = il.itli_itemlistid', "LEFT");
        $this->db->join('sama_salemaster sm', 'sm.sama_salemasterid=sd.sade_salemasterid', "LEFT");
        $this->db->join('unit_unit ut', 'ut.unit_unitid=il.itli_unitid', "LEFT");
        $this->db->group_by("il.itli_itemlistid,il.itli_itemcode, il.itli_itemname,ut.unit_unitname");

        // if(!empty($order_by) && !empty($order)){
        //     $order_by = 'maty_material';
        //     $order = 'asc';
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

        //echo $this->db->last_query();die();
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


public function get_purchase_serach($cond=false)
    {  
        $frmDate=$this->input->get('frmDate');
        $toDate=$this->input->get('toDate');
      $get = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
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

        $store_id = !empty($get['store_id'])?$get['store_id']:$this->input->post('store_id');
        $toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');
        $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');
        $locationid =!empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');


        if(!empty(($store_id)))
        {  
            //print_r($store_id);die;
           $this->db->where('rm.recm_departmentid',$store_id);
           
        }

        if(!empty($locationid)){
            $this->db->where('recm_locationid',$locationid);
        }else{
            $this->db->where('recm_locationid',$this->locationid);
        }

        if(!empty(($frmDate && $toDate)))
        {
            if(DEFAULT_DATEPICKER == 'NP'){
                $this->db->where('recm_receiveddatebs >=',$frmDate);
                $this->db->where('recm_receiveddatebs <=',$toDate);    
            }else{
                $this->db->where('recm_receiveddatead >=',$frmDate);
                $this->db->where('recm_receiveddatead <=',$toDate);
            }
        }


        $resltrpt=$this->db->select("itli_itemlistid")
                    ->from('itli_itemslist il')
                    ->join('recd_receiveddetail rd', 'rd.recd_itemsid = il.itli_itemlistid', "LEFT")
                    ->join('recm_receivedmaster rm', 'rm.recm_receivedmasterid = rd.recd_receivedmasterid', "LEFT")
                    ->join('unit_unit ut', 'ut.unit_unitid=il.itli_unitid', "LEFT")
                    ->group_by('itli_itemlistid')
                    ->get()
                    ->result();
        // echo $this->db->last_query();die(); 
                    // print_r($resltrpt);
                    // die();


        $totalfilteredrecs=sizeof($resltrpt);

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
            $order_by = 'unit_unitname';
       
        
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
            $this->db->where("itli_itemname like  '%".$get['sSearch_2']."%' OR itli_itemnamenp like  '%".$get['sSearch_2']."%'  ");
        }

        if(!empty($get['sSearch_3'])){
            $this->db->where("unit_unitname like  '%".$get['sSearch_3']."%'  ");
        }
       

        if(!empty(($frmDate && $toDate)))
        {
            if(DEFAULT_DATEPICKER == 'NP'){
                $this->db->where('recm_receiveddatebs >=',$frmDate);
                $this->db->where('recm_receiveddatebs <=',$toDate);    
            }else{
                $this->db->where('recm_receiveddatead >=',$frmDate);
                $this->db->where('recm_receiveddatead <=',$toDate);
            }
        }

        if($cond) {
          $this->db->where($cond);
        }

        $store_id = !empty($get['store_id'])?$get['store_id']:$this->input->post('store_id');
        $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');
        $toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');
        $locationid = !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');

       

        if(!empty(($store_id)))
        {  
           $this->db->where('rm.recm_departmentid',$store_id);
           
        }

        if(!empty($locationid)){
            $this->db->where('rm.recm_locationid',$locationid);
        }else{
            $this->db->where('rm.recm_locationid',$this->locationid);
        }

        
        $this->db->select("il.itli_itemlistid,il.itli_itemcode,il.itli_locationid, il.itli_itemname, il.itli_itemnamenp,rm.recm_locationid, ut.unit_unitname,SUM(recd_purchasedqty) as rec_qty,SUM(recd_unitprice )as recrate ,SUM(recd_purchasedqty*recd_unitprice) as recamount");
        $this->db->from('itli_itemslist il');
        $this->db->join('recd_receiveddetail rd', 'rd.recd_itemsid = il.itli_itemlistid', "LEFT");
        $this->db->join('recm_receivedmaster rm', 'rm.recm_receivedmasterid = rd.recd_receivedmasterid', "LEFT");
        $this->db->join('unit_unit ut', 'ut.unit_unitid=il.itli_unitid', "LEFT");
        $this->db->group_by("il.itli_itemlistid,il.itli_itemcode, il.itli_itemname,ut.unit_unitname");

        // if(!empty($order_by) && !empty($order)){
        //     $order_by = 'maty_material';
        //     $order = 'asc';
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




public function get_transfer_serach($cond=false)
    {  
        $frmDate=$this->input->get('frmDate');
        $toDate=$this->input->get('toDate');
      $get = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("itli_itemcode like  '%".$get['sSearch_1']."%'  ");
        }
        if(!empty($get['sSearch_2'])){
            $this->db->where("itli_itemname like  '%".$get['sSearch_2']."%'  OR itli_itemnamenp like  '%".$get['sSearch_2']."%'  ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("unit_unitname like  '%".$get['sSearch_3']."%'  ");
        }
        
        
        if($cond) {
            $this->db->where($cond);
        }
        $get = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("itli_itemcode like  '%".$get['sSearch_1']."%'  ");
        }
        if(!empty($get['sSearch_2'])){
            $this->db->where("itli_itemname like  '%".$get['sSearch_2']."%'  OR itli_itemnamenp like  '%".$get['sSearch_2']."%' ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("unit_unitname like  '%".$get['sSearch_3']."%'  ");
        }
        
        
        if($cond) {
            $this->db->where($cond);
        }

        

        $store_id = !empty($get['store_id'])?$get['store_id']:$this->input->post('store_id');
        $toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');
        $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');
        $locationid = !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');




        

        if(!empty(($store_id)))
        {  
            //print_r($store_id);die;
           $this->db->where('tm.trma_fromdepartmentid',$store_id);
           
        }
         if($this->location_ismain=='Y'){
            if(!empty($locationid)){
                $this->db->where('tm.trma_locationid',$locationid);
            }

        }else{
             $this->db->where('tm.trma_locationid',$this->locationid);

        }

        if(!empty(($frmDate && $toDate)))
        {
            if(DEFAULT_DATEPICKER == 'NP'){
                $this->db->where('td.trde_transactiondatebs >=',$frmDate);
                $this->db->where('td.trde_transactiondatebs <=',$toDate);    
            }else{
                $this->db->where('td.trde_transactiondatead >=',$frmDate);
                $this->db->where('td.trde_transactiondatead <=',$toDate);
            }
        }


         $resltrpt=$this->db->select("COUNT(*) as cnt")
                    ->from('itli_itemslist il')
                    ->join('trde_transactiondetail td', 'td.trde_itemsid = il.itli_itemlistid', "LEFT")
                    ->join('trma_transactionmain tm', 'tm.trma_trmaid = td.trde_trmaid', "LEFT")
                    ->join('unit_unit ut', 'ut.unit_unitid=il.itli_unitid', "LEFT")
                    ->get()
                    ->row();
        //echo $this->db->last_query();die(); 


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
            $order_by = 'unit_unitname';
       
        
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
            $this->db->where("itli_itemname like  '%".$get['sSearch_2']."%'  OR itli_itemnamenp like  '%".$get['sSearch_2']."%' ");
        }

        if(!empty($get['sSearch_3'])){
            $this->db->where("unit_unitname like  '%".$get['sSearch_3']."%'  ");
        }
       

        if(!empty(($frmDate && $toDate)))
        {
            if(DEFAULT_DATEPICKER == 'NP'){
                $this->db->where('td.trde_transactiondatebs >=',$frmDate);
                $this->db->where('td.trde_transactiondatebs <=',$toDate);    
            }else{
                $this->db->where('td.trde_transactiondatead >=',$frmDate);
                $this->db->where('td.trde_transactiondatead <=',$toDate);
            }
        }

        if($cond) {
          $this->db->where($cond);
        }

        $store_id = !empty($get['store_id'])?$get['store_id']:$this->input->post('store_id');
        $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');
        $toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');
        $locationid = !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');

       

        if(!empty(($store_id)))
        {  
           $this->db->where('tm.trma_fromdepartmentid',$store_id);
           
        }

         if($this->location_ismain=='Y'){
            if(!empty($locationid)){
                $this->db->where('tm.trma_locationid',$locationid);
            }

        }else{
             $this->db->where('tm.trma_locationid',$this->locationid);

        }
      
      $get = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("itli_itemcode like  '%".$get['sSearch_1']."%'  ");
        }
        if(!empty($get['sSearch_2'])){
            $this->db->where("itli_itemname like  '%".$get['sSearch_2']."%'  OR itli_itemnamenp like  '%".$get['sSearch_2']."%' ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("unit_unitname like  '%".$get['sSearch_3']."%'  ");
        }
        
        
        if($cond) {
            $this->db->where($cond);
        }

        

        
         $this->db->select("il.itli_itemlistid,il.itli_itemcode, il.itli_itemname, il.itli_itemnamenp,il.itli_locationid, tm.trma_locationid, ut.unit_unitname,
            SUM(trde_requiredqty) as rec_qty,SUM(trde_unitprice )as recrate ,SUM(trde_requiredqty*trde_unitprice) as recamount");
        $this->db->from('itli_itemslist il');
        $this->db->join('trde_transactiondetail td', 'td.trde_itemsid = il.itli_itemlistid', "LEFT");
        $this->db->join('trma_transactionmain tm', 'tm.trma_trmaid = td.trde_trmaid', "LEFT");
        $this->db->join('unit_unit ut', 'ut.unit_unitid=il.itli_unitid', "LEFT");
        $this->db->where('td.trde_transactiontype','ISSUE');
        $this->db->group_by("il.itli_itemlistid,il.itli_itemcode,       il.itli_itemname,ut.unit_unitname");

        $this->db->order_by($order_by,$order);
      
        if($limit && $limit>0)
        {  
            $this->db->limit($limit);
        }
      
        if($offset)
        {
            $this->db->offset($offset);
        }
        if($cond) {
          $this->db->where($cond);
        }
      
        $nquery=$this->db->get();

        //echo $this->db->last_query();die();
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





public function get_issue_return_serach($cond=false)
    {  
        $frmDate=$this->input->get('frmDate');
        $toDate=$this->input->get('toDate');
      // $locationid=$this->input->get('locationid');
      $get = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("itli_itemcode like  '%".$get['sSearch_1']."%'  ");
        }
        if(!empty($get['sSearch_2'])){
            $this->db->where("itli_itemname like  '%".$get['sSearch_2']."%'  OR itli_itemnamenp like  '%".$get['sSearch_2']."%' ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("unit_unitname like  '%".$get['sSearch_3']."%'  ");
        }
        
        
        if($cond) {
            $this->db->where($cond);
        }

        

        $store_id = !empty($get['store_id'])?$get['store_id']:$this->input->post('store_id');
        $toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');
        $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');
        $locationid=!empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');




        

        if(!empty(($store_id)))
        {  
            //print_r($store_id);die;
           $this->db->where('rm.rema_depid',$store_id);
           
        }

         if($this->location_ismain=='Y'){
            if(!empty($locationid)){
                $this->db->where('rm.rema_locationid',$locationid);
            }else{
                 $this->db->where('rm.rema_locationid',$this->locationid);

            }

        }else{
             $this->db->where('rm.rema_locationid',$this->locationid);

        }

        if(!empty(($frmDate && $toDate)))
        {
            if(DEFAULT_DATEPICKER == 'NP'){
                $this->db->where('rema_returndatebs >=',$frmDate);
                $this->db->where('rema_returndatebs <=',$toDate);    
            }else{
                $this->db->where('rema_returndatead >=',$frmDate);
                $this->db->where('rema_returndatead <=',$toDate);
            }
        }


        $resltrpt=$this->db->select("COUNT(*) as cnt")
                    ->from('itli_itemslist il')
                    ->join('rede_returndetail rd', 'rd.rede_itemsid = il.itli_itemlistid', "LEFT")
                    ->join('rema_returnmaster rm', 'rd.rede_returnmasterid = rm.rema_returnmasterid', "LEFT")
                    ->join('unit_unit ut', 'ut.unit_unitid=il.itli_unitid', "LEFT")
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
            $order_by = 'unit_unitname';
       
        
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
            $this->db->where("itli_itemname like  '%".$get['sSearch_2']."%'  OR itli_itemnamenp like  '%".$get['sSearch_2']."%' ");
        }

        if(!empty($get['sSearch_3'])){
            $this->db->where("unit_unitname like  '%".$get['sSearch_3']."%'  ");
        }
       

        if(!empty(($frmDate && $toDate)))
        {
            if(DEFAULT_DATEPICKER == 'NP'){
                $this->db->where('rema_returndatebs >=',$frmDate);
                $this->db->where('rema_returndatebs <=',$toDate);    
            }else{
                $this->db->where('rema_returndatead >=',$frmDate);
                $this->db->where('rema_returndatead <=',$toDate);
            }
        }

        if($cond) {
          $this->db->where($cond);
        }
        

        $store_id = !empty($get['store_id'])?$get['store_id']:$this->input->post('store_id');
        $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');
        $toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');
        $locationid=!empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');

       

        if(!empty(($store_id)))
        {  
           $this->db->where('rm.rema_depid',$store_id);
           
        }

         if($this->location_ismain=='Y'){
            if(!empty($locationid)){
                $this->db->where('rm.rema_locationid',$locationid);
            }else{
                $this->db->where('rm.rema_locationid',$this->locationid);
            }

        }else{
             $this->db->where('rm.rema_locationid',$this->locationid);

        }

        
        $this->db->select("il.itli_itemlistid,il.itli_itemcode, il.itli_itemname, il.itli_itemnamenp, ut.unit_unitname,SUM(rede_qty) as rec_qty,SUM(rede_unitprice )as recrate ,SUM(rede_qty*rede_unitprice) as recamount");
        $this->db->from('itli_itemslist il');
        $this->db->join('rede_returndetail rd', 'rd.rede_itemsid = il.itli_itemlistid', "LEFT");
        $this->db->join('rema_returnmaster rm', 'rd.rede_returnmasterid = rm.rema_returnmasterid', "LEFT");
        $this->db->join('unit_unit ut', 'ut.unit_unitid=il.itli_unitid', "LEFT");
        $this->db->group_by("il.itli_itemlistid,il.itli_itemcode, il.itli_itemname,ut.unit_unitname");

        // if(!empty($order_by) && !empty($order)){
        //     $order_by = 'maty_material';
        //     $order = 'asc';
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

        //echo $this->db->last_query();die();
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



public function get_purchase_return_serach($cond=false)
    {  
        $frmDate=$this->input->get('frmDate');
        $toDate=$this->input->get('toDate');
      $get = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("itli_itemcode like  '%".$get['sSearch_1']."%'  ");
        }
        if(!empty($get['sSearch_2'])){
            $this->db->where("itli_itemname like  '%".$get['sSearch_2']."%'  OR itli_itemnamenp like  '%".$get['sSearch_2']."%' ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("unit_unitname like  '%".$get['sSearch_3']."%'  ");
        }
        
        
        if($cond) {
            $this->db->where($cond);
        }

        $store_id = !empty($get['store_id'])?$get['store_id']:$this->input->post('store_id');
        $toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');
        $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');




        

        if(!empty(($store_id)))
        {  
            //print_r($store_id);die;
           $this->db->where('pr.purr_departmentid',$store_id);
           
        }

        if(!empty(($frmDate && $toDate)))
        {
            if(DEFAULT_DATEPICKER == 'NP'){
                $this->db->where('pr.purr_returndatebs >=',$frmDate);
                $this->db->where('pr.purr_returndatebs <=',$toDate);    
            }else{
                $this->db->where('pr.purr_returndatead >=',$frmDate);
                $this->db->where('pr.purr_returndatead <=',$toDate);
            }
        }


        $resltrpt=$this->db->select("COUNT(*) as cnt")
                    ->from('itli_itemslist il')
                    ->join('prde_purchasereturndetail prd', 'prd.prde_itemsid = il.itli_itemlistid', "LEFT")
                    ->join('purr_purchasereturn pr', 'pr.purr_purchasereturnid = prd.prde_purchasereturnid', "LEFT")
                    ->join('unit_unit ut', 'ut.unit_unitid=il.itli_unitid', "LEFT")
                    ->get()
                    ->row();
        //echo $this->db->last_query();die(); 


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
            $order_by = 'unit_unitname';
       
        
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
            $this->db->where("itli_itemname like  '%".$get['sSearch_2']."%'  OR itli_itemnamenp like  '%".$get['sSearch_2']."%' ");
        }

        if(!empty($get['sSearch_3'])){
            $this->db->where("unit_unitname like  '%".$get['sSearch_3']."%'  ");
        }
       

        if(!empty(($frmDate && $toDate)))
        {
            if(DEFAULT_DATEPICKER == 'NP'){
                $this->db->where('pr.purr_returndatebs >=',$frmDate);
                $this->db->where('pr.purr_returndatebs <=',$toDate);    
            }else{
                $this->db->where('pr.purr_returndatead >=',$frmDate);
                $this->db->where('pr.purr_returndatead <=',$toDate);
            }
        }

        if($cond) {
          $this->db->where($cond);
        }

        $store_id = !empty($get['store_id'])?$get['store_id']:$this->input->post('store_id');
        $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');
        $toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');

       

        if(!empty(($store_id)))
        {  
           $this->db->where('pr.purr_departmentid',$store_id);
           
        }

        
        $this->db->select("il.itli_itemlistid,il.itli_itemcode, il.itli_itemname, il.itli_itemnamenp, ut.unit_unitname,
        SUM(prde_returnqty) as rec_qty,SUM(prde_purchaserate )as recrate ,SUM(prde_returnqty*prde_purchaserate) as recamount");
        $this->db->from('itli_itemslist il');
        $this->db->join('prde_purchasereturndetail prd', 'prd.prde_itemsid = il.itli_itemlistid', "LEFT");
        $this->db->join('purr_purchasereturn pr', 'pr.purr_purchasereturnid = prd.prde_purchasereturnid', "LEFT");
        $this->db->join('unit_unit ut', 'ut.unit_unitid=il.itli_unitid', "LEFT");
        $this->db->group_by("il.itli_itemlistid,il.itli_itemcode, il.itli_itemname,ut.unit_unitname");

        // if(!empty($order_by) && !empty($order)){
        //     $order_by = 'maty_material';
        //     $order = 'asc';
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
        //echo $this->db->last_query();die();
       return $ndata;
    }






public function get_stock_receive_search($cond=false)
    {  
        $frmDate=$this->input->get('frmDate');
        $toDate=$this->input->get('toDate');
        $locationid=$this->input->get('locationid');
      $get = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("itli_itemcode like  '%".$get['sSearch_1']."%'  ");
        }
        if(!empty($get['sSearch_2'])){
            $this->db->where("itli_itemname like  '%".$get['sSearch_2']."%'  OR itli_itemnamenp like  '%".$get['sSearch_2']."%' ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("unit_unitname like  '%".$get['sSearch_3']."%'  ");
        }
        
        
        if($cond) {
            $this->db->where($cond);
        }
        if($this->location_ismain=='Y'){
            if(!empty($locationid)){
                $this->db->where('il.itli_locationid',$locationid);
            }

        }else{
             $this->db->where('il.itli_locationid',$this->locationid);

        }

        $store_id = !empty($get['store_id'])?$get['store_id']:$this->input->post('store_id');
        $toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');
        $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');




        

        if(!empty(($store_id)))
        {  
            //print_r($store_id);die;
           $this->db->where('tm.trma_todepartmentid',$store_id);
           
        }

        if(!empty(($frmDate && $toDate)))
        {
            if(DEFAULT_DATEPICKER == 'NP'){
                $this->db->where('td.trde_transactiondatebs >=',$frmDate);
                $this->db->where('td.trde_transactiondatebs <=',$toDate);    
            }else{
                $this->db->where('td.trde_transactiondatead >=',$frmDate);
                $this->db->where('td.trde_transactiondatead <=',$toDate);
            }
        }


        $resltrpt=$this->db->select("COUNT(*) as cnt")
                    ->from('itli_itemslist il')
                    ->join('trde_transactiondetail td', 'td.trde_itemsid = il.itli_itemlistid', "LEFT")
                    ->join('trma_transactionmain tm', 'tm.trma_trmaid = td.trde_trmaid', "LEFT")
                    ->join('unit_unit ut', 'ut.unit_unitid=il.itli_unitid', "LEFT")
                    ->get()
                    ->row();
        //echo $this->db->last_query();die(); 


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
            $order_by = 'unit_unitname';
       
        
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
            $this->db->where("itli_itemname like  '%".$get['sSearch_2']."%'  OR itli_itemnamenp like  '%".$get['sSearch_2']."%' ");
        }

        if(!empty($get['sSearch_3'])){
            $this->db->where("unit_unitname like  '%".$get['sSearch_3']."%'  ");
        }
       

        if(!empty(($frmDate && $toDate)))
        {
            if(DEFAULT_DATEPICKER == 'NP'){
                $this->db->where('td.trde_transactiondatebs >=',$frmDate);
                $this->db->where('td.trde_transactiondatebs <=',$toDate);    
            }else{
                $this->db->where('td.trde_transactiondatead >=',$frmDate);
                $this->db->where('td.trde_transactiondatead <=',$toDate);
            }
        }
         $locationid=$this->input->get('locationid');
        if($cond) {
          $this->db->where($cond);
        }
           if($this->location_ismain == 'Y'){
            if(!empty($locationid)){
                $this->db->where('il.itli_locationid',$locationid);
            }

        }else{
             $this->db->where('il.itli_locationid',$this->locationid);

        }
        $store_id = !empty($get['store_id'])?$get['store_id']:$this->input->post('store_id');
        $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');
        $toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');

        

        if(!empty(($store_id)))
        {  
           $this->db->where('tm.trma_todepartmentid',$store_id);
           
        }

        
        $this->db->select("il.itli_itemlistid,il.itli_locationid,il.itli_itemcode, il.itli_itemname, il.itli_itemnamenp, ut.unit_unitname,
SUM(trde_requiredqty) as rec_qty,SUM(trde_unitprice )as recrate ,SUM(trde_requiredqty*trde_unitprice) as recamount");
        $this->db->from('itli_itemslist il');
        $this->db->join('trde_transactiondetail td', 'td.trde_itemsid = il.itli_itemlistid', "LEFT");
        $this->db->join('trma_transactionmain tm', 'tm.trma_trmaid = td.trde_trmaid', "LEFT");
        $this->db->join('unit_unit ut', 'ut.unit_unitid=il.itli_unitid', "LEFT");
        $this->db->where('td.trde_transactiontype','ISSUE');
        $this->db->group_by("il.itli_itemlistid,il.itli_itemcode, il.itli_itemname,ut.unit_unitname");

        // if(!empty($order_by) && !empty($order)){
        //     $order_by = 'maty_material';
        //     $order = 'asc';
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

        //echo $this->db->last_query();die();
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








}