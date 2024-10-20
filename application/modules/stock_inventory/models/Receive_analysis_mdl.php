<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Receive_analysis_mdl extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
		//$this->table='eqli_equipmentlist';
		$this->locationid=$this->session->userdata(LOCATION_ID);
        $this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
	}
	public function strock_intransaction($srchcol=false)
	{
		$fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
        $locationid=$this->input->post('locationid');
        $storeid = $this->input->post('store_id');
		$this->db->select('eq.eqty_equipmenttype,il.itli_itemname,SUM(md.trde_requiredqty) as stock, SUM(md.trde_requiredqty * md.trde_unitprice) as stockvalue');
			$this->db->from('trma_transactionmain mt');
	    	$this->db->join('trde_transactiondetail md','md.trde_trmaid = mt.trma_trmaid','LEFT');
	    	$this->db->join('itli_itemslist il','il.itli_itemlistid = md.trde_itemsid','LEFT');
	    	//$this->db->where('trma_todepartmentid', '');
			$this->db->join('eqty_equipmenttype eq','eq.eqty_equipmenttypeid = mt.trma_fromdepartmentid','LEFT');
		$this->db->where('mt.trma_received', '0');
			
	    if($srchcol)
	    {
	      $this->db->where($srchcol);
	    }
	    if($fromdate &&  $todate){
	        if(DEFAULT_DATEPICKER=='NP')
	        {
	          $this->db->where('md.trde_transactiondatebs >=', $fromdate);
	          $this->db->where('md.trde_transactiondatebs <=', $todate);
	        }
	        else
	        {
	          $this->db->where('md.trde_transactiondatead >=', $fromdate);
	          $this->db->where('md.trde_transactiondatead <=', $todate);
	        }
	    }
	    if($this->location_ismain=='Y'){
	    	if($locationid){
	    	$this->db->where('md.trde_locationid',$locationid);
	    }
	}else{

	    	$this->db->where('md.trde_locationid',$this->locationid);
	    
	}
	    if($storeid){
	    	$this->db->where('eq.eqty_equipmenttypeid',$storeid);
	    }
	    $this->db->group_by('eq.eqty_equipmenttype');
	    $query = $this->db->get();
	    //echo $this->db->last_query();die();
	    if ($query->num_rows() > 0) 
	    {
	      $data=$query->result();   
	      return $data;   
	    }   
	    return false;
	}
	public function get_dispatch_wise_search($srchcol=false)
	{
		$fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
        $locationid=$this->input->post('locationid');
		$this->db->select('mt.trma_issueno,mt.trma_receiveddatebs,mt.trma_receiveddatead, mt.trma_reqno as requisitionno,eq.eqty_equipmenttype,SUM(md.trde_requiredqty * md.trde_unitprice) as amount ,mt.trma_receivedby');
			$this->db->from('trma_transactionmain mt');
	    	$this->db->join('trde_transactiondetail md','md.trde_trmaid = mt.trma_trmaid','LEFT');
			$this->db->join('eqty_equipmenttype eq','eq.eqty_equipmenttypeid = mt.trma_fromdepartmentid','LEFT');
			$this->db->where(array('mt.trma_transactiontype'=>'ISSUE'));
			$this->db->where(array('mt.trma_fromdepartmentid <>'=> 'mt.trma_todepartmentid'));
	    if($srchcol)
	    {
	      $this->db->where($srchcol);
	    }
	    if($fromdate &&  $todate){
	        if(DEFAULT_DATEPICKER=='NP')
	        {
	          $this->db->where('mt.trma_receiveddatebs >=', $fromdate);
	          $this->db->where('mt.trma_receiveddatebs <=', $todate);
	        }
	        else
	        {
	          $this->db->where('mt.trma_receiveddatead >=', $fromdate);
	          $this->db->where('mt.trma_receiveddatead <=', $todate);
	        }
	    }
	       if($locationid)
	    {
	      $this->db->where('mt.trma_locationid',$locationid);
	    }
	    $this->db->group_by('eq.eqty_equipmenttype, mt.trma_reqno,mt.trma_receiveddatebs,mt.trma_receivedby');
	    $this->db->order_by('eq.eqty_equipmenttype,mt.trma_reqno');
	    $query = $this->db->get();
	    //echo $this->db->last_query();die();
	    if ($query->num_rows() > 0) 
	    {
	      $data=$query->result();   
	      return $data;   
	    }   
	    return false;
	}
	public function get_items_only($cond=false)
	{ 	
		$fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
		$sql = "SELECT DISTINCT
					(trma_issueno) AS issueno, requisitionno,trma_receiveddatebs,trma_receivedby
				FROM
					(
						SELECT
							`mt`.`trma_issueno`,
							`mt`.`trma_reqno` AS `requisitionno`,
							`mt`.`trma_receiveddatebs`,
							`eq`.`eqty_equipmenttype`,
							`il`.`itli_itemname`,
							`il`.`itli_itemcode`,
							`md`.`trde_requiredqty`,
							`md`.`trde_unitprice`,
							`md`.`trde_controlno` AS `batchno`,
							`mt`.`trma_receivedby`
						FROM
							`xw_trma_transactionmain` `mt`
						LEFT JOIN `xw_trde_transactiondetail` `md` ON `md`.`trde_trmaid` = `mt`.`trma_trmaid`
						LEFT JOIN `xw_itli_itemslist` `il` ON `il`.`itli_itemlistid` = `md`.`trde_itemsid`
						LEFT JOIN `xw_eqty_equipmenttype` `eq` ON `eq`.`eqty_equipmenttypeid` = `mt`.`trma_fromdepartmentid`
						WHERE
							`mt`.`trma_fromdepartmentid` <> 'mt.trma_todepartmentid'
						AND `mt`.`trma_transactiontype` = 'ISSUE'
						AND `mt`.`trma_todepartmentid` = '2'
						AND `mt`.`trma_receiveddatebs` >= '$fromdate'
						AND `mt`.`trma_receiveddatebs` <= '$todate' $cond
					) x";
		$query = $this->db->query($sql);
		//echo $this->db->last_query();die();
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();		
			return $data;		
		}		
		return false;
		
	}
	public function get_item_wise_search($srchcol=false)
	{
		$fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
         $locationid=$this->input->post('locationid');
         //$storeid = $this->input->post('store_id');
		$this->db->select('mt.trma_issueno,mt.trma_reqno as requisitionno,mt.trma_receiveddatebs,eq.eqty_equipmenttype,il.itli_itemname,il.itli_itemcode, md.trde_requiredqty,md.trde_unitprice, md.trde_controlno as batchno,md.trde_requiredqty, md.trde_unitprice,mt.trma_receivedby');
			$this->db->from('trma_transactionmain mt');
	    	$this->db->join('trde_transactiondetail md','md.trde_trmaid = mt.trma_trmaid','LEFT');
	    	$this->db->join('itli_itemslist il','il.itli_itemlistid = md.trde_itemsid','LEFT');
			$this->db->join('eqty_equipmenttype eq','eq.eqty_equipmenttypeid = mt.trma_fromdepartmentid','LEFT');
			$this->db->where(array('mt.trma_fromdepartmentid <>'=> 'mt.trma_todepartmentid'));
			$this->db->where('mt.trma_transactiontype', 'ISSUE');
	    if($srchcol)
	    {
	      $this->db->where($srchcol);
	    }
	    if($fromdate &&  $todate){
	        if(DEFAULT_DATEPICKER=='NP')
	        {
	          $this->db->where('mt.trma_receiveddatebs >=', $fromdate);
	          $this->db->where('mt.trma_receiveddatebs <=', $todate);
	        }
	        else
	        {
	          $this->db->where('mt.trma_receiveddatead >=', $fromdate);
	          $this->db->where('mt.trma_receiveddatead <=', $todate);
	        }
	    }
	 if($this->location_ismain=='Y'){
	   if($locationid)
	    {
	      $this->db->where('mt.trma_locationid',$locationid);
	    }
	   }else 
	    {
	      $this->db->where('mt.trma_locationid',$this->locationid);
	    }
	    // if($storeid)
	    // {
	    //   $this->db->where('eq.eqty_equipmenttypeid',$storeid);
	    // }
	   // $this->db->group_by('eq.eqty_equipmenttype');
	    $query = $this->db->get();
	   // echo $this->db->last_query();die();
	    if ($query->num_rows() > 0) 
	    {
	      $data=$query->result();   
	      return $data;   
	    }   
	    return false;
	}
}