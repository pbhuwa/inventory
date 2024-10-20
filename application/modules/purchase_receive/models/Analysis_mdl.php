<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Analysis_mdl extends CI_Model 
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
    array('field' => 'dist_repemail', 'label' => 'Sales Resp. Email', 'rules' => 'trim|valid_email|xss_clean'  )
	);

	public function get_analysis_list($cond = false)
	{
		$get = $_GET;
      	foreach ($get as $key => $value) {
        	$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
      	}
     	if(!empty($get['sSearch_0'])){
            $this->db->where("quma_quotationmasterid like  '%".$get['sSearch_0']."%'  ");
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
            $this->db->where("quma_quotationdatebs like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("quma_quotationnumber like  '%".$get['sSearch_5']."%'  ");
        }
        if(!empty($get['sSearch_6'])){
            $this->db->where("qude_rate like  '%".$get['sSearch_6']."%'  ");
        }
        if(!empty($get['sSearch_7'])){
            $this->db->where("qude_discountpc like  '%".$get['sSearch_7']."%'  ");
        }
        if(!empty($get['sSearch_8'])){
            $this->db->where("qude_vatpc like  '%".$get['sSearch_8']."%'  ");
        }
        if(!empty($get['sSearch_9'])){
            $this->db->where("qude_netrate like  '%".$get['sSearch_9']."%'  ");
        }
        if(!empty($get['sSearch_10'])){
            $this->db->where("qude_remarks like  '%".$get['sSearch_10']."%'  ");
        }
        
        if($cond) {
            $this->db->where($cond);
        }
        
        if(!empty($get['searchByFiscalYear'])){
            $fiscalyear = $get['searchByFiscalYear'];
            $new_year = explode('/', $fiscalyear);

            $start_date = '2'.$new_year[0].'/04/01';
            $end_date = '20'.$new_year[1].'/03/31';

            $this->db->where('quma_quotationdatebs >=',$start_date);
            $this->db->where('quma_quotationdatebs <=', $end_date);
        }

        $resltrpt=$this->db->select("COUNT(*) as cnt")
  					->from('quma_quotationmaster qm')
  					->join('qude_quotationdetail qd','qd.qude_quotationmasterid = qm.quma_quotationmasterid')
  					->join('itli_itemslist t','t.itli_itemlistid = qd.qude_itemsid')
            ->join('supp_supplier s','s.supp_supplierid = qm.quma_supplierid')
  					->get()
  					->row(); 
      	//echo $this->db->last_query();die(); 
      	$totalfilteredrecs=$resltrpt->cnt; 

      	$order_by = 'quma_quotationmasterid';
      	$order = 'desc';
      	if($this->input->get('sSortDir_0'))
  		{
  				$order = $this->input->get('sSortDir_0');
  		}
  
      	$where='';
      	if($this->input->get('iSortCol_0')==0)
        	$order_by = 'quma_quotationmasterid';
      	else if($this->input->get('iSortCol_0')==1)
        	$order_by = 'itli_itemcode';
      	else if($this->input->get('iSortCol_0')==2)
       		$order_by = 'itli_itemname';
       	else if($this->input->get('iSortCol_0')==3)
      	 	$order_by = 'supp_suppliername';
      	else if($this->input->get('iSortCol_0')==4)
      	 	$order_by = 'quma_quotationdatebs';
      	else if($this->input->get('iSortCol_0')==5)
      	 	$order_by = 'quma_quotationnumber';
      	else if($this->input->get('iSortCol_0')==6)
      	 	$order_by = 'qude_rate';
      	else if($this->input->get('iSortCol_0')==7)
            $order_by = 'qude_discountpc';
        else if($this->input->get('iSortCol_0')==8)
            $order_by = 'qude_vatpc';
        else if($this->input->get('iSortCol_0')==9)
            $order_by = 'qude_netrate';
        else if($this->input->get('iSortCol_0')==10)
            $order_by = 'qude_remarks';
        
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
            $this->db->where("quma_quotationmasterid like  '%".$get['sSearch_0']."%'  ");
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
            $this->db->where("quma_quotationdatebs like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("quma_quotationnumber like  '%".$get['sSearch_5']."%'  ");
        } 
        if(!empty($get['sSearch_6'])){
            $this->db->where("qude_rate like  '%".$get['sSearch_6']."%'  ");
        }
        if(!empty($get['sSearch_7'])){
            $this->db->where("qude_discountpc like  '%".$get['sSearch_7']."%'  ");
        }
        if(!empty($get['sSearch_8'])){
            $this->db->where("qude_vatpc like  '%".$get['sSearch_8']."%'  ");
        }
        if(!empty($get['sSearch_9'])){
            $this->db->where("qude_netrate like  '%".$get['sSearch_9']."%'  ");
        }
        if(!empty($get['sSearch_10'])){
            $this->db->where("qude_remarks like  '%".$get['sSearch_10']."%'  ");
        }
       //  if($this->session->userdata(USER_ACCESS_TYPE)=='S')
      	// {
       //  	$this->db->where('dist_orgid',$this->session->userdata(ORG_ID));
      	// }
        if($cond) {
          $this->db->where($cond);
        }

        if(!empty($get['searchByFiscalYear'])){
            $fiscalyear = $get['searchByFiscalYear'];
            $new_year = explode('/', $fiscalyear);

            $start_date = '2'.$new_year[0].'/04/01';
            $end_date = '20'.$new_year[1].'/03/31';

            $this->db->where('quma_quotationdatebs >=',$start_date);
            $this->db->where('quma_quotationdatebs <=', $end_date);
        }

        $this->db->select('qm.*, qd.qude_quotationdetailid, qd.qude_rate,qd.qude_discountpc,qd.qude_vatpc,qd.qude_netrate, qude_remarks, t.itli_itemname, t.itli_itemcode, t.itli_itemlistid, s.supp_suppliername');
	    $this->db->from('quma_quotationmaster qm');
	    $this->db->join('qude_quotationdetail qd','qd.qude_quotationmasterid = qm.quma_quotationmasterid');
	    $this->db->join('itli_itemslist t','t.itli_itemlistid = qd.qude_itemsid');
        $this->db->join('supp_supplier s','s.supp_supplierid = qm.quma_supplierid');
 
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
}