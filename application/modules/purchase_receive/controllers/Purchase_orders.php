<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Purchase_orders extends CI_Controller
{
	function __construct()
	{	
		parent::__construct();
		$this->load->Model('purchase_orders_mdl');
	}

	// this is backup of purchase_order
	public function index()
	{  
	 $this->data['order_details'] ="";
		$this->data['store'] = $this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','DESC');
		$this->data['equipmentcategory']=$this->general->get_tbl_data('*','eqca_equipmentcategory',false,'eqca_equipmentcategoryid','DESC');
		$this->data['distributor']=$this->general->get_tbl_data('*','dist_distributors',false,'dist_distributorid','DESC');
		$this->data['depatrment']=$this->general->get_tbl_data('*','dept_department',false,'dept_depid','DESC');
		$this->data['unit_all'] = $this->general->get_tbl_data('*','unit_unit',false,'unit_unitid','DESC');
		
		$this->data['fiscal_year'] = $this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','DESC');
		$this->data['current_stock']='purchase_orders';
		$storeid = $this->session->userdata(STORE_ID);
		$this->data['order_no'] = $this->general->get_tbl_data('max(puor_orderno) as ordnumb','puor_purchaseordermaster',array('puor_fyear'=>CUR_FISCALYEAR),'puor_purchaseordermasterid','DESC');
		//echo "<pre>";print_r($this->data['orderno']);die;
		$this->data['eqty_equipmenttype'] = $this->general->get_tbl_data('*','eqty_equipmenttype',array('eqty_equipmenttypeid'=>$storeid),'eqty_equipmenttypeid','DESC');

		if(DEFAULT_DATEPICKER=='NP')
		{
			$this->data['delivery_date']=$this->general->EngToNepDateConv($this->general->add_date(CURDATE_EN,7,'days'));
		}
		else
		{
			$this->data['delivery_date']=$this->general->add_date(CURDATE_EN,7,'days');
		}
		
		// die();

		$seo_data='';
		$id = $this->input->post('id');
		if($id)
		{
			$this->data['order_details'] = $this->general->get_tbl_data('*','puor_purchaseordermaster',array('puor_purchaseordermasterid'=>$id),'puor_purchaseordermasterid','DESC');
			$this->data['orderdetails'] = $this->purchase_orders_mdl->get_order_selected(array('puor_purchaseordermasterid'=>$id,'puor_fyear'=>CUR_FISCALYEAR));
			//
			//$this->->purchase_orders_mdl->get_order_list();
			//echo "<pre>";print_r($this->data['orderdetails']);die;
		}

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
			// ->build('purchase_order/v_purchase_order', $this->data);
			->build('purchase_orders/v_common_purchaseorder_tab', $this->data);
	}

	public function ajax_delivery_date_calculation()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$days=$this->input->post('days');

		if(DEFAULT_DATEPICKER=='NP'){
			$this->data['delivery_date']=$this->general->EngToNepDateConv($this->general->add_date(CURDATE_EN,$days,'days'));
		}else{
			$this->data['delivery_date']=$this->general->add_date(CURDATE_EN,$days,'days');
		}
		print_r(json_encode(array('status'=>'success','delivery_date'=>$this->data['delivery_date'],'message'=>'Calculate Successfully !!!')));
	        exit;
	}
		else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}
	}

	public function purhasre_requisition_chaeck_miniumqty()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$detailsid = $this->input->post('purdetailsid');
			$qty = $this->input->post('qty');
			$fyear=$this->input->post('fiscalyear');
			$this->data['qunatity']=$this->general->get_tbl_data('pude_quantity','pude_purchaseorderdetail ',array('pude_puordeid'=>$detailsid),'pude_puordeid','DESC');
			$oldqty = $this->data['qunatity']->pude_quantity;
			if($qty < $oldqty)
			{
				print_r(json_encode(array('status'=>'success','message'=>'New Entered Quantity Is Not Less Then Previous Quantity','qty'=>$oldqty)));
	            exit;
			}
			// else
				// {
				// 	print_r(json_encode(array('status'=>'errorLimit','message'=>'Requisition Quantiy Is Exceeded !!')));
		  		//           exit;
			// }
		}
		else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}
	}
	public function form_purchase_order()
	{
		$this->data['order_details'] ="";
		$this->data['equipmentcategory']=$this->general->get_tbl_data('*','eqca_equipmentcategory',false,'eqca_equipmentcategoryid','DESC');
		$this->data['store'] = $this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','DESC');
		$this->data['distributor']=$this->general->get_tbl_data('*','dist_distributors',false,'dist_distributorid','DESC');
		
		$this->data['depatrment']=$this->general->get_tbl_data('*','dept_department',false,'dept_depid','DESC');
		
		$this->data['unit_all'] = $this->general->get_tbl_data('*','unit_unit',false,'unit_unitid','DESC');
		
		$this->data['fiscal_year'] = $this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','DESC');
		$this->data['order_no'] = $this->general->get_tbl_data('max(puor_orderno) as ordnumb','puor_purchaseordermaster',array('puor_fyear'=>CUR_FISCALYEAR),'puor_purchaseordermasterid','DESC');
		$this->data['current_stock']='purchase_orders';
		$storeid = $this->session->userdata(STORE_ID);
		$this->data['eqty_equipmenttype'] = $this->general->get_tbl_data('*','eqty_equipmenttype',array('eqty_equipmenttypeid'=>$storeid),'eqty_equipmenttypeid','DESC');
		$this->load->view('purchase_orders/v_purchase_order_form' , $this->data);
	}
	public function purchase_order_book()
	{	
	$this->data['distributor']=$this->general->get_tbl_data('*','dist_distributors',false,'dist_distributorid','DESC');
	$this->data['item_all']=$this->general->get_tbl_data('*','itli_itemslist',false,'itli_itemlistid','DESC');

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

		$this->data['current_stock']='purchase_order_book';

		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			// ->build('purchase_order/v_purchase_order_book_list', $this->data);
			->build('purchase_orders/v_common_purchaseorder_tab', $this->data);
	}
	
	public function purhasre_requisition_check_remainigqty()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$qtynow=$this->input->post('remqty');
			$fyear=$this->input->post('fiscalyear');
			$pid=$this->input->post('pid');
			$this->data['qunatity']=$this->general->get_tbl_data('purd_remqty','purd_purchasereqdetail ',array('purd_reqdetid'=>$pid,'purd_fyear'=>$fyear),'purd_reqdetid','DESC');
			$oldqty = $this->data['qunatity'][0]->purd_remqty;
			//echo $this->db->last_query();print_r($oldqty);die;
			if($oldqty > $qtynow)
			{
				print_r(json_encode(array('status'=>'success','message'=>'Remaining Quantity Not Exceeded','qty'=>$oldqty)));
	            exit;
			}
			else
			{
				print_r(json_encode(array('status'=>'errorLimit','message'=>'Requisition Quantiy Is Exceeded !!','qty'=>$oldqty)));
	            exit;
			}
		}
		else
		{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}
	}
	public function purchase_requisition_find()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$reqno=$this->input->post('requisitionno');
			$fyear=$this->input->post('fiscalyear');
			$this->data['purhasre_requisition'] = $this->purchase_orders_mdl->get_requisition_details(array('cm.pure_reqno'=>$reqno,'pure_fyear'=>$fyear,'pure_isapproved'=>'Y','rd.purd_remqty >'=>'0'));
			// echo "<pre>";
			// echo $this->db->last_query();
			// die();
			// pure_itemstypeid
			// echo "<pre>";
			// print_r($this->data['purhasre_requisition']);
			// die();
			$this->data['storeid']=!empty($this->data['purhasre_requisition'][0]->pure_itemstypeid)?$this->data['purhasre_requisition'][0]->pure_itemstypeid:''; 
			// echo $this->data['storeid'];
			// die();
			$tempform=$this->load->view('purchase_orders/v_requisition_details_form',$this->data,true);
			// echo"<pre>"; print_r($this->data['purhasre_requisition']);die;
			// print_r($tempform);die;
			if(!empty($this->data['purhasre_requisition']))
			{
				print_r(json_encode(array('status'=>'success','message'=>'You Can view Order','tempform'=>$tempform,'storeid'=>$this->data['storeid'])));
	            exit;
			}
			else
			{
				print_r(json_encode(array('status'=>'error','message'=>'Please Try Latter!!')));
	            exit;
			}
		}
		else
		{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}
	}
	public function order_lists()
	{	
		$this->data['depatrment']=$this->general->get_tbl_data('*','dept_department',false,'dept_depid','DESC');
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$order_muner = $this->input->post('order_no');
			$this->data['orderno'] =  $this->input->post('order_no');
			if($order_muner)
			{
				$this->data['order_item_details'] = $this->receive_order_model->get_selected_order();
				
				$template=$this->load->view('receive_order_item/v_receive_order_form',$this->data,true);
			// echo $template; die();
			if($this->data['order_item_details']>0)
			{
					print_r(json_encode(array('status'=>'success','message'=>'','template'=>$template)));
	            	exit;
			}
			else{
				print_r(json_encode(array('status'=>'error','message'=>'')));
	            	exit;
			}
				print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));
	   		 exit;	
			}
		}
	 	else
	    {
	    	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	            exit;
	    }
	}
	public function purchased_summary()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$srchcol='';
			$frmDate=$this->input->post('frmdate');
        	$toDate=$this->input->post('todate');
			if($frmDate && $toDate)
			{
				$srchcol=(" puor_orderdatebs BETWEEN '$frmDate' AND'$toDate'");
			}
			if(ORGANATION_NAME=='KUKL'){
			$status_count = $this->purchase_orders_mdl->getStatusCount_kukl();
			}
			else{
			$status_count = $this->purchase_orders_mdl->getStatusCount($srchcol);
			}

		    //$return_count = $this->purchase_orders_mdl->getStatusCount(array('rema_returndatebs >='=>$frmDate, 'rema_returndatebs <='=>$toDate),'return');
		    // echo $this->db->last_query();
		    print_r(json_encode(array('status'=>'success','status_count'=>$status_count)));
		}
	}
	public function purchase_order_book_list()
	{   $apptype = $this->input->get('apptype');
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if(MODULES_VIEW=='N')
			{
			$array["dist_distributorid"]='';
			$array["distributor"]='';
			$array["countryname"]='';
			$array["city"]='';
			$array["address1"]='';
			$array["action"]='';
			 // $this->general->permission_denial_message();
			 echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));			
			exit;
			}
		}
		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);
			// if($orgid){
			// 	$org_id=$orgid;
			// }
			// else
			// {
			// 	$org_id = $this->session->userdata(ORG_ID); 
			// }
			
			// if($useraccess == 'B')
			// {
			// 	if($orgid)
			// 	{
			// 		$srchcol=array('dist_orgid'=>$org_id);
			// 	}
			// 	else
			// 	{
			// 		$srchcol='';
			// 	}

			// 	$data = $this->analysis_mdl->get_deletedistributors_list($srchcol);
			// }else{
			// 	$data = $this->analysis_mdl->get_deletedistributors_list(array('dist_orgid'=> $org_id));
			// }	
        
	        // echo $this->db->last_query();
	        // die();
	
			// if($result == 'bmin_equipid') {

			// 	$cond = array('dist_postdatead'=>date("Y/m/d"),'dist_orgid'=>$org_id);
			// 	$data = $this->analysis_mdl->get_deletedistributors_list($cond);
			// }
		    // echo "<pre>"; print_r($data); die();
	  	$i = 0;$srch='';
	  	if($apptype == 'pending')
	  	{
	  		$srch = array('puor_status'=>'N','puor_purchased'=>'0');
	  	}
	  	if($apptype == 'complete')
	  	{
	  		$srch = array('puor_status'=>'R','puor_purchased'=>'2');
	  	}
	  	if($apptype == 'partialcomplete')
	  	{
	  		$srch = array('puor_status'=>'R','puor_purchased'=>'1');
	  	}
	  	$data = $this->purchase_orders_mdl->get_order_list($srch);
	  	//echo"<pre>";print_r($data);die;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];


	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
		  	foreach($data as $row)
		    {
		   		$appclass='';
		    	$approved=$row->puor_status;
		    	$status=$row->puor_purchased;
		    	if($approved=='R' && $status == '1')
		    	{
		    		$appclass='partialcomplete';
		    	}
		    	if($approved=='N' && $status == '0')
		    	{
		    		$appclass='pending';
		    	}
		    	if($approved=='R' && $status == '2')
		    	{
					$appclass='complete';
		    	}
		    	$array[$i]["approvedclass"] = $appclass;
			    $array[$i]["puor_purchaseordermasterid"] = '<a href="javascript:void(0)" class="patlist" data-patientid='.$row->puor_purchaseordermasterid.'>'.$row->puor_purchaseordermasterid.'</a>';
			    $array[$i]["orderno"] = $row->puor_orderno;
			   	$array[$i]["puor_orderdatebs"] = $row->puor_orderdatebs;
			    $array[$i]["puor_deliverysite"] = $row->puor_deliverysite;
			    $array[$i]["supplier"] = $row->dist_distributor;
			    $array[$i]["puor_orderdatead"] = $row->puor_orderdatead; 
			    $array[$i]["puor_deliverydatebs"] = $row->puor_deliverydatebs; 
			    $array[$i]["puor_deliverydatead"] = $row->puor_deliverydatead; 
			    $array[$i]["amount"] = $row->puor_amount;
			    $array[$i]["requno"] = $row->puor_requno;
			    $array[$i]["totalamount"] = $row->puor_amount;
			    $array[$i]["puor_approvedby"] = $row->puor_approvedby;
			    $array[$i]["action"] ='<a href="javascript:void(0)" data-id='.$row->puor_purchaseordermasterid.' data-displaydiv="orderDetails" data-viewurl='.base_url('purchase_receive/purchase_orders/details_order_views/').' class="view btn-primary btn-xxs" data-heading="View Order Details"  ><i class="fa fa-eye " aria-hidden="true" ></i></a> &nbsp; <a href="javascript:void(0)" data-id='.$row->puor_purchaseordermasterid.' data-date='.$row->puor_purchaseordermasterid.' data-viewurl='.base_url('purchase_receive/purchase_order').' class="redirectedit btn-success btn-xxs"><i class="fa fa-check" title="Order Approved" aria-hidden="true"></i></a>';
			    $i++;
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}

	public function exportToExcel(){
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=all_purchase_item_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");
        $data = $this->purchase_orders_mdl->get_order_list();
        $this->data['searchResult'] = $this->purchase_orders_mdl->get_order_list();
        //print_r($this->data['searchResult']);die;
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);

        $response = $this->load->view('purchase_orders/v_cancel_order_download', $this->data, true);


        echo $response;
    }
    public function generate_pdf()
    {
    	$this->data['searchResult'] = $this->purchase_orders_mdl->get_order_list();
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);
        $this->load->library('pdf');

        $mpdf = $this->pdf->load();
        //echo"<pre>";print_r($this->data['searchResult']);die;
        ini_set('memory_limit', '256M');

        $html = $this->load->view('purchase_orders/v_cancel_order_download', $this->data, true);
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
        $output = 'all_purchase_item_'.date('Y_m_d_H_i').'.pdf';
        $mpdf->Output();
        exit();
    }
	public function details_order_reprint()
	{	
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$this->data['equipmentcategory']=$this->general->get_tbl_data('*','eqca_equipmentcategory',false,'eqca_equipmentcategoryid','DESC');
			$this->data['supplier']=$this->general->get_tbl_data('*','dist_distributors',false,'dist_distributorid','DESC');
			$this->data['depatrment']=$this->general->get_tbl_data('*','dept_department',false,'dept_depid','DESC');
			$this->data['item_all']=$this->general->get_tbl_data('*','itli_itemslist',false,'itli_itemlistid','DESC');
			$this->data['unit_all'] = $this->general->get_tbl_data('*','unit_unit',false,'unit_unitid','DESC');
			$this->data['tax_all'] = $this->general->get_tbl_data('*','tava_taxvalue',false,'tava_taxvalueid','DESC');
			$this->data['product_all'] = $this->general->get_tbl_data('*','prod_product',false,'prod_productid','DESC');
			$this->data['fiscal'] = $this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','DESC');
			
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$id = $this->input->post('id');
				if($id)
				{ 
					$this->data['order_details'] = $this->purchase_orders_mdl->get_order_selected();
					//echo"<pre>";print_r($this->data['order_details']);die();
					$template=$this->load->view('purchase_orders/v_purchase_order_print',$this->data,true);
					//print_r($template);die;
				if($this->data['order_details']>0)
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
	public function details_order_views()
	{	
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$this->data['equipmentcategory']=$this->general->get_tbl_data('*','eqca_equipmentcategory',false,'eqca_equipmentcategoryid','DESC');
			$this->data['supplier']=$this->general->get_tbl_data('*','dist_distributors',false,'dist_distributorid','DESC');
			$this->data['depatrment']=$this->general->get_tbl_data('*','dept_department',false,'dept_depid','DESC');
			$this->data['item_all']=$this->general->get_tbl_data('*','itli_itemslist',false,'itli_itemlistid','DESC');
			$this->data['unit_all'] = $this->general->get_tbl_data('*','unit_unit',false,'unit_unitid','DESC');
			$this->data['tax_all'] = $this->general->get_tbl_data('*','tava_taxvalue',false,'tava_taxvalueid','DESC');
			$this->data['product_all'] = $this->general->get_tbl_data('*','prod_product',false,'prod_productid','DESC');
			$this->data['fiscal'] = $this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','DESC');
			
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$id = $this->input->post('id');
				if($id)
				{ 
					$this->data['order_details'] = $this->purchase_orders_mdl->get_order_selected();
					//echo"<pre>";print_r($this->data['order_details']);die();
					$template=$this->load->view('purchase_orders/v_purchase_order_details',$this->data,true);
					//print_r($template);die;
				if($this->data['order_details']>0)
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
	
	public function _notMatch($totalamountValue, $billamountFieldName)
	{
	    if($totalamountValue != $this->input->post($billamountFieldName))
	    {
	       $this->form_validation->set_message('_notMatch', 'Bill Amount and Total Amount Not Match');
	       return false;
	    }
	    return true;
	}
	public function save_order_item($print = false)
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		try {
			$this->form_validation->set_rules($this->purchase_orders_mdl->validate_settings_order_item);
			if($this->form_validation->run()==TRUE)
			{
				//echo"<pre>";print_r($thid->input->post());die;
				
				$trans = $this->purchase_orders_mdl->order_item_save();
				if($trans)
				{
					if($print = "print")
					{ 
						// echo"<pre>";print_r($this->input->post());die;
						$this->data['order_details']='';
						$report_data = $this->data['report_data'] = $this->input->post();
						$itemid = !empty($report_data['qude_itemsid'])?$report_data['qude_itemsid']:'';
						if(!empty($itemid)):
							foreach($itemid as $key=>$it):
								$itemid = !empty($report_data['qude_itemsid'][$key])?$report_data['qude_itemsid'][$key]:'';
								$unitid = !empty($report_data['rede_unit'][$key])?$report_data['rede_unit'][$key]:'';
								$this->data['item_name']=$this->general->get_tbl_data('*','itli_itemslist',array('itli_itemlistid'=>$itemid),'itli_itemlistid','DESC');
								$this->data['items']=$this->general->get_tbl_data('*','eqty_equipmenttype',array('eqty_equipmenttypeid'=>$itemid),'eqty_equipmenttypeid','DESC');
							endforeach;
						endif;
						$print_report = $this->load->view('purchase_orders/v_purchase_order_print', $this->data, true);
					}
					print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully', 'print_report'=>$print_report)));
					exit;
				}
				else
				{
					print_r(json_encode(array('status'=>'error','message'=>'Record Save Successfully')));
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
	
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */