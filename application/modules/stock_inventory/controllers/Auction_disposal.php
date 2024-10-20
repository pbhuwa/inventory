<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Auction_disposal extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();

        $this->load->Model('auction_disposal_mdl');

        $this->load->Model('ams/assets_sales_desposal_mdl');

        $this->load->library('upload');

        $this->load->library('image_lib');

        $this->load->helper('file');

        $this->load->helper('form');

    }

    public function index()
    {

        $seo_data = '';
        if ($seo_data) {
            $this->page_title        = $seo_data->page_title;
            $this->data['meta_keys'] = $seo_data->meta_key;
            $this->data['meta_desc'] = $seo_data->meta_description;
        } else {
            //set SEO data

            $this->page_title = ORGA_NAME;

            $this->data['meta_keys'] = ORGA_NAME;

            $this->data['meta_desc'] = ORGA_NAME;

        }

        $this->data['breadcrumb'] = 'Item Auction/Disposal';
        $this->data['tab_type']   = "entry";
        $this->page_title         = 'Item Auction/Disposal';
        $this->template
            ->set_layout('general')
            ->enable_parser(false)
            ->title($this->page_title)
            ->build('assets_sales_desposal/v_assets_sales_desposal_common', $this->data);

    }

    public function entry($reload = false)
    {
        $locationid              = $this->session->userdata(LOCATION_ID);
        $currentfyrs             = CUR_FISCALYEAR;
        $cur_fiscalyrs_invoiceno = $this->db->select('prin_code,prin_fiscalyrs')
            ->from('prin_projectinfo')
            ->where('prin_locationid', $locationid)
        // ->where('prin_fiscalyrs',$currentfyrs)
            ->order_by('prin_fiscalyrs', 'DESC')
            ->limit(1)
            ->get()->row();

        if (!empty($cur_fiscalyrs_invoiceno)) {
            $invoice_format                        = $cur_fiscalyrs_invoiceno->prin_code;
            $invoice_string                        = str_split($invoice_format);
            $invoice_prefix_len                    = strlen(ITEM_DISPOSAL_NO_PREFIX);
            $chk_first_string_after_invoice_prefix = !empty($invoice_string[$invoice_prefix_len]) ? $invoice_string[$invoice_prefix_len] : '';
            // echo $chk_first_string_after_invoice_prefix;
            // die();
            if ($chk_first_string_after_invoice_prefix == '0') {
                $invoice_no_prefix = ITEM_DISPOSAL_NO_PREFIX . CUR_FISCALYEAR;
            } else if ($cur_fiscalyrs_invoiceno->prin_fiscalyrs == $currentfyrs && $chk_first_string_after_invoice_prefix == '0') {
                $invoice_no_prefix = ITEM_DISPOSAL_NO_PREFIX . CUR_FISCALYEAR;
            } else if ($cur_fiscalyrs_invoiceno->prin_fiscalyrs != $currentfyrs && $chk_first_string_after_invoice_prefix == '0') {
                $invoice_no_prefix = ITEM_DISPOSAL_NO_PREFIX . CUR_FISCALYEAR;
            } else if ($cur_fiscalyrs_invoiceno->prin_fiscalyrs != $currentfyrs && $chk_first_string_after_invoice_prefix != '0') {
                $invoice_no_prefix = ITEM_DISPOSAL_NO_PREFIX . CUR_FISCALYEAR;
            } else {
                $invoice_no_prefix = ITEM_DISPOSAL_NO_PREFIX;
            }
        } else {
            $invoice_no_prefix = ITEM_DISPOSAL_NO_PREFIX . CUR_FISCALYEAR;
        }

        $this->data['disposal_code'] = $this->general->generate_invoiceno('asde_disposalno', 'asde_disposalno', 'asde_assetdesposalmaster', $invoice_no_prefix, ITEM_DISPOSAL_NO_LENGTH, false, 'asde_locationid');

        $this->data['fiscal_year']  = $this->general->get_tbl_data('*', 'fiye_fiscalyear', false, 'fiye_fiscalyear_id', 'DESC', 2);
        $this->data['desposaltype'] = $this->general->get_tbl_data('*', 'dety_desposaltype', array('dety_isactive' => 'Y'), 'dety_detyid', 'ASC');

        if ($reload == 'reload') {
            $this->load->view('auction_disposal/v_auction_disposal_form', $this->data);
        } else {
            $seo_data = '';
            if ($seo_data) {

                //set SEO data

                $this->page_title = $seo_data->page_title;

                $this->data['meta_keys'] = $seo_data->meta_key;

                $this->data['meta_desc'] = $seo_data->meta_description;

            } else {
                $this->page_title        = ORGA_NAME;
                $this->data['meta_keys'] = ORGA_NAME;
                $this->data['meta_desc'] = ORGA_NAME;
            }

            $this->data['breadcrumb'] = 'Sales/Disposal Entry';
            $this->data['tab_type']   = "entry";
            $this->session->unset_userdata('id');
            $this->page_title = 'Assets Assets';
            $this->template
                ->set_layout('general')
                ->enable_parser(false)
                ->title($this->page_title)
                ->build('auction_disposal/v_auction_disposal_common', $this->data);
        }
    }

    public function summary(){
        $this->data['fiscal_year']  = $this->general->get_tbl_data('*', 'fiye_fiscalyear', false, 'fiye_fiscalyear_id', 'DESC', 2);
        $this->data['desposaltype'] = $this->general->get_tbl_data('*', 'dety_desposaltype', array('dety_isactive' => 'Y'), 'dety_detyid', 'ASC');
        $this->data['tab_type'] = 'summary';
        
        $seo_data = '';
        if ($seo_data) {
            $this->page_title = $seo_data->page_title;
            $this->data['meta_keys'] = $seo_data->meta_key;
            $this->data['meta_desc'] = $seo_data->meta_description;
        } else {
            $this->page_title = ORGA_NAME;
            $this->data['meta_keys'] = ORGA_NAME;
            $this->data['meta_desc'] = ORGA_NAME;
        }

        $this->template
            ->set_layout('general')
            ->enable_parser(FALSE)
            ->title($this->page_title)
            ->build('auction_disposal/v_auction_disposal_common', $this->data);
    }

    public function detail()

    {

        $this->data['desposaltype']=$this->general->get_tbl_data('*','dety_desposaltype',array('dety_isactive'=>'Y'),'dety_detyid','ASC');

        $this->data['department_list']=$this->general->get_tbl_data('dept_depid,dept_depname','dept_department',array('dept_isactive'=>'Y'),'dept_depid','ASC');

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

        $this->data['breadcrumb']='Auction/Disposal Detail';

        $this->data['tab_type']="detail";

        $this->session->unset_userdata('id');

        $this->page_title='Auction/Disposal Detail';

        $this->template

            ->set_layout('general') 

            ->enable_parser(FALSE)

            ->title($this->page_title)

            ->build('auction_disposal/v_auction_disposal_common', $this->data);

    }

    public function get_detail_list()
    {   
        if(MODULES_VIEW=='N'){
            $array=array();
            echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));            
            exit;
        }
        $useraccess= $this->session->userdata(USER_ACCESS_TYPE);
        $i = 0;
        $data = $this->auction_disposal_mdl->get_action_disposal_detail_list(false);
        // echo "<pre>";
        // print_r ($data);
        // echo "</pre>";
        // die;
        $array = array();
        $filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
        $totalrecs = $data["totalrecs"];
        unset($data["totalfilteredrecs"]);
        unset($data["totalrecs"]);
        foreach($data as $row) 
        {   
            $array[$i]['id'] = $row->asde_assetdesposalmasterid;
            $array[$i]['date_ad'] = $row->asde_desposaldatead;
            $array[$i]['date_bs'] = $row->asde_deposaldatebs;
            $array[$i]['disposal_type']=$row->dety_name;
            $array[$i]['itemcode']=$row->itli_itemcode;
            $array[$i]['itemname']=$row->itli_itemname; 
            $array[$i]['purchase_qty']=$row->asdd_purchaseqty;
            $array[$i]['disposal_qty']=$row->asdd_disposalqty;
            $array[$i]['sales_amount']=$row->asdd_sales_amount;
            $array[$i]['remarks']=$row->asdd_remarks;  
            $array[$i]['action']=''; 
            $i++;
        }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));

    }   

    public function get_summary_list(){
        
        if(MODULES_VIEW=='N'){

        $array=array();

        echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));            

        exit;

        }

        $useraccess= $this->session->userdata(USER_ACCESS_TYPE);
        $i = 0;
        $data = $this->auction_disposal_mdl->get_auction_disposal_summary_list(false);
        $array = array();
        $filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
        $totalrecs = $data["totalrecs"];
        unset($data["totalfilteredrecs"]);
        unset($data["totalrecs"]);

        foreach($data as $row) 
        {   
            $array[$i]['id'] = $row->asde_assetdesposalmasterid;
            $array[$i]['datead']=$row->asde_desposaldatead;
            $array[$i]['datebs']=$row->asde_deposaldatebs;  
            $array[$i]['disposal_type']=$row->dety_name;
            $array[$i]['disposal_no']=$row->asde_disposalno;    
            $array[$i]['customer_name']=$row->asde_customer_name;
            $array[$i]['grand_total']=$row->asdd_sales_totalamt;
            $array[$i]['sales_cost']=$row->asdd_sales_amount;  
            $array[$i]['item_count']=$row->item_count;  
            $array[$i]['action']='<a href="javascript:void(0)" class="view" data-id='.$row->asde_assetdesposalmasterid.' title="View" data-viewurl="'.base_url("stock_inventory/auction_disposal/show_summary_view").'" title="Auction/Desposal Summary View" data-heading="Auction/Desposal Summary View"><i class="fa fa-eye"></i></a>&nbsp;'; 
            $i++;
        }

        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));

    }

    public function show_summary_view()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $this->input->post('id');
        if($id){ 

            $this->data['sales_disposal_master']=$this->assets_sales_desposal_mdl->get_sales_desposal_master_data(array('asde.asde_assetdesposalmasterid'=>$id));

            $template='';

            if($this->data['sales_disposal_master']>0){
                $this->data['sales_disposal_detail'] =  $this->assets_sales_desposal_mdl->get_sales_desposal_detail_data(array('asdd.asdd_assetdesposalmasterid'=>$id));
                $template=$this->load->view('auction_disposal/v_auction_disposal_summary_view',$this->data,true);
                print_r(json_encode(array('status'=>'success','message'=>'','tempform'=>$template)));

                exit;

            } else{
                print_r(json_encode(array('status'=>'error','message'=>'')));
                exit;
            }
            print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','tempform'=>$template)));
            exit;   
            }

        }

        else{

        print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        exit;

        }
    }

    public function re_print_auction_disposal()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $this->input->post('id');
        if($id){ 

            $this->data['disposal_master']=$this->assets_sales_desposal_mdl->get_sales_desposal_master_data(array('asde.asde_assetdesposalmasterid'=>$id));

            $template='';

            if($this->data['disposal_master']>0){
                $this->data['disposal_detail'] =  $this->assets_sales_desposal_mdl->get_sales_desposal_detail_data(array('asdd.asdd_assetdesposalmasterid'=>$id));
                // echo "<pre>";
                // print_r ($this->data);
                // echo "</pre>";
                // die;
                $template=$this->load->view('auction_disposal/v_auction_disposal_print',$this->data,true);
            print_r(json_encode(array('status' => 'success', 'message' => '', 'tempform' => $template)));
            exit;
            }
            
        }
            print_r(json_encode(array('status'=>'error','message'=>'No Data Available')));
            exit;
        }else{

        print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        exit;

        }
    }

    public function save_auction_disposal($print = false){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            if($this->input->post('id'))
            {
                if(MODULES_UPDATE=='N')
                {
                    $this->general->permission_denial_message();
                    exit;
                }
                $action_log_message = "edit";
            }
            else
            {
                if(MODULES_INSERT=='N')
                {
                    $this->general->permission_denial_message();
                    exit;
                }
                $action_log_message = "";
            }

            $this->form_validation->set_rules($this->auction_disposal_mdl->validate_settings_auction_disposal);
            if($this->form_validation->run()==TRUE){  
                $print_report='';
                $trans = $this->auction_disposal_mdl->auction_disposal_save();
                if($trans){     
                    if($print == "print")
                    {   
                        $this->data['disposal_master']=$this->assets_sales_desposal_mdl->get_sales_desposal_master_data(array('asde.asde_assetdesposalmasterid'=>$trans));

                        if($this->data['disposal_master']>0){
                        $this->data['disposal_detail'] =  $this->assets_sales_desposal_mdl->get_sales_desposal_detail_data(array('asdd.asdd_assetdesposalmasterid'=>$trans));
                        }
                
                    $print_report=$this->load->view('auction_disposal/v_auction_disposal_print',$this->data,true);
                    print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully.', 'print_report'=>$print_report)));
                    exit;
                    }
                    print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully.')));
                    exit;
                }
                else{

                    print_r(json_encode(array('status'=>'error','message'=>'Unsuccessful Operation.')));
                    exit;
                }
            }
            else
            {
                print_r(json_encode(array('status'=>'error','message'=>validation_errors())));
                exit;
            }

        } catch (Exception $e) {

            print_r(json_encode(array('status'=>'error','message' => $e->getMessage())));

        }

    }else{

        print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        exit;

        }
    }

    public function item_list_record()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->unknown = 'N';
            $this->data            = array();
            $this->data['rowno']   = $this->input->post('id');
            $this->data['storeid'] = $this->input->post('storeid');
            $this->data['type']    = $this->input->post('type');
            // if(MODULES_VIEW=='N')
            //     {
            //     $this->general->permission_denial_message();
            //     exit;
            //     }
            $template = '';
            $template = $this->load->view('auction_disposal/v_item_list_popup', $this->data, true);
            print_r(json_encode(array('status' => 'success', 'message' => 'Successfully Selected!!', 'template' => $template, 'tempform' => $template)));
            exit;
        } else {
            print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));
            exit;
        }
    }

    public function get_item_list_for_auction_disposal($rowno = false, $storeid = false, $type = false)
    {
        $get     = $_GET;
         $distype=!empty($get['distype'])?$get['distype']:'';
         if($distype==1){
            $type    = 2;
         }else{
            $type    = '';
         }
        
        $storeid = !empty($storeid) ? $storeid : $this->session->userdata(STORE_ID);

        $useraccess = $this->session->userdata(USER_ACCESS_TYPE);
        $orgid      = $this->session->userdata(ORG_ID);
        if (!empty($type)) {
            $srchcol = array('itli_materialtypeid' => $type);
        } else {
            $srchcol = false;
        }

        $data = $this->auction_disposal_mdl->get_db_item_list_form_master_table($srchcol, $storeid);
        // echo $this->db->last_query();
        // die();
        
        $i            = 0;
        $array        = array();
        $filtereddata = ($data["totalfilteredrecs"] > 0 ? $data["totalfilteredrecs"] : $data["totalrecs"]);
        $totalrecs    = $data["totalrecs"];

        unset($data["totalfilteredrecs"]);
        unset($data["totalrecs"]);

        foreach ($data as $row) {
            $statusClass             = "";
            $array[$i]["rowno"]      = $rowno;
            $array[$i]["itemlistid"] = $row->trde_itemsid;
            $array[$i]["itemcode"]   = $row->itli_itemcode;
            $array[$i]["itemname"]   = $row->itli_itemname;
            $array[$i]["itemnamenp"] = $row->itli_itemname;
            if (ITEM_DISPLAY_TYPE == 'NP') {
                $array[$i]["itemname_display"] = !empty($row->itli_itemname) ? $row->itli_itemname : $row->itli_itemname;
            } else {
                $array[$i]["itemname_display"] = !empty($row->itli_itemname) ? $row->itli_itemname : '';
            }

            $array[$i]["purqty"]       = $row->purqty;
            $array[$i]["dep_issqty"]   = $row->dep_issqty;
            $array[$i]["remqty"]       = $row->remqty;
            $array[$i]["category"]     = $row->eqca_category;
            $array[$i]["statusClass"]  = $statusClass;
            $array[$i]["purchaserate"] = $row->purrate;
            $array[$i]["unitname"]     = $row->unit_unitname;
            $array[$i]["unitid"]       = $row->unit_unitid;
            $array[$i]["mattypeid"]       = $row->itli_materialtypeid;
            $i++;
        }
        echo json_encode(array("recordsFiltered" => $filtereddata, "recordsTotal" => $totalrecs, "data" => $array));
    }

    public function excel_export_detail(){
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=sales_disposal_detail".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");
         $this->data['searchResult'] = $this->auction_disposal_mdl->get_action_disposal_detail_list(false);
        // $this->data['searchResult'] = $this->assets_sales_desposal_mdl->get_sales_disposal_detail_list(false);
        $array = array();
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);
        $response = $this->load->view('auction_disposal/v_auction_disposal_detail_download', $this->data, true);
        echo $response;
    }

    public function pdf_export_detail()
    {
        $this->data['searchResult'] = $this->auction_disposal_mdl->get_action_disposal_detail_list(false);
        // $this->data['searchResult'] = $this->assets_sales_desposal_mdl->get_sales_disposal_detail_list(false);
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);
        $html = $this->load->view('auction_disposal/v_auction_disposal_detail_download', $this->data, true);
        $filename = 'sales_disposal_detail'. date('Y_m_d_H_i_s') . '_.pdf'; 
        $pdfsize = 'A4-L'; //A4-L for landscape
        //if save and download with default filename, send $filename as parameter
        $this->general->generate_pdf($html,false,$pdfsize);
        exit();
    }
}