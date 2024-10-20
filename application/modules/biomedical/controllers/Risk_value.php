<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Risk_value extends CI_Controller
{
	function __construct()
	{
			
		parent::__construct();
		$this->load->Model('risk_value_mdl');
		
	}

	public function index()
    {

		$this->data['risk_value_all'] = $this->risk_value_mdl->get_all_risk_value();

		$this->data['editurl'] = base_url().'biomedical/risk_value/editrisk_value';
		$this->data['deleteurl'] = base_url().'biomedical/risk_value/deleterisk_value';
		$this->data['listurl']=base_url().'biomedical/risk_value/list_risk_value';
		// echo "<pre>";
		// print_r($this->input->post());
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
			->build('risk_value/v_risk_value', $this->data);
	}
    
    public function list_risk_value()
    {
    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    		if(MODULES_VIEW=='N')
				{
				$this->general->permission_denial_message();
				exit;
				}
			$this->data=array();
			$template=$this->load->view('risk_value/v_risk_value_list',$this->data,true);
			print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));
	   		 exit;	
		}
		else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}
    }
	public function save_risk_value()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		try {
			if($this->input->post('id'))
			{
				if(MODULES_UPDATE=='N')
				{
				$this->general->permission_denial_message();
				exit;
				}
			}
			else
			{
				if(MODULES_INSERT=='N')
				{
				$this->general->permission_denial_message();
				exit;
				}
			}

			$id=$this->input->post('id');
				if($id)
			{
					$this->data['risk_data']=$this->risk_value_mdl->get_all_risk_value(array('rv.riva_riskid'=>$id));
				// echo "<pre>";
				// print_r($this->data['dept_data']);
				// die();
			if($this->data['risk_data'])
			{
				$dep_date=$this->data['risk_data'][0]->riva_postdatead;
				$dep_time=$this->data['risk_data'][0]->riva_posttime;
				$editstatus=$this->general->compute_data_for_edit($dep_date,$dep_time);
				$usergroup=$this->session->userdata(USER_GROUPCODE);
				
				if($editstatus==0 && $usergroup!='SA' )
				{
					   $this->general->disabled_edit_message();

				}

			}
			}
			
			$this->form_validation->set_rules($this->risk_value_mdl->validate_risk_value);
			
			
			  if($this->form_validation->run()==TRUE)
			 {

            $trans = $this->risk_value_mdl->save_risk_value();
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
	public function form_risk_value()
		{
			$this->data['risk_value_all'] = $this->risk_value_mdl->get_all_risk_value();
			$this->load->view('risk_value/v_risk_valueform',$this->data);
		}

	public function editrisk_value()
	{   $id=$this->input->post('id'); 
			
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if(MODULES_UPDATE=='N')
				{
				$this->general->permission_denial_message();
				exit;
				}

			$id=$this->input->post('id');
		
			$this->data['risk_data']=$this->risk_value_mdl->get_all_risk_value(array('rv.riva_riskid'=>$id));
			// echo "<pre>";
			// print_r($this->data['pudo_data']);
			// die();
					if($this->data['risk_data'])
		{
			$dep_date=$this->data['risk_data'][0]->riva_postdatead;
			$dep_time=$this->data['risk_data'][0]->riva_posttime;
			$editstatus=$this->general->compute_data_for_edit($dep_date,$dep_time);
			// echo $editstatus;
			// die();
			$this->data['edit_status']=$editstatus;

		}
			$tempform = $this->load->view('risk_value/v_risk_valueform',$this->data,true);
			// echo $tempform;
			// die();
			if(!empty($this->data['risk_data']))
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

	public function deleterisk_value()
    {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if(MODULES_DELETE=='N')
				{
				$this->general->permission_denial_message();
				exit;
				}

			$id=$this->input->post('id');
			$trans=$this->risk_value_mdl->remove_risk_value();
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


	public function get_risk_value()
    {
    	if(MODULES_VIEW=='N')
		{
			 $array["riva_riskid"]='';
			 $array["risk"] ='';
			 $array["riva_times"]='';
			 $array["comments"]='';
			 $array["postdatead"]='';
			 $array["postdatebs"] ='';
			 $array["action"]='';
			  echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));
                exit;
		}
		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);

		$orgid = $this->session->userdata(ORG_ID);
		if($useraccess == 'B')
		{
			$this->data = $this->risk_value_mdl->get_risk_value_list();
		}else{
			$this->data = $this->risk_value_mdl->get_risk_value_list(array('riva_orgid'=>$orgid));
		}
    	
    	$i = 0;
		$array = array();
		$filtereddata = ($this->data["totalfilteredrecs"]>0?$this->data["totalfilteredrecs"]:$this->data["totalrecs"]);
		$totalrecs = $this->data["totalrecs"];

	    unset($this->data["totalfilteredrecs"]);
	  	unset($this->data["totalrecs"]);
	  	foreach($this->data as $row)
		    {
		   
			    $array[$i]["riva_riskid"] = '<a href="javascript:void(0)" class="patlist" data-patientid='.$row->riva_riskid.'>'.$row->riva_riskid.'</a>';
			    $array[$i]["risk"] = $row->riva_risk;
			    $array[$i]["riva_times"] = $row->riva_times;
			    
			    $array[$i]["comments"] = $row->riva_comments;
			    $array[$i]["postdatead"] = $row->riva_postdatead;
			     $array[$i]["postdatebs"] = $row->riva_postdatebs;
			    $array[$i]["action"] ='<a href="javascript:void(0)" data-id='.$row->riva_riskid.' data-displaydiv="risk_value" data-viewurl='.base_url('biomedical/risk_value/editrisk_value').' class="btnEdit"><i class="fa fa-edit" aria-hidden="true" ></i></a>
			    <a href="javascript:void(0)" data-id='.$row->riva_riskid.' data-tableid='.($i+1).' data-deleteurl='. base_url('biomedical/risk_value/deleterisk_value') .' class="btnDeleteServer"><i class="fa fa-trash-o" aria-hidden="true" ></i></a>';
			    
			    $i++;
		        //(object)array('',$row->studentregno,$row->firstname,$row->classsemyear,$row->section,$row->rollno,$row->gender,'');
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */