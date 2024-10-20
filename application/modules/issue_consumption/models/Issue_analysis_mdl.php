<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Issue_analysis_mdl extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
		//$this->table='eqli_equipmentlist';
		 $this->locationid=$this->session->userdata(LOCATION_ID);
        $this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
	}

	public function get_issue_analysis_report($srchcol=false,$limit=false,$offset=false,$order=false,$order_by=false)
	{ 	
		$summary = $this->input->post('summary');
      	$item = $this->input->post('item');
      	$storeid = $this->input->post('store_id');
		$fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
        $locationid = $this->input->post('locationid');
        $depid = $this->input->post('depid');
      	$materialtypeid = $this->input->post('maty_materialtypeid');
      	$catid = $this->input->post('catid');
       	
       	$where_sama_date = $where_rema_date = $where_sama_location = $where_rema_location = $where_sama_store = $where_rema_store = $where_sama_department = $where_rema_department = $where_materialtype = $where_category = "";
       	if(DEFAULT_DATEPICKER == 'NP'){
       		$where_sama_date = "AND sama_billdatebs >= '$fromdate' AND sama_billdatebs <= '$todate'";
       		$where_rema_date = "AND rema_returndatebs >= '$fromdate' AND rema_returndatebs <= '$todate'";
       	}else{
       		$where_sama_date = "AND sama_billdatead >= '$fromdate' AND sama_billdatead <= '$todate'";
       		$where_rema_date = "AND rema_returndatead >= '$fromdate' AND rema_returndatead <= '$todate'";
       	}

       	// if($locationid){
       	// 	$where_sama_location = "AND sama_locationid = $locationid";
       	// 	$where_rema_location = "AND rema_locationid = $locationid";
       	// }
	       	if($this->location_ismain){
	       		if(!empty($locationid)){
	       			$where_sama_location = "AND sama_locationid = $locationid";
	       		    $where_rema_location = "AND rema_locationid = $locationid";

	       		}

	       	}else{
	       		$where_sama_location = "AND sama_locationid = $this->locationid";
	       		$where_rema_location = "AND rema_locationid = $this->locationid";

	       	}

       	if($storeid){
       		$where_sama_store = "AND sama_storeid = $storeid";
       		$where_rema_store = "AND rema_storeid = $storeid";
       	}

       	if($depid){
       		$where_sama_department = "AND sama_depid = $depid";
       		$where_rema_department = "AND rema_depid = $depid";
       	}
        
        if($materialtypeid){
        	$where_materialtype = "AND itli_materialtypeid = $materialtypeid";
        }

        if($catid){
        	$where_category = "AND itli_catid = $catid";
        }

        $sql1 ="
        SELECT Y.depid,dp.dept_depcode, dp.dept_depname, SUM(consumptionamt) consumption,SUM(assets) assets FROM (
			SELECT depid,itemid,SUM(issueamount-returnamount) consumptionamt, 0 as assets
			FROM(
				SELECT sm.sama_depid depid,sd.sade_itemsid itemid, SUM(sade_qty) as issueqty,SUM(sade_qty*sade_unitrate) as issueamount,0 returnqty,0 returnamount  
				FROM xw_sama_salemaster sm
				LEFT JOIN xw_sade_saledetail sd ON 
								sd.sade_salemasterid = sm.sama_salemasterid
				WHERE sm.sama_st<>'C'
				AND sama_status ='O'
				$where_sama_date $where_sama_location $where_sama_store $where_sama_department
				GROUP BY sama_depid,sd.sade_itemsid
				UNION
				SELECT rm.rema_depid depid,rd.rede_itemsid itemid,0 issueqty, 0 issueamount, rede_qty returnqty,SUM(rede_qty*rede_unitprice)  as returnamount 
				from xw_rema_returnmaster rm 
				LEFT JOIN xw_rede_returndetail rd on rd.rede_returnmasterid=rm.rema_returnmasterid
				WHERE rm.rema_st<>'C'  
				$where_rema_date $where_rema_location $where_rema_store $where_rema_department
				GROUP BY rema_depid,rd.rede_itemsid
			) X 
			LEFT JOIN xw_itli_itemslist il ON il.itli_itemlistid = X.itemid
			WHERE il.itli_materialtypeid=1 $where_category
			GROUP BY depid,itemid
			UNION
			SELECT depid,itemid,0 consumptionamt, SUM(issueamount-returnamount) assets
			FROM(
				SELECT sm.sama_depid depid,sd.sade_itemsid itemid, SUM(sade_qty) as issueqty,SUM(sade_qty*sade_unitrate) as issueamount,0 returnqty,0 returnamount  FROM xw_sama_salemaster sm
				LEFT JOIN xw_sade_saledetail sd ON sd.sade_salemasterid = sm.sama_salemasterid
				WHERE sm.sama_st<>'C'
				AND sama_status ='O'
				$where_sama_date $where_sama_location $where_sama_store $where_sama_department
				GROUP BY sama_depid,sd.sade_itemsid
				UNION
				SELECT rm.rema_depid depid,rd.rede_itemsid itemid,0 issueqty, 0 issueamount, rede_qty returnqty,SUM(rede_qty*rede_unitprice)  as returnamount from xw_rema_returnmaster rm 
				LEFT JOIN xw_rede_returndetail rd on rd.rede_returnmasterid=rm.rema_returnmasterid
				WHERE rm.rema_st<>'C'  
				$where_rema_date $where_rema_location $where_rema_store $where_rema_department
				GROUP BY rema_depid,rd.rede_itemsid
			) X 
			LEFT JOIN xw_itli_itemslist il ON il.itli_itemlistid = X.itemid
			WHERE il.itli_materialtypeid=2 $where_category
			GROUP BY depid,itemid
		) Y 
		inner join xw_dept_department dp on dp.dept_depid=Y.depid GROUP BY depid,dp.dept_depcode, dp.dept_depname";
			
		$query=$this->db->query($sql1);
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

	public function get_issue_analysis_department($srchcol=false, $exp=false)
	{
		$fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
        $locationid = $this->input->post('locationid');
        if($exp == 2)
        {
        	$expendiable  = 'AND itli_materialtypeid = '.$exp.'';
        }else{
        	$expendiable  = 'AND itli_materialtypeid = "1"';
        }
        $loc='';
        if($this->location_ismain=='Y'){
        	if(!empty($locationid)){
        		$loc="AND itli_locationid=$locationid";
        	}

        }
        else{
        	$loc="AND itli_locationid=$this->locationid";

        }
		$sql="SELECT
				dept_depname,
				dept_depcode,
				dept_depid,
				maty_material,
				itli_materialtypeid,
				itli_locationid,
				SUM(total) AS issueval,
				SUM(ReturnValue) AS returnvalue,
				SUM(total - ReturnValue) AS netvalue,
				billdate
			FROM
				(
					SELECT
						mt.maty_material,
						d.dept_depid,
						il.itli_materialtypeid,
						il.itli_locationid,
						d.dept_depname,
						d.dept_depcode,
						sum(sd.sade_qty * sd.sade_unitrate) AS total,
						0 AS ReturnValue,
						sm.sama_billdatebs billdate
					FROM
						xw_dept_department d
					LEFT JOIN xw_sama_salemaster sm ON sm.sama_depid = d.dept_depid
					LEFT JOIN xw_sade_saledetail sd ON sd.sade_salemasterid = sm.sama_salemasterid
					LEFT JOIN xw_itli_itemslist il ON il.itli_itemlistid = sd.sade_itemsid
					LEFT JOIN xw_maty_materialtype mt ON mt.maty_materialtypeid = il.itli_materialtypeid
					WHERE
						sm.sama_st = 'N'
					AND sama_billdatebs BETWEEN '$fromdate' and '$todate'
					GROUP BY
						d.dept_depcode,
						d.dept_depname,
						d.dept_depid,
						il.itli_materialtypeid,
						il.itli_locationid,
						mt.maty_material
					UNION
						SELECT
							mt.maty_material,
							d.dept_depid,
							il.itli_materialtypeid,
							il.itli_locationid,
							d.dept_depname,
							d.dept_depcode,
							0 AS total,
							sum(rd.rede_total) AS ReturnValue,
							rm.rema_returndatebs billdate
						FROM
							xw_dept_department d
						LEFT JOIN xw_rema_returnmaster rm ON rm.rema_depid = d.dept_depid
						LEFT JOIN xw_rede_returndetail rd ON rd.rede_returnmasterid = rm.rema_returnmasterid
						LEFT JOIN xw_itli_itemslist il ON il.itli_itemlistid = rd.rede_itemsid
						LEFT JOIN xw_maty_materialtype mt ON mt.maty_materialtypeid = il.itli_materialtypeid
						WHERE
							rm.rema_st = 'N'
						AND rm.rema_returndatebs BETWEEN '$fromdate' and '$todate'
						GROUP BY
							d.dept_depcode,
							d.dept_depname,
							il.itli_materialtypeid,
							il.itli_locationid,
							d.dept_depid,
							mt.maty_material
				) X
				WHERE billdate BETWEEN '$fromdate' and '$todate' $expendiable $srchcol $loc
			GROUP BY
				X.dept_depcode,
				X.dept_depname,
				X.itli_materialtypeid,
				X.itli_locationid,
				X.dept_depid,
				X.maty_material";

	    $query=$this->db->query($sql);
		// echo $this->db->last_query();die;		
		if($query->num_rows() > 0) 
		{
			$data=$query->result();		
			return $data;		
		}		
		return false;
	}
	public function issue_item_wise_data($srchcol=false,$dist=false)
	{	
		$fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
        $locationid = $this->input->post('locationid');
        $store_id=$this->input->post('store_id');
        $cond_ret='';
        $cond_iss='';
        $cond_other='';
        // if($locationid)
        // {
        // 	$cond_iss .=" AND sama_locationid=$locationid ";
        // 	$cond_ret .= "AND rema_locationid=$locationid ";

        // }
        if($this->location_ismain=='Y'){
        	if(!empty($locationid)){
        		$cond_iss .=" AND sama_locationid=$locationid ";
        	    $cond_ret .= "AND rema_locationid=$locationid ";

        	}
        }else{
        	    $cond_iss .=" AND sama_locationid=$this->locationid ";
        	    $cond_ret .= "AND rema_locationid=$this->locationid ";

        }
        if($store_id)
        {
        	$cond_iss .=" AND sama_storeid =$store_id ";
        	$cond_ret .= "AND rema_storeid=$store_id ";
        }

        

        if($dist=='dist')
        {
         $dis_sqlst="SELECT DISTINCT(dept_depname) dept_depname ,dept_depid from(";
         $dis_sqlen=")X ";
        }
       else
       {
       	$dis_sqlst='';
       	$dis_sqlen='';
       }

       $sql ="$dis_sqlst SELECT 
				itli_itemlistid,
				itli_itemname,
				itli_itemcode,
				maty_material maty_material,
				dept_depid,
				itli_materialtypeid,
				dept_depcode,
				dept_depname,
				SUM(issueqty) AS issqty,
				SUM(unitrate) unitrate,
				SUM(issamount) AS issamount,
				SUM(returnqty) AS returnqty,
				SUM(retrate) as retrate,
				SUM(returnqty*retrate) AS returnamount,
				SUM(issamount - returnnamount) AS netvalue,
				unit_unitname
			FROM
				(
					SELECT
						il.itli_itemlistid,
						il.itli_itemcode,
						il.itli_itemname,
							mt.maty_material,
							il.itli_materialtypeid,
						u.unit_unitname,
						d.dept_depid,
						d.dept_depcode,
						d.dept_depname,
						SUM(sd.sade_qty) AS issueqty,
						sd.sade_unitrate AS unitrate,
						(
							SUM(sd.sade_qty) * sd.sade_unitrate
						) issamount,
						0 AS returnqty,
						0 as retrate,
						0 AS returnnamount,
						sm.sama_billdatebs AS billdate
					FROM
						xw_dept_department d
					LEFT JOIN xw_sama_salemaster sm ON sm.sama_depid = d.dept_depid
					LEFT JOIN xw_sade_saledetail sd ON sd.sade_salemasterid = sm.sama_salemasterid
					INNER JOIN xw_itli_itemslist il ON il.itli_itemlistid = sd.sade_itemsid
					LEFT JOIN xw_maty_materialtype mt ON mt.maty_materialtypeid = il.itli_materialtypeid
					LEFT JOIN xw_unit_unit u ON u.unit_unitid = il.itli_unitid
					WHERE
						sm.sama_st = 'N' $cond_iss
					AND sm.sama_billdatebs BETWEEN  '$fromdate' and '$todate' $srchcol
					GROUP BY
						il.itli_itemlistid,
						il.itli_itemcode,
						il.itli_itemname,
						il.itli_materialtypeid,
						mt.maty_material,
						u.unit_unitname,
						d.dept_depid,
						d.dept_depcode,
						d.dept_depname,
					  sd.sade_unitrate
					UNION
						SELECT
						  il.itli_itemlistid,
							il.itli_itemcode,
							il.itli_itemname,
							mt.maty_material,
							il.itli_materialtypeid,
							u.unit_unitname,
							d.dept_depid,
							d.dept_depcode,
							d.dept_depname,
							0 AS issueqty,
							0 as unitrate,
							0 AS issueamount,
							SUM(rd.rede_qty) AS returnqty,
							rd.rede_unitprice AS retrate,
							(SUM(rd.rede_qty)*rd.rede_unitprice) AS returnnamount,
							rm.rema_returndatebs AS billdate
						FROM
							xw_rede_returndetail rd
						JOIN xw_rema_returnmaster rm ON rm.rema_returnmasterid = rd.rede_returnmasterid
						INNER JOIN xw_itli_itemslist il ON il.itli_itemlistid = rd.rede_itemsid
						LEFT JOIN xw_maty_materialtype mt ON mt.maty_materialtypeid = il.itli_materialtypeid
						LEFT JOIN xw_dept_department d ON d.dept_depid = rm.rema_depid
						LEFT JOIN xw_unit_unit u ON u.unit_unitid = il.itli_unitid
						WHERE
							rm.rema_st = 'N'
							$cond_ret 
						AND rm.rema_returndatebs BETWEEN  '$fromdate' and '$todate' $srchcol
						GROUP BY
							il.itli_itemlistid,
							il.itli_itemcode,
							il.itli_itemname,
							mt.maty_material,
							il.itli_materialtypeid,
							u.unit_unitname,
							d.dept_depid,
							d.dept_depcode,
							d.dept_depname,
							rd.rede_unitprice
				) p
			WHERE
				billdate BETWEEN '$fromdate' and '$todate' 
			GROUP BY
				p.itli_itemlistid,
				p.itli_itemname,
				p.itli_itemcode,
				p.maty_material,
				p.dept_depid,
				p.dept_depcode,
				p.dept_depname,
				p.itli_materialtypeid $dis_sqlen" ;
		$query=$this->db->query($sql);
		if($query->num_rows() > 0) 
		{
			$data=$query->result();		
			return $data;		
		}		
		return false;
	}

	public function get_issue_analysis_itemwise($srchcol=false)
	{   
		// $fromdate = $this->input->post('fromdate');
		  //       $todate = $this->input->post('todate');
		 //        SELECT
			// 		IL.ItemsID,
			// 		IL.ItemsName,
			// 		IL.ItemsCode,
			// 		Mt.TypeName,
			// 		D .DepId,
			// 		IL.TypeAid,
			// 		D .DepCode,
			// 		D .DepName,
			// 		SUM (SD.Qty) IssQty,
			// 		SUM (SD.Qty * SD.UnitRate) IssAmount,
			// 		0 AS RuturnQty,
			// 		0 AS ReturnAmount
		// 	FROM
			// 		Department D,
			// 		SaleMaster SM,
			// 		ItemsList IL,
			// 		SaleDetail SD,
			// 		MaterialType Mt
			// 	WHERE
			// 		D .DepId = SM.CustomerID
			// 	AND SM.st = 'N'
			// 	AND MT.TypeID = Il.TypeAID
			// 	AND SM.SalemasterID = SD.SaleMasterID
			// 	AND SD.ItemsID = IL.ItemsID
			// --	AND Sm.BillDate BETWEEN : FromDate AND : ToDate
			// 	GROUP BY
			// 		IL.ItemsID,
			// 		IL.ItemsName,
			// 		IL.ItemsCode,
			// 		D .Depcode,
			// 		D .DepName,
			// 		D .DepId,
			// 		Il.TypeAId,
			// 		Mt.TypeName
	    //       $this->db->select('IL.ItemsID,IL.ItemsName,IL.ItemsCode,Mt.TypeName,D .DepId,IL.TypeAid,D .DepCode,D .DepName,SUM (SD.Qty) IssQty,SUM (SD.Qty * SD.UnitRate) IssAmount,0 AS RuturnQty,0 AS ReturnAmount');
		$this->db->select('it.itli_itemlistid,it.itli_itemname,it.itli_itemcode,d.dept_depid,it.itli_materialtypeid, d.dept_depcode, d.dept_depname, SUM(sd.sade_qty) issqty, SUM(sd.sade_qty * sd.sade_unitrate) isamount,0 AS returnqty, 0 AS returnamount)');
		// $this->db->from('dept_department d');
		// $this->db->join('sama_salemaster sm', 'sm.sama_depid = d.dep_id');
		$this->db->join('sade_saledetail sd', 'sd.sade_salemasterid = s.sama_salemasterid');
		$this->db->join('itli_itemslist it', 'it.itli_itemlistid = sd.sade_itemsid', "LEFT");
		$this->db->join('maty_materialtype mt', 'mt.sade_salemasterid = it.itli_materialtypeid');
		
		$this->db->where('sm.sama_st', 'N');
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

	public function issue_item_return_data()
	{
		$fromdate = $this->input->post('fromdate');
		//$fromdate = '2073/07/24';
        $todate = $this->input->post('todate');
        $locationid = $this->input->post('locationid');

        $this->db->select('d.dept_depname,mt.maty_material,it.itli_itemname,it.itli_itemcode,rm.rema_returndatebs,rd.rede_qty,rd.rede_unitprice,rm.rema_invoiceno,rm.rema_username, rd.rede_controlno,rm.rema_locationid');
		$this->db->from('rema_returnmaster rm');
		$this->db->join('rede_returndetail rd', 'rd.rede_returnmasterid = rm.rema_returnmasterid');
		$this->db->join('itli_itemslist it', 'it.itli_itemlistid = rd.rede_itemsid', "LEFT");
		$this->db->join('maty_materialtype mt', 'mt.maty_materialtypeid = it.itli_materialtypeid', "LEFT");
		$this->db->join('dept_department d', 'd.dept_depid = rm.rema_depid', "LEFT");
		if($fromdate &&  $todate) {
	        if(DEFAULT_DATEPICKER=='NP')
	        {
	          $this->db->where('rm.rema_returndatebs >=', $fromdate);
	          $this->db->where('rm.rema_returndatebs <=', $todate);
	        }
	        else
	        {
	          $this->db->where('rm.rema_returndatebs >=', $fromdate);
	          $this->db->where('rm.rema_returndatebs <=', $todate);
	        }
	    }
	    // if($locationid){

	    // 	$this->db->where('rm.rema_locationid',$locationid);
	    // }
	    if($this->location_ismain=='Y'){
	    	if(!empty($locationid)){
	    		$this->db->where('rm.rema_locationid',$locationid);

	    	}
	    }
	    else{
	    	$this->db->where('rm.rema_locationid',$this->locationid);

	    }
	    $this->db->where('rm.rema_st',"N");
	    //TYPENAME,CATEGORYNAME,ITEMSNAME
		$query = $this->db->get();
		// echo $this->db->last_query();die();
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();		
			return $data;		
		}		
		return false;
	}
	public function get_issue_consumption_report($srchcol=false,$limit=false,$offset=false,$order=false,$order_by=false)
	{
		$fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
        $this->db->select('s.sama_depname,s.sama_billdate, s.sama_invoiceno,sd.sade_expdate, sd.sade_qty,sd.sade_unitrate,it.itli_itemname, (sd.sade_unitrate * sd.sade_qty)as amount');
		$this->db->from('sama_salemaster s');
		$this->db->join('sade_saledetail sd', 'sd.sade_salemasterid = s.sama_salemasterid');
		$this->db->join('itli_itemslist it', 'it.itli_itemlistid = sd.sade_itemsid', "LEFT");
		$this->db->order_by('it.itli_itemname');
		if($fromdate &&  $todate){
	        if(DEFAULT_DATEPICKER=='NP')
	        {
	          //print_r($todate); echo"from date"; print_r($fromdate);die;
	          $this->db->where('s.sama_billdate >=', $fromdate);
	          $this->db->where('s.sama_billdate <=', $todate);
	        }
	        else
	        {

	          $this->db->where('s.sama_billdate >=', $fromdate);
	          $this->db->where('s.sama_billdate <=', $todate);
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

	public function get_current_stock_report($srchcol=false,$limit=false,$offset=false,$order=false,$order_by=false)
	{
		$fromdate = $this->input->post('frmDate');
        $todate = $this->input->post('toDate');
        //$this->db->select("sd.*, mt.maty_material,u.unit_unitname, it.itli_itemname,it.itli_itemcode, (sd.trde_issueqty * sd.trde_unitprice) as total,sd.trde_unitprice");
        $this->db->select("sd.*, mt.maty_material,u.unit_unitname, it.itli_itemname,it.itli_itemcode, 
	    		(
	    		CASE WHEN (sd.trde_batchno != '') THEN sd.trde_batchno ELSE sd.trde_controlno END ) batchno,(sd.trde_issueqty * sd.trde_unitprice) as total,sd.trde_unitprice");
		$this->db->from('trde_transactiondetail sd');
		$this->db->join('itli_itemslist it', 'it.itli_itemlistid = sd.trde_itemsid', "LEFT");
		$this->db->join('maty_materialtype mt', 'mt.maty_materialtypeid = sd.trde_itemcode', "LEFT");
		$this->db->join('unit_unit u', 'u.unit_unitid = sd.trde_unitprice', "LEFT");

		if($fromdate &&  $todate){
	        if(DEFAULT_DATEPICKER=='NP')
	        {
	          $this->db->where('sd.trde_expdate >=', $fromdate);
	          $this->db->where('sd.trde_expdate <=', $todate);
	        }
	        else
	        {
	          $this->db->where('sd.trde_expdate >=', $fromdate);
	          $this->db->where('sd.trde_expdate <=', $todate);
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

	public function search_issue_wise_department()
	{
		
	}
}