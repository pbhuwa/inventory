<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Monthlywise_item_issue_mdl extends CI_Model
{
    public function __construct(){
        parent::__construct();
        $this->rema_masterTable='rema_reqmaster';
        $this->rede_detailTable='rede_reqdetail';

        $this->userid = $this->session->userdata(USER_ID);
        $this->username = $this->session->userdata(USER_NAME);
        $this->curtime = $this->general->get_currenttime();
        $this->mac = $this->general->get_Mac_Address();
        $this->ip = $this->general->get_real_ipaddr();
        $this->locationid=$this->session->userdata(LOCATION_ID);
        $this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);


    }

 public function generate_item_wise_data()
    {
        // $this->db->query('TRUNCATE TABLE xw_temi_tempmonthlyissue');

        $get = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }
        $whr='';
        if(!empty($get['sSearch_1'])){
          
            $whr .=" AND  il.itli_itemcode like  '%".$get['sSearch_1']."%' "; 
        }
        if(!empty($get['sSearch_2'])){
          
            $whr .=" AND  il.itli_itemname like  '%".$get['sSearch_2']."%' OR itli_itemnamenp like  '%".$get['sSearch_2']."%' "; 
        }

        $store_id = !empty($get['store_id'])?$get['store_id']:0;
        $fyear = !empty($get['fiscal_year'])?$get['fiscal_year']:CUR_FISCALYEAR;
       // $apstatus=!empty($get['appstatus'])?$get['appstatus']:4;
        $locationid = !empty($get['locationid'])?$get['locationid']:$this->session->userdata(LOCATION_ID);

        if($locationid)
        {
            $whr .=" AND kd.sade_locationid= $locationid"; 
        }
      
        if($store_id)
        {
            $whr .=" AND kd.storeid= ".$store_id."";    
        }
          if($fyear)
        {
            // kd.fiscalyrs= "074/75"
            // $whr .=" AND kd.fiscalyrs= '".$fyear."'"; 
        }
        $sql ="SELECT
                COUNT(*) AS cnt from
                (
                SELECT
                    kd.sade_itemsid,
                    il.itli_itemname,
                    il.itli_itemcode
                FROM
                    xw_vw_depwiseitemissue kd
                LEFT JOIN xw_itli_itemslist il ON il.itli_itemlistid = kd.sade_itemsid
                AND kd.sade_itemsid IS NOT NULL
                $whr
                GROUP BY 
                kd.sade_itemsid
                ) as k";
        $query=$this->db->query($sql);
        //echo $this->db->last_query();die();
        if($query->num_rows() > 0) 
        {
            $data=$query->row();     
            $totalfilteredrecs=  $data->cnt;       
        }
        $order_by = 'il.itli_itemname';
        $order = 'asc';
  
      
        if($this->input->get('iSortCol_0')==1)
            $order_by = 'il.itli_itemcode';
        else if($this->input->get('iSortCol_0')==2)
            $order_by = 'il.itli_itemname';           
        
        $totalrecs='';
        $limit = 15;
        $offset = 1;
        $get = $_GET;
        if($this->input->get('sSortDir_0'))
        {
                $order = $this->input->get('sSortDir_0');
        }
 
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }
      
        if(!empty($_GET["iDisplayLength"])){
           $limit = $_GET['iDisplayLength'];
           $offset = $_GET["iDisplayStart"];
        }
        $sql1 ="SELECT
                    kd.sade_itemsid,il.itli_itemname,il.itli_itemcode,
                    monthlywiseitem_issue(sade_itemsid, $locationid, $store_id,'$fyear', 4) mdrk4,
                    monthlywiseitem_issue(sade_itemsid, $locationid, $store_id,'$fyear', 5) mdrk5,
                    monthlywiseitem_issue(sade_itemsid, $locationid, $store_id,'$fyear', 6) mdrk6,
                    monthlywiseitem_issue(sade_itemsid, $locationid, $store_id,'$fyear', 7) mdrk7,
                    monthlywiseitem_issue(sade_itemsid, $locationid, $store_id,'$fyear', 8) mdrk8,
                    monthlywiseitem_issue(sade_itemsid, $locationid, $store_id,'$fyear', 9) mdrk9,
                    monthlywiseitem_issue(sade_itemsid, $locationid, $store_id,'$fyear', 10) mdrk10,
                    monthlywiseitem_issue(sade_itemsid, $locationid, $store_id,'$fyear', 11) mdrk11,
                    monthlywiseitem_issue(sade_itemsid, $locationid, $store_id,'$fyear', 12) mdrk12,
                    monthlywiseitem_issue(sade_itemsid, $locationid, $store_id,'$fyear', 1) mdrk1,
                    monthlywiseitem_issue(sade_itemsid, $locationid, $store_id,'$fyear', 2) mdrk2,
                    monthlywiseitem_issue(sade_itemsid, $locationid, $store_id,'$fyear', 3) mdrk3
                FROM
                    xw_vw_depwiseitemissue kd
                LEFT JOIN xw_itli_itemslist il ON il.itli_itemlistid = kd.sade_itemsid
                AND kd.sade_itemsid IS NOT NULL
                $whr
                GROUP BY
                    kd.sade_itemsid ";
                  
                   $table_name_session= $this->session->userdata('__ci_last_regenerate');

                  $sql2= 'INSERT INTO xw_temi_tempmonthlyissue '.$sql1;
           // echo $sql2;
           // die();
        $nquery=$this->db->query($sql2); 
     
    }
  public function get_item_wise_data_tempdatble()
    {
         $table_name_session= $this->session->userdata('__ci_last_regenerate');
         $newtbl=$table_name_session.'_monthly_issue ';

        $get = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }
        $whr='';
        if(!empty($get['sSearch_1'])){
          
            $whr .=" AND itli_itemcode like  '%".$get['sSearch_1']."%' "; 
        }
        if(!empty($get['sSearch_2'])){
          
            $whr .=" AND itli_itemname like  '%".$get['sSearch_2']."%' OR itli_itemnamenp like  '%".$get['sSearch_2']."%' "; 
        }

        $store_id = !empty($get['store_id'])?$get['store_id']:0;
        $fyear = !empty($get['fiscal_year'])?$get['fiscal_year']:CUR_FISCALYEAR;
       // $apstatus=!empty($get['appstatus'])?$get['appstatus']:4;
        $locationid = !empty($get['locationid'])?$get['locationid']:$this->session->userdata(LOCATION_ID);

        if($locationid)
        {
            $whr .=" AND sade_locationid= $locationid"; 
        }
      
        if($store_id)
        {
            $whr .=" AND storeid= ".$store_id."";    
        }
          if($fyear)
        {
            // kd.fiscalyrs= "074/75"
            // $whr .=" AND kd.fiscalyrs= '".$fyear."'"; 
        }
        $sql ="SELECT
                COUNT(*) AS cnt from
                xw_temi_tempmonthlyissue  ";
        $query=$this->db->query($sql);
        //echo $this->db->last_query();die();
        if($query->num_rows() > 0) 
        {
            $data=$query->row();     
            $totalfilteredrecs=  $data->cnt;       
        }
        $order_by = 'itli_itemname';
        $order = 'asc';
  
      
        if($this->input->get('iSortCol_0')==1)
            $order_by = 'itli_itemcode';
        else if($this->input->get('iSortCol_0')==2)
            $order_by = 'itli_itemname';           
        
        $totalrecs='';
        $limit = 15;
        $offset = 1;
        $get = $_GET;
        if($this->input->get('sSortDir_0'))
        {
                $order = $this->input->get('sSortDir_0');
        }
 
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }
      
        if(!empty($_GET["iDisplayLength"])){
           $limit = $_GET['iDisplayLength'];
           $offset = $_GET["iDisplayStart"];
        }
        $sql1 ="SELECT
                    sade_itemsid,itli_itemname,itli_itemcode,
                    mdrk4,
                    mdrk5,
                    mdrk6,
                    mdrk7,
                    mdrk8,
                    mdrk9,
                    mdrk10,
                    mdrk11,
                    mdrk12,
                    mdrk1,
                    mdrk2,
                    mdrk3
                FROM
                    xw_temi_tempmonthlyissue WHERE sade_itemsid IS NOT NULL $whr
                 ORDER BY $order_by $order LIMIT $limit OFFSET $offset";
             
           
        $nquery=$this->db->query($sql1); 
        // echo $this->db->last_query();die();
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

    public function get_item_wise_data()
    {
        $get = $_GET;
        foreach ($get as $key => $value) 
        {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }
        $whr='';
        if(!empty($get['sSearch_1']))
        {
          
            $whr .=" AND  il.itli_itemcode like  '%".$get['sSearch_1']."%' "; 
        }
        if(!empty($get['sSearch_2']))
        {
          
            $whr .=" AND  il.itli_itemname like  '%".$get['sSearch_2']."%' OR itli_itemnamenp like  '%".$get['sSearch_2']."%' "; 
        }

        $store_id = !empty($get['store_id'])?$get['store_id']:0;
        $fyear = !empty($get['fiscal_year'])?$get['fiscal_year']:CUR_FISCALYEAR;

        // $locationid = !empty($get['locationid'])?$get['locationid']:$this->session->userdata(LOCATION_ID);

        // if($locationid)
        // {
        //     $whr .=" AND kd.sade_locationid= $locationid"; 
        // }
          $input_locationid= !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');
      
          if($this->location_ismain=='Y')
          {
            if($input_locationid)
            {
                $whr .=" AND kd.sade_locationid= $input_locationid";
            }
        }
        else
        {
              $whr .=" AND kd.sade_locationid= $input_locationid";
        }
      
      
        if($store_id)
        {
            $whr .=" AND kd.storeid= ".$store_id."";    
        }
          if($fyear)
        {
            // kd.fiscalyrs= "074/75"
            // $whr .=" AND kd.fiscalyrs= '".$fyear."'"; 
        }
        $sql ="SELECT
                COUNT(*) AS cnt from
                (
                SELECT
                    kd.sade_itemsid,
                    il.itli_itemname,
                    il.itli_itemcode
                FROM
                    xw_vw_depwiseitemissue kd
                LEFT JOIN xw_itli_itemslist il ON il.itli_itemlistid = kd.sade_itemsid
                AND kd.sade_itemsid IS NOT NULL
                $whr
                GROUP BY 
                kd.sade_itemsid
                ) as k";
        $query=$this->db->query($sql);
        //echo $this->db->last_query();die();
        if($query->num_rows() > 0) 
        {
            $data=$query->row();     
            $totalfilteredrecs=  $data->cnt;       
        }
        $order_by = 'il.itli_itemname';
        $order = 'asc';
  
      
        if($this->input->get('iSortCol_0')==1)
            $order_by = 'il.itli_itemcode';
        else if($this->input->get('iSortCol_0')==2)
            $order_by = 'il.itli_itemname';           
        
        $totalrecs='';
        $limit = 15;
        $offset = 1;
        $get = $_GET;
        if($this->input->get('sSortDir_0'))
        {
                $order = $this->input->get('sSortDir_0');
        }
 
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }
      
        if(!empty($_GET["iDisplayLength"])){
           $limit = $_GET['iDisplayLength'];
           $offset = $_GET["iDisplayStart"];
        }
        // echo "aaa";die;
        $sql1 ="SELECT kd.sade_itemsid,il.itli_itemname,il.itli_itemcode,
                    monthlywiseitem_issue(sade_itemsid, $input_locationid, $store_id,'$fyear', 4) mdrk4,
                    monthlywiseitem_issue(sade_itemsid, $input_locationid, $store_id,'$fyear', 5) mdrk5,
                    monthlywiseitem_issue(sade_itemsid, $input_locationid, $store_id,'$fyear', 6) mdrk6,
                    monthlywiseitem_issue(sade_itemsid, $input_locationid, $store_id,'$fyear', 7) mdrk7,
                    monthlywiseitem_issue(sade_itemsid, $input_locationid, $store_id,'$fyear', 8) mdrk8,
                    monthlywiseitem_issue(sade_itemsid, $input_locationid, $store_id,'$fyear', 9) mdrk9,
                    monthlywiseitem_issue(sade_itemsid, $input_locationid, $store_id,'$fyear', 10) mdrk10,
                    monthlywiseitem_issue(sade_itemsid, $input_locationid, $store_id,'$fyear', 11) mdrk11,
                    monthlywiseitem_issue(sade_itemsid, $input_locationid, $store_id,'$fyear', 12) mdrk12,
                    monthlywiseitem_issue(sade_itemsid, $input_locationid, $store_id,'$fyear', 1) mdrk1,
                    monthlywiseitem_issue(sade_itemsid, $input_locationid, $store_id,'$fyear', 2) mdrk2,
                    monthlywiseitem_issue(sade_itemsid, $input_locationid, $store_id,'$fyear', 3) mdrk3
                FROM
                    xw_vw_depwiseitemissue kd
                LEFT JOIN xw_itli_itemslist il ON il.itli_itemlistid = kd.sade_itemsid
                AND kd.sade_itemsid IS NOT NULL
                $whr
                GROUP BY
                    kd.sade_itemsid  ORDER BY $order_by $order LIMIT $limit OFFSET $offset";
             
         // echo $sql1;
         // die();
        $nquery=$this->db->query($sql1); 
        //echo $this->db->last_query();die();
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
    public function get_monthlywise_item_issue($cond)
    {   
        $id = $this->input->post('id');
        $fiscalyear = $this->input->post('fiscal_year');
        $store_id = $this->input->post('store_id');
        $locationid = $this->input->post('location');
        $this->db->select('kd.*,d.dept_depname,d.dept_depid');
        $this->db->from('vw_depwiseitemissue kd');
        $this->db->join('dept_department d','d.dept_depid = kd.sama_depid','left');
        if($cond){
            $this->db->where($cond);
        }
        //$this->db->group_by('d.dept_depid');
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        if($query->num_rows() > 0){
            $result = $query->result();
            return $result;
        }
        return false;
    }

    public function get_details_issue($srchcol)
    {
        $this->db->select('sm.sama_receivedby,sm.sama_invoiceno,sm.sama_username,sm.sama_fyear,sm.sama_billdatead,sm.sama_billdatebs,rd.sade_unit,rd.sade_curqty,rd.sade_unitrate,it.itli_itemcode,it.itli_itemname,ut.unit_unitname');
        $this->db->from('sade_saledetail rd');
        $this->db->join('sama_salemaster sm','sm.sama_salemasterid = rd.sade_salemasterid','left');
        $this->db->join('itli_itemslist it','it.itli_itemlistid = rd.sade_itemsid','left');
        $this->db->join('unit_unit ut','it.itli_unitid = ut.unit_unitid','left');
        if($srchcol){
            $this->db->where($srchcol);
        }
        $this->db->where('sade_iscancel', 'N');
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        if($query->num_rows() > 0){
            $result = $query->result();
            return $result;
        }
        return false;
    }
}