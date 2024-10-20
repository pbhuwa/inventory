<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller

{

	function __construct()

	{

		parent::__construct();

		$this->load->Model('users_mdl');

		$this->load->Model('department_mdl');

		$this->load->Model('group_mdl');

		 //$this->load->Model('designation_mdl');

		$this->load->model('login/mdl_login');

		$this->load->Model('location_mdl');

		$this->useraccess= $this->session->userdata(USER_ACCESS_TYPE);

		$this->orgid= $this->session->userdata(ORG_ID);

		$this->locationid = $this->session->userdata(LOCATION_ID);

		$this->location_ismain = $this->session->userdata(ISMAIN_LOCATION);

	}

	public function index()

	{

		$this->data['department_all']=$this->department_mdl->get_all_department();

		// $this->data['doctor_list']=$this->doctor_mdl->get_all_doctor();

		//$this->data['location_all'] = $this->general->get_tbl_data('*','loca_location',false,'loca_locationid','DESC');

		$this->data['dashboard_all'] = $this->general->get_tbl_data('*','dash_dashboard',array('dash_orgid'=>$this->orgid),'dash_id','ASC');

		$this->data['designation'] = $this->general->get_tbl_data('*','desi_designation');

		$this->data['material_type']=$this->general->get_tbl_data('*','maty_materialtype',array('maty_isactive'=>'Y'),'maty_materialtypeid','ASC');

		if($this->location_ismain == 'Y')

		{

			$this->data['users_all']=$this->users_mdl->get_all_users(array('um.usma_orgid'=>$this->orgid));

			$this->data['location_all'] = $this->general->get_tbl_data('*','loca_location',array('loca_isactive'=>'Y'),'loca_locationid','DESC');

			$this->data['group_all']=$this->group_mdl->get_all_group();

		}else{

			$this->data['users_all']=$this->users_mdl->get_all_users(array('um.usma_locationid'=>$this->locationid,'um.usma_orgid'=>$this->orgid));

			$this->data['location_all'] =$this->general->get_tbl_data('*','loca_location',array('loca_locationid'=>$this->locationid),'loca_locationid','ASC');

			 // $this->data['group_all']=$this->group_mdl->get_all_group(array(

			 // 	'usgr_locationid'=>$this->locationid));

			$this->data['group_all']=$this->group_mdl->group_union();

		}

		// echo "<pre>";
		// print_r($this->data['group_all']);
		// die();

		$this->data['editurl']=base_url().'settings/users/editusers';

		$this->data['deleteurl']=base_url().'settings/users/deleteusers';

		$this->data['listurl']=base_url().'settings/users/listusers';

		$this->data['location_ismain']=$this->location_ismain;

		$this->data['current_location']=$this->locationid;

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

		->build('users/v_users', $this->data);

	}

	public function form_users()

	{

		$this->data['department_all']=$this->department_mdl->get_all_department();

		$this->data['designation'] = $this->general->get_tbl_data('*','desi_designation');

		$this->data['material_type']=$this->general->get_tbl_data('*','maty_materialtype',array('maty_isactive'=>'Y'),'maty_materialtypeid','ASC');

		if($this->location_ismain == 'Y')

		{

			$this->data['users_all']=$this->users_mdl->get_all_users(array('um.usma_orgid'=>$this->orgid));

			$this->data['location_all'] = $this->general->get_tbl_data('*','loca_location',false,'loca_locationid','DESC');

			$this->data['group_all']=$this->group_mdl->get_all_group();

		}else{

			$this->data['users_all']=$this->users_mdl->get_all_users(array('um.usma_locationid'=>$this->locationid,'um.usma_orgid'=>$this->orgid));

			$this->data['location_all'] =$this->general->get_tbl_data('*','loca_location',array('loca_locationid'=>$this->locationid),'loca_locationid','ASC');

			$this->data['group_all']=$this->group_mdl->get_all_group(array(

				'usgr_locationid'=>$this->locationid));

		}

		$this->data['dashboard_all'] = $this->general->get_tbl_data('*','dash_dashboard',array('dash_orgid'=>$this->orgid),'dash_id','ASC');

	if(ORGANIZATION_NAME=='KU' || ORGANIZATION_NAME=='ARMY'){

		$this->load->view('users/ku/v_usersform',$this->data);

		}else{

		$this->load->view('users/v_usersform',$this->data);	

		}

	}

	public function listusers()

	{

		if(MODULES_VIEW=='N')

			//echo MODULES_VIEW;die;

		{

			$array["usma_userid"]='';

			$array["usma_username"]='';

			 //$array["usma_userid"]='';

			$array["usgr_usergroup"]='';

			$array["usma_postdatebs"]='';

			$array["action"]='';

			 // $this->general->permission_denial_message();

			echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));			

			exit;

		}

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			if($this->location_ismain == 'Y')

			{

				$this->data['users_all']=$this->users_mdl->get_all_users(array('um.usma_orgid'=>$this->orgid));

			}else{

				$this->data['users_all']=$this->users_mdl->get_all_users(array('um.usma_locationid'=>$this->locationid,'um.usma_orgid'=>$this->orgid));

			//echo"<pre>";print_r($this->data['users_all']);die;

			}

			$template=$this->load->view('users/v_user_list',$this->data,true);

			print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));

			exit;	

		}

		else

		{

			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

			exit;

		}

	}

	public function save_users(){

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$id = $this->input->post('id');

			try {

			// $this->form_validation->set_rules($this->users_mdl->validate_settings_users);

				$this->session->unset_userdata('upload_error');

				$this->signatureupload = '';

				if($id)

				{

					$this->data['user_data']=$this->users_mdl->get_all_users(array('um.usma_userid'=>$id));

					// echo "<pre>";

					// print_r($data['user_data']);

					// die();

					if($this->data['user_data'])

					{

						$dep_date=$this->data['user_data'][0]->usma_postdatead;

						$dep_time=$this->data['user_data'][0]->usma_posttime;

						$editstatus=$this->general->compute_data_for_edit($dep_date,$dep_time);

						$usergroup=$this->session->userdata(USER_GROUPCODE);

						if($editstatus==0 && $usergroup!='SA' )

						{

							$this->general->disabled_edit_message();

						}

					}

				}

				if($id)

				{

					$this->form_validation->set_rules($this->users_mdl->validate_settings_users_edit);

				}

				else

				{

					$this->form_validation->set_rules($this->users_mdl->validate_settings_users);

				}

				if($this->form_validation->run()==TRUE)

				{

					$upload_result_error=FALSE;

					if(!empty($_FILES['usma_signaturepath']['name']))

					{

						$upload_result_error=$this->users_mdl->upload_signature();

						// echo $upload_result_error;

						// die();

						if($upload_result_error==TRUE)

						{

							print_r(json_encode(array('status'=>'error','message'=>$this->session->userdata('upload_error'))));

							exit;

						}

					}

					$trans = $this->users_mdl->users_save();

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

	public function editusers()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			if(MODULES_UPDATE=='N')

			{

				$this->general->permission_denial_message();

				exit;

			}

			$id=$this->input->post('id');

			$this->data['user_data']=$this->users_mdl->get_all_users(array('um.usma_userid'=>$id));

			$this->data['department_all']=$this->department_mdl->get_all_department();

			$this->data['group_all']=$this->group_mdl->get_all_group();

			$this->data['designation'] = $this->general->get_tbl_data('*','desi_designation');

			if($this->location_ismain == 'Y')

			{

				$this->data['location_all'] = $this->general->get_tbl_data('*','loca_location',false,'loca_locationid','DESC');

			}else{

				$this->data['location_all'] =$this->general->get_tbl_data('*','loca_location',array('loca_locationid'=>$this->locationid),'loca_locationid','ASC');

			}

			$this->data['dashboard_all'] = $this->general->get_tbl_data('*','dash_dashboard',array('dash_orgid'=>$this->orgid),'dash_id','ASC');

			if($this->data['user_data'])

			{

				$dep_date=$this->data['user_data'][0]->usma_postdatead;

				$dep_time=$this->data['user_data'][0]->usma_posttime;

				$editstatus=$this->general->compute_data_for_edit($dep_date,$dep_time);

			// echo $editstatus;

			// die();

				$this->data['edit_status']=$editstatus;

			}

			$this->data['material_type']=$this->general->get_tbl_data('*','maty_materialtype',array('maty_isactive'=>'Y'),'maty_materialtypeid','ASC');

		// echo "<pre>";

		// print_r($data['user_data']);

		// die();

			if(ORGANIZATION_NAME=='KU' || ORGANIZATION_NAME=='ARMY'){

			$tempform= $this->load->view('users/ku/v_usersform',$this->data,true);

		}else{

			$tempform=$this->load->view('users/v_usersform',$this->data,true);

		}

		// echo $tempform;

		// die();

			if(!empty($this->data['user_data']))

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

	public function deleteusers()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			if(MODULES_DELETE=='N')

			{

				$this->general->permission_denial_message();

				exit;

			}

			$id=$this->input->post('id');

			$trans=$this->users_mdl->remove_users();

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

		$username=$this->users_mdl->check_exit_username_for_other($usma_username,$input_id);

		if($username)

		{

			$this->form_validation->set_message('exists_username', 'Alreay Exit Username.');

			return false;

		}

		else

		{

			return true;

		}

	}

	public function change_password()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			if($this->input->post('password'))

			{

				$tran=$this->users_mdl->change_user_password();

				if($tran)

				{

					print_r(json_encode(array('status'=>'success','message'=>'Successfully!!')));

					exit;

				}

				else

				{

					print_r(json_encode(array('status'=>'error','message'=>'UnSuccessfully!!')));

					exit;

				}

			}

			else

			{

				print_r(json_encode(array('status'=>'error','field'=>'password','message'=>'Password Field is required')));

				exit;

			}

		}

		else

		{

			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

			exit;

		}

	}

	public function change_password_user()

	{

		$this->page_title = "Change Password";

		$this->data['meta_keys']= "Change Password";

		$this->data['meta_desc']= "Change Password";

		$this->data['title']='Change Password';

		$this->template

		->set_layout('general')

		->enable_parser(FALSE)

		->title($this->page_title)

		->build('login/v_change_pwd', $this->data);	

	}

	public function check_oldpassword()

	{

		$option = array('usma_userid'=>$this->session->userdata(USER_ID));

		$query = $this->db->get_where('usma_usermain',$option);

		// echo $this->db->last_query(); die();

		$record = $query->row();

		$input_password= $this->input->post('password',TRUE);

		$salt = $record->usma_salt;		

		$oldpassword = $this->general->hash_password($input_password,$salt);

		//echo"<pre>";print_r($oldpassword);echo"<br>";print_r($record->usma_userpassword);die;

		if(isset($record->usma_userpassword) && ($record->usma_userpassword==$oldpassword))

		{

			return TRUE;	

		}

		else

		{

		// $this->form_validation->set_message('check_oldpassword', 'Old Password is not match');

			return FALSE;			

		}

	}

	public function save_change_pasword()

	{

		$user_id = $this->session->userdata(USER_ID);

		//echo $user_id; die;

		if(!$this->input->is_ajax_request())

		{

			exit('No direct script access allowed');

		}

		if($this->input->server('REQUEST_METHOD')=='POST')

		{

			$checkoldpass=$this->check_oldpassword();

			if($checkoldpass==FALSE)

			{

				$return_data = array(

					'status'=>'error',

					'message'=>'Old Password is not match',

				);

				print_r(json_encode($return_data)); 

				exit;

			}

			$this->form_validation->set_rules($this->mdl_login->validate_settings_changePass);

			if($this->form_validation->run()==TRUE)

			{ //echo"<pre>";print_r($this->input->post());die;

				//now change users password

		$change = $this->mdl_login->change_users_password($user_id);

				//print_r($change); exit;

		if($change){

					//now clear session and redirect to home page after chaging password

			$this->session->unset_userdata(USER_ID);

					// $this->session->unset_userdata(SESSION.'usertype');

					// $this->session->unset_userdata(SESSION.'email');

			$return_data = array(

				'status'=>'success',

				'message'=>'Password Changed Successfully!!',

			);

		}else{

			$return_data = array(

				'status'=>'error',

				'message'=>'Unsuccessful Changed Password',

			);

		}

	}else{

				//validation error messages

		$return_data = array(

			'status'=>'error',

			'message'=>validation_errors(),

		);

	}

}else{

			//invalid operation, no post data found

	$return_data = array(

		'status'=>'error',

		'message'=>'Illegal Operation'

	);

}

print_r(json_encode($return_data)); exit;

}

public function user_profile(){

	$id = $this->session->userdata(USER_ID);

		// echo $id;

		// die();

	$this->data['usersall']=$this->users_mdl->get_all_users_profile(array('um.usma_userid'=>$id));

		// echo $this->db->last_query(); die();

         // echo "<pre>"; print_r($this->data['usersall']);die;

	$this->page_title = "User Profile";

	$this->data['meta_keys']= "User Profile";

	$this->data['meta_desc']= "User Profile";

	$this->data['title']='User Profile';

	$this->template

	->set_layout('general')

	->enable_parser(FALSE)

	->title($this->page_title)

	->build('login/v_user_profile', $this->data);

}

public function get_user_list(){

	$data = $this->users_mdl->get_all_user_list();

		    // echo "<pre>"; print_r($data); die();

	$i = 0;

	$array = array();

	$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);

	$totalrecs = $data["totalrecs"];

	unset($data["totalfilteredrecs"]);

	unset($data["totalrecs"]);

	foreach($data as $row)

	{

		$deparray=explode(',', $row->usma_departmentid);

		$department=$this->users_mdl->get_userwise_dep($row->usma_userid,$deparray);

		if($department==false){

			$department="-------";

		}

		$array[$i]["sno"] = $i+1;

		$array[$i]["usma_username"] = $row->usma_username;

		$array[$i]["usma_fullname"] = $row->usma_fullname;

		$array[$i]["usma_departmentid"] = $department;

		$array[$i]["usma_usergroupid"] = $row->usgr_usergroup;

		$array[$i]["usma_postdatebs"] = $row->usma_postdatebs;

		$array[$i]["usma_postdatead"] = $row->usma_postdatead;

		if(MODULES_DELETE=='Y')

		{

			$deletebtn = '<a href="javascript:void(0)" data-id='.$row->usma_userid.' data-tableid='.($i+1).' data-deleteurl='. base_url('settings/users/deleteusers') .' class="btnDeleteServer"><i class="fa fa-trash-o" aria-hidden="true" ></i></a>';

		}

		else

		{

			$deletebtn='';

		}

		if(MODULES_UPDATE=='Y')

		{

			$editbtn= '<a href="javascript:void(0)" data-id='.$row->usma_userid.' data-displaydiv="users" data-viewurl='.base_url('settings/users/editusers').' class="btnEdit"><i class="fa fa-edit" aria-hidden="true" ></i></a>';

		}else{

			$editbtn='';

		}

		if(MODULES_VIEW=='Y')

		{

			$viewbtn = '<a href="javascript:void(0)" data-id='.$row->usma_userid.' data-displaydiv="UserDetails" data-viewurl='.base_url('settings/users/user_view_details/').' class="view  btn-xxs" data-heading="View User Details" ><i class="fa fa-eye" aria-hidden="true" ></i></a>';

		}

		else

		{

			$viewbtn='';

		}

		$array[$i]["action"] = $editbtn.'|'.$viewbtn.'|'.$deletebtn;

		$i++;

	}

	echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));

}

public function exportToExcelReqlist(){

	header("Content-Type: application/xls");    

	header("Content-Disposition: attachment; filename=User_list".date('Y_m_d_H_i').".xls");  

	header("Pragma: no-cache"); 

	header("Expires: 0");

	$locationid = $this->input->post('locationid');

	if($this->location_ismain=='Y'){

		if($locationid){

			$this->data['location']=$this->general->get_tbl_data('loca_name','loca_location',array('loca_locationid'=>$locationid));

		}else{

			$this->data['location'] = 'All';

		}

	}else{

		$this->data['location']=$this->general->get_tbl_data('loca_name','loca_location',array('loca_locationid'=>$this->locationid));

	}

	$this->data['location']=$this->general->get_tbl_data('DISTINCT(loca_name),loca_locationid','loca_location',array('loca_locationid'=>$this->locationid));

	$data = $this->users_mdl->get_all_user_list();

	$this->data['searchResult'] = $this->users_mdl->get_all_user_list();

	$array = array();

	unset($this->data['searchResult']['totalfilteredrecs']);

	unset($this->data['searchResult']['totalrecs']);

	$response = $this->load->view('users/v_user_list_download', $this->data, true);

	echo $response;

}

public function generate_pdfReqlist()

{

	$locationid = $this->input->post('locationid');

	if($this->location_ismain=='Y'){

		if($locationid){

			$this->data['location']=$this->general->get_tbl_data('loca_name','loca_location',array('loca_locationid'=>$locationid));

		}else{

			$this->data['location'] = 'All';

		}

	}else{

		$this->data['location']=$this->general->get_tbl_data('loca_name','loca_location',array('loca_locationid'=>$this->locationid));

	}

	$this->data['searchResult'] = $this->users_mdl->get_all_user_list();

	unset($this->data['searchResult']['totalfilteredrecs']);

	unset($this->data['searchResult']['totalrecs']);

	// $this->load->library('pdf');

	// $mpdf = $this->pdf->load();

        //echo"<pre>";print_r($this->data['searchResult']);die;

	ini_set('memory_limit', '256M');

	$html = $this->load->view('users/v_user_list_download', $this->data, true);
	$filename = 'user_list_' . date('Y_m_d_H_i_s') . '_.pdf';
	$pdfsize = 'A4-L'; //A4-L for landscape
	//if save and download with default filename, send $filename as parameter
	$this->general->generate_pdf($html, false, $pdfsize);
	exit();

	// // $mpdf = new mPDF('c', 'A4-L');
	// $mpdf = new mPDF('utf-8', 'A4-L'); 

	// if(PDF_IMAGEATEXT == '3')

	// {

	// 	$mpdf->SetWatermarkImage(PDF_WATERMARK);

	// 	$mpdf->showWatermarkImage = true;

	// 	$mpdf->showWatermarkText = true;  

	// 	$mpdf->SetWatermarkText(ORGA_NAME);

	// }

	// if(PDF_IMAGEATEXT == '1')

	// {

	// 	$mpdf->SetWatermarkImage(PDF_WATERMARK);

	// 	$mpdf->showWatermarkImage = true;

	// } 

	// if(PDF_IMAGEATEXT == '2')

	// {

	// 	$mpdf->showWatermarkText = true;  

	// 	$mpdf->SetWatermarkText(ORGA_NAME);

	// }

	// // $mpdf = new mPDF('utf-8', 'A4-L');

	// $mpdf->SetAutoFont(AUTOFONT_ALL);

	// $mpdf->WriteHTML($stylesheet, 1);

	// $mpdf->WriteHTML($html);

	// $output = 'User_list'.date('Y_m_d_H_i').'.pdf';

	// $mpdf->Output();

	// exit();

}

public function user_view_details(){

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		$id=$this->input->post('id');

		$this->data['user_data']=$this->users_mdl->get_all_users(array('um.usma_userid'=>$id));

		$deparray=explode(',', $this->data['user_data'][0]->usma_departmentid);

		$this->data['departmentname']=$this->users_mdl->get_userwise_dep($this->data['user_data'][0]->usma_userid,$deparray);

		$tempform=$this->load->view('users/v_user_view_details',$this->data,true);

		// echo $tempform;

		// die();

		if(!empty($this->data['user_data']))

		{

			print_r(json_encode(array('status'=>'success','message'=>'You Can view','tempform'=>$tempform)));

			exit;

		}

		else{

			print_r(json_encode(array('status'=>'error','message'=>'Unable to view!!')));

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

/* End of file welcome.php */

/* Location: ./application/controllers/welcome.php */