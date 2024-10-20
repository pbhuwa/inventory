<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Receive_against_order_mdl extends CI_Model
{

    public function __construct()
    {
        parent::__construct();

        $this->recm_masterTable = 'recm_receivedmaster';
        $this->recd_detailTable = 'recd_receiveddetail';
        $this->trma_masterTable = 'trma_transactionmain'; 
        $this->trde_detailTable = 'trde_transactiondetail';
        $this->puor_masterTable = 'puor_purchaseordermaster';
        $this->pude_detailTable = 'pude_purchaseorderdetail';

        $this->curtime = $this->general->get_currenttime();
        $this->userid = $this->session->userdata(USER_ID);
        $this->username = $this->session->userdata(USER_NAME);
        $this->storeid = $this->session->userdata(STORE_ID);
        $this->userdepid = $this->session->userdata(USER_DEPT); //storeid
        $this->mac = $this->general->get_Mac_Address();
        $this->ip = $this->general->get_real_ipaddr();
        $this->locationid = $this->session->userdata(LOCATION_ID);
        $this->location_ismain = $this->session->userdata(ISMAIN_LOCATION);
        $this->orgid = $this->session->userdata(ORG_ID);
        $this->mattypeid = $this->session->userdata(USER_MAT_TYPEID);
    }

    public $validate_settings_receive_against_order = array(
        array('field' => 'supplierid', 'label' => 'Supplier Name', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'received_no', 'label' => 'Received No', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'suplier_bill_no', 'label' => 'Supplier Bill No.', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'suplier_bill_date', 'label' => 'Supplier Bill Date.', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'received_date', 'label' => 'Received Date', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'received_qty[]', 'label' => 'Received Qty', 'rules' => 'trim|required|xss_clean|greater_than[0]'),
        // array('field' => 'billamount', 'label' => 'Bill Amount', 'rules' => 'trim|required|xss_clean'),
        // array('field' => 'clearanceamt', 'label' => 'Clearance Amount', 'rules' => 'trim|required|callback__notMatch[billamount]|xss_clean'),
    );

    public $validate_settings_upload_attachment = array(
        array('field' => 'recm_attachments[]', 'label' => 'Attachment', 'rules' => 'required'),
    );

    public $validate_settings_cancelreceive = array(
        array('field' => 'receive_no', 'label' => 'Receive Number', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'cancel_reason', 'label' => 'Cancel Reason', 'rules' => 'trim|required|xss_clean'),
    );

    public function get_receive_against_order_list($cond = false)
    {
        $get = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }

        if (!empty($get['sSearch_1'])) {
            $this->db->where("recm_receiveddatebs like  '%" . $get['sSearch_1'] . "%'  ");
        }

        if (!empty($get['sSearch_2'])) {
            $this->db->where("recm_fyear like  '%" . $get['sSearch_2'] . "%'  ");
        }

        if (!empty($get['sSearch_3'])) {
            $this->db->where("recm_purchaseorderno like  '%" . $get['sSearch_3'] . "%'  ");
        }
        if (!empty($get['sSearch_4'])) {
            $this->db->where("recm_purchaseorderno like  '%" . $get['sSearch_4'] . "%'  ");
        }
        if (!empty($get['sSearch_5'])) {
            $this->db->where("dist_distributor like  '%" . $get['sSearch_5'] . "%'  ");
        }
        if (!empty($get['sSearch_6'])) {
            $this->db->where("recm_discount like  '%" . $get['sSearch_6'] . "%'  ");
        }
        if (!empty($get['sSearch_7'])) {
            $this->db->where("recm_taxamount like  '%" . $get['sSearch_7'] . "%'  ");
        }
        if (!empty($get['sSearch_8'])) {
            $this->db->where("recm_clearanceamount like  '%" . $get['sSearch_8'] . "%'  ");
        }
        if (!empty($get['sSearch_9'])) {
            $this->db->where("recm_posttime like  '%" . $get['sSearch_9'] . "%'  ");
        }
        if ($cond) {
            $this->db->where($cond);
        }
        $frmDate = !empty($get['frmDate']) ? $get['frmDate'] : $this->input->post('frmDate');
        $toDate = !empty($get['toDate']) ? $get['toDate'] : $this->input->post('toDate');

        $fyear = !empty($get['fyear']) ? $get['fyear'] : $this->input->post('fyear');
        $store_id = !empty($get['store_id']) ? $get['store_id'] : $this->input->post('store_id');
        $supplierid = !empty($get['supplierid']) ? $get['supplierid'] : $this->input->post('supplierid');
        $mattypeid = !empty($get['mattypeid']) ? $get['mattypeid'] : $this->input->post('mattypeid');
        // $supplierid=$this->input->get('supplierid');
        // echo"<pre>";print_r($this->input->get());die;


        $locationid = !empty($get['locationid']) ? $get['locationid'] : $this->input->post('locationid');
        if ($this->location_ismain == 'Y') {
            if (!empty($locationid)) {
                $this->db->where('rm.recm_locationid', $locationid);
            }
        } else {
            $this->db->where('rm.recm_locationid', $this->locationid);
        }
        if ($frmDate &&  $toDate) {
            if (DEFAULT_DATEPICKER == 'NP') {
                $this->db->where('recm_receiveddatebs >=', $frmDate);
                $this->db->where('recm_receiveddatebs <=', $toDate);
            } else {
                $this->db->where('recm_receiveddatead >=', $frmDate);
                $this->db->where('recm_receiveddatead <=', $toDate);
            }
        }

        if ($fyear) {
            $this->db->where('recm_fyear', $fyear);
        }

        if (!empty($supplierid)) {
            $this->db->where(array('rm.recm_supplierid' => $supplierid));
        }

        if (!empty($this->mattypeid)) {
            $this->db->where('rm.recm_mattypeid', $this->mattypeid);
        } else {
            if (!empty($mattypeid)) {
                $this->db->where('rm.recm_mattypeid', $mattypeid);
            }
        }

        $resltrpt = $this->db->select("COUNT(*) as cnt")
            ->from('recm_receivedmaster rm')
            ->join('dist_distributors s', 's.dist_distributorid = rm.recm_supplierid', 'LEFT')
            ->join('budg_budgets b', 'b.budg_budgetid = rm.recm_budgetid', 'LEFT')
            // ->where('recm_purchaseordermasterid !=',0)
            ->where('recm_purchaseordermasterid != 0 OR recm_challanno != 0')
            // ->where("rm.recm_status !='M'")
            ->get()
            ->row();

        //echo $this->db->last_query();die(); 
        $totalfilteredrecs = $resltrpt->cnt;

        $order_by = 'rm.recm_receiveddatebs';
        $order = 'DESC';
        if ($this->input->get('sSortDir_0')) {
            $order = $this->input->get('sSortDir_0');
        }

        $where = '';
        if ($this->input->get('iSortCol_0') == 1)
            $order_by = 'recm_receiveddatebs';
        else if ($this->input->get('iSortCol_0') == 2)
            $order_by = 'recm_fyear';
        else if ($this->input->get('iSortCol_0') == 3)
            $order_by = 'recm_invoiceno';
        else if ($this->input->get('iSortCol_0') == 4)
            $order_by = 'recm_purchaseorderno';
        else if ($this->input->get('iSortCol_0') == 5)
            $order_by = 'dist_distributor';
        else if ($this->input->get('iSortCol_0') == 6)
            $order_by = 'recm_discount';
        else if ($this->input->get('iSortCol_0') == 7)
            $order_by = 'recm_taxamount';
        else if ($this->input->get('iSortCol_0') == 8)
            $order_by = 'recm_clearanceamount';
        else if ($this->input->get('iSortCol_0') == 9)
            $order_by = 'recm_posttime';
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

        if (!empty($get['sSearch_1'])) {
            $this->db->where("recm_receiveddatebs like  '%" . $get['sSearch_1'] . "%'  ");
        }

        if (!empty($get['sSearch_2'])) {
            $this->db->where("recm_fyear like  '%" . $get['sSearch_2'] . "%'  ");
        }

        if (!empty($get['sSearch_3'])) {
            $this->db->where("recm_invoiceno like  '%" . $get['sSearch_3'] . "%'  ");
        }
        if (!empty($get['sSearch_4'])) {
            $this->db->where("recm_purchaseorderno like  '%" . $get['sSearch_4'] . "%'  ");
        }
        if (!empty($get['sSearch_5'])) {
            $this->db->where("dist_distributor like  '%" . $get['sSearch_5'] . "%'  ");
        }

        if (!empty($get['sSearch_6'])) {
            $this->db->where("recm_discount like  '%" . $get['sSearch_6'] . "%'  ");
        }
        if (!empty($get['sSearch_7'])) {
            $this->db->where("recm_taxamount like  '%" . $get['sSearch_7'] . "%'  ");
        }
        if (!empty($get['sSearch_8'])) {
            $this->db->where("recm_clearanceamount like  '%" . $get['sSearch_8'] . "%'  ");
        }
        if (!empty($get['sSearch_9'])) {
            $this->db->where("recm_posttime like  '%" . $get['sSearch_9'] . "%'  ");
        }

        if ($cond) {
            $this->db->where($cond);
        }

        $frmDate = !empty($get['frmDate']) ? $get['frmDate'] : $this->input->post('frmDate');
        $toDate = !empty($get['toDate']) ? $get['toDate'] : $this->input->post('toDate');

        if ($frmDate &&  $toDate) {
            if (DEFAULT_DATEPICKER == 'NP') {
                $this->db->where('recm_receiveddatebs >=', $frmDate);
                $this->db->where('recm_receiveddatebs <=', $toDate);
            } else {
                $this->db->where('recm_receiveddatead >=', $frmDate);
                $this->db->where('recm_receiveddatead <=', $toDate);
            }
        }
        $locationid = !empty($get['locationid']) ? $get['locationid'] : $this->input->post('locationid');
        if ($this->location_ismain == 'Y') {
            if (!empty($locationid)) {
                $this->db->where('rm.recm_locationid', $locationid);
            }
        } else {
            $this->db->where('rm.recm_locationid', $this->locationid);
        }
        if (!empty($this->mattypeid)) {
            $this->db->where('rm.recm_mattypeid', $this->mattypeid);
        } else {
            if (!empty($mattypeid)) {
                $this->db->where('rm.recm_mattypeid', $mattypeid);
            }
        }
        $this->db->select('rm.*,s.dist_distributor,s.dist_distributorid, b.budg_budgetname');
        $this->db->from('recm_receivedmaster rm');
        $this->db->join('dist_distributors s', 's.dist_distributorid = rm.recm_supplierid', 'LEFT');
        $this->db->join('budg_budgets b', 'b.budg_budgetid = rm.recm_budgetid', 'LEFT');
        // $this->db->where('recm_purchaseordermasterid !=',0);
        $this->db->where('(recm_purchaseordermasterid != 0 OR recm_challanno != 0)');
        // $this->db->where("rm.recm_status !='M'");

        // if($fyear)
        // {
        //     $this->db->where('rm.recm_fyear',$fyear);
        // }
        if ($store_id) {
            $this->db->where('recm_storeid', $store_id);
        }


        if (!empty($supplierid)) {
            $this->db->where(array('rm.recm_supplierid' => $supplierid));
        }
        // if(!empty($order_by) && !empty($order)){
        //     $order_by = 'rm.recm_receiveddatebs';
        //     $order = 'desc';
        // }
        $this->db->order_by($order_by, $order);

        if ($limit && $limit > 0) {
            $this->db->limit($limit);
        }
        if ($offset) {
            $this->db->offset($offset);
        }

        $nquery = $this->db->get();

        // echo $this->db->last_query(); die();

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

    public function get_receive_against_order_list_ku($cond = false)
    {


        $get = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }

        if (!empty($get['sSearch_1'])) {
            $this->db->where("recm_receiveddatebs like  '%" . $get['sSearch_1'] . "%'  ");
        }
        if (!empty($get['sSearch_2'])) {
            $this->db->where("recm_fyear like  '%" . $get['sSearch_2'] . "%'  ");
        }
        if (!empty($get['sSearch_3'])) {
            $this->db->where("recm_invoiceno like  '%" . $get['sSearch_3'] . "%'  ");
        }
        if (!empty($get['sSearch_4'])) {
            $this->db->where("recm_purchaseorderno like  '%" . $get['sSearch_4'] . "%'  ");
        }
        if (!empty($get['sSearch_5'])) {
            $this->db->where("dist_distributor like  '%" . $get['sSearch_5'] . "%'  ");
        }
        if (!empty($get['sSearch_6'])) {
            $this->db->where("budg_budgetname like  '%" . $get['sSearch_6'] . "%'  ");
        }



        if ($cond) {
            $this->db->where($cond);
        }
        $frmDate = !empty($get['frmDate']) ? $get['frmDate'] : $this->input->post('frmDate');
        $toDate = !empty($get['toDate']) ? $get['toDate'] : $this->input->post('toDate');

        $fyear = !empty($get['fyear']) ? $get['fyear'] : $this->input->post('fyear');
        $store_id = !empty($get['store_id']) ? $get['store_id'] : $this->input->post('store_id');
        $supplierid = !empty($get['supplierid']) ? $get['supplierid'] : $this->input->post('supplierid');
        $mattypeid = !empty($get['mattypeid']) ? $get['mattypeid'] : $this->input->post('mattypeid');
        $schoolid = !empty($get['schoolid']) ? $get['schoolid'] : $this->input->post('schoolid');
        $departmentid = !empty($get['departmentid']) ? $get['departmentid'] : $this->input->post('mattypeid');
        $subdepid = !empty($get['subdepid']) ? $get['subdepid'] : $this->input->post('subdepid');

        $subdeparray = array();
        if ($departmentid) {
            $check_parentid = $this->general->get_tbl_data('dept_depid,dept_parentdepid', 'dept_department', array('dept_depid' => $departmentid), 'dept_depname', 'ASC');
        }


        if (!empty($check_parentid)) {
            // print_r($check_parentid);
            // die();
            $parentdepid = !empty($check_parentid[0]->dept_parentdepid) ? $check_parentid[0]->dept_parentdepid : '0';
            if ($parentdepid == '0') {
                $subdep_result = $this->general->get_tbl_data('dept_depid', 'dept_department', array('dept_parentdepid' => $departmentid), 'dept_depname', 'ASC');
                if (!empty($subdep_result)) {
                    foreach ($subdep_result as $ksd => $dep) {
                        $subdeparray[] = $dep->dept_depid;
                    }
                }
                // $subdeparray

            }
        }


        $locationid = !empty($get['locationid']) ? $get['locationid'] : $this->input->post('locationid');
        if ($this->location_ismain == 'Y') {
            if (!empty($locationid)) {
                $this->db->where('rm.recm_locationid', $locationid);
            }
        } else {
            $this->db->where('rm.recm_locationid', $this->locationid);
        }
        if ($frmDate &&  $toDate) {
            if (DEFAULT_DATEPICKER == 'NP') {
                $this->db->where('recm_receiveddatebs >=', $frmDate);
                $this->db->where('recm_receiveddatebs <=', $toDate);
            } else {
                $this->db->where('recm_receiveddatead >=', $frmDate);
                $this->db->where('recm_receiveddatead <=', $toDate);
            }
        }

        if ($fyear) {
            $this->db->where('recm_fyear', $fyear);
        }

        if (!empty($supplierid)) {
            $this->db->where(array('rm.recm_supplierid' => $supplierid));
        }

        if (!empty($this->mattypeid)) {
            $this->db->where('rm.recm_mattypeid', $this->mattypeid);
        } else {
            if (!empty($mattypeid)) {
                $this->db->where('rm.recm_mattypeid', $mattypeid);
            }
        }
        if (!empty($schoolid)) {
            $this->db->where('rm.recm_school', $schoolid);
        }
        if (!empty($subdepid)) {
            $departmentid = $subdepid;
        }
        if (!empty($departmentid)) {
            if (!empty($subdeparray)) {
                $this->db->where_in('rm.recm_departmentid', $subdeparray);
            } else {
                $this->db->where('rm.recm_departmentid', $departmentid);
            }
        }




        $resltrpt = $this->db->select("COUNT(*) as cnt")
            ->from('recm_receivedmaster rm')
            ->join('dist_distributors s', 's.dist_distributorid = rm.recm_supplierid', 'LEFT')
            ->join('budg_budgets b', 'b.budg_budgetid = rm.recm_budgetid', 'LEFT')
            // ->where('recm_purchaseordermasterid !=',0)
            ->where('recm_purchaseordermasterid != 0 OR recm_challanno != 0')
            // ->where("rm.recm_status !='M'")
            ->get()
            ->row();

        // echo $this->db->last_query();die(); 
        $totalfilteredrecs = $resltrpt->cnt;

        $order_by = 'rm.recm_receiveddatebs';
        $order = 'DESC';
        if ($this->input->get('sSortDir_0')) {
            $order = $this->input->get('sSortDir_0');
        }

        $where = '';
        if ($this->input->get('iSortCol_0') == 1)
            $order_by = 'recm_receiveddatebs';
        else if ($this->input->get('iSortCol_0') == 2)
            $order_by = 'recm_fyear';
        else if ($this->input->get('iSortCol_0') == 3)
            $order_by = 'recm_invoiceno';
        else if ($this->input->get('iSortCol_0') == 4)
            $order_by = 'recm_purchaseorderno';
        else if ($this->input->get('iSortCol_0') == 5)
            $order_by = 'dist_distributor';
        else if ($this->input->get('iSortCol_0') == 6)
            $order_by = 'budg_budgetname';
        else if ($this->input->get('iSortCol_0') == 7)
            $order_by = 'recm_amount';
        else if ($this->input->get('iSortCol_0') == 8)
            $order_by = 'recm_discount';
        else if ($this->input->get('iSortCol_0') == 10)
            $order_by = 'recm_clearanceamount';
        else if ($this->input->get('iSortCol_0') == 11)
            $order_by = 'recm_posttime';
        else if ($this->input->get('iSortCol_0') == 11)
            $order_by = 'recm_receivedby';
        else if ($this->input->get('iSortCol_0') == 11)
            $order_by = 'maty_material';
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

        if (!empty($get['sSearch_1'])) {
            $this->db->where("recm_receiveddatebs like  '%" . $get['sSearch_1'] . "%'  ");
        }
        if (!empty($get['sSearch_2'])) {
            $this->db->where("recm_fyear like  '%" . $get['sSearch_2'] . "%'  ");
        }
        if (!empty($get['sSearch_3'])) {
            $this->db->where("recm_invoiceno like  '%" . $get['sSearch_3'] . "%'  ");
        }
        if (!empty($get['sSearch_4'])) {
            $this->db->where("recm_purchaseorderno like  '%" . $get['sSearch_4'] . "%'  ");
        }
        if (!empty($get['sSearch_5'])) {
            $this->db->where("dist_distributor like  '%" . $get['sSearch_5'] . "%'  ");
        }
        if (!empty($get['sSearch_6'])) {
            $this->db->where("budg_budgetname like  '%" . $get['sSearch_6'] . "%'  ");
        }



        if ($cond) {
            $this->db->where($cond);
        }

        $frmDate = !empty($get['frmDate']) ? $get['frmDate'] : $this->input->post('frmDate');
        $toDate = !empty($get['toDate']) ? $get['toDate'] : $this->input->post('toDate');

        if ($frmDate &&  $toDate) {
            if (DEFAULT_DATEPICKER == 'NP') {
                $this->db->where('recm_receiveddatebs >=', $frmDate);
                $this->db->where('recm_receiveddatebs <=', $toDate);
            } else {
                $this->db->where('recm_receiveddatead >=', $frmDate);
                $this->db->where('recm_receiveddatead <=', $toDate);
            }
        }

        $locationid = !empty($get['locationid']) ? $get['locationid'] : $this->input->post('locationid');
        if ($this->location_ismain == 'Y') {
            if (!empty($locationid)) {
                $this->db->where('rm.recm_locationid', $locationid);
            }
        } else {
            $this->db->where('rm.recm_locationid', $this->locationid);
        }
        if (!empty($this->mattypeid)) {
            $this->db->where('rm.recm_mattypeid', $this->mattypeid);
        } else {
            if (!empty($mattypeid)) {
                $this->db->where('rm.recm_mattypeid', $mattypeid);
            }
        }

        if (!empty($schoolid)) {
            $this->db->where('rm.recm_school', $schoolid);
        }
        if (!empty($subdepid)) {
            $departmentid = $subdepid;
        }
        if (!empty($departmentid)) {
            if (!empty($subdeparray)) {
                $this->db->where_in('rm.recm_departmentid', $subdeparray);
            } else {
                $this->db->where('rm.recm_departmentid', $departmentid);
            }
        }

        $this->db->select('rm.*,s.dist_distributor,s.dist_distributorid, b.budg_budgetname,mt.maty_material');
        $this->db->from('recm_receivedmaster rm');
        $this->db->join('dist_distributors s', 's.dist_distributorid = rm.recm_supplierid', 'LEFT');
        $this->db->join('budg_budgets b', 'b.budg_budgetid = rm.recm_budgetid', 'LEFT');
        // $this->db->where('recm_purchaseordermasterid !=',0);
        $this->db->where('(recm_purchaseordermasterid != 0 OR recm_challanno != 0)');
        $this->db->join('maty_materialtype mt', 'mt.maty_materialtypeid=rm.recm_mattypeid', "LEFT");
        // $this->db->where("rm.recm_status !='M'");

        // if($fyear)
        // {
        //     $this->db->where('rm.recm_fyear',$fyear);
        // }
        if ($store_id) {
            $this->db->where('recm_storeid', $store_id);
        }


        if (!empty($supplierid)) {
            $this->db->where(array('rm.recm_supplierid' => $supplierid));
        }
        // if(!empty($order_by) && !empty($order)){
        //     $order_by = 'rm.recm_receiveddatebs';
        //     $order = 'desc';
        // }
        $this->db->order_by($order_by, $order);

        if ($limit && $limit > 0) {
            $this->db->limit($limit);
        }
        if ($offset) {
            $this->db->offset($offset);
        }

        $nquery = $this->db->get();

        // echo $this->db->last_query(); die();

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



    public function get_receive_against_order_details_list($cond = false)
    {
        $get = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }

        $frmDate = !empty($get['frmDate']) ? $get['frmDate'] : $this->input->post('frmDate');
        $toDate = !empty($get['toDate']) ? $get['toDate'] : $this->input->post('toDate');
        // $fyear = !empty($get['fyear'])?$get['fyear']:$this->input->post('fyear');
        $store_id = !empty($get['store_id']) ? $get['store_id'] : $this->input->post('store_id');
        $supplierid = !empty($get['supplierid']) ? $get['supplierid'] : $this->input->post('supplierid');
        // echo"<pre>";print_r($this->input->get());die;
         $mattypeid = !empty($get['mattypeid']) ? $get['mattypeid'] : $this->input->post('mattypeid');
        $schoolid = !empty($get['schoolid']) ? $get['schoolid'] : $this->input->post('schoolid');
        $departmentid = !empty($get['departmentid']) ? $get['departmentid'] : $this->input->post('mattypeid');
        $subdepid = !empty($get['subdepid']) ? $get['subdepid'] : $this->input->post('subdepid');

        $subdeparray = array();
        if ($departmentid) {
            $check_parentid = $this->general->get_tbl_data('dept_depid,dept_parentdepid', 'dept_department', array('dept_depid' => $departmentid), 'dept_depname', 'ASC');
        }


        if (!empty($check_parentid)) {
            // print_r($check_parentid);
            // die();
            $parentdepid = !empty($check_parentid[0]->dept_parentdepid) ? $check_parentid[0]->dept_parentdepid : '0';
            if ($parentdepid == '0') {
                $subdep_result = $this->general->get_tbl_data('dept_depid', 'dept_department', array('dept_parentdepid' => $departmentid), 'dept_depname', 'ASC');
                if (!empty($subdep_result)) {
                    foreach ($subdep_result as $ksd => $dep) {
                        $subdeparray[] = $dep->dept_depid;
                    }
                }
                // $subdeparray

            }
        }




        if ($frmDate &&  $toDate) {
            if (DEFAULT_DATEPICKER == 'NP') {
                $this->db->where('recm_receiveddatebs >=', $frmDate);
                $this->db->where('recm_receiveddatebs <=', $toDate);
            } else {
                $this->db->where('recm_receiveddatead >=', $frmDate);
                $this->db->where('recm_receiveddatead <=', $toDate);
            }
        }

        if (!empty($get['sSearch_1'])) {
            $this->db->where("recm_receiveddatebs like  '%" . $get['sSearch_1'] . "%'  ");
        }
        if (!empty($get['sSearch_2'])) {
            $this->db->where("recm_supbilldatebs like  '%" . $get['sSearch_2'] . "%'  ");
        }
        if (!empty($get['sSearch_3'])) {
            $this->db->where("recm_purchaseorderno like  '%" . $get['sSearch_3'] . "%'  ");
        }
        if (!empty($get['sSearch_4'])) {
            $this->db->where("dist_distributor like  '%" . $get['sSearch_4'] . "%'  ");
        }

        if (!empty($get['sSearch_5'])) {

            $this->db->where("itli_itemname like  '%" . $get['sSearch_5'] . "%' OR itli_itemnamenp like  '%" . $get['sSearch_5'] . "%'  ");
        }

        if (!empty($get['sSearch_6'])) {
            $this->db->where("recm_fyear like  '%" . $get['sSearch_6'] . "%'  ");
        }

        if (!empty($get['sSearch_7'])) {
            $this->db->where("unit_unitname like  '%" . $get['sSearch_7'] . "%'  ");
        }

        if (!empty($get['sSearch_8'])) {
            $this->db->where("recd_purchasedqty like  '%" . $get['sSearch_8'] . "%'  ");
        }

        if (!empty($get['sSearch_9'])) {
            $this->db->where("recd_discountamt like  '%" . $get['sSearch_9'] . "%'  ");
        }

        if (!empty($get['sSearch_10'])) {
            $this->db->where("recd_vatamt like  '%" . $get['sSearch_10'] . "%'  ");
        }
        if (!empty($get['sSearch_11'])) {
            $this->db->where("recd_amount like  '%" . $get['sSearch_11'] . "%'  ");
        }

        if ($cond) {
            $this->db->where($cond);
        }

        //print_r( $store_id);die;
        if ($store_id) {
            $this->db->where('rm.recm_storeid', $store_id);
        }

        if ($supplierid) {
            $this->db->where('rm.recm_supplierid', $supplierid);
        }

        $locationid = !empty($get['locationid']) ? $get['locationid'] : $this->input->post('locationid');

        if ($this->location_ismain == 'Y') {
            if (!empty($locationid)) {
                $this->db->where('rd.recd_locationid', $locationid);
            }
        } else {
            $this->db->where('rd.recd_locationid', $this->locationid);
        }
        // if($fyear)
        // {
        //    $this->db->where('recm_fyear',$fyear);
        // }

  if (!empty($this->mattypeid)) {
            $this->db->where('rm.recm_mattypeid', $this->mattypeid);
        } else {
            if (!empty($mattypeid)) {
                $this->db->where('rm.recm_mattypeid', $mattypeid);
            }
        }

        if (!empty($schoolid)) {
            $this->db->where('rm.recm_school', $schoolid);
        }
        if (!empty($subdepid)) {
            $departmentid = $subdepid;
        }
        if (!empty($departmentid)) {
            if (!empty($subdeparray)) {
                $this->db->where_in('rm.recm_departmentid', $subdeparray);
            } else {
                $this->db->where('rm.recm_departmentid', $departmentid);
            }
        }

        $resltrpt = $this->db->select("COUNT(*) as cnt")
            ->from('recd_receiveddetail rd')
            ->join('recm_receivedmaster rm', 'rm.recm_receivedmasterid=rd.recd_receivedmasterid', "LEFT")
            ->join('itli_itemslist it', 'it.itli_itemlistid=rd.recd_itemsid', 'LEFT')
            ->join('dist_distributors s', 's.dist_distributorid = rm.recm_supplierid', 'LEFT')
            ->join('unit_unit un', 'un.unit_unitid=it.itli_unitid', 'LEFT')
            // ->where('recm_purchaseordermasterid !=',0)
            ->where('(recm_purchaseordermasterid != 0 OR recm_challanno != 0)')
            ->get()
            ->row();

            // echo $this->db->last_query();
            // die();



        $totalfilteredrecs = $resltrpt->cnt;

        $order_by = 'rm.recm_purchaseorderno';
        $order = 'DESC';
        if ($this->input->get('sSortDir_0')) {
            $order = $this->input->get('sSortDir_0');
        }

        $where = '';
        if ($this->input->get('iSortCol_0') == 1)
            $order_by = 'recm_purchaseorderno';
        else if ($this->input->get('iSortCol_0') == 2)
            $order_by = 'recm_receiveddatebs';
        else if ($this->input->get('iSortCol_0') == 3)
            $order_by = 'recm_supbilldatebs';
        else if ($this->input->get('iSortCol_0') == 4)
            $order_by = 'recm_purchaseorderno';
        else if ($this->input->get('iSortCol_0') == 5)
            $order_by = 'dist_distributor';
        else if ($this->input->get('iSortCol_0') == 6)
            $order_by = 'itli_itemname';
        else if ($this->input->get('iSortCol_0') == 7)
            $order_by = 'recm_fyear';
        else if ($this->input->get('iSortCol_0') == 8)
            $order_by = 'recd_purchasedqty';
        else if ($this->input->get('iSortCol_0') == 9)
            $order_by = 'recd_discountamt';
        else if ($this->input->get('iSortCol_0') == 10)
            $order_by = 'recd_vatamt';
        else if ($this->input->get('iSortCol_0') == 11)
            $order_by = 'recd_amount';


        $totalrecs = '';
        $limit = 15;
        $offset = 1;
        $get = $_GET;

        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }

        $frmDate = !empty($get['frmDate']) ? $get['frmDate'] : $this->input->post('frmDate');
        $toDate = !empty($get['toDate']) ? $get['toDate'] : $this->input->post('toDate');

        if ($frmDate &&  $toDate) {
            if (DEFAULT_DATEPICKER == 'NP') {
                $this->db->where('recm_receiveddatebs >=', $frmDate);
                $this->db->where('recm_receiveddatebs <=', $toDate);
            } else {
                $this->db->where('recm_receiveddatead >=', $frmDate);
                $this->db->where('recm_receiveddatead <=', $toDate);
            }
        }


        if (!empty($_GET["iDisplayLength"])) {
            $limit = $_GET['iDisplayLength'];
            $offset = $_GET["iDisplayStart"];
        }

        if (!empty($get['sSearch_1'])) {
            $this->db->where("recm_receiveddatebs like  '%" . $get['sSearch_1'] . "%'  ");
        }
        if (!empty($get['sSearch_2'])) {
            $this->db->where("recm_supbilldatebs like  '%" . $get['sSearch_2'] . "%'  ");
        }
        if (!empty($get['sSearch_3'])) {
            $this->db->where("recm_purchaseorderno like  '%" . $get['sSearch_3'] . "%'  ");
        }
        if (!empty($get['sSearch_4'])) {
            $this->db->where("dist_distributor like  '%" . $get['sSearch_4'] . "%'  ");
        }

        if (!empty($get['sSearch_5'])) {

            $this->db->where("itli_itemname like  '%" . $get['sSearch_5'] . "%' OR itli_itemnamenp like  '%" . $get['sSearch_5'] . "%'  ");
        }

        if (!empty($get['sSearch_6'])) {
            $this->db->where("recm_fyear like  '%" . $get['sSearch_6'] . "%'  ");
        }

        if (!empty($get['sSearch_7'])) {
            $this->db->where("unit_unitname like  '%" . $get['sSearch_7'] . "%'  ");
        }

        if (!empty($get['sSearch_8'])) {
            $this->db->where("recd_purchasedqty like  '%" . $get['sSearch_8'] . "%'  ");
        }

        if (!empty($get['sSearch_9'])) {
            $this->db->where("recd_discountamt like  '%" . $get['sSearch_9'] . "%'  ");
        }

        if (!empty($get['sSearch_10'])) {
            $this->db->where("recd_vatamt like  '%" . $get['sSearch_10'] . "%'  ");
        }
        if (!empty($get['sSearch_11'])) {
            $this->db->where("recd_amount like  '%" . $get['sSearch_11'] . "%'  ");
        }

        if ($cond) {
            $this->db->where($cond);
        }
        $locationid = !empty($get['locationid']) ? $get['locationid'] : $this->input->post('locationid');

        if ($this->location_ismain == 'Y') {
            if (!empty($locationid)) {
                $this->db->where('rd.recd_locationid', $locationid);
            }
        } else {
            $this->db->where('rd.recd_locationid', $this->locationid);
        }
          if (!empty($this->mattypeid)) {
            $this->db->where('rm.recm_mattypeid', $this->mattypeid);
        } else {
            if (!empty($mattypeid)) {
                $this->db->where('rm.recm_mattypeid', $mattypeid);
            }
        }

        if (!empty($schoolid)) {
            $this->db->where('rm.recm_school', $schoolid);
        }
        if (!empty($subdepid)) {
            $departmentid = $subdepid;
        }
        if (!empty($departmentid)) {
            if (!empty($subdeparray)) {
                $this->db->where_in('rm.recm_departmentid', $subdeparray);
            } else {
                $this->db->where('rm.recm_departmentid', $departmentid);
            }
        }


        $this->db->select('rm.recm_receivedmasterid,rm.recm_purchaseorderno,rm.recm_fyear,it.itli_itemname,it.itli_itemnamenp,s.dist_distributor, s.dist_distributorid, un.unit_unitname,rd.recd_purchasedqty,rd.recd_unitprice,(recd_purchasedqty*recd_unitprice) total,rd.recd_discountamt,rd.recd_vatamt,rd.recd_amount,rd.recd_locationid,rm.recm_receiveddatebs,rm.recm_receiveddatead,rm.recm_supbilldatebs, rm.recm_challanno');
        $this->db->from('recd_receiveddetail rd');
        $this->db->join('recm_receivedmaster rm', 'rm.recm_receivedmasterid=rd.recd_receivedmasterid', "LEFT");
        $this->db->join('dist_distributors s', 's.dist_distributorid = rm.recm_supplierid', 'LEFT');
        $this->db->join('itli_itemslist it', 'it.itli_itemlistid=rd.recd_itemsid', 'LEFT');
        $this->db->join('unit_unit un', 'un.unit_unitid=it.itli_unitid', 'LEFT');
        $this->db->where('(recm_purchaseordermasterid != 0 OR recm_challanno != 0)');

        if ($store_id) {
            $this->db->where('rm.recm_storeid', $store_id);
        }

        if ($supplierid) {
            $this->db->where('rm.recm_supplierid', $supplierid);
        }
        $this->db->order_by($order_by, $order);


        if ($limit && $limit > 0) {
            $this->db->limit($limit);
        }
        if ($offset) {
            $this->db->offset($offset);
        }

        $nquery = $this->db->get();

        // echo $this->db->last_query(); die();
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
        //echo $this->db->last_query();die();
        return $ndata;
    }

    public function get_orderlist_by_order_no($srchcol = false)
    {
        $this->db->select('po.*');
        $this->db->from('puor_purchaseordermaster po');
        if ($srchcol) {
            $this->db->where($srchcol);
        }
        // $this->db->where('puor_orderno',$orderno);
        $query = $this->db->get();
        // echo $this->db->last_query();
        // die();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }


    public function get_received_master_by_order_no($srchcol = false)
    {
        $this->db->select('rm.*');
        $this->db->from('recm_receivedmaster rm');
        if ($srchcol) {
            $this->db->where($srchcol);
        }
        // $this->db->where('puor_orderno',$orderno);
        $query = $this->db->get();
        //echo $this->db->last_query(); die();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }

    public function get_received_detail_by_order_no($srchcol = false)
    {
        $this->db->select('rd.*,il.itli_itemcode, il.itli_itemname, il.itli_itemnamenp, ut.unit_unitname');
        $this->db->from('recd_receiveddetail rd');
        $this->db->join('itli_itemslist il', 'il.itli_itemlistid=rd.recd_itemsid', 'LEFT');
        $this->db->join('unit_unit ut', 'ut.unit_unitid=il.itli_unitid', 'LEFT');
        if ($srchcol) {
            $this->db->where($srchcol);
        }
        // $this->db->where('puor_orderno',$orderno);
        $query = $this->db->get();
        // echo $this->db->last_query();
        // die();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }


    public function get_orderdetail_list($srchcol = false)
    {
        // $this->db->select('*');
        $this->db->select('il.itli_itemcode, il.itli_itemname, il.itli_itemnamenp, il.itli_itemlistid, il.itli_purchaserate, pod.*');
        $this->db->from('pude_purchaseorderdetail pod');
        $this->db->join('itli_itemslist il', 'il.itli_itemlistid = pod.pude_itemsid', 'left');
        // $this->db->join('supp_supplier s','s.supp_supplierid = pom.puor_supplierid','left');

        if ($srchcol) {
            $this->db->where($srchcol);
        }
        // $this->db->where('puor_orderno',$orderno);
        $query = $this->db->get();
        // echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }

    public function save_receive_order()
    {
        //check id
        $id = $this->input->post('id');

        //received master data
        $orderno = $this->input->post('orderno');

        // print_r($orderno);
        // die();
        // echo "<pre>";
        // print_r($this->input->post());
        // die();

        $fiscalyear = $this->input->post('fiscalyear');
        $supplierid = $this->input->post('supplierid');
        $orderdate = $this->input->post('order_date');
        $received_no = $this->input->post('received_no');
        $received_date = $this->input->post('received_date');
        $supplier_bill_no = $this->input->post('suplier_bill_no');
        $suplier_bill_date = $this->input->post('suplier_bill_date');
        $purchaseordermasterid = $this->input->post('purchaseordermasterid');
        $bugetid = $this->input->post('bugetid');
        $mattypeid = $this->input->post('recm_mattypeid');
        $receivedby = $this->input->post('recm_receivedby');
        $school = $this->input->post('recm_school');
        $departmentid = $this->input->post('recm_departmentid');
        $recm_subdepartmentid = $this->input->post('recm_subdepartmentid');
        if (!empty($recm_subdepartmentid)) {
            $departmentid = $recm_subdepartmentid;
        }
        if (DEFAULT_DATEPICKER == 'NP') {
            $orderdatebs = $orderdate;
            $orderdatead = $this->general->NepToEngDateConv($orderdate);

            $received_datebs = $received_date;
            $received_datead = $this->general->NepToEngDateConv($received_date);

            $suplier_bill_datebs = $suplier_bill_date;
            $suplier_bill_datead = $this->general->NepToEngDateConv($suplier_bill_date);
        } else {
            $orderdatead = $orderdate;
            $orderdatebs = $this->general->EngToNepDateConv($orderdate);

            $received_datead = $received_date;
            $received_datebs = $this->general->EngToNepDateConv($received_date);

            $suplier_bill_datead = $suplier_bill_date;
            $suplier_bill_datebs = $this->general->EngToNepDateConv($suplier_bill_date);
        }

        $bill_amount = $this->input->post('billamount');
        $remarks = $this->input->post('remarks');

        $insurance = $this->input->post('insurance');
        $carriage = $this->input->post('carriage');
        $packing = $this->input->post('packing');
        $transportamt = $this->input->post('transportamt');
        $otheramt = $this->input->post('otheramt');

        $totalamount = $this->input->post('totalamount');
        $discountamt = $this->input->post('discountamt');
        $subtotalamt = $this->input->post('subtotalamt');
        $taxamt = $this->input->post('taxamt');
        $extra = $this->input->post('extra');
        $refund = $this->input->post('refund');

        $clearanceamt = $this->input->post('clearanceamt');

        //received detail data
        $itemsid = $this->input->post('itemsid');
        $batchno = $this->input->post('batchno');
        $unit = $this->input->post('unit');
        $order_qty = $this->input->post('order_qty');
        $received_qty = $this->input->post('received_qty');
        $free = $this->input->post('free');
        $rate = $this->input->post('rate');
        $purchase_rate = $this->input->post('purchase_rate');
        $cc = $this->input->post('cc');
        $discount = $this->input->post('discount');
        $disamt = $this->input->post('disamt');
        $vat = $this->input->post('vat');
        $vatamt = $this->input->post('vatamt');
        $amount = $this->input->post('amount');
        $expiry_date = $this->input->post('expiry_date');
        $description = $this->input->post('description');
        $temperature = $this->input->post('temperature');
        $pudeid = $this->input->post('pudeid');


        $get_remain_items = $this->general->get_tbl_data('pude_remqty', 'pude_purchaseorderdetail', array('pude_remqty !=' => 0, 'pude_purchasemasterid' => $purchaseordermasterid));

        $count_input_items = count($itemsid);

        $count_remain_items = count($get_remain_items);


        $last_receivedno = $this->get_last_receivedno($fiscalyear, $this->storeid);

        $receivedno = !empty($last_receivedno[0]->recm_receivedno) ? $last_receivedno[0]->recm_receivedno : 0;

        $this->db->trans_begin();

        $currentfyrs = $fiscalyear;

        // echo ORGANIZATION_NAME;
        // die();



        $this->db->select('recm_invoiceno,recm_fyear')
            ->from('recm_receivedmaster')
            ->where('recm_locationid', $this->locationid);
        if (ORGANIZATION_NAME == 'KU') {
            if ($this->mattypeid) {
                $this->db->where('recm_mattypeid', $this->mattypeid);
            } else {
                $this->db->where('recm_mattypeid', $mattypeid);
            }
        }

        $cur_fiscalyrs_invoiceno = $this->db->order_by('recm_fyear', 'DESC')
            ->limit(1)
            ->get()->row();

        // echo "<pre>";
        // echo($this->db->last_query());
        // die();

        // echo "<pre>";
        // print_r($cur_fiscalyrs_invoiceno);
        // die();

        if (!empty($cur_fiscalyrs_invoiceno)) {
            $invoice_format = $cur_fiscalyrs_invoiceno->recm_invoiceno;

            $invoice_string = str_split($invoice_format);
            // echo "<pre>";
            // print_r($invoice_string);
            // die();
            $invoice_prefix_len = strlen(RECEIVED_NO_PREFIX);
            $chk_first_string_after_invoice_prefix = $invoice_string[$invoice_prefix_len];
            // echo $chk_first_string_after_invoice_prefix;
            // die();
            if ($chk_first_string_after_invoice_prefix == '0') {
                $invoice_no_prefix = RECEIVED_NO_PREFIX . CUR_FISCALYEAR;
            } else if ($cur_fiscalyrs_invoiceno->recm_fyear == $currentfyrs && $chk_first_string_after_invoice_prefix == '0') {
                $invoice_no_prefix = RECEIVED_NO_PREFIX . CUR_FISCALYEAR;
            } else if ($cur_fiscalyrs_invoiceno->recm_fyear != $currentfyrs && $chk_first_string_after_invoice_prefix == '0') {
                $invoice_no_prefix = RECEIVED_NO_PREFIX . CUR_FISCALYEAR;
            } else if ($cur_fiscalyrs_invoiceno->recm_fyear != $currentfyrs && $chk_first_string_after_invoice_prefix != '0') {
                $invoice_no_prefix = RECEIVED_NO_PREFIX . CUR_FISCALYEAR;
            } else {
                $invoice_no_prefix = RECEIVED_NO_PREFIX;
            }
        } else {
            $invoice_no_prefix = RECEIVED_NO_PREFIX . CUR_FISCALYEAR;
        }

        // $this->data['received_no']=$this->generate_receiveno();
        if (ORGANIZATION_NAME == 'KU') {
            $invoice_no_prefix = '';
            if ($this->mattypeid) {
                $mattypeid = $this->mattypeid;
            } else {
                $mattypeid = $mattypeid;
            }

            $received_no = $this->general->generate_invoiceno('recm_invoiceno', 'recm_invoiceno', 'recm_receivedmaster', $invoice_no_prefix, RECEIVED_NO_LENGTH, array('recm_mattypeid' => $mattypeid), 'recm_locationid', 'recm_fyear DESC ,recm_receivedmasterid  DESC', 'M', false, 'Y');
            // echo $this->db->last_query();
            // die();
        } else {
            $received_no = $this->general->generate_invoiceno('recm_invoiceno', 'recm_invoiceno', 'recm_receivedmaster', $invoice_no_prefix, RECEIVED_NO_LENGTH, false, 'recm_locationid', 'recm_fyear DESC ,recm_receivedmasterid  DESC', 'M');
        }


        if ($id) {
        } else {
            $attachments = $this->input->post('recm_attach');
            // $attachments = $_FILES;
            $imageList = '';

            if (!empty($attachments)) :
                foreach ($attachments as $key => $value) :
                    $_FILES['attachments']['name'] = $_FILES['recm_attachments']['name'][$key];
                    $_FILES['attachments']['type'] = $_FILES['recm_attachments']['type'][$key];
                    $_FILES['attachments']['tmp_name'] = $_FILES['recm_attachments']['tmp_name'][$key];
                    $_FILES['attachments']['error'] = $_FILES['recm_attachments']['error'][$key];
                    $_FILES['attachments']['size'] = $_FILES['recm_attachments']['size'][$key];

                    if (!empty($_FILES)) {
                        $new_image_name = $_FILES['recm_attachments']['name'][$key];
                        $imgfile = $this->doupload('attachments');
                    } else {
                        $imgfile = '';
                    }

                    $imageList .= $imgfile . ', ';
                endforeach;
            endif;
            $imageName = rtrim($imageList, ', ');

            $receivedMasterArray = array(
                'recm_fyear' => $fiscalyear,
                'recm_supplierid' => $supplierid,
                'recm_purchaseorderno' => $orderno,
                'recm_purchaseorderdatead' => $orderdatead,
                'recm_purchaseorderdatebs' => $orderdatebs,
                'recm_purchaseordermasterid' => $purchaseordermasterid,
                'recm_receivedno' => $receivedno + 1,
                'recm_receiveddatebs' => $received_datebs,
                'recm_receiveddatead' => $received_datead,
                'recm_supplierbillno' => $supplier_bill_no,
                'recm_supbilldatebs' => $suplier_bill_datebs,
                'recm_supbilldatead' => $suplier_bill_datead,
                'recm_clearanceamount' => $clearanceamt,
                'recm_amount' => $totalamount, //
                'recm_discount' => $discountamt,
                'recm_taxamount' => $taxamt,
                'recm_departmentid' => $this->storeid,
                'recm_storeid' => $this->storeid,
                'recm_status' => 'O',
                'recm_invoiceno' => $received_no,
                'recm_insurance' => $insurance,
                'recm_carriagefreight' => $carriage,
                'recm_packing' => $packing,
                'recm_transportcourier' => $transportamt,
                'recm_others' => $otheramt,
                'recm_remarks' => $remarks,
                'recm_budgetid' => $bugetid,
                'recm_postusername' => $this->username,
                'recm_postby' => $this->userid,
                'recm_postdatead' => CURDATE_EN,
                'recm_postdatebs' => CURDATE_NP,
                'recm_posttime' => $this->curtime,
                'recm_postmac' => $this->mac,
                'recm_postip' => $this->ip,
                'recm_locationid' => $this->locationid,
                'recm_orgid' => $this->orgid,
                'recm_attachments' => $imageName
            );

            if (!empty($receivedMasterArray)) {

                if (!empty($mattypeid)) {
                    $receivedMasterArray['recm_mattypeid'] = $mattypeid;
                }
                if (!empty($school)) {
                    $receivedMasterArray['recm_school'] = $school;
                }
                if (!empty($departmentid)) {
                    $receivedMasterArray['recm_departmentid'] = $departmentid;
                }

                if (!empty($receivedby)) {
                    $received_arr = explode(',', $receivedby);
                    $receivedMasterArray['recm_receivedstaffid'] = !empty($received_arr[0]) ? $received_arr[0] : '';
                    $receivedMasterArray['recm_receivedby'] = !empty($received_arr[1]) ? $received_arr[1] : '';
                }
                // echo "<pre>";
                // print_r($receivedMasterArray);
                // die();


                $this->db->insert($this->recm_masterTable, $receivedMasterArray);
                $insert_id = $this->db->insert_id();

                if ($insert_id) {
                    $detail_insertArray = array();
                    // if insert in master, insert in detail table
                    if (!empty($itemsid)) {
                        foreach ($itemsid as $key => $val) :

                            $expiry_date = !empty($expiry_date[$key]) ? $expiry_date[$key] : '';
                            if (DEFAULT_DATEPICKER == 'NP') {
                                $expirydatebs = $expiry_date;
                                $expirydatead = $this->general->NepToEngDateConv($expiry_date);
                            } else {
                                $expirydatead = $expiry_date;
                                $expirydatebs = $this->general->EngToNepDateConv($expiry_date);
                            }

                            $purchased_qty = !empty($received_qty[$key]) ? $received_qty[$key] : 0;
                            $received_rate = !empty($rate[$key]) ? $rate[$key] : 0;
                            $purchaserate = !empty($purchase_rate[$key]) ? $purchase_rate[$key] : 0;
                            $cc_charge = !empty($cc[$key]) ? $cc[$key] : 0;
                            $discountpc = !empty($discount[$key]) ? $discount[$key] : 0;
                            $discountamt = !empty($disamt[$key]) ? $disamt[$key] : 0;
                            $vatpc = !empty($vat[$key]) ? $vat[$key] : 0;
                            $vatamt_total = !empty($vatamt[$key]) ? $vatamt[$key] : 0;
                            $amount_total = !empty($amount[$key]) ? $amount[$key] : 0;
                            $actualrate =    $amount_total / $purchased_qty;

                            $receivedDetailArray = array(
                                'recd_receivedmasterid' => $insert_id,
                                'recd_itemsid' => !empty($itemsid[$key]) ? $itemsid[$key] : '',
                                'recd_purchasedqty' => $purchased_qty,
                                'recd_amount' => $amount_total,
                                'recd_qualitystatus' => 'O',
                                'recd_status' => 'O',
                                'recd_batchno' => !empty($batchno[$key]) ? $batchno[$key] : '',
                                'recd_st' => 'N',
                                'recd_expdatead' => $expirydatead,
                                'recd_expdatebs' => $expirydatebs,
                                'recd_cccharge' => $cc_charge,
                                // 'recd_unitprice' => $purchaserate,
                                'recd_unitprice' => $received_rate,
                                'recd_arate' => $actualrate,
                                'recd_salerate' => $received_rate,
                                'recd_free' => !empty($free[$key]) ? $free[$key] : '',
                                'recd_discountpc' => $discountpc,
                                'recd_discountamt' => $discountamt,
                                'recd_vatpc' => $vatpc,
                                'recd_vatamt' => $vatamt_total,
                                'recd_purchaseorderdetailid' => !empty($pudeid[$key]) ? $pudeid[$key] : '',
                                'recd_description' => !empty($description[$key]) ? $description[$key] : '',
                                'recd_temperature' => !empty($temperature[$key]) ? $temperature[$key] : '',
                                'recd_postusername' => $this->username,
                                'recd_postby' => $this->userid,
                                'recd_postdatead' => CURDATE_EN,
                                'recd_postdatebs' => CURDATE_NP,
                                'recd_posttime' => $this->curtime,
                                'recd_postmac' => $this->mac,
                                'recd_postip' => $this->ip,
                                'recd_locationid' => $this->locationid,
                                'recd_orgid' => $this->orgid
                            );

                            if (!empty($receivedDetailArray)) {
                                $this->db->insert($this->recd_detailTable, $receivedDetailArray);
                                $detail_insertArray[] = $this->db->insert_id();
                            }
                        endforeach;

                        foreach ($itemsid  as $key => $val) {

                            $itemid = !empty($itemsid[$key]) ? $itemsid[$key] : '';
                            $purchased_qty = !empty($received_qty[$key]) ? $received_qty[$key] : 0;
                            $amount_total = !empty($amount[$key]) ? $amount[$key] : 0;

                            $unitprice = $amount_total / $purchased_qty; //!empty($rate[$key])?$rate[$key]:'';
                            $this->general->compare_item_price($itemid, $unitprice);
                            // echo $this->db->last_query();
                        }
                    } // end if itemsid

                    //insert in transaction master table

                    $mattransMasterArray = array(
                        'trma_transactiondatead' => $received_datead,
                        'trma_transactiondatebs' => $received_datebs,
                        'trma_transactiontype' => 'PURCHASE',
                        'trma_fromdepartmentid' => $this->storeid, //recheck
                        'trma_todepartmentid' => $this->storeid, //recheck
                        'trma_status' => 'O',
                        'trma_received' => '1',
                        'trma_fyear' => $fiscalyear,
                        'trma_fromby' => $this->userid, //recheck
                        'trma_toby' => $this->userid, //recheck
                        'trma_sttransfer' => 'N', //N
                        'trma_issueno' => $received_no,
                        'trma_postby' => $this->userid,
                        'trma_postdatead' => CURDATE_EN,
                        'trma_postdatebs' => CURDATE_NP,
                        'trma_posttime' => $this->curtime,
                        'trma_postmac' => $this->mac,
                        'trma_postip' => $this->ip,
                        'trma_locationid' => $this->locationid,
                        'trma_orgid' => $this->orgid
                    );

                    if (!empty($mattransMasterArray)) {
                        $this->db->insert($this->trma_masterTable, $mattransMasterArray);
                        $master_insertid = $this->db->insert_id();
                    }

                    if (!empty($master_insertid)) {
                        if (!empty($itemsid)) :
                            foreach ($itemsid as $key => $value) {
                                $qty_total = !empty($qty[$key]) ? $qty[$key] : 0;

                                $receivedqty = !empty($received_qty[$key]) ? $received_qty[$key] : '';

                                $expiry_date = !empty($expiry_date[$key]) ? $expiry_date[$key] : '';
                                if (DEFAULT_DATEPICKER == 'NP') {
                                    $expirydatebs = $expiry_date;
                                    $expirydatead = $this->general->NepToEngDateConv($expiry_date);
                                } else {
                                    $expirydatead = $expiry_date;
                                    $expirydatebs = $this->general->EngToNepDateConv($expiry_date);
                                }
                                $amount_total = !empty($amount[$key]) ? $amount[$key] : 0;
                                $actualrate =    $amount_total / $receivedqty;


                                $mattransDetailArray[] = array(
                                    'trde_trmaid' => $master_insertid,
                                    'trde_mtdid' => !empty($detail_insertArray[$key]) ? $detail_insertArray[$key] : '',
                                    'trde_transactiondatead' => CURDATE_EN,
                                    'trde_transactiondatebs' => CURDATE_NP,
                                    'trde_itemsid' => !empty($itemsid[$key]) ? $itemsid[$key] : '',
                                    'trde_controlno' => '',
                                    'trde_expdatebs' => $expirydatebs,
                                    'trde_expdatead' => $expirydatead,
                                    'trde_requiredqty' => $receivedqty,
                                    'trde_issueqty' => $receivedqty,
                                    'trde_transferqty' => '',
                                    'trde_status' => 'O', //O
                                    'trde_sysdate' => CURDATE_NP,
                                    'trde_transactiontype' => 'PURCHASE',
                                    'trde_unitprice' => !empty($actualrate) ? $actualrate : '0.00',
                                    'trde_selprice' => !empty($rate[$key]) ? $rate[$key] : '',
                                    'trde_supplierid' => $supplierid,
                                    'trde_mtmid' => $supplierid,
                                    'trde_supplierbillno' => $supplier_bill_no,
                                    'trde_unitvolume' => 0,
                                    'trde_microunitid' => 0,
                                    'trde_totalvalue' => 0,
                                    'trde_description' => !empty($description[$key]) ? $description[$key] : '',
                                    'trde_temperature' => !empty($temperature[$key]) ? $temperature[$key] : '',
                                    'trde_newissueqty' => $receivedqty,
                                    'trde_postby' => $this->userid,
                                    'trde_postdatead' => CURDATE_EN,
                                    'trde_postdatebs' => CURDATE_NP,
                                    'trde_posttime' => $this->curtime,
                                    'trde_postmac' => $this->mac,
                                    'trde_postip' => $this->ip,
                                    'trde_locationid' => $this->locationid,
                                    'trde_orgid' => $this->orgid
                                );
                            }
                        endif;

                        if (!empty($mattransDetailArray)) {
                            $this->db->insert_batch($this->trde_detailTable, $mattransDetailArray);
                        }
                    } // end check if master insertid

                    //purchase order array
                    if (!empty($itemsid)) {
                        $all_total_qty = 0;
                        foreach ($itemsid as $key => $value) {
                            $pude_id = !empty($pudeid[$key]) ? $pudeid[$key] : '';

                            $orderqty = !empty($order_qty[$key]) ? $order_qty[$key] : 0;
                            $receivedqty = !empty($received_qty[$key]) ? $received_qty[$key] : 0;

                            $total_qty = $orderqty - $receivedqty;

                            $pude_array = array(
                                'pude_remqty' => $total_qty
                            );

                            $all_total_qty = $all_total_qty + $total_qty;

                            //update detail table
                            if (!empty($pude_array)) {
                                $this->db->where('pude_puordeid', $pude_id);
                                $this->db->update($this->pude_detailTable, $pude_array);
                            }
                        }

                        // check received status and insert into master table
                        if ($count_input_items >= $count_remain_items) {
                            if ($all_total_qty == 0) {
                                $received_status = 2;
                            } else {
                                $received_status = 1;
                            }
                        } else {
                            $received_status = 1;
                        }


                        $puor_array = array(
                            'puor_status' => 'R',
                            'puor_purchased' => $received_status
                        );

                        if (!empty($puor_array)) {
                            $this->db->where('puor_purchaseordermasterid', $purchaseordermasterid);
                            $this->db->update($this->puor_masterTable, $puor_array);
                        }
                    } // end if itemsid exists for purchase table       
                } // if insertid
            }
        }

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return $insert_id;
        }
    }

    public function save_attachment()
    {
        //check id
        $id = $this->input->post('id');
        if ($id) {
            $old_image = $this->general->get_tbl_data('recm_attachments', 'recm_receivedmaster', array('recm_receivedmasterid' => $id), false, 'ASC');
            $attachments = $this->input->post('recm_attach');
            $imageList = '';

            if (!empty($attachments)) :
                foreach ($attachments as $key => $value) :
                    $_FILES['attachments']['name'] = $_FILES['recm_attachments']['name'][$key];
                    $_FILES['attachments']['type'] = $_FILES['recm_attachments']['type'][$key];
                    $_FILES['attachments']['tmp_name'] = $_FILES['recm_attachments']['tmp_name'][$key];
                    $_FILES['attachments']['error'] = $_FILES['recm_attachments']['error'][$key];
                    $_FILES['attachments']['size'] = $_FILES['recm_attachments']['size'][$key];

                    if (!empty($_FILES)) {
                        $new_image_name = $_FILES['recm_attachments']['name'][$key];
                        $imgfile = $this->adoupload('attachments');
                    } else {
                        $imgfile = '';
                    }
                    $imageList .= $imgfile . ', ';
                endforeach;
            endif;
            $imageName = rtrim($imageList, ', ');
            if (!empty($old_image)) {
                $append_image = $old_image[0]->recm_attachments . ', ' . $imageName;
                $receivedMasterArray = array(
                    'recm_attachments' => $append_image
                );
            } elseif (!empty($imageName)) {
                $receivedMasterArray = array(
                    'recm_attachments' => $imageName
                );
            }
            if (!empty($receivedMasterArray)) {
                $this->db->where('recm_receivedmasterid', $id);
                $this->db->update($this->recm_masterTable, $receivedMasterArray);
                return $id;
            }
            return false;
        }
        return false;
    }

    function get_purchasemasterid($purchaseorderno, $fiscalyear, $storeid)
    {
        try {
            if (empty($purchaseorderno) || empty($fiscalyear) || empty($storeid)) {
                echo "Error occured. Please try again";
                return false;
            }

            $this->db->select('puor_purchaseordermasterid');
            $this->db->from('puor_purchaseordermaster');
            $this->db->where('puor_orderno', $purchaseorderno);
            $this->db->where('puor_fyear', $fiscalyear);
            $this->db->where('puor_storeid', $storeid);

            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                return $query->result();
            }
            return false;
        } catch (Exception $e) {
            throw $e;
        }
    }

    function get_last_receivedno($fiscalyear, $storeid)
    {
        try {
            if (empty($fiscalyear) || empty($storeid)) {
                echo "Error occured. Please try again";
                return false;
            }

            $this->db->select_max('recm_receivedno');
            $this->db->from('recm_receivedmaster');
            $this->db->where('recm_fyear', $fiscalyear);
            $this->db->where('recm_departmentid', $storeid);
            $this->db->where('recm_locationid', $this->locationid);

            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                return $query->result();
            }
            return false;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function get_order_list($cond = false)
    {
        $get = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }

        if (!empty($get['sSearch_1'])) {
            $this->db->where("puor_orderno like  '%" . $get['sSearch_1'] . "%'  ");
        }

        if (!empty($get['sSearch_2'])) {
            $this->db->where("puor_requno like  '%" . $get['sSearch_2'] . "%'  ");
        }

        if (!empty($get['sSearch_3'])) {
            if (DEFAULT_DATEPICKER == 'NP') {
                $this->db->where("puor_orderdatebs like  '%" . $get['sSearch_3'] . "%'  ");
            } else {
                $this->db->where("puor_orderdatead like  '%" . $get['sSearch_3'] . "%'  ");
            }
        }

        if (!empty($get['sSearch_4'])) {
            $this->db->where("dist_distributor like  '%" . $get['sSearch_4'] . "%'  ");
        }

        if (!empty($get['sSearch_5'])) {
            $this->db->where("puor_amount like  '%" . $get['sSearch_5'] . "%'  ");
        }

        if ($cond) {
            $this->db->where($cond);
        }

        $resltrpt = $this->db->select("COUNT(*) as cnt")
            ->from('puor_purchaseordermaster po')
            ->join('dist_distributors dist', 'po.puor_supplierid = dist.dist_distributorid', 'left')
            ->where('puor_purchased <>', 2)
            ->get()
            ->row();

        $totalfilteredrecs = $resltrpt->cnt;

        $order_by = 'puor_orderno';
        $order = 'desc';

        $where = '';
        if ($this->input->get('iSortCol_0') == 1)
            $order_by = 'puor_orderno';
        else if ($this->input->get('iSortCol_0') == 2)
            $order_by = 'puor_requno';
        else if ($this->input->get('iSortCol_0') == 3)
            $order_by = 'puor_orderdatebs';
        else if ($this->input->get('iSortCol_0') == 4)
            $order_by = 'dist_distributor';
        else if ($this->input->get('iSortCol_0') == 5)
            $order_by = 'puor_amount';

        $totalrecs = '';
        $limit = 15;
        $offset = 1;
        $get = $_GET;

        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }
        if ($this->input->get('sSortDir_0')) {
            $order = $this->input->get('sSortDir_0');
        }

        if (!empty($_GET["iDisplayLength"])) {
            $limit = $_GET['iDisplayLength'];
            $offset = $_GET["iDisplayStart"];
        }

        if (!empty($get['sSearch_1'])) {
            $this->db->where("puor_orderno like  '%" . $get['sSearch_1'] . "%'  ");
        }

        if (!empty($get['sSearch_2'])) {
            $this->db->where("puor_requno like  '%" . $get['sSearch_2'] . "%'  ");
        }

        if (!empty($get['sSearch_3'])) {
            if (DEFAULT_DATEPICKER == 'NP') {
                $this->db->where("puor_orderdatebs like  '%" . $get['sSearch_3'] . "%'  ");
            } else {
                $this->db->where("puor_orderdatead like  '%" . $get['sSearch_3'] . "%'  ");
            }
        }

        if (!empty($get['sSearch_4'])) {
            $this->db->where("dist_distributor like  '%" . $get['sSearch_4'] . "%'  ");
        }

        if (!empty($get['sSearch_5'])) {
            $this->db->where("puor_amount like  '%" . $get['sSearch_5'] . "%'  ");
        }

        $this->db->select('po.puor_purchaseordermasterid, po.puor_orderno, po.puor_requno, po.puor_orderdatead, po.puor_orderdatebs, po.puor_supplierid, po.puor_amount, dist.dist_distributor');
        $this->db->from('puor_purchaseordermaster po');
        $this->db->join('dist_distributors dist', 'po.puor_supplierid = dist.dist_distributorid', 'left');
        $this->db->where('puor_purchased <>', 2);

        if ($cond) {
            $this->db->where($cond);
        }

        if ($limit && $limit > 0) {
            $this->db->limit($limit);
        }

        if ($offset) {
            $this->db->offset($offset);
        }
        $this->db->order_by($order_by, $order);

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

    public function get_order_details($srchcol = false)
    {
        $this->db->select('it.itli_itemcode as itemcode, it.itli_itemname as itemname,it.itli_itemnamenp as itemnamenp, it.itli_itemlistid, it.itli_purchaserate, it.itli_salesrate, pd.pude_puordeid, pd.pude_itemsid, pd.pude_quantity as quantity, pd.pude_unit as unit_unitname, pd.pude_rate as rate, pd.pude_amount,pd.pude_discount, pd.pude_vat, pd.pude_remqty, pd.pude_remarks');
        $this->db->from('pude_purchaseorderdetail pd');
        $this->db->join('itli_itemslist it', 'it.itli_itemlistid = pd.pude_itemsid', 'left');

        if ($srchcol) {
            $this->db->where($srchcol);
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result;
        }
        return false;
    }

    public function doupload($file)
    {
        // echo "test";
        // die();
        $config['upload_path'] = './' . RECEIVED_BILL_ATTACHMENT_PATH; //define in constants
        $config['allowed_types'] = 'png|jpg|gif|jpeg|pdf';
        $config['encrypt_name'] = TRUE;
        $config['remove_spaces'] = TRUE;
        $config['max_size'] = '2000000';
        $config['max_width'] = '5000';
        $config['max_height'] = '5000';
        $this->upload->initialize($config);
        $this->load->library('upload', $config);
        $this->upload->do_upload($file);
        $data = $this->upload->data();
        // echo "<pre>";
        // echo "file: ";
        // print_r($file);
        // echo "<br/>";
        // echo "Data: ";
        // print_r($data);
        // exit;
        $name_array = $data['file_name'];
        // echo $name_array;
        // exit;
        // $names= implode(',', $name_array);   
        //     // return $names;   
        return $name_array;
    }

    public function adoupload($file)
    {
        // echo "test";
        // die();
        $config['upload_path'] = './' . RECEIVED_BILL_ATTACHMENT_PATH; //define in constants
        $config['allowed_types'] = 'png|jpg|gif|jpeg|pdf';
        $config['encrypt_name'] = TRUE;
        $config['remove_spaces'] = TRUE;
        $config['max_size'] = '2000000';
        $config['max_width'] = '5000';
        $config['max_height'] = '5000';
        $this->upload->initialize($config);
        $this->load->library('upload', $config);
        $this->upload->do_upload($file);
        $data = $this->upload->data();
        // echo "<pre>";
        // echo "file: ";
        // print_r($file);
        // echo "<br/>";
        // echo "Data: ";
        // print_r($data);
        // exit;
        $name_array = $data['file_name'];
        // echo $name_array;
        // exit;
        // $names= implode(',', $name_array);   
        //     // return $names;   
        return $name_array;
    }


    public function get_receive_master($srchcol = false)
    {

        $locationid = $this->input->post('locationid');
        $this->db->select('rm.*');
        $this->db->from('recm_receivedmaster rm');

        if ($srchcol) {
            $this->db->where($srchcol);
        }

        // if(!empty($locationid)){
        //     $this->db->where('recm_locationid',$locationid);
        // }else{
        //     $this->db->where('recm_locationid',$this->locationid);
        // }


        $query = $this->db->get();
        // echo $this->db->last_query();
        // die();
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data;
        }
        return false;
    }

    public function get_receive_detail($srchcol = false)
    {
        $this->db->select('rm.recm_receivedmasterid,rm.recm_purchaseorderno,rm.recm_fyear,it.itli_itemname,it.itli_itemnamenp, it.itli_itemcode, s.dist_distributor, s.dist_distributorid, un.unit_unitname,rd.recd_purchasedqty,rd.recd_unitprice,(recd_purchasedqty*recd_unitprice) total,rd.recd_discountamt,rd.recd_vatamt,rd.recd_amount,rd.recd_locationid,rm.recm_receiveddatebs,rm.recm_receiveddatead,rm.recm_supbilldatebs, rm.recm_challanno, rd.recd_receiveddetailid, rm.recm_receivedmasterid, it.itli_itemlistid');
        $this->db->from('recd_receiveddetail rd');
        $this->db->join('recm_receivedmaster rm', 'rm.recm_receivedmasterid=rd.recd_receivedmasterid', "LEFT");
        $this->db->join('dist_distributors s', 's.dist_distributorid = rm.recm_supplierid', 'LEFT');
        $this->db->join('itli_itemslist it', 'it.itli_itemlistid=rd.recd_itemsid', 'LEFT');
        $this->db->join('unit_unit un', 'un.unit_unitid=it.itli_unitid', 'LEFT');
        $this->db->where('(recm_purchaseordermasterid != 0 OR recm_challanno != 0)');

        if ($srchcol) {
            $this->db->where($srchcol);
        }
        $query = $this->db->get();
        // echo $this->db->last_query(); die();
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data;
        }
        return false;
    }

    public function get_receive_detail_item($srchcol)
    {
        $this->db->select('rd.recd_itemsid,it.itli_itemname,it.itli_itemnamenp, it.itli_itemcode, un.unit_unitname,rd.recd_purchasedqty,rd.recd_unitprice,(recd_purchasedqty*recd_unitprice) total,rd.recd_arate,rd.recd_free,rd.recd_discountpc, rd.recd_discountamt,rd.recd_vatpc,rd.recd_vatamt,rd.recd_amount,rd.recd_purchaseorderdetailid,rd.recd_challandetailid,rd.recd_description,rd.recd_tenderid,rd.recd_discounttype,,rd.recd_locationid, rd.recd_receiveddetailid,it.itli_itemlistid,pod.pude_quantity as orderqty');
        $this->db->from('recd_receiveddetail rd');
        $this->db->join('itli_itemslist it', 'it.itli_itemlistid=rd.recd_itemsid', 'LEFT');
        $this->db->join('pude_purchaseorderdetail pod', 'pod.pude_puordeid=rd.recd_purchaseorderdetailid', 'LEFT');
        $this->db->join('unit_unit un', 'un.unit_unitid=it.itli_unitid', 'LEFT');

        if ($srchcol) {
            $this->db->where($srchcol);
        }
        $query = $this->db->get();
        // echo $this->db->last_query(); die();
        if ($query->num_rows() > 0) {
            $data = $query->result();
            return $data;
        }
        return false;
    }

    public function getStatusCount($srchcol = false, $type = false)
    {
        try {
            $locationid = $this->input->post('locid');

            if ($type == 'cancel') {
                $this->db->select("SUM(CASE WHEN recm_status='M' THEN 1 ELSE 0 END ) cancel");
                $this->db->from('recm_receivedmaster');
                if (!empty($locationid)) {
                    $this->db->where('recm_locationid', $locationid);
                } else {
                    $this->db->where('recm_locationid', $this->locationid);
                }
            } else {
                $this->db->select("SUM('recm_status') total");
                $this->db->from('recm_receivedmaster');
                if (!empty($locationid)) {
                    $this->db->where('recm_locationid', $locationid);
                } else {
                    $this->db->where('recm_locationid', $this->locationid);
                }
            }


            if ($srchcol) {
                $this->db->where($srchcol);
            }

            $query = $this->db->get();
            // echo $this->db->last_query();
            // die();

            if ($query->num_rows() > 0) {
                return $query->result();
            }
            return false;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function get_receive_status()
    {
        $receive_cancel = '';
        $locationid = $this->input->post('locid');
        $frmdate = $this->input->post('frmdate');
        $todate = $this->input->post('todate');
        if ($locationid) {
            $receive_cancel .= " AND recm_locationid = $locationid  ";
        }
        if (!empty($frmdate) && !empty($todate)) {
            if (DEFAULT_DATEPICKER == 'NP') {
                $receive_cancel .= " AND recm_receiveddatebs >='" . $frmdate . "' AND recm_receiveddatebs <='" . $todate . "'  ";
            } else {
                $receive_cancel .= " AND  recm_receiveddatead >='" . $frmdate . "' AND recm_receiveddatead <='" . $todate . "'   ";
            }
        }
        $sql = "SELECT SUM(cancel)cancel, total
    FROM(
        SELECT SUM( CASE WHEN recm_status = 'M' THEN 1 ELSE 0 END ) cancel, count(recm_status) total
         FROM xw_recm_receivedmaster WHERE recm_receivedmasterid IS NOT NULL  $receive_cancel  )X";
        $result = $this->db->query($sql)->row();
        if (!empty($result)) {
            return $result;
        }
        return false;
    }

    public function update_receive_data()
    {
        //check id
        try {

            $id = $this->input->post('id');
            $received_date = $this->input->post('received_date');
            $supplier_bill_no = $this->input->post('suplier_bill_no');
            $suplier_bill_date = $this->input->post('suplier_bill_date');
            $receivedmasterid = $this->input->post('receivedmasterid');
            $supplierid = $this->input->post('supplierid');
            $school = $this->input->post('recm_school');
            $departmentid = $this->input->post('recm_departmentid');
            $recm_subdepartmentid = $this->input->post('recm_subdepartmentid');
            if (!empty($recm_subdepartmentid)) {
                $departmentid = $recm_subdepartmentid;
            }


            $bugetid = $this->input->post('bugetid');
            $received_by = $this->input->post('recm_receivedby');
            $receivedby = explode(',', $received_by);

            if (DEFAULT_DATEPICKER == 'NP') {
                $received_datebs = $received_date;
                $received_datead = $this->general->NepToEngDateConv($received_date);
                $suplier_bill_datebs = $suplier_bill_date;
                $suplier_bill_datead = $this->general->NepToEngDateConv($suplier_bill_date);
            } else {
                // $orderdatead = $orderdate;
                // $orderdatebs = $this->general->EngToNepDateConv($orderdate);
                $received_datead = $received_date;
                $received_datebs = $this->general->EngToNepDateConv($received_date);

                $suplier_bill_datead = $suplier_bill_date;
                $suplier_bill_datebs = $this->general->EngToNepDateConv($suplier_bill_date);
            }

            // echo $received_datead;
            // echo $received_datebs;
            // die();


            $remarks = $this->input->post('remarks');
            $totalamount = $this->input->post('totalamount');
            $insurance = $this->input->post('insurance');
            $carriage = $this->input->post('carriage');
            $packing = $this->input->post('packing');
            $transportamt = $this->input->post('transportamt');
            $otheramt = $this->input->post('otheramt');
            $bill_amount = $this->input->post('billamount');
            $discountamt = $this->input->post('discountamt');
            $discountamt_overall = $this->input->post('discountamt_overall');
            $subtotalamt = $this->input->post('subtotalamt');
            $taxamt = $this->input->post('taxamt');
            $extra = $this->input->post('extra');
            $refund = $this->input->post('refund');
            $clearanceamt = $this->input->post('clearanceamt');

            //received detail ID data
            $receiveddetailid = $this->input->post('recd_receiveddetailid');
            $itemsid = $this->input->post('itemsid');
            $received_qty = $this->input->post('received_qty');
            $rate = $this->input->post('rate');
            $free = $this->input->post('free');
            $purchase_rate = $this->input->post('purchase_rate');
            $cc = $this->input->post('cc');
            $discount = $this->input->post('discount');
            $disamt = $this->input->post('disamt');
            $vat = $this->input->post('vat');
            $vatamt = $this->input->post('vatamt');
            $amount = $this->input->post('amount');
            $ratexqty = $this->input->post('ratexqty');
            $expiry_date = $this->input->post('expiry_date');
            $temperature = $this->input->post('temperature');
            $description = $this->input->post('description');
            $batchno = $this->input->post('batchno');


            $pudeid = $this->input->post('pudeid');





            // echo "<pre>";
            // print_r($this->input->post('recd_receiveddetailid'));
            // die();
            $trans_main_id = '';
            if (!empty($receiveddetailid)) :
                $first_rec_dtlid = !empty($receiveddetailid[0]) ? $receiveddetailid[0] : '';
                // echo "f_r_d".$first_rec_dtlid;
                $this->db->select('trde_trdeid,trde_trmaid');
                $this->db->from('trde_transactiondetail');
                $this->db->where('trde_mtdid', $first_rec_dtlid);
                $this->db->order_by('trde_trdeid', 'ASC');
                $rslt_trdetail = $this->db->get()->row();

                // echo "<pre>";
                // print_r($rslt_trdetail);
                // die();
                if (!empty($rslt_trdetail)) {
                    $trans_main_id = $rslt_trdetail->trde_trmaid;
                }

            endif;
            // die();
            // echo $trans_main_id;
            // die();


            $result_receivedid_db = $this->db->select('recd_receiveddetailid,recd_itemsid')
                ->from('recd_receiveddetail')
                ->where(array('recd_receivedmasterid' => $receivedmasterid))->get()->result();
            // echo "<pre>";
            // print_r($result_receivedid_db);
            // die();
            $db_receivedid = array();
            if (!empty($result_receivedid_db)) {
                foreach ($result_receivedid_db as $rrd) {
                    $db_receivedid[] = $rrd->recd_receiveddetailid;
                }
            }

            // $db_receivedid=array();

            //  echo "<pre>";
            // print_r($db_receivedid);
            // die();
            $rec_diff = array_diff($db_receivedid, $receiveddetailid);
            // echo "<pre>";
            // print_r($rec_diff);
            // die();
            /* Update For remove iteme id */
            if (!empty($rec_diff)) {
                $this->db->where_in('recd_receiveddetail', $rec_diff);
                $this->db->update('recd_receiveddetail', array('recd_status' => 'M'));
                $this->db->where_in('trde_mtdid', $rec_diff);
                $this->db->update('trde_transactiondetail', array('trde_status' => 'M'));
            }
            $receivedDetailUpdateArray = array();
            $tran_detailUpdateArray = array();
            $UpdatereceivedMasterArray = array(
                'recm_receiveddatebs' => $received_datebs,
                'recm_receiveddatead' => $received_datead,
                'recm_supplierid' => $supplierid,
                'recm_supplierbillno' => $supplier_bill_no,
                'recm_supbilldatebs' => $suplier_bill_datebs,
                'recm_supbilldatead' => $suplier_bill_datead,
                'recm_clearanceamount' => $clearanceamt,
                'recm_amount' => $totalamount, //
                'recm_discount' => $discountamt,
                'recm_taxamount' => $taxamt,
                'recm_insurance' => $insurance,
                'recm_carriagefreight' => $carriage,
                'recm_packing' => $packing,
                'recm_transportcourier' => $transportamt,
                'recm_others' => $otheramt,
                'recm_remarks' => $remarks,
                'recm_budgetid' => $bugetid,
                'recm_receivedby' => $receivedby[1],
                'recm_receivedstaffid' => $receivedby[0]
            );


            $updateTransmasterArray = array(
                'trma_transactiondatead' => $received_datead,
                'trma_transactiondatebs' => $received_datebs,
                'trma_modifytime' => $this->curtime,
                'trma_modifyby' => $this->userid,
                'trma_modifyip' => $this->ip,
                'trma_modifymac' => $this->mac,
                'trma_receiveddatead' => $received_datead,
                'trma_receiveddatebs' => $received_datebs,
            );


            if (!empty($UpdatereceivedMasterArray)) {
                 if (!empty($school)) {
                    $UpdatereceivedMasterArray['recm_school'] = $school;
                }
                if (!empty($departmentid)) {
                    $UpdatereceivedMasterArray['recm_departmentid'] = $departmentid;
                }
                
                $this->db->update('recm_receivedmaster', $UpdatereceivedMasterArray, array('recm_receivedmasterid' => $receivedmasterid));
                $this->general->save_log('recm_receivedmaster', 'recm_receivedmasterid', $receivedmasterid, $UpdatereceivedMasterArray, 'Update');

                if (!empty($updateTransmasterArray)) {
                    $this->db->update('trma_transactionmain', $updateTransmasterArray, array('trma_trmaid' => $trans_main_id));
                    $this->general->save_log('trma_transactionmain', 'trma_trmaid', $trans_main_id, $updateTransmasterArray, 'Update');
                }

                if (!empty($itemsid)) {
                    foreach ($itemsid as $key => $val) :
                        $expiry_date = !empty($expiry_date[$key]) ? $expiry_date[$key] : '';
                        if (DEFAULT_DATEPICKER == 'NP') {
                            $expirydatebs = $expiry_date;
                            $expirydatead = $this->general->NepToEngDateConv($expiry_date);
                        } else {
                            $expirydatead = $expiry_date;
                            $expirydatebs = $this->general->EngToNepDateConv($expiry_date);
                        }

                        $purchased_qty = !empty($received_qty[$key]) ? $received_qty[$key] : 0;
                        $received_rate = !empty($rate[$key]) ? $rate[$key] : 0;
                        $purchaserate = !empty($purchase_rate[$key]) ? $purchase_rate[$key] : 0;
                        $cc_charge = !empty($cc[$key]) ? $cc[$key] : 0;
                        $discountpc = !empty($discount[$key]) ? $discount[$key] : 0;
                        $discountamt = !empty($disamt[$key]) ? $disamt[$key] : 0;
                        $vatpc = !empty($vat[$key]) ? $vat[$key] : 0;
                        $vatamt_total = !empty($vatamt[$key]) ? $vatamt[$key] : 0;
                        $amount_total = !empty($amount[$key]) ? $amount[$key] : 0;
                        $actualrate =    $amount_total / $purchased_qty;

                        $receivedDetailUpdateArray[] = array(
                            'recd_receiveddetailid' => !empty($receiveddetailid[$key]) ? $receiveddetailid[$key] : '',
                            'recd_itemsid' => !empty($itemsid[$key]) ? $itemsid[$key] : '',
                            'recd_purchasedqty' => $purchased_qty,
                            'recd_amount' => $amount_total,
                            'recd_batchno' => !empty($batchno[$key]) ? $batchno[$key] : '',
                            'recd_expdatead' => $expirydatead,
                            'recd_expdatebs' => $expirydatebs,
                            'recd_cccharge' => $cc_charge,
                            'recd_unitprice' => $received_rate,
                            'recd_arate' => $actualrate,
                            'recd_salerate' => $received_rate,
                            'recd_free' => !empty($free[$key]) ? $free[$key] : '',
                            'recd_discountpc' => $discountpc,
                            'recd_discountamt' => $discountamt,
                            'recd_vatpc' => $vatpc,
                            'recd_vatamt' => $vatamt_total,
                            'recd_description' => !empty($description[$key]) ? $description[$key] : '',
                            'recd_temperature' => !empty($temperature[$key]) ? $temperature[$key] : ''
                        );
                        // endforeach;

                        $tran_detailUpdateArray[] = array(
                            'trde_mtdid' => !empty($receiveddetailid[$key]) ? $receiveddetailid[$key] : '',
                            'trde_transactiondatead' => $received_datead,
                            'trde_transactiondatebs' => $received_datebs,
                            'trde_itemsid' => !empty($itemsid[$key]) ? $itemsid[$key] : '',
                            'trde_expdatebs' => $expirydatebs,
                            'trde_expdatead' => $expirydatead,
                            'trde_requiredqty' => !empty($receivedqty[$key]) ? $receivedqty[$key] : '0.00',
                            'trde_issueqty' => !empty($receivedqty[$key]) ? $receivedqty[$key] : '0.00',
                            'trde_status' => 'O',
                            'trde_unitprice' => $actualrate,
                            'trde_selprice' => !empty($rate[$key]) ? $rate[$key] : '',
                            'trde_description' => !empty($description[$key]) ? $description[$key] : '',
                            'trde_temperature' => !empty($temperature[$key]) ? $temperature[$key] : '',
                            'trde_newissueqty' => !empty($receivedqty[$key]) ? $receivedqty[$key] : '0.00',
                             'trde_supplierid' => $supplierid,
                             'trde_mtmid' => $supplierid,
                        );
                    endforeach;

                    if (!empty($receivedDetailUpdateArray)) {
                        $this->db->update_batch('recd_receiveddetail', $receivedDetailUpdateArray, 'recd_receiveddetailid');
                    }
                    if (!empty($tran_detailUpdateArray)) {
                        $this->db->update_batch('trde_transactiondetail', $tran_detailUpdateArray, 'trde_mtdid');
                    }
                }
            }
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                // echo "rollback";
                return false;
            } else {
                $this->db->trans_commit();
                // echo "committed";
                return $receivedmasterid;
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            // echo "Error";
            return false;
        }
    }
}
