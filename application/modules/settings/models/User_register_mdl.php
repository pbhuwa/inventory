<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_register_mdl extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
		$this->table='usre_userregister';
		$this->load->library('upload');
		$this->locationid=$this->session->userdata(LOCATION_ID);
		$this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
		
	}


	public $validate_settings_user_reg = array(               
		array('field' => 'usre_username', 'label' => 'UsersName', 'rules' => 'trim|required|xss_clean|is_unique[usre_userregister.usre_username]'),
		array('field' => 'usre_userpassword', 'label' => 'Password', 'rules' => 'trim|required|xss_clean'),
		
	);
	public	 $validate_settings_users_approved = array(               
		array('field' => 'usma_username', 'label' => 'UsersName', 'rules' => 'trim|required|xss_clean|is_unique[usma_usermain.usma_username]')

	);
	public function exit_user_name($username=false)
	{
		$this->db->select('usma_username');
		$this->db->where('usma_username',$username);
		$query = $this->db->get('usma_usermain');

		if ($query->num_rows() > 0) 
		{
			$data=$query->result();     
			return true;       
		}       
		return false;
	}
		

	
	public function user_reg_save()
	{
		$this->userid = $this->session->userdata(USER_ID);
		$this->username = $this->session->userdata(USER_NAME);
		$postdata=$this->input->post();
		$id=$this->input->post('id');
		$locationid=$this->input->post('usre_locationid');
		// $locationid=$this->session->userdata(LOCATION_ID);
		$depname=$this->input->post('usre_departmentid');
		$dashboard=$this->input->post('dashboard');

		// echo "<pre>";
		// print_r($dashboard);
		// die();
		$depid='';
		if(!empty($depname))
		{
			$depid=implode(',', $depname);   
		}

		if(!empty($dashboard))
		{
			$dasboardid=implode(',', $dashboard);   
		}
		
		// echo $depid;
		// die();

		unset($postdata['usre_departmentid']);
		unset($postdata['dashboard']);

		// echo $id;
		// die();

		$salt = $this->general->salt();		
		// echo $salt;
		// die();
		$password=$this->input->post('usre_userpassword');
		$postid=$this->general->get_real_ipaddr();
		$postmac=$this->general->get_Mac_Address();
		$staffdepid=$this->input->post('usre_departmentid');
		$groupid=$this->input->post('usre_usergroupid');

		$old_signaturepath = $this->input->post('usre_oldsignaturepath');
		
		unset($postdata['usre_oldsignaturepath']);
		unset($postdata['id']);
		unset($postdata['usre_userpassword']);
		unset($postdata['usre_conformpassword']);
		if($id)
		{
			$this->db->trans_start();
			$postdata['usre_modifydatead']=CURDATE_EN;
			$postdata['usre_modifydatebs']=CURDATE_NP;
			$postdata['usre_modifytime']=date('H:i:s');
			$postdata['usre_modifyby']=$this->session->userdata(USER_ID);
			$postdata['usre_modifyip']=$postid;
			$postdata['usre_modifymac']=$postmac;
			$postdata['usre_departmentid']=$depid;
			$postdata['usre_dashboard']=$dasboardid;
			$postdata['usre_signaturepath']=!empty($this->signatureupload)?$this->signatureupload:$old_signaturepath;

			if(!empty($postdata))
			{
				$this->db->update($this->table,$postdata,array('usre_userid'=>$id));
				$rowaffected=$this->db->affected_rows();
				if($rowaffected)
				{
				// return $rowaffected;

				}
				else
				{
					return false;
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
		else
		{
			$postdata['usre_salt']=$salt;
			$postdata['usre_userpassword']=$password;
			$postdata['usre_postdatead']=CURDATE_EN;
			$postdata['usre_postdatebs']=CURDATE_NP;
			$postdata['usre_posttime']=date('H:i:s');
			$postdata['usre_orgid']=$this->session->userdata(ORG_ID);
			$postdata['usre_postby']=$this->session->userdata(USER_ID);
			$postdata['usre_postip']=$postid;
			$postdata['usre_postmac']=$postmac;
			$postdata['usre_status']='0';
			$postdata['usre_isactive']='0';
			$postdata['usre_departmentid']=$depid;
			$postdata['usre_dashboard']=!empty($dasboardid)?$dasboardid:'0';
			$postdata['usre_locationid']=$locationid;
			$postdata['usre_signaturepath']=$this->signatureupload;
		// print_r($postdata);
		// die();

			$this->db->trans_start();
			if(!empty($postdata))
			{
				$this->db->insert($this->table,$postdata);
				$insertid=$this->db->insert_id();
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

	public function get_all_user_reg($srchcol=false)
	{
		$this->db->select('um.*,ug.usgr_usergroup,de.desi_designationname,dp.dept_depname,lo.loca_name');
		$this->db->from('usre_userregister um');
		$this->db->join('usgr_usergroup ug','ug.usgr_usergroupid=um.usre_usergroupid','LEFT');
		$this->db->join('desi_designation de','de.desi_designationid=um.usre_desiid','LEFT');
		$this->db->from('dept_department dp','dp.dept_depid=um.usre_departmentid','LEFT');
		$this->db->from('loca_location lo','lo.loca_locationid=um.usre_locationid','LEFT');
		
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
	
	public function get_all_user_reg_profile($srchcol=false)
	{
		$this->db->select('um.*,ug.usgr_usergroup,dp.*');
		$this->db->from('usre_userregister um');

		$this->db->join('usgr_usergroup ug','ug.usgr_usergroupid=um.usre_usergroupid','LEFT');
		$this->db->from('dept_department dp','dp.dept_depid=dp.usre_departmentid','LEFT');
		
		if($srchcol)
		{
			$this->db->where($srchcol);
		}
		$qry=$this->db->get();
				//echo $this->db->last_query(); die();
		if($qry->num_rows()>0)
		{
			return $qry->result();
			return false;
		}
	}

	public function get_userwise_dep($userid=false,$deparray=false)
	{
		$dep='';
		$this->db->select('dp.*');
		$this->db->from('dept_department dp');
		$this->db->where_in('dept_depid',$deparray);
		$qry=$this->db->get();
		if($qry->num_rows()>0)
		{
			$result=$qry->result();
			
			if($result)
			{
				foreach ($result as $rs => $val) {
					$dep.=$val->dept_depname;	
				}
				return $dep;
			}
			return false;
			
		}
		return false;
	}


	public function get_userwise_group($userid=false,$type=false)
	{
		$dep='';
		$this->db->select('ug.*,g.*');
		$this->db->from('uwgr_userwisegroup ug');
		$this->db->join('usgr_usergroup g','g.usgr_usergroupid=ug.uwgr_groupid','left');
		$this->db->where(array('ug.uwgr_userid'=>$userid,'ug.uwgr_status'=>'1'));
		$qry=$this->db->get();
		if($qry->num_rows()>0)
		{
			$result=$qry->result();
			if($type=='V')
			{
				if($result)
				{
					foreach ($result as $rs => $val) {
						$dep.=$val->usgr_usergroup.' | ';	
					}
					return $dep;
				}
			}
			return $result;
			
		}
		return false;
	}



	



	public function check_exit_username_for_other($usre_username,$input_id)
	{
		
		$data = array();

		if($input_id)
		{
			$query = $this->db->get_where($this->table,array('usre_username'=>$usre_username,'usre_userid !='=>$input_id));
		}
		else
		{
			$query = $this->db->get_where($this->table,array('usre_username'=>$usre_username));
		}
		if ($query->num_rows() > 0) 
		{
			$data=$query->row();	
			return $data;			
		}
		return false;
	}



	public function upload_signature(){
		$image1_name = $this->file_settings_do_upload('usre_signaturepath',SIGNATURE_UPLOAD_PATH);
	    // print_r($image1_name);
	    // die();
		echo $this->session->userdata('upload_error');
		if($image1_name!==false)
		{
			$this->signatureupload = $image1_name['file_name'];
			return FALSE;
		}

		return TRUE;
	}

	public function file_settings_do_upload($file,$path){
	    $config['upload_path'] = './'.$path;//define in constants
	    $config['allowed_types'] = 'gif|jpg|png|docx|pdf|bmp|doc|xls|xlsx';
	    $config['remove_spaces'] = TRUE;  
	    //$config['overwrite'] = TRUE;  
	    $config['encrypt_name'] = TRUE;
	    $config['max_size'] = '5000';
	    $config['max_width'] = '5000';
	    $config['max_height'] = '5000';
	    $this->upload->initialize($config);
	    // print_r($_FILES);
	    // die();

	    $this->upload->do_upload($file);
	    if($this->upload->display_errors()){
	    	$this->error_img=$this->upload->display_errors();
    		// $this->error_img;
	    	if($file=='usre_signaturepath'){
	    		$this->session->set_userdata('upload_error',$this->error_img);
	    	}
	    	return false;
	    }
	    else
	    {	    
	    	$data = $this->upload->data();
	    	return $data;
	    }     
	}

	public function get_user_register_list()
	{
		$get = $_GET;

		foreach ($get as $key => $value) {
			$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
		}
		if(!empty($get['sSearch_0'])){
			$this->db->where("usre_userid like  '%".$get['sSearch_0']."%'  ");
		}

		if(!empty($get['sSearch_1'])){
			$this->db->where("usre_username like  '%".$get['sSearch_1']."%'  ");
		}
		if(!empty($get['sSearch_2'])){
			$this->db->where("usre_fullname like  '%".$get['sSearch_2']."%'  ");
		}

		if(!empty($get['sSearch_3'])){
			$this->db->where("dept_depname like  '%".$get['sSearch_3']."%'  ");
		}
		if(!empty($get['sSearch_4'])){
			$this->db->where("usre_phoneno like  '%".$get['sSearch_4']."%'  ");
		}
		if(!empty($get['sSearch_5'])){
			$this->db->where("usre_postdatebs like  '%".$get['sSearch_5']."%'  ");
		}
		if(!empty($get['sSearch_6'])){
			$this->db->where("usre_postdatead like  '%".$get['sSearch_6']."%'  ");
		}
		$frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');
		$toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');
		$apptype = !empty($get['apptype'])?$get['apptype']:$this->input->post('apptype');
		$input_locationid= !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');
		$departmentid= !empty($get['departmentid'])?$get['departmentid']:$this->input->post('departmentid');

	$color_codeclass=$this->getColorStatusCount();
      foreach ($color_codeclass as $key => $color) {
		if($apptype==$color->coco_statusname)
		 {
			 $approved=$color->coco_statusval;
		   }
         }


		// if($apptype=='pending')
		// {
		// 	$approved=0;
		// }
		// if($apptype=='approved')
		// {
		// 	$approved=1;
		// }
		// if($apptype=='cancel')
		// {
		// 	$approved=2;
		// }
		// if($apptype=='cntissue')
		// {
		// 	$approved='';
		// }

		if(!empty(($frmDate && $toDate)))
		{
			if(DEFAULT_DATEPICKER == 'NP'){
				$this->db->where('um.usre_postdatebs >=',$frmDate);
				$this->db->where('um.usre_postdatebs <=',$toDate);    
			}else{
				$this->db->where('um.usre_postdatead >=',$frmDate);
				$this->db->where('um.usre_postdatead <=',$toDate);
			}
		}
		

		 if($this->location_ismain=='Y')
        {
            if($input_locationid)
            {
                $this->db->where('um.usre_locationid',$input_locationid);
            }
        }
        else
        {
             $this->db->where('um.usre_locationid',$this->locationid);
        }
        if(!empty($departmentid))
         {
            $this->db->where('um.usre_departmentid',"$departmentid");
         }

        if($apptype!="cntissue"){
        if(!empty($apptype))
         {
            $this->db->where('um.usre_status',"$approved");
         }
        }



		$resltrpt=$this->db->select("COUNT(*) as cnt")
		->from('usre_userregister um')
		->join('usgr_usergroup ug','ug.usgr_usergroupid=um.usre_usergroupid','LEFT')
		->join('dept_department dp','dp.dept_depid=um.usre_departmentid','LEFT')
		 // ->where(array('um.usre_isactive'=>'1'))
		->get()
		->row(); 
      	// echo $this->db->last_query();die(); 
		$totalfilteredrecs=$resltrpt->cnt; 

		$order_by = 'usre_userid';
		$order = 'desc';
		if($this->input->get('sSortDir_0'))
		{
			$order = $this->input->get('sSortDir_0');
		}

		$where='';
		if($this->input->get('iSortCol_0')==0)
			$order_by = 'usre_userid';
		else if($this->input->get('iSortCol_0')==1)
			$order_by = 'usre_username';
		else if($this->input->get('iSortCol_0')==2)
			$order_by = 'usre_fullname';
		else if($this->input->get('iSortCol_0')==3)
			$order_by = 'dept_depname';
		else if($this->input->get('iSortCol_0')==4)
			$order_by = 'usre_phoneno';
		else if($this->input->get('iSortCol_0')==5)
			$order_by = 'usre_postdatebs';
		else if($this->input->get('iSortCol_0')==6)
			$order_by = 'usre_postdatead';

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
			$this->db->where("usre_username like  '%".$get['sSearch_1']."%'  ");
		}
		if(!empty($get['sSearch_2'])){
			$this->db->where("usre_fullname like  '%".$get['sSearch_2']."%'  ");
		}

		if(!empty($get['sSearch_3'])){
			$this->db->where("dept_depname like  '%".$get['sSearch_3']."%'  ");
		}
		if(!empty($get['sSearch_4'])){
			$this->db->where("usre_phoneno like  '%".$get['sSearch_4']."%'  ");
		}
		if(!empty($get['sSearch_5'])){
			$this->db->where("usre_postdatebs like  '%".$get['sSearch_5']."%'  ");
		}
		if(!empty($get['sSearch_6'])){
			$this->db->where("usre_postdatead like  '%".$get['sSearch_6']."%'  ");
		}
		$frmDate = !empty($get['frmDate'])?$get['frmDate']:$this->input->post('frmDate');
		$toDate = !empty($get['toDate'])?$get['toDate']:$this->input->post('toDate');
		$apptype = !empty($get['apptype'])?$get['apptype']:$this->input->post('apptype');
		$input_locationid= !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');
		$departmentid= !empty($get['departmentid'])?$get['departmentid']:$this->input->post('departmentid');
		
$color_codeclass=$this->getColorStatusCount();
      foreach ($color_codeclass as $key => $color) {
		if($apptype==$color->coco_statusname)
		 {
			 $approved=$color->coco_statusval;
		   }
         }

		// if($apptype=='pending')
		// {
		// 	$approved=0;
		// }
		// if($apptype=='approved')
		// {
		// 	$approved=1;
		// }
		// if($apptype=='cancel')
		// {
		// 	$approved=2;
		// }

		// if($apptype=='cntissue')
		// {
		// 	$approved='';
		// }
		if(!empty(($frmDate && $toDate)))
		{
			if(DEFAULT_DATEPICKER == 'NP'){
				$this->db->where('um.usre_postdatebs >=',$frmDate);
				$this->db->where('um.usre_postdatebs <=',$toDate);    
			}else{
				$this->db->where('um.usre_postdatead >=',$frmDate);
				$this->db->where('um.usre_postdatead <=',$toDate);
			}
		}

		if($apptype!="cntissue"){
        if(!empty($apptype))
         {
            $this->db->where('um.usre_status',"$approved");
         }
        }

		$this->db->select('um.*,ug.usgr_usergroup,dp.*');
		$this->db->from('usre_userregister um');

		$this->db->join('usgr_usergroup ug','ug.usgr_usergroupid=um.usre_usergroupid','LEFT');
		$this->db->join('dept_department dp','dp.dept_depid=um.usre_departmentid','LEFT');

        // $this->db->where(array('um.usre_isactive'=>'1'));
		$this->db->order_by('usre_isactive','desc');

	if($this->location_ismain=='Y')
        {
            if($input_locationid)
            {
                $this->db->where('um.usre_locationid',$input_locationid);
            }
        }
        else
        {
             $this->db->where('um.usre_locationid',$this->locationid);
        }

		
		
		
        if(!empty($departmentid))
         {
            $this->db->where('um.usre_departmentid',"$departmentid");
         }


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
		if(!empty($_GET['iDisplayLength']) && is_array($nquery)) {
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
	
	public function status_change_user_register($status =false,$userid=false)
	{   
		$this->userid = $this->session->userdata(USER_ID);
		$this->username = $this->session->userdata(USER_NAME);
    // echo  $status;die;
		$userid = $this->input->post('userid');
		$groupid = $this->input->post('usre_usergroupid');
		$desigid=$this->input->post('usre_appdesiid');

		if(!empty($desigid))
		{
			$usre_appdesiid=implode(',', $desigid);   
		}else{
			$usre_appdesiid='';
		}

		if(defined('APPROVEBY_TYPE')):
			if(APPROVEBY_TYPE == 'USER'){
				$approved_id = $this->userid;
				$approved_by = $this->username;
			}else{
				$approved_id = (defined('APPROVER_USERID'))?APPROVER_USERID:'';
				$approved_by = (defined('APPROVER_USERNAME'))?APPROVER_USERNAME:'';
			}
		endif;

		$postdata = array(
			'usre_usergroupid'=>$groupid,
			'usre_status'=>$status,
			'usre_modifydatead'=>CURDATE_EN,
			'usre_modifydatebs'=> CURDATE_NP,
			'usre_modifytime'=>date('H:i:s'),
			'usre_modifymac'=>$this->general->get_real_ipaddr(),
			'usre_modifyip'=>$this->general->get_Mac_Address(),
			'usre_approvedby'=> $approved_by,
			'usre_approvedid' => $approved_id,
			'usre_appdesiid'=>$usre_appdesiid,
			'usre_approvedatead'=>CURDATE_EN,
			'usre_approvedatebs'=>CURDATE_NP,
			'usre_regesterdatead'=>CURDATE_EN,
			'usre_regesterdatebs'=>CURDATE_NP,
			'usre_approvetime'=>date('H:i:s')
		);


     //echo"<pre>";print_r($postdata);die;
		$this->db->update('usre_userregister',$postdata,array('usre_userid'=>$userid));
        //echo  $this->db->last_query();die;
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
	public function status_change_userstatus($id=false,$status=false)
	{
		$this->userid = $this->session->userdata(USER_ID);  
		if($status==true){
			$ischeck=0;
		}
		$postdata = array(
			'usre_isactive'=>$ischeck,
			'usre_modifydatead'=>CURDATE_EN,
			'usre_modifydatebs'=> CURDATE_NP,
			'usre_modifytime'=>date('H:i:s'),
			'usre_modifymac'=>$this->general->get_real_ipaddr(),
			'usre_modifyip'=>$this->general->get_Mac_Address(),
			'usre_inactivedatebs'=>CURDATE_NP,
			'usre_inactivedatead'=>CURDATE_EN
		);
		$this->db->update('usre_userregister',$postdata,array('usre_userid'=>$id));
   //echo  $this->db->last_query();die;
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

	public function get_all_group_reg($srchcol=false)
	{
		$this->db->select('ug.*,lo.*');
		$this->db->from('usgr_usergroup ug');
		$this->db->join('loca_location lo','lo.loca_locationid=ug.usgr_locationid','LEFT');

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

	// public function getStatusCount($srchcol = false){
	// 	try{
	// 		$this->db->select("
	// 			SUM(CASE WHEN usre_status='0' THEN 1 ELSE 0 END ) pending, 
	// 			SUM(CASE WHEN usre_status='1' THEN 1 ELSE 0 END ) approved, 
	// 			SUM(CASE WHEN usre_status='2' THEN 1 ELSE 0 END ) cancel,
	// 			");
	// 		$this->db->from('usre_userregister');

	// 		if($srchcol){
	// 			$this->db->where($srchcol);
	// 		}

	// 		$query = $this->db->get();
 //           // echo $this->db->last_query();
 //           //  die;

	// 		if($query->num_rows() > 0){
	// 			return $query->result();
	// 		}
	// 		return false;
	// 	}catch(Exception $e){
	// 		throw $e;
	// 	}
	// }
	public function getStatusCount($srchcol = false){
		try{
			$this->db->select("
				coco_statusval,coco_statusname,SUM(CASE WHEN(ur.usre_status= cc.coco_statusval) THEN 1 ELSE 0 END) countstatus");
			$this->db->from('xw_coco_colorcode cc');
			$this->db->join('xw_usre_userregister ur','ur.usre_status = cc.coco_statusval','LEFT');

			if($srchcol){
				$this->db->where($srchcol);
			}
		
			$this->db->group_by(['coco_statusval','coco_statusname']);

			$query = $this->db->get();
           // echo $this->db->last_query();
           //  die;

			if($query->num_rows() > 0){
				return $query->result();
			}
			return false;
		}catch(Exception $e){
			throw $e;
		}
	}




	

	 public function getRemCount($srchcol = false){
        try{
            $this->db->select("COUNT('*') as cntissue");
            $this->db->from('usre_userregister');
            
           
            if($srchcol){
                $this->db->where($srchcol);
            }

            $query = $this->db->get();

            if($query->num_rows() > 0){
                return $query->result();
            }
            return false;
        }catch(Exception $e){
            throw $e;
        }
    }
 public function getColorStatusCount($srchcol = false){
     if($srchcol){
         $con1= $srchcol;
     }
     else{
         $con1='';
     }


$sql="SELECT * FROM
     xw_coco_colorcode cc
    LEFT JOIN (
     SELECT
         usre_status,
         COUNT('*') AS statuscount
     FROM
         xw_usre_userregister ur
     ".$con1."
     GROUP BY
         usre_status
    ) X ON X.usre_status = cc.coco_statusval
    WHERE
     cc.coco_listname = 'user_registerlist'
    AND cc.coco_statusval <> ''
    AND cc.coco_isactive = 'Y'";
            
         $query = $this->db->query($sql);
         // echo $this->db->last_query();
         // die();
         return $query->result();
        
 }


}