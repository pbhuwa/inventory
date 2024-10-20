<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Stock_received_mdl extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->curtime = $this->general->get_currenttime();
        $this->userid  = $this->session->userdata(USER_ID);
        $this->mac     = $this->general->get_Mac_Address();
        $this->ip      = $this->general->get_real_ipaddr();
        $this->locationid=$this->session->userdata(LOCATION_ID);
        $this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
    }

    public $validate_settings_distributors = array(
        array(
            'field' => 'dist_distributor', 'label' => 'Distributor Name', 'rules' => 'trim|required|xss_clean'), 
        array('field' => 'dist_phone1', 'label' => 'Phone 1', 'rules' => 'trim|required|xss_clean'), 
        array('field' => 'dist_email', 'label' => 'Email', 'rules' => 'trim|valid_email|xss_clean'), 
        array('field' => 'dist_repemail', 'label' => 'Sales Resp. Email', 'rules' => 'trim|valid_email|xss_clean'));

    

    public function get_stock_received_list($cond = false)
    {
        $get = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }

    if(!empty($get['sSearch_1'])){
            $this->db->where("trma_issueno like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("eqty_equipmenttype like  '%".$get['sSearch_2']."%'  ");
        }

        if(!empty($get['sSearch_5'])){
            $this->db->where("trma_fromby like  '%".$get['sSearch_5']."%'  ");
        }

        if(!empty($get['sSearch_6'])){
            $this->db->where("trma_receivedby like  '%".$get['sSearch_6']."%'  ");
        }
        
        if($cond) {
            $this->db->where($cond);
        }

        $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');
        $toDate = CURDATE_NP;

        $locationid = !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');
      
        if($frmDate &&  $toDate){
            if(DEFAULT_DATEPICKER=='NP')
            {
              $this->db->where('mtm.trma_transactiondatebs >=', $frmDate);
              $this->db->where('mtm.trma_transactiondatebs <=', $toDate);
            }
            else
            {
              $this->db->where('mtm.trma_transactiondatead >=', $frmDate);
              $this->db->where('mtm.trma_transactiondatead <=', $toDate);
            }
        }
        if($this->location_ismain=='Y'){

        if(!empty($locationid)){
            $this->db->where('mtm.trma_locationid',$locationid);
        }
        }else{
            $this->db->where('mtm.trma_locationid',$this->locationid);
        }

        $resltrpt=$this->db->select("COUNT(*) as cnt")
                    ->from('trma_transactionmain mtm')
                    ->join('eqty_equipmenttype et','et.eqty_equipmenttypeid = mtm.trma_fromdepartmentid','left')
                    ->join('trde_transactiondetail mtd','mtm.trma_trmaid = mtd.trde_trmaid','left')
                    ->where("trma_received",'1')
                    ->where("trma_todepartmentid",'1')
                    ->where("trma_transactiontype",'issue')
                    ->where("trma_status",'O')
                    ->where("trma_received",'1')
                    ->group_by('mtm.trma_transactiondatebs, mtm.trma_transactiontype, mtm.trma_todepartmentid, mtm.trma_fromby, mtm.trma_receivedby,mtm.trma_fromdepartmentid, mtm.trma_issueno, et.eqty_equipmenttype, mtm.trma_trmaid')
                    ->get()
                    ->result();

        $totalfilteredrecs=sizeof($resltrpt);  

        $order_by = 'trma_transactiondatebs';
        $order = 'desc';
  
        $where='';
        if($this->input->get('iSortCol_0')==1)
            $order_by = 'trma_issueno';
        else if($this->input->get('iSortCol_0')==2)
            $order_by = 'eqty_equipmenttype';
        
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
            $this->db->where("trma_issueno like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("eqty_equipmenttype like  '%".$get['sSearch_2']."%'  ");
        }

        if(!empty($get['sSearch_5'])){
            $this->db->where("trma_fromby like  '%".$get['sSearch_5']."%'  ");
        }

        if(!empty($get['sSearch_6'])){
            $this->db->where("trma_receivedby like  '%".$get['sSearch_6']."%'  ");
        }

        $locationid = !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');
      
      if($this->location_ismain=='Y'){

        if(!empty($locationid)){
            $this->db->where('mtm.trma_locationid',$locationid);
        }
        }else{
            $this->db->where('mtm.trma_locationid',$this->locationid);
        }
        if($cond) {
          $this->db->where($cond);
        }

        

        if($frmDate &&  $toDate){
            if(DEFAULT_DATEPICKER=='NP')
            {
              $this->db->where('mtm.trma_transactiondatebs >=', $frmDate);
              $this->db->where('mtm.trma_transactiondatebs <=', $toDate);
            }
            else
            {
              $this->db->where('mtm.trma_transactiondatead >=', $frmDate);
              $this->db->where('mtm.trma_transactiondatead <=', $toDate);
            }
        }

         


        $this->db->select('mtm.trma_transactiondatead as transactiondatead, mtm.trma_transactiondatebs as transactiondatebs, mtm.trma_todepartmentid as todepid, mtm.trma_fromby as fromby, mtm.trma_receivedby as receivedby, mtm.trma_fromdepartmentid as fromdepid, mtm.trma_issueno as issueno, et.eqty_equipmenttype as departmentname, mtm.trma_trmaid as mattransmasterid, sum(mtd.trde_requiredqty * mtd.trde_unitprice) as amount, mtm.trma_reqno as reqno,mtm.trma_locationid');
        $this->db->from('trma_transactionmain mtm');
        $this->db->join('eqty_equipmenttype et','et.eqty_equipmenttypeid = mtm.trma_fromdepartmentid','left');
        $this->db->join('trde_transactiondetail mtd','mtm.trma_trmaid = mtd.trde_trmaid','left');
        $this->db->where("trma_received",'1');
        $this->db->where("trma_todepartmentid",'1');
        $this->db->where("trma_transactiontype",'issue');
        $this->db->where("trma_status",'O');
        // $this->db->where("trma_received",'1');
        $this->db->group_by('mtm.trma_transactiondatebs, mtm.trma_transactiontype, mtm.trma_todepartmentid, mtm.trma_fromby, mtm.trma_receivedby,mtm.trma_fromdepartmentid, mtm.trma_issueno, et.eqty_equipmenttype, mtm.trma_trmaid');
      
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

    public function get_stock_received_by_id($srchcol = false){
        try{
            $this->db->select('trde_requiredqty as requiredqty, trde_controlno as controlno, trde_itemsid as itemsid, il.itli_itemname as itemname, il.itli_itemnamenp as itemnamenp, il.itli_itemcode as itemcode, trde_unitprice as unitprice, u.unit_unitname as unitname');
            $this->db->from('trde_transactiondetail mtd');
            $this->db->join('itli_itemslist il','il.itli_itemlistid = mtd.trde_itemsid');
            $this->db->join('unit_unit u','u.unit_unitid  = il.itli_unitid');
            if($srchcol){
                $this->db->where($srchcol);
            }
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