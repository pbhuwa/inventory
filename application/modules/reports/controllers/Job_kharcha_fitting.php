<?php ini_set('max_execution_time', 0); ini_set('memory_limit','2048M');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Job_kharcha_fitting extends CI_Controller
{
    function __construct()
    {
      
        parent::__construct();
        $this->load->Model('job_kharcha_fitting_mdl');
         $this->load->Model('job_kharcha_others_mdl');
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
 
    public function index()
    {
         $this->data['fiscalyrs']=$this->general->getFiscalYear(false,'fiye_fiscalyear_id','DESC');
        $this->data['month']=$this->general->get_tbl_data('*','mona_monthname');

        $this->data['tab_type']='job_kharcha_fitting';

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
            ->build('job_kharcha_fitting/v_report_common', $this->data);
    }

    public function get_job_kharcha_fitting_report(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(MODULES_VIEW=='N')
            {
                
                print_r(json_encode(array('status'=>'error','message'=>$this->general->permission_denial_message())));
                exit;
            }

            $template = $this->job_kharcha_fitting_data();
           
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

    public function job_kharcha_fitting_data(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
           
            $this->data['excel_url'] = "reports/job_kharcha_fitting/generate_job_kharcha_fitting_report_excel";
            $this->data['pdf_url'] = "reports/job_kharcha_fitting/generate_job_kharcha_fitting_report_data_pdf";

            $this->data['report_title'] ="फिटिन्स शिर्षगत जिन्सी खर्च विवरण (फिटिन्स तथा पाइप)";

            $frmDate=$this->input->post('fromdate');
            $toDate=$this->input->post('todate');
            $locationid = $this->input->post('locationid');
            $month = $this->input->post('month');
            $fiscalyrs = $this->input->post('fiscalyrs');

              $frmDate=$this->input->post('fromdate');
            $toDate=$this->input->post('todate');
            $locationid = $this->input->post('locationid');
            $month = $this->input->post('month');
            $fiscalyrs = $this->input->post('fiscalyrs');

            $catlist=$this->general->get_tbl_data('eqca_equipmentcategoryid,eqca_equiptypeid,eqca_code,eqca_category','eqca_equipmentcategory',false,'eqca_order','ASC');

            // echo "<pre>";
            // print_r($catlist);
            // die();
            $loc_var='';
            if($locationid){
                $loc_var=$locationid;
            }
            $tempfn='';
            if(!empty($catlist)){
                foreach ($catlist as $kct => $cat) {
                $tempfn.='fn_categorywise_issueitem(sm.sama_salemasterid,'.$cat->eqca_equipmentcategoryid.','.$loc_var.') as catval_'.$cat->eqca_equipmentcategoryid.',';
                }
            }
            $tempfn=rtrim($tempfn, ',');
            // echo $tempfn;
            // die();
            $this->data['catlist']=$catlist;
            $this->data['job_kharcha_fitting_report'] = $this->job_kharcha_others_mdl->get_job_kharcha_others_report($tempfn);

            // echo "<pre>";
            // print_r($this->data['get_job_kharcha_fitting_report']);
            // die();

            // $this->data['get_job_kharcha_fitting_report'] = $this->job_kharcha_fitting_mdl->get_job_fitting_fitting_report();
            ///echo $this->db->last_query();
          //   echo "<pre>";
          //   print_r($this->data['get_capital_exp_report']);
          // die();
           
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

            $this->data['fiscalyrs']=$fiscalyrs;
             // if(!empty($this->data['get_capital_exp_report'])){
                $template=$this->load->view('job_kharcha_fitting/v_job_kharcha_fitting_list', $this->data,true);
            // }else{
            //     $template='<span class="col-sm-12 alert alert-danger text-center">No Record Found!!!</span>';
            // }

            return $template;
        }else{
            print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
            exit;
        }
    }

    public function generate_job_kharcha_fitting_report_excel()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header("Content-Type: application/xls");    
            header("Content-Disposition: attachment; filename=job_kharcha_fitting_".date('Y_m_d_H_i').".xls");  
            header("Pragma: no-cache"); 
            header("Expires: 0");
            
            $response = $this->job_kharcha_fitting_data();
            if($response){
                echo $response; 
            }
            return false;
        }else{
            print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
            exit;
        }
    }

     public function generate_job_kharcha_fitting_report_data_pdf()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $html = $this->job_kharcha_fitting_data();

            $filename = 'job_kharcha_fitting_'. date('Y_m_d_H_i_s') . '_.pdf'; 
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