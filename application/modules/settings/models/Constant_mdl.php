<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Constant_mdl extends CI_Model 
{
    public function __construct() 
    {
        parent::__construct();
    }
    public function get_constant_list($id=false)
    {
        $this->db->select('*');
        $this->db->from('xw_cons_constant');
            if($id)
            {
                $this->db->where('cons_id',$id);
            }
            $query = $this->db->get();
           
            if ($query->num_rows() > 0) 
            {
                $data=$query->result();     
                return $data;       
            }       
        
        return false;
    }
    public function edit_constant($id)
    {
       
        $postdata['cons_id']=$this->input->post('id');
        $postdata['cons_value']=$this->input->post('cons_value');
        $postdata['cons_description']=$this->input->post('cons_description');
        $postdata['cons_isactive']=$this->input->post('cons_isactive');
        
        if(!empty($postdata))
        {
            $this->general->save_log('xw_cons_constant','cons_id',$id,$postdata,'Update');
            $this->db->update('xw_cons_constant',$postdata,array('cons_id'=>$id));
            $rowaffected=$this->db->affected_rows();
            if($rowaffected)
            {

            return $rowaffected;
            }
            else
            {
            return false;
            }
        }
    }
}