<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Amc_data extends CI_Controller
{
	function __construct()
	{
			
		parent::__construct();
			$this->load->Model('amc_data_mdl');
			$this->load->Model('ams/assets_mdl');
			$this->load->Model('risk_value_mdl');
			$this->load->Model('equipment_mdl');
			$this->load->Model('bio_medical_mdl');
			$this->load->Model('repair_request_info_mdl');

		
	}

	public function index()
    {

		// $this->data['amc_data_all'] = $this->amc_data_mdl->get_all_amc_data();
		// $this->data['risk_value_all'] = $this->risk_value_mdl->get_all_risk_value();
		// $this->data['equipment_all'] = $this->equipment_mdl->get_all_equipment();
		// $this->data['distributor_list']=$this->bio_medical_mdl->get_distributor_list();
    	$this->data['org_id']=$this->session->userdata(ORG_ID);

		$this->data['editurl'] = base_url().'biomedical/amc_data/editamc_data';
		$this->data['deleteurl'] = base_url().'biomedical/amc_data/deleteamc_data';
		$this->data['listurl']=base_url().'biomedical/amc_data/list_amc_data';
	    $this->data['amc_data']='addnewamc';
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
			//set SEO data
		    $this->page_title = ORGA_NAME;
		    $this->data['meta_keys']= ORGA_NAME;
		    $this->data['meta_desc']= ORGA_NAME;
		}

		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('amc_data/v_amc_data', $this->data);
	}
	public function amc_summary()
    {

		// $this->data['amc_data_all'] = $this->amc_data_mdl->get_all_amc_data();
		// $this->data['risk_value_all'] = $this->risk_value_mdl->get_all_risk_value();
		// $this->data['equipment_all'] = $this->equipment_mdl->get_all_equipment();
		// $this->data['distributor_list']=$this->bio_medical_mdl->get_distributor_list();

		$this->data['editurl'] = base_url().'biomedical/amc_data/editamc_data';
		$this->data['deleteurl'] = base_url().'biomedical/amc_data/deleteamc_data';
		$this->data['listurl']=base_url().'biomedical/amc_data/list_amc_data';
	    $this->data['amc_data']='summary';
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
			//set SEO data
		    $this->page_title = ORGA_NAME;
		    $this->data['meta_keys']= ORGA_NAME;
		    $this->data['meta_desc']= ORGA_NAME;
		}

		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('amc_data/v_amc_data', $this->data);
	}
		public function amc_detail()
    {

		// $this->data['amc_data_all'] = $this->amc_data_mdl->get_all_amc_data();
		// $this->data['risk_value_all'] = $this->risk_value_mdl->get_all_risk_value();
		// $this->data['equipment_all'] = $this->equipment_mdl->get_all_equipment();
		// $this->data['distributor_list']=$this->bio_medical_mdl->get_distributor_list();

		$this->data['editurl'] = base_url().'biomedical/amc_data/editamc_data';
		$this->data['deleteurl'] = base_url().'biomedical/amc_data/deleteamc_data';
		$this->data['listurl']=base_url().'biomedical/amc_data/list_amc_data';
	    $this->data['amc_data']='detail';
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
			//set SEO data
		    $this->page_title = ORGA_NAME;
		    $this->data['meta_keys']= ORGA_NAME;
		    $this->data['meta_desc']= ORGA_NAME;
		}

		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('amc_data/v_amc_data', $this->data);
	}

	public function amc_data_list($status=false)
	{
		
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

		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('amc_data/v_pm_list', $this->data);
	}

	public function list_amc_data()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$data=array();
			$template=$this->load->view('amc_data/v_amc_data_list',$data,true);
			print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));
	   		 exit;	
		}
		else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}
	}


	public function get_amc_data_detail()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$data=array();
			$equipid=$this->input->post('equipid');
			$pmtaid=$this->input->post('pmtaid');
			$template='';
			// echo "<pre>";
			// print_r($amc_data_list);
			// die();
			$org_id=$this->data['org_id']=$this->session->userdata(ORG_ID);
			// echo $org_id; die;
			$this->data['pmtaid']=$pmtaid;
			$this->data['equipid']=$equipid;

			if($org_id=='2'){
				$this->data['eqli_data'] = $this->assets_mdl->get_assets_detail(array('asen_asenid'=>$equipid));
				//echo $this->db->last_query();
				//echo "<pre>"; print_r($this->data['eqli_data']); die;
			}else{
			$this->data['eqli_data'] = $this->bio_medical_mdl->get_biomedical_inventory(array('bm.bmin_equipid'=>$equipid));
			}
			


			$this->data['amc_data_rec']=$this->amc_data_mdl->get_all_amc_data(array('amta_amctableid'=>$pmtaid ,'amta_equipid'=>$equipid));
			// echo $this->db->last_query();

			// echo "<pre>";
			// print_r($this->data['amc_data_rec']);
			// die();
			if($org_id=='2'){
			$this->data['pmco_amc']=$this->data['eqli_data'][0]->asen_amc;
			}else{
			$this->data['pmco_amc']=$this->data['eqli_data'][0]->bmin_amc;
			}
			if($org_id!='2'){
				$this->data['amccontractor']=$this->data['eqli_data'][0]->bmin_amcontractorid;
			}
			
			
			if($org_id=='2'){
			$template.=$this->load->view('common/v_assets_detail',$this->data,true);

			}else{
			$template.=$this->load->view('common/equipment_detail',$this->data,true);

			}
			$template .=$this->load->view('amc_data/v_amc_completeform',$this->data,true);

			print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));
	   		 exit;	
		}
		else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}
	}

	public function save_amc_data()
	{
		 //echo "<pre>"; print_r($this->input->post()); die;

		//  print_r($id); 
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		try {
			$id=$this->input->post('id');
			$amta_equipid = $this->input->post('amta_equipid');
			
			$this->form_validation->set_rules($this->amc_data_mdl->validate_amc_data);
			
			if($this->form_validation->run()==TRUE)
		{
                 // print_r($_FILES);
			//  	$upload_result_error=FALSE;
			// 	if(!empty($_FILES['amta_amcfile']['name']))
			// 	{
			// 	$upload_result_error=$this->amc_data_mdl->upload_amc_images();
			// 	// echo $upload_result_error;
			// 	// die();
			// 	if($upload_result_error==TRUE)
			// 	{
			// 		print_r(json_encode(array('status'=>'error','message'=>$this->session->userdata('amc_fileupload_error'))));
			// 		exit;
			// 	}
			// }

            $trans = $this->amc_data_mdl->save_amc_data();

            if($trans)
            {
            	  print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully')));
            	exit;
            }
            else
            {
            	 print_r(json_encode(array('status'=>'error','message'=>'Operation Unsuccessful')));
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
	    }
		else
	    {
	    	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	            exit;
	    }
	}
	public function form_amc_data()
		{
			$this->data['org_id']=$this->session->userdata(ORG_ID);
			$this->load->view('amc_data/v_amc_dataform',$this->data);
		}

	public function editamc_data()
	{   $id=$this->input->post('id'); 
			
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$id=$this->input->post('id');
		
			$data['amc_data']=$this->amc_data_mdl->get_all_amc_data(array('amc.amta_amctableid'=>$id));	

			// echo "<pre>";
			// print_r($data['risk_value_all']);
			// die();
			$tempform = $this->load->view('amc_data/v_amc_dataform',$data,true);
			// echo $tempform;
			// die();
			if(!empty($data['amc_data']))
			{
					print_r(json_encode(array('status'=>'success','message'=>'You Can edit','tempform'=>$tempform)));
	            	exit;
			}
			else{
				print_r(json_encode(array('status'=>'error','message'=>'Unable to Edit!!')));
	            	exit;
			}
		}
		else
		{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}
	}

	public function edit_amc_data()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		try {
			$editid = $this->input->post('modal_editid');
			
			if(!empty($editid))
			{

            $trans = $this->amc_data_mdl->edit_amc_data($editid);
            if($trans)
            {
            	print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully')));
            	exit;
            }
            else
            {
            	 print_r(json_encode(array('status'=>'error','message'=>'Operation Unsuccessful')));
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
	    }
		else
	    {
	    	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	            exit;
	    }
	}

	public function deleteamc_data()
    {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$id=$this->input->post('id');
			$trans=$this->amc_data_mdl->remove_amc_data();
			if($trans)
			{
				print_r(json_encode(array('status'=>'success','message'=>'Successfully Deleted!!')));
	       		exit;	
			}
			else
			{
				print_r(json_encode(array('status'=>'error','message'=>'Error while deleting!!')));
	       		exit;	
			}

		}
		else
		{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}

	}

	public function get_equdata()
	{   
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$equid_key=$this->input->post('id');
			//echo $equid_key; die;
			$this->data['org_id']=$org_id=$this->session->userdata(ORG_ID);
			if($org_id=='2'){
				$this->data['eqli_data'] = $this->assets_mdl->get_assets_detail(array('asen_assetcode'=>$equid_key));
			}else{
				$this->data['eqli_data'] = $this->bio_medical_mdl->get_biomedical_inventory(array('bm.bmin_equipmentkey'=>$equid_key));
			}
			
			$this->data['distributor_list']=$this->bio_medical_mdl->get_distributor_list();


			if($this->data['eqli_data'])
			{
				if($org_id=='2'){
				$equid=$this->data['eqli_data'][0]->asen_asenid;

				}else{
				$equid=$this->data['eqli_data'][0]->bmin_equipid;
				}
			$this->data['pmdata'] = $this->bio_medical_mdl->get_selected_amcdata(array('amta_equipid'=>$equid,'amta_orgid'=>$org_id));
			
			// $tempform .='';
			$this->data['equip_comment'] = $this->bio_medical_mdl->get_equip_comment(array('ec.eqco_eqid'=>$equid,'eqco_orgid'=>$org_id));
			$this->data['repair_comment'] = $this->repair_request_info_mdl->repair_request_info(array('r.rere_equid'=>$equid,'eqco_orgid'=>$org_id));
			}

		
			//$this->data['history'] = $this->amc_data_mdl->get_pm_report_by_department(array('amta_equipid'=>$equid));
			//echo "<pre>";print_r($this->data['pmdata']);die();
			$tempform= $this->load->view('amc_data/v_equi_detail',$this->data,true);
			//$tempform= $this->load->view('amc_data/v_amc_dataform', $data, true);
			//$this->load->view('amc_data/v_amc_dataform');
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
   public function amc_summary_view()
   {   
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$equid_key=$this->input->post('id');

			// $this->data['eqli_data'] = $this->bio_medical_mdl->get_biomedical_inventory(array('bm.bmin_equipmentkey'=>$equid_key));
			// $this->data['distributor_list']=$this->bio_medical_mdl->get_distributor_list();
			// //echo "<pre>";print_r($this->data['eqli_data']);die();
			// $equid=$this->data['eqli_data'][0]->bmin_equipid;
			$org_id=$this->session->userdata(ORG_ID);
			if($org_id=='2'){
				$this->data['amcdata'] = $this->bio_medical_mdl->get_selected_amcdata(array('amta_equipid'=>$equid_key,'amta_orgid'=>'2'));
				//echo $this->db->last_query(); die;
			}else{
				$this->data['amcdata'] = $this->bio_medical_mdl->get_selected_amcdata(array('amta_equipid'=>$equid_key,'amta_orgid'=>'1'));
			}
			
			$tempform= $this->load->view('amc_data/v_amc_summary_detail',$this->data,true);
			//echo $tempform; die();
			if($this->data['amcdata'])
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
    public function get_amc_data()
    {
   		$data = $this->amc_data_mdl->get_amc_data_list(); //echo"<pre>";print_r($data) ;die;
    	$i = 0;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
	  	foreach($data as $row)
		    {
		   
			    $array[$i]["riva_riskid"] = '<a href="javascript:void(0)" class="patlist" data-patientid='.$row->riva_riskid.'>'.$row->riva_riskid.'</a>';
			    $array[$i]["risk"] = $row->riva_risk;
			    $array[$i]["comments"] = $row->riva_comments;
			    $array[$i]["postdatebs"] = $row->riva_postdatebs;
			    $array[$i]["action"] ='<a href="javascript:void(0)"><i class="fa fa-eye" aria-hidden="true"></i></a>';
			    
			    $i++;
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
    }
     public function get_amc_alert()
    {
     	$data = $this->amc_data_mdl->get_all_pm_alert();
		// echo $this->db->last_query(); die();
		//echo "<pre>"; print_r($data);die;
    	$i = 0;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
	  	foreach($data as $row)
		    {
		    	
		    	$array[$i]["equipid"] = $row->amta_equipid;	
			    $array[$i]["equipmentkey"] = $row->bmin_equipmentkey;
			     $array[$i]["equidesc"] = $row->eqli_description;
			 	$array[$i]["department"] = $row->dein_department;
			 	$array[$i]["room"] = $row->rode_roomname;
			    $array[$i]["risk_val"] = $row->riva_risk;
			    $array[$i]["manufacture"] = $row->manu_manlst;
			    $array[$i]["distributor"] = $row->dist_distributor;
			   
				$i++;
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
    }

    public function get_amc_summary()
    {   //echo MODULES_VIEW ;die;

  //   	if(MODULES_VIEW=='N')
		// {
		// 	 $array["equipid"]='';
		// 	 $array["equipmentkey"] ='';
		// 	 $array["equidesc"]='';
		// 	 $array["department"]='';
		// 	 $array["room"]='';
		// 	 $array["risk_val"] ='';
		// 	 $array["manufacture"]='';
		// 	 $array["distributor"]='';
		// 	 $array["action"]='';
		// 	 echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));
  //               exit;
	 //     	}
    	$org_id=$this->session->userdata(ORG_ID);
    	if($org_id=='2'){
    		$data = $this->amc_data_mdl->get_amc_summary_assets(array('amta_orgid'=>'2'));
    	}else{
     	$data = $this->amc_data_mdl->get_all_amc_summary(array('amta_orgid'=>'1'));
     	}
     	
		// echo $this->db->last_query(); die();
		//echo "<pre>"; print_r($data);die;
    	$i = 0;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
	  	foreach($data as $row)
		    {
		    	  //$array[$i]["equipid"] = '<a href="javascript:void(0)" class="patlist" data-patientid='.$row->amta_amctableid.'>'.$row->amta_amctableid.'</a>';
			   
		    	$array[$i]["equipid"] = $row->amta_equipid;	
			    $array[$i]["equipmentkey"] = $row->bmin_equipmentkey;
			    $array[$i]["equidesc"] = $row->eqli_description;
			 	$array[$i]["department"] = $row->dein_department;
			 	$array[$i]["room"] = $row->rode_roomname;
			    $array[$i]["risk_val"] = $row->riva_risk;
			    $array[$i]["manufacture"] = $row->manu_manlst;
			    $array[$i]["distributor"] = $row->dist_distributor;
			    $array[$i]["action"] ='<a href="javascript:void(0)" data-id='.$row->amta_equipid.' data-displaydiv="displyblock" data-viewurl='.base_url('biomedical/amc_data/amc_summary_view').' class="view btn-primary btn-xxs sm-pd" data-heading="AMC Summmary " ><i class="fa fa-eye" aria-hidden="true" ></i></a>';
			    
			    $i++;
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
    } 
      public function get_amc_detail()
    {
    	$org_id=$this->session->userdata(ORG_ID);
    	if($org_id=='2'){
    		$data = $this->amc_data_mdl->get_amc_summary_assets(array('amta_orgid'=>'2'));
    	}else{
    		$data = $this->amc_data_mdl->get_all_amc_detail(array('amta_orgid'=>'1'));
    	}
     	
		// echo $this->db->last_query(); die();
		//echo "<pre>"; print_r($data);die;
    	$i = 0;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
	  	foreach($data as $row)


		    {      
                     
                    $newDate = !empty($row->amta_isamccompleted)?$row->amta_isamccompleted:'';
                    if($newDate == '1'){
                        $style = "color:#d00";
                        $status = "Completed";
                        $display = "display:none;";
                    }else{
                        $style = "color:#0f0";
                        $status = "Available";
                        $display = "display:inline-block;";
                    }
		    	
					$array[$i]["equipid"] = $row->amta_equipid;	
					$array[$i]["equipmentkey"] = $row->bmin_equipmentkey;
					$array[$i]["equidesc"] = $row->eqli_description;
					$array[$i]["department"] = $row->dein_department;
					$array[$i]["room"] = $row->rode_roomname;
					$array[$i]["risk_val"] = $row->riva_risk;
					$array[$i]["manufacture"] = $row->manu_manlst;
					$array[$i]["distributor"] = $row->dist_distributor;
					$array[$i]["date_ad"] = $row->amta_postdatead;
					$array[$i]["date_bs"] = $row->amta_postdatebs;
					$array[$i]["completedby"] = $this->session->userdata('user_name');
					$array[$i]["status"] = $status;

			   
				$i++;
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
    }

    public function get_pm_record($status=false)
    {
     // if ($_SERVER['REQUEST_METHOD'] == 'POST') 
     // {
	
     		$data = $this->amc_data_mdl->get_all_pm_alert(array('amc.amta_amcdatead >='=>CURDATE_EN,'pmta_ispmcompleted'=>0));
     	if($status=='prior')
     	{
     	$data = $this->amc_data_mdl->get_all_pm_alert(array('amc.amta_amcdatead <='=>CURDATE_EN));
     	}

     
     	// echo "<pre>";
     	// print_r($data);
     	// die();

		// echo $this->db->last_query(); die();
		//echo "<pre>"; print_r($data);die;
    	$i = 0;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
	  	foreach($data as $row)
		    {
		    	 $ispmcomplete = $row->pmta_ispmcompleted;
		    	 if($ispmcomplete==1)
		    	 {
		    	 	$pmcomplete='<label class="label label-success">Yes</label>';
		    	 }
		    	 else
		    	 {
		    	 	$pmcomplete='<label class="label label-danger">No</label>';
		    	 }

		    	$date1=strtotime($row->amta_amcdatead);
		    	$date2=strtotime(CURDATE_EN);
		    	$days=$this->general->get_left_days($date1,$date2);
		    	if($days!=='Expiry')
		    	{
		    		$status='<span class="text-success">'.$days.' Days Left</span>';;
		    		if($days<7)
		    		{
		    			$status='<span class="text-danger">'.$days.' Days Left</span>';;
		    		}
		    	}
		    	else
		    	{
		    		$status='<span class="text-danger">Expiry</span>';
		    	}

		    	
		    	$array[$i]["equipid"] = $row->amta_equipid;	
			    $array[$i]["equipmentkey"] = $row->bmin_equipmentkey;
			     $array[$i]["equidesc"] = $row->eqli_description;
			 	$array[$i]["department"] = $row->dein_department;
			 	$array[$i]["room"] = $row->rode_roomname;
			    $array[$i]["risk_val"] = $row->riva_risk;
			    $array[$i]["manufacture"] = $row->manu_manlst;
			    $array[$i]["distributor"] = $row->dist_distributor;
			    $array[$i]["amta_amcdatead"] = $row->amta_amcdatead;
			    $array[$i]["amta_amcdatebs"] = $row->amta_amcdatebs;
			    $array[$i]["pmta_remarks"] = $row->pmta_remarks;
			    $array[$i]["pmta_status"] = $status;
			    $array[$i]["ispmcomplete"] = $pmcomplete;
			   
				$i++;
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));

      
  //   	} 
		
		// else
  //   	{
  //   		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	 //        exit;
  //   	}
    }
    

    public function get_pm_detail()
    {
    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    		$this->data['amc_data_detail']=$this->amc_data_mdl->get_pm_detail_list();
    		$this->data['amc_data_not_done_detail']=$this->amc_data_mdl->get_pm_detail_list(array('amc.pmta_ispmcompleted'=>'0'));
    		$this->data['amc_data_done_detail']=$this->amc_data_mdl->get_pm_detail_list(array('amc.pmta_ispmcompleted'=>'1'));

    		// echo '<pre>';
    		// print_r($this->data);
    		// die();

    		$tempform= $this->load->view('amc_data/v_pm_detail_list',$this->data,true);

    		if($this->data['amc_data_detail'])
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

public function generate_pdfDirect($type=false)
    {
    	if($type=='summary'){
    		$this->data['searchResult'] = $this->amc_data_mdl->get_amc_summary_assets();
       

	        // echo "<pre>";
	        // print_r( $this->data['searchResult']);
	        // die();
	        unset($this->data['searchResult']['totalfilteredrecs']);
	        unset($this->data['searchResult']['totalrecs']);
	        $html = $this->load->view('amc_data/v_amc_data_list_download', $this->data, true);
	      	$filename = 'direct_purchase_'. date('Y_m_d_H_i_s') . '_.pdf'; 
	        $pdfsize = 'A4-L'; //A4-L for landscape
	        //if save and download with default filename, send $filename as parameter
	        $this->general->generate_pdf($html,false,$pdfsize);
	        exit();

    	}elseif ($type=='detail') {
    		$this->data['searchResult'] = $this->amc_data_mdl->get_amc_summary_assets(array('amta_orgid'=>'2'));

	        // echo "<pre>";
	        // print_r( $this->data['searchResult']);
	        // die();
	        unset($this->data['searchResult']['totalfilteredrecs']);
	        unset($this->data['searchResult']['totalrecs']);

	        $html = $this->load->view('amc_data/v_amc_detail_download', $this->data, true);
	        
	      	$filename = 'direct_purchase_'. date('Y_m_d_H_i_s') . '_.pdf'; 
	        $pdfsize = 'A4-L'; //A4-L for landscape
	        //if save and download with default filename, send $filename as parameter
	        $this->general->generate_pdf($html,false,$pdfsize);
	        exit();
	    }
}

    public function exportToExcelDirect($type=false)
    {
    	if($type=='summary'){
	        header("Content-Type: application/xls");    
	        header("Content-Disposition: attachment; filename=assets_list".date('Y_m_d_H_i').".xls");  
	        header("Pragma: no-cache"); 
	        header("Expires: 0");

	        $data = $this->amc_data_mdl->get_amc_summary_assets();
	        

	        $this->data['searchResult'] = $this->amc_data_mdl->get_amc_summary_assets();
	        
	        $array = array();
	        unset($this->data['searchResult']['totalfilteredrecs']);
	        unset($this->data['searchResult']['totalrecs']);
	        $response = $this->load->view('amc_data/v_amc_data_list_download', $this->data, true);

	        echo $response;
	    }
	     elseif ($type=='detail') {
	     	header("Content-Type: application/xls");    
	        header("Content-Disposition: attachment; filename=assets_list".date('Y_m_d_H_i').".xls");  
	        header("Pragma: no-cache"); 
	        header("Expires: 0");

	        $data = $this->amc_data_mdl->get_amc_summary_assets(array('amta_orgid'=>'2'));
	        

	        $this->data['searchResult'] = $this->amc_data_mdl->get_amc_summary_assets(array('amta_orgid'=>'2'));
	        
	        $array = array();
	        unset($this->data['searchResult']['totalfilteredrecs']);
	        unset($this->data['searchResult']['totalrecs']);
	        $response = $this->load->view('amc_data/v_amc_detail_download', $this->data, true);

	        echo $response;

	     }
    }


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */