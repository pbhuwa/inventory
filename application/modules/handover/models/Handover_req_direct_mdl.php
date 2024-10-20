<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Handover_req_direct_mdl extends CI_Model
{
    public function __construct(){
        parent::__construct();
        $this->harm_masterTable='harm_handoverreqmaster';
        $this->hard_detailTable='hard_handoverreqdetail';
        $this->userid = $this->session->userdata(USER_ID);
        $this->username = $this->session->userdata(USER_NAME);
        $this->curtime = $this->general->get_currenttime();
        $this->mac = $this->general->get_Mac_Address();
        $this->ip = $this->general->get_real_ipaddr();
        $this->locationid=$this->session->userdata(LOCATION_ID);
        $this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
        $this->orgid=$this->session->userdata(ORG_ID);
        $this->load->Model('stock_inventory/stock_requisition_mdl');
    }
    public $validate_settings_handover_requisition = array(
        array('field' => 'harm_handoverreqno', 'label' => 'REQ Number', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'harm_requestedby', 'label' => 'Requested By', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'harm_fromlocationid', 'label' => 'Department ', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'hard_itemsid[]', 'label' => 'Items ', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'hard_qty[]', 'label' => 'Required .Qty ', 'rules' => 'trim|required|xss_clean|greater_than[0]'),

    );
    public function save_handover_direct(){       
        try{
            //   $postdata=$this->input->post();
            // echo "<pre>";print_r($postdata);die();
            $id = $this->input->post('id');
            $req_date=$this->input->post('harm_reqdate');
            $approved_date=$this->input->post('harm_approveddate');
            if(DEFAULT_DATEPICKER=='NP')
            {
                $reqdatebs=$req_date;
                $reqdatead=$this->general->NepToEngDateConv($req_date);

                $approveddatebs=$approved_date;
                $approveddatead=$this->general->NepToEngDateConv($approved_date);
            }
            else
            {
                $reqdatead=$req_date;
                $reqdatebs=$this->general->EngToNepDateConv($req_date);

                $approveddatead=$approved_date;
                $approveddatebs=$this->general->EngToNepDateConv($approved_date);
            }
            $harm_ishandover=$this->input->post('harm_ishandover');
            $harm_storeid = $this->session->userdata(STORE_ID); //need check
            $harm_manualno = $this->input->post('harm_manualno');
            $harm_fromlocationid = $this->input->post('harm_fromlocationid'); 
            $harm_tolocationid = $this->input->post('harm_tolocationid');  
            $harm_fromdepid = $this->input->post('harm_fromdepid');
            $harm_requestedby = $this->input->post('harm_requestedby');
            $harm_remarks = $this->input->post('harm_remarks');
            //if approval
            $harm_approved = $this->input->post('harm_approved');
            $harm_approvedby = $this->input->post('harm_approvedby');
            $subottaltotal = $this->input->post('subtotalamt');
            $grandtotal = $this->input->post('totalamount');
            $hard_unitprice =   $this->input->post('hard_unitprice');
            $hard_totalamt =   $this->input->post('hard_totalamt');
            $remarks = $this->input->post('remarks');
            // $generate_reqno = $this->get_req_no(array('harm_fyear'=>CUR_FISCALYEAR));

            // $reqno = '';
            // if(!empty($generate_reqno)){
            //  $reqno = !empty($generate_reqno[0]->handoverreqno)?$generate_reqno[0]->handoverreqno+1:1;
            // }
            // if($id){
            //  $harm_handoverreqno = $this->input->post('harm_handoverreqno');
            // }else{
            //  $harm_handoverreqno = $reqno;    
            // }
            // $reme_remarks =   $this->input->post('harm_remarks');
            // Handover detail items
            $harm_handoverreqno = $this->input->post('harm_handoverreqno');
            $itemcode = $this->input->post('hard_code');
            $itemsid = $this->input->post('hard_itemsid');
            $hard_unit =   $this->input->post('hard_unit');
            $qty =   $this->input->post('hard_qty');
            $remarks =   $this->input->post('hard_remarks');
            $qtyinstock =   $this->input->post('hard_qtyinstock');
              $totalamount =   $this->input->post('totalamount');
            // echo "<pre>";
            // print_r($qtyinstock);
            // die();
            $reqdetailid = $this->input->post('hard_handoverdetailid');
            $this->db->trans_begin();
            if($id){ // update
                //update master
                $ReqMasterArray = array(
                    'harm_handoverreqno'=>$harm_handoverreqno,
                    'harm_ishandover'=>$harm_ishandover,
                    'harm_storeid'=>$harm_storeid,
                    'harm_reqdatebs'=>$reqdatebs,
                    'harm_reqdatead'=>$reqdatead,
                    'harm_manualno'=>$harm_manualno,
                    'harm_remarks'=>$harm_remarks,
                    'harm_fromlocationid'=>$harm_fromlocationid,
                    'harm_tolocationid'=>$harm_tolocationid,
                    'harm_fromdepid'=>$harm_fromdepid,
                    'harm_requestedby'=>$harm_requestedby,
                    'harm_fyear'=>CUR_FISCALYEAR,
                    'harm_estimatecost'=>$totalamount,   
                    'harm_username'=>$this->username,
                    'harm_modifydatead'=>CURDATE_EN,
                    'harm_modifydatebs'=>CURDATE_NP,
                    'harm_modifytime'=>$this->curtime,
                    'harm_modifyby'=>$this->userid,
                    'harm_modifymac'=>$this->mac,
                    'harm_modifyip'=>$this->ip,
                    'harm_locationid'=>$this->locationid,   
                    'harm_orgid'=>$this->orgid
                );
                if($ReqMasterArray) {
                    $this->db->where('harm_handovermasterid',$id);
                    $this->db->update($this->harm_masterTable,$ReqMasterArray);
                }             
                // update detail
                $ReqMasterArray['harm_approved'] = '0';//$harm_approved;
                $ReqMasterArray['harm_approvedby'] = $harm_approvedby;
                $ReqMasterArray['harm_approveddatebs'] = $approveddatebs;
                $ReqMasterArray['harm_approveddatead'] = $approveddatead;
                $old_hard_list = $this->get_all_hard_id(array('hard_handovermasterid'=>$id)); // check old req detail ids
                $old_hard_array=array();
                if(!empty($old_hard_list)){
                    foreach($old_hard_list as $key=>$value){
                        $old_hard_array[] = $value->hard_handoverdetailid;
                    }
                }
                $hard_insertid=array();
                    // if($rowaffected){
                if(!empty($itemsid)){
                    foreach($itemsid as $key=>$val){
                        $reqdetlid = !empty($reqdetailid[$key])?$reqdetailid[$key]:'';
                        if($reqdetlid){
                            if(in_array($reqdetlid, $old_hard_array)){
                                $hard_array[] = $reqdetlid;
                            }
                            $hard_update_array = array(
                                'hard_itemsid'=> !empty($itemsid[$key])?$itemsid[$key]:'',
                                'hard_code'=> !empty($itemcode[$key])?$itemcode[$key]:'',
                                'hard_unit'=> !empty($hard_unit[$key])?$hard_unit[$key]:'',
                                'hard_qty'=> !empty($qty[$key])?$qty[$key]:'',
                                'hard_remqty'=> !empty($qty[$key])?$qty[$key]:'',
                                'hard_remarks'=> !empty($remarks[$key])?$remarks[$key]:'',
                                'hard_unitprice'=> !empty($hard_unitprice[$key])?$hard_unitprice[$key]:'',
                                'hard_totalamt'=> !empty($hard_totalamt[$key])?$hard_totalamt[$key]:'',
                                'hard_modifydatead'=>CURDATE_EN,
                                'hard_modifydatebs'=>CURDATE_NP,
                                'hard_modifytime'=>$this->curtime,
                                'hard_modifyby'=>$this->userid,
                                'hard_modifymac'=>$this->mac,
                                'hard_modifyip'=>$this->ip,
                                'hard_fromlocationid'=>!empty($harm_fromlocationid)?$harm_fromlocationid:'',
                                'hard_tolocationid'=>!empty($harm_tolocationid)?$harm_tolocationid:'',
                                'hard_fromdepid'=>!empty($harm_fromdepid)?$harm_fromdepid:'',
                            );
                            $this->db->update($this->hard_detailTable, $hard_update_array,array('hard_handoverdetailid'=>$reqdetlid));
                                    } // if in array of reqdetailid
                                    else{
                                        $hard_insert_array = array(
                                            'hard_handovermasterid'=>$id,
                                            'hard_itemsid'=> !empty($itemsid[$key])?$itemsid[$key]:'',
                                            'hard_code'=> !empty($itemcode[$key])?$itemcode[$key]:'',
                                            'hard_unit'=> !empty($hard_unit[$key])?$hard_unit[$key]:'',
                                            'hard_qty'=> !empty($qty[$key])?$qty[$key]:'',
                                            'hard_remqty'=> !empty($qty[$key])?$qty[$key]:'',
                                            'hard_remarks'=> !empty($remarks[$key])?$remarks[$key]:'',
                                            'hard_unitprice'=> !empty($hard_unitprice[$key])?$hard_unitprice[$key]:'',
                                            'hard_totalamt'=> !empty($hard_totalamt[$key])?$hard_totalamt[$key]:'',
                                             // 'hard_qtyinstock'=>!empty($qtyinstock[$key])?$qtyinstock[$key]:'',
                                            'hard_postdatead'=>CURDATE_EN,
                                            'hard_postdatebs'=>CURDATE_NP,
                                            'hard_posttime'=>$this->curtime,
                                            'hard_postby'=>$this->userid,
                                            'hard_postmac'=>$this->mac,
                                            'hard_postip'=>$this->ip ,
                                            'hard_locationid'=>$this->locationid,
                                            'hard_fromlocationid'=>!empty($harm_fromlocationid)?$harm_fromlocationid:'',
                                            'hard_tolocationid'=>!empty($harm_tolocationid)?$harm_tolocationid:'',
                                            'hard_fromdepid'=>!empty($harm_fromdepid)?$harm_fromdepid:'',
                                            'hard_orgid'=>$this->orgid
                                        );

                                        $this->db->insert($this->hard_detailTable, $hard_insert_array);
                                        $hard_insertid[] = $this->db->insert_id();

                                    } // end if ... no reqdetailid... inserted
                                 // end if reqdetailid ... updated
                            } // end foreach itemsid

                            if(!empty($hard_array)){

                            } // end if hard_array

                        } // end if itemsid
                    // }

                // }

                //for deleted items

                        $old_items_list = $this->general->get_tbl_data('hard_handoverdetailid','hard_handoverreqdetail',array('hard_handovermasterid'=>$id));

                        $old_items_array = array();
                        if(!empty($old_items_list)){
                            foreach($old_items_list as $key=>$value){
                                $old_items_array[] = $value->hard_handoverdetailid;
                            }
                        }
                // print_r($old_items_array);
                // die();
                        $total_itemlist = count($old_items_list);
                        $deleted_items = array();
                        if($hard_insertid){
                            $reqdetailid = array_merge($reqdetailid, $hard_insertid);
                        }
                        if(is_array($reqdetailid)){
                            $deleted_items = array_diff($old_items_array, $reqdetailid);
                        }
                        $del_items_num = count($deleted_items);
                        if(!empty($del_items_num)){
                            for($i = 0; $i<$del_items_num; $i++){
                                $deleted_array = array_values($deleted_items);

                                foreach($deleted_array as $key=>$del){

                                    $this->db->where(array('hard_handoverdetailid'=>$del));
                                    $this->db->delete('harm_handoverreqmaster');
                                }
                            }
                        }

            }// if id not exists (new insert)
            else{
                $ReqMasterArray = array(
                    'harm_handoverreqno'=>$harm_handoverreqno,
                    'harm_ishandover'=>'N',
                    'harm_storeid'=>$harm_storeid,
                    'harm_reqdatebs'=>$reqdatebs,
                    'harm_reqdatead'=>$reqdatead,
                    'harm_manualno'=>$harm_manualno,
                    'harm_remarks'=>$harm_remarks,
                    'harm_fromlocationid'=>$harm_fromlocationid,
                    'harm_tolocationid'=>$harm_tolocationid,
                    'harm_fromdepid'=>$harm_fromdepid,
                    'harm_requestedby'=>$harm_requestedby,
                    'harm_fyear'=>CUR_FISCALYEAR,
                    'harm_estimatecost'=>$totalamount,   
                    // 'harm_received'=>'0',
                    'harm_username'=>$this->username,
                    'harm_postdatead'=>CURDATE_EN,
                    'harm_postdatebs'=>CURDATE_NP,
                    'harm_posttime'=>$this->curtime,
                    'harm_postby'=>$this->userid,
                    'harm_postmac'=>$this->mac,
                    'harm_postip'=>$this->ip,
                    'harm_locationid'=>$this->locationid,   
                    'harm_orgid'=>$this->orgid
                );

                if(!empty($ReqMasterArray))
                {   //print_r($ReqMasterArray);die;
                    $this->db->insert($this->harm_masterTable,$ReqMasterArray);
                    $insertid=$this->db->insert_id();
                    if($insertid){
                        //$ReqDetail[] = array();
                        if(!empty($itemsid)):
                            foreach ($itemsid as $key => $val) {
                                $ReqDetail[]=array( 
                                    'hard_handovermasterid'=>$insertid,
                                    'hard_itemsid'=> !empty($itemsid[$key])?$itemsid[$key]:'',
                                    'hard_code'=> !empty($itemcode[$key])?$itemcode[$key]:'',
                                    'hard_unit'=> !empty($hard_unit[$key])?$hard_unit[$key]:'',
                                    'hard_qty'=> !empty($qty[$key])?$qty[$key]:'',
                                    'hard_remqty'=> !empty($qty[$key])?$qty[$key]:'',
                                    'hard_qtyinstock'=>!empty($qtyinstock[$key])?$qtyinstock[$key]:'',
                                    'hard_remarks'=> !empty($remarks[$key])?$remarks[$key]:'',
                                    'hard_unitprice'=> !empty($hard_unitprice[$key])?$hard_unitprice[$key]:'',
                                    'hard_totalamt'=> !empty($hard_totalamt[$key])?$hard_totalamt[$key]:'',
                                    'hard_postdatead'=>CURDATE_EN,
                                    'hard_postdatebs'=>CURDATE_NP,
                                    'hard_posttime'=>$this->curtime,
                                    'hard_postby'=>$this->userid,
                                    'hard_postmac'=>$this->mac,
                                    'hard_postip'=>$this->ip,
                                    'hard_locationid'=>$this->locationid,
                                    'hard_fromlocationid'=>!empty($harm_fromlocationid)?$harm_fromlocationid:'',
                                    'hard_tolocationid'=>!empty($harm_tolocationid)?$harm_tolocationid:'',
                                    'hard_fromdepid'=>!empty($harm_fromdepid)?$harm_fromdepid:'',
                                    'hard_orgid'=>$this->orgid
                                );
                            }
                        endif;
                        if(!empty($ReqDetail)){   
                            //echo"<pre>";print_r($ReqDetail);die;
                            $this->db->insert_batch($this->hard_detailTable,$ReqDetail);
                        }
                    } // if insertid
                } // check if ReqMasterArray
            }

            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                return false;
            }
            else{
                $this->db->trans_commit();
                if($id){
                    return $id;
                }else{
                    return $insertid;
                }
            }
        }catch(Exception $e){
            throw $e;
        }
    }
    
    public function save_handover_request_from_branch()
    {
        try{
            $itemlist=$this->input->post('itemlist');
            $req_no=$this->input->post('req_no');
            $fyear=$this->input->post('fyear');
            
            $handoverreqArray=$this->general->get_tbl_data('MAX(harm_handoverreqno) as reqno','harm_handoverreqmaster',array('harm_locationid'=>$this->locationid),'harm_handovermasterid','DESC');
            // echo $this->db->last_query();
            // die();
            // print_r($handoverreqArray);
            // die();
            if(!empty($handoverreqArray))
            {
                $reqarry=$handoverreqArray[0]->reqno;
                $handoverreqno=$reqarry+1;
            }
            else
            {
                $handoverreqno=1;
            }
         
            // echo $handoverreqno;
            // die();
             $this->db->trans_begin();

            $storeid=!empty($this->session->userdata(STORE_ID))?$this->session->userdata(STORE_ID):1;
            
            $srchcol=array('rema_reqno'=>$req_no,'rema_fyear'=>$fyear,'rema_reqtodepid'=>$storeid,'rema_locationid'=>$this->locationid);
            
            $reqmasterdata=$this->stock_requisition_mdl->get_req_no_list($srchcol, 'rema_reqno','desc');

            $location_db=$this->general->get_tbl_data('loca_locationid as locid','loca_location',array('loca_ismain'=>'Y'),'loca_locationid','ASC');
            // echo $this->db->last_query();
            // echo "<pre>";
            // print_r($location_db);
            // die();
            $to_head_location_id=1;
            // echo "<pre>";
            // print_r($location_db);
            // die();
            if(!empty($location_db)){
            $to_head_location_id=!empty($location_db[0]->locid)?$location_db[0]->locid:'1';
            }
            // echo 'to_head'.$to_head_location_id;
            // die();

            $list_item_rec=$this->get_requisition_item_details();

            // echo "<pre>";
            // print_r($list_item_rec);
            // die();
            $reqdatebs=CURDATE_NP;
            $reqdatead=CURDATE_EN;
            if(!empty($itemlist))
            {
                 if(!empty($reqmasterdata)){
                $reqmasterid=!empty($reqmasterdata[0]->rema_reqmasterid)?$reqmasterdata[0]->rema_reqmasterid:'';
                $reqmaster_depid=!empty($reqmasterdata[0]->rema_reqfromdepid)?$reqmasterdata[0]->rema_reqfromdepid:'';
                $reqmaster_rema_reqby=!empty($reqmasterdata[0]->rema_reqby)?$reqmasterdata[0]->rema_reqby:'';

                $ReqMasterArray = array(
                    'harm_handoverreqno'=>$handoverreqno,
                    'harm_reqmasterid'=>$reqmasterid,
                    'harm_reqno'=>$req_no,
                    'harm_storeid'=>$storeid,
                    'harm_reqdatebs'=>$reqdatebs,
                    'harm_reqdatead'=>$reqdatead,
                    'harm_fromlocationid'=>$this->locationid,
                    'harm_tolocationid'=>$to_head_location_id,
                    'harm_fromdepid'=>$reqmaster_depid,
                    'harm_requestedby'=>$reqmaster_rema_reqby,
                    'harm_fyear'=> $fyear,
                    'harm_username'=>$this->username,
                    'harm_postdatead'=>CURDATE_EN,
                    'harm_postdatebs'=>CURDATE_NP,
                    'harm_posttime'=>$this->curtime,
                    'harm_postby'=>$this->userid,
                    'harm_postmac'=>$this->mac,
                    'harm_postip'=>$this->ip,
                    'harm_locationid'=>$this->locationid,   
                    'harm_orgid'=>$this->orgid
                );

                if(!empty($ReqMasterArray))
                {   //print_r($ReqMasterArray);die;
                    $this->db->insert($this->harm_masterTable,$ReqMasterArray);
                    $insertid=$this->db->insert_id();
                    if($insertid){
                        //$ReqDetail[] = array();
                        if(!empty($list_item_rec)):
                            foreach ($list_item_rec as $key => $val) {
                            $item_total_amt=$val->rede_qty*$val->itli_purchaserate;
                            $stockqty=!empty($val->stockqty)?$val->stockqty:'0';
                            $hand_req_qty=!empty($val->rede_qty)?$val->rede_qty:'0';
                            $hand_rem_qty=!empty($val->rede_remqty)?$val->rede_remqty:'0';
                            if($stockqty > 0 && ($hand_req_qty>$stockqty) ){
                                $hand_req_to_branch_qty=$hand_req_qty-$stockqty;
                            }else{
                                $hand_req_to_branch_qty=$hand_req_qty;
                            }

                                $ReqDetail[]=array( 
                                    'hard_handovermasterid'=>$insertid,
                                    'hard_itemsid'=> !empty($val->itli_itemlistid)?$val->itli_itemlistid:'',
                                    'hard_code'=> !empty($val->itli_itemcode)?$val->itli_itemcode:'',
                                    'hard_unit'=>  !empty($val->unit_unitname)?$val->unit_unitname:'',
                                    'hard_qty'=>  !empty($hand_req_to_branch_qty)?$hand_req_to_branch_qty:'0',
                                    'hard_remqty'=>  !empty($hand_req_to_branch_qty)?$hand_req_to_branch_qty:'0',
                                    'hard_qtyinstock'=>$stockqty,
                                    'hard_remarks'=> !empty($val->unit_unitname)?$val->unit_unitname:'',
                                    'hard_unitprice'=> !empty($val->itli_purchaserate)?$val->itli_purchaserate:'',
                                    'hard_totalamt'=> !empty($item_total_amt)?$item_total_amt:'',
                                    'hard_postdatead'=>CURDATE_EN,
                                    'hard_postdatebs'=>CURDATE_NP,
                                    'hard_posttime'=>$this->curtime,
                                    'hard_postby'=>$this->userid,
                                    'hard_postmac'=>$this->mac,
                                    'hard_postip'=>$this->ip,
                                    'hard_locationid'=>$this->locationid,
                                    'hard_fromlocationid'=>$this->locationid,
                                    'hard_tolocationid'=>$to_head_location_id,
                                    'hard_fromdepid'=>$reqmaster_depid,
                                    'hard_orgid'=>$this->orgid
                                );
                            }
                        endif;
                        if(!empty($ReqDetail)){   
                            //echo"<pre>";print_r($ReqDetail);die;
                            $this->db->insert_batch($this->hard_detailTable,$ReqDetail);
                        }
                    } // if insertid

                    $central_request_array = array(
                                'rema_centralrequest' => 'Y'
                    );
                    $this->db->update('rema_reqmaster',$central_request_array,array('rema_reqmasterid'=>$reqmasterid));
                     $this->general->saveActionLog('rema_reqmaster', $reqmasterid, $this->userid, 'Y', 'rema_centralrequest');

                } // check if ReqMasterArray
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
            }
           

            }

        catch(Exception $e){
            throw $e;
        }
    }

 public function get_requisition_item_details(){
        $itemlist=$this->input->post('itemlist');
        // echo "<pre>";
        // print_r($itemlist);
        // die();
        $req_no=$this->input->post('req_no');
        $fyear=$this->input->post('fyear');
        $this->db->select('it.itli_itemcode, it.itli_itemname, it.itli_itemnamenp, it.itli_itemlistid, it.itli_purchaserate, it.itli_salesrate, rd.rede_reqdetailid, rd.rede_itemsid, rd.rede_qty,rd.rede_remqty,rd.rede_reqmasterid, ut.unit_unitname, rd.rede_qtyinstock,(SELECT IFNULL(SUM(md.trde_issueqty)," ") FROM xw_trde_transactiondetail md LEFT JOIN xw_trma_transactionmain mt   on md.trde_trmaid =mt.trma_trmaid
  WHERE it.itli_itemlistid=md.trde_itemsid AND mt.trma_received=1 AND md.trde_locationid='.$this->locationid.' ) as stockqty,rd.rede_remarks');
        $this->db->from('rede_reqdetail rd');
        $this->db->join('rema_reqmaster rm','rm.rema_reqmasterid=rd.rede_reqmasterid','LEFT');
        $this->db->join('itli_itemslist it','it.itli_itemlistid = rd.rede_itemsid','left');
        $this->db->join('unit_unit ut','it.itli_unitid = ut.unit_unitid','left');
        if(!empty($itemlist)){
            $this->db->where_in('rd.rede_itemsid',$itemlist);
        }
        if(!empty($req_no)){
            $this->db->where('rm.rema_reqno',$req_no);
        }
        if(!empty($fyear)){
             $this->db->where('rm.rema_fyear',$fyear);
        }
        $this->db->where('rm.rema_locationid',$this->locationid);

      
        $query = $this->db->get();
        // echo $this->db->last_query();
        // die();
        if($query->num_rows() > 0){
            $result = $query->result();
            return $result;
        }
        return false;
    }


    public function get_all_hard_id($srchcol = false){
        try{
            $this->db->select('hard_handoverdetailid');
            $this->db->from($this->hard_detailTable);
            if($srchcol){
                $this->db->where($srchcol);
            }
            $query = $this->db->get();
            if($query->num_rows() > 0){
                $result = $query->result();
                // echo $this->db->last_query();die();
                return $result;
            }
        }catch(Exception $e){
            throw $e;
        }
    }

    public function get_handover_requisition_list($cond = false)
    {
        $get = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }
         // echo "<pre>";print_r($get); die();
        if(!empty($get['sSearch_0'])){
            $this->db->where("harm_handovermasterid like  '%".$get['sSearch_0']."%'  ");
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("harm_reqdatead like  '%".$get['sSearch_1']."%'  ");
        }
        if(!empty($get['sSearch_2'])){
            $this->db->where("harm_reqdatebs like  '%".$get['sSearch_2']."%'  ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("harm_handoverreqno like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("lo1.loca_name like  '%".$get['sSearch_4']."%'  ");
        } 
        if(!empty($get['sSearch_5'])){
            $this->db->where("lo2.loca_name like  '%".$get['sSearch_5']."%'  ");
        } 
        if(!empty($get['sSearch_6'])){
             $this->db->where("d.dept_depname like  '%".$get['sSearch_6']."%'  ");
        }
        if(!empty($get['sSearch_7'])){
            $this->db->where("harm_username like  '%".$get['sSearch_7']."%'  ");
        }
        if(!empty($get['sSearch_8'])){
            $this->db->where("harm_requestedby like  '%".$get['sSearch_8']."%'  ");
        }
        if(!empty($get['sSearch_9'])){
            $this->db->where("harm_approvedby like  '%".$get['sSearch_9']."%'  ");
        }
        if(!empty($get['sSearch_10'])){
            $this->db->where("harm_manualno like  '%".$get['sSearch_10']."%'  ");
        }
        if(!empty($get['sSearch_11'])){
            $this->db->where("harm_fyear like  '%".$get['sSearch_11']."%'  ");
        }

        if($cond) {
            $this->db->where($cond);
        }
        $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');
        $toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');
        $type = !empty($get['type'])?$get['type']:$this->input->post('type');
        $apptype = !empty($get['apptype'])?$get['apptype']:$this->input->post('apptype');
        $input_locationid= !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');
        $fiscalyear = !empty($get['fiscalyear'])?$get['fiscalyear']:$this->input->post('fiscalyear');

        if($apptype=='pending')
        {
            $approved=0;
        }
           if($apptype=='verified')
        {
            $approved=1;
        }
        if($apptype=='approved')
        {
            $approved=2;
        }
        if($apptype=='unapproved')
        {
            $approved=3;
        }
        if($apptype=='cancel')
        {
            $approved=4;
        }
        if($apptype=='cntissue')
        {
            $approved='';
        }
        if(!empty(($frmDate && $toDate)))
        {
            if(DEFAULT_DATEPICKER == 'NP'){
                $this->db->where('rm.harm_reqdatebs >=',$frmDate);
                $this->db->where('rm.harm_reqdatebs <=',$toDate);    
            }else{
                $this->db->where('rm.harm_reqdatead >=',$frmDate);
                $this->db->where('rm.harm_reqdatead <=',$toDate);
            }
        }

        if(!empty($type)){
            $this->db->where('rm.harm_ishandover',$type);
        }
        if($apptype!="cntissue"){
            if(!empty($apptype))
            {
                $this->db->where('rm.harm_approved',"$approved");
            }
        }

        if($this->location_ismain=='Y')
        {
            if($input_locationid)
            {
                $this->db->where('rm.harm_tolocationid',$input_locationid);
            }

        }
        else
        {
            $this->db->where('rm.harm_tolocationid',$this->locationid);
        }

        $this->db->where('harm_ishandover <>',' ');

        $resltrpt=$this->db->select("COUNT(*) as cnt,lo1.loca_name as fromloc,lo2.loca_name as toloc")
        ->from('harm_handoverreqmaster rm')
        ->join('dept_department d','d.dept_depid=rm.harm_fromdepid','LEFT')
        ->join('eqty_equipmenttype et','et.eqty_equipmenttypeid=rm.harm_storeid','LEFT')
        ->join('dept_department dt','dt.dept_depid=rm.harm_fromdepid','LEFT')
        ->join('loca_location lo1','lo1.loca_locationid=rm.harm_locationid','LEFT')
         ->join('loca_location lo2','lo2.loca_locationid=rm.harm_tolocationid','LEFT')
        ->get()
        ->row();
       // echo $this->db->last_query();
       // die();
        $totalfilteredrecs=$resltrpt->cnt; 
        $order_by = 'harm_handovermasterid';
        $order = 'desc';
        if($this->input->get('sSortDir_0'))
        {
            $order = $this->input->get('sSortDir_0');
        }

        $where='';
        if($this->input->get('iSortCol_0')==1)
            $order_by = 'harm_reqdatead';
        else if($this->input->get('iSortCol_0')==2)
            $order_by = 'harm_reqdatebs';
        else if($this->input->get('iSortCol_0')==3)
            $order_by = 'harm_handoverreqno';
        else if($this->input->get('iSortCol_0')==4)
            $order_by = 'lo1.loca_name';
        else if($this->input->get('iSortCol_0')==5)
            $order_by = 'lo2.loca_name';
        else if($this->input->get('iSortCol_0')==6)
            $order_by = 'dept_depname';
        else if($this->input->get('iSortCol_0')==7)
            $order_by = 'harm_usernam';
        else if($this->input->get('iSortCol_0')==8)
            $order_by = 'harm_requestedby';
        else if($this->input->get('iSortCol_0')==9)
            $order_by = 'harm_approvedby';
        else if($this->input->get('iSortCol_0')==10)
            $order_by = 'harm_manualno';
        else if($this->input->get('iSortCol_0')==11)
            $order_by = 'harm_fyear';
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
            $this->db->where("harm_handovermasterid like  '%".$get['sSearch_0']."%'  ");
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("harm_reqdatead like  '%".$get['sSearch_1']."%'  ");
        }
        if(!empty($get['sSearch_2'])){
            $this->db->where("harm_reqdatebs like  '%".$get['sSearch_2']."%'  ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("harm_handoverreqno like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("lo1.loca_name like  '%".$get['sSearch_4']."%'  ");
        } 
        if(!empty($get['sSearch_5'])){
            $this->db->where("lo2.loca_name like  '%".$get['sSearch_5']."%'  ");
        } 
        if(!empty($get['sSearch_6'])){
            $this->db->where("d.dept_depname like  '%".$get['sSearch_6']."%'  ");
        }
        if(!empty($get['sSearch_7'])){
            $this->db->where("harm_username like  '%".$get['sSearch_7']."%'  ");
        }
        if(!empty($get['sSearch_8'])){
            $this->db->where("harm_requestedby like  '%".$get['sSearch_8']."%'  ");
        }
        if(!empty($get['sSearch_9'])){
            $this->db->where("harm_approvedby like  '%".$get['sSearch_9']."%'  ");
        }
        if(!empty($get['sSearch_10'])){
            $this->db->where("harm_manualno like  '%".$get['sSearch_10']."%'  ");
        }
        if(!empty($get['sSearch_11'])){
            $this->db->where("harm_fyear like  '%".$get['sSearch_11']."%'  ");
        }
    $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');
    $toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');
    $type = !empty($get['type'])?$get['type']:$this->input->post('type');
    $apptype = !empty($get['apptype'])?$get['apptype']:$this->input->post('apptype');
    $input_locationid= !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');
    $fiscalyear = !empty($get['fiscalyear'])?$get['fiscalyear']:$this->input->post('fiscalyear');

    if($apptype=='pending')
    {
        $approved=0;
    }
      if($apptype=='verified')
    {
        $approved=1;
    }
    if($apptype=='approved')
    {
        $approved=2;
    }
    if($apptype=='unapproved')
    {
        $approved=3;
    }
    if($apptype=='cancel')
    {
        $approved=4;
    }
    if($apptype=='cntissue')
    {
        $approved='';
    }


    if(!empty(($frmDate && $toDate)))
    {
        if(DEFAULT_DATEPICKER == 'NP'){
            $this->db->where('rm.harm_reqdatebs >=',$frmDate);
            $this->db->where('rm.harm_reqdatebs <=',$toDate);    
        }else{
            $this->db->where('rm.harm_reqdatead >=',$frmDate);
            $this->db->where('rm.harm_reqdatead <=',$toDate);
        }
    }
    if($type){
        $this->db->where('rm.harm_ishandover',$type);
    }
    if($apptype!="cntissue"){
        if(!empty($apptype))
        {
            $this->db->where('rm.harm_approved',"$approved");
        }
    }
    
    if($this->location_ismain=='Y')
    {
        if($input_locationid)
        {
            $this->db->where('rm.harm_tolocationid',$input_locationid);
        }
    }
    else
    {
       $this->db->where('rm.harm_tolocationid',$this->locationid);
   }

   $cntitemQty="(SELECT COUNT(*) as cntitem from xw_hard_handoverreqdetail rd WHERE rd.hard_remqty >0 AND rd.hard_handovermasterid=rm.harm_handovermasterid AND rd.hard_isdelete = 'N') as cntitem";

   $this->db->select("rm.*,rm.harm_remarks,$cntitemQty,lo1.loca_name as fromloc,lo2.loca_name as toloc,dt.dept_depname ");
   $this->db->from('harm_handoverreqmaster rm');
   $this->db->join('dept_department d','d.dept_depid=rm.harm_fromdepid','LEFT');
   $this->db->join('eqty_equipmenttype et','et.eqty_equipmenttypeid=rm.harm_storeid','LEFT');
   $this->db->join('dept_department dt','dt.dept_depid=rm.harm_fromdepid','LEFT');
   $this->db->join('loca_location lo1','lo1.loca_locationid=rm.harm_locationid','LEFT');
   $this->db->join('loca_location lo2','lo2.loca_locationid=rm.harm_tolocationid','LEFT');

   $this->db->where('harm_ishandover <>',' ');

   $this->db->order_by($order_by,$order);

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
$nquery=$this->db->get();
       // echo $this->db->last_query();die;
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
    //echo $this->db->last_query();die();
return $ndata;

}



public function get_req_no($srchcol = false){
   try{
      $this->db->select('max(harm_handoverreqno) as handoverreqno');
      $this->db->from('harm_handoverreqmaster');
      if($srchcol){
         $this->db->where($srchcol);    
     }

     $query = $this->db->get();
     // echo $this->db->last_query();die;

     if($query->num_rows() > 0){
         return $query->result();
     }
     return false;
 }catch(Exception $e){
  throw $e;
}
}

public function getStatusCount($srchcol = false){
   try{
      $this->db->select("SUM(CASE WHEN harm_approved='0' THEN 1 ELSE 0 END ) pending, SUM(CASE WHEN harm_approved='2' THEN 1 ELSE 0 END ) approved, SUM(CASE WHEN harm_approved='3' THEN 1 ELSE 0 END ) unapproved, SUM(CASE WHEN harm_approved='4' THEN 1 ELSE 0 END ) cancel,SUM(CASE WHEN harm_approved='1' THEN 1 ELSE 0 END ) verified");
      $this->db->from('harm_handoverreqmaster');

      if($srchcol){
         $this->db->where($srchcol);
     }

     $query = $this->db->get();
     // echo $this->db->last_query();die;

     if($query->num_rows() > 0){
         return $query->result();
     }
     return false;
 }catch(Exception $e){
  throw $e;
}
}

public function getRemCount($srchcol = false){
   try{
      $this->db->select("COUNT('*') as cntissue");
      $this->db->from('harm_handoverreqmaster as rm');
      $this->db->join('hard_handoverreqdetail rd','rd.hard_handovermasterid=rm.harm_handovermasterid','LEFT');
      $this->db->where('rd.hard_remqty >',0);
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



public function get_requisition_data($srchcol = false){
    try{
        $this->db->select('rm.*, rd.*, il.itli_itemcode,il.itli_purchaserate, il.itli_itemname,il.itli_itemnamenp, il.itli_itemlistid, dt.dept_depname as fromdepname,ut.unit_unitname,,lo1.loca_name as fromloc,lo2.loca_name as toloc');
        $this->db->from('harm_handoverreqmaster rm');
        $this->db->join('hard_handoverreqdetail rd','rd.hard_handovermasterid = rm.harm_handovermasterid','left');
        $this->db->join('itli_itemslist il','il.itli_itemlistid = rd.hard_itemsid','left');
        $this->db->join('unit_unit ut','ut.unit_unitid = rd.hard_unit','left');
       $this->db->join('dept_department dt','dt.dept_depid=rm.harm_fromdepid','LEFT');
       $this->db->join('loca_location lo1','lo1.loca_locationid=rm.harm_fromlocationid','LEFT');
       $this->db->join('loca_location lo2','lo2.loca_locationid=rm.harm_tolocationid','LEFT');
 
     $this->db->where($srchcol);
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

public function get_requisition_master_data($srchcol = false)
{
    try{
        $this->db->select('rm.*,dt.dept_depname as fromdepname,et.eqty_equipmenttype as todepname,(SELECT  ett.eqty_equipmenttype  FROM  xw_eqty_equipmenttype ett WHERE ett.eqty_equipmenttypeid=rm.harm_fromdepid AND rm.harm_ishandover="N") fromdep_transfer,lo1.loca_name as fromloc,lo2.loca_name as toloc');
        $this->db->from('harm_handoverreqmaster rm');
        $this->db->join('dept_department dt','dt.dept_depid=rm.harm_fromdepid','LEFT');
        $this->db->join('eqty_equipmenttype et','et.eqty_equipmenttypeid=rm.harm_storeid','LEFT');
        $this->db->join('loca_location lo1','lo1.loca_locationid=rm.harm_fromlocationid','LEFT');
          $this->db->join('loca_location lo2','lo2.loca_locationid=rm.harm_tolocationid','LEFT');


        if($srchcol)
        {
         $this->db->where($srchcol); 
     }
     $query = $this->db->get();
        // echo $this->db->last_query();die;
     if($query->num_rows() > 0){
         return $query->result();
     }
     return false;

 }
 catch(Exception $e){
  throw $e;
}

}

public function get_requisition_details_data($srchcol = false,$storeid=false){
    if($storeid)
    {
        $search_storeid=" AND mtm.trma_fromdepartmentid=$storeid";
    }
    else
    {
        $search_storeid='';
    }
    $this->db->select('it.itli_itemcode, it.itli_itemname,it.itli_itemnamenp,it.itli_reorderlevel,it.itli_maxlimit ,it.itli_itemlistid,rd.hard_unitprice,rd.hard_totalamt, rd.hard_itemsid, rd.hard_qty,rd.hard_remqty, ut.unit_unitname, rd.hard_qtyinstock,(select SUM(mtd.trde_issueqty) from xw_trde_transactiondetail mtd, xw_trma_transactionmain  mtm WHERE  mtm.trma_trmaid=mtd.trde_trmaid AND mtd.trde_itemsid=it.itli_itemlistid AND mtm.trma_received="1" AND mtd.trde_status="O" AND mtd.trde_locationid='.$this->locationid.' '. $search_storeid.' ) cur_stock_qty');
    $this->db->from('hard_handoverreqdetail rd');
    $this->db->join('itli_itemslist it','it.itli_itemlistid = rd.hard_itemsid','left');
    $this->db->join('unit_unit ut','it.itli_unitid = ut.unit_unitid','left');

    if($srchcol){
        $this->db->where($srchcol);
    }
    $query = $this->db->get();
        //echo $this->db->last_query();die;
    if($query->num_rows() > 0){
        $result = $query->result();
        return $result;
    }
    return false;

}

public function stock_requisition_change_status_email($status,$masterid)
{
    $unappresondatead = CURDATE_EN;
    $unappresondatebs =  CURDATE_NP;
    $postdata = array(
                    // 'harm_unapprovedreason'=>$unappreson,
                    // 'harm_reasoncancel'=> $canreson,
        'harm_approved'=>$status,
        'harm_modifydatead'=>CURDATE_EN,
                    // ''=>$unappresondatead,
                    // 'harm_rsncanceldatead'=>$canresondatead,
        'harm_unappreasonbs'=>CURDATE_NP,
        'harm_unappreasonad'=> $unappresondatead,
                    //'harm_rsncanceldatebs'=>$unappresondatebs,
        'harm_modifytime'=>date('H:i:s'),
        'harm_modifymac'=>$this->general->get_real_ipaddr(),
        'harm_modifymac'=>$this->general->get_Mac_Address()
    );
        //echo "<pre>";print_r($masterid);die;
    $this->db->update('harm_handoverreqmaster',$postdata,array('harm_handovermasterid'=>$masterid));
        //echo  $this->db->last_query();die;
    $rowaffected=$this->db->affected_rows();
    if($rowaffected)
    {
        return $rowaffected;
    }
    else
    {
        return false;
    }
}
public function handover_requisition_change_status($status =false,$masterid=false)
{   
    // echo  $status;die;
    $masterid = $this->input->post('masterid');
    $unappreson = $this->input->post('harm_unapprovedreason');
    $canreson = $this->input->post('cancel_reason');

    $approved_status = $this->input->post('harm_ishandover');

    $approved_datead = $approved_datebs = '';
    $approved_id = 0;
    $approved_by = '';
    if($approved_status == '1'){
       $approved_datead = CURDATE_EN;
       $approved_datebs = CURDATE_NP;

       if(defined('APPROVEBY_TYPE')):
          if(APPROVEBY_TYPE == 'USER'){
             $approved_id = $this->userid;
             $approved_by = $this->username;
         }else{
             $approved_id = (defined('APPROVER_USERID'))?APPROVER_USERID:'';
             $approved_by = (defined('APPROVER_USERNAME'))?APPROVER_USERNAME:'';
         }
     endif;
 }

 $unappresondatead ='';
 $unappresondatebs ='';
 $canresondatead ='';
 $canresondatebs ='';

 if(!empty($canreson))
        {  //echo "Canreason";
    $canresondatead = CURDATE_EN;
    $canresondatebs =  CURDATE_NP; 
}
if(!empty($unappreson))
        {  //echo "Unapp";
    $unappresondatead = CURDATE_EN;
    $unappresondatebs =  CURDATE_NP; 
}

$postdata = array(
    'harm_approveddatead' => $approved_datead,
    'harm_approveddatebs' => $approved_datebs,
    'harm_unapprovedreason'=>$unappreson,
    'harm_reasoncancel'=> $canreson,
    'harm_approved'=>$status,
    'harm_modifydatead'=>CURDATE_EN,
    'harm_unappreasonad'=>$unappresondatead,
    'harm_rsncanceldatead'=>$canresondatead,
    'harm_unappreasonbs'=>$unappresondatebs,
    'harm_modifydatebs'=> CURDATE_NP,
    'harm_rsncanceldatebs'=>$canresondatebs,
    'harm_modifytime'=>date('H:i:s'),
    'harm_modifymac'=>$this->general->get_real_ipaddr(),
    'harm_modifyip'=>$this->general->get_Mac_Address(),
    'harm_approvedby'=> $approved_by,
    'harm_approvedid' => $approved_id
);


        //echo"<pre>";print_r($postdata);die;
$this->db->update('harm_handoverreqmaster',$postdata,array('harm_handovermasterid'=>$masterid));
        //echo  $this->db->last_query();die;
$rowaffected=$this->db->affected_rows();
if($rowaffected)
{
    return $rowaffected;
}
else
{
    return false;
}
}

public function get_handover_req_no_list($srchcol = false, $order_by = false, $order = false){
    $this->db->select('rm.harm_handovermasterid, rm.harm_handoverreqno, rm.harm_reqdatebs, rm.harm_reqdatead, rm.harm_manualno, rm.harm_fromdepid, d.dept_depname,rm.harm_requestedby,rm.harm_approved,rm.harm_fromlocationid,rm.harm_tolocationid,l.loca_name');
    $this->db->from('harm_handoverreqmaster rm');
    $this->db->join('dept_department d','d.dept_depid = rm.harm_fromdepid','left');
    $this->db->join('loca_location l','l.loca_locationid=rm.harm_fromlocationid','left');
    if($srchcol){
      $this->db->where($srchcol);
  }
  if($order_by && $order){
      $this->db->order_by($order_by,$order);    
  }

  $query = $this->db->get();
        // echo $this->db->last_query();die();
  if($query->num_rows() > 0){
      $result = $query->result();
      return $result;
  }
  return false;
}
public function get_handover_requisition_details_list($cond = false)
{
    $frmDate=$this->input->get('frmDate');
    $toDate=$this->input->get('toDate');
    $get = $_GET;
    foreach ($get as $key => $value) {
        $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
    }
    if(!empty($get['sSearch_1'])){
        $this->db->where("harm_reqdatead like  '%".$get['sSearch_1']."%'  ");
    }
    if(!empty($get['sSearch_2'])){
        $this->db->where("harm_reqdatebs like  '%".$get['sSearch_2']."%'  ");
    }
    if(!empty($get['sSearch_3'])){
        $this->db->where("harm_handoverreqno like  '%".$get['sSearch_3']."%'  ");
    }

    if(!empty($get['sSearch_4'])){
        $this->db->where("itli_itemcode like  '%".$get['sSearch_4']."%'  ");
    }
    if(!empty($get['sSearch_5'])){
        $this->db->where("itli_itemname like  '%".$get['sSearch_5']."%'  ");
    }
    if(!empty($get['sSearch_6'])){
        $this->db->where("itli_itemnamenp like  '%".$get['sSearch_6']."%'  ");
    }
    if(!empty($get['sSearch_7'])){
        $this->db->where("harm_fyear like  '%".$get['sSearch_7']."%'  ");
    }
    if(!empty($get['sSearch_8'])){
        $this->db->where("hard_qty like  '%".$get['sSearch_8']."%'  ");
    }
    if(!empty($get['sSearch_10'])){
        $this->db->where("hard_remqty like  '%".$get['sSearch_10']."%'  ");
    }


    $fiscalyear = !empty($get['fiscalyear'])?$get['fiscalyear']:$this->input->post('fiscalyear');
    if($cond) {
      $this->db->where($cond);
  }
  $input_locationid= !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');

  if($this->location_ismain=='Y')
  {
    if($input_locationid)
    {
        $this->db->where('rm.harm_tolocationid',$input_locationid);
    }
}
else
{
   $this->db->where('rm.harm_tolocationid',$this->locationid);
}


if(!empty(($frmDate && $toDate)))
{
    if(DEFAULT_DATEPICKER == 'NP'){
        $this->db->where('rm.harm_reqdatebs >=',$frmDate);
        $this->db->where('rm.harm_reqdatebs <=',$toDate);    
    }else{
        $this->db->where('rm.harm_reqdatead >=',$frmDate);
        $this->db->where('rm.harm_reqdatead <=',$toDate);
    }
}
if($fiscalyear)
{
    $this->db->where('harm_fyear',$fiscalyear);
}

$resltrpt=$this->db->select("COUNT(*) as cnt")
->from('hard_handoverreqdetail rd')
->join('harm_handoverreqmaster rm','rm.harm_handovermasterid=rd.hard_handovermasterid','LEFT')
->join('itli_itemslist eq','eq.itli_itemlistid = rd.hard_itemsid','LEFT')
->join('dept_department dp','dp.dept_depid=rm.harm_fromdepid','left')
->join('unit_unit u','u.unit_unitid = eq.itli_unitid','LEFT')
                    // ->join('eqty_equipmenttype t','t.eqty_equipmenttypeid = rm.harm_storeid','LEFT')
->get()->row();
        //echo $this->db->last_query();die(); 
$totalfilteredrecs=($resltrpt->cnt); 
$order_by = 'harm_reqdatebs';
$order = 'desc';
if($this->input->get('sSortDir_0'))
{
    $order = $this->input->get('sSortDir_0');
}

$where='';
if($this->input->get('iSortCol_0')==1)
    $order_by = 'harm_handoverreqno';
else if($this->input->get('iSortCol_0')==2)
    $order_by = 'harm_reqdatead';
else if($this->input->get('iSortCol_0')==3)
    $order_by = 'harm_reqdatebs';
        // else if($this->input->get('iSortCol_0')==2)
        //     if(DEFAULT_DATEPICKER=='NP')
        //     {
        //         $order_by = 'harm_reqdatebs';
        //     }else{
        //         $order_by = 'sama_billdatead';
        //     }
else if($this->input->get('iSortCol_0')==4)
    $order_by = 'itli_itemcode';
else if($this->input->get('iSortCol_0')==5)
    $order_by = 'itli_itemname';
else if($this->input->get('iSortCol_0')==6)
    $order_by = 'itli_itemnamenp';
else if($this->input->get('iSortCol_0')==7)
    $order_by = 'harm_fyear';
else if($this->input->get('iSortCol_0')==8)
    $order_by = 'hard_qty';
else if($this->input->get('iSortCol_0')==10)
    $order_by = 'hard_remqty';

        //  else if($this->input->get('iSortCol_0')==9)
        //     $order_by = 'sama_billtime';
        //  else if($this->input->get('iSortCol_0')==10)
        //     $order_by = 'sade_qty';
        //  else if($this->input->get('iSortCol_0')==11)
        //     $order_by = 'sade_unitrate';
        // else if($this->input->get('iSortCol_0')==12)
        //     $order_by = 'issueamt';
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
    $this->db->where("harm_reqdatead like  '%".$get['sSearch_1']."%'  ");
}
if(!empty($get['sSearch_2'])){
    $this->db->where("harm_reqdatebs like  '%".$get['sSearch_2']."%'  ");
}
if(!empty($get['sSearch_3'])){
    $this->db->where("harm_handoverreqno like  '%".$get['sSearch_3']."%'  ");
}

if(!empty($get['sSearch_4'])){
    $this->db->where("itli_itemcode like  '%".$get['sSearch_4']."%'  ");
}
if(!empty($get['sSearch_5'])){
    $this->db->where("itli_itemname like  '%".$get['sSearch_5']."%'  ");
}
if(!empty($get['sSearch_6'])){
    $this->db->where("itli_itemnamenp like  '%".$get['sSearch_6']."%'  ");
}
if(!empty($get['sSearch_7'])){
    $this->db->where("harm_fyear like  '%".$get['sSearch_7']."%'  ");
}
if(!empty($get['sSearch_8'])){
    $this->db->where("hard_qty like  '%".$get['sSearch_8']."%'  ");
}
if(!empty($get['sSearch_10'])){
    $this->db->where("hard_remqty like  '%".$get['sSearch_10']."%'  ");
}
$input_locationid= !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');




if(!empty(($frmDate && $toDate)))
{
    if(DEFAULT_DATEPICKER == 'NP'){
        $this->db->where('rm.harm_reqdatebs >=',$frmDate);
        $this->db->where('rm.harm_reqdatebs <=',$toDate);    
    }else{
        $this->db->where('rm.harm_reqdatead >=',$frmDate);
        $this->db->where('rm.harm_reqdatead <=',$toDate);
    }
}
if($cond) {
  $this->db->where($cond);
}
if($fiscalyear)
{
    $this->db->where('harm_fyear',$fiscalyear);
}
if($this->location_ismain=='Y')
{
    if($input_locationid)
    {
        $this->db->where('rm.harm_tolocationid',$input_locationid);
    }

}
else
{
    $this->db->where('rm.harm_tolocationid',$this->locationid);
}
$this->db->select('rd.hard_handoverdetailid,rd.hard_locationid,rd.hard_remarks,rd.hard_remqty,rd.hard_qty,rm.harm_handoverreqno,rm.harm_reqdatead,rm.harm_reqdatebs,rm.harm_username,rm.harm_fyear,rm.harm_requestedby,it.itli_itemname,it.itli_itemnamenp,it.itli_itemcode,dp.dept_depname,u.unit_unitname');
$this->db->from('hard_handoverreqdetail rd');
$this->db->join('harm_handoverreqmaster rm','rm.harm_handovermasterid=rd.hard_handovermasterid','LEFT','LEFT');
$this->db->join('dept_department dp','dp.dept_depid=rd.hard_tolocationid','LEFT');
         // $this->db->join('eqty_equipmenttype t','t.eqty_equipmenttypeid = rm.harm_storeid','LEFT');
$this->db->join('itli_itemslist it','it.itli_itemlistid = rd.hard_itemsid','LEFT');
$this->db->join('unit_unit u','u.unit_unitid = it.itli_unitid','LEFT');

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
    //echo $this->db->last_query();die();
return $ndata;
}
  public function get_handover_issue_list($cond = false)
    {
        $get = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("harm_handoverreqno like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("harm_manualno like  '%".$get['sSearch_2']."%'  ");
        }
        
        if(!empty($get['sSearch_3'])){
         if(DEFAULT_DATEPICKER=='NP')
            {
            $this->db->where("harm_reqdatebs like  '%".$get['sSearch_3']."%'  ");       
            }
            else
            {
            $this->db->where("harm_reqdatead like  '%".$get['sSearch_3']."%'  ");
            }
          }
          if(!empty($get['sSearch_4'])){
             $this->db->where("dept_depname like  '%".$get['sSearch_4']."%'  ");
           }

        if($cond) {
            $this->db->where($cond);
        }

        // $resltrpt=$this->db->select("COUNT(*) as cnt")
        //             ->from('harm_reqmaster rm')
        //             ->join('dept_department d','d.dept_depid = rm.harm_fromlocationid','left')
        //             ->get()
        //             ->row();

       $select=$this->db->select('rm.harm_handovermasterid, rm.harm_handoverreqno, rm.harm_reqdatebs, rm.harm_reqdatead, rm.harm_manualno, rm.harm_fromlocationid,rm.harm_locationid, d.dept_depname,rm.harm_requestedby,(select COUNT("*") as cnt from xw_hard_handoverreqdetail where hard_remqty<>0 AND hard_qtyinstock<>0 AND hard_handovermasterid=rm.harm_handovermasterid) as dtl_cnt, (select COUNT("*") as cnt from xw_hard_handoverreqdetail where hard_remqty<>0 AND hard_qtyinstock<>0 AND  hard_handovermasterid=rm.harm_handovermasterid) as stk_cnt, loc1.loca_name as fromlocation, loc2.loca_name as tolocation')
           ->from('harm_handoverreqmaster rm')
           ->join('dept_department d','d.dept_depid = rm.harm_fromdepid','left')
           ->join('loca_location loc1','loc1.loca_locationid = rm.harm_fromlocationid','left')
           ->join('loca_location loc2','loc2.loca_locationid = rm.harm_tolocationid','left');
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
        $nquery=$this->db->query("SELECT * FROM ($sql) x WHERE dtl_cnt>0 ")->result();
        // $this->db->where(array('dtl_cnt >'=>'0','stk_cnt >'=>'0'));
        // echo $sql;
        // die();

         // echo $this->db->last_query();die(); 
        $totalfilteredrecs=sizeof($nquery); 

        $order_by = 'harm_handoverreqno';
        $order = 'desc';
  
        $where='';
        if($this->input->get('iSortCol_0')==1)
            $order_by = 'harm_handoverreqno';
        else if($this->input->get('iSortCol_0')==2)
            $order_by = 'harm_manualno';
        else if($this->input->get('iSortCol_0')==3)
            $order_by = 'harm_reqdatead';
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
            $this->db->where("harm_handoverreqno like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("harm_manualno like  '%".$get['sSearch_2']."%'  ");
        }
         if(!empty($get['sSearch_3'])){
         if(DEFAULT_DATEPICKER=='NP')
            {
            $this->db->where("harm_reqdatebs like  '%".$get['sSearch_3']."%'  ");       
            }
            else
            {
            $this->db->where("harm_reqdatead like  '%".$get['sSearch_3']."%'  ");
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

        $select=$this->db->select('rm.harm_handovermasterid, rm.harm_handoverreqno, rm.harm_reqdatebs, rm.harm_reqdatead, rm.harm_manualno,rm.harm_fromdepid,rm.harm_locationid,  rm.harm_fromlocationid, d.dept_depname,rm.harm_requestedby,
            (select COUNT("*") as cnt from xw_hard_handoverreqdetail where hard_remqty<>0 AND hard_qtyinstock<>0 AND hard_handovermasterid=rm.harm_handovermasterid) as dtl_cnt, 
            (select COUNT("*") as cnt from xw_hard_handoverreqdetail where hard_remqty<>0 AND hard_qtyinstock<>0 AND  hard_handovermasterid=rm.harm_handovermasterid) as stk_cnt, 
            loc1.loca_name as fromlocation, loc2.loca_name as tolocation')
           ->from('harm_handoverreqmaster rm')
            ->join('dept_department d','d.dept_depid = rm.harm_fromdepid','left')
            ->join('loca_location loc1','loc1.loca_locationid = rm.harm_fromlocationid','left')
            ->join('loca_location loc2','loc2.loca_locationid = rm.harm_tolocationid','left');
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

        $nquery=$this->db->query("SELECT * FROM ($sql) x  WHERE dtl_cnt>0 ");

        // $this->db->where(array('dtl_cnt >'=>'0','stk_cnt >'=>'0'));
        // echo $sql;
        // die();

       
      
      
        // $nquery=$this->db->get();

        $db_query= $this->db->last_query();
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
      public function get_all_reqby($srstinl=false,$limit=false,$offset=false,$order_by=false,$order=false,$groupby=false)
    {
        $srchtxt= $this->input->post('srchtext');
        $this->db->select('*');
        $this->db->from('harm_handoverreqmaster');
        $this->db->group_by('harm_requestedby');
        if($srstinl)
        {
            $this->db->where($srstinl);
        }

        if($srchtxt)
        {
            $this->db->where("harm_requestedby like  '%".$srchtxt."%'  ");
        }

        if($limit && $limit>0)
        {
            $this->db->limit($limit);
        }
        
        if($offset)
        {
            $this->db->offset($offset);
        }
        
        if($order_by)
        {
            $this->db->order_by($order_by,$order);
        }
        
        $this->db->set_dbprefix('');

        if($groupby)
        {
            $this->db->group_by($groupby);
        }
        
        $this->db->set_dbprefix('');
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

    public function change_current_status($status=false)
    {
        $handover_masterid=$this->input->post('hmid');
        $itemid=$this->input->post('itemlist');

        $itemArray=implode(',', $itemid);
        // echo "asd";
        // die();
        // echo "<pre>";
        // print_r($itemid);
        // die();


        $postdataArray=array();
        if($status=='reject'){
        $postdataArray=array(
            'harm_currentstatus'=>'R',
           'harm_statusdatead'=>CURDATE_EN,
           'harm_statusdatbs'=>CURDATE_NP,
           'harm_statustime'=>$this->curtime);
            // $this->db->set();
          $this->db->where_in('hard_itemsid',$itemid);
          $this->db->where(array('hard_handovermasterid'=>$handover_masterid));
          $this->db->update('hard_handoverreqdetail',array('hard_appstatus'=>'R'));
             
            // $this->db->where();
            // echo $this->db->last_query();
            // die();
        }
         if($status=='accept'){
         $postdataArray=array(
           'harm_currentstatus'=>'A',
           'harm_handoverlvl'=>'3',
           'harm_statusdatead'=>CURDATE_EN,
           'harm_statusdatbs'=>CURDATE_NP,
           'harm_statustime'=>$this->curtime);
          if(!empty($itemArray)){
            $itmstock=$this->check_stock_qty_array($itemArray);
            if(!empty($itmstock))
            {
                foreach ($itmstock as $kts => $istk) {
                   $stkArray[]=$istk->tels_stockqty;
                }
            }
            if(in_array('0.00', $stkArray))
            {
                return "stock_empty";
                // return false;
            }

            // echo "<pre>";
            // print_r($itmstock);
            // die();
        }


           
          $this->db->where_in('hard_itemsid',$itemid);
          $this->db->where(array('hard_handovermasterid'=>$handover_masterid));
          $this->db->update('hard_handoverreqdetail',array('hard_appstatus'=>'A'));
        }
        if(!empty($postdataArray)){
            $this->db->update('harm_handoverreqmaster',$postdataArray,array('harm_handovermasterid'=>$handover_masterid));
           $rowaffected=$this->db->affected_rows();
            if($rowaffected){
                $this->general->saveActionLog('harm_handoverreqmaster', $handover_masterid, $this->userid, '3', 'harm_handoverlvl');
                $this->general->saveActionLog('harm_handoverreqmaster', $handover_masterid, $this->userid, 'A', 'harm_currentstatus');

                return $rowaffected;
            }
            else{
                return false;
            }
        }
        return false;
    }

    public function check_stock_qty_array($itmArray=false){
         $sql1="
        SELECT
        td.trde_itemsid AS tels_itemid,
        il.itli_itemcode AS tels_itemcode,
        il.itli_itemname AS tels_itemname,  
        sum(td.trde_issueqty) AS tels_stockqty,
        td.trde_locationid AS tels_locationid,
        tm.trma_fromdepartmentid AS tels_storeid
        FROM
        xw_itli_itemslist il 
        LEFT JOIN xw_trde_transactiondetail td  ON il.itli_itemlistid = td.trde_itemsid
        LEFT JOIN xw_trma_transactionmain tm
        ON tm.trma_trmaid = td.trde_trmaid
        WHERE
        -- td.trde_issueqty > 0 AND 
                tm.trma_received = '1'
                AND td.trde_status = 'O'
                AND td.trde_itemsid IN($itmArray)
            
        GROUP BY
            `td`.`trde_itemsid`,
            `td`.`trde_locationid`,
             tm.trma_fromdepartmentid
        ORDER BY  `td`.`trde_itemsid`;";
        // echo $sql1;
        // die();
         $nquery=$this->db->query($sql1)->result();
         return $nquery;
    }

    public function request_to_other_branch()
    {
        $item_n_loc=$this->input->post('itemlist');
        $handovermasterid=$this->input->post('handovermasterid');
        // echo "<pre>";
        // print_r($item_n_loc);
        // die();

        $loc_id = array();
        $chkmaster=$this->check_item_with_handovermaster('master');
           if(!empty($item_n_loc)){
            foreach ($item_n_loc as $kt => $val) {
                $val_list=explode('|', $val);
                $loc_id[]=$val_list[1];
                $item_n_locArray[]=array(
                    'itemid'=>$val_list[0],
                    'loc_id'=>$val_list[1]);
             }
         }
            // echo "<pre>";
            // print_r($item_n_locArray);
            // die();
        $unique_loc=array_unique($loc_id);

        $this->db->trans_begin();

         if(!empty($chkmaster)){
            foreach ($unique_loc as $kl => $loc) {
             $handoverreqArray=$this->general->get_tbl_data('MAX(harm_handoverreqno) as reqno','harm_handoverreqmaster',array('harm_locationid'=>$this->locationid),'harm_handovermasterid','DESC');
             if(!empty($handoverreqArray)){
                    $handoverreqno=($handoverreqArray[0]->reqno)+1;
                }
                else{
                    $handoverreqno=1;
                }

            $arrayhandovermaster=array(
                'harm_reqmasterid'=>$chkmaster->harm_reqmasterid,
                'harm_parentharmid'=>$chkmaster->harm_handovermasterid,
                'harm_handoverreqno'=>$handoverreqno,
                'harm_reqno'=>$chkmaster->harm_reqno,
                'harm_reqdatead'=>CURDATE_EN,
                'harm_reqdatebs'=>CURDATE_NP,
                'harm_fromlocationid'=>$this->locationid,
                'harm_tolocationid'=>$loc,
                'harm_fyear'=>$chkmaster->harm_fyear,
                'harm_requestedby'=>$this->session->userdata(USER_NAME),
                'harm_remarks'=>$chkmaster->harm_remarks,
                'harm_estimatecost'=>$chkmaster->harm_estimatecost,
                'harm_status'=>$chkmaster->harm_status,
                'harm_manualno'=>$chkmaster->harm_manualno,
                'harm_storeid'=>$chkmaster->harm_storeid,
                'harm_postdatead'=>$chkmaster->harm_postdatead,
                'harm_postdatebs'=>$chkmaster->harm_postdatebs,
                'harm_postby'=>$chkmaster->harm_postby,
                'harm_postmac'=>$chkmaster->harm_postmac,
                'harm_postip'=>$chkmaster->harm_postip,
                'harm_posttime'=>$chkmaster->harm_posttime,
                'harm_username'=>$chkmaster->harm_username,
                'harm_locationid'=>$chkmaster->harm_locationid,
                'harm_orgid'=>$chkmaster->harm_orgid
                );
            if(!empty($arrayhandovermaster)){
                $this->db->insert('harm_handoverreqmaster',$arrayhandovermaster);
                $last_masterid=$this->db->insert_id();
                if(!empty($last_masterid)){
                    // $itemArray[]=array()
                    // echo "<pre>";
                    // print_r($item_n_locArray);
                    // die();
                    if(!empty($item_n_locArray)){
                        foreach ($item_n_locArray as $kl => $itm) {
                           $locid=$itm['loc_id'];
                           $itemid=$itm['itemid'];

                           $chkdetail_list=$this->check_item_with_handovermaster('detail',array('hard_itemsid'=>$itemid));
                            // echo "<pre>";
                            // print_r($chkdetail_list);
                            // die();
                           if($locid==$loc){
                            if(!empty($chkdetail_list)){
                                foreach ($chkdetail_list as $kcl => $chkdtl) {
                                    $chkitem_id=$chkdtl->hard_itemsid;
                                    if($itemid==$chkitem_id) {
                                        $reqArray=array(
                                        'hard_code'=>$chkdtl->hard_code,
                                        'hard_handovermasterid'=>$last_masterid,
                                        'hard_itemsid'=>$chkdtl->hard_itemsid,
                                        'hard_qty'=>$chkdtl->hard_qty,
                                        'hard_remarks'=>$chkdtl->hard_remarks,
                                        'hard_totalamt'=>$chkdtl->hard_totalamt,
                                        'hard_unitprice'=>$chkdtl->hard_unitprice,
                                        'hard_remqty'=>$chkdtl->hard_remqty,
                                        'hard_unit'=>$chkdtl->hard_unit,
                                        'hard_postip'=>$chkdtl->hard_postip,
                                        'hard_postmac'=>$chkdtl->hard_postmac,
                                        'hard_posttime'=>$chkdtl->hard_posttime,
                                        'hard_postdatead'=>$chkdtl->hard_postdatead,
                                        'hard_postdatebs'=>$chkdtl->hard_postdatebs,
                                        'hard_postby'=>$chkdtl->hard_postby,
                                        'hard_fromlocationid'=>$this->locationid,
                                        'hard_tolocationid'=>$loc,
                                        'hard_orgid'=>$chkdtl->hard_orgid,
                                        'hard_locationid'=>$chkdtl->hard_locationid,
                                        'hard_fromdepid'=>$chkdtl->hard_fromdepid
                                        );
                                        $this->db->insert('hard_handoverreqdetail',$reqArray);
                                    }
                                     

                                }
                               
                            }
                          
                           }

                        }

                    }
                }
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
        

       
    }

    public function check_item_with_handovermaster($type,$srchcol=false)
    {
        $handovermasterid=$this->input->post('handovermasterid');
        if($type=='master'):
            $this->db->select('*');
            $this->db->from('harm_handoverreqmaster hm');
            $this->db->where(array('hm.harm_handovermasterid'=>$handovermasterid));
            if($srchcol)
            {
                $this->db->where($srchcol);
            }
            $qry=$this->db->get();
             if ($qry->num_rows() > 0) 
            {
                $data=$qry->row();     
                return $data;       
            }       
        return false;

        endif;

        if($type=='detail'):
            $this->db->select('*');
            $this->db->from('hard_handoverreqdetail hd');
            $this->db->where(array('hd.hard_handovermasterid'=>$handovermasterid));
            if($srchcol)
            {
                $this->db->where($srchcol);
            }
            $qry=$this->db->get();
             if ($qry->num_rows() > 0) 
            {
                $data=$qry->result();     
                return $data;       
            }       
        return false;

        endif;

    }

    public function request_for_approval(){
        $handovermasterid = $this->input->post('handovermasterid');

        $approval_level = $this->input->post('approval_level');

        $handover_array = array(
            'harm_handoverlvl' => $approval_level
        ); 

        if($handover_array){
            $this->db->where('harm_handovermasterid', $handovermasterid);
            $this->db->update('harm_handoverreqmaster',$handover_array);
        }      
        if($this->db->affected_rows() >=0){
            $this->general->saveActionLog('harm_handoverreqmaster', $handovermasterid, $this->userid, $approval_level,'harm_handoverlvl'); 

            return true; 
        }else{
            return false;
        } 
    }
}