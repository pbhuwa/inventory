<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Scheme extends CI_Controller
{
	function __construct()
	{
			
		parent::__construct();
		$this->load->Model('scheme_mdl');
		
	}
	
	public function index()
	{
		
		$this->data['department_all']=$this->scheme_mdl->get_all_scheme();
		$this->data['community_list']=$this->general->get_tbl_data('*', 'comm_community', false);
		$this->data['editurl']=base_url().'settings/scheme/editscheme';
		$this->data['deleteurl']=base_url().'settings/scheme/deletescheme';
		//echo "<pre>";print_r($this->data['department_all']);die;
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
			->build('scheme/v_scheme', $this->data);
	}

	public function form_scheme()
	{
		$this->load->view('scheme/v_schemeform');
	}

	public function save_scheme()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		try {
			$this->form_validation->set_rules($this->scheme_mdl->validate_settings_scheme);
			if($this->form_validation->run()==TRUE)
			{
            $trans = $this->scheme_mdl->scheme_save();
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


	public function editscheme()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$id=$this->input->post('id');
		    $data['community_list']=$this->general->get_tbl_data('*', 'comm_community', false);
			$data['comm_data']=$this->scheme_mdl->get_all_scheme(array('sche_schemeid'=>$id));
			// echo "<pre>";
			// print_r($data['community_list']);
			// die();
			$tempform=$this->load->view('scheme/v_schemeform',$data,true);
			// echo $tempform;
			// die();
			if(!empty($data['comm_data']))
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

	public function deletescheme()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$id=$this->input->post('id');
			$trans=$this->scheme_mdl->remove_scheme();
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

	public function get_schema_data()
    {
   		$data = $this->scheme_mdl->get_schema_list(); //echo"<pre>";print_r($data) ;die;
    	$i = 0;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
	  	foreach($data as $row)
		    {
		   
			    $array[$i]["sche_schemeid"] = '<a href="javascript:void(0)" class="patlist" data-patientid='.$row->sche_schemeid.'>'.$row->sche_schemeid.'</a>';
			    $array[$i]["schemecode"] = $row->sche_schemecode;
			    $array[$i]["scheme"] = $row->sche_scheme;
			    $array[$i]["validfromdatead"] = $row->sche_validfromdatead;
			    $array[$i]["action"] ='<a href="javascript:void(0)" data-id='.$row->sche_schemeid.' data-displaydiv="scheme" class="btnEdit" data-viewurl='.base_url('settings/scheme/editscheme').'><i class="fa fa-edit" aria-hidden="true" ></i></a>';
			    
			    $i++;
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
