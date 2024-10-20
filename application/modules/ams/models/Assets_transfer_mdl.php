<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Assets_transfer_mdl extends CI_Model 

{

    public function __construct() 

    {

        parent::__construct();

        $this->userid = $this->session->userdata(USER_ID);

        $this->username = $this->session->userdata(USER_NAME);

        $this->curtime = $this->general->get_currenttime();

        $this->mac = $this->general->get_Mac_Address();

        $this->ip = $this->general->get_real_ipaddr();

        $this->locationid=$this->session->userdata(LOCATION_ID);

        $this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);

        $this->orgid=$this->session->userdata(ORG_ID);

    }

     public $validate_settings_transfer_assets = array(

        array('field' => 'astm_fiscalyrs', 'label' => 'Fiscal Year', 'rules' => 'trim|required|xss_clean'),

        array('field' => 'astm_transferno', 'label' => 'Transfer No', 'rules' => 'trim|required|xss_clean'),

        array('field' => 'astm_transfertypeid', 'label' => 'Transfer Type ', 'rules' => 'trim|required|xss_clean'),

        array('field' => 'transferdate', 'label' => 'Transfer Date', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'assetid[]', 'label' => 'Assets', 'rules' => 'trim|required|xss_clean')

    );

    public function save_assets_transfer_data(){       
        try{
            $astm_fiscalyrs=$this->input->post('astm_fiscalyrs');
            $astm_transferno=$this->input->post('astm_transferno');
            $astm_manualno=$this->input->post('astm_manualno');
            $astm_transfertypeid=$this->input->post('astm_transfertypeid');
            $fromdepid=$this->input->post('fromdepid');
            $todepid=$this->input->post('todepid');
            $locationfrom=$this->input->post('locationfrom');
            $locationto=$this->input->post('locationto');
            $from_schoolid=$this->input->post('from_schoolid');
            $to_schoolid=$this->input->post('to_schoolid');
            $from_subdepid=$this->input->post('from_subdepid');
            $to_subdepid=$this->input->post('to_subdepid');
            $transferdate=$this->input->post('transferdate');
            $assets_code=$this->input->post('assets_code');
            $assetid=$this->input->post('assetid');
            $assets_desc=$this->input->post('assets_desc');
            $assets_orginalval=$this->input->post('assets_orginalval');
            $assets_currentval=$this->input->post('assets_currentval');
            $fullremarks=$this->input->post('fullremarks');
            $remarks=$this->input->post('remarks');
            $staffid=$this->input->post('staffid');
            $assets_prev_staffname=$this->input->post('assets_prev_staffname');
            $received_staff_infoid='';
            $received_staff_infoname='';
            // echo "<pre>";
            // print_r($this->input->post());
            // die();
            $asset_cnt=0;
            if(!empty($assetid) && is_array($assetid)){
                $asset_cnt=sizeof($assetid);
            }
            if (ORGANIZATION_NAME == 'KU' || ORGANIZATION_NAME=='ARMY') {
                $received_by = $this->input->post('astm_receivedstaffid');
                $from_subdepid = $this->input->post('from_subdepid');
                $to_subdepid = $this->input->post('to_subdepid');
                if(!empty($from_subdepid)){
                    $fromdepid = $from_subdepid;
                }
                if(!empty($to_subdepid)){
                    $todepid = $to_subdepid;
                }
                if (!empty($received_by)) {
                    $staff_info = explode('@', $received_by);
                    $received_staff_infoid=!empty($staff_info[0])?$staff_info[0]:'';
                    $received_staff_infoname=!empty($staff_info[1])?$staff_info[1]:'';
                }
            }
            if($astm_transfertypeid=='D'){
                $astm_from=$fromdepid;
                $astm_to=$todepid;
            }
            else if($astm_transfertypeid=='B'){
                if(ORGANIZATION_NAME=='KU' || ORGANIZATION_NAME=='ARMY'){
                    $astm_from=$from_schoolid;
                 $astm_to=$to_schoolid;
                }else{
                $astm_from=$locationfrom;
                $astm_to=$locationto;
                }
            }
            else{
                $astm_from='';
                $astm_to='';
            }
            if(DEFAULT_DATEPICKER=='NP')
            {
                $transferdatebs=$transferdate;
                $transferdatead=$this->general->NepToEngDateConv($transferdate);
            }
            else
            {
                $transferdatead=$transferdate;
                $transferdatebs=$this->general->EngToNepDateConv($transferdate);
            }
            $worderno=$this->input->post('astm_transferno');
        $locationid=$this->session->userdata(LOCATION_ID);
        $currentfyrs=CUR_FISCALYEAR;
        $cur_fiscalyrs_transferno=$this->db->select('astm_transferno,astm_fiscalyrs')
                                    ->from('astm_assettransfermaster')
                                    ->where('astm_locationid',$locationid)
                                    // ->where('prin_fiscalyrs',$currentfyrs)
                                    ->order_by('astm_fiscalyrs','DESC')
                                    ->limit(1)
                                    ->get()->row();
        // echo "<pre>";
        // print_r($cur_fiscalyrs_transferno);
        // die();
        if(!empty($cur_fiscalyrs_transferno)){
            $transfer_format=$cur_fiscalyrs_transferno->astm_transferno;
            $transfer_string=str_split($transfer_format);
            // echo "<pre>";
            // print_r($transfer_string);
            // die();
            $transfer_prefix_len=strlen(ASSETS_TRANSFER_CODE_NO_PREFIX);
            $chk_first_string_after_transfer_prefix=$transfer_string[$transfer_prefix_len];
            // echo $chk_first_string_after_transfer_prefix;
            // die();
            if($chk_first_string_after_transfer_prefix =='0'){
                $transfer_no_prefix=ASSETS_TRANSFER_CODE_NO_PREFIX.CUR_FISCALYEAR;
            }
            else if ($cur_fiscalyrs_transferno->prin_fiscalyrs==$currentfyrs && $chk_first_string_after_transfer_prefix =='0' ) {
                $transfer_no_prefix=ASSETS_TRANSFER_CODE_NO_PREFIX.CUR_FISCALYEAR;
            }
            else if ($cur_fiscalyrs_transferno->prin_fiscalyrs!=$currentfyrs && $chk_first_string_after_transfer_prefix =='0' ) {
                $transfer_no_prefix=ASSETS_TRANSFER_CODE_NO_PREFIX.CUR_FISCALYEAR;
            }
            else if ($cur_fiscalyrs_transferno->prin_fiscalyrs!=$currentfyrs && $chk_first_string_after_transfer_prefix !='0' ) {
                $transfer_no_prefix=ASSETS_TRANSFER_CODE_NO_PREFIX.CUR_FISCALYEAR;
            }
            else{
                $transfer_no_prefix=ASSETS_TRANSFER_CODE_NO_PREFIX;
            }
        }
        else{
            $transfer_no_prefix=ASSETS_TRANSFER_CODE_NO_PREFIX.CUR_FISCALYEAR;
        }
        // die();
        $transfer_code = $this->general->generate_invoiceno('astm_transferno','astm_transferno','astm_assettransfermaster',$transfer_no_prefix,ASSETS_TRANSFER_CODE_NO_LENGTH,false,'astm_locationid');
            $transferMasterArr=array(
                'astm_fiscalyrs'=>$astm_fiscalyrs,
                'astm_transferno'=>$transfer_code,
                'astm_transfertypeid'=>$astm_transfertypeid,
                'astm_from'=>$astm_from,
                'astm_to'=>$astm_to,
                'astm_manualno'=>$astm_manualno,
                'astm_transferdatebs'=>$transferdatebs,
                'astm_transferdatead'=>$transferdatead,
                'astm_noofassets'=>$asset_cnt,
                'astm_status'=>'O',
                'astm_remark'=>$fullremarks,
                'astm_postdatead'=>CURDATE_EN,
                'astm_postdatebs'=>CURDATE_NP,
                'astm_posttime'=>date('H:i:s'),
                'astm_postby'=> $this->userid,
                'astm_postip'=> $this->ip,
                'astm_postmac'=>$this->mac,
                'astm_locationid'=> $this->locationid,
                'astm_orgid'=>$this->orgid
            );
            if(!empty($transferMasterArr)){
                if(ORGANIZATION_NAME=='KU' || ORGANIZATION_NAME=='ARMY'){
                    $transferMasterArr['astm_fromschoolid']=$from_schoolid;
                    $transferMasterArr['astm_toschoolid']=$to_schoolid;
                    $transferMasterArr['astm_receivedstaffid']=!empty($staff_info[0])?$staff_info[0]:'';
                    $transferMasterArr['astm_receivedby']=!empty($staff_info[1])?$staff_info[1]:'';
                }
                $this->db->insert('astm_assettransfermaster',$transferMasterArr);
                  $insertid=$this->db->insert_id();
                  $transferDetail=array();
                    if($insertid){
                        $assetsid_arr=array();
                        if(!empty($assetid)):
                            foreach ($assetid as $kdw => $dlist) {
                                $assetsid_arr[]=!empty($assetid[$kdw])?$assetid[$kdw]:'';
                                $transferDetail[]=array(
                                    'astd_assetetransfermasterid'=>$insertid,
                                    'astd_assetsid'=>!empty($assetid[$kdw])?$assetid[$kdw]:'',
                                    'astd_assetsdesc'=>!empty($assets_desc[$kdw])?$assets_desc[$kdw]:'',
                                    'astd_originalamt'=>!empty($assets_orginalval[$kdw])?$assets_orginalval[$kdw]:'',
                                    'astd_currentamt'=>!empty($assets_currentval[$kdw])?$assets_currentval[$kdw]:'',
                                    'astd_remark'=>!empty($remarks[$kdw])?$remarks[$kdw]:'',
                                    'astd_prev_staffname'=>!empty($assets_prev_staffname[$kdw])?$assets_prev_staffname[$kdw]:'',
                                    'astd_prev_staffid'=>!empty($staffid[$kdw])?$staffid[$kdw]:'',
                                    'astd_status'=>'O',
                                    'astd_postdatead'=>CURDATE_EN,
                                    'astd_postdatebs'=>CURDATE_NP,
                                    'astd_posttime'=>date('H:i:s'),
                                    'astd_postby'=>$this->userid,
                                    'astd_postip'=>$this->ip,
                                    'astd_postmac'=>$this->mac,
                                    'astd_locationid'=>$this->locationid,
                                    'astd_orgid'=>$this->orgid
                                ); 
                    }
                endif;
                    if(!empty($transferDetail)){
                        $this->db->insert_batch('astd_assettransferdetail',$transferDetail);
                        if(!empty($assetsid_arr)){
                            if($astm_transfertypeid=='D'){ 
                                $this->db->set('asen_depid',$astm_to);
                                $this->db->set('asen_schoolid',$to_schoolid);
                                if(!empty($received_staff_infoid)){
                                    $this->db->set('asen_staffid',$received_staff_infoid);
                                }
                                $this->db->where_in('asen_asenid',$assetsid_arr); 
                                $this->db->update('asen_assetentry');
                             }
                             else if($astm_transfertypeid=='B'){
                                if(ORGANIZATION_NAME=='KU' || ORGANIZATION_NAME=='ARMY'){
                                    $this->db->set('asen_schoolid',$to_schoolid);
                                }else{
                                      $this->db->set('asen_locationid',$astm_to);
                                }
                                 $this->db->where_in('asen_asenid',$assetsid_arr);  
                                 $this->db->update('asen_assetentry');
                             }
                      }
                }
            }
        }
         $this->db->trans_complete();
         // $this->db->trans_commit();
           // return true;
       if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return $insertid;
        }
     }catch(Exception $e){
            $this->db->trans_rollback();
                return false;
            throw $e;
        }
    }

    public function save_assets_transfer_data_bulk(){       
        try{
            // echo "<pre>";
            // print_r($this->input->post());
            // die();
            $astm_fiscalyrs=$this->input->post('astm_fiscalyrs');
            $astm_transferno=$this->input->post('astm_transferno');
            $astm_manualno='';
            $astm_transfertypeid=$this->input->post('astm_transfertypeid');
           
            $locationfrom=$this->input->post('locationfrom');
            $locationto=$this->input->post('locationto');

            $from_schoolid=$this->input->post('astm_fromschoolid');
            $from_subdepid=$this->input->post('fromsubdepid');
            $fromdepid=$this->input->post('fromdepid');

            $to_schoolid=$this->input->post('to_schoolid');
            $todepid=$this->input->post('todepid');
           
            $to_subdepid=$this->input->post('to_subdepid'); 
            $transferdate=$this->input->post('transferdate');
            $assets_code=$this->input->post('assets_code');
            $assetid=$this->input->post('assetid');
            $assets_desc=$this->input->post('assets_desc');
            $assets_orginalval=$this->input->post('assets_orginalval');
            $assets_currentval=$this->input->post('assets_currentval');
            $fullremarks=$this->input->post('fullremarks');
            $remarks=$this->input->post('remarks');
            $astm_receivedstaffid=$this->input->post('astm_receivedstaffid');
         
            $received_staff_infoid='';
            $received_staff_infoname='';
            // echo "<pre>";
            // print_r($this->input->post());
            // die();
            $asset_cnt=0;
            if(!empty($assetid) && is_array($assetid)){
                $asset_cnt=sizeof($assetid);
            }
            if (ORGANIZATION_NAME == 'KU') {
                $received_by = $this->input->post('astm_receivedstaffid');
                $from_subdepid = $this->input->post('fromsubdepid');
                $to_subdepid = $this->input->post('to_subdepid');
                if(!empty($from_subdepid)){
                    $fromdepid = $from_subdepid;
                }
                if(!empty($to_subdepid)){
                    $todepid = $to_subdepid;
                }
                if (!empty($received_by)) {
                    $staff_info = explode('@', $received_by);
                    $received_staff_infoid=!empty($staff_info[0])?$staff_info[0]:'';
                    $received_staff_infoname=!empty($staff_info[1])?$staff_info[1]:'';
                }
            }
            if($astm_transfertypeid=='D'){
                $astm_from=$fromdepid;
                $astm_to=$todepid;
            }
            else if($astm_transfertypeid=='B'){
                if(ORGANIZATION_NAME=='KU'){
                    $astm_from=$from_schoolid;
                 $astm_to=$to_schoolid;
                }else{
                $astm_from=$locationfrom;
                $astm_to=$locationto;
                }
            }
            else{
                $astm_from='';
                $astm_to='';
            }
            if(DEFAULT_DATEPICKER=='NP')
            {
                $transferdatebs=$transferdate;
                $transferdatead=$this->general->NepToEngDateConv($transferdate);
            }
            else
            {
                $transferdatead=$transferdate;
                $transferdatebs=$this->general->EngToNepDateConv($transferdate);
            }
            $worderno=$this->input->post('astm_transferno');
            $locationid=$this->session->userdata(LOCATION_ID);
            $currentfyrs=CUR_FISCALYEAR;
            $cur_fiscalyrs_transferno=$this->db->select('astm_transferno,astm_fiscalyrs')
                                        ->from('astm_assettransfermaster')
                                        ->where('astm_locationid',$locationid)
                                        // ->where('prin_fiscalyrs',$currentfyrs)
                                        ->order_by('astm_fiscalyrs','DESC')
                                        ->limit(1)
                                        ->get()->row();
        // echo "<pre>";
        // print_r($cur_fiscalyrs_transferno);
        // die();
        if(!empty($cur_fiscalyrs_transferno)){
            $transfer_format=$cur_fiscalyrs_transferno->astm_transferno;
            $transfer_string=str_split($transfer_format);
            // echo "<pre>";
            // print_r($transfer_string);
            // die();
            $transfer_prefix_len=strlen(ASSETS_TRANSFER_CODE_NO_PREFIX);
            $chk_first_string_after_transfer_prefix=$transfer_string[$transfer_prefix_len];
            // echo $chk_first_string_after_transfer_prefix;
            // die();
            if($chk_first_string_after_transfer_prefix =='0'){
                $transfer_no_prefix=ASSETS_TRANSFER_CODE_NO_PREFIX.CUR_FISCALYEAR;
            }
            else if ($cur_fiscalyrs_transferno->prin_fiscalyrs==$currentfyrs && $chk_first_string_after_transfer_prefix =='0' ) {
                $transfer_no_prefix=ASSETS_TRANSFER_CODE_NO_PREFIX.CUR_FISCALYEAR;
            }
            else if ($cur_fiscalyrs_transferno->prin_fiscalyrs!=$currentfyrs && $chk_first_string_after_transfer_prefix =='0' ) {
                $transfer_no_prefix=ASSETS_TRANSFER_CODE_NO_PREFIX.CUR_FISCALYEAR;
            }
            else if ($cur_fiscalyrs_transferno->prin_fiscalyrs!=$currentfyrs && $chk_first_string_after_transfer_prefix !='0' ) {
                $transfer_no_prefix=ASSETS_TRANSFER_CODE_NO_PREFIX.CUR_FISCALYEAR;
            }
            else{
                $transfer_no_prefix=ASSETS_TRANSFER_CODE_NO_PREFIX;
            }
        }
        else{
            $transfer_no_prefix=ASSETS_TRANSFER_CODE_NO_PREFIX.CUR_FISCALYEAR;
        }
        // die();
        $transfer_code = $this->general->generate_invoiceno('astm_transferno','astm_transferno','astm_assettransfermaster',$transfer_no_prefix,ASSETS_TRANSFER_CODE_NO_LENGTH,false,'astm_locationid');
            $transferMasterArr=array(
                'astm_fiscalyrs'=>$astm_fiscalyrs,
                'astm_transferno'=>$transfer_code,
                'astm_transfertypeid'=>$astm_transfertypeid,
                'astm_from'=>$astm_from,
                'astm_to'=>$astm_to,
                'astm_manualno'=>$astm_manualno,
                'astm_transferdatebs'=>$transferdatebs,
                'astm_transferdatead'=>$transferdatead,
                'astm_noofassets'=>$asset_cnt,
                'astm_status'=>'O',
                'astm_remark'=>$fullremarks,
                'astm_postdatead'=>CURDATE_EN,
                'astm_postdatebs'=>CURDATE_NP,
                'astm_posttime'=>date('H:i:s'),
                'astm_postby'=> $this->userid,
                'astm_postip'=> $this->ip,
                'astm_postmac'=>$this->mac,
                'astm_locationid'=> $this->locationid,
                'astm_orgid'=>$this->orgid
            );
            if(!empty($transferMasterArr)){
                if(ORGANIZATION_NAME=='KU'){
                    $transferMasterArr['astm_fromschoolid']=$from_schoolid;
                    $transferMasterArr['astm_toschoolid']=$to_schoolid;
                    $transferMasterArr['astm_receivedstaffid']=!empty($staff_info[0])?$staff_info[0]:'';
                    $transferMasterArr['astm_receivedby']=!empty($staff_info[1])?$staff_info[1]:'';
                }
                $this->db->insert('astm_assettransfermaster',$transferMasterArr);
                  $insertid=$this->db->insert_id();
                  $transferDetail=array();
                    if($insertid){
                        $assetsid_arr=array();
                        if(!empty($assetid)):
                            foreach ($assetid as $kdw => $dlist) {
                                $assetsid_arr[]=!empty($assetid[$kdw])?$assetid[$kdw]:'';
                                $asset_detail = $this->db->select('asen_asenid, asen_desc, asen_staffid, asen_purchaserate, asen_remarks')->from('asen_assetentry')->where('asen_asenid',$dlist)->get()->row();

                                $transferDetail[]=array(
                                    'astd_assetetransfermasterid'=>$insertid,
                                    'astd_assetsid'=>!empty($assetid[$kdw])?$assetid[$kdw]:'',
                                    // 'astd_assetsdesc'=>!empty($assets_desc[$kdw])?$assets_desc[$kdw]:'',
                                    // 'astd_originalamt'=>!empty($assets_orginalval[$kdw])?$assets_orginalval[$kdw]:'',
                                    // 'astd_remark'=>!empty($remarks[$kdw])?$remarks[$kdw]:'',
                                    // 'astd_prev_staffid'=>!empty($staffid[$kdw])?$staffid[$kdw]:'',
                                    'astd_assetsdesc' => $asset_detail->asen_desc ?? '',
                                    'astd_originalamt' => $asset_detail->asen_purchaserate ?? '',
                                    'astd_currentamt'=>!empty($assets_currentval[$kdw])?$assets_currentval[$kdw]:'',
                                    'astd_remark'=> $asset_detail->asen_remarks ?? '',
                                    'astd_prev_staffid'=> $asset_detail->asen_staffid ?? '',
                                    'astd_prev_staffname'=>!empty($assets_prev_staffname[$kdw])?$assets_prev_staffname[$kdw]:'',
                                    
                                    'astd_status'=>'O',
                                    'astd_postdatead'=>CURDATE_EN,
                                    'astd_postdatebs'=>CURDATE_NP,
                                    'astd_posttime'=>date('H:i:s'),
                                    'astd_postby'=>$this->userid,
                                    'astd_postip'=>$this->ip,
                                    'astd_postmac'=>$this->mac,
                                    'astd_locationid'=>$this->locationid,
                                    'astd_orgid'=>$this->orgid
                                ); 
                    }
                endif;
                    if(!empty($transferDetail)){
                        $this->db->insert_batch('astd_assettransferdetail',$transferDetail);
                        if(!empty($assetsid_arr)){
                            if($astm_transfertypeid=='D'){ 
                                $this->db->set('asen_depid',$astm_to);
                                $this->db->set('asen_schoolid',$to_schoolid);
                                if(!empty($received_staff_infoid)){
                                    $this->db->set('asen_staffid',$received_staff_infoid);
                                }
                                $this->db->where_in('asen_asenid',$assetsid_arr); 
                                $this->db->update('asen_assetentry');
                             }
                             else if($astm_transfertypeid=='B'){
                                if(ORGANIZATION_NAME=='KU'){
                                    $this->db->set('asen_schoolid',$to_schoolid);
                                }else{
                                      $this->db->set('asen_locationid',$astm_to);
                                }
                                 $this->db->where_in('asen_asenid',$assetsid_arr);  
                                 $this->db->update('asen_assetentry');
                             }
                      }
                }
            }
        }
         $this->db->trans_complete();
         // $this->db->trans_commit();
           // return true;
       if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return $insertid;
        }
     }catch(Exception $e){
            $this->db->trans_rollback();
                return false;
            throw $e;
        }
    }

    public function cancel_asset_transfer()
    {
        try{

            $astm_masterid = $this->input->post('id');
            $this->db->select('astm_assettransfermasterid,astm_status');
            $this->db->from('astm_assettransfermaster');
            $this->db->where('astm_assettransfermasterid', $astm_masterid);
            $this->db->order_by('astm_assettransfermasterid', 'ASC');
            $tm_data = $this->db->get()->row();

            if (!empty($tm_data)) {

                $this->db->trans_begin();
                $rc_mid = $tm_data->astm_assettransfermasterid;
                $rc_status = $tm_data->astm_status;
                if ($rc_status == 'C') { // C=Cancel Status and O =Ok Status
                    print_r(json_encode(array('status' => 'error', 'message' => 'Transfer Receipt Already Cancelled')));
                    exit;
                }
                $update_transfer_masterArray = array(
                    'astm_status' => 'C'
                );
                $this->db->update('astm_assettransfermaster', $update_transfer_masterArray, array('astm_assettransfermasterid' => $rc_mid));

                $this->db->select('astd_assettransferdetailid,astd_assetsid,astd_prev_staffid,astd_prev_staffname');
                $this->db->from('astd_assettransferdetail');
                $this->db->where('astd_assetetransfermasterid', $rc_mid);
                $this->db->order_by('astd_assettransferdetailid', 'ASC');
                $transfer_details = $this->db->get()->result();

                // print_r($transfer_details);
                // die();
                
                if (count($transfer_details) > 0) {
                   
                   foreach ($transfer_details as $key => $tra_detail) {
                       $asset_id = $tra_detail->astd_assetsid; 
                       $update_asset_entry = array(
                        'asen_staffid' => $tra_detail->astd_prev_staffid,
                        'asen_receivedby' => $tra_detail->astd_prev_staffname,
                       );
                   }

                   $this->db->update('asen_assetentry', $update_asset_entry, array('asen_asenid' => $asset_id));

                    $this->db->update('astd_assettransferdetail', array('astd_status'=>'C'), array('astd_assettransferdetailid' => $tra_detail->astd_assettransferdetailid));
                }

            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
               return false;
            } else {
                $this->db->trans_commit();
               return $astm_masterid;
            }    
        }else{
            return false;
        }

        // $this->db->trans_complete();

        // if ($this->db->trans_status() === FALSE) {

        //     $this->db->trans_rollback();
        //     return false;
        // } else {
        //     $this->db->trans_commit();
        //     return $astm_masterid;
        // }

     }catch(Exception $e){

            $this->db->trans_rollback();

            return false;

            // throw $e;

        }
    }

     public function get_summary_list_of_assets_transfer($cond = false)
    {

        $get = $_GET;

        $frmDate=$this->input->get('frmDate');

        $toDate=$this->input->get('toDate');

        $fromDepid=$this->input->get('fromDepid');

        $toDepid=$this->input->get('toDepid');

        $transfertypeid=$this->input->get('transfertypeid');

        $locationfrom=$this->input->get('locationfrom');

        $locationto=$this->input->get('locationto');

        $input_locationid= !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');

        foreach ($get as $key => $value) {

            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));

        }

        if($this->location_ismain=='Y')

          {

            if($input_locationid)

            {

                $this->db->where('am.astm_locationid',$input_locationid);

            }

        }

        else

        {

             $this->db->where('am.astm_locationid',$this->locationid);

        }

   if($transfertypeid=='D')

{

         if(!empty(($fromDepid && $toDepid))){

                $this->db->where('am.astm_from =',$fromDepid);

                $this->db->where('am.astm_to =',$toDepid);    

        }

    }

    else{

          if(!empty(($locationfrom && $locationto))){

                $this->db->where('am.astm_from =',$locationfrom);

                $this->db->where('am.astm_to =',$locationto); 

    }

} 

        if(!empty(($frmDate && $toDate))){

            if(DEFAULT_DATEPICKER == 'NP'){

                $this->db->where('am.astm_transferdatebs >=',$frmDate);

                $this->db->where('am.astm_transferdatebs <=',$toDate);    

            }else{

                $this->db->where('am.astm_transferdatead >=',$frmDate);

                $this->db->where('am.astm_transferdatead <=',$toDate);

            }

        }

        if(!empty($get['sSearch_0'])){

            $this->db->where("astm_assettransfermasterid like  '%".$get['sSearch_0']."%'  ");

        }

        if(!empty($get['sSearch_1'])){

            $this->db->where("astm_transferdatead like  '%".$get['sSearch_1']."%'  ");

        }

        if(!empty($get['sSearch_2'])){

            $this->db->where("astm_transferdatebs like  '%".$get['sSearch_2']."%'  ");

        }

        if(!empty($get['sSearch_3'])){

            $this->db->where("astm_transferno like  '%".$get['sSearch_3']."%'  ");

        }

        if(!empty($get['sSearch_4'])){

            $this->db->where("woma_noticeno like  '%".$get['sSearch_4']."%'  ");

        }

        if(!empty($get['sSearch_5'])){

            $this->db->where("p.prin_project_title like  '%".$get['sSearch_5']."%'  ");

        }

        if(!empty($get['sSearch_6'])){

            $this->db->where("d.dist_distributor like  '%".$get['sSearch_6']."%'  ");

        }

         if(!empty($get['sSearch_7'])){

            $this->db->where("astm_manualno like  '%".$get['sSearch_7']."%'  ");

        }

         if(!empty($get['sSearch_8'])){

            $this->db->where("woma_fiscalyrs like  '%".$get['sSearch_8']."%'  ");

        }

          if($cond) {

          $this->db->where($cond);

        }

       //  

        $resltrpt=$this->db->select("COUNT('*') as cnt")

                    ->from('astm_assettransfermaster am')

                    ->get()->row();

        //echo $this->db->last_query();die(); 

         $totalfilteredrecs=0;

         if(!empty($resltrpt)){

            $totalfilteredrecs=$resltrpt->cnt;      

         }

        $order_by = 'astm_assettransfermasterid';

        $order = 'desc';

        if($this->input->get('sSortDir_0'))

        {

                $order = $this->input->get('sSortDir_0');

        }

        $where='';

        if($this->input->get('iSortCol_0')==0)

            $order_by = 'astm_assettransfermasterid';

        else if($this->input->get('iSortCol_0')==1)

            $order_by = 'astm_transferdatead';

        else if($this->input->get('iSortCol_0')==2)

            $order_by = 'astm_transferdatebs';

        else if($this->input->get('iSortCol_0')==3)

            $order_by = 'astm_transferno';

        else if($this->input->get('iSortCol_0')==4)

            $order_by = 'woma_noticeno';

        else if($this->input->get('iSortCol_0')==5)

            $order_by = 'prin_project_title';

        else if($this->input->get('iSortCol_0')==6)

            $order_by = 'dist_distributor';

         else if($this->input->get('iSortCol_0')==7)

            $order_by = 'astm_manualno';

         else if($this->input->get('iSortCol_0')==8)

            $order_by = 'woma_fiscalyrs';

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

          if($this->location_ismain=='Y')

          {

            if($input_locationid)

            {

                $this->db->where('am.astm_locationid',$input_locationid);

            }

        }

        else

        {

             $this->db->where('am.astm_locationid',$this->locationid);

        }

   if($transfertypeid=='D')

{

         if(!empty(($fromDepid && $toDepid))){

                $this->db->where('am.astm_from =',$fromDepid);

                $this->db->where('am.astm_to =',$toDepid);    

        }

    }

    else{

          if(!empty(($locationfrom && $locationto))){

                $this->db->where('am.astm_from =',$locationfrom);

                $this->db->where('am.astm_to =',$locationto); 

    }

} 

        if(!empty(($frmDate && $toDate))){

            if(DEFAULT_DATEPICKER == 'NP'){

                $this->db->where('am.astm_transferdatebs >=',$frmDate);

                $this->db->where('am.astm_transferdatebs <=',$toDate);    

            }else{

                $this->db->where('am.astm_transferdatead >=',$frmDate);

                $this->db->where('am.astm_transferdatead <=',$toDate);

            }

        }

       if(!empty($get['sSearch_0'])){

            $this->db->where("astm_assettransfermasterid like  '%".$get['sSearch_0']."%'  ");

        }

        if(!empty($get['sSearch_1'])){

            $this->db->where("astm_transferdatead like  '%".$get['sSearch_1']."%'  ");

        }

        if(!empty($get['sSearch_2'])){

            $this->db->where("astm_transferdatebs like  '%".$get['sSearch_2']."%'  ");

        }

        if(!empty($get['sSearch_3'])){

            $this->db->where("astm_transferno like  '%".$get['sSearch_3']."%'  ");

        }

        if(!empty($get['sSearch_4'])){

            $this->db->where("woma_noticeno like  '%".$get['sSearch_4']."%'  ");

        }

        if(!empty($get['sSearch_5'])){

            $this->db->where("p.prin_project_title like  '%".$get['sSearch_5']."%'  ");

        }

        if(!empty($get['sSearch_6'])){

            $this->db->where("d.dist_distributor like  '%".$get['sSearch_6']."%'  ");

        }

         if(!empty($get['sSearch_7'])){

            $this->db->where("astm_manualno like  '%".$get['sSearch_7']."%'  ");

        }

         if(!empty($get['sSearch_8'])){

            $this->db->where("astm_fiscalyrs like  '%".$get['sSearch_8']."%'  ");

        }

        if($cond) {

          $this->db->where($cond);

        }

       $this->db->select("am.*,df.dept_depname fromdep,dto.dept_depname todep,lf.loca_name fromlocation,lto.loca_name tolocation")

                    ->from('astm_assettransfermaster am')

                    ->join('dept_department df','df.dept_depid = am.astm_from AND astm_transfertypeid="D"' ,'LEFT')

                    ->join('dept_department dto','dto.dept_depid = am.astm_to AND astm_transfertypeid="D"' ,'LEFT')

                    ->join('loca_location lf','lf.loca_locationid = am.astm_from AND astm_transfertypeid="B"' ,'LEFT')

                     ->join('loca_location lto','lto.loca_locationid = am.astm_to AND astm_transfertypeid="B"' ,'LEFT');

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

    public function get_summary_list_of_assets_transfer_ku($cond = false)
    {

        $get = $_GET;
        $frmDate=$this->input->get('frmDate');
        $toDate=$this->input->get('toDate');
        $from_schoolid=$this->input->get('from_schoolid');
        $fromdepid=$this->input->get('fromDepid');
        $subdepid=$this->input->get('subdepid');
        $to_schoolid=$this->input->get('to_schoolid');
        $todepid=$this->input->get('toDepid');
        $to_subdepid=$this->input->get('to_subdepid');

        $input_locationid= !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');

        foreach ($get as $key => $value) {

            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));

        }

        if(!empty($fromdepid)){
         $check_parentid=$this->general->get_tbl_data('dept_depid, ','dept_department',array('dept_depid'=>$fromdepid),'dept_depname','ASC');
            }
            $subdeparray=array();
            if(!empty($check_parentid)){
            $parentdepid=!empty($check_parentid[0]->dept_parentdepid)?$check_parentid[0]->dept_parentdepid:'0';
            if($parentdepid=='0'){
            $subdep_result=$this->general->get_tbl_data('dept_depid','dept_department',array('dept_parentdepid'=>$fromdepid),'dept_depname','ASC');
            if(!empty($subdep_result)){
                foreach ($subdep_result as $ksd => $dep) {
                  $subdeparray[]=$dep->dept_depid;
                }
            }
            }
        }

        if(!empty($todepid)){
         $check_parentid=$this->general->get_tbl_data('dept_depid,dept_parentdepid','dept_department',array('dept_depid'=>$todepid),'dept_depname','ASC');
            }
            $subdeptoarray=array();
            if(!empty($check_parentid)){
            $parentdepid=!empty($check_parentid[0]->dept_parentdepid)?$check_parentid[0]->dept_parentdepid:'0';
            if($parentdepid=='0'){

                $subdep_result=$this->general->get_tbl_data('dept_depid','dept_department',array('dept_parentdepid'=>$todepid),'dept_depname','ASC');

                if(!empty($subdep_result)){

                    foreach ($subdep_result as $ksd => $dep) {

                      $subdeptoarray[]=$dep->dept_depid;

                    }

                }
            }
           }
        if($this->location_ismain=='Y')
          {
            if($input_locationid)
            {
                $this->db->where('am.astm_locationid',$input_locationid);
            }
        }
        else{
             $this->db->where('am.astm_locationid',$this->locationid);
        }
        if(!empty($from_schoolid)){
            $this->db->where('am.astm_fromschoolid',$from_schoolid);
        }

        if(!empty($fromdepid)){
            if(!empty($subdepid)){
                $this->db->where('am.astm_from',$subdepid);
            }else{
            $this->db->where_in('am.astm_from',$subdeparray);
            }
        }
        // echo "<pre>";
        // print_r($subdeparray);
        // die();

        if(!empty($to_schoolid)){
            $this->db->where('am.astm_toschoolid',$to_schoolid);   
        }
          if(!empty($todepid)){
            if(!empty($subdepid)){
                $this->db->where('am.astm_to',$subdepid);
            }else{
            $this->db->where_in('am.astm_to',$subdeptoarray);

            }
        }

        if(!empty(($frmDate && $toDate))){

            if(DEFAULT_DATEPICKER == 'NP'){

                $this->db->where('am.astm_transferdatebs >=',$frmDate);

                $this->db->where('am.astm_transferdatebs <=',$toDate);    

            }else{

                $this->db->where('am.astm_transferdatead >=',$frmDate);

                $this->db->where('am.astm_transferdatead <=',$toDate);

            }

        }

        if(!empty($get['sSearch_0'])){

            $this->db->where("astm_assettransfermasterid like  '%".$get['sSearch_0']."%'  ");

        }

        if(!empty($get['sSearch_1'])){

            $this->db->where("astm_transferdatead like  '%".$get['sSearch_1']."%'  ");

        }

        if(!empty($get['sSearch_2'])){

            $this->db->where("astm_transferdatebs like  '%".$get['sSearch_2']."%'  ");

        }

        if(!empty($get['sSearch_3'])){

            $this->db->where("astm_transferno like  '%".$get['sSearch_3']."%'  ");

        }

        if(!empty($get['sSearch_6'])){

            $this->db->where("astm_manualno like  '%".$get['sSearch_6']."%'  ");

        }

         if(!empty($get['sSearch_7'])){

            $this->db->where("astm_fiscalyrs like  '%".$get['sSearch_7']."%'  ");

        } 
        if(!empty($get['sSearch_9'])){

            $this->db->where("astm_receivedby like  '%".$get['sSearch_9']."%'  ");

        }
        if(!empty($get['sSearch_10'])){

            $this->db->where("astm_remark like  '%".$get['sSearch_10']."%'  ");

        }

          if($cond) {

          $this->db->where($cond);

        }

       //  

        $resltrpt=$this->db->select("COUNT('*') as cnt")

                    ->from('astm_assettransfermaster am')
                    ->where('astm_status','O')

                    ->get()->row();

        //echo $this->db->last_query();die(); 

         $totalfilteredrecs=0;

         if(!empty($resltrpt)){

            $totalfilteredrecs=$resltrpt->cnt;      

         }

        $order_by = 'astm_assettransfermasterid';

        $order = 'desc';

        if($this->input->get('sSortDir_0'))

        {

                $order = $this->input->get('sSortDir_0');

        }

        $where='';

        if($this->input->get('iSortCol_0')==0)

            $order_by = 'astm_assettransfermasterid';

        else if($this->input->get('iSortCol_0')==1)

            $order_by = 'astm_transferdatead';

        else if($this->input->get('iSortCol_0')==2)

            $order_by = 'astm_transferdatebs';

        else if($this->input->get('iSortCol_0')==3)

            $order_by = 'astm_transferno';

        else if($this->input->get('iSortCol_0')==4)

            $order_by = 'dtf.dept_depname';

        else if($this->input->get('iSortCol_0')==5)

            $order_by = 'dtf.dept_depname';

        else if($this->input->get('iSortCol_0')==6)

            $order_by = 'astm_manualno';
        else if($this->input->get('iSortCol_0')==7)

            $order_by = 'astm_fiscalyrs';

        else if($this->input->get('iSortCol_0')==8)

            $order_by = 'astm_noofassets';

        else if($this->input->get('iSortCol_0')==9)

            $order_by = 'astm_receivedby';
         else if($this->input->get('iSortCol_0')==10)

            $order_by = 'astm_remark';

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

          if($this->location_ismain=='Y')
          {

            if($input_locationid)
            {
                $this->db->where('am.astm_locationid',$input_locationid);
            }

        }
        else
        {

             $this->db->where('am.astm_locationid',$this->locationid);

        }

         if(!empty($from_schoolid)){
            $this->db->where('am.astm_fromschoolid',$from_schoolid);
        }

        if(!empty($fromdepid)){
            if(!empty($subdepid)){
                $this->db->where('am.astm_from',$subdepid);
            }else{
            $this->db->where_in('am.astm_from',$subdeparray);

            }
        }

        if(!empty($to_schoolid)){
            $this->db->where('am.astm_toschoolid',$to_schoolid);   
        }
          if(!empty($todepid)){
            if(!empty($subdepid)){
                $this->db->where('am.astm_to',$subdepid);
            }else{
            $this->db->where_in('am.astm_to',$subdeptoarray);

            }
        }

        if(!empty(($frmDate && $toDate))){

            if(DEFAULT_DATEPICKER == 'NP'){

                $this->db->where('am.astm_transferdatebs >=',$frmDate);

                $this->db->where('am.astm_transferdatebs <=',$toDate);    

            }else{

                $this->db->where('am.astm_transferdatead >=',$frmDate);

                $this->db->where('am.astm_transferdatead <=',$toDate);

            }

        }

       if(!empty($get['sSearch_0'])){

            $this->db->where("astm_assettransfermasterid like  '%".$get['sSearch_0']."%'  ");

        }

        if(!empty($get['sSearch_1'])){

            $this->db->where("astm_transferdatead like  '%".$get['sSearch_1']."%'  ");

        }

        if(!empty($get['sSearch_2'])){

            $this->db->where("astm_transferdatebs like  '%".$get['sSearch_2']."%'  ");

        }

        if(!empty($get['sSearch_3'])){

            $this->db->where("astm_transferno like  '%".$get['sSearch_3']."%'  ");

        }

        if(!empty($get['sSearch_6'])){

            $this->db->where("astm_manualno like  '%".$get['sSearch_6']."%'  ");

        }

         if(!empty($get['sSearch_7'])){

            $this->db->where("astm_fiscalyrs like  '%".$get['sSearch_7']."%'  ");

        } 
        if(!empty($get['sSearch_9'])){

            $this->db->where("astm_receivedby like  '%".$get['sSearch_9']."%'  ");

        }
        if(!empty($get['sSearch_10'])){

            $this->db->where("astm_remark like  '%".$get['sSearch_10']."%'  ");

        }

        if($cond) {

          $this->db->where($cond);

        }

       // $this->db->select("am.*,df.dept_depname fromdep,dto.dept_depname todep,lf.loca_name fromlocation,lto.loca_name tolocation")

       //              ->from('astm_assettransfermaster am')

       //              ->join('dept_department df','df.dept_depid = am.astm_from AND astm_transfertypeid="D"' ,'LEFT')

       //              ->join('dept_department dto','dto.dept_depid = am.astm_to AND astm_transfertypeid="D"' ,'LEFT')

       //              ->join('loca_location lf','lf.loca_locationid = am.astm_from AND astm_transfertypeid="B"' ,'LEFT')

       //               ->join('loca_location lto','lto.loca_locationid = am.astm_to AND astm_transfertypeid="B"' ,'LEFT');

        $this->db->select("am.*,scf.loca_name fromlocation, sct.loca_name tolocation,dtf.dept_depname fromdep,dtfp.dept_depname fromdepparent,dtt.dept_depname todep,dttp.dept_depname todepparent")
       ->from('astm_assettransfermaster am')
       // ->join('astd_assettransferdetail ad','ad.astd_assetetransfermasterid = am.astm_assettransfermasterid' ,'LEFT')
       // ->join('asen_assetentry ae','ae.asen_asenid=ad.astd_assetsid','LEFT')
       // ->join('itli_itemslist il','il.itli_itemlistid=ae.asen_description','LEFT')
       ->join('loca_location scf','am.astm_fromschoolid=scf.loca_locationid','LEFT')
       ->join('loca_location sct','am.astm_toschoolid=sct.loca_locationid','LEFT')
       ->join('dept_department dtf','am.astm_from=dtf.dept_depid','LEFT')
       ->join('dept_department dtfp','dtfp.dept_depid=dtf.dept_parentdepid','LEFT')
        ->join('dept_department dtt','am.astm_to=dtt.dept_depid','LEFT')
       ->join('dept_department dttp','dttp.dept_depid=dtt.dept_parentdepid','LEFT')
       ->where('am.astm_status','O');
       // ->group_by('am.astm_assettransfermasterid');

        // $cntitemQty="(SELECT COUNT(*) as cntitem from xw_astd_assettransferdetail atd WHERE atd.astd_assetetransfermasterid = am.astm_assettransfermasterid) as cntitem";
                    
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

      public function get_detail_list_of_assets_transfer($cond = false)
    {

        $get = $_GET;

        $frmDate=$this->input->get('frmDate');

        $toDate=$this->input->get('toDate');

        $fromDepid=$this->input->get('fromDepid');

        $toDepid=$this->input->get('toDepid');

        $transfertypeid=$this->input->get('transfertypeid');

        $locationfrom=$this->input->get('locationfrom');

        $locationto=$this->input->get('locationto');

        $input_locationid= !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');

        foreach ($get as $key => $value) {

            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));

        }

        if($this->location_ismain=='Y')

          {

            if($input_locationid)

            {

                $this->db->where('ad.astd_locationid',$input_locationid);

            }

        }

        else

        {

             $this->db->where('ad.astd_locationid',$this->locationid);

        }

if($transfertypeid=='D')

{

         if(!empty(($fromDepid && $toDepid))){

                $this->db->where('am.astm_from =',$fromDepid);

                $this->db->where('am.astm_to =',$toDepid);    

        }

    }

    else{

          if(!empty(($locationfrom && $locationto))){

                $this->db->where('am.astm_from =',$locationfrom);

                $this->db->where('am.astm_to =',$locationto); 

    }

}

        if(!empty(($frmDate && $toDate))){

            if(DEFAULT_DATEPICKER == 'NP'){

                $this->db->where('am.astm_transferdatebs >=',$frmDate);

                $this->db->where('am.astm_transferdatebs <=',$toDate);    

            }else{

                $this->db->where('am.astm_transferdatead >=',$frmDate);

                $this->db->where('am.astm_transferdatead <=',$toDate);

            }

        }

        if(!empty($get['sSearch_0'])){

            $this->db->where("astd_assettransferdetail like  '%".$get['sSearch_0']."%'  ");

        }

        if(!empty($get['sSearch_1'])){

            $this->db->where("astm_transferdatead like  '%".$get['sSearch_1']."%'  ");

        }

        if(!empty($get['sSearch_2'])){

            $this->db->where("astm_transferdatebs like  '%".$get['sSearch_2']."%'  ");

        }

         if(!empty($get['sSearch_3'])){

            $this->db->where("astm_transferno like  '%".$get['sSearch_3']."%'  ");

        }

        if(!empty($get['sSearch_4'])){

            $this->db->where("astm_transfertypeid like  '%".$get['sSearch_4']."%'  ");

        }

        if(!empty($get['sSearch_5'])){

            $this->db->where("astd_assetsid like  '%".$get['sSearch_5']."%'  ");

        }

        if(!empty($get['sSearch_6'])){

            $this->db->where("astd_assetsdesc like  '%".$get['sSearch_6']."%'  ");

        }

          if($cond) {

          $this->db->where($cond);

        }

       //  

        $resltrpt=$this->db->select("COUNT('*') as cnt")

                    ->from('astd_assettransferdetail ad')

                     ->join('astm_assettransfermaster am','ad.astd_assetetransfermasterid = am.astm_assettransfermasterid' ,'LEFT')

                    ->get()->row();

        //echo $this->db->last_query();die(); 

         $totalfilteredrecs=0;

         if(!empty($resltrpt)){

            $totalfilteredrecs=$resltrpt->cnt;      

         }

        $order_by = 'astd_assettransferdetailid';

        $order = 'desc';

        if($this->input->get('sSortDir_0'))

        {

                $order = $this->input->get('sSortDir_0');

        }

        $where='';

        if($this->input->get('iSortCol_0')==0)

            $order_by = 'astd_assettransferdetailid';

        else if($this->input->get('iSortCol_0')==1)

            $order_by = 'astm_transferdatead';

        else if($this->input->get('iSortCol_0')==2)

            $order_by = 'astm_transferdatebs';

        else if($this->input->get('iSortCol_0')==3)

            $order_by = 'astm_transferno';

        else if($this->input->get('iSortCol_0')==4)

            $order_by = 'astm_transfertypeid';

        else if($this->input->get('iSortCol_0')==5)

            $order_by = 'astd_assetsid';

        else if($this->input->get('iSortCol_0')==6)

            $order_by = 'astd_assetsdesc';

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

          if($this->location_ismain=='Y')

          {

            if($input_locationid)

            {

                $this->db->where('ad.astd_locationid',$input_locationid);

            }

        }

        else

        {

             $this->db->where('ad.astd_locationid',$this->locationid);

        }

 if($transfertypeid=='D')

{

         if(!empty(($fromDepid && $toDepid))){

                $this->db->where('am.astm_from =',$fromDepid);

                $this->db->where('am.astm_to =',$toDepid);    

        }

    }

    else{

          if(!empty(($locationfrom && $locationto))){

                $this->db->where('am.astm_from =',$locationfrom);

                $this->db->where('am.astm_to =',$locationto); 

    }

}       

 if(!empty(($frmDate && $toDate))){

            if(DEFAULT_DATEPICKER == 'NP'){

                $this->db->where('am.astm_transferdatebs >=',$frmDate);

                $this->db->where('am.astm_transferdatebs <=',$toDate);    

            }else{

                $this->db->where('am.astm_transferdatead >=',$frmDate);

                $this->db->where('am.astm_transferdatead <=',$toDate);

            }

        }

       if(!empty($get['sSearch_0'])){

            $this->db->where("astd_assettransferdetail like  '%".$get['sSearch_0']."%'  ");

        }

           if(!empty($get['sSearch_1'])){

            $this->db->where("astm_transferdatead like  '%".$get['sSearch_1']."%'  ");

        }

        if(!empty($get['sSearch_2'])){

            $this->db->where("astm_transferdatebs like  '%".$get['sSearch_2']."%'  ");

        }

         if(!empty($get['sSearch_3'])){

            $this->db->where("astm_transferno like  '%".$get['sSearch_3']."%'  ");

        }

        if(!empty($get['sSearch_4'])){

            $this->db->where("astm_transfertypeid like  '%".$get['sSearch_4']."%'  ");

        }

        if(!empty($get['sSearch_5'])){

            $this->db->where("astd_assetsid like  '%".$get['sSearch_5']."%'  ");

        }

        if(!empty($get['sSearch_6'])){

            $this->db->where("astd_assetsdesc like  '%".$get['sSearch_6']."%'  ");

        }

        if($cond) {

          $this->db->where($cond);

        }

       $this->db->select("am.*,ad.*,df.dept_depname fromdep,dto.dept_depname todep,lf.loca_name fromlocation,lto.loca_name tolocation,ae.asen_assetcode")

                ->from('astm_assettransfermaster am')
                ->join('astd_assettransferdetail ad','ad.astd_assetetransfermasterid = am.astm_assettransfermasterid' ,'LEFT')
                ->join('asen_assetentry ae','ae.asen_asenid=ad.astd_assetsid','LEFT')
                ->join('dept_department df','df.dept_depid = am.astm_from AND astm_transfertypeid="D"' ,'LEFT')
                ->join('dept_department dto','dto.dept_depid = am.astm_to AND astm_transfertypeid="D"' ,'LEFT')
                ->join('loca_location lf','lf.loca_locationid = am.astm_from AND astm_transfertypeid="B"' ,'LEFT')
                ->join('loca_location lto','lto.loca_locationid = am.astm_to AND astm_transfertypeid="B"' ,'LEFT')

                ->join('dept_department dtf','am.astm_from=dtf.dept_depid','LEFT')
                ->join('dept_department dtfp','dtfp.dept_depid=dtf.dept_parentdepid','LEFT')
                ->join('dept_department dtt','am.astm_to=dtt.dept_depid','LEFT')
                ->join('dept_department dttp','dttp.dept_depid=dtt.dept_parentdepid','LEFT');

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

    public function get_detail_list_of_assets_transfer_ku($cond = false)
    {

        $get = $_GET;

       $frmDate=$this->input->get('frmDate');
        $toDate=$this->input->get('toDate');
        $from_schoolid=$this->input->get('from_schoolid');
        $fromdepid=$this->input->get('fromDepid');
        $subdepid=$this->input->get('subdepid');
        $to_schoolid=$this->input->get('to_schoolid');
        $todepid=$this->input->get('toDepid');
        $to_subdepid=$this->input->get('to_subdepid');

        $input_locationid= !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');

    if(!empty($fromdepid)){
         $check_parentid=$this->general->get_tbl_data('dept_depid,dept_parentdepid','dept_department',array('dept_depid'=>$fromdepid),'dept_depname','ASC');
            }
            $subdeparray=array();
            if(!empty($check_parentid)){
            $parentdepid=!empty($check_parentid[0]->dept_parentdepid)?$check_parentid[0]->dept_parentdepid:'0';
            if($parentdepid=='0'){
            $subdep_result=$this->general->get_tbl_data('dept_depid','dept_department',array('dept_parentdepid'=>$fromdepid),'dept_depname','ASC');
            if(!empty($subdep_result)){
                foreach ($subdep_result as $ksd => $dep) {
                  $subdeparray[]=$dep->dept_depid;
                }
            }
            }
        }
if(!empty($todepid)){
         $check_parentid=$this->general->get_tbl_data('dept_depid,dept_parentdepid','dept_department',array('dept_depid'=>$todepid),'dept_depname','ASC');
            }
            $subdeptoarray=array();
            if(!empty($check_parentid)){
            $parentdepid=!empty($check_parentid[0]->dept_parentdepid)?$check_parentid[0]->dept_parentdepid:'0';
            if($parentdepid=='0'){

                $subdep_result=$this->general->get_tbl_data('dept_depid','dept_department',array('dept_parentdepid'=>$todepid),'dept_depname','ASC');

                if(!empty($subdep_result)){

                    foreach ($subdep_result as $ksd => $dep) {

                      $subdeptoarray[]=$dep->dept_depid;

                    }

                }
            }
           }
        if(!empty($from_schoolid)){
                    $this->db->where('am.astm_fromschoolid',$from_schoolid);
                }

                if(!empty($fromdepid)){
                    if(!empty($subdepid)){
                        $this->db->where('am.astm_from',$subdepid);
                    }else{
                    $this->db->where_in('am.astm_from',$subdeparray);
                    }
                }
        if(!empty($to_schoolid)){
                    $this->db->where('am.astm_toschoolid',$to_schoolid);   
                }
                  if(!empty($todepid)){
                    if(!empty($subdepid)){
                        $this->db->where('am.astm_to',$subdepid);
                    }else{
                    $this->db->where_in('am.astm_to',$subdeptoarray);

                    }
                }

        foreach ($get as $key => $value) {

            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));

        }

        if($this->location_ismain=='Y')

          {

            if($input_locationid){
                $this->db->where('ad.astd_locationid',$input_locationid);

            }
        }

        else
        {
            $this->db->where('ad.astd_locationid',$this->locationid);
        }

        if(!empty(($frmDate && $toDate))){
            if(DEFAULT_DATEPICKER == 'NP'){
                $this->db->where('am.astm_transferdatebs >=',$frmDate);
                $this->db->where('am.astm_transferdatebs <=',$toDate);    
            }else{

                $this->db->where('am.astm_transferdatead >=',$frmDate);

                $this->db->where('am.astm_transferdatead <=',$toDate);
            }
        }

        if(!empty($get['sSearch_0'])){

            $this->db->where("astd_assettransferdetail like  '%".$get['sSearch_0']."%'  ");

        }

        if(!empty($get['sSearch_1'])){

            $this->db->where("astm_transferdatead like  '%".$get['sSearch_1']."%'  ");

        }

        if(!empty($get['sSearch_2'])){

            $this->db->where("astm_transferdatebs like  '%".$get['sSearch_2']."%'  ");

        }

         if(!empty($get['sSearch_3'])){

            $this->db->where("astm_transferno like  '%".$get['sSearch_3']."%'  ");

        }

        if(!empty($get['sSearch_4'])){

            $this->db->where("astm_transfertypeid like  '%".$get['sSearch_4']."%'  ");

        }

        if(!empty($get['sSearch_5'])){

            $this->db->where("astd_assetsid like  '%".$get['sSearch_5']."%'  ");

        }

        if(!empty($get['sSearch_6'])){

            $this->db->where("astd_assetsdesc like  '%".$get['sSearch_6']."%'  ");

        }

          if($cond) {

          $this->db->where($cond);

        }

       //  

        $resltrpt=$this->db->select("COUNT('*') as cnt")

                    ->from('astd_assettransferdetail ad')

                     ->join('astm_assettransfermaster am','ad.astd_assetetransfermasterid = am.astm_assettransfermasterid' ,'LEFT')
                     ->where('astm_status','O')

                    ->get()->row();

        //echo $this->db->last_query();die(); 

         $totalfilteredrecs=0;

         if(!empty($resltrpt)){

            $totalfilteredrecs=$resltrpt->cnt;      

         }

        $order_by = 'astd_assettransferdetailid';

        $order = 'desc';

        if($this->input->get('sSortDir_0'))

        {

                $order = $this->input->get('sSortDir_0');

        }

        $where='';

        if($this->input->get('iSortCol_0')==0)

            $order_by = 'astd_assettransferdetailid';

        else if($this->input->get('iSortCol_0')==1)

            $order_by = 'astm_transferdatead';

        else if($this->input->get('iSortCol_0')==2)

            $order_by = 'astm_transferdatebs';

        else if($this->input->get('iSortCol_0')==3)

            $order_by = 'astm_transferno';

        else if($this->input->get('iSortCol_0')==4)

            $order_by = 'astm_transfertypeid';

        else if($this->input->get('iSortCol_0')==5)

            $order_by = 'astd_assetsid';

        else if($this->input->get('iSortCol_0')==6)

            $order_by = 'astd_assetsdesc';

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

          if($this->location_ismain=='Y')

          {

            if($input_locationid)

            {

                $this->db->where('ad.astd_locationid',$input_locationid);

            }

        }

        else

        {

             $this->db->where('ad.astd_locationid',$this->locationid);

        }

 if(!empty(($frmDate && $toDate))){

            if(DEFAULT_DATEPICKER == 'NP'){

                $this->db->where('am.astm_transferdatebs >=',$frmDate);

                $this->db->where('am.astm_transferdatebs <=',$toDate);    

            }else{

                $this->db->where('am.astm_transferdatead >=',$frmDate);

                $this->db->where('am.astm_transferdatead <=',$toDate);

            }

        }

        if(!empty($from_schoolid)){
                    $this->db->where('am.astm_fromschoolid',$from_schoolid);
                }

                if(!empty($fromdepid)){
                    if(!empty($subdepid)){
                        $this->db->where('am.astm_from',$subdepid);
                    }else{
                    $this->db->where_in('am.astm_from',$subdeparray);
                    }
                }
        if(!empty($to_schoolid)){
                    $this->db->where('am.astm_toschoolid',$to_schoolid);   
                }
                  if(!empty($todepid)){
                    if(!empty($subdepid)){
                        $this->db->where('am.astm_to',$subdepid);
                    }else{
                    $this->db->where_in('am.astm_to',$subdeptoarray);

                    }
                }

       if(!empty($get['sSearch_0'])){

            $this->db->where("astd_assettransferdetail like  '%".$get['sSearch_0']."%'  ");

        }

           if(!empty($get['sSearch_1'])){

            $this->db->where("astm_transferdatead like  '%".$get['sSearch_1']."%'  ");

        }

        if(!empty($get['sSearch_2'])){

            $this->db->where("astm_transferdatebs like  '%".$get['sSearch_2']."%'  ");

        }

         if(!empty($get['sSearch_3'])){

            $this->db->where("astm_transferno like  '%".$get['sSearch_3']."%'  ");

        }

        if(!empty($get['sSearch_4'])){

            $this->db->where("astm_transfertypeid like  '%".$get['sSearch_4']."%'  ");

        }

        if(!empty($get['sSearch_5'])){

            $this->db->where("astd_assetsid like  '%".$get['sSearch_5']."%'  ");

        }

        if(!empty($get['sSearch_6'])){

            $this->db->where("astd_assetsdesc like  '%".$get['sSearch_6']."%'  ");

        }

        if($cond) {

          $this->db->where($cond);

        }

       $this->db->select("am.*,ad.*,ae.asen_assetcode,il.itli_itemname,scf.loca_name fromschoolname, sct.loca_name toschoolname,dtf.dept_depname fromdep,dtfp.dept_depname fromdepparent,dtt.dept_depname todep,dttp.dept_depname todepparent")
       ->from('astm_assettransfermaster am')
       ->join('astd_assettransferdetail ad','ad.astd_assetetransfermasterid = am.astm_assettransfermasterid' ,'LEFT')
       ->join('asen_assetentry ae','ae.asen_asenid=ad.astd_assetsid','LEFT')
       ->join('itli_itemslist il','il.itli_itemlistid=ae.asen_description','LEFT')
       ->join('loca_location scf','am.astm_fromschoolid=scf.loca_locationid','LEFT')
       ->join('loca_location sct','am.astm_toschoolid=sct.loca_locationid','LEFT')
       ->join('dept_department dtf','am.astm_from=dtf.dept_depid','LEFT')
       ->join('dept_department dtfp','dtfp.dept_depid=dtf.dept_parentdepid','LEFT')
        ->join('dept_department dtt','am.astm_to=dtt.dept_depid','LEFT')
       ->join('dept_department dttp','dttp.dept_depid=dtt.dept_parentdepid','LEFT')
       ->where('am.astm_status','O');

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

 public function get_assets_transfer_detail_data($srchcol=false){

        try{

        $this->db->select("tm.*,td.*,df.dept_depname fromdep,dto.dept_depname todep,lf.loca_name fromlocation,lto.loca_name tolocation,ae.asen_assetcode,ae.asen_desc")

        ->from('astm_assettransfermaster tm')

         ->join('astd_assettransferdetail td','td.astd_assetetransfermasterid = tm.astm_assettransfermasterid' ,'LEFT')

        ->join('asen_assetentry ae','ae.asen_asenid=td.astd_assetsid','LEFT')

        ->join('dept_department df','df.dept_depid = tm.astm_from AND astm_transfertypeid="D"' ,'LEFT')

       ->join('dept_department dto','dto.dept_depid = tm.astm_to AND astm_transfertypeid="D"' ,'LEFT')

        ->join('loca_location lf','lf.loca_locationid = tm.astm_from AND astm_transfertypeid="B"' ,'LEFT')

        ->join('loca_location lto','lto.loca_locationid = tm.astm_to AND astm_transfertypeid="B"' ,'LEFT');

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

      public function get_assets_transfer_detail_data_ku($srchcol=false){
        try{
        // $this->db->select("tm.*,td.*,ae.asen_assetcode,ae.asen_desc,il.itli_itemname")
        // ->from('astm_assettransfermaster tm')
        // ->join('astd_assettransferdetail td','td.astd_assetetransfermasterid = tm.astm_assettransfermasterid' ,'LEFT')
        // ->join('asen_assetentry ae','ae.asen_asenid=td.astd_assetsid','LEFT')
        // ->join('itli_itemslist il','il.itli_itemlistid=ae.asen_description','LEFT');

             $this->db->select("tm.*,td.*,ae.asen_assetcode,ae.asen_desc,il.itli_itemcode,il.itli_itemname,ut.unit_unitname,scf.loca_name fromschoolname, sct.loca_name toschoolname,dtf.dept_depname fromdep,dtfp.dept_depname fromdepparent,dtt.dept_depname todep,dttp.dept_depname todepparent,stin_fname,stin_mname,stin_lname")
               ->from('astm_assettransfermaster tm')
               ->join('astd_assettransferdetail td','td.astd_assetetransfermasterid = tm.astm_assettransfermasterid' ,'LEFT')
               ->join('asen_assetentry ae','ae.asen_asenid=td.astd_assetsid','LEFT')
               ->join('itli_itemslist il','il.itli_itemlistid=ae.asen_description','LEFT')
                ->join('unit_unit ut','ut.unit_unitid=il.itli_unitid','LEFT')
               ->join('loca_location scf','tm.astm_fromschoolid=scf.loca_locationid','LEFT')
               ->join('loca_location sct','tm.astm_toschoolid=sct.loca_locationid','LEFT')
               ->join('dept_department dtf','tm.astm_from=dtf.dept_depid','LEFT')
               ->join('dept_department dtfp','dtfp.dept_depid=dtf.dept_parentdepid','LEFT')
                ->join('dept_department dtt','tm.astm_to=dtt.dept_depid','LEFT')
               ->join('dept_department dttp','dttp.dept_depid=dtt.dept_parentdepid','LEFT')
               ->join('stin_staffinfo st','st.stin_staffinfoid=ae.asen_staffid','LEFT')
               ->where('tm.astm_status','O');

        if($srchcol){
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

public function get_all_asset_transfer_detail($srorgal=false,$limit=false,$offset=false,$order=false,$order_by=false)

    {

        $this->input->post();

          $this->db->select("am.*,ad.*,df.dept_depname fromdep,dto.dept_depname todep,lf.loca_name fromlocation,lto.loca_name tolocation")

                    ->from('astm_assettransfermaster am')

                      ->join('astd_assettransferdetail ad','ad.astd_assetetransfermasterid = am.astm_assettransfermasterid' ,'LEFT')

                    ->join('dept_department df','df.dept_depid = am.astm_from AND astm_transfertypeid="D"' ,'LEFT')

                    ->join('dept_department dto','dto.dept_depid = am.astm_to AND astm_transfertypeid="D"' ,'LEFT')

                    ->join('loca_location lf','lf.loca_locationid = am.astm_from AND astm_transfertypeid="B"' ,'LEFT')

                     ->join('loca_location lto','lto.loca_locationid = am.astm_to AND astm_transfertypeid="B"' ,'LEFT');

        if($srorgal)

        {

            $this->db->where($srorgal);

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

    public function get_all_asset_transfer_summary($srorgal=false,$limit=false,$offset=false,$order=false,$order_by=false)

    {

        $this->input->post();

          $this->db->select("am.*,ad.*,df.dept_depname fromdep,dto.dept_depname todep,lf.loca_name fromlocation,lto.loca_name tolocation")

                    ->from('astm_assettransfermaster am')

                      ->join('astd_assettransferdetail ad','ad.astd_assetetransfermasterid = am.astm_assettransfermasterid' ,'LEFT')

                    ->join('dept_department df','df.dept_depid = am.astm_from AND astm_transfertypeid="D"' ,'LEFT')

                    ->join('dept_department dto','dto.dept_depid = am.astm_to AND astm_transfertypeid="D"' ,'LEFT')

                    ->join('loca_location lf','lf.loca_locationid = am.astm_from AND astm_transfertypeid="B"' ,'LEFT')

                     ->join('loca_location lto','lto.loca_locationid = am.astm_to AND astm_transfertypeid="B"' ,'LEFT');

        if($srorgal)

        {

            $this->db->where($srorgal);

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

}