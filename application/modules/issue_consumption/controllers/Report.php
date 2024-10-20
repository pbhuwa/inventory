<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Report extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->Model('report_issue_mdl');
		$this->username = $this->session->userdata(USER_NAME);
		$this->deptid = $this->session->userdata(USER_DEPT);
		$this->userid = $this->session->userdata(USER_ID);
		$this->locationid = $this->session->userdata(LOCATION_ID);
		if (defined('LOCATION_CODE')) :
			$this->locationcode = $this->session->userdata(LOCATION_CODE);
		endif;
		$this->location_ismain = $this->session->userdata(ISMAIN_LOCATION);
		$this->orgid = $this->session->userdata(ORG_ID);
		$this->usergroup = $this->session->userdata(USER_GROUPCODE);
		$this->userdept = $this->session->userdata(USER_DEPT);
		$this->mattypeid = $this->session->userdata(USER_MAT_TYPEID);
		$this->show_location_group = array('SA', 'SK', 'SI');
	}
	public function index()
	{
		$this->data['materialstypecategory'] = $this->general->get_tbl_data('*', 'maty_materialtype', false, 'maty_materialtypeid', 'DESC');
		$this->data['items'] = $this->general->get_tbl_data('*', 'itli_itemslist', false, 'itli_itemlistid', 'DESC');
		$this->data['store'] = $this->general->get_tbl_data('*', 'store', false, 'st_store_id', 'DESC');
		$this->data['equipment'] = $this->general->get_tbl_data('*', 'eqca_equipmentcategory', false, 'eqca_equipmentcategoryid', 'DESC');
		$this->data['fiscal_year'] = $this->general->getFiscalYear();
		$this->data['store_type'] = $this->general->get_tbl_data('*', 'eqty_equipmenttype');


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
		$this->data['current_tab'] = 'category_wise';
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('report/v_report', $this->data);
	}
	public function item_wise_display()
	{
		$this->data['materialstypecategory'] = $this->general->get_tbl_data('*', 'maty_materialtype', false, 'maty_materialtypeid', 'DESC');
		$this->data['items'] = $this->general->get_tbl_data('*', 'itli_itemslist', false, 'itli_itemlistid', 'DESC');
		$this->data['store'] = $this->general->get_tbl_data('*', 'eqty_equipmenttype');
		$this->data['equipment'] = $this->general->get_tbl_data('*', 'eqca_equipmentcategory', false, 'eqca_equipmentcategoryid', 'DESC');
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
		$this->data['current_tab'] = 'item_wise';
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('report/v_report', $this->data);
	}

	public function issue_book_display()
	{
		$this->data['materialstypecategory'] = $this->general->get_tbl_data('*', 'maty_materialtype', false, 'maty_materialtypeid', 'DESC');
		$this->data['items'] = $this->general->get_tbl_data('*', 'itli_itemslist', false, 'itli_itemlistid', 'DESC');
		$this->data['store'] = $this->general->get_tbl_data('*', 'eqty_equipmenttype');
		$this->data['equipment'] = $this->general->get_tbl_data('*', 'eqca_equipmentcategory', false, 'eqca_equipmentcategoryid', 'DESC');

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
		$this->data['current_tab'] = 'issue_book';
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('report/v_report', $this->data);
	}

	public function issue_summary_display()
	{
		$this->data['materialstypecategory'] = $this->general->get_tbl_data('*', 'maty_materialtype', false, 'maty_materialtypeid', 'DESC');
		$this->data['items'] = $this->general->get_tbl_data('*', 'itli_itemslist', false, 'itli_itemlistid', 'DESC');
		$this->data['store'] = $this->general->get_tbl_data('*', 'eqty_equipmenttype');
		$this->data['equipment'] = $this->general->get_tbl_data('*', 'eqca_equipmentcategory', false, 'eqca_equipmentcategoryid', 'DESC');
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
		$this->data['current_tab'] = 'issue_summary';
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('report/v_report', $this->data);
	}

	public function issue_details_display()
	{
		$this->data['materialstypecategory'] = $this->general->get_tbl_data('*', 'maty_materialtype', false, 'maty_materialtypeid', 'DESC');
		$this->data['items'] = $this->general->get_tbl_data('*', 'itli_itemslist', false, 'itli_itemlistid', 'DESC');
		$this->data['store'] = $this->general->get_tbl_data('*', 'eqty_equipmenttype');

		if ($this->location_ismain == 'Y') {
			$user_cond = false;
		} else {
			$user_cond = array('usma_locationid' => $this->locationid);
		}
		$this->data['users'] = $this->general->get_tbl_data('*', 'usma_usermain', $user_cond, 'usma_userid', 'DESC');

		$this->data['equipment'] = $this->general->get_tbl_data('*', 'eqca_equipmentcategory', false, 'eqca_equipmentcategoryid', 'DESC');
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
		$this->data['current_tab'] = 'issue_details';
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('report/v_report', $this->data);
	}


	public function search_categorywise_issue()
	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if (MODULES_VIEW == 'N') {
				$array = array();

				print_r(json_encode(array('status' => 'error', 'message' => $this->general->permission_denial_message())));
				exit;
			}

			$html = $this->search_categorywise_issue_common();
			//echo $this->db->last_query(); die;
			if ($html) {
				$template = $html;
			}
			print_r(json_encode(array('status' => 'success', 'template' => $template, 'message' => 'Successfully Selected')));
			exit;
		} else {
			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		}
	}


	public function search_categorywise_issue_excel()
	{
		header("Content-Type: application/xls");
		header("Content-Disposition: attachment; filename=categorywise_issue_excel_" . date('Y_m_d_H_i') . ".xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		$response = $this->search_categorywise_issue_common();
		if ($response) {
			echo $response;
		}
		return false;
	}
	public function search_categorywise_issue_common()
	{
		$this->data['excel_url'] = "issue_consumption/report/search_categorywise_issue_excel";
		$this->data['pdf_url'] = "issue_consumption/report/search_categorywise_issue_pdf";
		$this->data['report_title'] = $this->lang->line('category_wise_issue');
		$category = $this->input->post('maty_materialtypeid') ? $this->input->post('maty_materialtypeid') : $this->input->post('materialtype');
		if ($category) :
			//print_r($category);die;
			$this->data['materialtype'] = $this->general->get_tbl_data('maty_material,maty_materialtypeid', 'maty_materialtype', array('maty_materialtypeid' => $category), 'maty_materialtypeid', 'DESC');
		//echo"<pre>";print_r($this->data['materialtype']);die;
		else :
			$this->data['materialtype'] = 'All';
		endif;
		$locationid = $this->input->post('locationid');
		if ($locationid) :
			$this->data['location'] = $this->general->get_tbl_data('loca_locationid,loca_name', 'loca_location', array('loca_locationid' => $locationid));
		else :
			$this->data['location'] = 'All';
		endif;
		$fyear = $this->input->post('fyear');
		$srchcol = "";
		if ($category) {
			$srchcol = 'WHERE maty_materialtypeid = ' . '"' . $category . '"';
			$groupby = 'itli_itemcode, itli_itemname, maty_material, maty_materialtypeid,unit_unitname';
		} else {
			$groupby = 'maty_material, maty_materialtypeid';
		}
		$this->data['fromdate'] = $this->input->post('fromdate');
		$this->data['todate'] = $this->input->post('todate');
		$this->data['categorieswise'] = $this->report_issue_mdl->category_wise_report($srchcol, $groupby);
		//echo"<pre>"; print_r($this->input->post());die;
		//echo"<pre>"; print_r($this->data['categorieswise']);die;
		//pdf generation
		if ($category) {
			if ($this->data['categorieswise']) {
				$html = $this->load->view('report/v_categories_wise_report', $this->data, true);
			} else {
				$html = '<span class="col-sm-12 alert alert-danger text-center">No Record Found!!!</span>';
			}
		} else {
			if ($this->data['categorieswise']) {
				$html = $this->load->view('report/v_all_categories_wise_report', $this->data, true);
			} else {
				$html = '<span class="col-sm-12 alert alert-danger text-center">No Record Found!!!</span>';
			}
		}
		return $html;
	}
	public function search_categorywise_issue_pdf()
	{
		 $page_orientation = !empty($_GET['page_orientation']) ? $_GET['page_orientation']  : '';
		if ($page_orientation == 'L') {
			$page_size = 'A4-L';
		} else {
			$page_size = 'A4';
		}
		$html = $this->search_categorywise_issue_common();
		//echo $this->db->last_query(); die;
		$filename = 'categories_wise_issue_' . date('Y_m_d_H_i_s') . '_.pdf';
		$pdfsize = 'A4'; //A4-L for landscape //if save and download with default filename, send $filename as parameter
		$this->general->generate_pdf($html, false, $pdfsize,$page_size);
	}
	/* 
		Category Wise Issue report  pdf excel End 
		Sub Category Wise Issue  pdf excel Start 
	*/
	public function sub_categorywise_display()
	{
		$this->data['materialstypecategory'] = $this->general->get_tbl_data('*', 'maty_materialtype', false, 'maty_materialtypeid', 'DESC');
		$this->data['items'] = $this->general->get_tbl_data('*', 'itli_itemslist', false, 'itli_itemlistid', 'DESC');

		$this->data['equipment'] = $this->general->get_tbl_data('*', 'eqca_equipmentcategory', false, 'eqca_equipmentcategoryid', 'DESC');
		$this->data['fiscal_year'] = $this->general->getFiscalYear();
		$this->data['store_type'] = $this->general->get_tbl_data('*', 'eqty_equipmenttype');
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
		$this->data['current_tab'] = 'sub_category_wise';
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('report/v_report', $this->data);
	}

	public function search_sub_categorywise_issue()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if (MODULES_VIEW == 'N') {
				print_r(json_encode(array('status' => 'error', 'message' => $this->general->permission_denial_message())));
				exit;
			}


			$html = $this->search_sub_categorywise_issue_common();
			// echo $this->db->last_query(); die;
			if ($html) {
				$template = $html;
			}
			print_r(json_encode(array('status' => 'success', 'template' => $template, 'message' => 'Successfully Selected')));
			exit;
		} else {
			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		}
	}
	public function search_sub_categorywise_issue_excel()
	{
		header("Content-Type: application/xls");
		header("Content-Disposition: attachment; filename=sub_categorywise_issue_excel_" . date('Y_m_d_H_i') . ".xls");
		header("Pragma: no-cache");
		header("Expires: 0");

		$response = $this->search_sub_categorywise_issue_common();
		if ($response) {
			echo $response;
		}
		return false;
	}
	public function search_sub_categorywise_issue_pdf()
	{
		 $page_orientation = !empty($_GET['page_orientation']) ? $_GET['page_orientation']  : '';
		if ($page_orientation == 'L') {
			$page_size = 'A4-L';
		} else {
			$page_size = 'A4';
		}

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$html = $this->search_sub_categorywise_issue_common();
			//echo $this->db->last_query(); die;
			$html = $this->load->view('report/v_sub_categories_wise_report', $this->data, true);
			$filename = 'sub_categories_wise_issue_' . date('Y_m_d_H_i_s') . '_.pdf';
			$pdfsize = 'A4'; //A4-L for landscape
			//if save and download with default filename, send $filename as parameter
			$this->general->generate_pdf($html, false, $pdfsize,$page_size);
			exit();
		} else {
			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		}
	}
	public function search_sub_categorywise_issue_common()
	{
		$this->data['excel_url'] = "issue_consumption/report/search_sub_categorywise_issue_excel";
		$this->data['pdf_url'] = "issue_consumption/report/search_sub_categorywise_issue_pdf";
		$this->data['report_title'] = $this->lang->line('sub_category_wise_issue');


		$category = $this->input->post('catid');
		$locationid = $this->input->post('locationid');
		$store_id = $this->input->post('store_id');
		$fyear = $this->input->post('fyear');
		$srchcol = "";
		$cond = "";
		$cond1 = "";

		if ($category) {
			$srchcol = 'AND ec.eqca_equipmentcategoryid = ' . '"' . $category . '"';
			$groupby = 'itli_itemname';
			$this->data['eq_category'] = $this->general->get_tbl_data('eqca_equipmentcategoryid, eqca_category', 'eqca_equipmentcategory', array('eqca_equipmentcategoryid' => $category), 'eqca_equipmentcategoryid', 'DESC');
		} else {
			$groupby = 'eqca_category, eqca_equipmentcategoryid';
			$this->data['eq_category'] = 'All';
		}

		if ($store_id) :
			$this->data['store_type'] = $this->general->get_tbl_data('eqty_equipmenttype,eqty_equipmenttypeid', 'eqty_equipmenttype', array('eqty_equipmenttypeid' => $store_id));
		else :
			$this->data['store_type'] = 'All';
		endif;

		if ($locationid) :
			$this->data['location'] = $this->general->get_tbl_data('loca_locationid,loca_name', 'loca_location', array('loca_locationid' => $locationid));
		else :
			$this->data['location'] = 'All';
		endif;

		$this->data['category'] = $category;
		$this->data['fromdate'] = $this->input->post('fromdate');
		$this->data['todate'] = $this->input->post('todate');

		$this->data['categorieswise'] = $this->report_issue_mdl->sub_category_wise_report($srchcol, $groupby);
		$html = ''; // echo"<pre>"; print_r($this->data['categorieswise']);die;
		if ($this->data['categorieswise']) {
			$html = $this->load->view('report/v_sub_categories_wise_report', $this->data, true);
		} else {
			$html = '<span class="col-sm-12 alert alert-danger text-center">No Record Found!!!</span>';
		}
		return $html;
	}
	/* 
		SubCategory Wise Issue report  pdf excel End 
		
	*/


	/* Item wise issue start */
	public function search_result()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$acategory = $this->input->post('acategory');
			$allcategory = $this->input->post('allcategory');
			$category = $this->input->post('maty_materialtypeid');

			//echo"<pre>";print_r($equid);die;
			$srchcol = "";
			if ($acategory) {
				$srchcol = array('bmin_equipmentkey' => $acategory);
			}
			if ($allcategory) {
				$srchcol = array('bmin_equipmentkey' => $allcategory);
			}
			if ($category) {
				$srchcol = array('maty_materialtypeid' => $category);
			}
			$this->data['fromdate'] = $this->input->post('fromdate');
			$this->data['todate'] = $this->input->post('todate');

			$this->data['issue_report'] = $this->report_issue_mdl->get_category_wise_report($srchcol);
			$template = '';
			// echo"<pre>"; print_r($this->data['pm_report']);die;

			if ($this->data['issue_report']) {
				$template = $this->load->view('report/v_pmgeneated_report', $this->data, true);
			} else {
				$template = '<span class="col-sm-12 alert alert-danger text-center">No Record Found!!!</span>';
			}
			// echo $temp; die();
			print_r(json_encode(array('status' => 'success', 'template' => $template, 'message' => 'Successfully Selected')));
			exit;
		} else {
			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		}
	}
	public function itemwise_result()
	{
		// echo MODULES_VIEW;
		// die();
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			//
			if (MODULES_VIEW == 'N') {

				print_r(json_encode(array('status' => 'error', 'message' => $this->general->permission_denial_message())));
				exit;
			}

			$html = $this->search_itemwise_issue_common();
			//echo $this->db->last_query(); die;
			if ($html) {
				$template = $html;
			} else {
				$template = '';
			}
			print_r(json_encode(array('status' => 'success', 'template' => $template, 'message' => 'Successfully Selected')));
			exit;
		} else {
			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		}
		/*		//report_data
	      	$aitem = $this->input->post('aitem');
	      	$allitem = $this->input->post('allitem');
	      	$itmlist = $this->input->post('itli_itemlistid');
	      	$allstore = $this->input->post('allstore');
	      	$st_store_id = $this->input->post('st_store_id');
	        $issuefrequent = $this->input->post('issueitem');

	      	
	      	$this->data['store'] = $st_store_id;
	      	$this->data['item'] = $itmlist;
	      	$this->data['issuefrequent'] = $issuefrequent;
	      	$this->data['fromdate'] = $this->input->post('fromdate');
        	$this->data['todate'] = $this->input->post('todate');
        	
        	$this->data['item_report']=$this->report_issue_mdl->get_item_wise_report();
      	*/
		/*		//report_functions
	      	$template='';
	       	
		    if($this->data['item_report'])
		    {
		    	$template=$this->load->view('report/v_items_report',$this->data,true);
		    }
		    else
		    {
		        $template='<span class="col-sm-12 alert alert-danger text-center">No Record Found!!!</span>';
		    }
	        
	        print_r(json_encode(array('status'=>'success','template'=>$template,'message'=>'Successfully Selected')));
	        exit;
	    		}
	    		else
	    		{
        			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        			exit;
        		}
        */
	}
	public function search_itemwise_issue_common()
	{
		$this->data['excel_url'] = "issue_consumption/report/itemwise_result_excel";
		$this->data['pdf_url'] = "issue_consumption/report/itemwise_result_pdf";
		$this->data['report_title'] = $this->lang->line('item_wise_issue');


		$aitem = $this->input->post('aitem');
		$allitem = $this->input->post('allitem');
		//$itmlist = $this->input->post('itli_itemlistid');
		$allstore = $this->input->post('allstore');
		$store_id = $this->input->post('store_id');
		$issuefrequent = $this->input->post('issueitem') ? $this->input->post('issueitem') : $this->input->post('is_summary');
		//$issuefrequent =$this->input->post('is_summary');
		$itemid = $this->input->post('itemid');

		if ($itemid) {
			$this->data['item'] = $itemid;
		} else {
			$this->data['item'] = 'All';
		}
		$this->data['item'] = $itemid;
		$this->data['issuefrequent'] = $issuefrequent;
		$this->data['fromdate'] = $this->input->post('fromdate');
		$this->data['todate'] = $this->input->post('todate');

		$this->data['item_distinct'] = $this->report_issue_mdl->get_itemwise_detail_issue_report(false, false, false, false, false, 'distinct');

		// echo "<pre>";
		// print_r($this->data['item_distinct']);
		// die();


		if ($store_id) :
			$this->data['store_type'] = $this->general->get_tbl_data('eqty_equipmenttype,eqty_equipmenttypeid', 'eqty_equipmenttype', array('eqty_equipmenttypeid' => $store_id));
		else :
			$this->data['store_type'] = 'All';
		endif;

		$locationid = $this->input->post('locationid');

		if ($locationid) :
			$this->data['location'] = $this->general->get_tbl_data('loca_locationid,loca_name', 'loca_location', array('loca_locationid' => $locationid));
		else :
			$this->data['location'] = 'All';
		endif;

		if ($this->data['item_distinct']) {
			$html = $this->load->view('report/v_itemswise_issue_report', $this->data, true);
		} else {
			$html = '<span class="col-sm-12 alert alert-danger text-center">No Record Found!!!</span>';
		}


		return $html;
	}
	public function itemwise_result_pdf()
	{
		 $page_orientation = !empty($_GET['page_orientation']) ? $_GET['page_orientation']  : '';
		if ($page_orientation == 'L') {
			$page_size = 'A4-L';
		} else {
			$page_size = 'A4';
		}
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$html = $this->search_itemwise_issue_common();

			$filename = 'item_wise_issue_' . date('Y_m_d_H_i_s') . '_.pdf';
			$pdfsize = 'A4-L'; //A4-L for landscape
			//if save and download with default filename, send $filename as parameter
			$this->general->generate_pdf($html, false, $pdfsize,$page_size);

			exit();
		} else {
			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		}
	}
	public function itemwise_result_excel()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			header("Content-Type: application/xls");
			header("Content-Disposition: attachment; filename=consumption_report_" . date('Y_m_d_H_i') . ".xls");
			header("Pragma: no-cache");
			header("Expires: 0");

			$response = $this->search_itemwise_issue_common();
			if ($response) {
				echo $response;
			}
			return false;
		} else {
			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		}
	}
	/* Item wise issue end */
	// public function issue_details_search()
	// {
	// 	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	//       	$issue_details = $this->input->post('issue_details');
	//       	$st_store_id = $this->input->post('st_store_id');
	//       	$locationid=$this->input->post('locationid');
	//       	//echo"<pre>";print_r($this->input->post());die;
	//       	$srchcol = "";$srchcol1='';

	//       	if($st_store_id)
	//       	{
	//       		$srchcol = array('s.sama_storeid'=>$st_store_id);
	//       		$srchcol1 = array('s.rema_type'=>$st_store_id);
	//       	}
	//       	$this->data['fromdate'] = $this->input->post('fromdate');
	//            $this->data['todate'] = $this->input->post('todate');
	//            $this->data['username'] = $this->input->post('username');

	//       	$this->data['return_report']=$this->report_issue_mdl->get_return_details_report($srchcol1);
	//       	$this->data['item_report']=$this->report_issue_mdl->get_issue_details_report($srchcol);
	//       	//print_r($this->data['return_report']);die;
	//       	$this->data['selectedstore'] = $st_store_id;
	//       	$this->data['selectedstore'] = $st_store_id;
	//       	$this->data['detailsissue'] = $issue_details;

	//       	if($st_store_id):
	//        		$this->data['store_type']=$this->general->get_tbl_data('*','eqty_equipmenttype',array('eqty_equipmenttypeid'=>$st_store_id));
	//        	else:
	//        		$this->data['store_type'] = '';
	//        	endif;


	//         $template='';
	//        	//echo"<pre>"; print_r($this->data['item_report']);die;
	// 	    if($this->data['item_report'] || $this->data['return_report'])
	// 	    {
	// 	    	$template=$this->load->view('report/v_issue_details_report',$this->data,true);
	// 	    }
	// 	    else
	// 	    {
	// 	        $template='<span class="col-sm-12 alert alert-danger text-center">No Record Found!!!</span>';
	// 	    }
	//         // echo $temp; die();
	//         print_r(json_encode(array('status'=>'success','template'=>$template,'message'=>'Successfully Selected')));
	//         exit;
	//     }else{
	//        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	//        	exit;
	//        }
	// }
	// public function issue_details_pdf()
	// {
	// 	$issue_details = $this->input->post('issue_details');
	//      	$st_store_id = $this->input->post('st_store_id');
	//      	$locationid=$this->input->post('locationid');
	//      	//echo"<pre>";print_r($this->input->post());die;
	//      	$srchcol = "";$srchcol1='';

	//      	if($st_store_id)
	//      	{
	//      		$srchcol = array('s.sama_storeid'=>$st_store_id);
	//      		$srchcol1 = array('s.rema_type'=>$st_store_id);
	//      	}
	//      	$this->data['fromdate'] = $this->input->post('fromdate');
	//        $this->data['todate'] = $this->input->post('todate');
	//        $this->data['username'] = $this->input->post('username');

	//      	$this->data['return_report']=$this->report_issue_mdl->get_return_details_report($srchcol1);
	//      	$this->data['item_report']=$this->report_issue_mdl->get_issue_details_report($srchcol);
	//      	//print_r($this->data['return_report']);die;
	//      	$this->data['selectedstore'] = $st_store_id;
	//      	$this->data['selectedstore'] = $st_store_id;
	//      	$this->data['detailsissue'] = $issue_details;

	//      	if($st_store_id):
	//    		$this->data['store_type']=$this->general->get_tbl_data('*','eqty_equipmenttype',array('eqty_equipmenttypeid'=>$st_store_id));
	//    	else:
	//    		$this->data['store_type'] = '';
	//    	endif;

	// 	//pdf generation
	//        $html = $this->load->view('report/v_issue_details_report', $this->data, true);   
	//        $filename = 'issue_details_'. date('Y_m_d_H_i_s') . '_.pdf'; 
	//        $pdfsize = 'A4'; //A4-L for landscape
	//        //if save and download with default filename, send $filename as parameter
	//        $this->general->generate_pdf($html,false,$pdfsize);

	//        exit();
	// }

	// public function issue_details_excel()
	// {
	// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// 	header("Content-Type: application/xls");    
	//        header("Content-Disposition: attachment; filename=itemwise_result_excel_".date('Y_m_d_H_i').".xls");  
	//        header("Pragma: no-cache"); 
	//        header("Expires: 0");

	//        $issue_details = $this->input->post('issue_details');
	//        $st_store_id = $this->input->post('st_store_id');
	//      	$locationid=$this->input->post('locationid');
	//      	//echo"<pre>";print_r($this->input->post());die;
	//      	$srchcol = "";$srchcol1='';

	//      	if($st_store_id)
	//      	{
	//      		$srchcol = array('s.sama_storeid'=>$st_store_id);
	//      		$srchcol1 = array('s.rema_type'=>$st_store_id);
	//      	}
	//      	$this->data['fromdate'] = $this->input->post('fromdate');
	//        $this->data['todate'] = $this->input->post('todate');
	//        $this->data['username'] = $this->input->post('username');

	//      	$this->data['return_report']=$this->report_issue_mdl->get_return_details_report($srchcol1);
	//      	$this->data['item_report']=$this->report_issue_mdl->get_issue_details_report($srchcol);
	//      	//print_r($this->data['return_report']);die;
	//      	$this->data['selectedstore'] = $st_store_id;
	//      	$this->data['selectedstore'] = $st_store_id;
	//      	$this->data['detailsissue'] = $issue_details;

	//      	if($st_store_id):
	//    		$this->data['store_type']=$this->general->get_tbl_data('*','eqty_equipmenttype',array('eqty_equipmenttypeid'=>$st_store_id));
	//    	else:
	//    		$this->data['store_type'] = '';
	//    	endif;

	//        $response = $this->load->view('report/v_issue_details_report', $this->data, true);

	//        echo $response;
	//     }else{
	//        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	//        	exit;
	//        }
	// }

	public function issue_details_search()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if (MODULES_VIEW == 'N') {

				print_r(json_encode(array('status' => 'error', 'message' => $this->general->permission_denial_message())));
				exit;
			}
			$html = $this->issue_detail_common();
			if ($html) {
				$template = $html;
			} else {
				$template = '<span class="col-sm-12 alert alert-danger text-center">No Record Found!!!</span>';
			}
			print_r(json_encode(array('status' => 'success', 'template' => $template, 'message' => 'Successfully Selected')));
			exit;
		} else {
			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		}
	}

	public function issue_detail_common()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$this->data['excel_url'] = "issue_consumption/report/issue_details_excel";
			$this->data['pdf_url'] = "issue_consumption/report/issue_details_pdf";
			$this->data['report_title'] = $this->lang->line('issue_details');
			$this->data['fromdate'] = $this->input->post('fromdate');
			$this->data['todate'] = $this->input->post('todate');
			$locationid = $this->input->post('locationid');
			$store_id = $this->input->post('store_id');
			$username = $this->input->post('username');
			$this->data['return_report'] = $this->report_issue_mdl->get_return_details_report();
			$this->data['item_report'] = $this->report_issue_mdl->get_issue_details_report();
			//echo $this->db->last_query();die();
			if ($store_id) :
				$this->data['store_type'] = $this->general->get_tbl_data('*', 'eqty_equipmenttype', array('eqty_equipmenttypeid' => $store_id));
			else :
				$this->data['store_type'] = 'All';
			endif;
			if ($username) :
				$this->data['username'] = $this->general->get_tbl_data('*', 'usma_usermain', array('usma_userid' => $username));
			else :
				$this->data['username'] = 'All';
			endif;

			if ($locationid) :
				$this->data['location'] = $this->general->get_tbl_data('*', 'loca_location', array('loca_locationid' => $locationid));
			else :
				$this->data['location'] = 'All';
			endif;

			if ($this->data['item_report'] || $this->data['return_report']) {
				$html = $this->load->view('report/v_issue_details_report', $this->data, true);
			} else {
				$html = '<span class="col-sm-12 alert alert-danger text-center">No Record Found!!!</span>';
			}
			return $html;
		} else {
			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		}
	}
	public function issue_details_pdf()
	{
		 $page_orientation = !empty($_GET['page_orientation']) ? $_GET['page_orientation']  : '';
		if ($page_orientation == 'L') {
			$page_size = 'A4-L';
		} else {
			$page_size = 'A4';
		}

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$html = $this->issue_detail_common();

			$filename = 'issue_detail' . date('Y_m_d_H_i_s') . '_.pdf';
			$pdfsize = 'A4'; //A4-L for landscape

			//if save and download with default filename, send $filename as parameter
			$this->general->generate_pdf($html, false, $pdfsize,$page_size);

			exit();
		} else {
			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		}
	}



	public function issue_details_excel()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			header("Content-Type: application/xls");
			header("Content-Disposition: attachment; filename=issue_detail_excel_" . date('Y_m_d_H_i') . ".xls");
			header("Pragma: no-cache");
			header("Expires: 0");

			$response = $this->issue_detail_common();
			if ($response) {
				echo $response;
			}
			return false;


			echo $response;
		}
	}
	public function issue_summary_search()
	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if (MODULES_VIEW == 'N') {

				print_r(json_encode(array('status' => 'error', 'message' => $this->general->permission_denial_message())));
				exit;
			}
			$template = $this->issue_summary_common();
			print_r(json_encode(array('status' => 'success', 'template' => $template, 'message' => 'Successfully Selected')));
			exit;
		} else {
			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		}
	}

	public function issue_summary_common()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$this->data['excel_url'] = "issue_consumption/report/issue_summary_excel";
			$this->data['pdf_url'] = "issue_consumption/report/issue_summary_pdf";
			$this->data['report_title'] = $this->lang->line('issue_summary');


			$this->data['fromdate'] = $this->input->post('fromdate');
			$this->data['todate'] = $this->input->post('todate');
			$locationid = $this->input->post('locationid');
			$store_id = $this->input->post('store_id');

			$this->data['summary_report'] = $this->report_issue_mdl->issue_summary_report();

			if ($store_id) :
				$this->data['store_type'] = $this->general->get_tbl_data('*', 'eqty_equipmenttype', array('eqty_equipmenttypeid' => $store_id));
			else :
				$this->data['store_type'] = 'All';
			endif;

			if ($locationid) :
				$this->data['location'] = $this->general->get_tbl_data('*', 'loca_location', array('loca_locationid' => $locationid));
			else :
				$this->data['location'] = 'All';
			endif;



			if ($this->data['summary_report']) {
				$html = $this->load->view('report/v_issue_summary_report', $this->data, true);
			} else {
				$html = '<span class="col-sm-12 alert alert-danger text-center">No Record Found!!!</span>';
			}

			return $html;
		} else {
			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		}
	}

	public function issue_summary_pdf()
	{
		$page_orientation = !empty($_GET['page_orientation']) ? $_GET['page_orientation']  : '';
		if ($page_orientation == 'L') {
			$page_size = 'A4-L';
		} else {
			$page_size = 'A4';
		}

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$html = $this->issue_summary_common();

			$filename = 'issue_summary' . date('Y_m_d_H_i_s') . '_.pdf';
			$pdfsize = 'A4'; //A4-L for landscape

			//if save and download with default filename, send $filename as parameter
			$this->general->generate_pdf($html, false, $pdfsize,$page_size);

			exit();
		} else {
			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		}
	}

	public function issue_summary_excel()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			header("Content-Type: application/xls");
			header("Content-Disposition: attachment; filename=issue_summary_excel_" . date('Y_m_d_H_i') . ".xls");
			header("Pragma: no-cache");
			header("Expires: 0");

			$response = $this->issue_summary_common();
			if ($response) {
				echo $response;
			}
			return false;


			echo $response;
		}
	}


	public function report_pdf()
	{
		 $page_orientation = !empty($_GET['page_orientation']) ? $_GET['page_orientation']  : '';
		if ($page_orientation == 'L') {
			$page_size = 'A4-L';
		} else {
			$page_size = 'A4';
		}


		$equid = $this->input->post('id');
		$itmlist = $this->input->post('store_id');
		$locationid = $this->input->post('locationid');
		$srchcol = "";
		if ($itmlist) {
			$srchcol = array('it.itli_itemlistid' => $itmlist);
		}
		$this->data['fromdate'] = $this->input->post('fromdate');
		$this->data['todate'] = $this->input->post('todate');

		$this->data['item'] = $itmlist;
		$this->data['item_report'] = $this->report_issue_mdl->get_item_wise_report($srchcol);

		//pdf generation
		$html = $this->load->view('report/v_items_report', $this->data, true);
		$filename = 'itemwise_report_' . date('Y_m_d_H_i_s') . '_.pdf';
		$pdfsize = 'A4'; //A4-L for landscape
		//if save and download with default filename, send $filename as parameter
		$this->general->generate_pdf($html, false, $pdfsize,$page_size);

		exit();
	}
	public function report_excel_itemwise()
	{
		header("Content-Type: application/xls");
		header("Content-Disposition: attachment; filename=itemwise_" . date('Y_m_d_H_i') . ".xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		$equid = $this->input->post('id');
		$itmlist = $this->input->post('store_id');
		$srchcol = "";

		if ($itmlist) {
			$srchcol = array('it.itli_itemlistid' => $itmlist);
		}
		$this->data['fromdate'] = $this->input->post('fromdate');
		$this->data['todate'] = $this->input->post('todate');

		$this->data['item'] = $itmlist;
		$data = $this->report_issue_mdl->get_item_wise_report($srchcol);
		$this->data['item_report'] = $this->report_issue_mdl->get_item_wise_report($srchcol);

		$response = $this->load->view('report/v_items_report', $this->data, true);


		echo $response;
	}

	public function issuebook_result()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if (MODULES_VIEW == 'N') {

				print_r(json_encode(array('status' => 'error', 'message' => $this->general->permission_denial_message())));
				exit;
			}

			$html = $this->issue_book_common();
			//echo $this->db->last_query(); die;
			if ($html) {
				$template = $html;
			} else {
				$template = '';
			}
			// echo $temp; die();
			print_r(json_encode(array('status' => 'success', 'template' => $template, 'message' => 'Successfully Selected')));
			exit;
		} else {
			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		}
	}
	public function issue_book_common()
	{

		$this->data['excel_url'] = "issue_consumption/report/issue_book_excel";
		$this->data['pdf_url'] = "issue_consumption/report/issue_book_pdf";
		$this->data['report_title'] = $this->lang->line('issue_book');

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$summary = $this->input->post('summary');
			$allstore = $this->input->post('allstore');
			$store_id = $this->input->post('store_id');
			$locationid = $this->input->post('locationid');
			$comprehensive = $this->input->post('comprehensive');

			$this->data['compreHensive'] = "";
			$this->data['item_report'] = '';
			$this->data['store'] = $store_id;
			//echo"<pre>";print_r($this->input->post());die;

			if ($store_id) :
				$this->data['store_type'] = $this->general->get_tbl_data('*', 'eqty_equipmenttype', array('eqty_equipmenttypeid' => $store_id));
			else :
				$this->data['store_type'] = 'All';
			endif;

			if ($locationid) :
				$this->data['location'] = $this->general->get_tbl_data('*', 'loca_location', array('loca_locationid' => $locationid));
			else :
				$this->data['location'] = 'All';
			endif;
			$srchcol = "";

			if ($comprehensive) {
				$this->data['compreHensive'] = $this->report_issue_mdl->get_issuebook($srchcol);
			} else {
				$this->data['item_report'] = $this->report_issue_mdl->get_issuebook_result($srchcol);
			}
			//print_r($this->data['compreHensive']);die;
			$this->data['fromdate'] = $this->input->post('fromdate');
			$this->data['todate'] = $this->input->post('todate');
			$this->data['comprehensive'] = $this->input->post('comprehensive');
			$html = '';
			//echo"<pre>"; print_r($this->data['item_report']);die;
			if ($this->data['item_report'] || $this->data['compreHensive']) {
				$html = $this->load->view('report/v_issue_book_report', $this->data, true);
			} else {
				$html = '<span class="col-sm-12 alert alert-danger text-center">No Record Found!!!</span>';
			}
			return $html;
		} else {
			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		}
	}
	public function issue_book_excel()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			header("Content-Type: application/xls");
			header("Content-Disposition: attachment; filename=issue_summary_excel_" . date('Y_m_d_H_i') . ".xls");
			header("Pragma: no-cache");
			header("Expires: 0");

			$response = $this->issue_book_common();

			if ($response) {
				echo $response;
			}
			return false;
		} else {
			print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
			exit;
		}
	}
	public function issue_book_pdf()
	{
		  $page_orientation = !empty($_GET['page_orientation']) ? $_GET['page_orientation']  : '';
		if ($page_orientation == 'L') {
			$page_size = 'A4-L';
		} else {
			$page_size = 'A4';
		}

		//pdf generation
		$html = $this->issue_book_common();
		// echo $this->db->last_query(); die;
		$filename = 'issue_book_' . date('Y_m_d_H_i_s') . '_.pdf';
		$pdfsize = 'A4'; //A4-L for landscape
		//if save and download with default filename, send $filename as parameter
		$this->general->generate_pdf($html, false, $pdfsize,$page_size);

		exit();
	}



	// public function issuebook_result()
	// {
	// 	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// 		$template=$this->issue_book_common();
	//       	print_r(json_encode(array('status'=>'success','template'=>$template,'message'=>'Successfully Selected')));
	//         exit;
	//     }
	//     else
	//     {
	//        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	//        	exit;
	//        }
	// }

	// public function issue_book_common()
	// {
	// 	if ($_SERVER['REQUEST_METHOD'] === 'POST') 
	// 	{
	// 	$this->data['excel_url'] = "issue_consumption/report/issue_book_excel";
	// 	$this->data['pdf_url'] = "issue_consumption/report/issue_book_pdf";
	// 	$this->data['report_title'] = $this->lang->line('issue_book');


	// 	$this->data['fromdate'] = $this->input->post('fromdate');
	//        $this->data['todate'] = $this->input->post('todate');

	//        $locationid = $this->input->post('locationid');
	//        $store_id = $this->input->post('store_id');

	//     $this->data['summary_report']=$this->report_issue_mdl->issue_summary_report();

	//   if($store_id):
	//  		$this->data['store_type']=$this->general->get_tbl_data('*','eqty_equipmenttype',array('eqty_equipmenttypeid'=>$store_id));
	//  	else:
	//  		$this->data['store_type'] = 'All';
	//  	endif;

	//  	if($locationid):
	// 	$this->data['location']=$this->general->get_tbl_data('*','loca_location',array('loca_locationid'=>$locationid));
	// else:
	// 	$this->data['location'] = 'All';
	// endif;



	// 	if($this->data['summary_report'])
	// 		{
	// 			$html = $this->load->view('report/v_issue_book_report',$this->data,true);
	// 		}else
	// 		{
	// 			$html='<span class="col-sm-12 alert alert-danger text-center">No Record Found!!!</span>';
	// 		}

	// 		return $html;
	// 	}
	// 	else
	// 	{
	//     	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	//     	exit;
	//     }


	// }

	// public function issue_book_pdf()
	// {
	// 	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	// 		$html = $this->issue_book_common();

	// 		$filename = 'issue_book'. date('Y_m_d_H_i_s') . '_.pdf'; 
	//         $pdfsize = 'A4'; //A4-L for landscape

	//         //if save and download with default filename, send $filename as parameter
	//         $this->general->generate_pdf($html,false,$pdfsize);

	//         exit();
	//     }else{
	//        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	//        	exit;
	//        }
	// }

	// public function issue_book_excel()
	// {
	//        if ($_SERVER['REQUEST_METHOD'] === 'POST') 
	// 	{
	// 		header("Content-Type: application/xls");    
	//         header("Content-Disposition: attachment; filename=issue_book_excel_".date('Y_m_d_H_i').".xls");  
	//         header("Pragma: no-cache"); 
	//         header("Expires: 0");

	//          $response = $this->issue_book_common();
	//         if($response){
	//         	echo $response;	
	//         }
	//         return false;


	//         echo $response;
	//     }
	// }



	public function save_stocktransfer()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			try {
				$this->form_validation->set_rules($this->stock_transfer_mdl->validate_settings_stock_requisition);
				if ($this->form_validation->run() == TRUE) {
					$trans = $this->stock_transfer_mdl->save_stocktransfer();
					if ($trans) {
						print_r(json_encode(array('status' => 'success', 'message' => 'Record Save Successfully')));
						exit;
					} else {
						print_r(json_encode(array('status' => 'error', 'message' => 'Record Save Successfully')));
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