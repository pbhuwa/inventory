<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Reports extends CI_Controller
{
    function __construct()
    {
            
        parent::__construct();
    $this->load->Model('repair_request_info_mdl');
        $this->load->Model('pm_data_mdl');
        $this->load->Model('settings/department_mdl','department_mdl');
        $this->load->Model('bio_medical_mdl');
    $this->load->Model('equipment_mdl');
    $this->load->Model('distributors_mdl');
    $this->load->Model('department_information_mdl');
    $this->load->Model('purchase_donate_mdl');
    $this->load->Model('pm_completed_mdl');
        $this->load->Model('equipmentwise_report_mdl');
    $this->load->Model('assign_equipement_mdl');
    $this->load->library('zend');
    $this->zend->load('Zend/Barcode');
    $this->load->library('ciqrcode');
    $this->load->Model('settings/users_mdl');
    }

  public function index($status=false)
    {
      $this->data['status']=$status;
      $this->data['equipmentlist']=$this->general->get_tbl_data('eqli_equipmentlistid,eqli_description','eqli_equipmentlist');
       $this->data['department']=$this->department_mdl->get_all_department(array('dept_deptype'=>BIOMEDICALID));

       $this->data['distributor']=$this->general->get_tbl_data('dist_distributorid,dist_distributor','dist_distributors');
       $this->data['purchase']=$this->general->get_tbl_data('pudo_purdonatedid,pudo_purdonated','pudo_purchdonate');
       // print_r($this->data);die();
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
        $this->data['tab_type'] = "equ_reports";
        $this->template
            ->set_layout('general')
            ->enable_parser(FALSE)
            ->title($this->page_title)
            //->build('report/v_report', $this->data);
            ->build('report/v_common_report_tab', $this->data); 
    }

    public function inventoryrpt()
    {
        $data['distinct_department'] =$this->department_mdl->get_all_department(array('dept_deptype'=>BIOMEDICALID));;
        $this->load->library('pdf');
        $mpdf = $this->pdf->load(); 
        // $stylesheet= file_get_contents(CSS_PATH.'template/report/stylereport.css');
            
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

        ini_set('memory_limit', '256M');
        $html = $this->load->view('bio_medical_inventory/v_report_biomedical_inventry', $data, true);
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->WriteHTML($html); 
        
        $output = 'BiomedicalIventory.pdf'; 
        // $mpdf->Output($output, 'D'); 
        $mpdf->Output(); 
        exit();
    }

    public function yearlypmreport()
    {   
        $data['pmReportByDepartment'] = $this->pm_data_mdl->get_pm_report_by_department();
        $this->load->library('pdf');
        $mpdf = $this->pdf->load(); 
        // $stylesheet= file_get_contents(CSS_PATH.'template/report/stylereport.css');
            
        ini_set('memory_limit', '256M');

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

        $html = $this->load->view('pm_data/v_pmreport', $data, true);
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->WriteHTML($html); 
        
        $output = 'yearlyPmreport.pdf'; 
        // $mpdf->Output($output, 'D'); 
         $mpdf->Output(); 
        exit();
    }

   public function get_department_equipment(){

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id=$this->input->post('malo_depid');

            if(!empty($id))

            {

            $this->data['eqip_list']=$this->equipment_mdl->get_all_equipment_detail(array('bm.bmin_departmentid'=>$id));
  //$this->data['eqli_data']=$this->equipment_mdl->get_all_equipment(array('eq.eqli_equipmentlistid'=>$id));
      
            // echo $this->db->last_query();

            // die();

            // echo "<pre>";

             //print_r($this->data['eqip_list']);die;

            if(!empty($this->data['eqip_list']))

                {

                echo json_encode($this->data['eqip_list']);

                }

            else

                {

                    echo json_encode(array());

                }

            }

            else

            {

                echo json_encode('');

            }

        }

        else

        {

        print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

            exit;

        }

    }

   public function get_equipment_code(){

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id=$this->input->post('malo_equipid');

            if(!empty($id))

            {

            $this->data['eqip_list']=$this->equipment_mdl->get_all_equipment_detail(array('bm.bmin_equipid'=>$id));
  //$this->data['eqli_data']=$this->equipment_mdl->get_all_equipment(array('eq.eqli_equipmentlistid'=>$id));
      
            // echo $this->db->last_query();

            // die();

            // echo "<pre>";

            // print_r($this->data['room_list']);die;

            if(!empty($this->data['eqip_list']))

                {

                echo json_encode($this->data['eqip_list']);

                }

            else

                {

                    echo json_encode(array());

                }

            }

            else

            {

                echo json_encode('');

            }

        }

        else

        {

        print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

            exit;

        }

    }

  public function getreport_type($status=false)
  {
      //echo"<pre>";print_r($report);die;
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         $this->data['rpt_type']=$this->input->post('rpttype');
         if($this->data['rpt_type']=='desc'){
         $this->data['equipment_list']=$this->bio_medical_mdl->get_equipmentlist();
         }
         if($this->data['rpt_type']=='dist')
         {
         $this->data['distributor_list']=$this->distributors_mdl->get_distributor_list(); 

         }
         if($this->data['rpt_type']=='dept')
         {
            $this->data['dep_information']=$this->department_mdl->get_all_department(array('dept_deptype'=>BIOMEDICALID));
         }
         if($this->data['rpt_type']=='pur_don')
         {
        
          $this->data['purchase_donate_all'] = $this->purchase_donate_mdl->get_all_purchase_donate();
         }

         $template='';
         $template=$this->load->view('report/v_report_type',$this->data,true);

         // echo $temp;
         // die();
          print_r(json_encode(array('status'=>'success','template'=>$template,'message'=>'Successfully Selected')));
          exit;
         
      }else{
          print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
          exit;
      }

  }

  public function  generate_report($status=false,$is_other=false)
  {
       if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         
          $this->data['print_pdf']='Yes';
          
          $rpt_type=$this->input->post('rpttype');
          $this->data['status']=$status;
           if($status=='decommission')
           {
            $is_rep='Y';

           }
           else
           {
            $is_rep='N';
           }

        // $this->data['biomedical_inv_list']=$this->bio_medical_mdl->get_biomedical_inventory(array('bmin_isunrepairable'=>$is_rep));
        // // echo $this->db->last_query();
        // // die();
        $this->data['distdept']='';
        $groupby='';
        $srch=array('bmin_isunrepairable'=>$is_rep);
        if($rpt_type=='desc')
        {  
          $groupby="eql.eqli_equipmentlistid";
          $descriptionid=$this->input->post('bmin_descriptionid');
          if($descriptionid)
          {
            $srch=array('bmin_descriptionid'=>$descriptionid,'bmin_isunrepairable'=>$is_rep);
            
            //echo"<pre>"; print_r($this->data['distdept']);die;
          }
        }
        if($rpt_type=='dist')
        {  
          $groupby="dis.dist_distributorid";
          $distributorid=$this->input->post('bmin_distributorid');
          if($distributorid)
          {
            $srch=array('bmin_distributorid'=>$distributorid,'bmin_isunrepairable'=>$is_rep);
          }
        }
        if($rpt_type=='dept')
        { $groupby="di.dept_depid";
          $departmentid=$this->input->post('bmin_departmentid');
          if($departmentid)
          {
            $srch=array('bmin_departmentid'=>$departmentid,'bmin_isunrepairable'=>$is_rep);
            
          }
        }
      if($rpt_type=='pur_don')
      {  $groupby="pudo_purdonatedid";
         $purch_donatedid=$this->input->post('bmin_purch_donatedid');
         if($purch_donatedid)
        {
          $srch=array('bmin_purch_donatedid'=>$purch_donatedid,'bmin_isunrepairable'=>$is_rep);
        }

      } 
      if($rpt_type=='amc')
      {   $groupby="bmin_amc";
          $amc=$this->input->post('bmin_amc');
           if($amc)
          {
            $srch=array('bmin_amc'=>$amc,'bmin_isunrepairable'=>$is_rep);
          }
      } 
      if($rpt_type=='manual')
      { 
        $bmin_isoperation=$this->input->post('bmin_isoperation');
         if($bmin_isoperation)
          {
            $srch=array('bmin_isoperation'=>$bmin_isoperation,'bmin_isunrepairable'=>$is_rep);
          }
       
      }   
      $this->data['type'] = $rpt_type;
      //$this->data['biomedical_inv_list']=$this->bio_medical_mdl->get_biomedical_inventory($srch);
      //print_r($groupby);die;
      $this->data['distdept']=$this->bio_medical_mdl->get_allprocurement_list($is_other);
      // get_biomedical_inventory
      //$this->data['distdept']=$this->bio_medical_mdl->get_biomedical_inventory($srch,$gpby);
      //echo $this->db->last_query();die;
      
        //echo "<pre>"; print_r($this->data['distdept']);die();
        $template='';
        $template=$this->load->view('report/v_report_inventory',$this->data,true);

         // echo $temp; die();
         print_r(json_encode(array('status'=>'success','template'=>$template,'message'=>'Successfully Selected')));
          exit;
      }
      else{
          print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
          exit;
      }
  }

  public function generate_allpmreport()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $equid = $this->input->post('equid');
      if($equid)
      {
         $this->data['pm_report']=$this->pm_completed_mdl->get_all_pm_completed_report(array('bmin_equipmentkey'=>$equid));
      }
      else
      {
         $this->data['pm_report']=$this->pm_completed_mdl->get_all_pm_completed_report();
      }
     
      $template='';
      // echo"<pre>"; print_r($this->data['pm_report']);die;
      if($this->data['pm_report'])
      {
      $template=$this->load->view('report/v_pmgeneated_report',$this->data,true);
      }
      else
      {
        $template='<span class="col-sm-12 alert alert-danger text-center" style="margin-top: -25px;">No Record Found!!!</span>';
      }
        // echo $temp; die();
        print_r(json_encode(array('status'=>'success','template'=>$template,'message'=>'Successfully Selected')));
        exit;
    }else{
        print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        exit;
      }
  }
  public function download_bio_medical_rpt()
  {
     
     $this->data['print_pdf']='Yes';
        $rpt_type=$this->input->post('rpttype');
        $this->data['status']=$status;
        $status=$this->input->post('status');
           if($status=='decommission')
           {
            $is_rep='Y';

           }
           else
           {
            $is_rep='N';
           }

        // $this->data['biomedical_inv_list']=$this->bio_medical_mdl->get_biomedical_inventory(array('bmin_isunrepairable'=>$is_rep));
        // // echo $this->db->last_query();
        // // die();
        $this->data['distdept']='';
        $groupby='';
        $srch=array('bmin_isunrepairable'=>$is_rep);
        if($rpt_type=='desc')
        {  
          $groupby="eql.eqli_equipmentlistid";
          $descriptionid=$this->input->post('bmin_descriptionid');
          if($descriptionid)
          {
            $srch=array('bmin_descriptionid'=>$descriptionid,'bmin_isunrepairable'=>$is_rep);
          }
        }
        
        if($rpt_type=='dist')
        {  
          $groupby="dis.dist_distributorid";
          $distributorid=$this->input->post('bmin_distributorid');
          if($distributorid)
          {
            $srch=array('bmin_distributorid'=>$distributorid,'bmin_isunrepairable'=>$is_rep);
          }
        }
        if($rpt_type=='dept')
        {  $groupby="di.dept_depid";
           $departmentid=$this->input->post('bmin_departmentid');
           if($departmentid)
          {
            $srch=array('bmin_departmentid'=>$departmentid,'bmin_isunrepairable'=>$is_rep);
          }

        }
        if($rpt_type=='pur_don')
        {  $groupby="pudo_purdonatedid";
           $purch_donatedid=$this->input->post('bmin_purch_donatedid');
           if($purch_donatedid)
           {
             $srch=array('bmin_purch_donatedid'=>$purch_donatedid,'bmin_isunrepairable'=>$is_rep);
           }

        } 
      if($rpt_type=='amc')
      {   $groupby="bmin_amc";
          $amc=$this->input->post('bmin_amc');
           if($amc)
          {
            $srch=array('bmin_amc'=>$amc,'bmin_isunrepairable'=>$is_rep);
          }
      } 
      if($rpt_type=='manual')
      { 
           $bmin_isoperation=$this->input->post('bmin_isoperation');
         if($bmin_isoperation)
          {
            $srch=array('bmin_isoperation'=>$bmin_isoperation,'bmin_isunrepairable'=>$is_rep);
          }
      }  
      $this->data['type'] = $rpt_type; 
      //$this->data['biomedical_inv_list']=$this->bio_medical_mdl->get_biomedical_inventory($srch);
      $this->data['distdept']=$this->bio_medical_mdl->get_biomedical_inventory($srch,false,false,false,false,$groupby);
      $stylesheet='';
        $this->load->library('pdf');
        $mpdf = $this->pdf->load();
        ini_set('memory_limit', '256M');
        $html = $this->load->view('report/v_report_inventory', $this->data, true);
        $mpdf = new mPDF('c', 'A4-L'); 

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
        $mpdf = new mPDF('utf-8', 'A4-L');
        $mpdf->SetAutoFont(AUTOFONT_ALL);
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->WriteHTML($html);
        $output = 'biomedical_report_of_'.date('Y_m_d_H_i').'.pdf';
        $mpdf->Output();
        exit();
  }

    public function generate_excel_biomedical(){
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=biomedical_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");

        $reporttype = $this->input->post('reportType');
        $descriptiontype = $this->input->post('descriptiontype');

        $rpt_type=$this->input->post('rpttype');
        $status=$this->input->post('status');
      if($status=='decommission')
       {
        $is_rep='Y';
       }
       else
       {
        $is_rep='N';
       }
      $this->data['status']=$status;
       // $this->data['biomedical_inv_list']=$this->bio_medical_mdl->get_biomedical_inventory(array('bmin_isunrepairable'=>$is_rep));
        // // echo $this->db->last_query();
        // // die();
        $this->data['distdept']='';
        $srch=array('bmin_isunrepairable'=>$is_rep);
        if($rpt_type=='desc')
        {  $groupby="eql.eqli_equipmentlistid";
           $descriptionid=$this->input->post('bmin_descriptionid');
          if($descriptionid)
          {
            $srch=array('bmin_descriptionid'=>$descriptionid,'bmin_isunrepairable'=>$is_rep);
          }
        }
        
        if($rpt_type=='dist')
        {   $groupby="dis.dist_distributorid";
          $distributorid=$this->input->post('bmin_distributorid');
          if($distributorid)
          {
            $srch=array('bmin_distributorid'=>$distributorid,'bmin_isunrepairable'=>$is_rep);
          }
        }
        if($rpt_type=='dept')
        {  $groupby="di.dept_depid";
           $departmentid=$this->input->post('bmin_departmentid');
           if($departmentid)
          {
            $srch=array('bmin_departmentid'=>$departmentid,'bmin_isunrepairable'=>$is_rep);
          }

        }
        if($rpt_type=='pur_don')
        {  $groupby="pudo_purdonatedid";
          $purch_donatedid=$this->input->post('bmin_purch_donatedid');
           if($purch_donatedid)
          {
            $srch=array('bmin_purch_donatedid'=>$purch_donatedid,'bmin_isunrepairable'=>$is_rep);
          }

        } 
      if($rpt_type=='amc')
      {  $groupby="bmin_amc";
          $amc=$this->input->post('bmin_amc');
           if($amc)
          {
            $srch=array('bmin_amc'=>$amc,'bmin_isunrepairable'=>$is_rep);
          }
      } 
      if($rpt_type=='manual')
      { 
           $bmin_isoperation=$this->input->post('bmin_isoperation');
         if($bmin_isoperation)
          {
            $srch=array('bmin_isoperation'=>$bmin_isoperation,'bmin_isunrepairable'=>$is_rep);
          }
      } 
      
        $this->data['type'] = $rpt_type; 
        $this->data['distdept']=$this->bio_medical_mdl->get_biomedical_inventory($srch,false,false,false,false,$groupby);
        $array = array();
        $response = $this->load->view('report/v_report_inventory', $this->data, true);
        echo $response;  
      //  $this->data['biomedical_inv_list']=$this->bio_medical_mdl->get_biomedical_inventory($srch);
      //  $response = '<table border ="1">';
      // $response .='<tr><td colspan="12"><center>'.ORGA_NAME.'</center></td></tr>';
      // $response .='<tr><td colspan="12"><center>'.ORGA_ADDRESS1.','.ORGA_ADDRESS2.'</center></td></tr>';
      // $response .='<tr><td colspan="12"><center>Date/Time: '.CURDATE_NP.' AD ('.CURDATE_EN.' BS) '.date("h:i:s").'</center></td></tr>';
      // $response .='<tr><td colspan="12"><center>'.$reporttype.'</center></td></tr>';
      // $response .='<tr><td colspan="12"><center>'.$descriptiontype.'</center></td></tr>';
      // $response .= '<tr><td>S.No.</td><td>Equp ID</td><td>Description</td><td>Dept</td><td>Model No.</td><td>Serial No.</td><td>Manufacturer</td><td>Risk</td><td>AMC</td><td>Ser.St.Date</td><td>Ser.End.Warr.</td><td>Manual</td></tr>';
      //   if(!empty($this->data['biomedical_inv_list'])):
      //       foreach($this->data['biomedical_inv_list'] as $key=>$value){
      //           if(DEFAULT_DATEPICKER=='NP')
      //           {
      //             $servicedate=$value->bmin_servicedatebs ;
      //             $end_warrenty=$value->bmin_endwarrantydatebs;
      //           }
      //           else
      //           {
      //             $servicedate=$value->bmin_servicedatead ;
      //             $end_warrenty=$value->bmin_endwarrantydatead;
      //           }
      //           $sno = $key+1;
      //           $equipid = $value->bmin_equipmentkey;
      //           $description = $value->eqli_description;
      //           $department = $value->dein_department;
      //           $modelno = $value->bmin_modelno;
      //           $serialno = $value->bmin_serialno;
      //           // $manufacturer = $value->;
      //           $rivarisk = $value->riva_risk;
      //           $amc = $value->bmin_amc;
      //           $servicedate = $servicedate;
      //           $endwarrenty = $end_warrenty;
      //           $bmin_isoperation= !empty($value->bmin_isoperation)?'Oper.':''; 
      //           $bmin_ismaintenance= !empty($value->bmin_ismaintenance)?'Main.':''; 

      //           $response .= '<tr><td>'.$sno.'</td><td>'.$equipid.'</td><td>'.$description.'</td><td>'.$department.'</td><td>'.$modelno.'</td><td>'.$serialno.'</td><td>'.'</td><td>'.$rivarisk.'</td><td>'.$amc.'</td><td>'.$servicedate.'</td><td>'.$endwarrenty.'</td><td>'.$bmin_isoperation.' '.$bmin_ismaintenance.'</td></tr>';
      //       }
      //   endif;

      //   $response .= '</table>';

      //   echo $response;

    }

  public function overview_report()
  {
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
      $this->data['tab_type'] = "overview_report";
 
      $this->template
          ->set_layout('general')
          ->enable_parser(FALSE)
          ->title($this->page_title)
          //->build('report/v_overview_reoport', $this->data); 
          ->build('report/v_common_report_tab', $this->data);   
  }

  public function equipmentwise_report()
  {
    $this->data['department_all']=$this->department_mdl->get_all_department(array('dept_deptype'=>BIOMEDICALID));
    $this->data['store']=$this->general->get_tbl_data('*','eqty_equipmenttype');
    $this->data['equipment']=$this->general->get_tbl_data('*','eqli_equipmentlist');
    $this->data['tab_type'] = "equip_report";
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
          ->build('report/v_common_report_tab', $this->data);   
          //->build('report/v_equipmentwise_report', $this->data);   
  }

  public function equipmentwise_dep_report()
  {
    if($_SERVER['REQUEST_METHOD'] === 'POST') 
    {
    if(MODULES_VIEW=='N')
      {
      $array=array();
      
      echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));      
      exit;
      }
    }
      $deptquery='';
      $this->data['department_all']=$this->department_mdl->get_all_department(array('dept_deptype'=>BIOMEDICALID));

      foreach ($this->data['department_all'] as $key => $dep) {
        $deptquery .='depwise_equipment(bmin_descriptionid,'.$dep->dept_depid.') as dep'.$dep->dept_depid.',';
      }

      $deptquery = rtrim($deptquery,','); 
     //print_r($deptquery);die;
      $data = $this->equipmentwise_report_mdl->get_department_wise_lists($deptquery);
      // echo"<pre>";print_r($data);die;
      // echo $this->db->last_query();die();
      $array = array();
      $filtereddata = ($data["totalfilteredrecs"]>0)?($data["totalfilteredrecs"]):$data["totalrecs"];
      $totalrecs = $data["totalrecs"];
      unset($data["totalfilteredrecs"]);
      unset($data["totalrecs"]);
        // foreach ($this->data['location'] as $key => $locat) {
      $i=0;
          foreach($data as $row)
          { 
            // $array[$i]["sn"] = $i+1;
            $array[$i]["code"] = $row->eqli_code;
            $array[$i]["name"] = $row->eqli_description;
            // $array[$i]['sade_unitrate'] =$row->sade_unitrate;
            $sum =0;
            foreach ($this->data['department_all'] as $key => $dpt) {
              $rwdep=('dep'.$dpt->dept_depid);
              // $rwtotal=('issuetotal'.$dpt->dept_depid);
              $rwtotal='';
              //$array[$i]['dep'.$locat->dept_depid] = !empty(number_format($row->{$rwdep}))?number_format($row->{$rwdep}):'';
            $totaliss=  !empty(number_format($row->{$rwdep}))?number_format($row->{$rwdep}):'0';

            // $totaliss=0;
              $array[$i]['dep'.$dpt->dept_depid]=$totaliss;
              // $stotal=$row->{$rwtotal};
              $sum+= $totaliss;
              // $sum=0;
            }
            // $array[$i]['total'] = '<a data-toggle="tooltip" style="color: green;">'.number_format($sum,2).'</a>' ;

            $array[$i]['total'] ='<a>'.$sum.'</a>';
            $i++;
           
          }
      
          // print_r(json_encode($array));
          // die();

        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
  }

  public function get_overview_reoprt()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      $this->data['users_all']=$this->users_mdl->get_all_users();

     $this->data['equipmnt_type']=$this->bio_medical_mdl->get_equipmentlist();
  
      $this->data['dep_data']==$this->department_mdl->get_all_department(array('dept_deptype'=>BIOMEDICALID));

      $equipkey=$this->input->post('id');
      // echo $equipkey;die();
        $equid='';
       $this->data['eqli_data'] = $this->bio_medical_mdl->overview_reports(array('bm.bmin_equipmentkey'=>$equipkey));
      // echo $this->db->last_query();
      // die();
        if($this->data['eqli_data'])
        {
        $equid=$this->data['eqli_data'][0]->bmin_equipid;
        }
      $this->data['cmnt_data'] = $this->bio_medical_mdl->overview_comments_reports(array('bm.bmin_equipmentkey'=>$equipkey));
       //$this->data['maintenance_data'] = $this->bio_medical_mdl->overview_maintenance_reports(array('ml.malo_maintenancelogid'=>$equipkey));

       $this->data['maintenance_data'] = $this->bio_medical_mdl->overview_maintenance_reports(array('ml.malo_equipid'=>$equid));
     
      $this->data['equipment_detail']=$this->repair_request_info_mdl->repair_request_info(array('rere_equid'=>$equid));

      // $this->data['rere_data'] = $this->bio_medical_mdl->overview_repair_reports(array('bm.bmin_equipmentkey'=>$equipkey));
      // $this->data['pmcpmpleted'] = $this->bio_medical_mdl->overview_pmcompleted_reports(array('bm.bmin_equipmentkey'=>$equipkey));
      // $this->data['pmta'] = $this->bio_medical_mdl->overview_pmtable_reports(array('bm.bmin_equipmentkey'=>$equipkey));

      $this->data['pmdata'] = $this->bio_medical_mdl->get_selected_pmdata(array('pmta_equipid'=>$equid));
      
      // echo "<pre>";
      // print_r($this->data);
      // die();
      $this->data['eqiupment'] = $this->bio_medical_mdl->overview_comments_count(array('bm.bmin_equipmentkey'=>$equipkey));
      $this->data['decom'] = $this->bio_medical_mdl->overview_decommission_count(array('bm.bmin_equipmentkey'=>$equipkey));
     $this->data['equip_assign']=$this->assign_equipement_mdl->get_assign_equipment_report(array('eqas_equipid'=>$equid),false,false,'eqas_equipmentassignid','DESC');
     $this->data['equip_handover']=$this->assign_equipement_mdl->get_assign_equipment_report(array('eqas_equipid'=>$equid,'eqas_ishandover'=>'Y'),false,false,'eqas_equipmentassignid','DESC');
     $this->data['amc_data']=$this->general->get_tbl_data('*','amta_amctable',array('amta_equipid'=>$equid));
     //echo"<pre>"; print_r($this->data['amc']);die;
     $orga = explode(" ", ORGA_NAME);
      $acronym = "";

      foreach ($orga as $org) {
          $acronym .= $org[0];
      }

      // $equipkey = $this->data['equipid'];

      $eqID = explode('-', $equipkey);

      $eq_code = $eqID[0];
      $eq_number = $eqID[1];

      $new_equip_id = $acronym.'-'.$eq_code.'-'.$eq_number;

      // $this->data['new_equip_id'] = $new_equip_id;
      $this->data['new_equip_id'] = $equipkey;
      $this->data['qr_link'] = QRCODE_URL.'/biomedical/reports/overview_report'.'/'.$equipkey;
      // print_r($this->data['qr_link']);
      // die();
     
     // echo $this->db->last_query();
     // die();
      // $tempform .='';
      // $eqment = $this->general->get_count_data('*', 'eqco_equipmentcomment', $equid);
      //echo "<pre>";print_r($this->data['decom']);die();
      $this->data['equipment_data']=$this->bio_medical_mdl->overview_reports(array('bm.bmin_equipmentkey'=>$equipkey));
      $tempform= $this->load->view('report/v_overview_detail',$this->data,true);
      // echo $tempform;die();
      if($this->data['eqli_data'] || $this->data['pmta'] || $this->data['cmnt_data'] || $this->data['pmcpmpleted'] || $this->data['pmta'])
      {
        print_r(json_encode(array('status'=>'success','tempform'=>$tempform,'message'=>'Successfully Selected!!')));
            exit; 
      }
      else
      {
        $tempform='<span class="text-danger">Record Not Found!!</span>';
        print_r(json_encode(array('status'=>'success','message'=>'Unsuccessfully Selected')));
            exit; 
      }
    
    }else{
        print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        exit;
    }
  }

    public function get_itemwise_reoprt()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $equipkey=$this->input->post('id');
      // echo $equipkey;
      // die();
        $equid='';
       $this->data['eqli_data'] = $this->bio_medical_mdl->overview_reports(array('bm.bmin_equipmentkey'=>$equipkey));

      // echo $this->db->last_query();
      // die();

        if($this->data['eqli_data'])
        {
        $equid=$this->data['eqli_data'][0]->bmin_equipid;
        }
      $this->data['cmnt_data'] = $this->bio_medical_mdl->overview_comments_reports(array('bm.bmin_equipmentkey'=>$equipkey));
     
     $this->data['equipment_detail']=$this->repair_request_info_mdl->repair_request_info(array('rere_equid'=>$equid));

      // $this->data['rere_data'] = $this->bio_medical_mdl->overview_repair_reports(array('bm.bmin_equipmentkey'=>$equipkey));
      // $this->data['pmcpmpleted'] = $this->bio_medical_mdl->overview_pmcompleted_reports(array('bm.bmin_equipmentkey'=>$equipkey));
      // $this->data['pmta'] = $this->bio_medical_mdl->overview_pmtable_reports(array('bm.bmin_equipmentkey'=>$equipkey));

      $this->data['pmdata'] = $this->bio_medical_mdl->get_selected_pmdata(array('pmta_equipid'=>$equid));
      
      // echo "<pre>";
      // print_r($this->data);
      // die();
      $this->data['eqiupment'] = $this->bio_medical_mdl->overview_comments_count(array('bm.bmin_equipmentkey'=>$equipkey));
      $this->data['decom'] = $this->bio_medical_mdl->overview_decommission_count(array('bm.bmin_equipmentkey'=>$equipkey));
      $this->data['equip_assign']=$this->assign_equipement_mdl->get_assign_equipment_report(array('eqas_equipid'=>$equid),false,false,'eqas_equipmentassignid','DESC');
     $this->data['equip_handover']=$this->assign_equipement_mdl->get_assign_equipment_report(array('eqas_equipid'=>$equid,'eqas_ishandover'=>'Y'),false,false,'eqas_equipmentassignid','DESC');

     $orga = explode(" ", ORGA_NAME);
      $acronym = "";

      foreach ($orga as $org) {
          $acronym .= $org[0];
      }

      // $equipkey = $this->data['equipid'];

      $eqID = explode('-', $equipkey);

      $eq_code = $eqID[0];
      $eq_number = $eqID[1];

      $new_equip_id = $acronym.'-'.$eq_code.'-'.$eq_number;

      // $this->data['new_equip_id'] = $new_equip_id;
      $this->data['new_equip_id'] = $equipkey;
      $this->data['qr_link'] = QRCODE_URL.'/biomedical/reports/overview_report'.'/'.$equipkey;
     
     // echo $this->db->last_query();
     // die();
      // $tempform .='';
      // $eqment = $this->general->get_count_data('*', 'eqco_equipmentcomment', $equid);
      //echo "<pre>";print_r($this->data['decom']);die();
      $tempform= $this->load->view('report/v_overview_detail',$this->data,true);
      // echo $tempform;die();
      if($this->data['eqli_data'] || $this->data['pmta'] || $this->data['cmnt_data'] || $this->data['pmcpmpleted'] || $this->data['pmta'])
      {
        print_r(json_encode(array('status'=>'success','tempform'=>$tempform,'message'=>'Successfully Selected!!')));
            exit; 
      }
      else
      {
        $tempform='<span class="text-danger">Record Not Found!!</span>';
        print_r(json_encode(array('status'=>'success','message'=>'Unsuccessfully Selected')));
            exit; 
      }
    
    }else{
        print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        exit;
    }
  }

  public function report_search()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data['id'] =  $this->input->post('id');

    $tempform=$this->load->view('report/v_overview_form',$data,true);
    //echo $tempform;die();
    if(!empty($data['id']))
    {
        print_r(json_encode(array('status'=>'success','message'=>'You Can edit','tempform'=>$tempform)));
              exit;
    }
    else{
      $tempform='<span class="text-danger">Record Not Found!!</span>';
      print_r(json_encode(array('status'=>'error','message'=>'Unable to Edit!!')));
              exit;
      }
    }
  }
  public function overview_reports_pdf()
  {
      $equid=$this->input->post('id');
      // $equid='';
      // $this->data['eqli_data'] = $this->bio_medical_mdl->overview_reports(array('bm.bmin_equipmentkey'=>$equipkey));
      // // echo $this->db->last_query(); die();
      // if($this->data['eqli_data'])
      // {
      // $equid=$this->data['eqli_data'][0]->bmin_equipid;
      // }
      // $this->data['cmnt_data'] = $this->bio_medical_mdl->overview_comments_reports(array('bm.bmin_equipmentkey'=>$equipkey));
      // $this->data['equipment_detail']=$this->repair_request_info_mdl->repair_request_info(array('rere_equid'=>$equid));
      // $this->data['pmdata'] = $this->bio_medical_mdl->get_selected_pmdata(array('pmta_equipid'=>$equid));
      // $this->data['eqiupment'] = $this->bio_medical_mdl->overview_comments_count(array('bm.bmin_equipmentkey'=>$equipkey));
      $this->data['decom'] = $this->bio_medical_mdl->overview_decommission_count(array('bm.bmin_equipmentkey'=>$equipkey));
      $this->data['equip_assign']=$this->assign_equipement_mdl->get_assign_equipment_report(array('eqas_equipid'=>$equid),false,false,'eqas_equipmentassignid','DESC');
    // previous code for 
    $this->data['cmnt_data'] = $this->bio_medical_mdl->overview_comments_reports(array('bm.bmin_equipid'=>$equid));
    $this->data['eqli_data'] = $this->bio_medical_mdl->overview_reports(array('bm.bmin_equipid'=>$equid));
    $this->data['rere_data'] = $this->bio_medical_mdl->overview_repair_reports(array('bm.bmin_equipid'=>$equid));
    $this->data['pmcpmpleted'] = '';//$this->bio_medical_mdl->overview_pmcompleted_reports(array('bm.bmin_equipid'=>$equid));
    $this->data['pmdata'] = $this->bio_medical_mdl->get_selected_pmdata(array('pmta_equipid'=>$equid));
      //$this->data['pmta'] = $this->bio_medical_mdl->overview_pmtable_reports(array('bm.bmin_equipid'=>$equid));
    $this->data['eqiupment'] = $this->bio_medical_mdl->overview_comments_count(array('bm.bmin_equipid'=>$equid));
    $this->data['decom'] = $this->bio_medical_mdl->overview_decommission_count(array('bm.bmin_equipid'=>$equid));
    $this->data['equip_handover']=$this->assign_equipement_mdl->get_assign_equipment_report(array('eqas_equipid'=>$equid,'eqas_ishandover'=>'Y'),false,false,'eqas_equipmentassignid','DESC');
    $this->data['amc_data']=$this->general->get_tbl_data('*','amta_amctable',array('amta_equipid'=>$equid));
      $stylesheet='';
      $this->load->library('pdf');
      $mpdf = $this->pdf->load(); 
      $stylesheet.= file_get_contents(TEMPLATE_CSS.'custom.css');

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
          
      ini_set('memory_limit', '256M');
      $html = $this->load->view('report/inventory/v_overview_detail_download', $this->data, true);
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->WriteHTML($html);
      $output = 'overview_report_of_'. date('Y_m_d_H_i_s') . '_.pdf'; 
      $mpdf->Output($output, 'D'); 
      exit();
  }

  public function download_pmdatareport()
  {
      $equid = $this->input->post('id');
      $this->data['pm_report']=$this->pm_completed_mdl->get_all_pm_completed_report($equid);
      $stylesheet='';
      $this->load->library('pdf');
      $mpdf = $this->pdf->load(); 
      $stylesheet.= file_get_contents(TEMPLATE_CSS.'custom.css');

      ini_set('memory_limit', '256M');

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

      $html = $this->load->view('report/v_pmgeneated_report', $this->data, true);
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->WriteHTML($html);
      $mpdf->Output(); 
      exit();
  }
  public function pm_data_reports()
  {
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
        
        ->build('report/v_pmdata_report', $this->data);
  }

  public function pm_data_report($status=false)
  {
    // echo $status;
    // die();
    $this->data['status']=$status;
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
        if($status == 'complete'){
            $this->data['tab_type'] = "complete";
        }else{
            $this->data['tab_type'] = "pm_data_report";
        }
      
      $this->template
          ->set_layout('general')
          ->enable_parser(FALSE)
          ->title($this->page_title)
          //->build('report/v_pm_data_report', $this->data);
          ->build('report/v_common_report_tab', $this->data);
  }
  //   public function pm_complete($status=false)
  // {
  //   // echo $status;
  //   // die();
  //   $this->data['status']=$status;
  //     $seo_data='';
  //     if($seo_data)
  //     {
  //         //set SEO data
  //         $this->page_title = $seo_data->page_title;
  //         $this->data['meta_keys']= $seo_data->meta_key;
  //         $this->data['meta_desc']= $seo_data->meta_description;
  //     }
  //     else
  //     {
  //         //set SEO data
  //         $this->page_title = ORGA_NAME;
  //         $this->data['meta_keys']= ORGA_NAME;
  //         $this->data['meta_desc']= ORGA_NAME;
  //     }
  //     $this->data['tab_type'] = "complete";
  //     $this->template
  //         ->set_layout('general')
  //         ->enable_parser(FALSE)
  //         ->title($this->page_title)
  //         //->build('report/v_pm_data_report', $this->data);
  //         ->build('report/v_common_report_tab', $this->data);
  // }

  public function  generate_report_pm_data($ispmcomp=false)
  {
       if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         
         if($ispmcomp=='complete')
         {
          $compval=1;
          $this->data['is_complete']='Y';
         }
         else
         {
          $compval=0;
           $this->data['is_complete']='N';
         }

           $rpt_type=$this->input->post('rpttype');

          // echo "<pre>";
          // print_r($postdata);
          // die();
        $srch='';
        if($rpt_type=='desc')
        {  
          $descriptionid=$this->input->post('bmin_descriptionid');
          if($descriptionid)
          {
            $srch=array('bm.bmin_descriptionid'=>$descriptionid);
          }
          // $this->data['biomedical_pm_report']=$this->pm_data_mdl->get_pm_data_reports();
        }
        
        if($rpt_type=='dist')
        {  
          $distributorid=$this->input->post('bmin_distributorid');
          if($distributorid)
          {
            $srch=array('bm.bmin_distributorid'=>$distributorid);
          }

          // $this->data['biomedical_pm_report']=$this->pm_data_mdl->get_pm_data_reports();
        }
        if($rpt_type=='dept')
        {  
           $departmentid=$this->input->post('bmin_departmentid');
          if($departmentid)
          {
            $srch=array('bm.bmin_departmentid'=>$departmentid);
          }
           // $this->data['biomedical_pm_report']=$this->pm_data_mdl->get_pm_data_reports("bm.bmin_departmentid=$departmentid");
        }
        if($rpt_type=='pur_don')
        {  
          $purch_donatedid=$this->input->post('bmin_purch_donatedid');
           if($purch_donatedid)
          {
            $srch=array('bm.bmin_purch_donatedid'=>$purch_donatedid);
          }

          // $this->data['biomedical_pm_report']=$this->pm_data_mdl->get_pm_data_reports("bm.bmin_purch_donatedid=$purch_donatedid");
        } 
       if($rpt_type=='amc')
       { 
          $amc=$this->input->post('bmin_amc');
          if($amc)
          {
             $srch=array('bm.bmin_amc'=>$amc);
          }
          // $this->data['biomedical_pm_report']=$this->pm_data_mdl->get_pm_data_reports("bm.bmin_amc=$amc");
       } 
      if($rpt_type=='manual')
      { 
         
          $bmin_isoperation=$this->input->post('bmin_isoperation');
          if($bmin_isoperation)
          {
             $srch=array('bm.bmin_isoperation'=>'Y');
          }

          // $this->data['biomedical_pm_report']=$this->pm_data_mdl->get_pm_data_reports("bm.bmin_isoperation='Y'");
      }   
       // $this->data['biomedical_pm_report']=$this->pm_data_mdl->get_pm_data_reports($srch);
      // echo "<pre>";
      // print_r($srch);
      // die();
      $this->data['biomedical_pm_report']=$this->pm_data_mdl->get_all_pm_alert(array('pm.pmta_pmdatead >='=>CURDATE_EN,'pmta_ispmcompleted'=>$compval),$srch);
      // echo "<pre>";
      // print_r($this->data['biomedical_pm_report']);
      // die();
      // echo $this->db->last_query();
      // die();
      unset($this->data['biomedical_pm_report']['totalrecs']);
      unset($this->data['biomedical_pm_report']['totalfilteredrecs']);
      
      // ($srch);
       // echo $this->db->last_query();
       // die();

        $template='';
        $template=$this->load->view('report/v_report_pm_data',$this->data,true);

         // echo $template;
         // die();
         print_r(json_encode(array('status'=>'success','template'=>$template,'message'=>'Successfully Selected')));
          exit;
      }
      else{
          print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
          exit;
      }
  }
  public function pm_completed_report()
  {
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
    $this->data['tab_type']="complete";
    $this->template
        ->set_layout('general')
        ->enable_parser(FALSE)
        ->title($this->page_title)
       // ->build('report/v_pm_completed_report', $this->data);
        ->build('report/v_common_report_tab', $this->data);
  }

  public function generate_pmcompleted_report()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $srch = '';
      $rpt_type=$this->input->post('rpttype');
      if($rpt_type=='desc')
        {  
          if($descriptionid=$this->input->post('bmin_descriptionid')){
            $srch ="bm.bmin_descriptionid=$descriptionid";
          }
        }
        if($rpt_type=='dist')
        {  
          if($distributorid=$this->input->post('bmin_distributorid')){
            $srch = "bm.bmin_distributorid=$distributorid";
          }
        }
        if($rpt_type=='dept')
        {  
           if($departmentid=$this->input->post('bmin_departmentid')){
             $srch = "bm.bmin_departmentid=$departmentid";
           }
        }
        if($rpt_type=='pur_don')
        {  
          if($purch_donatedid=$this->input->post('bmin_purch_donatedid')){
            $srch = "bm.bmin_purch_donatedid=$purch_donatedid";
          }
        } 
      if($rpt_type=='amc')
      { 
          if($amc=$this->input->post('bmin_amc')){
            $srch="bm.bmin_amc='".$amc."'";
           }
      } 
      if($rpt_type=='manual')
      { 
          if($bmin_isoperation=$this->input->post('bmin_isoperation')){
            $srch = "bm.bmin_isoperation=$bmin_isoperation)";
          }
          
      }
       $this->data['biomedical_pmcompleted_report']=$this->pm_data_mdl->get_pm_completed_reports($srch);   
      //echo "<pre>"; print_r($this->data['biomedical_pmcompleted_report']);die();
      $template='';
      $template=$this->load->view('report/v_report_pmcompleted',$this->data,true);

       // echo $template; die();
         print_r(json_encode(array('status'=>'success','template'=>$template,'message'=>'Successfully Selected')));
          exit;
      }
      else{
          print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
          exit;
      }
  }

  public function pmcompleted_report_pd()
  {
     $this->data['print_pdf']='Yes';
        $rpt_type=$this->input->post('rpttype');

        //echo "<pre>";print_r($this->input->post()); die();
        if($rpt_type=='desc')
        {  
          $descriptionid=$this->input->post('bmin_descriptionid');
          $this->data['biomedical_pmcompleted_report']=$this->pm_data_mdl->get_pm_completed_reports('bmin_descriptionid='.$descriptionid);
        }
        
        if($rpt_type=='dist')
        {  
          $distributorid=$this->input->post('bmin_distributorid');
          $this->data['biomedical_pmcompleted_report']=$this->pm_data_mdl->get_pm_completed_reports('bmin_distributorid='.$distributorid);
        }
        if($rpt_type=='dept')
        {  
           $departmentid=$this->input->post('bmin_departmentid');
          $this->data['biomedical_pmcompleted_report']=$this->pm_data_mdl->get_pm_completed_reports('bmin_departmentid ='.$departmentid);
        }
        if($rpt_type=='pur_don')
        {  
          $purch_donatedid=$this->input->post('bmin_purch_donatedid');
          $this->data['biomedical_pmcompleted_report']=$this->pm_data_mdl->get_pm_completed_reports('bmin_purch_donatedid='.$purch_donatedid);
        } 
      if($rpt_type=='amc')
      { 
           $amc=$this->input->post('bmin_amc');
          $this->data['biomedical_pmcompleted_report']=$this->pm_data_mdl->get_pm_completed_reports("bm.bmin_amc='".$amc."'");
      } 
     // print_r($this->data['biomedical_pmcompleted_report']);die;
      $stylesheet='';
      $this->load->library('pdf');
      $mpdf = $this->pdf->load(); 
       // $stylesheet.= file_get_contents(TEMPLATE_CSS.'bootstrap.css');
      $stylesheet.= file_get_contents(TEMPLATE_CSS.'custom.css');
      // $stylesheet.= file_get_contents(TEMPLATE_CSS.'style.css');
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

      ini_set('memory_limit', '256M');
      $html = $this->load->view('report/v_report_pmcompleted', $this->data, true);
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->WriteHTML($html); 
        // echo $html;die(); $output = 'BiomedicalIventory.pdf'; $mpdf->Output($output, 'D'); 
      $mpdf->Output(); 
      exit();
  }

  public function repair_request_report()
  {
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
    $this->data['tab_type'] = "rep_reports";
    $this->template
        ->set_layout('general')
        ->enable_parser(FALSE)
        ->title($this->page_title)
        //->build('report/v_pm_repair_request_report', $this->data);
        ->build('report/v_common_report_tab', $this->data);
  }

  public function generate_repair_request_report($value='')
  {
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $rpt_type=$this->input->post('rpttype');
      $srch='';
      if($rpt_type=='desc')
      {  
        if($descriptionid = $this->input->post('bmin_descriptionid')){
          $srch="bm.bmin_descriptionid=$descriptionid";
        }
      }
        
      if($rpt_type=='dist')
      {  
        if($distributorid=$this->input->post('bmin_distributorid')){
          $srch="bm.bmin_distributorid=$distributorid";
        }
      }
      if($rpt_type=='dept')
      {  
         if($departmentid=$this->input->post('bmin_departmentid'))
          $srch ="bm.bmin_departmentid=$departmentid";
      }
      if($rpt_type=='pur_don')
      {  
        if($purch_donatedid=$this->input->post('bmin_purch_donatedid')){
          $srch ="bm.bmin_purch_donatedid=$purch_donatedid";
        }
      } 
      if($rpt_type=='amc')
      { 
          if($amc=$this->input->post('bmin_amc')){
             $srch="bm.bmin_amc='".$amc."'";
          }
      } 
    
      if($rpt_type=='manual')
      { 
          if($bmin_isoperation=$this->input->post('bmin_isoperation')){
            $srch = array(("bm.bmin_isoperation"));
          }
          
      }
        $this->data['equipment_detail']=$this->repair_request_info_mdl->repair_request_info( $srch);
          
      // echo "<pre>"; print_r($this->data['biomedical_repair_request_report']);die();
      $template='';
     $template=$this->load->view('repair_request_info/v_assistance_list',$this->data,true);

       // echo $template; die();
         print_r(json_encode(array('status'=>'success','template'=>$template,'message'=>'Successfully Selected')));
          exit;
      }
      else{
          print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
          exit;
      }
  }

  public function pdf_repair_request()
  {
     $this->data['print_pdf']='Yes';
        $rpt_type=$this->input->post('rpttype');
      if($rpt_type=='desc')
        {  
          $descriptionid=$this->input->post('bmin_descriptionid');
          $this->data['biomedical_repair_request_report']=$this->pm_data_mdl->get_repair_request_report("bm.bmin_descriptionid=$descriptionid");
        }
        
        if($rpt_type=='dist')
        {  
          $distributorid=$this->input->post('bmin_distributorid');
          $this->data['biomedical_repair_request_report']=$this->pm_data_mdl->get_repair_request_report("bm.bmin_distributorid=$distributorid");
        }
        if($rpt_type=='dept')
        {  
           $departmentid=$this->input->post('bmin_departmentid');
          $this->data['biomedical_repair_request_report']=$this->pm_data_mdl->get_repair_request_report("rere_department = $departmentid");
        }
        if($rpt_type=='pur_don')
        {  
          $purch_donatedid=$this->input->post('bmin_purch_donatedid');
          $this->data['biomedical_repair_request_report']=$this->pm_data_mdl->get_repair_request_report("bm.bmin_purch_donatedid=$purch_donatedid");
        } 
      if($rpt_type=='amc')
      { 
          $amc=$this->input->post('bmin_amc');
          $this->data['biomedical_repair_request_report']=$this->pm_data_mdl->get_repair_request_report("bm.bmin_amc='".$amc."'");
      } 
      if($rpt_type=='manual')
      { 
          $bmin_isoperation=$this->input->post('bmin_isoperation');
          $this->data['biomedical_repair_request_report']=$this->pm_data_mdl->get_repair_request_report("bm.bmin_isoperation='Y'");
      }

      $stylesheet='';
      $this->load->library('pdf');
      $mpdf = $this->pdf->load(); 
       // $stylesheet.= file_get_contents(TEMPLATE_CSS.'bootstrap.css');
      $stylesheet.= file_get_contents(TEMPLATE_CSS.'custom.css');
      // $stylesheet.= file_get_contents(TEMPLATE_CSS.'style.css');
        
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
          
      ini_set('memory_limit', '256M');
      $html = $this->load->view('report/v_repair_request_report', $this->data, true);
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->WriteHTML($html); 
        // echo $html;die(); $output = 'BiomedicalIventory.pdf'; $mpdf->Output($output, 'D'); 
      $mpdf->Output(); 
      exit();
  }

  //Summary All Inventory Report
  public function summary_report_inventory()
  {
    // $depwise=$this->bio_medical_mdl->get_department_wise_report();
   $this->data['departmentwise']=$this->bio_medical_mdl->get_column_wise_report('bmin_bmeinventory bm' ,'dept_department dp', $where=false,"bm.bmin_departmentid,COUNT('*') as cnt,dept_depname",'dp.dept_depid=bm.bmin_departmentid','INNER','bm.bmin_departmentid','dp.dept_depname','ASC');

    $this->data['descriptionwise']=$this->bio_medical_mdl->get_column_wise_report('bmin_bmeinventory bm' ,'eqli_equipmentlist eq', $where=false,"bm.bmin_descriptionid,COUNT('*') as cnt,eqli_description",'eq.eqli_equipmentlistid=bm.bmin_descriptionid','INNER','bm.bmin_descriptionid','eq.eqli_description','ASC');

    $this->data['distributor_wise']=$this->bio_medical_mdl->get_column_wise_report('bmin_bmeinventory bm' ,'dist_distributors di', $where=false,"bm.bmin_distributorid,COUNT('*') as cnt,dist_distributor",'di.dist_distributorid=bm.bmin_distributorid','INNER','bm.bmin_distributorid','di.dist_distributor','ASC');

    $this->data['amcwise']=$this->bio_medical_mdl->get_column_wise_report('bmin_bmeinventory bm' ,false, $where=false,"bm.bmin_amc,COUNT('*') as cnt",false,false,'bm.bmin_amc','bm.bmin_amc','ASC');

    $this->data['operationwise']=$this->bio_medical_mdl->get_column_wise_report('bmin_bmeinventory bm' ,false, $where=false,"bm.bmin_equip_oper,COUNT('*') as cnt",false,false,'bm.bmin_equip_oper','bm.bmin_equip_oper','ASC');

    $this->data['warrenty_wise']=$this->bio_medical_mdl->get_column_wise_report('bmin_bmeinventory' ,false, $where=false,"bmin_endwarrantydatebs,COUNT('*') as cnt",false,false,'bmin_endwarrantydatebs','bmin_endwarrantydatebs','ASC');

    /*s
        $warrentywise=$this->bio_medical_mdl->get_column_wise_report('bmin_bmeinventory' ,'eqli_equipmentlist', $where=false,"bmin_equipmentkey,eqli_description,bmin_endwarrantydatebs,COUNT('*') as cnt",'eqli_equipmentlistid = bmin_descriptionid','LEFT','eqli_description',false,false);
    */

        $this->data['warranty_status']=$this->bio_medical_mdl->warrantywise_checker();
        $a=$this->data['warranty_status'];

        //echo"<pre>";print_r($a);

    /*
        $items=$this->general->get_tbl_data('bmin_equipmentkey,bmin_endwarrantydatebs','bmin_bmeinventory',false,'bmin_equipmentkey','ASC');
   
      $k=0;
        $warr_array=array();
        $in_warr_count=0;
        $out_warr_count=0;
        $invalid_warr_count=0;
        $status='';
        foreach ($items as $key=>$value) 
        {
            $warr_array['eq_name'][$k]=$value->bmin_equipmentkey;
            $eq_warr_date=$value->bmin_endwarrantydatebs;
           
            if($eq_warr_date)
            {    
                $date1=date("Y-m-d",strtotime($eq_warr_date));
            }
            else
            {
                $date1="#empty";
            }

            $date2=date("Y-m-d",strtotime(CURDATE_NP));
            if($date1!="#empty")
            {
                $diff=strtotime($date1) - strtotime($date2);
                if ($diff>0) 
                {
                    // $in_warr_count=$in_warr_count+1;
                    $status='in';
                    $in_warr_count=$in_warr_count+1;

                }
                else if($diff<=0)
                {
                    // $out_warr_count=$out_warr_count+1;
                    $status='out';
                    $out_warr_count=$out_warr_count+1;
                }
                
            }
            else
            {
                 $status='undefined';
                 $invalid_warr_count=$invalid_warr_count+1;
            }

            $a='for item '.($k+1).'  '.$warr_array['eq_name'][$k].'  --- date:'.$value->bmin_endwarrantydatebs.' status=>'.$status.' count=';
            if($status=='in')
            {
                $a.=$in_warr_count;
            }
            else if($status=='out')
            {
                $a.=$out_warr_count;
            }
            else
            {
                $a.=$invalid_warr_count;
            }

            echo "<pre>";print_r($a);
            
            $k++;
        }
        echo "<br>-----------------------------------------------------------------------<br>";
        echo " total items= ".($in_warr_count+$out_warr_count+$invalid_warr_count)." in warranty=> ".$in_warr_count." out warranty=> ".$out_warr_count." invalid count=> ".$invalid_warr_count;
      die;
    */
    
    $this->data['in_warrenty']=$this->bio_medical_mdl->in_warrenty();
    $this->data['out_warrenty']=$this->bio_medical_mdl->out_warrenty();

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
        $this->data['tab_type']="summary_report";

        $this->template
            ->set_layout('general')
            ->enable_parser(FALSE)
            ->title($this->page_title)
           // ->build('report/v_column_wise_report', $this->data);
            ->build('report/v_common_report_tab', $this->data);

  }

  public function get_report_list()
  {
    $useraccess= $this->session->userdata(USER_ACCESS_TYPE);
    $orgid = $this->session->userdata(ORG_ID);
  
    $data = $this->bio_medical_mdl->get_allreport_list();
     // echo "<pre>"; print_r($data); die();
 
    $i = 0;
    $array = array();
    $filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
    $totalrecs = $data["totalrecs"];

      unset($data["totalfilteredrecs"]);
      unset($data["totalrecs"]);
    
        foreach($data as $key=>$row)
        {
          $array[$i]["sno"]=$key+1;
          $array[$i]["bmin_equipmentkey"] = $row->bmin_equipmentkey;
          $array[$i]["eqli_description"] = $row->eqli_description;
          $array[$i]["dein_department"] = $row->dein_department;
          $array[$i]["rode_roomname"] = $row->rode_roomname;
          $array[$i]["bmin_modelno"] = $row->bmin_modelno;
          $array[$i]["bmin_serialno"] = $row->bmin_serialno;
          $array[$i]["manu_manlst"] = $row->manu_manlst;
          $array[$i]["dist_distributor"] = $row->dist_distributor;
          $array[$i]["riva_risk"] = $row->riva_risk;
          $array[$i]["bmin_amc"] = $row->bmin_amc;
          $array[$i]["bmin_equip_oper"] = $row->bmin_equip_oper;
          $array[$i]["bmin_servicedatebs"] = $row->bmin_servicedatebs;
          $array[$i]["bmin_endwarrantydatebs"] = $row->bmin_endwarrantydatebs;
          $array[$i]["bmin_ismaintenance"] = ($row->bmin_ismaintenance=='Y')?'Yes':'No';
           if(DEFAULT_DATEPICKER=='NP')
          {
             $array[$i]["bmin_servicedatebs"] = $row->bmin_servicedatebs;
          }
          else
          {
              $array[$i]["bmin_servicedatebs"] = $row->bmin_servicedatead;  
          }

           if(DEFAULT_DATEPICKER=='NP')
          {
             $array[$i]["bmin_endwarrantydatebs"] = $row->bmin_endwarrantydatebs;
          }
          else
          {
              $array[$i]["bmin_endwarrantydatebs"] = $row->bmin_endwarrantydatead;  
          }
          $i++;
        }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
  }

   public function exportToExcelDirect($type=false)
    {
       header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=equipment".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");

        $data = $this->bio_medical_mdl->get_allreport_list();

        $this->data['searchResult'] = $this->bio_medical_mdl->get_allreport_list();
        
        $array = array();
        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);
        $response = $this->load->view('report/v_report_pdf', $this->data, true);

        echo $response;
       }

      public function generate_pdfDirect($type=false)
      {
      $this->data['searchResult'] = $this->bio_medical_mdl->get_allreport_list();

        unset($this->data['searchResult']['totalfilteredrecs']);
        unset($this->data['searchResult']['totalrecs']);

        $html = $this->load->view('report/v_report_pdf', $this->data, true);
        $filename = 'depreciation_report'. date('Y_m_d_H_i_s') . '_.pdf'; 
        $pdfsize = 'A4-L'; //A4-L for landscape
        //if save and download with default filename, send $filename as parameter
        $this->general->generate_pdf($html,false,$pdfsize);
        exit();
      }
}