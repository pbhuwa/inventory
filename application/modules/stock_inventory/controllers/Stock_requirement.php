<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Stock_requirement extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->Model('stock_requirement_mdl');
    }
    public function index()
    {
        // $this->data['stock_requirement_list'] = $this->stock_requirement_mdl->get_stock_requirement_list();

        $this->data['stock_requirement_list'] = "";

        $seo_data                 = '';
        $this->data['tab']='stock_requirement';
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
        // $this->template->set_layout('general')->enable_parser(FALSE)->title($this->page_title)->build('stock_requirement/v_stock_requirement', $this->data);
          $this->template->set_layout('general')->enable_parser(FALSE)->title($this->page_title)->build('stock/v_stock_common_tab', $this->data);
    }

    public function stock_requirement_list()
    {
        if(MODULES_VIEW=='N')
            {        
                print_r(json_encode(array('status'=>'error','message'=>$this->general->permission_denial_message())));
                exit;
            }
        $frmDate = $this->input->post('frmDate');

        $date_array = explode('/', $frmDate);
        $month_no = $date_array[1]; 
        
        $month_no_1 = $month_no_2 = '';
        if($month_no == '1'){
            $month_no_1 = '12';
            $month_no_2 = '11';
        }else if($month_no == '2'){
            $month_no_1 = '1';
            $month_no_2 = '12';
        }else{
            $month_no_1 =  $month_no - 2;
            $month_no_2 =  $month_no - 1 ;
        }

        if(DEFAULT_DATEPICKER == 'NP'){
            $monthname = $this->general->getNepaliMonth($month_no);
            $monthname_1 = $this->general->getNepaliMonth($month_no_1);
            $monthname_2 = $this->general->getNepaliMonth($month_no_2);
        }else{
            $monthname = date('F',strtotime("2000-$month_no-01"));
            $monthname_1 = date('F',strtotime("2000-$month_no_1-01"));
            $monthname_2 = date('F',strtotime("2000-$month_no_2-01"));
        }

        $this->data['cur_month'] = $monthname;
        $this->data['monthname_1'] = $monthname_1;
        $this->data['monthname_2'] = $monthname_2;

        $this->data['stock_requirement_list'] = $this->stock_requirement_mdl->get_stock_requirement_list($frmDate);

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

        $list = $this->load->view('stock_requirement/v_stock_requirement_table_list', $this->data, true);
        print_r(json_encode(array(
                'status' => 'success',
                'list' => $list
            )));
    }

    public function exportToExcel()
    {
        $frmDate = $this->data['fromdate'] = $this->input->get('frmDate');

        header("Content-Type: application/xls");
        header("Content-Disposition: attachment; filename=stock_requirement_" . date('Y_m_d_H_i') . ".xls");
        header("Pragma: no-cache");
        header("Expires: 0");

        if($frmDate){
            $searchResult = $this->data['searchResult'] = $this->stock_requirement_mdl->get_stock_requirement_list($frmDate);    
        }else{
            $searchResult = array();
        }
        
        $array    = array();
        $response = $this->load->view('stock_requirement/v_stock_requirement_download', $this->data, true);
        echo $response;
    }

    public function generate_pdf()
    {
        $frmDate = $this->data['fromdate'] = $this->input->get('frmDate');

        if($frmDate){
            $searchResult = $this->data['searchResult'] = $this->stock_requirement_mdl->get_stock_requirement_list($frmDate);    
        }else{
            $searchResult = array();
        }
        
        $this->load->library('pdf');
        $mpdf = $this->pdf->load();
        ini_set('memory_limit', '256M');
        $html = $this->load->view('stock_requirement/v_stock_requirement_download', $this->data, true);
        $mpdf  = new mPDF('c', 'A4-L');


        if(PDF_IMAGEATEXT == '3')
        {
            $mpdf->SetWatermarkImage(PDF_WATERMARK);
            $mpdf->showWatermarkImage = true;
            $mpdf->showWatermarkText = true;  
            $mpdf->SetWatermarkText(ORGA_NAME);
        }
        if(PDF_IMAGEATEXT == '1')
        {
            $mpdf->SetWatermarkImage(PDF_WATERMARK);
            $mpdf->showWatermarkImage = true;
        } 
        if(PDF_IMAGEATEXT == '2')
        {
            $mpdf->showWatermarkText = true;  
            $mpdf->SetWatermarkText(ORGA_NAME);
        }

        
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->WriteHTML($html);
        $output = 'stock_requirement_' . date('Y_m_d_H_i') . '.pdf';
        $mpdf->Output();
        exit();
    }
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */