<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Asset_issue extends CI_Controller
{
	function __construct()
	{

		parent::__construct();
		$this->locationid = $this->session->userdata(LOCATION_ID);
		if (defined('LOCATION_CODE')) :
			$this->locationcode = $this->session->userdata(LOCATION_CODE);
		endif;
		$this->location_ismain = $this->session->userdata(ISMAIN_LOCATION);
		$this->userid = $this->session->userdata(USER_ID);

		$this->load->Model('asset_issue_mdl');
		$this->load->Model('stock_inventory/stock_requisition_mdl');
	}

	public function index($reload = false)
	{

		$this->data['reqno'] = $this->input->post('id');
		$this->data['issue_no'] = 'S';
		$dept_cond = array();
		if($this->location_ismain != 'Y'){
			$dept_cond = array('dept_locationid' => $this->locationid);
        } 
  		$this->data['depatrment'] = $this->general->get_tbl_data('*', 'dept_department', $dept_cond, 'dept_depname', 'ASC');
		$locationid = $this->session->userdata(LOCATION_ID);
		$currentfyrs = CUR_FISCALYEAR;

		$cur_fiscalyrs_invoiceno = $this->db->select('asim_issueno,asim_fyear')
			->from('asim_assetissuemaster')
			->where('asim_locationid', $locationid)
			->order_by('asim_fyear', 'DESC')
			->limit(1)
			->get()->row();
		
		if (!empty($cur_fiscalyrs_invoiceno)) {
			$invoice_format = $cur_fiscalyrs_invoiceno->asim_issueno;
			$invoice_string = str_split($invoice_format);
			$invoice_prefix_len = strlen(INVOICE_NO_PREFIX);
			$chk_first_string_after_invoice_prefix = $invoice_string[$invoice_prefix_len];
			if ($chk_first_string_after_invoice_prefix == '0') {
				$invoice_no_prefix = INVOICE_NO_PREFIX . CUR_FISCALYEAR;
			} else if ($cur_fiscalyrs_invoiceno->asim_fyear == $currentfyrs && $chk_first_string_after_invoice_prefix == '0') {
				$invoice_no_prefix = INVOICE_NO_PREFIX . CUR_FISCALYEAR;
			} else if ($cur_fiscalyrs_invoiceno->asim_fyear != $currentfyrs && $chk_first_string_after_invoice_prefix == '0') {
				$invoice_no_prefix = INVOICE_NO_PREFIX . CUR_FISCALYEAR;
			} else if ($cur_fiscalyrs_invoiceno->asim_fyear != $currentfyrs && $chk_first_string_after_invoice_prefix != '0') {
				$invoice_no_prefix = INVOICE_NO_PREFIX . CUR_FISCALYEAR;
			} else {
				$invoice_no_prefix = INVOICE_NO_PREFIX;
			}
		} else {
			$invoice_no_prefix = INVOICE_NO_PREFIX . CUR_FISCALYEAR;
		}
		
		$this->data['issue_no'] = $this->general->generate_invoiceno('asim_issueno', 'asim_issueno', 'asim_assetissuemaster', $invoice_no_prefix, INVOICE_NO_LENGTH, false, 'asim_locationid', 'asim_asimid', 'S', 'DESC'); 

		$this->data['fiscal_year'] = $this->general->get_tbl_data('*', 'fiye_fiscalyear', false, 'fiye_fiscalyear_id', 'DESC', 2);
		$this->data['staff_list'] = $this->general->get_tbl_data('stin_staffinfoid,stin_code,stin_fname,stin_lname', 'stin_staffinfo', array('stin_jobstatus' => 'Y'), 'stin_fname', 'ASC');

		$this->data['new_issue'] = "";
		$this->data['tab_type'] = 'entry';

		if ($reload == 'reload') {
			$this->load->view('asset_issue/v_issue_form',$this->data);
		}else{
		$seo_data = '';
		if ($seo_data) {
			//set SEO data
			$this->page_title = $seo_data->page_title;
			$this->data['meta_keys'] = $seo_data->meta_key;
			$this->data['meta_desc'] = $seo_data->meta_description;
		} else {
			//set SEO data
			$this->page_title = ORGA_NAME;
			$this->data['meta_keys'] = ORGA_NAME;
			$this->data['meta_desc'] = ORGA_NAME;
		}

		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('asset_issue/v_issue', $this->data);

		}
	}

	public function summary()
	{	
		$dept_cond = array();
		if($this->location_ismain != 'Y'){
			$dept_cond = array('dept_locationid' => $this->locationid);
        }  
		$this->data['department'] = $this->general->get_tbl_data('*', 'dept_department', $dept_cond, 'dept_depname', 'ASC');
		$this->data['fiscal_year'] = $this->general->get_tbl_data('*', 'fiye_fiscalyear', false, 'fiye_fiscalyear_id', 'DESC', 2);
		$this->data['staff_list'] = $this->general->get_tbl_data('stin_staffinfoid,stin_code,stin_fname,stin_lname', 'stin_staffinfo', array('stin_jobstatus' => 'Y'), 'stin_fname', 'ASC');
		$this->data['equipmentcategory'] = $this->general->get_tbl_data('*', 'eqca_equipmentcategory', array('eqca_equiptypeid' => 2), 'eqca_equipmentcategoryid', 'DESC');

		$this->data['tab_type'] = 'summary';

		$seo_data = '';
		if ($seo_data) {
			//set SEO data
			$this->page_title = $seo_data->page_title;
			$this->data['meta_keys'] = $seo_data->meta_key;
			$this->data['meta_desc'] = $seo_data->meta_description;
		} else {
			//set SEO data
			$this->page_title = ORGA_NAME;
			$this->data['meta_keys'] = ORGA_NAME;
			$this->data['meta_desc'] = ORGA_NAME;
		}

		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('asset_issue/v_issue', $this->data);
	}

	public function save_asset_issue()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			try {
				$id = $this->input->post('id');
				// if ($id) {
				// 	if(MODULES_UPDATE=='N')
				// 	{
				// 	$this->general->permission_denial_message();
				// 	exit;
				// 	}
				// } else {
				// 	if (MODULES_INSERT == 'N') {
				// 		$this->general->permission_denial_message();
				// 		exit;
				// 	}
				// }
				// $postdata = $this->input->post();
				// echo "<pre>";
				// print_r($postdata);
				// die();
				if (empty($id)) {
					$req_nochk = $this->check_req_no();
					if (empty($req_nochk)) {
						print_r(json_encode(array('status' => 'error', 'message' => 'Invalid Requisition No!!')));
						exit;
					}
				}
				$print = $this->input->post('print');
				$print_report = '';
				$itemsid = $this->input->post('asid_itemsid');
				$qtyinstock = $this->input->post('qtyinstock');
				$isqty = $this->input->post('assetslist');
				$itmname = $this->input->post('asid_itemsname');
				$reqqty = $this->input->post('remqty');
				if (!empty($id)) {
					$this->form_validation->set_rules($this->asset_issue_mdl->validate_asset_issue_edit);
				} else {
					$this->form_validation->set_rules($this->asset_issue_mdl->validate_asset_issue);
				}
				if ($this->form_validation->run() == TRUE) {
					if (empty($id)) {
						if (!empty($itemsid)) {
							foreach ($itemsid as $key => $val) {
								$stockval = !empty($qtyinstock[$key]) ? $qtyinstock[$key] : '';
								$issueqty = !empty($isqty[$key]) ? count($isqty[$key]) : 0;
								$itemid = !empty($val) ? $val : '';
								$itemStockVal = $this->asset_issue_mdl->check_issue_asset_stock($itemid);
								// echo $this->db->last_query();
								// die();
								$db_item_stockval = !empty($itemStockVal) ? $itemStockVal : 0;
								$itmname = !empty($itmname[$key]) ? $itmname[$key] : '';
								$remQty = !empty($reqqty[$key]) ? $reqqty[$key] : '';
								if ($issueqty > $db_item_stockval) {
									print_r(json_encode(array('status' => 'error', 'message' => 'Issue Qty of Item ' . $itmname . ' should not exceed stock qty. Please check it.')));
									exit;
								}
								if ($issueqty > $remQty) {
									print_r(json_encode(array('status' => 'error', 'message' => 'Issue Qty of Item ' . $itmname . ' should not exceed Req. qty. Please check it.')));
									exit;
								}
							}
						}
					}
					if (!empty($id)) {
						$trans = $this->asset_issue_mdl->save_asset_issue_edit();
					} else {
						$trans = $this->asset_issue_mdl->save_asset_issue();
						// $this->general->saveActionLog('sama_salemaster', $trans, $this->userid, 'RC', 'sama_receivedstatus');
					}
					if ($trans) {
						if ($print == "print") {
								$issue_master = $this->data['issue_master'] = $this->asset_issue_mdl->get_assetissuemaster_date_id(array('asim_asimid' => $trans));
								$this->data['issue_details'] = $this->asset_issue_mdl->get_assetissue_detail(array('ad.asid_asimid' => $trans));
								$this->data['store'] = $this->general->get_tbl_data('eqty_equipmenttype', 'eqty_equipmenttype', array('eqty_equipmenttypeid' => $this->session->userdata(STORE_ID)), 'eqty_equipmenttypeid', 'ASC');
								$this->data['user_signature'] = $this->general->get_signature($this->userid);
								$approve_data = $this->asset_issue_mdl->get_approve_data($trans);
								$approvedby = !empty($approve_data[0]->rema_approvedid) ? $approve_data[0]->rema_approvedid : '';
								$this->data['approver_signature'] = $this->general->get_signature($approvedby);
								$issue_date = !empty($issue_master[0]->asim_issuedatebs) ? $issue_master[0]->asim_issuedatebs : CURDATE_NP;
								$store_head_id = $this->general->get_store_post_data($issue_date, 'store_head');
								$this->data['store_head_signature'] = $this->general->get_signature($store_head_id);
								$this->data['user_list_for_issue_report'] = $this->asset_issue_mdl->get_user_list_for_issue_report($trans);
								$this->data['requisition_data'] = $requisition_data = $this->asset_issue_mdl->get_requisition_data_from_asset_issue_masterid($trans);
								$rema_reqmasterid = $requisition_data[0]->rema_reqmasterid;
								$this->data['get_branch_manager_name'] = $this->general->get_username_from_actionlog(array('aclo_masterid' => $rema_reqmasterid, 'aclo_status' => 2, 'aclo_fieldname' => 'rema_proceedissue'));
								$this->data['equipment_category'] = $this->asset_issue_mdl->get_equipment_category($trans);
								
								$print_report = $this->load->view('asset_issue/v_asset_issue_print', $this->data, true);
								
							}
							print_r(json_encode(array('status' => 'success', 'message' => 'Record Save Successfully', 'print_report' => '')));
							// exit;
						} else {
							print_r(json_encode(array('status' => 'error', 'message' => 'Unsuccessfull Operation')));
							exit;
						}
					} else {
						print_r(json_encode(array('status' => 'error', 'message' => validation_errors())));
						exit;
					}
			} catch (Exception $e) {
				print_r(json_encode(array('status' => 'error', 'message' => $e->getMessage())));
			}
		} else {
			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		}
	}

	public function asset_issue_summary_list(){
		if (MODULES_VIEW == 'N') {
			$array = array();
			// $this->general->permission_denial_message();
			echo json_encode(array("recordsFiltered" => 0, "recordsTotal" => 0, "data" => $array));
			exit;
		}
		$i = 0;
		$data = $this->asset_issue_mdl->get_asset_issue_list();
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"] > 0 ? $data["totalfilteredrecs"] : $data["totalrecs"]);
		$totalrecs = $data["totalrecs"];
		unset($data["totalfilteredrecs"]);
		unset($data["totalrecs"]);
		foreach ($data as $row) {
					
			$array[$i]['issuedatebs'] = $row->asim_issuedatebs;
			$array[$i]["issuedatead"] = $row->asim_issuedatead;
			$array[$i]["issue_no"] = $row->asim_issueno;
			$array[$i]["depname"] = $row->dept_depname;
			$array[$i]["reqno"] = $row->asim_reqno;
			$array[$i]["received_by"] = $row->asim_staffname;
			$array[$i]["fyear"] = $row->asim_fyear;
			$array[$i]["action"] = "
			<a href='javascript:void(0)' data-id='$row->asim_asimid' data-invoiceno='$row->asim_issueno' data-fyear='$row->asim_fyear' data-displaydiv='IssueDetails' data-viewurl='".base_url('ams/asset_issue/asset_issue_view')."' class='view btn-primary' data-heading='Asset Issue' details='' title='View' issue=''><i class='fa fa-eye'></i></a>";
			$i++;
		}
		echo json_encode(array("recordsFiltered" => $filtereddata, "recordsTotal" => $totalrecs, "data" => $array));
	}

	public function search_requisition_no_for_assets()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$req_no = $this->input->post('req_no');
			$fyear = $this->input->post('fyear');
			$searcharr = array(
				'rema_mattypeid' => 2,
				'rema_fyear' => $fyear,
				'rema_reqno' => $req_no,
				'rema_locationid' => $this->locationid,

			);

			if (!empty($searcharr)) {
				$this->db->select('rema_reqmasterid,rema_reqdatead,rema_reqdatebs,rema_reqfromdepid,rema_reqby');
				$this->db->from('rema_reqmaster');
				$this->db->where($searcharr);
				$result = $this->db->get()->row();

				$req_data = array();
				if (!empty($result)) {
					$reqmasterid = $result->rema_reqmasterid;
					if (DEFAULT_DATEPICKER == 'NP') {

						$req_data['req_date'] = $result->rema_reqdatebs;
					} else {

						$req_data['req_date'] = $result->rema_reqdatead;
					}

					$req_data['fromdepid'] = $result->rema_reqfromdepid;

					$req_data['reqby'] = $result->rema_reqby;

					print_r(json_encode(array('status' => 'success', 'message' => 'Data Selected  Successfully!!', 'masterid' => $reqmasterid, 'req_data' => $req_data)));

					// $stock_count = "SELECT COUNT('*') as cnt FROM xw_asen_assetentry ae WHERE asen_staffid = 0 AND ae.asen_description=il.itli_itemlistid";
					// $asset_list = "SELECT GROUP_CONCAT(CONCAT_WS('@',asen_asenid,asen_assetcode)) FROM xw_asen_assetentry ae WHERE asen_staffid = 0 AND ae.asen_description = il.itli_itemlistid";

					// $this->db->select("rd.*,($stock_count) as stock_qty, ($asset_list) as asset_list");
					// $this->db->from('rede_reqdetail rd');
					// $this->db->join('itli_itemslist il', 'il.itli_itemlistid=rd.rede_itemsid', 'LEFT');
					// $this->db->where(array('rede_reqmasterid' => $reqmasterid));
					// $rslt_detail = $this->db->get()->result();
					// echo "<pre>";
					// print_r($rslt_detail);
					// die();

				} else {
					print_r(json_encode(array('status' => 'error', 'message' => 'Demand Req. No. does not exit. Please Try Another Demand Req. no. !!!')));
				}
			}
		} else {

			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));

			exit;
		}
	}

	public function load_pendinglist($new_issue = false)
	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$req_masterid = $this->input->post('req_masterid');
			$pending_array = array('rd.rede_reqmasterid' => $req_masterid, 'rd.rede_remqty >' => 0);
			$this->data['pending_list'] = $this->asset_issue_mdl->get_requisition_details($pending_array);
			// echo"<pre>";print_r($this->data['pending_list']);die;
			// echo $this->db->last_query();die();
			if (empty($this->data['pending_list'])) {
				$isempty = 'empty';
			} else {
				$isempty = 'not_empty';
			}
			if ($new_issue == 'new_issue_pending_list') {
				$tempform = $this->load->view('asset_issue/v_issue_pending_list', $this->data, true);
			} else {
				$tempform = $this->load->view('stock/v_requisition_pendinglist_modal', $this->data, true);
			}
			if (!empty($tempform)) {
				print_r(json_encode(array('status' => 'success', 'message' => 'You Can view', 'tempform' => $tempform, 'isempty' => $isempty)));
				exit;
			} else {
				print_r(json_encode(array('status' => 'error', 'message' => 'Unable to View!!')));
				exit;
			}
		} else {
			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		} 
	}

	public function check_req_no()
	{
		$req_no = $this->input->post('asim_requisitionno');
		$fyear = $this->input->post('asim_fyear');
		$storeid = !empty($this->session->userdata(STORE_ID)) ? $this->session->userdata(STORE_ID) : 1;
		$srchcol = array('rema_reqno' => $req_no, 'rema_fyear' => $fyear, 'rema_reqtodepid' => $storeid, 'rema_approved' => '1');
		$this->data['req_data'] = $this->stock_requisition_mdl->get_req_no_list($srchcol, 'rema_reqno', 'desc');
		if (!empty($this->data['req_data'])) {
			return 1;
		} else {
			return 0;
		}
	}

	public function reprint_asset_issue_details()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$id = $this->input->post('id');
			if ($id) {

				$issue_master = $this->data['issue_master'] = $this->asset_issue_mdl->get_assetissuemaster_date_id(array('asim_asimid' => $id));
				$this->data['issue_details'] = $this->asset_issue_mdl->get_assetissue_detail(array('ad.asid_asimid' => $id));
				// echo "<pre>";
				// print_r($this->data['issue_details']);
				// die();

				$this->data['store'] = $this->general->get_tbl_data('eqty_equipmenttype', 'eqty_equipmenttype', array('eqty_equipmenttypeid' => $this->session->userdata(STORE_ID)), 'eqty_equipmenttypeid', 'ASC');
				$this->data['user_signature'] = $this->general->get_signature($this->userid);
				$approve_data = $this->asset_issue_mdl->get_approve_data($id);
				$approvedby = !empty($approve_data[0]->rema_approvedid) ? $approve_data[0]->rema_approvedid : '';
				$this->data['approver_signature'] = $this->general->get_signature($approvedby);
				$issue_date = !empty($issue_master[0]->asim_issuedatebs) ? $issue_master[0]->asim_issuedatebs : CURDATE_NP;
				$store_head_id = $this->general->get_store_post_data($issue_date, 'store_head');
				$this->data['store_head_signature'] = $this->general->get_signature($store_head_id);
				$this->data['user_list_for_issue_report'] = $this->asset_issue_mdl->get_user_list_for_issue_report($id);
				$this->data['requisition_data'] = $requisition_data = $this->asset_issue_mdl->get_requisition_data_from_asset_issue_masterid($id);
				$rema_reqmasterid = $requisition_data[0]->rema_reqmasterid;
				$this->data['get_branch_manager_name'] = $this->general->get_username_from_actionlog(array('aclo_masterid' => $rema_reqmasterid, 'aclo_status' => 2, 'aclo_fieldname' => 'rema_proceedissue'));
				$this->data['equipment_category'] = $this->asset_issue_mdl->get_equipment_category($id);

				$template = $this->load->view('asset_issue/v_asset_issue_print_2',$this->data,true);
				if ($this->data['issue_master'] > 0) {
					print_r(json_encode(array('status' => 'success', 'message' => '', 'tempform' => $template)));
					exit;
				} else {
					print_r(json_encode(array('status' => 'error', 'message' => '')));
					exit;
				}
				print_r(json_encode(array('status' => 'success', 'message' => 'Successfully Selected!!', 'tempform' => $template)));
				exit;
			}
		} else {
			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		}
	}

	public function asset_issue_view()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$id = $this->data['id'] = $this->input->post('id');
			if ($id) {
				$issue_master = $this->data['issue_master'] = $this->asset_issue_mdl->get_assetissuemaster_date_id(array('asim_asimid' => $id));
				$this->data['issue_details'] = $this->asset_issue_mdl->get_assetissue_detail(array('ad.asid_asimid' => $id));
				// echo "<pre>";
				// print_r($this->data['issue_details']);
				// die();

				$this->data['store'] = $this->general->get_tbl_data('eqty_equipmenttype', 'eqty_equipmenttype', array('eqty_equipmenttypeid' => $this->session->userdata(STORE_ID)), 'eqty_equipmenttypeid', 'ASC');
				$this->data['user_signature'] = $this->general->get_signature($this->userid);
				$approve_data = $this->asset_issue_mdl->get_approve_data($id);
				$approvedby = !empty($approve_data[0]->rema_approvedid) ? $approve_data[0]->rema_approvedid : '';
				$this->data['approver_signature'] = $this->general->get_signature($approvedby);
				$issue_date = !empty($issue_master[0]->asim_issuedatebs) ? $issue_master[0]->asim_issuedatebs : CURDATE_NP;
				$store_head_id = $this->general->get_store_post_data($issue_date, 'store_head');
				$this->data['store_head_signature'] = $this->general->get_signature($store_head_id);
				$this->data['user_list_for_issue_report'] = $this->asset_issue_mdl->get_user_list_for_issue_report($id);
				$this->data['requisition_data'] = $requisition_data = $this->asset_issue_mdl->get_requisition_data_from_asset_issue_masterid($id);
				$rema_reqmasterid = $requisition_data[0]->rema_reqmasterid;
				$this->data['get_branch_manager_name'] = $this->general->get_username_from_actionlog(array('aclo_masterid' => $rema_reqmasterid, 'aclo_status' => 2, 'aclo_fieldname' => 'rema_proceedissue'));
				$this->data['equipment_category'] = $this->asset_issue_mdl->get_equipment_category($id);
				$template='';
				
				$template .= $this->load->view('asset_issue/v_asset_issue_view', $this->data, true);
				$template .= $this->load->view('asset_issue/v_asset_issue_print_2',$this->data,true);

				print_r(json_encode(array('status' => 'success', 'message' => '', 'tempform' => $template)));
			}
		} else {
			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		}
	}
}