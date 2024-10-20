<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Constant_set_mdl extends CI_Model 
{
    public function __construct() 
    {
        parent::__construct();
         $this->userid = $this->session->userdata(USER_ID);
        $this->username = $this->session->userdata(USER_NAME);
        $this->curtime = $this->general->get_currenttime();
        $this->mac = $this->general->get_Mac_Address();
        $this->ip = $this->general->get_real_ipaddr();
        $this->locationid=$this->session->userdata(LOCATION_ID);
        $this->orgid=$this->session->userdata(ORG_ID);
    }
   
    public function save_constant_set()
    {
        $postdata=$this->input->post();
       
        $postdata['cons_postdatead']=CURDATE_EN;
        $postdata['cons_postdatebs']=CURDATE_NP;
        $postdata['cons_posttime']=date('H:i:s');
        $postdata['cons_postby']=$this->session->userdata(USER_ID);
        $postdata['cons_postip']=$this->general->get_real_ipaddr();
        $postdata['cons_postmac']=$this->general->get_Mac_Address();
        if(!empty($postdata))
        {
            $this->db->insert('xw_cons_constant',$postdata);
            $insertid=$this->db->insert_id();
            if($insertid)
            {
                return $insertid;
            }
            else
            {
                return false;
            }
        }

        
        return false;

    }
    public function get_constant_set_list($id=false,$srch=false)
    {
        $this->db->select('*');
        $this->db->from('xw_cons_constant');
            if($id)
            {
                $this->db->where('cons_id',$id);
            }
             if($srch)
            {
                $this->db->where($srch);
            }
            $query = $this->db->get();
           
            if ($query->num_rows() > 0) 
            {
                $data=$query->result();     
                return $data;       
            }       
        
        return false;
    }
      public function get_constant_category()
    {
        $this->db->select('DISTINCT(cons_category)');
        $this->db->from('xw_cons_constant');
           
            $query = $this->db->get();
           
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
        $postdata['cons_modifydatead']=CURDATE_EN;
        $postdata['cons_modifydatebs']=CURDATE_NP;
        $postdata['cons_modifytime']=date('H:i:s');
        $postdata['cons_modifyby']=$this->session->userdata(USER_ID);
        $postdata['cons_modifyip']=$this->general->get_real_ipaddr();
        $postdata['cons_modifymac']=$this->general->get_Mac_Address();
        foreach ($cons_id as $key => $value) 
        {
         $dataArray[]= array(
                    
                    'cons_id'=>$cons_id[$key],
                    'cons_value'=>$cons_value[$key],
                    'cons_modifydatead'=>CURDATE_EN,
                    'cons_modifydatebs'=>CURDATE_NP,
                    'cons_modifytime'=>$this->curtime,
                    'cons_modifyby'=>$this->userid,
                    'cons_modifymac'=>$this->mac,
                    'cons_modifyip'=>$this->ip,
                    'cons_locationid'=>$this->locationid,
                    'cons_orgid'=>$this->orgid
                    
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