<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notification_mdl extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
		// $this->table='dept_department';
		// $this->table='usma_usermain';
		 $this->sess_usercode = $this->session->userdata(USER_GROUPCODE);
        $this->sess_dept = $this->session->userdata(USER_DEPT);
         $this->locationid = $this->session->userdata(LOCATION_ID);
	}
	  public function notification_user($id=false)
    {
        $this->db->select('*');
        $this->db->from('mess_message');
        if($id)
        {
            $this->db->where('mess_messageid',$id);
        }
        
        $query = $this->db->get();

        if ($query->num_rows() > 0)
        {
         return $data=$query->result();
        } 
        return false;

    }
 public function update_message_status($id)
    {
        $date=date('Y-m-d h:i:s');
        $this->db->update('mess_message',array('mess_status'=>'R','mess_updatedatead'=> $date), array('mess_messageid'=>$id));
    }


    public function delete_message_notification()
    {
       $message_id=$this->input->post('id');
        $date=date('Y-m-d h:i:s');
       
        // echo $message_id;
        // die();
        $user_id=$this->session->userdata(USER_ID);
        $this->db->update('mess_message',array('mess_isdelete'=>'Y','mess_deletedatead'=> $date), array('mess_messageid'=>$message_id));
        // echo $this->db->last_query();
        // die();
        $affrws=$this->db->affected_rows();
        if($affrws)
        {
            return $affrws;
        }
        return false;
    }

}