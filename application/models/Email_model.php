<?php
class email_model extends CI_Model
{
	function __construct()
	{
		
	}
	
	//to get email body and subject
	function get_email_template($mail_type=false,$lang_id=false)
	{
		$options=array('notification_code'=>$mail_type,'lang_id'=>$lang_id);
		$query=$this->db->get_where('system_notifications',$options);
		// echo $this->db->last_query();
		// die();
		return $query->row_array();;

	}

	//to parse the the email which is available in the
	function parse_email($parseElement,$mail_body)
	{
		foreach($parseElement as $name=>$value)
		{
			$parserName=$name;
			$parseValue=$value;
			$mail_body=str_replace("[$parserName]",$parseValue,$mail_body);
		}
		return $mail_body;
	}	
}
?>