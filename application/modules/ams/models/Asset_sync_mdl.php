<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Asset_sync_mdl extends CI_Model

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

    public $validate_settings_asset_sync = array(

        array('field' => 'asen_assetcode[]', 'label' => 'Asset Code', 'rules' => 'trim|required|xss_clean'),

        // array('field' => 'asen_serialno[]', 'label' => 'Asset Serial No.', 'rules' => 'trim|required|xss_clean')

    );

    public function get_itemslist_from_inventory($cond = false)

    {

        // $locationid=$this->input->get('locationid');

        $frmDate = $this->input->get('frmDate');

        $toDate = $this->input->get('toDate');

        // $category_id=!empty($this->input->get('categoryid'))?$this->input->get('categoryid'):'';

        $category_id = $this->input->get('categoryid');

        $get = $_GET;

        foreach ($get as $key => $value) {

            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }

        if (!empty($get['sSearch_1'])) {

            $this->db->where("recm_receiveddatead like  '%" . $get['sSearch_1'] . "%'  ");
        }

        if (!empty($get['sSearch_2'])) {

            $this->db->where("recm_receiveddatebs like  '%" . $get['sSearch_2'] . "%'  ");
        }

        if (!empty($get['sSearch_3'])) {

            $this->db->where("recm_receivedno like  '%" . $get['sSearch_3'] . "%'  ");
        }

        if (!empty($get['sSearch_4'])) {

            $this->db->where("itli_itemcode like  '%" . $get['sSearch_4'] . "%'  ");
        }

        if (!empty($get['sSearch_5'])) {

            $this->db->where("itli_itemname like  '%" . $get['sSearch_5'] . "%'  ");
        }

        if (!empty($get['sSearch_6'])) {

            $this->db->where("itli_itemnamenp like  '%" . $get['sSearch_6'] . "%'  ");
        }

        if (!empty($get['sSearch_7'])) {

            $this->db->where("eqca_category like  '%" . $get['sSearch_7'] . "%'  ");
        }

        if (!empty($get['sSearch_8'])) {

            $this->db->where("dist_distributor like  '%" . $get['sSearch_8'] . "%'  ");
        }

        if ($cond) {

            $this->db->where($cond);
        }

        $input_locationid = !empty($get['locationid']) ? $get['locationid'] : $this->input->post('locationid');

        if (!empty(($frmDate && $toDate))) {

            if (DEFAULT_DATEPICKER == 'NP') {

                $this->db->where('rm.recm_receiveddatebs >=', $frmDate);

                $this->db->where('rm.recm_receiveddatebs <=', $toDate);
            } else {

                $this->db->where('rm.recm_receiveddatead >=', $frmDate);

                $this->db->where('rm.recm_receiveddatead <=', $toDate);
            }
        }

        if ($input_locationid) {

            $this->db->where('tm.trma_locationid', $this->locationid);
        }

        if (!empty($category_id)) {

            $this->db->where('itli_catid', $category_id);
        }

        $where = "(trma_transactiontype = 'OPENING' or trma_transactiontype = 'PURCHASE' or trma_transactiontype = 'D.RECEIVE')";

        $resltrpt = $this->db->select("COUNT(*) as cnt")

            //->from('sama_salemaster rn')

            ->from('trma_transactionmain tm')

            ->join('trde_transactiondetail td', 'td.trde_trmaid = tm.trma_trmaid', 'LEFT')

            ->join('recd_receiveddetail rd', 'rd.recd_receiveddetailid = td.trde_mtdid', 'LEFT')

            ->join('recm_receivedmaster rm', 'rm.recm_receivedmasterid = rd.recd_receivedmasterid', 'LEFT')

            ->join('itli_itemslist il', 'il.itli_itemlistid = td.trde_itemsid', 'LEFT')

            ->join('dist_distributors d', 'd.dist_distributorid = rm.recm_supplierid', 'LEFT')

            ->join('eqca_equipmentcategory ec', 'ec.eqca_equipmentcategoryid = il.itli_catid', 'LEFT')

            ->where('trde_isassetsync ', 'N')

            ->where('itli_materialtypeid', '2')

            ->where($where)

            ->get()

            ->row();

        // echo $this->db->last_query();die(); 

        $totalfilteredrecs = ($resltrpt->cnt);

        $order_by = 'recm_receivedno';

        $order = 'desc';

        if ($this->input->get('sSortDir_0')) {

            $order = $this->input->get('sSortDir_0');
        }

        $where = '';

        if ($this->input->get('iSortCol_0') == 1)

            $order_by = 'recm_receiveddatead';

        else if ($this->input->get('iSortCol_0') == 2)

            $order_by = 'recm_receiveddatebs';

        else if ($this->input->get('iSortCol_0') == 3)

            $order_by = 'recm_receivedno';

        else if ($this->input->get('iSortCol_0') == 4)

            $order_by = 'itli_itemcode';

        else if ($this->input->get('iSortCol_0') == 5)

            $order_by = 'itli_itemname';

        else if ($this->input->get('iSortCol_0') == 6)

            $order_by = 'itli_itemnamenp';

        else if ($this->input->get('iSortCol_0') == 7)

            $order_by = 'eqca_category';

        else if ($this->input->get('iSortCol_0') == 8)

            $order_by = 'dist_distributor';

        else if ($this->input->get('iSortCol_0') == 9)

            $order_by = 'trde_requiredqty';

        else if ($this->input->get('iSortCol_0') == 10)

            $order_by = 'trde_selprice';

        else if ($this->input->get('iSortCol_0') == 11)

            $order_by = 'recm_amount';

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

            $this->db->where("recm_receiveddatead like  '%" . $get['sSearch_1'] . "%'  ");
        }

        if (!empty($get['sSearch_2'])) {

            $this->db->where("recm_receiveddatebs like  '%" . $get['sSearch_2'] . "%'  ");
        }

        if (!empty($get['sSearch_3'])) {

            $this->db->where("recm_receivedno like  '%" . $get['sSearch_3'] . "%'  ");
        }

        if (!empty($get['sSearch_4'])) {

            $this->db->where("itli_itemcode like  '%" . $get['sSearch_4'] . "%'  ");
        }

        if (!empty($get['sSearch_5'])) {

            $this->db->where("itli_itemname like  '%" . $get['sSearch_5'] . "%'  ");
        }

        if (!empty($get['sSearch_6'])) {

            $this->db->where("itli_itemnamenp like  '%" . $get['sSearch_6'] . "%'  ");
        }

        if (!empty($get['sSearch_7'])) {

            $this->db->where("eqca_category like  '%" . $get['sSearch_7'] . "%'  ");
        }

        if (!empty($get['sSearch_8'])) {

            $this->db->where("dist_distributor like  '%" . $get['sSearch_8'] . "%'  ");
        }

        if (!empty(($frmDate && $toDate))) {

            if (DEFAULT_DATEPICKER == 'NP') {

                $this->db->where('rm.recm_receiveddatebs >=', $frmDate);

                $this->db->where('rm.recm_receiveddatebs <=', $toDate);
            } else {

                $this->db->where('rm.recm_receiveddatead >=', $frmDate);

                $this->db->where('rm.recm_receiveddatead <=', $toDate);
            }
        }

        if ($cond) {

            $this->db->where($cond);
        }

        if ($input_locationid) {

            $this->db->where('tm.trma_locationid', $this->locationid);
        }

        if (!empty($category_id)) {

            $this->db->where('itli_catid', $category_id);
        }

        $this->db->select('tm.trma_trmaid, itli_itemlistid, itli_itemcode, itli_itemname, itli_itemnamenp, td.trde_trdeid, td.trde_requiredqty, td.trde_stripqty, tm.trma_transactiontype, td.trde_itemsid, td.trde_mtdid, recm_receivedmasterid, td.trde_unitprice, td.trde_selprice, itli_purchaserate, itli_salesrate, td.trde_supplierid, td.trde_description, itli_materialtypeid, itli_catid, itli_unitid, itli_typeid, tm.trma_transactiondatead, tm.trma_transactiondatebs, rm.recm_receiveddatead, rm.recm_receiveddatebs, rm.recm_invoiceno recm_receivedno, rm.recm_amount, tm.trma_fyear, d.dist_distributor, ec.eqca_category');

        $this->db->from('trma_transactionmain tm');

        $this->db->join('trde_transactiondetail td', 'td.trde_trmaid = tm.trma_trmaid', 'LEFT');

        $this->db->join('recd_receiveddetail rd', 'rd.recd_receiveddetailid = td.trde_mtdid', 'LEFT');

        $this->db->join('recm_receivedmaster rm', 'rm.recm_receivedmasterid = rd.recd_receivedmasterid', 'LEFT');

        $this->db->join('itli_itemslist il', 'il.itli_itemlistid = td.trde_itemsid', 'LEFT');

        $this->db->join('dist_distributors d', 'd.dist_distributorid = rm.recm_supplierid', 'LEFT');

        $this->db->join('eqca_equipmentcategory ec', 'ec.eqca_equipmentcategoryid = il.itli_catid', 'LEFT');

        $this->db->where('itli_materialtypeid', 2);

        $this->db->where('trde_isassetsync ', 'N');

        $where = "(trma_transactiontype = 'OPENING' or trma_transactiontype = 'PURCHASE' or trma_transactiontype = 'D.RECEIVE')";

        $this->db->where($where);

        $this->db->order_by($order_by, $order);

        if ($limit && $limit > 0) {

            $this->db->limit($limit);
        }

        if ($offset) {

            $this->db->offset($offset);
        }

        $nquery = $this->db->get();

        // echo $this->db->last_query();die();

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

    public function get_item_synch_summary_ku($cond = false)
    {
        $get = $_GET;
        $frmDate = $this->input->get('frmDate');
        $toDate = $this->input->get('toDate');
        $category_id = $this->input->get('categoryid');
        $supplierid = $this->input->get('supplierid');
        $schoolid = !empty($get['schoolid']) ? $get['schoolid'] : $this->input->post('schoolid');
        $departmentid = !empty($get['departmentid']) ? $get['departmentid'] : $this->input->post('mattypeid');
        $subdepid = !empty($get['subdepid']) ? $get['subdepid'] : $this->input->post('subdepid');
        $subdeparray = array();

        if ($departmentid) {

            $check_parentid = $this->general->get_tbl_data('dept_depid,dept_parentdepid', 'dept_department', array('dept_depid' => $departmentid), 'dept_depname', 'ASC');
        }

        if (!empty($check_parentid)) {

            $parentdepid = !empty($check_parentid[0]->dept_parentdepid) ? $check_parentid[0]->dept_parentdepid : '0';

            if ($parentdepid == '0') {

                $subdep_result = $this->general->get_tbl_data('dept_depid', 'dept_department', array('dept_parentdepid' => $departmentid), 'dept_depname', 'ASC');

                if (!empty($subdep_result)) {

                    foreach ($subdep_result as $ksd => $dep) {

                        $subdeparray[] = $dep->dept_depid;
                    }
                }
            }
        }

        foreach ($get as $key => $value) {

            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }

        if ($cond) {

            $this->db->where($cond);
        }

        $input_locationid = !empty($get['locationid']) ? $get['locationid'] : $this->input->post('locationid');

        // $locationid = !empty($get['locationid']) ? $get['locationid'] : $this->locationid;

        if (!empty(($frmDate && $toDate))) {

            if (DEFAULT_DATEPICKER == 'NP') {

                $this->db->where('as.assy_syncdatebs >=', $frmDate);

                $this->db->where('as.assy_syncdatebs <=', $toDate);
            } else {

                $this->db->where('as.assy_syncdatead >=', $frmDate);

                $this->db->where('as.assy_syncdatead <=', $toDate);
            }
        }

        if ($input_locationid) {
            $this->db->where('as.assy_locationid', $input_locationid);
        }

        if (!empty($category_id)) {

            $this->db->where('as.assy_assettype', $category_id);
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
        if (!empty($supplierid)) {
            $this->db->where('d.dist_distributorid',$supplierid);
        }

        if (!empty($get['sSearch_1'])) {

            $this->db->where("assy_syncdatead like  '%" . $get['sSearch_1'] . "%'  ");
        }
        if (!empty($get['sSearch_2'])) {

            $this->db->where("assy_syncdatebs like  '%" . $get['sSearch_2'] . "%'  ");
        }
        if (!empty($get['sSearch_3'])) {

            $this->db->where("assy_purchasedatead like  '%" . $get['sSearch_3'] . "%'  ");
        }
        if (!empty($get['sSearch_4'])) {

            $this->db->where("assy_purchasedatebs like  '%" . $get['sSearch_4'] . "%'  ");
        }
        if (!empty($get['sSearch_5'])) {

            $this->db->where("itli_itemcode like  '%" . $get['sSearch_5'] . "%'  ");
        }
        if (!empty($get['sSearch_6'])) {

            $this->db->where("itli_itemname like  '%" . $get['sSearch_6'] . "%'  ");
        }  
        if (!empty($get['sSearch_7'])) {

            $this->db->where("eqca_category like  '%" . $get['sSearch_7'] . "%'  ");
        }
        if (!empty($get['sSearch_8'])) {

            $this->db->where("dist_distributor like  '%" . $get['sSearch_8'] . "%'  ");
        }

        $this->db->select("COUNT(*) as cnt");

        $this->db->from('assy_assetsync as');
        $this->db->join('trde_transactiondetail tr', 'tr.trde_trdeid = as.assy_trdeid', 'LEFT');
        $this->db->join('recd_receiveddetail rd', 'rd.recd_receiveddetailid = tr.trde_mtdid', 'INNER');

        $this->db->join('recm_receivedmaster rm', 'rm.recm_receivedmasterid = rd.recd_receivedmasterid', 'INNER');

        $this->db->join('loca_location lo', 'lo.loca_locationid=rm.recm_school', 'LEFT');

        $this->db->join('dept_department dt', 'dt.dept_depid=rm.recm_departmentid', 'LEFT');

        $this->db->join('dept_department dt2', 'dt2.dept_parentdepid=dt.dept_depid', 'LEFT');

        $this->db->join('itli_itemslist il', 'il.itli_itemlistid = as.assy_itemeid', 'INNER');
        $this->db->join('eqca_equipmentcategory ec', 'ec.eqca_equipmentcategoryid = as.assy_assettype', 'INNER');
        $this->db->join('dist_distributors d', 'd.dist_distributorid = tr.trde_supplierid', 'LEFT');

        $this->db->where('assy_status', 'O');
        $this->db->group_by('trde_trdeid');

        $resltrpt = $this->db->get()->row();
        $totalfilteredrecs = ($resltrpt->cnt ?? 0);

        $order_by = 'assy_syncdatead';

        $order = 'desc';

        if ($this->input->get('sSortDir_0')) {

            $order = $this->input->get('sSortDir_0');
        }

        if ($this->input->get('iSortCol_0') == 1)

            $order_by = 'assy_syncdatead';

        if ($this->input->get('iSortCol_0') == 2)

            $order_by = 'assy_syncdatebs';

        if ($this->input->get('iSortCol_0') == 3)

            $order_by = 'assy_purchasedatead';

        if ($this->input->get('iSortCol_0') == 4)

            $order_by = 'assy_purchasedatebs';

        if ($this->input->get('iSortCol_0') == 5)

            $order_by = 'itli_itemcode';

        if ($this->input->get('iSortCol_0') == 6)

            $order_by = 'itli_itemname';
        if ($this->input->get('iSortCol_0') == 7)

            $order_by = 'eqca_category';
        if ($this->input->get('iSortCol_0') == 8)

            $order_by = 'dist_distributor';

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

        if (!empty(($frmDate && $toDate))) {

            if (DEFAULT_DATEPICKER == 'NP') {

                $this->db->where('as.assy_syncdatebs >=', $frmDate);

                $this->db->where('as.assy_syncdatebs <=', $toDate);
            } else {

                $this->db->where('as.assy_syncdatead >=', $frmDate);

                $this->db->where('as.assy_syncdatead <=', $toDate);
            }
        }

        if ($input_locationid) {
            $this->db->where('as.assy_locationid', $input_locationid);
        }

        if (!empty($category_id)) {

            $this->db->where('as.assy_assettype', $category_id);
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
        if (!empty($supplierid)) {
            $this->db->where('d.dist_distributorid',$supplierid);
        }

         if (!empty($get['sSearch_1'])) {

            $this->db->where("assy_syncdatead like  '%" . $get['sSearch_1'] . "%'  ");
        }
        if (!empty($get['sSearch_2'])) {

            $this->db->where("assy_syncdatebs like  '%" . $get['sSearch_2'] . "%'  ");
        }
        if (!empty($get['sSearch_3'])) {

            $this->db->where("assy_purchasedatead like  '%" . $get['sSearch_3'] . "%'  ");
        }
        if (!empty($get['sSearch_4'])) {

            $this->db->where("assy_purchasedatebs like  '%" . $get['sSearch_4'] . "%'  ");
        }
        if (!empty($get['sSearch_5'])) {

            $this->db->where("itli_itemcode like  '%" . $get['sSearch_5'] . "%'  ");
        }
        if (!empty($get['sSearch_6'])) {

            $this->db->where("itli_itemname like  '%" . $get['sSearch_6'] . "%'  ");
        }  
        if (!empty($get['sSearch_7'])) {

            $this->db->where("eqca_category like  '%" . $get['sSearch_7'] . "%'  ");
        }
        if (!empty($get['sSearch_8'])) {

            $this->db->where("dist_distributor like  '%" . $get['sSearch_8'] . "%'  ");
        }

        $this->db->select('as.assy_assyid, as.assy_trmaid,as.assy_trdeid,as.assy_salemasterid,as.assy_saledetailid,as.assy_servicedatead,as.assy_servicedatebs,il.itli_itemcode,il.itli_itemname,il.itli_itemnamenp,ec.eqca_category,as.assy_syncdatead,as.assy_syncdatebs,as.assy_purchasedatead,as.assy_purchasedatebs,as.assy_qty,as.assy_price,d.dist_distributor,rm.recm_receivedby,lo.loca_name as schoolname,dt.dept_depname, dt2.dept_depname depparentname');

        $this->db->from('assy_assetsync as');
        $this->db->join('trde_transactiondetail tr', 'tr.trde_trdeid = as.assy_trdeid', 'LEFT');
        $this->db->join('recd_receiveddetail rd', 'rd.recd_receiveddetailid = tr.trde_mtdid', 'INNER');

        $this->db->join('recm_receivedmaster rm', 'rm.recm_receivedmasterid = rd.recd_receivedmasterid', 'INNER');

        $this->db->join('loca_location lo', 'lo.loca_locationid=rm.recm_school', 'LEFT');

        $this->db->join('dept_department dt', 'dt.dept_depid=rm.recm_departmentid', 'LEFT');

        $this->db->join('dept_department dt2', 'dt2.dept_parentdepid=dt.dept_depid', 'LEFT');

        $this->db->join('itli_itemslist il', 'il.itli_itemlistid = as.assy_itemeid', 'INNER');

        $this->db->join('eqca_equipmentcategory ec', 'ec.eqca_equipmentcategoryid = as.assy_assettype', 'INNER');
        $this->db->join('dist_distributors d', 'd.dist_distributorid = tr.trde_supplierid', 'LEFT');

        $this->db->where('assy_status', 'O');
        $this->db->group_by('trde_trdeid');
        $this->db->order_by($order_by, $order);

        if ($limit && $limit > 0) {

            $this->db->limit($limit);
        }

        if ($offset) {

            $this->db->offset($offset);
        }

        $nquery = $this->db->get();
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

    public function get_itemslist_from_inventory_ku($cond = false)

    {

        // $locationid=$this->input->get('locationid');

        $get = $_GET;

        $frmDate = $this->input->get('frmDate');

        $toDate = $this->input->get('toDate');

        // $category_id=!empty($this->input->get('categoryid'))?$this->input->get('categoryid'):'';

        $category_id = $this->input->get('categoryid');

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

        foreach ($get as $key => $value) {

            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }

        if (!empty($get['sSearch_1'])) {

            $this->db->where("recm_receiveddatead like  '%" . $get['sSearch_1'] . "%'  ");
        }

        if (!empty($get['sSearch_2'])) {

            $this->db->where("recm_receiveddatebs like  '%" . $get['sSearch_2'] . "%'  ");
        }

        if (!empty($get['sSearch_3'])) {

            $this->db->where("recm_invoiceno like  '%" . $get['sSearch_3'] . "%'  ");
        }

        if (!empty($get['sSearch_4'])) {

            $this->db->where("itli_itemcode like  '%" . $get['sSearch_4'] . "%'  ");
        }

        if (!empty($get['sSearch_5'])) {

            $this->db->where("itli_itemname like  '%" . $get['sSearch_5'] . "%'  ");
        }

        if (!empty($get['sSearch_6'])) {

            $this->db->where("itli_itemnamenp like  '%" . $get['sSearch_6'] . "%'  ");
        }

        if (!empty($get['sSearch_7'])) {

            $this->db->where("eqca_category like  '%" . $get['sSearch_7'] . "%'  ");
        }

        if (!empty($get['sSearch_8'])) {

            $this->db->where("dist_distributor like  '%" . $get['sSearch_8'] . "%'  ");
        }

        if ($cond) {

            $this->db->where($cond);
        }

        $input_locationid = !empty($get['locationid']) ? $get['locationid'] : $this->input->post('locationid');

        if (!empty(($frmDate && $toDate))) {

            if (DEFAULT_DATEPICKER == 'NP') {

                $this->db->where('rm.recm_receiveddatebs >=', $frmDate);

                $this->db->where('rm.recm_receiveddatebs <=', $toDate);
            } else {

                $this->db->where('rm.recm_receiveddatead >=', $frmDate);

                $this->db->where('rm.recm_receiveddatead <=', $toDate);
            }
        }

        if ($input_locationid) {

            $this->db->where('tm.trma_locationid', $this->locationid);
        }

        if (!empty($category_id)) {

            $this->db->where('itli_catid', $category_id);
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

        $where = "(trma_transactiontype = 'OPENING' or trma_transactiontype = 'PURCHASE' or trma_transactiontype = 'D.RECEIVE')";

        $resltrpt = $this->db->select("COUNT(*) as cnt")

            //->from('sama_salemaster rn')

            ->from('trma_transactionmain tm')

            ->join('trde_transactiondetail td', 'td.trde_trmaid = tm.trma_trmaid', 'LEFT')

            ->join('recd_receiveddetail rd', 'rd.recd_receiveddetailid = td.trde_mtdid AND td.trde_itemsid=rd.recd_itemsid', 'LEFT')

            ->join('recm_receivedmaster rm', 'rm.recm_receivedmasterid = rd.recd_receivedmasterid', 'LEFT')

            ->join('itli_itemslist il', 'il.itli_itemlistid = td.trde_itemsid', 'LEFT')

            ->join('dist_distributors d', 'd.dist_distributorid = rm.recm_supplierid', 'LEFT')

            ->join('eqca_equipmentcategory ec', 'ec.eqca_equipmentcategoryid = il.itli_catid', 'LEFT')

            ->where('trde_isassetsync ', 'N')
             ->where('recm_status <>', 'M')

            ->where('recm_mattypeid', 2)

            ->where($where)
            ->group_by('trde_trdeid')
            ->get()

            ->row();

        // echo $this->db->last_query();die(); 

        $totalfilteredrecs = !empty($resltrpt->cnt)?$resltrpt->cnt:'0';

        $order_by = 'recm_receivedno';

        $order = 'desc';

        if ($this->input->get('sSortDir_0')) {

            $order = $this->input->get('sSortDir_0');
        }

        $where = '';

        if ($this->input->get('iSortCol_0') == 1)

            $order_by = 'recm_receiveddatead';

        else if ($this->input->get('iSortCol_0') == 2)

            $order_by = 'recm_receiveddatebs';

        else if ($this->input->get('iSortCol_0') == 3)

            $order_by = 'recm_invoiceno';

        else if ($this->input->get('iSortCol_0') == 4)

            $order_by = 'itli_itemcode';

        else if ($this->input->get('iSortCol_0') == 5)

            $order_by = 'itli_itemname';

        else if ($this->input->get('iSortCol_0') == 6)

            $order_by = 'itli_itemnamenp';

        else if ($this->input->get('iSortCol_0') == 7)

            $order_by = 'eqca_category';

        else if ($this->input->get('iSortCol_0') == 8)

            $order_by = 'dist_distributor';

        else if ($this->input->get('iSortCol_0') == 9)

            $order_by = 'trde_requiredqty';

        else if ($this->input->get('iSortCol_0') == 10)

            $order_by = 'trde_selprice';

        else if ($this->input->get('iSortCol_0') == 11)

            $order_by = 'recm_amount';

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

            $this->db->where("recm_receiveddatead like  '%" . $get['sSearch_1'] . "%'  ");
        }

        if (!empty($get['sSearch_2'])) {

            $this->db->where("recm_receiveddatebs like  '%" . $get['sSearch_2'] . "%'  ");
        }

        if (!empty($get['sSearch_3'])) {

            $this->db->where("recm_invoiceno like  '%" . $get['sSearch_3'] . "%'  ");
        }

        if (!empty($get['sSearch_4'])) {

            $this->db->where("itli_itemcode like  '%" . $get['sSearch_4'] . "%'  ");
        }

        if (!empty($get['sSearch_5'])) {

            $this->db->where("itli_itemname like  '%" . $get['sSearch_5'] . "%'  ");
        }

        if (!empty($get['sSearch_6'])) {

            $this->db->where("itli_itemnamenp like  '%" . $get['sSearch_6'] . "%'  ");
        }

        if (!empty($get['sSearch_7'])) {

            $this->db->where("eqca_category like  '%" . $get['sSearch_7'] . "%'  ");
        }

        if (!empty($get['sSearch_8'])) {

            $this->db->where("dist_distributor like  '%" . $get['sSearch_8'] . "%'  ");
        }

        if (!empty(($frmDate && $toDate))) {

            if (DEFAULT_DATEPICKER == 'NP') {

                $this->db->where('rm.recm_receiveddatebs >=', $frmDate);

                $this->db->where('rm.recm_receiveddatebs <=', $toDate);
            } else {

                $this->db->where('rm.recm_receiveddatead >=', $frmDate);

                $this->db->where('rm.recm_receiveddatead <=', $toDate);
            }
        }

        if ($cond) {

            $this->db->where($cond);
        }

        if ($input_locationid) {

            $this->db->where('tm.trma_locationid', $this->locationid);
        }

        if (!empty($category_id)) {

            $this->db->where('itli_catid', $category_id);
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

        $this->db->select('tm.trma_trmaid, itli_itemlistid, itli_itemcode, itli_itemname, itli_itemnamenp, td.trde_trdeid, rd.recd_purchasedqty  trde_requiredqty, td.trde_stripqty, tm.trma_transactiontype, td.trde_itemsid, td.trde_mtdid, recm_receivedmasterid, td.trde_unitprice, td.trde_selprice, itli_purchaserate, itli_salesrate, td.trde_supplierid, td.trde_description, itli_materialtypeid, itli_catid, itli_unitid, itli_typeid, tm.trma_transactiondatead, tm.trma_transactiondatebs, rm.recm_receiveddatead, rm.recm_receiveddatebs, rm.recm_invoiceno as recm_receivedno, rm.recm_amount, rm.recm_receivedby ,tm.trma_fyear, d.dist_distributor, ec.eqca_category,lo.loca_name as schoolname,dt.dept_depname, dt2.dept_depname depparentname');

        $this->db->from('trma_transactionmain tm');

        $this->db->join('trde_transactiondetail td', 'td.trde_trmaid = tm.trma_trmaid', 'LEFT');

        $this->db->join('recd_receiveddetail rd', 'rd.recd_receiveddetailid =  td.trde_mtdid AND  td.trde_itemsid=rd.recd_itemsid', 'LEFT');

        $this->db->join('recm_receivedmaster rm', 'rm.recm_receivedmasterid = rd.recd_receivedmasterid', 'LEFT');

        $this->db->join('itli_itemslist il', 'il.itli_itemlistid = td.trde_itemsid', 'LEFT');

        $this->db->join('dist_distributors d', 'd.dist_distributorid = rm.recm_supplierid', 'LEFT');

        $this->db->join('eqca_equipmentcategory ec', 'ec.eqca_equipmentcategoryid = il.itli_catid', 'LEFT');

        $this->db->join('loca_location lo', 'lo.loca_locationid=rm.recm_school', 'LEFT');

        $this->db->join('dept_department dt', 'dt.dept_depid=rm.recm_departmentid', 'LEFT');

        $this->db->join('dept_department dt2', 'dt2.dept_parentdepid=dt.dept_depid', 'LEFT');

        $this->db->where('recm_mattypeid', 2);
          $this->db->where('recm_status <>', 'M');

        $this->db->where('trde_isassetsync ', 'N');

        $where = "(trma_transactiontype = 'OPENING' or trma_transactiontype = 'PURCHASE' or trma_transactiontype = 'D.RECEIVE')";

        $this->db->where($where);
        $this->db->group_by('trde_trdeid');

        $this->db->order_by($order_by, $order);

        if ($limit && $limit > 0) {

            $this->db->limit($limit);
        }

        if ($offset) {

            $this->db->offset($offset);
        }

        $nquery = $this->db->get();

         // echo $this->db->last_query();die();

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

    public function get_itemslist_from_inventory_kukl($cond = false)

    {

        $frmDate = $this->input->get('frmDate');

        $toDate = $this->input->get('toDate');

        $category_id = $this->input->get('categoryid');

        $get = $_GET;

        foreach ($get as $key => $value) {

            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }

        if (!empty($get['sSearch_1'])) {

            $this->db->where("recm_receiveddatead like  '%" . $get['sSearch_1'] . "%'  ");
        }

        if (!empty($get['sSearch_2'])) {

            $this->db->where("recm_receiveddatebs like  '%" . $get['sSearch_2'] . "%'  ");
        }

        if (!empty($get['sSearch_3'])) {

            $this->db->where("sama_billdatead like  '%" . $get['sSearch_3'] . "%'  ");
        }

        if (!empty($get['sSearch_4'])) {

            $this->db->where("sama_billdatebs like  '%" . $get['sSearch_4'] . "%'  ");
        }

        if (!empty($get['sSearch_5'])) {

            $this->db->where("sama_invoiceno like  '%" . $get['sSearch_5'] . "%'  ");
        }

        if (!empty($get['sSearch_6'])) {

            $this->db->where("itli_itemcode like  '%" . $get['sSearch_6'] . "%'  ");
        }

        if (!empty($get['sSearch_7'])) {

            $this->db->where("itli_itemname like  '%" . $get['sSearch_7'] . "%'  ");
        }

        if (!empty($get['sSearch_8'])) {

            $this->db->where("eqca_category like  '%" . $get['sSearch_8'] . "%'  ");
        }

        if (!empty($get['sSearch_9'])) {

            $this->db->where("dist_distributor like  '%" . $get['sSearch_9'] . "%'  ");
        }

        if ($cond) {

            $this->db->where($cond);
        }

        $input_locationid = !empty($get['locationid']) ? $get['locationid'] : $this->locationid;

        if (!empty(($frmDate && $toDate))) {

            if (DEFAULT_DATEPICKER == 'NP') {

                $this->db->where('sm.sama_billdatebs >=', $frmDate);

                $this->db->where('sm.sama_billdatebs <=', $toDate);
            } else {

                $this->db->where('sm.sama_billdatead >=', $frmDate);

                $this->db->where('sm.sama_billdatead <=', $toDate);
            }
        }

        if ($input_locationid) {

            $this->db->where('tm.trma_locationid', $input_locationid);
        }

        if (!empty($category_id)) {

            $this->db->where('itli_catid', $category_id);
        }

        $where = "(trma_transactiontype = 'OPENING' or trma_transactiontype = 'PURCHASE' or trma_transactiontype = 'D.RECEIVE')";

        $resltrpt = $this->db->select("COUNT(*) as cnt");

        //->from('sama_salemaster rn')

        $this->db->from('trma_transactionmain tm');

        $this->db->join('trde_transactiondetail td', 'td.trde_trmaid = tm.trma_trmaid', 'INNER');

        $this->db->join('recd_receiveddetail rd', 'rd.recd_receiveddetailid = td.trde_mtdid', 'INNER');

        $this->db->join('recm_receivedmaster rm', 'rm.recm_receivedmasterid = rd.recd_receivedmasterid', 'INNER');

        $this->db->join('itli_itemslist il', 'il.itli_itemlistid = td.trde_itemsid', 'INNER');

        $this->db->join('dist_distributors d', 'd.dist_distributorid = rm.recm_supplierid', 'INNER');

        $this->db->join('eqca_equipmentcategory ec', 'ec.eqca_equipmentcategoryid = il.itli_catid', 'INNER');

        $this->db->join('sade_saledetail sd', 'sd.sade_mattransdetailid=td.trde_trdeid', 'INNER');

        $this->db->join('sama_salemaster sm', 'sm.sama_salemasterid=sd.sade_salemasterid', 'INNER');

        $this->db->where('itli_materialtypeid', '2');

        $this->db->where('sd.sade_isassetsync', 'N');

        $this->db->where('sd.sade_curqty !=', '0');

        $this->db->where($where);

        $resltrpt = $this->db->get()->row();

        // echo $this->db->last_query();die(); 

        $totalfilteredrecs = ($resltrpt->cnt);

        $order_by = 'recm_receivedno';

        $order = 'desc';

        if ($this->input->get('sSortDir_0')) {

            $order = $this->input->get('sSortDir_0');
        }

        $where = '';

        if ($this->input->get('iSortCol_0') == 1)

            $order_by = 'recm_receiveddatead';

        else if ($this->input->get('iSortCol_0') == 2)

            $order_by = 'recm_receiveddatebs';

        else if ($this->input->get('iSortCol_0') == 3)

            $order_by = 'sama_billdatead';

        else if ($this->input->get('iSortCol_0') == 4)

            $order_by = 'sama_billdatebs';

        else if ($this->input->get('iSortCol_0') == 5)

            $order_by = 'sama_invoiceno';

        else if ($this->input->get('iSortCol_0') == 6)

            $order_by = 'itli_itemcode';

        else if ($this->input->get('iSortCol_0') == 7)

            $order_by = 'itli_itemname';

        else if ($this->input->get('iSortCol_0') == 8)

            $order_by = 'eqca_category';

        else if ($this->input->get('iSortCol_0') == 9)

            $order_by = 'dist_distributor';

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

            $this->db->where("recm_receiveddatead like  '%" . $get['sSearch_1'] . "%'  ");
        }

        if (!empty($get['sSearch_2'])) {

            $this->db->where("recm_receiveddatebs like  '%" . $get['sSearch_2'] . "%'  ");
        }

        if (!empty($get['sSearch_3'])) {

            $this->db->where("sama_billdatead like  '%" . $get['sSearch_3'] . "%'  ");
        }

        if (!empty($get['sSearch_4'])) {

            $this->db->where("sama_billdatebs like  '%" . $get['sSearch_4'] . "%'  ");
        }

        if (!empty($get['sSearch_5'])) {

            $this->db->where("sama_invoiceno like  '%" . $get['sSearch_5'] . "%'  ");
        }

        if (!empty($get['sSearch_6'])) {

            $this->db->where("itli_itemcode like  '%" . $get['sSearch_6'] . "%'  ");
        }

        if (!empty($get['sSearch_7'])) {

            $this->db->where("itli_itemname like  '%" . $get['sSearch_7'] . "%'  ");
        }

        if (!empty($get['sSearch_8'])) {

            $this->db->where("eqca_category like  '%" . $get['sSearch_8'] . "%'  ");
        }

        if (!empty($get['sSearch_9'])) {

            $this->db->where("dist_distributor like  '%" . $get['sSearch_9'] . "%'  ");
        }

        if (!empty(($frmDate && $toDate))) {

            if (DEFAULT_DATEPICKER == 'NP') {

                $this->db->where('sm.sama_billdatebs >=', $frmDate);

                $this->db->where('sm.sama_billdatebs <=', $toDate);
            } else {

                $this->db->where('sm.sama_billdatead >=', $frmDate);

                $this->db->where('sm.sama_billdatead <=', $toDate);
            }
        }

        if ($cond) {

            $this->db->where($cond);
        }

        if ($input_locationid) {

            $this->db->where('tm.trma_locationid', $input_locationid);
        }

        if (!empty($category_id)) {

            $this->db->where('itli_catid', $category_id);
        }

        $this->db->select(' tm.trma_trmaid,sm.sama_invoiceno, sm.sama_salemasterid, sd.sade_saledetailid,sm.sama_billdatead,sm.sama_billdatebs, sd.sade_unitrate,itli_itemlistid, itli_itemcode, itli_itemname, itli_itemnamenp, td.trde_trdeid, sade_curqty trde_requiredqty, td.trde_stripqty, tm.trma_transactiontype, td.trde_itemsid, td.trde_mtdid, recm_receivedmasterid, sade_unitrate trde_unitprice, td.trde_selprice, itli_purchaserate, itli_salesrate, td.trde_supplierid, td.trde_description, itli_materialtypeid, itli_catid, itli_unitid, itli_typeid, tm.trma_transactiondatead, tm.trma_transactiondatebs, rm.recm_receiveddatead, rm.recm_receiveddatebs, rm.recm_invoiceno recm_receivedno, rm.recm_amount, tm.trma_fyear, d.dist_distributor, ec.eqca_category');

        $this->db->from('trma_transactionmain tm');

        $this->db->join('trde_transactiondetail td', 'td.trde_trmaid = tm.trma_trmaid', 'INNER');

        $this->db->join('recd_receiveddetail rd', 'rd.recd_receiveddetailid = td.trde_mtdid', 'INNER');

        $this->db->join('recm_receivedmaster rm', 'rm.recm_receivedmasterid = rd.recd_receivedmasterid', 'INNER');

        $this->db->join('itli_itemslist il', 'il.itli_itemlistid = td.trde_itemsid', 'INNER');

        $this->db->join('dist_distributors d', 'd.dist_distributorid = rm.recm_supplierid', 'INNER');

        $this->db->join('eqca_equipmentcategory ec', 'ec.eqca_equipmentcategoryid = il.itli_catid', 'INNER');

        $this->db->join('sade_saledetail sd', 'sd.sade_mattransdetailid=td.trde_trdeid', 'INNER');

        $this->db->join('sama_salemaster sm', 'sm.sama_salemasterid=sd.sade_salemasterid', 'INNER');

        $this->db->where('itli_materialtypeid', 2);

        $this->db->where('sd.sade_isassetsync', 'N');

        $this->db->where('sd.sade_curqty !=', '0');

        $where = "(trma_transactiontype = 'OPENING' or trma_transactiontype = 'PURCHASE' or trma_transactiontype = 'D.RECEIVE')";

        $this->db->where($where);

        $this->db->order_by($order_by, $order);

        if ($limit && $limit > 0) {

            $this->db->limit($limit);
        }

        if ($offset) {

            $this->db->offset($offset);
        }

        $nquery = $this->db->get();

        // echo $this->db->last_query();die();

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

    public function get_item_synch_list($cond = false)

    {

        $frmDate = $this->input->get('frmDate');

        $toDate = $this->input->get('toDate');

        $category_id = $this->input->get('categoryid');

        $input_locationid = !empty($get['locationid']) ? $get['locationid'] : $this->input->post('locationid');

        $get = $_GET;

        foreach ($get as $key => $value) {

            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }

        if (!empty($get['sSearch_1'])) {

            $this->db->where("assy_syncdatead like  '%" . $get['sSearch_1'] . "%'  ");
        }

        if (!empty($get['sSearch_2'])) {

            $this->db->where("assy_syncdatebs like  '%" . $get['sSearch_2'] . "%'  ");
        }

        if (!empty($get['sSearch_3'])) {

            $this->db->where("assy_servicedatead like  '%" . $get['sSearch_3'] . "%'  ");
        }

        if (!empty($get['sSearch_4'])) {

            $this->db->where("assy_servicedatebs like  '%" . $get['sSearch_4'] . "%'  ");
        }

        if (!empty($get['sSearch_5'])) {

            $this->db->where("itli_itemcode like  '%" . $get['sSearch_5'] . "%'  ");
        }

        if (!empty($get['sSearch_6'])) {

            $this->db->where("itli_itemname like  '%" . $get['sSearch_6'] . "%'  ");
        }

        if (!empty($get['sSearch_7'])) {

            $this->db->where("eqca_category like  '%" . $get['sSearch_7'] . "%'  ");
        }

        if (!empty(($frmDate && $toDate))) {

            if (DEFAULT_DATEPICKER == 'NP') {

                $this->db->where('as.assy_servicedatebs >=', $frmDate);

                $this->db->where('as.assy_servicedatebs <=', $toDate);
            } else {

                $this->db->where('as.assy_servicedatead >=', $frmDate);

                $this->db->where('as.assy_servicedatead <=', $toDate);
            }
        }

        if ($cond) {

            $this->db->where($cond);
        }

        if ($input_locationid) {

            $this->db->where('as.assy_locationid', $this->locationid);
        }

        if (!empty($category_id)) {

            $this->db->where('assy_assettype', $category_id);
        }

        $this->db->select("COUNT(*) as cnt");

        $this->db->from('assy_assetsync as');

        $this->db->join('itli_itemslist il', 'il.itli_itemlistid = as.assy_itemeid', 'INNER');

        $this->db->join('eqca_equipmentcategory ec', 'ec.eqca_equipmentcategoryid = as.assy_assettype', 'INNER');

        $this->db->where('assy_status', 'O');

        $resltrpt = $this->db->get()->row();

        // echo $this->db->last_query();die(); 

        $totalfilteredrecs = ($resltrpt->cnt);

        $order_by = 'assy_syncdatead';

        $order = 'desc';

        if ($this->input->get('sSortDir_0')) {

            $order = $this->input->get('sSortDir_0');
        }

        $where = '';

        if ($this->input->get('iSortCol_0') == 1)

            $order_by = 'assy_syncdatead';

        else if ($this->input->get('iSortCol_0') == 2)

            $order_by = 'assy_syncdatebs';

        else if ($this->input->get('iSortCol_0') == 3)

            $order_by = 'assy_servicedatead';

        else if ($this->input->get('iSortCol_0') == 4)

            $order_by = 'assy_servicedatebs';

        else if ($this->input->get('iSortCol_0') == 5)

            $order_by = 'itli_itemcode';

        else if ($this->input->get('iSortCol_0') == 6)

            $order_by = 'itli_itemname';

        else if ($this->input->get('iSortCol_0') == 7)

            $order_by = 'eqca_category';

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

            $this->db->where("assy_syncdatead like  '%" . $get['sSearch_1'] . "%'  ");
        }

        if (!empty($get['sSearch_2'])) {

            $this->db->where("assy_syncdatebs like  '%" . $get['sSearch_2'] . "%'  ");
        }

        if (!empty($get['sSearch_3'])) {

            $this->db->where("assy_servicedatead like  '%" . $get['sSearch_3'] . "%'  ");
        }

        if (!empty($get['sSearch_4'])) {

            $this->db->where("assy_servicedatebs like  '%" . $get['sSearch_4'] . "%'  ");
        }

        if (!empty($get['sSearch_5'])) {

            $this->db->where("itli_itemcode like  '%" . $get['sSearch_5'] . "%'  ");
        }

        if (!empty($get['sSearch_6'])) {

            $this->db->where("itli_itemname like  '%" . $get['sSearch_6'] . "%'  ");
        }

        if (!empty($get['sSearch_7'])) {

            $this->db->where("eqca_category like  '%" . $get['sSearch_7'] . "%'  ");
        }

        if (!empty(($frmDate && $toDate))) {

            if (DEFAULT_DATEPICKER == 'NP') {

                $this->db->where('as.assy_servicedatebs >=', $frmDate);

                $this->db->where('as.assy_servicedatebs <=', $toDate);
            } else {

                $this->db->where('as.assy_servicedatead >=', $frmDate);

                $this->db->where('as.assy_servicedatead <=', $toDate);
            }
        }

        if ($cond) {

            $this->db->where($cond);
        }

        if ($input_locationid) {

            $this->db->where('as.assy_locationid', $this->locationid);
        }

        if (!empty($category_id)) {

            $this->db->where('assy_assettype', $category_id);
        }

        $this->db->select('as.assy_assyid, as.assy_trmaid,as.assy_trdeid,as.assy_salemasterid,as.assy_saledetailid,as.assy_servicedatead,as.assy_servicedatebs,il.itli_itemcode,il.itli_itemname,ec.eqca_category,as.assy_syncdatead,as.assy_syncdatebs,as.assy_qty,as.assy_price');

        $this->db->from('assy_assetsync as');

        $this->db->join('itli_itemslist il', 'il.itli_itemlistid = as.assy_itemeid', 'INNER');

        $this->db->join('eqca_equipmentcategory ec', 'ec.eqca_equipmentcategoryid = as.assy_assettype', 'INNER');

        $this->db->where('assy_status', 'O');

        $this->db->order_by($order_by, $order);

        if ($limit && $limit > 0) {

            $this->db->limit($limit);
        }

        if ($offset) {

            $this->db->offset($offset);
        }

        $nquery = $this->db->get();

        // echo $this->db->last_query();die();

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

    public function get_item_details_for_asset($srchcol = false)
    {

        $this->db->select('itli_itemlistid, itli_itemcode, itli_itemname, itli_itemnamenp, td.trde_trdeid, rd.recd_purchasedqty trde_requiredqty, td.trde_stripqty, tm.trma_transactiontype, td.trde_itemsid, td.trde_mtdid, td.trde_trmaid, recm_receivedmasterid, td.trde_unitprice, td.trde_selprice, itli_purchaserate, itli_salesrate, td.trde_supplierid,td.trde_description, itli_materialtypeid, itli_catid, itli_unitid, itli_typeid, tm.trma_transactiondatead, tm.trma_transactiondatebs, rm.recm_receiveddatead, rm.recm_receiveddatebs, rm.recm_invoiceno recm_receivedno, rm.recm_amount,rm.recm_remarks,rd.recd_description, tm.trma_fyear, d.dist_distributor, ec.eqca_deprate,ec.eqca_category,dp.dept_depcode,dp.dept_depname,dp.dept_assetcode,b.budg_budgetname,recm_departmentid,recm_receivedstaffid,recm_receivedby,rm.recm_budgetid,rm.recm_school,rm.recm_departmentid,td.trde_isassetsync,rm.recm_supplierbillno,rm.recm_locationid');

        $this->db->from('trma_transactionmain tm');

        $this->db->join('trde_transactiondetail td', 'td.trde_trmaid = tm.trma_trmaid', 'LEFT');

        $this->db->join('recd_receiveddetail rd', 'rd.recd_receiveddetailid = td.trde_mtdid', 'LEFT');

        $this->db->join('recm_receivedmaster rm', 'rm.recm_receivedmasterid = rd.recd_receivedmasterid', 'LEFT');

        $this->db->join('budg_budgets b', 'b.budg_budgetid=rm.recm_budgetid',"LEFT");

        $this->db->join('itli_itemslist il', 'il.itli_itemlistid = td.trde_itemsid', 'LEFT');

        $this->db->join('dist_distributors d', 'd.dist_distributorid = rm.recm_supplierid', 'LEFT');

        $this->db->join('eqca_equipmentcategory ec', 'ec.eqca_equipmentcategoryid = il.itli_catid', 'LEFT');

        $this->db->join('dept_department dp', 'dp.dept_depid=rm.recm_departmentid', 'LEFT');

        // $this->db->where('itli_materialtypeid', '2');

        $where = "(trma_transactiontype = 'OPENING' or trma_transactiontype = 'PURCHASE' or trma_transactiontype = 'D.RECEIVE')";

        if ($srchcol) {

            $this->db->where($srchcol);
        }

        $query = $this->db->get();

        // echo $this->db->last_query();die();

        if ($query->num_rows() > 0) {

            $data = $query->result();

            return $data;
        }

        return false;
    }

    public function get_item_details_for_asset_kukl($srchcol = false)
    {

        $this->db->select('tm.trma_trmaid,sm.sama_billdatead,sm.sama_billdatebs,sm.sama_invoiceno, sm.sama_salemasterid,sm.sama_depid,sm.sama_fyear, sd.sade_saledetailid, itli_itemlistid, itli_itemcode, itli_itemname, itli_itemnamenp, td.trde_trdeid, td.trde_requiredqty, td.trde_stripqty, tm.trma_transactiontype, td.trde_itemsid, td.trde_mtdid, recm_receivedmasterid, td.trde_unitprice, td.trde_selprice, itli_purchaserate, itli_salesrate, td.trde_supplierid,

            sd.sade_curqty,sd.sade_unitrate, td.trde_description, itli_materialtypeid, itli_catid, itli_unitid, itli_typeid, tm.trma_transactiondatead, tm.trma_transactiondatebs, rm.recm_receiveddatead, rm.recm_receiveddatebs, rm.recm_invoiceno recm_receivedno, rm.recm_amount, tm.trma_fyear, d.dist_distributor, ec.eqca_deprate,ec.eqca_category,dp.dept_depcode,dp.dept_depname');

        $this->db->from('trma_transactionmain tm');

        $this->db->join('trde_transactiondetail td', 'td.trde_trmaid = tm.trma_trmaid', 'LEFT');

        $this->db->join('recd_receiveddetail rd', 'rd.recd_receiveddetailid = td.trde_mtdid', 'LEFT');

        $this->db->join('recm_receivedmaster rm', 'rm.recm_receivedmasterid = rd.recd_receivedmasterid', 'LEFT');

        $this->db->join('itli_itemslist il', 'il.itli_itemlistid = td.trde_itemsid', 'LEFT');

        $this->db->join('dist_distributors d', 'd.dist_distributorid = rm.recm_supplierid', 'LEFT');

        $this->db->join('eqca_equipmentcategory ec', 'ec.eqca_equipmentcategoryid = il.itli_catid', 'LEFT');

        $this->db->join('sade_saledetail sd', 'sd.sade_mattransdetailid=td.trde_trdeid', 'LEFT');

        $this->db->join('sama_salemaster sm', 'sm.sama_salemasterid=sd.sade_salemasterid', 'LEFT');

        $this->db->join('dept_department dp', 'dp.dept_depid=sm.sama_depid', 'LEFT');

        $this->db->where('itli_materialtypeid', '2');

        $this->db->where('sd.sade_isassetsync', 'N');

        $where = "(trma_transactiontype = 'OPENING' or trma_transactiontype = 'PURCHASE' or trma_transactiontype = 'D.RECEIVE')";

        if ($srchcol) {

            $this->db->where($srchcol);
        }

        $query = $this->db->get();

        // echo $this->db->last_query();die();

        if ($query->num_rows() > 0) {

            $data = $query->result();

            return $data;
        }

        return false;
    }

    public function save_asset_sync()
    {

        // echo "<pre>";

        // print_r($this->input->post());

        // die();

        $id = $this->input->post('id');

        //common values

        $purchase_rate = $this->input->post('asen_purchaserate');

        $purchase_date = $this->input->post('asen_purchasedate');

        $warr_date = $this->input->post('asen_warrentydate');

        $asen_inservicedate = $this->input->post('asen_inservicedate');

        if (DEFAULT_DATEPICKER == 'NP') {

            $purchase_date_bs = $purchase_date;

            $purchase_date_ad = $this->general->NepToEngDateConv($purchase_date);
        } else {

            $purchase_date_ad = $purchase_date;

            $purchase_date_bs = $this->general->EngtoNepDateConv($purchase_date);
        }

        if (DEFAULT_DATEPICKER == 'NP') {

            $service_date_bs = $asen_inservicedate;

            $service_date_ad = $this->general->NepToEngDateConv($asen_inservicedate);
        } else {

            $service_date_ad = $asen_inservicedate;

            $service_date_bs = $this->general->EngtoNepDateConv($asen_inservicedate);
        }

        $itemid = $this->input->post('asen_description');

        $item_desc = $this->input->post('asen_desc');

        $catid = $this->input->post('asen_assettype');

        $supplierid = $this->input->post('asen_distributor');

        $trmaid = $this->input->post('trmaid');

        $trdeid = $this->input->post('trdeid');

        $asen_supplierbillno = $this->input->post('asen_supplierbillno');

        $dep_per = $this->input->post('asen_deppercentage');

        $dep_method = $this->input->post('asen_depreciation');

        //assets

        $assetcode = $this->input->post('asen_assetcode');

        $manufacture = $this->input->post('asen_manufacture');

        $brand = $this->input->post('asen_brand');

        $modelno = $this->input->post('asen_modelno');

        $serialno = $this->input->post('asen_serialno');

        $asen_remarks = $this->input->post('asen_remarks');
        $budgetid=$this->input->post('asen_budgetid');

        $asen_staffid = $this->input->post('asen_staffid');


        $scrapvalue = $this->input->post('asen_scrapvalue');

        $expectedlife = $this->input->post('asen_expectedlife');
        
        $schoolid=$this->input->post('schoolid');

        $depid = $this->input->post('asen_depid');
        $asen_schoolid = $this->input->post('asen_schoolid') ?? [];


        $this->db->trans_begin();

        if ($id) {

        } else {

            $assetSyncArray = array(

                'assy_trmaid' => $trmaid,

                'assy_trdeid' => $trdeid,

                'assy_syncdatead' => CURDATE_EN,

                'assy_syncdatebs' => CURDATE_NP,

                'assy_synctime' => $this->curtime,

                'assy_fyear' => CUR_FISCALYEAR,

                'assy_purchasedatead' => $purchase_date_ad,

                'assy_purchasedatebs' => $purchase_date_bs,

                'assy_price' => $purchase_rate,

                'assy_itemeid' => $itemid,

                'assy_assettype' => $catid,

                'assy_postby' => $this->userid,

                'assy_postdatead' => CURDATE_EN,

                'assy_postdatebs' => CURDATE_NP,

                'assy_posttime' => $this->curtime,

                'assy_postmac' => $this->mac,

                'assy_postip' => $this->ip,

                'assy_locationid' => $this->locationid,

                'assy_orgid' => $this->orgid,

                'assy_supplierid' => $supplierid,

                'assy_qty' => count($assetcode),

            );

            if (!empty($assetSyncArray)) {
                if(ORGANIZATION_NAME=='ARMY'){
                    //unset($assetSyncArray['assy_locationid']);
                    //$assetSyncArray['assy_locationid']=$schoolid;
                }

                $this->db->insert('assy_assetsync', $assetSyncArray);

                $insertid = $this->db->insert_id();

                if ($insertid) {

                    // $assetArray = array();

                    foreach ($assetcode as $key => $val) :

                        if (DEFAULT_DATEPICKER == 'NP') {

                            $wardatebs = !empty($warr_date[$key]) ? $warr_date[$key] : '';

                            $wardatead = $this->general->NepToEngDateConv($wardatebs);
                        } else {

                            $wardatead = !empty($warr_date[$key]) ? $warr_date[$key] : '';

                            $wardatebs = $this->general->EngtoNepDateConv($wardatead);
                        }

                        $assetArray = array(

                            'asen_syncid' => $insertid,

                            'asen_masterid' => $trdeid,

                            'asen_assettypeid' => '1',

                            'asen_assetcode' => !empty($assetcode[$key]) ? $assetcode[$key] : '',

                            'asen_manufacture' => !empty($manufacture[$key]) ? $manufacture[$key] : '',

                            'asen_brand' => !empty($brand[$key]) ? $brand[$key] : '',

                            'asen_modelno' => !empty($modelno[$key]) ? $modelno[$key] : '',

                            'asen_serialno' => !empty($serialno[$key]) ? $serialno[$key] : '',

                            'asen_remarks' => !empty($asen_remarks[$key]) ? $asen_remarks[$key] : '',
                            'asen_schoolid'=>!empty($schoolid)?$schoolid:0,

                            'asen_depid' => !empty($depid[$key]) ? $depid[$key] : '',
                            'asen_budgetid' => !empty($budgetid[$key]) ? $budgetid[$key] : '',

                            'asen_supplierbillno' => !empty($asen_supplierbillno) ? $asen_supplierbillno : '',

                            'asen_scrapvalue' => !empty($scrapvalue[$key]) ? $scrapvalue[$key] : '',

                            'asen_expectedlife' => !empty($expectedlife[$key]) ? $expectedlife[$key] : '',

                            'asen_staffid' => !empty($asen_staffid) ? $asen_staffid : '',

                            'asen_warrentydatebs' => $wardatebs,

                            'asen_warrentydatead' => $wardatead,

                            'asen_purchaserate' => $purchase_rate,

                            'asen_purchasedatead' => $purchase_date,

                            'asen_purchasedatebs' => $purchase_date,

                            'asen_inservicedatead' => $service_date_ad,

                            'asen_inservicedatebs' => $service_date_bs,

                            'asen_description' => $itemid,

                            'asen_desc' => $item_desc,

                            'asen_assettype' => $catid,

                            'asen_distributor' => $supplierid,

                            'asen_depreciation' => $dep_method,

                            'asen_deppercentage' => $dep_per,

                            'asen_postdatead' => CURDATE_EN,

                            'asen_postdatebs' => CURDATE_NP,

                            'asen_posttime' => $this->curtime,

                            'asen_postmac' => $this->mac,

                            'asen_postip' => $this->ip,

                            'asen_postby' => $this->userid,

                            'asen_locationid' => $this->locationid,

                            'asen_orgid' => $this->orgid

                        );

                        if (!empty($assetArray)) {
                            if(ORGANIZATION_NAME=='ARMY'){
                                unset($assetArray['asen_locationid']);
                                $assetArray['asen_schoolid']=$asen_schoolid[$key] ?? 0;    
                                $assetArray['asen_locationid']=$asen_schoolid[$key] ?? 0;    
                            }
                            
                            $this->db->insert('asen_assetentry', $assetArray);
                        }

                    endforeach;

                    //update transaction table

                    $trma_array = array(

                        'trma_isassetsync' => 'Y'

                    );

                    $this->db->where('trma_trmaid', $trmaid);

                    $this->db->update('trma_transactionmain', $trma_array);

                    $trde_array = array(

                        'trde_isassetsync' => 'Y'

                    );

                    $this->db->where('trde_trdeid', $trdeid);

                    $this->db->update('trde_transactiondetail', $trde_array);
                }
            }
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {

            $this->db->trans_rollback();

            return false;
        } else {

            $this->db->trans_commit();

            if ($id) {

                return $id;
            } else {

                return $insertid;
            }
        }

        foreach ($asset_code as $key => $value) {
        }
    }

    public function save_asset_sync_kukl()
    {

        //   echo "<pre>";

        // print_r($this->input->post());

        // die();

        $id = $this->input->post('id');

        //common values

        $purchase_rate = $this->input->post('asen_purchaserate');

        $unit_qty = $this->input->post('unit_qty');

        $purchase_date = $this->input->post('asen_purchasedate');

        $warr_date = $this->input->post('asen_warrentydate');

        $asen_inservicedate = $this->input->post('asen_inservicedate');

        if (DEFAULT_DATEPICKER == 'NP') {

            $purchase_date_bs = $purchase_date;

            $purchase_date_ad = $this->general->NepToEngDateConv($purchase_date);
        } else {

            $purchase_date_ad = $purchase_date;

            $purchase_date_bs = $this->general->EngtoNepDateConv($purchase_date);
        }

        if (DEFAULT_DATEPICKER == 'NP') {

            $service_date_bs = $asen_inservicedate;

            $service_date_ad = $this->general->NepToEngDateConv($asen_inservicedate);
        } else {

            $service_date_ad = $asen_inservicedate;

            $service_date_bs = $this->general->EngtoNepDateConv($asen_inservicedate);
        }

        $itemid = $this->input->post('asen_description');

        $asen_desc = $this->input->post('asen_desc');

        $catid = $this->input->post('asen_assettype');

        $supplierid = $this->input->post('asen_distributor');

        $trmaid = $this->input->post('trmaid');

        $trdeid = $this->input->post('trdeid');

        $salemasterid = $this->input->post('salemasterid');

        $saledetailid = $this->input->post('saledetailid');

        $dep_per = $this->input->post('asen_deppercentage');

        $dep_method = $this->input->post('asen_depreciation');

        //assets

        $assetcode = $this->input->post('asen_assetcode');

        $manufacture = $this->input->post('asen_manufacture');

        $brand = $this->input->post('asen_brand');

        $modelno = $this->input->post('asen_modelno');

        $serialno = $this->input->post('asen_serialno');

        $notes = $this->input->post('asen_notes');

        $depid = $this->input->post('asen_depid');

        $scrapvalue = $this->input->post('asen_scrapvalue');

        $expectedlife = $this->input->post('asen_expectedlife');

        $this->db->trans_begin();

        if ($id) {
        } else {

            $assetSyncArray = array(

                'assy_trmaid' => $trmaid,

                'assy_trdeid' => $trdeid,

                'assy_salemasterid' => $salemasterid,

                'assy_saledetailid' => $saledetailid,

                'assy_servicedatead' => $service_date_ad,

                'assy_servicedatebs' => $service_date_bs,

                'assy_itemeid' => $itemid,

                'assy_assettype' => $catid,

                'assy_supplierid' => $supplierid,

                'assy_syncdatead' => CURDATE_EN,

                'assy_syncdatebs' => CURDATE_NP,

                'assy_synctime' => $this->curtime,

                'assy_fyear' => CUR_FISCALYEAR,

                'assy_qty' => $unit_qty,

                'assy_price' => $purchase_rate,

                'assy_postby' => $this->userid,

                'assy_postdatead' => CURDATE_EN,

                'assy_postdatebs' => CURDATE_NP,

                'assy_posttime' => $this->curtime,

                'assy_postmac' => $this->mac,

                'assy_postip' => $this->ip,

                'assy_locationid' => $this->locationid,

                'assy_orgid' => $this->orgid

            );

            if (!empty($assetSyncArray)) {

                $this->db->insert('assy_assetsync', $assetSyncArray);

                $insertid = $this->db->insert_id();

                if ($insertid) {

                    // $assetArray = array();

                    foreach ($assetcode as $key => $val) :

                        if (DEFAULT_DATEPICKER == 'NP') {

                            $wardatebs = !empty($warr_date[$key]) ? $warr_date[$key] : '';

                            $wardatead = $this->general->NepToEngDateConv($wardatebs);
                        } else {

                            $wardatead = !empty($warr_date[$key]) ? $warr_date[$key] : '';

                            $wardatebs = $this->general->EngtoNepDateConv($wardatead);
                        }

                        $assetArray = array(

                            'asen_syncid' => $insertid,

                            'asen_assetcode' => !empty($assetcode[$key]) ? $assetcode[$key] : '',

                            'asen_manufacture' => !empty($manufacture[$key]) ? $manufacture[$key] : '',

                            'asen_brand' => !empty($brand[$key]) ? $brand[$key] : '',

                            'asen_modelno' => !empty($modelno[$key]) ? $modelno[$key] : '',

                            'asen_serialno' => !empty($serialno[$key]) ? $serialno[$key] : '',

                            'asen_notes' => !empty($notes[$key]) ? $notes[$key] : '',

                            'asen_depid' => !empty($depid[$key]) ? $depid[$key] : '',

                            'asen_scrapvalue' => !empty($scrapvalue[$key]) ? $scrapvalue[$key] : '0',

                            'asen_expectedlife' => !empty($expectedlife[$key]) ? $expectedlife[$key] : '0',

                            'asen_warrentydatebs' => $wardatebs,

                            'asen_warrentydatead' => $wardatead,

                            'asen_purchaserate' => $purchase_rate,

                            'asen_purchasedatead' => $purchase_date,

                            'asen_purchasedatebs' => $purchase_date,

                            'asen_inservicedatead' => $service_date_ad,

                            'asen_inservicedatebs' => $service_date_bs,

                            'asen_depreciationstartdatead' => $service_date_ad,

                            'asen_depreciationstartdatebs' => $service_date_bs,

                            'asen_description' => $itemid,

                            'asen_desc' => $asen_desc,

                            'asen_assettype' => $catid,

                            'asen_distributor' => $supplierid,

                            'asen_depreciation' => $dep_method,

                            'asen_deppercentage' => $dep_per,

                            'asen_postdatead' => CURDATE_EN,

                            'asen_postdatebs' => CURDATE_NP,

                            'asen_posttime' => $this->curtime,

                            'asen_postmac' => $this->mac,

                            'asen_postip' => $this->ip,

                            'asen_postby' => $this->userid,

                            'asen_locationid' => $this->locationid,

                            'asen_orgid' => $this->orgid

                        );

                        if (!empty($assetArray)) {

                            $this->db->insert('asen_assetentry', $assetArray);
                        }

                    endforeach;

                    //update transaction table

                    $sade_array = array(

                        'sade_isassetsync' => 'Y'

                    );

                    $this->db->where('sade_saledetailid', $saledetailid);

                    $this->db->update('sade_saledetail', $sade_array);
                }
            }
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {

            $this->db->trans_rollback();

            return false;
        } else {

            $this->db->trans_commit();

            if ($id) {

                return $id;
            } else {

                return $insertid;
            }
        }
    }

    public function save_asset_sync_ku()
    {

        //   echo "<pre>";

        // print_r($this->input->post());

        // die();

        $id = $this->input->post('id');

        //common values

        $purchase_rate = $this->input->post('asen_purchaserate');

        $unit_qty = $this->input->post('unit_qty');

        $purchase_date = $this->input->post('asen_purchasedate');

        $warr_date = $this->input->post('asen_warrentydate');

        $asen_inservicedate = $this->input->post('asen_inservicedate');

        if (DEFAULT_DATEPICKER == 'NP') {

            $purchase_date_bs = $purchase_date;

            $purchase_date_ad = $this->general->NepToEngDateConv($purchase_date);
        } else {

            $purchase_date_ad = $purchase_date;

            $purchase_date_bs = $this->general->EngtoNepDateConv($purchase_date);
        }

        if (DEFAULT_DATEPICKER == 'NP') {

            $service_date_bs = $asen_inservicedate;

            $service_date_ad = $this->general->NepToEngDateConv($asen_inservicedate);
        } else {

            $service_date_ad = $asen_inservicedate;

            $service_date_bs = $this->general->EngtoNepDateConv($asen_inservicedate);
        }

        $itemid = $this->input->post('asen_description');

        $asen_desc = $this->input->post('asen_desc');

        $catid = $this->input->post('asen_assettype');

        $supplierid = $this->input->post('asen_distributor');

        $trmaid = $this->input->post('trmaid');

        $trdeid = $this->input->post('trdeid');

        $asen_staffid = $this->input->post('asen_staffid');

        $asen_staffid = $this->input->post('asen_staffid');

        $dep_per = $this->input->post('asen_deppercentage');

        $dep_method = $this->input->post('asen_depreciation');

        //assets

        $assetcode = $this->input->post('asen_assetcode');

        $manufacture = $this->input->post('asen_manufacture');

        $brand = $this->input->post('asen_brand');

        $modelno = $this->input->post('asen_modelno');

        $serialno = $this->input->post('asen_serialno');

        $asen_remarks = $this->input->post('asen_remarks');

        $asen_supplierbillno = $this->input->post('asen_supplierbillno');

        $depid = $this->input->post('asen_depid');

        $scrapvalue = $this->input->post('asen_scrapvalue');

        $expectedlife = $this->input->post('asen_expectedlife');

        $this->db->trans_begin();

        if ($id) {
        } else {

            $assetSyncArray = array(

                'assy_trmaid' => $trmaid,

                'assy_trdeid' => $trdeid,

                'assy_salemasterid' => $salemasterid,

                'assy_saledetailid' => $saledetailid,

                'assy_servicedatead' => $service_date_ad,

                'assy_servicedatebs' => $service_date_bs,

                'assy_itemeid' => $itemid,

                'assy_assettype' => $catid,

                'assy_supplierid' => $supplierid,

                'assy_syncdatead' => CURDATE_EN,

                'assy_syncdatebs' => CURDATE_NP,

                'assy_synctime' => $this->curtime,

                'assy_fyear' => CUR_FISCALYEAR,

                'assy_qty' => $unit_qty,

                'assy_price' => $purchase_rate,

                'assy_postby' => $this->userid,

                'assy_postdatead' => CURDATE_EN,

                'assy_postdatebs' => CURDATE_NP,

                'assy_posttime' => $this->curtime,

                'assy_postmac' => $this->mac,

                'assy_postip' => $this->ip,

                'assy_locationid' => $this->locationid,

                'assy_orgid' => $this->orgid

            );

            if (!empty($assetSyncArray)) {

                $this->db->insert('assy_assetsync', $assetSyncArray);

                $insertid = $this->db->insert_id();

                if ($insertid) {

                    // $assetArray = array();

                    foreach ($assetcode as $key => $val) :

                        if (DEFAULT_DATEPICKER == 'NP') {

                            $wardatebs = !empty($warr_date[$key]) ? $warr_date[$key] : '';

                            $wardatead = $this->general->NepToEngDateConv($wardatebs);
                        } else {

                            $wardatead = !empty($warr_date[$key]) ? $warr_date[$key] : '';

                            $wardatebs = $this->general->EngtoNepDateConv($wardatead);
                        }

                        $assetArray = array(

                            'asen_syncid' => $insertid,

                            'asen_masterid' => $assy_trdeid,

                            'asen_supplierbillno' => !empty($asen_supplierbillno) ? $asen_supplierbillno : '',

                            'asen_assetcode' => !empty($assetcode[$key]) ? $assetcode[$key] : '',

                            'asen_manufacture' => !empty($manufacture[$key]) ? $manufacture[$key] : '',

                            'asen_staffid' => $asen_staffid,

                            'asen_brand' => !empty($brand[$key]) ? $brand[$key] : '',

                            'asen_modelno' => !empty($modelno[$key]) ? $modelno[$key] : '',

                            'asen_serialno' => !empty($serialno[$key]) ? $serialno[$key] : '',

                            'asen_remarks' => !empty($asen_remarks[$key]) ? $asen_remarks[$key] : '',

                            'asen_depid' => !empty($depid[$key]) ? $depid[$key] : '',

                            'asen_scrapvalue' => !empty($scrapvalue[$key]) ? $scrapvalue[$key] : '0',

                            'asen_expectedlife' => !empty($expectedlife[$key]) ? $expectedlife[$key] : '0',

                            'asen_warrentydatebs' => $wardatebs,

                            'asen_warrentydatead' => $wardatead,

                            'asen_purchaserate' => $purchase_rate,

                            'asen_purchasedatead' => $purchase_date_ad,

                            'asen_purchasedatebs' => $purchase_date_bs,

                            'asen_inservicedatead' => $purchase_date_ad,

                            'asen_inservicedatebs' => $purchase_date_bs,

                            'asen_depreciationstartdatead' => $purchase_date_ad,

                            'asen_depreciationstartdatebs' => $purchase_date_bs,

                            'asen_description' => $itemid,

                            'asen_desc' => $asen_desc,

                            'asen_assettype' => $catid,

                            'asen_distributor' => $supplierid,

                            'asen_depreciation' => $dep_method,

                            'asen_deppercentage' => $dep_per,

                            'asen_postdatead' => CURDATE_EN,

                            'asen_postdatebs' => CURDATE_NP,

                            'asen_posttime' => $this->curtime,

                            'asen_postmac' => $this->mac,

                            'asen_postip' => $this->ip,

                            'asen_postby' => $this->userid,

                            'asen_locationid' => $this->locationid,

                            'asen_orgid' => $this->orgid

                        );

                        if (!empty($assetArray)) {

                            $this->db->insert('asen_assetentry', $assetArray);
                        }

                    endforeach;

                    //update transaction table

                    $trde_array = array(

                        'trde_isassetsync' => 'Y'

                    );

                    $this->db->where('trde_trdeid', $trdeid);

                    $this->db->update('trde_transactiondetail', $trde_array);
                }
            }
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {

            $this->db->trans_rollback();

            return false;
        } else {

            $this->db->trans_commit();

            if ($id) {

                return $id;
            } else {

                return $insertid;
            }
        }
    }

    public function get_synch_item_data($id = false)
    {

        $data = array();

        $this->db->select('as.assy_assyid, as.assy_trmaid,as.assy_trdeid,as.assy_salemasterid,as.assy_saledetailid,as.assy_servicedatead,as.assy_servicedatebs,il.itli_itemcode,il.itli_itemname,ec.eqca_category,as.assy_syncdatead,as.assy_syncdatebs,as.assy_qty,as.assy_price');

        $this->db->from('assy_assetsync as');

        $this->db->join('itli_itemslist il', 'il.itli_itemlistid = as.assy_itemeid', 'INNER');

        $this->db->join('eqca_equipmentcategory ec', 'ec.eqca_equipmentcategoryid = as.assy_assettype', 'INNER');

        $this->db->where(array('as.assy_assyid' => $id));

        $result = $this->db->get()->row();

        // echo $this->db->last_query();

        // echo "<pre>";

        // print_r($result);

        // die();

        if (!empty($result)) {

            $data['synch_master'] = $result;

            $this->db->select('*');

            $this->db->from('asen_assetentry en');

            $this->db->where(array('en.asen_syncid' => $id));

            $rslt_detail = $this->db->get()->result();

            $data['rslt_detail'] = $rslt_detail;

            // return $data;

        }

        // echo "<pre>";

        // print_r($data);

        // die();

        return false;
    }
}