<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Direct_issue extends CI_Controller
{
	function __construct()
	{
			
		parent::__construct();
		$this->load->Model('direct_issue_mdl');
		$this->load->Model('stock_inventory/stock_requisition_mdl');

		$this->username = $this->session->userdata(USER_NAME);
		$this->storeid = $this->session->userdata(STORE_ID);
		$this->locationid=$this->session->userdata(LOCATION_ID);
		
	}
	public function index()
	{   
		 $locationid=$this->session->userdata(LOCATION_ID);
		$this->data['reqno']= $this->input->post('id');
		$this->data['equipmentcategory']=$this->general->get_tbl_data('*','eqca_equipmentcategory',false,'eqca_equipmentcategoryid','DESC');
		$this->data['depatrment']=$this->general->get_tbl_data('*','dept_department',false,'dept_depid','DESC');
		$this->data['item_all']=$this->general->get_tbl_data('*','itli_itemslist',false,'itli_itemlistid','DESC');
		$this->data['fiscal_year']=$this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','DESC','2');
		$this->data['new_issue'] ="";
		$this->data['tab_type']='direct_issue_entry';
		// $this->data['issue_no']=$this->generate_invoiceno();
		$currentfyrs=CUR_FISCALYEAR;

		$cur_fiscalyrs_invoiceno=$this->db->select('sama_invoiceno,sama_fyear')
									->from('sama_salemaster')
									->where('sama_locationid',$locationid)
									->where('sama_fyear',$currentfyrs)
									->order_by('sama_fyear','DESC')
									->order_by('sama_salemasterid','DESC')
									->limit(1)
									->get()->row();

		// echo "<pre>";
		// print_r($cur_fiscalyrs_invoiceno);
		// die();

		if(!empty($cur_fiscalyrs_invoiceno)){
			$invoice_format=$cur_fiscalyrs_invoiceno->sama_invoiceno;
			
			$invoice_string=str_split($invoice_format);
			// echo "<pre>";
			// print_r($invoice_string);
			// die();
			$invoice_prefix_len=strlen(INVOICE_NO_PREFIX);
			$chk_first_string_after_invoice_prefix=$invoice_string[$invoice_prefix_len];
			// echo $chk_first_string_after_invoice_prefix;
			// die();
			if($chk_first_string_after_invoice_prefix =='0'){
				$invoice_no_prefix=INVOICE_NO_PREFIX.CUR_FISCALYEAR;
			}
			else if ($cur_fiscalyrs_invoiceno->sama_fyear==$currentfyrs && $chk_first_string_after_invoice_prefix =='0' ) {
				$invoice_no_prefix=INVOICE_NO_PREFIX.CUR_FISCALYEAR;
			}
			else if ($cur_fiscalyrs_invoiceno->sama_fyear!=$currentfyrs && $chk_first_string_after_invoice_prefix =='0' ) {
				$invoice_no_prefix=INVOICE_NO_PREFIX.CUR_FISCALYEAR;
			}
			else if ($cur_fiscalyrs_invoiceno->sama_fyear!=$currentfyrs && $chk_first_string_after_invoice_prefix !='0' ) {
				$invoice_no_prefix=INVOICE_NO_PREFIX.CUR_FISCALYEAR;
			}
			else{
				$invoice_no_prefix=INVOICE_NO_PREFIX;
			}
			
		}
		else{
			$invoice_no_prefix=INVOICE_NO_PREFIX.CUR_FISCALYEAR;
		}
		// die();

		// if (ORGANIZATION_NAME == 'KU' || ORGANIZATION_NAME =='PU' || ORGANIZATION_NAME == 'NPHL') {

		// 	$invoice_no_prefix = '';

		// 	$this->data['issue_no'] = $this->general->generate_invoiceno('sama_invoiceno', 'sama_invoiceno', 'sama_salemaster', $invoice_no_prefix, INVOICE_NO_LENGTH, array('sama_fyear'=>$currentfyrs), 'sama_locationid', 'sama_salemasterid', 'S', 'DESC', 'Y');

		// 	// $location_fieldname =false,$order_by=false,$order_type='S',$order='DESC',$is_disable_prefix='N')

		// } else {

			$this->data['issue_no'] = $this->general->generate_invoiceno('sama_invoiceno', 'sama_invoiceno', 'sama_salemaster', $invoice_no_prefix, INVOICE_NO_LENGTH, array('sama_fyear'=>$currentfyrs), 'sama_locationid', 'sama_salemasterid', 'S', 'DESC');
		// }
		
		// $this->data['issue_no'] = $this->general->generate_invoiceno('sama_invoiceno','sama_invoiceno','sama_salemaster',$invoice_no_prefix,INVOICE_NO_LENGTH,false,'sama_locationid','sama_salemasterid','S','DESC');

		$cur_fiscalyrs_handover_no=$this->db->select('sama_invoiceno,sama_fyear')
							->from('sama_salemaster')
							->where('sama_locationid',$locationid)
							->where('sama_fyear',$currentfyrs)
							->where('sama_ishandover','Y')
							->order_by('sama_fyear','DESC')
							->order_by('sama_salemasterid','DESC')
							->limit(1)
							->get()->row();

				// echo "<pre>";
				// print_r($cur_fiscalyrs_handover_no);
				// die();

				if(!empty($cur_fiscalyrs_handover_no)){
					$invoice_format_handover=$cur_fiscalyrs_handover_no->sama_invoiceno;
					
					$invoice_string=str_split($invoice_format_handover);
					// echo "<pre>";
					// print_r($invoice_string);
					// die();
					$invoice_prefix_hand_len=strlen(DIRECT_ISSUE_NO_PREFIX);
					$chk_first_string_after_invoice_hand_prefix=$invoice_string[$invoice_prefix_hand_len];
					// echo $chk_first_string_after_invoice_hand_prefix;
					// die();
					if($chk_first_string_after_invoice_hand_prefix =='0'){
						$invoice_no_hand_prefix=DIRECT_ISSUE_NO_PREFIX.CUR_FISCALYEAR;
					}
					else if ($cur_fiscalyrs_handover_no->sama_fyear==$currentfyrs && $chk_first_string_after_invoice_hand_prefix =='0' ) {
						$invoice_no_hand_prefix=DIRECT_ISSUE_NO_PREFIX.CUR_FISCALYEAR;
					}
					else if ($cur_fiscalyrs_handover_no->sama_fyear!=$currentfyrs && $chk_first_string_after_invoice_hand_prefix =='0' ) {
						$invoice_no_hand_prefix=DIRECT_ISSUE_NO_PREFIX.CUR_FISCALYEAR;
					}
					else if ($cur_fiscalyrs_handover_no->sama_fyear!=$currentfyrs && $chk_first_string_after_invoice_hand_prefix !='0' ) {
						$invoice_no_hand_prefix=DIRECT_ISSUE_NO_PREFIX.CUR_FISCALYEAR;
					}
					else{
						$invoice_no_hand_prefix=DIRECT_ISSUE_NO_PREFIX;
					}
					
				}
				else{
					$invoice_no_hand_prefix=DIRECT_ISSUE_NO_PREFIX.CUR_FISCALYEAR;
				}
				
		$this->data['handover_no'] = $this->general->generate_invoiceno('sama_invoiceno','sama_invoiceno','sama_salemaster',$invoice_no_hand_prefix,DIRECT_ISSUE_NO_LENGTH, array('sama_ishandover'=>'Y'),'sama_locationid');

		// echo $this->db->last_query();
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
			->build('issue/v_new_issue', $this->data);
	}

	public function issuedetails()
	{
		$this->data['tab_type']='issuedetails';
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
			->build('issue/v_new_issue', $this->data);
	}
	public function issuebook()
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
			->build('issue/v_new_issue', $this->data);
	}

	public function new_issue_temp()
	{
		$this->data['depatrment']=$this->general->get_tbl_data('*','dept_department',false,'dept_depid','DESC');
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$depid = $this->input->post('depid');
			$this->data['depart'] =  $this->input->post('depid');
			if($depid)
			{
				$this->data['new_issue'] = $this->direct_issue_mdl->get_selected_issue();
				
				$template=$this->load->view('issue/v_temp_new_issue',$this->data,true);
				//echo"<pre>"; print_r($template); die;
			if($this->data['new_issue']>0)
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
	public function save_direct_issue($print =false)
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

			$postdata=$this->input->post();
   			//echo "<pre>";print_r($postdata);die();
   			$req_nochk=$this->check_req_no();
   			// echo $this->db->last_query();
   			// die();
			// echo $req_nochk;
			// if(empty($req_nochk))
			// {
			// 	print_r(json_encode(array('status'=>'error','message'=>'Invalid Requisition No!!')));
			// 		exit;
			// 	// $this->form_validation->set_message('reqno', 'Invalid Requisition No!!');
			// 	// exit;
			// }
			$print_report='';
			$itemsid = $this->input->post('sade_itemsid');
			$qtyinstock = $this->input->post('qtyinstock');
			$isqty = $this->input->post('sade_qty');
			$itmname=$this->input->post('sade_itemsname');
			$reqqty=$this->input->post('remqty');

			$is_handover = $this->input->post('handover');

			$this->form_validation->set_rules($this->direct_issue_mdl->validate_new_issue);
			if($this->form_validation->run()==TRUE)
			{	if(!empty($itemsid))
				{
					foreach($itemsid as $key=>$val){
						$stockval = !empty($qtyinstock[$key])?$qtyinstock[$key]:'';
						$issueqty= !empty($isqty[$key])?$isqty[$key]:'';
						$itemid= !empty($itemsid[$key])?$itemsid[$key]:'';
						$itemStockVal=$this->direct_issue_mdl->check_item_stock($itemid);
						// echo $this->db->last_query();
						// die();
						// print_r($issueqty);
						// die();
						$db_item_stockval=!empty($itemStockVal)?$itemStockVal:0;

						$itmname=!empty($itmname[$key])?$itmname[$key]:'';
						$remQty=!empty($reqqty[$key])?$reqqty[$key]:'';

						if($issueqty>$db_item_stockval)
						{
							print_r(json_encode(array('status'=>'error','message'=>'Issue Qty of Item '.$itmname.' should not exceed stock qty. Please check it.')));
							exit;
						}

						// if($issueqty>$remQty)
						// {
						// 	print_r(json_encode(array('status'=>'error','message'=>'Issue Qty of Item '.$itmname.' should not exceed Req. qty. Please check it.')));
						// 	exit;
						// }
					}
				}

				$trans = $this->direct_issue_mdl->save_direct_issue();

				// $trans = "1";

				if($trans)
				{   
					if($print =="print")
					{	
						$this->data['issue_master'] = $this->general->get_tbl_data('*','sama_salemaster',array('sama_salemasterid'=>$trans),'sama_salemasterid','DESC');

						$this->data['issue_details'] = $this->direct_issue_mdl->get_issue_detail(array('sd.sade_salemasterid'=>$trans));

						$this->data['store']=$this->general->get_tbl_data('eqty_equipmenttype','eqty_equipmenttype',array('eqty_equipmenttypeid'=>$this->session->userdata(STORE_ID)),'eqty_equipmenttypeid','ASC');

						if($is_handover == 'Y'){
							$print_report = $this->load->view('direct_issue/v_direct_issue_print', $this->data, true);
						}else{
							$print_report = $this->load->view('issue/v_new_issue_print', $this->data, true);
						}
						
						//echo "<pre>"; print_r($print_report);die;
					}
					print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully','print_report'=>$print_report)));
					exit;
				}
				else
				{
					print_r(json_encode(array('status'=>'error','message'=>'Unsuccessfull Operation')));
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

	public function form_direct_issue(){
		 $locationid=$this->session->userdata(LOCATION_ID);
		$this->data['reqno']= $this->input->post('id');
		$this->data['equipmentcategory']=$this->general->get_tbl_data('*','eqca_equipmentcategory',false,'eqca_equipmentcategoryid','DESC');
		$this->data['depatrment']=$this->general->get_tbl_data('*','dept_department',false,'dept_depid','DESC');
		$this->data['item_all']=$this->general->get_tbl_data('*','itli_itemslist',false,'itli_itemlistid','DESC');
		$this->data['fiscal_year']=$this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','DESC','2');
		$this->data['new_issue'] ="";
		$this->data['tab_type']='direct_issue_entry';
		// $this->data['issue_no']=$this->generate_invoiceno();
		$currentfyrs=CUR_FISCALYEAR;

		$cur_fiscalyrs_invoiceno=$this->db->select('sama_invoiceno,sama_fyear')
									->from('sama_salemaster')
									->where('sama_locationid',$locationid)
									// ->where('sama_fyear',$currentfyrs)
									->order_by('sama_fyear','DESC')
									->limit(1)
									->get()->row();

		// echo "<pre>";
		// print_r($cur_fiscalyrs_invoiceno);
		// die();

		if(!empty($cur_fiscalyrs_invoiceno)){
			$invoice_format=$cur_fiscalyrs_invoiceno->sama_invoiceno;
			
			$invoice_string=str_split($invoice_format);
			// echo "<pre>";
			// print_r($invoice_string);
			// die();
			$invoice_prefix_len=strlen(INVOICE_NO_PREFIX);
			$chk_first_string_after_invoice_prefix=$invoice_string[$invoice_prefix_len];
			// echo $chk_first_string_after_invoice_prefix;
			// die();
			if($chk_first_string_after_invoice_prefix =='0'){
				$invoice_no_prefix=INVOICE_NO_PREFIX.CUR_FISCALYEAR;
			}
			else if ($cur_fiscalyrs_invoiceno->sama_fyear==$currentfyrs && $chk_first_string_after_invoice_prefix =='0' ) {
				$invoice_no_prefix=INVOICE_NO_PREFIX.CUR_FISCALYEAR;
			}
			else if ($cur_fiscalyrs_invoiceno->sama_fyear!=$currentfyrs && $chk_first_string_after_invoice_prefix =='0' ) {
				$invoice_no_prefix=INVOICE_NO_PREFIX.CUR_FISCALYEAR;
			}
			else if ($cur_fiscalyrs_invoiceno->sama_fyear!=$currentfyrs && $chk_first_string_after_invoice_prefix !='0' ) {
				$invoice_no_prefix=INVOICE_NO_PREFIX.CUR_FISCALYEAR;
			}
			else{
				$invoice_no_prefix=INVOICE_NO_PREFIX;
			}
			
		}
		else{
			$invoice_no_prefix=INVOICE_NO_PREFIX.CUR_FISCALYEAR;
		}
		// die();

		$this->data['issue_no'] = $this->general->generate_invoiceno('sama_invoiceno','sama_invoiceno','sama_salemaster',$invoice_no_prefix,INVOICE_NO_LENGTH,false,'sama_locationid','sama_salemasterid','S','DESC');

		$cur_fiscalyrs_handover_no=$this->db->select('sama_invoiceno,sama_fyear')
							->from('sama_salemaster')
							->where('sama_locationid',$locationid)
							->where('sama_ishandover','Y')
							->order_by('sama_fyear','DESC')
							->limit(1)
							->get()->row();

				// echo "<pre>";
				// print_r($cur_fiscalyrs_handover_no);
				// die();

				if(!empty($cur_fiscalyrs_handover_no)){
					$invoice_format_handover=$cur_fiscalyrs_handover_no->sama_invoiceno;
					
					$invoice_string=str_split($invoice_format_handover);
					// echo "<pre>";
					// print_r($invoice_string);
					// die();
					$invoice_prefix_hand_len=strlen(DIRECT_ISSUE_NO_PREFIX);
					$chk_first_string_after_invoice_hand_prefix=$invoice_string[$invoice_prefix_hand_len];
					// echo $chk_first_string_after_invoice_hand_prefix;
					// die();
					if($chk_first_string_after_invoice_hand_prefix =='0'){
						$invoice_no_hand_prefix=DIRECT_ISSUE_NO_PREFIX.CUR_FISCALYEAR;
					}
					else if ($cur_fiscalyrs_handover_no->sama_fyear==$currentfyrs && $chk_first_string_after_invoice_hand_prefix =='0' ) {
						$invoice_no_hand_prefix=DIRECT_ISSUE_NO_PREFIX.CUR_FISCALYEAR;
					}
					else if ($cur_fiscalyrs_handover_no->sama_fyear!=$currentfyrs && $chk_first_string_after_invoice_hand_prefix =='0' ) {
						$invoice_no_hand_prefix=DIRECT_ISSUE_NO_PREFIX.CUR_FISCALYEAR;
					}
					else if ($cur_fiscalyrs_handover_no->sama_fyear!=$currentfyrs && $chk_first_string_after_invoice_hand_prefix !='0' ) {
						$invoice_no_hand_prefix=DIRECT_ISSUE_NO_PREFIX.CUR_FISCALYEAR;
					}
					else{
						$invoice_no_hand_prefix=DIRECT_ISSUE_NO_PREFIX;
					}
					
				}
				else{
					$invoice_no_hand_prefix=DIRECT_ISSUE_NO_PREFIX.CUR_FISCALYEAR;
				}

		$this->data['handover_no'] = $this->general->generate_invoiceno('sama_invoiceno','sama_invoiceno','sama_salemaster',$invoice_no_hand_prefix,DIRECT_ISSUE_NO_LENGTH, array('sama_ishandover'=>'Y'),'sama_locationid');
		
		$this->load->view('direct_issue/v_direct_new_issue_form',$this->data);
	}

	public function gen_invoice(){
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$fyrs=$this->input->post('fyrs');
			$locationid=$this->session->userdata(LOCATION_ID);
			$fyrs=!empty($fyrs)?$fyrs:CUR_FISCALYEAR;

			$cur_fiscalyrs_invoiceno=$this->db->select('sama_invoiceno,sama_fyear')
									->from('sama_salemaster')
									->where('sama_locationid',$locationid)
									->where('sama_fyear',$fyrs)
									->order_by('sama_salemasterid','DESC')
									->order_by('sama_fyear','DESC')
									->limit(1)
									->get()->row();
								// echo $this->db->last_query();
								// die();

		// echo "<pre>";
		// print_r($cur_fiscalyrs_invoiceno);
		// die();

		if(!empty($cur_fiscalyrs_invoiceno)){
			$invoice_format=$cur_fiscalyrs_invoiceno->sama_invoiceno;
			
			$invoice_string=str_split($invoice_format);
			// echo "<pre>";
			// print_r($invoice_string);
			// die();
			$invoice_prefix_len=strlen(INVOICE_NO_PREFIX);
			$chk_first_string_after_invoice_prefix=$invoice_string[$invoice_prefix_len];
			// echo $chk_first_string_after_invoice_prefix;
			// die();
			if($chk_first_string_after_invoice_prefix =='0'){
				$invoice_no_prefix=INVOICE_NO_PREFIX.$fyrs;
			}
			else if ($cur_fiscalyrs_invoiceno->sama_fyear==$fyrs && $chk_first_string_after_invoice_prefix =='0' ) {
				$invoice_no_prefix=INVOICE_NO_PREFIX.$fyrs;
			}
			else if ($cur_fiscalyrs_invoiceno->sama_fyear!=$fyrs && $chk_first_string_after_invoice_prefix =='0' ) {
				$invoice_no_prefix=INVOICE_NO_PREFIX.$fyrs;
			}
			else if ($cur_fiscalyrs_invoiceno->sama_fyear!=$fyrs && $chk_first_string_after_invoice_prefix !='0' ) {
				$invoice_no_prefix=INVOICE_NO_PREFIX.$fyrs;
			}
			else{
				$invoice_no_prefix=INVOICE_NO_PREFIX;
			}
			
		}
		else{
			$invoice_no_prefix=INVOICE_NO_PREFIX.$fyrs;
		}
		// die();
		
		// echo $invoice_no_prefix;
		// die();

		$issue_no = $this->general->generate_invoiceno('sama_invoiceno','sama_invoiceno','sama_salemaster',$invoice_no_prefix,INVOICE_NO_LENGTH,false,'sama_locationid');
		// echo $issue_no;
		// die();
		$cur_fiscalyrs_handover_no=$this->db->select('sama_invoiceno,sama_fyear')
							->from('sama_salemaster')
							->where('sama_locationid',$locationid)
							->where('sama_fyear',$fyrs)
							->where('sama_ishandover','Y')
							->order_by('sama_fyear','DESC')
							->limit(1)
							->get()->row();

				// echo "<pre>";
				// print_r($cur_fiscalyrs_handover_no);
				// die();

				if(!empty($cur_fiscalyrs_handover_no)){
					$invoice_format_handover=$cur_fiscalyrs_handover_no->sama_invoiceno;
					
					$invoice_string=str_split($invoice_format_handover);
					// echo "<pre>";
					// print_r($invoice_string);
					// die();
					$invoice_prefix_hand_len=strlen(DIRECT_ISSUE_NO_PREFIX);
					$chk_first_string_after_invoice_hand_prefix=$invoice_string[$invoice_prefix_hand_len];
					// echo $chk_first_string_after_invoice_hand_prefix;
					// die();
					if($chk_first_string_after_invoice_hand_prefix =='0'){
						$invoice_no_hand_prefix=DIRECT_ISSUE_NO_PREFIX.$fyrs;
					}
					else if ($cur_fiscalyrs_handover_no->sama_fyear==$fyrs && $chk_first_string_after_invoice_hand_prefix =='0' ) {
						$invoice_no_hand_prefix=DIRECT_ISSUE_NO_PREFIX.$fyrs;
					}
					else if ($cur_fiscalyrs_handover_no->sama_fyear!=$fyrs && $chk_first_string_after_invoice_hand_prefix =='0' ) {
						$invoice_no_hand_prefix=DIRECT_ISSUE_NO_PREFIX.$fyrs;
					}
					else if ($cur_fiscalyrs_handover_no->sama_fyear!=$fyrs && $chk_first_string_after_invoice_hand_prefix !='0' ) {
						$invoice_no_hand_prefix=DIRECT_ISSUE_NO_PREFIX.$fyrs;
					}
					else{
						$invoice_no_hand_prefix=DIRECT_ISSUE_NO_PREFIX;
					}
					
				}
				else{
					$invoice_no_hand_prefix=DIRECT_ISSUE_NO_PREFIX.$fyrs;
				}

		$handover_no = $this->general->generate_invoiceno('sama_invoiceno','sama_invoiceno','sama_salemaster',$invoice_no_hand_prefix,DIRECT_ISSUE_NO_LENGTH, array('sama_ishandover'=>'Y'),'sama_locationid');

		if (ORGANIZATION_NAME == 'KU' || ORGANIZATION_NAME == 'PU' || ORGANIZATION_NAME == 'ARMY' ) {

				$invoice_no_prefix = '';

				// $issue_no = $this->general->generate_invoiceno('sama_invoiceno','sama_invoiceno','sama_salemaster',$invoice_no_prefix,INVOICE_NO_LENGTH,false,'sama_locationid',false,false,false,'Y');
				$issue_no = $this->general->generate_invoiceno('sama_invoiceno', 'sama_invoiceno', 'sama_salemaster', $invoice_no_prefix, INVOICE_NO_LENGTH, array('sama_fyear'=>$fyrs), 'sama_locationid', 'sama_salemasterid', 'S', 'DESC', 'Y');

				// $location_fieldname =false,$order_by=false,$order_type='S',$order='DESC',$is_disable_prefix='N')

			} else {

				$issue_no = $this->general->generate_invoiceno('sama_invoiceno', 'sama_invoiceno', 'sama_salemaster', $invoice_no_prefix, INVOICE_NO_LENGTH, array('sama_fyear'=>$fyrs), 'sama_locationid', 'sama_salemasterid', 'S', 'DESC');
			}

		print_r(json_encode(array('status'=>'success','issue_no'=>$issue_no,'handover_no'=>$handover_no)));
			exit;
		}
		else{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
			exit;
		}
	}

	public function check_req_no()
	{
		$req_no=$this->input->post('sama_requisitionno');
			$fyear=$this->input->post('sama_fyear');
			$storeid=!empty($this->session->userdata(STORE_ID))?$this->session->userdata(STORE_ID):1;
			
			$srchcol=array('rema_reqno'=>$req_no,'rema_fyear'=>$fyear,'rema_reqtodepid'=>$storeid,'rema_approved'=>'1');
			
			$this->data['req_data']=$this->stock_requisition_mdl->get_req_no_list($srchcol, 'rema_reqno','desc');
			// echo $this->db->last_query();
			// die();
			if(!empty($this->data['req_data']))
			{
				return 1;
			}
			else
			{
				return 0;
			}

	}

	public function issuelist_by_req_no()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$req_no=$this->input->post('req_no');
			$fyear=$this->input->post('fyear');
			$storeid=!empty($this->session->userdata(STORE_ID))?$this->session->userdata(STORE_ID):1;
			
			$srchcol=array('rema_reqno'=>$req_no,'rema_fyear'=>$fyear,'rema_reqtodepid'=>$storeid);
			
			$this->data['req_data']=$this->stock_requisition_mdl->get_req_no_list($srchcol, 'rema_reqno','desc');
			// echo $this->db->last_query();
			// die();
			// echo "<pre>";print_r($this->data['req_data']);die();
			$req_data=array();
			if(!empty($this->data['req_data']))
			{
				$masterid=$this->data['req_data'][0]->rema_reqmasterid;
				$isapproved=!empty($this->data['req_data'][0]->rema_approved)?$this->data['req_data'][0]->rema_approved:'0';
				// echo $isapproved;
				// die();
				if(DEFAULT_DATEPICKER=='NP')
				{
					$req_data['req_date']=$this->data['req_data'][0]->rema_reqdatebs;
				}
				else
				{
					$req_data['req_date']=$this->data['req_data'][0]->rema_reqdatead;
				}
				$req_data['fromdepid']=$this->data['req_data'][0]->rema_reqfromdepid;
				$req_data['reqby']=$this->data['req_data'][0]->rema_reqby;
				if($isapproved=='0' && empty($isapproved) )
				{
					print_r(json_encode(array('status'=>'error','message'=>'Requested requisition number is not approved !!')));
					exit;
				}
				else
				{
					print_r(json_encode(array('status'=>'success','message'=>'Data Selected  Successfully!!','masterid'=>$masterid,'req_data'=>$req_data)));
				exit;
				}
				
			}
			else
			{
				print_r(json_encode(array('status'=>'error','message'=>'Invalid Requisition Number!!!')));
							exit;
			}
		}
		else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
			exit;
		}
	}
	public function issue_book_details_list()
	{  
		if($_SERVER['REQUEST_METHOD'] === 'POST') {
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
	  	// if($apptype == 'cancel'){
	  	// 	$data = $this->direct_issue_mdl->get_issue_book_list(array('sama_st'=>'C'));	
	  	// }else if($apptype == 'issuereturn'){
	  	// 	$data = $this->direct_issue_mdl->get_issue_return_list(array('rema_st'=>'N'));
	  	// }else if($apptype == 'returncancel'){
	  	// 	$data = $this->direct_issue_mdl->get_issue_return_list(array('rema_st'=>'C'));
	  	// }else if($apptype == 'issue' || empty($apptype)){
	  	// 	$data = $this->direct_issue_mdl->get_issue_book_list(array('sama_st'=>'N'));
	  	// }//echo $this->db->last_query();die();
	  	$data = $this->direct_issue_mdl->get_issue_book_details_list();
	  	//echo "<pre>";print_r($data);die();
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];
	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
	  	if($apptype == 'cancel' || $apptype =='issue' || empty($apptype) ){
	  		foreach($data as $row)
			{
				if(ITEM_DISPLAY_TYPE=='NP'){
                	$req_itemname = !empty($row->itli_itemnamenp)?$row->itli_itemnamenp:$row->itli_itemname;
                }else{ 
                    $req_itemname = !empty($row->itli_itemname)?$row->itli_itemname:'';
                }

				$appclass='';
		    	$approved=$row->sama_st;
		    	if($approved=='C')
		    	{
		    		$appclass='cancel';
		    	}
		    	$array[$i]["approvedclass"] = $appclass;
			 	$array[$i]['salemasterid']=$row->sama_salemasterid;
			 	$array[$i]["invoiceno"]=$row->sama_invoiceno;
			
			if(DEFAULT_DATEPICKER=='NP')
			{
				$array[$i]["billdatebs"]=$row->sama_billdatebs;
			}else{
				$array[$i]["billdatebs"]=$row->sama_billdatead;
			}
			 	
			 	$array[$i]["depname"]=$row->sama_depname;
			 	$array[$i]["totalamount"]=$row->sama_totalamount;
			 	$array[$i]["username"]=$row->sama_username;
			 	$array[$i]["memno"]=$row->sama_receivedby;
			 	$array[$i]["requisitionno"]=$row->sama_requisitionno;
		 		$array[$i]["billtime"]=$row->sama_billtime;
		 		
		 		$array[$i]["sade_qty"]= number_format($row->sade_qty);
		 		$array[$i]["sade_unitrate"]=number_format($row->sade_unitrate);
		 		$array[$i]["issueamt"]= number_format($row->issueamt,2);
		 		$array[$i]["itli_itemcode"]=$row->itli_itemcode;
		 		$array[$i]["itli_itemname"]=$req_itemname;
		 		$array[$i]["sade_remarks"]=$row->sade_remarks;

		 		$array[$i]["action"]='';
				$i++;
			}
	  	}
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}
	public function exportToExcelIssueDetails(){
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=issue_details_list".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");
        
        $data = $this->direct_issue_mdl->get_issue_book_details_list();
        $this->data['searchResult'] = $this->direct_issue_mdl->get_issue_book_details_list();
        
        $array = array();
        unset($this->data['searchResult']["totalfilteredrecs"]);
        unset($this->data['searchResult']["totalrecs"]);
        $response = $this->load->view('issue/v_issue_details_download', $this->data, true);

        echo $response;
    }

    public function generate_pdfIssueDetails()
    {	
        $this->data['searchResult'] = $this->direct_issue_mdl->get_issue_book_details_list();

        unset($this->data['searchResult']["totalfilteredrecs"]);
        unset($this->data['searchResult']["totalrecs"]);
        
        $this->load->library('pdf');
        $mpdf = $this->pdf->load();
        //echo"<pre>"; print_r($this->data['searchResult']);die;
        ini_set('memory_limit', '256M');
        $html = $this->load->view('issue/v_issue_details_download', $this->data, true);
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
	public function issue_book_list()
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

	  	if($apptype == 'cancel'){
	  		$data = $this->direct_issue_mdl->get_issue_book_list(array('sama_st'=>'C'));	
	  	}else if($apptype == 'issuereturn'){
	  		$data = $this->direct_issue_mdl->get_issue_return_list(array('rema_st'=>'N'));
	  	}else if($apptype == 'returncancel'){
	  		$data = $this->direct_issue_mdl->get_issue_return_list(array('rema_st'=>'C'));
	  	}else if($apptype == 'issue' || empty($apptype)){
	  		$data = $this->direct_issue_mdl->get_issue_book_list(array('sama_st'=>'N'));
	  	}
	  	// else
	  	// {//this is for total click from dashboard
	  	// 	$data = $this->direct_issue_mdl->get_issue_book_list();
	  	// }
	  	// echo $this->db->last_query();die();
	  	//echo"<pre>";print_r($apptype);die;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
	  	if($apptype == 'cancel' || $apptype =='issue' || empty($apptype) ){
	  		foreach($data as $row)
			{
				if(ITEM_DISPLAY_TYPE=='NP'){
                	$req_itemname = !empty($row->itli_itemnamenp)?$row->itli_itemnamenp:$row->itli_itemname;
                }else{ 
                    $req_itemname = !empty($row->itli_itemname)?$row->itli_itemname:'';
                }

				$appclass='';
		    	$approved=$row->sama_st;
		    	if($approved=='C')
		    	{
		    		$appclass='cancel';
		    	}
		    	$array[$i]["approvedclass"] = $appclass;
			 	$array[$i]['salemasterid']=$row->sama_salemasterid;
			 	$array[$i]["invoiceno"]=$row->sama_invoiceno;
			 	if(DEFAULT_DATEPICKER=='NP')
			 	{
					$array[$i]["billdatebs"]=$row->sama_billdatebs;
			 	}else{
					$array[$i]["billdatebs"]=$row->sama_billdatead;
			 	}
			 	
			 	$array[$i]["depname"]=$row->sama_depname;
			 	$array[$i]["totalamount"]=$row->totalamt;
			 	$array[$i]["username"]=$row->sama_username;
			 	$array[$i]["memno"]=$row->sama_receivedby;
			 	$array[$i]["requisitionno"]=$row->sama_requisitionno;
		 		$array[$i]["billtime"]=$row->sama_billtime;
		 		$array[$i]["billno"]=$row->sama_billno;
		 		$array[$i]["fyear"]=$row->sama_fyear;

		 		if($apptype == 'issue' || empty($apptype)):
		 			$array[$i]["action"]='
		 			<a href="javascript:void(0)" data-id='.$row->sama_invoiceno.' data-date='.$row->sama_billdatebs.' data-viewurl='.base_url('issue_consumption/new_issue/issue_cancel').' class="redirectedit  btn-danger btn-xxs" title="Issue Cancel"><i class="fa fa-times-rectangle" aria-hidden="true"></i></a> <a href="javascript:void(0)" data-id='.$row->sama_invoiceno.' data-detailid='.$row->sama_fyear.' data-date='.$row->sama_billdatebs.' data-viewurl='.base_url('issue_consumption/new_issue/issue_return').' class="redirectedit  btn-info btn-xxs"><i class="fa fa-undo" title="Issue Return" aria-hidden="true" ></i></a>  <a href="javascript:void(0)" data-id='.$row->sama_salemasterid.' data-invoiceno='.$row->sama_invoiceno.' data-fyear='.$row->sama_fyear.' data-displaydiv="IssueDetails" data-viewurl='.base_url('issue_consumption/new_issue/issue_details_views').' class="view btn-primary badge" data-heading='.$this->lang->line('issue_details').' title='.$this->lang->line('issue_details').'>'.$row->totcnt.'</a>';	
		 		else:
		 			$array[$i]["action"] = "";
		 		endif;

				$i++;
			}
	  	}
	  	else if($apptype == 'issuereturn' || $apptype == 'returncancel'){
	  		foreach($data as $row):
	  			$appclass='';
		    	$approved=$row->rema_st;
		    	if($approved=='C')
		    	{
		    		$appclass='returncancel';
		    	}else{
		    		$appclass='issuereturn';
		    	}

		    	$array[$i]["approvedclass"] = $appclass;
		  		$array[$i]['salemasterid']=$row->rema_returnmasterid;
			 	$array[$i]["invoiceno"]=$row->rema_receiveno;
			 	if(DEFAULT_DATEPICKER=='NP')
			 	{
					$array[$i]["billdatebs"]=$row->rema_returndatebs;
			 	}else{
					$array[$i]["billdatebs"]=$row->rema_returndatead;
			 	}
			 	$array[$i]["depname"]=$row->dept_depname;
			 	$array[$i]["totalamount"]=$row->rema_amount;
			 	$array[$i]["username"]=$row->rema_username;
			 	$array[$i]["memno"]=$row->rema_returnby;
			 	$array[$i]["requisitionno"]=$row->rema_invoiceno;
		 		$array[$i]["billtime"]=$row->rema_returntime;
		 		$array[$i]["billno"]=$row->rema_fyear;	

		 		if($apptype == 'issuereturn'):
		 			$array[$i]["action"]='<a href="javascript:void(0)" data-id='.$row->rema_invoiceno.' data-date='.$row->rema_returndatebs.' data-viewurl='.base_url('issue_consumption/new_issue/issue_returncancel').' class="redirectedit btn btn-danger btn-xs"><i class="fa fa-times" title="Return Cancel" aria-hidden="true" ></i></a>';	
		 		elseif($apptype == 'returncancel'):
		 			$array[$i]["action"]="";
		 		else:
		 			$array[$i]["action"] = "";
		 		endif;

				$i++;
			endforeach;
	  	}
		
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}
	public function generate_pdfIssueBookList()
    {
    	$apptype = $this->input->get('apptype');
		if($apptype == 'cancel'){
	  		$this->data['searchResult'] = $this->direct_issue_mdl->get_issue_book_list(array('sama_st'=>'C'));	
	  	}else if($apptype == 'issuereturn'){
	  		$this->data['searchResult'] = $this->direct_issue_mdl->get_issue_return_list(array('rema_st'=>'N'));
	  	}else if($apptype == 'returncancel'){
	  		$this->data['searchResult'] = $this->direct_issue_mdl->get_issue_return_list(array('rema_st'=>'C'));
	  	}else if($apptype == 'issue' || empty($apptype)){
	  		$this->data['searchResult'] = $this->direct_issue_mdl->get_issue_book_list(array('sama_st'=>'N'));
	  	}
       // $this->data['searchResult'] = $this->stock_requisition_mdl->get_requisition_list();
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);
        $this->load->library('pdf');
        $mpdf = $this->pdf->load();
        //echo"<pre>";print_r($this->data['searchResult']);die;
        ini_set('memory_limit', '256M');
        $html = $this->load->view('issue/v_new_issue_download', $this->data, true);
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
        $output = 'new_issue'.date('Y_m_d_H_i').'.pdf';
        $mpdf->Output();
        exit();
    }
    public function exportToExcelIssueBookList(){
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=new_issue".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");

        //$data = $this->issue_requisition_mdl->get_requisition_list();
           		$apptype = $this->input->get('apptype');
		if($apptype == 'cancel'){
	  		$data = $this->direct_issue_mdl->get_issue_book_list(array('sama_st'=>'C'));	
	  	}else if($apptype == 'issuereturn'){
	  		$data = $this->direct_issue_mdl->get_issue_return_list(array('rema_st'=>'N'));
	  	}else if($apptype == 'returncancel'){
	  		$data = $this->direct_issue_mdl->get_issue_return_list(array('rema_st'=>'C'));
	  	}else if($apptype == 'issue' || empty($apptype)){
	  		$data = $this->direct_issue_mdl->get_issue_book_list(array('sama_st'=>'N'));
	  	}

        //$this->data['searchResult'] = $this->issue_requisition_mdl->get_requisition_list();
           		//$apptype = $this->input->get('apptype');
		if($apptype == 'cancel'){
	  		$this->data['searchResult'] = $this->direct_issue_mdl->get_issue_book_list(array('sama_st'=>'C'));	
	  	}else if($apptype == 'issuereturn'){
	  		$this->data['searchResult'] = $this->direct_issue_mdl->get_issue_return_list(array('rema_st'=>'N'));
	  	}else if($apptype == 'returncancel'){
	  		$this->data['searchResult'] = $this->direct_issue_mdl->get_issue_return_list(array('rema_st'=>'C'));
	  	}else if($apptype == 'issue' || empty($apptype)){
	  		$this->data['searchResult'] = $this->direct_issue_mdl->get_issue_book_list(array('sama_st'=>'N'));
	  	}
        
        $array = array();
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);
        $response = $this->load->view('issue/v_new_issue_download', $this->data, true);

        echo $response;
    }
	public function reprint_issue_details()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$id = $this->input->post('id');
			if($id)
			{ 
				$this->data['issue_master'] = $this->general->get_tbl_data('*','sama_salemaster',array('sama_salemasterid'=>$id),'sama_salemasterid','DESC');
				
				$this->data['issue_details'] = $this->direct_issue_mdl->get_issue_detail(array('sd.sade_salemasterid'=>$id));

				$this->data['store']=$this->general->get_tbl_data('eqty_equipmenttype','eqty_equipmenttype',array('eqty_equipmenttypeid'=>$this->session->userdata(STORE_ID)),'eqty_equipmenttypeid','ASC');
				//echo"<pre>";print_r($this->data['issue_details']);die();
				//$template=$this->load->view('issue/v_new_issue_reprint',$this->data,true);
				$template=$this->load->view('issue/v_new_issue_print',$this->data,true);
				 
				if($this->data['issue_master']>0)
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
	public function issue_details_views()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$id = $this->input->post('id');
				$invoiceno = $this->input->post('invoiceno');
				$fyear = $this->input->post('fiscal_year');

				if($id)
				{ 
					$this->data['issue_master'] = $this->general->get_tbl_data('*','sama_salemaster',array('sama_salemasterid'=>$id),'sama_salemasterid','DESC');
					$this->data['issue_details'] = $this->direct_issue_mdl->get_issue_detail(array('sd.sade_salemasterid'=>$id));

					$this->data['all_issue_details'] = $this->direct_issue_mdl->get_all_issue_details($id, $invoiceno, $fyear);
					//echo $this->db->last_query();die;
					//echo"<pre>";print_r($this->data['issue_details']);die();
					$template=$this->load->view('issue/v_issue_details_view',$this->data,true);
					if($this->data['issue_master']>0)
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
	public function issue_cancel(){

		$this->data['tab_type']='cancel';

		$this->data['issue_no']=$this->generate_invoiceno();
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
			->build('issue/v_new_issue', $this->data);
	}

	public function issue_cancel_item()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			try {
			$sade_id=$this->input->post('id');
			// echo $sade_id;
			// die();
			$sade_data=$this->direct_issue_mdl->get_issue_detail(array('sade_saledetailid'=>$sade_id));
			// echo "<pre>";
			// print_r($sade_data);
			// die();
			if(empty($sade_data))
			{
				print_r(json_encode(array('status'=>'error','message'=>'Unable to cancel this Item !!!')));
				exit;
			}
			else
			{
				$qty=$sade_data[0]->sade_qty;
				$mat_transdetailid=$sade_data[0]->sade_mattransdetailid;
				$iscancel=$sade_data[0]->sade_iscancel;
				if($iscancel=='Y')
				{
					print_r(json_encode(array('status'=>'error','message'=>'Already Cancel this Item !!!')));
					exit;
				}

				$update_sd=$this->direct_issue_mdl->update_salesdetail($sade_id);
				$mat_trans=$this->direct_issue_mdl->update_mat_trans_detailid($mat_transdetailid,$qty);

				print_r(json_encode(array('status'=>'success','message'=>'Successfully Cancelled !!!')));
				exit;

			}

			}catch (Exception $e) {
            print_r(json_encode(array('status'=>'error','message' => $e->getMessage())));
        	}
		}
			else
			{
				print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
				exit;
			}
	}

	public function issue_cancel_item_all()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			try {
			$sama_id=$this->input->post('id');
			// echo $sama_id;
			// die();
			$sama_data=$this->direct_issue_mdl->get_issue_master(array('sama_salemasterid'=>$sama_id));
			// echo "<pre>";
			// print_r($sama_data);
			// die();

			$reqno = !empty($sama_data[0]->sama_requisitionno)?$sama_data[0]->sama_requisitionno:'';
			$fyear = !empty($sama_data[0]->sama_fyear)?$sama_data[0]->sama_fyear:'';
			$storeid = !empty($sama_data[0]->sama_storeid)?$sama_data[0]->sama_storeid:'';
			$locationid = !empty($sama_data[0]->sama_locationid)?$sama_data[0]->sama_locationid:'';
			$depid = !empty($sama_data[0]->sama_depid)?$sama_data[0]->sama_depid:'';

			if(empty($sama_data))
			{
				print_r(json_encode(array('status'=>'error','message'=>'Unable to cancel')));
				exit;
			}

			if($sama_data[0]->sama_st=='C')
			{
				print_r(json_encode(array('status'=>'error','message'=>'Already cancel this issue no!!')));
				exit;
			}
			else
			{

				$this->db->trans_begin();

				$this->direct_issue_mdl->update_salesmaster($sama_id);

				$sade_data=$this->direct_issue_mdl->get_issue_detail(array('sade_salemasterid'=>$sama_id));
				// echo "<pre>";
				// print_r($sade_data);
				// die();

				// $this->direct_issue_mdl->update_reqmaster($reqno,$fyear,$storeid,$depid,$locationid);

				if(!empty($sade_data))
				{
					foreach ($sade_data as $ksd => $sade) {
						$saledetailid=$sade->sade_saledetailid;
						$qty=$sade->sade_qty;
						$mat_transdetailidid=$sade->sade_mattransdetailid;
						$iscancel=$sade->sade_iscancel;
						$reqdetailid = $sade->sade_reqdetailid;

						if($iscancel!='Y')
						{
							$update_sd=$this->direct_issue_mdl->update_salesdetail($saledetailid);
						}
					
						if($mat_transdetailidid)
						{
							$mat_trans=$this->direct_issue_mdl->update_mat_trans_detailid($mat_transdetailidid,$qty);
						}

						if($reqdetailid){
							$update_reqdetail = $this->direct_issue_mdl->update_reqdetail($reqdetailid);
						}

					}
				}

				$this->db->trans_complete();
				if ($this->db->trans_status() === FALSE){
					$this->db->trans_rollback();
					trigger_error("Commit failed");
					// return false;
				}
				else{
					$this->db->trans_commit();
				}

				print_r(json_encode(array('status'=>'success','message'=>'Successfully Cancelled !!!')));
				exit;

			}

			}catch (Exception $e) {
            print_r(json_encode(array('status'=>'error','message' => $e->getMessage())));
        	}
		}
			else
			{
				print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
				exit;
			}
	}
	public function issue_return(){

		$this->data['tab_type']='return';
		$this->data['fiscal'] = $this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','DESC');
		$this->data['return_issue_no']=$this->generate_return_invoiceno();
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
			->build('issue/v_new_issue', $this->data);
	}

	public function form_issue_return(){
		$this->data['tab_type']='return';
		$this->data['fiscal'] = $this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','DESC');
		$this->data['return_issue_no']=$this->generate_return_invoiceno();

		$this->load->view('issue/v_issue_return',$this->data);
	}

	public function issuelist_by_issue_no()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$issue_no=$this->input->post('issue_no');
				$issue_date=$this->input->post('issue_date');
				$this->storeid = $this->session->userdata(STORE_ID);
			
				if(DEFAULT_DATEPICKER=='NP')
				{
					$srchcol=array('sama_billdatebs'=>$issue_date,'sama_invoiceno'=>$issue_no,'sama_storeid'=>$this->storeid);
				}
				else
				{
					$srchcol=array('sama_billdatead'=>$issue_date,'sama_invoiceno'=>$issue_no,'sama_storeid'=>$this->storeid);
				}
				
				$this->data['issue_data']=$this->direct_issue_mdl->get_issue_master($srchcol);
				// echo $this->db->last_query();
				// die();
				// echo "<pre>";
				// print_r($this->data['issue_data']);
				// die();
				
				if(empty($this->data['issue_data'][0]))
				{
					print_r(json_encode(array('status'=>'error','message'=>'Cannot Cancel this issue.!!!')));
					exit;	
				}

				$this->data['issue_detail']=array();
				$tempform='';
				if($this->data['issue_data'])
				{
				$issuemasterid=$this->data['issue_data'][0]->sama_salemasterid;
				$this->data['issue_detail']=$this->direct_issue_mdl->get_issue_detail(array('sade_salemasterid'=>$issuemasterid));
				// 	// echo "<pre>";
				// 	// print_r($this->data['order_detail']);
				// 	// die();
					if($this->data['issue_detail'])
					{
						$tempform=$this->load->view('issue/v_issue_list_for_cancel',$this->data,true);
					}
				
				}
				print_r(json_encode(array('status'=>'success','issue_data'=>$this->data['issue_data'],'tempform'=>$tempform,'message'=>'Selected Successfully')));
				exit;	

			}
			else
			{
				print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
				exit;
			}
	}

	public function issuelist_by_issue_no_for_return()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$issue_no=$this->input->post('issue_no');
				$fiscalyrs=$this->input->post('fiscalyrs');
				$this->storeid=$this->session->userdata(STORE_ID);
				
				$srchcol=array('sama_fyear'=>$fiscalyrs,'sama_invoiceno'=>$issue_no,'sama_storeid'=>$this->storeid);			
				$this->data['issue_data']=$this->direct_issue_mdl->get_issue_master($srchcol);
				// echo "<pre>";
				// print_r($this->data['issue_data']);
				// die();
				// echo $this->db->last_query();
				// die();
				
				if(empty($this->data['issue_data']))
				{
					print_r(json_encode(array('status'=>'error','message'=>'Invalid Issue No.!!!')));
					exit;	
				}

				$this->data['issue_detail']=array();
				$tempform='';
				if($this->data['issue_data'])
				{
				$issuemasterid=$this->data['issue_data'][0]->sama_salemasterid;
				$this->data['issue_detail']=$this->direct_issue_mdl->get_issue_detail(array('sade_salemasterid'=>$issuemasterid));
				$this->data['issuemasterid']=$issuemasterid;
				// 	// echo "<pre>";
				// 	// print_r($this->data['order_detail']);
				// 	// die();
					if($this->data['issue_detail'])
					{
						$tempform=$this->load->view('issue/v_issue_list_for_return',$this->data,true);
					}
				
				}
				print_r(json_encode(array('status'=>'success','issue_data'=>$this->data['issue_data'],'tempform'=>$tempform,'message'=>'Selected Successfully')));
				exit;	

			}
			else
			{
				print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
				exit;
			}
	}
	
	public function exportToExcel(){
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=stock_requisition_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");
        
        $data = $this->store_requisition_mdl->get_store_requisition_list();
        
        $array = array();
        unset($data["totalfilteredrecs"]);
        unset($data["totalrecs"]);

        $response = '<table border="1">';
        $response .= '<tr><th colspan="7"><center>Store Requisition</center></th></tr>';
        $response .= '<tr><th >S.n.</th>
                    <th>Req.No</th>
                    <th>Req.Date(BS)</th>
                    <th>Req.Date(AD)</th>
                    <th>Req.Time</th>
                    <th>Req.By</th>
                    <th>F.Year</th>
                    <th>Cost Center</th></tr>';

        $i=1;
        $iDisplayStart = !empty($_GET['iDisplayStart'])?$_GET['iDisplayStart']:0;
        foreach($data as $row){
            $sno = $iDisplayStart + $i; 
            $reqdatebs = $row->reno_reqdatebs;
	   	 	$reqdatead = $row->reno_reqdatead;
	   	 	$reqno = $row->reno_reqno;
	   	 	$reqtime = $row->reno_reqtime;
	   	 	$appliedby = $row->reno_appliedby;
	   	 	$fyear = $row->reno_fyear;
	   	 	$costcenter = $row->reno_costcenter;

            $response .= '<tr><td>'.$sno.'</td><td>'.$reqno.'</td><td>'.$reqdatebs.'</td><td>'.$reqdatead.'</td><td>'.$reqtime.'</td><td>'.$appliedby.'</td><td>'.$fyear.'</td><td>'.$costcenter.'</td></tr>';
            $i++;
        }
        
        $response .= '</table>';

        echo $response;
    }

    public function save_requisition()
    {
    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		try {
			$id=$this->input->post('id');
			// if($id)
			// {
			// 		$this->data['item_data']=$this->store_requisition_mdl->get_all_itemlist(array('it.itli_itemlistid'=>$id));
			// 	// echo "<pre>";
			// 	// print_r($data['dept_data']);
			// 	// die();
			// if($this->data['item_data'])
			// {
			// 	$p_date=$this->data['item_data'][0]->itli_postdatead;
			// 	$p_time=$this->data['item_data'][0]->itli_posttime;
			// 	$editstatus=$this->general->compute_data_for_edit($p_date,$p_time);
			// 	$usergroup=$this->session->userdata(USER_GROUPCODE);
				
			// 	if($editstatus==0 && $usergroup!='SA' )
			// 	{
			// 		   $this->general->disabled_edit_message();

			// 	}

			// }
			// }

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

			$this->form_validation->set_rules($this->store_requisition_mdl->validate_settings_requisition);
			// }
			
			  if($this->form_validation->run()==TRUE)
			 {

            $trans = $this->store_requisition_mdl->store_requisition_save();
            if($trans)
            {
            	
            	  print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully')));
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
    }
 		else
    		{
    	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
            exit;
    }
  }

  public function form_store_requisition()
  {
  	$reqdata=$this->general->get_tbl_data('MAX(reno_reqno)+1 as maxreqno','reno_requisitionnote',array('reno_fyear'=>CUR_FISCALYEAR),false,false);
		 $this->data['req_no']=!empty($reqdata[0]->maxreqno)?$reqdata[0]->maxreqno:'1';
		$this->load->view('store_requisition/store_requisition_form',$this->data);

  }

  public function generate_invoiceno()
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

  	if(ORGANIZATION_NAME == 'NPHL'){
  		$prefix = 'E';
  	}

  	$this->db->select('sama_invoiceno');
  	$this->db->from('sama_salemaster');
  	$this->db->where('sama_invoiceno LIKE '.'"%'.INVOICE_NO_PREFIX.$prefix.'%"');
  	$this->db->where('sama_ishandover','N');
  	$this->db->where('sama_locationid',$this->locationid);
  	$this->db->limit(1);
  	$this->db->order_by('sama_invoiceno','DESC');
  	$query = $this->db->get();
        // echo $this->db->last_query(); die();
  	$dbinvoiceno='';
        if ($query->num_rows() > 0) 
        {
            $dbinvoiceno=$query->row()->sama_invoiceno;         
        }

      $invoiceno=$this->general->stringseperator($dbinvoiceno,'number');
      $nw_invoice = str_pad($invoiceno + 1, INVOICE_NO_LENGTH, 0, STR_PAD_LEFT);
      return INVOICE_NO_PREFIX.$prefix.$nw_invoice;
  }

  public function generate_return_invoiceno()
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

  	if(ORGANIZATION_NAME == 'NPHL'){
  		$prefix = 'E';
  	}

  	$this->db->select('rema_invoiceno');
  	$this->db->from('rema_returnmaster');
  	$this->db->where('rema_invoiceno LIKE '.'"%'.RETURN_NO_PREFIX.$prefix.'%"');
  	$this->db->where('sama_locationid',$this->locationid);
  	$this->db->limit(1);
  	$this->db->order_by('rema_invoiceno','DESC');
  	$query = $this->db->get();
        // echo $this->db->last_query(); die();
  	$dbinvoiceno='';
        if ($query->num_rows() > 0) 
        {
            $dbinvoiceno=$query->row()->rema_invoiceno;         
        }

      $invoiceno=$this->general->stringseperator($dbinvoiceno,'number');
      $nw_invoice = str_pad($invoiceno + 1, RETURN_NO_LENGTH, 0, STR_PAD_LEFT);
      return RETURN_NO_PREFIX.$prefix.$nw_invoice;
  	}

  	// public function generate_handoverno()
  	// {
  	// 	$curmnth=CURMONTH;
  	// 	if($curmnth==1)
  	// 	{	
  	// 		$prefix='A';
  	// 	}
  	// 	if($curmnth==2)
	  // 	{
	  // 		$prefix='B';
	  // 	}
	  // 	if($curmnth==3)
	  // 	{
	  // 		$prefix='C';
	  // 	}
	  // 	if($curmnth==4)
	  // 	{
	  // 		$prefix='D';
	  // 	}
	  // 	if($curmnth==5)
	  // 	{
	  // 		$prefix='E';
	  // 	}
	  // 	if($curmnth==6)
	  // 	{
	  // 		$prefix='F';
	  // 	}
	  // 	if($curmnth==7)
	  // 	{
	  // 		$prefix='G';
	  // 	}
	  // 	if($curmnth==8)
	  // 	{
	  // 		$prefix='H';
	  // 	}
	  // 	if($curmnth==9)
	  // 	{
	  // 		$prefix='I';
	  // 	}
	  // 	if($curmnth==10)
	  // 	{
	  // 		$prefix='J';
	  // 	}
	  // 	if($curmnth==11)
	  // 	{
	  // 		$prefix='K';
	  // 	}
	  // 	if($curmnth==12)
	  // 	{
	  // 		$prefix='L';
	  // 	}

	  // 	$this->db->select('sama_invoiceno');
	  // 	$this->db->from('sama_salemaster');
	  // 	$this->db->where('sama_invoiceno LIKE '.'"%'.DIRECT_ISSUE_NO_PREFIX.$prefix.'%"');
	  // 	$this->db->where('sama_ishandover','Y');
	  // 	$this->db->limit(1);
	  // 	$this->db->order_by('sama_invoiceno','DESC');
	  // 	$query = $this->db->get();
	  //       // echo $this->db->last_query(); die();
	  // 	$dbinvoiceno='';
	  //       if ($query->num_rows() > 0) 
	  //       {
	  //           $dbinvoiceno=$query->row()->sama_invoiceno;         
	  //       }

	  //     $invoiceno=$this->general->stringseperator($dbinvoiceno,'number');
	  //     $nw_invoice = str_pad($invoiceno + 1, DIRECT_ISSUE_NO_LENGTH, 0, STR_PAD_LEFT);
	  //     return DIRECT_ISSUE_NO_PREFIX.$prefix.$nw_invoice;
  	// }

  	public function save_issue_return()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			try {
				// $postdata=$this->input->post();
	   			//  echo "<pre>";print_r($postdata);die();
	   			$returnqty=$this->input->post('returnqty');
	   			$cnttotalArray=count($returnqty);
	   			$uniqueCnt=count(array_unique($returnqty));
	   			// echo $uniqueCnt;
	   			// echo $cnttotalArray;
	   			// die();
	   			if($uniqueCnt==1 && $cnttotalArray>=2 )
	   			{
	   				print_r(json_encode(array('status'=>'error','message'=>'Atleast one returning Qty. should not be zero !')));
						exit;
	   			}
	   			// echo "<pre>";
	   			// print_r($returnqty);
	   			// die();

				$this->form_validation->set_rules($this->direct_issue_mdl->validate_issue_return);
				if($this->form_validation->run()==TRUE)
				{
					$trans = $this->direct_issue_mdl->save_issue_return();
					if($trans)
					{
						print_r(json_encode(array('status'=>'success','message'=>'Record Saved Successfully')));
						exit;
					}
					else
					{
						print_r(json_encode(array('status'=>'error','message'=>'Record Saved Successfully')));
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

	public function issue_summary()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		  // print_r($this->input->post());
		  // die();
		    $frmDate = !empty($this->input->post('frmdate'))?$this->input->post('frmdate'):CURDATE_NP;
        	$toDate = !empty($this->input->post('todate'))?$this->input->post('todate'):CURDATE_NP;

		    $status_count = $this->direct_issue_mdl->getStatusCount(array('sama_billdatebs >='=>$frmDate, 'sama_billdatebs <='=>$toDate),'cancel');

		    $return_count = $this->direct_issue_mdl->getStatusCount(array('rema_returndatebs >='=>$frmDate, 'rema_returndatebs <='=>$toDate),'return');
		    // echo $this->db->last_query();
		    print_r(json_encode(array('status'=>'success','status_count'=>$status_count,'return_count'=>$return_count)));
		}

	}

	public function issue_returncancel(){

		$this->data['tab_type']='returncancel';

		$this->data['issue_no']=$this->generate_invoiceno();
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
			->build('issue/v_new_issue', $this->data);
	}

	public function issuelist_by_return_no(){
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$return_no=$this->input->post('return_no');
			$return_date=$this->input->post('return_date');
			$this->storeid=$this->session->userdata(STORE_ID);
			if(DEFAULT_DATEPICKER=='NP')
			{
				$srchcol=array('rema_returndatebs'=>$return_date,'rema_invoiceno'=>$return_no,'rema_storeid'=>$this->storeid);
			}
			else
			{
				$srchcol=array('rema_returndatead'=>$return_date,'rema_invoiceno'=>$return_no,'rema_storeid'=>$this->storeid);
			}
			
			$this->data['return_data']=$this->direct_issue_mdl->get_return_master($srchcol);

			// echo "<pre>";
			// print_r($this->data['return_data']);
			// die();
			
			// echo $this->db->last_query();
			// die();
			
			if(empty($this->data['return_data'][0]))
			{
				print_r(json_encode(array('status'=>'error','message'=>'Cannot Cancel this Return No.')));
				exit;	
			}

			$this->data['return_detail']=array();
			$tempform='';
			if($this->data['return_data'])
			{
			$returnmasterid=$this->data['return_data'][0]->rema_returnmasterid;
			$this->data['return_detail']=$this->direct_issue_mdl->get_return_detail(array('rede_returnmasterid'=>$returnmasterid));
			// 	// echo "<pre>";
			// 	// print_r($this->data['order_detail']);
			// 	// die();
				if($this->data['return_detail'])
				{
					$tempform=$this->load->view('issue/v_return_list_for_cancel',$this->data,true);
				}
			
			}
			print_r(json_encode(array('status'=>'success','return_data'=>$this->data['return_data'],'tempform'=>$tempform,'message'=>'Cancel Issue Return Successfully')));
			exit;	

		}
		else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
			exit;
		}
	}

	public function return_cancel_item_all()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			try {
			$rema_id=$this->input->post('id');
			// echo $rema_id;
			// die();
			$rema_data=$this->direct_issue_mdl->get_return_master(array('rema_returnmasterid'=>$rema_id));
			// echo "<pre>";
			// print_r($rema_data);
			// die();

			if(empty($rema_data))
			{
				print_r(json_encode(array('status'=>'error','message'=>'Unable to Cancel')));
				exit;
			}

			if($rema_data[0]->rema_st == 'C')
			{
				print_r(json_encode(array('status'=>'error','message'=>'Already cancel this receive no!!')));
				exit;
			}
			else
			{

				$this->direct_issue_mdl->update_returnmaster($rema_id);
				print_r(json_encode(array('status'=>'success','message'=>'Successfully Cancelled !!!')));
				exit;

			}

			}catch (Exception $e) {
            print_r(json_encode(array('status'=>'error','message' => $e->getMessage())));
        	}
		}
			else
			{
				print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
				exit;
			}
	}

	public function return_cancel_item()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			try {
			$rede_id=$this->input->post('id');
			// echo $rede_id;
			// die();
			$rede_data=$this->direct_issue_mdl->get_return_detail(array('rede_returndetailid'=>$rede_id));
			// echo "<pre>";
			// print_r($rede_data);
			// die();
			if(empty($rede_data))
			{
				print_r(json_encode(array('status'=>'error','message'=>'Unable to cancel this Item !!!')));
				exit;
			}
			else
			{
				$qty=$rede_data[0]->rede_qty;
				$mat_transdetailid=$rede_data[0]->rede_mattransdetailid;
				$iscancel=$rede_data[0]->rede_iscancel;
				if($iscancel=='Y')
				{
					print_r(json_encode(array('status'=>'error','message'=>'Already Cancel this Item !!!')));
					exit;
				}

				$update_rd=$this->direct_issue_mdl->update_returndetail($rede_id);
				$mat_trans=$this->direct_issue_mdl->update_mat_trans_detailid($mat_transdetailid,$qty,'returncancel');

				print_r(json_encode(array('status'=>'success','message'=>'Successfully Cancelled !!!')));
				exit;

			}

			}catch (Exception $e) {
            print_r(json_encode(array('status'=>'error','message' => $e->getMessage())));
        	}
		}
			else
			{
				print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
				exit;
			}
	}
	
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */