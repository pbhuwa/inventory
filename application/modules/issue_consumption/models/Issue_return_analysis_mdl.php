<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Issue_return_analysis_mdl extends CI_Model 
{
	public function __construct() 
	{
		 parent::__construct();
         $this->locationid=$this->session->userdata(LOCATION_ID);
         $this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
	}
	public function get_issue_analysis_lists($cond= false)
	{
		$get = $_GET;
      	foreach ($get as $key => $value) {
        	$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
      	}

        if(!empty($get['sSearch_1'])){
            $this->db->where("lower(itli_itemcode) like  '%".$get['sSearch_1']."%'  ");
        }
        if(!empty($get['sSearch_2'])){
            $this->db->where("lower(itli_itemname) like  '%".$get['sSearch_2']."%'  ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("lower(maty_material) like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("lower(eqca_category) like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("lower(dept_depname) like  '%".$get['sSearch_5']."%'  ");
        }
        if(!empty($get['sSearch_6'])){
            $this->db->where("lower(rema_returndatebs) like  '%".$get['sSearch_6']."%'  ");
        }
        if(!empty($get['sSearch_7'])){
            $this->db->where("lower(rema_invoiceno) like  '%".$get['sSearch_7']."%'  ");
        }
        if(!empty($get['sSearch_8'])){
            $this->db->where("lower(rede_qty) like  '%".$get['sSearch_8']."%'  ");
        }
        if(!empty($get['sSearch_9'])){
            $this->db->where("lower(rede_unitprice) like  '%".$get['sSearch_9']."%'  ");
        }
        if(!empty($get['sSearch_10'])){
            $this->db->where("lower((rd.rede_qty * rd.rede_unitprice)) like  '%".$get['sSearch_10']."%'  ");
        }
        if(!empty($get['sSearch_11'])){
            $this->db->where("lower(rede_invoiceno) like  '%".$get['sSearch_11']."%'  ");
        }
        if(!empty($get['sSearch_12'])){
            $this->db->where("lower(rede_controlno) like  '%".$get['sSearch_12']."%'  ");
        }
        if($cond) {
            $this->db->where($cond);
        }

        $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');
        $toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');
         $locationid = !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');


        $supplier = !empty($get['supplier'])?$get['supplier']:$this->input->post('supplier');
        
        $items = !empty($get['items'])?$get['items']:$this->input->post('items');

        if(!empty(($frmDate && $toDate)))
        {    
        	$this->db->where('rm.rema_returndatebs >=',$frmDate);
            $this->db->where('rm.rema_returndatebs <=',$toDate);
        }

        if(!empty($supplier)){
            $this->db->where('supp_supplierid',$supplier);
        }

        if(!empty($items)){
            $this->db->where('itli_itemlistid',$items);
        }
        if($this->location_ismain=='Y'){
         if(!empty($locationid)){
         $this->db->where('rm.rema_locationid',$locationid);
        }}
        else{
            $this->db->where('rm.rema_locationid',$this->locationid);
        }
        

        $resltrpt=$this->db->select("COUNT(*) as cnt")
        			->from('rema_returnmaster rm')
                    ->join('rede_returndetail rd', 'rd.rede_returnmasterid=rm.rema_returnmasterid', "LEFT")
                    ->join('itli_itemslist il', 'il.itli_itemlistid=rd.rede_itemsid', "LEFT")
                    ->join('maty_materialtype mt', 'mt.maty_materialtypeid=il.itli_materialtypeid', "LEFT")
                    ->join('dept_department d', 'd.dept_depid = rm.rema_depid', "LEFT")
                    ->join('eqca_equipmentcategory c', 'c.eqca_equipmentcategoryid = il.itli_catid', "LEFT")
                    ->get()
                    ->row();
        //echo $this->db->last_query();die(); 
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
      	 	$order_by = 'maty_material';
      	else if($this->input->get('iSortCol_0')==4)
      	 	$order_by = 'eqca_category';
      	else if($this->input->get('iSortCol_0')==5)
      	 	$order_by = 'dept_depname';
      	else if($this->input->get('iSortCol_0')==6)
      	 	$order_by = 'rema_returndatebs';
        else if($this->input->get('iSortCol_0')==7)
            $order_by = 'rema_invoiceno';
        else if($this->input->get('iSortCol_0')==8)
            $order_by = 'rede_qty';
        else if($this->input->get('iSortCol_0')==9)
            $order_by = 'rede_unitprice';
        else if($this->input->get('iSortCol_0')==10)
            $order_by = 'amount';
        else if($this->input->get('iSortCol_0')==11)
            $order_by = 'rede_controlno';
        else if($this->input->get('iSortCol_0')==12)
            $order_by = 'rede_invoiceno';
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
            $this->db->where("lower(maty_material) like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("lower(eqca_category) like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("lower(dept_depname) like  '%".$get['sSearch_5']."%'  ");
        }
        if(!empty($get['sSearch_6'])){
            $this->db->where("lower(rema_returndatebs) like  '%".$get['sSearch_6']."%'  ");
        }

        if(!empty($get['sSearch_7'])){
            $this->db->where("lower(rema_invoiceno) like  '%".$get['sSearch_7']."%'  ");
        }

        if(!empty($get['sSearch_8'])){
            $this->db->where("lower(rede_qty) like  '%".$get['sSearch_8']."%'  ");
        }
        if(!empty($get['sSearch_9'])){
            $this->db->where("lower(rede_unitprice) like  '%".$get['sSearch_9']."%'  ");
        }
        if(!empty($get['sSearch_10'])){
            $this->db->where("lower((rd.rede_qty * rd.rede_unitprice)) like  '%".$get['sSearch_10']."%'  ");
        }
        if(!empty($get['sSearch_11'])){
            $this->db->where("lower(rede_invoiceno) like  '%".$get['sSearch_11']."%'  ");
        }
        if(!empty($get['sSearch_12'])){
            $this->db->where("lower(rede_controlno) like  '%".$get['sSearch_12']."%'  ");
        }
       
        if($cond) {
          $this->db->where($cond);
        }

        $frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');
        $toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');
         $locationid = !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');

        $supplier = !empty($get['supplier'])?$get['supplier']:$this->input->post('supplier');
        
        $items = !empty($get['items'])?$get['items']:$this->input->post('items');

       if(!empty(($frmDate && $toDate)))
        {  
            $this->db->where('rm.rema_returndatebs >=',$frmDate);
            $this->db->where('rm.rema_returndatebs <=',$toDate);
        }

        if(!empty($supplier)){
            $this->db->where('supp_supplierid',$supplier);
        }

        if(!empty($items)){
            $this->db->where('itli_itemlistid',$items);
        }
        if($this->location_ismain=='Y'){
         if(!empty($locationid)){
            $this->db->where('rm.rema_locationid',$locationid);
        }}
        else{
            $this->db->where('rm.rema_locationid',$this->locationid);

        }

        $this->db->select("mt.maty_material,il.itli_materialtypeid as typename, rm.rema_invoiceno as invoiceno_1,rd.rede_qty,rm.rema_returndatebs,rd.rede_invoiceno,rd.rede_unitprice,d.dept_depname,il.itli_itemname,il.itli_itemcode,c.eqca_category,(rd.rede_qty * rd.rede_unitprice) as amount,rd.rede_controlno, ");

		    $this->db->from('rema_returnmaster rm');
	        $this->db->join('rede_returndetail rd', 'rd.rede_returnmasterid=rm.rema_returnmasterid', "LEFT");
	        $this->db->join('itli_itemslist il', 'il.itli_itemlistid=rd.rede_itemsid', "LEFT");
	        $this->db->join('maty_materialtype mt', 'mt.maty_materialtypeid=il.itli_materialtypeid', "LEFT");
	        $this->db->join('dept_department d', 'd.dept_depid = rm.rema_depid', "LEFT");
	        $this->db->join('eqca_equipmentcategory c', 'c.eqca_equipmentcategoryid = il.itli_catid', "LEFT");
        // if(!empty($order_by) && !empty($order)){
        //     $order_by = 'maty_material';
        //     $order = 'asc';
        // }
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
}