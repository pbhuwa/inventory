<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Repair_request_info extends CI_Controller
{
	function __construct()
	{
			
		parent::__construct();
		$this->load->Model('repair_request_info_mdl');
		$this->load->Model('bio_medical_mdl');
		$this->load->Model('manufacturers_mdl');
		$this->load->Model('home/home_mdl');
	}

	public function index()
    {	
    	$this->data['listurl']=base_url().'biomedical/repair_request_info/list_repair_request_info';

    	$this->data['rr_data']='rrinfo';

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
			// ->build('repair_request_info/v_repairrequest_list', $this->data);
			->build('repair_request_info/v_repairrequest_tab', $this->data);
	}

	public function rr_completed_data()
    {	
    	$org_id = $this->session->userdata(ORG_ID); 
    	$this->data['listurl']=base_url().'biomedical/repair_request_info/lists/all/'.$org_id.'/completed';

    	$this->data['rr_data']='rrcompleted';
    	$this->data['rrtype'] = 'completed';

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
			// ->build('repair_request_info/v_repairrequest_list', $this->data);
			->build('repair_request_info/v_repairrequest_tab', $this->data);
	}

	public function assistance_data()
    {	
    	$this->data['listurl']=base_url().'biomedical/repair_request_info/list_repair_request_info';

    	$this->data['rr_data']='assistance';

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
			// ->build('repair_request_info/v_repairrequest_list', $this->data);
			->build('repair_request_info/v_repairrequest_tab', $this->data);
	}

	public function repairrequest_list()
    {	
    	$this->data['listurl']=base_url().'biomedical/repair_request_info/list_repair_request_info';

    	$this->data['rr_data']='rrinfo';

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
			->build('repair_request_info/v_repairrequest_list', $this->data);
	}

	public function repair_request()
	{
		$this->data='';
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
			->build('repair_request_info/v_repair_request_information_nepali', $this->data);
	}

	public function assistance()
	{
		// $this->data='';

		$this->data['rr_data'] = 'assistance';

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
			->build('repair_request_info/v_assistance', $this->data);

	}

	public function get_assistance_detail()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$problem=$this->input->post('id');

			$this->data['equipment_detail']=$this->repair_request_info_mdl->repair_request_info('rere_problem LIKE "%'.$problem.'%"');
			// echo "<pre>";
			// print_r($this->data['equipment_detail']);
			// die();

			$template=$this->load->view('repair_request_info/v_assistance_list',$this->data,true);
			print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','tempform'=>$template)));
	   		 exit;	
		}
		else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}

	}

	public function completed()
    {	
    	$this->data['listurl']=base_url().'biomedical/repair_request_info/list_repair_request_info';

    	$this->data['rrtype'] = "completed";
    	$this->data['rr_data'] = 'rrcompleted';

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
			->build('repair_request_info/v_repairrequest_list', $this->data);
	}
	public function get_repair_request($result=false,$org_id=false)
	{
		$this->data['result']=$result;
		$this->data['org_id']=$org_id;
		$this->data['listurl']=base_url().'biomedical/repair_request_info/list_repair_request_info';
		$this->load->view('repair_request_info/v_repairrequest_list',$this->data);
	}


	public function list_repair_request_info()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$data=array();
			$template=$this->load->view('repair_request_info/v_repairrequest_list',$data,true);
			print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));
	   		 exit;	
		}
		else
		{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        exit;
		}
	}

	public function lists($result=false,$orgid=false, $rrtype = false)
	{	
		
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
				if($rrtype == "completed"){
					$srchcol=array('rere_orgid'=>$org_id,'rere_status'=>1);
				}else{
					$srchcol=array('rere_orgid'=>$org_id,'rere_status'=>0);
				}
			}
			else
			{
				if($rrtype =="completed"){
					$srchcol=array('rere_status'=>1);
				}else{
					$srchcol=array('rere_status'=>0);
				}
			}

			
		}else{
			if($rrtype == "completed"){
				$srchcol = array('rere_orgid'=>$orgid,'rere_status'=>1);	
			}else{
				$srchcol = array('rere_orgid'=>$orgid,'rere_status'=>0);
			}
			// $this->data = $this->manufacturers_mdl->get_manufacturers_list($cond);
		}
		$data = $this->repair_request_info_mdl->get_all_repair_information($srchcol); 
		// echo"<pre>";print_r($data) ;die;

		if($result == 'cur') {
			$date = CURDATE_EN;
			$data = $this->repair_request_info_mdl->get_all_repair_information(array('rere_status'=>0,'rere_postdatead'=>$date,'rere_orgid'=>$org_id));
		}
    	$i = 0;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
	  	foreach($data as $row)
		    {
		    	$prblmtype=$row->rere_problemtype;
		    	if($prblmtype=='Ex')
		    	{
		    		$problemtype='External';
		    	}
		    	else
		    	{
		    		$problemtype='Internal';
		    	}
		    	$checkStatus = ($row->rere_status == 1)?"Completed":"Pending";
		    	$btn = ($row->rere_status == 1)?"label-success":"label-warning";
		    	 $array[$i]["id"] = '<a href="javascript:void(0)" class="patlist" data-id='.$row->rere_repairrequestid.'>'.$row->rere_repairrequestid.'</a>';
			    $array[$i]["postdatead"] = $row->rere_postdatead;
			    $array[$i]["postdatebs"] = $row->rere_postdatebs;
			    $array[$i]["posttime"] = $row->rere_posttime;
			    $array[$i]["equipmentkey"] = $row->bmin_equipmentkey;
			    $array[$i]["department"] = $row->dein_department;
			    $array[$i]["room"] = $row->rode_roomname;
			    $array[$i]["problemtype"] = $problemtype;
			    $array[$i]["problem"] = $row->rere_problem;
			    $array[$i]["action_taken"] = $row->rere_action;
			    $array[$i]["status"] ='<a href="javascript:void(0)"  data-commentid='.$row->rere_commentid.' data-status='.$row->rere_status.' data-requestid='.$row->rere_repairrequestid.' class="repairStatus label '.$btn.'">'.$checkStatus.'</a>';
			    $array[$i]["action"] ='<a href="javascript:void(0)" data-id='.$row->rere_repairrequestid.' data-displaydiv="RepairInformation" data-viewurl='.base_url('biomedical/repair_request_info/view_repair_info').' class="view" data-heading="View Repair Request " ><i class="fa fa-eye" aria-hidden="true" ></i></a>';
			    
			    $i++;
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}
	public function view_repair_info()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$repairid=$this->input->post('id');
			$this->data['rere_data']=$this->repair_request_info_mdl->repair_request_info(array('rere_repairrequestid'=>$repairid));
			// echo "<pre>";
			// print_r($this->data['rere_data']);
			// die();
			$this->data['part_list']=$this->repair_request_info_mdl->get_part_information(array('eqpa_repairid'=>$repairid));
			// echo "<pre>";
			// print_r($this->data['part_list']);
			// die();
			$this->data['problemtype']='';
			if($this->data['rere_data'])
			{
				$this->data['problemtype']=$this->data['rere_data'][0]->rere_problemtype;
			}

			$tempform='';

			$tempform=$this->load->view('repair_request_info/v_repair_request_information',$this->data,true);
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
	



public function get_assistance_detail_indiv()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$repairid=$this->input->post('id');
			$this->data['rere_data']=$this->repair_request_info_mdl->repair_request_info(array('rere_repairrequestid'=>$repairid));
			// echo "<pre>";
			// print_r($this->data['rere_data']);
			// die();
			$this->data['part_list']=$this->repair_request_info_mdl->get_part_information(array('rere_repairrequestid'=>$repairid));
			// echo "<pre>";
			// print_r($this->data['part_list']);
			// die();
			$this->data['problemtype']='';
			if($this->data['rere_data'])
			{
				$this->data['problemtype']=$this->data['rere_data'][0]->rere_problemtype;
			}

			$tempform='';

			$tempform=$this->load->view('repair_request_info/v_get_assistance_detail_indiv',$this->data,true);
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
	public function print_repair_info()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$repairid=$this->input->post('id');
			$print_type=$this->input->post('print_type');
			$this->data['rere_data']=$this->repair_request_info_mdl->repair_request_info(array('rere_repairrequestid'=>$repairid));
			// echo "<pre>";
			// print_r($this->data['rere_data']);
			// die();
			$this->data['part_list']=$this->repair_request_info_mdl->get_part_information(array('eqpa_repairid'=>$repairid));
			// echo "<pre>";
			// print_r($this->data['part_list']);
			// die();
			$this->data['problemtype']='';
			if($this->data['rere_data'])
			{
				$this->data['problemtype']=$this->data['rere_data'][0]->rere_problemtype;
			}

			$tempform='';
			if($print_type=='nepali')
			{
			$tempform=$this->load->view('repair_request_info/v_repair_request_information_nepali',$this->data,true);
			}
			else
			{
				
			$tempform=$this->load->view('repair_request_info/v_repair_request_information_english',$this->data,true);
			}


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


	public function viewRepairStatus(){
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$commentid = $this->input->post('commentid');
			$requestid = $this->input->post('requestid');
			$data['comment'] = $this->home_mdl->get_repair_data(array('ec.eqco_equipmentcommentid'=>$commentid));
			$data['repairStatus'] = $this->repair_request_info_mdl->repair_request_info(array('rere_repairrequestid'=>$requestid));

			$templateData = $this->load->view('repair_request_info/v_repairrequest_confirm', $data, true);
			print_r(json_encode(array('status'=>'success','message'=>'Repair Request Confirmation','repairdata'=>$templateData)));
	        exit;
        }
        else
        {
            print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
            exit;
        }
	}

	public function updateRepairStatus(){
		if($_SERVER['REQUEST_METHOD'] === 'POST'){
			$trans = $this->repair_request_info_mdl->updateRepairStatus();

			if($trans)
            {
            	print_r(json_encode(array('status'=>'success','message'=>'Repair Request Confirmed.')));
            	exit;
            }
            else
            {
            	print_r(json_encode(array('status'=>'error','message'=>'Operation Unsuccessful.')));
            	exit;
            }

		}else{
			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation.')));
            exit;
		}
	}

	public function repairRequestCompleted(){
		try{
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$commentid = $this->input->post('commentid');
				$requestid = $this->input->post('requestid');
				$data['completeData'] = $this->repair_request_info_mdl->repair_request_info(array('rere_repairrequestid'=>$requestid));
				$data['comment'] = $this->home_mdl->get_repair_data(array('ec.eqco_equipmentcommentid'=>$commentid));

				$templateData = $this->load->view('repair_request_info/v_repairrequest_complete', $data, true);
				print_r(json_encode(array('status'=>'success','message'=>'Repair Request Completed','completeData'=>$templateData)));
		        exit;
	        }
	        else
	        {
	            print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	            exit;
	        }
		}catch(Exception $e){
			throw $e;
		}
	}

	public function delete_repairrequest()
    {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$id=$this->input->post('id');
			//$trans=$this->pm_data_mdl->delete_repairrequest();
			$trans=$this->repair_request_info_mdl->delete_repairrequest();
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
	public function save_parts()
	{
		//echo '<pre>';
		//print_r($this->input->post()); die();
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		try {
			 $this->form_validation->set_rules($this->repair_request_info_mdl->validate_settings_parts);
			  if($this->form_validation->run()==TRUE)
			 {

            $trans = $this->repair_request_info_mdl->parts_details_save();
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
	
}