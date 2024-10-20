<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Order_check_mdl extends CI_Model 
{
  public function __construct()
    {
        parent::__construct(); 
        $this->locationid=$this->session->userdata(LOCATION_ID);
        $this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
        $this->orgid=$this->session->userdata(ORG_ID);
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
           $locationid= !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');
         if($this->location_ismain=='Y'){
       if(!empty($locationid))
        {
            $this->db->where('pom.puor_locationid',$locationid);
        }
        }else{
            $this->db->where('pom.puor_locationid',$this->locationid);

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
          $locationid= !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');
         if($this->location_ismain=='Y'){
       if(!empty($locationid))
        {
            $this->db->where('pom.puor_locationid',$locationid);
        }
        }else{
            $this->db->where('pom.puor_locationid',$this->locationid);

        }

        $this->db->select('pom.puor_purchaseordermasterid,pom.puor_orderno,pom.puor_orderdatebs,pom.puor_orderdatead,d.dist_distributor,
pom.puor_deliverysite,pom.puor_requno,pom.puor_deliverydatead,pom.puor_deliverydatebs,pom.puor_status,pom.puor_locationid');
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
         $this->db->select('pod.pude_quantity,pod.pude_rate,pod.pude_amount,pod.pude_remqty,pod.pude_unit, il.itli_itemcode,il.itli_itemname,il.itli_itemnamenp');
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
    
}