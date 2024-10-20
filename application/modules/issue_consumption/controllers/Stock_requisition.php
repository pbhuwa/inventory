<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Stock_requisition extends CI_Controller

{

	function __construct()

	{
		parent::__construct();

		$this->load->Model('stock_requisition_mdl');

		$this->load->Model('new_issue_mdl');

		$this->locationid = $this->session->userdata(LOCATION_ID);

		$this->location_ismain = $this->session->userdata(ISMAIN_LOCATION);

		$this->storeid = $this->session->userdata(STORE_ID);

		$this->userid = $this->session->userdata(USER_ID);

		$this->username = $this->session->userdata(USER_NAME);

		$this->curtime = $this->general->get_currenttime();

		$this->mac = $this->general->get_Mac_Address();

		$this->ip = $this->general->get_real_ipaddr();

		$this->orgid = $this->session->userdata(ORG_ID);

		$this->usergroup = $this->session->userdata(USER_GROUPCODE);

		$this->userdept = $this->session->userdata(USER_DEPT);

		$this->mattypeid = $this->session->userdata(USER_MAT_TYPEID);

		$this->show_location_group = array('SA', 'SK', 'SI');

		$this->adjacencydepList = '';
	}

	public function index($type = 'entry')

	{

		// echo "<pre>";
		// print_r($this->session->userdata());
		// echo "</pre>";
		// die;

		$id = $this->input->post('id');

		$save_type = !empty($this->input->post('otherdata')) ? $this->input->post('otherdata') : ''; //resubmit
		$this->data['tab_type'] = $type;
		$this->data['save_type'] = $save_type;

		if (!empty($this->mattypeid)) {
			$srchmat = array('maty_materialtypeid' => $this->mattypeid, 'maty_isactive' => 'Y');
		} else {
			$srchmat = array('maty_isactive' => 'Y');
		}

		$this->data['sub_department'] = array();

		$this->data['material_type'] = $this->general->get_tbl_data('maty_materialtypeid,maty_material', 'maty_materialtype', $srchmat, 'maty_materialtypeid', 'ASC');
		$this->data['fiscal_year'] = $this->general->get_tbl_data('*', 'fiye_fiscalyear', false, 'fiye_fiscalyear_id', 'DESC', 2);

		// echo $this->usergroup;
		// die();
		$this->data['designation'] = array();
		$this->data['supervisor_list'] = array();
		if (ORGANIZATION_NAME == 'KUKL') :
			$this->data['department'] = $this->stock_requisition_mdl->get_dept_by_user();
			// echo $this->db->last_query();
			// echo $this->data['department'];
			// die();
			$get_approval_designation = $this->general->get_tbl_data('usma_appdesiid', 'usma_usermain', array('usma_userid' => $this->userid));
			$approval_designation = $get_approval_designation[0]->usma_appdesiid;
			if ($approval_designation) {
				$approval_designation_array = explode(',', $approval_designation);
			} else {
				$approval_designation_array = array();
			}
			$this->data['designation'] = $this->stock_requisition_mdl->get_approval_designation_list($approval_designation_array);
			$this->data['supervisor_list'] = $this->stock_requisition_mdl->get_user_by_group_code();

		// echo $this->db->last_query();
		// die();
		elseif (ORGANIZATION_NAME == 'NPHL' && $this->usergroup == 'DM') :
			$this->data['department'] = $this->stock_requisition_mdl->get_dept_by_user();

		elseif (ORGANIZATION_NAME == 'ARMY') :
			$srcharr = array('dept_locationid' => $this->locationid);
			$this->data['department'] = $this->general->get_tbl_data('*', 'dept_department', $srcharr, 'dept_depname', 'ASC');

		else :

			$this->data['department'] = $this->general->get_tbl_data('*', 'dept_department', array('dept_locationid' => $this->locationid), 'dept_depname', 'ASC');

		endif;

		// echo ORGANIZATION_NAME;
		// // die();

		if ($id) {

			if ($save_type == 'resubmit') {
				$this->data['req_data'] = $this->stock_requisition_mdl->get_requisition_data(array('rede_isdelete' => 'N', 'rede_reqmasterid' => $id, 'rede_itemavailable' => '1'));
			} else {

				$this->data['req_data'] = $this->stock_requisition_mdl->get_requisition_data(array('rede_isdelete' => 'N', 'rede_reqmasterid' => $id));
			}

			// echo "<pre>";
			// print_r($this->data['req_data']);
			// die();
			if (!empty($this->data['req_data'])) {
				if (ORGANIZATION_NAME == 'KU' || ORGANIZATION_NAME=='PU') {
					$schoolid = !empty($this->data['req_data'][0]->rema_school) ? $this->data['req_data'][0]->rema_school : $this->locationid;
					// echo $this->data['req_data'][0]->rema_school;
					// die();

					$reqdepartment = !empty($this->data['req_data'][0]->rema_reqfromdepid) ? $this->data['req_data'][0]->rema_reqfromdepid : '';

					$this->data['department'] = $this->general->get_tbl_data('*', 'dept_department', array('dept_locationid' => $schoolid), 'dept_depname', 'ASC');

					$check_parentid = $this->general->get_tbl_data('*', 'dept_department', array('dept_depid' => $reqdepartment), 'dept_depname', 'ASC');

					// echo "<pre>";
					// print_r($check_parentid);
					// die();

					if (!empty($check_parentid)) {

						$dep_parentid = !empty($check_parentid[0]->dept_parentdepid) ? $check_parentid[0]->dept_parentdepid : '0';

						if ($dep_parentid != 0) {

							$this->data['parent_depid'] = $dep_parentid;

							$this->data['sub_department'] = $this->general->get_tbl_data('*', 'dept_department', array('dept_parentdepid' => $dep_parentid), 'dept_depname', 'ASC');
						}
					}
				}
			}
		} else {

			$this->data['req_data'] = array();
		}

		// echo "<pre>";
		// print_r($this->data['department']);
		// die;

		// echo $this->db->last_query();

		// die();

		// $this->data['editurl']=base_url().'issue_consumption/stock_requisition/edit_stock_requisition';

		// $this->data['deleteurl']=base_url().'issue_consumption/stock_requisition/delete_requisition';

		// $this->data['listurl']=base_url().'issue_consumption/stock_requisition/list_requisition';

		$this->data['store_type'] = $this->general->get_tbl_data('*', 'eqty_equipmenttype', false, 'eqty_equipmenttype', 'ASC');

		// echo "<pre>";

		//  print_r($this->data['store_type']);

		// die();

		// echo $this->db->last_query();

		// die();

		if (ORGANIZATION_NAME == 'KU' || ORGANIZATION_NAME == 'ARMY' || ORGANIZATION_NAME=='PU') {

			$this->data['requisition_no'] = $this->get_req_no_by_mat_type('Y');
		} else {

			$this->data['requisition_no'] = $this->generate_stock_reqno();
		}

		// echo $this->data['requisition_no'];
		// die();

		// echo $this->db->last_query();

		// echo $this->data['requisition_no'];

		// die();

		// $this->data['designation'] = $this->general->get_tbl_data('*','desi_designation');

		// echo STOCK_REQ_FORM_TYPE;
		// die();

		if ($type == 'reload') {

			$this->data['load_select2'] = 'Y';

			if (defined('STOCK_REQ_FORM_TYPE')) :

				if (STOCK_REQ_FORM_TYPE == 'DEFAULT') {

					$this->load->view('stock/v_stock_requisition', $this->data);
				} else {

					$this->load->view('stock/' . REPORT_SUFFIX . '/v_stockrequisition_form', $this->data);
				}

			else :

				$this->load->view('stock/v_stock_requisition', $this->data);

			endif;
		} else {

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

			// $this->load->view('stock/v_stock_requisition', $this->data);

			$this->template

				->set_layout('general')

				->enable_parser(FALSE)

				->title($this->page_title)

				->build('stock/v_stock_requisition', $this->data);
		}
	}

	public function testemail()

	{
		echo anchor('https://xelwel.com.np/biomedical', 'Click To visit Homepage', 'class="link-class"');
		die;

		$this->load->library('email');

		$subject = "Stock Requisition Details";

		$emailbody = " this is test email test";

		$from = 'info@xelwel.com.np';

		$to = 'kunwarsujan143@gmail.com';

		$this->email->from($to);

		$this->email->to($to);

		$this->email->subject($subject);

		//echo"<pre>"; print_r($emailbody); die;

		$this->email->message('Email:' . $from . ' ' . $emailbody);

		$this->email->send();

		echo $this->email->print_debugger();
	}

	public function save_requisition($print = false)

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			try {

				if ($this->input->post('id')) {

					if (MODULES_UPDATE == 'N') {

						$this->general->permission_denial_message();

						exit;
					}
					$action_log_message = "edit";
				} else {

					if (MODULES_INSERT == 'N') {

						$this->general->permission_denial_message();

						exit;
					}

					$action_log_message = "";
				}

				$this->form_validation->set_rules($this->stock_requisition_mdl->validate_settings_stock_requisition);

				if ($this->form_validation->run() == TRUE) {
					// echo "<pre>"; print_r($this->input->post());die;

					$trans = $this->stock_requisition_mdl->stock_requisition_save();

					if ($trans) {

						//error_reporting(0);

						$report_data = $this->data['report_data'] = $this->input->post();

						$rema_reqfromdepid = !empty($report_data['rema_reqfromdepid']) ? $report_data['rema_reqfromdepid'] : '';

						$rema_reqtodepid = !empty($report_data['rema_reqtodepid']) ? $report_data['rema_reqtodepid'] : '';

						$dep = $this->input->post('rema_isdep');

						if ($dep == "Y") {

							$this->data['from'] = $this->general->get_tbl_data('*', 'dept_department', array('dept_depid' => $rema_reqfromdepid), false, 'DESC');
						}

						if ($dep == "N") {

							$this->data['from'] = $this->general->get_tbl_data('*', 'eqty_equipmenttype', array('eqty_equipmenttypeid' => $rema_reqfromdepid), false, 'DESC');
						}

						$this->data['tostore'] = $this->general->get_tbl_data('*', 'eqty_equipmenttype', array('eqty_equipmenttypeid' => $rema_reqtodepid), false, 'DESC');

						//print_r($this->data['tostore']);die;

						if (!empty($itemid)) :

							foreach ($itemid as $key => $it) :

								$itemid = !empty($report_data['rede_itemsid'][$key]) ? $report_data['rede_itemsid'][$key] : '';

								$unitid = !empty($report_data['puit_unitid'][$key]) ? $report_data['puit_unitid'][$key] : '';

							endforeach;

						endif;

						if ($print == "print") {

							$stock_requisition_details = $this->data['stock_requisition_details'] = $this->general->get_tbl_data('*', 'rema_reqmaster', array('rema_reqmasterid' => $trans), 'rema_reqmasterid', 'DESC');

							$this->data['stock_requisition'] = $this->stock_requisition_mdl->get_requisition_data(array('rd.rede_reqmasterid' => $trans));

							// echo "<pre>";
							// print_r($this->data['stock_requisition']);
							// die();

							$this->data['user_signature'] = $this->general->get_signature($this->userid);

							$approvedby = $stock_requisition_details[0]->rema_approvedid;

							$this->data['approver_signature'] = $this->general->get_signature($approvedby);

							$req_date = !empty($stock_requisition_details[0]->rema_reqdatebs) ? $stock_requisition_details[0]->rema_reqdatebs : CURDATE_NP;

							$store_head_id = $this->general->get_store_post_data($req_date, 'store_head');

							$this->data['store_head_signature'] = $this->general->get_signature($store_head_id);

							$this->data['requisition_no'] = $this->generate_stock_reqno();

							if (STOCK_REQ_REPORT_TYPE == 'DEFAULT') {

								$template = $this->load->view('stock/v_print_report_issue', $this->data, true);
							} else {

								$file_name = base_url('stock/v_print_report_issue' . '_' . REPORT_SUFFIX . '.php');

								if (file_exists($file_name)) //not working

								{
									$template = $this->load->view('stock/v_print_report_issue' . '_' . REPORT_SUFFIX, $this->data, true);
								} else {

									$template = $this->load->view('stock/' . REPORT_SUFFIX . '/v_print_report_issue', $this->data, true);
								}
							}

							// send message to supervisor on demand form save

							$rema_reqno = !empty($stock_requisition_details[0]->rema_reqno) ? $stock_requisition_details[0]->rema_reqno : '';

							// $mess_user = array('DS');

							if ($this->usergroup == 'DM') {

								// if demander, send message to Supervisor group

								// $mess_user = array('DS');	

								// $message = "New Demand Request No. $rema_reqno generated.";

								// $mess_title = $mess_message = $message;

								// $mess_path = 'issue_consumption/stock_requisition/requisition_list';

								// $this->general->send_message_to_user($mess_user, $mess_title, $mess_message, $mess_path, 'G');

								$msg_params = array(

									// 'DEMAND_NO' => $reqno
									'DEMAND_NO' => $rema_reqno
								);

								$this->general->send_message_params('save_requisition', $msg_params);
							} else {

								// if not demander, send message to approval designation

								$approval_designation_id = $stock_requisition_details[0]->rema_reqtodesignation;

								if ($approval_designation_id) :

									$approval_designation_id_array = explode(',', $approval_designation_id);

								else :

									$approval_designation_id_array = array();

								endif;

								if ($approval_designation_id_array) {

									$approval_userlist = $this->stock_requisition_mdl->get_userlist_by_approval_designation_id($approval_designation_id_array);
								} else {

									$approval_userlist = array();
								}

								$mess_user_array = $approval_userlist;

								// $message = "New Demand Request No. $rema_reqno generated.";

								// $mess_title = $mess_message = $message;

								// $mess_path = 'issue_consumption/stock_requisition/requisition_list';

								// $this->general->send_message_to_user($mess_user, $mess_title, $mess_message, $mess_path, 'G');

								foreach ($mess_user_array as $mess) {

									$mess_user = $mess->usma_userid;

									// $this->general->send_message_to_user($mess_user, $mess_title, $mess_message, $mess_path, 'U');

									$msg_params = array(

										// 'DEMAND_NO' => $reqno,
										'DEMAND_NO' => $rema_reqno

									);

									$user_params = array(

										'TO_USERID' => $mess_user

									);

									$this->general->send_message_params('save_requisition_touserid', $msg_params, $user_params);
								}
							}

							$this->general->saveActionLog('rema_reqmaster', $trans, $this->userid, '0', 'rema_approved');

							print_r(json_encode(array('status' => 'success', 'message' => 'Record Save Successfully.', 'print_report' => $template)));

							exit;
						}

						if (ORGANIZATION_NAME == 'KUKL') {

							$stock_requisition_details = $this->data['stock_requisition_details'] = $this->general->get_tbl_data('*', 'rema_reqmaster', array('rema_reqmasterid' => $trans), 'rema_reqmasterid', 'DESC');

							$rema_reqno = !empty($stock_requisition_details[0]->rema_reqno) ? $stock_requisition_details[0]->rema_reqno : '';

							if ($this->usergroup == 'DM') {

								// if demander, send message to Supervisor group
								if ($action_log_message != 'edit') {

									$msg_params = array(

										'DEMAND_NO' => $rema_reqno

									);

									$this->general->send_message_params('save_requisition', $msg_params);
								}
							} else {

								// if not demander, send message to approval designation

								$approval_designation_id = !empty($stock_requisition_details[0]->rema_reqtodesignation) ? $stock_requisition_details[0]->rema_reqtodesignation : 0;

								if ($approval_designation_id) :

									$approval_designation_id_array = explode(',', $approval_designation_id);

								else :

									$approval_designation_id_array = array();

								endif;

								if ($approval_designation_id_array) {

									$approval_userlist = $this->stock_requisition_mdl->get_userlist_by_approval_designation_id($approval_designation_id_array);
								} else {

									$approval_userlist = array();
								}

								$mess_user_array = $approval_userlist;

								if (!empty($mess_user_array)) {

									foreach ($mess_user_array as $mess) {

										$mess_user = $mess->usma_userid;

										$msg_params = array(

											'DEMAND_NO' => $rema_reqno,

											'TO_USERID' => $mess_user

										);
										// $user_params = array(

										// 	'TO_USERID' => $mess_user

										// );

										$this->general->send_message_params('save_requisition_touserid', $msg_params);
									}
								}
							}

							$this->general->saveActionLog('rema_reqmaster', $trans, $this->userid, '0', 'rema_approved', $action_log_message);
						}

						print_r(json_encode(array('status' => 'success', 'message' => 'Record Save Successfully.')));

						exit;
					} else {

						print_r(json_encode(array('status' => 'error', 'message' => 'Unsuccessful Operation.')));

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

	public function get_department_by_schoolid()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$schoolid = $this->input->post('schoolid');

			$dept_listtemp = '<option value="">--select--</option>';
			if (ORGANIZATION_NAME == 'KU' || ORGANIZATION_NAME == 'ARMY' || ORGANIZATION_NAME=='PU') {
				$schoolid = $schoolid;
			} else {
				$schoolid = 0;
			}
			if(REPORT_SUFFIX=='star'){
				$schoolid = 0;
			}
			// print_r(ORGANIZATION_NAME);
			// die();
			$dept_list = $this->dept_adjacency(0, 0, $schoolid, 0);

			// echo $dept_list;

			// die();
			if (!empty($dept_list)) {

				$dept_listtemp .= $dept_list; 

				print_r(json_encode(array('status' => 'success', 'dept_list' => $dept_listtemp, 'message' => 'Data Selection')));

				exit;
			} else {

				print_r(json_encode(array('status' => 'error', 'dept_list' => array(), 'message' => 'Record Empty')));
			}
		} else {

			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));

			exit;
		}
	}

	public function  dept_adjacency($id, $parent, $parent_id, $level, $isactive = false)
	{

		$this->db->select('*');

		$this->db->from('dept_department');

		$this->db->where('dept_locationid', $parent_id);

		$this->db->order_by('dept_depname', 'ASC');

		$query = $this->db->get();

		$dep_list = $query->result();

		// echo $this->db->last_query();

		// die();

		// $this->adjacencyList.="";

		if (!empty($dep_list)) :

			foreach ($dep_list as $value) :

				$this->adjacencydepList .= "<option value=" . $value->dept_depid;

				if ($parent == $value->dept_depid)

					$this->adjacencydepList .= " selected";

				$this->adjacencydepList .= ">" . str_repeat('  &minus; ', $level) . stripslashes($value->dept_depname) . "</option>";

				if ($isactive == 'Y') {

					$this->dept_adjacency($id, $parent, $value->dept_depid,  $level + 1);
				}

			endforeach;

			return $this->adjacencydepList;

		endif;

		return false;
	}

	public function form_stock_requisition($type = 'entry', $id = false)
	{

		$id = $this->input->post('id');

		$this->data['tab_type'] = $type;

		$save_type = !empty($this->input->post('otherdata')) ? $this->input->post('otherdata') : ''; //resubmit

		$this->data['save_type'] = $save_type;

		$this->data['is_approval_modal'] = 'N';

		$this->data['req_data'] = $this->stock_requisition_mdl->get_requisition_data(array('rede_isdelete' => 'N', 'rema_reqmasterid' => $id));

		$this->data['supervisor_list'] = $this->stock_requisition_mdl->get_user_by_group_code();

		// echo $this->db->last_query();

		// die();

		// $this->data['editurl']=base_url().'issue_consumption/stock_requisition/edit_stock_requisition';

		// $this->data['deleteurl']=base_url().'issue_consumption/stock_requisition/delete_requisition';

		// $this->data['listurl']=base_url().'issue_consumption/stock_requisition/list_requisition';

		$this->data['equipmentcategory'] = $this->general->get_tbl_data('*', 'eqca_equipmentcategory', false, 'eqca_equipmentcategoryid', 'DESC');

		$this->data['store_type'] = $this->general->get_tbl_data('*', 'eqty_equipmenttype', false, 'eqty_equipmenttype', 'ASC');

		if (ORGANIZATION_NAME == 'KUKL') :

			$this->data['department'] = $this->stock_requisition_mdl->get_dept_by_user();

		elseif (ORGANIZATION_NAME == 'NPHL' && $this->usergroup == 'DM') :
			$this->data['department'] = $this->stock_requisition_mdl->get_dept_by_user();

		else :

			$this->data['department'] = $this->general->get_tbl_data('*', 'dept_department', false, 'dept_depid', 'DESC');

		endif;

		$this->data['item_all'] = $this->general->get_tbl_data('*', 'itli_itemslist', false, 'itli_itemlistid', 'DESC');

		$this->data['requisition_no'] = $this->generate_stock_reqno();

		// $this->load->view('stock/v_stockrequisition_form',$this->data);

		$get_approval_designation = $this->general->get_tbl_data('usma_appdesiid', 'usma_usermain', array('usma_userid' => $this->userid));

		$approval_designation = $get_approval_designation[0]->usma_appdesiid;

		if ($approval_designation) {

			$approval_designation_array = explode(',', $approval_designation);
		} else {

			$approval_designation_array = array();
		}

		// $this->data['designation'] = $this->general->get_tbl_data('*','desi_designation');

		$this->data['designation'] = $this->stock_requisition_mdl->get_approval_designation_list($approval_designation_array);

		$this->data['load_select2'] = 'Y';

		if (defined('STOCK_REQ_FORM_TYPE')) :

			if (STOCK_REQ_FORM_TYPE == 'DEFAULT') {

				$this->load->view('stock/v_stock_requisition', $this->data);
			} else {

				$this->load->view('stock/' . REPORT_SUFFIX . '/v_stockrequisition_form', $this->data);
			}

		else :

			$this->load->view('issue/v_stock_requisition', $this->data);

		endif;
	}

	public function requisition_list()

	{

		// echo "test";

		// die();

		// echo "<pre>";print_r('hyy');die();   

		$this->data['tab_type'] = 'list';

		$frmDate = CURMONTH_DAY1;

		$toDate = CURDATE_NP;

		$cur_fiscalyear = CUR_FISCALYEAR;

		$this->data['fiscalyear'] = $this->general->get_tbl_data('*', 'fiye_fiscalyear', false, 'fiye_fiscalyear_id', 'DESC');

		$this->data['department'] = $this->general->get_tbl_data('*', 'dept_department', array('dept_locationid' => $this->locationid), 'dept_depid', 'DESC');

		// $this->data['status_count'] = $this->stock_requisition_mdl->getStatusCount(array('rema_reqdatebs >='=>$frmDate, 'rema_reqdatebs <='=>$toDate));

		if (ORGANIZATION_NAME == 'KU' || ORGANIZATION_NAME=='PU') {

			$this->data['dept_list'] = $this->dept_adjacency(0, 0, $this->locationid, 0, 'Y');
		}

		// echo $dept_list;

		// die();

		if (!empty($this->mattypeid)) {

			$srchmat = array('maty_materialtypeid' => $this->mattypeid, 'maty_isactive' => 'Y');
		} else {

			$srchmat = array('maty_isactive' => 'Y');
		}

		$this->data['material_type'] = $this->general->get_tbl_data('maty_materialtypeid,maty_material', 'maty_materialtype', $srchmat, 'maty_materialtypeid', 'ASC');

		if (ORGANIZATION_NAME == 'KUKL') {

			$cond = '';

			if ($frmDate) {

				$cond .= " WHERE rema_reqdatebs >='" . $frmDate . "'";
			}

			if ($toDate) {

				$cond .= " AND rema_reqdatebs <='" . $toDate . "'";
			} else {

				$cond .= " AND rema_reqdatebs <='" . $frmDate . "'";
			}

			$this->data['status_count'] = $this->stock_requisition_mdl->getColorStatusCount($cond);

			// echo "<pre>";

			// print_r($this->data['status_count']);

			// die();

		} else {

			$this->data['status_count'] = $this->stock_requisition_mdl->getStatusCount(array('rema_reqdatebs >=' => $frmDate, 'rema_reqdatebs <=' => $toDate));
		}

		// echo $this->db->last_query();

		// echo '<pre>';

		// print_r($this->data['status_count']);

		// die();

		$this->data['total_count'] = $this->stock_requisition_mdl->getRemCount(array('rema_reqdatebs >=' => $frmDate, 'rema_reqdatebs <=' => $toDate, 'rema_locationid' => $this->locationid));

		// echo "<pre>";

		// print_r($this->data['total_count']);

		// die();

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

			->build('stock/v_stock_requisition', $this->data);
	}

	public function stock_requisition_details()

	{

		$this->data['tab_type'] = 'details';

		$frmDate = CURDATE_NP;

		$toDate = CURDATE_NP;

		$cur_fiscalyear = CUR_FISCALYEAR;

		$this->data['fiscalyear'] = $this->general->get_tbl_data('*', 'fiye_fiscalyear', false, 'fiye_fiscalyear_id', 'DESC');

		$this->data['status_count'] = $this->stock_requisition_mdl->getStatusCount(array('rema_reqdatebs >=' => $frmDate, 'rema_reqdatebs <=' => $toDate));

		if (!empty($this->mattypeid)) {

			$srchmat = array('maty_materialtypeid' => $this->mattypeid, 'maty_isactive' => 'Y');
		} else {

			$srchmat = array('maty_isactive' => 'Y');
		}

		$this->data['material_type'] = $this->general->get_tbl_data('maty_materialtypeid,maty_material', 'maty_materialtype', $srchmat, 'maty_materialtypeid', 'ASC');

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

			->build('stock/v_stock_requisition', $this->data);
	}

	public function requisition_details_lists()

	{
		if (MODULES_VIEW == 'N') {

			$array = array();

			// $this->general->permission_denial_message();

			echo json_encode(array("recordsFiltered" => 0, "recordsTotal" => 0, "data" => $array));

			exit;
		}

		$useraccess = $this->session->userdata(USER_ACCESS_TYPE);

		$i = 0;

		$data = $this->stock_requisition_mdl->get_requisition_details_list();

		// echo $this->db->last_query();die();

		//echo"<pre>";print_r($data);die;

		$array = array();

		$filtereddata = ($data["totalfilteredrecs"] > 0 ? $data["totalfilteredrecs"] : $data["totalrecs"]);

		$totalrecs = $data["totalrecs"];

		unset($data["totalfilteredrecs"]);

		unset($data["totalrecs"]);

		foreach ($data as $row) {

			// $array[$i]["rede_reqdetailid"] = '<a href="javascript:void(0)" class="patlist" data-patientid='.$row->rede_reqdetailid.'>'.$row->rede_reqdetailid.'</a>';

			$array[$i]["rema_reqno"] = $row->rema_reqno;

			$array[$i]["postdatead"] = $row->rema_reqdatead;

			$array[$i]["postdatebs"] = $row->rema_reqdatebs;

			$array[$i]["itli_itemcode"] = $row->itli_itemcode;

			$array[$i]["itli_itemname"] = $row->itli_itemname;

			$array[$i]["itli_itemnamenp"] = $row->itli_itemnamenp;

			$array[$i]["rema_fyear"] = $row->rema_fyear;

			$array[$i]["rede_qty"] = $row->rede_qty;

			$array[$i]["rede_remqty"] = $row->rede_remqty;

			$array[$i]["issueqty"] = $row->rede_qty - $row->rede_remqty;

			$array[$i]["rede_remarks"] = $row->rede_remarks;

			//$array[$i]["itli_itemname"] = $row->itli_itemname;

			$i++;
		}

		//echo"<pre>";print_r($data);die;

		$get = $_GET;

		echo json_encode(array("recordsFiltered" => $filtereddata, "recordsTotal" => $totalrecs, "data" => $array));
	}

	public function view_requisition()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$mastid_id = $this->input->post('id');

			$this->data['requistion_data'] = $this->stock_requisition_mdl->get_requisition_master_data(array('rm.rema_reqmasterid' => $mastid_id));

			if (ORGANIZATION_NAME == 'ARMY') {

				$where_cond = [
					'aclo_tablename' => 'rema_reqmaster',
					'aclo_masterid' => $mastid_id,
					'aclo_fieldname' => 'rema_operation',
					'aclo_locationid' => $this->locationid,
					'aclo_orgid' => $this->orgid
				];

				$this->data['operation_data'] = $this->db->from('aclo_actionlog as al')->join('usma_usermain as u', 'al.aclo_comment = u.usma_userid', 'LEFT')->select('aclo_masterid, aclo_userid, aclo_comment, aclo_status, usma_username')->where($where_cond)->get()->result();
			}

			// echo $this->db->last_query();echo $id;die();

			$this->data['mat_type'] = $this->general->get_tbl_data('*', 'maty_materialtype', array('maty_isactive' => 'Y'));

			$this->data['rede_reqmasterid'] = $mastid_id;

			$this->data['req_detail_list'] = $this->stock_requisition_mdl->get_requisition_details_data(array('rd.rede_reqmasterid' => $mastid_id, 'rd.rede_isdelete' => 'N'));

			// echo $this->db->last_query();
			// die();

			// echo "<pre>";print_r($this->data['req_detail_list']);die();

			$this->data['check_it_dep'] = $this->stock_requisition_mdl->check_it_dep(array('rd.rede_reqmasterid' => $mastid_id, 'rd.rede_isdelete' => 'N'));

			$this->data['handover_status'] = $this->general->get_tbl_data('harm_currentstatus', 'harm_handoverreqmaster', array('harm_reqmasterid' => $mastid_id), 'harm_handovermasterid', 'DESC');

			// echo "Test";

			// print_r($this->data['mat_type']);

			// die();

			$this->data['items_count'] = $this->stock_requisition_mdl->get_items_count(array('rede_reqmasterid' => $mastid_id));

			$tempform = '';

			if (defined('STOCK_DEMAND_LIST')) :

				if (STOCK_DEMAND_LIST == 'DEFAULT') {

					$tempform = $this->load->view('stock/v_stock_requistion_view', $this->data, true);
				} else {
					
					if(defined('APPROVED_STEP') && APPROVED_STEP=='Y' ){
							$tempform = $this->load->view('stock/' . REPORT_SUFFIX . '/v_stock_requistion_view_multi_verification', $this->data, true);
					}else{
							$tempform = $this->load->view('stock/' . REPORT_SUFFIX . '/v_stock_requistion_view', $this->data, true);
					}

				}

			else :

				$tempform = $this->load->view('stock/v_stock_requistion_view', $this->data, true);

			endif;

			// print_r($tempform);die;

			if (!empty($tempform)) {

				print_r(json_encode(array('status' => 'success', 'message' => 'You Can view', 'tempform' => $tempform)));

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

	public function get_headwise_account()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			
			$budgetid = $this->input->post('budgetid');
			$kvwsmb_id=KVWSMB_ID;

			if($budgetid==$kvwsmb_id){
				$cost_central_id=9;
				$url=KUKL_API_URL.'InventoryService/FetchChartOfAccByCostCenter/@ccessKuK!nv!ntegr@t!0n20!9?costcenter_id='.$cost_central_id;
				$json = file_get_contents($url);
				$accounts = json_decode($json);
				print_r(json_encode(array('status' => 'success', 'accounts' => $accounts,'cost_central_id'=>9)));
				exit;
			}else{
				
				$this->db->select('acty_id, acty_accode, acty_acname, acty_code, buhe_code');
				$this->db->from('acty_accounttype as ac');
				$this->db->join('buhe_bugethead as bh', 'bh.buhe_bugetheadid = ac.acty_budgetid', 'LEFT');
				$this->db->where('acty_budgetid IS NOT NULL',NULL, false);
				if ($budgetid != $kvwsmb_id) {
					$this->db->where('acty_budgetid', $budgetid);
				}
				$this->db->order_by('acty_acname', 'ASC');
				$accounts = $this->db->get()->result();

				print_r(json_encode(array('status' => 'success', 'accounts' => $accounts)));
				exit;
			}

		} else {
			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		}
	}

	public function save_app_qty()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$reqdetaiidval = $this->input->post('reqdetaiidval');
			$apqty = $this->input->post('apqty');
			if ($apqty && $reqdetaiidval) {
				$this->db->update('xw_rede_reqdetail', array('rede_remqty' => $apqty, 'rede_approvedqty' => $apqty), array('rede_reqdetailid' => $reqdetaiidval));
				$rw = $this->db->affected_rows();
				if ($rw) {
					print_r(json_encode(array('status' => 'success', 'message' => 'Approved Qty Success')));
					exit;
				}
				print_r(json_encode(array('status' => 'error', 'message' => 'Approved Qty Failed!!')));
				exit;
			}
		} else {
			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		}
	}

	public function verification_requisition($id = false, $reqno = false)

	{

		$masterid = $this->general->get_tbl_data('rema_reqmasterid', 'rema_reqmaster', array('rema_reqno' => $reqno), false, 'DESC');

		if ($id == "2") {

			$status = "2";
		}

		if ($id == "1") {

			$status = "1";
		}

		//print_r($status);die;

		$trans  = $this->stock_requisition_mdl->stock_requisition_change_status_email($status, $masterid[0]->rema_reqmasterid);

		if ($trans) {

			echo "Change  Status Successfully";

			echo anchor('https://xelwel.com.np/biomedical', 'Click To visit Homepage', 'class="link-class"');

			//print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully')));

			exit;
		} else {

			print_r(json_encode(array('status' => 'error', 'message' => 'Record Save Successfully')));

			exit;
		}
	}

	public function change_status()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			if (MODULES_APPROVE == 'N') {

				print_r(json_encode(array('status' => 'error', 'message' => $this->general->permission_denial_message())));

				exit;
			}

			$reqno = $this->input->post('reqno');

			$masterid = $this->input->post('masterid');

			$approve_post_status = $this->input->post('approve_status');

			if ($approve_post_status == '') {

				print_r(json_encode(array('status' => 'error', 'message' => 'You Need to Select Atleast One Option !!! ')));

				exit;
			}

			$status = '';

			if ($approve_post_status == "2") {

				$status = "2";
			}

			if ($approve_post_status == "1") {

				$status = "1";
			}

			if ($approve_post_status == "3") {

				$status = "3";
			}

			if ($approve_post_status == "4") {

				$status = "4";
			}

			//print_r($status);die;

			$trans  = $this->stock_requisition_mdl->stock_requisition_change_status($status);

			if ($trans) {

				if ($status == '4') :

					// send message to storekeeper on verified

					$msg_params = array(

						'DEMAND_NO' => $reqno

					);

					$this->general->send_message_params('change_status', $msg_params);

					// send notification message to IT officer

					$check_it_item_count = $this->stock_requisition_mdl->get_it_items_count(array('eqca_isitdep' => 'Y', 'rede_reqmasterid' => $trans));

					$it_item_count = !empty($check_it_item_count[0]->it_item_count) ? $check_it_item_count[0]->it_item_count : 0;

					if ($it_item_count > 0) :

						$msg_params = array(

							'DEMAND_NO' => $reqno

						);

						$this->general->send_message_params('change_status_itverify', $msg_params);

					endif;

				elseif ($status == '3') :

					// send message to demander about cancel

					$get_post_by = $this->general->get_tbl_data('rema_postby', 'rema_reqmaster', array('rema_reqmasterid' => $masterid));

					$mess_user = $get_post_by[0]->rema_postby;

					$message = "Demand No. $reqno is cancelled.";

					$mess_title = $mess_message = $message;

					$mess_path = 'issue_consumption/stock_requisition/requisition_list';

					$this->general->send_message_to_user($mess_user, $mess_title, $mess_message, $mess_path, 'S');

				endif;

				print_r(json_encode(array('status' => 'success', 'message' => 'Record Save Successfully')));

				exit;
			} else {

				print_r(json_encode(array('status' => 'error', 'message' => 'Record Save Successfully')));

				exit;
			}
		} else {

			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));

			exit;
		}
	}

	public function requisition_lists()

	{
		if (MODULES_VIEW == 'N') {

			$array = array();

			// $this->general->permission_denial_message();

			echo json_encode(array("recordsFiltered" => 0, "recordsTotal" => 0, "data" => $array));

			exit;
		}

		// die();

		$useraccess = $this->session->userdata(USER_ACCESS_TYPE);

		$i = 0;

		if (ORGANIZATION_NAME == 'KUKL') {

			$data = $this->stock_requisition_mdl->get_requisition_list_kukl();
			// echo $this->db->last_query();
			// die();
		} else if (ORGANIZATION_NAME == 'KU' || ORGANIZATION_NAME=='PU') {

			$data = $this->stock_requisition_mdl->get_requisition_list_ku();
		} else if (ORGANIZATION_NAME == 'ARMY' ) {

			$data = $this->stock_requisition_mdl->get_requisition_list_army();
			// echo $this->db->last_query();
			// die();
		} else {

			$data = $this->stock_requisition_mdl->get_requisition_list();
		}
		// echo $this->db->last_query();die();

		$this->data['requisition_no'] = $this->generate_stock_reqno();

		// echo $this->db->last_query();die();

		// echo"<pre>";print_r($data);die;

		$array = array();

		$filtereddata = ($data["totalfilteredrecs"] > 0 ? $data["totalfilteredrecs"] : $data["totalrecs"]);

		$totalrecs = $data["totalrecs"];

		unset($data["totalfilteredrecs"]);

		unset($data["totalrecs"]);

		$view_heading_var = $this->lang->line('stock_requisition_details');

		$approve_heading_var = $this->lang->line('requisition_information');

		$recommend_qty_view_group = array('SA', 'DM', 'DS');

		foreach ($data as $row) {

			$isdep = $row->rema_isdep;

			if ($isdep == 'N') {

				$frm_dep = !empty($row->fromdep_transfer) ? $row->fromdep_transfer : '';
			} else {

				$frm_dep = !empty($row->depfrom) ? $row->depfrom : '';
			}

			$appclass = '';

			$approved = !empty($row->rema_approved) ? $row->rema_approved : 0;

			$recommend_status = !empty($row->rema_recommendstatus) ? $row->rema_recommendstatus : '';

			$item_available_informed = !empty($row->rema_itemavailable) ? $row->rema_itemavailable : '';

			if (ORGANIZATION_NAME == 'KUKL') {

				$color_codeclass = $this->stock_requisition_mdl->getColorStatusCount();

				// echo "<pre>";

				// print_r($color_codeclass);

				// die();

				foreach ($color_codeclass as $key => $color) {

					if ($approved == 0) {

						$appclass = 'pending';
					} else if ($approved == $color->coco_statusval) {

						$appclass = $color->coco_statusname;
					}
				}
			} else {

				if ($approved == '0') {

					$appclass = 'pending';
				}

				if ($approved == '1') {

					$appclass = 'approved';
				}

				if ($approved == '2') {

					$appclass = 'unapproved';
				}

				if ($approved == '3') {

					$appclass = 'cancel';
				}

				if ($approved == '4') {

					$appclass = 'verified';
				}
			}

			$approvedby = $row->rema_approvedby;

			if (defined('APPROVEBY_TYPE')) :

				if (APPROVEBY_TYPE == 'USER') {

					$approvedby = $row->rema_approvedby;
				} else {

					$approvedby = (defined('APPROVER_USERNAME') && !empty($row->rema_approvedby)) ? APPROVER_USERNAME : $row->rema_approvedby;
				}

			endif;

			if ($row->rema_recommendstatus == 'R') {

				$recommendstatus = 'Recomm.';
			} else if ($row->rema_recommendstatus == 'A') {

				$recommendstatus = 'Accepted';
			} else if ($row->rema_recommendstatus == 'D') {

				$recommendstatus = 'Declined';
			} else {

				$recommendstatus = '';
			}

			// $array[$i]['viewurl']=base_url().'issue_consumption/stock_requisition/load_stock_requisition_popup';

			$array[$i]['viewurl'] = base_url() . 'issue_consumption/stock_requisition';

			$array[$i]["prime_id"] = $row->rema_reqmasterid;

			$array[$i]["rema_reqmasterid"] = '<a href="javascript:void(0)" class="patlist" data-patientid=' . $row->rema_reqmasterid . '>' . $row->rema_reqmasterid . '</a>';

			$array[$i]["reqno"] = $row->rema_reqno;

			$array[$i]["approvedclass"] = $appclass;

			$array[$i]["manualno"] = $row->rema_manualno;

			// $array[$i]["fromdep"] = $frm_dep;
			if (ORGANIZATION_NAME == 'KU' || ORGANIZATION_NAME=='PU') {
				$schoolname = !empty($row->schoolname) ? $row->schoolname : '';
				$depparent = !empty($row->deptparent) ? $row->deptparent : '';
				if (!empty($depparent)) {
					$array[$i]["fromdep"] = $schoolname . '-' . $depparent . '/' . $frm_dep;
				} else {
					$array[$i]["fromdep"] = $schoolname . '-' . $frm_dep;
				}
			} else {
				$array[$i]["fromdep"] = $frm_dep;
			}

			$array[$i]["todep"] = $row->depto;

			$array[$i]["username"] = $row->rema_username;

			$array[$i]["cntitem"] = '<a href="javascript:void(0)" data-id=' . $row->rema_reqmasterid . ' data-displaydiv="orderDetails" data-viewurl=' . base_url('issue_consumption/stock_requisition/stock_requisition_views_details') . ' class="view  btn-xxs" data-heading="' . $view_heading_var . '">' . $row->cntitem . '</a>';

			$array[$i]["isdep"] = ($row->rema_received == 1) ? 'Y' : 'N';

			$array[$i]["reqby"] = $row->rema_reqby;

			$array[$i]["approvedby"] = $approvedby;

			$array[$i]["remarks"] = $row->rema_remarks;

			$array[$i]["workplace"] = $row->rema_workplace;

			$array[$i]["workdesc"] = $row->rema_workdesc;

			$array[$i]["fyear"] = $row->rema_fyear;

			$array[$i]["postdatead"] = $row->rema_reqdatead;

			$array[$i]["postdatebs"] = $row->rema_reqdatebs;

			if (DEFAULT_DATEPICKER == 'NP') {
				$array[$i]["postdate"] = $row->rema_postdatebs . ' ' . $row->rema_posttime;
			} else {
				$array[$i]["postdate"] = $row->rema_postdatead . ' ' . $row->rema_posttime;
			}

			$array[$i]['recommend_status'] = $recommendstatus;
			$array[$i]['prev_demand_no'] = '';
			$prev_demandno = !empty($row->prev_demandno) ? $row->prev_demandno : '';
			if (!empty($prev_demandno)) {
				$dtempl = '';
				$prev_demand_arr = explode('@', $prev_demandno);
				if (!empty($prev_demand_arr)) {
					$pdno = !empty($prev_demand_arr[0]) ? $prev_demand_arr[0] : '';
					$mid = !empty($prev_demand_arr[1]) ? $prev_demand_arr[1] : '';

					$dtempl = '<a href="javascript:void(0)" title="Previous Demand" data-viewurl=' . base_url('issue_consumption/stock_requisition/view_requisition') . ' data-heading="Previous Demand"  class="view" data-id=' . $mid . '>' . $pdno . '</a>';
				}
				$array[$i]['prev_demand_no'] = $dtempl;
			}

			if (ORGANIZATION_NAME == 'KU' || ORGANIZATION_NAME == 'ARMY' || ORGANIZATION_NAME=='PU') {

				$array[$i]['maty_material'] = $row->maty_material;
			}

			$edit_allowed_group = array('DM', 'SA', 'SI');

			if ($approved == '0' && MODULES_UPDATE == 'Y' && empty($recommendstatus) && $row->rema_postby == $this->userid) {

				$editbtn = '<a href="javascript:void(0)" data-id=' . $row->rema_reqmasterid . ' data-displaydiv="stockreqform" data-viewurl=' . base_url('issue_consumption/stock_requisition') . ' class="btnredirect btn-info btn-xxs" data-heading="View Stock Requisition" title="Edit"  ><i class="fa fa-pencil-square-o " aria-hidden="true" ></i></a>';
			} else if (MODULES_UPDATE == 'Y' && $approved == '0'  && $item_available_informed == 1 && $row->rema_postby == $this->userid) {

				$editbtn = '<a href="javascript:void(0)" data-id=' . $row->rema_reqmasterid . ' data-otherdata="resubmit" data-displaydiv="stockreqform" data-viewurl=' . base_url('issue_consumption/stock_requisition') . ' class="btnredirect btn-info btn-xxs" data-heading="View Stock Requisition" title="Edit"  ><i class="fa fa-pencil-square-o " aria-hidden="true" ></i></a>';
			} else if (MODULES_UPDATE == 'Y' && $approved == '0'  && in_array($this->usergroup, $edit_allowed_group)) {

				$editbtn = '<a href="javascript:void(0)" data-id=' . $row->rema_reqmasterid . ' data-displaydiv="stockreqform" data-viewurl=' . base_url('issue_consumption/stock_requisition') . ' class="btnredirect btn-info btn-xxs" data-heading="View Stock Requisition" title="Edit"  ><i class="fa fa-pencil-square-o " aria-hidden="true" ></i></a>';
			} else {

				$editbtn = '';
			}

			if ($approved != '0' || (MODULES_VERIFIED == 'Y' || MODULES_APPROVE == 'Y')) {

				if (ORGANIZATION_NAME == 'KUKL') {

					if ($this->usergroup == 'SI') {
						$approvedbtn = '<a href="javascript:void(0)" title="Verified/Approved" data-viewurl=' . base_url('issue_consumption/stock_requisition/view_requisition') . ' data-heading="' . $approve_heading_var . '"  class="view  btn-success btn-xxs" data-id=' . $row->rema_reqmasterid . '><i class="fa fa-check" aria-hidden="true"></i></a>';
					} elseif ($row->rema_postby != $this->userid) {

						$approvedbtn = '<a href="javascript:void(0)" title="Verified/Approved" data-viewurl=' . base_url('issue_consumption/stock_requisition/view_requisition') . ' data-heading="' . $approve_heading_var . '"  class="view  btn-success btn-xxs" data-id=' . $row->rema_reqmasterid . '><i class="fa fa-check" aria-hidden="true"></i></a>';
					} else {

						$approvedbtn = '';
					}
				} else {

					$approvedbtn = '<a href="javascript:void(0)" title="Verified/Approved" data-viewurl=' . base_url('issue_consumption/stock_requisition/view_requisition') . ' data-heading="' . $approve_heading_var . '"  class="view  btn-success btn-xxs" data-id=' . $row->rema_reqmasterid . '><i class="fa fa-check" aria-hidden="true"></i></a>';
				}
			} else {

				$approvedbtn = '';
			}

			// echo $approvedbtn;

			// die();

			$array[$i]["action"] = $editbtn . '' . $approvedbtn . '<a href="javascript:void(0)" data-id=' . $row->rema_reqmasterid . ' data-displaydiv="orderDetails" data-viewurl=' . base_url('issue_consumption/stock_requisition/stock_requisition_views_details') . ' title="View" class="view btn-primary btn-xxs" data-heading="' . $view_heading_var . '"><i class="fa fa-eye" aria-hidden="true" ></i></a>';

			$i++;
		}

		$get = $_GET;

		echo json_encode(array("recordsFiltered" => $filtereddata, "recordsTotal" => $totalrecs, "data" => $array));
	}

	public function generate_pdfReqlist_details()

	{
		$page_orientation = !empty($_GET['page_orientation']) ? $_GET['page_orientation']  : '';
		if ($page_orientation == 'L') {
			$page_size = 'A4-L';
		} else {
			$page_size = 'A4';
		}

		$this->data['searchResult'] = $this->stock_requisition_mdl->get_requisition_details_list();

		unset($this->data['searchResult']['totalfilteredrecs']);

		unset($this->data['searchResult']['totalrecs']);

		$html = $this->load->view('stock/v_stock_requisition_download_details', $this->data, true);

		$filename = 'stock_requisition_details' . date('Y_m_d_H_i') . '.pdf';

		$this->general->generate_pdf($html, '', $page_size);
	}

	public function exportToExcelReqlistDetails()

	{

		header("Content-Type: application/xls");

		header("Content-Disposition: attachment; filename=stock_requisition_details" . date('Y_m_d_H_i') . ".xls");

		header("Pragma: no-cache");

		header("Expires: 0");

		$data = $this->stock_requisition_mdl->get_requisition_details_list();

		$this->data['searchResult'] = $this->stock_requisition_mdl->get_requisition_details_list();

		$array = array();

		unset($this->data['searchResult']['totalfilteredrecs']);

		unset($this->data['searchResult']['totalrecs']);

		$response = $this->load->view('stock/v_stock_requisition_download_details', $this->data, true);

		echo $response;
	}

	public function generate_pdfReqlist()

	{
		$this->data['report_title'] =  $this->lang->line('stock_requisition_summary');
		$page_orientation = !empty($_GET['page_orientation']) ? $_GET['page_orientation']  : '';
		if ($page_orientation == 'L') {
			$page_size = 'A4-L';
		} else {
			$page_size = 'A4';
		}

		if (ORGANIZATION_NAME == 'KUKL') {
			$this->data['searchResult']  = $this->stock_requisition_mdl->get_requisition_list_kukl();
			// print_r($data);
			// die();
		} else if (ORGANIZATION_NAME == 'KU' ||  ORGANIZATION_NAME == 'ARMY' || ORGANIZATION_NAME=='PU') {
			$this->data['searchResult']  = $this->stock_requisition_mdl->get_requisition_list_ku();
			// print_r($this->data['searchResult']);
			// die();

		} else {

			$this->data['searchResult'] = $this->stock_requisition_mdl->get_requisition_list();
		}
		// $this->data['searchResult'] = $this->stock_requisition_mdl->get_requisition_list_kukl();

		unset($this->data['searchResult']['totalfilteredrecs']);
		unset($this->data['searchResult']['totalrecs']);

		// echo"<pre>";
		// print_r($this->data['searchResult']);
		// echo "</pre>";
		// die;

		ini_set('memory_limit', '256M');

		if (ORGANIZATION_NAME == 'KU' || ORGANIZATION_NAME == 'ARMY' || ORGANIZATION_NAME=='PU') {
			// echo "test";
			//  die();
			$html = $this->load->view('stock/ku/v_stock_requisition_download', $this->data, true);
		} else {
			$html = $this->load->view('stock/v_stock_requisition_download', $this->data, true);
		}

		$this->general->generate_pdf($html, '', $page_size);
	}

	public function exportToExcelReqlist()
	{

		header("Content-Type: application/xls");

		header("Content-Disposition: attachment; filename=stock_requisition" . date('Y_m_d_H_i') . ".xls");

		header("Pragma: no-cache");

		header("Expires: 0");

		$data = $this->stock_requisition_mdl->get_requisition_list();

		if (ORGANIZATION_NAME == 'KUKL') {

			$this->data['searchResult']  = $this->stock_requisition_mdl->get_requisition_list_kukl();
		} else {

			$this->data['searchResult'] = $this->stock_requisition_mdl->get_requisition_list();
		}

		// $this->data['searchResult'] = $this->stock_requisition_mdl->get_requisition_list_kukl();

		$array = array();

		unset($this->data['searchResult']['totalfilteredrecs']);

		unset($this->data['searchResult']['totalrecs']);

		$response = $this->load->view('stock/v_stock_requisition_download', $this->data, true);

		echo $response;
	}

	public function stock_requisition_views_details()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			if ($_SERVER['REQUEST_METHOD'] === 'POST') {

				$id = $this->input->post('id');

				if ($id) {

					$this->data['stock_requisition_details'] = $this->stock_requisition_mdl->get_requisition_master_data(array('rm.rema_reqmasterid' => $id));

					$req_no = $this->data['stock_requisition_details'][0]->rema_reqno;

					$locationid = $this->data['stock_requisition_details'][0]->rema_locationid;

					$fyear = $this->data['stock_requisition_details'][0]->rema_fyear;

					$this->data['is_issued'] = $this->general->get_tbl_data('*', 'sama_salemaster', array('sama_requisitionno' => $req_no, 'sama_locationid' => $locationid, 'sama_fyear' => $fyear));

					// echo "<pre>"; print_r($this->data['is_issued']);die;

					$template = '';

					if ($this->data['stock_requisition_details'] > 0) {

						$store_id = $this->data['stock_requisition_details'][0]->rema_storeid;

						$this->data['mat_type'] = $this->general->get_tbl_data('*', 'maty_materialtype', array('maty_isactive' => 'Y'));

						$this->data['stock_requisition'] = $this->stock_requisition_mdl->get_requisition_details_data(array('rd.rede_reqmasterid' => $id, 'rd.rede_isdelete' => 'N'), $store_id);

						// echo "<pre>"; print_r($this->data['stock_requisition']);die;

						// echo $this->db->last_query();

						// die();

						$this->data['store_id'] = $store_id;

						$this->data['rede_reqmasterid'] = $id;

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

	public function stock_requisition_reprint()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$id = $this->input->post('id');

			if ($id) {

				$requisition_data = $this->data['stock_requisition_details'] = $this->stock_requisition_mdl->get_requisition_master_data(array('rema_reqmasterid' => $id));

				//general->get_tbl_data('*','rema_reqmaster',array('rema_reqmasterid'=>$id),'rema_reqmasterid','DESC');

				// echo "<pre>";

				// print_r($requisition_data);

				// die();

				// need to check rede_proceedissue

				$this->data['stock_requisition'] = $this->stock_requisition_mdl->get_requisition_data(array('rd.rede_reqmasterid' => $id));

				// echo $this->db->last_query();

				// die();

				$this->data['user_signature'] = $this->general->get_signature($this->userid);

				$approvedby = $requisition_data[0]->rema_approvedid;

				$this->data['approver_signature'] = $this->general->get_signature($approvedby);

				//echo"<pre>";print_r($this->data['stock_requisition_details']);die();

				$req_date = !empty($stock_requisition_details[0]->rema_reqdatebs) ? $stock_requisition_details[0]->rema_reqdatebs : CURDATE_NP;

				$store_head_id = $this->general->get_store_post_data($req_date, 'store_head');

				$this->data['store_head_signature'] = $this->general->get_signature($store_head_id);

				$reqno = !empty($requisition_data[0]->rema_reqno) ? $requisition_data[0]->rema_reqno : '';

				$fyear = !empty($requisition_data[0]->rema_fyear) ? $requisition_data[0]->rema_fyear : '';

				// $this->data['user_list_for_report'] = $this->stock_requisition_mdl->get_user_list_for_report($reqno, $fyear);

				// for kukl

				if (ORGANIZATION_NAME == 'KUKL') :

					$pure_data = $this->data['check_budget_availability'] = $this->general->get_tbl_data('pure_isapproved, pure_purchasereqid', 'pure_purchaserequisition', array('pure_streqno' => $reqno, 'pure_fyear' => $fyear, 'pure_locationid' => $this->locationid));

					$pure_masterid = !empty($pure_data[0]->pure_purchasereqid) ? $pure_data[0]->pure_purchasereqid : '';

					$this->data['account_action_log'] = $this->general->get_username_from_actionlog(array('aclo_masterid' => $pure_masterid, 'aclo_tablename' => 'pure_purchaserequisition', 'aclo_fieldname' => 'pure_accountverify'));

				endif;

				// echo STOCK_REQ_REPORT_TYPE;

				// die();
				// echo REPORT_SUFFIX;
				// die();
				if (STOCK_REQ_REPORT_TYPE == 'DEFAULT') {

					$template = $this->load->view('stock/v_print_report_issue', $this->data, true);
				} else {

					$file_name = base_url('stock/v_print_report_issue' . '_' . REPORT_SUFFIX . '.php');

					if (file_exists($file_name)) //not working

					{
						// echo "Asasdsad";
						// die();
						$template = $this->load->view('stock/v_print_report_issue' . '_' . REPORT_SUFFIX, $this->data, true);
					} else {

						// echo "Asd";
						// die();
						$template = $this->load->view('stock/' . REPORT_SUFFIX . '/v_print_report_issue', $this->data, true);
					}
				}

				if ($template) {

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

	public function requisition_summary()

	{

		// echo "test";

		// die();

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			// print_r($this->input->post());

			// die();

			$frmDate = !empty($this->input->post('frmdate')) ? $this->input->post('frmdate') : CURDATE_NP;

			$toDate = !empty($this->input->post('todate')) ? $this->input->post('todate') : CURDATE_NP;

			$input_locationid = !empty($this->input->post('locationid')) ? $this->input->post('locationid') : '';

			// echo "<pre>";

			// print_r($input_locationid);

			// die();

			if (ORGANIZATION_NAME == 'KUKL') :

				$status_count = $this->stock_requisition_mdl->getStatusCount_kukl();

				// echo $this->db->last_query();

				// die();

				$total_count = $this->stock_requisition_mdl->getRemCount_kulk();

			else :

				if ($this->location_ismain == 'Y') {

					if ($input_locationid) {

						$status_count = $this->stock_requisition_mdl->getStatusCount(array('rema_reqdatebs >=' => $frmDate, 'rema_reqdatebs <=' => $toDate, 'rema_locationid' => $input_locationid));

						// echo "<pre>";

						// print_r($status_count);

						// die();

						$total_count = $this->stock_requisition_mdl->getRemCount(array('rm.rema_reqdatebs >=' => $frmDate, 'rm.rema_reqdatebs <=' => $toDate, 'rm.rema_locationid' => $input_locationid));

						// echo "<pre>";

						// print_r($total_count);

						// die();

					} else {

						$status_count = $this->stock_requisition_mdl->getStatusCount(array('rema_reqdatebs >=' => $frmDate, 'rema_reqdatebs <=' => $toDate));

						$total_count = $this->stock_requisition_mdl->getRemCount(array('rm.rema_reqdatebs >=' => $frmDate, 'rm.rema_reqdatebs <=' => $toDate));
					}
				} else {

					$status_count = $this->stock_requisition_mdl->getStatusCount(array('rema_reqdatebs >=' => $frmDate, 'rema_reqdatebs <=' => $toDate, 'rema_locationid' => $this->locationid));

					$total_count = $this->stock_requisition_mdl->getRemCount(array('rm.rema_reqdatebs >=' => $frmDate, 'rm.rema_reqdatebs <=' => $toDate, 'rm.rema_locationid' => $this->locationid));
				}

			endif;

			// echo $this->db->last_query();

			print_r(json_encode(array('status' => 'success', 'status_count' => $status_count, 'total_count' => $total_count)));
		}
	}

	public function get_dept_list()
	{

		try {

			$cur_storeid = $this->session->userdata(STORE_ID);

			$type = $this->input->post('type');

			if ($type == 'issue') {

				$selected = '';

				if (ORGANIZATION_NAME == 'KUKL') :

					$department = $this->stock_requisition_mdl->get_dept_by_user();

					$count_dep = count($department);

					if ($count_dep == '1') :

						$selected = 'selected';

					endif;

				elseif (ORGANIZATION_NAME == 'NPHL' && $this->usergroup == 'DM') :
					$department = $this->stock_requisition_mdl->get_dept_by_user();
					$count_dep = count($department);

					if ($count_dep == '1') :

						$selected = 'selected';

					endif;
				elseif (ORGANIZATION_NAME == 'ARMY') :
					if ($this->location_ismain == 'Y' && in_array($this->usergroup, $this->show_location_group)) {
						$dept_cond = array(
							'dept_isactive' => 'Y',
						);
					} else {
						$dept_cond = array(
							'dept_isactive' => 'Y',
							'dept_locationid' => $this->locationid
						);
					}

					$department = $this->general->get_tbl_data('*', 'dept_department', $dept_cond, 'dept_depname', 'ASC');

				else :

					$department = $this->general->get_tbl_data('*', 'dept_department', false, 'dept_depname', 'ASC');

				endif;

				$store_type = $this->general->get_tbl_data('*', 'eqty_equipmenttype', false, 'eqty_equipmenttype', 'ASC');

				$fromdepid = "<option value=''>---select---</option>";

				if (!empty($department)) :

					foreach ($department as $dep) :

						$fromdepid .= "<option value='$dep->dept_depid' $selected>$dep->dept_depname</option>";

					endforeach;

				endif;

				$todepid = "";

				if (!empty($store_type)) :

					foreach ($store_type as $dep) :

						if ($this->storeid == $dep->eqty_equipmenttypeid) {

							$is_selected = "selected";
						} else {

							$is_selected = "";
						}

						$todepid .= "<option value='$dep->eqty_equipmenttypeid' $is_selected>$dep->eqty_equipmenttype</option>";

					endforeach;

				endif;
			} else if ($type == 'transfer') {

				$fromdepid_data = $this->general->get_tbl_data('*', 'eqty_equipmenttype', array('eqty_equipmenttypeid' => $cur_storeid), 'eqty_equipmenttype', 'ASC');

				$todepid_data = $this->general->get_tbl_data('*', 'eqty_equipmenttype', array('eqty_equipmenttypeid !=' => $cur_storeid), 'eqty_equipmenttype', 'ASC');

				$fromdepid = "<option value=''>---select---</option>";

				if (!empty($fromdepid_data)) :

					foreach ($fromdepid_data as $dep) :

						$fromdepid .= "<option value='$dep->eqty_equipmenttypeid' selected='selected'>$dep->eqty_equipmenttype</option>";

					endforeach;

				endif;

				$todepid = "";

				if (!empty($todepid_data)) :

					foreach ($todepid_data as $dep) :

						if ($this->storeid == $dep->eqty_equipmenttypeid) {

							$is_selected = "selected";
						} else {

							$is_selected = "";
						}

						$todepid .= "<option value='$dep->eqty_equipmenttypeid' $is_selected>$dep->eqty_equipmenttype</option>";

					endforeach;

				endif;
			}

			print_r(json_encode(array('status' => 'success', 'from_depid' => $fromdepid, 'to_depid' => $todepid, 'type' => $type)));

			exit;
		} catch (Exception $e) {

			echo $e->getMessage();
		}
	}

	public function get_req_no()
	{

		try {

			$cur_fiscalyear = CUR_FISCALYEAR;

			$depid = !empty($this->input->post('depid')) ? $this->input->post('depid') : $this->storeid;

			$type = !empty($this->input->post('type')) ? $this->input->post('type') : 'issue';

			$reqno = $this->generate_stock_reqno();

			print_r(json_encode(array('status' => 'success', 'reqno' => $reqno, 'depid' => $depid, 'type' => $type)));

			exit;
		} catch (Exception $e) {

			echo $e->getMessage();
		}
	}

	public function get_req_no_by_mat_type($direct_access = false)
	{

		try {

			// echo "<pre>";

			// print_r($this->input->post());

			// die();
			$cur_fiscalyear=!empty($this->input->post('fyear')) ? $this->input->post('fyear') : CUR_FISCALYEAR;

			$depid = !empty($this->input->post('depid')) ? $this->input->post('depid') : $this->storeid;

			$type = !empty($this->input->post('type')) ? $this->input->post('type') : 'issue';

			$mattype = !empty($this->input->post('mattype')) ? $this->input->post('mattype') : '1';

			if ($this->mattypeid) {

				$mattype = $this->mattypeid;
			}

			 if (defined('SHOW_MATERIAL_OPTION_TYPE')) :
                $show_material_type=SHOW_MATERIAL_OPTION_TYPE;
                else:
                    $show_material_type='N';
                endif;

               if($show_material_type=='Y'){
               	$get_reqno = $this->stock_requisition_mdl->get_req_no(array('rema_reqtodepid' => $depid, 'rema_fyear' => $cur_fiscalyear, 'rema_locationid' => $this->locationid, 'rema_mattypeid' => $mattype, 'rema_isdep' => 'Y'));
               }else{
               		$get_reqno = $this->stock_requisition_mdl->get_req_no(array('rema_reqtodepid' => $depid, 'rema_fyear' => $cur_fiscalyear, 'rema_locationid' => $this->locationid,'rema_isdep' => 'Y'));
               }
			// $reqno = $this->generate_stock_reqno();

			// echo $this->db->last_query();

			// die();

			if (!empty($get_reqno)) {

				$reqno = !empty($get_reqno[0]->reqno) ? $get_reqno[0]->reqno + 1 : 1;
			} else {

				$reqno = 1;
			}

			if ($direct_access == 'Y') {

				return $reqno;
			} else {

				print_r(json_encode(array('status' => 'success', 'reqno' => $reqno, 'depid' => $depid, 'type' => $type)));

				exit;
			}
		} catch (Exception $e) {

			echo $e->getMessage();
		}
	}

	public function load_stock_requisition_popup($rema_id = false)

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			try {

				$id = $this->input->post('id');

				$this->data['id'] = $id;

				$this->data['is_approval_modal'] = 'Y';

				$this->data['req_data'] = $this->stock_requisition_mdl->get_requisition_data(array('rede_isdelete' => 'N', 'rede_reqmasterid' => $id));

				$this->data['equipmentcategory'] = $this->general->get_tbl_data('*', 'eqca_equipmentcategory', false, 'eqca_equipmentcategoryid', 'DESC');

				$this->data['store_type'] = $this->general->get_tbl_data('*', 'eqty_equipmenttype', false, 'eqty_equipmenttype', 'ASC');

				$this->data['department'] = $this->general->get_tbl_data('*', 'dept_department', false, 'dept_depid', 'DESC');

				$this->data['item_all'] = $this->general->get_tbl_data('*', 'itli_itemslist', false, 'itli_itemlistid', 'DESC');

				$this->data['requisition_no'] = $this->generate_stock_reqno();

				$tempform = $this->load->view('stock/v_stockrequisition_form', $this->data, true);

				if (!empty($tempform)) {

					print_r(json_encode(array('status' => 'success', 'message' => 'You Can view', 'tempform' => $tempform)));

					exit;
				} else {

					print_r(json_encode(array('status' => 'error', 'message' => 'Unable to View!!')));

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

	public function demand_analysis()

	{

		$this->data['store_type'] = $this->general->get_tbl_data('*', 'eqty_equipmenttype', false, 'eqty_equipmenttype', 'ASC');

		$this->data['department'] = $this->general->get_tbl_data('*', 'dept_department', false, 'dept_depid', 'ASC');

		$this->data['tab_type'] = 'demand_analysis';

		$frmDate = CURDATE_NP;

		$toDate = CURDATE_NP;

		$this->data['status_count'] = $this->stock_requisition_mdl->getStatusCount(array('rema_reqdatebs >=' => $frmDate, 'rema_reqdatebs <=' => $toDate));

		$this->data['requisition_no'] = $this->generate_stock_reqno();

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

			->build('stock/v_stock_requisition', $this->data);
	}

	public function demand_analysis_lists()

	{

		if (MODULES_VIEW == 'N') {

			$array = array();

			// $this->general->permission_denial_message();

			echo json_encode(array("recordsFiltered" => 0, "recordsTotal" => 0, "data" => $array));

			exit;
		}

		$useraccess = $this->session->userdata(USER_ACCESS_TYPE);

		$i = 0;

		$cond = "";

		$st_store_id = $this->input->post('st_store_id');

		$depid = $this->input->post('depid');

		$store_id = $this->input->post('store_id');

		$data = $this->stock_requisition_mdl->get_demand_analysis_list();

		// echo "<pre>";

		// print_r($data);

		// die();

		$array = array();

		$filtereddata = ($data["totalfilteredrecs"] > 0 ? $data["totalfilteredrecs"] : $data["totalrecs"]);

		$totalrecs = $data["totalrecs"];

		unset($data["totalfilteredrecs"]);

		unset($data["totalrecs"]);

		foreach ($data as $row) {

			if (ITEM_DISPLAY_TYPE == 'NP') {

				$req_itemname = !empty($row->itli_itemnamenp) ? $row->itli_itemnamenp : $row->itli_itemname;
			} else {

				$req_itemname = !empty($row->itli_itemname) ? $row->itli_itemname : '';
			}

			$diffval = ($row->stockqty - $row->demandqty);

			if ($diffval > 0) {

				$diff = '<label class=" text-success">' . $diffval . '</label>';
			} else {

				$diff = '<label class=" text-danger">' . $diffval . '</label>';
			}

			$array[$i]["itli_itemlistid"] = $row->itli_itemlistid;

			$array[$i]["itli_itemcode"] = $row->itli_itemcode;

			$array[$i]["itli_itemname"] = $req_itemname;

			$array[$i]['demand_cnt'] = $row->cnt;

			$array[$i]["demandqty"] = $row->demandqty;

			$array[$i]["stockqty"] = $row->stockqty;

			$array[$i]["diff"] = $diff;

			$i++;
		}

		$get = $_GET;

		echo json_encode(array("recordsFiltered" => $filtereddata, "recordsTotal" => $totalrecs, "data" => $array));
	}

	public function generate_pdfDemand()

	{

		$this->data['searchResult'] = $this->stock_requisition_mdl->get_demand_analysis_list();

		unset($this->data['searchResult']['totalfilteredrecs']);

		unset($this->data['searchResult']['totalrecs']);

		$html = $this->load->view('stock/v_stock_requisition_download', $this->data, true);

		$this->general->generate_pdf($html, '', '');
	}

	public function exportToExcelDemand()
	{

		header("Content-Type: application/xls");

		header("Content-Disposition: attachment; filename=stock_requisition" . date('Y_m_d_H_i') . ".xls");

		header("Pragma: no-cache");

		header("Expires: 0");

		$data = $this->stock_requisition_mdl->get_demand_analysis_list();

		$this->data['searchResult'] = $this->stock_requisition_mdl->get_demand_analysis_list();

		$array = array();

		unset($this->data['searchResult']['totalfilteredrecs']);

		unset($this->data['searchResult']['totalrecs']);

		$response = $this->load->view('stock/v_stock_requisition_download', $this->data, true);

		echo $response;
	}

	public function demand_analysis_form_dropdown()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$type = $this->input->post('id');

			// $this->data['department'] = '';

			// $this->data['store_type'] = '';

			$this->data['type'] = $type;

			if ($type == "transfer") {

				$this->data['store_type'] = $this->general->get_tbl_data('*', 'eqty_equipmenttype', false, 'eqty_equipmenttype', 'ASC');
			}

			if ($type == "issue") {

				$this->data['department'] = $this->general->get_tbl_data('*', 'dept_department', false, 'dept_depid', 'ASC');
			}

			$template = $this->load->view('stock/v_stock_partial_form', $this->data, true);

			//echo"<pre>"; print_r($template);die;

			if (!empty($this->data['store_type']) || !empty($this->data['department'])) {

				print_r(json_encode(array('status' => 'success', 'message' => 'success', 'template' => $template)));

				exit;
			} else {

				print_r(json_encode(array('status' => 'error', 'message' => 'Error While Choosing Data!!')));

				exit;
			}
		} else {

			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));

			exit;
		}
	}

	public function monthlywise_dep_req()

	{

		$this->data['tab_type'] = 'monthlywise_dep_req';

		$this->data['fiscalyear'] = $this->general->get_tbl_data('*', 'fiye_fiscalyear', false, 'fiye_fiscalyear_id', 'ASC');

		$this->data['store'] = $this->general->get_tbl_data('*', 'eqty_equipmenttype', false, 'eqty_equipmenttypeid', 'ASC');

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

			->build('stock/v_stock_requisition', $this->data);
	}

	public function monthlywise_dep_req_lists()

	{

		$get = $_GET;

		$store_id = !empty($get['store_id']) ? $get['store_id'] : '0';

		$fyear = !empty($get['fiscal_year']) ? $get['fiscal_year'] : CUR_FISCALYEAR;

		// echo $fyear;

		// die();

		$apstatus = !empty($get['appstatus']) ? $get['appstatus'] : '';

		$locationid = !empty($get['locationid']) ? $get['locationid'] : $this->session->userdata(LOCATION_ID);

		if (MODULES_VIEW == 'N') {

			$array = array();

			echo json_encode(array("recordsFiltered" => 0, "recordsTotal" => 0, "data" => $array));

			exit;
		}

		$useraccess = $this->session->userdata(USER_ACCESS_TYPE);

		$i = 0;

		$deptreq = '';

		$this->data['department'] = $this->general->get_tbl_data('*', 'dept_department', false, 'dept_depid', 'ASC');

		$data = $this->stock_requisition_mdl->get_department_wise_data();

		// echo"<pre>";print_r($data);die;

		//echo $this->db->last_query();die();

		$array = array();

		$filtereddata = ($data["totalfilteredrecs"] > 0 ? $data["totalfilteredrecs"] : $data["totalrecs"]);

		$totalrecs = $data["totalrecs"];

		unset($data["totalfilteredrecs"]);

		unset($data["totalrecs"]);

		foreach ($data as $row) {

			$totalallloc = 0;

			$array[$i]["sno"] = $i + 1;

			$array[$i]['depid'] = $row->depid;

			$array[$i]['dept_depname'] = $row->dept_depname;

			$sum_all_data = 0;

			for ($j = 1; $j <= 12; $j++) {

				$rwdep = ('mdr' . $j);

				$monthname = $this->general->getNepaliMonth($j);

				$mnthr = !empty($row->{$rwdep}) ? $row->{$rwdep} : '0';

				$array[$i]['mdr' . $j] = '<a href="javascript:void(0)" data-yrs=' . $row->yrs . ' data-appstatus="' . $apstatus . '" data-month=' . $j . ' data-locationid=' . $row->locationid . '  data-fyear="' . $fyear . '" data-store_id=' . $store_id . ' data-id=' . $row->depid . ' data-displaydiv="IssueDetails" data-viewurl=' . base_url('issue_consumption/stock_requisition/view_deails_requisition') . ' class="view" data-heading="Requisition Monthly Details ' . $monthname . '" title="Requisition Monthly Details ' . $monthname . '">' . $mnthr . '</a>';

				$sum_all_data += $mnthr;
			}

			$array[$i]['total_all'] = $sum_all_data;

			$array[$i]['totalallloc'] = $totalallloc;

			$i++;
		}

		echo json_encode(array("recordsFiltered" => $filtereddata, "recordsTotal" => $totalrecs, "data" => $array));
	}

	public function view_deails_requisition()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			if ($_SERVER['REQUEST_METHOD'] === 'POST') {

				$id = $this->input->post('id');

				// $appstatus = $this->input->post('appstatus');

				// $month = $this->input->post('month');

				// $yrs = $this->input->post('yrs');

				// if($month < 10)

				// {

				// 	$nyrs ='0'.$month;

				// }else{

				// 	$nyrs =$month;

				// }

				// $year = "$yrs/$nyrs";

				if ($id) {

					//echo"<pre>"; print_r($this->input->post());die;

					//print_r($srch);die;

					$this->data['details_requisition_department'] = $this->stock_requisition_mdl->get_requisition_data_department_wise();

					// echo $this->db->last_query(); die();

					// echo"<pre>";print_r($this->data['details_requisition_department']);die();

					$template = $this->load->view('stock/v_stock_requistion_monthly_popup', $this->data, true);

					//$template=$this->load->view('stock/v_stock_requistion_details',$this->data,true);

					if ($this->data['details_requisition_department'] > 0) {

						print_r(json_encode(array('status' => 'success', 'message' => '', 'tempform' => $template)));

						exit;
					} else {

						print_r(json_encode(array('status' => 'error', 'message' => 'No record Found!!')));

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

	public function generate_pdfRequisitionMonthly()

	{

		//locationid appstatus store_id fiscal_year

		$this->data['searchResult'] = $this->stock_requisition_mdl->get_department_wise_data();

		//echo"<pre>";print_r($this->input->get());die;

		//echo"<pre>";print_r($this->data['searchResult']);die;

		unset($this->data['searchResult']['totalfilteredrecs']);

		unset($this->data['searchResult']['totalrecs']);

		$html = $this->load->view('stock/v_stock_requisition_monthly_download', $this->data, true);

		$filename = 'pdfRequisitionMonthly_' . date('Y_m_d_H_i') . '.pdf';

		$this->general->generate_pdf($html, '', '');
	}

	public function exportToExcelRequisitionMonthly()
	{

		header("Content-Type: application/xls");

		header("Content-Disposition: attachment; filename=stock_requisition" . date('Y_m_d_H_i') . ".xls");

		header("Pragma: no-cache");

		header("Expires: 0");

		$data = $this->stock_requisition_mdl->get_department_wise_data();

		$this->data['searchResult'] = $this->stock_requisition_mdl->get_department_wise_data();

		$array = array();

		unset($this->data['searchResult']['totalfilteredrecs']);

		unset($this->data['searchResult']['totalrecs']);

		$response = $this->load->view('stock/v_stock_requisition_monthly_download', $this->data, true);

		echo $response;
	}

	public function list_of_reqby()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			try {

				$data['reqby_list'] = $this->stock_requisition_mdl->get_all_reqby(false, 10, false, 'rema_reqmasterid', 'ASC');

				// echo "<pre>";

				// print_r($data);

				// die();

				$template = $this->load->view('issue_consumption/stock/list_of_reqby', $data, true);

				if ($template) {

					print_r(json_encode(array('status' => 'success', 'message' => 'Selected Successfully', 'template' => $template)));

					exit;
				} else {

					print_r(json_encode(array('status' => 'error', 'message' => 'Operation Unsuccessful')));

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

	public function demand_print_form()

	{

		$this->data['issue_master'] = $this->general->get_tbl_data('*', 'rema_reqmaster', array('rema_reqmasterid' => '29'), 'rema_reqmasterid', 'DESC');

		$this->data['stock_requisition'] = $this->stock_requisition_mdl->get_requisition_data(array('rd.rede_reqmasterid' => '29'));

		$print_report = $this->load->view('stock/v_print_report_issue_kukl', $this->data, true);

		echo $print_report;

		die();
	}

	public function generate_stock_reqno()

	{

		//req no without location code

		$reqno = '';

		$cur_fiscalyear = CUR_FISCALYEAR;

		$depid = !empty($this->input->post('depid')) ? $this->input->post('depid') : $this->storeid;

		$type = !empty($this->input->post('type')) ? $this->input->post('type') : 'issue';

		if ($type == 'transfer') {

			$get_reqno = $this->stock_requisition_mdl->get_req_no(array('rema_isdep' => 'N', 'rema_fyear' => $cur_fiscalyear, 'rema_locationid' => $this->locationid));
		} else if ($type == 'issue') {

			$get_reqno = $this->stock_requisition_mdl->get_req_no(array('rema_reqtodepid' => $depid, 'rema_fyear' => $cur_fiscalyear, 'rema_locationid' => $this->locationid));
		} else {

			$get_reqno = $this->stock_requisition_mdl->get_req_no(array('rema_reqtodepid' => $depid, 'rema_fyear' => $cur_fiscalyear, 'rema_locationid' => $this->locationid));

			// print_r($get_reqno);

			// die();

		}

		if (!empty($get_reqno)) {

			$reqno = !empty($get_reqno[0]->reqno) ? $get_reqno[0]->reqno + 1 : 1;
		}

		if (defined('SHOW_FORM_NO_WITH_LOCATION')) {

			if (SHOW_FORM_NO_WITH_LOCATION == 'Y') {

				//req no with location code

				$location_data = $this->general->get_tbl_data('loca_code', 'loca_location', array('loca_locationid' => $this->locationid));

				$location_code = !empty($location_data[0]->loca_code) ? $location_data[0]->loca_code : '';

				$prefix = $location_code;

				$this->db->select('rema_reqno');

				$this->db->from('rema_reqmaster');

				$this->db->where('rema_reqno LIKE ' . '"%' . $prefix . '%"');

				$this->db->where('rema_locationid', $this->locationid);

				$this->db->limit(1);

				$this->db->order_by('rema_reqno', 'DESC');

				$query = $this->db->get();

				// echo $this->db->last_query(); die();

				$invoiceno = 0;

				$dbinvoiceno = '';

				if ($query->num_rows() > 0) {

					$dbinvoiceno = $query->row()->rema_reqno;
				}

				if (!empty($dbinvoiceno)) {

					$invoiceno = $this->general->stringseperator($dbinvoiceno, 'number');
				}

				$nw_invoice = str_pad($invoiceno + 1, RECEIVED_NO_LENGTH, 0, STR_PAD_LEFT);

				return $prefix . '-' . $nw_invoice;
			} else {

				return $reqno;
			}
		} else {

			return $reqno;
		}
	}

	/*FOR KUKL*/

	public function requisition_summary_view()
	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			// print_r($this->input->post());

			// die();

			$frmDate = !empty($this->input->post('frmdate')) ? $this->input->post('frmdate') : CURDATE_NP;

			$toDate = !empty($this->input->post('todate')) ? $this->input->post('todate') : CURDATE_NP;

			$input_locationid = !empty($this->input->post('locationid')) ? $this->input->post('locationid') : '';

			if ($this->location_ismain == 'Y') {

				if ($input_locationid) {

					$status_count = $this->stock_requisition_mdl->getStatusCount(array('rema_reqdatebs >=' => $frmDate, 'rema_reqdatebs <=' => $toDate, 'rema_locationid' => $input_locationid));

					$total_count = $this->stock_requisition_mdl->getRemCount(array('rm.rema_reqdatebs >=' => $frmDate, 'rm.rema_reqdatebs <=' => $toDate, 'rm.rema_locationid' => $input_locationid));
				} else {

					$status_count = $this->stock_requisition_mdl->getStatusCount(array('rema_reqdatebs >=' => $frmDate, 'rema_reqdatebs <=' => $toDate));

					$total_count = $this->stock_requisition_mdl->getRemCount(array('rm.rema_reqdatebs >=' => $frmDate, 'rm.rema_reqdatebs <=' => $toDate));
				}
			} else {

				$status_count = $this->stock_requisition_mdl->getStatusCount(array('rema_reqdatebs >=' => $frmDate, 'rema_reqdatebs <=' => $toDate, 'rema_locationid' => $this->locationid));

				$total_count = $this->stock_requisition_mdl->getRemCount(array('rm.rema_reqdatebs >=' => $frmDate, 'rm.rema_reqdatebs <=' => $toDate, 'rm.rema_locationid' => $this->locationid));
			}

			// echo $this->db->last_query();

			print_r(json_encode(array('status' => 'success', 'status_count' => $status_count, 'total_count' => $total_count)));
		}
	}

	public function view_requisition_mdl()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$mastid_id = $this->input->post('id');

			$this->data['requistion_data'] = $this->stock_requisition_mdl->get_requisition_master_data(array('rm.rema_reqmasterid' => $mastid_id));

			// echo $this->db->last_query();echo $id;die();

			$this->data['req_detail_list'] = $this->stock_requisition_mdl->get_requisition_details_data(array('rd.rede_reqmasterid' => $mastid_id, 'rd.rede_isdelete' => 'N'));

			// echo "<pre>";print_r($this->data['req_detail_list']);die();

			$tempform = '';

			$tempform = $this->load->view('stock/v_stock_requistion_view', $this->data, true);

			if (!empty($tempform)) {

				print_r(json_encode(array('status' => 'success', 'message' => 'You Can view', 'tempform' => $tempform)));

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

	public function update_recommend_qty()
	{

		$recommend_qty = $this->input->post('all_recommend_qty');

		$items_id = $this->input->post('all_items_id');

		$rema_reqmasterid = $this->input->post('rema_reqmasterid');

		$rema_reqno = $this->input->post('rema_reqno');

		$trans = $this->stock_requisition_mdl->update_recommend_qty($items_id, $recommend_qty, $rema_reqmasterid);

		if ($trans) {

			//Send Message

			$get_post_by = $this->general->get_tbl_data('rema_postby', 'rema_reqmaster', array('rema_reqmasterid' => $rema_reqmasterid));

			$mess_userid = !empty($get_post_by[0]->rema_postby) ? $get_post_by[0]->rema_postby : 0;

			$msg_params = array(

				'DEMAND_NO' => $rema_reqno,

				'TO_USERID' => $mess_userid

			);

			$this->general->send_message_params('update_recommend_qty', $msg_params);

			print_r(json_encode(array('status' => 'success', 'message' => 'Recommend qty was submitted.')));

			exit;
		} else {

			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));

			exit;
		}
	}

	public function verify_recommend_qty()
	{

		$recommend_qty = $this->input->post('all_recommend_qty');

		$items_id = $this->input->post('all_items_id');

		$rema_reqmasterid = $this->input->post('rema_reqmasterid');

		$rema_reqno = $this->input->post('rema_reqno');

		$recommendation_status = $this->input->post('recommendation_status');

		$trans = $this->stock_requisition_mdl->verify_recommend_qty($items_id, $recommend_qty, $rema_reqmasterid, $recommendation_status);

		if ($trans) {

			//Send Message

			if ($recommendation_status == 'A') {

				$recomm_status = "accepted";
			} else {

				$recomm_status = "declined";
			}

			$get_post_by = $this->general->get_tbl_data('rema_recommendby', 'rema_reqmaster', array('rema_reqmasterid' => $rema_reqmasterid));

			$mess_userid = !empty($get_post_by[0]->rema_recommendby) ? $get_post_by[0]->rema_recommendby : 0;

			$msg_params = array(

				'DEMAND_NO' => $rema_reqno,

				'TO_USERID' => $mess_userid,

				'RECOMMEND_STATUS' => $recomm_status

			);

			$this->general->send_message_params('verify_recommend_qty', $msg_params);

			print_r(json_encode(array('status' => 'success', 'message' => 'Recommend qty was submitted.')));

			exit;
		} else {

			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));

			exit;
		}
	}

	public function proceed_to_issue()
	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$items_id = $this->input->post('itemlist');

			$rema_reqmasterid = $this->input->post('masterid');

			$status = '1';

			foreach ($items_id as $key => $item) {

				$itemArray = array(

					'rede_proceedissue' => 'Y',

					'rede_proceedtype' => 'I'

				);

				$this->db->where('rede_reqmasterid', $rema_reqmasterid);

				$this->db->where('rede_itemsid', $items_id[$key]);

				$this->db->update('rede_reqdetail', $itemArray);
			}

			$trans  = $this->stock_requisition_mdl->process_issue($status);

			if ($trans) {

				$approve_data = $this->data['approve_data'] = $this->general->get_tbl_data('*', 'rema_reqmaster', array('rema_reqmasterid' => $rema_reqmasterid), 'rema_reqmasterid', 'DESC');

				$rema_reqno = !empty($approve_data[0]->rema_reqno) ? $approve_data[0]->rema_reqno : '';

				$mess_user = array('BM');

				$message = "Issue Request No. $rema_reqno generated.";

				$mess_title = $mess_message = $message;

				$mess_path = 'issue_consumption/stock_requisition/requisition_list';

				$this->general->send_message_to_user($mess_user, $mess_title, $mess_message, $mess_path, 'G');

				print_r(json_encode(array('status' => 'success', 'message' => 'Record Save Successfully')));

				exit;
			} else {

				print_r(json_encode(array('status' => 'error', 'message' => 'Operation Error')));

				exit;
			}
		} else {

			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));

			exit;
		}
	}

	public function proceed_to_procurement()
	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$rema_reqno = $this->input->post('rema_reqno');
			$itemid = $this->input->post('itemlist');
			$masterid = $this->input->post('masterid');
			$chk_for_unknown_item = $this->db->select('itli_materialtypeid')
				->from('itli_itemslist')
				->where_in('itli_itemlistid', $itemid)
				->where('itli_materialtypeid', 3)
				->get()->result();

			// echo "<pre>";
			// print_r($this->input->post());
			// die();
			if (!empty($chk_for_unknown_item)) {

				print_r(json_encode(array('status' => 'error', 'message' => 'Unknown Item Could not be Process to Procurement, Please make change to known items !! ')));
				exit;
			}
			$check_for_req_for_procurement = $this->db->select('pure_reqmasterid')
				->from('pure_purchaserequisition')
				->where('pure_reqmasterid', $masterid)
				->get()->result();

			if (!empty($check_for_req_for_procurement)) {

				print_r(json_encode(array('status' => 'error', 'message' => 'You have already processed to procurement !! ')));
				exit;
			}

			$trans  = $this->stock_requisition_mdl->proceed_to_procurement();

			if ($trans) {

				// send message to proceed to procurement

				$msg_params = array(

					'DEMAND_NO' => $rema_reqno,

					'PROCUREMENT_NO' => $trans

				);

				$this->general->send_message_params('proceed_to_procurement', $msg_params);

				print_r(json_encode(array('status' => 'success', 'message' => 'Record Save Successfully')));

				exit;
			} else {

				print_r(json_encode(array('status' => 'error', 'message' => 'Operation Error')));

				exit;
			}
		} else {

			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));

			exit;
		}
	}

	public function send_to_it_department()
	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$trans  = $this->stock_requisition_mdl->send_to_it_department_change_status();

			if ($trans) {

				print_r(json_encode(array('status' => 'success', 'message' => 'Record Save Successfully')));

				exit;
			} else {

				print_r(json_encode(array('status' => 'error', 'message' => 'Operation Error')));

				exit;
			}
		} else {

			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));

			exit;
		}
	}

	public function proceed_to_account()
	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$trans  = $this->stock_requisition_mdl->proceed_to_account();

			if ($trans) {

				// send message to proceed to procurement

				$mess_user = array('PR');

				$message = "Procurement Request No. $trans generated.";

				$mess_title = $mess_message = $message;

				$mess_path = 'issue_consumption/stock_requisition/requisition_list';

				$this->general->send_message_to_user($mess_user, $mess_title, $mess_message, $mess_path, 'G');

				print_r(json_encode(array('status' => 'success', 'message' => 'Record Save Successfully')));

				exit;
			} else {

				print_r(json_encode(array('status' => 'error', 'message' => 'Operation Error')));

				exit;
			}
		} else {

			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));

			exit;
		}
	}

	public function submit_it_recommendation()
	{

		// echo "check";

		// die();

		$rede_itrecommend = $this->input->post('rede_itrecommend');

		$rede_itcomment = $this->input->post('rede_itcomment');

		$items_id = $this->input->post('all_items_id');

		$rema_reqmasterid = $this->input->post('rema_reqmasterid');

		$rema_reqno = $this->input->post('rema_reqno');

		$recommendation_status = '2';

		$trans = $this->stock_requisition_mdl->submit_it_recommendation($items_id, $rede_itrecommend, $rede_itcomment, $rema_reqmasterid, $recommendation_status);

		if ($trans) {

			// Send Message back to supervisor

			$message = "Recommendation from IT Department for $rema_reqno was submitted.";

			$supervisor_id = $this->general->get_tbl_data('rema_reqto', 'rema_reqmaster', array('rema_reqmasterid' => $rema_reqmasterid));

			$mess_userid = $supervisor_id[0]->rema_reqto;

			$mess_title = $mess_message = $message;

			$mess_path = 'issue_consumption/stock_requisition/requisition_list';

			$this->general->send_message_to_user($mess_userid, $mess_title, $mess_message, $mess_path, 'S');

			print_r(json_encode(array('status' => 'success', 'message' => 'Recommend qty was submitted.')));

			exit;
		} else {

			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));

			exit;
		}
	}

	public function respond_issue_by_branch_manager()
	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$respond_type = $this->input->post('respond_type');

			if ($respond_type == 'approve') {

				$status = 2;
			} else {

				$status = 3;
			}

			$rema_reqmasterid = $this->input->post('masterid');

			$trans  = $this->stock_requisition_mdl->process_issue($status);

			if ($trans) {

				// print_r($issuedby);print_r($rema_reqno);die;

				$approve_data = $this->data['approve_data'] = $this->general->get_tbl_data('*', 'rema_reqmaster', array('rema_reqmasterid' => $rema_reqmasterid), 'rema_reqmasterid', 'DESC');

				$rema_reqno = !empty($approve_data[0]->rema_reqno) ? $approve_data[0]->rema_reqno : '';

				$message = "Demand  Req No. $rema_reqno has been approved By Branch manager can Issued.";

				$mess_user = array('SI');

				$mess_title = $mess_message = $message;

				$mess_path = 'issue_consumption/stock_requisition/requisition_list';

				$this->general->send_message_to_user($mess_user, $mess_title, $mess_message, $mess_path, 'G');

				print_r(json_encode(array('status' => 'success', 'message' => 'Issue request was approved.')));

				exit;
			} else {

				print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));

				exit;
			}
		} else {

			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));

			exit;
		}
	}

	public function requisition_vs_issue()

	{

		$this->data['tab_type'] = 'requisition_vs_issue';

		$seo_data = '';

		$this->data['fiscalyear'] = $this->general->get_tbl_data('*', 'fiye_fiscalyear', false, 'fiye_fiscalyear_id', 'ASC');

		$this->data['store'] = $this->general->get_tbl_data('*', 'eqty_equipmenttype', false, 'eqty_equipmenttypeid', 'ASC');

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

			->build('stock/v_stock_requisition', $this->data);
	}

	public function requisition_vs_issue_report()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			if (MODULES_VIEW == 'N') {

				print_r(json_encode(array('status' => 'error', 'message' => $this->general->permission_denial_message())));

				exit;
			}

			$template = $this->requisition_vs_issue_report_data();

			if (!empty($template)) {

				print_r(json_encode(array('status' => 'success', 'message' => 'Selected Successfully', 'template' => $template)));

				exit;
			} else {

				print_r(json_encode(array('status' => 'success', 'message' => 'No Record Found!!')));

				exit;
			}
		} else {

			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));

			exit;
		}
	}

	public function requisition_vs_issue_report_data()
	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$this->data['excel_url'] = "issue_consumption/stock_requisition/generate_requisition_vs_issue_report_excel";

			$this->data['pdf_url'] = "issue_consumption/stock_requisition/generate_requisition_vs_issue_report_pdf";

			$this->data['report_title'] = "Requisition VS Issue Report";

			$frmDate = $this->input->post('fromdate');

			$toDate = $this->input->post('todate');

			$locationid = $this->input->post('locationid');

			$fyear = $this->input->post('fyear');

			// echo "<pre>";

			// print_r($fiscalyear);

			// die();

			$this->data['get_req_data'] = $this->stock_requisition_mdl->requisition_vs_issue_list('requisition_vs_issue');

			if ($this->location_ismain == 'Y') {

				if ($locationid) {

					$this->data['location'] = $this->general->get_tbl_data('loca_name', 'loca_location', array('loca_locationid' => $locationid));
				} else {

					$this->data['location'] = 'All';
				}
			} else {

				$this->data['location'] = $this->general->get_tbl_data('loca_name', 'loca_location', array('loca_locationid' => $this->locationid));
			}

			if ($fyear) :

				$this->data['fyear'] = $this->general->get_tbl_data('rema_fyear', 'rema_reqmaster', array('rema_fyear' => $fyear));

			else :

				$this->data['fyear'] = 'All';

			endif;

			if (!empty($this->data['get_req_data'])) {

				$template = $this->load->view('stock/v_requisition_vs_issue_list', $this->data, true);
			} else {

				$template = '<span class="col-sm-12 alert alert-danger text-center">No Record Found!!!</span>';
			}

			return $template;
		} else {

			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));

			exit;
		}
	}

	public function generate_requisition_vs_issue_report_pdf()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$html = $this->requisition_vs_issue_report_data();

			$filename = 'requisition_vs_issue_' . date('Y_m_d_H_i_s') . '_.pdf';

			$pdfsize = 'A4-L'; //A4-L for landscape

			//if save and download with default filename, send $filename as parameter

			$this->general->generate_pdf($html, '', '');

			exit();
		} else {

			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));

			exit;
		}
	}

	public function generate_requisition_vs_issue_report_excel()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			header("Content-Type: application/xls");

			header("Content-Disposition: attachment; filename=requisition_vs_issue_report_" . date('Y_m_d_H_i') . ".xls");

			header("Pragma: no-cache");

			header("Expires: 0");

			$response = $this->requisition_vs_issue_report_data();

			if ($response) {

				echo $response;
			}

			return false;
		} else {

			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));

			exit;
		}
	}

	public function confirm_demand_item_receive()
	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$reqno = $this->input->post('id');

			$fiscal_year = $this->input->post('fiscal_year');

			// print_r($reqno);die;

			$trans = $this->stock_requisition_mdl->change_receive_status_item_accepted($reqno, $fiscal_year);

			// print_r($trans);die;

			if ($trans) {

				print_r(json_encode(array('status' => 'success', 'message' => 'Demanded Item received Successfully')));
			} else {

				print_r(json_encode(array('status' => 'error', 'message' => 'Demanded Item received failed !!')));
			}
		} else {

			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));

			exit;
		}
	}

	public function confirm_demand_item_reject()
	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$reqno = $this->input->post('id');

			$fiscal_year = $this->input->post('fiscal_year');

			// print_r($reqno);die;

			$trans = $this->stock_requisition_mdl->change_receive_status_item_reject($reqno, $fiscal_year);

			// print_r($trans);die;

			if ($trans) {

				print_r(json_encode(array('status' => 'success', 'message' => 'Demanded Item Reject Successfully')));
			} else {

				print_r(json_encode(array('status' => 'error', 'message' => 'Demanded Item received failed !!')));
			}
		} else {

			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));

			exit;
		}
	}

	public function add_item_code()

	{

		$this->stock_view_group = array('1');

		$this->unknown = 'Y';

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			try {

				$id = $this->input->post('id');

				$this->data = array();

				$this->data['rowno'] = $this->input->post('id');

				$this->data['storeid'] = $this->input->post('storeid');

				$this->data['reqdetail_data'] = $this->stock_requisition_mdl->get_requisition_details_data(array('rd.rede_reqdetailid' => $id, 'rd.rede_isdelete' => 'N'));

				// print_r( $this->data['reqdetail_data']);die;

				$tempform = '';

				$tempform .= $this->load->view('stock/kukl/add_item_code_popup', $this->data, true);

				$tempform .= $this->load->view('stock_inventory/item/v_item_list_popup_stock_requisition', $this->data, true);

				if ($tempform) {

					print_r(json_encode(array('status' => 'success', 'message' => 'Selected Successfully', 'tempform' => $tempform)));

					exit;
				} else {

					print_r(json_encode(array('status' => 'error', 'message' => 'Operation Unsuccessful')));

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

	public function list_item_with_stock_requisition()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			// echo $storeid;

			// die();

			$this->data = array();

			$this->data['rowno'] = $this->input->post('id');

			$this->data['storeid'] = $this->input->post('storeid');

			// if(MODULES_VIEW=='N')

			// 	{

			// 	$this->general->permission_denial_message();

			// 	exit;

			// 	}

			$template = '';

			$template = $this->load->view('item/v_item_list_popup_stock_requisition', $this->data, true);

			print_r(json_encode(array('status' => 'success', 'message' => 'Successfully Selected!!', 'template' => $template, 'tempform' => $template)));

			exit;
		} else {

			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));

			exit;
		}
	}

	public function update_itemcode()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$code = $this->input->post('itli_itemcode');

			$id = $this->input->post('id');

			$this->data['reqdetail_data'] = $this->stock_requisition_mdl->get_requisition_details_data(array('rd.rede_reqdetailid' => $id, 'rd.rede_isdelete' => 'N'));

			if ($code == '') {

				print_r(json_encode(array('status' => 'error', 'message' => 'You must need to add item code!!! ')));

				exit;
			}

			// $code_val=$this->data['reqdetail_data'][0]->itli_itemcode;

			$this->data['check_code'] = $this->stock_requisition_mdl->item_code_exit($code);

			if ($this->data['check_code']) {

				$itemid = $this->data['check_code'][0]->itli_itemlistid;

				$trans = $this->stock_requisition_mdl->item_code_update($code, $id, $itemid);

				if ($trans == true) {

					print_r(json_encode(array('status' => 'success', 'message' => 'Record save Successfully')));

					exit;
				} else {

					print_r(json_encode(array('status' => 'error', 'message' => ' Failed to save!!!')));

					exit;
				}
			} else {

				print_r(json_encode(array('status' => 'error', 'message' => 'Item code not found !!! ')));

				exit;
			}
		} else {

			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));

			exit;
		}
	}

	public function check_history()
	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$id = $this->input->post('id');

			$reqno = $this->input->post('reqno');

			$fyear = $this->input->post('fyear');

			// $pur_data = $this->general->get_tbl_data('pure_purchasereqid','pure_purchaserequisition',array('pure_fyear'=>$fyear,'pure_streqno'=>$reqno));

			// $pur_masterid = !empty($pur_data[0]->pure_purchasereqid)?$pur_data[0]->pure_purchasereqid:0;

			// $hnd_data = $this->general->get_tbl_data('harm_handovermasterid','harm_handoverreqmaster',array('harm_fyear'=>$fyear,'harm_reqno'=>$reqno));

			// $hnd_masterid = !empty($hnd_data[0]->harm_handovermasterid)?$hnd_data[0]->harm_handovermasterid:0;

			$this->data['history_data'] = $this->general->get_history_data($id, $reqno, $fyear);

			$this->data['last_action'] = end($this->data['history_data']);

			$this->data['prev_action'] = prev($this->data['history_data']);

			$template = $this->load->view('stock/' . REPORT_SUFFIX . '/v_history', $this->data, true);

			if ($template) {

				print_r(json_encode(array('status' => 'success', 'tempform' => $template, 'message' => 'Successfully Selected')));

				exit;
			} else {

				print_r(json_encode(array('status' => 'success', 'tempform' => '', 'message' => 'Empty Record')));

				exit;
			}
		} else {

			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));

			exit;
		}
	}

	public function proceed_to_issue_items()
	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$req_masterid = $this->input->post('masterid');

			$trans = $this->new_issue_mdl->save_issue_items($req_masterid);

			if ($trans) {

				$this->new_issue_mdl->insert_api_data_locally($trans);

				if (defined('RUN_API') && RUN_API == 'Y') :

					if (defined('API_CALL')) :

						if (API_CALL == 'KUKL') {

							// $this->load->module('api/Api_kukl');

							// $this->Api_kukl->post_api_import_asset_with_issueno($trans);

							$this->new_issue_mdl->post_api_import_asset_with_issueno($trans);
						}

					endif;

				endif;

				$get_postby = $this->general->get_tbl_data('rema_postby', 'rema_reqmaster', array('rema_reqmasterid' => $req_masterid));

				$reqby = !empty($get_postby[0]->rema_postby) ? $get_postby[0]->rema_postby : 0;

				$rema_reqno = $this->input->post('rema_reqno');

				// SEND MESSAGE TO DEMANDER

				$msg_params = array(

					'DEMAND_NO' => $rema_reqno,

					'TO_USERID' => $reqby

				);

				$this->general->send_message_params('proceed_to_issue_items', $msg_params);

				$this->general->saveActionLog('sama_salemaster', $trans, $this->userid, 'RC', 'sama_receivedstatus');

				print_r(json_encode(array('status' => 'success', 'tempform' => $trans, 'message' => 'Successfully Selected')));

				exit;
			} else {

				print_r(json_encode(array('status' => 'success', 'tempform' => '', 'message' => 'Empty Record')));

				exit;
			}
		} else {

			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));

			exit;
		}
	}

	public function inform_item_available()
	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$items_id = $this->input->post('itemlist');

			$rema_reqmasterid = $this->input->post('masterid');

			$reqdetailid = $this->input->post('reqdetailid');

			$trans = $this->stock_requisition_mdl->inform_item_available($items_id, $reqdetailid, $rema_reqmasterid);

			$rema_reqno = $this->input->post('rema_reqno');

			if ($trans) {

				//Send Message

				$message = "Item is available Req No. $rema_reqno. Please resubmit the demand form.";

				$get_post_by = $this->general->get_tbl_data('rema_postby', 'rema_reqmaster', array('rema_reqmasterid' => $rema_reqmasterid));

				$mess_userid = !empty($get_post_by[0]->rema_postby) ? $get_post_by[0]->rema_postby : 0;

				$mess_title = $mess_message = $message;

				$mess_path = 'issue_consumption/stock_requisition/requisition_list';

				$this->general->send_message_to_user($mess_userid, $mess_title, $mess_message, $mess_path, 'S');

				print_r(json_encode(array('status' => 'success', 'message' => 'Inform Action Successful.')));

				exit;
			} else {

				print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));

				exit;
			}
		} else {

			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));

			exit;
		}
	}

	/* End KUKL */

	public function stock_vs_demand_analysis()
	{

		echo "asd";

		die();
	}

	public function undo_last_action()
	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$last_action = $this->input->post('lastaction');

			$prev_action = $this->input->post('prevaction');

			// echo "<pre>";

			// print_r($last_action);

			// print_r($prev_action);

			// die();

			$last_fieldname = $last_action['fieldname'];

			$last_tablename = $last_action['tablename'];

			$last_masterid = $last_action['masterid'];

			$prev_fieldname = $prev_action['fieldname'];

			$prev_status = $prev_action['status'];

			$default_status = NULL;

			if ($last_fieldname == $prev_fieldname) {

				$change_status = $prev_status;
			} else {

				$change_status = $default_status;
			}

			$change_array = array(

				$last_fieldname => $change_status

			);

			switch ($last_tablename) {

				case 'rema_reqmaster':

					$master_field = 'rema_reqmasterid';

					break;

				case 'pure_purchaserequisition':

					$master_field = 'pure_purchasereqid';

					break;
			}

			$this->db->trans_begin();

			$update = $this->db->update($last_tablename, $change_array, array($master_field => $last_masterid));

			$this->general->saveActionLog($last_tablename, $last_masterid, $this->userid, $change_status, $last_fieldname, 'Last Action Undone.');

			$this->db->trans_complete();

			if ($this->db->trans_status() === FALSE) {

				$this->db->trans_rollback();

				print_r(json_encode(array('status' => 'success', 'message' => 'Empty Record')));

				exit;
			} else {

				$this->db->trans_commit();

				print_r(json_encode(array('status' => 'success', 'message' => 'Last Action Was Successfully Undone.')));

				exit;
			}
		} else {

			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));

			exit;
		}
	}

	public function check_budget_category()
	{
		try {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$cur_fiscalyear = CUR_FISCALYEAR;
				$fiscal_array = explode('/', $cur_fiscalyear);
				$formatted_fiscalyear = '2' . $fiscal_array[0] . '.0' . $fiscal_array[1];

				$catid = $this->input->post('cat_id');
				$buheadid = $this->input->post('bhead');
				$reqdid = $this->input->post('reqdid');
				$sub_cat_id = $this->input->post('sub_cat_id');

				$location_code = '';
				$budget_code = '';
				$account_code = '';

				$location_data = $this->db->select('loca_accountcode')->from('loca_location')->where('loca_locationid', $this->locationid)->get()->row();
				if (!empty($location_data)) {
					$location_code = $location_data->loca_accountcode;
				}

				$budget_data = $this->db->select('buhe_accountid')->from('buhe_bugethead')->where('buhe_bugetheadid', $buheadid)->get()->row();
				if (!empty($budget_data)) {
					$budget_code = $budget_data->buhe_accountid;
				}

				$account_data = $this->db->select('acty_accode')->from('acty_accounttype')->where('acty_id', $catid)->get()->row();
				if (!empty($account_data)) {
					$account_code = $account_data->acty_accode;
				}

				if ($budget_code == 9) {
					$account_code = $catid;	
				}

				$api_response = '';

				if (defined('RUN_API') && RUN_API == 'Y') {
					if (defined('API_CALL') && API_CALL == 'KUKL') {
						// for testing purpose only
						// $location_code = 50;
						$api_response = $this->check_for_budget($location_code, $formatted_fiscalyear, $budget_code, $account_code,$sub_cat_id);
						// print_r($api_response);die;
					}
				}
				$this->db->select("rede_reqdetailid, rede_reqmasterid, rede_totalamt, purd_estimatetotal,rede_itemsid, itli_itemname, rema_reqdatead, rema_reqdatebs,rema_reqno,rema_locationid");
				$this->db->from('rede_reqdetail rd');
				$this->db->join('rema_reqmaster rm', 'rm.rema_reqmasterid = rd.rede_reqmasterid', 'LEFT');
				$this->db->join('purd_purchasereqdetail pd', 'rd.rede_reqdetailid = pd.purd_reqdetailid', 'LEFT');
				$this->db->join('itli_itemslist il', 'il.itli_itemlistid = rd.rede_itemsid', 'LEFT');
				$this->db->where('rede_reqdetailid', $reqdid);
				$requsition_detail = $this->db->get()->row();
				if ($api_response && $requsition_detail) {
					// sleep(1);	
					$req_masterid = $requsition_detail->rede_reqmasterid;
					// Check for record in database
					$this->db->select('id, SUM(block_amount) as block_amount');
					$this->db->from('api_budgetexpense');
					$this->db->where('budget_headid', $buheadid);
					$this->db->where('budget_categoryid', $catid);
					$this->db->where('req_masterid', $req_masterid);
					$this->db->where('req_detailid !=', $reqdid);
					if (!empty($sub_cat_id)) {
						$this->db->where('subsidiary_account_code', $sub_cat_id);
					}
					$this->db->where('status', 'P');
					$this->db->where('locationid', $this->locationid);
					$this->db->where('orgid', $this->orgid);
					$this->db->group_by('req_masterid');
					$previous_expenses = $this->db->get()->row();

					// echo $this->db->last_query();

					$block_amount = $previous_expenses->block_amount ?? 0;
					$usable_budget = $api_response->usable_Amount ?? 0;

					$estimate_amount = !empty($requsition_detail->purd_estimatetotal) ? $requsition_detail->purd_estimatetotal : 0;

					$total_expense = $estimate_amount + $block_amount;

					$actual_usable_budget = $usable_budget - $block_amount;

					$actual_remaning_amount = $usable_budget - $total_expense;

					if ($total_expense > $usable_budget) {
						print_r(json_encode(array('status' => 'success', 'message' => '', 'template' => '<span class="badge badge-sm badge-danger">Not Available</span>', 'isbug_avl' => 'N', 'budget_amount' => $usable_budget)));
						exit;
					} else {

						$this->db->select('*');
						$this->db->from('api_budgetexpense');
						$this->db->where('budget_headid', $buheadid);
						$this->db->where('budget_categoryid', $catid);
						$this->db->where('req_detailid', $reqdid);
						$this->db->where('fiscal_year', $formatted_fiscalyear);
						$this->db->where('status', 'P');
						if (!empty($sub_cat_id)) {
							$this->db->where('subsidiary_account_code', $sub_cat_id);
						}
						$this->db->where('locationid', $this->locationid);
						$this->db->where('orgid', $this->orgid);
						$previous_record = $this->db->get()->row();

						$expense_data = array(
							'req_masterid' => $requsition_detail->rede_reqmasterid,
							'req_detailid' => $requsition_detail->rede_reqdetailid,
							'demand_no' => $requsition_detail->rema_reqno,
							'req_datead' => $requsition_detail->rema_reqdatead,
							'req_datebs' => $requsition_detail->rema_reqdatebs,
							'item_id' => $requsition_detail->rede_itemsid,
							'item_description' => $requsition_detail->itli_itemname,
							'location_id' => $requsition_detail->rema_locationid,
							'fiscal_year' => $formatted_fiscalyear,
							'budget_headid' => $buheadid,
							'budget_id' => $api_response->budget_Id,
							'cost_centerid' => $budget_code,
							'budget_categoryid' => $catid,
							'account_code' => $account_code,
							'subsidiary_account_code' => $sub_cat_id,
							'office_code' => $location_code,
							'api_usable_budget' => $usable_budget,
							'usable_budget' => $actual_usable_budget,
							'block_amount' => $estimate_amount,
							'remaning_blocked_amount' => $estimate_amount,
							'remaning_amount' => $actual_remaning_amount,
						);

						if ($previous_record) {
							$db_id = $previous_record->id;
							$expense_data['modifydatead'] = CURDATE_EN;
							$expense_data['modifydatebs'] = CURDATE_NP;
							$expense_data['modifytime'] = $this->curtime;
							$expense_data['modifyby'] = $this->userid;
							$expense_data['modifymac'] = $this->mac;
							$expense_data['modifyip'] = $this->ip;

							$this->db->where('id', $db_id);
							$this->db->update('api_budgetexpense', $expense_data);
							$api_expense_id = $db_id;
						} else {
							$expense_data['postdatead'] = CURDATE_EN;
							$expense_data['postdatebs'] = CURDATE_NP;
							$expense_data['posttime'] = $this->curtime;
							$expense_data['postby'] = $this->userid;
							$expense_data['postmac'] = $this->mac;
							$expense_data['postip'] = $this->ip;
							$expense_data['locationid'] = $this->locationid;
							$expense_data['orgid'] = $this->orgid;
							$this->db->insert('api_budgetexpense', $expense_data);
							$api_expense_id = $this->db->insert_id();
						}
						print_r(json_encode(array('status' => 'success', 'message' => '', 'template' => '<span class="badge badge-sm badge-success">Available</span>', 'isbug_avl' => 'Y', 'budget_amount' => $usable_budget, 'api_expense_id' => $api_expense_id)));

						exit;
					}
				} else {
					print_r(json_encode(array('status' => 'success', 'message' => '', 'template' => '<span class="badge badge-sm badge-danger">Not Available</span>', 'isbug_avl' => 'N', 'budget_amount' => 0, 'api_expense_id' => '')));
					exit;
				}

				// 	$this->db->select('budg_availableamt');

				// 	$this->db->from('budg_budgets');

				// 	$this->db->where(array('budg_catid' => $catid, 'budg_budgetheadid' => $buheadid));

				// 	$this->db->where(array('budg_fyear' => $cur_fiscalyear));

				// 	$reqid = $this->input->post('reqdid');

				// 	$result = $this->db->get()->row();

				// 	if ($result) {

				// 		$available_amt = $result->budg_availableamt;

				// 		if ($available_amt > 0.00) {

				// 			print_r(json_encode(array('status' => 'success', 'message' => '', 'template' => '<span class="badge badge-sm badge-success">Available</span>', 'isbug_avl' => 'Y')));

				// 			exit;
				// 		}
				// 	}

				// 	print_r(json_encode(array('status' => 'success', 'message' => '', 'template' => '<span class="badge badge-sm badge-danger">Not Available</span>', 'isbug_avl' => 'N')));

				// 	exit;
			} else {

				print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));

				exit;
			}
		} catch (Exception $e) {
			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		}
	}

	public function save_budget_category()
	{
		try {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {

				$catid = $this->input->post('cat_id');

				$buheadid = $this->input->post('bhead');
				$subs_cat=$this->input->post('subs_cat');

				$reqdid = $this->input->post('reqdid');

				$isbug_avl = $this->input->post('isbug_avl');

				$api_expense_id = $this->input->post('api_expense_id');
				// echo "<pre>";
				// print_r($this->input->post());
				// die();

				if ($isbug_avl == 'N' && empty($api_expense_id)) {

					print_r(json_encode(array('status' => 'error', 'message' => 'Budget is not Available', 'template' => '')));

					exit;
				}

				// return false;

				$updateparam = array('rede_budgetheadid' => $buheadid, 'rede_catid' => $catid, 'rede_isbudgetavl' => $isbug_avl);
				if($buheadid == 4){
					$updateparam['rede_subcatid']=$subs_cat;
				}

				if (defined('RUN_API') && RUN_API == 'Y') {
					if (defined('API_CALL') && API_CALL == 'KUKL') {
						if (!$api_expense_id) {
							print_r(json_encode(array('status' => 'error', 'message' => 'Error while saving data', 'template' => '')));
							exit;
						}
						
						$this->db->where('id', $api_expense_id);
						$this->db->where('status', 'P');
						$this->db->where('locationid', $this->locationid);
						$this->db->where('orgid', $this->orgid);
						$this->db->from('api_budgetexpense');
						$expense_data = $this->db->get()->row();

						if (!$expense_data) {
							print_r(json_encode(array('status' => 'error', 'message' => 'Error while saving data, no expense data found', 'template' => '')));
							exit;
						}
						$post_data = array(
							"Budget_id" => $expense_data->budget_id,
							"Amount" => (float)($expense_data->remaning_blocked_amount ?: 0),
							"r_Status" => "H",
							"Entry_By" => $this->username,
							"Entry_Date" => str_replace('/', '.', CURDATE_NP),
							"Req_MasterId" => $expense_data->req_masterid,
							"req_detailId" => $expense_data->req_detailid,
							"Item_Description" => $expense_data->item_description,
							"Rem_Amount" => 0,
							"Req_DateEn" => str_replace('/', '.', $expense_data->req_datead),
							"Req_DateNp" => str_replace('/', '.', $expense_data->req_datebs),
							"Office_code" => $expense_data->office_code,
							"Demand_No" => $expense_data->demand_no,
							"Fyear" => $expense_data->fiscal_year,
							"Updated_Date" => null,
							"Updated_Time" => null,
							"Updated_By" => null,
							"Entrytime" => $this->curtime,
							"Remarks" => 'Hold Amount',
							"insUp" => "INS"
						);
						// print_r($post_data);
						// die();

						if ($this->general->api_send_budget_demand_amount($post_data)) {

							$this->db->where('id', $api_expense_id);
							$this->db->where('locationid', $this->locationid);
							$this->db->where('orgid', $this->orgid);
							$this->db->update('api_budgetexpense', array('status' => 'O'));
						} else {

							print_r(json_encode(array('status' => 'error', 'message' => 'Error while saving data, api error', 'template' => '')));
							exit;
						}

						if ($this->db->update('rede_reqdetail', $updateparam, array('rede_reqdetailid' => $reqdid))) {

							print_r(json_encode(array('status' => 'success', 'message' => '', 'template' => '<span class="badge badge-sm badge-success">Saved</span>')));

							exit;
						} else {

							print_r(json_encode(array('status' => 'error', 'message' => 'Error while saving data', 'template' => '')));

							exit;
						}
					}
				} else {
					print_r(json_encode(array('status' => 'error', 'message' => 'Api Function Not Enabled')));

					exit;
				}
			} else {

				print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));

				exit;
			}
		} catch (Exception $e) {
			print_r(json_encode(array('status' => 'error', 'message' => 'Api Error')));
			exit;
		}
	}

	public function get_subsidiary_account()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$cat_id = $this->input->post('cat_id');
			$bhead = $this->input->post('bhead');
			$location_code = '';
			$budget_code = '';
			$account_code = '';
			// $this->locationid=15;
			// echo $this->locationid;
			// die();
			$location_data = $this->db->select('loca_accountcode')->from('loca_location')->where('loca_locationid', $this->locationid)->get()->row();
			if (!empty($location_data)) {
				$location_code = $location_data->loca_accountcode;
			}

			$budget_data = $this->db->select('buhe_accountid')->from('buhe_bugethead')->where('buhe_bugetheadid', $bhead)->get()->row();
			if (!empty($budget_data)) {
				$budget_code = $budget_data->buhe_accountid;
			}

			$account_data = $this->db->select('acty_accode')->from('acty_accounttype')->where('acty_id', $cat_id)->get()->row();
			if (!empty($account_data)) {
				$account_code = $account_data->acty_accode;
			}

			if($budget_code==9){
				$account_code=$cat_id;
			}
			// echo 'Loc'.$location_code;
			// echo "--<br>";
			// echo 'Acc'.$account_code;
			// die();
			if (defined('RUN_API') && RUN_API == 'Y') {
				if (defined('API_CALL') && API_CALL == 'KUKL') {
					if ($location_code && $account_code) {
						$api_url = "http://api.kathmanduwater.com:8085/api/InventoryService/FetchSubsidiaryAccount/@ccessKuK!nv!ntegr@t!0n20!9/" . $location_code . '/'. $account_code;
						// echo $api_url;
						// die();
						$client = curl_init($api_url);
						curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
						$response = curl_exec($client);
						$response_data = json_decode($response);
						$httpcode = curl_getinfo($client, CURLINFO_HTTP_CODE);
						curl_close($client);
						if ($httpcode === 200 && is_array($response_data) && !empty($response_data)) {

							print_r(json_encode(array('status' => 'success','data'=>$response_data, 'message' => 'Record Fetched')));
							exit;
						}else{
							print_r(json_encode(array('status' => 'error', 'message' => 'Record empty')));
							exit;
						}
					}
				}
			}
			print_r(json_encode(array('status' => 'error', 'message' => 'Error While Fetching Data')));
			exit;
			
		} else {
			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));

			exit;
		}
		
	}

	public function cancel_budget_category()
	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$api_expense_id = $this->input->post('api_expense_id');
			$updateparam = array('status' => 'C');

			$this->db->where_in('id', $api_expense_id);
			$this->db->where('status', 'P');
			$this->db->update('api_budgetexpense', $updateparam);
			print_r(json_encode(array('status' => 'success')));
			exit;
		} else {
			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));

			exit;
		}
	}

	public function check_for_budget($office_code = 0, $fiscal_year = '', $costcenter_id = 0, $acc_code = 0, $subsidiary_catid = 0)
	{	
		// echo("office_code : $office_code <br>"); 
		// echo("fiscal_year : $fiscal_year <br>"); 
		// echo("costcenter_id : $costcenter_id <br>"); 
		// echo("acc_code : $acc_code <br>"); 
		// echo("subsidiary_catid : $subsidiary_catid <br>"); 
		// die();
		if ($office_code && $fiscal_year && $costcenter_id && $acc_code) {

			// $api_url = KUKL_API_URL.'BudgetService/KUKLBUDGETVALUE'.KUKL_API_KEY.'/'.$office_code.'/'.$fiscal_year.'/'.$costcenter_id.'/'.$acc_code;
			$api_url = "http://api.kathmanduwater.com:8085/api/BudgetService/KUKLBUDGETVALUE/@ccessKuK!nv!ntegr@t!0n20!0/" . $office_code . '/' . $fiscal_year . '/' . $costcenter_id . '/' . $acc_code;
			if ($subsidiary_catid) {
				$api_url .= "?subsidiary_acc_no=$subsidiary_catid";
			}
			// print_r($api_url);
			// die(); 			
			$client = curl_init($api_url);
			curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($client);
			$response_data = json_decode($response);
			$httpcode = curl_getinfo($client, CURLINFO_HTTP_CODE);
			curl_close($client);
			if ($httpcode === 200 && is_array($response_data)) {
				return $response_data[0];
			}
		}

		return false;
	}

	public function send_budget_demand_amount($post_data)
	{
		$api_url = "http://api.kathmanduwater.com:8085/api/BudgetDemand/BudgetDemand%40ccessKuK!nv!ntegr%40t!0n20!9/";
		$ch = curl_init($api_url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json-patch+json',
			'Content-Length: ' . strlen(json_encode($post_data))
		));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		$response = curl_exec($ch);
		$response_data = json_decode($response);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		if ($httpcode === 200) {
			return true;
		}

		return false;
	}

	public function request_for_operation()
	{
		// print_r($this->input->post());
		// die();
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$request_to = $this->input->post('request_to');
			$masterid = $this->input->post('masterid');
			$operation = $this->input->post('operation');
			if (empty($request_to)) {
				print_r(json_encode(array('status' => 'error', 'message' => 'Please select a user for request.')));
				exit;
			}
			$where_cond = [
				'aclo_tablename' => 'rema_reqmaster',
				'aclo_masterid' => $masterid,
				'aclo_fieldname' => 'rema_operation',
				'aclo_locationid' => $this->locationid,
				'aclo_orgid' => $this->orgid,
				'aclo_status' => $operation
			];

			$previous_data = $this->db->from('aclo_actionlog')->select('aclo_masterid')->where($where_cond)->get()->row();

			if (!empty($previous_data)) {
				print_r(json_encode(array('status' => 'error', 'message' => 'Request for operation already sent.')));

				exit;
			}

			$trans = $this->stock_requisition_mdl->request_for_operation();
			if ($trans) {

				print_r(json_encode(array('status' => 'success', 'message' => 'Record Saved Successfully.')));

				exit;
			} else {

				print_r(json_encode(array('status' => 'error', 'message' => 'Error While Saving.')));

				exit;
			}
		} else {

			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));

			exit;
		}
	}

	public function test_stock_requisition()
	{
		$id = 1;

		if ($id) {

			$requisition_data = $this->data['stock_requisition_details'] = $this->stock_requisition_mdl->get_requisition_master_data(array('rema_reqmasterid' => $id));

			//general->get_tbl_data('*','rema_reqmaster',array('rema_reqmasterid'=>$id),'rema_reqmasterid','DESC');

			// echo "<pre>";

			// print_r($requisition_data);

			// die();

			// need to check rede_proceedissue

			$this->data['stock_requisition'] = $this->stock_requisition_mdl->get_requisition_data(array('rd.rede_reqmasterid' => $id));

			// echo $this->db->last_query();

			// die();

			$this->data['user_signature'] = $this->general->get_signature($this->userid);

			$approvedby = $requisition_data[0]->rema_approvedid;

			$this->data['approver_signature'] = $this->general->get_signature($approvedby);

			//echo"<pre>";print_r($this->data['stock_requisition_details']);die();

			$req_date = !empty($stock_requisition_details[0]->rema_reqdatebs) ? $stock_requisition_details[0]->rema_reqdatebs : CURDATE_NP;

			$store_head_id = $this->general->get_store_post_data($req_date, 'store_head');

			$this->data['store_head_signature'] = $this->general->get_signature($store_head_id);

			$reqno = !empty($requisition_data[0]->rema_reqno) ? $requisition_data[0]->rema_reqno : '';

			$fyear = !empty($requisition_data[0]->rema_fyear) ? $requisition_data[0]->rema_fyear : '';

			// $this->data['user_list_for_report'] = $this->stock_requisition_mdl->get_user_list_for_report($reqno, $fyear);

			// for kukl

			if (ORGANIZATION_NAME == 'KUKL') :

				$pure_data = $this->data['check_budget_availability'] = $this->general->get_tbl_data('pure_isapproved, pure_purchasereqid', 'pure_purchaserequisition', array('pure_streqno' => $reqno, 'pure_fyear' => $fyear, 'pure_locationid' => $this->locationid));

				$pure_masterid = !empty($pure_data[0]->pure_purchasereqid) ? $pure_data[0]->pure_purchasereqid : '';

				$this->data['account_action_log'] = $this->general->get_username_from_actionlog(array('aclo_masterid' => $pure_masterid, 'aclo_tablename' => 'pure_purchaserequisition', 'aclo_fieldname' => 'pure_accountverify'));

			endif;

			// echo STOCK_REQ_REPORT_TYPE;

			// die();
			// echo REPORT_SUFFIX;
			// die();
			if (STOCK_REQ_REPORT_TYPE == 'DEFAULT') {

				$template = $this->load->view('stock/v_print_report_issue', $this->data, true);
			} else {

				$file_name = base_url('stock/v_print_report_issue' . '_' . REPORT_SUFFIX . '.php');

				if (file_exists($file_name)) //not working

				{
					// echo "Asasdsad";
					// die();
					$template = $this->load->view('stock/v_print_report_issue' . '_' . REPORT_SUFFIX, $this->data, true);
				} else {

					// echo "Asd";
					// die();
					$template = $this->load->view('stock/' . REPORT_SUFFIX . '/v_print_report_issue', $this->data, true);
				}
			}
			echo $template;
			die();

			if ($template) {

				print_r(json_encode(array('status' => 'success', 'message' => '', 'tempform' => $template)));

				exit;
			} else {

				print_r(json_encode(array('status' => 'error', 'message' => '')));

				exit;
			}

			print_r(json_encode(array('status' => 'success', 'message' => 'Successfully Selected!!', 'tempform' => $template)));

			exit;
		} else {

			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));

			exit;
		}
	}
}

/* End of file welcome.php */

/* Location: ./application/controllers/welcome.php */