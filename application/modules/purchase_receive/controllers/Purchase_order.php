<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Purchase_order extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->Model('purchase_order_mdl');
		$this->load->Model('stock_inventory/approved_mdl');
		$this->load->Model('purchase_requisition_mdl');

		$this->storeid = $this->session->userdata(STORE_ID);
		$this->locationid = $this->session->userdata(LOCATION_ID);
		$this->orgid=$this->session->userdata(ORG_ID);
		$this->username=$this->session->userdata(USER_NAME);
		if (defined('LOCATION_CODE')) {
			$this->locationcode = $this->session->userdata(LOCATION_CODE);
		}
		$this->location_ismain = $this->session->userdata(ISMAIN_LOCATION);

		$this->usergroup = $this->session->userdata(USER_GROUPCODE);
	}
	public function index($reload = false)
	{

		$masterid = $this->input->post('masterid');
		$mattypeid = 1;
		$reqno = 1;

		// print_r($this->input->post());
		// die();

		$this->data['approved_data'] = $this->approved_mdl->get_all_approved_list();
		// echo "<pre>"; print_r($this->data['approved_data']);die;
		$this->data['order_details'] = "";
		$this->data['store'] = $this->general->get_tbl_data('*', 'eqty_equipmenttype', false, 'eqty_equipmenttypeid', 'DESC');
		$this->data['equipmentcategory'] = $this->general->get_tbl_data('*', 'eqca_equipmentcategory', false, 'eqca_equipmentcategoryid', 'DESC');
		$this->data['distributor'] = $this->general->get_tbl_data('*', 'dist_distributors', false, 'dist_distributor', 'ASC');

		$this->data['material_type'] = $this->general->get_tbl_data('*', 'maty_materialtype', array('maty_isactive' => 'Y'), 'maty_materialtypeid', 'ASC');

		// echo "<pre>";
		// print_r($this->data['material_type']);
		// die();

		$this->data['fiscal_year'] = $this->general->get_tbl_data('*', 'fiye_fiscalyear', false, 'fiye_fiscalyear_id', 'DESC', '2');
		$this->data['current_tab'] = 'purchase_order';
		$storeid = $this->session->userdata(STORE_ID);
		if ($masterid) {
			$this->data['requisition_details'] = $this->purchase_requisition_mdl->get_purchase_requisition_master_data(array('pure_purchasereqid' => $masterid));
			$this->data['purchase_requisition'] = $this->purchase_requisition_mdl->get_purchase_requisition_data(array('rd.purd_reqid' => $masterid));
			// echo "<pre>";
			// print_r($this->data['requisition_details']);
			// die();
			if (!empty($this->data['requisition_details'])) {
				$mattypeid = !empty($this->data['requisition_details'][0]->pure_mattypeid) ? $this->data['requisition_details'][0]->pure_mattypeid : '';
				$reqno = !empty($this->data['requisition_details'][0]->pure_reqno) ? $this->data['requisition_details'][0]->pure_reqno : '';
			}
		}

		// echo "<pre>";
		// print_r($this->data);
		// die();

		$order_no_array = array('puor_fyear' => CUR_FISCALYEAR, 'puor_locationid' => $this->locationid);

		if (ORGANIZATION_NAME == 'KU' || ORGANIZATION_NAME == 'ARMY' || ORGANIZATION_NAME == 'PU') {
			// echo "test";
			// die();
			$order_no_array['puro_mattypeid'] = $mattypeid;

			$this->data['order_no'] = $this->general->generate_form_no('puor_orderno', 'puor_purchaseordermaster', $order_no_array, 'puor_purchaseordermasterid', 'DESC');
		} else {
			// echo "test";
			// die();
			// $this->data['order_no'] = $this->general->get_tbl_data('max(puor_orderno) as ordnumb','puor_purchaseordermaster',array('puor_fyear'=>CUR_FISCALYEAR),'puor_purchaseordermasterid','DESC');
			 $this->data['order_no'] = $this->general->generate_form_no('puor_orderno', 'puor_purchaseordermaster', $order_no_array, 'puor_purchaseordermasterid', 'DESC');
		}
		// echo $this->data['order_no'];
		// die();
		// $srchbudg='';

		// echo $this->db->last_query();
		// die();
		$this->data['pure_reqno'] = $reqno;
		$this->data['puro_mattypeid'] = $mattypeid;
		$srchbudg=array('budg_isactive'=>'Y');
		$this->data['budgets_list'] = $this->general->get_tbl_data('*', 'budg_budgets', $srchbudg, 'budg_budgetname', 'ASC');
		
		if(ORGANIZATION_NAME=='ARMY'):
		// if(!empty($mattypeid)){
		// 	$srchbudg=array('budg_materialtypeid'=>$mattypeid,'budg_isactive'=>'Y');
		// }else{
			$srchbudg=array('budg_isactive'=>'Y');
		// }
		$this->data['budgets_list'] = $this->general->get_tbl_data('*', 'budg_budgets', $srchbudg, 'budg_budgetname', 'ASC');

		endif;
		// echo $this->db->last_query();
		// die();
		// echo "<pre>";print_r($this->data['order_no']);die;
		$this->data['eqty_equipmenttype'] = $this->general->get_tbl_data('*', 'eqty_equipmenttype', array('eqty_equipmenttypeid' => $storeid), 'eqty_equipmenttypeid', 'DESC');

		if (DEFAULT_DATEPICKER == 'NP') {
			$this->data['delivery_date'] = $this->general->EngToNepDateConv($this->general->add_date(CURDATE_EN, 7, 'days'));
		} else {
			$this->data['delivery_date'] = $this->general->add_date(CURDATE_EN, 7, 'days');
		}

		// die();

		$seo_data = '';
		$id = $this->input->post('id');
		// echo($id);
		// die;

		// print_r($budgets_list);
		// die();

		$this->data['purreqmasterid'] = $masterid;
		if ($id) {
			$this->data['order_details'] = $this->general->get_tbl_data('*', 'puor_purchaseordermaster', array('puor_purchaseordermasterid' => $id), 'puor_purchaseordermasterid', 'DESC');
			// echo "<pre>";
			// print_r($this->data['order_details']);
			// die();
			$this->data['orderdetails'] = $this->purchase_order_mdl->get_order_selected(array('puor_purchaseordermasterid' => $id));
			//
			//$this->->purchase_order_mdl->get_order_list();
			//echo "<pre>";print_r($this->data['orderdetails']);die;
		}
		// echo PUR_OR_FORM_TYPE;
		// die();
		if ($reload == 'reload') {
			if (defined('PUR_OR_FORM_TYPE')) :
				if (PUR_OR_FORM_TYPE == 'DEFAULT') {
					$this->load->view('purchase_order/v_purchase_order_form', $this->data);
				} else {
					$this->load->view('purchase_order/' . REPORT_SUFFIX . '/v_purchase_order_form', $this->data);
				}
			else :
				$this->load->view('purchase_order/v_purchase_order_form', $this->data);
			endif;
		} else {
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
				// ->build('purchase_order/v_purchase_order', $this->data);
				->build('purchase_order/v_common_purchaseorder_tab', $this->data);
		}
	}
	public function test_form()
	{

		$this->data['equipmentcategory'] = $this->general->get_tbl_data('*', 'eqca_equipmentcategory', false, 'eqca_equipmentcategoryid', 'DESC');
		$this->data['supplier'] = $this->general->get_tbl_data('*', 'dist_distributors', false, 'dist_distributorid', 'DESC');
		$this->data['depatrment'] = $this->general->get_tbl_data('*', 'dept_department', false, 'dept_depid', 'DESC');
		$this->data['item_all'] = $this->general->get_tbl_data('*', 'itli_itemslist', false, 'itli_itemlistid', 'DESC');
		$this->data['unit_all'] = $this->general->get_tbl_data('*', 'unit_unit', false, 'unit_unitid', 'DESC');
		$this->data['tax_all'] = $this->general->get_tbl_data('*', 'tava_taxvalue', false, 'tava_taxvalueid', 'DESC');
		$this->data['product_all'] = $this->general->get_tbl_data('*', 'prod_product', false, 'prod_productid', 'DESC');
		$this->data['fiscal'] = $this->general->get_tbl_data('*', 'fiye_fiscalyear', false, 'fiye_fiscalyear_id', 'DESC');

		$this->data['order_details'] = $this->purchase_order_mdl->get_order_selected(array('puor_purchaseordermasterid' => 2696));

	if (PUR_OR_REPORT_TYPE == 'DEFAULT') {
						// echo "test";
						// die();
						// $template = $this->load->view('purchase_order/v_purchase_order_print', $this->data, true);

						$print_report = $this->load->view('purchase_order/' . REPORT_SUFFIX . '/v_purchase_order_print', $this->data, true);

					} else {
						$file_name = base_url('purchase_order/v_purchase_order_print' . '_' . REPORT_SUFFIX . '.php');

						if (file_exists($file_name)) //not working
						{

							$print_report = $this->load->view('purchase_order/v_purchase_order_print' . '_' . REPORT_SUFFIX, $this->data, true);
						} else {
							$print_report = $this->load->view('purchase_order/' . REPORT_SUFFIX . '/v_purchase_order_print', $this->data, true);
						}
					}
		echo $print_report;
		die();
	}

	public function ajax_delivery_date_calculation()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$days = $this->input->post('days');

			if (DEFAULT_DATEPICKER == 'NP') {
				$this->data['delivery_date'] = $this->general->EngToNepDateConv($this->general->add_date(CURDATE_EN, $days, 'days'));
			} else {
				$this->data['delivery_date'] = $this->general->add_date(CURDATE_EN, $days, 'days');
			}
			print_r(json_encode(array('status' => 'success', 'delivery_date' => $this->data['delivery_date'], 'message' => 'Calculate Successfully !!!')));
			exit;
		} else {
			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		}
	}

	public function purhasre_requisition_chaeck_miniumqty() 
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$detailsid = $this->input->post('purdetailsid');
			$qty = $this->input->post('qty');
			$fyear = $this->input->post('fiscalyear');
			$this->data['qunatity'] = $this->general->get_tbl_data('pude_quantity', 'pude_purchaseorderdetail ', array('pude_puordeid' => $detailsid), 'pude_puordeid', 'DESC');
			$oldqty = !empty($this->data['qunatity']->pude_quantity) ? $this->data['qunatity']->pude_quantity : 0;
			if ($qty < $oldqty) {
				print_r(json_encode(array('status' => 'success', 'message' => 'New Entered Quantity Is Not Less Then Previous Quantity', 'qty' => $oldqty)));
				exit;
			} else {
				print_r(json_encode(array('status' => 'errorLimit', 'message' => 'Requisition Quantiy Is Exceeded', 'qty' => $oldqty)));
				exit;
			}
			// else
			// {
			// 	print_r(json_encode(array('status'=>'errorLimit','message'=>'Requisition Quantiy Is Exceeded !!')));
			//           exit;
			// }
		} else {
			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		}
	}
	public function form_purchase_order()
	{

		$this->data['order_details'] = "";
		$this->data['equipmentcategory'] = $this->general->get_tbl_data('*', 'eqca_equipmentcategory', false, 'eqca_equipmentcategoryid', 'DESC');
		$this->data['store'] = $this->general->get_tbl_data('*', 'eqty_equipmenttype', false, 'eqty_equipmenttypeid', 'DESC');
			$this->data['approved_data'] = $this->approved_mdl->get_all_approved_list();

		$this->data['distributor'] = $this->general->get_tbl_data('*', 'dist_distributors', false, 'dist_distributorid', 'DESC');

		$this->data['fiscal_year'] = $this->general->get_tbl_data('*', 'fiye_fiscalyear', false, 'fiye_fiscalyear_id', 'DESC', '2');

		$order_no_array = array('puor_fyear' => CUR_FISCALYEAR, 'puor_locationid' => $this->locationid);
		$this->data['order_no'] = $this->general->generate_form_no('puor_orderno', 'puor_purchaseordermaster', $order_no_array, 'puor_purchaseordermasterid', 'DESC');

		$this->data['current_tab'] = 'purchase_order';
		$storeid = $this->session->userdata(STORE_ID);
		$this->data['eqty_equipmenttype'] = $this->general->get_tbl_data('*', 'eqty_equipmenttype', array('eqty_equipmenttypeid' => $storeid), 'eqty_equipmenttypeid', 'DESC');

		if (defined('PUR_OR_FORM_TYPE')) :
			if (PUR_OR_FORM_TYPE == 'DEFAULT') {
				$this->load->view('purchase_order/v_purchase_order_form', $this->data);
			} else {
				$this->load->view('purchase_order/' . REPORT_SUFFIX . '/v_purchase_order_form', $this->data);
			}
		else :
			$this->load->view('purchase_order/v_purchase_order_form', $this->data);
		endif;
	}

	public function purchase_order_book()
	{
		$this->data['distributor'] = $this->general->get_tbl_data('*', 'dist_distributors', array('dist_isactive' => 'Y'), 'dist_distributor', 'ASC');
		$this->data['material_type'] = $this->general->get_tbl_data('*', 'maty_materialtype', array('maty_isactive' => 'Y'), 'maty_materialtypeid', 'ASC');

		// $this->data['item_all']=$this->general->get_tbl_data('*','itli_itemslist',false,'itli_itemlistid','DESC');
		$frmDate = CURMONTH_DAY1;
		$toDate = CURDATE_NP;
		if (ORGANIZATION_NAME == 'KUKL') {
			$cond = '';
			if ($frmDate) {
				$cond .= " WHERE puor_orderdatebs >='" . $frmDate . "'";
			}
			if ($toDate) {
				$cond .= " AND puor_orderdatebs <='" . $toDate . "'";
			} else {
				$cond .= " AND puor_orderdatebs <='" . $frmDate . "'";
			}

			$this->data['status_count'] = $this->purchase_order_mdl->getColorStatusCount($cond);
		} else {
			$this->data['status_count'] = $this->purchase_order_mdl->getStatusCount();
		}

		// echo $this->db->last_query();
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

		$this->data['current_tab'] = 'purchase_order_book';

		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			// ->build('purchase_order/v_purchase_order_book_list', $this->data);
			->build('purchase_order/v_common_purchaseorder_tab', $this->data);
	}

	public function purhasre_requisition_check_remainigqty()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$qtynow = $this->input->post('remqty');
			$fyear = $this->input->post('fiscalyear');
			$pid = $this->input->post('pid');
			$this->data['qunatity'] = $this->general->get_tbl_data('purd_remqty', 'purd_purchasereqdetail ', array('purd_reqdetid' => $pid, 'purd_fyear' => $fyear), 'purd_reqdetid', 'DESC');
			$oldqty = !empty($this->data['qunatity'][0]->purd_remqty) ? $this->data['qunatity'][0]->purd_remqty : 0;
			//echo $this->db->last_query();print_r($oldqty);die;
			// if($oldqty > $qtynow)
			// {
			// 	print_r(json_encode(array('status'=>'success','message'=>'Remaining Quantity Not Exceeded','qty'=>$oldqty)));
			//           exit;
			// }
			// else
			// {
			// 	print_r(json_encode(array('status'=>'errorLimit','message'=>'Requisition Quantiy Is Exceeded !!','qty'=>$oldqty)));
			//           exit;
			// }
		} else {
			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		}
	}
	public function purchase_requisition_find()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$reqno = $this->input->post('requisitionno');
			$reqarr = $this->input->post('reqn');
			// echo "<pre>";
			// print_r($reqarr);
			// die(); 

			if (!empty($reqarr)) :
				if (in_array($reqno, $reqarr)) {
					print_r(json_encode(array('status' => 'error', 'message' => 'Already Added !!')));
					exit;
				}
			endif;

			$fyear = $this->input->post('fiscalyear');
			$mat_type_id = $this->input->post('mat_type_id');
			if (ORGANIZATION_NAME == 'KUKL') {
				$chekreqnovalid = $this->purchase_order_mdl->get_pur_requisition_details(array('pure_streqno' => $reqno, 'pure_fyear' => $fyear, 'pure_isapproved' => 'P')); 
				// echo $this->db->last_query();
				// die();
			} else {
				$chekreqnovalid = $this->purchase_order_mdl->get_pur_requisition_details(array('pure_reqno' => $reqno, 'pure_fyear' => $fyear, 'pure_isapproved' => 'Y'));
			}
			// echo $this->db->last_query();
			// die();

			// echo "<pre>";
			// print_r($chekreqnovalid);
			// die();

			if (!empty($chekreqnovalid)) {
				$remqty = $chekreqnovalid[0]->purd_remqty;
				// $remqty;
				if (ORGANIZATION_NAME != 'KU' || ORGANIZATION_NAME == 'ARMY') {
					if ($remqty <= '0') {
						print_r(json_encode(array('status' => 'error', 'message' => 'Already Order')));
						exit;
					}
				}
			}
			// die();

			if (ORGANIZATION_NAME == 'KUKL') {
				$pure_isapproved = 'P';
			} else {
				$pure_isapproved = 'Y';
			}

			if (ORGANIZATION_NAME == 'KUKL') {
				if ($mat_type_id) {
					$this->data['detail_list'] = $this->purchase_order_mdl->get_pur_requisition_details(array('pure_reqno' => $reqno, 'pure_fyear' => $fyear, 'pure_isapproved' => $pure_isapproved, 'purd_remqty >' => '0', 'pure_locationid' => $this->locationid, 'prld_mattypeid' => $mat_type_id));
					
				} else {
					$this->data['detail_list'] = $this->purchase_order_mdl->get_pur_requisition_details(array('pure_streqno' => $reqno, 'pure_fyear' => $fyear, 'pure_isapproved' => $pure_isapproved, 'purd_proceedmanager' => 'Y', 'purd_proceedorder' => 'Y', 'purd_remqty >' => '0', 'pure_locationid' => $this->locationid));
				}
				// echo $this->db->last_query();
				// 	die();
			} else {
				$this->data['detail_list'] = $this->purchase_order_mdl->get_pur_requisition_details(array('pure_reqno' => $reqno, 'pure_fyear' => $fyear, 'pure_isapproved' => 'Y', 'purd_remqty >' => '0'));
			}

			// echo "<pre>";
			// print_r($this->data['detail_list']);
			// // print_r($this->db->last_query());
			// die();

			$this->data['storeid'] = !empty($this->data['detail_list'][0]->pure_itemstypeid) ? $this->data['detail_list'][0]->pure_itemstypeid : '';
			$this->data['purchasereqid'] = !empty($this->data['detail_list'][0]->pure_purchasereqid) ? $this->data['detail_list'][0]->pure_purchasereqid : '';

			if (ORGANIZATION_NAME == 'KU' || ORGANIZATION_NAME == 'ARMY' || ORGANIZATION_NAME == 'KU') {
				$tempform = $this->load->view('purchase_order/ku/v_pur_requisition_detail_append', $this->data, true);
			} else {
				$tempform = $this->load->view('purchase_order/v_pur_requisition_detail_append', $this->data, true);
			}

			if (!empty($this->data['detail_list'])) {
				$budget_head=!empty($this->data['detail_list'][0]->pure_accheadid)?$this->data['detail_list'][0]->pure_accheadid:'';
				print_r(json_encode(array('status' => 'success', 'message' => 'You Can view Order', 'tempform' => $tempform, 'storeid' => $this->data['storeid'], 'purchasereqid' => $this->data['purchasereqid'], 'purchasereqno' => $reqno,'budget_head'=>$budget_head)));
				exit;
			} else {
				print_r(json_encode(array('status' => 'error', 'message' => 'Purchase requisition no is not exit please try another !!')));
				exit;
			}
		} else {
			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		}
	}

	public function get_order_no_by_material_type_id()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			// echo "<pre>";
			// print_r($this->input->post());
			// die();
			$mattype = $this->input->post('mattype');
			$fyear = $this->input->post('fyear');
			$order_no_array = array('puro_mattypeid' => $mattype, 'puor_fyear' => $fyear, 'puor_locationid' => $this->locationid);
			$orderno = $this->general->generate_form_no('puor_orderno', 'puor_purchaseordermaster', $order_no_array, 'puor_purchaseordermasterid', 'DESC');
			print_r(json_encode(array('status' => 'success', 'orderno' => $orderno)));
			exit;
		} else {
			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		}
	}
	public function order_lists()
	{
		$this->data['depatrment'] = $this->general->get_tbl_data('*', 'dept_department', false, 'dept_depid', 'DESC');
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$order_muner = $this->input->post('order_no');
			$this->data['orderno'] =  $this->input->post('order_no');
			if ($order_muner) {
				$this->data['order_item_details'] = $this->receive_order_model->get_selected_order();

				$template = $this->load->view('receive_order_item/v_receive_order_form', $this->data, true);
				// echo $template; die();
				if ($this->data['order_item_details'] > 0) {
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
	public function purchased_summary()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$frmDate = !empty($this->input->post('frmdate')) ? $this->input->post('frmdate') : '';
			$toDate = !empty($this->input->post('todate')) ? $this->input->post('todate') : '';

			$cond = '';
			if (!empty($frmDate) && !empty($toDate)) {
				if ($frmDate) {
					$cond .= "  puor_orderdatebs >='" . $frmDate . "'";
				}
				if ($toDate) {
					$cond .= " AND puor_orderdatebs <='" . $toDate . "'";
				} else {
					$cond .= " AND puor_orderdatebs <='" . $frmDate . "'";
				}
			} else {

				$cond = '';
			}

			// if($frmDate && $toDate)
			// {
			// 	$srchcol=(" puor_orderdatebs BETWEEN '$frmDate' AND '$toDate'");
			// }
			if (ORGANIZATION_NAME == 'KUKL') {

				// $status_count = $this->purchase_order_mdl->getColorStatusCount($cond);
				$status_count = $this->purchase_order_mdl->getStatusCount_kukl();
			} else {
				$status_count = $this->purchase_order_mdl->getStatusCount();
			}

			// echo "<pre>";print_r($status_count);die();
			//$return_count = $this->purchase_order_mdl->getStatusCount(array('rema_returndatebs >='=>$frmDate, 'rema_returndatebs <='=>$toDate),'return');
			// echo $this->db->last_query();
			print_r(json_encode(array('status' => 'success', 'status_count' => $status_count)));
		}
	}
	public function purchase_order_book_list()
	{
		$apptype = $this->input->get('apptype');
		if (MODULES_VIEW == 'N') {
			$array = array();

			// $this->general->permission_denial_message();
			echo json_encode(array("recordsFiltered" => 0, "recordsTotal" => 0, "data" => $array));
			exit;
		}
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		}
		$useraccess = $this->session->userdata(USER_ACCESS_TYPE);

		$i = 0;
		$srch = '';
		if (ORGANIZATION_NAME == 'KUKL') {
			$status_count = $this->purchase_order_mdl->getColorStatusCount();
			foreach ($status_count as $key => $color) {
				if ($apptype == $color->coco_statusname) {
					$value = $color->coco_statusval;
					$button = $color->coco_button;
					if ($value != 'all') {
						$srch = array('puor_status' => $value, 'puor_purchased' => $button);
					} else {
						$srch = '';
					}
				}
			}
		} else {
			if ($apptype == 'pending') {
				$srch = array('puor_status' => 'N', 'puor_purchased' => '0');
			}
			if ($apptype == 'complete') {
				$srch = array('puor_status' => 'R', 'puor_purchased' => '2');
			}
			if ($apptype == 'partialcomplete') {
				$srch = array('puor_status' => 'R', 'puor_purchased' => '1');
			}
			if ($apptype == 'cancel') {
				$srch = array('puor_status' => 'C', 'puor_purchased' => '0');
			}
			if ($apptype == 'challan') {
				$srch = array('puor_status' => 'CH', 'puor_purchased' => '0');
			}
		}

		$data = $this->purchase_order_mdl->get_order_list($srch);
		// echo"<pre>";print_r($data);die;
		// echo $this->db->last_query();
		// die();
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"] > 0 ? $data["totalfilteredrecs"] : $data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

		unset($data["totalfilteredrecs"]);
		unset($data["totalrecs"]);
		foreach ($data as $row) {
			$appclass = '';
			$approved = $row->puor_status;
			$status = $row->puor_purchased;
			if (ORGANIZATION_NAME == 'KUKL') {
				$status_count = $this->purchase_order_mdl->getColorStatusCount();
				foreach ($status_count as $key => $color) {
					$value = $color->coco_statusval;
					$button = $color->coco_button;
					if ($approved == $value && $status == $button) {
						$appclass = $color->coco_statusname;
					}
				}
			} else {
				if ($approved == 'R' && $status == '1') {
					$appclass = 'partialcomplete';
				}
				if ($approved == 'N' && $status == '0') {
					$appclass = 'pending';
				}
				if ($approved == 'R' && $status == '2') {
					$appclass = 'complete';
				}
				if ($approved == 'C' && $status == '0') {
					$appclass = 'cancel';
				}
				if ($approved == 'CH' && $status == '0') {
					$appclass = 'challan';
				}
			}

			$array[$i]["approvedclass"] = $appclass;
			$array[$i]["puor_purchaseordermasterid"] = '<a href="javascript:void(0)" class="patlist" data-patientid=' . $row->puor_purchaseordermasterid . '>' . $row->puor_purchaseordermasterid . '</a>';
			$array[$i]["orderno"] = $row->puor_orderno;
			$array[$i]['fyear'] = $row->puor_fyear;
			$array[$i]["puor_orderdatebs"] = $row->puor_orderdatebs;
			$array[$i]["puor_deliverysite"] = $row->puor_deliverysite;
			$array[$i]["supplier"] = $row->dist_distributor;
			$array[$i]["puor_orderdatead"] = $row->puor_orderdatead;
			$array[$i]["puor_deliverydatebs"] = $row->puor_deliverydatebs;
			$array[$i]["puor_deliverydatead"] = $row->puor_deliverydatead;
			$array[$i]["amount"] = $row->puor_amount;
			$array[$i]["requno"] = $row->puor_requno;
			$array[$i]["totalamount"] = $row->puor_amount;
			$array[$i]["puor_approvedby"] = !empty($row->appr_approvedname) ? $row->appr_approvedname : '';
			 $array[$i]["mattype"] = !empty($row->maty_material) ? $row->maty_material : '';
			 // $array[$i]["postdate"] = $row->puor_postedbs;
			 if(DEFAULT_DATEPICKER == 'NP'){
				$array[$i]["postdate"] = $row->puor_postedbs.'</br>'.$row->puor_posttime;
			}else{
				$array[$i]["postdate"] = $row->puor_postedad.' </br>'.$row->puor_posttime;
			}
			// $array[$i]["action"] ='
			// <a href="javascript:void(0)" data-id='.$row->puor_purchaseordermasterid.' data-displaydiv="orderDetails" data-viewurl='.base_url('purchase_receive/purchase_order/details_order_views/').' class="view btn-primary btn-xxs" data-heading="'.$this->lang->line('order_detail').'"  ><i class="fa fa-eye " aria-hidden="true" ></i></a> &nbsp; 
			// <a href="javascript:void(0)" data-id='.$row->puor_purchaseordermasterid.' data-date='.$row->puor_orderdatebs.' data-viewurl='.base_url('purchase_receive/purchase_order').' class="redirectedit btn-success btn-xxs"><i class="fa fa-check" title="Order Approved" aria-hidden="true"></i></a>';

			if (MODULES_UPDATE == 'Y') {

				$editbtn = '<a href="javascript:void(0)" data-id="' . $row->puor_purchaseordermasterid . '"" data-date="' . $row->puor_purchaseordermasterid . '" data-viewurl="' . base_url('purchase_receive/purchase_order') . '" class="redirectedit btn-info btn-xxs"><i class="fa fa-edit " title="Edit Purchase Order" aria-hidden="true"></i></a> ';
			} else {
				$editbtn = '';
			}

			if (MODULES_VIEW == 'Y') {

				$viewbtn = '<a href="javascript:void(0)" title="View Purchase Order" data-id=' . $row->puor_purchaseordermasterid . ' data-displaydiv="orderDetails" data-viewurl=' . base_url('purchase_receive/purchase_order/details_order_views/') . ' class="view btn-primary btn-xxs" data-heading="' . $this->lang->line('order_detail') . '"  ><i class="fa fa-eye " aria-hidden="true" ></i></a>';
			} else {
				$viewbtn = '';
			}

			if ($status == '0') :
				$array[$i]["action"] = $editbtn . $viewbtn;

			else :
				$array[$i]["action"] = $viewbtn;
			// '
			//    <a href="javascript:void(0)" data-id='.$row->puor_purchaseordermasterid.' data-displaydiv="orderDetails" data-viewurl='.base_url('purchase_receive/purchase_order/details_order_views/').' class="view btn-primary btn-xxs" data-heading="'.$this->lang->line('order_detail').'"  ><i class="fa fa-eye " aria-hidden="true" ></i></a> &nbsp; 
			// ';
			endif;
			$i++;
		}
		echo json_encode(array("recordsFiltered" => $filtereddata, "recordsTotal" => $totalrecs, "data" => $array));
	}

	public function exportToExcel()
	{
		header("Content-Type: application/xls");
		header("Content-Disposition: attachment; filename=all_purchase_item_" . date('Y_m_d_H_i') . ".xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		$data = $this->purchase_order_mdl->get_order_list();
		$this->data['searchResult'] = $this->purchase_order_mdl->get_order_list();
		//print_r($this->data['searchResult']);die;
		unset($this->data['searchResult']['totalfilteredrecs']);
		unset($this->data['searchResult']['totalrecs']);

		$response = $this->load->view('purchase_order/v_cancel_order_download', $this->data, true);

		echo $response;
	}
	public function generate_pdf()
	{
		 $page_orientation = !empty($_GET['page_orientation']) ? $_GET['page_orientation']  : '';
		if ($page_orientation == 'L') {
			$page_size = 'A4-L';
		} else {
			$page_size = 'A4';
		}
		$this->data['searchResult'] = $this->purchase_order_mdl->get_order_list();

		// echo "<pre>";
		// print_r($this->data['searchResult']);
		// echo "</pre>";
		// die();
		unset($this->data['searchResult']['totalfilteredrecs']);
		unset($this->data['searchResult']['totalrecs']);

		if (ORGANIZATION_NAME  == 'KU' || ORGANIZATION_NAME == 'ARMY') {
			// echo "string";
			// die();
			$html = $this->load->view('purchase_order/ku/v_cancel_order_download', $this->data, true);
		} else {
			$html = $this->load->view('purchase_order/v_cancel_order_download', $this->data, true);
		}

		$output = 'all_purchase_item_' . date('Y_m_d_H_i') . '.pdf';

		$this->general->generate_pdf($html, '',$page_size);
	}
	public function details_order_reprint()
	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			if (defined('ORGANIZATION_NAME')) :
				if (ORGANIZATION_NAME == 'KUKL') :

					$this->data['userdata'] = $this->purchase_order_mdl->get_approve_user(array('usma_appdesiid' => '5'));

					// echo "<pre>";
					// print_r($this->data['userdata']);
					// die();

					// $this->data['userdata'] = $this->purchase_order_mdl->get_approve_user(array('usma_appdesiid'=>'5','usma_locationid'=>$this->locationid));

					$name_1 = !empty($this->data['userdata'][2]->usma_fullname) ? $this->data['userdata'][2]->usma_fullname : '';
					$name_2 = !empty($this->data['userdata'][3]->usma_fullname) ? $this->data['userdata'][3]->usma_fullname : '';
					$name_3 = !empty($this->data['userdata'][0]->usma_fullname) ? $this->data['userdata'][0]->usma_fullname : '';

					$employee_id1 = !empty($this->data['userdata'][2]->usma_employeeid) ? '(' . $this->data['userdata'][2]->usma_employeeid . ')' : '';
					$employee_id2 = !empty($this->data['userdata'][3]->usma_employeeid) ? '(' . $this->data['userdata'][3]->usma_employeeid . ')' : '';
					$employee_id3 = !empty($this->data['userdata'][0]->usma_employeeid) ? '(' . $this->data['userdata'][0]->usma_employeeid . ')' : '';

					$this->data['name2'] = $name_1 . ' ' . $employee_id1;
					$this->data['name3'] = $name_2 . ' ' . $employee_id2;
					$this->data['name1'] = $name_3 . ' ' . $employee_id3;

				// $this->data['desig1']=$this->data['userdata'][2]->desi_designationname;
				// $this->data['desig2']=$this->data['userdata'][1]->desi_designationname;
				// $this->data['desig3']=$this->data['userdata'][0]->desi_designationname;
				endif;
			endif;

			// echo"<pre>";print_r($this->data['userdata']);die();

			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$id = $this->input->post('id');
				if ($id) {
					$this->data['order_details'] = $this->purchase_order_mdl->get_order_selected();
					// echo "<pre>";
					// print_r($this->data['order_details']);
					// die();
					// echo PUR_OR_REPORT_TYPE;
					// die();
					if (PUR_OR_REPORT_TYPE == 'DEFAULT') {
						// echo "test";
						// die();
						// $template = $this->load->view('purchase_order/v_purchase_order_print', $this->data, true);

						$template = $this->load->view('purchase_order/v_purchase_order_print', $this->data, true);

					} else {
						$file_name = base_url('purchase_order/v_purchase_order_print' . '_' . REPORT_SUFFIX . '.php');

						if (file_exists($file_name)) //not working
						{

							$template = $this->load->view('purchase_order/v_purchase_order_print' . '_' . REPORT_SUFFIX, $this->data, true);
						} else {
							$template = $this->load->view('purchase_order/' . REPORT_SUFFIX . '/v_purchase_order_print', $this->data, true);
						}
					}

					//print_r($template);die;
					if ($this->data['order_details'] > 0) {
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
	public function details_order_views()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$id = $this->input->post('id');
				if ($id) {
					$this->data['order_details'] = $this->purchase_order_mdl->get_order_selected();
					// echo"<pre>";print_r($this->data['order_details']);die();

					if (ORGANIZATION_NAME == 'KUKL') {
						$template = $this->load->view('purchase_order/' . REPORT_SUFFIX . '/v_purchase_order_details', $this->data, true);
					} else if (ORGANIZATION_NAME == 'KU' || ORGANIZATION_NAME == 'ARMY' || ORGANIZATION_NAME == 'KU') {
						$template = $this->load->view('purchase_order/' . REPORT_SUFFIX . '/v_purchase_order_details', $this->data, true);
					} else {

						$template = $this->load->view('purchase_order/v_purchase_order_details', $this->data, true);
					}

					//print_r($template);die;
					if ($this->data['order_details'] > 0) {
						print_r(json_encode(array('status' => 'success', 'message' => '', 'tempform' => $template)));
						exit;
					} else {
						print_r(json_encode(array('status' => 'error', 'message' => 'Order Details Not Found!')));
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

	public function _notMatch($totalamountValue, $billamountFieldName)
	{
		if ($totalamountValue != $this->input->post($billamountFieldName)) {
			$this->form_validation->set_message('_notMatch', 'Bill Amount and Total Amount Not Match');
			return false;
		}
		return true;
	}

	public function save_order_item($print = false)
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
			try {
				$has_no_supplier=!empty($this->input->post('has_no_supplier'))?$this->input->post('has_no_supplier'):'N';
				if($has_no_supplier=='Y'){
						$this->form_validation->set_rules($this->purchase_order_mdl->validate_settings_order_item_no_supplier);
				}else{
						$this->form_validation->set_rules($this->purchase_order_mdl->validate_settings_order_item);
					}
			

				if ($this->form_validation->run() == TRUE) {
					//echo"<pre>";print_r($thid->input->post());die;
					// die();
					$trans = $this->purchase_order_mdl->order_item_save();
					if ($trans) {
						if (ORGANIZATION_NAME == "KUKL") {
							// need to send approval to department supervisor after updateing market values
							$items_id = $this->input->post('qude_itemsid');
							$approve_status = 'S';
							$masterid = $trans;
							$materialtype = $this->input->post('mat_type_id');

							$this->purchase_requisition_mdl->send_to_purchase_order_market_price($items_id, $approve_status, $masterid, $materialtype);

							$this->data['order_details'] = $this->purchase_order_mdl->get_order_selected(array('puor_purchaseordermasterid' => $trans));

							$puor_reqno = !empty($this->data['order_details'][0]->puor_requno) ? $this->data['order_details'][0]->puor_requno : 0;

							$puor_orderno = !empty($this->data['order_details'][0]->puor_orderno) ? $this->data['order_details'][0]->puor_orderno : 0;

							$msg_params = array(
								'PROCUREMENT_NO' => $puor_reqno,
								'ORDER_NO' => $puor_orderno
							);

							$this->general->send_message_params('save_order_item', $msg_params);

							// if (defined('RUN_API') && RUN_API == 'Y'){
       //          				if (defined('API_CALL') && API_CALL == 'KUKL') {
							// 		$this->notify_kukl_budget($trans);
							// 	}
							// } 
						}

						if ($print == "print") {
							// $this->data['equipmentcategory'] = $this->general->get_tbl_data('*', 'eqca_equipmentcategory', false, 'eqca_equipmentcategoryid', 'DESC');
							// $this->data['supplier'] = $this->general->get_tbl_data('*', 'dist_distributors', false, 'dist_distributorid', 'DESC');
							// $this->data['depatrment'] = $this->general->get_tbl_data('*', 'dept_department', false, 'dept_depid', 'DESC');
							// $this->data['item_all'] = $this->general->get_tbl_data('*', 'itli_itemslist', false, 'itli_itemlistid', 'DESC');
							// $this->data['unit_all'] = $this->general->get_tbl_data('*', 'unit_unit', false, 'unit_unitid', 'DESC');
							// $this->data['tax_all'] = $this->general->get_tbl_data('*', 'tava_taxvalue', false, 'tava_taxvalueid', 'DESC');
							// $this->data['product_all'] = $this->general->get_tbl_data('*', 'prod_product', false, 'prod_productid', 'DESC');
							// $this->data['fiscal'] = $this->general->get_tbl_data('*', 'fiye_fiscalyear', false, 'fiye_fiscalyear_id', 'DESC');
							// echo "<pre>";
							// print_r($this->data);
							// die();

							$this->data['order_details'] = $this->purchase_order_mdl->get_order_selected(array('puor_purchaseordermasterid' => $trans));

							if (ORGANIZATION_NAME == 'KUKL') :
								$this->data['userdata'] = $this->purchase_order_mdl->get_approve_user(array('usma_appdesiid' => '5'));

								$this->data['name1'] = $this->data['userdata'][2]->usma_fullname;
								$this->data['name2'] = $this->data['userdata'][1]->usma_fullname;
								$this->data['name3'] = $this->data['userdata'][0]->usma_fullname;

								$this->data['desig1'] = $this->data['userdata'][2]->desi_designationname;
								$this->data['desig2'] = $this->data['userdata'][1]->desi_designationname;
								$this->data['desig3'] = $this->data['userdata'][0]->desi_designationname;
							endif;

							// $print_report = $this->load->view('purchase_order/v_purchase_order_print', $this->data, true);

							// if(PUR_OR_REPORT_TYPE == 'DEFAULT'){
							// 	$print_report=$this->load->view('purchase_order/v_purchase_order_print',$this->data,true);
							// }else{
							// 	$print_report=$this->load->view('purchase_order/v_purchase_order_print'.'_'.REPORT_SUFFIX,$this->data,true);
							// }

							if (PUR_OR_REPORT_TYPE == 'DEFAULT') {
								$template = $this->load->view('purchase_order/v_purchase_order_print', $this->data, true);
							} else {
								$file_name = base_url('purchase_order/v_purchase_order_print' . '_' . REPORT_SUFFIX . '.php');

								if (file_exists($file_name)) //not working
								{
									$template = $this->load->view('purchase_order/v_purchase_order_print' . '_' . REPORT_SUFFIX, $this->data, true);
								} else {
									$template = $this->load->view('purchase_order/' . REPORT_SUFFIX . '/v_purchase_order_print', $this->data, true);
								}
							}

							// echo $print_report;
							// die();

							print_r(json_encode(array('status' => 'success', 'message' => 'Record Save Successfully', 'print_report' => $template)));
							exit;
						} else {

							print_r(json_encode(array('status' => 'success', 'message' => 'Record Save Successfully')));
							exit;
						}
					} else {
						print_r(json_encode(array('status' => 'error', 'message' => 'Operation Unsuccessful!')));
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

	public function load_pur_reqisition_list()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			try {
				$mattype = $this->input->post('id');
				$fiscalyear = $this->input->post('fiscalyear');
				$this->data['mattype'] =	$mattype;
				$this->data['fiscalyear'] = $fiscalyear;

				$this->data['requistion_departments'] = '';
				$this->data['detail_list'] = '';

				$tempform = '';

				$tempform = $this->load->view('purchase_order/v_pur_requisition_list_modal', $this->data, true);

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

	public function get_pur_requisition_list()
	{

		if (MODULES_VIEW == 'N') {
			$array = array();
			echo json_encode(array("recordsFiltered" => 0, "recordsTotal" => 0, "data" => $array));
			exit;
		}

		$fiscalyear = !empty($this->input->get('fiscalyear')) ? $this->input->get('fiscalyear') : $this->input->post('fiscalyear');

		$searcharray = array('pr.pure_fyear' => $fiscalyear, 'pr.pure_storeid' => $this->storeid);

		$this->data['detail_list'] = '';

		$data = $this->purchase_order_mdl->get_pur_requisition_list($searcharray);

		// echo $this->db->last_query();
		// die();
		// echo "<pre>";
		// print_r($data); die;
		// echo $this->db->last_query(); die;
		$i = 0;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"] > 0 ? $data["totalfilteredrecs"] : $data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

		unset($data["totalfilteredrecs"]);
		unset($data["totalrecs"]);

		foreach ($data as $row) {
			$array[$i]["masterid"] = !empty($row->pure_purchasereqid) ? $row->pure_purchasereqid : '';
			$array[$i]["req_no"] = !empty($row->pure_reqno) ? $row->pure_reqno : '';
			$array[$i]["date_bs"] = !empty($row->pure_reqdatebs) ? $row->pure_reqdatebs : '';
			$array[$i]["date_ad"] = !empty($row->pure_reqdatead) ? $row->pure_reqdatead : '';
			$array[$i]["appliedby"] = !empty($row->pure_appliedby) ? $row->pure_appliedby : '';
			$array[$i]["store"] = !empty($row->eqty_equipmenttype) ? $row->eqty_equipmenttype : '';
			$array[$i]["storeid"] = !empty($row->eqty_equipmenttypeid) ? $row->eqty_equipmenttypeid : '';
			$array[$i]["requestto"] = !empty($row->pure_requestto) ? $row->pure_requestto : '';

			$i++;
		}
		echo json_encode(array("recordsFiltered" => $filtereddata, "recordsTotal" => $totalrecs, "data" => $array));
	}

	public function load_detail_list($new_order = false)
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$masterid = $this->input->post('masterid');
			$mat_type_id = !empty($this->input->post('mat_type_id')) ? $this->input->post('mat_type_id') : '';

			$tempform = '';

			if ($mat_type_id) {
				$detail_list = $this->data['detail_list'] = $this->purchase_order_mdl->get_pur_requisition_details(array('purd_reqid' => $masterid, 'purd_remqty >' => 0, 'prld_mattypeid' => $mat_type_id));
			} else {
				$detail_list = $this->data['detail_list'] = $this->purchase_order_mdl->get_pur_requisition_details(array('purd_reqid' => $masterid, 'purd_remqty >' => 0));
			}

			$this->data['distributor'] = $this->general->get_tbl_data('*', 'dist_distributors', false, 'dist_distributorid', 'DESC');
			if (empty($detail_list)) {
				$isempty = 'empty';
			} else {
				$isempty = 'not_empty';
			}
			if ($new_order == 'new_detail_list') {
				$tempform = $this->load->view('purchase_order/v_pur_requisition_detail_append', $this->data, true);
			} else {
				$tempform = $this->load->view('purchase_order/v_pur_requisition_detail_modal', $this->data, true);
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

	public function purchase_order_approval()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$trans  = $this->purchase_order_mdl->purchase_order_approval();

			if ($trans) {
				$get_orderby = $this->general->get_tbl_data('puor_enteredby', 'puor_purchaseordermaster', array('puor_purchaseordermasterid' => $trans));

				$orderby = !empty($get_orderby[0]->puor_enteredby) ? $get_orderby[0]->puor_enteredby : 0;

				$approve_status = $this->input->post('approve_status');
				$puor_orderno = $this->input->post('puor_orderno');
				$puor_requno = $this->input->post('puor_requno');

				if ($approve_status == '1') :
					// send to approval from branch manager

					$msg_params = array(
						'PROCUREMENT_NO' => $puor_requno,
						'ORDER_NO' => $puor_orderno
					);
					$this->general->send_message_params('purchase_order_approval_ps', $msg_params);

				elseif ($approve_status == '2') :
					// approved message

					$msg_params = array(
						'PROCUREMENT_NO' => $puor_requno,
						'ORDER_NO' => $puor_orderno,
						'TO_USERID' => $orderby
					);
					$this->general->send_message_params('purchase_order_approval_ph', $msg_params);

				endif;

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

	public function notify_kukl_budget($id)
	{
		// if (!$id)
		// {
		// 	return false;
		// }

		// $this->db->select('pd.pude_requsitionid,purd_reqid');
  //       $this->db->from('pude_purchaseorderdetail pd');
  //    	$this->db->join('purd_purchasereqdetail prd','prd.purd_reqdetid = pd.pude_requsitionid','left');
  //       $this->db->where('pude_purchasemasterid',$id);
  //       $ordered_items = $this->db->get()->result();
		// $ordered_items_array = array();
		// $pur_req_master_array = array(); 
  //       if (!empty($ordered_items && count($ordered_items))) {
  //       	$ordered_items_array = array_column($ordered_items,'pude_requsitionid');
  //       	$pur_req_master_array = array_unique(array_column($ordered_items,'purd_reqid'));
        	
  //       	$this->db->select('purd_reqdetid');
  //       	$this->db->from('purd_purchasereqdetail');
  //       	$this->db->where_in('purd_reqid',$pur_req_master_array);
  //       	$preq_items = $this->db->get()->result();

  //       	if (!empty($preq_items && count($preq_items))) {
  //       		$all_requested_array = array_column($preq_items,'purd_reqdetid');

  //       		$removed_items = array_diff($all_requested_array,$ordered_items_array);

  //       		if (!empty($removed_items) && count($removed_items)) {
  //       			$this->db->select('purd_reqdetailid,rede_reqmasterid');
		//         	$this->db->from('purd_purchasereqdetail pd');
		//         	$this->db->join('rede_reqdetail rd','pd.purd_reqdetailid = rd.rede_reqdetailid','LEFT');
		//         	$this->db->where_in('purd_reqdetid',$removed_items);
		//         	$removed_items = $this->db->get()->result();

		//         	foreach($removed_items as $items){
		//         		$post_data = array(
  //                           'Req_MasterId'=> $items->rede_reqmasterid,
		//         			'req_detailId' => $items->purd_reqdetailid,
		//         			'r_Status' => 'C', 
		//         			'insUp' => 'UP',
		//         			'Entry_By' => null,
  //                           'Entry_Date' => null,
  //                           "Remarks" => 'cancel item',  
  //                           "insUp" => "UP",
  //                           "Budget_id"=> 0,
  //                           "Amount"=> 0,
  //                           "Item_Description"=> null,
  //                           "Rem_Amount"=> 0,
  //                           "Req_DateEn"=> null,
  //                           "Req_DateNp"=> null,
  //                           "Office_code"=> 0,
  //                           "Demand_No"=> 0, 
  //                           "Fyear"=> null,
  //                           "Updated_Date"=> str_replace('/', '.', CURDATE_NP), 
  //                           "Updated_Time"=> $this->general->get_currenttime(),
  //                           "Updated_By" => $this->username,
  //                           "Entrytime"=> null,
		//         		); 

		//         		if($this->general->api_send_budget_demand_amount($post_data)){

		// 					$this->db->where('req_detailid',$items->purd_reqdetailid);
		// 					$this->db->where('req_masterid',$items->rede_reqmasterid);
		// 					$this->db->where('locationid',$this->locationid);
		// 					$this->db->where('orgid',$this->orgid);  
		// 					$this->db->update('api_budgetexpense',array('status' => 'C'));

		// 				}
		//         	}

  //       		}
  //       	}
  //       }
  //       return true;
        
	}

public function no_supplier($reload=false){
	$masterid = $this->input->post('masterid');
		$mattypeid = 1;
		$reqno = 1;

		// print_r($this->input->post());
		// die();

		$this->data['approved_data'] = $this->approved_mdl->get_all_approved_list();
		// echo "<pre>"; print_r($this->data['approved_data']);die;
		$this->data['order_details'] = "";
		$this->data['store'] = $this->general->get_tbl_data('*', 'eqty_equipmenttype', false, 'eqty_equipmenttypeid', 'DESC');
		$this->data['equipmentcategory'] = $this->general->get_tbl_data('*', 'eqca_equipmentcategory', false, 'eqca_equipmentcategoryid', 'DESC');
		$this->data['distributor'] = $this->general->get_tbl_data('*', 'dist_distributors', false, 'dist_distributor', 'ASC');

		$this->data['material_type'] = $this->general->get_tbl_data('*', 'maty_materialtype', array('maty_isactive' => 'Y'), 'maty_materialtypeid', 'ASC');

		// echo "<pre>";
		// print_r($this->data['material_type']);
		// die();

		$this->data['fiscal_year'] = $this->general->get_tbl_data('*', 'fiye_fiscalyear', false, 'fiye_fiscalyear_id', 'DESC', '2');
		$this->data['current_tab'] = 'purchase_order_no_supplier';
		$storeid = $this->session->userdata(STORE_ID);
		if ($masterid) {
			$this->data['requisition_details'] = $this->purchase_requisition_mdl->get_purchase_requisition_master_data(array('pure_purchasereqid' => $masterid));
			$this->data['purchase_requisition'] = $this->purchase_requisition_mdl->get_purchase_requisition_data(array('rd.purd_reqid' => $masterid));
			// echo "<pre>";
			// print_r($this->data['requisition_details']);
			// die();
			if (!empty($this->data['requisition_details'])) {
				$mattypeid = !empty($this->data['requisition_details'][0]->pure_mattypeid) ? $this->data['requisition_details'][0]->pure_mattypeid : '';
				$reqno = !empty($this->data['requisition_details'][0]->pure_reqno) ? $this->data['requisition_details'][0]->pure_reqno : '';
			}
		}

		// echo "<pre>";
		// print_r($this->data);
		// die();

		$order_no_array = array('puor_fyear' => CUR_FISCALYEAR, 'puor_locationid' => $this->locationid);

		if (ORGANIZATION_NAME == 'KU' || ORGANIZATION_NAME == 'ARMY' || ORGANIZATION_NAME == 'PU') {
			// echo "test";
			// die();
			$order_no_array['puro_mattypeid'] = $mattypeid;

			$this->data['order_no'] = $this->general->generate_form_no('puor_orderno', 'puor_purchaseordermaster', $order_no_array, 'puor_purchaseordermasterid', 'DESC');
		} else {
			// echo "test";
			// die();
			// $this->data['order_no'] = $this->general->get_tbl_data('max(puor_orderno) as ordnumb','puor_purchaseordermaster',array('puor_fyear'=>CUR_FISCALYEAR),'puor_purchaseordermasterid','DESC');
			 $this->data['order_no'] = $this->general->generate_form_no('puor_orderno', 'puor_purchaseordermaster', $order_no_array, 'puor_purchaseordermasterid', 'DESC');
		}
		// echo $this->data['order_no'];
		// die();
		// $srchbudg='';

		// echo $this->db->last_query();
		// die();
		$this->data['pure_reqno'] = $reqno;
		$this->data['puro_mattypeid'] = $mattypeid;
		$srchbudg=array('budg_isactive'=>'Y');
		$this->data['budgets_list'] = $this->general->get_tbl_data('*', 'budg_budgets', $srchbudg, 'budg_budgetname', 'ASC');
		
		if(ORGANIZATION_NAME=='ARMY'):
		// if(!empty($mattypeid)){
		// 	$srchbudg=array('budg_materialtypeid'=>$mattypeid,'budg_isactive'=>'Y');
		// }else{
			$srchbudg=array('budg_isactive'=>'Y');
		// }
		$this->data['budgets_list'] = $this->general->get_tbl_data('*', 'budg_budgets', $srchbudg, 'budg_budgetname', 'ASC');

		endif;
		// echo $this->db->last_query();
		// die();
		// echo "<pre>";print_r($this->data['order_no']);die;
		$this->data['eqty_equipmenttype'] = $this->general->get_tbl_data('*', 'eqty_equipmenttype', array('eqty_equipmenttypeid' => $storeid), 'eqty_equipmenttypeid', 'DESC');

		if (DEFAULT_DATEPICKER == 'NP') {
			$this->data['delivery_date'] = $this->general->EngToNepDateConv($this->general->add_date(CURDATE_EN, 7, 'days'));
		} else {
			$this->data['delivery_date'] = $this->general->add_date(CURDATE_EN, 7, 'days');
		}

		// die();

		$seo_data = '';
		$id = $this->input->post('id');
		// echo($id);
		// die;

		// print_r($budgets_list);
		// die();

		$this->data['purreqmasterid'] = $masterid;
		if ($id) {
			$this->data['order_details'] = $this->general->get_tbl_data('*', 'puor_purchaseordermaster', array('puor_purchaseordermasterid' => $id), 'puor_purchaseordermasterid', 'DESC');
			// echo "<pre>";
			// print_r($this->data['order_details']);
			// die();
			$this->data['orderdetails'] = $this->purchase_order_mdl->get_order_selected(array('puor_purchaseordermasterid' => $id));
			//
			//$this->->purchase_order_mdl->get_order_list();
			//echo "<pre>";print_r($this->data['orderdetails']);die;
		}
		// echo PUR_OR_FORM_TYPE;
		// die();
		if ($reload == 'reload') {
			$this->load->view('purchase_order/pu/v_purchase_order_form', $this->data);
			
		} else {
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
				// ->build('purchase_order/v_purchase_order', $this->data);
				->build('purchase_order/v_common_purchaseorder_tab', $this->data);
		}
}

}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */