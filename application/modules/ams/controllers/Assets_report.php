<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

ini_set('max_execution_time', 50000);

class Assets_report extends CI_Controller 

{

	function __construct() 

	{  

		parent::__construct();

		$this->load->model('assets_mdl');

		$this->load->model('assets_report_mdl');

	    $this->load->Model('settings/department_mdl','department_mdl');

	    $this->load->Model('biomedical/manufacturers_mdl');

	}     

	public function index(){ 

		// echo "Asd";

		// die();

		$this->data['status']=$this->assets_mdl->get_status();

		$this->data['condition']=$this->assets_mdl->get_condition();

		$this->data['lease_company']=$this->general->get_tbl_data('*','leco_leasocompany',array('leco_isactive'=>'Y'));

       $this->data['department_list']=$this->general->get_tbl_data('*','dept_department',false);

       $this->data['assetentry_list']=array();

       $this->data['manufacturers']=$this->manufacturers_mdl->get_all_manufacturers();

       $this->data['insurance_company']=$this->general->get_tbl_data('*','inco_insurancecompany',array('inco_isactive'=>'Y'));

       $this->data['frequency']=$this->general->get_tbl_data('*','frty_frequencytype',array('frty_isactive'=>'Y'));

       $this->data['desposal'] = $this->general->get_tbl_data('*','dety_desposaltype');

       $this->data['distributors']=$this->general->get_tbl_data('*','dist_distributors',array('dist_isactive'=>'Y'));

       $this->data['receiver_list'] = $this->general->get_tbl_data('*','stin_staffinfo',array('stin_jobstatus' => 'Y'));

        // echo "<pre>";

		// print_r($this->data);

		// die();

		$this->db->select('*');

	    $this->db->from('eqca_equipmentcategory ec');

	    $this->db->where('eqca_isnonexp','Y');

	    $result=$this->db->get()->result();

		$this->data['material']= $result;

		$this->data['tab_type']="assets_report";

		$this->page_title='Fix Assets Report';

		$this->template

			->set_layout('general')

			->enable_parser(FALSE)

			->title($this->page_title)

			->build('assets_report/v_report_main', $this->data);

	}

	public function assets_register_report()

	{

		$this->data['tab_type']="assets_register";

		$this->page_title='Assets Register Report';

		$this->template

			->set_layout('general')

			->enable_parser(FALSE)

			->title($this->page_title)

			->build('assets_report/v_report_main', $this->data);

	}

	public function get_assets_register_report()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	      	$html = $this->get_assets_register_common();

		  	if($html)

		  	{

		  		$template=$html;

		  	}

	        print_r(json_encode(array('status'=>'success','template'=>$template,'message'=>'Successfully Selected')));

	        exit;

	    }else{

        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

        	exit;

        }

	}

	public function get_assets_register_common(){

		$this->data['assets_reglist']=$this->assets_report_mdl->get_assets_register_rpt();

		// echo "<pre>";

		// print_r($this->data);

		// die();

	    $view=$this->load->view('ams/assets_report/v_assets_register_report',$this->data,true);

	    return $view;

	} 

	public function assets_ledger_summary()

	{

		$this->data['tab_type']="assets_ledger";

		$this->page_title='Assets Ledger Report';

		$this->template

			->set_layout('general')

			->enable_parser(FALSE)

			->title($this->page_title)

			->build('assets_report/v_report_main', $this->data);

	}

	public function get_assets_ledger_report(){

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	      	$html = $this->get_assets_ledger_common();

		  	if($html)

		  	{

		  		$template=$html;

		  	}

	        print_r(json_encode(array('status'=>'success','template'=>$template,'message'=>'Successfully Selected')));

	        exit;

	    }else{

        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

        	exit;

        }

	}

	public function get_assets_ledger_common(){

		$this->data='';

	    $view=$this->load->view('ams/assets_report/v_assets_ledger_report',$this->data,true);

	    return $view;

	}

	public function fix_assets_detail()

	{

		$this->data['tab_type']="fix_assets";

		$this->page_title='Fix Assets Report';

		$this->template

			->set_layout('general')

			->enable_parser(FALSE)

			->title($this->page_title)

			->build('assets_report/v_report_main', $this->data);

	}

	public function get_assets_fix_report(){

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	      	$html = $this->get_assets_fix_common();

		  	if($html)

		  	{

		  		$template=$html;

		  	}

	        print_r(json_encode(array('status'=>'success','template'=>$template,'message'=>'Successfully Selected')));

	        exit;

	    }else{

        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

        	exit;

        }

	}

	public function get_assets_fix_common(){

		$this->data='';

	    $view=$this->load->view('ams/assets_report/v_assets_fix_report',$this->data,true);

	    return $view;

	}

	public function search_assets()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				if(ORGANIZATION_NAME=='KU' || ORGANIZATION_NAME=='ARMY' ){
				   $html = $this->get_search_assets_report_ku();					
				}
				else{
					$html = $this->get_search_assets_report();						
				}

			   if($html)

			   {

				   $template=$html;

			   }

			 print_r(json_encode(array('status'=>'success','template'=>$template,'message'=>'Successfully Selected')));

			 exit;

		 }else{

			 print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

			 exit;

		 }

	}

	public function search_lease()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$this->data['excel_url'] = "ams/assets_report/asset_lease_report_excel";

			$this->data['pdf_url'] = "ams/assets_report/asset_lease_report_pdf";

			$this->data['report_title'] = "Asset Lease Report";

			$this->data['asset_lease_report'] = $this->assets_report_mdl->get_asset_lease_report();

			$template=$this->load->view('assets_report/assets_report_pages/v_assets_lease_report_template',$this->data,true);

			if(empty($template)){

				$template  ='<span class="col-sm-12 alert alert-danger text-center">No Record Found!!!</span>';

			}

			print_r(json_encode(array('status'=>'success','template'=>$template,'message'=>'Successfully Selected')));

			exit;

		}else{

			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

			exit;

		}

	}

	public function search_insurance()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$this->data['excel_url'] = "ams/assets_report/asset_insurance_report_excel";

			$this->data['pdf_url'] = "ams/assets_report/asset_insurance_report_pdf";

			$this->data['report_title'] = "Asset Insurance Report";

			$this->data['asset_insurance_report'] = $this->assets_report_mdl->get_asset_insurance_report();

			$template=$this->load->view('assets_report/assets_report_pages/v_assets_insurance_report_template',$this->data,true);

			if(empty($template)){ 

				$template  ='<span class="col-sm-12 alert alert-danger text-center">No Record Found!!!</span>';

			}

			print_r(json_encode(array('status'=>'success','template'=>$template,'message'=>'Successfully Selected')));

			exit;

		}else{

			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

			exit;

		}

	}

	public function search_maintenance()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$this->data['excel_url'] = "ams/assets_report/asset_maintenance_report_excel";

			$this->data['pdf_url'] = "ams/assets_report/asset_maintenance_report_pdf";

			$this->data['report_title'] = "Asset Maintenance Report";

			$this->data['asset_maintenance_report'] = $this->assets_report_mdl->get_asset_maintenance_report();

			$template=$this->load->view('assets_report/assets_report_pages/v_assets_maintenance_report_template',$this->data,true);

			if(empty($template)){ 

				$template  ='<span class="col-sm-12 alert alert-danger text-center">No Record Found!!!</span>';

			}

			print_r(json_encode(array('status'=>'success','template'=>$template,'message'=>'Successfully Selected')));

			exit;

		}else{

			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

			exit;

		}

	}

	public function search_disposal()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$this->data['excel_url'] = "ams/assets_report/asset_disposal_report_excel";

			$this->data['pdf_url'] = "ams/assets_report/asset_disposal_report_pdf";

			$this->data['report_title'] = "Asset Disposal Report";

			$this->data['asset_disposal_report'] = $this->assets_report_mdl->get_asset_disposal_report();

			$template=$this->load->view('assets_report/assets_report_pages/v_assets_disposal_report_template',$this->data,true);

			if(empty($template)){ 

				$template  ='<span class="col-sm-12 alert alert-danger text-center">No Record Found!!!</span>';

			}

			print_r(json_encode(array('status'=>'success','template'=>$template,'message'=>'Successfully Selected')));

			exit;

		}else{

			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

			exit;

		}

	}

	public function get_search_assets_report()

    {

    	if ($_SERVER['REQUEST_METHOD'] === 'POST') 

    	{

    		$this->data['excel_url'] = "ams/assets_report/asset_entry_report_excel";

			$this->data['pdf_url'] = "ams/assets_report/asset_entry_report_pdf";

			$this->data['report_title'] = "Asset Entry Report";

			$department = $this->input->post('department');

    		$asset_category = $this->input->post('asset_category');

	      	$asset_status = $this->input->post('asset_status');

	      	$asset_condition = $this->input->post('asset_condition');

			$wise_type = $this->input->post('wise_type');

			if($wise_type == "department"){

				if(!empty($department)){

					$this->data['department_wise_data'] = $this->assets_report_mdl->distinct_department_list(array('asen_depid'=>$department));

				}else{

					$this->data['department_wise_data'] = $this->assets_report_mdl->distinct_department_list(false);

				}

				// echo "<pre>";

				// print_r($this->data['department_wise_data']);

				// die();

				$this->data['report_title'] = "Asset Entry Department Wise Report";

				$html=$this->load->view('assets_report/assets_report_pages/v_assets_entry_department_wise_report',$this->data,true);

			}else if($wise_type == "category"){

				if(!empty($asset_category) ){

					$this->data['category_wise_data'] = $this->assets_report_mdl->distinct_category_list(array('asen_assettype'=>$asset_category));

				}else{

					$this->data['category_wise_data'] = $this->assets_report_mdl->distinct_category_list(false);

				}

				// echo "<pre>";

				// print_r($this->data['category_wise_data']);

				// die();

				$this->data['report_title'] = "Asset Entry Category Wise Report";

				$html=$this->load->view('assets_report/assets_report_pages/v_assets_entry_category_wise_report',$this->data,true);

			}else if($wise_type == 'status'){

				if(!empty($asset_status)){

					$this->data['status_wise_data'] = $this->assets_report_mdl->distinct_status_list(array('asen_status'=>$asset_status));

				}else{

					$this->data['status_wise_data'] = $this->assets_report_mdl->distinct_status_list(false);

				}

				$this->data['report_title'] = "Asset Entry Status Wise Report";

				$html=$this->load->view('assets_report/assets_report_pages/v_assets_entry_status_wise_report',$this->data,true);

			}else if($wise_type == 'condition'){

				if(!empty($asset_condition)){

					$this->data['condition_wise_data'] = $this->assets_report_mdl->distinct_condition_list(array('asen_condition'=>$asset_condition));

				}else{

					$this->data['condition_wise_data'] = $this->assets_report_mdl->distinct_condition_list(false);

				}

				$this->data['report_title'] = "Asset Entry Condition Wise Report";

				$html=$this->load->view('assets_report/assets_report_pages/v_assets_entry_condition_wise_report',$this->data,true);

			}

			if(!empty($html)){ 

				return $html;

			}else{

				$html='<span class="col-sm-12 alert alert-danger text-center">No Record Found!!!</span>';

				return $html;

			}

    	}

    	else

    	{

		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

		exit;

        }

    }

	public function asset_entry_report_pdf()
	  { 
	      if(ORGANIZATION_NAME=='KU'){
				   $html = $this->get_search_assets_report_ku();					
				}
				else{
					$html = $this->get_search_assets_report();						
				}

	    //echo $this->db->last_query(); die;
				$porientation=$this->input->post('page_orientation');
				if($porientation=='L'){
					$page_type='A4-L';
				}else{
					$page_type='A4';
				}
	        $filename = 'categories_wise_issue_'. date('Y_m_d_H_i_s') . '_.pdf'; 
	        $pdfsize = $page_type; //A4-L for landscape //if save and download with default filename, send $filename as parameter
	        
	        $this->general->generate_pdf($html,false,$pdfsize);
	  }

	  public function asset_entry_report_excel()
	  { 
	  	 $exporttype = $this->input->post('exporttype');
		  	if ($exporttype == 'word') {
		      header("Content-type: application/vnd.ms-word");
		      header("Content-Disposition: attachment;Filename=Assets_list" . date(' Y_m_d_H_i') . ".doc");
		    } else {
		      header("Content-Type: application/xls");
		      header("Content-Disposition: attachment; filename=Assets_list" . date(' Y_m_d_H_i') . ".xls");
		    }

	        header("Pragma: no-cache"); 
	        header("Expires: 0");
	        if(ORGANIZATION_NAME=='KU'){
				   $response = $this->get_search_assets_report_ku();					
				}
				else{
					$response = $this->get_search_assets_report();						
				}

	      // $response = $this->search_purchase_received_report_common();
	      if($response){
	          echo $response; 
	        }
	        return false;
	  }

    public function get_search_assets_report_ku()

    {

    	if ($_SERVER['REQUEST_METHOD'] === 'POST') 

    	{

    		$this->data['excel_url'] = "ams/assets_report/asset_entry_report_excel";

			$this->data['pdf_url'] = "ams/assets_report/asset_entry_report_pdf";

			$this->data['report_title'] = "Asset Entry Report";

			$this->data['target_formid'] = 'asset_search_form';

			$schoolid=$this->input->post('school');

			$department = $this->input->post('departmentid');

    		$asset_category = $this->input->post('asset_category');

	      	$asset_status = $this->input->post('asset_status');

	      	$asset_condition = $this->input->post('asset_condition');

			$asen_staffid=$this->input->post('asen_staffid');

			$rpt_type=$this->input->post('report_type');
			
			$wise_type = $this->input->post('wise_type');
			$asen_distributor=$this->input->post('asen_distributor');

			if($wise_type=='default'){
				if($rpt_type=='summary'){
		       
		        $this->data['report_result']=$this->assets_report_mdl->get_assets_summary_report_ku();
		        $html = $this->load->view('assets_report/assets_report_pages/ku/v_assets_default_summary_report', $this->data, true);
		        }else{
		        $this->data['report_result']=$this->assets_report_mdl->get_assets_detail_report_ku();
		        // echo "<pre>";
		        // echo $this->db->last_query();
		        // print_r($this->data['report_result']);
		        // die();
	          	$html = $this->load->view('assets_report/assets_report_pages/ku/v_assets_default_detail_report', $this->data, true);
		        }
		      
			}

			elseif($wise_type=='items'){
				if($rpt_type=='summary'){
					$this->data['report_result']=$this->assets_report_mdl->get_assets_summary_report_ku();
		        	// echo "<pre>";
		        	// print_r($this->data['report_result']);
		        	// die();
		        $html = $this->load->view('assets_report/assets_report_pages/ku/v_assets_default_summary_report', $this->data, true);

				}else{
					$this->data['report_result']=$this->assets_report_mdl->get_assets_item_detail_ku();
		        	// echo "<pre>";
		        	// print_r($this->data['report_result']);
		        	// die();
		        $html = $this->load->view('assets_report/assets_report_pages/ku/v_assets_items_detail_report', $this->data, true);
				}

			}
			elseif($wise_type=='school'){
				if($rpt_type=='summary'){
				$this->data['report_result']=$this->assets_report_mdl->get_assets_summary_report_ku();
				// echo $this->db->last_query();
				// die();

		        $html = $this->load->view('assets_report/assets_report_pages/ku/v_assets_default_summary_report', $this->data, true);

				}else{
					$this->data['report_result']=$this->assets_report_mdl->get_assets_school_detail_ku();
				$this->data['report_title'] = "Asset Entry School Wise Report";
		  	
		        $html = $this->load->view('assets_report/assets_report_pages/ku/v_assets_school_detail_report', $this->data, true);
				}

			}			 
			elseif($wise_type=='department'){
				if($rpt_type=='summary'){
				$this->data['report_result']=$this->assets_report_mdl->get_assets_summary_report_ku();
				// echo $this->db->last_query();
				// echo"<pre>";
				// print_r($this->data['report_result']);
				// die();
				// die();
		        $html = $this->load->view('assets_report/assets_report_pages/ku/v_assets_default_summary_report', $this->data, true);

				}else{
					$this->data['report_result']=$this->assets_report_mdl->get_assets_department_detail_ku();
				$this->data['report_title'] = "Asset Entry Department Wise Report";
		  
		        $html = $this->load->view('assets_report/assets_report_pages/ku/v_assets_department_detail_report', $this->data, true);
				}

			}			 
			elseif($wise_type=='category'){
				if($rpt_type=='summary'){
					$this->data['report_result']=$this->assets_report_mdl->get_assets_summary_report_ku();
					// echo $this->db->last_query();
					// die();
			        $html = $this->load->view('assets_report/assets_report_pages/ku/v_assets_default_summary_report', $this->data, true);

				}else{
					$this->data['report_result']=$this->assets_report_mdl->get_assets_category_detail_ku();
					$this->data['report_title'] = "Asset Entry Category Wise Report";
		  
		        $html = $this->load->view('assets_report/assets_report_pages/ku/v_assets_category_detail_report', $this->data, true);
				}

			}
			elseif($wise_type=='department_category'){
				if($schoolid==''){
					   $html='<span class="text-danger">School Field is required</span>';
				}else{
					if($rpt_type=='summary'){
					$this->data['report_result']=$this->assets_report_mdl->get_assets_summary_report_ku();
					// echo $this->db->last_query();
					// // die();
					// echo "<pre>";
					// print_r($this->data['report_result']);
					// die();
			        $html = $this->load->view('assets_report/assets_report_pages/ku/v_assets_summary_department_categoryreport', $this->data, true);

				}else{
					$html='<span class="text-danger">Report is available for Summary Only</span>';
				}
				}
			}	 
			elseif($wise_type=='category_items'){
				if($schoolid==''){
					   $html='<span class="text-danger">School Field is required</span>';
				}else{
					if($rpt_type=='summary'){
					$this->data['report_result']=$this->assets_report_mdl->get_assets_summary_report_ku();
					// echo $this->db->last_query();
					// // die();
					// echo "<pre>";
					// print_r($this->data['report_result']);
					// die();
			        $html = $this->load->view('assets_report/assets_report_pages/ku/v_assets_summary_category_itemsreport', $this->data, true);

				}else{
					$html='<span class="text-danger">Report is available for Summary Only</span>';
				}
				}
			
			}	
			
			elseif($wise_type=='supplier'){
				if($rpt_type=='summary'){
					$this->data['report_result']=$this->assets_report_mdl->get_assets_summary_report_ku();
			        $html = $this->load->view('assets_report/assets_report_pages/ku/v_assets_default_summary_report', $this->data, true);

				}else{
					$this->data['report_result']=$this->assets_report_mdl->get_assets_supplier_detail_ku();
					$this->data['report_title'] = "Asset Entry Supplier Wise Report";
		  
		        $html = $this->load->view('assets_report/assets_report_pages/ku/v_assets_supplier_detail_report', $this->data, true);
				}

			}		
			elseif($wise_type=='purchase_date'){
				if($rpt_type=='summary'){
					$this->data['report_result']=$this->assets_report_mdl->get_assets_summary_report_ku();
			        $html = $this->load->view('assets_report/assets_report_pages/ku/v_assets_default_summary_report', $this->data, true);

				}else{
					$this->data['report_result']=$this->assets_report_mdl->get_assets_purchase_date_detail_ku();
					$this->data['report_title'] = "Asset Entry Purchase Date Wise Report";
		  
		        $html = $this->load->view('assets_report/assets_report_pages/ku/v_assets_purchase_date_detail_report', $this->data, true);
				}

			}			 
			elseif($wise_type=='receiver'){
				if($rpt_type=='summary'){
					$this->data['report_result']=$this->assets_report_mdl->get_assets_summary_report_ku();
			        $html = $this->load->view('assets_report/assets_report_pages/ku/v_assets_default_summary_report', $this->data, true);

				}else{
					$this->data['report_result']=$this->assets_report_mdl->get_assets_receiver_detail_ku();
					$this->data['report_title'] = "Asset Entry Receiver Wise Report";
		  
		        $html = $this->load->view('assets_report/assets_report_pages/ku/v_assets_receiver_detail_report', $this->data, true);
				}

			}			 

			// if($wise_type == "department"){

			// 	if(!empty($department)){

			// 		$this->data['department_wise_data'] = $this->assets_report_mdl->distinct_department_list(array('asen_depid'=>$department));

			// 	}else{

			// 		$this->data['department_wise_data'] = $this->assets_report_mdl->distinct_department_list(false);

			// 	}

			// 	$this->data['report_title'] = "Asset Entry Department Wise Report";

			// 	$html=$this->load->view('assets_report/assets_report_pages/v_assets_entry_department_wise_report',$this->data,true);

			// }else if($wise_type == "category"){

			// 	if(!empty($asset_category) ){

			// 		$this->data['category_wise_data'] = $this->assets_report_mdl->distinct_category_list(array('asen_assettype'=>$asset_category));

			// 	}else{

			// 		$this->data['category_wise_data'] = $this->assets_report_mdl->distinct_category_list(false);

			// 	}

			// 	$this->data['report_title'] = "Asset Entry Category Wise Report";

			// 	$html=$this->load->view('assets_report/assets_report_pages/v_assets_entry_category_wise_report',$this->data,true);

			// }else if($wise_type == 'status'){

			// 	if(!empty($asset_status)){

			// 		$this->data['status_wise_data'] = $this->assets_report_mdl->distinct_status_list(array('asen_status'=>$asset_status));

			// 	}else{

			// 		$this->data['status_wise_data'] = $this->assets_report_mdl->distinct_status_list(false);

			// 	}

			// 	$this->data['report_title'] = "Asset Entry Status Wise Report";

			// 	$html=$this->load->view('assets_report/assets_report_pages/v_assets_entry_status_wise_report',$this->data,true);

			// }else if($wise_type == 'condition'){

			// 	if(!empty($asset_condition)){

			// 		$this->data['condition_wise_data'] = $this->assets_report_mdl->distinct_condition_list(array('asen_condition'=>$asset_condition));

			// 	}else{

			// 		$this->data['condition_wise_data'] = $this->assets_report_mdl->distinct_condition_list(false);

			// 	}

			// 	$this->data['report_title'] = "Asset Entry Condition Wise Report";

			// 	$html=$this->load->view('assets_report/assets_report_pages/v_assets_entry_condition_wise_report',$this->data,true);

			// }

			if(!empty($html)){ 

				return $html;

			}else{

				$html='<span class="col-sm-12 alert alert-danger text-center">No Record Found!!!</span>';

				return $html;

			}

    	}

    	else

    	{

		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

		exit;

        }

    }

}

?>