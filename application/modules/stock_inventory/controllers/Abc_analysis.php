<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Abc_analysis extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->Model('abc_analysis_mdl');
        // $this->load->model('general');
        $this->locationid=$this->session->userdata(LOCATION_ID);
        $this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
    }
    public function index()
    {
        $this->data['receive_analysis'] = "abcsetup";
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
        $this->template->set_layout('general')->enable_parser(FALSE)->title($this->page_title)->build('abc_analysis/v_abc_analysis', $this->data);
    }
    public function abc_setup()
    {
        $this->data['receive_analysis'] = "abcenrty";
        $this->data['absabcsetup'] = $this->general->get_tbl_data('*', 'abse_abcsetup', false, 'abse_abcsetupid', 'ASC');

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
        $this->template->set_layout('general')->enable_parser(FALSE)->title($this->page_title)->build('abc_analysis/v_abc_analysis', $this->data);
    }

    public function abc_analysis_list()
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
            $data= $this->abc_analysis_mdl->get_abc_analysis_list();
        }else{
            $data= $this->abc_analysis_mdl->get_abc_analysis_list(array('sama_locationid'=>$this->locationid));
        }
      
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
            $array[$i]['eqca_category'] = $row->eqca_category;
            $array[$i]['total_issue_qty'] = $row->total_issue_qty;
            $array[$i]['TotalIsseAmt'] = $row->TotalIsseAmt;
            $i++;
        }
        echo json_encode(array(
            "recordsFiltered" => $filtereddata,
            "recordsTotal" => $totalrecs,
            "data" => $array
        ));
    }
    public function form_abc()
    {    
        $this->data['receive_analysis'] = "abcenrty";
        $this->data['absabcsetup'] = $this->general->get_tbl_data('*', 'abse_abcsetup', false, 'abse_abcsetupid', 'ASC');
        $this->load->view('abc_analysis/v_abc_setup_form');
    }

    public function exportToExcel()
    {
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment; filename=abc_analysis_" . date('Y_m_d_H_i') . ".xls");
        header("Pragma: no-cache");
        header("Expires: 0");

        $this->data['fromdate'] = !empty($_GET['frmDate'])?$_GET['frmDate']:CURDATE_NP;
        $this->data['todate'] = !empty($_GET['toDate'])?$_GET['toDate']:CURDATE_NP;

        if($this->location_ismain=='Y'){
           $searchResult = $this->data['searchResult'] = $this->abc_analysis_mdl->get_abc_analysis_list(); 
       }else{
        $searchResult = $this->data['searchResult'] = $this->abc_analysis_mdl->get_abc_analysis_list(array('sama_locationid'=>$this->locationid));
       }

        

        unset($this->data['searchResult']["totalfilteredrecs"]);
        unset($this->data['searchResult']["totalrecs"]);
        
        $array    = array();
        $response = $this->load->view('abc_analysis/v_abc_analysis_download', $this->data, true);
        echo $response;
    }
    public function generate_pdf()
    {
        $this->data['fromdate'] = !empty($_GET['frmDate'])?$_GET['frmDate']:CURDATE_NP;
        $this->data['todate'] = !empty($_GET['toDate'])?$_GET['toDate']:CURDATE_NP;

        if($this->location_ismain=='Y'){
            $searchResult = $this->data['searchResult'] = $this->abc_analysis_mdl->get_abc_analysis_list();
        }
        else{
            $searchResult = $this->data['searchResult'] = $this->abc_analysis_mdl->get_abc_analysis_list(array('sama_locationid'=>$this->locationid));
        }

        

        unset($this->data['searchResult']["totalfilteredrecs"]);
        unset($this->data['searchResult']["totalrecs"]);
        $this->load->library('pdf');
        $mpdf = $this->pdf->load();
        ini_set('memory_limit', '256M');
        $html = $this->load->view('abc_analysis/v_abc_analysis_download', $this->data, true);
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
        $output = 'abc_analysis_' . date('Y_m_d_H_i') . '.pdf';
        $mpdf->Output();
        exit();
    }
    public function save_absvalue()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') 
        {

            if($this->input->post('id'))
                {
                    if(MODULES_UPDATE=='N')
                    {
                        $this->general->permission_denial_message();
                        exit;
                    }
                }
                else
                {
                    if(MODULES_INSERT=='N')
                    {
                        $this->general->permission_denial_message();
                        exit;
                    }
                }
        try {

            $this->form_validation->set_rules($this->abc_analysis_mdl->validate_settings_abc_analysis);
            if($this->form_validation->run()==TRUE)
            {  //echo"<pre>";print_r($this->input->post());die;
                $trans = $this->abc_analysis_mdl->abc_analysis_save();
                if($trans)
                {
                    print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully')));
                    exit;
                }
                else
                {
                    print_r(json_encode(array('status'=>'error','message'=>'Operation Failed.')));
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
        }else
        {
            print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        exit;
        }
    }
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */