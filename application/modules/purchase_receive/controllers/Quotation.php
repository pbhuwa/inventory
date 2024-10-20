<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Quotation extends CI_Controller
{
	function __construct()
	{
			
		parent::__construct();
		$this->load->Model('quotation_mdl');
		$this->username = $this->session->userdata(USER_NAME);
		$this->userid = $this->session->userdata(USER_ID);
		$this->locationid=$this->session->userdata(LOCATION_ID);

		$this->locationcode='';
		if (defined('LOCATION_CODE')) {
			   	$this->locationcode=$this->session->userdata(LOCATION_CODE);
			}
		$this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
		$this->orgid=$this->session->userdata(ORG_ID);
	}

	public function index($type=false)
	{  
		if($type=='quotation'){
			$vtype='Q';
		}elseif ($type=='tender') {
			$vtype='T';
		}
		$this->data['type']=$vtype;
		// $this->data['quotationno'] = $this->general->get_tbl_data('MAX(quma_quotationmasterid) as quomax','quma_quotationmaster',array('quma_type'=> $vtype),'quma_quotationmasterid','DESC');
		// public function 
		 $this->data['quotationno'] = $this->generate_receiveno();

		// print_r($this->data['quotationno']);die;
		$this->data['supplier_all'] = $this->general->get_tbl_data('*','dist_distributors',false,'dist_distributorid','DESC');

		$this->data['quotation_supplier'] = array();

		$this->data['item_all']=$this->general->get_tbl_data('*','itli_itemslist',false,'itli_itemlistid','DESC');

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
		// echo $this->data['valid_date'];
		// die();

		$this->data['loadselect2']='no';
		$this->data['current_stock']='quotation';
		$id=$this->input->post('id');
		if(!empty($id))
		{
		$this->data['quotation_data']=$this->quotation_mdl->get_all_quotation(array('quma_quotationmasterid'=>$id));
		$this->data['current_stock']='quotation';
		$this->data['quotation_items']=$this->quotation_mdl->get_all_quotation_items(array('qude_quotationmasterid'=>$id));
		$this->data['quotation_supplier'] = array();
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
			->build('quotation/v_common_quotation_tab', $this->data);
	}
	public function form_quotation($vtype=false)
	{
		if($vtype=='Q'){
			$type='quotation';
		}elseif ($vtype=='T') {
			$type='tender';
		}
		$this->data['type']=$vtype;
		// $this->data['quotationno'] = $this->general->get_tbl_data('MAX(quma_quotationmasterid) as quomax','quma_quotationmaster',array('quma_type'=> $vtype),'quma_quotationmasterid','DESC');
		 $this->data['quotationno'] = $this->generate_receiveno();
		$this->data['current_stock']='quotation';
		
		$this->data['supplier_all'] = $this->general->get_tbl_data('*','dist_distributors',false,'dist_distributorid','DESC');

		$this->data['quotation_supplier'] = array();

		$this->data['item_all']=$this->general->get_tbl_data('*','itli_itemslist',false,'itli_itemlistid','DESC');

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
		$this->load->view('quotation/v_quotation_form',$this->data);
	}

	public function save_quotation()
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

			$this->form_validation->set_rules($this->quotation_mdl->validate_settings_quotation);
			if($this->form_validation->run()==TRUE)
			{
				$trans = $this->quotation_mdl->quotation_save();
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

	public function form_purchases(){
		$this->data['form_title'] = 'Purchase Invoice';
		
		$this->data['supplier_all'] = $this->general->get_tbl_data('*','dist_distributors',false,'dist_distributorid','DESC');

		$this->data['quotation_supplier'] = array();

		$this->data['item_all']=$this->general->get_tbl_data('*','itli_itemslist',false,'itli_itemlistid','DESC');

		$this->data['loadselect2']='yes';
		$this->load->view('quotation/v_common_quotation_tab', $this->data);
	}

	public function quotation_book($type=false){
		$this->data=array();
		if($type=='quotation'){
			$vtype='Q';
		}else {
			$vtype='T';
		}
		$this->data = $this->quotation_mdl->get_all_quotation_list();
		$this->data['current_stock']="quotation_book";
		$this->data['type']=$vtype;
		$seo_data='';
		if($seo_data){
				//set SEO data
				$this->page_title = $seo_data->page_title;
				$this->data['meta_keys']= $seo_data->meta_key;
				$this->data['meta_desc']= $seo_data->meta_description;
			}else{
				//set SEO data
		    	$this->page_title = ORGA_NAME;
		    	$this->data['meta_keys']= ORGA_NAME;
		    	$this->data['meta_desc']= ORGA_NAME;
			}

			$this->template
				->set_layout('general')
				->enable_parser(FALSE)
				->title($this->page_title)
				->build('quotation/v_common_quotation_tab', $this->data);
	}

	public function get_quotation_book_list(){
		try{
			if(MODULES_VIEW=='N')
			{
				$array=array();

				// $this->general->permission_denial_message();
				 echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));			
				exit;
			}

      		$data = $this->quotation_mdl->get_all_quotation_list();

			$i = 0;
			$array = array();

			$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
			$totalrecs = $data["totalrecs"];

		    unset($data["totalfilteredrecs"]);
		  	unset($data["totalrecs"]);

		  	// echo "<pre>";
		  	// print_r($data);
		  	// die();
		  	foreach($data as $key=>$row){
		  		$array[$i]['sno'] = $i;
		  		$array[$i]['quma_reqno'] = !empty($row->quma_reqno)?$row->quma_reqno:'';
		  		$array[$i]['quma_quotationnumber'] = !empty($row->quma_quotationnumber)?$row->quma_quotationnumber:'';

		  		$array[$i]['supp_suppliername'] = !empty($row->supp_suppliername)?$row->supp_suppliername:'';
		  		if(DEFAULT_DATEPICKER=='NP')
		  		{
		  		$array[$i]['quma_quotationdate'] = !empty($row->quma_quotationdatebs)?$row->quma_quotationdatebs:'';
		  		$array[$i]['quma_supplierquotationdate'] = !empty($row->quma_supplierquotationdatebs)?$row->quma_supplierquotationdatebs:'';
		  		$array[$i]['expdatebs'] = !empty($row->quma_expdatebs)?$row->quma_expdatebs:'';
		  		$array[$i]['valid_date'] =$array[$i]['expdatebs'] ;
		  		}
		  		else
		  		{
		  			$array[$i]['quma_quotationdate'] = !empty($row->quma_quotationdatead)?$row->quma_quotationdatead:'';
		  			$array[$i]['expdatead'] = !empty($row->quma_expdatead)?$row->quma_expdatead:'';
		  			$array[$i]['valid_date'] =$array[$i]['expdatead'] ;
		  			$array[$i]['quma_supplierquotationdate'] = !empty($row->quma_supplierquotationdatead)?$row->quma_supplierquotationdatead:'';
		  		}
		  		
		  		$array[$i]['quma_supplierquotationnumber'] = !empty($row->quma_supplierquotationnumber)?$row->quma_supplierquotationnumber:'';
		  		$array[$i]['quma_totalamount'] = !empty($row->quma_totalamount)?number_format($row->quma_totalamount,2):0;

		  		$disp_var=$this->lang->line('quotation_details');


                 if(MODULES_UPDATE=='Y'){

		  		$editbtn='<a href="javascript:void(0)" data-id='.$row->quma_quotationmasterid.' data-displaydiv="quotationBook" data-viewurl='.base_url('purchase_receive/quotation').' class="redirectedit"><i class="fa fa-edit" title="Edit" aria-hidden="true" ></i></a> ';
		  		}else{
		  			$editbtn='';
		  		} 

		  		$array[$i]['action'] = $editbtn.' | '.'<a href="javascript:void(0)" data-id='.$row->quma_quotationmasterid.' data-displaydiv="" data-viewurl='.base_url('purchase_receive/quotation/quotation_details').' class="view" data-heading="'.$disp_var.'"><i class="fa fa-eye" title="View" aria-hidden="true" ></i></a>';
		  		$i++;
		  	}

			echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));

		}catch(Exception $e){
			throw $e;
		}
	}
	public function generate_pdfQuotation()
    {
        $this->data['searchResult'] = $this->quotation_mdl->get_all_quotation_list();
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);

        $html = $this->load->view('quotation/v_quotation_download', $this->data, true);

      	$filename = 'quotation_'. date('Y_m_d_H_i_s') . '_.pdf'; 
        $pdfsize = 'A4-L'; //A4-L for landscape
        //if save and download with default filename, send $filename as parameter
        $this->general->generate_pdf($html,false,$pdfsize);
        exit();
    }
    public function exportToExcelQuotation(){
    	$dateSearch = $this->input->get('dateSearch');
        //print_r($dateSearch);die;
        $cond='';
        if($dateSearch == "validate")
        {
			$cond =('quma_expdatebs');
        }
        if($dateSearch == "supplierdate")
        {
			$cond =('quma_supplierquotationdatebs');
        }
		if($dateSearch == "quotationdate")
        {
			$cond =('quma_quotationdatebs');
        }
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=quotation_mdl".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");

        $data = $this->quotation_mdl->get_all_quotation_list($cond);

        $this->data['searchResult'] = $this->quotation_mdl->get_all_quotation_list($cond);
        
        $array = array();
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);
        $response = $this->load->view('quotation/v_quotation_download', $this->data, true);


        echo $response;
    }

	public function quotation_details($type = false)
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$mastid_id=$this->input->post('id');
		$vtype = '';
		if($type=='quotation'){
			$vtype='Q';
		}elseif ($type=='tender') {
			$vtype='T';
		}
		$this->data['type']=$vtype;
		$this->data['req_detail_list']=$this->quotation_mdl->get_all_quotation_details(array('qd.qude_quotationmasterid'=>$mastid_id));
		$this->data['req_master']=$this->quotation_mdl->get_all_quotation(array('quma_quotationmasterid'=>$mastid_id));
		// echo "<pre>";print_r($this->data['req_master']);die();
		
		$tempform='';
		$tempform=$this->load->view('quotation/v_quotation_view',$this->data,true);
		if(!empty($tempform))
			{
					print_r(json_encode(array('status'=>'success','message'=>'View Open Success','tempform'=>$tempform)));
	            	exit;
			}
			else{
				print_r(json_encode(array('status'=>'error','message'=>'Unable to View!!')));
	            	exit;
			}
		}
		else
		{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
		exit;
		}
	}

	public function edit_quotation()
	{
		$id=$this->input->post('id');
		$this->data['quotation_data']=$this->quotation_mdl->get_all_quotation(array('quma_quotationmasterid'=>$id));
		$this->data['current_stock']='quotation';
		$this->data['quotation_items']=$this->quotation_mdl->get_all_quotation_items(array('qude_quotationmasterid'=>$id));
		
		$this->data['supplier_all'] = $this->general->get_tbl_data('*','dist_distributors',false,'dist_distributorid','DESC');

		$this->data['quotation_supplier'] = "";

		$this->data['item_all']=$this->general->get_tbl_data('*','itli_itemslist',false,'itli_itemlistid','DESC');
		$this->data['loadselect2']='yes';

		$tempform=$this->load->view('quotation/v_quotation_form',$this->data,true);

		if(!empty($this->data['quotation_data']))
		{
				print_r(json_encode(array('status'=>'success','message'=>'You Can edit','tempform'=>$tempform)));
            	exit;
		}
		else{
			print_r(json_encode(array('status'=>'error','message'=>'Unable to Edit!!')));
            	exit;
		}
	
	}

	public function quotation_comparitive_table($type=false)
	{
		if($type=='quotation'){
			$vtype='Q';
		}elseif ($type=='tender') {
			$vtype='T';
		}
		$this->data['type']=$vtype;
		$this->data['current_stock']='quotation_comp_table';
		$this->data['store']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','ASC');
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
			->build('quotation/v_common_quotation_tab', $this->data);
	}
	
	public function quotation_comparitive_search()
	{
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	        $template = $this->quotation_comparitive_search_common();

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



	public function quotation_comparitive_search_common()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$this->data['excel_url'] = "stock_inventory/current_stock/quotation_comparision_excel";
			$this->data['pdf_url'] = "stock_inventory/current_stock/quotation_comparision_pdf";
			$type=$this->input->post('type');
			if($type=='Q'){
				$this->data['report_title'] = $this->lang->line('quotation_comparitive_table');
			}
			else{
				$this->data['report_title'] = $this->lang->line('tender_comparitive_table');
			}
	      	$locationid = $this->input->post('locationid');
        	$req_no=$this->input->post('req_no');
        	$fyear=$this->input->post('fiscalyear');

        	$distinct_supplier=$this->quotation_mdl->get_all_quotation(array('quma_reqno'=>$req_no,'quma_fyear'=>$fyear,'quma_type'=>$type),false,false,'quma_supplierid','ASC');
        	// echo "<pre>";
        	// print_r($distinct_supplier);
        	// die();
        	// echo "<pre>";
        	// print_r($distinct_quotation_item);
        	// die();
        	if(empty($distinct_supplier))
        	{
        		return '<p><span class="alert alert-danger text-center">Record Empty!!!</span></p>';
        	}

        	$supplier_summary=$this->quotation_mdl->get_supplier_summary(array('quma_reqno'=>$req_no,'quma_fyear'=>$fyear,'quma_type'=>$type));
        	$th_sup='';
        	$sumtemp='';
        	$td_item_rate='';
        	if(!empty($distinct_supplier))
        	{
        		foreach ($distinct_supplier as $kds => $sup) {
        		$th_sup.='<th>'.$sup->supp_suppliername.'</th>';
        		$td_item_rate .= 'quotation_compare(qude_itemsid,'.$sup->quma_supplierid.','.$sup->quma_reqno.') as sup'.$kds.' ,';
        		}
        	}

        	$sup_column_rate=rtrim($td_item_rate,',');
        	// echo $sup_column_rate;
        	// die();
        	$sup_column_rate .=',quotation_compare(qude_itemsid,0,'.$req_no.') as minrate';
        	$this->data['th_sup']=$th_sup;
        	$this->data['distinct_supplier']=$distinct_supplier;
        	$distinct_quotation_item=$this->quotation_mdl->get_distinct_quotation_items(array('qm.quma_reqno'=>$req_no,'qm.quma_fyear'=>$fyear),$sup_column_rate);
        	// echo $this->db->last_query();
        	// die();
        	if(!empty($supplier_summary))
        	{
        		foreach ($supplier_summary as $kss => $sum) {
        		$sumtemp .= '<th>'.$sum->nettotal.'</th>';
        		}
        	}
        	$this->data['sumtemp']=$sumtemp;

        	$this->data['itemwise_quotation_rate']=$distinct_quotation_item;
        
        	if($locationid):
				$this->data['location']=$this->general->get_tbl_data('*','loca_location',array('loca_locationid'=>$locationid));
			else:
				$this->data['location'] = 'All';
			endif;
				
			$cond = "";
			
			$template = $this->load->view('purchase_receive/quotation/v_quotation_table_comparision', $this->data, true);
	      
	        return $template;
	        exit;
	    }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
	}

	public function quotation_comparision_pdf()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$html = $this->quotation_comparitive_search_common();

			$filename = 'current_stock_detail_item_'. date('Y_m_d_H_i_s') . '_.pdf'; 
	        $pdfsize = 'A4'; //A4-L for landscape

	        //if save and download with default filename, send $filename as parameter
	        $this->general->generate_pdf($html,false,$pdfsize);

	        exit();
	    }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
	}

	

	public function quotation_comparision_excel()
	{
        if ($_SERVER['REQUEST_METHOD'] === 'POST') 
		{
			header("Content-Type: application/xls");    
	        header("Content-Disposition: attachment; filename=current_stock_detail_item_".date('Y_m_d_H_i').".xls");  
	        header("Pragma: no-cache"); 
	        header("Expires: 0");

	         $response = $this->quotation_comparitive_search_common();
	        if($response){
	        	echo $response;	
	        }
	        return false;


	        echo $response;
	    }
	}

	public function load_supplier_list(){
		try{
			$this->data['supplier_all'] = $this->general->get_tbl_data('*','dist_distributors',false,'dist_distributorid','DESC');

			$reqno = $this->input->post('requisitionno');
			$fyear = $this->input->post('fiscalyear');

			if($reqno){
				$quotation_supplier = $this->quotation_mdl->get_suppliers_by_fyear_reqno($reqno, $fyear);

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

			$tempform = $this->load->view('quotation/v_load_supplier_list',$this->data,true);	

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
	public function generate_receiveno()
	{
	  	$curmnth=CURMONTH;
	  	if($curmnth==1)
	  	{
	  		$prefix='A';
	  	}
	  	if($curmnth==2)
	  	{
	  		$prefix='B';
	  	}
	  	if($curmnth==3)
	  	{
	  		$prefix='C';
	  	}
	  	if($curmnth==4)
	  	{
	  		$prefix='D';
	  	}
	  	if($curmnth==5)
	  	{
	  		$prefix='E';
	  	}
	  	if($curmnth==6)
	  	{
	  		$prefix='F';
	  	}
	  	if($curmnth==7)
	  	{
	  		$prefix='G';
	  	}
	  	if($curmnth==8)
	  	{
	  		$prefix='H';
	  	}
	  	if($curmnth==9)
	  	{
	  		$prefix='I';
	  	}
	  	if($curmnth==10)
	  	{
	  		$prefix='J';
	  	}
	  	if($curmnth==11)
	  	{
	  		$prefix='K';
	  	}
	  	if($curmnth==12)
	  	{
	  		$prefix='L';
	  	}

	  	$this->db->select('quma_quotationnumber');
	  	$this->db->from('quma_quotationmaster');
	  	$this->db->where('quma_quotationnumber LIKE '.'"%'.RECEIVED_NO_PREFIX.$prefix.'%"');
	  	$this->db->where('quma_locationid',$this->locationid);
	  	$this->db->limit(1);
	  	$this->db->order_by('quma_quotationnumber','DESC');
	  	$query = $this->db->get();
	          // echo $this->db->last_query(); die();
	  	$invoiceno=1;
	  	$dbinvoiceno='';
		
		if ($query->num_rows() > 0) 
		{
		    $dbinvoiceno=$query->row()->quma_quotationnumber;         
		}
		if(!empty($dbinvoiceno))
		{
			  $invoiceno=$this->general->stringseperator($dbinvoiceno,'number');
		}

		$nw_invoice = str_pad($invoiceno + 1, RECEIVED_NO_LENGTH, 0, STR_PAD_LEFT);

		// echo RECEIVED_NO_PREFIX;
		// die();

		if(defined('SHOW_FORM_NO_WITH_LOCATION')){
	      	if(SHOW_FORM_NO_WITH_LOCATION == 'Y'){
	      		return $this->locationcode.'-'.RECEIVED_NO_PREFIX.$prefix.$nw_invoice;	
	      	}else{
	      		return RECEIVED_NO_PREFIX.$prefix.$nw_invoice;
	      	}
	    }else{
	     	return RECEIVED_NO_PREFIX.$prefix.$nw_invoice;
	    }
    }

}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */