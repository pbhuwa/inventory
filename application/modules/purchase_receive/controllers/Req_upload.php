<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Req_upload extends CI_Controller
{
	function __construct()
	{
			
		parent::__construct();
		$this->load->Model('req_upload_mdl');
		$this->load->library('excel');
		$this->locationid = $this->session->userdata(LOCATION_ID);
		$this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
        $this->orgid=$this->session->userdata(ORG_ID);

	}

	public function index()
	{  
		$this->data['current_tab'] = 'req_upload_form';
        $upload_no= $this->data['upload_no'] = $this->generate_uploadno(); 
        // print_r($upload_no);
        // die();
		// $upload_no = $this->data['upload_no'] = $this->general->get_tbl_data('MAX(reum_uploadno) as reqmax','reum_requploadmaster',false,'reum_uploadno','DESC');

		$this->data['supplier_all'] = $this->general->get_tbl_data('*','dist_distributors',false,'dist_distributorid','DESC');

		$this->data['fiscal'] = $this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','DESC');

		$this->data['loadselect2'] = 'no';

		$id=$this->input->post('id');
		if(!empty($id))
			{
			$this->data['quotation_data']=$this->req_upload_mdl->get_all_quotation(array('quma_quotationmasterid'=>$id));
			$this->data['current_stock']='quotation';
			$this->data['quotation_items']=$this->req_upload_mdl->get_all_quotation_items(array('qude_quotationmasterid'=>$id));
		}
		
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
			->build('req_upload/v_common_req_upload_tab', $this->data);
	}

	public function req_upload_correction()
	{

		$this->data['current_tab'] = 'correction_upload_requistion';
		$this->data['fiscal'] = $this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','DESC');
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
			->build('req_upload/v_common_req_upload_tab', $this->data);
	}

	public function search_correction_requisition()
	{
		$this->data=array();
		$requisitionno=$this->input->post('requisitionno');
		$fiscalyear=$this->input->post('fiscalyear');
		$detail_data=array();
		$master_data=$this->req_upload_mdl->get_upload_excel_masterdata();
		if(!empty($master_data)){

			$curstatus=$master_data->reum_status;

			$this->data['masterdata']=$master_data;
			$masterid=!empty($master_data->reum_reumid)?$master_data->reum_reumid:'0';

			$detail_data=$this->req_upload_mdl->get_upload_excel_detaildata(array('reud_reumid'=>$masterid));
	
		// echo "<pre>";
		// print_r($detail_data);
		// die();

		$this->data['master_data']=$master_data;
		$this->data['detail_data']=$detail_data;
		$template = $this->load->view('purchase_receive/req_upload/v_update_upload_form_requisition', $this->data, true);
		if($curstatus=='C'){
				$template='<span class="alert-danger text-danger">Already Cancel this requisition !!!</span>';
			}
	}else{
		$template='<span class="alert-danger text-danger">Record doesnot exit !!!</span>';
	}

	   if($template){
        	 print_r(json_encode(array('status'=>'success','template'=>$template,'message'=>'Successfully Selected')));
       		 exit;
        }
        else{
        	print_r(json_encode(array('status'=>'success','template'=>'','message'=>'Empty Record')));
       		 exit;
        }

	}

	public function correction_upload_requistion_empty()
	{
		$this->data['fiscal'] = $this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','DESC');
		$this->load->view('req_upload/v_req_correction_form',$this->data);
	}
	public function form_req_upload()
	{
		  $upload_no= $this->data['upload_no'] = $this->generate_uploadno();
		// $this->data['upload_no'] = $this->general->get_tbl_data('MAX(reum_uploadno) as reqmax','reum_requploadmaster',false,'reum_uploadno','DESC');

		$this->data['current_tab'] = 'req_upload_form';
		
		$this->data['supplier_all'] = $this->general->get_tbl_data('*','dist_distributors',false,'dist_distributorid','DESC');

		$this->data['fiscal'] = $this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','DESC');

		$val_date=$this->general->add_date(CURDATE_EN,QUOTATION_VALIDATION_PERIOD,'days');
		// echo $val_date;
		// die();
		if(DEFAULT_DATEPICKER=='NP')
		{
			$this->data['valid_date']=$this->general->EngToNepDateConv($val_date);
		}
		else
		{
			$this->data['valid_date']=$val_date;
		}
		$this->data['loadselect2']='yes';
		$this->load->view('req_upload/v_req_upload_form',$this->data);
	}

	public function save_req_upload()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			try {
				if($this->input->post('id'))
				{
					if(MODULES_UPDATE=='N')
					{
					$this->general->permission_denial_message();
					exit;
					}
				}
				else
				{
					if(MODULES_INSERT=='N')
					{
					$this->general->permission_denial_message();
					exit;
					}
				}

				// $this->import_excel_data();

				$this->form_validation->set_rules($this->req_upload_mdl->validate_settings_req_upload);

				if($this->form_validation->run()==TRUE)
				{
					$trans = $this->req_upload_mdl->req_upload_save();
					if($trans)
					{
						print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully')));
						exit;
					}
					else
					{
						print_r(json_encode(array('status'=>'error','message'=>'Operation Failed.')));
						exit;
					}
				}
				else
				{
					print_r(json_encode(array('status'=>'error','message'=>validation_errors())));
						exit;
				}
			
			} catch (Exception $e) {
					print_r(json_encode(array('status'=>'error','message' => $e->getMessage())));
			}
		}else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
			exit;
		}
	}

	public function supplier_rate_entry(){
		$this->data['current_tab'] = 'supplier_rate_entry';
		$this->data['supplier_all'] = $this->general->get_tbl_data('*','dist_distributors',false,'dist_distributor','ASC');
		$this->data['fiscal'] = $this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','DESC',2);
		$this->data['loadselect2'] = 'no';

		// $quotation_supplier = $this->req_upload_mdl->get_suppliers_by_fyear_reqno();
		// $dist = '';
		// if(!empty($quotation_supplier)):
		// 	foreach($quotation_supplier as $supp){
		// 		$dist.= $supp->dist_distributorid.',';
		// 	}
		// endif;
		// $dist = rtrim($dist,',');

		// $dist = explode(',',$dist);
		// $this->data['quotation_supplier'] = $dist;

		$this->data['quotation_supplier'] = array();

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
			->build('req_upload/v_common_req_upload_tab', $this->data);
	}

	public function load_req_upload_for_rate_entry(){
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			try {	
				$this->data['requistion_departments']= '';
				$this->data['detail_list'] = '';
				$this->data['fiscal_yrs']=$this->input->post('fiscalyear');
				// echo $this->fiscal_yrs;
				// die();

				$tempform=$this->load->view('req_upload/v_req_upload_list_modal',$this->data,true);

				if(!empty($tempform))
				{
					print_r(json_encode(array('status'=>'success','message'=>'You Can view','tempform'=>$tempform)));
		            exit;
				}
				else{
					print_r(json_encode(array('status'=>'error','message'=>'Unable to View!!')));
		            exit;
				}
			}
			catch (Exception $e) {
				print_r(json_encode(array('status'=>'error','message' => $e->getMessage())));
			}
		}else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
		exit;
		}
	}

	public function get_req_upload_list_for_modal(){
		if(MODULES_VIEW=='N')
		{
		  	$array=array();
            echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));
            exit;
		}
		
		$fiscalyear= !empty($this->input->get('fiscalyear'))?$this->input->get('fiscalyear'):$this->input->post('fiscalyear');

		$searcharray = array('rm.reum_fyear'=>$fiscalyear);

		$this->data['detail_list'] = '';

		$data = $this->req_upload_mdl->get_req_upload_list_for_modal($searcharray);

	  	$i = 0;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
	  
		  	foreach($data as $row)
		    {
		    	$array[$i]["masterid"] = !empty($row->reum_reumid)?$row->reum_reumid:'';
			    $array[$i]["upload_no"] = !empty($row->reum_uploadno)?$row->reum_uploadno:'';
			    $array[$i]["req_no"] = !empty($row->reum_uploadno)?$row->reum_uploadno:'';
			    $array[$i]["manual_no"] = !empty($row->reum_manualno)?$row->reum_manualno:'';
			    $array[$i]["fiscalyear"] = !empty($row->reum_fyear)?$row->reum_fyear:'';
			    $array[$i]["valid_datead"] = !empty($row->reum_validdatead)?$row->reum_validdatead:'';
			    $array[$i]["valid_datebs"] = !empty($row->reum_validdatebs)?$row->reum_validdatebs:'';
			    $array[$i]["upload_datead"] = !empty($row->reum_postdatead)?$row->reum_postdatead:'';
			    $array[$i]["upload_datebs"] = !empty($row->reum_postdatebs)?$row->reum_postdatebs:'';
			    $i++;
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}

	public function load_req_upload_detail_list($new_order = false){
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$masterid = $this->input->post('masterid');

			$requisitionno = $this->input->post('requisitionno');
			$fiscalyear = $this->input->post('fiscalyear');

			if($requisitionno){
				$detail_list = $this->data['detail_list'] = $this->req_upload_mdl->get_req_upload_detail(array('reum_uploadno'=>$requisitionno,'reum_fyear'=>$fiscalyear));
			}else{
				$detail_list = $this->data['detail_list'] = $this->req_upload_mdl->get_req_upload_detail(array('reum_reumid'=>$masterid));
			}

			// echo "<pre>";
			// print_r($detail_list);
			// die();
			if(!empty($detail_list)){
				$curstatus=!empty($detail_list[0]->reud_status)?$detail_list[0]->reud_status:'';
				if($curstatus=='C'){
						print_r(json_encode(array('status'=>'error','message'=>'This Upload was Cancelled. Please try another!!! ')));
	            exit;
				}
			}

			$this->data['distributor']=$this->general->get_tbl_data('*','dist_distributors',false,'dist_distributor','ASC');

			if(empty($detail_list)){
				$isempty = 'empty';
			}else{
				$isempty = 'not_empty';
			}

			if($new_order == 'new_detail_list'){
				$tempform=$this->load->view('req_upload/v_req_upload_detail_append',$this->data,true);
			}else{
				$tempform=$this->load->view('req_upload/v_req_upload_detail_modal',$this->data,true);
			}

			if(!empty($tempform))
			{
				print_r(json_encode(array('status'=>'success','message'=>'You Can view','tempform'=>$tempform,'isempty'=>$isempty)));
	            exit;
			}
			else{
				print_r(json_encode(array('status'=>'error','message'=>'Unable to View!!')));
	            exit;
			}
		}else{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
			exit;
		}
	}

	public function load_detail_list_req($new_order = false){
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$this->load->model('purchase_order_mdl');
			$requisitionno = $this->input->post('requisitionno');
			$fiscalyear = $this->input->post('fiscalyear');

			$reqmaster_data=$this->general->get_tbl_data('*','pure_purchaserequisition',array('pure_fyear'=>$fiscalyear,'pure_reqno'=>$requisitionno ));

			if(!empty($reqmaster_data))
			{
				$masterid=$reqmaster_data[0]->pure_purchasereqid;

				$this->data['detail_list'] = $this->purchase_order_mdl->get_pur_requisition_details(array('purd_reqid'=>$masterid, 'purd_remqty >'=>0));

				$tempform=$this->load->view('purchase/v_pur_requisition_detail_append_quot',$this->data,true);
			
				if(!empty($tempform))
				{
					print_r(json_encode(array('status'=>'success','message'=>'You Can view','tempform'=>$tempform)));
		            exit;
				}
				else{
					print_r(json_encode(array('status'=>'error','message'=>'Unable to View!!')));
		            exit;
				}
			}
			else
			{
				print_r(json_encode(array('status'=>'error','message'=>'Requisition Number Cannnot Match')));
		            exit;
			}

		}else{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
			exit;
		}
	}

	public function save_supplier_rate_entry()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			try {
				if($this->input->post('id'))
				{
					if(MODULES_UPDATE=='N')
					{
					$this->general->permission_denial_message();
					exit;
					}
				}
				else
				{
					if(MODULES_INSERT=='N')
					{
					$this->general->permission_denial_message();
					exit;
					}
				}

				// $this->import_excel_data();

				$this->form_validation->set_rules($this->req_upload_mdl->validate_supplier_rate_entry);

				if($this->form_validation->run()==TRUE)
				{
					$trans = $this->req_upload_mdl->supplier_rate_entry_save();
					if($trans)
					{
						print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully')));
						exit;
					}
					else
					{
						print_r(json_encode(array('status'=>'error','message'=>'Operation Failed.')));
						exit;
					}
				}
				else
				{
					print_r(json_encode(array('status'=>'error','message'=>validation_errors())));
						exit;
				}
			
			} catch (Exception $e) {
					print_r(json_encode(array('status'=>'error','message' => $e->getMessage())));
			}
		}else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
			exit;
		}
	}

	public function form_supplier_rate_entry()
	{
		$this->data['current_tab'] = 'req_upload_form';
		
		$this->data['supplier_all'] = $this->general->get_tbl_data('*','dist_distributors',false,'dist_distributorid','DESC');

		// $quotation_supplier = $this->req_upload_mdl->get_suppliers_by_fyear_reqno();
		// $dist = '';
		// if(!empty($quotation_supplier)):
		// 	foreach($quotation_supplier as $supp){
		// 		$dist.= $supp->dist_distributorid.',';
		// 	}
		// endif;
		// $dist = rtrim($dist,',');

		// $dist = explode(',',$dist);
		// $this->data['quotation_supplier'] = $dist;

		$this->data['quotation_supplier'] = array();

		$this->data['fiscal'] = $this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','DESC');

		$val_date=$this->general->add_date(CURDATE_EN,QUOTATION_VALIDATION_PERIOD,'days');
		// echo $val_date;
		// die();
		if(DEFAULT_DATEPICKER=='NP')
		{
			$this->data['valid_date']=$this->general->EngToNepDateConv($val_date);
		}
		else
		{
			$this->data['valid_date']=$val_date;
		}
		$this->data['loadselect2']='yes';
		$this->load->view('req_upload/v_supplier_rate_entry_form',$this->data);
	}

	public function load_supplier_list(){
		try{
			$this->data['supplier_all'] = $this->general->get_tbl_data('*','dist_distributors',false,'dist_distributorid','DESC');

			$reqno = $this->input->post('requisitionno');
			$fyear = $this->input->post('fiscalyear');

			if($reqno){
				$quotation_supplier = $this->req_upload_mdl->get_suppliers_by_fyear_reqno($reqno, $fyear);

				$dist = '';
				if(!empty($quotation_supplier)){
					foreach($quotation_supplier as $supp){
						$dist.= $supp->dist_distributorid.',';
					}
				}
				
				$dist = rtrim($dist,',');

				$dist = explode(',',$dist);
				$this->data['quotation_supplier'] = $dist;
			}else{
				$this->data['quotation_supplier'] = array();
			}

			$tempform = $this->load->view('req_upload/v_load_supplier_list',$this->data,true);	

			if(!empty($tempform))
			{
					print_r(json_encode(array('status'=>'success','message'=>'View Open Success','tempform'=>$tempform)));
	            	exit;
			}
			else{
				print_r(json_encode(array('status'=>'error','message'=>'Unable to View!!')));
	            	exit;
			}
			
		}catch(Exception $e){
			throw $e;
		}
	}

public function compare_suplier_rate(){
		$this->data['current_tab'] = 'compare_suplier_rate';
		$this->data['fiscal'] = $this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','DESC');
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
		->build('req_upload/v_common_req_upload_tab', $this->data);
 }

public function supplier_comparitive_search()
 {
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	        $template = $this->supplier_search_common();
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

	public function supplier_search_common()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$this->data['excel_url'] = "purchase_receive/req_upload/supplier_comparision_excel";
			$this->data['pdf_url'] = "purchase_receive/req_upload/supplier_comparision_pdf";
			$this->data['report_title'] = $this->lang->line('quotation_comparitive_table');
	      	$locationid = $this->input->post('locationid');
        	$req_no=$this->input->post('reqno');

        	$fyear=$this->input->post('fyear');
        	$distinct_supplier=$this->req_upload_mdl->distinct_suppliers_req_list(array('urem_uploadno'=>$req_no,'urem_fyear'=>$fyear), false, false, 'urem_supplierid','ASC');

        	// echo $this->db->last_query();
        	// die();
        	// $distinct_supplier=$this->req_upload_mdl->distinct_suppliers_req_list(array('urem_uploadno'=>$req_no,'urem_fyear'=>$fyear),false,false,'urem_supplierid','ASC');
        	// echo "<pre>";
        	// print_r($distinct_supplier);
        	// die();
        	if(empty($distinct_supplier))
        	{
        		return '<p><span class="alert alert-danger text-center">Record Empty!!!</span></p>';
        	}
			// if($locationid):
			// 	$this->data['location']=$this->general->get_tbl_data('*','loca_location',array('loca_locationid'=>$locationid));
			// else:
			// 	$this->data['location'] = 'All';
			// endif;

    if($this->location_ismain=='Y'){
      if($locationid){
				$this->data['location']=$this->general->get_tbl_data('*','loca_location',array('loca_locationid'=>$locationid));
			}else{
				$this->data['location'] = 'All';
			}
        }else{
            $this->db->where('loca_locationid',$this->locationid);

        }
				
			$cond = "";

			$th_sup='';
        	$sumtemp='';
        	$td_item_rate='';
        	if(!empty($distinct_supplier))
        	{
        		foreach ($distinct_supplier as $kds => $sup) {
        		$th_sup.='<th>'.$sup->supp_suppliername.'</th>';
        		$td_item_rate .= 'supp_compare_rate(ured_itemid,'.$sup->urem_supplierid.','.$sup->urem_uploadno.') as sup'.$kds.' ,';
        		}
        	}

        	$sup_column_rate=rtrim($td_item_rate,',');
        	// echo $sup_column_rate;
        	// die();
        	$sup_column_rate .=',supp_compare_rate(ured_itemid,0,'.$req_no.') as minrate';
        	$this->data['th_sup']=$th_sup;
        	$this->data['distinct_supplier']=$distinct_supplier;
        	$distinct_quotation_item=$this->req_upload_mdl->get_distinct_req_items(array('um.urem_uploadno'=>$req_no,'um.urem_fyear'=>$fyear),$sup_column_rate);
        	// echo $this->db->last_query();
        	// die();
        	$this->data['itemwise_quotation_rate']=$distinct_quotation_item;
        	$supplier_summary=$this->req_upload_mdl->get_supplier_req_summary(array('urem_uploadno'=>$req_no,'urem_fyear'=>$fyear));

        	// echo "<pre>";
        	// print_r($supplier_summary);
        	// die();
        	if(!empty($supplier_summary))
        	{
        		foreach ($supplier_summary as $kss => $sum) {
        			$sup_net_total[]=$sum->nettotal;
        			
        		}
        	}
        	$min_net_total=min($sup_net_total);

        	if(!empty($supplier_summary))
        	{
        		foreach ($supplier_summary as $kss => $sum) {
        			$min_style='';
        			if($min_net_total==$sum->nettotal)
        			{
        				$min_style='min_style';
        			}
        		$sumtemp .= '<td align="right" class="'.$min_style.'"><strong>'.$sum->nettotal.'<strong></td>';
        		}
        	}
        	$this->data['sumtemp']=$sumtemp;
        	// echo "<pre>";
        	// print_r($sup_net_total);
        	
        	// echo "<pre>";
        	// print_r($this->data);
        	// die();
			
			$template = $this->load->view('purchase_receive/req_upload/v_supplier_table_comparision', $this->data, true);
	      
	        return $template;
	        exit;
	    }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
	}

	public function supplier_comparision_pdf()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$html = $this->supplier_search_common();
			$filename = 'Supplier_comprision_table_'. date('Y_m_d_H_i_s') . '_.pdf'; 
	        $pdfsize = 'A4-L';

	        //if save and download with default filename, send $filename as parameter
	        $this->general->generate_pdf($html,false,$pdfsize);

	        exit();
	    }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
	}

	public function supplier_comparision_excel()
	{
	    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
		{
			header("Content-Type: application/xls");    
	        header("Content-Disposition: attachment; filename=Supplier_comprision_table_".date('Y_m_d_H_i').".xls");  
	        header("Pragma: no-cache"); 
	        header("Expires: 0");
	        $response = $this->supplier_search_common();
		    if($response){
	        	echo $response;	
	        }
	        return false;

	        echo $response;
	    }
	}

	public function generate_uploadno()

	{

		$reqmax = '';

		$cur_fiscalyear = CUR_FISCALYEAR;

		$get_upload_no = $this->req_upload_mdl->get_upload_no(array('reum_fyear' => $cur_fiscalyear, 'reum_locationid' => $this->locationid));

		if (!empty($get_upload_no)) {

			$reqmax = !empty($get_upload_no[0]->reqmax) ? $get_upload_no[0]->reqmax + 1 : 1;
			// print_r($upload_no);
			// die();
		}

			return $reqmax;
		}

		public function get_upload_no()
	{

		try {
			$fyear=$this->input->post('fyear');

			$cur_fiscalyear = $fyear;

			$upload_no = $this->generate_upload_no($cur_fiscalyear);

			print_r(json_encode(array('status' => 'success', 'upload_no' => $upload_no)));

			exit;
		} catch (Exception $e) {

			echo $e->getMessage();
		}
	}

public function generate_upload_no($cur_fiscalyear)
	{

		$reqmax = '';

		$get_upload_no = $this->req_upload_mdl->get_upload_no(array('reum_fyear' => $cur_fiscalyear, 'reum_locationid' => $this->locationid));

		if (!empty($get_upload_no)) {

			$reqmax = !empty($get_upload_no[0]->reqmax) ? $get_upload_no[0]->reqmax + 1 : 1;
		}

			return $reqmax;
		}

public function update_req_upload()
{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		try {
			
			$trans=$this->req_upload_mdl->update_req_form_data();
		if($trans)
				{
					print_r(json_encode(array('status'=>'success','message'=>'Update Record  Successfully')));
					exit;
				}
				else
				{
					print_r(json_encode(array('status'=>'error','message'=>'Fail to Update Record')));
					exit;
				}

		} catch (Exception $e) {
				print_r(json_encode(array('status'=>'error','message' => $e->getMessage())));
					}
			}else{
				print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
				exit;
		}
}

public function req_upload_cancel()
{
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	try {
		$masterid=$this->input->post('id');
		if(!empty($masterid)){
			$this->db->select('*');
			$this->db->from('reum_requploadmaster as rm');
			$this->db->where('reum_reumid',$masterid);
			$this->db->where('reum_locationid',$this->locationid);
			$masterdata=$this->db->get()->row();
			if(!empty($masterdata)){
				$curstatus=$masterdata->reum_status;
				if($curstatus=='C'){
					print_r(json_encode(array('status' => 'error', 'message' => 'Already Cancel this requistion !!!')));
					exit;
				}else{

					$this->db->update('reum_requploadmaster',array('reum_status'=>'C'),array('reum_reumid'=>$masterid,'reum_locationid'=>$this->locationid));
					$this->db->update('reud_requploaddetail',array('reud_status'=>'C'),array('reud_reumid'=>$masterid,'reud_locationid'=>$this->locationid));
					print_r(json_encode(array('status' => 'success', 'message' => 'Requisition Cancel Successfully!!')));
					exit;
				}
			}

		}
	} catch (Exception $e) {
				print_r(json_encode(array('status'=>'error','message' => $e->getMessage())));
					}
		}else{
				print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
				exit;
		}
}

public function supply_rate_correction($reload=false)
{
	$this->data['loadselect2']='';
	$this->data['current_tab'] = 'upload_supplier_rate_correction';
		$this->data['supplier_all'] = $this->general->get_tbl_data('*','dist_distributors',false,'dist_distributor','ASC');
		$this->data['fiscal'] = $this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','DESC',2);
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
		
		if($reload=='reload'){
			$this->data['loadselect2']='yes';
			$this->load->view('req_upload/v_upload_supplier_rate_correction_form',$this->data);
		}else{
				$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('req_upload/v_common_req_upload_tab', $this->data);
		}
		
}

public function search_supply_rate_correction()
	{
		$this->data=array();
		$requisitionno=$this->input->post('requisitionno');
		$fiscalyear=$this->input->post('fiscalyear');
		$supplierid=$this->input->post('supplierid');
		$detail_data=array();

		$sup_rate_masterdata=$this->req_upload_mdl->search_supply_upload_record_master();
		// echo "<pre>";
		// print_r($sup_rate_masterdata);
		// die();
		$this->data['sup_rate_masterdata']=$sup_rate_masterdata;
		$this->data['sup_rate_detaildata']=array();
		if(!empty($sup_rate_masterdata)){
			$masterid=$sup_rate_masterdata->urem_uremid;
			$curstatus=$sup_rate_masterdata->urem_status;
			if(!empty($masterid)){
			$sup_rate_detaildata=$this->req_upload_mdl->search_supply_upload_record_detail(array('ured_uremid'=>$masterid));
			$this->data['sup_rate_detaildata']=$sup_rate_detaildata;
			}

			// echo "<pre>";
			// print_r($this->data['sup_rate_detaildata']);
			// die();

			if($curstatus=='C'){
				$template='<span class="alert-danger text-danger">Already Cancel this requisition !!!</span>';
			}
			else{

				$template = $this->load->view('purchase_receive/req_upload/v_update_upload_supply_rate_form', $this->data, true);
			}
		}
		else{
			$template='<span class="alert-danger text-danger">Record doesnot exit !!!</span>';
		}

	   if($template){
        	 print_r(json_encode(array('status'=>'success','template'=>$template,'message'=>'Successfully Selected')));
       		 exit;
        }
        else{
        	print_r(json_encode(array('status'=>'success','template'=>'','message'=>'Empty Record')));
       		 exit;
        }

	}

	public function update_supplier_rate_entry()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			try{

			$trans=$this->req_upload_mdl->update_supplier_item_rate();
		if($trans)
				{
					print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully')));
					exit;
				}
				else
				{
					print_r(json_encode(array('status'=>'error','message'=>'Operation Failed.')));
					exit;
				}

		} catch (Exception $e) {
				print_r(json_encode(array('status'=>'error','message' => $e->getMessage())));
					}
		}else{
				print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
				exit;
		}
	}

}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */