<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Audit_trial_mdl extends CI_Model 
{

	public function __construct() 
	{
		parent::__construct();
    $this->table='colt_commonlogtable';
		
	}


public function get_audit_trial_rec($srchcol=false,$limit=false,$offset=false,$order_by=false,$order=false)
{
    $this->db->select('cl.*');
    $this->db->from('colt_commonlogtable cl');

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

      if($order_by)
      {
        $this->db->order_by($order_by,$order);
      }
      $qry=$this->db->get();
      //echo $this->db->last_query();die();
      
        if($qry->num_rows()>0)
          {
          return $qry->result();
       }
     return false;
  }

	public function get_table_list($srchcol=false,$limit=false,$offset=false,$order_by=false,$order=false)
{
    $this->db->select('cl.colt_tablename,tn.tana_tabledisplay');
    $this->db->from('colt_commonlogtable cl');
    $this->db->join('tana_tablename tn','cl.colt_tablename=tn.tana_tablename','inner');
    $this->db->group_by('cl.colt_tablename,tn.tana_tabledisplay');

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

      if($order_by)
      {
        $this->db->order_by($order_by,$order);
      }
      $qry=$this->db->get();
      //echo $this->db->last_query();die();
      
        if($qry->num_rows()>0)
          {
          return $qry->result();
       }
     return false;
  }

}
