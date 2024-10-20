<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Department_information_mdl extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
		$this->table='dein_departmentinformation';
	}


	public $validate_settings_department = array(               
        array('field' => 'dein_department', 'label' => 'Department Name', 'rules' => 'trim|required|xss_clean|min_length[3]'),
        array('field' => 'dein_contact', 'label' => 'Contact', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'dein_phone', 'label' => 'Department phone', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'dein_department_head', 'label' => 'Department Head', 'rules' => 'trim|required|xss_clean'),
        );


	
	
	public function save_department()
	{
		$postdata=$this->input->post();
		$id=$this->input->post('id');
		

		$postid=$this->general->get_real_ipaddr();
		$postmac=$this->general->get_Mac_Address();
		unset($postdata['id']);
	
		if($id)
		{
			$this->db->trans_start();
			$postdata['dein_modifydatead']=CURDATE_EN;
			$postdata['dein_modifydatebs']=CURDATE_NP;
			$postdata['dein_modifytime']=$this->general->get_currenttime();
			$postdata['dein_modifyby']=$this->session->userdata(USER_ID);
			$postdata['dein_modifyip']=$postid;
			$postdata['dein_modifymac']=$postmac;
			if(!empty($postdata))
			{
				$this->db->update($this->table,$postdata,array('dein_departmentid'=>$id));
				
			}

			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
				{
				        $this->db->trans_rollback();
				        return false;
				}
				else
				{
				        $this->db->trans_commit();
				        return true;
				}
		}
		else
		{
		
			$postdata['dein_postdatead']=CURDATE_EN;
			$postdata['dein_postdatebs']=CURDATE_NP;
			$postdata['dein_posttime']=$this->general->get_currenttime();
			$postdata['dein_postby']=$this->session->userdata(USER_ID);
			$postdata['dein_postip']=$postid;
			$postdata['dein_postmac']=$postmac;
			// echo "<pre>";
			// print_r($postdata);
			// die();
			$this->db->trans_start();
			if(!empty($postdata))
			{
				$this->db->insert($this->table,$postdata);
				
			
			}
				
			
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
				{
				        $this->db->trans_rollback();
				        return false;
				}
				else
				{
				        $this->db->trans_commit();
				        return true;
				}
			}
			return false;
	}


	public function get_all_department($srchcol=false)
	{
		$this->db->select('ds.*');
		$this->db->from('dein_departmentinformation ds');
		
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



	


	public function remove_department()
	{
		$id=$this->input->post('id');
		if($id)
		{
			$this->db->delete($this->table,array('dein_departmentid'=>$id));
			$rowaffected=$this->db->affected_rows();
			if($rowaffected)
			{
				return $rowaffected;
			}
			return false;
		}
		return false;
	}


	public function check_exit_username_for_other($dein_username,$input_id)
	{
		$data = array();
		$query = $this->db->get_where($this->table,array('dein_username'=>$dein_username,'dein_userid'=>$input_id));
		if ($query->num_rows() > 0) 
		{
			$data=$query->row();	
			return $data;			
		}
		return false;
	}


	public function get_department_information_list()
	{
		$get = $_GET;
 
      	foreach ($get as $key => $value) {
        	$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
      	}
     	 $where='';

      	if(!empty(($this->input->get('frmDate') && $this->input->get('toDate'))))
      	{
          // $where. ="WHERE WANO_DATE BETWEEN '".$get['frmDate']."' and '".$get['toDate']."'";
      	}
     	 if(!empty($get['sSearch_2']))
      	{
      		$where.="WHERE dein_department LIKE '%".$get['sSearch_2']."%'";
      	}
      	if(!empty($get['sSearch_3']))
      	{
      		$where.="WHERE dein_contact LIKE '%".$get['sSearch_3']."%'";
      	}
      	if(!empty($get['sSearch_4']))
      	{
      		$where.="WHERE dein_department_head LIKE '%".$get['sSearch_4']."%'";
      	}
      	if(!empty($get['sSearch_5']))
      	{
      		$where.="WHERE dein_department_head LIKE '%".$get['sSearch_5']."%'";
      	}
         
      	$resltrpt=$this->db->query("SELECT COUNT(*) as cnt FROM xw_dein_departmentinformation  $where ")->row();
	    //echo $this->db->last_query();die(); 
      	$totalfilteredrecs=$resltrpt->cnt; 

      	$order_by = 'dein_departmentid';
      	$order = 'desc';
      	if($this->input->get('sSortDir_0'))
  		{
  				$order = $this->input->get('sSortDir_0');
  		}
  
      	$where='';
      	if($this->input->get('iSortCol_0')==2)
        	$order_by = 'dein_department';
      	else if($this->input->get('iSortCol_0')==3)
        	$order_by = 'dein_contact';
      	else if($this->input->get('iSortCol_0')==4)
       		$order_by = 'dein_department_head';
       	else if($this->input->get('iSortCol_0')==5)
      	 	$order_by = 'dein_phone';
      	
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

        if(!empty($get['sSearch_1'])){
            $this->db->where("dein_department like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("dein_contact like  '%".$get['sSearch_2']."%'  ");
        }

        if(!empty($get['sSearch_3'])){
            $this->db->where("dein_department_head like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("dein_phone like  '%".$get['sSearch_4']."%'  ");
        }

        // if(!empty($get['frmDate']) && !empty($get['toDate']))
        // {
       	// 	$this->db->where("WANO_DATE BETWEEN '".$get['frmDate']."' and '".$get['toDate']."'");
        // }

        $this->db->select('*');
        $this->db->from('dein_departmentinformation pm');
        $this->db->order_by($order_by,$order);
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
	    // echo $this->db->last_query();die();
	  return $ndata;

	}
	
}