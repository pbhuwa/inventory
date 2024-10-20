<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manufacturers_mdl extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
		$this->table='manu_manufacturers';
	}



	public $validate_settings_manufacturers = array(               
        array('field' => 'manu_manlst', 'label' => 'Manufacturers Name', 'rules' => 'trim|required|xss_clean|callback_exists_manufacturers'),
        array('field' => 'manu_phone1', 'label' => 'Manufacturers Phone1', 'rules' => 'trim|required|xss_clean'),
        // array('field' => 'manu_phone1', 'label' => 'Phone Number', 'rules' => 'trim|required|xss_clean|numeric'),

       
        );
	
	public function manufacturers_save()
	{
		$postdata=$this->input->post();
		$id=$this->input->post('id');
		unset($postdata['id']);
		if($id)
		{

		$postdata['manu_modifydatead']=CURDATE_EN;
		$postdata['manu_modifydatebs']=CURDATE_NP;
		$postdata['manu_modifytime']=$this->general->get_currenttime();
		$postdata['manu_modifyip']=$this->session->userdata(USER_ID);
		$postdata['manu_modifyip']=$this->general->get_real_ipaddr();
		$postdata['manu_modifymac']=$this->general->get_Mac_Address();
		if(!empty($postdata))
		{
			 $this->general->save_log($this->table,'manu_manlistid',$id,$postdata,'Update');
			$this->db->update($this->table,$postdata,array('manu_manlistid'=>$id));
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
		else
		{
		$postdata['manu_postdatead']=CURDATE_EN;
		$postdata['manu_postdatebs']=CURDATE_NP;
		$postdata['manu_posttime']=$this->general->get_currenttime();
		$postdata['manu_postby']=$this->session->userdata(USER_ID);
		$postdata['manu_orgid']=$this->session->userdata(ORG_ID);
		$postdata['manu_postip']=$this->general->get_real_ipaddr();
		$postdata['manu_postmac']=$this->general->get_Mac_Address();
		// echo "<pre>";
		// print_r($postdata);
		// die();

		if(!empty($postdata))
		{
			$this->db->insert($this->table,$postdata);
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
	}
		
		return false;

	}

	public function get_all_manufacturers_view($srchcol=false)
	{
		$this->db->select('m.*,c.coun_countrycode,c.coun_countryname,d.dist_distributor, s.sete_name as tech1, s1.sete_name as tech2,s2.sete_name as tech3');
		$this->db->from('manu_manufacturers m');
		$this->db->join('coun_country c','c.coun_countryid=m.manu_countryid','LEFT');
		$this->db->join('dist_distributors d', 'd.dist_distributorid = m.manu_distributorid', 'LEFT');
		$this->db->join('sete_servicetechs s', 's.sete_techid = m.manu_servicetech1', 'LEFT');
		$this->db->join('sete_servicetechs s1', 's1.sete_techid = m.manu_servicetech2', 'LEFT');
		$this->db->join('sete_servicetechs s2', 's2.sete_techid = m.manu_servicetech3', 'LEFT');
		if($srchcol)
		{
			$this->db->where($srchcol);
		}
		$query = $this->db->get();
		// echo $this->db->last_query(); die();
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();		
			return $data;		
		}		
		return false;
	}

	public function get_all_manufacturers($srchcol=false,$limit=false,$offset=false,$order=false,$order_by=false)
	{
		$this->db->select('m.*');
		$this->db->from('manu_manufacturers m');
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

	public function remove_manufacturers()
	{
		$id=$this->input->post('id');
		if($id)
		{
			 $this->general->save_log($this->table,'manu_manlistid',$id,$postdata=array(),'Delete');
			$this->db->delete($this->table,array('manu_manlistid'=>$id));
			$rowaffected=$this->db->affected_rows();
			if($rowaffected)
			{
				return $rowaffected;
			}
			return false;
		}
		return false;
	}



	public function get_manufacturers_list($cond =false)
	{
		$get = $_GET;
 
      	foreach ($get as $key => $value) {
        	$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
      	}
     	if(!empty($get['sSearch_0'])){
            $this->db->where("manu_manlistid like  '%".$get['sSearch_0']."%'  ");
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("manu_manlst like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("manu_address1 like  '%".$get['sSearch_2']."%'  ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("manu_phone1 like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("manu_email like  '%".$get['sSearch_4']."%'  ");
        }
         if($cond) {
          $this->db->where($cond);
        }
        if($this->session->userdata(USER_ACCESS_TYPE)=='S')
      	{
        $this->db->where('manu_orgid',$this->session->userdata(ORG_ID));
      	}

        $resltrpt=$this->db->select("COUNT(*) as cnt")
  					->from('manu_manufacturers')
  					->get()
  					->row();
      	//echo $this->db->last_query();die(); 
      	$totalfilteredrecs=$resltrpt->cnt; 

      	$order_by = 'manu_manlistid';
      	$order = 'desc';
      	if($this->input->get('sSortDir_0'))
  		{
  				$order = $this->input->get('sSortDir_0');
  		}
  
      	$where='';
      	if($this->input->get('iSortCol_0')==0)
        	$order_by = 'manu_manlistid';
      	else if($this->input->get('iSortCol_0')==1)
        	$order_by = 'manu_manlst';
      	else if($this->input->get('iSortCol_0')==2)
       		$order_by = 'manu_address1';
       	else if($this->input->get('iSortCol_0')==3)
      	 	$order_by = 'manu_phone1';
      	else if($this->input->get('iSortCol_0')==4)
      	 	$order_by = 'manu_email';
      	
      	$totalrecs='';
      	$limit = 15;
      	$offset = 1;
      	$get = $_GET;
 
	    foreach ($get as $key => $value) {
	        $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
	    }
      
        if(!empty($_GET["iDisplayLength"])){
           $limit = $_GET['iDisplayLength'];
           $offset = $_GET["iDisplayStart"];
        }

        if(!empty($get['sSearch_0'])){
            $this->db->where("manu_manlistid like  '%".$get['sSearch_0']."%'  ");
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("manu_manlst like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("manu_address1 like  '%".$get['sSearch_2']."%'  ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("manu_phone1 like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("manu_email like  '%".$get['sSearch_4']."%'  ");
        }
        if($cond) {
          $this->db->where($cond);
        }
        if($this->session->userdata(USER_ACCESS_TYPE)=='S')
      	{
        $this->db->where('manu_orgid',$this->session->userdata(ORG_ID));
      	}
        
        $this->db->select('*');
		$this->db->from('manu_manufacturers');
        $this->db->order_by($order_by,$order);
        
        // if($cond) {
        // 	$this->db->where('manu_postdatead =', date("Y/m/d"));
        // }
        if($limit && $limit>0)
        {  
            $this->db->limit($limit);
        }
        if($offset)
        {
            $this->db->offset($offset);
        }
      
       $nquery=$this->db->get();
       $num_row=$nquery->num_rows();
        if (!empty($_GET['iDisplayLength']) &&  !empty($nquery) && is_array($nquery) && count($nquery) > 0 ) {
            $totalrecs = sizeof($nquery);
        }


       if($num_row>0){
          $ndata=$nquery->result();
          $ndata['totalrecs'] = $totalrecs;
          $ndata['totalfilteredrecs'] = $totalfilteredrecs;
        } 
        else
        {
            $ndata=array();
            $ndata['totalrecs'] = 0;
            $ndata['totalfilteredrecs'] = 0;
        }
	    //echo $this->db->last_query();die();
	  return $ndata;

	}

	public function check_exit_manafacture_for_other($mnlist=false,$id=false)
		{
		$data = array();

		if($id)
		{
			$query = $this->db->get_where($this->table,array('manu_manlst'=>$mnlist,'manu_manlistid !='=>$id));
		}
		else
		{
			$query = $this->db->get_where($this->table,array('manu_manlst'=>$mnlist));
		}
		if ($query->num_rows() > 0) 
		{
			$data=$query->row();	
			return $data;			
		}
		return false;
		}


}