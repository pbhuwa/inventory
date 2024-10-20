<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Purchase_detail_mdl extends CI_Model 
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

	public function get_purchase_detail_list($cond = false)
	{
		$get = $_GET;
      	foreach ($get as $key => $value) {
        	$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
      	}

        if(!empty($get['sSearch_1'])){
            $this->db->where("recm_receiveddatebs like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("recm_invoiceno like  '%".$get['sSearch_2']."%'  ");
        }

        if(!empty($get['sSearch_3'])){
            $this->db->where("recm_supplierbillno like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("itli_itemcode like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            // $this->db->where("itli_itemname like  '%".$get['sSearch_5']."%'  ");
              $this->db->where("itli_itemname like  '%".$get['sSearch_5']."%' OR itli_itemnamenp like  '%".$get['sSearch_5']."%'  ");
        }
        if(!empty($get['sSearch_6'])){
            $this->db->where("materialtypename like  '%".$get['sSearch_6']."%'  ");
        }

        if(!empty($get['sSearch_7'])){
            $this->db->where("categoryname like  '%".$get['sSearch_7']."%'  ");
        }

        if(!empty($get['sSearch_8'])){
            $this->db->where("supp_suppliername like  '%".$get['sSearch_8']."%'  ");
        }
        
        if($cond) {
            $this->db->where($cond);
        }

        $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');
        $toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');
    
     $locationid= !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');
    if($this->location_ismain=='Y'){
       if(!empty($locationid))
        {
            $this->db->where('recm_locationid',$locationid);
        }
        }else{
           $this->db->where('recm_locationid',$this->locationid);

        }

        

        if($frmDate &&  $toDate){
            if(DEFAULT_DATEPICKER=='NP')
            {
              $this->db->where('recm_receiveddatebs >=', $frmDate);
              $this->db->where('recm_receiveddatebs <=', $toDate);
            }
            else
            {
              $this->db->where('recm_receiveddatead >=', $frmDate);
              $this->db->where('recm_receiveddatead <=', $toDate);
            }
        }


        $resltrpt=$this->db->select("COUNT(*) as cnt")
                    ->from('recm_receivedmaster rm')
                    ->join('recd_receiveddetail rd','rm.recm_receivedmasterid = rd.recd_receivedmasterid','left')
                    ->join('itli_itemslist il','rd.recd_itemsid = il.itli_itemlistid','left')
                    ->join('dist_distributors s','rm.recm_supplierid = s.dist_distributorid','left')
                    ->join('maty_materialtype mt','il.itli_typeid = mt.maty_materialtypeid','left')
                    ->join('eqca_equipmentcategory c','itli_catid = c.eqca_equipmentcategoryid','left')
                    ->join('unit_unit u','il.itli_unitid = u.unit_unitid','left')
                    ->get()
                    ->row();

      	// echo $this->db->last_query();die(); 
      	$totalfilteredrecs=$resltrpt->cnt; 

      	$order_by = 'recm_invoiceno';
      	$order = 'asc';
      	if($this->input->get('sSortDir_0'))
  		{
  				$order = $this->input->get('sSortDir_0');
  		}
  
      	$where='';
      	if($this->input->get('iSortCol_0')==1)
        	$order_by = 'recm_receiveddatebs';
      	else if($this->input->get('iSortCol_0')==2)
       		$order_by = 'recm_invoiceno';
       	else if($this->input->get('iSortCol_0')==3)
      	 	$order_by = 'recm_supplierbillno';
      	else if($this->input->get('iSortCol_0')==4)
      	 	$order_by = 'itli_itemcode';
      	else if($this->input->get('iSortCol_0')==5)
      	 	$order_by = 'itli_itemname';
      	else if($this->input->get('iSortCol_0')==6)
      	 	$order_by = 'materialtypename';
        else if($this->input->get('iSortCol_0')==7)
            $order_by = 'categoryname';
        else if($this->input->get('iSortCol_0')==8)
            $order_by = 'supp_suppliername';
        else if($this->input->get('iSortCol_0')==9)
            $order_by = 'recm_purchaseorderno';
        else if($this->input->get('iSortCol_0')==10)
            $order_by = 'recd_purchasedqty';
        else if($this->input->get('iSortCol_0')==11)
            $order_by = 'unit_unitname';
        else if($this->input->get('iSortCol_0')==12)
            $order_by = 'recd_unitprice';
        else if($this->input->get('iSortCol_0')==13)
            $order_by = 'recd_discountpc';
        else if($this->input->get('iSortCol_0')==14)
            $order_by = 'recd_vatpc';
         else if($this->input->get('iSortCol_0')==16)
            $order_by = 'recd_amount';
         else if($this->input->get('iSortCol_0')==17)
            $order_by = 'itli_remarks';
        
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
            $this->db->where("recm_receiveddatebs like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("recm_invoiceno like  '%".$get['sSearch_2']."%'  ");
        }

        if(!empty($get['sSearch_3'])){
            $this->db->where("recm_supplierbillno like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("itli_itemcode like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("itli_itemname like  '%".$get['sSearch_5']."%' OR itli_itemnamenp like  '%".$get['sSearch_5']."%'  ");
        }
        if(!empty($get['sSearch_6'])){
            $this->db->where("materialtypename like  '%".$get['sSearch_6']."%'  ");
        }

        if(!empty($get['sSearch_7'])){
            $this->db->where("categoryname like  '%".$get['sSearch_7']."%'  ");
        }

        if(!empty($get['sSearch_8'])){
            $this->db->where("supp_suppliername like  '%".$get['sSearch_8']."%'  ");
        }
       
        if($cond) {
          $this->db->where($cond);
        }

        $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');
        $toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');
          $locationid = !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');
      if($this->location_ismain=='Y'){
       if(!empty($locationid))
        {
            $this->db->where('recm_locationid',$locationid);
        }
        }else{
           $this->db->where('recm_locationid',$this->locationid);

        }


        if($frmDate &&  $toDate){
            if(DEFAULT_DATEPICKER=='NP')
            {
              $this->db->where('recm_receiveddatebs >=', $frmDate);
              $this->db->where('recm_receiveddatebs <=', $toDate);
            }
            else
            {
              $this->db->where('recm_receiveddatead >=', $frmDate);
              $this->db->where('recm_receiveddatead <=', $toDate);
            }
        }

        $this->db->select('rd.recd_controlno, rm.recm_receiveddatead, rm.recm_receiveddatebs, rm.recm_supplierbillno, rm.recm_purchaseorderno, rd.recd_salerate, rd.recd_arate as netrate, rd.recd_unitprice, rm.recm_invoiceno, il.itli_itemname,il.itli_itemnamenp, il.itli_itemcode, il.itli_remarks, rd.recd_purchasedqty, rd.recd_vatpc, s.dist_distributor, c.eqca_category as categoryname, mt.maty_material as materialtypename, rd.recd_amount, rd.recd_discountpc, u.unit_unitname');
        $this->db->from('recm_receivedmaster rm');
        $this->db->join('recd_receiveddetail rd','rm.recm_receivedmasterid = rd.recd_receivedmasterid','left');
        $this->db->join('itli_itemslist il','rd.recd_itemsid = il.itli_itemlistid','left');
        $this->db->join('dist_distributors s','rm.recm_supplierid = s.dist_distributorid','left');
        $this->db->join('maty_materialtype mt','il.itli_typeid = mt.maty_materialtypeid','left');
        $this->db->join('eqca_equipmentcategory c','il.itli_catid = c.eqca_equipmentcategoryid','left');
        $this->db->join('unit_unit u','il.itli_unitid = u.unit_unitid','left');
    
        // if(!empty($order_by) && !empty($order)){
        //     $order_by = 'recm_receiveddatebs';
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