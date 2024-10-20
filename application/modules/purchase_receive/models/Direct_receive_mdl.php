<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Direct_receive_mdl extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->trma_masterTable='trma_transactionmain';
        $this->trma_detailTable='trde_transactiondetail';

        $this->curtime = $this->general->get_currenttime();
        $this->userid = $this->session->userdata(USER_ID);
        $this->username = $this->session->userdata(USER_NAME);
        $this->userdepid = $this->session->userdata(USER_DEPT); //storeid
        $this->storeid = $this->session->userdata(STORE_ID);
        $this->mac = $this->general->get_Mac_Address();
        $this->ip = $this->general->get_real_ipaddr();
        $this->locationid=$this->session->userdata(LOCATION_ID);
        $this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
    }
    
    public $validate_settings_stock_requisition = array(
    array('field' => 'receive_by', 'label' => 'Receiver Name ', 'rules' => 'trim|required|xss_clean'),
    );

    public function stock_requisition_save()
    {
        try{
            //echo "<pre>";print_r($this->input->post());die();
            $req_date=$this->input->post('receive_date');
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

            //master table
            $receive_no = $this->input->post('receive_no');
            $manual_no = $this->input->post('manual_no');
            $receive_date = $this->input->post('receive_date');
            $receive_from = $this->input->post('receive_from');
            $receive_to = $this->input->post('receive_to');
            $receive_by = $this->input->post('receive_by');
            $remarks = $this->input->post('remarks');
 
            $fromdepartmentid=$this->input->post('trma_fromdepartmentid');
            $todepartmentid=$this->input->post('trma_todepartmentid');

            $remarks = $this->input->post('trma_remarks');
            $trma_fromby = $this->input->post('trma_fromby');
               
            $trde_issueqty = $this->input->post('trde_issueqty');
            $itemsid = $this->input->post('trde_itemsid');
            $trde_itemsid =   $this->input->post('trde_itemsid');
            $trde_unitpercase =   $this->input->post('trde_unitpercase');
            $trde_unitprice =   $this->input->post('trde_unitprice');
            $trde_itemname = $this->input->post('itemname');

            //  $postdata = $this->input->post();
            // echo "<pre>";
            // print_r($postdata);
            // die();

            $curtime=$this->general->get_currenttime();
            $userid=$this->session->userdata(USER_ID);
            $mac=$this->general->get_Mac_Address();
            $ip=$this->general->get_real_ipaddr();
            $this->db->trans_begin();
            $ReqMasterArray = array(
                                'trma_manualno'=>$manual_no,
                                'trma_issueno' => $receive_no,
                                'trma_fromdepartmentid'=>$receive_from,
                                'trma_todepartmentid'=>$receive_to,
                                'trma_received' => '1',
                                'trma_transactiontype'=>'D.RECEIVE',
                                'trma_remarks'=>$remarks,
                                'trma_receivedby'=>$receive_by,
                                'trma_status'=>'O',
                                'trma_fyear' => CUR_FISCALYEAR,
                                'trma_transactiondatebs'=>$requstdateNp,
                                'trma_transactiondatead'=>$requstdateEn,
                                'trma_postdatead'=>CURDATE_EN,
                                'trma_postdatebs'=>CURDATE_NP,
                                'trma_posttime'=>$this->curtime,
                                'trma_postby'=>$this->userid,
                                'trma_postusername'=>$this->username,
                                'trma_postmac'=>$this->mac,
                                'trma_postip'=>$this->ip,
                                'trma_locationid'=>$this->locationid                             
                            );
            if(!empty($ReqMasterArray))
            {   //print_r($ReqMasterArray);die;
                $this->db->insert($this->trma_masterTable,$ReqMasterArray);
                $insertid=$this->db->insert_id();
                if($insertid)
                {
                    if(!empty($itemsid)):
                        foreach ($itemsid as $key => $val) {
                            $ReqDetail[]=array(
                                    'trde_trmaid'=>$insertid,
                                    'trde_mtmid'=> !empty($itemsid[$key])?$itemsid[$key]:'',
                                    'trde_itemsid'=> !empty($trde_itemsid[$key])?$trde_itemsid[$key]:'',
                                    'trde_unitpercase'=> !empty($trde_unitpercase[$key])?$trde_unitpercase[$key]:'',
                                    'trde_issueqty'=> !empty($trde_issueqty[$key])?$trde_issueqty[$key]:'',
                                    'trde_requiredqty'=> !empty($trde_issueqty[$key])?$trde_issueqty[$key]:'',
                                    'trde_transferqty' => 0,
                                    'trde_newissueqty' => !empty($trde_issueqty[$key])?$trde_issueqty[$key]:'',
                                    'trde_transactiontype'=>'D.RECEIVE',
                                    'trde_unitprice'=> !empty($trde_unitprice[$key])?$trde_unitprice[$key]:'',
                                    'trde_description'=> !empty($itemname[$key])?$itemname[$key]:'',
                                    'trde_postdatead'=>CURDATE_EN,
                                    'trde_postdatebs'=>CURDATE_NP,
                                    'trde_posttime'=>$curtime,
                                    'trde_postby'=>$userid,
                                    'trde_postmac'=>$mac,
                                    'trde_postip'=>$ip,
                                    'trde_locationid'=>$this->locationid  
                                );
                        }
                    endif;
                    if(!empty($ReqDetail))
                    {   //echo"<pre>";print_r($ReqDetail);die;
                        $this->db->insert_batch($this->trma_detailTable,$ReqDetail);
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