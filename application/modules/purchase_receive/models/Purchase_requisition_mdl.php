<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Purchase_requisition_mdl extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->pure_masterTable='pure_purchaserequisition';
        $this->purd_detailTable='purd_purchasereqdetail';

        $this->storeid = $this->session->userdata(STORE_ID);
        $this->userid=$this->session->userdata(USER_ID);
        $this->username=$this->session->userdata(USER_NAME);
        $this->orgid=$this->session->userdata(ORG_ID);
        $this->locationid=$this->session->userdata(LOCATION_ID);
        $this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
    }

    public $validate_settings_stock_requisition = array(
        array('field' => 'rema_reqdatead', 'label' => 'Requisition Date', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'rema_reqby', 'label' => 'Requested By ', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'rede_itemsid[]', 'label' => 'Item ', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'rede_qty[]', 'label' => 'Qty ', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'requested_to', 'label' => 'Requested To ', 'rules' => 'trim|required|xss_clean'),
    );

    public function get_item_name_by_reqno($reqno=false,$itemlist=false,$fyear=false)
    {

       $this->db->select('rm.rema_reqmasterid,it.itli_itemcode, it.itli_itemname, it.itli_itemnamenp, it.itli_itemlistid, it.itli_purchaserate, it.itli_salesrate, rd.rede_reqdetailid, rd.rede_itemsid, (select SUM(mtd.trde_issueqty) from xw_trde_transactiondetail mtd, xw_trma_transactionmain  mtm WHERE  mtm.trma_trmaid=mtd.trde_trmaid AND mtd.trde_itemsid=it.itli_itemlistid AND mtm.trma_received="1" AND mtd.trde_status="O" AND mtd.trde_locationid=rm.rema_locationid AND rd.rede_itemsid=mtd.trde_itemsid ) cur_stock_qty,rd.rede_qty,rd.rede_remqty,rd.rede_reqmasterid, ut.unit_unitname, rd.rede_qtyinstock,rd.rede_remarks');
       $this->db->from('rede_reqdetail rd');
       $this->db->join('rema_reqmaster rm','rm.rema_reqmasterid=rd.rede_reqmasterid','left');
       $this->db->join('itli_itemslist it','it.itli_itemlistid = rd.rede_itemsid','left');
       $this->db->join('unit_unit ut','it.itli_unitid = ut.unit_unitid','left');
       if($reqno)
       {
        $this->db->where('rema_reqno',$reqno);
    }
    if($itemlist)
    {
        $this->db->where_in('rede_itemsid',$itemlist);
    }
    if($fyear)
    {
        $this->db->where('rema_fyear',$fyear);
    }

    $reqmasterid=$this->input->post('reqmasterid');
    if(!empty($reqmasterid)){
        $this->db->where('rm.rema_reqmasterid',$reqmasterid);
    }
    $this->db->where('rema_locationid',$this->locationid);      
    $query = $this->db->get();
        // echo $this->db->last_query();
        // die();
    if($query->num_rows() > 0){
        $result = $query->result();
        return $result;
    }
    return false;
}

public function purchase_requisition_save()
{
    try{
        $postdata=$this->input->post();

         // echo "<pre>";
         //    print_r($this->input->post());
         //    die();
        $id = $this->input->post('id');
        $mattype=$this->input->post('pure_mattypeid');
        $cur_fiscalyear=$this->input->post('pure_fyear');
            //echo "<pre>";print_r($id);die();
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
        $requested_by=$this->input->post('rema_reqby');
        $itemtype=$this->input->post('item_type');
        $requsition_no = $this->input->post('rema_reqno');
       
        $requestedto = $this->input->post('requested_to');
        $is_approved = $this->input->post('is_approved');
        $fiscal_year = $this->input->post('pure_fyear');

        $code = $this->input->post('rede_code');
        $itemsid = $this->input->post('rede_itemsid');
        $unit =   $this->input->post('rede_unit');
        $qty =   $this->input->post('rede_qty');
        $remarks =   $this->input->post('rede_remarks');
        $stock =   $this->input->post('stock');
        $required_date =   $this->input->post('required_date');
        $pure_mattypeid=$this->input->post('pure_mattypeid');
        $pure_streqno=$this->input->post('pure_streqno');
        $pure_reqmasterid=$this->input->post('pure_reqmasterid');

        $orma_itemid = $this->input->post('orma_itemid');
        $reqdetailsid = $this->input->post('reqdetid');
        $curtime=$this->general->get_currenttime();
        $userid=$this->session->userdata(USER_ID);
        $username=$this->session->userdata(USER_NAME);
        $mac=$this->general->get_Mac_Address();
        $ip=$this->general->get_real_ipaddr();
        if($id)
        {
            $this->db->trans_begin();

                //update purchase req master
            $ReqMasterArray = array(
                'pure_itemstypeid'=>$itemtype,
                'pure_reqdatead'=>$requstdateEn,
                'pure_reqdatebs'=>$requstdateNp,
                'pure_requser'=>$requested_by,
                'pure_appliedby'=>$requested_by,
                'pure_requestto'=>$requestedto,
                'pure_isapproved'=>$is_approved,
                'pure_fyear'=>$fiscal_year,
                'pure_isapproved'=>'N',
                'pure_storeid' => $this->storeid,
                'pure_modifydatead'=>CURDATE_EN,
                'pure_modifydatebs'=>CURDATE_NP,
                'pure_modifytime'=>$curtime,
                'pure_modifyby'=>$userid,
                'pure_modifymac'=>$mac,
                'pure_modifyip'=>$ip
            );
            if(!empty($pure_mattypeid)){
                 $ReqMasterArray['pure_mattypeid']=$pure_mattypeid;
            }

            if($ReqMasterArray) {
                $this->db->where('pure_purchasereqid',$id);
                $this->db->update($this->pure_masterTable,$ReqMasterArray);
            }    

            $old_purd_list = $this->get_all_purd_id(array('purd_reqid'=>$id));

            $old_purd_array = array();

            if(!empty($old_purd_list)){
                foreach($old_purd_list as $key=>$value){
                    $old_purd_array[] = $value->purd_reqdetid;
                }
            }

            $purd_insertid = array();

            if(!empty($itemsid)){
                foreach($itemsid as $key=>$val){
                    $req_id= !empty($reqdetailsid[$key])?$reqdetailsid[$key]:'';
                    if($req_id){
                        if(in_array($req_id, $old_purd_array)){
                            $purd_array[] = $req_id;
                        }

                        $reqdate= !empty($required_date[$key])?$required_date[$key]:'';
                        if(DEFAULT_DATEPICKER=='NP')
                        {
                            $reqdatebs=$reqdate;
                            $reqdatead=$this->general->NepToEngDateConv($reqdate);
                        }
                        else
                        {
                            $reqdatebs=$this->general->EngToNepDateConv($reqdate);
                            $reqdatead=$reqdate;
                        }
                        $ReqDetailUp=array(
                                        //'purd_reqdetid'=>$updetailsid,
                            'purd_itemsid'=> !empty($itemsid[$key])?$itemsid[$key]:'',
                            'purd_budcode'=> !empty($code[$key])?$code[$key]:'',
                            'purd_qty'=> !empty($qty[$key])?$qty[$key]:'',
                            'purd_remqty'=> !empty($qty[$key])?$qty[$key]:'',
                            'purd_remarks'=> !empty($remarks[$key])?$remarks[$key]:'',
                            'purd_reqdatead'=> $reqdatead,
                            'purd_reqdatebs'=> $reqdatebs,
                            'purd_stock'=> !empty($stock[$key])?$stock[$key]:'',
                            'purd_unit'=> !empty($unit[$key])?$unit[$key]:'',
                            'purd_fyear' => $fiscal_year,
                            'purd_modifydatead'=>CURDATE_EN,
                            'purd_modifydatebs'=>CURDATE_NP,
                            'purd_modifytime'=>$curtime,
                            'purd_modifyby'=>$userid,
                            'purd_modifymac'=>$mac,
                            'purd_modifyip'=>$ip 
                        );
                        if(!empty($ReqDetailUp))
                            {   //echo"<pre>";print_r($updetailsid);die;
                        $this->db->update($this->purd_detailTable,$ReqDetailUp,array('purd_reqdetid'=>$req_id));
                    }  
                }else{

                    $reqdate= !empty($required_date[$key])?$required_date[$key]:'';
                    if(DEFAULT_DATEPICKER=='NP')
                    {
                        $reqdatebs=$reqdate;
                        $reqdatead=$this->general->NepToEngDateConv($reqdate);
                    }
                    else
                    {
                        $reqdatebs=$this->general->EngToNepDateConv($reqdate);
                        $reqdatead=$reqdate;
                    }

                    $ReqDetailInsert = array(
                        'purd_reqid'=>$id,
                        'purd_itemsid'=> !empty($itemsid[$key])?$itemsid[$key]:'',
                        'purd_budcode'=> !empty($code[$key])?$code[$key]:'',
                        'purd_qty'=> !empty($qty[$key])?$qty[$key]:'',
                        'purd_remqty'=> !empty($qty[$key])?$qty[$key]:'',
                        'purd_remarks'=> !empty($remarks[$key])?$remarks[$key]:'',
                        'purd_reqdatead'=> $reqdatead,
                        'purd_reqdatebs'=> $reqdatebs,
                        'purd_stock'=> !empty($stock[$key])?$stock[$key]:'',
                        'purd_unit'=> !empty($unit[$key])?$unit[$key]:'',
                        'purd_fyear' => $fiscal_year,
                        'purd_postdatead'=>CURDATE_EN,
                        'purd_postdatebs'=>CURDATE_NP,
                        'purd_posttime'=>$curtime,
                        'purd_postby'=>$userid,
                        'purd_postmac'=>$mac,
                        'purd_postip'=>$ip,
                        'purd_orgid'=>$this->orgid,
                        'purd_locationid'=>$this->locationid
                    );

                    $this->db->insert($this->purd_detailTable, $ReqDetailInsert);
                    $purd_insertid[] = $this->db->insert_id();
                }

                if(!empty($purd_array)){
                            // if(!empty($purd_insertid)){
                            //     $this->db->where_not_in('purd_reqdetid',$purd_insertid);
                            // }
                            // $this->db->where(array('purd_reqid'=>$id));
                            // $this->db->where_not_in('purd_reqdetid',$purd_array);
                            // $this->db->delete($this->purd_detailTable);
                }

            }
        }

                //for deleted items

        $old_items_list = $this->general->get_tbl_data('purd_reqdetid','purd_purchasereqdetail',array('purd_reqid'=>$id));

        $old_items_array = array();
        if(!empty($old_items_list)){
            foreach($old_items_list as $key=>$value){
                $old_items_array[] = $value->purd_reqdetid;
            }
        }

        $total_itemlist = count($old_items_list);

        $deleted_items = array();

        if($purd_insertid){
            $reqdetailsid = array_merge($reqdetailsid, $purd_insertid);
        }

        if(is_array($reqdetailsid)){
            $deleted_items = array_diff($old_items_array, $reqdetailsid);
        }

        $del_items_num = count($deleted_items);

        if(!empty($del_items_num)){
            for($i = 0; $i<$del_items_num; $i++){
                $deleted_array = array_values($deleted_items);
                foreach($deleted_array as $key=>$del){

                    $this->db->where(array('purd_reqdetid'=>$del));
                    $this->db->delete('purd_purchasereqdetail');
                }
            }
        }

        $ReqMasterArrayUp = array(
            'pure_modifyby'=>$userid,
            'pure_modifydatead'=>CURDATE_EN,
            'pure_modifydatebs'=>CURDATE_NP,
            'pure_modifytime'=>$curtime,
            'pure_modifymac'=>$mac,
            'pure_modifyip'=>$ip
        );
        if(!empty($ReqMasterArrayUp))
                {   //echo"<pre>";print_r($ReqMasterArrayUp); die;
            $this->db->update($this->pure_masterTable,$ReqMasterArrayUp,array('pure_purchasereqid'=>$id));
        }
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            return $id;
        }
    }else{
         if(ORGANIZATION_NAME=='KU' || ORGANIZATION_NAME=='ARMY' || ORGANIZATION_NAME=='PU'){
            // $this->db->select('max(pure_reqno) as reqno');
            // $this->db->from('pure_purchaserequisition');
            // $this->db->where(array('pure_locationid'=>$this->locationid,'pure_fyear'=>$cur_fiscalyear,'pure_mattypeid'=>$mattype));
            // $result = $this->db->get()->row();
            // if(!empty($result))
            // {
            //     $requsitionno=$result->reqno +1;
            // }else{
            //     $requsitionno=1;
            // }
             $requsition_sno = $this->general->getLastNo('pure_reqno','pure_purchaserequisition',array('pure_fyear'=>$cur_fiscalyear,'pure_locationid'=>$this->locationid,'pure_mattypeid'=>$mattype));
             // if(!empty($requsition_sno)){
             //    $requsitionno = $requsition_sno+1;
             // }else{
             //    $requsitionno = 1;   
             // }
             $requsitionno=!empty($requsition_sno)?$requsition_sno +1:1;
             
        }else{
             $requsition_sno = $this->general->getLastNo('pure_reqno','pure_purchaserequisition',array('pure_fyear'=>$cur_fiscalyear,'pure_locationid'=>$this->locationid));
           $requsitionno=!empty($requsition_sno)?$requsition_sno +1:1;
        }
        $this->db->trans_begin();
        $ReqMasterArray = array(
           'pure_reqno'=>$requsitionno,
           'pure_itemstypeid'=>$itemtype,
           'pure_reqdatead'=>$requstdateEn,
           'pure_reqdatebs'=>$requstdateNp,
           'pure_requser'=>$requested_by,
           'pure_appliedby'=>$requested_by,
           'pure_requestto'=>$requestedto,
           'pure_isapproved'=>$is_approved,
           'pure_fyear'=>$fiscal_year,
           'pure_isapproved'=>'N',
           'pure_storeid' => $this->storeid,
           'pure_streqno'=>$pure_streqno,
           'pure_reqmasterid'=>$pure_reqmasterid,
           'pure_postdatead'=>CURDATE_EN,
           'pure_postdatebs'=>CURDATE_NP,
           'pure_posttime'=>$curtime,
           'pure_postby'=>$userid,
           'pure_postmac'=>$mac,
           'pure_postip'=>$ip,
           'pure_locationid'=>$this->locationid,
           'pure_orgid'=>$this->orgid

       );
        // echo "<pre>";
        // print_r($ReqMasterArray);
        // die();
        if(!empty($ReqMasterArray))
                {   

                     if(!empty($pure_mattypeid)){
                         $ReqMasterArray['pure_mattypeid']=$pure_mattypeid;
                    }
                    // echo "<pre>";
                    //  print_r($ReqMasterArray);die;
                    $this->db->insert($this->pure_masterTable,$ReqMasterArray);
                    $insertid=$this->db->insert_id();
                    if($insertid)
                    {
                        foreach ($itemsid as $key => $val) {
                            $reqdatebs='';
                            $reqdatead='';
                            $reqdate= !empty($required_date[$key])?$required_date[$key]:'';
                            if(!empty($reqdate)){
                               if(DEFAULT_DATEPICKER=='NP')
                                {
                                    $reqdatebs=$reqdate;
                                    $reqdatead=$this->general->NepToEngDateConv($reqdate);
                                }
                                else
                                {
                                    $reqdatebs=$this->general->EngToNepDateConv($reqdate);
                                    $reqdatead=$reqdate;
                                }
                            }
                         
                            $ReqDetail[]=array(
                                'purd_reqid'=>$insertid,
                                'purd_itemsid'=> !empty($itemsid[$key])?$itemsid[$key]:'',
                                'purd_budcode'=> !empty($code[$key])?$code[$key]:'',
                                'purd_qty'=> !empty($qty[$key])?$qty[$key]:'',
                                'purd_remqty'=> !empty($qty[$key])?$qty[$key]:'',
                                'purd_remarks'=> !empty($remarks[$key])?$remarks[$key]:'',
                                'purd_reqdatead'=> $reqdatead,
                                'purd_reqdatebs'=> $reqdatebs,
                                'purd_stock'=> !empty($stock[$key])?$stock[$key]:'',
                                'purd_unit'=> !empty($unit[$key])?$unit[$key]:'',
                                'purd_fyear' => $fiscal_year,
                                'purd_postdatead'=>CURDATE_EN,
                                'purd_postdatebs'=>CURDATE_NP,
                                'purd_posttime'=>$curtime,
                                'purd_postby'=>$userid,
                                'purd_postmac'=>$mac,
                                'purd_postip'=>$ip,
                                'purd_locationid'=>$this->locationid,
                                'purd_orgid'=>$this->orgid
                            );
                        }
                        if(!empty($ReqDetail))
                        {   //echo"<pre>";print_r($ReqDetail);die;
                    $this->db->insert_batch($this->purd_detailTable,$ReqDetail);
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
            return $insertid;
        }
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
        $this->db->where("pure_reqno like  '%".$get['sSearch_1']."%'  ");
    }
    if(!empty($get['sSearch_2'])){
        $this->db->where("eqty_equipmenttype like  '%".$get['sSearch_2']."%'  ");
    }
    if(!empty($get['sSearch_3'])){
        $this->db->where("pure_requestto like  '%".$get['sSearch_3']."%'  ");
    }
    if(!empty($get['sSearch_4'])){
        $this->db->where("pure_reqdatead like  '%".$get['sSearch_4']."%'  ");
    }
    if(!empty($get['sSearch_5'])){
        $this->db->where("pure_reqdatebs like  '%".$get['sSearch_5']."%'  ");
    }
    if($cond) {
      $this->db->where($cond);
  }
       //  if($this->session->userdata(USER_ACCESS_TYPE)=='S')
        // {
       //   $this->db->where('dist_orgid',$this->session->userdata(ORG_ID));
        // }

  $resltrpt=$this->db->select("cm.*,t.eqty_equipmenttype")
  ->from('pure_purchaserequisition cm')
  ->join('eqty_equipmenttype t','t.eqty_equipmenttypeid = cm.pure_itemstypeid','LEFT')
  ->get();
        //echo $this->db->last_query();die(); 
  $totalfilteredrecs=count($resltrpt); 
  $order_by = 'pure_purchasereqid';
  $order = 'desc';
  if($this->input->get('sSortDir_0'))
  {
    $order = $this->input->get('sSortDir_0');
}

$where='';
if($this->input->get('iSortCol_0')==0)
    $order_by = 'pure_purchasereqid';
else if($this->input->get('iSortCol_0')==1)
    $order_by = 'pure_reqno';
else if($this->input->get('iSortCol_0')==2)
    $order_by = 'eqty_equipmenttype';
else if($this->input->get('iSortCol_0')==3)
    $order_by = 'pure_requestto';
else if($this->input->get('iSortCol_0')==4)
    $order_by = 'pure_reqdatead';
else if($this->input->get('iSortCol_0')==5)
    $order_by = 'pure_reqdatebs';
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
    $this->db->where("pure_reqno like  '%".$get['sSearch_1']."%'  ");
}
if(!empty($get['sSearch_2'])){
    $this->db->where("eqty_equipmenttype like  '%".$get['sSearch_2']."%'  ");
}
if(!empty($get['sSearch_3'])){
    $this->db->where("pure_requestto like  '%".$get['sSearch_3']."%'  ");
}
if(!empty($get['sSearch_4'])){
    $this->db->where("pure_reqdatead like  '%".$get['sSearch_4']."%'  ");
} 
if(!empty($get['sSearch_5'])){
    $this->db->where("pure_reqdatebs like  '%".$get['sSearch_5']."%'  ");
}
       //  if($this->session->userdata(USER_ACCESS_TYPE)=='S')
        // {
       //   $this->db->where('dist_orgid',$this->session->userdata(ORG_ID));
        // }
if($cond) {
  $this->db->where($cond);
}
$this->db->select('cm.*,t.eqty_equipmenttype');
$this->db->from('pure_purchaserequisition cm');
        //$this->db->join('pude_purchaseorderdetail qd','qd.pude_purchasemasterid = cm.puor_purchasorderemaster_id','LEFT');
$this->db->join('eqty_equipmenttype t','t.eqty_equipmenttypeid = cm.pure_itemstypeid','LEFT');

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
if(!empty($_GET['iDisplayLength'])) {
  $totalrecs = sizeof( $nquery);
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

public function getStatusCountRequisition($srchcol = false){
    try{
        $locationid=$this->input->post('locid');
        $frmDate = !empty($this->input->post('frmdate'))?$this->input->post('frmdate'):'';
        $toDate = !empty($this->input->post('todate'))?$this->input->post('todate'):'';
        $mattype=!empty($this->input->post('mattype'))?$this->input->post('mattype'):$this->mattypeid;

        if(!empty($frmDate) && !empty($toDate) ){
            $this->db->where(array('pure_reqdatebs >='=>$frmDate, 'pure_reqdatebs <='=>$toDate));
        }
        $this->db->select("
            SUM(CASE WHEN pure_isapproved='Y' THEN 1 ELSE 0 END ) approved, 
            SUM(case WHEN pure_isapproved='N' THEN 1 ELSE 0 END ) pending, 
            SUM(CASE WHEN pure_isapproved='C' THEN 1 ELSE 0 END ) cancel,
            SUM(CASE WHEN pure_isapproved='V' THEN 1 ELSE 0 END ) verified");
        $this->db->from('pure_purchaserequisition'); 

        if($this->location_ismain=='Y')
        {
            if(!empty($locationid))
            {
                $this->db->where('pure_locationid',$locationid);
            }else{
                $this->db->where('pure_locationid',$this->locationid);
            }
        }
        else
        {
            $this->db->where('pure_locationid',$this->locationid);
        }

        if($srchcol){
            $this->db->where($srchcol);
        }
        if(!empty($mattype)){
            $this->db->where('pure_mattypeid',$mattype);
        }
        $query = $this->db->get();
            // echo $this->db->last_query();die(); 
        if($query->num_rows() > 0){
            return $query->result();
        }
        return false;
    }catch(Exception $e){
        throw $e;
    }
}

public function getStatusCountRequisition_kukl($srchcol = false){
    try{
        $locationid=$this->input->post('locid');
        $frmDate = !empty($this->input->post('frmdate'))?$this->input->post('frmdate'):'';
        $toDate = !empty($this->input->post('todate'))?$this->input->post('todate'):'';
        $this->db->select("
            SUM(CASE WHEN pure_isapproved='Y' THEN 1 ELSE 0 END ) approved, 
            SUM(case WHEN pure_isapproved='N' THEN 1 ELSE 0 END ) pending, 
            SUM(CASE WHEN pure_isapproved='C' THEN 1 ELSE 0 END ) cancel,
            SUM(CASE WHEN pure_isapproved='V' THEN 1 ELSE 0 END ) verified,
            SUM(CASE WHEN pure_isapproved='P' THEN 1 ELSE 0 END ) procurement
            ");
        $this->db->from('pure_purchaserequisition'); 

        if($this->location_ismain=='Y')
        {
            if(!empty($locationid))
            {
                $this->db->where('pure_locationid',$locationid);
            }else{
                $this->db->where('pure_locationid',$this->locationid);
            }
        }
        else
        {
            $this->db->where('pure_locationid',$this->locationid);
        }

        if(!empty(($frmDate && $toDate)))
        {
            if(DEFAULT_DATEPICKER == 'NP'){
                $this->db->where('pure_reqdatebs >=',$frmDate);
                $this->db->where('pure_reqdatebs <=',$toDate);    
            }else{
                $this->db->where('pure_reqdatead >=',$frmDate);
                $this->db->where('pure_reqdatead <=',$toDate);
            }
        }

        if($srchcol){
            $this->db->where($srchcol);
        }
        $query = $this->db->get();
            // echo $this->db->last_query();die(); 
        if($query->num_rows() > 0){
            return $query->result();
        }
        return false;
    }catch(Exception $e){
        throw $e;
    }
}
public function get_purchase_requisition_list($cond=false,$group=false)
{

    $get = $_GET;
    $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');
    $toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');
    $locationid = !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');
    $mattype =!empty($get['mattype'])?$get['mattype']:$this->mattypeid;
    $srchtext=!empty($get['srchtext'])?$get['srchtext']:'';

    foreach ($get as $key => $value) {
        $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
    }
    if(!empty($get['sSearch_0'])){
        $this->db->where("rema_reqmasterid like  '%".$get['sSearch_0']."%'  ");
    }
    if(!empty($get['sSearch_1'])){
        $this->db->where("pure_reqno like  '%".$get['sSearch_1']."%'  ");
    }
    if(!empty($get['sSearch_2'])){
        $this->db->where("pure_streqno like  '%".$get['sSearch_2']."%'  ");
    }
    if(!empty($get['sSearch_3'])){
        $this->db->where("pure_reqdatead like  '%".$get['sSearch_3']."%'  ");
    }
    if(!empty($get['sSearch_4'])){
        $this->db->where("pure_reqdatebs like  '%".$get['sSearch_4']."%'  ");
    }
    if(!empty($get['sSearch_5'])){
        $this->db->where("pure_posttime like  '%".$get['sSearch_5']."%'  ");
    }
    if(!empty($get['sSearch_6'])){
        $this->db->where("pure_fyear like  '%".$get['sSearch_6']."%'  ");
    }
    if(!empty($get['sSearch_7'])){
        $this->db->where("pure_requestto like  '%".$get['sSearch_7']."%'  ");
    }
    if(!empty($get['sSearch_8'])){
        $this->db->where("pure_appliedby like  '%".$get['sSearch_8']."%'  ");
    }     
    if(!empty($get['sSearch_9'])){
        $this->db->where("pure_requser like  '%".$get['sSearch_9']."%'  ");
    }
    if(!empty($get['sSearch_10'])){
        $this->db->where("pure_approvaluser like  '%".$get['sSearch_10']."%'  ");
    }
    if(!empty($get['sSearch_11'])){
        if(DEFAULT_DATEPICKER=='NP')
        {
           $this->db->where("pure_approveddatebs like  '%".$get['sSearch_11']."%'  ");
       }else{
           $this->db->where("pure_approveddatead like  '%".$get['sSearch_11']."%'  ");
       }

   }
   if(!empty($get['sSearch_12'])){
    $this->db->where("pure_reqtime like  '%".$get['sSearch_12']."%'  ");
}

if(!empty(($frmDate && $toDate)))
{
    if(DEFAULT_DATEPICKER == 'NP'){
        $this->db->where('pure_reqdatebs >=',$frmDate);
        $this->db->where('pure_reqdatebs <=',$toDate);    
    }else{
        $this->db->where('pure_reqdatead >=',$frmDate);
        $this->db->where('pure_reqdatead <=',$toDate);
    }
}
if($cond) {
  $this->db->where($cond);
}

if($this->location_ismain=='Y')
{

    if(!empty($locationid)){
        $this->db->where('pure_locationid',$locationid);
    }

}
else
{
   $this->db->where('pure_locationid',$this->locationid);
}

if(!empty($mattype)){
    $this->db->where('pure_mattypeid',$mattype);
}
if(!empty($srchtext)){
    $this->db->where('(pure_streqno='.$srchtext.' OR pure_reqno='.$srchtext.')');
}

$resltrpt=$this->db->select("COUNT(*) as cnt")
->from('pure_purchaserequisition cm')
->join('eqty_equipmenttype t','t.eqty_equipmenttypeid = cm.pure_itemstypeid','LEFT')
                    // ->join('purd_purchasereqdetail qd','qd.purd_reqid = cm.pure_purchasereqid','LEFT')
                    // ->join('itli_itemslist it','it.itli_itemlistid = qd.purd_itemsid','LEFT')

->join('usma_usermain um','um.usma_userid = cm.pure_approvaluser','LEFT')
->get()->row();
       // echo $this->db->last_query();die(); 
$totalfilteredrecs=($resltrpt->cnt);
        //$totalfilteredrecs=$resltrpt->cnt; 
        //print_r($totalfilteredrecs);die;
$order_by = 'pure_purchasereqid';
$order = 'desc';
if($this->input->get('sSortDir_0'))
{
    $order = $this->input->get('sSortDir_0');
}
$where='';
if($this->input->get('iSortCol_0')==0)
    $order_by = 'pure_purchasereqid';
else if($this->input->get('iSortCol_0')==1)
    $order_by = 'pure_reqno';
else if($this->input->get('iSortCol_0')==2)
    $order_by = 'pure_streqno';
else if($this->input->get('iSortCol_0')==3)
    $order_by = 'pure_reqdatead';
else if($this->input->get('iSortCol_0')==4)
    $order_by = 'pure_reqdatebs';
else if($this->input->get('iSortCol_0')==5)
    $order_by = 'pure_posttime';
else if($this->input->get('iSortCol_0')==6)
    $order_by = 'pure_fyear';
else if($this->input->get('iSortCol_0')==7)
    $order_by = 'pure_requestto';
else if($this->input->get('iSortCol_0')==8)
    $order_by = 'pure_appliedby';
else if($this->input->get('iSortCol_0')==9)
    $order_by = 'pure_requser';
else if($this->input->get('iSortCol_0')==10)
    $order_by = 'pure_approvaluser';
else if($this->input->get('iSortCol_0')==11)
    $order_by = 'pure_approveddatebs';
else if($this->input->get('iSortCol_0')==12)
    $order_by = 'pure_reqtime';

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
    $this->db->where("pure_reqno like  '%".$get['sSearch_1']."%'  ");
}
if(!empty($get['sSearch_2'])){
    $this->db->where("pure_streqno like  '%".$get['sSearch_2']."%'  ");
}
if(!empty($get['sSearch_3'])){
    $this->db->where("pure_reqdatead like  '%".$get['sSearch_3']."%'  ");
}
if(!empty($get['sSearch_4'])){
    $this->db->where("pure_reqdatebs like  '%".$get['sSearch_4']."%'  ");
}
if(!empty($get['sSearch_5'])){
    $this->db->where("pure_posttime like  '%".$get['sSearch_5']."%'  ");
}
if(!empty($get['sSearch_6'])){
    $this->db->where("pure_fyear like  '%".$get['sSearch_6']."%'  ");
}
if(!empty($get['sSearch_7'])){
    $this->db->where("pure_requestto like  '%".$get['sSearch_7']."%'  ");
}
if(!empty($get['sSearch_8'])){
    $this->db->where("pure_appliedby like  '%".$get['sSearch_8']."%'  ");
}     
if(!empty($get['sSearch_9'])){
    $this->db->where("pure_requser like  '%".$get['sSearch_9']."%'  ");
}
if(!empty($get['sSearch_10'])){
    $this->db->where("pure_approvaluser like  '%".$get['sSearch_10']."%'  ");
}
if(!empty($get['sSearch_11'])){
    if(DEFAULT_DATEPICKER=='NP')
    {
        $this->db->where("pure_approveddatebs like  '%".$get['sSearch_11']."%'  ");
    }else{
        $this->db->where("pure_approveddatead like  '%".$get['sSearch_11']."%'  ");
    }

}
if(!empty($get['sSearch_12'])){
    $this->db->where("pure_reqtime like  '%".$get['sSearch_12']."%'  ");
}

if($cond) {
  $this->db->where($cond);
}
$locationid = !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');

if(!empty(($frmDate && $toDate)))
{
    if(DEFAULT_DATEPICKER == 'NP'){
        $this->db->where('pure_reqdatebs >=',$frmDate);
        $this->db->where('pure_reqdatebs <=',$toDate);    
    }else{
        $this->db->where('pure_reqdatead >=',$frmDate);
        $this->db->where('pure_reqdatead <=',$toDate);
    }
}
if($this->location_ismain=='Y')
{

    if(!empty($locationid)){
        $this->db->where('pure_locationid',$locationid);
    }

}
else
{
    $this->db->where('pure_locationid',$this->locationid);
}
if(!empty($mattype)){
    $this->db->where('pure_mattypeid',$mattype);
}
if(!empty($srchtext)){
    $this->db->where('(pure_streqno='.$srchtext.' OR pure_reqno='.$srchtext.')');
}

if(ORGANIZATION_NAME=='KU' || ORGANIZATION_NAME=='ARMY'){
    $custom_selcol=',cm.pure_reqmasterid,mt.maty_material';
}else{
    $custom_selcol='';
}
$this->db->select("um.usma_username,cm.pure_purchasereqid,cm.pure_isapproved,rm.rema_reqby,cm.pure_posttime,cm.pure_fyear,cm.pure_approvaluser,cm.pure_approveddatebs,cm.pure_reqno,cm.pure_streqno,cm.pure_reqdatebs,cm.pure_reqdatead,cm.pure_appliedby,cm.pure_requser as user,cm.pure_approveddatead,cm.pure_requestto,pure_locationid,cm.pure_reqtime,cm.pure_postdatead,cm.pure_postdatebs,cm.pure_requestto, cm.pure_accountverify, pm.puor_purchaseordermasterid $custom_selcol");
$this->db->from('pure_purchaserequisition cm');
$this->db->join('rema_reqmaster rm','rm.rema_reqmasterid=cm.pure_reqmasterid','LEFT');
        // $this->db->join('purd_purchasereqdetail qd','qd.purd_reqid = cm.pure_purchasereqid','LEFT');
        // $this->db->join('itli_itemslist it','it.itli_itemlistid = qd.purd_itemsid','LEFT');
if(ORGANIZATION_NAME == 'KUKL'){
    $this->db->join('puor_purchaseordermaster pm','pm.puor_requno = cm.pure_reqno','left');

}else{
    $this->db->join('puor_purchaseordermaster pm',' pm.puor_purchasereqmasterid = cm.pure_purchasereqid ','left');
}
$this->db->join('maty_materialtype mt','mt.maty_materialtypeid=cm.pure_mattypeid','LEFT');

$this->db->join('eqty_equipmenttype t','t.eqty_equipmenttypeid = cm.pure_itemstypeid','LEFT');
$this->db->join('usma_usermain um','um.usma_userid = cm.pure_approvaluser','LEFT');
$this->db->group_by('pure_purchasereqid');
$this->db->order_by($order_by,$order);

if($group)
{
    $this->db->group_by($group);
}
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
// if(!empty($_GET['iDisplayLength'])) {
//   $totalrecs = sizeof($nquery);
// }
 if (!empty($_GET['iDisplayLength']) &&  !empty($resltrpt) && is_array($resltrpt) && sizeof($resltrpt) > 0 ) {
            $totalfilteredrecs = sizeof($resltrpt);
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
public function get_purchase_requisition_data($cond = false)
{   
    if (ORGANIZATION_NAME == 'KUKL') {
        $budget_rows = " , abe.api_usable_budget as budg_availableamt, (case when block_amount > 0 then 'Y' else 'N' END) budget_status"; 
    }else{
        $budget_rows = ' , bg.budg_availableamt, (case when budg_availableamt > purd_totalamt then "Y" else "N" END) budget_status';
    }
    $this->db->select('rd.purd_rate,rd.purd_reqdetid,(SELECT IFNULL(SUM(md.trde_issueqty),0) FROM xw_trde_transactiondetail md LEFT JOIN xw_trma_transactionmain mt   on md.trde_trmaid =mt.trma_trmaid
        WHERE eq.itli_itemlistid=md.trde_itemsid AND mt.trma_received=1 AND md.trde_locationid='.$this->locationid.' AND mt.trma_fromdepartmentid='.$this->storeid.' ) as purd_stock,rd.purd_unit,rd.purd_qty, rd.purd_rate, rd.purd_totalamt, rd.purd_remarks, rd.purd_itemsid,rd.purd_remarks, rd.purd_reqdatebs,eq.itli_itemname,eq.itli_itemnamenp,eq.itli_itemcode,eq.itli_itemlistid,un.unit_unitname,lo.loca_name , rd.purd_proceedorder, rd.purd_estimatecost, rd.purd_estimatetotal, rmd.rede_itrecommend, rmd.rede_itcomment, rm.rema_fyear, rm.rema_reqno, rm.rema_remarks, rm.rema_recommendstatus, rm.rema_workdesc, rm.rema_workplace, rema_postby, purd_accountverify, rm.rema_centralrequest, rm.rema_proceedissue, rm.rema_proceedpurchase, itli_purchaserate,cm.pure_streqno,cm.pure_reqdatebs,cm.pure_reqdatead,cm.pure_mattypeid, cm.pure_estimateamt,rmd.rede_remarks as rmd_remarks'.$budget_rows);
    $this->db->from('purd_purchasereqdetail rd');
    $this->db->join('rede_reqdetail rmd','rmd.rede_reqdetailid=rd.purd_reqdetailid','LEFT');
    $this->db->join('pure_purchaserequisition cm','cm.pure_purchasereqid = rd.purd_reqid','LEFT');
    // $this->db->join('rema_reqmaster rm','rm.rema_reqno=cm.pure_streqno and rm.rema_fyear = cm.pure_fyear','LEFT');

    $this->db->join('xw_rema_reqmaster rm','rm.rema_reqmasterid = cm.pure_reqmasterid','LEFT');

    // $this->db->join('rede_reqdetail rmd','rmd.rede_reqmasterid=rm.rema_reqmasterid','LEFT');
    $this->db->join('itli_itemslist eq','eq.itli_itemlistid = rd.purd_itemsid','LEFT');
    $this->db->join('unit_unit un','un.unit_unitid = eq.itli_unitid','LEFT');
    $this->db->join('loca_location lo','lo.loca_locationid=rd.purd_locationid','LEFT');
    if (ORGANIZATION_NAME == 'KUKL') {
        $this->db->join('api_budgetexpense abe','abe.req_detailid = rmd.rede_reqdetailid AND abe.status = "O" ','left');
    }else{
        $this->db->join('budg_budgets bg','eq.itli_catid = bg.budg_catid','left');
    }
    $this->db->group_by('purd_itemsid');
    $this->db->group_by('purd_remarks'); 
    $this->db->order_by('purd_reqdetid','ASC');
    if($cond)
    {
        $this->db->where($cond);
    }
    $query = $this->db->get();
          // echo $this->db->last_query(); 
          // die();
    if ($query->num_rows() > 0) 
    {
        $data=$query->result();     
        return $data;       
    }       
    return false;
}
public function get_purchase_requisition_master_data($cond = false)
{
    if(ORGANIZATION_NAME=='KUKL'){
         $this->db->select('pr.*,lo.loca_name,rm.rema_workdesc,rm.rema_workplace,rm.rema_remarks, plm.prlm_mattypeid, plm.prlm_status ');
    $this->db->from('pure_purchaserequisition pr');
    $this->db->join('loca_location lo','lo.loca_locationid=pr.pure_locationid','LEFT');
    // $this->db->join('rema_reqmaster rm','rm.rema_reqno=pr.pure_streqno and rm.rema_fyear = pr.pure_fyear','LEFT');
    $this->db->join('xw_rema_reqmaster rm','rm.rema_reqmasterid = pr.pure_reqmasterid','LEFT');
    $this->db->join('prlm_purreqlogmaster plm','plm.prlm_pureid =pr.pure_purchasereqid','LEFT');
    }else{
         $this->db->select('pr.*,lo.loca_name,rm.rema_workdesc,rm.rema_workplace,rm.rema_remarks ');
    $this->db->from('pure_purchaserequisition pr');
    $this->db->join('loca_location lo','lo.loca_locationid=pr.pure_locationid','LEFT');
    // $this->db->join('rema_reqmaster rm','rm.rema_reqno=pr.pure_streqno and rm.rema_fyear = pr.pure_fyear','LEFT');
    $this->db->join('xw_rema_reqmaster rm','rm.rema_reqmasterid = pr.pure_reqmasterid','LEFT');

    }
   
    if($cond)
    {
        $this->db->where($cond);
    }
    $query = $this->db->get();
         // echo $this->db->last_query(); die();
    if ($query->num_rows() > 0) 
    {
        $data=$query->result();     
        return $data;       
    }       
    return false;
}
public function get_purchase_requisition_details($cond = false)
{
    $this->db->select('rd.purd_reqdetid,rd.purd_stock,rd.purd_unit,rd.purd_qty,rd.purd_remarks,rd.purd_reqdatebs,eq.itli_itemname,eq.itli_itemnamenp, eq.itli_itemcode,eq.itli_itemlistid,un.unit_unitname');
    $this->db->from('purd_purchasereqdetail rd');
    $this->db->join('itli_itemslist eq','eq.itli_itemlistid = rd.purd_itemsid','LEFT');
    $this->db->join('unit_unit un','un.unit_unitid = eq.itli_unitid','LEFT');
    if($cond)
    {
        $this->db->where($cond);
    }
    $query = $this->db->get();
       // echo $this->db->last_query(); die();
    if ($query->num_rows() > 0) 
    {
        $data=$query->result();     
        return $data;       
    }       
    return false;
}
public function get_purchase_requisition_selected()
{
   $id = $this->input->post('id');
   $this->db->select('p.*,pd.*,t.eqty_equipmenttype,eq.itli_itemname,eq.itli_itemnamenp');
   $this->db->from('pure_purchaserequisition p');
   $this->db->join('purd_reqdetail pd','pd.purd_reqdetid=p.pure_purchasereqid','LEFT');
   $this->db->join('eqty_equipmenttype t','t.eqty_equipmenttypeid = p.pure_itemstypeid','LEFT');
   $this->db->join('itli_itemslist eq','eq.itli_itemlistid = pd.purd_itemsid','LEFT');
   if($id)
   {
    $this->db->where('pure_purchasereqid', $id);
}
$query = $this->db->get();
        //echo $this->db->last_query(); die();
if ($query->num_rows() > 0) 
{
    $data=$query->result();     
    return $data;       
}       
return false;
}

public function get_purchase_requisition_details_list($cond=false,$group=false)
{
    $get = $_GET;
    foreach ($get as $key => $value) {
        $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
    }
    if(!empty($get['sSearch_0'])){
        $this->db->where("rema_reqmasterid like  '%".$get['sSearch_0']."%'  ");
    }
    if(!empty($get['sSearch_1'])){
        $this->db->where("pure_reqno like  '%".$get['sSearch_1']."%'  ");
    }
    if(!empty($get['sSearch_2'])){
            // $this->db->where("itli_itemname like  '%".$get['sSearch_2']."%'  ");
     $this->db->where("itli_itemname like  '%".$get['sSearch_2']."%' OR itli_itemnamenp like  '%".$get['sSearch_2']."%'  ");
 }
 if(!empty($get['sSearch_3'])){
    $this->db->where("purd_qty like  '%".$get['sSearch_3']."%'  ");
}
if(!empty($get['sSearch_4'])){
    $this->db->where("purd_unit like  '%".$get['sSearch_4']."%'  ");
}
if(!empty($get['sSearch_5'])){
    $this->db->where("pure_reqdatebs like  '%".$get['sSearch_5']."%'  ");
}
if(!empty($get['sSearch_6'])){
    $this->db->where("pure_approvaluser like  '%".$get['sSearch_6']."%'  ");
}
if(!empty($get['sSearch_10'])){
    $this->db->where("pure_approveddatebs like  '%".$get['sSearch_10']."%'  ");
}
if(!empty($get['sSearch_8'])){
    $this->db->where("usma_username like  '%".$get['sSearch_8']."%'  ");
}
if(!empty($get['sSearch_9'])){
    $this->db->where("pure_approveddatebs like  '%".$get['sSearch_9']."%'  ");
}
if(!empty($get['sSearch_11'])){
    $this->db->where("pure_appliedby like  '%".$get['sSearch_11']."%'  ");
}
$frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');
$toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');
$locationid = !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');
$mattypeid = !empty($get['mattype'])?$get['mattype']:$this->mattypeid;

if(!empty(($frmDate && $toDate)))
{
    if(DEFAULT_DATEPICKER == 'NP'){
        $this->db->where('pure_reqdatebs >=',$frmDate);
        $this->db->where('pure_reqdatebs <=',$toDate);    
    }else{
        $this->db->where('pure_reqdatead >=',$frmDate);
        $this->db->where('pure_reqdatead <=',$toDate);
    }
}

        // if(!empty($locationid)){
        //     $this->db->where('pure_locationid',$locationid);
        // }
if($this->location_ismain=='Y')
{

    if(!empty($locationid)){
        $this->db->where('pure_locationid',$locationid);
    }

}
else
{
   $this->db->where('pure_locationid',$this->locationid);
}

if($cond) {
  $this->db->where($cond);
}

if(!empty($mattypeid)){
    $this->db->where('cm.pure_mattypeid',$mattypeid);
}
$resltrpt=$this->db->select("COUNT(*) as cnt")
->from('purd_purchasereqdetail qd')
->join('pure_purchaserequisition cm','cm.pure_purchasereqid = qd.purd_reqid','LEFT')
->join('eqty_equipmenttype t','t.eqty_equipmenttypeid=cm.pure_itemstypeid','LEFT')
->join('itli_itemslist itm','itm.itli_itemlistid = qd.purd_itemsid','LEFT')
->join('usma_usermain um','um.usma_userid = cm.pure_approvaluser','LEFT')
->get()->row();
       // echo $this->db->last_query();die(); 
$totalfilteredrecs=($resltrpt->cnt);
        //$totalfilteredrecs=$resltrpt->cnt; 
        //print_r($totalfilteredrecs);die;
$order_by = 'pure_purchasereqid';
$order = 'desc';
if($this->input->get('sSortDir_0'))
{
    $order = $this->input->get('sSortDir_0');
}
$where='';
if($this->input->get('iSortCol_0')==0)
    $order_by = 'pure_purchasereqid';
else if($this->input->get('iSortCol_0')==1)
    $order_by = 'pure_reqno';
else if($this->input->get('iSortCol_0')==2)
    $order_by = 'itli_itemname';
else if($this->input->get('iSortCol_0')==3)
    $order_by = 'purd_qty';
else if($this->input->get('iSortCol_0')==4)
    $order_by = 'purd_unit';
else if($this->input->get('iSortCol_0')==5)
    $order_by = 'pure_reqdatebs';
else if($this->input->get('iSortCol_0')==6)
    $order_by = 'pure_approvaluser';
else if($this->input->get('iSortCol_0')==7)
    $order_by = 'pure_fyear';
else if($this->input->get('iSortCol_0')==8)
    $order_by = 'usma_username';
else if($this->input->get('iSortCol_0')==9)
    $order_by = 'pure_approveddatebs';
else if($this->input->get('iSortCol_0')==10)
    $order_by = 'pure_approveddatebs';
else if($this->input->get('iSortCol_0')==11)
    $order_by = 'pure_appliedby';

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
    $this->db->where("pure_reqno like  '%".$get['sSearch_1']."%'  ");
}
if(!empty($get['sSearch_2'])){
            // $this->db->where("itli_itemname like  '%".$get['sSearch_2']."%'  ");
  $this->db->where("itli_itemname like  '%".$get['sSearch_2']."%' OR itli_itemnamenp like  '%".$get['sSearch_2']."%'  ");
}
if(!empty($get['sSearch_3'])){
    $this->db->where("purd_qty like  '%".$get['sSearch_3']."%'  ");
}
if(!empty($get['sSearch_4'])){
    $this->db->where("purd_unit like  '%".$get['sSearch_4']."%'  ");
}
if(!empty($get['sSearch_5'])){
    $this->db->where("pure_reqdatebs like  '%".$get['sSearch_5']."%'  ");
}
if(!empty($get['sSearch_6'])){
    $this->db->where("pure_approvaluser like  '%".$get['sSearch_6']."%'  ");
}
if(!empty($get['sSearch_10'])){
    $this->db->where("pure_approveddatebs like  '%".$get['sSearch_10']."%'  ");
}
if(!empty($get['sSearch_8'])){
    $this->db->where("usma_username like  '%".$get['sSearch_8']."%'  ");
} 
if(!empty($get['sSearch_9'])){
    $this->db->where("pure_approveddatebs like  '%".$get['sSearch_9']."%'  ");
}
if(!empty($get['sSearch_11'])){
    $this->db->where("pure_appliedby like  '%".$get['sSearch_11']."%'  ");
}
        //  if($this->session->userdata(USER_ACCESS_TYPE)=='S')
        // {
        //   $this->db->where('dist_orgid',$this->session->userdata(ORG_ID));
        // }
if($cond) {
  $this->db->where($cond);
}

if(!empty(($frmDate && $toDate)))
{
    if(DEFAULT_DATEPICKER == 'NP'){
        $this->db->where('pure_reqdatebs >=',$frmDate);
        $this->db->where('pure_reqdatebs <=',$toDate);    
    }else{
        $this->db->where('pure_reqdatead >=',$frmDate);
        $this->db->where('pure_reqdatead <=',$toDate);
    }
}
$locationid = !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');
if(!empty($locationid)){
    $this->db->where('pure_locationid',$locationid);
}
if(!empty($mattypeid)){
    $this->db->where('cm.pure_mattypeid',$mattypeid);
}

$this->db->select('cm.pure_purchasereqid,cm.pure_isapproved,cm.pure_posttime,cm.pure_fyear,cm.pure_approvaluser,cm.pure_approveddatebs,cm.pure_reqno,cm.pure_reqtime,cm.pure_reqdatebs,cm.pure_reqdatead,cm.pure_appliedby,cm.pure_requser as user,cm.pure_approveddatead,cm.pure_requestto,itm.itli_itemname,itm.itli_itemnamenp,itm.itli_itemcode,qd.purd_qty,qd.purd_remarks,qd.purd_unit,cm.pure_locationid,qd.purd_stock,qd.purd_rate,un.unit_unitname,um.usma_username');

$this->db->from('purd_purchasereqdetail qd');
$this->db->join('pure_purchaserequisition cm','cm.pure_purchasereqid = qd.purd_reqid ','LEFT');

$this->db->join('usma_usermain um','um.usma_userid = cm.pure_approvaluser','LEFT');
$this->db->join('eqty_equipmenttype t','t.eqty_equipmenttypeid = cm.pure_itemstypeid','LEFT');
$this->db->join('itli_itemslist itm','itm.itli_itemlistid = qd.purd_itemsid','LEFT');
$this->db->join('unit_unit un','un.unit_unitid = itm.itli_unitid','LEFT');

$this->db->order_by($order_by,$order);

if($group)
{
    $this->db->group_by($group);
}
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
// if(!empty($_GET['iDisplayLength'])) {
//   $totalrecs = sizeof($nquery);
// }
 if (!empty($_GET['iDisplayLength']) &&  !empty($resltrpt) && is_array($resltrpt) && sizeof($resltrpt) > 0 ) {
            $totalfilteredrecs = sizeof($resltrpt);
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

public function get_pur_requisition_list_db_quot($cond = false)
{
    $get = $_GET;
    foreach ($get as $key => $value) {
        $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
    }

    if(!empty($get['sSearch_1'])){
        $this->db->where("pure_reqno like  '%".$get['sSearch_1']."%'  ");
    }

    if(!empty($get['sSearch_2'])){
        $this->db->where("pure_reqdatebs like  '%".$get['sSearch_2']."%'  ");
    }

    if(!empty($get['sSearch_3'])){
        $this->db->where("pure_reqdatead like  '%".$get['sSearch_3']."%'  ");
    }

    if(!empty($get['sSearch_4'])){
        $this->db->where("pure_appliedby like  '%".$get['sSearch_4']."%'  ");
    }

    if(!empty($get['sSearch_5'])){
        $this->db->where("eqty_equipmenttype like  '%".$get['sSearch_5']."%'  ");
    }

    if(!empty($get['sSearch_6'])){
        $this->db->where("pure_requestto like  '%".$get['sSearch_6']."%'  ");
    }

    if($cond) {
        $this->db->where($cond);
    }

    $resltrpt=$this->db->select("pure_purchasereqid")
    ->from('pure_purchaserequisition pr')
    ->join('eqty_equipmenttype et','et.eqty_equipmenttypeid = pr.pure_itemstypeid','LEFT')
    ->join('puor_purchaseordermaster por','por.puor_requno = pr.pure_purchasereqid  and por.puor_fyear = pr.pure_fyear','LEFT')
    ->where('pure_isapproved','Y')

    ->get()
    ->result();

    $totalfilteredrecs=!sizeof($resltrpt)?$resltrpt:0; 

    $order_by = 'pure_reqno';
    $order = 'desc';

    $where='';
    if($this->input->get('iSortCol_0')==1)
        $order_by = 'pure_reqno';
    else if($this->input->get('iSortCol_0')==2)
        $order_by = 'pure_reqdatebs';
    else if($this->input->get('iSortCol_0')==3)
        $order_by = 'pure_reqdatead';
    else if($this->input->get('iSortCol_0')==4)
        $order_by = 'pure_appliedby';
    else if($this->input->get('iSortCol_0')==5)
        $order_by = 'eqty_equipmenttype';
    else if($this->input->get('iSortCol_0')==6)
        $order_by = 'pure_requestto';

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
        $this->db->where("pure_reqno like  '%".$get['sSearch_1']."%'  ");
    }

    if(!empty($get['sSearch_2'])){
        $this->db->where("pure_reqdatebs like  '%".$get['sSearch_2']."%'  ");
    }

    if(!empty($get['sSearch_3'])){
        $this->db->where("pure_reqdatead like  '%".$get['sSearch_3']."%'  ");
    }

    if(!empty($get['sSearch_4'])){
        $this->db->where("pure_appliedby like  '%".$get['sSearch_4']."%'  ");
    }

    if(!empty($get['sSearch_5'])){
        $this->db->where("eqty_equipmenttype like  '%".$get['sSearch_5']."%'  ");
    }

    if(!empty($get['sSearch_6'])){
        $this->db->where("pure_requestto like  '%".$get['sSearch_6']."%'  ");
    }

    $this->db->select('pure_purchasereqid, pure_reqdatebs, pure_reqdatead, pure_appliedby, pure_reqtime, pure_requestto, pure_fyear, pure_reqno, pure_ordered, et.eqty_equipmenttype, et.eqty_equipmenttypeid');
    $this->db->from('pure_purchaserequisition pr');
    $this->db->join('eqty_equipmenttype et','et.eqty_equipmenttypeid = pr.pure_itemstypeid','LEFT');
    $this->db->where('pure_isapproved','Y');
    if($cond) {
        $this->db->where($cond);
    }

    if($limit && $limit>0)
    {  
        $this->db->limit($limit);
    }

    if($offset)
    {
        $this->db->offset($offset);
    }
    $this->db->order_by($order_by,$order);

    $nquery=$this->db->get();

         // echo $this->db->last_query();die();

    $num_row=$nquery->num_rows();

    if(!empty($_GET['iDisplayLength'])) {
        $totalrecs = sizeof(array($nquery));
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

    return $ndata;
}

public function purchase_requisition_change_status($status =false)
{   
    $masterid = $this->input->post('masterid');

$approve_remarks = $this->input->post('approve_remarks');

$this->db->trans_begin();

if(defined('APPROVEBY_TYPE')):
    if(APPROVEBY_TYPE == 'USER'){
        $approved_id = $this->userid;
        $approved_by = $this->username;
    }else{
        $approved_id = (defined('APPROVER_USERID'))?APPROVER_USERID:'';
        $approved_by = (defined('APPROVER_USERNAME'))?APPROVER_USERNAME:'';
    }
endif;

if($status == 'V'){
    $postdata = array(
        'pure_isapproved' => $status,
        'pure_verifiedby' => $this->userid,
        'pure_verifieddatebs' => CURDATE_NP,
        'pure_verifieddatead' => CURDATE_EN,
        'pure_verifiedtime' => date('H:i:s')
    );
}else{
    $postdata = array(
        'pure_isapproved' => $status,
        'pure_approvaluser' => $approved_id,
        'pure_approvedby' => $approved_id,
        'pure_approveddatebs' => CURDATE_NP,
        'pure_approveddatead' => CURDATE_EN,
        'pure_approveremarks' => $approve_remarks
    );

    if(ORGANIZATION_NAME=='ARMY'){
        $query = $this->db->field_exists('acc_bugetheadid', 'pure_purchaserequisition');
        if($query == TRUE)
            {
             $postdata['pure_accheadid']=!empty($this->input->post('acc_bugetheadid'))?$this->input->post('acc_bugetheadid'):'';
            } 

       
    }
}

// echo "<pre>";
// print_r($postdata);
// die();

$this->db->update('pure_purchaserequisition', $postdata, array('pure_purchasereqid'=>$masterid));

$this->db->trans_complete();
if ($this->db->trans_status() === FALSE){
    $this->db->trans_rollback();
    return false;
}
else{
    $this->db->trans_commit();
    // $rowaffected=$this->db->affected_rows();
     $this->general->saveActionLog('pure_purchaserequisition', $masterid, $this->userid, $status,'pure_isapproved'); 

    return true;
}

// $rowaffected=$this->db->affected_rows();

}

public function get_all_purd_id($srchcol = false){
    try{
        $this->db->select('purd_reqdetid');
        $this->db->from($this->purd_detailTable);
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

public function update_estimate_amount($status){
    $masterid = $this->input->post('masterid');

    $all_estimate_cost = $this->input->post('all_estimate_cost');

    $estimate_total = $this->input->post('total_estimate_cost');

    $all_items_id = $this->input->post('all_items_id');

    $estimate_amt = $this->input->post('pure_estimateamt');

    $all_estimate_item_total = $this->input->post('all_estimate_item_total');

    // echo "<pre>";
    // print_r($this->input->post());
    // die();

    $this->db->trans_begin();

    $pureArray = array(
        'pure_isapproved' => $status,
        'pure_estimateamt' => $estimate_total,
        'pure_verifiedby' => $this->userid,
        'pure_verifieddatebs' => CURDATE_NP,
        'pure_verifieddatead' => CURDATE_EN,
        'pure_verifiedtime' => date('H:i:s')
    );

    $this->db->update('pure_purchaserequisition', $pureArray, array('pure_purchasereqid'=>$masterid));

    $this->general->saveActionLog('pure_purchaserequisition', $masterid, $this->userid, $status,'pure_isapproved'); 

    foreach($all_estimate_cost as $key=>$value){
        $purdArray = array(
            'purd_estimatecost' => $all_estimate_cost[$key],
            'purd_estimatetotal' => $all_estimate_item_total[$key]
        );

        $this->db->where('purd_reqid',$masterid);
        $this->db->where('purd_itemsid',$all_items_id[$key]);
        $this->db->update('purd_purchasereqdetail', $purdArray);
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
}

public function update_qty_to_provide(){
    $masterid = $this->input->post('masterid');

    $all_prov_qty = $this->input->post('all_prov_qty');
    $all_cur_qty = $this->input->post('all_cur_qty');
    $all_items_id = $this->input->post('all_items_id');

    $this->db->trans_begin();

    $pureArray = array(
        'pure_isqtyupdate' => 'Y'
    );

    $this->db->update('pure_purchaserequisition', $pureArray, array('pure_purchasereqid'=>$masterid));

    $this->general->saveActionLog('pure_purchaserequisition', $masterid, $this->userid, 'Y','pure_isqtyupdate'); 

    foreach($all_prov_qty as $key=>$value){
        $purdArray = array(
            'purd_qty' => $all_prov_qty[$key],
            'purd_oldqty' => $all_cur_qty[$key]
        );

        $this->db->where('purd_reqid',$masterid);
        $this->db->where('purd_itemsid',$all_items_id[$key]);
        $this->db->update('purd_purchasereqdetail', $purdArray);
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
}

public function proceed_to_purchase_order(){
    $items_id = $this->input->post('itemlist');
    $masterid = $this->input->post('masterid');
    $materialtype = $this->input->post('materialtype');

    $this->db->trans_begin();

    if(defined('APPROVEBY_TYPE')):
        if(APPROVEBY_TYPE == 'USER'){
            $approved_id = $this->userid;
            $approved_by = $this->username;
        }else{
            $approved_id = (defined('APPROVER_USERID'))?APPROVER_USERID:'';
            $approved_by = (defined('APPROVER_USERNAME'))?APPROVER_USERNAME:'';
        }
    endif;

    $approve_remarks = 'Approved From Budget Available';

    $pureArray = array(
        'pure_isapproved' => 'P'
    );
    $this->db->update('pure_purchaserequisition', $pureArray, array('pure_purchasereqid'=>$masterid));

    $this->general->saveActionLog('pure_purchaserequisition', $masterid, $this->userid, 'P','pure_isapproved'); 

    $this->save_pur_req_log($masterid, $materialtype, $items_id,'P');

    foreach($items_id as $key=>$item){
        $itemArray = array(
            'purd_proceedorder' =>'Y',
        );

        $this->db->where('purd_reqid',$masterid);
        $this->db->where('purd_itemsid',$items_id[$key]);
        $this->db->update('purd_purchasereqdetail',$itemArray);
    }

    $this->db->trans_complete();
    if ($this->db->trans_status() === FALSE){
        $this->db->trans_rollback();
        return false;
    }
    else{
        $this->db->trans_commit();
        $rowaffected=$this->db->affected_rows();
        return true;
    }

    // $rowaffected=$this->db->affected_rows();

    if($rowaffected)
    {
        return $rowaffected;
    }
    else
    {
        return false;
    }
}

public function save_pur_req_log($pure_id=false, $mat_typeid=false, $items_id=false, $prlm_status = false, $update = false){

    // print_r($update);
    // die();

    $items_id = $this->input->post('itemlist');
    $pure_id = $this->input->post('masterid');
    $mat_typeid = $this->input->post('materialtype');
    $status = !empty($this->input->post('approve_status'))?$this->input->post('approve_status'):$prlm_status;

    $this->db->trans_begin();

    $pur_req_log_array = array(
        'prlm_pureid' => $pure_id,
        'prlm_mattypeid' => $mat_typeid,
        'prlm_verified' => '',
        'prlm_status' => $status,
        'prlm_postby' => $this->userid,
        'prlm_postdatebs' => CURDATE_NP,
        'prlm_postdatead' => CURDATE_EN,
        'prlm_posttime' => date('H:i:s'),
        'prlm_locationid' => $this->locationid
    );

    // echo "<pre>";
    // print_r($pur_req_log_array);
    // die();

    if(!empty($update)){
        $prlm_update_array = array(
            'prlm_status' => $status
        );
        $this->db->where('prlm_pureid',$pure_id);
        $this->db->where('prlm_mattypeid',$mat_typeid);
        $this->db->update('prlm_purreqlogmaster',$prlm_update_array);
    }else{

        $this->db->insert('prlm_purreqlogmaster',$pur_req_log_array); 
        $insertid = $this->db->insert_id();
    }
   
    if(empty($update)){
        foreach($items_id as $key=>$item){
      
            $get_material_type = $this->general->get_tbl_data('itli_materialtypeid','itli_itemslist',array('itli_itemlistid'=>$items_id[$key]));
            $material_typeid = !empty($get_material_type[0]->itli_materialtypeid)?$get_material_type[0]->itli_materialtypeid:0;
            
            $prld_detailArray = array(
                'prld_prlmid' => $insertid,
                'prld_pureid' =>$pure_id,
                // 'prld_purdid' => $purd_id[$key],
                'prld_itemsid' => $items_id[$key],
                'prld_mattypeid' => $material_typeid,
                'prld_isverified' => '',
                'prld_status' =>'Y',
                'prld_postby' => $this->userid,
                'prld_postdatebs' => CURDATE_NP,
                'prld_postdatead' => CURDATE_EN,
                'prld_posttime' => date('H:i:s'),
                'prld_locationid' => $this->locationid
            );

            $this->db->insert('prld_purreqlogdetail',$prld_detailArray);
        }
    }
    
    $this->db->trans_complete();
    if ($this->db->trans_status() === FALSE){
        $this->db->trans_rollback();
        return false;
    }
    else{
        $this->db->trans_commit();
        $rowaffected=$this->db->affected_rows();
        return true;
    }

    // $rowaffected=$this->db->affected_rows();

    if($rowaffected)
    {
        return $rowaffected;
    }
    else
    {
        return false;
    }
}

public function notify_budget_unavailable(){
        // $items_id = $this->input->post('itemlist');

    $masterid = $this->input->post('masterid');

    $this->db->trans_begin();

    $pureArray = array(
            'pure_isapproved' => 'B' //budget unavailable
        );
    $this->db->update('pure_purchaserequisition', $pureArray, array('pure_purchasereqid'=>$masterid));

    $this->general->saveActionLog('pure_purchaserequisition', $masterid, $this->userid, 'B','pure_isapproved'); 

        // foreach($items_id as $key=>$item){
        //     $itemArray = array(
        //         'purd_proceedorder' =>'N',
        //     );

        //     $this->db->where('purd_reqid',$masterid);
        //     $this->db->where('purd_itemsid',$items_id[$key]);
        //     $this->db->update('purd_purchasereqdetail',$itemArray);
        // }

    $this->db->trans_complete();
    if ($this->db->trans_status() === FALSE){
        $this->db->trans_rollback();
        return false;
    }
    else{
        $this->db->trans_commit();
        $rowaffected=$this->db->affected_rows();
        return true;
    }

    // $rowaffected=$this->db->affected_rows();

    if($rowaffected)
    {
        return $rowaffected;
    }
    else
    {
        return false;
    }
}

public function send_to_purchase_order_approval(){

    try{
    $items_id = $this->input->post('itemlist');

    $approve_status = $this->input->post('approve_status');

    $masterid = $this->input->post('masterid');

    $materialtype = $this->input->post('materialtype');

    $this->db->trans_begin();

    if(defined('APPROVEBY_TYPE')):
        if(APPROVEBY_TYPE == 'USER'){
            $approved_id = $this->userid;
            $approved_by = $this->username;
        }else{
            $approved_id = (defined('APPROVER_USERID'))?APPROVER_USERID:'';
            $approved_by = (defined('APPROVER_USERNAME'))?APPROVER_USERNAME:'';
        }
    endif;

    $approve_remarks = '';
    if($approve_status == 'M'){ // M -> Branch Manager
        $approve_remarks = "Get Approval From Branch Manager";
    }

    $pureArray = array(
        'pure_isapproved' => $approve_status,
        'pure_approvaluser' => $approved_id,
        'pure_approvedby' => $approved_id,
        'pure_approveddatebs' => CURDATE_NP,
        'pure_approveddatead' => CURDATE_EN,
        'pure_approveremarks' => $approve_remarks
    );

    // echo "<pre>";
    // print_r($items_id);
    // die();

    // Reject the purchase so release the hold amount. 

    if ($approve_status == 'R') {
         if (defined('RUN_API') && RUN_API == 'Y'){
            if (defined('API_CALL') && API_CALL == 'KUKL') {
                if ($masterid) {

                    $this->db->select('pure_reqmasterid');
                    $this->db->from('pure_purchaserequisition');
                    $this->db->where('pure_purchasereqid',$masterid);
                    $purd_details = $this->db->get()->row();   

                    if(!empty($purd_details)){
                        
                        $this->db->where('req_masterid',$purd_details->pure_reqmasterid);
                        $this->db->where('status','O');
                        $this->db->where('locationid',$this->locationid);
                        $this->db->where('orgid',$this->orgid);
                        $this->db->from('api_budgetexpense');
                        $expense_data = $this->db->get()->row(); 

                        if ($expense_data) { 
                            $post_data = array(
                                "Budget_id"=> 0,
                                "Amount"=> 0,
                                'r_Status' => "C",   
                                'Entry_By' => null,
                                'Entry_Date' => null,
                                'Req_MasterId'=> $expense_data->req_masterid,
                                "req_detailId"=> 0,
                                "Item_Description"=> null,
                                "Rem_Amount"=> 0,
                                "Req_DateEn"=> null,
                                "Req_DateNp"=> null,
                                "Office_code"=> 0,
                                "Demand_No"=> 0, 
                                "Fyear"=> null,
                                "Updated_Date"=> str_replace('/', '.', CURDATE_NP), 
                                "Updated_Time"=> $this->general->get_currenttime(),
                                "Updated_By" => $this->username,
                                "Entrytime"=> null,
                                "Remarks" => 'Cancel Purchase Request', 
                                "insUp" => "UP" 
                            ); 

                            // print_r($post_data);
                            // die(); 
                            if($this->general->api_send_budget_demand_amount($post_data)){ 
 
                                $this->db->where('req_masterid',$purd_details->pure_reqmasterid);
                                $this->db->where('status','O'); 
                                $this->db->where('locationid',$this->locationid);
                                $this->db->where('orgid',$this->orgid);
                                $this->db->update('api_budgetexpense',array('status' => 'C'));
                            }
                        }
                         
                    }
                }
            }
        }
    }
    // die();
    $this->db->update('pure_purchaserequisition', $pureArray, array('pure_purchasereqid'=>$masterid));

    if($approve_status == 'M'){
        $this->save_pur_req_log($masterid, $materialtype, $items_id, $approve_status);
    }else{
        $this->save_pur_req_log($masterid, $materialtype, $items_id, $approve_status,'update');
    }

    $this->general->saveActionLog('pure_purchaserequisition', $masterid, $this->userid, $approve_status,'pure_isapproved',$approve_remarks); 

    if(!empty($items_id)):
        foreach($items_id as $key=>$value){

            if($approve_status == 'M'){
                $purdArray = array(
                    'purd_verification' => '1', // send for approval to bm
                    'purd_proceedmanager' => 'Y'
                );
            }else{
                $purdArray = array(
                    'purd_verification' => '1', // send for approval to bm
                    'purd_proceedorder' => 'Y'
                );
            }
            
            $this->db->where('purd_reqid',$masterid);
            $this->db->where('purd_itemsid',$items_id[$key]);
            $this->db->update('purd_purchasereqdetail', $purdArray);
        }
    endif;

    $this->db->trans_complete();
    if ($this->db->trans_status() === FALSE){
        $this->db->trans_rollback();
        return false;
    }
    else{
        $this->db->trans_commit();
        $rowaffected=$this->db->affected_rows();
    }

    // $rowaffected=$this->db->affected_rows();

    if($rowaffected)
    {
        return $rowaffected;
    }
    else
    {
        return false;
    }
    }catch(Exception $e){
        $this->db->trans_rollback();
        return false;
    }
}

// after update market price in purchase order
public function send_to_purchase_order_market_price($items_id, $approve_status, $masterid, $materialtype){

    if(defined('APPROVEBY_TYPE')):
        if(APPROVEBY_TYPE == 'USER'){
            $approved_id = $this->userid;
            $approved_by = $this->username;
        }else{
            $approved_id = (defined('APPROVER_USERID'))?APPROVER_USERID:'';
            $approved_by = (defined('APPROVER_USERNAME'))?APPROVER_USERNAME:'';
        }
    endif;

    $approve_remarks = 'Approved from branch manager';

    $this->db->trans_begin();

    $pureArray = array(
        'pure_isapproved' => $approve_status,
        'pure_approvaluser' => $approved_id,
        'pure_approvedby' => $approved_id,
        'pure_approveddatebs' => CURDATE_NP,
        'pure_approveddatead' => CURDATE_EN,
        'pure_approveremarks' => $approve_remarks
    );
    $this->db->update('pure_purchaserequisition', $pureArray, array('pure_purchasereqid'=>$masterid));

    $this->save_pur_req_log($masterid, $materialtype, $items_id, $approve_status,'update');

    $this->general->saveActionLog('pure_purchaserequisition', $masterid, $this->userid, $approve_status,'pure_isapproved'); 

    $this->db->trans_complete();
    if ($this->db->trans_status() === FALSE){
        $this->db->trans_rollback();
        return false;
    }
    else{
        $this->db->trans_commit();
        $rowaffected=$this->db->affected_rows();
        return true;
    }

    // $rowaffected=$this->db->affected_rows();

    if($rowaffected)
    {
        return $rowaffected;
    }
    else
    {
        return false;
    }
}

public function procced_to_next_accountant(){
    try{
        $masterid = $this->input->post('masterid');
        $mat_typeid = $this->input->post('materialtype');
        $items_id = $this->input->post('itemlist');

        $account_verification_comment = $this->input->post('account_verification_comment');
        $account_verification_level = $this->input->post('account_verification_level');

        $account_status = $this->input->post('account_status');  

        $this->db->trans_begin();

        if($account_status == 'D'){
            $pureArray = array(
                'pure_status' => $account_status
            );

            if (defined('RUN_API') && RUN_API == 'Y'){
                if (defined('API_CALL') && API_CALL == 'KUKL') {
                    if ($masterid) {

                        $this->db->select('purd_reqdetailid');
                        $this->db->from('purd_purchasereqdetail');
                        $this->db->where('purd_reqid',$masterid);
                        $this->db->where_in('purd_itemsid',$items_id); 
                        $purd_details = $this->db->get()->result();   

                        if(!empty($purd_details) && count($purd_details)){

                            foreach($purd_details as $detail){
                            
                                $this->db->where('req_detailid',$detail->purd_reqdetailid);
                                $this->db->where('status','O');
                                $this->db->where('locationid',$this->locationid);
                                $this->db->where('orgid',$this->orgid);
                                $this->db->from('api_budgetexpense'); 
                                $expense_data = $this->db->get()->row();

                                if ($expense_data) {
                                    $post_data = array(
                                        'Req_MasterId'=> $expense_data->req_masterid,
                                        'req_detailId' => $expense_data->req_detailid,
                                        'r_Status' => 'C', 
                                        'insUp' => 'UP', 
                                        'Entry_By' => null,
                                        'Entry_Date' => null,
                                        "Remarks" => 'Cancel Item', 
                                        "Budget_id"=> 0, 
                                        "Amount"=> 0,
                                        "Item_Description"=> null,
                                        "Rem_Amount"=> 0,
                                        "Req_DateEn"=> null,
                                        "Req_DateNp"=> null,
                                        "Office_code"=> 0,
                                        "Demand_No"=> 0, 
                                        "Fyear"=> null,
                                        "Updated_Date"=> str_replace('/', '.', CURDATE_NP), 
                                        "Updated_Time"=> $this->general->get_currenttime(),
                                        "Updated_By" => $this->username,
                                        "Entrytime"=> null,
                                    ); 
                             
                                    if($this->general->api_send_budget_demand_amount($post_data)){

                                        $this->db->where('id',$expense_data->id);
                                        $this->db->update('api_budgetexpense',array('status' => 'C'));
                                    }
                                }
                            }   
                        }
                    }
                }
            }

            $this->general->saveActionLog('pure_purchaserequisition', $masterid, $this->userid, $account_status,'pure_status', "Decline by Account Section");
        }else{
           $pureArray = array(
                'pure_accountverify' => $account_verification_level,
                'pure_status' => $account_status,
            );
        }

        $this->db->update('pure_purchaserequisition', $pureArray, array('pure_purchasereqid'=>$masterid));

        $this->save_acc_ver_log($masterid, $mat_typeid, $items_id, $account_verification_level, false);

        if (!empty($items_id)) {
        foreach($items_id as $key=>$value){
            $purdArray = array(
                'purd_accountverify' => $account_verification_level
            );

            $this->db->where('purd_reqid',$masterid);
            $this->db->where('purd_itemsid',$items_id[$key]);
            $this->db->update('purd_purchasereqdetail', $purdArray);
        }   
        }

        $this->general->saveActionLog('pure_purchaserequisition', $masterid, $this->userid, $account_verification_level,'pure_accountverify', $account_verification_comment);

        // send message to account verifier
        $get_data = $this->general->get_tbl_data('pure_reqno','pure_purchaserequisition',array('pure_purchasereqid'=>$masterid));
        $procureno = !empty($get_data[0]->pure_reqno)?$get_data[0]->pure_reqno:0;

        $mess_user = array('AV');
        $message = "Please verify the budget for procument of demand no. $procureno";
        $mess_title = $mess_message = $message;
        $mess_path = 'purchase_receive/purchase_requisition/pur_req_book';

        $this->general->send_message_to_user($mess_user, $mess_title, $mess_message, $mess_path, 'G');

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            $rowaffected=$this->db->affected_rows();
            return true;
        } 

        // $rowaffected=$this->db->affected_rows();

        if($rowaffected)
        {
            return $rowaffected;
        }
        else
        {
            return false;
        }
    }catch(Exception $e){
        $this->db->trans_rollback();
        return false;
    }
    
}

public function procced_to_next_accountant_verifier(){
    $masterid = $this->input->post('masterid');
    $items_id = $this->input->post('itemlist');

    $account_verifcation_comment = $this->input->post('account_verifcation_comment');
    $account_verification_status = $this->input->post('account_verification_status');
        // $account_verification_level = $this->input->post('account_verification_level');
    $last_verification_level = $this->input->post('last_verification_level');

    $account_verifier = $this->input->post('account_verifier');

    $previous_account_verification_flow = $this->input->post('previous_account_verification_flow');

    $account_verifier_id = $account_verification_level = '';
    if($account_verifier != '0'){
        $account_verifier_data = explode('|',$account_verifier);

        $account_verifier_id = $account_verifier_data[0];
        $account_verification_level = !empty($account_verifier_data[1])?$account_verifier_data[1]:'0';
    }else{
        $account_verifier_id = '';
        $account_verification_level = $last_verification_level+1;
    }

    $account_verifier_list = $this->general->get_user_list_by_group(false, 'AV','usma_accountlvl');

    $count_verifier = count($account_verifier_list);

    if($account_verifier == '0'){
        if($last_verification_level >= $count_verifier || $previous_account_verification_flow == 'B'){
            $account_verification_flow = 'B';
            $account_verification_level = $last_verification_level-1;

        }else{
         $account_verification_flow = 'F';
     }

 }else{
    if($last_verification_level >= $account_verification_level || $previous_account_verification_flow == 'B'){
        $account_verification_flow = 'B';
    }else{
     $account_verification_flow = 'F';
    }

}

$this->db->trans_begin();

if($account_verification_level == '0'){
     $pureArray = array(
        'pure_accountverify' => $account_verification_level,
        'pure_verifyflow' => $account_verification_flow,
        'pure_isapproved' => 'M' 
    );

     if(!empty($items_id)):
        foreach($items_id as $key=>$value){
            $purdArray = array(
                'purd_verification' => '1', // send for approval to bm
                'purd_proceedmanager' => 'Y'
            );

            $this->db->where('purd_reqid',$masterid);
            $this->db->where('purd_itemsid',$items_id[$key]);
            $this->db->update('purd_purchasereqdetail', $purdArray);
        }
    endif;
}else{
     $pureArray = array(
        'pure_accountverify' => $account_verification_level,
        'pure_verifyflow' => $account_verification_flow 
    ); 
}

$this->db->update('pure_purchaserequisition', $pureArray, array('pure_purchasereqid'=>$masterid));

if($account_verification_level == '0'){
    $this->general->saveActionLog('pure_purchaserequisition', $masterid, $this->userid, $account_verification_level,'pure_accountverify', $account_verifcation_comment);
    $this->general->saveActionLog('pure_purchaserequisition', $masterid, $this->userid, 'M','pure_isapproved', $account_verifcation_comment);
}
else{
    $this->general->saveActionLog('pure_purchaserequisition', $masterid, $this->userid, $account_verification_level,'pure_accountverify', $account_verifcation_comment);   
}

        // message start
$get_data = $this->general->get_tbl_data('*','pure_purchaserequisition',array('pure_purchasereqid'=>$masterid));
$procureno = $get_data[0]->pure_reqno;
$mess_user = array('AV');

if($previous_account_verification_flow == 'B'){
   $account_verification_level=$last_verification_level+1;
   $var_point="Down to";

}else{
    $var_point="Upto";

}

$message = "procurement for demand No.$procureno  has been Approved  $var_point Account $account_verification_level.";

$mess_title = $mess_message = $message;

$mess_path = 'purchase_receive/purchase_requisition/pur_req_book';

$this->general->send_message_to_user($mess_user, $mess_title, $mess_message, $mess_path, 'G');

if($account_verification_level == 0 || $previous_account_verification_flow == 'B'){

    $get_data = $this->general->get_tbl_data('*','pure_purchaserequisition',array('pure_purchasereqid'=>$masterid));
    $procureno = $get_data[0]->pure_reqno;
    $mess_user = array('BM');

    $message = "Procurement For Demand No.$procureno has been all 4 level Verified Please Process to Purchase Order.";

    $mess_title = $mess_message = $message;

    $mess_path = 'purchase_receive/purchase_requisition/pur_req_book';

    $this->general->send_message_to_user($mess_user, $mess_title, $mess_message, $mess_path, 'G');
}

        // message end
// $this->save_acc_ver_log($masterid, false, $items_id, $account_verification_level, false);

$this->db->trans_begin();
$this->db->trans_complete();
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            $rowaffected=$this->db->affected_rows();
            return true;
        }

// $rowaffected=$this->db->affected_rows();

if($rowaffected)
{
    return $rowaffected;
}
else
{
    return false;
}
}

public function get_account_verification_history($id, $fieldname = false){
    try{
        $this->db->select('um.usma_fullname, al.aclo_comment, al.aclo_status, al.aclo_fieldname, aclo_actiondatebs, aclo_actiontime, aclo_actiondatead');
        $this->db->from('aclo_actionlog al');
        $this->db->join('usma_usermain um', 'um.usma_userid = al.aclo_userid');
        $this->db->where('aclo_masterid',$id);
        $this->db->where('aclo_fieldname',$fieldname);
        $this->db->where('aclo_comment !=','');

        $query = $this->db->get();
        if($query->num_rows() > 0){
            $result = $query->result();
            return $result;
        }
    }catch(Exception $e){
        throw $e;
    }
}
public function getColorStatusCount($srchcol = false){

   $con1='';
   if($srchcol){
    if($this->location_ismain=='Y'){
     $con1= $srchcol;
 }else{

   $con1.= $srchcol;
   $con1.=" AND pure_locationid ='".$this->locationid."'";
}
}else{
   $con1='';
}

$sql="SELECT * FROM
xw_coco_colorcode cc
LEFT JOIN (
SELECT
pure_isapproved,
COUNT('*') AS statuscount
FROM
xw_pure_purchaserequisition pr
".$con1."
GROUP BY
pure_isapproved
) X ON X.pure_isapproved = cc.coco_statusval
WHERE
cc.coco_listname = 'req_purchasereqsummarylist'
AND cc.coco_statusval <> ''";

$query = $this->db->query($sql);
         // echo $this->db->last_query();
         // die();
return $query->result();

}

public function save_acc_ver_log($pure_id=false, $mat_typeid=false, $items_id=false, $status = false, $update = false){

    // print_r($update);
    // die();

    $items_id = $this->input->post('itemlist');
    $pure_id = $this->input->post('masterid');
    $mat_typeid = $this->input->post('materialtype');
    $status = $this->input->post('approve_status');
    // $update = 'update';

    $this->db->trans_begin();

    $acc_ver_array = array(
        'avlm_pureid' => $pure_id,
        'avlm_mattypeid' => $mat_typeid,
        'avlm_verified' => '',
        'avlm_status' => $status
    );

    if(!empty($update)){
        $acc_ver_update_array = array(
            'avlm_status' => $status
        );
        $this->db->where('avlm_pureid',$pure_id);
        $this->db->where('avlm_mattypeid',$mat_typeid);
        $this->db->update('avlm_accverlogmaster',$acc_ver_update_array);
    }else{

        $this->db->insert('avlm_accverlogmaster',$acc_ver_array); 
    }
   
    if(empty($update)){
        foreach($items_id as $key=>$item){
            $acc_ver_detailArray = array(
                'avld_pureid' =>$pure_id,
                // 'avld_purdid' => $purd_id[$key],
                'avld_itemsid' => $items_id[$key],
                'avld_mattypeid' => $mat_typeid,
                'avld_isverified' => '',
                'avld_status' =>'Y'
            );

            $this->db->insert('avld_accverlogdetail',$acc_ver_detailArray);
        }
    }

    $this->db->trans_complete();
    if ($this->db->trans_status() === FALSE){
        $this->db->trans_rollback();
        return false;
    }
    else{
        $this->db->trans_commit();
        $rowaffected=$this->db->affected_rows();
    }
    
    // $rowaffected=$this->db->affected_rows();

    if($rowaffected)
    {
        return $rowaffected;
    }
    else
    {
        return false;
    }
}

public function check_purchase_order_items($pude_requsitionid){
    $sql = "select count('purd_reqdetid') as totalcnt from xw_purd_purchasereqdetail xpp where purd_reqdetid =(select pude_requsitionid from xw_pude_purchaseorderdetail xpp where pude_requsitionid = $pude_requsitionid)";
    $query = $this->db->query($sql);
    return $query->result();

}

public function get_purd_items_count($srchcol = false){
        try{
            $this->db->select(" 
                purd_reqdetid, 
                count(purd_itemsid) ttl_count,
                sum(case when purd_proceedmanager = 'Y' and purd_estimatetotal > budg_availableamt then 1 else 0 end) proceed_man_count_no_budget,
                sum(case when purd_proceedmanager = 'Y' and purd_estimatetotal < budg_availableamt then 1 else 0 end) proceed_man_count_budget,
                sum(case when purd_proceedmanager = 'Y' then 1 else 0 end) proceed_man_count,
                sum(case when purd_estimatetotal > budg_availableamt then 1 else 0 end) count_no_budget,
                sum(case when purd_estimatetotal < budg_availableamt then 1 else 0 end) count_budget ,
                sum(case when purd_proceedorder = 'Y' then 1 else 0 end) proceed_ord_count
            ");
            $this->db->from('purd_purchasereqdetail p');
            $this->db->join('itli_itemslist it','it.itli_itemlistid = p.purd_itemsid');
            $this->db->join('budg_budgets b','b.budg_catid = it.itli_catid');
            
            if($srchcol){
                $this->db->where($srchcol);
            }

            $query = $this->db->get();
           // echo $this->db->last_query();
           //  die;

            if($query->num_rows() > 0){
                return $query->result();
            }
            return false;

        }catch(Exception $e){
            throw $e;
        }
    }

public function get_purd_items_count_new($srchcol = false){
    try{
        $this->db->select(" 
            purd_reqdetid,
            purd_reqdetailid,
            sum(case when purd_estimatetotal <= abe.remaning_blocked_amount then 1 else 0 end) count_budget,   
        ");
        $this->db->from('purd_purchasereqdetail p');
        $this->db->join('api_budgetexpense abe','abe.req_detailid = p.purd_reqdetailid');
        $this->db->where('abe.status','O');
        
        if($srchcol){
            $this->db->where($srchcol);
        }

        $query = $this->db->get();

        if($query->num_rows() > 0){
            return $query->result();
        }
        return false;

    }catch(Exception $e){
        throw $e;
    }
}

}