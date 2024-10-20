<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Job_operation extends CI_Controller
{
    function __construct()
    {
      
        parent::__construct();
        $this->load->Model('job_operation_mdl');
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

        if($analysis_type)
        {
            $this->data['tab_type']='job_operation';
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
            ->build('job_operation/v_report_common', $this->data);
    }

    public function job_operation_details(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(MODULES_VIEW=='N')
            {
                
                print_r(json_encode(array('status'=>'error','message'=>$this->general->permission_denial_message())));
                exit;
            }

            $template = $this->job_operation_data();
           
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

    public function job_operation_data(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
           
            $this->data['excel_url'] = "reports/job_operation/generate_job_operation_excel";
            $this->data['pdf_url'] = "reports/job_operation/generate_job_operation_pdf";

            $this->data['report_title'] ="Job Operation Report";

            $frmDate=$this->input->post('fromdate');
            $toDate=$this->input->post('todate');
            $locationid = $this->input->post('locationid');
            $month = $this->input->post('month');
            $year = $this->input->post('year');

            $this->data['get_job_operation'] = $this->job_operation_mdl->get_job_operation_report('job_operation');
           
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

            if(!empty($this->data['get_job_operation'])){
                $template=$this->load->view('job_operation/v_job_operation_list', $this->data,true);
            }else{
                $template='<span class="col-sm-12 alert alert-danger text-center">No Record Found!!!</span>';
            }

            return $template;
        }else{
            print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
            exit;
        }
    }

    public function generate_job_operation_excel()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header("Content-Type: application/xls");    
            header("Content-Disposition: attachment; filename=job_operation_".date('Y_m_d_H_i').".xls");  
            header("Pragma: no-cache"); 
            header("Expires: 0");
            
            $response = $this->job_operation_data();
            if($response){
                echo $response; 
            }
            return false;
        }else{
            print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
            exit;
        }
    }

     public function generate_job_operation_pdf()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $html = $this->job_operation_data();

            $filename = 'job_operation_'. date('Y_m_d_H_i_s') . '_.pdf'; 
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