<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api_issue_mdl extends CI_Model 
{

	public function __construct() 
	{
		parent::__construct();
		$this->db3=$this->load->database('inventory',true);
		
	}

	public function get_sales_master_other_db()
{
    $this->db3->select('
      	SALEMASTERID		as				sama_salemasterid,
		CUSTOMERID			as				sama_depid,
		BILLDATE			as				sama_billdatebs,
		DUEDATE				as				sama_duedatebs,
		SOLDBY				as				sama_soldby,
		TOTALAMOUNT			as				sama_totalamount,
		DISCOUNT			as				sama_discount,
		TAXRATE				as				sama_taxrate,
		VAT					as				sama_vat,
		USER_NAME			as				sama_username,
		LASTCHANGEDATE		as				sama_lastchangedate,
		ORDERNO				as				sama_orderno,
		CHALLANNO			as				sama_challanno,
		BILL_NO				as				sama_billno,
		PAYMENT				as				sama_payment,
		STATUS				as				sama_status,
		FYEAR				as				sama_fyear,
		DISCOUNTPC			as				sama_discountpc,
		ISPRINTED			as				sama_isprinted,
		ST					as				sama_st,
		REQUISITIONNO 		as 				sama_requisitionno,
		MANUALBILLNO		as				sama_manualbillno,
		DEPID				as				sama_storeid,
		STDATE				as				sama_stdatebs,
		STDEPID				as				sama_stdepid,
		STSHIFTID			as				sama_stshiftid,
		CUSTOMERNAME		as				sama_depname,
		INVOICENO			as				sama_invoiceno,
		MEMNO				as 				sama_receivedby,
		REQUISITIONDATE		as 				sama_requisitiondatebs
            '); 

        $this->db3->order_by('SALEMASTERID','ASC');
         // $this->db3->limit(1);
        $query=$this->db3->get('SALEMASTER');

        if($query->num_rows()>0)
        {
            return $query->result();
        }
        return false;

}



	public function get_sales_detail_other_db()
	{
		$this->db3->select('
			SALEDETAILID			As		sade_saledetailid,
			SALEMASTERID			As		sade_salemasterid,
			ITEMSID					As		sade_itemsid,
			QTY						As		sade_qty,
			CURQTY					As		sade_curqty,
			UNITRATE				As		sade_unitrate,
			DISCOUNT				As		sade_discount,
			BATCHNO					As		sade_batchno,
			MFGDATE					As		sade_mfgdate,
			EXPDATE					As		sade_expdate,
			MAT_TRANS_DETAILID		As		sade_mattransdetailid,
			STATUS					As		sade_status,
			CONTROLNO				As		sade_controlno,
			PURCHASERATE			As		sade_purchaserate,
			BILLDATE				As		sade_billdatebs,
			BILLTIME				As		sade_billtime,
			USER_NAME				As		sade_username,
			VATAMT					As		sade_vatamt,
			INVOICENO				As		sade_invoiceno,
			SNO						As		sade_sno,
			REMARKS					As		sade_remarks
			');
        $this->db3->order_by('SALEDETAILID','ASC');
        // $this->db3->limit(1);

        $query=$this->db3->get('SALEDETAIL');

        if($query->num_rows()>0)
        {
            return $query->result();
        }
        return false;

	}


	public function get_req_master_other_db()
	{
		$this->db3->select('
			REQ_MASTERID		as			rema_reqmasterid,
			REQ_NO				as			rema_reqno,
			REQ_DATE			as			rema_reqdatebs,
			REQ_FROMDEPID		as			rema_reqfromdepid,
			REQ_TODEPID			as			rema_reqtodepid,
			USERNAME			as			rema_username,
			REQ_BY				as			rema_reqby,
			REQ_TO				as			rema_reqto,
			FYEAR				as			rema_fyear,
			REMARKS				as			rema_remarks,
			STATUS				as			rema_status,
			RECEIVED			as			rema_received,
			MANUAL_NO			as			rema_manualno,
			APPROVEDBY			as			rema_approvedby,
			APPROVED			as			rema_approved,
			STOREID				as			rema_storeid,
			ISDEP				as			rema_isdep,
			');
        $this->db3->order_by('REQ_MASTERID','ASC');
        //$this->db3->limit(1);

        $query=$this->db3->get('REQ_MASTER');

        if($query->num_rows()>0)
        {
            return $query->result();
        }
        return false;

	}



	public function get_req_detail_other_db()
	{
		$this->db3->select('
	REQ_DETAILID			as			rede_reqdetailid,
	REQ_MASTERID			as			rede_reqmasterid,
	ITEMSID					as			rede_itemsid,
	QTY						as			rede_qty,
	REMARKS					as			rede_remarks,
	REM_QTY					as			rede_remqty,
	QTYINSTOCK				as			rede_qtyinstock,
	EXPECTEDEXAUSTDATE		as			rede_expectedexaustdate,
	EXPECTEDARRIVALDATE		as			rede_expectedarrivaldate,
	APPROVEDQTY				as			rede_approvedqty,
	APPROVEDDATE			as			rede_approveddatead,							
			');
        $this->db3->order_by('REQ_DETAILID','ASC');
        //$this->db3->limit(1);

        $query=$this->db3->get('REQ_DETAIL');

        if($query->num_rows()>0)
        {
            return $query->result();
        }
        return false;

	}


public function get_reqdetail_note_other_db()
	{
		$this->db3->select('
		REQID		as			redt_reqdeit,
		REQDETID	as			redt_reqid,
		ITEMSID		as			redt_itemsid,
		UNIT		as			redt_unit,
		STORE_STOCK	as			redt_storestock,
		QTY			as			redt_qty,
		RATE		as			redt_rate,
		BUD_CODE	as			redt_budcode,
		REMARKS		as			redt_remarks,
		FYEAR		as			redt_fyear,
		REQ_DATE	as			redt_reqdatead,
		REM_QTY		as			redt_remaqty,
		NEWREQ		as			redt_newreq,
		');
        $this->db3->order_by('REQID','ASC');
        //$this->db3->limit(1);

        $query=$this->db3->get('REQDETAIL');

        if($query->num_rows()>0)
        {
            return $query->result();
        }
        return false;

	}


public function get_requisition_other_db()
	{
		$this->db3->select('
		REQID				as				requ_requid,	
		REQ_DATE			as				requ_requdatebs,	
		APPLIED_BY			as				requ_appliedby,	
		REQUSER				as				requ_requser,	
		REQTIME				as				requ_reqtime,	
		REQUEST_TO			as				requ_requestto,	
		FYEAR				as				requ_requfyear,	
		COSTCENTRE			as				requ_costcentre,	
		STOREID				as				requ_storeid,	
		REQNO				as				requ_requno,	
		ORDERED				as				requ_orderd,	
		ISAPPROVED			as				requ_isapproved,	
		APPROVALDATE		as				requ_approvaldatebs	
		ITEMSTYPEID			as				requ_itemstypeid,	
		STATUS				as				requ_status,	
									

		');
        $this->db3->order_by('REQID','ASC');
        //$this->db3->limit(1);

        $query=$this->db3->get('REQUISITION');

        if($query->num_rows()>0)
        {
            return $query->result();
        }
        return false;

	}




	public function get_requisitionnote_other_db()
	{
		$this->db3->select('
		REQID			as			reno_reqid,
		REQ_DATE		as			reno_reqdatead,
		APPLIED_BY		as			reno_appliedby,
		REQUSER			as			reno_requser,
		REQTIME			as			reno_reqtime,
		REQUEST_TO		as			reno_requestto,
		FYEAR			as			reno_fyear,
		COSTCENTRE		as			reno_costcenter,
		STOREID			as			reno_storeid,
		REQNO			as			reno_reqno,

		');
        $this->db3->order_by('REQID','ASC');
        //$this->db3->limit(1);

        $query=$this->db3->get('REQUISITION_NOTE');

        if($query->num_rows()>0)
        {
            return $query->result();
        }
        return false;

	}


// public function get_REQ_DETAIL_other_db()
// 	{
// 		$this->db3->select('
// 		REQ_DETAILID			as		rede_reqdetailid,
// 		REQ_MASTERID			as		rede_reqmasterid,
// 		ITEMSID					as		rede_itemsid,
// 		QTY						as		rede_qty,
// 		REMARKS					as		rede_remarks,
// 		REM_QTY					as		rede_remqty,
// 		QTYINSTOCK				as		rede_qtyinstock,
// 		EXPECTEDEXAUSTDATE		as		rede_expectedexaustdate,
// 		EXPECTEDARRIVALDATE		as		rede_expectedarrivaldate,
// 		APPROVEDQTY				as		rede_approvedqty,
// 		APPROVEDDATE			as		rede_approveddatebs
// 		');
		
//         $this->db3->order_by('REQ_DETAILID','ASC');
//         //$this->db3->limit(1);

//         $query=$this->db3->get('REQ_DETAIL');

//         if($query->num_rows()>0)
//         {
//             return $query->result();
//         }
//         return false;

// 	}

public function get_return_master_db()
    {
        $this->db3->select('
                 RETURNMASTERID	AS	rema_returnmasterid,
				RECEIVENO		AS	rema_receiveno,
				FYEAR			AS	rema_fyear,
				CUSTOMERID		AS	rema_depid,
				AMOUNT			AS	rema_amount,
				RETURNDATE		AS	rema_returndatebs,	
				DEPID			AS	rema_storeid,
				BDATE			AS	rema_bdatebs,		
				TYPE			AS	rema_type,
				AUTHER			AS	rema_auther,
				USERNAME		AS	rema_username,		
				RETTIME			AS	rema_returntime,
				INVOICENO		AS	rema_invoiceno,
				ST				AS	rema_st,
				ST_USERNAME		AS	rema_stusername,
				ST_DATE			AS	rema_stdatebs,
				REMARKS			AS	rema_remarks,
				RETURNBY		AS	rema_returnby   
            ');
        $this->db3->order_by('RETURNMASTERID','ASC');
        $query=$this->db3->get('RETURNMASTER');
      

        if($query->num_rows()>0)
        {
            return $query->result();
        }
        return false;
    }
    public function get_return_detail_db()
    {
        $this->db3->select('
            RETURNDETAILID      as  rede_returndetailid,
            RETURNMASTERID      as  rede_returnmasterid,
            ITEMSID             as  rede_itemsid,
            UNITPRICE           as  rede_unitprice,
            QTY                 as  rede_qty,
            TOTAL               as  rede_total,
            MAT_TRANS_DETAILID  as  `rede_mattransdetailid`,
            CONTROLNO           as  rede_controlno,
            DISCOUNT            as  rede_discount,
            DEPID               as  rede_storeid,
            INVOICENO           as  rede_invoiceno,
            PATIENTID           as  rede_depid,
            EXPDATE             as  rede_expdatebs,
            NEWMTDID            as  rede_newmtdid,
            REMARKS             as  rede_remarks,
            SALEFYEAR           as  rede_salefyear,
            REQDETAILID         as  rede_reqdetailid

            ');
        $this->db3->order_by('RETURNDETAILID','ASC');
        $query=$this->db3->get('RETURNDETAIL');

        if($query->num_rows()>0)
        {
            return $query->result();
        }
        return false;
    }

    public function get_transaction_master()
    {
	 $this->db3->select('
	            MAT_TRANS_MASTERID	AS	trma_trmaid,
				TRANSACTION_DATE	AS	trma_transactiondatebs,
				TRANSACTION_TYPE	AS	trma_transactiontype,
				FROM_DEPARTMENTID	AS	trma_fromdepartmentid,
				TO_DEPARTMENTID		AS	trma_todepartmentid,
				FROM_BY				AS	trma_fromby,
				TO_BY				AS	trma_toby,
				ISSUE_NO			AS	trma_issueno,
				STATUS				AS	trma_status,
				SYS_DATE			AS	trma_sysdate,
				LAST_CHANGE_DATE	AS	trma_lastchangedate,
				LAST_CHANGE_BY		AS	trma_lastchangeby,
				BATCH_JOB_ID		AS	trma_batchjobid,
				BATCHNO				AS	trma_batchno,
				BATCH_ITEM_ID		AS	trma_batchitemid,
				BATCH_SIZE			AS	trma_batchsize,
				STATUS_UPDATE_DATE	AS	trma_statusupdatedate,
				REQNO				AS	trma_reqno,
				RECEIVED			AS	trma_received,
				RECEIVEDDATE		AS	trma_receiveddatebs,
				RECEIVEDBY			AS	trma_receivedby,
				REMARKS				AS	trma_remarks,
				MANUALNO			AS	trma_manualno,
				MTMTIME				AS	trma_mtmtime,
				FYEAR				AS	trma_fyear
				
	            ');
	        $this->db3->order_by('MAT_TRANS_MASTERID','ASC');
	        $query=$this->db3->get('MAT_TRANS_MASTER');

	        if($query->num_rows()>0)
	        {
	            return $query->result();
	        }
	        return false;
    }

    public function get_transaction_detail()
    {
    	$this->db3->select('
	            MAT_TRANS_DETAILID	AS	trde_trdeid,
				MAT_TRANS_MASTERID	AS	trde_trmaid,
				TRANSACTION_DATE	AS	trde_transactiondatebs,
				ITEMSID				AS	trde_itemsid,
				CONTROL_NO			AS	trde_controlno,
				MFG_DATE			AS	trde_mfgdatebs,
				EXP_DATE			AS	trde_expdatebs,
				PACKINGTYPEID		AS	trde_packingtypeid,
				MTDID				AS	trde_mtdid,
				BATCHNO				AS	trde_batchno,
				UNITPERCASE			AS	trde_unitpercase,
				NOOFCASES			AS	trde_noofcases,
				CASENO				AS	trde_caseno,
				REQUIRED_QTY		AS	trde_requiredqty,
				ISSUE_QTY			AS	trde_issueqty,
				BATCHSIZE			AS	trde_batchsize,
				PACKING				AS	trde_packing,
				STRIPQTY			AS	trde_stripqty,
				ISSUE_NO			AS	trde_issueno,
				STATUS				AS	trde_status,
				SYS_DATE			AS	trde_sysdate,
				LAST_CHANGE_DATE	AS	trde_lastchangedate,
				LAST_CHANGE_BY		AS	trde_lastchangeby,
				MTMID				AS	trde_mtmid,
				TRANSACTION_TYPE	AS	trde_transactiontype,
				STATUS_UPDATE_DATE	AS	trde_statusupdatedatebs,
				UNITPRICE			AS	trde_unitprice,
				SELPRICE			AS	trde_selprice,
				REMARKS				AS	trde_remarks,
				SUPPLIERID			AS	trde_supplierid,
				SUPPLIERBILLNO		AS	trde_supplierbillno,
				TRANSTIME			AS	trde_transtime,
				MTDTIME				AS	trde_mtdtime,
				UNITVOLUME			AS	trde_unitvolume,
				MICROUNITID			AS	trde_microunitid,
				TOTALVOLUME			AS	trde_totalvalue,
				DESCRIPTION			AS	trde_description,
				FREE				AS	trde_free
	            ');
	        $this->db3->order_by('MAT_TRANS_DETAILID','ASC');
	        $query=$this->db3->get('MAT_TRANS_DETAIL');

	        if($query->num_rows()>0)
	        {
	            return $query->result();
	        }
	        return false;
    }





}
?>