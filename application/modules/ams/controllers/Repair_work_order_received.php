<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Asset Repair Work Order
 */
class Repair_work_order_received extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->Model('Repair_work_order_received_mdl');
		$this->load->Model('repair_work_order_mdl');
	}

	public function index($reload = false)
	{

		$this->data['reload']=$reload;

		$this->data['breadcrumb'] = 'Repair Order Received Entry';

		$this->data['fiscal'] = $this->general->get_tbl_data('*', 'fiye_fiscalyear', false, 'fiye_fiscalyear_id', 'DESC', '2');

		$this->data['supplier_all']=$this->general->get_tbl_data('*','dist_distributors',array('dist_isactive'=>'Y'));

		$this->data['department_list']=$this->general->get_tbl_data('*','dept_department',false);

		$this->data['tab_type'] = "entry";

		$this->page_title = 'Repair Order Received Entry';

		$this->data['loadselect2'] = '';
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

			->build('repair_order_received/v_repair_order_received_common', $this->data);
		}
	}

	public function save_repair_order_received($print=false){

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

			$trans = $this->Repair_work_order_received_mdl->repair_work_order_save();
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

public function workorderlist_by_order_no(){
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$orderno = trim($this->input->post('orderno'));
			
			$fiscalyrs = $this->input->post('fiscalyear');
			
			$srchcol = array('rm.rewm_orderno' => $orderno, 'rm.rewm_fiscalyrs' => $fiscalyrs);

			$this->data['work_order_data'] = $this->repair_work_order_mdl->get_assets_repair_work_order_master_data($srchcol);

			$status = !empty($this->data['work_order_data'][0]->rewm_status) ? $this->data['work_order_data'][0]->rewm_status : '';

			if (empty($this->data['work_order_data'])) {
				print_r(json_encode(array('status' => 'error', 'message' => 'Repair Request No. ' . $orderno . ' is not found!!')));
				exit;
			}
	
			$this->data['work_order_details'] = array();
			$tempform = '';
			if ($this->data['work_order_data']) {

				$repairmasterid = $this->data['work_order_data'][0]->rewm_repairordermasterid;
				
				$this->data['work_order_details'] = $this->repair_work_order_mdl->get_assets_repair_work_order_detail_data(array('rewd_repairordermasterid' => $repairmasterid));
				
				if (!empty($this->data['work_order_details'])) {
					$tempform = $this->load->view('repair_order_received/v_repair_work_order_received_form_detail', $this->data, true);
				}
			}
			print_r(json_encode(array('status' => 'success', 'work_order_data' => $this->data['work_order_data'], 'tempform' => $tempform, 'message' => 'Selected Successfully')));
			exit;
		} else {
			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		}
}

}