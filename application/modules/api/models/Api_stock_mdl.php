<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api_stock_mdl extends CI_Model 
{

	public function __construct() 
	{
		parent::__construct();
		$this->db3=$this->load->database('inventory',true);
		
	}

function get_stock_detail_other_db()
	{
		// print_r($this->db3);
		// die();
		$this->db3->select('
			STOCKDETAILID		as			stde_stockdetailid,		
			STOCKMASTERID		as			stde_stockmasterid,		
			ITEMSID				as			stde_itemsid,		
			CONTROLNO			as			stde_controlno,		
			EXPDATE				as			stde_expiredatead,		
			QTY					as			stde_qty,		
			RATE				as			stde_rate,		
			OPERATOR			as			stde_operator,		
			ADJUSTDATE			as			stde_adjustdatebs,		
			REMARKS				as			stde_remarks,		
			MAT_TRANS_DETAILID	as			stde_mattransdetailid,	
			SALERATE			as			stde_salerate,		
			ADJAMOUNT			as			stde_adjustamount,		
			EXPDATE				as			stde_expiredatebs,		
			ADJUSTDATE			as			stde_adjustdatead,		
			');
		$this->db3->order_by('STOCKDETAILID','ASC');
		$query=$this->db3->get('STOCKDETAIL');

		if($query->num_rows()>0)
		{
			return $query->result();
		}
		return false;

	}


function get_stock_master_other_db()
	{
		// print_r($this->db3);
		// die();
		$this->db3->select('
			STOCKMASTERID			as		stma_stockmassterid,		
			STOCKDATE				as		stma_stockdatebs,		
			OPERATOR				as		stma_operator,		
			COUNTERID				as		stma_counterid,		
			REMARKS					as		stma_remarks,		
							
		
			');
		$this->db3->order_by('STOCKMASTERID','ASC');
		$query=$this->db3->get('STOCKMASTER');

		if($query->num_rows()>0)
		{
			return $query->result();
		}
		return false;

	}


function get_closing_stock_other_db()
	{
		// print_r($this->db3);
		// die();
		$this->db3->select('
			CSDETAILID			as			csde_csdetailid,
			ITEMSID				as			csde_itemsid,
			PURCHASEDQTY		as			csde_purchasedqty,
			PURCHASEDVALUE		as			csde_purchasedvalue,
			PRETURNQTY			as			csde_returnqty,
			PRETURNVALUE		as			csde_preturnvalue,
			SOLDQTY				as			csde_soldqty,
			SOLDVALUE			as			csde_soldvalue,
			SOLDPURVALUE		as			csde_soldpurvalue,
			SRETURNQTY			as			csde_sreturnqty,
			SRETURNVALUE		as			csde_sreturnvalue,
			SRETURNPVALUE		as			csde_sreturnpvalue,
			STOCKQTY			as			csde_stockqty,
			STOCKVALUE			as			csde_stockvalue,
			CSMASTERID			as			csde_csmamasterid,
			ISSUEQTY			as			csde_issueqty,
			ISSUEAMT			as			csde_issueamount,
			RECEIVEDQTY			as			csde_receivedqty,
			RECEIVEDAMT			as			csde_receivedamnt,
			OPENINGQTY			as			csde_openingqty,
			OPENINGAMT			as			csde_openingamt,
			CUROPENINGQTY		as			csde_curopeningqty,
			CUROPENINGAMT		as			csde_curopeningamt,
			TRANSACTIONQTY		as			csde_transactionqty,
			TRANSACTIONVALUE	as			csde_transactionvalue,
			ADJQTY				as			csde_adjqty,
			ADJVALUE			as			csde_adjvalue,
			MTDQTY				as			csde_mtdqty,
			CONQTY				as			csde_conqty,
			CONVALUE			as			csde_convalue,
			');
		$this->db3->order_by('CSDETAILID','ASC');
		$query=$this->db3->get('CLOSINGSTOCK');

		if($query->num_rows()>0)
		{
			return $query->result();
		}
		return false;

	}


function get_closing_stock_master_other_db()
	{
		// print_r($this->db3);
		// die();
		$this->db3->select('
			CSMASTERID			as			clsm_csmasterid,
			GENERATEDATE		as			clsm_generatedatebs,
			GENERATETIME		as			clsm_generatetime,
			USER_NAME			as			clsm_username,
			FROMDATE			as			clsm_fromdatebs,
			TODATE				as			clsm_todatebs,
			COMPLETE			as			clsm_complete,
			DEPARTMENTID		as			clsm_departmentid,
			GENERATEDATE		as			clsm_generatedatead,
			TODATE				as			clsm_todatead,
			FROMDATE			as			clsm_fromdatead
			');
		$this->db3->order_by('CSMASTERID','ASC');
		$query=$this->db3->get('CLOSINGSTOCKMASTER');

		if($query->num_rows()>0)
		{
			return $query->result();
		}
		return false;

	}



}