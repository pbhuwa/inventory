<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Receiver_wise_issue_details_mdl extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
         $this->locationid=$this->session->userdata(LOCATION_ID);
        $this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
	}
	public function get_current_stock_lists($cond= false)
	{
		$get = $_GET;
      	foreach ($get as $key => $value) {
        	$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
      	}

        if(!empty($get['sSearch_1'])){
            $this->db->where("itli_itemcode) like  '%".$get['sSearch_1']."%'  ");
        }
        if(!empty($get['sSearch_2'])){
            $this->db->where("lower(itli_itemname) like  '%".$get['sSearch_2']."%'  ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("lower(eqca_category) like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("lower(maty_material like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("lower(itli_maxlimit) like  '%".$get['sSearch_5']."%'  ");
        }
        if(!empty($get['sSearch_6'])){
            $this->db->where("lower(itli_reorderlevel) like  '%".$get['sSearch_6']."%'  ");
        }
        if(!empty($get['sSearch_7'])){
            $this->db->where("lower(atstock) like  '%".$get['sSearch_7']."%'  ");
        }
        if(!empty($get['sSearch_8'])){
            $this->db->where("lower(matd_unitprice) like  '%".$get['sSearch_8']."%'  ");
        }
        if(!empty($get['sSearch_9'])){
            $this->db->where("lower(unit_unitname) like  '%".$get['sSearch_9']."%'  ");
        }
        
        if($cond) {
            $this->db->where($cond);
        }

        $store_id = !empty($get['store_id'])?$get['store_id']:$this->input->post('store_id');
        $toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');

        $supplier = !empty($get['supplier'])?$get['supplier']:$this->input->post('supplier');
        
        $items = !empty($get['items'])?$get['items']:$this->input->post('items');

        if(!empty(($store_id)))
        {  
        	//print_r($store_id);die;
           $this->db->where('c.eqca_equiptypeid',$store_id);
           
        }

        if(!empty($supplier)){
            $this->db->where('supp_supplierid',$supplier);
        }

        if(!empty($items)){
            $this->db->where('itli_itemlistid',$items);
        }

        $resltrpt=$this->db->select("COUNT(*) as cnt")
        			->from('matd_mattransdetail sd')
                    ->join('itli_itemslist it', 'it.itli_itemlistid = sd.matd_itemsid', "LEFT")
                    ->join('maty_materialtype mt', 'mt.maty_materialtypeid = it.itli_materialtypeid', "LEFT")
                    ->join('unit_unit u', 'u.unit_unitid = sd.matd_unitprice', "LEFT")
                    ->join('eqca_equipmentcategory c', 'c.eqca_equipmentcategoryid = it.itli_catid', "LEFT")
                    ->get()
                    ->row();
        // echo $this->db->last_query();die(); 
      	$totalfilteredrecs=$resltrpt->cnt; 

      	$order_by = 'itli_itemname';
      	$order = 'asc';
      	if($this->input->get('sSortDir_0'))
  		{
  				$order = $this->input->get('sSortDir_0');
  		}
  
      	$where='';
      	if($this->input->get('iSortCol_0')==1)
        	$order_by = 'itli_itemcode';
      	else if($this->input->get('iSortCol_0')==2)
       		$order_by = 'itli_itemname';
       	else if($this->input->get('iSortCol_0')==3)
      	 	$order_by = 'eqca_category';
      	else if($this->input->get('iSortCol_0')==4)
      	 	$order_by = 'maty_material';
      	else if($this->input->get('iSortCol_0')==5)
      	 	$order_by = 'itli_maxlimit';
      	else if($this->input->get('iSortCol_0')==6)
      	 	$order_by = 'itli_reorderlevel';
        else if($this->input->get('iSortCol_0')==7)
            $order_by = 'atstock';
        else if($this->input->get('iSortCol_0')==8)
            $order_by = 'matd_unitprice';
        else if($this->input->get('iSortCol_0')==9)
            $order_by = 'unit_unitname';
        
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

        if(!empty($get['sSearch_1'])){
            $this->db->where("lower(itli_itemcode) like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("lower(itli_itemname) like  '%".$get['sSearch_2']."%'  ");
        }

        if(!empty($get['sSearch_3'])){
            $this->db->where("lower(eqca_category) like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("lower(maty_material) like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("lower(itli_maxlimit) like  '%".$get['sSearch_5']."%'  ");
        }
        if(!empty($get['sSearch_6'])){
            $this->db->where("lower(itli_reorderlevel) like  '%".$get['sSearch_6']."%'  ");
        }

        if(!empty($get['sSearch_7'])){
            $this->db->where("lower(atstock) like  '%".$get['sSearch_7']."%'  ");
        }
        if(!empty($get['sSearch_8'])){
            $this->db->where("lower(matd_unitprice) like  '%".$get['sSearch_8']."%'  ");
        }

        if(!empty($get['sSearch_9'])){
            $this->db->where("lower(unit_unitname) like  '%".$get['sSearch_9']."%'  ");
        }
       
        if($cond) {
          $this->db->where($cond);
        }

        $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');
        $toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');

        $supplier = !empty($get['supplier'])?$get['supplier']:$this->input->post('supplier');
        
        $items = !empty($get['items'])?$get['items']:$this->input->post('items');

        if(!empty(($store_id)))
        {  
           $this->db->where('c.eqca_equiptypeid',$store_id);
           
        }

        if(!empty($supplier)){
            $this->db->where('supp_supplierid',$supplier);
        }

        if(!empty($items)){
            $this->db->where('itli_itemlistid',$items);
        }
        $this->db->select("mt.maty_material,u.unit_unitname, it.itli_itemname,it.itli_itemcode,it.itli_maxlimit, it.itli_reorderlevel,u.unit_unitname,c.eqca_category,sd.matd_issueqty AS atstock,sd.matd_expdatebs,
	    		(
	    		CASE WHEN (sd.matd_batchno != '') THEN sd.matd_batchno ELSE sd.matd_controlno END ) batchno,(sd.matd_issueqty * sd.matd_unitprice) as amount,sd.matd_unitprice");
		$this->db->from('matd_mattransdetail sd');
		$this->db->join('itli_itemslist it', 'it.itli_itemlistid = sd.matd_itemsid', "LEFT");
			$this->db->join('maty_materialtype mt', 'mt.maty_materialtypeid = it.itli_materialtypeid', "LEFT");
		$this->db->join('unit_unit u', 'u.unit_unitid = sd.matd_unitprice', "LEFT");
    	$this->db->join('eqca_equipmentcategory c', 'c.eqca_equipmentcategoryid = it.itli_catid', "LEFT");
        if(!empty($order_by) && !empty($order)){
            $order_by = 'maty_material';
            $order = 'asc';
        }
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

        //echo $this->db->last_query();die();
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
	public function get_category_wise_report($srchcol=false,$limit=false,$offset=false,$order=false,$order_by=false)
	{
		$fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');

        $this->db->select('p.*, bm.bmin_equipmentkey, rsk.riva_risk, d.dept_depname');
		$this->db->from('pmta_pmtable p');
		$this->db->join('bmin_bmeinventory bm', 'bm.bmin_equipid = p.pmta_equipid');
		$this->db->join('riva_riskvalues rsk', 'rsk.riva_riskid = bm.bmin_riskid', "LEFT");
		$this->db->join('dept_department d', 'd.dept_depid  = bm.bmin_departmentid', "LEFT");

		if($fromdate &&  $todate){
	        if(DEFAULT_DATEPICKER=='NP')
	        {
	          $this->db->where('pmta_pmdatebs >=', $fromdate);
	          $this->db->where('pmta_pmdatebs <=', $todate);
	        }
	        else
	        {
	          $this->db->where('pmta_pmdatead >=', $fromdate);
	          $this->db->where('pmta_pmdatead <=', $todate);
	        }
	    }
        if($srchcol)
        {
         	$this->db->where($srchcol); 
        }
		$query = $this->db->get();
		//echo $this->db->last_query();die();
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();		
			return $data;		
		}		
		return false;
	}

    public function get_receiver_wise_issue_details($cond = false){
        if($cond) {
            $this->db->where($cond);
        }

        $frmDate = $this->input->post('fromdate');
        $toDate = $this->input->post('todate');
        $locationid = $this->input->post('locationid');
        $store_id = $this->input->post('store_id');
        $depid = $this->input->post('depid');
        $catid = $this->input->post('catid');
        $maty_materialtypeid = $this->input->post('materialtypeid');

        $cond = '';
        if(!empty(($store_id)))
        {  
           $cond .= (" AND sm.sama_storeid = $store_id");
        }
        if(!empty($depid)){
            $cond .= (" AND sm.sama_depid = $depid");
        }
        if(!empty($maty_materialtypeid)){
            $cond .= (" AND mt.maty_materialtypeid = $maty_materialtypeid");
        }
        if(!empty($catid)){
            $cond .= (" AND it.itli_catid = $catid");
        }
        if($this->location_ismain=='Y'){
        if(!empty($locationid)){
            $cond .= (" AND sm.sama_locationid = $locationid");
        }
      }
        else{
            $cond .= (" AND sm.sama_locationid = $this->locationid");

        }

        $sql = "SELECT
                    itli_itemlistid,
                    qty,
                    rate,
                    (qty*rate) tamount,
                    itli_itemcode,
                    itli_itemname,
                    unit_unitname,
                    dept_depname,
                    sama_receivedby,
                    sama_billdatebs,
                    sama_billdatead,
                    sama_invoiceno,
                    sama_requisitionno FROM(
                        SELECT
                            it.itli_itemlistid,
                            sd.sade_qty AS qty,
                            sd.sade_unitrate as rate,
                            sm.sama_storeid,
                            eq.eqty_equipmenttype,
                            sm.sama_depid,
                            d.dept_depname,
                            sm.sama_soldby,
                            sm.sama_receivedby,
                            sm.sama_requisitionno,
                            it.itli_itemname,
                            u.unit_unitname,
                            mt.maty_materialtypeid,
                            it.itli_itemcode,
                            it.itli_catid,
                            ec.eqca_category,
                            sm.sama_billdatebs,
                            sm.sama_billdatead,
                            sm.sama_invoiceno
                        FROM
                            xw_sama_salemaster sm
                        LEFT JOIN xw_sade_saledetail sd ON sd.sade_salemasterid = sm.sama_salemasterid
                        INNER JOIN xw_itli_itemslist it ON it.itli_itemlistid = sd.sade_itemsid
                        LEFT JOIN xw_maty_materialtype mt ON mt.maty_materialtypeid = it.itli_materialtypeid
                        LEFT JOIN xw_unit_unit u ON u.unit_unitid = it.itli_unitid
                        INNER JOIN xw_dept_department d ON d.dept_depid = sm.sama_depid
                        LEFT JOIN xw_eqty_equipmenttype eq ON eq.eqty_equipmenttypeid = sm.sama_storeid
                        LEFT JOIN xw_eqca_equipmentcategory ec on ec.eqca_equipmentcategoryid = it.itli_catid
                        WHERE
                            sm.sama_st = 'N' AND sm.sama_billdatebs BETWEEN '$frmDate' AND '$toDate' $cond
                        GROUP BY
                            sd.sade_unitrate,
                            sm.sama_storeid,
                            eq.eqty_equipmenttype,
                            sm.sama_depid,
                            d.dept_depname,
                            sm.sama_soldby,
                            sm.sama_receivedby,
                            sm.sama_requisitionno,
                            it.itli_itemname,
                            u.unit_unitname,
                            mt.maty_materialtypeid,
                            it.itli_itemcode,
                            it.itli_catid,
                            ec.eqca_category,
                            sm.sama_billdatebs,
                            sm.sama_billdatead,
                            sm.sama_invoiceno
                    ) p
                GROUP BY
                    p.rate,
                    p.itli_itemcode,
                    p.itli_itemname,
                    p.unit_unitname,
                    p.dept_depname,
                    p.sama_receivedby,
                    p.sama_billdatebs,
                    p.sama_billdatead,
                    p.sama_invoiceno,
                    p.sama_requisitionno
                ORDER BY
                    p.itli_itemname ASC";

        $query=$this->db->query($sql);
        // echo $this->db->last_query();die;        
        if($query->num_rows() > 0) 
        {
            $data=$query->result();     
            return $data;       
        }       
        return false;
    }

    public function get_receiver_wise_return_details($cond = false){
        if($cond) {
            $this->db->where($cond);
        }

        $frmDate = $this->input->post('fromdate');
        $toDate = $this->input->post('todate');
        $locationid = $this->input->post('locationid');
        $store_id = $this->input->post('store_id');
        $depid = $this->input->post('depid');
        $catid = $this->input->post('catid');
        $maty_materialtypeid = $this->input->post('materialtypeid');

        $cond = '';
        if(!empty(($store_id)))
        {  
           $cond .= (" AND sm.rema_storeid = $store_id");
        }
        if(!empty($depid)){
            $cond .= (" AND sm.rema_depid = $depid");
        }
        if(!empty($maty_materialtypeid)){
            $cond .= (" AND it.itli_materialtypeid = $maty_materialtypeid");
        }
        if(!empty($catid)){
            $cond .= (" AND it.itli_catid = $catid");
        }
        // if(!empty($locationid)){
        //     $cond .= (" AND sm.rema_locationid = $locationid");
        // }
         if($this->location_ismain=='Y'){
        if(!empty($locationid)){
            $cond .= (" AND sm.rema_locationid = $locationid");
        }
      }
        else{
            $cond .= (" AND sm.rema_locationid = $this->locationid");

        }

        $sql = "SELECT
                    itli_itemlistid,
                    qty AS returnqty,
                    rate,
                    (qty*rate) as total_amt,
                    itli_itemcode,
                    itli_itemname,
                    unit_unitname,
                    dept_depname,
                    rema_returnby,
                    rema_username,
                    rema_returndatebs,
                    rema_returndatead,
                    rema_invoiceno,
                    rema_receiveno
                FROM
                    (
                        SELECT
                            it.itli_itemlistid,
                            sd.rede_qty AS qty,
                            sd.rede_unitprice as rate,
                            it.itli_itemname,
                            sm.rema_storeid,
                            eq.eqty_equipmenttype,
                            sm.rema_depid,
                            d.dept_depname,
                            sm.rema_username,
                            sm.rema_returnby,
                            sm.rema_receiveno,
                            u.unit_unitname,
                            mt.maty_materialtypeid,
                            it.itli_itemcode,
                            it.itli_catid,
                            ec.eqca_category,
                            sm.rema_returndatebs,
                            sm.rema_returndatead,
                            sm.rema_invoiceno
                        FROM
                            xw_rema_returnmaster sm
                        LEFT JOIN xw_rede_returndetail sd ON sd.rede_returnmasterid = sm.rema_returnmasterid
                        INNER JOIN xw_itli_itemslist it ON it.itli_itemlistid = sd.rede_itemsid
                        LEFT JOIN xw_maty_materialtype mt ON mt.maty_materialtypeid = it.itli_materialtypeid
                        LEFT JOIN xw_unit_unit u ON u.unit_unitid = it.itli_unitid
                        INNER JOIN xw_dept_department d ON d.dept_depid = sm.rema_depid
                        LEFT JOIN xw_eqty_equipmenttype eq ON eq.eqty_equipmenttypeid = sm.rema_storeid
                        LEFT JOIN xw_eqca_equipmentcategory ec on ec.eqca_equipmentcategoryid = it.itli_catid
                        WHERE
                            sm.rema_st = 'N' AND sm.rema_returndatebs BETWEEN '$frmDate' AND '$toDate' $cond
                        GROUP BY
                            sd.rede_unitprice,
                            it.itli_itemname,
                            sm.rema_storeid,
                            eq.eqty_equipmenttype,
                            sm.rema_depid,
                            d.dept_depname,
                            sm.rema_username,
                            sm.rema_returnby,
                            sm.rema_receiveno,
                            u.unit_unitname,
                            mt.maty_materialtypeid,
                            it.itli_itemcode,
                            it.itli_catid,
                            ec.eqca_category,
                            sm.rema_returndatebs,
                            sm.rema_returndatead,
                            sm.rema_invoiceno
                    ) p
                GROUP BY
                    p.rate,
                    p.itli_itemcode,
                    p.itli_itemname,
                    p.unit_unitname,
                    p.dept_depname,
                    p.rema_returnby,
                    p.rema_username,
                    p.rema_returndatebs,
                    p.rema_returndatead,
                    p.rema_invoiceno,
                    p.rema_receiveno
                ORDER BY
                    p.itli_itemname ASC";
        $query=$this->db->query($sql);
        // echo $this->db->last_query();die;        
        if($query->num_rows() > 0) 
        {
            $data=$query->result();     
            return $data;       
        }       
        return false;
    }

}