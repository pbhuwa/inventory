<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Asset_handover extends CI_Controller
{
	function __construct()
	{
			
		parent::__construct();
			$this->load->model('assets_mdl');
			$this->load->Model('settings/department_mdl','department_mdl');
			$this->load->Model('biomedical/bio_medical_mdl');
			$this->load->Model('biomedical/manufacturers_mdl');
			$this->load->Model('biomedical/equipment_mdl');
			$this->load->library('zend');
			$this->zend->load('Zend/Barcode');
			$this->load->library('ciqrcode');
			
		
	}

		public function index()
	{
		
		// $this->data['editurl'] = base_url().'biomedical/pm_data/editpm_data';
		// $this->data['deleteurl'] = base_url().'biomedical/pm_data/deletepm_data';
		// $this->data['listurl']=base_url().'biomedical/pm_data/list_pm_data';

		$this->data['editurl'] = '';
		$this->data['deleteurl'] = '';
		$this->data['listurl']='';
		$seo_data='';
		// echo "<pre>"; print_r($this->data['equipment_all']); die();
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
		    $this->page_title = ORGA_NAME;
		    $this->data['meta_keys']= ORGA_NAME;
		    $this->data['meta_desc']= ORGA_NAME;
		}
		
		$this->data['breadcrumb']='Assets/Handover ';

		$this->data['tab_type']='Handover';

		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('assets/v_assets_common', $this->data);

	}

	public function asset_handover_form()
	{
		$this->data['editurl'] = '';
		$this->data['deleteurl'] = '';
		$this->data['listurl']='';
		$seo_data='';
		// echo "<pre>"; print_r($this->data['equipment_all']); die();
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
		    $this->page_title = ORGA_NAME;
		    $this->data['meta_keys']= ORGA_NAME;
		    $this->data['meta_desc']= ORGA_NAME;
		}
		
		$this->data['breadcrumb']='Assets/Handover ';

		$this->data['tab_type']='Handover';

		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('assets_handover/v_assets_handover', $this->data);

	}


	public function save_equipment_handover()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			 $trans = $this->assign_equipement_mdl->handover_equipment_save();
            if($trans)
            {
            	print_r(json_encode(array('status'=>'success','message'=>'Handover Successfully!!')));
            	exit;
            }
            else
            {
            	 print_r(json_encode(array('status'=>'error','message'=>'Handover Unsuccessfully!!')));
            	exit;
            }
		}
		else
	    {
	    	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation!!')));
	            exit;
	    }
	}




	public function get_equdata_handover()
	{   
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$equid_key=$this->input->post('id');

			$this->data['eqli_data'] = $this->bio_medical_mdl->get_biomedical_inventory(array('bm.bmin_equipmentkey'=>$equid_key));


			if($this->data['eqli_data'])
			{
			$equid=$this->data['eqli_data'][0]->bmin_equipid;

			// $this->data['pmdata'] = $this->bio_medical_mdl->get_selected_pmdata(array('pmta_equipid'=>$equid));
			
			// $tempform .='';
			$this->data['equip_assign']=$this->assign_equipement_mdl->get_assign_equipment_report(array('eqas_equipid'=>$equid),false,false,'eqas_equipmentassignid','DESC');

			$this->data['equip_handover']=$this->assign_equipement_mdl->get_assign_equipment_report(array('eqas_equipid'=>$equid,'eqas_ishandover'=>'Y'),false,false,'eqas_equipmentassignid','DESC');
     		
     		
			$this->data['equip_comment'] = $this->bio_medical_mdl->get_equip_comment(array('ec.eqco_eqid'=>$equid));
			$this->data['repair_comment'] = $this->repair_request_info_mdl->repair_request_info(array('r.rere_equid'=>$equid));
			}

		
			//$this->data['history'] = $this->pm_data_mdl->get_pm_report_by_department(array('pmta_equipid'=>$equid));
			// echo "<pre>";print_r($this->data['equip_assign']);die();
			$tempform= $this->load->view('assign_equipement/v_equi_detail_handover',$this->data,true);
			//$tempform= $this->load->view('pm_data/v_pm_dataform', $data, true);
			//$this->load->view('pm_data/v_pm_dataform');
			// echo $tempform;
			// die();
			if($this->data['eqli_data'])
			{
				print_r(json_encode(array('status'=>'success','tempform'=>$tempform,'message'=>'Successfully Selected!!')));
	       		exit;	
			}
			else
			{
				$tempform='<span class="col-sm-12 alert  alert-danger text-center">Record Not Found!!</span>';
				print_r(json_encode(array('status'=>'success','tempform'=>$tempform,'message'=>'Unsuccessfully Selected')));
	       		exit;	
			}
		

		}
		else
		{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}
	}


	public function get_equipment_handover_detail()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$this->load->Model('staff_info_mdl');
		$this->data=array();
		$id = $this->input->post('id');
		$depid=$this->input->post('departmentid');
		$roomid=$this->input->post('roomid');
		$this->data['assignid']=$this->input->post('assignid');
		$tempform='';
		$this->data['is_multiple']='N';

		// if(!empty($depid) && empty($roomid))
		// {
			$same_srch=array('stin_departmentid'=>$depid,'stin_jobstatus'=>'1');
			$diff_srch=array('stin_departmentid !='=>$depid,'stin_jobstatus'=>'1');
		// }
		// else if(!empty($depid) && !empty($roomid))
		// {
			// $srch=array('stin_departmentid'=>$depid,'stin_roomid'=>$roomid);
		// }
		$this->data['equipid']=$id;
		$this->data['biomedical_data']=$this->bio_medical_mdl->get_biomedical_inventory(array('bmin_equipid'=>$id));
		$this->data['same_department_staff_list']=$this->staff_info_mdl->get_all_staff_info($same_srch);
		$this->data['staffcode']=$this->input->post('staffcode');
		$this->data['staffname']=$this->input->post('staffname');
		// echo "<prE>";
		// print_r($this->data['same_department_list']);
		// die();

		$this->data['different_department_staff_list']=$this->staff_info_mdl->get_all_staff_info($diff_srch);
		// echo "<pre>";print_r($this->data['biomedical_data']);die;
		$tempform.=$this->load->view('bio_medical_inventory/v_biomedical_view',$this->data,true);
		$tempform.=$this->load->view('assign_equipement/v_department_staff_handover',$this->data,true);
		if(!empty($tempform))
			{
					print_r(json_encode(array('status'=>'success','message'=>'You Can view','tempform'=>$tempform)));
	            	exit;
			}
			else{
				print_r(json_encode(array('status'=>'error','message'=>'Unable to View!!')));
	            	exit;
			}
		}

		 else
	    {
	    	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	            exit;
	    }

	}



	public function equip_assign_report()
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
		$this->data['dep_information']=$this->department_mdl->get_all_department(array('dept_deptype'=>BIOMEDICALID),false,false,'dept_depname','ASC');
		$this->data['tab_type']="assign_report";
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			//->build('assign_equipement/v_equip_assign_report', $this->data);
			->build('report/v_common_report_tab', $this->data);
	}





	 public function get_assign_report_type()
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
            $this->data['dep_information']=$this->bio_medical_mdl->get_departmentinfo();
         }
         if($this->data['rpt_type']=='pur_don')
         {
        
          $this->data['purchase_donate_all'] = $this->purchase_donate_mdl->get_all_purchase_donate();
         }


          if($this->data['rpt_type']=='assign_to')
         {
        
          $this->data['assign_to'] = $this->assign_equipement_mdl->get_all_assign_to('st.stin_staffinfoid IN (SELECT eqas_staffid FROM xw_eqas_equipmentassign)');
         }

         if($this->data['rpt_type']=='assign_by')
         {
        
          $this->data['assign_by'] = $this->assign_equipement_mdl->get_all_assign_by('um.usma_userid IN (SELECT eqas_postby FROM xw_eqas_equipmentassign)');
         }
         $template='';
         $template=$this->load->view('assign_equipement/v_assign_report_type',$this->data,true);

         // echo $temp;
         // die();
          print_r(json_encode(array('status'=>'success','template'=>$template,'message'=>'Successfully Selected')));
          exit;
         
      }else{
          print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
          exit;
      }

  }


	public function generate_assign_report()
	{

       if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         
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
        }
        
        if($rpt_type=='dist')
        {  
          $distributorid=$this->input->post('bmin_distributorid');
          if($distributorid)
          {
            $srch=array('bm.bmin_distributorid'=>$distributorid);
          }
        }
        if($rpt_type=='dept')
        {  
           $departmentid=$this->input->post('bmin_departmentid');
           if($departmentid)
          {
            $srch=array('bm.bmin_departmentid'=>$departmentid);
          }

        }
        if($rpt_type=='pur_don')
        {  
          $purch_donatedid=$this->input->post('bmin_purch_donatedid');
           if($purch_donatedid)
          {
            $srch=array('bm.bmin_purch_donatedid'=>$purch_donatedid);
          }

        } 
      if($rpt_type=='amc')
      { 
          $amc=$this->input->post('bmin_amc');
           if($amc)
          {
            $srch=array('bm.bmin_amc'=>$amc);
          }
      } 

       if($rpt_type=='assign_to')
         {
         	$assign_to=$this->input->post('stin_staffinfoid');
           if($assign_to)
          {
            $srch=array('as.eqas_staffid'=>$assign_to);
          }
         }

         if($rpt_type=='assign_by')
         {
         	$assign_by=$this->input->post('usma_userid');
           if($assign_by)
          {
            $srch=array('as.eqas_postby'=>$assign_by);
          }
         }



       $this->data['biomedical_inv_list']=$this->assign_equipement_mdl->get_assign_equipment_report($srch);
     	// echo $this->db->last_query();
     	// die();
      // print_r($srch);die;
      // echo "<pre>"; print_r($this->data['biomedical_inv_list']);die();
        $template='';
        $template=$this->load->view('assign_equipement/v_report_equipment_assign',$this->data,true);

         // echo $temp; die();
         print_r(json_encode(array('status'=>'success','template'=>$template,'message'=>'Successfully Selected')));
          exit;
      }
      else{
          print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
          exit;
      }
	}

	 public function download_assign_report()
  {
     
     	$this->data['print_pdf']='Yes';
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
        }
        
        if($rpt_type=='dist')
        {  
          $distributorid=$this->input->post('bmin_distributorid');
          if($distributorid)
          {
            $srch=array('bm.bmin_distributorid'=>$distributorid);
          }
        }
        if($rpt_type=='dept')
        {  
           $departmentid=$this->input->post('bmin_departmentid');
           if($departmentid)
          {
            $srch=array('bm.bmin_departmentid'=>$departmentid);
          }

        }
        if($rpt_type=='pur_don')
        {  
          $purch_donatedid=$this->input->post('bmin_purch_donatedid');
           if($purch_donatedid)
          {
            $srch=array('bm.bmin_purch_donatedid'=>$purch_donatedid);
          }

        } 
      if($rpt_type=='amc')
      { 
          $amc=$this->input->post('bmin_amc');
           if($amc)
          {
            $srch=array('bm.bmin_amc'=>$amc);
          }
      } 

       if($rpt_type=='assign_to')
         {
         	$assign_to=$this->input->post('stin_staffinfoid');
           if($assign_to)
          {
            $srch=array('as.eqas_staffid'=>$assign_to);
          }
         }

         if($rpt_type=='assign_by')
         {
         	$assign_by=$this->input->post('usma_userid');
           if($assign_by)
          {
            $srch=array('as.eqas_postby'=>$assign_by);
          }
         }
         $this->data['biomedical_inv_list']=$this->assign_equipement_mdl->get_assign_equipment_report($srch);
  
      $stylesheet='';
      $this->load->library('pdf');
      $mpdf = $this->pdf->load(); 
      $stylesheet.= file_get_contents(TEMPLATE_CSS.'custom.css');
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
       
      ini_set('memory_limit', '256M');
      $html = $this->load->view('assign_equipement/v_report_equipment_assign', $this->data, true);
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->WriteHTML($html); 
        // echo $html;
        // die();
        // $output = 'BiomedicalIventory.pdf'; 
        // $mpdf->Output($output, 'D'); 
      $output = 'Equipment_assign_report_of_'. date('Y_m_d_H_i_s') . '_.pdf'; 
      $mpdf->Output($output, 'D'); 
      // $pdf->Output(); 
      exit();
  }

  public function download_assign_report_excel()
  {
  	 header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=Equipment_Assing_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");

        $reporttype = $this->input->post('reportType');
        $descriptiontype = $this->input->post('descriptiontype');

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
        }
        
        if($rpt_type=='dist')
        {  
          $distributorid=$this->input->post('bmin_distributorid');
          if($distributorid)
          {
            $srch=array('bm.bmin_distributorid'=>$distributorid);
          }
        }
        if($rpt_type=='dept')
        {  
           $departmentid=$this->input->post('bmin_departmentid');
           if($departmentid)
          {
            $srch=array('bm.bmin_departmentid'=>$departmentid);
          }

        }
        if($rpt_type=='pur_don')
        {  
          $purch_donatedid=$this->input->post('bmin_purch_donatedid');
           if($purch_donatedid)
          {
            $srch=array('bm.bmin_purch_donatedid'=>$purch_donatedid);
          }

        } 
      if($rpt_type=='amc')
      { 
          $amc=$this->input->post('bmin_amc');
           if($amc)
          {
            $srch=array('bm.bmin_amc'=>$amc);
          }
      } 

       if($rpt_type=='assign_to')
         {
         	$assign_to=$this->input->post('stin_staffinfoid');
           if($assign_to)
          {
            $srch=array('as.eqas_staffid'=>$assign_to);
          }
         }

         if($rpt_type=='assign_by')
         {
         	$assign_by=$this->input->post('usma_userid');
           if($assign_by)
          {
            $srch=array('as.eqas_postby'=>$assign_by);
          }
         }
         $this->data['biomedical_inv_list']=$this->assign_equipement_mdl->get_assign_equipment_report($srch);


        $response = '<table border ="1">';
        $response .='<tr><td colspan="14"><center>'.ORGANAMETITLE.'</center></td></tr>';
        $response .='<tr><td colspan="14"><center>'.ORGA_NAME.'</center></td></tr>';
        $response .='<tr><td colspan="14"><center>'.ORGA_ADDRESS1.','.ORGA_ADDRESS2.'</center></td></tr>';
        $response .='<tr><td colspan="14"><center>Date/Time: '.CURDATE_NP.' AD ('.CURDATE_EN.' BS) '.date("h:i:s").'</center></td></tr>';
        $response .='<tr><td colspan="14"><center>'.$reporttype.'</center></td></tr>';
        $response .='<tr><td colspan="14"><center>'.$descriptiontype.'</center></td></tr>';

        $response .= '<tr><th >S.n.</th><th >Equp.ID</th><th >Description</th><th >Model No</th><th >Serial No</th><th >Distributor</th><th >AMC</th><th >Pur/Don</th><th >Assign Date</th><th >Assign To</th><th >Assign By</th><th >Department</th><th >Room</th><th >Entry Date</th></tr>';

        if(!empty($this->data['biomedical_inv_list'])):
        	$i=1;
            foreach($this->data['biomedical_inv_list'] as $key=>$value){
                 if(DEFAULT_DATEPICKER=='NP')
                {
                  $assigndate=$value->eqas_assigndatebs ;  
                  $postdate=$value->eqas_postdatebs ;     
                }
                else
                {
                  $assigndate=$value->eqas_assigndatead ; 
                  $postdate=$value->eqas_postdatead ;        
                }
                 $response .= '<tr>
                <td>'.$i .'</td>
                <td>'.$value->bmin_equipmentkey.'</td>
                <td>'.$value->eqli_description.'</td>
                <td>'.$value->bmin_modelno.'</td>
                <td>'.$value->bmin_serialno.'</td>
                <td>'.$value->dist_distributor.'</td>
                <td>'.$value->bmin_amc.'</td>
                <td>'.$value->pudo_purdonated.'</td>
                <td>'.$assigndate.'</td>
                <td>'.$value->stin_fname.' '.$value->stin_lname.'</td>
                <td>'.$value->usma_username.'</td>
                <td>'.$value->dein_department.'</td>
                <td>'.$value->rode_roomname.'</td>
                <td>'.$postdate.'</td></tr>';
            }
        endif;

        $response .= '</table>';

        echo $response;

  }



public function equip_handover_report()
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
		$this->data['dep_information']=$this->department_mdl->get_all_department(array('dept_deptype'=>BIOMEDICALID),false,false,'dept_depname','ASC');
		$this->data['tab_type']="handover";

		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			//->build('assign_equipement/v_equip_handover_report', $this->data);
			->build('report/v_common_report_tab', $this->data);
	}


	 public function get_handover_report_type()
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
            $this->data['dep_information']=$this->bio_medical_mdl->get_departmentinfo();
         }
         if($this->data['rpt_type']=='pur_don')
         {
        
          $this->data['purchase_donate_all'] = $this->purchase_donate_mdl->get_all_purchase_donate();
         }

         if($this->data['rpt_type']=='handover_from')
         {
        
          $this->data['handover_from'] = $this->assign_equipement_mdl->get_all_assign_to('st.stin_staffinfoid IN (SELECT eqas_staffid FROM xw_eqas_equipmentassign)');
         }

         if($this->data['rpt_type']=='handover_to')
         {
        
          $this->data['handover_to'] = $this->assign_equipement_mdl->get_all_assign_to('st.stin_staffinfoid IN (SELECT eqas_handoverstaffid FROM xw_eqas_equipmentassign)');
         }

         
         if($this->data['rpt_type']=='handover_by')
         {
        
          $this->data['handover_by'] = $this->assign_equipement_mdl->get_all_assign_by('um.usma_userid IN (SELECT eqas_handoverpostby FROM xw_eqas_equipmentassign)');
         }
         $template='';
         $template=$this->load->view('assign_equipement/v_handover_report_type',$this->data,true);

         // echo $temp;
         // die();
          print_r(json_encode(array('status'=>'success','template'=>$template,'message'=>'Successfully Selected')));
          exit;
         
      }else{
          print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
          exit;
      }

  }

  public function generate_handover_report()
	{

       if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         
           $rpt_type=$this->input->post('rpttype');

          // echo "<pre>";
          // print_r($postdata);
          // die();
     
        $srch=array('eqas_ishandover'=>'Y');
        if($rpt_type=='desc')
        {  
          $descriptionid=$this->input->post('bmin_descriptionid');
          if($descriptionid)
          {
            $srch=array('bm.bmin_descriptionid'=>$descriptionid,'eqas_ishandover'=>'Y');
          }
        }
        
        if($rpt_type=='dist')
        {  
          $distributorid=$this->input->post('bmin_distributorid');
          if($distributorid)
          {
            $srch=array('bm.bmin_distributorid'=>$distributorid,'eqas_ishandover'=>'Y');
          }
        }
        if($rpt_type=='dept')
        {  
           $departmentid=$this->input->post('bmin_departmentid');
           if($departmentid)
          {
            $srch=array('bm.bmin_departmentid'=>$departmentid,'eqas_ishandover'=>'Y');
          }

        }
        if($rpt_type=='pur_don')
        {  
          $purch_donatedid=$this->input->post('bmin_purch_donatedid');
           if($purch_donatedid)
          {
            $srch=array('bm.bmin_purch_donatedid'=>$purch_donatedid,'eqas_ishandover'=>'Y');
          }

        } 
      if($rpt_type=='amc')
      { 
          $amc=$this->input->post('bmin_amc');
           if($amc)
          {
            $srch=array('bm.bmin_amc'=>$amc,'eqas_ishandover'=>'Y');
          }
      } 

       if($rpt_type=='handover_from')
         {
         	$eqas_staffid=$this->input->post('eqas_staffid');
         	if($eqas_staffid)
        	{
        	 $srch=array('eqas_staffid'=>$eqas_staffid,'eqas_ishandover'=>'Y');
        	}
        }

         if($rpt_type=='handover_to')
         {
         	$eqas_handoverstaffid=$this->input->post('eqas_handoverstaffid');
         	if($eqas_handoverstaffid)
        	{
        		$srch=array('eqas_handoverstaffid'=>$eqas_handoverstaffid,'eqas_ishandover'=>'Y');
        	} 
         }

         if($rpt_type=='handover_by')
         {
         	$handover_by=$this->input->post('usma_userid');
           if($handover_by)
          {
            $srch=array('as.eqas_handoverpostby'=>$handover_by,'eqas_ishandover'=>'Y');
          }

         }

         $this->data['biomedical_inv_list']=$this->assign_equipement_mdl->get_assign_equipment_report($srch);
     	
        $template='';
        $template=$this->load->view('assign_equipement/v_report_equipment_handover',$this->data,true);

         // echo $temp; die();
         print_r(json_encode(array('status'=>'success','template'=>$template,'message'=>'Successfully Selected')));
          exit;
      }
      else{
          print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
          exit;
      }
	}





	
	

	

	

	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */