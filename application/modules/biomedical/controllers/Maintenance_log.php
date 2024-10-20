<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Maintenance_log extends CI_Controller
{
	function __construct()
	{
			
		parent::__construct();
		//$this->load->Model('bio_medical_mdl');
		$this->load->Model('maintenance_log_mdl');
		$this->load->Model('settings/department_mdl','department_mdl');
		$this->load->Model('settings/users_mdl');
		$this->load->Model('bio_medical_mdl');
    	$this->load->Model('equipment_mdl');
    	$this->load->Model('repair_request_info_mdl');
    	$this->load->Model('assign_equipement_mdl');

		$this->load->library('zend');
        $this->zend->load('Zend/Barcode');
        $this->load->library('upload');
		$this->load->library('image_lib');
		$this->load->helper('file');
		$this->load->helper('form');
		$this->load->library('ciqrcode');

	}

	
	public function index()
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
		$this->data['breadcrumb']=$this->lang->line('maintenance_logs');
		$this->data['tab_type']='log_report';

		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)

			->build('maintenance_log/v_maintenance_log_common_tab', $this->data);
	}

	public function list_of_maintenance_logs()
    {
    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		try {
			
			  $data['equipment_inv_list'] = $this->bio_medical_mdl->get_biomedical_inventory(array('bmin_isunrepairable'=>'N'),10,false,'bmin_equipid','ASC');
			  // echo "<pre>";
			  // print_r($data);
			  // die();
			   $template=$this->load->view('biomedical/bio_medical_inventory/list_of_equipment_inv',$data,true);
	            if($template)
	            {
	            	  print_r(json_encode(array('status'=>'success','message'=>'Selected Successfully','template'=>$template)));
	            	exit;
	            }
	            else
	            {
	            	 print_r(json_encode(array('status'=>'error','message'=>'Operation Unsuccessful')));
	            	exit;
	            }
		}
		catch (Exception $e) {
          
            print_r(json_encode(array('status'=>'error','message' => $e->getMessage())));
        }

		}
		else
	    {
	    	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	            exit;
	    }
    }

     public function list_mlog_comments($equid=false)
    {
    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   		//  		if(MODULES_VIEW=='N')
			// {
			// $this->general->permission_denial_message();
			// exit;
			// }
			$org_id=$this->session->userdata(ORG_ID);
			// $this->data['equip_comment'] = $this->Maintenance_log_mdl->get_mlog_comment(array('ec.eqco_eqid'=>$equid,'eqco_orgid'=>$org_id));
			$this->data['maintenance_data'] = $this->maintenance_log_mdl->get_mlog_comment(array('ma.malo_equipid'=>$equid));
			//get_equip_comment(array('ec.eqco_eqid'=>$equid,'eqco_orgid'=>$org_id));
			$template=$this->load->view('maintenance_log/v_maintenancelog_list',$this->data,true);
			print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));
	   		 exit;	
		}
		else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}
    }


	public function entry()
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
		$this->data['breadcrumb']=$this->lang->line('maintenance_log_entry');
		$this->data['tab_type']='log_entry';

		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('maintenance_log/v_maintenance_log_common_tab', $this->data);
	}

	public function get_overview_report()
  	{
     if ($_SERVER['REQUEST_METHOD'] === 'POST') 
     {

      $this->data['users_all']=$this->users_mdl->get_all_users();

      $this->data['equipmnt_type']=$this->bio_medical_mdl->get_equipmentlist();
  
      $this->data['dep_data']=$this->bio_medical_mdl->get_departmentinfo();

	  $this->data['listurl']=base_url().'biomedical/bio_medical_inventory/list_bio_medical_inv';

	  //$this->data['deleteurl']='';//delete url 

      $equipkey=$this->input->post('id');
      // echo $equipkey;die();
    
       $this->data['eqli_data'] = $this->bio_medical_mdl->overview_reports(array('bm.bmin_equipmentkey'=>$equipkey));
      // echo $this->db->last_query();
      // die();
        if($this->data['eqli_data'])
        {
        $equid=$this->data['eqli_data'][0]->bmin_equipid;
        }
      $this->data['cmnt_data'] = $this->bio_medical_mdl->overview_comments_reports(array('bm.bmin_equipmentkey'=>$equipkey));
       //$this->data['maintenance_data'] = $this->bio_medical_mdl->overview_maintenance_reports(array('ml.malo_maintenancelogid'=>$equipkey));

       // $this->data['maintenance_data'] = $this->bio_medical_mdl->overview_maintenance_reports(array('bm.bmin_equipmentkey'=>$equipkey));
      $this->data['maintenance_data'] = $this->maintenance_log_mdl->get_mlog_comment(array('ma.malo_equipid'=>$equid));
     
      $this->data['equipment_detail']=$this->repair_request_info_mdl->repair_request_info(array('rere_equid'=>$equid));

      $this->data['pmdata'] = $this->bio_medical_mdl->get_selected_pmdata(array('pmta_equipid'=>$equid));
      
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
      $this->data['listurl']=base_url().'biomedical/maintenance_log/list_mlog_comments/'.$equid;
	  $this->data['deleteurl']=base_url().'biomedical/maintenance_log/delete_bio_comment';

      $tempform ='';
      // $eqment = $this->general->get_count_data('*', 'eqco_equipmentcomment', $equid);
      //echo "<pre>";print_r($this->data['decom']);die();
      $this->data['equipment_data']=$this->bio_medical_mdl->overview_reports(array('bm.bmin_equipmentkey'=>$equipkey));
      $tempform= $this->load->view('maintenance_log/v_maintenance_log_details',$this->data,true);
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
    

    	}
    	else
    	{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
    	}
  	}

	public function actual_mlog()
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
		$this->data['breadcrumb']=$this->lang->line('maintenance_logs');
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('maintenance_log/v_maintenance_log_list_bck', $this->data);
	}



	public function delete_mlog_comment()
    {
    	
    		$delete_id = $this->input->post('id');
    		
    		if($this->maintenance_log_mdl->delete_mlog_comment($delete_id))
    		{
    			print_r(json_encode(array('status'=>'success','message'=>'Deleted Successfully')));
	            exit;
    		}
    		else
    		{
    			print_r(json_encode(array('status'=>'success','message'=>'Cannot delete!')));
	            exit;
    		}
    	
    }

	public function search_result()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	      	
	        $template='';
	      	$this->data['fromdate'] = $this->input->post('fromdate');
        	$this->data['todate'] = $this->input->post('todate');
        	$srchcol='';
	      	$this->data['mlog_report']=$this->maintenance_log_mdl->get_mlog_report($srchcol);

		    if($this->data['mlog_report'])
		    {
		    	$template=$this->load->view('maintenance_log/v_maintenance_log_list_bck',$this->data,true);
		    }
		    else
		    {
		        $template='<span class="col-sm-12 alert alert-danger text-center">No Record Found!!!</span>';
		    }
	        // echo $temp; die();
	        print_r(json_encode(array('status'=>'success','template'=>$template,'message'=>'Successfully Selected')));
	        exit;
	    }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
	}

  	public function get_mlog_summary()
    {   
     	$data = $this->maintenance_log_mdl->get_all_mlog_summary();
		//print_r($data);die;
    	$i = 0;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
	  	foreach($data as $row)
		    {
		    	  //$array[$i]["equipid"] = '<a href="javascript:void(0)" class="patlist" data-patientid='.$row->amta_amctableid.'>'.$row->amta_amctableid.'</a>';
			   
		    	$array[$i]["equipid"] = $row->malo_equipid;	
			    $array[$i]["equipmentkey"] = $row->bmin_equipmentkey;
			    $array[$i]["equidesc"] = $row->eqli_description;
			 	$array[$i]["department"] = $row->dept_depname;
			 	$array[$i]["room"] = $row->rode_roomname;
			    $array[$i]["problem"] = $row->malo_comment;
			    $array[$i]["solution"] = $row->malo_remark;
			    $array[$i]["maintained_by"] = $row->usma_username;
			    $array[$i]["posted_time"] = $row->malo_posttime;
			    $array[$i]["posted_date"] = $row->malo_postdatebs;
			    // $array[$i]["action"] ='<a href="javascript:void(0)" data-id='.$row->amta_equipid.' data-displaydiv="displyblock" data-viewurl='.base_url('biomedical/amc_data/amc_summary_view').' class="view" data-heading="AMC Summmary " ><i class="fa fa-eye" aria-hidden="true" ></i></a>';
			    
			    $i++;
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
    } 


    public function search_mlog()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			
		  	$html = $this->search_mlog_common();
		  	
		  	if($html)
		  	{
		  		$template=$html;
		  	}
	        print_r(json_encode(array('status'=>'success','template'=>$template,'message'=>'Successfully Selected')));
	        exit;
	    }else{
        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
        	exit;
        }
	}

	public function search_mlog_common()
	{
		$this->data['excel_url'] = "biomedical/maintenance_log/search_mlog_excel";
		$this->data['pdf_url'] = "biomedical/maintenance_log/search_mlog_pdf";
		$this->data['report_title'] = $this->lang->line('equipment_maintenance_logs');

		$this->data['searchResult'] = $this->maintenance_log_mdl->get_all_mlog();
		$this->data['fromdate'] = $this->input->post('fromdate');
    	$this->data['todate'] = $this->input->post('todate');
		//print_r($this->data['searchResult']);die;
		unset($this->data['searchResult']["totalfilteredrecs"]);
		unset($this->data['searchResult']["totalrecs"]);
		//$html = $this->load->view('pending_order_detail/v_pending_order_detail_pdf', $this->data, true);
		$html = $this->load->view('maintenance_log/v_maintenance_log_report', $this->data, true);
        return $html;
	}

	public function search_mlog_excel()
	{	
		header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=maintenance_log_".date('Y_m_d_H_i').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");
	    $response = $this->search_mlog_common();
	    if($response){
        	echo $response;	
        }
        return false;
	}
	
	public function search_mlog_pdf()
	{	
		$html = $this->search_mlog_common();
		
        $filename = 'maintenance_log_'. date('Y_m_d_H_i_s') . '_.pdf'; 
        $pdfsize = 'A4'; 
        $this->general->generate_pdf($html,false,$pdfsize);
	}


}
