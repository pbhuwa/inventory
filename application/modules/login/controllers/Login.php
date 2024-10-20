<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct() {

        parent::__construct();

        // echo ISUSERACCESS;

        // die();

        $this->template->set_layout('login');

        $this->load->library('form_validation');

			// $this->load->library('encrypt');

		//load custom module

			$this->load->model('mdl_login');

			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');

			$this->load->Model('settings/users_mdl');

    }

    public function index() 

    {

    	if($this->session->userdata(USER_ID))

      	{

      		redirect('home','refresh');

      	}

    	// echo "test";

    	// exit;

  		//       if ($this->general->admin_logged_in())

		// 	{

		// 		redirect(ADMIN_DASHBOARD_PATH, 'refresh');

		// exit;}

		//$store_type = $this->input->post('eqty_equipmenttypeid');

		//print_r($store_type);die;

		$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');

		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');

		$this->data['org_list']=$this->general->get_tbl_data('*','orga_organization',array('orga_isactive'=>'Y'),'orga_order','ASC');

		$this->data['store']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','ASC');

		$this->data['location_all'] =$this->general->get_tbl_data('*','loca_location',false,'loca_locationid','ASC');

		// echo "<pre>";

		// print_r($this->data['location_all']);

		// die();

		//check the form validation

		if ($this->form_validation->run() == true)

		{ 

			//if the login is successful

			// echo "test";

			// die();

			$admin_login_status= $this->mdl_login->check_login();

			// echo $admin_login_status;

			// die();

			if ($admin_login_status=='success')

			{

				$rslt= $this->general->select_menu_link_from_db();
               if(!empty($rslt)){
                  $this->general->generate_menu_link('update');   
               }else{
                  $this->general->generate_menu_link();  
               }
               
				 // if ($this->session->has_userdata('redirect')) {

		   //          redirect($this->session->redirect);

		   //          exit;

		   //      } else {

		           redirect('/home', 'refresh');exit;

		        // }

			}

			else

			{

				$this->session->set_flashdata('message',$admin_login_status);

				redirect('/login', 'refresh');exit;	

			}

		}

		//$this->template->title("Login | " . ORGA_NAME);

        //$this->template->build('index',$this->data);

		$this->load->view('login_new',$this->data);

    }

/*    public function login_new()

    {	

    	if($this->session->userdata(USER_ID))

      		{

      		redirect('home','refresh');

      		}

    	// echo "test";

    	// exit;

  		//       if ($this->general->admin_logged_in())

		// 	{

		// 		redirect(ADMIN_DASHBOARD_PATH, 'refresh');

		// exit;}

		//$store_type = $this->input->post('eqty_equipmenttypeid');

		//print_r($store_type);die;

		$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');

		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');

		$this->data['org_list']=$this->general->get_tbl_data('*','orga_organization',array('orga_isactive'=>'Y'),'orga_orgid','ASC');

		$this->data['store']=$this->general->get_tbl_data('*','eqty_equipmenttype',false,'eqty_equipmenttypeid','ASC');

		$this->data['location_all'] =$this->general->get_tbl_data('*','loca_location',false,'loca_locationid','ASC');

		// echo "<pre>";

		// print_r($this->data['location_all']);

		// die();

		//check the form validation

		if ($this->form_validation->run() == true)

		{ 

			//if the login is successful

			// echo "test";

			// die();

			$admin_login_status= $this->mdl_login->check_login();

			// echo $admin_login_status;

			// die();

			if ($admin_login_status=='success')

			{

				redirect('/home', 'refresh');exit;

			}

			else

			{

				$this->session->set_flashdata('message',$admin_login_status);

				redirect('/login', 'refresh');exit;	

			}

		}

		// $this->template->title("Login | " . ORGA_NAME);

  		//  $this->template->build('login_new',$this->data);

		$this->load->view('login_new',$this->data);

    }*/

    public function logout()

	{

		if ($this->general->user_logout())			

		{

			 redirect('login', 'refresh');exit;

		}

	}

	public function change_password()

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

}

/*end of admin.php*/