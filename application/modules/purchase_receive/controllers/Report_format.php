<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Report_format extends CI_Controller
{
    function __construct()
    {

            parent::__construct();
            $this->load->model('report_mdl');
            $this->storeid = $this->session->userdata(STORE_ID);
        $this->locationid = $this->session->userdata(LOCATION_ID);
        $this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
    }

    public function index($type=false)
    { 
     $this->data['month']=$this->general->get_tbl_data('*','mona_monthname');
     $this->data['fiscalyrs']=$this->general->getFiscalYear(false,'fiye_fiscalyear_id','DESC');
     // echo "<pre>";
     // print_r($this->data['fiscalyrs']);
     // die();

    if($type){
       $this->data['report_type']=$type;
    }
    else{
       $this->data['report_type']='yearly_report';
    }
   $seo_data='';
   if($seo_data)
   {
            //set SEO data
       $this->data['page_title'] = $seo_data->page_title;
       $this->data['meta_keys']= $seo_data->meta_key;
       $this->data['meta_desc']= $seo_data->meta_description;
   }
   else
   {
            //set SEO data
       $this->data['page_title'] = ORGA_NAME;
       $this->data['meta_keys']= ORGA_NAME;
       $this->data['meta_desc']= ORGA_NAME;
   }
   $this->template
   ->set_layout('general')
   ->enable_parser(FALSE)
   ->title($this->data['page_title'])
   ->build('report_format/v_report_format_maintab', $this->data);
}

public function report_generate($report_type=false)
{
        // echo "asdf";die;
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(MODULES_VIEW=='N')
        {

            print_r(json_encode(array('status'=>'error','message'=>$this->general->permission_denial_message())));
            exit;
        }

        $template = $this->get_report_data($report_type);

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

public function generate_pdf($report_type=false)
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $html = $this->get_report_data($report_type);

        $filename = $report_type.'_'. date('Y_m_d_H_i_s') . '_.pdf'; 
            $pdfsize = 'A4-L'; //A4-L for landscape
            $this->general->generate_pdf($html,false,$pdfsize);
            
            exit();
        }else{
            print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
            exit;
        }
    }

    public function generate_excel($report_type=false)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header("Content-Type: application/xls");    
            header("Content-Disposition: attachment; filename=".$report_type."_".date('Y_m_d_H_i').".xls");  
            header("Pragma: no-cache"); 
            header("Expires: 0");
            
            $response = $this->get_report_data($report_type);
            if($response){
                echo $response; 
            }
            return false;
        }else{
            print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
            exit;
        }
    }

    public function get_report_data($report_type=false){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $this->data['excel_url'] = "purchase_receive/report_format/generate_excel/".$report_type;
            $this->data['pdf_url'] = "purchase_receive/report_format/generate_pdf/".$report_type;

            $title=ucwords($report_type);
            if($report_type=='reamaning_fund')
            {
              $title='Current Stock';
            }else if($report_type == 'store_expenses'){
              $title = 'Kharcha Bibaran';
            }
            $output = str_replace('_', ' ', $title);
            $this->data['report_title'] = $output.' ';

            $this->data['fromdate'] = $this->input->post('fromdate');
            $this->data['todate'] = $this->input->post('todate');
            $locationid = $this->input->post('locationid');

            $month = $this->input->post('month');
            $fiscalyrs = $this->input->post('fiscalyrs');
           
         if($this->location_ismain=='Y'){
              if($locationid){
               $this->data['location']=$this->general->get_tbl_data('loca_name','loca_location',array('loca_locationid'=>$locationid));
           }else{
             $this->data['location'] = 'All';

           }
       }else{
           $this->data['location']=$this->general->get_tbl_data('loca_name','loca_location',array('loca_locationid'=>$this->locationid));
       }

      if($report_type=='yearly_report')
      {
        $this->data['fiscalyrs']=$this->input->post('fiscalyrs');
        $this->data['branch_id']=$this->input->post('locationid')?$this->input->post('locationid'):'all';
        $month=$this->input->post('month');
        if($month){

        $fyrs=$this->data['fiscalyrs'];
        if (!empty($fyrs)) {
            $yrs_split = explode('/', $fyrs);
            $yr1 = '2' . $yrs_split[0];
            $yr2 = '20' . $yrs_split[1];
        }

        if ($month >= 4 && $month <= 12) {
            $year = $yr1;
        } else {
            $year = $yr2;
        }
        
        $mnth=$month;
         $yrs_month=sprintf('%s/%02s', $year, $mnth);    
      
        $inp_location=$this->data['branch_id'];
        if($inp_location!='all'){
          $locationid=$inp_location;
        }else{
          $locationid='';
        }

      // echo $fyrs;
      // echo $yrs_month;
      $start_date=$yrs_month.'/01';
      $end_date=$this->general->find_end_of_month($yrs_month);
      // echo $end_date;
      // die();

      $_POST['locationid']=$locationid;
      $_POST['fromdate']=$start_date;
      $_POST['todate']=$end_date;
      // echo "<pre>";
      // print_r($_POST);
      // die();

      $this->data['monthly_income_exp_data']=$this->report_mdl->get_monthly_income_exp_report();
      // echo $this->db->last_query();
      // echo "<pre>";
      // print_r($this->data['monthly_income_exp_data']);
      // die();
     
      $this->data['fiscalyrs']=$fyrs;
      $this->data['monthname']=$this->general->get_monthname($mnth,$mnthtype='np');
      $this->data['loction_id']=$inp_location;
      $this->data['report_title'] = 'मासिक विवरण';

       $template=$this->load->view('report_format/v_monthly_income_exp_report_list', $this->data,true);

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
         $this->data['yearly_rpt']=$this->report_mdl->get_yearly_report();    
         $this->db->query("DROP TEMPORARY TABLE  xw_yearly_income_exp"); 
        }
        
      }
      if($report_type=='store_expenses'){
        if($month):
          $this->data['month']=$this->general->get_tbl_data('mona_namenp','mona_monthname',array('mona_monthid'=>$month));
        else:
            $this->data['month'] = 'All';
        endif;
        $this->data['fiscalyrs']=$fiscalyrs;
        $this->data['store_expenses_rpt']=$this->report_mdl->store_expenses_report();
      }
       if($report_type=='material_income'){
        $this->data['material_income_rpt']=$this->report_mdl->party_ledger_report();
        $this->data['material_return_rpt']=$this->report_mdl->material_return_ledger_report();
        $this->data['handover_rec_rpt']=$this->report_mdl->handover_received_report();
         // echo $this->db->last_query();
          // echo "<pre>";
          // print_r($this->data['material_return_rpt']);
          // die();
       }
       if($report_type=='reamaning_fund'){
        $this->data['current_stock_rpt']=$this->report_mdl->current_stock_report();
       }

      if($report_type=='income'){
        $this->data['fiscalyrs']=$this->input->post('fiscalyrs');
        $this->data['branch_id']=$this->input->post('locationid')?$this->input->post('locationid'):'all';
        $this->data['income_rpt']=$this->report_mdl->get_income_exp_report();
         $this->db->query("DROP TEMPORARY TABLE  xw_yearly_income");
        // echo $this->db->last_query();
        // die();
       }
        if($report_type=='expenses_report'){
           if($month):
                $this->data['month']=$this->general->get_tbl_data('mona_namenp','mona_monthname',array('mona_monthid'=>$month));
            else:
                $this->data['month'] = 'All';
            endif;

            $this->data['fiscalyrs']=$fiscalyrs;
            // if(!empty($this->data['get_store_report'])){
                $template=$this->load->view('report_format/v_expenses_report_list', $this->data,true);

        $this->data['expenses_rpt']=$this->report_mdl->expenses_report();
        $this->data['capital_internal_rpt']=$this->report_mdl->capital_internal_report();
        $this->data['capital_external_rpt']=$this->report_mdl->capital_external_report();
        // echo "<pre>";
        // print_r($this->data['expenses_rpt']);
        // die();
        //  echo $this->db->last_query();
        // die();
       }

   // $report_data=
  //  print_r($this->data);
  //  die();

  if(!empty($this->data['report_title'])){
      $template=$this->load->view('report_format/v_'.$report_type.'_list', $this->data,true);
  }else{
      $template='<span class="col-sm-12 alert alert-danger text-center">No Record Found!!!</span>';
  }

  return $template;
  }else{
      print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
      exit;
  }
}

public function monthly_income_exp()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $inp_data=$this->input->post('inp_data');
      $inparr=explode('@', $inp_data);
      $fyrs='';
      $mnth='';
      $yrs_month='';
      if(!empty($inparr)){
        $fyrs=$inparr[0];
        $inp_yrsmnth=explode('-', $inparr[1]);
        if(!empty($inp_yrsmnth)){
          $yrs=$inp_yrsmnth[0];
          $mnth=$inp_yrsmnth[1];
         $yrs_month=sprintf('%s/%02s', $inp_yrsmnth[0], $inp_yrsmnth[1]);    
        }
        $inp_location=$inparr[2];
        if($inp_location!='all'){
          $locationid=$inp_location;
        }else{
          $locationid='';
        }

      }
      // echo $fyrs;
      // echo $yrs_month;
      $start_date=$yrs_month.'/01';
      $end_date=$this->general->find_end_of_month($yrs_month);
      // echo $end_date;
      // die();

      $_POST['locationid']=$locationid;
      $_POST['fromdate']=$start_date;
      $_POST['todate']=$end_date;
      // echo "<pre>";
      // print_r($_POST);
      // die();

      $this->data['monthly_income_exp_data']=$this->report_mdl->get_monthly_income_exp_report();
      // echo "<pre>";
      // print_r($this->data['monthly_income_exp_data']);
      // die();
      // 

      $this->data['fiscalyrs']=$fyrs;
      $this->data['monthname']=$this->general->get_monthname($mnth,$mnthtype='np');
      $this->data['loction_id']=$inp_location;

       $template=$this->load->view('report_format/v_monthly_income_exp_report_list', $this->data,true);

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

public function daily_income_exp(){
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $inp_data=$this->input->post('id');
      // echo $inp_data;
      // die();
      $inparr=explode('@', $inp_data);
      $fyrs='';
      $mnth='';
      $yrs_month='';
      if(!empty($inparr)){
        $fyrs=$inparr[0];
        $inp_date=$inparr[1];
        $inp_location=$inparr[2];
        if($inp_location!='all'){
          $locationid=$inp_location;
        }else{
          $locationid='';
        }

        $_POST['locationid']=$locationid;
        $_POST['search_date']=$inp_date;
        $_POST['fyrs']=$fyrs;
        $this->data['daily_market_income_master']=$this->report_mdl->daily_market_income_master();
        // echo "<pre>";
        // print_r($this->data['daily_market_income']);
        // die();

         $template=$this->load->view('report_format/v_daily_income_exp_report_list', $this->data,true);

        if(!empty($template))
        {
            print_r(json_encode(array('status'=>'success','message'=>'Selected Successfully','tempform'=>$template)));
            exit;
        }
        else{
            print_r(json_encode(array('status'=>'success','message'=>'No Record Found!!')));
            exit;
        }

      }
 }else{
      print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
      exit;
    }
}

public function monthly_income_only(){
   if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $inp_data=$this->input->post('inp_data');
      $inparr=explode('@', $inp_data);
      $fyrs='';
      $mnth='';
      $yrs_month='';
      if(!empty($inparr)){
        $fyrs=$inparr[0];
        $inp_yrsmnth=explode('-', $inparr[1]);
        if(!empty($inp_yrsmnth)){
          $yrs=$inp_yrsmnth[0];
          $mnth=$inp_yrsmnth[1];
         $yrs_month=sprintf('%s/%02s', $inp_yrsmnth[0], $inp_yrsmnth[1]);    
        }
        $inp_location=$inparr[2];
        if($inp_location!='all'){
          $locationid=$inp_location;
        }else{
          $locationid='';
        }

      }
      // echo $fyrs;
      // echo $yrs_month;
      $start_date=$yrs_month.'/01';
      $end_date=$this->general->find_end_of_month($yrs_month);
      // echo $end_date;
      // die();

      $_POST['locationid']=$locationid;
      $_POST['fromdate']=$start_date;
      $_POST['todate']=$end_date;
      // echo "<pre>";
      // print_r($_POST);
      // die();

      $this->data['monthly_income_data']=$this->report_mdl->get_monthly_income_only_report();
      // echo $this->db->last_query();
      // die();
      // echo "<pre>";
      // print_r($this->data['monthly_income_data']);
      // die();      

      $this->data['fiscalyrs']=$fyrs;
      $this->data['monthname']=$this->general->get_monthname($mnth,$mnthtype='np');
      $this->data['loction_id']=$inp_location;

       $template=$this->load->view('report_format/v_monthly_income_only_report_list', $this->data,true);

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

public function daily_income_only(){
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $inp_data=$this->input->post('id');
      // echo $inp_data;
      // die();
      $inparr=explode('@', $inp_data);
      $fyrs='';
      $mnth='';
      $yrs_month='';
      if(!empty($inparr)){
        $fyrs=$inparr[0];
        $inp_date=$inparr[1];
        $inp_location=$inparr[2];
        if($inp_location!='all'){
          $locationid=$inp_location;
        }else{
          $locationid='';
        }

        $_POST['locationid']=$locationid;
        $_POST['search_date']=$inp_date;
        $_POST['fyrs']=$fyrs;
        $this->data['daily_market_income_master']=$this->report_mdl->daily_market_income_master();
         $this->data['daily_handover_income_master']=$this->report_mdl->daily_market_income_master();
        // echo "<pre>";
        // print_r($this->data['daily_market_income']);
        // die();

         $template=$this->load->view('report_format/v_daily_income_only_report_list', $this->data,true);

        if(!empty($template))
        {
            print_r(json_encode(array('status'=>'success','message'=>'Selected Successfully','tempform'=>$template)));
            exit;
        }
        else{
            print_r(json_encode(array('status'=>'success','message'=>'No Record Found!!')));
            exit;
        }

      }
 }else{
      print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
      exit;
    }
}

}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */