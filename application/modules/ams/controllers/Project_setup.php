<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Project_setup extends CI_Controller
{
	function __construct()
	{
			
		parent::__construct();
		
		$this->load->Model('project_setup_mdl');
		$this->load->library('upload');
		$this->load->library('image_lib');
		$this->load->helper('file');
		$this->load->helper('form');

	}

	public function index()
	{
	 	 $this->data['fiscal_year']=$this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','ASC');
	    $this->data['distributors']=$this->general->get_tbl_data('*','dist_distributors',array('dist_isactive'=>'Y'));
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
		$this->data['breadcrumb']='Project Setup';
		// $this->data['tab_type']="Log";
		// $this->session->unset_userdata('id');
		// $this->page_title='Assets Assets';
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)
			->build('project_setup/v_project_list', $this->data);

	}

	public function project_entry($reload=false)
	{	
		$id=$this->input->post('id');
				$locationid=$this->session->userdata(LOCATION_ID);
		$currentfyrs=CUR_FISCALYEAR;


		$cur_fiscalyrs_invoiceno=$this->db->select('prin_code,prin_fiscalyrs')
									->from('prin_projectinfo')
									->where('prin_locationid',$locationid)
									// ->where('prin_fiscalyrs',$currentfyrs)
									->order_by('prin_fiscalyrs','DESC')
									->limit(1)
									->get()->row();

		// echo "<pre>";
		// print_r($cur_fiscalyrs_invoiceno);
		// die();

		if(!empty($cur_fiscalyrs_invoiceno)){
			$invoice_format=$cur_fiscalyrs_invoiceno->prin_code;
			
			$invoice_string=str_split($invoice_format);
			// echo "<pre>";
			// print_r($invoice_string);
			// die();
			$invoice_prefix_len=strlen(PROJECT_CODE_NO_PREFIX);
			$chk_first_string_after_invoice_prefix=!empty($invoice_string[$invoice_prefix_len])?$invoice_string[$invoice_prefix_len]:'';
			// echo $chk_first_string_after_invoice_prefix;
			// die();
			if($chk_first_string_after_invoice_prefix =='0'){
				$invoice_no_prefix=PROJECT_CODE_NO_PREFIX.CUR_FISCALYEAR;
			}
			else if ($cur_fiscalyrs_invoiceno->prin_fiscalyrs==$currentfyrs && $chk_first_string_after_invoice_prefix =='0' ) {
				$invoice_no_prefix=PROJECT_CODE_NO_PREFIX.CUR_FISCALYEAR;
			}
			else if ($cur_fiscalyrs_invoiceno->prin_fiscalyrs!=$currentfyrs && $chk_first_string_after_invoice_prefix =='0' ) {
				$invoice_no_prefix=PROJECT_CODE_NO_PREFIX.CUR_FISCALYEAR;
			}
			else if ($cur_fiscalyrs_invoiceno->prin_fiscalyrs!=$currentfyrs && $chk_first_string_after_invoice_prefix !='0' ) {
				$invoice_no_prefix=PROJECT_CODE_NO_PREFIX.CUR_FISCALYEAR;
			}
			else{
				$invoice_no_prefix=PROJECT_CODE_NO_PREFIX;
			}
			
		}
		else{
			$invoice_no_prefix=PROJECT_CODE_NO_PREFIX.CUR_FISCALYEAR;
		}
		$this->data['project_code'] = $this->general->generate_invoiceno('prin_code','prin_code','prin_projectinfo',$invoice_no_prefix,PROJECT_CODE_NO_LENGTH,false,'prin_locationid');

		// echo $this->data['project_code'];
		// die();

		$this->data['project_rec_data']=$this->general->get_tbl_data('*','prin_projectinfo',array('prin_prinid'=>$id),'prin_prinid','ASC');

		
		 $this->data['fiscal_year']=$this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','DESC','2',false);
		 // echo $this->db->last_query();
		 // die();
	    $this->data['distributors']=$this->general->get_tbl_data('*','dist_distributors',array('dist_isactive'=>'Y'));

	    $html=$this->load->view('project_setup/v_project_form',$this->data,true);
		if($html){
		  		$template=$html;
		  		  print_r(json_encode(array('status'=>'success','tempform'=>$template,'message'=>'Successfully Selected')));
	        	exit;
		  	}else{
	        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        	exit;
	        }

		
	}

	public function save_project($print=false){
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		try {
			// echo "<pre>";
			// print_r($this->input->post());
			// die();

			// if($this->input->post('id'))
			// {
			// 	if(MODULES_UPDATE=='N')
			// 	{
			// 		$this->general->permission_denial_message();
			// 		exit;
			// 	}

			// 	$action_log_message = "edit";
			// }
			// else
			// {
			// 	if(MODULES_INSERT=='N')
			// 	{
			// 		$this->general->permission_denial_message();
			// 		exit;
			// 	}
			// 	$action_log_message = "";
			// }

			$this->form_validation->set_rules($this->project_setup_mdl->validate_project_setup);
			if($this->form_validation->run()==TRUE)
			{   
			// echo "<pre>";
			// print_r($this->input->post());
			// die();

			$trans = $this->project_setup_mdl->project_setup_save();
			if($trans){		
				if($print == "print")
				{	

				$print_report='';
				
				print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully.', 'print_report'=>$print_report)));
				exit;
				}
				print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully.')));
				exit;
			}
			else{
				print_r(json_encode(array('status'=>'error','message'=>'Unsuccessful Operation.')));
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
}else{
	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	exit;
 }

}

	public function get_project_setup_list()
	{
		// echo "hi";
		// die();
		// if(MODULES_VIEW=='N')
		// 	{
		// 	  	$array["asen_assetcode"] ='';
		// 	    $array["asen_assettype"] = '';
		// 	    $array["asen_modelno"] =''; '';
		// 	    $array["asen_serialno"] = '';
		// 	    $array["asen_status"] = '';
		// 	    $array["asen_condition"] = '';
  		//      $array["action"]='';
  		//         echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));
  		//          exit;
		// 	}
		$useraccess= $this->session->userdata(USER_ACCESS_TYPE);
		$orgid = $this->session->userdata(ORG_ID);
		$data = $this->project_setup_mdl->get_all_project_rec_list();
		// echo "<pre>"; print_r($data); die();
 
	  	$i = 0;
		$array = array();
		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);
		$totalrecs = $data["totalrecs"];

	    unset($data["totalfilteredrecs"]);
	  	unset($data["totalrecs"]);
	  
		  	foreach($data as $row)
		    {
		    	$array[$i]["sn"] = $i+1;
			    $array[$i]["prin_fiscalyrs"] = $row->prin_fiscalyrs;
			    $array[$i]["prin_code"] = $row->prin_code;
			    $array[$i]["prin_project_title"] = $row->prin_project_title;
			    $array[$i]["prin_project_desc"] = $row->prin_project_desc;
			    $array[$i]["prin_startdatebs"] = $row->prin_startdatebs;
			    $array[$i]["prin_estenddatebs"] = $row->prin_estenddatebs;
			    $array[$i]["prin_contractno"] = $row->prin_contractno;
			    $array[$i]["action"] ='<a href="javascript:void(0)" data-id='.$row->prin_prinid.' data-displaydiv="assets" data-viewurl='.base_url('ams/project_setup/editdeproject').' class="view" data-viewurl="'.base_url().'/ams/project_setup/editdeproject"><i class="fa fa-edit" aria-hidden="true" ></i></a> | 
			    	<a href="javascript:void(0)" data-id='.$row->prin_prinid.' data-tableid='.$row->prin_prinid.' data-deleteurl='.base_url('ams/assets/assets_delete') .' class="btnDeleteServer"><i class="fa fa-trash-o" aria-hidden="true" ></i></a> | 
			    	<a href="javascript:void(0)" data-id='.$row->prin_prinid.' data-displaydiv="assets" data-viewurl='.base_url('/ams/assets/comp_assets_details').' class="view" data-heading="Project Setup Details"><i class="fa fa-eye" aria-hidden="true" ></i></a> | 
			    	<a href="javascript:void(0)" data-id='.$row->prin_prinid.' data-displaydiv="assets" data-viewurl='.base_url('ams/project_setup/project_bill_entry').' class="view" data-viewurl="'.base_url().'/ams/project_setup/project_bill_entry"><i class="fa fa-plus" aria-hidden="true" ></i></a> ';
			     
			    $i++;
		        //(object)array('',$row->studentregno,$row->firstname,$row->classsemyear,$row->section,$row->rollno,$row->gender,'');
		    }
        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));
	}

	
public function project_bill_entry($reload=false)
	{	
		$id=$this->input->post('id');
		$project_id = $this->input->post('prbl_projectid');
		$this->data['project_id']=$id;

		// $this->data['project_bill_data']=$this->general->get_tbl_data('*','prbl_projectbill',array('prbl_prblid'=>$id),'prbl_prblid','ASC');
		$this->data['project_bill_data']=$this->general->get_tbl_data('*','prbl_projectbill',array('prbl_projectid'=>$id),'prbl_prblid','ASC');
		// echo $this->db->last_query();
		// die();
		// $this->data['project_rec_data']=$this->general->get_tbl_data('*','prin_projectinfo',array('prin_prinid'=>$pbid),'prin_prinid','ASC');
		// echo "<pre>";
		// print_r($this->data['project_bill_data']);
		// die();
		 $this->data['fiscal_year']=$this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','DESC','2',false);
		 // echo $this->db->last_query();
		 // die();
	    $this->data['distributors']=$this->general->get_tbl_data('*','dist_distributors',array('dist_isactive'=>'Y'));

	    $html=$this->load->view('project_setup/v_project_bill',$this->data,true);
		if($html){
		  		$template=$html;
		  		  print_r(json_encode(array('status'=>'success','tempform'=>$template,'message'=>'Successfully Selected')));
	        	exit;
		  	}else{
	        	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	        	exit;
	        }
	}

	public function save_project_bill($print=false){
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		try {
			// echo "<pre>";
			// print_r($this->input->post());
			// die();

			// if($this->input->post('id'))
			// {
			// 	if(MODULES_UPDATE=='N')
			// 	{
			// 		$this->general->permission_denial_message();
			// 		exit;
			// 	}

			// 	$action_log_message = "edit";
			// }
			// else
			// {
			// 	if(MODULES_INSERT=='N')
			// 	{
			// 		$this->general->permission_denial_message();
			// 		exit;
			// 	}
			// 	$action_log_message = "";
			// }

			$this->form_validation->set_rules($this->project_setup_mdl->validate_project_bill_setup);
			if($this->form_validation->run()==TRUE)
			{   
			// echo "<pre>";
			// print_r($this->input->post());
			// die();

			$trans = $this->project_setup_mdl->project_bill_setup_save();
			if($trans){		
				if($print == "print")
				{	

				$print_report='';
				
				print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully.', 'print_report'=>$print_report)));
				exit;
				}
				print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully.')));
				exit;
			}
			else{
				print_r(json_encode(array('status'=>'error','message'=>'Unsuccessful Operation.')));
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
}else{
	print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));
	exit;
 }

}

	public function editdeproject()
	{   



		// if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			// if(MODULES_UPDATE=='N')

			// 	{

			// 	$this->general->permission_denial_message();

			// 	exit;

			// 	}
   
		    $id=$this->input->post('id');

		    $this->data['project_rec_data']=$this->general->get_tbl_data('*','prin_projectinfo',array('prin_prinid'=>$id),false,'false');
		    $this->data['fiscal_year']=$this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','DESC','2',false);
		 // echo $this->db->last_query();
		 // die();
	    $this->data['distributors']=$this->general->get_tbl_data('*','dist_distributors',array('dist_isactive'=>'Y'));


		// echo "<pre>";print_r($this->data['file_manager_data']);die;

			$tempform = $this->load->view('project_setup/v_project_form',$this->data,true);

	

			if(!empty($this->data['project_rec_data']))

			{

					print_r(json_encode(array('status'=>'success','message'=>'You Can edit','tempform'=>$tempform)));

	            	exit;

			}

			else{

				print_r(json_encode(array('status'=>'error','message'=>'Unable to Edit!!')));

	            	exit;

			}

		// }

		// else

		// {

		// print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

	 //        exit;

		// }



	}
		
}
