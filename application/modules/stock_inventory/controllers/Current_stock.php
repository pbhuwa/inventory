<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Current_stock extends CI_Controller
{
	function __construct()
	{	
		parent::__construct();
		$this->load->Model('current_stock_mdl');
		$this->load->Model('home/home_mdl');
		$this->locationid=$this->session->userdata(LOCATION_ID);
		$this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
		$this->orgid=$this->session->userdata(ORG_ID);
		$this->mattypeid = $this->session->userdata(USER_MAT_TYPEID);
	}

	public function index($type=false)
	{ 
		// echo "test";
		// die();
		$this->data['store_type']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','ASC');
		$this->data['code']=$this->general->get_tbl_data('*','itli_itemslist',false,'itli_itemlistid','ASC');
		$this->data['current_stock']='summary';
		$this->data['material_list']=$this->general->get_tbl_data('*','maty_materialtype',array('maty_isactive'=>"Y"),'maty_materialtypeid','ASC');
		$this->data['category'] = $this->general->get_tbl_data('eqca_equipmentcategoryid,eqca_code,eqca_category','eqca_equipmentcategory',array('eqca_isactive'=>"Y"),'eqca_category','ASC');

		$seo_data='';
		if($seo_data)
		{	//set SEO data
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
			->build('current_stock/v_current_stock_details_main', $this->data);
	}

	public function current_stock_details()
	{
		$this->data['store_type']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','ASC');
		$this->data['code']=$this->general->get_tbl_data('*','itli_itemslist',false,'itli_itemlistid','ASC');
		$this->data['current_stock']='detail';
		$seo_data='';
		if($seo_data)
		{	//set SEO data
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
			->build('current_stock/v_current_stock_details_main', $this->data);
	}

	public function location_wise_item_stock()
	{
		$this->data['store_type']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','ASC');
		
		$this->current_stock_mdl->generate_stock_location();
		$this->data['location']=$this->current_stock_mdl->get_distinct_location_from_store();

		// $this->data['tab_type']='locationstock';
		$this->data['current_stock']='locationstock';
		$seo_data='';
		if($seo_data)
		{	//set SEO data
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
			->build('current_stock/v_current_stock_details_main', $this->data);
			// ->build('issue_consumption/stock_transfer/v_stock_transfer', $this->data);
	}
	public function itemwise_stock_summary()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$this->data['handovermasterid']=$this->input->post('handovermasterid');

			$this->current_stock_mdl->generate_temp_stock_location();
			$this->data['location']=$this->general->get_tbl_data('*','loca_location',array('loca_isactive'=>'Y'));
	  	// echo "<pre>";
	  	// print_r($this->data['location']);
	  	// die();
		$queryloc ='';
	  	foreach ($this->data['location'] as $key => $loca) {
	  		// $queryloc .='(CASE WHEN (trde_locationid = '.$loca->loca_locationid.') THEN SUM(issqty) ELSE 0 END ) AS location'.$loca->loca_locationid.',';
	  			$queryloc .='fn_item_locationwise_stock(tels_itemid,'.$loca->loca_locationid.') as location_'.$loca->loca_locationid.',';
	  	}
	  	// echo $queryloc;
	  	// die();
	  	$queryloc = rtrim($queryloc,',');

	  	$this->data['stock_list_item'] = $this->current_stock_mdl->get_stock_locationwise_lists($queryloc);
	  	// echo "<pre>";
	  	// echo $this->db->last_query();
	  	// die();
	  	unset($this->data['stock_list_item']['totalrecs'] );
	  	unset($this->data['stock_list_item']['totalfilteredrecs'] );
	  	// echo "<pre>";
	  	// print_r($this->data['stock_list_item']);
	  	// die();
	  	// if($this->location_ismain=='Y'){
			$template = $this->load->view('stock_inventory/current_stock/v_location_current_stock_temperory', $this->data, true);
	  	// }
	  	// else{
	  	// 	$template = "<span class='text text-denger'>You Don't Have Permission to Access</span>";
	  	// }
		
		 if($template){

        	 print_r(json_encode(array('status'=>'success','tempform'=>$template,'message'=>'Successfully Selected')));
       		 exit;
        }
        else{
        	print_r(json_encode(array('status'=>'success','tempform'=>'','message'=>'Empty Record')));
       		 exit;
        }

		}else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
	}

	public function search_location_stock_detail_list()
	{
		if(MODULES_VIEW=='N')
		{
			$array=array();
			 // $this->general->permission_denial_message();
			echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));			
			exit;
		}

		if($_SERVER['REQUEST_METHOD'] === 'POST') {
		}
		
		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);
	  	$i = 0;
	  		$queryloc='';
	  	$this->data['location']=$this->current_stock_mdl->get_distinct_location_from_store();
	  	// echo "<pre>";
	  	// print_r($this->data['location']);
	  	// die();
	  	foreach ($this->data['location'] as $key => $loca) {
	  		// $queryloc .='(CASE WHEN (trde_locationid = '.$loca->loca_locationid.') THEN SUM(issqty) ELSE 0 END ) AS location'.$loca->loca_locationid.',';
	  			$queryloc .='fn_item_locationwise_stock(lost_itemid,'.$loca->locid.') as location'.$loca->locid.',';
	  	}
		
		$queryloc = rtrim($queryloc,',');

	  	$data = $this->current_stock_mdl->get_stock_location_lists($queryloc);

		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
	  	
			  	foreach($data as $row)
			    {
			    	if(ITEM_DISPLAY_TYPE=='NP')
			    	{
                		$req_itemname = !empty($row->lost_itemname)?$row->lost_itemname:$row->lost_itemname;
                	}
	                else
	                { 
                    	$req_itemname = !empty($row->lost_itemname)?$row->lost_itemname:'';
                	}
                
			    	$totalallloc=0;	
			   		$array[$i]["sno"] = $i+1;
			   		$array[$i]['itemcode'] = $row->lost_itemcode;
			   		$array[$i]['itemname'] = $req_itemname;
			   		foreach ($this->data['location'] as $key => $locat) {
			   			$rwloc=('location'.$locat->locid);
				   		$array[$i]['location'.$locat->locid] = !empty($row->{$rwloc})?$row->{$rwloc}:''; 
				   		$totalloc= !empty($row->{$rwloc})?$row->{$rwloc}:0;
				   		$totalallloc +=$totalloc;
				   	}
				   	$array[$i]['totalallloc']=$totalallloc;
				    $i++;
			    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}

	public function get_stock_count_total()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		  // print_r($this->input->post()); die();
		  $frmDfrme = !empty($this->input->post('frmDate'))?$this->input->post('frmDate'):CURDATE_NP;
		   !empty($this->input->post('frmDate'))?$this->input->post('frmDate'):CURDATE_NP;!empty($this->input->post('frmdate'))?$this->input->post('frmdate'):CURDATE_NP;
        	$toDate = !empty($this->input->post('todate'))?$this->input->post('todate'):CURDATE_NP;

        	$locationid = !empty($this->input->post('locationid'))?$this->input->post('locationid'):$this->session->userdata(LOCATION_ID);

        	$mat_id = !empty($this->input->post('mat_id'))?$this->input->post('mat_id'):'';
			$store_id = !empty($this->input->post('store_id'))?$this->input->post('store_id'):'';

        	$where = '';
        	if($locationid){
        		$where .= " AND trde_locationid = $locationid";
        	}
        	if($mat_id){
        		$where .=" AND il.itli_materialtypeid =$mat_id";
        	}
        	if($store_id){
        		$where .=" AND tm.trma_fromdepartmentid =$store_id";
        	}

		    $status_count = $this->home_mdl->get_stock_count($where);

		    // echo $this->db->last_query();
		    // die();
		    print_r(json_encode(array('status'=>'success','status_count'=>$status_count)));
		}
	}

	public function search_current_stock_list()
	{
		// if(MODULES_VIEW=='N')
		// 	{
		// 	$array=array();
		// 	echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));			
		// 	exit;
		// 	}
		
		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);
	  	$i = 0;
	  	
	  	$frmDate = !empty($this->input->post('frmDate'))?$this->input->post('frmDate'):CURDATE_NP;
	  	$toDate = !empty($this->input->post('toDate'))?$this->input->post('toDate'):CURDATE_NP;;
	  	
	  	$data = $this->current_stock_mdl->get_current_stock_lists();

		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);

		  	foreach($data as $row)
		    {	
		    	if(ITEM_DISPLAY_TYPE=='NP'){
                	$req_itemname = !empty($row->itli_itemnamenp)?$row->itli_itemnamenp:$row->itli_itemname;
                }else{ 
                    $req_itemname = !empty($row->itli_itemname)?$row->itli_itemname:'';
                }

		    	$remarks = $row->stockrmk;
		    	if($remarks == 'Zero'){
		    		$statusClass = 'danger';
		    		$statusName = 'Out of Stock';
		    	}else if($remarks == 'Limited'){
		    		$statusClass = 'warning';
		    		$statusName = 'Limited';
		    	}else if($remarks == 'Stock'){
		    		$statusClass = 'success';
		    		$statusName = 'Available';
		    	}else{
		    		$statusClass = '';
		    		$statusName = '';
		    	}

		    	$array[$i]["statusClass"] = $statusClass;
		   		$array[$i]["sno"] = $i+1;
		   		$array[$i]['itemcode'] = $row->itli_itemcode;
		   		$array[$i]['itemname'] = $req_itemname;
		   		$array[$i]['unit'] = $row->unit_unitname;
		   		$array[$i]['category'] = $row->eqca_category;
		   		$array[$i]['material'] = $row->maty_material;
		   		$array[$i]['maxlimit'] = $row->itli_maxlimit;
		   		$array[$i]['reorderlevel'] = $row->itli_reorderlevel;
		   		$array[$i]['totalstock'] = (int)$row->totalstock;
		   		$array[$i]['stockrmk'] = $statusName;
		   		$array[$i]['location'] = $row->loca_name;
			    $i++;
		    }
		    // echo "<pre>";print_r($array);die;
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}

	public function exportToExcelList($details=false){
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=all_purchase_item_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");

        $data = $this->current_stock_mdl->get_current_stock_lists();
        $this->data['pdf_details'] = $details;
        $this->data['searchResult'] = $this->current_stock_mdl->get_current_stock_lists();
        
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);

        $response = $this->load->view('current_stock/v_current_stock_list_download', $this->data, true);

        echo $response;
    }

    public function generate_details_pdfList($details=false)
    {	
    	$page_orientation = !empty($_GET['page_orientation']) ? $_GET['page_orientation']  : '';
		if ($page_orientation == 'L') {
			$page_size = 'A4-L';
		} else {
			$page_size = 'A4';
		}
    	unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);
        $this->data['searchResult'] = $this->current_stock_mdl->get_current_stock_lists();
        
        $this->data['pdf_details'] = $details;
        
        $html = $this->load->view('current_stock/v_current_stock_list_download', $this->data, true);
       
        $output = 'all_purchase_item_'.date('Y_m_d_H_i').'.pdf';
        
        $this->general->generate_pdf($html,'',$page_size);

    }

	public function search_current_stock_detail_list()
	{
		if(MODULES_VIEW=='N')
			{
				$array=array();
				 echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));			
				exit;
			}
		$frmDate=!empty($this->input->post('frmDate'))?$this->input->post('frmDate'):CURDATE_NP;
        $toDate = !empty($this->input->post('toDate'))?$this->input->post('toDate'):CURDATE_NP;
        		
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		}
		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);
	  	$i = 0;
	  	//echo"<pre>";print_r($this->input->get());die;
	  
	  	$data = $this->current_stock_mdl->get_location_stock_detail_lists();
	  	// echo"<pre>";print_r($data);die;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];
	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
		  	foreach($data as $row)
		    {	
		    	if(ITEM_DISPLAY_TYPE=='NP'){
                	$req_itemname = !empty($row->itli_itemnamenp)?$row->itli_itemnamenp:$row->itli_itemname;
                }else{ 
                    $req_itemname = !empty($row->itli_itemname)?$row->itli_itemname:'';
                }

		   		$array[$i]["sno"] = $i+1;
		   		$array[$i]['itemcode'] = $row->itli_itemcode;
		   		$array[$i]['itemname'] = $req_itemname;
		   		$array[$i]['unit'] = $row->unit_unitname;
		   		$array[$i]['category'] = $row->eqca_category;
		   		$array[$i]['material'] = $row->maty_material;
		   		$array[$i]['stock_qty'] = sprintf('%g',$row->trde_issueqty);
		   		$array[$i]['trde_unitprice'] = number_format($row->trde_unitprice, 2);
		   		$array[$i]['toal_amount'] = number_format(($row->trde_unitprice) * ($row->trde_issueqty), 2);

		   		if(DEFAULT_DATEPICKER == 'NP'){
		   			$array[$i]['tran_date'] = $row->trde_transactiondatebs;	
		   		}else{
		   			$array[$i]['tran_date'] = $row->trde_transactiondatead;
		   		}
		   		$array[$i]['location'] = $row->loca_name;
		   		$array[$i]['trans_type'] = $row->trde_transactiontype;
		   		
			    $i++;
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}
		
	public function exportToExcel($details=false){
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=all_purchase_item_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");

        $data = $this->current_stock_mdl->get_location_stock_detail_lists();
        $this->data['pdf_details'] = $details;
        $this->data['searchResult'] = $this->current_stock_mdl->get_location_stock_detail_lists();
        
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);

        $response = $this->load->view('current_stock/v_current_stock_details_download', $this->data, true);

        echo $response;
    }
    public function generate_details_pdf($details=false)
    {	
    	$page_orientation = !empty($_GET['page_orientation']) ? $_GET['page_orientation']  : '';
		if ($page_orientation == 'L') {
			$page_size = 'A4-L';
		} else {
			$page_size = 'A4';
		}

    	unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);
        $this->data['searchResult'] = $this->current_stock_mdl->get_location_stock_detail_lists();
        
        $html = $this->load->view('current_stock/v_current_stock_details_download', $this->data, true);
        
        $output = 'all_purchase_item_'.date('Y_m_d_H_i').'.pdf';
        
        $this->general->generate_pdf($html, '',$page_size);
    }

public function stock_report($val=false)
	{
		$this->data['current_stock']='stock_detail';
		$this->data['store']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','ASC');
		$this->data['materialstypecategory']=$this->general->get_tbl_data('*','eqca_equipmentcategory',false,'eqca_category','ASC');

	if (!empty($this->mattypeid)) {

				$srchmat = array('maty_materialtypeid' => $this->mattypeid, 'maty_isactive' => 'Y');
			} else {

				$srchmat = array('maty_isactive' => 'Y');
			}

			$this->data['material_type'] = $this->general->get_tbl_data('maty_materialtypeid,maty_material', 'maty_materialtype', $srchmat, 'maty_materialtypeid', 'ASC');

		// echo "<pre>";
		// print_r($this->data['store_type']);
		// die();

		$seo_data='';
		if($seo_data)
		{	//set SEO data
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
			->build('current_stock/v_current_stock_details_main', $this->data);
	}

    public function current_stock_search()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			  // $fromdate = $this->input->post('fromdate');
     //          $todate = $this->input->post('todate');
     //       echo $fromdate;echo $todate;die;
	        $template = $this->current_stock_search_common();

	        // echo $template; die();
	        if($template)
	        {
	        	 print_r(json_encode(array('status'=>'success','template'=>$template,'message'=>'Successfully Selected')));
	       		 exit;
	        }
	        else
	        {
	        	print_r(json_encode(array('status'=>'success','template'=>'','message'=>'Empty Record')));
	       		 exit;
	        }
	       
	    }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
	}

	public function current_stock_search_common()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$this->data['target_formid'] = "FormreqAnalysis";
			$this->data['excel_url'] = "stock_inventory/current_stock/current_stock_detail_excel";
			$this->data['pdf_url'] = "stock_inventory/current_stock/current_stock_detail_pdf";
			// $this->data['target_formid']='FormreqAnalysis';
			$this->data['report_title'] = $this->lang->line('current_stock_details');
			$this->data['report_title'] .='<br></u> From '.$this->input->post('fromdate').'- '.$this->input->post('todate');
	      	$locationid = $this->input->post('locationid');
        	$st_store_id = $this->input->post('store_id');
        	$report_type = $this->input->post('report_type');
        	$mattypeid=$this->input->post('mattypeid');
			$this->data['mattypeid'] = $mattypeid;
        	if($locationid):
				$this->data['location']=$this->general->get_tbl_data('*','loca_location',array('loca_locationid'=>$locationid));
			else:
				$this->data['location'] = 'All';
			endif;
				
			$cond = "";
			$template = '';
			$this->data['distinct_cat'] = $this->current_stock_mdl->distinct_category();
		 	// echo $this->db->last_query();
		 	// die();
		 	if ($report_type == 'old') {
			$template = $this->load->view('issue_consumption/current_stock/v_current_stock_detail_report', $this->data, true);
		 	}else if ($report_type == 'new'){
			$template = $this->load->view('issue_consumption/current_stock/v_current_stock_detail_report_manmohan', $this->data, true);
		 	}
	      
	        return $template;
	        exit;
	    }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
	}

	public function current_stock_detail_pdf()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$html = $this->current_stock_search_common();

			$filename = 'current_stock_detail_item_'. date('Y_m_d_H_i_s') . '_.pdf'; 
	        $pdfsize = 'A4'; //A4-L for landscape

	        //if save and download with default filename, send $filename as parameter
	        $this->general->generate_pdf($html,'','');

	        exit();
	    }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
	}

	public function current_stock_detail_excel()
	{
        if ($_SERVER['REQUEST_METHOD'] === 'POST') 
		{
			header("Content-Type: application/xls");    
	        header("Content-Disposition: attachment; filename=current_stock_detail_item_".date('Y_m_d_H_i').".xls");  
	        header("Pragma: no-cache"); 
	        header("Expires: 0");

	         $response = $this->current_stock_search_common();
	        if($response){
	        	echo $response;	
	        }
	        return false;

	        echo $response;
	    }
	}

	public function exportToExcelListLocationWise($details=false){
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=all_purchase_item_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");

       	$queryloc='';
	  	$this->data['location']=$this->current_stock_mdl->get_distinct_location_from_store();
	  	// echo "<pre>";
	  	// print_r($this->data['location']);
	  	// die();
	  	foreach ($this->data['location'] as $key => $loca) {
	  		// $queryloc .='(CASE WHEN (trde_locationid = '.$loca->loca_locationid.') THEN SUM(issqty) ELSE 0 END ) AS location'.$loca->loca_locationid.',';
	  			$queryloc .='fn_item_locationwise_stock(lost_itemid,'.$loca->locid.') as location'.$loca->locid.',';
	  	}
		
		$queryloc = rtrim($queryloc,',');

        $this->data['searchResult'] = $this->current_stock_mdl->get_stock_location_lists($queryloc);

        // echo "<pre>";
        // print_r($this->data['searchResult']);
        // die();
        
        $this->data['pdf_details'] = $details;
        
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);

        $response = $this->load->view('current_stock/v_location_wise_item_stock_list_download', $this->data, true);

        echo $response;
    }

    public function generate_details_pdfListLocationWise($details=false)
    {	
    	unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);

       	$queryloc='';
	  	$this->data['location']=$this->current_stock_mdl->get_distinct_location_from_store();
	  	// echo "<pre>";
	  	// print_r($this->data['location']);
	  	// die();
	  	foreach ($this->data['location'] as $key => $loca) {
	  		// $queryloc .='(CASE WHEN (trde_locationid = '.$loca->loca_locationid.') THEN SUM(issqty) ELSE 0 END ) AS location'.$loca->loca_locationid.',';
	  			$queryloc .='fn_item_locationwise_stock(lost_itemid,'.$loca->locid.') as location'.$loca->locid.',';
	  	}
		
		$queryloc = rtrim($queryloc,',');

        $this->data['searchResult'] = $this->current_stock_mdl->get_stock_location_lists($queryloc);

        // echo "<pre>";
        // print_r($this->data['searchResult']);
        // die();
        
        $this->data['pdf_details'] = $details;

        $html = $this->load->view('current_stock/v_location_wise_item_stock_list_download', $this->data, true);
       
        $output = 'all_purchase_item_'.date('Y_m_d_H_i').'.pdf';
        
        $this->general->generate_pdf($html,'','');

    }

}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */