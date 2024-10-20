<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Mrn_book_mdl extends CI_Model 
{
     public function __construct()
    {
        parent::__construct(); 
        $this->locationid=$this->session->userdata(LOCATION_ID);
        $this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
        $this->orgid=$this->session->userdata(ORG_ID);
    }
   

    public function get_purchase_mrn_list($cond = false)
    {
        $frmDate=$this->input->get('frmDate');
        $toDate=$this->input->get('toDate');


        $get = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }
       

        if(!empty($get['sSearch_1'])){
            $this->db->where("recm_invoiceno like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("recm_receiveddatebs like  '%".$get['sSearch_2']."%'  ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("recm_purchaseorderno like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("recm_supplierbillno like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("recm_supbilldatebs like  '%".$get['sSearch_5']."%'  ");
        } 
        if(!empty($get['sSearch_6'])){
            $this->db->where("dist_distributor like  '%".$get['sSearch_6']."%'  ");
        }
          if(!empty($get['sSearch_7'])){
            $this->db->where("recm_amount like  '%".$get['sSearch_7']."%'  ");
        }
        if(!empty($get['sSearch_8'])){
            $this->db->where("recm_discount like  '%".$get['sSearch_8']."%'  ");
        }
         if(!empty($get['sSearch_9'])){
            $this->db->where("recm_taxamount like  '%".$get['sSearch_9']."%'  ");
        }
        if(!empty($get['sSearch_10'])){
            $this->db->where("recm_clearanceamount like  '%".$get['sSearch_10']."%'  ");
        }
        if(!empty($get['sSearch_11'])){
            $this->db->where("usma_username like  '%".$get['sSearch_11']."%'  ");
        }
        if(!empty($frmDate) && !empty($toDate))
        {
            $this->db->where(array('recm_receiveddatebs >='=>$frmDate,'recm_receiveddatebs <='=>$toDate));
        }
     $locationid= !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');

      // if(!empty($locationid))
      //       {
      //           $this->db->where('recm_locationid',$locationid);
      //       }

         if($this->location_ismain=='Y'){
       if(!empty($locationid))
        {
            $this->db->where('recm_locationid',$locationid);
        }
        }else{
            $this->db->where('recm_locationid',$this->locationid);

        }

        $resltrpt=$this->db->select("COUNT(*) as cnt")
                            ->from('recm_receivedmaster rm')
                            ->join('dist_distributors d','d.dist_distributorid=rm.recm_supplierid','LEFT')
                            ->join('usma_usermain u','u.usma_userid=rm.recm_enteredby','LEFT')
                            ->where(array('rm.recm_status'=>'O'))
                           ->get()
                            ->row(); 
        
        $totalfilteredrecs=$resltrpt->cnt; 

        $order_by = 'recm_invoiceno';
        $order = 'desc';
        if($this->input->get('sSortDir_0'))
        {
                $order = $this->input->get('sSortDir_0');
        }

        $where='';
   if($this->input->get('iSortCol_0')==0)
            $order_by = 'recm_invoiceno';
        else if($this->input->get('iSortCol_0')==1)
            $order_by = 'recm_invoiceno';
        else if($this->input->get('iSortCol_0')==2)
            $order_by = 'recm_receiveddatebs';
        else if($this->input->get('iSortCol_0')==3)
            $order_by = 'recm_purchaseorderno';
        else if($this->input->get('iSortCol_0')==4)
            $order_by = 'recm_supplierbillno';
        else if($this->input->get('iSortCol_0')==5)
            $order_by = 'recm_supbilldatebs';
         else if($this->input->get('iSortCol_0')==6)
            $order_by = 'dist_distributor';
         else if($this->input->get('iSortCol_0')==7)
            $order_by = 'recm_amount';
         else if($this->input->get('iSortCol_0')==8)
            $order_by = 'recm_discount';
         else if($this->input->get('iSortCol_0')==9)
            $order_by = 'recm_taxamount';
         else if($this->input->get('iSortCol_0')==10)
            $order_by = 'recm_clearanceamount';
          else if($this->input->get('iSortCol_0')==11)
            $order_by = 'usma_username';
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
            $this->db->where("recm_invoiceno like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("recm_receiveddatebs like  '%".$get['sSearch_2']."%'  ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("recm_purchaseorderno like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("recm_supplierbillno like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("recm_supbilldatebs like  '%".$get['sSearch_5']."%'  ");
        } 
        if(!empty($get['sSearch_6'])){
            $this->db->where("dist_distributor like  '%".$get['sSearch_6']."%'  ");
        }
          if(!empty($get['sSearch_7'])){
            $this->db->where("recm_amount like  '%".$get['sSearch_7']."%'  ");
        }
        if(!empty($get['sSearch_8'])){
            $this->db->where("recm_discount like  '%".$get['sSearch_8']."%'  ");
        }
         if(!empty($get['sSearch_9'])){
            $this->db->where("recm_taxamount like  '%".$get['sSearch_9']."%'  ");
        }
        if(!empty($get['sSearch_10'])){
            $this->db->where("recm_clearanceamount like  '%".$get['sSearch_10']."%'  ");
        }
        if(!empty($get['sSearch_11'])){
            $this->db->where("usma_username like  '%".$get['sSearch_11']."%'  ");
        }

        if($frmDate &&  $toDate)
        {
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
            $this->db->where('recm_locationid',$locationid);
        }
        }else{
            $this->db->where('recm_locationid',$this->locationid);

        }
        $this->db->select('recm_invoiceno,recm_receiveddatebs,recm_receiveddatead,recm_supbilldatead, recm_supbilldatebs as recm_supbilldatebs,recm_supplierbillno, d.dist_distributor,rm.recm_amount,rm.recm_discount,rm.recm_taxamount,rm.recm_clearanceamount,rm.recm_purchaseorderno,u.usma_username,rm.recm_enteredby');
        $this->db->from('recm_receivedmaster rm');
        $this->db->join('dist_distributors d','d.dist_distributorid=rm.recm_supplierid','LEFT');
        $this->db->join('usma_usermain u','u.usma_userid=rm.recm_enteredby','LEFT');
        $this->db->where(array('rm.recm_status'=>'O'));

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

    public function get_purchase_mrn_supplierwise_list($cond = false)
    {
        $frmDate=$this->input->get('frmDate');
        $toDate=$this->input->get('toDate');

        $get = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }
       

        if(!empty($get['sSearch_1'])){
            $this->db->where("dist_distributor like  '%".$get['sSearch_1']."%'  ");
        }


        if($frmDate &&  $toDate)
        {
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
            $this->db->where('recm_locationid',$locationid);
        }
        }else{
            $this->db->where('recm_locationid',$this->locationid);

        }

         $this->db->select('rm.recm_invoiceno,rm.recm_receiveddatebs,rm.recm_receiveddatead,rm.recm_supbilldatead, rm.recm_supbilldatebs as recm_supbilldatebs,
recm_supplierbillno, d.dist_distributor,rm.recm_amount,rm.recm_discount,rm.recm_taxamount,rm.recm_clearanceamount,rm.recm_purchaseorderno,
rm.recm_enteredby');
        $this->db->from('recm_receivedmaster rm');
        $this->db->join('dist_distributors d','d.dist_distributorid=rm.recm_supplierid','LEFT');
       $this->db->where(array('rm.recm_status'=>'O'));

       $this->db->get();
       $nqry=$this->db->last_query();

    $nquery2=$this->db->query("SELECT COUNT('*') as cnt FROM (SELECT dist_distributor,SUM(recm_amount) as amount,SUM(recm_discount) as discount, SUM(recm_taxamount) as vat ,suM(recm_clearanceamount) as netamount FROM( $nqry) X GROUP BY dist_distributor ) Y");


        //echo $this->last_query();die(); 
        $totalfilteredrecs=$nquery2->row()->cnt; 

        $order_by = 'recm_invoiceno';
        $order = 'desc';
        if($this->input->get('sSortDir_0'))
        {
                $order = $this->input->get('sSortDir_0');
        }

        $where='';
        if($this->input->get('iSortCol_0')==0)
            $order_by = 'recm_invoiceno';
        else if($this->input->get('iSortCol_0')==1)
            $order_by = 'dist_distributor';
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
            $this->db->where("dist_distributor like  '%".$get['sSearch_1']."%'  ");
        }
          $locationid= !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');

              if($this->location_ismain=='Y'){
       if(!empty($locationid))
        {
            $this->db->where('recm_locationid',$locationid);
        }
        }else{
            $this->db->where('recm_locationid',$this->locationid);

        }

         
        if($frmDate &&  $toDate)
        {
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
     
        $this->db->select('rm.recm_invoiceno,rm.recm_receiveddatebs,rm.recm_receiveddatead,rm.recm_supbilldatead, rm.recm_supbilldatebs as recm_supbilldatebs,
recm_supplierbillno, d.dist_distributor,rm.recm_amount,rm.recm_discount,rm.recm_taxamount,rm.recm_clearanceamount,rm.recm_purchaseorderno,
rm.recm_enteredby');
        $this->db->from('recm_receivedmaster rm');
        $this->db->join('dist_distributors d','d.dist_distributorid=rm.recm_supplierid','LEFT');
       $this->db->where(array('rm.recm_status'=>'O'));

       $this->db->get();
       $nqry=$this->db->last_query();

    $nquery2=$this->db->query("SELECT dist_distributor,SUM(recm_amount) as amount,SUM(recm_discount) as discount, SUM(recm_taxamount) as vat ,suM(recm_clearanceamount) as netamount FROM( $nqry) X GROUP BY dist_distributor LIMIT $limit OFFSET $offset ");
    $nmrow=$nquery2->num_rows();
        if(!empty($_GET['iDisplayLength'])) {
          $totalrecs = $nmrow;
        }
       if($nmrow>0){
          $ndata=$nquery2->result();
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

    public function getSupplierwise_purchase_mrn()
    {
          $this->db->select('rm.recm_invoiceno,rm.recm_receiveddatebs,rm.recm_receiveddatead,rm.recm_supbilldatead, rm.recm_supbilldatebs as recm_supbilldatebs,
recm_supplierbillno, d.dist_distributor,rm.recm_amount,rm.recm_discount,rm.recm_taxamount,rm.recm_clearanceamount,rm.recm_purchaseorderno,
rm.recm_enteredby');
        $this->db->from('recm_receivedmaster rm');
        $this->db->join('dist_distributors d','d.dist_distributorid=rm.recm_supplierid','LEFT');
       $this->db->where(array('rm.recm_status'=>'O'));

       $this->db->get();
       $nqry=$this->db->last_query();

    $nquery2=$this->db->query("SELECT dist_distributor,SUM(recm_amount) as amount,SUM(recm_discount) as discount, SUM(recm_taxamount) as vat ,suM(recm_clearanceamount) as netamount FROM( $nqry) X GROUP BY dist_distributor");

     $num_row=$nquery2->num_rows();
 if($num_row>0){
          $ndata=$nquery2->result();
          return $ndata;
      } 

      return false;



    }

    
}