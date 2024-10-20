<?php 
if ( ! function_exists('ip_accept_check'))
{
	/**
	 * Elements
	 *
	 * Returns only the array items specified. Will return a default value if
	 * it is not set.
	 *
	 * @param	array
	 * @param	array
	 * @param	mixed
	 * @return	mixed	depends on what the array contains
	 */
	
	function ip_accept_check()
	{   
		$ci =& get_instance();
		$ip = $ci->input->ip_address();
		$return = array();
		$ci->db->select('ip_address');
		$query = $ci->db->get_where('accepted_ips_dashboard', array('ip_address' => $ip));
		$data  = $query->result();
		if(count($data) < 1)
		{
			redirect('/permissiondenied/index', 'refresh');
		}
		return TRUE;

        
	}
}

?>