<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Colorcode_set_mdl extends CI_Model 
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
   
    public function save_colorcode_set()
    {
        $postdata=$this->input->post();
       
        $postdata['coco_postdatead']=CURDATE_EN;
        $postdata['coco_postdatebs']=CURDATE_NP;
        $postdata['coco_posttime']=date('H:i:s');
        $postdata['coco_postby']=$this->session->userdata(USER_ID);
        $postdata['coco_postip']=$this->general->get_real_ipaddr();
        $postdata['coco_postmac']=$this->general->get_Mac_Address();
        if(!empty($postdata))
        {
            $this->db->insert('xw_coco_colorcode',$postdata);
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
    public function get_colorcode_set_list($id=false,$srch=false)
    {
        $this->db->select('*');
        $this->db->from('xw_coco_colorcode');
            if($id)
            {
                $this->db->where('coco_colorcodeid',$id);
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
      public function get_colorcode_category()
    {
        $this->db->select('DISTINCT(coco_category)');
        $this->db->from('xw_coco_colorcode');
           
            $query = $this->db->get();
           
            if ($query->num_rows() > 0) 
            {
                $data=$query->result();     
                return $data;       
            }       
        
        return false;
    }
    public function update_colorcode()
    {


        $coco_colorcodeid=$this->input->post('coco_colorcodeid');
        $coco_color=$this->input->post('coco_color');
        $coco_bgcolor=$this->input->post('coco_bgcolor');
        $coco_displaystatus=$this->input->post('coco_displaystatus');
        $postdata['coco_modifydatead']=CURDATE_EN;
        $postdata['coco_modifydatebs']=CURDATE_NP;
        $postdata['coco_modifytime']=date('H:i:s');
        $postdata['coco_modifyby']=$this->session->userdata(USER_ID);
        $postdata['coco_modifyip']=$this->general->get_real_ipaddr();
        $postdata['coco_modifymac']=$this->general->get_Mac_Address();
        foreach ($coco_colorcodeid as $key => $value) 
        {
         $dataArray[]= array(
                    
                    'coco_colorcodeid'=>$coco_colorcodeid[$key],
                    'coco_color'=>$coco_color[$key],
                    'coco_bgcolor'=>$coco_bgcolor[$key],
                    'coco_displaystatus'=>$coco_displaystatus[$key],
                    'coco_modifydatead'=>CURDATE_EN,
                    'coco_modifydatebs'=>CURDATE_NP,
                    'coco_modifytime'=>$this->curtime,
                    'coco_modifyby'=>$this->userid,
                    'coco_modifymac'=>$this->mac,
                    'coco_modifyip'=>$this->ip,
                    'coco_locationid'=>$this->locationid,
                    'coco_orgid'=>$this->orgid
                    
                );
         }
         if (is_array($dataArray) && ! empty($dataArray))
        {
            
            $this->db->update_batch('coco_colorcode', $dataArray, 'coco_colorcodeid');
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