<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Stock_received extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->Model('stock_received_mdl');
        $this->locationid=$this->session->userdata(LOCATION_ID);
        $this->location_ismain = $this->session->userdata(ISMAIN_LOCATION);
    }
    public function index()
    {
        $this->data['store_type'] = $this->general->get_tbl_data('*', 'eqty_equipmenttype', false, 'eqty_equipmenttypeid', 'ASC');

        $this->data['material_type'] = $this->general->get_tbl_data('*', 'maty_materialtype', false, 'maty_materialtypeid', 'ASC');

        $this->data['category'] = $this->general->get_tbl_data('*', 'eqca_equipmentcategory', false, 'eqca_category', 'ASC');

        $seo_data                 = '';
        $this->data['tab']='stock_received';
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
        // $this->template->set_layout('general')->enable_parser(FALSE)->title($this->page_title)->build('stock_received/v_stock_received', $this->data);

        $this->template->set_layout('general')->enable_parser(FALSE)->title($this->page_title)->build('stock/v_stock_common_tab', $this->data);
    }

    public function stock_received_list()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (MODULES_VIEW == 'N') {
                $array=array();
                echo json_encode(array("recordsFiltered" => 0, "recordsTotal" => 0, "data" => $array));
                exit;
            }
        }
        $useraccess   = $this->session->userdata(USER_ACCESS_TYPE);
        $i            = 0;
       $data  = $this->stock_received_mdl->get_stock_received_list();
        // if($this->location_ismain=='Y'){
        //      $data  = $this->stock_received_mdl->get_stock_received_list();
        // }else{
        //      $data  = $this->stock_received_mdl->get_stock_received_list(array('trma_locationid'=>$this->locationid));
        // }
       
        $array        = array();
        $filtereddata = ($data["totalfilteredrecs"] > 0 ? $data["totalfilteredrecs"] : $data["totalrecs"]);
        $totalrecs    = $data["totalrecs"];
        unset($data["totalfilteredrecs"]);
        unset($data["totalrecs"]);
        foreach ($data as $row) {
            $array[$i]["sno"]      = $i + 1;
            $array[$i]['viewurl']  = base_url() . '/stock_inventory/stock_received/load_stock_received';
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

        $this->data['fromdate'] = !empty($_GET['frmDate'])?$_GET['frmDate']:CURDATE_NP;
        $this->data['todate'] = !empty($_GET['toDate'])?$_GET['toDate']:CURDATE_NP;

        if($this->location_ismain=='Y'){
             $searchResult = $this->data['searchResult'] = $this->stock_received_mdl->get_stock_received_list();
         }else{
             $searchResult = $this->data['searchResult'] = $this->stock_received_mdl->get_stock_received_list(array('trma_locationid'=>$this->locationid));
         }

        unset($this->data['searchResult']["totalfilteredrecs"]);
        unset($this->data['searchResult']["totalrecs"]);
        
        $array    = array();
        $response = $this->load->view('stock_received/v_stock_received_download', $this->data, true);
        echo $response;
    }

    public function generate_pdf()
    {
        $this->data['fromdate'] = !empty($_GET['frmDate'])?$_GET['frmDate']:CURDATE_NP;
        $this->data['todate'] = !empty($_GET['toDate'])?$_GET['toDate']:CURDATE_NP;

        if($this->location_ismain=='Y'){
            $searchResult = $this->data['searchResult'] = $this->stock_received_mdl->get_stock_received_list(); 
        }else{

             $searchResult = $this->data['searchResult'] = $this->stock_received_mdl->get_stock_received_list(array('trma_locationid'=>$this->locationid));
        }

       

        unset($this->data['searchResult']["totalfilteredrecs"]);
        unset($this->data['searchResult']["totalrecs"]);
        $this->load->library('pdf');
        $mpdf = $this->pdf->load();
        ini_set('memory_limit', '256M');
        $html = $this->load->view('stock_received/v_stock_received_download', $this->data, true);
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
        $output = 'stock_received_' . date('Y_m_d_H_i') . '.pdf';
        $mpdf->Output();
        exit();
    }

    public function load_stock_received()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $id                        = $this->input->post('id');
                // echo $id;
                // die();
                $this->data['stock_received'] = $this->stock_received_mdl->get_stock_received_by_id(array(
                    'mtd.trde_trmaid' => $id
                ));
                $tempform                  = $this->load->view('stock_received/v_stock_received_modal', $this->data, true);
                if (!empty($tempform)) {
                    print_r(json_encode(array(
                        'status' => 'success',
                        'message' => 'You Can view',
                        'tempform' => $tempform
                    )));
                    exit;
                } else {
                    print_r(json_encode(array(
                        'status' => 'error',
                        'message' => 'Unable to View!!'
                    )));
                    exit;
                }
            }
            catch (Exception $e) {
                print_r(json_encode(array(
                    'status' => 'error',
                    'message' => $e->getMessage()
                )));
            }
        } else {
            print_r(json_encode(array(
                'status' => 'error',
                'message' => 'Cannot Perform this Operation'
            )));
            exit;
        }
    }
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */