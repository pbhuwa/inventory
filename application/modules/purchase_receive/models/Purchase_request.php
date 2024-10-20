<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Purchase_request_mdl extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
        $this->approveTable = 'teap_tenderapproved';
        $this->quotation_detail = 'qude_quotationdetail';

        $this->curtime = $this->general->get_currenttime();
        $this->userid = $this->session->userdata(USER_ID);
        $this->mac = $this->general->get_Mac_Address();
        $this->ip = $this->general->get_real_ipaddr();
	}
	public $validate_settings_distributors = array(               
        array('field' => 'dist_distributor', 'label' => 'Distributor Name', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'dist_phone1', 'label' => 'Phone 1', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'dist_email', 'label' => 'Email', 'rules' => 'trim|valid_email|xss_clean'),
        array('field' => 'dist_repemail', 'label' => 'Sales Resp. Email', 'rules' => 'trim|valid_email|xss_clean')
	);

	public function get_pending_order_list($cond = false)
	{
		$get = $_GET;
      	foreach ($get as $key => $value) {
        	$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
      	}

        if(!empty($get['sSearch_1'])){
            $this->db->where("itli_itemcode like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("itli_itemname like  '%".$get['sSearch_2']."%'  ");
        }

        if(!empty($get['sSearch_3'])){
            $this->db->where("supp_suppliername like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("recm_receiveddatebs like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("puor_no like  '%".$get['sSearch_5']."%'  ");
        }
        if(!empty($get['sSearch_6'])){
            $this->db->where("pude_quantity like  '%".$get['sSearch_6']."%'  ");
        }

        if(!empty($get['sSearch_7'])){
            $this->db->where("pude_rate like  '%".$get['sSearch_7']."%'  ");
        }

        if(!empty($get['sSearch_8'])){
            $this->db->where("pude_remarks like  '%".$get['sSearch_8']."%'  ");
        }
        
        if($cond) {
            $this->db->where($cond);
        }

        $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');
        $toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');

        if(!empty(($frmDate && $toDate)))
        {
            $this->db->where('recm_receiveddatebs >=',$frmDate);
            $this->db->where('recm_receiveddatebs <=',$toDate);
        }

        $resltrpt=$this->db->select("COUNT(*) as cnt")
                    ->from('puor_purchasorderemaster pom')
                    ->join('supp_supplier s','s.supp_supplierid = pom.puor_dist_id')
                    ->where('puor_purchased !=',2)
                    ->where('puor_status !=','C')
                    ->get()
                    ->row();

      	// echo $this->db->last_query();die(); 
      	$totalfilteredrecs=$resltrpt->cnt; 

      	$order_by = 'itli_itemname';
      	$order = 'asc';
      	if($this->input->get('sSortDir_0'))
  		{
  				$order = $this->input->get('sSortDir_0');
  		}
  
      	$where='';
      	if($this->input->get('iSortCol_0')==1)
        	$order_by = 'itli_itemcode';
      	else if($this->input->get('iSortCol_0')==2)
       		$order_by = 'itli_itemname';
       	else if($this->input->get('iSortCol_0')==3)
      	 	$order_by = 'supp_suppliername';
      	else if($this->input->get('iSortCol_0')==4)
      	 	$order_by = 'recm_receiveddatebs';
      	else if($this->input->get('iSortCol_0')==5)
      	 	$order_by = 'puor_no';
      	else if($this->input->get('iSortCol_0')==6)
      	 	$order_by = 'pude_quantity';
        else if($this->input->get('iSortCol_0')==7)
            $order_by = 'pude_rate';
        else if($this->input->get('iSortCol_0')==8)
            $order_by = 'pude_remarks';
        
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
            $this->db->where("itli_itemcode like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("itli_itemname like  '%".$get['sSearch_2']."%'  ");
        }

        if(!empty($get['sSearch_3'])){
            $this->db->where("supp_suppliername like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("recm_receiveddatebs like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("puor_no like  '%".$get['sSearch_5']."%'  ");
        }
        if(!empty($get['sSearch_6'])){
            $this->db->where("pude_quantity like  '%".$get['sSearch_6']."%'  ");
        }

        if(!empty($get['sSearch_7'])){
            $this->db->where("pude_rate like  '%".$get['sSearch_7']."%'  ");
        }

        if(!empty($get['sSearch_8'])){
            $this->db->where("pude_remarks like  '%".$get['sSearch_8']."%'  ");
        }
       
        if($cond) {
          $this->db->where($cond);
        }

        $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');
        $toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');

        if(!empty(($frmDate && $toDate)))
        {
            $this->db->where('recm_receiveddatebs >=',$frmDate);
            $this->db->where('recm_receiveddatebs <=',$toDate);
        }

        $this->db->select('pom.*,s.supp_suppliername');
        $this->db->from('puor_purchasorderemaster pom');
        $this->db->join('supp_supplier s','s.supp_supplierid = pom.puor_dist_id');
        $this->db->where('puor_purchased !=',2);
        $this->db->where('puor_status !=','C');
    
        if(!empty($order_by) && !empty($order)){
            $order_by = 'puor_del_datebs';
            $order = 'desc';
        }
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

        // echo $this->db->last_query();
        // die();
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