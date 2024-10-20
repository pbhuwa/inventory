<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Units_mdl extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->table='unit_unit';
	}
	
	public $validate_settings_units = array(
array('field' => 'unit_unitname', 'label' => 'units Name', 'rules' => 'trim|required|xss_clean|callback_exists_unitname'),
array('field' => 'unit_isactive', 'label' => 'Is Active', 'rules' => 'trim|required|xss_clean'),
);
	
	public function units_save()
	{
		$postdata=$this->input->post();
		$id=$this->input->post('id');
		unset($postdata['id']);
		if($id)
		{
		$postdata['unit_modifydatead']=CURDATE_EN;
		$postdata['unit_modifydatebs']=CURDATE_NP;
		$postdata['unit_modifytime']=date('H:i:s');
		$postdata['unit_modifyip']='';
		$postdata['unit_modifyip']=$this->general->get_real_ipaddr();
		$postdata['unit_modifymac']=$this->general->get_Mac_Address();
		if(!empty($postdata))
		{
			$this->db->update($this->table,$postdata,array('unit_unitid'=>$id));
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
		$postdata['unit_postdatead']=CURDATE_EN;
		$postdata['unit_postdatebs']=CURDATE_NP;
		$postdata['unit_posttime']=date('H:i:s');
		$postdata['unit_postby']='';
		$postdata['unit_postip']=$this->general->get_real_ipaddr();
		$postdata['unit_postmac']=$this->general->get_Mac_Address();
// echo "<pre>";
	// print_r($postdata);
	// die();
	if(!empty($postdata))
	{
	$this->db->insert($this->table,$postdata);
	// echo $this->db->last_query();
	$insertid=$this->db->insert_id();
	// echo $insertid;
	// die();
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
	public function get_all_units($srchcol=false,$limit=false,$offset=false,$order=false,$order_by=false, $where_in = false)
	{
	$this->db->select('*');
	$this->db->from('unit_unit pc');
	
	if($srchcol)
	{
	$this->db->where($srchcol);
	}
	if($where_in){
	$this->db->where_in('unit_unitid',$where_in);
	}
	$query = $this->db->get();
	if ($query->num_rows() > 0) 
	{
	$data=$query->result();
	return $data;
	}
	return false;
	}
	public function remove_units()
	{
	$id=$this->input->post('id');
	if($id)
	{
	$this->db->delete($this->table,array('unit_unitid'=>$id));
	$rowaffected=$this->db->affected_rows();
	if($rowaffected)
	{
	return $rowaffected;
	}
	return false;
	}
	return false;
	}
	public function check_exist_unitname_for_other($unitname = false, $id = false){
	$data = array();
	if($unitname)
	{
	$this->db->where('unit_unitname',$unitname);
	}
	if($id)
	{
	$this->db->where('unit_unitid!=',$id);
	}
	$query = $this->db->get($this->table);
	// echo $this->db->last_query();
	// die();
	if ($query->num_rows() > 0) 
	{
	$data=$query->row();
	return $data;
	}
	return false;
	}

	
	public function get_all_units_list()
	{
		$get = $_GET;
 
      	foreach ($get as $key => $value) {
        	$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
      	}
     	if(!empty($get['sSearch_0'])){
            $this->db->where("unit_unitid like  '%".$get['sSearch_0']."%'  ");
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("unit_unitname like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("unit_postdatebs like  '%".$get['sSearch_2']."%'  ");
        }
        $resltrpt=$this->db->select("COUNT(*) as cnt")
  					->from('unit_unit')
  					->get()
  					->row();
	    //echo $this->db->last_query();die(); 
      	$totalfilteredrecs=$resltrpt->cnt; 

      	$order_by = 'unit_unitid';
      	$order = 'desc';
      	if($this->input->get('sSortDir_0'))
  		{
  				$order = $this->input->get('sSortDir_0');
  		}
  
      	$where='';
      	if($this->input->get('iSortCol_0')==0)
        	$order_by = 'unit_unitid';
      	else if($this->input->get('iSortCol_0')==1)
        	$order_by = 'unit_unitname';
      	else if($this->input->get('iSortCol_0')==2)
       		$order_by = 'unit_postdatebs';
       	
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
            $this->db->where("unit_unitid like  '%".$get['sSearch_0']."%'  ");
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("unit_unitname like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("unit_postdatebs like  '%".$get['sSearch_2']."%'  ");
        }
        $this->db->select('*');
		$this->db->from('unit_unit');
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