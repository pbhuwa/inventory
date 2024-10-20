<?php
    ini_set('max_execution_time', 0); 
    ini_set('memory_limit','2048M');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Operational_expense extends CI_Controller
{
    function __construct()
    {
      
        parent::__construct();
        $this->load->Model('operational_expense_mdl');
        $this->username = $this->session->userdata(USER_NAME);
        $this->deptid = $this->session->userdata(USER_DEPT);
        $this->userid = $this->session->userdata(USER_ID);
        $this->locationid=$this->session->userdata(LOCATION_ID);
        if(defined('LOCATION_CODE')):
        $this->locationcode=$this->session->userdata(LOCATION_CODE);
        endif;
        $this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
        $this->orgid=$this->session->userdata(ORG_ID);
    }
 
    public function index($analysis_type)
    {
        $this->data['month']=$this->general->get_tbl_data('*','mona_monthname');
      $this->data['fiscalyrs']=$this->general->getFiscalYear(false,'fiye_fiscalyear_id','DESC');

        if($analysis_type)
        {
            $this->data['tab_type']='operational_expense';
        }

        $this->data['apptype'] = '';
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
            ->build('operational_expense/v_report_common', $this->data);
    }

    public function operational_expense_details(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(MODULES_VIEW=='N')
            {
                
                print_r(json_encode(array('status'=>'error','message'=>$this->general->permission_denial_message())));
                exit;
            }

            $template = $this->operational_expense_data();
           
            if(!empty($template))
            {
                print_r(json_encode(array('status'=>'success','message'=>'Selected Successfully','template'=>$template)));
                exit;
            }
            else{
                print_r(json_encode(array('status'=>'success','message'=>'No Record Found!!')));
                exit;
            }
        }else{
            print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
            exit;
        }  
    }

    public function operational_expense_data(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
           
            $this->data['excel_url'] = "reports/operational_expense/generate_operational_expense_excel";
            $this->data['pdf_url'] = "reports/operational_expense/generate_operational_expense_pdf";

            $this->data['report_title'] ="Job Operation Report";

            $frmDate=$this->input->post('fromdate');
            $toDate=$this->input->post('todate');
            $locationid = $this->input->post('locationid');
            $month = $this->input->post('month');
            $year = $this->input->post('year');

            $this->data['get_operational_expense'] = $this->operational_expense_mdl->get_operational_expense_report('operational_expense');
           
           if($this->location_ismain=='Y'){
                if($locationid){
                  $this->data['location']=$this->general->get_tbl_data('loca_name','loca_location',array('loca_locationid'=>$locationid));
              }else{
                $this->data['location'] = 'All';

              }
            }else{
              $this->data['location']=$this->general->get_tbl_data('loca_name','loca_location',array('loca_locationid'=>$this->locationid));
            }
           
            if($month):
                $this->data['month']=$this->general->get_tbl_data('mona_namenp','mona_monthname',array('mona_monthid'=>$month));
            else:
                $this->data['month'] = 'All';
            endif;

            // $this->data['get_operational_expense'] = 'test';

            if(!empty($this->data['get_operational_expense'])){
                $template=$this->load->view('operational_expense/v_operational_expense_list', $this->data,true);
            }else{
                $template='<span class="col-sm-12 alert alert-danger text-center">No Record Found!!!</span>';
            }

            return $template;
        }else{
            print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
            exit;
        }
    }

    public function generate_operational_expense_excel()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header("Content-Type: application/xls");    
            header("Content-Disposition: attachment; filename=operational_expense_".date('Y_m_d_H_i').".xls");  
            header("Pragma: no-cache"); 
            header("Expires: 0");
            
            $response = $this->operational_expense_data();
            if($response){
                echo $response; 
            }
            return false;
        }else{
            print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
            exit;
        }
    }

     public function generate_operational_expense_pdf()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $html = $this->operational_expense_data();

            $filename = 'operational_expense_'. date('Y_m_d_H_i_s') . '_.pdf'; 
            $pdfsize = 'A4-L'; //A4-L for landscape
            //if save and download with default filename, send $filename as parameter
            $this->general->generate_pdf($html,false,$pdfsize);
            
            exit();
        }else{
            print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
            exit;
        }
    }
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */