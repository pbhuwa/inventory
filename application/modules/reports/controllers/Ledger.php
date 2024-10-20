<?php 
ini_set('max_execution_time', '300');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ledger extends CI_Controller
{
  function __construct()
  {

    parent::__construct();
    $this->load->Model('ledger_mdl');
    $this->load->Model('Stock_report_mdl');
    $this->username = $this->session->userdata(USER_NAME);
    $this->deptid = $this->session->userdata(USER_DEPT);
    $this->userid = $this->session->userdata(USER_ID);
    $this->locationid=$this->session->userdata(LOCATION_ID);
    if(defined('LOCATION_CODE')):
      $this->locationcode=$this->session->userdata(LOCATION_CODE);
    endif;
    $this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
    $this->orgid=$this->session->userdata(ORG_ID);
    $this->mattypeid = $this->session->userdata(USER_MAT_TYPEID);
  }

  public function index()
  {
    $this->data['tab_type']='item_ledger';
    
    $this->data['store']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','ASC');
      $this->data['category']=$this->general->get_tbl_data('*','eqca_equipmentcategory',false,'eqca_category','ASC');

    $seo_data='';
    if($seo_data)
    {
      //set SEO data
      $this->page_title = $seo_data->page_title;
      $this->data['meta_keys']= $seo_data->meta_key;
      $this->data['meta_desc']= $seo_data->meta_description;
    }
    else
    {
      //set SEO data
      $this->page_title = ORGA_NAME;
      $this->data['meta_keys']= ORGA_NAME;
      $this->data['meta_desc']= ORGA_NAME;
    }
    $this->template
    ->set_layout('general')
    ->enable_parser(FALSE)
    ->title($this->page_title)
    ->build('ledger/v_ledger_report_common', $this->data);

  }

  public function get_search_ledger_report(){
   if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if(MODULES_VIEW=='N')
    {
      $array=array();

      print_r(json_encode(array('status'=>'error','message'=>$this->general->permission_denial_message())));
      exit;
    } 

    $html = $this->search_ledger_report_common();
        //echo $this->db->last_query(); die;
    if($html)
    {
      $template=$html;
    }
    print_r(json_encode(array('status'=>'success','template'=>$template,'message'=>'Successfully Selected')));
    exit;
  }else{
    print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
    exit;
  }
}

public function search_ledger_report_pdf()
{ 
  $html = $this->search_ledger_report_common();
  //echo $this->db->last_query(); die;
  $filename = 'Item_Ledger'. date('Y_m_d_H_i_s') . '_.pdf'; 
  $pdfsize = 'A4'; //A4-L for landscape //if save and download with default filename, send $filename as parameter
  $this->general->generate_pdf($html,false,$pdfsize);

}

public function search_ledger_report_excel()
{ 
  header("Content-Type: application/xls");    
  header("Content-Disposition: attachment; filename=Item_leger".date('Y_m_d_H_i').".xls");  
  header("Pragma: no-cache"); 
  header("Expires: 0");
  $response = $this->search_ledger_report_common();
  if($response){
    echo $response; 
  }
  return false;
}

  public function search_ledger_report_common()
  {
    $ledger_type = $this->input->post('ledger_type');
     if($ledger_type != 'bulk'){
    $this->data['excel_url'] = "reports/stock_report/search_ledger_report_excel";
    $this->data['pdf_url'] = "reports/stock_report/search_ledger_report_pdf";
     } 
    $this->data['report_title'] = 'जिन्सी सामानको खाता';
    $this->data['target_formid'] = 'stock_report_searchForm';

    $searchtype=$this->input->post('searchDateType');

    $itemid=$this->input->post('itemid');
    $locationid=$this->input->post('locationid');
    if(empty($locationid)){
      print_r(json_encode(array('status'=>'error','message'=>'Branch Field is required!!')));
        exit;
    }
    if($ledger_type == 'single' && empty($itemid)){
      print_r(json_encode(array('status'=>'error','message'=>'Item Field is required!!')));
      exit;
    }

    $store_id = $this->input->post('store_id');
    if($itemid):
      $item_name = $this->data['item_name']=$this->general->get_tbl_data('itli_itemname, itli_itemcode,itli_unitid,itli_catid','itli_itemslist',array('itli_itemlistid'=>$itemid));
          
      $unitid = !empty($item_name[0]->itli_unitid)?$item_name[0]->itli_unitid:'';
      $itemcatid = !empty($item_name[0]->itli_catid)?$item_name[0]->itli_catid:'';

      if($unitid){
        $this->data['unit_name'] = $this->general->get_tbl_data('unit_unitname','unit_unit',array('unit_unitid'=>$unitid));
      }else{
        $this->data['unit_name'] = "";
      }
      if(!empty($itemcatid)){
        $this->data['itemcat_name'] = $this->general->get_tbl_data('eqca_code,eqca_category','eqca_equipmentcategory',array('eqca_equipmentcategoryid'=>$itemcatid));
      }else{
        $this->data['itemcat_name'] = "";
      }
      endif;

      if($store_id):
        $this->data['store_type']=$this->general->get_tbl_data('eqty_equipmenttype','eqty_equipmenttype',array('eqty_equipmenttypeid'=>$store_id));
      else:
        $this->data['store_type'] = 'All';
      endif;
          
      if($locationid):
      $this->data['location']=$this->general->get_tbl_data('loca_locationid,loca_name','loca_location',array('loca_locationid'=>$locationid));
      else:
        $this->data['location'] = 'All';
      endif;

    if($ledger_type == 'single'){
      $this->data['ledger_report'] = $this->ledger_mdl->stock_report_date_range_detail();
      // echo $this->db->last_query();
      // die();
      $html=$this->load->view('ledger/v_item_ledger_single', $this->data,true);
    }elseif ($ledger_type == 'bulk'){ 

      $distinct_items_in_range = $this->available_items();
      $html = '<style type="text/css">
      .table_jo_header, .jo_tbl_head, .jo_table, .jo_footer { width:100%; font-size:12px; border-collapse:collapse; }
      .table_jo_header { width:100%; vertical-align: top; font-size:12px; }
      .table_jo_header td.text-center { text-align:center; }
      .table_jo_header td.text-right { text-align:right; }
      h4 { font-size:18px; margin:0; }
      .table_jo_header u { text-decoration:underline; padding-top:15px; }

      .jo_table { border-right:1px solid #333; border-bottom:1px solid #000; margin-top:5px; margin-bottom:15px; }
      .jo_table tr{border-bottom:  1px solid #333;}
      .jo_table tr th { border-top:1px solid #333; border-bottom:1px solid #333; border-left:1px solid #333; }

      .jo_table tr th { padding:5px 3px; font-weight: bold; text-align: center;}
      .jo_table tr td { padding:5px 3px; height:15px; border-left:1px solid #333; font-size: 12px; }
      .jo_table tr td span{font-size: 12px;}
      .jo_footer { vertical-align: top; }
      .jo_footer td { padding:4px 0px; font-weight: bold;   }
      .bdr-table{border: 1px solid #000;}

      .table_item{
          height:100%;
      }
      .table_item .td_cell{
          padding:5px;margin:5px; 
      }
      .table_item .td_empty{
          height:100%;
      }
      .table-wrapper {
        height:100%;
        border-bottom: 3px dotted #000;
        padding-bottom: 10px;
        margin-bottom: 10px;
        overflow:auto
      }
    
  @page {
    margin: 20px 40px;
  }
  .table_jo_header,
  .jo_tbl_head,
  .jo_table,
  .jo_footer {
    width: 100%;
    font-size: 12px;
    border-collapse: collapse;
  }

  .table_jo_header {
    width: 100%;
    vertical-align: top;
    font-size: 12px;
  }

  .table_jo_header td.text-center {
    text-align: center;
  }

  .table_jo_header td.text-right {
    text-align: right;
  }

  h4 {
    font-size: 18px;
    margin: 0;
  }

  .table_jo_header u {
    text-decoration: underline;
    padding-top: 15px;
  }

  .jo_table {
    border-right: 1px solid #333;
    margin-top: 5px;
  }

  .jo_table tr th {
    border-top: 1px solid #333;
    border-bottom: 1px solid #333;
    border-left: 1px solid #333;
  }

  .jo_table tr th {
    padding: 5px 3px;
  }

  .jo_table tr td {
    padding: 3px 3px;
    height: 15px;
    border-left: 1px solid #333;
  }

  .jo_footer {
    border: 1px solid #333;
    vertical-align: top;
  }

  .jo_footer td {
    padding: 8px 8px;
  }

  .preeti {

    font-family: preeti;

  }

  tr.title_sub img {

    margin-top: -0px;

  }

  .alt_table {
    border-collapse: collapse;
    border: 1px solid #000;
    margin: 0 auto;
    width: 100%;
  }

  .alt_table thead tr th,
  .alt_table tbody tr td {
    border: 1px solid #000;
    padding: 2px 5px;
    font-size: 12px;
  }

  .alt_table thead tr th {
    font-weight: bold;
  }

  .alt_table tbody tr td {
    font-size: 12px;
  }

  .alt_table tbody tr td.header {
    padding: 5px;
    font-size: 12px;
    font-weight: bold;
  }

  .alt_table tbody tr.alter td {
    border: 0;
    text-align: center;
  }

  .alt_table tbody tr td.noboder {
    border-right: 0;
    text-align: center;
  }

  .alt_table tbody tr td.noboder+td {
    border-left: 0px;
  }

  .alt_table table.noborder {
    border: 0px;
  }

  .alt_table tr.noborder {
    border: 0px;
  }

  .alt_table td.noborder {
    border: 0px;
  }

  .alt_table tr.borderBottom {
    border-bottom: none;
  }

  .alt_table tr.header td {
    font-weight: bold;
  }

  .table>tbody+tbody {

    border-top: 1px solid #ddd;

  }

  table.organizationInfo {

    margin: 0px;

    /*margin-top: -50px;*/

    padding: 0px;

  }

  .header-content {

    margin-top: 13px;

    font-size: 12px;

  }

  /*used in purchase reports */

  .format_pdf {
    border: 1px solid #000;
    border-collapse: initial;
  }

  .format_pdf thead tr th,
  .format_pdf tbody tr td {
    font-size: 13px;
    border: 1px solid #000;
    padding: 2px 4px;
  }

  .format_pdf tbody tr td {
    font-size: 12px;
    padding: 4px;
  }

  .format_sub_tbl_pdf {
    width: 80%;
    border-collapse: collapse;
    border-color: #ccc;
  }

  .format_sub_pdf,
  .format_sub_tbl_pdf thead tr th,
  .format_sub_tbl_pdf tbody tr td {
    background-color: #fff;
  }

  .format_sub_pdf {
    background-color: #f0f0f0;
    clear: both;
  }

  </style>
  <a href="javascript:void(0)" class="btn btn_print"><i class="fa fa-print"></i></a>
  <a href="javascript:void(0)" class="btn btn_pdf2 btn_gen_report" data-exporturl="reports/ledger/bulk_item_ledger_pdf" data-exporttype="pdf" data-targetformid="purchase_mrn_search_form"><i class="fa fa-file-pdf-o"></i></a>
  <div class="white-box pad-5 mtop_10 pdf-wrapper" >
  <div class="jo_form organizationInfo "  id="printrpt">'
  ; 
    if(!$this->db->table_exists('xw_item_ledger_balance')){
          $create_stockrecord_table = "CREATE TABLE xw_item_ledger_balance  (
          id BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              item_code VARCHAR(20),
              item_name VARCHAR(250),
              item_id BIGINT(15),
              balance DECIMAL(15,2)
          )";
          $this->db->query($create_stockrecord_table);      
    }else{
    $this->db->query("TRUNCATE TABLE xw_item_ledger_balance");     
    }

      foreach ($distinct_items_in_range as $key => $item) {

      $item_name = $this->data['item_name']=$this->general->get_tbl_data('itli_itemname, itli_itemcode,itli_unitid,itli_catid,itli_itemlistid','itli_itemslist',array('itli_itemlistid'=>$item->itemid));
          
      $unitid = !empty($item_name[0]->itli_unitid)?$item_name[0]->itli_unitid:'';
      $itemcatid = !empty($item_name[0]->itli_catid)?$item_name[0]->itli_catid:'';

      if($unitid){
        $this->data['unit_name'] = $this->general->get_tbl_data('unit_unitname','unit_unit',array('unit_unitid'=>$unitid));
      }else{
        $this->data['unit_name'] = "";
      }
      if(!empty($itemcatid)){
        $this->data['itemcat_name'] = $this->general->get_tbl_data('eqca_code,eqca_category','eqca_equipmentcategory',array('eqca_equipmentcategoryid'=>$itemcatid));
      }else{
        $this->data['itemcat_name'] = "";
      }
      
        $_POST['itemid']=$item->itemid;
        $this->data['ledger_report'] = $this->ledger_mdl->stock_report_date_range_detail();
        $html .= '<strong style="font-size:10px">'.($key+1).'</strong>';
        $html .= $this->load->view('ledger/v_item_ledger_bulk', $this->data,true);

      }
       $html .= "</div></div>";
    }

    if(!empty($this->data['ledger_report'])){
     $html=$html;

   }else{
    $html='<span class="col-sm-12 alert alert-danger text-center">No Record Found!!!</span>';

  }

  return $html; 
}

public function available_items()
{
  $offset = $this->input->post('start');
  $limit = $this->input->post('limit');
  $categoryid=$this->input->post('categoryid');
  unset($_POST['itemid']);
  $result = $this->Stock_report_mdl->stock_report_data_range_detail(false,$categoryid,$limit,$offset);
  // echo "<pre>";
  // print_r ($result);
  // echo "</pre>";
  // die;
  return $result;
}

public function bulk_item_ledger_pdf(){
  // $page_orientation = $this->input->post('page_orientation') ?? 'L';

  // if ($page_orientation == 'L') {
    // $page_layout = 'A4-L';
  // } else {
    // $page_layout = 'A4-L';
  // }
  $html = $this->search_ledger_report_common();
  $filename = 'Bulk_Item_ledger'. date('Y_m_d_H_i_s') . '_.pdf'; 
  $pdfsize = 'A4-L'; 
  $this->general->generate_pdf($html, false, $pdfsize);
}

}