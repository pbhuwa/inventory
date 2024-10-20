<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Purchase_order_details_mdl extends CI_Model 
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
         $this->locationid=$this->session->userdata(LOCATION_ID);
        $this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
    }
    public $validate_settings_distributors = array(               
        array('field' => 'dist_distributor', 'label' => 'Distributor Name', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'dist_phone1', 'label' => 'Phone 1', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'dist_email', 'label' => 'Email', 'rules' => 'trim|valid_email|xss_clean'),
        array('field' => 'dist_repemail', 'label' => 'Sales Resp. Email', 'rules' => 'trim|valid_email|xss_clean')
    );

    public function get_purchase_order_details_list($cond = false)
    {

        $get = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }

        $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');
        $toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');

        $supplier = !empty($get['supplier'])?$get['supplier']:$this->input->post('supplier');

        $locationid= !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');
        
        $items = !empty($get['items'])?$get['items']:$this->input->post('items');
        $mattypeid=!empty($get['mattypeid'])?$get['mattypeid']:'';

        if(!empty(($frmDate && $toDate)))
        {
            $this->db->where('puor_orderdatebs >=',$frmDate);
            $this->db->where('puor_orderdatebs <=',$toDate);
        }

        if(!empty($supplier)){
            $this->db->where('pm.puor_supplierid',$supplier);
        }

        
         if($this->location_ismain=='Y'){
        if(!empty($locationid))
        {
              $this->db->where('pm.puor_locationid',$locationid);
        }
        }else{
            $this->db->where('pm.puor_locationid',$this->locationid);

        }
        if(!empty($mattypeid)){
            $this->db->where('maty_materialtypeid',$mattypeid);
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("puor_orderdatebs like  '%".$get['sSearch_1']."%'  ");
        }
        if(!empty($get['sSearch_2'])){
            $this->db->where("itli_itemcode like  '%".$get['sSearch_2']."%'  ");
        }
        if(!empty($get['sSearch_3'])){
            // $this->db->where("itli_itemname like  '%".$get['sSearch_3']."%'  ");
              $this->db->where("itli_itemname like  '%".$get['sSearch_3']."%' OR itli_itemnamenp like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("maty_material like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("eqca_category like  '%".$get['sSearch_5']."%'  ");
        }
        if(!empty($get['sSearch_6'])){
            $this->db->where("dist_distributor like  '%".$get['sSearch_6']."%'  ");
        }
        if(!empty($get['sSearch_7'])){
            $this->db->where("puor_orderno like  '%".$get['sSearch_7']."%'  ");
        }
        if(!empty($get['sSearch_8'])){
            $this->db->where("pude_quantity like  '%".$get['sSearch_8']."%'  ");
        }
        if(!empty($get['sSearch_9'])){
            $this->db->where("pude_unit like  '%".$get['sSearch_9']."%'  ");
        }
        if(!empty($get['sSearch_10'])){
            $this->db->where("pude_rate like  '%".$get['sSearch_10']."%'  ");
        }
        if(!empty($get['sSearch_11'])){
            $this->db->where("pude_discount like  '%".$get['sSearch_11']."%'  ");
        }
        if(!empty($get['sSearch_12'])){
            $this->db->where("pude_vat like  '%".$get['sSearch_12']."%'  ");
        }
        if(!empty($get['sSearch_13'])){
            $this->db->where("pude_amount like  '%".$get['sSearch_13']."%'  ");
        }
        if(!empty($get['sSearch_14'])){
            $this->db->where("puor_remarks like  '%".$get['sSearch_14']."%'  ");
        }
        if(!empty($get['sSearch_15'])){
            $this->db->where("puor_requno like  '%".$get['sSearch_15']."%'  ");
        }
    
        if($cond) {
            $this->db->where($cond);
        }

       

        if(!empty($items)){
            $this->db->where('itli_itemlistid',$items);
        }

        $resltrpt=$this->db->select("COUNT(*) as cnt")
                    ->from('puor_purchaseordermaster pm')
                    ->join('pude_purchaseorderdetail pd','pd.pude_purchasemasterid = pm.puor_purchaseordermasterid')
                    ->join('itli_itemslist il','il.itli_itemlistid = pd.pude_itemsid')
                    ->join('eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid = il.itli_catid')
                    ->join('maty_materialtype mt','mt.maty_materialtypeid = il.itli_materialtypeid')
                    ->join('dist_distributors dt','dt.dist_distributorid = pm.puor_supplierid','left')
                    ->where('pm.puor_storeid',1)
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
            $order_by = 'puor_orderdatebs';
        else if($this->input->get('iSortCol_0')==2)
            $order_by = 'itli_itemcode';
        else if($this->input->get('iSortCol_0')==3)
            $order_by = 'itli_itemname';
        else if($this->input->get('iSortCol_0')==4)
            $order_by = 'maty_material';
        else if($this->input->get('iSortCol_0')==5)
            $order_by = 'eqca_category';
        else if($this->input->get('iSortCol_0')==6)
            $order_by = 'dist_distributor';
        else if($this->input->get('iSortCol_0')==7)
            $order_by = 'puor_orderno';
        else if($this->input->get('iSortCol_0')==8)
            $order_by = 'pude_quantity';
        else if($this->input->get('iSortCol_0')==9)
            $order_by = 'pude_unit';
        else if($this->input->get('iSortCol_0')==10)
            $order_by = 'pude_rate';
        else if($this->input->get('iSortCol_0')==11)
            $order_by = 'pude_discount';
        else if($this->input->get('iSortCol_0')==12)
            $order_by = 'pude_vat';
        else if($this->input->get('iSortCol_0')==13)
            $order_by = 'pude_amount';
        else if($this->input->get('iSortCol_0')==14)
            $order_by = 'puor_remarks';
        else if($this->input->get('iSortCol_0')==15)
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

          $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');
        $toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');

        $supplier = !empty($get['supplier'])?$get['supplier']:$this->input->post('supplier');
        
        $items = !empty($get['items'])?$get['items']:$this->input->post('items');


        if(!empty(($frmDate && $toDate)))
        {
            $this->db->where('puor_orderdatebs >=',$frmDate);
            $this->db->where('puor_orderdatebs <=',$toDate);
        }


        if(!empty($get['sSearch_1'])){
            $this->db->where("puor_orderdatebs like  '%".$get['sSearch_1']."%'  ");
        }
        if(!empty($get['sSearch_2'])){
            $this->db->where("itli_itemcode like  '%".$get['sSearch_2']."%'  ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("itli_itemname like  '%".$get['sSearch_3']."%' OR itli_itemnamenp like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("maty_material like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("eqca_category like  '%".$get['sSearch_5']."%'  ");
        }
        if(!empty($get['sSearch_6'])){
            $this->db->where("dist_distributor like  '%".$get['sSearch_6']."%'  ");
        }
        if(!empty($get['sSearch_7'])){
            $this->db->where("puor_orderno like  '%".$get['sSearch_7']."%'  ");
        }
        if(!empty($get['sSearch_8'])){
            $this->db->where("pude_quantity like  '%".$get['sSearch_8']."%'  ");
        }
        if(!empty($get['sSearch_9'])){
            $this->db->where("pude_unit like  '%".$get['sSearch_9']."%'  ");
        }
        if(!empty($get['sSearch_10'])){
            $this->db->where("pude_rate like  '%".$get['sSearch_10']."%'  ");
        }
        if(!empty($get['sSearch_11'])){
            $this->db->where("pude_discount like  '%".$get['sSearch_11']."%'  ");
        }
        if(!empty($get['sSearch_12'])){
            $this->db->where("pude_vat like  '%".$get['sSearch_12']."%'  ");
        }
        if(!empty($get['sSearch_13'])){
            $this->db->where("pude_amount like  '%".$get['sSearch_13']."%'  ");
        }
        if(!empty($get['sSearch_14'])){
            $this->db->where("puor_remarks like  '%".$get['sSearch_14']."%'  ");
        }
        if(!empty($get['sSearch_15'])){
            $this->db->where("puor_requno like  '%".$get['sSearch_15']."%'  ");
        }
    
       
        if($cond) {
          $this->db->where($cond);
        }

      
        if(!empty($supplier)){
            $this->db->where('puor_supplierid',$supplier);
        }
                if(!empty($mattypeid)){
            $this->db->where('maty_materialtypeid',$mattypeid);
        }
        

        // if(!empty($locationid))
        // {
        //       $this->db->where('pm.puor_locationid',$locationid);
        // }
     if($this->location_ismain=='Y'){
            if(!empty($locationid))
            {
                  $this->db->where('pm.puor_locationid',$locationid);
            }
         }else{
            $this->db->where('pm.puor_locationid',$this->locationid);

        }

        if(!empty($items)){
            $this->db->where('itli_itemlistid',$items);
        }

        $this->db->select('pm.puor_orderdatebs as orderdatebs, pm.puor_orderdatead as orderdatead,pm.puor_remarks as remarks, il.itli_itemcode as itemcode, il.itli_itemname as itemname,il.itli_itemnamenp as itemnamenp, mt.maty_material as materialname, dist_distributor as suppliername,
            ec.eqca_category as category, pm.puor_orderno as orderno, pd.pude_quantity as quantity, pd.pude_unit as unit, pd.pude_rate as rate, pd.pude_vat as vat, 
            pd.pude_discount as discount, pd.pude_amount as amount, pd.pude_remarks , pm.puor_requno as requno');
        $this->db->from('puor_purchaseordermaster pm');
        $this->db->join('pude_purchaseorderdetail pd','pd.pude_purchasemasterid = pm.puor_purchaseordermasterid','left');
        $this->db->join('itli_itemslist il','il.itli_itemlistid = pd.pude_itemsid','left');
        $this->db->join('eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid = il.itli_catid','left');
        $this->db->join('maty_materialtype mt','mt.maty_materialtypeid = il.itli_materialtypeid','left');
        $this->db->join('dist_distributors dt','dt.dist_distributorid = pm.puor_supplierid','left');

        $this->db->where('pm.puor_storeid',1);

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
}