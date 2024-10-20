<?php
ini_set('max_execution_time', 0);
ini_set('memory_limit', '2048M');
?>
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class JobHeadExpensesReport extends CI_Controller
{
  function __construct()
  {

    parent::__construct();
    $this->load->Model('JobHeadExpensesReport_mdl','report_mdl');
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
    $this->data['tab_type'] = 'job_head_expenses_report';
    
    $this->data['budget_head'] = $this->general->get_tbl_data('*','buhe_bugethead',array('buhe_isactive'=>'Y'));

    $this->db->select('DISTINCT(itli_catid) catid,ec.eqca_code,ec.eqca_category');
    $this->db->from('itli_itemslist il');
    $this->db->join('eqca_equipmentcategory ec','ec.eqca_equipmentcategoryid=il.itli_catid','LEFT');
    $this->db->order_by('ec.eqca_category','ASC');
    $this->data['category_type']=$this->db->get()->result();

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

   public function get_report()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      if (MODULES_VIEW == 'N') {
        $array = array();

        print_r(json_encode(array('status' => 'error', 'message' => $this->general->permission_denial_message())));
        exit;
      }

      $html = $this->search_report_common();
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
  public function search_report_pdf()
  {
    
    $html = $this->search_report_common();
    
    $page_orientation = $this->input->post('page_orientation');

    if ($page_orientation == 'L') {
      $page_layout = 'A4-L';
    } else {
      $page_layout = 'A4';
    }
    $filename = 'job_head_expenses_report' . date('Y_m_d_H_i_s') . '_.pdf';
    $pdfsize = $page_layout;
    $this->general->generate_pdf($html, false, $pdfsize);
  }

  public function search_report_excel()
  {
    $exporttype = $this->input->post('exporttype');
    if ($exporttype == 'word') {
      header("Content-type: application/vnd.ms-word");
      header("Content-Disposition: attachment;Filename=job_head_expenses_report" . date(' Y_m_d_H_i') . ".doc");
    } else {
      header("Content-Type: application/xls");
      header("Content-Disposition: attachment; filename=job_head_expenses_report" . date('Y_m_d_H_i') . ".xls");
    }
    header("Pragma: no-cache");
    header("Expires: 0");

    $response = $this->search_report_common();
    
    if ($response) {
      echo $response;
    }
    return false;
  }

  public function search_report_common()
  {
    $this->data['excel_url'] = "reports/JobHeadExpensesReport/search_report_excel";
    $this->data['pdf_url'] = "reports/JobHeadExpensesReport/search_report_pdf";
    $this->data['report_title'] = 'Job Head Expenses Report';
    $this->data['target_formid'] = 'job_head_expenses_report_search_form';

    $html = '<span class="col-sm-12 alert alert-danger text-center">No Record Found!!!</span>';

    $this->data['report_result'] = $this->report_mdl->get_report_detail();
    $this->data['budget_head'] = $this->general->get_tbl_data('*','buhe_bugethead',array('buhe_isactive'=>'Y'));
    // echo "<pre>";
    // print_r ($this->data['report_result']);
    // echo "</pre>";
    // die;
    if(!empty($this->data['report_result'])){
    $html = $this->load->view('job_head_expenses_report/v_detail_report', $this->data, true);
    }

    return $html;
  }
}