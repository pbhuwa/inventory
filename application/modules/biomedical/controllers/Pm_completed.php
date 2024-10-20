<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pm_completed extends CI_Controller
{
	function __construct()
	{
			
		parent::__construct();
		$this->load->Model('pm_completed_mdl');
		$this->load->Model('bio_medical_mdl');
		$this->load->Model('pm_data_mdl');
		// $this->load->Model('service_tech_mdl');
	}

	public function index()
	{
		$this->data['pm_completed_list']=$this->pm_completed_mdl->get_all_pm_completed();
		
		// echo '<pre>';
		// print_r($this->data['pm_completed_list']);
		// die();

		$this->data['editurl']=base_url().'biomedical/pm_completed/editpm_completed';
		$this->data['deleteurl']=base_url().'biomedical/pm_completed/deletepm_completed';
		$this->data['listurl']=base_url().'biomedical/pm_completed/list_pm_completed';
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
			->build('pm_completed/v_pm_completed', $this->data);
	}
    public function list_pm_completed()
    {
    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$data=array();
			$template=$this->load->view('pm_completed/v_pm_completed_list',$data,true);
			print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));
	   		 exit;	
		}
		else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}
    }
	public function form_pm_completed()
	{
		$this->load->view('pm_completed/v_pm_completedform');
	}

	public function save_pm_completed()
	{   
		 //echo '<pre>'; print_r($this->input->post());die();
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		// try {
			$result=$this->input->post('pmco_results');
			$amc=$this->input->post('pmta_amc');
			$pmtaid=$this->input->post('pmtaid');
			$pm_data=$this->pm_data_mdl->get_all_pm_data(array('pmta_pmtableid'=>$pmtaid));
			// echo "<pre>";
			// print_r($pm_data);
			// die();
			$pmcomplete=$pm_data[0]->pmta_ispmcompleted;
			if($pmcomplete=='1')
			{
				 print_r(json_encode(array('status'=>'error','message'=>'PM Already Completed!!')));
            	exit;
			}

			// echo $result;
			// die();
			if($result=='comment')
			{
				$this->form_validation->set_rules('pmco_comments', 'Comments', 'trim|required|xss_clean');
			}
			if($amc=='Y')
			{
				$this->form_validation->set_rules('pmta_amccontractorid', 'AMC Contractor', 'trim|required|xss_clean');
			}
		$this->form_validation->set_rules($this->pm_completed_mdl->validate_settings_pm_completed);
			
			 if($this->form_validation->run()==TRUE)
			{

            $trans = $this->pm_completed_mdl->save_pm_completed();
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
           
        // } catch (Exception $e) {
          
        //     print_r(json_encode(array('status'=>'error','message' => $e->getMessage())));
        // }
	    }
	 else
	    {
	    	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	            exit;
	    }
	}


	public function editpm_completed()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$id=$this->input->post('id');
		
			$data['pm_completed_data']=$this->pm_completed_mdl->get_all_pm_completed(array('pmco_pmcompletedid'=>$id));
			
			// echo "<pre>";
			// print_r($data['pm_completed_data']);
			// die();
			$tempform = $this->load->view('pm_completed/v_pm_completedform',$data,true);
			// echo $tempform;
			// die();
			if(!empty($data['pm_completed_data']))
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

	public function deletepm_completed()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$id=$this->input->post('id');
			$trans=$this->pm_completed_mdl->remove_pm_completed();
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
	
	public function get_equipment_list()
	{
		$data = $this->pm_completed_mdl->get_all_pm_completed();

		//echo "<pre>";print_r($data);die();
	  	$i = 0;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
	  
		  	foreach($data as $row)
		    {
		   
			    $array[$i]["pmco_pmcompletedid"] = '<a href="javascript:void(0)" class="patlist" data-patientid='.$row->pmco_pmcompletedid.'>'.$row->pmco_pmcompletedid.'</a>';
			    $array[$i]["department"] = $row->pmco_department;
			    $array[$i]["description"] = $row->pmco_description;
			    $array[$i]["amccontractor"] = $row->pmco_amccontractor;
			    $array[$i]["results"] = $row->pmco_results;
			    $array[$i]["comments"] = $row->pmco_comments;
			    $array[$i]["action"] ='<a href="javascript:void(0)" data-id='.$row->pmco_pmcompletedid.' data-displaydiv="equipments" data-viewurl='.base_url('biomedical/equipments/editdeequipment').' class="btnEdit"><i class="fa fa-edit" aria-hidden="true" ></i></a>
			    <a href="javascript:void(0)" data-id='.$row->pmco_pmcompletedid.' data-tableid='.($i+1).' data-deleteurl='. base_url('biomedical/pm_completed/deletepm_completed') .' class="btnDeleteServer"><i class="fa fa-trash-o" aria-hidden="true" ></i></a>
			    ';
			     
			    $i++;
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}


	public function get_equdata()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$equid=$this->input->post('id');

			$data['eqli_data'] = $this->bio_medical_mdl->get_biomedical_inventory(array('bm.bmin_equipmentkey'=>$equid));
			//echo "<pre>"; print_r($data['eqli_data']);die();
			
			$tempform = $this->load->view('pm_completed/v_equi_completeddetail',$data,true);
			// echo $tempform;die();
			
			if($data['eqli_data'])
			{
				print_r(json_encode(array('status'=>'success','tempform'=>$tempform,'message'=>'Successfully Selected!!')));
	       		exit;	
			}
			else
			{
				$tempform='<span class="text-danger">Record Not Found!!</span>';
				print_r(json_encode(array('status'=>'success','tempform'=>$tempform,'message'=>'Successfully Selected!!')));
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


