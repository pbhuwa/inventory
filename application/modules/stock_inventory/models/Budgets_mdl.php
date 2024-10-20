<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Budgets_mdl extends CI_Model 
{
	
	public function __construct() 
	{
		parent::__construct();
		$this->table='budg_budgets';
		$this->locationid=$this->session->userdata(LOCATION_ID);
		$this->location_ismain = $this->session->userdata(ISMAIN_LOCATION);
	}

	public $validate_settings_budgets = array( 
	  array('field' => 'budg_budgetname', 'label' => 'Budgets Name ', 'rules' => 'trim|required|xss_clean|callback_exists_budgetsname'),
       );                
	
	public function save_budgets()
	{
		$postdata=$this->input->post();
		$id=$this->input->post('id');
		unset($postdata['id']);
		if($id)
		{
		$postdata['budg_modifydatead']=CURDATE_EN;
		$postdata['budg_modifydatebs']=CURDATE_NP;
		$postdata['budg_modifytime']=date('H:i:s');
		$postdata['budg_modifyby']=$this->session->userdata(USER_ID);
		$postdata['budg_modifyip']=$this->general->get_real_ipaddr();
		$postdata['budg_modifymac']=$this->general->get_Mac_Address();
		$postdata['budg_locationid']=$this->locationid;
		if(!empty($postdata))
		{
			$this->db->update($this->table,$postdata,array('budg_budgetid'=>$id));
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
		$postdata['budg_postdatead']=CURDATE_EN;
		$postdata['budg_postdatebs']=CURDATE_NP;
		$postdata['budg_posttime']=date('H:i:s');
		$postdata['budg_postby']=$this->session->userdata(USER_ID);
		$postdata['budg_orgid']=$this->session->userdata(ORG_ID);
		$postdata['budg_postip']=$this->general->get_real_ipaddr();
		$postdata['budg_postmac']=$this->general->get_Mac_Address();
		$postdata['budg_locationid']=$this->locationid;
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
	
	public function remove_budgets()
	{
		$id=$this->input->post('id');
		if($id)
		{
			 $this->general->save_log($this->table,'budg_budgetid',$id,$postdata=array(),'Delete');
			$this->db->delete($this->table,array('budg_budgetid'=>$id));
			$rowaffected=$this->db->affected_rows();
			if($rowaffected)
			{
				return $rowaffected;
			}
			return false;
		}
		return false;
	}

public function get_budgets_list($srch=false)
	{
		$get = $_GET;
      	foreach ($get as $key => $value) {
        	$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
      	}
    //    if(!empty($get['sSearch_1'])){
    //         $this->db->where("budg_code like  '%".trim($get['sSearch_1'])."%'  ");
    //     }
        if(!empty($get['sSearch_2'])){
            $this->db->where("lower(budg_budgetname) like  '%".trim($get['sSearch_2'])."%'  ");
        }
      	$resltrpt=$this->db->select("COUNT(*) as cnt")
      					->from('budg_budgets as bb')
                       ->get()
      					->row();
      	//$resltrpt=$this->db->query("SELECT COUNT(*) as cnt FROM xw_pudo_purchdonate  ")->row();
	    //echo $this->db->last_query();die(); 
      	$totalfilteredrecs=$resltrpt->cnt; 
      	$order_by = 'budg_budgetid';
      	$order = 'desc';
      	if($this->input->get('sSortDir_0'))
  		{
  				$order = $this->input->get('sSortDir_0');
  		}
      	$where='';
      	if($this->input->get('iSortCol_0')==0)
        	$order_by = 'budg_budgetid';
      	else if($this->input->get('iSortCol_0')==1)
        	$order_by = 'budg_budgetname';
      	$totalrecs='';
      	$limit = 10;
      	$offset = 0;
      	$get = $_GET;
	    foreach ($get as $key => $value) {
	        $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
	    }
        if(!empty($_GET["iDisplayLength"])){
           $limit = $_GET['iDisplayLength'];
           $offset = $_GET["iDisplayStart"];
        }
    //    if(!empty($get['sSearch_1'])){
    //         $this->db->where("lower(budg_code) like  '%".trim($get['sSearch_1'])."%'  ");
    //     }
        if(!empty($get['sSearch_2'])){
            $this->db->where("lower(budg_budgetname) like  '%".trim($get['sSearch_2'])."%'  ");
        }
        $this->db->select('bd.budg_budgetid,bd.budg_budgetname,budg_isactive,mt.maty_material');
		$this->db->from('budg_budgets bd');
		$this->db->join('maty_materialtype mt','mt.maty_materialtypeid=bd.budg_materialtypeid','LEFT');
        $this->db->order_by($order_by,$order);
        if($limit && $limit>0)
        {  
            $this->db->limit($limit);
        }
        if($offset)
        {
            $this->db->offset($offset);
        }
        if($srch){
        	$this->db->where($srch);
        }
       $nquery=$this->db->get();
       $num_row=$nquery->num_rows();
        // if(!empty($_GET['iDisplayLength'])) {
        //   $totalrecs = sizeof( $nquery);
        // }
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
	    //echo "<pre>";print_r($ndata);die;
	    return $ndata;
	}

public function check_exist_budgets_for_other($budgetname = false, $id = false){
		$data = array();
		if($budgetname)
		{
			$query = $this->db->get_where($this->table,array('budg_budgetname'=>$budgetname,'budg_budgetid !='=>$id));
		}
		else
		{
			$query = $this->db->get_where($this->table,array('budg_budgetname'=>$budgetname));
		}
		// echo $this->db->last_query();
		// die();
		if ($query->num_rows() > 0) 
		{
			$data=$query->row();	
			return $data;			
		}
		return false;
	}
}