<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Unrepair_information extends CI_Controller
{
	function __construct()
	{
			
		parent::__construct();
		$this->load->Model('unrepair_information_mdl');
		$this->load->Model('bio_medical_mdl');
		$this->load->Model('assign_equipement_mdl');
		$this->load->Model('repair_request_info_mdl');
	}

	public function index()
	{
		//$this->data['repair_information_list']=$this->repair_information_mdl->get_all_repair_information();
		
		// echo '<pre>';
		// print_r($this->data['distributor_list']);
		// die();

		// $this->data['editurl']=base_url().'biomedical/repair_information/editrepair_information';
		// $this->data['deleteurl']=base_url().'biomedical/repair_information/deleterepair_information';
		$this->data['listurl']=base_url().'biomedical/unrepair_information/list_repair_information';
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
		$this->data['breadcrumb']='Equipments/Unrepairable Equipment ';
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('unrepair_information/v_unrepairinformation', $this->data);
	}

	public function list_repair_information()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$this->data=array();
			$template=$this->load->view('unrepair_information/v_unrepair_information_list',$this->data,true);
			print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));
	   		 exit;	
		}
		else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}
	}

	public function form_unrepair_information()
	{
		$this->load->view('unrepair_information/v_un_repairableform');
	}

	public function save_unrepair_information()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			try {
				$id=$this->input->post('id');
				if($id)
			{
					$this->data['repair_data']=$this->unrepair_information_mdl->get_all_repair_information(array('m.ureq_unrepairableequid'=>$id));
				// echo "<pre>";
				// print_r($this->data['dept_data']);
				// die();
			if($this->data['repair_data'])
			{
				$dep_date=$this->data['repair_data'][0]->ureq_postdatead;
				$dep_time=$this->data['repair_data'][0]->ureq_posttime;
				$editstatus=$this->general->compute_data_for_edit($dep_date,$dep_time);
				$usergroup=$this->session->userdata(USER_GROUPCODE);
				
				if($editstatus==0 && $usergroup!='SA' )
				{
					   $this->general->disabled_edit_message();

				}

			}
			}
		
				 	$this->form_validation->set_rules($this->unrepair_information_mdl->validate_settings_unrepair_information);
					if($this->form_validation->run()==TRUE)
					{

		            $trans = $this->unrepair_information_mdl->ureq_information_save();
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
	            }else{
					print_r(json_encode(array('status'=>'error','message'=>validation_errors())));
					exit;
				}
	           
	        } catch (Exception $e) {
	          
	            print_r(json_encode(array('status'=>'error','message' => $e->getMessage())));
	        }
    	}else{
	    	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
	    }
	}


	public function editrepair_information()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$id=$this->input->post('id');
		
			$this->data['repair_data']=$this->unrepair_information_mdl->get_all_repair_information(array('m.ureq_unrepairableequid'=>$id));
			// echo "<pre>";
			// print_r($this->data['service_techlist']);
			// die();

		if($this->data['repair_data'])
		{
			$dep_date=$this->data['repair_data'][0]->ureq_postdatead;
			$dep_time=$this->data['repair_data'][0]->ureq_posttime;
			$editstatus=$this->general->compute_data_for_edit($dep_date,$dep_time);
			// echo $editstatus;
			// die();
			$this->data['edit_status']=$editstatus;

		}
			$tempform = $this->load->view('unrepair_information/v_un_repairableform',$this->data,true);
			// echo $tempform;
			// die();
			if(!empty($this->data['repair_data']))
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

	public function deleterepair_information()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$id=$this->input->post('id');
			$trans=$this->unrepair_information_mdl->remove_unrepair_information_information();
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
	public function get_repair_information()
	{	

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		//print_r($equid);die;
			$equid_key=trim($this->input->post('id'));
			$this->data=array();
			$tempform='';

			$this->data['eqli_data'] = $this->bio_medical_mdl->get_biomedical_inventory(array('bm.bmin_equipmentkey'=>$equid_key));
				

			if($this->data['eqli_data'])
			{
			$equid=$this->data['eqli_data'][0]->bmin_equipid;
			$this->data['eqli_is_dis']=$this->data['eqli_data'][0]->bmin_isunrepairable;

			$this->data['equipid']=$equid;

			$this->data['reason_for_dis']=$this->unrepair_information_mdl->get_all_unrepair_information_view(array('ureq_equipid'=>$equid));
			
			// $tempform .='';
			// echo "<pre>";
			// print_r($this->data['reason_for_dis']);
			// die();
			$this->data['equip_assign']=$this->assign_equipement_mdl->get_assign_equipment_report(array('eqas_equipid'=>$equid),false,false,'eqas_equipmentassignid','DESC');

			$this->data['equip_handover']=$this->assign_equipement_mdl->get_assign_equipment_report(array('eqas_equipid'=>$equid,'eqas_ishandover'=>'Y'),false,false,'eqas_equipmentassignid','DESC');
     		
     		
			$this->data['equip_comment'] = $this->bio_medical_mdl->get_equip_comment(array('ec.eqco_eqid'=>$equid));
			$this->data['repair_comment'] = $this->repair_request_info_mdl->repair_request_info(array('r.rere_equid'=>$equid));
			}

			
			$tempform .= $this->load->view('common/equipment_detail',$this->data,true);
			$tempform .= $this->load->view('unrepair_information/v_unrepairable_form',$this->data,true);
			// echo $tempform;
			// die();
			if($this->data['eqli_data'])
			{
				print_r(json_encode(array('status'=>'success','tempform'=>$tempform,'message'=>'Successfully Selected!!')));
	       		exit;	
			}
			else
			{
				print_r(json_encode(array('status'=>'error','message'=>'Unsuccessfully Selected')));
	       		exit;	
			}
		

		}
		else
		{
		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}
	}

	public function view_unrepair_information()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$this->data=array();
		$id = $this->input->post('id');
		$tempform='';

		$this->data['eqli_data']=$this->unrepair_information_mdl->get_all_unrepair_information_view(array('u.ureq_unrepairableequid'=>$id));
		//echo "<pre>"; print_r($this->data['unrepair_data']);die;
		$tempform .= $this->load->view('common/equipment_detail',$this->data,true);
		$tempform .=$this->load->view('unrepair_information/v_unrepair_information_view',$this->data,true);

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
	
	public function get_unrepairequ_list($cond = FALSE)
	{
		if(MODULES_VIEW=='N')
		{
			 $array["ureq_unrepairableequid"]='';
			 $array["equipmentkey"] ='';
			 $array["resoan_disommission"]='';
			 $array["description"]='';
			 $array["postdatead"]='';
			 $array["action"]='';
			  echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));
                exit;
		}
		$this->data = $this->unrepair_information_mdl->get_unrepair_request_rec();
	  	$i = 0;
		$array = array();
		$filtereddata = ($this->data["totalfilteredrecs"]>0?$this->data["totalfilteredrecs"]:$this->data["totalrecs"]);
		$totalrecs = $this->data["totalrecs"];

	    unset($this->data["totalfilteredrecs"]);
	  	unset($this->data["totalrecs"]);
	  
		  	foreach($this->data as $row)
		    {
		   
			    $array[$i]["ureq_unrepairableequid"] = '<a href="javascript:void(0)" class="patlist" data-patientid='.$row->ureq_unrepairableequid.'>'.$row->ureq_unrepairableequid.'</a>';
			    $array[$i]["equipmentkey"] = $row->bmin_equipmentkey;
			    $array[$i]["resoan_disommission"] = $row->ureq_resoan_disommission;
			     $array[$i]["description"] = $row->eqli_description;
			    $array[$i]["postdatead"] = $row->ureq_postdatead;
			    $array[$i]["action"] =
			   	'<a href="javascript:void(0)" data-id='.$row->ureq_unrepairableequid.' data-displaydiv="Distributer" data-viewurl='.base_url('biomedical/unrepair_information/view_unrepair_information').' class="view" data-heading="Unrepairable Equipment" ><i class="fa fa-eye" aria-hidden="true" ></i></a>&nbsp;';
			    $i++;
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}



}