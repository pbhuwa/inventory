<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class JobHeadExpensesReport_mdl extends CI_Model
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

  public function get_report_detail(){

    $locationid = $this->input->post('locationid');
    $searchDateType = $this->input->post('searchDateType');
    $frmDate = $this->input->post('frmDate');
    $toDate = $this->input->post('toDate');
    $budgetheadid = $this->input->post('budgetheadid');
    $categoryid = $this->input->post('categoryid');

    if($this->location_ismain == 'Y'){
      if($locationid)
      {
          $this->db->where('sm.sama_locationid',$locationid);
      }
    }
    else
    {
      $this->db->where('sm.sama_locationid',$this->locationid);
    }

    // if($searchDateType == 'date_range'){
        if(!empty(($frmDate && $toDate))){
            if(DEFAULT_DATEPICKER == 'NP'){
                $this->db->where('sama_billdatebs >=',$frmDate);
                $this->db->where('sama_billdatebs <=',$toDate);    
            }else{
                $this->db->where('sama_billdatead >=',$frmDate);
                $this->db->where('sama_billdatead <=',$toDate);
            }
        }

    // }

    if (!empty($budgetheadid)) {
      $this->db->where('rede_budgetheadid',$budgetheadid);
    }
    if (!empty($categoryid)) {
      $this->db->where('rede_catid',$categoryid);
    }

    $this->db->select('DISTINCT(eqca_category) as category,eq.eqca_equipmentcategoryid as catid,sama_locationid as locationid,eqca_code');
    $this->db->from('sade_saledetail sd');
    $this->db->join('sama_salemaster sm','sm.sama_salemasterid = sd.sade_salemasterid','LEFT');
    $this->db->join('rede_reqdetail rd','rd.rede_reqdetailid = sd.sade_reqdetailid','LEFT');
    // $this->db->join('buhe_bugethead bh','rd.rede_budgetheadid = bh.buhe_bugetheadid','LEFT');
    $this->db->join('eqca_equipmentcategory eq','rd.rede_catid = eq.eqca_equipmentcategoryid','LEFT');
    $this->db->where('sama_st !=','C');
    $this->db->where('sama_status','O');
    
    $category_list = $this->db->get()->result();
    $budget_head = $this->general->get_tbl_data('*','buhe_bugethead',array('buhe_isactive'=>'Y'));

    // echo "<pre>";
    // print_r ($category_list);
    // echo "</pre>";
    // die;
     
    $data = array();  
    if(!empty($category_list) && !empty($budget_head)){
      foreach ($category_list as $key => $cat) {
        if(!empty($cat->catid)){
        $data[$key]['name'] = $cat->category;
        $data[$key]['code'] = $cat->eqca_code;
        $query = "SELECT";
        foreach ($budget_head as $bk => $bh) { 
          $query .= " fn_get_jobhead_amount($cat->catid, $bh->buhe_bugetheadid,$cat->locationid,'$frmDate','$toDate') as '$bh->buhe_bugetheadid',";
        } 
          $query = substr($query, 0, -1); 
          $data[$key]['details'] = (array)$this->db->query($query)->row(); 
        }
      }
    } 
    return $data;
  }
}