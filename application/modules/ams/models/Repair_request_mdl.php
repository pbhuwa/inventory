<?php if (!defined('BASEPATH')) exit('No direct script access allowed');



class Repair_request_mdl extends CI_Model

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





    public $validate_settings_repair_request = array(

        array('field' => 'rerm_fiscalyrs', 'label' => 'Fiscal Year', 'rules' => 'trim|required|xss_clean'),

        array('field' => 'rerm_requestno', 'label' => 'Request No', 'rules' => 'trim|required|xss_clean'),

        array('field' => 'rerm_requestdate', 'label' => 'Request Date', 'rules' => 'trim|required|xss_clean'),

        array('field' => 'rerm_reqdepid', 'label' => 'Department', 'rules' => 'trim|required|xss_clean'),

        array('field' => 'rerm_requestby', 'label' => 'Requested By', 'rules' => 'trim|required|xss_clean'),

        array('field' => 'asdd_assetid[]', 'label' => 'Assets ', 'rules' => 'trim|required|xss_clean'),

        array('field' => 'assets_desc[]', 'label' => 'Assets Description ', 'rules' => 'trim|required|xss_clean'),

        array('field' => 'problem[]', 'label' => 'Problem ', 'rules' => 'trim|required|xss_clean'),

    );





    public function repair_request_save_new()
    {
        echo "<pre>";
        print_r($this->input->post());
        die();
        try {


            $fyear = $this->input->post('rerm_fiscalyrs');

            $requestno = $this->input->post('rerm_requestno');

            $manualno = $this->input->post('rerm_manualno');

            $rerm_requestdate = $this->input->post('rerm_requestdate');

            $rerm_estmatecost = $this->input->post('total_estimate');

            if (DEFAULT_DATEPICKER == 'NP') {

                $rerm_requestdatebs = $rerm_requestdate;

                $rerm_requestdatead = $this->general->NepToEngDateConv($rerm_requestdate);
            } else {

                $rerm_requestdatead = $rerm_requestdate;

                $rerm_requestdatebs = $this->general->EngToNepDateConv($rerm_requestdate);
            }

            $full_remarks = $this->input->post('full_remarks');



            /* For detail */

            $reqdepid = $this->input->post('rerm_reqdepid');

            $requestby = $this->input->post('rerm_requestby');

            $assetscode = $this->input->post('assets_code');

            $assetid = $this->input->post('asdd_assetid');

            $assetsdesc = $this->input->post('assets_desc');

            $problem = $this->input->post('problem');

            $estimated_cost = $this->input->post('estimated_cost');

            $remarks = $this->input->post('remarks');

            $asset_cnt = 0;

            if (!empty($assetid) && is_array($assetid)) {

                $asset_cnt = sizeof($assetid);
            }


            $locationid = $this->session->userdata(LOCATION_ID);

            $currentfyrs = CUR_FISCALYEAR;


            $cur_fiscalyrs_rrreqno = $this->db->select('rerm_requestno,rerm_fiscalyrs')

                ->from('rerm_repairrequestmaster')

                ->where('rerm_locationid', $locationid)

                ->order_by('rerm_fiscalyrs', 'DESC')

                ->limit(1)

                ->get()->row();



            // echo "<pre>";

            // print_r($cur_fiscalyrs_rrreqno);

            // die();



            if (!empty($cur_fiscalyrs_rrreqno)) {

                $rreq_format = $cur_fiscalyrs_rrreqno->rerm_requestno;



                $invoice_string = str_split($rreq_format);

                // echo "<pre>";

                // print_r($invoice_string);

                // die();

                $rrreq_prefix_len = strlen(ASSETS_REPAIRREQ_CODE_NO_PREFIX);

                $chk_first_string_after_invoice_prefix = $invoice_string[$rrreq_prefix_len];

                // echo $chk_first_string_after_invoice_prefix;

                // die();

                if ($chk_first_string_after_invoice_prefix == '0') {

                    $rr_no_prefix = ASSETS_REPAIRREQ_CODE_NO_PREFIX . CUR_FISCALYEAR;
                } else if ($cur_fiscalyrs_rrreqno->rerm_fiscalyrs == $currentfyrs && $chk_first_string_after_invoice_prefix == '0') {

                    $rr_no_prefix = ASSETS_REPAIRREQ_CODE_NO_PREFIX . CUR_FISCALYEAR;
                } else if ($cur_fiscalyrs_rrreqno->rerm_fiscalyrs != $currentfyrs && $chk_first_string_after_invoice_prefix == '0') {

                    $rr_no_prefix = ASSETS_REPAIRREQ_CODE_NO_PREFIX . CUR_FISCALYEAR;
                } else if ($cur_fiscalyrs_rrreqno->rerm_fiscalyrs != $currentfyrs && $chk_first_string_after_invoice_prefix != '0') {

                    $rr_no_prefix = ASSETS_REPAIRREQ_CODE_NO_PREFIX . CUR_FISCALYEAR;
                } else {

                    $rr_no_prefix = ASSETS_REPAIRREQ_CODE_NO_PREFIX;
                }
            } else {

                $rr_no_prefix = ASSETS_REPAIRREQ_CODE_NO_PREFIX . CUR_FISCALYEAR;
            }

            $request_no = $this->general->generate_invoiceno('rerm_requestno', 'rerm_requestno', 'rerm_repairrequestmaster', $rr_no_prefix, ASSETS_REPAIRREQ_CODE_NO_LENGTH, false, 'rerm_locationid');



            $repairequestMasterArr = array(

                'rerm_fiscalyrs' => $fyear,

                'rerm_requestno' => $requestno,

                'rerm_reqdepid' => $reqdepid,

                'rerm_manualno' => $manualno,

                'rerm_requestdatebs' => $rerm_requestdatebs,

                'rerm_requestdatead' => $rerm_requestdatead,

                'rerm_estmatecost' => $rerm_estmatecost,

                'rerm_requestby' => $requestby,

                'rerm_remark' => $full_remarks,

                'rerm_noofassets' => $asset_cnt,

                'rerm_status' => 'O',

                'rerm_approved' => '0',

                'rerm_postdatead' => CURDATE_EN,

                'rerm_postdatebs' => CURDATE_NP,

                'rerm_posttime' => $this->curtime,

                'rerm_postby' => $this->userid,

                'rerm_postip' => $this->ip,

                'rerm_postmac' => $this->mac,

                'rerm_locationid' => $this->locationid,

                'rerm_orgid' => $this->orgid

            );



            if (!empty($repairequestMasterArr)) {

                $this->db->insert('rerm_repairrequestmaster', $repairequestMasterArr);

                $insertid = $this->db->insert_id();

                $repairrequestDetailArr = array();

                if ($insertid) {

                    if (!empty($assetid)) :

                        foreach ($assetid as $kdw => $dlist) {

                            $repairrequestDetailArr[] = array(

                                'rerd_repairrequestmasterid' => $insertid,

                                'rerd_assetsid' => !empty($assetid[$kdw]) ? $assetid[$kdw] : '',

                                'rerd_assetsdesc' => !empty($assetsdesc[$kdw]) ? $assetsdesc[$kdw] : '',

                                'rerd_assetcode' => !empty($assetscode[$kdw]) ? $assetscode[$kdw] : '',

                                'rerd_problem' => !empty($problem[$kdw]) ? $problem[$kdw] : '',

                                'rerd_estimateamt' => !empty($estimated_cost[$kdw]) ? $estimated_cost[$kdw] : '',

                                'rerd_remark' => !empty($remarks[$kdw]) ? $remarks[$kdw] : '',

                                'rerd_repairedstatus' => 'WR',

                                'rerd_status' => 'O',

                                'rerd_postdatead' => CURDATE_EN,

                                'rerd_postdatebs' => CURDATE_NP,

                                'rerd_posttime' => $this->curtime,

                                'rerd_postby' => $this->userid,

                                'rerd_postip' => $this->ip,

                                'rerd_postmac' => $this->mac,

                                'rerd_locationid' => $this->locationid,

                                'rerd_orgid' => $this->orgid

                            );
                        }

                    endif;

                    if (!empty($repairrequestDetailArr)) {

                        $this->db->insert_batch('xw_rerd_repairrequestdetail', $repairrequestDetailArr);
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



    public function get_summary_list_of_repair_request($cond = false)

    {

        $get = $_GET;

        $frmDate = $this->input->get('frmDate');

        $toDate = $this->input->get('toDate');

        $fromDepid = $this->input->get('fromDepid');

        $toDepid = $this->input->get('toDepid');

        $input_locationid = !empty($get['locationid']) ? $get['locationid'] : $this->input->post('locationid');





        foreach ($get as $key => $value) {

            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }



        if ($this->location_ismain == 'Y') {

            if ($input_locationid) {

                $this->db->where('rm.rerm_locationid', $input_locationid);
            }
        } else {

            $this->db->where('rm.rerm_locationid', $this->locationid);
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













        if (!empty($get['sSearch_0'])) {

            $this->db->where("rerm_repairrequestmasterid like  '%" . $get['sSearch_0'] . "%'  ");
        }



        if (!empty($get['sSearch_1'])) {

            $this->db->where("astm_transferdatead like  '%" . $get['sSearch_1'] . "%'  ");
        }

        if (!empty($get['sSearch_2'])) {

            $this->db->where("astm_transferdatebs like  '%" . $get['sSearch_2'] . "%'  ");
        }

        if (!empty($get['sSearch_3'])) {

            $this->db->where("astm_transferno like  '%" . $get['sSearch_3'] . "%'  ");
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

            ->from('rerm_repairrequestmaster rm')

            ->get()->row();

        //echo $this->db->last_query();die(); 

        $totalfilteredrecs = 0;

        if (!empty($resltrpt)) {

            $totalfilteredrecs = $resltrpt->cnt;
        }



        $order_by = 'rerm_repairrequestmasterid';

        $order = 'desc';

        if ($this->input->get('sSortDir_0')) {

            $order = $this->input->get('sSortDir_0');
        }



        $where = '';

        if ($this->input->get('iSortCol_0') == 0)

            $order_by = 'rerm_repairrequestmasterid';

        else if ($this->input->get('iSortCol_0') == 1)

            $order_by = 'astm_transferdatead';

        else if ($this->input->get('iSortCol_0') == 2)

            $order_by = 'astm_transferdatebs';

        else if ($this->input->get('iSortCol_0') == 3)

            $order_by = 'astm_transferno';

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

                $this->db->where('rm.rerm_locationid', $input_locationid);
            }
        } else {

            $this->db->where('rm.rerm_locationid', $this->locationid);
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





        if (!empty($get['sSearch_0'])) {

            $this->db->where("rerm_repairrequestmasterid like  '%" . $get['sSearch_0'] . "%'  ");
        }



        if (!empty($get['sSearch_1'])) {

            $this->db->where("astm_transferdatead like  '%" . $get['sSearch_1'] . "%'  ");
        }

        if (!empty($get['sSearch_2'])) {

            $this->db->where("astm_transferdatebs like  '%" . $get['sSearch_2'] . "%'  ");
        }

        if (!empty($get['sSearch_3'])) {

            $this->db->where("astm_transferno like  '%" . $get['sSearch_3'] . "%'  ");
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



        $this->db->select("rm.*,df.dept_depname,loc.loca_name")

            ->from('rerm_repairrequestmaster rm')

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

                ->join('rerm_repairrequestmaster rm', 'rm.rerm_repairrequestmasterid=rd.rerd_repairrequestmasterid', 'LEF')

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
}
