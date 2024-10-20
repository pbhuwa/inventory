<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Issue_report_mdl extends CI_Model
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
    $this->locationid=$this->session->userdata(LOCATION_ID);
    $this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
    $this->orgid=$this->session->userdata(ORG_ID);
    
  }
  
  public function get_issue_report_summary()
  {
    
    $locationid = $this->input->post('locationid');
    $searchDateType = $this->input->post('searchDateType');
    $frmDate = $this->input->post('frmDate');
    $toDate = $this->input->post('toDate');
    $sama_mattypeid = $this->input->post('sama_mattypeid');
    $categoryid=$this->input->post('categoryid');
    $schoolid = $this->input->post('school');
    $departmentid = $this->input->post('departmentid');
    $subdepid = $this->input->post('subdepid');
    $sama_receivedby = $this->input->post('sama_receivedby');
    $itemid=$this->input->post('itemid');
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
      if(!empty(($frmDate && $toDate)))
      {
        if(DEFAULT_DATEPICKER == 'NP'){
            $this->db->where('sama_billdatebs >=',$frmDate);
            $this->db->where('sama_billdatebs <=',$toDate);    
        }else{
            $this->db->where('sama_billdatead >=',$frmDate);
            $this->db->where('sama_billdatead <=',$toDate);
        }
      } 
    }

    if (!empty($this->mattypeid)) {
      $this->db->where('il.itli_materialtypeid', $this->mattypeid);
    } else {
      if (!empty($sama_mattypeid)) {
        $this->db->where('il.itli_materialtypeid', $sama_mattypeid);
      }
    }

    if (!empty($sama_receivedby)) {
        // $staffid = explode(',',$sama_receivedby);
        // if($staffid[0] != '1') 
        $this->db->where('sm.sama_receivedby', $sama_receivedby);
    }
      
    if ($this->location_ismain == 'Y') {
      if (!empty($locationid)) {
          $this->db->where('sm.sama_locationid', $locationid);
      }
    } else {
        $this->db->where('sm.sama_locationid', $this->locationid);
    }

    if (!empty($departmentid)) {
      if (!empty($subdepid)) {
          $this->db->where("sama_depid =" . $subdepid . " ");
      } else {
          if (!empty($subdeparray)) {
              $this->db->where_in("sama_depid", $subdeparray);
          } else {
              $this->db->where("sama_depid =" . $departmentid . " ");
          }
      }
    }

    if (!empty($schoolid)) {
      $this->db->where('rm.rema_school', $schoolid);
    }
    if(!empty($itemid)){
      $this->db->where('sde.sade_itemsid',$itemid);
    }
    if(!empty($categoryid)){
      $this->db->where('il.itli_catid',$categoryid);
    }

  $this->db->stop_cache();

  $this->db->select("sama_salemasterid,totcnt,
  totalamt,sama_depid,sama_billdatead, sama_billdatebs, sama_duedatead, sama_duedatebs, sama_soldby, sama_discount, sama_taxrate, sama_vat, sama_totalamount, sama_username, sama_lastchangedate, sama_orderno, sama_challanno, sama_billno, sama_payment, sama_status, sama_fyear, sama_st, sama_stdatebs, sama_stdatead, sama_stdepid, sama_stusername, sama_stshiftid, dp.dept_depname,dtfp.dept_depname as parent_dep, sama_depname, sama_invoiceno, sama_billtime, sama_receivedby, sama_manualbillno, sama_requisitionno,sama_postdatebs,sama_postdatead,sama_posttime,mt.maty_material,scf.loca_name schoolname");
  $this->db->from('sama_salemaster sm');
  $this->db->join('maty_materialtype mt','mt.maty_materialtypeid=sm.sama_mattypeid','LEFT');
  $this->db->join('vw_issue_summary sd','sd.sade_salemasterid =sm.sama_salemasterid','LEFT');
  $this->db->join('sade_saledetail sde','sm.sama_salemasterid = sde.sade_salemasterid','LEFT');
   $this->db->join('itli_itemslist il','il.itli_itemlistid=sde.sade_itemsid','LEFT');
  $this->db->join('rede_reqdetail rd','rd.rede_reqdetailid = sde.sade_reqdetailid','LEFT');
  $this->db->join('rema_reqmaster rm','rm.rema_reqmasterid = rd.rede_reqmasterid','LEFT');
  $this->db->join('loca_location scf', 'rm.rema_school=scf.loca_locationid', 'LEFT');
  $this->db->join('dept_department dp', 'dp.dept_depid=sm.sama_depid', 'LEFT');
  $this->db->join('dept_department dtfp', 'dtfp.dept_depid=dp.dept_parentdepid', 'LEFT');
  $this->db->where('sama_st !=','C');
  $this->db->group_by('sama_salemasterid');

  $data['default_summary'] = $this->db->get()->result();
  
  // if ($rpt_wise == 'default'){
  // $this->db->flush_cache();
  // unset($array);
  // $array['default_summary'] = $data['default_summary'];
  // return $array;
  // }

 $this->db->select("il.itli_catid,ec.eqca_category,COUNT(*) as cnt,SUM(sade_curqty) as qty,SUM(sade_unitrate) as rate,SUM(IFNULL(sade_curqty,0)*sade_unitrate) as amount");
  $this->db->from('sama_salemaster sm');
  $this->db->join('sade_saledetail sde','sm.sama_salemasterid = sde.sade_salemasterid','LEFT');
  $this->db->join('rede_reqdetail rd','rd.rede_reqdetailid =  sde.sade_reqdetailid','LEFT');
  $this->db->join('rema_reqmaster rm','rm.rema_reqmasterid = rd.rede_reqmasterid','LEFT');
  $this->db->join('itli_itemslist il','il.itli_itemlistid=sde.sade_itemsid','LEFT');
  $this->db->join('eqca_equipmentcategory  ec','ec.eqca_equipmentcategoryid=il.itli_catid','LEFT');

  $this->db->where('sama_st !=','C');
  $this->db->group_by('il.itli_catid');
  $this->db->order_by('eqca_category','ASC');
  $data['category_wise'] = $this->db->get()->result(); 
  if ($rpt_wise == 'category_wise') {
    $this->db->flush_cache();
    unset($array);
    $array['category_wise'] = $data['category_wise'];
    return $array;
  }

  $this->db->select("loca_name,dtfp.dept_depname as parent_dep,dp.dept_depname as departmentname,COUNT(*) as cnt,SUM(sade_curqty) as qty,SUM(sade_unitrate) as rate,SUM(IFNULL(sade_curqty,0)*sade_unitrate) as amount");
  $this->db->from('sama_salemaster sm');
  $this->db->join('maty_materialtype mt','mt.maty_materialtypeid=sm.sama_mattypeid','LEFT');
  $this->db->join('sade_saledetail sde','sm.sama_salemasterid = sde.sade_salemasterid','LEFT');
   $this->db->join('itli_itemslist il','il.itli_itemlistid=sde.sade_itemsid','LEFT');
  $this->db->join('rede_reqdetail rd','rd.rede_reqdetailid = sde.sade_reqdetailid','LEFT');
  $this->db->join('rema_reqmaster rm','rm.rema_reqmasterid = rd.rede_reqmasterid','LEFT');
  $this->db->join('loca_location scf', 'rm.rema_school=scf.loca_locationid', 'LEFT');
  $this->db->join('dept_department dp', 'dp.dept_depid=sm.sama_depid', 'LEFT');
  $this->db->join('dept_department dtfp', 'dtfp.dept_depid=dp.dept_parentdepid', 'LEFT');
  $this->db->where('sama_st !=','C');
  $this->db->group_by('sm.sama_depid');

  $data['department'] = $this->db->get()->result();
  if ($rpt_wise == 'department') {
    $this->db->flush_cache();
    unset($array);
    $array['department'] = $data['department'];
    return $array;
  }

  $this->db->select("sama_invoiceno,sama_billdatead,sama_billdatebs,loca_name,dtfp.dept_depname as parent_dep,dp.dept_depname as departmentname,COUNT(*) as cnt,SUM(sade_curqty) as qty,SUM(sade_unitrate) as rate,SUM(IFNULL(sade_curqty,0)*sade_unitrate) as amount");
  $this->db->from('sama_salemaster sm');
    $this->db->join('sade_saledetail sde','sm.sama_salemasterid = sde.sade_salemasterid','LEFT');
  $this->db->join('maty_materialtype mt','mt.maty_materialtypeid=sm.sama_mattypeid','LEFT');
   $this->db->join('itli_itemslist il','il.itli_itemlistid=sde.sade_itemsid','LEFT');
  $this->db->join('rede_reqdetail rd','rd.rede_reqdetailid = sde.sade_reqdetailid','LEFT');
  $this->db->join('rema_reqmaster rm','rm.rema_reqmasterid = rd.rede_reqmasterid','LEFT');
  $this->db->join('loca_location scf', 'rm.rema_school=scf.loca_locationid', 'LEFT');
  $this->db->join('dept_department dp', 'dp.dept_depid=sm.sama_depid', 'LEFT');
  $this->db->join('dept_department dtfp', 'dtfp.dept_depid=dp.dept_parentdepid', 'LEFT');
  $this->db->where('sama_st !=','C');
  $this->db->group_by('sm.sama_salemasterid');

  $data['issue_no'] = $this->db->get()->result();
  if ($rpt_wise == 'issue_no') {
    $this->db->flush_cache();
    unset($array);
    $array['issue_no'] = $data['issue_no'];
    return $array;
  }

  $this->db->select('maty_material,COUNT(*) as cnt,SUM(sade_curqty) as qty,SUM(sade_unitrate) as rate,SUM(IFNULL(sade_curqty,0)*sade_unitrate) as amount');
  $this->db->from('sama_salemaster sm');
  $this->db->join('sade_saledetail sde','sm.sama_salemasterid = sde.sade_salemasterid','LEFT');
  $this->db->join('itli_itemslist il','il.itli_itemlistid=sde.sade_itemsid','LEFT');
  $this->db->join('maty_materialtype mt','mt.maty_materialtypeid=il.itli_materialtypeid','LEFT');
  $this->db->join('rede_reqdetail rd','rd.rede_reqdetailid = sde.sade_reqdetailid','LEFT');
  $this->db->join('rema_reqmaster rm','rm.rema_reqmasterid = rd.rede_reqmasterid','LEFT');
  $this->db->join('loca_location scf', 'rm.rema_school=scf.loca_locationid', 'LEFT');
  $this->db->join('dept_department dp', 'dp.dept_depid=sm.sama_depid', 'LEFT');
  $this->db->join('dept_department dtfp', 'dtfp.dept_depid=dp.dept_parentdepid', 'LEFT');
  $this->db->where('sama_st !=','C');
  $this->db->group_by('il.itli_materialtypeid');
  $data['material_type'] = $this->db->get()->result();
  if ($rpt_wise == 'material_type') {
    $this->db->flush_cache();
    unset($array);
    $array['material_type'] = $data['material_type'];
    return $array;
  }

  $this->db->select("rema_reqdatead,rema_reqdatebs,COUNT(*) as cnt,SUM(sade_curqty) as qty,SUM(sade_unitrate) as rate,SUM(IFNULL(sade_curqty,0)*sade_unitrate) as amount");
  $this->db->from('sama_salemaster sm');
   $this->db->join('sade_saledetail sde','sm.sama_salemasterid = sde.sade_salemasterid','LEFT');
   $this->db->join('itli_itemslist il','il.itli_itemlistid=sde.sade_itemsid','LEFT');
  $this->db->join('maty_materialtype mt','mt.maty_materialtypeid=il.itli_materialtypeid','LEFT');
  $this->db->join('rede_reqdetail rd','rd.rede_reqdetailid = sde.sade_reqdetailid','LEFT');
  $this->db->join('rema_reqmaster rm','rm.rema_reqmasterid = rd.rede_reqmasterid','LEFT');
  $this->db->join('loca_location scf', 'rm.rema_school=scf.loca_locationid', 'LEFT');
  $this->db->join('dept_department dp', 'dp.dept_depid=sm.sama_depid', 'LEFT');
  $this->db->join('dept_department dtfp', 'dtfp.dept_depid=dp.dept_parentdepid', 'LEFT');
  $this->db->where('sama_st !=','C');
  $this->db->group_by('rema_reqdatebs');
  $this->db->order_by('rema_reqdatebs','ASC');
  $data['demand_date'] = $this->db->get()->result(); 
  if ($rpt_wise == 'demand_date') {
    $this->db->flush_cache();
    unset($array);
    $array['demand_date'] = $data['demand_date'];
    return $array;
  }

  $this->db->select("sm.sama_billdatebs,sama_billdatead,COUNT(*) as cnt,SUM(sade_curqty) as qty,SUM(IFNULL(sade_curqty,0)*sade_unitrate) as amount");
  $this->db->from('sama_salemaster sm');
  $this->db->join('sade_saledetail sde','sm.sama_salemasterid = sde.sade_salemasterid','LEFT');
  $this->db->join('rede_reqdetail rd','rd.rede_reqdetailid = sde.sade_reqdetailid','LEFT');
  $this->db->join('rema_reqmaster rm','rm.rema_reqmasterid = rd.rede_reqmasterid','LEFT');
 $this->db->join('itli_itemslist il','il.itli_itemlistid=sde.sade_itemsid','LEFT');
  $this->db->join('maty_materialtype mt','mt.maty_materialtypeid=il.itli_materialtypeid','LEFT');
  $this->db->join('dept_department dp', 'dp.dept_depid=sm.sama_depid', 'LEFT');
  $this->db->join('dept_department dtfp', 'dtfp.dept_depid=dp.dept_parentdepid', 'LEFT');
  $this->db->where('sama_st !=','C');
  $this->db->where('sama_status =','O');
  $this->db->group_by('sama_billdatebs');
  $this->db->order_by('sama_billdatebs','ASC');
  $data['issue_date'] = $this->db->get()->result(); 
  if ($rpt_wise == 'issue_date') {
    $this->db->flush_cache();
    unset($array);
    $array['issue_date'] = $data['issue_date'];
    return $array;
  }

  $this->db->select("sde.sade_itemsid,il.itli_itemcode,il.itli_itemname, COUNT(*) as cnt,SUM(sade_curqty) as qty,SUM(sade_unitrate) as rate,SUM(IFNULL(sade_curqty,0)*sade_unitrate) as amount");
  $this->db->from('sama_salemaster sm');
  $this->db->join('sade_saledetail sde','sm.sama_salemasterid = sde.sade_salemasterid','LEFT');
  $this->db->join('rede_reqdetail rd','rd.rede_reqdetailid = sde.sade_reqdetailid','LEFT');
  $this->db->join('rema_reqmaster rm','rm.rema_reqmasterid = rd.rede_reqmasterid','LEFT');
  $this->db->join('itli_itemslist il','il.itli_itemlistid=sde.sade_itemsid','LEFT');
  $this->db->join('maty_materialtype mt','mt.maty_materialtypeid=il.itli_materialtypeid','LEFT');
  $this->db->join('eqca_equipmentcategory  ec','ec.eqca_equipmentcategoryid=il.itli_catid','LEFT');
  $this->db->where('sama_st !=','C');
  $this->db->group_by('sde.sade_itemsid');
  $this->db->order_by('il.itli_itemname','ASC');
  $data['item_wise'] = $this->db->get()->result(); 
  if ($rpt_wise == 'item_wise') {
    $this->db->flush_cache();
    unset($array);
    $array['item_wise'] = $data['item_wise'];
    return $array;
  }
  
  $this->db->select("rema_reqby,COUNT(*) as cnt,SUM(sade_curqty) as qty,SUM(sade_unitrate) as rate,SUM(IFNULL(sade_curqty,0)*sade_unitrate) as amount");
    $this->db->from('sama_salemaster sm');
    $this->db->join('sade_saledetail sde','sm.sama_salemasterid = sde.sade_salemasterid','LEFT');
    $this->db->join('rede_reqdetail rd','rd.rede_reqdetailid = sde.sade_reqdetailid','LEFT');
    $this->db->join('rema_reqmaster rm','rm.rema_reqmasterid = rd.rede_reqmasterid','LEFT');
    $this->db->join('itli_itemslist il','il.itli_itemlistid=sde.sade_itemsid','LEFT');
  $this->db->join('maty_materialtype mt','mt.maty_materialtypeid=il.itli_materialtypeid','LEFT');
    $this->db->join('loca_location scf', 'rm.rema_school=scf.loca_locationid', 'LEFT');
    $this->db->join('dept_department dp', 'dp.dept_depid=sm.sama_depid', 'LEFT');
    $this->db->join('dept_department dtfp', 'dtfp.dept_depid=dp.dept_parentdepid', 'LEFT');
    $this->db->where('sama_st !=','C');
    $this->db->group_by('rema_reqby');
    $this->db->order_by('rema_reqby','ASC');
    $data['received_by'] = $this->db->get()->result();
    if ($rpt_wise == 'received_by') {
      $this->db->flush_cache();
      unset($array);
      $array['received_by'] = $data['received_by'];
      return $array;
    }

 $this->db->select("sama_salemasterid,totcnt,
  totalamt,sama_depid,sama_billdatead, sama_billdatebs, sama_duedatead, sama_duedatebs, sama_soldby, sama_discount, sama_taxrate, sama_vat, sama_totalamount, sama_username, sama_lastchangedate, sama_orderno, sama_challanno, sama_billno, sama_payment, sama_status, sama_fyear, sama_st, sama_stdatebs, sama_stdatead, sama_stdepid, sama_stusername, sama_stshiftid, dp.dept_depname,dtfp.dept_depname as parent_dep, sama_depname, sama_invoiceno, sama_billtime, sama_receivedby, sama_manualbillno, sama_requisitionno,sama_postdatebs,sama_postdatead,sama_posttime,mt.maty_material");
  $this->db->from('sama_salemaster sm');
  $this->db->join('maty_materialtype mt','mt.maty_materialtypeid=sm.sama_mattypeid','LEFT');
  $this->db->join('vw_issue_summary sd','sd.sade_salemasterid =sm.sama_salemasterid','LEFT');
  $this->db->join('sade_saledetail sde','sm.sama_salemasterid = sde.sade_salemasterid','LEFT');
   $this->db->join('itli_itemslist il','il.itli_itemlistid=sde.sade_itemsid','LEFT');
  $this->db->join('rede_reqdetail rd','rd.rede_reqdetailid = sde.sade_reqdetailid','LEFT');
  $this->db->join('rema_reqmaster rm','rm.rema_reqmasterid = rd.rede_reqmasterid','LEFT');
  $this->db->join('loca_location scf', 'rm.rema_school=scf.loca_locationid', 'LEFT');
  $this->db->join('dept_department dp', 'dp.dept_depid=sm.sama_depid', 'LEFT');
  $this->db->join('dept_department dtfp', 'dtfp.dept_depid=dp.dept_parentdepid', 'LEFT');
  $this->db->where('sama_st !=','C');
  $this->db->where('sama_ishandover','Y');
  $this->db->group_by('sama_salemasterid');
  $this->db->order_by('sama_salemasterid','ASC');

    $data['handover_issue'] = $this->db->get()->result();
    if ($rpt_wise == 'handover_issue') {
      $this->db->flush_cache();
      unset($array);
      $array['handover_issue'] = $data['handover_issue'];
      return $array;
    }

  $this->db->flush_cache();
  return $data;

  }

  public function get_issue_report_detail()
  {
    $locationid = $this->input->post('locationid');
    $searchDateType = $this->input->post('searchDateType');
    $frmDate = $this->input->post('frmDate');
    $toDate = $this->input->post('toDate');
    $sama_mattypeid = $this->input->post('sama_mattypeid');
    $schoolid = $this->input->post('school');
    $departmentid = $this->input->post('departmentid');
    $subdepid = $this->input->post('subdepid');
    $sama_receivedby = $this->input->post('sama_receivedby');
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
      if(!empty(($frmDate && $toDate)))
      {
        if(DEFAULT_DATEPICKER == 'NP'){
            $this->db->where('sama_billdatebs >=',$frmDate);
            $this->db->where('sama_billdatebs <=',$toDate);    
        }else{
            $this->db->where('sama_billdatead >=',$frmDate);
            $this->db->where('sama_billdatead <=',$toDate);
        }
      } 
    }

    if (!empty($this->mattypeid)) {
      $this->db->where('rn.sama_mattypeid', $this->mattypeid);
    } else {
      if (!empty($sama_mattypeid)) {
        $this->db->where('rn.sama_mattypeid', $sama_mattypeid);
      }
    }

    if (!empty($sama_receivedby)) {
        // $staffid = explode(',',$sama_receivedby);
        // if($staffid[0] != '1') 
          $this->db->where('rn.sama_receivedby', $sama_receivedby);
    }
     
    if ($this->location_ismain == 'Y') {
      if (!empty($locationid)) {
          $this->db->where('rn.sama_locationid', $locationid);
      }
    } else {
        $this->db->where('rn.sama_locationid', $this->locationid);
    }

    if (!empty($departmentid)) {
      if (!empty($subdepid)) {
          $this->db->where("sama_depid =" . $subdepid . " ");
      } else {
          if (!empty($subdeparray)) {
              $this->db->where_in("sama_depid", $subdeparray);
          } else {
              $this->db->where("sama_depid =" . $departmentid . " ");
          }
      }
    }

    if (!empty($schoolid)) {
      $this->db->where('rm.rema_school', $schoolid);
    }
    $this->db->stop_cache();
    $this->db->select('rn.sama_st,rn.sama_billtime,rn.sama_requisitionno,sd.sade_curqty as sade_qty, sd.sade_unitrate,sd.sade_remarks,rn.sama_salemasterid,rn.sama_invoiceno,rn.sama_billdatebs,rn.sama_billdatead,dp.dept_depname sama_depname,rn.sama_totalamount,rn.sama_username,rn.sama_receivedby,(sd.sade_curqty*sd.sade_unitrate) as issueamt,eq.itli_itemname,eq.itli_itemnamenp,eq.itli_itemcode,eq.itli_itemlistid,dtfp.dept_depname parent_dep,scf.loca_name schoolname');
    $this->db->from('sade_saledetail sd');
    $this->db->join('sama_salemaster rn','rn.sama_salemasterid = sd.sade_salemasterid','LEFT');
    $this->db->join('rede_reqdetail rd','rd.rede_reqdetailid = sd.sade_reqdetailid','LEFT');
    $this->db->join('rema_reqmaster rm','rm.rema_reqmasterid = rd.rede_reqmasterid','LEFT');
    $this->db->join('loca_location scf', 'rm.rema_school=scf.loca_locationid', 'LEFT');
    $this->db->join('dept_department dp', 'dp.dept_depid=rn.sama_depid', 'LEFT');
    $this->db->join('dept_department dtfp', 'dtfp.dept_depid=dp.dept_parentdepid', 'LEFT');
    $this->db->join('itli_itemslist eq','eq.itli_itemlistid = sd.sade_itemsid','LEFT');
    $this->db->where('sama_st !=','C');
    $data = $this->db->get()->result();
    $this->db->flush_cache();
    return $data;
  }

  public function issue_report_department_detail()
  {
    $locationid = $this->input->post('locationid');
    $searchDateType = $this->input->post('searchDateType');
    $frmDate = $this->input->post('frmDate');
    $toDate = $this->input->post('toDate');
    $sama_mattypeid = $this->input->post('sama_mattypeid');
     $categoryid=$this->input->post('categoryid');

    $schoolid = $this->input->post('school');
    $departmentid = $this->input->post('departmentid');
    $subdepid = $this->input->post('subdepid');
    $sama_receivedby = $this->input->post('sama_receivedby');
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
      if(!empty(($frmDate && $toDate)))
      {
        if(DEFAULT_DATEPICKER == 'NP'){
            $this->db->where('sama_billdatebs >=',$frmDate);
            $this->db->where('sama_billdatebs <=',$toDate);    
        }else{
            $this->db->where('sama_billdatead >=',$frmDate);
            $this->db->where('sama_billdatead <=',$toDate);
        }
      } 
    }

    if (!empty($this->mattypeid)) {
      $this->db->where('sm.sama_mattypeid', $this->mattypeid);
    } else {
      if (!empty($sama_mattypeid)) {
        $this->db->where('sm.sama_mattypeid', $sama_mattypeid);
      }
    }

    if (!empty($sama_receivedby)) {
        // $staffid = explode(',',$sama_receivedby);
        // if($staffid[0] != '1') 
          $this->db->where('sm.sama_receivedby', $sama_receivedby);
    }
      
    if ($this->location_ismain == 'Y') {
      if (!empty($locationid)) {
          $this->db->where('sm.sama_locationid', $locationid);
      }
    } else {
        $this->db->where('sm.sama_locationid', $this->locationid);
    }

    if (!empty($schoolid)) {
      $this->db->where('rm.rema_school', $schoolid);
    }

     if(!empty($categoryid)){
      $this->db->where('il.itli_catid',$categoryid);
    }
    
    $this->db->stop_cache();

    if (!empty($departmentid)) {
      if (!empty($subdepid)) {
          $this->db->where("sama_depid =" . $subdepid . " ");
      } else {
          if (!empty($subdeparray)) {
              $this->db->where_in("sama_depid", $subdeparray);
          } else {
              $this->db->where("sama_depid =" . $departmentid . " ");
          }
      }
    }

   $this->db->select('DISTINCT(sm.sama_depid), de.dept_depid, de.dept_depname, dtfp.dept_depname fromdepparent');
    $this->db->from('sama_salemaster sm');
    $this->db->join('sade_saledetail sd','sm.sama_salemasterid = sd.sade_salemasterid','LEFT');
    $this->db->join('itli_itemslist il','il.itli_itemlistid = sd.sade_itemsid','LEFT');
    $this->db->join('rede_reqdetail rd','rd.rede_reqdetailid = sd.sade_reqdetailid','LEFT');
    $this->db->join('rema_reqmaster rm','rm.rema_reqmasterid = rd.rede_reqmasterid','LEFT');
    $this->db->join('loca_location scf', 'rm.rema_school=scf.loca_locationid', 'LEFT');
    $this->db->join('dept_department de', 'sm.sama_depid=de.dept_depid', 'LEFT');
    $this->db->join('dept_department dtfp', 'dtfp.dept_depid=de.dept_parentdepid', 'LEFT');
    $this->db->where('sama_depid IS NOT NULL');
    $this->db->where('sama_st !=','C');
    $this->db->order_by('dept_depname','ASC');
    $department_list = $this->db->get()->result();
    // print_r($department_list);
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
 
    $this->db->select('sm.sama_st,sm.sama_billtime,sm.sama_requisitionno,sd.sade_curqty as sade_qty,sd.sade_unitrate,sd.sade_remarks,sm.sama_salemasterid,sm.sama_invoiceno,sm.sama_billdatebs,sm.sama_billdatead,dp.dept_depname sama_depname,sm.sama_totalamount,sm.sama_username,sm.sama_receivedby,(sd.sade_curqty*sd.sade_unitrate) as issueamt,il.itli_itemname,il.itli_itemnamenp,il.itli_itemcode,il.itli_itemlistid,dtfp.dept_depname parent_dep,scf.loca_name schoolname');
    $this->db->from('sade_saledetail sd');
    $this->db->join('sama_salemaster sm','sm.sama_salemasterid = sd.sade_salemasterid','LEFT');
    $this->db->join('rede_reqdetail rd','rd.rede_reqdetailid = sd.sade_reqdetailid','LEFT');
    $this->db->join('rema_reqmaster rm','rm.rema_reqmasterid = rd.rede_reqmasterid','LEFT');
    $this->db->join('loca_location scf', 'rm.rema_school = scf.loca_locationid', 'LEFT');
    $this->db->join('dept_department dp', 'dp.dept_depid=sm.sama_depid', 'LEFT');
    $this->db->join('dept_department dtfp', 'dtfp.dept_depid=dp.dept_parentdepid', 'LEFT');
   $this->db->join('itli_itemslist il','il.itli_itemlistid = sd.sade_itemsid','LEFT');
    $this->db->where('sama_st !=','C');
    $this->db->where('sama_depid',$item->sama_depid);
    $department[$key]['department_details'] = $this->db->get()->result();
    // echo $this->db->last_query();
    // die();
    }
    }

    $this->db->flush_cache();   
    return $department;
  }

  public function issue_report_material_type_detail()
  {
    $locationid = $this->input->post('locationid');
    $searchDateType = $this->input->post('searchDateType');
    $frmDate = $this->input->post('frmDate');
    $toDate = $this->input->post('toDate');
    $sama_mattypeid = $this->input->post('sama_mattypeid');
      $categoryid=$this->input->post('categoryid');
  
    $schoolid = $this->input->post('school');
    $departmentid = $this->input->post('departmentid');
    $subdepid = $this->input->post('subdepid');
    $sama_receivedby = $this->input->post('sama_receivedby');
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
      if(!empty(($frmDate && $toDate)))
      {
        if(DEFAULT_DATEPICKER == 'NP'){
            $this->db->where('sama_billdatebs >=',$frmDate);
            $this->db->where('sama_billdatebs <=',$toDate);    
        }else{
            $this->db->where('sama_billdatead >=',$frmDate);
            $this->db->where('sama_billdatead <=',$toDate);
        }
      } 
    }

    if (!empty($sama_receivedby)) {
        // $staffid = explode(',',$sama_receivedby);
        // if($staffid[0] != '1') 
          $this->db->where('sm.sama_receivedby', $sama_receivedby);
    }
      
    if ($this->location_ismain == 'Y') {
      if (!empty($locationid)) {
          $this->db->where('sm.sama_locationid', $locationid);
      }
    } else {
        $this->db->where('sm.sama_locationid', $this->locationid);
    }

    if (!empty($schoolid)) {
      $this->db->where('rm.rema_school', $schoolid);
    }
    
    if (!empty($departmentid)) {
      if (!empty($subdepid)) {
          $this->db->where("sama_depid =" . $subdepid . " ");
      } else {
          if (!empty($subdeparray)) {
              $this->db->where_in("sama_depid", $subdeparray);
          } else {
              $this->db->where("sama_depid =" . $departmentid . " ");
          }
      }
    }
    $this->db->stop_cache();

    if (!empty($this->mattypeid)) {
      $this->db->where('sm.sama_mattypeid', $this->mattypeid);
    } else {
      if (!empty($sama_mattypeid)) {
        $this->db->where('sm.sama_mattypeid', $sama_mattypeid);
      }
    }
    if(!empty($categoryid)){
      $this->db->where('il.itli_catid',$categoryid);
    }

   $this->db->select('DISTINCT(il.itli_materialtypeid) sama_mattypeid, maty_material');
    $this->db->from('sama_salemaster sm');
    $this->db->join('sade_saledetail sd','sm.sama_salemasterid = sd.sade_salemasterid','LEFT');
    $this->db->join('itli_itemslist il','il.itli_itemlistid = sd.sade_itemsid','LEFT');
    $this->db->join('maty_materialtype mt','mt.maty_materialtypeid=il.itli_materialtypeid','LEF');
    $this->db->join('rede_reqdetail rd','rd.rede_reqdetailid = sd.sade_reqdetailid','LEFT');
    $this->db->join('rema_reqmaster rm','rm.rema_reqmasterid = rd.rede_reqmasterid','LEFT');
    $this->db->join('loca_location scf', 'rm.rema_school=scf.loca_locationid', 'LEFT');
    $this->db->join('dept_department de', 'sm.sama_depid=de.dept_depid', 'LEFT');
    $this->db->join('dept_department dtfp', 'dtfp.dept_depid=de.dept_parentdepid', 'LEFT');
    $this->db->where('sama_st !=','C');
    $this->db->order_by('maty_material','ASC');
    $material_list = $this->db->get()->result();
    // echo "<pre>";
    // print_r($material_list);
    // die();

    $material = array();
    if (count($material_list)) {
    foreach ($material_list as $key => $item) {
               
    $material[$key]['material_name'] = $item->maty_material;
 
    $this->db->select('sm.sama_st,sm.sama_billtime,sm.sama_requisitionno,sd.sade_curqty as sade_qty,sd.sade_unitrate,sd.sade_remarks,sm.sama_salemasterid,sm.sama_invoiceno,sm.sama_billdatebs,sm.sama_billdatead,dp.dept_depname sama_depname,sm.sama_totalamount,sm.sama_username,sm.sama_receivedby,(sd.sade_curqty*sd.sade_unitrate) as issueamt,il.itli_itemname,il.itli_itemnamenp,il.itli_itemcode,il.itli_itemlistid,dtfp.dept_depname parent_dep,scf.loca_name schoolname');
    $this->db->from('sade_saledetail sd');
    $this->db->join('sama_salemaster sm','sm.sama_salemasterid = sd.sade_salemasterid','LEFT');
    $this->db->join('rede_reqdetail rd','rd.rede_reqdetailid = sd.sade_reqdetailid','LEFT');
    $this->db->join('rema_reqmaster rm','rm.rema_reqmasterid = rd.rede_reqmasterid','LEFT');
    $this->db->join('loca_location scf', 'rm.rema_school = scf.loca_locationid', 'LEFT');
    $this->db->join('dept_department dp', 'dp.dept_depid=sm.sama_depid', 'LEFT');
    $this->db->join('dept_department dtfp', 'dtfp.dept_depid=dp.dept_parentdepid', 'LEFT');
    $this->db->join('itli_itemslist il','il.itli_itemlistid = sd.sade_itemsid','LEFT');
    $this->db->where('il.itli_materialtypeid',$item->sama_mattypeid);
    $this->db->where('sama_st !=','C');

    $material[$key]['material_details'] = $this->db->get()->result();
    }
    }

    $this->db->flush_cache();   
    return $material;

  }

  public function issue_report_demand_date_detail()
  {
    $locationid = $this->input->post('locationid');
    $searchDateType = $this->input->post('searchDateType');
    $frmDate = $this->input->post('frmDate');
    $toDate = $this->input->post('toDate');
    $sama_mattypeid = $this->input->post('sama_mattypeid');
    $schoolid = $this->input->post('school');
    $departmentid = $this->input->post('departmentid');
    $subdepid = $this->input->post('subdepid');
    $sama_receivedby = $this->input->post('sama_receivedby');
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
      if(!empty(($frmDate && $toDate)))
      {
        if(DEFAULT_DATEPICKER == 'NP'){
            $this->db->where('sama_billdatebs >=',$frmDate);
            $this->db->where('sama_billdatebs <=',$toDate);    
        }else{
            $this->db->where('sama_billdatead >=',$frmDate);
            $this->db->where('sama_billdatead <=',$toDate);
        }
      } 
    }

    if (!empty($this->mattypeid)) {
      $this->db->where('sm.sama_mattypeid', $this->mattypeid);
    } else {
      if (!empty($sama_mattypeid)) {
        $this->db->where('sm.sama_mattypeid', $sama_mattypeid);
      }
    }

    if (!empty($sama_receivedby)) {
        // $staffid = explode(',',$sama_receivedby);
        // if($staffid[0] != '1') 
          $this->db->where('sm.sama_receivedby', $sama_receivedby);
    }
      
    if ($this->location_ismain == 'Y') {
      if (!empty($locationid)) {
          $this->db->where('sm.sama_locationid', $locationid);
      }
    } else {
        $this->db->where('sm.sama_locationid', $this->locationid);
    }

    if (!empty($schoolid)) {
      $this->db->where('rm.rema_school', $schoolid);
    }
    
    if (!empty($departmentid)) {
      if (!empty($subdepid)) {
          $this->db->where("sama_depid =" . $subdepid . " ");
      } else {
          if (!empty($subdeparray)) {
              $this->db->where_in("sama_depid", $subdeparray);
          } else {
              $this->db->where("sama_depid =" . $departmentid . " ");
          }
      }
    }
    $this->db->stop_cache();

   $this->db->select('DISTINCT(rema_reqdatebs),rema_reqdatead');
    $this->db->from('sama_salemaster sm');
    $this->db->join('sade_saledetail sde','sm.sama_salemasterid = sde.sade_salemasterid','LEFT');
   
    $this->db->join('rede_reqdetail rd','rd.rede_reqdetailid = sde.sade_reqdetailid','LEFT');
    $this->db->join('rema_reqmaster rm','rm.rema_reqmasterid = rd.rede_reqmasterid','LEFT');
    $this->db->join('loca_location scf', 'rm.rema_school=scf.loca_locationid', 'LEFT');
    $this->db->join('dept_department de', 'sm.sama_depid=de.dept_depid', 'LEFT');
    $this->db->join('dept_department dtfp', 'dtfp.dept_depid=de.dept_parentdepid', 'LEFT');
    $this->db->where('sama_st !=','C');
    $this->db->order_by('rema_reqdatebs','ASC');
    $demand_date_list = $this->db->get()->result();
    // print_r($demand_date_list);
    // die();

    $demand_date = array();
    if (count($demand_date_list)) {
    foreach ($demand_date_list as $key => $item) {
               
    $demand_date[$key]['demand_date'] = "$item->rema_reqdatebs (B.S) - $item->rema_reqdatead(A.D)";
 
    $this->db->select('sm.sama_st,sm.sama_billtime,sm.sama_requisitionno,sd.sade_curqty as sade_qty,sd.sade_unitrate,sd.sade_remarks,sm.sama_salemasterid,sm.sama_invoiceno,sm.sama_billdatebs,sm.sama_billdatead,dp.dept_depname sama_depname,sm.sama_totalamount,sm.sama_username,sm.sama_receivedby,(sd.sade_curqty*sd.sade_unitrate) as issueamt,eq.itli_itemname,eq.itli_itemnamenp,eq.itli_itemcode,eq.itli_itemlistid,dtfp.dept_depname parent_dep,scf.loca_name schoolname');
    $this->db->from('sade_saledetail sd');
    $this->db->join('sama_salemaster sm','sm.sama_salemasterid = sd.sade_salemasterid','LEFT');
   
    $this->db->join('rede_reqdetail rd','rd.rede_reqdetailid = sd.sade_reqdetailid','LEFT');
    $this->db->join('rema_reqmaster rm','rm.rema_reqmasterid = rd.rede_reqmasterid','LEFT');
    $this->db->join('loca_location scf', 'rm.rema_school = scf.loca_locationid', 'LEFT');
    $this->db->join('dept_department dp', 'dp.dept_depid=sm.sama_depid', 'LEFT');
    $this->db->join('dept_department dtfp', 'dtfp.dept_depid=dp.dept_parentdepid', 'LEFT');
    $this->db->join('itli_itemslist eq','eq.itli_itemlistid = sd.sade_itemsid','LEFT');
    $this->db->where('rema_reqdatebs',$item->rema_reqdatebs);
    $this->db->where('sama_st !=','C');

    $demand_date[$key]['demand_date_details'] = $this->db->get()->result();
    }
    }

    $this->db->flush_cache();   
    return $demand_date;
  }

  public function issue_report_received_by_detail()
  {
    $locationid = $this->input->post('locationid');
    $searchDateType = $this->input->post('searchDateType');
    $frmDate = $this->input->post('frmDate');
    $toDate = $this->input->post('toDate');
    $sama_mattypeid = $this->input->post('sama_mattypeid');
    $schoolid = $this->input->post('school');
    $departmentid = $this->input->post('departmentid');
    $subdepid = $this->input->post('subdepid');
    $sama_receivedby = $this->input->post('sama_receivedby');
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
      if(!empty(($frmDate && $toDate)))
      {
        if(DEFAULT_DATEPICKER == 'NP'){
            $this->db->where('sama_billdatebs >=',$frmDate);
            $this->db->where('sama_billdatebs <=',$toDate);    
        }else{
            $this->db->where('sama_billdatead >=',$frmDate);
            $this->db->where('sama_billdatead <=',$toDate);
        }
      } 
    }

    if (!empty($this->mattypeid)) {
      $this->db->where('sm.sama_mattypeid', $this->mattypeid);
    } else {
      if (!empty($sama_mattypeid)) {
        $this->db->where('sm.sama_mattypeid', $sama_mattypeid);
      }
    }

    if ($this->location_ismain == 'Y') {
      if (!empty($locationid)) {
          $this->db->where('sm.sama_locationid', $locationid);
      }
    } else {
        $this->db->where('sm.sama_locationid', $this->locationid);
    }

    if (!empty($schoolid)) {
      $this->db->where('rm.rema_school', $schoolid);
    }
    
    if (!empty($departmentid)) {
      if (!empty($subdepid)) {
          $this->db->where("sama_depid =" . $subdepid . " ");
      } else {
          if (!empty($subdeparray)) {
              $this->db->where_in("sama_depid", $subdeparray);
          } else {
              $this->db->where("sama_depid =" . $departmentid . " ");
          }
      }
    }
    $this->db->stop_cache();
     if (!empty($sama_receivedby)) {
        // $staffid = explode(',',$sama_receivedby);
        // if($staffid[0] != '1') 
          $this->db->where('sm.sama_receivedby', $sama_receivedby);
    }

   $this->db->select('DISTINCT(sama_receivedby)');
    $this->db->from('sama_salemaster sm');
    $this->db->join('sade_saledetail sde','sm.sama_salemasterid = sde.sade_salemasterid','LEFT');
   
    $this->db->join('rede_reqdetail rd','rd.rede_reqdetailid = sde.sade_reqdetailid','LEFT');
    $this->db->join('rema_reqmaster rm','rm.rema_reqmasterid = rd.rede_reqmasterid','LEFT');
    $this->db->join('loca_location scf', 'rm.rema_school=scf.loca_locationid', 'LEFT');
    $this->db->join('dept_department de', 'sm.sama_depid=de.dept_depid', 'LEFT');
    $this->db->join('dept_department dtfp', 'dtfp.dept_depid=de.dept_parentdepid', 'LEFT');
    $this->db->where('sama_st !=','C');
    $this->db->order_by('sama_receivedby','ASC');
    $requested_by_list = $this->db->get()->result();
    // print_r($requested_by_list);
    // die();

    $requested_by = array();
    if (count($requested_by_list)) {
    foreach ($requested_by_list as $key => $item) {
               
    $requested_by[$key]['requested_by'] = ucfirst($item->sama_receivedby);
 
    $this->db->select('sm.sama_st,sm.sama_billtime,sm.sama_requisitionno,sd.sade_curqty as sade_qty,sd.sade_unitrate,sd.sade_remarks,sm.sama_salemasterid,sm.sama_invoiceno,sm.sama_billdatebs,sm.sama_billdatead,dp.dept_depname sama_depname,sm.sama_totalamount,sm.sama_username,sm.sama_receivedby,(sd.sade_curqty*sd.sade_unitrate) as issueamt,eq.itli_itemname,eq.itli_itemnamenp,eq.itli_itemcode,eq.itli_itemlistid,dtfp.dept_depname parent_dep,scf.loca_name schoolname');
    $this->db->from('sade_saledetail sd');
    $this->db->join('sama_salemaster sm','sm.sama_salemasterid = sd.sade_salemasterid','LEFT');
   
    $this->db->join('rede_reqdetail rd','rd.rede_reqdetailid = sd.sade_reqdetailid','LEFT');
    $this->db->join('rema_reqmaster rm','rm.rema_reqmasterid = rd.rede_reqmasterid','LEFT');
    $this->db->join('loca_location scf', 'rm.rema_school = scf.loca_locationid', 'LEFT');
    $this->db->join('dept_department dp', 'dp.dept_depid=sm.sama_depid', 'LEFT');
    $this->db->join('dept_department dtfp', 'dtfp.dept_depid=dp.dept_parentdepid', 'LEFT');
    $this->db->join('itli_itemslist eq','eq.itli_itemlistid = sd.sade_itemsid','LEFT');
    $this->db->where('sama_receivedby',$item->sama_receivedby);
    $this->db->where('sama_st !=','C');
    
    $requested_by[$key]['requested_by_details'] = $this->db->get()->result();
    }
    }

    $this->db->flush_cache();   
    return $requested_by;
  }

  public function issue_report_category_wise_detail_default()
  {
    $locationid = $this->input->post('locationid');
    $searchDateType = $this->input->post('searchDateType');
    $frmDate = $this->input->post('frmDate');
    $toDate = $this->input->post('toDate');
    $sama_mattypeid = $this->input->post('sama_mattypeid');
    $categoryid=$this->input->post('categoryid');
    $schoolid = $this->input->post('school');
    $departmentid = $this->input->post('departmentid');
    $subdepid = $this->input->post('subdepid');
    $sama_receivedby = $this->input->post('sama_receivedby');
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
      if(!empty(($frmDate && $toDate)))
      {
        if(DEFAULT_DATEPICKER == 'NP'){
            $this->db->where('sama_billdatebs >=',$frmDate);
            $this->db->where('sama_billdatebs <=',$toDate);    
        }else{
            $this->db->where('sama_billdatead >=',$frmDate);
            $this->db->where('sama_billdatead <=',$toDate);
        }
      } 
    }

    if (!empty($this->mattypeid)) {
      $this->db->where('sm.sama_mattypeid', $this->mattypeid);
    } else {
      if (!empty($sama_mattypeid)) {
        $this->db->where('sm.sama_mattypeid', $sama_mattypeid);
      }
    }

    if (!empty($sama_receivedby)) {
        // $staffid = explode(',',$sama_receivedby);
        // if($staffid[0] != '1') 
          $this->db->where('sm.sama_receivedby', $sama_receivedby);
    }
      
    if ($this->location_ismain == 'Y') {
      if (!empty($locationid)) {
          $this->db->where('sm.sama_locationid', $locationid);
      }
    } else {
        $this->db->where('sm.sama_locationid', $this->locationid);
    }

    if (!empty($schoolid)) {
      $this->db->where('rm.rema_school', $schoolid);
    }
    
    if (!empty($departmentid)) {
      if (!empty($subdepid)) {
          $this->db->where("sama_depid =" . $subdepid . " ");
      } else {
          if (!empty($subdeparray)) {
              $this->db->where_in("sama_depid", $subdeparray);
          } else {
              $this->db->where("sama_depid =" . $departmentid . " ");
          }
      }
    }
     if(!empty($categoryid)){
      $this->db->where('il.itli_catid',$categoryid);
    }

    $this->db->stop_cache();

  $this->db->select("DISTINCT(il.itli_catid) as catid,ec.eqca_category");
  $this->db->from('sama_salemaster sm');
  $this->db->join('sade_saledetail sde','sm.sama_salemasterid = sde.sade_salemasterid','LEFT');
  $this->db->join('itli_itemslist il','il.itli_itemlistid=sde.sade_itemsid','LEFT');
  $this->db->join('eqca_equipmentcategory  ec','ec.eqca_equipmentcategoryid=il.itli_catid','LEFT');
  $this->db->where('sama_st !=','C');
  $this->db->group_by('il.itli_catid');
  $this->db->order_by('eqca_category','ASC');
    $cat_list = $this->db->get()->result();
   // echo "<pre>";
   //  print_r($cat_list);
   //  die();

    $category_data = array();
    if (count($cat_list)) {
    foreach ($cat_list as $key => $cat) {
               
    $category_data[$key]['category_data'] = "$cat->eqca_category";
 
    $this->db->select('sm.sama_st,sm.sama_billtime,sm.sama_requisitionno,sd.sade_curqty as sade_qty,sd.sade_unitrate,sd.sade_remarks,sm.sama_salemasterid,sm.sama_invoiceno,sm.sama_billdatebs,sm.sama_billdatead,dp.dept_depname sama_depname,sm.sama_totalamount,sm.sama_username,sm.sama_receivedby,(sd.sade_curqty*sd.sade_unitrate) as issueamt,il.itli_itemname,il.itli_itemnamenp,il.itli_itemcode,il.itli_itemlistid,dtfp.dept_depname parent_dep,scf.loca_name schoolname');
    $this->db->from('sade_saledetail sd');
    $this->db->join('sama_salemaster sm','sm.sama_salemasterid = sd.sade_salemasterid','LEFT');
    $this->db->join('rede_reqdetail rd','rd.rede_reqdetailid = sd.sade_reqdetailid','LEFT');
    $this->db->join('rema_reqmaster rm','rm.rema_reqmasterid = rd.rede_reqmasterid','LEFT');
    $this->db->join('loca_location scf', 'rm.rema_school = scf.loca_locationid', 'LEFT');
    $this->db->join('dept_department dp', 'dp.dept_depid=sm.sama_depid', 'LEFT');
    $this->db->join('dept_department dtfp', 'dtfp.dept_depid=dp.dept_parentdepid', 'LEFT');
    $this->db->join('itli_itemslist il','il.itli_itemlistid = sd.sade_itemsid','LEFT');
    $this->db->where('il.itli_catid',$cat->catid);
    $this->db->where('sama_st !=','C');

    $category_data[$key]['category_details'] = $this->db->get()->result();
    }
    }

    $this->db->flush_cache();   
    return $category_data;
  }

public function issue_report_handover_detail()
  {
    $locationid = $this->input->post('locationid');
    $searchDateType = $this->input->post('searchDateType');
    $frmDate = $this->input->post('frmDate');
    $toDate = $this->input->post('toDate');
    $sama_mattypeid = $this->input->post('sama_mattypeid');
    $categoryid=$this->input->post('categoryid');
    $departmentid = $this->input->post('departmentid');
    $subdepid = $this->input->post('subdepid');
    $sama_receivedby = $this->input->post('sama_receivedby');
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
      if(!empty(($frmDate && $toDate)))
      {
        if(DEFAULT_DATEPICKER == 'NP'){
            $this->db->where('sama_billdatebs >=',$frmDate);
            $this->db->where('sama_billdatebs <=',$toDate);    
        }else{
            $this->db->where('sama_billdatead >=',$frmDate);
            $this->db->where('sama_billdatead <=',$toDate);
        }
      } 
    }

    if (!empty($sama_receivedby)) {
        // $staffid = explode(',',$sama_receivedby);
        // if($staffid[0] != '1') 
          $this->db->where('sm.sama_receivedby', $sama_receivedby);
    }
      
    if ($this->location_ismain == 'Y') {
      if (!empty($locationid)) {
          $this->db->where('sm.sama_locationid', $locationid);
      }
    } else {
        $this->db->where('sm.sama_locationid', $this->locationid);
    }

    if (!empty($departmentid)) {
      if (!empty($subdepid)) {
          $this->db->where("sama_depid =" . $subdepid . " ");
      } else {
          if (!empty($subdeparray)) {
              $this->db->where_in("sama_depid", $subdeparray);
          } else {
              $this->db->where("sama_depid =" . $departmentid . " ");
          }
      }
    }
    $this->db->stop_cache();

    if (!empty($this->mattypeid)) {
      $this->db->where('sm.sama_mattypeid', $this->mattypeid);
    } else {
      if (!empty($sama_mattypeid)) {
        $this->db->where('sm.sama_mattypeid', $sama_mattypeid);
      }
    }
    if(!empty($categoryid)){
      $this->db->where('il.itli_catid',$categoryid);
    }

   $this->db->select('DISTINCT(sm.sama_salemasterid) sama_salemasterid, sm.sama_invoiceno');
    $this->db->from('sama_salemaster sm');
    $this->db->join('sade_saledetail sd','sm.sama_salemasterid = sd.sade_salemasterid','LEFT');
    $this->db->join('itli_itemslist il','il.itli_itemlistid = sd.sade_itemsid','LEFT');
    $this->db->join('maty_materialtype mt','mt.maty_materialtypeid=il.itli_materialtypeid','LEF');
    $this->db->join('rede_reqdetail rd','rd.rede_reqdetailid = sd.sade_reqdetailid','LEFT');
    $this->db->join('rema_reqmaster rm','rm.rema_reqmasterid = rd.rede_reqmasterid','LEFT');
    $this->db->join('loca_location scf', 'rm.rema_school=scf.loca_locationid', 'LEFT');
    $this->db->join('dept_department de', 'sm.sama_depid=de.dept_depid', 'LEFT');
    $this->db->join('dept_department dtfp', 'dtfp.dept_depid=de.dept_parentdepid', 'LEFT');
    $this->db->where('sama_st !=','C');
    $this->db->where('sama_ishandover','Y');
    $this->db->order_by('sama_salemasterid','ASC');
    $handover_list = $this->db->get()->result();
    // echo "<pre>";
    // print_r($handover_list);
    // die();

    $handover = array();
    if (count($handover_list)) {
    foreach ($handover_list as $key => $item) {
               
    $handover[$key]['invoice_no'] = $item->sama_invoiceno;
 
    $this->db->select('sm.sama_st,sm.sama_billtime,sm.sama_requisitionno,sd.sade_curqty as sade_qty, sd.sade_unitrate,sd.sade_remarks,sm.sama_salemasterid,sm.sama_invoiceno,sm.sama_billdatebs,sm.sama_billdatead,dp.dept_depname sama_depname,sm.sama_totalamount,sm.sama_username,sm.sama_receivedby,(sd.sade_curqty*sd.sade_unitrate) as issueamt,il.itli_itemname,il.itli_itemnamenp,il.itli_itemcode,il.itli_itemlistid,dtfp.dept_depname parent_dep,scf.loca_name schoolname');
    $this->db->from('sade_saledetail sd');
    $this->db->join('sama_salemaster sm','sm.sama_salemasterid = sd.sade_salemasterid','LEFT');
    $this->db->join('rede_reqdetail rd','rd.rede_reqdetailid = sd.sade_reqdetailid','LEFT');
    $this->db->join('rema_reqmaster rm','rm.rema_reqmasterid = rd.rede_reqmasterid','LEFT');
    $this->db->join('loca_location scf', 'rm.rema_school = scf.loca_locationid', 'LEFT');
    $this->db->join('dept_department dp', 'dp.dept_depid=sm.sama_depid', 'LEFT');
    $this->db->join('dept_department dtfp', 'dtfp.dept_depid=dp.dept_parentdepid', 'LEFT');
    $this->db->join('itli_itemslist il','il.itli_itemlistid = sd.sade_itemsid','LEFT');
    $this->db->where('sm.sama_salemasterid',$item->sama_salemasterid);
    $this->db->where('sama_st !=','C');
    $this->db->where('sama_ishandover','Y');

    $handover[$key]['handover_detail'] = $this->db->get()->result();
    }
    }

    $this->db->flush_cache();   
    return $handover;

  }

  public function issue_report_item_wise_detail_default()
  {
    $locationid = $this->input->post('locationid');
    $searchDateType = $this->input->post('searchDateType');
    $frmDate = $this->input->post('frmDate');
    $toDate = $this->input->post('toDate');
    $itemid =$this->input->post('itemid');
    $sama_mattypeid = $this->input->post('sama_mattypeid');
    $schoolid = $this->input->post('school');
    $departmentid = $this->input->post('departmentid');
    $subdepid = $this->input->post('subdepid');
    $sama_receivedby = $this->input->post('sama_receivedby');
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
      if(!empty(($frmDate && $toDate)))
      {
        if(DEFAULT_DATEPICKER == 'NP'){
            $this->db->where('sama_billdatebs >=',$frmDate);
            $this->db->where('sama_billdatebs <=',$toDate);    
        }else{
            $this->db->where('sama_billdatead >=',$frmDate);
            $this->db->where('sama_billdatead <=',$toDate);
        }
      } 
    }

    if (!empty($this->mattypeid)) {
      $this->db->where('sm.sama_mattypeid', $this->mattypeid);
    } else {
      if (!empty($sama_mattypeid)) {
        $this->db->where('sm.sama_mattypeid', $sama_mattypeid);
      }
    }

    if (!empty($sama_receivedby)) {
        // $staffid = explode(',',$sama_receivedby);
        // if($staffid[0] != '1') 
          $this->db->where('sm.sama_receivedby', $sama_receivedby);
    }
      
    if ($this->location_ismain == 'Y') {
      if (!empty($locationid)) {
          $this->db->where('sm.sama_locationid', $locationid);
      }
    } else {
        $this->db->where('sm.sama_locationid', $this->locationid);
    }

    if (!empty($schoolid)) {
      $this->db->where('rm.rema_school', $schoolid);
    }
    
    if (!empty($departmentid)) {
      if (!empty($subdepid)) {
          $this->db->where("sama_depid =" . $subdepid . " ");
      } else {
          if (!empty($subdeparray)) {
              $this->db->where_in("sama_depid", $subdeparray);
          } else {
              $this->db->where("sama_depid =" . $departmentid . " ");
          }
      }
    }

    if(!empty($itemid)){
      $this->db->where('il.itli_itemlistid',$itemid);
    }
    $this->db->stop_cache();

  $this->db->select("DISTINCT(sde.sade_itemsid) as itemid,il.itli_itemcode,il.itli_itemname");
  $this->db->from('sama_salemaster sm');
  $this->db->join('sade_saledetail sde','sm.sama_salemasterid = sde.sade_salemasterid','LEFT');
  $this->db->join('itli_itemslist il','il.itli_itemlistid=sde.sade_itemsid','LEFT');
  $this->db->join('eqca_equipmentcategory  ec','ec.eqca_equipmentcategoryid=il.itli_catid','LEFT');
  $this->db->where('sama_st !=','C');
  $this->db->group_by('sde.sade_itemsid');
  $this->db->order_by('il.itli_itemname','ASC');
  $item_list = $this->db->get()->result();
    // print_r($item_list);
    // die();

    $item_data = array();
    if (count($item_list)) {
    foreach ($item_list as $key => $cat) {
               
    $item_data[$key]['item_data'] = $cat->itli_itemcode.' | '.$cat->itli_itemname;
 
    $this->db->select('sm.sama_st,sm.sama_billtime,sm.sama_requisitionno,sde.sade_curqty as sade_qty, sde.sade_unitrate,sde.sade_remarks,sm.sama_salemasterid,sm.sama_invoiceno,sm.sama_billdatebs,sm.sama_billdatead,dp.dept_depname sama_depname,sm.sama_totalamount,sm.sama_username,sm.sama_receivedby,(sde.sade_curqty*sde.sade_unitrate) as issueamt,il.itli_itemname,il.itli_itemnamenp,il.itli_itemcode,il.itli_itemlistid,dtfp.dept_depname parent_dep,scf.loca_name schoolname');
    $this->db->from('sade_saledetail sde');
    $this->db->join('sama_salemaster sm','sm.sama_salemasterid = sde.sade_salemasterid','LEFT');
    $this->db->join('rede_reqdetail rd','rd.rede_reqdetailid = sde.sade_reqdetailid','LEFT');
    $this->db->join('rema_reqmaster rm','rm.rema_reqmasterid = rd.rede_reqmasterid','LEFT');
    $this->db->join('loca_location scf', 'rm.rema_school = scf.loca_locationid', 'LEFT');
    $this->db->join('dept_department dp', 'dp.dept_depid=sm.sama_depid', 'LEFT');
    $this->db->join('dept_department dtfp', 'dtfp.dept_depid=dp.dept_parentdepid', 'LEFT');
    $this->db->join('itli_itemslist il','il.itli_itemlistid = sde.sade_itemsid','LEFT');
    $this->db->where('sde.sade_itemsid',$cat->itemid);
    $this->db->where('sama_st !=','C');

    $item_data[$key]['item_details'] = $this->db->get()->result();
    }
    }

    $this->db->flush_cache();   
    return $item_data;
  }

 public function issue_number_detail_report()
  {
    $locationid = $this->input->post('locationid');
    $searchDateType = $this->input->post('searchDateType');
    $frmDate = $this->input->post('frmDate');
    $toDate = $this->input->post('toDate');
    $itemid =$this->input->post('itemid');
    $sama_mattypeid = $this->input->post('sama_mattypeid');
    $schoolid = $this->input->post('school');
    $departmentid = $this->input->post('departmentid');
    $subdepid = $this->input->post('subdepid');
    $sama_receivedby = $this->input->post('sama_receivedby');
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
      if(!empty(($frmDate && $toDate)))
      {
        if(DEFAULT_DATEPICKER == 'NP'){
            $this->db->where('sama_billdatebs >=',$frmDate);
            $this->db->where('sama_billdatebs <=',$toDate);    
        }else{
            $this->db->where('sama_billdatead >=',$frmDate);
            $this->db->where('sama_billdatead <=',$toDate);
        }
      } 
    }

    if (!empty($this->mattypeid)) {
      $this->db->where('sm.sama_mattypeid', $this->mattypeid);
    } else {
      if (!empty($sama_mattypeid)) {
        $this->db->where('sm.sama_mattypeid', $sama_mattypeid);
      }
    }

    if (!empty($sama_receivedby)) {
        // $staffid = explode(',',$sama_receivedby);
        // if($staffid[0] != '1') 
          $this->db->where('sm.sama_receivedby', $sama_receivedby);
    }
      
    if ($this->location_ismain == 'Y') {
      if (!empty($locationid)) {
          $this->db->where('sm.sama_locationid', $locationid);
      }
    } else {
        $this->db->where('sm.sama_locationid', $this->locationid);
    }

    if (!empty($schoolid)) {
      $this->db->where('rm.rema_school', $schoolid);
    }
    
    if (!empty($departmentid)) {
      if (!empty($subdepid)) {
          $this->db->where("sama_depid =" . $subdepid . " ");
      } else {
          if (!empty($subdeparray)) {
              $this->db->where_in("sama_depid", $subdeparray);
          } else {
              $this->db->where("sama_depid =" . $departmentid . " ");
          }
      }
    }

    if(!empty($itemid)){
      $this->db->where('il.itli_itemlistid',$itemid);
    }
    $this->db->stop_cache();

  $this->db->select("sama_salemasterid, sama_invoiceno, sama_billdatead, sama_billdatebs, sama_receivedby, sama_requisitionno");
  $this->db->from('sama_salemaster sm');
  $this->db->join('sade_saledetail sde','sm.sama_salemasterid = sde.sade_salemasterid','LEFT');
  $this->db->join('rede_reqdetail rd','rd.rede_reqdetailid = sde.sade_reqdetailid','LEFT');
  $this->db->join('rema_reqmaster rm','rm.rema_reqmasterid = rd.rede_reqmasterid','LEFT');
  // $this->db->join('itli_itemslist il','il.itli_itemlistid=sde.sade_itemsid','LEFT');
  // $this->db->join('eqca_equipmentcategory  ec','ec.eqca_equipmentcategoryid=il.itli_catid','LEFT');
  $this->db->where('sama_st !=','C');
  $this->db->group_by('sama_salemasterid');
  $this->db->order_by('sama_salemasterid','ASC');
  $invoice_list = $this->db->get()->result();

    $invoice_data = array();
    if (count($invoice_list)) {
    foreach ($invoice_list as $key => $inv) {
      $i = 1;  
    $invoice_data[$key]['invoice_data'] = $i.'. Invoice No.:'.$inv->sama_invoiceno.'  |  Issue Date : '.$inv->sama_billdatebs.' | Demand Req. No. : '.$inv->sama_requisitionno .' | Receiver Name: '.$inv->sama_receivedby;
 
    $this->db->select('sm.sama_billtime,sm.sama_requisitionno,(sde.sade_curqty) as sade_qty,sde.sade_unitrate,sde.sade_remarks,sm.sama_salemasterid,sm.sama_invoiceno,sm.sama_billdatebs,sm.sama_billdatead,dp.dept_depname sama_depname,sm.sama_totalamount,sm.sama_username,sm.sama_receivedby,(sde.sade_curqty*sde.sade_unitrate) as issueamt,il.itli_itemname,il.itli_itemnamenp,il.itli_itemcode,il.itli_itemlistid,dtfp.dept_depname parent_dep,scf.loca_name schoolname,ut.unit_unitname');
    $this->db->from('sade_saledetail sde');
    $this->db->join('sama_salemaster sm','sm.sama_salemasterid = sde.sade_salemasterid','LEFT');
    $this->db->join('rede_reqdetail rd','rd.rede_reqdetailid = sde.sade_reqdetailid','LEFT');
    $this->db->join('rema_reqmaster rm','rm.rema_reqmasterid = rd.rede_reqmasterid','LEFT');
    $this->db->join('loca_location scf', 'rm.rema_school = scf.loca_locationid', 'LEFT');
    $this->db->join('dept_department dp', 'dp.dept_depid=sm.sama_depid', 'LEFT');
    $this->db->join('dept_department dtfp', 'dtfp.dept_depid=dp.dept_parentdepid', 'LEFT');
    $this->db->join('itli_itemslist il','il.itli_itemlistid = sde.sade_itemsid','LEFT');
    $this->db->join('unit_unit ut', 'il.itli_unitid = ut.unit_unitid', 'LEFT');
    $this->db->where('sama_salemasterid',$inv->sama_salemasterid);
    $this->db->where('sama_st !=','C');
    // $this->db->group_by('sade_invoice,sade_itemsid,sade_unitrate');

    $invoice_data[$key]['invoice_details'] = $this->db->get()->result();
    $i++;
    }
    }

    $this->db->flush_cache();  
    // echo "<pre>";
    //  print_r ($invoice_data);
    //  echo "</pre>"; 
    //  die;
    return $invoice_data;
  }
 
}