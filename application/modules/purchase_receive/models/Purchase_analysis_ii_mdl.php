<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Purchase_analysis_ii_mdl extends CI_Model 
{
    public function __construct() 
    {
        parent::__construct();
         $this->locationid=$this->session->userdata(LOCATION_ID);
        $this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
    }
    public function get_summary_purchase_analysis_ii($cond = false)
    {
        $frmDate=$this->input->get('frmDate');
        $toDate=$this->input->get('toDate');
        $supplierid=$this->input->get('supplierid');
        $materialid=$this->input->get('materialid');
        $categoryid=$this->input->get('categoryid');
        $reportby=$this->input->get('reportby');
        // $locationid=$this->input->get('locationid');
        $get = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }
        if(!empty($get['sSearch_1'])){
            $this->db->where("eqca_category like  '%".$get['sSearch_1']."%'  ");
        }
         if(!empty($get['sSearch_2'])){
            $this->db->where("dist_distributor like  '%".$get['sSearch_2']."%'  ");
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

        if(!empty($supplierid))
        {
            $this->db->where(array('dist_distributorid'=>$supplierid));
        }
         if(!empty($materialid))
        {
            $this->db->where(array('maty_materialtypeid'=>$materialid));
        }
         if(!empty($categoryid))
        {
            $this->db->where(array('eqca_equipmentcategoryid'=>$categoryid));
        }
        //  if(!empty($locationid))
        // {
        //     $this->db->where(array('recm_locationid'=>$locationid));
        // }
        if($reportby=='sup')
        {
            $selectstatement='SELECT dist_distributorid,dist_distributor,SUM(recd_amount) as pvalue,0 as rvalue,SUM(recd_amount)-0 as netvalue';
            $grpby='dist_distributorid,dist_distributor';
        }
        else
        {
            $selectstatement='SELECT eqca_equipmentcategoryid,eqca_category,dist_distributorid,dist_distributor,SUM(recd_amount) as pvalue,0 as rvalue,SUM(recd_amount)-0 as netvalue';
             $grpby='eqca_equipmentcategoryid,eqca_category,dist_distributorid, dist_distributor';
        }
         $this->db->select('c.eqca_equipmentcategoryid,d.dist_distributorid,d.dist_distributor,mt.maty_materialtypeid, mt.maty_material,ut.unit_unitname,rd.recd_purchasedqty,rd.recd_amount,rd.recd_discountpc,rd.recd_vatpc,rm.recm_invoiceno,rm.recm_receiveddatebs,rm.recm_locationid,rm.recm_receiveddatead,il.itli_itemlistid,il.itli_itemcode,il.itli_itemname,c.eqca_category');
        $this->db->from('recm_receivedmaster rm');
        $this->db->join('recd_receiveddetail rd','rm.recm_receivedmasterid= rd.recd_receivedmasterid','LEFT');
        $this->db->join('itli_itemslist il','rd.recd_itemsid=il.itli_itemlistid','LEFT');
        $this->db->join('unit_unit ut','ut.unit_unitid=il.itli_unitid','LEFT');
        $this->db->join('eqca_equipmentcategory c','c.eqca_equipmentcategoryid=il.itli_catid','LEFT');
        $this->db->join('maty_materialtype mt','mt.maty_materialtypeid=il.itli_materialtypeid','LEFT');
           $this->db->join('dist_distributors d','d.dist_distributorid=rm.recm_supplierid','LEFT');
       $this->db->where(array('rm.recm_status'=>'O'));
       $this->db->get();
       $nqry=$this->db->last_query();
    $nquery2=$this->db->query("SELECT COUNT('*') as cnt FROM ($selectstatement FROM( $nqry) X GROUP BY $grpby ) Y");
        //echo $this->last_query();die(); 
        $totalfilteredrecs=$nquery2->row()->cnt; 
        $order_by = 'eqca_category';
        $order = 'asc';
        if($this->input->get('sSortDir_0'))
        {
                $order = $this->input->get('sSortDir_0');
        }
        $where='';
        if($this->input->get('iSortCol_0')==1)
            $order_by = 'eqca_category';
        else if($this->input->get('iSortCol_0')==2)
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
            $this->db->where("eqca_category like  '%".$get['sSearch_1']."%'  ");
        }
         if(!empty($get['sSearch_2'])){
            $this->db->where("dist_distributor like  '%".$get['sSearch_2']."%'  ");
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

        if(!empty($supplierid))
        {
            $this->db->where(array('dist_distributorid'=>$supplierid));
        }
         if(!empty($materialid))
        {
            $this->db->where(array('maty_materialtypeid'=>$materialid));
        }
         if(!empty($categoryid))
        {
            $this->db->where(array('eqca_equipmentcategoryid'=>$categoryid));
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
        $this->db->select('c.eqca_equipmentcategoryid,d.dist_distributorid,d.dist_distributor,mt.maty_materialtypeid, mt.maty_material,ut.unit_unitname,rd.recd_purchasedqty,rd.recd_amount,rd.recd_discountpc,rd.recd_vatpc,rm.recm_invoiceno,rm.recm_receiveddatebs,rm.recm_receiveddatead,rm.recm_locationid,il.itli_itemlistid,il.itli_itemcode,il.itli_itemname,c.eqca_category');
        $this->db->from('recm_receivedmaster rm');
        $this->db->join('recd_receiveddetail rd','rm.recm_receivedmasterid= rd.recd_receivedmasterid','LEFT');
        $this->db->join('itli_itemslist il','rd.recd_itemsid=il.itli_itemlistid','LEFT');
        $this->db->join('unit_unit ut','ut.unit_unitid=il.itli_unitid','LEFT');
        $this->db->join('eqca_equipmentcategory c','c.eqca_equipmentcategoryid=il.itli_catid','LEFT');
        $this->db->join('maty_materialtype mt','mt.maty_materialtypeid=il.itli_materialtypeid','LEFT');
           $this->db->join('dist_distributors d','d.dist_distributorid=rm.recm_supplierid','LEFT');
       $this->db->where(array('rm.recm_status'=>'O'));
       $this->db->get();
       $nqry=$this->db->last_query();
    $nquery2=$this->db->query("$selectstatement FROM( $nqry) X GROUP BY $grpby LIMIT $limit OFFSET $offset ");
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
    public function get_detail_purchase_analysis_ii($cond = false)
    {
        $frmDate=$this->input->get('frmDate');
        $toDate=$this->input->get('toDate');
        $supplierid=$this->input->get('supplierid');
        $materialid=$this->input->get('materialid');
        $categoryid=$this->input->get('categoryid');
        $reportby=$this->input->get('reportby');
        // $locationid=$this->input->get('locationid');
        $get = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }
        if(!empty($get['sSearch_1'])){
            $this->db->where("eqca_category like  '%".$get['sSearch_1']."%'  ");
        }
         if(!empty($get['sSearch_2'])){
            $this->db->where("dist_distributor like  '%".$get['sSearch_2']."%'  ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("itli_itemcode like  '%".$get['sSearch_3']."%'  ");
        }  
        if(!empty($get['sSearch_4'])){
            // $this->db->where("itli_itemname like  '%".$get['sSearch_4']."%'  ");
          $this->db->where("itli_itemname like  '%".$get['sSearch_4']."%' OR itli_itemnamenp like  '%".$get['sSearch_4']."%'  ");
        }  
        if(!empty($get['sSearch_5'])){
            $this->db->where("recm_invoiceno like  '%".$get['sSearch_5']."%'  ");
        }  
        if(!empty($get['sSearch_6'])){
            $this->db->where("recm_supplierbillno like  '%".$get['sSearch_6']."%'  ");
        }
         if(!empty($get['sSearch_7'])){
            $this->db->where("recm_receiveddatebs like  '%".$get['sSearch_7']."%'  ");
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

        if(!empty($supplierid))
        {
            $this->db->where(array('dist_distributorid'=>$supplierid));
        }
         if(!empty($materialid))
        {
            $this->db->where(array('maty_materialtypeid'=>$materialid));
        }
         if(!empty($categoryid))
        {
            $this->db->where(array('eqca_equipmentcategoryid'=>$categoryid));
        }
        //     if(!empty($locationid))
        // {
        //     $this->db->where(array('recm_locationid'=>$locationid));
        // }
          $locationid= !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');

             
     if($this->location_ismain=='Y'){
       if(!empty($locationid))
        {
            $this->db->where('recm_locationid',$locationid);
        }
        }else{
            $this->db->where('recm_locationid',$this->locationid);

        }

        $this->db->select('COUNT(*) as cnt');
        $this->db->from('recm_receivedmaster rm');
        $this->db->join('recd_receiveddetail rd','rm.recm_receivedmasterid= rd.recd_receivedmasterid','LEFT');
        $this->db->join('itli_itemslist il','rd.recd_itemsid=il.itli_itemlistid','LEFT');
        $this->db->join('unit_unit ut','ut.unit_unitid=il.itli_unitid','LEFT');
        $this->db->join('eqca_equipmentcategory c','c.eqca_equipmentcategoryid=il.itli_catid','LEFT');
        $this->db->join('maty_materialtype mt','mt.maty_materialtypeid=il.itli_materialtypeid','LEFT');
           $this->db->join('dist_distributors d','d.dist_distributorid=rm.recm_supplierid','LEFT');
       $this->db->where(array('rm.recm_status'=>'O'));
       $resltrpt=$this->db->get()->row();
       $totalfilteredrecs=$resltrpt->cnt; 
        $order_by = 'eqca_category';
        $order = 'asc';
        if($this->input->get('sSortDir_0'))
        {
                $order = $this->input->get('sSortDir_0');
        }
    $where='';
   if($this->input->get('iSortCol_0')==0)
            $order_by = 'eqca_category';
        else if($this->input->get('iSortCol_0')==1)
            $order_by = 'eqca_category';
        else if($this->input->get('iSortCol_0')==2)
            $order_by = 'dist_distributor';
        else if($this->input->get('iSortCol_0')==3)
            $order_by = 'itli_itemcode';
        else if($this->input->get('iSortCol_0')==4)
            $order_by = 'itli_itemname';
        else if($this->input->get('iSortCol_0')==5)
            $order_by = 'recm_invoiceno';
        else if($this->input->get('iSortCol_0')==6)
            $order_by = 'recm_supplierbillno';
        else if($this->input->get('iSortCol_0')==7)
            $order_by = 'recm_receiveddatebs';
        else if($this->input->get('iSortCol_0')==8)
            $order_by = 'recd_purchasedqty';
        else if($this->input->get('iSortCol_0')==9)
            $order_by = 'recd_unitprice';
        else if($this->input->get('iSortCol_0')==10)
            $order_by = 'recd_discountpc';
         else if($this->input->get('iSortCol_0')==11)
            $order_by = 'recd_vatpc';
         else if($this->input->get('iSortCol_0')==13)
            $order_by = 'recd_amount';


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
            $this->db->where("eqca_category like  '%".$get['sSearch_1']."%'  ");
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
        if(!empty($get['sSearch_5'])){
            $this->db->where("recm_invoiceno like  '%".$get['sSearch_5']."%'  ");
        }  
        if(!empty($get['sSearch_6'])){
            $this->db->where("recm_supplierbillno like  '%".$get['sSearch_6']."%'  ");
        }
         if(!empty($get['sSearch_7'])){
            $this->db->where("recm_receiveddatebs like  '%".$get['sSearch_7']."%'  ");
        } 
         if(!empty($frmDate) && !empty($toDate))
        {
            $this->db->where(array('recm_receiveddatebs >='=>$frmDate,'recm_receiveddatebs <='=>$toDate));
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

        if(!empty($supplierid))
        {
            $this->db->where(array('dist_distributorid'=>$supplierid));
        }
         if(!empty($materialid))
        {
            $this->db->where(array('maty_materialtypeid'=>$materialid));
        }
         if(!empty($categoryid))
        {
            $this->db->where(array('eqca_equipmentcategoryid'=>$categoryid));
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
        $this->db->select('c.eqca_equipmentcategoryid,d.dist_distributorid,d.dist_distributor,mt.maty_materialtypeid, mt.maty_material,ut.unit_unitname,rd.recd_purchasedqty,rd.recd_amount,rd.recd_unitprice,rd.recd_discountpc,rd.recd_vatpc,rm.recm_invoiceno,rm.recm_supplierbillno, rm.recm_receiveddatebs,rm.recm_receiveddatead,il.itli_itemlistid,il.itli_itemcode,il.itli_itemname,il.itli_itemnamenp,c.eqca_category');
        $this->db->from('recm_receivedmaster rm');
        $this->db->join('recd_receiveddetail rd','rm.recm_receivedmasterid= rd.recd_receivedmasterid','LEFT');
        $this->db->join('itli_itemslist il','rd.recd_itemsid=il.itli_itemlistid','LEFT');
        $this->db->join('unit_unit ut','ut.unit_unitid=il.itli_unitid','LEFT');
        $this->db->join('eqca_equipmentcategory c','c.eqca_equipmentcategoryid=il.itli_catid','LEFT');
        $this->db->join('maty_materialtype mt','mt.maty_materialtypeid=il.itli_materialtypeid','LEFT');
           $this->db->join('dist_distributors d','d.dist_distributorid=rm.recm_supplierid','LEFT');
       $this->db->where(array('rm.recm_status'=>'O'));
       $this->db->order_by($order_by,$order);
       $this->db->limit($limit,$offset);
       $nquery2= $this->db->get();

       // echo $this->db->last_query(); die();
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
}