<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
ini_set('max_execution_time', 0); 
ini_set('memory_limit','2048M');


class Api_army extends CI_Controller {

	function __construct() {

		parent::__construct();
// 		$serverName = "SUJAN";  
// $connectionInfo = array( "Database"=>"inventory1","UID" => "sa", "PWD" => "xelwel");  
  
// /* Connect using Windows Authentication. */  
// $conn = sqlsrv_connect( $serverName, $connectionInfo);  
// if( $conn === false )  
// {  
// 	echo "<pre>";
//      echo "Unable to connect.</br>";  
//      die( print_r( sqlsrv_errors(), true));  
// } 
// else{
// 	echo "connect success";
// } 

		$this->db2=$this->load->database('inventory1',true);


		$this->locationid=4;
		$this->orgid=3;
		// die();
	}


	public function index()
	{
		// die();
		$api_rec=array(
			array(
			'api_name'=>'Truncate Old Table',
			'api_remarks'=>'Remove All Old Data',
			'api_url'=>''
			),
			array(
			'api_name'=>'Truncate Table',
			'api_remarks'=>'Remove All New Data',
			'api_url'=>''
			),
			array(
			'api_name'=>'Synch All Data ',
			'api_remarks'=>'From other Database',
			'api_url'=>''
			),
			array(
			'api_name'=>'Location Update',
			'api_remarks'=>'Set Location Id',
			'api_url'=>''
			),
			array(
			'api_name'=>'Category Manage',
			'api_remarks'=>'',
			'api_url'=>'/api/api_army/category_manage'
			),
			array(
			'api_name'=>'Unit Manage',
			'api_remarks'=>'',
			'api_url'=>'/api/api_army/unit_manage'
			),
			array(
			'api_name'=>'Item Manage',
			'api_remarks'=>'',
			'api_url'=>'/api/api_army/item_manage_rec'
			),
			array(
			'api_name'=>'Supplier Manage',
			'api_remarks'=>'',
			'api_url'=>'/api/api_army/supplier_manage'
			),
			array(
			'api_name'=>'Budget Manage',
			'api_remarks'=>'',
			'api_url'=>'/api/api_army/budget_manage'
			),
			array(
			'api_name'=>'Department Manage',
			'api_remarks'=>'',
			'api_url'=>'/api/api_army/department_manage'
			),

			array(
			'api_name'=>'Update Category and Unit on Item',
			'api_remarks'=>'',
			'api_url'=>'/api/api_army/update_category_unit_on_item'
			),
		
		array(
			'api_name'=>'Synch Data to Similar Table',
			'api_remarks'=>'',
			'api_url'=>'/api/api_army/synch_table'
			),
						

		);
	$this->data['api_rec']=$api_rec;
		// echo "<pre>";
		// print_r($this->data['api_rec']);
		// die();
		$seo_data='';
		if($seo_data)
		{
			//set SEO data
			$this->page_title = $seo_data->page_title;
			$this->data['meta_keys']= $seo_data->meta_key;
			$this->data['meta_desc']= $seo_data->meta_description;
		}
		else
		{
			//set SEO data
		    $this->page_title = ORGA_NAME;
		    $this->data['meta_keys']= ORGA_NAME;
		    $this->data['meta_desc']= ORGA_NAME;
		}

		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('api/api/v_api_army', $this->data);
	}


	public function truncate_old_table()
	{
		$this->db->query("TRUNCATE TABLE xw_itli_itemslist;");
		$this->db->query("TRUNCATE TABLE xw_unit_unit;");
		$this->db->query("TRUNCATE TABLE xw_eqca_equipmentcategory;");
		$this->db->query("TRUNCATE TABLE xw_budg_budgets;");
		$this->db->query("TRUNCATE TABLE xw_dept_department;");
		$this->db->query("TRUNCATE TABLE xw_dist_distributors;");
		$this->db->query("TRUNCATE TABLE xw_trde_transactiondetail;");
		$this->db->query("TRUNCATE TABLE xw_trma_transactionmain;");
		$this->db->query("TRUNCATE TABLE xw_pure_purchaserequisition;");
		$this->db->query("TRUNCATE TABLE xw_purd_purchasereqdetail;");
		$this->db->query("TRUNCATE TABLE xw_puor_purchaseordermaster;");
		$this->db->query("TRUNCATE TABLE xw_pude_purchaseorderdetail;");
		$this->db->query("TRUNCATE TABLE xw_purr_purchasereturn;");
		$this->db->query("TRUNCATE TABLE xw_prde_purchasereturndetail;");
		$this->db->query("TRUNCATE TABLE xw_recm_receivedmaster;");
		$this->db->query("TRUNCATE TABLE xw_recd_receiveddetail;");
		$this->db->query("TRUNCATE TABLE xw_rema_returnmaster;");
		$this->db->query("TRUNCATE TABLE xw_rede_returndetail;");
		$this->db->query("TRUNCATE TABLE xw_sama_salemaster;");
		$this->db->query("TRUNCATE TABLE xw_sade_saledetail;");
		
	}

	public function truncate_table_new()
	{
		$this->db->query("TRUNCATE TABLE xw_itli_itemslist_central");
		$this->db->query("TRUNCATE TABLE xw_unit_unit_central");
		$this->db->query("TRUNCATE TABLE xw_eqca_equipmentcategory_central");
		$this->db->query("TRUNCATE TABLE xw_budg_budgets_central");
		$this->db->query("TRUNCATE TABLE xw_dept_department_central");
		$this->db->query("TRUNCATE TABLE xw_dist_distributors_central");
		$this->db->query("TRUNCATE TABLE xw_trde_transactiondetail_central");
		$this->db->query("TRUNCATE TABLE xw_trma_transactionmain_central");
		$this->db->query("TRUNCATE TABLE xw_pure_purchaserequisition_central");
		$this->db->query("TRUNCATE TABLE xw_purd_purchasereqdetail_central");
		$this->db->query("TRUNCATE TABLE xw_puor_purchaseordermaster_central");
		$this->db->query("TRUNCATE TABLE xw_pude_purchaseorderdetail_central");
		$this->db->query("TRUNCATE TABLE xw_purr_purchasereturn_central");
		$this->db->query("TRUNCATE TABLE xw_prde_purchasereturndetail_central");
		$this->db->query("TRUNCATE TABLE xw_recm_receivedmaster_central");
		$this->db->query("TRUNCATE TABLE xw_recd_receiveddetail_central");
		$this->db->query("TRUNCATE TABLE xw_rema_returnmaster_central");
		$this->db->query("TRUNCATE TABLE xw_rede_returndetail_central");
		$this->db->query("TRUNCATE TABLE xw_sama_salemaster_central");
		$this->db->query("TRUNCATE TABLE xw_sade_saledetail_central");
		
	}

	public function custom_run_function()
	{
			// $this->items_rec();
			// $this->item_locationid_update();
			// $this->item_manage_rec();
		// $this->synch_similar_table_into_original_table('xw_recm_receivedmaster_central');
	}

	public function synch_all_table()
		{
			$this->items_rec();
			$this->unit_rec();
			$this->item_category_rec();
			$this->supplier_rec();
			$this->department_rec();
			$this->budget_rec();
			$this->transaction_main_rec();
			$this->transaction_detail_rec();
			$this->purchase_requisition_master_rec();
			$this->purchase_requisition_detail_rec();
			$this->purchase_order_master_rec();
			$this->purchase_order_detail_rec();
			$this->purchase_received_master_rec();
			$this->purchase_received_detail_rec();
			$this->purchase_return_master_rec();
			$this->purchase_return_detail_rec();
			$this->issue_master_rec();
			$this->issue_detail_rec();
			$this->update_locationid();
		}

	public function update_locationid(){
	
		$this->item_locationid_update();
		$this->unit_locationid_update();
		$this->category_locationid_update();
		$this->supplier_locationid_update();
		$this->department_locationid_update();
		$this->budget_locationid_update();
		$this->transaction_main_locationid_update();
		$this->transaction_detail_locationid_update();
		$this->purchase_requisition_master_locationid_update();
		$this->purchase_requisition_detail_locationid_update();
		$this->purchase_order_master_locationid_update();
		$this->purchase_order_detail_locationid_update();
		$this->purchase_received_master_locationid_update();
		$this->purchase_received_detail_locationid_update();
		$this->purchase_return_master_locationid_update();
		$this->purchase_return_detail_locationid_update();
		$this->issue_master_locationid_update();
		$this->issue_detail_locationid_update();

	}

	

	public function items_rec()
	{
		$itemlist=$this->get_itemlistfromotherdb();
		// echo "<pre>";
		// print_r($itemlist);
		// die();
		if(!empty($itemlist)){
			 $trans=$this->db->insert_batch('xw_itli_itemslist_central',$itemlist);
			 if($trans)
	            {
	            	
	            	echo "Item Synch Successfully !!<br>";

	            }
	            else
	            {
	            	echo "Item Synch Fail !!<br>";
	            }
			flush();
			ob_flush();
		}
		
	 	//
	}

	public function unit_rec()
	{
		$unit_rec=$this->get_unit();
		// echo "<pre>";
		// print_r($unit_rec);
		// die();
		if(!empty($unit_rec)){
			 $trans=$this->db->insert_batch('xw_unit_unit_central',$unit_rec);
			 if($trans)
	            {
	            	  	echo "Unit Synch Successfully !!<br>";
	            }
	            else
	            {
	            		echo "Unit Synch Fail !!<br>";
	            }
		}
		
		flush();
		ob_flush();
	 	//
	}
	

	public function item_category_rec(){
		$category=$this->get_category();
		// echo "<pre>";
		// print_r($category);
		// die();
		if(!empty($category)){
			 $trans=$this->db->insert_batch('xw_eqca_equipmentcategory_central',$category);
			 if($trans)
	            {
	            	 echo "Category Synch Successfully !!<br>";
	            }
	            else
	            {
	            	echo "Category Synch Fail !!<br>";
	            }
			flush();
			ob_flush();
		}
	
	}

	


	public function supplier_rec(){
		$supplier=$this->get_supplier_other_db();
				// echo "<pre>";
				// print_r($supplier);
				// die();
		if(!empty($supplier)){
				 $trans=$this->db->insert_batch('xw_dist_distributors_central',$supplier);
				if($trans){
	            	 echo "Supplier Synch Successfully !!<br>";
	            }
	            else
	            {
	            	echo "Supplier Synch Fail !!<br>";
	            }
				flush();
				ob_flush();
		}
				
	}

	public function department_rec()
	{
		$department_rec=$this->get_department_other_db();
				// echo "<pre>";
				// print_r($department_rec);
				// die();
		if(!empty($department_rec)){
		 $trans=$this->db->insert_batch('xw_dept_department_central',$department_rec);
		if($trans){
	            	 echo "Department Synch Successfully !!<br>";
	            }
	            else
	            {
	            	echo "Department Synch Fail !!<br>";
	            }
		flush();
		ob_flush();
		}
				

	}

	

	public function budget_rec(){
		$budget_rec=$this->get_budget_other_db();
						// echo "<pre>";
						// print_r($budget_rec);
						// die();
		if(!empty($budget_rec)){
		 $trans=$this->db->insert_batch('xw_budg_budgets_central',$budget_rec);
		if($trans){
	            	 echo "Budget Synch Successfully !!<br>";
	            }
	            else
	            {
	            	echo "Budget Synch Fail !!<br>";
	            }
		flush();
		ob_flush();
		}
		
	}

	public function transaction_main_rec(){
		$transaction_master_list=$this->get_transaction_master();	
		// echo "<pre>";
		// 	print_r($transaction_master_list);
		// 	die();
		if(!empty($transaction_master_list)){
			$trans=$this->db->insert_batch('xw_trma_transactionmain_central',$transaction_master_list);
			if($trans){
	            	 echo "Transaction Main Synch Successfully !!<br>";
	            }
	            else
	            {
	            	echo "Transaction Main Synch Fail !!<br>";
	            }
		flush();
		ob_flush();
		}
			
	}

	public function transaction_detail_rec(){
		$transaction_detail_list=$this->get_transaction_detail();
		if(!empty($transaction_detail_list)){
		$trans=$this->db->insert_batch('trde_transactiondetail_central',$transaction_detail_list);
		// $this->db->query("UPDATE xw_trde_transactiondetail_central SET trde_transactiondatead=date_conveter('EN',trde_transactiondatebs)");
			if($trans){
	            	 echo "Transaction Detail Synch Successfully !!<br>";
	            }
	            else
	            {
	            	echo "Transaction Detail Synch Fail !!<br>";
	            }
		flush();
		ob_flush();
		}	
			
	}


	public function demand_request_master_rec(){

	}


	public function demand_request_detail_rec(){


	}


	public function purchase_requisition_master_rec(){
		$purchase_requisition_master_list=$this->get_purchase_requistion_master();
			// echo "<pre>";
			// print_r($purchase_requisition_master_list);
			// die();	
		if(!empty($purchase_requisition_master_list)){
			$trans=$this->db->insert_batch('pure_purchaserequisition_central',$purchase_requisition_master_list);
			if($trans){
	            	 echo "Purchase Requisition Master Synch Successfully !!<br>";
	            }
	            else
	            {
	            	echo "Purchase Requisition Master Synch Fail !!<br>";
	            }
				    flush();
					ob_flush();	
		}
	
	}
	
	public function purchase_requisition_detail_rec(){
		$purchase_requisition_detail_list=$this->get_purchase_requistion_detail();
			// echo "<pre>";
			// print_r($purchase_requisition_detail_list);
			// die();	
		if(!empty($purchase_requisition_detail_list)){
			$trans=$this->db->insert_batch('purd_purchasereqdetail_central',$purchase_requisition_detail_list);
			if($trans){
		            	 echo "Purchase Requisition Detail Synch Successfully !!<br>";
		            }
		            else
		            {
		            	echo "Purchase Requisition Detail Synch Fail !!<br>";
		            }
				    flush();
					ob_flush();
		}
		
	}

	public function purchase_order_master_rec(){
		$purchase_order_master_list=$this->get_purchase_order_master_db();
			// echo "<pre>";
			// print_r($purchase_order_master_list);
			// die();	
		if(!empty($purchase_order_master_list)){
		$trans=$this->db->insert_batch('puor_purchaseordermaster_central',$purchase_order_master_list);
		$this->db->query('UPDATE xw_puor_purchaseordermaster_central SET puor_vatamount=puor_vat');
		if($trans){
	        	 echo "Purchase Order Master Synch Successfully !!<br>";
	        }
	        else
	        {
	        	echo "Purchase Order Master Synch Fail !!<br>";
	        }	
	    flush();
		ob_flush();
		}
		

	}
	

	public function purchase_order_detail_rec(){
		$purchase_order_detail_list=$this->get_purchase_order_detail_db();
			// echo "<pre>";
			// print_r($purchase_order_detail_list);
			// die();	
		if(!empty($purchase_order_detail_list)){
		$trans=$this->db->insert_batch('pude_purchaseorderdetail_central',$purchase_order_detail_list);
		if($trans){
	        	 echo "Purchase Order Detail Synch Successfully !!<br>";
	        }
	        else
	        {
	        	echo "Purchase Order Detail Synch Fail !!<br>";
	        }	
	    flush();
		ob_flush();
		}
	}	


	public function purchase_received_master_rec(){
	$received_master_list=$this->get_received_master_db();
				// echo "<pre>";
				// print_r($received_master_list);
				// die();
		if(!empty($received_master_list)){
			$trans=$this->db->insert_batch('recm_receivedmaster_central',$received_master_list);
			if($trans){
	        	 echo "Purchase Received Master Synch Successfully !!<br>";
	        }
	        else
	        {
	        	echo "Purchase Received Master Synch Fail !!<br>";
	        }	
		    flush();
			ob_flush();
		}	
		

	}

	public function purchase_received_detail_rec(){
	$received_detail_list=$this->get_received_detail_db();
			// echo "<pre>";
			// print_r($received_detail_list);
			// die();	
	
		if(!empty($received_detail_list)){
		$trans=$this->db->insert_batch('recd_receiveddetail_central',$received_detail_list);
		if($trans){
	        	 echo "Purchase Received Detail Synch Successfully !!<br>";
	        }
	        else
	        {
	        	echo "Purchase Received Detail Synch Fail !!<br>";
	        }	
	    flush();
		ob_flush();
	}
	}

	public function purchase_return_master_rec()
	{
		$purchase_return_master_list=$this->get_purchase_return_db();
			// echo "<pre>";
			// print_r($purchase_return_master_list);
			// die();	
		if(!empty($purchase_return_master_list)){
			$trans=$this->db->insert_batch('purr_purchasereturn_central',$purchase_return_master_list);
			if($trans){
	        	 echo "Purchase Return Master Synch Successfully !!<br>";
	        }
	        else
	        {
	        	echo "Purchase Return Master Synch Fail !!<br>";
	        }	
	    flush();
		ob_flush();
		}
		
	}

	public function purchase_return_detail_rec()
	{
		$purchase_return_detail_list=$this->get_purchase_return_detail_db();
			// echo "<pre>";
			// print_r($purchase_return_detail_list);
			// die();	
		if(!empty($purchase_return_detail_list)){
			$trans=$this->db->insert_batch('prde_purchasereturndetail_central',$purchase_return_detail_list);
			if($trans){
		        	 echo "Purchase Return Detail Synch Successfully !!<br>";
		        }
		        else
		        {
		        	echo "Purchase Return Detail Synch Fail !!<br>";
		        }	
		    flush();
			ob_flush();
		}
		
	}


	public function issue_master_rec()
	{
		$issue_master_list=$this->get_sales_master_other_db();
		if(!empty($issue_master_list)){
		$trans=$this->db->insert_batch('xw_sama_salemaster_central',$issue_master_list);
		if($trans){
		        	 echo "Issue Master Synch Successfully !!<br>";
		        }
		        else
		        {
		        	echo "Issue Master Synch Fail !!<br>";
		        }	
	    flush();
		ob_flush();	
		}
			
		
	}

	public function issue_detail_rec(){
		$issue_detail_list=$this->get_sales_detail_other_db();
	// 	echo "<pre>";
	// print_r($issue_detail_list);
	// die();	
		if(!empty($issue_detail_list)){
			$trans=$this->db->insert_batch('xw_sade_saledetail_central',$issue_detail_list);
			if($trans){
		        	 echo "Issue Detail Synch Successfully !!<br>";
		        }
		        else
		        {
		        	echo "Issue Detail Synch Fail !!<br>";
		        }
		    flush();
			ob_flush();
		}
		
	}





/* Function for getting Data from SQL Server */
	public function get_itemlistfromotherdb()
	{
		$this->db2->select('
		ITEMSID	As	id,
		ITEMSCODE	As	itli_itemcode,
		ITEMSNAME	As	itli_itemname,
		TYPEAID 	As  itli_materialtypeid,				
		SALERATE	As	itli_salesrate,
		PURCHASERATE	As	itli_purchaserate,		
		REORDERLEVEL	As	itli_reorderlevel,
		LOSSQTY	As	itli_lossqty,
		CATID	As	itli_catid,
		SUBCATID	As	itli_subcatid,	
		UNITID		AS itli_unitid,
		ACTIVE	As	itli_active,
		MAXLIMIT	As	itli_maxlimit,
		MOVINGTYPE	As	itli_movingtype,
		VALUETYPE	As	itli_valuetype');
		$this->db2->order_by('ITEMSID','ASC');
		$query=$this->db2->get('ITEMSLIST');
		if($query->num_rows()>0)
		{
			return $query->result();
		}
		return false;

	}

	public function get_unit()
	{
		$this->db2->select('
				 UNITID		AS	id,	
				 UNITNAME	AS	unit_unitname');
				$this->db2->order_by('UNITID','ASC');
				$query=$this->db2->get('UNITTABLE');
				if($query->num_rows()>0)
				{
					return $query->result();
				}
				return false;
	}

	
	public function get_category()
	{
		$this->db2->select('
				CATEGORYID 		As	id,
				CATEGORYNAME	As	eqca_category,
				TYPEID			As	eqca_equiptypeid,
				CATCODE			As	eqca_code,
				PARENTID		AS	eqca_parentcategoryid');
				$this->db2->order_by('CATEGORYID','ASC');
				$query=$this->db2->get('CATEGORY');
				if($query->num_rows()>0)
				{
					return $query->result();
				}
				return false;

	}


	function get_supplier_other_db()
	{
		// print_r($this->db2);
		// die();
		$this->db2->select('
			SUPPLIERID as id,
			SUPPLIERCODE as dist_distributorcode,
			SUPPLIERNAME 		as  dist_distributor,
            SUPPLIERADDRESS  	as 	dist_address1,
            SUPPLIERPHONE  		as  dist_phone1,
            SUPPLIERMOBILE  	as 	dist_phone2,
            CONTACTPERSON  		as  dist_salesrep,
            SUPPLIERFAX  		as 	dist_fax,
            SUPPLIERMAIL  		as  dist_email,
            GOVTREGNO  			as 	dist_govtregno,
            GOVTREGDATE  		as 	dist_govtregdatead,
            REMARKS  			as  dist_remarks,
            SUPPLIERCODE  		as  dist_distributorcode,
            CITY   				as  dist_city,
            STREET   			as  dist_address1,
           ');
		$this->db2->order_by('SUPPLIERID','ASC');
		$query=$this->db2->get('SUPPLIER');

		if($query->num_rows()>0)
		{
			return $query->result();
		}
		return false;

	}

    public function get_department_other_db()
    {
        $this->db2->select('
            DEPID   as id, 
            DEPCODE as dept_depcode, 
            DEPNAME as dept_depname
            ');
        $this->db2->order_by('DEPID','ASC');
        $query=$this->db2->get('DEPARTMENT');

        if($query->num_rows()>0)
        {
            return $query->result();
        }
        return false;
    }

     public function get_budget_other_db()
    {
        $this->db2->select('
        	BUDGETID as id,
        	BUDGETNAME as budg_budgetname');
        $this->db2->order_by('BUDGETID','ASC');
        $query=$this->db2->get('BUDGETS');

        if($query->num_rows()>0)
        {
            return $query->result();
        }
        return false;
    }


 public function get_transaction_master()
    {
	 $this->db2->select('
	            MAT_TRANS_MASTERID	AS	id,
				TRANSACTION_DATE	AS	trma_transactiondatebs,
				TRANSACTION_TYPE	AS	trma_transactiontype,
				FROM_DEPARTMENTID	AS	trma_fromdepartmentid,
				TO_DEPARTMENTID		AS	trma_todepartmentid,
				FROM_BY				AS	trma_fromby,
				TO_BY				AS	trma_toby,
				ISSUE_NO			AS	trma_issueno,
				STATUS				AS	trma_status,
				SYS_DATE			AS	trma_sysdate,
				LAST_CHANGE_DATE	AS	trma_lastchangedate,
				LAST_CHANGE_BY		AS	trma_lastchangeby,
				BATCH_JOB_ID		AS	trma_batchjobid,
				BATCHNO				AS	trma_batchno,
				BATCH_ITEM_ID		AS	trma_batchitemid,
				BATCH_SIZE			AS	trma_batchsize,
				STATUS_UPDATE_DATE	AS	trma_statusupdatedate,
				REQNO				AS	trma_reqno,
				RECEIVED			AS	trma_received,
				RECEIVEDDATE		AS	trma_receiveddatebs,
				RECEIVEDBY			AS	trma_receivedby,
				REMARKS				AS	trma_remarks,
				MANUALNO			AS	trma_manualno,
				MTMTIME				AS	trma_mtmtime,
				FYEAR				AS	trma_fyear,
				
	            ');
	        $this->db2->order_by('MAT_TRANS_MASTERID','ASC');
	        $query=$this->db2->get('MAT_TRANS_MASTER');

	        if($query->num_rows()>0)
	        {
	            return $query->result();
	        }
	        return false;
    }

    public function get_transaction_detail()
    {
    	$this->db2->select('
	            MAT_TRANS_DETAILID	AS	id,
				MAT_TRANS_MASTERID	AS	trde_trmaid,
				TRANSACTION_DATE	AS	trde_transactiondatebs,
				ITEMSID				AS	trde_itemsid,
				CONTROL_NO			AS	trde_controlno,
				MFG_DATE			AS	trde_mfgdatebs,
				EXP_DATE			AS	trde_expdatebs,
				PACKINGTYPEID		AS	trde_packingtypeid,
				MTDID				AS	trde_mtdid,
				BATCHNO				AS	trde_batchno,
				UNITPERCASE			AS	trde_unitpercase,
				NOOFCASES			AS	trde_noofcases,
				CASENO				AS	trde_caseno,
				REQUIRED_QTY		AS	trde_requiredqty,
				ISSUE_QTY			AS	trde_issueqty,
				BATCHSIZE			AS	trde_batchsize,
				PACKING				AS	trde_packing,
				STRIPQTY			AS	trde_stripqty,
				ISSUE_NO			AS	trde_issueno,
				STATUS				AS	trde_status,
				SYS_DATE			AS	trde_sysdate,
				LAST_CHANGE_DATE	AS	trde_lastchangedate,
				LAST_CHANGE_BY		AS	trde_lastchangeby,
				MTMID				AS	trde_mtmid,
				TRANSACTION_TYPE	AS	trde_transactiontype,
				STATUS_UPDATE_DATE	AS	trde_statusupdatedatebs,
				UNITPRICE			AS	trde_unitprice,
				SELPRICE			AS	trde_selprice,
				REMARKS				AS	trde_remarks,
				SUPPLIERID			AS	trde_supplierid,
				SUPPLIERBILLNO		AS	trde_supplierbillno,
				TRANSTIME			AS	trde_transtime,
				MTDTIME				AS	trde_mtdtime,
				UNITVOLUME			AS	trde_unitvolume,
				MICROUNITID			AS	trde_microunitid,
				TOTALVOLUME			AS	trde_totalvalue,
				DESCRIPTION			AS	trde_description,
				FREE				AS	trde_free
	            ');
	        $this->db2->order_by('MAT_TRANS_DETAILID','ASC');
	        $query=$this->db2->get('MAT_TRANS_DETAIL');

	        if($query->num_rows()>0)
	        {
	            return $query->result();
	        }
	        return false;
    }

 	public function get_purchase_requistion_master()
    {
    	if($this->locationid==3){
    		$this->db2->select("
                REQID          AS  id,
                REQ_DATE       AS  pure_reqdatebs,
                APPLIED_BY     AS  pure_appliedby,
                REQUSER        AS  pure_requser,
                REQTIME        AS  pure_reqtime,
                REQUEST_TO     AS  pure_requestto,
                FYEAR          AS  pure_fyear,
                COSTCENTRE     AS  pure_costcenter,
                STOREID        AS  pure_storeid,
                REQNO          AS  pure_reqno,
                ORDERED        AS  pure_ordered");
    	}else{
    		$this->db2->select("
                REQID          AS  id,
                REQ_DATE       AS  pure_reqdatebs,
                APPLIED_BY     AS  pure_appliedby,
                REQUSER        AS  pure_requser,
                REQTIME        AS  pure_reqtime,
                REQUEST_TO     AS  pure_requestto,
                FYEAR          AS  pure_fyear,
                COSTCENTRE     AS  pure_costcenter,
                STOREID        AS  pure_storeid,
                REQNO          AS  pure_reqno,
                ORDERED        AS  pure_ordered,
                (CASE WHEN(isapproved='PENDING') THEN 'Y' ELSE 'N' END)       AS  pure_isapproved");
    	}
        
                $this->db2->order_by('REQID','ASC');
                $query=$this->db2->get('REQUISITION');
                if($query->num_rows()>0)
                {
                    return $query->result();
                }
                return false;
    }

    public function get_purchase_requistion_detail()
    {
        $this->db2->select('
        	  	REQDETID    AS  id,
                REQID       AS  purd_reqid,
                ITEMSID     AS  purd_itemsid,
                UNIT        AS  purd_unit,
                STORE_STOCK AS  purd_stock,
                QTY         AS  purd_qty,
                RATE        AS  purd_rate,
                BUD_CODE    AS  purd_budcode,
                REMARKS     AS  purd_remarks,
                FYEAR       AS  purd_fyear,
                REQ_DATE    AS  purd_reqdatebs,
                REM_QTY     AS  purd_remqty
                ');
                $this->db2->order_by('REQID','ASC');
                $query=$this->db2->get('REQDETAIL');
                if($query->num_rows()>0)
                {
                    return $query->result();
                }
                return false;
    }

public function get_purchase_order_master_db()
    {
        $this->db2->select('
        PURCHASEORDERMASTERID  as          id,
        PURCHASEORDERNO        as          puor_orderno,
        PURCHASEORDERDATE      as          puor_orderdatebs,
        FYEAR                  as          puor_fyear,
        DELIVERYSITE           as          puor_deliverysite,
        DELIVERYDATE           as          puor_deliverydatebs,
        SUPPLIERID             as          puor_supplierid,
        ORDERAMOUNT            as          puor_amount,
        VAT                    as          puor_vat,
        STATUS                 as          puor_status,
        PURCHASED              as          puor_purchased,
        DISCOUNT               as          puor_discount,
        TERMS                  as          puor_terms,
        APPROVEDBY             as          puor_approvedby,
        ORDER_FOR              as          puor_orderfor,
        DELIVERYDAYS           as          puor_deliverydays,
        PAYMENTDAYS            as          puor_paymentdays,
        CANCELDATE             as          puor_canceldatebs,
        REQUISITIONNO          as          puor_requno,
        USER_NAME              as          puor_postby,
        CURRENCYSYMBOL         as          puor_currencytype,
        CURRENCYRATE           as          puor_currencyrate,
        ORDERTYPE              as          puor_ordertype,
        INSURANCE              as          puor_insurance,
        CARRIAGEFREIGHT        as          puor_carriagefreight,
        PACKING                as          puor_packing,
        TRANSPORTCOURIER       as          puor_transportcourier,
        OTHERS                 as          puor_other,
        REMARKS                as          puor_remarks,
        STOREID                as          puor_storeid,
        BudgetId		  	   as  		   puor_budgetid
        ');
        $this->db2->order_by('PURCHASEORDERMASTERID','ASC');
        $query=$this->db2->get('PURCHASEORDERMASTER');
        if($query->num_rows()>0)
        {
            return $query->result();
        }
        return false;
    }

 public function get_purchase_order_detail_db()
    {
        $this->db2->select('
        PURCHASEORDERDETAILID   as      id,
        PURCHASEORDERMASTERID   as      pude_purchasemasterid,
        ITEMSID                 as      pude_itemsid,
        QUANTITY                as      pude_quantity,
        RATE                    as      pude_rate,
        AMOUNT                  as      pude_amount,
        UNIT                    as      pude_unit,
        REMQTY                  as      pude_remqty,
        DISCOUNT                as      pude_discount,
        VAT                     as      pude_vat,
        FREE                    as      pude_free,
        REMARKS                 as      pude_remarks,
        CANCELDATE              as      pude_canceldatebs,
        STATUS                  as      pude_status,
        USER_NAME               as      pude_username,
        CANCELLEDQTY            as      pude_cancelqty,
        NCRATE                  as      pude_ncrate,
        TENDERID                as      pude_tenderid
        ');
        $this->db2->order_by('PURCHASEORDERDETAILID','ASC');
        $query=$this->db2->get('PURCHASEORDERDETAIL');
        if($query->num_rows()>0)
        {
            return $query->result();
        }
        return false;
    }


    public function get_purchase_return_db()
    {
        $this->db2->select('
        PURCHASERETURNID   as          id,
        RETURNDATE         as          purr_returndatebs,
        RETURNNO           as          purr_returnno,
        RETURNEDBY         as          purr_returnby,
        RECEIVEDBY         as          purr_receivedby,
        REMARKS            as          purr_remarks,
        SUPPLIERID         as          purr_supplierid,
        FYEAR              as          purr_fyear,
        OPERATOR           as          purr_operator,
        DEPARTMENTID       as          purr_departmentid,
        RETURNAMOUNT       as          purr_returnamount,
        DISCOUNT           as          purr_discount,
        INVOICENO          as          purr_invoiceno,
        RETURNTIME         as          purr_returntime,
        VATAMOUNT          as          purr_vatamount,
        DAY_CLOSEID        as          purr_dayclosedid,
        ST                 as          purr_st
        ');
        $this->db2->order_by('PURCHASERETURNID','ASC');
        $query=$this->db2->get('PURCHASERETURN');
        // echo $this->db->last_query();
        // die();
        if($query->num_rows()>0)
        {
            return $query->result();
        }
        return false;
    }


public function get_purchase_return_detail_db()
    {
        $this->db2->select('
        PURCHASERETURNDETAILID as          id,
        PURCHASERETURNID       as          prde_purchasereturnid,
        ITEMSID                as          prde_itemsid,
        RETURNQTY              as          prde_returnqty,
        CONTROLNO              as          prde_controlno,
        PURCHASERATE           as          prde_purchaserate,
        EXPDATE                as          prde_expdatebs,
        INVOICENO              as          prde_invoiceno,
        RECEIVEDDETAILID       as          prde_receiveddetailid,
        NOTEQTY                as          prde_noteqty,
        SALERATE               as          prde_salerate,
        FREE                   as          prde_free,
        SUPPLIERID             as          prde_supplierid,
        SUPPLIERBILLNO         as          prde_supplierbillno,
        REMARKS                as          prde_remarks ');
        $this->db2->order_by('PURCHASERETURNDETAILID','ASC');
        $query=$this->db2->get('PURCHASERETURNDETAIL');
        if($query->num_rows()>0)
        {
            return $query->result();
        }
        return false;
    }


public function get_received_master_db()
    {
        $this->db2->select('
        RECEIVEDMASTERID           as      id,
        RECEIVEDDATE               as      recm_receiveddatebs,
        FYEAR                      as      recm_fyear,
        SUPPLIERID                 as      recm_supplierid,
        PURCHASEORDERMASTERID      as      recm_purchaseordermasterid,
        AMOUNT                     as      recm_amount,
        DISCOUNT                   as      recm_discount,
        TAXAMOUNT                  as      recm_taxamount,
        CLEARANCEAMOUNT            as      recm_clearanceamount,
        DSTAT                      as      recm_dstat,
        TSTAT                      as      recm_tstat,
        CHALLANNO                  as      recm_challanno,
        PURCHASEORDERNO            as      recm_purchaseorderno,
        PURCHASEORDERDATE          as      recm_purchaseorderdatebs,
        QTYCHALLAN                 as      recm_qtychallan,
        QTYRECEIVED                as      recm_qtyreceived,
        SUPPLIERBILLNO             as      recm_supplierbillno,
        RECEIVEDNO                 as      recm_receivedno,
        DEPARTMENTID               as      recm_departmentid,
        STATUS                     as      recm_status,
        ENTEREDBY                  as      recm_enteredby,
        SUPBILLDATE                as      recm_supbilldatebs,
        POSTTIME                   as      recm_posttime,
        INVOICENO                  as      recm_invoiceno,
        INSURANCE                  as      recm_insurance,
        CARRIAGEFREIGHT            as      recm_carriagefreight,
        PACKING                    as      recm_packing,
        TRANSPORTCOURIER           as      recm_transportcourier,
        OTHERS                     as      recm_others,
        REMARKS                    as      recm_remarks,
        CURRENCYSYMBOL             as      recm_currencysymbol,
        CURRENCYRATE               as      recm_currencyrate,
        BUDGETID                   as      recm_budgetid
        ');
        $this->db2->order_by('RECEIVEDMASTERID','ASC');
        $query=$this->db2->get('RECEIVEDMASTER');
        if($query->num_rows()>0)
        {
            return $query->result();
        }
        return false;
    }

public function get_received_detail_db()
    {
        $this->db2->select('
        RECEIVEDDETAILID        as      id,
        RECEIVEDMASTERID        as      recd_receivedmasterid,
        ITEMSID                 as      recd_itemsid,
        PURCHASEDQTY            as      recd_purchasedqty,
        UNITPRICE               as      recd_unitprice,
        ATSTOCK                 as      recd_atstock,
        LOCATION                as      recd_location,
        CONTROLNO               as      recd_controlno,
        MARGIN                  as      recd_margin,
        SALERATE                as      recd_salerate,
        QUALITYCHECKDATE        as      recd_qualitycheckdate,
        QUALITYSTATUS           as      recd_qualitystatus,
        CONSUMEQTY              as      recd_consumeqty,
        QUALITYREF              as      recd_qualityref,
        STATUS                  as      recd_status,
        BATCHNO                 as      recd_batchno,
        ST                      as      recd_st,
        EXPDATE                 as      recd_expdatebs,
        CCCHARGE                as      recd_cccharge,
        ENTEREDBY               as      recd_enteredby,
        ENTEREDDATETIME         as      recd_entereddatetime,
        ARATE                   as      recd_arate,
        FREE                    as      recd_free,
        DISCOUNTPC              as      recd_discountpc,
        VATPC                   as      recd_vatpc,
        AMOUNT                  as      recd_amount,
        PURCHASEORDERDETAILID   as      recd_purchaseorderdetailid,
        CHALLANDETAILID         as      recd_challandetailid,
        DESCRIPTION             as      recd_description
        ');
        $this->db2->order_by('RECEIVEDDETAILID','ASC');
        $query=$this->db2->get('RECEIVEDDETAIL');
        if($query->num_rows()>0)
        {
            return $query->result();
        }
        return false;
    }


    public function get_sales_master_other_db()
{
    $this->db2->select('
      	SALEMASTERID		as				id,
		CUSTOMERID			as				sama_depid,
		BILLDATE			as				sama_billdatebs,
		DUEDATE				as				sama_duedatebs,
		SOLDBY				as				sama_soldby,
		TOTALAMOUNT			as				sama_totalamount,
		DISCOUNT			as				sama_discount,
		TAXRATE				as				sama_taxrate,
		VAT					as				sama_vat,
		USER_NAME			as				sama_username,
		LASTCHANGEDATE		as				sama_lastchangedate,
		ORDERNO				as				sama_orderno,
		CHALLANNO			as				sama_challanno,
		BILL_NO				as				sama_billno,
		PAYMENT				as				sama_payment,
		STATUS				as				sama_status,
		FYEAR				as				sama_fyear,
		DISCOUNTPC			as				sama_discountpc,
		ISPRINTED			as				sama_isprinted,
		ST					as				sama_st,
		REQUISITIONNO 		as 				sama_requisitionno,
		MANUALBILLNO		as				sama_manualbillno,
		DEPID				as				sama_storeid,
		STDATE				as				sama_stdatebs,
		STDEPID				as				sama_stdepid,
		STSHIFTID			as				sama_stshiftid,
		CUSTOMERNAME		as				sama_depname,
		INVOICENO			as				sama_invoiceno,
		MEMNO				as 				sama_receivedby,
		REQUISITIONDATE		as 				sama_requisitiondatebs
            '); 

        $this->db2->order_by('SALEMASTERID','ASC');
         // $this->db2->limit(1);
        $query=$this->db2->get('SALEMASTER');

        if($query->num_rows()>0)
        {
            return $query->result();
        }
        return false;

}



	public function get_sales_detail_other_db()
	{
		$this->db2->select('
			SALEDETAILID			As		id,
			SALEMASTERID			As		sade_salemasterid,
			ITEMSID					As		sade_itemsid,
			QTY						As		sade_qty,
			CURQTY					As		sade_curqty,
			UNITRATE				As		sade_unitrate,
			DISCOUNT				As		sade_discount,
			BATCHNO					As		sade_batchno,
			MFGDATE					As		sade_mfgdate,
			EXPDATE					As		sade_expdate,
			MAT_TRANS_DETAILID		As		sade_mattransdetailid,
			STATUS					As		sade_status,
			CONTROLNO				As		sade_controlno,
			PURCHASERATE			As		sade_purchaserate,
			BILLDATE				As		sade_billdatebs,
			BILLTIME				As		sade_billtime,
			USER_NAME				As		sade_username,
			VATAMT					As		sade_vatamt,
			INVOICENO				As		sade_invoiceno,
			SNO						As		sade_sno,
			REMARKS					As		sade_remarks
			');
        $this->db2->order_by('SALEDETAILID','ASC');
        // $this->db2->limit(1);

        $query=$this->db2->get('SALEDETAIL');

        if($query->num_rows()>0)
        {
            return $query->result();
        }
        return false;

	}


    public function item_locationid_update()
    {
    		/*Item Rec Start*/
		$this->db->select('MIN(itli_itemlistid) as minid,MAX(itli_itemlistid)as maxid');
		$this->db->from('xw_itli_itemslist_central');
		$this->db->where('itli_locationid IS NULL');
		$rslt_itm=$this->db->get()->row();
		// echo "<pre>";
		// print_r($rslt_itm);
		// die();
		if(!empty($rslt_itm)){
			$minid=$rslt_itm->minid;
			$maxid=$rslt_itm->maxid;
			if(!empty($minid) && !empty($maxid)){
			$this->db->query("UPDATE xw_itli_itemslist_central SET itli_locationid=$this->locationid WHERE itli_itemlistid>=$minid AND itli_itemlistid<=$maxid  ");

		}
		}

		/*Item Rec End */
    }

    public function unit_locationid_update()
    {
    		/*Unit Start*/
		$this->db->select('MIN(unit_unitid) as minid,MAX(unit_unitid)as maxid');
		$this->db->from('xw_unit_unit_central');
		$this->db->where('unit_locationid IS NULL');
		$rslt_itm=$this->db->get()->row();
		// echo "<pre>";
		// print_r($rslt_itm);
		// die();
		if(!empty($rslt_itm)){
			$minid=$rslt_itm->minid;
			$maxid=$rslt_itm->maxid;
			if(!empty($minid) && !empty($maxid)){
			$this->db->query("UPDATE xw_unit_unit_central SET unit_locationid=$this->locationid WHERE unit_unitid>=$minid AND unit_unitid<=$maxid  ");
		}
		}

		/*Unit End */
    }

   

    public function category_locationid_update()
    {
    		/*Category Start*/
		$this->db->select('MIN(eqca_equipmentcategoryid) as minid,MAX(eqca_equipmentcategoryid)as maxid');
		$this->db->from('xw_eqca_equipmentcategory_central');
		$this->db->where('eqca_locationid IS NULL');
		$rslt_itm=$this->db->get()->row();
		// echo "<pre>";
		// print_r($rslt_itm);
		// die();
		if(!empty($rslt_itm)){
			$minid=$rslt_itm->minid;
			$maxid=$rslt_itm->maxid;
			if(!empty($minid) && !empty($maxid)){
			$this->db->query("UPDATE xw_eqca_equipmentcategory_central SET eqca_locationid=$this->locationid WHERE eqca_equipmentcategoryid>=$minid AND eqca_equipmentcategoryid<=$maxid  ");
			}
		}

		/*Category End */
    }
	public function supplier_locationid_update()
	    {
	    		/*Supplier Start*/
			$this->db->select('MIN(dist_distributorid) as minid,MAX(dist_distributorid)as maxid');
			$this->db->from('xw_dist_distributors_central');
			$this->db->where('dist_locationid IS NULL');
			$rslt_itm=$this->db->get()->row();
			// echo "<pre>";
			// print_r($rslt_itm);
			// die();
			if(!empty($rslt_itm)){
				$minid=$rslt_itm->minid;
				$maxid=$rslt_itm->maxid;
				if(!empty($minid) && !empty($maxid)){
				$this->db->query("UPDATE xw_dist_distributors_central SET dist_locationid=$this->locationid WHERE dist_distributorid>=$minid AND dist_distributorid<=$maxid  ");
			}
			}

			/*Supplier End */
	    }


	    public function department_locationid_update(){
	    		/*Department Start*/
			$this->db->select('MIN(dept_depid) as minid,MAX(dept_depid)as maxid');
			$this->db->from('xw_dept_department_central');
			$this->db->where('dept_locationid IS NULL');
			$rslt_itm=$this->db->get()->row();
			// echo "<pre>";
			// print_r($rslt_itm);
			// die();
			if(!empty($rslt_itm)){
				$minid=$rslt_itm->minid;
				$maxid=$rslt_itm->maxid;
				if(!empty($minid) && !empty($maxid)){
				$this->db->query("UPDATE xw_dept_department_central SET dept_locationid=$this->locationid WHERE dept_depid>=$minid AND dept_depid<=$maxid  ");
			}
			}

			/*Department End */
	    }

	    public function budget_locationid_update(){
	    		/*Budget Start*/
			$this->db->select('MIN(budg_budgetid) as minid,MAX(budg_budgetid)as maxid');
			$this->db->from('xw_budg_budgets_central');
			$this->db->where('budg_locationid IS NULL');
			$rslt_itm=$this->db->get()->row();
			// echo "<pre>";
			// print_r($rslt_itm);
			// die();
			if(!empty($rslt_itm)){
				$minid=$rslt_itm->minid;
				$maxid=$rslt_itm->maxid;
				if(!empty($minid) && !empty($maxid)){
				$this->db->query("UPDATE xw_budg_budgets_central SET budg_locationid=$this->locationid WHERE budg_budgetid>=$minid AND budg_budgetid<=$maxid  ");
			}
			}

			/*Budget End */

	    }
		public function transaction_main_locationid_update(){
		/*Transaction main Start*/

		$this->db->select('MIN(trma_trmaid) as minid,MAX(trma_trmaid)as maxid');
		$this->db->from('xw_trma_transactionmain_central');
		$this->db->where('trma_locationid IS NULL');
		$rslt_itm=$this->db->get()->row();
		// echo "<pre>";
		// print_r($rslt_itm);
		// die();
		if(!empty($rslt_itm)){
			$minid=$rslt_itm->minid;
			$maxid=$rslt_itm->maxid;
			if(!empty($minid) && !empty($maxid)){
			$this->db->query("UPDATE xw_trma_transactionmain_central SET trma_locationid=$this->locationid WHERE trma_trmaid>=$minid AND trma_trmaid<=$maxid  ");
			}
		}
		/*Transaction main End*/
		}

		public function transaction_detail_locationid_update(){
			/*Transaction Detail Start*/

		$this->db->select('MIN(trde_trdeid) as minid,MAX(trde_trdeid)as maxid');
		$this->db->from('xw_trde_transactiondetail_central');
		$this->db->where('trde_locationid IS NULL');
		$rslt_itm=$this->db->get()->row();
		// echo "<pre>";
		// print_r($rslt_itm);
		// die();
		if(!empty($rslt_itm)){
			$minid=$rslt_itm->minid;
			$maxid=$rslt_itm->maxid;
			if(!empty($minid) && !empty($maxid)){
			$this->db->query("UPDATE xw_trde_transactiondetail_central SET trde_locationid=$this->locationid WHERE trde_trdeid>=$minid AND trde_trdeid<=$maxid  ");
			}
		}
		/*Transaction Detail End*/


		}
		public function purchase_requisition_master_locationid_update(){
		/*Purchase Master Start*/
		$this->db->select('MIN(pure_purchasereqid) as minid,MAX(pure_purchasereqid)as maxid');
		$this->db->from('xw_pure_purchaserequisition_central');
		$this->db->where('pure_locationid IS NULL');
		$rslt_itm=$this->db->get()->row();
		// echo "<pre>";
		// print_r($rslt_itm);
		// die();
		if(!empty($rslt_itm)){
			$minid=$rslt_itm->minid;
			$maxid=$rslt_itm->maxid;
			if(!empty($minid) && !empty($maxid)){
			$this->db->query("UPDATE xw_pure_purchaserequisition_central SET pure_locationid=$this->locationid WHERE pure_purchasereqid>=$minid AND pure_purchasereqid<=$maxid  ");
			}
		}
		/*Purchase Master End*/	

		}

		public function purchase_requisition_detail_locationid_update(){
			/*Purchase Detail Start*/
		$this->db->select('MIN(purd_reqdetid) as minid,MAX(purd_reqdetid)as maxid');
		$this->db->from('xw_purd_purchasereqdetail_central');
		$this->db->where('purd_locationid IS NULL');
		$rslt_itm=$this->db->get()->row();
		// echo "<pre>";
		// print_r($rslt_itm);
		// die();
		if(!empty($rslt_itm)){
			$minid=$rslt_itm->minid;
			$maxid=$rslt_itm->maxid;
			if(!empty($minid) && !empty($maxid)){
			$this->db->query("UPDATE xw_purd_purchasereqdetail_central SET purd_locationid=$this->locationid WHERE purd_reqdetid>=$minid AND purd_reqdetid<=$maxid  ");
			}
			}
		/*Purchase Detail End*/	


		}
		public function purchase_order_master_locationid_update(){
				/*Purchase Order Master Start*/
		$this->db->select('MIN(puor_purchaseordermasterid) as minid,MAX(puor_purchaseordermasterid)as maxid');
		$this->db->from('xw_puor_purchaseordermaster_central');
		$this->db->where('puor_locationid IS NULL');
		$rslt_itm=$this->db->get()->row();
		// echo "<pre>";
		// print_r($rslt_itm);
		// die();
		if(!empty($rslt_itm)){
			$minid=$rslt_itm->minid;
			$maxid=$rslt_itm->maxid;
			if(!empty($minid) && !empty($maxid)){
			$this->db->query("UPDATE xw_puor_purchaseordermaster_central SET puor_locationid=$this->locationid WHERE puor_purchaseordermasterid>=$minid AND puor_purchaseordermasterid<=$maxid  ");
			}
			}
		/*Purchase Order Master End*/	

		}
		public function purchase_order_detail_locationid_update(){
		/*Purchase Order Master Start*/
		$this->db->select('MIN(pude_puordeid) as minid,MAX(pude_puordeid)as maxid');
		$this->db->from('xw_pude_purchaseorderdetail_central');
		$this->db->where('pude_locationid IS NULL');
		$rslt_itm=$this->db->get()->row();
		// echo "<pre>";
		// print_r($rslt_itm);
		// die();
		if(!empty($rslt_itm)){
			$minid=$rslt_itm->minid;
			$maxid=$rslt_itm->maxid;
			if(!empty($minid) && !empty($maxid)){
			$this->db->query("UPDATE xw_pude_purchaseorderdetail_central SET pude_locationid=$this->locationid WHERE pude_puordeid>=$minid AND pude_puordeid<=$maxid  ");
			}
		}
		/*Purchase Order Master End*/	

		}
		public function purchase_received_master_locationid_update(){
			/*Purchase Received Master Start*/
			$this->db->select('MIN(recm_receivedmasterid) as minid,MAX(recm_receivedmasterid)as maxid');
			$this->db->from('xw_recm_receivedmaster_central');
			$this->db->where('recm_locationid IS NULL');
			$rslt_itm=$this->db->get()->row();
			// echo "<pre>";
			// print_r($rslt_itm);
			// die();
			if(!empty($rslt_itm)){
				$minid=$rslt_itm->minid;
				$maxid=$rslt_itm->maxid;
				if(!empty($minid) && !empty($maxid)){
				$this->db->query("UPDATE xw_recm_receivedmaster_central SET recm_locationid=$this->locationid WHERE recm_receivedmasterid>=$minid AND recm_receivedmasterid<=$maxid  ");
				}
			}
			/*Purchase Received Master End*/	

		}

		public function purchase_received_detail_locationid_update(){
			/*Purchase Received Detail Start*/
		$this->db->select('MIN(recd_receiveddetailid) as minid,MAX(recd_receiveddetailid)as maxid');
		$this->db->from('xw_recd_receiveddetail_central');
		$this->db->where('recd_locationid IS NULL');
		$rslt_itm=$this->db->get()->row();
		// echo "<pre>";
		// print_r($rslt_itm);
		// die();
		if(!empty($rslt_itm)){
			$minid=$rslt_itm->minid;
			$maxid=$rslt_itm->maxid;
			if(!empty($minid) && !empty($maxid)){
			$this->db->query("UPDATE xw_recd_receiveddetail_central SET recd_locationid=$this->locationid WHERE recd_receiveddetailid>=$minid AND recd_receiveddetailid<=$maxid  ");
			}
			}
		/*Purchase Received Detail End*/	

		}
		public function purchase_return_master_locationid_update(){
		/*Purchase Return Master Start*/
		$this->db->select('MIN(rema_returnmasterid) as minid,MAX(rema_returnmasterid)as maxid');
		$this->db->from('xw_rema_returnmaster_central');
		$this->db->where('rema_locationid IS NULL');
		$rslt_itm=$this->db->get()->row();
		// echo "<pre>";
		// print_r($rslt_itm);
		// die();
		if(!empty($rslt_itm)){
			$minid=$rslt_itm->minid;
			$maxid=$rslt_itm->maxid;
			if(!empty($minid) && !empty($maxid)){
					$this->db->query("UPDATE xw_rema_returnmaster_central SET rema_locationid=$this->locationid WHERE rema_returnmasterid>=$minid AND rema_returnmasterid<=$maxid  ");
			}
			
			}
		/*Purchase Return Master End*/	

		}

		public function purchase_return_detail_locationid_update(){
				/*Purchase Return Master Start*/
		$this->db->select('MIN(rede_returndetailid) as minid,MAX(rede_returndetailid)as maxid');
		$this->db->from('xw_rede_returndetail_central');
		$this->db->where('rede_locationid IS NULL');
		$rslt_itm=$this->db->get()->row();
		// echo "<pre>";
		// print_r($rslt_itm);
		// die();
		if(!empty($rslt_itm)){
			$minid=$rslt_itm->minid;
			$maxid=$rslt_itm->maxid;
			if(!empty($minid) && !empty($maxid)){
			$this->db->query("UPDATE xw_rede_returndetail_central SET rede_locationid=$this->locationid WHERE rede_returndetailid>=$minid AND rede_returndetailid<=$maxid  ");
			}
			}
		/*Purchase Return Master End*/	
		}

	public function issue_master_locationid_update(){
				/*Issue  Master Start*/
		$this->db->select('MIN(sama_salemasterid) as minid,MAX(sama_salemasterid)as maxid');
		$this->db->from('xw_sama_salemaster_central');
		$this->db->where('sama_locationid IS NULL');
		$rslt_itm=$this->db->get()->row();
		// echo "<pre>";
		// print_r($rslt_itm);
		// die();
		if(!empty($rslt_itm)){
			$minid=$rslt_itm->minid;
			$maxid=$rslt_itm->maxid;
			if(!empty($minid) && !empty($maxid)){
			$this->db->query("UPDATE xw_sama_salemaster_central SET sama_locationid=$this->locationid WHERE sama_salemasterid>=$minid AND sama_salemasterid<=$maxid  ");
		}
			}
		/*Issue  Master End*/	
	}

	public function issue_detail_locationid_update(){
				/*Issue Detail Start*/
		$this->db->select('MIN(sade_saledetailid) as minid,MAX(sade_saledetailid)as maxid');
		$this->db->from('xw_sade_saledetail_central');
		$this->db->where('sade_locationid IS NULL');
		$rslt_itm=$this->db->get()->row();
		// echo "<pre>";
		// print_r($rslt_itm);
		// die();
		if(!empty($rslt_itm)){
			$minid=$rslt_itm->minid;
			$maxid=$rslt_itm->maxid;
			if(!empty($minid) && !empty($maxid)){
			$this->db->query("UPDATE xw_sade_saledetail_central SET sade_locationid=$this->locationid WHERE sade_saledetailid>=$minid AND sade_saledetailid<=$maxid  ");
			}
			}
		/*Issue Detail End*/	
	}

public function general_inventory_setup_manage()
	{
		$this->unit_manage();
		$this->item_manage_rec();
		$this->supplier_manage();
		$this->department_manage();
		$this->category_manage();
		$this->budget_manage();
		$this->update_category_unit_on_item();


	}




	


	public function unit_manage()
	{
		$this->db->query("TRUNCATE TABLE xw_unit_unit");
		$this->db->select("DISTINCT(unit_unitname) as unitname");
		$this->db->from("xw_unit_unit_central");
		$this->db->order_by('unit_unitname','ASC');
		// $this->db->limit(20);
		$result=$this->db->get()->result();
		// echo "<pre>";
		// print_r($result);
		// die();
		foreach ($result as $kr => $val) {
			$unitarr=array(
				'unit_unitname'=>$val->unitname);
			$this->db->insert('unit_unit',$unitarr);
			$lastId=$this->db->insert_id();
			if(!empty($lastId)){
				$this->db->update('xw_unit_unit_central',array('new_id'=>$lastId),array('unit_unitname'=>$val->unitname));
				echo $val->unitname.' is added with id:'.$lastId.' And Update Into Central Table<br>';
				// echo $val->category.'Is Added with ID:'.$lastId.'<br>';

				$this->db->select("*");
					$this->db->from("xw_unit_unit_central");
					$this->db->where('new_id',$lastId);
					$this->db->order_by('unit_unitid','ASC');
					$this->db->limit(1);
					// $this->db->limit(20);
					$result_data=$this->db->get()->row();
					// echo "<pre>";
					// print_r(($result_data));
					// echo "---------------<br>";
					if($result_data){
						$arr_cat=array();
						foreach ($result_data as $kdr => $rval) {
							// echo $kdr.'=>'.$rval.'<br>';
							$arr_cat[$kdr]=$rval;
						}
						if(!empty($arr_cat)){
						unset($arr_cat['unit_unitid']);
						unset($arr_cat['id']);
						unset($arr_cat['new_id']);
						
						$this->db->update('unit_unit',$arr_cat,array('unit_unitid'=>$lastId));
						$rw=$this->db->affected_rows();
							if($rw){
								echo "Updated complete on xw_unit_unit table also! <br>";
							}
						}
					
					}

					echo "------------------------------------------------<br>";
					flush();
					ob_flush();
			}

		}
	}

	public function item_manage_rec()
	{
		$this->db->query("TRUNCATE TABLE xw_itli_itemslist");
		$this->db->select("DISTINCT(itli_itemname) as itemname");
		$this->db->from("xw_itli_itemslist_central");
		$this->db->order_by('itli_itemname','ASC');
		// $this->db->limit(20);
		$result=$this->db->get()->result();
		// echo "<pre>";
		// print_r($result);
		// die();
		foreach ($result as $kr => $val) {
			$unitarr=array(
				'itli_itemname'=>$val->itemname);
			$this->db->insert('itli_itemslist',$unitarr);
			$lastId=$this->db->insert_id();
			if(!empty($lastId)){
				$this->db->update('xw_itli_itemslist_central',array('new_id'=>$lastId),array('itli_itemname'=>$val->itemname));
				echo $val->itemname.' is added with id:'.$lastId.' And Update Into Central Table<br>';
				// echo $val->category.'Is Added with ID:'.$lastId.'<br>';

				$this->db->select("*");
					$this->db->from("xw_itli_itemslist_central");
					$this->db->where('new_id',$lastId);
					$this->db->order_by('itli_itemlistid','ASC');
					$this->db->limit(1);
					// $this->db->limit(20);
					$result_data=$this->db->get()->row();
					// echo "<pre>";
					// print_r(($result_data));
					// echo "---------------<br>";
					if($result_data){
						$arr_cat=array();
						foreach ($result_data as $kdr => $rval) {
							// echo $kdr.'=>'.$rval.'<br>';
							$arr_cat[$kdr]=$rval;
						}
						if(!empty($arr_cat)){
						unset($arr_cat['itli_itemlistid']);
						unset($arr_cat['id']);
						unset($arr_cat['new_id']);
						
						$this->db->update('xw_itli_itemslist',$arr_cat,array('itli_itemlistid'=>$lastId));
						$rw=$this->db->affected_rows();
							if($rw){
								echo "Updated complete on xw_itli_itemslist table also! <br>";
							}
						}
					
					}

					echo "------------------------------------------------<br>";
					flush();
					ob_flush();
			}

		}
	}

	public function supplier_manage(){
		$this->db->query("TRUNCATE TABLE xw_dist_distributors");

		$this->db->select("DISTINCT(dist_distributor) as distributor");
		$this->db->from("xw_dist_distributors_central");
		$this->db->order_by('dist_distributorid','ASC');
		// $this->db->limit(20);
		$result=$this->db->get()->result();
		// echo "<pre>";
		// print_r($result);
		// die();
		foreach ($result as $kr => $val) {
			$disarr=array(
				'dist_distributor'=>$val->distributor);
			$this->db->insert('dist_distributors',$disarr);

			$lastId=$this->db->insert_id();
			if(!empty($lastId)){
				$this->db->update('xw_dist_distributors_central',array('new_id'=>$lastId),array('dist_distributor'=>$val->distributor));
				echo $val->distributor.' is added with id:'.$lastId.' And Update Into Central Table<br>';
				// echo $val->category.'Is Added with ID:'.$lastId.'<br>';

				$this->db->select("*");
					$this->db->from("xw_dist_distributors_central");
					$this->db->where('new_id',$lastId);
					$this->db->order_by('dist_distributorid','ASC');
					$this->db->limit(1);
					// $this->db->limit(20);
					$result_data=$this->db->get()->row();
					// echo "<pre>";
					// print_r(($result_data));
					// echo "---------------<br>";
					if($result_data){
						$arr_cat=array();
						foreach ($result_data as $kdr => $rval) {
							// echo $kdr.'=>'.$rval.'<br>';
							$arr_cat[$kdr]=$rval;
						}
						if(!empty($arr_cat)){
						unset($arr_cat['dist_distributorid']);
						unset($arr_cat['id']);
						unset($arr_cat['new_id']);
						
						$this->db->update('xw_dist_distributors',$arr_cat,array('dist_distributorid'=>$lastId));
						$rw=$this->db->affected_rows();
							if($rw){
								echo "Updated complete on xw_dist_distributors table also! <br>";
							}
						}
					
					}

					echo "------------------------------------------------<br>";
					flush();
					ob_flush();
			}

		}
	}


	public function budget_manage(){
		$this->db->query("TRUNCATE TABLE xw_budg_budgets");

		$this->db->select("DISTINCT(budg_budgetname) as budgetname");
		$this->db->from("xw_budg_budgets_central");
		$this->db->order_by('budg_budgetid','ASC');
		// $this->db->limit(20);
		$result=$this->db->get()->result();
		// echo "<pre>";
		// print_r($result);
		// die();
		foreach ($result as $kr => $val) {
			$disarr=array(
				'budg_budgetname'=>$val->budgetname);
			$this->db->insert('budg_budgets',$disarr);

			$lastId=$this->db->insert_id();
			if(!empty($lastId)){
				$this->db->update('xw_budg_budgets_central',array('new_id'=>$lastId),array('budg_budgetname'=>$val->budgetname));
				echo $val->budgetname.' is added with id:'.$lastId.' And Update Into Central Table<br>';
				// echo $val->category.'Is Added with ID:'.$lastId.'<br>';

				$this->db->select("*");
					$this->db->from("xw_budg_budgets_central");
					$this->db->where('new_id',$lastId);
					$this->db->order_by('budg_budgetid','ASC');
					$this->db->limit(1);
					// $this->db->limit(20);
					$result_data=$this->db->get()->row();
					// echo "<pre>";
					// print_r(($result_data));
					// echo "---------------<br>";
					if($result_data){
						$arr_cat=array();
						foreach ($result_data as $kdr => $rval) {
							// echo $kdr.'=>'.$rval.'<br>';
							$arr_cat[$kdr]=$rval;
						}
						if(!empty($arr_cat)){
						unset($arr_cat['budg_budgetid']);
						unset($arr_cat['id']);
						unset($arr_cat['new_id']);
						
						$this->db->update('budg_budgets',$arr_cat,array('budg_budgetid'=>$lastId));
						$rw=$this->db->affected_rows();
							if($rw){
								echo "Updated complete on xw_budg_budgets table also! <br>";
							}
						}
					
					}
				echo "------------------------------------------------<br>";
				flush();
				ob_flush();
			}
		}
	}

	public function department_manage()
	{
		$this->db->query("TRUNCATE TABLE xw_dept_department");

		$this->db->select("DISTINCT(dept_depname) as depname");
		$this->db->from("xw_dept_department_central");
		$this->db->order_by('dept_depid','ASC');
		// $this->db->limit(20);
		$result=$this->db->get()->result();
		// echo "<pre>";
		// print_r($result);
		// die();
		foreach ($result as $kr => $val) {
			$deparr=array(
				'dept_depname'=>$val->depname);
			$this->db->insert('xw_dept_department',$deparr);

			$lastId=$this->db->insert_id();
			if(!empty($lastId)){
				$this->db->update('xw_dept_department_central',array('new_id'=>$lastId),array('dept_depname'=>$val->depname));
				echo $val->depname.' is added with id:'.$lastId.' And Update Into Central Table<br>';
				// echo $val->category.'Is Added with ID:'.$lastId.'<br>';

				$this->db->select("*");
					$this->db->from("xw_dept_department_central");
					$this->db->where('new_id',$lastId);
					$this->db->order_by('dept_depid','ASC');
					$this->db->limit(1);
					// $this->db->limit(20);
					$result_data=$this->db->get()->row();
					// echo "<pre>";
					// print_r(($result_data));
					// echo "---------------<br>";
					if($result_data){
						$arr_dep=array();
						foreach ($result_data as $kdr => $rval) {
							// echo $kdr.'=>'.$rval.'<br>';
							$arr_dep[$kdr]=$rval;
						}
						if(!empty($arr_dep)){
						unset($arr_dep['dept_depid']);
						unset($arr_dep['id']);
						unset($arr_dep['new_id']);
						
						$this->db->update('xw_dept_department',$arr_dep,array('dept_depid'=>$lastId));
						$rw=$this->db->affected_rows();
							if($rw){
								echo "Updated complete on xw_dept_department table also! <br>";
							}
						}
					
					}

					echo "------------------------------------------------<br>";
					flush();
					ob_flush();
			}

		}
	}

		public function category_manage()
	{
		$this->db->query("TRUNCATE TABLE xw_eqca_equipmentcategory");
		$this->db->select("DISTINCT(eqca_category) as category");
		$this->db->from("xw_eqca_equipmentcategory_central");
		$this->db->order_by('eqca_category','ASC');
		// $this->db->limit(20);
		$result=$this->db->get()->result();
		// echo "<pre>";
		// print_r($result);
		// die();
		foreach ($result as $kr => $val) {
			$catarr=array(
				'eqca_category'=>$val->category);
			$this->db->insert('eqca_equipmentcategory',$catarr);
			$lastId=$this->db->insert_id();
			if(!empty($lastId)){
				$this->db->update('xw_eqca_equipmentcategory_central',array('new_id'=>$lastId),array('eqca_category'=>$val->category));
				echo $val->category.' is added with id:'.$lastId.' And Update Into Central Table<br>';
				// echo $val->category.'Is Added with ID:'.$lastId.'<br>';

				$this->db->select("*");
					$this->db->from("xw_eqca_equipmentcategory_central");
					$this->db->where('new_id',$lastId);
					$this->db->order_by('eqca_equipmentcategoryid','ASC');
					$this->db->limit(1);
					// $this->db->limit(20);
					$result_data=$this->db->get()->row();
					// echo "<pre>";
					// print_r(($result_data));
					// echo "---------------<br>";
					if($result_data){
						$arr_cat=array();
						foreach ($result_data as $kdr => $rval) {
							// echo $kdr.'=>'.$rval.'<br>';
							$arr_cat[$kdr]=$rval;
						}
						if(!empty($arr_cat)){
						unset($arr_cat['eqca_equipmentcategoryid']);
						unset($arr_cat['id']);
						unset($arr_cat['new_id']);
						
						$this->db->update('eqca_equipmentcategory',$arr_cat,array('eqca_equipmentcategoryid'=>$lastId));
						$rw=$this->db->affected_rows();
							if($rw){
								echo "Updated complete on xw_eqca_equipmentcategory table also! <br>";
							}
						}
					
					}

					echo "------------------------------------------------<br>";
					flush();
					ob_flush();
			}

		}
	}


	public function update_category_unit_on_item(){

		$this->db->select("DISTINCT(it.new_id) as itemnewid,it.itli_unitid as unitid,ut.new_id as unit_newid ");
		$this->db->from("xw_itli_itemslist_central it");
		$this->db->join("xw_unit_unit_central ut",'ut.id=it.itli_unitid');
		$this->db->group_by("it.new_id");
		$result=$this->db->get()->result();
		// echo "<pre>";
		// print_r($result);
		// die();


		// $this->db->select('*');
		// $this->db->from('xw_unit_unit_central');
		// $result=$this->db->get()->result();
		// echo "<pre>";
		// print_r($result);
		// die();
		if(!empty($result)){
				echo "-----------------Start Item Data Manage ----------------------<br>";
			foreach ($result as $key => $val) {
				$this->db->update('itli_itemslist',array('itli_unitid'=>$val->unit_newid),array('itli_itemlistid'=>$val->itemnewid));
			$rw=$this->db->affected_rows();
				if($rw){
					echo "Updated Unit ID from ".$val->unitid." to ".$val->unit_newid." <br>";
					flush();
					ob_flush();
				}
			}
			echo "------------------End Item Data Manage -------------------------<br>";
		}


		$this->db->select("DISTINCT(it.new_id) as itemnewid,it.itli_catid as old_catid,eq.new_id as cat_newid ");
		$this->db->from("xw_itli_itemslist_central it");
		$this->db->join("xw_eqca_equipmentcategory_central eq",'eq.id=it.itli_catid');
		$this->db->group_by("it.new_id");
		$eqca_cat_result=$this->db->get()->result();
		// echo "<pre>";
		// print_r($eqca_cat_result);
		// die();

			if(!empty($eqca_cat_result)){
					echo "<br>------------------Equipment Category Start-------------------------";
			foreach ($eqca_cat_result as $kc => $rval) {
				$this->db->update('itli_itemslist',array('itli_catid'=>$rval->cat_newid),array('itli_itemlistid'=>$rval->itemnewid));
				// echo $this->db->last_query();
			$rw=$this->db->affected_rows();
				if($rw){
					echo "Updated Category ID from ".$rval->old_catid." to ".$rval->cat_newid." <br>";
					flush();
					ob_flush();
				}
			}
			echo "<br>------------------Equipment Category End-------------------------";
		}
	}

	public function synch_table(){
	$this->synch_similar_table_into_original_table('xw_unit_unit_central');
	$this->synch_similar_table_into_original_table('xw_eqca_equipmentcategory_central');
	$this->synch_similar_table_into_original_table('xw_itli_itemslist_central');
	$this->synch_similar_table_into_original_table('xw_dist_distributors_central');
	$this->synch_similar_table_into_original_table('xw_dept_department_central');
	$this->synch_similar_table_into_original_table('xw_budg_budgets_central');
	$this->synch_similar_table_into_original_table('xw_trma_transactionmain_central');
	$this->synch_similar_table_into_original_table('xw_trde_transactiondetail_central');
	$this->synch_similar_table_into_original_table('xw_pure_purchaserequisition_central');
	$this->synch_similar_table_into_original_table('xw_purd_purchasereqdetail_central');
	$this->synch_similar_table_into_original_table('xw_puor_purchaseordermaster_central');
	$this->synch_similar_table_into_original_table('xw_pude_purchaseorderdetail_central');
	$this->synch_similar_table_into_original_table('xw_purr_purchasereturn_central');
	$this->synch_similar_table_into_original_table('xw_prde_purchasereturndetail_central');
	$this->synch_similar_table_into_original_table('xw_recm_receivedmaster_central');
	$this->synch_similar_table_into_original_table('xw_recd_receiveddetail_central');
	$this->synch_similar_table_into_original_table('xw_rema_returnmaster_central');
	$this->synch_similar_table_into_original_table('xw_rede_returndetail_central');
	$this->synch_similar_table_into_original_table('xw_sama_salemaster_central');
	$this->synch_similar_table_into_original_table('xw_sade_saledetail_central');

}

	public function synch_similar_table_into_original_table($tablename)
	{
		$orginal_table=str_replace('_central', '', $tablename);

		$this->db->select('*');
		$this->db->from($tablename);
		// $this->db->limit(10);
		$result=$this->db->get()->result();


		if(!empty($result)){
			 $dtable=array();
			$column_field=$result[0];
			if(!empty($column_field)){
				foreach ($result as $kr => $rval) {
					foreach ($column_field as $kcol => $col) {
					 $dfield[$kcol]=$rval->{$kcol};
					 unset($dfield['id']);
					}
					 $dtable[]=$dfield;
         			
				}

				if(!empty($dtable)){
					$this->db->query("TRUNCATE TABLE $orginal_table");
					$this->db->insert_batch($orginal_table,$dtable);

					echo '<strong>'.$tablename.'</strong> Table is synch to <strong>'.$orginal_table.'</strong> Completed <br>';
					flush();
					ob_flush();
				}
			}
			
			// foreach ($result as $kr => $val) {
			// 	# code...
			// }
		}
	}

	public function update_masterid_into_detail_table()
	{
		$this->update_trans_detail_tbl("xw_trde_transactiondetail_central","xw_trma_transactionmain_central","trde_trmaid,trde_locationid,trde_trdeid","id,trma_locationid","trma_trmaid");
		$this->update_trans_detail_tbl("xw_purd_purchasereqdetail_central","xw_pure_purchaserequisition_central","purd_reqid,purd_locationid,purd_reqdetid","id,pure_locationid","pure_purchasereqid");

		$this->update_trans_detail_tbl("xw_pude_purchaseorderdetail_central","xw_puor_purchaseordermaster_central","pude_purchasemasterid,pude_locationid,pude_puordeid","id,puor_locationid","puor_purchaseordermasterid");

		$this->update_trans_detail_tbl("xw_prde_purchasereturndetail_central","xw_purr_purchasereturn_central","prde_purchasereturnid,prde_locationid,prde_purchasereturndetailid","id,purr_locationid","purr_purchasereturnid");

		$this->update_trans_detail_tbl("xw_recd_receiveddetail_central","xw_recm_receivedmaster_central","recd_receivedmasterid,recd_locationid,recd_receiveddetailid","id,recm_locationid","recm_receivedmasterid");

		$this->update_trans_detail_tbl("xw_rede_returndetail_central","xw_rema_returnmaster_central","rede_returnmasterid,rede_locationid,rede_returndetailid","id,rema_locationid","rema_returnmasterid");

		$this->update_trans_detail_tbl("xw_sade_saledetail_central","xw_sama_salemaster_central","sade_salemasterid,sade_locationid,sade_saledetailid","id,sama_locationid","sama_salemasterid");

		$this->update_trans_detail_tbl("xw_sade_saledetail_central","xw_sama_salemaster_central","sade_salemasterid,sade_locationid,sade_saledetailid","id,sama_locationid","sama_salemasterid");



	}


	public function update_trans_detail_tbl($tblname_detail,$tablename_master,$selcolm_dtl,$srchcolm,$selcomn_mster)
	{
		$orginal_table=str_replace('_central', '', $tblname_detail);
		$selarr=explode(',', $selcolm_dtl);
		$srcharr=explode(',', $srchcolm);

		// echo $tablename;
		// echo $selcolm;
		// die();
		$this->db->select($selcolm_dtl);
		$this->db->from($tblname_detail);
		// $this->db->limit(1);
		$result=$this->db->get()->result();
		// echo "<pre>";
		// print_r($result);
		// die();
		if(!empty($result)){
			$searcharr=array();
			foreach ($result as $kr => $rv) {
				$searcharr[$srcharr[0]]=$rv->{$selarr[0]};
				$searcharr[$srcharr[1]]=$rv->{$selarr[1]};
				// print_r($searcharr);
				// die();


				$this->db->select($selcomn_mster);
					$this->db->from($tablename_master);
					$this->db->where($searcharr);
					$mainid=$this->db->get()->row();
					// echo $this->db->last_query();
					// die();
					if(!empty($mainid)){
						$update_arr=array();
						$masterid=$mainid->{$selcomn_mster};
						// echo $tr_mainid->trma_trmaid.'<br>';
						$update_arr[$selarr[0]]=$masterid;
						// $searcharr[$selarr[]]
						$update_srch=array();
						$update_srch[$selarr[1]]=$rv->{$selarr[1]};
						$update_srch[$selarr[2]]=$rv->{$selarr[2]};

						$this->db->update($orginal_table,$update_arr,$update_srch);
						// echo $this->db->last_query();
						$rw=$this->db->affected_rows();
						if($rw){
							echo "Updated Table <strong>".$orginal_table."</strong> Master ID  from ".$rv->{$selarr[0]}." to ".$masterid." <br>";
							flush();
							ob_flush();
						}
					}
			}
		}

	}


	public function update_new_itemid_on_table()
	{
		$this->purchase_req_detail();
		$this->purchase_order_detail();
		$this->purchase_return_detail();
		$this->received_detail();
		$this->transaction_detail();
		$this->sales_detail();

	}


	public function purchase_req_detail(){
		
		$this->query("DROP TABLE IF EXISTS temp_purchasereqdetail;
		CREATE TABLE temp_purchasereqdetail
		AS 
		SELECT purd_reqdetid,
		purd_itemsid,
		id as old_itemid,
		new_id
		from  xw_purd_purchasereqdetail pd 
		LEFT JOIN xw_itli_itemslist_central
		il on il.id=purd_itemsid;");
	}
	public function purchase_order_detail(){
		
		$this->query("DROP TABLE IF EXISTS temp_purchaseorderdetail;
		CREATE TABLE temp_purchaseorderdetail
		AS 
		SELECT pude_puordeid,
		pude_itemsid,
		id as old_itemid,
		new_id
		from  xw_pude_purchaseorderdetail pd 
		LEFT JOIN xw_itli_itemslist_central
		il on il.id=pude_itemsid;");

	}

	

	public function purchase_return_detail(){
		$this->query("DROP TABLE IF EXISTS temp_purchasereturndetail;
		CREATE TABLE temp_purchasereturndetail
		AS SELECT prde_purchasereturndetailid,
		prde_itemsid,
		id as old_itemid,
		new_id
		from  xw_prde_purchasereturndetail pr 
		LEFT JOIN xw_itli_itemslist_central
		il on il.id=prde_itemsid;");
	}

	public function received_detail(){
		$this->query("DROP TABLE IF EXISTS `temp_receiveddetail`;
		CREATE TABLE temp_receiveddetail
		AS 
		SELECT recd_receiveddetailid,
		recd_itemsid,
		id as old_itemid,
		new_id
		from  xw_recd_receiveddetail rc 
		LEFT JOIN xw_itli_itemslist_central
		il on il.id=recd_itemsid;");
	}
	public function transaction_detail(){
			$this->query("DROP TABLE IF EXISTS `temp_transactiondetail`;
	CREATE TABLE temp_transactiondetail
		AS
		SELECT trde_trdeid,
		trde_itemsid,
		id as old_itemid,
		new_id
		from  xw_trde_transactiondetail td 
		LEFT JOIN xw_itli_itemslist_central
		il on il.id=trde_itemsid;");
		}

	public function sales_detail(){
		$this->query("DROP TABLE IF EXISTS `temp_saledetail`;
		CREATE TABLE temp_saledetail
		AS
		SELECT sade_saledetailid,
		sade_itemsid,
		id as old_itemid,
		new_id
		from  xw_sade_saledetail sd 
		LEFT JOIN xw_itli_itemslist_central
		il on il.id=sade_itemsid;");
	}



	public function update_all_item_on_table()
	{
		$this->update_item_on_table('xw_trde_transactiondetail_central','trde_itemsid','trde_locationid');
		$this->update_item_on_table('xw_purd_purchasereqdetail_central','purd_itemsid','purd_locationid');

		$this->update_item_on_table('xw_recd_receiveddetail_central','recd_itemsid','recd_locationid');
		$this->update_item_on_table('xw_prde_purchasereturndetail_central','prde_itemsid','prde_locationid');
		$this->update_item_on_table('xw_rede_returndetail_central','rede_itemsid','rede_locationid');

		// $this->update_item_on_table('xw_sade_saledetail_central','sade_itemsid','sade_locationid');

		$this->update_item_on_table('xw_sade_saledetail_central','sade_itemsid','sade_locationid');


	}

	public function update_item_on_table($dtl_tablname,$item,$location)
	{
		$orginal_table=str_replace('_central', '', $dtl_tablname);

		$this->db->select("DISTINCT($item) as itemid,$location as locationid, it.new_id");
		$this->db->from($dtl_tablname.' as tc');
		$this->db->join("xw_itli_itemslist_central it",'it.id=tc.'.$item.' AND it.itli_locationid=tc.'.$location);
		$this->db->group_by($item.','.$location);
		$this->db->order_by($item,'ASC');
		$rslt_items=$this->db->get()->result();
		echo $this->db->last_query();
		die();
		// echo "<pre>";
		// print_r($rslt_items);
		// die();

		if(!empty($rslt_items)){

			foreach ($rslt_items as $key => $rv) {
				$update_item=array();
				$whr_arr=array();
				$update_item[$item]=$rv->new_id;
				$whr_arr[$item]=$rv->itemid;
				$whr_arr[$location]=$rv->locationid;

				$this->db->update($orginal_table,$update_item,$whr_arr);
				// echo $this->db->last_query();
				// echo "<br>";
				$rw=$this->db->affected_rows();
					if($rw){
						echo "Updated Table <strong>".$orginal_table."</strong> Item ID  from ".$rv->itemid." to ".$rv->new_id." <br>";
						flush();
						ob_flush();
					}

			}
		}

	}

	public function update_supplier_on_all_table(){
		$this->update_common_supplier_on_table('xw_puor_purchaseordermaster_central','puor_supplierid','puor_locationid');
		$this->update_common_supplier_on_table('xw_recm_receivedmaster_central','recm_supplierid','recm_locationid');
		$this->update_common_supplier_on_table('xw_purr_purchasereturn_central','purr_supplierid','purr_locationid');

	}

	public function update_common_supplier_on_table($dtl_tablname,$suppcol,$location)
	{
		$orginal_table=str_replace('_central', '', $dtl_tablname);
		$this->db->select("DISTINCT($suppcol) as supplierid,$location as locationid, dc.new_id");
		$this->db->from($dtl_tablname.' as tc');
		$this->db->join("xw_dist_distributors_central dc",'dc.id=tc.'.$suppcol.' AND dc.dist_locationid=tc.'.$location);
		$this->db->group_by($suppcol.','.$location);
		$this->db->order_by($suppcol,'ASC');
		$rslt_supplier=$this->db->get()->result();

		// echo "<pre>";
		// print_r($rslt_supplier);
		// die();

		if(!empty($rslt_supplier)){

			foreach ($rslt_supplier as $key => $rv) {
				$update_sup=array();
				$whr_arr=array();
				$update_sup[$suppcol]=$rv->new_id;
				$whr_arr[$suppcol]=$rv->supplierid;
				$whr_arr[$location]=$rv->locationid;

				$this->db->update($orginal_table,$update_sup,$whr_arr);
				// echo $this->db->last_query();
				// echo "<br>";
				$rw=$this->db->affected_rows();
					if($rw){
						echo "Updated Table <strong>".$orginal_table."</strong> Supplier ID  from ".$rv->supplierid." to ".$rv->new_id." <br>";
						flush();
						ob_flush();
					}

			}
		}
		
	}


	public function update_budget_on_all_table(){
		$this->update_common_budget_on_table('xw_recm_receivedmaster_central','recm_budgetid','recm_locationid');
		$this->update_common_budget_on_table('xw_puor_purchaseordermaster_central','puor_budgetid','puor_locationid');


	}

	public function update_common_budget_on_table($dtl_tablname,$budgetcol,$location){
		$orginal_table=str_replace('_central', '', $dtl_tablname);
		$this->db->select("DISTINCT($budgetcol) as budgetid,$location as locationid, dc.new_id");
		$this->db->from($dtl_tablname.' as tc');
		$this->db->join("xw_budg_budgets_central dc",'dc.id=tc.'.$budgetcol.' AND dc.budg_locationid=tc.'.$location);
		$this->db->where("$budgetcol !=0");
		$this->db->group_by($budgetcol.','.$location);
		$this->db->order_by($budgetcol,'ASC');
		$rslt_budget=$this->db->get()->result();

		// echo "<pre>";
		// print_r($rslt_budget);
		// die();

		if(!empty($rslt_budget)){

			foreach ($rslt_budget as $key => $rv) {
				$update_sup=array();
				$whr_arr=array();
				$update_sup[$budgetcol]=$rv->new_id;
				$whr_arr[$budgetcol]=$rv->budgetid;
				$whr_arr[$location]=$rv->locationid;

				$this->db->update($orginal_table,$update_sup,$whr_arr);
				// echo $this->db->last_query();
				// echo "<br>";
				$rw=$this->db->affected_rows();
					if($rw){
						echo "Updated Table <strong>".$orginal_table."</strong> Supplier ID  from ".$rv->budgetid." to ".$rv->new_id." <br>";
						flush();
						ob_flush();
					}

			}
		}
	}


	public function replace_all_table_column_with_masterid()
	{
		$this->update_common_replace_primary_id_on_table('xw_puor_purchaseordermaster_central','xw_recm_receivedmaster_central','puor_purchaseordermasterid','recm_purchaseordermasterid','puor_locationid','recm_locationid','recm_receivedmasterid');
		$this->update_common_replace_primary_id_on_table('xw_pude_purchaseorderdetail_central','xw_recd_receiveddetail_central','pude_puordeid','recd_purchaseorderdetailid','pude_locationid','recd_locationid','recd_receiveddetailid');
		
		$this->update_common_replace_primary_id_on_table('xw_trde_transactiondetail_central','xw_sade_saledetail_central','trde_trdeid','sade_mattransdetailid','trde_locationid','sade_locationid','sade_saledetailid');
	}

	
	public function update_common_replace_primary_id_on_table($pri_tablname,$sec_tblname,$primarycol,$secondarycol,$primarylocation,$secondarylocation,$sec_primaryid){

			$orginal_sec_table=str_replace('_central', '', $sec_tblname);

				$this->db->select("pt.id,pt.".$primarycol.' as pcol,st.'.$secondarycol.' as scol,'.$primarycol.' as pri_primaryid ,'.$sec_primaryid.' as secprimaryid');
				$this->db->from($sec_tblname.' as st');
				$this->db->join($pri_tablname.' as pt','pt.id='.'st.'.$secondarycol. ' AND  pt.'.$primarylocation .'= st.'.$secondarylocation );
				$this->db->where('st.'.$secondarycol.' !=0 OR st.'.$secondarycol.' IS NOT NULL ');
				// $this->db->limit(1000);
				$result=$this->db->get()->result();

				// echo $this->db->last_query();
				// echo "<pre>";
				// print_r($result);
				// die();
				if(!empty($result)){

					foreach ($result as $kr => $rval){
						$update_arr=array();
						$searchcol=array();
						$update_arr[$secondarycol]=$rval->pri_primaryid;
						$searchcol[$sec_primaryid]=$rval->secprimaryid;
						 	// [id] => 1
						
				    //         [pcol] => 1
				    //         [scol] => 1
				    //         [pri_primaryid] => 1
				    //         [secprimaryid] => 118

				            $this->db->update($orginal_sec_table,$update_arr,$searchcol);
				            // echo $this->db->last_query();
				            $rw=$this->db->affected_rows();
				            // echo $this->db->last_query();
				            // echo "<br>";
				            if($rw){
								echo "Updated Table <strong>".$orginal_sec_table."</strong> ".$secondarycol." ID  from ".$rval->scol." to ".$rval->pri_primaryid." <br>";
								flush();
								ob_flush();
								}
				            
					}
				}
				

	}


	public function update_all_table_organization_id()

	{

		$orgid=3;

		$locationid=1;

			$query=$this->db->query("UPDATE xw_budg_budgets set budg_orgid=$orgid,budg_locationid=$locationid;
				UPDATE xw_unit_unit set unit_orgid=$orgid,unit_locationid=$locationid;
				UPDATE xw_itli_itemslist set itli_orgid=$orgid,itli_locationid=$locationid;
				UPDATE xw_dept_department set dept_orgid=$orgid,dept_locationid=$locationid;
				UPDATE xw_dist_distributors set dist_orgid=$orgid,dist_locationid=$locationid;
				UPDATE xw_eqca_equipmentcategory set eqca_orgid=$orgid,eqca_locationid=$locationid;

				UPDATE xw_rema_reqmaster set rema_orgid=$orgid,rema_locationid=$locationid;
				UPDATE xw_rede_reqdetail set rede_orgid=$orgid,rede_locationid=$locationid;
				UPDATE xw_sama_salemaster set sama_orgid=$orgid,sama_locationid=$locationid;
				UPDATE xw_sade_saledetail set sade_orgid=$orgid,sade_locationid=$locationid;

				UPDATE xw_pure_purchaserequisition set pure_orgid=3, pure_locationid=$locationid;
				UPDATE xw_purd_purchasereqdetail set purd_orgid=$orgid,purd_locationid=$locationid;

				UPDATE xw_pude_purchaseorderdetail set pude_orgid=$orgid,pude_locationid=$locationid;
				UPDATE xw_puor_purchaseordermaster set puor_orgid=$orgid,puor_locationid=$locationid;

				UPDATE xw_purr_purchasereturn set purr_orgid=$orgid,purr_locationid=$locationid;
				UPDATE xw_prde_purchasereturndetail set prde_orgid=$orgid,prde_locationid=$locationid;

				UPDATE xw_trde_transactiondetail set trde_orgid=$orgid,trde_locationid=$locationid;
				UPDATE xw_trma_transactionmain set trma_orgid=$orgid,trma_locationid=$locationid;

				UPDATE xw_recd_receiveddetail set recd_orgid=$orgid,recd_locationid=$locationid;
				UPDATE xw_recm_receivedmaster set recm_orgid=$orgid,recm_locationid=$locationid;

				UPDATE xw_rema_returnmaster set rema_orgid=$orgid,rema_locationid=$locationid;
				UPDATE xw_rede_returndetail set rede_orgid=$orgid,rede_locationid=$locationid;

");

		

		// return false;

		//echo $this->db->last_query(); die;

		

	}


	public function update_item_on_purchase_req_detail_table()
	{
		$result=$this->db->query("SELECT * FROM temp_purchasereqdetail ORDER BY purd_reqdetid ASC")->result();
		// echo "<pre>";
		// print_r($result);
		// die();
		$updatearr=array();
		if(!empty($result)){
			foreach ($result as $key => $rslt) {
				$updatearr[]=array(
					'purd_reqdetid'=>$rslt->purd_reqdetid,
		            'purd_itemsid'=>$rslt->new_itemid
		            
				);
			}
			if(!empty($updatearr)){
				$this->db->update_batch('purd_purchasereqdetail',$updatearr, 'purd_reqdetid'); 
			}

			
		}


	}

	public function update_item_on_purchase_order_detail_table()
	{
		$result=$this->db->query("SELECT * FROM temp_purchaseorderdetail ORDER BY pude_puordeid ASC")->result();
		// echo "<pre>";
		// print_r($result);
		// die();
		$updatearr=array();
		if(!empty($result)){
			foreach ($result as $key => $rslt) {
				$updatearr[]=array(
					'pude_puordeid'=>$rslt->pude_puordeid,
		            'pude_itemsid'=>$rslt->new_itemid
		            
				);
			}
			if(!empty($updatearr)){
				$this->db->update_batch('pude_purchaseorderdetail',$updatearr, 'pude_puordeid'); 
			}
		}
	}


	public function update_item_on_received_detail_table()
	{
		$result=$this->db->query("SELECT * FROM temp_receiveddetail ORDER BY recd_receiveddetailid ASC")->result();
		// echo "<pre>";
		// print_r($result);
		// die();
		$updatearr=array();
		if(!empty($result)){
			foreach ($result as $key => $rslt) {
				$updatearr[]=array(
					'recd_receiveddetailid'=>$rslt->recd_receiveddetailid,
		            'recd_itemsid'=>$rslt->new_itemid
		            
				);
			}
			if(!empty($updatearr)){
				$this->db->update_batch('recd_receiveddetail',$updatearr, 'recd_receiveddetailid'); 
			}
		}
	}

public function update_item_on_transaction_detail_table()
	{
		$result=$this->db->query("SELECT * FROM temp_transactiondetail ORDER BY trde_trdeid ASC")->result();
		// echo "<pre>";
		// print_r($result);
		// die();
		$updatearr=array();
		if(!empty($result)){
			foreach ($result as $key => $rslt) {
				$updatearr[]=array(
					'trde_trdeid'=>$rslt->trde_trdeid,
		            'trde_itemsid'=>$rslt->new_itemid
		            
				);
			}
			if(!empty($updatearr)){
				$this->db->update_batch('trde_transactiondetail',$updatearr, 'trde_trdeid'); 
			}
		}
	}


public function update_item_on_sales_detail_table()
	{
		$result=$this->db->query("SELECT * FROM temp_saledetail ORDER BY sade_saledetailid ASC")->result();
		// echo "<pre>";
		// print_r($result);
		// die();
		$updatearr=array();
		if(!empty($result)){
			foreach ($result as $key => $rslt) {
				$updatearr[]=array(
					'sade_saledetailid'=>$rslt->sade_saledetailid,
		            'sade_itemsid'=>$rslt->new_itemid
		            
				);
			}
			if(!empty($updatearr)){
				$this->db->update_batch('sade_saledetail',$updatearr, 'sade_saledetailid'); 
			}
		}
	}


public function update_item_on_purchase_return_detail_table()
	{
		$result=$this->db->query("SELECT * FROM temp_purchasereturndetail ORDER BY prde_purchasereturndetailid ASC")->result();
		// echo "<pre>";
		// print_r($result);
		// die();
		$updatearr=array();
		if(!empty($result)){
			foreach ($result as $key => $rslt) {
				$updatearr[]=array(
					'prde_purchasereturndetailid'=>$rslt->prde_purchasereturndetailid,
		            'prde_itemsid'=>$rslt->new_itemid
		            
				);
			}
			if(!empty($updatearr)){
				$this->db->update_batch('prde_purchasereturndetail_central',$updatearr, 'prde_purchasereturndetailid'); 
			}
		}
	}

}






/* End of file welcome.php */

/* Location: ./application/controllers/welcome.php */