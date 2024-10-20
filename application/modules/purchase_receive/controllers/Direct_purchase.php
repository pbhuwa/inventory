<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Direct_purchase extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->Model('direct_purchase_mdl');
		$this->load->Model('return_analysis_mdl');
		$this->load->Model('issue_consumption/challan_mdl');

		$this->storeid = $this->session->userdata(STORE_ID);
		$this->userid = $this->session->userdata(USER_ID);
		$this->locationid = $this->session->userdata(LOCATION_ID);
		if (defined('LOCATION_CODE')) :
			$this->locationcode = $this->session->userdata(LOCATION_CODE);
		endif;
		// $this->locationcode=$this->session->userdata(LOCATION_CODE);
		$this->location_ismain = $this->session->userdata(ISMAIN_LOCATION);
		$this->mattypeid = $this->session->userdata(USER_MAT_TYPEID);
		$this->userdept = $this->session->userdata(USER_DEPT);
		$this->usergroup = $this->session->userdata(USER_GROUPCODE);
		$this->show_location_group = array('SA', 'SK', 'SI');
	}

	public function index($reload = false)
	{
		$this->data['store_type'] = $this->general->get_tbl_data('*', 'store', false, 'st_store_id', 'ASC');
		$this->data['tab_type'] = 'entry';
		$this->data['fiscal'] = $this->general->get_tbl_data('*', 'fiye_fiscalyear', false, 'fiye_fiscalyear_id', 'DESC', '3');
		// $this->data['demand_type'] = $this->general->get_tbl_data('*','rety_receivetypestatys',false,'rety_receivetypeid','DESC');
		$this->data['distributor'] = $this->general->get_tbl_data('*', 'dist_distributors', false, 'dist_distributor', 'ASC');
		// $this->data['supplier_all'] = $this->general->get_tbl_data('*','dist_distributors',false,'dist_distributor','ASC');

		// echo "<pre>";print_r($this->data['budgets_list']);die();

		$this->data['department'] = $this->general->get_tbl_data('*', 'dept_department', array('dept_locationid' => $this->locationid), 'dept_depid', 'DESC');

		if (!empty($this->mattypeid)) {
			$srchmat = array('maty_materialtypeid' => $this->mattypeid, 'maty_isactive' => 'Y');
			$srchbudg = array('budg_materialtypeid' => $this->mattypeid);
		} else {
			$srchmat = array('maty_isactive' => 'Y');
			$srchbudg = '';
		}
		$this->data['material_type'] = $this->general->get_tbl_data('maty_materialtypeid,maty_material', 'maty_materialtype', $srchmat, 'maty_materialtypeid', 'ASC');

		$this->data['budgets_list'] = $this->general->get_tbl_data('*', 'budg_budgets', $srchbudg, 'budg_budgetname', 'ASC');

		$currentfyrs = CUR_FISCALYEAR;
		$locationid = $this->session->userdata(LOCATION_ID);

		$this->db->select('recm_invoiceno,recm_fyear')
			->from('recm_receivedmaster')
			->where('recm_locationid', $locationid);

		if (ORGANIZATION_NAME == 'KU') {
			if ($this->mattypeid) {
				$this->db->where('recm_mattypeid', $this->mattypeid);
			} else {
				$this->db->where('recm_mattypeid', 1);
			}
		}
		$cur_fiscalyrs_invoiceno = $this->db->order_by('recm_fyear', 'DESC')
			->limit(1)
			->get()->row();

		if (!empty($cur_fiscalyrs_invoiceno)) {
			$invoice_format = $cur_fiscalyrs_invoiceno->recm_invoiceno;

			$invoice_string = str_split($invoice_format);
			// echo "<pre>";
			// print_r($invoice_string);
			// die();
			$invoice_prefix_len = strlen(RECEIVED_NO_PREFIX);
			$chk_first_string_after_invoice_prefix = $invoice_string[$invoice_prefix_len];
			// echo $chk_first_string_after_invoice_prefix;
			// die();
			if ($chk_first_string_after_invoice_prefix == '0') {
				$invoice_no_prefix = RECEIVED_NO_PREFIX . CUR_FISCALYEAR;
			} else if ($cur_fiscalyrs_invoiceno->recm_fyear == $currentfyrs && $chk_first_string_after_invoice_prefix == '0') {
				$invoice_no_prefix = RECEIVED_NO_PREFIX . CUR_FISCALYEAR;
			} else if ($cur_fiscalyrs_invoiceno->recm_fyear != $currentfyrs && $chk_first_string_after_invoice_prefix == '0') {
				$invoice_no_prefix = RECEIVED_NO_PREFIX . CUR_FISCALYEAR;
			} else if ($cur_fiscalyrs_invoiceno->recm_fyear != $currentfyrs && $chk_first_string_after_invoice_prefix != '0') {
				$invoice_no_prefix = RECEIVED_NO_PREFIX . CUR_FISCALYEAR;
			} else {
				$invoice_no_prefix = RECEIVED_NO_PREFIX;
			}
		} else {
			$invoice_no_prefix = RECEIVED_NO_PREFIX . CUR_FISCALYEAR;
		}

		// $this->data['received_no']=$this->generate_receiveno();
		if (ORGANIZATION_NAME == 'KU' || ORGANIZATION_NAME=='ARMY' ||  ORGANIZATION_NAME=='PU') {
			$invoice_no_prefix = '';
			if ($this->mattypeid) {
				$mattypeid = $this->mattypeid;
			} else {
				$mattypeid = 1;
			}

			$this->data['received_no'] = $this->general->generate_invoiceno('recm_invoiceno', 'recm_invoiceno', 'recm_receivedmaster', $invoice_no_prefix, RECEIVED_NO_LENGTH, array('recm_mattypeid' => $mattypeid), 'recm_locationid', 'recm_fyear DESC ,recm_receivedmasterid  DESC', 'M', false, 'Y');
			// echo $this->db->last_query();
			// die();
		} else {
			$this->data['received_no'] = $this->general->generate_invoiceno('recm_invoiceno', 'recm_invoiceno', 'recm_receivedmaster', $invoice_no_prefix, RECEIVED_NO_LENGTH, false, 'recm_locationid', 'recm_fyear DESC ,recm_receivedmasterid  DESC', 'M');
		}

		// $this->data['received_no'] = $this->generate_receiveno();

		$seo_data = '';
		$this->data['direct_purchase'] = 'purchase_direct_entry';
		$this->data['purchased_data'] = '';
		$this->data['purchased_details'] = '';
		$this->data['challan_data'] = '';
		$this->data['challan_details'] = '';
		$id = $this->input->post('id');
		$mid = $this->input->post('mid');
		$pure_id = $this->input->post('pure_id');

		if ($mid) {
			$this->data['purchased_data']  = $this->general->get_tbl_data('*', 'chma_challanmaster', array('chma_challanmasterid' => $mid), 'chma_challanmasterid', 'ASC');
			$this->data['challan_details']  = $this->challan_mdl->chalandetails(array('chma_challanmasterid' => $mid));
		}
		if ($id) {
			$this->data['purchased_data']  = $this->general->get_tbl_data('*', 'recm_receivedmaster', array('recm_receivedmasterid' => $id), 'recm_receivedmasterid', 'ASC');
			$this->data['purchased_details']  = $this->direct_purchase_mdl->get_purcase_details(array('rm.recd_receivedmasterid' => $id));
			// $this->general->get_tbl_data('*','recd_receiveddetail',array('recd_receivedmasterid'=>$id),'recd_receivedmasterid','ASC');
			//echo"<pre>";print_r($this->data['purchased_details']);die;
		}

		if ($pure_id) {
			$mat_type_id = $this->input->post('mat_type_id');
			$this->data['purchased_data']  = $this->general->get_tbl_data('*', 'pure_purchaserequisition', array('pure_purchasereqid' => $pure_id), 'pure_purchasereqid', 'ASC');
			$this->data['purchased_details']  = $this->direct_purchase_mdl->get_purcase_req_details(array('rm.purd_reqid' => $pure_id, 'prld_mattypeid' => $mat_type_id));

		}

		// echo "<pre>";
		// 	print_r($this->data['purchased_data']);
		// 	die();
			
		if(!empty($this->data['purchased_data'] && count($this->data['purchased_data']))){
			$depid = !empty($this->data['purchased_data'][0]->recm_departmentid) ? $this->data['purchased_data'][0]->recm_departmentid : '';
			$school = !empty($this->data['purchased_data'][0]->recm_school) ? $this->data['purchased_data'][0]->recm_school : $this->locationid;
			$this->data['department'] = $this->general->get_tbl_data('*', 'dept_department', array('dept_locationid' => $school), 'dept_depid', 'ASC');

            $get_dept_data =  $this->general->get_tbl_data('*', 'dept_department', ['dept_depid' => $depid]);
                    
            if (count($get_dept_data) == 1) {
                $main_dep_data = $this->general->get_tbl_data('*', 'dept_department', ['dept_depid' => $get_dept_data[0]->dept_locationid]);
                if ($main_dep_data) {
                    $main_depid = $main_dep_data[0]->dept_depid;
                } else {
                    $main_depid = $depid;
                }
            }
            if ($depid != $main_depid){
            	$this->data['sub_department'] = $this->general->get_tbl_data('*', 'dept_department', ['dept_locationid' => $main_depid]);
            }
		}

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

		if ($reload == 'reload') {
			if (ORGANIZATION_NAME == 'KU' || ORGANIZATION_NAME == 'PU' ) {
				$this->load->view('purchase/ku/v_direct_purchase_form', $this->data);
			}
			else if (ORGANIZATION_NAME == 'ARMY') {
				$this->load->view('purchase/army/v_direct_purchase_form', $this->data);
			}

			 else if (ORGANIZATION_NAME == 'KUKL') {
				$this->load->view('purchase/kukl/v_direct_purchase_form', $this->data);
			} else {
				$this->load->view('purchase/v_direct_purchase_form', $this->data);
			}
		} else {

			$this->template
				->set_layout('general')
				->enable_parser(FALSE)
				->title($this->page_title)
				//->build('receive_against_order/v_against_order', $this->data);
				//->build('purchase/v_direct_purchase', $this->data);
				->build('purchase/v_direct_purchase_common_tab', $this->data);
		}
	}
	public function purchased_summary($type = false)
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$cond = $ret_cond = '';
			$frmDate = $this->input->post('frmdate');
			$toDate = $this->input->post('todate');
			$srchtext=$this->input->post('srchtext');
			// echo $srchtext;
			// die();
			// if(!empty($srchtext)){
			// 	$invoice_no=$srchtext;
			// }
			// echo $invoice_no;
			// die();
			
			$locationid = !empty($this->input->post('locationid')) ? $this->input->post('locationid') : 0;

			if ($locationid != 'false' || $locationid != 0) {
				$where_locationid = "AND recm_locationid = '$locationid'";
				$where_retlocationid = "AND purr_locationid = '$locationid'";
			} else {
				$where_locationid = "";
				$where_retlocationid = "";
			}

			if ($frmDate && $toDate) {
				if (DEFAULT_DATEPICKER == 'NP') {
					$cond = ("recm_receiveddatebs BETWEEN '$frmDate' AND'$toDate' $where_locationid");
					$ret_cond = ("purr_returndatebs BETWEEN '$frmDate' AND'$toDate' $where_retlocationid");
				} else {
					$cond = ("recm_receiveddatead BETWEEN '$frmDate' AND'$toDate' $where_locationid");
					$ret_cond = ("purr_returndatead BETWEEN '$frmDate' AND'$toDate' $where_retlocationid");
				}
			}
			$status_count = $this->direct_purchase_mdl->getStatusCount($cond,$srchtext);

			$return_count = $this->direct_purchase_mdl->getStatusCountReturn($ret_cond);
			// echo $this->db->last_query();
			// die();
			print_r(json_encode(array('status' => 'success', 'status_count' => $status_count, 'return_count' => $return_count)));
		}
	}
	public function direct_purchase_summary()
	{
		$seo_data = '';
		$this->data['direct_purchase'] = 'direct_purchase_summary';
		$frmDate = CURMONTH_DAY1;
		$toDate = CURDATE_NP;
		$cond = $ret_cond = '';

		if (ORGANIZATION_NAME == 'KUKL') {

			if ($frmDate) {
				$cond .= " WHERE recm_receiveddatebs >='" . $frmDate . "'";
			}
			if ($toDate) {
				$cond .= " AND recm_receiveddatebs <='" . $toDate . "'";
			} else {
				$cond .= " AND recm_receiveddatebs <='" . $frmDate . "'";
			}

			$this->data['status_count'] = $this->direct_purchase_mdl->getColorStatusCount($cond);
			$this->data['return_count'] = $this->direct_purchase_mdl->getStatusCountReturn($ret_cond);
		} else {

			$locationid = !empty($this->input->post('locationid')) ? $this->input->post('locationid') : 0;

			if ($locationid != 'false' || $locationid != 0) {
				$where_locationid = "AND recm_locationid = '$locationid'";
				$where_retlocationid = "AND purr_locationid = '$locationid'";
			} else {
				$where_locationid = "";
				$where_retlocationid = "";
			}

			if ($frmDate && $toDate) {
				if (DEFAULT_DATEPICKER == 'NP') {
					$cond = ("recm_receiveddatebs BETWEEN '$frmDate' AND'$toDate' $where_locationid");
					$ret_cond = ("purr_returndatebs BETWEEN '$frmDate' AND'$toDate' $where_retlocationid");
				} else {
					$cond = ("recm_receiveddatead BETWEEN '$frmDate' AND'$toDate' $where_locationid");
					$ret_cond = ("purr_returndatead BETWEEN '$frmDate' AND'$toDate' $where_retlocationid");
				}
			}

			$this->data['status_count'] = $this->direct_purchase_mdl->getStatusCount($cond);
			$this->data['return_count'] = $this->direct_purchase_mdl->getStatusCountReturn($ret_cond);
		}
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
			//->build('receive_against_order/v_against_order', $this->data);
			//->build('purchase/v_direct_purchase', $this->data);
			->build('purchase/v_direct_purchase_common_tab', $this->data);
	}
	public function direct_purchase_summary_list()
	{
		$apptype = $this->input->get('apptype');

		if (MODULES_VIEW == 'N') {
			$array = array();

			// $this->general->permission_denial_message();
			echo json_encode(array("recordsFiltered" => 0, "recordsTotal" => 0, "data" => $array));
			exit;
		}

		$useraccess = $this->session->userdata(USER_ACCESS_TYPE);
		// $srch = array();
		// if(!empty($this->mattypeid)){
		// 	$srch[] = array('recm_mattypeid' => $this->mattypeid);
		// }

		$i = 0;
		$srch = '';
		$data = $this->direct_purchase_mdl->get_direct_received_list_new($srch);
		if ($apptype == 'directreceived') {
			$srch = array('recm_purchasestatus' => 'D');
			if (!empty($this->mattypeid)) {
				$srch['recm_mattypeid'] = $this->mattypeid;
			}
			$data = $this->direct_purchase_mdl->get_direct_received_list_new($srch);
			// echo $this->db->last_query();
			// die();
		}
		if ($apptype == 'cancel') {
			$srch = array('recm_purchasestatus' => 'C');
			$data = $this->direct_purchase_mdl->get_direct_received_list_new($srch);
		}
		if ($apptype == 'returno') {
			//$srch = array('recm_purchasestatus'=>'R');
			
			$data = $this->direct_purchase_mdl->get_purchase_return_list_new();
		}
		if ($apptype == 'all') {
			$srch = array('recm_purchasestatus !=' => '');
			$data = $this->direct_purchase_mdl->get_direct_received_list_new($srch);
		}
		//echo"<pre>";print_r($data);die;

		// echo $this->db->last_query();
		// die();
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"] > 0 ? $data["totalfilteredrecs"] : $data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

		unset($data["totalfilteredrecs"]);
		unset($data["totalrecs"]);

		if ($apptype == 'returno') {
			foreach ($data as $row) {
				$appclass = 'returno';

				$array[$i]["approvedclass"] = $appclass;
				$array[$i]["sno"] = $i + 1;
				$array[$i]['recm_receiveddatebs'] = $row->purr_returndatebs;
				$array[$i]['recm_receiveddatead'] = $row->purr_returndatead;
				$array[$i]['recm_invoiceno'] = $row->purr_invoiceno;
				$array[$i]['orderno'] = $row->purr_returnno;
				$array[$i]['dist_distributor'] = $row->dist_distributor;
				//$array[$i]['budg_budgetname'] = $row->budg_budgetname;
				$array[$i]['recm_discount'] = $row->purr_discount;
				$array[$i]['recm_taxamount'] = $row->purr_vatamount;
				$array[$i]['recm_clearanceamount'] = $row->purr_returnamount;
				$array[$i]['recm_posttime'] = $row->purr_posttime;
				$array[$i]['recm_fyear'] = $row->purr_fyear;
				// $array[$i]['order_date'] = $row->orderdate;
				// $array[$i]['rate'] = $row->rate;
				// $array[$i]['vat'] = $row->vat;
				$array[$i]['recm_status'] = '';
				$array[$i]['recm_amount'] = $row->purr_returnamount;
				$array[$i]['action'] = '';
				$i++;
			}
		} else {
			foreach ($data as $row) {
				$appclass = '';
				$approved = $row->recm_purchasestatus;
				//  $color_codeclass=$this->general->get_color_code('*','coco_colorcode',array('coco_isactive'=>'Y','coco_listname'=>'direct_purchaselist','coco_isallorg'=>'Y'));
				//    foreach ($color_codeclass as $key => $color) {
				//  if($approved=$color->coco_statusval){
				//  	$appclass=$color->coco_statusname;
				//  }
				// }

				if ($approved == 'D') {
					$appclass = 'directreceived';
				}
				if ($approved == 'C') {
					$appclass = 'cancel';
				}
				if ($approved == 'R') {
					$appclass = 'returno';
				}
				$array[$i]["approvedclass"] = $appclass;
				$array[$i]["sno"] = $i + 1;
				$array[$i]['recm_receiveddatebs'] = $row->recm_receiveddatebs;
				$array[$i]['recm_receiveddatead'] = $row->recm_receiveddatead;
				$array[$i]['recm_invoiceno'] = $row->recm_invoiceno;
				$array[$i]['orderno'] = $row->orderno;
				$array[$i]['dist_distributor'] = $row->dist_distributor;
				//$array[$i]['budg_budgetname'] = $row->budg_budgetname;
				$array[$i]['recm_discount'] = $row->recm_discount;
				$array[$i]['recm_taxamount'] = $row->recm_taxamount;
				$array[$i]['recm_clearanceamount'] = $row->recm_clearanceamount;
				$array[$i]['recm_posttime'] = $row->recm_posttime;
				$array[$i]['recm_fyear'] = $row->recm_fyear;
				// $array[$i]['order_date'] = $row->orderdate;
				// $array[$i]['rate'] = $row->rate;
				// $array[$i]['vat'] = $row->vat;
				$array[$i]['recm_status'] = $row->recm_status;
				$array[$i]['recm_amount'] = $row->recm_amount;

				if (MODULES_UPDATE == 'Y') {
					$editbtn = '<a href="javascript:void(0)" data-id=' . $row->recm_receivedmasterid . ' data-displaydiv="directpurchase" data-viewurl=' . base_url('purchase_receive/direct_purchase') . ' class="redirectedit btn-info btn-xxs sm-pd"><i class="fa fa-edit"  title="Edit" aria-hidden="true" ></i></a>';
				} else {
					$editbtn = '';
				}

				$array[$i]['action'] = $editbtn . '' . '<a href="javascript:void(0)" data-id=' . $row->recm_receivedmasterid . ' data-displaydiv="" data-viewurl=' . base_url('purchase_receive/receive_against_order/direct_purchase_details') . ' class="view btn-primary btn-xxs sm-pd" data-heading="Direct Purchase Details"><i class="fa fa-eye" title="View" aria-hidden="true" ></i></a>';
				$i++;
			}
		}

		echo json_encode(array("recordsFiltered" => $filtereddata, "recordsTotal" => $totalrecs, "data" => $array));
		// echo $this->db->last_query();
		// die;
	}
	public function direct_purchase_details()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$mastid_id = $this->input->post('id');
			$this->data['req_detail_list'] = $this->direct_purchase_mdl->get_received_details(array('rd.recd_receivedmasterid' => $mastid_id, 'rm.recm_dstat' => 'D'));

			$this->data['direct_purchase_master'] = $this->direct_purchase_mdl->received_master_views(array('rm.recm_receivedmasterid' => $mastid_id));
			// echo "<pre>";print_r($this->data['req_detail_list']);die();
			$tempform = '';
			$tempform = $this->load->view('purchase/v_direct_purchase_details_modal', $this->data, true);
			if (!empty($tempform)) {
				print_r(json_encode(array('status' => 'success', 'message' => 'View Open Success', 'tempform' => $tempform)));
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
	public function direct_receive_reprint()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$id = $this->input->post('id');
				if ($id) {
					$this->data['req_detail_list'] = $this->direct_purchase_mdl->get_received_details(array('rd.recd_receivedmasterid' => $id, 'rm.recm_dstat' => 'D'));
					// echo $this->db->last_query();
					// die();
					$this->data['direct_purchase_master'] = $this->direct_purchase_mdl->received_master_views(array('rm.recm_receivedmasterid' => $id));

					//echo"<pre>";print_r($this->data['req_detail_list']);die();
					//$template=$this->load->view('purchase/v_print_report_direct_purchase',$this->data,true);
					// $template=$this->load->view('purchase/v_print_report_direct_purchase',$this->data,true);
					// print_r($template);die;

					$this->data['user_signature'] = $this->general->get_signature($this->userid);

					$recv_date = !empty($req_detail_list[0]->recm_receiveddatebs) ? $req_detail_list[0]->recm_receiveddatebs : CURDATE_NP;

					$approvedby = $this->general->get_store_post_data($recv_date, 'approver');

					$this->data['approver_signature'] = $this->general->get_signature($approvedby);

					$store_head_id = $this->general->get_store_post_data($recv_date, 'store_head');

					$this->data['store_head_signature'] = $this->general->get_signature($store_head_id);

					if (RECV_REPORT_TYPE == 'DEFAULT') {
						$template = $this->load->view('purchase/v_print_report_direct_purchase', $this->data, true);
					} else {
						$template = $this->load->view('purchase/' . REPORT_SUFFIX . '/v_print_report_direct_purchase', $this->data, true);

						// $template = $this->load->view('purchase/v_print_report_direct_purchase' . '_' . REPORT_SUFFIX, $this->data, true);
					}

					if ($this->data['req_detail_list'] > 0) {
						print_r(json_encode(array('status' => 'success', 'message' => '', 'tempform' => $template)));
						exit;
					} else {
						print_r(json_encode(array('status' => 'error', 'message' => 'Unable to Reprint')));
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
	public function generate_pdfDirect()
	{
		$page_orientation = !empty($_GET['page_orientation']) ? $_GET['page_orientation']  : '';
		if ($page_orientation == 'L') {
			$page_size = 'A4-L';
		} else {
			$page_size = 'A4';
		}

		$this->data['searchResult'] = $this->direct_purchase_mdl->get_direct_received_list_new();
		// echo "<pre>";
		// print_r( $this->data['searchResult']);
		// die();
		unset($this->data['searchResult']['totalfilteredrecs']);
		unset($this->data['searchResult']['totalrecs']);

		$html = $this->load->view('purchase/v_direct_purchase_download', $this->data, true);
		$filename = 'direct_purchase_' . date('Y_m_d_H_i_s') . '_.pdf';
		$pdfsize = 'A4-L'; //A4-L for landscape
		//if save and download with default filename, send $filename as parameter
		$this->general->generate_pdf($html, false, $pdfsize, $page_size);
		exit();
	}

	public function exportToExcelDirect()
	{
		header("Content-Type: application/xls");
		header("Content-Disposition: attachment; filename=direct_purchase" . date('Y_m_d_H_i') . ".xls");
		header("Pragma: no-cache");
		header("Expires: 0");

		$data = $this->direct_purchase_mdl->get_direct_received_list();

		$this->data['searchResult'] = $this->direct_purchase_mdl->get_direct_received_list_new();

		$array = array();
		unset($this->data['searchResult']['totalfilteredrecs']);
		unset($this->data['searchResult']['totalrecs']);
		$response = $this->load->view('purchase/v_direct_purchase_download', $this->data, true);

		echo $response;
	}
	public function form_purchase_receive()
	{

		$this->data['store_type'] = $this->general->get_tbl_data('*', 'store', false, 'st_store_id', 'ASC');
		$this->data['tab_type'] = 'entry';
		$this->data['fiscal'] = $this->general->get_tbl_data('*', 'fiye_fiscalyear', false, 'fiye_fiscalyear_id', 'DESC');
		// $this->data['demand_type'] = $this->general->get_tbl_data('*','rety_receivetypestatys',false,'rety_receivetypeid','DESC');
		$this->data['distributor'] = $this->general->get_tbl_data('*', 'dist_distributors', false, 'dist_distributor', 'ASC');
		$this->data['supplier_all'] = $this->general->get_tbl_data('*', 'dist_distributors', false, 'dist_distributor', 'ASC');
		$this->data['budgets_list'] = $this->general->get_tbl_data('*', 'budg_budgets', false, 'budg_budgetname', 'ASC');
		$this->data['purchased_details']  = '';
		// echo "<pre>";
		// print_r($this->data['budgets_list']);
		// die();
		$this->data['budgets_list'] = $this->general->get_tbl_data('*', 'budg_budgets', false, 'budg_budgetname', 'ASC');

		// $this->data['received_no'] = $this->generate_receiveno();
		if (!empty($this->mattypeid)) {
			$srchmat = array('maty_materialtypeid' => $this->mattypeid, 'maty_isactive' => 'Y');
		} else {
			$srchmat = array('maty_isactive' => 'Y');
		}
		$this->data['material_type'] = $this->general->get_tbl_data('maty_materialtypeid,maty_material', 'maty_materialtype', $srchmat, 'maty_materialtypeid', 'ASC');
		$currentfyrs = CUR_FISCALYEAR;
		$locationid = $this->session->userdata(LOCATION_ID);

		$this->db->select('recm_invoiceno,recm_fyear')
			->from('recm_receivedmaster')
			->where('recm_locationid', $locationid);

		if (ORGANIZATION_NAME == 'KU') {
			if ($this->mattypeid) {
				$this->db->where('recm_mattypeid', $this->mattypeid);
			} else {
				$this->db->where('recm_mattypeid', 1);
			}
		}
		$cur_fiscalyrs_invoiceno = $this->db->order_by('recm_fyear', 'DESC')
			->limit(1)
			->get()->row();

		if (!empty($cur_fiscalyrs_invoiceno)) {
			$invoice_format = $cur_fiscalyrs_invoiceno->recm_invoiceno;

			$invoice_string = str_split($invoice_format);
			// echo "<pre>";
			// print_r($invoice_string);
			// die();
			$invoice_prefix_len = strlen(RECEIVED_NO_PREFIX);
			$chk_first_string_after_invoice_prefix = $invoice_string[$invoice_prefix_len];
			// echo $chk_first_string_after_invoice_prefix;
			// die();
			if ($chk_first_string_after_invoice_prefix == '0') {
				$invoice_no_prefix = RECEIVED_NO_PREFIX . CUR_FISCALYEAR;
			} else if ($cur_fiscalyrs_invoiceno->recm_fyear == $currentfyrs && $chk_first_string_after_invoice_prefix == '0') {
				$invoice_no_prefix = RECEIVED_NO_PREFIX . CUR_FISCALYEAR;
			} else if ($cur_fiscalyrs_invoiceno->recm_fyear != $currentfyrs && $chk_first_string_after_invoice_prefix == '0') {
				$invoice_no_prefix = RECEIVED_NO_PREFIX . CUR_FISCALYEAR;
			} else if ($cur_fiscalyrs_invoiceno->recm_fyear != $currentfyrs && $chk_first_string_after_invoice_prefix != '0') {
				$invoice_no_prefix = RECEIVED_NO_PREFIX . CUR_FISCALYEAR;
			} else {
				$invoice_no_prefix = RECEIVED_NO_PREFIX;
			}
		} else {
			$invoice_no_prefix = RECEIVED_NO_PREFIX . CUR_FISCALYEAR;
		}

		// $this->data['received_no']=$this->generate_receiveno();
		if (ORGANIZATION_NAME == 'KU') {
			$invoice_no_prefix = '';
			if ($this->mattypeid) {
				$mattypeid = $this->mattypeid;
			} else {
				$mattypeid = 1;
			}

			$this->data['received_no'] = $this->general->generate_invoiceno('recm_invoiceno', 'recm_invoiceno', 'recm_receivedmaster', $invoice_no_prefix, RECEIVED_NO_LENGTH, array('recm_mattypeid' => $mattypeid), 'recm_locationid', 'recm_fyear DESC ,recm_receivedmasterid  DESC', 'M', false, 'Y');
			// echo $this->db->last_query();
			// die();
		} else {
			$this->data['received_no'] = $this->general->generate_invoiceno('recm_invoiceno', 'recm_invoiceno', 'recm_receivedmaster', $invoice_no_prefix, RECEIVED_NO_LENGTH, false, 'recm_locationid', 'recm_fyear DESC ,recm_receivedmasterid  DESC', 'M');
		}

		if (ORGANIZATION_NAME == 'KU') {
			$this->load->view('purchase/ku/v_direct_purchase_form', $this->data);
		} else if (ORGANIZATION_NAME == 'KUKL') {
			$this->load->view('purchase/kukl/v_direct_purchase_form', $this->data);
		} else {
			$this->load->view('purchase/v_direct_purchase_form', $this->data);
		}
		// if (REPORT_SUFFIX == 'kukl') {
		// 	$this->load->view('purchase/' . REPORT_SUFFIX . '/v_direct_purchase_form', $this->data);
		// } else {
		// 	$this->load->view('purchase/v_direct_purchase_form', $this->data);
		// }
	}
	public function save_receive_order_item()
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

				$this->form_validation->set_rules($this->direct_purchase_mdl->validate_settings_receive_order_item);
				if ($this->form_validation->run() == TRUE) {

					$trans = $this->direct_purchase_mdl->order_item_receive_save();

					// echo "test";
					// die();
					if ($trans) {
						$print = $this->input->post('print');
						$print_report = '';
						if ($print = "print") {
							// $this->data['req_detail_list']='';
							// $report_data = $this->data['report_data'] = $this->input->post();
							// // echo "<pre>";
							// // print_r($report_data);
							// // die();
							// $itemid = !empty($report_data['trde_itemsid'])?$report_data['trde_itemsid']:'';
							// if(!empty($itemid)):
							// 	foreach($itemid as $key=>$it):
							// 		$itemid = !empty($report_data['trde_itemsid'][$key])?$report_data['trde_itemsid'][$key]:'';
							// 	$this->data['item_name']=$this->general->get_tbl_data('*','itli_itemslist',array('itli_itemlistid'=>$itemid),false,'DESC');
							// 	endforeach;
							// endif;
							$this->data['report_data'] = array();

							$this->data['req_detail_list'] = $this->direct_purchase_mdl->get_received_details(array('rd.recd_receivedmasterid' => $trans, 'rm.recm_dstat' => 'D'));

							$this->data['direct_purchase_master'] = $this->direct_purchase_mdl->received_master_views(array('rm.recm_receivedmasterid' => $trans));

							$this->data['user_signature'] = $this->general->get_signature($this->userid);

							$recv_date = !empty($req_detail_list[0]->recm_receiveddatebs) ? $req_detail_list[0]->recm_receiveddatebs : CURDATE_NP;

							$approvedby = $this->general->get_store_post_data($recv_date, 'approver');

							$this->data['approver_signature'] = $this->general->get_signature($approvedby);

							$store_head_id = $this->general->get_store_post_data($recv_date, 'store_head');

							$this->data['store_head_signature'] = $this->general->get_signature($store_head_id);

							// if (RECV_REPORT_TYPE == 'DEFAULT') {
							// 	$print_report = $this->load->view('purchase/v_print_report_direct_purchase', $this->data, true);
							// } else {
							// 	$print_report = $this->load->view('purchase/v_print_report_direct_purchase' . '_' . REPORT_SUFFIX, $this->data, true);
							// }

							if (ORGANIZATION_NAME == 'KU') {
								$mattypeid = $this->input->post('recm_mattypeid');
								$this->data['mattypeid'] = !empty($mattypeid) ? $mattypeid : '';
							}
							if (RECV_REPORT_TYPE == 'DEFAULT') {
								$print_report = $this->load->view('receive_against_order/v_received_against_order_print', $this->data, true);
							} else { 
								$print_report = $this->load->view('receive_against_order/v_received_against_order_print' . '_' . REPORT_SUFFIX, $this->data, true);
							}

							// $print_report = $this->load->view('purchase/v_print_report_direct_purchase', $this->data, true);
							//echo "<pre>"; print_r($print_report);die;
						}
						print_r(json_encode(array('status' => 'success', 'message' => 'Record Save Successfully', 'print_report' => $print_report)));
						exit;
						// print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully')));
						// exit;
					} else {
						print_r(json_encode(array('status' => 'error', 'message' => 'Unsuccessful Operation')));
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
	public function direct_return_details()
	{
		$this->data['direct_purchase'] = 'direct_return_details';
		$this->data['fiscal'] = $this->general->get_tbl_data('*', 'fiye_fiscalyear', false, 'fiye_fiscalyear_id', 'DESC');
		// $this->data['demand_type'] = $this->general->get_tbl_data('*','rety_receivetypestatys',false,'rety_receivetypeid','DESC'); 

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
			->build('purchase/v_direct_purchase_common_tab', $this->data);
	}
	public function generate_pdfReturn()
	{
		 $page_orientation = !empty($_GET['page_orientation']) ? $_GET['page_orientation']  : '';
		if ($page_orientation == 'L') {
			$page_size = 'A4-L';
		} else {
			$page_size = 'A4';
		}
		$this->data['searchResult'] = $this->return_analysis_mdl->get_direct_received_return_details_list();
		unset($this->data['searchResult']['totalfilteredrecs']);
		unset($this->data['searchResult']['totalrecs']);

		$html = $this->load->view('purchase/v_direct_purchase_return_detail_download', $this->data, true);
		$filename = 'return_detail_' . date('Y_m_d_H_i_s') . '_.pdf';
		$pdfsize = 'A4-L'; //A4-L for landscape
		//if save and download with default filename, send $filename as parameter
		$this->general->generate_pdf($html, false, $pdfsize, $page_size);
		exit();
	}

	public function exportToExcelReturn()
	{
		header("Content-Type: application/xls");
		header("Content-Disposition: attachment; filename=return_detail" . date('Y_m_d_H_i') . ".xls");
		header("Pragma: no-cache");
		header("Expires: 0");

		$data = $this->return_analysis_mdl->get_direct_received_return_details_list();

		$this->data['searchResult'] = $this->return_analysis_mdl->get_direct_received_return_details_list();

		$array = array();
		unset($this->data['searchResult']['totalfilteredrecs']);
		unset($this->data['searchResult']['totalrecs']);
		$response = $this->load->view('purchase/v_direct_purchase_return_detail_download', $this->data, true);

		echo $response;
	}
	public function direct_purchase_cancel()
	{

		$this->data['direct_purchase'] = 'direct_purchase_cancel';
		$this->data['fiscal'] = $this->general->get_tbl_data('*', 'fiye_fiscalyear', false, 'fiye_fiscalyear_id', 'DESC');
		// $this->data['demand_type'] = $this->general->get_tbl_data('*','rety_receivetypestatys',false,'rety_receivetypeid','DESC');

		$this->data['receive_no'] = $this->generate_receiveno();
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
			->build('purchase/v_direct_purchase_common_tab', $this->data);
	}
	public function direct_purchase_cancel_item()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			try {
				$recd_id = $this->input->post('id');
				// echo $recd_id;
				// die();
				$recd_data = $this->direct_purchase_mdl->get_received_details(array('recd_receiveddetailid' => $recd_id));
				// echo "<pre>";
				// print_r($recd_data);
				// die();
				if (empty($recd_data)) {
					print_r(json_encode(array('status' => 'error', 'message' => 'Unable to cancel this Item !!!')));
					exit;
				} else {
					$qty = $recd_data[0]->recd_purchasedqty;
					// $mat_transdetailid=$recd_data[0]->sade_mattransdetailid;
					$iscancel = $recd_data[0]->recd_iscancel;
					if ($iscancel == 'Y') {
						print_r(json_encode(array('status' => 'error', 'message' => 'Already Cancel this Item !!!')));
						exit;
					}

					$update_sd = $this->direct_purchase_mdl->update_receive_detail($recd_id);
					// $mat_trans=$this->direct_purchase_mdl->update_mat_trans_detailid($mat_transdetailid,$qty);

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

	public function direct_purchase_list_by_invoice_no()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if (MODULES_VIEW == 'N') {
				print_r(json_encode(array('status' => 'error', 'message' => $this->general->permission_denial_message())));
				exit;
			}

			$invoice_no = $this->input->post('invoice_no');

			if (empty($invoice_no)) {
				print_r(json_encode(array('status' => 'error', 'message' => 'Receive number can not be empty. Please enter a receive number.')));
				exit;
			}

			$fiscal_year = $this->input->post('fiscal_year');

			$srchcol = array('recm_fyear' => $fiscal_year, 'recm_invoiceno' => $invoice_no, 'recm_purchaseorderno' => 0, 'recm_locationid' => $this->locationid);

			$this->data['received_data'] = $this->direct_purchase_mdl->get_received_master($srchcol);
			// echo "<pre>";
			// print_r($this->data['received_data']);
			// die();

			if (empty($this->data['received_data'][0])) {
				print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Cancel this purchase. This purchase is already booked!!')));
				exit;
			}

			$this->data['received_details'] = array();
			$tempform = '';
			if ($this->data['received_data']) {
				$receivedmasterid = $this->data['received_data'][0]->recm_receivedmasterid;
				$this->data['received_details'] = $this->direct_purchase_mdl->get_received_details(array('recd_receivedmasterid' => $receivedmasterid));
				// 	// echo "<pre>";
				// 	// print_r($this->data['order_detail']);
				// 	// die();
				if ($this->data['received_details']) {
					$tempform = $this->load->view('purchase/v_direct_purchase_list_for_cancel', $this->data, true);
				}
			}
			print_r(json_encode(array('status' => 'success', 'received_data' => $this->data['received_data'], 'tempform' => $tempform, 'message' => 'Selected Successfully')));
			exit;
		} else {
			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		}
	}

	public function direct_purchase_cancel_item_all()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			try {
				$recm_id = $this->input->post('id');
				// echo $recm_id;
				// die();
				$recm_data = $this->direct_purchase_mdl->get_received_master(array('recm_receivedmasterid' => $recm_id));
				// echo "<pre>";
				// print_r($recm_data);
				// die();

				if (empty($recm_data)) {
					print_r(json_encode(array('status' => 'error', 'message' => 'Unable to cancel')));
					exit;
				}

				if ($recm_data[0]->recm_status == 'C') {
					print_r(json_encode(array('status' => 'error', 'message' => 'Already cancel this received number!!')));
					exit;
				} else {

					$this->direct_purchase_mdl->update_receive_master($recm_id);

					$recd_data = $this->direct_purchase_mdl->get_received_details(array('recd_receivedmasterid' => $recm_id));
					// echo"<pre>";print_r($recd_data);die();
					if (!empty($recd_data)) {
						foreach ($recd_data as $ksd => $recd) {

							$recd_receiveddetailid = $recd->recd_receiveddetailid;
							$qty = $recd->recd_purchasedqty;
							$mat_transdetailidid = $recd->recd_receivedmasterid;
							$iscancel = $recd->recd_iscancel;
							//echo "<pre>";print_r($mat_transdetailidid);die;
							if ($iscancel != 'Y') {
								$update_sd = $this->direct_purchase_mdl->update_receive_detail($recd_receiveddetailid);
							}

							if ($mat_transdetailidid) {
								$mat_trans = $this->direct_purchase_mdl->update_mat_trans_detailid($mat_transdetailidid, $qty);
							}
						}
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
	public function compareamount($bill_amount)
	{
		$clearance_amount = $this->input->post('clearanceamt');
		if ($bill_amount != $clearance_amount) {
			$this->form_validation->set_message('compareamount', 'Bill Amount and Clearance Amount did not match. Pleace check it.');
			return false;
		}
		return true;
	}
	public function exportToExcel()
	{
		header("Content-Type: application/xls");
		header("Content-Disposition: attachment; filename=cancel_order_" . date('Y_m_d_H_i') . ".xls");
		header("Pragma: no-cache");
		header("Expires: 0");

		$data = $this->receive_against_order_mdl->get_receive_against_order_list();

		$this->data['searchResult'] = $this->receive_against_order_mdl->get_receive_against_order_list();

		$array = array();
		unset($this->data['searchResult']['totalfilteredrecs']);
		unset($this->data['searchResult']['totalrecs']);
		$response = $this->load->view('receive_against_order/v_against_order_download', $this->data, true);

		echo $response;
	}
	public function generate_pdf()
	{
		$this->data['searchResult'] = $this->receive_against_order_mdl->get_receive_against_order_list();
		unset($this->data['searchResult']['totalfilteredrecs']);
		unset($this->data['searchResult']['totalrecs']);

		$html = $this->load->view('receive_against_order/v_against_order_download', $this->data, true);

		$filename = 'cancel_order_' . date('Y_m_d_H_i_s') . '_.pdf';
		$pdfsize = 'A4-L'; //A4-L for landscape
		//if save and download with default filename, send $filename as parameter
		$this->general->generate_pdf($html, false, $pdfsize);
		exit();
	}

	public function generate_receiveno()
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

		$this->db->select('recm_invoiceno');
		$this->db->from('recm_receivedmaster');
		$this->db->where('recm_invoiceno LIKE ' . '"%' . RECEIVED_NO_PREFIX . $prefix . '%"');
		$this->db->where('recm_locationid', $this->locationid);
		$this->db->limit(1);
		$this->db->order_by('recm_invoiceno', 'DESC');
		$query = $this->db->get();
		// echo $this->db->last_query(); die();
		$invoiceno = 0;
		$dbinvoiceno = '';

		if ($query->num_rows() > 0) {
			$dbinvoiceno = $query->row()->recm_invoiceno;
		}
		if (!empty($dbinvoiceno)) {
			$invoiceno = $this->general->stringseperator($dbinvoiceno, 'number');
		}

		$nw_invoice = str_pad($invoiceno + 1, RECEIVED_NO_LENGTH, 0, STR_PAD_LEFT);

		// echo RECEIVED_NO_PREFIX;
		// die();

		if (defined('SHOW_FORM_NO_WITH_LOCATION')) {
			if (SHOW_FORM_NO_WITH_LOCATION == 'Y') {
				return $this->locationcode . '-' . RECEIVED_NO_PREFIX . $prefix . $nw_invoice;
			} else {
				return RECEIVED_NO_PREFIX . $prefix . $nw_invoice;
			}
		} else {
			return RECEIVED_NO_PREFIX . $prefix . $nw_invoice;
		}
	}

	public function direct_purchase_from_req()
	{

		//   	if(MODULES_VIEW=='N')
		// {
		// 		print_r(json_encode(array('status'=>'error','message'=>$this->general->permission_denial_message())));
		// 	exit;
		// }
		$this->data['reqno'] = $this->input->post('id');

		$this->data['store_type'] = $this->general->get_tbl_data('*', 'store', false, 'st_store_id', 'ASC');
		$this->data['tab_type'] = 'entry';
		$this->data['fiscal'] = $this->general->get_tbl_data('*', 'fiye_fiscalyear', false, 'fiye_fiscalyear_id', 'DESC');
		// $this->data['demand_type'] = $this->general->get_tbl_data('*','rety_receivetypestatys',false,'rety_receivetypeid','DESC');

		$this->data['distributor'] = $this->general->get_tbl_data('*', 'dist_distributors', false, 'dist_distributorid', 'DESC');
		$this->data['supplier_all'] = $this->general->get_tbl_data('*', 'dist_distributors', false, 'dist_distributor', 'ASC');
		$this->data['budgets_list'] = $this->general->get_tbl_data('*', 'budg_budgets', false, 'budg_budgetname', 'ASC');
		// echo "<pre>";print_r($this->data['budgets_list']);die();
		$this->data['budgets_list'] = $this->general->get_tbl_data('*', 'budg_budgets', false, 'budg_budgetname', 'ASC');
		$this->data['received_no'] = $this->generate_receiveno();
		$seo_data = '';
		$this->data['direct_purchase'] = 'direct_purchase_from_req';
		$this->data['purchased_details'] = '';

		$id = $this->input->post('id');
		$mid = $this->input->post('mid');
		if ($mid) {
			$this->data['purchased_data']  = $this->general->get_tbl_data('*', 'chma_challanmaster', array('chma_challanmasterid' => $mid), 'chma_challanmasterid', 'ASC');
			$this->data['challan_details']  = $this->challan_mdl->chalandetails(array('chma_challanmasterid' => $mid));
		}
		if ($id) {
			$this->data['purchased_data']  = $this->general->get_tbl_data('*', 'recm_receivedmaster', array('recm_receivedmasterid' => $id), 'recm_receivedmasterid', 'ASC');
			$this->data['purchased_details']  = $this->direct_purchase_mdl->get_purcase_details(array('rm.recd_receivedmasterid' => $id));
			// $this->general->get_tbl_data('*','recd_receiveddetail',array('recd_receivedmasterid'=>$id),'recd_receivedmasterid','ASC');
			//echo"<pre>";print_r($this->data['purchased_details']);die;
		}
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
			//->build('receive_against_order/v_against_order', $this->data);
			//->build('purchase/v_direct_purchase', $this->data);
			->build('purchase/v_direct_purchase_common_tab', $this->data);
	}
	public function form_purchase_req()
	{
		$this->data['reqno'] = $this->input->post('id');

		$this->data['store_type'] = $this->general->get_tbl_data('*', 'store', false, 'st_store_id', 'ASC');
		$this->data['tab_type'] = 'entry';
		$this->data['fiscal'] = $this->general->get_tbl_data('*', 'fiye_fiscalyear', false, 'fiye_fiscalyear_id', 'DESC');
		// $this->data['demand_type'] = $this->general->get_tbl_data('*','rety_receivetypestatys',false,'rety_receivetypeid','DESC');

		$this->data['distributor'] = $this->general->get_tbl_data('*', 'dist_distributors', false, 'dist_distributorid', 'DESC');
		$this->data['supplier_all'] = $this->general->get_tbl_data('*', 'dist_distributors', false, 'dist_distributor', 'ASC');
		$this->data['budgets_list'] = $this->general->get_tbl_data('*', 'budg_budgets', false, 'budg_budgetname', 'ASC');
		// echo "<pre>";print_r($this->data['budgets_list']);die();
		$this->data['budgets_list'] = $this->general->get_tbl_data('*', 'budg_budgets', false, 'budg_budgetname', 'ASC');
		$this->data['received_no'] = $this->generate_receiveno();
		$this->data['purchased_details']  = '';
		// echo "<pre>";
		// print_r($this->data['budgets_list']);
		// die();
		$this->data['budgets_list'] = $this->general->get_tbl_data('*', 'budg_budgets', false, 'budg_budgetname', 'ASC');
		$this->data['received_no'] = $this->generate_receiveno();
		$this->load->view('purchase/v_direct_purchase_test', $this->data);
	}
	public function save_direct_pur_req()
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
				$masterid = $this->input->post('masterid');
				$this->form_validation->set_rules($this->direct_purchase_mdl->validate_settings_receive_order_item);
				if ($this->form_validation->run() == TRUE) {

					$trans = $this->direct_purchase_mdl->order_item_receive_save();
					$change = $this->direct_purchase_mdl->update_req_master($masterid);

					// echo "test";
					// die();
					if ($trans) {
						$print = $this->input->post('print');
						$print_report = '';
						if ($print = "print") {
							// $this->data['req_detail_list']='';
							// $report_data = $this->data['report_data'] = $this->input->post();
							// // echo "<pre>";
							// // print_r($report_data);
							// // die();
							// $itemid = !empty($report_data['trde_itemsid'])?$report_data['trde_itemsid']:'';
							// if(!empty($itemid)):
							// 	foreach($itemid as $key=>$it):
							// 		$itemid = !empty($report_data['trde_itemsid'][$key])?$report_data['trde_itemsid'][$key]:'';
							// 	$this->data['item_name']=$this->general->get_tbl_data('*','itli_itemslist',array('itli_itemlistid'=>$itemid),false,'DESC');
							// 	endforeach;
							// endif;

							$this->data['report_data'] = array();

							$this->data['req_detail_list'] = $this->direct_purchase_mdl->get_received_details(array('rd.recd_receivedmasterid' => $trans, 'rm.recm_dstat' => 'D'));

							$this->data['direct_purchase_master'] = $this->direct_purchase_mdl->received_master_views(array('rm.recm_receivedmasterid' => $trans));

							$print_report = $this->load->view('purchase/v_print_report_direct_purchase', $this->data, true);
							//echo "<pre>"; print_r($print_report);die;
						}
						print_r(json_encode(array('status' => 'success', 'message' => 'Record Save Successfully', 'print_report' => $print_report)));
						exit;
						// print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully')));
						// exit;
					} else {
						print_r(json_encode(array('status' => 'error', 'message' => 'Unsuccessful Operation')));
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
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */