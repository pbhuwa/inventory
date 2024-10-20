<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Store_requisition_mdl extends CI_Model
{
    public function __construct()
    {
    parent::__construct();
    $this->req_noteTable='reno_requisitionnote';
    $this->req_detailNoteTable='redt_reqdetailnote';
       $this->locationid=$this->session->userdata(LOCATION_ID);
    $this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
    }
    public $validate_settings_requisition = array(
    array('field' => 'reqdate', 'label' => 'Requisition Date', 'rules' => 'trim|required|xss_clean'),
    array('field' => 'requ_appliedby', 'label' => 'Requested By ', 'rules' => 'trim|required|xss_clean'),
    array('field' => 'requ_requno', 'label' => 'Requisition No ', 'rules' => 'trim|required|xss_clean|callback_exists_reqno'),
    array('field' => 'requ_requestto', 'label' => 'Requested To ', 'rules' => 'trim|required|xss_clean'),
    array('field' => 'itemcode[]', 'label' => 'Item Code', 'rules' => 'trim|required|xss_clean'),
    array('field' => 'itemname[]', 'label' => 'Item Name', 'rules' => 'trim|required|xss_clean'),
    array('field' => 'itemqty[]', 'label' => 'Item Qty', 'rules' => 'trim|required|xss_clean')
    
    );
    public function store_requisition_save()
    {
        try{
            
             $requ_date=$this->input->post('reqdate');
            if(DEFAULT_DATEPICKER=='NP')
            {
                $requ_dateNp=$requ_date;
                $requ_dateEn=$this->general->NepToEngDateConv($requ_date);
            }
            else
            {
                $requ_dateEn=$requ_date;
                $requ_dateNp=$this->general->EngToNepDateConv($requ_date);
            }

            $requ_appliedby=$this->input->post('requ_appliedby');
            $requ_requno=$this->input->post('requ_requno');
            $requ_requestto = $this->input->post('requ_requestto');
          
            $itemid =   $this->input->post('itemid');
            $itemunit =   $this->input->post('itemunit');
            $itemstock =   $this->input->post('itemstock');
            $itemqty =   $this->input->post('itemqty');
            $itemrate = $this->input->post('itemrate');
            $bugetcode = $this->input->post('bugetcode');
            $remarks = $this->input->post('remarks');

            $curtime=$this->general->get_currenttime();
            $userid=$this->session->userdata(USER_ID);
            $username=$this->session->userdata(USER_NAME);
            $mac=$this->general->get_Mac_Address();
            $ip=$this->general->get_real_ipaddr();
            $this->db->trans_begin();
            $req_note= array(
                               'reno_reqdatead'=>$requ_dateEn,
                               'reno_reqdatebs'=>$requ_dateNp,
                               'reno_appliedby'=>$requ_appliedby,
                               'reno_requser'=>$username,
                               'reno_reqtime'=>$curtime,
                               'reno_requestto'=>$requ_requestto,
                               'reno_reqno'=>$requ_requno,
                               'reno_fyear'=>CUR_FISCALYEAR,
                               'reno_postdatead'=>CURDATE_EN,
                               'reno_postdatebs'=>CURDATE_NP,
                                'reno_posttime'=>$curtime,
                                'reno_postip'=>$ip,
                                'reno_postmac'=>$mac,
                                'reno_postby'=>$userid ,
                                'reno_locationid'=>$this->locationid                  
                                );
            if(!empty($req_note))
            {   //print_r($ReqMasterArray);die;
                $this->db->insert($this->req_noteTable,$req_note);
                $insertid=$this->db->insert_id();
                if($insertid)
                {
                foreach ($itemid as $key => $val) {
                $Reqdetailnote[]=array(
                                'redt_reqid'=>$insertid,
                                'redt_itemsid'=> !empty($itemid[$key])?$itemid[$key]:'',
                                'redt_unit'=> !empty($itemunit[$key])?$itemunit[$key]:'',
                                'redt_storestock'=> !empty($itemstock[$key])?$itemstock[$key]:'',
                                'redt_qty'=> !empty($itemqty[$key])?$itemqty[$key]:'',
                                'redt_rate'=> !empty($itemrate[$key])?$itemrate[$key]:'',
                                'redt_budcode'=> !empty($bugetcode[$key])?$bugetcode[$key]:'',
                                'redt_rate'=> !empty($remarks[$key])?$remarks[$key]:'',
                                'redt_fyear'=>CUR_FISCALYEAR,
                                'redt_postdatead'=>CURDATE_EN,
                                'redt_postdatebs'=>CURDATE_NP,
                                'redt_posttime'=>$curtime,
                                'redt_postby'=>$userid,
                                'redt_postmac'=>$mac,
                                'redt_postip'=>$ip,
                                'redt_locationid'=>$this->locationid 
                            );
                    }
                    if(!empty($Reqdetailnote))
                    {   //echo"<pre>";print_r($ReqDetail);die;
                        $this->db->insert_batch($this->req_detailNoteTable,$Reqdetailnote);
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
                return true;
            }
        }catch(Exception $e){
            throw $e;
        }
    }

    public function get_store_requisition_list($cond = false)
    {
        $frmDate=$this->input->get('frmDate');
        $toDate=$this->input->get('toDate');
        $get = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }
        if(!empty($get['sSearch_0'])){
            $this->db->where("reno_reqid like  '%".$get['sSearch_0']."%'  ");
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("reno_reqno like  '%".$get['sSearch_1']."%'  ");
        }
        if(!empty($get['sSearch_2'])){
            $this->db->where("reno_reqdatebs like  '%".$get['sSearch_2']."%'  ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("reno_reqdatead like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("reno_reqtime like  '%".$get['sSearch_4']."%'  ");
        }
          if(!empty($get['sSearch_5'])){
            $this->db->where("reno_appliedby like  '%".$get['sSearch_5']."%'  ");
        }
        if(!empty($get['sSearch_6'])){
            $this->db->where("reno_fyear like  '%".$get['sSearch_6']."%'  ");
        }
        if(!empty($get['sSearch_7'])){
            $this->db->where("reno_costcenter like  '%".$get['sSearch_7']."%'  ");
        }
          if($cond) {
          $this->db->where($cond);
        }
       $locationid = !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');
       

        if($frmDate &&  $toDate){
            if(DEFAULT_DATEPICKER=='NP')
            {
              $this->db->where('reno_reqdatebs >=', $frmDate);
              $this->db->where('reno_reqdatebs <=', $toDate);
            }
            else
            {
              $this->db->where('reno_reqdatead >=', $frmDate);
              $this->db->where('reno_reqdatead <=', $toDate);
            }
        }

        if($this->location_ismain=='Y'){
            if(!empty($locationid)){
         $this->db->where('rn.reno_locationid',$locationid);
        }
    }else{
        $this->db->where('rn.reno_locationid',$this->locationid);
    }

        $resltrpt=$this->db->select("COUNT(*) as cnt")
                    ->from('reno_requisitionnote rn')
                    ->get()->row();
        //echo $this->db->last_query();die(); 
        $totalfilteredrecs=($resltrpt->cnt); 
        $order_by = 'reno_reqid';
        $order = 'desc';
        if($this->input->get('sSortDir_0'))
        {
                $order = $this->input->get('sSortDir_0');
        }
  
        $where='';
        if($this->input->get('iSortCol_0')==0)
            $order_by = 'reno_reqid';
        else if($this->input->get('iSortCol_0')==1)
            $order_by = 'reno_reqno';
        else if($this->input->get('iSortCol_0')==2)
            $order_by = 'reno_reqdatebs';
        else if($this->input->get('iSortCol_0')==3)
            $order_by = 'reno_reqdatead';
        else if($this->input->get('iSortCol_0')==4)
            $order_by = 'reno_reqtime';
        else if($this->input->get('iSortCol_0')==5)
            $order_by = 'reno_appliedby';
            else if($this->input->get('iSortCol_0')==6)
            $order_by = 'reno_fyear';
        else if($this->input->get('iSortCol_0')==7)
            $order_by = 'reno_costcenter';
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
            $this->db->where("reno_reqid like  '%".$get['sSearch_0']."%'  ");
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("reno_reqno like  '%".$get['sSearch_1']."%'  ");
        }
        if(!empty($get['sSearch_2'])){
            $this->db->where("reno_reqdatebs like  '%".$get['sSearch_2']."%'  ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("reno_reqdatead like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("reno_reqtime like  '%".$get['sSearch_4']."%'  ");
        }
          if(!empty($get['sSearch_5'])){
            $this->db->where("reno_appliedby like  '%".$get['sSearch_5']."%'  ");
        }
        if(!empty($get['sSearch_6'])){
            $this->db->where("reno_fyear like  '%".$get['sSearch_6']."%'  ");
        }
        if(!empty($get['sSearch_7'])){
            $this->db->where("reno_costcenter like  '%".$get['sSearch_7']."%'  ");
        }
       

        if($frmDate &&  $toDate){
            if(DEFAULT_DATEPICKER=='NP')
            {
              $this->db->where('reno_reqdatebs >=', $frmDate);
              $this->db->where('reno_reqdatebs <=', $toDate);
            }
            else
            {
              $this->db->where('reno_reqdatead >=', $frmDate);
              $this->db->where('reno_reqdatead <=', $toDate);
            }
        }

         $locationid = !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');
        if($cond) {
          $this->db->where($cond);
        }
         if($this->location_ismain=='Y'){
                if(!empty($locationid)){
                   $this->db->where('rn.reno_locationid',$locationid);
               }
             }else{
             $this->db->where('rn.reno_locationid',$this->locationid);
             }
        $this->db->select('rn.*');
        $this->db->from('reno_requisitionnote rn');
       
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

    public function get_new_issue_list($srchcol = false, $order_by = false, $order = false){
        $this->db->select('rm.rema_reqmasterid, rm.rema_reqno, rm.rema_reqdatebs, rm.rema_reqdatead, rm.rema_manualno, rm.rema_reqfromdepid, d.dept_depname,rm.rema_reqby');
        $this->db->from('rema_reqmaster rm');
        $this->db->join('dept_department d','d.dept_depid = rm.rema_reqfromdepid','left');
        if($srchcol){
            $this->db->where($srchcol);
        }
        if($order_by && $order){
            $this->db->order_by($order_by,$order);    
        }
        
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $result = $query->result();
            return $result;
        }
        return false;
    }

    public function get_requisition_details($srchcol = false){
        $this->db->select('it.itli_itemcode, it.itli_itemname, it.itli_itemnamenp, it.itli_itemlistid, rd.rede_itemsid, rd.rede_qty,rd.rede_remqty, ut.unit_unitname, rd.rede_qtyinstock');
        $this->db->from('rede_reqdetail rd');
        $this->db->join('itli_itemslist it','it.itli_itemlistid = rd.rede_itemsid','left');
        $this->db->join('unit_unit ut','it.itli_unitid = ut.unit_unitid','left');

        if($srchcol){
            $this->db->where($srchcol);
        }
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $result = $query->result();
            return $result;
        }
        return false;
    }


    public function get_max_requisition_no($srchcol=false)
    {
        $this->db->select('MAX(reno_reqno)+1 as maxreqno');
        $this->db->from('reno_requisitionnote rn');
       
        if($srchcol){
            $this->db->where($srchcol);
        }
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $result = $query->row()->maxreqno;
            return $result;
        }
        return false;        
 }

 public function check_exist_requision_no($req_no = false, $id = false){
        $data = array();
        if($req_no)
        {
                $this->db->where('reno_reqno',$req_no);
        }
        if($id)
        {
            $this->db->where('reno_reqid!=',$id);
        }
        $this->db->where(array('reno_fyear'=>CUR_FISCALYEAR));

        $query = $this->db->get("reno_requisitionnote");
        // echo $this->db->last_query();
        // die();

        if ($query->num_rows() > 0) 
        {
            $data=$query->row();    
            return $data;           
        }
        return false;
    }

}