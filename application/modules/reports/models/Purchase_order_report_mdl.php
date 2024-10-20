<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Purchase_order_report_mdl extends CI_Model
{
    public function __construct()
    {
        parent::__construct();

        $this->curtime = $this->general->get_currenttime();
        $this->userid = $this->session->userdata(USER_ID);
        $this->username = $this->session->userdata(USER_NAME);
        $this->userdepid = $this->session->userdata(USER_DEPT); //storeid
        $this->storeid = $this->session->userdata(STORE_ID);
        $this->mac = $this->general->get_Mac_Address();
        $this->ip = $this->general->get_real_ipaddr();
        $this->locationid = $this->session->userdata(LOCATION_ID);
        $this->location_ismain = $this->session->userdata(ISMAIN_LOCATION);
        $this->orgid = $this->session->userdata(ORG_ID);
    }

    public function get_purchase_order_report_summary_ku()
    {
        $locationid = $this->input->post('locationid');
        $searchDateType = $this->input->post('searchDateType');
        $frmDate = $this->input->post('frmDate');
        $toDate = $this->input->post('toDate');
        $store_id = $this->input->post('store_id');
        $supplierid = $this->input->post('supplierid');
        $puro_mattypeid = $this->input->post('puro_mattypeid');
        $schoolid = $this->input->post('school');
        $departmentid = $this->input->post('departmentid');
        $subdepid = $this->input->post('subdepid');
        $rpt_type = $this->input->post('rpt_type');
        $rpt_wise = $this->input->post('rpt_wise');

        // $subdeparray = array();
        // if ($departmentid) {
        //     $check_parentid = $this->general->get_tbl_data('dept_depid,dept_parentdepid', 'dept_department', array('dept_depid' => $departmentid), 'dept_depname', 'ASC');
        // }

        // if (!empty($check_parentid)) {
        //     $parentdepid = !empty($check_parentid[0]->dept_parentdepid) ? $check_parentid[0]->dept_parentdepid : '0';
        //     if ($parentdepid == '0') {
        //         $subdep_result = $this->general->get_tbl_data('dept_depid', 'dept_department', array('dept_parentdepid' => $departmentid), 'dept_depname', 'ASC');
        //         if (!empty($subdep_result)) {
        //             foreach ($subdep_result as $ksd => $dep) {
        //                 $subdeparray[] = $dep->dept_depid;
        //             }
        //         }

        //     }
        // }

        $this->db->start_cache();
        if ($searchDateType == 'date_range') {
            if ($frmDate &&  $toDate) {
               if(DEFAULT_DATEPICKER=='NP')
                { 
                    $this->db->where('po.puor_orderdatebs >=',$frmDate);
                    $this->db->where('po.puor_orderdatebs <=',$toDate);
                }
                else
                {
                    $this->db->where('po.puor_orderdatead >=',$frmDate);
                    $this->db->where('po.puor_orderdatead <=',$toDate);
                }
            }
        }

        if ($this->location_ismain == 'Y') {
            if (!empty($locationid)) {
                $this->db->where('po.puor_locationid', $locationid);
            }
        } else {
            $this->db->where('po.puor_locationid', $this->locationid);
        }

        if (!empty($this->mattypeid)) {
            $this->db->where('po.puro_mattypeid', $this->mattypeid);
        } else {
            if (!empty($puro_mattypeid)) {
                $this->db->where('po.puro_mattypeid', $puro_mattypeid);
            }
        }

        // if (!empty($schoolid)) {
        //     $this->db->where('rm.recm_school', $schoolid);
        // }

        // if (!empty($departmentid)) {

        //     if (!empty($subdepid)) {
        //         $this->db->where("recm_departmentid =" . $subdepid . " ");
        //     } else {
        //         if (!empty($subdeparray)) {
        //             $this->db->where_in("recm_departmentid", $subdeparray);
        //         } else {
        //             $this->db->where("recm_departmentid =" . $departmentid . " ");
        //         }
        //     }
        // }

        if (!empty($store_id)) {
            $this->db->where('puor_storeid', $store_id);
        }

        if (!empty($supplierid)) {
            $this->db->where(array('puor_supplierid' => $supplierid));
        }

        $this->db->stop_cache();

        $this->db->select("po.*,dist_distributor,mt.maty_material");
        $this->db->from('puor_purchaseordermaster po');
        $this->db->join('maty_materialtype mt','mt.maty_materialtypeid=po.puro_mattypeid',"LEF");
        $this->db->join('dist_distributors t','t.dist_distributorid = po.puor_supplierid','LEFT');

        $data['summary'] = $this->db->get()->result();
      
        $this->db->select("dist_distributor as suppliername,SUM(pude_quantity) as qty,SUM(pude_rate) as rate,SUM(pude_quantity*pude_rate) as amount,SUM(pude_amount) as total_amount,pude_vat");
        $this->db->from('puor_purchaseordermaster po');
        $this->db->join('pude_purchaseorderdetail pd','pd.pude_purchasemasterid = po.puor_purchaseordermasterid','left');
        $this->db->join('itli_itemslist il','il.itli_itemlistid = pd.pude_itemsid','left');
        $this->db->join('eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid = il.itli_catid','left');
        $this->db->join('maty_materialtype mt','mt.maty_materialtypeid = po.puro_mattypeid','left');
        $this->db->join('dist_distributors dt','dt.dist_distributorid = po.puor_supplierid','left');
        $this->db->group_by('puor_supplierid');
        $this->db->order_by('dist_distributor','ASC');
        $data['supplier'] = $this->db->get()->result();
        if ($rpt_wise == 'supplier'){
        $this->db->flush_cache();
        unset($array);
        $array['supplier'] = $data['supplier'];
        return $array;
        }

        $this->db->select("maty_material as materialname,SUM(pude_quantity) as qty,SUM(pude_rate) as rate,SUM(pude_quantity*pude_rate) as amount,SUM(pude_amount) as total_amount,pude_vat");
        $this->db->from('puor_purchaseordermaster po');
        $this->db->join('pude_purchaseorderdetail pd','pd.pude_purchasemasterid = po.puor_purchaseordermasterid','left');
        $this->db->join('itli_itemslist il','il.itli_itemlistid = pd.pude_itemsid','left');
        $this->db->join('eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid = il.itli_catid','left');
        $this->db->join('maty_materialtype mt','mt.maty_materialtypeid = po.puro_mattypeid','left');
        $this->db->join('dist_distributors dt','dt.dist_distributorid = po.puor_supplierid','left');
        $this->db->group_by('puro_mattypeid');
        $this->db->order_by('maty_material','ASC');
        $data['material'] = $this->db->get()->result();
        if ($rpt_wise == 'material_type'){
        $this->db->flush_cache();
        unset($array);
        $array['material'] = $data['material'];
        return $array;
        }

        $this->db->select("puor_orderdatebs,puor_orderdatead,SUM(pude_quantity) as qty,SUM(pude_rate) as rate,SUM(pude_quantity*pude_rate) as amount,SUM(pude_amount) as total_amount,pude_vat");
        $this->db->from('puor_purchaseordermaster po');
        $this->db->join('pude_purchaseorderdetail pd','pd.pude_purchasemasterid = po.puor_purchaseordermasterid','left');
        $this->db->join('itli_itemslist il','il.itli_itemlistid = pd.pude_itemsid','left');
        $this->db->join('eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid = il.itli_catid','left');
        $this->db->join('maty_materialtype mt','mt.maty_materialtypeid = po.puro_mattypeid','left');
        $this->db->join('dist_distributors dt','dt.dist_distributorid = po.puor_supplierid','left');
        $this->db->group_by('puor_orderdatebs');
        $this->db->order_by('puor_orderdatebs','ASC');
        $data['order_date'] = $this->db->get()->result();
        if ($rpt_wise == 'order_date'){
        $this->db->flush_cache();
        unset($array);
        $array['order_date'] = $data['order_date'];
        return $array;
        }

        $this->db->select("puor_deliverydatebs,puor_deliverydatead,SUM(pude_quantity) as qty,SUM(pude_rate) as rate,SUM(pude_quantity*pude_rate) as amount,SUM(pude_amount) as total_amount,pude_vat");
        $this->db->from('puor_purchaseordermaster po');
        $this->db->join('pude_purchaseorderdetail pd','pd.pude_purchasemasterid = po.puor_purchaseordermasterid','left');
        $this->db->join('itli_itemslist il','il.itli_itemlistid = pd.pude_itemsid','left');
        $this->db->join('eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid = il.itli_catid','left');
        $this->db->join('maty_materialtype mt','mt.maty_materialtypeid = po.puro_mattypeid','left');
        $this->db->join('dist_distributors dt','dt.dist_distributorid = po.puor_supplierid','left');
        $this->db->group_by('puor_deliverydatebs');
        $this->db->order_by('puor_deliverydatebs','ASC');
        $data['delivery_date'] = $this->db->get()->result();
        if ($rpt_wise == 'delivery_date'){
        $this->db->flush_cache();
        unset($array);
        $array['delivery_date'] = $data['delivery_date'];
        return $array;
        }

        $this->db->flush_cache();
        return $data; 
    }

    public function get_purchase_order_report_detail_ku()
    {   
        $locationid = $this->input->post('locationid');
        $searchDateType = $this->input->post('searchDateType');
        $frmDate = $this->input->post('frmDate');
        $toDate = $this->input->post('toDate');
        $store_id = $this->input->post('store_id');
        $supplierid = $this->input->post('supplierid');
        $puro_mattypeid = $this->input->post('puro_mattypeid');
        $rpt_type = $this->input->post('rpt_type');
        $rpt_wise = $this->input->post('rpt_wise');

        $this->db->start_cache();
        if ($searchDateType == 'date_range') {
            if ($frmDate &&  $toDate) {
               if(DEFAULT_DATEPICKER=='NP')
                { 
                    $this->db->where('po.puor_orderdatebs >=',$frmDate);
                    $this->db->where('po.puor_orderdatebs <=',$toDate);
                }
                else
                {
                    $this->db->where('po.puor_orderdatead >=',$frmDate);
                    $this->db->where('po.puor_orderdatead <=',$toDate);
                }
            }
        }

        if ($this->location_ismain == 'Y') {
            if (!empty($locationid)) {
                $this->db->where('po.puor_locationid', $locationid);
            }
        } else {
            $this->db->where('po.puor_locationid', $this->locationid);
        }

        if (!empty($this->mattypeid)) {
            $this->db->where('po.puro_mattypeid', $this->mattypeid);
        } else {
            if (!empty($puro_mattypeid)) {
                $this->db->where('po.puro_mattypeid', $puro_mattypeid);
            }
        }

        if (!empty($store_id)) {
            $this->db->where('puor_storeid', $store_id);
        }

        if (!empty($supplierid)) {
            $this->db->where('puor_supplierid', $supplierid);
        }

        $this->db->stop_cache();

        $this->db->select('po.puor_orderdatebs as orderdatebs, po.puor_orderdatead as orderdatead,po.puor_remarks as remarks, il.itli_itemcode as itemcode, il.itli_itemname as itemname,il.itli_itemnamenp as itemnamenp, mt.maty_material as materialname, dist_distributor as suppliername,
            ec.eqca_category as category, po.puor_orderno as orderno, pd.pude_quantity as quantity, pd.pude_unit as unit, pd.pude_rate as rate, pd.pude_vat as vat, 
            pd.pude_discount as discount, pd.pude_amount as amount, pd.pude_remarks , po.puor_requno as requno,puor_deliverydatead,puor_deliverydatebs');
        $this->db->from('puor_purchaseordermaster po');
        $this->db->join('pude_purchaseorderdetail pd','pd.pude_purchasemasterid = po.puor_purchaseordermasterid','left');
        $this->db->join('itli_itemslist il','il.itli_itemlistid = pd.pude_itemsid','left');
        $this->db->join('eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid = il.itli_catid','left');
        $this->db->join('maty_materialtype mt','mt.maty_materialtypeid = po.puro_mattypeid','left');
        $this->db->join('dist_distributors dt','dt.dist_distributorid = po.puor_supplierid','left');
        $this->db->flush_cache();
        
        return $this->db->get()->result();

    }

    public function purchase_order_report_supplier_detail_ku()
    {
        $locationid = $this->input->post('locationid');
        $searchDateType = $this->input->post('searchDateType');
        $frmDate = $this->input->post('frmDate');
        $toDate = $this->input->post('toDate');
        $store_id = $this->input->post('store_id');
        $supplierid = $this->input->post('supplierid');
        $puro_mattypeid = $this->input->post('puro_mattypeid');
        $rpt_type = $this->input->post('rpt_type');
        $rpt_wise = $this->input->post('rpt_wise');

        $this->db->start_cache();
        if ($searchDateType == 'date_range') {
            if ($frmDate &&  $toDate) {
               if(DEFAULT_DATEPICKER=='NP')
                { 
                    $this->db->where('po.puor_orderdatebs >=',$frmDate);
                    $this->db->where('po.puor_orderdatebs <=',$toDate);
                }
                else
                {
                    $this->db->where('po.puor_orderdatead >=',$frmDate);
                    $this->db->where('po.puor_orderdatead <=',$toDate);
                }
            }
        }

        if ($this->location_ismain == 'Y') {
            if (!empty($locationid)) {
                $this->db->where('po.puor_locationid', $locationid);
            }
        } else {
            $this->db->where('po.puor_locationid', $this->locationid);
        }

        if (!empty($this->mattypeid)) {
            $this->db->where('po.puro_mattypeid', $this->mattypeid);
        } else {
            if (!empty($puro_mattypeid)) {
                $this->db->where('po.puro_mattypeid', $puro_mattypeid);
            }
        }

        if (!empty($store_id)) {
            $this->db->where('puor_storeid', $store_id);
        }
        $this->db->stop_cache();

        if (!empty($supplierid)) {
            $this->db->where(array('puor_supplierid' => $supplierid));
        }

        $supplier_list = $this->db->select('DISTINCT(puor_supplierid),dist_distributor')
        ->from('puor_purchaseordermaster po')->join('dist_distributors dt','dt.dist_distributorid = po.puor_supplierid','left')->get()->result();

        $supplier = array();

        foreach ($supplier_list as $key => $value) {
            $supplier[$key]['name'] = $value->dist_distributor;

            $this->db->select('po.puor_orderdatebs as orderdatebs, po.puor_orderdatead as orderdatead,po.puor_remarks as remarks, il.itli_itemcode as itemcode, il.itli_itemname as itemname,il.itli_itemnamenp as itemnamenp, mt.maty_material as materialname, dist_distributor as suppliername,
                ec.eqca_category as category, po.puor_orderno as orderno, pd.pude_quantity as quantity, pd.pude_unit as unit, pd.pude_rate as rate, pd.pude_vat as vat, 
                pd.pude_discount as discount, pd.pude_amount as amount, pd.pude_remarks , po.puor_requno as requno,puor_deliverydatead,puor_deliverydatebs');
            $this->db->from('puor_purchaseordermaster po');
            $this->db->join('pude_purchaseorderdetail pd','pd.pude_purchasemasterid = po.puor_purchaseordermasterid','left');
            $this->db->join('itli_itemslist il','il.itli_itemlistid = pd.pude_itemsid','left');
            $this->db->join('eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid = il.itli_catid','left');
            $this->db->join('maty_materialtype mt','mt.maty_materialtypeid = po.puro_mattypeid','left');
            $this->db->join('dist_distributors dt','dt.dist_distributorid = po.puor_supplierid','left');
            $this->db->where('puor_supplierid',$value->puor_supplierid);
            $supplier[$key]['details'] = $this->db->get()->result();
        }
        $this->db->flush_cache();
        // echo "<pre>";
        // print_r($this->db->get()->result());
        // die();
        return $supplier;
    }

    public function purchase_order_report_material_type_detail_ku()
    {
        $locationid = $this->input->post('locationid');
        $searchDateType = $this->input->post('searchDateType');
        $frmDate = $this->input->post('frmDate');
        $toDate = $this->input->post('toDate');
        $store_id = $this->input->post('store_id');
        $supplierid = $this->input->post('supplierid');
        $puro_mattypeid = $this->input->post('puro_mattypeid');
        $rpt_type = $this->input->post('rpt_type');
        $rpt_wise = $this->input->post('rpt_wise');

        $this->db->start_cache();
        if ($searchDateType == 'date_range') {
            if ($frmDate &&  $toDate) {
               if(DEFAULT_DATEPICKER=='NP')
                { 
                    $this->db->where('po.puor_orderdatebs >=',$frmDate);
                    $this->db->where('po.puor_orderdatebs <=',$toDate);
                }
                else
                {
                    $this->db->where('po.puor_orderdatead >=',$frmDate);
                    $this->db->where('po.puor_orderdatead <=',$toDate);
                }
            }
        }

        if ($this->location_ismain == 'Y') {
            if (!empty($locationid)) {
                $this->db->where('po.puor_locationid', $locationid);
            }
        } else {
            $this->db->where('po.puor_locationid', $this->locationid);
        }

        if (!empty($store_id)) {
            $this->db->where('puor_storeid', $store_id);
        }

        if (!empty($supplierid)) {
            $this->db->where(array('puor_supplierid' => $supplierid));
        }
        $this->db->stop_cache();

        if (!empty($this->mattypeid)) {
            $this->db->where('po.puro_mattypeid', $this->mattypeid);
        } else {
            if (!empty($puro_mattypeid)) {
                $this->db->where('po.puro_mattypeid', $puro_mattypeid);
            }
        }

        $material_list = $this->db->select('DISTINCT(puro_mattypeid),mt.maty_material')
        ->from('puor_purchaseordermaster po')->join('maty_materialtype mt','mt.maty_materialtypeid = po.puro_mattypeid','left')->get()->result();

        $material = array();

        foreach ($material_list as $key => $value) {
            $material[$key]['name'] = $value->maty_material;

            $this->db->select('po.puor_orderdatebs as orderdatebs, po.puor_orderdatead as orderdatead,po.puor_remarks as remarks, il.itli_itemcode as itemcode, il.itli_itemname as itemname,il.itli_itemnamenp as itemnamenp, mt.maty_material as materialname, dist_distributor as suppliername,
                ec.eqca_category as category, po.puor_orderno as orderno, pd.pude_quantity as quantity, pd.pude_unit as unit, pd.pude_rate as rate, pd.pude_vat as vat, 
                pd.pude_discount as discount, pd.pude_amount as amount, pd.pude_remarks , po.puor_requno as requno,puor_deliverydatead,puor_deliverydatebs');
            $this->db->from('puor_purchaseordermaster po');
            $this->db->join('pude_purchaseorderdetail pd','pd.pude_purchasemasterid = po.puor_purchaseordermasterid','left');
            $this->db->join('itli_itemslist il','il.itli_itemlistid = pd.pude_itemsid','left');
            $this->db->join('eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid = il.itli_catid','left');
            $this->db->join('maty_materialtype mt','mt.maty_materialtypeid = po.puro_mattypeid','left');
            $this->db->join('dist_distributors dt','dt.dist_distributorid = po.puor_supplierid','left');
            $this->db->where('puro_mattypeid',$value->puro_mattypeid);
            $material[$key]['details'] = $this->db->get()->result();
        }
        $this->db->flush_cache();
        // echo "<pre>";
        // print_r($this->db->get()->result());
        // die();
        return $material;
    }

    public function purchase_order_report_order_date_detail_ku()
    {
        $locationid = $this->input->post('locationid');
        $searchDateType = $this->input->post('searchDateType');
        $frmDate = $this->input->post('frmDate');
        $toDate = $this->input->post('toDate');
        $store_id = $this->input->post('store_id');
        $supplierid = $this->input->post('supplierid');
        $puro_mattypeid = $this->input->post('puro_mattypeid');
        $rpt_type = $this->input->post('rpt_type');
        $rpt_wise = $this->input->post('rpt_wise');

        $this->db->start_cache();
        if ($searchDateType == 'date_range') {
            if ($frmDate &&  $toDate) {
               if(DEFAULT_DATEPICKER=='NP')
                { 
                    $this->db->where('po.puor_orderdatebs >=',$frmDate);
                    $this->db->where('po.puor_orderdatebs <=',$toDate);
                }
                else
                {
                    $this->db->where('po.puor_orderdatead >=',$frmDate);
                    $this->db->where('po.puor_orderdatead <=',$toDate);
                }
            }
        }

        if ($this->location_ismain == 'Y') {
            if (!empty($locationid)) {
                $this->db->where('po.puor_locationid', $locationid);
            }
        } else {
            $this->db->where('po.puor_locationid', $this->locationid);
        }

        if (!empty($store_id)) {
            $this->db->where('puor_storeid', $store_id);
        }

        if (!empty($supplierid)) {
            $this->db->where(array('puor_supplierid' => $supplierid));
        }
        $this->db->stop_cache();

        if (!empty($this->mattypeid)) {
            $this->db->where('po.puro_mattypeid', $this->mattypeid);
        } else {
            if (!empty($puro_mattypeid)) {
                $this->db->where('po.puro_mattypeid', $puro_mattypeid);
            }
        }

        $order_date_list = $this->db->select('DISTINCT(puor_orderdatebs),puor_orderdatead')
        ->from('puor_purchaseordermaster po')->get()->result();

        $demand_date = array();

        foreach ($order_date_list as $key => $value) {
            $demand_date[$key]['name'] = "$value->puor_orderdatebs (B.S) - $value->puor_orderdatead (A.D)";

            $this->db->select('po.puor_orderdatebs as orderdatebs, po.puor_orderdatead as orderdatead,po.puor_remarks as remarks, il.itli_itemcode as itemcode, il.itli_itemname as itemname,il.itli_itemnamenp as itemnamenp, mt.maty_material as materialname, dist_distributor as suppliername,
                ec.eqca_category as category, po.puor_orderno as orderno, pd.pude_quantity as quantity, pd.pude_unit as unit, pd.pude_rate as rate, pd.pude_vat as vat, 
                pd.pude_discount as discount, pd.pude_amount as amount, pd.pude_remarks , po.puor_requno as requno,puor_deliverydatead,puor_deliverydatebs');
            $this->db->from('puor_purchaseordermaster po');
            $this->db->join('pude_purchaseorderdetail pd','pd.pude_purchasemasterid = po.puor_purchaseordermasterid','left');
            $this->db->join('itli_itemslist il','il.itli_itemlistid = pd.pude_itemsid','left');
            $this->db->join('eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid = il.itli_catid','left');
            $this->db->join('maty_materialtype mt','mt.maty_materialtypeid = po.puro_mattypeid','left');
            $this->db->join('dist_distributors dt','dt.dist_distributorid = po.puor_supplierid','left');
            $this->db->where('puor_orderdatebs',$value->puor_orderdatebs);
            $demand_date[$key]['details'] = $this->db->get()->result();
        }
        $this->db->flush_cache();
        // echo "<pre>";
        // print_r($this->db->get()->result());
        // die();
        return $demand_date;   
    }

    public function purchase_order_report_delivery_date_detail_ku()
    {
        $locationid = $this->input->post('locationid');
        $searchDateType = $this->input->post('searchDateType');
        $frmDate = $this->input->post('frmDate');
        $toDate = $this->input->post('toDate');
        $store_id = $this->input->post('store_id');
        $supplierid = $this->input->post('supplierid');
        $puro_mattypeid = $this->input->post('puro_mattypeid');
        $rpt_type = $this->input->post('rpt_type');
        $rpt_wise = $this->input->post('rpt_wise');

        $this->db->start_cache();
        if ($searchDateType == 'date_range') {
            if ($frmDate &&  $toDate) {
               if(DEFAULT_DATEPICKER=='NP')
                { 
                    $this->db->where('po.puor_orderdatebs >=',$frmDate);
                    $this->db->where('po.puor_orderdatebs <=',$toDate);
                }
                else
                {
                    $this->db->where('po.puor_orderdatead >=',$frmDate);
                    $this->db->where('po.puor_orderdatead <=',$toDate);
                }
            }
        }

        if ($this->location_ismain == 'Y') {
            if (!empty($locationid)) {
                $this->db->where('po.puor_locationid', $locationid);
            }
        } else {
            $this->db->where('po.puor_locationid', $this->locationid);
        }

        if (!empty($store_id)) {
            $this->db->where('puor_storeid', $store_id);
        }

        if (!empty($supplierid)) {
            $this->db->where(array('puor_supplierid' => $supplierid));
        }
        $this->db->stop_cache();

        if (!empty($this->mattypeid)) {
            $this->db->where('po.puro_mattypeid', $this->mattypeid);
        } else {
            if (!empty($puro_mattypeid)) {
                $this->db->where('po.puro_mattypeid', $puro_mattypeid);
            }
        }

        $delivery_date_list = $this->db->select('DISTINCT(puor_deliverydatebs),puor_deliverydatead')
        ->from('puor_purchaseordermaster po')->get()->result();

        $delivery_date = array();

        foreach ($delivery_date_list as $key => $value) {
            $delivery_date[$key]['name'] = "$value->puor_deliverydatebs (B.S) - $value->puor_deliverydatead (A.D)";

            $this->db->select('po.puor_orderdatebs as orderdatebs, po.puor_orderdatead as orderdatead,po.puor_remarks as remarks, il.itli_itemcode as itemcode, il.itli_itemname as itemname,il.itli_itemnamenp as itemnamenp, mt.maty_material as materialname, dist_distributor as suppliername,
                ec.eqca_category as category, po.puor_orderno as orderno, pd.pude_quantity as quantity, pd.pude_unit as unit, pd.pude_rate as rate, pd.pude_vat as vat, 
                pd.pude_discount as discount, pd.pude_amount as amount, pd.pude_remarks , po.puor_requno as requno,puor_deliverydatead,puor_deliverydatebs');
            $this->db->from('puor_purchaseordermaster po');
            $this->db->join('pude_purchaseorderdetail pd','pd.pude_purchasemasterid = po.puor_purchaseordermasterid','left');
            $this->db->join('itli_itemslist il','il.itli_itemlistid = pd.pude_itemsid','left');
            $this->db->join('eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid = il.itli_catid','left');
            $this->db->join('maty_materialtype mt','mt.maty_materialtypeid = po.puro_mattypeid','left');
            $this->db->join('dist_distributors dt','dt.dist_distributorid = po.puor_supplierid','left');
            $this->db->where('puor_deliverydatebs',$value->puor_deliverydatebs);
            $delivery_date[$key]['details'] = $this->db->get()->result();
        }
        $this->db->flush_cache();
        // echo "<pre>";
        // print_r($this->db->get()->result());
        // die();
        return $delivery_date;  
    }
}