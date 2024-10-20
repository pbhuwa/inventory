<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api_purchase_mdl extends CI_Model 
{

	public function __construct() 
	{
		parent::__construct();
		$this->db3=$this->load->database('inventory',true);
		
	}

	function get_purchase_quotation_db()
	{
		//print_r($this->db3);die();
		$this->db3->select('
			QUOTATIONDETAILID    AS      qude_quotationdetailid,
            QUOTATIONMASTERID    AS      qude_quotationmasterid,
            ITEMSID              AS      qude_itemsid,
            QTY                  AS      qude_qty,
            AMOUNT               AS      qude_amount,
            DISCOUNTPC           AS      qude_discountpc,
            VATPC                AS      qude_vatpc,
            RATE                 AS      qude_rate,
            FREE                 AS      qude_free,
            ARATE                AS      qude_netrate,
            UNITS                AS      qude_units,
            REMARKS              AS      qude_remarks');
		$this->db3->order_by('QUOTATIONDETAILID','ASC');
		$query=$this->db3->get('QUOTATIONDETAIL');

		if($query->num_rows()>0)
		{
			return $query->result();
		}
		return false;
	}



    public function get_purchase_master_db()
    {
        $this->db3->select('
            QUOTATIONMASTERID           as      quma_quotationmasterid,
            SUPPLIERID                  as      quma_supplierid,
            QUOTATIONNUMBER             as      quma_quotationnumber,
            SUPPLIERQUOTATIONNUMBER     as      quma_supplierquotationnumber,
            QUOTATIONDATE               as      quma_quotationdatebs,
            SUPPLIERQUOTATIONDATE       as      quma_supplierquotationdatead, 
            AMOUNT                      as      quma_amount,
            DISCOUNT                    as      quma_discount,
            VAT                         as      quma_vat,
            TOTALAMOUNT                 as      quma_totalamount,
            USER_NAME                   as      quma_username,
            POSTTIME                    as      quma_posttime,
            EXPDATE                     as      quma_expdatebs,
            ');
        $this->db3->order_by('QUOTATIONMASTERID','ASC');
        $query=$this->db3->get('QUOTATIONMASTER');

        if($query->num_rows()>0)
        {
            return $query->result();
        }
        return false;
    }




    public function get_sales_master_other_db()
    {
        $this->db3->select('
                SUPPLIERNAME        as dist_distributor,
                SUPPLIERADDRESS     as  dist_address1,
                SUPPLIERPHONE       as  dist_phone1,
                SUPPLIERMOBILE      as  dist_phone2,
                CONTACTPERSON       as  dist_salesrep,
                SUPPLIERFAX         as  dist_fax,
                SUPPLIERMAIL        as  dist_email,
                GOVTREGNO           as  dist_govtregno,
                GOVTREGDATE         as  dist_govtregdatead,
                REMARKS             as dist_remarks,
                SUPPLIERCODE        as dist_distributorcode,
                CITY                as dist_city,
                STREET              as dist_address1,
                APPROVED            as dist_approval,
                TDS                 as dist_tds
                ');
            $this->db3->order_by('SUPPLIERID','ASC');
            $query=$this->db3->get('SALEMASTER');

            if($query->num_rows()>0)
            {
                return $query->result();
            }
            return false;

    }
    public function get_requisition_note_db()
    {
        $this->db3->select('
            REQID       AS  reno_reqid,
            REQ_DATE    AS  reno_reqdatebs,
            APPLIED_BY  AS  reno_appliedby,
            REQUSER     AS  reno_requser,
            REQTIME     AS  reno_reqtime,
            REQUEST_TO  AS  reno_requestto,
            FYEAR       AS  reno_fyear,
            COSTCENTRE  AS  reno_costcenter,
            STOREID     AS  reno_storeid,
            REQNO       AS  reno_reqno,
            REQ_DATE    as  reno_postdatebs,
            ');
        $this->db3->order_by('REQID','ASC');
        $query=$this->db3->get('REQUISITION_NOTE');

        if($query->num_rows()>0)
        {
            return $query->result();
        }
        return false;
    }
    public function get_requisition_note_details_db()
    {
        $this->db3->select('
                    REQID       as  redt_reqdeit,
                    REQDETID    as  redt_reqid,
                    ITEMSID     as  redt_itemsid,
                    UNIT        as  redt_unit,
                    STORE_STOCK as  redt_storestock,
                    QTY         as  redt_qty,
                    RATE        as  redt_rate,
                    BUD_CODE    as  redt_budcode,
                    REMARKS     as  redt_remarks,
                    FYEAR       as  redt_fyear,
                    REQ_DATE    as  redt_reqdatebs,
                    REM_QTY     as  redt_remaqty,
                    NEWREQ      as  redt_newreq,
            ');
        $this->db3->order_by('REQID','ASC');
        $query=$this->db3->get('REQDETAIL_NOTE');

        if($query->num_rows()>0)
        {
            return $query->result();
        }
        return false;
    }

    public function get_return_master_db()
    {
        $this->db3->select('
                    RETURNMASTERID  as  rema_returnmasterid,
                    RECEIVENO       as  rema_receiveno,
                    FYEAR           as  rema_fyear,
                    CUSTOMERID      as  rema_depid,
                    AMOUNT          as  rema_amount,
                    RETURNDATE      as  rema_returndatebs,
                    DEPID           as  rema_storeid,
                    BDATE           as  rema_bdatebs,
                    TYPE            as  rema_type,
                    AUTHER          as  rema_auther,
                    USERNAME        as  rema_username,
                    SHIFTID         as  rema_shiftid,
                    STATUSCALC      as  rema_statuscalc,
                    CUSPAYID        as  rema_cuspayid,
                    RETTIME         as  rema_returntime
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
            MAT_TRANS_DETAILID  as  rede_mat_trans_detailid,
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
    public function get_chalan_details_db()
    {
        $this->db3->select('
                    CHALLANDETAILID AS  chde_challandetailid,
                    CHALLANMASTERID AS  chde_challanmasterid,
                    ITEMSID         AS  chde_itemsid,
                    QTY             AS  chde_qty,
                    REMARKS         AS  chde_remarks,
                    RECEIVECOMPLETE AS  chde_receivecomplete
                ');
        $this->db3->order_by('CHALLANDETAILID','ASC');
        $query=$this->db3->get('CHALLANDETAIL');

        if($query->num_rows()>0)
        {
            return $query->result();
        }
        return false;
    }
    
    public function get_chalan_master_db()
    {
        $this->db3->select('
                    CHALLANDETAILID AS  chde_challandetailid,
                    CHALLANMASTERID AS  chde_challanmasterid,
                    ITEMSID         AS  chde_itemsid,
                    QTY             AS  chde_qty,
                    REMARKS         AS  chde_remarks,
                    RECEIVECOMPLETE AS  chde_receivecomplete
                ');
        $this->db3->order_by('CHALLANDETAILID','ASC');
        $query=$this->db3->get('CHALLANDETAIL');

        if($query->num_rows()>0)
        {
            return $query->result();
        }
        return false;
    }



public function get_purchase_return_detail_db()
    {
        $this->db3->select('
        PURCHASERETURNDETAILID as          prde_purchasereturndetailid,
        PURCHASERETURNID       as          prde_purchasereturnid,
        ITEMSID                as          prde_itemsid,
        RETURNQTY              as          prde_returnqty,
        CONTROLNO              as          prde_controlno,
        PURCHASERATE           as          prde_purchaserate,
        EXPDATE                as          prde_expdatead,
        INVOICENO              as          prde_invoiceno,
        RECEIVEDDETAILID       as          prde_receiveddetailid,
        NOTEQTY                as          prde_noteqty,
        SALERATE               as          prde_salerate,
        FREE                   as          prde_free,
        SUPPLIERID             as          prde_supplierid,
        SUPPLIERBILLNO         as          prde_supplierbillno,
        REMARKS                as          prde_remarks
        EXPDATE                as          prde_expdatebs,
        ');

        $this->db3->order_by('PURCHASERETURNDETAILID','ASC');
        $query=$this->db3->get('PURCHASERETURNDETAIL');

        if($query->num_rows()>0)
        {
            return $query->result();
        }
        return false;
    }


public function get_purchase_order_detail_db()
    {
        $this->db3->select('
        PURCHASEORDERDETAILID   as      pude_puordeid,
        PURCHASEORDERMASTERID   as      pude_purchasemasterid,
        ITEMSID                 as      pude_itemsid,
        QUANTITY                as      pude_quantity,
        RATE                    as      pude_rate,
        AMOUNT                  as      pude_amount,
        UNIT                    as      pude_unit,
        REMQTY                  as      pude_remqty,
        DISCOUNT                as      pude_discount,
        VAT                     as      pude_vat,
        FREE                    as      pude_free,
        REMARKS                 as      pude_remarks,
        CANCELDATE              as      pude_canceldatead,
        STATUS                  as      pude_status,
        USER_NAME               as      pude_username,
        CANCELLEDQTY            as      pude_cancelqty,
        NCRATE                  as      pude_ncrate,
        TENDERID                as      pude_tenderid,
        ADJUSTMENTQTY           as      pude_adjustmentqty,
        TENDERNO                as      pude_tenderno,
        REQUISITIONID           as      pude_requsitionid,
        NEWPUR                  as      pude_newpur,
        FREE_REMQTY             as      pude_freeremqty,
        STK_QTY                 as      pude_stockqty,
        CANCELDATE              as      pude_canceldatebs,

        ');

        $this->db3->order_by('PURCHASEORDERDETAILID','ASC');
        $query=$this->db3->get('PURCHASEORDERDETAIL');

        if($query->num_rows()>0)
        {
            return $query->result();
        }
        return false;
    }


public function get_purchase_order_master_db()
    {
        $this->db3->select('
        PURCHASEORDERMASTERID  as          puor_purchaseordermasterid,
        PURCHASEORDERNO        as          puor_orderno,
        PURCHASEORDERDATE      as          puor_orderdatead,
        FYEAR                  as          puor_fyear,
        DELIVERYSITE           as          puor_deliverysite,
        DELIVERYDATE           as          puor_deliverydatead,
        SUPPLIERID             as          puor_supplierid,
        ORDERAMOUNT            as          puor_amount,
        VAT                    as          puor_vat,
        STATUS                 as          puor_status,
        PURCHASED              as          puor_purchased,
        DISCOUNT               as          puor_discount,
        TERMS                  as          puor_terms,
        APPROVEDBY             as          puor_approvedby,
        ORDER_FOR              as          puor_orderfor,
        DELIVERYDAYS           as          puor_deliverydays,
        PAYMENTDAYS            as          puor_paymentdays,
        CANCELDATE             as          puor_canceldatead,
        REQUISITIONNO          as          puor_requno,
        USER_NAME              as          puor_postby,
        CURRENCYSYMBOL         as          puor_currencytype,
        CURRENCYRATE           as          puor_currencyrate,
        ORDERTYPE              as          puor_ordertype,
        INSURANCE              as          puor_insurance,
        CARRIAGEFREIGHT        as          puor_carriagefreight,
        PACKING                as          puor_packing,
        TRANSPORTCOURIER       as          puor_transportcourier,
        OTHERS                 as          puor_other,
        REMARKS                as          puor_remarks,
        STOREID                as          puor_storeid,
        ITEMTYPEID             as          puor_timetypeid,
        ISFREEZE               as          puor_isfreezer,
        ');

        $this->db3->order_by('PURCHASEORDERMASTERID','ASC');
        $query=$this->db3->get('PURCHASEORDERMASTER');

        if($query->num_rows()>0)
        {
            return $query->result();
        }
        return false;
    }



public function get_purchase_return_db()
    {
        $this->db3->select('
        PURCHASERETURNID   as          purr_purchasereturnid,
        RETURNDATE         as          purr_returndatebs,
        RETURNNO           as          purr_returnno,
        RETURNEDBY         as          purr_returnby,
        RECEIVEDBY         as          purr_receivedby,
        REMARKS            as          purr_remarks,
        SUPPLIERID         as          purr_supplierid,
        FYEAR              as          purr_fyear,
        OPERATOR           as          purr_operator,
        DEPARTMENTID       as          purr_departmentid,
        RETURNAMOUNT       as          purr_returnamount,
        DISCOUNT           as          purr_discount,
        INVOICENO          as          purr_invoiceno,
        RETURNTIME         as          purr_returntime,
        VATAMOUNT          as          purr_vatamount,
        DAY_CLOSEID        as          purr_dayclosedid,
        ST                 as          purr_st,
        RETURNDATE         as          purr_returndatead
        ');

        $this->db3->order_by('PURCHASERETURNID','ASC');
        $query=$this->db3->get('PURCHASERETURN');

        if($query->num_rows()>0)
        {
            return $query->result();
        }
        return false;
    }


public function get_received_master_db()
    {
        $this->db3->select('
        RECEIVEDMASTERID           as      recm_receivedmasterid,
        RECEIVEDDATE               as      recm_receiveddatebs,
        FYEAR                      as      recm_fyear,
        SUPPLIERID                 as      recm_supplierid,
        PURCHASEORDERMASTERID      as      recm_purchaseordermasterid,
        AMOUNT                     as      recm_amount,
        DISCOUNT                   as      recm_discount,
        TAXAMOUNT                  as      recm_taxamount,
        CLEARANCEAMOUNT            as      recm_clearanceamount,
        AMOUNT1                    as      recm_amount1,
        AMOUNT2                    as      recm_amount2,
        DSTAT                      as      recm_dstat,
        TSTAT                      as      recm_tstat,
        CHALLANNO                  as      recm_challanno,
        PURCHASEORDERNO            as      recm_purchaseorderno,
        PURCHASEORDERDATE          as      recm_purchaseorderdatebs,
        QTYCHALLAN                 as      recm_qtychallan,
        QTYRECEIVED                as      recm_qtyreceived,
        CUSTOMEDUTY                as      recm_customeduty,
        LOCALDEVP                  as      recm_localdevp,
        SUPPLIERBILLNO             as      recm_supplierbillno,
        RECEIVEDNO                 as      recm_receivedno,
        DEPARTMENTID               as      recm_departmentid,
        STATUS                     as      recm_status,
        ENTEREDBY                  as      recm_enteredby,
        SUPBILLDATE                as      recm_supbilldatebs,
        POSTTIME                   as      recm_posttime,
        INVOICENO                  as      recm_invoiceno,
        BALANCINGFIGURE            as      recm_balancingfigure,
        DAY_CLOSEID                as      recm_day_closeid,
        INSURANCE                  as      recm_insurance,
        CARRIAGEFREIGHT            as      recm_carriagefreight,
        PACKING                    as      recm_packing,
        TRANSPORTCOURIER           as      recm_transportcourier,
        OTHERS                     as      recm_others,
        REMARKS                    as      recm_remarks,
        CURRENCYSYMBOL             as      recm_currencysymbol,
        CURRENCYRATE               as      recm_currencyrate,
        BUDGETID                   as      recm_budgetid,
        SYSTEMDATE                 as      recm_systemdate,
        ACTUALCLEARANCEAMOUNT      as      recm_actualclearanceamount,
        ');

        $this->db3->order_by('RECEIVEDMASTERID','ASC');
        $query=$this->db3->get('RECEIVEDMASTER');

        if($query->num_rows()>0)
        {
            return $query->result();
        }
        return false;
    }







public function get_received_detail_db()
    {
        $this->db3->select('
        RECEIVEDDETAILID        as      recd_receiveddetailid,
        RECEIVEDMASTERID        as      recd_receivedmasterid,
        ITEMSID                 as      recd_itemsid,
        PURCHASEDQTY            as      recd_purchasedqty,
        UNITPRICE               as      recd_unitprice,
        ATSTOCK                 as      recd_atstock,
        LOCATION                as      recd_location,
        CONTROLNO               as      recd_controlno,
        MARGIN                  as      recd_margin,
        SALERATE                as      recd_salerate,
        QUALITYCHECKDATE        as      recd_qualitycheckdate,
        QUALITYSTATUS           as      recd_qualitystatus,
        CONSUMEQTY              as      recd_consumeqty,
        QUALITYREF              as      recd_qualityref,
        STATUS                  as      recd_status,
        BATCHNO                 as      recd_batchno,
        ST                      as      recd_st,
        EXPDATE                 as      recd_expdate,
        CCCHARGE                as      recd_cccharge,
        ENTEREDBY               as      recd_enteredby,
        ENTEREDDATETIME         as      recd_entereddatetime,
        ARATE                   as      recd_arate,
        FREE                    as      recd_free,
        DISCOUNTPC              as      recd_discountpc,
        VATPC                   as      recd_vatpc,
        AMOUNT                  as      recd_amount,
        PURCHASEORDERDETAILID   as      recd_purchaseorderdetailid,
        CHALLANDETAILID         as      recd_challandetailid,
        DESCRIPTION             as      recd_description,
        TENDERID                as      recd_tenderid,
        ');

        $this->db3->order_by('RECEIVEDDETAILID','ASC');
        $query=$this->db3->get('RECEIVEDDETAIL');

        if($query->num_rows()>0)
        {
            return $query->result();
        }
        return false;
    }

}
        
                
                 
                
                
              
               
                     
                  
            
    
                
               
                    
                
                
                     
                   