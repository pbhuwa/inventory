<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api_kukl_mdl extends CI_Model 
{

	public function __construct() 
	{
		parent::__construct();
		
	}

	public function get_received_details($srchcol=false)
	{
	    $subqry = "(SELECT sum(pod.pude_quantity) from xw_puor_purchaseordermaster pom LEFT JOIN xw_pude_purchaseorderdetail pod
	    on pom.puor_purchaseordermasterid=pod.pude_purchasemasterid WHERE pom.puor_purchaseordermasterid=rm.recm_purchaseordermasterid
	    AND pod.pude_itemsid=rd.recd_itemsid group by puor_purchaseordermasterid
			) as puord_qty";
		$this->db->select("rd.*,il.itli_itemcode,il.itli_itemname,il.itli_itemnamenp,il.itli_itemlistid,ut.unit_unitname,rm.recm_invoiceno,rm.recm_receivedno,d.dist_distributor,rm.recm_supplierbillno,rm.recm_amount,rm.recm_clearanceamount,rm.recm_purchaseorderno,rm.recm_taxamount, rm.recm_discount,rm.recm_receiveddatead,rm.recm_receiveddatebs, rm.recm_postusername, rm.recm_remarks, rm.recm_locationid, eq.eqca_jinsicode, eq.eqca_accode, $subqry");
		$this->db->from('recd_receiveddetail rd');
		$this->db->join('itli_itemslist il','il.itli_itemlistid=rd.recd_itemsid','LEFT');
		$this->db->join('unit_unit ut','ut.unit_unitid=il.itli_unitid','LEFT');
		$this->db->join('recm_receivedmaster rm','rm.recm_receivedmasterid=rd.recd_receivedmasterid','LEFT');
		$this->db->join('dist_distributors d','d.dist_distributorid=rm.recm_supplierid','LEFT');
		$this->db->join('eqca_equipmentcategory eq','eq.eqca_equipmentcategoryid = il.itli_catid','LEFT');


		if($srchcol)
		{
		    $this->db->where($srchcol);
		}
		$query = $this->db->get();
		        // echo $this->db->last_query(); die();
		if ($query->num_rows() > 0) 
		{
		    $data=$query->result();     
		    return $data;       
		}       
		return false;
	}

	public function get_issue_detail($srchcol=false)
	{
		$this->locationid = '1';
		$this->storeid = '1';
		
		$this->db->select('sd.*, sum(sd.sade_curqty) as totalcurqty, sum(sd.sade_qty) as totalqty, il.itli_itemcode,il.itli_materialtypeid,il.itli_itemname,il.itli_itemnamenp,il.itli_itemlistid,ut.unit_unitname,rd.rede_qty,rd.rede_remqty,sum(sd.sade_unitrate * sd.sade_qty) as subtotal,(SELECT IFNULL(SUM(md.trde_issueqty),0) FROM xw_trde_transactiondetail md LEFT JOIN xw_trma_transactionmain mt   on md.trde_trmaid =mt.trma_trmaid
  		WHERE il.itli_itemlistid=md.trde_itemsid AND mt.trma_received=1 AND md.trde_locationid='.$this->locationid.' AND mt.trma_fromdepartmentid='.$this->storeid.' ) as stockqty, sm.sama_receivedby, eq.eqca_accode');
		$this->db->from('sade_saledetail sd');
		$this->db->join('sama_salemaster sm','sm.sama_salemasterid = sd.sade_salemasterid');
		$this->db->join('rede_reqdetail rd','rd.rede_reqdetailid=sd.sade_reqdetailid','LEFT');
		$this->db->join('itli_itemslist il','il.itli_itemlistid=sd.sade_itemsid','INNER');
		$this->db->join('unit_unit ut','ut.unit_unitid=il.itli_unitid','LEFT');
		$this->db->join('eqca_equipmentcategory eq','eq.eqca_equipmentcategoryid = il.itli_catid','LEFT');
		$this->db->group_by('il.itli_itemlistid');
		
		if($srchcol)
		{
			$this->db->where($srchcol);
		}
		$query = $this->db->get();
		// echo $this->db->last_query(); die();
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();     
			return $data;       
		}       
		return false;
	}
	public function get_issue_direct_purchase($srchcol=false)
	{
		$this->locationid = '1';
		$this->storeid = '1';
		
		$this->db->select('sd.*, sum(sd.sade_curqty) as totalcurqty, sum(sd.sade_qty) as totalqty, il.itli_itemcode,il.itli_materialtypeid,il.itli_itemname,il.itli_itemnamenp,il.itli_itemlistid,ut.unit_unitname,rd.rede_qty,rd.rede_remqty,sum(sd.sade_unitrate * sd.sade_qty) as subtotal,(SELECT IFNULL(SUM(md.trde_issueqty),0) FROM xw_trde_transactiondetail md LEFT JOIN xw_trma_transactionmain mt   on md.trde_trmaid =mt.trma_trmaid
  		WHERE il.itli_itemlistid=md.trde_itemsid AND mt.trma_received=1 AND md.trde_locationid='.$this->locationid.' AND mt.trma_fromdepartmentid='.$this->storeid.' ) as stockqty, sm.sama_receivedby, eq.eqca_accode');
		$this->db->from('sade_saledetail sd');
		$this->db->join('sama_salemaster sm','sm.sama_salemasterid = sd.sade_salemasterid');
		$this->db->join('rede_reqdetail rd','rd.rede_reqdetailid=sd.sade_reqdetailid','LEFT');
		$this->db->join('itli_itemslist il','il.itli_itemlistid=sd.sade_itemsid','INNER');
		$this->db->join('unit_unit ut','ut.unit_unitid=il.itli_unitid','LEFT');
		$this->db->join('eqca_equipmentcategory eq','eq.eqca_equipmentcategoryid = il.itli_catid','LEFT');
		$this->db->group_by('il.itli_itemlistid');
		
		if($srchcol)
		{
			$this->db->where($srchcol);
		}
		$query = $this->db->get();
		// echo $this->db->last_query(); die();
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();     
			return $data;       
		}       
		return false;
	}

}