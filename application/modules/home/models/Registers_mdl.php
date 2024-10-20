<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Registers_mdl extends CI_Model 
{
	
	public $validate_settings_user_reg = array(               
		array('field' => 'usre_username', 'label' => 'UsersName', 'rules' => 'trim|required|xss_clean|is_unique[usre_userregister.usre_username]'),
		array('field' => 'usre_userpassword', 'label' => 'Password', 'rules' => 'trim|required|xss_clean'),

		
	);
	
	
	public function user_reg_save()
	{ 
	 
		$postdata=$this->input->post();
		$id=$this->input->post('id');
		$locationid=$this->input->post('usre_locationid');
		// $locationid=$this->session->userdata(LOCATION_ID);
		$depname=$this->input->post('usre_departmentid');
		$dashboard=$this->input->post('dashboard');

		
		$depid='';
		if(!empty($depname))
		{
			$depid=implode(',', $depname);   
		}

		if(!empty($dashboard))
		{
			$dasboardid=implode(',', $dashboard);   
		}
		unset($postdata['usre_departmentid']);
		unset($postdata['dashboard']);
		$salt = $this->general->salt();		
		// echo $salt;
		// die();
		$password=$this->input->post('usre_userpassword');
		
		$postid=$this->general->get_real_ipaddr();
		$postmac=$this->general->get_Mac_Address();
		$staffdepid=$this->input->post('usre_departmentid');
		$groupid=$this->input->post('usre_usergroupid');

		// $old_signaturepath = $this->input->post('usre_oldsignaturepath');
		
		// unset($postdata['usre_oldsignaturepath']);
		unset($postdata['id']);
		unset($postdata['usre_userpassword']);
		// unset($postdata['usre_conformpassword']);
		if($id)
		{
			$this->db->trans_start();
			$postdata['usre_modifydatead']=CURDATE_EN;
			$postdata['usre_modifydatebs']=CURDATE_NP;
			$postdata['usre_modifytime']=date('H:i:s');
			// $postdata['usre_modifyby']=$this->session->userdata(USER_ID);
			$postdata['usre_modifyip']=$postid;
			$postdata['usre_modifymac']=$postmac;
			$postdata['usre_departmentid']=$depid;
			$postdata['usre_dashboard']=$dasboardid;
			// $postdata['usre_signaturepath']=!empty($this->signatureupload)?$this->signatureupload:$old_signaturepath;

			if(!empty($postdata))
			{
				$this->db->update('usre_userregister',$postdata,array('usre_userid'=>$id));
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
			// $postdata['usre_orgid']=$this->session->userdata(ORG_ID);
			// $postdata['usre_postby']=$this->session->userdata(USER_ID);
			$postdata['usre_postip']=$postid;
			$postdata['usre_postmac']=$postmac;
			$postdata['usre_status']='0';
			$postdata['usre_departmentid']=$depid;
			$postdata['usre_dashboard']=!empty($dasboardid)?$dasboardid:'0';
			$postdata['usre_locationid']=$locationid;
			// $postdata['usre_signaturepath']=$this->signatureupload;
		// print_r($postdata);
		// die();

			$this->db->trans_start();
			if(!empty($postdata))
			{
				$this->db->insert('usre_userregister',$postdata);
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

	public function check_exit_username_for_other($usre_username,$input_id)
	{ 
		
		$data = array();

		if($input_id)
		{
			$query = $this->db->get_where("usre_userregiser",array('usre_username'=>$usre_username,'usre_userid !='=>$input_id));
		}
		else
		{
			$query = $this->db->get_where("usre_userregiser",array('usre_username'=>$usre_username));
		}
		if ($query->num_rows() > 0) 
		{
			$data=$query->row();	
			return $data;			
		}
		return false;
	}

	public function get_all_department_reg($srchcol=false,$limit=false,$offset=false,$order_by=false,$order='ASC')
	{
		$this->db->select('dp.*,lo.*');
		$this->db->from('dept_department dp');
		$this->db->join('loca_location lo','lo.loca_locationid=dp.dept_locationid','LEFT');
		 
		
	          
		if($srchcol)
		{
			$this->db->where($srchcol);
		}
		if($limit && $limit>0)
	      {
	        $this->db->limit($limit);
	      }
	      if($offset)
	      {
	        $this->db->offset($offset);
	      }

	      if($order_by)
	      {
	        $this->db->order_by($order_by,$order);
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




	

}