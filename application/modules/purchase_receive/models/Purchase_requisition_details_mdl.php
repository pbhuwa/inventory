<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Purchase_requisition_details_mdl extends CI_Model 
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

    public function get_purchase_requisition_details_list($cond = false)
    {
        $get = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("requ_requno like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("requ_requser like  '%".$get['sSearch_2']."%'  ");
        }

        if(!empty($get['sSearch_3'])){
            $this->db->where("requ_requser like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            // $this->db->where("itli_itemname like  '%".$get['sSearch_4']."%'  ");
               $this->db->where("itli_itemname like  '%".$get['sSearch_4']."%' OR itli_itemnamenp like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("rede_unit like  '%".$get['sSearch_5']."%'  ");
        }
    
        if($cond) {
            $this->db->where($cond);
        }

        $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');
        $toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');

        $supplier = !empty($get['supplier'])?$get['supplier']:$this->input->post('supplier');
        
        $items = !empty($get['items'])?$get['items']:$this->input->post('items');

        if(!empty(($frmDate && $toDate)))
        {
            $this->db->where('requ_requdatebs >=',$frmDate);
            $this->db->where('requ_requdatebs <=',$toDate);
        }

        if(!empty($supplier)){
            $this->db->where('supp_supplierid',$supplier);
        }

        if(!empty($items)){
            $this->db->where('itli_itemlistid',$items);
        }

        $resltrpt=$this->db->select("COUNT(*) as cnt")
                    ->from('requ_requisition req')
                    ->join('rede_reqdetail rd','rd.rede_reqdetailid = req.requ_requid','left')
                    ->join('itli_itemslist il','il.itli_itemlistid = rd.rede_itemsid','left')
                    ->join('maty_materialtype mt','mt.maty_materialtypeid = il.itli_materialtypeid','left')
                    ->where('req.requ_isapproved','Y')
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
            $order_by = 'requ_requno';
        else if($this->input->get('iSortCol_0')==2)
            $order_by = 'requ_requdatebs';
        else if($this->input->get('iSortCol_0')==3)
            $order_by = 'requ_requser';
        else if($this->input->get('iSortCol_0')==4)
            $order_by = 'itli_itemname';
        else if($this->input->get('iSortCol_0')==5)
            $order_by = 'rede_unit';
        
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
            $this->db->where("requ_requno like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("requ_requdatebs like  '%".$get['sSearch_2']."%'  ");
        }

        if(!empty($get['sSearch_3'])){
            $this->db->where("requ_requser like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
           $this->db->where("itli_itemname like  '%".$get['sSearch_4']."%' OR itli_itemnamenp like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("rede_unit like  '%".$get['sSearch_5']."%'  ");
        }
    
       
        if($cond) {
          $this->db->where($cond);
        }

        $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');
        $toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');

        $supplier = !empty($get['supplier'])?$get['supplier']:$this->input->post('supplier');
        
        $items = !empty($get['items'])?$get['items']:$this->input->post('items');

        if(!empty(($frmDate && $toDate)))
        {
            $this->db->where('requ_requdatebs >=',$frmDate);
            $this->db->where('requ_requdatebs <=',$toDate);
        }

        if(!empty($supplier)){
            $this->db->where('supp_supplierid',$supplier);
        }

        if(!empty($items)){
            $this->db->where('itli_itemlistid',$items);
        }

        $this->db->select('req.requ_requid as reqid, req.requ_requno as reqno, req.requ_requdatebs as reqdatebs,req.requ_requdatead as reqdatead, req.requ_requser as requser,  rd.rede_qty as qty,
            rd.rede_unit as unit, il.itli_itemname as itemname, mt.maty_material as materialname, ec.eqca_category as category, req.requ_status as status');
        $this->db->from('requ_requisition req');
        $this->db->join('rede_reqdetail rd','rd.rede_reqdetailid = req.requ_requid','left');
        $this->db->join('itli_itemslist il','il.itli_itemlistid = rd.rede_itemsid','left');
        $this->db->join('eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid = il.itli_catid','left');
        $this->db->join('maty_materialtype mt','mt.maty_materialtypeid = il.itli_materialtypeid','left');
        $this->db->where('req.requ_isapproved','Y');

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