<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home_mdl extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
    $this->sess_usercode = $this->session->userdata(USER_GROUPCODE);
    $this->sess_dept = $this->session->userdata(USER_DEPT);
	}
	
  // validate_repair_request
    public $validate_repair_request = array(               
        array('field' => 'rere_problem', 'label' => 'Description Problem', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'rere_expecteddays', 'label' => 'Expected Days', 'rules' => 'trim|required|xss_clean'),
        );
	public $validate_repair_request_ex = array(               
      array('field' => 'rere_action', 'label' => 'Action Taken', 'rules' => 'trim|required|xss_clean'),
       array('field' => 'rere_receivedby', 'label' => 'Received By', 'rules' => 'trim|required|xss_clean'),
        array('field' => 'rere_receivedate', 'label' => 'Receivedate', 'rules' => 'trim|valid_date|xss_clean'),
        );

	
    public function count_equipentlist($srch = array()) {
        $this->db->where($srch);
        $query = $this->db
                ->select('bmin_equipid')
                ->get('bmin_bmeinventory');
        return $query->num_rows();
    }

    public function count_equipentlist_by_dep($srch = array(), $dept_where_in=array()) {       
        $this->db->select("count('bmin_equipid') as total_inventory, count('bmin_equipid') as todays_inventory");
        $this->db->from('bmin_bmeinventory bm');
        $this->db->join('dept_department d','bm.bmin_departmentid = d.dept_depid','left');
        if($srch){
          $this->db->where($srch);
        }

        if($dept_where_in){
          $this->db->where_in('dept_depid',$dept_where_in);
        }
        
        $query = $this->db->get();
  
        return $query->result();
    }

    public function count_repairrequestlist_by_dep($srch = array(), $dept_where_in=array()) {       
        $this->db->select("count('rere_equid') as total_repairreq, count('rere_equid') as today_repairreq");
        $this->db->from('rere_repairrequests r');
        $this->db->join('bmin_bmeinventory bm','r.rere_equid=bm.bmin_equipid','LEFT');
        $this->db->join('dept_department di','di.dept_depid=bm.bmin_departmentid','LEFT');
        if($srch){
          $this->db->where($srch);
        }

        if($dept_where_in){
          $this->db->where_in('dept_depid',$dept_where_in);
        }
        
        $query = $this->db->get();
  
        return $query->result();
    }
   
    public function count_distributers($srch = array()) {
        $this->db->where($srch);
        $query = $this->db
                ->select('dist_distributorid')
                ->get('dist_distributors');
        return $query->num_rows();
    }
    public function count_manufactures($srch = array()) {
        $this->db->where($srch);
        $query = $this->db
                ->select('manu_manlistid')
                ->get('manu_manufacturers');
        return $query->num_rows();
    }
	
	public function count_service_tech($srch = array()) {
        $this->db->where($srch);
        $query = $this->db
                ->select('sete_techid')
                ->get('sete_servicetechs');
        return $query->num_rows();
    }

    public function get_repair_data($srchcol=false,$limit=false,$offset=false,$order_by=false,$order=false)
    {
      $this->db->select('ec.*, bm.*, um.usma_fullname, eql.eqli_description,di.dept_depname as dein_department,ri.riva_risk,ri.riva_risktype, ri.riva_year,ri.riva_riskcount,ri.riva_times, dis.dist_distributor,mf.manu_manlst,rd.rode_roomname,dam.dist_distributor as amc_contractor');
	    $this->db->from('eqco_equipmentcomment ec');
	    $this->db->join('bmin_bmeinventory bm','bm.bmin_equipid=ec.eqco_eqid','left');
	    $this->db->join('eqli_equipmentlist eql','eql.eqli_equipmentlistid=bm.bmin_descriptionid','LEFT');
      $this->db->join('dept_department di','di.dept_depid=bm.bmin_departmentid','LEFT');
      $this->db->join('riva_riskvalues ri', 'ri.riva_riskid = bm.bmin_riskid', 'LEFT');
      $this->db->join('dist_distributors dis', 'dis.dist_distributorid = bm.bmin_distributorid', 'LEFT');
      $this->db->join('manu_manufacturers mf', 'mf.manu_manlistid = bm.bmin_manufacturerid', 'LEFT');
      $this->db->join('rode_roomdepartment rd', 'rd.rode_roomdepartmentid = bm.bmin_roomid', 'LEFT');
      $this->db->join('dist_distributors dam', 'dam.dist_distributorid = bm.bmin_amcontractorid', 'LEFT'); 
      $this->db->join('usma_usermain um','um.usma_userid=ec.eqco_postby','left');

	    $this->db->order_by($order_by,$order);
      if($srchcol)
      {
         $this->db->where($srchcol); 
      }

     $qry=$this->db->get();
     // echo $this->db->last_query();die();
      
     if($qry->num_rows()>0)
     {
      return $qry->result();
     }
     return false;
  }

    public function get_repair_data_assets($srchcol=false,$limit=false,$offset=false,$order_by=false,$order=false)
    {
      $this->db->select('ec.*, um.usma_fullname,itli_itemname,asen_assetcode,asen_modelno,
                        asen_serialno, di.dept_depname as dein_department, asen_brand, dis.dist_distributor,mf.manu_manlst');
      $this->db->from('eqco_equipmentcomment ec');
      $this->db->join('asen_assetentry aet','aet.asen_asenid=ec.eqco_eqid','left');
      $this->db->join('eqas_equipmentassign ea','ea.eqas_equipid=ec.eqco_eqid','LEFT');
      $this->db->join('dept_department di','di.dept_depid=ea.eqas_equipdepid','LEFT');
      $this->db->join('itli_itemslist il', 'il.itli_itemlistid=aet.asen_description', 'LEFT');
      $this->db->join('dist_distributors dis', 'dis.dist_distributorid = aet.asen_distributor', 'LEFT');
      $this->db->join('manu_manufacturers mf', 'mf.manu_manlistid = aet.asen_manufacture', 'LEFT');
       
      $this->db->join('usma_usermain um','um.usma_userid=ec.eqco_postby','left');
      $this->db->where('eqco_orgid = 2');
        $this->db->order_by($order_by,$order);
      if($srchcol)
      {
         $this->db->where($srchcol); 
      }

     $qry=$this->db->get();
     // echo $this->db->last_query();die();
      
     if($qry->num_rows()>0)
     {
      return $qry->result();
     }
     return false;
  }

  public function get_all_repairinformation()
	{
		$get = $_GET;
      	foreach ($get as $key => $value) {
        	$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
      	}

      	if(!empty($get['sSearch_1'])){
            $this->db->where("bmin_equipmentkey like  '%".$get['sSearch_1']."%'  ");
        }

      	if(!empty($get['sSearch_2'])){
            $this->db->where("bmin_comments like  '%".$get['sSearch_2']."%'  ");
        }

        if(!empty($get['sSearch_3'])){
            $this->db->where("di.dept_depname like  '%".$get['sSearch_3']."%'  ");
        }

        if(!empty($get['sSearch_4'])){
            $this->db->where("eqco_comment like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("usma_fullname like  '%".$get['sSearch_5']."%'  ");
        }


         if(($this->sess_usercode != 'SA') && ($this->sess_usercode != 'AD')){
 
          $new_sess_dept = explode(',',$this->sess_dept);
          $this->db->where_in('dept_depid',$new_sess_dept);
        }

         
        $resltrpt=$this->db->select("COUNT(*) as cnt")
            ->from('eqco_equipmentcomment ec')
            ->join('bmin_bmeinventory bm','bm.bmin_equipid=ec.eqco_eqid','left')
             ->join('dept_department di','di.dept_depid=bm.bmin_departmentid','LEFT')
            ->join('usma_usermain um','um.usma_userid=ec.eqco_postby','left')
            // ->where('eqco_comment_status = 0')
            ->get()
            ->row();
            //echo $this->db->last_query();die();
      	$totalfilteredrecs=$resltrpt->cnt; 

      	$order_by = 'eqco_equipmentcommentid';
      	$order = 'desc';
  
      	$where='';
      	if($this->input->get('iSortCol_0')==1)
        	$order_by = 'bmin_equipmentkey';
      	else if($this->input->get('iSortCol_0')==2)
        	$order_by = 'bmin_comments';
      	else if($this->input->get('iSortCol_0')==3)
       		$order_by = 'dein_department';
       	else if($this->input->get('iSortCol_0')==4)
      	 	$order_by = 'eqco_comment';
      	else if($this->input->get('iSortCol_0')==5)
      	 	$order_by = 'usma_fullname';
      	
      	$totalrecs='';
      	$limit = 10;
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
            $this->db->where("bmin_equipmentkey like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("bmin_comments like  '%".$get['sSearch_2']."%'  ");
        }

        if(!empty($get['sSearch_3'])){
            $this->db->where("di.dept_depname like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("eqco_comment like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("usma_fullname like  '%".$get['sSearch_4']."%'  ");
        }

        $this->db->select("ec.*,um.usma_fullname,bm.bmin_comments, bm.bmin_equipmentkey, di.dept_depname as dein_department,eql.eqli_description");
	    $this->db->from('eqco_equipmentcomment ec');
	    $this->db->join('bmin_bmeinventory bm','bm.bmin_equipid=ec.eqco_eqid','left');
      $this->db->join('eqli_equipmentlist eql','eql.eqli_equipmentlistid=bm.bmin_descriptionid','LEFT');
	    $this->db->join('dept_department di','di.dept_depid=bm.bmin_departmentid','LEFT');
	    $this->db->join('usma_usermain um','um.usma_userid=ec.eqco_postby','left');
	    // $this->db->where('eqco_comment_status = 0');
        $this->db->order_by($order_by,$order);
        if($limit && $limit>0)
        {  
            $this->db->limit($limit);
        }
        if($offset)
        {
            $this->db->offset($offset);
        }

        if(($this->sess_usercode != 'SA') && ($this->sess_usercode != 'AD')){
 
          $new_sess_dept = explode(',',$this->sess_dept);
          $this->db->where_in('dept_depid',$new_sess_dept);
        }
      
       $nquery=$this->db->get();

       // echo $this->db->last_query();
       // die();
       $num_row=$nquery->num_rows();
        if (!empty($_GET['iDisplayLength']) &&  !empty($nquery) && is_array($nquery) && count($nquery) > 0 ) {
            $totalrecs = count($nquery);
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

  public function get_all_repairinfo_assets()
  {
    $get = $_GET;
        foreach ($get as $key => $value) {
          $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("asen_assetcode like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("itli_itemname like  '%".$get['sSearch_2']."%'  ");
        }

        if(!empty($get['sSearch_3'])){
            $this->db->where("dept_depname like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("eqco_comment like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("usma_fullname like  '%".$get['sSearch_5']."%'  ");
        }

           if(($this->sess_usercode != 'SA') && ($this->sess_usercode != 'AD')){
 
          $new_sess_dept = explode(',',$this->sess_dept);
          $this->db->where_in('dept_depid',$new_sess_dept);
        }
         
        $resltrpt=$this->db->select("COUNT(*) as cnt")
            ->from('eqco_equipmentcomment ec')
            ->join('asen_assetentry aet','aet.asen_asenid=ec.eqco_eqid','left')
             ->join('itli_itemslist il','il.itli_itemlistid=aet.asen_description','LEFT')
             ->join('eqas_equipmentassign ea','ea.eqas_equipid=ec.eqco_eqid','LEFT')
             ->join('dept_department dp','dp.dept_depid=ea.eqas_equipdepid','LEFT')
            ->join('usma_usermain um','um.usma_userid=ec.eqco_postby','left')
            ->where('eqco_comment_status = 0')
            ->where('eqco_orgid = 2')
            
            ->get()
            ->row();

            //echo $this->db->last_query();die();
        $totalfilteredrecs=$resltrpt->cnt; 
        //echo $totalfilteredrecs; die;
        $order_by = 'eqco_equipmentcommentid';
        $order = 'desc';
  
        $where='';
        if($this->input->get('iSortCol_0')==1)
          $order_by = 'asen_assetcode';
        else if($this->input->get('iSortCol_0')==2)
          $order_by = 'itli_itemname';
        else if($this->input->get('iSortCol_0')==3)
          $order_by = 'dein_department';
        else if($this->input->get('iSortCol_0')==4)
          $order_by = 'eqco_comment';
        else if($this->input->get('iSortCol_0')==5)
          $order_by = 'usma_fullname';
        else if($this->input->get('iSortCol_0')==6)
          $order_by = 'eqco_postdatead';
        
        $totalrecs='';
        $limit = 10;
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
            $this->db->where("asen_assetcode like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("itli_itemname like  '%".$get['sSearch_2']."%'  ");
        }

        if(!empty($get['sSearch_3'])){
            $this->db->where("dept_depname like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
            $this->db->where("eqco_comment like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
            $this->db->where("usma_fullname like  '%".$get['sSearch_5']."%'  ");
        }
        
        $this->db->select("ec.*,asen_assetcode as bmin_equipmentkey,itli_itemname as eqli_description,dept_depname as dein_department,usma_fullname");
        $this->db->from('eqco_equipmentcomment ec');
        $this->db->join('asen_assetentry aet','aet.asen_asenid=ec.eqco_eqid','left');
        $this->db->join('itli_itemslist il','il.itli_itemlistid=aet.asen_description','LEFT');
        $this->db->join('eqas_equipmentassign ea','ea.eqas_equipid=ec.eqco_eqid','LEFT');
        $this->db->join('dept_department dp','dp.dept_depid=ea.eqas_equipdepid','LEFT');
        $this->db->join('usma_usermain um','um.usma_userid=ec.eqco_postby','left');
        $this->db->where('eqco_comment_status = 0');
        $this->db->where('eqco_orgid = 2');
            
        // $this->db->group_by('eqco_equipmentcommentid');
        $this->db->order_by($order_by,$order);
        if($limit && $limit>0)
        {  
            $this->db->limit($limit);
        }
        if($offset)
        {
            $this->db->offset($offset);
        }

           if(($this->sess_usercode != 'SA') && ($this->sess_usercode != 'AD')){
 
          $new_sess_dept = explode(',',$this->sess_dept);
          $this->db->where_in('dept_depid',$new_sess_dept);
        }
      
       $nquery=$this->db->get();
       $num_row=$nquery->num_rows();
      if (!empty($_GET['iDisplayLength']) &&  !empty($nquery) && is_array($nquery) && count($nquery) > 0 ) {
            $totalrecs = count($nquery);
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

	public function rere_information_update()
	{   
      $problemtype=$this->input->post('rere_problemtype');
    // die();
		  $postdata = $this->input->post();
		  $rere_id = $this->input->post('rere_repairrequestid');
      $parts_name = $this->input->post('parts_name');
      $qty = $this->input->post('qty');
      $rate = $this->input->post('rate');
      $total = $this->input->post('total');
      if(!empty($rere_id)){
        $status = 1; //repair is completed ??
      }else{
        $status = 4; //repair is in progress and only completed after verified by dep
      }
      $id = $this->input->post('id');
      $equipid = $this->input->post('equipid');
      
      unset($postdata['id']);
      unset($postdata['equipid']);
      unset($postdata['dispatchdate']);
      unset($postdata['parts_name']);
      unset($postdata['qty']);
      unset($postdata['rate']);
      unset($postdata['total']);

      
      // echo "<pre>";
      // print_r($postdata);
      // die();

      $userid=$this->session->userdata(USER_ID);
      $ipaddress=$this->general->get_real_ipaddr();
      $mac=$this->general->get_Mac_Address();
      $partsArray=array();


    if($rere_id){
      $rere_techcost = $this->input->post('rere_techcost');
      $rere_othercost = $this->input->post('rere_othercost');
      $rere_techcost = $this->input->post('rere_techcost');
      $rere_receivedate=$this->input->post('rere_receivedate');
      if($rere_receivedate)
      {
        if(DEFAULT_DATEPICKER=='NP')
            {
              $postdata['rere_receivedatebs']=$this->input->post('rere_receivedate'); 
              $postdata['rere_receivedatead']= $this->general->NepToEngDateConv($this->input->post('rere_receivedate'));
            }
            else
            {
              $postdata['rere_receivedatead']=$this->input->post('rere_receivedate'); 
              $postdata['rere_receivedatebs']=$this->general->EngToNepDateConv($this->input->post('rere_receivedate'));
            }
      }
      unset($postdata['rere_receivedate']);
      // print_r($this->input->post());die;
     
     if($this->input->post('rere_ispartsused')=='Y')
     {
      if(!empty($parts_name)){
          foreach ($parts_name as $key => $value) {
              $partsArray[]= array(
                  'eqpa_partsname'=>$parts_name[$key],
                  'eqpa_qty'=>$qty[$key],
                  'eqpa_rate'=>$rate[$key],
                  'eqpa_total'=>$total[$key],
                  'eqpa_postmac'=> $mac,
                  'eqpa_postip'=>$ipaddress,
                  'eqpa_postby'=>$userid,
                  'eqpa_postdatebs'=>CURDATE_NP,
                  'eqpa_postdatead'=>CURDATE_EN,
                  'eqpa_equipid'=>$this->input->post('bmin_equipid'),
                  'eqpa_repairid'=>$this->input->post('rere_repairrequestid'),
              ); 
          }
        }
      }
      $this->db->trans_begin();
      if(!empty($partsArray))
      {
         $this->db->insert_batch('eqpa_equipparts', $partsArray);
      }
     
      $postdata['rere_status'] = 1;
      $postdata['rere_isrepair'] = 'Y';
      $postdata['rere_repairdatead'] = CURDATE_EN;
      $postdata['rere_repairdatebs'] = CURDATE_NP;
      $postdata['rere_modifydatead'] = CURDATE_EN;
      $postdata['rere_modifydatebs'] = CURDATE_NP;
      $postdata['rere_modifytime'] = $this->general->get_currenttime();
      $postdata['rere_modifymac'] = $mac;
      $postdata['rere_modifyip'] = $ipaddress;
      $postdata['rere_modifyby'] = $this->session->userdata(USER_ID);
      // echo "<pre>";
      // print_r($postdata);
      // die();
      unset($postdata['bmin_equipid']);
      if(!empty($postdata)){
          $this->db->update('rere_repairrequests',$postdata,array('rere_repairrequestid'=>$rere_id));
        $repair_data = $this->db->select('rere_commentid')->from('rere_repairrequests')->where(array('rere_repairrequestid'=>$rere_id))->get()->row();    
        if ($repair_data) {
          $this->db->where("eqco_equipmentcommentid", $repair_data->rere_commentid);
          $this->db->set("eqco_comment_status", $status);
          $this->db->update("eqco_equipmentcomment"); 
        } 
      }
      $this->db->trans_complete();

     if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                throw new Exception("Error Occurred");
        } else {
              $this->db->trans_commit();
              return true;
            }
  }
  else{

      if($problemtype=='Ex')
      {
            if(DEFAULT_DATEPICKER=='NP')
            {
              $postdata['rere_dispatchdatebs']=$this->input->post('dispatchdate'); 
              $postdata['rere_dispatchdatead']= $this->general->NepToEngDateConv($this->input->post('dispatchdate'));
            }
            else
            {
              $postdata['rere_dispatchdatead']=$this->input->post('dispatchdate'); 
              $postdata['rere_dispatchdatebs']=$this->general->EngToNepDateConv($this->input->post('dispatchdate'));
            }
           
      }

    		$postdata['rere_postdatead']=CURDATE_EN;
    		$postdata['rere_postdatebs']=CURDATE_NP;
    		$postdata['rere_posttime']=$this->general->get_currenttime();
    		$postdata['rere_postby']=$this->session->userdata(USER_ID);
    		$postdata['rere_postip']=$this->general->get_real_ipaddr();
    		$postdata['rere_postmac']=$this->general->get_Mac_Address();
    		$postdata['rere_commentid']= $id;
    		$postdata['rere_equid'] = $equipid;
        $postdata['rere_orgid'] = $this->session->userdata(ORG_ID);
        
    		// print_r($postdata); die();
    		$this->db->trans_begin();
    			if(!empty($postdata)){	
    				//echo "<pre>"; print_r($postdata); die;
    				$this->db->insert('rere_repairrequests', $postdata);
    				$insertid=$this->db->insert_id();
    			}

    			$this->db->where("eqco_equipmentcommentid", $id);
          $this->db->set("eqco_comment_status", $status);
          $this->db->update("eqco_equipmentcomment");	

         if($this->input->post('rere_ispartsused')=='Y')
         {
          if(!empty($parts_name)){
          foreach ($parts_name as $key => $value) {
              $partsArray[]= array(
                  'eqpa_partsname'=>$parts_name[$key],
                  'eqpa_qty'=>$qty[$key],
                  'eqpa_rate'=>$rate[$key],
                  'eqpa_total'=>$total[$key],
                  'eqpa_postmac'=> $mac,
                  'eqpa_postip'=>$ipaddress,
                  'eqpa_postby'=>$userid,
                  'eqpa_postdatebs'=>CURDATE_NP,
                  'eqpa_postdatead'=>CURDATE_EN,
                  'eqpa_equipid'=>$this->input->post('equipid'),
                  'eqpa_repairid'=>$insertid,
              ); 
          }
        }
      }

      if(!empty($partsArray))
      {
         $this->db->insert_batch('eqpa_equipparts', $partsArray);
      }

    		$this->db->trans_complete();

    		if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                throw new Exception("Error Occurred");
            } else {
                $this->db->trans_commit();
                return true;
            }
      }

	}



	public function get_all_pm_alert()
	{

		 $add_date=  date('Y/m/d',strtotime(CURDATE_EN . "+15 days"));
				$get = $_GET;
 
      	foreach ($get as $key => $value) {
        	$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
      	}
     	

      	if(!empty($get['sSearch_0'])){
            $this->db->where("bmin_equipid like  '%".$get['sSearch_0']."%' ");
        }
        if(!empty($get['sSearch_1'])){
	          $this->db->where("bmin_equipmentkey like  '%".$get['sSearch_1']."%' ");
	    }

	    if(!empty($get['sSearch_2'])){
	          $this->db->where("pm.pmta_pmdatead like  '%".$get['sSearch_2']."%' ");
	    }

	    if(!empty($get['sSearch_3'])){
	          $this->db->where("pm.pmta_pmdatebs like  '%".$get['sSearch_3']."%'  ");
	    }

	    if(!empty($get['sSearch_4'])){
	          $this->db->where("di.dein_department like  '%".$get['sSearch_4']."%'  ");
	    }
	    if(!empty($get['sSearch_5'])){
	          $this->db->where("rv.riva_risk like  '%".$get['sSearch_5']."%'  ");
	    }

         if(($this->sess_usercode != 'SA') && ($this->sess_usercode != 'AD')){
 
          $new_sess_dept = explode(',',$this->sess_dept);
          $this->db->where_in('dept_depid',$new_sess_dept);
        }

        $this->db->where('pmta_pmdatead >=', CURDATE_EN);
        $this->db->where('pmta_pmdatead <=', $add_date);

        $this->db->select("COUNT(*) as cnt");
        $this->db->from('pmta_pmtable pm');
	      $this->db->join('bmin_bmeinventory bm','bm.bmin_equipid=pm.pmta_pmtableid','left');
	     $this->db->join('dept_department di','di.dept_depid=bm.bmin_departmentid','LEFT');
	     $this->db->join('riva_riskvalues rv','rv.riva_riskid=bm.bmin_riskid','left');
	    $resltrpt=$this->db->get();
        $rslt=$resltrpt->row();

        $totalfilteredrecs=$rslt->cnt;


      	$order_by = 'pmta_pmdatead';
      	$order = 'asc';
  
      	$where='';
      	if($this->input->get('iSortCol_0')==0)
        	$order_by = 'pmta_equipid';
        else if($this->input->get('iSortCol_0')==1)
        	$order_by = 'bmin_equipmentkey';
      	else if($this->input->get('iSortCol_0')==2)
        	$order_by = 'pmta_pmdatead';
      	else if($this->input->get('iSortCol_0')==3)
        	$order_by = 'pmta_pmdatebs';
      	else if($this->input->get('iSortCol_0')==4)
       		$order_by = 'dein_department';
       	else if($this->input->get('iSortCol_0')==5)
      	 	$order_by = 'riva_risk';
      	
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
            $this->db->where("bmin_equipid like  '%".$get['sSearch_0']."%' ");
        }
        if(!empty($get['sSearch_1'])){
          $this->db->where("bmin_equipmentkey like  '%".$get['sSearch_1']."%' ");
        }

        if(!empty($get['sSearch_2'])){
          $this->db->where("pm.pmta_pmdatead like  '%".$get['sSearch_2']."%' ");
        }

        if(!empty($get['sSearch_3'])){
          $this->db->where("pm.pmta_pmdatebs like  '%".$get['sSearch_3']."%'  ");
        }

        if(!empty($get['sSearch_4'])){
          $this->db->where("di.dein_department like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
          $this->db->where("rv.riva_risk like  '%".$get['sSearch_5']."%'  ");
        }

        $this->db->where('pmta_pmdatead >=', CURDATE_EN);
        $this->db->where('pmta_pmdatead <=', $add_date);
        $selectsub="  (SELECT   count('*') AS pmcount
                            FROM   xw_pmta_pmtable pm
                           WHERE   pm.pmta_equipid = bm.bmin_equipid) as pmcount ";
        // $selectsub='';

        $this->db->select("pm.*,bm.*,  $selectsub, rv.riva_risk, di.dept_depname as dein_department");
	    $this->db->from('pmta_pmtable pm');
	    $this->db->join('bmin_bmeinventory bm','bm.bmin_equipid=pm.pmta_equipid','left');
	    $this->db->join('dept_department di','di.dept_depid=bm.bmin_departmentid','LEFT');
	    $this->db->join('riva_riskvalues rv','rv.riva_riskid=bm.bmin_riskid','left');
	  
        $this->db->order_by($order_by,$order);
        if($limit && $limit>0)
        {  
            $this->db->limit($limit);
        }
        if($offset)
        {
            $this->db->offset($offset);
        }

           if(($this->sess_usercode != 'SA') && ($this->sess_usercode != 'AD')){
 
          $new_sess_dept = explode(',',$this->sess_dept);
          $this->db->where_in('dept_depid',$new_sess_dept);
        }
      
        $nquery=$this->db->get();
        $num_row=$nquery->num_rows();
        if (!empty($_GET['iDisplayLength']) &&  !empty($nquery) && is_array($nquery) && count($nquery) > 0 ) {
            $totalrecs = count($nquery);
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
  public function get_all_contractor($org_id=false)
  {

    $add_date=  date('Y/m/d',strtotime(CURDATE_EN . "+15 days"));
    $get = $_GET;
 
        foreach ($get as $key => $value) {
          $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }
      
      if(!empty($get['sSearch_0'])){
            $this->db->where("coin_contractinformationid like  '%".$get['sSearch_0']."%'  ");
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("coty_contracttype like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("dist_distributor like  '%".$get['sSearch_2']."%'  ");
        }

        if(!empty($get['sSearch_3'])){
            $this->db->where("coin_contracttitle like  '%".$get['sSearch_3']."%'  ");
        }
        
        if(!empty($get['sSearch_4'])){
            $this->db->where("coin_contractstartdatead like  '%".$get['sSearch_4']."%'  ");
        }
        
        if(!empty($get['sSearch_5'])){
            $this->db->where("coin_contractstartdatebs like  '%".$get['sSearch_5']."%'  ");
        }
        
        if(!empty($get['sSearch_6'])){
            $this->db->where("coin_contractvalue like  '%".$get['sSearch_6']."%'  ");
        }
         $this->db->where('coin_contractstartdatead >=', CURDATE_EN);
        $this->db->where('coin_contractstartdatead <=', $add_date);
         if($org_id){
          $this->db->where('coin_orgid',$org_id);
         }
        $resltrpt=$this->db->select("COUNT(*) as cnt")
                ->from('coin_contractinformation c')
                ->join('coty_contracttype ct', 'ct.coty_contracttypeid = c.coin_contracttypeid','LEFT')
                ->join('dist_distributors d','d.dist_distributorid = c.coin_distributorid','LEFT')
                ->get()
                ->row();
        //$resltrpt=$this->db->query("SELECT COUNT(*) as cnt FROM xw_pudo_purchdonate  ")->row();
      //echo $this->db->last_query();die(); 
        $totalfilteredrecs=$resltrpt->cnt; 

        $order_by = 'coin_contractinformationid';
        $order = 'desc';
        if($this->input->get('sSortDir_0'))
      {
          $order = $this->input->get('sSortDir_0');
      }
  
        $where='';
        if($this->input->get('iSortCol_0')==0)
          $order_by = 'coin_contractinformationid';
        else if($this->input->get('iSortCol_0')==1)
          $order_by = 'coty_contracttype';
        else if($this->input->get('iSortCol_0')==2)
          $order_by = 'dist_distributor';
        else if($this->input->get('iSortCol_0')==3)
          $order_by = 'coin_contracttitle';
        else if($this->input->get('iSortCol_0')==4)
          $order_by = 'coin_contractstartdatead';
        else if($this->input->get('iSortCol_0')==5)
          $order_by = 'coin_contractenddatead';
        else if($this->input->get('iSortCol_0')==6)
          $order_by = 'coin_contractvalue';
        
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
            $this->db->where("coin_contractinformationid like  '%".$get['sSearch_0']."%'  ");
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("coty_contracttype like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("dist_distributor like  '%".$get['sSearch_2']."%'  ");
        }

        if(!empty($get['sSearch_3'])){
            $this->db->where("coin_contracttitle like  '%".$get['sSearch_3']."%'  ");
        }

        if(!empty($get['sSearch_4'])){
            $this->db->where("coin_contractstartdatead like  '%".$get['sSearch_4']."%'  ");
        }

        if(!empty($get['sSearch_5'])){
            $this->db->where("coin_contractenddatead like  '%".$get['sSearch_5']."%'  ");
        }

        if(!empty($get['sSearch_6'])){
            $this->db->where("coin_contractvalue like  '%".$get['sSearch_6']."%'  ");
        }
       $this->db->where('coin_contractstartdatead >=', CURDATE_EN);
        $this->db->where('coin_contractstartdatead <=', $add_date);
      
       
        $this->db->select('c.*, ct.coty_contracttype, d.dist_distributor');
    $this->db->from('coin_contractinformation c');
    $this->db->join('coty_contracttype ct', 'ct.coty_contracttypeid = c.coin_contracttypeid','LEFT');
      
        $this->db->join('dist_distributors d','d.dist_distributorid = c.coin_distributorid','LEFT');
        if($org_id){
          $this->db->where('coin_orgid',$org_id);
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
       $num_row=$nquery->num_rows();
        if (!empty($_GET['iDisplayLength']) &&  !empty($nquery) && is_array($nquery) && count($nquery) > 0 ) {
            $totalrecs = count($nquery);
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




	public function checkBeforeApproval($user_id = false, $user_dept = false){
		try{
			$this->db->select('usma_departmentid');
			$this->db->from('usma_usermain');
			$this->db->where('usma_userid',$user_id);
			$query = $this->db->get()->row();
			if($query){
				return $query;	
			}
			return false;
		}catch(Exception $e){
			throw $e;
		}
	}

	public function approveRepairRequest($commentid = false){
		try{
            if(empty($commentid)){
                throw new Exception("Error Processing Request", 1);
            }
            $where = array(
                  'eqco_equipmentcommentid'=>$commentid
                  );

            $data = array(
                'eqco_comment_status'=>'1',
                'eqco_approveddatead'=>CURDATE_EN,
                'eqco_approveddatebs'=>CURDATE_NP,
                'eqco_approvedtime'=>$this->general->get_currenttime(),
                'eqco_approvedby'=>$this->session->userdata(USER_ID),
                'eqco_approvedip'=>$this->general->get_real_ipaddr(),
                'eqco_approvedmac'=>$this->general->get_Mac_Address()
            );

            $this->db->where($where);
            if($this->db->update('eqco_equipmentcomment', $data))
                return true;
            else 
                throw new Exception("Error Processing Request", 1);
        }catch(Exception $e){
            throw $e;
        }
	}
  public function get_weekly_pm()
  {
    $strdate = $this->dateAddCase();


    $befor     = strtotime($strdate);


    $befordate = date("Y/m/d", $befor);
  
    $indate = new DateTime($befordate);
    $i = 1;
    while($i <= 7):
      $indate->add(new DateInterval('P1D'));
      $genDate = $indate->format('Y/m/d');
      $date[] = $genDate;
     
      $i++;
    endwhile;
   

  $sql = " SELECT
      IFNULL(
        Sum(
          CASE pmta_pmdatead
          WHEN '".$date[0]."' THEN
            not_comp
          END
        ),
        0
      ) AS not_comp1,
      IFNULL(
        Sum(
          CASE pmta_pmdatead
          WHEN '".$date[0]."' THEN
            comp
          END
        ),
        0
      ) AS comp1,
      IFNULL(
        Sum(
          CASE pmta_pmdatead
          WHEN '".$date[1]."' THEN
            not_comp
          END
        ),
        0
      ) AS not_comp2,
      IFNULL(
        Sum(
          CASE pmta_pmdatead
          WHEN '".$date[1]."' THEN
            comp
          END
        ),
        0
      ) AS comp2,
      IFNULL(
        Sum(
          CASE pmta_pmdatead
          WHEN '".$date[2]."' THEN
            not_comp
          END
        ),
        0
      ) AS not_comp3,
      IFNULL(
        Sum(
          CASE pmta_pmdatead
          WHEN '".$date[2]."' THEN
            comp
          END
        ),
        0
      ) AS comp3,
      IFNULL(
        Sum(
          CASE pmta_pmdatead
          WHEN '".$date[3]."' THEN
            not_comp
          END
        ),
        0
      ) AS not_comp4,
      IFNULL(
        Sum(
          CASE pmta_pmdatead
          WHEN '".$date[3]."' THEN
            comp
          END
        ),
        0
      ) AS comp4,
      IFNULL(
        Sum(
          CASE pmta_pmdatead
          WHEN '".$date[4]."' THEN
            not_comp
          END
        ),
        0
      ) AS not_comp5,
      IFNULL(
        Sum(
          CASE pmta_pmdatead
          WHEN '".$date[4]."' THEN
            comp
          END
        ),
        0
      ) AS comp5,
      IFNULL(
        Sum(
          CASE pmta_pmdatead
          WHEN '".$date[5]."' THEN
            not_comp
          END
        ),
        0
      ) AS not_comp6,
      IFNULL(
        Sum(
          CASE pmta_pmdatead
          WHEN '".$date[5]."' THEN
            comp
          END
        ),
        0
      ) AS comp6,
      IFNULL(
        Sum(
          CASE pmta_pmdatead
          WHEN '".$date[6]."' THEN
            not_comp
          END
        ),
        0
      ) AS not_comp7,
      IFNULL(
        Sum(
          CASE pmta_pmdatead
          WHEN '".$date[6]."' THEN
            comp
          END
        ),
        0
      ) AS comp7
    FROM
      xw_vwpmdata
    WHERE
      pmta_pmdatead >= '".$date[0]."'
    AND pmta_pmdatead <= '".$date[6]."' ";
      $query = $this->db->query($sql);
      // echo $this->db->last_query();
      // die();
      return $query->result();
  }


  public function get_last5_pm()
  {

    $week      = $this->weekFormate();
    // echo "<pre>";
    // print_r($week);
    // die();

    $firstWeek = $this->getFSundayOfFiveWeek();
    $lastWeek  =  $this->getCurSundayDate();

    // echo $firstWeek;
    //     echo $lastWeek;

    // die();


    $sql =" SELECT
      IFNULL(
        Sum(
          CASE week
          WHEN '".$week[0]."' THEN
            not_comp
          END
        ),
        0
      ) AS not_comp1,
      IFNULL(
        Sum(
          CASE week
          WHEN '".$week[0]."' THEN
            comp
          END
        ),
        0
      ) AS comp1,
      IFNULL(
        Sum(
          CASE week
          WHEN '".$week[1]."' THEN
            not_comp
          END
        ),
        0
      ) AS not_comp2,
      IFNULL(
        Sum(
          CASE week
          WHEN '".$week[1]."' THEN
            comp
          END
        ),
        0
      ) AS comp2,
      IFNULL(
        Sum(
          CASE week
          WHEN '".$week[2]."' THEN
            not_comp
          END
        ),
        0
      ) AS not_comp3,
      IFNULL(
        Sum(
          CASE week
          WHEN '".$week[2]."' THEN
            comp
          END
        ),
        0
      ) AS comp3,
      IFNULL(
        Sum(
          CASE week
          WHEN '".$week[3]."' THEN
            not_comp
          END
        ),
        0
      ) AS not_comp4,
      IFNULL(
        Sum(
          CASE week
          WHEN '".$week[3]."' THEN
            comp
          END
        ),
        0
      ) AS comp4,
      IFNULL(
        Sum(
          CASE week
          WHEN '".$week[4]."' THEN
            not_comp
          END
        ),
        0
      ) AS not_comp5,
      IFNULL(
        Sum(
          CASE week
          WHEN '".$week[4]."' THEN
            comp
          END
        ),
        0
      ) AS comp5
      
    FROM
      xw_vwpmdata
    WHERE
      pmta_pmdatead >= '".$firstWeek."'
    AND pmta_pmdatead <= '".$lastWeek."' "; 
        
    $query= $this->db->query($sql);
    // echo $this->db->last_query();
    // exit;
    return $query->result();
  }


 public function get_year_pm()
  {
    $curYearF = date('Y').'/01/01';
  
    $curYearL = date('Y').'/12/31';
   
    $strmonth = $this->dateAddCaseMonth();
    $befor    = strtotime($strmonth);
    $befordate= date("Y/m/d", $befor);
    $i = 1;
    $indate = new DateTime($befordate);

    while($i <= 12):
    $indate->add(new DateInterval('P1M'));
    $genDate = $indate->format('Y/m/d');
    $strdate = strtotime($genDate);
    $day     = strtoupper(date("F", $strdate));
    $month[] = $i;
    $i++;
    endwhile;
    // echo "<pre>";
    // print_r($month);
    // die();
    $sql = "SELECT 
    IFNULL(Sum(CASE month WHEN '".$month[0]."' THEN not_comp END),0) AS not_comp1,
    IFNULL(Sum(CASE month WHEN '".$month[0]."' THEN comp END),0) AS comp1,      
    IFNULL(Sum(CASE month WHEN '".$month[1]."' THEN not_comp END ),0) AS not_comp2,     
    IFNULL(Sum(CASE month WHEN '".$month[1]."' THEN comp END ),0 ) AS comp2,
    IFNULL(Sum(CASE month WHEN '".$month[2]."' THEN not_comp END ),0) AS not_comp3,
    IFNULL(Sum(CASE month WHEN '".$month[2]."' THEN comp END), 0) AS comp3,
    IFNULL(Sum(CASE month WHEN '".$month[3]."' THEN not_comp END ),0) AS not_comp4,
    IFNULL(Sum(CASE month WHEN '".$month[3]."' THEN comp END), 0) AS comp4,
    IFNULL(Sum(CASE month WHEN '".$month[4]."' THEN not_comp END ),0) AS not_comp5,
    IFNULL(Sum(CASE month WHEN '".$month[4]."' THEN comp END), 0) AS comp5,
    IFNULL(Sum(CASE month WHEN '".$month[5]."' THEN not_comp END ),0) AS not_comp6,
    IFNULL(Sum(CASE month WHEN '".$month[5]."' THEN comp END), 0) AS comp6,
    IFNULL(Sum(CASE month WHEN '".$month[6]."' THEN not_comp END ),0) AS not_comp7,
    IFNULL(Sum(CASE month WHEN '".$month[6]."' THEN comp END), 0) AS comp7,
    IFNULL(Sum(CASE month WHEN '".$month[7]."' THEN not_comp END ),0) AS not_comp8,
    IFNULL(Sum(CASE month WHEN '".$month[7]."' THEN comp END), 0) AS comp8,
    IFNULL(Sum(CASE month WHEN '".$month[8]."' THEN not_comp END ),0) AS not_comp9,
    IFNULL(Sum(CASE month WHEN '".$month[8]."' THEN comp END), 0) AS comp9,
    IFNULL(Sum(CASE month WHEN '".$month[9]."' THEN not_comp END ),0) AS not_comp10,
    IFNULL(Sum(CASE month WHEN '".$month[9]."' THEN comp END), 0) AS comp10,
    IFNULL(Sum(CASE month WHEN '".$month[10]."' THEN not_comp END ),0) AS not_comp11,
    IFNULL(Sum(CASE month WHEN '".$month[10]."' THEN comp END), 0) AS comp11,
    IFNULL(Sum(CASE month WHEN '".$month[11]."' THEN not_comp END ),0) AS not_comp12,
    IFNULL(Sum(CASE month WHEN '".$month[11]."' THEN comp END), 0) AS comp12
    FROM
      xw_vwpmdata
    WHERE
      pmta_pmdatead >= '".$curYearF."'
    AND pmta_pmdatead <= '".$curYearL."' 
        ";
         $query = $this->db->query($sql);
         // echo $this->db->last_query();
         // die();
         return $query->result(); 
  }

  public function get_year_wise_pm()
  {
      $curYear = date('Y');
      $last5yrs=$curYear-5;
      $i= $last5yrs;
      $coming5yrs=$curYear+5;
      while($i < $coming5yrs):
      $year[] = $i;
      $i++;
    endwhile;
    // echo "<pre>";
    // print_r($year);
    // die();
    $sql = "SELECT 
    IFNULL(Sum(CASE year WHEN '".$year[0]."' THEN not_comp END),0) AS not_comp1,
    IFNULL(Sum(CASE year WHEN '".$year[0]."' THEN comp END),0) AS comp1,      
    IFNULL(Sum(CASE year WHEN '".$year[1]."' THEN not_comp END ),0) AS not_comp2,     
    IFNULL(Sum(CASE year WHEN '".$year[1]."' THEN comp END ),0 ) AS comp2,
    IFNULL(Sum(CASE year WHEN '".$year[2]."' THEN not_comp END ),0) AS not_comp3,
    IFNULL(Sum(CASE year WHEN '".$year[2]."' THEN comp END), 0) AS comp3,
    IFNULL(Sum(CASE year WHEN '".$year[3]."' THEN not_comp END ),0) AS not_comp4,
    IFNULL(Sum(CASE year WHEN '".$year[3]."' THEN comp END), 0) AS comp4,
    IFNULL(Sum(CASE year WHEN '".$year[4]."' THEN not_comp END ),0) AS not_comp5,
    IFNULL(Sum(CASE year WHEN '".$year[4]."' THEN comp END), 0) AS comp5,
    IFNULL(Sum(CASE year WHEN '".$year[5]."' THEN not_comp END ),0) AS not_comp6,
    IFNULL(Sum(CASE year WHEN '".$year[5]."' THEN comp END), 0) AS comp6,
    IFNULL(Sum(CASE year WHEN '".$year[6]."' THEN not_comp END ),0) AS not_comp7,
    IFNULL(Sum(CASE year WHEN '".$year[6]."' THEN comp END), 0) AS comp7,
    IFNULL(Sum(CASE year WHEN '".$year[7]."' THEN not_comp END ),0) AS not_comp8,
    IFNULL(Sum(CASE year WHEN '".$year[7]."' THEN comp END), 0) AS comp8,
    IFNULL(Sum(CASE year WHEN '".$year[8]."' THEN not_comp END ),0) AS not_comp9,
    IFNULL(Sum(CASE year WHEN '".$year[8]."' THEN comp END), 0) AS comp9,
    IFNULL(Sum(CASE year WHEN '".$year[9]."' THEN not_comp END ),0) AS not_comp10,
    IFNULL(Sum(CASE year WHEN '".$year[9]."' THEN comp END), 0) AS comp10
    FROM
      xw_vwpmdata
    WHERE
      year >= '".$last5yrs."'
    AND year <= '".$coming5yrs."' 
        ";
         $query = $this->db->query($sql);
         // echo $this->db->last_query();
         // die();
         return $query->result(); 
  }




// For Helper

  function dateAddCase()
  {
    $curdate = date("l");

    switch($curdate){
      case "Sunday":
        return $strdate = '-1 day';
        break;
      case 'Monday':
        return $strdate = '-2 day';
        break;
      case 'Tuesday':
        return $strdate = '-3 day';
      case 'Wednesday':
        return $strdate = '-4 day';
        break;
      case 'Thursday':
        return $strdate = '-5 day';
        break;
      case 'Friday':
        return $strdate = '-6 day';
        break;
      case 'Saturday':
        return $strdate = '-7 day';
        break;
      default:
        return 'Invalid';
    }
  }

  function weekFormate()
  {
      $weekNum    = strtotime('this sunday -1 week');

      $weekDate1    = strtotime('-7 day', $weekNum);
      $weekDate2    = strtotime('-14 day', $weekNum);
      $weekDate3    = strtotime('-21 day', $weekNum);
      $weekDate4    = strtotime('-28 day', $weekNum);

      $cnvWeek = date("W", $weekNum); 
      $weekNum = $cnvWeek;


      $cnvWeek1 = date("W", $weekDate1); 
      $weekNum1 = $cnvWeek1;

      $cnvWeek2 = date("W", $weekDate2); 
      $weekNum2 = $cnvWeek2;

      $cnvWeek3 = date("W", $weekDate3); 
      $weekNum3 = $cnvWeek3;

      $cnvWeek4 = date("W", $weekDate4); 
      $weekNum4 = $cnvWeek4;

      $strarray = array($weekNum, $weekNum1, $weekNum2, $weekNum3, $weekNum4);
      return $strarray;
  }


  function getCurSundayDate()
  {
    $curnWeek   = date('Y/m/d', strtotime('this sunday -1 week'));
    return $curnWeek;
  }

  function getFSundayOfFiveWeek()
  {
    $weekNum  = strtotime('this sunday -1 week');
    $weekdate   = strtotime('-35 day', $weekNum);
    $date = date('Y/m/d', $weekdate);
    return $date;
  }

  function dateAddCaseMonth()
  {
    $curmonth = date("F");

    switch($curmonth){
      case "January":
        return $strmonth = '-1 month';
        break;
      case 'February':
        return $strmonth = '-2 month';
        break;
      case 'March':
        return $strmonth = '-3 month';
      case 'April':
        return $strmonth = '-4 month';
        break;
      case 'May':
        return $strmonth = '-5 month';
        break;
      case 'June':
        return $strmonth = '-6 month';
        break;
      case 'July':
        return $strmonth = '-7 month';
        break;
      case 'August':
        return $strmonth = '-8 month';
        break;
      case 'September':
        return $strmonth = '-9 month';
        break;
      case 'October':
        return $strmonth = '-10 month';
        break;
      case 'November':
        return $strmonth = '-11 month';
        break;
      case 'December':
        return $strmonth = '-12 month';
        break;
      default:
        return 'Invalid';
    }
  }

    public function get_stock_count($cond = false)
    {
        $prefix = $this->db->dbprefix;
        $sql = "SELECT SUM(CASE WHEN(stockrmk='Stock') THEN 1 ELSE 0 END) As StockCnt, SUM(CASE WHEN(stockrmk='Limited') THEN 1 ELSE 0 END) As LimitCnt,SUM(CASE WHEN(stockrmk='Zero') THEN 1 ELSE 0 END) As ZeroCnt
            FROM(
            select itli_itemlistid, itli_itemcode, itli_itemname, itli_reorderlevel, itli_maxlimit, ifnull(sum(trde_issueqty),0) as totalstock,
            (
            CASE WHEN((ifnull(sum(trde_issueqty),0) <itli_reorderlevel) && (ifnull(sum(trde_issueqty),0)>0 )) THEN 'Limited'  WHEN (ifnull(sum(trde_issueqty),0)=0) THEN 'Zero' ELSE  'Stock' END ) stockrmk 
            from ".$prefix."itli_itemslist il
            left join ".$prefix."trde_transactiondetail td on td.trde_itemsid  = il.itli_itemlistid 
            left join ".$prefix."trma_transactionmain tm on tm.trma_trmaid = td.trde_trmaid
            where trma_received = '1' AND td.trde_status = 'O' ". $cond. "
            group by itli_itemname, itli_locationid
            )X";
        $query = $this->db->query($sql);

        // echo $this->db->last_query();
        // die();

        return $query->result();
    }


   public function get_stock_count_department($cond = false){
        $sql = "SELECT SUM(CASE WHEN(avl_item_stock>10) THEN 1 ELSE 0 END ) as avl_cnt,
         SUM(CASE WHEN(avl_item_stock>0 AND lab_stock_qty<10) THEN 1 ELSE 0 END ) as limit_cnt,
         SUM(CASE WHEN(avl_item_stock=0) THEN 1 ELSE 0 END) as out_cnt
         FROM xw_vw_lab_stock_rec $cond";
        $query = $this->db->query($sql);

        // echo $this->db->last_query();
        // die();

        return $query->result();
    }



     public function get_receive_stock_count($cond = false)
     {
        $prefix = $this->db->dbprefix;
        $sql = "SELECT SUM(CASE WHEN(stockrmk='Stock') THEN 1 ELSE 0 END) As StockCnt, SUM(CASE WHEN(stockrmk='Limited') THEN 1 ELSE 0 END) As LimitCnt,SUM(CASE WHEN(stockrmk='Zero') THEN 1 ELSE 0 END) As ZeroCnt
            FROM(
            select itli_itemlistid, itli_itemcode, itli_itemname, itli_reorderlevel, itli_maxlimit, ifnull(sum(trde_issueqty),0) as totalstock,
            (
            CASE WHEN((ifnull(sum(trde_issueqty),0) <itli_reorderlevel) && (ifnull(sum(trde_issueqty),0)>0 )) THEN 'Limited'  WHEN (ifnull(sum(trde_issueqty),0)=0) THEN 'Zero' ELSE  'Stock' END ) stockrmk 
            from ".$prefix."itli_itemslist il
            left join ".$prefix."trde_transactiondetail td on td.trde_itemsid  = il.itli_itemlistid 
            left join ".$prefix."trma_transactionmain tm on tm.trma_trmaid = td.trde_trmaid
            where trma_received = '1' AND td.trde_status = 'O' ". $cond. "
            group by itli_itemname, itli_locationid
            )X";
        $query = $this->db->query($sql);

        // echo $this->db->last_query();
        // die();

        return $query->result();
    }


public function get_requisition_issue_data()
  {
   $prefix = $this->db->dbprefix;
        $sql = "SELECT * from xw_vw_requ_issue LIMIT 5";
        $query = $this->db->query($sql);

        // echo $this->db->last_query();
        // die();

        return $query->result();
}


public function get_weekly_req_issue()
  {
    $strdate = $this->dateAddCase();


    $befor     = strtotime($strdate);


    $befordate = date("Y/m/d", $befor);
  
    $indate = new DateTime($befordate);
    $i = 1;
    while($i <= 7):
      $indate->add(new DateInterval('P1D'));
      $genDate = $indate->format('Y/m/d');
      $date[] = $this->general->EngToNepDateConv($genDate);
     
      $i++;
    endwhile;
   

  $sql = " SELECT
      IFNULL(
        Sum(
          CASE dates
          WHEN '".$date[0]."' THEN
            reqcnt
          END
        ),
        0
      ) AS reqcnt1,
      IFNULL(
        Sum(
          CASE dates
          WHEN '".$date[0]."' THEN
            isscnt
          END
        ),
        0
      ) AS isscnt1,
      IFNULL(
        Sum(
          CASE dates
          WHEN '".$date[1]."' THEN
            reqcnt
          END
        ),
        0
      ) AS reqcnt2,
      IFNULL(
        Sum(
          CASE dates
          WHEN '".$date[1]."' THEN
            isscnt
          END
        ),
        0
      ) AS isscnt2,
      IFNULL(
        Sum(
          CASE dates
          WHEN '".$date[2]."' THEN
            reqcnt
          END
        ),
        0
      ) AS reqcnt3,
      IFNULL(
        Sum(
          CASE dates
          WHEN '".$date[2]."' THEN
            isscnt
          END
        ),
        0
      ) AS isscnt3,
      IFNULL(
        Sum(
          CASE dates
          WHEN '".$date[3]."' THEN
            reqcnt
          END
        ),
        0
      ) AS reqcnt4,
      IFNULL(
        Sum(
          CASE dates
          WHEN '".$date[3]."' THEN
            isscnt
          END
        ),
        0
      ) AS isscnt4,
      IFNULL(
        Sum(
          CASE dates
          WHEN '".$date[4]."' THEN
            reqcnt
          END
        ),
        0
      ) AS reqcnt5,
      IFNULL(
        Sum(
          CASE dates
          WHEN '".$date[4]."' THEN
            isscnt
          END
        ),
        0
      ) AS isscnt5,
      IFNULL(
        Sum(
          CASE dates
          WHEN '".$date[5]."' THEN
            reqcnt
          END
        ),
        0
      ) AS reqcnt6,
      IFNULL(
        Sum(
          CASE dates
          WHEN '".$date[5]."' THEN
            isscnt
          END
        ),
        0
      ) AS isscnt6,
      IFNULL(
        Sum(
          CASE dates
          WHEN '".$date[6]."' THEN
            reqcnt
          END
        ),
        0
      ) AS reqcnt7,
      IFNULL(
        Sum(
          CASE dates
          WHEN '".$date[6]."' THEN
            isscnt
          END
        ),
        0
      ) AS isscnt7
    FROM
      xw_vw_requ_issue
    WHERE
      dates >= '".$date[0]."'
    AND dates <= '".$date[6]."' ";
      $query = $this->db->query($sql);
      // echo $this->db->last_query();
      // die();
      return $query->result();
  }

public function get_year_wise_req_issue()
  {
      $curYear = CURYEAR;
      $last5yrs=$curYear-5;
      $i= $last5yrs;
      $coming5yrs=$curYear+5;
      while($i < $coming5yrs):
       $year[]= substr($i,-3).'/'.substr($i+1,-2);
      // $year[] = $i;
      $i++;
    endwhile;
    // die();
    // echo "<pre>";
    // print_r($year);
    // die();
    $sql = "SELECT 
    IFNULL(Sum(CASE fiscalyrs WHEN '".$year[0]."' THEN reqcnt END),0) AS reqcnt1,
    IFNULL(Sum(CASE fiscalyrs WHEN '".$year[0]."' THEN isscnt END),0) AS isscnt1,      
    IFNULL(Sum(CASE fiscalyrs WHEN '".$year[1]."' THEN reqcnt END ),0) AS reqcnt2,     
    IFNULL(Sum(CASE fiscalyrs WHEN '".$year[1]."' THEN isscnt END ),0 ) AS isscnt2,
    IFNULL(Sum(CASE fiscalyrs WHEN '".$year[2]."' THEN reqcnt END ),0) AS reqcnt3,
    IFNULL(Sum(CASE fiscalyrs WHEN '".$year[2]."' THEN isscnt END), 0) AS isscnt3,
    IFNULL(Sum(CASE fiscalyrs WHEN '".$year[3]."' THEN reqcnt END ),0) AS reqcnt4,
    IFNULL(Sum(CASE fiscalyrs WHEN '".$year[3]."' THEN isscnt END), 0) AS isscnt4,
    IFNULL(Sum(CASE fiscalyrs WHEN '".$year[4]."' THEN reqcnt END ),0) AS reqcnt5,
    IFNULL(Sum(CASE fiscalyrs WHEN '".$year[4]."' THEN isscnt END), 0) AS isscnt5,
    IFNULL(Sum(CASE fiscalyrs WHEN '".$year[5]."' THEN reqcnt END ),0) AS reqcnt6,
    IFNULL(Sum(CASE fiscalyrs WHEN '".$year[5]."' THEN isscnt END), 0) AS isscnt6,
    IFNULL(Sum(CASE fiscalyrs WHEN '".$year[6]."' THEN reqcnt END ),0) AS reqcnt7,
    IFNULL(Sum(CASE fiscalyrs WHEN '".$year[6]."' THEN isscnt END), 0) AS isscnt7,
    IFNULL(Sum(CASE fiscalyrs WHEN '".$year[7]."' THEN reqcnt END ),0) AS reqcnt8,
    IFNULL(Sum(CASE fiscalyrs WHEN '".$year[7]."' THEN isscnt END), 0) AS isscnt8,
    IFNULL(Sum(CASE fiscalyrs WHEN '".$year[8]."' THEN reqcnt END ),0) AS reqcnt9,
    IFNULL(Sum(CASE fiscalyrs WHEN '".$year[8]."' THEN isscnt END), 0) AS isscnt9,
    IFNULL(Sum(CASE fiscalyrs WHEN '".$year[9]."' THEN reqcnt END ),0) AS reqcnt10,
    IFNULL(Sum(CASE fiscalyrs WHEN '".$year[9]."' THEN isscnt END), 0) AS isscnt10
    FROM
      xw_vw_requ_issue
    WHERE
      yrs >= '".$last5yrs."'
    AND yrs <= '".$coming5yrs."' 
        ";
         $query = $this->db->query($sql);
         // echo $this->db->last_query();
         // die();
         return $query->result(); 
  }
 public function get_year_req_issue()
  {
    $curYearF = date('Y').'/01/01';
  
    $curYearL = date('Y').'/12/31';
   
    $strmonth = $this->dateAddCaseMonth();
    $befor    = strtotime($strmonth);
    $befordate= date("Y/m/d", $befor);
    $i = 1;
    $indate = new DateTime($befordate);

    while($i <= 12):
    $indate->add(new DateInterval('P1M'));
    $genDate = $indate->format('Y/m/d');
    $strdate = strtotime($genDate);
    $day     = strtoupper(date("F", $strdate));
    $month[] = $i;
    $i++;
    endwhile;
    // echo "<pre>";
    // print_r($month);
    // die();
    $sql = "SELECT 
    IFNULL(Sum(CASE mnth WHEN '".$month[3]."' THEN reqcnt END),0) AS reqcnt1,
    IFNULL(Sum(CASE mnth WHEN '".$month[3]."' THEN isscnt END),0) AS isscnt1,      
    IFNULL(Sum(CASE mnth WHEN '".$month[4]."' THEN reqcnt END ),0) AS reqcnt2,     
    IFNULL(Sum(CASE mnth WHEN '".$month[4]."' THEN isscnt END ),0 ) AS isscnt2,
    IFNULL(Sum(CASE mnth WHEN '".$month[5]."' THEN reqcnt END ),0) AS reqcnt3,
    IFNULL(Sum(CASE mnth WHEN '".$month[5]."' THEN isscnt END), 0) AS isscnt3,
    IFNULL(Sum(CASE mnth WHEN '".$month[6]."' THEN reqcnt END ),0) AS reqcnt4,
    IFNULL(Sum(CASE mnth WHEN '".$month[6]."' THEN isscnt END), 0) AS isscnt4,
    IFNULL(Sum(CASE mnth WHEN '".$month[7]."' THEN reqcnt END ),0) AS reqcnt5,
    IFNULL(Sum(CASE mnth WHEN '".$month[7]."' THEN isscnt END), 0) AS isscnt5,
    IFNULL(Sum(CASE mnth WHEN '".$month[8]."' THEN reqcnt END ),0) AS reqcnt6,
    IFNULL(Sum(CASE mnth WHEN '".$month[8]."' THEN isscnt END), 0) AS isscnt6,
    IFNULL(Sum(CASE mnth WHEN '".$month[9]."' THEN reqcnt END ),0) AS reqcnt7,
    IFNULL(Sum(CASE mnth WHEN '".$month[9]."' THEN isscnt END), 0) AS isscnt7,
    IFNULL(Sum(CASE mnth WHEN '".$month[10]."' THEN reqcnt END ),0) AS reqcnt8,
    IFNULL(Sum(CASE mnth WHEN '".$month[10]."' THEN isscnt END), 0) AS isscnt8,
    IFNULL(Sum(CASE mnth WHEN '".$month[11]."' THEN reqcnt END ),0) AS reqcnt9,
    IFNULL(Sum(CASE mnth WHEN '".$month[11]."' THEN isscnt END), 0) AS isscnt9,
    IFNULL(Sum(CASE mnth WHEN '".$month[0]."' THEN reqcnt END ),0) AS reqcnt10,
    IFNULL(Sum(CASE mnth WHEN '".$month[0]."' THEN isscnt END), 0) AS isscnt10,
    IFNULL(Sum(CASE mnth WHEN '".$month[1]."' THEN reqcnt END ),0) AS reqcnt11,
    IFNULL(Sum(CASE mnth WHEN '".$month[1]."' THEN isscnt END), 0) AS isscnt11,
    IFNULL(Sum(CASE mnth WHEN '".$month[2]."' THEN reqcnt END ),0) AS reqcnt12,
    IFNULL(Sum(CASE mnth WHEN '".$month[2]."' THEN isscnt END), 0) AS isscnt12
    FROM
      xw_vw_requ_issue
    WHERE
      fiscalyrs='".CUR_FISCALYEAR."'
        ";
         $query = $this->db->query($sql);
         // echo $this->db->last_query();
         // die();
         return $query->result(); 
  }

public function get_pie_chart($type=false){
    $sum=("SELECT ec.eqca_equipmentcategoryid catid,ec.eqca_category category,0 as recqty,SUM(sade_curqty) as issueqty from xw_sade_saledetail sd LEFT JOIN xw_sama_salemaster sm on sm.sama_salemasterid=sd.sade_salemasterid
     LEFT JOIN xw_itli_itemslist il on il.itli_itemlistid=sd.sade_itemsid LEFT JOIN  xw_eqca_equipmentcategory ec on ec.eqca_equipmentcategoryid=il.itli_catid
    WHERE sm.sama_storeid=1 AND sm.sama_st='N' AND sm.sama_status='O'GROUP BY ec.eqca_equipmentcategoryid,ec.eqca_category
    UNION
    SELECT ec.eqca_equipmentcategoryid catid,ec.eqca_category category,SUM(trde_requiredqty) as recqty,0 as issueqty from xw_trde_transactiondetail td LEFT JOIN xw_trma_transactionmain tm on tm.trma_trmaid = td.trde_trmaid
     LEFT JOIN xw_itli_itemslist il on il.itli_itemlistid=td.trde_itemsid LEFT JOIN  xw_eqca_equipmentcategory ec on ec.eqca_equipmentcategoryid=il.itli_catid WHERE tm.trma_todepartmentid=1 AND tm.trma_status='O'
    GROUP BY ec.eqca_equipmentcategoryid,ec.eqca_category");

    $query=("SELECT ec.eqca_equipmentcategoryid catid,ec.eqca_category category,0 as recqty,SUM(sade_curqty) as issueqty from xw_sade_saledetail sd
    LEFT JOIN xw_sama_salemaster sm on sm.sama_salemasterid=sd.sade_salemasterid
     LEFT JOIN xw_itli_itemslist il on il.itli_itemlistid=sd.sade_itemsid
    LEFT JOIN  xw_eqca_equipmentcategory ec on ec.eqca_equipmentcategoryid=il.itli_catid
    WHERE sm.sama_storeid=1 AND sm.sama_st='N' AND sm.sama_status='O'
    GROUP BY ec.eqca_equipmentcategoryid,ec.eqca_category
    UNION
    select ec.eqca_equipmentcategoryid catid,ec.eqca_category category,SUM(trde_requiredqty) as recqty,0 as issueqty from xw_trde_transactiondetail td
    LEFT JOIN xw_trma_transactionmain tm on tm.trma_trmaid = td.trde_trmaid
     LEFT JOIN xw_itli_itemslist il on il.itli_itemlistid=td.trde_itemsid
    LEFT JOIN  xw_eqca_equipmentcategory ec on ec.eqca_equipmentcategoryid=il.itli_catid
    WHERE tm.trma_todepartmentid=1 AND tm.trma_status='O'
    GROUP BY ec.eqca_equipmentcategoryid,ec.eqca_category");

    if($type==1){
      $sql_req=("SELECT catid,category,SUM(recqty) recqty,SUM(issueqty)issueqty,ROUND(
      SUM(recqty)/(SELECT SUM(recqty)recqty FROM($sum) X WHERE catid <>'' )*100,2) as req_per,
      SUM(recqty-issueqty) balance FROM($query
      ) X WHERE catid <>'' GROUP BY   catid,category;");
        $nquery=$this->db->query($sql_req);
    //echo $nquery; die;
      }elseif($type==2){
      $sql_req=("SELECT catid,category,SUM(recqty) recqty,SUM(issueqty)issueqty,ROUND(
      SUM(issueqty)/(SELECT SUM(issueqty)issueqty FROM($sum) X WHERE catid <>'' )*100,2) as iss_per,
      SUM(recqty-issueqty) balance FROM($query
      ) X WHERE catid <>'' GROUP BY   catid,category;");
      $nquery=$this->db->query($sql_req);
    }

$num_row=$nquery->num_rows();

        if (!empty($_GET['iDisplayLength']) &&  !empty($nquery) && is_array($nquery) && count($nquery) > 0 ) {
            $totalrecs = sizeof($nquery);
        }

       if($num_row>0){
          $ndata=$nquery->result();
        
        } 
        else
        {
            $ndata=array();
            // $ndata['totalrecs'] = 0;
            // $ndata['totalfilteredrecs'] = 0;
        }
       return $ndata;
}

    public function get_req_iss_detail($group_by=false,$id=false)
    {
       
        
        $month=$this->input->post('month');
        $year=$this->input->post('year');
        // $week=$this->input->post('week');
        $date=$this->general->EngToNepDateConv($this->input->post('date'));
        // $type=$this->input->post('type');
        //echo "<pre>"; print_r($this->input->post()) ; die;
          $subquery2 = "(SELECT et.eqty_equipmenttype FROM xw_eqty_equipmenttype et WHERE et.eqty_equipmenttypeid=rm.rema_reqtodepid)";

        
        // $cntitemQty="(SELECT COUNT(*) as cntitem from xw_rede_reqdetail rd WHERE rd.rede_remqty >0 AND rd.rede_reqmasterid=rm.rema_reqmasterid) as cntitem";


        $this->db->select('ri.dates,ri.fiscalyrs,ri.yrs,ri.mnth,rema_reqmasterid,rema_reqno,
                            rema_manualno,rede_qty,itli_itemname,itli_itemnamenp,itli_itemcode,
                            rema_reqby,rema_username,rema_isdep,
                            rema_approvedby,rede_remqty,rede_remarks,
                            rema_reqdatebs,
                            rema_reqdatead, rema_isdep,rema_fyear,dept_depname,eqty_equipmenttype');
        $this->db->from('xw_vw_requ_issue ri');
        $this->db->join('rema_reqmaster rm','rema_reqdatebs=ri.dates ','LEFT');
        $this->db->join('rede_reqdetail rd','rd.rede_reqmasterid=rm.rema_reqmasterid ','LEFT');
        $this->db->join('itli_itemslist it','it.itli_itemlistid = rd.rede_itemsid','LEFT');

        $this->db->join('dept_department d','d.dept_depid=rm.rema_reqfromdepid','LEFT');
        $this->db->join('eqty_equipmenttype et','et.eqty_equipmenttypeid=rm.rema_reqtodepid','LEFT');
        $this->db->where('rema_reqmasterid<>0');

        if($group_by)
        {
            $this->db->group_by($group_by);
        }
        if($id)
        {
            $this->db->where('rema_reqno',$id);
        }

        if($month)
        {
            $this->db->where('ri.mnth',$month);
        }
        if($year)
        {
            $this->db->where('ri.yrs',$year);
        }
        // if($week)
        // {
        //   $this->db->where('ri.wek',$week);
        // }
        if($date)
        {
           $this->db->where('ri.dates',$date);
        }
        if(!empty($month) && !empty($year))
        {
            $mnth=$month;
            if($month<10)
            {
                $mnth='0'.$month;
            }
            // echo $mnth;
            $datesrch=$year.'/'.$mnth;
            $this->db->like('ri.dates',$datesrch, 'after');
        }
     

        $query = $this->db->get();
          //echo $this->db->last_query(); die();
        if ($query->num_rows() > 0) 
        {
            $data=$query->result();     
            return $data;       
        }       
        
        return false;
    }

    public function get_issue_detail($group_by=false, $id=false)
    {
       
        
        $month=$this->input->post('month');
        $year=$this->input->post('year');
        // $week=$this->input->post('week');
         $date=$this->general->EngToNepDateConv($this->input->post('date'));
        // $type=$this->input->post('type');
        // echo "<pre>"; print_r($this->input->post()) ; die;
         

        $this->db->select('ri.dates,ri.fiscalyrs,ri.yrs,ri.mnth,sama_billdatebs, sama_billdatead,
                            sama_invoiceno, itli_itemcode, itli_itemname, itli_itemnamenp,
                            sama_depname,sade_qty, sade_unitrate,
                            sama_totalamount,
                            sama_receivedby,
                            sama_requisitionno , sama_username,sama_billtime,sama_billno,sama_fyear');
        $this->db->from('xw_vw_requ_issue ri');
        $this->db->join('xw_sama_salemaster sm','sama_billdatebs=ri.dates ','LEFT');
        $this->db->join('sade_saledetail sd','sd.sade_salemasterid=sm.sama_salemasterid ','LEFT');
        $this->db->join('itli_itemslist it','it.itli_itemlistid = sd.sade_itemsid','LEFT');
        $this->db->join('dept_department dp','dp.dept_depid=sm.sama_depid','left');
        $this->db->where('sama_salemasterid<>0');
       $this->db->where('sade_iscancel',"N");

        if($group_by)
        {
            $this->db->group_by($group_by);
        }
        if($id)
        {
            $this->db->where('sama_invoiceno',$id);
        }

        if($month)
        {
            $this->db->where('ri.mnth',$month);
        }
        if($year)
        {
            $this->db->where('ri.yrs',$year);
        }
        // if($week)
        // {
        //   $this->db->where('ri.wek',$week);
        // }
        if($date)
        {
           $this->db->where('ri.dates',$date);
        }
        if(!empty($month) && !empty($year))
        {
            $mnth=$month;
            if($month<10)
            {
                $mnth='0'.$month;
            }
            // echo $mnth;
            $datesrch=$year.'/'.$mnth;
            $this->db->like('ri.dates',$datesrch, 'after');
        }
     

        $query = $this->db->get();
         //echo $this->db->last_query(); die();
        if ($query->num_rows() > 0) 
        {
            $data=$query->result();     
            return $data;       
        }       
        
        return false;
    }

    //assets dashboard

    public function get_assets_dashboard_count($fromDate=false,$toDate=false){
        $where = "";
        if($fromDate && $toDate){
            $where = "where asen_purchasedatebs >= '$fromDate' AND asen_purchasedatebs <= '$toDate'";
        }
        $sql = "select count(*) as total, (select count(*) from xw_asen_assetentry where asen_purchasedatebs = '".CURDATE_NP."') as today,sum(case when(asen_status = '1') then 1 else 0 end) in_use, sum(case when(asen_status = '2') then 1 else 0 end) in_store, sum(case when(asen_status = '3') then 1 else 0 end) loaned_out,sum(case when(asen_condition = '1') then 1 else 0 end) new, sum(case when(asen_condition = '2') then 1 else 0 end) good, sum(case when(asen_condition = '3') then 1 else 0 end) fair, sum(case when(asen_condition = '4') then 1 else 0 end) poor,sum(case when(asen_depreciation = '1') then 1 else 0 end) sl, sum(case when(asen_depreciation = '2') then 1 else 0 end) ddb, sum(case when(asen_depreciation = '3') then 1 else 0 end) uop, sum(case when(asen_depreciation = '4') then 1 else 0 end) soyd from xw_asen_assetentry $where";
        $query = $this->db->query($sql);
        
        if($query->num_rows() > 0){
            $data = $query->result();
            return $data;        
        }
        return false;
    }

    public function get_all_amc_assets($srchcol=false,$othersrch=false){
    //$add_date=  date('Y/m/d',strtotime(CURDATE_EN . "+15 days"));
    $get = $_GET;
 
        foreach ($get as $key => $value) {
          $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }
      

      if(!empty($get['sSearch_1'])){
          $this->db->where("asen_assetcode like  '%".$get['sSearch_1']."%' ");
        }

        if(!empty($get['sSearch_2'])){
          $this->db->where("itli_itemname like  '%".$get['sSearch_2']."%' ");
        }

        
        if(!empty($get['sSearch_3'])){
          $this->db->where("manu_manlst like  '%".$get['sSearch_3']."%'  ");
        }
           if(!empty($get['sSearch_4'])){
          $this->db->where("dist_distributor like  '%".$get['sSearch_4']."%'  ");
        }
             if(!empty($get['sSearch_5'])){
          $this->db->where("amta_postdatead like  '%".$get['sSearch_5']."%'  ");
        }


      
        //$this->db->where('amta_amcdatead <=', $add_date);

        $this->db->select("*");
       $this->db->from('amta_amctable amc');
       $this->db->join('asen_assetentry aet','aet.asen_asenid=amc.amta_equipid','LEFT');
      $this->db->join('itli_itemslist it','it.itli_itemlistid=aet.asen_description','LEFT');
       $this->db->join('manu_manufacturers mn','mn.manu_manlistid=asen_manufacture','LEFT');
      
       
       if($srchcol)
       {
        $this->db->where($srchcol);
       }
       if($othersrch)
       {
        $this->db->where($othersrch);
       }

        // $this->db->group_by('amc.amta_equipid');
    
  
      $resltrpt=$this->db->get();
        $rslt=$resltrpt->num_rows();
        if(!empty($rslt))
        {
        $totalfilteredrecs=$rslt;
      }
      else
      {
        $totalfilteredrecs=0;
      }


        $order_by = 'amc.amta_amcdatead';
        $order = 'asc';
  
        $where='';
        if($this->input->get('iSortCol_0')==0)
          $order_by = 'amc.amta_equipid';
        else if($this->input->get('iSortCol_0')==1)
          $order_by = 'asen_assetcode';
        else if($this->input->get('iSortCol_0')==2)
          $order_by = 'itli_itemname';
        
        else if($this->input->get('iSortCol_0')==3)
          $order_by = 'manu_manlst';
        
        else if($this->input->get('iSortCol_0')==4)
          $order_by = 'amta_postdatead';
        else if($this->input->get('iSortCol_0')==5)
          $order_by = 'amta_postdatebs';
        
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
          $this->db->where("asen_assetcode like  '%".$get['sSearch_1']."%' ");
        }

        if(!empty($get['sSearch_2'])){
          $this->db->where("itli_itemname like  '%".$get['sSearch_2']."%' ");
        }
       
        if(!empty($get['sSearch_3'])){
          $this->db->where("manu_manlst like  '%".$get['sSearch_3']."%'  ");
        }
           if(!empty($get['sSearch_4'])){
          $this->db->where("dist_distributor like  '%".$get['sSearch_4']."%'  ");
        }
             if(!empty($get['sSearch_5'])){
          $this->db->where("amta_postdatead like  '%".$get['sSearch_5']."%'  ");
        }
         

        $this->db->select("amc.*,asen_assetcode,itli_itemname, manu_manlst");
       $this->db->from('amta_amctable amc');
      $this->db->join('asen_assetentry aet','aet.asen_asenid=amc.amta_equipid','LEFT');
      
       $this->db->join('itli_itemslist it','it.itli_itemlistid=aet.asen_description','LEFT');
       $this->db->join('manu_manufacturers mn','mn.manu_manlistid=asen_manufacture','LEFT');
       
        if($srchcol)
       {
        $this->db->where($srchcol);
       }
        if($othersrch)
       {
        $this->db->where($othersrch);
       }
       //$this->db->group_by('amc.amta_equipid');
       if($limit){
        $this->db->limit($limit);
       }
       if($offset)
        {
            $this->db->offset($offset);
        }
        $nquery=$this->db->get();
        $num_row=$nquery->num_rows();
        if (!empty($_GET['iDisplayLength']) &&  !empty($nquery) && is_array($nquery) && count($nquery) > 0 ) {
            $totalrecs = count($nquery);
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
    public function update_comment($id=false)
    {
         $this->db->where("eqco_equipmentcommentid", $id);
          $this->db->set("eqco_comment_status", '3');
          $this->db->update("eqco_equipmentcomment");

          // $this->db->update("eqco_equipmentcomment",$postdata,array('eqco_equipmentcommentid'=>$id));
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

    public function get_access_dashboard_list()
    {
      $usergroupid=$this->session->userdata(USER_GROUP);
      // echo 't'.$usergroupid;
      // die();

        $this->db->select("usgr_dashboard");
        $this->db->from('usgr_usergroup urg');
        $this->db->where(array('usgr_usergroupid'=>$usergroupid));
       
        $query = $this->db->get();
  
        $numrw=$query->num_rows();
         if($numrw>0){
         $result=$query->row();
         if(!empty($result)){
            $dashboardid=$result->usgr_dashboard;
          if(!empty($dashboardid))
          {
            // echo $dashboardid;
            // die();
            $list_dashboard=explode(',', $dashboardid);
            return $list_dashboard;
          }
         }
         
          return false;
        }
        return false; 

    }
}