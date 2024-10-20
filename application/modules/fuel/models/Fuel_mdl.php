<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Fuel_mdl extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();

    $this->tableMaster='fuel_fuelcoupen';
    $this->tableDetails='fude_fuelcoupendetails';
    $this->userid = $this->session->userdata(USER_ID);
    $this->username = $this->session->userdata(USER_NAME);
    $this->curtime = $this->general->get_currenttime();
    $this->mac = $this->general->get_Mac_Address();
    $this->ip = $this->general->get_real_ipaddr();
  }
  public $validate_settings_fuel_list = array(
    array('field' => 'fuel_typeid', 'label'=>' Fuel Type','rules'=>'trim|required|xss_clean'),
        // array('field' => 'fuel_valdate', 'label'=>'valid date','rules'=>'trim|required|xss_clean'),
        // array('field' => 'fuel_month', 'label'=>'Month','rules'=>'trim|required|xss_clean'),
    array('field' => 'fuel_fyear', 'label'=>'Fiscal Year','rules'=>'trim|required|xss_clean')
  );
  

  public function fuel_save(){       
    try{


     $postdata=$this->input->post();
     $generate_date=$this->input->post('fuel_gendate');
     $expire_date=$this->input->post('fuel_expdate');
     // $fueltypeid=$this->input->post('fuel_typeid');
     $no_of_coupen=$this->input->post('fuel_noofcoupen');

     $typeid=$this->input->post('fuel_typeid');
     $month=$this->input->post('fuel_month');
     $fyear=$this->input->post('fuel_fyear');

     $check_coupen=$this->check_exist_coupen_no($typeid,$month,$fyear);
     $max_coupenno=$check_coupen[0]->max_coupen_number;
         // print_r($max_coupenno);die;
     if(DEFAULT_DATEPICKER=='NP')
     {
      $generatebs=$generate_date;
      $generatead=$this->general->NepToEngDateConv($generate_date);
      $expireddatebs=$expire_date;
      $expireddatead=$this->general->NepToEngDateConv($expire_date);
    }
    else
    {
      $generatead=$generate_date;
      $generatebs=$this->general->EngToNepDateConv($generate_date);
      $expireddatead=$expire_date;
      $expireddatebs=$this->general->EngToNepDateConv($expire_date);
    }


    $this->db->trans_begin();


    $postdata['fuel_gendatead']=$generatead;
    $postdata['fuel_gendatebs']=$generatebs;
    $postdata['fuel_expdatead']=$expireddatead;
    $postdata['fuel_expdatebs']=$expireddatebs;

    $postdata['fuel_postdatead']=CURDATE_EN;
    $postdata['fuel_postdatebs']=CURDATE_NP;
    $postdata['fuel_posttime']=date('H:i:s');
    $postdata['fuel_postmac']=$this->general->get_Mac_Address();
    $postdata['fuel_postip']=$this->general->get_real_ipaddr();
    $postdata['fuel_postby']=$this->session->userdata(USER_ID);

    if(!empty($postdata)){
      $this->db->insert($this->tableMaster,$postdata);
      $insertid=$this->db->insert_id();

      if($insertid){

        if($check_coupen!=''){
         $start = $max_coupenno+1;
         $end = $max_coupenno + $no_of_coupen;
       }else{
         $start = 1;
         $end = $no_of_coupen;
       }
       $noofcoupen = 0;
       for($i=$start; $i<=$end; $i++) {
        $noofcoupen =$i;
        $coupenDetails[]=array( 
          'fude_fuelcoupenid'=>$insertid,
          'fude_coupenno'=> !empty($noofcoupen)?$noofcoupen:'',
          'fude_postdatead'=>CURDATE_EN,
          'fude_postdatebs'=>CURDATE_NP,
          'fude_posttime'=>$this->curtime,
          'fude_postby'=>$this->userid,
          'fude_postmac'=>$this->mac,
          'fude_postip'=>$this->ip,
          'fude_typeid'=>$typeid,
          'fude_fyear'=>$fyear,
          'fude_month'=>$month,
          'fude_isassigned'=>'N',
          'fude_staffid'=>0

        );
      }
      
      if(!empty($coupenDetails)){   
        $this->db->insert_batch($this->tableDetails,$coupenDetails);
      }
    } 
  } 

  $this->db->trans_complete();
  if ($this->db->trans_status() === FALSE){
    $this->db->trans_rollback();
    return false;
  }
  else{
    $this->db->trans_commit();

    return $insertid;

  }
}catch(Exception $e){
  throw $e;
}
}
public function check_exist_coupen_no($typeid=flase,$month=false,$fyear=false) {
  $this->db->select('MAX(fude_coupenno) as max_coupen_number');
  $this->db->from('fude_fuelcoupendetails fd');
  // $this->db->join('fuel_fuelcoupen fm','fm.fuel_fuelcoupenid = fd.fude_fuelcoupenid','left');
  // $this->db->join('futy_fueltype fts','fts.futy_typeid = fd.fude_typeid','left');
  $this->db->where('fude_typeid', $typeid);
  $this->db->where('fude_fyear', $fyear);
  $this->db->where('fude_month', $month);

  $query = $this->db->get();
    // echo $this->db->last_query();
    // die();
  if ($query->num_rows() > 0) 
  {
    $data=$query->result();   
    return $data;   
  }   
  return false;
}
public function get_fuel_details($srchcol=false,$limit=false,$offset=false,$order_by=false,$order='ASC')
{
 $this->db->select('fd.*,fm.fuel_fyear,fm.fuel_expdatebs,fm.fuel_fuelcoupenid,fts.futy_name,mo.mona_namenp,st.stin_fname,st.stin_lname');
 $this->db->from('fude_fuelcoupendetails fd');
 $this->db->join('fuel_fuelcoupen fm','fm.fuel_fuelcoupenid = fd.fude_fuelcoupenid','left');
 $this->db->join('futy_fueltype fts','fts.futy_typeid = fd.fude_typeid','left');
 $this->db->join('mona_monthname mo','mo.mona_monthid = fm.fuel_month','left');
 $this->db->join('stin_staffinfo st','st.stin_staffinfoid = fd.fude_staffid','left');

 if($srchcol)
 {
  $this->db->where($srchcol);
}
if($limit && $limit>0)
{
  $this->db->limit($limit);
}
if($offset)
{
  $this->db->offset($offset);
}

if($order_by)
{
  $this->db->order_by($order_by,$order);
}

$query = $this->db->get();
    // echo $this->db->last_query();
    // die();
if ($query->num_rows() > 0) 
{
  $data=$query->result();   
  return $data;   
}   
return false;
}

public function remove_fuel()
{
  $id=$this->input->post('id');
  if($id)
  {
   $this->db->where('fuel_fuelcoupenid', $id);
   $this->db->delete('fuel_fuelcoupen'); 
   $rowaffected=$this->db->affected_rows();
   if($rowaffected)
   {
    return $rowaffected;
  }
  return false;
}
return false;
}
public function assign_coupen_update()
{ 

 $staffid = $this->input->post('fude_staffid');
 $id=$this->input->post('assignid');
 $assigndatead = CURDATE_EN;
 $assigndatebs = CURDATE_NP;
 $assigned_by = $this->username;
 $postdata = array(
  'fude_staffid'=>$staffid,
  'fude_modifydatead'=> CURDATE_NP,
  'fude_modifydatebs'=>CURDATE_EN,
  'fude_modifytime'=>date('H:i:s'),
  'fude_modifymac'=>$this->general->get_real_ipaddr(),
  'fude_modifyip'=>$this->general->get_Mac_Address(),
  'fude_assignedby'=> $assigned_by,
  'fude_assigneddatebs'=> CURDATE_NP,
  'fude_assigneddatebs'=>CURDATE_EN,
  'fude_assignedtime'=>date('H:i:s'),
  'fude_isassigned'=>'Y'
  

);
 $this->db->update($this->tableDetails,$postdata,array('fude_fuelcoupendetailsid'=>$id));
 $rowaffected=$this->db->affected_rows();
 if($rowaffected)
 {
  return $rowaffected;
}
else
{
  return false;
}
}
public function get_all_coupen_details_list()
{
  $get = $_GET;

  foreach ($get as $key => $value) {
    $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
  }
  if(!empty($get['sSearch_0'])){
    $this->db->where("fude_coupenno like  '%".$get['sSearch_0']."%'  ");
  }

  if(!empty($get['sSearch_1'])){
    $this->db->where("futy_name like  '%".$get['sSearch_1']."%'  ");
  }
  if(!empty($get['sSearch_2'])){
    $this->db->where("mona_namenp like  '%".$get['sSearch_2']."%'  ");
  }

  if(!empty($get['sSearch_3'])){
    $this->db->where("fuel_fyear like  '%".$get['sSearch_3']."%'  ");
  }
  if(!empty($get['sSearch_4'])){
    $this->db->where("fuel_expdatebs like  '%".$get['sSearch_4']."%'  ");
  }
  if(!empty($get['sSearch_5'])){
    $this->db->where("stin_fname like  '%".$get['sSearch_5']."%'  ");
  }
  if(!empty($get['sSearch_6'])){
    $this->db->where("fude_isassigned like  '%".$get['sSearch_6']."%'  ");
  }
  
  $monthid = !empty($get['monthid'])?$get['monthid']:$this->input->post('monthid');
  $fyear= !empty($get['fyear'])?$get['fyear']:$this->input->post('fyear');
  $typeid= !empty($get['typeid'])?$get['typeid']:$this->input->post('typeid');


  if(!empty($fyear))
  {
    $this->db->where('fm.fuel_fyear',"$fyear");
  }

  if(!empty($monthid))
  {
    $this->db->where('fm.fuel_month',"$monthid");
  }
  if(!empty($typeid))
  {
    $this->db->where('fd.fude_typeid',"$typeid");
  }

  $resltrpt=$this->db->select("COUNT(*) as cnt")
  ->from('fude_fuelcoupendetails fd')
  ->join('fuel_fuelcoupen fm','fm.fuel_fuelcoupenid = fd.fude_fuelcoupenid','left')
  ->join('futy_fueltype fts','fts.futy_typeid = fd.fude_typeid','left')
  ->join('mona_monthname mo','mo.mona_monthid = fm.fuel_month','left')
  ->join('stin_staffinfo st','st.stin_staffinfoid = fd.fude_staffid','left')
     // ->where(array('um.usma_isactive'=>'1')
  ->get()
  ->row(); 
         // echo $this->db->last_query();die(); 
  $totalfilteredrecs=$resltrpt->cnt; 

  $order_by = 'fude_fuelcoupendetailsid';
  $order = 'desc';
  if($this->input->get('sSortDir_0'))
  {
    $order = $this->input->get('sSortDir_0');
  }

  $where='';
  if($this->input->get('iSortCol_0')==0)
    $order_by = 'fude_fuelcoupendetailsid';
  else if($this->input->get('iSortCol_0')==1)
    $order_by = 'fude_coupenno';
  else if($this->input->get('iSortCol_0')==2)
    $order_by = 'mona_monthname';
  else if($this->input->get('iSortCol_0')==3)
    $order_by = 'fuel_fyear';
  else if($this->input->get('iSortCol_0')==4)
    $order_by = 'fuel_expdatebs';
  else if($this->input->get('iSortCol_0')==5)
    $order_by = 'stin_fname';
  else if($this->input->get('iSortCol_0')==6)
    $order_by = 'fude_isassigned';

  $totalrecs='';
  $limit = 15;
  $offset = 1;
  $get = $_GET;

  foreach ($get as $key => $value) {
    $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
  }

  if(!empty($_GET["iDisplayLength"])){
    $limit = $_GET['iDisplayLength'];
    $offset = $_GET["iDisplayStart"];
  }

  if(!empty($get['sSearch_0'])){
    $this->db->where("fude_coupenno like  '%".$get['sSearch_0']."%'  ");
  }

  if(!empty($get['sSearch_1'])){
    $this->db->where("futy_name like  '%".$get['sSearch_1']."%'  ");
  }
  if(!empty($get['sSearch_2'])){
    $this->db->where("mona_namenp like  '%".$get['sSearch_2']."%'  ");
  }

  if(!empty($get['sSearch_3'])){
    $this->db->where("fuel_fyear like  '%".$get['sSearch_3']."%'  ");
  }
  if(!empty($get['sSearch_4'])){
    $this->db->where("fuel_expdatebs like  '%".$get['sSearch_4']."%'  ");
  }
  if(!empty($get['sSearch_5'])){
    $this->db->where("stin_fname like  '%".$get['sSearch_5']."%'  ");
  }
  if(!empty($get['sSearch_6'])){
    $this->db->where("fude_isassigned like  '%".$get['sSearch_6']."%'  ");
  }
  
  $monthid = !empty($get['monthid'])?$get['monthid']:$this->input->post('monthid');
  $fyear= !empty($get['fyear'])?$get['fyear']:$this->input->post('fyear');
  $typeid= !empty($get['typeid'])?$get['typeid']:$this->input->post('typeid');


  

  $this->db->select('fd.*,fm.fuel_fyear,fm.fuel_expdatebs,fm.fuel_fuelcoupenid,fts.futy_name,mo.mona_namenp,st.stin_fname,st.stin_lname');
  $this->db->from('fude_fuelcoupendetails fd');
  $this->db->join('fuel_fuelcoupen fm','fm.fuel_fuelcoupenid = fd.fude_fuelcoupenid','left');
  $this->db->join('futy_fueltype fts','fts.futy_typeid = fd.fude_typeid','left');
  $this->db->join('mona_monthname mo','mo.mona_monthid = fm.fuel_month','left');
  $this->db->join('stin_staffinfo st','st.stin_staffinfoid = fd.fude_staffid','left');

  if(!empty($fyear))
  {
    $this->db->where('fm.fuel_fyear',"$fyear");
  }

  if(!empty($monthid))
  {
    $this->db->where('fm.fuel_month',"$monthid");
  }
  if(!empty($typeid))
  {
    $this->db->where('fd.fude_typeid',"$typeid");
  }


  if($limit && $limit>0)
  {  
    $this->db->limit($limit);
  }
  if($offset)
  {
    $this->db->offset($offset);
  }

  $nquery=$this->db->get();
  $num_row=$nquery->num_rows();
  if(!empty($_GET['iDisplayLength']) && is_array($nquery)) {
    $totalrecs = sizeof( $nquery);
  }


  if($num_row>0){
    $ndata=$nquery->result();
    $ndata['totalrecs'] = $totalrecs;
    $ndata['totalfilteredrecs'] = $totalfilteredrecs;
  } 
  else
  {
    $ndata=array();
    $ndata['totalrecs'] = 0;
    $ndata['totalfilteredrecs'] = 0;
  }
         // echo $this->db->last_query();die();
  return $ndata;

}
public function get_all_staff_manager($srstinl=false,$limit=false,$offset=false,$order_by=false,$order=false)
{
  $this->db->select('st.*,rd.rode_roomname,dp.dept_depname,sp.stpo_staffposition');
  $this->db->from('stin_staffinfo st');
  $this->db->join('dept_department dp','dp.dept_depid=st.stin_departmentid','LEFT');
  $this->db->join('rode_roomdepartment rd','rd.rode_roomdepartmentid=st.stin_roomid','LEFT');
  $this->db->join('stpo_staffposition sp','sp.stpo_staffpositionid=st.stin_positionid','LEFT');
  if($srstinl)
  {
    $this->db->where($srstinl);
  }
  if($limit && $limit>0)
  {
    $this->db->limit($limit);
  }
  if($offset)
  {
    $this->db->offset($offset);
  }

  if($order_by)
  {
    $this->db->order_by($order_by,$order);
  }

  $query = $this->db->get();
    // echo $this->db->last_query();
    // die();
  if ($query->num_rows() > 0) 
  {
    $data=$query->result();   
    return $data;   
  }   
  return false;
}



}