<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Purchase_donate_mdl extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
		$this->table='pudo_purchdonate';
	}

	public $validate_purchase_donate = array(               
        array('field' => 'pudo_purdonated', 'label' => 'Purchase Donate', 'rules' => 'trim|required|xss_clean|min_length[3]'),
        );
	
	
	public function save_purchase_donate()
	{
		$postdata=$this->input->post();
		$id=$this->input->post('id');
		

		$postid=$this->general->get_real_ipaddr();
		$postmac=$this->general->get_Mac_Address();
		unset($postdata['id']);
			// echo "<pre>";
			// print_r($id);
			// die();
		if($id)
		{
			$this->db->trans_start();
			$postdata['pudo_modifydatead']=CURDATE_EN;
			$postdata['pudo_modifydatebs']=CURDATE_NP;
			$postdata['pudo_modifytime']=$this->general->get_currenttime();
			$postdata['pudo_modifyby']=$this->session->userdata(USER_ID);
			$postdata['pudo_modifyip']=$postid;
			$postdata['pudo_modifymac']=$postmac;
			
			if(!empty($postdata))
			{
				 $this->general->save_log($this->table,'pudo_purdonatedid',$id,$postdata,'Update');
				$this->db->update($this->table,$postdata,array('pudo_purdonatedid'=>$id));
				
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
		
			$postdata['pudo_postdatead']=CURDATE_EN;
			$postdata['pudo_postdatebs']=CURDATE_NP;
			$postdata['pudo_posttime']=$this->general->get_currenttime();
			$postdata['pudo_postby']=$this->session->userdata(USER_ID);
			$postdata['pudo_postip']=$postid;
			$postdata['pudo_postmac']=$postmac;
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


	public function get_all_purchase_donate($srchcol=false)
	{
		$this->db->select('ds.*');
		$this->db->from('pudo_purchdonate ds');
		
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

	


	public function remove_purchase_donate()
	{
		$id=$this->input->post('id');
		if($id)
		{
			 $this->general->save_log($this->table,'pudo_purdonatedid',$id,$postdata=array(),'Delete');
			$this->db->delete($this->table,array('pudo_purdonatedid'=>$id));
			$rowaffected=$this->db->affected_rows();
			if($rowaffected)
			{
				return $rowaffected;
			}
			return false;
		}
		return false;
	}


	public function check_exit_username_for_other($eqli_username,$input_id)
	{
		$data = array();
		$query = $this->db->get_where($this->table,array('eqli_username'=>$eqli_username,'eqli_userid'=>$input_id));
		if ($query->num_rows() > 0) 
		{
			$data=$query->row();	
			return $data;			
		}
		return false;
	}

	public function get_purchasedonate_list()
	{
		$get = $_GET;
 
      	foreach ($get as $key => $value) {
        	$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
      	}
     	
     	if(!empty($get['sSearch_0'])){
            $this->db->where("pudo_purdonatedid like  '%".$get['sSearch_0']."%'  ");
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("pudo_purdonated like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("pudo_postdatebs like  '%".$get['sSearch_2']."%'  ");
        }
         
      	$resltrpt=$this->db->select("COUNT(*) as cnt")
      					->from('pudo_purchdonate')
      					->get()
      					->row();
      	//$resltrpt=$this->db->query("SELECT COUNT(*) as cnt FROM xw_pudo_purchdonate  ")->row();
	    //echo $this->db->last_query();die(); 
      	$totalfilteredrecs=$resltrpt->cnt; 

      	$order_by = 'pudo_purdonatedid';
      	$order = 'desc';
      	if($this->input->get('sSortDir_0'))
  		{
  				$order = $this->input->get('sSortDir_0');
  		}
  
      	$where='';
      	if($this->input->get('iSortCol_0')==0)
        	$order_by = 'pudo_purdonatedid';
      	else if($this->input->get('iSortCol_0')==1)
        	$order_by = 'pudo_purdonated';
      	else if($this->input->get('iSortCol_0')==2)
       		$order_by = 'pudo_postdatebs';
      	
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
            $this->db->where("pudo_purdonatedid like  '%".$get['sSearch_0']."%'  ");
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("pudo_purdonated like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("pudo_postdatebs like  '%".$get['sSearch_2']."%'  ");
        }
       
        $this->db->select('*');
		$this->db->from('pudo_purchdonate');
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