<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class pm_data_mdl extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
		$this->table='pmta_pmtable';
     $this->load->library('upload');

     $this->sess_usercode = $this->session->userdata(USER_GROUPCODE);
    $this->sess_dept = $this->session->userdata(USER_DEPT);
	}

	public $validate_pm_data = array(  
	 	array('field' => 'pmta_equipid', 'label' => 'Search And Add Data', 'rules' => 'trim|required|xss_clean'),            
        );
	
	public function save_pm_data()
	{
		$pmArray = array();
		$postdata=$this->input->post();
		$id=$this->input->post('id');
		
		$pmdate = $this->input->post('pmta_pmdate');

    // print_r($pmdate);die;
		// $pmdatead = $this->input->post('pmta_pmdatead');
		$remarks = $this->input->post('pmta_remarks');

		$postid=$this->general->get_real_ipaddr();
		$postmac=$this->general->get_Mac_Address();

		// $primary_id = $this->input->post('pmtableid');
		$primary_id = '';

		unset($postdata['id']);
		unset($postdata['pmid']);
		unset($postdata['pmta_pmdate']);
			// echo "<pre>";
			// print_r($pmid);
			// die();

		if(empty($primary_id)){
			if($pmdate){
        $pmta_file = $this->input->post('pmta_file');
              if(!empty($pmdate)):
              foreach($pmdate as $key=>$value):
                  $_FILES['attachments']['name'] = $_FILES['pmta_file']['name'][$key];
                  $_FILES['attachments']['type'] = $_FILES['pmta_file']['type'][$key];
                  $_FILES['attachments']['tmp_name'] = $_FILES['pmta_file']['tmp_name'][$key];
                  $_FILES['attachments']['error'] = $_FILES['pmta_file']['error'][$key];
                  $_FILES['attachments']['size'] = $_FILES['pmta_file']['size'][$key];
                  if(!empty($_FILES)){
                      $imgfile[]=$this->doupload('attachments');
                       // print_r($imgfile);die;
                  }else{
                      $imgfile = '';
                  }
              endforeach;
              endif;

              // print_r($imgfile);die;
				$curtime=$this->general->get_currenttime();
				$userid=$this->session->userdata(USER_ID);
				foreach($pmdate as $key=>$data){
					if(DEFAULT_DATEPICKER == 'NP'){
						$pmdatebs = !empty($pmdate[$key])?$pmdate[$key]:'';
						$pmdatead = $this->general->NepToEngDateConv(!empty($pmdate[$key])?$pmdate[$key]:'');
					}else{
						$pmdatead = !empty($pmdate[$key])?$pmdate[$key]:'';
						$pmdatebs = $this->general->EngToNepDateConv(!empty($pmdate[$key])?$pmdate[$key]:'');
					}

					$pmArray[] = array(
						'pmta_pmdatebs'=>$pmdatebs,
						'pmta_pmdatead'=>$pmdatead,
						'pmta_remarks'=>!empty($remarks[$key])?$remarks[$key]:'',
						'pmta_postdatead'=>CURDATE_EN,
						'pmta_postdatebs'=>CURDATE_NP,
						'pmta_posttime'=>$curtime,
						'pmta_postby'=>$userid,
						'pmta_postip'=>$postid,
						'pmta_postmac'=>$postmac,
						'pmta_orgid'=>$this->session->userdata(ORG_ID),
						'pmta_equipid'=>$this->input->post("pmta_equipid"),
            'pmta_file'=>!empty($imgfile[$key])?$imgfile[$key]:'',
					);
				}
			}

			// echo "<pre>";
			// print_r($pmArray);
			// die();

			if(!empty($pmArray)){
	            $result = $this->db->insert_batch('xw_pmta_pmtable', $pmArray);
	            return true;
	        }
		}else{
			$updateArray = array();

			$pmid = $this->input->post('pmta_pmtableid');

			if($pmdate):
				$curtime=$this->general->get_currenttime();
				$userid=$this->session->userdata(USER_ID);
				foreach($pmdate as $key=>$data){
					if(DEFAULT_DATEPICKER == 'NP'){
						$pmdatebs = !empty($pmdate[$key])?$pmdate[$key]:'';
						$pmdatead = $this->general->NepToEngDateConv(!empty($pmdate[$key])?$pmdate[$key]:'');
					}else{
						$pmdatead = !empty($pmdate[$key])?$pmdate[$key]:'';
						$pmdatebs = $this->general->EngToNepDateConv(!empty($pmdate[$key])?$pmdate[$key]:'');
					}
					
					$updateArray[] = array(
						'pmta_pmtableid'=>!empty($pmid[$key])?$pmid[$key]:'',
						'pmta_pmdatebs'=>$pmdatebs,
						'pmta_pmdatead'=>$pmdatead,
						'pmta_remarks'=>!empty($remarks[$key])?$remarks[$key]:'',
						'pmta_modifydatead'=>CURDATE_EN,
						'pmta_modifydatebs'=>CURDATE_NP,
						'pmta_modifytime'=>$curtime,
						'pmta_modifyby'=>$userid,
						'pmta_modifyip'=>$postid,
						'pmta_modifymac'=>$postmac,
						'pmta_equipid'=>$this->input->post("pmta_equipid")
					);
				}
			endif;
 			if(!empty($updateArray)){
                $this->db->update_batch('xw_pmta_pmtable', $updateArray,'pmta_pmtableid');
                return true;
            }
		}
		
		return false;
	
	}
    public function doupload($file) {
        // echo "test";
        // die();
        $config['upload_path'] = './'.PM_UPLOAD_PATH;//define in constants
        $config['allowed_types'] = 'png|jpg|gif|jpeg|pdf';
        $config['encrypt_name'] = TRUE;
        $config['remove_spaces'] = TRUE;    
        $config['max_size'] = '2000000';
        $config['max_width'] = '50000';
        $config['max_height'] = '50000';

        $this->upload->initialize($config);
        $this->load->library('upload', $config);
        $this->upload->do_upload($file);
        $data = $this->upload->data();
         
        $name_array = $data['file_name'];
            // echo $name_array;
            // exit;
                // $names= implode(',', $name_array);   
            //     // return $names;   
        return $name_array;
    }

	public function edit_pm_data($editid = false){
		$postdata = array();
		$postdata = $this->input->post();

		// echo $editid;
		// die();

		$postid=$this->general->get_real_ipaddr();
		$postmac=$this->general->get_Mac_Address();

		$pmdate = $this->input->post('pmta_pmdatebs');

		if(DEFAULT_DATEPICKER=='NP')
		{
			$pmdatebs= $pmdate;
			$pmdatead = $this->general->NepToEngDateConv($pmdate);
		}
		else
		{
			$pmdatebs= $this->general->EngToNepDateConv($pmdate);
			$pmdatead = $pmdate;
		}


		$pmremarks = $this->input->post('pmta_remarks');

		unset($postdata['modal_editid']);

		$postdata['pmta_pmdatebs'] = $pmdatebs;
		$postdata['pmta_pmdatead'] = $pmdatead;
		$postdata['pmta_remarks'] = $pmremarks;
		$postdata['pmta_modifydatead']=CURDATE_EN;
		$postdata['pmta_modifydatebs']=CURDATE_NP;
		$postdata['pmta_modifytime']=$this->general->get_currenttime();
		$postdata['pmta_modifyby']=$this->session->userdata(USER_ID);
		$postdata['pmta_modifyip']=$postid;
		$postdata['pmta_modifymac']=$postmac;
		// $postdata['pmta_equipid']=$this->input->post("pmta_equipid");

		if(!empty($postdata)){
			$this->db->update($this->table,$postdata,array('pmta_pmtableid'=>$editid));
		}
		return true;
	}


	public function get_all_pm_data($srchcol=false)
	{
		$this->db->select('pm.*');
		$this->db->from('pmta_pmtable pm');
		
		if($srchcol)
		{
			$this->db->where($srchcol);
		}
		$query = $this->db->get();
		// echo $this->db->last_query();die();
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();		
			return $data;		
		}		
		return false;
	}
    
   


	public function remove_pm_data()
	{
		$id=$this->input->post('id');
		if($id)
		{
			$this->db->delete($this->table,array('pmta_pmtableid'=>$id));
			$rowaffected=$this->db->affected_rows();
			if($rowaffected)
			{
				return $rowaffected;
			}
			return false;
		}
		return false;
	}

	public function get_pm_data_list()
	{
		$get = $_GET;
 
      	foreach ($get as $key => $value) {
        	$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
      	}
     	if(!empty($get['sSearch_0'])){
            $this->db->where("riva_riskid like  '%".$get['sSearch_0']."%'  ");
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("riva_risk like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("riva_comments like  '%".$get['sSearch_2']."%'  ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("riva_postdatebs like  '%".$get['sSearch_3']."%'  ");
        }
        $resltrpt=$this->db->select("COUNT(*) as cnt")
  					->from('riva_riskvalues')
  					->get()
  					->row();
	    //echo $this->db->last_query();die(); 
      	$totalfilteredrecs=$resltrpt->cnt; 

      	$order_by = 'riva_riskid';
      	$order = 'desc';
      	if($this->input->get('sSortDir_0'))
  		{
  				$order = $this->input->get('sSortDir_0');
  		}
  
      	$where='';
      	if($this->input->get('iSortCol_0')==0)
        	$order_by = 'riva_riskid';
      	else if($this->input->get('iSortCol_0')==1)
        	$order_by = 'riva_risk';
      	else if($this->input->get('iSortCol_0')==2)
       		$order_by = 'riva_comments';
       	else if($this->input->get('iSortCol_0')==3)
       		$order_by = 'riva_postdatebs';
       	
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
            $this->db->where("riva_riskid like  '%".$get['sSearch_0']."%'  ");
        }

        if(!empty($get['sSearch_1'])){
            $this->db->where("riva_risk like  '%".$get['sSearch_1']."%'  ");
        }

        if(!empty($get['sSearch_2'])){
            $this->db->where("riva_comments like  '%".$get['sSearch_2']."%'  ");
        }
        if(!empty($get['sSearch_3'])){
            $this->db->where("riva_postdatebs like  '%".$get['sSearch_3']."%'  ");
        }
       
        $this->db->select('*');
		$this->db->from('riva_riskvalues');
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

	public function get_all_pm_alert($srchcol=false,$othersrch=false)
	{
		//$add_date=  date('Y/m/d',strtotime(CURDATE_EN . "+15 days"));
		$get = $_GET;
 
      	foreach ($get as $key => $value) {
        	$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
      	}
     	

      if(!empty($get['sSearch_1'])){
          $this->db->where("bm.bmin_equipmentkey like  '%".$get['sSearch_1']."%' ");
        }

        if(!empty($get['sSearch_2'])){
          $this->db->where("eql.eqli_description like  '%".$get['sSearch_2']."%' ");
        }

        if(!empty($get['sSearch_3'])){
          $this->db->where("di.dept_depname like  '%".$get['sSearch_3']."%'  ");
        }

        if(!empty($get['sSearch_4'])){
          $this->db->where("rd.rode_roomname like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
          $this->db->where("rv.riva_risk like  '%".$get['sSearch_5']."%'  ");
        }

        if(!empty($get['sSearch_6'])){
          $this->db->where("mf.manu_manlst like  '%".$get['sSearch_6']."%'  ");
        }
           if(!empty($get['sSearch_7'])){
          $this->db->where("dis.dist_distributor like  '%".$get['sSearch_7']."%'  ");
        }


         if(($this->sess_usercode != 'SA') && ($this->sess_usercode != 'AD')){
 
          $new_sess_dept = explode(',',$this->sess_dept);
          $this->db->where_in('dept_depid',$new_sess_dept);
        }
        //$this->db->where('pmta_pmdatead <=', $add_date);

        $this->db->select("*");
    	 $this->db->from('pmta_pmtable pm');
    	 $this->db->join('bmin_bmeinventory bm','bm.bmin_equipid = pm.pmta_equipid','LEFT');
    	 $this->db->join('eqli_equipmentlist eql','eql.eqli_equipmentlistid=bm.bmin_descriptionid','LEFT');
    	 $this->db->join('dept_department di','di.dept_depid = bm.bmin_departmentid','LEFT');
    	 $this->db->join('riva_riskvalues rv','rv.riva_riskid=bm.bmin_riskid','LEFT');
    	 $this->db->join('dist_distributors dis','dis.dist_distributorid = bm.bmin_distributorid','LEFT');
    	 $this->db->join('manu_manufacturers mf','mf.manu_manlistid=bm.bmin_manufacturerid','LEFT');
    	 $this->db->join('rode_roomdepartment rd', 'rd.rode_roomdepartmentid = bm.bmin_roomid', 'LEFT');
    	 if($srchcol)
    	 {
    	 	$this->db->where($srchcol);
    	 }
       if($othersrch)
       {
        $this->db->where($othersrch);
       }

    	  $this->db->group_by('pm.pmta_equipid');
    
	
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


      	$order_by = 'pm.pmta_pmdatead';
      	$order = 'asc';
  
      	$where='';
      	if($this->input->get('iSortCol_0')==0)
        	$order_by = 'pm.pmta_equipid';
        else if($this->input->get('iSortCol_0')==1)
        	$order_by = 'bm.bmin_equipmentkey';
      	else if($this->input->get('iSortCol_0')==2)
        	$order_by = 'eqli_description';
      	else if($this->input->get('iSortCol_0')==3)
        	$order_by = 'dept_depname';
      	else if($this->input->get('iSortCol_0')==4)
       		$order_by = 'rode_roomname';
       	else if($this->input->get('iSortCol_0')==5)
      	 	$order_by = 'riva_risk';
      	else if($this->input->get('iSortCol_0')==6)
      	 	$order_by = 'manu_manlst';
      	else if($this->input->get('iSortCol_0')==7)
      	 	$order_by = 'dist_distributor';
      	
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
          $this->db->where("bm.bmin_equipmentkey like  '%".$get['sSearch_1']."%' ");
        }

        if(!empty($get['sSearch_2'])){
          $this->db->where("eql.eqli_description like  '%".$get['sSearch_2']."%' ");
        }

        if(!empty($get['sSearch_3'])){
          $this->db->where("di.dept_depname like  '%".$get['sSearch_3']."%'  ");
        }

        if(!empty($get['sSearch_4'])){
          $this->db->where("rd.rode_roomname like  '%".$get['sSearch_4']."%'  ");
        }
        if(!empty($get['sSearch_5'])){
          $this->db->where("rv.riva_risk like  '%".$get['sSearch_5']."%'  ");
        }

        if(!empty($get['sSearch_6'])){
          $this->db->where("mf.manu_manlst like  '%".$get['sSearch_6']."%'  ");
        }
           if(!empty($get['sSearch_7'])){
          $this->db->where("dis.dist_distributor like  '%".$get['sSearch_7']."%'  ");
        }

        $this->db->select("pm.*,pmta_equipid,rv.riva_risk,bm.bmin_equipmentkey,bm.bmin_modelno,bm.bmin_serialno,bm.bmin_amc,bm.bmin_isoperation,bm.bmin_ismaintenance,bm.bmin_servicedatebs,bm.bmin_endwarrantydatebs,bm.bmin_servicedatead,bm.bmin_endwarrantydatead,eql.eqli_description, rv.riva_risk,di.dept_depname AS dein_department,mf.manu_manlst,dis.dist_distributor, rd.rode_roomname");
    	 $this->db->from('pmta_pmtable pm');
    	 $this->db->join('bmin_bmeinventory bm','bm.bmin_equipid = pm.pmta_equipid','LEFT');
    	  $this->db->join('eqli_equipmentlist eql','eql.eqli_equipmentlistid=bm.bmin_descriptionid','LEFT');
    	 $this->db->join('dept_department di','di.dept_depid = bm.bmin_departmentid','LEFT');
    	 $this->db->join('riva_riskvalues rv','rv.riva_riskid=bm.bmin_riskid','LEFT');
    	 $this->db->join('dist_distributors dis','dis.dist_distributorid = bm.bmin_distributorid','LEFT');
    	 $this->db->join('manu_manufacturers mf','mf.manu_manlistid=bm.bmin_manufacturerid','LEFT');
    	 $this->db->join('rode_roomdepartment rd', 'rd.rode_roomdepartmentid = bm.bmin_roomid', 'LEFT');
    	  if($srchcol)
    	 {
    	 	$this->db->where($srchcol);
    	 }
        if($othersrch)
       {
        $this->db->where($othersrch);
       }
    	 $this->db->group_by('pm.pmta_equipid');

        $this->db->order_by($order_by,$order);
        // $this->db->group_by('pmta_equipid');
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


	public function get_pm_data_reports($searchcol=false)
	{
		$fromdate=$this->input->post('frmDate');
		$toDate=$this->input->post('toDate');
		$equpid=$this->input->post('equid');

		if($searchcol)
		{
			$wherecol= 'WHERE '.$searchcol;
		}
		else
		{
			$wherecol='';
		}
		$where='';
		if($fromdate && $toDate)
		{
				if(DEFAULT_DATEPICKER=='NP')
					{
						$fromdateen=$this->general->NepToEngDateConv($fromdate);
						$toDateen=$this->general->NepToEngDateConv($toDate);	
					}
				else
					{
						$fromdateen=$fromdate;
						$toDateen=$toDate;	
				}

			$where="WHERE pmta_pmdatead >='".$fromdateen."' AND pmta_pmdatead <= '".$toDateen."'";
		}

		$sql1="SELECT pmta_equipid,eql.eqli_description,rv.riva_risk,di.dept_depname as dein_department, bm.bmin_equipmentkey,bm.bmin_modelno,bm.bmin_serialno,bm.bmin_amc,bm.bmin_isoperation,bm.bmin_ismaintenance,bm.bmin_servicedatebs,bm.bmin_endwarrantydatebs,bm.bmin_servicedatead,bm.bmin_endwarrantydatead,mf.manu_manlst,dis.dist_distributor from(	
				SELECT pmta_equipid from xw_pmta_pmtable $where
				group by pmta_equipid )pm  LEFT JOIN xw_bmin_bmeinventory bm ON bm.bmin_equipid = pm.pmta_equipid
				LEFT JOIN xw_eqli_equipmentlist eql ON eql.eqli_equipmentlistid=bm.bmin_descriptionid
				LEFT JOIN xw_dept_department di ON di.dept_depid = bm.bmin_departmentid
				LEFT JOIN xw_riva_riskvalues rv ON rv.riva_riskid = bm.bmin_riskid
				LEFT JOIN xw_manu_manufacturers mf ON mf.manu_manlistid = bm.bmin_manufacturerid
				LEFT JOIN xw_dist_distributors dis ON dis.dist_distributorid = bm.bmin_distributorid $wherecol ";

		$query = $this->db->query($sql1);
		// echo $this->db->last_query(); die();
		
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();		
			return $data;		
		}		
		return false;

	}

	public function get_pm_completed_reports($searchcol=false)
	{
		    $fromdate=$this->input->post('frmDate');
			$toDate=$this->input->post('toDate');
			$equpid=$this->input->post('equid');
			if($searchcol)
			{ 
				$wherecol= "WHERE $searchcol";
				//print_r($wherecol);die;
			}
			else
			{
				$wherecol='';
			}
			$where='';
			if($fromdate && $toDate)
			{
				if(DEFAULT_DATEPICKER=='NP')
					{
						$fromdateen=$this->general->NepToEngDateConv($fromdate);
						$toDateen=$this->general->NepToEngDateConv($toDate);	
					}
				else
					{
						$fromdateen=$fromdate;
						$toDateen=$toDate;	
				}
				// $this->db->where(array('pmco_postdatead>='=>$fromdateen,'pmco_postdatead<='=>$toDateen));
				$where="WHERE pmco_postdatead >='".$fromdateen."' AND pmco_postdatead <= '".$toDateen."'";
			}

			// $sql1="SELECT pmco_equipid,eql.eqli_description,rv.riva_risk,di.dept_depname as dein_department, bm.bmin_equipmentkey,bm.bmin_modelno,bm.bmin_serialno,bm.bmin_amc,bm.bmin_isoperation,bm.bmin_ismaintenance,bm.bmin_servicedatebs,bm.bmin_endwarrantydatebs,bm.bmin_servicedatead,bm.bmin_endwarrantydatead,mf.manu_manlst,dis.dist_distributor from(	
				// 		SELECT pmta_equipid from xw_pmta_pmtable $where
				// 		group by pmta_equipid )pm  LEFT JOIN xw_bmin_bmeinventory bm ON bm.bmin_equipid = pm.pmta_equipid
				// 		LEFT JOIN xw_eqli_equipmentlist eql ON eql.eqli_equipmentlistid=bm.bmin_descriptionid
				// 		LEFT JOIN xw_dept_department di ON di.dept_depid = bm.bmin_departmentid
				// 		LEFT JOIN xw_riva_riskvalues rv ON rv.riva_riskid = bm.bmin_riskid
				// 		LEFT JOIN xw_manu_manufacturers mf ON mf.manu_manlistid = bm.bmin_manufacturerid
			// 		LEFT JOIN xw_dist_distributors dis ON dis.dist_distributorid = bm.bmin_distributorid $wherecol ";
			$sql1="SELECT * from(	
					SELECT pmco_pmcompletedid from xw_pmco_pmcompleted $where
					group by pmco_pmcompletedid )pm  LEFT JOIN xw_bmin_bmeinventory bm ON bm.bmin_equipid = pm.pmco_pmcompletedid
					LEFT JOIN xw_eqli_equipmentlist eql ON eql.eqli_equipmentlistid=bm.bmin_descriptionid
					LEFT JOIN xw_dept_department di ON di.dept_depid = bm.bmin_departmentid
					LEFT JOIN xw_riva_riskvalues rv ON rv.riva_riskid = bm.bmin_riskid
					LEFT JOIN xw_manu_manufacturers mf ON mf.manu_manlistid = bm.bmin_manufacturerid
					LEFT JOIN xw_dist_distributors dis ON dis.dist_distributorid = bm.bmin_distributorid $wherecol ";

			$query = $this->db->query($sql1);
			// echo $this->db->last_query(); die();
			if ($query->num_rows() > 0) 
			{
				$data=$query->result();		
				return $data;		
			}		
		return false;
	}

	public function get_repair_request_report($searchcol=false)
	{
	    $fromdate=$this->input->post('frmDate');
		$toDate=$this->input->post('toDate');
		$equpid=$this->input->post('equid');
		if($fromdate && $toDate)
		{
			if(DEFAULT_DATEPICKER=='NP')
				{
					$fromdateen=$this->general->NepToEngDateConv($fromdate);
					$toDateen=$this->general->NepToEngDateConv($toDate);	
				}
			else
				{
					$fromdateen=$fromdate;
					$toDateen=$toDate;	
			}
			$this->db->where("rere_postdatead >='".$fromdateen."' AND rere_postdatead <= '".$toDateen."'");
		}
		if($searchcol){
			$this->db->where($searchcol);
		}
		$this->db->select('re.*, dp.dept_depname,bm.bmin_modelno, bm.bmin_serialno,bm.bmin_equipmentkey, bm.bmin_endwarrantydatebs, bm.bmin_endwarrantydatead,bm.bmin_amc,bm.bmin_isoperation, bm.bmin_ismaintenance, mf.manu_manlst, r.riva_risk,eql.eqli_description');
		$this->db->from('rere_repairrequests re');
      $this->db->join('bmin_bmeinventory bm' , 'bm.bmin_equipid = re.rere_equid');
		$this->db->join('dept_department dp' , 'dp.dept_depid = bm.bmin_departmentid', 'LEFT');
	
		$this->db->join('manu_manufacturers mf', 'mf.manu_manlistid = re.rere_manufcontacted', 'LEFT');
		$this->db->join('riva_riskvalues r' , 'r.riva_riskid = bm.bmin_riskid', 'LEFT');
		$this->db->join('eqli_equipmentlist eql','eql.eqli_equipmentlistid=bm.bmin_descriptionid','LEFT');
		$query = $this->db->get();
		//echo $this->db->last_query(); die();
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();		
			return $data;		
		}		
		return false;
		
	}
	

	public function get_pm_detail_list($srchcol=false)
	{
		$month=$this->input->post('month');
		$year=$this->input->post('year');
    $week=$this->input->post('week');
    $date=$this->input->post('date');
    
		$type=$this->input->post('type');
		$this->db->select('vpm.*,pm.*,bm.bmin_equipid,bm.bmin_equipmentkey,bm.bmin_descriptionid,bm.bmin_modelno,bm.bmin_serialno,bm.bmin_departmentid,bm.bmin_riskid,bm.bmin_equip_oper,bm.bmin_manufacturerid,bm.bmin_distributorid,bm.bmin_amc,bm.bmin_servicedatead,bm.bmin_servicedatebs,bm.bmin_endwarrantydatead,bm.bmin_endwarrantydatebs,bm.bmin_purch_donatedid,bm.bmin_isoperation,bm.bmin_ismaintenance,bm.bmin_amcontractorid,bm.bmin_accessories ,bm.bmin_comments,bm.bmin_currencytypeid,bm.bmin_cost,bm.bmin_removed,bm.bmin_isprintsticker,bm.bmin_postdatead,bm.bmin_postdatebs,bm.bmin_posttime,bm.bmin_postmac,bm.bmin_postip,bm.bmin_postby,bm.bmin_modifydatead,bm.bmin_modifydatebs,bm.bmin_modifytime,bm.bmin_modifymac,bm.bmin_modifyip,bm.bmin_modifyby,bm.bmin_isunrepairable,bm.bmin_isdelete,eql.eqli_description,di.dept_depname as dein_department, mf.manu_manlst, ri.riva_risk,dis.dist_distributor, rd.rode_roomname');
		$this->db->from('vwpmdata vpm');
		$this->db->join('pmta_pmtable pm','vpm.pmta_equipid=pm.pmta_equipid AND vpm.pmta_pmdatead=pm.pmta_pmdatead ','LEFT');
		$this->db->join('bmin_bmeinventory bm' , 'bm.bmin_equipid = vpm.pmta_equipid','LEFT');
	 	$this->db->join('eqli_equipmentlist eql','eql.eqli_equipmentlistid=bm.bmin_descriptionid','LEFT');
  	$this->db->join('dept_department di','di.dept_depid=bm.bmin_departmentid','LEFT');
  	$this->db->join('manu_manufacturers mf','mf.manu_manlistid=bm.bmin_manufacturerid','LEFT');
  	$this->db->join('riva_riskvalues ri', 'ri.riva_riskid = bm.bmin_riskid', 'LEFT');
  	$this->db->join('dist_distributors dis', 'dis.dist_distributorid = bm.bmin_distributorid', 'LEFT');
    $this->db->join('rode_roomdepartment rd', 'rd.rode_roomdepartmentid = bm.bmin_roomid', 'LEFT');
	
		if($month)
		{
			$this->db->where('vpm.month',$month);
		}
		if($year)
		{
			$this->db->where('vpm.year',$year);
		}
    if($week)
    {
      $this->db->where('vpm.week',$week);
    }
    if($date)
    {
       $this->db->where('vpm.pmta_pmdatead',$date);
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
			$this->db->like('vpm.pmta_pmdatead',$datesrch, 'after');
		}
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
	
	
}