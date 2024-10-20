<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Stock_report extends CI_Controller
{
    function __construct()
    {
      
        parent::__construct();
        $this->load->Model('stock_report_mdl');
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
        $this->data['tab_type']='stock_report';
    
    $this->data['store_type'] = $this->general->get_tbl_data('*', 'eqty_equipmenttype', false, 'eqty_equipmenttypeid', 'ASC');
  
      if (!empty($this->mattypeid)) {
            $srchmat = array('maty_materialtypeid' => $this->mattypeid, 'maty_isactive' => 'Y');
          } else {
            $srchmat = array('maty_isactive' => 'Y');
          }
          if(ORGANIZATION_NAME=='KU'){
            $srchmat =array('maty_materialtypeid'=>1);
          }
      $this->data['material_type'] = $this->general->get_tbl_data('maty_materialtypeid,maty_material', 'maty_materialtype', $srchmat, 'maty_materialtypeid', 'ASC');

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
          ->build('v_overall_report_common', $this->data);

    }

   public function get_search_stock_report(){
   if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      if(MODULES_VIEW=='N')
      {
        $array=array();
        
        print_r(json_encode(array('status'=>'error','message'=>$this->general->permission_denial_message())));
        exit;
      } 
        $html = $this->search_stock_report_common();
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

public function search_stock_report_pdf()
  {   
       $page_orientation = $this->input->post('page_orientation');

      if ($page_orientation == 'L') {
        $page_layout = 'A4-L';
      } else {
        $page_layout = 'A4';
      }
      $html = $this->search_stock_report_common();
      $filename = 'Stock_result'. date('Y_m_d_H_i_s') . '_.pdf'; 
      $pdfsize = $page_layout; 
      $this->general->generate_pdf($html, false, $pdfsize);
  }

  public function search_stock_report_excel()
  { 
     $exporttype = $this->input->post('exporttype');
    if ($exporttype == 'word') {
      header("Content-type: application/vnd.ms-word");
      header("Content-Disposition: attachment;Filename=stock_report" . date(' Y_m_d_H_i') . ".doc");
    } else {
    header("Content-Type: application/xls");    
    header("Content-Disposition: attachment; filename=stock_report".date('Y_m_d_H_i').".xls"); 
  }
    header("Pragma: no-cache"); 
    header("Expires: 0");
    $response = $this->search_stock_report_common();
    if($response){
      echo $response; 
    }
    return false;
  }

  public function search_stock_report_common()
  {
    $this->data['excel_url'] = "reports/stock_report/search_stock_report_excel";
    $this->data['pdf_url'] = "reports/stock_report/search_stock_report_pdf";
    $this->data['report_title'] = 'Stock Report';
    $this->data['target_formid'] = 'stock_report_searchForm';

    $rpt_wise=$this->input->post('rpt_wise');
    $rpt_type = $this->input->post('rpt_type');
     $catid = $this->input->post('categoryid');
    
    $this->data['report_type'] = ucfirst($rpt_type);
    $searchtype=$this->input->post('searchDateType');
    
    if($searchtype=='date_range'){
      $this->data['fromdate'] = $this->input->post('frmDate');
      $this->data['todate'] = $this->input->post('toDate');
    }

  if (ORGANIZATION_NAME == "ARMY") {
      
    $main_branch_info = $this->db->where('loca_ismain', 'Y')->select('loca_namenp')->from('loca_location')->get()->row();
    $branch_info = $this->db->where('loca_locationid', $this->locationid)->select('loca_namenp')->from('loca_location')->get()->row();
    $main_branch_namenp = $main_branch_info->loca_namenp ? $main_branch_info->loca_namenp: '';
    $branch_namenp = $branch_info->loca_namenp ?$branch_info->loca_namenp: '';
    if ($this->location_ismain == "Y") {
      $this->data['form_branch_name'] = $main_branch_namenp;
    }else{
      $this->data['form_branch_name'] = "$main_branch_namenp, $branch_namenp";
    }
  }
  
  if($rpt_type=='default'){
  if($searchtype=='date_range'){
     $form_category = $this->input->post('categoryid');
      $itemid = $this->input->post('itemid');
     
      // $cond =  array('eqca_isactive'=>"Y");
      $cond = '';
      if(!empty($itemid)){
        $item_data = $this->general->get_tbl_data('itli_itemlistid,itli_catid', 'itli_itemslist',array('itli_itemlistid'=>$itemid));
        if(!empty($item_data)){
          $cond =  array('eqca_equipmentcategoryid'=>$item_data[0]->itli_catid,'eqca_isactive'=>"Y");
        }
      }
      if(!empty($form_category)){
        $cond = array('eqca_equipmentcategoryid'=>$form_category,'eqca_isactive'=>"Y");
      }
      if (!empty($cond)) {
      $categories = $this->general->get_tbl_data('eqca_equipmentcategoryid, eqca_code, eqca_category', 'eqca_equipmentcategory',$cond,'eqca_category','ASC');
      }
      $cat_id = false;
      if(!empty($categories)){
        $cat_id = $categories[0]->eqca_equipmentcategoryid;
      }
      $this->data['stock_result']=$this->stock_report_mdl->stock_report_data_range_detail(false,$cat_id);
      // echo $this->db->last_query();
      // die();
      $html=$this->load->view('stock_report/v_stock_report_detail_by_category', $this->data,true);
  }else{

      $this->data['stock_result'] = $this->stock_report_mdl->distinct_stock_category();
      $html=$this->load->view('stock_report/v_stock_report_summary_by_category', $this->data,true);
    // $this->data['stock_result']=$this->stock_report_mdl->stock_report_current();
  }
}
else if($rpt_type=='stock_range'){
  if($searchtype=='date_range'){
      $this->data['stock_result']=$this->stock_report_mdl->stock_report_data_range_detail(false,$catid);
      // echo "<pre>";
      // print_r($this->data['stock_result']);
      // die();

      $html=$this->load->view('stock_report/v_stock_report_summary_by_category_range', $this->data,true);
  }else{

      // echo "ASd";
      // die();
    $this->data['stock_result'] = $this->stock_report_mdl->distinct_stock_category();
      $html='<label class="text-danger text-center">Features not available</label>';
    // $this->data['stock_result']=$this->stock_report_mdl->stock_report_current();
  }
}
else if($rpt_type=='inspection'){
    if($searchtype=='date_range'){ 
      $this->data['report_title'] = 'जिन्सी निरीक्षण फारम';
       $this->data['stock_result']=$this->stock_report_mdl->stock_report_data_range_detail(false, $catid);
       // echo "<pre>";
       // print_r ($this->data['stock_result']);
       // echo "</pre>";
       // die();
       if (ORGANIZATION_NAME == 'ARMY') { 
       $html=$this->load->view('stock_report/v_stock_inspection_report_detail_army', $this->data,true);
       } else {
       $html=$this->load->view('stock_report/v_stock_inspection_report_detail', $this->data,true);
       }
    }else{
      $this->data['stock_result']=$this->stock_report_mdl->stock_report_current();
      // print_r($this->data['sto'])
      if (ORGANIZATION_NAME == 'ARMY') { 
       $html=$this->load->view('stock_report/v_stock_inspection_report_detail_army', $this->data,true);
       } else {
       $html=$this->load->view('stock_report/v_stock_inspection_report_detail', $this->data,true);
       }
    }
}
else if($rpt_type=='stock'){
      $this->data['report_title'] = 'जिन्सी मैाज्दातको वार्षिक विवरण';
 if($searchtype=='date_range'){ 
      $this->data['stock_result']=$this->stock_report_mdl->stock_report_data_range_detail(false,$catid);
       if (ORGANIZATION_NAME == 'ARMY') { 
        $html=$this->load->view('stock_report/v_store_stock_report_detail_army', $this->data,true);
       } else {
        $html=$this->load->view('stock_report/v_store_stock_report_detail', $this->data,true);
        }
  }
 else{
      $this->data['stock_result']=$this->stock_report_mdl->stock_report_current();
       if (ORGANIZATION_NAME == 'ARMY') { 
        $html=$this->load->view('stock_report/v_store_stock_report_detail_army', $this->data,true);
       } else {
        $html=$this->load->view('stock_report/v_store_stock_report_detail', $this->data,true);
        }
  }

}

else if($rpt_type=='bin_card'){
 if($searchtype=='date_range'){ 
      $this->data['report_title'] = 'बिन कार्ड';
      $this->data['stock_result']=$this->stock_report_mdl->stock_report_data_range_detail(false,$catid);
       $html=$this->load->view('stock_report/v_bin_card_report_detail', $this->data,true);
  }
 else{
        $this->data['report_title'] = 'बिन कार्ड';
      $this->data['stock_result']=$this->stock_report_mdl->stock_report_current();
       $html=$this->load->view('stock_report/v_bin_card_report_detail', $this->data,true);
  }

}

else if($rpt_type=='stock_adjustment'){
 if($searchtype=='date_range'){ 
      $this->data['report_title'] = 'जिन्सी निसगर् / मिन्हा फाराम';
      $this->data['stock_result']=$this->stock_report_mdl->stock_report_data_range_detail(false,$catid);
       $html=$this->load->view('stock_report/v_stock_adjustment_report_detail', $this->data,true);
  }
 else{
        $this->data['report_title'] = 'जिन्सी निसगर् / मिन्हा फाराम';
      $this->data['stock_result']=$this->stock_report_mdl->stock_report_current();
       $html=$this->load->view('stock_report/v_stock_adjustment_report_detail', $this->data,true);
  }

}
else if($rpt_type=='stock_new'){
      // $this->data['stock_result']=$this->stock_report_mdl->stock_generate_by_date();
      $this->data['stock_new_type']  = $stock_type = $this->input->post('stock_new_type');
      if($searchtype=='date_range'){

      $stock = array(); 
      $form_category = $this->input->post('categoryid');
      $itemid = $this->input->post('itemid');
      $cond =  array('eqca_isactive'=>"Y");
      if(!empty($itemid)){
        $item_data = $this->general->get_tbl_data('itli_itemlistid,itli_catid', 'itli_itemslist',array('itli_itemlistid'=>$itemid));
        if(!empty($item_data)){
          $cond =  array('eqca_equipmentcategoryid'=>$item_data[0]->itli_catid,'eqca_isactive'=>"Y");
        }
      }
      if(!empty($form_category)){
        $cond = array('eqca_equipmentcategoryid'=>$form_category,'eqca_isactive'=>"Y");
      }
      $categories = $this->general->get_tbl_data('eqca_equipmentcategoryid, eqca_code, eqca_category', 'eqca_equipmentcategory',$cond,'eqca_category','ASC');  
      if (!empty($categories)) {
          $this->stock_report_mdl->stock_generate_by_date('generate_table',false);
          if ($stock_type == 'balance_only') {
             $stock=  $this->stock_report_mdl->stock_generate_by_date('get_stock_data',false);
          }else{
          foreach ($categories as $key => $category) {
            $stock[$key]['name'] = $category->eqca_category;
            $stock[$key]['stock_details'] =  $this->stock_report_mdl->stock_generate_by_date('get_stock_data',$category->eqca_equipmentcategoryid);
          } 
          }

      }
      // 
      // print_r($stock);die();
      $this->data['stock_result']= $stock;
      // echo "<pre>";
      // echo $this->db->last_query();
      // echo "</pre>";
      // die();
      // echo "test";
      // die();
      if ($stock_type == 'balance_only') {
      $html=$this->load->view('stock_report/v_new_stock_report_category_balance', $this->data,true);
      }else{
      $html=$this->load->view('stock_report/v_new_stock_report_category', $this->data,true);

      }
       
    }else{

      $this->data['stock_result'] = $this->stock_report_mdl->distinct_stock_category();
      $html=$this->load->view('stock_report/v_stock_report_summary_by_category', $this->data,true);
  }
  }
  
  if(!empty($this->data['stock_result'])){
       $html=$html;

    }else{
          $html='<span class="col-sm-12 alert alert-danger text-center">No Record Found!!!</span>';

    }

 return $html; 
  }

}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */