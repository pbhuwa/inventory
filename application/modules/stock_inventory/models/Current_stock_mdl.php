<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
ini_set('max_execution_time', '300');
class Current_stock_mdl extends CI_Model 
{
    public function __construct() 
    {
        parent::__construct();
         $this->locationid=$this->session->userdata(LOCATION_ID);
        $this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
    }
    
    public function get_category_wise_report($srchcol=false,$limit=false,$offset=false,$order=false,$order_by=false)
    {
        $fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');

        $this->db->select('p.*, bm.bmin_equipmentkey, rsk.riva_risk, d.dept_depname');
        $this->db->from('pmta_pmtable p');
        $this->db->join('bmin_bmeinventory bm', 'bm.bmin_equipid = p.pmta_equipid');
        $this->db->join('riva_riskvalues rsk', 'rsk.riva_riskid = bm.bmin_riskid', "LEFT");
        $this->db->join('dept_department d', 'd.dept_depid  = bm.bmin_departmentid', "LEFT");

        if($fromdate &&  $todate){
            if(DEFAULT_DATEPICKER=='NP')
            {
              $this->db->where('pmta_pmdatebs >=', $fromdate);
              $this->db->where('pmta_pmdatebs <=', $todate);
            }
            else
            {
              $this->db->where('pmta_pmdatead >=', $fromdate);
              $this->db->where('pmta_pmdatead <=', $todate);
            }
        }
        if($srchcol)
        {
            $this->db->where($srchcol); 
        }
        $query = $this->db->get();
        //echo $this->db->last_query();die();
        if ($query->num_rows() > 0) 
        {
            $data=$query->result();     
            return $data;       
        }       
        return false;
    }

    public function get_current_stock_lists($cond= false)
    {
        $apptype = $this->input->get('apptype');
        $get = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("lower(itli_itemcode) like  '%".$get['sSearch_1']."%'  ");
        }
        if(!empty($get['sSearch_2'])){
             $this->db->where("lower(itli_itemname) like  '%".$get['sSearch_2']."%' OR itli_itemnamenp like  '%".$get['sSearch_2']."%'  ");
        }
         if(!empty($get['sSearch_3'])){
            $this->db->where("lower(unit_unitname) like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("lower(eqca_category) like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("lower(maty_material) like  '%".$get['sSearch_5']."%'  ");
        }
        if(!empty($get['sSearch_6'])){
            $this->db->where("lower(itli_maxlimit) like  '%".$get['sSearch_6']."%'  ");
        }
        if(!empty($get['sSearch_7'])){
            $this->db->where("lower(itli_reorderlevel) like  '%".$get['sSearch_7']."%'  ");
        }
        if(!empty($get['sSearch_8'])){
            $this->db->where("lower(trde_issueqty) like  '%".$get['sSearch_8']."%'  ");
        }
        if(!empty($get['sSearch_9'])){
            $this->db->where("lower(stockrmk) like  '%".$get['sSearch_9']."%'  ");
        }
        if(!empty($get['sSearch_10'])){
            $this->db->where("lower(loca_name) like  '%".$get['sSearch_10']."%'  ");
        }
        
        // if($cond) {
        //     $this->db->where($cond);
        // }

        $store_id = !empty($get['store_id'])?$get['store_id']:$this->input->post('store_id');
        $categoryid = !empty($get['categoryid'])?$get['categoryid']:$this->input->post('categoryid');
        $toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');
        $items = !empty($get['items'])?$get['items']:$this->input->post('items');
        $locationid = !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');
        $mat_id =!empty($get['mat_id'])?$get['mat_id']:$this->input->post('mat_id');
        $searchText = !empty($get['searchText'])?$get['searchText']:$this->input->post('searchText');
        // if($locationid)
        // {
        //     $this->db->where('td.trde_locationid',$locationid);
        // }
        if(!empty($mat_id)){
            $this->db->where('itli_materialtypeid',$mat_id);
        }
        if($this->location_ismain=='Y')
        {
           if(!empty($locationid))
            {
                $this->db->where('td.trde_locationid',$locationid);
            }

        }
        else
        {
            $this->db->where('td.trde_locationid',$this->locationid);
        }
        if ($categoryid) {
            $this->db->where('eqca_equipmentcategoryid',$categoryid);
        }

        if($searchText){
            $this->db->where("lower(itli_itemcode) like  '%".$searchText."%'  ")
            ->or_where("lower(itli_itemname) like  '%".$searchText."%'  ");
        }

        if($apptype == 'available'){
            $this->db->having('stockrmk','Stock');
        }else if($apptype == 'zero'){
            $this->db->having('stockrmk','Zero');
        }else if($apptype == 'limited'){
            $this->db->having('stockrmk','Limited');
        }
        
        $select = "itli_itemlistid, itli_itemcode, itli_itemname,itli_itemnamenp, itli_reorderlevel, itli_maxlimit, mt.maty_material,
                eq.eqca_category, unit_unitname, trde_transactiontype, trma_todepartmentid, trma_locationid, loca_name, loca_locationid, ifnull(sum(trde_issueqty),0) as totalstock,
                (
                CASE WHEN((ifnull(sum(trde_issueqty),0) <itli_reorderlevel) && (ifnull(sum(trde_issueqty),0)>0 )) THEN 'Limited'  WHEN (ifnull(sum(trde_issueqty),0)=0) THEN 'Zero' ELSE  'Stock' END ) as stockrmk";
        $resltrpt=$this->db->select($select)
                        ->from('itli_itemslist il')
                        ->join('trde_transactiondetail td','td.trde_itemsid  = il.itli_itemlistid','LEFT')
                        ->join('unit_unit ut','ut.unit_unitid  = il.itli_unitid','left')
                        ->join('eqca_equipmentcategory eq','eq.eqca_equipmentcategoryid = il.itli_catid','LEFT')
                        ->join('maty_materialtype mt','mt.maty_materialtypeid = il.itli_materialtypeid','LEFT')
                        ->join('trma_transactionmain tm','tm.trma_trmaid = td.trde_trmaid','LEFT')
                        ->join('loca_location lc','lc.loca_locationid = tm.trma_locationid','left')
                        ->where(array('tm.trma_received'=>'1','td.trde_status'=>'O'))
                      
                        ->group_by('itli_itemlistid, loca_locationid')
                        ->get()
                        ->result();
         // echo $this->db->last_query();die();
        // $totalfilteredrecs=$resltrpt->cnt;
        $totalfilteredrecs = sizeof($resltrpt); 

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
        else if($this->input->get('iSortCol_0')==4)
            $order_by = 'eqca_category';
        else if($this->input->get('iSortCol_0')==5)
            $order_by = 'maty_material';
        else if($this->input->get('iSortCol_0')==6)
            $order_by = 'itli_maxlimit';
        else if($this->input->get('iSortCol_0')==7)
            $order_by = 'itli_reorderlevel';
        else if($this->input->get('iSortCol_0')==8)
            $order_by = 'trde_issueqty';
        else if($this->input->get('iSortCol_0')==9)
            $order_by = 'stockrmk';
        else if($this->input->get('iSortCol_0')==10)
            $order_by = 'loca_name';
        
        $totalrecs='';
        $limit = 15;
        $offset = 0;
        $get = $_GET;
 
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }
      
        if(!empty($_GET["iDisplayLength"])){
           $limit = $_GET['iDisplayLength'];
           $offset = $_GET["iDisplayStart"];
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("lower(itli_itemcode) like  '%".$get['sSearch_1']."%'  ");
        }
        if(!empty($get['sSearch_2'])){
            $this->db->where("(lower(itli_itemname) like  '%".$get['sSearch_2']."%' OR itli_itemnamenp like  '%".$get['sSearch_2']."%'  )");
        }
         if(!empty($get['sSearch_3'])){
            $this->db->where("lower(unit_unitname) like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("lower(eqca_category) like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("lower(maty_material) like  '%".$get['sSearch_5']."%'  ");
        }
        if(!empty($get['sSearch_6'])){
            $this->db->where("lower(itli_maxlimit) like  '%".$get['sSearch_6']."%'  ");
        }
        if(!empty($get['sSearch_7'])){
            $this->db->where("lower(itli_reorderlevel) like  '%".$get['sSearch_7']."%'  ");
        }
        if(!empty($get['sSearch_8'])){
            $this->db->where("lower(trde_issueqty) like  '%".$get['sSearch_8']."%'  ");
        }
        if(!empty($get['sSearch_9'])){
            $this->db->where("lower(stockrmk) like  '%".$get['sSearch_9']."%'  ");
        }
        if(!empty($get['sSearch_10'])){
            $this->db->where("lower(loca_name) like  '%".$get['sSearch_10']."%'  ");
        }

        $select = "itli_itemlistid, itli_itemcode, itli_itemname,itli_itemnamenp, itli_reorderlevel, itli_maxlimit, mt.maty_material,
                eq.eqca_category, unit_unitname, trma_todepartmentid, trma_locationid, loca_name, loca_locationid, ifnull(sum(trde_issueqty),0) as totalstock,
                (
                CASE WHEN((ifnull(sum(trde_issueqty),0) <itli_reorderlevel) && (ifnull(sum(trde_issueqty),0)>0 )) THEN 'Limited'  WHEN (ifnull(sum(trde_issueqty),0)=0) THEN 'Zero' ELSE  'Stock' END ) stockrmk";

        $this->db->select($select);
        $this->db->from('itli_itemslist il');
        $this->db->join('unit_unit ut','ut.unit_unitid  = il.itli_unitid','left');
        $this->db->join('trde_transactiondetail td','td.trde_itemsid  = il.itli_itemlistid','left');
        $this->db->join('eqca_equipmentcategory eq','eq.eqca_equipmentcategoryid = il.itli_catid','left');
        $this->db->join('maty_materialtype mt','mt.maty_materialtypeid = il.itli_materialtypeid','left');
        $this->db->join('trma_transactionmain tm','tm.trma_trmaid = td.trde_trmaid','left');
        $this->db->join('loca_location lc','lc.loca_locationid = td.trde_locationid','left');
       
        if($this->location_ismain=='Y')
        {
            if($locationid)
            {
                $this->db->where('td.trde_locationid',$locationid);
            }

        }
        else
        {
           $this->db->where('td.trde_locationid',$this->locationid);
        }
        $this->db->where(array('tm.trma_received'=>'1','td.trde_status'=>'O'));
        $this->db->group_by('itli_itemlistid, loca_locationid');

        if($cond) 
        {
          $this->db->where($cond);
        }

        $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');
        $toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');

        $mat_id =!empty($get['mat_id'])?$get['mat_id']:$this->input->post('mat_id');
        $locationid = !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');
        $items = !empty($get['items'])?$get['items']:$this->input->post('items');

        if(!empty(($store_id)))
        {  
           $this->db->where('eq.eqca_equiptypeid',$store_id); 
        }

        if(!empty($supplier))
        {
            $this->db->where('supp_supplierid',$supplier);
        }

        if(!empty($code_id))
        {
            $this->db->where('il.itli_itemlistid',$code_id);
        }

        if(!empty($items))
        {
            $this->db->where('itli_itemlistid',$items);
        }
        if(!empty($mat_id)){
            $this->db->where('itli_materialtypeid',$mat_id);
        }

        if(!empty($location))
        {
            $this->db->where('loca_name',$location);
        }
        if ($categoryid) {
            $this->db->where('eqca_equipmentcategoryid',$categoryid);
        }
        if($searchText){
            $this->db->where("lower(itli_itemcode) like  '%".$searchText."%'  ")
            ->or_where("lower(itli_itemname) like  '%".$searchText."%'  ");
        }

        // if(!empty($locationid)){
        //     $this->db->where('trde_locationid',$locationid);
        // }
         if($this->location_ismain=='Y')
        {
        if(!empty($locationid))
            {
                $this->db->where('trde_locationid',$locationid);
            }

        }
        else
        {
            $this->db->where('trde_locationid',$this->locationid);
        }

        if($apptype == 'available'){
            $this->db->having('stockrmk','Stock');
        }else if($apptype == 'zero'){
            $this->db->having('stockrmk','Zero');
        }else if($apptype == 'limited'){
            $this->db->having('stockrmk','Limited');
        }
        
        $order_by = 'itli_itemname';
        $order = 'asc';
        if($this->input->get('sSortDir_0'))
        {
            $order = $this->input->get('sSortDir_0');
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
      
        // $nquery=$this->db->query($sql);
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

    public function get_current_stock_detail_lists($cond= false)
    {
        $get = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("lower(itli_itemcode) like  '%".$get['sSearch_1']."%'  ");
        }
        if(!empty($get['sSearch_2'])){
            $this->db->where("lower(itli_itemname) like  '%".$get['sSearch_2']."%' OR itli_itemnamenp like  '%".$get['sSearch_2']."%'  ");
        }
          if(!empty($get['sSearch_3'])){
            $this->db->where("lower(itli_itemname) like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("lower(eqca_category) like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("lower(maty_material) like  '%".$get['sSearch_5']."%'  ");
        }
        if(!empty($get['sSearch_6'])){
            $this->db->where("lower(itli_maxlimit) like  '%".$get['sSearch_6']."%'  ");
        }
        if(!empty($get['sSearch_6'])){
            $this->db->where("lower(itli_reorderlevel) like  '%".$get['sSearch_6']."%'  ");
        }
        if(!empty($get['sSearch_7'])){
            $this->db->where("lower(totalstock) like  '%".$get['sSearch_7']."%'  ");
        }
        if(!empty($get['sSearch_8'])){
            $this->db->where("lower(stockrmk) like  '%".$get['sSearch_8']."%'  ");
        }
        if(!empty($get['sSearch_9'])){
            if(DEFAULT_DATEPICKER == 'NP')
            {
                $this->db->where("lower(trde_transactiondatebs) like  '%".$get['sSearch_9']."%'  ");
            }else{
                $this->db->where("lower(trde_transactiondatead) like  '%".$get['sSearch_9']."%'  ");
            }
        }
         if(!empty($get['sSearch_10'])){
            $this->db->where("lower(loca_name) like  '%".$get['sSearch_10']."%'  ");
        }

        if(!empty($get['sSearch_11'])){
            $this->db->where("lower(trde_transactiontype) like  '%".$get['sSearch_11']."%'  ");
        }
        // if($cond) {
        //     $this->db->where($cond);
        // }

        $store_id = !empty($get['store_id'])?$get['store_id']:$this->input->post('store_id');
        $toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');

        $supplier = !empty($get['supplier'])?$get['supplier']:$this->input->post('supplier');
        
        $items = !empty($get['items'])?$get['items']:$this->input->post('items');
        $locationid = !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');

        // if(!empty(($store_id)))
        // {  
        //     //print_r($store_id);die;
        //    $this->db->where('c.eqca_equiptypeid',$store_id);
           
        // }

        // if(!empty($supplier)){
        //     $this->db->where('supp_supplierid',$supplier);
        // }

        // if(!empty($items)){
        //     $this->db->where('itli_itemlistid',$items);
        // }
        //  if(!empty($location)){
        //  $this->db->where('location',$location);
        // }
    
        $resltrpt=$this->db->select("*")
                        ->from('itli_itemslist il')
                        ->join('trde_transactiondetail td','td.trde_itemsid  = il.itli_itemlistid','LEFT')
                        ->join('unit_unit ut','ut.unit_unitid  = il.itli_unitid','left')
                        ->join('eqca_equipmentcategory eq','eq.eqca_equipmentcategoryid = il.itli_catid','LEFT')
                        ->join('maty_materialtype mt','mt.maty_materialtypeid = il.itli_materialtypeid','LEFT')
                        ->join('trma_transactionmain tm','tm.trma_trmaid = td.trde_trmaid','LEFT')
                        ->join('loca_location lc','lc.loca_locationid = tm.trma_locationid','left')
                        ->get()
                        ->result();
        // echo $this->db->last_query();die();

        // $totalfilteredrecs=$resltrpt->cnt;
        $totalfilteredrecs = sizeof($resltrpt); 

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
            $order_by = 'eqca_category';
        else if($this->input->get('iSortCol_0')==4)
            $order_by = 'maty_material';
        else if($this->input->get('iSortCol_0')==5)
            $order_by = 'itli_maxlimit';
        else if($this->input->get('iSortCol_0')==6)
            $order_by = 'itli_reorderlevel';
        else if($this->input->get('iSortCol_0')==7)
            $order_by = 'totalstock';
        else if($this->input->get('iSortCol_0')==8)
            $order_by = 'stockrmk';
        else if($this->input->get('iSortCol_0')==9)
            if(DEFAULT_DATEPICKER == 'NP')
                {
                    $order_by = 'trde_transactiondatebs';
                }else{
                    $order_by = 'trde_transactiondatead';
                }
        else if($this->input->get('iSortCol_0')==10)
            $order_by = 'loca_name';
        else if($this->input->get('iSortCol_0')==11)
            $order_by = 'trde_transactiontype';
            
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
            $this->db->where("lower(itli_itemcode) like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
           $this->db->where("lower(itli_itemname) like  '%".$get['sSearch_2']."%' OR itli_itemnamenp like  '%".$get['sSearch_2']."%'  ");
        }

        if(!empty($get['sSearch_3'])){
            $this->db->where("lower(eqca_category) like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("lower(maty_material) like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("lower(itli_maxlimit) like  '%".$get['sSearch_5']."%'  ");
        }
        if(!empty($get['sSearch_6'])){
            $this->db->where("lower(itli_reorderlevel) like  '%".$get['sSearch_6']."%'  ");
        }

        if(!empty($get['sSearch_7'])){
            $this->db->where("lower(totalstock) like  '%".$get['sSearch_7']."%'  ");
        }
        if(!empty($get['sSearch_8'])){
            $this->db->where("lower(stockrmk) like  '%".$get['sSearch_8']."%'  ");
        }

        if(!empty($get['sSearch_9'])){
            if(DEFAULT_DATEPICKER == 'NP')
            {
                $this->db->where("lower(trde_transactiondatebs) like  '%".$get['sSearch_9']."%'  ");
            }else{
                $this->db->where("lower(trde_transactiondatead) like  '%".$get['sSearch_9']."%'  ");
            }
        }
        if(!empty($get['sSearch_10'])){
            $this->db->where("lower(loca_name) like  '%".$get['sSearch_10']."%'  ");
        }

        if(!empty($get['sSearch_11'])){
            $this->db->where("lower(trde_transactiontype) like  '%".$get['sSearch_11']."%'  ");
        }

        $select = "itli_itemlistid, itli_itemcode, itli_itemname, mt.maty_material, eq.eqca_category, unit_unitname, trde_transactiontype, trde_issueqty, trde_unitprice, trde_transactiondatead, trde_transactiondatebs,trma_todepartmentid,  loca_name, loca_locationid";
        $this->db->select($select);
        $this->db->from('itli_itemslist il');
        $this->db->join('trde_transactiondetail td','td.trde_itemsid  = il.itli_itemlistid','left');
        $this->db->join('unit_unit ut','ut.unit_unitid  = il.itli_unitid','left');
        $this->db->join('eqca_equipmentcategory eq','eq.eqca_equipmentcategoryid = il.itli_catid','left');
        $this->db->join('maty_materialtype mt','mt.maty_materialtypeid = il.itli_materialtypeid','left');
        $this->db->join('trma_transactionmain tm','tm.trma_trmaid = td.trde_trmaid','left');
        $this->db->join('loca_location lc','lc.loca_locationid = td.trde_locationid','left');

        if($cond) {
          $this->db->where($cond);
        }

        $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');
        $toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');

        $supplier = !empty($get['supplier'])?$get['supplier']:$this->input->post('supplier');
        $locationid = !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');
        $items = !empty($get['items'])?$get['items']:$this->input->post('items');

        if(!empty(($store_id)))
        {  
           $this->db->where('c.eqca_equiptypeid',$store_id);
           
        }

        if(!empty($supplier)){
            $this->db->where('supp_supplierid',$supplier);
        }

        if(!empty($items)){
            $this->db->where('itli_itemlistid',$items);
        }
        if(!empty($location)){
            $this->db->where('loca_name',$location);
        }

        if(!empty($locationid)){
            $this->db->where('trde_locationid',$locationid);
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
      
        // $nquery=$this->db->query($sql);
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

    public function get_location_stock_detail_lists($cond=false)
    {
        $get = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("lower(itli_itemcode) like  '%".$get['sSearch_1']."%'  ");
        }
        if(!empty($get['sSearch_2'])){
            $this->db->where("lower(itli_itemname) like  '%".$get['sSearch_2']."%' OR itli_itemnamenp like  '%".$get['sSearch_2']."%'  ");
        }
          if(!empty($get['sSearch_3'])){
            $this->db->where("lower(itli_itemname) like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("lower(eqca_category) like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("lower(maty_material) like  '%".$get['sSearch_5']."%'  ");
        }
        if(!empty($get['sSearch_6'])){
            $this->db->where("lower(trde_issueqty) like  '%".$get['sSearch_6']."%'  ");
        }
        
        if(!empty($get['sSearch_7'])){
            $this->db->where("lower(trde_unitprice) like  '%".$get['sSearch_7']."%'  ");
        }
       
        if(!empty($get['sSearch_9'])){
            if(DEFAULT_DATEPICKER == 'NP')
            {
                $this->db->where("lower(trde_transactiondatebs) like  '%".$get['sSearch_9']."%'  ");
            }else{
                $this->db->where("lower(trde_transactiondatead) like  '%".$get['sSearch_9']."%'  ");
            }
        }
         if(!empty($get['sSearch_10'])){
            $this->db->where("lower(loca_name) like  '%".$get['sSearch_10']."%'  ");
        }
        if(!empty($get['sSearch_11'])){
            $this->db->where("lower(trde_transactiontype) like  '%".$get['sSearch_11']."%'  ");
        }
        // if($cond) {
        //     $this->db->where($cond);
        // }

        $store_id = !empty($get['store_id'])?$get['store_id']:$this->input->post('store_id');
         $code_id = !empty($get['code_id'])?$get['code_id']:$this->input->post('code_id');

        $frmDate = !empty($get['frmDate'])?$get['toDate']:$this->input->post('frmDate');
        $toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');

        if($frmDate &&  $toDate){
            if(DEFAULT_DATEPICKER=='NP')
            {
              $this->db->where('trde_transactiondatebs >=', $frmDate); //change acc to db date
              $this->db->where('trde_transactiondatebs <=', $toDate); //change acc to db date
            }
            else
            {
              $this->db->where('trde_transactiondatead >=', $frmDate);//change acc to db date
              $this->db->where('trde_transactiondatead <=', $toDate);//change acc to db date
            }
        }

        $supplier = !empty($get['supplier'])?$get['supplier']:$this->input->post('supplier');
        
        $items = !empty($get['items'])?$get['items']:$this->input->post('items');
        $fromdate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');
        $todate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');
        $locationid = !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');

   if($this->location_ismain=='Y'){
     if(!empty($locationid))
        {
            $this->db->where('trde_locationid',$locationid);
        }

         }else{
             $this->db->where('trde_locationid',$this->locationid);

        }

        // if(!empty(($store_id)))
        // {  
        //     //print_r($store_id);die;
        //    $this->db->where('c.eqca_equiptypeid',$store_id);
           
        // }

        // if(!empty($supplier)){
        //     $this->db->where('supp_supplierid',$supplier);
        // }

        // if(!empty($items)){
        //     $this->db->where('itli_itemlistid',$items);
        // }
        //  if(!empty($location)){
        //  $this->db->where('location',$location);
        // }
    
        $resltrpt=$this->db->select("*")
                        ->from('itli_itemslist il')
                        ->join('trde_transactiondetail td','td.trde_itemsid  = il.itli_itemlistid','LEFT')
                        ->join('unit_unit ut','ut.unit_unitid  = il.itli_unitid','left')
                        ->join('eqca_equipmentcategory eq','eq.eqca_equipmentcategoryid = il.itli_catid','LEFT')
                        ->join('maty_materialtype mt','mt.maty_materialtypeid = il.itli_materialtypeid','LEFT')
                        ->join('trma_transactionmain tm','tm.trma_trmaid = td.trde_trmaid','LEFT')
                        ->join('loca_location lc','lc.loca_locationid = tm.trma_locationid','left')
                        ->get()
                        ->result();
        // echo $this->db->last_query();die();

        // $totalfilteredrecs=$resltrpt->cnt;
        $totalfilteredrecs = sizeof($resltrpt); 

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
        else if($this->input->get('iSortCol_0')==4)
            $order_by = 'eqca_category';
        else if($this->input->get('iSortCol_0')==5)
            $order_by = 'maty_material';
        else if($this->input->get('iSortCol_0')==6)
            $order_by = 'trde_issueqty';
        else if($this->input->get('iSortCol_0')==7)
            $order_by = 'trde_unitprice';
        
        else if($this->input->get('iSortCol_0')==9)
            if(DEFAULT_DATEPICKER == 'NP')
                {
                    $order_by = 'trde_transactiondatebs';
                }else{
                    $order_by = 'trde_transactiondatead';
                }
        else if($this->input->get('iSortCol_0')==10)
            $order_by = 'loca_name';
        else if($this->input->get('iSortCol_0')==11)
            $order_by = 'trde_transactiontype';

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
            $this->db->where("lower(itli_itemcode) like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
           $this->db->where("lower(itli_itemname) like  '%".$get['sSearch_2']."%' OR itli_itemnamenp like  '%".$get['sSearch_2']."%'  ");
        }

        if(!empty($get['sSearch_3'])){
            $this->db->where("lower(unit_unitname) like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("lower(eqca_category) like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("lower(maty_material) like  '%".$get['sSearch_5']."%'  ");
        }
        if(!empty($get['sSearch_6'])){
            $this->db->where("lower(trde_issueqty) like  '%".$get['sSearch_6']."%'  ");
        }

        if(!empty($get['sSearch_7'])){
            $this->db->where("lower(trde_unitprice) like  '%".$get['sSearch_7']."%'  ");
        }

        if(!empty($get['sSearch_9'])){
            if(DEFAULT_DATEPICKER == 'NP')
            {
                $this->db->where("lower(trde_transactiondatebs) like  '%".$get['sSearch_9']."%'  ");
            }else{
                $this->db->where("lower(trde_transactiondatead) like  '%".$get['sSearch_9']."%'  ");
            }
        }
         if(!empty($get['sSearch_10'])){
            $this->db->where("lower(loca_name) like  '%".$get['sSearch_10']."%'  ");
        }
        if(!empty($get['sSearch_11'])){
            $this->db->where("lower(trde_transactiontype) like  '%".$get['sSearch_11']."%'  ");
        }

        $select = "itli_itemlistid, itli_itemcode, itli_itemname,itli_itemnamenp, mt.maty_material, eq.eqca_category, unit_unitname, trde_transactiontype, trde_issueqty, trde_unitprice, trde_transactiondatead, trde_transactiondatebs,trma_todepartmentid,  loca_name, loca_locationid";
        $this->db->select($select);
        $this->db->from('itli_itemslist il');
        $this->db->join('trde_transactiondetail td','td.trde_itemsid  = il.itli_itemlistid','left');
        $this->db->join('unit_unit ut','ut.unit_unitid  = il.itli_unitid','left');
        $this->db->join('eqca_equipmentcategory eq','eq.eqca_equipmentcategoryid = il.itli_catid','left');
        $this->db->join('maty_materialtype mt','mt.maty_materialtypeid = il.itli_materialtypeid','left');
        $this->db->join('trma_transactionmain tm','tm.trma_trmaid = td.trde_trmaid','left');
        $this->db->join('loca_location lc','lc.loca_locationid = td.trde_locationid','left');

        if($cond) {
          $this->db->where($cond);
        }

        $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');
        $toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');

        $supplier = !empty($get['supplier'])?$get['supplier']:$this->input->post('supplier');
        $locationid = !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');
        $items = !empty($get['items'])?$get['items']:$this->input->post('items');

        $fromdate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');
        $todate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');

        if($frmDate &&  $toDate){
            if(DEFAULT_DATEPICKER=='NP')
            {
              $this->db->where('trde_transactiondatebs >=', $frmDate);//change acc to db date
              $this->db->where('trde_transactiondatebs <=', $toDate);//change acc to db date
            }
            else
            {
              $this->db->where('trde_transactiondatead >=', $frmDate);//change acc to db date
              $this->db->where('trde_transactiondatead <=', $toDate);//change acc to db date
            }
        }

        if(!empty(($store_id)))
        {  
           $this->db->where('eq.eqca_equiptypeid',$store_id);
           
        }

        if(!empty(($code_id)))
        {
            $this->db->where('il.itli_itemlistid',$code_id);
        }

        if(!empty($items)){
            $this->db->where('itli_itemlistid',$items);
        }
        if(!empty($location)){
            $this->db->where('loca_name',$location);
        }

        // if(!empty($locationid)){
        //     $this->db->where('trde_locationid',$locationid);
        // }
        if($this->location_ismain=='Y'){
            if(!empty($locationid)){
            $this->db->where('trde_locationid',$locationid);
        }

        }else{
             $this->db->where('trde_locationid',$this->locationid);

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
      
        // $nquery=$this->db->query($sql);
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

    public function generate_stock_location()
    {
        $sql="TRUNCATE table xw_lost_locationstock;";
        $nquery=$this->db->query($sql);

        $sql1="
        INSERT INTO xw_lost_locationstock(lost_itemid, lost_itemcode, lost_itemname,  lost_stockqty, lost_locationid,lost_storeid)
        SELECT
        td.trde_itemsid AS lost_itemid,
        il.itli_itemcode AS lost_itemcode,
        il.itli_itemname AS lost_itemname,  
        sum(td.trde_issueqty) AS lost_stockqty,
        td.trde_locationid AS trde_locationid,
        tm.trma_fromdepartmentid AS lost_storeid
        FROM
        xw_trma_transactionmain tm
        LEFT JOIN xw_trde_transactiondetail td ON tm.trma_trmaid = td.trde_trmaid
        LEFT JOIN xw_itli_itemslist il on il.itli_itemlistid=td.trde_itemsid
        WHERE
        td.trde_issueqty > 0
                AND tm.trma_received = '1'
                AND td.trde_status = 'O'
            
        GROUP BY
            `td`.`trde_itemsid`,
            `td`.`trde_locationid`,
             tm.trma_fromdepartmentid
        ORDER BY  `td`.`trde_itemsid`;";
         $nquery=$this->db->query($sql1);
       
    }

  public function generate_temp_stock_location()
    {
        $itemlst=$this->input->post('itemlist');
        // echo "<pre>";
        // print_r($itemlst);
        // die();
        $itemArray=implode(',', $itemlst);

        // echo $itemArray;
        // die();

        $sql="TRUNCATE table xw_tels_templocationstock;";
        $nquery=$this->db->query($sql);
        $select_qry=" SELECT
        td.trde_itemsid AS tels_itemid,
        il.itli_itemcode AS tels_itemcode,
        il.itli_itemname AS tels_itemname,  
        sum(td.trde_issueqty) AS tels_stockqty,
        td.trde_locationid AS tels_locationid,
        tm.trma_fromdepartmentid AS tels_storeid
        FROM
        xw_itli_itemslist il 
        LEFT JOIN xw_trde_transactiondetail td  ON il.itli_itemlistid = td.trde_itemsid
        LEFT JOIN xw_trma_transactionmain tm
        ON tm.trma_trmaid = td.trde_trmaid
        WHERE
        -- td.trde_issueqty > 0 AND 
                tm.trma_received = '1'
                AND td.trde_status = 'O'
                AND td.trde_itemsid IN($itemArray)
            
        GROUP BY
            `td`.`trde_itemsid`,
            `td`.`trde_locationid`,
             tm.trma_fromdepartmentid
        ORDER BY  `td`.`trde_itemsid`";

        // echo $select_qry;
        // die();

        $sql1="
        INSERT INTO xw_tels_templocationstock(tels_itemid, tels_itemcode, tels_itemname,  tels_stockqty, tels_locationid,tels_storeid)
       $select_qry ";
        // echo $sql1;
        // die();
         $nquery=$this->db->query($sql1);
       
    }

    public function get_distinct_location_from_store()
    {
        $locationid=$this->input->post('locationid');
        if($this->location_ismain=='Y')
        {
            if(!empty($locationid))
            {
                // $this->db->where('lost_locationid',$locationid);
                $con= " WHERE lost_locationid = '$locationid'";
            }else{
                 $con= " ";
            }

        }else{
            $con= "WHERE lost_locationid = '$this->locationid'";
        }
        $sql="SELECT
        DISTINCT(lost_locationid) as locid , loc.loca_name FROM xw_lost_locationstock ls 
            INNER JOIN xw_loca_location loc on loc.loca_locationid=ls.lost_locationid 
            AND loca_isactive='Y'  $con GROUP by lost_locationid ";
       
         $nquery=$this->db->query($sql);
         // echo $this->db->last_query();die;
         $num_row=$nquery->num_rows();
        if($num_row>0){
            $ndata=$nquery->result();
            return $ndata;
        }
        return 0;
    }

    public function get_stock_location_lists($queryloc)
    {
        $get = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }
        $whr='';

        if(!empty($get['sSearch_1'])){
          
            $whr .=" AND  lost_itemcode like  '%".$get['sSearch_1']."%' "; 
        }
        if(!empty($get['sSearch_2'])){
            
              $whr .=" AND lost_itemname like  '%".$get['sSearch_2']."%'  OR lost_itemname like  '%".$get['sSearch_2']."%'   "; 
        }

        $store_id = !empty($get['store_id'])?$get['store_id']:$this->input->post('store_id');
        $locationid = !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');
        
        $items = !empty($get['items'])?$get['items']:$this->input->post('items');
       
        if($store_id)
        {
            $whr .=" AND lost_storeid= $store_id"; 
        }
        if($this->location_ismain=='Y'){
            if(!empty($locationid)){
                 $whr .="AND lost_locationid = $locationid"; 

            }else{
                 $whr .=" ";

            }
        }
        else{
            $whr .="AND lost_locationid = $this->locationid"; 

        }
        $sql ="SELECT COUNT(DISTINCT(ls.lost_itemid)) AS cnt  FROM xw_lost_locationstock ls WHERE  ls.lost_itemid IS NOT NULL $whr ";
                    // echo $sql;
                    // die();
        $query=$this->db->query($sql);
         // echo $this->db->last_query();die();
        if($query->num_rows() > 0) 
        {
            $data=$query->row();     
            $totalfilteredrecs=  $data->cnt;       
        }
        $order_by = 'lost_itemname';
        $order = 'asc';
  
        $where='';
        if($this->input->get('iSortCol_0')==1)
            $order_by = 'lost_itemcode';
        else if($this->input->get('iSortCol_0')==2)
            $order_by = 'lost_itemname';           
        
        $totalrecs='';
        $limit = 15;
        $offset = 1;
        $get = $_GET;
 
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }
         $locationid = !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');
      
        if(!empty($_GET["iDisplayLength"])){
           $limit = $_GET['iDisplayLength'];
           $offset = 0; $_GET["iDisplayStart"];
        }
        $whr='';

          if(!empty($get['sSearch_1'])){ 
            $whr .=" AND  lost_itemcode like  '%".$get['sSearch_1']."%' "; 
        }

        if(!empty($get['sSearch_2'])){
            
              $whr .=" AND lost_itemname like  '%".$get['sSearch_2']."%'  OR lost_itemname like  '%".$get['sSearch_2']."%'  "; 
        }
        if($store_id)
        {
            $whr .=" AND lost_storeid= $store_id"; 
        }
        if($this->location_ismain=='Y'){
            if(!empty($locationid)){
                 $whr .="AND lost_locationid = $locationid"; 

            }else{
                 $whr .=" ";

            }
        }
        else{
            $whr .="AND lost_locationid = $this->locationid"; 

        }

        $sql1="SELECT ls.lost_itemid, ls.lost_itemname, ls.lost_itemcode,ls.lost_locationid, $queryloc FROM  xw_lost_locationstock ls WHERE
             ls.lost_itemid IS NOT NULL $whr
            GROUP BY ls.lost_itemid LIMIT $limit OFFSET $offset";

            // echo $sql1;
            // die();

        $nquery=$this->db->query($sql1);
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

    public function get_stock_locationwise_lists($queryloc)
    {
        $get = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }
        $whr='';

        if(!empty($get['sSearch_1'])){
          
            $whr .=" AND  tels_itemcode like  '%".$get['sSearch_1']."%' "; 
        }
        if(!empty($get['sSearch_2'])){
            
              $whr .=" AND tels_itemname like  '%".$get['sSearch_2']."%'  OR lost_itemname like  '%".$get['sSearch_2']."%'   "; 
        }

        $store_id = !empty($get['store_id'])?$get['store_id']:$this->input->post('store_id');
        $locationid = !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');
        
        $items = !empty($get['items'])?$get['items']:$this->input->post('items');
       
        if($store_id)
        {
            $whr .=" AND tels_storeid= $store_id"; 
        }
        if($this->location_ismain=='Y'){
            if(!empty($locationid)){
                 $whr .="AND tels_locationid = $locationid"; 

            }else{
                 $whr .=" ";

            }
        }
        else{
            $whr .="AND tels_locationid = $this->locationid"; 

        }
        $sql ="SELECT COUNT(DISTINCT(ls.tels_itemid)) AS cnt  FROM xw_tels_templocationstock ls WHERE  ls.tels_itemid IS NOT NULL $whr ";
                    // echo $sql;
                    // die();
        $query=$this->db->query($sql);
         // echo $this->db->last_query();die();
        if($query->num_rows() > 0) 
        {
            $data=$query->row();     
            $totalfilteredrecs=  $data->cnt;       
        }
        $order_by = 'tels_itemname';
        $order = 'asc';
  
        $where='';
        if($this->input->get('iSortCol_0')==1)
            $order_by = 'tels_itemcode';
        else if($this->input->get('iSortCol_0')==2)
            $order_by = 'tels_itemname';           
        
        $totalrecs='';
        $limit = 15;
        $offset = 0;
        $get = $_GET;
 
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }
         $locationid = !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');
      
        if(!empty($_GET["iDisplayLength"])){
           $limit = $_GET['iDisplayLength'];
           $offset = 0; $_GET["iDisplayStart"];
        }
        $whr='';

          if(!empty($get['sSearch_1'])){ 
            $whr .=" AND  tels_itemcode like  '%".$get['sSearch_1']."%' "; 
        }

        if(!empty($get['sSearch_2'])){
            
              $whr .=" AND tels_itemname like  '%".$get['sSearch_2']."%'  OR tels_itemname like  '%".$get['sSearch_2']."%'  "; 
        }
        if($store_id)
        {
            $whr .=" AND tels_storeid= $store_id"; 
        }
        if($this->location_ismain=='Y'){
            if(!empty($locationid)){
                 $whr .="AND tels_locationid = $locationid"; 

            }else{
                 $whr .=" ";

            }
        }
        else{
            $whr .="AND tels_locationid = $this->locationid"; 

        }

        $sql1="SELECT ls.tels_itemid, ls.tels_itemname, ls.tels_itemcode,ls.tels_locationid, $queryloc FROM  xw_tels_templocationstock ls WHERE
             ls.tels_itemid IS NOT NULL $whr
            GROUP BY ls.tels_itemid LIMIT $limit OFFSET $offset";

            // echo $sql1;
            // die();

        $nquery=$this->db->query($sql1);
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

public function get_current_stock_detail($cat_id=false)
  {
    $locid=$this->input->post('locationid');
    $storid=$this->input->post('store_id');
    $catid=$this->input->post('catid');
    $fromdate = $this->input->post('fromdate');
    $todate = $this->input->post('todate');
    $mattypeid=$this->input->post('mattypeid');
    $search_date_type =$this->input->post('searchDateType');

    $cond='';
    if($locid)
    {
        $cond.=" AND trma_locationid =$locid";
    }
    if($storid)
    {
        $cond.=" AND trma_fromdepartmentid =$storid";
    }
    if($catid)
    {
        $cond.= " AND eq.eqca_equipmentcategoryid =$catid";
    }
    if($cat_id)
    {
         $cond.= " AND il.itli_catid= $cat_id";
    }
    else
    {
         $cond.=" AND il.itli_catid IS NULL ";
    }
    if (!empty($search_date_type)) {
        if ($search_date_type == 'date_range' && $fromdate &&  $todate) {
            if(DEFAULT_DATEPICKER=='NP')
            {
               $cond.=" AND trma_transactiondatebs >= '$fromdate' AND trma_transactiondatebs <= '$todate'";
              
            }
            else
            {
             
              $cond.=" AND trma_transactiondatead >= '$fromdate' AND trma_transactiondatead <= '$todate'";
            }
        }
    }else{
    if($fromdate &&  $todate){
            if(DEFAULT_DATEPICKER=='NP')
            {
               $cond.=" AND trma_transactiondatebs >= '$fromdate' AND trma_transactiondatebs <= '$todate'";
              
            }
            else
            {
             
              $cond.=" AND trma_transactiondatead >= '$fromdate' AND trma_transactiondatead <= '$todate'";
            }
        }

    }

          if(!empty($mattypeid)){
            $cond.= " AND il.itli_typeid =$mattypeid ";
    }
        // echo INVENTORY_VALUATION;
        // die();

        if(defined('INVENTORY_VALUATION')){
            if(INVENTORY_VALUATION=='FIFO' || INVENTORY_VALUATION=='LIFO' ){
                 $data= $this->db->query('SELECT eq.eqca_category,tm.trma_transactiondatebs,tm.trma_transactiondatead,il.itli_itemname,il.itli_itemnamenp,il.itli_itemcode,td.trde_itemsid,SUM(td.trde_issueqty)trde_issueqty,td.trde_unitprice,(sum(td.trde_issueqty)*td.trde_unitprice) tamount from xw_trma_transactionmain tm LEFT JOIN xw_trde_transactiondetail td on td.trde_trmaid=tm.trma_trmaid
                  LEFT JOIN xw_itli_itemslist il on il.itli_itemlistid=td.trde_itemsid
                  LEFT JOIN xw_eqca_equipmentcategory eq ON eq.eqca_equipmentcategoryid = il.itli_catid
                  WHERE tm.trma_received = "1"
                  AND td.trde_status = "O"
                  AND td.trde_issueqty >0 '.$cond.'  
                  AND td.trde_itemsid IS NOT NULL
                   GROUP BY il.itli_itemname,td.trde_itemsid, td.trde_unitprice
                  ORDER BY eq.eqca_category ASC, itli_itemname ASC')->result();
            }
             if(INVENTORY_VALUATION=='AVERAGE_WEIGHTED'){
                 $data= $this->db->query('SELECT eq.eqca_category,tm.trma_transactiondatebs,tm.trma_transactiondatead,il.itli_itemname,il.itli_itemnamenp,il.itli_itemcode,td.trde_itemsid,SUM(td.trde_issueqty) trde_issueqty,SUM(td.trde_issueqty*td.trde_unitprice)/SUM(td.trde_issueqty) trde_unitprice,SUM(td.trde_issueqty)*(SUM(td.trde_issueqty*td.trde_unitprice)/SUM(td.trde_issueqty)) tamount from xw_trma_transactionmain tm LEFT JOIN xw_trde_transactiondetail td on td.trde_trmaid=tm.trma_trmaid
                  LEFT JOIN xw_itli_itemslist il on il.itli_itemlistid=td.trde_itemsid
                  LEFT JOIN xw_eqca_equipmentcategory eq ON eq.eqca_equipmentcategoryid = il.itli_catid
                  WHERE tm.trma_received = "1"
                  AND td.trde_status = "O"
                  AND td.trde_issueqty >0 '.$cond.'  
                  AND td.trde_itemsid IS NOT NULL
                   GROUP BY il.itli_itemname,td.trde_itemsid
                  ORDER BY eq.eqca_category ASC, itli_itemname ASC')->result();
            }
        }
        else{
              $data= $this->db->query('SELECT eq.eqca_category,tm.trma_transactiondatebs,tm.trma_transactiondatead,il.itli_itemname,il.itli_itemnamenp,il.itli_itemcode,td.trde_itemsid,SUM(td.trde_issueqty)trde_issueqty,td.trde_unitprice,(sum(td.trde_issueqty)*td.trde_unitprice) tamount from xw_trma_transactionmain tm LEFT JOIN xw_trde_transactiondetail td on td.trde_trmaid=tm.trma_trmaid
      LEFT JOIN xw_itli_itemslist il on il.itli_itemlistid=td.trde_itemsid
      LEFT JOIN xw_eqca_equipmentcategory eq ON eq.eqca_equipmentcategoryid = il.itli_catid
      WHERE tm.trma_received = "1"
      AND td.trde_status = "O"
      AND td.trde_issueqty >0 '.$cond.'  
      AND td.trde_itemsid IS NOT NULL
       GROUP BY il.itli_itemname,td.trde_itemsid, td.trde_unitprice
      ORDER BY eq.eqca_category ASC, itli_itemname ASC')->result();
        }

   // echo $this->db->last_query();die;
   return $data;

  }

  public function get_current_stock_detail_format2($cat_id=false)
  {
    $locid=$this->input->post('locationid');
    $storid=$this->input->post('store_id');
    $catid=$this->input->post('catid');
    $fromdate = $this->input->post('fromDate');
    $todate = $this->input->post('toDate');
    $cond='';
    $cond1='';
    $cond2='';
    $cond3='';

    if($locid)
    {  
         $cond.=  " AND trma_locationid =$locid";
       
    }
    if($storid)
    {
        $cond.=" AND trma_fromdepartmentid =$storid";
    }
    // if($catid)
    // {
    //     $cond.= " AND eq.eqca_equipmentcategoryid =$catid";
           
    // }
    // if($cat_id)
    // {
    //      $cond.= " AND il.itli_catid= $cat_id";
         
    // }
    // else
    // {
    //      $cond.=" AND il.itli_catid IS NULL ";
    // }
    $cond2 .= $cond;

    if($fromdate &&  $todate){
        $cond1 .= $cond;
        $cond1 .= " AND trma_transactiondatebs < '$fromdate'";
        $cond3 .= $cond;
        $cond3 .= " AND trma_transactiondatebs > '$todate'";

            if(DEFAULT_DATEPICKER=='NP')
            {
               $cond.=" AND trma_transactiondatebs >= '$fromdate' AND trma_transactiondatebs <= '$todate'";
              
            }
            else
            {
             
              $cond.=" AND trma_transactiondatead >= '$fromdate' AND trma_transactiondatead <= '$todate'";
            }
        }
        // echo INVENTORY_VALUATION;
        // die();

        // if(defined('INVENTORY_VALUATION')){
        //     if(INVENTORY_VALUATION=='FIFO'){
        //          $data= $this->db->query('SELECT eq.eqca_category,tm.trma_transactiondatebs,tm.trma_transactiondatead,il.itli_itemname,il.itli_itemnamenp,td.trde_itemsid,SUM(td.trde_issueqty)trde_issueqty,td.trde_unitprice,(sum(td.trde_issueqty)*td.trde_unitprice) tamount from xw_trma_transactionmain tm LEFT JOIN xw_trde_transactiondetail td on td.trde_trmaid=tm.trma_trmaid
        //           LEFT JOIN xw_itli_itemslist il on il.itli_itemlistid=td.trde_itemsid
        //           LEFT JOIN xw_eqca_equipmentcategory eq ON eq.eqca_equipmentcategoryid = il.itli_catid
        //           WHERE tm.trma_received = "1"
        //           AND td.trde_status = "O"
        //           AND td.trde_issueqty >0 '.$cond.'  
        //           AND td.trde_itemsid IS NOT NULL
        //            GROUP BY il.itli_itemname,td.trde_itemsid, td.trde_unitprice
        //           ORDER BY eq.eqca_category ASC, itli_itemname ASC')->result();
        //     }
        //      if(INVENTORY_VALUATION=='AVERAGE_WEIGHTED'){
        //          $data= $this->db->query('SELECT eq.eqca_category,tm.trma_transactiondatebs,tm.trma_transactiondatead,il.itli_itemname,il.itli_itemnamenp,td.trde_itemsid,SUM(td.trde_issueqty) trde_issueqty,SUM(td.trde_issueqty*td.trde_unitprice)/SUM(td.trde_issueqty) trde_unitprice,SUM(td.trde_issueqty)*(SUM(td.trde_issueqty*td.trde_unitprice)/SUM(td.trde_issueqty)) tamount from xw_trma_transactionmain tm LEFT JOIN xw_trde_transactiondetail td on td.trde_trmaid=tm.trma_trmaid
        //           LEFT JOIN xw_itli_itemslist il on il.itli_itemlistid=td.trde_itemsid
        //           LEFT JOIN xw_eqca_equipmentcategory eq ON eq.eqca_equipmentcategoryid = il.itli_catid
        //           WHERE tm.trma_received = "1"
        //           AND td.trde_status = "O"
        //           AND td.trde_issueqty >0 '.$cond.'  
        //           AND td.trde_itemsid IS NOT NULL
        //            GROUP BY il.itli_itemname,td.trde_itemsid
        //           ORDER BY eq.eqca_category ASC, itli_itemname ASC')->result();
        //     }
        // }
        // else{
              $data= $this->db->query('SELECT trde_itemsid, il.itli_itemname, trde_unitprice, SUM(trde_opening_qty) trde_opening_qty, SUM(trde_range_qty) trde_range_qty, SUM(trde_range_out_qty) trde_range_out_qty, SUM(trde_curqty) as trde_curqty FROM( SELECT td.trde_itemsid, SUM(td.trde_issueqty) trde_opening_qty, 0 as trde_range_qty, 0 as trde_range_out_qty, 0 as trde_curqty, td.trde_unitprice FROM xw_trma_transactionmain tm LEFT JOIN xw_trde_transactiondetail td ON td.trde_trmaid = tm.trma_trmaid WHERE tm.trma_received = "1" AND td.trde_status = "O" AND td.trde_issueqty > 0 
                '.$cond1.' 
                AND td.trde_itemsid IS NOT NULL GROUP BY td.trde_itemsid, td.trde_unitprice          
                UNION 
                SELECT td.trde_itemsid, 0 as trde_opening_qty, SUM(td.trde_issueqty) trde_range_qty, 0 as trde_range_out_qty, 0 as trde_curqty, td.trde_unitprice FROM xw_trma_transactionmain tm LEFT JOIN xw_trde_transactiondetail td ON td.trde_trmaid = tm.trma_trmaid WHERE tm.trma_received = "1" AND td.trde_status = "O" AND td.trde_issueqty > 0 '.$cond.'  AND td.trde_itemsid IS NOT NULL GROUP BY td.trde_itemsid, td.trde_unitprice 
                UNION 
                SELECT td.trde_itemsid, 0 trde_opening_qty, 0 as trde_range_qty, SUM(td.trde_issueqty) as trde_range_out_qty, 0 as trde_curqty, td.trde_unitprice FROM xw_trma_transactionmain tm LEFT JOIN xw_trde_transactiondetail td ON td.trde_trmaid = tm.trma_trmaid WHERE tm.trma_received = "1" AND td.trde_status = "O" AND td.trde_issueqty > 0 '.$cond2.'  AND td.trde_itemsid IS NOT NULL GROUP BY td.trde_itemsid, td.trde_unitprice 
                UNION 
                SELECT td.trde_itemsid, 0 as trde_opening_qty, 0 as trde_range_qty, 0 as trde_range_out_qty, SUM(td.trde_issueqty) trde_curqty, td.trde_unitprice FROM xw_trma_transactionmain tm LEFT JOIN xw_trde_transactiondetail td ON td.trde_trmaid = tm.trma_trmaid WHERE tm.trma_received = "1" AND td.trde_status = "O" AND td.trde_issueqty > 0 '.$cond3.'  AND td.trde_itemsid IS NOT NULL GROUP BY td.trde_itemsid, td.trde_unitprice ) X 
                LEFT JOIN xw_itli_itemslist il ON il.itli_itemlistid = X.trde_itemsid WHERE  il.itli_catid= '.$cat_id.' GROUP BY X.trde_itemsid,il.itli_itemname,trde_unitprice')->result();
        // }
   // echo $this->db->last_query();die;
   return $data;
  }

  public function distinct_category()
  {

    $locid=$this->input->post('locationid');
    $storid=$this->input->post('store_id');
    $catid=$this->input->post('catid');
    $fromdate = $this->input->post('fromDate');
    $todate = $this->input->post('toDate');
    $mattypeid=$this->input->post('mattypeid');
    // echo $todate;die;

    $cond='';
  if($this->location_ismain=='Y'){
    if($locid)
    {
        $cond.=" AND trma_locationid =$locid";
    }
    }
    else{
        $cond.=" AND trma_locationid =$this->locationid";
    }

    if($storid)
    {
        $cond.=" AND trma_fromdepartmentid =$storid";
    }
    if($catid)
    {
        $cond.= " AND eq.eqca_equipmentcategoryid =$catid";
    }
    if($fromdate &&  $todate){
            if(DEFAULT_DATEPICKER=='NP')
            {
               $cond.=" AND trma_transactiondatebs >= '$fromdate' AND trma_transactiondatebs <= '$todate'";
              
            }
            else
            {
             
              $cond.=" AND trma_transactiondatead >= '$fromdate' AND trma_transactiondatead <= '$todate'";
            }
        }

        if(!empty($mattypeid)){
            // $cond.= " AND il.itli_typeid = $mattypeid ";
            $cond.= " AND il.itli_materialtypeid = $mattypeid ";
    }

     $data= $this->db->query('SELECT DISTINCT(eqca_equipmentcategoryid)eqca_equipmentcategoryid ,eqca_category,trma_transactiondatebs,trma_transactiondatead FROM( SELECT eq.eqca_equipmentcategoryid,eq.eqca_category,tm.trma_transactiondatebs,tm.trma_transactiondatead,il.itli_itemname,il.itli_itemnamenp,td.trde_itemsid,SUM(td.trde_issueqty)trde_issueqty,td.trde_unitprice,(td.trde_issueqty*td.trde_unitprice) tamount from xw_trma_transactionmain tm LEFT JOIN xw_trde_transactiondetail td on td.trde_trmaid=tm.trma_trmaid 
        LEFT JOIN xw_itli_itemslist il on il.itli_itemlistid=td.trde_itemsid
        LEFT JOIN xw_eqca_equipmentcategory eq ON eq.eqca_equipmentcategoryid = il.itli_catid
        WHERE
        tm.trma_received = "1"
        AND td.trde_status = "O"
        AND td.trde_issueqty >0 '.$cond.'  
        AND td.trde_itemsid IS NOT NULL
        GROUP BY il.itli_itemname,td.trde_itemsid, td.trde_unitprice
        )X WHERE eqca_equipmentcategoryid IS NOT NULL  GROUP BY eqca_equipmentcategoryid ORDER by eqca_category ASC')->result();
     // echo  $this->db->last_query();die;
   return $data;
  }

  public function stock_generate_by_date($type = false,$category_id = false)
    {
    $locid=$this->input->post('locationid');
    $mattypeid='';//$this->input->post('mattypeid');
    $searchtype=$this->input->post('searchDateType');
    $storeid=$this->input->post('store_id');
    $catid=$this->input->post('catid');
    $fromdate = $this->input->post('fromdate');
    $todate = $this->input->post('todate');
    $itemid=$this->input->post('itemid');

    if($type == 'generate_table'){
      // $this->db->query("DROP TABLE xw_temp_stockrec");  
    if(!$this->db->table_exists('xw_temp_stockrec')){
      $create_stockrecord_table = "CREATE TABLE xw_temp_stockrec  (
      id BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      date VARCHAR(15),
      itemid BIGINT(15),
      vatpc INT(10),
      qty DECIMAL(15,2),
      rate DECIMAL(15,2),
      total_amt DECIMAL(15,2),
      type VARCHAR(15),
      locationid INT(15),
      orgid INT(15)
      )";
      $this->db->query($create_stockrecord_table);      
    }
    $this->db->query("TRUNCATE TABLE xw_temp_stockrec");

    $condiss1 ='';
    $condiss2 ='';
    $condrec ='';
    $conditem='';
    $cond_trde='';
    // if($searchtype=='date_range'){
      if($fromdate && $todate){
        if(DEFAULT_DATEPICKER=='NP'){
          $condiss1 .= " AND sm.sama_billdatebs < '".$fromdate."' ";
          $condiss2 .= " AND sm.sama_billdatebs >='".$fromdate."' AND sm.sama_billdatebs<='".$todate."' ";
          $condrec .=" AND tm.trma_transactiondatebs >='".$fromdate."' AND tm.trma_transactiondatebs <='".$todate."' ";
         
        }  
      }
      
    // }

    if($storeid){
      $condiss1 .= " AND sm.sama_storeid =$storeid ";
      $condiss2 .= " AND sm.sama_storeid =$storeid ";
      $condrec .= " AND  tm.trma_fromdepartmentid =$storeid ";
    }

    if($mattypeid){
       $condiss1 .= ' AND itli_materialtypeid ='.$mattypeid.'';
        $condiss2 .= ' AND itli_materialtypeid ='.$mattypeid.'';
        $condrec .= ' AND itli_materialtypeid ='.$mattypeid.'';
    }

    if(!empty($locid)){
       $condiss1 .= ' AND sm.sama_locationid ='.$locid.'';
      $condiss2 .= ' AND sm.sama_locationid ='.$locid.'';
      $condrec .= ' AND tm.trma_locationid ='.$locid.'';
    }

    if(!empty($itemid)){
       $condiss1 .= ' AND itli_itemlistid ='.$itemid.'';
        $condiss2 .= ' AND itli_itemlistid ='.$itemid.'';
        $condrec .= ' AND itli_itemlistid ='.$itemid.'';
        $conditem .=' AND itli_itemlistid ='.$itemid.'';
        $cond_trde .= ' AND itli_itemlistid ='.$itemid.'';
    }

     if(empty($locid)){
      $locid="''";
    }

  $sql_opening="SELECT
  itemid,
  vatpc,
  SUM(pqty)- SUM(iqty) AS qty,
  rate,
  (SUM(ptotal_amt)/ SUM(pqty))*(SUM(pqty-iqty)) total_amt,
  'OPENING' as type,
  $locid as locationid
FROM
  (
    SELECT
      trde_itemsid itemid,
      rd.recd_vatpc as vatpc,
      SUM(td.trde_requiredqty) pqty,
      SUM(
        td.trde_requiredqty * rd.recd_unitprice
            ) / SUM(td.trde_requiredqty) as rate,
     SUM(td.trde_requiredqty) * (
                SUM(
                    td.trde_requiredqty * rd.recd_unitprice
                ) / SUM(td.trde_requiredqty)
            ) ptotal_amt,
      0 AS iqty,
      0 AS itotal_amt
    FROM
      xw_trma_transactionmain tm
    LEFT JOIN xw_trde_transactiondetail td ON td.trde_trmaid = tm.trma_trmaid
    LEFT JOIN xw_recd_receiveddetail rd ON rd.recd_receiveddetailid = td.trde_mtdid
    LEFT JOIN xw_itli_itemslist il ON il.itli_itemlistid = td.trde_itemsid
    WHERE
      td.trde_status = 'O'
    AND tm.trma_status = 'O'
    AND tm.trma_received = '1'
   AND tm.trma_transactiondatebs < '".$fromdate."' 
   $cond_trde
    GROUP BY
      trde_itemsid
    UNION
      SELECT
      sd.sade_itemsid itemid,
      rd.recd_vatpc as vatpc,
        0 AS pqty,
        0 AS rate,
        0 AS ptotal_amt,
        SUM(sd.sade_curqty) iqty,
        
        SUM(sd.sade_curqty) * (
                SUM(
                    sd.sade_curqty * rd.recd_unitprice
                ) / SUM(sd.sade_curqty)
            ) itotal_amt
        FROM
        xw_sama_salemaster sm
      LEFT JOIN xw_sade_saledetail sd ON sd.sade_salemasterid = sm.sama_salemasterid
      LEFT JOIN xw_trde_transactiondetail td ON td.trde_trdeid = sd.sade_mattransdetailid
            LEFT JOIN xw_recd_receiveddetail rd ON rd.recd_receiveddetailid = td.trde_mtdid
      LEFT JOIN xw_itli_itemslist il ON il.itli_itemlistid = sd.sade_itemsid
            LEFT JOIN xw_eqca_equipmentcategory eq ON eq.eqca_equipmentcategoryid = il.itli_catid
      WHERE
      td.trde_status = 'O' 
        AND sm.sama_status = 'O'
        AND sm.sama_st != 'C'
       $condiss1
      GROUP BY
        sd.sade_itemsid
  ) X 
GROUP BY
  X.itemid HAVING SUM(pqty)>SUM(iqty)";

       // echo $sql_opening;
       // die();

      $result_open=$this->db->query($sql_opening)->result();
      // echo "<pre>";
      // print_r( $result);
      // die();

      if(!empty($result_open)){
        $this->db->insert_batch('temp_stockrec',$result_open);
      }

      $sql_purchase="SELECT
            td.trde_itemsid as itemid,
            rd.recd_vatpc as vatpc,
            SUM(td.trde_requiredqty) AS qty,
            SUM(
                            td.trde_requiredqty * rd.recd_unitprice
                        ) / SUM(td.trde_requiredqty) AS rate,
           SUM(td.trde_requiredqty) * (
                SUM(
                    td.trde_requiredqty * rd.recd_unitprice
                        ) / SUM(td.trde_requiredqty))
                     AS total_amt,
           'PURCHASE' as type,
           $locid as locationid
          FROM xw_trde_transactiondetail td
          LEFT JOIN xw_recd_receiveddetail rd ON rd.recd_receiveddetailid = td.trde_mtdid
          LEFT JOIN  xw_itli_itemslist il  ON td.trde_itemsid = il.itli_itemlistid
          LEFT JOIN xw_trma_transactionmain tm ON tm.trma_trmaid = td.trde_trmaid
          WHERE
          tm.trma_status = 'O'
          AND td.trde_status='O'
          AND tm.trma_received='1'
          $condrec 
          GROUP BY
            td.trde_itemsid " ;

            // echo $sql_purchase;
            // die();

    $result_purchase=$this->db->query($sql_purchase)->result();

    if(!empty($result_purchase)){
      $this->db->insert_batch('temp_stockrec',$result_purchase);
    }

    $sql_issue=" SELECT
                sd.sade_itemsid as itemid,
                recd_vatpc as vatpc,
                SUM(sade_curqty) qty,
                SUM(sade_curqty * rd.recd_unitprice) / SUM(sade_curqty) as rate,
                SUM(sd.sade_curqty * rd.recd_unitprice) / SUM(sd.sade_curqty) AS total_amt,
                'ISSUE' as type,
                $locid as locationid
                FROM
                xw_sade_saledetail sd 
                LEFT JOIN xw_trde_transactiondetail td ON td.trde_trdeid = sd.sade_mattransdetailid
                LEFT JOIN xw_recd_receiveddetail rd ON rd.recd_receiveddetailid = td.trde_mtdid 
                LEFT JOIN xw_itli_itemslist il  ON sd.sade_itemsid = il.itli_itemlistid
                LEFT JOIN xw_sama_salemaster sm ON sm.sama_salemasterid = sd.sade_salemasterid
                WHERE
                td.trde_status = 'O' AND
                 sm.sama_status = 'O'
                 AND sm.sama_st != 'C'
                $condiss2
                    GROUP BY
                sd.sade_itemsid";

            // echo $sql_issue;
            // die()

             $result_issue=$this->db->query($sql_issue)->result();
      // echo "<pre>";;
      // print_r( $result_issue);
      // die();

      if(!empty($result_issue)){
        $this->db->insert_batch('temp_stockrec',$result_issue);
      }  

      return true;    
    }

    if($type == 'get_stock_data'){
      $category_condition = '';
     if(!empty($category_id)){
      $category_condition = " WHERE itli_catid = $category_id ";
     }
    $sql_final="SELECT * FROM (SELECT itemid,il.itli_itemcode,il.itli_itemname, ut.unit_unitname,vatpc as recd_vatpc,
                SUM(opqty) as opqty,SUM(opamt)/SUM(opqty) as oprate,SUM(opamt) opamt,
                SUM(purqty) as purqty,SUM(puramt)/SUM(purqty) as purrate,SUM(puramt) puramt ,
                SUM(issqty) as issqty,SUM(issamt)/SUM(issqty) as issrate,SUM(issamt) issamt,
                SUM( (opqty + purqty) - issqty) trde_issueqty,
                SUM( (opamt + puramt) - issamt) balanceamt,
                rate as trde_unitprice  
                FROM (
                SELECT itemid, vatpc,rate,
                SUM(qty) as opqty,SUM(total_amt)/SUM(qty) as oprate,SUM(total_amt) opamt,
                0 as purqty,0 as purrate,0 as puramt,
                0 as issqty,0 as issrate,0 as issamt 
                FROM xw_temp_stockrec
                WHERE type='OPENING'
                GROUP BY itemid 
                UNION
                SELECT itemid,vatpc,rate,
                0 as opqty,0 as oprate,0 as opamt,  
                SUM(qty) as purqty,SUM(total_amt)/SUM(qty) as purrate,SUM(total_amt) puramt ,
                0 as issqty,0 as issrate,0 as issamt 
                FROM xw_temp_stockrec
                WHERE type='PURCHASE'
                GROUP BY itemid 
                UNION
                SELECT itemid,vatpc,rate,
                0 as opqty,0 as oprate,0 as opamt,  
                0 as purqty,0 as purrate,0 as puramt,
                SUM(qty) as issqty,SUM(total_amt)/SUM(qty) as issrate,SUM(total_amt) issamt 
                FROM xw_temp_stockrec
                WHERE type='ISSUE'
                GROUP BY itemid 
                ) X LEFT JOIN xw_itli_itemslist il on il.itli_itemlistid=X.itemid LEFT JOIN xw_unit_unit ut on ut.unit_unitid=il.itli_unitid
                $category_condition
                GROUP BY X.itemid
                ORDER BY il.itli_itemname ASC ) Y HAVING trde_issueqty > 0;
                ";
        $result_final=$this->db->query($sql_final)->result();
        // echo $this->db->last_query();
        // die();
        if(!empty($result_final)){
          return $result_final;
        }
    }
    return false;

    }
}