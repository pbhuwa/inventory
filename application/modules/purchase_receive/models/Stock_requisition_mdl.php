<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Stock_requisition_mdl extends CI_Model
{
    public function __construct()
    {
    parent::__construct();
    $this->stre_masterTable='rema_reqmaster';
    $this->stre_detailTable='rede_reqdetail';
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
                                'rema_postip'=>$ip                              
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
                                'rede_postip'=>$ip 
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
}