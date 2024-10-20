<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report_issue_mdl extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
		    $this->locationid=$this->session->userdata(LOCATION_ID);
        $this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
		//$this->table='eqli_equipmentlist';
	}
	public function category_wise_report($srchcol=false, $groupby = false,$cond =false,$cond1=false)
	{
		//echo "<pre>"; print_r($this->input->post()); die;
		$fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
        $loid = $this->input->post('locationid');
      	$material=$this->input->post('materialtype');
      	//echo $material; die;
      	if($material){
      		$where_materialtypeid = "AND my.maty_materialtypeid = '".$material."'";
      		
      	}else{
      		$where_materialtypeid="";
      	}

      if($this->location_ismain=='Y'){
      		if($loid){
      		$where_sama_locationid = "AND sm.sama_locationid = '".$loid."'";
      		$where_rema_locationid = "AND rm.rema_locationid = '".$loid."'";
      		
      	}else{
      		$where_sama_locationid = $where_rema_locationid = "";
      	}
      }else{

      		$where_sama_locationid = "AND sm.sama_locationid = '".$this->locationid."'";
      		$where_rema_locationid = "AND rm.rema_locationid = '".$this->locationid."'";
      		
      	
      	}
      


      	//print_r($where_sama_locationid);die;
		$sql="SELECT 
			itli_itemcode,
			itli_itemname,  
			maty_material,
			maty_materialtypeid,
			unit_unitname,
			SUM(
					CASE
					WHEN (tname = 'I') THEN
						(sade_qty)
					ELSE
						0
					END
				) AS IssQty,
			SUM(
				CASE
				WHEN (tname = 'R') THEN
					sade_qty
				ELSE
					0
				END
			) AS RetQty,
			(
				SUM(
					CASE
					WHEN (tname = 'I') THEN
						(sade_qty)
					ELSE
						0
					END
				) - SUM(
					CASE
					WHEN (tname = 'R') THEN
						sade_qty
					ELSE
						0
					END
				)
			) AS TotalIssue,
			SUM(
				CASE
				WHEN (tname = 'I') THEN
					amount
				ELSE
					0
				END
			) AS IssueValue,
			SUM(
				CASE
				WHEN (tname = 'R') THEN
					(amount)
				ELSE
					0
				END
			) AS ReturnValue,
			(
				SUM(
					CASE
					WHEN (tname = 'I') THEN
						(amount)
					ELSE
						0
					END
				) - SUM(
					CASE
					WHEN (tname = 'R') THEN
						amount
					ELSE
						0
					END
				)
			) AS TotalValue
		FROM
			(
				SELECT
					il.itli_itemcode,
					il.itli_itemname,
					my.maty_material,
					my.maty_materialtypeid,
					sm.sama_billdatebs,
					sm.sama_invoiceno,
					sd.sade_qty,
					sd.sade_unitrate AS unitrate,
					u.unit_unitname,
					(
						sd.sade_qty * sd.sade_unitrate
					) AS amount,
					'I' AS tname
				FROM
					xw_sama_salemaster sm
				LEFT JOIN xw_sade_saledetail sd ON sd.sade_salemasterid = sm.sama_salemasterid
				LEFT JOIN xw_itli_itemslist il ON il.itli_itemlistid = sd.sade_itemsid
				LEFT JOIN xw_maty_materialtype my ON my.maty_materialtypeid = il.itli_materialtypeid
				LEFT JOIN xw_unit_unit u ON u.unit_unitid = il.itli_unitid
				WHERE
					sm.sama_st = 'N'
				AND sm.sama_billdatebs BETWEEN '$fromdate'
				AND '$todate' $where_sama_locationid $where_materialtypeid

				UNION

					SELECT
					il.itli_itemcode,
					il.itli_itemname,
					my.maty_material,
					my.maty_materialtypeid,
					rm.rema_returndatebs,
					rm.rema_invoiceno AS issueno,
					rd.rede_qty,
					rd.rede_unitprice AS unitrate,
					u.unit_unitname,
					rd.rede_total AS amount,
						'R' AS tname
					FROM
		        xw_rema_returnmaster rm 
					LEFT JOIN xw_rede_returndetail rd ON rm.rema_returnmasterid = rd.rede_returnmasterid
					LEFT JOIN xw_itli_itemslist il ON il.itli_itemlistid = rd.rede_itemsid
					LEFT JOIN xw_maty_materialtype my ON my.maty_materialtypeid = il.itli_materialtypeid
					LEFT JOIN xw_unit_unit u ON u.unit_unitid = il.itli_unitid
					WHERE
		      rm.rema_returndatebs BETWEEN '$fromdate'
				AND '$todate' $where_rema_locationid $where_materialtypeid
			) X
		$srchcol
		GROUP BY
		$groupby";
		$query=$this->db->query($sql);
		// echo $this->db->last_query();die;		
		if($query->num_rows() > 0) 
		{
			$data=$query->result();		
			return $data;		
		}		
		return false;
	}
	public function sub_category_wise_report($srchcol=false,$groupby=false,$cond=false,$cond1=false)
	{
		//echo "<pre>"; print_r($this->input->post()); die; 
		$fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
        $locationid = $this->input->post('locationid');
        $store_id = $this->input->post('store_id');
        $catid = $this->input->post('catid');

        $where_sama_locationid = $where_rema_locationid = "";
      	if($this->location_ismain=='Y'){
      		if($locationid){
      		$where_sama_locationid = 'AND sm.sama_locationid = "'.$locationid.'" ';
      		$where_rema_locationid = 'AND rm.rema_locationid = "'.$locationid.'" ';
      	}else{
      		$where_sama_locationid = $where_rema_locationid = "";

      	}
      	}else{

      		$where_sama_locationid = 'AND sm.sama_locationid = "'.$this->locationid.'" ';
      		$where_rema_locationid = 'AND rm.rema_locationid = "'.$this->locationid.'" ';
      	
      	}

      	$where_sama_storeid = $where_rema_storeid = "";
      	if($store_id){
      		$where_sama_storeid = 'AND sm.sama_storeid = "'.$store_id.'" ';
      		$where_rema_storeid = 'AND rm.rema_storeid = "'.$store_id.'" ';
      	}
      	if($catid){
      		$where_equipmentid= 'AND ec.eqca_equipmentcategoryid = "'.$catid.'" ';
          	}
          	else{
          	$where_equipmentid = "";
          	}
      	

		$sql="SELECT
			itli_itemname,itli_itemcode, 	
			eqca_equipmentcategoryid,
			eqca_category,
			SUM(IssQty) as issueqty,
			SUM(RetQty) as retqty,
			SUM(TotalIssue) as totalissue,
			SUM(IssueValue) as issuevalue,
			SUM(ReturnValue) as returnvalue
		FROM
		(
			SELECT		
			    itli_itemcode,
					itli_itemname, 
					eqca_category,
				  eqca_equipmentcategoryid,
					unit_unitname,
					SUM(
							CASE
							WHEN (tname = 'I') THEN
								(sade_qty)
							ELSE
								0
							END
						) AS IssQty,
					SUM(
						CASE
						WHEN (tname = 'R') THEN
							sade_qty
						ELSE
							0
						END
					) AS RetQty,
					(
						SUM(
							CASE
							WHEN (tname = 'I') THEN
								(sade_qty)
							ELSE
								0
							END
						) - SUM(
							CASE
							WHEN (tname = 'R') THEN
								sade_qty
							ELSE
								0
							END
						)
					) AS TotalIssue,
					SUM(
						CASE
						WHEN (tname = 'I') THEN
							amount
						ELSE
							0
						END
					) AS IssueValue,
					SUM(
						CASE
						WHEN (tname = 'R') THEN
							(amount)
						ELSE
							0
						END
		) AS ReturnValue
		FROM
		(
			SELECT
					il.itli_itemcode,
					il.itli_itemname,
					ec.eqca_category,
					ec.eqca_equipmentcategoryid,
					sm.sama_billdatebs as billdate,
					sm.sama_invoiceno,
					sd.sade_qty,
					sd.sade_unitrate AS unitrate,
					u.unit_unitname,
					(
						sd.sade_qty * sd.sade_unitrate
					) AS amount,
					'I' AS tname
				FROM
					xw_sama_salemaster sm
				LEFT JOIN xw_sade_saledetail sd ON sd.sade_salemasterid = sm.sama_salemasterid
				LEFT JOIN xw_itli_itemslist il ON il.itli_itemlistid = sd.sade_itemsid
				LEFT JOIN xw_eqca_equipmentcategory ec ON ec.eqca_equipmentcategoryid = il.itli_catid
				LEFT JOIN xw_unit_unit u ON u.unit_unitid = il.itli_typeid
				WHERE
					sm.sama_st = 'N'
				AND sm.sama_billdatebs BETWEEN '$fromdate'
							AND '$todate' $where_sama_locationid $where_sama_storeid $cond $srchcol 
							$where_equipmentid
			UNION

			SELECT
					il.itli_itemcode,
					il.itli_itemname,
					ec.eqca_category,
					ec.eqca_equipmentcategoryid,
					rm.rema_returndatebs as billdate,
					rm.rema_invoiceno AS issueno,
					rd.rede_qty,
					rd.rede_unitprice AS unitrate,
					u.unit_unitname,
					rd.rede_total AS amount,
						'R' AS tname
					FROM
						xw_rema_returnmaster rm 
					LEFT JOIN xw_rede_returndetail rd ON rm.rema_returnmasterid = rd.rede_returnmasterid
					LEFT JOIN xw_itli_itemslist il ON il.itli_itemlistid = rd.rede_itemsid
					LEFT JOIN xw_eqca_equipmentcategory ec ON ec.eqca_equipmentcategoryid = il.itli_catid
					LEFT JOIN xw_unit_unit u ON u.unit_unitid = il.itli_typeid
					WHERE rm.rema_returndatebs BETWEEN '$fromdate'
						AND '$todate' $where_rema_locationid $where_rema_storeid $cond1 $srchcol $where_equipmentid
								
			) x
		GROUP BY
			$groupby
			
		) y
		GROUP BY
			$groupby
		 
			";
// 			--    eqca_equipmentcategoryid,
// 			-- eqca_category
// -- x.eqca_category,
// 			-- x.eqca_equipmentcategoryid
		$query=$this->db->query($sql);
		// echo $this->db->last_query();die;  		
		if($query->num_rows() > 0) 
		{
			$data=$query->result();		
			return $data;		
		}		
		return false;
	}
	public function get_category_wise_report($srchcol=false,$limit=false,$offset=false,$order=false,$order_by=false)
	{
		$fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
        $locationid=$this->input->post('locationid');
        $this->db->select('p.*, bm.bmin_equipmentkey, rsk.riva_risk, d.dept_depname');
		$this->db->from('pmta_pmtable p');
		$this->db->join('bmin_bmeinventory bm', 'bm.bmin_equipid = p.pmta_equipid');
		$this->db->join('riva_riskvalues rsk', 'rsk.riva_riskid = bm.bmin_riskid', "LEFT");
		$this->db->join('dept_department d', 'd.dept_depid  = bm.bmin_departmentid', "LEFT");
		if($fromdate &&  $todate){
	        if(DEFAULT_DATEPICKER=='NP')
	        {
	          $this->db->where('p.pmta_pmdatebs >=', $fromdate);
	          $this->db->where('p.pmta_pmdatebs <=', $todate);
	        }
	        else
	        {
	          $this->db->where('p.pmta_pmdatead >=', $fromdate);
	          $this->db->where('p.pmta_pmdatead <=', $todate);
	        }
	    }
	    if($locationid){
	    	$this->db->where('p.pmta_locationid',$locationid);
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

	public function get_issue_report($srchcol=false,$limit=false,$offset=false,$order=false,$order_by=false)
	{
		$fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
        $locationid=$this->input->post('locationid');
       // $this->db->select('s.*, sd.*,it.itli_itemname, n.maty_material, (sd.sade_unitrate * sd.sade_qty)as amount');
        $this->db->select('s.sama_depname,s.sama_billdatebs,s.sama_invoiceno, sd.sade_qty, sd.sade_unitrate,it.itli_itemname, n.maty_material, SUM(sd.sade_unitrate * sd.sade_qty)as amount, sum(s.sama_totalamount) as issueamount');
		$this->db->from('sama_salemaster s');
		$this->db->join('sade_saledetail sd', 'sd.sade_salemasterid = s.sama_salemasterid');
		$this->db->join('itli_itemslist it', 'it.itli_itemlistid = sd.sade_itemsid', "LEFT");
		$this->db->join('maty_materialtype n', 'n.maty_materialtypeid = it.itli_materialtypeid', "LEFT");
		$this->db->where('s.sama_st', "N");
		if($fromdate &&  $todate){
	        if(DEFAULT_DATEPICKER=='NP')
	        {
	          $this->db->where('s.sama_billdatebs >=', $fromdate);
	          $this->db->where('s.sama_billdatebs <=', $todate);
	        }
	        else
	        {
	          $this->db->where('s.sama_billdatebs >=', $fromdate);
	          $this->db->where('s.sama_billdatebs <=', $todate);
	        }
	    }
	   if($this->location_ismain=='Y'){
	    if($locationid){
	    	$this->db->where('s.sama_locationid',$locationid);
	    }}
	    else{
	    	$this->db->where('s.sama_locationid',$this->locationid);

	    }
        if($srchcol)
        {
         	$this->db->where($srchcol); 
        }
		$query = $this->db->get();
		// echo $this->db->last_query();die();
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();		
			return $data;		
		}		
		return false;
	}
	public function get_issue_details_report($srchcol=false,$limit=false,$offset=false,$order=false,$order_by=false)
	{
		$fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
        $username = $this->input->post('userid');
        $storeid = $this->input->post('store_id');
        $this->db->select('s.sama_depname, s.sama_username, s.sama_billdatebs, s.sama_billdatead, s.sama_invoiceno, sd.sade_qty,sd.sade_unitrate,it.itli_itemname, (sd.sade_unitrate * sd.sade_qty)as amount, s.sama_totalamount');
		$this->db->from('sama_salemaster s');
		$this->db->join('sade_saledetail sd', 'sd.sade_salemasterid = s.sama_salemasterid');
		$this->db->join('itli_itemslist it', 'it.itli_itemlistid = sd.sade_itemsid', "LEFT");
		$this->db->where('s.sama_st', "N");
		$this->db->where('s.sama_depid !=',0);
		if($fromdate &&  $todate){
	        if(DEFAULT_DATEPICKER=='NP')
	        {
	          $this->db->where('s.sama_billdatebs >=', $fromdate);
	          $this->db->where('s.sama_billdatebs <=', $todate);
	        }
	        else
	        {
	          $this->db->where('s.sama_billdatebs >=', $fromdate);
	          $this->db->where('s.sama_billdatebs <=', $todate);
	        }
	    }
	    if($storeid)
	    {
	    	$this->db->where('s.sama_storeid',$storeid);
	    }
	    if($username){
	    	$this->db->where('s.sama_username',$username);
	    }
        if($srchcol)
        {
         	$this->db->where($srchcol); 
        }
        $this->db->group_by('sama_depname, sama_invoiceno');
        $this->db->order_by('sama_invoiceno, sama_depname','asc');
		$query = $this->db->get();
		// echo $this->db->last_query();die();
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();		
			return $data;		
		}		
		return false;
	}
	public function get_return_details_report($srchcol=false,$limit=false,$offset=false,$order=false,$order_by=false)
	{
		$fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
        $locationid=$this->input->post('locationid');
        $username = $this->input->post('userid');
        $storeid = $this->input->post('store_id');
		//print_r($this->input->post());die;
        $this->db->select('s.rema_returndatebs, s.rema_username, s.rema_returndatead, s.rema_invoiceno, s.rema_receiveno,s.rema_locationid, sd.rede_qty,sd.rede_total as returntotal,it.itli_itemname,(sd.rede_total)as sumamount,d.dept_depname');
		$this->db->from('rema_returnmaster s');
		$this->db->join('rede_returndetail sd', 'sd.rede_returnmasterid = s.rema_returnmasterid');
		$this->db->join('itli_itemslist it', 'it.itli_itemlistid = sd.rede_itemsid', "LEFT");
		$this->db->join('dept_department d','d.dept_depid = s.rema_depid');
		if($fromdate &&  $todate){
	        if(DEFAULT_DATEPICKER=='NP')
	        {
	          $this->db->where('s.rema_returndatebs >=', $fromdate);
	          $this->db->where('s.rema_returndatebs <=', $todate);
	        }
	        else
	        {
	          $this->db->where('s.rema_returndatebs >=', $fromdate);
	          $this->db->where('s.rema_returndatebs <=', $todate);
	        }
	    }
	    if($storeid)
	    {
	    	$this->db->where('sd.rede_storeid',$storeid);
	    }
	   
	    // if($locationid){

	    // 	$this->db->where('s.rema_locationid',$locationid);
	    // }
	    if($this->location_ismain=='Y'){
	    if($locationid){
	    	$this->db->where('s.rema_locationid',$locationid);
	    }}
	    else{
	    	$this->db->where('s.rema_locationid',$this->locationid);
	    }

	    if($username){
	    	$this->db->where('s.rema_username',$username);
	    }
        if($srchcol)
        {
         	$this->db->where($srchcol); 
        }
        $this->db->where('s.rema_st <>','C');
		$query = $this->db->get();
		// echo $this->db->last_query();die();
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();		
			return $data;		
		}		
		return false;
	}
	public function get_return_report($srchcol=false,$limit=false,$offset=false,$order=false,$order_by=false)
	{
		$fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
        $locationid=$this->input->post('locationid');
        $storeid = $this->input->post('store_id');
        $username = $this->input->post('userid');
        
       // $this->db->select('s.*, sd.*,it.itli_itemname, n.maty_material, (sd.sade_unitrate * sd.sade_qty)as amount');
        $this->db->select('s.rema_returndatebs, sd.rede_qty ,it.itli_itemname,  dep.dept_depname, s.rema_invoiceno as issueno,sd.rede_total as returntotal');
		$this->db->from('rema_returnmaster s');
		$this->db->join('rede_returndetail sd', 'sd.rede_returnmasterid = s.rema_returnmasterid',"LEFT");
		$this->db->join('itli_itemslist it', 'it.itli_itemlistid = sd.rede_itemsid', "LEFT");
		$this->db->join('dept_department dep', 'dep.dept_depid = s.rema_depid', "LEFT");
		if($fromdate && $todate){
	        if(DEFAULT_DATEPICKER=='NP')
	        {
	          $this->db->where('s.rema_returndatebs >=', $fromdate);
	          $this->db->where('s.rema_returndatebs <=', $todate);
	        }
	        else
	        {
	          $this->db->where('s.rema_returndatead >=', $fromdate);
	          $this->db->where('s.rema_returndatead <=', $todate);
	        }
	    }

	    if($storeid){
	    	$this->db->where('s.rema_storeid',$storeid);
	    }
	    if($locationid){

	    	$this->db->where('s.rema_locationid',$locationid);
	    }
	    if($username){
	    	$this->db->where('s.rema_username',$username);
	    }
        if($srchcol)
        {
         	$this->db->where($srchcol); 
        }
		$query = $this->db->get();
		// echo $this->db->last_query();die();
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();		
			return $data;		
		}		
		return false;
	}
	public function get_item_wise_report($srchcol=false,$limit=false,$offset=false,$order=false,$order_by=false)
	{
		// echo "<pre>";
		// print_r($this->input->post()); die;
		$fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
        $locationid=$this->input->post('locationid');
        $store_id = $this->input->post('store_id');

        $itemid=$this->input->post('itemid');

    	$aitem = $this->input->post('aitem');
      	$allitem = $this->input->post('allitem');
      	//$itmlist = $this->input->post('itli_itemlistid');
      	$allstore = $this->input->post('allstore');
      	//$st_store_id = $this->input->post('st_store_id');
        $issuefrequent = $this->input->post('is_summary')?$this->input->post('is_summary'):$this->input->post('issueitem');

	     // 	$this->data['item'] = $itmlist;

        $this->db->select('it.itli_itemname, it.itli_itemcode, eq.eqty_equipmenttype as storename, s.sama_depname,sama_billdatebs,sama_billno,sama_invoiceno, (SUM(sd.sade_unitrate * sd.sade_qty) /SUM(sade_qty)) sade_unitrate ,SUM(sade_qty)sade_qty ,sade_unitrate as unitrate,SUM(sd.sade_unitrate * sd.sade_qty) as amount');
		$this->db->from('sama_salemaster s');
		$this->db->join('sade_saledetail sd', 'sd.sade_salemasterid = s.sama_salemasterid','LEFT');
		$this->db->join('itli_itemslist it', 'it.itli_itemlistid = sd.sade_itemsid', "LEFT");
		$this->db->join('eqty_equipmenttype eq', 'eq.eqty_equipmenttypeid = s.sama_storeid', "LEFT");
		if($fromdate &&  $todate){
	        if(DEFAULT_DATEPICKER=='NP')
	        {
	          $this->db->where('s.sama_billdatebs >=', $fromdate);
	          $this->db->where('s.sama_billdatebs <=', $todate);
	        }
	        else
	        {
	          $this->db->where('s.sama_billdatebs >=', $fromdate);
	          $this->db->where('s.sama_billdatebs <=', $todate);
	        }
	    }

	    if($srchcol)
        {
         	$this->db->where($srchcol); 
        }
        if($locationid)
        {
         	$this->db->where('s.sama_locationid',$locationid); 
        }

	    if($aitem)
  		{
  			$this->db->where('it.itli_itemlistid',$aitem);
  		}
      	if($allitem)
      	{  
      		$this->db->where('it.itli_itemlistid',$allitem);
      	}
      	if($itemid)
      	{
      		$this->db->where('it.itli_itemlistid',$itemid);
         	
      	}
      	if($store_id)
      	{
      		$this->db->where('s.sama_storeid',$store_id);
      	}

      	if($issuefrequent){
      		$this->db->where(array('s.sama_st '=>'N','s.sama_status'=>'O'));
      		$this->db->group_by('sd.sade_itemsid');
      		$this->db->order_by('it.itli_itemname');
      	}else{
      		$this->db->group_by('sd.sade_itemsid, s.sama_depid');
      		$this->db->order_by('s.sama_billdatebs');
      	}

		$query = $this->db->get();
		// echo $this->db->last_query();die();
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();		
			return $data;		
		}		
		return false;
	}


	public function get_itemwise_detail_issue_report($srchcol=false,$limit=false,$offset=false,$order_by=false,$order='ASC',$is_distinct=false){
		// echo "<pre>";
		// print_r($this->input->post()); die;
		$fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
        $locationid=$this->input->post('locationid');
        $store_id = $this->input->post('store_id');

        $itemid=$this->input->post('itemid');

    	$aitem = $this->input->post('aitem');
      	$allitem = $this->input->post('allitem');
      	//$itmlist = $this->input->post('itli_itemlistid');
      	$allstore = $this->input->post('allstore');
      	//$st_store_id = $this->input->post('st_store_id');
        $issuefrequent = $this->input->post('is_summary')?$this->input->post('is_summary'):$this->input->post('issueitem');
        $this->db->select('
					    sd.sade_itemsid,
						it.itli_itemname,
						it.itli_itemcode,
						eq.eqty_equipmenttype AS storename,
						dp.dept_depname sama_depname,
						sama_billdatead,	
						sama_billdatebs,
						sama_invoiceno,
						 sama_receivedby,
						 sama_requisitionno reqno,
						SUM(sade_curqty) sade_curqty,
						sade_unitrate AS unitrate,
						(SUM(sd.sade_curqty)*sd.sade_unitrate)
						 amount,sd.sade_remarks');
		$this->db->from('sama_salemaster s');
		$this->db->join('sade_saledetail sd', 'sd.sade_salemasterid = s.sama_salemasterid','LEFT');
		$this->db->join('itli_itemslist it', 'it.itli_itemlistid = sd.sade_itemsid', "LEFT");
		$this->db->join('eqty_equipmenttype eq', 'eq.eqty_equipmenttypeid = s.sama_storeid', "LEFT");
		$this->db->join('dept_department dp', 'dp.dept_depid=s.sama_depid', "LEFT");
		if($fromdate &&  $todate){
	        if(DEFAULT_DATEPICKER=='NP')
	        {
	          $this->db->where('s.sama_billdatebs >=', $fromdate);
	          $this->db->where('s.sama_billdatebs <=', $todate);
	        }
	        else
	        {
	          $this->db->where('s.sama_billdatebs >=', $fromdate);
	          $this->db->where('s.sama_billdatebs <=', $todate);
	        }
	    }

	    if($srchcol)
        {
         	$this->db->where($srchcol); 
        }
        if($this->location_ismain=='Y'){
        	if($locationid)
        {
         	$this->db->where('s.sama_locationid',$locationid); 
        }
        }
        else{
        	$this->db->where('s.sama_locationid',$this->locationid); 

        }

	    if($aitem)
  		{
  			$this->db->where('it.itli_itemlistid',$aitem);
  		}
      	if($allitem)
      	{  
      		$this->db->where('it.itli_itemlistid',$allitem);
      	}
      	if($itemid)
      	{
      		$this->db->where('it.itli_itemlistid',$itemid);
         	
      	}
      	if($store_id)
      	{
      		$this->db->where('s.sama_storeid',$store_id);
      	}

      	$this->db->where(array('s.sama_st'=>'N','s.sama_status'=>'O'));
  		$this->db->group_by('sd.sade_itemsid,
							s.sama_storeid,
							s.sama_depid,
							sd.sade_unitrate');
  		if($order_by)
  		{
  			$this->db->order_by($order_by,$order);
  		}
  	
      	

		$query = $this->db->get();
		// echo $query;die();
		$last_qry= $this->db->last_query();
		if($is_distinct)
		{
			$new_qry=$this->db->query("SELECT DISTINCT(sade_itemsid),itli_itemname,itli_itemcode FROM( $last_qry )X")->result();
			return $new_qry;
		}
		else
		{
			if ($query->num_rows() > 0) 
			{
				$data=$query->result();		
				return $data;		
			}		
		}
		
		return false;
	}

	public function get_issuebook_result($srchcol=false,$limit=false,$offset=false,$order=false,$order_by=false)
	{   
		$fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
        $locationid=$this->input->post('locationid');
        //$comprehensive = $this->input->post('comprehensive');
        $st_store_id = $this->input->post('store_id');
        
        $this->db->select('s.sama_invoiceno,s.sama_billdatebs,s.sama_billno,it.itli_itemname,SUM(sd.sade_unitrate * sd.sade_qty)as amount,dep.dept_depname, eq.eqty_equipmenttype as storename');
		$this->db->from('sama_salemaster s');
		$this->db->join('sade_saledetail sd', 'sd.sade_salemasterid = s.sama_salemasterid','LEFT');
		$this->db->join('itli_itemslist it', 'it.itli_itemlistid = sd.sade_itemsid', "LEFT");
		$this->db->join('dept_department dep', 'dep.dept_depid = s.sama_depid', "LEFT");
		$this->db->join('eqty_equipmenttype eq', 'eq.eqty_equipmenttypeid = s.sama_storeid', "LEFT");
		$this->db->group_by('s.sama_depname, s.sama_invoiceno,s.sama_billdatebs'); 
		
		if($fromdate &&  $todate){
	        if(DEFAULT_DATEPICKER=='NP')
	        {
	          $this->db->where('s.sama_billdatebs >=', $fromdate);
	          $this->db->where('s.sama_billdatebs <=', $todate);
	        }
	        else
	        {
	          $this->db->where('s.sama_billdatebs >=', $fromdate);
	          $this->db->where('s.sama_billdatebs <=', $todate);
	        }
	    }
	    if($this->location_ismain=='Y'){
	    if($locationid)
        {
         	$this->db->where('s.sama_locationid',$locationid); 
        }}else{
         	$this->db->where('s.sama_locationid',$this->locationid); 

        }
        
	    if($st_store_id)
      	{
      		$this->db->where('s.sama_storeid',$st_store_id);
         	
      	}

	    $this->db->where('sama_depid !=',0);

        if($srchcol)
        {
         	$this->db->where($srchcol); 
        }
        $this->db->order_by('sama_invoiceno, dept_depname','asc');
		$query = $this->db->get();
		// echo $this->db->last_query();die();
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();		
			return $data;		
		}		
		return false;
	}
	public function get_issue_wise_deails($srchcol=false)
	{
		$fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
         $locationid = $this->input->post('locationid');
        $this->db->select('s.*,(s.sade_unitrate * s.sade_qty) as amount, it.itli_itemname, it.itli_itemcode');
		$this->db->from('sade_saledetail s');
		$this->db->join('itli_itemslist it', 'it.itli_itemlistid = s.sade_itemsid', "LEFT");
		//echo"correct"; die;
				// if($fromdate &&  $todate){
			 //        if(DEFAULT_DATEPICKER=='NP')
			 //        {
			 //          $this->db->where('s.sade_billdate >=', $fromdate);
			 //          $this->db->where('s.sade_billdate <=', $todate);
			 //        }
			 //        else
			 //        {
			 //          $this->db->where('s.sade_billdate >=', $fromdate);
			 //          $this->db->where('s.sade_billdate <=', $todate);
			 //        }
			 //    }
	    //print_r($srchcol);die;
        if($srchcol)
        {
         	$this->db->where($srchcol); 
        }
	    if($this->location_ismain=='Y'){

        if($locationid){

	    	$this->db->where('s.sade_locationid',$locationid);
	    }}else{
	    	$this->db->where('s.sade_locationid',$this->locationid);

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

	public function get_issuebook($srchcol=false,$limit=false,$offset=false,$order=false,$order_by=false)
	{
		$fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
        $issuefrequent = $this->input->post('issueitem');
        $store_id=$this->input->post('store_id');
        $this->db->select('s.sama_invoiceno,s.sama_billdatebs,s.sama_salemasterid,s.sama_billno, s. sama_username, sama_billtime,dep.dept_depname,et.eqty_equipmenttype');
		$this->db->from('sama_salemaster s');
		$this->db->join('dept_department dep', 'dep.dept_depid = s.sama_depid', "LEFT");
		$this->db->join('eqty_equipmenttype et','et.eqty_equipmenttypeid = s.sama_storeid','LEFT');
		//$this->db->group_by('s.sama_depname, s.sama_invoiceno,s.sama_billdatebs'); 
		
		if($fromdate &&  $todate){
	        if(DEFAULT_DATEPICKER=='NP')
	        {
	          $this->db->where('s.sama_billdatebs >=', $fromdate);
	          $this->db->where('s.sama_billdatebs <=', $todate);
	        }
	        else
	        {
	          $this->db->where('s.sama_billdatebs >=', $fromdate);
	          $this->db->where('s.sama_billdatebs <=', $todate);
	        }
	    }
	    if($store_id){
	    	$this->db->where('s.sama_storeid',$store_id);
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
	public function get_issue_value_report($srchcol=false,$limit=false,$offset=false,$order=false,$order_by=false)
	{
		$fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
        $locationid=$this->input->post('locationid');
        $storeid = $this->input->post('store_id');
        $username = $this->input->post('userid');
        // print_r($this->input->post());die;
        // print_r($fromdate);
        // print_r($todate);die;
        $this->db->select('s.sama_duedatebs,s.sama_invoiceno, s.sama_depname, s.sama_totalamount');
		$this->db->from('sama_salemaster s');
		$this->db->where('s.sama_st','N');
		if($fromdate &&  $todate){
	        if(DEFAULT_DATEPICKER=='NP')
	        {
	          $this->db->where('s.sama_duedatebs >=', $fromdate);
	          $this->db->where('s.sama_duedatebs <=', $todate);
	        }
	        else
	        {
	          $this->db->where('s.sama_duedatebs >=', $fromdate);
	          $this->db->where('s.sama_duedatebs <=', $todate);
	        }
	    }
	    if($storeid){
	    	$this->db->where('s.sama_storeid',$storeid);
	    }
	    if($this->location_ismain=='Y'){
	    if($locationid){
	    	$this->db->where('s.sama_locationid',$locationid);
	    }}
	    else{
	    	$this->db->where('s.sama_locationid',$this->locationid);

	    }
	    if($username){
	    	$this->db->where('s.sama_username',$username);
	    }
        if($srchcol)
        {
         	$this->db->where($srchcol); 
        }
		$query = $this->db->get();
		// echo $this->db->last_query();die();
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();		
			return $data;		
		}		
		return false;

	}
	// public function get_issuebook_total($srchcol=false,$limit=false,$offset=false,$order=false,$order_by=false)
		// {   
			// 	$fromdate = $this->input->post('fromdate');
		 //        $todate = $this->input->post('todate');
		 //        $issuefrequent = $this->input->post('issueitem');
		 //        $this->db->select('s.*, sd.*,it.itli_itemname,(sd.sade_unitrate * sd.sade_qty)as amount,dep.dept_depname, SUM(s.sama_totalamount) as gtotal');
			// 	$this->db->from('sama_salemaster s');
			// 	$this->db->join('sade_saledetail sd', 'sd.sade_salemasterid = s.sama_salemasterid');
			// 	$this->db->join('itli_itemslist it', 'it.itli_itemlistid = sd.sade_itemsid', "LEFT");
			// 	$this->db->join('dept_department dep', 'dep.dept_depid = s.sama_stdepid', "LEFT");
			// 	$this->db->group_by('s.sama_user_name, s.sama_invoiceno,s.sama_billdatebs'); 
			// 	if($fromdate &&  $todate){
			//         if(DEFAULT_DATEPICKER=='NP')
			//         {
			//           $this->db->where('s.sama_billdatebs >=', $fromdate);
			//           $this->db->where('s.sama_billdatebs <=', $todate);
			//         }
			//         else
			//         {
			//           $this->db->where('s.sama_billdatebs >=', $fromdate);
			//           $this->db->where('s.sama_billdatebs <=', $todate);
			//         }
			//     }
		 //        if($srchcol)
		 //        {
		 //         	$this->db->where($srchcol); 
		 //        }
			// 	$query = $this->db->get();
			// 	//echo $this->db->last_query();die();
			// 	if ($query->num_rows() > 0) 
			// 	{
			// 		$data=$query->result();		
			// 		return $data;		
			// 	}		
			// 	return false;
	// }

	public function issue_summary_report(){
		$fromdate = $this->input->post('fromdate');
		$todate = $this->input->post('todate');
		$storeid = $this->input->post('st_store_id');

		$where_sama_storeid = $where_rema_storeid = "";
      	if($storeid){
      		$where_sama_storeid = 'AND sm.sama_storeid = "'.$storeid.'" ';
      		$where_rema_storeid = 'AND rm.rema_storeid = "'.$storeid.'" ';
      	}


		$sql = "select sum(x.issuetotal) as total_issue, sum(x.returntotal) as total_return from (select sum(sm.sama_totalamount) as issuetotal, 0 as returntotal from xw_sama_salemaster sm where sm.sama_st = 'N' $where_sama_storeid AND sm.sama_billdatebs between '$fromdate' and '$todate' UNION select 0 as issuetotal, sum(rm.rema_amount) as returntotal from xw_rema_returnmaster rm where rm.rema_returndatebs between '$fromdate' and '$todate' $where_rema_storeid) x";

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

