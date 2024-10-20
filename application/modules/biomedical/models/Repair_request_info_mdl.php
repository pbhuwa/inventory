<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Repair_request_info_mdl extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
		  $this->table='rere_repairrequests';
      $this->postip=$this->general->get_real_ipaddr();
      $this->postmac=$this->general->get_Mac_Address();

      $this->sess_usercode = $this->session->userdata(USER_GROUPCODE);
      $this->sess_dept = $this->session->userdata(USER_DEPT);
	}

   public $validate_settings_parts = array(               
      array('field' => 'rere_action', 'label' => 'Action Taken', 'rules' => 'trim|required|xss_clean'),
    );


	public function get_all_repair_information($srchcol=false)
	{
		$get = $_GET;
 
      	foreach ($get as $key => $value) {
        	$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
      	}
     	if(!empty($get['sSearch_0'])){
            $this->db->where("rere_repairrequestid like  '%".$get['sSearch_0']."%'  ");
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("rere_postdatead like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("rere_postdatebs like  '%".$get['sSearch_2']."%'  ");
        }
         if(!empty($get['sSearch_3'])){
            $this->db->where("dept_depname like  '%".$get['sSearch_3']."%'  ");
        }
         if(!empty($get['sSearch_4'])){
            $this->db->where("bmin_equipmentkey like  '%".$get['sSearch_4']."%'  ");
        }
         if(!empty($get['sSearch_5'])){
            $this->db->where("rere_problem like  '%".$get['sSearch_5']."%'  ");
        }
        if(!empty($get['sSearch_6'])){
            $this->db->where("rere_action like  '%".$get['sSearch_6']."%'  ");
        }

        if($srchcol)
        {
          $this->db->where($srchcol);
        }

         if(($this->sess_usercode != 'SA') && ($this->sess_usercode != 'AD')){
 
          $new_sess_dept = explode(',',$this->sess_dept);
          $this->db->where_in('dept_depid',$new_sess_dept);
        }
        $resltrpt=$this->db->select("COUNT(*) as cnt")
  					->from('rere_repairrequests r')
            ->join('bmin_bmeinventory b','b.bmin_equipid = r.rere_equid')
            ->join('dept_department d','d.dept_depid = b.bmin_departmentid')
  					->get()
  					->row();
	    //echo $this->db->last_query();die(); 
      	$totalfilteredrecs=$resltrpt->cnt; 

      	$order_by = 'r.rere_repairrequestid';
      	$order = 'desc';
      	if($this->input->get('sSortDir_0'))
  		{
  				$order = $this->input->get('sSortDir_0');
  		}
  
      	$where='';
      	if($this->input->get('iSortCol_0')==0)
        	$order_by = 'rere_repairrequestid';
      	else if($this->input->get('iSortCol_0')==1)
        	$order_by = 'rere_postdatead';
      	else if($this->input->get('iSortCol_0')==2)
       		$order_by = 'rere_postdatebs';
       	else if($this->input->get('iSortCol_0')==3)
       		$order_by = 'dept_depname';
        else if($this->input->get('iSortCol_0')==4)
          $order_by = 'bmin_equipmentkey';
        else if($this->input->get('iSortCol_0')==5)
          $order_by = 'rere_problem';
        else if($this->input->get('iSortCol_0')==6)
          $order_by = 'rere_action';
        else if($this->input->get('iSortCol_0')==7)
          $order_by = 'rere_status';
       	
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
            $this->db->where("rere_repairrequestid like  '%".$get['sSearch_0']."%'  ");
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("rere_postdatead like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("rere_postdatebs like  '%".$get['sSearch_2']."%'  ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("dept_depname like  '%".$get['sSearch_3']."%'  ");
        }
         if(!empty($get['sSearch_4'])){
            $this->db->where("bmin_equipmentkey like  '%".$get['sSearch_4']."%'  ");
        }
         if(!empty($get['sSearch_5'])){
            $this->db->where("rere_problem like  '%".$get['sSearch_5']."%'  ");
        }
        if(!empty($get['sSearch_6'])){
            $this->db->where("rere_action like  '%".$get['sSearch_6']."%'  ");
        }
          if($srchcol)
        {
          $this->db->where($srchcol);
        }
   
      $this->db->select('r.*,bm.*,eql.eqli_description,di.dept_depname as dein_department,ri.riva_risk,ri.riva_risktype, ri.riva_year,ri.riva_riskcount,ri.riva_times, dis.dist_distributor,mf.manu_manlst,rd.rode_roomname,dam.dist_distributor as amc_contractor ');
      $this->db->from('rere_repairrequests r');
      $this->db->join('bmin_bmeinventory bm','bm.bmin_equipid = r.rere_equid');
      $this->db->join('eqli_equipmentlist eql','eql.eqli_equipmentlistid=bm.bmin_descriptionid','LEFT');
      $this->db->join('dept_department di','di.dept_depid=bm.bmin_departmentid','LEFT');
      $this->db->join('riva_riskvalues ri', 'ri.riva_riskid = bm.bmin_riskid', 'LEFT');
      $this->db->join('dist_distributors dis', 'dis.dist_distributorid = bm.bmin_distributorid', 'LEFT');
      $this->db->join('manu_manufacturers mf', 'mf.manu_manlistid = bm.bmin_manufacturerid', 'LEFT');
      $this->db->join('rode_roomdepartment rd', 'rd.rode_roomdepartmentid = bm.bmin_roomid', 'LEFT');
      $this->db->join('dist_distributors dam', 'dam.dist_distributorid = bm.bmin_amcontractorid', 'LEFT');
      $this->db->order_by($order_by,$order);
        if($limit && $limit>0)
        {  
            $this->db->limit($limit);
        }
        if($offset)
        {
            $this->db->offset($offset);
        }

         if(($this->sess_usercode != 'SA') && ($this->sess_usercode != 'AD')){
 
          $new_sess_dept = explode(',',$this->sess_dept);
          $this->db->where_in('dept_depid',$new_sess_dept);
        }
      
       $nquery=$this->db->get();
       $num_row=$nquery->num_rows();
        if (!empty($_GET['iDisplayLength']) &&  !empty($nquery) && is_array($nquery) && count($nquery) > 0 ) {
            $totalrecs = sizeof($nquery);
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

  public function repair_request_info($srchcol = false,$limit=false,$offset=false,$order_by=false,$order='ASC'){
    try{
      $this->db->select('r.*,bm.*,eql.eqli_description,di.dept_depname as dein_department,ri.riva_risk,ri.riva_risktype, ri.riva_year,ri.riva_riskcount,ri.riva_times, dis.dist_distributor,mf.manu_manlst,rd.rode_roomname,dam.dist_distributor as amc_contractor,u.usma_username,st.sete_name,st.sete_workphone,st. sete_mobilephone  ');
      $this->db->from('rere_repairrequests r');
      $this->db->join('eqco_equipmentcomment ec','ec.eqco_equipmentcommentid = r.rere_commentid');
      $this->db->join('usma_usermain u','u.usma_userid = ec.eqco_postby','left');
      $this->db->join('bmin_bmeinventory bm','bm.bmin_equipid = r.rere_equid');
      $this->db->join('eqli_equipmentlist eql','eql.eqli_equipmentlistid=bm.bmin_descriptionid','LEFT');
      $this->db->join('dept_department di','di.dept_depid=bm.bmin_departmentid','LEFT');
      $this->db->join('riva_riskvalues ri', 'ri.riva_riskid = bm.bmin_riskid', 'LEFT');
      $this->db->join('dist_distributors dis', 'dis.dist_distributorid = bm.bmin_distributorid', 'LEFT');
      $this->db->join('manu_manufacturers mf', 'mf.manu_manlistid = bm.bmin_manufacturerid', 'LEFT');
      $this->db->join('rode_roomdepartment rd', 'rd.rode_roomdepartmentid = bm.bmin_roomid', 'LEFT');
      $this->db->join('dist_distributors dam', 'dam.dist_distributorid = bm.bmin_amcontractorid', 'LEFT');
      $this->db->join('sete_servicetechs st', 'st.sete_techid = r.rere_technician', 'LEFT');

      if($srchcol){
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

          if(($this->sess_usercode != 'SA') && ($this->sess_usercode != 'AD')){
 
          $new_sess_dept = explode(',',$this->sess_dept);
          $this->db->where_in('dept_depid',$new_sess_dept);
        }
        
        $qry=$this->db->get();
      //echo $this->db->last_query();die();
       if($qry->num_rows()>0)
        {
      return $qry->result();
      }
     return false;

    }catch(Exception $e){
      throw $e;
    }
  }

    public function updateRepairStatus(){
        try{
            $repairid = $this->input->post('repairid');
            $postdata['rere_status'] = 1;
            $postdata['rere_isrepair'] = 'Y';
            $postdata['rere_repairdatead'] = CURDATE_EN;
            $postdata['rere_repairdatebs'] = CURDATE_NP;
            $postdata['rere_modifydatead'] = CURDATE_EN;
            $postdata['rere_modifydatebs'] = CURDATE_NP;
            $postdata['rere_modifytime'] = $this->general->get_currenttime();
            $postdata['rere_modifymac'] = $this->postmac;
            $postdata['rere_modifyip'] = $this->postip;
            $postdata['rere_modifyby'] = $this->session->userdata(USER_ID);

            $status = 1; //equipement comment process is completed
            if(!empty($postdata)){
                $this->db->update($this->table,$postdata,array('rere_repairrequestid'=>$repairid));

              $repair_data = $this->db->select('rere_commentid')->from($this->table)->where(array('rere_repairrequestid'=>$repairid))->get()->row();    
              if ($repair_data) {
                $this->db->where("eqco_equipmentcommentid", $repair_data->rere_commentid);
                $this->db->set("eqco_comment_status", $status);
                $this->db->update("eqco_equipmentcomment"); 
              }
                return true;
            }
            return false;
        }catch(Exception $e){
            throw $e;
        }
    }

    public function delete_repairrequest()
    {
      $id=$this->input->post('id');
      if($id)
      {
        $this->db->delete($this->table,array('rere_repairrequestid'=>$id));
        $rowaffected=$this->db->affected_rows();
        if($rowaffected)
        {
          return $rowaffected;
        }
        return false;
      }
      return false;
    }
	
  function parts_details_save()
  { 
    $postdata=$this->input->post();//print_r($postdata);die;
    $parts_name = $this->input->post('parts_name');
    $qty = $this->input->post('qty');
    $rate = $this->input->post('rate');
    $total = $this->input->post('total');

    foreach ($parts_name as $key => $value) {
        $dataArray[]= array(
            'eqpa_partsname'=>$parts_name[$key],
            'eqpa_qty'=>$qty[$key],
            'eqpa_rate'=>$rate[$key],
            'eqpa_total'=>$total[$key],
            'eqpa_modifyby'=>$this->session->userdata(USER_ID),
            'eqpa_modifytime'=>$this->general->get_currenttime(),
            'eqpa_postmac'=>$this->postmac,
            'eqpa_postip'=>$this->postmac,
            'eqpa_postby'=>$this->session->userdata(USER_ID),
            'eqpa_postdatebs'=>CURDATE_NP,
            'eqpa_postdatead'=>CURDATE_EN,
            'eqpa_equipid'=>$this->input->post('bmin_equipid'),
            'eqpa_repairid'=>$this->input->post('rere_repairrequestid'),
        ); 
    }
    //print_r($postArray);die;
    $this->db->insert_batch('eqpa_equipparts', $dataArray);
    $rowaffected=$this->db->affected_rows();
    if($rowaffected)
    {
      return $rowaffected;
    }
    return false;
  }

  // public function get_part_information($srchcol=false,$limit=false,$offset=false,$order_by=false,$order='ASC')
  // {
  //   $this->db->select('*');
  //   $this->db->from('eqpa_equipparts');

  //      if($srchcol)
  //     {
  //        $this->db->where($srchcol);
  //     }
  //     if($limit && $limit>0)
  //     {
  //       $this->db->limit($limit);
  //     }
  //     if($offset)
  //     {
  //       $this->db->offset($offset);
  //     }

  //     if($order_by)
  //     {
  //       $this->db->order_by($order_by,$order);
  //     }

  //    $qry=$this->db->get();
  //     //echo $this->db->last_query();die();
      
  //    if($qry->num_rows()>0)
  //    {
  //     return $qry->result();
  //    }
  //    return false;
  // }
  public function get_part_information($srchcol=false,$limit=false,$offset=false,$order_by=false,$order='ASC')
  {
    $this->db->select('r.*,bm.bmin_equipmentkey,rd.rode_roomname,di.dept_depname as dein_department');
    $this->db->from('rere_repairrequests r');
    $this->db->join('bmin_bmeinventory bm','bm.bmin_equipid = r.rere_equid');
    $this->db->join('rode_roomdepartment rd', 'rd.rode_roomdepartmentid = bm.bmin_roomid', 'LEFT');
    $this->db->join('dept_department di','di.dept_depid=bm.bmin_departmentid','LEFT');
    $this->db->join('eqpa_equipparts as ep','r.rere_equid = ep.eqpa_equippartsid');

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

     $qry=$this->db->get();
      //echo $this->db->last_query();die();
      
     if($qry->num_rows()>0)
     {
      return $qry->result();
     }
     return false;
  }
}