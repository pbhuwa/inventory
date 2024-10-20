<?php if (!defined('BASEPATH')) exit('No direct script access allowed');



class Repair_work_order_mdl extends CI_Model

{



    public function __construct()

    {

        parent::__construct();

        $this->userid = $this->session->userdata(USER_ID);

        $this->username = $this->session->userdata(USER_NAME);

        $this->curtime = $this->general->get_currenttime();

        $this->mac = $this->general->get_Mac_Address();

        $this->ip = $this->general->get_real_ipaddr();

        $this->locationid = $this->session->userdata(LOCATION_ID);

        $this->location_ismain = $this->session->userdata(ISMAIN_LOCATION);

        $this->orgid = $this->session->userdata(ORG_ID);
    }





    public $validate_settings_repair_work_order = array(

        array('field' => 'fiscalyear', 'label' => 'Fiscal Year', 'rules' => 'trim|required|xss_clean'),

        array('field' => 'repair_request_no', 'label' => 'Repair Request No', 'rules' => 'trim|required|xss_clean'),

        array('field' => 'workorder_date', 'label' => 'Work Order Date', 'rules' => 'trim|required|xss_clean'),

        array('field' => 'depid', 'label' => 'Department', 'rules' => 'trim|required|xss_clean'), 

        array('field' => 'distributorid', 'label' => 'Supplier', 'rules' => 'trim|required|xss_clean'),

        array('field' => 'delivery_date', 'label' => 'Delivery Date', 'rules' => 'trim|required|xss_clean'),

        array('field' => 'delivery_place', 'label' => 'Delivery Place ', 'rules' => 'trim|required|xss_clean'),

        array('field' => 'assets_code[]', 'label' => 'Assets Code ', 'rules' => 'trim|required|xss_clean'),

        array('field' => 'assets_desc[]', 'label' => 'Assets Description ', 'rules' => 'trim|required|xss_clean'),

        array('field' => 'estimated_cost[]', 'label' => 'Estimated Cost ', 'rules' => 'trim|required|xss_clean'),

        array('field' => 'problem[]', 'label' => 'Problem ', 'rules' => 'trim|required|xss_clean'),

    );


    public function repair_work_order_save()
    {
        try {

            $id = $this->input->post('id');

            $fyear = $this->input->post('fiscalyear');

            $repair_request_no = $this->input->post('repair_request_no');

            $workorder_date = $this->input->post('workorder_date');
            
            $distributorid = $this->input->post('distributorid');


            $rerm_estmatecost = $this->input->post('total_estimate');

            $delivery_date = $this->input->post('delivery_date');            

            $delivery_place = $this->input->post('delivery_place');

            $requestby = $this->input->post('requestby');
            
            $rewm_repairrequestmasterid = $this->input->post('rewm_repairrequestmasterid');



            if (DEFAULT_DATEPICKER == 'NP') {

                $workorder_datebs = $workorder_date;

                $workorder_datead = $this->general->NepToEngDateConv($workorder_date);

                $delivery_datebs = $delivery_date;

                $delivery_datead = $this->general->NepToEngDateConv($delivery_date);

            } else {

                $workorder_datead = $workorder_date;

                $workorder_datebs = $this->general->EngToNepDateConv($workorder_date);  

                $delivery_datead = $delivery_date;

                $delivery_datebs = $this->general->EngToNepDateConv($delivery_date);
            }

            $work_order_remarks = $this->input->post('work_order_remarks');



            /* For detail */

            $depid = $this->input->post('depid');

            $assetscode = $this->input->post('assets_code');

            $assetid = $this->input->post('asdd_assetid');

            $assetsdesc = $this->input->post('assets_desc');

            $problem = $this->input->post('problem');

            $estimated_cost = $this->input->post('estimated_cost');

            $prev_cnt = $this->input->post('prev_cnt');
            
            $prev_cost = $this->input->post('prev_cost');
            
            $prev_repair_datebs = $this->input->post('prev_repair_datebs');
            
            $prev_repair_datead = $this->input->post('prev_repair_datead');

            $remarks = $this->input->post('remarks');

            $asset_cnt = 0;

            if (!empty($assetid) && is_array($assetid)) {

                $asset_cnt = sizeof($assetid);
            }


            $currentfyrs = CUR_FISCALYEAR;

           $this->db->select('rewm_orderno,rewm_fiscalyrs')
            ->from('rewm_repairworkordermaster')
            ->where('rewm_locationid', $this->locationid);

            $cur_fiscalyrs_invoiceno = $this->db->order_by('rewm_fiscalyrs', 'DESC')
                ->limit(1)
                ->get()->row();

            if (!empty($cur_fiscalyrs_invoiceno)) {
                $invoice_format = $cur_fiscalyrs_invoiceno->rewm_orderno;

                $invoice_string = str_split($invoice_format);
                $invoice_prefix_len = strlen(REPAIR_WORK_ORDER_NO_PREFIX);
                $chk_first_string_after_invoice_prefix = $invoice_string[$invoice_prefix_len];
                if ($chk_first_string_after_invoice_prefix == '0') {
                    $invoice_no_prefix = REPAIR_WORK_ORDER_NO_PREFIX;
                } else if ($cur_fiscalyrs_invoiceno->rewm_fiscalyrs == $currentfyrs && $chk_first_string_after_invoice_prefix == '0') {
                    $invoice_no_prefix = REPAIR_WORK_ORDER_NO_PREFIX;
                } else if ($cur_fiscalyrs_invoiceno->rewm_fiscalyrs != $currentfyrs && $chk_first_string_after_invoice_prefix == '0') {
                    $invoice_no_prefix = REPAIR_WORK_ORDER_NO_PREFIX;
                } else if ($cur_fiscalyrs_invoiceno->rewm_fiscalyrs != $currentfyrs && $chk_first_string_after_invoice_prefix != '0') {
                    $invoice_no_prefix = REPAIR_WORK_ORDER_NO_PREFIX;
                } else {
                    $invoice_no_prefix = REPAIR_WORK_ORDER_NO_PREFIX;
                }
            } else {
                $invoice_no_prefix = REPAIR_WORK_ORDER_NO_PREFIX;
            }

            $this->db->trans_begin();

            if ($id) {

                // $request_detail_id = $this->input->post('request_detail_id');

                // $repairequestMasterArrUpdate = array(
                //     'rerm_fiscalyrs' => $fyear,
                //     'rerm_requestno' => $requestno,
                //     'rerm_reqdepid' => $reqdepid,
                //     'rerm_manualno' => $manualno,
                //     'rerm_requestdatebs' => $rerm_requestdatebs,
                //     'rerm_requestdatead' => $rerm_requestdatead,
                //     'rerm_estmatecost' => $rerm_estmatecost,
                //     'rerm_requestby' => $requestby,
                //     'rerm_remark' => $full_remarks,
                //     'rerm_noofassets' => $asset_cnt,
                //     'rerm_status' => 'O',
                //     'rerm_approved' => '0',
                //     'rerm_modifyby' => $this->userid,
                //     'rerm_modifydatead' => CURDATE_EN,
                //     'rerm_modifydatebs' => CURDATE_NP,
                //     'rerm_modifytime' => $this->curtime,
                //     'rerm_modifymac' => $this->mac,
                //     'rerm_modifyip' => $this->ip,
                //     'rerm_locationid' => $this->locationid,
                //     'rerm_orgid' => $this->orgid
                // );

                // if (!empty($repairequestMasterArrUpdate)) {
                //     $this->general->save_log('rerm_repairrequestmaster','rerm_repairrequestmasterid',$id,$repairequestMasterArrUpdate,'Edit');
                //     $this->db->update('rerm_repairrequestmaster', $repairequestMasterArrUpdate, array('rerm_repairrequestmasterid' => $id));
                // }

                // $old_request_list = $this->general->get_tbl_data('rerd_repairrequestdetailid', 'rerd_repairrequestdetail', array('rerd_repairrequestmasterid' => $id));
                // $old_request_det_id_array = array();

                // if (!empty($old_request_list)) {
                //     foreach ($old_request_list as $key => $value) {
                //         $old_request_det_id_array[] = $value->rerd_repairrequestdetailid;
                //     }
                // }
                // $rerd_insertid = array();

                // if (!empty($assetid)) :

                //     foreach ($assetid as $kdw => $dlist) {
                //         $detail_id = !empty($request_detail_id[$kdw]) ? $request_detail_id[$kdw] : '';
                //         if ($detail_id) {
                //             $repairReqDetailUpdate = array(
                //                 'rerd_assetsid' => !empty($assetid[$kdw]) ? $assetid[$kdw] : '',
                //                 'rerd_assetsdesc' => !empty($assetsdesc[$kdw]) ? $assetsdesc[$kdw] : '',
                //                 'rerd_assetcode' => !empty($assetscode[$kdw]) ? $assetscode[$kdw] : '',
                //                 'rerd_problem' => !empty($problem[$kdw]) ? $problem[$kdw] : '',
                //                 'rerd_estimateamt' => !empty($estimated_cost[$kdw]) ? $estimated_cost[$kdw] : '',
                //                 'rerd_remark' => !empty($remarks[$kdw]) ? $remarks[$kdw] : '',
                //                 'rerd_repairedstatus' => 'WR',
                //                 'rerd_status' => 'O',
                //                 'rerd_modifydatead' => CURDATE_EN,
                //                 'rerd_modifydatebs' => CURDATE_NP,
                //                 'rerd_modifytime' => $this->curtime,
                //                 'rerd_modifyby' => $this->userid,
                //                 'rerd_modifyip' => $this->ip,
                //                 'rerd_modifymac' => $this->mac,
                //                 'rerd_locationid' => $this->locationid,
                //                 'rerd_orgid' => $this->orgid
                //             );
                //             if (!empty($repairReqDetailUpdate)) {
                //                 $this->general->save_log('rerd_repairrequestdetail','rerd_repairrequestdetailid',$detail_id,$repairReqDetailUpdate,'Edit');
                //                 $this->db->update('rerd_repairrequestdetail', $repairReqDetailUpdate, array('rerd_repairrequestdetailid' => $detail_id));
                //                 $rerd_insertid[] = $detail_id;
                //             }
                //         } else {

                //             $repairReqDetailInsertArr = array(
                //                 'rerd_repairrequestmasterid' => $id,
                //                 'rerd_assetsid' => !empty($assetid[$kdw]) ? $assetid[$kdw] : '',
                //                 'rerd_assetsdesc' => !empty($assetsdesc[$kdw]) ? $assetsdesc[$kdw] : '',
                //                 'rerd_assetcode' => !empty($assetscode[$kdw]) ? $assetscode[$kdw] : '',
                //                 'rerd_problem' => !empty($problem[$kdw]) ? $problem[$kdw] : '',
                //                 'rerd_estimateamt' => !empty($estimated_cost[$kdw]) ? $estimated_cost[$kdw] : '',
                //                 'rerd_remark' => !empty($remarks[$kdw]) ? $remarks[$kdw] : '',
                //                 'rerd_repairedstatus' => 'WR',
                //                 'rerd_status' => 'O',
                //                 'rerd_postdatead' => CURDATE_EN,
                //                 'rerd_postdatebs' => CURDATE_NP,
                //                 'rerd_posttime' => $this->curtime,
                //                 'rerd_postby' => $this->userid,
                //                 'rerd_postip' => $this->ip,
                //                 'rerd_postmac' => $this->mac,
                //                 'rerd_locationid' => $this->locationid,
                //                 'rerd_orgid' => $this->orgid
                //             );

                //             $this->db->insert('rerd_repairrequestdetail', $repairReqDetailInsertArr);
                //             $rerd_insertid[] = $this->db->insert_id();
                //         }
                //     }

                //     if (is_array($rerd_insertid)) {
                //         $deleted_items = array_diff($old_request_det_id_array, $rerd_insertid);
                //     }
                //     if (is_array($deleted_items) && count($deleted_items)) {
                //         $this->db->where_in('rerd_repairrequestdetailid', $deleted_items);
                //         $this->db->delete('rerd_repairrequestdetail');
                //     }

                // endif;
            } else {

              $repair_orderno = $this->general->generate_invoiceno('rewm_orderno', 'rewm_orderno', 'rewm_repairworkordermaster', $invoice_no_prefix, REPAIR_WORK_ORDER_NO_LENGTH, false, 'rewm_locationid', 'rewm_fiscalyrs DESC ,rewm_repairordermasterid  DESC', 'M');

                $repairOrderMasterArr = array(
                    'rewm_repairrequestmasterid' =>$rewm_repairrequestmasterid,
                    'rewm_fiscalyrs' => $fyear,
                    'rewm_orderno' => $repair_orderno,
                    'rewm_rwodepid' => $depid,
                    'rewm_repairrequestno' => $repair_request_no,
                    'rewm_supplierid' => $distributorid,
                    'rewm_repairorderdatebs' => $workorder_datebs,
                    'rewm_repairorderdatead' => $workorder_datead,
                    'rewm_deliverydatebs' => $delivery_datebs,
                    'rewm_deliverydatead' => $delivery_datead,
                    'rewm_deliverysite' => $delivery_place,
                    'rewm_requestby' => $requestby,
                    'rewm_remark' => $work_order_remarks,
                    'rewm_status' => 'O',
                    'rewm_postdatead' => CURDATE_EN,
                    'rewm_postdatebs' => CURDATE_NP,
                    'rewm_posttime' => $this->curtime,
                    'rewm_postby' => $this->userid,
                    'rewm_postip' => $this->ip,
                    'rewm_postmac' => $this->mac,
                    'rewm_locationid' => $this->locationid,
                    'rewm_orgid' => $this->orgid
                );

                if (!empty($repairOrderMasterArr)) {

                    $this->db->insert('rewm_repairworkordermaster', $repairOrderMasterArr);

                    $insertid = $this->db->insert_id();

                    $repairOrderDetailArr = array();

                    if ($insertid) {
                        if (!empty($assetid)) :
                            foreach ($assetid as $kdw => $dlist) {
                                $repairOrderDetailArr[] = array(

                        'rewd_repairordermasterid' => $insertid,
                        'rewd_assetsid' => !empty($assetid[$kdw]) ? $assetid[$kdw] : '',
                        'rewd_assetsdesc' => !empty($assetsdesc[$kdw]) ? $assetsdesc[$kdw] : '',
                        'rewd_assetcode' => !empty($assetscode[$kdw]) ? $assetscode[$kdw] : '',
                        'rewd_problem' => !empty($problem[$kdw]) ? $problem[$kdw] : '',
                        'rewd_estimated_cost' => !empty($estimated_cost[$kdw]) ? $estimated_cost[$kdw] : '',
                        'rewd_remarks' => !empty($remarks[$kdw]) ? $remarks[$kdw] : '', 
                        'rewd_prevrepaircount' => !empty($prev_cnt[$kdw]) ? $prev_cnt[$kdw] : '',
                        'rewd_prevrepaircost' => !empty($prev_cost[$kdw]) ? $prev_cost[$kdw] : '',
                        'rewd_prevrepairdatead' => !empty($prev_repair_datead[$kdw]) ? $prev_repair_datead[$kdw] : '',
                        'rewd_prerepairdatebs' => !empty($prev_repair_datebs[$kdw]) ? $prev_repair_datebs[$kdw] : '',
                        'rewd_status' => 'O',
                        'rewd_postdatead' => CURDATE_EN,
                        'rewd_postdatebs' => CURDATE_NP,
                        'rewd_posttime' => $this->curtime,
                        'rewd_postby' => $this->userid,
                        'rewd_postip' => $this->ip,
                        'rewd_postmac' => $this->mac,
                        'rewd_locationid' => $this->locationid,
                        'rewd_orgid' => $this->orgid
                                );
                            }
                        endif;
                        if (!empty($repairOrderDetailArr)) {
                            $this->db->insert_batch('xw_rewd_repairworkorderdetail', $repairOrderDetailArr);
                        }

                        $this->db->where('rerm_repairrequestmasterid',$rewm_repairrequestmasterid);
                        $this->db->update('rerm_repairrequestmaster',array('rerm_status' => 'WO'));
                    }
                }
            }

            $this->db->trans_complete();
            $this->db->trans_commit();
            if ($id) {
                return $id;
            }else{
                return $insertid;
            }
        } catch (Exception $e) {

            $this->db->trans_rollback();
            return false;
            throw $e;
        }
    }



    public function get_summary_list_of_repair_order($cond = false)

    {

        $get = $_GET;

        $frmDate = $this->input->get('frmDate');

        $toDate = $this->input->get('toDate');

        $departmentid = $this->input->get('departmentid'); 

        $distributorid = $this->input->get('distributorid');

        $input_locationid = !empty($get['locationid']) ? $get['locationid'] : $this->input->post('locationid');

        foreach ($get as $key => $value) {

            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }

        $this->db->start_cache();

        if ($this->location_ismain == 'Y') {

            if ($input_locationid) {

                $this->db->where('rm.rewm_locationid', $input_locationid);
            }
        } else {

            $this->db->where('rm.rewm_locationid', $this->locationid);
        }



        if (!empty(($frmDate && $toDate))) {

            if (DEFAULT_DATEPICKER == 'NP') {

                $this->db->where('rm.rewm_repairorderdatebs >=', $frmDate);

                $this->db->where('rm.rewm_repairorderdatebs <=', $toDate);
            } else {

                $this->db->where('rm.rewm_repairorderdatead >=', $frmDate);

                $this->db->where('rm.rewm_repairorderdatead <=', $toDate);
            }
        }

        if (!empty($departmentid)) {
            $this->db->where("rewm_rwodepid",$departmentid);
        }        

        if (!empty($distributorid)) {
            $this->db->where("rewm_supplierid",$distributorid);
        }


        if (!empty($get['sSearch_0'])) {

            $this->db->where("rewm_repairordermasterid like  '%" . $get['sSearch_0'] . "%'  ");
        }

        if (!empty($get['sSearch_1'])) {

            $this->db->where("rewm_repairorderdatead like  '%" . $get['sSearch_1'] . "%'  ");
        }

        if (!empty($get['sSearch_2'])) {

            $this->db->where("rewm_repairorderdatebs like  '%" . $get['sSearch_2'] . "%'  ");
        }

        if (!empty($get['sSearch_3'])) {

            $this->db->where("rewm_orderno like  '%" . $get['sSearch_3'] . "%'  ");
        }

        if (!empty($get['sSearch_4'])) {

            $this->db->where("df.dept_depname like  '%" . $get['sSearch_4'] . "%'  ");
        }

        if (!empty($get['sSearch_5'])) {

            $this->db->where("rewm_requestby like  '%" . $get['sSearch_5'] . "%'  ");
        }

        if (!empty($get['sSearch_6'])) {

            $this->db->where("ds.dist_distributor like  '%" . $get['sSearch_6'] . "%'  ");
        }

        if (!empty($get['sSearch_7'])) {

            $this->db->where("rewm_deliverysite like  '%" . $get['sSearch_7'] . "%'  ");
        }

        if (!empty($get['sSearch_8'])) {

            $this->db->where("rewm_deliverydatebs like  '%" . $get['sSearch_8'] . "%'  ");
        }

        if ($cond) {

            $this->db->where($cond);
        }

        $this->db->stop_cache();

        $resltrpt = $this->db->select("COUNT('*') as cnt")

            ->from('rewm_repairworkordermaster rm')

            ->get()->row();


        $totalfilteredrecs = 0;

        if (!empty($resltrpt)) {

            $totalfilteredrecs = $resltrpt->cnt;
        }



        $order_by = 'rewm_repairordermasterid';

        $order = 'desc';

        if ($this->input->get('sSortDir_0')) {

            $order = $this->input->get('sSortDir_0');
        }

        $where = '';

        if ($this->input->get('iSortCol_0') == 0)

            $order_by = 'rewm_repairordermasterid';

        else if ($this->input->get('iSortCol_0') == 1)

            $order_by = 'rewm_repairorderdatead';

        else if ($this->input->get('iSortCol_0') == 2)

            $order_by = 'rewm_repairorderdatebs';

        else if ($this->input->get('iSortCol_0') == 3)

            $order_by = 'rewm_orderno';

        else if ($this->input->get('iSortCol_0') == 4)

            $order_by = 'dept_depname';

        else if ($this->input->get('iSortCol_0') == 5)

            $order_by = 'rewm_requestby';

        else if ($this->input->get('iSortCol_0') == 6)

            $order_by = 'dist_distributor';

        else if ($this->input->get('iSortCol_0') == 7)

            $order_by = 'rewm_deliverysite';

        else if ($this->input->get('iSortCol_0') == 8)

            $order_by = 'rewm_deliverydatebs';

        $totalrecs = '';

        $limit = 15;

        $offset = 0;

        if (!empty($_GET["iDisplayLength"])) {

            $limit = $_GET['iDisplayLength'];

            $offset = $_GET["iDisplayStart"];
        }



        $this->db->select("rm.*,df.dept_depname,loc.loca_name,ds.dist_distributor")

            ->from('rewm_repairworkordermaster rm')

            ->join('dept_department df', 'df.dept_depid = rm.rewm_rwodepid', 'LEFT')

            ->join('loca_location loc', 'loc.loca_locationid = rm.rewm_locationid', 'LEFT')

            ->join('dist_distributors ds', 'rm.rewm_supplierid = ds.dist_distributorid', 'LEFT');


        $this->db->order_by($order_by, $order);

        if ($limit && $limit > 0) {

            $this->db->limit($limit);
        }

        if ($offset) {

            $this->db->offset($offset);
        }

        $nquery = $this->db->get();
        $this->db->flush_cache();
        
        // echo $this->db->last_query();
        // die();

        $num_row = $nquery->num_rows();

        if (!empty($_GET['iDisplayLength']) &&  !empty($nquery) && is_array($nquery) && count($nquery) > 0) {

            $totalrecs = sizeof($nquery);
        }

        if ($num_row > 0) {

            $ndata = $nquery->result();

            $ndata['totalrecs'] = $totalrecs;

            $ndata['totalfilteredrecs'] = $totalfilteredrecs;
        } else {

            $ndata = array();

            $ndata['totalrecs'] = 0;

            $ndata['totalfilteredrecs'] = 0;
        }

        return $ndata;
    }



    public function get_detail_list_of_repair_request($cond = false)

    {

        $get = $_GET;

        $frmDate = $this->input->get('frmDate');

        $toDate = $this->input->get('toDate');

        $departmentid = $this->input->get('departmentid');



        $input_locationid = !empty($get['locationid']) ? $get['locationid'] : $this->input->post('locationid');





        foreach ($get as $key => $value) {

            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }



        if ($this->location_ismain == 'Y') {

            if ($input_locationid) {

                $this->db->where('rd.rerd_locationid', $input_locationid);
            }
        } else {

            $this->db->where('rd.rerd_locationid', $this->locationid);
        }



        if (!empty(($frmDate && $toDate))) {

            if (DEFAULT_DATEPICKER == 'NP') {

                $this->db->where('rm.rerm_requestdatebs >=', $frmDate);

                $this->db->where('rm.rerm_requestdatebs <=', $toDate);
            } else {

                $this->db->where('rm.rerm_requestdatead >=', $frmDate);

                $this->db->where('rm.rerm_requestdatead <=', $toDate);
            }
        }



        if ($departmentid) {

            $this->db->where('rm.rerm_reqdepid', $departmentid);
        }









        if (!empty($get['sSearch_0'])) {

            $this->db->where("rerd_repairrequestdetailid like  '%" . $get['sSearch_0'] . "%'  ");
        }



        if (!empty($get['sSearch_1'])) {

            $this->db->where("rerm_requestdatead like  '%" . $get['sSearch_1'] . "%'  ");
        }

        if (!empty($get['sSearch_2'])) {

            $this->db->where("rerm_requestdatebs like  '%" . $get['sSearch_2'] . "%'  ");
        }

        if (!empty($get['sSearch_3'])) {

            $this->db->where("rerm_requestno like  '%" . $get['sSearch_3'] . "%'  ");
        }

        if (!empty($get['sSearch_4'])) {

            $this->db->where("dept_depname like  '%" . $get['sSearch_4'] . "%'  ");
        }



        if ($cond) {

            $this->db->where($cond);
        }

        //  



        $resltrpt = $this->db->select("COUNT('*') as cnt")

            ->from('rerm_repairrequestmaster rm')

            ->join('rerd_repairrequestdetail rd', 'rd.rerd_repairrequestmasterid = rm.rerm_repairrequestmasterid', 'LEFT')

            ->join('dept_department df', 'df.dept_depid = rm.rerm_reqdepid', 'LEFT')



            ->get()->row();

        //echo $this->db->last_query();die(); 

        $totalfilteredrecs = 0;

        if (!empty($resltrpt)) {

            $totalfilteredrecs = $resltrpt->cnt;
        }



        $order_by = 'rerd_repairrequestdetailid';

        $order = 'desc';

        if ($this->input->get('sSortDir_0')) {

            $order = $this->input->get('sSortDir_0');
        }



        $where = '';

        if ($this->input->get('iSortCol_0') == 0)

            $order_by = 'rerd_repairrequestdetailid';

        else if ($this->input->get('iSortCol_0') == 1)

            $order_by = 'rerm_requestdatead';

        else if ($this->input->get('iSortCol_0') == 2)

            $order_by = 'rerm_requestdatebs';

        else if ($this->input->get('iSortCol_0') == 3)

            $order_by = 'rerm_requestno';

        else if ($this->input->get('iSortCol_0') == 4)

            $order_by = 'dept_depname';



        $totalrecs = '';

        $limit = 15;

        $offset = 1;

        $get = $_GET;



        foreach ($get as $key => $value) {

            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }



        if (!empty($_GET["iDisplayLength"])) {

            $limit = $_GET['iDisplayLength'];

            $offset = $_GET["iDisplayStart"];
        }



        if ($this->location_ismain == 'Y') {

            if ($input_locationid) {

                $this->db->where('rd.rerd_locationid', $input_locationid);
            }
        } else {

            $this->db->where('rd.rerd_locationid', $this->locationid);
        }



        if (!empty(($frmDate && $toDate))) {

            if (DEFAULT_DATEPICKER == 'NP') {

                $this->db->where('rm.rerm_requestdatebs >=', $frmDate);

                $this->db->where('rm.rerm_requestdatebs <=', $toDate);
            } else {

                $this->db->where('rm.rerm_requestdatead >=', $frmDate);

                $this->db->where('rm.rerm_requestdatead <=', $toDate);
            }
        }

        if ($departmentid) {

            $this->db->where('rm.rerm_reqdepid', $departmentid);
        }



        if (!empty($get['sSearch_0'])) {

            $this->db->where("rerd_repairrequestdetailid like  '%" . $get['sSearch_0'] . "%'  ");
        }



        if (!empty($get['sSearch_1'])) {

            $this->db->where("rerm_requestdatead like  '%" . $get['sSearch_1'] . "%'  ");
        }

        if (!empty($get['sSearch_2'])) {

            $this->db->where("rerm_requestdatebs like  '%" . $get['sSearch_2'] . "%'  ");
        }

        if (!empty($get['sSearch_3'])) {

            $this->db->where("rerm_requestno like  '%" . $get['sSearch_3'] . "%'  ");
        }

        if (!empty($get['sSearch_4'])) {

            $this->db->where("dept_depname like  '%" . $get['sSearch_4'] . "%'  ");
        }

        if ($cond) {

            $this->db->where($cond);
        }



        $this->db->select("rm.*,rd.*,df.dept_depname,loc.loca_name,ae.asen_assetcode")

            ->from('rerm_repairrequestmaster rm')

            ->join('rerd_repairrequestdetail rd', 'rd.rerd_repairrequestmasterid = rm.rerm_repairrequestmasterid', 'LEFT')

            ->join('asen_assetentry ae', 'ae.asen_asenid=rd.rerd_assetsid', 'LEFT')

            ->join('dept_department df', 'df.dept_depid = rm.rerm_reqdepid', 'LEFT')

            ->join('loca_location loc', 'loc.loca_locationid = rm.rerm_locationid', 'LEFT');



        $this->db->order_by($order_by, $order);

        if ($limit && $limit > 0) {

            $this->db->limit($limit);
        }

        if ($offset) {

            $this->db->offset($offset);
        }


        $nquery = $this->db->get();



        $num_row = $nquery->num_rows();

        if (!empty($_GET['iDisplayLength']) &&  !empty($nquery) && is_array($nquery) && count($nquery) > 0) {

            $totalrecs = sizeof($nquery);
        }


        if ($num_row > 0) {

            $ndata = $nquery->result();

            $ndata['totalrecs'] = $totalrecs;

            $ndata['totalfilteredrecs'] = $totalfilteredrecs;
        } else {

            $ndata = array();

            $ndata['totalrecs'] = 0;

            $ndata['totalfilteredrecs'] = 0;
        }

        // echo $this->db->last_query();die();

        return $ndata;
    }



    public function get_assets_repair_request_master_data($srchcol = false)
    {

        try {

            $this->db->select("rm.*,df.dept_depname,loc.loca_name")

                ->from('rerm_repairrequestmaster rm')

                ->join('dept_department df', 'df.dept_depid = rm.rerm_reqdepid', 'LEFT')

                ->join('loca_location loc', 'loc.loca_locationid = rm.rerm_locationid', 'LEFT');

            if ($srchcol) {

                $this->db->where($srchcol);
            }

            $query = $this->db->get();

            if ($query->num_rows() > 0) {

                return $query->result();
            }

            return false;
        } catch (Exception $e) {

            throw $e;
        }
    }





    public function get_assets_repair_request_detail_data($srchcol = false)
    {

        try {

            $this->db->select("rd.*,ae.asen_assetcode,ae.asen_desc")
                ->from('rerd_repairrequestdetail rd')
                ->join('rerm_repairrequestmaster rm', 'rm.rerm_repairrequestmasterid = rd.rerd_repairrequestmasterid', 'LEFT')
                ->join('asen_assetentry ae', 'ae.asen_asenid = rd.rerd_assetsid', 'LEFT');

            if ($srchcol) {

                $this->db->where($srchcol);
            }

            $query = $this->db->get();

            if ($query->num_rows() > 0) {

                return $query->result();
            }

            return false;
        } catch (Exception $e) {

            throw $e;
        }
    }



    public function get_all_asset_repair_request_detail($srorgal = false, $limit = false, $offset = false, $order = false, $order_by = false)

    {

        $this->input->post();

        $this->db->select("rm.*,rd.*,df.dept_depname,loc.loca_name")

            ->from('rerm_repairrequestmaster rm')

            ->join('rerd_repairrequestdetail rd', 'rd.rerd_repairrequestmasterid = rm.rerm_repairrequestmasterid', 'LEFT')

            ->join('dept_department df', 'df.dept_depid = rm.rerm_reqdepid', 'LEFT')

            ->join('loca_location loc', 'loc.loca_locationid = rm.rerm_locationid', 'LEFT');


        if ($srorgal) {

            $this->db->where($srorgal);
        }

        $query = $this->db->get();

        // echo $this->db->last_query();

        // die();

        if ($query->num_rows() > 0) {

            $data = $query->result();

            return $data;
        }

        return false;
    }

    public function get_last_repair_details($where = false)
    {
        try {

            $this->db->select("COUNT(rd.*) repair_count,rd.rerd_postdatead as last_repair_date,ae.asen_assetcode,ae.asen_desc")
                ->from('rerd_repairrequestdetail rd')
                ->join('rerm_repairrequestmaster rm', 'rm.rerm_repairrequestmasterid=rd.rerd_repairrequestmasterid', 'LEFT')
                ->join('asen_assetentry ae', 'ae.asen_asenid = rd.rerd_assetsid', 'LEFT');

            if ($where) {

                $this->db->where($where);
            }
            $this->db->order_by('rd.rerd_assetcode','DESC');
            $this->db->limit('1');
            $this->db->offset('1');

            $query = $this->db->get();

            if ($query->num_rows() > 0) {

                return $query->result();
            }

            return false;
        } catch (Exception $e) {

            throw $e;
        }
    }

    public function get_assets_repair_work_order_master_data($srchcol = false)
    {

        try {

            $this->db->select("rm.*,df.dept_depname,loc.loca_name")

                ->from('rewm_repairworkordermaster rm')

                ->join('dept_department df', 'df.dept_depid = rm.rewm_rwodepid', 'LEFT')

                ->join('loca_location loc', 'loc.loca_locationid = rm.rewm_locationid', 'LEFT');

            if ($srchcol) {

                $this->db->where($srchcol);
            }

            $query = $this->db->get();

            if ($query->num_rows() > 0) {

                return $query->result();
            }

            return false;
        } catch (Exception $e) {

            throw $e;
        }
    }

    public function get_assets_repair_work_order_detail_data($srchcol = false)
    {

        try {

            $this->db->select("rd.*,ae.asen_assetcode,ae.asen_desc")

                ->from('rewd_repairworkorderdetail rd')

                ->join('rewm_repairworkordermaster rm', 'rm.rewm_repairordermasterid=rd.rewd_repairordermasterid', 'LEF')

                ->join('asen_assetentry ae', 'ae.asen_asenid = rd.rewd_assetsid', 'LEFT');



            if ($srchcol) {

                $this->db->where($srchcol);
            }

            $query = $this->db->get();

            if ($query->num_rows() > 0) {

                return $query->result();
            }

            return false;
        } catch (Exception $e) {

            throw $e;
        }
    }
}
