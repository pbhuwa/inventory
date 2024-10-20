<?php
ini_set('max_execution_time', 0);
ini_set('memory_limit', '2048M');
?>
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Purchase_req_report extends CI_Controller
{
  function __construct()
  {

    parent::__construct();
    $this->load->Model('purchase_req_report_mdl');
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

    $this->data['tab_type'] = 'purchase_requisition_report';
    if (!empty($this->mattypeid)) {
      $srchmat = array('maty_materialtypeid' => $this->mattypeid, 'maty_isactive' => 'Y');
    } else {
      $srchmat = array('maty_isactive' => 'Y');
    }
    $this->data['material_type'] = $this->general->get_tbl_data('maty_materialtypeid,maty_material', 'maty_materialtype', $srchmat, 'maty_materialtypeid', 'ASC');

    $this->db->select('DISTINCT(pure_requser)')->from('pure_purchaserequisition');
    if ($this->location_ismain !== 'Y') {
      $this->db->where('pure_locationid', $this->locationid);
    }
    $this->data['requested_by'] = $this->db->get()->result();
    $this->data['department'] = $this->general->get_tbl_data('*', 'dept_department', array('dept_locationid' => $this->locationid), 'dept_depname', 'ASC');

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
      ->build('v_overall_report_common', $this->data);
  }


  public function get_search_purchase_req_report()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      if (MODULES_VIEW == 'N') {
        $array = array();

        print_r(json_encode(array('status' => 'error', 'message' => $this->general->permission_denial_message())));
        exit;
      }

      if (ORGANIZATION_NAME == "KU") {
        $html = $this->search_purchase_req_report_ku();
      } else {
        $html = $this->search_purchase_req_report_ku();
      }
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


  public function search_purchase_req_report_pdf()
  {
    if (ORGANIZATION_NAME == "KU") {
      $html = $this->search_purchase_req_report_ku();
    } else {
      $html = $this->search_purchase_req_report_ku();
    }
    $page_orientation = $this->input->post('page_orientation');
    if ($page_orientation == 'L') {
      $page_layout = 'A4-L';
    } else {
      $page_layout = 'A4';
    }
    $filename = 'categories_wise_issue_' . date('Y_m_d_H_i_s') . '_.pdf';
    $pdfsize = $page_layout; //A4-L for landscape //if save and download with default filename, send $filename as parameter
    $this->general->generate_pdf($html, false, $pdfsize);
  }

  public function search_purchase_req_report_excel()
  {

    $exporttype = $this->input->post('exporttype');
    if ($exporttype == 'word') {
      header("Content-type: application/vnd.ms-word");
      header("Content-Disposition: attachment;Filename=purchase_req_report" . date(' Y_m_d_H_i') . ".doc");
    } else {
      header("Content-Type: application/xls");
      header("Content-Disposition: attachment; filename=purchase_req_report" . date('Y_m_d_H_i') . ".xls");
    }

    header("Pragma: no-cache");
    header("Expires: 0");
    if (ORGANIZATION_NAME == "KU") {
      $response = $this->search_purchase_req_report_ku();
    } else {
      $response = $this->search_purchase_req_report_ku();
    }
    if ($response) {
      echo $response;
    }
    return false;
  }

  public function search_purchase_req_report_ku()
  {
    $this->data['excel_url'] = "reports/purchase_req_report/search_purchase_req_report_excel";
    $this->data['pdf_url'] = "reports/purchase_req_report/search_purchase_req_report_pdf";
    $this->data['report_title'] = 'Purchase Requisition Report Analysis';
    $this->data['target_formid'] = 'purchase_req_report_search_form';
    $rpt_wise = $this->input->post('rpt_wise');
    $rpt_type = $this->input->post('rpt_type');
    $this->data['report_type'] = ucfirst(str_replace('_', " ", $rpt_wise)) . ' Wise Report';

    $html = '<span class="col-sm-12 alert alert-danger text-center">No Record Found!!!</span>';

    if ($rpt_wise == 'default') {
      $this->data['report_wise'] = 'Default';
      if ($rpt_type == 'summary') {
        $this->data['report_result'] = $this->purchase_req_report_mdl->get_purchase_req_report_summary_ku();
        $html = $this->load->view('purchase_req_report/' . REPORT_SUFFIX . '/v_default_summary_report', $this->data, true);
      } else {
        $this->data['report_result'] = $this->purchase_req_report_mdl->get_purchase_req_report_detail_ku();
        $html = $this->load->view('purchase_req_report/' . REPORT_SUFFIX . '/v_default_detail_report', $this->data, true);
      }
    }

    if ($rpt_wise == 'department') {
      $this->data['report_wise'] = 'Department';
      if ($rpt_type == 'summary') {
        $this->data['report_result'] = $this->purchase_req_report_mdl->get_purchase_req_report_summary_ku();
        $html = $this->load->view('purchase_req_report/' . REPORT_SUFFIX . '/v_default_summary_report', $this->data, true);
      } else {
        $this->data['report_result'] = $this->purchase_req_report_mdl->purchase_req_report_department_detail_ku();
        // echo "<pre>";
        // print_r($this->data);
        // die;
        $html = $this->load->view('purchase_req_report/' . REPORT_SUFFIX . '/v_department_detail_report', $this->data, true);
      }
    }

    if ($rpt_wise == 'material_type') {
      $this->data['report_wise'] = 'Material Type';
      if ($rpt_type == 'summary') {
        $this->data['report_result'] = $this->purchase_req_report_mdl->get_purchase_req_report_summary_ku();
        // echo "<pre>";
        // print_r($this->data['report_result']);
        // die;
        $html = $this->load->view('purchase_req_report/' . REPORT_SUFFIX . '/v_default_summary_report', $this->data, true);
      } else {
        $this->data['report_result'] = $this->purchase_req_report_mdl->purchase_req_report_material_type_detail_ku();
        $html = $this->load->view('purchase_req_report/' . REPORT_SUFFIX . '/v_material_type_detail_report', $this->data, true);
      }
    }

    if ($rpt_wise == 'requisition_date') {
      $this->data['report_wise'] = 'Requisition Date';
      if ($rpt_type == 'summary') {
        $this->data['report_result'] = $this->purchase_req_report_mdl->get_purchase_req_report_summary_ku();
        // echo "<pre>";
        // print_r($this->data['report_result']);
        // die;
        $html = $this->load->view('purchase_req_report/' . REPORT_SUFFIX . '/v_default_summary_report', $this->data, true);
      } else {
        $this->data['report_result'] = $this->purchase_req_report_mdl->purchase_req_report_requisition_date_detail_ku();
        $html = $this->load->view('purchase_req_report/' . REPORT_SUFFIX . '/v_requisition_date_detail_report', $this->data, true);
      }
    }

    if ($rpt_wise == 'requested_by') {
      $this->data['report_wise'] = 'Requested By';
      if ($rpt_type == 'summary') {
        $this->data['report_result'] = $this->purchase_req_report_mdl->get_purchase_req_report_summary_ku();
        // echo "<pre>";
        // print_r($this->data['report_result']);
        // die;
        $html = $this->load->view('purchase_req_report/' . REPORT_SUFFIX . '/v_default_summary_report', $this->data, true);
      } else {
        $this->data['report_result'] = $this->purchase_req_report_mdl->purchase_req_report_requested_by_detail_ku();
        $html = $this->load->view('purchase_req_report/' . REPORT_SUFFIX . '/v_requested_by_detail_report', $this->data, true);
      }
    }

    return $html;
  }
}
