<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Debit_note_mdl extends CI_Model
{
  public function __construct()
    {
        parent::__construct(); 
        $this->locationid=$this->session->userdata(LOCATION_ID);
        $this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
        $this->orgid=$this->session->userdata(ORG_ID);
    }
    
    
    public function get_debit_note_list($cond = false)
	{
		$get = $_GET;
      	foreach ($get as $key => $value) {
        	$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
      	}

        if(!empty($get['sSearch_1'])){
            $this->db->where("purr_returnno like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("purr_returndatebs like  '%".$get['sSearch_2']."%'  ");
        }

        if(!empty($get['sSearch_3'])){
            $this->db->where("dist_distributor like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("purr_returnamount like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("purr_discount like  '%".$get['sSearch_5']."%'  ");
        }

        if(!empty($get['sSearch_6'])){
            $this->db->where("purr_vatamount like  '%".$get['sSearch_6']."%'  ");
        }
		    if(!empty($get['sSearch_7'])){
            $this->db->where("purr_returnby like  '%".$get['sSearch_7']."%'  ");
        }
         $locationid= !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');
         if($this->location_ismain=='Y'){
       if(!empty($locationid))
        {
            $this->db->where('p.purr_locationid',$locationid);
        }
        }else{
            $this->db->where('p.purr_locationid',$this->locationid);

        }
       
        
        if($cond) {
            $this->db->where($cond);
        }
        $fyear = !empty($get['fyear'])?$get['fyear']:$this->input->post('fyear');
        $store_id = !empty($get['store_id'])?$get['store_id']:$this->input->post('store_id');
       
        $resltrpt=$this->db->select("COUNT(*) as cnt")
                  ->from('purr_purchasereturn p ')
                	->join('dist_distributors d','d.dist_distributorid = p.purr_purchasereturnid')
                  ->get()
                  ->row();
      	// echo $this->db->last_query();die(); 
      	$totalfilteredrecs=$resltrpt->cnt; 

      	$order_by = 'p.purr_returndatebs';
      	$order = 'DESC';
      	if($this->input->get('sSortDir_0'))
  		{
  				$order = $this->input->get('sSortDir_0');
  		}
  
      	$where='';
      	if($this->input->get('iSortCol_0')==1)
        	$order_by = 'purr_returnno';
      	else if($this->input->get('iSortCol_0')==2)
       		$order_by = 'purr_returndatebs';
       	else if($this->input->get('iSortCol_0')==3)
      	 	$order_by = 'dist_distributor';
      	else if($this->input->get('iSortCol_0')==4)
      	 	$order_by = 'purr_returnamount';
      	else if($this->input->get('iSortCol_0')==5)
      	 	$order_by = 'purr_discount';
        else if($this->input->get('iSortCol_0')==6)
            $order_by = 'purr_vatamount';
        else if($this->input->get('iSortCol_0')==7)
            $order_by = 'purr_returnby';
           else if($this->input->get('iSortCol_0')==8)
            $order_by = 'netamount';
        
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

        if(!empty($get['sSearch_1'])){
            $this->db->where("purr_returnno like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("purr_returndatebs like  '%".$get['sSearch_2']."%'  ");
        }

        if(!empty($get['sSearch_3'])){
            $this->db->where("dist_distributor like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("purr_returnamount like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("purr_discount like  '%".$get['sSearch_5']."%'  ");
        }

        if(!empty($get['sSearch_6'])){
            $this->db->where("purr_vatamount like  '%".$get['sSearch_6']."%'  ");
        }
		    if(!empty($get['sSearch_7'])){
            $this->db->where("purr_returnby like  '%".$get['sSearch_7']."%'  ");
        }
        
       
        if($cond) {
           $this->db->where($cond);
           }
              $locationid= !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');
         if($this->location_ismain=='Y'){
       if(!empty($locationid))
        {
            $this->db->where('p.purr_locationid',$locationid);
        }
        }else{
            $this->db->where('p.purr_locationid',$this->locationid);

        }

        
         $this->db->select('d.dist_distributor,p.purr_returndatebs,p.purr_returnno,p.purr_returnby,p.purr_purchasereturnid,p.purr_receivedby,p.purr_returntime,p.purr_st,p.purr_returnamount,p.purr_discount,p.purr_vatamount, (p.purr_returnamount - p.purr_discount + p.purr_vatamount) as netamount,p.purr_locationid');
    	    $this->db->from('purr_purchasereturn p ');
          $this->db->join('dist_distributors d','d.dist_distributorid = p.purr_purchasereturnid');
          
          
        // if(!empty($order_by) && !empty($order)){
        //     $order_by = 'p.purr_returndatebs';
        //     $order = 'desc';
        // }
        $this->db->order_by($order_by,$order);
      

        if($limit && $limit>0)
        {  
            $this->db->limit($limit);
        }
        if($offset)
        {
            $this->db->offset($offset);
        }
      
        $nquery=$this->db->get();

       // echo $this->db->last_query(); die();
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
}