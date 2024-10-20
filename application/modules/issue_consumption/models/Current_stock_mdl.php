<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Current_stock_mdl extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
	}
	public function get_current_stock_lists($cond= false)
	{
		$get = $_GET;
      	foreach ($get as $key => $value) {
        	$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
      	}

        if(!empty($get['sSearch_1'])){
            $this->db->where("lower(lower(itli_it)emcode) like  '%".$get['sSearch_1']."%'  ");
        }
        if(!empty($get['sSearch_2'])){
            $this->db->where("lower(itli_itemname) like  '%".$get['sSearch_2']."%'  ");
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
            $this->db->where("lower(trde_issueqty) like  '%".$get['sSearch_7']."%'  ");
        }
        if(!empty($get['sSearch_8'])){
            $this->db->where("lower(trde_unitprice) like  '%".$get['sSearch_8']."%'  ");
        }
        if(!empty($get['sSearch_9'])){
            $this->db->where("lower(unit_unitname) like  '%".$get['sSearch_9']."%'  ");
        }
        
        if($cond) {
            $this->db->where($cond);
        }

        $store_id = !empty($get['store_id'])?$get['store_id']:$this->input->post('store_id');
        $toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');

        $supplier = !empty($get['supplier'])?$get['supplier']:$this->input->post('supplier');
        
        $items = !empty($get['items'])?$get['items']:$this->input->post('items');
         $locationid = !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');

        if(!empty(($store_id)))
        {  
        	//print_r($store_id);die;
           $this->db->where('c.eqca_equiptypeid',$store_id);
           
        }

        if(!empty($supplier)){
            $this->db->where('supp_supplierid',$supplier);
        }

        if(!empty($items)){
            $this->db->where('itli_itemlistid',$items);
        }
        //  if(!empty($locationid)){
        //  $this->db->where('itli_locationid',$locationid);
        // }
         if($this->location_ismain=='Y')
        {
            if($locationid)
            {
                $this->db->where('itli_locationid',$locationid);
            }
        }
        else
        {
            $this->db->where('itli_locationid',$this->locationid);
        }

        $resltrpt=$this->db->select("COUNT(*) as cnt")
        			->from('trde_transactiondetail sd')
                    ->join('itli_itemslist it', 'it.itli_itemlistid = sd.trde_itemsid', "LEFT")
                    ->join('maty_materialtype mt', 'mt.maty_materialtypeid = it.itli_materialtypeid', "LEFT")
                    ->join('unit_unit u', 'u.unit_unitid = sd.trde_unitprice', "LEFT")
                    ->join('eqca_equipmentcategory c', 'c.eqca_equipmentcategoryid = it.itli_catid', "LEFT")
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
      	 	$order_by = 'eqca_category';
      	else if($this->input->get('iSortCol_0')==4)
      	 	$order_by = 'maty_material';
      	else if($this->input->get('iSortCol_0')==5)
      	 	$order_by = 'itli_maxlimit';
      	else if($this->input->get('iSortCol_0')==6)
      	 	$order_by = 'itli_reorderlevel';
        else if($this->input->get('iSortCol_0')==7)
            $order_by = 'trde_issueqty';
        else if($this->input->get('iSortCol_0')==8)
            $order_by = 'trde_unitprice';
        else if($this->input->get('iSortCol_0')==9)
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
            $this->db->where("lower(itli_itemcode) like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("lower(itli_itemname) like  '%".$get['sSearch_2']."%'  ");
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
            $this->db->where("lower(trde_issueqty) like  '%".$get['sSearch_7']."%'  ");
        }
        if(!empty($get['sSearch_8'])){
            $this->db->where("lower(trde_unitprice) like  '%".$get['sSearch_8']."%'  ");
        }

        if(!empty($get['sSearch_9'])){
            $this->db->where("lower(unit_unitname) like  '%".$get['sSearch_9']."%'  ");
        }
       
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
        // if(!empty($locationid)){
        //     $this->db->where('itli_locationid',$locationid);
        // }
         if($this->location_ismain=='Y')
        {
            if($locationid)
            {
                $this->db->where('it.itli_locationid',$locationid);
            }
        }
        else
        {
            $this->db->where('it.itli_locationid',$this->locationid);
        }
        $this->db->select("mt.maty_material,u.unit_unitname, it.itli_itemname,it.itli_itemcode,it.itli_maxlimit, it.itli_locationid,it.itli_reorderlevel,u.unit_unitname,c.eqca_category,sd.trde_issueqty AS atstock,sd.trde_expdatebs,
	    		(
	    		CASE WHEN (sd.trde_batchno != '') THEN sd.trde_batchno ELSE sd.trde_controlno END ) batchno,(sd.trde_issueqty * sd.trde_unitprice) as amount,sd.trde_unitprice");
		$this->db->from('trde_transactiondetail sd');
		$this->db->join('itli_itemslist it', 'it.itli_itemlistid = sd.trde_itemsid', "LEFT");
			$this->db->join('maty_materialtype mt', 'mt.maty_materialtypeid = it.itli_materialtypeid', "LEFT");
		$this->db->join('unit_unit u', 'u.unit_unitid = it.itli_unitid', "LEFT");
    	$this->db->join('eqca_equipmentcategory c', 'c.eqca_equipmentcategoryid = it.itli_catid', "LEFT");

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



}