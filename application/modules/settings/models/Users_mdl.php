<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users_mdl extends CI_Model 
{

	public function __construct() {
		parent::__construct();
		$this->table='usma_usermain';
		$this->load->library('upload');
		$this->locationid=$this->session->userdata(LOCATION_ID);
		$this->location_ismain=$this->session->userdata(ISMAIN_LOCATION);
		$this->orgid=$this->session->userdata(ORG_ID);
	}

	public $validate_settings_users = array(               

		array('field' => 'usma_username', 'label' => 'UsersName', 'rules' => 'trim|required|xss_clean|is_unique[usma_usermain.usma_username]'),
		array('field' => 'usma_userpassword', 'label' => 'Password', 'rules' => 'trim|required|xss_clean|matches[usma_conformpassword]'),
		array('field' => 'usma_conformpassword', 'label' => 'Conform Password', 'rules' => 'trim|xss_clean'),
        // array('field' => 'usma_departmentid[]', 'label' => 'Department', 'rules' => 'trim|required|xss_clean'),
		array('field' => 'usma_usergroupid', 'label' => 'Group', 'rules' => 'trim|required|xss_clean'),
	);

	public $validate_settings_users_edit = array(               

		array('field' => 'usma_username', 'label' => 'UsersName', 'rules' => 'trim|required|xss_clean|callback_exists_username'),

	);

	public $validate_settings_users_approved = array(               

		array('field' => 'usre_username', 'label' => 'Approved', 'rules' => 'trim|required|xss_clean|callback_exists_username'),

	);

	public function users_save(){

		$postdata=$this->input->post();

		$id=$this->input->post('id');

		$locationid=$this->input->post('usma_locationid');

		// $locationid=$this->session->userdata(LOCATION_ID);

		$depname=$this->input->post('usma_departmentid');

		// echo "<pre>";

		// print_r($dashboard);

		// die();

		$depid='';

		if(!empty($depname))

		{

			$depid=implode(',', $depname);   

		}

		$desigid=$this->input->post('usma_appdesiid');

		if(!empty($desigid))

		{

			$appdesiid=implode(',', $desigid);   

		}else{

			$appdesiid='';   

		}

		// echo $depid;

		// die();

		unset($postdata['usma_departmentid']);

		// echo $id;

		// die();

		$salt = $this->general->salt();		

		// echo $salt;

		// die();

		$conpassword=$this->input->post('usma_conformpassword');

		$password=$this->general->hash_password($conpassword,$salt);

		$postid=$this->general->get_real_ipaddr();

		$postmac=$this->general->get_Mac_Address();

		$staffdepid=$this->input->post('usma_departmentid');

		$groupid=$this->input->post('usma_usergroupid');

		$old_signaturepath = $this->input->post('usma_oldsignaturepath');

		unset($postdata['usma_oldsignaturepath']);

		unset($postdata['id']);

		unset($postdata['usma_userpassword']);

		unset($postdata['usma_conformpassword']);

		if($id)

		{

			$this->db->trans_start();

			$postdata['usma_modifydatead']=CURDATE_EN;

			$postdata['usma_modifydatebs']=CURDATE_NP;

			$postdata['usma_modifytime']=date('H:i:s');

			$postdata['usma_modifyby']=$this->session->userdata(USER_ID);

			$postdata['usma_modifyip']=$postid;

			$postdata['usma_modifymac']=$postmac;

			$postdata['usma_departmentid']=$depid;

			$postdata['usma_appdesiid']=$appdesiid;

			$postdata['usma_signaturepath']=!empty($this->signatureupload)?$this->signatureupload:$old_signaturepath;

			if(!empty($postdata))

			{

				$this->general->save_log($this->table,'usma_userid',$id,$postdata,'Update');

				$this->db->update($this->table,$postdata,array('usma_userid'=>$id));

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

			$postdata['usma_salt']=$salt;

			$postdata['usma_userpassword']=$password;

			$postdata['usma_postdatead']=CURDATE_EN;

			$postdata['usma_postdatebs']=CURDATE_NP;

			$postdata['usma_posttime']=date('H:i:s');

			$postdata['usma_orgid']=$this->session->userdata(ORG_ID);

			$postdata['usma_postby']=$this->session->userdata(USER_ID);

			$postdata['usma_postip']=$postid;

			$postdata['usma_postmac']=$postmac;

			$postdata['usma_status']='1';

			$postdata['usma_departmentid']=$depid;

			$postdata['usma_appdesiid']=$appdesiid;

			$postdata['usma_locationid']=$locationid;

			$postdata['usma_signaturepath']=$this->signatureupload;

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

	public function get_all_users($srchcol=false) {

		$this->db->select('um.*,ug.usgr_usergroup,de.desi_designationname');
		$this->db->from('usma_usermain um');
		$this->db->join('usgr_usergroup ug','ug.usgr_usergroupid=um.usma_usergroupid','LEFT');
		$this->db->join('desi_designation de','de.desi_designationid=um.usma_desiid','LEFT');

		if($srchcol)

		{

			$this->db->where($srchcol);

		}

		$query = $this->db->get();

		if ($query->num_rows() > 0) 

		{

			$data=$query->result();		

			return $data;		

		}		

		return false;

	}

	public function get_all_users_profile($srchcol=false)

	{

		$this->db->select('um.*,ug.usgr_usergroup,dp.*');

		$this->db->from('usma_usermain um');

		$this->db->join('usgr_usergroup ug','ug.usgr_usergroupid=um.usma_usergroupid','LEFT');

		$this->db->from('dept_department dp','dp.dept_depid=dp.usma_departmentid','LEFT');

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

					$dep.=$val->dept_depname.' | ';	

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

	public function remove_users()

	{

		$id=$this->input->post('id');

		if($id)

		{

			$this->general->save_log($this->table,'usma_userid',$id,$postdata=array(),'Delete');

			$this->db->delete($this->table,array('usma_userid'=>$id));

			$rowaffected=$this->db->affected_rows();

			if($rowaffected)

			{

				return $rowaffected;

			}

			return false;

		}

		return false;

	}

	public function check_exit_username_for_other($usma_username,$input_id)

	{

		$data = array();

		if($input_id)

		{

			$query = $this->db->get_where($this->table,array('usma_username'=>$usma_username,'usma_userid !='=>$input_id));

		}

		else

		{

			$query = $this->db->get_where($this->table,array('usma_username'=>$usma_username));

		}

		if ($query->num_rows() > 0) 

		{

			$data=$query->row();	

			return $data;			

		}

		return false;

	}

	public function change_user_password()

	{

    	// $password=$this->input->post('password');

		$password  = $this->input->post('password');

		$userid=$this->input->post('userid');

		// Create a random salt

		$salt = $this->general->salt();		

		$password = $this->general->hash_password($password, $salt);

		$data = array(

			'usma_userpassword' => $password,

			'usma_salt' => $salt,

			'usma_modifydatead'=>CURDATE_EN,

			'usma_modifydatebs'=>CURDATE_NP,

			'usma_modifytime'=>$this->general->get_currenttime(),

			'usma_modifyby'=>$this->session->userdata(USER_ID)

		);

		$this->db->update('usma_usermain', $data,array('usma_userid' => $userid));

       	 // echo $this->db->last_query(); 

       	 // die();

		$rwaff= $this->db->affected_rows();

		if($rwaff)

		{

			return $rwaff;

		}

		return false;

	}

	public function upload_signature(){

		$image1_name = $this->file_settings_do_upload('usma_signaturepath',SIGNATURE_UPLOAD_PATH);

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

	    	if($file=='usma_signaturepath'){

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

	 public function get_all_user_list()

	 {

	 	$get = $_GET;

	 	foreach ($get as $key => $value) {

	 		$get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));

	 	}

	 	if(!empty($get['sSearch_0'])){

	 		$this->db->where("lower(usma_userid) like  '%".$get['sSearch_0']."%'  ");

	 	}

	 	if(!empty($get['sSearch_1'])){

	 		$this->db->where("lower(usma_username) like  '%".$get['sSearch_1']."%'  ");

	 	}

	 	if(!empty($get['sSearch_2'])){

	 		$this->db->where("lower(usma_fullname) like  '%".$get['sSearch_2']."%'  ");

	 	}

	 	if(!empty($get['sSearch_3'])){

	 		$this->db->where("lower(dept_depname) like  '%".$get['sSearch_3']."%'  ");

	 	}

	 	if(!empty($get['sSearch_4'])){

	 		$this->db->where("lower(usgr_usergroup) like  '%".$get['sSearch_4']."%'  ");

	 	}

	 	if(!empty($get['sSearch_5'])){

	 		$this->db->where("lower(usma_postdatebs) like  '%".$get['sSearch_5']."%'  ");

	 	}

	 	if(!empty($get['sSearch_6'])){

	 		$this->db->where("lower(usma_postdatead) like  '%".$get['sSearch_6']."%'  ");

	 	}

	 	$groupid = !empty($get['groupid'])?$get['groupid']:$this->input->post('groupid');

	 	$input_locationid= !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');

	 	$departmentid= !empty($get['departmentid'])?$get['departmentid']:$this->input->post('departmentid');

	 	if($this->location_ismain=='Y')

	 	{

	 		if($input_locationid)
	 		{
	 			$this->db->where('um.usma_locationid',$input_locationid);

	 		}

	 	}

	 	else

	 	{

	 		$this->db->where('um.usma_locationid',$this->locationid);

	 	}

	 	if(!empty($departmentid))

	 	{

	 		$this->db->where('um.usma_departmentid',"$departmentid");

	 	}

	 	if(!empty($groupid))

	 	{

	 		$this->db->where('um.usma_usergroupid',"$groupid");

	 	}
	 	$this->db->where('um.usma_orgid',$this->orgid);

	 	$resltrpt=$this->db->select("COUNT(*) as cnt")

	 	->from('usma_usermain um')

	 	->join('usgr_usergroup ug','ug.usgr_usergroupid=um.usma_usergroupid','LEFT')

	 	->join('dept_department dp','dp.dept_depid=um.usma_departmentid','LEFT')

		 // ->where(array('um.usma_isactive'=>'1'))

	 	->get()

	 	->row(); 

      	 // echo $this->db->last_query();die(); 

	 	$totalfilteredrecs=$resltrpt->cnt; 

	 	$order_by = 'usma_userid';

	 	$order = 'desc';

	 	if($this->input->get('sSortDir_0'))

	 	{

	 		$order = $this->input->get('sSortDir_0');

	 	}

	 	$where='';

	 	if($this->input->get('iSortCol_0')==0)

	 		$order_by = 'usma_userid';

	 	else if($this->input->get('iSortCol_0')==1)

	 		$order_by = 'usma_username';

	 	else if($this->input->get('iSortCol_0')==2)

	 		$order_by = 'usma_fullname';

	 	else if($this->input->get('iSortCol_0')==3)

	 		$order_by = 'dept_depname';

	 	else if($this->input->get('iSortCol_0')==4)

	 		$order_by = 'usgr_usergroup';

	 	else if($this->input->get('iSortCol_0')==5)

	 		$order_by = 'usma_postdatebs';

	 	else if($this->input->get('iSortCol_0')==6)

	 		$order_by = 'usma_postdatead';

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

	 	if(!empty($get['sSearch_1'])){

	 		$this->db->where("lower(usma_username) like  '%".$get['sSearch_1']."%'  ");

	 	}

	 	if(!empty($get['sSearch_2'])){

	 		$this->db->where("lower(usma_fullname) like  '%".$get['sSearch_2']."%'  ");

	 	}

	 	if(!empty($get['sSearch_3'])){

	 		$this->db->where("lower(dept_depname) like  '%".$get['sSearch_3']."%'  ");

	 	}

	 	if(!empty($get['sSearch_4'])){

	 		$this->db->where("lower(usgr_usergroup) like  '%".$get['sSearch_4']."%'  ");

	 	}

	 	if(!empty($get['sSearch_5'])){

	 		$this->db->where("lower(usma_postdatebs) like  '%".$get['sSearch_5']."%'  ");

	 	}

	 	if(!empty($get['sSearch_6'])){

	 		$this->db->where("lower(usma_postdatead) like  '%".$get['sSearch_6']."%'  ");

	 	}

	 	$groupid = !empty($get['groupid'])?$get['groupid']:$this->input->post('groupid');

	 	$input_locationid= !empty($get['locationid'])?$get['locationid']:$this->input->post('locationid');

	 	$departmentid= !empty($get['departmentid'])?$get['departmentid']:$this->input->post('departmentid');

	 	$this->db->select('um.*,ug.*,dp.*');

	 	$this->db->from('usma_usermain um');

	 	$this->db->join('usgr_usergroup ug','ug.usgr_usergroupid=um.usma_usergroupid','LEFT');

	 	$this->db->join('dept_department dp','dp.dept_depid=um.usma_departmentid','LEFT');

	 	if($this->location_ismain=='Y')

	 	{

	 		if($input_locationid)

	 		{

	 			$this->db->where('um.usma_locationid',$input_locationid);

	 		}

	 	}

	 	else

	 	{

	 		$this->db->where('um.usma_locationid',$this->locationid);

	 	}

	 	if(!empty($departmentid))

	 	{

	 		$this->db->where('um.usma_departmentid',"$departmentid");

	 	}

	 	if(!empty($groupid))

	 	{

	 		$this->db->where('um.usma_usergroupid',"$groupid");

	 	}

	 	$this->db->where('um.usma_orgid',$this->orgid);

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

		// if(!empty($_GET['iDisplayLength'])) {

		// 	$totalrecs = sizeof( $nquery);

		// }

	 	if (!empty($_GET['iDisplayLength']) &&  !empty($resltrpt) && is_array($resltrpt) && sizeof($resltrpt) > 0 ) {

	 		$totalfilteredrecs = sizeof($resltrpt);

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