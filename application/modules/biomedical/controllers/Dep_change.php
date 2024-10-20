<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dep_change extends CI_Controller
{
	function __construct()
	{
			
		parent::__construct();
		$this->load->Model('dep_change_mdl');
		$this->load->Model('equipment_mdl');
		$this->load->Model('bio_medical_mdl');
		$this->load->Model('repair_request_info_mdl');
		$this->load->Model('settings/department_mdl','department_mdl');
		
	}

	public function index()
    {

		//$this->data['equipment_all'] = $this->equipment_mdl->get_all_equipment();

		$this->data['editurl']=base_url().'biomedical/equipments/editdeequipment';
		$this->data['deleteurl']=base_url().'biomedical/equipments/deletedeequipment';
		$this->data['listurl']=base_url().'biomedical/dep_change/v_dep_change_log';
		
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
		$this->data['breadcrumb']='Equipments/Change Department ';
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('dep_change/v_dep_change', $this->data);
	}

	public function get_equdatadetail_depchange()
	{   
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$equid_key=$this->input->post('id');

			$this->data['eqli_data'] = $this->bio_medical_mdl->get_biomedical_inventory(array('bm.bmin_equipmentkey'=>$equid_key));

		


			if($this->data['eqli_data'])
			{
			$equid=$this->data['eqli_data'][0]->bmin_equipid;
			$this->data['equid']=$equid;
			$this->data['listurl']=base_url().'biomedical/dep_change/list_depchange_equipment/'.$equid;

			$this->data['equip_dep_change_list'] = $this->dep_change_mdl->get_change_equip_department(array('eqch.eqdc_equipid'=>$equid),false,false,'eqdc_eqdepchangeid','DESC');
			
			$this->data['equip_comment'] = $this->bio_medical_mdl->get_equip_comment(array('ec.eqco_eqid'=>$equid));
			$this->data['repair_comment'] = $this->repair_request_info_mdl->repair_request_info(array('r.rere_equid'=>$equid));
			$this->data['dep_information']=$this->department_mdl->get_all_department(array('dept_deptype'=>BIOMEDICALID));
			}

		
			//$this->data['history'] = $this->pm_data_mdl->get_pm_report_by_department(array('pmta_equipid'=>$equid));
			//echo "<pre>";print_r($this->data['pmdata']);die();
			$tempform= $this->load->view('dep_change/v_equi_detail_dep_change',$this->data,true);
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

	public function list_depchange_equipment($equid=false)
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   //  		if(MODULES_VIEW=='N')
			// {
			// $this->general->permission_denial_message();
			// exit;
			// }
		$this->data['equip_dep_change_list'] = $this->dep_change_mdl->get_change_equip_department(array('eqch.eqdc_equipid'=>$equid),false,false,'eqdc_eqdepchangeid','DESC');
			$template=$this->load->view('dep_change/v_dep_change_log',$this->data,true);
			print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));
	   		 exit;	
		}
		else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}
	}


	public function save_dep_change()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		try {
			// if($this->input->post('id'))
			// {
			// 	if(MODULES_UPDATE=='N')
			// 	{
			// 	$this->general->permission_denial_message();
			// 	exit;
			// 	}
			// }
			// else
			// {
			// 	if(MODULES_INSERT=='N')
			// 	{
			// 	$this->general->permission_denial_message();
			// 	exit;
			// 	}
			// }

			
			$this->form_validation->set_rules($this->dep_change_mdl->validate_settings_dep_change);
		  if($this->form_validation->run()==TRUE)
			 {
            $trans = $this->dep_change_mdl->save_department_change();
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

	public function get_dep_change_log()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if(MODULES_VIEW=='N')
				{
				$this->general->permission_denial_message();
				exit;
				}
			$data=array();
			$template=$this->load->view('dep_change/v_dep_change_log',$data,true);
			print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));
	   		 exit;	
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