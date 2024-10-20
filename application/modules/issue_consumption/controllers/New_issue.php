<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class New_issue extends CI_Controller

{

	function __construct()

	{

		parent::__construct();

		$this->load->Model('new_issue_mdl');

		$this->load->Model('stock_requisition_mdl', 'requisition_mdl');

		$this->load->Model('stock_inventory/stock_requisition_mdl');

		$this->username = $this->session->userdata(USER_NAME);

		$this->userid = $this->session->userdata(USER_ID);

		$this->locationid = $this->session->userdata(LOCATION_ID);

		if (defined('LOCATION_CODE')) :

			$this->locationcode = $this->session->userdata(LOCATION_CODE);

		endif;

		$this->location_ismain = $this->session->userdata(ISMAIN_LOCATION);

		$this->orgid = $this->session->userdata(ORG_ID);

		$this->mattypeid = $this->session->userdata(USER_MAT_TYPEID);

		$this->usergroup = $this->session->userdata(USER_GROUPCODE);

		$this->show_location_group = array('SA', 'SK', 'SI');
	}

	public function index()

	{

		$this->data['reqno'] = $this->input->post('id');

		// $this->data['equipmentcategory']=$this->general->get_tbl_data('*','eqca_equipmentcategory',false,'eqca_equipmentcategoryid','DESC');

		// if ($this->location_ismain == 'Y' && in_array($this->usergroup, $this->show_location_group)) {
			$dept_cond = array();
		// } else {
		// 	$dept_cond = array(
		// 		'dept_locationid' => $this->locationid
		// 	);
		// }

		$this->data['depatrment'] = $this->general->get_tbl_data('*', 'dept_department', $dept_cond, 'dept_depname', 'ASC');

		// echo "<pre>";

		// print_r($this->data['depatrment']);

		// die();

		$locationid = $this->session->userdata(LOCATION_ID);

		$currentfyrs = CUR_FISCALYEAR;

		$cur_fiscalyrs_invoiceno = $this->db->select('sama_invoiceno,sama_fyear')

			->from('sama_salemaster')

			->where('sama_locationid', $locationid)

			->where('sama_fyear',$currentfyrs)

			->order_by('sama_fyear', 'DESC')

			->limit(1)

			->get()->row();

		// echo "<pre>";

		// print_r($cur_fiscalyrs_invoiceno);

		// die();

		if (!empty($cur_fiscalyrs_invoiceno)) {

			$invoice_format = $cur_fiscalyrs_invoiceno->sama_invoiceno;

			$invoice_string = str_split($invoice_format);

			// echo "<pre>";

			// print_r($invoice_string);

			// die();

			$invoice_prefix_len = strlen(INVOICE_NO_PREFIX);

			$chk_first_string_after_invoice_prefix = $invoice_string[$invoice_prefix_len];

			// echo $chk_first_string_after_invoice_prefix;

			// die();

			if ($chk_first_string_after_invoice_prefix == '0') {

				$invoice_no_prefix = INVOICE_NO_PREFIX . CUR_FISCALYEAR;
			} else if ($cur_fiscalyrs_invoiceno->sama_fyear == $currentfyrs && $chk_first_string_after_invoice_prefix == '0') {

				$invoice_no_prefix = INVOICE_NO_PREFIX . CUR_FISCALYEAR;
			} else if ($cur_fiscalyrs_invoiceno->sama_fyear != $currentfyrs && $chk_first_string_after_invoice_prefix == '0') {

				$invoice_no_prefix = INVOICE_NO_PREFIX . CUR_FISCALYEAR;
			} else if ($cur_fiscalyrs_invoiceno->sama_fyear != $currentfyrs && $chk_first_string_after_invoice_prefix != '0') {

				$invoice_no_prefix = INVOICE_NO_PREFIX . CUR_FISCALYEAR;
			} else {

				$invoice_no_prefix = INVOICE_NO_PREFIX;
			}
		} else {

			$invoice_no_prefix = INVOICE_NO_PREFIX . CUR_FISCALYEAR;
		}

		// die();

		if (ORGANIZATION_NAME == 'KU' || ORGANIZATION_NAME =='PU' || ORGANIZATION_NAME == 'NPHL') {

			$invoice_no_prefix = '';

			$this->data['issue_no'] = $this->general->generate_invoiceno('sama_invoiceno', 'sama_invoiceno', 'sama_salemaster', $invoice_no_prefix, INVOICE_NO_LENGTH, array('sama_fyear'=>$currentfyrs), 'sama_locationid', 'sama_salemasterid', 'S', 'DESC', 'Y');

			// $location_fieldname =false,$order_by=false,$order_type='S',$order='DESC',$is_disable_prefix='N')

		} else {

			$this->data['issue_no'] = $this->general->generate_invoiceno('sama_invoiceno', 'sama_invoiceno', 'sama_salemaster', $invoice_no_prefix, INVOICE_NO_LENGTH, array('sama_fyear'=>$currentfyrs), 'sama_locationid', 'sama_salemasterid', 'S', 'DESC');
		}
			// echo $this->db->last_query();
			// 		die();

		$this->data['fiscal_year'] = $this->general->get_tbl_data('*', 'fiye_fiscalyear', false, 'fiye_fiscalyear_id', 'DESC', 2);

		if (!empty($this->mattypeid)) {

			$srchmat = array('maty_materialtypeid' => 1, 'maty_isactive' => 'Y');
		} else {

			$srchmat = array('maty_isactive' => 'Y','maty_materialtypeid' =>1);
		}

		$this->data['material_type'] = $this->general->get_tbl_data('maty_materialtypeid,maty_material', 'maty_materialtype', $srchmat, 'maty_materialtypeid', 'ASC');

		$this->data['new_issue'] = "";

		$this->data['tab_type'] = 'entry';

		// $this->data['issue_no']=$this->generate_invoiceno();

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

			->build('issue/v_new_issue', $this->data);
	}

	public function issuedetails()

	{

		$this->data['tab_type'] = 'issuedetails';

		$this->data['apptype'] = '';

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

			->build('issue/v_new_issue', $this->data);
	}

	public function retern_view()

	{

		$this->data['apptype'] = '';

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

			->build('issue/kukl/v_handover_print', $this->data);
	}

	public function issuebook()

	{
		$frmDate = CURMONTH_DAY1;

		$toDate = CURDATE_NP;

		$cur_fiscalyear = CUR_FISCALYEAR;

		$this->data['fiscalyear'] = $this->general->get_tbl_data('*', 'fiye_fiscalyear', false, 'fiye_fiscalyear_id', 'DESC');

		if ($this->location_ismain == 'Y' && in_array($this->usergroup, $this->show_location_group)) {
			$dept_cond = false;
		} else {
			$dept_cond = array(
				'dept_locationid' => $this->locationid
			);
		}

		$this->data['department'] = $this->general->get_tbl_data('*', 'dept_department', $dept_cond, 'dept_depid', 'DESC');

		if (!empty($this->mattypeid)) {

			$srchmat = array('maty_materialtypeid' => $this->mattypeid, 'maty_isactive' => 'Y');
		} else {

			$srchmat = array('maty_isactive' => 'Y');
		}

		$this->data['material_type'] = $this->general->get_tbl_data('maty_materialtypeid,maty_material', 'maty_materialtype', $srchmat, 'maty_materialtypeid', 'ASC');

		// $this->data['status_count'] = $this->stock_requisition_mdl->getStatusCount(array('rema_reqdatebs >='=>$frmDate, 'rema_reqdatebs <='=>$toDate));

		if (ORGANIZATION_NAME == 'KUKL') {

			$cond = '';

			if ($frmDate) {

				$cond .= " WHERE rema_returndatebs >='" . $frmDate . "'";
			}

			if ($toDate) {

				$cond .= " AND rema_returndatebs <='" . $toDate . "'";
			} else {

				$cond .= " AND rema_returndatebs <='" . $frmDate . "'";
			}

			$cond2 = '';

			if ($frmDate) {

				$cond2 .= " WHERE sama_billdatebs >='" . $frmDate . "'";
			}

			if ($toDate) {

				$cond2 .= " AND sama_billdatebs <='" . $toDate . "'";
			} else {

				$cond2 .= " AND sama_billdatebs <='" . $frmDate . "'";
			}

			$this->data['return_count'] = $this->new_issue_mdl->getColorStatusCountreturn($cond);

			$this->data['status_count'] = $this->new_issue_mdl->getColorStatusCountissue($cond2);

			// echo "<pre>";

			// print_r($this->data['status_count']);

			// die();

		} else {

			$this->data['status_count'] = $this->new_issue_mdl->getStatusCount(array('sama_billdatebs >=' => $frmDate, 'sama_billdatebs <=' => $toDate, 'sama_locationid' => $this->locationid), 'cancel');

			// echo "<pre>";

			// print_r($this->data['status_count']);

			// die();

			$this->data['return_count'] = $this->new_issue_mdl->getStatusCount(array('rema_returndatebs >=' => $frmDate, 'rema_returndatebs <=' => $toDate, 'rema_locationid' => $this->locationid), 'return');
		}

		// echo $this->db->last_query();

		// echo '<pre>';

		// print_r($this->data['status_count']);

		// die();

		// $this->data['total_count'] = $this->new_issue_mdl->getRemCount(array('rema_reqdatebs >='=>$frmDate, 'rema_reqdatebs <='=>$toDate,'rema_locationid'=>$this->locationid));

		$this->data['tab_type'] = 'list';

		$this->data['apptype'] = '';

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

			->build('issue/v_new_issue', $this->data);
	}

	public function new_issue_temp()

	{

		$this->data['depatrment'] = $this->general->get_tbl_data('*', 'dept_department', false, 'dept_depid', 'DESC');

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$depid = $this->input->post('depid');

			$this->data['depart'] =  $this->input->post('depid');

			if ($depid) {

				$this->data['new_issue'] = $this->new_issue_mdl->get_selected_issue();

				$template = $this->load->view('issue/v_temp_new_issue', $this->data, true);

				//echo"<pre>"; print_r($template); die;

				if ($this->data['new_issue'] > 0) {

					print_r(json_encode(array('status' => 'success', 'message' => '', 'template' => $template)));

					exit;
				} else {

					print_r(json_encode(array('status' => 'error', 'message' => '')));

					exit;
				}

				print_r(json_encode(array('status' => 'success', 'message' => 'Successfully Selected!!', 'template' => $template)));

				exit;
			}
		} else {

			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));

			exit;
		}
	}

	public function save_new_issue($print = false)

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			try {

				$id = $this->input->post('id');

				if ($this->input->post('id')) {

					// if(MODULES_UPDATE=='N')

					// {

					// $this->general->permission_denial_message();

					// exit;

					// }

				} else {

					if (MODULES_INSERT == 'N') {

						$this->general->permission_denial_message();

						exit;
					}
				}

				$postdata = $this->input->post();

				// echo "<pre>";print_r($postdata);die();

				if (empty($id)) {

					$req_nochk = $this->check_req_no();

					// echo $this->db->last_query();

					// die();

					// echo $req_nochk;

					if (empty($req_nochk)) {

						print_r(json_encode(array('status' => 'error', 'message' => 'Invalid Requisition No!!')));

						exit;

						// $this->form_validation->set_message('reqno', 'Invalid Requisition No!!');

						// exit;

					}
				}

				$print_report = '';

				$itemsid = $this->input->post('sade_itemsid');

				$qtyinstock = $this->input->post('qtyinstock');

				$isqty = $this->input->post('sade_qty');

				$itmname = $this->input->post('sade_itemsname');

				$reqqty = $this->input->post('remqty');

				$is_handover = $this->input->post('handover');

				if (!empty($id)) {

					// echo "id";

					$this->form_validation->set_rules($this->new_issue_mdl->validate_new_issue_edit);
				} else {

					// echo "nonid";

					$this->form_validation->set_rules($this->new_issue_mdl->validate_new_issue);
				}

				if ($this->form_validation->run() == TRUE) {

					if (empty($id)) {

						if (!empty($itemsid)) {

							foreach ($itemsid as $key => $val) {

								$stockval = !empty($qtyinstock[$key]) ? $qtyinstock[$key] : '';

								$issueqty = !empty($isqty[$key]) ? $isqty[$key] : '';

								$itemid = !empty($itemsid[$key]) ? $itemsid[$key] : '';

								$itemStockVal = $this->new_issue_mdl->check_item_stock($itemid);

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

						$trans = $this->new_issue_mdl->save_new_issue_edit();
					} else {

						$trans = $this->new_issue_mdl->save_new_issue();

						$this->general->saveActionLog('sama_salemaster', $trans, $this->userid, 'RC', 'sama_receivedstatus');
					}

					if ($trans) {

						if (ORGANIZATION_NAME == 'KUKL') {

							$approve_data = $this->new_issue_mdl->get_approve_data($trans);

							$rema_reqno = !empty($approve_data[0]->rema_reqno) ? $approve_data[0]->rema_reqno : '';

							$issueto = !empty($approve_data[0]->rema_postby) ? $approve_data[0]->rema_postby : '';

							$mess_userid = $issueto; // message to demander

							// print_r($issueto);print_r($rema_reqno);die;

							$message = "Demand Req No. $rema_reqno has been issued. Please confirm receive.";

							$mess_userid = $issueto;

							$mess_title = $mess_message = $message;

							$mess_path = 'issue_consumption/stock_requisition/requisition_list';

							$this->general->send_message_to_user($mess_userid, $mess_title, $mess_message, $mess_path, 'S');
						}

						// print_r($trans);die; 

						if ($print == "print") {

							$issue_master = $this->data['issue_master'] = $this->new_issue_mdl->get_salemaster_date_id(array('sama_salemasterid' => $trans));

							// echo"<pre>";print_r($this->data['issue_master']);die;

							$this->data['issue_details'] = $this->new_issue_mdl->get_issue_detail(array('sd.sade_salemasterid' => $trans));

							// echo"<pre>";	print_r($this->data['issue_details']);die;

							$this->data['store'] = $this->general->get_tbl_data('eqty_equipmenttype', 'eqty_equipmenttype', array('eqty_equipmenttypeid' => $this->session->userdata(STORE_ID)), 'eqty_equipmenttypeid', 'ASC');

							$this->data['user_signature'] = $this->general->get_signature($this->userid);

							$approve_data = $this->new_issue_mdl->get_approve_data($trans);

							$approvedby = !empty($approve_data[0]->rema_approvedid) ? $approve_data[0]->rema_approvedid : '';

							$this->data['approver_signature'] = $this->general->get_signature($approvedby);

							$issue_date = !empty($issue_details[0]->sama_billdatebs) ? $issue_details[0]->sama_billdatebs : CURDATE_NP;

							$store_head_id = $this->general->get_store_post_data($issue_date, 'store_head');

							$this->data['store_head_signature'] = $this->general->get_signature($store_head_id);

							$this->data['user_list_for_issue_report'] = $this->new_issue_mdl->get_user_list_for_issue_report($trans);

							$this->data['requisition_data'] = $requisition_data = $this->new_issue_mdl->get_requisition_data_from_salemasterid($trans);

							$rema_reqmasterid = $requisition_data[0]->rema_reqmasterid;

							$this->data['get_branch_manager_name'] = $this->general->get_username_from_actionlog(array('aclo_masterid' => $rema_reqmasterid, 'aclo_status' => 2, 'aclo_fieldname' => 'rema_proceedissue'));

							$this->data['equipment_category'] = $this->new_issue_mdl->get_equipment_category($trans);

							if($is_handover == 'Y'){

								 $print_report = $this->load->view('direct_issue/v_direct_issue_print', $this->data, true);
								// if (NEW_ISSUE_REPORT_TYPE == 'DEFAULT') {

								// 	$template = $this->load->view('direct_issue/v_direct_issue_print', $this->data, true);
								// } else {

								// 	$template = $this->load->view('direct_issue/v_direct_issue_print' . '_' . REPORT_SUFFIX, $this->data, true);
								// }

							}else{
							if (defined('NEW_ISSUE_REPORT_TYPE')) :

								if (NEW_ISSUE_REPORT_TYPE == 'DEFAULT') {

									$print_report = $this->load->view('issue/v_new_issue_print', $this->data, true);
								} else {

									$print_report = $this->load->view('issue/v_new_issue_print' . '_' . REPORT_SUFFIX, $this->data, true);
								}

							else :

								$print_report = $this->load->view('issue/v_new_issue_print', $this->data, true);

							endif;

							}

							//echo "<pre>"; print_r($print_report);die;

						}

						$this->new_issue_mdl->insert_api_data_locally($trans);

						// api parameters

						if (defined('RUN_API') && RUN_API == 'Y') :

							if (defined('API_CALL')) :

								if (API_CALL == 'KUKL') {

									// $this->load->module('api/Api_kukl');

									// $this->Api_kukl->post_api_import_asset_with_issueno($trans);

									$this->new_issue_mdl->post_api_import_asset_with_issueno($trans);
								}

							endif;

						endif;

						print_r(json_encode(array('status' => 'success', 'message' => 'Record Save Successfully', 'print_report' => $print_report)));

						exit;
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

	public function save_new_issue_test()

	{

		$this->data['issue_master'] = $this->general->get_tbl_data('*', 'sama_salemaster', array('sama_salemasterid' => '7991'), 'sama_salemasterid', 'DESC');

		$this->data['issue_details'] = $this->new_issue_mdl->get_issue_detail(array('sd.sade_salemasterid' => '7991'));

		// echo"<pre>";print_r($this->data['issue_master']);echo"<pre>";	print_r($this->data['issue_details']);die;

		// echo"<pre>";	print_r($this->data['issue_details']);die;

		$this->data['store'] = $this->general->get_tbl_data('eqty_equipmenttype', 'eqty_equipmenttype', array('eqty_equipmenttypeid' => $this->session->userdata(STORE_ID)), 'eqty_equipmenttypeid', 'ASC');

		$this->data['user_signature'] = $this->general->get_signature($this->userid);

		$print_report = $this->load->view('issue/v_new_issue_print_kukl', $this->data, true);

		echo $print_report;

		die();
	}

	public function form_new_issue()
	{

		$this->data['reqno'] = '';

		$this->data['equipmentcategory'] = $this->general->get_tbl_data('*', 'eqca_equipmentcategory', false, 'eqca_equipmentcategoryid', 'DESC');

		$this->data['depatrment'] = $this->general->get_tbl_data('*', 'dept_department', false, 'dept_depid', 'DESC');

		$this->data['material_type'] = $this->general->get_tbl_data('maty_materialtypeid,maty_material', 'maty_materialtype', array('maty_isactive' => 'Y'), 'maty_materialtypeid', 'ASC');

		$this->data['new_issue'] = "";

		$this->data['tab_type'] = 'entry';

		$locationid = $this->session->userdata(LOCATION_ID);

		$currentfyrs = CUR_FISCALYEAR;

		$cur_fiscalyrs_invoiceno = $this->db->select('sama_invoiceno,sama_fyear')

			->from('sama_salemaster')

			->where('sama_locationid', $locationid)

			->where('sama_fyear',$currentfyrs)

			->order_by('sama_fyear', 'DESC')

			->limit(1)

			->get()->row();

		if (!empty($cur_fiscalyrs_invoiceno)) {

			$invoice_format = $cur_fiscalyrs_invoiceno->sama_invoiceno;

			$invoice_string = str_split($invoice_format);

			// echo "<pre>";

			// print_r($invoice_string);

			// die();

			$invoice_prefix_len = strlen(INVOICE_NO_PREFIX);

			$chk_first_string_after_invoice_prefix = $invoice_string[$invoice_prefix_len];

			// echo $chk_first_string_after_invoice_prefix;

			// die();

			if ($chk_first_string_after_invoice_prefix == '0') {

				$invoice_no_prefix = INVOICE_NO_PREFIX . CUR_FISCALYEAR;
			} else if ($cur_fiscalyrs_invoiceno->sama_fyear == $currentfyrs && $chk_first_string_after_invoice_prefix == '0') {

				$invoice_no_prefix = INVOICE_NO_PREFIX . CUR_FISCALYEAR;
			} else if ($cur_fiscalyrs_invoiceno->sama_fyear != $currentfyrs && $chk_first_string_after_invoice_prefix == '0') {

				$invoice_no_prefix = INVOICE_NO_PREFIX . CUR_FISCALYEAR;
			} else if ($cur_fiscalyrs_invoiceno->sama_fyear != $currentfyrs && $chk_first_string_after_invoice_prefix != '0') {

				$invoice_no_prefix = INVOICE_NO_PREFIX . CUR_FISCALYEAR;
			} else {

				$invoice_no_prefix = INVOICE_NO_PREFIX;
			}
		} else {

			$invoice_no_prefix = INVOICE_NO_PREFIX . CUR_FISCALYEAR;
		}

		// die();

		if (ORGANIZATION_NAME == 'KU' || ORGANIZATION_NAME =='PU' || ORGANIZATION_NAME == 'NPHL') {

			$invoice_no_prefix = '';

			$this->data['issue_no'] = $this->general->generate_invoiceno('sama_invoiceno', 'sama_invoiceno', 'sama_salemaster', $invoice_no_prefix, INVOICE_NO_LENGTH, array('sama_fyear'=>$currentfyrs), 'sama_locationid', 'sama_salemasterid', 'S', 'DESC', 'Y');

			// $location_fieldname =false,$order_by=false,$order_type='S',$order='DESC',$is_disable_prefix='N')

		} else {

			$this->data['issue_no'] = $this->general->generate_invoiceno('sama_invoiceno', 'sama_invoiceno', 'sama_salemaster', $invoice_no_prefix, INVOICE_NO_LENGTH, array('sama_fyear'=>$currentfyrs), 'sama_locationid', 'sama_salemasterid', 'S', 'DESC');
		}

		if (!empty($this->mattypeid)) {

			$srchmat = array('maty_materialtypeid' => $this->mattypeid, 'maty_isactive' => 'Y');
		} else {

			$srchmat = array('maty_isactive' => 'Y');
		}

		$this->data['material_type'] = $this->general->get_tbl_data('maty_materialtypeid,maty_material', 'maty_materialtype', $srchmat, 'maty_materialtypeid', 'ASC');

		$this->data['fiscal_year'] = $this->general->get_tbl_data('*', 'fiye_fiscalyear', false, 'fiye_fiscalyear_id', 'DESC', 2);

		if (defined('NEW_ISSUE_FORM_TYPE')) :

			if (NEW_ISSUE_FORM_TYPE == 'DEFAULT') {

				$this->load->view('issue/v_new_issue_form', $this->data);
			} else {

				$this->load->view('issue/' . REPORT_SUFFIX . '/v_new_issue_form', $this->data);
			}

		else :

			$this->load->view('issue/v_new_issue_form', $this->data);

		endif;

		//$this->load->view('issue/v_new_issue_form',$this->data);

	}

	public function check_req_no()

	{

		$req_no = $this->input->post('sama_requisitionno');

		$fyear = $this->input->post('sama_fyear');

		$storeid = !empty($this->session->userdata(STORE_ID)) ? $this->session->userdata(STORE_ID) : 1;

		$srchcol = array('rema_reqno' => $req_no, 'rema_fyear' => $fyear, 'rema_reqtodepid' => $storeid, 'rema_approved' => '1');

		$this->data['req_data'] = $this->stock_requisition_mdl->get_req_no_list($srchcol, 'rema_reqno', 'desc');

		// echo $this->db->last_query();

		// die();

		if (!empty($this->data['req_data'])) {

			return 1;
		} else {

			return 0;
		}
	}

	public function issuelist_by_req_no()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$req_no = $this->input->post('req_no');

			$fyear = $this->input->post('fyear');

			$mattypeid = $this->input->post('mattypeid');

			$storeid = !empty($this->session->userdata(STORE_ID)) ? $this->session->userdata(STORE_ID) : 1;

			$srchcol = array('rema_reqno' => $req_no, 'rema_fyear' => $fyear, 'rema_reqtodepid' => $storeid, 'rema_locationid' => $this->locationid);

			if (!empty($mattypeid)) {

				$srchcol['rema_mattypeid'] = $mattypeid;
			}

			// echo "<pre>";

			// print_r($srchcol);

			// die();

			$this->data['req_data'] = $this->stock_requisition_mdl->get_req_no_list($srchcol, 'rema_reqno', 'desc');

			// echo "<pre>";

			// echo $this->db->last_query();

			// die();

			// echo "<pre>";print_r($this->data['req_data']);die();

			$req_data = array();

			if (!empty($this->data['req_data'])) {

				$masterid = $this->data['req_data'][0]->rema_reqmasterid;
				$referrer = $_SERVER['HTTP_REFERER'];
				if (strpos($referrer, 'purchase_receive/purchase_requisition') !== false) {
					$check_for_prev_store = $this->db->select('pure_reqmasterid')
						->from('pure_purchaserequisition')
						->where(array('pure_reqmasterid' => $masterid))
						->get()->result();
					if (!empty($check_for_prev_store)) {
						print_r(json_encode(array('status' => 'error', 'message' => 'Demand No. ' . $req_no . ' is Already Requested To Purchase. Please Try another !!',)));

						exit;
					}
				}

				$isapproved = !empty($this->data['req_data'][0]->rema_approved) ? $this->data['req_data'][0]->rema_approved : '0';

				// echo $isapproved;

				// die();

				$purchasereqid = !empty($this->data['req_data'][0]->purchasereqid) ? $this->data['req_data'][0]->purchasereqid : '';

				// echo $purchasereqid;

				// die();

				if (!empty($purchasereqid)) {

					// if(ORGANIZATION_NAME=='KU'){

					// 	print_r(json_encode(array('status'=>'error','message'=>'Already Send to Purchase Requisition !!!')));

					// 	exit;

					// }

				}

				if (DEFAULT_DATEPICKER == 'NP') {

					$req_data['req_date'] = $this->data['req_data'][0]->rema_reqdatebs;
				} else {

					$req_data['req_date'] = $this->data['req_data'][0]->rema_reqdatead;
				}

				$req_data['fromdepid'] = $this->data['req_data'][0]->rema_reqfromdepid;

				$req_data['reqby'] = $this->data['req_data'][0]->rema_reqby;

				// echo "<pre>";
				// print_r($req_data);
				// echo "</pre>";
				// die;

				if ($isapproved == '0' && empty($isapproved)) {

					print_r(json_encode(array('status' => 'error', 'message' => 'Demand  number is not approved !!')));

					exit;
				} else {

					print_r(json_encode(array('status' => 'success', 'message' => 'Data Selected  Successfully!!', 'masterid' => $masterid, 'req_data' => $req_data)));

					exit;
				}
			} else {

				print_r(json_encode(array('status' => 'error', 'message' => 'Demand Req. no. is not exit. Please Try Another Demand Req. no. !!!')));

				exit;
			}
		} else {

			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));

			exit;
		}
	}

	public function issue_book_details_list()

	{

		if (MODULES_VIEW == 'N') {

			$array = array();

			// $this->general->permission_denial_message();

			echo json_encode(array("recordsFiltered" => 0, "recordsTotal" => 0, "data" => $array));

			exit;
		}

		$apptype = $this->input->get('apptype');

		$useraccess = $this->session->userdata(USER_ACCESS_TYPE);

		$i = 0;

		$data = $this->new_issue_mdl->get_issue_book_details_list();

		$array = array();

		$filtereddata = ($data["totalfilteredrecs"] > 0 ? $data["totalfilteredrecs"] : $data["totalrecs"]);

		$totalrecs = $data["totalrecs"];

		unset($data["totalfilteredrecs"]);

		unset($data["totalrecs"]);

		if ($apptype == 'cancel' || $apptype == 'issue' || empty($apptype)) {

			foreach ($data as $row) {

				if (ITEM_DISPLAY_TYPE == 'NP') {

					$req_itemname = !empty($row->itli_itemnamenp) ? $row->itli_itemnamenp : $row->itli_itemname;
				} else {

					$req_itemname = !empty($row->itli_itemname) ? $row->itli_itemname : '';
				}

				$appclass = '';

				$approved = $row->sama_st;

				if ($approved == 'C') {

					$appclass = 'cancel';
				}

				$array[$i]["approvedclass"] = $appclass;

				$array[$i]['salemasterid'] = $row->sama_salemasterid;

				$array[$i]["invoiceno"] = $row->sama_invoiceno;

				$array[$i]["billdatebs"] = $row->sama_billdatebs;

				$array[$i]["billdatead"] = $row->sama_billdatead;

				$array[$i]["depname"] = $row->sama_depname;

				$array[$i]["totalamount"] = $row->sama_totalamount;

				$array[$i]["username"] = $row->sama_username;

				$array[$i]["memno"] = $row->sama_receivedby;

				$array[$i]["requisitionno"] = $row->sama_requisitionno;

				$array[$i]["billtime"] = $row->sama_billtime;

				$array[$i]["sade_qty"] = sprintf('%g',$row->sade_qty);

				$array[$i]["sade_unitrate"] = number_format($row->sade_unitrate, 2);

				$array[$i]["issueamt"] = number_format($row->issueamt, 2);

				$array[$i]["itli_itemcode"] = $row->itli_itemcode;

				$array[$i]["itli_itemname"] = $req_itemname;

				$array[$i]["sade_remarks"] = $row->sade_remarks;

				$array[$i]["action"] = '';

				$i++;
			}
		}

		echo json_encode(array("recordsFiltered" => $filtereddata, "recordsTotal" => $totalrecs, "data" => $array));
	}

	public function exportToExcelIssueDetails()
	{

		header("Content-Type: application/xls");

		header("Content-Disposition: attachment; filename=issue_details_list" . date('Y_m_d_H_i') . ".xls");

		header("Pragma: no-cache");

		header("Expires: 0");

		$data = $this->new_issue_mdl->get_issue_book_details_list();

		$this->data['searchResult'] = $this->new_issue_mdl->get_issue_book_details_list();

		$array = array();

		unset($this->data['searchResult']["totalfilteredrecs"]);

		unset($this->data['searchResult']["totalrecs"]);

		$response = $this->load->view('issue/v_issue_details_download', $this->data, true);

		echo $response;
	}

	public function generate_pdfIssueDetails()

	{
		$page_orientation = !empty($_GET['page_orientation']) ? $_GET['page_orientation']  : '';
		if ($page_orientation == 'L') {
			$page_size = 'A4-L';
		} else {
			$page_size = 'A4';
		}

		$this->data['searchResult'] = $this->new_issue_mdl->get_issue_book_details_list();

		unset($this->data['searchResult']["totalfilteredrecs"]);

		unset($this->data['searchResult']["totalrecs"]);

		if (ORGANIZATION_NAME == 'KU' || ORGANIZATION_NAME =='PU') {
			$html = $this->load->view('issue/ku/v_issue_details_download', $this->data, true);
		} else {
			$html = $this->load->view('issue/v_issue_details_download', $this->data, true);
		}

		$this->general->generate_pdf($html, '', $page_size);
	}

	public function issue_book_list()

	{

		if (MODULES_VIEW == 'N') {

			$array = array();

			// $this->general->permission_denial_message();

			echo json_encode(array("recordsFiltered" => 0, "recordsTotal" => 0, "data" => $array));

			exit;
		}

		$apptype = $this->input->get('apptype');

		// print_r($apptype);die;

		$useraccess = $this->session->userdata(USER_ACCESS_TYPE);

		$i = 0;

		if ($apptype == 'cancel') {

			$data = $this->new_issue_mdl->get_issue_book_list(array('sama_st' => 'C'));

		} else if ($apptype == 'issuereturn') {

			$data = $this->new_issue_mdl->get_issue_return_list(array('rema_st' => 'N'));
			
		} else if ($apptype == 'returncancel') {

			$data = $this->new_issue_mdl->get_issue_return_list(array('rema_st' => 'C'));
		} else if ($apptype == 'issue' || empty($apptype)) {

			$data = $this->new_issue_mdl->get_issue_book_list(array('sama_st' => 'N'));
			// echo $this->db->last_query();
			// die();
			// echo "<pre>";
			// print_r($data);
			// die();
		}

		$array = array();

		$filtereddata = ($data["totalfilteredrecs"] > 0 ? $data["totalfilteredrecs"] : $data["totalrecs"]);

		$totalrecs = $data["totalrecs"];

		// echo "<pre>";

		// print_r($data);

		// die();

		// echo $this->db->last_query();

		// die();

		unset($data["totalfilteredrecs"]);

		unset($data["totalrecs"]);

		$view_heading_var = $this->lang->line('issue_requisition_details');

		if ($apptype == 'cancel' || $apptype == 'issue' || empty($apptype)) {

			foreach ($data as $row) {

				$postdatead = $row->sama_postdatead;

				$posttime = $row->sama_posttime;

				$editstatus = $this->general->compute_data_for_edit($postdatead, $posttime);

				$editbtn = '<a href="javascript:void(0)" data-id="' . $row->sama_salemasterid . '" class="btnredirect btn-xxs btn-info" title="Edit" data-viewurl="' . base_url('issue_consumption/new_issue/issue_edit') . '" ><i class="fa fa-edit " aria-hidden="true"></i></a>';

				// if($editstatus==0)

				// {

				// 	$editbtn='';

				// }

				// echo $editstatus;

				$appclass = '';

				$approved = $row->sama_st;

				if ($approved == 'C') {

					$appclass = 'cancel';
				}

				$array[$i]["approvedclass"] = $appclass;

				$array[$i]['salemasterid'] = $row->sama_salemasterid;

				$array[$i]["invoiceno"] = $row->sama_invoiceno;

				$array[$i]["billdatebs"] = $row->sama_billdatebs;

				$array[$i]["billdatead"] = $row->sama_billdatead;

				$array[$i]["depname"] = $row->sama_depname;

				$array[$i]["totalamount"] = round($row->totalamt, 2);

				//$row->totalamt;

				//round($row->totalamt,2);

				$array[$i]["username"] = $row->sama_username;

				$array[$i]["memno"] = $row->sama_receivedby;

				//	$array[$i]["requisitionno"]=$row->sama_requisitionno;

				$array[$i]["requisitionno"] = '<a href="javascript:void(0)" data-id=' . $row->sama_requisitionno . ' data-fyear=' . $row->sama_fyear . ' data-displaydiv="orderDetails" data-locationid='.$row->sama_locationid.' data-viewurl=' . base_url('issue_consumption/new_issue/issue_requisition_views_details') . ' class="view  btn-xxs" data-heading="' . $view_heading_var . '">' . $row->sama_requisitionno . '</a>';

				$array[$i]["billtime"] = $row->sama_billtime;

				$array[$i]["billno"] = $row->sama_billno;

				$array[$i]["fyear"] = $row->sama_fyear;

				if (ORGANIZATION_NAME == 'KU' || ORGANIZATION_NAME =='PU' || ORGANIZATION_NAME =='ARMY' ) {

					$array[$i]["maty_material"] = !empty($row->maty_material)?$row->maty_material:'';
				}
				if(DEFAULT_DATEPICKER == 'NP'){
				$array[$i]["postdate"] = $row->sama_postdatebs.' '.$row->sama_posttime;
				}else{
					$array[$i]["postdate"] = $row->sama_postdateas.' '.$row->sama_posttime;
				}

				$totalcnt = !empty($row->totcnt) ? $row->totcnt : '0';

				if ($apptype == 'issue' || empty($apptype)) :

					$array[$i]["action"] = $editbtn . '

		 			<a href="javascript:void(0)" data-id=' . $row->sama_invoiceno . ' data-date=' . $row->sama_billdatebs . ' data-viewurl=' . base_url('issue_consumption/new_issue/issue_cancel') . ' class="redirectedit  btn-danger btn-xxs" title="Issue Cancel"><i class="fa fa-times-rectangle" aria-hidden="true"></i></a> <a href="javascript:void(0)" data-id=' . $row->sama_invoiceno . ' data-detailid=' . $row->sama_fyear . ' data-date=' . $row->sama_billdatebs . ' data-viewurl=' . base_url('issue_consumption/new_issue/issue_return') . ' class="redirectedit  btn-info btn-xxs"><i class="fa fa-undo" title="Issue Return" aria-hidden="true" ></i></a>  <a href="javascript:void(0)" data-id=' . $row->sama_salemasterid . ' data-invoiceno=' . $row->sama_invoiceno . ' data-fyear=' . $row->sama_fyear . ' data-displaydiv="IssueDetails" data-viewurl=' . base_url('issue_consumption/new_issue/issue_details_views') . ' class="view btn-primary badge" data-heading=' . $this->lang->line('issue_details') . ' title=View ' . $this->lang->line('issue_details') . '>' . $totalcnt . '</a>';

				else :

					$array[$i]["action"] = "";

				endif;

				$i++;
			}
		} else if ($apptype == 'issuereturn' || $apptype == 'returncancel') {

			foreach ($data as $row) :

				$appclass = '';

				$approved = $row->rema_st;

				if ($approved == 'C') {

					$appclass = 'returncancel';
				} else {

					$appclass = 'issuereturn';
				}

				$array[$i]["approvedclass"] = $appclass;

				$array[$i]['salemasterid'] = $row->rema_returnmasterid;

				$array[$i]["invoiceno"] = $row->rema_receiveno;

				$array[$i]["billdatebs"] = $row->rema_returndatebs;

				$array[$i]["billdatead"] = $row->rema_returndatead;

				$array[$i]["depname"] = $row->dept_depname;

				$array[$i]["totalamount"] = $row->rema_amount;

				$array[$i]["username"] = $row->rema_username;

				$array[$i]["memno"] = $row->rema_returnby;

				$array[$i]["fyear"] = $row->rema_fyear;

				$array[$i]["requisitionno"] = $row->rema_invoiceno;

				// $array[$i]["requisitionno"]='<a href="javascript:void(0)" data-id="0" data-fyear='.$row->rema_fyear.' data-displaydiv="orderDetails" data-viewurl='.base_url('issue_consumption/new_issue/issue_requisition_views_details').' class="view  btn-xxs" data-heading="'.$view_heading_var.'">'.$row->rema_invoiceno.'</a>';

				$array[$i]["billtime"] = $row->rema_returntime;

				$array[$i]["billno"] = $row->rema_receiveno;

				if ($apptype == 'issuereturn') :

					$array[$i]["action"] = '<a href="javascript:void(0)" data-id=' . $row->rema_invoiceno . ' data-date=' . $row->rema_returndatebs . ' data-viewurl=' . base_url('issue_consumption/new_issue/issue_returncancel') . ' class="redirectedit btn-danger btn-xxs"><i class="fa fa-times" title="Return Cancel" aria-hidden="true" ></i></a>   <a href="javascript:void(0)" data-id=' . $row->rema_returnmasterid . '  data-displaydiv="IssueDetails" data-viewurl=' . base_url('issue_consumption/new_issue/issue_return_details_views') . ' class="view btn-primary btn-xxs" title="View" data-heading="Issue Return Details" ><i class="fa fa-eye" title="Return view" aria-hidden="true" ></i</a>

		 			';

				elseif ($apptype == 'returncancel') :

					$array[$i]["action"] = "";

				else :

					$array[$i]["action"] = "";

				endif;

				$i++;

			endforeach;
		}

		echo json_encode(array("recordsFiltered" => $filtereddata, "recordsTotal" => $totalrecs, "data" => $array));
	}

	public function issue_edit()

	{

		$this->data['issue_masterid'] = $id = $this->input->post('id');

		if ($id) {

			$this->data['issue_master'] = $this->new_issue_mdl->get_salemaster_date_id(array('sm.sama_salemasterid' => $id));

			$this->data['issue_details'] = $this->new_issue_mdl->get_issue_detail_edit(array('sd.sade_salemasterid' => $id));

			// echo "<pre>";

			// // print_r($this->data['issue_master'] );

			// print_r($this->data['issue_details']);

			// die();

			// $this->data['all_issue_details'] = $this->new_issue_mdl->get_all_issue_details($id, $invoiceno, $fyear);

			//echo $this->db->last_query();die;

		}

		$this->data['equipmentcategory'] = $this->general->get_tbl_data('*', 'eqca_equipmentcategory', false, 'eqca_equipmentcategoryid', 'DESC');

		$this->data['depatrment'] = $this->general->get_tbl_data('*', 'dept_department', false, 'dept_depid', 'DESC');

		$this->data['fiscal_year'] = $this->general->get_tbl_data('*', 'fiye_fiscalyear', false, 'fiye_fiscalyear_id', 'DESC');

		if (!empty($this->mattypeid)) {

			$srchmat = array('maty_materialtypeid' => $this->mattypeid, 'maty_isactive' => 'Y');
		} else {

			$srchmat = array('maty_isactive' => 'Y');
		}

		$this->data['material_type'] = $this->general->get_tbl_data('maty_materialtypeid,maty_material', 'maty_materialtype', $srchmat, 'maty_materialtypeid', 'ASC');

		$this->data['new_issue'] = "";

		$this->data['tab_type'] = 'edit_issue';

		$this->data['issue_no'] = $this->generate_invoiceno();

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

			->build('issue/v_new_issue', $this->data);
	}

	public function generate_pdfIssueBookList()

	{

		$page_orientation = !empty($_GET['page_orientation']) ? $_GET['page_orientation']  : '';
		if ($page_orientation == 'L') {
			$page_size = 'A4-L';
		} else {
			$page_size = 'A4';
		}

		$apptype = $this->input->get('apptype');

		if ($apptype == 'cancel') {

			$this->data['searchResult'] = $this->new_issue_mdl->get_issue_book_list(array('sama_st' => 'C'));
		} else if ($apptype == 'issuereturn') {

			$this->data['searchResult'] = $this->new_issue_mdl->get_issue_return_list(array('rema_st' => 'N'));
		} else if ($apptype == 'returncancel') {

			$this->data['searchResult'] = $this->new_issue_mdl->get_issue_return_list(array('rema_st' => 'C'));
		} else if ($apptype == 'issue' || empty($apptype)) {

			$this->data['searchResult'] = $this->new_issue_mdl->get_issue_book_list(array('sama_st' => 'N'));
		}

		// $this->data['searchResult'] = $this->stock_requisition_mdl->get_requisition_list();

		unset($this->data['searchResult']['totalfilteredrecs']);

		unset($this->data['searchResult']['totalrecs']);

		if (ORGANIZATION_NAME == 'KU' || ORGANIZATION_NAME =='PU') {
			// echo "string";
			// die();
			$html = $this->load->view('issue/ku/v_new_issue_download', $this->data, true);
		} else {

			$html = $this->load->view('issue/v_new_issue_download', $this->data, true);
		}

		$this->general->generate_pdf($html, '', $page_size);
	}

	public function exportToExcelIssueBookList()
	{

		header("Content-Type: application/xls");

		header("Content-Disposition: attachment; filename=new_issue" . date('Y_m_d_H_i') . ".xls");

		header("Pragma: no-cache");

		header("Expires: 0");

		//$data = $this->issue_requisition_mdl->get_requisition_list();

		$apptype = $this->input->get('apptype');

		if ($apptype == 'cancel') {

			$data = $this->new_issue_mdl->get_issue_book_list(array('sama_st' => 'C'));
		} else if ($apptype == 'issuereturn') {

			$data = $this->new_issue_mdl->get_issue_return_list(array('rema_st' => 'N'));
		} else if ($apptype == 'returncancel') {

			$data = $this->new_issue_mdl->get_issue_return_list(array('rema_st' => 'C'));
		} else if ($apptype == 'issue' || empty($apptype)) {

			$data = $this->new_issue_mdl->get_issue_book_list(array('sama_st' => 'N'));
		}

		//$this->data['searchResult'] = $this->issue_requisition_mdl->get_requisition_list();

		//$apptype = $this->input->get('apptype');

		if ($apptype == 'cancel') {

			$this->data['searchResult'] = $this->new_issue_mdl->get_issue_book_list(array('sama_st' => 'C'));
		} else if ($apptype == 'issuereturn') {

			$this->data['searchResult'] = $this->new_issue_mdl->get_issue_return_list(array('rema_st' => 'N'));
		} else if ($apptype == 'returncancel') {

			$this->data['searchResult'] = $this->new_issue_mdl->get_issue_return_list(array('rema_st' => 'C'));
		} else if ($apptype == 'issue' || empty($apptype)) {

			$this->data['searchResult'] = $this->new_issue_mdl->get_issue_book_list(array('sama_st' => 'N'));
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

			if ($id) {

				$issue_master = $this->data['issue_master'] = $this->new_issue_mdl->get_salemaster_date_id(array('sama_salemasterid' => $id));

				// echo "<pre>";

				// print_r($issue_master);

				// die();

				$this->data['issue_details'] = $this->new_issue_mdl->get_issue_detail(array('sd.sade_salemasterid' => $id));

				// 	echo "<pre>";

				// print_r($this->data['issue_details']);

				// die();

				$this->data['store'] = $this->general->get_tbl_data('eqty_equipmenttype', 'eqty_equipmenttype', array('eqty_equipmenttypeid' => $this->session->userdata(STORE_ID)), 'eqty_equipmenttypeid', 'ASC');

				//signature

				$this->data['user_signature'] = $this->general->get_signature($this->userid);

				$approve_data = $this->new_issue_mdl->get_approve_data($id);

				$approvedby = !empty($approve_data[0]->rema_approvedid) ? $approve_data[0]->rema_approvedid : '';

				$this->data['approver_signature'] = $this->general->get_signature($approvedby);

				$issue_date = !empty($issue_details[0]->sama_billdatebs) ? $issue_details[0]->sama_billdatebs : CURDATE_NP;

				$store_head_id = $this->general->get_store_post_data($issue_date, 'store_head');

				$this->data['store_head_signature'] = $this->general->get_signature($store_head_id);

				$this->data['user_list_for_issue_report'] = $this->new_issue_mdl->get_user_list_for_issue_report($id);

				$this->data['requisition_data'] = $requisition_data = $this->new_issue_mdl->get_requisition_data_from_salemasterid($id);

				$rema_reqmasterid = !empty($requisition_data[0]->rema_reqmasterid) ? $requisition_data[0]->rema_reqmasterid : 0;

				$this->data['get_branch_manager_name'] = $this->general->get_username_from_actionlog(array('aclo_masterid' => $rema_reqmasterid, 'aclo_status' => 2, 'aclo_fieldname' => 'rema_proceedissue'));

				$this->data['equipment_category'] = $this->new_issue_mdl->get_equipment_category($id);

				//echo "ok";die;

				// echo "<pre>";
				// print_r($this->data);
				// echo "</pre>";
				// die;

				if ($issue_master[0]->sama_ishandover == 'Y') {

					$template = $this->load->view('direct_issue/v_direct_issue_print', $this->data, true);
					// if (NEW_ISSUE_REPORT_TYPE == 'DEFAULT') {
					// 	$template = $this->load->view('direct_issue/v_direct_issue_print', $this->data, true);

					// } else {

					// 	$template = $this->load->view('direct_issue/v_direct_issue_print' . '_' . REPORT_SUFFIX, $this->data, true);
					// }
				} else {

					if (NEW_ISSUE_REPORT_TYPE == 'DEFAULT') {

						$template = $this->load->view('issue/v_new_issue_print', $this->data, true);
					} else {

						$template = $this->load->view('issue/' . REPORT_SUFFIX . '/v_new_issue_print', $this->data, true);
						
						// $template = $this->load->view('issue/v_new_issue_print' . '_' . REPORT_SUFFIX, $this->data, true);
					}
				}

				//print_r($this->data['issue_master']);die;

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

	public function varpai_issue_details()

	{

		// echo "test";

		// die();

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$id = $this->input->post('id');

			if ($id) {

				$this->data['issue_master'] = $this->new_issue_mdl->varpai_issue_details(array('il.itli_materialtypeid' => 2));

				$this->data['issue_details'] = $this->new_issue_mdl->get_issue_detail(array('sd.sade_salemasterid' => $id, 'il.itli_materialtypeid' => 2));

				$template = '';

				$template = $this->load->view('direct_issue/v_verpai_issue_print', $this->data, true);

				// echo "<pre>";

				//      print_r($template);

				//      die();

				// if($template){

				// 	// echo "test";

				// 	// die();

				// 	print_r(json_encode(array('status'=>'success','message'=>'','tempform'=>$template)));

				//         	exit;

				// }

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

	public function voucher_print()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$id = $this->input->post('id');

			if ($id) {

				$issue_master = $this->data['issue_master'] = $this->general->get_tbl_data('*', 'sama_salemaster', array('sama_salemasterid' => $id), 'sama_salemasterid', 'DESC');

				$this->data['issue_details'] = $this->new_issue_mdl->get_issue_detail(array('sd.sade_salemasterid' => $id));

				$this->data['store'] = $this->general->get_tbl_data('eqty_equipmenttype', 'eqty_equipmenttype', array('eqty_equipmenttypeid' => $this->session->userdata(STORE_ID)), 'eqty_equipmenttypeid', 'ASC');

				//signature

				$this->data['user_signature'] = $this->general->get_signature($this->userid);

				$approve_data = $this->new_issue_mdl->get_approve_data($id);

				$approvedby = !empty($approve_data[0]->rema_approvedid) ? $approve_data[0]->rema_approvedid : '';

				$this->data['approver_signature'] = $this->general->get_signature($approvedby);

				$issue_date = !empty($issue_details[0]->sama_billdatebs) ? $issue_details[0]->sama_billdatebs : CURDATE_NP;

				$store_head_id = $this->general->get_store_post_data($issue_date, 'store_head');

				$this->data['store_head_signature'] = $this->general->get_signature($store_head_id);

				$this->data['user_list_for_issue_report'] = $this->new_issue_mdl->get_user_list_for_issue_report($id);

				$this->data['requisition_data'] = $requisition_data = $this->new_issue_mdl->get_requisition_data_from_salemasterid($id);

				$rema_reqmasterid = !empty($requisition_data[0]->rema_reqmasterid) ? $requisition_data[0]->rema_reqmasterid : 0;

				$this->data['get_branch_manager_name'] = $this->general->get_username_from_actionlog(array('aclo_masterid' => $rema_reqmasterid, 'aclo_status' => 2, 'aclo_fieldname' => 'rema_proceedissue'));

				$this->data['equipment_category'] = $this->new_issue_mdl->get_equipment_category($id);

				//echo "ok";die;

				if (RECV_REPORT_TYPE == 'DEFAULT') {

					$template = $this->load->view('issue/v_voucher_print', $this->data, true);
				} else {

					$template = $this->load->view('issue/v_voucher_print' . '_' . REPORT_SUFFIX, $this->data, true);
				}

				//print_r($this->data['issue_master']);die;

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

	public function issue_details_views()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			if ($_SERVER['REQUEST_METHOD'] === 'POST') {

				$id = $this->input->post('id');

				$invoiceno = $this->input->post('invoiceno');

				$fyear = $this->input->post('fiscal_year');

				if ($id) {

					$this->data['issue_master'] = $this->new_issue_mdl->get_salemaster_date_id(array('sm.sama_salemasterid' => $id));

					// echo "<pre>";

					// print_r($this->data['issue_master']);

					// die();

					$this->data['issue_details'] = $this->new_issue_mdl->get_issue_detail(array('sd.sade_salemasterid' => $id));

					$this->data['all_issue_details'] = $this->new_issue_mdl->get_all_issue_details($id, $invoiceno, $fyear);
					// 	echo $this->db->last_query();
					// die();

					//echo $this->db->last_query();die;

					// echo"<pre>";print_r($this->data['all_issue_details']);die();

					$template = $this->load->view('issue/v_issue_details_view', $this->data, true);

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
		} else {

			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));

			exit;
		}
	}

	public function issue_cancel()
	{

		$this->data['tab_type'] = 'cancel';

		$this->data['issue_no'] = $this->generate_invoiceno();

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

			->build('issue/v_new_issue', $this->data);
	}

	public function issue_cancel_item()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			try {

				$sade_id = $this->input->post('id');

				// echo $sade_id;

				// die();

				$sade_data = $this->new_issue_mdl->get_issue_detail(array('sade_saledetailid' => $sade_id));

				// echo "<pre>";

				// print_r($sade_data);

				// die();

				if (empty($sade_data)) {

					print_r(json_encode(array('status' => 'error', 'message' => 'Unable to cancel this Item !!!')));

					exit;
				} else {

					$qty = $sade_data[0]->sade_qty;

					$mat_transdetailid = $sade_data[0]->sade_mattransdetailid;

					$iscancel = $sade_data[0]->sade_iscancel;

					if ($iscancel == 'Y') {

						print_r(json_encode(array('status' => 'error', 'message' => 'Already Cancel this Item !!!')));

						exit;
					}

					$update_sd = $this->new_issue_mdl->update_salesdetail($sade_id);

					$mat_trans = $this->new_issue_mdl->update_mat_trans_detailid($mat_transdetailid, $qty);

					print_r(json_encode(array('status' => 'success', 'message' => 'Successfully Cancelled !!!')));

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

	public function issue_cancel_item_all()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			try {

				$sama_id = $this->input->post('id');

				// echo $sama_id;

				// die();

				$sama_data = $this->new_issue_mdl->get_issue_master(array('sama_salemasterid' => $sama_id));

				// echo "<pre>";

				// print_r($sama_data);

				// die();

				$reqno = !empty($sama_data[0]->sama_requisitionno) ? $sama_data[0]->sama_requisitionno : '';

				$fyear = !empty($sama_data[0]->sama_fyear) ? $sama_data[0]->sama_fyear : '';

				$storeid = !empty($sama_data[0]->sama_storeid) ? $sama_data[0]->sama_storeid : '';

				$locationid = !empty($sama_data[0]->sama_locationid) ? $sama_data[0]->sama_locationid : '';

				$depid = !empty($sama_data[0]->sama_depid) ? $sama_data[0]->sama_depid : '';

				if (empty($sama_data)) {

					print_r(json_encode(array('status' => 'error', 'message' => 'Unable to cancel')));

					exit;
				}

				if ($sama_data[0]->sama_st == 'C') {

					print_r(json_encode(array('status' => 'error', 'message' => 'Already cancel this issue no!!')));

					exit;
				} else {

					$this->db->trans_begin();

					$this->new_issue_mdl->update_salesmaster($sama_id);

					$sade_data = $this->new_issue_mdl->get_issue_detail(array('sade_salemasterid' => $sama_id));

					// echo "<pre>";

					// print_r($sade_data);

					// die();

					// $this->new_issue_mdl->update_reqmaster($reqno,$fyear,$storeid,$depid,$locationid);

					if (!empty($sade_data)) {

						foreach ($sade_data as $ksd => $sade) {

							$saledetailid = $sade->sade_saledetailid;

							$qty = $sade->sade_qty;

							$mat_transdetailidid = $sade->sade_mattransdetailid;

							$iscancel = $sade->sade_iscancel;

							$reqdetailid = $sade->sade_reqdetailid;

							if ($iscancel != 'Y') {

								$update_sd = $this->new_issue_mdl->update_salesdetail($saledetailid);
							}

							if ($mat_transdetailidid) {

								$mat_trans = $this->new_issue_mdl->update_mat_trans_detailid($mat_transdetailidid, $qty);
							}

							if ($reqdetailid) {

								$update_reqdetail = $this->new_issue_mdl->update_reqdetail($reqdetailid);
							}
						}
					}

					$this->db->trans_complete();

					if ($this->db->trans_status() === FALSE) {

						$this->db->trans_rollback();

						trigger_error("Commit failed");

						// return false;

					} else {

						$this->db->trans_commit();
					}

					print_r(json_encode(array('status' => 'success', 'message' => 'Successfully Cancelled !!!')));

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

	public function issue_return()
	{

		$this->data['tab_type'] = 'return';

		$this->data['fiscal'] = $this->general->get_tbl_data('*', 'fiye_fiscalyear', false, 'fiye_fiscalyear_id', 'DESC');

		$this->data['return_issue_no'] = $this->generate_return_invoiceno();

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

			->build('issue/v_new_issue', $this->data);
	}

	public function form_issue_return()
	{

		$this->data['tab_type'] = 'return';

		$this->data['fiscal'] = $this->general->get_tbl_data('*', 'fiye_fiscalyear', false, 'fiye_fiscalyear_id', 'DESC');

		$this->data['return_issue_no'] = $this->generate_return_invoiceno();

		$this->load->view('issue/v_issue_return', $this->data);
	}

	public function issuelist_by_issue_no()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			if (MODULES_VIEW == 'N') {

				print_r(json_encode(array('status' => 'error', 'message' => $this->general->permission_denial_message())));

				exit;
			}

			$issue_no = $this->input->post('issue_no');

			$issue_date = $this->input->post('issue_date');

			$locationid = !empty($this->input->post('locationid')) ? $this->input->post('locationid') : 0;

			$this->storeid = $this->session->userdata(STORE_ID);

			if (DEFAULT_DATEPICKER == 'NP') {

				$srchcol = array('sama_billdatebs' => $issue_date, 'sama_invoiceno' => $issue_no, 'sama_storeid' => $this->storeid, 'sama_locationid' => $this->locationid);
			} else {

				$srchcol = array('sama_billdatead' => $issue_date, 'sama_invoiceno' => $issue_no, 'sama_storeid' => $this->storeid, 'sama_locationid' => $this->locationid);
			}

			$this->data['issue_data'] = $this->new_issue_mdl->get_issue_master($srchcol);

			// echo $this->db->last_query();

			// die();

			// echo "<pre>";

			// print_r($this->data['issue_data']);

			// die();

			if (empty($this->data['issue_data'][0])) {

				print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Cancel this issue.!!!')));

				exit;
			}

			$this->data['issue_detail'] = array();

			$tempform = '';

			if ($this->data['issue_data']) {

				$issuemasterid = $this->data['issue_data'][0]->sama_salemasterid;

				$this->data['issue_detail'] = $this->new_issue_mdl->get_issue_detail(array('sade_salemasterid' => $issuemasterid));

				// 	// echo "<pre>";

				// 	// print_r($this->data['order_detail']);

				// 	// die();

				if ($this->data['issue_detail']) {

					$tempform = $this->load->view('issue/v_issue_list_for_cancel', $this->data, true);
				}
			}

			print_r(json_encode(array('status' => 'success', 'issue_data' => $this->data['issue_data'], 'tempform' => $tempform, 'message' => 'Selected Successfully')));

			exit;
		} else {

			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));

			exit;
		}
	}

	public function issuelist_by_issue_no_for_return()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$issue_no = $this->input->post('issue_no');

			$fiscalyrs = $this->input->post('fiscalyrs');

			$this->storeid = $this->session->userdata(STORE_ID);

			$srchcol = array('sama_fyear' => $fiscalyrs, 'sama_invoiceno' => $issue_no, 'sama_storeid' => $this->storeid);

			$this->data['issue_data'] = $this->new_issue_mdl->get_issue_master($srchcol);

			$req_no = !empty($this->data['issue_data'][0]->sama_requisitionno) ? $this->data['issue_data'][0]->sama_requisitionno : '0';
			if($req_no == 0){
				print_r(json_encode(array('status' => 'error', 'message' => 'Issue number doesnot exisits!!')));

			exit;
			}

			$this->data['return_master'] = $this->general->get_tbl_data('*', 'rema_reqmaster', array('rema_reqno' => $req_no), 'rema_reqmasterid', 'DESC');

			// echo "<pre>";

			// print_r($this->data['return_master']);

			// die();

			// echo $this->db->last_query();

			// die();

			if (empty($this->data['issue_data'])) {

				print_r(json_encode(array('status' => 'error', 'message' => 'Invalid Issue No.!!!')));

				exit;
			}

			$this->data['issue_detail'] = array();

			$tempform = '';

			if ($this->data['issue_data']) {

				$issuemasterid = $this->data['issue_data'][0]->sama_salemasterid;

				$this->data['issue_detail'] = $this->new_issue_mdl->get_issue_detail(array('sade_salemasterid' => $issuemasterid));

				$this->data['issuemasterid'] = $issuemasterid;

				// 	// echo "<pre>";

				// 	// print_r($this->data['order_detail']);

				// 	// die();

				if ($this->data['issue_detail']) {

					$tempform = $this->load->view('issue/v_issue_list_for_return', $this->data, true);
				}
			}

			print_r(json_encode(array('status' => 'success', 'issue_data' => $this->data['issue_data'], 'tempform' => $tempform, 'message' => 'Selected Successfully', 'rerurn_data' => $this->data['return_master'])));

			exit;
		} else {

			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));

			exit;
		}
	}

	public function exportToExcel()
	{

		header("Content-Type: application/xls");

		header("Content-Disposition: attachment; filename=stock_requisition_" . date('Y_m_d_H_i') . ".xls");

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

		$i = 1;

		$iDisplayStart = !empty($_GET['iDisplayStart']) ? $_GET['iDisplayStart'] : 0;

		foreach ($data as $row) {

			$sno = $iDisplayStart + $i;

			$reqdatebs = $row->reno_reqdatebs;

			$reqdatead = $row->reno_reqdatead;

			$reqno = $row->reno_reqno;

			$reqtime = $row->reno_reqtime;

			$appliedby = $row->reno_appliedby;

			$fyear = $row->reno_fyear;

			$costcenter = $row->reno_costcenter;

			$response .= '<tr><td>' . $sno . '</td><td>' . $reqno . '</td><td>' . $reqdatebs . '</td><td>' . $reqdatead . '</td><td>' . $reqtime . '</td><td>' . $appliedby . '</td><td>' . $fyear . '</td><td>' . $costcenter . '</td></tr>';

			$i++;
		}

		$response .= '</table>';

		echo $response;
	}

	public function save_requisition()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			try {

				$id = $this->input->post('id');

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

				if ($this->input->post('id')) {

					if (MODULES_UPDATE == 'N') {

						$this->general->permission_denial_message();

						exit;
					}
				} else {

					if (MODULES_INSERT == 'N') {

						$this->general->permission_denial_message();

						exit;
					}
				}

				$this->form_validation->set_rules($this->store_requisition_mdl->validate_settings_requisition);

				// }

				if ($this->form_validation->run() == TRUE) {

					$trans = $this->store_requisition_mdl->store_requisition_save();

					if ($trans) {

						print_r(json_encode(array('status' => 'success', 'message' => 'Record Save Successfully')));

						exit;
					} else {

						print_r(json_encode(array('status' => 'error', 'message' => 'Operation Unsuccessful')));

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

	public function form_store_requisition()

	{

		$reqdata = $this->general->get_tbl_data('MAX(reno_reqno)+1 as maxreqno', 'reno_requisitionnote', array('reno_fyear' => CUR_FISCALYEAR), false, false);

		$this->data['req_no'] = !empty($reqdata[0]->maxreqno) ? $reqdata[0]->maxreqno : '1';

		$this->load->view('store_requisition/store_requisition_form', $this->data);
	}

	public function generate_invoiceno()

	{

		$curmnth = CURMONTH;

		if ($curmnth == 1) {

			$prefix = 'A';
		}

		if ($curmnth == 2) {

			$prefix = 'B';
		}

		if ($curmnth == 3) {

			$prefix = 'C';
		}

		if ($curmnth == 4) {

			$prefix = 'D';
		}

		if ($curmnth == 5) {

			$prefix = 'E';
		}

		if ($curmnth == 6) {

			$prefix = 'F';
		}

		if ($curmnth == 7) {

			$prefix = 'G';
		}

		if ($curmnth == 8) {

			$prefix = 'H';
		}

		if ($curmnth == 9) {

			$prefix = 'I';
		}

		if ($curmnth == 10) {

			$prefix = 'J';
		}

		if ($curmnth == 11) {

			$prefix = 'K';
		}

		if ($curmnth == 12) {

			$prefix = 'L';
		}

		if (ORGANIZATION_NAME == 'NPHL') {

			$prefix = 'E';
		}

		$this->db->select('sama_invoiceno');

		$this->db->from('sama_salemaster');

		$this->db->where('sama_invoiceno LIKE ' . '"%' . INVOICE_NO_PREFIX . $prefix . '%"');

		$this->db->where('sama_locationid', $this->locationid);

		$this->db->limit(1);

		$this->db->order_by('sama_invoiceno', 'DESC');

		$query = $this->db->get();

		// echo $this->db->last_query(); die();

		$dbinvoiceno = '';

		if ($query->num_rows() > 0) {

			$dbinvoiceno = $query->row()->sama_invoiceno;
		}

		$invoiceno = $this->general->stringseperator($dbinvoiceno, 'number');

		// echo $invoiceno;

		// die();

		if (empty($invoiceno)) {

			$invoiceno = 0;
		}

		$nw_invoice = str_pad($invoiceno + 1, INVOICE_NO_LENGTH, 0, STR_PAD_LEFT);

		if (defined('SHOW_FORM_NO_WITH_LOCATION')) {

			if (SHOW_FORM_NO_WITH_LOCATION == 'Y') {

				return $this->locationcode . '-' . INVOICE_NO_PREFIX . $prefix . $nw_invoice;
			} else {

				return INVOICE_NO_PREFIX . $prefix . $nw_invoice;
			}
		} else {

			return INVOICE_NO_PREFIX . $prefix . $nw_invoice;
		}
	}

	public function generate_return_invoiceno()

	{

		$curmnth = CURMONTH;

		if ($curmnth == 1) {

			$prefix = 'A';
		}

		if ($curmnth == 2) {

			$prefix = 'B';
		}

		if ($curmnth == 3) {

			$prefix = 'C';
		}

		if ($curmnth == 4) {

			$prefix = 'D';
		}

		if ($curmnth == 5) {

			$prefix = 'E';
		}

		if ($curmnth == 6) {

			$prefix = 'F';
		}

		if ($curmnth == 7) {

			$prefix = 'G';
		}

		if ($curmnth == 8) {

			$prefix = 'H';
		}

		if ($curmnth == 9) {

			$prefix = 'I';
		}

		if ($curmnth == 10) {

			$prefix = 'J';
		}

		if ($curmnth == 11) {

			$prefix = 'K';
		}

		if ($curmnth == 12) {

			$prefix = 'L';
		}

		if (ORGANIZATION_NAME == 'NPHL') {

			$prefix = 'E';
		}

		$this->db->select('rema_invoiceno');

		$this->db->from('rema_returnmaster');

		$this->db->where('rema_invoiceno LIKE ' . '"%' . RETURN_NO_PREFIX . $prefix . '%"');

		$this->db->where('rema_locationid', $this->locationid);

		$this->db->limit(1);

		$this->db->order_by('rema_invoiceno', 'DESC');

		$query = $this->db->get();

		// echo $this->db->last_query(); die();

		$dbinvoiceno = '';

		if ($query->num_rows() > 0) {

			$dbinvoiceno = $query->row()->rema_invoiceno;
		}

		$invoiceno = $this->general->stringseperator($dbinvoiceno, 'number');

		$invoiceno = !empty($invoiceno) ? $invoiceno : 0;

		$nw_invoice = str_pad($invoiceno + 1, RETURN_NO_LENGTH, 0, STR_PAD_LEFT);

		if (defined('SHOW_FORM_NO_WITH_LOCATION')) {

			if (SHOW_FORM_NO_WITH_LOCATION == 'Y') {

				return $this->locationcode . '-' . RETURN_NO_PREFIX . $prefix . $nw_invoice;
			} else {

				return RETURN_NO_PREFIX . $prefix . $nw_invoice;
			}
		} else {

			return RETURN_NO_PREFIX . $prefix . $nw_invoice;
		}
	}

	public function save_issue_return($print = false)

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			try {

				if ($this->input->post('id')) {

					if (MODULES_UPDATE == 'N') {

						$this->general->permission_denial_message();

						exit;
					}
				} else {

					if (MODULES_INSERT == 'N') {

						$this->general->permission_denial_message();

						exit;
					}
				}

				// $postdata=$this->input->post();

				//  echo "<pre>";print_r($postdata);die();

				$returnqty = $this->input->post('returnqty');

				$cnttotalArray = count($returnqty);

				$uniqueCnt = 0;

				if ($returnqty) {

					$uniqueCnt = count(array_unique($returnqty));
				}

				// echo $uniqueCnt;

				// echo $cnttotalArray;

				// die();

				if ($uniqueCnt == 1 && $cnttotalArray >= 2) {

					print_r(json_encode(array('status' => 'error', 'message' => 'Atleast one returning Qty. should not be zero !')));

					exit;
				}

				// echo "<pre>";

				// print_r($returnqty);

				// die();

				$this->form_validation->set_rules($this->new_issue_mdl->validate_issue_return);

				if ($this->form_validation->run() == TRUE) {

					$trans = $this->new_issue_mdl->save_issue_return();

					if ($trans) {

						if ($print == "print") {

							$this->data['return_master'] = $this->general->get_tbl_data('*', 'rema_returnmaster', array('rema_returnmasterid' => $trans), 'rema_returnmasterid', 'DESC');

							// echo"<pre>";print_r($this->data['return_master']);die();

							$this->data['return_details'] = $this->new_issue_mdl->get_return_detail(array('rede_returnmasterid' => $trans));

							// echo"<pre>";	print_r($this->data['return_details']);die();

							$this->data['store'] = $this->general->get_tbl_data('eqty_equipmenttype', 'eqty_equipmenttype', array('eqty_equipmenttypeid' => $this->session->userdata(STORE_ID)), 'eqty_equipmenttypeid', 'ASC');

							// echo "<pre>";print_r($this->data['store']);die();

							$this->data['user_signature'] = $this->general->get_signature($this->userid);

							$approve_data = $this->new_issue_mdl->get_approve_data($trans);

							$approvedby = !empty($approve_data[0]->rema_approvedid) ? $approve_data[0]->rema_approvedid : '';

							$this->data['approver_signature'] = $this->general->get_signature($approvedby);

							$issue_date = !empty($issue_details[0]->sama_billdatebs) ? $issue_details[0]->sama_billdatebs : CURDATE_NP;

							$store_head_id = $this->general->get_store_post_data($issue_date, 'store_head');

							$this->data['store_head_signature'] = $this->general->get_signature($store_head_id);

							$print_report = $this->load->view('issue/kukl/v_new_issue_return_print_report', $this->data, true);

							// echo "<pre>"; print_r($print_report);die;

						}

						print_r(json_encode(array('status' => 'success', 'message' => 'Record Save Successfully', 'print_report' => $print_report)));

						exit;
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

	public function issue_summary()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			// // print_r($this->input->post());

			// // die();

			//   $frmDate = !empty($this->input->post('frmdate'))?$this->input->post('frmdate'):CURDATE_NP;

			//     	$toDate = !empty($this->input->post('todate'))?$this->input->post('todate'):CURDATE_NP;

			//   $status_count = $this->new_issue_mdl->getStatusCount(array('sama_billdatebs >='=>$frmDate, 'sama_billdatebs <='=>$toDate,'sama_locationid'=>$this->locationid),'cancel');

			//   $return_count = $this->new_issue_mdl->getStatusCount(array('rema_returndatebs >='=>$frmDate, 'rema_returndatebs <='=>$toDate,'rema_locationid'=>$this->locationid),'return');

			//   // echo $this->db->last_query();

			$issue_status = $this->new_issue_mdl->get_issue_status();

			// echo $this->db->last_query();

			// die();

			print_r(json_encode(array('status' => 'success', 'status_count' => $issue_status)));
		}
	}

	public function issue_returncancel()
	{

		$this->data['tab_type'] = 'returncancel';

		$this->data['issue_no'] = $this->generate_invoiceno();

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

			->build('issue/v_new_issue', $this->data);
	}

	public function issuelist_by_return_no()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			if (MODULES_VIEW == 'N') {

				print_r(json_encode(array('status' => 'error', 'message' => $this->general->permission_denial_message())));

				exit;
			}

			$return_no = $this->input->post('return_no');

			$return_date = $this->input->post('return_date');

			$this->storeid = $this->session->userdata(STORE_ID);

			if (DEFAULT_DATEPICKER == 'NP') {

				$srchcol = array('rema_returndatebs' => $return_date, 'rema_invoiceno' => $return_no, 'rema_storeid' => $this->storeid, 'rema_locationid' => $this->locationid);
			} else {

				$srchcol = array('rema_returndatead' => $return_date, 'rema_invoiceno' => $return_no, 'rema_storeid' => $this->storeid, 'rema_locationid' => $this->locationid);
			}

			$this->data['return_data'] = $this->new_issue_mdl->get_return_master($srchcol);

			// echo "<pre>";

			// print_r($this->data['return_data']);

			// die();

			// echo $this->db->last_query();

			// die();

			if (empty($this->data['return_data'][0])) {

				print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Cancel this Return No.')));

				exit;
			}

			$this->data['return_detail'] = array();

			$tempform = '';

			if ($this->data['return_data']) {

				$returnmasterid = $this->data['return_data'][0]->rema_returnmasterid;

				$this->data['return_detail'] = $this->new_issue_mdl->get_return_detail(array('rede_returnmasterid' => $returnmasterid));

				// 	// echo "<pre>";

				// 	// print_r($this->data['order_detail']);

				// 	// die();

				if ($this->data['return_detail']) {

					$tempform = $this->load->view('issue/v_return_list_for_cancel', $this->data, true);
				}
			}

			print_r(json_encode(array('status' => 'success', 'return_data' => $this->data['return_data'], 'tempform' => $tempform, 'message' => 'Cancel Issue Return Successfully')));

			exit;
		} else {

			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));

			exit;
		}
	}

	public function return_cancel_item_all()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			try {

				$rema_id = $this->input->post('id');

				// echo $rema_id;

				// die();

				$rema_data = $this->new_issue_mdl->get_return_master(array('rema_returnmasterid' => $rema_id));

				// echo "<pre>";

				// print_r($rema_data);

				// die();

				if (empty($rema_data)) {

					print_r(json_encode(array('status' => 'error', 'message' => 'Unable to Cancel')));

					exit;
				}

				if ($rema_data[0]->rema_st == 'C') {

					print_r(json_encode(array('status' => 'error', 'message' => 'Already cancel this receive no!!')));

					exit;
				} else {

					$this->new_issue_mdl->update_returnmaster($rema_id);

					print_r(json_encode(array('status' => 'success', 'message' => 'Successfully Cancelled !!!')));

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

	public function return_cancel_item()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			try {

				$rede_id = $this->input->post('id');

				// echo $rede_id;

				// die();

				$rede_data = $this->new_issue_mdl->get_return_detail(array('rede_returndetailid' => $rede_id));

				// echo "<pre>";

				// print_r($rede_data);

				// die();

				if (empty($rede_data)) {

					print_r(json_encode(array('status' => 'error', 'message' => 'Unable to cancel this Item !!!')));

					exit;
				} else {

					$qty = $rede_data[0]->rede_qty;

					$mat_transdetailid = $rede_data[0]->rede_mattransdetailid;

					$iscancel = $rede_data[0]->rede_iscancel;

					if ($iscancel == 'Y') {

						print_r(json_encode(array('status' => 'error', 'message' => 'Already Cancel this Item !!!')));

						exit;
					}

					$update_rd = $this->new_issue_mdl->update_returndetail($rede_id);

					$mat_trans = $this->new_issue_mdl->update_mat_trans_detailid($mat_transdetailid, $qty, 'returncancel');

					print_r(json_encode(array('status' => 'success', 'message' => 'Successfully Cancelled !!!')));

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

	public function issue_requisition_views_details()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			if ($_SERVER['REQUEST_METHOD'] === 'POST') {

				$id = $this->input->post('id');

				$fyear = $this->input->post('fiscal_year');

				$locationid = $this->input->post('location');

				if ($id) {

					$this->data['stock_requisition_details'] = $this->requisition_mdl->get_requisition_master_data(array('rm.rema_reqno' => $id, 'rm.rema_fyear' => $fyear,'rm.rema_locationid' => $locationid));

					// print_r($this->data['stock_requisition_details']);

					$template = '';

					if ($this->data['stock_requisition_details'] > 0) {

						$mast_id = $this->data['stock_requisition_details'][0]->rema_reqmasterid;

						// echo $mast_id;

						$store_id = $this->data['stock_requisition_details'][0]->rema_storeid;

						$this->data['stock_requisition'] = $this->requisition_mdl->get_requisition_details_data(array('rd.rede_reqmasterid' => $mast_id, 'rd.rede_isdelete' => 'N','rd.rede_locationid'=>$locationid), $store_id);

						// echo $this->db->last_query();

						// $template=$this->load->view('stock/v_stock_requistion_details',$this->data,true);

						if (defined('STOCK_DEMAND_LIST')) :

							if (STOCK_DEMAND_LIST == 'DEFAULT') {

								$template = $this->load->view('stock/v_stock_requistion_details', $this->data, true);
							} else {

								$template = $this->load->view('stock/' . REPORT_SUFFIX . '/v_stock_requistion_details', $this->data, true);
							}

						else :

							$template = $this->load->view('stock/v_stock_requistion_details', $this->data, true);

						endif;

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
		} else {

			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));

			exit;
		}
	}

	public function issue_return_details_views()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			if ($_SERVER['REQUEST_METHOD'] === 'POST') {

				$id = $this->input->post('id');

				// $invoiceno = $this->input->post('invoiceno');

				// $fyear = $this->input->post('fiscal_year');

				if ($id) {

					$this->data['return_master'] = $this->general->get_tbl_data('*', 'rema_returnmaster', array('rema_returnmasterid' => $id), 'rema_returnmasterid', 'DESC');

					// echo"<pre>";print_r($this->data['return_master']);die();

					$this->data['return_details'] = $this->new_issue_mdl->get_return_detail(array('rede_returnmasterid' => $id));

					// echo"<pre>";	print_r($this->data['return_details']);die();

					$template = $this->load->view('issue/kukl/v_issue_return_details_view', $this->data, true);

					if ($this->data['return_master'] > 0) {

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
		} else {

			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));

			exit;
		}
	}

	public function reprint_issue_return()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$id = $this->input->post('id');

			if ($id) {

				$this->data['return_master'] = $this->general->get_tbl_data('*', 'rema_returnmaster', array('rema_returnmasterid' => $id), 'rema_returnmasterid', 'DESC');

				// echo"<pre>";print_r($this->data['return_master']);die();

				$this->data['return_details'] = $this->new_issue_mdl->get_return_detail(array('rede_returnmasterid' => $id));

				// echo"<pre>";	print_r($this->data['return_details']);die();

				$this->data['store'] = $this->general->get_tbl_data('eqty_equipmenttype', 'eqty_equipmenttype', array('eqty_equipmenttypeid' => $this->session->userdata(STORE_ID)), 'eqty_equipmenttypeid', 'ASC');

				// echo "<pre>";print_r($this->data['store']);die();

				$this->data['user_signature'] = $this->general->get_signature($this->userid);

				$approve_data = $this->new_issue_mdl->get_approve_data($id);

				$approvedby = !empty($approve_data[0]->rema_approvedid) ? $approve_data[0]->rema_approvedid : '';

				$this->data['approver_signature'] = $this->general->get_signature($approvedby);

				$issue_date = !empty($issue_details[0]->sama_billdatebs) ? $issue_details[0]->sama_billdatebs : CURDATE_NP;

				$store_head_id = $this->general->get_store_post_data($issue_date, 'store_head');

				$this->data['store_head_signature'] = $this->general->get_signature($store_head_id);

				$template = $this->load->view('issue/kukl/v_new_issue_return_print_report', $this->data, true);

				//print_r($this->data['issue_master']);die;

				if ($this->data['return_master'] > 0) {

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

	public function post_api_import_asset_with_issueno($issue_no)
	{

		$issue_detail_list = $this->new_issue_mdl->get_issue_detail_for_api(array('sd.sade_salemasterid' => $issue_no));

		$issue_no = !empty($issue_detail_list[0]->sama_invoiceno) ? $issue_detail_list[0]->sama_invoiceno : '';

		$issue_date = !empty($issue_detail_list[0]->sama_billdatebs) ? $issue_detail_list[0]->sama_billdatebs : '';

		$issue_date_conv = str_replace("/", ".", $issue_date);

		$departmentid = !empty($issue_detail_list[0]->sama_depid) ? $issue_detail_list[0]->sama_depid : '';

		$postusername = !empty($issue_detail_list[0]->sama_username) ? $issue_detail_list[0]->sama_username : '';

		$locationid = !empty($issue_detail_list[0]->sama_locationid) ? $issue_detail_list[0]->sama_locationid : '';

		$master_remarks = !empty($issue_detail_list[0]->sama_remarks) ? $issue_detail_list[0]->sama_remarks : '';

		$post_master_array = array(

			"tranDate" => !empty($issue_date_conv) ? $issue_date_conv : "0", //2076.01.20

			"voucherType" => "1",

			"voucherNo" => !empty($issue_no) ? $issue_no : "0",

			"office_ID" => 40,

			"entryBY" => !empty($postusername) ? $postusername : "0",

			"narration" => !empty($master_remarks) ? $master_remarks : "0"

		);

		if (!empty($issue_detail_list)) :

			$drCrArray = array('Dr', 'Cr');

			foreach ($issue_detail_list as $isskey => $issval) {

				$itemsid = !empty($issval->sade_itemsid) ? $issval->sade_itemsid : '';

				$accode = !empty($issval->eqca_accode) ? $issval->eqca_accode : '';

				$description = !empty($issval->sade_remarks) ? $issval->sade_remarks : '';

				$qty = !empty($issval->sade_qty) ? $issval->sade_qty : '0';

				$unitrate = !empty($issval->sade_unitrate) ? $issval->sade_unitrate : '0';

				$total_amount = $qty * $unitrate;

				$issue_amount = !empty($total_amount) ? $total_amount : '0';

				$distributor = !empty($issval->dist_distributor) ? $issval->dist_distributor : '';

				$receive_by = !empty($issval->sama_receivedby) ? $issval->sama_receivedby : '';

				foreach ($drCrArray as $value) {

					$post_detail_array[] = array(

						"aC_Code" => !empty($accode) ? (int)$accode : 0, // acc code according to api

						"drCr" => $value,

						"description" => !empty($description) ? $description : "0",

						"amount" => !empty($issue_amount) ? (float)$issue_amount : 0,

						"costCenter_ID" => 1,

						"acC_NAME" => !empty($receive_by) ? $receive_by : "0" // receiver name

					);
				}
			}

		endif;

		$master_array = array();

		$dtl_arr = '';

		$dtl_arr .= '{"offTranModel": ' . json_encode($post_master_array) . ',';

		if (!empty($post_detail_array)) :

			foreach ($post_detail_array as $key => $value) {

				$dtl_arr .= '"offTranDetModel":[' . json_encode($value) . ']' . ',';
			}

		endif;

		$dtl_arr = rtrim($dtl_arr, ',');

		$dtl_arr .= '}';

		$post_json = $dtl_arr;

		// $ch = curl_init("http://xelwel.com.np");    // initialize curl handle

		// // curl_setopt($ch, CURLOPT_PROXY, "http://google.com"); //your proxy url

		// // curl_setopt($ch, CURLOPT_PROXYPORT, "80"); // your proxy port number

		// curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

		// $data = curl_exec($ch);

		// print($data);

		// print_r($post_json);

		$api_url = KUKL_API_URL . 'InventoryService/CurrentAssetsImport' . KUKL_API_KEY;

		// $api_url = base_url('api/api_kukl/get_post_data_issue');

		// $api_url = "https://xelwel.com.np/kukl/api/api_kukl/get_post_data_issue";

		// echo $api_url;

		$client = curl_init($api_url);

		// var_dump($client);

		// die();

		// curl_setopt($client, CURLOPT_SSL_VERIFYPEER, 0); //used  On dev server only!

		// curl_setopt($client, CURLOPT_SSL_VERIFYPEER, FALSE);//other way

		// curl_setopt($client, CURLOPT_PROXY, FALSE);//other way

		curl_setopt($client, CURLOPT_CUSTOMREQUEST, "POST");

		curl_setopt($client, CURLOPT_HEADER, 0);

		curl_setopt(
			$client,
			CURLOPT_HTTPHEADER,
			array(

				'Content-Type: application/json',

				'Content-Length: ' . strlen($post_json)
			)

		);

		curl_setopt($client, CURLOPT_RETURNTRANSFER, true);

		curl_setopt($client, CURLOPT_POSTFIELDS, $post_json);

		curl_setopt($client, CURLOPT_FOLLOWLOCATION, 1);

		// $httpCode = curl_getinfo($client , CURLINFO_HTTP_CODE);

		$response = curl_exec($client);

		if ($response === false) {

			$response = curl_error($client);
		} else {

			// echo $response;

			// return true;

		}

		curl_close($client);

		// print_r(curl_getinfo($client));

		// echo $httpCode;

		// print_r($response);

		// echo $response;

		return true;
	}

	/* Issue Correction /Edit */

	public function issue_correction()

	{

		// echo "asd";

		// die();

		$this->data['tab_type'] = 'issue_edit';

		$this->data['fiscal'] = $this->general->get_tbl_data('*', 'fiye_fiscalyear', false, 'fiye_fiscalyear_id', 'DESC');

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

			->build('issue/v_new_issue', $this->data);
	}

	public function issue_list_by_issue_no()
	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$invoiceno = $this->input->post('invoiceno');

			$locationid = $this->input->post('locationid');

			$fiscalyrs = $this->input->post('fiscalyrs');

			$this->data['issue_master'] = $this->new_issue_mdl->get_salemaster_date_id(array('sm.sama_locationid' => $locationid, 'sama_fyear' => $fiscalyrs, 'sama_invoiceno' => trim($invoiceno)));

			// echo $this->db->last_query();
			// die();

			$this->data['issue_details'] = array();

			// echo "<pre>";

			// print_r($this->data['issue_master']);

			// die();

			if (!empty($this->data['issue_master'])) {

				$this->data['equipmentcategory'] = $this->general->get_tbl_data('*', 'eqca_equipmentcategory', false, 'eqca_equipmentcategoryid', 'DESC');

				$this->data['depatrment'] = $this->general->get_tbl_data('*', 'dept_department', false, 'dept_depid', 'DESC');

				$this->data['fiscal_year'] = $this->general->get_tbl_data('*', 'fiye_fiscalyear', false, 'fiye_fiscalyear_id', 'DESC',2);

				$sama_masterid = $this->data['issue_master'][0]->sama_salemasterid;

				$this->data['issue_details'] = $this->new_issue_mdl->get_issue_detail_edit(array('sd.sade_salemasterid' => $sama_masterid));

				$template = '<div class="white-box pad-5 mtop_10 pdf-wrapper">';

				$template .= $this->load->view('issue/v_new_issue_form_edit', $this->data, true);

				$template .= '</div>';

				// echo $template;
				// die();

				print_r(json_encode(array('status' => 'success', 'message' => '', 'tempform' => $template)));

				exit;
			}

			// $this->data['issue_details'] = $this->new_issue_mdl->get_issue_detail_edit(array('sd.sade_salemasterid'=>$id));

		} else {

			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));

			exit;
		}
	}
	public function issue_edit_form()
	{

		$this->data['fiscal'] = $this->general->get_tbl_data('*', 'fiye_fiscalyear', false, 'fiye_fiscalyear_id', 'DESC',2);

		// $this->load->view('issue/v_issue_correction', $this->data);
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

			->build('issue/v_issue_correction', $this->data);
	}
	public function form_new_issue_edit()

	{

		$this->data['fiscal'] = $this->general->get_tbl_data('*', 'fiye_fiscalyear', false, 'fiye_fiscalyear_id', 'DESC');

		$this->load->view('issue/v_issue_correction', $this->data);
	}

	public function insert_api_data_locally($issue_no)
	{

		$issue_detail_list = $this->new_issue_mdl->get_issue_detail_for_api(array('sd.sade_salemasterid' => $issue_no));

		// echo "<pre>";

		// print_r($issue_detail_list);

		// die();

		$issue_no = !empty($issue_detail_list[0]->sama_invoiceno) ? $issue_detail_list[0]->sama_invoiceno : '';

		$issue_date = !empty($issue_detail_list[0]->sama_billdatebs) ? $issue_detail_list[0]->sama_billdatebs : '';

		$issue_date_conv = str_replace("/", ".", $issue_date);

		$departmentid = !empty($issue_detail_list[0]->sama_depid) ? $issue_detail_list[0]->sama_depid : '';

		$postusername = !empty($issue_detail_list[0]->sama_username) ? $issue_detail_list[0]->sama_username : '';

		$locationid = !empty($issue_detail_list[0]->sama_locationid) ? $issue_detail_list[0]->sama_locationid : '';

		$master_remarks = !empty($issue_detail_list[0]->sama_remarks) ? $issue_detail_list[0]->sama_remarks : '';

		$this->db->trans_begin();

		$api_master_array = array(

			'apma_transdate' => !empty($issue_date_conv) ? $issue_date_conv : "0",

			'apma_vouchertype' => "1",

			'apma_voucherno' => !empty($issue_no) ? $issue_no : "0",

			'apma_officeid' => 40,

			'apma_entryby' => !empty($postusername) ? $postusername : "0",

			'apma_narration' => !empty($master_remarks) ? $master_remarks : "0",

			'apma_issync' => 'N',

			'apma_actionfrom' => 'Issue'

		);

		// echo "<pre>";

		// print_r($api_master_array);

		// die();

		if (!empty($api_master_array)) {

			$this->db->insert('apma_apimaster', $api_master_array);

			$insertid = $this->db->insert_id();
		}

		if (!empty($insertid)) {

			if (!empty($issue_detail_list)) :

				$drCrArray = array('Dr', 'Cr');

				foreach ($issue_detail_list as $isskey => $issval) {

					$itemsid = !empty($issval->sade_itemsid) ? $issval->sade_itemsid : '';

					$accode = !empty($issval->eqca_accode) ? $issval->eqca_accode : '';

					$description = !empty($issval->sade_remarks) ? $issval->sade_remarks : '';

					$qty = !empty($issval->sade_qty) ? $issval->sade_qty : '0';

					$unitrate = !empty($issval->sade_unitrate) ? $issval->sade_unitrate : '0';

					$total_amount = $qty * $unitrate;

					$issue_amount = !empty($total_amount) ? $total_amount : '0';

					$distributor = !empty($issval->dist_distributor) ? $issval->dist_distributor : '';

					$receive_by = !empty($issval->sama_receivedby) ? $issval->sama_receivedby : '';

					foreach ($drCrArray as $value) {

						$api_detail_array[] = array(

							"apde_apmaid" => $insertid,

							"apde_accode" => !empty($accode) ? (int)$accode : 0, // acc code according to api

							"apde_drcr" => $value,

							"apde_description" => !empty($description) ? $description : "0",

							"apde_amount" => !empty($issue_amount) ? (float)$issue_amount : 0,

							"apde_costcenterid" => 1,

							"apde_acname" => !empty($receive_by) ? $receive_by : "0" // receiver name

						);
					}
				}

			endif;

			if (!empty($api_detail_array)) {

				$this->db->insert_batch('apde_apidetail', $api_detail_array);
			}
		}

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {

			$this->db->trans_rollback();

			return false;
		} else {

			$this->db->trans_commit();

			return true;
		}
	}
}

/* End of file welcome.php */

/* Location: ./application/controllers/welcome.php */