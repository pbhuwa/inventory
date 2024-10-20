<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Amc_data_mdl extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
    $this->load->library('upload');
		$this->table='amta_amctable';
    $this->sess_usercode = $this->session->userdata(USER_GROUPCODE);
    $this->sess_dept = $this->session->userdata(USER_DEPT);
	}

	public $validate_amc_data = array(  
	 	array('field' => 'amta_equipid', 'label' => 'Search And Add Data', 'rules' => 'trim|required|xss_clean'),            
        );
	
	public function save_amc_data()
	{
    // echo "<pre>"; print_r($this->input->post()); die;
		$pmArray = array();
		$postdata=$this->input->post();
		$id=$this->input->post('id');
		
		$pmdate = $this->input->post('amta_amcdate');
    $enddate= $this->input->post('amta_amcenddate');
   //print_r($enddate); die;
	 // $pmdatead = $this->input->post('amta_amcdatead');
		$remarks = $this->input->post('amta_remarks');
    // $amta_amcfile=$postdata['amta_amcfile']  = $this->amcfile;
    $amta_amccontractorid = $this->input->post('amta_amccontractorid');
    $amta_visit_plans = $this->input->post('amta_visitplans');

		$postid=$this->general->get_real_ipaddr();
		$postmac=$this->general->get_Mac_Address();

		$primary_id = $this->input->post('amctableid');
		$primary_id = '';

		unset($postdata['id']);
		unset($postdata['pmid']);
		unset($postdata['amta_amcdate']);
			// echo "<pre>";
			// print_r($pmid);
			// die();

		if(empty($primary_id)){
			if($pmdate){
         // print_r($_FILES);
          $amta_amcfile = $this->input->post('amta_amcfile');
              if(!empty($pmdate)):
              foreach($pmdate as $key=>$value):
                  $_FILES['attachments']['name'] = $_FILES['amta_amcfile']['name'][$key];
                  $_FILES['attachments']['type'] = $_FILES['amta_amcfile']['type'][$key];
                  $_FILES['attachments']['tmp_name'] = $_FILES['amta_amcfile']['tmp_name'][$key];
                  $_FILES['attachments']['error'] = $_FILES['amta_amcfile']['error'][$key];
                  $_FILES['attachments']['size'] = $_FILES['amta_amcfile']['size'][$key];
                  if(!empty($_FILES)){
                      $imgfile[]=$this->doupload('attachments');
                       // print_r($imgfile);die;
                  }else{
                      $imgfile = '';
                  }
              endforeach;
              endif;

				$curtime=$this->general->get_currenttime();

				$userid=$this->session->userdata(USER_ID);
				foreach($pmdate as $key=>$data){
					if(DEFAULT_DATEPICKER == 'NP'){
						$pmdatebs = !empty($pmdate[$key])?$pmdate[$key]:'';
						$pmdatead = $this->general->NepToEngDateConv(!empty($pmdate[$key])?$pmdate[$key]:'');

            $enddatebs = !empty($enddate[$key])?$enddate[$key]:'';
            $enddatead = $this->general->NepToEngDateConv(!empty($enddate[$key])?$enddate[$key]:'');
            
          
					}else{
						$pmdatead = !empty($pmdate[$key])?$pmdate[$key]:'';
						$pmdatebs = $this->general->EngToNepDateConv(!empty($pmdate[$key])?$pmdate[$key]:'');

              $enddatead = !empty($enddate[$key])?$enddate[$key]:'';
            $enddatebs = $this->general->EngToNepDateConv(!empty($enddate[$key])?$enddate[$key]:'');
          
					}
         


					$pmArray[] = array(
            
						'amta_amcdatebs'=>$pmdatebs,
						'amta_amcdatead'=>$pmdatead,
            'amta_amcenddatebs'=>$enddatebs,
            'amta_amcenddatead'=>$enddatead,
						'amta_remarks'=>!empty($remarks[$key])?$remarks[$key]:'',
						'amta_postdatead'=>CURDATE_EN,
						'amta_postdatebs'=>CURDATE_NP,
						'amta_posttime'=>$curtime,
						'amta_postby'=>$userid,
						'amta_postip'=>$postid,
						'amta_postmac'=>$postmac,
						'amta_orgid'=>$this->session->userdata(ORG_ID),
						'amta_equipid'=>$this->input->post("amta_equipid"),
            'amta_amccontractorid'=>$amta_amccontractorid,
            'amta_visitplans' =>$amta_visit_plans,
            'amta_amcfile'=>!empty($imgfile[$key])?$imgfile[$key]:'',

					);
				}
			}

			// echo "<pre>";
			// print_r($pmArray);
			// die;

			if(!empty($pmArray)){
	            $result = $this->db->insert_batch('xw_amta_amctable', $pmArray);

	            return true;
	        }
		}else{
			$updateArray = array();

			$pmid = $this->input->post('amta_amctableid');

			if($pmdate):
				$curtime=$this->general->get_currenttime();
				$userid=$this->session->userdata(USER_ID);
				foreach($pmdate as $key=>$data){
					if(DEFAULT_DATEPICKER == 'NP'){
						$pmdatebs = !empty($pmdate[$key])?$pmdate[$key]:'';
						$pmdatead = $this->general->NepToEngDateConv(!empty($pmdate[$key])?$pmdate[$key]:'');

            $enddatebs = !empty($enddate[$key])?$enddate[$key]:'';
            $enddatead = $this->general->NepToEngDateConv(!empty($enddate[$key])?$enddate[$key]:'');
					}else{
						$pmdatead = !empty($pmdate[$key])?$pmdate[$key]:'';
						$pmdatebs = $this->general->EngToNepDateConv(!empty($pmdate[$key])?$pmdate[$key]:'');
             $enddatead = !empty($enddate[$key])?$enddate[$key]:'';
            $enddatebs = $this->general->EngToNepDateConv(!empty($enddate[$key])?$enddate[$key]:'');
					}
					
					$updateArray[] = array(
						'amta_amctableid'=>!empty($pmid[$key])?$pmid[$key]:'',
						'amta_amcdatebs'=>$pmdatebs,
						'amta_amcdatead'=>$pmdatead,
            'amta_amcenddatebs'=>$enddatebs,
            'amta_amcenddatead'=>$enddatead,
						'amta_remarks'=>!empty($remarks[$key])?$remarks[$key]:'',
            'amta_amcfile'=>!empty($amta_amcfile[$key])?$amta_amcfile[$key]:'',
						'amta_modifydatead'=>CURDATE_EN,
						'amta_modifydatebs'=>CURDATE_NP,
						'amta_modifytime'=>$curtime,
						'amta_modifyby'=>$userid,
						'amta_modifyip'=>$postid,
						'amta_modifymac'=>$postmac,
            'amta_amcfile'=>!empty($amta_amcfile[$key])?$amta_amcfile[$key]:'',
						'amta_equipid'=>$this->input->post("amta_equipid")
					);
				}
			endif;
 			if(!empty($updateArray)){
                $this->db->update_batch('xw_amta_amctable', $updateArray,'amta_amctableid');
                return true;
            }
		}
		
		return false;
	
	}
   
    public function doupload($file) {
        // echo "test";
        // die();
        $config['upload_path'] = './'.AMC_UPLOAD_PATH;//define in constants
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


	public function edit_amc_data($editid = false){
		$postdata = array();
		$postdata = $this->input->post();

		// echo $editid;
		// die();

		$postid=$this->general->get_real_ipaddr();
		$postmac=$this->general->get_Mac_Address();

		$pmdate = $this->input->post('amta_amcdatebs');

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


		$pmremarks = $this->input->post('amta_remarks');

		unset($postdata['modal_editid']);

		$postdata['amta_amcdatebs'] = $pmdatebs;
		$postdata['amta_amcdatead'] = $pmdatead;
		$postdata['amta_remarks'] = $pmremarks;
		$postdata['amta_modifydatead']=CURDATE_EN;
		$postdata['amta_modifydatebs']=CURDATE_NP;
		$postdata['amta_modifytime']=$this->general->get_currenttime();
		$postdata['amta_modifyby']=$this->session->userdata(USER_ID);
		$postdata['amta_modifyip']=$postid;
		$postdata['amta_modifymac']=$postmac;
		// $postdata['amta_equipid']=$this->input->post("amta_equipid");

		if(!empty($postdata)){
			$this->db->update($this->table,$postdata,array('amta_amctableid'=>$editid));
		}
		return true;
	}


	public function get_all_amc_data($srchcol=false)
	{
		$this->db->select('amc.*');
		$this->db->from('amta_amctable amc');
		
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
    
   


	public function remove_amc_data()
	{
		$id=$this->input->post('id');
		if($id)
		{
      //$this->db->delete('$this->table',array('amta_amctableid'=>$id));
			$this->db->delete('eqco_equipmentcomment',array('eqco_equipmentcommentid'=>$id));
			$rowaffected=$this->db->affected_rows();
			if($rowaffected)
			{
				return $rowaffected;
			}
			return false;
		}
		return false;
	}

	public function get_amc_data_list()
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

	public function get_all_amc_summary($srchcol=false,$othersrch=false)
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
      
        //$this->db->where('amta_amcdatead <=', $add_date);

      $this->db->select("*");
    	 $this->db->from('amta_amctable amc');
    	 $this->db->join('bmin_bmeinventory bm','bm.bmin_equipid = amc.amta_equipid','LEFT');
    	 $this->db->join('eqli_equipmentlist eql','eql.eqli_equipmentlistid=bm.bmin_descriptionid','LEFT');
    	 $this->db->join('dept_department di','di.dept_depid = bm.bmin_departmentid','LEFT');
    	 $this->db->join('riva_riskvalues rv','rv.riva_riskid=bm.bmin_riskid','LEFT');
    	 $this->db->join('dist_distributors dis','dis.dist_distributorid = amc.amta_amccontractorid','LEFT');
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

    	  $this->db->group_by('amc.amta_equipid');
    
	
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

        $this->db->select("amc.*,amta_equipid,rv.riva_risk,bm.bmin_equipmentkey,bm.bmin_modelno,bm.bmin_serialno,bm.bmin_amc,bm.bmin_isoperation,bm.bmin_ismaintenance,bm.bmin_servicedatebs,bm.bmin_endwarrantydatebs,bm.bmin_servicedatead,bm.bmin_endwarrantydatead,eql.eqli_description, rv.riva_risk,di.dept_depname AS dein_department,mf.manu_manlst,dis.dist_distributor, rd.rode_roomname");
    	 $this->db->from('amta_amctable amc');
    	 $this->db->join('bmin_bmeinventory bm','bm.bmin_equipid = amc.amta_equipid','LEFT');
    	  $this->db->join('eqli_equipmentlist eql','eql.eqli_equipmentlistid=bm.bmin_descriptionid','LEFT');
    	 $this->db->join('dept_department di','di.dept_depid = bm.bmin_departmentid','LEFT');
    	 $this->db->join('riva_riskvalues rv','rv.riva_riskid=bm.bmin_riskid','LEFT');
    	$this->db->join('dist_distributors dis','dis.dist_distributorid = amc.amta_amccontractorid','LEFT');
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
    	 $this->db->group_by('amc.amta_equipid');

        $this->db->order_by($order_by,$order);
        // $this->db->group_by('amta_equipid');
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
	   //  echo $this->db->last_query();die();
	    return $ndata;
	}

  public function get_all_amc_detail($srchcol=false,$othersrch=false)
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
             if(!empty($get['sSearch_8'])){
          $this->db->where("amc.amta_postdatead like  '%".$get['sSearch_8']."%'  ");
        }
             if(!empty($get['sSearch_9'])){
          $this->db->where("amc.amta_postdatebs like  '%".$get['sSearch_9']."%'  ");
        }


  if(($this->sess_usercode != 'SA') && ($this->sess_usercode != 'AD')){
 
          $new_sess_dept = explode(',',$this->sess_dept);
          $this->db->where_in('dept_depid',$new_sess_dept);
        }

      
        //$this->db->where('amta_amcdatead <=', $add_date);

        $this->db->select("*");
       $this->db->from('amta_amctable amc');
       $this->db->join('bmin_bmeinventory bm','bm.bmin_equipid = amc.amta_equipid','LEFT');
       $this->db->join('eqli_equipmentlist eql','eql.eqli_equipmentlistid=bm.bmin_descriptionid','LEFT');
       $this->db->join('dept_department di','di.dept_depid = bm.bmin_departmentid','LEFT');
       $this->db->join('riva_riskvalues rv','rv.riva_riskid=bm.bmin_riskid','LEFT');
       $this->db->join('dist_distributors dis','dis.dist_distributorid = amc.amta_amccontractorid','LEFT');
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
         else if($this->input->get('iSortCol_0')==8)
          $order_by = 'amta_postdatead';
        
         else if($this->input->get('iSortCol_0')==9)
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
             if(!empty($get['sSearch_8'])){
          $this->db->where("amc.amta_postdatead like  '%".$get['sSearch_8']."%'  ");
        }
             if(!empty($get['sSearch_9'])){
          $this->db->where("amc.amta_postdatbs like  '%".$get['sSearch_9']."%'  ");
        }


        $this->db->select("amc.*,rv.riva_risk,bm.bmin_equipmentkey,bm.bmin_modelno,bm.bmin_serialno,bm.bmin_amc,bm.bmin_isoperation,bm.bmin_ismaintenance,bm.bmin_servicedatebs,bm.bmin_endwarrantydatebs,bm.bmin_servicedatead,bm.bmin_endwarrantydatead,eql.eqli_description, rv.riva_risk,di.dept_depname AS dein_department,mf.manu_manlst,dis.dist_distributor, rd.rode_roomname");
       $this->db->from('amta_amctable amc');
       $this->db->join('bmin_bmeinventory bm','bm.bmin_equipid = amc.amta_equipid','LEFT');
        $this->db->join('eqli_equipmentlist eql','eql.eqli_equipmentlistid=bm.bmin_descriptionid','LEFT');
       $this->db->join('dept_department di','di.dept_depid = bm.bmin_departmentid','LEFT');
       $this->db->join('riva_riskvalues rv','rv.riva_riskid=bm.bmin_riskid','LEFT');
       $this->db->join('dist_distributors dis','dis.dist_distributorid = amc.amta_amccontractorid','LEFT');
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
      // $this->db->group_by('amc.amta_equipid');

        $this->db->order_by($order_by,$order);
        // $this->db->group_by('amta_equipid');
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
       //echo $this->db->last_query();die();
      return $ndata;
  }



	public function get_amc_data_reports($searchcol=false)
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

			$where="WHERE amta_amcdatead >='".$fromdateen."' AND amta_amcdatead <= '".$toDateen."'";
		}

		$sql1="SELECT amta_equipid,eql.eqli_description,rv.riva_risk,di.dept_depname as dein_department, bm.bmin_equipmentkey,bm.bmin_modelno,bm.bmin_serialno,bm.bmin_amc,bm.bmin_isoperation,bm.bmin_ismaintenance,bm.bmin_servicedatebs,bm.bmin_endwarrantydatebs,bm.bmin_servicedatead,bm.bmin_endwarrantydatead,mf.manu_manlst,dis.dist_distributor from(	
				SELECT amta_equipid from xw_amta_amctable $where
				group by amta_equipid )pm  LEFT JOIN xw_bmin_bmeinventory bm ON bm.bmin_equipid = amc.amta_equipid
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
				// 		SELECT amta_equipid from xw_amta_amctable $where
				// 		group by amta_equipid )pm  LEFT JOIN xw_bmin_bmeinventory bm ON bm.bmin_equipid = amc.amta_equipid
				// 		LEFT JOIN xw_eqli_equipmentlist eql ON eql.eqli_equipmentlistid=bm.bmin_descriptionid
				// 		LEFT JOIN xw_dept_department di ON di.dept_depid = bm.bmin_departmentid
				// 		LEFT JOIN xw_riva_riskvalues rv ON rv.riva_riskid = bm.bmin_riskid
				// 		LEFT JOIN xw_manu_manufacturers mf ON mf.manu_manlistid = bm.bmin_manufacturerid
			// 		LEFT JOIN xw_dist_distributors dis ON dis.dist_distributorid = bm.bmin_distributorid $wherecol ";
			$sql1="SELECT * from(	
					SELECT pmco_pmcompletedid from xw_pmco_pmcompleted $where
					group by pmco_pmcompletedid )pm  LEFT JOIN xw_bmin_bmeinventory bm ON bm.bmin_equipid = amc.pmco_pmcompletedid
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
		$this->db->select('vamc.*,amc.*,bm.bmin_equipid,bm.bmin_equipmentkey,bm.bmin_descriptionid,bm.bmin_modelno,bm.bmin_serialno,bm.bmin_departmentid,bm.bmin_riskid,bm.bmin_equip_oper,bm.bmin_manufacturerid,bm.bmin_distributorid,bm.bmin_amc,bm.bmin_servicedatead,bm.bmin_servicedatebs,bm.bmin_endwarrantydatead,bm.bmin_endwarrantydatebs,bm.bmin_purch_donatedid,bm.bmin_isoperation,bm.bmin_ismaintenance,bm.bmin_amcontractorid,bm.bmin_accessories ,bm.bmin_comments,bm.bmin_currencytypeid,bm.bmin_cost,bm.bmin_removed,bm.bmin_isprintsticker,bm.bmin_postdatead,bm.bmin_postdatebs,bm.bmin_posttime,bm.bmin_postmac,bm.bmin_postip,bm.bmin_postby,bm.bmin_modifydatead,bm.bmin_modifydatebs,bm.bmin_modifytime,bm.bmin_modifymac,bm.bmin_modifyip,bm.bmin_modifyby,bm.bmin_isunrepairable,bm.bmin_isdelete,eql.eqli_description,di.dept_depname as dein_department, mf.manu_manlst, ri.riva_risk,dis.dist_distributor, rd.rode_roomname');
		$this->db->from('vwpmdata vpm');
		$this->db->join('amta_amctable amc','vamc.amta_equipid=amc.amta_equipid AND vamc.amta_amcdatead=amc.amta_amcdatead ','LEFT');
		$this->db->join('bmin_bmeinventory bm' , 'bm.bmin_equipid = vamc.amta_equipid','LEFT');
	 	$this->db->join('eqli_equipmentlist eql','eql.eqli_equipmentlistid=bm.bmin_descriptionid','LEFT');
  	$this->db->join('dept_department di','di.dept_depid=bm.bmin_departmentid','LEFT');
  	$this->db->join('manu_manufacturers mf','mf.manu_manlistid=bm.bmin_manufacturerid','LEFT');
  	$this->db->join('riva_riskvalues ri', 'ri.riva_riskid = bm.bmin_riskid', 'LEFT');
  	$this->db->join('dist_distributors dis', 'dis.dist_distributorid = bm.bmin_distributorid', 'LEFT');
    $this->db->join('rode_roomdepartment rd', 'rd.rode_roomdepartmentid = bm.bmin_roomid', 'LEFT');
	
		if($month)
		{
			$this->db->where('vamc.month',$month);
		}
		if($year)
		{
			$this->db->where('vamc.year',$year);
		}
    if($week)
    {
      $this->db->where('vamc.week',$week);
    }
    if($date)
    {
       $this->db->where('vamc.amta_amcdatead',$date);
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
			$this->db->like('vamc.amta_amcdatead',$datesrch, 'after');
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
	
  public function get_amc_summary_assets($srchcol=false,$othersrch=false)
  {
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
          $this->db->where("dept_depname like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
          $this->db->where("asen_brand like  '%".$get['sSearch_4']."%'  ");
        }

        if(!empty($get['sSearch_5'])){
          $this->db->where("asst_statusname like  '%".$get['sSearch_5']."%'  ");
        }
        if(!empty($get['sSearch_6'])){
          $this->db->where("manu_manlst like  '%".$get['sSearch_6']."%'  ");
        }
           if(!empty($get['sSearch_7'])){
          $this->db->where("dist_distributor like  '%".$get['sSearch_7']."%'  ");
        }
             if(!empty($get['sSearch_8'])){
          $this->db->where("amta_postdatead like  '%".$get['sSearch_8']."%'  ");
        }
             if(!empty($get['sSearch_9'])){
          $this->db->where("amta_postdatebs like  '%".$get['sSearch_9']."%'  ");
        }
    

        //$this->db->where('amta_amcdatead <=', $add_date);

           if(($this->sess_usercode != 'SA') && ($this->sess_usercode != 'AD')){
           $new_sess_dept = explode(',',$this->sess_dept);
          $this->db->where_in('dept_depid',$new_sess_dept);
        }

        $this->db->select("*");
        $this->db->from('amta_amctable amc');
        $this->db->join('asen_assetentry aet','aet.asen_asenid=amc.amta_equipid','LEFT');
        $this->db->join('asst_assetstatus as','aet.asen_status=as.asst_asstid','LEFT');
        $this->db->join('eqco_equipmentcomment eco','eco.eqco_eqid=aet.asen_asenid');
        $this->db->join('eqas_equipmentassign ea','ea.eqas_equipid=eco.eqco_eqid','LEFT');
        $this->db->join('dept_department dp','dp.dept_depid=ea.eqas_equipdepid','LEFT');
        $this->db->join('itli_itemslist it','it.itli_itemlistid=aet.asen_description','LEFT');
        $this->db->join('manu_manufacturers mn','mn.manu_manlistid=asen_manufacture','LEFT');
        $this->db->join('dist_distributors dt','dt.dist_distributorid=asen_distributor','LEFT');
       
      if(($this->sess_usercode != 'SA') && ($this->sess_usercode != 'AD')){
           $new_sess_dept = explode(',',$this->sess_dept);
          $this->db->where_in('dept_depid',$new_sess_dept);
        }
       if($srchcol)
       {
        $this->db->where($srchcol);
       }
       if($othersrch)
       {
        $this->db->where($othersrch);
       }

        $this->db->group_by('amc.amta_equipid');
    
 
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
          $order_by = 'dept_depname';
        else if($this->input->get('iSortCol_0')==4)
          $order_by = 'asen_brand';
       else if($this->input->get('iSortCol_0')==5)
          $order_by = 'asst_statusname';
        else if($this->input->get('iSortCol_0')==6)
          $order_by = 'manu_manlst';
        else if($this->input->get('iSortCol_0')==7)
          $order_by = 'dist_distributor';
        else if($this->input->get('iSortCol_0')==8)
          $order_by = 'amta_postdatead';
        else if($this->input->get('iSortCol_0')==9)
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
          $this->db->where("dept_depname like  '%".$get['sSearch_3']."%'  ");
        }
        if(!empty($get['sSearch_4'])){
          $this->db->where("asen_brand like  '%".$get['sSearch_4']."%'  ");
        }

        if(!empty($get['sSearch_5'])){
          $this->db->where("asst_statusname like  '%".$get['sSearch_5']."%'  ");
        }
        if(!empty($get['sSearch_6'])){
          $this->db->where("manu_manlst like  '%".$get['sSearch_6']."%'  ");
        }
           if(!empty($get['sSearch_7'])){
          $this->db->where("dist_distributor like  '%".$get['sSearch_7']."%'  ");
        }
             if(!empty($get['sSearch_8'])){
          $this->db->where("amta_postdatead like  '%".$get['sSearch_8']."%'  ");
        }
             if(!empty($get['sSearch_9'])){
          $this->db->where("amta_postdatebs like  '%".$get['sSearch_9']."%'  ");
        }
        

        $this->db->select("amc.*,asen_assetcode as bmin_equipmentkey,asen_brand as rode_roomname,asst_statusname as riva_risk,itli_itemname as eqli_description, dist_distributor, manu_manlst,dept_depname as dein_department");
       $this->db->from('amta_amctable amc');
      $this->db->join('asen_assetentry aet','aet.asen_asenid=amc.amta_equipid','LEFT');
      $this->db->join('asst_assetstatus as','aet.asen_status=as.asst_asstid','LEFT');
      $this->db->join('eqco_equipmentcomment eco','eco.eqco_eqid=aet.asen_asenid');
      $this->db->join('eqas_equipmentassign ea','ea.eqas_equipid=eco.eqco_eqid','LEFT');
      $this->db->join('dept_department dp','dp.dept_depid=ea.eqas_equipdepid','LEFT');
       $this->db->join('itli_itemslist it','it.itli_itemlistid=aet.asen_description','LEFT');
       $this->db->join('manu_manufacturers mn','mn.manu_manlistid=asen_manufacture','LEFT');
       $this->db->join('dist_distributors dt','dt.dist_distributorid=asen_distributor','LEFT');
      if(($this->sess_usercode != 'SA') && ($this->sess_usercode != 'AD')){
           $new_sess_dept = explode(',',$this->sess_dept);
          $this->db->where_in('dept_depid',$new_sess_dept);
        }
        if($srchcol)
       {
        $this->db->where($srchcol);
       }
        if($othersrch)
       {
        $this->db->where($othersrch);
       }
       $this->db->group_by('amc.amta_equipid');

        // $this->db->order_by($order_by,$order);
        // // $this->db->group_by('amta_equipid');
        // if($limit && $limit>0)
        // {  
        //     $this->db->limit($limit);
        // }
        // if($offset)
        // {
        //     $this->db->offset($offset);
        // }

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
     //  echo $this->db->last_query();die();
      return $ndata;
  }
	
}