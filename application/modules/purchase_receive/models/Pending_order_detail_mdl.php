<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pending_order_detail_mdl extends CI_Model 
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
            $this->locationid=$this->session->userdata(LOCATION_ID);
        $this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
	}
	public $validate_settings_distributors = array(               
        array('field' => 'dist_distributor', 'label' => 'Distributor Name', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'dist_phone1', 'label' => 'Phone 1', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'dist_email', 'label' => 'Email', 'rules' => 'trim|valid_email|xss_clean'),
        array('field' => 'dist_repemail', 'label' => 'Sales Resp. Email', 'rules' => 'trim|valid_email|xss_clean')
	);

	public function get_pending_order_detail_list($cond = false)
	{
		$get = $_GET;
      	foreach ($get as $key => $value) {
        	$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
      	}

        if(!empty($get['sSearch_1'])){
            $this->db->where("supp_suppliername like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("puor_orderno like  '%".$get['sSearch_2']."%'  ");
        }

        if(!empty($get['sSearch_3'])){
            $this->db->where("itli_itemcode like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            // $this->db->where("itli_itemname like  '%".$get['sSearch_4']."%'  ");
              $this->db->where("itli_itemname like  '%".$get['sSearch_4']."%' OR itli_itemnamenp like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("pude_quantity like  '%".$get['sSearch_5']."%'  ");
        }
        if(!empty($get['sSearch_6'])){
            $this->db->where("pude_remqty like  '%".$get['sSearch_6']."%'  ");
        }

        if(!empty($get['sSearch_7'])){
            $this->db->where("pude_rate like  '%".$get['sSearch_7']."%'  ");
        }

        if(!empty($get['sSearch_8'])){
            $this->db->where("pude_vat like  '%".$get['sSearch_8']."%'  ");
        }
        
        if(!empty($get['sSearch_9'])){
            $this->db->where("pude_discount like  '%".$get['sSearch_9']."%'  ");
        }
        
        if(!empty($get['sSearch_10'])){
            $this->db->where("pude_amount like  '%".$get['sSearch_10']."%'  ");
        }

        if(!empty($get['sSearch_11'])){
            $this->db->where("puor_orderdatebs like  '%".$get['sSearch_11']."%'  ");
        }

        if(!empty($get['sSearch_12'])){
            $this->db->where("puor_deliverydatebs like  '%".$get['sSearch_12']."%'  ");
        }

        if(!empty($get['sSearch_13'])){
            $this->db->where("puor_approvedby like  '%".$get['sSearch_13']."%'  ");
        }
        
        if($cond) {
            $this->db->where($cond);
        }
        $locationid= !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');
    if($this->location_ismain=='Y'){
       if(!empty($locationid))
        {
            $this->db->where('pod.pude_locationid',$locationid);
        }
        }else{
            $this->db->where('pod.pude_locationid',$this->locationid);

        }

        $resltrpt=$this->db->select("COUNT(*) as cnt")
                    ->from('pude_purchaseorderdetail pod')
                    ->join('itli_itemslist il','il.itli_itemlistid = pod.pude_itemsid')
                    ->join('puor_purchaseordermaster pom','pom.puor_purchaseordermasterid = pod.pude_purchasemasterid')
                    ->join('dist_distributors s','s.dist_distributorid = pom.puor_supplierid')
                    ->where('puor_purchased !=',2)
                    ->where('puor_status !=','C')
                    ->where('pude_remqty >',0)
                    ->get()
                    ->row();

      	// echo $this->db->last_query();die(); 
      	$totalfilteredrecs=$resltrpt->cnt; 

        $order_by = 'puor_deliverydatebs';
        $order = 'desc';

      	if($this->input->get('sSortDir_0'))
  		{
  			$order = $this->input->get('sSortDir_0');
  		}
  
      	$where='';
      	if($this->input->get('iSortCol_0')==1)
        	$order_by = 'supp_suppliername';
      	else if($this->input->get('iSortCol_0')==2)
       		$order_by = 'puor_orderno';
       	else if($this->input->get('iSortCol_0')==3)
      	 	$order_by = 'itli_itemcode';
      	else if($this->input->get('iSortCol_0')==4)
      	 	$order_by = 'itli_itemname';
      	else if($this->input->get('iSortCol_0')==5)
      	 	$order_by = 'pude_quantity';
      	else if($this->input->get('iSortCol_0')==6)
      	 	$order_by = 'pude_remqty';
        else if($this->input->get('iSortCol_0')==7)
            $order_by = 'pude_rate';
        else if($this->input->get('iSortCol_0')==8)
            $order_by = 'pude_vat';
        else if($this->input->get('iSortCol_0')==9)
            $order_by = 'pude_discount';
        else if($this->input->get('iSortCol_0')==10)
            $order_by = 'pude_amount';
        else if($this->input->get('iSortCol_0')==11)
            $order_by = 'puor_orderdatebs';
        else if($this->input->get('iSortCol_0')==12)
            $order_by = 'puor_deliverydatebs';
        else if($this->input->get('iSortCol_0')==13)
            $order_by = 'puor_approvedby';
        
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
            $this->db->where("supp_suppliername like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("puor_orderno like  '%".$get['sSearch_2']."%'  ");
        }

        if(!empty($get['sSearch_3'])){
            $this->db->where("itli_itemcode like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            // $this->db->where("itli_itemname like  '%".$get['sSearch_4']."%'  ");
            $this->db->where("itli_itemname like  '%".$get['sSearch_4']."%' OR itli_itemnamenp like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("pude_quantity like  '%".$get['sSearch_5']."%'  ");
        }
        if(!empty($get['sSearch_6'])){
            $this->db->where("pude_remqty like  '%".$get['sSearch_6']."%'  ");
        }

        if(!empty($get['sSearch_7'])){
            $this->db->where("pude_rate like  '%".$get['sSearch_7']."%'  ");
        }

        if(!empty($get['sSearch_8'])){
            $this->db->where("pude_vat like  '%".$get['sSearch_8']."%'  ");
        }
        
        if(!empty($get['sSearch_9'])){
            $this->db->where("pude_discount like  '%".$get['sSearch_9']."%'  ");
        }
        
        if(!empty($get['sSearch_10'])){
            $this->db->where("pude_amount like  '%".$get['sSearch_10']."%'  ");
        }

        if(!empty($get['sSearch_11'])){
            $this->db->where("puor_orderdatebs like  '%".$get['sSearch_11']."%'  ");
        }

        if(!empty($get['sSearch_12'])){
            $this->db->where("puor_deliverydatebs like  '%".$get['sSearch_12']."%'  ");
        }

        if(!empty($get['sSearch_13'])){
            $this->db->where("puor_approvedby like  '%".$get['sSearch_13']."%'  ");
        }
       
        if($cond) {
          $this->db->where($cond);
        }
        if($this->location_ismain=='Y'){
       if(!empty($locationid))
        {
            $this->db->where('pod.pude_locationid',$locationid);
        }
        }else{
            $this->db->where('pod.pude_locationid',$this->locationid);

        }


        $this->db->select('pom.puor_deliverydatebs as deliverydate, pom.puor_orderno as orderno, pom.puor_orderdatebs as orderdate, pom.puor_deliverysite as deliversite, pod.pude_amount as purchaseamount, pom.puor_approvedby as approvedby, il.itli_itemname as itemname,il.itli_itemnamenp as itemnamenp, il.itli_itemcode as itemcode, pod.pude_quantity as quantity, pod.pude_remqty as remquantity, pod.pude_rate as rate, pod.pude_discount as discount, pod.pude_vat as vat, pod.pude_free as free, s.dist_distributor as suppliername');
        $this->db->from('pude_purchaseorderdetail pod');
        $this->db->join('puor_purchaseordermaster pom','pom.puor_purchaseordermasterid = pod.pude_purchasemasterid');
        $this->db->join('itli_itemslist il','il.itli_itemlistid = pod.pude_itemsid');
        $this->db->join('dist_distributors s','s.dist_distributorid = pom.puor_supplierid');
        $this->db->where('puor_purchased !=',2);
        $this->db->where('pom.puor_status !=','C');
        $this->db->where('pude_remqty >',0);
    
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

    public function approve_quotation(){
        $qdetailid = $this->input->post('qdetailid');
        $itemsid = $this->input->post('itemsid');
        $fyear = $this->input->post('fyear');

        $approveArray = array(
                            'teap_itemsid'=>$itemsid,
                            'teap_qdetailid'=>$qdetailid,
                            'teap_approveddatead'=>CURDATE_EN,
                            'teap_approveddatebs'=>CURDATE_NP,
                            'teap_approvedtime'=>$this->curtime,
                            'teap_fyear'=>$fyear,
                            'teap_postedby'=>$this->userid,
                            'teap_postedmac'=>$this->mac,
                            'teap_postedip'=>$this->ip
                        );

        if($approveArray){
            $insert = $this->db->insert($this->approveTable, $approveArray);
            return $insert;
        }
        return false;
    }

    public function get_tender_approved($srchcol = false){
        try{
            $this->db->select('*');
            $this->db->from($this->approveTable);
            if($srchcol){
                $this->db->where($srchcol);
            }
            $query = $this->db->get();
            if($query->num_rows() > 0){
                $result = $query->result();
                return $result;
            }
        }catch(Exception $e){
            throw $e;
        }
    }

    public function undo_approve_quotation(){
        $qdetailid = $this->input->post('qdetailid');
        $remarks = $this->input->post('remarks');

        if($qdetailid && $remarks){
            $this->db->trans_begin();
            $undoArray = array(
                            'qude_remarks'=>$remarks,
                            'qude_modifyby'=>$this->userid,
                            'qude_modifydatebs'=>CURDATE_NP,
                            'qude_modifydatead'=>CURDATE_EN,
                            'qude_modifytime'=>$this->curtime,
                            'qude_modifymac'=>$this->mac,
                            'qude_modifyip'=>$this->ip
                        );

            $this->db->where('qude_quotationdetailid', $qdetailid);
            $undo = $this->db->update($this->quotation_detail, $undoArray);

            $this->db->where('teap_qdetailid',$qdetailid);
            $delete = $this->db->delete($this->approveTable);

            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                return false;
            }
            else{
                $this->db->trans_commit();
                return true;
            }
        }

        return false;
    }

    public function get_purchase_detail_by_id($srchcol = false){
        try{
            $this->db->select('il.itli_itemname as itemname, il.itli_itemnamenp as itemnamenp, il.itli_itemcode as itemcode, pod.pude_quantity as quantity, pod.pude_remqty as remquantity, pod.pude_rate as rate, pod.pude_discount as discount, pod.pude_vat as vat, pod.pude_free as free');
            $this->db->from('pude_purchaseorderdetail pod');
            $this->db->join('itli_itemslist il','il.itli_itemlistid = pod.pude_itemsid');
            $this->db->where('pod.pude_status !=','C');
            if($srchcol){
                $this->db->where($srchcol);
            }
            $this->db->order_by('il.itli_itemname','asc');
            $query = $this->db->get();

            if($query->num_rows() >0){
                $result = $query->result();
                return $result;
            }
        }catch(Exception $e){
            throw $e;
        }
    }
}