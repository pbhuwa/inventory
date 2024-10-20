<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api_item_mdl extends CI_Model 
{

	public function __construct() 
	{
		parent::__construct();
		$this->db2=$this->load->database('inventory',true);
		
	}




	public function get_itemlistfromotherdb()
	{
		$this->db2->select('
		 ITEMSID	As	itli_itemlistid,
		ITEMSCODE	As	itli_itemcode,
		ITEMSNAME	As	itli_itemname,
		TYPEAID 	As  itli_materialtypeid,				
		SALERATE	As	itli_salesrate,
		PURCHASERATE	As	itli_purchaserate,		
		REORDERLEVEL	As	itli_reorderlevel,
		LOSSQTY	As	itli_lossqty,
		CATID	As	itli_catid,
		SUBCATID	As	itli_subcatid,	
		UNITID		AS itli_unitid,
		ACTIVE	As	itli_active,
		MAXLIMIT	As	itli_maxlimit,
		MOVINGTYPE	As	itli_movingtype,
		VALUETYPE	As	itli_valuetype');
		$this->db2->order_by('ITEMSID','ASC');
		$query=$this->db2->get('ITEMSLIST');
		if($query->num_rows()>0)
		{
			return $query->result();
		}
		return false;

	}

	public function get_unit()
	{
		$this->db2->select('
				 UNITID		AS	unit_unitid,	
				 UNITNAME	AS	unit_unitname');
				$this->db2->order_by('UNITID','ASC');
				$query=$this->db2->get('UNITTABLE');
				if($query->num_rows()>0)
				{
					return $query->result();
				}
				return false;

	}
	
	public function get_category()
	{
		$this->db2->select('
				CATEGORYID 		As	eqca_equipmentcategoryid,
				CATEGORYNAME	As	eqca_category,
				TYPEID			As	eqca_equiptypeid,
				CATCODE			As	eqca_code,
				PARENTID		AS	eqca_parentcategoryid');
				$this->db2->order_by('CATEGORYID','ASC');
				$query=$this->db2->get('CATEGORY');
				if($query->num_rows()>0)
				{
					return $query->result();
				}
				return false;

	}
}