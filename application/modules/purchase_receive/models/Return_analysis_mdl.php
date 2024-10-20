<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Return_analysis_mdl extends CI_Model 
{
    public function __construct() 
    {
        parent::__construct();
        $this->locationid=$this->session->userdata(LOCATION_ID);
        $this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
       
    }
   

    public function get_order_check_list($cond = false)
    {
        $get = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }
         if(!empty($get['sSearch_0'])){
            $this->db->where("puor_purchaseordermasterid like  '%".$get['sSearch_0']."%'  ");
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("dist_distributor like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("puor_orderdatebs like  '%".$get['sSearch_2']."%'  ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("puor_orderno like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("puor_deliverysite like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("puor_deliverydatebs like  '%".$get['sSearch_5']."%'  ");
        } 
        if(!empty($get['sSearch_6'])){
            $this->db->where("puor_requno like  '%".$get['sSearch_6']."%'  ");
        }
          if($cond) {
          $this->db->where($cond);
        }

        $resltrpt=$this->db->select("COUNT(*) as cnt")
                           ->from('puor_purchaseordermaster pom')
                           ->join('dist_distributors d','d.dist_distributorid=pom.puor_supplierid','LEFT')
                           ->where(array('pom.puor_purchased <>'=>2,'pom.puor_status <>'=>'C'))
                           ->get()
                            ->row(); 
        //echo $this->db->last_query();die(); 
        $totalfilteredrecs=$resltrpt->cnt; 

        $order_by = 'puor_orderno';
        $order = 'desc';
        if($this->input->get('sSortDir_0'))
        {
                $order = $this->input->get('sSortDir_0');
        }

        $where='';
        if($this->input->get('iSortCol_0')==0)
            $order_by = 'puor_orderno';
        else if($this->input->get('iSortCol_0')==1)
            $order_by = 'dist_distributor';
        else if($this->input->get('iSortCol_0')==2)
            $order_by = 'puor_orderdatebs';
        else if($this->input->get('iSortCol_0')==3)
            $order_by = 'puor_orderno';
        else if($this->input->get('iSortCol_0')==4)
            $order_by = 'puor_deliverysite';
        else if($this->input->get('iSortCol_0')==5)
            $order_by = 'puor_deliverydatebs';
         else if($this->input->get('iSortCol_0')==6)
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
            $this->db->where("puor_purchaseordermasterid like  '%".$get['sSearch_0']."%'  ");
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("dist_distributor like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("puor_orderdatebs like  '%".$get['sSearch_2']."%'  ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("puor_orderno like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("puor_deliverysite like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("puor_deliverydatebs like  '%".$get['sSearch_5']."%'  ");
        } 
        if(!empty($get['sSearch_6'])){
            $this->db->where("puor_requno like  '%".$get['sSearch_6']."%'  ");
        }
       //  if($this->session->userdata(USER_ACCESS_TYPE)=='S')
        // {
       //   $this->db->where('dist_orgid',$this->session->userdata(ORG_ID));
        // }
        if($cond) {
          $this->db->where($cond);
        }

        $this->db->select('pom.puor_purchaseordermasterid,pom.puor_orderno,pom.puor_orderdatebs,pom.puor_orderdatead,d.dist_distributor,
pom.puor_deliverysite,pom.puor_requno,pom.puor_deliverydatead,pom.puor_deliverydatebs,pom.puor_status');
        $this->db->from('puor_purchaseordermaster pom');
        $this->db->join('dist_distributors d','d.dist_distributorid=pom.puor_supplierid','LEFT');
       $this->db->where(array('pom.puor_purchased <>'=>2,'pom.puor_status <>'=>'C'));

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

    public function get_indivi_order_check_list($masterid)
    {
         $this->db->select('pod.pude_quantity,pod.pude_rate,pod.pude_amount,pod.pude_remqty,pod.pude_unit, il.itli_itemcode,il.itli_itemname');
        $this->db->from('pude_purchaseorderdetail pod');
        $this->db->join('itli_itemslist il','il.itli_itemlistid=pod.pude_itemsid','LEFT');
       $this->db->where(array('pod.pude_status <>'=>'C'));
       $this->db->where(array('pod.pude_purchasemasterid'=>$masterid));

        $this->db->order_by('itli_itemname',"ASC");
      
        // if($limit && $limit>0)
        // {  
        //     $this->db->limit($limit);
        // }
        // if($offset)
        // {
        //     $this->db->offset($offset);
        // }
      
       $nquery=$this->db->get();
       $num_row=$nquery->num_rows();
       if($num_row>0)
       {
        return $nquery->result();
       }
       return false;

    }
    public function get_direct_received_return_details_list($cond = false)
    {
        $get = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("recm_receiveddatebs like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("dist_distributor like  '%".$get['sSearch_2']."%'  ");
        }

        if(!empty($get['sSearch_3'])){
            $this->db->where("itli_itemcode like  '%".$get['sSearch_3']."%'  ");
        }
        // if(!empty($get['sSearch_4'])){
        //     $this->db->where("recm_purchaseorderno like  '%".$get['sSearch_4']."%'  ");
        // }
        if(!empty($get['sSearch_4'])){
            // $this->db->where("itli_itemname like  '%".$get['sSearch_4']."%'  ");
            $this->db->where("itli_itemname like  '%".$get['sSearch_4']."%' OR itli_itemnamenp like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("rd.recd_purchasedqty like  '%".$get['sSearch_5']."%'  ");
        }

        if(!empty($get['sSearch_6'])){
            $this->db->where("recd_unitprice like  '%".$get['sSearch_6']."%'  ");
        }
        if(!empty($get['sSearch_7'])){
            $this->db->where("recm_discount like  '%".$get['sSearch_7']."%'  ");
        }
        if(!empty($get['sSearch_8'])){
            $this->db->where("recm_taxamount like  '%".$get['sSearch_8']."%'  ");
        }
        if(!empty($get['sSearch_9'])){
            $this->db->where("recm_amount like  '%".$get['sSearch_9']."%'  ");
        }
       
        if($cond) {
            $this->db->where($cond);
        }

        $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');
        $toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');
        //echo"<pre>";print_r($this->input->get());die;
        $fyear = !empty($get['fyear'])?$get['fyear']:$this->input->post('fyear');
         $locationid = !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');
        $store_id = !empty($get['store_id'])?$get['store_id']:$this->input->post('store_id');
        

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
        
        if(!empty($locationid)){
            $this->db->where('rm.recm_locationid',$locationid);
        }
        //   if($this->location_ismain=='Y')
        //   {
        //     if($input_locationid)
        //     {
        //         $this->db->where('rm.recm_locationid',$locationid);
        //      }

        // }
        // else
        // {
        //      $this->db->where('rm.recm_locationid',$this->locationid);
        // }
      



        $resltrpt=$this->db->select("COUNT(*) as cnt")
                    ->from('recd_receiveddetail rd')
                    ->join('recm_receivedmaster rm','rm.recm_receivedmasterid = rd.recd_receivedmasterid','left')
                    ->join('dist_distributors s','s.dist_distributorid = rm.recm_supplierid','left')
                    ->join('itli_itemslist il','il.itli_itemlistid=rd.recd_itemsid','LEFT')
                    ->where('rm.recm_dstat','D')
                    ->get()
                    ->row();

        // echo $this->db->last_query();die(); 
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
            $order_by = 'dist_distributor';
        else if($this->input->get('iSortCol_0')==3)
            $order_by = 'itli_itemcode';
            // else if($this->input->get('iSortCol_0')==4)
            //      $order_by = 'recm_purchaseorderno';
        else if($this->input->get('iSortCol_0')==4)
            $order_by = 'itli_itemname';
        else if($this->input->get('iSortCol_0')==5)
            $order_by = 'rd.recd_purchasedqty';
        else if($this->input->get('iSortCol_0')==6)
            $order_by = 'recd_unitprice';
        else if($this->input->get('iSortCol_0')==7)
            $order_by = 'recm_discount';
        else if($this->input->get('iSortCol_0')==8)
            $order_by = 'recm_taxamount';
        else if($this->input->get('iSortCol_0')==9)
            $order_by = 'recm_amount';
      
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
            $this->db->where("recm_receiveddatebs like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("dist_distributor like  '%".$get['sSearch_2']."%'  ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("itli_itemcode like  '%".$get['sSearch_3']."%'  ");
        }
        // if(!empty($get['sSearch_4'])){
        //     $this->db->where("recm_purchaseorderno like  '%".$get['sSearch_4']."%'  ");
        // }
        if(!empty($get['sSearch_4'])){
           $this->db->where("itli_itemname like  '%".$get['sSearch_4']."%' OR itli_itemnamenp like  '%".$get['sSearch_4']."%'  ");

        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("budg_budgetname like  '%".$get['sSearch_5']."%'  ");
        }

        if(!empty($get['sSearch_6'])){
            $this->db->where("recd_unitprice like  '%".$get['sSearch_6']."%'  ");
        }
        if(!empty($get['sSearch_7'])){
            $this->db->where("recm_discount like  '%".$get['sSearch_7']."%'  ");
        }
        if(!empty($get['sSearch_8'])){
            $this->db->where("recm_taxamount like  '%".$get['sSearch_8']."%'  ");
        }
        if(!empty($get['sSearch_9'])){
            $this->db->where("recm_amount like  '%".$get['sSearch_9']."%'  ");
        }
       
       
        if($cond) {
          $this->db->where($cond);
        }

        $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');
        $toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');
        $locationid = !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');

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
        if(!empty($locationid)){
            $this->db->where('rm.recm_locationid',$locationid);
        }
      
        $this->db->select('rm.recm_receivedmasterid,rm.recm_locationid,rm.recm_receiveddatebs,rm.recm_purchasestatus,rm.recm_invoiceno,rm.recm_purchaseorderno as orderno,rm.recm_amount,s.dist_distributor,rm.recm_discount,rm.recm_taxamount,rm.recm_clearanceamount,rm.recm_posttime,rm.recm_status,il.itli_itemcode,il.itli_itemname,il.itli_itemnamenp,il.itli_itemlistid,rd.recd_purchasedqty,rd.recd_unitprice,rd.recd_description,il.itli_locationid');
        $this->db->from('recd_receiveddetail rd');
        $this->db->join('recm_receivedmaster rm','rm.recm_receivedmasterid = rd.recd_receivedmasterid','LEFT');
        $this->db->join('dist_distributors s','s.dist_distributorid = rm.recm_supplierid','LEFT');
        $this->db->join('itli_itemslist il','il.itli_itemlistid=rd.recd_itemsid','LEFT');
        $this->db->where('rm.recm_dstat','D');
        if($fyear)
        {
            $this->db->where('rm.recm_fyear',$fyear);
        }
        if($store_id)
        {
            $this->db->where('recm_storeid',$store_id);
        }
        //    if($this->location_ismain=='Y')
        //   {
        //     if($input_locationid)
        //     {
        //         $this->db->where('rm.recm_locationid',$locationid);
        //      }

        // }
        // else
        // {
        //      $this->db->where('rm.recm_locationid',$this->locationid);
        // }
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
      
       return $ndata;
    }

    public function get_purchase_return_details_list($cond = false)
    {
        $get = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }

        if(DEFAULT_DATEPICKER == 'NP'){
            if(!empty($get['sSearch_1'])){
                $this->db->where("purr_returndatebs like  '%".$get['sSearch_1']."%'  ");
            }
        }else{
            if(!empty($get['sSearch_1'])){
                $this->db->where("purr_returndatead like  '%".$get['sSearch_1']."%'  ");
            }
        }
        
        if(!empty($get['sSearch_2'])){
            $this->db->where("dist_distributor like  '%".$get['sSearch_2']."%'  ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("itli_itemcode like  '%".$get['sSearch_3']."%'  ");
        }
 
        if(!empty($get['sSearch_4'])){
            $this->db->where("itli_itemname like  '%".$get['sSearch_4']."%' OR itli_itemnamenp like  '%".$get['sSearch_4']."%'  ");
        }
       
        if($cond) {
            $this->db->where($cond);
        }

        $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');
        $toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');
        //echo"<pre>";print_r($this->input->get());die;
        $fyear = !empty($get['fyear'])?$get['fyear']:$this->input->post('fyear');
         $locationid = !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');
        $store_id = !empty($get['store_id'])?$get['store_id']:$this->input->post('store_id');
        

        if($frmDate &&  $toDate){
            if(DEFAULT_DATEPICKER=='NP')
            {
              $this->db->where('purr_returndatebs >=', $frmDate);
              $this->db->where('purr_returndatebs <=', $toDate);
            }
            else
            {
              $this->db->where('purr_returndatead >=', $frmDate);
              $this->db->where('purr_returndatead <=', $toDate);
            }
        }

        if($fyear)
        {
           $this->db->where('purr_fyear',$fyear);
        }
        
        if(!empty($locationid)){
            $this->db->where('purr_locationid',$locationid);
        }
        
        $resltrpt=$this->db->select("COUNT(*) as cnt")
                    ->from('purr_purchasereturn pr')
                    ->join('prde_purchasereturndetail pd','pd.prde_purchasereturnid = pr.purr_purchasereturnid','LEFT')
                    ->join('dist_distributors s','s.dist_distributorid = pr.purr_supplierid','LEFT')
                    ->join('itli_itemslist il','il.itli_itemlistid = pd.prde_itemsid','LEFT')
                    ->get()
                    ->row();

        //echo $this->db->last_query();die(); 
        $totalfilteredrecs=$resltrpt->cnt; 

        $order_by = 'pr.purr_returndatebs';
        $order = 'DESC';
        if($this->input->get('sSortDir_0'))
        {
                $order = $this->input->get('sSortDir_0');
        }
  
        $where='';
        if($this->input->get('iSortCol_0')==1)
            $order_by = 'purr_returndatebs';
        else if($this->input->get('iSortCol_0')==2)
            $order_by = 'dist_distributor';
        else if($this->input->get('iSortCol_0')==3)
            $order_by = 'itli_itemcode';
        else if($this->input->get('iSortCol_0')==4)
            $order_by = 'itli_itemname';
        else if($this->input->get('iSortCol_0')==5)
            $order_by = 'pd.prde_returnqty';
        else if($this->input->get('iSortCol_0')==6)
            $order_by = 'pd.prde_purchaserate';
        else if($this->input->get('iSortCol_0')==7)
            $order_by = 'pd.purr_discount';
        else if($this->input->get('iSortCol_0')==8)
            $order_by = 'pd.purr_vatamount';
        else if($this->input->get('iSortCol_0')==9)
            $order_by = 'pd.purr_returnamount';
      
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

        if(DEFAULT_DATEPICKER == 'NP'){
            if(!empty($get['sSearch_1'])){
                $this->db->where("purr_returndatebs like  '%".$get['sSearch_1']."%'  ");
            }
        }else{
            if(!empty($get['sSearch_1'])){
                $this->db->where("purr_returndatead like  '%".$get['sSearch_1']."%'  ");
            }
        }
        
        if(!empty($get['sSearch_2'])){
            $this->db->where("dist_distributor like  '%".$get['sSearch_2']."%'  ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("itli_itemcode like  '%".$get['sSearch_3']."%'  ");
        }
 
        if(!empty($get['sSearch_4'])){
            $this->db->where("itli_itemname like  '%".$get['sSearch_4']."%' OR itli_itemnamenp like  '%".$get['sSearch_4']."%'  ");
        }
       
        if($cond) {
          $this->db->where($cond);
        }

        $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');
        $toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');
        $locationid = !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');

        if($frmDate &&  $toDate){
            if(DEFAULT_DATEPICKER=='NP')
            {
              $this->db->where('purr_returndatebs >=', $frmDate);
              $this->db->where('purr_returndatebs <=', $toDate);
            }
            else
            {
              $this->db->where('purr_returndatead >=', $frmDate);
              $this->db->where('purr_returndatead <=', $toDate);
            }
        }
        if(!empty($locationid)){
            $this->db->where('purr_locationid',$locationid);
        }
        $this->db->select('pr.purr_purchasereturnid, pr.purr_returndatebs, pr.purr_returndatead, pr.purr_invoiceno, pr.purr_receiptno,pr.purr_returnno, pr.purr_returnamount,pr.purr_supplierid,pr.purr_discount,pr.purr_vatamount, pr.purr_posttime, pr.purr_st, il.itli_itemcode, il.itli_itemname,il.itli_itemnamenp, il.itli_itemlistid, pd.prde_receivedqty, pd.prde_returnqty, pd.prde_purchaserate, pd.prde_salerate, pd.prde_remarks, s.dist_distributor');
        $this->db->from('purr_purchasereturn pr');
        $this->db->join('prde_purchasereturndetail pd','pd.prde_purchasereturnid = pr.purr_purchasereturnid','left');
        $this->db->join('dist_distributors s','s.dist_distributorid = pr.purr_supplierid','left');
        $this->db->join('itli_itemslist il','il.itli_itemlistid = pd.prde_itemsid','LEFT');
        if($fyear)
        {
            $this->db->where('pr.purr_fyear',$fyear);
        }
        if($store_id)
        {
            $this->db->where('pr.purr_storeid',$store_id);
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
       //echo $this->db->last_query();die();
       return $ndata;
    }
    
    public function getStatusCountReturn($srchcol = false)
    {
        try{ 
            $this->db->select('COUNT(prde_purchasereturndetailid) as total, purr_returndatebs');
            $this->db->from('prde_purchasereturndetail pd');
            $this->db->join('purr_purchasereturn pr','pr.purr_purchasereturnid = pd.prde_purchasereturnid');

            if($srchcol){
                $this->db->where($srchcol);
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
    public function getStatusCount($srchcol = false){
        try{
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
            $this->db->from('recm_receivedmaster'); 

            if($srchcol){
                $this->db->where($srchcol);
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

    public function getStatusCountDetail($srchcol = false){
        try{
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
            $this->db->from('recd_receiveddetail rd');
            $this->db->join('recm_receivedmaster rm', 'rm.recm_receivedmasterid = rd.recd_receivedmasterid');
            $this->db->where('rm.recm_dstat','D');
            if($srchcol){
                $this->db->where($srchcol);
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
}