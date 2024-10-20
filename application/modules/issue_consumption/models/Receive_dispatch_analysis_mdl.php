<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Receive_dispatch_analysis_mdl extends CI_Model
{
    public function __construct()
    {
    parent::__construct();
    $this->req_noteTable='reno_requisitionnote';
    $this->req_detailNoteTable='redt_reqdetailnote';
    $this->locationid=$this->session->userdata(LOCATION_ID);
    $this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
    }
    public function get_opening_stock_list($cond = false)
    {
    	$category = $this->input->get('category');
		$materialsid = $this->input->get('materialsid');
        $locationid = $this->input->get('locationid');
		$itemsid = $this->input->get('itemsid');
        $unitid = $this->input->get('unitid');
        $get = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }
        

       
        if(!empty($get['sSearch_1'])){
            $this->db->where("lower(itli_itemcode) like  '%".$get['sSearch_1']."%'  ");
        }
        if(!empty($get['sSearch_2'])){
            $this->db->where("lower(itli_itemname) like  '%".$get['sSearch_2']."%'  ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("lower(maty_material) like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("lower(eqca_category) like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("lower(unit_unitname) like  '%".$get['sSearch_5']."%'  ");
        }
        if(!empty($get['sSearch_6'])){
            $this->db->where("lower(trde_requiredqty) like  '%".$get['sSearch_6']."%'  ");
        }
         if(!empty($get['sSearch_7'])){
            $this->db->where("lower(trde_unitprice) like  '%".$get['sSearch_7']."%'  ");
        }
      
        if(!empty($get['sSearch_9'])){
            $this->db->where("lower(sade_qty) like  '%".$get['sSearch_9']."%'  ");
        }
        if(!empty($get['sSearch_10'])){
            $this->db->where("lower(sade_unitrate) like  '%".$get['sSearch_10']."%'  ");
        }
       
        if(!empty($get['sSearch_12'])){
            $this->db->where("lower(loca_name) like  '%".$get['sSearch_12']."%'  ");
        }
        if(!empty($get['sSearch_16'])){
            $this->db->where("lower(seda_remarks) like  '%".$get['sSearch_16']."%'  ");
        }
        if($category)
        {
            $this->db->where(array('ec.eqca_equipmentcategoryid'=>$category));
        }
        if($materialsid)
        {
            $this->db->where(array('mt.maty_materialtypeid'=>$materialsid));
        }
		if($itemsid)
        {
            $this->db->where(array('il.itli_itemlistid'=>$itemsid));
        }
        if($unitid)
        {
            $this->db->where(array('ut.unit_unitid'=>$unitid));
        }
        if($this->location_ismain=='Y'){
            if($locationid)
        {
            $this->db->where(array('lo.loca_locationid'=>$locationid));
        }
      }else{
          $this->db->where(array('lo.loca_locationid'=>$this->locationid));

      }
          if($cond) {
          $this->db->where($cond);
        }
        $this->db->select('COUNT(*) as cnt');
        $this->db->from('trma_transactionmain tm');
        $this->db->join('trde_transactiondetail td','td.trde_trmaid=tm.trma_trmaid','LEFT');
        $this->db->join('sade_saledetail sd','sd.sade_mattransdetailid=td.trde_trdeid','LEFT');
        $this->db->join('sama_salemaster sm','sm.sama_salemasterid=sd.sade_mattransdetailid','LEFT');
        $this->db->join('itli_itemslist il','il.itli_itemlistid=td.trde_itemsid','LEFT');
        $this->db->join('maty_materialtype  mt','mt.maty_materialtypeid=il.itli_typeid','LEFT');
        $this->db->join('eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid= il.itli_catid','LEFT');
        $this->db->join('unit_unit ut','ut.unit_unitid=il.itli_unitid','LEFT');
		$this->db->join('loca_location lo','lo.loca_locationid=sd.sade_locationid','LEFT');
		$this->db->where(array('tm.trma_status'=>'O'));
		$this->db->where(array('sd.sade_iscancel'=>'N'));

        $resltrpt=$this->db->get()->row();
        //echo $this->db->last_query();die(); 
        $totalfilteredrecs=($resltrpt->cnt); 
        $order_by = 'itli_itemname';
        $order = 'ASC';
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
            $order_by = 'maty_material';
        else if($this->input->get('iSortCol_0')==4)
            $order_by = 'eqca_category';
        else if($this->input->get('iSortCol_0')==5)
            $order_by = 'unit_unitname';
         else if($this->input->get('iSortCol_0')==6)
            $order_by = 'receivedqty';
           else if($this->input->get('iSortCol_0')==7)
            $order_by = 'trde_unitprice';
        else if($this->input->get('iSortCol_0')==9)
            $order_by = 'sade_qty';
         else if($this->input->get('iSortCol_0')==10)
            $order_by = 'sade_unitrate';
         else if($this->input->get('iSortCol_0')==12)
            $order_by = 'loca_name';
        else if($this->input->get('iSortCol_0')==16)
            $order_by = 'seda_remarks';
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
            $this->db->where("lower(itli_itemname) like  '%".$get['sSearch_2']."%'  ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("lower(maty_material) like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("lower(eqca_category) like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("lower(unit_unitname) like  '%".$get['sSearch_5']."%'  ");
        }
         if(!empty($get['sSearch_6'])){
            $this->db->where("lower(trde_requiredqty) like  '%".$get['sSearch_6']."%'  ");
        }
        if(!empty($get['sSearch_7'])){
            $this->db->where("lower(trde_unitprice) like  '%".$get['sSearch_7']."%'  ");
        }
        if(!empty($get['sSearch_9'])){
            $this->db->where("lower(sade_qty) like  '%".$get['sSearch_9']."%'  ");
        }
        if(!empty($get['sSearch_10'])){
            $this->db->where("lower(sade_unitrate) like  '%".$get['sSearch_10']."%'  ");
        }
         if(!empty($get['sSearch_12'])){
            $this->db->where("lower(loca_name) like  '%".$get['sSearch_12']."%'  ");
        }
        if(!empty($get['sSearch_16'])){
            $this->db->where("lower(seda_remarks) like  '%".$get['sSearch_16']."%'  ");
        }
     		
        if($category)
        {
            $this->db->where(array('ec.eqca_equipmentcategoryid'=>$category));
        }
        if($materialsid)
        {
            $this->db->where(array('mt.maty_materialtypeid'=>$materialsid));
        }
		if($itemsid)
        {
            $this->db->where(array('il.itli_itemlistid'=>$itemsid));
        }
        if($unitid)
        {
            $this->db->where(array('ut.unit_unitid'=>$unitid));
        }
     if($this->location_ismain=='Y'){
        if($locationid)
         {
             $this->db->where(array('lo.loca_locationid'=>$locationid));
         }
          }else{
            $this->db->where(array('lo.loca_locationid'=>$this->locationid));

          }
        if($cond) {
          $this->db->where($cond);
        }
        $this->db->select('td.trde_itemsid,il.itli_itemcode, il.itli_itemname,mt.maty_material,ut.unit_unitname,ec.eqca_category,
		td.trde_requiredqty as receivedqty ,td.trde_issueqty,td.trde_unitprice,sd.sade_qty as dispatch_qty,sd.sade_unitrate as dispatch_rate,sd.sade_locationid,lo.loca_name as dispatchlocation,sd.sade_remarks');
        $this->db->from('trma_transactionmain tm');
        $this->db->join('trde_transactiondetail td','td.trde_trmaid=tm.trma_trmaid','LEFT');
        $this->db->join('sade_saledetail sd','sd.sade_mattransdetailid=td.trde_trdeid','LEFT');
        $this->db->join('sama_salemaster sm','sm.sama_salemasterid=sd.sade_salemasterid','LEFT');
        $this->db->join('itli_itemslist il','il.itli_itemlistid=td.trde_itemsid','LEFT');
        $this->db->join('maty_materialtype  mt','mt.maty_materialtypeid=il.itli_typeid','LEFT');
        $this->db->join('eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid= il.itli_catid','LEFT');
        $this->db->join('unit_unit ut','ut.unit_unitid=il.itli_unitid','LEFT');
		$this->db->join('loca_location lo','lo.loca_locationid=sd.sade_locationid','LEFT');
		$this->db->where(array('tm.trma_status'=>'O'));
		$this->db->where(array('sd.sade_iscancel'=>'N'));
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
        //echo $this->db->last_query();die();
      return $ndata;

    }
}
