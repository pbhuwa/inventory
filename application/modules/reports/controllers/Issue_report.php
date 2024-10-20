<?php
ini_set('max_execution_time', 0);
ini_set('memory_limit', '2048M');
?>
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Issue_report extends CI_Controller
{
  function __construct()
  {

    parent::__construct();
    $this->load->Model('issue_report_mdl');
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

    $this->data['tab_type'] = 'demand_report';
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

    $this->data['tab_type'] = 'issue_report';

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


  public function get_search_issue_report()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      if (MODULES_VIEW == 'N') {
        $array = array();
        print_r(json_encode(array('status' => 'error', 'message' => $this->general->permission_denial_message())));
        exit;
      }
        $html = $this->search_issue_report();

       
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

  public function search_issue_report_pdf()
  {
   
     $html = $this->search_issue_report();
  
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

  public function search_demand_report_excel()
  {

    $exporttype = $this->input->post('exporttype');
    if ($exporttype == 'word') {
      header("Content-type: application/vnd.ms-word");
      header("Content-Disposition: attachment;Filename=issue_report" . date(' Y_m_d_H_i') . ".doc");
    } else {
      header("Content-Type: application/xls");
      header("Content-Disposition: attachment; filename=issue_report" . date('Y_m_d_H_i') . ".xls");
    }

    header("Pragma: no-cache");
    header("Expires: 0");
 
    $response = $this->search_issue_report();
   
    if ($response) {
      echo $response;
    }
    return false;
  }




  public function search_issue_report()
  {
    $this->data['excel_url'] = "reports/issue_report/search_demand_report_excel";
    $this->data['pdf_url'] = "reports/issue_report/search_issue_report_pdf";
    $this->data['report_title'] = 'Issue Report Analysis';
    $this->data['target_formid'] = 'issue_report_searchForm';
    $rpt_wise = $this->input->post('rpt_wise');
    $rpt_type = $this->input->post('rpt_type');
    $this->data['report_type'] = ucfirst(str_replace('_', " ", $rpt_wise)) . ' Report';

    $html = '<span class="col-sm-12 alert alert-danger text-center">No Record Found!!!</span>';

    if ($rpt_wise == 'default') {
      $this->data['report_wise'] = 'Default';
      if ($rpt_type == 'summary') {
        $this->data['report_result'] = $this->issue_report_mdl->get_issue_report_summary();
        if(ORGANIZATION_NAME=='KU'){
          $html = $this->load->view('issue_report/' . REPORT_SUFFIX . '/v_default_summary_report', $this->data, true);
        }else{
            $html = $this->load->view('issue_report/v_default_summary_report', $this->data, true);
        }
        
      } else {
        $this->data['report_result'] = $this->issue_report_mdl->get_issue_report_detail();
         if(ORGANIZATION_NAME=='KU'){
            $html = $this->load->view('issue_report/' . REPORT_SUFFIX . '/v_default_detail_report', $this->data, true);
         }else{
            $html = $this->load->view('issue_report/v_default_detail_report', $this->data, true);
         }
        
      
      }
    }

    if ($rpt_wise == 'issue_no') {
      $this->data['report_wise'] = 'Issue No. wise';
      if ($rpt_type == 'summary') {
        $this->data['report_result'] = $this->issue_report_mdl->get_issue_report_summary();
        // echo $this->db->last_query();
        // die();
        $html = $this->load->view('issue_report/v_default_summary_report', $this->data, true);
      
      } else {

        $this->data['report_result'] = $this->issue_report_mdl->issue_number_detail_report();
        // echo $this->db->last_query();
        // die();
          $html = $this->load->view('issue_report/v_issue_number_detail_report', $this->data, true);

      
      }
    }

     if ($rpt_wise == 'category_wise') {
      $this->data['report_wise'] = 'Category Wise';
      if ($rpt_type == 'summary') {
        $this->data['report_result'] = $this->issue_report_mdl->get_issue_report_summary();
        // echo $this->db->last_query();
        // die();
       if(ORGANIZATION_NAME=='KU'){
        $html = $this->load->view('issue_report/' . REPORT_SUFFIX . '/v_default_summary_report', $this->data, true);
      }else{
        $html = $this->load->view('issue_report/v_default_summary_report', $this->data, true);
      }

      } else {

        $this->data['report_result'] = $this->issue_report_mdl->issue_report_category_wise_detail_default();
        // echo $this->db->last_query();
        // die();
        if(ORGANIZATION_NAME=='KU'){
            $html = $this->load->view('issue_report/' . REPORT_SUFFIX . '/v_category_detail_report', $this->data, true);
       }else{
          $html = $this->load->view('issue_report/v_category_detail_report', $this->data, true);
       }
      
      
      }
    }

     if ($rpt_wise == 'item_wise') {
      $this->data['report_wise'] = 'Item';
      if ($rpt_type == 'summary') {
        $this->data['report_result'] = $this->issue_report_mdl->get_issue_report_summary();
        // echo "<pre>";
        // print_r($this->data['report_result']);
        // die;
        // echo REPORT_SUFFIX;
        // die();
         if(ORGANIZATION_NAME=='KU'){
          $html = $this->load->view('issue_report/' . REPORT_SUFFIX . '/v_default_summary_report', $this->data, true);
        }else{
            $html = $this->load->view('issue_report/v_default_summary_report', $this->data, true);
        }
        
      } else {
        $this->data['report_result'] = $this->issue_report_mdl->issue_report_item_wise_detail_default();
        // echo "<pre>";
        // print_r($this->data['report_result']);
        // die();
         if(ORGANIZATION_NAME=='KU'){
           $html = $this->load->view('issue_report/' . REPORT_SUFFIX . '/v_item_detail_report', $this->data, true);
         }else{
           $html = $this->load->view('issue_report/v_item_detail_report', $this->data, true);
         }

       
      }
    }


    if ($rpt_wise == 'department') {
      $this->data['report_wise'] = 'Department';
      if ($rpt_type == 'summary') {
         $this->data['report_result'] = $this->issue_report_mdl->get_issue_report_summary();
           if(ORGANIZATION_NAME=='KU'){
               $html = $this->load->view('issue_report/' . REPORT_SUFFIX . '/v_default_summary_report', $this->data, true);
           }else{
              $html = $this->load->view('issue_report/v_default_summary_report', $this->data, true);
           }
       
     
      } else {
        $this->data['report_result'] = $this->issue_report_mdl->issue_report_department_detail();
         if(ORGANIZATION_NAME=='KU'){
            $html = $this->load->view('issue_report/' . REPORT_SUFFIX . '/v_department_detail_report', $this->data, true);
         }else{
            $html = $this->load->view('issue_report/v_department_detail_report', $this->data, true);
         }
      
      }
    }

      if ($rpt_wise == 'received_by') {
      $this->data['report_wise'] = 'Received By';
      if ($rpt_type == 'summary') {
        $this->data['report_result'] = $this->issue_report_mdl->get_issue_report_summary();
        // echo "<pre>";
        // print_r($this->data['report_result']);
         if(ORGANIZATION_NAME=='KU'){
           $html = $this->load->view('issue_report/' . REPORT_SUFFIX . '/v_default_summary_report', $this->data, true);
         }else{
           $html = $this->load->view('issue_report/v_default_summary_report', $this->data, true);
         }
        // die;
       
      } else {
           $this->data['report_result'] = $this->issue_report_mdl->issue_report_received_by_detail();
          if(ORGANIZATION_NAME=='KU'){
                $html = $this->load->view('issue_report/' . REPORT_SUFFIX . '/v_received_by_detail_report', $this->data, true);
          }else{
                $html = $this->load->view('issue_report/v_received_by_detail_report', $this->data, true);
          }
      
    
      }
    }

     if ($rpt_wise == 'demand_date') {
      $this->data['report_wise'] = 'Demand Date';
      if ($rpt_type == 'summary') {
        $this->data['report_result'] = $this->issue_report_mdl->get_issue_report_summary();
        // echo "<pre>";
        // print_r($this->data['report_result']);
        // die;

        if(ORGANIZATION_NAME=='KU'){
           $html = $this->load->view('issue_report/' . REPORT_SUFFIX . '/v_default_summary_report', $this->data, true);
        }else{
           $html = $this->load->view('issue_report/v_default_summary_report', $this->data, true);
        }
       
      } else {
        $this->data['report_result'] = $this->issue_report_mdl->issue_report_demand_date_detail();
         if(ORGANIZATION_NAME=='KU'){
             $html = $this->load->view('issue_report/' . REPORT_SUFFIX . '/v_demand_date_detail_report', $this->data, true);
         }else{
             $html = $this->load->view('issue_report/v_demand_date_detail_report', $this->data, true);
         }
     
      }
    }

     if ($rpt_wise == 'issue_date') {
      $this->data['report_wise'] = 'Issue Date';
      if ($rpt_type == 'summary') {
        $this->data['report_result'] = $this->issue_report_mdl->get_issue_report_summary();
        // echo "<pre>";
        // print_r($this->data['report_result']);
        // die;
        // echo REPORT_SUFFIX;
        // die();
          if(ORGANIZATION_NAME=='KU'){
              $html = $this->load->view('issue_report/' . REPORT_SUFFIX . '/v_default_summary_report', $this->data, true);
          }else{
               $html = $this->load->view('issue_report/v_default_summary_report', $this->data, true);
          }
      
      } else {
         $this->data['report_result'] = $this->issue_report_mdl->issue_report_demand_date_detail();
         if(ORGANIZATION_NAME=='KU'){
           $html = $this->load->view('issue_report/' . REPORT_SUFFIX . '/v_demand_date_detail_report', $this->data, true);
         }else{
        $html = $this->load->view('issue_report/v_demand_date_detail_report', $this->data, true);
         }
         
         
      }
    }

    if ($rpt_wise == 'material_type') {
      $this->data['report_wise'] = 'Material Type';
      if ($rpt_type == 'summary') {
        $this->data['report_result'] = $this->issue_report_mdl->get_issue_report_summary();
        // echo "<pre>";
        // // print_r($this->data['report_result']);
        // print_r($this->db->last_query());
        // die;
           if(ORGANIZATION_NAME=='KU'){
                $html = $this->load->view('issue_report/' . REPORT_SUFFIX . '/v_default_summary_report', $this->data, true);
           }else{
                $html = $this->load->view('issue_report/v_default_summary_report', $this->data, true);
           }
    
      } else {
         $this->data['report_result'] = $this->issue_report_mdl->issue_report_material_type_detail();
          if(ORGANIZATION_NAME=='KU'){
              $html = $this->load->view('issue_report/' . REPORT_SUFFIX . '/v_material_type_detail_report', $this->data, true);
           }else{
              $html = $this->load->view('issue_report/v_material_type_detail_report', $this->data, true);
          }
       
      
      }
    }

   
 if ($rpt_wise == 'handover_issue') {
      $this->data['report_wise'] = 'Handover';
      if ($rpt_type == 'summary') {
        $this->data['report_result'] = $this->issue_report_mdl->get_issue_report_summary();
        // echo "<pre>";
        // // print_r($this->data['report_result']);
        // print_r($this->db->last_query());
        // die;
           if(ORGANIZATION_NAME=='KU'){
                $html = $this->load->view('issue_report/' . REPORT_SUFFIX . '/v_default_summary_report', $this->data, true);
           }else{
                $html = $this->load->view('issue_report/v_default_summary_report', $this->data, true);
           }
    
      } else {
         $this->data['report_result'] = $this->issue_report_mdl->issue_report_handover_detail();
         // echo "<pre>";
         // print_r($this->data['report_result']);
         // die();
          
              $html = $this->load->view('issue_report/v_handover_detail_report', $this->data, true);
          
       
      
      }
    }
    
     return $html;
  }

  
}
