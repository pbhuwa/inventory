<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Purchase_req_report_mdl extends CI_Model
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


  public function get_purchase_req_report_summary_ku()
  {
    $locationid = $this->input->post('locationid');
    $searchDateType = $this->input->post('searchDateType');
    $frmDate = $this->input->post('frmDate');
    $toDate = $this->input->post('toDate');
    $pure_mattypeid = $this->input->post('pure_mattypeid');
    $schoolid = $this->input->post('school');
    $departmentid = $this->input->post('departmentid');
    $subdepid = $this->input->post('subdepid');
    $pure_requser = $this->input->post('pure_requser');
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
      if (!empty(($frmDate && $toDate))) {
        if (DEFAULT_DATEPICKER == 'NP') {
          $this->db->where('pure_reqdatebs >=', $frmDate);
          $this->db->where('pure_reqdatebs <=', $toDate);
        } else {
          $this->db->where('pure_reqdatead >=', $frmDate);
          $this->db->where('pure_reqdatead <=', $toDate);
        }
      }
    }

    if (!empty($this->mattypeid)) {
      $this->db->where('pure_mattypeid', $this->mattypeid);
    } else {
      if (!empty($pure_mattypeid)) {
        $this->db->where('pure_mattypeid', $pure_mattypeid);
      }
    }


    if (!empty($pure_requser)) {
      $this->db->where('pure_requser', $pure_requser);
    }


    if ($this->location_ismain == 'Y') {
      if (!empty($locationid)) {
        $this->db->where('pure_locationid', $locationid);
      }
    } else {
      $this->db->where('pure_locationid', $this->locationid);
    }

    if (!empty($departmentid)) {
      if (!empty($subdepid)) {
        $this->db->where("rema_reqfromdepid =" . $subdepid . " ");
      } else {
        if (!empty($subdeparray)) {
          $this->db->where_in("rema_reqfromdepid", $subdeparray);
        } else {
          $this->db->where("rema_reqfromdepid =" . $departmentid . " ");
        }
      }
    }

    if (!empty($schoolid)) {
      $this->db->where('rema_school', $schoolid);
    }

    $this->db->stop_cache();

    $this->db->select("cm.pure_purchasereqid,cm.pure_isapproved,cm.pure_posttime,cm.pure_fyear,cm.pure_approveddatebs,cm.pure_reqno,cm.pure_streqno,cm.pure_reqdatebs,cm.pure_reqdatead,cm.pure_requser,cm.pure_approveddatead,pure_locationid,cm.pure_reqtime,cm.pure_requestto, cm.pure_accountverify,pm.puor_purchaseordermasterid,cm.pure_reqmasterid,mt.maty_material,um.usma_username,d.dept_depname as deptfrom,dtfp.dept_depname deptparent,scf.loca_name as schoolname");
    $this->db->from('pure_purchaserequisition cm');
    $this->db->join('rema_reqmaster rm', 'rm.rema_reqmasterid=cm.pure_reqmasterid', 'LEFT');
    $this->db->join('puor_purchaseordermaster pm', ' pm.puor_purchasereqmasterid = cm.pure_purchasereqid ', 'left');
    $this->db->join('dept_department d', 'd.dept_depid=rm.rema_reqfromdepid', 'LEFT');
    $this->db->join('dept_department dtfp', 'dtfp.dept_depid=d.dept_parentdepid', 'LEFT');
    $this->db->join('loca_location scf', 'rm.rema_school=scf.loca_locationid', 'LEFT');
    $this->db->join('maty_materialtype mt', 'mt.maty_materialtypeid=cm.pure_mattypeid', 'LEFT');
    $this->db->join('eqty_equipmenttype t', 't.eqty_equipmenttypeid = cm.pure_itemstypeid', 'LEFT');
    $this->db->join('usma_usermain um', 'um.usma_userid = cm.pure_approvaluser', 'LEFT');

    $data['summary'] = $this->db->get()->result();
    if ($rpt_wise == 'default') {
      $this->db->flush_cache();
      // echo $this->db->last_query();
      // die;
      unset($array);
      $array['summary'] = $data['summary'];
      return $array;
    }

    $this->db->select('d.dept_depname as deptfrom,dtfp.dept_depname deptparent,loca_name as schoolname,SUM(purd_qty) as qty,COUNT(*) as cnt');
    $this->db->from('purd_purchasereqdetail pd');
    $this->db->join('pure_purchaserequisition cm', 'cm.pure_purchasereqid = pd.purd_reqid ', 'LEFT');
    $this->db->join('maty_materialtype mt', 'mt.maty_materialtypeid=cm.pure_mattypeid', 'LEFT');
    $this->db->join('rema_reqmaster rm', 'rm.rema_reqmasterid=cm.pure_reqmasterid', 'LEFT');
    $this->db->join('dept_department d', 'd.dept_depid=rm.rema_reqfromdepid', 'LEFT');
    $this->db->join('dept_department dtfp', 'dtfp.dept_depid=d.dept_parentdepid', 'LEFT');
    $this->db->join('loca_location scf', 'rm.rema_school=scf.loca_locationid', 'LEFT');
    // $this->db->join('usma_usermain um','um.usma_userid = cm.pure_approvaluser','LEFT');
    // $this->db->join('eqty_equipmenttype t','t.eqty_equipmenttypeid = cm.pure_itemstypeid','LEFT');
    // $this->db->join('itli_itemslist itm','itm.itli_itemlistid = qd.purd_itemsid','LEFT');
    // $this->db->join('unit_unit un','un.unit_unitid = itm.itli_unitid','LEFT');
    $data['department'] = $this->db->get()->result();
    if ($rpt_wise == 'department') {
      $this->db->flush_cache();
      // echo "<pre>";
      // print_r($this->db->last_query());
      // die;
      unset($array);
      $array['department'] = $data['department'];
      return $array;
    }

    $this->db->select("maty_material, SUM(rd.rede_remqty) as rede_remqty,SUM(rede_qty) as rede_qty");
    $this->db->from('rema_reqmaster rm');
    $this->db->join('rede_reqdetail rd', 'rm.rema_reqmasterid=rd.rede_reqmasterid', 'LEFT');
    $this->db->join('dept_department d', 'd.dept_depid=rm.rema_reqfromdepid', 'LEFT');
    $this->db->join('dept_department dtfp', 'dtfp.dept_depid=d.dept_parentdepid', 'LEFT');
    $this->db->join('loca_location scf', 'rm.rema_school=scf.loca_locationid', 'LEFT');
    $this->db->join('maty_materialtype mt', 'mt.maty_materialtypeid=rm.rema_mattypeid', "LEFT");
    $this->db->join('eqty_equipmenttype et', 'et.eqty_equipmenttypeid=rm.rema_reqtodepid', 'LEFT');
    $this->db->where('rema_isdep <>', '');
    $this->db->group_by('rema_mattypeid');
    $data['material_type'] = $this->db->get()->result();
    if ($rpt_wise == 'material_type') {
      $this->db->flush_cache();
      unset($array);
      $array['material_type'] = $data['material_type'];
      return $array;
    }

    $this->db->select("rema_reqdatebs,rema_reqdatead, SUM(rd.rede_remqty) as rede_remqty,SUM(rede_qty) as rede_qty");
    $this->db->from('rema_reqmaster rm');
    $this->db->join('rede_reqdetail rd', 'rm.rema_reqmasterid=rd.rede_reqmasterid', 'LEFT');
    $this->db->join('dept_department d', 'd.dept_depid=rm.rema_reqfromdepid', 'LEFT');
    $this->db->join('dept_department dtfp', 'dtfp.dept_depid=d.dept_parentdepid', 'LEFT');
    $this->db->join('loca_location scf', 'rm.rema_school=scf.loca_locationid', 'LEFT');
    $this->db->join('maty_materialtype mt', 'mt.maty_materialtypeid=rm.rema_mattypeid', "LEFT");
    $this->db->join('eqty_equipmenttype et', 'et.eqty_equipmenttypeid=rm.rema_reqtodepid', 'LEFT');
    $this->db->where('rema_isdep <>', '');
    $this->db->group_by('rema_reqdatebs');
    $data['demand_date'] = $this->db->get()->result();
    if ($rpt_wise == 'demand_date') {
      $this->db->flush_cache();
      unset($array);
      $array['demand_date'] = $data['demand_date'];
      return $array;
    }

    $this->db->select("rema_reqby, SUM(rd.rede_remqty) as rede_remqty,SUM(rede_qty) as rede_qty");
    $this->db->from('rema_reqmaster rm');
    $this->db->join('rede_reqdetail rd', 'rm.rema_reqmasterid=rd.rede_reqmasterid', 'LEFT');
    $this->db->join('dept_department d', 'd.dept_depid=rm.rema_reqfromdepid', 'LEFT');
    $this->db->join('dept_department dtfp', 'dtfp.dept_depid=d.dept_parentdepid', 'LEFT');
    $this->db->join('loca_location scf', 'rm.rema_school=scf.loca_locationid', 'LEFT');
    $this->db->join('maty_materialtype mt', 'mt.maty_materialtypeid=rm.rema_mattypeid', "LEFT");
    $this->db->join('eqty_equipmenttype et', 'et.eqty_equipmenttypeid=rm.rema_reqtodepid', 'LEFT');
    $this->db->where('rema_isdep <>', '');
    $this->db->group_by('rema_reqby');
    $data['requested_by'] = $this->db->get()->result();
    if ($rpt_wise == 'requested_by') {
      $this->db->flush_cache();
      unset($array);
      $array['requested_by'] = $data['requested_by'];
      return $array;
    }
    $this->db->flush_cache();
    return $data;
  }

  public function get_purchase_req_report_detail_ku()
  {
    $locationid = $this->input->post('locationid');
    $searchDateType = $this->input->post('searchDateType');
    $frmDate = $this->input->post('frmDate');
    $toDate = $this->input->post('toDate');
    $pure_mattypeid = $this->input->post('pure_mattypeid');
    $schoolid = $this->input->post('school');
    $departmentid = $this->input->post('departmentid');
    $subdepid = $this->input->post('subdepid');
    $pure_requser = $this->input->post('pure_requser');
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
      if (!empty(($frmDate && $toDate))) {
        if (DEFAULT_DATEPICKER == 'NP') {
          $this->db->where('pure_reqdatebs >=', $frmDate);
          $this->db->where('pure_reqdatebs <=', $toDate);
        } else {
          $this->db->where('pure_reqdatead >=', $frmDate);
          $this->db->where('pure_reqdatead <=', $toDate);
        }
      }
    }

    if (!empty($this->mattypeid)) {
      $this->db->where('pure_mattypeid', $this->mattypeid);
    } else {
      if (!empty($pure_mattypeid)) {
        $this->db->where('pure_mattypeid', $pure_mattypeid);
      }
    }


    if (!empty($pure_requser)) {
      $this->db->where('pure_requser', $pure_requser);
    }


    if ($this->location_ismain == 'Y') {
      if (!empty($locationid)) {
        $this->db->where('pure_locationid', $locationid);
      }
    } else {
      $this->db->where('pure_locationid', $this->locationid);
    }

    if (!empty($departmentid)) {
      if (!empty($subdepid)) {
        $this->db->where("rema_reqfromdepid =" . $subdepid . " ");
      } else {
        if (!empty($subdeparray)) {
          $this->db->where_in("rema_reqfromdepid", $subdeparray);
        } else {
          $this->db->where("rema_reqfromdepid =" . $departmentid . " ");
        }
      }
    }

    if (!empty($schoolid)) {
      $this->db->where('rema_school', $schoolid);
    }
    $this->db->stop_cache();

    $this->db->select('cm.pure_purchasereqid,cm.pure_isapproved,cm.pure_posttime,cm.pure_fyear,cm.pure_approvaluser,cm.pure_approveddatebs,cm.pure_reqno,cm.pure_reqtime,cm.pure_reqdatebs,cm.pure_reqdatead,cm.pure_appliedby,cm.pure_requser as user,cm.pure_approveddatead,cm.pure_requestto,itm.itli_itemname,itm.itli_itemnamenp,itm.itli_itemcode,qd.purd_qty,qd.purd_remarks,qd.purd_unit,cm.pure_locationid,qd.purd_stock,qd.purd_rate,un.unit_unitname,um.usma_username,maty_material,d.dept_depname as deptfrom,dtfp.dept_depname deptparent,scf.loca_name as schoolname');
    $this->db->from('purd_purchasereqdetail qd');
    $this->db->join('pure_purchaserequisition cm', 'cm.pure_purchasereqid = qd.purd_reqid ', 'LEFT');
    $this->db->join('maty_materialtype mt', 'mt.maty_materialtypeid=cm.pure_mattypeid', 'LEFT');
    $this->db->join('rema_reqmaster rm', 'rm.rema_reqmasterid=cm.pure_reqmasterid', 'LEFT');
    $this->db->join('dept_department d', 'd.dept_depid=rm.rema_reqfromdepid', 'LEFT');
    $this->db->join('dept_department dtfp', 'dtfp.dept_depid=d.dept_parentdepid', 'LEFT');
    $this->db->join('loca_location scf', 'rm.rema_school=scf.loca_locationid', 'LEFT');
    $this->db->join('usma_usermain um', 'um.usma_userid = cm.pure_approvaluser', 'LEFT');
    $this->db->join('eqty_equipmenttype t', 't.eqty_equipmenttypeid = cm.pure_itemstypeid', 'LEFT');
    $this->db->join('itli_itemslist itm', 'itm.itli_itemlistid = qd.purd_itemsid', 'LEFT');
    $this->db->join('unit_unit un', 'un.unit_unitid = itm.itli_unitid', 'LEFT');

    $data = $this->db->get()->result();
    $this->db->flush_cache();
    // echo "<pre>";
    // print_r($data);
    // die;

    return $data;
  }

  public function purchase_req_report_department_detail_ku()
  {
    $locationid = $this->input->post('locationid');
    $searchDateType = $this->input->post('searchDateType');
    $frmDate = $this->input->post('frmDate');
    $toDate = $this->input->post('toDate');
    $pure_mattypeid = $this->input->post('pure_mattypeid');
    $schoolid = $this->input->post('school');
    $departmentid = $this->input->post('departmentid');
    $subdepid = $this->input->post('subdepid');
    $pure_requser = $this->input->post('pure_requser');
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
      if (!empty(($frmDate && $toDate))) {
        if (DEFAULT_DATEPICKER == 'NP') {
          $this->db->where('pure_reqdatebs >=', $frmDate);
          $this->db->where('pure_reqdatebs <=', $toDate);
        } else {
          $this->db->where('pure_reqdatead >=', $frmDate);
          $this->db->where('pure_reqdatead <=', $toDate);
        }
      }
    }

    if (!empty($this->mattypeid)) {
      $this->db->where('pure_mattypeid', $this->mattypeid);
    } else {
      if (!empty($pure_mattypeid)) {
        $this->db->where('pure_mattypeid', $pure_mattypeid);
      }
    }


    if (!empty($pure_requser)) {
      $this->db->where('pure_requser', $pure_requser);
    }


    if ($this->location_ismain == 'Y') {
      if (!empty($locationid)) {
        $this->db->where('pure_locationid', $locationid);
      }
    } else {
      $this->db->where('pure_locationid', $this->locationid);
    }

    if (!empty($schoolid)) {
      $this->db->where('rema_school', $schoolid);
    }

    $this->db->stop_cache();

    if (!empty($departmentid)) {
      if (!empty($subdepid)) {
        $this->db->where("rema_reqfromdepid =" . $subdepid . " ");
      } else {
        if (!empty($subdeparray)) {
          $this->db->where_in("rema_reqfromdepid", $subdeparray);
        } else {
          $this->db->where("rema_reqfromdepid =" . $departmentid . " ");
        }
      }
    }

    $this->db->select('DISTINCT(rema_reqfromdepid),d.dept_depname as deptfrom,dtfp.dept_depname deptparent,scf.loca_name as schoolname');
    $this->db->from('pure_purchaserequisition cm');
    $this->db->join('maty_materialtype mt', 'mt.maty_materialtypeid=cm.pure_mattypeid', 'LEFT');
    $this->db->join('rema_reqmaster rm', 'rm.rema_reqmasterid=cm.pure_reqmasterid', 'LEFT');
    $this->db->join('dept_department d', 'd.dept_depid=rm.rema_reqfromdepid', 'LEFT');
    $this->db->join('dept_department dtfp', 'dtfp.dept_depid=d.dept_parentdepid', 'LEFT');
    $this->db->join('loca_location scf', 'rm.rema_school=scf.loca_locationid', 'LEFT');
    $dep_list = $this->db->get()->result();

    $department = array();
    foreach ($dep_list as $key => $value) {

      $schoolname = !empty($dept->schoolname) ? $dept->schoolname : '';
      $depparent = !empty($dept->deptparent) ? $dept->deptparent : '';
      if (!empty($depparent)) {
        $department[$key]['name'] = $schoolname . '-' . $depparent . '/' . $dept->deptfrom;
      } else {
        $department[$key]['name'] = !empty($dept->deptfrom) ? "$schoolname-$dept->deptfrom" : $schoolname;
      }

      $this->db->select('cm.pure_purchasereqid,cm.pure_isapproved,cm.pure_posttime,cm.pure_fyear,cm.pure_approvaluser,cm.pure_approveddatebs,cm.pure_reqno,cm.pure_reqtime,cm.pure_reqdatebs,cm.pure_reqdatead,cm.pure_appliedby,cm.pure_requser as user,cm.pure_approveddatead,cm.pure_requestto,itm.itli_itemname,itm.itli_itemnamenp,itm.itli_itemcode,qd.purd_qty,qd.purd_remarks,qd.purd_unit,cm.pure_locationid,qd.purd_stock,qd.purd_rate,un.unit_unitname,um.usma_username,maty_material,d.dept_depname as deptfrom,dtfp.dept_depname deptparent,scf.loca_name as schoolname');
      $this->db->from('purd_purchasereqdetail qd');
      $this->db->join('pure_purchaserequisition cm', 'cm.pure_purchasereqid = qd.purd_reqid ', 'LEFT');
      $this->db->join('maty_materialtype mt', 'mt.maty_materialtypeid=cm.pure_mattypeid', 'LEFT');
      $this->db->join('rema_reqmaster rm', 'rm.rema_reqmasterid=cm.pure_reqmasterid', 'LEFT');
      $this->db->join('dept_department d', 'd.dept_depid=rm.rema_reqfromdepid', 'LEFT');
      $this->db->join('dept_department dtfp', 'dtfp.dept_depid=d.dept_parentdepid', 'LEFT');
      $this->db->join('loca_location scf', 'rm.rema_school=scf.loca_locationid', 'LEFT');
      $this->db->join('usma_usermain um', 'um.usma_userid = cm.pure_approvaluser', 'LEFT');
      $this->db->join('eqty_equipmenttype t', 't.eqty_equipmenttypeid = cm.pure_itemstypeid', 'LEFT');
      $this->db->join('itli_itemslist itm', 'itm.itli_itemlistid = qd.purd_itemsid', 'LEFT');
      $this->db->join('unit_unit un', 'un.unit_unitid = itm.itli_unitid', 'LEFT');
      $this->db->where('rema_reqfromdepid', $value->rema_reqfromdepid);
      $department[$key]['details'] = $this->db->get()->result();
    }
    $this->db->flush_cache();
    return $department;
  }

  public function purchase_req_report_material_type_detail_ku()
  {
    $locationid = $this->input->post('locationid');
    $searchDateType = $this->input->post('searchDateType');
    $frmDate = $this->input->post('frmDate');
    $toDate = $this->input->post('toDate');
    $rema_mattypeid = $this->input->post('rema_mattypeid');
    $schoolid = $this->input->post('school');
    $departmentid = $this->input->post('departmentid');
    $subdepid = $this->input->post('subdepid');
    $rema_reqby = $this->input->post('rema_reqby');
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
      if (!empty(($frmDate && $toDate))) {
        if (DEFAULT_DATEPICKER == 'NP') {
          $this->db->where('rema_reqdatebs >=', $frmDate);
          $this->db->where('rema_reqdatebs <=', $toDate);
        } else {
          $this->db->where('rema_reqdatead >=', $frmDate);
          $this->db->where('rema_reqdatead <=', $toDate);
        }
      }
    }

    if (!empty($rema_reqby)) {
      $this->db->where('rema_reqby', $rema_reqby);
    }


    if ($this->location_ismain == 'Y') {
      if (!empty($locationid)) {
        $this->db->where('rema_locationid', $locationid);
      }
    } else {
      $this->db->where('rema_locationid', $this->locationid);
    }

    if (!empty($schoolid)) {
      $this->db->where('rema_school', $schoolid);
    }

    if (!empty($departmentid)) {
      if (!empty($subdepid)) {
        $this->db->where("rema_reqfromdepid =" . $subdepid . " ");
      } else {
        if (!empty($subdeparray)) {
          $this->db->where_in("rema_reqfromdepid", $subdeparray);
        } else {
          $this->db->where("rema_reqfromdepid =" . $departmentid . " ");
        }
      }
    }
    $this->db->stop_cache();

    if (!empty($this->mattypeid)) {
      $this->db->where('rema_mattypeid', $this->mattypeid);
    } else {
      if (!empty($rema_mattypeid)) {
        $this->db->where('rema_mattypeid', $rema_mattypeid);
      }
    }

    $this->db->select('DISTINCT(rm.rema_mattypeid),maty_material');
    $this->db->from('rema_reqmaster rm');
    $this->db->join('maty_materialtype mt', 'mt.maty_materialtypeid=rm.rema_mattypeid', "LEFT");
    $material_list = $this->db->get()->result();

    $material = array();
    foreach ($material_list as $key => $value) {
      $material[$key]['name'] = $value->maty_material;
      $this->db->select('rd.rede_reqdetailid,rd.rede_remarks,rd.rede_remqty,rd.rede_qty,rm.rema_reqno,rm.rema_reqdatead,rm.rema_reqdatebs,rm.rema_username,rm.rema_fyear,rm.rema_reqby,it.itli_itemname,it.itli_itemnamenp,it.itli_itemcode,u.unit_unitname,,dp.dept_depname,dtfp.dept_depname as deptparent,loca_name as schoolname');
      $this->db->from('rede_reqdetail rd');
      $this->db->join('rema_reqmaster rm', 'rm.rema_reqmasterid=rd.rede_reqmasterid', 'LEFT');
      $this->db->join('dept_department dp', 'dp.dept_depid=rm.rema_reqfromdepid', 'LEFT');
      $this->db->join('dept_department dtfp', 'dtfp.dept_depid=dp.dept_parentdepid', 'LEFT');
      $this->db->join('loca_location scf', 'rm.rema_school=scf.loca_locationid', 'LEFT');
      $this->db->join('eqty_equipmenttype t', 't.eqty_equipmenttypeid = rm.rema_reqtodepid', 'LEFT');
      $this->db->join('itli_itemslist it', 'it.itli_itemlistid = rd.rede_itemsid', 'LEFT');
      $this->db->join('unit_unit u', 'u.unit_unitid = it.itli_unitid', 'LEFT');
      $this->db->where('rm.rema_mattypeid', $value->rema_mattypeid);
      $material[$key]['details'] = $this->db->get()->result();
    }
    $this->db->flush_cache();
    return $material;
  }

  public function purchase_req_report_demand_date_detail_ku()
  {
    $locationid = $this->input->post('locationid');
    $searchDateType = $this->input->post('searchDateType');
    $frmDate = $this->input->post('frmDate');
    $toDate = $this->input->post('toDate');
    $rema_mattypeid = $this->input->post('rema_mattypeid');
    $schoolid = $this->input->post('school');
    $departmentid = $this->input->post('departmentid');
    $subdepid = $this->input->post('subdepid');
    $rema_reqby = $this->input->post('rema_reqby');
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

    if (!empty($this->mattypeid)) {
      $this->db->where('rema_mattypeid', $this->mattypeid);
    } else {
      if (!empty($rema_mattypeid)) {
        $this->db->where('rema_mattypeid', $rema_mattypeid);
      }
    }


    if (!empty($rema_reqby)) {
      $this->db->where('rema_reqby', $rema_reqby);
    }


    if ($this->location_ismain == 'Y') {
      if (!empty($locationid)) {
        $this->db->where('rema_locationid', $locationid);
      }
    } else {
      $this->db->where('rema_locationid', $this->locationid);
    }

    if (!empty($schoolid)) {
      $this->db->where('rema_school', $schoolid);
    }

    if (!empty($departmentid)) {
      if (!empty($subdepid)) {
        $this->db->where("rema_reqfromdepid =" . $subdepid . " ");
      } else {
        if (!empty($subdeparray)) {
          $this->db->where_in("rema_reqfromdepid", $subdeparray);
        } else {
          $this->db->where("rema_reqfromdepid =" . $departmentid . " ");
        }
      }
    }
    $this->db->stop_cache();

    if ($searchDateType == 'date_range') {
      if (!empty(($frmDate && $toDate))) {
        if (DEFAULT_DATEPICKER == 'NP') {
          $this->db->where('rema_reqdatebs >=', $frmDate);
          $this->db->where('rema_reqdatebs <=', $toDate);
        } else {
          $this->db->where('rema_reqdatead >=', $frmDate);
          $this->db->where('rema_reqdatead <=', $toDate);
        }
      }
    }

    $this->db->select('DISTINCT(rm.rema_reqdatebs),rema_reqdatead');
    $this->db->from('rema_reqmaster rm');
    $demand_date_list = $this->db->get()->result();

    $demand = array();
    foreach ($demand_date_list as $key => $value) {
      $demand[$key]['name'] = "$value->rema_reqdatebs (B.S) - $value->rema_reqdatead (A.D)";
      $this->db->select('rd.rede_reqdetailid,rd.rede_remarks,rd.rede_remqty,rd.rede_qty,rm.rema_reqno,rm.rema_reqdatead,rm.rema_reqdatebs,rm.rema_username,rm.rema_fyear,rm.rema_reqby,it.itli_itemname,it.itli_itemnamenp,it.itli_itemcode,u.unit_unitname,,dp.dept_depname,dtfp.dept_depname as deptparent,loca_name as schoolname,maty_material');
      $this->db->from('rede_reqdetail rd');
      $this->db->join('rema_reqmaster rm', 'rm.rema_reqmasterid=rd.rede_reqmasterid', 'LEFT');
      $this->db->join('dept_department dp', 'dp.dept_depid=rm.rema_reqfromdepid', 'LEFT');
      $this->db->join('dept_department dtfp', 'dtfp.dept_depid=dp.dept_parentdepid', 'LEFT');
      $this->db->join('loca_location scf', 'rm.rema_school=scf.loca_locationid', 'LEFT');
      $this->db->join('maty_materialtype mt', 'mt.maty_materialtypeid=rm.rema_mattypeid', "LEFT");
      $this->db->join('eqty_equipmenttype t', 't.eqty_equipmenttypeid = rm.rema_reqtodepid', 'LEFT');
      $this->db->join('itli_itemslist it', 'it.itli_itemlistid = rd.rede_itemsid', 'LEFT');
      $this->db->join('unit_unit u', 'u.unit_unitid = it.itli_unitid', 'LEFT');
      $this->db->where('rm.rema_reqdatebs', $value->rema_reqdatebs);
      $demand[$key]['details'] = $this->db->get()->result();
    }
    $this->db->flush_cache();
    return $demand;
  }

  public function purchase_req_report_requested_by_detail_ku()
  {
    $locationid = $this->input->post('locationid');
    $searchDateType = $this->input->post('searchDateType');
    $frmDate = $this->input->post('frmDate');
    $toDate = $this->input->post('toDate');
    $rema_mattypeid = $this->input->post('rema_mattypeid');
    $schoolid = $this->input->post('school');
    $departmentid = $this->input->post('departmentid');
    $subdepid = $this->input->post('subdepid');
    $rema_reqby = $this->input->post('rema_reqby');
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
      if (!empty(($frmDate && $toDate))) {
        if (DEFAULT_DATEPICKER == 'NP') {
          $this->db->where('rema_reqdatebs >=', $frmDate);
          $this->db->where('rema_reqdatebs <=', $toDate);
        } else {
          $this->db->where('rema_reqdatead >=', $frmDate);
          $this->db->where('rema_reqdatead <=', $toDate);
        }
      }
    }

    if (!empty($this->mattypeid)) {
      $this->db->where('rema_mattypeid', $this->mattypeid);
    } else {
      if (!empty($rema_mattypeid)) {
        $this->db->where('rema_mattypeid', $rema_mattypeid);
      }
    }


    if ($this->location_ismain == 'Y') {
      if (!empty($locationid)) {
        $this->db->where('rema_locationid', $locationid);
      }
    } else {
      $this->db->where('rema_locationid', $this->locationid);
    }

    if (!empty($schoolid)) {
      $this->db->where('rema_school', $schoolid);
    }

    if (!empty($departmentid)) {
      if (!empty($subdepid)) {
        $this->db->where("rema_reqfromdepid =" . $subdepid . " ");
      } else {
        if (!empty($subdeparray)) {
          $this->db->where_in("rema_reqfromdepid", $subdeparray);
        } else {
          $this->db->where("rema_reqfromdepid =" . $departmentid . " ");
        }
      }
    }
    $this->db->stop_cache();

    if (!empty($rema_reqby)) {
      $this->db->where('rema_reqby', $rema_reqby);
    }


    $this->db->select('DISTINCT(rm.rema_reqby)');
    $this->db->from('rema_reqmaster rm');
    $reqby_list = $this->db->get()->result();

    $reqby = array();
    foreach ($reqby_list as $key => $value) {
      $reqby[$key]['name'] = ucfirst($value->rema_reqby);
      $this->db->select('rd.rede_reqdetailid,rd.rede_remarks,rd.rede_remqty,rd.rede_qty,rm.rema_reqno,rm.rema_reqdatead,rm.rema_reqdatebs,rm.rema_username,rm.rema_fyear,rm.rema_reqby,it.itli_itemname,it.itli_itemnamenp,it.itli_itemcode,u.unit_unitname,,dp.dept_depname,dtfp.dept_depname as deptparent,loca_name as schoolname,maty_material');
      $this->db->from('rede_reqdetail rd');
      $this->db->join('rema_reqmaster rm', 'rm.rema_reqmasterid=rd.rede_reqmasterid', 'LEFT');
      $this->db->join('dept_department dp', 'dp.dept_depid=rm.rema_reqfromdepid', 'LEFT');
      $this->db->join('dept_department dtfp', 'dtfp.dept_depid=dp.dept_parentdepid', 'LEFT');
      $this->db->join('loca_location scf', 'rm.rema_school=scf.loca_locationid', 'LEFT');
      $this->db->join('maty_materialtype mt', 'mt.maty_materialtypeid=rm.rema_mattypeid', "LEFT");
      $this->db->join('eqty_equipmenttype t', 't.eqty_equipmenttypeid = rm.rema_reqtodepid', 'LEFT');
      $this->db->join('itli_itemslist it', 'it.itli_itemlistid = rd.rede_itemsid', 'LEFT');
      $this->db->join('unit_unit u', 'u.unit_unitid = it.itli_unitid', 'LEFT');
      $this->db->where('rm.rema_reqby', $value->rema_reqby);
      $reqby[$key]['details'] = $this->db->get()->result();
    }
    $this->db->flush_cache();
    return $reqby;
  }
}
