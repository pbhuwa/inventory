<?php if(!defined('BASEPATH')) exit('No direct script allowed');



class Mdl_login extends CI_Model{



	public $validation;



	function __construct(){

		parent::__construct();

		$this->validation = array(

							array(

								'field'	=>	'user-name',

								'label'	=>	'Username',

								'rules'	=>	'trim|required|min_length[5]|xss_clean'

							),

							array(

								'field'	=>	'password',

								'label'	=>	'Password',

								'rules'	=>	'trim|required|min_length[5]|xss_clean'

							)

						);

	}



	public $validate_settings_changePass=array(

   // array('field' => 'password', 'label' => 'Old Password', 'rules' => 'trim|required|callback_oldpassword'),

    array('field' => 'new_password', 'label' => 'New Password', 'rules' => 'trim|required|xss_clean'),

    array('field' => 're_new_password', 'label' => 'Confirm Password', 'rules' => 'required|matches[new_password]'),

  );









	public function check_login() 

	{



		// echo "test";die();

		$uname = $this->input->post('username',TRUE);

		$pass = $this->input->post('password',TRUE);

		$usgr_accesssystemid = $this->input->post('usgr_accesssystemid');

		$store_type = $this->input->post('eqty_equipmenttypeid');

		

		// print_r($store_type);die;

		$this->db->select('um.*,ug.*,lo.*');

		$this->db->from('usma_usermain um');

		$this->db->join('usgr_usergroup ug','ug.usgr_usergroupid=um.usma_usergroupid','LEFT');

		$this->db->join('loca_location lo','lo.loca_locationid=um.usma_locationid','LEFT');

		// $this->db->where('usma_locationid',$this->input->post('usma_locationid'));
		if (ORGANIZATION_NAME != 'NPHL') {
			$this->db->where('usma_orgid',$usgr_accesssystemid);
		}


		$this->db->where('usma_username',$this->input->post('username',TRUE));

		$this->db->or_where('usma_email',$this->input->post('username',TRUE));

		$query = $this->db->get();

		// echo $this->db->last_query();

		// die();

		if($query->num_rows()>0)

		{



			$record = $query->row();

			// echo "<pre>";

			// print_r($record);

			// die();

			

			if($record->usma_status==1)

			{

			// 	echo "<pre>";

			// print_r($record);

			// die();

				// echo $record->usma_userpassword;

				// echo "<br>";

				// echo $this->general->hash_password($pass,$record->usma_salt);

				// die();

				





				if((strtolower($record->usma_username)==strtolower($uname) ||strtolower($record->usma_email)==strtolower($uname)) && $record->usma_userpassword==$this->general->hash_password($pass,$record->usma_salt))

				{



					$mat_typeid=!empty($record->usma_materialtypeid)?$record->usma_materialtypeid:'';

					// echo $mat_typeid;

					// die();

				

				// echo $usgr_accesssystemid;

				// die();



				if($usgr_accesssystemid == 3)

				{ 	//echo "inside";print_r($store_type);die;

					$this->session->set_userdata(STORE_ID, $store_type);

				}

					// echo "tes";

					// die();

					//update admin last login

					$this->update_member($record->usma_userid);

					

					$this->session->set_userdata(USER_ID, $record->usma_userid);

					$this->session->set_userdata(USER_NAME, $record->usma_username);

					// $this->session->set_userdata(USER_EMAIL, $record->usma_email);

					$this->session->set_userdata(USER_GROUP, $record->usma_usergroupid);

					$this->session->set_userdata(USER_GROUPCODE, $record->usgr_usergroupcode);

					if (ORGANIZATION_NAME == 'NPHL') {
					$this->session->set_userdata(ORG_ID, $usgr_accesssystemid );
						
					}else{

					$this->session->set_userdata(ORG_ID, $record->usma_orgid);
					}


					$this->session->set_userdata(USER_ACCESS_TYPE, $record->usgr_accesstypes);

					$this->session->set_userdata(USER_ACCESS_SYSTEM, $record->usgr_accesssystemid);

					$this->session->set_userdata(USER_DEPT, $record->usma_departmentid);

					$this->session->set_userdata(ISMAIN_LOCATION, $record->loca_ismain);

					$this->session->set_userdata(LOCATION_ID, $record->usma_locationid);

					$this->session->set_userdata(LOCATION_NAME,$record->loca_name);

					if(defined('LOCATION_CODE')):

					$this->session->set_userdata(LOCATION_CODE,$record->loca_code);

					endif;



					$this->session->set_userdata(LOGINDATETIME, date('Y/m/d').' '.$this->general->get_currenttime());

					if(defined('USER_DESIGNATION')):

					$this->session->set_userdata(USER_DESIGNATION, $record->usma_desiid);

					

					if(!empty($mat_typeid)){

						$this->session->set_userdata(USER_MAT_TYPEID, $mat_typeid);

					}

					

					





				endif;

					// echo "<pre>";

					// print_r($this->session);

					// die();

					

					

					$this->login_activity($record->usma_userid,'Y');

					

					return "success";

				}

				else

				{

					

					$this->login_activity(0,'N');

					return 'Invalid Username or Password ';	

				}

				

			}

			else

			{

				//keep log of login if login is not successful

				if(LOG_INVALID_LOGIN == 'Y'){ 

				// $this->general->log_invalid_logins(array('password' => $pass, 'username' => $uname, 'module' => 'Admin Login', 'desc' => 'Invalid Username or Password'));

				}

				$this->login_activity(0,'N');

				return 'Invalid Username or Password';	

			}

		}

		else

		{

			//keep log of login if login is not successful

			// if(LOG_INVALID_LOGIN == 'Y'){ 

			// $this->general->log_invalid_logins(array('password' => $pass, 'username' => $uname, 'module' => 'Admin Login', 'desc' => 'Invalid Username or Password'));

			// }

			$this->login_activity(0,'N');

			return 'Invalid Username or Password';

		}

	}



	public function update_member($usma_userid)

	{

		$postid=$this->general->get_real_ipaddr();

		$postmac=$this->general->get_Mac_Address();

		

		$udata = array(

               	'usma_loginmac' => $postmac,

				'usma_loginip' =>$postid,

				'usma_islogin' => '1',

				'usma_logintime'=>$this->general->get_currenttime(),

				'usma_logindatead'=>CURDATE_EN,

				'usma_logindatebs'=>CURDATE_NP,

				);

				

		$this->db->where('usma_userid',$usma_userid);

		$this->db->update('usma_usermain',$udata);

	}



	public function login_activity($userid=0,$validlogin=Y)

	{

		$uname = $this->input->post('username',TRUE);

		if (filter_var($uname, FILTER_VALIDATE_EMAIL)) {

			$usrname='';

			$email=$uname;

		}

		else

		{

			$usrname=$uname;

			$email='';

		}



		$postid=$this->general->get_real_ipaddr();

		$postmac=$this->general->get_Mac_Address();

		

		$postdate = array(

				'loac_loginuserid'=>$userid,

               'loac_loginuseremail' =>$email ,

				'loac_loginusername'=>$usrname,

				'loac_logintime'=>$this->general->get_currenttime(),

				'loac_logindatead'=>CURDATE_EN,

				'loac_logindatebs'=>CURDATE_NP,

				'loac_loginmac' => $postmac,

				'loac_loginip' =>$postid,

				'loac_isvalidlogin'=>$validlogin

				);

		// echo "<pre>";

		// print_r($postdate);

		// die();

		

		$this->db->insert('loac_loginactivity',$postdate);

	}





  public function change_users_password($user_id=false){

    $password_tmp  = $this->input->post('new_password');

    // Create a random salt

    $salt = $this->general->salt();   

    $password = $this->general->hash_password($password_tmp, $salt);

        

    $data = array(

            'usma_userpassword' => $password,

            'usma_salt' => $salt

        );

        

    $this->db->update('usma_usermain', $data,array('usma_userid' => $user_id));

         // echo $this->db->last_query(); 

         // die();

        return $this->db->affected_rows();

    }

}