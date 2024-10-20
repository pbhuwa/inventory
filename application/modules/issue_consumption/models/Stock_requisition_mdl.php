<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stock_requisition_mdl extends CI_Model

{

    public function __construct(){

        parent::__construct();

        $this->rema_masterTable='rema_reqmaster';

        $this->rede_detailTable='rede_reqdetail';

        $this->userid = $this->session->userdata(USER_ID);

        $this->username = $this->session->userdata(USER_NAME);

        $this->curtime = $this->general->get_currenttime();

        $this->mac = $this->general->get_Mac_Address();

        $this->ip = $this->general->get_real_ipaddr();

        $this->locationid=$this->session->userdata(LOCATION_ID);

        $this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);

        $this->orgid=$this->session->userdata(ORG_ID);

        $this->storeid = $this->session->userdata(STORE_ID);

        $this->usergroup = $this->session->userdata(USER_GROUPCODE);

        if(defined('USER_DESIGNATION')):

        $this->userdesignation = $this->session->userdata(USER_DESIGNATION);

        else:

        $this->userdesignation='';

        endif;

          if(defined('USER_DEPT')):

        $this->departmentid = $this->session->userdata(USER_DEPT);

        else:

        $this->departmentid='';

        endif;

       // echo "<pre>";

       // print_r($this->departmentid);

       // die();

    }

    public $validate_settings_stock_requisition = array(

    array('field' => 'rema_reqno', 'label' => 'REQ Number', 'rules' => 'trim|required|xss_clean'),

    array('field' => 'rema_reqby', 'label' => 'Requested By', 'rules' => 'trim|required|xss_clean'),

    array('field' => 'rema_reqfromdepid', 'label' => 'Department ', 'rules' => 'trim|required|xss_clean'),

    array('field' => 'rede_itemsid[]', 'label' => 'Items ', 'rules' => 'trim|required|xss_clean'),

    array('field' => 'rede_qty[]', 'label' => 'Required .Qty ', 'rules' => 'trim|required|xss_clean|greater_than[0]'),

    );

    public function stock_requisition_save(){       

        try{

            // echo "<pre>";

            // print_r($this->input->post());

            // die();

            $id = $this->input->post('id');

            $req_date=$this->input->post('rema_reqdate');

            $approved_date=$this->input->post('rema_approveddate');

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

            $rema_isdep = $this->input->post('rema_isdep');

            $rema_storeid = $this->session->userdata(STORE_ID); //need check

            $rema_manualno = $this->input->post('rema_manualno');

            $rema_reqfromdepid = $this->input->post('rema_reqfromdepid');

            $rema_reqtodepid = $this->input->post('rema_reqtodepid');

            $rema_reqby = $this->input->post('rema_reqby');

            $rema_remarks = $this->input->post('rema_remarks');

            $rema_workplace = $this->input->post('rema_workplace');

            $rema_workdesc = $this->input->post('rema_workdesc');

            //if approval

            $rema_approved = $this->input->post('rema_approved');

            $rema_approvedby = $this->input->post('rema_approvedby');

            $rema_school=$this->input->post('rema_school');

            $subottaltotal = $this->input->post('subtotalamt');

            $grandtotal = $this->input->post('totalamount');

            $rema_reqto = $this->input->post('rema_reqto');

            $remarks = $this->input->post('remarks');

            $mattypeid = $this->input->post('rema_mattypeid');

            $designation=$this->input->post('rema_reqtodesignation');
            $rema_fyear=$this->input->post('rema_fyear');

            if(!empty($designation))

            {

                $designationid=implode(',', $designation);   

            }else{

                 $designationid='';  

            }

            $cur_fiscalyear=!empty($rema_fyear) ? $rema_fyear : CUR_FISCALYEAR;


            $default_reqArr=array('rema_reqtodepid'=>$rema_reqtodepid,'rema_fyear'=>$cur_fiscalyear,'rema_locationid'=>$this->locationid);

            $mattype=!empty($this->input->post('rema_mattypeid'))?$this->input->post('rema_mattypeid'):'';

             if($this->mattypeid){    

                   $mattype= $this->mattypeid;

             }

         


             
                 if (defined('SHOW_MATERIAL_OPTION_TYPE')) :
                $show_material_type=SHOW_MATERIAL_OPTION_TYPE;
                else:
                    $show_material_type='N';
                endif;
                if($show_material_type=='Y'){
                    if($mattype){

                    $default_reqArr['rema_mattypeid']=$mattype;

                    }
                }


            $generate_reqno = $this->get_req_no($default_reqArr);

            $reqno = '';

            if(!empty($generate_reqno)){

                $reqno = !empty($generate_reqno[0]->reqno)?$generate_reqno[0]->reqno+1:1;

            }

            if($id){

                $rema_reqno = $this->input->post('rema_reqno');

            }else{

                $rema_reqno = $reqno;    

            }

            $reme_remarks =   $this->input->post('rema_remarks');

             $reme_workplace =   $this->input->post('reme_workplace');

            $reme_workdesc =   $this->input->post('reme_workdesc');

            $rema_subdepid=$this->input->post('rema_subdepid');

            if(!empty($rema_subdepid)){

                $rema_reqfromdepid= $rema_subdepid;

            }

            // requisition detail items

            $itemcode = $this->input->post('rede_code');

            $itemsid = $this->input->post('rede_itemsid');

            $rede_unit =   $this->input->post('rede_unit');

            $qty =   $this->input->post('rede_qty');

            $remarks =   $this->input->post('rede_remarks');

            $qtyinstock =   $this->input->post('rede_qtyinstock');

            $rede_unitprice =   $this->input->post('rede_unitprice');

            $rede_totalamt =   $this->input->post('rede_totalamt');

            $reqdetailid = $this->input->post('rede_reqdetailid');

            $save_type = !empty($this->input->post('save_type'))?$this->input->post('save_type'):'';

            $rede_catid = $this->input->post('rede_catid') ?? []; 
            $rede_budgetheadid = $this->input->post('rede_budgetheadid') ?? []; 
            $rede_isbudgetavl = $this->input->post('rede_isbudgetavl') ?? []; 

            $ReqMasterArray = array(

                                'rema_reqno'=>$rema_reqno,

                                'rema_isdep'=>$rema_isdep,

                                'rema_storeid'=>$rema_storeid,

                                'rema_reqdatebs'=>$reqdatebs,

                                'rema_reqdatead'=>$reqdatead,

                                'rema_manualno'=>$rema_manualno,

                                'rema_remarks'=>$rema_remarks,

                                'rema_workplace'=>$rema_workplace,

                                'rema_workdesc'=>$rema_workdesc,

                                'rema_reqfromdepid'=>$rema_reqfromdepid,

                                'rema_reqtodepid'=>$rema_reqtodepid,

                                'rema_reqby'=>$rema_reqby,
                                
                                'rema_reqto' => $rema_reqto,

                                'rema_fyear'=>CUR_FISCALYEAR,   

                                'rema_received'=>'0',

                                'rema_username'=>$this->username,

                                'rema_reqtodesignation'=>$designationid

                            );

            if(!empty($mattypeid)){

                $ReqMasterArray['rema_mattypeid']=$mattypeid;

            }

            if(!empty($rema_school)){

                $ReqMasterArray['rema_school']=$rema_school;

            }

            $this->db->trans_begin();

            if($id && $save_type != 'resubmit'){ // update

                //update master

                $ReqMasterArray = array(

                                'rema_reqno'=>$rema_reqno,

                                'rema_isdep'=>$rema_isdep,

                                'rema_storeid'=>$rema_storeid,

                                'rema_reqdatebs'=>$reqdatebs,

                                'rema_reqdatead'=>$reqdatead,

                                'rema_manualno'=>$rema_manualno,

                                'rema_remarks'=>$rema_remarks,

                                'rema_workplace'=>$rema_workplace,

                                'rema_workdesc'=>$rema_workdesc,

                                'rema_reqfromdepid'=>$rema_reqfromdepid,

                                'rema_reqtodepid'=>$rema_reqtodepid,

                                'rema_reqby'=>$rema_reqby,

                                'rema_reqto' => $rema_reqto,

                                'rema_fyear'=>$cur_fiscalyear,   

                                'rema_received'=>'0',

                                'rema_username'=>$this->username,

                                'rema_modifydatead'=>CURDATE_EN,

                                'rema_modifydatebs'=>CURDATE_NP,

                                'rema_modifytime'=>$this->curtime,

                                'rema_modifyby'=>$this->userid,

                                'rema_modifymac'=>$this->mac,

                                'rema_modifyip'=>$this->ip,

                                'rema_locationid'=>$this->locationid,

                                'rema_reqtodesignation'=>$designationid,  

                                'rema_orgid'=>$this->orgid

                            );

                     if(!empty($mattypeid)){

                    $ReqMasterArray['rema_mattypeid']=$mattypeid;

                }

                    if($ReqMasterArray) {

                        $this->general->save_log($this->rema_masterTable,'rema_reqmasterid',$id,$ReqMasterArray,'Update');

                        $this->db->update($this->rema_masterTable,$ReqMasterArray,array('rema_reqmasterid'=>$id));

                        // $this->db->where('rema_reqmasterid',$id);

                        // echo $this->db->last_query();

                        // die();

                    }             

                // update detail

                $ReqMasterArray['rema_approved'] = '0';//$rema_approved;

                $ReqMasterArray['rema_approvedby'] = $rema_approvedby;

                $ReqMasterArray['rema_approveddatebs'] = $approveddatebs;

                $ReqMasterArray['rema_approveddatead'] = $approveddatead;

                $old_rede_list = $this->get_all_rede_id(array('rede_reqmasterid'=>$id)); // check old req detail ids

                $old_rede_array=array();

                if(!empty($old_rede_list)){

                    foreach($old_rede_list as $key=>$value){

                        $old_rede_array[] = $value->rede_reqdetailid;

                    }

                }

                //echo "<pre>";print_r($ReqMasterArray);die();

                // if(!empty($ReqMasterArray)){

                    //update master table

                    // $this->db->update($this->rema_masterTable,$ReqMasterArray,array('rema_reqmasterid'=>$id));

                    // $rowaffected=$this->db->affected_rows();

                    $rede_insertid=array();

                    // if($rowaffected){

                        if(!empty($itemsid)){

                            foreach($itemsid as $key=>$val){

                                $reqdetlid = !empty($reqdetailid[$key])?$reqdetailid[$key]:'';

                                if($reqdetlid){

                                    if(in_array($reqdetlid, $old_rede_array)){

                                        $rede_array[] = $reqdetlid;

                                        }

                                        $rede_update_array = array(

                                            // 'rede_reqmasterid'=>$insertid,

                                            'rede_itemsid'=> !empty($itemsid[$key])?$itemsid[$key]:'',

                                            'rede_code'=> !empty($itemcode[$key])?$itemcode[$key]:'',

                                            'rede_unit'=> !empty($rede_unit[$key])?$rede_unit[$key]:'',

                                            'rede_qty'=> !empty($qty[$key])?$qty[$key]:'',

                                            'rede_remqty'=> !empty($qty[$key])?$qty[$key]:'',

                                            'rede_remarks'=> !empty($remarks[$key])?$remarks[$key]:'',

                                            'rede_unitprice'=> !empty($rede_unitprice[$key])?$rede_unitprice[$key]:'',

                                            'rede_totalamt'=> !empty($rede_totalamt[$key])?$rede_totalamt[$key]:'',

                                            'rede_istempitem'=>!empty($itemcode[$key])?'N':'Y',

                                            // 'rede_qtyinstock'=>!empty($qtyinstock[$key])?$qtyinstock[$key]:'',

                                            'rede_modifydatead'=>CURDATE_EN,

                                            'rede_modifydatebs'=>CURDATE_NP,

                                            'rede_modifytime'=>$this->curtime,

                                            'rede_modifyby'=>$this->userid,

                                            'rede_modifymac'=>$this->mac,

                                            'rede_modifyip'=>$this->ip,

                                            'rede_fromstoreid'=>!empty($rema_reqfromdepid)?$rema_reqfromdepid:'',

                                            'rede_tostoreid'=>!empty($rema_reqtodepid)?$rema_reqtodepid:'',

                                        );

                                        $this->general->save_log($this->rede_detailTable,'rede_reqdetailid',$reqdetlid,$rede_update_array,'Update');

                                        $this->db->update($this->rede_detailTable, $rede_update_array,array('rede_reqdetailid'=>$reqdetlid));

                                    } // if in array of reqdetailid

                                    else{

                                        $rede_insert_array = array(

                                            'rede_reqmasterid'=>$id,

                                            'rede_itemsid'=> !empty($itemsid[$key])?$itemsid[$key]:'',

                                            'rede_code'=> !empty($itemcode[$key])?$itemcode[$key]:'',

                                            'rede_unit'=> !empty($rede_unit[$key])?$rede_unit[$key]:'',

                                            'rede_qty'=> !empty($qty[$key])?$qty[$key]:'',

                                            'rede_remqty'=> !empty($qty[$key])?$qty[$key]:'',

                                            'rede_remarks'=> !empty($remarks[$key])?$remarks[$key]:'',

                                             'rede_unitprice'=> !empty($rede_unitprice[$key])?$rede_unitprice[$key]:'',

                                            'rede_totalamt'=> !empty($rede_totalamt[$key])?$rede_totalamt[$key]:'',

                                            'rede_istempitem'=>!empty($itemcode[$key])?'N':'Y',

                                             // 'rede_qtyinstock'=>!empty($qtyinstock[$key])?$qtyinstock[$key]:'',

                                            'rede_postdatead'=>CURDATE_EN,

                                            'rede_postdatebs'=>CURDATE_NP,

                                            'rede_posttime'=>$this->curtime,

                                            'rede_postby'=>$this->userid,

                                            'rede_postmac'=>$this->mac,

                                            'rede_postip'=>$this->ip,

                                            'rede_locationid'=>$this->locationid,

                                            'rede_fromstoreid'=>!empty($rema_reqfromdepid)?$rema_reqfromdepid:'',

                                            'rede_tostoreid'=>!empty($rema_reqtodepid)?$rema_reqtodepid:'',

                                            'rede_orgid'=>$this->orgid

                                        );

                                        $this->db->insert($this->rede_detailTable, $rede_insert_array);

                                        $rede_insertid[] = $this->db->insert_id();

                                    } // end if ... no reqdetailid... inserted

                                 // end if reqdetailid ... updated

                            } // end foreach itemsid

                            if(!empty($rede_array)){

                                // if(!empty($rede_insertid)){

                                //     $this->db->where_not_in('rede_reqdetailid',$rede_insertid);

                                // }

                                // $this->db->where(array('rede_reqmasterid'=>$id));

                                // $this->db->where_not_in('rede_reqdetailid',$rede_array);

                                // $this->db->update($this->rede_detailTable,array('rede_isdelete'=>'Y'));

                            } // end if rede_array

                        } // end if itemsid

                    // }

                // }

                //for deleted items

                $old_items_list = $this->general->get_tbl_data('rede_reqdetailid','rede_reqdetail',array('rede_reqmasterid'=>$id));

                $old_items_array = array();

                if(!empty($old_items_list)){

                    foreach($old_items_list as $key=>$value){

                        $old_items_array[] = $value->rede_reqdetailid;

                    }

                }

                // print_r($old_items_array);

                // die();

                $total_itemlist = count($old_items_list);

                $deleted_items = array();

                if($rede_insertid){

                    $reqdetailid = array_merge($reqdetailid, $rede_insertid);

                }

                if(is_array($reqdetailid)){

                    $deleted_items = array_diff($old_items_array, $reqdetailid);

                }

                $del_items_num = count($deleted_items);

                if(!empty($del_items_num)){

                    for($i = 0; $i<$del_items_num; $i++){

                        $deleted_array = array_values($deleted_items);

                        foreach($deleted_array as $key=>$del){

                            // $deletedItemsArray = array(

                            //     'rede_isdelete' => 'Y',

                            //     'rede_modifydatead'=>CURDATE_EN,

                            //     'rede_modifydatebs'=>CURDATE_NP,

                            //     'rede_modifytime'=>$this->curtime,

                            //     'rede_modifyby'=>$this->userid,

                            //     'rede_modifymac'=>$this->mac,

                            //     'rede_modifyip'=>$this->ip,

                            // );

                            // if($deletedItemsArray){

                            //     $this->db->where(array('rede_itemsid'=>$del,'rede_reqmasterid'=>$id));

                            //     $this->db->update('rede_reqdetail',$deletedItemsArray);

                            // }

                            $this->db->where(array('rede_reqdetailid'=>$del));

                            $this->db->delete('rede_reqdetail');

                        }

                    }

                }

            }// if id not exists (new insert)

            else{

                $ReqMasterArray = array(

                    'rema_reqno'=>$rema_reqno,

                    'rema_isdep'=>$rema_isdep,

                    'rema_storeid'=>$rema_storeid,

                    'rema_reqdatebs'=>$reqdatebs,

                    'rema_reqdatead'=>$reqdatead,

                    'rema_manualno'=>$rema_manualno,

                    'rema_remarks'=>$rema_remarks,

                    'rema_workplace'=>$rema_workplace,

                    'rema_workdesc'=>$rema_workdesc,

                    'rema_reqfromdepid'=>$rema_reqfromdepid,

                    'rema_reqtodepid'=>$rema_reqtodepid,

                    'rema_reqby'=>$rema_reqby,

                    'rema_reqto' => $rema_reqto,

                    'rema_fyear'=>$cur_fiscalyear,   

                    'rema_received'=>'0',

                    'rema_username'=>$this->username,

                    'rema_postdatead'=>CURDATE_EN,

                    'rema_postdatebs'=>CURDATE_NP,

                    'rema_posttime'=>$this->curtime,

                    'rema_postby'=>$this->userid,

                    'rema_postmac'=>$this->mac,

                    'rema_postip'=>$this->ip,

                    'rema_locationid'=>$this->locationid, 

                    'rema_reqtodesignation'=>$designationid,  

                    'rema_orgid'=>$this->orgid

                );

                if(ORGANIZATION_NAME == "KUKL" && $save_type == 'resubmit'){
                    $ReqMasterArray['rema_parentreqmasterid']=$this->input->post('id');
                }
       
                if(!empty($ReqMasterArray))

                {   //print_r($ReqMasterArray);die;

                     if(!empty($mattypeid)){

                            $ReqMasterArray['rema_mattypeid']=$mattypeid;

                     }

                      if(!empty($rema_school)){

                        $ReqMasterArray['rema_school']=$rema_school;

                    }

                     // echo "<pre>";

                     // print_r($ReqMasterArray);

                     // die();

                    $this->db->insert($this->rema_masterTable,$ReqMasterArray);

                    $insertid=$this->db->insert_id($this->rema_masterTable,'rema_reqmasterid');

                    if($insertid){

                        //$ReqDetail[] = array();

                        if(!empty($itemsid)):

                            foreach ($itemsid as $key => $val) {

                                $ReqDetail=array( 

                                    'rede_reqmasterid'=>$insertid,

                                    'rede_itemsid'=> !empty($itemsid[$key])?$itemsid[$key]:'',

                                    'rede_code'=> !empty($itemcode[$key])?$itemcode[$key]:'',

                                    'rede_unit'=> !empty($rede_unit[$key])?$rede_unit[$key]:'',

                                    'rede_qty'=> !empty($qty[$key])?$qty[$key]:'',

                                    'rede_remqty'=> !empty($qty[$key])?$qty[$key]:'',

                                    'rede_qtyinstock'=>!empty($qtyinstock[$key])?$qtyinstock[$key]:'',

                                    'rede_remarks'=> !empty($remarks[$key])?$remarks[$key]:'',

                                     'rede_unitprice'=> !empty($rede_unitprice[$key])?$rede_unitprice[$key]:'',

                                     'rede_totalamt'=> !empty($rede_totalamt[$key])?$rede_totalamt[$key]:'',

                                    'rede_postdatead'=>CURDATE_EN,

                                    'rede_postdatebs'=>CURDATE_NP,

                                    'rede_posttime'=>$this->curtime,

                                    'rede_postby'=>$this->userid,

                                    'rede_postmac'=>$this->mac,

                                    'rede_postip'=>$this->ip,

                                    'rede_locationid'=>$this->locationid,

                                    'rede_fromstoreid'=>!empty($rema_reqfromdepid)?$rema_reqfromdepid:'',

                                    'rede_tostoreid'=>!empty($rema_reqtodepid)?$rema_reqtodepid:'',

                                    'rede_orgid'=>$this->orgid,

                                    'rede_istempitem'=>!empty($itemcode[$key])?'N':'Y'

                                );
                                if(ORGANIZATION_NAME == "KUKL" && $save_type == 'resubmit'){
                                $ReqDetail['rede_catid'] = $rede_catid[$key] ?? '';
                                $ReqDetail['rede_budgetheadid'] = $rede_budgetheadid[$key] ?? '';
                                $ReqDetail['rede_isbudgetavl'] = $rede_isbudgetavl[$key] ?? ''; 
                                }

                                $this->db->insert($this->rede_detailTable,$ReqDetail);

                            }

                        endif;

                        // if(!empty($ReqDetail)){   

                        //     //echo"<pre>";print_r($ReqDetail);die;

                        //     $this->db->insert_batch($this->rede_detailTable,$ReqDetail);

                        // }

                    } // if insertid

                } // check if ReqMasterArray

                if($save_type == 'resubmit'){

                    $rema_id = $this->input->post('id');

                    if($rema_id){

                        $item_available_master = array(

                            'rema_itemavailable'=>2

                        );

                        $this->db->update($this->rema_masterTable, $item_available_master,array('rema_reqmasterid'=>$rema_id));

                        $item_available_detail = array(

                            'rede_itemavailable'=>2

                        );

                        $this->db->update($this->rede_detailTable, $item_available_detail,array('rede_reqmasterid'=>$rema_id,'rede_itemavailable'=>1));

                    }

                }

            } // end else

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

    public function get_all_rede_id($srchcol = false){

        try{

            $this->db->select('rede_reqdetailid');

            $this->db->from($this->rede_detailTable);

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

    public function get_requisition_list($cond = false)

    {

        $get = $_GET;                          

        foreach ($get as $key => $value) {

            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));

        }

         // echo "<pre>";print_r($get); die();

        if(!empty($get['sSearch_0'])){

            $this->db->where("lower(rema_reqmasterid) like  '%".$get['sSearch_0']."%'  ");

        }

        if(!empty($get['sSearch_1'])){

            $this->db->where("lower(rema_reqdatead) like  '%".$get['sSearch_1']."%'  ");

        }

        if(!empty($get['sSearch_2'])){

            $this->db->where("lower(rema_reqdatebs) like  '%".$get['sSearch_2']."%'  ");

        }

        if(!empty($get['sSearch_3'])){

            $this->db->where("lower(rema_reqno) like  '%".$get['sSearch_3']."%'  ");

        }

         if(!empty($get['sSearch_4'])){

            $this->db->where("lower(d.dept_depname) like  '%".$get['sSearch_4']."%'  ");

        } 

        if(!empty($get['sSearch_5'])){

            $this->db->where("lower(eqty_equipmenttype) like  '%".$get['sSearch_5']."%'  ");

        } 

        if(!empty($get['sSearch_6'])){

            $this->db->where("lower(rema_username) like  '%".$get['sSearch_6']."%'  ");

        }

        if(!empty($get['sSearch_7'])){

            $this->db->where("lower(rema_isdep) like  '%".$get['sSearch_7']."%'  ");

        }

         if(!empty($get['sSearch_8'])){

            $this->db->where("lower(rema_reqby) like  '%".$get['sSearch_8']."%'  ");

        }

         if(!empty($get['sSearch_9'])){

            $this->db->where("lower(rema_approvedby) like  '%".$get['sSearch_9']."%'  ");

        }

        if(!empty($get['sSearch_10'])){

            $this->db->where("lower(rema_manualno) like  '%".$get['sSearch_10']."%'  ");

        }

        if(!empty($get['sSearch_12'])){

            $this->db->where("lower(rema_fyear) like  '%".$get['sSearch_12']."%'  ");

        }

        if($cond) {

            $this->db->where($cond);

        }

            $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');

            $toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');

            $type = !empty($get['type'])?$get['type']:$this->input->post('type');

            $apptype = !empty($get['apptype'])?$get['apptype']:$this->input->post('apptype');

            $input_locationid= !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');

            $departmentid= !empty($get['departmentid'])?$get['departmentid']:$this->input->post('departmentid');

            $fiscalyear = !empty($get['fiscalyear'])?$get['fiscalyear']:$this->input->post('fiscalyear');

             $mattype = !empty($get['mattype'])?$get['mattype']:$this->input->post('mattype');

            if(ORGANIZATION_NAME=='KUKL'){

                 $color_codeclass=$this->general->get_color_code('*','coco_colorcode',array('coco_isactive'=>'Y','coco_listname'=>'req_summary','coco_isallorg'=>'Y'));

                 if(!empty($color_codeclass)):

                 foreach ($color_codeclass as $key => $color) {

                    if($approved==$color->coco_statusval)

                    {

                    $appclass=$color->coco_statusname;

                     }

                   }

                endif;

            }else{

            if($apptype=='pending')

            {

                $approved=0;

            }

            if($apptype=='approved')

            {

                $approved=1;

            }

            if($apptype=='unapproved')

            {

                $approved=2;

            }

            if($apptype=='cancel')

            {

                $approved=3;

            }

            if($apptype=='verified')

            {

                $approved=4;

            }

            if($apptype=='cntissue')

            {

                $approved='';

            }

            }

        // $this->db->select('d.dept_depname');

        // $this->db->from('dept_department d');

        // $this->db->where('d.dept_depid','rm.rema_reqfromdepid',false);

        // $subquery1 = $this->db->get_compiled_select();

        $subquery1="(SELECT d.dept_depname FROM xw_dept_department d WHERE d.dept_depid=rm.rema_reqfromdepid)";

        // $this->db->select('et.eqty_equipmenttype');

        // $this->db->from('eqty_equipmenttype et');

        // $this->db->where('et.eqty_equipmenttypeid','rm.rema_reqtodepid',false);

        // $subquery2 = $this->db->get_compiled_select();

        $subquery2 = "(SELECT et.eqty_equipmenttype FROM xw_eqty_equipmenttype et WHERE et.eqty_equipmenttypeid=rm.rema_reqtodepid)";

        $subquery3="(SELECT  ett.eqty_equipmenttype  FROM xw_eqty_equipmenttype ett WHERE ett.eqty_equipmenttypeid=rm.rema_reqfromdepid AND rm.rema_isdep='N') fromdep_transfer";

        if(!empty(($frmDate && $toDate)))

        {

            if(DEFAULT_DATEPICKER == 'NP'){

                $this->db->where('rm.rema_reqdatebs >=',$frmDate);

                $this->db->where('rm.rema_reqdatebs <=',$toDate);    

            }else{

                $this->db->where('rm.rema_reqdatead >=',$frmDate);

                $this->db->where('rm.rema_reqdatead <=',$toDate);

            }

        }

        if(!empty($type)){

            $this->db->where('rm.rema_isdep',$type);

        }

          if(!empty($mattype)){

            $this->db->where('rm.rema_mattypeid',$mattype);

        }

        if($apptype!="cntissue"){

        if(!empty($apptype))

         {

            $this->db->where('rm.rema_approved',"$approved");

         }

        }

        if($this->location_ismain=='Y')

        {

            if($input_locationid)

            {

                $this->db->where('rm.rema_locationid',$input_locationid);

            }

        }

        else

        {

            $this->db->where('rm.rema_locationid',$this->locationid);

        }

        if(!empty($departmentid))

         {

            $this->db->where('rm.rema_reqfromdepid',"$departmentid");

         }

        if($this->usergroup=='DM'):

              $this->db->where('rm.rema_postby',$this->userid);

        endif;

        if($this->usergroup == 'SK' || $this->usergroup == 'SI'):

            $this->db->where('rm.rema_approved','4');

        endif;

        $this->db->where('rema_isdep <>',' ');

        $resltrpt=$this->db->select("COUNT(*) as cnt")

                        ->from('rema_reqmaster rm')

                        ->join('dept_department d','d.dept_depid=rm.rema_reqfromdepid','LEFT')

                        //->join('rede_reqdetail rd','rd.rede_reqmasterid=rm.rema_reqmasterid','LEFT')

                        ->join('eqty_equipmenttype et','et.eqty_equipmenttypeid=rm.rema_reqtodepid','LEFT')

                        ->get()

                        ->row();

       // echo $this->db->last_query();

       // die();

        $totalfilteredrecs=$resltrpt->cnt; 

        $order_by = 'rema_reqmasterid';

        $order = 'desc';

        if($this->input->get('sSortDir_0'))

        {

                $order = $this->input->get('sSortDir_0');

        }

        $where='';

       if($this->input->get('iSortCol_0')==1)

            $order_by = 'rema_reqdatead';

        else if($this->input->get('iSortCol_0')==2)

            $order_by = 'rema_reqdatebs';

        else if($this->input->get('iSortCol_0')==3)

            $order_by = 'rema_reqno';

        else if($this->input->get('iSortCol_0')==4)

            $order_by = 'dept_depname';

        else if($this->input->get('iSortCol_0')==5)

            $order_by = 'eqty_equipmenttype';

        else if($this->input->get('iSortCol_0')==6)

            $order_by = 'rema_username';

        else if($this->input->get('iSortCol_0')==7)

            $order_by = 'rema_isdep';

        else if($this->input->get('iSortCol_0')==8)

            $order_by = 'rema_reqby';

         else if($this->input->get('iSortCol_0')==9)

            $order_by = 'rema_approvedby';

        else if($this->input->get('iSortCol_0')==10)

            $order_by = 'rema_manualno';

        else if($this->input->get('iSortCol_0')==12)

            $order_by = 'rema_fyear';

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

            $this->db->where("lower(rema_reqmasterid) like  '%".$get['sSearch_0']."%'  ");

        }

        if(!empty($get['sSearch_1'])){

            $this->db->where("lower(rema_reqdatead) like  '%".$get['sSearch_1']."%'  ");

        }

        if(!empty($get['sSearch_2'])){

            $this->db->where("lower(rema_reqdatebs) like  '%".$get['sSearch_2']."%'  ");

        }

        if(!empty($get['sSearch_3'])){

            $this->db->where("lower(rema_reqno) like  '%".$get['sSearch_3']."%'  ");

        }

         if(!empty($get['sSearch_4'])){

            $this->db->where("lower(d.dept_depname) like  '%".$get['sSearch_4']."%'  ");

        } 

        if(!empty($get['sSearch_5'])){

            $this->db->where("lower(eqty_equipmenttype) like  '%".$get['sSearch_5']."%'  ");

        } 

        if(!empty($get['sSearch_6'])){

            $this->db->where("lower(rema_username) like  '%".$get['sSearch_6']."%'  ");

        }

        if(!empty($get['sSearch_7'])){

            $this->db->where("lower(rema_isdep) like  '%".$get['sSearch_7']."%'  ");

        }

         if(!empty($get['sSearch_8'])){

            $this->db->where("lower(rema_reqby) like  '%".$get['sSearch_8']."%'  ");

        }

         if(!empty($get['sSearch_9'])){

            $this->db->where("lower(rema_approvedby) like  '%".$get['sSearch_9']."%'  ");

        }

        if(!empty($get['sSearch_12'])){

            $this->db->where("lower(rema_fyear) like  '%".$get['sSearch_12']."%'  ");

        }

        if(!empty($get['sSearch_10'])){

            $this->db->where("lower(rema_manualno) like  '%".$get['sSearch_10']."%'  ");

        }

            $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');

            $toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');

            $type = !empty($get['type'])?$get['type']:$this->input->post('type');

            $apptype = !empty($get['apptype'])?$get['apptype']:$this->input->post('apptype');

            $input_locationid= !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');

             $departmentid= !empty($get['departmentid'])?$get['departmentid']:$this->input->post('departmentid');

            $fiscalyear = !empty($get['fiscalyear'])?$get['fiscalyear']:$this->input->post('fiscalyear');

           if(ORGANIZATION_NAME=='KUKL'){

            $color_codeclass=$this->general->get_color_code('*','coco_colorcode',array('coco_isactive'=>'Y','coco_listname'=>'req_summary','coco_isallorg'=>'Y'));

                 if(!empty($color_codeclass)):

                 foreach ($color_codeclass as $key => $color) {

                    if($approved==$color->coco_statusval)

                    {

                    $appclass=$color->coco_statusname;

                     }

                   }

                    endif;

            }else{

                if($apptype=='pending')

                {

                    $approved=0;

                }

                if($apptype=='approved')

                {

                    $approved=1;

                }

                if($apptype=='unapproved')

                {

                    $approved=2;

                }

                if($apptype=='cancel')

                {

                    $approved=3;

                }

                if($apptype=='verified')

                {

                    $approved=4;

                }

                if($apptype=='cntissue')

                {

                    $approved='';

                }

            }

        if(!empty(($frmDate && $toDate)))

        {

            if(DEFAULT_DATEPICKER == 'NP'){

                $this->db->where('rm.rema_reqdatebs >=',$frmDate);

                $this->db->where('rm.rema_reqdatebs <=',$toDate);    

            }else{

                $this->db->where('rm.rema_reqdatead >=',$frmDate);

                $this->db->where('rm.rema_reqdatead <=',$toDate);

            }

        }

        if($type){

            $this->db->where('rm.rema_isdep',$type);

        }

          if(!empty($mattype)){

            $this->db->where('rm.rema_mattypeid',$mattype);

        }

      if($apptype!="cntissue"){

        if(!empty($apptype))

         {

            $this->db->where('rm.rema_approved',"$approved");

         }

        }

        // if($fiscalyear)

        // {

        //     $this->db->where('rema_fyear',$fiscalyear);

        // }

        if($this->location_ismain=='Y')

        {

            if($input_locationid)

            {

                $this->db->where('rm.rema_locationid',$input_locationid);

            }

        }

        else

        {

             $this->db->where('rm.rema_locationid',$this->locationid);

        }

      if(!empty($departmentid))

         {

            $this->db->where('rm.rema_reqfromdepid',"$departmentid");

         }

        if($this->usergroup=='DM'):

              $this->db->where('rm.rema_postby',$this->userid);

        endif;

        // Store keeper and Store incharge can only view verified demand

        if($this->usergroup == 'SK' || $this->usergroup == 'SI'):

            $this->db->where('rm.rema_approved','4');

        endif;

        $cntitemQty="(SELECT COUNT(*) as cntitem from xw_rede_reqdetail rd WHERE rd.rede_remqty >0 AND rd.rede_reqmasterid=rm.rema_reqmasterid AND rd.rede_isdelete = 'N') as cntitem";

        $this->db->select("rm.*,rm.rema_remarks,rm.rema_workplace,rm.rema_workdesc,mt.maty_material,$cntitemQty, ($subquery1) depfrom, ($subquery2) depto,  $subquery3 ");

        $this->db->from('rema_reqmaster rm');

        $this->db->join('dept_department d','d.dept_depid=rm.rema_reqfromdepid','LEFT');
        $this->db->join('maty_materialtype mt','mt.maty_materialtypeid=rm.rema_mattypeid',"LEFT");

        //$this->db->join('rede_reqdetail rd','rd.rede_reqmasterid=rm.rema_reqmasterid','LEFT');

        $this->db->join('eqty_equipmenttype et','et.eqty_equipmenttypeid=rm.rema_reqtodepid','LEFT');

        $this->db->where('rema_isdep <>',' ');

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

        if (!empty($_GET['iDisplayLength']) &&  !empty($nquery) && is_array($nquery) && count($nquery) > 0 ) {

            $totalrecs = count($nquery);

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

            $this->db->select('max(rema_reqno) as reqno');

            $this->db->from('rema_reqmaster');

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

    public function getStatusCount($srchcol = false){

        try{

            if($this->mattypeid)

            {

                $this->db->where('rema_mattypeid',$this->mattypeid);

            }

            $departmentid=!empty($this->input->post('departmentid'))?$this->input->post('departmentid'):'';

              $subdepid=!empty($this->input->post('subdepid'))?$this->input->post('subdepid'):'';

            //   if(!empty($subdepid)){

            //     $departmentid=$subdepid;

            //   }

            // if(!empty($departmentid)){

            //     $this->db->where('rema_reqfromdepid',$departmentid);

            // }

              if(ORGANIZATION_NAME=='KU' || ORGANIZATION_NAME=='PU'){
                  $check_parentid=array();
            if(!empty($departmentid)){
                  $check_parentid=$this->general->get_tbl_data('dept_depid,dept_parentdepid','dept_department',array('dept_depid'=>$departmentid),'dept_depname','ASC');

            }

            $subdeparray=array();

            if(!empty($check_parentid)){

                $parentdepid=!empty($check_parentid[0]->dept_parentdepid)?$check_parentid[0]->dept_parentdepid:'0';

                if($parentdepid=='0'){

                    $subdep_result=$this->general->get_tbl_data('dept_depid','dept_department',array('dept_parentdepid'=>$departmentid),'dept_depname','ASC');

                    if(!empty($subdep_result)){

                        foreach ($subdep_result as $ksd => $dep) {

                          $subdeparray[]=$dep->dept_depid;

                        }

                    }

                    // $subdeparray

                }

            }
                if(!empty($departmentid)){
                            if(!empty( $subdepid)){
                            $this->db->where('rm.rema_reqfromdepid',$subdepid);    
                            }else{
                                if(!empty($subdeparray)){
                                $this->db->where_in('rm.rema_reqfromdepid',$subdeparray);

                            }else{

                            $this->db->where('rm.rema_reqfromdepid',$departmentid);    

                            }
                            }
                   
                        }
              }
              else{
                 if(!empty($departmentid)){

                $this->db->where('rema_reqfromdepid',$departmentid);

                 }
              }

            $schoolid=!empty($this->input->post('schoolid'))?$this->input->post('schoolid'):'';

            if(!empty($schoolid)){

                 $this->db->where('rema_school',$schoolid);

            }

            $this->db->select("

                  SUM(CASE WHEN rema_approved='0' THEN 1 ELSE 0 END ) pending,

                  SUM(CASE WHEN rema_approved='1' THEN 1 ELSE 0 END ) approved,

                  SUM(CASE WHEN rema_approved='2' THEN 1 ELSE 0 END ) unapproved,

                  SUM(CASE WHEN rema_approved='3' THEN 1 ELSE 0 END ) cancel,

                  SUM(CASE WHEN rema_approved='4' THEN 1 ELSE 0 END ) verified 

               ");

            $this->db->from('rema_reqmaster rm');

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

      public function getStatusCount_kukl(){

        try{

        $frmDate = $this->input->post('frmdate');

        $toDate = $this->input->post('todate');

        $type = $this->input->post('othertype');

        $input_locationid= $this->input->post('locationid');

        $departmentid= $this->input->post('departmentid');

        // echo $departmentid;

        // die();

        if(!empty(($frmDate && $toDate)))

        {

            if(DEFAULT_DATEPICKER == 'NP'){

                $this->db->where('rm.rema_reqdatebs >=',$frmDate);

                $this->db->where('rm.rema_reqdatebs <=',$toDate);    

            }else{

                $this->db->where('rm.rema_reqdatead >=',$frmDate);

                $this->db->where('rm.rema_reqdatead <=',$toDate);

            }

        }

        if($this->location_ismain=='Y')

        {

            if($input_locationid)

            {

                $this->db->where('rm.rema_locationid',$input_locationid);

            }

        }

        else

        {

             $this->db->where('rm.rema_locationid',$this->locationid);

        }

        if(!empty($departmentid) && $departmentid!='false' )

        {

            $this->db->where('rm.rema_reqfromdepid',"$departmentid");

        }

        if($this->usergroup=='DM'){

            $this->db->where('rm.rema_postby',$this->userid);

        }              

        else if($this->usergroup=='SA'){

             $this->db->where('rm.rema_postby IS NOT NULL ');

        }

        else if($this->usergroup == 'SK' || $this->usergroup == 'SI'){   

            if(!empty($type)){

                if($type=='self'){

                    $this->db->group_start();

                    $this->db->where('rm.rema_postby',$this->userid);

                     $this->db->group_end();

                }

                else if($type=='others'){

                    $this->db->group_start();

                        $this->db->where('rm.rema_approved','4');

                        $this->db->or_where('rm.rema_approved','1');

                    $this->db->group_end();

                    $this->db->where('rm.rema_postby !=',$this->userid);

                }

                else

                {

                $this->db->group_start();

                    $this->db->where('rm.rema_approved','4');

                    $this->db->or_where('rm.rema_approved','1');

                    $this->db->or_where('rm.rema_postby',$this->userid);

                $this->db->group_end();

                }

            }        

            // if(!empty($db_depArray)){

            //    $this->db->where_in('rm.rema_reqfromdepid',$db_depArray);

            // }

        }  

        // else if($this->usergroup <> 'DS' && $this->usergroup <> 'DM'){

        //     $this->db->where('usma_userid',$this->userid);

        // }

        else if($this->usergroup == 'DS'){

            $depid=$this->departmentid;

            // print_r($depid)

            if(!empty($depid))

            {

                $db_depid=explode(',', $depid);

                $this->db->where_in('rema_reqfromdepid',$db_depid);

            }

            if(!empty($type)){

                if($type=='self'){

                   $this->db->where('rm.rema_postby',$this->userid);

                }

                else if($type=='others'){

                     $this->db->group_start();

                     $this->db->where('rm.rema_postby !=',$this->userid);

                     $this->db->where('rm.rema_reqto',$this->userid);

                      $this->db->group_end();

                }

                else

                {

                    $this->db->group_start();

                    $this->db->where('rm.rema_postby',$this->userid);

                    $this->db->or_where('rm.rema_reqto',$this->userid);

                    $this->db->group_end();

                }

            }

        }

         else if($this->usergroup == 'BM'){

            if(!empty($type)){

                if($type=='self'){

                   $this->db->where('rm.rema_postby',$this->userid);

                }

                else if($type=='others'){

                     $this->db->where('rm.rema_postby !=',$this->userid);

                }

                else

                {

                    // $this->db->group_start();

                    // $this->db->where('rm.rema_postby',$this->userid);

                    $this->db->where('rm.rema_proceedissue != ','');

                      // $this->db->group_end();

                }

            }

        }

        else if($this->usergroup == 'IT'){

            if($type=='self'){

                $this->db->where('rm.rema_postby',$this->userid);

            }

            else if($type=='others'){

                $this->db->group_start();

                    $this->db->where('rm.rema_approved','4');

                    $this->db->or_where('rm.rema_approved','1');

                $this->db->group_end();

                $this->db->where('rm.rema_postby !=',$this->userid);

                $this->db->where('rm.rema_itstatus is not null', null, false);

            }

            else

            {

                $this->db->group_start();

                    $this->db->where('rm.rema_approved','4');

                    $this->db->or_where('rm.rema_approved','1');

                $this->db->group_end();

                $this->db->where('rm.rema_itstatus is not null', null, false);

                $this->db->or_group_start();

                 if(!empty(($frmDate && $toDate)))

                    {

                        if(DEFAULT_DATEPICKER == 'NP'){

                            $this->db->where('rm.rema_reqdatebs >=',$frmDate);

                            $this->db->where('rm.rema_reqdatebs <=',$toDate);    

                        }else{

                            $this->db->where('rm.rema_reqdatead >=',$frmDate);

                            $this->db->where('rm.rema_reqdatead <=',$toDate);

                        }

                    }

                     if($this->location_ismain=='Y')

                        {

                        if($input_locationid)

                        {

                            $this->db->where('rm.rema_locationid',$input_locationid);

                        }

                    }

                    else

                    {

                         $this->db->where('rm.rema_locationid',$this->locationid);

                    }

                 $this->db->where('rm.rema_postby',$this->userid);

                 $this->db->group_end();

            }

        }

        else {

        }

        // or condition start

        if(!empty($this->userdesignation) && $this->usergroup!='DM' )

        {

            // $this->db->where("find_in_set($this->userdesignation, rm.rema_reqtodesignation)");   

            if($type=='all' || $type=='others'){

                  $this->db->or_group_start();

        if(!empty(($frmDate && $toDate)))

        {

            if(DEFAULT_DATEPICKER == 'NP'){

                $this->db->where('rm.rema_reqdatebs >=',$frmDate);

                $this->db->where('rm.rema_reqdatebs <=',$toDate);    

            }else{

                $this->db->where('rm.rema_reqdatead >=',$frmDate);

                $this->db->where('rm.rema_reqdatead <=',$toDate);

            }

        }

         if($this->location_ismain=='Y')

            {

            if($input_locationid)

            {

                $this->db->where('rm.rema_locationid',$input_locationid);

            }

        }

        else

        {

             $this->db->where('rm.rema_locationid',$this->locationid);

        }

            $this->db->group_start();

            $this->db->where("

                        rema_reqtodesignation  LIKE '".$this->userdesignation.",%' OR 

                        rema_reqtodesignation  LIKE '%,".$this->userdesignation.",%' OR

                        rema_reqtodesignation  LIKE '%,".$this->userdesignation."' OR 

                        rema_reqtodesignation  ='".$this->userdesignation."'

                        OR rema_reqtodesignation  LIKE '".$this->userdesignation.",%' ");

            $this->db->group_end();

              $this->db->group_end();

            }

        }

 $this->db->where('rema_isdep IS NOT NULL');

        $this->db->select("

              SUM(CASE WHEN rema_approved='0' THEN 1 ELSE 0 END ) pending,

              SUM(CASE WHEN rema_approved='1' THEN 1 ELSE 0 END ) approved,

              SUM(CASE WHEN rema_approved='2' THEN 1 ELSE 0 END ) unapproved,

              SUM(CASE WHEN rema_approved='3' THEN 1 ELSE 0 END ) cancel,

              SUM(CASE WHEN rema_approved='4' THEN 1 ELSE 0 END ) verified 

           ");

            $this->db->from('rema_reqmaster rm');

            // if($srchcol){

            //     $this->db->where($srchcol);

            // }

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

    public function getRemCount($srchcol = false){

        try{

            if($this->mattypeid)

            {

                $this->db->where('rm.rema_mattypeid',$this->mattypeid);

            }

             $departmentid=!empty($this->input->post('departmentid'))?$this->input->post('departmentid'):'';

              $subdepid=!empty($this->input->post('subdepid'))?$this->input->post('subdepid'):'';

              if(!empty($subdepid)){

                $departmentid=$subdepid;

              }

            if(!empty($departmentid)){

                $this->db->where('rema_reqfromdepid',$departmentid);

            }

             $schoolid=!empty($this->input->post('schoolid'))?$this->input->post('schoolid'):'';

            if(!empty($schoolid)){

                 $this->db->where('rema_school',$schoolid);

            }

            $this->db->select("COUNT('*') as cntissue");

            $this->db->from('rema_reqmaster rm');

            $this->db->join('rede_reqdetail rd','rd.rede_reqmasterid=rm.rema_reqmasterid','LEFT');

            $this->db->where('rd.rede_remqty >',0);

            //$this->db->where('rema_locationid',$this->locationid);

            if($srchcol){

                $this->db->where($srchcol);

            }

            $query = $this->db->get();

            // echo $this->db->last_query();

            // die();

            if($query->num_rows() > 0){

                return $query->result();

            }

            return false;

        }catch(Exception $e){

            throw $e;

        }

    }

    public function getRemCount_kulk(){

        try{

               $frmDate = $this->input->post('frmdate');

        $toDate = $this->input->post('todate');

        $type = $this->input->post('othertype');

        $input_locationid= $this->input->post('locationid');

        $departmentid= $this->input->post('departmentid');

        if(!empty(($frmDate && $toDate)))

        {

            if(DEFAULT_DATEPICKER == 'NP'){

                $this->db->where('rm.rema_reqdatebs >=',$frmDate);

                $this->db->where('rm.rema_reqdatebs <=',$toDate);    

            }else{

                $this->db->where('rm.rema_reqdatead >=',$frmDate);

                $this->db->where('rm.rema_reqdatead <=',$toDate);

            }

        }

        if($this->location_ismain=='Y')

        {

            if($input_locationid)

            {

                $this->db->where('rm.rema_locationid',$input_locationid);

            }

        }

        else

        {

             $this->db->where('rm.rema_locationid',$this->locationid);

        }

       if(!empty($departmentid) && $departmentid!='false' )

        {

            $this->db->where('rm.rema_reqfromdepid',"$departmentid");

        }

        if($this->usergroup=='DM'){

            $this->db->where('rm.rema_postby',$this->userid);

        }              

        else if($this->usergroup=='SA'){

             $this->db->where(array('rm.rema_postby !='=>''));

        }

        else if($this->usergroup == 'SK' || $this->usergroup == 'SI'){   

            if(!empty($type)){

                if($type=='self'){

                    $this->db->group_start();

                    $this->db->where('rm.rema_postby',$this->userid);

                     $this->db->group_end();

                }

                else if($type=='others'){

                    $this->db->group_start();

                        $this->db->where('rm.rema_approved','4');

                        $this->db->or_where('rm.rema_approved','1');

                    $this->db->group_end();

                    $this->db->where('rm.rema_postby !=',$this->userid);

                }

                else

                {

                $this->db->group_start();

                    $this->db->where('rm.rema_approved','4');

                    $this->db->or_where('rm.rema_approved','1');

                    $this->db->or_where('rm.rema_postby',$this->userid);

                $this->db->group_end();

                }

            }        

            // if(!empty($db_depArray)){

            //    $this->db->where_in('rm.rema_reqfromdepid',$db_depArray);

            // }

        }  

        // else if($this->usergroup <> 'DS' && $this->usergroup <> 'DM'){

        //     $this->db->where('usma_userid',$this->userid);

        // }

        else if($this->usergroup == 'DS'){

            $depid=$this->departmentid;

            // print_r($depid)

            if(!empty($depid))

            {

                $db_depid=explode(',', $depid);

                $this->db->where_in('rema_reqfromdepid',$db_depid);

            }

            if(!empty($type)){

                if($type=='self'){

                   $this->db->where('rm.rema_postby',$this->userid);

                }

                else if($type=='others'){

                     $this->db->group_start();

                     $this->db->where('rm.rema_postby !=',$this->userid);

                     $this->db->where('rm.rema_reqto',$this->userid);

                      $this->db->group_end();

                }

                else

                {

                    $this->db->group_start();

                    $this->db->where('rm.rema_postby',$this->userid);

                    $this->db->or_where('rm.rema_reqto',$this->userid);

                    $this->db->group_end();

                }

            }

        }

         else if($this->usergroup == 'BM'){

            if(!empty($type)){

                if($type=='self'){

                   $this->db->where('rm.rema_postby',$this->userid);

                }

                else if($type=='others'){

                     $this->db->where('rm.rema_postby !=',$this->userid);

                }

                else

                {

                    // $this->db->group_start();

                    // $this->db->where('rm.rema_postby',$this->userid);

                    $this->db->where('rm.rema_proceedissue != ','');

                      // $this->db->group_end();

                }

            }

        }

        else if($this->usergroup == 'IT'){

            if($type=='self'){

                $this->db->where('rm.rema_postby',$this->userid);

            }

            else if($type=='others'){

                $this->db->group_start();

                    $this->db->where('rm.rema_approved','4');

                    $this->db->or_where('rm.rema_approved','1');

                $this->db->group_end();

                $this->db->where('rm.rema_postby !=',$this->userid);

                $this->db->where('rm.rema_itstatus is not null', null, false);

            }

            else

            {

                $this->db->group_start();

                    $this->db->where('rm.rema_approved','4');

                    $this->db->or_where('rm.rema_approved','1');

                $this->db->group_end();

                $this->db->where('rm.rema_itstatus is not null', null, false);

                $this->db->or_group_start();

                 if(!empty(($frmDate && $toDate)))

                    {

                        if(DEFAULT_DATEPICKER == 'NP'){

                            $this->db->where('rm.rema_reqdatebs >=',$frmDate);

                            $this->db->where('rm.rema_reqdatebs <=',$toDate);    

                        }else{

                            $this->db->where('rm.rema_reqdatead >=',$frmDate);

                            $this->db->where('rm.rema_reqdatead <=',$toDate);

                        }

                    }

                     if($this->location_ismain=='Y')

                        {

                        if($input_locationid)

                        {

                            $this->db->where('rm.rema_locationid',$input_locationid);

                        }

                    }

                    else

                    {

                         $this->db->where('rm.rema_locationid',$this->locationid);

                    }

                 $this->db->where('rm.rema_postby',$this->userid);

                 $this->db->group_end();

            }

        }

        else {

        }

        // or condition start

        if(!empty($this->userdesignation) && $this->usergroup!='DM' )

        {

            // $this->db->where("find_in_set($this->userdesignation, rm.rema_reqtodesignation)");   

            if($type=='all' || $type=='others'){

                  $this->db->or_group_start();

        if(!empty(($frmDate && $toDate)))

        {

            if(DEFAULT_DATEPICKER == 'NP'){

                $this->db->where('rm.rema_reqdatebs >=',$frmDate);

                $this->db->where('rm.rema_reqdatebs <=',$toDate);    

            }else{

                $this->db->where('rm.rema_reqdatead >=',$frmDate);

                $this->db->where('rm.rema_reqdatead <=',$toDate);

            }

        }

         if($this->location_ismain=='Y')

            {

            if($input_locationid)

            {

                $this->db->where('rm.rema_locationid',$input_locationid);

            }

        }

        else

        {

             $this->db->where('rm.rema_locationid',$this->locationid);

        }

            $this->db->group_start();

            $this->db->where("

                        rema_reqtodesignation  LIKE '".$this->userdesignation.",%' OR 

                        rema_reqtodesignation  LIKE '%,".$this->userdesignation.",%' OR

                        rema_reqtodesignation  LIKE '%,".$this->userdesignation."' OR 

                        rema_reqtodesignation  ='".$this->userdesignation."'

                        OR rema_reqtodesignation  LIKE '".$this->userdesignation.",%' ");

            $this->db->group_end();

              $this->db->group_end();

            }

        }

 $this->db->where('rema_isdep <>',' ');

            $this->db->select("COUNT('*') as cntissue");

            $this->db->from('rema_reqmaster rm');

            $this->db->join('rede_reqdetail rd','rd.rede_reqmasterid=rm.rema_reqmasterid','LEFT');

            $this->db->where('rd.rede_remqty >',0);

            $query = $this->db->get();

            // echo $this->db->last_query();

            // die();

            if($query->num_rows() > 0){

                return $query->result();

            }

            return false;

        }catch(Exception $e){

            throw $e;

        }

    }

    public function get_requisition_details_list($cond = false)

    {

        $frmDate=$this->input->get('frmDate');

        $toDate=$this->input->get('toDate');

        $mattype=$this->input->get('mattype');

        $get = $_GET;

        foreach ($get as $key => $value) {

            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));

        }

        if(!empty($get['sSearch_1'])){

            $this->db->where("lower(rema_reqdatead) like  '%".$get['sSearch_1']."%'  ");

        }

        if(!empty($get['sSearch_2'])){

            $this->db->where("lower(rema_reqdatebs) like  '%".$get['sSearch_2']."%'  ");

        }

        if(!empty($get['sSearch_3'])){

            $this->db->where("lower(rema_reqno) like  '%".$get['sSearch_3']."%'  ");

        }

        if(!empty($get['sSearch_4'])){

            $this->db->where("lower(itli_itemcode) like  '%".$get['sSearch_4']."%'  ");

        }

        if(!empty($get['sSearch_5'])){

            $this->db->where("lower(itli_itemname) like  '%".$get['sSearch_5']."%'  ");

        }

         if(!empty($get['sSearch_6'])){

            $this->db->where("lower(itli_itemnamenp) like  '%".$get['sSearch_6']."%'  ");

        }

        if(!empty($get['sSearch_7'])){

            $this->db->where("lower(rema_fyear) like  '%".$get['sSearch_7']."%'  ");

        }

          if(!empty($get['sSearch_8'])){

            $this->db->where("lower(rede_qty) like  '%".$get['sSearch_8']."%'  ");

        }

        if(!empty($get['sSearch_10'])){

            $this->db->where("lower(rede_remqty) like  '%".$get['sSearch_10']."%'  ");

        }

        if($cond) {

          $this->db->where($cond);

        }

         $input_locationid= !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');

          if($this->location_ismain=='Y')

          {

            if($input_locationid)

            {

                $this->db->where('rm.rema_locationid',$input_locationid);

            }

        }

        else

        {

             $this->db->where('rm.rema_locationid',$this->locationid);

        }

        if(!empty(($frmDate && $toDate)))

        {

            if(DEFAULT_DATEPICKER == 'NP'){

                $this->db->where('rm.rema_reqdatebs >=',$frmDate);

                $this->db->where('rm.rema_reqdatebs <=',$toDate);    

            }else{

                $this->db->where('rm.rema_reqdatead >=',$frmDate);

                $this->db->where('rm.rema_reqdatead <=',$toDate);

            }

        }

       $mattype = !empty($get['mattype'])?$get['mattype']:$this->input->post('mattype');

            // echo $this->mattypeid;

            if($this->mattypeid){    

               $mattype= $this->mattypeid;

            }

         if(!empty($mattype)){

                    $this->db->where('rm.rema_mattypeid',$mattype);

                }

        $resltrpt=$this->db->select("COUNT(*) as cnt")

                    ->from('rede_reqdetail rd')

                    ->join('rema_reqmaster rm','rm.rema_reqmasterid=rd.rede_reqmasterid','LEFT')

                    ->join('itli_itemslist eq','eq.itli_itemlistid = rd.rede_itemsid','LEFT')

                    ->join('dept_department dp','dp.dept_depid=rm.rema_reqfromdepid','left')

                    ->join('unit_unit u','u.unit_unitid = eq.itli_unitid','LEFT')

                    ->join('eqty_equipmenttype t','t.eqty_equipmenttypeid = rm.rema_reqtodepid','LEFT')

                    ->get()->row();

        //echo $this->db->last_query();die(); 

        $totalfilteredrecs=($resltrpt->cnt); 

        $order_by = 'rema_reqdatebs';

        $order = 'desc';

        if($this->input->get('sSortDir_0'))

        {

                $order = $this->input->get('sSortDir_0');

        }

        $where='';

       if($this->input->get('iSortCol_0')==1)

            $order_by = 'rema_reqno';

        else if($this->input->get('iSortCol_0')==2)

            $order_by = 'rema_reqdatead';

        else if($this->input->get('iSortCol_0')==3)

            $order_by = 'rema_reqdatebs';

        // else if($this->input->get('iSortCol_0')==2)

        //     if(DEFAULT_DATEPICKER=='NP')

        //     {

        //         $order_by = 'rema_reqdatebs';

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

            $order_by = 'rema_fyear';

        else if($this->input->get('iSortCol_0')==8)

            $order_by = 'rede_qty';

        else if($this->input->get('iSortCol_0')==10)

            $order_by = 'rede_remqty';

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

            $this->db->where("lower(rema_reqdatead) like  '%".$get['sSearch_1']."%'  ");

        }

        if(!empty($get['sSearch_2'])){

            $this->db->where("lower(rema_reqdatebs) like  '%".$get['sSearch_2']."%'  ");

        }

        if(!empty($get['sSearch_3'])){

            $this->db->where("lower(rema_reqno) like  '%".$get['sSearch_3']."%'  ");

        }

        if(!empty($get['sSearch_4'])){

            $this->db->where("lower(itli_itemcode) like  '%".$get['sSearch_4']."%'  ");

        }

        if(!empty($get['sSearch_5'])){

            $this->db->where("lower(itli_itemname) like  '%".$get['sSearch_5']."%'  ");

        }

         if(!empty($get['sSearch_6'])){

            $this->db->where("lower(itli_itemnamenp) like  '%".$get['sSearch_6']."%'  ");

        }

        if(!empty($get['sSearch_7'])){

            $this->db->where("lower(rema_fyear) like  '%".$get['sSearch_7']."%'  ");

        }

          if(!empty($get['sSearch_8'])){

            $this->db->where("lower(rede_qty) like  '%".$get['sSearch_8']."%'  ");

        }

        if(!empty($get['sSearch_10'])){

            $this->db->where("lower(rede_remqty) like  '%".$get['sSearch_10']."%'  ");

        }

        $input_locationid= !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');

            // echo $this->mattypeid;

            if($this->mattypeid){    

               $mattype= $this->mattypeid;

            }

         if(!empty($mattype)){

                    $this->db->where('rm.rema_mattypeid',$mattype);

                }

        if(!empty(($frmDate && $toDate)))

        {

            if(DEFAULT_DATEPICKER == 'NP'){

                $this->db->where('rm.rema_reqdatebs >=',$frmDate);

                $this->db->where('rm.rema_reqdatebs <=',$toDate);    

            }else{

                $this->db->where('rm.rema_reqdatead >=',$frmDate);

                $this->db->where('rm.rema_reqdatead <=',$toDate);

            }

        }

        if($cond) {

          $this->db->where($cond);

        }

        if($this->location_ismain=='Y')

        {

            if($input_locationid)

            {

                $this->db->where('rm.rema_locationid',$input_locationid);

            }

        }

        else

        {

            $this->db->where('rm.rema_locationid',$this->locationid);

        }

        $this->db->select('rd.rede_reqdetailid,rd.rede_remarks,rd.rede_remqty,rd.rede_qty,rm.rema_reqno,rm.rema_reqdatead,rm.rema_reqdatebs,rm.rema_username,rm.rema_fyear,rm.rema_reqby,it.itli_itemname,it.itli_itemnamenp,it.itli_itemcode,dp.dept_depname,u.unit_unitname');

        $this->db->from('rede_reqdetail rd');

        $this->db->join('rema_reqmaster rm','rm.rema_reqmasterid=rd.rede_reqmasterid','LEFT','LEFT');

        $this->db->join('dept_department dp','dp.dept_depid=rm.rema_reqfromdepid','left');

        $this->db->join('eqty_equipmenttype t','t.eqty_equipmenttypeid = rm.rema_reqtodepid','LEFT');

        $this->db->join('itli_itemslist it','it.itli_itemlistid = rd.rede_itemsid','LEFT');

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

         if (!empty($_GET['iDisplayLength']) &&  !empty($nquery) && is_array($nquery) && count($nquery) > 0 ) {

            $totalrecs = count($nquery);

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

    public function get_demand_analysis_list($cond = false)

    {

        $get = $_GET;

        foreach ($get as $key => $value) {

            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));

        }

        $whr='';

        if(!empty($get['sSearch_0'])){

            $this->db->where("rema_reqmasterid like  '%".$get['sSearch_0']."%'  ");

        }

        if(!empty($get['sSearch_1'])){

             $whr.=" AND itli_itemcode like  '%".$get['sSearch_1']."%'";

        }

        if(!empty($get['sSearch_2'])){

              $whr.=" AND itli_itemname like  '%".$get['sSearch_2']."%' OR itli_itemnamenp like  '%".$get['sSearch_2']."%' ";

        }

          if($cond) {

          $this->db->where($cond);

        }

        $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');

        $toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');

        $input_locationid= !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');

         $location_inp=$this->locationid;

         $status=!empty($get['status'])?$get['status']:'';

         // echo $status;

         // die();

        $cond= $cond1 = $cond3= $cond4=  $cond5='';

        if($status=='pending'){

            $cond .= " AND rm.rema_approved = '0'";

        }

        else if($status=='approved'){

              $cond .= " AND rm.rema_approved = '1'";

        } 

        else{

              $cond .= " AND rm.rema_approved IN('1','2') ";

        }

        if($this->location_ismain=='Y')

        {

            if($input_locationid)

            {

                $location_inp=$input_locationid;

                $cond .=" AND rm.rema_locationid = $location_inp";

                // $this->db->where('rm.mtm.trma_locationid',$input_locationid);

            }

        }

        else{

             $location_inp=$this->locationid;

              $cond .=" AND rm.rema_locationid = $location_inp";

        }

        $sql = "SELECT

                COUNT(*) AS cnt

            FROM

                (

                            SELECT

                                il.itli_itemlistid,

                                il.itli_itemcode,

                                il.itli_itemname,

                               count('*') as cnt,

                                sum(rd.rede_remqty) demandqty,

                                (SELECT IFNULL(SUM(md.trde_issueqty),0) FROM xw_trde_transactiondetail md LEFT JOIN xw_trma_transactionmain mt   on md.trde_trmaid =mt.trma_trmaid

  WHERE il.itli_itemlistid=md.trde_itemsid AND mt.trma_received=1 AND md.trde_locationid=".$location_inp." AND mt.trma_fromdepartmentid=".$this->storeid." ) as stockqty

                            FROM

                                xw_rede_reqdetail rd

                            INNER JOIN xw_rema_reqmaster rm ON rm.rema_reqmasterid = rd.rede_reqmasterid

                            INNER JOIN xw_itli_itemslist il ON il.itli_itemlistid = rd.rede_itemsid

                            WHERE

                               rm.rema_status = 'N'

                            AND rm.rema_received <> 2

                            AND rm.rema_isdep <> '' AND rm.rema_reqdatebs BETWEEN '$frmDate' AND '$toDate'  $cond

                            GROUP BY

                                il.itli_itemlistid,

                                il.itli_itemcode,

                                il.itli_itemname) X";

        $query=$this->db->query($sql);

        // echo $this->db->last_query();

        if($query->num_rows() > 0) 

        {

            $data=$query->row();     

            $totalfilteredrecs=  $data->cnt;       

        } 

        $order_by = 'il.itli_itemname';

        $order = 'ASC';

        if($this->input->get('sSortDir_0'))

        {

                $order = $this->input->get('sSortDir_0');

        }

        $where='';

        if($this->input->get('iSortCol_0')==3)

            $order_by = 'itli_itemcode';

        else if($this->input->get('iSortCol_0')==4)

            $order_by = 'itli_itemname';

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

             $whr.=" AND itli_itemcode like  '%".$get['sSearch_1']."%'";

        }

        if(!empty($get['sSearch_2'])){

              $whr.=" AND itli_itemname like  '%".$get['sSearch_2']."%' OR itli_itemnamenp like  '%".$get['sSearch_2']."%' ";

        }

        if($limit && $offset){

            $limit_to  = "LIMIT $limit, $offset";

        }else{

            $limit_to = "LIMIT $limit";

        }

        $sql1 =" SELECT il.itli_itemlistid,

                                il.itli_itemcode,

                                il.itli_itemname,

                               count('*') as cnt,

                                sum(rd.rede_remqty) demandqty,

                                (SELECT IFNULL(SUM(md.trde_issueqty),0) FROM xw_trde_transactiondetail md LEFT JOIN xw_trma_transactionmain mt   on md.trde_trmaid =mt.trma_trmaid

                            WHERE il.itli_itemlistid=md.trde_itemsid AND mt.trma_received=1 AND md.trde_locationid=".$location_inp." AND mt.trma_fromdepartmentid=".$this->storeid." ) as stockqty

                            FROM

                                xw_rede_reqdetail rd

                            INNER JOIN xw_rema_reqmaster rm ON rm.rema_reqmasterid = rd.rede_reqmasterid

                            INNER JOIN xw_itli_itemslist il ON il.itli_itemlistid = rd.rede_itemsid

                            WHERE

                               rm.rema_status = 'N'

                            AND rm.rema_received <> 2

                            AND rm.rema_isdep <> '' AND rm.rema_reqdatebs BETWEEN '$frmDate' AND '$toDate'  $cond

                            GROUP BY

                                il.itli_itemlistid,

                                il.itli_itemcode,

                                il.itli_itemname

        ORDER BY

            $order_by $order  $limit_to";
      
        $nquery=$this->db->query($sql1);

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

        //echo $this->db->last_query();die();

      return $ndata;

    }

    public function get_requisition_data($srchcol = false){

        try{

            $this->db->select('rm.*, rd.rede_reqdetailid, rd.rede_reqmasterid, rd.rede_unit,rd.rede_unitprice,rd.rede_totalamt, rd.rede_qty, rd.rede_remarks, rd.rede_code, rd.rede_itemsid, rd.rede_itcomment, rd.rede_itrecommend, rd.rede_budgetheadid, rd.rede_catid, rede_isbudgetavl, il.itli_itemcode,il.itli_purchaserate, il.itli_itemname,il.itli_itemnamenp, il.itli_itemlistid, ut.unit_unitname, dt.dept_depname as fromdepname');

            $this->db->from('rema_reqmaster rm');

            $this->db->join('rede_reqdetail rd','rd.rede_reqmasterid = rm.rema_reqmasterid','left');

            $this->db->join('itli_itemslist il','il.itli_itemlistid = rd.rede_itemsid','left');

            $this->db->join('unit_unit ut','ut.unit_unitid = il.itli_unitid','left');

            $this->db->join('dept_department dt','dt.dept_depid=rm.rema_reqfromdepid','LEFT');

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

        $this->db->select("rm.*,dt.dept_depname as fromdepname,et.eqty_equipmenttype as todepname,(SELECT  ett.eqty_equipmenttype  FROM xw_eqty_equipmenttype ett WHERE ett.eqty_equipmenttypeid=rm.rema_reqfromdepid AND rm.rema_isdep='N') fromdep_transfer,l.loca_name as locationname");

        $this->db->from('rema_reqmaster rm');

        $this->db->join('dept_department dt','dt.dept_depid=rm.rema_reqfromdepid','LEFT');

        $this->db->join('eqty_equipmenttype et','et.eqty_equipmenttypeid=rm.rema_reqtodepid','LEFT');

        $this->db->join('loca_location l','l.loca_locationid=rm.rema_locationid','LEFT');

        if($srchcol)

            {

            $this->db->where($srchcol); 

            }

            $query = $this->db->get();

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

        $additional_select="";
        
        if (ORGANIZATION_NAME == 'KUKL') {
            $budget_rows = " , abe.api_usable_budget as budg_availableamt, (case when block_amount > 0 then 'Y' else 'N' END) budget_status";
        }else{
            // $budget_rows = ' , bg.budg_availableamt, (case when budg_availableamt > purd_totalamt then "Y" else "N" END) budget_status';
            $budget_rows ='';
        }

        $this->db->select("it.itli_materialtypeid,it.itli_itemcode, it.itli_itemname,it.itli_itemnamenp, ti.teit_itemid, ti.teit_itemname, rd.rede_recommendqty,rd.rede_remarks, rd.rede_totalamt,it.itli_reorderlevel,it.itli_maxlimit ,it.itli_itemlistid, itli_purchaserate,rd.*,rd.rede_unitprice, rd.rede_itemsid, rd.rede_qty,rd.rede_remqty, rd.rede_proceedissue, rd.rede_proceedpurchase, rd.rede_proceedtype, rd.rede_itrecommend, rd.rede_reqdetailid, rd.rede_itcomment, ut.unit_unitname, rd.rede_qtyinstock,(select SUM(mtd.trde_issueqty) from xw_trde_transactiondetail mtd, xw_trma_transactionmain  mtm WHERE  mtm.trma_trmaid=mtd.trde_trmaid AND mtd.trde_itemsid=it.itli_itemlistid AND mtm.trma_received='1' AND mtd.trde_status='O' AND mtd.trde_locationid='$this->locationid' $search_storeid ) cur_stock_qty,
            l.loca_name as locationname,
            (SELECT pr.purd_estimatetotal FROM xw_purd_purchasereqdetail pr WHERE pr.purd_reqdetailid = rd.rede_reqdetailid ) as total_estimate_amount $budget_rows");

        $this->db->from('rede_reqdetail rd');

        $this->db->join('rema_reqmaster rm','rm.rema_reqmasterid=rd.rede_reqmasterid','LEFT');

        // $this->db->join('itli_itemslist it',"it.itli_itemlistid = rd.rede_itemsid and (rede_istempitem is NULL || rede_istempitem = 'N' ||  rede_istempitem = 'Y')",'left');
        $this->db->join('itli_itemslist it',"it.itli_itemlistid = rd.rede_itemsid",'left');
        $this->db->join('teit_tempitem ti',"ti.teit_tempitemid = rd.rede_itemsid and rede_istempitem = 'Y'",'left');

        $this->db->join('unit_unit ut','it.itli_unitid = ut.unit_unitid','left');
         if (ORGANIZATION_NAME == 'KUKL') {
        $this->db->join('api_budgetexpense abe','abe.req_detailid = rd.rede_reqdetailid AND abe.status = "O" ','left');
    }else{
        $this->db->join('budg_budgets bg','it.itli_catid = bg.budg_catid','left');
    }

        // $this->db->join('budg_budgets bg','it.itli_catid = bg.budg_catid','left');

        $this->db->join('loca_location l','l.loca_locationid=rm.rema_locationid','LEFT');

        $this->db->join('eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid=it.itli_catid','LEFT');

        if($srchcol){

            $this->db->where($srchcol);

        }
        $this->db->group_by('rede_itemsid, rede_remarks');

        $query = $this->db->get();

        // echo $this->db->last_query();die;

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

                    'rema_approved'=>$status,

                    'rema_modifydatead'=>CURDATE_EN,

                    'rema_unappreasonbs'=>CURDATE_NP,

                    'rema_unappreasonad'=> $unappresondatead,

                    'rema_modifytime'=>date('H:i:s'),

                    'rema_modifyip'=>$this->general->get_real_ipaddr(),

                    'rema_modifymac'=>$this->general->get_Mac_Address()

            );

        $this->db->update('rema_reqmaster',$postdata,array('rema_reqmasterid'=>$masterid));

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

    public function stock_requisition_change_status($status =false)

    { 

        $masterid = $this->input->post('masterid');

        $unappreson = $this->input->post('rema_unapprovedreason');

        $canreson = $this->input->post('cancel_reason');

        $approved_status = $this->input->post('approve_status');

        // print_r($approved_status);die;

        $action_log_userid = '';

        $approved_datead = '';

        $approved_datebs = '';

        $approved_id = 0;

        $approved_by = '';

        $verified_datebs = '';

        $verified_datead = '';

        $verified_time = '';

        $verified_by = '';

        if($approved_status == '1' || $status == '1'){

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

            $action_log_userid = $approved_id;

        }

        if($approved_status == '4'){

            $verified_datebs = CURDATE_EN;

            $verified_datead = CURDATE_NP;

            $verified_time = $this->curtime;

            $verified_by = $this->userid;

            $action_log_userid = $verified_by;

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

        $this->db->trans_begin();

        if($approved_status == '1' || $status == '1'){

            $postdata = array(

                    'rema_approveddatead' => $approved_datead,

                    'rema_approveddatebs' => $approved_datebs,

                    'rema_approved'=>$status,

                    'rema_modifydatead'=>CURDATE_EN,

                    'rema_modifydatebs'=> CURDATE_NP,

                    'rema_modifytime'=>date('H:i:s'),

                    'rema_modifyip'=>$this->general->get_real_ipaddr(),

                    'rema_modifymac'=>$this->general->get_Mac_Address(),

                    'rema_approvedby'=> $approved_by,

                    'rema_approvedid' => $approved_id,

            );

        }else{

            $postdata = array(

                    'rema_approveddatead' => $approved_datead,

                    'rema_approveddatebs' => $approved_datebs,

                    'rema_unapprovedreason'=>$unappreson,

                    'rema_reasoncancel'=> $canreson,

                    'rema_approved'=>$status,

                    'rema_modifydatead'=>CURDATE_EN,

                    'rema_unappreasonad'=>$unappresondatead,

                    'rema_rsncanceldatead'=>$canresondatead,

                    'rema_unappreasonbs'=>$unappresondatebs,

                    'rema_modifydatebs'=> CURDATE_NP,

                    'rema_rsncanceldatebs'=>$canresondatebs,

                    'rema_modifytime'=>date('H:i:s'),

                    'rema_modifyip'=>$this->general->get_real_ipaddr(),

                    'rema_modifymac'=>$this->general->get_Mac_Address(),

                    'rema_approvedby'=> $approved_by,

                    'rema_approvedid' => $approved_id,

                    'rema_verifieddatead' => $verified_datead,

                    'rema_verifieddatebs' => $verified_datebs,

                    'rema_verifiedtime' => $verified_time,

                    'rema_verifiedby' => $verified_by,
                    
                    'rema_proceedissue' => '1'

            );

        }

        $has_it_items = $this->input->post('check_it_dep');

        // if demand has IT items

        if($has_it_items == '1'):

            $itStatusArray = array(

                'rema_itstatus' => '1',

            );  

            if($itStatusArray){

                $this->db->where('rema_reqmasterid',$masterid);

                $this->db->update('rema_reqmaster',$itStatusArray);

                $this->general->saveActionLog('rema_reqmaster', $masterid, $this->userid, '1','rema_itstatus'); 

            }

        endif;

        //echo"<pre>";print_r($postdata);die;

       // $this->general->save_log($this->table,'dist_distributorid',$id,$postdata,'Update');

        $this->general->save_log('rema_reqmaster','rema_reqmasterid',$masterid,$postdata,'Update');

        $this->db->update('rema_reqmaster',$postdata,array('rema_reqmasterid'=>$masterid));

        $this->general->saveActionLog('rema_reqmaster', $masterid, $action_log_userid, $status, 'rema_approved'); 

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE){

            $this->db->trans_rollback();

            return false;

        }

        else{

            $this->db->trans_commit();

            return $masterid;

        }

    }

    public function request_for_operation()
    {
        $masterid = $this->input->post('masterid');
        $request_to = $this->input->post('request_to');
        $operation = $this->input->post('operation');

        $action_log_userid = '';

        $approved_datead = '';

        $approved_datebs = '';

        $approved_id = 0;

        $approved_by = '';

        if(defined('APPROVEBY_TYPE') && APPROVEBY_TYPE == 'USER'){

            $approved_id = $this->userid;

            $approved_by = $this->username;

        }else{

            $approved_id = (defined('APPROVER_USERID'))?APPROVER_USERID:'';

            $approved_by = (defined('APPROVER_USERNAME'))?APPROVER_USERNAME:'';

        }
        $action_log_userid = $approved_id;

        if ($operation == 'issue') {

            $approved_datead = CURDATE_EN;
            $approved_datebs = CURDATE_NP;

            $postdata = array(

                    'rema_approveddatead' => $approved_datead,

                    'rema_approveddatebs' => $approved_datebs,

                    'rema_approved'=> 1,

                    'rema_modifydatead'=>CURDATE_EN,

                    'rema_modifydatebs'=> CURDATE_NP,

                    'rema_modifytime'=>date('H:i:s'),

                    'rema_modifyip'=>$this->general->get_real_ipaddr(),

                    'rema_modifymac'=>$this->general->get_Mac_Address(),

                    'rema_approvedby'=> $approved_by,

                    'rema_approvedid' => $approved_id,

                    'rema_verifieddatead' => $approved_datead,

                    'rema_verifieddatebs' => $approved_datebs,

                    'rema_verifiedtime' => date('H:i:s'),

                    'rema_verifiedby' =>  $approved_id,
                    
                    'rema_proceedissue' => '1',

                    'rema_reqto' => $request_to,

                    'rema_operation' => $operation,

            );
        }else{
                $postdata = array(
                    
                    'rema_modifydatead'=>CURDATE_EN,

                    'rema_modifydatebs'=> CURDATE_NP,

                    'rema_modifytime'=>date('H:i:s'),

                    'rema_modifyby'=>$approved_id,

                    'rema_modifyip'=>$this->general->get_real_ipaddr(),

                    'rema_modifymac'=>$this->general->get_Mac_Address(),

                    'rema_reqto' => $request_to,

                    'rema_operation' => $operation,

            );
        }

        $this->db->trans_begin();

        $this->general->save_log('rema_reqmaster','rema_reqmasterid',$masterid,$postdata,'Update');

        $this->db->update('rema_reqmaster',$postdata,array('rema_reqmasterid'=>$masterid));

        $this->general->saveActionLog('rema_reqmaster', $masterid, $action_log_userid, $operation, 'rema_operation',$request_to); 
        if ($operation == 'issue') {
        $this->general->saveActionLog('rema_reqmaster', $masterid, $action_log_userid, '1', 'rema_approved'); 
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE){

            $this->db->trans_rollback();

            return false;

        }

        else{

            $this->db->trans_commit();

            return $masterid;

        }
    }

    public function get_department_wise_data()

    {

        $get = $_GET;

        foreach ($get as $key => $value) {

            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));

        }

        $whr='';

        if(!empty($get['sSearch_1'])){

            $whr .=" AND  d.dept_depname like  '%".$get['sSearch_1']."%' "; 

        }

        $store_id = !empty($get['store_id'])?$get['store_id']:0;

        $fyear = !empty($get['fiscal_year'])?$get['fiscal_year']:CUR_FISCALYEAR;

        $apstatus=!empty($get['appstatus'])?$get['appstatus']:4;

        $appstatus =!empty($get['appstatus'])?$get['appstatus']:4;

        $status=4;

        if($appstatus!='4')

        {

            if($appstatus==5)

            {

                $status ='0';

            }else{

                $status =$appstatus;

            }

        }

        // $locationid = !empty($get['locationid'])?$get['locationid']:$this->session->userdata(LOCATION_ID);

        // if($locationid)

        // {

        //     $whr .=" AND locationid= $locationid"; 

        // }

        $locationid= !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');

          if($this->location_ismain=='Y')

          {

            if($locationid)

            {

                 $whr .=" AND locationid= $locationid";

            }

            }

            else

            {

                 $whr .=" AND locationid= $this->locationid";

            }

        if($fyear)

        {

            $whr .=" AND fiscalyrs= '".$fyear."'"; 

        }

        if($store_id)

        {

            $whr .=" AND reqdep= ".$store_id."";    

        }

        if($apstatus!=4)

        {  

            if($apstatus==5)

            {

                $whr .=" AND appstatus='0'";

            }else{

                $whr .=" AND appstatus=".$apstatus."";

            }

        }

        $sql ="SELECT

                COUNT(*) AS cnt from

                (

                SELECT

                    mdr.depid,

                    d.dept_depname

                FROM

                    xw_vw_monthwise_dep_requisition mdr

                LEFT JOIN xw_dept_department d ON d.dept_depid = mdr.depid

               where rema_isdep='Y' AND depid IS NOT NULL  $whr

                GROUP BY 

                depid 

                ) as k";

                    // echo $sql;

                    // die();

        $query=$this->db->query($sql);

        //echo $this->db->last_query();die();

        if($query->num_rows() > 0) 

        {

            $data=$query->row();     

            $totalfilteredrecs=  $data->cnt;       

        }

        $order_by = 'itli_itemname';

        $order = 'asc';

        $where='';

        if($this->input->get('iSortCol_0')==1)

            $order_by = 'd.dept_depname';

        else if($this->input->get('iSortCol_0')==2)

            $order_by = 'itli_itemname';           

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

        //   if(!empty($get['sSearch_1'])){

        //     $whr .=" AND  d.dept_depname like  '%".$get['sSearch_1']."%' "; 

        // }

        // if(!empty($get['sSearch_2'])){

        //       $whr .=" AND itli_itemname like  '%".$get['sSearch_2']."%'  "; 

        // }

        $sql1 ="SELECT

                mdr.depid,mdr.fiscalyrs,mdr.locationid,mdr.mnth,mdr.reqdep,mdr.appstatus,

                d.dept_depname,mdr.yrs,

                    month_dep_requisition ('$fyear', 4, depid,'Y',$status,$store_id,$locationid) mdr4,

                    month_dep_requisition ('$fyear', 5, depid,'Y',$status,$store_id,$locationid) mdr5,

                    month_dep_requisition ('$fyear', 6, depid,'Y',$status,$store_id,$locationid) mdr6,

                    month_dep_requisition ('$fyear', 7, depid,'Y',$status,$store_id,$locationid) mdr7,

                    month_dep_requisition ('$fyear', 8, depid,'Y',$status,$store_id,$locationid) mdr8,

                    month_dep_requisition ('$fyear', 9, depid,'Y',$status,$store_id,$locationid) mdr9,

                    month_dep_requisition ('$fyear', 10, depid,'Y',$status,$store_id,$locationid) mdr10,

                    month_dep_requisition ('$fyear', 11, depid,'Y',$status,$store_id,$locationid) mdr11,

                    month_dep_requisition ('$fyear', 12, depid,'Y',$status,$store_id,$locationid) mdr12,

                    month_dep_requisition ('$fyear', 1, depid,'Y',$status,$store_id,$locationid) mdr1,

                    month_dep_requisition ('$fyear', 2, depid,'Y',$status,$store_id,$locationid) mdr2,

                    month_dep_requisition ('$fyear', 3, depid,'Y',$status,$store_id,$locationid) mdr3

            FROM

                xw_vw_monthwise_dep_requisition mdr

            LEFT JOIN xw_dept_department d ON d.dept_depid = mdr.depid

            where rema_isdep='Y'  AND depid IS NOT NULL 

            $whr

            GROUP BY 

            depid LIMIT $limit OFFSET $offset";

        $nquery=$this->db->query($sql1); 

        // echo $this->db->last_query();die();

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

        //echo $this->db->last_query();die();

       return $ndata;

    }

    public function get_requisition_data_department_wise($srch=false,$srchn=false)

    {   

        $id = $this->input->post('id');

        $fiscalyear = $this->input->post('fiscal_year');

        //$store_id = $this->input->post('store_id');

        $locationid = $this->input->post('location');

        $month = $this->input->post('month');

        $store_id = !empty($this->input->post('store_id'))? $this->input->post('store_id'):'0';

        $appstatus = !empty($this->input->post('appstatus'))?$this->input->post('appstatus'):'4';

        // if($appstatus)

        // {

        //     $srch=array('appstatus'=>$appstatus);

        // }

        // if($store_id)

        // {

        //     $srchn=array('reqdep'=>$store_id);

        // }

        $this->db->select('*');

        $this->db->from('vw_monthwise_dep_requisition'); 

       // if($locationid)

       //  {

       //      $this->db->where('locationid',$locationid);

       //  }

         if($this->location_ismain=='Y')

          {

            if($locationid)

            {

                  $this->db->where('locationid',$locationid);

            }

            }

            else

            {

                 $this->db->where('locationid',$this->locationid);

            }

        if($appstatus!='4')

        {

            $this->db->where(array('appstatus'=>$appstatus));

        }

        if(!empty($store_id))

        {

            $this->db->where(array('reqdep'=>$store_id));

        }

        if($id)

        {

            $this->db->where('depid',$id);

        }

        if($month)

        {

            $this->db->where('mnth',$month);

        }

        if($fiscalyear)

        {

            $this->db->where('fiscalyrs',$fiscalyear);

        }

        $this->db->where(array('rema_isdep'=>'Y'));

            // $nsql="rema_reqdatebs LIKE '%".$year."%'";

            // $this->db->where($nsql);

        $query = $this->db->get();

        // echo $this->db->last_query();die;

        if($query->num_rows() > 0){

            $result = $query->result();

            return $result;

        }

        return false;

    }

    public function get_details_requisition($srchcol)

    {

        $this->db->select('rd.*,it.itli_itemcode,it.itli_itemname,it.itli_itemnamenp,ut.unit_unitname,rm.rema_reqdatebs,rm.rema_reqby,rm.rema_approvedby,rm.rema_fyear');

        $this->db->from('rede_reqdetail rd'); 

        $this->db->join('rema_reqmaster rm','rm.rema_reqmasterid = rd.rede_reqmasterid','left');

        $this->db->join('itli_itemslist it','it.itli_itemlistid = rd.rede_itemsid','left');

        $this->db->join('unit_unit ut','it.itli_unitid = ut.unit_unitid','left');

        if($srchcol){

            $this->db->where($srchcol);

        }

        $this->db->where('rede_isdelete', 'N');

        $query = $this->db->get();

        //echo $this->db->last_query();die;

        if($query->num_rows() > 0){

            $result = $query->result();

            return $result;

        }

        return false;

    }

    public function get_all_reqby($srstinl=false,$limit=false,$offset=false,$order_by=false,$order=false,$groupby=false)

    {

        $srchtxt= $this->input->post('srchtext');

        $this->db->select('*');

        $this->db->from('rema_reqmaster');
        $this->db->where('rema_locationid',$this->locationid);

        $this->db->group_by('rema_reqby');

        if($srstinl)

        {

            $this->db->where($srstinl);

        }

        if($srchtxt)

        {

            $this->db->where("rema_reqby like  '%".$srchtxt."%'  ");

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

        $this->db->set_dbprefix('xw_');

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

     public function get_req_no_list($srchcol = false, $order_by = false, $order = false){

        $subqry="(SELECT GROUP_CONCAT(pure_purchasereqid) from xw_pure_purchaserequisition pr WHERE pr.pure_reqmasterid =rm.rema_reqmasterid) as purchasereqid ";

        $this->db->select("rm.rema_reqmasterid, rm.rema_reqno, rm.rema_reqdatebs, rm.rema_reqdatead, rm.rema_manualno, rm.rema_reqfromdepid, d.dept_depname,rm.rema_reqby,rm.rema_approved, $subqry");

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

    public function update_recommend_qty($items_id, $recommend_qty, $rema_reqmasterid){

        $this->db->trans_begin();

        foreach($items_id as $key=>$item){

            $itemArray = array(

                'rede_recommendqty' =>$recommend_qty[$key]

            );

            $this->db->where('rede_reqmasterid',$rema_reqmasterid);

            $this->db->where('rede_itemsid',$items_id[$key]);

            $this->db->update('rede_reqdetail',$itemArray);

        }

        $recommendArray = array(

            'rema_recommendstatus' => 'R',

            'rema_recommendby' => $this->userid,

            'rema_recommenddatead'=>CURDATE_EN,

            'rema_recommenddatebs'=>CURDATE_NP,

            'rema_recommendtime'=>$this->curtime,

            'rema_recommendmac'=>$this->mac,

            'rema_recommendip'=>$this->ip,

        );  

        if($recommendArray){

            $this->db->where('rema_reqmasterid',$rema_reqmasterid);

            $this->db->update('rema_reqmaster',$recommendArray);

            $this->general->saveActionLog('rema_reqmaster', $rema_reqmasterid, $this->userid, 'R','rema_recommendstatus'); 

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

    public function verify_recommend_qty($items_id, $recommend_qty, $rema_reqmasterid, $recommendation_status){

        $this->db->trans_begin();

        if($recommendation_status == 'A'){

            if(!empty($items_id)){

                foreach($items_id as $key=>$item){

                    $itemArray = array(

                        'rede_qty' =>$recommend_qty[$key],

                        'rede_remqty' =>$recommend_qty[$key]

                    );

                    $this->db->where('rede_reqmasterid',$rema_reqmasterid);

                    $this->db->where('rede_itemsid',$items_id[$key]);

                    $this->db->update('rede_reqdetail',$itemArray);

                }  

            }

        }

        $recommendArray = array(

            'rema_recommendstatus' => $recommendation_status,

        );

        if($recommendArray){

            $this->db->where('rema_reqmasterid',$rema_reqmasterid);

            $this->db->update('rema_reqmaster',$recommendArray);

            $this->general->saveActionLog('rema_reqmaster', $rema_reqmasterid, $this->userid, $recommendation_status,'rema_recommendstatus'); 

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

    public function proceed_to_procurement(){

        $items_id = $this->input->post('itemlist');

        $itemcode = $this->input->post('itemcode');

        $itemname = $this->input->post('itemname');

        $unitname = $this->input->post('unitname');

        $qty = $this->input->post('qty');

        $remqty = $this->input->post('remqty');

        $unitprice = $this->input->post('unitprice');

        $totalamt = $this->input->post('totalamt');

        $reqdetailid = $this->input->post('reqdetailid');

        $itemtypeid = $this->input->post('itemtypeid'); 

        $stockqty = $this->input->post('stockqty');

        $rema_reqmasterid = $this->input->post('masterid');

        $rema_reqby = $this->input->post('rema_reqby');

        $rema_fyear = $this->input->post('rema_fyear');

        $rema_reqno = $this->input->post('rema_reqno');

        $proctype = $this->input->post('proctype');

        $requsition_sno = $this->general->getLastNo('pure_reqno','pure_purchaserequisition',array('pure_fyear'=>$rema_fyear,'pure_locationid'=>$this->locationid));
        if(!empty($requsition_sno)){
        $requsitionno = $requsition_sno+1;    
        }
        else{
           $requsitionno = 1; 
        }
        
        // echo "<pre>";

        // print_r($this->input->post());

        // die();

        $this->db->trans_begin();

        $pureArray = array(

            'pure_reqdatead' => CURDATE_EN,

            'pure_reqdatebs' => CURDATE_NP,

            'pure_appliedby' => $this->username,

            'pure_requser' => $this->username,

            'pure_requestto' => 'Procurement',

            'pure_fyear' => $rema_fyear,

            'pure_storeid' => $this->storeid,

            'pure_reqno' => $requsitionno,

            'pure_reqmasterid' => $rema_reqmasterid,

            'pure_streqno' => $rema_reqno,

            'pure_isapproved' => 'N',

            'pure_itemstypeid' => '',

            'pure_proctype' => $proctype,

            'pure_postby' => $this->userid,

            'pure_postdatead' => CURDATE_EN,

            'pure_postdatebs' => CURDATE_NP,

            'pure_posttime' => $this->curtime,

            'pure_postip' => $this->ip,

            'pure_postmac' => $this->mac,

            'pure_orgid' => $this->orgid,

            'pure_locationid' => $this->locationid

        );

        if(!empty($pureArray)):

            $this->db->insert('pure_purchaserequisition',$pureArray);

            $insertid=$this->db->insert_id();

            $this->general->saveActionLog('pure_purchaserequisition', $insertid, $this->userid, 'N', 'pure_isapproved'); 

            foreach($items_id as $ikey=>$ival){

                $rate = !empty($unitprice[$ikey])?$unitprice[$ikey]:0;

                $total_qty = !empty($qty[$ikey])?$qty[$ikey]:0;

                $total_amt = (int)$rate*(int)$total_qty;

                $stock_qty = !empty($stockqty[$ikey])?$stockqty[$ikey]:0;

                if($stock_qty == 0 || empty($stock_qty)){

                    $prc_qty = !empty($remqty[$ikey])?$remqty[$ikey]:0;

                }else{

                    $prc_qty = (int)$total_qty - (int)$stock_qty;

                    if (ORGANIZATION_NAME == 'KUKL') {
                        $remaning_qty =  !empty($remqty[$ikey])?$remqty[$ikey]:0;
                        if ($remaning_qty > $stock_qty) {
                            $prc_qty = (int)$remaning_qty - (int)$stock_qty;
                            
                        }else{ 
                            $prc_qty = !empty($remqty[$ikey])?$remqty[$ikey]:0;
                        }
                    } 

                }

                $purdArray = array(

                    'purd_reqid' => $insertid,

                    'purd_reqdetailid' => !empty($reqdetailid[$ikey])?$reqdetailid[$ikey]:'',

                    'purd_itemsid' => !empty($items_id[$ikey])?$items_id[$ikey]:'',

                    'purd_unit' => !empty($unit_name[$ikey])?$unit_name[$ikey]:'',

                    'purd_stock' => '',

                    'purd_qty' => $prc_qty,

                    'purd_rate' => $rate,

                    'purd_budcode' => !empty($itemcode[$ikey])?$itemcode[$ikey]:'',

                    'purd_fyear' => $rema_fyear,

                    'purd_remqty' => !empty($remqty[$ikey])?$remqty[$ikey]:'',

                    'purd_totalamt' => $total_amt,

                    'purd_postby' => $this->userid,

                    'purd_postdatead' => CURDATE_EN,

                    'purd_postdatebs' => CURDATE_NP,

                    'purd_posttime' => $this->curtime,

                    'purd_postip' => $this->ip,

                    'purd_postmac' => $this->mac,

                    'purd_orgid' => $this->orgid,

                    'purd_locationid' => $this->locationid

                );

                $this->db->insert('purd_purchasereqdetail', $purdArray);

                // update requisition table

                $remaArray = array(

                    'rema_proceedpurchase' => 'Y'

                );

                $this->db->where('rema_reqmasterid',$rema_reqmasterid);

                $this->db->update('rema_reqmaster',$remaArray);

                $redeArray = array(

                    'rede_proceedpurchase' =>'Y',

                    'rede_proceedtype' =>'P'

                );

                $this->db->where('rede_reqmasterid',$rema_reqmasterid);

                $this->db->where('rede_itemsid',$items_id[$ikey]);

                $this->db->update('rede_reqdetail',$redeArray);

            }

        endif;

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE){

            $this->db->trans_rollback();

            return false;

        }

        else{

            $this->db->trans_commit();

            return $requsitionno;

        }

    }

    public function get_dept_by_user(){

        try{

            if($this->userdept):

                $user_dept_list = explode(',',$this->userdept);

            else:

                $user_dept_list = '';

            endif;

            $this->db->select('*');

            $this->db->from('dept_department');

            if($user_dept_list):

                $this->db->where_in('dept_depid',$user_dept_list);

            endif;

            $query = $this->db->get();

            if($query->num_rows() > 0){

                $result = $query->result();

                return $result;

            }

        }catch(Exception $e){

            throw $e;

        }

    }

    public function get_user_by_group_code($cond=false){

        try{

            $this->db->select('usma_username, usma_fullname, usma_usergroupid, usgr_usergroupcode, usma_departmentid, usma_userid, usma_appdesiid');

            $this->db->from('usma_usermain um');

            $this->db->join('usgr_usergroup ug','um.usma_usergroupid = ug.usgr_usergroupid','left');

            if (ORGANIZATION_NAME == 'KUKL') {
                
            $this->db->where_in('usgr_usergroupcode',['DS','PH']);
            }else{
            $this->db->where('usgr_usergroupcode','DS');

            }

            $this->db->where('usma_locationid',$this->locationid);
            if(!empty($cond)){
                $this->db->where($cond);
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

    public function get_approval_designation_list($var_id=false){

        try{

            $this->db->select('*');

            $this->db->from('desi_designation');

            if($var_id):

                $this->db->where_in('desi_designationid',$var_id);

            endif;

            $query = $this->db->get();

            if($query->num_rows() > 0){

                $result = $query->result();

                return $result;

            }

        }catch(Exception $e){

            throw $e;

        }

    }

    public function get_userlist_by_approval_designation_id($approval_designation_id_array=false){

        try{

            $this->db->select('usma_userid');

            $this->db->from('usma_usermain');

            if($approval_designation_id_array):

                $this->db->where_in('usma_desiid',$approval_designation_id_array);

            endif;

            $query = $this->db->get();

            if($query->num_rows() > 0){

                $result = $query->result();

                return $result;

            }

        }catch(Exception $e){

            throw $e;

        }

    }

    public function get_requisition_list_kukl($cond = false)

    {
        
        $usrdep=$this->userdept;

        $subquery1="(SELECT d.dept_depname FROM xw_dept_department d WHERE d.dept_depid=rm.rema_reqfromdepid)";

        // $this->db->select('et.eqty_equipmenttype');

        // $this->db->from('eqty_equipmenttype et');

        // $this->db->where('et.eqty_equipmenttypeid','rm.rema_reqtodepid',false);

        // $subquery2 = $this->db->get_compiled_select();

        $subquery2 = "(SELECT et.eqty_equipmenttype FROM xw_eqty_equipmenttype et WHERE et.eqty_equipmenttypeid=rm.rema_reqtodepid)";

        $subquery3="(SELECT  ett.eqty_equipmenttype  FROM xw_eqty_equipmenttype ett WHERE ett.eqty_equipmenttypeid=rm.rema_reqfromdepid AND rm.rema_isdep='N') fromdep_transfer";

        $get = $_GET;                          

        foreach ($get as $key => $value) {

            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));

        }

        // echo "<pre>";print_r($get); die();

        if(!empty($get['sSearch_0'])){

            $this->db->where("lower(rema_reqmasterid) like  '%".$get['sSearch_0']."%'  ");

        }

        if(!empty($get['sSearch_1'])){

            $this->db->where("lower(rema_reqdatead) like  '%".$get['sSearch_1']."%'  ");

        }

        if(!empty($get['sSearch_2'])){

            $this->db->where("lower(rema_reqdatebs) like  '%".$get['sSearch_2']."%'  ");

        }

        if(!empty($get['sSearch_3'])){

            $this->db->where("lower(rema_reqno) like  '%".$get['sSearch_3']."%'  ");

        }

        if(!empty($get['sSearch_4'])){

            $this->db->where("lower(d.dept_depname) like  '%".$get['sSearch_4']."%'  ");

        } 

        if(!empty($get['sSearch_5'])){

            $this->db->where("lower(eqty_equipmenttype) like  '%".$get['sSearch_5']."%'  ");

        } 

        if(!empty($get['sSearch_6'])){

            $this->db->where("lower(rema_username) like  '%".$get['sSearch_6']."%'  ");

        }

        if(!empty($get['sSearch_7'])){

            $this->db->where("lower(rema_isdep) like  '%".$get['sSearch_7']."%'  ");

        }

        if(!empty($get['sSearch_8'])){

            $this->db->where("lower(rema_reqby) like  '%".$get['sSearch_8']."%'  ");

        }

        if(!empty($get['sSearch_9'])){

            $this->db->where("lower(rema_approvedby) like  '%".$get['sSearch_9']."%'  ");

        }

        if(!empty($get['sSearch_10'])){

            $this->db->where("lower(rema_manualno) like  '%".$get['sSearch_10']."%'  ");

        }

        if(!empty($get['sSearch_12'])){

            $this->db->where("lower(rema_fyear) like  '%".$get['sSearch_12']."%'  ");

        }

        if($cond) {

            $this->db->where($cond);

        }

        $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');

        $toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');

        $type = !empty($get['type'])?$get['type']:$this->input->post('type');

        $apptype = !empty($get['apptype'])?$get['apptype']:$this->input->post('apptype');

        $input_locationid= !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');

        $departmentid= !empty($get['departmentid'])?$get['departmentid']:$this->input->post('departmentid');

        $fiscalyear = !empty($get['fiscalyear'])?$get['fiscalyear']:$this->input->post('fiscalyear');
        $srchtext = !empty($get['srchtext'])?$get['srchtext']:$this->input->post('srchtext');

        $color_codeclass=$this->getColorStatusCount_kukl();

        foreach ($color_codeclass as $key => $color) {

            if($apptype==$color->coco_statusname)

            {

                $approved=$color->coco_statusval;

            }

        }

        // if($apptype=='pending')

        // {

        //     $approved=0;

        // }

        // if($apptype=='approved')

        // {

        //     $approved=1;

        // }

        // if($apptype=='unapproved')

        // {

        //     $approved=2;

        // }

        // if($apptype=='cancel')

        // {

        //     $approved=3;

        // }

        // if($apptype=='verified')

        // {

        //     $approved=4;

        // }

        if($apptype=='cntissue'|| $apptype=='all')

        {

            $approved='';

        }   

        if(!empty(($frmDate && $toDate)))

        {

            if(DEFAULT_DATEPICKER == 'NP'){

                $this->db->where('rm.rema_reqdatebs >=',$frmDate);

                $this->db->where('rm.rema_reqdatebs <=',$toDate);    

            }else{

                $this->db->where('rm.rema_reqdatead >=',$frmDate);

                $this->db->where('rm.rema_reqdatead <=',$toDate);

            }

        }

        if($apptype!="cntissue" && $apptype!="all"){

            if(!empty($apptype))

            {

                $this->db->where('rm.rema_approved',"$approved");

            }

        }

        // if($fiscalyear)

        // {

        //     $this->db->where('rema_fyear',$fiscalyear);

        // }

        if($this->location_ismain=='Y')

        {

            if($input_locationid)

            {

                $this->db->where('rm.rema_locationid',$input_locationid);

            }

        }

        else

        {

             $this->db->where('rm.rema_locationid',$this->locationid);

        }

        if(!empty($departmentid))

        {

            $this->db->where('rm.rema_reqfromdepid',"$departmentid");

        }

        if(!empty($srchtext)){
            $this->db->where("rm.rema_reqno = $srchtext OR rm.rema_manualno =$srchtext");
        }

        if($this->usergroup=='DM'){

            $this->db->where('rm.rema_postby',$this->userid);

        }              

        else if($this->usergroup=='SA'){

             $this->db->where('rm.rema_postby IS NOT NULL');

        }

        else if($this->usergroup == 'SK' || $this->usergroup == 'SI'){   

            if(!empty($type)){

                if($type=='self'){

                    $this->db->group_start();

                    $this->db->where('rm.rema_postby',$this->userid);

                     $this->db->group_end();

                }

                else if($type=='others'){

                    $this->db->group_start();

                        $this->db->where('rm.rema_approved','4');

                        $this->db->or_where('rm.rema_approved','1');

                    $this->db->group_end();

                    $this->db->where('rm.rema_postby !=',$this->userid);

                }

                else

                {

                $this->db->group_start();

                    $this->db->where('rm.rema_approved','4');

                    $this->db->or_where('rm.rema_approved','1');

                    $this->db->or_where('rm.rema_postby',$this->userid);

                $this->db->group_end();

                }

            }        

            // if(!empty($db_depArray)){

            //    $this->db->where_in('rm.rema_reqfromdepid',$db_depArray);

            // }

        }  

        // else if($this->usergroup <> 'DS' && $this->usergroup <> 'DM'){

        //     $this->db->where('usma_userid',$this->userid);

        // }

        else if($this->usergroup == 'DS'){

            $depid=$this->departmentid;

            // print_r($depid)

            if(!empty($depid))

            {

                $db_depid=explode(',', $depid);

                $this->db->where_in('rema_reqfromdepid',$db_depid);

            }

            if(!empty($type)){

                if($type=='self'){

                   $this->db->where('rm.rema_postby',$this->userid);

                }

                else if($type=='others'){

                     $this->db->group_start();

                     $this->db->where('rm.rema_postby !=',$this->userid);

                     $this->db->where('rm.rema_reqto',$this->userid);

                      $this->db->group_end();

                }

                else

                {

                    $this->db->group_start();

                    $this->db->where('rm.rema_postby',$this->userid);

                    $this->db->or_where('rm.rema_reqto',$this->userid);

                    $this->db->group_end();

                }

            }

        }

         else if($this->usergroup == 'BM'){

            if(!empty($type)){

                if($type=='self'){

                   $this->db->where('rm.rema_postby',$this->userid);

                }

                else if($type=='others'){

                     $this->db->where('rm.rema_postby !=',$this->userid);

                }

                else

                {

                    // $this->db->group_start();

                    // $this->db->where('rm.rema_postby',$this->userid);
                    // Changed By Sujan Kunwar
                    $this->db->where('rm.rema_proceedissue IS NOT NULL');

                      // $this->db->group_end();

                }

            }

        }

        else if($this->usergroup == 'IT'){

            if($type=='self'){

                $this->db->where('rm.rema_postby',$this->userid);

            }

            else if($type=='others'){

                $this->db->group_start();

                    $this->db->where('rm.rema_approved','4');

                    $this->db->or_where('rm.rema_approved','1');

                $this->db->group_end();

                $this->db->where('rm.rema_postby !=',$this->userid);

                $this->db->where('rm.rema_itstatus is not null', null, false);

            }

            else

            {

                $this->db->group_start();

                    $this->db->where('rm.rema_approved','4');

                    $this->db->or_where('rm.rema_approved','1');

                $this->db->group_end();

                $this->db->where('rm.rema_itstatus is not null', null, false);

                $this->db->or_group_start();

                 if(!empty(($frmDate && $toDate)))

                    {

                        if(DEFAULT_DATEPICKER == 'NP'){

                            $this->db->where('rm.rema_reqdatebs >=',$frmDate);

                            $this->db->where('rm.rema_reqdatebs <=',$toDate);    

                        }else{

                            $this->db->where('rm.rema_reqdatead >=',$frmDate);

                            $this->db->where('rm.rema_reqdatead <=',$toDate);

                        }

                    }

                     if($this->location_ismain=='Y')

                        {

                        if($input_locationid)

                        {

                            $this->db->where('rm.rema_locationid',$input_locationid);

                        }

                    }

                    else

                    {

                         $this->db->where('rm.rema_locationid',$this->locationid);

                    }

                    if($apptype!="cntissue" && $apptype!="all"){

                        if(!empty($apptype))

                        {

                            $this->db->where('rm.rema_approved',"$approved");

                        }

                    }

                 $this->db->where('rm.rema_postby',$this->userid);

                 $this->db->group_end();

            }

        }

        else {

        }

        // or condition start

        if(!empty($this->userdesignation) && $this->usergroup!='DM' )

        {

            // $this->db->where("find_in_set($this->userdesignation, rm.rema_reqtodesignation)");   

            if($type=='all' || $type=='others'){

                  $this->db->or_group_start();

        if(!empty(($frmDate && $toDate)))

        {

            if(DEFAULT_DATEPICKER == 'NP'){

                $this->db->where('rm.rema_reqdatebs >=',$frmDate);

                $this->db->where('rm.rema_reqdatebs <=',$toDate);    

            }else{

                $this->db->where('rm.rema_reqdatead >=',$frmDate);

                $this->db->where('rm.rema_reqdatead <=',$toDate);

            }

        }

         if($this->location_ismain=='Y')

            {

            if($input_locationid)

            {

                $this->db->where('rm.rema_locationid',$input_locationid);

            }

        }

        else

        {

             $this->db->where('rm.rema_locationid',$this->locationid);

        }

         if($apptype!="cntissue" && $apptype!="all"){

            if(!empty($apptype))

            {

                $this->db->where('rm.rema_approved',"$approved");

            }

            else{

                 if($this->usergroup == 'SK' || $this->usergroup == 'SI'){ 

                    $this->db->group_start();

                    $this->db->where('rm.rema_approved','4');

                    $this->db->or_where('rm.rema_approved','1');

                    $this->db->group_end();

                }

            }

           }

            $this->db->group_start();

            $this->db->where("

                        rema_reqtodesignation  LIKE '".$this->userdesignation.",%' OR 

                        rema_reqtodesignation  LIKE '%,".$this->userdesignation.",%' OR

                        rema_reqtodesignation  LIKE '%,".$this->userdesignation."' OR 

                        rema_reqtodesignation  ='".$this->userdesignation."'

                        OR rema_reqtodesignation  LIKE '".$this->userdesignation.",%' ");

            $this->db->group_end();

              $this->db->group_end();

            }

        }

        $resltrpt=$this->db->select("COUNT(*) as cnt")

                        ->from('rema_reqmaster rm')

                        ->join('dept_department d','d.dept_depid=rm.rema_reqfromdepid','LEFT')

                        //->join('rede_reqdetail rd','rd.rede_reqmasterid=rm.rema_reqmasterid','LEFT')

                        ->join('eqty_equipmenttype et','et.eqty_equipmenttypeid=rm.rema_reqtodepid','LEFT')

                        // ->join('usma_usermain um',"find_in_set(um.usma_desiid, rm.rema_reqtodesignation)",'LEFT')

                        ->get()

                        ->row();

       // echo $this->db->last_query();

       // die();

        $totalfilteredrecs=$resltrpt->cnt; 

        $order_by = 'rema_reqmasterid';

        $order = 'desc';

        if($this->input->get('sSortDir_0'))
        {
            $order = $this->input->get('sSortDir_0');
        }

        if($this->input->get('iSortCol_0')==1)

            $order_by = 'rema_reqdatead';

        else if($this->input->get('iSortCol_0')==2)

            $order_by = 'rema_reqdatebs';

        else if($this->input->get('iSortCol_0')==3)

            $order_by = 'rema_reqno';

        else if($this->input->get('iSortCol_0')==4)

            $order_by = 'dept_depname';

        else if($this->input->get('iSortCol_0')==5)

            $order_by = 'eqty_equipmenttype';

        else if($this->input->get('iSortCol_0')==6)

            $order_by = 'rema_username';

        else if($this->input->get('iSortCol_0')==7)

            $order_by = 'rema_isdep';

        else if($this->input->get('iSortCol_0')==8)

            $order_by = 'rema_reqby';

         else if($this->input->get('iSortCol_0')==9)

            $order_by = 'rema_approvedby';

        else if($this->input->get('iSortCol_0')==10)

            $order_by = 'rema_manualno';

        else if($this->input->get('iSortCol_0')==12)

            $order_by = 'rema_fyear';

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

            $this->db->where("lower(rema_reqmasterid) like  '%".$get['sSearch_0']."%'  ");

        }

        if(!empty($get['sSearch_1'])){

            $this->db->where("lower(rema_reqdatead) like  '%".$get['sSearch_1']."%'  ");

        }

        if(!empty($get['sSearch_2'])){

            $this->db->where("lower(rema_reqdatebs) like  '%".$get['sSearch_2']."%'  ");

        }

        if(!empty($get['sSearch_3'])){

            $this->db->where("lower(rema_reqno) like  '%".$get['sSearch_3']."%'  ");

        }

        if(!empty($get['sSearch_4'])){

            $this->db->where("lower(d.dept_depname) like  '%".$get['sSearch_4']."%'  ");

        } 

        if(!empty($get['sSearch_5'])){

            $this->db->where("lower(eqty_equipmenttype) like  '%".$get['sSearch_5']."%'  ");

        } 

        if(!empty($get['sSearch_6'])){

            $this->db->where("lower(rema_username) like  '%".$get['sSearch_6']."%'  ");

        }

        if(!empty($get['sSearch_7'])){

            $this->db->where("lower(rema_isdep) like  '%".$get['sSearch_7']."%'  ");

        }

        if(!empty($get['sSearch_8'])){

            $this->db->where("lower(rema_reqby) like  '%".$get['sSearch_8']."%'  ");

        }

        if(!empty($get['sSearch_9'])){

            $this->db->where("lower(rema_approvedby) like  '%".$get['sSearch_9']."%'  ");

        }

        if(!empty($get['sSearch_12'])){

            $this->db->where("lower(rema_fyear) like  '%".$get['sSearch_12']."%'  ");

        }

        if(!empty($get['sSearch_10'])){

            $this->db->where("lower(rema_manualno) like  '%".$get['sSearch_10']."%'  ");

        }

        $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');

        $toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');

        $type = !empty($get['type'])?$get['type']:$this->input->post('type');

        $apptype = !empty($get['apptype'])?$get['apptype']:$this->input->post('apptype');

        $input_locationid= !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');

        $departmentid= !empty($get['departmentid'])?$get['departmentid']:$this->input->post('departmentid');

        $fiscalyear = !empty($get['fiscalyear'])?$get['fiscalyear']:$this->input->post('fiscalyear');
         $srchtext = !empty($get['srchtext'])?$get['srchtext']:$this->input->post('srchtext');

        $color_codeclass=$this->getColorStatusCount_kukl();

        foreach ($color_codeclass as $key => $color) {

            if($apptype==$color->coco_statusname)

            {

                $approved=$color->coco_statusval;

            }

        }

        // if($apptype=='pending')

        // {

        //     $approved=0;

        // }

        // if($apptype=='approved')

        // {

        //     $approved=1;

        // }

        // if($apptype=='unapproved')

        // {

        //     $approved=2;

        // }

        // if($apptype=='cancel')

        // {

        //     $approved=3;

        // }

        // if($apptype=='verified')

        // {

        //     $approved=4;

        // }

        if($apptype=='cntissue'|| $apptype=='all')

        {

            $approved='';

        }   

        if(!empty(($frmDate && $toDate)))

        {

            if(DEFAULT_DATEPICKER == 'NP'){

                $this->db->where('rm.rema_reqdatebs >=',$frmDate);

                $this->db->where('rm.rema_reqdatebs <=',$toDate);    

            }else{

                $this->db->where('rm.rema_reqdatead >=',$frmDate);

                $this->db->where('rm.rema_reqdatead <=',$toDate);

            }

        }

        if($apptype!="cntissue" && $apptype!="all"){

            if(!empty($apptype))

            {

                $this->db->where('rm.rema_approved',"$approved");

            }

        }

        // if($fiscalyear)

        // {

        //     $this->db->where('rema_fyear',$fiscalyear);

        // }

        if($this->location_ismain=='Y')

        {

            if($input_locationid)

            {

                $this->db->where('rm.rema_locationid',$input_locationid);

            }

        }

        else

        {

             $this->db->where('rm.rema_locationid',$this->locationid);

        }

        if(!empty($departmentid))

        {

            $this->db->where('rm.rema_reqfromdepid',"$departmentid");

        }

          if(!empty($srchtext)){
            $this->db->where("rm.rema_reqno = $srchtext OR rm.rema_manualno =$srchtext");
        }

        if($this->usergroup=='DM'){

            $this->db->where('rm.rema_postby',$this->userid);

        }              

        else if($this->usergroup=='SA'){

             $this->db->where('rm.rema_postby IS NOT NULL');

        }

        else if($this->usergroup == 'SK' || $this->usergroup == 'SI'){   

            if(!empty($type)){

                if($type=='self'){

                    $this->db->group_start();

                    $this->db->where('rm.rema_postby',$this->userid);

                     $this->db->group_end();

                }

                else if($type=='others'){

                    $this->db->group_start();

                        $this->db->where('rm.rema_approved','4');

                        $this->db->or_where('rm.rema_approved','1');

                    $this->db->group_end();

                    $this->db->where('rm.rema_postby !=',$this->userid);

                }

                else

                {

                $this->db->group_start();

                    $this->db->where('rm.rema_approved','4');

                    $this->db->or_where('rm.rema_approved','1');

                    $this->db->or_where('rm.rema_postby',$this->userid);

                $this->db->group_end();

                }

            }        

            // if(!empty($db_depArray)){

            //    $this->db->where_in('rm.rema_reqfromdepid',$db_depArray);

            // }

        }  

        // else if($this->usergroup <> 'DS' && $this->usergroup <> 'DM'){

        //     $this->db->where('usma_userid',$this->userid);

        // }

        else if($this->usergroup == 'DS'){

            $depid=$this->departmentid;

            // print_r($depid)

            if(!empty($depid))

            {

                $db_depid=explode(',', $depid);

                $this->db->where_in('rema_reqfromdepid',$db_depid);

            }

            if(!empty($type)){

                if($type=='self'){

                   $this->db->where('rm.rema_postby',$this->userid);

                }

                else if($type=='others'){

                     $this->db->group_start();

                     $this->db->where('rm.rema_postby !=',$this->userid);

                     $this->db->where('rm.rema_reqto',$this->userid);

                      $this->db->group_end();

                }

                else

                {

                    $this->db->group_start();

                    $this->db->where('rm.rema_postby',$this->userid);

                    $this->db->or_where('rm.rema_reqto',$this->userid);

                    $this->db->group_end();

                }

            }

        }

         else if($this->usergroup == 'BM'){

            if(!empty($type)){

                if($type=='self'){

                   $this->db->where('rm.rema_postby',$this->userid);

                }

                else if($type=='others'){

                     $this->db->where('rm.rema_postby !=',$this->userid);

                }

                else

                {

                    // $this->db->group_start();
                    // Sujan Kunwar
                    // $this->db->where('rm.rema_postby',$this->userid);

                    $this->db->where('rm.rema_proceedissue IS NOT NULL');
                    // $this->db->or_where('rm.rema_proceedissue IS NOT NULL');

                      // $this->db->group_end();

                }

            }

        }

        else if($this->usergroup == 'IT'){

            if($type=='self'){

                $this->db->where('rm.rema_postby',$this->userid);

            }

            else if($type=='others'){

                $this->db->group_start();

                    $this->db->where('rm.rema_approved','4');

                    $this->db->or_where('rm.rema_approved','1');

                $this->db->group_end();

                $this->db->where('rm.rema_postby !=',$this->userid);

                $this->db->where('rm.rema_itstatus is not null', null, false);

            }

            else

            {

                $this->db->group_start();

                    $this->db->where('rm.rema_approved','4');

                    $this->db->or_where('rm.rema_approved','1');

                $this->db->group_end();

                $this->db->where('rm.rema_itstatus is not null', null, false);

                $this->db->or_group_start();

                 if(!empty(($frmDate && $toDate)))

                    {

                        if(DEFAULT_DATEPICKER == 'NP'){

                            $this->db->where('rm.rema_reqdatebs >=',$frmDate);

                            $this->db->where('rm.rema_reqdatebs <=',$toDate);    

                        }else{

                            $this->db->where('rm.rema_reqdatead >=',$frmDate);

                            $this->db->where('rm.rema_reqdatead <=',$toDate);

                        }

                    }

                     if($this->location_ismain=='Y')

                        {

                        if($input_locationid)

                        {

                            $this->db->where('rm.rema_locationid',$input_locationid);

                        }

                    }

                    else

                    {

                         $this->db->where('rm.rema_locationid',$this->locationid);

                    }

                    if($apptype!="cntissue" && $apptype!="all"){

                        if(!empty($apptype))

                        {

                            $this->db->where('rm.rema_approved',"$approved");

                        }

                    }

                 $this->db->where('rm.rema_postby',$this->userid);

                 $this->db->group_end();

            }

        }

        else {

        }

        // or condition start

        if(!empty($this->userdesignation) && $this->usergroup!='DM' )

        {

            // $this->db->where("find_in_set($this->userdesignation, rm.rema_reqtodesignation)");   

            if($type=='all' || $type=='others'){

                  $this->db->or_group_start();

        if(!empty(($frmDate && $toDate)))

        {

            if(DEFAULT_DATEPICKER == 'NP'){

                $this->db->where('rm.rema_reqdatebs >=',$frmDate);

                $this->db->where('rm.rema_reqdatebs <=',$toDate);    

            }else{

                $this->db->where('rm.rema_reqdatead >=',$frmDate);

                $this->db->where('rm.rema_reqdatead <=',$toDate);

            }

        }

         if($this->location_ismain=='Y')

            {

            if($input_locationid)

            {

                $this->db->where('rm.rema_locationid',$input_locationid);

            }

        }

        else

        {

             $this->db->where('rm.rema_locationid',$this->locationid);

        }

         if($apptype!="cntissue" && $apptype!="all"){

            if(!empty($apptype))

            {

                $this->db->where('rm.rema_approved',"$approved");

            }

            else{

                 if($this->usergroup == 'SK' || $this->usergroup == 'SI'){ 

                    $this->db->group_start();

                    $this->db->where('rm.rema_approved','4');

                    $this->db->or_where('rm.rema_approved','1');

                    $this->db->group_end();

                }

            }

           }

            $this->db->group_start();

            $this->db->where("

                        rema_reqtodesignation  LIKE '".$this->userdesignation.",%' OR 

                        rema_reqtodesignation  LIKE '%,".$this->userdesignation.",%' OR

                        rema_reqtodesignation  LIKE '%,".$this->userdesignation."' OR 

                        rema_reqtodesignation  ='".$this->userdesignation."'

                        OR rema_reqtodesignation  LIKE '".$this->userdesignation.",%' ");

            $this->db->group_end();

              $this->db->group_end();

            }

        }

        // Store keeper and Store incharge can only view verified demand
        $prev_demandno="(SELECT CONCAT(rema_reqno,'@',rema_reqmasterid) as prev_demand FROM xw_rema_reqmaster rp where rm.rema_parentreqmasterid=rp.rema_reqmasterid) as prev_demandno";

        $cntitemQty="(SELECT COUNT(*) as cntitem from xw_rede_reqdetail rd WHERE rd.rede_remqty >0 AND rd.rede_reqmasterid=rm.rema_reqmasterid AND rd.rede_isdelete = 'N') as cntitem";

        $this->db->select("rm.*,$cntitemQty, ($subquery1) depfrom, ($subquery2) depto,  $subquery3,$prev_demandno ");

        $this->db->from('rema_reqmaster rm');

        $this->db->join('dept_department d','d.dept_depid=rm.rema_reqfromdepid','LEFT');

        //$this->db->join('rede_reqdetail rd','rd.rede_reqmasterid=rm.rema_reqmasterid','LEFT');

        $this->db->join('eqty_equipmenttype et','et.eqty_equipmenttypeid=rm.rema_reqtodepid','LEFT');

        // $this->db->join('usma_usermain um',"find_in_set(um.usma_desiid, rm.rema_reqtodesignation)",'LEFT');

        $this->db->where('rema_isdep IS NOT NULL');

        // if($this->usergroup <> 'DS' && $this->usergroup <> 'DM'):

        //     $this->db->where('usma_userid',$this->userid);

        // endif;

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

     public function get_requisition_list_ku($cond = false)

    {

        $get = $_GET;                          

        // echo "test";
        // die();
 
        foreach ($get as $key => $value) {

            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));

        }

         // echo "<pre>";print_r($get); die();

        if(!empty($get['sSearch_0'])){

            $this->db->where("rema_reqmasterid like  '%".$get['sSearch_0']."%'  ");

        }

        if(!empty($get['sSearch_1'])){

            $this->db->where("lower(rema_reqdatead) like  '%".$get['sSearch_1']."%'  ");

        }

        if(!empty($get['sSearch_2'])){

            $this->db->where("lower(rema_reqdatebs) like  '%".$get['sSearch_2']."%'  ");

        }

        if(!empty($get['sSearch_3'])){

            $this->db->where("lower(rema_reqno) like  '%".$get['sSearch_3']."%'  ");

        }

         if(!empty($get['sSearch_4'])){

            $this->db->where("lower(d.dept_depname) like  '%".$get['sSearch_4']."%'  ");

        } 

        if(!empty($get['sSearch_5'])){

            $this->db->where("lower(eqty_equipmenttype) like  '%".$get['sSearch_5']."%'  ");

        } 

        if(!empty($get['sSearch_6'])){

            $this->db->where("lower(rema_username) like  '%".$get['sSearch_6']."%'  ");

        }

        if(!empty($get['sSearch_7'])){

            $this->db->where("lower(rema_isdep) like  '%".$get['sSearch_7']."%'  ");

        }

         if(!empty($get['sSearch_8'])){

            $this->db->where("lower(rema_reqby) like  '%".$get['sSearch_8']."%'  ");

        }

         if(!empty($get['sSearch_9'])){

            $this->db->where("lower(rema_approvedby) like  '%".$get['sSearch_9']."%'  ");

        }

        if(!empty($get['sSearch_10'])){

            $this->db->where("lower(rema_manualno) like  '%".$get['sSearch_10']."%'  ");

        }

        if(!empty($get['sSearch_12'])){

            $this->db->where("lower(rema_fyear) like  '%".$get['sSearch_12']."%'  ");

        }

        if($cond) {

            $this->db->where($cond);

        }

            $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');

            $toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');

            $type = !empty($get['type'])?$get['type']:$this->input->post('type');

            $apptype = !empty($get['apptype'])?$get['apptype']:$this->input->post('apptype');

            $input_locationid= !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');

            $departmentid= !empty($get['departmentid'])?$get['departmentid']:$this->input->post('departmentid');

            $subdepid=!empty($get['subdepid'])?$get['subdepid']:$this->input->post('subdepid');
            $srchtext=!empty($get['srchtext'])?$get['srchtext']:'';

             $check_parentid=array();
            if(!empty($departmentid)){
                  $check_parentid=$this->general->get_tbl_data('dept_depid,dept_parentdepid','dept_department',array('dept_depid'=>$departmentid),'dept_depname','ASC');

            }

            $subdeparray=array();

            if(!empty($check_parentid)){

                $parentdepid=!empty($check_parentid[0]->dept_parentdepid)?$check_parentid[0]->dept_parentdepid:'0';

                if($parentdepid=='0'){

                    $subdep_result=$this->general->get_tbl_data('dept_depid','dept_department',array('dept_parentdepid'=>$departmentid),'dept_depname','ASC');

                    if(!empty($subdep_result)){

                        foreach ($subdep_result as $ksd => $dep) {

                          $subdeparray[]=$dep->dept_depid;

                        }

                    }

                    // $subdeparray

                }

            }

            // echo "<pre>";

            // print_r($subdeparray);

            // die();

            if(!empty( $subdepid)){

                $departmentid= $subdepid;

            }

            $fiscalyear = !empty($get['fiscalyear'])?$get['fiscalyear']:$this->input->post('fiscalyear');

            $mattype = !empty($get['mattype'])?$get['mattype']:$this->input->post('mattype');

            $schoolid = !empty($get['schoolid'])?$get['schoolid']:$this->input->post('schoolid');

            // echo $this->mattypeid;

            if($this->mattypeid){    

               $mattype= $this->mattypeid;

            }

            if($apptype=='pending')

            {

                $approved=0;

            }

            if($apptype=='approved')

            {

                $approved=1;

            }

            if($apptype=='unapproved')

            {

                $approved=2;

            }

            if($apptype=='cancel')

            {

                $approved=3;

            }

            if($apptype=='verified')

            {

                $approved=4;

            }

            if($apptype=='cntissue')

            {

                $approved='';

            }

        // $this->db->select('d.dept_depname');

        // $this->db->from('dept_department d');

        // $this->db->where('d.dept_depid','rm.rema_reqfromdepid',false);

        // $subquery1 = $this->db->get_compiled_select();

        $subquery1="(SELECT d.dept_depname FROM xw_dept_department d WHERE d.dept_depid=rm.rema_reqfromdepid)";

        // $this->db->select('et.eqty_equipmenttype');

        // $this->db->from('eqty_equipmenttype et');

        // $this->db->where('et.eqty_equipmenttypeid','rm.rema_reqtodepid',false);

        // $subquery2 = $this->db->get_compiled_select();

        $subquery2 = "(SELECT et.eqty_equipmenttype FROM xw_eqty_equipmenttype et WHERE et.eqty_equipmenttypeid=rm.rema_reqtodepid)";

        $subquery3="(SELECT  ett.eqty_equipmenttype  FROM xw_eqty_equipmenttype ett WHERE ett.eqty_equipmenttypeid=rm.rema_reqfromdepid AND rm.rema_isdep='N') fromdep_transfer";

        if(!empty(($frmDate && $toDate)))

        {

            if(DEFAULT_DATEPICKER == 'NP'){

                $this->db->where('rm.rema_reqdatebs >=',$frmDate);

                $this->db->where('rm.rema_reqdatebs <=',$toDate);    

            }else{

                $this->db->where('rm.rema_reqdatead >=',$frmDate);

                $this->db->where('rm.rema_reqdatead <=',$toDate);

            }

        }

        // if(!empty($type)){

        //     $this->db->where('rm.rema_isdep',$type);

        // }

          if(!empty($mattype)){

            $this->db->where('rm.rema_mattypeid',$mattype);

        }

        if($apptype!="cntissue"){

        if(!empty($apptype))

         {

            $this->db->where('rm.rema_approved',"$approved");

         }

        }

        if($this->location_ismain=='Y')

        {

            if($input_locationid)

            {

                $this->db->where('rm.rema_locationid',$input_locationid);

            }

        }

        else

        {

            $this->db->where('rm.rema_locationid',$this->locationid);

        }

   if(!empty($departmentid)){
            if(!empty( $subdepid)){
            $this->db->where('rm.rema_reqfromdepid',$subdepid);    
            }else{
                if(!empty($subdeparray)){
                $this->db->where_in('rm.rema_reqfromdepid',$subdeparray);

            }else{

            $this->db->where('rm.rema_reqfromdepid',$departmentid);    

            }
            }
   
        }

        if(!empty($srchtext)){
            $this->db->where('(rema_reqno='.$srchtext.' OR rema_manualno='.$srchtext.')');
        }

        if(!empty($schoolid)){

            $this->db->where('rm.rema_school', $schoolid);

        }       

        if($this->usergroup=='DM'):

              $this->db->where('rm.rema_postby',$this->userid);

        endif;

        $this->db->where('rema_isdep <>',' ');

        $resltrpt=$this->db->select("COUNT(*) as cnt")

                        ->from('rema_reqmaster rm')

                        ->join('dept_department d','d.dept_depid=rm.rema_reqfromdepid','LEFT')

                        //->join('rede_reqdetail rd','rd.rede_reqmasterid=rm.rema_reqmasterid','LEFT')

                        ->join('eqty_equipmenttype et','et.eqty_equipmenttypeid=rm.rema_reqtodepid','LEFT')

                        ->get()

                        ->row();

       // echo $this->db->last_query();

       // die();

        $totalfilteredrecs=$resltrpt->cnt; 

        $order_by = 'rema_reqmasterid';

        $order = 'desc';

        if($this->input->get('sSortDir_0'))

        {

                $order = $this->input->get('sSortDir_0');

        }

        $where='';

       if($this->input->get('iSortCol_0')==1)

            $order_by = 'rema_reqdatead';

        else if($this->input->get('iSortCol_0')==2)

            $order_by = 'rema_reqdatebs';

        else if($this->input->get('iSortCol_0')==3)

            $order_by = 'rema_reqno';

        else if($this->input->get('iSortCol_0')==3)

            $order_by = 'dept_depname';

        else if($this->input->get('iSortCol_0')==5)

            $order_by = 'eqty_equipmenttype';

        else if($this->input->get('iSortCol_0')==6)

            $order_by = 'rema_username';

        else if($this->input->get('iSortCol_0')==7)

            $order_by = 'rema_isdep';

        else if($this->input->get('iSortCol_0')==8)

            $order_by = 'rema_reqby';

         else if($this->input->get('iSortCol_0')==9)

            $order_by = 'rema_approvedby';

        else if($this->input->get('iSortCol_0')==10)

            $order_by = 'rema_manualno';

        else if($this->input->get('iSortCol_0')==12)

            $order_by = 'rema_fyear';
        else if($this->input->get('iSortCol_0')==14)

            $order_by = 'rema_reqdatebs';

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

            $this->db->where("lower(rema_reqmasterid) like  '%".$get['sSearch_0']."%'  ");

        }

        if(!empty($get['sSearch_1'])){

            $this->db->where("lower(rema_reqdatead) like  '%".$get['sSearch_1']."%'  ");

        }

        if(!empty($get['sSearch_2'])){

            $this->db->where("rema_reqdatebs like  '%".$get['sSearch_2']."%'  ");

        }

        if(!empty($get['sSearch_3'])){

            $this->db->where("rema_reqno like  '%".$get['sSearch_3']."%'  ");

        }

         if(!empty($get['sSearch_4'])){

            $this->db->where("d.dept_depname like  '%".$get['sSearch_4']."%'  ");

        } 

        if(!empty($get['sSearch_5'])){

            $this->db->where("eqty_equipmenttype like  '%".$get['sSearch_5']."%'  ");

        } 

        if(!empty($get['sSearch_6'])){

            $this->db->where("rema_username like  '%".$get['sSearch_6']."%'  ");

        }

        if(!empty($get['sSearch_7'])){

            $this->db->where("rema_isdep like  '%".$get['sSearch_7']."%'  ");

        }

         if(!empty($get['sSearch_8'])){

            $this->db->where("rema_reqby like  '%".$get['sSearch_8']."%'  ");

        }

         if(!empty($get['sSearch_9'])){

            $this->db->where("rema_approvedby like  '%".$get['sSearch_9']."%'  ");

        }

        if(!empty($get['sSearch_12'])){

            $this->db->where("rema_fyear like  '%".$get['sSearch_12']."%'  ");

        }

        if(!empty($get['sSearch_10'])){

            $this->db->where("rema_manualno like  '%".$get['sSearch_10']."%'  ");

        }

        $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');

        $toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');

        $type = !empty($get['type'])?$get['type']:$this->input->post('type');

        $apptype = !empty($get['apptype'])?$get['apptype']:$this->input->post('apptype');

         $srchtext=!empty($get['srchtext'])?$get['srchtext']:'';

        $input_locationid= !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');

        $fiscalyear = !empty($get['fiscalyear'])?$get['fiscalyear']:$this->input->post('fiscalyear');

            $mattype = !empty($get['mattype'])?$get['mattype']:$this->input->post('mattype');

         if($this->mattypeid){    

           $mattype= $this->mattypeid;

        }

         if(!empty($schoolid)){

            $this->db->where('rm.rema_school', $schoolid);

        }   

                if($apptype=='pending')

                {

                    $approved=0;

                }

                if($apptype=='approved')

                {

                    $approved=1;

                }

                if($apptype=='unapproved')

                {

                    $approved=2;

                }

                if($apptype=='cancel')

                {

                    $approved=3;

                }

                if($apptype=='verified')

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

                $this->db->where('rm.rema_reqdatebs >=',$frmDate);

                $this->db->where('rm.rema_reqdatebs <=',$toDate);    

            }else{

                $this->db->where('rm.rema_reqdatead >=',$frmDate);

                $this->db->where('rm.rema_reqdatead <=',$toDate);

            }

        }

        if($type){

            $this->db->where('rm.rema_isdep',$type);

        }

          if(!empty($mattype)){

            $this->db->where('rm.rema_mattypeid',$mattype);

        }

      if($apptype!="cntissue"){

        if(!empty($apptype))

         {

            $this->db->where('rm.rema_approved',"$approved");

         }

        }

        // if($fiscalyear)

        // {

        //     $this->db->where('rema_fyear',$fiscalyear);

        // }

        if($this->location_ismain=='Y')

        {

            if($input_locationid)

            {

                $this->db->where('rm.rema_locationid',$input_locationid);

            }

        }

        else

        {

             $this->db->where('rm.rema_locationid',$this->locationid);

        }

        if($this->usergroup=='DM'):

              $this->db->where('rm.rema_postby',$this->userid);

        endif;

        if(!empty($mattype)){

            $this->db->where('rm.rema_mattypeid',$mattype);

        }

         if(!empty($srchtext)){
            $this->db->where('(rema_reqno='.$srchtext.' OR rema_manualno='.$srchtext.')');
        }

         if(!empty( $subdepid)){

                $departmentid= $subdepid;

            }

         if(!empty($departmentid)){
            if(!empty( $subdepid)){
            $this->db->where('rm.rema_reqfromdepid',$subdepid);    
            }else{
                if(!empty($subdeparray)){
                $this->db->where_in('rm.rema_reqfromdepid',$subdeparray);

            }else{

            $this->db->where('rm.rema_reqfromdepid',$departmentid);    

            }
            }
   
        }

        $cntitemQty="(SELECT COUNT(*) as cntitem from xw_rede_reqdetail rd WHERE rd.rede_remqty >0 AND rd.rede_reqmasterid=rm.rema_reqmasterid AND rd.rede_isdelete = 'N') as cntitem";

        $this->db->select("rm.*,rm.rema_remarks,rm.rema_workplace,rm.rema_workdesc,mt.maty_material,$cntitemQty, ($subquery1) depfrom,dtfp.dept_depname deptparent,scf.loca_name as schoolname,  ($subquery2) depto,  $subquery3 ");

        $this->db->from('rema_reqmaster rm');

        $this->db->join('dept_department d','d.dept_depid=rm.rema_reqfromdepid','LEFT');
        $this->db->join('dept_department dtfp','dtfp.dept_depid=d.dept_parentdepid','LEFT');
        $this->db->join('loca_location scf','rm.rema_school=scf.loca_locationid','LEFT');
        $this->db->join('maty_materialtype mt','mt.maty_materialtypeid=rm.rema_mattypeid',"LEFT");

        $this->db->join('eqty_equipmenttype et','et.eqty_equipmenttypeid=rm.rema_reqtodepid','LEFT');
        
        $this->db->where('rema_isdep <>',' ');

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

        if (!empty($_GET['iDisplayLength']) &&  !empty($nquery) && is_array($nquery) && count($nquery) > 0 ) {

            $totalrecs = count($nquery);

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

    public function check_it_dep($srchcol){

        $this->db->select('il.itli_catid, il.itli_catid, e.eqca_isitdep');

        $this->db->from('rede_reqdetail rd');

        $this->db->join('itli_itemslist il','il.itli_itemlistid = rd.rede_itemsid');

        $this->db->join('eqca_equipmentcategory e','e.eqca_equipmentcategoryid = il.itli_catid');

        $this->db->where('eqca_isitdep','Y');

        // $this->db->where('rd.rede_itrecommend is null', null, false);

        if($srchcol){

            $this->db->where($srchcol);

        }

        $query = $this->db->get();

        // echo $this->db->last_query();

        // die();

        if($query->num_rows() > 0){

            $result = $query->num_rows();

            return $result;

        }

        return 0;

    }

    public function send_to_it_department_change_status(){

        try{

            $this->db->trans_begin();

            $rema_reqmasterid = $this->input->post('masterid');

            $itStatusArray = array(

                'rema_itstatus' => '1',

            );  

            if($itStatusArray){

                $this->db->where('rema_reqmasterid',$rema_reqmasterid);

                $this->db->update('rema_reqmaster',$itStatusArray);

                $this->general->saveActionLog('rema_reqmaster', $rema_reqmasterid, $this->userid, '1','rema_itstatus'); 

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

    public function proceed_to_account()

    {

        $reqmasterid=$this->input->post('req_masterid');

        $curdate_en=CURDATE_EN;

        $curdate_np=CURDATE_NP;

        $curtime=$this->curtime;

        $usrid=$this->userid;

        $mac=$this->mac;

        $ip=$this->ip;

        $chk_previous_capital_log=$this->check_previous_capital_log($reqmasterid);

        $reqdtl_list=$this->get_requisition_details_data(array('rd.rede_reqmasterid'=>$reqmasterid, 'rd.rede_isdelete' => 'N','it.itli_materialtypeid'=>'2'));

        if($chk_previous_capital_log){

             $capitalmasterArray=array(

                'calm_curstatus '=>'1',

                'calm_modifydatead'=>$curdate_en,

                'calm_modifydatebs'=>$curdate_np,

                'calm_modifytime '=>$curtime,

                'calm_modifyby '=>$usrid,

                'calm_modifymac'=>$mac,

                'calm_modifyip '=>$ip,

            );

             if(!empty($capitalmasterid)){

                $this->db->update('calm_capitallogmaster',$capitalmasterArray,array('calm_capitallogmasterid'=>$chk_previous_capital_log));

                $rowaffected=$this->db->affected_rows();

                if(!empty($rowaffected)){

                    return $rowaffected;

                }

                return false;

             }

        }

        else{

            if(!empty($reqmasterid)){

                $capitalmasterArray=array(

                'calm_reqmasterid'=>$reqmasterid, 

                'calm_curstatus '=>'1',

                'calm_postdatead'=>$curdate_en,

                'calm_postdatebs'=>$curdate_np,

                'calm_posttime '=>$curtime,

                'calm_postby '=>$usrid,

                'calm_postmac'=>$mac,

                'calm_postip '=>$this->ip,

                'calm_locationid'=>$this->locationid,

                'calm_orgid'=>$this->orgid

            );

            if(!empty($capitalmasterArray)){

                $this->db->insert('calm_capitallogmaster',$capitalmasterArray);

                $capitalmasterid=$this->db->insert_id();

                if(!empty($capitalmasterid)){

                    if(!empty($reqdtl_list)){

                        foreach ($reqdtl_list as $krl => $rqlst) {

                            $capitaldetailArray=array(

                            'cald_capitallogmasterid' =>$capitalmasterid,

                            'cald_itemcode' =>$rqlst->itli_itemcode,

                            'cald_itemid' =>$rqlst->itli_itemlistid,

                            'cald_itemname'=>$rqlst->itli_itemname,

                            'cald_itemnamenp'=>$rqlst->itli_itemnamenp,

                            'cald_qty' =>$rqlst->rede_qty,

                            'cald_returnqty'=>0,

                            'cald_curqty' =>$rqlst->rede_qty,

                            'cald_postdatead'=>$curdate_en,

                            'cald_postdatebs'=>$curdate_np,

                            'cald_posttime '=>$curtime,

                            'cald_postby '=>$usrid,

                            'cald_postmac'=>$mac,

                            'cald_postip '=>$ip,

                            'cald_locationid'=>$this->locationid,

                            'cald_orgid'=>$this->orgid

                        );

                        if(!empty($capitaldetailArray)){

                           $this->db->insert('cald_capitallogdetail',$capitaldetailArray);

                            $capitaldetailid=$this->db->insert_id();

                        }

                      }

                    }  

                }

            }

        }

        }

    }

    public function check_previous_capital_log($reqmasterid=false)

    {

        $this->db->select('calm_capitallogmasterid');

        $this->db->from('calm_capitallogmaster');

        $this->db->where('calm_reqmasterid',$reqmasterid);

        $query=$this->db->get();

        if($query->num_rows() > 0){

            $result = $query->row();

            if(!empty($result))

            {

                return $result->calm_capitallogmasterid;

            }

            return false;

        }

        return false;

    }

    public function submit_it_recommendation($items_id, $rede_itrecommend, $rede_itcomment, $rema_reqmasterid, $recommendation_status){

        $itemArray = array();

        $this->db->trans_begin();

        if(!empty($items_id)):

            foreach($items_id as $key=>$item){

                $itemArray = array(

                    'rede_itrecommend' =>$rede_itrecommend[$key],

                    'rede_itcomment' =>$rede_itcomment[$key]

                );

                $this->db->where('rede_reqmasterid',$rema_reqmasterid);

                $this->db->where('rede_itemsid',$items_id[$key]);

                $this->db->update('rede_reqdetail',$itemArray);

            }

        endif;

        $recommendArray = array(

            'rema_itstatus' => '2',

        );

        if($recommendArray){

            $this->db->where('rema_reqmasterid',$rema_reqmasterid);

            $this->db->update('rema_reqmaster',$recommendArray);

            $this->general->saveActionLog('rema_reqmaster', $rema_reqmasterid, $this->userid, $recommendation_status,'rema_itstatus'); 

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

 public function getColorStatusCount($srchcol = false){

     $con1='';

 if($srchcol){

    if($this->location_ismain=='Y'){

       $con1= $srchcol;

   }else{     

     $con1.= $srchcol;

     $con1.=" AND rema_locationid ='".$this->locationid."'";

 }

 }else{

     $con1='';

 }

$sql="SELECT * FROM

     xw_coco_colorcode cc

    LEFT JOIN (

     SELECT

         rema_approved,

         COUNT('*') AS statuscount

     FROM

         xw_rema_reqmaster rm

     ".$con1."

     GROUP BY

         rema_approved

    ) X ON X.rema_approved = cc.coco_statusval

    WHERE

     cc.coco_listname = 'req_demandsummary'

    AND cc.coco_statusval IS NOT NULL

    AND cc.coco_isactive = 'Y'";

         $query = $this->db->query($sql);

         // echo $this->db->last_query();

         // die();

         return $query->result();

    }

public function getColorStatusCount_kukl($srchcol = false){

  $con1='';

 if($srchcol){

    if($this->location_ismain=='Y'){

       $con1= $srchcol;

   }else{     

     $con1.= $srchcol;

     $con1.=" AND rema_locationid ='".$this->locationid."'";

 }

 }else{

     $con1='';

 }

$sql="SELECT * FROM

     xw_coco_colorcode cc

    LEFT JOIN (

     SELECT

         rema_approved,

         COUNT('*') AS statuscount

     FROM

         xw_rema_reqmaster rm

     ".$con1."

     GROUP BY

         rema_approved

    ) X ON X.rema_approved = cc.coco_statusval

    WHERE

     cc.coco_listname = 'req_demandsummary'

    AND cc.coco_statusval IS NOT NULL

    AND cc.coco_isactive = 'Y'";

         $query = $this->db->query($sql);

         // echo $this->db->last_query();

         // die();

         return $query->result();

    }

    public function get_user_list_for_report($reqno, $fyear, $status = false, $field = false){

        $sql = '

            SELECT aclo_tablename, aclo_masterid, aclo_userid, aclo_status, aclo_fieldname,rema_reqno,um.usma_fullname, um.usma_employeeid 

            from xw_aclo_actionlog xaa

            left join xw_rema_reqmaster rm on xaa.aclo_masterid = rm.rema_reqmasterid and aclo_tablename = "rema_reqmaster"

            left join xw_usma_usermain um on um.usma_userid = xaa.aclo_userid

            where rema_reqno = "'.$reqno.'" and rema_fyear = "'.$fyear.'" and aclo_status = "'.$status.'" and aclo_fieldname = "'.$field.'"

            UNION

            SELECT aclo_tablename, aclo_masterid, aclo_userid, aclo_status, aclo_fieldname, pure_streqno, um.usma_fullname, um.usma_employeeid

            from xw_aclo_actionlog xaa 

            left join xw_pure_purchaserequisition pr on xaa.aclo_masterid = pr.pure_purchasereqid and aclo_tablename = "pure_purchaserequisition" 

            left join xw_usma_usermain um on um.usma_userid = xaa.aclo_userid

            where pure_streqno = "'.$reqno.'" and pure_fyear = "'.$fyear.'" 

            and aclo_status = "'.$status.'" and aclo_fieldname = "'.$field.'"

            ';

        $query = $this->db->query($sql);

        if($query->num_rows() > 0){

            return $query->result();

        }

        return false;

    }

    public function process_issue($status){

        $rema_reqmasterid = $this->input->post('masterid');

        $this->db->trans_begin();

        $issueArray = array(

            'rema_proceedissue' => $status,

            // 'rema_approved' => '1'

        );

        if($issueArray){

            $this->db->where('rema_reqmasterid',$rema_reqmasterid);

            $this->db->update('rema_reqmaster',$issueArray);

            $this->general->saveActionLog('rema_reqmaster', $rema_reqmasterid, $this->userid, $status,'rema_proceedissue'); 

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

      public function requisition_vs_issue_list($type=false)

    {

        $frmDate=$this->input->post('fromdate');

        $toDate=$this->input->post('todate');

        $locationid = $this->input->post('locationid');

        $fyear = $this->input->post('fyear');
        if(!empty($locationid)){
            $srchcolsm= ' AND sm.sama_locationid='.$locationid;
            $srchcolrm= ' AND rm.rema_locationid='.$locationid;
        }else{
            $srchcolsm='';
            $srchcolrm='';
        }

        $sql="SELECT rm.rema_reqmasterid,rm.rema_reqno,rm.rema_reqdatebs,rm.rema_reqdatead,d.dept_depname,rm.rema_reqby,

        (SELECT GROUP_CONCAT(sm.sama_salemasterid,'-',sm.sama_invoiceno,'-',sm.sama_billdatebs,'-',sm.sama_receivedby) from xw_sama_salemaster sm WHERE sm.sama_requisitionno >0 

        AND sm.sama_requisitionno= rm.rema_reqno AND sm.sama_fyear='$fyear' $srchcolsm

        ) as issue_status

        from xw_rema_reqmaster rm

        LEFT JOIN xw_dept_department d on d.dept_depid=rm.rema_reqfromdepid

        WHERE rm.rema_fyear='$fyear'  AND rm.rema_approved<>3 $srchcolrm";

         if($type == 'requisition_vs_issue'){

        }else{

        }

        $qry=$this->db->query($sql);

        // echo $this->db->last_query();

        // die();

        $result=$qry->result();

        return $result;

    }

    public function change_receive_status_item_accepted($reqno=false,$fiscal_year=false){

      $update_array = array(

                       'rema_received'=>'1'

                    );

       $this->general->save_log('rema_reqmaster','rema_reqno',$reqno,$update_array,'Update');

       $this->db->update('rema_reqmaster',$update_array,array('rema_reqno'=>$reqno,'rema_fyear'=>$fiscal_year,'rema_storeid'=>$this->storeid));

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

    public function change_receive_status_item_reject($reqno=false,$fiscal_year=false){

      $update_array = array(

                       'rema_received'=>'0'

                    );

       $this->general->save_log('rema_reqmaster','rema_reqno',$reqno,$update_array,'Update');

       $this->db->update('rema_reqmaster',$update_array,array('rema_reqno'=>$reqno,'rema_fyear'=>$fiscal_year,'rema_storeid'=>$this->storeid));

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

public function item_code_update($code=false,$id=false,$itemid=false)

{   

    // $id = $this->input->post('id');

    // $code = $this->input->post('itli_itemcode');

     // print_r($id);die;

    $postdata = array(

     'rede_itemsid'=>$itemid,   

     'rede_code'=>$code,

     'rede_istempitem'=>'N',

    'rede_modifydatead'=>CURDATE_EN,

    'rede_modifydatebs'=> CURDATE_NP,

    'rede_modifytime'=>date('H:i:s'),

    'rede_modifymac'=>$this->general->get_real_ipaddr(),

    'rede_modifyip'=>$this->general->get_Mac_Address(),

    'rede_modifyby'=>$this->userid

   );

     $this->general->save_log('rede_reqdetail','rede_reqdetailid',$id,$postdata,'Update');

     $res=$this->db->update('rede_reqdetail',$postdata,array('rede_reqdetailid'=>$id));

     if($res)

        {

            return true;

        }

     else

        {

            return false;

        }

  }

 public function item_code_exit($itemcode=false)

    {

        $this->db->select('itli_itemlistid,itli_itemcode');

        $this->db->where('itli_itemcode',$itemcode);

        $query = $this->db->get('itli_itemslist');

         if($query->num_rows() > 0){

                return $query->result();

            }

        return false;

    }

    public function get_history_data($id, $reqno = false, $fyear = false, $order = false){

        $pur_data = $this->general->get_tbl_data('pure_purchasereqid','pure_purchaserequisition',array('pure_fyear'=>$fyear,'pure_streqno'=>$reqno));

        $pur_id = !empty($pur_data[0]->pure_purchasereqid)?$pur_data[0]->pure_purchasereqid:0;

        $hnd_data = $this->general->get_tbl_data('harm_handovermasterid','harm_handoverreqmaster',array('harm_fyear'=>$fyear,'harm_reqno'=>$reqno));

        $hnd_id = !empty($hnd_data[0]->harm_handovermasterid)?$hnd_data[0]->harm_handovermasterid:0;

        if(empty($order)){

            $order = "asc";

        }

        if($pur_id){

            $query = $this->db->query("

                select aclo_status, inst_comment, usma_username, aclo_actiondatead, aclo_actiondatebs, aclo_actiontime, aclo_actionmac, aclo_actionip, aclo_id

                from(

                select aclo_status, inst_comment, usma_username, aclo_actiondatead, aclo_actiondatebs, aclo_actiontime, aclo_actionmac, aclo_actionip, aclo_id from xw_aclo_actionlog xaa 

            left join xw_inst_inventorystatus xii on xii.inst_status = xaa.aclo_status and inst_fieldname = aclo_fieldname

            left join xw_usma_usermain u on u.usma_userid = aclo_userid

            where aclo_masterid = $id and aclo_tablename='rema_reqmaster'

            and aclo_locationid = $this->locationid

            UNION

            select aclo_status, inst_comment, usma_username, aclo_actiondatead, aclo_actiondatebs, aclo_actiontime, aclo_actionmac, aclo_actionip, aclo_id from xw_aclo_actionlog xaa 

            left join xw_inst_inventorystatus xii on xii.inst_status = xaa.aclo_status and inst_fieldname = aclo_fieldname

            left join xw_usma_usermain u on u.usma_userid = aclo_userid

            where aclo_masterid = $pur_id and aclo_tablename='pure_purchaserequisition'

            and aclo_locationid = $this->locationid

            ) x order by aclo_id $order

            ");

        }

        else if($hnd_id){

            $query = $this->db->query("

                select aclo_status, inst_comment, usma_username, aclo_actiondatead, aclo_actiondatebs, aclo_actiontime, aclo_actionmac, aclo_actionip, aclo_id

                from(

                select aclo_status, inst_comment, usma_username, aclo_actiondatead, aclo_actiondatebs, aclo_actiontime, aclo_actionmac, aclo_actionip, aclo_id from xw_aclo_actionlog xaa 

            left join xw_inst_inventorystatus xii on xii.inst_status = xaa.aclo_status and inst_fieldname = aclo_fieldname

            left join xw_usma_usermain u on u.usma_userid = aclo_userid

            where aclo_masterid = $id and aclo_tablename='rema_reqmaster'

            and aclo_locationid = $this->locationid

            UNION

            select aclo_status, inst_comment, usma_username, aclo_actiondatead, aclo_actiondatebs, aclo_actiontime, aclo_actionmac, aclo_actionip, aclo_id from xw_aclo_actionlog xaa 

            left join xw_inst_inventorystatus xii on xii.inst_status = xaa.aclo_status and inst_fieldname = aclo_fieldname

            left join xw_usma_usermain u on u.usma_userid = aclo_userid

            where aclo_masterid = $pur_id and aclo_tablename='pure_purchaserequisition'

            and aclo_locationid = $this->locationid

            UNION

            select aclo_status, inst_comment, usma_username, aclo_actiondatead, aclo_actiondatebs, aclo_actiontime, aclo_actionmac, aclo_actionip, aclo_id from xw_aclo_actionlog xaa 

            left join xw_inst_inventorystatus xii on xii.inst_status = xaa.aclo_status and inst_fieldname = aclo_fieldname

            left join xw_usma_usermain u on u.usma_userid = aclo_userid

            where aclo_masterid = $hnd_id and aclo_tablename='harm_handoverreqmaster' and aclo_locationid = $this->locationid

            ) x order by aclo_id $order

            ");

        }

        else{

             $query = $this->db->query("select aclo_status, inst_comment, usma_username, aclo_actiondatead, aclo_actiondatebs, aclo_actiontime, aclo_actionmac, aclo_actionip from xw_aclo_actionlog xaa 

            left join xw_inst_inventorystatus xii on xii.inst_status = xaa.aclo_status and inst_fieldname = aclo_fieldname

            left join xw_usma_usermain u on u.usma_userid = aclo_userid

            where aclo_masterid = $id and aclo_tablename='rema_reqmaster' and aclo_locationid = $this->locationid

            order by aclo_id $order

        ");

        }

        // echo $this->db->last_query();

        // die();

        $result=$query->result();

        return $result;

    }

    public function inform_item_available($items_id, $reqdetailid, $rema_reqmasterid){

        $this->db->trans_begin();

        foreach($items_id as $key=>$item){

            $itemArray = array(

                'rede_itemavailable' =>'1'

            );

            $this->db->where('rede_reqmasterid',$rema_reqmasterid);

            $this->db->where('rede_reqdetailid',$reqdetailid[$key]);

            $this->db->where('rede_itemsid',$items_id[$key]);

            $this->db->update('rede_reqdetail',$itemArray);

        }

        $remaArray = array(

            'rema_itemavailable' => '1'

        );  

        if($remaArray){

            $this->db->where('rema_reqmasterid',$rema_reqmasterid);

            $this->db->update('rema_reqmaster',$remaArray);

            $this->general->saveActionLog('rema_reqmaster', $rema_reqmasterid, $this->userid, '1','rema_itemavailable'); 

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

    public function get_items_count($srchcol = false){

        try{

            $this->db->select("

                rede_reqmasterid,

                count(rede_itemsid) ttl_count,

                sum(case when rede_proceedpurchase = 'Y' then 1 else 0 end) proceed_pur_count, 

                sum(case when rede_proceedissue = 'Y' then 1 else 0 end) proceed_iss_count,

                sum(case when rede_itemavailable = '1' then 1 else 0 end) avail_after_pur_count,

                (select count(sade_itemsid) from xw_sade_saledetail s where sade_reqdetailid = rede_reqdetailid) total_issued

            ");

            $this->db->from('rede_reqdetail');

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

    public function get_it_items_count($srchcol = false){

        try{

            $this->db->select("

                rede_reqmasterid,

                count(rede_itemsid) ttl_count,

                count(rede_itemsid) as it_item_count

            ");

            $this->db->from('rede_reqdetail r');

            $this->db->join('itli_itemslist i', 'i.itli_itemlistid = r.rede_itemsid');

            $this->db->join('eqca_equipmentcategory e', 'e.eqca_equipmentcategoryid = i.itli_catid');   

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

    public function get_requisition_list_army($cond = false)
    {   

        $request_user_group = defined('REQ_TO_GROUP_CODE') ? explode(',',REQ_TO_GROUP_CODE) : [];
        $request_to_other_group_access = defined('REQ_TO_OTHER_ACCESS_GROUP') ? explode(',',REQ_TO_OTHER_ACCESS_GROUP) : [];
        $get = $_GET;                          
 
        foreach ($get as $key => $value) {

            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));

        }

        // $srch_app_tbl=array();
        // $srch_app_tbl['aclo_userid']=$this->userid;
        // if($frmDate){
        //     $srch_app_tbl['aclo_userid']=$this->userid;
        // }

        // $action_tbl_approved_list=$this->general->get_tbl_data('DISTINCT(aclo_masterid) as aclo_masterid','aclo_actionlog',array('aclo_userid'=>$this->userid),'aclo_masterid','ASC');

        // echo "<pre>";
        // print_r($action_tbl_approved_list);
        // die();
        $totalrecs='';
        $limit = 15;
        $offset = 1;

        if(!empty($_GET["iDisplayLength"])){
           $limit = $_GET['iDisplayLength'];
           $offset = $_GET["iDisplayStart"];
        }

        $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');

        $toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');

        $type = !empty($get['type'])?$get['type']:$this->input->post('type');

        $apptype = !empty($get['apptype'])?$get['apptype']:$this->input->post('apptype');

        $input_locationid= !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');

        $departmentid= !empty($get['departmentid'])?$get['departmentid']:$this->input->post('departmentid');

        $subdepid=!empty($get['subdepid'])?$get['subdepid']:$this->input->post('subdepid');
        $srchtext=!empty($get['srchtext'])?$get['srchtext']:'';

                $this->db->select('acl.aclo_masterid')
                      ->from('aclo_actionlog as acl')
                      ->join('rema_reqmaster as rm','rm.rema_reqmasterid=acl.aclo_masterid','INNER')
                      ->where('aclo_userid',$this->userid);
                      if(!empty($frmDate) && ($toDate)){
                        $this->db->where(array('rm.rema_reqdatebs>='=>$frmDate,'rm.rema_reqdatebs<='=>$toDate));
                      }
            $action_tbl_approved_list=$this->db->get()->result();
    //         echo $this->db->last_query();
    // echo "<pre>";
    // print_r($action_tbl_approved_list);
    // die();

        $check_parentid=array();
        if(!empty($departmentid)){
          $check_parentid=$this->general->get_tbl_data('dept_depid,dept_parentdepid','dept_department',array('dept_depid'=>$departmentid),'dept_depname','ASC');

        }

        $subdeparray=array();

        if(!empty($check_parentid)){

            $parentdepid=!empty($check_parentid[0]->dept_parentdepid)?$check_parentid[0]->dept_parentdepid:'0';

            if($parentdepid=='0'){

                $subdep_result=$this->general->get_tbl_data('dept_depid','dept_department',array('dept_parentdepid'=>$departmentid),'dept_depname','ASC');

                if(!empty($subdep_result)){
                    foreach ($subdep_result as $ksd => $dep) {
                      $subdeparray[]=$dep->dept_depid;
                    }
                }
            }

        }

        if(!empty( $subdepid)){
            $departmentid= $subdepid;
        }

        $fiscalyear = !empty($get['fiscalyear'])?$get['fiscalyear']:$this->input->post('fiscalyear');

        $mattype = !empty($get['mattype'])?$get['mattype']:$this->input->post('mattype');

        $schoolid = !empty($get['schoolid'])?$get['schoolid']:$this->input->post('schoolid');

        if($this->mattypeid){    
           $mattype= $this->mattypeid;
        }

        if($apptype=='pending')
        {
            $approved=0;
        }

        if($apptype=='approved')
        {
            $approved=1;
        }

        if($apptype=='unapproved')
        {
            $approved=2;
        }

        if($apptype=='cancel')
        {
            $approved=3;
        }

        if($apptype=='verified')
        {
            $approved=4;
        }

        if($apptype=='cntissue')
        {
            $approved='';
        }

        $subquery1="(SELECT d.dept_depname FROM xw_dept_department d WHERE d.dept_depid=rm.rema_reqfromdepid)";

        $subquery2 = "(SELECT et.eqty_equipmenttype FROM xw_eqty_equipmenttype et WHERE et.eqty_equipmenttypeid=rm.rema_reqtodepid)";

        $subquery3="(SELECT  ett.eqty_equipmenttype  FROM xw_eqty_equipmenttype ett WHERE ett.eqty_equipmenttypeid=rm.rema_reqfromdepid AND rm.rema_isdep='N') fromdep_transfer";

        $this->db->start_cache();

        if(!empty($get['sSearch_0'])){

            $this->db->where("rema_reqmasterid like  '%".$get['sSearch_0']."%'  ");
        }

        if(!empty($get['sSearch_1'])){

            $this->db->where("lower(rema_reqdatead) like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){

            $this->db->where("lower(rema_reqdatebs) like  '%".$get['sSearch_2']."%'  ");
        }

        if(!empty($get['sSearch_3'])){

            $this->db->where("lower(rema_reqno) like  '%".$get['sSearch_3']."%'  ");

        }

         if(!empty($get['sSearch_4'])){

            $this->db->where("lower(d.dept_depname) like  '%".$get['sSearch_4']."%'  ");

        } 

        if(!empty($get['sSearch_5'])){

            $this->db->where("lower(eqty_equipmenttype) like  '%".$get['sSearch_5']."%'  ");

        } 

        if(!empty($get['sSearch_6'])){

            $this->db->where("lower(rema_username) like  '%".$get['sSearch_6']."%'  ");

        }

        if(!empty($get['sSearch_7'])){

            $this->db->where("lower(rema_isdep) like  '%".$get['sSearch_7']."%'  ");

        }

         if(!empty($get['sSearch_8'])){

            $this->db->where("lower(rema_reqby) like  '%".$get['sSearch_8']."%'  ");

        }

         if(!empty($get['sSearch_9'])){

            $this->db->where("lower(rema_approvedby) like  '%".$get['sSearch_9']."%'  ");

        }

        if(!empty($get['sSearch_10'])){

            $this->db->where("lower(rema_manualno) like  '%".$get['sSearch_10']."%'  ");

        }

        if(!empty($get['sSearch_12'])){

            $this->db->where("lower(rema_fyear) like  '%".$get['sSearch_12']."%'  ");

        }

        if($cond) {

            $this->db->where($cond);

        }

        if(!empty(($frmDate && $toDate)))
        {
            if(DEFAULT_DATEPICKER == 'NP'){

                $this->db->where('rm.rema_reqdatebs >=',$frmDate);

                $this->db->where('rm.rema_reqdatebs <=',$toDate);    

            }else{

                $this->db->where('rm.rema_reqdatead >=',$frmDate);

                $this->db->where('rm.rema_reqdatead <=',$toDate);

            }

        }

        if(!empty($mattype)){

            $this->db->where('rm.rema_mattypeid',$mattype);

        }

        if($apptype!="cntissue"){

            if(!empty($apptype))

            {

                $this->db->where('rm.rema_approved',"$approved");

            }

        }

        if($this->location_ismain=='Y')

        {

            if($input_locationid)

            {

                $this->db->where('rm.rema_locationid',$input_locationid);

            }

        }

        else

        {

            $this->db->where('rm.rema_locationid',$this->locationid);

        }

        if(!empty($departmentid)){
            if(!empty( $subdepid)){
                $this->db->where('rm.rema_reqfromdepid',$subdepid);    
            }else{
                if(!empty($subdeparray)){
                    $this->db->where_in('rm.rema_reqfromdepid',$subdeparray);

                }else{

                    $this->db->where('rm.rema_reqfromdepid',$departmentid);    

                }
            }
   
        }

        if(!empty($srchtext)){
            $this->db->where('(rema_reqno='.$srchtext.' OR rema_manualno='.$srchtext.')');
        }

        if(!empty($schoolid)){

            $this->db->where('rm.rema_school', $schoolid);

        }       

        if ( in_array($this->usergroup,$request_user_group)) {

            if(!empty($type)){
                if($type=='self'){
                    $this->db->where('rm.rema_postby',$this->userid);
                    
                }else if($type=='others'){
                    $this->db->where('rm.rema_postby !=',$this->userid);
                    $this->db->where('rm.rema_reqto',$this->userid);
                }else{

                    $this->db->group_start();
                    $this->db->where('rm.rema_postby',$this->userid);
                    $this->db->or_where('rm.rema_reqto',$this->userid);
                    if(!empty($action_tbl_approved_list)){
                        $app_list_master_id=array();
                        foreach($action_tbl_approved_list as $ata){
                            $app_list_master_id[]=$ata->aclo_masterid;
                        }
                        $this->db->or_where_in('rm.rema_reqmasterid',$app_list_master_id);
                    }
                    $this->db->group_end();
                }
            }    
        }else if(in_array($this->usergroup,$request_to_other_group_access) || $this->usergroup == 'SA'){

            $this->db->where('rm.rema_postby !=','');
        }else{
            $this->db->where('rm.rema_postby',$this->userid);
        }

        $this->db->where('rema_isdep <>',' ');

        $this->db->stop_cache();

        $resltrpt=$this->db->select("COUNT(*) as cnt")
                        ->from('rema_reqmaster rm')
                        ->join('dept_department d','d.dept_depid=rm.rema_reqfromdepid','LEFT')
                        ->join('eqty_equipmenttype et','et.eqty_equipmenttypeid=rm.rema_reqtodepid','LEFT')
                        ->get()
                        ->row();

        $totalfilteredrecs=$resltrpt->cnt; 

        $order_by = 'rema_reqmasterid';

        $order = 'desc';

        if($this->input->get('sSortDir_0'))
        {
            $order = $this->input->get('sSortDir_0');

        }

        if($this->input->get('iSortCol_0')==1)

            $order_by = 'rema_reqdatead';

        else if($this->input->get('iSortCol_0')==2)

            $order_by = 'rema_reqdatebs';

        else if($this->input->get('iSortCol_0')==4)

            $order_by = 'rema_reqno';

        else if($this->input->get('iSortCol_0')==4)

            $order_by = 'dept_depname';

        else if($this->input->get('iSortCol_0')==5)

            $order_by = 'eqty_equipmenttype';

        else if($this->input->get('iSortCol_0')==6)

            $order_by = 'rema_username';

        else if($this->input->get('iSortCol_0')==7)

            $order_by = 'rema_isdep';

        else if($this->input->get('iSortCol_0')==8)

            $order_by = 'rema_reqby';

         else if($this->input->get('iSortCol_0')==9)

            $order_by = 'rema_approvedby';

        else if($this->input->get('iSortCol_0')==10)

            $order_by = 'rema_manualno';

        else if($this->input->get('iSortCol_0')==12)

            $order_by = 'rema_fyear';

        $cntitemQty="(SELECT COUNT(*) as cntitem from xw_rede_reqdetail rd WHERE rd.rede_remqty >0 AND rd.rede_reqmasterid=rm.rema_reqmasterid AND rd.rede_isdelete = 'N') as cntitem";

        $this->db->select("rm.*,rm.rema_remarks,rm.rema_workplace,rm.rema_workdesc,mt.maty_material,$cntitemQty, ($subquery1) depfrom,dtfp.dept_depname deptparent,scf.loca_name as schoolname,  ($subquery2) depto,  $subquery3 ");

        $this->db->from('rema_reqmaster rm');

        $this->db->join('dept_department d','d.dept_depid=rm.rema_reqfromdepid','LEFT');
        $this->db->join('dept_department dtfp','dtfp.dept_depid=d.dept_parentdepid','LEFT');
        $this->db->join('loca_location scf','rm.rema_school=scf.loca_locationid','LEFT');
        $this->db->join('maty_materialtype mt','mt.maty_materialtypeid=rm.rema_mattypeid',"LEFT");

        $this->db->join('eqty_equipmenttype et','et.eqty_equipmenttypeid=rm.rema_reqtodepid','LEFT');
        
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
       $this->db->flush_cache();

        if (!empty($_GET['iDisplayLength']) &&  !empty($nquery) && is_array($nquery) && count($nquery) > 0 ) {
            $totalrecs = count($nquery);
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

}