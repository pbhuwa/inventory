<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bio_inventory_setting_mdl extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
		$this->table='bmin_bmeinventory';
	}


public function get_auto_generated_id()
{

  $this->db->order_by('bise_biomedicalsettingid','DESC');
  $this->db->limit(1);
  $query=$this->db->get('bise_biomedicalsettingid');
  if($query->num_rows()>0)
  {
    return $query->row();
  }
  return false;

}


}