<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Asset Repair Work Order
 */
class Repair_work_order extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->Model('repair_request_mdl');
		$this->load->Model('repair_work_order_mdl');
	}

	public function index($reload = false)
	{

		$this->data['reload']=$reload;

		$this->data['breadcrumb'] = 'Repair Work Order';

		$this->data['fiscal'] = $this->general->get_tbl_data('*', 'fiye_fiscalyear', false, 'fiye_fiscalyear_id', 'DESC', '2');

		$this->data['distributors']=$this->general->get_tbl_data('*','dist_distributors',array('dist_isactive'=>'Y'));

		$this->data['department_list']=$this->general->get_tbl_data('*','dept_department',false);

		$currentfyrs = CUR_FISCALYEAR;
		$locationid = $this->session->userdata(LOCATION_ID);

		$this->db->select('rewm_orderno,rewm_fiscalyrs')
			->from('rewm_repairworkordermaster')
			->where('rewm_locationid', $locationid);

		$cur_fiscalyrs_invoiceno = $this->db->order_by('rewm_fiscalyrs', 'DESC')
			->limit(1)
			->get()->row();

		if (!empty($cur_fiscalyrs_invoiceno)) {
			$invoice_format = $cur_fiscalyrs_invoiceno->rewm_orderno;

			$invoice_string = str_split($invoice_format);
			$invoice_prefix_len = strlen(REPAIR_WORK_ORDER_NO_PREFIX);
			$chk_first_string_after_invoice_prefix = $invoice_string[$invoice_prefix_len];
			if ($chk_first_string_after_invoice_prefix == '0') {
				$invoice_no_prefix = REPAIR_WORK_ORDER_NO_PREFIX;
			} else if ($cur_fiscalyrs_invoiceno->rewm_fiscalyrs == $currentfyrs && $chk_first_string_after_invoice_prefix == '0') {
				$invoice_no_prefix = REPAIR_WORK_ORDER_NO_PREFIX;
			} else if ($cur_fiscalyrs_invoiceno->rewm_fiscalyrs != $currentfyrs && $chk_first_string_after_invoice_prefix == '0') {
				$invoice_no_prefix = REPAIR_WORK_ORDER_NO_PREFIX;
			} else if ($cur_fiscalyrs_invoiceno->rewm_fiscalyrs != $currentfyrs && $chk_first_string_after_invoice_prefix != '0') {
				$invoice_no_prefix = REPAIR_WORK_ORDER_NO_PREFIX;
			} else {
				$invoice_no_prefix = REPAIR_WORK_ORDER_NO_PREFIX;
			}
		} else {
			$invoice_no_prefix = REPAIR_WORK_ORDER_NO_PREFIX;
		}

		$this->data['repair_orderno'] = $this->general->generate_invoiceno('rewm_orderno', 'rewm_orderno', 'rewm_repairworkordermaster', $invoice_no_prefix, REPAIR_WORK_ORDER_NO_LENGTH, false, 'rewm_locationid', 'rewm_fiscalyrs DESC ,rewm_repairordermasterid  DESC', 'M');


		$this->data['tab_type'] = "entry";

		$this->page_title = 'Repair Work Order Entry';
		if($reload=='reload'){

	    $this->load->view('repair_work_order/v_repair_work_order_form',$this->data);

	    }else{
	    	$seo_data = '';

			if ($seo_data) {

				$this->page_title = $seo_data->page_title;

				$this->data['meta_keys'] = $seo_data->meta_key;

				$this->data['meta_desc'] = $seo_data->meta_description;
			} else {

				$this->page_title = ORGA_NAME;

				$this->data['meta_keys'] = ORGA_NAME;

				$this->data['meta_desc'] = ORGA_NAME;
			}

		$this->template

			->set_layout('general')

			->enable_parser(FALSE)

			->title($this->page_title)

			->build('repair_work_order/v_assets_repair_work_order_common', $this->data);
		}
	}

	public function save_repair_work_order($print=false){

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		try {

			if($this->input->post('id'))

			{
				if(MODULES_UPDATE=='N')
				{
					$this->general->permission_denial_message();
					exit;
				}
				$action_log_message = "edit";
			}
			else
			{
				if(MODULES_INSERT=='N')
				{
					$this->general->permission_denial_message();
					exit;
				}
				$action_log_message = "";
			}

			$this->form_validation->set_rules($this->repair_work_order_mdl->validate_settings_repair_work_order);

			if($this->form_validation->run()==TRUE)

			{   

			$trans = $this->repair_work_order_mdl->repair_work_order_save();
			if($trans){		
				if($print == "print")
				{	
				$print_report='';
				$this->data['repair_detail'] =array();
				$this->data['repair_master']=$this->repair_work_order_mdl->get_assets_repair_request_master_data(array('rm.rerm_repairrequestmasterid'=>$trans));
				if($this->data['repair_master']>0)
				{
				$this->data['repair_detail'] = $this->repair_work_order_mdl->get_assets_repair_request_detail_data(array('rd.rerd_repairrequestmasterid'=>$trans));
				$print_report=$this->load->view('repair_request/v_repair_request_reprint',$this->data,true);
				}
				print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully.', 'print_report'=>$print_report)));

				exit;
				}
				print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully.')));
				exit;
			}
			else{

				print_r(json_encode(array('status'=>'error','message'=>'Unsuccessful Operation.')));
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
	}else{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
		exit;
	 }

}

	public function repairlist_by_repair_request_no()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$repair_request_no = $this->input->post('repair_request_no');
			
			$fiscalyrs = $this->input->post('fiscalyear');
			
			$srchcol = array('rm.rerm_requestno' => $repair_request_no, 'rm.rerm_fiscalyrs' => $fiscalyrs);

			$this->data['repair_data'] = $this->repair_request_mdl->get_assets_repair_request_master_data($srchcol);

			$status = !empty($this->data['repair_data'][0]->rerm_status) ? $this->data['repair_data'][0]->rerm_status : '';

			$approved = !empty($this->data['repair_data'][0]->rerm_approved) ? $this->data['repair_data'][0]->rerm_approved : '';

			if (empty($this->data['repair_data'])) {
				print_r(json_encode(array('status' => 'error', 'message' => 'Repair Request No. ' . $repair_request_no . ' is not found!!')));
				exit;
			}

			if ($approved == 0) {
				print_r(json_encode(array('status' => 'error', 'message' => 'Repair Request No. ' . $repair_request_no . ' is not approved.')));
				exit;
			}

			if ($status == 'WO') {
				print_r(json_encode(array('status' => 'error', 'message' => 'Repair Request No. ' . $repair_request_no . ' is already sent to work order.')));
				exit;
			}

			if ($status == 'C') {
				print_r(json_encode(array('status' => 'error', 'message' => 'Repair Request No. ' . $repair_request_no . ' is cancelled.')));
				exit;
			}

			

			$this->data['repair_details'] = array();
			$tempform = '';
			if ($this->data['repair_data']) {

				$repairmasterid = $this->data['repair_data'][0]->rerm_repairrequestmasterid;
				
				$this->data['repair_details'] = $this->repair_request_mdl->get_assets_repair_request_detail_data(array('rerm_repairrequestmasterid' => $repairmasterid));
				
				if (!empty($this->data['repair_details'])) {
					$tempform = $this->load->view('repair_work_order/v_repair_work_order_form_detail', $this->data, true);
				}
			}
			print_r(json_encode(array('status' => 'success', 'repair_data' => $this->data['repair_data'], 'tempform' => $tempform, 'message' => 'Selected Successfully')));
			exit;
		} else {
			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		}
	}

	public function summary()

	{
		$frmDate = CURMONTH_DAY1;

		$toDate = CURDATE_NP;

		$this->data['fiscalyear'] = $this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','DESC');

		$this->data['department_list']=$this->general->get_tbl_data('*','dept_department',false);

		$this->data['distributors']=$this->general->get_tbl_data('*','dist_distributors',array('dist_isactive'=>'Y'));

		$this->data['breadcrumb']='Repair Work Order Summary';

		$this->data['tab_type']="repair_work_order_summary";

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

		$this->session->unset_userdata('id');

		$this->page_title='Repair Work Order Summary';

		$this->template

			->set_layout('general')

			->enable_parser(FALSE)

			->title($this->page_title)

			->build('repair_work_order/v_assets_repair_work_order_common', $this->data);
	}

	public function get_repair_order_summary_list()
	{
		if(MODULES_VIEW=='N'){
		$array=array();
		echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));		
		exit;
		}

		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);
		$i = 0;
		$data = $this->repair_work_order_mdl->get_summary_list_of_repair_order();

		$array = array();

		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);

		$totalrecs = $data["totalrecs"];

		unset($data["totalfilteredrecs"]);

		unset($data["totalrecs"]);

		foreach($data as $row)

		{

			// $approved=$row->rerm_approved;

			// if($approved=='0'){

			// 	$appstatus='Pending';

			// }else if($approved=='1'){

			// 	$appstatus='Approval';

			// }

			// else if($approved=='2'){

			// 	$appstatus='Unapproval';

			// }

			// else if($approved=='3'){

			// 	$appstatus='Cancel';

			// }

			// else if($approved=='4'){

			// 	$appstatus='Verified';

			// }

			// else if($approved=='4'){

			// 	$appstatus='Estimated';

			// }


			// if($approved=='0')
			// {
			// 	$appclass='pending';
			// }

			// if($approved=='1')
			// {
			// 	$appclass='approved';
			// }

			// if($approved=='2')
			// {
			// 	$appclass='unapproved';
			// }

			// if($approved=='3')
			// {
			// 	$appclass='cancel';
			// }

			// if($approved=='4')
			// {
			// 	$appclass='verified';
			// }

			// if($approved=='5'){
			// 	$appclass='estimate';
			// }

			// $array[$i]["approvedclass"] = $appclass;



			$array[$i]['datead']=$row->rewm_repairorderdatead;

			$array[$i]['datebs']=$row->rewm_repairorderdatebs;

			$array[$i]['work_order_no']=$row->rewm_orderno;

			$array[$i]['depname']=$row->dept_depname;

			$array[$i]['requestby']=$row->rewm_requestby;

			$array[$i]['distributor']=$row->dist_distributor;

			$array[$i]['delivery_site']=$row->rewm_deliverysite;

			$array[$i]['delivery_datebs']=$row->rewm_deliverydatebs;

			// $array[$i]['status']=$appstatus;

			

			$array[$i]['action']='<a href="javascript:void(0)" data-id='.$row->rewm_repairordermasterid.' class="btnredirect btn-xxs btn-info" title="Edit" data-viewurl="'.base_url("/ams/repair_work_order").'"><i class="fa fa-edit " aria-hidden="true"></i></a>
			<a href="javascript:void(0)" class="view" data-id='.$row->rewm_repairordermasterid.' title="View" data-viewurl="'.base_url("/ams/repair_work_order/get_assets_repair_request_by_id").'" title="View Assets Repair Work Order" data-heading="Assets Repair Work Order View"><i class="fa fa-eye"></i></a>';
			$i++;

		}

		$get = $_GET;
		echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}

	public function get_assets_repair_request_by_id($operation=false){

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$id = $this->input->post('id');

			if($id)

			{ 

				$this->data['assets_repair_work_order_master']=$this->repair_work_order_mdl->get_assets_repair_work_order_master_data(array('rm.rewm_repairordermasterid'=>$id));

				

				$template='';

				if($this->data['assets_repair_work_order_master']>0)

				{

					$this->data['assets_repair_work_order_detail'] = $this->repair_work_order_mdl->get_assets_repair_work_order_detail_data(array('rd.rewd_repairordermasterid'=>$id));

				
// echo "<pre>";

// 				print_r($this->data['assets_repair_work_order_detail']);

// 				die();
				$template=$this->load->view('repair_work_order/v_repair_work_order_detail_view',$this->data,true);

				if($operation=='verify_approved')

				{

					$template .=$this->load->view('repair_work_order/v_repair_work_order_verify_approved_form',$this->data,true);

				}

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

		else{

			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

			exit;

		}

}
}