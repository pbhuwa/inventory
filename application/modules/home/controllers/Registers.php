<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Registers extends CI_Controller
{ 
	public function index()
	{
		$this->load->library('form_validation');	
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');

		$this->load->model('registers_mdl');
		$this->data['department_all']=$this->registers_mdl->get_all_department_reg();
		$this->data['designation'] = $this->general->get_tbl_data('*','desi_designation');
		$this->data['location_all'] =$this->general->get_tbl_data('*','loca_location',false,'loca_locationid','ASC');
		$name=$this->input->post('usre_fullname');
		$location_id=$this->input->post('usre_locationid');
		$this->form_validation->set_rules($this->registers_mdl->validate_settings_user_reg);

			if($this->form_validation->run()==TRUE)
			{

				$trans = $this->registers_mdl->user_reg_save();
				    
				if($trans)
				{
                    /*  for notification message*/ 
					$mess_user = array('HR');

					$message = " You have new registration request from $name.";
					$mess_title = $mess_message = $message;
					$mess_path = 'settings/notification/user_notification_detail';
					$this->general->send_message_to_user($mess_user, $mess_title, $mess_message, $mess_path, 'G',$location_id);
                    /*  for notification message*/ 
                    $this->session->set_flashdata('message_name', 'Regester seuccessfully!!  You can login After admin Approved !!');
					redirect('/login','refresh');
				
				}
				else
				{
					print_r(json_encode(array('status'=>'error','message'=>'Operation Unsuccessful')));
					exit;
				}
			}
			

		
		$this->load->view('settings/user_register/v_user_register_form',$this->data);
    
	}
	
	

public function exists_username()
	{
		$this->load->Model('registers_mdl');
		$usre_username=$this->input->post('usre_username');
		$input_id=$this->input->post('id');
		$username=$this->registers_mdl->check_exit_username_for_other($usre_username,$input_id);
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

		
}

	/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */