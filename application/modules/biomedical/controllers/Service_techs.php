<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Service_techs extends CI_Controller
{
	function __construct()
	{
			
		parent::__construct();
		$this->load->Model('service_techs_mdl');
		
	}

	public function index()
    {
    	$this->data['editurl'] = base_url().'biomedical/service_techs/editservice_techs';
		$this->data['deleteurl'] = base_url().'biomedical/service_techs/deleteservice_techs';
		$this->data['listurl']=base_url().'biomedical/service_techs/list_service_techs';
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
			->build('service_techs/v_service_techs', $this->data);
	}

	public function list_service_techs()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if(MODULES_VIEW=='N')
				{
				$this->general->permission_denial_message();
				exit;
				}
			$this->data=array();
			$template=$this->load->view('service_techs/v_service_tec_list',$this->data,true);
			print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));
	   		 exit;	
		}
		else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}
	}

	public function form_service_tec()
	{
		$this->load->view('service_techs/v_service_techsform');
	}

	public function get_all_service_tec($result=false, $org_id=false)
	{
		$this->data['result']=$result;
        $this->data['org_id']=$org_id;
		$this->load->view('service_techs/v_service_tec_list', $this->data);
	}
	public function save_service_techs()
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
				$this->data['sete_data']=$this->service_techs_mdl->get_all_service_techs(array('st.sete_techid'=>$id));
				// echo "<pre>";
				// print_r($this->data['dept_data']);
				// die();
			if($this->data['sete_data'])
			{
				$dep_date=$this->data['sete_data'][0]->sete_postdatead;
				$dep_time=$this->data['sete_data'][0]->sete_posttime;
				$editstatus=$this->general->compute_data_for_edit($dep_date,$dep_time);
				$usergroup=$this->session->userdata(USER_GROUPCODE);
				
				if($editstatus==0 && $usergroup!='SA' )
				{
					   $this->general->disabled_edit_message();

				}

			}
			}
		
			
			$this->form_validation->set_rules($this->service_techs_mdl->validate_service_techs);
			
			
			  if($this->form_validation->run()==TRUE)
			 {

            $trans = $this->service_techs_mdl->save_service_techs();
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
	public function form_service_techs()
		{
			$this->load->view('service_techs/v_service_techsform');
		}

	public function editservice_techs()
	{   $id=$this->input->post('id'); 
			
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if(MODULES_UPDATE=='N')
				{
				$this->general->permission_denial_message();
				exit;
				}

			$id=$this->input->post('id');
		
			$this->data['sete_data']=$this->service_techs_mdl->get_all_service_techs(array('st.sete_techid'=>$id));
			// echo "<pre>";
			// print_r($this->data['pudo_data']);
			// die();
			if($this->data['sete_data'])
		{
			$dep_date=$this->data['sete_data'][0]->sete_postdatead;
			$dep_time=$this->data['sete_data'][0]->sete_posttime;
			$editstatus=$this->general->compute_data_for_edit($dep_date,$dep_time);
			// echo $editstatus;
			// die();
			$this->data['edit_status']=$editstatus;

		}
			$tempform = $this->load->view('service_techs/v_service_techsform',$this->data,true);
			// echo $tempform;
			// die();
			if(!empty($this->data['sete_data']))
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

	public function deleteservice_techs()
    {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if(MODULES_DELETE=='N')
				{
				$this->general->permission_denial_message();
				exit;
				}

			$id=$this->input->post('id');
			$trans=$this->service_techs_mdl->remove_service_techs();
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

	public function get_servicetech($result=false ,$orgid=false)
	{   
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			
		}	
			$useraccess= $this->session->userdata(USER_ACCESS_TYPE);
			if($orgid){
				$org_id=$orgid;
			}
			else
			{
				$org_id = $this->session->userdata(ORG_ID); 
			}
			

			if($useraccess == 'B')
			{
				if($orgid)
				{
					$srchcol=array('sete_orgid'=>$org_id);
				}
				else
				{
					$srchcol='';
				}
				$this->data = $this->service_techs_mdl->get_servicetech_list($srchcol); 
			}else{

				$this->data = $this->service_techs_mdl->get_servicetech_list(array('sete_orgid'=>$org_id));
			//print_r($this->data);die;
			}
			if($result == 'cur'){
				$cond=array('sete_postdatead'=>date("Y/m/d"), 'sete_orgid'=>$org_id);
				$this->data = $this->service_techs_mdl->get_servicetech_list($cond);
			}
				
	    	$i = 0;
			$array = array();
			$filtereddata = ($this->data["totalfilteredrecs"]>0?$this->data["totalfilteredrecs"]:$this->data["totalrecs"]);
			$totalrecs = $this->data["totalrecs"];

		    unset($this->data["totalfilteredrecs"]);
		  	unset($this->data["totalrecs"]);
		  	foreach($this->data as $row)
			    {
			   
				    $array[$i]["sete_techid"] = '<a href="javascript:void(0)" class="patlist" data-patientid='.$row->sete_techid.'>'.$row->sete_techid.'</a>';
				    $array[$i]["name"] = $row->sete_name;
				    $array[$i]["workphone"] = $row->sete_workphone;
				    $array[$i]["email"] = $row->sete_email;
				    $array[$i]["address1"] = $row->sete_address1;
				    $array[$i]["action"] ='<a href="javascript:void(0)" data-id='.$row->sete_techid.' data-displaydiv="service_techs" data-viewurl='.base_url('biomedical/service_techs/editservice_techs').' class="btnEdit"><i class="fa fa-edit" aria-hidden="true" ></i></a>
				    <a href="javascript:void(0)" data-id='.$row->sete_techid.' data-tableid='.($i+1).' data-deleteurl='. base_url('biomedical/service_techs/deleteservice_techs') .' class="btnDeleteServer"><i class="fa fa-trash-o" aria-hidden="true" ></i></a>';
				    
				    $i++;
			    }
	        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
