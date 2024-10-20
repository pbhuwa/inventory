<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Challan extends CI_Controller
{
	function __construct()
	{	
		parent::__construct();
		$this->load->Model('challan_mdl');
		$this->load->Model('purchase_receive/direct_purchase_mdl');

	  	 $this->storeid = $this->session->userdata(STORE_ID);
		 $this->locationid=$this->session->userdata(LOCATION_ID);
		
	}
	public function index()
    {
		$this->data['editurl']=base_url().'stock_inventory/challan/edit_challan';
		$this->data['deleteurl']=base_url().'stock_inventory/challan/delete_challan';
		$this->data['listurl']=base_url().'dep_change/list_challan';
		$this->data['receiveno']=$this->general->get_tbl_data('max(convert(chma_challanrecno, SIGNED INTEGER)) as id','chma_challanmaster',array('chma_fyear'=>CUR_FISCALYEAR,'chma_locationid'=>$this->locationid),'chma_challanmasterid','DESC');

		$this->data['item_all']=$this->general->get_tbl_data('*','itli_itemslist',false,'itli_itemlistid','DESC');
		$this->data['supplier']=$this->general->get_tbl_data('*','dist_distributors',false,'dist_distributorid','DESC');
		$this->data['fiscal'] = $this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','DESC');

		$id = $this->input->post('id');
			
		$this->data['challan_data'] = $this->challan_mdl->chalandetails(array('chde_challanmasterid'=>$id));
		$this->data['loadselect2']='no';

		// echo "<pre>";
		// print_r($this->data['challan_data']);
		// die();

		$seo_data='';
		$this->data['tab_type'] = 'entry';
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
			->build('challan/v_challan', $this->data);
	}
	public function challan_list()
    {
    	// $frmDate = CURMONTH_DAY1;
    	// $toDate = CURDATE_NP;
    	 $frmDate = !empty($this->input->post('frmdate'))?$this->input->post('frmdate'):CURMONTH_DAY1;
         $toDate = !empty($this->input->post('todate'))?$this->input->post('todate'):CURDATE_NP;
  if(ORGANIZATION_NAME=='KUKL'){
		$cond='';
		if($frmDate){
			    $cond .=" WHERE chma_challanrecdatebs >='".$frmDate."'";
		}
		if($toDate){
				$cond .=" AND chma_challanrecdatebs <='".$toDate."'";
		}else{
			$cond .=" AND chma_challanrecdatebs <='".$frmDate."'";
		}
		
	   $this->data['status_count'] = $this->challan_mdl->getColorStatusCount($cond);
	   // print_r( $this->data['status_count']);die;

		}else{
			$this->data['status_count']=$this->challan_mdl->getStatusCount(array('chma_challanrecdatebs >='=>$frmDate, 'chma_challanrecdatebs <='=>$toDate));
		}

		$seo_data='';
		$this->data['tab_type'] = 'list';
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
			->build('challan/v_challan', $this->data);
	}

	public function save_challan($print=false)
	{   
		if($this->input->post('id')){
			if(MODULES_UPDATE=='N'){
				$this->general->permission_denial_message();
				exit;
			}
		}
		else{
			if(MODULES_INSERT=='N'){
				$this->general->permission_denial_message();
				exit;
			}
		}

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			try {
				$id=$this->input->post('id');

				if($id){
					$this->form_validation->set_rules($this->challan_mdl->validate_settings_challan);
				}else{
					$this->form_validation->set_rules($this->challan_mdl->validate_settings_challan);
				}

				if($this->form_validation->run()==TRUE){
					$trans = $this->challan_mdl->challan_save();
					
					if($trans){
	            		$print_report = "";
	            		if($print = "print"){	
	            			$this->data['report_data'] = '';

							$this->data['challans']  = $this->challan_mdl->chalanmaster(array('chma_challanmasterid'=>$trans),'chma_challanmasterid');
			
							$this->data['chalan_details'] = $this->challan_mdl->chalandetails(array('chde_challanmasterid'=>$trans));

							$print_report = $this->load->view('challan/v_challan_print_report', $this->data, true);

						}
						print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully', 'print_report'=>$print_report)));
						exit;
					}else{
	            		print_r(json_encode(array('status'=>'error','message'=>'Record Save Successfully')));
	            		exit;
	            	}
	            }
	            else{
	            	print_r(json_encode(array('status'=>'error','message'=>validation_errors())));
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

	public function form_challan()
	{
		$this->data['receiveno']=$this->general->get_tbl_data('max(convert(chma_challanrecno, SIGNED INTEGER)) as id','chma_challanmaster',array('chma_fyear'=>CUR_FISCALYEAR,'chma_locationid'=>$this->locationid),'chma_challanmasterid','DESC');
		$this->data['item_all']=$this->general->get_tbl_data('*','itli_itemslist',false,'itli_itemlistid','DESC');
		$this->data['supplier']=$this->general->get_tbl_data('*','dist_distributors',false,'dist_distributorid','DESC');
		$this->data['fiscal'] = $this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','DESC');
		$this->data['loadselect2']='yes';

		$this->load->view('challan/v_challan_form_new',$this->data);
	}
	public function chalan_lists()
	{	 
		if(MODULES_VIEW=='N')
			{
			$array=array();
			 echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));			
			exit;
			}
		
		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);
	
	  	$i = 0;
	  	$data = $this->challan_mdl->get_challan_list();
	  	//echo"<pre>";print_r($data);die;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
		  	foreach($data as $row)
		    {
		    	$appclass='';
		    	$billentry = $row->chma_received;
				if($billentry=="Y")
		    	{
		    		$appclass='billentry';
		    	}
		    	if($billentry=="N"){
		    		$appclass='pending';
		    	}
		    	$array[$i]["billentryclass"] = $appclass;
			    $array[$i]["chma_challanmasterid"] = '<a href="javascript:void(0)" class="patlist" data-patientid='.$row->chma_challanmasterid.'>'.$row->chma_challanmasterid.'</a>';
			    $array[$i]["challannumber"] = $row->chma_challannumber;
			   	$array[$i]["supplier"] = $row->dist_distributor;
			    $array[$i]["challanrecno"] = $row->chma_challanrecno;
			    $array[$i]["receivedatead"] = $row->chma_receivedatead; 
			    $array[$i]["receivedatebs"] = $row->chma_receivedatebs;
			    $array[$i]["suchallanno"] = $row->chma_suchallanno;
			    $array[$i]["suchalandatebs"] = $row->chma_suchalandatebs;
			    $array[$i]["purchase_order_no"] = $row->chma_puorid;
			    $array[$i]["purchase_date_ad"] = $row->puor_orderdatead;
			    $array[$i]["purchase_date_bs"] = $row->puor_orderdatebs;
			    $array[$i]["fyear"] = $row->chma_fyear;

			    if(MODULES_VIEW=='Y'){

			    $viewbtn='<a href="javascript:void(0)" data-id='.$row->chma_challanmasterid.' data-displaydiv="chalanDetails" data-viewurl='.base_url('issue_consumption/challan/details_chalan_views/').' class="view btn-primary btn-xxs sm-pd" data-heading="View Order Details"  ><i class="fa fa-eye" aria-hidden="true" ></i></a>';
			}else{
				$viewbtn='';
			}

			if(MODULES_UPDATE=='Y'){
				

			    $editbtn='<a href="javascript:void(0)" data-id='.$row->chma_challanmasterid.' data-displaydiv="chalanDetails" data-viewurl='.base_url('issue_consumption/challan').' class="redirectedit btn-info btn-xxs sm-pd"><i class="fa fa-edit" aria-hidden="true" ></i></a>';
			}else{
				$editbtn='';
			}


			    if($row->chma_received == 'N'){
			    	$array[$i]["action"] =$editbtn.''.$viewbtn;
			    }else{
				    $array[$i]["action"] =$viewbtn;
			    }
				
			    $i++;
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}
	public function chalan_status()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		    $frmDate = !empty($this->input->post('frmdate'))?$this->input->post('frmdate'):CURDATE_NP;
        	$toDate = !empty($this->input->post('todate'))?$this->input->post('todate'):CURDATE_NP;
  //      if(ORGANIZATION_NAME=='KUKL'){
		// $cond='';
		// if($frmDate){
		// 	    $cond .=" WHERE chma_challanrecdatebs >='".$frmDate."'";
		// }
		// if($toDate){
		// 		$cond .=" AND chma_challanrecdatebs <='".$toDate."'";
		// }else{
		// 	$cond .=" AND chma_challanrecdatebs <='".$frmDate."'";
		// }
		
	 //   $status_count = $this->challan_mdl->getColorStatusCount($cond);

		// }else{
			   $status_count = $this->challan_mdl->getStatusCount(array('chma_challanrecdatebs >='=>$frmDate, 'chma_challanrecdatebs <='=>$toDate));
		// }

		  
		    print_r(json_encode(array('status'=>'success','status_count'=>$status_count)));
		}
	}
	public function details_chalan_views()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			// if(MODULES_VIEW=='N')
			// 	{
			// 	$this->general->permission_denial_message();
			// 	exit;
			// 	}
			$this->data=array();
			$cond='';
			$id = $this->input->post('id');
			if($id)
			{
				$cond = array('chde_challanmasterid'=>$id);
			}
			$this->data['challans']  = $this->challan_mdl->chalanmaster(array('chma_challanmasterid'=>$id),'chma_challanmasterid');
			
			$this->data['chalan_details'] = $this->challan_mdl->chalandetails($cond);
			//echo"<pre>";print_r($this->data['challans']);die;
			
			$template=$this->load->view('challan/v_chalan_details',$this->data,true);
			print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','tempform'=>$template)));
	   		 exit;	
		}
		else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}	
	}
	public function challan_bill_entry()
	{	//echo"<pre>"; print_r($this->input->post());die;
	// echo "sad";
	// die();
		$mid = $this->input->post('mid');
		if($mid)
		{
			$this->data['purchased_data']  = $this->general->get_tbl_data('*','chma_challanmaster',array('chma_challanmasterid'=>$mid),'chma_challanmasterid','ASC');
			$this->data['challan_details']  =$this->challan_mdl->chalandetails(array('chde_challanmasterid'=>$mid));
		}else{
			$this->data['purchased_data']  ='';
			$this->data['challan_details']  ='';
		}
		$this->data['supplier_all'] = $this->general->get_tbl_data('*','dist_distributors',false,'dist_distributor','ASC');
		$this->data['distributor']=$this->general->get_tbl_data('*','dist_distributors',false,'dist_distributor','ASC');
		$seo_data='';
		
		$this->data['fiscal'] = $this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','DESC');

		$this->data['received_no']=$this->general->generate_invoiceno('recm_invoiceno','recm_invoiceno','recm_receivedmaster',RECEIVED_NO_PREFIX,RECEIVED_NO_LENGTH,false,'recm_locationid');

		$this->data['loadselect2']='no';
		//echo"<pre>"; print_r($this->data['purchased_data']);die;
		//echo"<pre>"; print_r($this->data['challan_details']);die;
		$this->data['tab_type'] = 'bill_entry';
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
			->build('challan/v_challan', $this->data);
	}
	public function save_challan_bill_entry()
	{
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
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		try {
			$this->form_validation->set_rules($this->challan_mdl->validate_settings_challan_bill_entry);
			if($this->form_validation->run()==TRUE)
			{
				$trans = $this->challan_mdl->save_challan_bill_entry();
				if($trans)
				{
					$print = $this->input->post('print');
					if($print = "print")
					{	
						$this->data['req_detail_list']=$this->direct_purchase_mdl->get_received_details(array('rd.recd_receivedmasterid'=>$trans));
						
						$receive_master = $this->data['direct_purchase_master']=$this->direct_purchase_mdl->received_master_views(array('rm.recm_receivedmasterid'=>$trans));


						$purchase_order_no = !empty($receive_master[0]->recm_purchaseorderno)?$receive_master[0]->recm_purchaseorderno:'';

						$this->data['challan_no'] = $this->general->get_tbl_data('chma_challanmasterid','chma_challanmaster', array('chma_puorid'=>$purchase_order_no));
						
						$print_report = $this->load->view('challan/v_challan_bill_entry_print', $this->data, true);
					}
					print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully', 'print_report'=>$print_report)));
					exit;
					// print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully')));
					// exit;
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
	public function form_challan_bill_entry()
	{
		$this->data['supplier_all'] = $this->general->get_tbl_data('*','dist_distributors',false,'dist_distributor','ASC');
		$this->data['distributor']=$this->general->get_tbl_data('*','dist_distributors',false,'dist_distributor','ASC');
		$this->data['purchased_data']  ='';
		$this->data['challan_details']  ='';
		$this->data['loadselect2']='yes';

		$this->data['received_no']=$this->general->generate_invoiceno('recm_invoiceno','recm_invoiceno','recm_receivedmaster',RECEIVED_NO_PREFIX,RECEIVED_NO_LENGTH, false, 'recm_locationid');

		$this->data['fiscal'] = $this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','DESC');
		$this->load->view('challan/v_challan_bill_entry', $this->data);
	}

	public function reprint_challan_details()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$id = $this->input->post('id');

			if($id)
			{ 
				$this->data['challans']  = $this->challan_mdl->chalanmaster(array('chma_challanmasterid'=>$id),'chma_challanmasterid');
			
				$this->data['chalan_details'] = $this->challan_mdl->chalandetails(array('chde_challanmasterid'=>$id));

				$template=$this->load->view('challan/v_challan_print_report',$this->data,true);
				
				//print_r($this->data['issue_master']);die;

				if($this->data['challans']>0)
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
	}

	public function load_order_list($type = false)
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			try {	
				$this->data['requistion_departments']= '';
				$this->data['detail_list'] = '';

				if($type == 'challan'){
					$is_challan = 'challan';
				}else{
					$is_challan = '';
				}
				$this->data['is_challan'] = $is_challan;

				$tempform=$this->load->view('challan/v_pur_order_list_modal',$this->data,true);

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

	public function get_order_list_for_challan($is_challan = false){

		if(MODULES_VIEW=='N')
		{
		  	$array=array();
            echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));
            exit;
		}
		
		$fiscalyear= !empty($this->input->get('fiscalyear'))?$this->input->get('fiscalyear'):$this->input->post('fiscalyear');

		if($is_challan == 'challan'){
			$searcharray = array('po.puor_fyear'=>$fiscalyear,'po.puor_storeid'=>$this->storeid,'po.puor_status'=>'CH','po.puor_locationid'=>$this->locationid);
		}else{
			$searcharray = array('po.puor_fyear'=>$fiscalyear,'po.puor_storeid'=>$this->storeid,'po.puor_status !='=>'R','po.puor_locationid'=>$this->locationid);
		}
		
		$this->data['detail_list'] = '';

		$data = $this->challan_mdl->get_order_list($searcharray);
		// echo "<pre>";
		// print_r($data); die;
		// echo $this->db->last_query(); die;
	  	$i = 0;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
	  
		  	foreach($data as $row)
		    {
		    	$array[$i]["masterid"] = $row->puor_purchaseordermasterid;
			    $array[$i]["order_no"] = $row->puor_orderno;
			    $array[$i]["req_no"] = $row->puor_requno;
			    $array[$i]["date"] = $row->puor_orderdatebs;
			    $array[$i]["suppliername"] = $row->dist_distributor;
			    $array[$i]["supplierid"] = $row->puor_supplierid;
			    $array[$i]["amount"] = $row->puor_amount;
			    
			    $i++;
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}

	public function load_detail_list($new_order = false){
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$masterid = $this->input->post('masterid');

			if($new_order == 'new_detail_list_for_bill_entry'){
				$detail_list = $this->data['detail_list'] = $this->challan_mdl->get_order_details_from_po(array('pude_purchasemasterid'=>$masterid));
			}else{
				$detail_list = $this->data['detail_list'] = $this->challan_mdl->get_order_details(array('pude_purchasemasterid'=>$masterid));
			}

			$this->data['received_status'] = !empty($detail_list[0]->puor_purchased)?$detail_list[0]->puor_purchased:0;

			// echo $this->db->last_query();
			// die();

			// echo "<pre>";
			// print_r($detail_list);
			// die();
			
			if(empty($detail_list)){
				$isempty = 'empty';
			}else{
				$isempty = 'not_empty';
			}
			if($new_order == 'new_detail_list'){
				$tempform=$this->load->view('challan/v_pur_order_detail_append',$this->data,true);
			}else if($new_order == 'new_detail_list_for_bill_entry'){
				$tempform=$this->load->view('challan/v_pur_order_detail_for_bill_entry_append',$this->data,true);
			}
			else{
				$tempform=$this->load->view('challan/v_pur_order_detail_modal',$this->data,true);
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

	public function orderlist_by_order_no()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$ordernumber=$this->input->post('orderno');
			$fiscalyear=$this->input->post('fiscalyear');
			$this->data['supplier']=$this->general->get_tbl_data('*','dist_distributors',false,'dist_distributorid','DESC');
			$this->data['receiveno']=$this->general->get_tbl_data('max(convert(chma_challanrecno, SIGNED INTEGER)) as id','chma_challanmaster',array('chma_fyear'=>CUR_FISCALYEAR,'chma_locationid'=>$this->locationid),'chma_challanmasterid','DESC');
			$this->data['fiscal'] = $this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','DESC');
			$order_list = $this->data['order_list'] = $this->challan_mdl->get_order_details_from_po(array('puor_orderno'=>$ordernumber,'puor_fyear'=>$fiscalyear));

			// echo $this->db->last_query();
			// die();

			$purchased=!empty($this->data['order_list'][0]->puor_purchased)?$this->data['order_list'][0]->puor_purchased:'';
			$status=!empty($this->data['order_list'][0]->puor_status)?$this->data['order_list'][0]->puor_status:'';

			if(empty($this->data['order_list']))
			{
				print_r(json_encode(array('status'=>'error','message'=>'Order no. '.$ordernumber .' is not found!!')));
				exit;	
			}

			if($purchased=='2')
			{
				print_r(json_encode(array('status'=>'error','message'=>'Order no. '.$ordernumber.' has been purchased/received completely')));
				exit;	
			}

			if($status=='C')
			{
				print_r(json_encode(array('status'=>'error','message'=>'Order no. '.$ordernumber.'is cancelled.')));
				exit;	
			}

			if($status=='CH')
			{
				print_r(json_encode(array('status'=>'error','message'=>'Order no. '.$ordernumber.'is received through challan.')));
				exit;	
			}

			$tempform=$this->load->view('challan/v_challan_form_details',$this->data,true);
		
			if(!empty($this->data['order_list']))
			{
				print_r(json_encode(array('status'=>'success','message'=>'Challan Detail List.','tempform'=>$tempform)));
			}
			else
			{
				print_r(json_encode(array('status'=>'error','message'=>'Order not found. Please try again.')));
	            exit;
			}
		}
		else
		{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}
	}

	public function orderlist_bill_entry_by_order_no()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$ordernumber=$this->input->post('orderno');
			$fiscalyear=$this->input->post('fiscalyear');
			$this->data['supplier']=$this->general->get_tbl_data('*','dist_distributors',false,'dist_distributorid','DESC');
			$this->data['receiveno']=$this->general->get_tbl_data('max(convert(chma_challanrecno, SIGNED INTEGER)) as id','chma_challanmaster',array('chma_fyear'=>CUR_FISCALYEAR,'chma_locationid'=>$this->locationid),'chma_challanmasterid','DESC');
			$this->data['fiscal'] = $this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','DESC');
			$order_list = $this->data['order_list'] = $this->challan_mdl->get_order_details_from_po(array('puor_orderno'=>$ordernumber,'puor_fyear'=>$fiscalyear));

			// echo $this->db->last_query();
			// die();

			$this->data['received_status'] = 0;

			$order_data = array();

			$order_data['puor_orderdatead'] = $order_list[0]->puor_orderdatead;
			$order_data['puor_orderdatebs'] = $order_list[0]->puor_orderdatebs;
			$order_data['puor_supplierid'] = $order_list[0]->puor_supplierid;
			$order_data['puor_purchaseordermasterid'] = $order_list[0]->puor_purchaseordermasterid;

			$purchased=!empty($this->data['order_list'][0]->puor_purchased)?$this->data['order_list'][0]->puor_purchased:'';
			$status=!empty($this->data['order_list'][0]->puor_status)?$this->data['order_list'][0]->puor_status:'';

			if(empty($this->data['order_list']))
			{
				print_r(json_encode(array('status'=>'error','message'=>'Order no. '.$ordernumber .' is not found!!')));
				exit;	
			}
			if($purchased=='2')
			{
				print_r(json_encode(array('status'=>'error','message'=>'Order no. '.$ordernumber.' has been purchased/received completely')));
				exit;	
			}
			if($status=='C')
			{
				print_r(json_encode(array('status'=>'error','message'=>'Order no. '.$ordernumber.'is cancelled.')));
				exit;	
			}
			if($status=='CH')
			{
				print_r(json_encode(array('status'=>'error','message'=>'Order no. '.$ordernumber.'is received through challan.')));
				exit;	
			}

			$tempform=$this->load->view('challan/v_pur_order_detail_for_bill_entry_append',$this->data,true);
		
			if(!empty($this->data['order_list']))
			{
				print_r(json_encode(array('status'=>'success','message'=>'Challan Detail List.','tempform'=>$tempform, 'order_data'=>$order_data)));
			}
			else
			{
				print_r(json_encode(array('status'=>'error','message'=>'Order not found. Please try again.')));
	            exit;
			}
		}
		else
		{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}
	}

	public function challan_bill_entry_lists()
    {
		$seo_data='';
		$this->data['tab_type'] = 'bill_entry_list';
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
			->build('challan/v_challan', $this->data);
	}

	public function get_challan_bill_entry_lists()
	{	 
		if(MODULES_VIEW=='N')
		{
			$array=array();
		 	// $this->general->permission_denial_message();
		 	echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));			
			exit;
		}
		
		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);
			
	  	$i = 0;
	  	$data = $this->challan_mdl->get_challan_bill_entry_lists();
	  	// echo $this->db->last_query();
	  	// die();
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
		  	foreach($data as $row)
		    {	
		   		$array[$i]["sno"] = $i+1;
		   		$array[$i]['recm_receiveddatebs'] = $row->recm_receiveddatebs;
		   		$array[$i]['recm_fyear'] = $row->recm_fyear;
		   		$array[$i]['recm_invoiceno'] = $row->recm_invoiceno;
		   		$array[$i]['orderno'] = !empty($row->orderno)?$row->orderno:"Challan: ".$row->recm_challanno;
		   		$array[$i]['challano'] = $row->recm_challanno;
		   		$array[$i]['dist_distributor'] = $row->dist_distributor;
		   		$array[$i]['budg_budgetname'] = $row->budg_budgetname;
		   		$array[$i]['recm_discount'] = $row->recm_discount;
		   		$array[$i]['recm_taxamount'] = $row->recm_taxamount;
		   		$array[$i]['recm_clearanceamount'] = $row->recm_clearanceamount;
		   		$array[$i]['recm_posttime'] = $row->recm_posttime;
			   		// $array[$i]['order_date'] = $row->orderdate;
			   		// $array[$i]['rate'] = $row->rate;
			   		// $array[$i]['vat'] = $row->vat;
		   		$disp_var=$this->lang->line('receive_ordered_items_detail');
			   	$array[$i]['recm_status'] = $row->recm_status;
		   		$array[$i]['recm_amount'] = $row->recm_amount;

		   		$array[$i]['challan_history'] = '<a href="javascript:void(0)" data-id="'.$row->orderno.'" data-displaydiv="" data-viewurl='.base_url('issue_consumption/challan/challan_details').' class="view" data-heading="Challan History">'.$row->challanhistory.'</a>';

		   		$array[$i]['action'] = '<a href="javascript:void(0)" data-id="'.$row->recm_receivedmasterid.'" data-displaydiv="" data-viewurl='.base_url('issue_consumption/challan/challan_bill_entry_details').' class="view btn-primary btn-xxs sm-pd" data-heading="'.$disp_var.'"><i class="fa fa-eye" title="Return" aria-hidden="true" ></i></a>';
		   		//$array[$i]['cancel_all'] = ''; purchase_receive/direct_purchase/direct_purchase_details
			    $i++;
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}

	public function challan_bill_entry_details()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$mastid_id=$this->input->post('id');
		$this->data['req_detail_list']=$this->direct_purchase_mdl->get_received_details(array('rd.recd_receivedmasterid'=>$mastid_id));
		
		$this->data['direct_purchase_master']=$this->direct_purchase_mdl->received_master_views(array('rm.recm_receivedmasterid'=>$mastid_id,'recm_status'=>'O'));
		// echo "<pre>";print_r($this->data['req_detail_list']);die();
		$tempform='';
		$tempform=$this->load->view('challan/v_challan_bill_entry_view',$this->data,true);
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

	public function challan_details()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$challan_order_id = $this->input->post('id');

		$this->data['challans']  = $this->challan_mdl->chalanmaster(array('chma_puorid'=>$challan_order_id),'chma_challanmasterid');
			
		// $this->data['chalan_details'] = $this->challan_mdl->chalandetails(array('chma_puorid'=>$challan_order_id));

		$tempform='';
		$tempform=$this->load->view('challan/v_challan_details_view',$this->data,true);
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

	public function challan_bill_entry_reprint()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$id = $this->input->post('id');
				if($id)
				{ 
					$this->data['req_detail_list']=$this->direct_purchase_mdl->get_received_details(array('rd.recd_receivedmasterid'=>$id));
					$receive_master = $this->data['direct_purchase_master']=$this->direct_purchase_mdl->received_master_views(array('rm.recm_receivedmasterid'=>$id));

					$purchase_order_no = !empty($receive_master[0]->recm_purchaseorderno)?$receive_master[0]->recm_purchaseorderno:'';

					$this->data['challan_no'] = $this->general->get_tbl_data('chma_challanmasterid','chma_challanmaster', array('chma_puorid'=>$purchase_order_no));
					
					$template=$this->load->view('challan/v_challan_bill_entry_print',$this->data,true);
					// print_r($template);die;
				if($this->data['req_detail_list']>0)
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

	 public function generate_pdfChallanDetails()
    {	
        $this->data['searchResult'] = $this->challan_mdl->get_challan_list();
        // echo "<pre>";
        // print_r($this->data['searchResult']);
        // die();

        unset($this->data['searchResult']["totalfilteredrecs"]);
        unset($this->data['searchResult']["totalrecs"]);
        
        $this->load->library('pdf');
        $mpdf = $this->pdf->load();
        //echo"<pre>"; print_r($this->data['searchResult']);die;
        ini_set('memory_limit', '256M');
        $html = $this->load->view('challan/v_challan_list_download', $this->data, true);
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
        $output = 'issue_details_list'.date('Y_m_d_H_i').'.pdf';
        $mpdf->Output();
        exit();
    }


     public function generate_pdfBillDetails()
    {	
        $this->data['searchResult'] = $this->challan_mdl->get_challan_bill_entry_lists();
        // echo "<pre>";
        // print_r($this->data['searchResult']);
        // die();

        unset($this->data['searchResult']["totalfilteredrecs"]);
        unset($this->data['searchResult']["totalrecs"]);
        
        $this->load->library('pdf');
        $mpdf = $this->pdf->load();
        //echo"<pre>"; print_r($this->data['searchResult']);die;
        ini_set('memory_limit', '256M');
        $html = $this->load->view('challan/v_bill_list_download', $this->data, true);
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
        $output = 'issue_details_list'.date('Y_m_d_H_i').'.pdf';
        $mpdf->Output();
        exit();
    }

    public function exportToExcelChallanDetails(){
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=issue_details_list".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");
        
        $data = $this->challan_mdl->get_challan_bill_entry_lists();
        $this->data['searchResult'] = $this->challan_mdl->get_challan_list();
        
        $array = array();
        unset($this->data['searchResult']["totalfilteredrecs"]);
        unset($this->data['searchResult']["totalrecs"]);
        $response = $this->load->view('challan/v_challan_list_download', $this->data, true);

        echo $response;
    }

     public function exportToExcelBillDetails(){
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=issue_details_list".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");
        
        $data = $this->challan_mdl->get_challan_bill_entry_lists();
        $this->data['searchResult'] = $this->challan_mdl->get_challan_bill_entry_lists();
        
        $array = array();
        unset($this->data['searchResult']["totalfilteredrecs"]);
        unset($this->data['searchResult']["totalrecs"]);
        $response = $this->load->view('challan/v_bill_list_download', $this->data, true);

        echo $response;
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */