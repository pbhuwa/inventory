<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Notification extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->Model('notification_mdl');
	}
public function user_notification_all()
{
    $srchcol=array('mess_userid'=>$this->session->userdata(USER_ID),'mess_isdelete'=>'N');	
	$this->data['notification']=$this->general->get_message($srchcol,false,false,'mess_messageid','DESC');
		// echo "<pre>";
		// print_r($this->data['notification']);
		// exit;
		$this->data['active_menu']='';
		$seo_data='';//$this->general->get_seo(LANG_ID,4);
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

			->build('notification/v_user_notification', $this->data);	
}

public function user_notification_detail($id=false)

{
	$message_id=$id;

	$user_id=$this->session->userdata(USER_ID);

	$notification=$this->data['notification_data']= $this->notification_mdl->notification_user($message_id);
	// print_r($this->data['notification_data']);die;

	$id=$notification[0]->mess_messageid;

	$msg_status=$notification[0]->mess_status;

	$msg_path = $notification[0]->mess_path;

	if ($msg_status=='U') 

	{

		$this->notification_mdl->update_message_status($id);

	}
		// $id=$notification[0]->jobid;

		// $this->data['job_detail']= $this->user_model->job_detail($id);
		$this->data['active_menu']='';
		$this->data['message_id']=$message_id;
		$seo_data='';//$this->general->get_seo(LANG_ID,4);

		redirect(base_url($msg_path));
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
			->build('notification/v_user_notification_detail', $this->data);	
}
public function delete_notification()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		$tran=$this->notification_mdl->delete_message_notification();
		if($tran)

			{

				print_r(json_encode(array('status'=>'success','message'=>'Notification Deleted Successfully!!')));

				// redirect(site_url('my_account/seeker/seeker_notification'),'refresh');

				exit;
			}
			else
			{
				print_r(json_encode(array('status'=>'error','message'=>'Notification Deleted UnSuccessfully!!')));

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