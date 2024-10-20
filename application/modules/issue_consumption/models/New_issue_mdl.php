<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class New_issue_mdl extends CI_Model

{

	public function __construct()

	{

		parent::__construct();

		$this->sama_masterTable = 'sama_salemaster';

		$this->sade_detailTable = 'sade_saledetail';

		$this->tran_masterTable = 'trma_transactionmain';

		$this->tran_detailsTable = 'trde_transactiondetail';

		$this->rede_detailTable = 'rede_reqdetail';

		$this->rema_masterTable = 'rema_reqmaster';

		$this->curtime = $this->general->get_currenttime();

		$this->userid = $this->session->userdata(USER_ID);

		$this->username = $this->session->userdata(USER_NAME);

		$this->userdepid = $this->session->userdata(USER_DEPT); //storeid

		$this->storeid = !empty($this->session->userdata(STORE_ID)) ? $this->session->userdata(STORE_ID) : '1';

		$this->mac = $this->general->get_Mac_Address();

		$this->ip = $this->general->get_real_ipaddr();

		$this->locationid = $this->session->userdata(LOCATION_ID);

		$this->location_ismain = $this->session->userdata(ISMAIN_LOCATION);

		$this->orgid = $this->session->userdata(ORG_ID);

		$this->load->Model('stock_requisition_mdl', 'requisition_mdl');

		// echo $this->orgid;

		// die();

	}

	public $validate_new_issue = array(

		array('field' => 'sama_depid', 'label' => 'Department ', 'rules' => 'trim|required|xss_clean'),

		array('field' => 'sama_requisitionno', 'label' => 'Requisition No. ', 'rules' => 'trim|required|xss_clean'),

		array('field' => 'requisition_date', 'label' => 'Requisition Date ', 'rules' => 'trim|required|xss_clean'),

		array('field' => 'issue_date', 'label' => 'Issue Date ', 'rules' => 'trim|required|xss_clean'),

		array('field' => 'sade_itemsid[]', 'label' => 'Items  ', 'rules' => 'trim|required|xss_clean'),

		array('field' => 'sade_qty[]', 'label' => 'Qty  ', 'rules' => 'trim|required|numeric|greater_than[0]|xss_clean'),

		array('field' => 'qtyinstock[]', 'label' => 'Stock Qty  ', 'rules' => 'trim|required|numeric|greater_than[0]|xss_clean'),

	);

	public $validate_new_issue_edit = array(

		array('field' => 'sama_depid', 'label' => 'Department ', 'rules' => 'trim|required|xss_clean'),

		array('field' => 'sama_requisitionno', 'label' => 'Requisition No. ', 'rules' => 'trim|required|xss_clean'),

		array('field' => 'requisition_date', 'label' => 'Requisition Date ', 'rules' => 'trim|required|xss_clean'),

		array('field' => 'issue_date', 'label' => 'Issue Date ', 'rules' => 'trim|required|xss_clean'),

		array('field' => 'sade_itemsid[]', 'label' => 'Items  ', 'rules' => 'trim|required|xss_clean'),

		array('field' => 'sade_qty[]', 'label' => 'Qty  ', 'rules' => 'trim|required|numeric|greater_than[0]|xss_clean'),

	);

	public $validate_issue_return = array(

		array('field' => 'rema_returnby', 'label' => 'Return by', 'rules' => 'trim|required|xss_clean'),

		array('field' => 'rema_returndate', 'label' => 'Return Date', 'rules' => 'trim|required|xss_clean'),

		array('field' => 'rema_invoiceno', 'label' => 'Return Invoice', 'rules' => 'trim|required|xss_clean'),

		array('field' => 'returnqty[]', 'label' => 'Return Qty.', 'rules' => 'trim|numeric|xss_clean'),

	);

	public function save_new_issue()

	{

		try {

			// $postdata=$this->input->post();

			//echo "<pre>";print_r($postdata);die();

			$id = $this->input->post('id');

			$req_date = $this->input->post('requisition_date');

			$issue_date = $this->input->post('issue_date');

			if (DEFAULT_DATEPICKER == 'NP') {

				$reqdateNp = $req_date;

				$reqdateEn = $this->general->NepToEngDateConv($req_date);

				$issuedateNp = $issue_date;

				$issuedateEn = $this->general->NepToEngDateConv($issue_date);
			} else {

				$reqdateEn = $req_date;

				$reqdateNp = $this->general->EngtoNepDateConv($req_date);

				$issuedateEn = $issue_date;

				$issuedateNp = $this->general->EngtoNepDateConv($issue_date);
			}

			

		

			//master table data

			$depid = $this->input->post('sama_depid');

			$depname = $this->input->post('sama_depname');

			$locationid = !empty($this->input->post('sama_locationid')) ? $this->input->post('sama_locationid') : $this->locationid;

			if ($depid) {

				$depdata = $this->general->get_tbl_data('dept_depname', 'dept_department', array('dept_depid' => $depid), 'dept_depid', 'DESC');

				if (!empty($depdata)) {

					$depname = !empty($depdata[0]->dept_depname) ? $depdata[0]->dept_depname : 'Y';
				}
			} else {

				$depname = '';
			}

			$req_no = $this->input->post('sama_requisitionno');

			$fiscal_year = $this->input->post('sama_fyear');

			// $issue_no = $this->input->post('sama_invoiceno');

			$locationid = $this->session->userdata(LOCATION_ID);

			$currentfyrs = !empty($fiscal_year)?$fiscal_year:CUR_FISCALYEAR;
			$get_last_billno = $this->general->get_tbl_data('sama_billno', 'sama_salemaster', array('sama_fyear' => $currentfyrs,'sama_locationid'=>$this->locationid), 'sama_salemasterid', 'DESC');
			$billno = !empty($get_last_billno[0]->sama_billno) ? $get_last_billno[0]->sama_billno : 0;


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

			// $this->data['issue_no'] = $this->general->generate_invoiceno('sama_invoiceno','sama_invoiceno','sama_salemaster',$invoice_no_prefix,INVOICE_NO_LENGTH,false,'sama_locationid');

			if (ORGANIZATION_NAME == 'KU' || ORGANIZATION_NAME == 'PU' ||  ORGANIZATION_NAME == 'ARMY' || ORGANIZATION_NAME == 'NPHL') {

				$invoice_no_prefix = '';

				// $issue_no = $this->general->generate_invoiceno('sama_invoiceno','sama_invoiceno','sama_salemaster',$invoice_no_prefix,INVOICE_NO_LENGTH,false,'sama_locationid',false,false,false,'Y');
				$issue_no = $this->general->generate_invoiceno('sama_invoiceno', 'sama_invoiceno', 'sama_salemaster', $invoice_no_prefix, INVOICE_NO_LENGTH, array('sama_fyear'=>$currentfyrs), 'sama_locationid', 'sama_salemasterid', 'S', 'DESC', 'Y');

				// $location_fieldname =false,$order_by=false,$order_type='S',$order='DESC',$is_disable_prefix='N')

			} else {

				$issue_no = $this->general->generate_invoiceno('sama_invoiceno', 'sama_invoiceno', 'sama_salemaster', $invoice_no_prefix, INVOICE_NO_LENGTH, array('sama_fyear'=>$currentfyrs), 'sama_locationid', 'sama_salemasterid', 'S', 'DESC');
			}

			// print_r($issue_no);

			// die();

			$received_by = $this->input->post('sama_receivedby');

			$unit = $this->input->post('unit');

			//detail table data

			$itemsid = $this->input->post('sade_itemsid');

			$qtyinstock = $this->input->post('qtyinstock');

			// echo "<pre>";

			// print_r($itemsid);

			// die();

			$unitrate = $this->input->post('sade_unitrate'); //save in unitrate,nrate,purchaserate

			$qty = $this->input->post('sade_qty');

			$remarks = $this->input->post('sade_remarks');

			$sama_remarks = $this->input->post('sama_remarks');

			$itemsname = $this->input->post('sade_itemsname');

			$my_rem_qty = $this->input->post('my_rem_qty');

			$volume = $this->input->post('volume');

			$s_no = $this->input->post('s_no');

			$rede_reqdetailid = $this->input->post('rede_reqdetailid');

			$sama_mattypeid = $this->input->post('sama_mattypeid');

			$this->db->trans_begin();

			if ($id) {

				// update case

				$samaMasterArray = array(

					'sama_requisitionno' => $req_no,

					'sama_depid' => $depid, //depid

					'sama_depname' => $depname, //depname

					'sama_billdatead' => $issuedateEn,

					'sama_billdatebs' => $issuedateNp,

					'sama_billtime' => $this->curtime,

					'sama_duedatead' => $issuedateEn,

					'sama_duedatebs' => $issuedateNp,

					'sama_soldby' => $this->username,

					'sama_username' => $this->username,

					'sama_receivedby' => strtoupper($received_by),

					'sama_lastchangedate' => '',

					'sama_orderno' => 0,

					'sama_challanno' => 0,

					'sama_billno' => $billno + 1,

					'sama_payment' => 0, //0

					'sama_status' => 'O', //O

					'sama_fyear' => $fiscal_year,

					'sama_discountpc' => '',

					'sama_st' => 'N',

					'sama_invoiceno' => $issue_no,

					'sama_manualbillno' => '',

					'sama_requisitiondatead' => $reqdateEn,

					'sama_requisitiondatebs' => $reqdateNp,

					'sama_storeid' => $this->storeid,

					'sama_remarks' => $sama_remarks,

					'sama_postdatead' => CURDATE_EN,

					'sama_postdatebs' => CURDATE_NP,

					'sama_postby' => $this->userid,

					'sama_postmac' => $this->mac,

					'sama_postip' => $this->ip,

					'sama_orgid' => $this->orgid,

					'sama_locationid' => $locationid,

				);

				//get old saledetail id

				$old_sade_list = $this->get_all_sade_id(array('sade_salemasterid' => $id));

				$old_sade_array = array();

				if (!empty($old_sade_list)) {

					foreach ($old_sade_list as $key => $value) {

						$old_sade_array[] = $value->sade_saledetailid;
					}
				}

				if (!empty($samaMasterArray)) {

					// $ReqMasterArray = array(

					// 				'rema_received'=>'1'

					// 				);

					if (defined('IS_DEMANDER_ACCEPT_ISSUE')) :

						if (IS_DEMANDER_ACCEPT_ISSUE == 'Y') {

							$ReqMasterArray = array(

								'rema_received' => '0'

							);
						} else {

							$ReqMasterArray = array(

								'rema_received' => '1'

							);
						}

					else :

						$ReqMasterArray = array(

							'rema_received' => '1'

						);

					endif;

					if ($ReqMasterArray) {

						$this->general->save_log($this->rema_masterTable, 'rema_reqno', $req_no, $ReqMasterArray, 'Update');

						$this->db->update($this->rema_masterTable, $ReqMasterArray, array('rema_reqno' => $req_no, 'rema_fyear' => $fiscal_year, 'rema_storeid' => $this->storeid));
					}

					$rowaffected = $this->db->affected_rows();

					$sade_insertid = array();

					if ($rowaffected) {

						if (!empty($itemsid)) {

							foreach ($itemsid as $key => $val) {

								$sade_detailid = !empty($reqdetailid[$key]) ? $reqdetailid[$key] : '';

								if ($sade_detailid) {

									if (in_array($sade_detailid, $old_sade_array)) {

										$sade_array[] = $sade_detailid;
									}

									$sade_update_array = array();

									$this->db->update($this->sade_detailTable, $sade_update_array, array('sade_saledetailid' => $sade_detailid));
								} // if sade_detailid

								else {

									$sade_insert_array = array();

									$this->db->insert($this->sade_detailTable, $sade_insert_array);

									$sade_insertid[] = $this->db->insert_id();
								}
							} // endforeach itemsid

							// if(!empty($sade_array)){

							//     if(!empty($sade_insertid)){

							//         $this->db->where_not_in('sade_saledetailid',$sade_insertid);

							//     }

							//     $this->db->where(array('sade_salemasterid'=>$id));

							//     $this->db->where_not_in('sade_saledetailid',$sade_array);

							//     $this->db->update($this->rede_detailTable,array('sade_isdelete'=>'Y'));

							// } // end if sade_array

						}
					}
				}
			} // end if id

			else {

				// insert case

				$samaMasterArray = array(

					'sama_requisitionno' => $req_no,

					'sama_depid' => $depid, //depid

					'sama_depname' => $depname, //depname

					'sama_billdatead' => $issuedateEn,

					'sama_billdatebs' => $issuedateNp,

					'sama_billtime' => $this->curtime,

					'sama_duedatead' => $issuedateEn,

					'sama_duedatebs' => $issuedateNp,

					'sama_soldby' => $this->username,

					'sama_username' => $this->username,

					'sama_lastchangedate' => '',

					'sama_orderno' => 0,

					'sama_challanno' => 0,

					'sama_billno' => $billno + 1,

					'sama_payment' => 0, //0

					'sama_status' => 'O', //O

					'sama_fyear' => $fiscal_year,

					'sama_discountpc' => '',

					'sama_st' => 'N',

					'sama_invoiceno' => $issue_no,

					'sama_manualbillno' => '',

					'sama_requisitiondatead' => $reqdateEn,

					'sama_requisitiondatebs' => $reqdateNp,

					'sama_storeid' => $this->storeid,

					'sama_remarks' => $sama_remarks,

					'sama_receivedby' => strtoupper($received_by),

					'sama_postdatead' => CURDATE_EN,

					'sama_postdatebs' => CURDATE_NP,

					'sama_postby' => $this->userid,

					'sama_postmac' => $this->mac,

					'sama_postip' => $this->ip,

					'sama_locationid' => $locationid,

					'sama_orgid' => $this->orgid

				);

				if (!empty($samaMasterArray)) {   //print_r($samaMasterArray);die;

					// insert into sale master

					if (!empty($sama_mattypeid)) {

						$samaMasterArray['sama_mattypeid'] = $sama_mattypeid;
					}

					$this->db->insert($this->sama_masterTable, $samaMasterArray);

					$insertid = $this->db->insert_id();

					if ($insertid) {

						$ReqMasterArray = array(

							'rema_received' => '1'

						);


						if ($ReqMasterArray) {

							$this->general->save_log($this->rema_masterTable, 'rema_reqno', $req_no, $ReqMasterArray, 'Update');
							$where_arr=array('rema_reqno' => $req_no, 'rema_fyear' => $fiscal_year, 'rema_storeid' => $this->storeid);

							if(ORGANIZATION_NAME=='KU' || ORGANIZATION_NAME=='PU'){
								$where_arr['rema_mattypeid']=$sama_mattypeid;
							}

							$this->db->update($this->rema_masterTable, $ReqMasterArray,$where_arr );
						}

						//update remqty of req detail

						if (!empty($itemsid)) :

							foreach ($itemsid as $key => $val) {

								$reqDetail[] = array(

									'rede_reqdetailid' => !empty($rede_reqdetailid[$key]) ? $rede_reqdetailid[$key] : '',

									'rede_remqty' => !empty($my_rem_qty[$key]) ? $my_rem_qty[$key] : '',

									'rede_modifydatead' => CURDATE_EN,

									'rede_modifydatebs' => CURDATE_NP,

									'rede_modifytime' => $this->curtime,

									'rede_modifyby' => $this->userid,

									'rede_modifymac' => $this->mac,

									'rede_modifyip' => $this->ip,

									'rede_locationid' => $locationid

								);
							} // end foreach item

							if ($reqDetail) {

								$this->db->update_batch($this->rede_detailTable, $reqDetail, 'rede_reqdetailid');
							}

						endif;

						$totalRateAmount = 0;

						$totalDiscount = 0;

						$totalVat = 0;

						$totalNetrate = 0;

						$totalAmount = 0;

						$totalTaxrate = 0;

						$discountpc = 0;

						//insert into sale detail table

						// echo "REQ<pre>";

						// print_r($rede_reqdetailid);

						// // die();

						// echo "REM<pre>";

						// print_r($remarks);

						// // die();

						// echo "SN<pre>";

						// print_r($s_no);

						// die();

						if (!empty($itemsid)) :

							foreach ($itemsid as $key => $val) {

								$items_id = !empty($itemsid[$key]) ? $itemsid[$key] : '';

								$issue_qty = !empty($qty[$key]) ? $qty[$key] : '';

								$reqdetailid = !empty($rede_reqdetailid[$key]) ? $rede_reqdetailid[$key] : '';

								$rmks = !empty($remarks[$key]) ? $remarks[$key] : '';

								$sno = !empty($s_no[$key]) ? $s_no[$key] : '';

								// $volume = !empty($volume[$key])?$volume[$key]:'';

								$volume = 0;

								$microunitid = 0;

								// $mattransdetailid = $this->get_mat_trans_detail_id($items_id,$volume,$microunitid,$issue_qty);

								$this->insert_into_sale_master($items_id, $issue_qty, $insertid, $reqdetailid, $rmks, $sno);

								// $checkSalesMaster = $this->update_mat_trans_detailid($mattransdetailid,$issue_qty,'new_issue');

								$unitrate = !empty($unitrate[$key]) ? $unitrate[$key] : 0;

								$totalAmount += $unitrate;
							}

							// die();

							$updateMasterSaleArray = array(

								'sama_discountpc' => $discountpc,

								'sama_discount' => $totalDiscount,

								'sama_vat' => $totalVat,

								'sama_taxrate' => $totalTaxrate,

								'sama_totalamount' => $totalAmount

							);

							if ($updateMasterSaleArray) {

								$this->db->where('sama_salemasterid', $insertid);

								$this->db->update($this->sama_masterTable, $updateMasterSaleArray);
							}

						endif;
					} // end if insertid

				} // if samaMasterArray

			}

			$this->db->trans_complete();

			if ($this->db->trans_status() === FALSE) {

				$this->db->trans_rollback();

				trigger_error("Commit failed");

				// return false;

			} else {

				$this->db->trans_commit();

				if ($id) {

					return $id;
				} else {

					return $insertid;
				}
			}
		} catch (Exception $e) {

			throw $e;
		}
	}

	public function save_new_issue_edit()

	{

		try {

			$postdata = $this->input->post();

			// echo "<pre>";print_r($postdata);die();

			$id = $this->input->post('id');

			$req_date = $this->input->post('requisition_date');

			$issue_date = $this->input->post('issue_date');

			if (DEFAULT_DATEPICKER == 'NP') {

				$reqdateNp = $req_date;

				$reqdateEn = $this->general->NepToEngDateConv($req_date);

				$issuedateNp = $issue_date;

				$issuedateEn = $this->general->NepToEngDateConv($issue_date);
			} else {

				$reqdateEn = $req_date;

				$reqdateNp = $this->general->EngtoNepDateConv($req_date);

				$issuedateEn = $issue_date;

				$issuedateNp = $this->general->EngtoNepDateConv($issue_date);
			}

			$get_last_billno = $this->general->get_tbl_data('sama_billno', 'sama_salemaster', array('sama_fyear' => CUR_FISCALYEAR), 'sama_salemasterid', 'DESC');

			$billno = !empty($get_last_billno[0]->sama_billno) ? $get_last_billno[0]->sama_billno : 0;

			//master table data

			$depid = $this->input->post('sama_depid');

			$depname = $this->input->post('sama_depname');

			$locationid = !empty($this->input->post('sama_locationid')) ? $this->input->post('sama_locationid') : $this->locationid;

			$req_no = $this->input->post('sama_requisitionno');

			$fiscal_year = $this->input->post('sama_fyear');

			// $issue_no = $this->input->post('sama_invoiceno');

			$issue_no = $this->general->generate_invoiceno('sama_invoiceno', 'sama_invoiceno', 'sama_salemaster', INVOICE_NO_PREFIX, INVOICE_NO_LENGTH, false, 'sama_locationid');

			// print_r($issue_no);

			// die();

			$received_by = $this->input->post('sama_receivedby');

			$unit = $this->input->post('unit');

			//detail table data

			$itemsid = $this->input->post('sade_itemsid');

			$qtyinstock = $this->input->post('qtyinstock');

			// echo "<pre>";

			// print_r($itemsid);

			// die();

			$unitrate = $this->input->post('sade_unitrate'); //save in unitrate,nrate,purchaserate

			$qty = $this->input->post('sade_qty');

			$remarks = $this->input->post('sade_remarks');

			$sama_remarks = $this->input->post('sama_remarks');

			$itemsname = $this->input->post('sade_itemsname');

			$my_rem_qty = $this->input->post('my_rem_qty');

			$volume = $this->input->post('volume');

			$s_no = $this->input->post('s_no');

			$sade_saledetailid = $this->input->post('sade_saledetailid');

			$mat_transdetailid = $this->input->post('sade_mattransdetailid');

			// echo "<pre>";

			// print_r($rede_reqdetailid);

			// die();

			$this->db->trans_begin();

			$tranmasterid = '';

			if ($id) {

				// $transdtlid=!empty($mat_transdetailid[0])?$mat_transdetailid[0]:'';

				// echo $transdtlid;

				// die();

				// if(!empty($transdtlid)){

				// 	$this->db->select('trde_trdeid,trde_trmaid,trde_itemsid');

				// 	$this->db->from('trde_transactiondetail');

				// 	$this->db->where('trde_trdeid',$transdtlid);

				// 	$this->db->order_by('trde_trdeid','ASC');

				// 	$rslt_trdetail=$this->db->get()->row();

				// 	// echo "<pre>";

				// 	// print_r($rslt_trdetail);

				// 	// die();

				// 	if(!empty($rslt_trdetail)){

				// 		$tranmasterid=$rslt_trdetail->trde_trmaid;

				// 	}

				// }

				// update case

				$samaMasterArray = array(

					'sama_billdatead' => $issuedateEn,

					'sama_billdatebs' => $issuedateNp,

					'sama_billtime' => $this->curtime,

					'sama_duedatead' => $issuedateEn,

					'sama_duedatebs' => $issuedateNp,

					'sama_receivedby' => strtoupper($received_by),

					'sama_fyear' => $fiscal_year,

					'sama_requisitiondatead' => $reqdateEn,

					'sama_requisitiondatebs' => $reqdateNp,

					'sama_remarks' => $sama_remarks,

					'sama_modifydatead' => CURDATE_EN,

					'sama_modifydatebs' => CURDATE_NP,

					'sama_modifyby' => $this->userid,

					'sama_modifymac' => $this->mac,

					'sama_modifyip' => $this->ip

				);

				// echo "<pre>";

				// print_r($samaMasterArray);

				// die();

				$this->general->save_log('sama_salemaster', 'sama_salemasterid', $id, $samaMasterArray, 'Update');

				//get old saledetail id

				$old_sade_list = $this->get_all_sade_id(array('sade_salemasterid' => $id));

				// echo "<pre>";

				// print_r($old_sade_list);

				// die();

				$old_sade_array = array();

				if (!empty($old_sade_list)) {

					foreach ($old_sade_list as $key => $value) {

						$old_sade_array[] = $value->sade_saledetailid;
					}
				}

				if (!empty($samaMasterArray)) {

					// $sade_insertid = array();

					$this->db->update('sama_salemaster', $samaMasterArray, array('sama_salemasterid' => $id));

					$rwaffupdateMaster = $this->db->affected_rows();

					if (!empty($itemsid)) {

						foreach ($itemsid as $key => $val) {

							$sdetailid = !empty($sade_saledetailid[$key]) ? $sade_saledetailid[$key] : '';

							$itm_id = !empty($itemsid[$key]) ? $itemsid[$key] : '';

							$mat_detailid = !empty($mat_transdetailid[$key]) ? $mat_transdetailid[$key] : '';

							$item_qty = !empty($qty[$key]) ? $qty[$key] : '0';

							$trans_detail_tbl_qty = $this->get_tran_detail_items_id($mat_detailid, $itm_id);

							$issue_detail_tbl_qty = $this->get_sales_detail_items_id($sdetailid, $itm_id);

							$issue_detail_tbl_rec = $this->get_sales_detail_items_id($sdetailid, $itm_id, 'all');

							// print_r($issue_detail_tbl_rec);

							// die();

							$this->db->insert('sade_saledetail_log', $issue_detail_tbl_rec);

							$sade_update_array = array(

								'sade_qty' => $item_qty,

								'sade_curqty' => $item_qty,

								'sade_remarks' => $remarks[$key],

								'sade_modifydatead' => CURDATE_EN,

								'sade_modifydatebs' => CURDATE_NP,

								'sade_modifytime' => $this->curtime,

								'sade_modifymac' => $this->mac,

								'sade_modifyip' => $this->ip,

								'sade_modifyby' => $this->userid

							);

							$this->general->save_log('sade_saledetail', 'sade_saledetailid', $sdetailid, $sade_update_array, 'Update');

							$this->db->update($this->sade_detailTable, $sade_update_array, array('sade_saledetailid' => $sdetailid));

							$rwaffupdatedetail = $this->db->affected_rows();

							if (!empty($rwaffupdatedetail)) {

								$new_transqty = $issue_detail_tbl_qty - $item_qty;

								// if($new_transqty>0)

								// {

								$new_trans_dtl_added_qty = $trans_detail_tbl_qty + $new_transqty;

								// }

								// else

								// {

								// 	$new_trans_dtl_added_qty=$trans_detail_tbl_qty-$new_transqty;

								// }

								$update_trans_detailArray = array('trde_issueqty' => $new_trans_dtl_added_qty);

								$this->general->save_log('trde_transactiondetail', 'trde_trdeid', $mat_detailid, $update_trans_detailArray, 'Update');

								$this->db->update('trde_transactiondetail', $update_trans_detailArray, array('trde_trdeid' => $mat_detailid));
							}
						}
					} // endforeach itemsid

				}
			} // end if id

			else {

				// insert case

				$samaMasterArray = array(

					'sama_requisitionno' => $req_no,

					'sama_depid' => $depid, //depid

					'sama_depname' => $depname, //depname

					'sama_billdatead' => $issuedateEn,

					'sama_billdatebs' => $issuedateNp,

					'sama_billtime' => $this->curtime,

					'sama_duedatead' => $issuedateEn,

					'sama_duedatebs' => $issuedateNp,

					'sama_soldby' => $this->username,

					'sama_username' => $this->username,

					'sama_lastchangedate' => '',

					'sama_orderno' => 0,

					'sama_challanno' => 0,

					'sama_billno' => $billno + 1,

					'sama_payment' => 0, //0

					'sama_status' => 'O', //O

					'sama_fyear' => $fiscal_year,

					'sama_discountpc' => '',

					'sama_st' => 'N',

					'sama_invoiceno' => $issue_no,

					'sama_manualbillno' => '',

					'sama_requisitiondatead' => $reqdateEn,

					'sama_requisitiondatebs' => $reqdateNp,

					'sama_storeid' => $this->storeid,

					'sama_remarks' => $sama_remarks,

					'sama_receivedby' => strtoupper($received_by),

					'sama_postdatead' => CURDATE_EN,

					'sama_postdatebs' => CURDATE_NP,

					'sama_postby' => $this->userid,

					'sama_postmac' => $this->mac,

					'sama_postip' => $this->ip,

					'sama_locationid' => $locationid,

					'sama_orgid' => $this->orgid

				);

				if (!empty($samaMasterArray)) {   //print_r($samaMasterArray);die;

					// insert into sale master

					$this->db->insert($this->sama_masterTable, $samaMasterArray);

					$insertid = $this->db->insert_id();

					if ($insertid) {

						$ReqMasterArray = array(

							'rema_received' => '1'

						);

						if ($ReqMasterArray) {

							$this->general->save_log($this->rema_masterTable, 'rema_reqno', $req_no, $ReqMasterArray, 'Update');

							$this->db->update($this->rema_masterTable, $ReqMasterArray, array('rema_reqno' => $req_no, 'rema_fyear' => $fiscal_year, 'rema_storeid' => $this->storeid));
						}

						//update remqty of req detail

						if (!empty($itemsid)) :

							foreach ($itemsid as $key => $val) {

								$reqDetail[] = array(

									'rede_reqdetailid' => !empty($rede_reqdetailid[$key]) ? $rede_reqdetailid[$key] : '',

									'rede_remqty' => !empty($my_rem_qty[$key]) ? $my_rem_qty[$key] : '',

									'rede_modifydatead' => CURDATE_EN,

									'rede_modifydatebs' => CURDATE_NP,

									'rede_modifytime' => $this->curtime,

									'rede_modifyby' => $this->userid,

									'rede_modifymac' => $this->mac,

									'rede_modifyip' => $this->ip,

									'rede_locationid' => $locationid

								);
							} // end foreach item

							if ($reqDetail) {

								$this->db->update_batch($this->rede_detailTable, $reqDetail, 'rede_reqdetailid');
							}

						endif;

						$totalRateAmount = 0;

						$totalDiscount = 0;

						$totalVat = 0;

						$totalNetrate = 0;

						$totalAmount = 0;

						$totalTaxrate = 0;

						$discountpc = 0;

						//insert into sale detail table

						// echo "REQ<pre>";

						// print_r($rede_reqdetailid);

						// // die();

						// echo "REM<pre>";

						// print_r($remarks);

						// // die();

						// echo "SN<pre>";

						// print_r($s_no);

						// die();

						if (!empty($itemsid)) :

							foreach ($itemsid as $key => $val) {

								$items_id = !empty($itemsid[$key]) ? $itemsid[$key] : '';

								$issue_qty = !empty($qty[$key]) ? $qty[$key] : '';

								$reqdetailid = !empty($rede_reqdetailid[$key]) ? $rede_reqdetailid[$key] : '';

								$rmks = !empty($remarks[$key]) ? $remarks[$key] : '';

								$sno = !empty($s_no[$key]) ? $s_no[$key] : '';

								// $volume = !empty($volume[$key])?$volume[$key]:'';

								$volume = 0;

								$microunitid = 0;

								// $mattransdetailid = $this->get_mat_trans_detail_id($items_id,$volume,$microunitid,$issue_qty);

								$this->insert_into_sale_master($items_id, $issue_qty, $insertid, $reqdetailid, $rmks, $sno);

								// $checkSalesMaster = $this->update_mat_trans_detailid($mattransdetailid,$issue_qty,'new_issue');

								$unitrate = !empty($unitrate[$key]) ? $unitrate[$key] : 0;

								$totalAmount += $unitrate;
							}

							// die();

							$updateMasterSaleArray = array(

								'sama_discountpc' => $discountpc,

								'sama_discount' => $totalDiscount,

								'sama_vat' => $totalVat,

								'sama_taxrate' => $totalTaxrate,

								'sama_totalamount' => $totalAmount

							);

							if ($updateMasterSaleArray) {

								$this->db->where('sama_salemasterid', $insertid);

								$this->db->update($this->sama_masterTable, $updateMasterSaleArray);
							}

						endif;
					} // end if insertid

				} // if samaMasterArray

			}

			$this->db->trans_complete();

			if ($this->db->trans_status() === FALSE) {

				$this->db->trans_rollback();

				trigger_error("Commit failed");

				// return false;

			} else {

				$this->db->trans_commit();

				if ($id) {

					return $id;
				} else {

					return $insertid;
				}
			}
		} catch (Exception $e) {

			throw $e;
		}
	}

	public function get_tran_detail_items_id($mat_transid, $items_id)

	{

		$this->db->select('mtd.trde_issueqty');

		$this->db->from('trde_transactiondetail mtd');

		$this->db->where(array('trde_trdeid' => $mat_transid, 'trde_itemsid' => $items_id));

		$qrydata = $this->db->get();

		$data = $qrydata->row();

		if ($data) {

			return $data->trde_issueqty;
		}

		return false;
	}

	public function get_sales_detail_items_id($saledetailid, $items_id, $all = false)

	{

		if ($all == 'all') {

			$this->db->select('sd.*');

			$this->db->from('sade_saledetail sd');

			$this->db->where(array('sd.sade_saledetailid' => $saledetailid, 'sd.sade_itemsid' => $items_id));

			$query = $this->db->get();

			if ($query->num_rows() > 0) {

				$result = $query->row();

				return $result;
			}
		} else {

			$this->db->select('sd.sade_qty,sd.sade_curqty');

			$this->db->from('sade_saledetail sd');

			$this->db->where(array('sd.sade_saledetailid' => $saledetailid, 'sd.sade_itemsid' => $items_id));

			$qrydata = $this->db->get();

			$data = $qrydata->row();

			if ($data) {

				return $data->sade_curqty;
			}

			return false;
		}
	}

	public function insert_into_sale_master($items_id, $issue_qty, $salesmasteid, $rede_reqdetailid, $remarks, $s_no, $issue_catid = false, $issue_budgetid = false)

	{

		// $s_no = $this->input->post('s_no');

		// $rede_reqdetailid = $this->input->post('rede_reqdetailid');

		// $remarks=$this->input->post('remarks');

		$issue_no = $this->input->post('sama_invoiceno');

		$this->db->select('mtd.trde_trdeid, mtd.trde_unitprice, mtd.trde_selprice, mtd.trde_controlno, mtd.trde_expdatebs, mtd.trde_issueqty');

		$this->db->from('trde_transactiondetail mtd');

		$this->db->join('trma_transactionmain mtm', 'mtm.trma_trmaid = mtd.trde_trmaid', 'LEFT');

		$this->db->where(array('mtd.trde_locationid' => $this->locationid));

		$this->db->where(array('trde_issueqty>' => '0', 'trma_received' => '1', 'trde_status' => 'O'));

		$this->db->where(array('trde_itemsid' => $items_id));

		if (defined('INVENTORY_VALUATION')) {

			if (INVENTORY_VALUATION == 'LIFO') {

				$this->db->order_by('trde_trdeid', 'DESC');
			} else {

				$this->db->order_by('trde_trdeid', 'ASC');
			}
		} else {

			$this->db->order_by('trde_trdeid', 'ASC');
		}

		$this->db->limit(1);

		$qrydata = $this->db->get();

		// echo $this->db->last_query();

		// die();

		$data = $qrydata->row();

		if ($data) {

			$db_issueqty = $data->trde_issueqty;

			$db_unitprice = $data->trde_unitprice;

			$mattransdetailid = $data->trde_trdeid;

			$rem_issue = $issue_qty - $db_issueqty;

			if ($rem_issue > 0) {

				// $data->trde_trdeid;    

				$issueqty = $db_issueqty;
			} else {

				if ($rem_issue <= 0) {

					$rm_issue = - ($rem_issue);

					$issueqty = $db_issueqty - $rm_issue;
				}
			}

			$saleDetail = array(

				'sade_salemasterid' => $salesmasteid,

				'sade_itemsid' => !empty($items_id) ? $items_id : '',

				'sade_unitrate' => $db_unitprice,

				'sade_purchaserate' => $db_unitprice,

				'sade_qty' => !empty($issueqty) ? $issueqty : 0,

				'sade_curqty' => !empty($issueqty) ? $issueqty : 0,

				'sade_discount' => 0,

				'sade_batchno' => 0,

				'sade_mfgdate' => 0,

				'sade_expdate' => '',

				'sade_mattransdetailid' => $mattransdetailid,

				'sade_status' => 'O',

				'sade_controlno' => '',

				'sade_invoiceno' => $issue_no,

				'sade_billdatead' => CURDATE_EN,

				'sade_billdatebs' => CURDATE_NP,

				'sade_billtime' => $this->curtime,

				'sade_username' => $this->username,

				'sade_sno' => $s_no,

				'sade_reqdetailid' => $rede_reqdetailid,

				'sade_remarks' => $remarks,

				'sade_postdatead' => CURDATE_EN,

				'sade_postdatebs' => CURDATE_NP,

				'sade_posttime' => $this->curtime,

				'sade_postby' => $this->userid,

				'sade_postmac' => $this->mac,

				'sade_postip' => $this->ip,

				'sade_locationid' => $this->locationid,

				'sade_orgid' => $this->orgid,

			);

			if (ORGANIZATION_NAME == "KUKL") {
				$saleDetail['sade_catid'] =  $issue_catid;
				$saleDetail['sade_budgetheadid'] = $issue_budgetid;
			}

			if (!empty($saleDetail)) {

				// echo"<pre>";print_r($saleDetail);die;

				$this->db->insert($this->sade_detailTable, $saleDetail);
			}

			if ($rem_issue > 0) {

				// $data->trde_trdeid;    

				$issueqty = $db_issueqty;

				$this->update_trde_issue_qty(0, $data->trde_trdeid);

				$this->insert_into_sale_master($items_id, $rem_issue, $salesmasteid, $rede_reqdetailid, $remarks, $s_no, $issue_catid, $issue_budgetid);

				// return   

			} else {

				if ($rem_issue <= 0) {

					$rem_issue = - ($rem_issue);

					$issueqty = $rem_issue;

					$this->update_trde_issue_qty($rem_issue, $data->trde_trdeid);

					// $this->insert_into_sale_master($items_id,$rem_issue,$salesmasteid,$rede_reqdetailid,$remarks,$s_no);

					return $data->trde_trdeid;
				}
			}

			// foreach($data as $d):

			// echo "<pre>";

			// print_r('rem_issue '.$rem_issue);

			// echo "<br/>";

			// print_r('db_issue '.$db_issueqty);

			// echo "<br/>";

			// print_r('issue '.$issueqty);

			// echo "<br/>";

			// print_r('matd '.$data->trde_trdeid);

			// echo "<br/>";

			// echo $this->db->last_query();

			// endforeach;

			// die();

		}
	}

	public function get_salemaster_date_id($srchcol = false)
	{

		$this->db->select('sm.*,lo.loca_name');

		$this->db->from('sama_salemaster sm');

		$this->db->join('loca_location lo', 'lo.loca_locationid=sm.sama_locationid', 'LEFT');

		if ($srchcol) {

			$this->db->where($srchcol);
		}

		$result = $this->db->get()->result();
		// echo $this->db->last_query();
		// echo "<pre>";
		// print_r($result);
		// die();

		return $result;
	}

	public function get_all_sade_id($srchcol = false)
	{

		try {

			$this->db->select('sade_saledetailid');

			$this->db->from($this->sade_detailTable);

			if ($srchcol) {

				$this->db->where($srchcol);
			}

			$query = $this->db->get();

			if ($query->num_rows() > 0) {

				$result = $query->result();

				return $result;
			}
		} catch (Exception $e) {

			throw $e;
		}
	}

	public function get_selected_issue()

	{

		$depid = $this->input->post('depid');

		$reqno = $this->input->post('reqno');

		$this->db->select('r.*,rm.*');

		if ($reqno) {

			$this->db->where('rm.rema_reqno', $reqno);
		}

		if ($depid) {

			$this->db->where('r.rede_storeid', $depid);
		}

		$query = $this->db->get();

		// echo $this->db->last_query(); die();

		if ($query->num_rows() > 0) {

			$data = $query->result();

			return $data;
		}

		return false;
	}

	public function get_issue_book_details_list($cond = false)

	{

		$frmDate = $this->input->get('frmDate');

		$toDate = $this->input->get('toDate');

		$get = $_GET;

		foreach ($get as $key => $value) {

			$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
		}

		if (!empty(($frmDate && $toDate))) {

			if (DEFAULT_DATEPICKER == 'NP') {

				$this->db->where('sama_billdatebs >=', $frmDate);

				$this->db->where('sama_billdatebs <=', $toDate);
			} else {

				$this->db->where('sama_billdatead >=', $frmDate);

				$this->db->where('sama_billdatead <=', $toDate);
			}
		}

		if (!empty($get['sSearch_1'])) {

			$this->db->where("lower(sama_invoiceno) like  '%" . $get['sSearch_1'] . "%'  ");
		}

		if (!empty($get['sSearch_2'])) {

			$this->db->where("lower(sama_billdatebs) like  '%" . $get['sSearch_2'] . "%'  ");
		}

		if (!empty($get['sSearch_3'])) {

			$this->db->where("lower(sama_requisitionno) like  '%" . $get['sSearch_3'] . "%'  ");
		}

		if (!empty($get['sSearch_4'])) {

			$this->db->where("lower(itli_itemcode) like  '%" . $get['sSearch_4'] . "%'  ");
		}

		if (!empty($get['sSearch_5'])) {

			$this->db->where("lower(itli_itemname) like  '%" . $get['sSearch_5'] . "%' OR itli_itemnamenp like  '%" . $get['sSearch_5'] . "%' ");
		}

		if (!empty($get['sSearch_6'])) {

			$this->db->where("lower(sama_depname) like  '%" . $get['sSearch_6'] . "%'  ");
		}

		if (!empty($get['sSearch_7'])) {

			$this->db->where("lower(sama_username) like  '%" . $get['sSearch_7'] . "%'  ");
		}

		if (!empty($get['sSearch_8'])) {

			$this->db->where("lower(sama_receivedby) like  '%" . $get['sSearch_8'] . "%'  ");
		}

		if (!empty($get['sSearch_11'])) {

			$this->db->where("lower(sade_unitrate) like  '%" . $get['sSearch_11'] . "%'  ");
		}

		if (!empty($get['sSearch_10'])) {

			$this->db->where("lower(sade_qty) like  '%" . $get['sSearch_10'] . "%'  ");
		}

		if ($cond) {

			$this->db->where($cond);
		}

		$input_locationid = !empty($get['locationid']) ? $get['locationid'] : $this->input->post('locationid');

		if ($this->location_ismain == 'Y') {

			if ($input_locationid) {

				$this->db->where('sd.sade_locationid', $input_locationid);
			}
		} else {

			$this->db->where('sd.sade_locationid', $this->locationid);
		}

		$resltrpt = $this->db->select("COUNT(*) as cnt")

			->from('sade_saledetail sd')

			->join('sama_salemaster rn', 'rn.sama_salemasterid = sd.sade_salemasterid', 'LEFT')

			->join('itli_itemslist eq', 'eq.itli_itemlistid = sd.sade_itemsid', 'LEFT')

			->get()->row();

		//echo $this->db->last_query();die(); 

		$totalfilteredrecs = ($resltrpt->cnt);

		$order_by = 'sama_requisitionno';

		$order = 'desc';

		if ($this->input->get('sSortDir_0')) {

			$order = $this->input->get('sSortDir_0');
		}

		$where = '';

		if ($this->input->get('iSortCol_0') == 1)

			$order_by = 'sama_invoiceno';

		else if ($this->input->get('iSortCol_0') == 2)

			if (DEFAULT_DATEPICKER == 'NP') {

				$order_by = 'sama_billdatebs';
			} else {

				$order_by = 'sama_billdatead';
			}

		else if ($this->input->get('iSortCol_0') == 3)

			$order_by = 'sama_requisitionno';

		else if ($this->input->get('iSortCol_0') == 4)

			$order_by = 'itli_itemcode';

		else if ($this->input->get('iSortCol_0') == 5)

			$order_by = 'itli_itemname';

		else if ($this->input->get('iSortCol_0') == 6)

			$order_by = 'sama_depname';

		else if ($this->input->get('iSortCol_0') == 7)

			$order_by = 'sama_username';

		else if ($this->input->get('iSortCol_0') == 8)

			$order_by = 'sama_receivedby';

		else if ($this->input->get('iSortCol_0') == 9)

			$order_by = 'sama_billtime';

		else if ($this->input->get('iSortCol_0') == 10)

			$order_by = 'sade_qty';

		else if ($this->input->get('iSortCol_0') == 11)

			$order_by = 'sade_unitrate';

		else if ($this->input->get('iSortCol_0') == 12)

			$order_by = 'issueamt';

		$totalrecs = '';

		$limit = 15;

		$offset = 1;

		$get = $_GET;

		foreach ($get as $key => $value) {

			$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
		}

		if (!empty($_GET["iDisplayLength"])) {

			$limit = $_GET['iDisplayLength'];

			$offset = $_GET["iDisplayStart"];
		}

		if (!empty(($frmDate && $toDate))) {

			if (DEFAULT_DATEPICKER == 'NP') {

				$this->db->where('sama_billdatebs >=', $frmDate);

				$this->db->where('sama_billdatebs <=', $toDate);
			} else {

				$this->db->where('sama_billdatead >=', $frmDate);

				$this->db->where('sama_billdatead <=', $toDate);
			}
		}

		if (!empty($get['sSearch_1'])) {

			$this->db->where("lower(sama_invoiceno) like  '%" . $get['sSearch_1'] . "%'  ");
		}

		if (!empty($get['sSearch_2'])) {

			if (DEFAULT_DATEPICKER == 'NP') {

				$this->db->where("lower(sama_billdatebs) like  '%" . $get['sSearch_2'] . "%'  ");
			} else {

				$this->db->where("lower(sama_billdatead) like  '%" . $get['sSearch_2'] . "%'  ");
			}
		}

		if (!empty($get['sSearch_3'])) {

			$this->db->where("lower(sama_requisitionno) like  '%" . $get['sSearch_3'] . "%'  ");
		}

		if (!empty($get['sSearch_4'])) {

			$this->db->where("lower(itli_itemcode) like  '%" . $get['sSearch_4'] . "%'  ");
		}

		if (!empty($get['sSearch_5'])) {

			$this->db->where("lower(itli_itemname) like  '%" . $get['sSearch_5'] . "%' OR itli_itemnamenp like  '%" . $get['sSearch_5'] . "%' ");
		}

		if (!empty($get['sSearch_6'])) {

			$this->db->where("lower(sama_depname) like  '%" . $get['sSearch_6'] . "%'  ");
		}

		if (!empty($get['sSearch_7'])) {

			$this->db->where("lower(sama_username) like  '%" . $get['sSearch_7'] . "%'  ");
		}

		if (!empty($get['sSearch_8'])) {

			$this->db->where("lower(sama_receivedby) like  '%" . $get['sSearch_8'] . "%'  ");
		}

		if (!empty($get['sSearch_10'])) {

			$this->db->where("lower(sade_qty) like  '%" . $get['sSearch_10'] . "%'  ");
		}

		if (!empty($get['sSearch_11'])) {

			$this->db->where("lower(sade_unitrate) like  '%" . $get['sSearch_11'] . "%'  ");
		}

		if ($cond) {

			$this->db->where($cond);
		}

		if ($this->location_ismain == 'Y') {

			if ($input_locationid) {

				$this->db->where('sd.sade_locationid', $input_locationid);
			}
		} else {

			$this->db->where('sd.sade_locationid', $this->locationid);
		}

		$this->db->select('rn.sama_st,rn.sama_billtime,rn.sama_requisitionno,sd.sade_qty,sd.sade_unitrate,sd.sade_remarks,rn.sama_salemasterid,rn.sama_invoiceno,rn.sama_billdatebs,rn.sama_billdatead,dp.dept_depname sama_depname,rn.sama_totalamount,rn.sama_username,rn.sama_receivedby,(sd.sade_qty*sd.sade_unitrate) as issueamt,eq.itli_itemname,eq.itli_itemnamenp,eq.itli_itemcode,eq.itli_itemlistid');

		$this->db->from('sade_saledetail sd');

		$this->db->join('sama_salemaster rn', 'rn.sama_salemasterid = sd.sade_salemasterid', 'LEFT');

		$this->db->join('dept_department dp', 'dp.dept_depid=rn.sama_depid', 'left');

		$this->db->join('itli_itemslist eq', 'eq.itli_itemlistid = sd.sade_itemsid', 'LEFT');

		$this->db->order_by($order_by, $order);

		if ($limit && $limit > 0) {

			$this->db->limit($limit);
		}

		if ($offset) {

			$this->db->offset($offset);
		}

		$nquery = $this->db->get();

		// echo $this->db->last_query();

		// die();

		$num_row = $nquery->num_rows();

		if (!empty($_GET['iDisplayLength']) &&  !empty($nquery) && is_array($nquery) && count($nquery) > 0) {

			$totalrecs = sizeof($nquery);
		}

		if ($num_row > 0) {

			$ndata = $nquery->result();

			$ndata['totalrecs'] = $totalrecs;

			$ndata['totalfilteredrecs'] = $totalfilteredrecs;
		} else {

			$ndata = array();

			$ndata['totalrecs'] = 0;

			$ndata['totalfilteredrecs'] = 0;
		}

		//echo $this->db->last_query();die();

		return $ndata;
	}

	public function get_issue_book_list($cond = false)

	{
		// echo "test";
		// die();
		$srchtext = $this->input->get('srchtext');

		$frmDate = $this->input->get('frmDate');

		$toDate = $this->input->get('toDate');

		$mattypeid = $this->input->get('mattypeid');
		$apptype = $this->input->get('apptype');

		$get = $_GET;

		foreach ($get as $key => $value) {

			$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
		}

		if (!empty($get['sSearch_1'])) {

			$this->db->where("lower(sama_billdatebs) like  '%" . $get['sSearch_1'] . "%'  ");
		}

		if (!empty($get['sSearch_2'])) {

			$this->db->where("lower(sama_billdatead) like  '%" . $get['sSearch_2'] . "%'  ");
		}

		if (!empty($get['sSearch_3'])) {

			$this->db->where("lower(sama_invoiceno) like  '%" . $get['sSearch_3'] . "%'  ");
		}

		if (!empty($get['sSearch_4'])) {

			$this->db->where("lower(sama_depname) like  '%" . $get['sSearch_4'] . "%'  ");
		}

		if (!empty($get['sSearch_5'])) {

			$this->db->where("lower(sama_totalamount) like  '%" . $get['sSearch_5'] . "%'  ");
		}

		if (!empty($get['sSearch_6'])) {

			$this->db->where("lower(sama_username) like  '%" . $get['sSearch_6'] . "%'  ");
		}

		if (!empty($get['sSearch_7'])) {

			$this->db->where("lower(sama_receivedby) like  '%" . $get['sSearch_7'] . "%'  ");
		}

		if (!empty($get['sSearch_8'])) {

			$this->db->where("lower(sama_requisitionno) like  '%" . $get['sSearch_8'] . "%'  ");
		}

		if (!empty($get['sSearch_9'])) {

			$this->db->where("lower(sama_billtime) like  '%" . $get['sSearch_9'] . "%'  ");
		}

		if (!empty($get['sSearch_10'])) {

			$this->db->where("lower(sama_billno) like  '%" . $get['sSearch_10'] . "%'  ");
		}

		if (!empty($get['sSearch_11'])) {

			$this->db->where("lower(sama_fyear) like  '%" . $get['sSearch_11'] . "%'  ");
		}

		if ($cond) {

			$this->db->where($cond);
		}

		if (!empty($mattypeid)) {

			$this->db->where("sama_mattypeid", $mattypeid);
		}

		if (!empty($srchtext)) {
			$this->db->where('(sama_invoiceno="' . $srchtext . '" OR sama_requisitionno="' . $srchtext . '")');
		}

		$input_locationid = !empty($get['locationid']) ? $get['locationid'] : $this->input->post('locationid');

		if (!empty(($frmDate && $toDate))) {

			if (DEFAULT_DATEPICKER == 'NP') {

				$this->db->where('sama_billdatebs >=', $frmDate);

				$this->db->where('sama_billdatebs <=', $toDate);
			} else {

				$this->db->where('sama_billdatead >=', $frmDate);

				$this->db->where('sama_billdatead <=', $toDate);
			}
		}

		// if($input_locationid)

		// {

		//     $this->db->where('rn.sama_locationid',$input_locationid);

		// }

		if ($this->location_ismain == 'Y') {

			if (!empty($input_locationid)) {

				$this->db->where('rn.sama_locationid', $input_locationid);
			} else {

				$this->db->where('rn.sama_locationid', $this->locationid);
			}
		} else {

			$this->db->where('rn.sama_locationid', $this->locationid);
		}

		$resltrpt = $this->db->select("COUNT(*) as cnt")

			->from('sama_salemaster rn')

			->get()->row();

		// echo $this->db->last_query();die(); 

		$totalfilteredrecs = ($resltrpt->cnt);

		$order_by = 'sama_salemasterid';

		$order = 'desc';

		if ($this->input->get('sSortDir_0')) {

			$order = $this->input->get('sSortDir_0');
		}

		$where = '';

		if ($this->input->get('iSortCol_0') == 1)

			$order_by = 'sama_billdatebs';

		else  if ($this->input->get('iSortCol_0') == 2)

			$order_by = 'sama_billdatead';

		else  if ($this->input->get('iSortCol_0') == 3)

			$order_by = 'sama_invoiceno';

		else if ($this->input->get('iSortCol_0') == 4)

			$order_by = 'sama_depname';

		else if ($this->input->get('iSortCol_0') == 5)

			$order_by = 'totalamt';

		else if ($this->input->get('iSortCol_0') == 6)

			$order_by = 'sama_username';

		else if ($this->input->get('iSortCol_0') == 7)

			$order_by = 'sama_receivedby';

		else if ($this->input->get('iSortCol_0') == 8)

			$order_by = 'sama_requisitionno';

		else if ($this->input->get('iSortCol_0') == 9)

			$order_by = 'sama_billtime';

		else if ($this->input->get('iSortCol_0') == 10)

			$order_by = 'sama_billno';

		else if ($this->input->get('iSortCol_0') == 11)

			$order_by = 'sama_fyear';
		else if ($this->input->get('iSortCol_0') == 11)
             if(DEFAULT_DATEPICKER == 'NP'){
				$order_by = 'sama_postdatebs';
			}else{
				$order_by = 'sama_postdatead';
			}
			
  
		$totalrecs = '';

		$limit = 15;

		$offset = 1;

		$get = $_GET;

		foreach ($get as $key => $value) {

			$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
		}

		// echo $this->db->last_query();

		//  die;

		if (!empty($_GET["iDisplayLength"])) {

			$limit = $_GET['iDisplayLength'];

			$offset = $_GET["iDisplayStart"];
		}

		if (!empty($get['sSearch_1'])) {

			$this->db->where("lower(sama_billdatebs) like  '%" . $get['sSearch_1'] . "%'  ");
		}

		if (!empty($get['sSearch_2'])) {

			$this->db->where("lower(sama_billdatead) like  '%" . $get['sSearch_2'] . "%'  ");
		}

		if (!empty($get['sSearch_3'])) {

			$this->db->where("lower(sama_invoiceno) like  '%" . $get['sSearch_3'] . "%'  ");
		}

		if (!empty($get['sSearch_4'])) {

			$this->db->where("lower(sama_depname) like  '%" . $get['sSearch_4'] . "%'  ");
		}

		if (!empty($get['sSearch_5'])) {

			$this->db->where("lower(sama_totalamount) like  '%" . $get['sSearch_5'] . "%'  ");
		}

		if (!empty($get['sSearch_6'])) {

			$this->db->where("lower(sama_username) like  '%" . $get['sSearch_6'] . "%'  ");
		}

		if (!empty($get['sSearch_7'])) {

			$this->db->where("lower(sama_receivedby) like  '%" . $get['sSearch_7'] . "%'  ");
		}

		if (!empty($get['sSearch_8'])) {

			$this->db->where("lower(sama_requisitionno) like  '%" . $get['sSearch_8'] . "%'  ");
		}

		if (!empty($get['sSearch_9'])) {

			$this->db->where("lower(sama_billtime like)  '%" . $get['sSearch_9'] . "%'  ");
		}

		if (!empty($get['sSearch_10'])) {

			$this->db->where("lower(sama_billno) like  '%" . $get['sSearch_10'] . "%'  ");
		}

		if (!empty($get['sSearch_11'])) {

			$this->db->where("lower(sama_fyear) like  '%" . $get['sSearch_11'] . "%'  ");
		}

		if (!empty(($frmDate && $toDate))) {

			if (DEFAULT_DATEPICKER == 'NP') {

				$this->db->where('sama_billdatebs >=', $frmDate);

				$this->db->where('sama_billdatebs <=', $toDate);
			} else {

				$this->db->where('sama_billdatead >=', $frmDate);

				$this->db->where('sama_billdatead <=', $toDate);
			}
		} else {
		}

		if ($cond) {

			$this->db->where($cond);
		}

		if (!empty($mattypeid)) {

			$this->db->where("sama_mattypeid", $mattypeid);
		}

		if (!empty($srchtext)) {
			$this->db->where('(sama_invoiceno="' . $srchtext . '" OR sama_requisitionno="' . $srchtext . '")');
		}
		if ($this->location_ismain == 'Y') {

			if (!empty($input_locationid)) {

				$this->db->where('sm.sama_locationid', $input_locationid);
			} else {

				$this->db->where('sm.sama_locationid', $this->locationid);
			}
		} else {

			$this->db->where('sm.sama_locationid', $this->locationid);
		}

		$custom_select = '';

		if (ORGANIZATION_NAME == 'KU') {

			$custom_select = ' ,mt.maty_material';
		}

		$this->db->select("sama_salemasterid,totcnt,
totalamt,sama_depid,sama_billdatead, sama_billdatebs, sama_duedatead, sama_duedatebs, sama_soldby, sama_discount, sama_taxrate, sama_vat, sama_totalamount, sama_username, sama_lastchangedate, sama_orderno, sama_challanno, sama_billno, sama_payment, sama_status, sama_fyear, sama_st, sama_stdatebs, sama_stdatead, sama_stdepid, sama_stusername, sama_stshiftid, dept_depname, sama_depname, sama_invoiceno, sama_billtime, sama_receivedby, sama_manualbillno, sama_requisitionno,sama_postdatebs,sama_postdatead,sama_locationid,sama_posttime $custom_select");

		$this->db->from('sama_salemaster sm');

		if (ORGANIZATION_NAME == 'KU') {

			$this->db->join('maty_materialtype mt', 'mt.maty_materialtypeid=sm.sama_mattypeid');
		}
	
		$this->db->join('vw_issue_summary sd', 'sd.sade_salemasterid =sm.sama_salemasterid', 'LEFT');

		$this->db->join('dept_department dp', 'dp.dept_depid=sm.sama_depid', 'left');

		$this->db->group_by('sama_salemasterid');

		$this->db->order_by($order_by, $order);

		if ($limit && $limit > 0) {

			$this->db->limit($limit);
		}

		if ($offset) {

			$this->db->offset($offset);
		}

		$nquery = $this->db->get();

		$num_row = $nquery->num_rows();

		if (!empty($_GET['iDisplayLength']) &&  !empty($nquery) && is_array($nquery) && count($nquery) > 0) {

			$totalrecs = sizeof($nquery);
		}

		if ($num_row > 0) {

			$ndata = $nquery->result();

			$ndata['totalrecs'] = $totalrecs;

			$ndata['totalfilteredrecs'] = $totalfilteredrecs;
		} else {

			$ndata = array();

			$ndata['totalrecs'] = 0;

			$ndata['totalfilteredrecs'] = 0;
		}

		// echo $this->db->last_query();die();

		return $ndata;
	}

	public function get_mat_trans_detail_id($itemsid, $vol = 0, $unit = 0, $issueqty = false)

	{

		$this->db->select('mtd.trde_trdeid, mtd.trde_unitprice, mtd.trde_selprice, mtd.trde_controlno, mtd.trde_expdatebs, mtd.trde_issueqty');

		$this->db->from('trde_transactiondetail mtd');

		$this->db->join('trma_transactionmain mtm', 'mtm.trma_trmaid = mtd.trde_trmaid', 'LEFT');

		// $this->db->where(array('trde_unitvolume'=>$vol,'trde_microunitid'=>$unit));

		$this->db->where(array('trde_issueqty>' => '0', 'trma_received' => '1', 'trde_status' => 'O'));

		$this->db->where(array('trde_itemsid' => $itemsid));

		$this->db->order_by('trde_trdeid', 'ASC');

		$this->db->limit(1);

		$qrydata = $this->db->get();

		$data = $qrydata->row();

		if ($data) {

			$db_issueqty = $data->trde_issueqty;

			$rem_issue = $issueqty - $db_issueqty;

			// foreach($data as $d):

			// echo "<pre>";

			// print_r('rem_issue '.$rem_issue);

			// echo "<br/>";

			// print_r('db_issue '.$db_issueqty);

			// echo "<br/>";

			// print_r('issue '.$issueqty);

			// echo "<br/>";

			// print_r('matd '.$data->trde_trdeid);

			// echo "<br/>";

			// echo $this->db->last_query();

			// endforeach;

			// die();

			if ($rem_issue > 0) {

				// $data->trde_trdeid;    

				$this->update_trde_issue_qty($rem_issue, $data->trde_trdeid);

				$this->get_mat_trans_detail_id($itemsid, $vol, $unit, $rem_issue);

				// return   

			} else {

				if ($rem_issue < 0) {

					$rem_issue = - ($rem_issue);

					$this->update_trde_issue_qty($rem_issue, $data->trde_trdeid);
				}

				return $data->trde_trdeid;
			}

			// return array(

			//     'mattransdetailid' => $data->trde_trdeid,

			//     'trde_issue_qty' => $data->trde_issueqty

			// );

		}
	}

	public function update_trde_issue_qty($rem_qty, $trde_id)
	{

		$update_array = array(

			'trde_issueqty' => $rem_qty,

			'trde_stripqty' => $rem_qty,

		);

		$this->general->save_log($this->tran_detailsTable, 'trde_trdeid', $trde_id, $update_array, 'Update');

		$this->db->update($this->tran_detailsTable, $update_array, array('trde_trdeid' => $trde_id));

		// $this->db->query('UPDATE xw_trde_transactiondetail SET  trde_issueqty =(trde_issueqty-'.$rem_qty.') WHERE  trde_trdeid='.$trde_id.' ');

	}

	public function update_trde_return_to_issue_qty($rem_qty, $trde_id)
	{

		$this->db->query('UPDATE xw_trde_transactiondetail SET  trde_issueqty =(trde_issueqty+' . $rem_qty . ') WHERE  trde_trdeid=' . $trde_id . ' ');
	}

	public function get_issue_master($srchcol = false)

	{

		$locationid = $this->input->post('locationid');

		$this->db->select('sm.*');

		$this->db->from('sama_salemaster sm');

		if ($srchcol) {

			$this->db->where($srchcol);
		}

		if (!empty($locationid)) {

			$this->db->where('sama_locationid', $locationid);
		} else {

			$this->db->where('sama_locationid', $this->locationid);
		}

		$query = $this->db->get();

		// echo $this->db->last_query();

		// die();

		if ($query->num_rows() > 0) {

			$data = $query->result();

			return $data;
		}

		return false;
	}

	public function get_issue_detail_edit($srchcol = false)

	{

		$this->db->select('sd.*, il.itli_itemcode,il.itli_materialtypeid,il.itli_itemname,il.itli_itemnamenp,il.itli_itemlistid,ut.unit_unitname,rd.rede_qty,rd.rede_remqty,(SELECT IFNULL(SUM(md.trde_issueqty),0) FROM xw_trde_transactiondetail md LEFT JOIN xw_trma_transactionmain mt   on md.trde_trmaid =mt.trma_trmaid

WHERE il.itli_itemlistid=md.trde_itemsid AND mt.trma_received=1 AND md.trde_locationid=' . $this->locationid . ' AND mt.trma_fromdepartmentid=' . $this->storeid . ' ) as stockqty');

		$this->db->from('sade_saledetail sd');

		$this->db->join('rede_reqdetail rd', 'rd.rede_reqdetailid=sd.sade_reqdetailid', 'LEFT');

		$this->db->join('itli_itemslist il', 'il.itli_itemlistid=sd.sade_itemsid', 'INNER');

		$this->db->join('unit_unit ut', 'ut.unit_unitid=il.itli_unitid', 'LEFT');

		// $this->db->group_by('il.itli_itemlistid');

		if ($srchcol) {

			$this->db->where($srchcol);
		}

		$query = $this->db->get();

		// echo $this->db->last_query(); die();

		if ($query->num_rows() > 0) {

			$data = $query->result();

			return $data;
		}

		return false;
	}

	public function get_issue_detail($srchcol = false)

	{

		$this->db->select('sd.*, sum(sd.sade_curqty) as totalcurqty, sum(sd.sade_qty) as totalqty,SUM(rd.rede_qty) as totaldemandqty, il.itli_itemcode,il.itli_materialtypeid,il.itli_itemname,il.itli_itemnamenp,il.itli_itemlistid,ut.unit_unitname,ec.eqca_code,ec.eqca_category,rd.rede_qty,rd.rede_remqty,sum(sd.sade_unitrate * sd.sade_qty) as subtotal,(SELECT IFNULL(SUM(md.trde_issueqty),0) FROM xw_trde_transactiondetail md LEFT JOIN xw_trma_transactionmain mt   on md.trde_trmaid =mt.trma_trmaid WHERE il.itli_itemlistid=md.trde_itemsid AND mt.trma_received=1 AND md.trde_locationid=' . $this->locationid . ' AND mt.trma_fromdepartmentid=' . $this->storeid . ' ) as stockqty');

		$this->db->from('sade_saledetail sd');

		$this->db->join('rede_reqdetail rd', 'rd.rede_reqdetailid=sd.sade_reqdetailid', 'LEFT');

		$this->db->join('itli_itemslist il', 'il.itli_itemlistid=sd.sade_itemsid', 'INNER');

		$this->db->join('unit_unit ut', 'ut.unit_unitid=il.itli_unitid', 'LEFT');

		$this->db->join('eqca_equipmentcategory ec', 'ec.eqca_equipmentcategoryid=il.itli_catid', 'LEFT');

		$this->db->group_by('il.itli_itemlistid');

		if ($srchcol) {

			$this->db->where($srchcol);
		}

		$query = $this->db->get();

		// echo $this->db->last_query(); die();

		if ($query->num_rows() > 0) {

			$data = $query->result();

			return $data;
		}

		return false;
	}

	public function update_mat_trans_detailid($mat_transdetailid, $qty = 0, $type = false)

	{

		if ($mat_transdetailid) {

			if ($type == 'returncancel' || $type == 'new_issue') {

				$this->db->query("UPDATE xw_trde_transactiondetail SET trde_issueqty= (trde_issueqty)-$qty, trde_stripqty = (trde_issueqty)-$qty WHERE trde_trdeid=$mat_transdetailid  ");

				// 				$this->db->update('',array('trde_issueqty'=>'trde_issueqty'-$qty),array('trde

				// trde_trdeid'=>$mat_transdetailid));

			} else {

				// $this->db->update('trde_transactiondetail',array('trde_issueqty'=>'trde_issueqty'+$qty),array('trde_trdeid'=>$mat_transdetailid));

				$this->db->query("UPDATE xw_trde_transactiondetail SET trde_issueqty= (trde_issueqty)+$qty, trde_stripqty = (trde_issueqty)+$qty WHERE trde_trdeid=$mat_transdetailid  ");
			}

			$rwaff = $this->db->affected_rows();

			if ($rwaff) {
				return true;
			}
		}

		return false;
	}

	public function update_salesdetail($id)

	{

		if ($id) {

			$updateArray['sade_iscancel'] = 'Y';

			$updateArray['sade_canceldatead'] = CURDATE_EN;

			$updateArray['sade_canceldatebs'] = CURDATE_NP;

			$updateArray['sade_canceldateby'] = $this->userid;

			$updateArray['sade_canceluser'] = $this->username;

			$this->db->update('sade_saledetail', $updateArray, array('sade_saledetailid' => $id));

			$rwaff = $this->db->affected_rows();

			if ($rwaff) {
				return true;
			}
		}

		return false;
	}

	public function update_reqdetail($reqdetailid)
	{

		if ($reqdetailid) {

			$updateArray = array(

				'rede_modifyby' => $this->userid,

				'rede_modifydatead' => CURDATE_EN,

				'rede_modifydatebs' => CURDATE_NP,

				'rede_modifytime' => $this->curtime,

				'rede_modifymac' => $this->mac,

				'rede_modifyip' => $this->ip

			);

			$this->db->set('rede_remqty', 'rede_qty', false);

			$this->db->where('rede_reqdetailid', $reqdetailid);

			$this->db->update('rede_reqdetail', $updateArray);

			// echo $this->db->last_query();

			// die();

			$rwaff = $this->db->affected_rows();

			if ($rwaff) {

				return true;
			}
		}

		return false;
	}

	// public function update_reqmaster($reqno,$fyear,$storeid,$depid,$locationid){

	// 	if(empty($reqno) || empty($fyear) || empty($storeid) || empty($depid) || empty($locationid)){

	// 		echo "There was some errors. Please try again.";

	// 		return false;

	// 	}else{

	// 		$updateArray = array(

	// 					'rema_received'=>0

	// 					);

	// 		$this->db->where('rema_reqno',$reqno);

	// 		$this->db->where('rema_fyear',$fyear);

	// 		$this->db->where('rema_storeid',$storeid);

	// 		$this->db->where('rema_locationid',$locationid);

	// 		$this->db->where('rema_reqfromdepid',$depid);

	// 		$this->db->update('rema_reqmaster',$updateArray);

	// 	}

	// 	$rwaff=$this->db->affected_rows(); 

	// 	if($rwaff){ 

	// 		return true;

	// 	}

	// }

	public function update_salesmaster($id)

	{

		if ($id) {

			$updateArray['sama_st'] = 'C';

			$updateArray['sama_stdepid'] = $this->session->userdata(STORE_ID);

			$updateArray['sama_stshiftid'] = $this->session->userdata(STORE_ID);

			$updateArray['sama_stusername'] = $this->username;

			$updateArray['sama_stdatebs'] = CURDATE_NP;

			$updateArray['sama_stdatead'] = CURDATE_EN;

			$this->db->update('sama_salemaster', $updateArray, array('sama_salemasterid' => $id));

			$rwaff = $this->db->affected_rows();

			if ($rwaff) {
				return true;
			}
		}

		return false;
	}

	public function save_issue_return()
	{

		try {

			$id = $this->input->post('id');

			$depid = $this->input->post('rema_depid');

			$issueno = $this->input->post('rema_issueno');

			$fyear = $this->input->post('rema_fyear');

			$returndate = $this->input->post('rema_returndate');

			$salesmasterid = $this->input->post('salesmasterid');

			if (DEFAULT_DATEPICKER == 'NP') {

				$returndatebs = $returndate;

				$returndatead = $this->general->NepToEngDateConv($returndate);
			} else {

				$returndatead = $returndate;

				$returndatebs = $this->general->EngtoNepDateConv($returndate);
			}

			$returnby = $this->input->post('rema_returnby');

			$issueto = $this->input->post('rema_issueto');

			$amount = $this->input->post('rema_amount');

			$remark_master = $this->input->post('rema_remarks');

			$return_invoice = $this->input->post('rema_invoiceno');

			//for return detail

			$itemsid = $this->input->post('itemsid');

			$mattransdetailid = $this->input->post('mattransdetailid');

			$qty = $this->input->post('qty');

			$unit_rate = $this->input->post('unit_rate');

			$issueqty = $this->input->post('issueqty');

			$returnqty = $this->input->post('returnqty');

			$ret_remarks = $this->input->post('remarks');

			$retamt_total = $this->input->post('retamt_total');

			$reqdetailid = $this->input->post('reqdetailid');

			$this->db->trans_begin();

			if ($id) {

				//update

			} else {

				//insert

				$returnMasterArray = array(

					'rema_fyear' => $fyear,

					'rema_receiveno' => $issueno,

					'rema_depid' => $depid,

					'rema_amount' => $amount,

					'rema_returndatead' => $returndatead,

					'rema_returndatebs' => $returndatebs,

					'rema_returntime' => $this->curtime,

					'rema_storeid' => $this->storeid,

					'rema_type' => '1', //1

					'rema_auther' => 'check', //check

					'rema_username' => $this->username,

					'rema_invoiceno' => $return_invoice,

					'rema_st' => 'N', //N,C

					'rema_remarks' => $remark_master, //32

					'rema_returnby' => $returnby,

					'rema_postby' => $this->userid,

					'rema_postdatead' => CURDATE_EN,

					'rema_postdatebs' => CURDATE_NP,

					'rema_posttime' => $this->curtime,

					'rema_postmac' => $this->mac,

					'rema_postip' => $this->ip,

					'rema_locationid' => $this->locationid,

					'rema_orgid' => $this->orgid

				);

				if (!empty($returnMasterArray)) {

					$this->db->insert('rema_returnmaster', $returnMasterArray);

					$insertid = $this->db->insert_id();

					// $insertid = 5;

					if ($insertid) {

						if (!empty($itemsid)) {

							$rema_amount_total = 0;

							foreach ($itemsid as $key => $val) {

								$itmid = !empty($itemsid[$key]) ? $itemsid[$key] : '';

								$retn_qty = !empty($returnqty[$key]) ? $returnqty[$key] : '';

								$ret_remarks = !empty($ret_remarks[$key]) ? $ret_remarks[$key] : '';

								if ($retn_qty > 0) {

									$this->update_return_issue_item($itmid, $salesmasterid, $retn_qty, $insertid, $ret_remarks);
								}
							}
						} // if itemsid

						// echo "<pre>";

						// print_r($returnDetailArray);

						// die();

						if (!empty($returnDetailArray)) {

							$detail_insert = $this->db->insert_batch('rede_returndetail', $returnDetailArray);

							// $detail_insert = 1;

							//update return master for total

							$updateRemaArray = array(

								'rema_amount' => $rema_amount_total

							);

							if ($updateRemaArray) {

								$this->db->where('rema_returnmasterid', $insertid);

								$this->db->update('rema_returnmaster', $updateRemaArray);
							}
						}
					} // if insertid

				} // if returnmasterarray

			} // else no id

			$this->db->trans_complete();

			if ($this->db->trans_status() === FALSE) {

				$this->db->trans_rollback();

				trigger_error("Commit failed");

				// return false;

			} else {

				$this->db->trans_commit();

				return true;
			}
		} catch (Exception $e) {

			throw $e;
		}
	}

	public function update_return_issue_item($item, $salesmasterid, $rtnqty, $retmasterid, $ret_remarks)

	{

		$this->db->select('sade_saledetailid,sade_salemasterid,sade_itemsid,sade_qty,sade_curqty,sade_unitrate,sm.sama_depid,sm.sama_invoiceno,sm.sama_fyear,sd.sade_reqdetailid,sd.sade_mattransdetailid');

		$this->db->from('sade_saledetail sd');

		$this->db->join('sama_salemaster sm', 'sm.sama_salemasterid=sd.sade_salemasterid');

		$this->db->order_by('sade_saledetailid', 'ASC');

		$this->db->where(array('sade_itemsid' => $item, 'sade_salemasterid' => $salesmasterid));

		$this->db->limit(1);

		$qrydata = $this->db->get();

		// echo $this->db->last_query();

		// die();

		$data = $qrydata->row();

		if ($data) {

			$db_orginalqty = $data->sade_qty;

			$db_issueqty = $data->sade_curqty;

			$db_unitprice = $data->sade_unitrate;

			$mattransdetailid = $data->sade_mattransdetailid;

			$depid = $data->sama_depid;

			$issueno = $data->sama_invoiceno;

			$fyear = $data->sama_fyear;

			$reqdetailid = $data->sade_reqdetailid;

			$salesdtlid = $data->sade_saledetailid;

			$rem_ret_qty = $rtnqty - $db_issueqty;

			if ($rem_ret_qty > 0) {

				$ret_qty = $db_issueqty;
			} else {

				if ($rem_ret_qty <= 0) {

					$rm_issue = - ($rem_ret_qty);

					$ret_qty = $db_issueqty - $rm_issue;
				}
			}

			$UpdatesalesDetailArray = array(

				'sade_curqty' => - ($rem_ret_qty)

			);

			if (!empty($UpdatesalesDetailArray)) {

				$this->db->update('sade_saledetail', $UpdatesalesDetailArray, array('sade_saledetailid' => $salesdtlid));
			}

			$UpdatereqDetailArray = array(

				'rede_remqty' => ($db_orginalqty - $db_issueqty + $ret_qty),

				'rede_modifydatead' => CURDATE_EN,

				'rede_modifydatebs' => CURDATE_NP,

				'rede_modifytime' => $this->curtime,

				'rede_modifyby' => $this->userid,

				'rede_modifymac' => $this->mac,

				'rede_modifyip' => $this->ip,

				'rede_locationid' => $this->locationid

			);

			if (!empty($UpdatereqDetailArray)) {

				$this->db->update($this->rede_detailTable, $UpdatereqDetailArray, array('rede_reqdetailid' => $reqdetailid));
			}

			// $this->db->query('UPDATE  '.$this->rede_detailTable.'  SET  rede_remqty =(rede_remqty+'.$rem_qty.') WHERE  rede_reqdetailid='.$reqdetailid.' ');

			$returnDetailArray = array(

				'rede_returnmasterid' => $retmasterid,

				'rede_itemsid' => !empty($item) ? $item : '',

				'rede_unitprice' => !empty($db_unitprice) ? $db_unitprice : '0',

				'rede_qty' => !empty($ret_qty) ? $ret_qty : 0,

				'rede_total' => ($db_unitprice) * ($ret_qty),

				'rede_mattransdetailid' => !empty($mattransdetailid) ? $mattransdetailid : '',

				'rede_newmtdid' => '',

				'rede_controlno' => 1,

				'rede_discount' => '',

				'rede_storeid' => $this->storeid,

				'rede_invoiceno' => $issueno,

				'rede_depid' => $depid,

				'rede_salefyear' => $fyear,

				'rede_remarks' => !empty($ret_remarks) ? $ret_remarks : '',

				'rede_reqdetailid' => !empty($reqdetailid) ? $reqdetailid : '',

				'rede_salesdetailid' => !empty($salesdtlid) ? $salesdtlid : '',

				'rede_postby' => $this->userid,

				'rede_postdatead' => CURDATE_EN,

				'rede_postdatebs' => CURDATE_NP,

				'rede_posttime' => $this->curtime,

				'rede_postmac' => $this->mac,

				'rede_postip' => $this->ip,

				'rede_locationid' => $this->locationid

			);

			if (!empty($returnDetailArray)) {

				$this->db->insert('rede_returndetail', $returnDetailArray);
			}

			if ($rem_ret_qty > 0) {

				// $data->trde_trdeid;    

				$issueqty = $db_issueqty;

				$this->update_return_issue_item($item, $salesmasterid, $rem_ret_qty, $retmasterid, $ret_remarks);

				$this->update_trde_return_to_issue_qty($issueqty, $mattransdetailid);
			} else {

				if ($rem_ret_qty <= 0) {

					$rm_issue = - ($rem_ret_qty);

					$issueqty = $db_issueqty - $rm_issue;

					$this->update_trde_return_to_issue_qty($issueqty, $mattransdetailid);
				}
			}
		}
	}

	public function get_issue_return_list($cond = false)

	{

		$frmDate = $this->input->get('frmDate');

		$toDate = $this->input->get('toDate');

		$locationid = $this->input->get('locationid') ? $this->input->get('locationid') : '';

		$get = $_GET;

		foreach ($get as $key => $value) {

			$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
		}

		if (!empty($get['sSearch_1'])) {

			$this->db->where("lower(rema_invoiceno) like  '%" . $get['sSearch_1'] . "%'  ");
		}

		if (!empty($get['sSearch_2'])) {

			$this->db->where("lower(rema_returndatebs) like  '%" . $get['sSearch_2'] . "%'  ");
		}

		if (!empty($get['sSearch_3'])) {

			$this->db->where("lower(sama_depname) like  '%" . $get['sSearch_3'] . "%'  ");
		}

		if (!empty($get['sSearch_4'])) {

			$this->db->where("lower(sama_totalamount) like  '%" . $get['sSearch_4'] . "%'  ");
		}

		if (!empty($get['sSearch_5'])) {

			$this->db->where("lower(sama_username) like  '%" . $get['sSearch_5'] . "%'  ");
		}

		if (!empty($get['sSearch_6'])) {

			$this->db->where("lower(sama_receivedby) like  '%" . $get['sSearch_6'] . "%'  ");
		}

		if (!empty($get['sSearch_7'])) {

			$this->db->where("lower(sama_requisitionno) like  '%" . $get['sSearch_7'] . "%'  ");
		}

		if (!empty($get['sSearch_8'])) {

			$this->db->where("lower(sama_billtime) like  '%" . $get['sSearch_8'] . "%'  ");
		}

		if (!empty($get['sSearch_9'])) {

			$this->db->where("lower(sama_billno) like  '%" . $get['sSearch_9'] . "%'  ");
		}

		if ($cond) {

			$this->db->where($cond);
		}

		if (!empty(($frmDate && $toDate))) {

			if (DEFAULT_DATEPICKER == 'NP') {

				$this->db->where('rema_returndatebs >=', $frmDate);

				$this->db->where('rema_returndatebs <=', $toDate);
			} else {

				$this->db->where('rema_returndatead >=', $frmDate);

				$this->db->where('rema_returndatead <=', $toDate);
			}
		}

		if ($this->location_ismain == 'Y') {

			if (!empty($locationid)) {

				$this->db->where('rema_locationid', $locationid);
			} else {

				$this->db->where('rema_locationid', $this->locationid);
			}
		} else {

			$this->db->where('rema_locationid', $this->locationid);
		}

		$resltrpt = $this->db->select("COUNT(*) as cnt")

			->from('rema_returnmaster rm')

			->join('dept_department d', 'rm.rema_depid = d.dept_depid', 'left')

			->get()->row();

		// echo $this->db->last_query();die(); 

		$totalfilteredrecs = ($resltrpt->cnt);

		$order_by = 'rema_returndatebs';

		$order = 'desc';

		if ($this->input->get('sSortDir_0')) {

			$order = $this->input->get('sSortDir_0');
		}

		$where = '';

		if ($this->input->get('iSortCol_0') == 1)

			$order_by = 'rema_invoiceno';

		else if ($this->input->get('iSortCol_0') == 2)

			$order_by = 'rema_returndatebs';

		else if ($this->input->get('iSortCol_0') == 3)

			$order_by = 'sama_depname';

		else if ($this->input->get('iSortCol_0') == 4)

			$order_by = 'sama_totalamount';

		else if ($this->input->get('iSortCol_0') == 5)

			$order_by = 'sama_username';

		else if ($this->input->get('iSortCol_0') == 6)

			$order_by = 'sama_receivedby';

		else if ($this->input->get('iSortCol_0') == 7)

			$order_by = 'rema_returndatebs';

		else if ($this->input->get('iSortCol_0') == 8)

			$order_by = 'sama_billtime';

		else if ($this->input->get('iSortCol_0') == 9)

			$order_by = 'sama_billno';

		$totalrecs = '';

		$limit = 15;

		$offset = 1;

		$get = $_GET;

		foreach ($get as $key => $value) {

			$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
		}

		if (!empty($_GET["iDisplayLength"])) {

			$limit = $_GET['iDisplayLength'];

			$offset = $_GET["iDisplayStart"];
		}

		if (!empty($get['sSearch_1'])) {

			$this->db->where("lower(sama_invoiceno) like  '%" . $get['sSearch_1'] . "%'  ");
		}

		if (!empty($get['sSearch_2'])) {

			$this->db->where("lower(rema_returndatebs) like  '%" . $get['sSearch_2'] . "%'  ");
		}

		if (!empty($get['sSearch_3'])) {

			$this->db->where("lower(sama_depname) like  '%" . $get['sSearch_3'] . "%'  ");
		}

		if (!empty($get['sSearch_4'])) {

			$this->db->where("lower(sama_totalamount) like  '%" . $get['sSearch_4'] . "%'  ");
		}

		if (!empty($get['sSearch_5'])) {

			$this->db->where("lower(sama_username) like  '%" . $get['sSearch_5'] . "%'  ");
		}

		if (!empty($get['sSearch_6'])) {

			$this->db->where("lower(sama_receivedby) like  '%" . $get['sSearch_6'] . "%'  ");
		}

		if (!empty($get['sSearch_7'])) {

			$this->db->where("lower(sama_requisitionno) like  '%" . $get['sSearch_7'] . "%'  ");
		}

		if (!empty($get['sSearch_8'])) {

			$this->db->where("lower(sama_billtime) like  '%" . $get['sSearch_8'] . "%'  ");
		}

		if (!empty($get['sSearch_9'])) {

			$this->db->where("lower(sama_billno) like  '%" . $get['sSearch_9'] . "%'  ");
		}

		if (!empty(($frmDate && $toDate))) {

			if (DEFAULT_DATEPICKER == 'NP') {

				$this->db->where('rema_returndatebs >=', $frmDate);

				$this->db->where('rema_returndatebs <=', $toDate);
			} else {

				$this->db->where('rema_returndatead >=', $frmDate);

				$this->db->where('rema_returndatead <=', $toDate);
			}
		}

		if ($this->location_ismain == 'Y') {

			if (!empty($locationid)) {

				$this->db->where('rema_locationid', $locationid);
			} else {

				$this->db->where('rema_locationid', $this->locationid);
			}
		} else {

			$this->db->where('rema_locationid', $this->locationid);
		}

		if ($cond) {

			$this->db->where($cond);
		}

		$this->db->select('rm.*,d.dept_depname');

		$this->db->from('rema_returnmaster rm');

		$this->db->join('dept_department d', 'rm.rema_depid = d.dept_depid', 'left');

		$this->db->order_by($order_by, $order);

		if ($limit && $limit > 0) {

			$this->db->limit($limit);
		}

		if ($offset) {

			$this->db->offset($offset);
		}

		$nquery = $this->db->get();

		$num_row = $nquery->num_rows();

		if (!empty($_GET['iDisplayLength']) &&  !empty($nquery) && is_array($nquery) && count($nquery) > 0) {

			$totalrecs = sizeof($nquery);
		}

		if ($num_row > 0) {

			$ndata = $nquery->result();

			$ndata['totalrecs'] = $totalrecs;

			$ndata['totalfilteredrecs'] = $totalfilteredrecs;
		} else {

			$ndata = array();

			$ndata['totalrecs'] = 0;

			$ndata['totalfilteredrecs'] = 0;
		}

		// echo $this->db->last_query();die();

		return $ndata;
	}

	public function getStatusCount($srchcol = false, $type = false)
	{

		try {

			$locationid = $this->input->post('locid');

			if ($type == 'cancel') {

				$this->db->select("SUM(CASE WHEN sama_st='N' THEN 1 ELSE 0 END ) issue, SUM(CASE WHEN sama_st='C' THEN 1 ELSE 0 END ) cancel");

				$this->db->from('sama_salemaster');

				if (!empty($locationid)) {

					$this->db->where('sama_locationid', $locationid);
				} else {

					$this->db->where('sama_locationid', $this->locationid);
				}
			} else if ($type == 'return') {

				$this->db->select("SUM(CASE WHEN rema_st='N' THEN 1 ELSE 0 END ) issuereturn, SUM(CASE WHEN rema_st='C' THEN 1 ELSE 0 END ) returncancel");

				$this->db->from('rema_returnmaster');

				if (!empty($locationid)) {

					$this->db->where('rema_locationid', $locationid);
				} else {

					$this->db->where('rema_locationid', $this->locationid);
				}
			}

			if ($srchcol) {

				$this->db->where($srchcol);
			}

			$query = $this->db->get();

			// echo $this->db->last_query();

			// die();

			if ($query->num_rows() > 0) {

				return $query->result();
			}

			return false;
		} catch (Exception $e) {

			throw $e;
		}
	}

	public function get_issue_status()

	{

		$issue_cancel = '';

		$isreturn_cancel = '';

		$locationid = $this->input->post('locid');

		$frmdate = $this->input->post('frmdate');

		$todate = $this->input->post('todate');

		$mattypeid = $this->input->post('mattypeid');

		if ($locationid) {

			$issue_cancel .= " AND  sama_locationid = $locationid  ";

			$isreturn_cancel .= " AND  rema_locationid = $locationid  ";
		}

		if (!empty($mattypeid)) {

			$issue_cancel .= "AND sama_mattypeid =$mattypeid";
		}

		if (!empty($frmdate) && !empty($todate)) {

			if (DEFAULT_DATEPICKER == 'NP') {

				$issue_cancel .= " AND sama_billdatebs >='" . $frmdate . "' AND sama_billdatebs <='" . $todate . "' ";

				$isreturn_cancel .= " AND rema_returndatebs >='" . $frmdate . "' AND rema_returndatebs <='" . $todate . "' ";
			} else {

				$issue_cancel .= " AND  sama_billdatead >='" . $frmdate . "' AND sama_billdatead <='" . $todate . "'";

				$isreturn_cancel .= " AND rema_returndatead >='" . $frmdate . "' AND rema_returndatead <='" . $todate . "'";
			}
		}

		$sql = "SELECT SUM(issue) issue, SUM(cancel)cancel, SUM(issue_ret) issue_ret, SUM(ret_cancel) ret_cancel

FROM(

SELECT SUM( CASE WHEN sama_st = 'N' THEN 1 ELSE 0 END) issue, SUM( CASE WHEN sama_st = 'C' THEN 1 ELSE 0 END ) cancel, 0 as issue_ret, 0 as ret_cancel FROM xw_sama_salemaster WHERE  sama_salemasterid IS NOT NULL $issue_cancel UNION SELECT 0 as issue, 0 as cancel, SUM(CASE WHEN rema_st='N' THEN 1 ELSE 0 END ) issuereturn, SUM(CASE WHEN rema_st='C' THEN 1 ELSE 0 END ) returncancel FROM xw_rema_returnmaster WHERE rema_returnmasterid IS NOT NULL   $isreturn_cancel )X";

		$result = $this->db->query($sql)->row();

		if (!empty($result)) {

			return $result;
		}

		return false;
	}

	public function getColorStatusCountreturn($srchcol = false)
	{

		$con1 = '';

		if ($srchcol) {

			if ($this->location_ismain == 'Y') {

				$con1 = $srchcol;
			} else {

				$con1 .= $srchcol;

				$con1 .= " AND rema_locationid ='" . $this->locationid . "'";
			}
		} else {

			$con1 = '';
		}

		$sql = "SELECT * FROM

xw_coco_colorcode cc

LEFT JOIN (

SELECT

	rema_st,

	COUNT('*') AS statuscount

FROM

	xw_rema_returnmaster rm

" . $con1 . "

GROUP BY

	rema_st

) X ON X.rema_st = cc.coco_statusval

WHERE

cc.coco_listname = 'issue_summarylistreturn'

AND cc.coco_statusval <> ''

AND cc.coco_isactive = 'Y'";

		$query = $this->db->query($sql);

		// echo $this->db->last_query();

		// die();

		return $query->result();
	}

	public function getColorStatusCountissue($srchcol = false)
	{

		$con1 = '';

		if ($srchcol) {

			if ($this->location_ismain == 'Y') {

				$con1 = $srchcol;
			} else {

				$con1 .= $srchcol;

				$con1 .= " AND sama_locationid ='" . $this->locationid . "'";
			}
		} else {

			$con1 = '';
		}

		$sql = "SELECT * FROM

xw_coco_colorcode cc

LEFT JOIN (

SELECT

	sama_st,

	COUNT('*') AS issuestatuscount

FROM

	xw_sama_salemaster sm

" . $con1 . "

GROUP BY

	sama_st

) X ON X.sama_st = cc.coco_statusval

WHERE

cc.coco_listname = 'issue_summarylist'

AND cc.coco_statusval <> ''

AND cc.coco_isactive = 'Y'";

		$query = $this->db->query($sql);

		// echo $this->db->last_query();

		// die();

		return $query->result();
	}

	public function get_return_master($srchcol = false)

	{

		$locationid = !empty($get['locationid']) ? $get['locationid'] : $this->input->post('locationid');

		$this->db->select('rm.*,d.dept_depname');

		$this->db->from('rema_returnmaster rm');

		$this->db->join('dept_department d', 'rm.rema_depid = d.dept_depid', 'left');

		if ($srchcol) {

			$this->db->where($srchcol);
		}

		if ($this->location_ismain == 'Y') {

			if ($locationid) {

				$this->db->where('rm.rema_locationid', $locationid);
			}
		} else {

			$this->db->where('rm.rema_locationid', $this->locationid);
		}

		$query = $this->db->get();

		// echo $this->db->last_query();

		// die();

		if ($query->num_rows() > 0) {

			$data = $query->result();

			return $data;
		}

		return false;
	}

	public function get_return_detail($srchcol = false)

	{

		$this->db->select('rd.*,il.itli_itemcode,il.itli_itemname,il.itli_itemnamenp,il.itli_itemlistid, ut.unit_unitname');

		$this->db->from('rede_returndetail rd');

		$this->db->join('itli_itemslist il', 'il.itli_itemlistid=rd.rede_itemsid', 'LEFT');

		$this->db->join('unit_unit ut', 'ut.unit_unitid=il.itli_unitid', 'LEFT');

		if ($srchcol) {

			$this->db->where($srchcol);
		}

		$query = $this->db->get();

		// echo $this->db->last_query();

		// die();

		if ($query->num_rows() > 0) {

			$data = $query->result();

			return $data;
		}

		return false;
	}

	public function get_all_issue_details($id = false, $invoiceno = false, $fyear = false)

	{

		$sql = "
	SELECT 
	itli_itemcode,
	itli_itemname,  
	itli_itemnamenp,  
	maty_material,
	maty_materialtypeid,
	issue_remarks,
	return_remarks,
	unit_unitname,
	SUM(
			CASE
			WHEN (tname = 'I') THEN
				(sade_qty)
			ELSE
				0
			END
		) AS IssQty,
	SUM(
		CASE
		WHEN (tname = 'R') THEN
			sade_qty
		ELSE
			0
		END
	) AS RetQty,
	(
		SUM(
			CASE
			WHEN (tname = 'I') THEN
				(sade_qty)
			ELSE
				0
			END
		) - SUM(

			CASE

			WHEN (tname = 'R') THEN

				sade_qty

			ELSE

				0

			END

		)

	) AS TotalIssue,

	SUM(

		CASE

		WHEN (tname = 'I') THEN

			amount

		ELSE

			0

		END

	) AS IssueValue,

	SUM(

		CASE

		WHEN (tname = 'R') THEN

			(amount)

		ELSE

			0

		END

	) AS ReturnValue,

	(

		SUM(

			CASE

			WHEN (tname = 'I') THEN

				(amount)

			ELSE

				0

			END

		) - SUM(

			CASE

			WHEN (tname = 'R') THEN

				amount

			ELSE

				0

			END

		)

	) AS TotalValue,

	unitrate

FROM

	(

		SELECT

			il.itli_itemcode,

			il.itli_itemname,

			il.itli_itemnamenp,

			my.maty_material,

			my.maty_materialtypeid,

			sm.sama_billdatebs,

			sm.sama_invoiceno,

			SUM(sd.sade_qty) sade_qty,

			sd.sade_remarks as issue_remarks,

			'' as return_remarks,

			SUM(sd.sade_qty * sd.sade_unitrate 

			)/SUM(sd.sade_qty) AS unitrate,

			u.unit_unitname,

			SUM(sd.sade_qty * sd.sade_unitrate

			) AS amount,

			'I' AS tname

		FROM

			xw_sama_salemaster sm

		LEFT JOIN xw_sade_saledetail sd ON sd.sade_salemasterid = sm.sama_salemasterid

		INNER JOIN xw_itli_itemslist il ON il.itli_itemlistid = sd.sade_itemsid

		LEFT JOIN xw_maty_materialtype my ON my.maty_materialtypeid = il.itli_materialtypeid

		LEFT JOIN xw_unit_unit u ON u.unit_unitid = il.itli_unitid

		WHERE

			sm.sama_st = 'N' AND sd.sade_salemasterid = '$id'
			GROUP BY sd.sade_itemsid

		UNION

			SELECT

			il.itli_itemcode,

			il.itli_itemname,

			il.itli_itemnamenp,

			my.maty_material,

			my.maty_materialtypeid,

			rm.rema_returndatebs,

			rm.rema_invoiceno AS issueno,

			rd.rede_qty,

			'' as issue_remarks,

			rd.rede_remarks as return_remarks,

			rd.rede_unitprice AS unitrate,

			u.unit_unitname,

			rd.rede_total AS amount,

				'R' AS tname

			FROM

		xw_rema_returnmaster rm 

			LEFT JOIN xw_rede_returndetail rd ON rm.rema_returnmasterid = rd.rede_returnmasterid

			LEFT JOIN xw_itli_itemslist il ON il.itli_itemlistid = rd.rede_itemsid

			LEFT JOIN xw_maty_materialtype my ON my.maty_materialtypeid = il.itli_materialtypeid

			LEFT JOIN xw_unit_unit u ON u.unit_unitid = il.itli_unitid

			WHERE rd.rede_invoiceno = '$invoiceno' AND rd.rede_salefyear = '$fyear'

	) X

	group by itli_itemname,unitrate

	";

		// if($srchcol)

		// {

		// 	$this->db->where($srchcol);

		// }

		// $query = $this->db->get();

		// echo $this->db->last_query();

		// die();

		$query = $this->db->query($sql);

		// echo $this->db->last_query();die();

		if ($query->num_rows() > 0) {

			$data = $query->result();

			return $data;
		}

		return false;
	}

	public function update_returnmaster($id)

	{

		if ($id) {

			$updateArray['rema_st'] = 'C';

			$updateArray['rema_stdepid'] = $this->session->userdata(STORE_ID);

			$updateArray['rema_stusername'] = $this->username;

			$updateArray['rema_stdatebs'] = CURDATE_NP;

			$updateArray['rema_stdatead'] = CURDATE_EN;

			$this->db->update('rema_returnmaster', $updateArray, array('rema_returnmasterid' => $id));

			$rwaff = $this->db->affected_rows();

			if ($rwaff) {

				$rede_data = $this->get_return_detail(array('rede_returnmasterid' => $id));

				// echo "<pre>";

				// print_r($rede_data);

				// die();

				if (!empty($rede_data)) {

					foreach ($rede_data as $ksd => $rede) {

						$qty = $rede->rede_qty;

						$returndetailid = $rede->rede_returndetailid;

						$mat_transdetailidid = $rede->rede_returnmasterid;

						$salesdtlid = $rede->rede_salesdetailid;

						$reqdtlid = $rede->rede_reqdetailid;

						$iscancel = $rede->rede_iscancel;

						if ($iscancel != 'Y') {

							$update_rd = $this->update_returndetail_tbl($returndetailid, $mat_transdetailidid, $salesdtlid, $reqdtlid, $qty);
						}
					}
				}

				return true;
			}
		}

		return false;
	}

	public function update_returndetail_tbl($returndetailid, $mat_transdetailidid, $salesdtlid, $reqdtlid, $qty)

	{

		// echo $sql="UPDATE xw_trde_transactiondetail SET trde_issueqty= (trde_issueqty)-$qty, trde_stripqty = (trde_stripqty)+$qty WHERE trde_trdeid=$mat_transdetailidid";

		// echo $sql2="UPDATE xw_sade_saledetail SET sade_curqty= (sade_curqty)+$qty WHERE sade_saledetailid=$salesdtlid";

		// die();

		if ($returndetailid) {

			$updateArray['rede_iscancel'] = 'Y';

			$updateArray['rede_canceldatead'] = CURDATE_EN;

			$updateArray['rede_canceldatebs'] = CURDATE_NP;

			$updateArray['rede_cancelby'] = $this->userid;

			$updateArray['rede_cancelusername'] = $this->username;

			$updateArray['rede_canceltime'] = $this->curtime;

			$updateArray['rede_cancelip'] = $this->ip;

			$this->db->update('rede_returndetail', $updateArray, array('rede_returndetailid' => $returndetailid));

			$rwaff = $this->db->affected_rows();

			if ($rwaff) {

				$this->db->query("UPDATE xw_trde_transactiondetail SET trde_issueqty= (trde_issueqty)-$qty, trde_stripqty = (trde_stripqty)+$qty WHERE trde_trdeid=$mat_transdetailidid  ");

				$this->db->query("UPDATE xw_sade_saledetail SET sade_curqty= (sade_curqty)+$qty WHERE sade_saledetailid=$salesdtlid  ");

				$this->db->query("UPDATE xw_rede_reqdetail SET rede_remqty= (rede_remqty)+$qty WHERE rede_reqdetailid=$reqdtlid  ");

				return true;
			}
		}

		return false;
	}

	public function check_item_stock($itemsid)
	{

		$this->db->select('(SELECT IFNULL(SUM(md.trde_issueqty),0) FROM xw_trde_transactiondetail md LEFT JOIN xw_trma_transactionmain mt   on md.trde_trmaid =mt.trma_trmaid

WHERE it.itli_itemlistid=md.trde_itemsid AND mt.trma_received=1 AND md.trde_locationid=' . $this->locationid . ' AND mt.trma_fromdepartmentid=' . $this->storeid . ' ) as stockqty');

		$this->db->from('itli_itemslist it');

		if ($itemsid) {

			$this->db->where(array('it.itli_itemlistid' => $itemsid));
		}

		$query = $this->db->get();

		if ($query->num_rows() > 0) {

			$result = $query->row();

			return $result->stockqty;
		}

		return false;
	}

	public function get_approve_data($id = false)
	{

		$this->db->select('rm.rema_approvedby, rm.rema_approvedid, rm.rema_approved, rm.rema_approveddatead, rm.rema_approveddatebs');

		$this->db->from('sama_salemaster sm');

		$this->db->join('rema_reqmaster rm', 'sm.sama_requisitionno = rm.rema_reqno and sm.sama_fyear = rm.rema_fyear and sm.sama_locationid = rm.rema_locationid');

		$this->db->where('sm.sama_salemasterid', $id);

		$this->db->where('sama_locationid', $this->locationid);

		$query = $this->db->get();

		if ($query->num_rows() > 0) {

			$result = $query->result();

			return $result;
		}

		return false;
	}

	public function get_user_list_for_issue_report($id)
	{

		$this->db->select('r.rema_reqno, sama_requisitionno, sama_invoiceno, u.usma_fullname as demander, s.sama_salemasterid, rema_postby, r.rema_verifiedby, u2.usma_fullname as supervisor, s.sama_receivedby as receiver, u3.usma_fullname as storekeeper, u.usma_employeeid as demander_userid, u2.usma_employeeid as supervisor_userid, u3.usma_employeeid as storekeeper_userid');

		$this->db->from('sama_salemaster s');

		$this->db->join('rema_reqmaster r', 'r.rema_reqno = s.sama_requisitionno and r.rema_fyear=s.sama_fyear', 'left');

		$this->db->join('usma_usermain u', 'r.rema_postby = u.usma_userid', 'left');

		$this->db->join('usma_usermain u2', 'r.rema_verifiedby = u2.usma_userid', 'left');

		$this->db->join('usma_usermain u3', 's.sama_postby = u3.usma_userid', 'left');

		$this->db->where('sama_salemasterid', $id);

		$this->db->where('sama_locationid', $this->locationid);

		$query = $this->db->get();

		// echo $this->db->last_query();

		// die();

		if ($query->num_rows() > 0) {

			$result = $query->result();

			return $result;
		}

		return false;
	}

	public function get_requisition_data_from_salemasterid($id)
	{

		$this->db->select('r.rema_reqmasterid, r.rema_workdesc, r.rema_workplace,r.rema_reqdatead,r.rema_reqdatebs,r.rema_reqby');

		$this->db->from('sama_salemaster s');

		$this->db->join('rema_reqmaster r', 'r.rema_reqno = s.sama_requisitionno and r.rema_fyear=s.sama_fyear', 'left');

		$this->db->where('sama_salemasterid', $id);

		$this->db->where('sama_locationid', $this->locationid);

		$query = $this->db->get();

		// echo $this->db->last_query();

		// die();

		if ($query->num_rows() > 0) {

			$result = $query->result();

			return $result;
		}

		return false;
	}

	public function get_equipment_category($id)
	{

		$this->db->select('itli_catid, ec.eqca_code');

		$this->db->from('sade_saledetail sd');

		$this->db->join('sama_salemaster sm', 'sm.sama_salemasterid = sd.sade_salemasterid', 'left');

		$this->db->join('itli_itemslist il', 'il.itli_itemlistid = sd.sade_itemsid', 'left');

		$this->db->join('eqca_equipmentcategory ec', 'ec.eqca_equipmentcategoryid = il.itli_catid', 'left');

		$this->db->where('sama_salemasterid', $id);

		$this->db->group_by('itli_catid');

		$query = $this->db->get();

		// echo $this->db->last_query();

		// die();

		if ($query->num_rows() > 0) {

			$result = $query->result();

			return $result;
		}

		return false;
	}

	public function varpai_issue_details($srchcol = false)
	{

		$this->db->select('sd.*,il.*,rn.sama_billdatebs,rn.sama_invoiceno, rn.sama_soldby, rn.sama_receivedby');

		$this->db->from('sade_saledetail sd');

		$this->db->join('itli_itemslist il', 'il.itli_itemlistid = sd.sade_itemsid', 'left');

		$this->db->join('sama_salemaster rn', 'rn.sama_salemasterid = sd.sade_salemasterid', 'LEFT');

		$this->db->where('itli_materialtypeid', 2);

		if ($srchcol) {

			$this->db->where($srchcol);
		}

		$query = $this->db->get();

		// echo $this->db->last_query();

		// die();

		if ($query->num_rows() > 0) {

			$result = $query->result();

			return $result;
		}

		return false;
	}

	public function get_issue_detail_for_api($srchcol = false)

	{

		$this->db->select('sd.*, sum(sd.sade_curqty) as totalcurqty, sum(sd.sade_qty) as totalqty, il.itli_itemcode,il.itli_materialtypeid,il.itli_itemname,il.itli_itemnamenp,il.itli_itemlistid,ut.unit_unitname,rd.rede_qty,rd.rede_remqty,sum(sd.sade_unitrate * sd.sade_qty) as subtotal,(SELECT IFNULL(SUM(md.trde_issueqty),0) FROM xw_trde_transactiondetail md LEFT JOIN xw_trma_transactionmain mt   on md.trde_trmaid =mt.trma_trmaid

WHERE il.itli_itemlistid=md.trde_itemsid AND mt.trma_received=1 AND md.trde_locationid=' . $this->locationid . ' AND mt.trma_fromdepartmentid=' . $this->storeid . ' ) as stockqty, sm.sama_receivedby, eq.eqca_accode, sama_invoiceno, sama_billdatebs, sama_depid, sama_username, sama_locationid, sama_remarks, sade_remarks, sade_itemsid, sade_qty, sade_unitrate');

		$this->db->from('sade_saledetail sd');

		$this->db->join('sama_salemaster sm', 'sm.sama_salemasterid = sd.sade_salemasterid');

		$this->db->join('rede_reqdetail rd', 'rd.rede_reqdetailid=sd.sade_reqdetailid', 'LEFT');

		$this->db->join('itli_itemslist il', 'il.itli_itemlistid=sd.sade_itemsid', 'INNER');

		$this->db->join('unit_unit ut', 'ut.unit_unitid=il.itli_unitid', 'LEFT');

		$this->db->join('eqca_equipmentcategory eq', 'eq.eqca_equipmentcategoryid = il.itli_catid', 'LEFT');

		$this->db->group_by('il.itli_itemlistid');

		if ($srchcol) {

			$this->db->where($srchcol);
		}

		$query = $this->db->get();

		// echo $this->db->last_query(); die();

		if ($query->num_rows() > 0) {

			$data = $query->result();

			return $data;
		}

		return false;
	}

	// direct save issue button for kukl

	public function save_issue_items($req_masterid)
	{	
		// echo '<pre>';
		// print_r($this->input->post());
		// die();
		$req_data = $this->requisition_mdl->get_requisition_data(array('rema_reqmasterid' => $req_masterid));

		// save issue items

		// $issue_date=$this->input->post('issue_date');
		$rema_issuedate = $this->input->post('rema_issuedate') ?? '';
		// $budget_headid = $this->input->post('budget_headid') ?? '';
		// $budget_categoryid = $this->input->post('budget_categoryid') ?? '';
		$issue_categoryid = $this->input->post('issue_category') ?? [];
		$issue_headid = $this->input->post('issue_budgethead') ?? [];

		if (DEFAULT_DATEPICKER == 'NP') {

			$reqdateNp = !empty($req_data[0]->rema_reqdatebs) ? $req_data[0]->rema_reqdatebs : '';

			$reqdateEn = !empty($req_data[0]->rema_reqdatead) ? $req_data[0]->rema_reqdatead : '';

			if (!empty($rema_issuedate)) {
				$issuedateNp = $rema_issuedate;
				$issuedateEn = $this->general->NepToEngDateConv($rema_issuedate);
			} else {
				$issuedateNp = CURDATE_NP;

				$issuedateEn = CURDATE_EN;
			}
		} else {

			$reqdateEn = !empty($req_data[0]->rema_reqdatead) ? $req_data[0]->rema_reqdatead : '';

			$reqdateNp = !empty($req_data[0]->rema_reqdatebs) ? $req_data[0]->rema_reqdatebs : '';

			if (!empty($rema_issuedate)) {
				$issuedateEn = $rema_issuedate;
				$issuedateNp = $this->general->EngtoNepDateConv($rema_issuedate);
			} else {
				$issuedateEn = CURDATE_EN;

				$issuedateNp = CURDATE_NP;
			}
		}

		$get_last_billno = $this->general->get_tbl_data('sama_billno', 'sama_salemaster', array('sama_fyear' => CUR_FISCALYEAR), 'sama_salemasterid', 'DESC');

		$billno = !empty($get_last_billno[0]->sama_billno) ? $get_last_billno[0]->sama_billno : 0;

		//master table data

		$depid = !empty($req_data[0]->rema_reqfromdepid) ? $req_data[0]->rema_reqfromdepid : '';

		$depname = !empty($req_data[0]->fromdepname) ? $req_data[0]->fromdepname : '';;

		$locationid = $this->locationid;

		$req_no = !empty($req_data[0]->rema_reqno) ? $req_data[0]->rema_reqno : '';

		$fiscal_year = !empty($req_data[0]->rema_fyear) ? $req_data[0]->rema_fyear : '';

		$currentfyrs = CUR_FISCALYEAR;

		$cur_fiscalyrs_invoiceno = $this->db->select('sama_invoiceno,sama_fyear')

			->from('sama_salemaster')

			->where('sama_locationid', $locationid)

			// ->where('sama_fyear',$currentfyrs)

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

		$issue_no = $this->general->generate_invoiceno('sama_invoiceno', 'sama_invoiceno', 'sama_salemaster', $invoice_no_prefix, INVOICE_NO_LENGTH, false, 'sama_locationid');

		$received_by = !empty($req_data[0]->rema_reqby) ? $req_data[0]->rema_reqby : '';

		$unit = "";

		//detail table data

		$itemsid = $this->input->post('itemlist');

		$qtyinstock = $this->input->post('stockqty');

		$unitrate = $this->input->post('unitprice'); //save in unitrate,nrate,purchaserate

		$qty = $this->input->post('qty');

		$remarks = $this->input->post('sade_remarks');

		$sama_remarks = "";

		$itemsname = $this->input->post('itemname');

		$my_rem_qty = $this->input->post('my_rem_qty');

		$volume = "";

		$s_no = "";

		$rede_reqdetailid = $this->input->post('reqdetailid');
		$issue_filename = '';
		if (ORGANIZATION_NAME == 'KUKL') {
			if (!empty($_FILES['issue_attachment']['name'])) {
			$issue_filename = $this->doupload('issue_attachment'); 
			}
		}

		$samaMasterArray = array(

			'sama_requisitionno' => $req_no,

			'sama_depid' => $depid, //depid

			'sama_depname' => $depname, //depname

			'sama_billdatead' => $issuedateEn,

			'sama_billdatebs' => $issuedateNp,

			'sama_billtime' => $this->curtime,

			'sama_duedatead' => $issuedateEn,

			'sama_duedatebs' => $issuedateNp,

			'sama_soldby' => $this->username,

			'sama_username' => $this->username,

			'sama_lastchangedate' => '',

			'sama_orderno' => 0,

			'sama_challanno' => 0,

			'sama_billno' => $billno + 1,

			'sama_payment' => 0, //0

			'sama_status' => 'O', //O

			'sama_fyear' => $fiscal_year,

			'sama_discountpc' => '',

			'sama_st' => 'N',

			'sama_invoiceno' => $issue_no,

			'sama_manualbillno' => '',

			'sama_requisitiondatead' => $reqdateEn,

			'sama_requisitiondatebs' => $reqdateNp,

			'sama_storeid' => $this->storeid,

			'sama_remarks' => $sama_remarks,

			'sama_receivedby' => strtoupper($received_by),

			'sama_postdatead' => CURDATE_EN,

			'sama_postdatebs' => CURDATE_NP,

			'sama_postby' => $this->userid,

			'sama_postmac' => $this->mac,

			'sama_postip' => $this->ip,

			'sama_locationid' => $locationid,

			'sama_orgid' => $this->orgid,

			'sama_issue_attachment' => $issue_filename,
		);

		// print_r($samaMasterArray);
		// die();

		$this->db->trans_begin();

		if (!empty($samaMasterArray)) {   //print_r($samaMasterArray);die;

			// insert into sale master

			$this->db->insert($this->sama_masterTable, $samaMasterArray);

			$insertid = $this->db->insert_id();

			if ($insertid) {

				$ReqMasterArray = array(

					'rema_received' => '1'

				);

				if ($ReqMasterArray) {

					$this->general->save_log($this->rema_masterTable, 'rema_reqno', $req_no, $ReqMasterArray, 'Update');

					$this->db->update($this->rema_masterTable, $ReqMasterArray, array('rema_reqno' => $req_no, 'rema_fyear' => $fiscal_year, 'rema_storeid' => $this->storeid));
				}

				//update remqty of req detail

				if (!empty($itemsid)) :

					foreach ($itemsid as $key => $val) {

						$reqDetail[] = array(

							'rede_reqdetailid' => !empty($rede_reqdetailid[$key]) ? $rede_reqdetailid[$key] : '',

							'rede_remqty' => !empty($my_rem_qty[$key]) ? $my_rem_qty[$key] : '',

							// 'rede_budgetheadid' => $budget_headid,

							// 'rede_catid' => $budget_categoryid,	

							'rede_modifydatead' => CURDATE_EN,

							'rede_modifydatebs' => CURDATE_NP,

							'rede_modifytime' => $this->curtime,

							'rede_modifyby' => $this->userid,

							'rede_modifymac' => $this->mac,

							'rede_modifyip' => $this->ip,

							'rede_locationid' => $locationid

						);
					} // end foreach item

					if ($reqDetail) {

						$this->db->update_batch($this->rede_detailTable, $reqDetail, 'rede_reqdetailid');
					}

				endif;

				$totalRateAmount = 0;

				$totalDiscount = 0;

				$totalVat = 0;

				$totalNetrate = 0;

				$totalAmount = 0;

				$totalTaxrate = 0;

				$discountpc = 0;

				//insert into sale detail table

				// echo "REQ<pre>";

				// print_r($rede_reqdetailid);

				// // die();

				// echo "REM<pre>";

				// print_r($remarks);

				// // die();

				// echo "SN<pre>";

				// print_r($s_no);

				// die();

				if (!empty($itemsid)) :

					foreach ($itemsid as $key => $val) {

						$items_id = !empty($itemsid[$key]) ? $itemsid[$key] : '';

						$issue_qty = !empty($qty[$key]) ? $qty[$key] : '';

						$reqdetailid = !empty($rede_reqdetailid[$key]) ? $rede_reqdetailid[$key] : '';

						$rmks = !empty($remarks[$key]) ? $remarks[$key] : '';

						$sno = !empty($s_no[$key]) ? $s_no[$key] : '';

						// $volume = !empty($volume[$key])?$volume[$key]:'';

						$volume = 0;

						$microunitid = 0;

						$issue_catid = $issue_categoryid[$key] ?? '';
						$issue_budgetid = $issue_headid[$key] ?? '';

						// $mattransdetailid = $this->get_mat_trans_detail_id($items_id,$volume,$microunitid,$issue_qty);

						$this->insert_into_sale_master($items_id, $issue_qty, $insertid, $reqdetailid, $rmks, $sno, $issue_catid, $issue_budgetid);

						// $checkSalesMaster = $this->update_mat_trans_detailid($mattransdetailid,$issue_qty,'new_issue');

						$unitrate = !empty($unitrate[$key]) ? $unitrate[$key] : 0;

						$totalAmount += $unitrate;
					}

					// die();

					$updateMasterSaleArray = array(

						'sama_discountpc' => $discountpc,

						'sama_discount' => $totalDiscount,

						'sama_vat' => $totalVat,

						'sama_taxrate' => $totalTaxrate,

						'sama_totalamount' => $totalAmount

					);

					if ($updateMasterSaleArray) {

						$this->db->where('sama_salemasterid', $insertid);

						$this->db->update($this->sama_masterTable, $updateMasterSaleArray);
					}

				endif;
			} // end if insertid

		} // if samaMasterArray

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {

			$this->db->trans_rollback();

			return false;
		} else {

			$this->db->trans_commit();

			return $insertid;
		}
	}

	public function insert_api_data_locally($issue_no)
	{

		$issue_detail_list = $this->new_issue_mdl->get_issue_detail_for_api(array('sd.sade_salemasterid' => $issue_no));

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

	public function doupload($file)
    {
        $config['upload_path'] = './' . BILL_ATTACHMENT_PATH; //define in constants
        $config['allowed_types'] = 'png|jpg|jpeg|pdf';
        $config['encrypt_name'] = TRUE;
        $config['remove_spaces'] = TRUE;
        $config['max_size'] = '2000000'; 
        $config['max_width'] = '5000';
        $config['max_height'] = '5000';
        $this->load->library('upload', $config);
        $this->upload->do_upload($file);
        $data = $this->upload->data();
        $name_array = $data['file_name'];   
        return $name_array;
    }
}