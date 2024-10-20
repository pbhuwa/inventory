<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Non_exp_and_exp_items_mdl extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->curtime = $this->general->get_currenttime();
        $this->userid  = $this->session->userdata(USER_ID);
        $this->mac     = $this->general->get_Mac_Address();
        $this->ip      = $this->general->get_real_ipaddr();
    }

    public $validate_settings_distributors = array(
        array(
            'field' => 'dist_distributor', 'label' => 'Distributor Name', 'rules' => 'trim|required|xss_clean'), 
        array('field' => 'dist_phone1', 'label' => 'Phone 1', 'rules' => 'trim|required|xss_clean'), 
        array('field' => 'dist_email', 'label' => 'Email', 'rules' => 'trim|valid_email|xss_clean'), 
        array('field' => 'dist_repemail', 'label' => 'Sales Resp. Email', 'rules' => 'trim|valid_email|xss_clean'));



    public function get_non_exp_and_exp_items_list($cond = false)
    {
        $get = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }
        

        $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');
        $toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');
        $locationid = !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');


        $materialtypeid = !empty($get['material_type'])?$get['material_type']:$this->input->post('material_type');

        $catid = !empty($get['category_type'])?$get['category_type']:$this->input->post('category_type');

        $typeid = !empty($get['counter'])?$get['counter']:$this->input->post('counter');

        $this->db->select('recm_invoiceno as invoiceno, recm_receiveddatebs as datebs, recm_receiveddatead as datead, recm_fyear as fyear, il.itli_itemcode as itemcode, il.itli_itemname as itemname, il.itli_itemnamenp as itemnamenp, il.itli_typeid as typeid, il.itli_materialtypeid as materialtypeid, il.itli_catid as catid, ec.eqca_category as categoryname, d.dist_distributor as distributorname, rd.recd_purchasedqty as purchasedqty, rd.recd_salerate as salerate, rm.recm_remarks as remarks,lo.loca_name as location');
        $this->db->from('recm_receivedmaster rm');
        $this->db->join('recd_receiveddetail rd','rd.recd_receivedmasterid = rm.recm_receivedmasterid','left');
        $this->db->join('loca_location lo','lo.loca_locationid = rm.recm_locationid','left');
        $this->db->join('itli_itemslist il','il.itli_itemlistid = rd.recd_itemsid','left');
        $this->db->join('eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid = il.itli_catid','left');
        $this->db->join('dist_distributors d','d.dist_distributorid = rm.recm_supplierid','left');
        

        if($frmDate &&  $toDate){
            if(DEFAULT_DATEPICKER=='NP')
            {
              $this->db->where('recm_receiveddatebs >=', $frmDate);
              $this->db->where('recm_receiveddatebs <=', $toDate);
            }
            else
            {
              $this->db->where('recm_receiveddatead >=', $frmDate);
              $this->db->where('recm_receiveddatead <=', $toDate);
            }
        }


        if($locationid){
            $this->db->where('recm_locationid',$locationid);
        }
        $query1 = $this->db->get_compiled_select();

        $this->db->select('"" as invoiceno, chma_challanrecdatebs as datebs, chma_challanrecdatead as datead, "" as fyear, il.itli_itemcode as itemcode, il.itli_itemname as itemname,  il.itli_itemnamenp as itemnamenp, il.itli_typeid as typeid, il.itli_materialtypeid as materialtypeid,il.itli_catid as catid, ec.eqca_category as categoryname, d.dist_distributor as distributorname, cd.chde_qty as purchasedqty, 0 as salerate, "Challan First" as remarks, lo.loca_name as location');
        $this->db->from('chma_challanmaster cm');
        $this->db->join('chde_challandetails cd','cd.chde_challanmasterid = cm.chma_challanmasterid','left');
        $this->db->join('loca_location lo','lo.loca_locationid = cm.chma_locationid','left');
        $this->db->join('itli_itemslist il','il.itli_itemlistid = cd.chde_itemsid','left');
        $this->db->join('eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid = il.itli_catid','left');
        $this->db->join('dist_distributors d','d.dist_distributorid = cm.chma_supplierid','left');
        

        if($frmDate &&  $toDate){
            if(DEFAULT_DATEPICKER=='NP')
            {
              $this->db->where('chma_challanrecdatebs >=', $frmDate);
              $this->db->where('chma_challanrecdatebs <=', $toDate);
            }
            else
            {
              $this->db->where('chma_challanrecdatead >=', $frmDate);
              $this->db->where('chma_challanrecdatead <=', $toDate);
            }
        }
         if($locationid){
            $this->db->where('chma_locationid',$locationid);
        }
        $query2 = $this->db->get_compiled_select();
        
        $this->db->set_dbprefix('');

        if (!empty($get['sSearch_1'])) {
            $this->db->where("invoiceno like  '%" . $get['sSearch_1'] . "%'  ");
        }
        if (!empty($get['sSearch_2'])) {
            $this->db->where("datebs like  '%" . $get['sSearch_2'] . "%'  ");
        }
        if (!empty($get['sSearch_3'])) {
            $this->db->where("fyear like  '%" . $get['sSearch_3'] . "%'  ");
        }
        if (!empty($get['sSearch_4'])) {
            $this->db->where("itemcode like  '%" . $get['sSearch_4'] . "%'  ");
        }
        if (!empty($get['sSearch_5'])) {
            $this->db->where("itemname like  '%" . $get['sSearch_5'] . "%' OR itemnamenp like  '%" . $get['sSearch_5'] . "%'  ");
        }
        if (!empty($get['sSearch_6'])) {
            $this->db->where("categoryname like  '%" . $get['sSearch_6'] . "%'  ");
        }
        if (!empty($get['sSearch_7'])) {
            $this->db->where("distributorname like  '%" . $get['sSearch_7'] . "%'  ");
        }
        if ($cond) {
            $this->db->where($cond);
        }

        $resltrpt  = $this->db->select("COUNT(*) as cnt")
                                    ->from('('.$query1 .' UNION '. $query2.') x')
                                    ->get()
                                    ->row();

        $this->db->set_dbprefix('xw_');
       
        $totalfilteredrecs = $resltrpt->cnt;

        $order_by          = 'itemname';
        $order             = 'asc';

        $where             = '';
        if ($this->input->get('iSortCol_0') == 1)
            $order_by = 'invoiceno';
        else if ($this->input->get('iSortCol_0') == 2)
            $order_by = 'datebs';
        $totalrecs = '';
        $limit     = 15;
        $offset    = 1;
        $get       = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }
        if (!empty($_GET["iDisplayLength"])) {
            $limit  = $_GET['iDisplayLength'];
            $offset = $_GET["iDisplayStart"];
        }
       

        $this->db->set_dbprefix('');

        if (!empty($get['sSearch_1'])) {
            $this->db->where("invoiceno like  '%" . $get['sSearch_1'] . "%'  ");
        }
        if (!empty($get['sSearch_2'])) {
            $this->db->where("datebs like  '%" . $get['sSearch_2'] . "%'  ");
        }
        if (!empty($get['sSearch_3'])) {
            $this->db->where("fyear like  '%" . $get['sSearch_3'] . "%'  ");
        }
        if (!empty($get['sSearch_4'])) {
            $this->db->where("itemcode like  '%" . $get['sSearch_4'] . "%'  ");
        }
        if (!empty($get['sSearch_5'])) {
            $this->db->where("itemname like  '%" . $get['sSearch_5'] . "%' OR itemnamenp like  '%" . $get['sSearch_5'] . "%'  ");
        }
        if (!empty($get['sSearch_6'])) {
            $this->db->where("categoryname like  '%" . $get['sSearch_6'] . "%'  ");
        }
        if (!empty($get['sSearch_7'])) {
            $this->db->where("distributorname like  '%" . $get['sSearch_7'] . "%'  ");
        }
        if ($cond) {
            $this->db->where($cond);
        }

        $this->db->select('*');
        $this->db->from('('.$query1 .' UNION '. $query2.') x');

        if($typeid){
            $this->db->where('typeid',$typeid);
        }

        if($catid){
            $this->db->where('catid',$catid);
        }

        if($materialtypeid){
            $this->db->where('materialtypeid',$materialtypeid);
        }

        $this->db->order_by($order_by, $order);
        if ($limit) {
            $this->db->limit($limit);
        }

        if ($offset) {
            $this->db->offset($offset);
        }
        $nquery  = $this->db->get();
        //echo $this->db->last_query();
        $this->db->set_dbprefix('xw_');
        
        $num_row = $nquery->num_rows();
        if (!empty($_GET['iDisplayLength'])) {
            $totalrecs = sizeof($nquery);
        }
        if ($num_row > 0) {
            $ndata                      = $nquery->result();
            $ndata['totalrecs']         = $totalrecs;
            $ndata['totalfilteredrecs'] = $totalfilteredrecs;//629
        } else {
            $ndata                      = array();
            $ndata['totalrecs']         = 0;
            $ndata['totalfilteredrecs'] = 0;
        }
        //echo"<pre>";print_r($ndata);
        return $ndata;
    }

    public function get_non_exp_and_exp_items_by_id($srchcol = false)
    {
        try {
            $this->db->select('mtm.trma_todepartmentid as todepartment, sum(mtd.trde_issueqty) as stockqty');
            $this->db->from('trma_transactionmain mtm');
            $this->db->join('trde_transactiondetail mtd', 'mtm.trma_trmaid = mtd.trde_trmaid');
            $this->db->where('mtm.trma_received', '1');
            if ($srchcol) {
                $this->db->where($srchcol);
            }
            $this->db->group_by('mtm.trma_todepartmentid');
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                $result = $query->result();
                return $result;
            }
        }
        catch (Exception $e) {
            throw $e;
        }
    }
}