<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class All_items_purchase_mdl extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
     $this->locationid=$this->session->userdata(LOCATION_ID);
        $this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
	}
	public function get_allpurchase_item($srchcol=false)
	{
		$fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
        $sql ="SELECT
				rm.recm_receiveddatebs,
				rm.recm_receiveddatebs,
				il.itli_itemcode,
				il.itli_itemname,
				c.eqca_category,
				mt.maty_material,
				rd.recd_purchasedqty,
				ut.unit_unitname unit,
				rd.recd_amount
			FROM
				xw_recm_receivedmaster rm
			LEFT JOIN xw_recd_receiveddetail rd ON rm.recm_receivedmasterid = rd.recd_receivedmasterid
			LEFT JOIN xw_itli_itemslist il ON rd.recd_itemsid = il.itli_itemlistid
			LEFT JOIN xw_unit_unit ut ON ut.unit_unitid = il.itli_unitid
			LEFT JOIN xw_eqca_equipmentcategory c ON c.eqca_equipmentcategoryid = il.itli_catid
			LEFT JOIN xw_maty_materialtype mt ON mt.maty_materialtypeid = il.itli_materialtypeid
			WHERE
				rm.recm_status <> 'M' AND recm_receiveddatebs BETWEEN '$fromdate' AND  '$todate'";
		$query = $this->db->query($sql);
		//echo $this->db->last_query();die();
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();		
			return $data;		
		}		
		return false;
	}

	public function get_allpurchase_item_lists($cond= false)
	{
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
            $this->db->where("eqca_category like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("maty_material like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("recd_purchasedqty like  '%".$get['sSearch_5']."%'  ");
        }
        if(!empty($get['sSearch_6'])){
            $this->db->where("unit_unitname like  '%".$get['sSearch_6']."%'  ");
        }
        if(!empty($get['sSearch_7'])){
            $this->db->where("recd_amount like  '%".$get['sSearch_7']."%'  ");
        }
        
        if($cond) {
            $this->db->where($cond);
        }

        $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');
        $toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');

        $supplier = !empty($get['supplier'])?$get['supplier']:$this->input->post('supplier');
        
        $items = !empty($get['items'])?$get['items']:$this->input->post('items');
           $locationid = !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');

   // if(!empty($locationid)){
   //          $this->db->where('recm_locationid',$locationid);
   //      }


             
         if($this->location_ismain=='Y'){
       if(!empty($locationid))
        {
            $this->db->where('recm_locationid',$locationid);
        }
        }else{
            $this->db->where('recm_locationid',$this->locationid);

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

        if(!empty($supplier)){
            $this->db->where('supp_supplierid',$supplier);
        }

        if(!empty($items)){
            $this->db->where('itli_itemlistid',$items);
        }
        $resltrpt=$this->db->select("COUNT(*) as cnt")
        			->from('recm_receivedmaster rm')
                    ->join('recd_receiveddetail rd','rd.recd_receivedmasterid = rm.recm_receivedmasterid','left')
                    ->join('itli_itemslist il','il.itli_itemlistid = rd.recd_itemsid','left')
                    ->join('unit_unit ut','ut.unit_unitid = il.itli_unitid','left')
                    ->join('eqca_equipmentcategory c','c.eqca_equipmentcategoryid = il.itli_catid','left')
                    ->join('maty_materialtype mt','mt.maty_materialtypeid = il.itli_materialtypeid','left')
                    ->where('rm.recm_status <>', 'M')
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
      	 	$order_by = 'eqca_category';
      	else if($this->input->get('iSortCol_0')==4)
      	 	$order_by = 'maty_material';
      	else if($this->input->get('iSortCol_0')==5)
      	 	$order_by = 'recd_purchasedqty';
      	else if($this->input->get('iSortCol_0')==6)
      	 	$order_by = 'unit_unitname';
        else if($this->input->get('iSortCol_0')==7)
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
            $this->db->where("itli_itemcode like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("itli_itemname like  '%".$get['sSearch_2']."%' OR itli_itemnamenp like  '%".$get['sSearch_2']."%'  ");
        }

        if(!empty($get['sSearch_3'])){
            $this->db->where("eqca_category like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("maty_material like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("recd_purchasedqty like  '%".$get['sSearch_5']."%'  ");
        }
        if(!empty($get['sSearch_6'])){
            $this->db->where("unit_unitname like  '%".$get['sSearch_6']."%'  ");
        }

        if(!empty($get['sSearch_7'])){
            $this->db->where("recd_amount like  '%".$get['sSearch_7']."%'  ");
        }

        
       
        if($cond) {
          $this->db->where($cond);
        }

        $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');
        $toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');

        $supplier = !empty($get['supplier'])?$get['supplier']:$this->input->post('supplier');
        
        $items = !empty($get['items'])?$get['items']:$this->input->post('items');

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

        if(!empty($supplier)){
            $this->db->where('supp_supplierid',$supplier);
        }
        //   if(!empty($locationid)){
        //     $this->db->where('recm_locationid',$locationid);
        // }
         if($this->location_ismain=='Y'){
       if(!empty($locationid))
        {
            $this->db->where('recm_locationid',$locationid);
        }
        }else{
            $this->db->where('recm_locationid',$this->locationid);

        }

        if(!empty($items)){
            $this->db->where('itli_itemlistid',$items);
        }
    	$this->db->select('rm.recm_receiveddatebs,rm.recm_receiveddatebs,il.itli_itemcode,il.itli_itemname,il.itli_itemnamenp,c.eqca_category,mt.maty_material,rd.recd_purchasedqty,ut.unit_unitname unit,rd.recd_amount');
        $this->db->from('recm_receivedmaster rm');
        $this->db->join('recd_receiveddetail rd','rd.recd_receivedmasterid = rm.recm_receivedmasterid','left');
        $this->db->join('itli_itemslist il','il.itli_itemlistid = rd.recd_itemsid','left');
        $this->db->join('unit_unit ut','ut.unit_unitid = il.itli_unitid','left');
        $this->db->join('eqca_equipmentcategory c','c.eqca_equipmentcategoryid = il.itli_catid','left');
        $this->db->join('maty_materialtype mt','mt.maty_materialtypeid = il.itli_materialtypeid','left');
    
        // if(!empty($order_by) && !empty($order)){
        //     $order_by = 'recm_receiveddatebs';
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
	   //  echo $this->db->last_query();die();
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