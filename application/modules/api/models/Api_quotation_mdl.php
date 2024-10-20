<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api_quotation_mdl extends CI_Model 
{

	public function __construct() 
	{
		parent::__construct();
		$this->db3=$this->load->database('inventory',true);
		
	}

	function get_quotation_master_other_db()
	{
		// print_r($this->db3);
		// die();
		$this->db3->select('
		QUOTATIONMASTERID			as		quma_quotationmasterid,
		SUPPLIERID					as		quma_supplierid,
		QUOTATIONNUMBER				as		quma_quotationnumber,
		SUPPLIERQUOTATIONNUMBER		as		quma_supplierquotationnumber,
		QUOTATIONDATE				as		quma_quotationdatebs,
		SUPPLIERQUOTATIONDATE		as		quma_supplierquotationdatebs,
		AMOUNT						as		quma_amount,
		DISCOUNT					as		quma_discount,
		VAT							as		quma_vat,
		TOTALAMOUNT					as		quma_totalamount,
		USER_NAME					as		quma_username,
		POSTTIME					as		quma_posttime,
		EXPDATE						as		quma_expdatebs,
			');
		$this->db3->order_by('QUOTATIONMASTERID','ASC');
		$query=$this->db3->get('QUOTATIONMASTER');

		if($query->num_rows()>0)
		{
			return $query->result();
		}
		return false;

	}

function get_quotation_detail_other_db()
	{
		// print_r($this->db3);
		// die();
		$this->db3->select('
			QUOTATIONDETAILID			as		qude_quotationdetailid,	
			QUOTATIONMASTERID			as		qude_quotationmasterid,	
			ITEMSID						as		qude_itemsid,	
			QTY							as		qude_qty,	
			AMOUNT						as		qude_amount,	
			DISCOUNTPC					as		qude_discountpc,	
			VATPC						as		qude_vatpc,	
			RATE						as		qude_rate,	
			FREE						as		qude_free,	
			ARATE						as		qude_netrate,	
			UNITS						as		qude_units,	
			REMARKS						as		qude_remarks,	
			');
		
		$this->db3->order_by('QUOTATIONDETAILID','ASC');
		$query=$this->db3->get('QUOTATIONDETAIL');

		if($query->num_rows()>0)
		{
			return $query->result();
		}
		return false;

	}





}