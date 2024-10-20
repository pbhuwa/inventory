<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Repair_request extends CI_Controller

{

	function __construct()

	{

			

		parent::__construct();

		

		$this->load->Model('repair_request_mdl');

		$this->load->library('upload');

		$this->load->library('image_lib');

		$this->load->helper('file');

		$this->load->helper('form');

		$this->userid = $this->session->userdata(USER_ID);

        $this->username = $this->session->userdata(USER_NAME);



	}



	public function index($reload=false)

	{

		$this->data['reload']=$reload;

		$locationid=$this->session->userdata(LOCATION_ID);

		$currentfyrs=CUR_FISCALYEAR;





		$cur_fiscalyrs_rrreqno=$this->db->select('rerm_requestno,rerm_fiscalyrs')

									->from('rerm_repairrequestmaster')

									->where('rerm_locationid',$locationid)

									->order_by('rerm_fiscalyrs','DESC')

									->limit(1)

									->get()->row();



		// echo "<pre>";

		// print_r($cur_fiscalyrs_rrreqno);

		// die();



		if(!empty($cur_fiscalyrs_rrreqno)){

			$rreq_format=$cur_fiscalyrs_rrreqno->rerm_requestno;

			

			$invoice_string=str_split($rreq_format);

			// echo "<pre>";

			// print_r($invoice_string);

			// die();

			$rrreq_prefix_len=strlen(ASSETS_REPAIRREQ_CODE_NO_PREFIX);

			$chk_first_string_after_invoice_prefix=$invoice_string[$rrreq_prefix_len];

			// echo $chk_first_string_after_invoice_prefix;

			// die();

			if($chk_first_string_after_invoice_prefix =='0'){

				$rr_no_prefix=ASSETS_REPAIRREQ_CODE_NO_PREFIX.CUR_FISCALYEAR;

			}

			else if ($cur_fiscalyrs_rrreqno->rerm_fiscalyrs==$currentfyrs && $chk_first_string_after_invoice_prefix =='0' ) {

				$rr_no_prefix=ASSETS_REPAIRREQ_CODE_NO_PREFIX.CUR_FISCALYEAR;

			}

			else if ($cur_fiscalyrs_rrreqno->rerm_fiscalyrs!=$currentfyrs && $chk_first_string_after_invoice_prefix =='0' ) {

				$rr_no_prefix=ASSETS_REPAIRREQ_CODE_NO_PREFIX.CUR_FISCALYEAR;

			}

			else if ($cur_fiscalyrs_rrreqno->rerm_fiscalyrs!=$currentfyrs && $chk_first_string_after_invoice_prefix !='0' ) {

				$rr_no_prefix=ASSETS_REPAIRREQ_CODE_NO_PREFIX.CUR_FISCALYEAR;

			}

			else{

				$rr_no_prefix=ASSETS_REPAIRREQ_CODE_NO_PREFIX;

			}

			

		}

		else{

			$rr_no_prefix=ASSETS_REPAIRREQ_CODE_NO_PREFIX.CUR_FISCALYEAR;

		}

		// die();



		$this->data['request_no'] = $this->general->generate_invoiceno('rerm_requestno','rerm_requestno','rerm_repairrequestmaster',$rr_no_prefix,ASSETS_REPAIRREQ_CODE_NO_LENGTH,false,'rerm_locationid');





	 	$this->data['fiscal_year']=$this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','DESC',2);

	 	$this->data['department_list']=$this->general->get_tbl_data('*','dept_department',false);

	 	$this->data['location_list']=$this->general->get_tbl_data('*','loca_location',false);

	    $this->data['distributors']=$this->general->get_tbl_data('*','dist_distributors',array('dist_isactive'=>'Y'));

	    $this->data['breadcrumb']='Repair Request Entry';

		$this->data['tab_type']="entry";

		$id=$this->input->post('id');

		if($id)

		{

			$this->data['request_master'] = $this->repair_request_mdl->get_assets_repair_request_master_data(array('rm.rerm_repairrequestmasterid'=>$id));

			$this->data['request_detail'] = $this->repair_request_mdl->get_assets_repair_request_detail_data(array('rm.rerm_repairrequestmasterid'=>$id));

		}	



	    if($reload=='reload'){

	    $this->load->view('repair_request/v_assets_repair_request_form',$this->data);
 
	    }else{

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

				->build('repair_request/v_assets_repair_request_common', $this->data);

	    }

		



	}


	public function save_repair_request($print=false){

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		try {

			if($this->input->post('id'))

			{
				if(MODULES_UPDATE=='N')
				{
					$this->general->permission_denial_message();
					exit;
				}
				$action_log_message = "edit";
			}
			else
			{
				if(MODULES_INSERT=='N')
				{
					$this->general->permission_denial_message();
					exit;
				}
				$action_log_message = "";
			}

			$this->form_validation->set_rules($this->repair_request_mdl->validate_settings_repair_request);

			if($this->form_validation->run()==TRUE)

			{   

			// $trans = $this->repair_request_mdl->repair_request_save();
			$trans = $this->repair_request_mdl->repair_request_save_new();
			// echo "<pre>"; print_r($this->input->post());die;
			if($trans){		
				if($print == "print")
				{	
				$print_report='';
				$this->data['repair_detail'] =array();
				$this->data['repair_master']=$this->repair_request_mdl->get_assets_repair_request_master_data(array('rm.rerm_repairrequestmasterid'=>$trans));
				if($this->data['repair_master']>0)
				{
				$this->data['repair_detail'] = $this->repair_request_mdl->get_assets_repair_request_detail_data(array('rd.rerd_repairrequestmasterid'=>$trans));
				$print_report=$this->load->view('repair_request/v_repair_request_reprint',$this->data,true);
				}
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


	public function repair_request_edit()
	{
		$this->data['rerm_repairrequestmasterid']=$id=$this->input->post('id');
		$this->data['request_no'] = '';

		if($id)

		{

			$this->data['request_master'] = $this->repair_request_mdl->get_assets_repair_request_master_data(array('rm.rerm_repairrequestmasterid'=>$id));

			$this->data['request_detail'] = $this->repair_request_mdl->get_assets_repair_request_detail_data(array('rm.rerm_repairrequestmasterid'=>$id));

		}

		$this->data['fiscal_year']=$this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','DESC',2);

	 	$this->data['department_list']=$this->general->get_tbl_data('*','dept_department',false);

	 	$this->data['location_list']=$this->general->get_tbl_data('*','loca_location',false);

	    $this->data['distributors']=$this->general->get_tbl_data('*','dist_distributors',array('dist_isactive'=>'Y'));


	    $this->data['breadcrumb']='Repair Request Edit';
		$this->data['tab_type']='entry';
		$this->data['reload'] = false;

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

		->build('repair_request/v_assets_repair_request_common', $this->data);
	}


public function summary()

{



$frmDate = CURMONTH_DAY1;

$toDate = CURDATE_NP;

$cur_fiscalyear = CUR_FISCALYEAR;

$this->data['fiscalyear'] = $this->general->get_tbl_data('*','fiye_fiscalyear',false,'fiye_fiscalyear_id','DESC');

$this->data['department_list']=$this->general->get_tbl_data('*','dept_department',false);



// echo "|asd";

// die();



$this->data['breadcrumb']='Repair Request Summary';

$this->data['tab_type']="repair_request_summary";

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





	$this->session->unset_userdata('id');

	$this->page_title='Work Order Summary';

	$this->template

		->set_layout('general')

		->enable_parser(FALSE)

		->title($this->page_title)

		->build('repair_request/v_assets_repair_request_common', $this->data);



}



public function get_repair_request_summary_list(){

	if(MODULES_VIEW=='N'){

		$array=array();

		echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));			

		exit;

	}

	$useraccess= $this->session->userdata(USER_ACCESS_TYPE);

	$i = 0;



	

	$data = $this->repair_request_mdl->get_summary_list_of_repair_request();



	// echo "<pre>";

	// print_r($data);

	// die();

	$array = array();

	$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);

	$totalrecs = $data["totalrecs"];

	unset($data["totalfilteredrecs"]);

	unset($data["totalrecs"]);



	

	foreach($data as $row)

	{

		

		$approved=$row->rerm_approved;

		if($approved=='0'){

			$appstatus='Pending';

		}else if($approved=='1'){

			$appstatus='Approval';

		}

		else if($approved=='2'){

			$appstatus='Unapproval';

		}

		else if($approved=='3'){

			$appstatus='Cancel';

		}

		else if($approved=='4'){

			$appstatus='Verified';

		}

		else if($approved=='4'){

			$appstatus='Estimated';

		}





		if($approved=='0')

			{

				$appclass='pending';

				

			}

			if($approved=='1')

			{

				$appclass='approved';

			}

			if($approved=='2')

			{

				$appclass='unapproved';

			}

			

			if($approved=='3')

			{

				$appclass='cancel';

			}



			if($approved=='4')

			{

				$appclass='verified';

			}



			if($approved=='5'){

				$appclass='estimate';

			}

		$array[$i]["approvedclass"] = $appclass;



		$array[$i]['datead']=$row->rerm_requestdatead;

		$array[$i]['datebs']=$row->rerm_requestdatebs;

		$array[$i]['requestno']=$row->rerm_requestno;

		$array[$i]['noofassets']=$row->rerm_noofassets;

		$array[$i]['depname']=$row->dept_depname;

		$array[$i]['requestby']=$row->rerm_requestby;

		$array[$i]['manualno']=$row->rerm_manualno;

		$array[$i]['fiscalyrs']=$row->rerm_fiscalyrs;

		$array[$i]['repstatus']='UR:6 | R:1';

		$array[$i]['status']=$appstatus;

		

		$array[$i]['action']='<a href="javascript:void(0)" data-id='.$row->rerm_repairrequestmasterid.' class="btnredirect btn-xxs btn-info" title="Edit" data-viewurl="'.base_url("/ams/repair_request").'"><i class="fa fa-edit " aria-hidden="true"></i></a>
		<a href="javascript:void(0)" title="Verified/Approved" data-viewurl='.base_url('ams/repair_request/get_assets_repair_request_by_id/verify_approved').' data-heading="Verify and Approved Repair Request"  class="view" data-id='.$row->rerm_repairrequestmasterid.'><i class="fa fa-check" aria-hidden="true"></i></a><a href="javascript:void(0)" class="view" data-id='.$row->rerm_repairrequestmasterid.' title="View" data-viewurl="'.base_url("/ams/repair_request/get_assets_repair_request_by_id").'" title="View Assets Repair Request" data-heading="Assets Repair Request View"><i class="fa fa-eye"></i></a>';

		

		$i++;

	}

	$get = $_GET;

	echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));

}







public function get_assets_repair_request_by_id($operation=false){

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$id = $this->input->post('id');

			if($id)

			{ 

				$this->data['assets_repair_request_master']=$this->repair_request_mdl->get_assets_repair_request_master_data(array('rm.rerm_repairrequestmasterid'=>$id));

				// echo "<pre>";

				// print_r($this->data['assets_repair_request_master']);

				// die();

				$template='';

				if($this->data['assets_repair_request_master']>0)

				{

					$this->data['assets_repair_request_detail'] = $this->repair_request_mdl->get_assets_repair_request_detail_data(array('rd.rerd_repairrequestmasterid'=>$id));



					// echo "<pre>";

					// print_r($this->data['assets_repair_request_detail']);

					// die();

				

				$template=$this->load->view('repair_request/v_repair_request_detail_view',$this->data,true);

				if($operation=='verify_approved')

				{

					$template .=$this->load->view('repair_request/v_repair_request_verify_approved_form',$this->data,true);

				}

				print_r(json_encode(array('status'=>'success','message'=>'','tempform'=>$template)));

					exit;

				}

				else{

					print_r(json_encode(array('status'=>'error','message'=>'')));

					exit;

				}

				print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','tempform'=>$template)));

				exit;	

			}

		}

		else{

			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

			exit;

		}

}



public function change_status()

{

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {



		// echo "test";

		// die();

		// if(MODULES_APPROVE=='N')

		// {

		// 	print_r(json_encode(array('status'=>'error','message'=>$this->general->permission_denial_message())));

		// 	exit;

		// }



		$masterid = $this->input->post('masterid');

		$approve_post_status = $this->input->post('approve_status');

		$cancelreason=$this->input->post('cancel_reason');

		$unapprovedreason=$this->input->post('unapprovedreason');



		if($approve_post_status=='')

		{

			print_r(json_encode(array('status'=>'error','message'=>'You Need to Select Atleast One Option !!! ')));

			exit;

		}

		

		$status='';

		if($approve_post_status == "2")

		{

			$status = "2";

			$post_data['rerm_cancelreason']=$unapprovedreason;

		}

		if($approve_post_status == "1")

		{

			$status = "1";

		}

		if($approve_post_status == "3")

		{

			$status = "3";

			$post_data['rerm_cancelreason']=$cancelreason;

		}

		if($approve_post_status == "4")

		{

			$status = "4";



		}



		$post_data['rerm_approved']=$status;

			//print_r($status);die;

		// ;



		if($this->db->update('rerm_repairrequestmaster',$post_data,array('rerm_repairrequestmasterid'=>$masterid)))

		{

			$action_log_userid=$this->userid;

			$this->general->saveActionLog('rerm_repairrequestmaster', $masterid, $action_log_userid, $status, 'rerm_approved'); 



			print_r(json_encode(array('status'=>'success','message'=>'Record Save Successfully')));

			exit;

		}

		else

		{

			print_r(json_encode(array('status'=>'error','message'=>'Error While Savind Data')));

			exit;

		}

	}else

	{

		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

		exit;

	}

}



public function detail()

	{

		$this->data['department_list']=$this->general->get_tbl_data('*','dept_department',array('dept_isactive'=>'Y'));

		$this->data['breadcrumb']='Repair Request Detail';

		$this->data['tab_type']="repair_request_detail";


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

		$this->page_title='Repair Request Detail';

		$this->template

			->set_layout('general')

			->enable_parser(FALSE)

			->title($this->page_title)

			->build('repair_request/v_assets_repair_request_common', $this->data);



	}



	public function get_repair_request_detail_list(){

	if(MODULES_VIEW=='N'){

		$array=array();

		echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));			

		exit;

	}

	$useraccess= $this->session->userdata(USER_ACCESS_TYPE);

	$i = 0;



	

	$data = $this->repair_request_mdl->get_detail_list_of_repair_request();



	// echo "<pre>";

	// print_r($data);

	// die();

	$array = array();

	$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);

	$totalrecs = $data["totalrecs"];

	unset($data["totalfilteredrecs"]);

	unset($data["totalrecs"]);



	

	foreach($data as $row)

	{



		$array[$i]['datead']=$row->rerm_requestdatead;

		$array[$i]['datebs']=$row->rerm_requestdatebs;

		$array[$i]['requestno']=$row->rerm_requestno;

		$array[$i]['depname']=$row->dept_depname;

		$array[$i]['fiscalyrs']=$row->rerm_fiscalyrs;

		$array[$i]['assets_code']=$row->asen_assetcode;

		$array[$i]['description']=$row->rerd_assetsdesc;

		$array[$i]['problem']=$row->rerd_problem;

		

		

		

		$i++;

	}

	$get = $_GET;

	echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));



}



public function list_asset_repair_request_detail(){

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		$this->data['list_asset_repair_request_detail']=$this->repair_request_mdl->get_all_asset_repair_request_detail();

		$template=$this->load->view('repair_request/v_assets_repair_request_detail_list',$this->data,true);

		print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));

			exit;	

	   }

	else

	{

		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

		exit;

	}

}

public function generate_pdfDirect()

    {

        $this->data['searchResult'] = $this->repair_request_mdl->get_detail_list_of_repair_request();



        // echo "<pre>";

        // print_r( $this->data['searchResult']);

        // die();

        unset($this->data['searchResult']['totalfilteredrecs']);

        unset($this->data['searchResult']['totalrecs']);



        $html = $this->load->view('repair_request/v_asset_repair_request_detail_download', $this->data, true);

      	$filename = 'direct_purchase_'. date('Y_m_d_H_i_s') . '_.pdf'; 

        $pdfsize = 'A4-L'; //A4-L for landscape

        //if save and download with default filename, send $filename as parameter

        $this->general->generate_pdf($html,false,$pdfsize);

        exit();

    }

public function exportToExcelDirect()

    {

        header("Content-Type: application/xls");    

        header("Content-Disposition: attachment; filename=assets_repair_request".date('Y_m_d_H_i').".xls");  

        header("Pragma: no-cache"); 

        header("Expires: 0");



        $data = $this->repair_request_mdl->get_detail_list_of_repair_request();



        $this->data['searchResult'] = $this->repair_request_mdl->get_detail_list_of_repair_request();

        

        $array = array();

        unset($this->data['searchResult']['totalfilteredrecs']);

        unset($this->data['searchResult']['totalrecs']);

        $response = $this->load->view('repair_request/v_asset_repair_request_detail_download', $this->data, true);



        echo $response;

    }



   public function reprint_repair_request()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		$id = $this->input->post('id');

		$this->data=array();

		if($id)

		{ 

			$this->data['repair_detail'] =array();

			$this->data['repair_master']=$this->repair_request_mdl->get_assets_repair_request_master_data(array('rm.rerm_repairrequestmasterid'=>$id));
			// echo "<pre>";
			// print_r($this->data['repair_master']);
			// die();

				$template='';

				if($this->data['repair_master']>0)

				{
					$req_date=!empty($this->data['repair_master'][0]->rerm_requestdatebs)?$this->data['repair_master'][0]->rerm_requestdatebs:'';

					if(!empty($req_date))
					{
						$date_arr=explode('/', $req_date);
						if(!empty($date_arr)){
						$month_result=$this->db->select('mona_namenp')->get_where('mona_monthname',array('mona_monthid'=>$date_arr[1]))->row();	
						// echo "<pre>";
						// print_r($month_name);
						// die();
						$this->data['month_name']=$month_result->mona_namenp;
						}
						
					}

					$this->data['repair_detail'] = $this->repair_request_mdl->get_assets_repair_request_detail_data(array('rd.rerd_repairrequestmasterid'=>$id));

					// if ($this->data['repair_master'][0]->rerm_approved == 1) {
					// 	foreach ($this->data['repair_detail'] as $key => $detail) {
					// 		$this->data['previous_repair'][] = $this->repair_request_mdl->get_last_repair_details();
					// 	}
					// }

					$template=$this->load->view('repair_request/v_repair_request_reprint',$this->data,true);

					if($template)

					{

						print_r(json_encode(array('status'=>'success','message'=>'','tempform'=>$template)));

						exit;

					}

					else{

						print_r(json_encode(array('status'=>'error','message'=>'')));

						exit;

					}

				print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','tempform'=>$template)));

				exit;	

		}

	}

}

	else

	{

		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

		exit;

	}  

}



}