<?php
ini_set('max_execution_time', 0);
ini_set('memory_limit', '2048M');
?>
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Purchase_received_report extends CI_Controller
{
  function __construct()
  {

    parent::__construct();
    $this->load->Model('purchase_received_report_mdl');
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

    $this->data['tab_type'] = 'purchase_received_report';

    $this->data['store_type'] = $this->general->get_tbl_data('*', 'eqty_equipmenttype', false, 'eqty_equipmenttypeid', 'ASC');
    $this->data['supplier_all'] = $this->general->get_tbl_data('*', 'dist_distributors', false, 'dist_distributorid', 'ASC');

    $this->data['receiver_list'] = $this->general->get_tbl_data('stin_staffinfoid,stin_fname,stin_mname,stin_lname', 'stin_staffinfo', false, 'stin_fname', 'ASC');


    if (!empty($this->mattypeid)) {
      $srchmat = array('maty_materialtypeid' => $this->mattypeid, 'maty_isactive' => 'Y');
    } else {
      $srchmat = array('maty_isactive' => 'Y');
    }
    $this->data['material_type'] = $this->general->get_tbl_data('maty_materialtypeid,maty_material', 'maty_materialtype', $srchmat, 'maty_materialtypeid', 'ASC');
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




  public function get_search_purchase_received_report()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      if (MODULES_VIEW == 'N') {
        $array = array();

        print_r(json_encode(array('status' => 'error', 'message' => $this->general->permission_denial_message())));
        exit;
      }

      $html = $this->search_purchase_received_report_common();
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

  public function search_purchase_received_report_pdf()
  {
    $html = $this->search_purchase_received_report_common();
    //echo $this->db->last_query(); die;
    $porientation = $this->input->post('page_orientation');
    if ($porientation == 'L') {
      $page_type = 'A4-L';
    } else {
      $page_type = 'A4';
    }
    $filename = 'categories_wise_issue_' . date('Y_m_d_H_i_s') . '_.pdf';
    $pdfsize = $page_type; //A4-L for landscape //if save and download with default filename, send $filename as parameter
    $this->general->generate_pdf($html, false, $pdfsize);
  }

  public function search_purchase_received_report_excel()
  {
    $exporttype = $this->input->post('exporttype');
    if ($exporttype == 'word') {
      header("Content-type: application/vnd.ms-word");
      header("Content-Disposition: attachment;Filename=purchase_received_report" . date(' Y_m_d_H_i') . ".doc");
    } else {
      header("Content-Type: application/xls");
      header("Content-Disposition: attachment; filename=purchase_received_report" . date(' Y_m_d_H_i') . ".xls");
    }

    header("Pragma: no-cache");
    header("Expires: 0");
    $response = $this->search_purchase_received_report_common();
    if ($response) {
      echo $response;
    }
    return false;
  }

  public function search_purchase_received_report_doc()
  {

    header("Content-type: application/vnd.ms-word");

    header("Content-Disposition: attachment;Filename=purchase_received_report" . date(' Y_m_d_H_i') . ".doc");

    header("Pragma: no-cache");

    header("Expires: 0");

    $response = $this->search_purchase_received_report_common();
    if ($response) {
      echo $response;
    }
    return false;
  }


  public function search_purchase_received_report_common()
  {
    $this->data['excel_url'] = "reports/purchase_received_report/search_purchase_received_report_excel";
    $this->data['pdf_url'] = "reports/purchase_received_report/search_purchase_received_report_pdf";
    $this->data['report_title'] = 'Purchase Received Analysis';
    $this->data['target_formid'] = 'purchase_receive_report_search_form';

    $rpt_wise = $this->input->post('rpt_wise');
    $rpt_type = $this->input->post('rpt_type');


    $this->data['report_type'] = ucfirst(str_replace('_', "", $rpt_wise)) . ' Wise Report';
    // $this->data['report_type']

    $html = '<span class="col-sm-12 alert alert-danger text-center">No Record Found!!!</span>';

    if ($rpt_wise == 'default') {
      $this->data['report_wise'] = 'Default';
      if ($rpt_type == 'summary') {
        if (ORGANIZATION_NAME == 'KU') {
          $this->data['report_result'] = $this->purchase_received_report_mdl->get_purchase_received_summarydata_ku();
          $html = $this->load->view('purchase_received_report/' . REPORT_SUFFIX . '/v_default_summary_report', $this->data, true);
        } else {
          $this->data['report_result'] = $this->purchase_received_report_mdl->get_purchase_received_summarydata();
           $html = $this->load->view('purchase_received_report/common/v_default_summary_report', $this->data, true);
        }
      } else if ($rpt_type == 'detail') {
        if (ORGANIZATION_NAME == 'KU') {
          $this->data['report_result'] = $this->purchase_received_report_mdl->get_purchase_received_detaildata_ku();
        } else {
          $this->data['report_result'] = $this->purchase_received_report_mdl->get_purchase_received_detaildata();
        }
      }
    }

    // if ($rpt_type == 'summary') {
    //     if (ORGANIZATION_NAME == 'KU') {
    //       $this->data['report_result'] = $this->purchase_received_report_mdl->get_purchase_received_summarydata_ku();
    //       $html = $this->load->view('purchase_received_report/' . REPORT_SUFFIX . '/v_default_summary_report', $this->data, true);
    //     } else {
    //       $this->data['report_result'] = $this->purchase_received_report_mdl->get_purchase_received_summarydata();
    //        $html = $this->load->view('purchase_received_report/common/v_default_summary_report', $this->data, true);
    //     }
    //   } else if ($rpt_type == 'detail') {
    //     if (ORGANIZATION_NAME == 'KU') {
    //       $this->data['report_result'] = $this->purchase_received_report_mdl->get_purchase_received_detaildata_ku();
    //     } else {
    //       $this->data['report_result'] = $this->purchase_received_report_mdl->get_purchase_received_detaildata();
    //     }
    //   }
    
    if ($rpt_wise == 'supplier') {
      $this->data['report_wise'] = 'Supplier';
      if ($rpt_type == 'summary') {
        $this->data['report_result'] = $this->purchase_received_report_mdl->get_purchase_received_summarydata();
         
          $html = $this->load->view('purchase_received_report/common/v_default_summary_report', $this->data, true);
      } else if ($rpt_type == 'detail') {
      
          $this->data['report_result'] = $this->purchase_received_report_mdl->get_purchase_received_supplier_detail();
          // echo "<pre>";
          // print_r($this->data['report_result']);
          // die();

           $html = $this->load->view('purchase_received_report/common/v_pr_supplier_detail_report', $this->data, true);
       
      }
    }


    if ($rpt_wise == 'invoice_wise') {
      $this->data['report_wise'] = 'Invoice';
      if ($rpt_type == 'summary') {
        $this->data['report_result'] = $this->purchase_received_report_mdl->get_purchase_received_summarydata();
         
          $html = $this->load->view('purchase_received_report/common/v_default_summary_report', $this->data, true);
      } else if ($rpt_type == 'detail') {
      
          $this->data['report_result'] = $this->purchase_received_report_mdl->get_purchase_received_invoice_detail();
          // echo "<pre>";
          // print_r($this->data['report_result']);
          // die();

           $html = $this->load->view('purchase_received_report/common/v_pr_invoice_detail_report', $this->data, true);
       
      }
    }



    if ($rpt_wise == 'item') {
      $this->data['report_wise'] = 'Item';
      if ($rpt_type == 'summary') {
        if (ORGANIZATION_NAME == 'KU') {
          $this->data['report_result'] = $this->purchase_received_report_mdl->get_purchase_received_summarydata_ku();
          $html = $this->load->view('purchase_received_report/' . REPORT_SUFFIX . '/v_default_summary_report', $this->data, true);
        } else {
          $this->data['report_result'] = $this->purchase_received_report_mdl->get_purchase_received_summarydata();
            $html = $this->load->view('purchase_received_report/common/v_default_summary_report', $this->data, true);
        }
        // echo $this->db->
      } else if ($rpt_type == 'detail') {
        if (ORGANIZATION_NAME == 'KU') {
          $this->data['report_result'] = $this->purchase_received_report_mdl->get_purchase_received_item_detail_ku();
          $html = $this->load->view('purchase_received_report/' . REPORT_SUFFIX . '/v_pr_items_detail_report', $this->data, true);
        } else {
          $this->data['report_result'] = $this->purchase_received_report_mdl->get_purchase_received_item_detail();
           $html = $this->load->view('purchase_received_report/common/v_pr_items_detail_report', $this->data, true);
        }
      }
    }

    if ($rpt_wise == 'school') {
      $this->data['report_wise'] = 'School';
      if ($rpt_type == 'summary') {
        if (ORGANIZATION_NAME == 'KU') {
          $this->data['report_result'] = $this->purchase_received_report_mdl->get_purchase_received_summarydata_ku();
          $html = $this->load->view('purchase_received_report/' . REPORT_SUFFIX . '/v_default_summary_report', $this->data, true);
        } else {
          $this->data['report_result'] = $this->purchase_received_report_mdl->get_purchase_received_summarydata();
            $html = $this->load->view('purchase_received_report/common/v_default_summary_report', $this->data, true);
        }
      } else if ($rpt_type == 'detail') {
        if (ORGANIZATION_NAME == 'KU') {
          $this->data['report_result'] = $this->purchase_received_report_mdl->get_purchase_received_school_detail_ku();
          $html = $this->load->view('purchase_received_report/' . REPORT_SUFFIX . '/v_pr_school_detail_report', $this->data, true);
        } else {
          $this->data['report_result'] = $this->purchase_received_report_mdl->get_purchase_received_school_detail();
        }
      }
    }
    if ($rpt_wise == 'department') {
      $this->data['report_wise'] = 'Department/Sub-Department';
      if ($rpt_type == 'summary') {
        if (ORGANIZATION_NAME == 'KU') {
          $this->data['report_result'] = $this->purchase_received_report_mdl->get_purchase_received_summarydata_ku();
          $html = $this->load->view('purchase_received_report/' . REPORT_SUFFIX . '/v_default_summary_report', $this->data, true);
        } else {
          $this->data['report_result'] = $this->purchase_received_report_mdl->get_purchase_received_summarydata();
            $html = $this->load->view('purchase_received_report/common/v_default_summary_report', $this->data, true);
        }
      } else if ($rpt_type == 'detail') {
        if (ORGANIZATION_NAME == 'KU') {
          $this->data['report_result'] = $this->purchase_received_report_mdl->get_purchase_received_department_detail_ku();
          $html = $this->load->view('purchase_received_report/' . REPORT_SUFFIX . '/v_pr_department_detail_report', $this->data, true);
        } else {
          $this->data['report_result'] = $this->purchase_received_report_mdl->get_purchase_received_department_detail_ku();
        }
      }
    }

    if ($rpt_wise == 'material_type') {
      $this->data['report_wise'] = 'Material Type';
      if ($rpt_type == 'summary') {
        if (ORGANIZATION_NAME == 'KU') {
          $this->data['report_result'] = $this->purchase_received_report_mdl->get_purchase_received_summarydata_ku();
          $html = $this->load->view('purchase_received_report/' . REPORT_SUFFIX . '/v_default_summary_report', $this->data, true);
        } else {
          $this->data['report_result'] = $this->purchase_received_report_mdl->get_purchase_received_summarydata();
            $html = $this->load->view('purchase_received_report/common/v_default_summary_report', $this->data, true);
        }
      } else if ($rpt_type == 'detail') {
        if (ORGANIZATION_NAME == 'KU') {
          $this->data['report_result'] = $this->purchase_received_report_mdl->get_purchase_received_material_type_detail_ku();
          $html = $this->load->view('purchase_received_report/' . REPORT_SUFFIX . '/v_pr_material_detail_report', $this->data, true);
        } else {
          $this->data['report_result'] = $this->purchase_received_report_mdl->get_purchase_received_material_type_detail_ku();
        }
      }
    }

    if ($rpt_wise == 'received_date') {
      $this->data['report_wise'] = 'Purchase Received Date';
      if ($rpt_type == 'summary') {
        if (ORGANIZATION_NAME == 'KU') {
          $this->data['report_result'] = $this->purchase_received_report_mdl->get_purchase_received_summarydata_ku();
          $html = $this->load->view('purchase_received_report/' . REPORT_SUFFIX . '/v_default_summary_report', $this->data, true);
        } else {
          $this->data['report_result'] = $this->purchase_received_report_mdl->get_purchase_received_summarydata();
            $html = $this->load->view('purchase_received_report/common/v_default_summary_report', $this->data, true);
        }
      } else if ($rpt_type == 'detail') {
        if (ORGANIZATION_NAME == 'KU') {
          $this->data['report_result'] = $this->purchase_received_report_mdl->get_purchase_received_received_date_detail_ku();
          $html = $this->load->view('purchase_received_report/' . REPORT_SUFFIX . '/v_pr_received_date_detail_report', $this->data, true);
        } else {
          $this->data['report_result'] = $this->purchase_received_report_mdl->get_purchase_received_received_date_detail_ku();

          // echo "<pre>";
          // print_r($this->data['report_result']);
          // die();
           $html = $this->load->view('purchase_received_report/common/v_pr_received_date_detail_report', $this->data, true);
        }
      }
    }

    if ($rpt_wise == 'bill_date') {
      $this->data['report_wise'] = 'Supplier Bill Date';
      if ($rpt_type == 'summary') {
        if (ORGANIZATION_NAME == 'KU') {
          $this->data['report_result'] = $this->purchase_received_report_mdl->get_purchase_received_summarydata_ku();
          $html = $this->load->view('purchase_received_report/' . REPORT_SUFFIX . '/v_default_summary_report', $this->data, true);
        } else {
          $this->data['report_result'] = $this->purchase_received_report_mdl->get_purchase_received_summarydata();
            $html = $this->load->view('purchase_received_report/common/v_default_summary_report', $this->data, true);
        }
      } else if ($rpt_type == 'detail') {
        if (ORGANIZATION_NAME == 'KU') {
          $this->data['report_result'] = $this->purchase_received_report_mdl->get_purchase_received_bill_date_detail_ku();
          $html = $this->load->view('purchase_received_report/' . REPORT_SUFFIX . '/v_pr_bill_date_detail_report', $this->data, true);
        } else {
          $this->data['report_result'] = $this->purchase_received_report_mdl->get_purchase_received_bill_date_detail_ku();
           $html = $this->load->view('purchase_received_report/common/v_pr_bill_date_detail_report', $this->data, true);
        }
      }
    }

    if ($rpt_wise == 'receiver') {
      $this->data['report_wise'] = 'Receiver Wise';
      if ($rpt_type == 'summary') {
        if (ORGANIZATION_NAME == 'KU') {
          $this->data['report_result'] = $this->purchase_received_report_mdl->get_purchase_received_summarydata_ku();
          // echo "<pre>";
          // print_r($this->data['report_result']);
          // die();
          $html = $this->load->view('purchase_received_report/' . REPORT_SUFFIX . '/v_default_summary_report', $this->data, true);
        } else {
          $this->data['report_result'] = $this->purchase_received_report_mdl->get_purchase_received_summarydata();
            $html = $this->load->view('purchase_received_report/common/v_default_summary_report', $this->data, true);
        }
      } else if ($rpt_type == 'detail') {
        if (ORGANIZATION_NAME == 'KU') {
          $this->data['report_result'] = $this->purchase_received_report_mdl->get_receiver_detail_ku();
          $html = $this->load->view('purchase_received_report/' . REPORT_SUFFIX . '/v_pr_receiver_detail_report', $this->data, true);
        } else {
          $this->data['report_result'] = $this->purchase_received_report_mdl->get_receiver_detail_ku();
           $html = $this->load->view('purchase_received_report/common/v_pr_receiver_detail_report', $this->data, true);
        }
      }
    }
    return $html;
  }
}
