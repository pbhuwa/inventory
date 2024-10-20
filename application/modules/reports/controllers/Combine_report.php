<?php
ini_set('max_execution_time', 0);
ini_set('memory_limit', '2048M');
?>
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Combine_report extends CI_Controller
{
	function __construct()
  {

    parent::__construct();
    $this->load->Model('combine_report_mdl');
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

    $this->data['tab_type'] = 'combine_report';
    if (!empty($this->mattypeid)) {
      $srchmat = array('maty_materialtypeid' => $this->mattypeid, 'maty_isactive' => 'Y');
    } else {
      $srchmat = array('maty_isactive' => 'Y');
    }
    $this->data['material_type'] = $this->general->get_tbl_data('maty_materialtypeid,maty_material', 'maty_materialtype',  $srchmat, 'maty_materialtypeid', 'ASC');
    
    $this->db->select('DISTINCT(sama_receivedby)')->from('sama_salemaster');
    if ($this->location_ismain !== 'Y') {
      $this->db->where('sama_locationid', $this->locationid);
    }
    $this->data['requested_by'] = $this->db->get()->result();
    $this->data['department'] = $this->general->get_tbl_data('*', 'dept_department', array('dept_locationid' => $this->locationid), 'dept_depname', 'ASC');
$this->data['category']=$this->general->get_tbl_data('eqca_equipmentcategoryid,eqca_category,eqca_code','eqca_equipmentcategory',false,'eqca_category','ASC');
// echo "<pre>";
//       print_r($this->data['category']);
//     die();

    $this->data['tab_type'] = 'combine_report';

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


public function get_search_combine_report(){
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // if (MODULES_VIEW == 'N') {
      //   $array = array();
      //   print_r(json_encode(array('status' => 'error', 'message' => $this->general->permission_denial_message())));
      //   exit;
      // }
        $html = $this->search_combine_report();

       
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

public function search_combine_report_pdf()
  {
   
    $html = $this->search_combine_report();
  
    $porientation = $this->input->post('page_orientation');
    if ($porientation == 'L') {
      $page_type = 'A4-L';
    } else {
      $page_type = 'A4';
    }
    //echo $this->db->last_query(); die;
    $filename = 'issue_analysis_' . date('Y_m_d_H_i_s') . '_.pdf';
    $pdfsize = $page_type; //A4-L for landscape //if save and download with default filename, send $filename as parameter
    $this->general->generate_pdf($html, false, $pdfsize);
  }

  public function search_combine_report_excel()
  {

    $exporttype = $this->input->post('exporttype');
    if ($exporttype == 'word') {
      header("Content-type: application/vnd.ms-word");
      header("Content-Disposition: attachment;Filename=combine_report" . date(' Y_m_d_H_i') . ".doc");
    } else {
      header("Content-Type: application/xls");
      header("Content-Disposition: attachment; filename=combine_report" . date('Y_m_d_H_i') . ".xls");
    }

    header("Pragma: no-cache");
    header("Expires: 0");
 
    $response = $this->search_combine_report();
   
    if ($response) {
      echo $response;
    }
    return false;
  }




  public function search_combine_report()
  {
    $this->data['excel_url'] = "reports/combine_report/search_combine_report_excel";
    $this->data['pdf_url'] = "reports/combine_report/search_combine_report_pdf";
    $this->data['report_title'] = 'Overall Report';
    $this->data['target_formid'] = 'combine_report_searchForm';
    $rpt_wise = $this->input->post('rpt_wise');
    $rpt_type = $this->input->post('rpt_type');
    $this->data['report_type'] = ucfirst(str_replace('_', " ", $rpt_wise)) . ' Report';

    $html = '<span class="col-sm-12 alert alert-danger text-center">No Record Found!!!</span>';

    if ($rpt_wise == 'default') {
      $this->data['report_wise'] = 'Default';
      if ($rpt_type == 'summary') {
      	  $this->data['combine_data'] = $this->combine_report_mdl->get_combine_report_summary();
      	  // echo "<pre>";
      	  // print_r($this->data['combine_data']);
      	  // die();
      	 $html=$this->load->view('combine_report/v_combine_report_summary', $this->data,true);

      }
    }

 	return $html;
  }


}