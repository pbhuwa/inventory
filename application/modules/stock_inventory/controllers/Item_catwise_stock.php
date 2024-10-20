<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Item_catwise_stock extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->Model('item_catwise_stock_mdl');
        $this->locationid=$this->session->userdata(LOCATION_ID);
        $this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
    }
    public function index()
    {
        $this->data['store_type'] = $this->general->get_tbl_data('*', 'eqty_equipmenttype', false, 'eqty_equipmenttypeid', 'ASC');

        $this->data['material_type'] = $this->general->get_tbl_data('*', 'maty_materialtype', false, 'maty_materialtypeid', 'ASC');

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
        $this->template->set_layout('general')->enable_parser(FALSE)->title($this->page_title)->build('item_cat_wise_stock/v_cat_wise_stock', $this->data);
    }

    public function item_catwise_stock_list()
    {
        
            if (MODULES_VIEW == 'N') {
                $array=array();
                // $this->general->permission_denial_message();
                echo json_encode(array(
                    "recordsFiltered" => 0,
                    "recordsTotal" => 0,
                    "data" => $array
                ));
                exit;
            }
        
        $useraccess   = $this->session->userdata(USER_ACCESS_TYPE);
        $i            = 0;

        if($this->location_ismain=='Y'){
             $data         = $this->item_catwise_stock_mdl->get_stock_received_list();
         }else{
             $data         = $this->item_catwise_stock_mdl->get_stock_received_list(array('trma_locationid'=>$this->locationid));
         }
       
        $array        = array();
        $filtereddata = ($data["totalfilteredrecs"] > 0 ? $data["totalfilteredrecs"] : $data["totalrecs"]);
        $totalrecs    = $data["totalrecs"];
        unset($data["totalfilteredrecs"]);
        unset($data["totalrecs"]);
        foreach ($data as $row) {
            $array[$i]["sno"]      = $i + 1;
            $array[$i]["prime_id"] = $row->mattransmasterid;
            $array[$i]['transactiondatead'] = $row->transactiondatead;
            $array[$i]['transactiondatebs'] = $row->transactiondatebs;
            $array[$i]['todepid'] = $row->todepid;
            $array[$i]['fromby'] = $row->fromby;
            $array[$i]['receivedby'] = $row->receivedby;
            $array[$i]['fromdepid'] = $row->fromdepid;
            $array[$i]['issueno'] = $row->issueno;
            $array[$i]['departmentname'] = $row->departmentname;
            $array[$i]['mattransmasterid'] = $row->mattransmasterid;
            $array[$i]['amount'] = $row->amount;
            $array[$i]['reqno'] = $row->reqno;
            $i++;
        }
        echo json_encode(array(
            "recordsFiltered" => $filtereddata,
            "recordsTotal" => $totalrecs,
            "data" => $array
        ));
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
        if($this->location_ismain){
             $searchResult = $this->data['searchResult'] = $this->item_catwise_stock_mdl->get_item_catwise_stock_list();
         }else{
             $searchResult = $this->data['searchResult'] = $this->item_catwise_stock_mdl->get_item_catwise_stock_list(array('trma_locationid'=>$this->locationid));
         }

       

        unset($this->data['searchResult']["totalfilteredrecs"]);
        unset($this->data['searchResult']["totalrecs"]);
        
        $array    = array();
        $response = $this->load->view('item_cat_wise_stock/v_cat_wise_stock_download', $this->data, true);
        echo $response;
    }

    public function generate_pdf()
    {
        $this->data['fromdate'] = !empty($_GET['frmDate'])?$_GET['frmDate']:CURDATE_NP;
        $this->data['todate'] = !empty($_GET['toDate'])?$_GET['toDate']:CURDATE_NP;
        //echo"call";die;

        if($this->location_ismain=='Y'){
            $searchResult = $this->data['searchResult'] = $this->item_catwise_stock_mdl->get_item_catwise_stock_list();
        }else{
            $searchResult = $this->data['searchResult'] = $this->item_catwise_stock_mdl->get_item_catwise_stock_list(array('trma_locationid'=>$this->locationid));
        }
        

        unset($this->data['searchResult']["totalfilteredrecs"]);
        unset($this->data['searchResult']["totalrecs"]);
        $this->load->library('pdf');
        $mpdf = $this->pdf->load();
        ini_set('memory_limit', '256M');
        $html = $this->load->view('item_cat_wise_stock/v_cat_wise_stock_download', $this->data, true);
        $mpdf  = new mPDF('c', 'A4-L');
        if(PDF_IMAGEATEXT == '3')
        {
            $mpdf->SetWatermarkImage(WATER_MARK_IMAGE);
            $mpdf->showWatermarkImage = true;
            $mpdf->showWatermarkText = true;  
            $mpdf->SetWatermarkText(ORGA_NAME);
        }
        if(PDF_IMAGEATEXT == '1')
        {
            $mpdf->SetWatermarkImage(WATER_MARK_IMAGE);
            $mpdf->showWatermarkImage = true;
        } 
        if(PDF_IMAGEATEXT == '2')
        {
            $mpdf->showWatermarkText = true;  
            $mpdf->SetWatermarkText(ORGA_NAME);
        }
        $mpdf = new mPDF('utf-8', 'A4-L');
        $mpdf->SetAutoFont(AUTOFONT_ALL);
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->WriteHTML($html);
        $output = 'item_catwise_stock_' . date('Y_m_d_H_i') . '.pdf';
        $mpdf->Output();
        exit();
    }
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */