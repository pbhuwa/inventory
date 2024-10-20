<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Api_purchase_received_mdl extends CI_Model 
{
    public function __construct() 
    {
        parent::__construct();
        $this->db3=$this->load->database('inventory',true);
    }
    function get_purchase_requistion_master()
    {
        $this->db3->select('
                REQID          AS  pure_purchasereqid,
                REQ_DATE       AS  pure_reqdatebs,
                APPLIED_BY     AS  pure_appliedby,
                REQUSER        AS  pure_requser,
                REQTIME        AS  pure_reqtime,
                REQUEST_TO     AS  pure_requestto,
                FYEAR          AS  pure_fyear,
                COSTCENTRE     AS  pure_costcenter,
                STOREID        AS  pure_storeid,
                REQNO          AS  pure_reqno,
                ORDERED        AS  pure_ordered,
                ISAPPROVED     AS  pure_isapproved
            ');
                $this->db3->order_by('REQID','ASC');
                $query=$this->db3->get('REQUISITION');
                if($query->num_rows()>0)
                {
                    return $query->result();
                }
                return false;
    }
    function get_purchase_requistion_detail()
    {
        $this->db3->select('
                REQID       AS  purd_reqid,
                REQDETID    AS  purd_reqdetid,
                ITEMSID     AS  purd_itemsid,
                UNIT        AS  purd_unit,
                STORE_STOCK AS  purd_stock,
                QTY         AS  purd_qty,
                RATE        AS  purd_rate,
                BUD_CODE    AS  purd_budcode,
                REMARKS     AS  purd_remarks,
                FYEAR       AS  purd_fyear,
                REQ_DATE    AS  purd_reqdatebs,
                REM_QTY     AS  purd_remqty
                ');
                $this->db3->order_by('REQID','ASC');
                $query=$this->db3->get('REQDETAIL');
                if($query->num_rows()>0)
                {
                    return $query->result();
                }
                return false;
    }
    function get_quotation_master_other_db()
    {
        // print_r($this->db3);
        // die();
        $this->db3->select('
        QUOTATIONMASTERID           as      quma_quotationmasterid,
        SUPPLIERID                  as      quma_supplierid,
        QUOTATIONNUMBER             as      quma_quotationnumber,
        SUPPLIERQUOTATIONNUMBER     as      quma_supplierquotationnumber,
        QUOTATIONDATE               as      quma_quotationdatebs,
        SUPPLIERQUOTATIONDATE       as      quma_supplierquotationdatebs,
        AMOUNT                      as      quma_amount,
        DISCOUNT                    as      quma_discount,
        VAT                         as      quma_vat,
        TOTALAMOUNT                 as      quma_totalamount,
        USER_NAME                   as      quma_username,
        POSTTIME                    as      quma_posttime,
        EXPDATE                     as      quma_expdatebs
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
            QUOTATIONDETAILID           as      qude_quotationdetailid, 
            QUOTATIONMASTERID           as      qude_quotationmasterid, 
            ITEMSID                     as      qude_itemsid,   
            QTY                         as      qude_qty,   
            AMOUNT                      as      qude_amount,    
            DISCOUNTPC                  as      qude_discountpc,    
            VATPC                       as      qude_vatpc, 
            RATE                        as      qude_rate,  
            FREE                        as      qude_free,  
            ARATE                       as      qude_netrate,   
            UNITS                       as      qude_units, 
            REMARKS                     as      qude_remarks,   
            ');
        $this->db3->order_by('QUOTATIONDETAILID','ASC');
        $query=$this->db3->get('QUOTATIONDETAIL');
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
        PURCHASEORDERDATE      as          puor_orderdatebs,
        FYEAR                  as          puor_fyear,
        DELIVERYSITE           as          puor_deliverysite,
        DELIVERYDATE           as          puor_deliverydatebs,
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
        CANCELDATE             as          puor_canceldatebs,
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
        STOREID                as          puor_storeid
        ');
        $this->db3->order_by('PURCHASEORDERMASTERID','ASC');
        $query=$this->db3->get('PURCHASEORDERMASTER');
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
        CANCELDATE              as      pude_canceldatebs,
        STATUS                  as      pude_status,
        USER_NAME               as      pude_username,
        CANCELLEDQTY            as      pude_cancelqty,
        NCRATE                  as      pude_ncrate
        ');
        $this->db3->order_by('PURCHASEORDERDETAILID','ASC');
        $query=$this->db3->get('PURCHASEORDERDETAIL');
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
        ST                 as          purr_st
        ');
        $this->db3->order_by('PURCHASERETURNID','ASC');
        $query=$this->db3->get('PURCHASERETURN');
        // echo $this->db->last_query();
        // die();
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
        EXPDATE                as          prde_expdatebs,
        INVOICENO              as          prde_invoiceno,
        RECEIVEDDETAILID       as          prde_receiveddetailid,
        NOTEQTY                as          prde_noteqty,
        SALERATE               as          prde_salerate,
        FREE                   as          prde_free,
        SUPPLIERID             as          prde_supplierid,
        SUPPLIERBILLNO         as          prde_supplierbillno,
        REMARKS                as          prde_remarks ');
        $this->db3->order_by('PURCHASERETURNDETAILID','ASC');
        $query=$this->db3->get('PURCHASERETURNDETAIL');
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
        DSTAT                      as      recm_dstat,
        TSTAT                      as      recm_tstat,
        CHALLANNO                  as      recm_challanno,
        PURCHASEORDERNO            as      recm_purchaseorderno,
        PURCHASEORDERDATE          as      recm_purchaseorderdatebs,
        QTYCHALLAN                 as      recm_qtychallan,
        QTYRECEIVED                as      recm_qtyreceived,
        SUPPLIERBILLNO             as      recm_supplierbillno,
        RECEIVEDNO                 as      recm_receivedno,
        DEPARTMENTID               as      recm_departmentid,
        STATUS                     as      recm_status,
        ENTEREDBY                  as      recm_enteredby,
        SUPBILLDATE                as      recm_supbilldatebs,
        POSTTIME                   as      recm_posttime,
        INVOICENO                  as      recm_invoiceno,
        INSURANCE                  as      recm_insurance,
        CARRIAGEFREIGHT            as      recm_carriagefreight,
        PACKING                    as      recm_packing,
        TRANSPORTCOURIER           as      recm_transportcourier,
        OTHERS                     as      recm_others,
        REMARKS                    as      recm_remarks,
        CURRENCYSYMBOL             as      recm_currencysymbol,
        CURRENCYRATE               as      recm_currencyrate,
        BUDGETID                   as      recm_budgetid
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
        EXPDATE                 as      recd_expdatebs,
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
        DESCRIPTION             as      recd_description
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
                   