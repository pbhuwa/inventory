<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// ini_set('max_execution_time', 50000);

class Assets_handover extends CI_Controller 

{

  function __construct() 

  {  

    parent::__construct();
  

    $this->load->model('assets_mdl');
    $this->load->model('assets_handover_mdl');
 
    $this->curtime = $this->general->get_currenttime();
    $this->userid = $this->session->userdata(USER_ID);
    $this->username = $this->session->userdata(USER_NAME);
    $this->userdepid = $this->session->userdata(USER_DEPT); //storeid
    $this->mac = $this->general->get_Mac_Address();
    $this->ip = $this->general->get_real_ipaddr();
    $this->locationid=$this->session->userdata(LOCATION_ID);
    $this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
    $this->orgid=$this->session->userdata(ORG_ID);

  }     

  public function index($reload=false){ 

    // echo "Asd";

    // die();

    $this->data['department_list']=$this->general->get_tbl_data('*','dept_department',false);

    $this->data['assetentry_list']=array();

     $this->data['receiver_list'] = $this->general->get_tbl_data('*','stin_staffinfo',array('stin_jobstatus' => 'Y'));

  



    $this->data['tab_type']="assets_handover";

    $this->page_title='Assets Handover ';

    if($reload=='reload'){
      $this->data['loadselect2']='Y';
      $this->load->view('assets_report/assets_report_pages/ku/v_assets_handover_mainpages',$this->data);

    }else{
       $this->template

      ->set_layout('general')

      ->enable_parser(FALSE)

      ->title($this->page_title)

      ->build('assets_report/v_report_main', $this->data);
    }

   

  }


public function search_assets_record_by_staff()
{
  $operation=$this->input->post('operation');

  if($operation=='view' || $operation=='update' ){

    $refno=$this->input->post('refno');
    if(empty($refno)){
      print_r(json_encode(array('status'=>'success','template'=>'<span class="text-danger alert">Refno field is required</span>','message'=>'Selected')));
      exit; 
    }
    if($refno) {
     $this->data['handover_master_data']=$this->assets_handover_mdl->get_handover_master_data(array('ashm_refno'=>$refno,'ashm_locationid'=>$this->locationid));
     if(!empty($this->data['handover_master_data'])){
      $masterid=!empty($this->data['handover_master_data'][0]->ashm_id)?$this->data['handover_master_data'][0]->ashm_id:'';
      $this->data['handover_detail_data']=$this->assets_handover_mdl->get_handover_detail_data(array('ashd_assethandovermasterid'=>$masterid));  
      $tempform='<div class="white-box pad-5 mtop_10 pdf-wrapper " style="border: 5px solid #d8cfcf !important;">';
      if (!empty($this->data['handover_master_data'])) {
            $tempform .= $this->load->view('assets_handover/v_assets_handover_summary_view',$this->data,true);
        } else {
          $tempform .= '<label>No Record Found !!</label>';
        } 
        $tempform .= '</div>';
     }
     // echo "<pre>";
     // print_r($this->data['handover_master_data']);
     // die();
     
      
        
      }

  }else{
      $this->data=array();
        $asen_staffid=$this->input->post('staffid');
        if(empty($asen_staffid)){
            print_r(json_encode(array('status'=>'success','template'=>'<span class="text-danger alert">Receiver field is required</span>','message'=>'Selected')));

            exit; 
        }
        $limit=$this->input->post('limit');
        $_POST['limit']=$limit;
        $this->data['fiscal'] = $this->general->get_tbl_data('*', 'fiye_fiscalyear', false, 'fiye_fiscalyear_id', 'DESC', '2');
        $this->data['asen_staffid']=$asen_staffid;
        $data = $this->assets_mdl->get_all_assets_list_ku();
         unset($data["totalfilteredrecs"]);
         unset($data["totalrecs"]);

         $this->data['staff_assets_record']=$data;
        $this->data['receiver_list'] = $this->general->get_tbl_data('*','stin_staffinfo',array('stin_jobstatus' => 'Y'));
             $this->data['refno']=$this->assets_handover_mdl->get_handover_refno();

        // echo "<pre>";
        // print_r($this->data['staff_assets_record']);
        // die();
            if(empty($this->data['staff_assets_record'])){
                $tempform= '<label class="alert alert-danger">No one asset for this staff name !!!</label>';
            }
            else{
                  $tempform= $this->load->view('assets_handover/v_assets_record_list_by_staff',$this->data,true);
            }

  }

        print_r(json_encode(array('status'=>'success','template'=>$tempform,'message'=>'Selected')));
            exit; 
   }

  public function save_handover_assets($print = false){

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // echo "<pre>";
      // print_r($this->input->post());
      // die();
      $handover_from_staffid=$this->input->post('handoverfromstaffid');
      $handover_to_staffid=$this->input->post('handoverstaffid');
      $asen_asenid=$this->input->post('asen_asenid');

      if($handover_from_staffid==$handover_to_staffid){
         print_r(json_encode(array('status'=>'error','message'=>'Same staff couldnot be handover!!')));
                  exit;
      }
      if(empty( $asen_asenid)){
          print_r(json_encode(array('status'=>'error','message'=>'Please choose at leat one assets !!!')));
                  exit;
      }
        $trans=$this->assets_handover_mdl->save_handover_record();
        if($trans)
            {
               $template='';
              if ($print == "print") {
                $this->data['handover_master_data']=$this->assets_handover_mdl->get_handover_master_data(array('ashm_id'=>$trans));
                $this->data['handover_detail_data']=$this->assets_handover_mdl->get_handover_detail_data(array('ashd_assethandovermasterid'=>$trans));
                $this->data['report_title']='Assets Handover Record';
                  $template = $this->load->view('assets_handover/v_assets_handover_record_print', $this->data, true);
              }
              print_r(json_encode(array('status'=>'success','message'=>'Record Saved Successfully', 'print_report' => $template)));
                  exit;
            }else{

              print_r(json_encode(array('status'=>'error','message'=>'Error While saving Data')));
                  exit;
            }
  }
  else{
      print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
      exit;
    }
 }

 public function re_print_assets_handover(){
  $mid=!empty($_GET['mid'])?$_GET['mid']:'';
  $masterid=$this->input->post('id');
  $this->data['print_active']='';
  if(!empty($mid)){
      $this->data['print_active']='active';
    $masterid=$mid;
  }
   $this->data['handover_master_data']=$this->assets_handover_mdl->get_handover_master_data(array('ashm_id'=>$masterid));
    $this->data['handover_detail_data']=$this->assets_handover_mdl->get_handover_detail_data(array('ashd_assethandovermasterid'=>$masterid));

    // echo "<pre>";
    // print_r( $this->data['handover_detail_data']);
    // die();
    $this->data['report_title']='Assets Handover Record';

        $template = $this->load->view('assets_handover/v_assets_handover_record_print', $this->data, true);
        if(!empty($mid)){
        echo $template;
        exit;
        }else{
      print_r(json_encode(array('status' => 'success', 'message' => 'Record Save Successfully.', 'tempform' => $template)));

              exit;
        }
        
       
     }

  public function handover_summary(){
  $this->data['tab_type']="assets_handover_summary";
   $this->data['receiver_list'] = $this->general->get_tbl_data('*','stin_staffinfo',array('stin_jobstatus' => 'Y'));
  $this->page_title='Assets Handover Summary';
  $this->template
      ->set_layout('general')

      ->enable_parser(FALSE)

      ->title($this->page_title)

      ->build('assets_report/v_report_main', $this->data);
 
  }

  public function get_assets_handover_summary(){

    // if (MODULES_VIEW == 'N') {
    //   $array = array();
    //   echo json_encode(array("recordsFiltered" => 0, "recordsTotal" => 0, "data" => $array));
    //   exit;
    // }
    $useraccess = $this->session->userdata(USER_ACCESS_TYPE);
    $i = 0;
    $data = $this->assets_handover_mdl->get_assets_hanover_record();
    // echo $this->db->last_query();
    // die();
    $array = array();
    $filtereddata = ($data["totalfilteredrecs"] > 0 ? $data["totalfilteredrecs"] : $data["totalrecs"]);
    $totalrecs = $data["totalrecs"];
    unset($data["totalfilteredrecs"]);
    unset($data["totalrecs"]);

    // echo "<pre>";
    // print_r($data);
    // die();

    foreach ($data as $row) {
      $array[$i]['id'] = $row->ashm_id;
      $array[$i]['fyear'] = $row->ashm_fyear;
      $array[$i]['refno'] = $row->ashm_refno;
       $array[$i]['handoverdatead'] = $row->ashm_handoverdatead;
       $array[$i]['handoverdatebs'] = $row->ashm_handoverdatebs;
      if(DEFAULT_DATEPICKER=='NP'){
       
        $array[$i]['entrydate'] = $row->ashm_postdatead;
      }else{
        
        $array[$i]['entrydate'] = $row->ashm_postdatebs;
      }
      $array[$i]['fromstaffname'] = $row->ashm_fromstaffname;
      $array[$i]['tostaffname'] = $row->ashm_tostaffname;
      $array[$i]['assetcount'] = $row->ashm_assetcount;
      $array[$i]['remarks'] = $row->ashm_remarks;
      $array[$i]['action'] = '<a href="javascript:void(0)" class="view" data-id=' . $row->ashm_id . ' title="View" data-viewurl="' . base_url("/ams/assets_handover/get_assets_handover_data_by_id") . '" title="View Assets handover Summary" data-heading="Assets handover Summary"><i class="fa fa-eye"></i></a>&nbsp;<a href="'.base_url("/ams/assets_handover/re_print_assets_handover?mid=$row->ashm_id").'" class="" target="_blank" data-id=' . $row->ashm_id . ' title="Print"  title="Print Assets handover Summary" data-heading="Print handover Summary"><i class="fa fa-print"></i></a>';
      $i++;
    }
    $get = $_GET;
    echo json_encode(array("recordsFiltered" => $filtereddata, "recordsTotal" => $totalrecs, "data" => $array));
  }

  public function get_assets_handover_data_by_id()
  {
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $id = $this->input->post('id');

        if ($id) {
       $this->data['handover_master_data']=$this->assets_handover_mdl->get_handover_master_data(array('ashm_id'=>$id));
       // echo "<pre>";
       // print_r($this->data['handover_master_data']);
       // die();
       $this->data['handover_detail_data']=$this->assets_handover_mdl->get_handover_detail_data(array('ashd_assethandovermasterid'=>$id));     
        $template = '';
          if (!empty($this->data['handover_master_data'])) {
              $template = $this->load->view('assets_handover/v_assets_handover_summary_view',$this->data,true);
          } else {
            $template = '';
          }
          print_r(json_encode(array('status' => 'success', 'message' => '', 'tempform' => $template)));
    

          exit;
        }
      }
       else {

        print_r(json_encode(array('status' => 'error', 'message' => 'Cannot Perform this Operation')));

        exit;
      }
    
  }

 }



?>