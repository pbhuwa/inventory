<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Permission_mdl extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
		$this->table='mope_modulespermission';
	}


	
	
	function save_perm(){		 
	
	$module_id=$this->input->post('module_id');
    $user_group=$this->input->post('user_group');
    $ugrpid=$this->input->post('ugrpid');
    $actionadd=$this->input->post('actionadd');
    $mac=$this->general->get_Mac_Address();
    $ip=$this->general->get_real_ipaddr();
    $permisson=$this->checkprev_permission($ugrpid,$module_id);
    if(!empty($permisson))
    {
    	if($actionadd=='true')
		{
			$postdata['mope_modifydatead']=CURDATE_EN;
			$postdata['mope_modifydatebs']=CURDATE_NP;
			$postdata['mope_modifytime']=$this->general->get_currenttime();
			$postdata['mope_modifyby']=$this->session->userdata(USER_ID);
			$postdata['mope_modifymac']=$mac;
			$postdata['mope_modifyip']=$ip;
			$postdata['mope_hasaccess']=1;
			$postdata['mope_insert']='Y';
			$postdata['mope_update']='Y';
			$postdata['mope_delete']='Y';
			$postdata['mope_view']='Y';
			$postdata['mope_orgid']=$this->session->userdata(ORG_ID);
			if($this->db->update($this->table,$postdata,array('mope_usergroupid'=>$ugrpid,'mope_moduleid'=>$module_id)))
			{
				return $this->db->affected_rows();
			}
			else
			{
			return false;
			}
		
		}else{
			$postdata['mope_modifydatead']=CURDATE_EN;
			$postdata['mope_modifydatebs']=CURDATE_NP;
			$postdata['mope_modifytime']=$this->general->get_currenttime();
			$postdata['mope_modifyby']=$this->session->userdata(USER_ID);
			$postdata['mope_modifymac']=$mac;
			$postdata['mope_modifyip']=$ip;
			$postdata['mope_hasaccess']=0;
			$postdata['mope_insert']='N';
			$postdata['mope_update']='N';
			$postdata['mope_delete']='N';
			$postdata['mope_view']='N';
			$postdata['mope_orgid']=$this->session->userdata(ORG_ID);
			if($this->db->update($this->table,$postdata,array('mope_usergroupid'=>$ugrpid,'mope_moduleid'=>$module_id)))
			{
				return $this->db->affected_rows();
			}
		else
			{
			return false;
			}
		
		}
    }
    else
    {
    	$postdata['mope_usergroupid']=$ugrpid;
		$postdata['mope_usergroup']=$user_group;
		$postdata['mope_moduleid']=$module_id;
		$postdata['mope_postdatead']=CURDATE_EN;
		$postdata['mope_postdatebs']=CURDATE_NP;
		$postdata['mope_posttime']=$this->general->get_currenttime();
		$postdata['mope_postby']=$this->session->userdata(USER_ID);
		$postdata['mope_postmac']=$mac;
		$postdata['mope_postip']=$ip;
		$postdata['mope_hasaccess']=1;
		$postdata['mope_insert']='Y';
		$postdata['mope_update']='Y';
		$postdata['mope_delete']='Y';
		$postdata['mope_view']='Y';
		$postdata['mope_orgid']=$this->session->userdata(ORG_ID);
		$postdata['mope_locationid']= $this->session->userdata(LOCATION_ID);
		if($this->db->insert($this->table,$postdata))
		{
			return $this->db->insert_id();
		}
		return false;
    }

		
	}

	public function save_all_permission()
	{
		// $postdata=$this->input->post();
		// echo "<pre>";
		// print_r($postdata);
		// die();
		$group_id= $this->input->post('grp_id');
		$group_name= $this->get_user_group_name($group_id);
		// echo $group_name;
		// die();
		$moduleid=$this->input->post('module');
		$insert=$this->input->post('insert');
		$view=$this->input->post('view');
		$update=$this->input->post('update');
		$delete=$this->input->post('delete');
		$verified=$this->input->post('verified');
		$approved=$this->input->post('approved');
		$modifydatead=CURDATE_EN;
		$modifydatebs=CURDATE_NP;
		$postdatead=CURDATE_EN;
		$postdatebs=CURDATE_NP;
		$cur_time=$this->general->get_currenttime();
		$mac=$this->general->get_Mac_Address();
    	$ip=$this->general->get_real_ipaddr();
    	$userid=$this->session->userdata(USER_ID);
		$orgid=$this->session->userdata(ORG_ID);
		$locationid=$this->session->userdata(LOCATION_ID);
		$modarray=array();
		$this->db->trans_start();

		if(!empty($moduleid))
		{
			foreach ($moduleid as $km => $modu) {
				$modarray[]=$km;
			}
		}
		// echo "<pre>";
		// print_r($modarray);
		// die();

		 $db_permission_model=$this->get_permissionlist($group_id);
		// echo "<pre>";
		// print_r($moduleid);
		// die();
		   // echo "<pre>";
		   // print_r($db_permission_model);
		   // die();

		    if($db_permission_model)
            {
                $diffmodid = array_diff($db_permission_model, $modarray);
                // echo "Diff.<pre>";
                // print_r($diffmodid);
                // die();
             if(!empty($diffmodid))
              {
              	foreach($diffmodid  as $fmod){
                 $difmid=$fmod;
                    $dataArray=array(
                        'mope_hasaccess'=>0,
                        'mope_insert'=>'N',
                        'mope_view'=>'N',
                        'mope_update'=>'N',
                        'mope_delete'=>'N',
                        'mope_approve'=>'N',
                        'mope_verified'=>'N',
                        'mope_modifydatead'=>$modifydatead,
                        'mope_modifydatebs'=>$modifydatebs,
                        'mope_modifytime'=>$cur_time,
                        'mope_modifyby'=>$userid,
                        'mope_modifyip'=>$ip,
                        'mope_modifymac'=>$mac);
                   $this->db->update($this->table,$dataArray,array('mope_usergroupid'=>$group_id,'mope_moduleid'=>$difmid,'mope_locationid'=>$locationid,'mope_orgid'=>$orgid));
                }
                // die();
                }
            }

            $dataArray[]=array();
            if(!empty($modarray))
            {
                foreach($modarray  as $mod){
                    $modid=$mod;
                    // echo $modid;
                    // die();
                    $insert_st=!empty($insert[$mod])?$insert[$mod]:'N';

                    // echo $insert;
                    $view_st=!empty($view[$mod])?$view[$mod]:'N';
                    $update_st=!empty($update[$mod])?$update[$mod]:'N';
                    $delete_st=!empty($delete[$mod])?$delete[$mod]:'N';
                    $approved_st=!empty($approved[$mod])?$approved[$mod]:'N';
                    $verified_st =!empty($verified[$mod])?$verified[$mod]:'N';
                    
                    if($insert_st=='N' &&  $view_st=='N' && $update_st=='N' &&  $delete_st=='N' && $approved_st=='N' && $verified_st=='N' ){
                      $chk_child=$this->chek_module_child($modid);
                      if($chk_child)
                      {
                         $hasaccess=1;
                      }
                      else
                      {
                         $hasaccess=0;
                      }
                       
                    }
                    else
                    {
                        $hasaccess=1;
                    }
                    // echo $hasaccess;


                    if(in_array($modid,$db_permission_model))
                    {
                        $dataArray=array(
                            'mope_usergroupid'=>$group_id,
                            'mope_moduleid'=>$modid,
                            'mope_hasaccess'=>$hasaccess,
                            'mope_insert'=>$insert_st,
                            'mope_update'=>$update_st,
                            'mope_delete'=>$delete_st,
                            'mope_view'=>$view_st,
                            'mope_verified'=>$verified_st,
                            'mope_approve'=>$approved_st,
                            'mope_modifydatead'=>$modifydatead,
                            'mope_modifydatebs'=>$modifydatebs,
                            'mope_modifytime'=>$cur_time,
                            'mope_modifyby'=>$userid,
                            'mope_modifyip'=>$ip,
                            'mope_modifymac'=>$mac,
                        );
                        //   echo "<pre>";
                        // print_r($dataArray);
                        // die();
                         $dataArray=array_filter($dataArray);
                        if(!empty($dataArray))
                        {
                        	$this->db->update('mope_modulespermission',$dataArray,array('mope_moduleid'=>$modid,'mope_usergroupid'=>$group_id,'mope_orgid'=>$orgid,'mope_locationid'=>$locationid));
                           
                        }
                    }

                    else
                    {
                        $dataArray=array(
                            'mope_usergroupid'=>$group_id,
                            'mope_usergroup'=>$group_name,
                            'mope_moduleid'=>$modid,
                            'mope_hasaccess'=>$hasaccess,
                            'mope_insert'=>$insert_st,
                            'mope_update'=>$update_st,
                            'mope_delete'=>$delete_st,
                            'mope_view'=>$view_st,
                            'mope_verified'=>$verified_st,
                            'mope_approve'=>$approved_st,
                            'mope_postip'=>$ip,
                            'mope_postmac'=>$mac,
                            'mope_postdatead'=>$postdatead,
                            'mope_postdatebs'=>$postdatebs,
                            'mope_posttime'=>$cur_time,
                            'mope_postby'=>$userid,
                            'mope_locationid'=>$locationid,
                            'mope_orgid'=>$orgid
                        );
                        // echo "<pre>";
                        // print_r($dataArray);
                        // die();
                         $dataArray=array_filter($dataArray);
                         if(!empty($dataArray))
                        {
                        	$this->db->insert('mope_modulespermission',$dataArray);
                        }

                    }
                }
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

	public function get_user_group_name($gid)
	{
		$this->db->select('usgr_usergroup');
		$this->db->from('usgr_usergroup ug');
		$this->db->where('usgr_usergroupid',$gid);
		$query = $this->db->get();
		$ret = $query->row();
		return $ret->usgr_usergroup;


	}

	public function chek_module_child($modid)
	{
    	$query=$this->db->get_where('modu_modules',array('modu_parentmodule'=>$modid));
    	// echo $this->db->last_query();
    	// die();
       
      if($query->num_rows()>0)
      {
        return 1;
      }
      return 0;
  	}


	public function get_permissionlist($grid)
	{
		$this->db->select('mope_modulespermissionid,mope_moduleid');
		$this->db->from('mope_modulespermission');
		$this->db->where(array('mope_hasaccess'=>1,'mope_usergroupid'=>$grid));
		$data= $this->db->get()->result();
		// echo "<pre>";
		// print_r($data);
		// die();
		$arrPer=array();
		if(!empty($data))
		{
			foreach ($data as $kd => $val) {
				$arrPer[]=$val->mope_moduleid;
			}
		}
		return $arrPer;

			
	}

	public function gets_permission()
	{
		try{			
			$data=$this->db->get_where($this->table,array('mope_hasaccess'=>1))->result();
			return $data;
		   }catch(Exception $e)
			{
				return array();
			}
	}

	public function checkprev_permission($ugrpid,$module_id)
	{
		try{			
			$data=$this->db->get_where($this->table,array('mope_usergroupid'=>$ugrpid,'mope_moduleid'=>$module_id,'mope_orgid'=>$this->session->userdata(ORG_ID)))->result();
			return $data;
		   }catch(Exception $e)
			{
				return array();
			}
	}

	public function update_perm()
	{
		$module_id=$this->input->post('module_id');
	    $user_group=$this->input->post('user_group');
	    $ugrpid=$this->input->post('ugrpid');
	    $actionadd=$this->input->post('actionadd');
	    $operation=$this->input->post('operation');
	    $mac=$this->general->get_Mac_Address();
		$ip=$this->general->get_real_ipaddr();
		if($actionadd=='true')
		{
			if($operation=='View')
			{
				$postdata['mope_view']='Y';
			}
			if($operation=='Insert')
			{
				$postdata['mope_insert']='Y';
			}
			if($operation=='Update')
			{
			$postdata['mope_update']='Y';
			}
			if($operation=='Delete')
			{
				$postdata['mope_delete']='Y';
			}
			if($operation=='Approved')
			{
				$postdata['mope_approve']='Y';
			}
			if($operation=='Verified')
			{
				$postdata['mope_verified']='Y';
			}

			$postdata['mope_modifydatead']=CURDATE_EN;
			$postdata['mope_modifydatebs']=CURDATE_NP;
			$postdata['mope_modifytime']=$this->general->get_currenttime();
			$postdata['mope_modifyby']=$this->session->userdata(USER_ID);
			$postdata['mope_modifymac']=$mac;
			$postdata['mope_modifyip']=$ip;
			if($this->db->update($this->table,$postdata,array('mope_usergroupid'=>$ugrpid,'mope_moduleid'=>$module_id)))
			{
				return $this->db->affected_rows();
			}
			else
			{
			return false;
			}
		
		}else{
			if($operation=='View')
			{
				$postdata['mope_view']='N';
			}
			if($operation=='Insert')
			{
				$postdata['mope_insert']='N';
			}
			if($operation=='Update')
			{
			$postdata['mope_update']='N';
			}
			if($operation=='Delete')
			{
				$postdata['mope_delete']='N';
			}
			if($operation=='Approved')
			{
				$postdata['mope_approve']='N';
			}

			$postdata['mope_modifydatead']=CURDATE_EN;
			$postdata['mope_modifydatebs']=CURDATE_NP;
			$postdata['mope_modifytime']=$this->general->get_currenttime();
			$postdata['mope_modifyby']=$this->session->userdata(USER_ID);
			$postdata['mope_modifymac']=$mac;
			$postdata['mope_modifyip']=$ip;
		
			if($this->db->update($this->table,$postdata,array('mope_usergroupid'=>$ugrpid,'mope_moduleid'=>$module_id)))
			{
				return $this->db->affected_rows();
			}
	}
}

	
}