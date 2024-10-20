<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Moving_analysis_mdl extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();

        $this->curtime = $this->general->get_currenttime();
        $this->userid = $this->session->userdata(USER_ID);
        $this->mac = $this->general->get_Mac_Address();
        $this->ip = $this->general->get_real_ipaddr();
        $this->locationid=$this->session->userdata(LOCATION_ID);
        $this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
	}
	public $validate_settings_distributors = array(               
        array('field' => 'dist_distributor', 'label' => 'Distributor Name', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'dist_phone1', 'label' => 'Phone 1', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'dist_email', 'label' => 'Email', 'rules' => 'trim|valid_email|xss_clean'),
        array('field' => 'dist_repemail', 'label' => 'Sales Resp. Email', 'rules' => 'trim|valid_email|xss_clean')
	);

	public function get_items_list(){
        try{
            $this->db->select('il.itli_itemlistid as itemid, il.itli_itemname as itemname, il.itli_salesrate as salesrate, il.itli_itemcode as itemcode, ec.eqca_category as categoryname, il.itli_movingtype as movingtype, il.itli_valuetype as valuetype');
            $this->db->from('itli_itemslist il');
            $this->db->join('eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid = il.itli_catid');
            $this->db->order_by('itli_itemname','asc');

            $query = $this->db->get();

            if($query->num_rows() > 0){
                $result = $query->result();
                return $result;
            }
            return false;
        }catch(Exception $e){
            throw $e;
        }
    }

    public function get_issue_list(){
        try{
            $sql = "
                    SELECT X.itli_itemlistid, ilo.itli_itemcode,ilo.itli_itemname,ec.eqca_category,ROUND(SUM(issueamt/issuedqty),2) salesrate,  SUM(issuedqty)issuedqty,SUM(returnqty) returnqty ,SUM(issueamt) issueamt,SUM(returnamt) returnamt,SUM(issuedqty-returnqty) as total_issue_qty,SUM(issueamt-returnamt) as TotalIsseAmt
                     FROM(
                    select il.itli_itemlistid, SUM(sd.sade_qty) as issuedqty,0 as returnqty, SUM(sd.sade_qty * sd.sade_unitrate) as issueamt, 0 as returnamt
                    from xw_sama_salemaster sm
                    left JOIN xw_sade_saledetail sd
                    ON sm.sama_salemasterid = sd.sade_salemasterid
                    left JOIN xw_itli_itemslist il on il.itli_itemlistid=sd.sade_itemsid
                    where 
                    sm.sama_st <> 'C' and 
                    sm.sama_billdatebs between '2073/08/10' AND '2074/11/10' -- and sd.sade_itemsid = 919
                    GROUP BY il.itli_itemlistid 
                    Union
                    select il.itli_itemlistid,0 as issuedqty, sum(rd.rede_qty) as returnqty, 0 as issueamt, sum(rd.rede_qty * rd.rede_unitprice) as returnamt
                    from xw_rema_returnmaster rm, xw_rede_returndetail rd,xw_itli_itemslist il
                    where rm.rema_returnmasterid = rd.rede_returnmasterid
                    and il.itli_itemlistid=rd.rede_itemsid
                    and rm.rema_returndatebs between '2073/08/10' AND '2074/11/10' -- and rd.rede_itemsid = 919
                    GROUP BY il.itli_itemlistid 
                    ) X LEFT JOIN xw_itli_itemslist ilo on ilo.itli_itemlistid= X.itli_itemlistid
                    LEFT JOIN xw_eqca_equipmentcategory ec  on ec.eqca_equipmentcategoryid = ilo.itli_catid
                     GROUP BY X.itli_itemlistid,ilo.itli_itemcode,ilo.itli_itemname,ec.eqca_category
                    order by itli_itemlistid
";
            $query = $this->db->query($sql);

            if($query->num_rows() > 0){
                $result = $query->result();
                return $result;
            }
            return false;

        }catch(Exception $e){
            throw $e;
        }
    }    

     public function get_moving_analysis_list($cond = false)
    {
        $get = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }

        if (!empty($get['sSearch_1'])) {
            $this->db->where("itli_itemcode like  '%" . $get['sSearch_1'] . "%'  ");
        }
        if (!empty($get['sSearch_2'])) {
           
            $this->db->where("itli_itemname like  '%".$get['sSearch_2']."%' OR itli_itemnamenp like  '%".$get['sSearch_2']."%'  ");
        }
       if (!empty($get['sSearch_3'])) {     
            $this->db->where("eqca_category like  '%".$get['sSearch_3']."%'");
        }
    
       

        $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');
        $toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');
        $locationid = !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');


        $materialtypeid = !empty($get['material_type'])?$get['material_type']:$this->input->post('material_type');

        $catid = !empty($get['category_type'])?$get['category_type']:$this->input->post('category_type');

        $typeid = !empty($get['counter'])?$get['counter']:$this->input->post('counter');

        $this->db->select('il.itli_itemlistid, SUM(sd.sade_qty) as issuedqty,0 as returnqty, SUM(sd.sade_qty * sd.sade_unitrate) as issueamt, 0 as returnamt');
        $this->db->from('sama_salemaster sm');
        $this->db->join('sade_saledetail sd','sm.sama_salemasterid = sd.sade_salemasterid','left');
        $this->db->join('itli_itemslist il','il.itli_itemlistid=sd.sade_itemsid','left');
        $this->db->JOIN ('eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid = il.itli_catid','LEFT');

        
        $this->db->where('sm.sama_st !=','C');
        

        if($frmDate &&  $toDate){
            if(DEFAULT_DATEPICKER=='NP')
            {
              $this->db->where('sama_billdatebs >=', $frmDate);
              $this->db->where('sama_billdatebs <=', $toDate);
            }
            else
            {
              $this->db->where('sama_billdatead >=', $frmDate);
              $this->db->where('sama_billdatead <=', $toDate);
            }
        }

        if($this->location_ismain=='Y'){
             if(!empty($locationid)){
            $this->db->where('sama_locationid',$locationid);
             }
        }else{
        $this->db->where('sama_locationid',$this->locationid);
    }

   
        $this->db->group_by('il.itli_itemlistid');
        $query1 = $this->db->get_compiled_select();
       
        $this->db->select('il.itli_itemlistid,0 as issuedqty, sum(rd.rede_qty) as returnqty, 0 as issueamt, sum(rd.rede_qty * rd.rede_unitprice) as returnamt');
        $this->db->from('rema_returnmaster rm');
        $this->db->join('rede_returndetail rd','rm.rema_returnmasterid = rd.rede_returnmasterid','left');
        $this->db->join('itli_itemslist il','il.itli_itemlistid=rd.rede_itemsid','left');

        
        if($frmDate &&  $toDate){
            if(DEFAULT_DATEPICKER=='NP')
            {
              $this->db->where('rm.rema_returndatebs >=', $frmDate);
              $this->db->where('rm.rema_returndatebs <=', $toDate);
            }
            else
            {
              $this->db->where('rm.rema_returndatead >=', $frmDate);
              $this->db->where('rm.rema_returndatead <=', $toDate);
            }
        }

        if($this->location_ismain=='Y'){
              if(!empty($locationid)){
            $this->db->where('rm.rema_locationid',$locationid);
        }
    }else{
        $this->db->where('rm.rema_locationid',$this->locationid);
    }

       
        $this->db->group_by('il.itli_itemlistid');
        
        $query2 = $this->db->get_compiled_select();
        
        $this->db->set_dbprefix('');

        if (!empty($get['sSearch_1'])) {
            $this->db->where("itli_itemcode like  '%" . $get['sSearch_1'] . "%'  ");
        }
        if (!empty($get['sSearch_2'])) {
        
            $this->db->where("itli_itemname like  '%".$get['sSearch_2']."%' OR itli_itemnamenp like  '%".$get['sSearch_2']."%'  ");
        }
        if (!empty($get['sSearch_3'])) {
            $this->db->where("eqca_category like  '%".$get['sSearch_3']."%'");
        }
        
        
        if ($cond) {
            $this->db->where($cond);
        }

        

        $resltrpt = $this->db->query("SELECT COUNT(*) as cnt from (SELECT X.* from ($query1 UNION $query2) X LEFT JOIN xw_itli_itemslist ilo on ilo.itli_itemlistid= X.itli_itemlistid
                    LEFT JOIN xw_eqca_equipmentcategory ec  on ec.eqca_equipmentcategoryid = ilo.itli_catid
                     GROUP BY X.itli_itemlistid,ilo.itli_itemcode,ilo.itli_itemname,ec.eqca_category ) Y ")->row();
        
        $this->db->set_dbprefix('xw_');
        

        $totalfilteredrecs=($resltrpt->cnt);  

        $order_by          = 'X.itli_itemlistid';
        $order             = 'asc';

        $where             = '';
        if ($this->input->get('iSortCol_0') == 1)
            $order_by = 'invoiceno';
        else if ($this->input->get('iSortCol_0') == 2)
            $order_by = 'datebs';
        else if ($this->input->get('iSortCol_0') == 3)
            $order_by = 'eqca_category';
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
            $this->db->where("itli_itemcode like  '%" . $get['sSearch_1'] . "%'  ");
        }
        if (!empty($get['sSearch_2'])) {
            $this->db->where("itli_itemname like  '%".$get['sSearch_2']."%' OR itli_itemnamenp like  '%".$get['sSearch_2']."%'  ");
        }
        if (!empty($get['sSearch_3'])) {

            $this->db->where("eqca_category like  '%".$get['sSearch_3']."%'");
        }
        
        
        if ($cond) {
            $this->db->where($cond);
        }

        $query = $this->db->query("SELECT X.itli_itemlistid, ilo.itli_itemcode,ilo.itli_itemname,ilo.itli_itemnamenp,ec.eqca_category,ROUND(SUM(issueamt/issuedqty),2) salesrate,  SUM(issuedqty)issuedqty,SUM(returnqty) returnqty ,SUM(issueamt) issueamt,SUM(returnamt) returnamt,SUM(issuedqty-returnqty) as total_issue_qty,SUM(issueamt-returnamt) as TotalIsseAmt from ($query1 UNION $query2) X LEFT JOIN xw_itli_itemslist ilo on ilo.itli_itemlistid= X.itli_itemlistid
                    LEFT JOIN xw_eqca_equipmentcategory ec  on ec.eqca_equipmentcategoryid = ilo.itli_catid
                     GROUP BY X.itli_itemlistid,ilo.itli_itemcode,ilo.itli_itemname,ec.eqca_category LIMIT $limit OFFSET $offset ");


        $this->db->order_by($order_by, $order);
            if ($limit) {
                $this->db->limit($limit);
            }

            if ($offset) {
                $this->db->offset($offset);
            }

        $nquery = $query;
        $this->db->set_dbprefix('xw_');

        $num_row = $nquery->num_rows();
         if (!empty($_GET['iDisplayLength']) &&  !empty($nquery) && is_array($nquery) && count($nquery) > 0 ) {
            $totalrecs = sizeof($nquery);
        }

        if ($num_row > 0) {
            $ndata                      = $nquery->result();
            $ndata['totalrecs']         = $totalrecs;
            $ndata['totalfilteredrecs'] = $totalfilteredrecs;
        } else {
            $ndata                      = array();
            $ndata['totalrecs']         = 0;
            $ndata['totalfilteredrecs'] = 0;
        }
        //echo "<pre>";print_r($ndata[0]->eqca_category);
        return $ndata;
    }
}