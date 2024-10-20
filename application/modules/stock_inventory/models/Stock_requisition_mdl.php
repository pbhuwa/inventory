<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Stock_requisition_mdl extends CI_Model
{
    public function __construct()
    {
    parent::__construct();
    $this->stre_masterTable='rema_reqmaster';
    $this->stre_detailTable='rede_reqdetail';
    $this->locationid=$this->session->userdata(LOCATION_ID);
    $this->storeid=$this->session->userdata(STORE_ID);
    }
    public $validate_settings_stock_requisition = array(
    array('field' => 'rema_reqno', 'label' => 'REQ Number', 'rules' => 'trim|required|xss_clean'),
    array('field' => 'rema_manualno', 'label' => 'Manual Number ', 'rules' => 'trim|required|xss_clean'),
    array('field' => 'rema_reqfromdepid', 'label' => 'Department ', 'rules' => 'trim|required|xss_clean'),

    );
    public function stock_requisition_save()
    {
       
        try{
            // $postdata=$this->input->post();
            // echo "<pre>";print_r($postdata);die();
                $req_date=$this->input->post('rema_reqdatead');
            if(DEFAULT_DATEPICKER=='NP')
            {
                $requstdateNp=$req_date;
                $requstdateEn=$this->general->NepToEngDateConv($req_date);
            }
            else
            {
                $requstdateEn=$req_date;
                $requstdateNp=$this->general->EngToNepDateConv($req_date);
            }
            $rema_reqno=$this->input->post('rema_reqno');
            $rema_storeid=$this->input->post('rema_storeid');
            $rema_manualno = $this->input->post('rema_manualno');
            $rema_reqfromdepid = $this->input->post('rema_reqfromdepid');
            $rema_reqtodepid = $this->input->post('rema_reqtodepid');
            $rema_reqby = $this->input->post('rema_reqby');
            $itemsid = $this->input->post('rede_itemsid');

            $rede_unit =   $this->input->post('rede_unit');
            $qty =   $this->input->post('rede_qty');
            $remarks =   $this->input->post('rede_remarks');

            $orma_itemid = $this->input->post('orma_itemid');
            $curtime=$this->general->get_currenttime();
            $userid=$this->session->userdata(USER_ID);
            $mac=$this->general->get_Mac_Address();
            $ip=$this->general->get_real_ipaddr();
            $this->db->trans_begin();
            $ReqMasterArray = array(
                                'rema_reqno'=>$rema_reqno,
                                'rema_storeid'=>$rema_storeid,
                                'rema_reqdatead'=>$requstdateNp,
                                //'rema_reorderlevel'=>$rema_reorderlevel,
                                'rema_manualno'=>$rema_manualno,
                                'rema_reqfromdepid'=>$rema_reqfromdepid,
                                'rema_reqtodepid'=>$rema_reqtodepid,
                                'rema_reqby'=>$rema_reqby,
                                'rema_reqdatebs'=>$requstdateEn,
                                'rema_postdatead'=>CURDATE_EN,
                                'rema_postdatebs'=>CURDATE_NP,
                                'rema_posttime'=>$curtime,
                                'rema_postby'=>$userid,
                                'rema_postmac'=>$mac,
                                'rema_postip'=>$ip ,
                                'rema_locationid'=>$this->locationid                             
                                );
            if(!empty($ReqMasterArray))
            {   //print_r($ReqMasterArray);die;
                $this->db->insert($this->stre_masterTable,$ReqMasterArray);
                $insertid=$this->db->insert_id();
                if($insertid)
                {
                foreach ($itemsid as $key => $val) {
                $ReqDetail[]=array(
                                'rede_reqmasterid'=>$insertid,
                                'rede_itemsid'=> !empty($itemsid[$key])?$itemsid[$key]:'',
                                'rede_unit'=> !empty($rede_unit[$key])?$rede_unit[$key]:'',
                                'rede_qty'=> !empty($qty[$key])?$qty[$key]:'',
                                'rede_remarks'=> !empty($remarks[$key])?$remarks[$key]:'',
                                'rede_postdatead'=>CURDATE_EN,
                                'rede_postdatebs'=>CURDATE_NP,
                                'rede_posttime'=>$curtime,
                                'rede_postby'=>$userid,
                                'rede_postmac'=>$mac,
                                'rede_postip'=>$ip,
                                'rede_locationid'=>$this->locationid 
                            );
                    }
                    if(!empty($ReqDetail))
                    {   //echo"<pre>";print_r($ReqDetail);die;
                        $this->db->insert_batch($this->stre_detailTable,$ReqDetail);
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

    public function get_requisition_list($cond = false)
    {
        $get = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }
        if(!empty($get['sSearch_0'])){
            $this->db->where("rema_reqmasterid like  '%".$get['sSearch_0']."%'  ");
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("rema_reqno like  '%".$get['sSearch_1']."%'  ");
        }
        if(!empty($get['sSearch_2'])){
            $this->db->where("rema_manualno like  '%".$get['sSearch_2']."%'  ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("j.dept_depname like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("t.dept_depname like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("rema_postdatead like  '%".$get['sSearch_5']."%'  ");
        }
        if(!empty($get['sSearch_6'])){
            $this->db->where("rema_postdatebs like  '%".$get['sSearch_6']."%'  ");
        }
          if($cond) {
          $this->db->where($cond);
        }
       //  if($this->session->userdata(USER_ACCESS_TYPE)=='S')
        // {
       //   $this->db->where('dist_orgid',$this->session->userdata(ORG_ID));
        // }

        $resltrpt=$this->db->select("cm.*,j.dept_depname as fromdep, t.dept_depname as todep")
                    ->from('rema_reqmaster cm')
                    ->join('dept_department t','t.dept_depid = cm.rema_reqtodepid','LEFT')
                    ->join('dept_department j','j.dept_depid = cm.rema_reqfromdepid','LEFT')
                    ->get();
        //echo $this->db->last_query();die(); 
        $totalfilteredrecs=count($resltrpt); 
        $order_by = 'rema_reqmasterid';
        $order = 'desc';
        if($this->input->get('sSortDir_0'))
        {
                $order = $this->input->get('sSortDir_0');
        }
  
        $where='';
        if($this->input->get('iSortCol_0')==0)
            $order_by = 'rema_reqmasterid';
        else if($this->input->get('iSortCol_0')==1)
            $order_by = 'rema_reqno';
        else if($this->input->get('iSortCol_0')==2)
            $order_by = 'rema_manualno';
        else if($this->input->get('iSortCol_0')==3)
            $order_by = 'j.dept_depname';
        else if($this->input->get('iSortCol_0')==4)
            $order_by = 't.dept_depname';
        else if($this->input->get('iSortCol_0')==5)
            $order_by = 'rema_postdatead';
        else if($this->input->get('iSortCol_0')==6)
            $order_by = 'rema_postdatebs';
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
            $this->db->where("rema_reqmasterid like  '%".$get['sSearch_0']."%'  ");
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("rema_reqno like  '%".$get['sSearch_1']."%'  ");
        }
        if(!empty($get['sSearch_2'])){
            $this->db->where("rema_manualno like  '%".$get['sSearch_2']."%'  ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("j.dept_depname like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("t.dept_depname like  '%".$get['sSearch_4']."%'  ");
        } 
        if(!empty($get['sSearch_5'])){
            $this->db->where("rema_postdatead like  '%".$get['sSearch_5']."%'  ");
        }
        if(!empty($get['sSearch_6'])){
            $this->db->where("rema_postdatebs like  '%".$get['sSearch_6']."%'  ");
        }
       //  if($this->session->userdata(USER_ACCESS_TYPE)=='S')
        // {
       //   $this->db->where('dist_orgid',$this->session->userdata(ORG_ID));
        // }
        if($cond) {
          $this->db->where($cond);
        }

        $this->db->select('cm.*,j.dept_depname as fromdep, t.dept_depname as todep');
        $this->db->from('rema_reqmaster cm');
        //$this->db->join('pude_purchaseorderdetail qd','qd.pude_purchasemasterid = cm.puor_purchasorderemaster_id','LEFT');
        $this->db->join('dept_department t','t.dept_depid = cm.rema_reqtodepid','LEFT');
        $this->db->join('dept_department j','j.dept_depid = cm.rema_reqfromdepid','LEFT');
 
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

    public function get_req_no_list($srchcol = false, $order_by = false, $order = false){
        $this->db->select('rm.rema_reqmasterid, rm.rema_reqno, rm.rema_reqdatebs, rm.rema_reqdatead, rm.rema_manualno, rm.rema_reqfromdepid, d.dept_depname,rm.rema_reqby,rm.rema_approved');
        $this->db->from('rema_reqmaster rm');
        $this->db->join('dept_department d','d.dept_depid = rm.rema_reqfromdepid','left');
        if($srchcol){
            $this->db->where($srchcol);
        }
        if($order_by && $order){
            $this->db->order_by($order_by,$order);    
        }
        
        $query = $this->db->get();
        //echo $this->db->last_query();die();
        if($query->num_rows() > 0){
            $result = $query->result();
            return $result;
        }
        return false;
    }

    public function get_new_issue_list($cond = false)
    {

        $get = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("rema_reqno like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("rema_manualno like  '%".$get['sSearch_2']."%'  ");
        }
        
        if(!empty($get['sSearch_3'])){
         if(DEFAULT_DATEPICKER=='NP')
            {
            $this->db->where("rema_reqdatebs like  '%".$get['sSearch_3']."%'  ");       
            }
            else
            {
            $this->db->where("rema_reqdatead like  '%".$get['sSearch_3']."%'  ");
            }
          }
          if(!empty($get['sSearch_4'])){
             $this->db->where("dept_depname like  '%".$get['sSearch_4']."%'  ");
           }

        if($cond) {
            $this->db->where($cond);
        }

        // $resltrpt=$this->db->select("COUNT(*) as cnt")
        //             ->from('rema_reqmaster rm')
        //             ->join('dept_department d','d.dept_depid = rm.rema_reqfromdepid','left')
        //             ->get()
        //             ->row();

       $select=$this->db->select('rm.rema_reqmasterid, rm.rema_reqno, rm.rema_reqdatebs, rm.rema_reqdatead, rm.rema_manualno, rm.rema_reqfromdepid,rm.rema_locationid, d.dept_depname,rm.rema_reqby,(select COUNT("*") as cnt from xw_rede_reqdetail where rede_remqty<>0 AND rede_qtyinstock<>0 AND rede_reqmasterid=rm.rema_reqmasterid) as dtl_cnt, (select COUNT("*") as cnt from xw_rede_reqdetail where rede_remqty<>0 AND rede_qtyinstock<>0 AND  rede_reqmasterid=rm.rema_reqmasterid) as stk_cnt, et1.eqty_equipmenttype as fromstorename, et2.eqty_equipmenttype as tostorename')
           ->from('rema_reqmaster rm')
           ->join('dept_department d','d.dept_depid = rm.rema_reqfromdepid','left')
           ->join('eqty_equipmenttype et1','et1.eqty_equipmenttypeid = rm.rema_reqfromdepid','left')
           ->join('eqty_equipmenttype et2','et2.eqty_equipmenttypeid = rm.rema_reqtodepid','left')
           ->where('rm.rema_reqmasterid NOT IN (SELECT pr.pure_reqmasterid FROM xw_pure_purchaserequisition pr WHERE pr.pure_reqmasterid=rm.rema_reqmasterid )');
        //       if($limit && $limit>0)
        // {  
        //     $this->db->limit($limit);
        // }
        // if($offset)
        // {
        //     $this->db->offset($offset);
        // }

        $sql = $this->db->get_compiled_select();
        // echo $sql;
        // die();
        // $this->db->select("($sql) x " );
        // $this->db->from("x");
        $nquery=$this->db->query("SELECT COUNT('*') as cnt FROM ($sql) x  ")->row();
        // $this->db->where(array('dtl_cnt >'=>'0','stk_cnt >'=>'0'));
        // echo $sql;
        // die();
         // echo $this->db->last_query();die(); 
        // echo "<pre>";
        // print_r($nquery);
        // die();
        $totalfilteredrecs=0;
            if(!empty( $nquery)){
                $totalfilteredrecs=$nquery->cnt;
            }
     

        $order_by = 'rema_reqno';
        $order = 'desc';
  
        $where='';
        if($this->input->get('iSortCol_0')==1)
            $order_by = 'rema_reqno';
        else if($this->input->get('iSortCol_0')==2)
            $order_by = 'rema_manualno';
        else if($this->input->get('iSortCol_0')==3)
            $order_by = 'rema_reqdatead';
         else if($this->input->get('iSortCol_0')==4)
            $order_by = 'dept_depname';
        
        $totalrecs='';
        $limit = 15;
        $offset = 1;
        $get = $_GET;
 
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }
          if($this->input->get('sSortDir_0'))
        {
                $order = $this->input->get('sSortDir_0');
        }
      
        if(!empty($_GET["iDisplayLength"])){
           $limit = $_GET['iDisplayLength'];
           $offset = $_GET["iDisplayStart"];
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("rema_reqno like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("rema_manualno like  '%".$get['sSearch_2']."%'  ");
        }
         if(!empty($get['sSearch_3'])){
         if(DEFAULT_DATEPICKER=='NP')
            {
            $this->db->where("rema_reqdatebs like  '%".$get['sSearch_3']."%'  ");       
            }
            else
            {
            $this->db->where("rema_reqdatead like  '%".$get['sSearch_3']."%'  ");
            }
          }
           if(!empty($get['sSearch_4'])){
             $this->db->where("dept_depname like  '%".$get['sSearch_4']."%'  ");
           }

        if($cond) {
          $this->db->where($cond);
        }

        // $this->db->select('il.itli_itemlistid as itemid, il.itli_itemcode as itemcode, il.itli_itemname as itemname');
        // $this->db->from('itli_itemslist il');

        $select=$this->db->select('rm.rema_reqmasterid, rm.rema_reqno, rm.rema_reqdatebs, rm.rema_reqdatead, rm.rema_manualno,rm.rema_reqtodepid,rm.rema_locationid,  rm.rema_reqfromdepid, d.dept_depname,rm.rema_reqby,
            (select COUNT("*") as cnt from xw_rede_reqdetail where rede_remqty<>0 AND rede_qtyinstock<>0 AND rede_reqmasterid=rm.rema_reqmasterid) as dtl_cnt, 
            (select COUNT("*") as cnt from xw_rede_reqdetail where rede_remqty<>0 AND rede_qtyinstock<>0 AND  rede_reqmasterid=rm.rema_reqmasterid) as stk_cnt, 
            et1.eqty_equipmenttype as fromstorename, et2.eqty_equipmenttype as tostorename')
           ->from('rema_reqmaster rm')
            ->join('dept_department d','d.dept_depid = rm.rema_reqfromdepid','left')
            ->join('eqty_equipmenttype et1','et1.eqty_equipmenttypeid = rm.rema_reqfromdepid','left')
            ->join('eqty_equipmenttype et2','et2.eqty_equipmenttypeid = rm.rema_reqtodepid','left')
            ->where('rm.rema_reqmasterid NOT IN (SELECT pr.pure_reqmasterid FROM xw_pure_purchaserequisition pr WHERE pr.pure_reqmasterid=rm.rema_reqmasterid )');
              if($limit && $limit>0)
        {  
            $this->db->limit($limit);
        }
        if($offset)
        {
            $this->db->offset($offset);
        }
         $this->db->order_by($order_by,$order);
      
        $sql = $this->db->get_compiled_select();
        // echo $sql;
        // die();
        // $this->db->select("($sql) x " );
        // $this->db->from("x");
        // $nquery=$this->db->query("SELECT * FROM ($sql) x WHERE dtl_cnt>0 and  stk_cnt>0 ");

        $nquery=$this->db->query("SELECT * FROM ($sql) x");

        // $this->db->where(array('dtl_cnt >'=>'0','stk_cnt >'=>'0'));
        // echo $sql;
        // die();

       
      
      
        // $nquery=$this->db->get();

        // $db_query= $this->db->last_query();
        // echo $db_query;

        // die();
        // $nquery=$this->db->query($db_query .' WHERE dtl_cnt>0 AND stk_cnt>0  ');

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
    
    public function get_requisition_details($srchcol = false){
        $this->db->select('it.itli_itemcode, it.itli_itemname, it.itli_itemnamenp, it.itli_itemlistid, it.itli_purchaserate, it.itli_salesrate, rd.rede_reqdetailid, rd.rede_itemsid, rm.*,rd.rede_qty,rd.rede_remqty,rd.rede_reqmasterid, ut.unit_unitname, rd.rede_qtyinstock,(SELECT IFNULL(SUM(md.trde_issueqty),0) FROM xw_trde_transactiondetail md LEFT JOIN xw_trma_transactionmain mt   on md.trde_trmaid =mt.trma_trmaid
  WHERE it.itli_itemlistid=md.trde_itemsid AND mt.trma_received=1 AND md.trde_locationid='.$this->locationid.' AND mt.trma_fromdepartmentid='.$this->storeid.'  AND mt.trma_received = "1" 
        AND md.trde_status = "O" ) as stockqty,rd.rede_remarks');
        $this->db->from('rede_reqdetail rd');
        $this->db->join('rema_reqmaster rm','rm.rema_reqmasterid=rd.rede_reqmasterid','LEFT');
        $this->db->join('itli_itemslist it','it.itli_itemlistid = rd.rede_itemsid','left');
        $this->db->join('unit_unit ut','it.itli_unitid = ut.unit_unitid','left');

        if($srchcol){
            $this->db->where($srchcol);
        }
        $query = $this->db->get();
        // echo $this->db->last_query();
        // die();
        if($query->num_rows() > 0){
            $result = $query->result();
            return $result;
        }
        return false;
    }
}