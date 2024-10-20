<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Purchase_received_report_mdl extends CI_Model
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

    public function get_purchase_received_summarydata_ku()
    {

        $locationid = $this->input->post('locationid');
        $searchDateType = $this->input->post('searchDateType');
        $frmDate = $this->input->post('frmDate');
        $toDate = $this->input->post('toDate');
        $store_id = $this->input->post('store_id');
        $supplierid = $this->input->post('supplierid');
        $recm_mattypeid = $this->input->post('recm_mattypeid');
        $schoolid = $this->input->post('school');
        $departmentid = $this->input->post('departmentid');
        $subdepid = $this->input->post('subdepid');
        $recm_receivedby = $this->input->post('recm_receivedby');
        $rpt_type = $this->input->post('rpt_type');
        $rpt_wise = $this->input->post('rpt_wise');

        $subdeparray = array();
        if ($departmentid) {
            $check_parentid = $this->general->get_tbl_data('dept_depid,dept_parentdepid', 'dept_department', array('dept_depid' => $departmentid), 'dept_depname', 'ASC');
        }

        if (!empty($check_parentid)) {
            $parentdepid = !empty($check_parentid[0]->dept_parentdepid) ? $check_parentid[0]->dept_parentdepid : '0';
            if ($parentdepid == '0') {
                $subdep_result = $this->general->get_tbl_data('dept_depid', 'dept_department', array('dept_parentdepid' => $departmentid), 'dept_depname', 'ASC');
                if (!empty($subdep_result)) {
                    foreach ($subdep_result as $ksd => $dep) {
                        $subdeparray[] = $dep->dept_depid;
                    }
                }

            }
        }

        $this->db->start_cache();
        if ($searchDateType == 'date_range') {
            if ($frmDate &&  $toDate) {
                if (DEFAULT_DATEPICKER == 'NP') {
                    $this->db->where('recm_receiveddatebs >=', $frmDate);
                    $this->db->where('recm_receiveddatebs <=', $toDate);
                } else {
                    $this->db->where('recm_receiveddatead >=', $frmDate);
                    $this->db->where('recm_receiveddatead <=', $toDate);
                }
            }
        }

        if ($this->location_ismain == 'Y') {
            if (!empty($locationid)) {
                $this->db->where('rm.recm_locationid', $locationid);
            }
        } else {
            $this->db->where('rm.recm_locationid', $this->locationid);
        }

        if (!empty($this->mattypeid)) {
            $this->db->where('rm.recm_mattypeid', $this->mattypeid);
        } else {
            if (!empty($recm_mattypeid)) {
                $this->db->where('rm.recm_mattypeid', $recm_mattypeid);
            }
        }

        if ( (!empty($this->mattypeid) && $this->mattypeid == '2') || (!empty($recm_mattypeid) && $recm_mattypeid == '2') ) { 
          if (!empty($recm_receivedby)) {
              $staffid = explode(',',$recm_receivedby);
              if($staffid[0] != '1') 
                $this->db->where('rm.recm_receivedstaffid', $staffid[0]);
          }
        }

        if (!empty($schoolid)) {
            $this->db->where('rm.recm_school', $schoolid);
        }

        if (!empty($departmentid)) {

            if (!empty($subdepid)) {
                $this->db->where("recm_departmentid =" . $subdepid . " ");
            } else {
                if (!empty($subdeparray)) {
                    $this->db->where_in("recm_departmentid", $subdeparray);
                } else {
                    $this->db->where("recm_departmentid =" . $departmentid . " ");
                }
            }
        }

        if (!empty($store_id)) {
            $this->db->where('recm_storeid', $store_id);
        }

        if (!empty($supplierid)) {
            $this->db->where(array('rm.recm_supplierid' => $supplierid));
        }

        $this->db->stop_cache();

        $this->db->select("recm_supplierid,ds.dist_distributor as suppliername,SUM(recm_amount) as amount,SUM(recm_discount) as discount,SUM(recm_taxamount)  as taxamount,SUM(recm_refund) as refund,SUM(recm_clearanceamount) as recm_gtotal");
        $this->db->from('recm_receivedmaster rm');
        $this->db->join('dist_distributors ds', 'ds.dist_distributorid = rm.recm_supplierid', 'LEFT');
        $this->db->where('recm_status', 'O');
        $this->db->group_by('recm_supplierid');
        $this->db->order_by('ds.dist_distributor', 'ASC');
 
       
        $data['suppliers'] = $this->db->get()->result();
        //  echo $this->db->last_query();
        // die();
        if ($rpt_wise == 'supplier'){
       $this->db->flush_cache();
        unset($array);
        $array['suppliers'] = $data['suppliers'];
        return $array;
        } 


       $this->db->select("recm_mattypeid,mt.maty_material as materialname,SUM(recm_amount) as amount,SUM(recm_discount) as discount,SUM(recm_taxamount)  as taxamount,SUM(recm_refund) as refund,SUM(recm_clearanceamount) as recm_gtotal");
        $this->db->from('recm_receivedmaster rm');
        $this->db->join('maty_materialtype mt', 'mt.maty_materialtypeid=rm.recm_mattypeid', "LEFT");
        $this->db->where('recm_status', 'O');
        $this->db->group_by('recm_mattypeid');
        $this->db->order_by('mt.maty_material', 'ASC');
        $data['material'] = $this->db->get()->result();
        if ($rpt_wise == 'material_type'){ 
          $this->db->flush_cache();
          unset($array);
          $array['material'] = $data['material'];
          return $array;
        }

        $this->db->select("recm_school,scf.loca_name as schoolname,SUM(recm_amount) as amount,SUM(recm_discount) as discount,SUM(recm_taxamount)  as taxamount,SUM(recm_refund) as refund,SUM(recm_clearanceamount) as recm_gtotal");
        $this->db->from('recm_receivedmaster rm');
        $this->db->join('loca_location scf','rm.recm_school=scf.loca_locationid','LEFT');
        $this->db->where('recm_status', 'O');
        $this->db->group_by('recm_school');
        $this->db->order_by('scf.loca_name', 'ASC');
         $data['school'] = $this->db->get()->result();
        if ($rpt_wise == 'school'){
        $this->db->flush_cache();
        unset($array);
        $array['school'] = $data['school'];
          return $array;
        } 


        $this->db->select("recm_departmentid,dtf.dept_depname as departmentname,SUM(recm_amount) as amount,SUM(recm_discount) as discount,SUM(recm_taxamount)  as taxamount,SUM(recm_refund) as refund,SUM(recm_clearanceamount) as recm_gtotal");
        $this->db->from('recm_receivedmaster rm');
        $this->db->join('dept_department dtf','rm.recm_departmentid=dtf.dept_depid','LEFT');
        $this->db->where('recm_status', 'O');
        $this->db->group_by('recm_departmentid');
        $this->db->order_by('dtf.dept_depname', 'ASC');
         $data['department'] = $this->db->get()->result();
        if ($rpt_wise == 'department') {
          $this->db->flush_cache();
          unset($array);
          $array['department'] = $data['department'];
          return $array;
        }

        // Items Summary

        $this->db->select("il.itli_itemname as itemname,SUM(recd_unitprice) as amount,SUM(recd_discountamt) as discount,SUM(recd_vatamt)  as taxamount,SUM(recd_amount) as recm_gtotal,SUM(recd_purchasedqty) as qty");
        $this->db->from('recm_receivedmaster rm');
        $this->db->join('recd_receiveddetail rd','rm.recm_receivedmasterid = rd.recd_receivedmasterid','LEFT');
        $this->db->join('itli_itemslist il','il.itli_itemlistid = rd.recd_itemsid','LEFT');
        $this->db->where('recm_status', 'O');
        $this->db->where('il.itli_itemlistid IS NOT NULL');
        $this->db->group_by('rd.recd_itemsid ');
        $this->db->order_by('il.itli_itemname', 'ASC');
        $data['items'] = $this->db->get()->result();

        if ($rpt_wise == 'item') {
          $this->db->flush_cache();
          unset($array);
          $array['items'] = $data['items'];
          return $array;
        }


        $this->db->select("recm_budgetid,b.budg_budgetname as budgetname,SUM(recm_amount) as amount,SUM(recm_discount) as discount,SUM(recm_taxamount)  as taxamount,SUM(recm_refund) as refund,SUM(recm_clearanceamount) as recm_gtotal");
        $this->db->from('recm_receivedmaster rm');
        $this->db->join('budg_budgets b', 'b.budg_budgetid = rm.recm_budgetid', 'LEFT');
        $this->db->where('recm_status', 'O');
        $this->db->group_by('recm_budgetid');
        $this->db->order_by('b.budg_budgetname', 'ASC');
         $data['budget_head'] = $this->db->get()->result();


        $this->db->select("recm_receivedstaffid,st.stin_fname,st.stin_mname,st.stin_lname,SUM(recm_amount) as amount,SUM(recm_discount) as discount,SUM(recm_taxamount)  as taxamount,SUM(recm_refund) as refund,SUM(recm_clearanceamount) as recm_gtotal,0 as qty");
        $this->db->from('recm_receivedmaster rm');
        $this->db->join('stin_staffinfo st', 'st.stin_staffinfoid = rm.recm_receivedstaffid', 'LEFT');
        $this->db->where('recm_status', 'O');
        $this->db->group_by('recm_receivedstaffid');
        $this->db->order_by('st.stin_fname', 'ASC');
         $data['staff_info'] = $this->db->get()->result();
          if ($rpt_wise == 'receiver') {
          $this->db->flush_cache();
          unset($array);
          $array['staff_info'] = $data['staff_info'];
          return $array;
        }

        $this->db->select("recm_receiveddatebs,recm_receiveddatead,SUM(recm_amount) as amount,SUM(recm_discount) as discount,SUM(recm_taxamount)  as taxamount,SUM(recm_refund) as refund,SUM(recm_clearanceamount) as recm_gtotal,0 as qty");
        $this->db->from('recm_receivedmaster rm');
        $this->db->where('recm_status', 'O');
        $this->db->group_by('recm_receiveddatebs');
        $this->db->order_by('recm_receiveddatebs', 'ASC');
         $data['received_date'] = $this->db->get()->result();
          if ($rpt_wise == 'received_date') {
          $this->db->flush_cache();
          unset($array);
          $array['received_date'] = $data['received_date'];
          return $array;
        }

        $this->db->select("recm_supbilldatebs,recm_supbilldatead,recm_receiveddatead,SUM(recm_amount) as amount,SUM(recm_discount) as discount,SUM(recm_taxamount)  as taxamount,SUM(recm_refund) as refund,SUM(recm_clearanceamount) as recm_gtotal,0 as qty");
        $this->db->from('recm_receivedmaster rm');
        $this->db->where('recm_status', 'O');
        $this->db->group_by('recm_supbilldatebs');
        $this->db->order_by('recm_supbilldatebs', 'ASC');
         $data['bill_date'] = $this->db->get()->result();
   // echo $this->db->last_query();
         // die();
          if ($rpt_wise == 'bill_date') {
          $this->db->flush_cache();
          unset($array);

          $array['bill_date'] = $data['bill_date'];
          return $array;
        }

         


        
        $this->db->flush_cache();

        return $data;
    }


    public function get_purchase_received_summarydata()
    {
        $locationid = $this->input->post('locationid');
        $searchDateType = $this->input->post('searchDateType');
        $frmDate = $this->input->post('frmDate');
        $toDate = $this->input->post('toDate');
        $store_id = $this->input->post('store_id');
        $supplierid = $this->input->post('supplierid');
        $recm_mattypeid = $this->input->post('recm_mattypeid');
        $departmentid = $this->input->post('departmentid');
        $subdepid = $this->input->post('subdepid');
        $recm_receivedby = $this->input->post('recm_receivedby');
        $itemid= $this->input->post('itemid');
        $rpt_type = $this->input->post('rpt_type');
        $rpt_wise = $this->input->post('rpt_wise');

        $subdeparray = array();
        if ($departmentid) {
            $check_parentid = $this->general->get_tbl_data('dept_depid,dept_parentdepid', 'dept_department', array('dept_depid' => $departmentid), 'dept_depname', 'ASC');
        }

        if (!empty($check_parentid)) {
            $parentdepid = !empty($check_parentid[0]->dept_parentdepid) ? $check_parentid[0]->dept_parentdepid : '0';
            if ($parentdepid == '0') {
                $subdep_result = $this->general->get_tbl_data('dept_depid', 'dept_department', array('dept_parentdepid' => $departmentid), 'dept_depname', 'ASC');
                if (!empty($subdep_result)) {
                    foreach ($subdep_result as $ksd => $dep) {
                        $subdeparray[] = $dep->dept_depid;
                    }
                }

            }
        }

        $this->db->start_cache();
        if ($searchDateType == 'date_range') {
            if ($frmDate &&  $toDate) {
                if (DEFAULT_DATEPICKER == 'NP') {
                    $this->db->where('recm_receiveddatebs >=', $frmDate);
                    $this->db->where('recm_receiveddatebs <=', $toDate);
                } else {
                    $this->db->where('recm_receiveddatead >=', $frmDate);
                    $this->db->where('recm_receiveddatead <=', $toDate);
                }
            }
        }

        if ($this->location_ismain == 'Y') {
            if (!empty($locationid)) {
                $this->db->where('rm.recm_locationid', $locationid);
            }
        } else {
            $this->db->where('rm.recm_locationid', $this->locationid);
        }

        // if (!empty($this->mattypeid)) {
        //     $this->db->where('rm.recm_mattypeid', $this->mattypeid);
        // } else {
        //     if (!empty($recm_mattypeid)) {
        //         $this->db->where('rm.recm_mattypeid', $recm_mattypeid);
        //     }
        // }

        // if ( (!empty($this->mattypeid) && $this->mattypeid == '2') || (!empty($recm_mattypeid) && $recm_mattypeid == '2') ) { 
        //   if (!empty($recm_receivedby)) {
        //       $staffid = explode(',',$recm_receivedby);
        //       if($staffid[0] != '1') 
        //         $this->db->where('rm.recm_receivedstaffid', $staffid[0]);
        //   }
        // }

     
        if (!empty($departmentid)) {

            if (!empty($subdepid)) {
                $this->db->where("recm_departmentid =" . $subdepid . " ");
            } else {
                if (!empty($subdeparray)) {
                    $this->db->where_in("recm_departmentid", $subdeparray);
                } else {
                    $this->db->where("recm_departmentid =" . $departmentid . " ");
                }
            }
        }

        if (!empty($store_id)) {
            $this->db->where('recm_storeid', $store_id);
        }

        if (!empty($supplierid)) {
            $this->db->where(array('rm.recm_supplierid' => $supplierid));
        }

        

        $this->db->stop_cache();

        $this->db->select("recm_supplierid,ds.dist_distributor as suppliername,SUM(recm_amount) as amount,SUM(recm_discount) as discount,SUM(recm_taxamount)  as taxamount,SUM(recm_refund) as refund,SUM(recm_clearanceamount) as recm_gtotal");
        $this->db->from('recm_receivedmaster rm');
        $this->db->join('dist_distributors ds', 'ds.dist_distributorid = rm.recm_supplierid', 'LEFT');
        $this->db->where('recm_status', 'O');
        $this->db->group_by('recm_supplierid');
        $this->db->order_by('ds.dist_distributor', 'ASC');

        $data['suppliers'] = $this->db->get()->result();
        if ($rpt_wise == 'supplier'){
        $this->db->flush_cache();
        unset($array);
        $array['suppliers'] = $data['suppliers'];
        return $array;
        } 


       $this->db->select("recm_mattypeid,mt.maty_material as materialname,SUM(recm_amount) as amount,SUM(recm_discount) as discount,SUM(recm_taxamount)  as taxamount,SUM(recm_refund) as refund,SUM(recm_clearanceamount) as recm_gtotal");
        $this->db->from('recm_receivedmaster rm');
        $this->db->join('maty_materialtype mt', 'mt.maty_materialtypeid=rm.recm_mattypeid', "LEFT");
        $this->db->where('recm_status', 'O');
        $this->db->group_by('recm_mattypeid');
        $this->db->order_by('mt.maty_material', 'ASC');
        $data['material'] = $this->db->get()->result();
        if ($rpt_wise == 'material_type'){ 
          $this->db->flush_cache();
          unset($array);
          $array['material'] = $data['material'];
          return $array;
        }


         $this->db->select("recm_receivedmasterid,recm_invoiceno,recm_receiveddatebs,recm_purchaseorderno,recm_supbilldatebs,recm_supplierbillno,SUM(recm_amount) as amount,SUM(recm_discount) as discount,SUM(recm_taxamount)  as taxamount,SUM(recm_refund) as refund,SUM(recm_clearanceamount) as recm_gtotal,s.dist_distributor");
        $this->db->from('recm_receivedmaster rm');
         $this->db->join('dist_distributors s', 's.dist_distributorid = rm.recm_supplierid', 'LEFT');
        $this->db->where('recm_status', 'O');
        $this->db->group_by('recm_receivedmasterid');
        $this->db->order_by('rm.recm_receivedmasterid', 'ASC');
        $data['invoice'] = $this->db->get()->result();
        if ($rpt_wise == 'invoice_wise'){ 
          $this->db->flush_cache();
          unset($array);
          $array['invoice'] = $data['invoice'];
          return $array;
        }
       

        $this->db->select("recm_departmentid,dtf.dept_depname as departmentname,SUM(recm_amount) as amount,SUM(recm_discount) as discount,SUM(recm_taxamount)  as taxamount,SUM(recm_refund) as refund,SUM(recm_clearanceamount) as recm_gtotal");
        $this->db->from('recm_receivedmaster rm');
        $this->db->join('dept_department dtf','rm.recm_departmentid=dtf.dept_depid','LEFT');
        $this->db->where('recm_status', 'O');
        $this->db->group_by('recm_departmentid');
        $this->db->order_by('dtf.dept_depname', 'ASC');
         $data['department'] = $this->db->get()->result();
        if ($rpt_wise == 'department') {
          $this->db->flush_cache();
          unset($array);
          $array['department'] = $data['department'];
          return $array;
        }

        // Items Summary

        $this->db->select("il.itli_itemcode,il.itli_itemname as itemname,SUM(recd_unitprice) *recd_purchasedqty as amount,SUM(recd_discountamt) as discount,SUM(recd_vatamt)  as taxamount,SUM(recd_amount) as recm_gtotal,SUM(recd_purchasedqty) as qty");
        $this->db->from('recm_receivedmaster rm');
        $this->db->join('recd_receiveddetail rd','rm.recm_receivedmasterid = rd.recd_receivedmasterid','LEFT');
        $this->db->join('itli_itemslist il','il.itli_itemlistid = rd.recd_itemsid','LEFT');
        $this->db->where('recm_status', 'O');
        $this->db->where('recd_status', 'O');
        // $this->db->where('il.itli_itemlistid IS NOT NULL');
        if(!empty($itemid) && $rpt_wise == 'item' ){
            $this->db->where('rd.recd_itemsid',$itemid);
        }

        if(!empty( $recm_mattypeid)){
            $this->db->where('il.itli_materialtypeid',$recm_mattypeid);
        }


        $this->db->group_by('rd.recd_itemsid');
        $this->db->order_by('il.itli_itemcode','ASC');
        $data['items'] = $this->db->get()->result();
        // echo $this->db->last_query();
        // die();

        if ($rpt_wise == 'item') {
          $this->db->flush_cache();
          unset($array);
          $array['items'] = $data['items'];
          return $array;
        }


        $this->db->select("recm_budgetid,b.budg_budgetname as budgetname,SUM(recm_amount) as amount,SUM(recm_discount) as discount,SUM(recm_taxamount)  as taxamount,SUM(recm_refund) as refund,SUM(recm_clearanceamount) as recm_gtotal");
        $this->db->from('recm_receivedmaster rm');
        $this->db->join('budg_budgets b', 'b.budg_budgetid = rm.recm_budgetid', 'LEFT');
        $this->db->where('recm_status', 'O');
        $this->db->group_by('recm_budgetid');
        $this->db->order_by('b.budg_budgetname', 'ASC');
         $data['budget_head'] = $this->db->get()->result();


        $this->db->select("recm_receivedstaffid,st.stin_fname,st.stin_mname,st.stin_lname,SUM(recm_amount) as amount,SUM(recm_discount) as discount,SUM(recm_taxamount)  as taxamount,SUM(recm_refund) as refund,SUM(recm_clearanceamount) as recm_gtotal,0 as qty");
        $this->db->from('recm_receivedmaster rm');
       
        $this->db->join('stin_staffinfo st', 'st.stin_staffinfoid = rm.recm_receivedstaffid', 'LEFT');
        $this->db->where('recm_status', 'O');
        $this->db->group_by('recm_receivedstaffid');
        $this->db->order_by('st.stin_fname', 'ASC');
         $data['staff_info'] = $this->db->get()->result();
          if ($rpt_wise == 'receiver') {
          $this->db->flush_cache();
          unset($array);
          $array['staff_info'] = $data['staff_info'];
          return $array;
        }

        $this->db->select("recm_receiveddatebs,recm_receiveddatead,SUM(recm_amount) as amount,SUM(recm_discount) as discount,SUM(recm_taxamount)  as taxamount,SUM(recm_refund) as refund,SUM(recm_clearanceamount) as recm_gtotal,0 as qty");
        $this->db->from('recm_receivedmaster rm');
       
        $this->db->where('recm_status', 'O');
        $this->db->group_by('recm_receiveddatebs');
        $this->db->order_by('recm_receiveddatebs', 'ASC');
         $data['received_date'] = $this->db->get()->result();
          if ($rpt_wise == 'received_date') {
          $this->db->flush_cache();
          unset($array);
          $array['received_date'] = $data['received_date'];
          return $array;
        }

        $this->db->select("recm_supbilldatebs,recm_supbilldatead,recm_receiveddatead,SUM(recm_amount) as amount,SUM(recm_discount) as discount,SUM(recm_taxamount)  as taxamount,SUM(recm_refund) as refund,SUM(recm_clearanceamount) as recm_gtotal,0 as qty");
        $this->db->from('recm_receivedmaster rm');
       
        $this->db->where('recm_status', 'O');
        $this->db->group_by('recm_supbilldatebs');
        $this->db->order_by('recm_supbilldatebs', 'ASC');
         $data['bill_date'] = $this->db->get()->result();
          if ($rpt_wise == 'bill_date') {
          $this->db->flush_cache();
          unset($array);
          $array['bill_date'] = $data['bill_date'];
          return $array;
        }

         


        
        $this->db->flush_cache();

        return $data;
    }


    public function get_purchase_received_supplier_detail_ku()
    {
        $locationid = $this->input->post('locationid');
        $searchDateType = $this->input->post('searchDateType');
        $frmDate = $this->input->post('frmDate');
        $toDate = $this->input->post('toDate');
        $store_id = $this->input->post('store_id');
        $supplierid = $this->input->post('supplierid');
        $recm_mattypeid = $this->input->post('recm_mattypeid');
        $schoolid = $this->input->post('school');
        $departmentid = $this->input->post('departmentid');
        $subdepid = $this->input->post('subdepid');
        $recm_receivedby = $this->input->post('recm_receivedby');
        $rpt_type = $this->input->post('rpt_type');
        $rpt_wise = $this->input->post('rpt_wise');

        $subdeparray = array();
        if ($departmentid) {
            $check_parentid = $this->general->get_tbl_data('dept_depid,dept_parentdepid', 'dept_department', array('dept_depid' => $departmentid), 'dept_depname', 'ASC');
        }

        if (!empty($check_parentid)) {
            $parentdepid = !empty($check_parentid[0]->dept_parentdepid) ? $check_parentid[0]->dept_parentdepid : '0';
            if ($parentdepid == '0') {
                $subdep_result = $this->general->get_tbl_data('dept_depid', 'dept_department', array('dept_parentdepid' => $departmentid), 'dept_depname', 'ASC');
                if (!empty($subdep_result)) {
                    foreach ($subdep_result as $ksd => $dep) {
                        $subdeparray[] = $dep->dept_depid;
                    }
                }

            }
        }

        $this->db->start_cache();
        if ($searchDateType == 'date_range') {
            if ($frmDate &&  $toDate) {
                if (DEFAULT_DATEPICKER == 'NP') {
                    $this->db->where('recm_receiveddatebs >=', $frmDate);
                    $this->db->where('recm_receiveddatebs <=', $toDate);
                } else {
                    $this->db->where('recm_receiveddatead >=', $frmDate);
                    $this->db->where('recm_receiveddatead <=', $toDate);
                }
            }
        }

        if ($this->location_ismain == 'Y') {
            if (!empty($locationid)) {
                $this->db->where('rm.recm_locationid', $locationid);
            }
        } else {
            $this->db->where('rm.recm_locationid', $this->locationid);
        }

        if (!empty($this->mattypeid)) {
            $this->db->where('rm.recm_mattypeid', $this->mattypeid);
        } else {
            if (!empty($recm_mattypeid)) {
                $this->db->where('rm.recm_mattypeid', $recm_mattypeid);
            }
        }

        if ( (!empty($this->mattypeid) && $this->mattypeid == '2') || (!empty($recm_mattypeid) && $recm_mattypeid == '2') ) { 
          if (!empty($recm_receivedby)) {
              $staffid = explode(',',$recm_receivedby);
              if($staffid[0] != '1') 
                $this->db->where('rm.recm_receivedstaffid', $staffid[0]);
          }
        }

        if (!empty($schoolid)) {
            $this->db->where('rm.recm_school', $schoolid);
        }


        if (!empty($departmentid)) {

            if (!empty($subdepid)) {
                $this->db->where("recm_departmentid =" . $subdepid . " ");
            } else {
                if (!empty($subdeparray)) {
                    $this->db->where_in("recm_departmentid", $subdeparray);
                } else {
                    $this->db->where("recm_departmentid =" . $departmentid . " ");
                }
            }
        }

        if (!empty($store_id)) {
            $this->db->where('recm_storeid', $store_id);
        }
        $this->db->stop_cache();

        if (!empty($supplierid)) {
            $this->db->where(array('rm.recm_supplierid' => $supplierid));
        }

        $this->db->select('DISTINCT(rm.recm_supplierid), s.dist_distributor, s.dist_distributorid,');
        $this->db->from('recm_receivedmaster rm');
        $this->db->join('dist_distributors s', 's.dist_distributorid = rm.recm_supplierid', 'LEFT');
        $this->db->where('recm_status','O');

        $supplier_list = $this->db->get()->result();
        $supplier = array();
        if (count($supplier_list)) {
            foreach ($supplier_list as $key => $supp) {
              $supplier[$key]['supplier_name'] = $supp->dist_distributor;
 
              $this->db->select('rm.*,rd.*,ut.unit_unitname,it.itli_itemcode,it.itli_itemname,s.dist_distributor,s.dist_distributorid, b.budg_budgetname,mt.maty_material,scf.loca_name schoolname,dtf.dept_depname fromdep,dtfp.dept_depname fromdepparent');
              $this->db->from('recm_receivedmaster rm');
              $this->db->join('recd_receiveddetail rd', 'rd.recd_receivedmasterid = rm.recm_receivedmasterid', 'LEFT');
              $this->db->join('itli_itemslist it', 'it.itli_itemlistid = rd.recd_itemsid', 'LEFT');
              $this->db->join('unit_unit ut', 'it.itli_unitid = ut.unit_unitid', 'LEFT');
              $this->db->join('dist_distributors s', 's.dist_distributorid = rm.recm_supplierid', 'LEFT');
              $this->db->join('budg_budgets b', 'b.budg_budgetid = rm.recm_budgetid', 'LEFT');
              $this->db->join('maty_materialtype mt', 'mt.maty_materialtypeid=rm.recm_mattypeid', "LEFT");
              $this->db->join('loca_location scf', 'rm.recm_school=scf.loca_locationid', 'LEFT');
              $this->db->join('dept_department dtf', 'rm.recm_departmentid=dtf.dept_depid', 'LEFT');
              $this->db->join('dept_department dtfp', 'dtfp.dept_depid=dtf.dept_parentdepid', 'LEFT');
              $this->db->where('recm_status','O');
              $this->db->where('rm.recm_supplierid',$supp->recm_supplierid);

              $supplier[$key]['supplier_details'] = $this->db->get()->result();
            }
        }

        $this->db->flush_cache();  
        return $supplier;
    }


    public function get_purchase_received_supplier_detail()
    {
        $locationid = $this->input->post('locationid');
        $searchDateType = $this->input->post('searchDateType');
        $frmDate = $this->input->post('frmDate');
        $toDate = $this->input->post('toDate');
        $store_id = $this->input->post('store_id');
        $supplierid = $this->input->post('supplierid');
        $recm_mattypeid = $this->input->post('recm_mattypeid');
        $departmentid = $this->input->post('departmentid');
        $subdepid = $this->input->post('subdepid');
        $recm_receivedby = $this->input->post('recm_receivedby');
        $rpt_type = $this->input->post('rpt_type');
        $rpt_wise = $this->input->post('rpt_wise');

        $subdeparray = array();
        if ($departmentid) {
            $check_parentid = $this->general->get_tbl_data('dept_depid,dept_parentdepid', 'dept_department', array('dept_depid' => $departmentid), 'dept_depname', 'ASC');
        }

        if (!empty($check_parentid)) {
            $parentdepid = !empty($check_parentid[0]->dept_parentdepid) ? $check_parentid[0]->dept_parentdepid : '0';
            if ($parentdepid == '0') {
                $subdep_result = $this->general->get_tbl_data('dept_depid', 'dept_department', array('dept_parentdepid' => $departmentid), 'dept_depname', 'ASC');
                if (!empty($subdep_result)) {
                    foreach ($subdep_result as $ksd => $dep) {
                        $subdeparray[] = $dep->dept_depid;
                    }
                }

            }
        }

        $this->db->start_cache();
        if ($searchDateType == 'date_range') {
            if ($frmDate &&  $toDate) {
                if (DEFAULT_DATEPICKER == 'NP') {
                    $this->db->where('recm_receiveddatebs >=', $frmDate);
                    $this->db->where('recm_receiveddatebs <=', $toDate);
                } else {
                    $this->db->where('recm_receiveddatead >=', $frmDate);
                    $this->db->where('recm_receiveddatead <=', $toDate);
                }
            }
        }

        if ($this->location_ismain == 'Y') {
            if (!empty($locationid)) {
                $this->db->where('rm.recm_locationid', $locationid);
            }
        } else {
            $this->db->where('rm.recm_locationid', $this->locationid);
        }

        if (!empty($this->mattypeid)) {
            $this->db->where('rm.recm_mattypeid', $this->mattypeid);
        } else {
            if (!empty($recm_mattypeid)) {
                $this->db->where('rm.recm_mattypeid', $recm_mattypeid);
            }
        }

        if ( (!empty($this->mattypeid) && $this->mattypeid == '2') || (!empty($recm_mattypeid) && $recm_mattypeid == '2') ) { 
          if (!empty($recm_receivedby)) {
              $staffid = explode(',',$recm_receivedby);
              if($staffid[0] != '1') 
                $this->db->where('rm.recm_receivedstaffid', $staffid[0]);
          }
        }

      

        if (!empty($departmentid)) {

            if (!empty($subdepid)) {
                $this->db->where("recm_departmentid =" . $subdepid . " ");
            } else {
                if (!empty($subdeparray)) {
                    $this->db->where_in("recm_departmentid", $subdeparray);
                } else {
                    $this->db->where("recm_departmentid =" . $departmentid . " ");
                }
            }
        }

        if (!empty($store_id)) {
            $this->db->where('recm_storeid', $store_id);
        }
        $this->db->stop_cache();

        if (!empty($supplierid)) {
            $this->db->where(array('rm.recm_supplierid' => $supplierid));
        }

        $this->db->select('DISTINCT(rm.recm_supplierid), s.dist_distributor, s.dist_distributorid,');
        $this->db->from('recm_receivedmaster rm');
        $this->db->join('dist_distributors s', 's.dist_distributorid = rm.recm_supplierid', 'LEFT');
        $this->db->where('recm_status','O');

        $supplier_list = $this->db->get()->result();
        $supplier = array();
        if (count($supplier_list)) {
            foreach ($supplier_list as $key => $supp) {
              $supplier[$key]['supplier_name'] = $supp->dist_distributor;
 
              $this->db->select('rm.*,rd.*,ut.unit_unitname,it.itli_itemcode,it.itli_itemname,s.dist_distributor,s.dist_distributorid, b.budg_budgetname,mt.maty_material,scf.loca_name schoolname,dtf.dept_depname fromdep,dtfp.dept_depname fromdepparent');
              $this->db->from('recm_receivedmaster rm');
              $this->db->join('recd_receiveddetail rd', 'rd.recd_receivedmasterid = rm.recm_receivedmasterid', 'LEFT');
              $this->db->join('itli_itemslist it', 'it.itli_itemlistid = rd.recd_itemsid', 'LEFT');
              $this->db->join('unit_unit ut', 'it.itli_unitid = ut.unit_unitid', 'LEFT');
              $this->db->join('dist_distributors s', 's.dist_distributorid = rm.recm_supplierid', 'LEFT');
              $this->db->join('budg_budgets b', 'b.budg_budgetid = rm.recm_budgetid', 'LEFT');
              $this->db->join('maty_materialtype mt', 'mt.maty_materialtypeid=rm.recm_mattypeid', "LEFT");
              $this->db->join('loca_location scf', 'rm.recm_school=scf.loca_locationid', 'LEFT');
              $this->db->join('dept_department dtf', 'rm.recm_departmentid=dtf.dept_depid', 'LEFT');
              $this->db->join('dept_department dtfp', 'dtfp.dept_depid=dtf.dept_parentdepid', 'LEFT');
              $this->db->where('recm_status','O');
              $this->db->where('rm.recm_supplierid',$supp->recm_supplierid);

              $supplier[$key]['supplier_details'] = $this->db->get()->result();
            }
        }

        $this->db->flush_cache();  
        return $supplier;
    }


    public function get_purchase_received_invoice_detail()
    {
        $locationid = $this->input->post('locationid');
        $searchDateType = $this->input->post('searchDateType');
        $frmDate = $this->input->post('frmDate');
        $toDate = $this->input->post('toDate');
        $store_id = $this->input->post('store_id');
        $supplierid = $this->input->post('supplierid');
        $recm_mattypeid = $this->input->post('recm_mattypeid');
        $departmentid = $this->input->post('departmentid');
        $subdepid = $this->input->post('subdepid');
        $recm_receivedby = $this->input->post('recm_receivedby');
        $rpt_type = $this->input->post('rpt_type');
        $rpt_wise = $this->input->post('rpt_wise');

        $subdeparray = array();
        if ($departmentid) {
            $check_parentid = $this->general->get_tbl_data('dept_depid,dept_parentdepid', 'dept_department', array('dept_depid' => $departmentid), 'dept_depname', 'ASC');
        }

        if (!empty($check_parentid)) {
            $parentdepid = !empty($check_parentid[0]->dept_parentdepid) ? $check_parentid[0]->dept_parentdepid : '0';
            if ($parentdepid == '0') {
                $subdep_result = $this->general->get_tbl_data('dept_depid', 'dept_department', array('dept_parentdepid' => $departmentid), 'dept_depname', 'ASC');
                if (!empty($subdep_result)) {
                    foreach ($subdep_result as $ksd => $dep) {
                        $subdeparray[] = $dep->dept_depid;
                    }
                }

            }
        }

        $this->db->start_cache();
        if ($searchDateType == 'date_range') {
            if ($frmDate &&  $toDate) {
                if (DEFAULT_DATEPICKER == 'NP') {
                    $this->db->where('recm_receiveddatebs >=', $frmDate);
                    $this->db->where('recm_receiveddatebs <=', $toDate);
                } else {
                    $this->db->where('recm_receiveddatead >=', $frmDate);
                    $this->db->where('recm_receiveddatead <=', $toDate);
                }
            }
        }

        if ($this->location_ismain == 'Y') {
            if (!empty($locationid)) {
                $this->db->where('rm.recm_locationid', $locationid);
            }
        } else {
            $this->db->where('rm.recm_locationid', $this->locationid);
        }

        if (!empty($this->mattypeid)) {
            $this->db->where('rm.recm_mattypeid', $this->mattypeid);
        } else {
            if (!empty($recm_mattypeid)) {
                $this->db->where('rm.recm_mattypeid', $recm_mattypeid);
            }
        }

        if ( (!empty($this->mattypeid) && $this->mattypeid == '2') || (!empty($recm_mattypeid) && $recm_mattypeid == '2') ) { 
          if (!empty($recm_receivedby)) {
              $staffid = explode(',',$recm_receivedby);
              if($staffid[0] != '1') 
                $this->db->where('rm.recm_receivedstaffid', $staffid[0]);
          }
        }

      

        if (!empty($departmentid)) {

            if (!empty($subdepid)) {
                $this->db->where("recm_departmentid =" . $subdepid . " ");
            } else {
                if (!empty($subdeparray)) {
                    $this->db->where_in("recm_departmentid", $subdeparray);
                } else {
                    $this->db->where("recm_departmentid =" . $departmentid . " ");
                }
            }
        }

        if (!empty($store_id)) {
            $this->db->where('recm_storeid', $store_id);
        }
        $this->db->stop_cache();

        if (!empty($supplierid)) {
            $this->db->where(array('rm.recm_supplierid' => $supplierid));
        }

         $this->db->select("recm_receivedmasterid,recm_invoiceno,recm_receiveddatebs,recm_purchaseorderno,recm_supbilldatebs,recm_supplierbillno,SUM(recm_amount) as amount,SUM(recm_discount) as discount,SUM(recm_taxamount)  as taxamount,SUM(recm_refund) as refund,SUM(recm_clearanceamount) as recm_gtotal,s.dist_distributor");
        $this->db->from('recm_receivedmaster rm');
         $this->db->join('dist_distributors s', 's.dist_distributorid = rm.recm_supplierid', 'LEFT');
        $this->db->where('recm_status', 'O');
        $this->db->group_by('recm_receivedmasterid');
        $this->db->order_by('rm.recm_receivedmasterid', 'ASC');

        $rec_detaillist = $this->db->get()->result();
        $invoice_arr = array();
        if (count($rec_detaillist)) {
            $i=1;
            foreach ($rec_detaillist as $key => $recd) {
              $invoice_arr[$key]['invoice_no'] = $i.'. Invoice No.:'.$recd->recm_invoiceno.'  |  Received Date : '.$recd->recm_receiveddatebs.' | Purchase Order No. : '.$recd->recm_purchaseorderno .' | Supplier Name: '.$recd->dist_distributor;
 
              $this->db->select('rd.*,ut.unit_unitname,it.itli_itemcode,it.itli_itemname');
              $this->db->from('recm_receivedmaster rm');
              $this->db->join('recd_receiveddetail rd', 'rd.recd_receivedmasterid = rm.recm_receivedmasterid', 'LEFT');
              $this->db->join('itli_itemslist it', 'it.itli_itemlistid = rd.recd_itemsid', 'LEFT');
              $this->db->join('unit_unit ut', 'it.itli_unitid = ut.unit_unitid', 'LEFT');
              $this->db->join('dist_distributors s', 's.dist_distributorid = rm.recm_supplierid', 'LEFT');
              $this->db->join('budg_budgets b', 'b.budg_budgetid = rm.recm_budgetid', 'LEFT');
              $this->db->join('maty_materialtype mt', 'mt.maty_materialtypeid=rm.recm_mattypeid', "LEFT");
              $this->db->join('loca_location scf', 'rm.recm_school=scf.loca_locationid', 'LEFT');
              $this->db->join('dept_department dtf', 'rm.recm_departmentid=dtf.dept_depid', 'LEFT');
              $this->db->join('dept_department dtfp', 'dtfp.dept_depid=dtf.dept_parentdepid', 'LEFT');
              $this->db->where('recm_status','O');
               $this->db->where('recd_status','O');
              $this->db->where('rm.recm_receivedmasterid',$recd->recm_receivedmasterid);
              $this->db->order_by('rd.recd_receiveddetailid','ASC');

              $invoice_arr[$key]['invoice_detail'] = $this->db->get()->result();
              $i++;
            }
        }

        $this->db->flush_cache();  
        return $invoice_arr;
    }

public function get_purchase_received_item_detail_ku()
    {
        $locationid = $this->input->post('locationid');
        $searchDateType = $this->input->post('searchDateType');
        $frmDate = $this->input->post('frmDate');
        $toDate = $this->input->post('toDate');
        $store_id = $this->input->post('store_id');
        $supplierid = $this->input->post('supplierid');
        $recm_mattypeid = $this->input->post('recm_mattypeid');
        $schoolid = $this->input->post('school');
        $departmentid = $this->input->post('departmentid');
        $subdepid = $this->input->post('subdepid');
        $recm_receivedby = $this->input->post('recm_receivedby');
        $rpt_type = $this->input->post('rpt_type');
        $rpt_wise = $this->input->post('rpt_wise');

        $subdeparray = array();
        if ($departmentid) {
            $check_parentid = $this->general->get_tbl_data('dept_depid,dept_parentdepid', 'dept_department', array('dept_depid' => $departmentid), 'dept_depname', 'ASC');
        }

        if (!empty($check_parentid)) {
            $parentdepid = !empty($check_parentid[0]->dept_parentdepid) ? $check_parentid[0]->dept_parentdepid : '0';
            if ($parentdepid == '0') {
                $subdep_result = $this->general->get_tbl_data('dept_depid', 'dept_department', array('dept_parentdepid' => $departmentid), 'dept_depname', 'ASC');
                if (!empty($subdep_result)) {
                    foreach ($subdep_result as $ksd => $dep) {
                        $subdeparray[] = $dep->dept_depid;
                    }
                }

            }
        }

        $this->db->start_cache();
        if ($searchDateType == 'date_range') {
            if ($frmDate &&  $toDate) {
                if (DEFAULT_DATEPICKER == 'NP') {
                    $this->db->where('recm_receiveddatebs >=', $frmDate);
                    $this->db->where('recm_receiveddatebs <=', $toDate);
                } else {
                    $this->db->where('recm_receiveddatead >=', $frmDate);
                    $this->db->where('recm_receiveddatead <=', $toDate);
                }
            }
        }

        if ($this->location_ismain == 'Y') {
            if (!empty($locationid)) {
                $this->db->where('rm.recm_locationid', $locationid);
            }
        } else {
            $this->db->where('rm.recm_locationid', $this->locationid);
        }

        if (!empty($this->mattypeid)) {
            $this->db->where('rm.recm_mattypeid', $this->mattypeid);
        } else {
            if (!empty($recm_mattypeid)) {
                $this->db->where('rm.recm_mattypeid', $recm_mattypeid);
            }
        }

        if ( (!empty($this->mattypeid) && $this->mattypeid == '2') || (!empty($recm_mattypeid) && $recm_mattypeid == '2') ) { 
          if (!empty($recm_receivedby)) {
              $staffid = explode(',',$recm_receivedby);
              if($staffid[0] != '1') 
                $this->db->where('rm.recm_receivedstaffid', $staffid[0]);
          }
        }

        if (!empty($schoolid)) {
            $this->db->where('rm.recm_school', $schoolid);
        }


        if (!empty($departmentid)) {

            if (!empty($subdepid)) {
                $this->db->where("recm_departmentid =" . $subdepid . " ");
            } else {
                if (!empty($subdeparray)) {
                    $this->db->where_in("recm_departmentid", $subdeparray);
                } else {
                    $this->db->where("recm_departmentid =" . $departmentid . " ");
                }
            }
        }

        if (!empty($store_id)) {
            $this->db->where('recm_storeid', $store_id);
        }

        if (!empty($supplierid)) {
            $this->db->where(array('rm.recm_supplierid' => $supplierid));
        }

        $this->db->stop_cache();

        $this->db->select('DISTINCT(rd.recd_itemsid),ut.unit_unitname ,il.itli_itemname, il.itli_itemlistid,il.itli_itemcode');
        $this->db->from('recm_receivedmaster rm');
        $this->db->join('recd_receiveddetail rd', 'rm.recm_receivedmasterid = rd.recd_receivedmasterid', 'LEFT');
        $this->db->join('itli_itemslist il', 'il.itli_itemlistid = rd.recd_itemsid', 'LEFT');
        $this->db->join('unit_unit ut', 'il.itli_unitid = ut.unit_unitid', 'LEFT');
        $this->db->where('recm_status','O');
        $this->db->where('il.itli_itemlistid IS NOT NULL');

        $items_list = $this->db->get()->result();
        $items = array();
        if (count($items_list)) {
            foreach ($items_list as $key => $item) {
              $items[$key]['item_name'] = $item->itli_itemcode.'-'.$item->itli_itemname;
              $items[$key]['item_unit'] = $item->unit_unitname;
 
              $this->db->select('rm.*,rd.*,ut.unit_unitname,it.itli_itemcode,it.itli_itemname,s.dist_distributor,s.dist_distributorid, b.budg_budgetname,mt.maty_material,scf.loca_name schoolname,dtf.dept_depname fromdep,dtfp.dept_depname fromdepparent');
              $this->db->from('recm_receivedmaster rm'); 
              $this->db->join('recd_receiveddetail rd', 'rd.recd_receivedmasterid = rm.recm_receivedmasterid', 'LEFT');
              $this->db->join('itli_itemslist it', 'it.itli_itemlistid = rd.recd_itemsid', 'LEFT');
              $this->db->join('unit_unit ut', 'it.itli_unitid = ut.unit_unitid', 'LEFT');
              $this->db->join('dist_distributors s', 's.dist_distributorid = rm.recm_supplierid', 'LEFT');
              $this->db->join('budg_budgets b', 'b.budg_budgetid = rm.recm_budgetid', 'LEFT');
              $this->db->join('maty_materialtype mt', 'mt.maty_materialtypeid=rm.recm_mattypeid', "LEFT");
              $this->db->join('loca_location scf', 'rm.recm_school=scf.loca_locationid', 'LEFT');
              $this->db->join('dept_department dtf', 'rm.recm_departmentid=dtf.dept_depid', 'LEFT');
              $this->db->join('dept_department dtfp', 'dtfp.dept_depid=dtf.dept_parentdepid', 'LEFT');
              $this->db->where('recm_status','O');
              $this->db->where('recd_itemsid',$item->recd_itemsid);

              $items[$key]['item_details'] = $this->db->get()->result();
            }
        }

        $this->db->flush_cache();   
        return $items;
    }

public function get_purchase_received_item_detail()
    {
        $locationid = $this->input->post('locationid');
        $searchDateType = $this->input->post('searchDateType');
        $frmDate = $this->input->post('frmDate');
        $toDate = $this->input->post('toDate');
        $store_id = $this->input->post('store_id');
        $supplierid = $this->input->post('supplierid');
         $itemid= $this->input->post('itemid');
 
        $recm_mattypeid = $this->input->post('recm_mattypeid');
        $schoolid = $this->input->post('school');
        $departmentid = $this->input->post('departmentid');
        $subdepid = $this->input->post('subdepid');
        $recm_receivedby = $this->input->post('recm_receivedby');
        $rpt_type = $this->input->post('rpt_type');
        $rpt_wise = $this->input->post('rpt_wise');

        $subdeparray = array();
        if ($departmentid) {
            $check_parentid = $this->general->get_tbl_data('dept_depid,dept_parentdepid', 'dept_department', array('dept_depid' => $departmentid), 'dept_depname', 'ASC');
        }

        if (!empty($check_parentid)) {
            $parentdepid = !empty($check_parentid[0]->dept_parentdepid) ? $check_parentid[0]->dept_parentdepid : '0';
            if ($parentdepid == '0') {
                $subdep_result = $this->general->get_tbl_data('dept_depid', 'dept_department', array('dept_parentdepid' => $departmentid), 'dept_depname', 'ASC');
                if (!empty($subdep_result)) {
                    foreach ($subdep_result as $ksd => $dep) {
                        $subdeparray[] = $dep->dept_depid;
                    }
                }

            }
        }

        $this->db->start_cache();
        if ($searchDateType == 'date_range') {
            if ($frmDate &&  $toDate) {
                if (DEFAULT_DATEPICKER == 'NP') {
                    $this->db->where('recm_receiveddatebs >=', $frmDate);
                    $this->db->where('recm_receiveddatebs <=', $toDate);
                } else {
                    $this->db->where('recm_receiveddatead >=', $frmDate);
                    $this->db->where('recm_receiveddatead <=', $toDate);
                }
            }
        }

        if ($this->location_ismain == 'Y') {
            if (!empty($locationid)) {
                $this->db->where('rm.recm_locationid', $locationid);
            }
        } else {
            $this->db->where('rm.recm_locationid', $this->locationid);
        }

        if (!empty($recm_mattypeid)) {
            $this->db->where('itli_materialtypeid', $recm_mattypeid);
        }

        if ( (!empty($this->mattypeid) && $this->mattypeid == '2') || (!empty($recm_mattypeid) && $recm_mattypeid == '2') ) { 
          if (!empty($recm_receivedby)) {
              $staffid = explode(',',$recm_receivedby);
              if($staffid[0] != '1') 
                $this->db->where('rm.recm_receivedstaffid', $staffid[0]);
          }
        }

        if (!empty($schoolid)) {
            $this->db->where('rm.recm_school', $schoolid);
        }


        if (!empty($departmentid)) {

            if (!empty($subdepid)) {
                $this->db->where("recm_departmentid =" . $subdepid . " ");
            } else {
                if (!empty($subdeparray)) {
                    $this->db->where_in("recm_departmentid", $subdeparray);
                } else {
                    $this->db->where("recm_departmentid =" . $departmentid . " ");
                }
            }
        }

        if (!empty($store_id)) {
            $this->db->where('recm_storeid', $store_id);
        }

        if (!empty($supplierid)) {
            $this->db->where(array('rm.recm_supplierid' => $supplierid));
        }

        $this->db->stop_cache();

        $this->db->select('DISTINCT(rd.recd_itemsid),ut.unit_unitname ,il.itli_itemname, il.itli_itemlistid,il.itli_itemcode');
        $this->db->from('recm_receivedmaster rm');
        $this->db->join('recd_receiveddetail rd', 'rm.recm_receivedmasterid = rd.recd_receivedmasterid', 'LEFT');
        $this->db->join('itli_itemslist il', 'il.itli_itemlistid = rd.recd_itemsid', 'LEFT');
        $this->db->join('unit_unit ut', 'il.itli_unitid = ut.unit_unitid', 'LEFT');
        $this->db->where('recm_status','O');
        $this->db->where('recd_status','O');
        $this->db->where('il.itli_itemlistid IS NOT NULL');
        if(!empty($itemid) && $rpt_wise == 'item' ){
            $this->db->where('rd.recd_itemsid',$itemid);
        }
        $this->db->order_by('il.itli_itemcode','ASC');
        $items_list = $this->db->get()->result();
        // echo $this->db->last_query();
        // die();
        $items = array();
        if (count($items_list)) {
            foreach ($items_list as $key => $item) {
              $items[$key]['item_name'] = $item->itli_itemcode.'-'.$item->itli_itemname;
              $items[$key]['item_unit'] = $item->unit_unitname;
 
              $this->db->select('rm.*,rd.*,ut.unit_unitname,it.itli_itemcode,it.itli_itemname,s.dist_distributor,s.dist_distributorid, b.budg_budgetname,mt.maty_material,scf.loca_name schoolname,dtf.dept_depname fromdep,dtfp.dept_depname fromdepparent');
              $this->db->from('recm_receivedmaster rm'); 
              $this->db->join('recd_receiveddetail rd', 'rd.recd_receivedmasterid = rm.recm_receivedmasterid', 'LEFT');
              $this->db->join('itli_itemslist it', 'it.itli_itemlistid = rd.recd_itemsid', 'LEFT');
              $this->db->join('unit_unit ut', 'it.itli_unitid = ut.unit_unitid', 'LEFT');
              $this->db->join('dist_distributors s', 's.dist_distributorid = rm.recm_supplierid', 'LEFT');
              $this->db->join('budg_budgets b', 'b.budg_budgetid = rm.recm_budgetid', 'LEFT');
              $this->db->join('maty_materialtype mt', 'mt.maty_materialtypeid=rm.recm_mattypeid', "LEFT");
              $this->db->join('loca_location scf', 'rm.recm_school=scf.loca_locationid', 'LEFT');
              $this->db->join('dept_department dtf', 'rm.recm_departmentid=dtf.dept_depid', 'LEFT');
              $this->db->join('dept_department dtfp', 'dtfp.dept_depid=dtf.dept_parentdepid', 'LEFT');
              $this->db->where('recm_status','O');
              $this->db->where('recd_itemsid',$item->recd_itemsid);

              $items[$key]['item_details'] = $this->db->get()->result();
            }
        }

        $this->db->flush_cache();   
        return $items;
    }

    public function get_purchase_received_material_type_detail_ku()
    {
        $locationid = $this->input->post('locationid');
        $searchDateType = $this->input->post('searchDateType');
        $frmDate = $this->input->post('frmDate');
        $toDate = $this->input->post('toDate');
        $store_id = $this->input->post('store_id');
        $supplierid = $this->input->post('supplierid');
        $recm_mattypeid = $this->input->post('recm_mattypeid');
        $schoolid = $this->input->post('school');
        $departmentid = $this->input->post('departmentid');
        $subdepid = $this->input->post('subdepid');
        $recm_receivedby = $this->input->post('recm_receivedby');
        $rpt_type = $this->input->post('rpt_type');
        $rpt_wise = $this->input->post('rpt_wise');

        $subdeparray = array();
        if ($departmentid) {
            $check_parentid = $this->general->get_tbl_data('dept_depid,dept_parentdepid', 'dept_department', array('dept_depid' => $departmentid), 'dept_depname', 'ASC');
        }

        if (!empty($check_parentid)) {
            $parentdepid = !empty($check_parentid[0]->dept_parentdepid) ? $check_parentid[0]->dept_parentdepid : '0';
            if ($parentdepid == '0') {
                $subdep_result = $this->general->get_tbl_data('dept_depid', 'dept_department', array('dept_parentdepid' => $departmentid), 'dept_depname', 'ASC');
                if (!empty($subdep_result)) {
                    foreach ($subdep_result as $ksd => $dep) {
                        $subdeparray[] = $dep->dept_depid;
                    }
                }

            }
        }

        $this->db->start_cache();
        if ($searchDateType == 'date_range') {
            if ($frmDate &&  $toDate) {
                if (DEFAULT_DATEPICKER == 'NP') {
                    $this->db->where('recm_receiveddatebs >=', $frmDate);
                    $this->db->where('recm_receiveddatebs <=', $toDate);
                } else {
                    $this->db->where('recm_receiveddatead >=', $frmDate);
                    $this->db->where('recm_receiveddatead <=', $toDate);
                }
            }
        }

        if ($this->location_ismain == 'Y') {
            if (!empty($locationid)) {
                $this->db->where('rm.recm_locationid', $locationid);
            }
        } else {
            $this->db->where('rm.recm_locationid', $this->locationid);
        }

        if ( (!empty($this->mattypeid) && $this->mattypeid == '2') || (!empty($recm_mattypeid) && $recm_mattypeid == '2') ) { 
          if (!empty($recm_receivedby)) {
              $staffid = explode(',',$recm_receivedby);
              if($staffid[0] != '1') 
                $this->db->where('rm.recm_receivedstaffid', $staffid[0]);
          }
        }

        if (!empty($schoolid)) {
            $this->db->where('rm.recm_school', $schoolid);
        }


        if (!empty($departmentid)) {

            if (!empty($subdepid)) {
                $this->db->where("recm_departmentid =" . $subdepid . " ");
            } else {
                if (!empty($subdeparray)) {
                    $this->db->where_in("recm_departmentid", $subdeparray);
                } else {
                    $this->db->where("recm_departmentid =" . $departmentid . " ");
                }
            }
        }

        if (!empty($store_id)) {
            $this->db->where('recm_storeid', $store_id);
        }

        if (!empty($supplierid)) {
            $this->db->where(array('rm.recm_supplierid' => $supplierid));
        }

        $this->db->stop_cache();

        if (!empty($this->mattypeid)) {
            $this->db->where('rm.recm_mattypeid', $this->mattypeid);
        } else {
            if (!empty($recm_mattypeid)) {
                $this->db->where('rm.recm_mattypeid', $recm_mattypeid);
            }
        }


        $this->db->select('DISTINCT(rm.recm_mattypeid),mt.maty_material,mt.maty_materialtypeid');
        $this->db->from('recm_receivedmaster rm');
        $this->db->join('maty_materialtype mt', 'mt.maty_materialtypeid=rm.recm_mattypeid', "LEFT");
        $this->db->where('recm_status','O');

        $mattype_list = $this->db->get()->result();
        $materials = array();
        if (count($mattype_list)) {
            foreach ($mattype_list as $key => $item) {
              $materials[$key]['material_name'] = $item->maty_material;
 
              $this->db->select('rm.*,rd.*,ut.unit_unitname,it.itli_itemcode,it.itli_itemname,s.dist_distributor,s.dist_distributorid, b.budg_budgetname,scf.loca_name schoolname,dtf.dept_depname fromdep,dtfp.dept_depname fromdepparent');
              $this->db->from('recm_receivedmaster rm'); 
              $this->db->join('recd_receiveddetail rd', 'rd.recd_receivedmasterid = rm.recm_receivedmasterid', 'LEFT');
              $this->db->join('itli_itemslist it', 'it.itli_itemlistid = rd.recd_itemsid', 'LEFT');
              $this->db->join('unit_unit ut', 'it.itli_unitid = ut.unit_unitid', 'LEFT');
              $this->db->join('dist_distributors s', 's.dist_distributorid = rm.recm_supplierid', 'LEFT');
              $this->db->join('budg_budgets b', 'b.budg_budgetid = rm.recm_budgetid', 'LEFT');
              // $this->db->join('maty_materialtype mt', 'mt.maty_materialtypeid=rm.recm_mattypeid', "LEFT");
              $this->db->join('loca_location scf', 'rm.recm_school=scf.loca_locationid', 'LEFT');
              $this->db->join('dept_department dtf', 'rm.recm_departmentid=dtf.dept_depid', 'LEFT');
              $this->db->join('dept_department dtfp', 'dtfp.dept_depid=dtf.dept_parentdepid', 'LEFT');
              $this->db->where('recm_status','O');
              $this->db->where('recm_mattypeid',$item->recm_mattypeid);

              $materials[$key]['item_details'] = $this->db->get()->result();
            }
        }

        $this->db->flush_cache();   
        return $materials;
    }

    public function get_purchase_received_school_detail_ku()
    {
        $locationid = $this->input->post('locationid');
        $searchDateType = $this->input->post('searchDateType');
        $frmDate = $this->input->post('frmDate');
        $toDate = $this->input->post('toDate');
        $store_id = $this->input->post('store_id');
        $supplierid = $this->input->post('supplierid');
        $recm_mattypeid = $this->input->post('recm_mattypeid');
        $schoolid = $this->input->post('school');
        $departmentid = $this->input->post('departmentid');
        $subdepid = $this->input->post('subdepid');
        $recm_receivedby = $this->input->post('recm_receivedby');
        $rpt_type = $this->input->post('rpt_type');
        $rpt_wise = $this->input->post('rpt_wise');

        $subdeparray = array();
        if ($departmentid) {
            $check_parentid = $this->general->get_tbl_data('dept_depid,dept_parentdepid', 'dept_department', array('dept_depid' => $departmentid), 'dept_depname', 'ASC');
        }

        if (!empty($check_parentid)) {
            $parentdepid = !empty($check_parentid[0]->dept_parentdepid) ? $check_parentid[0]->dept_parentdepid : '0';
            if ($parentdepid == '0') {
                $subdep_result = $this->general->get_tbl_data('dept_depid', 'dept_department', array('dept_parentdepid' => $departmentid), 'dept_depname', 'ASC');
                if (!empty($subdep_result)) {
                    foreach ($subdep_result as $ksd => $dep) {
                        $subdeparray[] = $dep->dept_depid;
                    }
                }

            }
        }

        $this->db->start_cache();
        if ($searchDateType == 'date_range') {
            if ($frmDate &&  $toDate) {
                if (DEFAULT_DATEPICKER == 'NP') {
                    $this->db->where('recm_receiveddatebs >=', $frmDate);
                    $this->db->where('recm_receiveddatebs <=', $toDate);
                } else {
                    $this->db->where('recm_receiveddatead >=', $frmDate);
                    $this->db->where('recm_receiveddatead <=', $toDate);
                }
            }
        }

        if ($this->location_ismain == 'Y') {
            if (!empty($locationid)) {
                $this->db->where('rm.recm_locationid', $locationid);
            }
        } else {
            $this->db->where('rm.recm_locationid', $this->locationid);
        }

        if ( (!empty($this->mattypeid) && $this->mattypeid == '2') || (!empty($recm_mattypeid) && $recm_mattypeid == '2') ) { 
          if (!empty($recm_receivedby)) {
              $staffid = explode(',',$recm_receivedby);
              if($staffid[0] != '1') 
                $this->db->where('rm.recm_receivedstaffid', $staffid[0]);
          }
        }

        if (!empty($departmentid)) {

            if (!empty($subdepid)) {
                $this->db->where("recm_departmentid =" . $subdepid . " ");
            } else {
                if (!empty($subdeparray)) {
                    $this->db->where_in("recm_departmentid", $subdeparray);
                } else {
                    $this->db->where("recm_departmentid =" . $departmentid . " ");
                }
            }
        }

        if (!empty($store_id)) {
            $this->db->where('recm_storeid', $store_id);
        }

        if (!empty($supplierid)) {
            $this->db->where(array('rm.recm_supplierid' => $supplierid));
        }

        if (!empty($this->mattypeid)) {
            $this->db->where('rm.recm_mattypeid', $this->mattypeid);
        } else {
            if (!empty($recm_mattypeid)) {
                $this->db->where('rm.recm_mattypeid', $recm_mattypeid);
            }
        }
        $this->db->stop_cache();

        if (!empty($schoolid)) {
            $this->db->where('rm.recm_school', $schoolid);
        }


        $this->db->select('DISTINCT(rm.recm_school),lc.loca_locationid,lc.loca_name');
        $this->db->from('recm_receivedmaster rm');
        $this->db->join('loca_location lc', 'rm.recm_school=lc.loca_locationid', 'LEFT');
        $this->db->where('recm_status','O');
        $this->db->order_by('loca_name','ASC');

        $school_list = $this->db->get()->result();
        $school = array();
        if (count($school_list)) {
            foreach ($school_list as $key => $item) {
              $school[$key]['school_name'] = $item->loca_name;
 
              $this->db->select('rm.*,rd.*,ut.unit_unitname,it.itli_itemcode,it.itli_itemname,s.dist_distributor,s.dist_distributorid,mt.maty_material,b.budg_budgetname,dtf.dept_depname fromdep,dtfp.dept_depname fromdepparent');
              $this->db->from('recm_receivedmaster rm'); 
              $this->db->join('recd_receiveddetail rd', 'rd.recd_receivedmasterid = rm.recm_receivedmasterid', 'LEFT');
              $this->db->join('itli_itemslist it', 'it.itli_itemlistid = rd.recd_itemsid', 'LEFT');
              $this->db->join('unit_unit ut', 'it.itli_unitid = ut.unit_unitid', 'LEFT');
              $this->db->join('dist_distributors s', 's.dist_distributorid = rm.recm_supplierid', 'LEFT');
              $this->db->join('budg_budgets b', 'b.budg_budgetid = rm.recm_budgetid', 'LEFT');
              $this->db->join('maty_materialtype mt', 'mt.maty_materialtypeid=rm.recm_mattypeid', "LEFT");
              // $this->db->join('loca_location scf', 'rm.recm_school=scf.loca_locationid', 'LEFT');
              $this->db->join('dept_department dtf', 'rm.recm_departmentid=dtf.dept_depid', 'LEFT');
              $this->db->join('dept_department dtfp', 'dtfp.dept_depid=dtf.dept_parentdepid', 'LEFT');
              $this->db->where('recm_status','O');
              $this->db->where('recm_school',$item->recm_school);

              $school[$key]['school_details'] = $this->db->get()->result();
            }
        }

        $this->db->flush_cache();   
        return $school;
    }

    public function get_purchase_received_department_detail_ku()
    {
        $locationid = $this->input->post('locationid');
        $searchDateType = $this->input->post('searchDateType');
        $frmDate = $this->input->post('frmDate');
        $toDate = $this->input->post('toDate');
        $store_id = $this->input->post('store_id');
        $supplierid = $this->input->post('supplierid');
        $recm_mattypeid = $this->input->post('recm_mattypeid');
        $schoolid = $this->input->post('school');
        $departmentid = $this->input->post('departmentid');
        $subdepid = $this->input->post('subdepid');
        $recm_receivedby = $this->input->post('recm_receivedby');
        $rpt_type = $this->input->post('rpt_type');
        $rpt_wise = $this->input->post('rpt_wise');

        $subdeparray = array();
        if ($departmentid) {
            $check_parentid = $this->general->get_tbl_data('dept_depid,dept_parentdepid', 'dept_department', array('dept_depid' => $departmentid), 'dept_depname', 'ASC');
        }

        if (!empty($check_parentid)) {
            $parentdepid = !empty($check_parentid[0]->dept_parentdepid) ? $check_parentid[0]->dept_parentdepid : '0';
            if ($parentdepid == '0') {
                $subdep_result = $this->general->get_tbl_data('dept_depid', 'dept_department', array('dept_parentdepid' => $departmentid), 'dept_depname', 'ASC');
                if (!empty($subdep_result)) {
                    foreach ($subdep_result as $ksd => $dep) {
                        $subdeparray[] = $dep->dept_depid;
                    }
                }

            }
        }

        $this->db->start_cache();
        if ($searchDateType == 'date_range') {
            if ($frmDate &&  $toDate) {
                if (DEFAULT_DATEPICKER == 'NP') {
                    $this->db->where('recm_receiveddatebs >=', $frmDate);
                    $this->db->where('recm_receiveddatebs <=', $toDate);
                } else {
                    $this->db->where('recm_receiveddatead >=', $frmDate);
                    $this->db->where('recm_receiveddatead <=', $toDate);
                }
            }
        }

        if ($this->location_ismain == 'Y') {
            if (!empty($locationid)) {
                $this->db->where('rm.recm_locationid', $locationid);
            }
        } else {
            $this->db->where('rm.recm_locationid', $this->locationid);
        }

        if ( (!empty($this->mattypeid) && $this->mattypeid == '2') || (!empty($recm_mattypeid) && $recm_mattypeid == '2') ) { 
          if (!empty($recm_receivedby)) {
              $staffid = explode(',',$recm_receivedby);
              if($staffid[0] != '1') 
                $this->db->where('rm.recm_receivedstaffid', $staffid[0]);
          }
        }

        if (!empty($store_id)) {
            $this->db->where('recm_storeid', $store_id);
        }

        if (!empty($supplierid)) {
            $this->db->where(array('rm.recm_supplierid' => $supplierid));
        }

        if (!empty($this->mattypeid)) {
            $this->db->where('rm.recm_mattypeid', $this->mattypeid);
        } else {
            if (!empty($recm_mattypeid)) {
                $this->db->where('rm.recm_mattypeid', $recm_mattypeid);
            }
        }

        if (!empty($schoolid)) {
            $this->db->where('rm.recm_school', $schoolid);
        }

        $this->db->stop_cache();

        if (!empty($departmentid)) {

            if (!empty($subdepid)) {
                $this->db->where("recm_departmentid =" . $subdepid . " ");
            } else {
                if (!empty($subdeparray)) {
                    $this->db->where_in("recm_departmentid", $subdeparray);
                } else {
                    $this->db->where("recm_departmentid =" . $departmentid . " ");
                }
            }
        }


        $this->db->select('DISTINCT(rm.recm_departmentid), de.dept_depid, de.dept_depname, dtfp.dept_depname fromdepparent');
        $this->db->from('recm_receivedmaster rm');
        $this->db->join('dept_department de', 'rm.recm_departmentid=de.dept_depid', 'LEFT');
        $this->db->join('dept_department dtfp', 'dtfp.dept_depid=de.dept_parentdepid', 'LEFT');
        $this->db->where('recm_status','O');
        $this->db->order_by('dept_depname','ASC');
        $department_list = $this->db->get()->result();
        // echo $this->db->last_query();
        // $this->db->flush_cache();   
        // die();
        $department = array();
        if (count($department_list)) {
            foreach ($department_list as $key => $item) {
                if (!empty($item->fromdepparent)) {
                    $dept_name = "$item->fromdepparent ($item->dept_depname)";    
                }else{
                    $dept_name = $item->dept_depname;
                }
            
                $department[$key]['department_name'] = $dept_name;
 
              $this->db->select('rm.*, rd.*, ut.unit_unitname, it.itli_itemcode, it.itli_itemname, s.dist_distributor,s.dist_distributorid,scf.loca_name schoolname, mt.maty_material, b.budg_budgetname, dtf.dept_depname fromdep, dtfp.dept_depname fromdepparent');
              $this->db->from('recm_receivedmaster rm'); 
              $this->db->join('recd_receiveddetail rd', 'rd.recd_receivedmasterid = rm.recm_receivedmasterid', 'LEFT');
              $this->db->join('itli_itemslist it', 'it.itli_itemlistid = rd.recd_itemsid', 'LEFT');
              $this->db->join('unit_unit ut', 'it.itli_unitid = ut.unit_unitid', 'LEFT');
              $this->db->join('dist_distributors s', 's.dist_distributorid = rm.recm_supplierid', 'LEFT');
              $this->db->join('budg_budgets b', 'b.budg_budgetid = rm.recm_budgetid', 'LEFT');
              $this->db->join('maty_materialtype mt', 'mt.maty_materialtypeid=rm.recm_mattypeid', "LEFT");
              $this->db->join('loca_location scf', 'rm.recm_school=scf.loca_locationid', 'LEFT');
              $this->db->join('dept_department dtf', 'rm.recm_departmentid=dtf.dept_depid', 'LEFT');
              $this->db->join('dept_department dtfp', 'dtfp.dept_depid=dtf.dept_parentdepid', 'LEFT');
              $this->db->where('recm_status','O');
              $this->db->where('recm_departmentid',$item->recm_departmentid);

              $department[$key]['department_details'] = $this->db->get()->result();
            }
        }

        $this->db->flush_cache();   
        return $department;
    }


    public function get_purchase_received_received_date_detail_ku()
    {
        $locationid = $this->input->post('locationid');
        $searchDateType = $this->input->post('searchDateType');
        $frmDate = $this->input->post('frmDate');
        $toDate = $this->input->post('toDate');
        $store_id = $this->input->post('store_id');
        $supplierid = $this->input->post('supplierid');
        $recm_mattypeid = $this->input->post('recm_mattypeid');
        $schoolid = $this->input->post('school');
        $departmentid = $this->input->post('departmentid');
        $subdepid = $this->input->post('subdepid');
        $recm_receivedby = $this->input->post('recm_receivedby');
        $rpt_type = $this->input->post('rpt_type');
        $rpt_wise = $this->input->post('rpt_wise');

        $subdeparray = array();
        if ($departmentid) {
            $check_parentid = $this->general->get_tbl_data('dept_depid,dept_parentdepid', 'dept_department', array('dept_depid' => $departmentid), 'dept_depname', 'ASC');
        }

        if (!empty($check_parentid)) {
            $parentdepid = !empty($check_parentid[0]->dept_parentdepid) ? $check_parentid[0]->dept_parentdepid : '0';
            if ($parentdepid == '0') {
                $subdep_result = $this->general->get_tbl_data('dept_depid', 'dept_department', array('dept_parentdepid' => $departmentid), 'dept_depname', 'ASC');
                if (!empty($subdep_result)) {
                    foreach ($subdep_result as $ksd => $dep) {
                        $subdeparray[] = $dep->dept_depid;
                    }
                }

            }
        }

        $this->db->start_cache();
        
        if ($this->location_ismain == 'Y') {
            if (!empty($locationid)) {
                $this->db->where('rm.recm_locationid', $locationid);
            }
        } else {
            $this->db->where('rm.recm_locationid', $this->locationid);
        }

        if ( (!empty($this->mattypeid) && $this->mattypeid == '2') || (!empty($recm_mattypeid) && $recm_mattypeid == '2') ) { 
          if (!empty($recm_receivedby)) {
              $staffid = explode(',',$recm_receivedby);
              if($staffid[0] != '1') 
                $this->db->where('rm.recm_receivedstaffid', $staffid[0]);
          }
        }

        if (!empty($store_id)) {
            $this->db->where('recm_storeid', $store_id);
        }

        if (!empty($supplierid)) {
            $this->db->where(array('rm.recm_supplierid' => $supplierid));
        }

        if (!empty($this->mattypeid)) {
            $this->db->where('rm.recm_mattypeid', $this->mattypeid);
        } else {
            if (!empty($recm_mattypeid)) {
                $this->db->where('rm.recm_mattypeid', $recm_mattypeid);
            }
        }

        if (!empty($schoolid)) {
            $this->db->where('rm.recm_school', $schoolid);
        }

        if (!empty($departmentid)) {

            if (!empty($subdepid)) {
                $this->db->where("recm_departmentid =" . $subdepid . " ");
            } else {
                if (!empty($subdeparray)) {
                    $this->db->where_in("recm_departmentid", $subdeparray);
                } else {
                    $this->db->where("recm_departmentid =" . $departmentid . " ");
                }
            }
        }
        $this->db->stop_cache();

        if ($searchDateType == 'date_range') {
            if ($frmDate &&  $toDate) {
                if (DEFAULT_DATEPICKER == 'NP') {
                    $this->db->where('recm_receiveddatebs >=', $frmDate);
                    $this->db->where('recm_receiveddatebs <=', $toDate);
                } else {
                    $this->db->where('recm_receiveddatead >=', $frmDate);
                    $this->db->where('recm_receiveddatead <=', $toDate);
                }
            }
        }



        $this->db->select('DISTINCT(rm.recm_receiveddatebs),recm_receiveddatead');
        $this->db->from('recm_receivedmaster rm');
        $this->db->where('recm_status','O');
        $this->db->order_by('recm_receiveddatebs','ASC');
        $received_date_list = $this->db->get()->result();
       
        $date = array();
        if (count($received_date_list)) {

            foreach ($received_date_list as $key => $item) {
                
            $date[$key]['received_date'] = "$item->recm_receiveddatebs (B.S) - $item->recm_receiveddatead (A.D)";
 
              $this->db->select('rm.*, rd.*, ut.unit_unitname, it.itli_itemcode, it.itli_itemname, s.dist_distributor,s.dist_distributorid,scf.loca_name schoolname, mt.maty_material, b.budg_budgetname, dtf.dept_depname fromdep, dtfp.dept_depname fromdepparent');
              $this->db->from('recm_receivedmaster rm'); 
              $this->db->join('recd_receiveddetail rd', 'rd.recd_receivedmasterid = rm.recm_receivedmasterid', 'LEFT');
              $this->db->join('itli_itemslist it', 'it.itli_itemlistid = rd.recd_itemsid', 'LEFT');
              $this->db->join('unit_unit ut', 'it.itli_unitid = ut.unit_unitid', 'LEFT');
              $this->db->join('dist_distributors s', 's.dist_distributorid = rm.recm_supplierid', 'LEFT');
              $this->db->join('budg_budgets b', 'b.budg_budgetid = rm.recm_budgetid', 'LEFT');
              $this->db->join('maty_materialtype mt', 'mt.maty_materialtypeid=rm.recm_mattypeid', "LEFT");
              $this->db->join('loca_location scf', 'rm.recm_school=scf.loca_locationid', 'LEFT');
              $this->db->join('dept_department dtf', 'rm.recm_departmentid=dtf.dept_depid', 'LEFT');
              $this->db->join('dept_department dtfp', 'dtfp.dept_depid=dtf.dept_parentdepid', 'LEFT');
              $this->db->where('recm_status','O');
              $this->db->where('recm_receiveddatebs',$item->recm_receiveddatebs);

          $date[$key]['date_details'] = $this->db->get()->result();
            }
        }

        $this->db->flush_cache();   
        return $date;
    }

    public function get_purchase_received_bill_date_detail_ku()
        {
            $locationid = $this->input->post('locationid');
            $searchDateType = $this->input->post('searchDateType');
            $frmDate = $this->input->post('frmDate');
            $toDate = $this->input->post('toDate');
            $store_id = $this->input->post('store_id');
            $supplierid = $this->input->post('supplierid');
            $recm_mattypeid = $this->input->post('recm_mattypeid');
            $schoolid = $this->input->post('school');
            $departmentid = $this->input->post('departmentid');
            $subdepid = $this->input->post('subdepid');
            $recm_receivedby = $this->input->post('recm_receivedby');
            $rpt_type = $this->input->post('rpt_type');
            $rpt_wise = $this->input->post('rpt_wise');

            $subdeparray = array();
            if ($departmentid) {
                $check_parentid = $this->general->get_tbl_data('dept_depid,dept_parentdepid', 'dept_department', array('dept_depid' => $departmentid), 'dept_depname', 'ASC');
            }

            if (!empty($check_parentid)) {
                $parentdepid = !empty($check_parentid[0]->dept_parentdepid) ? $check_parentid[0]->dept_parentdepid : '0';
                if ($parentdepid == '0') {
                    $subdep_result = $this->general->get_tbl_data('dept_depid', 'dept_department', array('dept_parentdepid' => $departmentid), 'dept_depname', 'ASC');
                    if (!empty($subdep_result)) {
                        foreach ($subdep_result as $ksd => $dep) {
                            $subdeparray[] = $dep->dept_depid;
                        }
                    }

                }
            }

            $this->db->start_cache();
            
            if ($this->location_ismain == 'Y') {
                if (!empty($locationid)) {
                    $this->db->where('rm.recm_locationid', $locationid);
                }
            } else {
                $this->db->where('rm.recm_locationid', $this->locationid);
            }

            if ( (!empty($this->mattypeid) && $this->mattypeid == '2') || (!empty($recm_mattypeid) && $recm_mattypeid == '2') ) { 
              if (!empty($recm_receivedby)) {
                  $staffid = explode(',',$recm_receivedby);
                  if($staffid[0] != '1') 
                    $this->db->where('rm.recm_receivedstaffid', $staffid[0]);
              }
            }

            if (!empty($store_id)) {
                $this->db->where('recm_storeid', $store_id);
            }

            if (!empty($supplierid)) {
                $this->db->where(array('rm.recm_supplierid' => $supplierid));
            }

            if (!empty($this->mattypeid)) {
                $this->db->where('rm.recm_mattypeid', $this->mattypeid);
            } else {
                if (!empty($recm_mattypeid)) {
                    $this->db->where('rm.recm_mattypeid', $recm_mattypeid);
                }
            }

            if (!empty($schoolid)) {
                $this->db->where('rm.recm_school', $schoolid);
            }

            if (!empty($departmentid)) {

                if (!empty($subdepid)) {
                    $this->db->where("recm_departmentid =" . $subdepid . " ");
                } else {
                    if (!empty($subdeparray)) {
                        $this->db->where_in("recm_departmentid", $subdeparray);
                    } else {
                        $this->db->where("recm_departmentid =" . $departmentid . " ");
                    }
                }
            }

            if ($searchDateType == 'date_range') {
                if ($frmDate &&  $toDate) {
                    if (DEFAULT_DATEPICKER == 'NP') {
                        $this->db->where('recm_receiveddatebs >=', $frmDate);
                        $this->db->where('recm_receiveddatebs <=', $toDate);
                    } else {
                        $this->db->where('recm_receiveddatead >=', $frmDate);
                        $this->db->where('recm_receiveddatead <=', $toDate);
                    }
                }
            }

            $this->db->stop_cache();




            $this->db->select('DISTINCT(rm.recm_supbilldatebs),recm_supbilldatead');
            $this->db->from('recm_receivedmaster rm');
            $this->db->where('recm_status','O');
            $this->db->order_by('recm_supbilldatebs','ASC');
            $bill_date_list = $this->db->get()->result();
           
            $date = array();
            if (count($bill_date_list)) {

                foreach ($bill_date_list as $key => $item) {
                    
                $date[$key]['bill_date'] = "$item->recm_supbilldatebs (B.S) - $item->recm_supbilldatead (A.D)";
     
                  $this->db->select('rm.*, rd.*, ut.unit_unitname, it.itli_itemcode, it.itli_itemname, s.dist_distributor,s.dist_distributorid,scf.loca_name schoolname, mt.maty_material, b.budg_budgetname, dtf.dept_depname fromdep, dtfp.dept_depname fromdepparent');
                  $this->db->from('recm_receivedmaster rm'); 
                  $this->db->join('recd_receiveddetail rd', 'rd.recd_receivedmasterid = rm.recm_receivedmasterid', 'LEFT');
                  $this->db->join('itli_itemslist it', 'it.itli_itemlistid = rd.recd_itemsid', 'LEFT');
                  $this->db->join('unit_unit ut', 'it.itli_unitid = ut.unit_unitid', 'LEFT');
                  $this->db->join('dist_distributors s', 's.dist_distributorid = rm.recm_supplierid', 'LEFT');
                  $this->db->join('budg_budgets b', 'b.budg_budgetid = rm.recm_budgetid', 'LEFT');
                  $this->db->join('maty_materialtype mt', 'mt.maty_materialtypeid=rm.recm_mattypeid', "LEFT");
                  $this->db->join('loca_location scf', 'rm.recm_school=scf.loca_locationid', 'LEFT');
                  $this->db->join('dept_department dtf', 'rm.recm_departmentid=dtf.dept_depid', 'LEFT');
                  $this->db->join('dept_department dtfp', 'dtfp.dept_depid=dtf.dept_parentdepid', 'LEFT');
                  $this->db->where('recm_status','O');
                  $this->db->where('recm_supbilldatebs',$item->recm_supbilldatebs);

              $date[$key]['date_details'] = $this->db->get()->result();
                }
            }

            $this->db->flush_cache();   
            return $date;
        }


         public function get_receiver_detail_ku()
        {
            $locationid = $this->input->post('locationid');
            $searchDateType = $this->input->post('searchDateType');
            $frmDate = $this->input->post('frmDate');
            $toDate = $this->input->post('toDate');
            $store_id = $this->input->post('store_id');
            $supplierid = $this->input->post('supplierid');
            $recm_mattypeid = $this->input->post('recm_mattypeid');
            $schoolid = $this->input->post('school');
            $departmentid = $this->input->post('departmentid');
            $subdepid = $this->input->post('subdepid');
            $recm_receivedby = $this->input->post('recm_receivedby');
            $rpt_type = $this->input->post('rpt_type');
            $rpt_wise = $this->input->post('rpt_wise');

            $subdeparray = array();
            if ($departmentid) {
                $check_parentid = $this->general->get_tbl_data('dept_depid,dept_parentdepid', 'dept_department', array('dept_depid' => $departmentid), 'dept_depname', 'ASC');
            }

            if (!empty($check_parentid)) {
                $parentdepid = !empty($check_parentid[0]->dept_parentdepid) ? $check_parentid[0]->dept_parentdepid : '0';
                if ($parentdepid == '0') {
                    $subdep_result = $this->general->get_tbl_data('dept_depid', 'dept_department', array('dept_parentdepid' => $departmentid), 'dept_depname', 'ASC');
                    if (!empty($subdep_result)) {
                        foreach ($subdep_result as $ksd => $dep) {
                            $subdeparray[] = $dep->dept_depid;
                        }
                    }

                }
            }

            $this->db->start_cache();
            
            if ($this->location_ismain == 'Y') {
                if (!empty($locationid)) {
                    $this->db->where('rm.recm_locationid', $locationid);
                }
            } else {
                $this->db->where('rm.recm_locationid', $this->locationid);
            }

            if ( (!empty($this->mattypeid) && $this->mattypeid == '2') || (!empty($recm_mattypeid) && $recm_mattypeid == '2') ) { 
              if (!empty($recm_receivedby)) {
                  $staffid = explode(',',$recm_receivedby);
                  if($staffid[0] != '1') 
                    $this->db->where('rm.recm_receivedstaffid', $staffid[0]);
              }
            }

            if (!empty($store_id)) {
                $this->db->where('recm_storeid', $store_id);
            }

            if (!empty($supplierid)) {
                $this->db->where(array('rm.recm_supplierid' => $supplierid));
            }

            if (!empty($this->mattypeid)) {
                $this->db->where('rm.recm_mattypeid', $this->mattypeid);
            } else {
                if (!empty($recm_mattypeid)) {
                    $this->db->where('rm.recm_mattypeid', $recm_mattypeid);
                }
            }

            if (!empty($schoolid)) {
                $this->db->where('rm.recm_school', $schoolid);
            }

            if (!empty($departmentid)) {

                if (!empty($subdepid)) {
                    $this->db->where("recm_departmentid =" . $subdepid . " ");
                } else {
                    if (!empty($subdeparray)) {
                        $this->db->where_in("recm_departmentid", $subdeparray);
                    } else {
                        $this->db->where("recm_departmentid =" . $departmentid . " ");
                    }
                }
            }

            if ($searchDateType == 'date_range') {
                if ($frmDate &&  $toDate) {
                    if (DEFAULT_DATEPICKER == 'NP') {
                        $this->db->where('recm_receiveddatebs >=', $frmDate);
                        $this->db->where('recm_receiveddatebs <=', $toDate);
                    } else {
                        $this->db->where('recm_receiveddatead >=', $frmDate);
                        $this->db->where('recm_receiveddatead <=', $toDate);
                    }
                }
            }

            $this->db->stop_cache();




            $this->db->select('DISTINCT(rm.recm_receivedstaffid) recm_receivedstaffid,si.stin_fname,si.stin_mname,si.stin_lname');
            $this->db->from('recm_receivedmaster rm');
            $this->db->join('stin_staffinfo si','si.stin_staffinfoid=rm.recm_receivedstaffid','LEFT');
            $this->db->where('recm_status','O');
            $this->db->order_by('stin_fname','ASC');
            $staff_date_list = $this->db->get()->result();
           
            $date = array();
            if (count($staff_date_list)) {

                foreach ($staff_date_list as $key => $item) {
                    
                $date[$key]['staff_name'] = "$item->stin_fname $item->stin_mname $item->stin_lname ";
     
                  $this->db->select('rm.*, rd.*, ut.unit_unitname, it.itli_itemcode, it.itli_itemname, s.dist_distributor,s.dist_distributorid,scf.loca_name schoolname, mt.maty_material, b.budg_budgetname, dtf.dept_depname fromdep, dtfp.dept_depname fromdepparent');
                  $this->db->from('recm_receivedmaster rm'); 
                  $this->db->join('recd_receiveddetail rd', 'rd.recd_receivedmasterid = rm.recm_receivedmasterid', 'LEFT');
                  $this->db->join('itli_itemslist it', 'it.itli_itemlistid = rd.recd_itemsid', 'LEFT');
                  $this->db->join('unit_unit ut', 'it.itli_unitid = ut.unit_unitid', 'LEFT');
                  $this->db->join('dist_distributors s', 's.dist_distributorid = rm.recm_supplierid', 'LEFT');
                  $this->db->join('budg_budgets b', 'b.budg_budgetid = rm.recm_budgetid', 'LEFT');
                  $this->db->join('maty_materialtype mt', 'mt.maty_materialtypeid=rm.recm_mattypeid', "LEFT");
                  $this->db->join('loca_location scf', 'rm.recm_school=scf.loca_locationid', 'LEFT');
                  $this->db->join('dept_department dtf', 'rm.recm_departmentid=dtf.dept_depid', 'LEFT');
                  $this->db->join('dept_department dtfp', 'dtfp.dept_depid=dtf.dept_parentdepid', 'LEFT');
                  $this->db->where('recm_status','O');
                  $this->db->where('recm_receivedstaffid',$item->recm_receivedstaffid);

              $date[$key]['receiver_details'] = $this->db->get()->result();
                }
            }

            $this->db->flush_cache();   
            return $date;
        }

}
