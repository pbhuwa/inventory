<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class System_setting_mdl extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
		// $this->table='comm_community';
	}

	public function get_all_constant($srchcol=false)
	{
		$this->db->select('*');
		$this->db->from('cons_constant');
		if($srchcol)
		{
			$this->db->where($srchcol);
		}
		$query = $this->db->get();
		// echo $this->db->last_query();
		// die();
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();		
			return $data;		
		}		
		return false;
	}

	public function update_constant()
	{
		$cons_id=$this->input->post('cons_id');
		$cons_value=$this->input->post('cons_value');
		foreach ($cons_id as $key => $value) 
		{
		 $dataArray[]= array(
                    
                    'cons_id'=>$cons_id[$key],
                    'cons_value'=>$cons_value[$key],
                    
                );
		 }
		 if (is_array($dataArray) && ! empty($dataArray))
	    {
	        
	        $this->db->update_batch('cons_constant', $dataArray, 'cons_id');
	        //echo $this->db->last_query();
	    }
	    $rowaffected=$this->db->affected_rows();
        if($rowaffected)
        {
          return $rowaffected;
        }
		return false;
	}

}