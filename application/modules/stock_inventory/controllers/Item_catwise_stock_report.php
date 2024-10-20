<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Item_catwise_stock_report extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->Model('item_catwise_stock_mdl');
    }
    public function index()
    {
        $this->data['store_type'] = $this->general->get_tbl_data('*', 'eqty_equipmenttype', false, 'eqty_equipmenttypeid', 'ASC');

        $this->data['report_type'] = $this->general->get_tbl_data('*', 'maty_materialtype', false, 'maty_materialtypeid', 'ASC');

        $this->data['category'] = $this->general->get_tbl_data('*', 'eqca_equipmentcategory', false, 'eqca_category', 'ASC');

        $seo_data                 = '';
        if ($seo_data) {
            //set SEO data
            $this->page_title        = $seo_data->page_title;
            $this->data['meta_keys'] = $seo_data->meta_key;
            $this->data['meta_desc'] = $seo_data->meta_description;
        } else {
            //set SEO data
            $this->page_title        = ORGA_NAME;
            $this->data['meta_keys'] = ORGA_NAME;
            $this->data['meta_desc'] = ORGA_NAME;
        }
        $this->template->set_layout('general')->enable_parser(FALSE)->title($this->page_title)->build('item_cat_wise_stock_report/v_item_wise_stock_report', $this->data);
    }

    public function item_cat_wise_report()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') 
        {
            if (MODULES_VIEW == 'N') {
                $array=array();
                echo json_encode(array("recordsFiltered" => 0, "recordsTotal" => 0, "data" => $array));
                exit;
            }
        }
       

        $useraccess   = $this->session->userdata(USER_ACCESS_TYPE);
        $i            = 0;
        
        $data         = $this->item_catwise_stock_mdl->get_item_stock_report();
        // echo "<pre>";
        // echo $this->db->last_query();
        // die();

        $array        = array();
        $filtereddata = ($data["totalfilteredrecs"] > 0 ? $data["totalfilteredrecs"] : $data["totalrecs"]);
        $totalrecs    = $data["totalrecs"];
        unset($data["totalfilteredrecs"]);
        unset($data["totalrecs"]);
        foreach ($data as $row) 
        {
            if(ITEM_DISPLAY_TYPE=='NP'){
                    $req_itemname = !empty($row->itli_itemnamenp)?$row->itli_itemnamenp:$row->itli_itemname;
                }else{ 
                    $req_itemname = !empty($row->itli_itemname)?$row->itli_itemname:'';
                }
                
            $array[$i]["sno"]      = $i + 1;

            $array[$i]['itli_itemcode'] = $row->itli_itemcode;
            $array[$i]['itli_itemname'] = $req_itemname;
            $array[$i]['unit_unitname'] = $row->unit_unitname;
            $array[$i]['opqty'] = round($row->opqty,2);
            $array[$i]['opamount'] = round($row->opamount,2);
            $array[$i]['rec_qty'] = round($row->rec_qty,2);
            $array[$i]['recamount'] = round($row->recamount,2);

            $array[$i]['issQty'] = round($row->issQty,2);
            $array[$i]['isstamt'] = round($row->isstamt,2);
            $array[$i]['balanceqty'] = round($row->balanceqty,2);
            $array[$i]['balanceamt'] = round($row->balanceamt,2);
           
            $i++;
        }
        echo json_encode(array(
            "recordsFiltered" => $filtereddata,
            "recordsTotal" => $totalrecs,
            "data" => $array
        ));
    }
    public function report_print()
    {
        // if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // $id = $this->input->post('id');
                // if($id)
                // { 
        $searchResult = $this->data['searchResult'] = $this->item_catwise_stock_mdl->get_item_stock_report();
                // $this->data['req_detail_list']=$this->direct_purchase_mdl->get_received_details(array('rd.recd_receivedmasterid'=>$id));
                // $this->data['direct_purchase_master']=$this->direct_purchase_mdl->received_master_views(array('rm.recm_receivedmasterid'=>$id));
                    //echo"<pre>";print_r($this->data['req_detail_list']);die();
                    //$template=$this->load->view('purchase/v_print_report_direct_purchase',$this->data,true);
                    $template=$this->load->view('item_cat_wise_stock_report/v_item_wise_stock_print',$this->data,true);
                     // print_r($template);die;
                if($this->data['searchResult']>0)
                {
                    print_r(json_encode(array('status'=>'success','message'=>'','tempform'=>$template)));
                    exit;
                }
                else{
                    print_r(json_encode(array('status'=>'error','message'=>'')));
                        exit;
                }
                    print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','tempform'=>$template)));
                 exit;  
                // }
            // }
            // else
            // {
            //     print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
            //         exit;
            // }
        // }else{
        //     print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        // exit;
        // }
    }
    public function exportToExcel()
    {
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment; filename=stock_received_" . date('Y_m_d_H_i') . ".xls");
        header("Pragma: no-cache");
        header("Expires: 0");
       // echo"call";die;
        $this->data['fromdate'] = !empty($_GET['frmDate'])?$_GET['frmDate']:CURDATE_NP;
        $this->data['todate'] = !empty($_GET['toDate'])?$_GET['toDate']:CURDATE_NP;
        $this->data['store_id'] = !empty($_GET['store_id'])?$_GET['store_id']:'';
        $this->data['material_id'] = !empty($_GET['material_id'])?$_GET['material_id']:'';

        $searchResult = $this->data['searchResult'] = $this->item_catwise_stock_mdl->get_item_stock_report();
       

        unset($this->data['searchResult']["totalfilteredrecs"]);
        unset($this->data['searchResult']["totalrecs"]);
        
        $array    = array();
        $response = $this->load->view('item_cat_wise_stock_report/v_item_wise_stock_print', $this->data, true);
        echo $response;
    }

    public function generate_pdf()
    {
        $this->data['fromdate'] = !empty($_GET['frmDate'])?$_GET['frmDate']:CURDATE_NP;
        $this->data['todate'] = !empty($_GET['toDate'])?$_GET['toDate']:CURDATE_NP;
        $this->data['store_id'] = !empty($_GET['store_id'])?$_GET['store_id']:'';
        $this->data['material_id'] = !empty($_GET['material_id'])?$_GET['material_id']:'';

        //echo"call";die;
        $searchResult = $this->data['searchResult'] = $this->item_catwise_stock_mdl->get_item_stock_report();
       // echo $this->db->last_query(); die;

        unset($this->data['searchResult']["totalfilteredrecs"]);
        unset($this->data['searchResult']["totalrecs"]);
    
        $html = $this->load->view('item_cat_wise_stock_report/v_item_wise_stock_print', $this->data, true);

        $filename = 'item_catwise_stock_'. date('Y_m_d_H_i_s') . '_.pdf'; 
        $pdfsize = 'A4-L'; //A4-L for landscape //if save and download with default filename, send $filename as parameter
        $this->general->generate_pdf($html,false,$pdfsize);

        exit();
    }
    public function generate_pdf_form()
    {

        $searchResult = $this->data['searchResult'] = $this->item_catwise_stock_mdl->get_item_stock_report();
       // echo $this->db->last_query(); die;

        unset($this->data['searchResult']["totalfilteredrecs"]);
        unset($this->data['searchResult']["totalrecs"]);
        $html = $this->load->view('item_cat_wise_stock_report/v_print_form', $this->data, true);
        //$html = $this->search_categorywise_issue_common();
        //echo $this->db->last_query(); die;
        // echo $html;
        // die();
        $filename = 'item_catwise_stock_'. date('Y_m_d_H_i_s') . '_.pdf'; 
        $pdfsize = 'A4-L'; //A4-L for landscape //if save and download with default filename, send $filename as parameter
        $this->general->generate_pdf($html,false,$pdfsize,'no_display'); //no display watermark
        
        
        exit();
    }
    public function generate_pdf_bibaran()
    {
        $searchResult = $this->data['searchResult'] = $this->item_catwise_stock_mdl->get_item_stock_report();
       // echo $this->db->last_query(); die;

        unset($this->data['searchResult']["totalfilteredrecs"]);
        unset($this->data['searchResult']["totalrecs"]);
        $html = $this->load->view('item_cat_wise_stock_report/v_print_bibaran', $this->data, true);
        // echo $html;
        // die();
        //$html = $this->search_categorywise_issue_common();
        //echo $this->db->last_query(); die;
        $filename = 'item_catwise_stock_'. date('Y_m_d_H_i_s') . '_.pdf'; 
        $pdfsize = 'A4-L'; //A4-L for landscape //if save and download with default filename, send $filename as parameter
        $this->general->generate_pdf($html,false,$pdfsize,'no_display'); //no display watermark
        //echo"call";die;
       //  $searchResult = $this->data['searchResult'] = $this->item_catwise_stock_mdl->get_item_stock_report();
       // // echo $this->db->last_query(); die;

       //  unset($this->data['searchResult']["totalfilteredrecs"]);
       //  unset($this->data['searchResult']["totalrecs"]);
        // $this->load->library('pdf');
        // $mpdf = $this->pdf->load();
        // ini_set('memory_limit', '256M');
       //  $html = $this->load->view('item_cat_wise_stock_report/v_print_bibaran', $this->data, true);
        // $mpdf  = new mPDF('c', 'A4-L');
        // if(PDF_IMAGEATEXT == '3')
        // {
        //     $mpdf->SetWatermarkImage(WATER_MARK_IMAGE);
        //     $mpdf->showWatermarkImage = true;
        //     $mpdf->showWatermarkText = true;  
        //     $mpdf->SetWatermarkText(ORGA_NAME);
        // }
        // if(PDF_IMAGEATEXT == '1')
        // {
        //     $mpdf->SetWatermarkImage(WATER_MARK_IMAGE);
        //     $mpdf->showWatermarkImage = true;
        // } 
        // if(PDF_IMAGEATEXT == '2')
        // {
        //     $mpdf->showWatermarkText = true;  
        //     $mpdf->SetWatermarkText(ORGA_NAME);
        // }
        // $mpdf = new mPDF('utf-8', 'A4-L');
        // $mpdf->SetAutoFont(AUTOFONT_ALL);
        // $mpdf->WriteHTML($stylesheet, 1);
        // $mpdf->WriteHTML($html);
        // $output = 'item_catwise_stock_' . date('Y_m_d_H_i') . '.pdf';
        // $mpdf->Output();
        exit();
    }
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */