<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Department_information extends CI_Controller
{
	function __construct()
	{
			
		parent::__construct();
		$this->load->Model('department_information_mdl');
		
		
	}
	
	public function index()
	{
		
		$this->data=array();
		$data['department_all'] = "";
		$this->data['editurl']=base_url().'biomedical/department_information/editdepartment';
		$this->data['deleteurl']=base_url().'biomedical/department_information/deletedepartment';
		$this->data['listurl']=base_url().'biomedical/department_information/list_department_information';
		//$this->data['department_all'] = $this->department_information_mdl->get_all_department();
		// echo "<pre>";
		// print_r($this->data['department_all']);
		// die();
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
			->build('department_information/v_department_information', $this->data);
	}
	public function list_department_information()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$data=array();
			$template=$this->load->view('department_information/v_list_department_information',$data,true);
			print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));
	   		 exit;	
		}
		else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}
	}

	public function save_department()
	 {  
	 	//     echo "<pre>";  print_r($this->input->post());die();
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$id = $this->input->post('id');
		try {
			
			$this->form_validation->set_rules($this->department_information_mdl->validate_settings_department);
		
			if($this->form_validation->run()==TRUE)
			{

            $trans = $this->department_information_mdl->save_department();
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

	public function form_department()
		{
			$this->load->view('department_information/v_department_information');
		}
	public function editdepartment()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$id=$this->input->post('id');
			
			$data['doc_data']=$this->department_information_mdl->get_all_department(array('ds.dein_departmentid'=>$id));

			// echo "<pre>";
			// print_r($data['doc_data']);
			// die();
			$tempform=$this->load->view('department_information/v_department_informationform',$data,true);
			// echo $tempform;
			// die();
			if(!empty($data['doc_data']))
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

	public function deletedepartment()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$id=$this->input->post('id');
			$trans=$this->department_information_mdl->remove_department();
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

	public function exists_username()
	{
			$usma_username=$this->input->post('usma_username');
			$input_id=$this->input->post('id');
			$username=$this->doctor_mdl->check_exit_username_for_other($usma_username,$input_id);
			if($username)
			{
				return true;
			}
			else
			{
				$this->form_validation->set_message('exists_username', 'Alreay Exit Username.');
				return false;
			}

	}

	public function department_information_list()
	{
		$data = $this->department_information_mdl->get_department_information_list();
		// echo "<pre>";
		// print_r($data);
		// die();
	  	$i = 0;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
	  
		  	foreach($data as $row)
		    {
		   
			    $array[$i]["dein_departmentid"] = '<a href="javascript:void(0)" class="patlist" data-patientid='.$row->dein_departmentid.'>'.$row->dein_departmentid.'</a>';
			    $array[$i]["department"] = $row->dein_department;
			    $array[$i]["contact"] = $row->dein_contact;
			    $array[$i]["department_head"] = $row->dein_department_head;
			    $array[$i]["phone"] = $row->dein_phone;
			    $array[$i]["action"] ='<a href="javascript:void(0)" data-id='.$row->dein_departmentid.' data-displaydiv="departmentInformation" data-viewurl='.base_url('biomedical/department_information/editdepartment').' class="btnEdit"><i class="fa fa-edit" aria-hidden="true" ></i></a>
			    <a href="javascript:void(0)" data-id='.$row->dein_departmentid.' data-tableid='.($i+1).' data-deleteurl='. base_url('biomedical/department_information/deletedepartment') .' class="btnDeleteServer"><i class="fa fa-trash-o" aria-hidden="true" ></i></a>
			    ';
			    $i++;
		        //(object)array('',$row->studentregno,$row->firstname,$row->classsemyear,$row->section,$row->rollno,$row->gender,'');
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}



		
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */