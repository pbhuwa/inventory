<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Consumption_report_mdl extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
		//$this->table='eqli_equipmentlist';
		    $this->locationid=$this->session->userdata(LOCATION_ID);
        $this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
	}
	public function get_category_wise_report($srchcol=false,$limit=false,$offset=false,$order=false,$order_by=false)
	{
		$fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
        $locationid = $this->input->post('locationid');
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
	    if($this->location_ismain=='Y'){
	    	   if($locationid)
        {
         	$this->db->where('s.sama_locationid',$locationid); 
        }
    }else{
    	$this->db->where('s.sama_locationid',$this->locationid);
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

	public function get_issue_report($srchcol=false,$limit=false,$offset=false,$order=false,$order_by=false)
	{
		$fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
        $locationid = $this->input->post('locationid');

       // $this->db->select('s.*, sd.*,it.itli_itemname, n.maty_material, (sd.sade_unitrate * sd.sade_qty)as amount');
        $this->db->select('s.sama_depname,s.sama_billdatebs,s.sama_invoiceno, sd.sade_qty, sd.sade_expdate, sd.sade_unitrate,it.itli_itemname, n.maty_material, SUM(sd.sade_unitrate * sd.sade_qty)as amount');
		$this->db->from('sama_salemaster s');
		$this->db->join('sade_saledetail sd', 'sd.sade_salemasterid = s.sama_salemasterid');
		$this->db->join('itli_itemslist it', 'it.itli_itemlistid = sd.sade_itemsid', "LEFT");
		$this->db->join('maty_materialtype n', 'n.maty_materialtypeid = it.itli_materialtypeid', "LEFT");
		$this->db->where('s.sama_st', "N");
		if($fromdate &&  $todate){
	        if(DEFAULT_DATEPICKER=='NP')
	        {
	          $this->db->where('s.sama_billdatebs >=', $fromdate);
	          $this->db->where('s.sama_billdatebs <=', $todate);
	        }
	        else
	        {
	          $this->db->where('s.sama_billdatebs >=', $fromdate);
	          $this->db->where('s.sama_billdatebs <=', $todate);
	        }
	    }
	    
          if($this->location_ismain=='Y'){
	    	if($locationid)
        {
         	$this->db->where('s.sama_locationid',$locationid); 
        }
    }else{
    	$this->db->where('s.sama_locationid',$this->locationid); 

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
	public function get_issue_consumption_report($srchcol=false,$limit=false,$offset=false,$order=false,$order_by=false)
	{
		$fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
        $locationid = $this->input->post('locationid');
        $storeid = $this->input->post('store_id');
        
        $this->db->select('s.sama_depname,s.sama_billdatebs, s.sama_invoiceno,sd.sade_expdate, sd.sade_qty,sd.sade_unitrate,it.itli_itemname, (sd.sade_unitrate * sd.sade_qty)as amount');
		$this->db->from('sama_salemaster s');
		$this->db->join('sade_saledetail sd', 'sd.sade_salemasterid = s.sama_salemasterid','LEFT');
		$this->db->join('itli_itemslist it', 'it.itli_itemlistid = sd.sade_itemsid', "LEFT");
		
		$this->db->where('s.sama_st <>','C');
		$this->db->where('s.sama_status','O');
		$this->db->where('it.itli_materialtypeid','1');
		if($fromdate &&  $todate){
	        if(DEFAULT_DATEPICKER=='NP')
	        {
	          //print_r($todate); echo"from date"; print_r($fromdate);die;
	          $this->db->where('s.sama_billdatebs >=', $fromdate);
	          $this->db->where('s.sama_billdatebs <=', $todate);
	        }
	        else
	        {

	          $this->db->where('s.sama_billdatebs >=', $fromdate);
	          $this->db->where('s.sama_billdatebs <=', $todate);
	        }
	    }
	    if($this->location_ismain=='Y'){
	    	if($locationid)
        {
         	$this->db->where('s.sama_locationid',$locationid); 
        }
    }else{
    	$this->db->where('s.sama_locationid',$this->locationid); 

    }

        if($storeid){
        	$this->db->where('s.sama_storeid',$storeid); 
        }

        if($srchcol)
        {
         	$this->db->where($srchcol); 
        }

        $this->db->group_by('sade_itemsid');
		$this->db->order_by('it.itli_itemname');
		$query = $this->db->get();
		 // echo $this->db->last_query();die();
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();		
			return $data;		
		}		
		return false;
	}
	
	public function get_current_stock_report($srchcol=false,$limit=false,$offset=false,$order=false,$order_by=false)
	{
		$fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
		// $fromdate = $this->input->post('frmDate');
		// $todate = $this->input->post('toDate');
		$locationid = $this->input->post('locationid');
   		// $store_id = $this->input->post('store_id');
		//print_r($fromdate);
        //$this->db->select("ssd.*, mt.maty_material,u.unit_unitname, it.itli_itemname,it.itli_itemcode, (sd.trde_issueqty * sd.trde_unitprice) as total,sd.trde_unitprice");
        $this->db->select("sd.*, mt.maty_material,u.unit_unitname, it.itli_itemname,it.itli_itemcode, 
	    		(
	    		CASE WHEN (sd.trde_batchno != '') THEN sd.trde_batchno ELSE sd.trde_controlno END ) batchno,(sd.trde_issueqty * sd.trde_unitprice) as total,sd.trde_unitprice");
		$this->db->from('trde_transactiondetail sd');
		$this->db->join('itli_itemslist it', 'it.itli_itemlistid = sd.trde_itemsid', "LEFT");
		$this->db->join('maty_materialtype mt', 'mt.maty_materialtypeid = sd.trde_itemsid', "LEFT");
		$this->db->join('unit_unit u', 'u.unit_unitid = sd.trde_unitprice', "LEFT");

		if($fromdate &&  $todate){
	        if(DEFAULT_DATEPICKER=='NP')
	        {
	          $this->db->where('sd.trde_expdatebs >=', $fromdate);
	          $this->db->where('sd.trde_expdatebs <=', $todate);
	        }
	        else
	        {
	          $this->db->where('sd.trde_expdatead >=', $fromdate);
	          $this->db->where('sd.trde_expdatead <=', $todate);
	        }
	    }
	    // if($locationid)
     //    {
     //     	$this->db->where('sd.trde_locationid',$locationid); 
     //    }
       if($this->location_ismain=='Y'){
	    if($locationid)
        {
         	$this->db->where('sd.trde_locationid',$locationid); 
        }
        }else{
    	$this->db->where('sd.trde_locationid',$this->locationid); 
         }
        //  if($store_id)
        // {
        //  	$this->db->where('sd.trde_locationid',$store_id); 
        // }
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