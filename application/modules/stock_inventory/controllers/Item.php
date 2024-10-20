<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Item extends CI_Controller {
	function __construct() {

		parent::__construct();
		$this->load->Model('item_mdl');
		$this->locationid = $this->session->userdata(LOCATION_ID);
		$this->location_ismain = $this->session->userdata(ISMAIN_LOCATION);
		$this->usergroup = $this->session->userdata(USER_GROUPCODE);
		$this->stock_view_group = array('SA', 'SK', 'SI');

	}

	public function index() {

		//$this->data['equipment_all'] = $this->equipment_mdl->get_all_equipment();

		$this->data['editurl'] = base_url() . 'stock_inventory/item/edit_item';
		$this->data['deleteurl'] = base_url() . 'stock_inventory/item/delete_item';
		$this->data['listurl'] = base_url() . 'stock_inventory/item/list_item';
		// $assignactivity=$this->assign_equipement_mdl->get_assign_equipment();
		// echo "<pre>";
		// print_r($assignactivity);
		// die();
		$this->data['material_type'] = $this->general->get_tbl_data('*', 'maty_materialtype');
		$this->data['subcategory'] = $this->general->get_tbl_data('*', 'eqca_equipmentcategory', array('eqca_isactive' => 'Y'));
		$this->data['brand'] = $this->general->get_tbl_data('*', 'bran_brand');
		$this->data['unit'] = $this->general->get_tbl_data('*', 'unit_unit', array('unit_isactive' => 'Y'));
		$this->data['equipmenttype'] = $this->general->get_tbl_data('*', 'eqty_equipmenttype');

		$this->data['modal'] = '';

		$this->data['breadcrumb'] = 'Stock Inventory/Item List';
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
			->build('item/v_item', $this->data);
	}

	public function search_acc_code() {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$data['account_code_list'] = $this->search_for_acc_code();
			// echo $this->db->last_query();
			// echo "<pre>";
			// print_r($data);
			// die();
			$template = $this->load->view('item/v_account_code_list', $data, true);
			if ($template) {
				print_r(json_encode(array('status' => 'success', 'message' => 'Selected Successfully', 'template' => $template)));
				exit;
			} else {
				print_r(json_encode(array('status' => 'error', 'message' => 'Operation Unsuccessful')));
				exit;
			}
		} else {
			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		}
	}

	public function search_for_acc_code() {
		$match = $this->input->post('srchtext');
		$this->db->select('*');
		$this->db->from('acty_accounttype');
		$this->db->like('acty_accode', "$match", 'both');
		$this->db->or_like('acty_acname', "$match", 'both');
		$this->db->limit(10);
		$result = $this->db->get()->result();
		return $result;
	}

	public function save_item() {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$id = $this->input->post('id');
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

				if ($id) {
					$this->data['item_data'] = $this->item_mdl->get_all_itemlist(array('it.itli_itemlistid' => $id));
					// echo "<pre>";
					// print_r($data['dept_data']);
					// die();
					if ($this->data['item_data']) {
						$p_date = $this->data['item_data'][0]->itli_postdatead;
						$p_time = $this->data['item_data'][0]->itli_posttime;
						$editstatus = $this->general->compute_data_for_edit($p_date, $p_time);
						$usergroup = $this->session->userdata(USER_GROUPCODE);

						// if ($editstatus == 0 && $usergroup != 'SA') {
						// 	$this->general->disabled_edit_message();

						// }
					}
				}
				$this->form_validation->set_rules($this->item_mdl->validate_settings_itemlist);
				// }

				if ($this->form_validation->run() == TRUE) {
					$trans = $this->item_mdl->save_item();
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

	public function save_otheritem() {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			try {

				$this->form_validation->set_rules($this->item_mdl->validate_settings_otheritemlist);
				// }

				if ($this->form_validation->run() == TRUE) {
					$trans = $this->item_mdl->save_otheritem();
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

	public function form_item() {
		$this->data['editurl'] = base_url() . 'stock_inventory/item/edit_item';
		$this->data['deleteurl'] = base_url() . 'stock_inventory/item/delete_item';
		$this->data['listurl'] = base_url() . 'dep_change/list_item';
		$this->data['material_type'] = $this->general->get_tbl_data('*', 'maty_materialtype');
		$this->data['subcategory'] = $this->general->get_tbl_data('*', 'eqca_equipmentcategory');
		$this->data['brand'] = $this->general->get_tbl_data('*', 'bran_brand');
		$this->data['unit'] = $this->general->get_tbl_data('*', 'unit_unit');
		$this->data['equipmenttype'] = $this->general->get_tbl_data('*', 'eqty_equipmenttype');
		$this->data['breadcrumb'] = 'Stock Inventory/Item List';
		$this->data['modal'] = '';
		// $this->load->view('item/v_item_form',$this->data);
		if (defined('ITEM_FORM')):
			if (ITEM_FORM == 'DEFAULT') {
				$this->load->view('item/v_item_form', $this->data);
			} else {
				$this->load->view('item/' . REPORT_SUFFIX . '/v_item_form', $this->data);
			} else :
			$this->load->view('item/v_item_form', $this->data);
		endif;
	}

	public function list_item() {
		if (MODULES_VIEW == 'N') {
			$this->general->permission_denial_message();
			exit;
		}

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$data = array();
			$data['material_type'] = $this->general->get_tbl_data('*', 'maty_materialtype');
			$data['subcategory'] = $this->general->get_tbl_data('*', 'eqca_equipmentcategory', array('eqca_isactive' => 'Y'));
			$template = $this->load->view('item/v_item_list', $data, true);
			print_r(json_encode(array('status' => 'success', 'message' => 'Successfully Selected!!', 'template' => $template, 'tempform' => $template)));
			exit;
		} else {
			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		}
	}

	public function edit_item() {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if (MODULES_UPDATE == 'N') {
				$this->general->permission_denial_message();
				exit;
			}
			$id = $this->input->post('id');

			$this->data['material_type'] = $this->general->get_tbl_data('*', 'maty_materialtype', array('maty_isactive' => 'Y'));

			$this->data['brand'] = $this->general->get_tbl_data('*', 'bran_brand');
			$this->data['unit'] = $this->general->get_tbl_data('*', 'unit_unit');
			$this->data['equipmenttype'] = $this->general->get_tbl_data('*', 'eqty_equipmenttype');

			$this->data['item_data'] = $this->item_mdl->get_all_itemlist(array('it.itli_itemlistid' => $id));
			$this->data['subcategory'] = $this->general->get_tbl_data('*', 'eqca_equipmentcategory', array('eqca_isactive' => 'Y'));

			$mattypeid = 1;
			if ($this->data['item_data']) {
				$mattypeid = $this->data['item_data'][0]->itli_materialtypeid;
				$post_date = $this->data['item_data'][0]->itli_postdatead;
				$post_time = $this->data['item_data'][0]->itli_posttime;
				$editstatus = $this->general->compute_data_for_edit($post_date, $post_time);
				// echo $editstatus;
				// die();
				$this->data['edit_status'] = $editstatus;

			}

			if (defined('ITEM_FORM')):
				if (ITEM_FORM == 'DEFAULT') {
					$tempform = $this->load->view('item/v_item_form', $this->data, true);
				} else {

					$itemcatid = $this->data['item_data'][0]->itli_catid;
					$condition = array('eqca_isactive' => 'Y', 'eqca_mattypeid' => $mattypeid);
					if (ORGANIZATION_NAME == "NPHL" || ORGANIZATION_NAME == 'KUKL') {
						$condition = array('eqca_isactive' => 'Y');
					}
					$this->data['subcategory'] = $this->general->get_tbl_data('*', 'eqca_equipmentcategory', $condition);

					$this->data['parent_data'] = $this->general->get_tbl_data('itli_itemlistid,itli_itemparentid,itli_catid,itli_itemcode,itli_itemname,itli_itemnamenp', 'itli_itemslist', array('itli_catid' => $itemcatid));
					$tempform = $this->load->view('item/' . REPORT_SUFFIX . '/v_item_form', $this->data, true);
				} else :
				$tempform = $this->load->view('item/v_item_form', $this->data, true);
			endif;

			if (!empty($this->data['item_data'])) {
				print_r(json_encode(array('status' => 'success', 'message' => 'You Can edit', 'tempform' => $tempform)));
				exit;
			} else {
				print_r(json_encode(array('status' => 'error', 'message' => 'Unable to Edit!!')));
				exit;
			}
		} else {
			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		}
	}

	public function delete_item() {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if (MODULES_DELETE == 'N') {
				$this->general->permission_denial_message();
				exit;
			}

			$id = $this->input->post('id');
			$this->data['item_data'] = $this->item_mdl->get_all_itemlist(array('it.itli_itemlistid' => $id));
			if ($this->data['item_data']) {
				$p_date = $this->data['item_data'][0]->itli_postdatead;
				$p_time = $this->data['item_data'][0]->itli_posttime;
				$editstatus = $this->general->compute_data_for_edit($p_date, $p_time);
				$usergroup = $this->session->userdata(USER_GROUPCODE);

				if ($editstatus == 0 && $usergroup != 'SA') {
					$this->general->disabled_edit_message();

				}
			}

			$trans = $this->item_mdl->remove_item();
			if ($trans) {
				print_r(json_encode(array('status' => 'success', 'message' => 'Successfully Deleted!!')));
				exit;
			} else {
				print_r(json_encode(array('status' => 'error', 'message' => 'Error while deleting!!')));
				exit;
			}

		} else {
			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		}

	}

	public function get_item_category_list() {

		if (MODULES_VIEW == 'N') {
			$array = array();
			echo json_encode(array("recordsFiltered" => 0, "recordsTotal" => 0, "data" => $array));
			exit;
		}
		$useraccess = $this->session->userdata(USER_ACCESS_TYPE);
		$orgid = $this->session->userdata(ORG_ID);

		if ($this->location_ismain) {
			$data = $this->item_mdl->get_item_list(); //echo "<pre>"; print_r($data); die();
		} else {
			$data = $this->item_mdl->get_item_list(); //echo "<pre>"; print_r($data); die();
		}

		$i = 0;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"] > 0 ? $data["totalfilteredrecs"] : $data["totalrecs"]);
		$totalrecs = $data["totalrecs"];
		$lang = $this->session->userdata('lang');

		unset($data["totalfilteredrecs"]);
		unset($data["totalrecs"]);

		foreach ($data as $row) {

			$array[$i]["maty_material"] = substr($row->maty_material, 0, 5);
			$array[$i]["eqca_category"] = $row->eqca_category;

			if (ORGANIZATION_NAME == 'KUKL'):
				$ac_code = !empty($row->itli_accode) ? ' (' . $row->itli_accode . ')' : '';
				$array[$i]["itli_itemcode"] = $row->itli_itemcode . $ac_code;
			else:
				$array[$i]["itli_itemcode"] = $row->itli_itemcode;
			endif;

			$array[$i]["itli_itemname"] = $row->itli_itemname;

			$array[$i]["itli_itemnamenp"] = '<span class="' . FONT_CLASS . '">' . $row->itli_itemnamenp . '</span>';

			$array[$i]["itli_purchaserate"] = $row->itli_purchaserate;
			$array[$i]["unit_unitname"] = $row->unit_unitname;
			$array[$i]["eqty_equipmenttype"] = $row->eqty_equipmenttype;
			
	    if(DEFAULT_DATEPICKER == 'NP'){  
	    	$array[$i]["postdate"] = $row->itli_postdatebs .' '.$row->itli_posttime;
	    }else{
			$array[$i]["postdate"] = $row->itli_postdatead .' '.$row->itli_posttime;
	    }
			
			//original code
			// $array[$i]["action"] = '<a href="javascript:void(0)" data-id=' . $row->itli_itemlistid . ' data-displaydiv="item" title="Edit" data-viewurl=' . base_url('stock_inventory/item/edit_item') . ' class="btnEdit"><i class="fa fa-edit" aria-hidden="true" ></i></a>
			// <a href="javascript:void(0)" data-id=' . $row->itli_itemlistid . ' data-tableid=' . ($i + 1) . ' data-deleteurl=' . base_url('stock_inventory/item/delete_item') . ' class="btnDeleteServer" title="Delete"><i class="fa fa-trash-o" aria-hidden="true" ></i></a>
			// ';
			//new code
			$array[$i]["action"] =
			'
			   <a href="javascript:void(0)" data-id=' . $row->itli_itemlistid . ' title="Edit" class="btn view btnitem mr-5 pr-5" data-heading= "Item List" data-viewurl = ' . base_url('stock_inventory/item/edit_stock_item') . '><i class="fa fa-edit" aria-hidden="true" ></i></a>
			   <a href="javascript:void(0)" data-id=' . $row->itli_itemlistid . ' data-tableid=' . ($i + 1) . ' data-deleteurl=' . base_url('stock_inventory/item/delete_item') . ' class="btnDeleteServer" title="Delete"><i class="fa fa-trash-o" aria-hidden="true" ></i></a>
			   ';
			// /add_item_for_stock_inventory

			$i++;
			//(object)array('',$row->studentregno,$row->firstname,$row->classsemyear,$row->section,$row->rollno,$row->gender,'');
		}
		echo json_encode(array("recordsFiltered" => $filtereddata, "recordsTotal" => $totalrecs, "data" => $array));
	}

	public function edit_stock_item() {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if (MODULES_UPDATE == 'N') {
				$this->general->permission_denial_message();
				exit;
			}
			$id = $this->input->post('id');

			$this->data['operation']='edit';
			$this->data['material_type'] = $this->general->get_tbl_data('*', 'maty_materialtype', array('maty_isactive' => 'Y'));

			$this->data['brand'] = $this->general->get_tbl_data('*', 'bran_brand');
			$this->data['unit'] = $this->general->get_tbl_data('*', 'unit_unit');
			$this->data['equipmenttype'] = $this->general->get_tbl_data('*', 'eqty_equipmenttype');

			$this->data['item_data'] = $this->item_mdl->get_all_itemlist(array('it.itli_itemlistid' => $id));
			$this->data['subcategory'] = $this->general->get_tbl_data('*', 'eqca_equipmentcategory', array('eqca_isactive' => 'Y'));
				if(ORGANIZATION_NAME=='KUKL'):
			$this->data['item_group_rec']=$this->general->get_tbl_data('itgr_id,itgr_code,itgr_name','itgr_itemgroup',array('itgr_isactive'=>'Y'),'itgr_name','ASC');
			endif;

			$mattypeid = 1;
			if ($this->data['item_data']) {
				$mattypeid = $this->data['item_data'][0]->itli_materialtypeid;
				$post_date = $this->data['item_data'][0]->itli_postdatead;
				$post_time = $this->data['item_data'][0]->itli_posttime;
				$editstatus = $this->general->compute_data_for_edit($post_date, $post_time);
				// echo $editstatus;
				// die();
				$this->data['edit_status'] = $editstatus;

			}

			// if (defined('ITEM_FORM')):
			// 	if (ITEM_FORM == 'DEFAULT') {
			// 		$tempform = $this->load->view('item/v_item_add_popup_stock_inventory', $this->data, true);
			// 	} else {

			// 		$itemcatid = $this->data['item_data'][0]->itli_catid;
			// 		$condition = array('eqca_isactive' => 'Y', 'eqca_mattypeid' => $mattypeid);
			// 		if (ORGANIZATION_NAME == "NPHL" || ORGANIZATION_NAME == 'KUKL') {
			// 			$condition = array('eqca_isactive' => 'Y');
			// 		}
			// 		$this->data['subcategory'] = $this->general->get_tbl_data('*', 'eqca_equipmentcategory', $condition);

			// 		$this->data['parent_data'] = $this->general->get_tbl_data('itli_itemlistid,itli_itemparentid,itli_catid,itli_itemcode,itli_itemname,itli_itemnamenp', 'itli_itemslist', array('itli_catid' => $itemcatid));
			// 		$tempform = $this->load->view('item/' . REPORT_SUFFIX . '/v_item_add_popup_stock_inventory', $this->data, true);
			// 	} else :
			// 	$tempform = $this->load->view('item/v_item_add_popup_stock_inventory', $this->data, true);
			// endif;
			$tempform = $this->load->view('item/v_item_add_popup_stock_inventory', $this->data, true);

			if (!empty($this->data['item_data'])) {
				print_r(json_encode(array('status' => 'success', 'message' => 'You Can edit', 'tempform' => $tempform)));
				exit;
			} else {
				print_r(json_encode(array('status' => 'error', 'message' => 'Unable to Edit!!')));
				exit;
			}
		} else {
			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		}
	}

	public function list_item_normal() {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$this->data = array();
			$this->data['rowno'] = $this->input->post('id');
			$this->data['type'] = $this->input->post('type') ? $this->input->post('type') : 0;
			// if(MODULES_VIEW=='N')
			// 	{
			// 	$this->general->permission_denial_message();
			// 	exit;
			// 	}

			$template = $this->load->view('item/v_item_list_normal_popup', $this->data, true);
			print_r(json_encode(array('status' => 'success', 'message' => 'Successfully Selected!!', 'template' => $template, 'tempform' => $template)));
			exit;
		} else {
			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		}
	}

	public function list_item_with_stock() {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$this->data = array();
			$this->data['rowno'] = $this->input->post('id');
			// if(MODULES_VIEW=='N')
			// 	{
			// 	$this->general->permission_denial_message();
			// 	exit;
			// 	}

			$template = $this->load->view('item/v_item_list_popup', $this->data, true);
			print_r(json_encode(array('status' => 'success', 'message' => 'Successfully Selected!!', 'template' => $template, 'tempform' => $template)));
			exit;
		} else {
			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		}
	}

	public function get_item_list_normal($rowno = false, $type = false) {
		$useraccess = $this->session->userdata(USER_ACCESS_TYPE);
		$orgid = $this->session->userdata(ORG_ID);
		if (!empty($type)) {
			$srchcol = array('itli_materialtypeid' => $type);
		} else {
			$srchcol = false;
		}
		$data = $this->item_mdl->item_list_normal($srchcol);
		// echo "<pre>"; print_r($data); die();
		$i = 0;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"] > 0 ? $data["totalfilteredrecs"] : $data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

		unset($data["totalfilteredrecs"]);
		unset($data["totalrecs"]);

		foreach ($data as $row) {
			if (ITEM_DISPLAY_TYPE == 'NP') {
				$array[$i]["itemname_display"] = !empty($row->itli_itemnamenp) ? $row->itli_itemnamenp : $row->itli_itemname;
			} else {
				$array[$i]["itemname_display"] = !empty($row->itli_itemname) ? $row->itli_itemname : '';
			}

			// if(ITEM_DISPLAY_TYPE=='NP'){
			//         	$req_itemname = !empty($row->itli_itemnamenp)?$row->itli_itemnamenp:$row->itli_itemname;
			//         }else{
			//             $req_itemname = !empty($row->itli_itemname)?$row->itli_itemname:'';
			//         }

			$array[$i]["rowno"] = $rowno;
			$array[$i]["itemlistid"] = $row->itli_itemlistid;
			$array[$i]["itemcode"] = $row->itli_itemcode;
			$array[$i]["itemname"] = $row->itli_itemname;
			$array[$i]["itemnamenp"] = $row->itli_itemnamenp;
			$array[$i]["salesrate"] = $row->itli_salesrate;
			$array[$i]["purchase_rate"] = $row->itli_purchaserate;
			$array[$i]["unitname"] = $row->unit_unitname;
			$i++;
			//(object)array('',$row->studentregno,$row->firstname,$row->classsemyear,$row->section,$row->rollno,$row->gender,'');
		}
		echo json_encode(array("recordsFiltered" => $filtereddata, "recordsTotal" => $totalrecs, "data" => $array));
	}

	public function get_item_list($rowno = false) {

		$useraccess = $this->session->userdata(USER_ACCESS_TYPE);
		$orgid = $this->session->userdata(ORG_ID);
		$data = $this->item_mdl->item_list_tbl();
		// echo "<pre>"; print_r($data); die();
		$i = 0;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"] > 0 ? $data["totalfilteredrecs"] : $data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

		unset($data["totalfilteredrecs"]);
		unset($data["totalrecs"]);

		foreach ($data as $row) {
			if (ITEM_DISPLAY_TYPE == 'NP') {
				$array[$i]["itemname_display"] = !empty($row->itli_itemnamenp) ? $row->itli_itemnamenp : $row->itli_itemname;
			} else {
				$array[$i]["itemname_display"] = !empty($row->itli_itemname) ? $row->itli_itemname : '';
			}

			$array[$i]["rowno"] = $rowno;
			$array[$i]["itemlistid"] = $row->itli_itemlistid;
			$array[$i]["itemcode"] = $row->itli_itemcode;
			$array[$i]["itemname"] = $row->itli_itemname;
			$array[$i]["itemnamenp"] = $row->itli_itemnamenp;
			$array[$i]["salesrate"] = $row->itli_salesrate;
			$array[$i]["stockqty"] = $row->stockqty;
			$array[$i]["unitname"] = $row->unit_unitname;
			$i++;
			//(object)array('',$row->studentregno,$row->firstname,$row->classsemyear,$row->section,$row->rollno,$row->gender,'');
		}
		echo json_encode(array("recordsFiltered" => $filtereddata, "recordsTotal" => $totalrecs, "data" => $array));
	}

	public function list_item_with_stock_transfer() {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			// echo $storeid;
			// die();

			$this->data = array();
			$this->data['rowno'] = $this->input->post('id');
			$storeid = $this->input->post('storeid');
			// if(MODULES_VIEW=='N')
			// 	{
			// 	$this->general->permission_denial_message();
			// 	exit;
			// 	}
			$store_type = !empty($this->session->userdata(STORE_ID)) ? $this->session->userdata(STORE_ID) : '';

			$this->data['storeid'] = !empty($storeid) ? $storeid : $store_type;
			$template = '';
			$template = $this->load->view('item/v_item_list_popup_stock_transfer', $this->data, true);
			print_r(json_encode(array('status' => 'success', 'message' => 'Successfully Selected!!', 'template' => $template, 'tempform' => $template)));
			exit;
		} else {
			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		}
	}

	// For Stock and Inventory --> Stock Transafer
	public function get_item_list_stock_transfer($rowno = false, $storeid = false) {
		//print_r($rowno); print_r($storeid);die;
		$stid = "";
		if (!empty($storeid)) {
			$stid = array('trma_todepartmentid' => $storeid);
		}
		$useraccess = $this->session->userdata(USER_ACCESS_TYPE);
		$orgid = $this->session->userdata(ORG_ID);
		$data = $this->item_mdl->get_item_list_stock_transfer($stid);
		//echo "<pre>";  print_r($data); die();

		$i = 0;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"] > 0 ? $data["totalfilteredrecs"] : $data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

		unset($data["totalfilteredrecs"]);
		unset($data["totalrecs"]);

		foreach ($data as $row) {
			if (ITEM_DISPLAY_TYPE == 'NP') {
				$array[$i]["itemname_display"] = !empty($row->itli_itemnamenp) ? $row->itli_itemnamenp : $row->itli_itemname;
			} else {
				$array[$i]["itemname_display"] = !empty($row->itli_itemname) ? $row->itli_itemname : '';
			}

			$array[$i]["rowno"] = $rowno;
			$array[$i]["itemlistid"] = $row->itli_itemlistid;
			$array[$i]["itemcode"] = $row->itli_itemcode;
			$array[$i]["mtdid"] = $row->trde_mtdid;
			$array[$i]["itemname"] = $row->itli_itemname;
			$array[$i]["itemnamenp"] = $row->itli_itemnamenp;

			$array[$i]["mattransdetailid"] = $row->trde_trdeid;
			$array[$i]["mattransmasterid"] = $row->trde_trmaid;
			$array[$i]["supplierid"] = $row->trde_trmaid;
			$array[$i]["controlno"] = $row->controlno;
			$array[$i]["supplierbillno"] = $row->trde_supplierid;
			$array[$i]["expdatead"] = $row->trde_expdatead;
			$array[$i]["expdatebs"] = $row->trde_expdatebs;
			$array[$i]["issueno"] = $row->trma_issueno;
			$array[$i]["stockqty"] = $row->trde_issueqty;
			$array[$i]["unitprice"] = $row->trde_unitprice;
			$array[$i]["unitname"] = $row->unit_unitname;
			$array[$i]["unitid"] = $row->unit_unitid;
			$array[$i]["purchaserate"] = $row->itli_purchaserate;
			$i++;
		}
		echo json_encode(array("recordsFiltered" => $filtereddata, "recordsTotal" => $totalrecs, "data" => $array));
	}

	public function list_item_with_stock_requisition() {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			// echo $storeid;
			// die();
			$this->unknown = 'N';

			$this->data = array();
			$this->data['rowno'] = $this->input->post('id');
			$this->data['storeid'] = $this->input->post('storeid');
			$this->data['type'] = $this->input->post('type');
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

	public function add_item_for_stock_inventory() {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			// echo $storeid;
			// die();
			$this->unknown = 'N';

			$this->data = array();
			$this->data['operation']='add';
			$this->data['rowno'] = $this->input->post('id');
			$this->data['storeid'] = $this->input->post('storeid');
			$this->data['type'] = $this->input->post('type');
			$this->data['editurl'] = base_url() . 'stock_inventory/item/edit_item';
			$this->data['deleteurl'] = base_url() . 'stock_inventory/item/delete_item';
			$this->data['listurl'] = base_url() . 'stock_inventory/item/list_item';
			// $assignactivity=$this->assign_equipement_mdl->get_assign_equipment();
			// echo "<pre>";
			// print_r($assignactivity);
			// die();
			$this->data['material_type'] = $this->general->get_tbl_data('*', 'maty_materialtype');
			$this->data['subcategory'] = $this->general->get_tbl_data('*', 'eqca_equipmentcategory', array('eqca_isactive' => 'Y'));
			$this->data['brand'] = $this->general->get_tbl_data('*', 'bran_brand');
			$this->data['unit'] = $this->general->get_tbl_data('*', 'unit_unit', array('unit_isactive' => 'Y'));
			$this->data['equipmenttype'] = $this->general->get_tbl_data('*', 'eqty_equipmenttype');
			if(ORGANIZATION_NAME=='KUKL'):
			$this->data['item_group_rec']=$this->general->get_tbl_data('itgr_id,itgr_code,itgr_name','itgr_itemgroup',array('itgr_isactive'=>'Y'),'itgr_name','ASC');
			endif;

			$this->data['modal'] = '';

			$this->data['breadcrumb'] = 'Item Add';
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

			// if(MODULES_VIEW=='N')
			// 	{
			// 	$this->general->permission_denial_message();
			// 	exit;
			// 	}
			$template = '';
			$template = $this->load->view('item/v_item_add_popup_stock_inventory', $this->data, true);
			print_r(json_encode(array('status' => 'success', 'message' => 'Successfully Selected!!', 'template' => $template, 'tempform' => $template)));
			exit;
		} else {
			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		}
	}

	public function addotheritem() {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$this->data = array();
			$template = '';
			$template = $this->load->view('item/v_other_item_add', $this->data, true);
			print_r(json_encode(array('status' => 'success', 'message' => 'Successfully Selected!!', 'template' => $template, 'tempform' => $template)));
			exit;

		} else {
			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		}
	}

	public function get_item_list_stock_requisition($rowno = false, $storeid = false, $type = false) {
		//print_r($rowno); print_r($storeid);die;
		// $stid ="";
		// if(!empty($storeid)){
		// 	$stid = array('trma_todepartmentid'=>$storeid);
		// }
		// echo $type;
		// die();
		$storeid = !empty($storeid) ? $storeid : $this->session->userdata(STORE_ID);

		$useraccess = $this->session->userdata(USER_ACCESS_TYPE);
		$orgid = $this->session->userdata(ORG_ID);
		if (!empty($type)) {
			$srchcol = array('itli_materialtypeid' => $type);
		} else {
			$srchcol = false;
		}
		// print_r($srchcol)

		$data = $this->item_mdl->get_item_list_stock_requisition($srchcol, $storeid);
		// echo $this->db->last_query();
		// die();
		// echo "<pre>";  print_r($data); die();
		// echo $this->db->last_query();
		// die();

		$i = 0;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"] > 0 ? $data["totalfilteredrecs"] : $data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

		unset($data["totalfilteredrecs"]);
		unset($data["totalrecs"]);

		foreach ($data as $row) {

			$stock_qty = !empty($row->issue_qty) ? $row->issue_qty : '0.00';
			$reorderlevel = $row->itli_reorderlevel;
			if ($stock_qty == '0.00') {

				$statusClass = 'danger';
			} else if ($stock_qty > 0 && $stock_qty < $reorderlevel) {
				$statusClass = 'warning';
			} else {
				$statusClass = 'success';
			}

			// if($this->session->userdata(USER_GROUPCODE) <> 'SA'):
			// 	$array[$i]["statusClass"] = '';
			// else:
			// 	$array[$i]["statusClass"] = $statusClass;
			// endif;

			// if(!empty($stock_qty)):
			$array[$i]["rowno"] = $rowno;
			$array[$i]["itemlistid"] = $row->itli_itemlistid;
			$array[$i]["itemcode"] = $row->itli_itemcode;
			$array[$i]["itemname"] = $row->itli_itemname;
			$array[$i]["itemnamenp"] = $row->itli_itemnamenp;
			if (ITEM_DISPLAY_TYPE == 'NP') {
				$array[$i]["itemname_display"] = !empty($row->itli_itemnamenp) ? $row->itli_itemnamenp : $row->itli_itemname;
			} else {
				$array[$i]["itemname_display"] = !empty($row->itli_itemname) ? $row->itli_itemname : '';
			}

			$array[$i]["purchaserate"] = $row->itli_purchaserate;
			$array[$i]["salesrate"] = $row->itli_salesrate;
			$array[$i]["issue_qty"] = sprintf('%g', $stock_qty);
			$array[$i]["category"] = $row->eqca_category;

			if (ORGANIZATION_NAME == 'KUKL' || ORGANIZATION_NAME == 'NPHL') {
				if (in_array($this->usergroup, $this->stock_view_group)):
					$array[$i]["statusClass"] = $statusClass;
					$array[$i]["purchaserate"] = $row->itli_purchaserate;
					$array[$i]["salesrate"] = $row->itli_salesrate;
					$array[$i]["issue_qty"] = $stock_qty;
				else:
					$array[$i]["statusClass"] = '';
					$array[$i]["purchaserate"] = '--';
					$array[$i]["salesrate"] = '--';
					$array[$i]["issue_qty"] = '--';
				endif;
			} else {
				$array[$i]["statusClass"] = $statusClass;
				$array[$i]["purchaserate"] = $row->itli_purchaserate;
				$array[$i]["salesrate"] = $row->itli_salesrate;
				$array[$i]["issue_qty"] = sprintf('%g', $stock_qty);
			}

			$array[$i]["unitname"] = $row->unit_unitname;
			$array[$i]["unitid"] = $row->unit_unitid;
			$array[$i]["is_perm"] = !empty($row->teit_ismove) ? $row->teit_ismove : '';
			$i++;
			// endif;
		}
		echo json_encode(array("recordsFiltered" => $filtereddata, "recordsTotal" => $totalrecs, "data" => $array));
	}

	public function list_item_with_stock_for_transfer_location() {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			// echo $storeid;
			// die();

			$this->data = array();
			$this->data['rowno'] = $this->input->post('id');
			$this->data['locationid'] = $this->input->post('storeid');
			// if(MODULES_VIEW=='N')
			// 	{
			// 	$this->general->permission_denial_message();
			// 	exit;
			// 	}
			$template = '';
			$template = $this->load->view('item/v_item_list_popup_stock_transfer_location', $this->data, true);
			print_r(json_encode(array('status' => 'success', 'message' => 'Successfully Selected!!', 'template' => $template, 'tempform' => $template)));
			exit;
		} else {
			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		}
	}

	public function get_item_list_stock_transfer_location($rowno = false, $locationid = false) {
		// echo 'loc'.$locationid;
		// die();
		//print_r($rowno); print_r($locationid);die;
		// $stid ="";
		// if(!empty($locationid)){
		// 	$stid = array('trma_todepartmentid'=>$locationid);
		// }
		$useraccess = $this->session->userdata(USER_ACCESS_TYPE);
		$orgid = $this->session->userdata(ORG_ID);
		$data = $this->item_mdl->get_item_list_stock_transfer_location(false, $locationid);
		// echo "<pre>";  print_r($data); die();

		$i = 0;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"] > 0 ? $data["totalfilteredrecs"] : $data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

		unset($data["totalfilteredrecs"]);
		unset($data["totalrecs"]);

		foreach ($data as $row) {
			if (ITEM_DISPLAY_TYPE == 'NP') {
				$array[$i]["itemname_display"] = !empty($row->itli_itemnamenp) ? $row->itli_itemnamenp : $row->itli_itemname;
			} else {
				$array[$i]["itemname_display"] = !empty($row->itli_itemname) ? $row->itli_itemname : '';
			}

			// if(ITEM_DISPLAY_TYPE=='NP'){
			//         	$req_itemname = !empty($row->itli_itemnamenp)?$row->itli_itemnamenp:$row->itli_itemname;
			//         }else{
			//             $req_itemname = !empty($row->itli_itemname)?$row->itli_itemname:'';
			//         }

			$stock_qty = !empty($row->issue_qty) ? $row->issue_qty : '';
			// if($stock_qty > 0):
			$array[$i]["rowno"] = $rowno;
			$array[$i]["itemid"] = $row->itli_itemlistid;
			$array[$i]["itemcode"] = $row->itli_itemcode;
			$array[$i]["itemname"] = $row->itli_itemname;
			$array[$i]["itemnamenp"] = $row->itli_itemnamenp;
			$array[$i]["unitname"] = $row->unit_unitname;
			$array[$i]["issue_qty"] = !empty($row->issue_qty) ? $row->issue_qty : '';
			$array[$i]["purchaserate"] = $row->itli_purchaserate;
			$array[$i]["salesrate"] = $row->itli_salesrate;
			// $array[$i]["unitid"] = $row->unit_unitid;
			$i++;
			// endif;
		}
		echo json_encode(array("recordsFiltered" => $filtereddata, "recordsTotal" => $totalrecs, "data" => $array));
	}

	public function list_item_with_purchase_requisition() {
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
			$template = $this->load->view('item/v_item_list_popup_purchase_requisition', $this->data, true);
			print_r(json_encode(array('status' => 'success', 'message' => 'Successfully Selected!!', 'template' => $template, 'tempform' => $template)));
			exit;
		} else {
			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		}
	}

	public function get_item_list_purchase_requisition($rowno = false, $storeid = false) {
		//print_r($rowno); print_r($storeid);die;
		// $stid ="";
		// if(!empty($storeid)){
		// 	$stid = array('trma_todepartmentid'=>$storeid);
		// }
		$useraccess = $this->session->userdata(USER_ACCESS_TYPE);
		$orgid = $this->session->userdata(ORG_ID);
		$data = $this->item_mdl->get_item_list_purchase_requisition(false, $storeid);
		// echo "<pre>";  print_r($data); die();

		$i = 0;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"] > 0 ? $data["totalfilteredrecs"] : $data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

		unset($data["totalfilteredrecs"]);
		unset($data["totalrecs"]);

		foreach ($data as $row) {

			$array[$i]["rowno"] = $rowno;
			$array[$i]["itemlistid"] = $row->itli_itemlistid;
			$array[$i]["itemcode"] = $row->itli_itemcode;
			$array[$i]["itemname"] = $row->itli_itemname;
			$array[$i]["purchaserate"] = $row->itli_purchaserate;
			$array[$i]["stock_qty"] = !empty($row->stock_qty) ? $row->stock_qty : '';
			$array[$i]["unitname"] = $row->unit_unitname;
			$array[$i]["quotationmasterid"] = $row->qude_quotationmasterid;
			$array[$i]["quotationnumber"] = $row->quma_quotationnumber;
			// [quma_quotationnumber] => 5

			$i++;
		}
		echo json_encode(array("recordsFiltered" => $filtereddata, "recordsTotal" => $totalrecs, "data" => $array));
	}

	public function getcat_code() {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$item_catid = $this->input->post('item_catid');

			if (!empty($item_catid)) {
				$equ_cat_data = $this->general->get_tbl_data('eqca_code', 'eqca_equipmentcategory', array('eqca_equipmentcategoryid' => $item_catid));

				$eqcode = $equ_cat_data[0]->eqca_code;

				$itemcode = '';

				$this->db->select('it.itli_itemcode');
				$this->db->from('itli_itemslist it');
				$this->db->where("itli_catid = $item_catid");
				$this->db->where("itli_itemcode like '$eqcode%'");
				$this->db->order_by("itli_itemcode DESC");
				$itemdata = $this->db->get()->row();

				// $itemdata = $this->item_mdl->get_all_itemlist(array('itli_catid' => $item_catid), 1, 0, false, false, 'itli_itemcode DESC');

				// echo "<pre>";
				// print_r($itemdata);
				// die();
				if ($itemdata) {
					$itemcode = $itemdata->itli_itemcode ?? '';
					// echo $itmcode;
					// die();

					// $codearr = $this->general->stringseperator($itemcode, 'number');
					$number = str_replace($eqcode,'',$itemcode);
					$codearr = (int) filter_var($number, FILTER_SANITIZE_NUMBER_INT); 
					// $itmcode=$eqcode.($codearr+1);
					// echo $codearr;
					// die();
					if (!empty($codearr)) {
						$codearr = $codearr;
					} else {
						$codearr = 0;
					}
					$item_string = str_pad($codearr + 1, ITEM_CODE_NO_LENGTH, 0, STR_PAD_LEFT);
					// die();
					$itmcode = $eqcode . $item_string;
				} else {
					$itmcode = $eqcode . str_pad(0 + 1, ITEM_CODE_NO_LENGTH, 0, STR_PAD_LEFT);
				}
				if (ORGANIZATION_NAME == 'KU') {
					$item_result = $this->general->get_tbl_data('itli_itemcode', 'itli_itemslist', false, 'itli_itemcode', 'DESC', '1');
					// echo "<pre>";
					// print_r($item_result);
					// die();
					if (!empty($item_result)) {
						$itli_itemcode = ($item_result[0]->itli_itemcode) + 1;
						$item_string = str_pad($itli_itemcode, 3, 0, STR_PAD_LEFT);
						$itmcode = $item_string;
					} else {
						$itli_itemcode = 1;
						$item_string = str_pad($itli_itemcode, 3, 0, STR_PAD_LEFT);
						$itmcode = $item_string;
					}
				}
				echo json_encode($itmcode);
			} else {
				echo json_encode(array());
			}

		} else {
			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		}
	}

	public function generate_item_list_excel() {
		header("Content-Type: application/xls");
		header("Content-Disposition: attachment; filename=item_list_" . date('Y_m_d_H_i') . ".xls");
		header("Pragma: no-cache");
		header("Expires: 0");

		$data = $this->item_mdl->get_item_list();
		$this->data['searchResult'] = $this->item_mdl->get_item_list();

		$array = array();

		$this->data['iDisplayStart'] = !empty($_GET['iDisplayStart']) ? $_GET['iDisplayStart'] : 0;

		unset($this->data['searchResult']["totalfilteredrecs"]);
		unset($this->data['searchResult']["totalrecs"]);

		$response = $this->load->view('item/v_item_list_download', $this->data, true);

		echo $response;
	}

	public function item_entry($modal = false) {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$this->data['editurl'] = base_url() . 'stock_inventory/item/edit_item';
			$this->data['deleteurl'] = base_url() . 'stock_inventory/item/delete_item';
			$this->data['listurl'] = base_url() . 'stock_inventory/item/list_item';
			$this->data['material_type'] = $this->general->get_tbl_data('*', 'maty_materialtype');
			$this->data['subcategory'] = $this->general->get_tbl_data('*', 'eqca_equipmentcategory');
			$this->data['brand'] = $this->general->get_tbl_data('*', 'bran_brand');
			$this->data['unit'] = $this->general->get_tbl_data('*', 'unit_unit', array('unit_isactive' => 'Y'));
			$this->data['equipmenttype'] = $this->general->get_tbl_data('*', 'eqty_equipmenttype');
			//for item entry from popup
			$this->data['modal'] = $modal;
			$template = '';
			$template = $this->load->view('item/v_item_form', $this->data, true);
			print_r(json_encode(array('status' => 'success', 'message' => 'Successfully Selected!!', 'template' => $template, 'tempform' => $template)));
			exit;
		} else {
			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		}
	}

	public function get_category_by_materialid() {
		$material_typeid = $this->input->post('material_typeid');

		// $category_list = $this->general->get_tbl_data('*','eqca_equipmentcategory',array('eqca_equiptypeid'=>$material_typeid));
		$subcategory = $this->item_mdl->get_category_by_materialid($material_typeid);

		// echo (json_encode(array('datas'=>$category_list,'status'=>'success')));

		$tempform = '';
		$tempform .= '<select name="itli_catid" class="form-control select2" id="item_catid" >';
		$tempform .= '<option value="">---select---</option>';
		if ($subcategory):

			foreach ($subcategory as $km => $cat):
				$tempform .= '<option value="' . $cat->eqca_equipmentcategoryid . '">' . $cat->eqca_category . '</option>';

			endforeach;
		endif;
		$tempform .= '</select>';
		echo json_encode($tempform);

		exit;
	}

	public function get_item_by_materialid() {
		$material_typeid = $this->input->post('material_typeid');

		// $category_list = $this->general->get_tbl_data('*','eqca_equipmentcategory',array('eqca_equiptypeid'=>$material_typeid));
		$item_list = $this->item_mdl->get_itemlist_by_materialid($material_typeid);

		// echo (json_encode(array('datas'=>$category_list,'status'=>'success')));
		// echo "<pre>";
		// print_r($item_list);
		// die();

		$tempform = '';
		$tempform .= '<select name="itli_itemlistid" class="form-control select2" id="item_catid" >';
		$tempform .= '<option value="">---select---</option>';
		if ($item_list):
			foreach ($item_list as $ki => $itm):
				if (ITEM_DISPLAY_TYPE == 'NP') {
					$item_name = !empty($itm->itli_itemnamenp) ? $itm->itli_itemnamenp : $itm->itli_itemname;
				} else {
					$item_name = $itm->itli_itemname;
				}

				$tempform .= '<option value="' . $itm->itli_itemlistid . '">' . $itm->itli_itemcode . ' | ' . $item_name . '</option>';

			endforeach;
		endif;
		$tempform .= '</select>';
		echo json_encode($tempform);

		exit;
	}

	public function get_item_by_cat() {
		$catid = $this->input->post('catid');
		if (!empty($catid)) {
			$itemdata = $this->general->get_tbl_data('*', 'itli_itemslist', array('itli_catid' => $catid));
			// echo "<pre>";
			// print_r($itemdata);
			// die();
			$temp = '<option value="">--Select--</option>';
			if (!empty($itemdata)) {
				foreach ($itemdata as $kid => $idat) {
					$temp .= '<option value="' . $idat->itli_itemlistid . '">' . $idat->itli_itemcode . ' ' . $idat->itli_itemname . '</option>';
				}
			}
			echo json_encode($temp);

		}
	}

	public function get_item_name_autocomplete() {
		// $input = $this->input->post('')
		$this->db->select('itli_itemname');
		$this->db->from('itli_itemlist');
		$data = $this->db->get();

		if ($data) {
			echo json_encode($data);
		}

	}

	public function get_item_code() {
		$itemid = $this->input->post('itemid');
		$catid = $this->input->post('item_catid');
		if (!empty($itemid)) {
			$itemdata = $this->general->get_tbl_data('itli_itemcode', 'itli_itemslist', array('itli_itemlistid' => $itemid));
			if (!empty($itemdata)) {
				$itemcode = !empty($itemdata[0]->itli_itemcode) ? $itemdata[0]->itli_itemcode : '';
				// echo $itemcode;
				// die();
				$this->db->select('itli_itemcode');
				$this->db->from('itli_itemslist');
				$this->db->where("itli_itemcode LIKE '" . $itemcode . "%' ");
				$this->db->order_by('itli_itemlistid DESC,itli_itemcode DESC');
				$rslt = $this->db->get()->row();
				// echo "<pre>";
				// print_r($rslt);
				// die();
				if (!empty($rslt)) {
					$master_item_code = $rslt->itli_itemcode;
					if ($master_item_code == $itemcode) {
						$str_code = str_pad(1, 4, 0, STR_PAD_LEFT);
						$stringcode = $itemcode . $str_code;
					} else {
						// echo $master_item_code;
						// echo "<br>";
						$prev_code = str_replace($itemcode, ' ', $master_item_code);
						// echo $prev_code;
						// die();
						$stringcode = str_pad($prev_code + 1, 4, 0, STR_PAD_LEFT);
						$stringcode = $itemcode . $stringcode;
					}
					// str_replace($prefix_no.$prefix,' ',$dbinvoiceno);
					// str_pad($invoiceno + 1, $length, 0, STR_PAD_LEFT);

					echo json_encode($stringcode);
				}

			}
		} else {
			// echo "sad";
			$this->getcat_code();
		}
	}

	public function exists_item_code()
	{
		$itli_itemcode = $this->input->post('itli_itemcode');
		$id = $this->input->post('id');
		$depcode = $this->item_mdl->check_exit_itemcode_for_other($itli_itemcode, $id);
		// print_r($depcode);
		// die();
		// echo $this->db->last_query();
		// die();
		if ($depcode) {
			$this->form_validation->set_message('exists_item_code', 'Already Exist Itemcode!!');
			return false;
		} else {
			return true;
		}
	}

	public function exists_item_name()
	{
		$itli_itemname = $this->input->post('itli_itemname');
		$id = $this->input->post('id');
		$depname = $this->item_mdl->check_exit_itemname_for_other($itli_itemname, $id);
		if ($depname) {

			$this->form_validation->set_message('exists_item_name', 'Already Exist Item Name!!');
			return false;
		} else {
			return true;
		}
	}

public function duplicate_item_replace(){
		try {
				$this->db->trans_begin();

		$this->db->select('DISTINCT(itli_itemname),MIN(itli_itemlistid) as minval,GROUP_CONCAT(itli_itemlistid ORDER BY itli_itemlistid ASC ) as group_item_id');
		$this->db->from('itli_itemslist as il');
		$this->db->group_by('itli_itemname');
		$this->db->having('count("*")>1');
		$result=$this->db->get()->result();
		// echo $this->db->last_query();
		// echo "<pre>";
		// print_r($result);
		// die();

		if(!empty($result)){
			foreach($result as $rit){
				$min_item_list=$rit->minval;
				$group_item_id=$rit->group_item_id;
				if(!empty($group_item_id)){
					$group_item_arr=explode(',',$group_item_id);

					$arr1=array($min_item_list);
					$arr2=$group_item_arr;
					// echo $min_item_list.'=> '.$group_item_id;
					// echo "<br>";
					$array_update = array_diff($arr2,$arr1);
					// echo "<pre>";
					// print_r($result);
					// echo "------";
					// echo "<br>";
					$itemcode='';
					$itmcode_result=$this->db->select('itli_itemcode')->from('itli_itemslist')->where('itli_itemlistid',$min_item_list)->get()->row();
					if(!empty($itmcode_result)){
						$itemcode=!empty($itmcode_result->itli_itemcode)?$itmcode_result->itli_itemcode:'';
					}
					// echo "<br>";
					// echo $itemcode;

					// Start Update Transaction Detail ID
					$this->db->set('trde_itemsid',$min_item_list);
					$this->db->where_in('trde_itemsid', $group_item_arr);
					$update_trde=$this->db->update('trde_transactiondetail');
					//End Update Transaction Detail ID

					// Start Update Demand Detail ID
					$this->db->set(array('rede_itemsid'=>$min_item_list,'rede_code'=>$itemcode));
					$this->db->where_in('rede_itemsid', $group_item_arr);
					$update_trde=$this->db->update('rede_reqdetail');
					//End Update Demand Detail ID

					// Start Update Purchase  Detail ID
					$this->db->set(array('purd_itemsid'=>$min_item_list,'purd_budcode'=>$itemcode));
					$this->db->where_in('purd_itemsid', $group_item_arr);
					$update_trde=$this->db->update('purd_purchasereqdetail');
					//End Update Purchase Detail ID

					// Start Update Purchase  Order Detail ID
					$this->db->set('pude_itemsid',$min_item_list);
					$this->db->where_in('pude_itemsid', $group_item_arr);
					$update_trde=$this->db->update('pude_purchaseorderdetail');
					//End Update Purchase Order Detail ID

					// Start Update Sales  Detail ID
					$this->db->set('sade_itemsid',$min_item_list);
					$this->db->where_in('sade_itemsid', $group_item_arr);
					$update_trde=$this->db->update('sade_saledetail');
					//End Update Sales Detail ID
					
					// Start Update Sales  Detail ID
					$this->db->set('rede_itemsid',$min_item_list);
					$this->db->where_in('rede_itemsid', $group_item_arr);
					$update_trde=$this->db->update('rede_returndetail');
					//End Update Sales Detail ID
					
				}

			}
		}

				$this->db->trans_complete();
					if ($this->db->trans_status() === FALSE) {
						$this->db->trans_rollback();
					} else {

						$this->db->trans_commit();
						$this->duplicate_item_delete();
					}

		}catch (Exception $e) {

			$this->db->trans_rollback();
				print_r(json_encode(array('status' => 'error', 'message' => $e->getMessage())));
		}

	}

public function duplicate_item_delete(){
	$this->db->select('DISTINCT(itli_itemname),MIN(itli_itemlistid) as minval,GROUP_CONCAT(itli_itemlistid ORDER BY itli_itemlistid ASC ) as group_item_id');
		$this->db->from('itli_itemslist as il');
		$this->db->group_by('itli_itemname');
		$this->db->having('count("*")>1');
		$result=$this->db->get()->result();
		// echo $this->db->last_query();
		// echo "<pre>";
		// print_r($result);
		// die();
		if(!empty($result)){
			foreach($result as $rit){
				$min_item_list=$rit->minval;
				$group_item_id=$rit->group_item_id;
				if(!empty($group_item_id)){
					$group_item_arr=explode(',',$group_item_id);
					$arr1=array($min_item_list);
					$arr2=$group_item_arr;
					
					$array_update = array_diff($arr2,$arr1);
					if(!empty($array_update)){
						$this->db->where_in('itli_itemlistid',$array_update);
						$this->db->delete('itli_itemslist');
					}
				}
			}
		}
}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */