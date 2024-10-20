<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Amc_completed_mdl extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
		 $this->sess_usercode = $this->session->userdata(USER_GROUPCODE);
         $this->sess_dept = $this->session->userdata(USER_DEPT);
		
	}

	public $validate_settings_amc_completed = array(               
       // array('field' => 'pmco_results', 'label' => 'Results', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'amc_amccompleteddate', 'label' => 'PM Complete Date', 'rules' => 'trim|xss_clean|valid_date'),
    

       
        );
	
	
	public function save_amc_completed()
	{	
			//echo "<pre>"; print_r($this->input->post()); die;
		//echo DEFAULT_DATEPICKER; die;
		$amta_amctableid=$this->input->post('pmtaid');
		$equipid=$this->input->post('equipid');
		//$result=$this->input->post('pmco_results');
		$amc=$this->input->post('amta_amc');
		$amccontractorid=$this->input->post('amta_amccontractorid');
		//$comments=$this->input->post('pmco_comments');

			$amc_completeddate=$this->input->post('amc_amccompleteddate');
			if(DEFAULT_DATEPICKER=='NP')
	  		{
	  			$amc_completeddatebs=$amc_completeddate;

	  			$amc_completeddatead=$this->general->NepToEngDateConv($amc_completeddate);
	  			
	  		}
	  		else
	  		{
	  			$amc_completeddatebs=$this->general->EngToNepDateConv($amc_completeddate);
	  			$amc_completeddatead=$amc_completeddate;
	  		}

		
		$postdata['amta_isamccompleted']='1';
		$postdata['amta_amcdatead']=$amc_completeddatead;
		$postdata['amta_amcdatebs']=$amc_completeddatebs;
		$postdata['amta_completeposttime']=$this->general->get_currenttime();
		$postdata['amta_completemac']=$this->general->get_Mac_Address();
		$postdata['amta_completeip']=$this->general->get_real_ipaddr();
		//$postdata['amta_completeresult']=$result;
		//$postdata['amta_comments']=$comments;
		//$postdata['amta_completedby']=$this->session->userdata(USER_ID);
		$postdata['amta_completepostdatead']=CURDATE_EN;
		$postdata['amta_completepostdatebs']=CURDATE_NP;
		if(!empty($postdata))
		{
				$this->db->update('amta_amctable',$postdata,array('amta_amctableid'=>$amta_amctableid,'amta_equipid'=>$equipid));
				$rwaff=$this->db->affected_rows();
				if($rwaff)
				{
					return true;
				}
				return false;
		}
		return false;		
	}

	
	public function get_all_amc_completed_report($srchcol=false,$limit=false,$offset=false,$order=false,$order_by=false)
	{
		$fromdate = $this->input->post('frmDate');
        $todate = $this->input->post('toDate');
		$this->db->select('p.*, bm.bmin_equipmentkey, rsk.riva_risk, d.dept_depname');
		$this->db->from('amta_pmtable p');
		$this->db->join('bmin_bmeinventory bm', 'bm.bmin_equipid = p.amta_equipid');
		$this->db->join('riva_riskvalues rsk', 'rsk.riva_riskid = bm.bmin_riskid', "LEFT");
		$this->db->join('dept_department d', 'd.dept_depid  = bm.bmin_departmentid', "LEFT");
		if($fromdate &&  $todate){
	        if(DEFAULT_DATEPICKER=='NP')
	        {
	          $this->db->where('amta_pmdatebs >=', $fromdate);
	          $this->db->where('amta_pmdatebs <=', $todate);
	        }
	        else
	        {
	          $this->db->where('amta_pmdatead >=', $fromdate);
	          $this->db->where('amta_pmdatead <=', $todate);
	        }
	    }
        if($srchcol)
        {
         	$this->db->where($srchcol); 
        }
		$query = $this->db->get();
		//echo $this->db->last_query();die();
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();		
			return $data;		
		}		
		return false;
	}

    public function get_all_amc_completed($cond = false)
    {
     	$get = $_GET;
 
	  	foreach ($get as $key => $value) {
	        $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
	  	}
	    if(!empty($get['sSearch_0'])){
	            $this->db->where("pmco_pmcompletedid like  '%".$get['sSearch_0']."%'  ");
	        }
        if(!empty($get['sSearch_1'])){
            $this->db->where("pmco_department like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("dein_department like  '%".$get['sSearch_2']."%'  ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("dein_department like  '%".$get['sSearch_3']."%'  ");
        } 
        if(!empty($get['sSearch_4'])){
            $this->db->where("dein_department like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("dein_department like  '%".$get['sSearch_5']."%'  ");
        } 
        if(!empty($get['sSearch_6'])){
            $this->db->where("dein_department like  '%".$get['sSearch_6']."%'  ");
        }
   		$resltrpt=$this->db->select("COUNT(*) as cnt")
  					->from('pmco_pmcompleted')
  					->get()
  					->row();
      	// echo $this->db->last_query();
      	// die();
      	$totalfilteredrecs=$resltrpt->cnt;

      	$order_by = 'pmco_pmcompletedid';
      	$order = 'desc';
  
      	$where='';
      	if($this->input->get('iSortCol_0')==0)
        	$order_by = 'pmco_pmcompletedid';
      	else if($this->input->get('iSortCol_0')==1)
        	$order_by = 'pmco_department';
      	else if($this->input->get('iSortCol_0')==2)
        	$order_by = 'di.dein_department';
     	else if($this->input->get('iSortCol_0')==3)
       		$order_by = 'di.dein_department'; 
       	else if($this->input->get('iSortCol_0')==4)
       		$order_by = 'di.dein_department'; 
   		else if($this->input->get('iSortCol_0')==5)
      		$order_by = 'di.dein_department'; 
   		else if($this->input->get('iSortCol_0')==6)
        	$order_by = 'di.dein_department';
      
      	if($this->input->get('sSortDir_0')=='desc')
        	$order = 'desc';
      	else if($this->input->get('sSortDir_0')=='asc')
        	$order = 'asc';

      	$totalrecs='';
      	$limit = 15;
      	$offset = 0;

     	$get = $_GET;
 
      	foreach ($get as $key => $value) {
        	$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
      	}
      
	      	if(!empty($_GET["iDisplayLength"])){
	          $limit = $_GET['iDisplayLength'];
	          $offset = $_GET["iDisplayStart"];
	        }

	        if(!empty($get['sSearch_0'])){
	            $this->db->where("pmco_pmcompletedid like  '%".$get['sSearch_0']."%'  ");
	        }

	        if(!empty($get['sSearch_1'])){
	            $this->db->where("pmco_department like  '%".$get['sSearch_1']."%'  ");
	        }

	        if(!empty($get['sSearch_2'])){
	            $this->db->where("dein_department like  '%".$get['sSearch_2']."%'  ");
	        }
	        if(!empty($get['sSearch_3'])){
	            $this->db->where("dein_department like  '%".$get['sSearch_3']."%'  ");
	        } 
	        if(!empty($get['sSearch_4'])){
	            $this->db->where("dein_department like  '%".$get['sSearch_4']."%'  ");
	        }
	        if(!empty($get['sSearch_5'])){
	            $this->db->where("dein_department like  '%".$get['sSearch_5']."%'  ");
	        } 
	        if(!empty($get['sSearch_6'])){
	            $this->db->where("dein_department like  '%".$get['sSearch_6']."%'  ");
	        }

     		$this->db->select('*');
			$this->db->from('pmco_pmcompleted');

	        if($cond) {
	          	$this->db->where('pmco_postdatead =', date("Y/m/d"));
	        }
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
	       		//echo $this->db->last_query();die();
	        $num_row=$nquery->num_rows();
	        if(!empty($_GET['iDisplayLength'])) {
	          	$totalrecs = sizeof( $nquery);
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