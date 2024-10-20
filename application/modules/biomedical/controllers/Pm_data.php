<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pm_data extends CI_Controller
{
	function __construct()
	{
			
		parent::__construct();
			$this->load->Model('pm_data_mdl');
			$this->load->Model('risk_value_mdl');
			$this->load->Model('equipment_mdl');
			$this->load->Model('bio_medical_mdl');
			$this->load->Model('repair_request_info_mdl');

		
	}

	public function index()
    {

		$this->data['pm_data_all'] = $this->pm_data_mdl->get_all_pm_data();
		$this->data['risk_value_all'] = $this->risk_value_mdl->get_all_risk_value();
		$this->data['equipment_all'] = $this->equipment_mdl->get_all_equipment();

		$this->data['editurl'] = base_url().'biomedical/pm_data/editpm_data';
		$this->data['deleteurl'] = base_url().'biomedical/pm_data/deletepm_data';
		$this->data['listurl']=base_url().'biomedical/pm_data/list_pm_data';
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
			//set SEO data
		    $this->page_title = ORGA_NAME;
		    $this->data['meta_keys']= ORGA_NAME;
		    $this->data['meta_desc']= ORGA_NAME;
		}

		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('pm_data/v_pm_data', $this->data);
	}

	public function pm_data_list($status=false)
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
			->build('pm_data/v_pm_list', $this->data);
	}

	public function list_pm_data()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$data=array();
			$template=$this->load->view('pm_data/v_pm_data_list',$data,true);
			print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));
	   		 exit;	
		}
		else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}
	}


	public function get_pm_data_detail()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$data=array();
			$equipid=$this->input->post('equipid');
			$pmtaid=$this->input->post('pmtaid');
			$template='';
			// echo "<pre>";
			// print_r($pm_data_list);
			// die();
			$this->data['pmtaid']=$pmtaid;
			$this->data['equipid']=$equipid;


			$this->data['eqli_data'] = $this->bio_medical_mdl->get_biomedical_inventory(array('bm.bmin_equipid'=>$equipid));
			// echo "<pre>";
			// print_r($this->data['equip_data']);
			// die();


			$this->data['pm_data_rec']=$this->pm_data_mdl->get_all_pm_data(array('pmta_pmtableid'=>$pmtaid ,'pmta_equipid'=>$equipid));
			// echo $this->db->last_query();

			// echo "<pre>";
			// print_r($this->data['pm_data_rec']);
			// die();
			$this->data['pmco_amc']=$this->data['eqli_data'][0]->bmin_amc;
			$this->data['amccontractor']=$this->data['eqli_data'][0]->bmin_amcontractorid;
			

			$template.=$this->load->view('common/equipment_detail',$this->data,true);
			$template .=$this->load->view('pm_data/v_pm_completeform',$this->data,true);

			print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));
	   		 exit;	
		}
		else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}
	}

	public function save_pm_data()
	{
		//echo "<pre>"; $id=$this->input->post();

		 //print_r($id); die();
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		try {
			$id=$this->input->post('id');
			$pmta_equipid = $this->input->post('pmta_equipid');
			
			$this->form_validation->set_rules($this->pm_data_mdl->validate_pm_data);
			
			
			if($this->form_validation->run()==TRUE)
			{

            $trans = $this->pm_data_mdl->save_pm_data();
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
	public function form_pm_data()
		{
			$this->load->view('pm_data/v_pm_dataform');
		}

	public function editpm_data()
	{   $id=$this->input->post('id'); 
			
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$id=$this->input->post('id');
		
			$data['pm_data']=$this->pm_data_mdl->get_all_pm_data(array('pm.pmta_pmtableid'=>$id));	

			// echo "<pre>";
			// print_r($data['risk_value_all']);
			// die();
			$tempform = $this->load->view('pm_data/v_pm_dataform',$data,true);
			// echo $tempform;
			// die();
			if(!empty($data['pm_data']))
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

	public function edit_pm_data()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		try {
			$editid = $this->input->post('modal_editid');
			
			if(!empty($editid))
			{

            $trans = $this->pm_data_mdl->edit_pm_data($editid);
            
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

	public function deletepm_data()
    {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$id=$this->input->post('id');
			$trans=$this->pm_data_mdl->remove_pm_data();
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

			$this->data['eqli_data'] = $this->bio_medical_mdl->get_biomedical_inventory(array('bm.bmin_equipmentkey'=>$equid_key));


			if($this->data['eqli_data'])
			{
			$equid=$this->data['eqli_data'][0]->bmin_equipid;

			$this->data['pmdata'] = $this->bio_medical_mdl->get_selected_pmdata(array('pmta_equipid'=>$equid));
			
			// $tempform .='';
			$this->data['equip_comment'] = $this->bio_medical_mdl->get_equip_comment(array('ec.eqco_eqid'=>$equid));
			$this->data['repair_comment'] = $this->repair_request_info_mdl->repair_request_info(array('r.rere_equid'=>$equid));
			}

		
			//$this->data['history'] = $this->pm_data_mdl->get_pm_report_by_department(array('pmta_equipid'=>$equid));
			//echo "<pre>";print_r($this->data['pmdata']);die();
			$tempform= $this->load->view('pm_data/v_equi_detail',$this->data,true);
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
   
    public function get_pm_data()
    {
   		$data = $this->pm_data_mdl->get_pm_data_list(); //echo"<pre>";print_r($data) ;die;
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

    public function get_pm_alert()
    {
    	if(MODULES_VIEW=='N')
			//echo MODULES_VIEW;die;
			{
			 $array["equipid"]='';
			 $array["equipmentkey"] ='';
			 $array["equidesc"]=''; 
			 $array["department"]=''; 
			 $array["room"] ='';
			 $array["risk_val"] ='';
			 $array["manufacture"]='';
			 $array["distributor"]='';
			 // $this->general->permission_denial_message();
			 echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));			
			exit;
			}
     	$data = $this->pm_data_mdl->get_all_pm_alert();
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
		    	
		    	$array[$i]["equipid"] = $row->pmta_equipid;	
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

    public function get_pm_record($status=false)
    {
     // if ($_SERVER['REQUEST_METHOD'] == 'POST') 
     // {
	
     		$data = $this->pm_data_mdl->get_all_pm_alert(array('pm.pmta_pmdatead >='=>CURDATE_EN,'pmta_ispmcompleted'=>0));
     	if($status=='prior')
     	{
     	$data = $this->pm_data_mdl->get_all_pm_alert(array('pm.pmta_pmdatead <='=>CURDATE_EN));
     	}

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

		    	$date1=strtotime($row->pmta_pmdatead);
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

		    	
		    	$array[$i]["equipid"] = $row->pmta_equipid;	
			    $array[$i]["equipmentkey"] = $row->bmin_equipmentkey;
			    $array[$i]["equidesc"] = $row->eqli_description;
			 	$array[$i]["department"] = $row->dein_department;
			 	$array[$i]["room"] = $row->rode_roomname;
			    $array[$i]["risk_val"] = $row->riva_risk;
			    $array[$i]["manufacture"] = $row->manu_manlst;
			    $array[$i]["distributor"] = $row->dist_distributor;
			    $array[$i]["pmta_pmdatead"] = $row->pmta_pmdatead;
			    $array[$i]["pmta_pmdatebs"] = $row->pmta_pmdatebs;
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
    		$this->data['pm_data_detail']=$this->pm_data_mdl->get_pm_detail_list();
    		$this->data['pm_data_not_done_detail']=$this->pm_data_mdl->get_pm_detail_list(array('pm.pmta_ispmcompleted'=>'0'));
    		$this->data['pm_data_done_detail']=$this->pm_data_mdl->get_pm_detail_list(array('pm.pmta_ispmcompleted'=>'1'));

    		// echo '<pre>';
    		// print_r($this->data);
    		// die();

    		$tempform= $this->load->view('pm_data/v_pm_detail_list',$this->data,true);

    		if($this->data['pm_data_detail'])
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


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */