<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Stock_transfer extends CI_Controller
{
	function __construct()
	{
			
		parent::__construct();
		$this->load->Model('stock_transfer_mdl');
		$this->locid = $this->session->userdata(LOCATION_ID);
		$this->storeid = $this->session->userdata(STORE_ID);
		$this->username = $this->session->userdata(USER_NAME);
		$this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
	}
	
	public function index()
	{
		// echo "<pre>";
		// print_r($this->session->userdata());
		// die();
		$this->data['tab_type'] = "entry";

		// print_r($this->location_ismain);
		// die();

		if($this->location_ismain == 'Y'){
			// echo "Test";
			// die();
			$this->data['from_location']=$this->general->get_tbl_data('*','loca_location',false,'loca_locationid','DESC');	
			$this->data['to_location']=$this->general->get_tbl_data('*','loca_location',false,'loca_locationid','DESC');
		}else{
			$this->data['from_location']=$this->general->get_tbl_data('*','loca_location',array('loca_locationid'=>$this->locid),'loca_locationid','DESC');
			$this->data['to_location']=$this->general->get_tbl_data('*','loca_location',false,'loca_locationid','DESC');
		}

		// $this->data['last_transferno'] = $this->general->getLastNo('trma_issueno','trma_transactionmain',array('trma_transactiontype'=>'S.TRANSFER'));
		$this->data['last_transferno'] = $this->general->generate_invoiceno('tfma_tfmaid','tfma_transferinvoice','tfma_transfermain',TRANSFER_NO_PREFIX,TRANSFER_NO_LENGTH);

		$this->data['equipmentcategory']=$this->general->get_tbl_data('*','eqca_equipmentcategory',false,'eqca_equipmentcategoryid','DESC');
		$this->data['store']=$this->general->get_tbl_data('*','store',false,'st_store_id','DESC');
		$this->data['fiscal'] = $this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','DESC');
		$this->data['item_all']=$this->general->get_tbl_data('*','itli_itemslist',false,'itli_itemlistid','DESC');
		$this->data['transferno']=$this->general->get_tbl_data('max(trma_issueno) as no','trma_transactionmain',false,'trma_issueno','DESC');
		//echo "<pre>";print_r($this->data['transferno']);die;

		$id = $this->input->post('id');
		if($id)
		{
			$transferred_main = $this->data['transferred_main']  = $this->general->get_tbl_data('*','tfma_transfermain',array('tfma_tfmaid'=>$id),'tfma_tfmaid','ASC');
			$transferred_details = $this->data['transferred_details']  =$this->stock_transfer_mdl->get_transfer_details(array('td.tfde_tfmaid'=>$id));

			$stockqty = array();

			$tran_from_location_id = !empty($transferred_main[0]->tfma_fromlocationid)?$transferred_main[0]->tfma_fromlocationid:0;
			if(!empty($transferred_details)):
				foreach($transferred_details as $key=>$val){
					$item_id = $val->itli_itemlistid;
					$stockqty[]= $this->getStockQty($item_id, $tran_from_location_id);
				}
			endif;
			$this->data['cur_stock_qty'] = $stockqty;
		

			// echo "<pre>";
			// print_r($this->data['transferred_main']);
			// print_r($this->data['transferred_details']);
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
			->build('stock_transfer/v_stock_transfer', $this->data);
	}

	public function getStockQty($itemsid, $locationid){
		$this->db->select('trde_itemsid, sum(trde_issueqty) as cur_stock');
		$this->db->from('trde_transactiondetail td');
		$this->db->join('trma_transactionmain tm','tm.trma_trmaid = td.trde_trmaid','left');
		$this->db->where('trde_locationid',$locationid);
		$this->db->where('trde_itemsid',$itemsid);
		$this->db->where('trma_received',1);
		$this->db->where('trde_status','O');
		$this->db->group_by('trde_itemsid');

		$query = $this->db->get();
		// echo $this->db->last_query();
		// die();
		if($query->num_rows()>0){
			return $query->result();
		}
		return false;
	}

	public function form_stocktransfer()
	{
		$this->data['tab_type'] = "entry";
		$this->data['from_location']=$this->general->get_tbl_data('*','loca_location',array('loca_locationid'=>$this->locid),'loca_locationid','DESC');
		$this->data['to_location']=$this->general->get_tbl_data('*','loca_location',array('loca_locationid !='=>$this->locid),'loca_locationid','DESC');
		// $this->data['last_transferno'] = $this->general->getLastNo('trma_issueno','trma_transactionmain',array('trma_transactiontype'=>'S.TRANSFER'));
		$this->data['last_transferno'] = $this->general->generate_invoiceno('tfma_tfmaid','tfma_transferinvoice','tfma_transfermain',TRANSFER_NO_PREFIX,TRANSFER_NO_LENGTH);
		$this->data['equipmentcategory']=$this->general->get_tbl_data('*','eqca_equipmentcategory',false,'eqca_equipmentcategoryid','DESC');
		$this->data['store']=$this->general->get_tbl_data('*','store',false,'st_store_id','DESC');
		$this->data['fiscal'] = $this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','DESC');
		$this->data['item_all']=$this->general->get_tbl_data('*','itli_itemslist',false,'itli_itemlistid','DESC');
		$this->data['transferno']=$this->general->get_tbl_data('max(trma_issueno) as no','trma_transactionmain',false,'trma_issueno','DESC');
		//echo "<pre>";print_r($this->data['transferno']);die;
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
		
		$this->load->view('stock_transfer/v_stock_transfer_form',$this->data);
	}

	public function save_stocktransfer($print =false)
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		try {
			$id = $this->input->post('id');

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
			
			if($id){
				$this->form_validation->set_rules($this->stock_transfer_mdl->validate_approve_stock_requisition);	
			}else{
				$this->form_validation->set_rules($this->stock_transfer_mdl->validate_settings_stock_requisition);	
			}
			
			if($this->form_validation->run()==TRUE)
			{	
				if($id){
					$trans = $this->stock_transfer_mdl->save_approve_stocktransfer();
				}else{
					$trans = $this->stock_transfer_mdl->save_stocktransfer();
				}
				if($trans)
				{	
					$print_report = "";
					if($print == "print")
					{	
						//print_r($this->input->post());die;
						$this->data['transfer_master']='';
						$this->data['transfer_details']='';
						$report_data = $this->data['report_data'] = $this->input->post();
						$itemid = !empty($report_data['itemid'])?$report_data['itemid']:'';
						if(!empty($itemid)):
							foreach($itemid as $key=>$it):
								$itemid = !empty($report_data['itemid'][$key])?$report_data['itemid'][$key]:'';
							endforeach;
						endif;
						$print_report = $this->load->view('stock_transfer/v_stock_transfer_print', $this->data, true);
						//echo "<pre>"; print_r($print_report);die;
					}
					print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully', 'print_report'=>$print_report)));
					exit;
				}
				else
				{
					print_r(json_encode(array('status'=>'error','message'=>'Operation Unsuccessful')));
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
	public function list_stock_transfer_details()
	{
		$this->data['tab_type']='detailslist';
		$this->data['apptype'] = '';
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
			->build('stock_transfer/v_stock_transfer', $this->data);
	}
	public function stock_transfer_details_list()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if(MODULES_VIEW=='N')
			{
				$array=array();
			 	// $this->general->permission_denial_message();
			 	echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));			
				exit;
			}
		}
		$apptype = $this->input->get('apptype');
		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);	
	  	$i = 0;
	  	$data = $this->stock_transfer_mdl->get_stock_transfer_details_list();
	  	// echo $this->db->last_query();die();
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

				$appclass='';
		    	$approved=$row->tfma_isapproved;
		    	$received = $row->tfma_isreceived;

		    	// if($approved=='N')
		    	// {
		    	// 	$appclass='pending';
		    	// }

		    	if($approved =='N'){
		    		$approvedView = "display:inline-block";
		    		$recievedView = "display:none";
		    	}else if($approved == 'Y' && $received == 'N'){
		    		$appclass = 'warning';
		    		$approvedView = "display:none";
		    		$recievedView = "display:inline-block";
		    	}else if($received == 'Y' && $approved == 'Y'){
		    		$appclass = 'success';
		    		$approvedView = "display:none";
		    		$recievedView = "display:none";
		    	}

		    	$array[$i]["approvedclass"] = $appclass;
		    	$array[$i]["tfma_transferno"]=$row->tfma_transferinvoice;
			 	$array[$i]["fromlocation"]=$row->fromlocation;
			 	$array[$i]["tolocation"]=$row->tolocation;
			 	$array[$i]["tfma_fiscalyear"]=$row->tfma_fiscalyear;
			 	if(DEFAULT_DATEPICKER=='NP')
			 	{
					$array[$i]["transferdate"]=$row->tfma_transferdatebs;
			 	}else{
					$array[$i]["transferdate"]=$row->tfma_transferdatead;
			 	}
			 	$array[$i]["tfma_transferby"]=$row->tfma_transferby;
			 	$array[$i]["itli_itemcode"]=$row->tfde_itemcode;
			 	$array[$i]["itli_itemname"]=$row->tfde_itemname;
			 	$array[$i]["unit_unitname"]=$row->unit_unitname;
			 	$array[$i]["tfde_reqtransferqty"]=$row->tfde_reqtransferqty;
			 	$array[$i]["tfde_remarks"]=$row->tfde_remarks;
				$i++;
			}
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}


	public function search_stock_transfer_detail_pdf()
	{	

       $page_orientation = !empty($_GET['page_orientation']) ? $_GET['page_orientation']  : '';
		if ($page_orientation == 'L') {
			$page_size = 'A4-L';
		} else {
			$page_size = 'A4';
		}

		$html = $this->stock_transfer_detail_report_common();
		//echo $this->db->last_query(); die;
        $filename = 'stock_transfer_details'. date('Y_m_d_H_i_s') . '_.pdf'; 
        $pdfsize = 'A4'; //A4-L for landscape //if save and download with default filename, send $filename as parameter
        $this->general->generate_pdf($html,false,$pdfsize, $page_size);
	}

	public function search_stock_transfer_detail_excel()
	{	
		header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=stock_transfer_details_excel_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");
	    $response = $this->stock_transfer_detail_report_common();
	    if($response){
        	echo $response;	
        }
        return false;
	}

	public function stock_transfer_detail_report_common()
	{

		$this->data['excel_url']= "issue_consumption/stock_transfer/search_stock_transfer_detail_excel";
		$this->data['pdf_url'] = "issue_consumption/stock_transfer/search_stock_transfer_detail_pdf";
		$this->data['report_title'] = $this->lang->line('stock_transfer_detail');

		$srchcol = "";
		$this->data['searchResult'] = $this->stock_transfer_mdl->get_stock_transfer_details_list();
		$this->data['fromdate'] = $this->input->get('frmDate');

    	$this->data['todate'] = $this->input->get('toDate');

		//echo 	$this->data['fromdate'];die;
    	$locationid=$this->input->post('locationid');
    	if($locationid):
			$this->data['location']=$this->general->get_tbl_data('loca_locationid,loca_name','loca_location',array('loca_locationid'=>$locationid));
		else:
			$this->data['location'] = 'All';
		endif;

		unset($this->data['searchResult']["totalfilteredrecs"]);
		unset($this->data['searchResult']["totalrecs"]);

		$html = $this->load->view('stock_transfer/v_stock_transfer_details_download', $this->data, true);
        return $html;
	}

	
	/*
		public function generate_pdfTransferDetail()
	    {
	    	
	        $this->data['searchResult'] = $this->stock_transfer_mdl->get_stock_transfer_details_list();
	        unset($this->data['searchResult']['totalfilteredrecs']);
	        unset($this->data['searchResult']['totalrecs']);
	        $this->load->library('pdf');
	        $mpdf = $this->pdf->load();
	        //echo"<pre>";print_r($this->data['searchResult']);die;
	        ini_set('memory_limit', '256M');
	        $html = $this->load->view('stock_transfer/v_stock_transfer_details_download', $this->data, true);
	        $mpdf = new mPDF('c', 'A4-L'); 

	        if(PDF_IMAGEATEXT == '3')
	        {
	            $mpdf->SetWatermarkImage(PDF_WATERMARK);
	            $mpdf->showWatermarkImage = true;
	            $mpdf->showWatermarkText = true;  
	            $mpdf->SetWatermarkText(ORGA_NAME);
	        }
	        if(PDF_IMAGEATEXT == '1')
	        {
	            $mpdf->SetWatermarkImage(PDF_WATERMARK);
	            $mpdf->showWatermarkImage = true;
	        } 
	        if(PDF_IMAGEATEXT == '2')
	        {
	            $mpdf->showWatermarkText = true;  
	            $mpdf->SetWatermarkText(ORGA_NAME);
	        }
	        $mpdf = new mPDF('utf-8', 'A4-L');
	        $mpdf->SetAutoFont(AUTOFONT_ALL);
	        $mpdf->WriteHTML($stylesheet, 1);
	        $mpdf->WriteHTML($html);
	        $output = 'stock_transfer_detail'.date('Y_m_d_H_i').'.pdf';
	        $mpdf->Output();
	        exit();
	    }

	    public function exportToExcelTransferDetail(){
	        header("Content-Type: application/xls");    
	        header("Content-Disposition: attachment; filename=stock_transfer_detail".date('Y_m_d_H_i').".xls");  
	        header("Pragma: no-cache"); 
	        header("Expires: 0");

	        $data = $this->stock_transfer_mdl->get_stock_transfer_details_list();

	        $this->data['searchResult'] = $this->stock_transfer_mdl->get_stock_transfer_details_list();
	        
	        $array = array();
	        unset($this->data['searchResult']['totalfilteredrecs']);
	        unset($this->data['searchResult']['totalrecs']);
	        $response = $this->load->view('stock_transfer/v_stock_transfer_details_download', $this->data, true);


	        echo $response;
	    }
	*/	
    public function list_stocktransfer()
	{
		$this->data['tab_type']='list';
		$this->data['apptype'] = '';
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
			->build('stock_transfer/v_stock_transfer', $this->data);
	}

	public function stock_transfer_summary()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		  // print_r($this->input->post());
		  // die();
		    $frmDate = !empty($this->input->post('frmdate'))?$this->input->post('frmdate'):CURDATE_NP;
        	$toDate = !empty($this->input->post('todate'))?$this->input->post('todate'):CURDATE_NP;
        	$srch='';
        	if($this->location_ismain=='Y'){
        		if(DEFAULT_DATEPICKER=='NP')
        		{
        			$srch = array('tfma_postdatebs >='=>$frmDate, 'tfma_postdatebs <='=>$toDate,);
        		}else{
        			$srch = array('tfma_postdatead >='=>$frmDate, 'tfma_postdatead <='=>$toDate);
        		}

        	}else{
        		if(DEFAULT_DATEPICKER=='NP')
        		{
        			$srch = array('tfma_postdatebs >='=>$frmDate, 'tfma_postdatebs <='=>$toDate,'tfma_locationid'=>$this->locid);
        		}else{
        			$srch = array('tfma_postdatead >='=>$frmDate, 'tfma_postdatead <='=>$toDate,'tfma_locationid'=>$this->locid);
        		}

        	}
        	
		    $status_count = $this->stock_transfer_mdl->getStatusCount($srch);
		    print_r(json_encode(array('status'=>'success','status_count'=>$status_count)));
		}

	}

	public function stock_transfer_list()
	{	
		if(MODULES_VIEW=='N')
			{
				$array=array();
			 	// $this->general->permission_denial_message();
			 	echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));			
				exit;
			}
		$apptype = $this->input->get('apptype');
		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);	
	  	$i = 0;

	  	$data = $this->stock_transfer_mdl->get_stock_transfer_list();
	  
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
	  		foreach($data as $row)
			{
				$appclass='';
		    	$approved=$row->tfma_isapproved;
		    	$received = $row->tfma_isreceived;

		    	// if($approved=='N')
		    	// {
		    	// 	$appclass='pending';
		    	// }

		    	if($approved =='N'){
		    		$appclass = 'primary';
		    		$approvedView = "display:inline-block";
		    		$recievedView = "display:none";
		    	}else if($approved == 'Y' && $received == 'N'){
		    		$appclass = 'warning';
		    		$approvedView = "display:none";
		    		$recievedView = "display:none";
		    	}else if($received == 'Y' && $approved == 'Y'){
		    		$appclass = 'success';
		    		$approvedView = "display:none";
		    		$recievedView = "display:none";
		    	}

		    	$array[$i]["approvedclass"] = $appclass;
		    	$array[$i]["tfma_transferno"]=$row->tfma_transferinvoice;
			 	$array[$i]["fromlocation"]=$row->fromlocation;
			 	$array[$i]["tolocation"]=$row->tolocation;
			 	$array[$i]["tfma_fiscalyear"]=$row->tfma_fiscalyear;
			 	if(DEFAULT_DATEPICKER=='NP')
			 	{
					$array[$i]["transferdate"]=$row->tfma_transferdatebs;
			 	}else{
					$array[$i]["transferdate"]=$row->tfma_transferdatead;
			 	}
			 	$array[$i]["tfma_transferby"]=$row->tfma_transferby;
			 	$array[$i]["tfma_remarks"]=$row->tfma_remarks;
		 		
		 		$array[$i]["action"]='
		 			<a href="javascript:void(0)" data-id='.$row->tfma_tfmaid.' data-displaydiv="IssueDetails" data-viewurl='.base_url('issue_consumption/stock_transfer/details_stock_transfer').' class="view btn-primary btn-xxs" data-heading="Stock Transfer Details" title="Stock Transfer Details"><i class="fa fa-eye" aria-hidden="true" ></i></a>
		 			<a href="javascript:void(0)" style="'.$approvedView.'" data-id='.$row->tfma_tfmaid.' data-displaydiv="directpurchase" data-viewurl='.base_url('issue_consumption/stock_transfer').' class="redirectedit btn-warning btn-xxs"><i class="fa fa-check" aria-hidden="true" ></i></a>
		 			<a href="javascript:void(0)" style="'.$recievedView.'" data-id='.$row->tfma_tfmaid.' data-displaydiv="directpurchase" data-viewurl='.base_url('issue_consumption/stock_transfer').' class="redirectedit btn-success btn-xxs"><i class="fa fa-download" aria-hidden="true" ></i></a>';
				$i++;
			}
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}

	public function search_stock_transfer_pdf()
	{	
		$html = $this->stock_transfer_report_common();
		//echo $this->db->last_query(); die;
        $filename = 'stock_transfers_'. date('Y_m_d_H_i_s') . '_.pdf'; 
        $pdfsize = 'A4'; //A4-L for landscape //if save and download with default filename, send $filename as parameter
        $this->general->generate_pdf($html,false,$pdfsize);
	}

	public function search_stock_transfer_excel()
	{	
		header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=stock_transfer_excel_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");
	    $response = $this->stock_transfer_report_common();
	    if($response){
        	echo $response;	
        }
        return false;
	}

	public function stock_transfer_report_common()
	{
		$this->data['excel_url']= "issue_consumption/stock_transfer/search_stock_transfer_excel";
		$this->data['pdf_url'] = "issue_consumption/stock_transfer/search_stock_transfer_pdf";
		$this->data['report_title'] = $this->lang->line('stock_transfer');

		$srchcol = "";
		$this->data['searchResult'] = $this->stock_transfer_mdl->get_stock_transfer_list();
		$this->data['fromdate'] = $this->input->get('frmDate');

    	$this->data['todate'] = $this->input->get('toDate');

		//echo 	$this->data['fromdate'];die;
    	$locationid=$this->input->post('locationid');
    	if($locationid):
			$this->data['location']=$this->general->get_tbl_data('loca_locationid,loca_name','loca_location',array('loca_locationid'=>$locationid));
		else:
			$this->data['location'] = 'All';
		endif;

		unset($this->data['searchResult']["totalfilteredrecs"]);
		unset($this->data['searchResult']["totalrecs"]);

		$html = $this->load->view('stock_transfer/v_stock_transfer_download', $this->data, true);
        return $html;
	}

	public function details_stock_transfer()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$id = $this->input->post('id');
				if($id)
				{ 
					$transferred_main = $this->data['transfer_master'] = $this->stock_transfer_mdl->get_transfer_master(array('tf.tfma_tfmaid'=>$id));
					$transferred_details = $this->data['transfer_details'] = $this->stock_transfer_mdl->get_transfer_detail(array('td.tfde_tfmaid'=>$id));

					// echo "<pre>";
					// print_r($transferred_details);
					// die();


					$stockqty = array();

					$tran_from_location_id = !empty($transferred_main[0]->tfma_fromlocationid)?$transferred_main[0]->tfma_fromlocationid:0;
					if(!empty($transferred_details)):
						foreach($transferred_details as $key=>$val){
							$item_id = $val->itli_itemlistid;
							$stockqty[]= $this->getStockQty($item_id, $tran_from_location_id);
						}
					endif;
					$this->data['cur_stock_qty'] = $stockqty;

					//echo"<pre>";print_r($this->data['transfer_master']);die();
					$template=$this->load->view('stock_transfer/v_stock_transfer_details',$this->data,true);
					if($this->data['transfer_details']>0)
					{
						print_r(json_encode(array('status'=>'success','message'=>'','tempform'=>$template)));
			            	exit;
					}
					else{
						print_r(json_encode(array('status'=>'error','message'=>'')));
			            	exit;
					}
						print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','tempform'=>$template)));
			   			exit;	
				}
			}
		 	else
		    {
		    	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
		            exit;
		    }
	    }else{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
		exit;
		}
	}
	public function stock_transfer_reprint()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$id = $this->input->post('id');
				if($id)
				{ 
					$this->data['transfer_master'] = $this->stock_transfer_mdl->get_transfer_master(array('tf.tfma_tfmaid'=>$id));
					$this->data['transfer_details'] = $this->stock_transfer_mdl->get_transfer_detail(array('td.tfde_tfmaid'=>$id));
					
					$template=$this->load->view('stock_transfer/v_stock_transfer_print_kukl',$this->data,true);
					
				if($this->data['transfer_master']>0)
				{
					print_r(json_encode(array('status'=>'success','message'=>'','tempform'=>$template)));
		            exit;
				}
				else{
					print_r(json_encode(array('status'=>'error','message'=>'')));
		            	exit;
				}
					print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','tempform'=>$template)));
		   		 exit;	
				}
			}
		 	else
		    {
		    	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
		            exit;
		    }
	    }else{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
		exit;
		}
	}

	public function req_analysis()
	{
		$this->data['tab_type']='req_analysis';
		 //    $frmDate = CURDATE_NP;
	  	//   	$toDate = CURDATE_NP;
		// $this->data['status_count'] = $this->stock_requisition_mdl->getStatusCount(array('rema_reqdatebs >='=>$frmDate, 'rema_reqdatebs <='=>$toDate));
		$seo_data='';
		if($seo_data)
		{
			$this->page_title = $seo_data->page_title;
			$this->data['meta_keys']= $seo_data->meta_key;
			$this->data['meta_desc']= $seo_data->meta_description;
		}
		else
		{
			$this->page_title = ORGA_NAME;
			$this->data['meta_keys']= ORGA_NAME;
			$this->data['meta_desc']= ORGA_NAME;
		}
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('stock/v_stock_requisition', $this->data);
	}
	public function req_analysis_search()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	        
	        if(MODULES_VIEW=='N')
			{
 				print_r(json_encode(array('status'=>'error','message'=>$this->general->permission_denial_message())));
				exit;
			}

	        $template = $this->req_analysis_search_common();

	        // echo $temp; die();
	        print_r(json_encode(array('status'=>'success','template'=>$template,'message'=>'Successfully Selected')));
	        exit;
	    }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
	}

	public function req_analysis_search_common()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$this->data['excel_url'] = "issue_consumption/stock_transfer/excel_item_wise";
			$this->data['pdf_url'] = "issue_consumption/stock_transfer/item_wise_pdf";
			$this->data['report_title'] = $this->lang->line('requisition_analysis');

	      	$this->data['fromdate'] = $this->input->post('frmDate');
        	$this->data['todate'] = $this->input->post('toDate');
	      	$locationid = $this->input->post('locationid');

        	$depid = $this->input->post('depid');
        	$st_store_id = $this->input->post('store_id');
        	$issutransfer = $this->input->post('issuetransfer');
        	$locationid=$this->input->post('locationid');
		//print_r($this->input->post());die;
        
        	if($locationid):
				$this->data['location']=$this->general->get_tbl_data('*','loca_location',array('loca_locationid'=>$locationid));
			else:
				$this->data['location'] = 'All';
			endif;
				
			$cond = "";
			
        	if($depid)
        	{
        		$cond = array('rm.rema_reqfromdepid'=>$depid);
        	}
        	if($st_store_id)
        	{
        		$cond = array('rm.rema_reqtodepid'=>$st_store_id);
        	}
        	// if($locationid)
        	// {
        	// 	$cond = array('rm.rema_locationid'=>$locationid);
        	// }
        $this->locationid=$this->session->userdata(LOCATION_ID);
        $this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
       if($this->location_ismain=='Y')
        {
            if($locationid)
            {
               $cond = array('rm.rema_locationid'=>$locationid);
            }

        }
        else
        {
           $cond = array('rm.rema_locationid'=>$this->locationid);
        }

	      	$this->data['store']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','DESC');

	      	$this->data['req_analysis']=$this->stock_transfer_mdl->req_analysis_report($cond);
	      	//$this->data['distinctmaster']=$this->general->get_tbl_data('rema_reqno,rema_reqdatebs,rema_manualno,rema_reqmasterid','rema_reqmaster',array(''=>,''=>,''=>,''=>,''=>,),'rema_reqmasterid','DESC');
	      	
	      	$this->data['distinctdep']=$this->stock_transfer_mdl->req_analysis_report_dist_dep($cond);
			//echo"<pre>"; print_r($this->data['distinctdep']);die;
	      	// echo $this->db->last_query();
	      	
	       $this->data['req_transfer']=$this->stock_transfer_mdl->req_analysis_transfer($cond);
	        //echo"<pre>"; print_r($this->data['req_transfer']);die;
	      	// $this->data['transferstore']=$this->general->get_tbl_data('*','rema_reqmaster',array('rema_isdep'=>'N'),'eqty_equipmenttypeid','DESC');
	       $issutransfer='issue';
	       $template='';
	       if($issutransfer== "issue")
	       {
		       	if($this->data['req_analysis'])
			    {
			    	$template=$this->load->view('stock/v_req_analysis',$this->data,true);
			    }
			    else
			    {
			        $template='<span class="col-sm-12 alert alert-danger text-center">No Record Found!!!</span>';
			    }
	       }
	       elseif($issutransfer== "transfer")
	       {
	       		if($this->data['req_transfer'])
			    {
			    	$template=$this->load->view('stock/v_transfer_analysis',$this->data,true);
			    }
			    else
			    {
			        $template='<span class="col-sm-12 alert alert-danger text-center">No Record Found!!!</span>';
			    }
	       }
	       else
	       {
	       	if($this->data['req_transfer'])
			    {
			    	$template=$this->load->view('stock/v_transfer_analysis',$this->data,true);
			    }
			    else
			    {
			        $template='<span class="col-sm-12 alert alert-danger text-center">No Record Found!!!</span>';
			    }
	       }
	        return $template;
	        exit;
	    }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
	}
	




}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */