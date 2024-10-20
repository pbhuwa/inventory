<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Staff_manager extends CI_Controller

{

	function __construct()

	{

		parent::__construct();

		$this->load->Model('staff_manager_mdl');

		$this->load->Model('settings/room_mdl');

		$this->load->Model('settings/department_mdl','department_mdl');

	}

	public function index()

	{

		$this->data['staff_manager_all']=$this->staff_manager_mdl->get_all_staff_manager();

		$this->data['staff_position']=$this->staff_manager_mdl->get_all_position();

		$this->data['dep_information']=$this->department_mdl->get_all_department();

		$this->data['room_all']=$this->room_mdl->get_all_room();

		$this->data['editurl']=base_url().'biomedical/staff_manager/editstaff_manager';

		$this->data['deleteurl']=base_url().'biomedical/staff_manager/deletestaff_manager';

		$this->data['listurl']=base_url().'biomedical/staff_manager/liststaff_manager';

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

			->build('staff_manager/v_staff_manager', $this->data);

	}

	public function form_staff_manager()

	{  $this->data['staff_manager_all']=$this->staff_manager_mdl->get_all_staff_manager();

	    // $this->data['dep_information']=$this->department_mdl->get_all_department(array('dept_deptype'=>BIOMEDICALID));

	    // $this->data['staff_position']=$this->staff_manager_mdl->get_all_position();

		$this->load->view('staff_manager/v_staff_manager_form',$this->data);

	}

	public function liststaff_manager()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			if(MODULES_VIEW=='N')

				{

				$this->general->permission_denial_message();

				exit;

				}

			$data=array();

			$template=$this->load->view('staff_manager/v_staff_manager_list',$data,true);

			print_r(json_encode(array('status'=>'success','message'=>'Successfully Selected!!','template'=>$template)));

	   		 exit;	

		}

		else

		{

			print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

	        exit;

		}

	}

	public function save_staff_manager()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		try {

			$id=$this->input->post('id');

			// if($id)

			// {

			// $this->form_validation->set_rules($this->staff_manager_mdl->validate_settings_menu_edit);

			// }

			// else

			// {

			$this->form_validation->set_rules($this->staff_manager_mdl->validate_settings_staff_manager);

			// }

			  if($this->form_validation->run()==TRUE)

			 {

            $trans = $this->staff_manager_mdl->staff_manager_save();

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

public function editstaff_manager()

{

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    			if(MODULES_UPDATE=='N')

				{

				$this->general->permission_denial_message();

				exit;

				}

		$id=$this->input->post('id');

		// $this->data['dep_information']=$this->department_mdl->get_all_department(array('dept_deptype'=>BIOMEDICALID));
		$this->data['dep_information']=$this->department_mdl->get_all_department();

		$this->data['staff_manager_all']=$this->staff_manager_mdl->get_all_staff_manager();

		$this->data['staff_position']=$this->staff_manager_mdl->get_all_position();

		$this->data['staff_manager_data']=$this->staff_manager_mdl->get_all_staff_manager(array('stin_staffinfoid'=>$id));

		// echo "<pre>";

		// print_r($this->data['staff_manager_all']);

		// die();

		$tempform=$this->load->view('staff_manager/v_staff_manager_form',$this->data,true);

		// echo $tempform;

		// die();

		if(!empty($this->data['staff_manager_data']))

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

public function deletestaff_manager()

{

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		if(MODULES_DELETE=='N')

				{

				$this->general->permission_denial_message();

				exit;

				}

		$id=$this->input->post('id');

		$trans=$this->staff_manager_mdl->remove_staff_manager();

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

}

public function exists_stin_code()

	{

		$stin_code=$this->input->post('stin_code');

		$id=$this->input->post('id');

		$stin_codechk=$this->staff_manager_mdl->check_exit_staff_info_desc_for_other($stin_code,$id);

		if($stin_codechk)

		{

			$this->form_validation->set_message('exists_stin_code', 'Already Exist modulekey!');

			return false;

		}

		else

		{

			return true;

		}

	}

	 public function get_room_from_depid()

    {

    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$id=$this->input->post('depid');

			if(!empty($id))

		 	{

		 	$this->data['room_list']=$this->room_mdl->get_all_room(array('rode_departmentid'=>$id));

		 	// echo $this->db->last_query();

		 	// die();

		 	// echo "<pre>";

		 	// print_r($this->data['room_list']);die;

		 	if(!empty($this->data['room_list']))

		 		{

		 		echo json_encode($this->data['room_list']);

		 		}

		 	else

		 		{

		 			echo json_encode(array());

		 		}

		 	}

		 	else

		 	{

		 		echo json_encode('');

		 	}

		}

		else

		{

		print_r(json_encode(array('status'=>'error','message'=>'Cannot Perform this Operation')));

	        exit;

		}

    }

      public function staff_list($result=false,$orgid=false)

	{  

		//echo "USER_ACCESS_TYPE";die;

			if(MODULES_VIEW=='N')

			{

			$array["stin_staffinfoid"]='';

			$array["code"]='';

			$array["name"]='';

			$array["address1"]='';

			$array["mobile"]='';

			$array["department"]='';

			$array["room"]='';

			$array["action"]='';

			 // $this->general->permission_denial_message();

			 echo json_encode(array("recordsFiltered"=>0,"recordsTotal"=>0 ,"data"=>$array));			

			exit;

			}

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		}

		// $useraccess= $this->session->userdata(USER_ACCESS_TYPE);

		//print_r($useraccess);die();

		// if($orgid){

		// 	$org_id=$orgid;

		// }

		// else

		// {

		// 	$org_id = $this->session->userdata(ORG_ID); 

		// }

		// if($useraccess == 'S')

		// {

			// if($orgid)

			// {

			// 	$srchcol=array('stin_orgid'=>$org_id);

			// }

			// else

			// {

			// 	$srchcol='';

			// }

			$data = $this->staff_manager_mdl->get_staff_list();

			// echo $this->db->last_query();

		// }

		//$data = $this->staff_manager_mdl->get_staff_list();

			// else{

			// 	//$data = $this->staff_manager_mdl->get_staff_list();

			// }

	        // echo $this->db->last_query();ie();

			// if($result == 'stin_staffinfoid') {

			// 	$cond = array('stin_postdatead'=>date("Y/m/d"),'stin_orgid'=>$org_id);

			// 	$data = $this->staff_manager_mdl->get_staff_list($cond);

			// }

		//echo "<pre>"; print_r($data["totalfilteredrecs"]); die();

	  	$i = 0;

		$array = array();

		$filtereddata = ($data["totalfilteredrecs"]>0?$data["totalfilteredrecs"]:$data["totalrecs"]);

		//print_r($filtereddata);die;

		$totalrecs = $data["totalrecs"];

	    unset($data["totalfilteredrecs"]);

	  	unset($data["totalrecs"]);

		  	foreach($data as $row)

		    {

			    $array[$i]["stin_staffinfoid"] = '<a href="javascript:void(0)" class="patlist" data-patientid='.$row->stin_staffinfoid.'>'.$row->stin_staffinfoid.'</a>';

			    $array[$i]["code"] = $row->stin_code;

			    $name = $row->stin_fname.' '.$row->stin_mname.' '.$row->stin_lname;

			    $array[$i]["name"] = $name;

			    $array[$i]["address1"] = $row->stin_address1;

			    $array[$i]["mobile"] = $row->stin_mobile;

			    $array[$i]["department"] = $row->dept_depname;

			    $array[$i]["room"] = $row->rode_roomname;

			    $array[$i]["action"] ='<a href="javascript:void(0)" data-id='.$row->stin_staffinfoid.'

			     data-displaydiv="staff" data-viewurl='.base_url('biomedical/staff_manager/view_staff').' 

			     class="view" data-heading="View Staff"  ><i class="fa fa-eye" aria-hidden="true" ></i></a>|

			     &nbsp;<a href="javascript:void(0)" 

			     data-id='.$row->stin_staffinfoid.' data-displaydiv="staff"

			      data-viewurl='.base_url('biomedical/staff_manager/editstaff_manager').' class="btnEdit" ><i 

			      class="fa fa-edit" aria-hidden="true" ></i></a>|

			        <a href="javascript:void(0)" data-id='.$row->stin_staffinfoid.' data-tableid='.($i+1).' 

			        data-deleteurl='. base_url('biomedical/staff_manager/deletestaff_manager') .' 

			        class="btnDeleteServer"><i class="fa fa-trash-o" aria-hidden="true" ></i></a>

			    ';

			    $i++;

		        //(object)array('',$row->studentregno,$row->firstname,$row->classsemyear,$row->section,$row->rollno,$row->gender,'');

		    }

        echo json_encode(array("recordsFiltered"=>$filtereddata,"recordsTotal"=>$totalrecs ,"data"=>$array));

	}

	public function view_staff()

	{

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		$this->data=array();

		$id = $this->input->post('id');

		$this->data['staff_manager_data']=$this->staff_manager_mdl->get_all_staff_manager(array('stin_staffinfoid'=>$id));

		//echo "<pre>";print_r($this->data['staff_manager_data']);die;

		$tempform=$this->load->view('staff_manager/v_staff_manager_view',$this->data,true);

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

}

/* End of file welcome.php */

/* Location: ./application/controllers/welcome.php */