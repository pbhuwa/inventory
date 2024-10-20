<?php if (!defined('BASEPATH')) exit('No direct script access allowed');



class Work_order_mdl extends CI_Model

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





    public $validate_settings_work_order = array(

        array('field' => 'woma_fiscalyrs', 'label' => 'Fiscal Year', 'rules' => 'trim|required|xss_clean'),

        array('field' => 'woma_workorderno', 'label' => 'Work Order No', 'rules' => 'trim|required|xss_clean'),

        array('field' => 'woma_date', 'label' => 'Order Date ', 'rules' => 'trim|required|xss_clean'),

        array('field' => 'woma_projectid', 'label' => 'Project', 'rules' => 'trim|required|xss_clean'),

        array('field' => 'woma_supplierid', 'label' => 'Contractor ', 'rules' => 'trim|required|xss_clean'),

        array('field' => 'wode_description[]', 'label' => 'Items ', 'rules' => 'trim|required|xss_clean'),

        array('field' => 'wode_qty[]', 'label' => 'Items ', 'rules' => 'trim|required|xss_clean'),

        array('field' => 'wode_rate[]', 'label' => 'Items ', 'rules' => 'trim|required|xss_clean'),



    );





    public function work_order_save()
    {

        try {





            $id = $this->input->post('id');

            $wdate = $this->input->post('woma_date');

            $ndate = $this->input->post('notice_date');

            if (DEFAULT_DATEPICKER == 'NP') {

                $wodatebs = $wdate;

                $wodatead = $this->general->NepToEngDateConv($wdate);

                $noticedatebs = $ndate;

                $noticedatead = $this->general->NepToEngDateConv($ndate);
            } else {

                $wodatead = $wdate;

                $wodatebs = $this->general->EngToNepDateConv($wdate);

                $noticedatead = $ndate;

                $noticedatebs = $this->general->EngToNepDateConv($ndate);
            }

            $worderno = $this->input->post('woma_workorderno');



            $locationid = $this->session->userdata(LOCATION_ID);

            $currentfyrs = CUR_FISCALYEAR;



            $cur_fiscalyrs_invoiceno = $this->db->select('woma_workorderno,woma_fiscalyrs')

                ->from('woma_workordermaster')

                ->where('woma_locationid', $locationid)

                // ->where('prin_fiscalyrs',$currentfyrs)

                ->order_by('woma_fiscalyrs', 'DESC')

                ->limit(1)

                ->get()->row();

            if (!empty($cur_fiscalyrs_invoiceno)) {

                $invoice_format = $cur_fiscalyrs_invoiceno->woma_workorderno;



                $invoice_string = str_split($invoice_format);

                // echo "<pre>";

                // print_r($invoice_string);

                // die();

                $invoice_prefix_len = strlen(WORKORDER_CODE_NO_PREFIX);

                $chk_first_string_after_invoice_prefix = $invoice_string[$invoice_prefix_len];

                // echo $chk_first_string_after_invoice_prefix;

                // die();

                if ($chk_first_string_after_invoice_prefix == '0') {

                    $invoice_no_prefix = WORKORDER_CODE_NO_PREFIX . CUR_FISCALYEAR;
                } else if ($cur_fiscalyrs_invoiceno->prin_fiscalyrs == $currentfyrs && $chk_first_string_after_invoice_prefix == '0') {

                    $invoice_no_prefix = WORKORDER_CODE_NO_PREFIX . CUR_FISCALYEAR;
                } else if ($cur_fiscalyrs_invoiceno->prin_fiscalyrs != $currentfyrs && $chk_first_string_after_invoice_prefix == '0') {

                    $invoice_no_prefix = WORKORDER_CODE_NO_PREFIX . CUR_FISCALYEAR;
                } else if ($cur_fiscalyrs_invoiceno->prin_fiscalyrs != $currentfyrs && $chk_first_string_after_invoice_prefix != '0') {

                    $invoice_no_prefix = WORKORDER_CODE_NO_PREFIX . CUR_FISCALYEAR;
                } else {

                    $invoice_no_prefix = WORKORDER_CODE_NO_PREFIX;
                }
            } else {

                $invoice_no_prefix = WORKORDER_CODE_NO_PREFIX . CUR_FISCALYEAR;
            }

            // die();



            $worderno = $this->general->generate_invoiceno('woma_workorderno', 'woma_workorderno', 'woma_workordermaster', $invoice_no_prefix, PROJECT_CODE_NO_LENGTH, false, 'woma_locationid');



            $projectid = $this->input->post('woma_projectid');

            $supplierid = $this->input->post('woma_supplierid');

            $manualno = $this->input->post('woma_manualno');

            $fyear = $this->input->post('woma_fiscalyrs');

            $noticeno = $this->input->post('woma_noticeno');



            $description = $this->input->post('wode_description');

            $qty = $this->input->post('wode_qty');

            $unit = $this->input->post('wode_unit');

            $rate = $this->input->post('wode_rate');

            $totalamt = $this->input->post('wode_totalamt');

            $remarks = $this->input->post('wode_remarks');

            $wode_dtype = $this->input->post('wode_dtype');

            $master_remarks = $this->input->post('woma_remark');



            $wmaterArr = array(

                'woma_projectid' => $projectid,

                'woma_workorderno' => $worderno,

                'woma_manualno' => $manualno,

                'woma_fiscalyrs' => $fyear,

                'woma_datead' => $wodatead,

                'woma_datebs' => $wodatebs,

                'woma_supplierid' => $supplierid,

                'woma_noticeno' => $noticeno,

                'woma_noticedatead' => $noticedatead,

                'woma_noticedatebs' => $noticedatebs,

                'woma_status' => 'O',

                'woma_remark' => $master_remarks,

                'woma_postdatead' => CURDATE_EN,

                'woma_postdatebs' => CURDATE_NP,

                'woma_posttime' => $this->curtime,

                'woma_postby' => $this->userid,

                'woma_postip' => $this->ip,

                'woma_postmac' => $this->mac,

                'woma_locationid' => $this->locationid,

                'woma_orgid' => $this->orgid

            );



            if (!empty($wmaterArr)) {

                $this->db->insert('woma_workordermaster', $wmaterArr);

                $insertid = $this->db->insert_id();

                $workDetail = array();

                if ($insertid) {

                    if (!empty($description)) :

                        foreach ($description as $kdw => $dlist) {

                            $workDetail[] = array(

                                'wode_womasterid' => $insertid,

                                'wode_dtype' => !empty($wode_dtype[$kdw]) ? $wode_dtype[$kdw] : '',

                                'wode_description' => !empty($description[$kdw]) ? $description[$kdw] : '',

                                'wode_qty' => !empty($qty[$kdw]) ? $qty[$kdw] : '',

                                'wode_rate' => !empty($rate[$kdw]) ? $rate[$kdw] : '',

                                'wode_unit' => !empty($unit[$kdw]) ? $unit[$kdw] : '',

                                'wode_totalamt' => !empty($totalamt[$kdw]) ? $totalamt[$kdw] : '',

                                'wode_remarks' => !empty($remarks[$kdw]) ? $remarks[$kdw] : '',

                                'wode_status' => 'O',

                                'wode_postdatead' => CURDATE_EN,

                                'wode_postdatebs' => CURDATE_NP,

                                'wode_posttime' => $this->curtime,

                                'wode_postby' => $this->userid,

                                'wode_postip' => $this->ip,

                                'wode_postmac' => $this->mac,

                                'wode_locationid' => $this->locationid,

                                'wode_orgid' => $this->orgid

                            );
                        }

                    endif;

                    if (!empty($workDetail)) {

                        $this->db->insert_batch('wode_workorderdetail', $workDetail);
                    }
                }
            }

            $this->db->trans_complete();

            $this->db->trans_commit();

            return true;
        } catch (Exception $e) {

            $this->db->trans_rollback();

            return false;

            throw $e;
        }
    }





    public function save_work_order_status()

    {

        // echo "<pre>";

        // print_r($this->input->post());

        // die();

        $masterid = $this->input->post('masterid');

        $woma_isworkorder = $this->input->post('woma_isworkorder');

        $wodate = $this->input->post('wodate');

        $tobecomdate = $this->input->post('woma_tobecomdate');

        $workorderstatus = $this->input->post('woma_workorderstatus');


        if ($workorderstatus == 'WO') {

            if (DEFAULT_DATEPICKER == 'NP') {

                $wodatebs = $wodate;

                $wodatead = $this->general->NepToEngDateConv($wodate);

                $tobecomdatebs = $tobecomdate;

                $tobecomdatead = $this->general->NepToEngDateConv($tobecomdate);
            } else {

                $wodatead = $wodate;

                $wodatebs = $this->general->EngToNepDateConv($wodate);

                $tobecomdatead = $tobecomdate;

                $tobecomdatebs = $this->general->EngToNepDateConv($tobecomdate);
            }

            $postdata['woma_isworkorder'] = $woma_isworkorder;

            $postdata['woma_wodatead'] = $wodatead;

            $postdata['woma_wodatebs'] = $wodatebs;

            $postdata['woma_tobecomdatead'] = $tobecomdatead;

            $postdata['woma_tobecomdatebs'] = $tobecomdatebs;

            $postdata['woma_workorderstatus'] = $workorderstatus;

            $this->general->saveActionLog('woma_workordermaster', $masterid,  $this->userid, 'WO', 'woma_workorderstatus', 'Convert From Estimation To Work Order');
        } else if ($workorderstatus == 'M') {
            $measurementdate = $this->input->post('measurementdate');
            if (DEFAULT_DATEPICKER == 'NP') {
                $postdata['woma_measurementdatebs'] = $measurementdate;
                $postdata['woma_measurementdatead'] = $this->general->NepToEngDateConv($measurementdate);
            } else { 

                $postdata['woma_measurementdatead'] = $measurementdate;
                $postdata['woma_measurementdatebs'] = $this->general->EngToNepDateConv($measurementdate);
            }
            $postdata['woma_measurementamount'] = $this->input->post('woma_measurementamount');

            $_FILES['attachments']['name'] = $_FILES['woma_measurementattachment']['name'];
            $_FILES['attachments']['type'] = $_FILES['woma_measurementattachment']['type'];
            $_FILES['attachments']['tmp_name'] = $_FILES['woma_measurementattachment']['tmp_name'];
            $_FILES['attachments']['error'] = $_FILES['woma_measurementattachment']['error'];
            $_FILES['attachments']['size'] = $_FILES['woma_measurementattachment']['size'];
            if (!empty($_FILES)) {
                $imgfile = $this->doupload('attachments');
            } else {
                $imgfile = '';
            }
            $postdata['woma_measurementattachment'] = $imgfile;
            $this->general->saveActionLog('woma_workordermaster', $masterid,  $this->userid, 'WO', 'woma_workorderstatus', 'Added Mesurement Data');
        } else if ($workorderstatus == 'WC') {

            $completion_date = $this->input->post('completiondate');

            if (DEFAULT_DATEPICKER == 'NP') {
                $postdata['woma_completiondatebs'] = $completion_date;
                $postdata['woma_completiondatead'] = $this->general->NepToEngDateConv($completion_date);
            } else {

                $postdata['woma_completiondatead'] = $completion_date;
                $postdata['woma_completiondatebs'] = $this->general->EngToNepDateConv($completion_date);
            }
            $postdata['woma_workorderstatus'] = $workorderstatus;
            $postdata['woma_civilamt'] = $this->input->post('woma_civilamt');
            $postdata['woma_materialamt'] = $this->input->post('woma_materialamt');
            $postdata['woma_advertisementamt'] = $this->input->post('woma_advertisementamt');
            $postdata['woma_otheramt'] = $this->input->post('woma_otheramt');
            $postdata['woma_completion_totalamt'] = $this->input->post('woma_completion_totalamt');

            $_FILES['attachments']['name'] = $_FILES['woma_completionattachment']['name'];
            $_FILES['attachments']['type'] = $_FILES['woma_completionattachment']['type'];
            $_FILES['attachments']['tmp_name'] = $_FILES['woma_completionattachment']['tmp_name'];
            $_FILES['attachments']['error'] = $_FILES['woma_completionattachment']['error'];
            $_FILES['attachments']['size'] = $_FILES['woma_completionattachment']['size'];
            if (!empty($_FILES)) {
                $imgfile = $this->doupload('attachments');
            } else {
                $imgfile = '';
            }
            $postdata['woma_completionattachment'] = $imgfile;

            $this->general->saveActionLog('woma_workordermaster', $masterid,  $this->userid, 'WC', 'woma_workorderstatus', 'Convert From Work Order To Work Complete');
        }

        if (!empty($postdata)) {

            $this->db->update('woma_workordermaster', $postdata, array('woma_womasterid' => $masterid));

            $rw_aff = $this->db->affected_rows();

            if ($rw_aff) {

                return true;
            }

            return false;
        }

        return false;
    }


    public function save_workorder_bill_and_payment()
    {
        $masterid = $this->input->post('masterid');
        $workorder_type = $this->input->post('workorder_type');

        if ($workorder_type == 'CB') {
            $contractbilldate = $this->input->post('contractbilldate');

            if (DEFAULT_DATEPICKER == 'NP') {
                $postdata['wocb_billdatebs'] = $contractbilldate;
                $postdata['wocb_billdatead'] = $this->general->NepToEngDateConv($contractbilldate);
            } else {

                $postdata['wocb_billdatead'] = $contractbilldate;
                $postdata['wocb_billdatebs'] = $this->general->EngToNepDateConv($contractbilldate);
            }
            $postdata['wocb_womasterid'] = $masterid;
            $postdata['wocb_amtwithoutvat'] = $this->input->post('wocb_amtwithoutvat');
            $postdata['wocb_amtwithvat'] = $this->input->post('wocb_amtwithvat');
            $postdata['wocb_postdatead'] = CURDATE_EN;
            $postdata['wocb_postdatebs'] = CURDATE_NP;
            $postdata['wocb_posttime'] = $this->curtime;
            $postdata['wocb_postby'] = $this->userid;
            $postdata['wocb_postip'] = $this->ip;
            $postdata['wocb_postmac'] = $this->mac;
            $postdata['wocb_locationid'] = $this->locationid;
            $postdata['wocb_orgid'] = $this->orgid;

            $_FILES['attachments']['name'] = $_FILES['wocb_contractbillattachment']['name'];
            $_FILES['attachments']['type'] = $_FILES['wocb_contractbillattachment']['type'];
            $_FILES['attachments']['tmp_name'] = $_FILES['wocb_contractbillattachment']['tmp_name'];
            $_FILES['attachments']['error'] = $_FILES['wocb_contractbillattachment']['error'];
            $_FILES['attachments']['size'] = $_FILES['wocb_contractbillattachment']['size'];
            if (!empty($_FILES)) {
                $imgfile = $this->doupload('attachments');
            } else {
                $imgfile = '';
            }
            $postdata['wocb_contractbillattachment'] = $imgfile;


            if (!empty($postdata)) {
                $this->db->insert('wocb_workordercontractbill', $postdata);
                $rw_aff = $this->db->affected_rows();
                if ($rw_aff) {
                    return true;
                }
                return false;
            }
        } else if ($workorder_type == 'PB') {

            $paymentdate = $this->input->post('paymentdate');
            if (DEFAULT_DATEPICKER == 'NP') {
                $postdata['wopa_paymentdatebs'] = $paymentdate;
                $postdata['wopa_paymentdatead'] = $this->general->NepToEngDateConv($paymentdate);
            } else {

                $postdata['wopa_paymentdatead'] = $paymentdate;
                $postdata['wopa_paymentdatebs'] = $this->general->EngToNepDateConv($paymentdate);
            }
            $postdata['wopa_masterid'] = $masterid;
            $postdata['wopa_paymentamt'] = $this->input->post('wopa_paymentamt');
            $postdata['wopa_chequeno'] = $this->input->post('wopa_chequeno');
            $postdata['wopa_postdatead'] = CURDATE_EN;
            $postdata['wopa_postdatebs'] = CURDATE_NP;
            $postdata['wopa_posttime'] = $this->curtime;
            $postdata['wopa_postby'] = $this->userid;
            $postdata['wopa_postip'] = $this->ip;
            $postdata['wopa_postmac'] = $this->mac;
            $postdata['wopa_locationid'] = $this->locationid;
            $postdata['wopa_orgid'] = $this->orgid;

            $_FILES['attachments']['name'] = $_FILES['wopa_paymentattachment']['name'];
            $_FILES['attachments']['type'] = $_FILES['wopa_paymentattachment']['type'];
            $_FILES['attachments']['tmp_name'] = $_FILES['wopa_paymentattachment']['tmp_name'];
            $_FILES['attachments']['error'] = $_FILES['wopa_paymentattachment']['error'];
            $_FILES['attachments']['size'] = $_FILES['wopa_paymentattachment']['size'];
            if (!empty($_FILES)) {
                $imgfile = $this->doupload('attachments');
            } else {
                $imgfile = '';
            }
            $postdata['wopa_paymentattachment'] = $imgfile;

            if (!empty($postdata)) {
                $this->db->insert('wopa_workorderpayment', $postdata);
                $rw_aff = $this->db->affected_rows();
                if ($rw_aff) {
                    return true;
                }
                return false;
            }
        }
        return false;
    }




    public function get_work_order_summary_list($cond = false)

    {

        $get = $_GET;

        $frmDate = $this->input->get('frmDate');

        $toDate = $this->input->get('toDate');

        $input_locationid = !empty($get['locationid']) ? $get['locationid'] : $this->input->post('locationid');

        $projectid = !empty($get['projectid']) ? $get['projectid'] : '';

        $contractorid = !empty($get['contractorid']) ? $get['contractorid'] : '';







        foreach ($get as $key => $value) {

            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }



        if ($this->location_ismain == 'Y') {

            if ($input_locationid) {

                $this->db->where('wm.woma_locationid', $input_locationid);
            }
        } else {

            $this->db->where('wm.woma_locationid', $this->locationid);
        }



        if (!empty(($frmDate && $toDate))) {

            if (DEFAULT_DATEPICKER == 'NP') {

                $this->db->where('wm.woma_datebs >=', $frmDate);

                $this->db->where('wm.woma_datebs <=', $toDate);
            } else {

                $this->db->where('wm.woma_datead >=', $frmDate);

                $this->db->where('wm.woma_datead <=', $toDate);
            }
        }

        if (!empty($projectid)) {

            $this->db->where('wm.woma_projectid', $projectid);
        }

        if (!empty($contractorid)) {

            $this->db->where('wm.woma_supplierid', $contractorid);
        }











        if (!empty($get['sSearch_0'])) {

            $this->db->where("woma_womasterid like  '%" . $get['sSearch_0'] . "%'  ");
        }



        if (!empty($get['sSearch_1'])) {

            $this->db->where("woma_datead like  '%" . $get['sSearch_1'] . "%'  ");
        }

        if (!empty($get['sSearch_2'])) {

            $this->db->where("woma_datebs like  '%" . $get['sSearch_2'] . "%'  ");
        }

        if (!empty($get['sSearch_3'])) {

            $this->db->where("woma_workorderno like  '%" . $get['sSearch_3'] . "%'  ");
        }

        if (!empty($get['sSearch_4'])) {

            $this->db->where("woma_noticeno like  '%" . $get['sSearch_4'] . "%'  ");
        }

        if (!empty($get['sSearch_5'])) {

            $this->db->where("p.prin_project_title like  '%" . $get['sSearch_5'] . "%'  ");
        }

        if (!empty($get['sSearch_6'])) {

            $this->db->where("d.dist_distributor like  '%" . $get['sSearch_6'] . "%'  ");
        }

        if (!empty($get['sSearch_7'])) {

            $this->db->where("woma_manualno like  '%" . $get['sSearch_7'] . "%'  ");
        }

        if (!empty($get['sSearch_8'])) {

            $this->db->where("woma_fiscalyrs like  '%" . $get['sSearch_8'] . "%'  ");
        }

        if ($cond) {

            $this->db->where($cond);
        }

        //  



        $resltrpt = $this->db->select("COUNT('*') as cnt")

            ->from('woma_workordermaster wm')

            ->join('prin_projectinfo p', 'p.prin_prinid = wm.woma_projectid', 'LEFT')

            ->join('dist_distributors d', 'd.dist_distributorid = wm.woma_supplierid', 'LEFT')

            ->get()->row();

        //echo $this->db->last_query();die(); 

        $totalfilteredrecs = 0;

        if (!empty($resltrpt)) {

            $totalfilteredrecs = $resltrpt->cnt;
        }



        $order_by = 'woma_womasterid';

        $order = 'desc';

        if ($this->input->get('sSortDir_0')) {

            $order = $this->input->get('sSortDir_0');
        }



        $where = '';

        if ($this->input->get('iSortCol_0') == 0)

            $order_by = 'woma_womasterid';

        else if ($this->input->get('iSortCol_0') == 1)

            $order_by = 'woma_datead';

        else if ($this->input->get('iSortCol_0') == 2)

            $order_by = 'woma_datebs';

        else if ($this->input->get('iSortCol_0') == 3)

            $order_by = 'woma_workorderno';

        else if ($this->input->get('iSortCol_0') == 4)

            $order_by = 'woma_noticeno';

        else if ($this->input->get('iSortCol_0') == 5)

            $order_by = 'prin_project_title';

        else if ($this->input->get('iSortCol_0') == 6)

            $order_by = 'dist_distributor';

        else if ($this->input->get('iSortCol_0') == 7)

            $order_by = 'woma_manualno';

        else if ($this->input->get('iSortCol_0') == 8)

            $order_by = 'woma_fiscalyrs';

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

                $this->db->where('wm.woma_locationid', $input_locationid);
            }
        } else {

            $this->db->where('wm.woma_locationid', $this->locationid);
        }



        if (!empty(($frmDate && $toDate))) {

            if (DEFAULT_DATEPICKER == 'NP') {

                $this->db->where('wm.woma_datebs >=', $frmDate);

                $this->db->where('wm.woma_datebs <=', $toDate);
            } else {

                $this->db->where('wm.woma_datead >=', $frmDate);

                $this->db->where('wm.woma_datead <=', $toDate);
            }
        }

        if (!empty($projectid)) {

            $this->db->where('wm.woma_projectid', $projectid);
        }

        if (!empty($contractorid)) {

            $this->db->where('wm.woma_supplierid', $contractorid);
        }



        if (!empty($get['sSearch_0'])) {

            $this->db->where("woma_womasterid like  '%" . $get['sSearch_0'] . "%'  ");
        }



        if (!empty($get['sSearch_1'])) {

            $this->db->where("woma_datead like  '%" . $get['sSearch_1'] . "%'  ");
        }

        if (!empty($get['sSearch_2'])) {

            $this->db->where("woma_datebs like  '%" . $get['sSearch_2'] . "%'  ");
        }

        if (!empty($get['sSearch_3'])) {

            $this->db->where("woma_workorderno like  '%" . $get['sSearch_3'] . "%'  ");
        }

        if (!empty($get['sSearch_4'])) {

            $this->db->where("woma_noticeno like  '%" . $get['sSearch_4'] . "%'  ");
        }

        if (!empty($get['sSearch_5'])) {

            $this->db->where("p.prin_project_title like  '%" . $get['sSearch_5'] . "%'  ");
        }

        if (!empty($get['sSearch_6'])) {

            $this->db->where("d.dist_distributor like  '%" . $get['sSearch_6'] . "%'  ");
        }

        if (!empty($get['sSearch_7'])) {

            $this->db->where("woma_manualno like  '%" . $get['sSearch_7'] . "%'  ");
        }

        if (!empty($get['sSearch_8'])) {

            $this->db->where("woma_fiscalyrs like  '%" . $get['sSearch_8'] . "%'  ");
        }

        if ($cond) {

            $this->db->where($cond);
        }



        $this->db->select("wm.*,p.prin_project_title as projectname, d.dist_distributor as contractor_name")

            ->from('woma_workordermaster wm')

            ->join('prin_projectinfo p', 'p.prin_prinid = wm.woma_projectid', 'LEFT')

            ->join('dist_distributors d', 'd.dist_distributorid = wm.woma_supplierid', 'LEFT');



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





    public function get_work_order_master_data($srchcol = false)
    {

        try {

            $this->db->select("wm.*,p.prin_project_title as projectname, d.dist_distributor as contractor_name,lo.loca_name as locationname")

                ->from('woma_workordermaster wm')

                ->join('prin_projectinfo p', 'p.prin_prinid = wm.woma_projectid', 'LEFT')

                ->join('dist_distributors d', 'd.dist_distributorid = wm.woma_supplierid', 'LEFT')

                ->join('loca_location lo', 'lo.loca_locationid=wm.woma_locationid', 'LEFT');



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





    public function get_work_order_detail_data($srchcol = false, $order_by = false, $order = 'ASC', $limit = false, $offset = false)
    {

        try {

            $this->db->select("wd.*,p.prin_project_title as projectname, d.dist_distributor as contractor_name,wm.woma_workorderno,wm.woma_datead,wm.woma_datebs")

                ->from('wode_workorderdetail wd')

                ->join('woma_workordermaster wm', 'wm.woma_womasterid=wd.wode_womasterid', 'LEF')

                ->join('prin_projectinfo p', 'p.prin_prinid = wm.woma_projectid', 'LEFT')

                ->join('dist_distributors d', 'd.dist_distributorid = wm.woma_supplierid', 'LEFT');

            if ($srchcol) {

                $this->db->where($srchcol);
            }



            if ($order_by) {

                $this->db->order_by($order_by, $order);
            }

            if ($limit) {

                $this->db->limit($limit);
            }

            if ($offset) {

                $this->db->offset($offset);
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

    public function doupload($file)
    {
        $config['upload_path'] = './' . PROJECT_BILL_ATTACHMENT_PATH; //define in constants
        $config['allowed_types'] = 'png|jpg|gif|jpeg|pdf|docx|doc|txt';
        $config['allowed_types'] = 'png|jpg|gif|jpeg|pdf';
        $config['encrypt_name'] = FALSE;
        $config['remove_spaces'] = TRUE;
        $config['max_size'] = '2000000';
        $config['max_width'] = '5000';
        $config['max_height'] = '5000';
        $this->upload->initialize($config);
        $this->load->library('upload', $config);
        $this->upload->do_upload($file);
        $data = $this->upload->data();
        $name_array = $data['file_name'];
        return $name_array;
    }
}
