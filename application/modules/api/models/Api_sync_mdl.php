<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api_sync_mdl extends CI_Model 
{

	public function __construct() 
	{
		parent::__construct();
		
	}





	public function get_all_faq_cat($srchcol=false,$limit=false,$offset=false,$order=false,$order_by=false)
	{
		$this->db->select('*');
		$this->db->from('facq_faqcategory');
		if($srchcol)
		{
			$this->db->where($srchcol);
		}
		if($limit && $limit>0)
		{
			$this->db->limit($limit);
		}
		if($offset)
		{
			$this->db->offset($offset);
		}

		if($order)
		{
			$this->db->order_by($order,$order_by);
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

public function get_all_faq($srchcol=false,$limit=false,$offset=false,$order=false,$order_by=false)
	{
		$this->db->select('*');
		$this->db->from('fali_faqlist');
		if($srchcol)
		{
			$this->db->where($srchcol);
		}
		if($limit && $limit>0)
		{
			$this->db->limit($limit);
		}
		if($offset)
		{
			$this->db->offset($offset);
		}

		if($order)
		{
			$this->db->order_by($order,$order_by);
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
}
        
                
                 
                
                
              
               
                     
                  
            
    
                
               
                    
                
                
                     
                   